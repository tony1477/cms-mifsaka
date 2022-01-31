<?php

class MrpController extends AdminController
{
	protected $menuname = 'mrp';
	public $module = 'Inventory';
	protected $pageTitle = 'Material Requirement Planning';
	public $wfname = '';
	protected $sqldata = "select a0.mrpid,a0.productid,a0.uomid,a0.slocid,a0.minstock,a0.reordervalue,a0.maxvalue,a0.leadtime,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode 
    from mrp a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid 
		left join plant a4 on a4.plantid = a3.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";
  protected $sqlcount = "select count(1) 
    from mrp a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
		left join plant a4 on a4.plantid = a3.plantid
		left join company a5 on a5.companyid = a4.companyid 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a5.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .= " where a1.productname like '%". $_REQUEST['productname']."%' 
and a2.uomcode like '%". $_REQUEST['uomcode']."%' 
and a3.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['mrpid']))
			{
				if (($_REQUEST['mrpid'] !== '0') && ($_REQUEST['mrpid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.mrpid in (".$_REQUEST['mrpid'].")";
					}
					else
					{
						$where .= " and a0.mrpid in (".$_REQUEST['mrpid'].")";
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
			for ($i = 4;$i <= $highestRow; $i++)
			{	
				$productname = $sheet->getCell('B'.$i)->getValue();
				$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$productname."')")->queryScalar();
				if ($productid == null)
				{
					$this->getMessage('error','emptyproductid');
				}
                $uomcode = $sheet->getCell('C'.$i)->getValue();
				$uomid = Yii::app()->db->createCommand("select unitofmeasureid from unitofmeasure where lower(uomcode) = lower('".$uomcode."')")->queryScalar();
				if ($uomid == null)
				{
					$this->getMessage('error','emptyuomid');
				}
                $sloccode = $sheet->getCell('D'.$i)->getValue();
				$slocid = Yii::app()->db->createCommand("select slocid from sloc where lower(sloccode) = lower('".$sloccode."')")->queryScalar();
				if ($slocid == null)
				{
					$this->getMessage('error','emptyslcoid');
				}
				$minstock = $sheet->getCell('E'.$i)->getValue();
				$reordervalue = $sheet->getCell('F'.$i)->getValue();
				$maxvalue = $sheet->getCell('G'.$i)->getValue();
				$leadtime = $sheet->getCell('H'.$i)->getValue();
				$recordstatus = $sheet->getCell('I'.$i)->getValue();
				
				$sql = "select count(1) from mrp where productid = ".$productid." and slocid = '".$slocid."' AND uomid='".$uomid."'";
				$id = Yii::app()->db->createCommand($sql)->queryScalar();
				if ($id == 0) {
					$sql = 'insert into mrp (productid,uomid,slocid,minstock,reordervalue,`maxvalue`,leadtime,recordstatus) 
						values (:productid,:uomid,:slocid,:minstock,:reordervalue,:maxvalue,:leadtime,:recordstatus)';
					$command = $connection->createCommand($sql);
					$command->bindvalue(':productid',$productid,PDO::PARAM_STR);
					$command->bindvalue(':uomid',$uomid,PDO::PARAM_STR);
					$command->bindvalue(':slocid',$slocid,PDO::PARAM_STR);
					$command->bindvalue(':minstock',$minstock,PDO::PARAM_STR);
					$command->bindvalue(':reordervalue',$reordervalue,PDO::PARAM_STR);
					$command->bindvalue(':maxvalue',$maxvalue,PDO::PARAM_STR);
					$command->bindvalue(':leadtime',$leadtime,PDO::PARAM_STR);
					$command->bindvalue(':recordstatus',$recordstatus,PDO::PARAM_STR);
					$command->execute();
				}
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
			'keyField'=>'mrpid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'mrpid','productid','uomid','slocid','minstock','reordervalue','maxvalue','leadtime','recordstatus'
				),
				'defaultOrder' => array( 
					'mrpid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"minstock" =>0,
      "reordervalue" =>0,
      "maxvalue" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.mrpid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'mrpid'=>$model['mrpid'],
          'productid'=>$model['productid'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'minstock'=>$model['minstock'],
          'reordervalue'=>$model['reordervalue'],
          'maxvalue'=>$model['maxvalue'],
          'leadtime'=>$model['leadtime'],
          'recordstatus'=>$model['recordstatus'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
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
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['mrpid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update mrp 
			      set productid = :productid,uomid = :uomid,slocid = :slocid,minstock = :minstock,reordervalue = :reordervalue,`maxvalue` = :maxvalue,leadtime = :leadtime,recordstatus = :recordstatus 
			      where mrpid = :mrpid';
				}
				else
				{
					$sql = 'insert into mrp (productid,uomid,slocid,minstock,reordervalue,`maxvalue`,leadtime,recordstatus) 
			      values (:productid,:uomid,:slocid,:minstock,:reordervalue,:maxvalue,:leadtime,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':mrpid',$_POST['mrpid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':minstock',(($_POST['minstock']!=='')?$_POST['minstock']:null),PDO::PARAM_STR);
        $command->bindvalue(':reordervalue',(($_POST['reordervalue']!=='')?$_POST['reordervalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':maxvalue',(($_POST['maxvalue']!=='')?$_POST['maxvalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':leadtime',(($_POST['leadtime']!=='')?$_POST['leadtime']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
				
	
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from mrp where mrpid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update mrp set recordstatus = 0 where mrpid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update mrp set recordstatus = 1 where mrpid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
				$sql = "delete from mrp where mrpid = ".$id[$i];
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
	}
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('mrp');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('mrpid'),$this->getCatalog('product'),$this->getCatalog('uom'),$this->getCatalog('sloc'),$this->getCatalog('minstock'),$this->getCatalog('reordervalue'),$this->getCatalog('maxvalue'),$this->getCatalog('leadtime'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['mrpid'],$row1['productname'],$row1['uomcode'],$row1['sloccode'],$row1['minstock'],$row1['reordervalue'],$row1['maxvalue'],$row1['leadtime'],$row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=3;
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['mrpid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['minstock'])
->setCellValueByColumnAndRow(5, $i+1, $row1['reordervalue'])
->setCellValueByColumnAndRow(6, $i+1, $row1['maxvalue'])
->setCellValueByColumnAndRow(7, $i+1, $row1['leadtime'])
->setCellValueByColumnAndRow(8, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}