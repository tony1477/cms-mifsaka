<?php

class TransstockinController extends AdminController
{
	protected $menuname = 'transstockin';
	public $module = 'Inventory';
	protected $pageTitle = 'Transfer Gudang Masuk';
	public $wfname = 'apptsin';
	protected $sqldata = "select a0.transstockid,a0.transstockno,a0.slocfromid,a0.sloctoid,a0.docdate,a0.headernote,a0.deliveryadviceid,a0.recordstatus,a1.sloccode as sloccode,a2.sloccode as sloccode,a3.dano as dano,a0.statusname  
    from transstock a0 
    left join sloc a1 on a1.slocid = a0.slocfromid
    left join sloc a2 on a2.slocid = a0.sloctoid
    left join deliveryadvice a3 on a3.deliveryadviceid = a0.deliveryadviceid
  ";
protected $sqldatatransstockdet = "select a0.transstockdetid,a0.transstockid,a0.productid,a0.storagebinid,a0.unitofmeasureid,a0.qty,a0.storagebintoid,a0.deliveryadvicedetailid,a0.itemtext,a1.productname as productname,a2.description as description,a3.uomcode as uomcode,a4.description as description 
    from transstockdet a0 
    left join product a1 on a1.productid = a0.productid
    left join storagebin a2 on a2.storagebinid = a0.storagebinid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a4 on a4.storagebinid = a0.storagebintoid
  ";
  protected $sqlcount = "select count(1) 
    from transstock a0 
    left join sloc a1 on a1.slocid = a0.slocfromid
    left join sloc a2 on a2.slocid = a0.sloctoid
    left join deliveryadvice a3 on a3.deliveryadviceid = a0.deliveryadviceid
  ";
protected $sqlcounttransstockdet = "select count(1) 
    from transstockdet a0 
    left join product a1 on a1.productid = a0.productid
    left join storagebin a2 on a2.storagebinid = a0.storagebinid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.unitofmeasureid
    left join storagebin a4 on a4.storagebinid = a0.storagebintoid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listtsin').") 
			and a0.recordstatus between 3 and 4
			and a0.sloctoid in (".getUserObjectValues('sloc').")";
		if ((isset($_REQUEST['transstockno'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['dano'])))
		{				
			$where .=  " 
and a0.transstockno like '%". $_REQUEST['transstockno']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.dano like '%". $_REQUEST['dano']."%'"; 
		}
		if (isset($_REQUEST['transstockid']))
			{
				if (($_REQUEST['transstockid'] !== '0') && ($_REQUEST['transstockid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.transstockid in (".$_REQUEST['transstockid'].")";
					}
					else
					{
						$where .= " and a0.transstockid in (".$_REQUEST['transstockid'].")";
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
					 'transstockid','transstockno','slocfromid','sloctoid','docdate','headernote','deliveryadviceid','recordstatus'
				),
				'defaultOrder' => array( 
					'transstockid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['transstockid']))
		{
			$this->sqlcounttransstockdet .= ' where a0.transstockid = '.$_REQUEST['transstockid'];
			$this->sqldatatransstockdet .= ' where a0.transstockid = '.$_REQUEST['transstockid'];
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

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into transstock (recordstatus) values (".$this->findstatusbyuser('').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'transstockid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("")
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.transstockid = '.$id)->queryRow();
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
          'deliveryadviceid'=>$model['deliveryadviceid'],
          'sloccode'=>$model['sloccode'],
          'sloccode'=>$model['sloccode'],
          'dano'=>$model['dano'],

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
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'qty'=>$model['qty'],
          'storagebintoid'=>$model['storagebintoid'],
          'itemtext'=>$model['itemtext'],
          'productname'=>$model['productname'],
          'description'=>$model['description'],
          'uomcode'=>$model['uomcode'],
          'description'=>$model['description'],

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
				$sql = 'call UpdateTransStock (:slocfromid
,:sloctoid
,:docdate
,:headernote
,:deliveryadviceid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':transstockid',$_POST['transstockid'],PDO::PARAM_STR);
				$command->bindvalue(':slocfromid',(($_POST['slocfromid']!=='')?$_POST['slocfromid']:null),PDO::PARAM_STR);
        $command->bindvalue(':sloctoid',(($_POST['sloctoid']!=='')?$_POST['sloctoid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
        $command->bindvalue(':deliveryadviceid',(($_POST['deliveryadviceid']!=='')?$_POST['deliveryadviceid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvetsin(:vid,:vcreatedby)';
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
				$sql = 'call Deletetsin(:vid,:vcreatedby)';
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