<?php

class BsheaderController extends AdminController
{
	protected $menuname = 'bsheader';
	public $module = 'Inventory';
	protected $pageTitle = 'Stok Opname';
	public $wfname = 'appbs';
	protected $sqldata = "select a0.bsheaderid,a0.slocid,a0.bsdate,a0.bsheaderno,a0.headernote,a0.recordstatus,a1.sloccode as sloccode,a0.statusname  
    from bsheader a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
protected $sqldatabsdetail = "select a0.bsdetailid,a0.bsheaderid,a0.productid,a0.unitofmeasureid,a0.qty,a0.ownershipid,a0.expiredate,a0.materialstatusid,a0.storagebinid,a0.location,a0.itemnote,a0.currencyid,a0.buyprice,a0.currencyrate,a1.productname as productname,a2.uomcode as uomcode,a3.ownershipname as ownershipname,a4.materialstatusname as materialstatusname,a5.description as description,a6.currencyname as currencyname 
    from bsdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join ownership a3 on a3.ownershipid = a0.ownershipid
    left join materialstatus a4 on a4.materialstatusid = a0.materialstatusid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join currency a6 on a6.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from bsheader a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
protected $sqlcountbsdetail = "select count(1) 
    from bsdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join ownership a3 on a3.ownershipid = a0.ownershipid
    left join materialstatus a4 on a4.materialstatusid = a0.materialstatusid
    left join storagebin a5 on a5.storagebinid = a0.storagebinid
    left join currency a6 on a6.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appbs')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listbs').") 
			and a0.recordstatus < {$maxstat}
			and a0.slocid in (".getUserObjectValues('sloc').")";
		if ((isset($_REQUEST['bsheaderno'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .=  " 
and a0.bsheaderno like '%". $_REQUEST['bsheaderno']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['bsheaderid']))
			{
				if (($_REQUEST['bsheaderid'] !== '0') && ($_REQUEST['bsheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.bsheaderid in (".$_REQUEST['bsheaderid'].")";
					}
					else
					{
						$where .= " and a0.bsheaderid in (".$_REQUEST['bsheaderid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionUploaddata()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		}
		$this->storeFolder = dirname('__FILES__').'/uploads/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	
	public function actionRunning()
	{
		$s = $_POST['id'];
		Yii::import('ext.phpexcel.XPHPExcel');
		Yii::import('ext.phpexcel.vendor.PHPExcel'); 
		$phpExcel = XPHPExcel::createPHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$phpExcel = $objReader->load(dirname('__FILES__').'/uploads/'.$s);
		$connection = Yii::app()->db;
		try
		{
			$sheet = $phpExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$sloc = $sheet->getCell('A2')->getValue();
			$slocid = Yii::app()->db->createCommand("select slocid from sloc where lower(sloccode) = lower('".$sloc."')")->queryScalar();
			$cell = $sheet->getCell('B2');
			$bsdate= $cell->getValue();
			if(PHPExcel_Shared_Date::isDateTime($cell)) {
				$bsdate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($bsdate)); 
			}
			$headernote = $sheet->getCell('C2')->getValue();
			$sql = "
				insert into bsheader (slocid,bsdate,headernote,recordstatus) 
				values (".$slocid.",'".$bsdate."','".$headernote."',".$this->findstatusbyuser("insbs").");
			";
			Yii::app()->db->createCommand($sql)->execute();
			
			$sql = "select last_insert_id();";
			$id = Yii::app()->db->createCommand($sql)->queryScalar();
			
			for ($i = 6;$i <= $highestRow; $i++)
			{	
				$product = $sheet->getCell('A'.$i)->getValue();
				$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$product."')")->queryScalar();
				if ($productid == null)
				{
					$this->getMessage('error','emptyproductid');
				}
				$uom = $sheet->getCell('B'.$i)->getValue();
				$uomid = Yii::app()->db->createCommand("select unitofmeasureid from unitofmeasure where lower(uomcode) = lower('".$uom."')")->queryScalar();
				if ($uomid == null)
				{
					$this->getMessage('error','emptyunitofmeasureid');
				}
				$qty = $sheet->getCell('C'.$i)->getValue();
				$owner = $sheet->getCell('D'.$i)->getValue();
				$ownershipid = Yii::app()->db->createCommand("select ownershipid from ownership where lower(ownershipname) = lower('".$owner."')")->queryScalar();
				if ($ownershipid == null)
				{
					$this->getMessage('error','emptyownershipid');
				}
				$cell = $sheet->getCell('E'.$i);
				$expiredate= $cell->getValue();
				if(PHPExcel_Shared_Date::isDateTime($cell)) {
					$expiredate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($expiredate)); 
				}
				$materialstatus = $sheet->getCell('F'.$i)->getValue();
				$materialstatusid = Yii::app()->db->createCommand("select materialstatusid from materialstatus where lower(materialstatusname) = lower('".$materialstatus."')")->queryScalar();
				if ($materialstatusid == null)
				{
					$this->getMessage('error','emptymaterialstatusid');
				}
				$storagebin = $sheet->getCell('G'.$i)->getValue();
				$storagebinid = Yii::app()->db->createCommand("select storagebinid from storagebin where lower(description) = lower('".$storagebin."')")->queryScalar();
				if ($storagebinid == null)
				{
					$this->getMessage('error','emptystoragebinid');
				}
				$location = $sheet->getCell('H'.$i)->getValue();
				$itemnote = $sheet->getCell('I'.$i)->getValue();
				$buyprice = $sheet->getCell('J'.$i)->getValue();
				$currency = $sheet->getCell('K'.$i)->getValue();
				$currencyid = Yii::app()->db->createCommand("select currencyid from currency where lower(currencyname) = lower('".$currency."')")->queryScalar();
				if ($currencyid == null)
				{
					$this->getMessage('error','emptycurrencyid');
				}
				$currencyrate = $sheet->getCell('L'.$i)->getValue();
				
				$sql = 'insert into bsdetail (bsheaderid,productid,unitofmeasureid,qty,ownershipid,expiredate,materialstatusid,storagebinid,location,itemnote,currencyid,buyprice,currencyrate) 
					values (:bsheaderid,:productid,:unitofmeasureid,:qty,:ownershipid,:expiredate,:materialstatusid,:storagebinid,:location,:itemnote,:currencyid,:buyprice,:currencyrate)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':bsheaderid',$id,PDO::PARAM_STR);
				$command->bindvalue(':productid',$productid,PDO::PARAM_STR);
				$command->bindvalue(':unitofmeasureid',$uomid,PDO::PARAM_STR);
				$command->bindvalue(':qty',(($qty != null)?$qty:0),PDO::PARAM_STR);
				$command->bindvalue(':ownershipid',$ownershipid,PDO::PARAM_STR);
				$command->bindvalue(':expiredate',$expiredate,PDO::PARAM_STR);
				$command->bindvalue(':materialstatusid',$materialstatusid,PDO::PARAM_STR);
				$command->bindvalue(':storagebinid',$storagebinid,PDO::PARAM_STR);
				$command->bindvalue(':location',$location,PDO::PARAM_STR);
				$command->bindvalue(':itemnote',$itemnote,PDO::PARAM_STR);
				$command->bindvalue(':currencyid',$currencyid,PDO::PARAM_STR);
				$command->bindvalue(':buyprice',$buyprice,PDO::PARAM_STR);
				$command->bindvalue(':currencyrate',$currencyrate,PDO::PARAM_STR);
				//var_dump($command);
				$command->execute();
			}
			$this->getMessage('success',"alreadysaved");
		}	
		catch (Exception $e)
		{
			$this->getMessage('error',$e->getMessage());
		}		
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'bsheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'bsheaderid','slocid','bsdate','bsheaderno','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'bsheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['bsheaderid']))
		{
			$this->sqlcountbsdetail .= ' where a0.bsheaderid = '.$_REQUEST['bsheaderid'];
			$this->sqldatabsdetail .= ' where a0.bsheaderid = '.$_REQUEST['bsheaderid'];
			$count = Yii::app()->db->createCommand($this->sqlcountbsdetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatabsdetail .= " limit 0";
		}
		$countbsdetail = $count;
$dataProviderbsdetail=new CSqlDataProvider($this->sqldatabsdetail,array(
					'totalItemCount'=>$countbsdetail,
					'keyField'=>'bsdetailid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'bsdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderbsdetail'=>$dataProviderbsdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into bsheader (recordstatus) values (".$this->findstatusbyuser('insbs').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'bsheaderid'=>$id,
			"bsdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insbs")
		));
	}
  public function actionCreatebsdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "expiredate" =>date("Y-m-d"),
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "buyprice" =>0,
      "currencyrate" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.bsheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'slocid'=>$model['slocid'],
          'bsdate'=>$model['bsdate'],
          'headernote'=>$model['headernote'],
          'sloccode'=>$model['sloccode'],
          'bsheaderid'=>$model['bsheaderid'],

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

  public function actionUpdatebsdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatabsdetail.' where bsdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'bsheaderid'=>$model['bsheaderid'],
          'productid'=>$model['productid'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'qty'=>$model['qty'],
          'ownershipid'=>$model['ownershipid'],
          'expiredate'=>$model['expiredate'],
          'materialstatusid'=>$model['materialstatusid'],
          'storagebinid'=>$model['storagebinid'],
          'location'=>$model['location'],
          'itemnote'=>$model['itemnote'],
          'currencyid'=>$model['currencyid'],
          'buyprice'=>$model['buyprice'],
          'currencyrate'=>$model['currencyrate'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'ownershipname'=>$model['ownershipname'],
          'materialstatusname'=>$model['materialstatusname'],
          'description'=>$model['description'],
          'currencyname'=>$model['currencyname'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('slocid','string','emptyslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['bsheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateBsHeader (:bsheaderid,:slocid
,:bsdate
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':bsheaderid',$_POST['bsheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':bsdate',(($_POST['bsdate']!=='')?$_POST['bsdate']:null),PDO::PARAM_STR);
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
public function actionSavebsdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('ownershipid','string','emptyownershipid'),
      array('materialstatusid','string','emptymaterialstatusid'),
      array('storagebinid','string','emptystoragebinid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['bsdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update bsdetail 
			      set bsheaderid = :bsheaderid,productid = :productid,unitofmeasureid = :unitofmeasureid,qty = :qty,ownershipid = :ownershipid,expiredate = :expiredate,materialstatusid = :materialstatusid,storagebinid = :storagebinid,location = :location,itemnote = :itemnote,currencyid = :currencyid,buyprice = :buyprice,currencyrate = :currencyrate 
			      where bsdetailid = :bsdetailid';
				}
				else
				{
					$sql = 'insert into bsdetail (bsheaderid,productid,unitofmeasureid,qty,ownershipid,expiredate,materialstatusid,storagebinid,location,itemnote,currencyid,buyprice,currencyrate) 
			      values (:bsheaderid,:productid,:unitofmeasureid,:qty,:ownershipid,:expiredate,:materialstatusid,:storagebinid,:location,:itemnote,:currencyid,:buyprice,:currencyrate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':bsdetailid',$_POST['bsdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':bsheaderid',(($_POST['bsheaderid']!=='')?$_POST['bsheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':ownershipid',(($_POST['ownershipid']!=='')?$_POST['ownershipid']:null),PDO::PARAM_STR);
        $command->bindvalue(':expiredate',(($_POST['expiredate']!=='')?$_POST['expiredate']:null),PDO::PARAM_STR);
        $command->bindvalue(':materialstatusid',(($_POST['materialstatusid']!=='')?$_POST['materialstatusid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':location',(($_POST['location']!=='')?$_POST['location']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemnote',(($_POST['itemnote']!=='')?$_POST['itemnote']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':buyprice',(($_POST['buyprice']!=='')?$_POST['buyprice']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvebs(:vid,:vcreatedby)';
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
				$sql = 'call Deletebs(:vid,:vcreatedby)';
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
				$sql = "delete from bsheader where bsheaderid = ".$id[$i];
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
	}public function actionPurgebsdetail()
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
				$sql = "delete from bsdetail where bsdetailid = ".$id[$i];
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
		$sql = "select a.bsheaderid,a.bsheaderno,a.bsdate,b.sloccode,a.headernote
						from bsheader a
						inner join sloc b on b.slocid = a.slocid ";
		if ($_REQUEST['bsheaderid'] !== '') 
		{
				$sql = $sql . "where a.bsheaderid in (".$_REQUEST['bsheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('bsheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNBPages();
	  // definisi font
	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',10);      
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['bsheaderno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['bsdate'])));
			$this->pdf->text(135,$this->pdf->gety()+5,'Gudang ');$this->pdf->text(170,$this->pdf->gety()+5,': '.$row['sloccode']);
	
			$i=0;$totalqty=0;$totaljumlah=0;
			$sql1 = "select b.productname,a.qty,a.buyprice,c.uomcode,a.itemnote,a.location,d.ownershipname,a.expiredate,e.materialstatusname,f.description
							from bsdetail a
							inner join product b on b.productid = a.productid
							inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							inner join ownership d on d.ownershipid = a.ownershipid
							inner join materialstatus e on e.materialstatusid = a.materialstatusid
							inner join storagebin f on f.storagebinid = a.storagebinid
							where bsheaderid = ".$row['bsheaderid']." order by bsdetailid ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->setwidths(array(7,45,20,15,22,25,30,20,20));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Hrg Beli/Prd','Jumlah','Rak','Status','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','C','R','C','L','L','L');
      
      foreach($dataReader1 as $row1)
      {
            if($this->GetMenuAuth('currency') == 'false'){
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],
					Yii::app()->format->formatCurrency($row1['buyprice']),
					Yii::app()->format->formatCurrency($row1['qty']*$row1['buyprice']),
					$row1['description'],
					$row1['ownershipname'].'-'.$row1['materialstatusname'],				
					$row1['itemnote']));
				$totalqty+=$row1['qty'];
				$totaljumlah+=$row1['qty']*$row1['buyprice'];
      }
      if($this->GetMenuAuth('currency') == 'true') {
          $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
					$row1['uomcode'].'  '.Yii::app()->format->formatNumber($row1['qty']),
					'0',
					'0',
					$row1['description'],
					$row1['ownershipname'].'-'.$row1['materialstatusname'],				
					$row1['itemnote']));
				
      }
      
            }
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->setFont('Arial','B',8);
      $this->pdf->coldetailalign = array('L','R','R','R','R','C','L','L');
			$this->pdf->row(array('','TOTAL',
				Yii::app()->format->formatNumber($totalqty),
				'',
				
				'',Yii::app()->format->formatCurrency($totaljumlah),'',''));
			
			$this->pdf->setFont('Arial','',8);
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Note',$row['headernote']));
			$this->pdf->checkNewPage(20);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+5);
			//$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
			//$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),' Diketahui oleh,');$this->pdf->text(137,$this->pdf->gety(),'     Disetujui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'.........................');$this->pdf->text(137,$this->pdf->gety()+22,'.................................');
			$this->pdf->text(15,$this->pdf->gety()+25,'       Admin');$this->pdf->text(55,$this->pdf->gety()+25,'    Supervisor');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');$this->pdf->text(137,$this->pdf->gety()+25,'Manager Accounting');
			//$this->pdf->Image('images/ttdbs.jpg',5,$this->pdf->gety()+5,200);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('bsheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('bsdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('bsheaderno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['bsheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['bsdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['bsheaderno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
