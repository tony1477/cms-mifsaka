<?php

class DeliveryadviceproductplanController extends AdminController
{
	protected $menuname = 'deliveryadviceproductplan';
	public $module = 'Inventory';
	protected $pageTitle = 'Form Permintaan Barang SPP';
	public $wfname = 'appda';
	protected $sqldata = "select a0.deliveryadviceid,a0.dadate,a0.dano,a0.useraccessid,a0.slocid,a0.productplanid,a0.soheaderid,a0.productoutputid,a0.headernote,a0.recordstatus,a1.username as username,a2.sloccode as sloccode,a3.productplanno as productplanno,a0.statusname  
    from deliveryadvice a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join sloc a2 on a2.slocid = a0.slocid
    left join productplan a3 on a3.productplanid = a0.productplanid
  ";
protected $sqldatadeliveryadvicedetail = "select a0.deliveryadvicedetailid,a0.deliveryadviceid,a0.productid,a0.qty,a0.unitofmeasureid,a0.requestedbyid,a0.reqdate,a0.itemtext,a0.prqty,a0.giqty,a0.grqty,a0.poqty,a0.productplandetailid,a0.sodetailid,a0.productoutputfgid,a0.slocid,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode,a3.requestedbycode as requestedbycode,a4.sloccode as sloccode 
    from deliveryadvicedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
    left join sloc a4 on a4.slocid = a0.slocid
  ";

