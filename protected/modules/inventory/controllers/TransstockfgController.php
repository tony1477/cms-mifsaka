<?php

class TransstockfgController extends AdminController
{
	protected $menuname = 'transstockfg';
	public $module = 'Inventory';
	protected $pageTitle = 'Transfer FG OP';
	public $wfname = 'appts';
	protected $sqldata = "SELECT t.transstockid,t.transstockno,t.docdate,t.productoutputid,t.slocfromid,t.sloctoid,t.slocfromcode,t.sloctocode,t.productoutputno,t.headernote,t.statusname,t.recordstatus 
			FROM transstock t ";
    
protected $sqldatatransstockdet = "SELECT t.*,a.productname,c.uomcode,
    (select distinct description from storagebin z where z.storagebinid = t.storagebinid) as rakasal,
	(select distinct description from storagebin z where z.storagebinid = t.storagebintoid) as raktujuan,
	(select sum(qty) from productstock z where z.productid = t.productid and z.unitofmeasureid = t.unitofmeasureid 
	and z.slocid = d.slocfromid and qty = (select max(zz.qty) from productstock zz where zz.productid = t.productid and zz.unitofmeasureid = t.unitofmeasureid 
	and zz.slocid = d.slocfromid and zz.storagebinid = t.storagebinid)) as stok
    FROM `transstockdet` `t`
    LEFT JOIN `product` `a` ON a.productid = t.productid
    LEFT JOIN `unitofmeasure` `c` ON c.unitofmeasureid = t.unitofmeasureid
    LEFT JOIN `transstock` `d` ON d.transstockid = t.transstockid ";
    
  protected $sqlcount = "select count(1) as total 
    from transstock t
  ";
protected $sqlcounttransstockdet = "select count(1) 
    FROM `transstockdet` `t`
    LEFT JOIN `product` `a` ON a.productid = t.productid
    LEFT JOIN `unitofmeasure` `c` ON c.unitofmeasureid = t.unitofmeasureid
    LEFT JOIN `transstock` `d` ON d.transstockid = t.transstockid ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "WHERE 
                t.recordstatus in (".getUserRecordStatus('listts').")
				and t.deliveryadviceid is null 
                and t.slocfromid in (".getUserObjectValues('sloc').")";
        
