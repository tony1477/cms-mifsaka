<?php

class BomController extends AdminController
{
	protected $menuname = 'bom';
	public $module = 'Production';
	protected $pageTitle = 'Komposisi Bahan';
	public $wfname = '';
	protected $sqldata = "select a0.bomid,a0.bomversion,a0.productid,a0.qty,a0.uomid,a0.bomdate,a0.description,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode 
    from billofmaterial a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqldatabomdetail = "select a0.bomdetailid,a0.bomid,a0.productid,a0.productbomid,a0.qty,a0.uomid,a0.description,a1.productname as productname,a2.bomversion as bomversion,a3.uomcode as uomcode 
    from bomdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join billofmaterial a2 on a2.bomid = a0.productbomid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.uomid
  ";
  protected $sqlcount = "select count(1) 
    from billofmaterial a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqlcountbomdetail = "select count(1) 
    from bomdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join billofmaterial a2 on a2.bomid = a0.productbomid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.uomid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['bomversion'])) && (isset($_REQUEST['productheader'])) && (isset($_REQUEST['uomcode'])) 
			&& (isset($_REQUEST['productdetail'])))
		{				
			$where .= " where a0.bomversion like '%". $_REQUEST['bomversion']."%' 
and a1.productname like '%". $_REQUEST['productheader']."%' 
and a2.uomcode like '%". $_REQUEST['uomcode']."%'
and a0.bomid in (
select az.bomid 
from bomdetail az 
join product ay on ay.productid = az.productid 
where ay.productname like '%". $_REQUEST['productdetail']."%')"; 
		}
		if (isset($_REQUEST['bomid']))
			{
				if (($_REQUEST['bomid'] !== '0') && ($_REQUEST['bomid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.bomid in (".$_REQUEST['bomid'].")";
					}
					else
					{
						$where .= " and a0.bomid in (".$_REQUEST['bomid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actioncopyBom()
	{
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call CopyBOM(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$id,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				$transaction->commit();
				$this->GetMessage('success','insertsuccess',1);
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
			$bomversion = $sheet->getCell('A2')->getValue();
			$productname = $sheet->getCell('B2')->getValue();
			$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$productname."')")->queryScalar();
			$qty = $sheet->getCell('C2')->getValue();
			$uomcode = $sheet->getCell('D2')->getValue();
			$uomid = Yii::app()->db->createCommand("select unitofmeasureid from unitofmeasure where lower(uomcode) = lower('".$uomcode."')")->queryScalar();
			$bomdate= $cell->getValue();
			if(PHPExcel_Shared_Date::isDateTime($cell)) {
				$bomdate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($bomdate)); 
			}
			$description = $sheet->getCell('F2')->getValue();
			$recordstatus = $sheet->getCell('G2')->getValue();
			$sql = "
				select bomid
				from billofmaterial 
				where bomversion = '".$bomversion."' 
				limit 1
			";
			$bomid = Yii::app()->db->createCommand($sql)->queryScalar();
			if ($bomid > 0) {
				$sql = "update billofmaterial 
					set productid = ".$productid.", qty = ".$qty.", uomid = ".$uomid.", bomdate = '".$bomdate."', description = '".$description."'
					where bomid = ".$bomid;
				Yii::app()->db->createCommand($sql)->execute();
			}
			else {
				$sql = "insert into billofmaterial (bomversion,productid,qty,uomid,bomdate,description,recordstatus)
					values ('".$bomversion."',".$productid.",".$qty.",".$uomid.",'".$bomdate."','".$description."',".$recordstatus.")";
				Yii::app()->db->createCommand($sql)->execute();
				$sql = "
					select bomid
					from billofmaterial 
					where bomversion = '".$bomversion."' 
					limit 1
				";
				$bomid = Yii::app()->db->createCommand($sql)->queryScalar();
			}		
			
			for ($i = 6;$i <= $highestRow; $i++)
			{	
				$product = $sheet->getCell('A'.$i)->getValue();
				$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$product."')")->queryScalar();
				$qty = $sheet->getCell('B'.$i)->getValue();
				$uom = $sheet->getCell('C'.$i)->getValue();
				$uomid = Yii::app()->db->createCommand("select unitofmeasureid from unitofmeasure where lower(description) = lower('".$uom."')")->queryScalar();
				$bomversion = $sheet->getCell('D'.$i)->getValue();
				$productbomid = Yii::app()->db->createCommand("select bomid from billofmaterial where lower(bomversion) = lower('".$bomversion."')")->queryScalar();
				$description = $sheet->getCell('E'.$i)->getValue();
				
				$sql = "
					select bomdetailid 
					from bomdetail 
					where bomid = ".$bomid." and productid = ".$productid;
				$bomdetailid = Yii::app()->db->createCommand($sql)->queryScalar();
				
				if ($bomdetailid > 0) {
					$sql = "
						update bomdetail 
						set qty = ".$qty.", uomid = ".$uomid.", productbomid = ".$productbomid.", description = '".$description."'
						where bomdetailid = ".$bomdetailid;
					Yii::app()->db->createCommand($sql)->execute();
				}
				else {
					$sql = " 
						insert into bomdetail (bomid,productid,qty,uomid,productbomid,description)
						values (".$bomid.",".$productid.",".$qty.",".$uomid.",".$productbomid.",".$description.")
					";
					Yii::app()->db->createCommand($sql)->execute();
				}
				$command->execute();
				$this->getMessage('success',"alreadysaved");
			}
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
			'keyField'=>'bomid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'bomid','bomversion','productid','qty','uomid','bomdate','description','recordstatus'
				),
				'defaultOrder' => array( 
					'bomid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['bomid']))
		{
			$this->sqlcountbomdetail .= ' where a0.bomid = '.$_REQUEST['bomid'];
			$this->sqldatabomdetail .= ' where a0.bomid = '.$_REQUEST['bomid'];
			$count = Yii::app()->db->createCommand($this->sqlcountbomdetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatabomdetail .= " limit 0";
		}
		$countbomdetail = $count;
		$dataProviderbomdetail=new CSqlDataProvider($this->sqldatabomdetail,array(
			'totalItemCount'=>$countbomdetail,
			'keyField'=>'bomdetailid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'bomdetailid' => CSort::SORT_DESC
				),
			),
			));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderbomdetail'=>$dataProviderbomdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into billofmaterial (recordstatus) values (1)";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'bomid'=>$id,
			"qty" =>0,
      "bomdate" =>date("Y-m-d"),
      "recordstatus" =>1
		));
	}
  public function actionCreatebomdetail()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.bomid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'bomid'=>$model['bomid'],
          'bomversion'=>$model['bomversion'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'bomdate'=>$model['bomdate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],

				));
				Yii::app()->end();
			}
		}
	}

  public function actionUpdatebomdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatabomdetail.' where bomdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'bomdetailid'=>$model['bomdetailid'],
          'bomid'=>$model['bomid'],
          'productid'=>$model['productid'],
          'productbomid'=>$model['productbomid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'description'=>$model['description'],
          'productname'=>$model['productname'],
          'bomversion'=>$model['bomversion'],
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
			array('bomversion','string','emptybomversion'),
      array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['bomid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateBOM (:bomid
,:bomversion
,:productid
,:qty
,:uomid
,:bomdate
,:description
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':bomid',$_POST['bomid'],PDO::PARAM_STR);
				$command->bindvalue(':bomversion',(($_POST['bomversion']!=='')?$_POST['bomversion']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':bomdate',(($_POST['bomdate']!=='')?$_POST['bomdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
public function actionSavebomdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
    ));
		if ($error == false)
		{
			$id = $_POST['bomdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update bomdetail 
			      set bomid = :bomid,productid = :productid,productbomid = :productbomid,qty = :qty,uomid = :uomid,description = :description 
			      where bomdetailid = :bomdetailid';
				}
				else
				{
					$sql = 'insert into bomdetail (bomid,productid,productbomid,qty,uomid,description) 
			      values (:bomid,:productid,:productbomid,:qty,:uomid,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':bomdetailid',$_POST['bomdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':bomid',(($_POST['bomid']!=='')?$_POST['bomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productbomid',(($_POST['productbomid']!=='')?$_POST['productbomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from billofmaterial where bomid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update billofmaterial set recordstatus = 0 where bomid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update billofmaterial set recordstatus = 1 where bomid = ".$id[$i];
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
				$sql = "delete from billofmaterial where bomid = ".$id[$i];
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
	}public function actionPurgebomdetail()
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
				$sql = "delete from bomdetail where bomdetailid = ".$id[$i];
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
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		$this->pdf->title=$this->getcatalog('bom');
	  $this->pdf->AddPage('P');
		$this->pdf->SetFont('Arial');
		$this->pdf->AliasNBPages();
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFontSize(8);
      $this->pdf->text(15,$this->pdf->gety()+5,'BOM Version ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['bomversion']);
      $this->pdf->text(15,$this->pdf->gety()+10,'BOM Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['bomdate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'Material / Service');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['productname']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Qty');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['qty']. ' '.$row['uomcode']);
      $this->pdf->text(15,$this->pdf->gety()+25,'Description');$this->pdf->text(50,$this->pdf->gety()+25,': '.$row['description']);

      $sql1 = "select a.bomdetailid,b.productname, a.qty, c.uomcode, a.description, d.bomversion
        from bomdetail a
        inner join product b on b.productid = a.productid
        inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.productbomid
        where a.bomid = '".$row['bomid']."'
	order by bomdetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

	  $this->pdf->sety($this->pdf->gety()+30);
      
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,15,65));
	  $this->pdf->colheader = array('No','Items','Qty','Unit','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['bomversion'] .' - '.$row1['description']));
      }
			$this->pdf->sety($this->pdf->gety()+30);
      $this->pdf->text(10,$this->pdf->gety()+10,'Approved By');$this->pdf->text(150,$this->pdf->gety()+10,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+30,'____________ ');$this->pdf->text(150,$this->pdf->gety()+30,'____________');
      $this->pdf->checkNewPage(10);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('bomid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('bomversion'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('bomdate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['bomid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['bomversion'])
->setCellValueByColumnAndRow(2, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(4, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['bomdate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['description'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=3;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$i,$this->getCatalog('bomid'))
->setCellValueByColumnAndRow(1,$i,$this->getCatalog('bomversion'))
->setCellValueByColumnAndRow(2,$i,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(3,$i,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(4,$i,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(5,$i,$this->getCatalog('description'));
$i+=1;
		$sql1 = "select a.bomdetailid,b.productname, a.qty, c.uomcode, a.description, d.bomversion
        from bomdetail a
        inner join product b on b.productid = a.productid
        inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.productbomid
        where a.bomid = '".$row1['bomid']."' and b.productname like '%".(isset($_REQUEST['productdetail'])?$_REQUEST['productdetail']:'')."%'
	order by bomdetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			foreach($dataReader1 as $row2)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, '')
->setCellValueByColumnAndRow(1, $i+1, $row2['bomversion'])
->setCellValueByColumnAndRow(2, $i+1, $row2['productname'])
->setCellValueByColumnAndRow(3, $i+1, $row2['qty'])
->setCellValueByColumnAndRow(4, $i+1, $row2['uomcode'])
->setCellValueByColumnAndRow(5, $i+1, $row2['description']);
$i+=1;
		}
		}
		$this->getFooterXLS($this->phpExcel);
	}
}