<?php

class ProductconvertController extends AdminController
{
	protected $menuname = 'productconvert';
	public $module = 'Inventory';
	protected $pageTitle = 'Material / Service Konversi';
	public $wfname = 'appconvert';
	protected $sqldata = "select a0.productconvertid,a0.productconversionid,a0.qty,a0.uomid,a0.slocid,a0.storagebinid,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description,getwfstatusbywfname('appconvert',a0.recordstatus) as statusname  
    from productconvert a0 
    left join productconversion a7 on a7.productconversionid = a0.productconversionid
    left join product a1 on a1.productid = a7.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid 
		left join plant a5 on a5.plantid = a3.plantid
		left join company a6 on a6.companyid = a5.companyid 
  ";
protected $sqldataproductconvertdetail = "select a0.productconvertdetailid,a0.productconvertid,a0.productconversiondetailid,a0.productid,a0.qty,a0.uomid,a0.slocid,a0.storagebinid,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from productconvertdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from productconvert a0 
    left join productconversion a7 on a7.productconversionid = a0.productconversionid
    left join product a1 on a1.productid = a7.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
		left join plant a5 on a5.plantid = a3.plantid
		left join company a6 on a6.companyid = a5.companyid 
  ";
protected $sqlcountproductconvertdetail = "select count(1) 
    from productconvertdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a6.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " and a1.productname like '%". $_REQUEST['productname']."%' 
and a2.uomcode like '%". $_REQUEST['uomcode']."%' 
and a3.sloccode like '%". $_REQUEST['sloccode']."%' 
and a4.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['productconvertid']))
			{
				if (($_REQUEST['productconvertid'] !== '0') && ($_REQUEST['productconvertid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productconvertid in (".$_REQUEST['productconvertid'].")";
					}
					else
					{
						$where .= " and a0.productconvertid in (".$_REQUEST['productconvertid'].")";
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
			'keyField'=>'productconvertid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productconvertid','productconversionid','qty','uomid','slocid','storagebinid','recordstatus'
				),
				'defaultOrder' => array( 
					'productconvertid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productconvertid']))
		{
			$this->sqlcountproductconvertdetail .= ' where a0.productconvertid = '.$_REQUEST['productconvertid'];
			$this->sqldataproductconvertdetail .= ' where a0.productconvertid = '.$_REQUEST['productconvertid'];
		}
		$countproductconvertdetail = Yii::app()->db->createCommand($this->sqlcountproductconvertdetail)->queryScalar();
$dataProviderproductconvertdetail=new CSqlDataProvider($this->sqldataproductconvertdetail,array(
					'totalItemCount'=>$countproductconvertdetail,
					'keyField'=>'productconvertdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productconvertdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductconvertdetail'=>$dataProviderproductconvertdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into productconvert (recordstatus) values (".$this->findstatusbyuser('insconvert').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'productconvertid'=>$id,
			"qty" =>0,
      "recordstatus" =>$this->findstatusbyuser("insconvert")
		));
	}
  public function actionCreateproductconvertdetail()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productconvertid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'productconvertid'=>$model['productconvertid'],
          'productconversionid'=>$model['productconversionid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],

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

  public function actionUpdateproductconvertdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductconvertdetail.' where productconvertdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
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
			array('productconversionid','string','emptyproductconversionid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productconvertid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateProductConvert (:productconvertid
,:productconversionid
,:qty
,:uomid
,:slocid
,:storagebinid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':productconvertid',$_POST['productconvertid'],PDO::PARAM_STR);
				$command->bindvalue(':productconversionid',(($_POST['productconversionid']!=='')?$_POST['productconversionid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
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
public function actionSaveproductconvertdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('qty','string','emptyqty'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productconvertdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update productconvertdetail 
			      set productid = :productid,qty = :qty,uomid = :uomid,slocid = :slocid,storagebinid = :storagebinid 
			      where productconvertdetailid = :productconvertdetailid';
				}
				else
				{
					$sql = 'insert into productconvertdetail (productid,qty,uomid,slocid,storagebinid) 
			      values (:productid,:qty,:uomid,:slocid,:storagebinid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':productconvertdetailid',$_POST['productconvertdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveconvert(:vid,:vcreatedby)';
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
				$sql = 'call Deleteconvert(:vid,:vcreatedby)';
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
				$sql = "delete from productconvert where productconvertid = ".$id[$i];
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
	}public function actionPurgeproductconvertdetail()
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
				$sql = "delete from productconvertdetail where productconvertdetailid = ".$id[$i];
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
		$sql = "select a.productconvertid,c.productname,a.qty,d.uomcode,e.sloccode,f.description as rak
						from productconvert a
						left join productconversion b on b.productconversionid = a.productconversionid
						left join product c on c.productid = b.productid
						left join unitofmeasure d on d.unitofmeasureid = a.uomid
						left join sloc e on e.slocid = a.slocid
						left join storagebin f on f.storagebinid = a.storagebinid ";
		if ($_GET['productconvertid'] !== '') 
		{
				$sql = $sql . "where a.productconvertid in (".$_GET['productconvertid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->pdf->title=$this->getcatalog('productconvert');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNBPages();
	  // definisi font
	  

    foreach($dataReader as $row)		
		{
			$this->pdf->setFont('Arial','',10);
			$this->pdf->SetFontSize(8);
      $this->pdf->text(15,$this->pdf->gety()+5,'Kode Gudang');
			$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['sloccode']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Qty');
			$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['qty']);
      $this->pdf->text(15,$this->pdf->gety()+15,'Material / Service');
			$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['productname']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Kode Satuan');
			$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['uomcode']);
      $this->pdf->text(15,$this->pdf->gety()+25,'Rak');
			$this->pdf->text(50,$this->pdf->gety()+25,': '.$row['rak']);			
			
			$sql1 = "select a.productconvertdetailid,b.productname,a.qty,c.uomcode,d.sloccode,e.description as rak
							from productconvertdetail a
							left join product b on b.productid = a.productid
							left join unitofmeasure c on c.unitofmeasureid = a.uomid
							left join sloc d on d.slocid = a.slocid
							left join storagebin e on e.storagebinid = a.storagebinid
							where productconvertid = ".$row['productconvertid']." order by productconvertdetailid ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+30);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->setwidths(array(10,85,15,15,33,33));
			$this->pdf->colheader = array('No','Material / Service','Qty','Satuan','Gudang','Rak Tujuan');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('C','L','C','C','C','C');
      $i=0;
      foreach($dataReader1 as $row1)
			{
				$i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				$row1['qty'],
				$row1['uomcode'],
				$row1['sloccode'],
				$row1['rak']));
			}
			$this->pdf->sety($this->pdf->gety());			
			$this->pdf->checkNewPage(10);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+5);
			
		}
		$this->pdf->text(25,$this->pdf->gety()+10,'Approved By');$this->pdf->text(150,$this->pdf->gety()+10,'Proposed By');
    $this->pdf->text(25,$this->pdf->gety()+30,'____________ ');$this->pdf->text(150,$this->pdf->gety()+30,'____________');
			
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productconvertid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productconvertid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(3, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['description'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}