		if ((isset($_REQUEST['transstockno'])) && (isset($_REQUEST['slocfromid'])) && (isset($_REQUEST['sloctoid'])) && (isset($_REQUEST['productoutputno'])))
		{				
			$where .=  " 
and t.transstockno like '%". $_REQUEST['transstockno']."%' 
and t.slocfromid like '%". $_REQUEST['slocfromcode']."%' 
and t.sloctoid like '%". $_REQUEST['sloctocode']."%' 
and a3.productoutputno like '%". $_REQUEST['productoutputno']."%'"; 
		}
		if (isset($_REQUEST['transstockid']))
			{
				if (($_REQUEST['transstockid'] !== '0') && ($_REQUEST['transstockid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where t.transstockid in (".$_REQUEST['transstockid'].")";
					}
					else
					{
						$where .= " and t.transstockid in (".$_REQUEST['transstockid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'transstockid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'transstockid','transstockno','productoutputid','slocfromid','sloctoid','docdate','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'transstockid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['transstockid']))
		{
			$this->sqlcounttransstockdet .= ' where t.transstockid = '.$_REQUEST['transstockid'];
			$this->sqldatatransstockdet .= ' where t.transstockid = '.$_REQUEST['transstockid'];
		}
		$counttransstockdet = Yii::app()->db->createCommand($this->sqlcounttransstockdet)->queryScalar();
$dataProvidertransstockdet=new CSqlDataProvider($this->sqldatatransstockdet,array(
					'totalItemCount'=>$counttransstockdet,
					'keyField'=>'transstockdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'transstockdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidertransstockdet'=>$dataProvidertransstockdet));
	}

    public function actionGeneratedetail(){
        parent::actionUpdate();
		if (isset($_POST['productoutputid']))
		{
			$id = $_POST['productoutputid'];
			$query = "SELECT a.productoutputid, a.companyid, b.productid, b.qtyoutput, b.uomid, b.slocid as slocfromid, a.description as headernote, c.sloccode as slocfromcode
                  FROM productoutput a
                  JOIN productoutputfg b ON a.productoutputid = b.productoutputid
                  JOIN sloc c ON c.slocid = b.slocid
                  WHERE a.productoutputid = ".$_POST['productoutputid']." LIMIT 1";
    
            $cmd = Yii::app()->db->createCommand($query)->queryRow();
            $slocfromid    = $cmd['slocfromid'];
            $slocfromcode    = $cmd['slocfromcode'];
            $header      = $cmd['headernote'];
            $connection  = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                $sql     = 'call GenerateTSFG(:vid, :vslocfrom, :vhid)';
                $command = $connection->createCommand($sql);
                $command->bindvalue(':vid', $_POST['productoutputid'], PDO::PARAM_INT);
                $command->bindvalue(':vslocfrom', $slocfromid, PDO::PARAM_INT);
                $command->bindvalue(':vhid', $_POST['transstockid'], PDO::PARAM_INT);
                $command->execute();
                $transaction->commit();
               
                  echo CJSON::encode(array(
                    'status' => 'success',
                    'slocfromid' => $slocfromid,
                    'slocfromcode' => $slocfromcode,
                    'headernote' => $header,
                  ));
                
            }
            catch (Exception $e) {
                $transaction->rollBack();
                GetMessage('failure', $e->getMessage());
            }
        }
		Yii::app()->end();
			
    }
    
    public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into transstock (recordstatus) values (".$this->findstatusbyuser('insts').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'transstockid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insts")
		));
	}
  public function actionCreatetransstockdet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.transstockid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'slocfromid'=>$model['slocfromid'],
                        'sloctoid'=>$model['sloctoid'],
                        'docdate'=>$model['docdate'],
                        'headernote'=>$model['headernote'],
                        'transstockid'=>$model['transstockid'],
                        'slocfromcode'=>$model['slocfromcode'],
                        'sloctocode'=>$model['sloctocode'],
                        'productoutputno'=>$model['productoutputno'],
                        'productoutputid'=>$model['productoutputid'],
					));
					Yii::app()->end();
				}
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
		}
	}

  public function actionUpdatetransstockdet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatatransstockdet.' where transstockdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'storagebinid'=>$model['storagebinid'],
          'storagebintoid'=>$model['storagebintoid'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'qty'=>$model['qty'],
          'itemtext'=>$model['itemtext'],
          'productname'=>$model['productname'],
          'rakasal'=>$model['rakasal'],
          'raktujuan'=>$model['raktujuan'],
          'uomcode'=>$model['uomcode'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('slocfromid','string','emptyslocfromid'),
      array('sloctoid','string','emptysloctoid'),
    ));
		if ($error == false)
		{
			$id = $_POST['transstockid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatetransstockfgop(:vid,:vslocfromid,:vsloctoid,:vdocdate,:vheadernote,:vproductoutputid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['transstockid'],PDO::PARAM_STR);
				$command->bindvalue(':vslocfromid',(($_POST['slocfromid']!=='')?$_POST['slocfromid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsloctoid',(($_POST['sloctoid']!=='')?$_POST['sloctoid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vheadernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
                $command->bindvalue(':vproductoutputid',(($_POST['productoutputid']!=='')?$_POST['productoutputid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
public function actionSavetransstockdet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('storagebinid','string','emptystoragebinid'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('storagebintoid','string','emptystoragebintoid'),
    ));
		if ($error == false)
		{
			$id = $_POST['transstockdetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update transstockdet 
			      set productid = :productid,storagebinid = :storagebinid,unitofmeasureid = :unitofmeasureid,qty = :qty,storagebintoid = :storagebintoid,itemtext = :itemtext 
			      where transstockdetid = :transstockdetid';
				}
				else
				{
					$sql = 'insert into transstockdet (productid,storagebinid,unitofmeasureid,qty,storagebintoid,itemtext) 
			      values (:productid,:storagebinid,:unitofmeasureid,:qty,:storagebintoid,:itemtext)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':transstockdetid',$_POST['transstockdetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebintoid',(($_POST['storagebintoid']!=='')?$_POST['storagebintoid']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemtext',(($_POST['itemtext']!=='')?$_POST['itemtext']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
	
public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call ApproveTSFG(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	
public function actionDelete()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Deletets(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from transstock where transstockid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			else
			{
				$this->getMessage('success','chooseone');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}public function actionPurgetransstockdet()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from transstockdet where transstockdetid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.*,getcompanysloc(slocfromid) as companyid,b.dano,
						(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = a.slocfromid) as fromsloc,
						(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = a.sloctoid) as tosloc
						from transstock a
						left join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid ";
		if ($_GET['transstockid'] !== '') 
		{
				$sql = $sql . "where a.transstockid in (".$_GET['transstockid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('transstock');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFontSize(8);      
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(40,$this->pdf->gety()+2,': '.$row['transstockno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(40,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(10,$this->pdf->gety()+10,'No Permintaan');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['dano']);
      $this->pdf->text(120,$this->pdf->gety()+2,'Gd Asal');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['fromsloc']);
      $this->pdf->text(120,$this->pdf->gety()+6,'Gd Tujuan');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['tosloc']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,
							(select description from storagebin z where z.storagebinid = a.storagebinid) as storagebinfrom,
							(select description from storagebin z where z.storagebinid = a.storagebintoid) as storagebinto
							from transstockdet a
							inner join product b on b.productid = a.productid
							inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							where transstockid = ".$row['transstockid']." group by b.productname order by transstockdetid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('L','L','R','C','L','L','L');
      $this->pdf->setwidths(array(10,85,25,20,25,25));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Rak Asal','Rak Tujuan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['storagebinfrom'],
				$row1['storagebinto']));
      }
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(30,160));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');	  
			$this->pdf->row(array('Keterangan',$row['headernote']));
			$this->pdf->checkNewPage(40);
			//$this->pdf->Image('images/ttdts.jpg',10,$this->pdf->gety()+5,190);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Dibuat oleh,');$this->pdf->text(50,$this->pdf->gety(),'Diserahkan oleh,');$this->pdf->text(120,$this->pdf->gety(),'Diketahui oleh,');$this->pdf->text(170,$this->pdf->gety(),'Diterima oleh,');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');

		}
    // me-render ke browser
    $this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('transstockid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('transstockno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('dano'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['transstockid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['transstockno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['dano'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}