  protected $sqlcount = "select count(1) 
    from deliveryadvice a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join sloc a2 on a2.slocid = a0.slocid
    left join productplan a3 on a3.productplanid = a0.productplanid
  ";
protected $sqlcountdeliveryadvicedetail = "select count(1) 
    from deliveryadvicedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join requestedby a3 on a3.requestedbyid = a0.requestedbyid
    left join sloc a4 on a4.slocid = a0.slocid
  ";


	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appda')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listda').") 
				and a0.recordstatus < {$maxstat}
				and a0.useraccessid in (".getUserObjectValues('useraccess').")
				and a3.productplanno is not null";
		if ((isset($_REQUEST['dano'])) && (isset($_REQUEST['username'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['productplanno'])))
		{				
			$where .=  " 
and a0.dano like '%". $_REQUEST['dano']."%' 
and a1.username like '%". $_REQUEST['username']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.productplanno like '%". $_REQUEST['productplanno']."%'"; 
		}
		if (isset($_REQUEST['deliveryadviceid']))
			{
				if (($_REQUEST['deliveryadviceid'] !== '0') && ($_REQUEST['deliveryadviceid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.deliveryadviceid in (".$_REQUEST['deliveryadviceid'].")";
					}
					else
					{
						$where .= " and a0.deliveryadviceid in (".$_REQUEST['deliveryadviceid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionGeneratepp()
	{
			if (isset($_POST['id']))
			{
				$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
				try
				{
					$sql = 'call GenerateSPP(:vid, :vslocid,:vhid)';
					$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
					$command->bindvalue(':vslocid',$_POST['slocid'],PDO::PARAM_INT);
					$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
					$command->execute();
					$transaction->commit();
					$this->GetMessage('success','insertsuccess');
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$transaction->rollBack();
					$this->GetMessage('error',$e->getMessage());
				}
			}
		}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'deliveryadviceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'deliveryadviceid','dadate','dano','useraccessid','slocid','productplanid','soheaderid','productoutputid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'deliveryadviceid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['deliveryadviceid']))
		{
			$this->sqlcountdeliveryadvicedetail .= ' where a0.deliveryadviceid = '.$_REQUEST['deliveryadviceid'];
			$this->sqldatadeliveryadvicedetail .= ' where a0.deliveryadviceid = '.$_REQUEST['deliveryadviceid'];
			$count = Yii::app()->db->createCommand($this->sqlcountdeliveryadvicedetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatadeliveryadvicedetail .= " limit 0";
		}
		$countdeliveryadvicedetail = $count;
$dataProviderdeliveryadvicedetail=new CSqlDataProvider($this->sqldatadeliveryadvicedetail,array(
					'totalItemCount'=>$countdeliveryadvicedetail,
					'keyField'=>'deliveryadvicedetailid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'deliveryadvicedetailid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['deliveryadviceid']));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderdeliveryadvicedetail'=>$dataProviderdeliveryadvicedetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$cmd = Yii::app()->db->createCommand("select useraccessid 
			from useraccess 
			where lower (username) = '".Yii::app()->user->id."'")->queryScalar();
		$sql = "insert into deliveryadvice (useraccessid,recordstatus) values (".$cmd.",".$this->findstatusbyuser('insda').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'deliveryadviceid'=>$id,
			"dadate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insda")
		));
	}
  public function actionCreatedeliveryadvicedetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "reqdate" =>date("Y-m-d"),
      "prqty" =>0,
      "giqty" =>0,
      "grqty" =>0,
      "poqty" =>0,
      "recordstatus" =>$this->findstatusbyuser("insda")
		));
	}
 
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.deliveryadviceid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'dadate'=>$model['dadate'],
						'deliveryadviceid'=>$model['deliveryadviceid'],
          'slocid'=>$model['slocid'],
          'productplanid'=>$model['productplanid'],
          'headernote'=>$model['headernote'],
          'username'=>$model['username'],
          'sloccode'=>$model['sloccode'],
          'productplanno'=>$model['productplanno'],

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

  public function actionUpdatedeliveryadvicedetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatadeliveryadvicedetail.' where deliveryadvicedetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'requestedbyid'=>$model['requestedbyid'],
          'reqdate'=>$model['reqdate'],
          'itemtext'=>$model['itemtext'],
          'slocid'=>$model['slocid'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'requestedbycode'=>$model['requestedbycode'],
          'sloccode'=>$model['sloccode'],

				));
				Yii::app()->end();
			}
		}
	}
 
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('dadate','string','emptydadate'),
      array('slocid','string','emptyslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['deliveryadviceid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateDAPP (:deliveryadviceid
					,:dadate
					,:headernote
,:slocid
,:productplanid
,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':deliveryadviceid',$_POST['deliveryadviceid'],PDO::PARAM_STR);
				$command->bindvalue(':dadate',(($_POST['dadate']!=='')?$_POST['dadate']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productplanid',(($_POST['productplanid']!=='')?$_POST['productplanid']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
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
public function actionSavedeliveryadvicedetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('requestedbyid','string','emptyrequestedbyid'),
      array('slocid','string','emptyslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['deliveryadvicedetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update deliveryadvicedetail 
			      set productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,requestedbyid = :requestedbyid,reqdate = :reqdate,itemtext = :itemtext,slocid = :slocid 
			      where deliveryadvicedetailid = :deliveryadvicedetailid';
				}
				else
				{
					$sql = 'insert into deliveryadvicedetail (productid,qty,unitofmeasureid,requestedbyid,reqdate,itemtext,slocid) 
			      values (:productid,:qty,:unitofmeasureid,:requestedbyid,:reqdate,:itemtext,:slocid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':deliveryadvicedetailid',$_POST['deliveryadvicedetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':requestedbyid',(($_POST['requestedbyid']!=='')?$_POST['requestedbyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':reqdate',(($_POST['reqdate']!=='')?$_POST['reqdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemtext',(($_POST['itemtext']!=='')?$_POST['itemtext']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
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
				$sql = 'call ApproveDA(:vid,:vcreatedby)';
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
				$sql = 'call DeleteDA(:vid,:vcreatedby)';
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
				$sql = "delete from deliveryadvice where deliveryadviceid = ".$id[$i];
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
	}public function actionPurgedeliveryadvicedetail()
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
				$sql = "delete from deliveryadvicedetail where deliveryadvicedetailid = ".$id[$i];
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
		$sql = "select getcompanysloc(a.slocid) as companyid,a.dano,a.dadate,a.headernote,
				a.deliveryadviceid,b.sloccode,b.description,a.recordstatus,c.productplanno,d.sono,e.productoutputno
      from deliveryadvice a 
			left join productplan c on c.productplanid = a.productplanid 
			left join soheader d on d.soheaderid = a.soheaderid 
			left join productoutput e on e.productoutputid = a.productoutputid
			left join sloc b on b.slocid = a.slocid ";
		if ($_GET['deliveryadviceid'] !== '') {
				$sql = $sql . "where a.deliveryadviceid in (".$_GET['deliveryadviceid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('deliveryadvice');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFontSize(8);
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['dano']);
      $this->pdf->text(120,$this->pdf->gety()+2,'SPP ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['productplanno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])));
      $this->pdf->text(120,$this->pdf->gety()+6,'Gudang ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['sloccode'].' - '.$row['description']);

      $sql1 = "select b.productname, sum(a.qty) as qty, c.uomcode, a.itemtext,concat(e.sloccode,' - ',e.description) as sloccode
        from deliveryadvicedetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
				left join sloc e on e.slocid = a.slocid
        where deliveryadviceid = ".$row['deliveryadviceid'].
				" group by b.productname,c.uomcode,e.sloccode ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+10);
      
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,30,15,60,25));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Gd Tujuan','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['sloccode'],
            $row1['itemtext']));
      }
			
			$this->pdf->sety($this->pdf->gety());
	  $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(30,170));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');
	  $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
$this->pdf->checkNewPage(20);      
//      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');

			}
	  $this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('deliveryadviceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('dadate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('dano'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('username'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('productplanno'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('soheaderid'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('productoutputid'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['deliveryadviceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['dadate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['dano'])
->setCellValueByColumnAndRow(3, $i+1, $row1['username'])
->setCellValueByColumnAndRow(4, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['productplanno'])
->setCellValueByColumnAndRow(6, $i+1, $row1['soheaderid'])
->setCellValueByColumnAndRow(7, $i+1, $row1['productoutputid'])
->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}