<?php

class ProductconversionController extends AdminController
{
	protected $menuname = 'productconversion';
	public $module = 'Common';
	protected $pageTitle = 'Material / Service Konversi Unit';
	public $wfname = '';
	protected $sqldata = "select a0.productconversionid,a0.productid,a0.qty,a0.uomid,a0.recordstatus,a1.productname as productname,a2.uomcode as uomcode 
    from productconversion a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqldataproductconversiondetail = "select a0.productconversiondetailid,a0.productconversionid,a0.productid,a0.qty,a0.uomid,a1.productname as productname,a2.uomcode as uomcode 
    from productconversiondetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
  protected $sqlcount = "select count(1) 
    from productconversion a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqlcountproductconversiondetail = "select count(1) 
    from productconversiondetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])))
		{				
			$where .= " where a1.productname like '%". $_REQUEST['productname']."%' 
and a2.uomcode like '%". $_REQUEST['uomcode']."%'"; 
		}
		if (isset($_REQUEST['productconversionid']))
			{
				if (($_REQUEST['productconversionid'] !== '0') && ($_REQUEST['productconversionid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productconversionid in (".$_REQUEST['productconversionid'].")";
					}
					else
					{
						$where .= " and a0.productconversionid in (".$_REQUEST['productconversionid'].")";
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
			'keyField'=>'productconversionid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productconversionid','productid','qty','uomid','recordstatus'
				),
				'defaultOrder' => array( 
					'productconversionid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productconversionid']))
		{
			$this->sqlcountproductconversiondetail .= ' where a0.productconversionid = '.$_REQUEST['productconversionid'];
			$this->sqldataproductconversiondetail .= ' where a0.productconversionid = '.$_REQUEST['productconversionid'];
		}
		$countproductconversiondetail = Yii::app()->db->createCommand($this->sqlcountproductconversiondetail)->queryScalar();
$dataProviderproductconversiondetail=new CSqlDataProvider($this->sqldataproductconversiondetail,array(
					'totalItemCount'=>$countproductconversiondetail,
					'keyField'=>'productconversiondetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'productconversiondetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductconversiondetail'=>$dataProviderproductconversiondetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into productconversion (recordstatus) values (1)";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'productconversionid'=>$id,
			"qty" =>0
		));
	}
  public function actionCreateproductconversiondetail()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productconversionid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productconversionid'=>$model['productconversionid'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'recordstatus'=>$model['recordstatus'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],

				));
				Yii::app()->end();
			}
		}
	}

  public function actionUpdateproductconversiondetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductconversiondetail.' where productconversiondetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productconversiondetailid'=>$model['productconversiondetailid'],
          'productconversionid'=>$model['productconversionid'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'productname'=>$model['productname'],
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
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productconversionid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateProductConversion (:productconversionid
,:productid
,:qty
,:uomid
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':productconversionid',$_POST['productconversionid'],PDO::PARAM_STR);
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
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
public function actionSaveproductconversiondetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productconversiondetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update productconversiondetail 
			      set productconversionid = :productconversionid,productid = :productid,qty = :qty,uomid = :uomid 
			      where productconversiondetailid = :productconversiondetailid';
				}
				else
				{
					$sql = 'insert into productconversiondetail (productconversionid,productid,qty,uomid) 
			      values (:productconversionid,:productid,:qty,:uomid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':productconversiondetailid',$_POST['productconversiondetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productconversionid',(($_POST['productconversionid']!=='')?$_POST['productconversionid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from productconversion where productconversionid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update productconversion set recordstatus = 0 where productconversionid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update productconversion set recordstatus = 1 where productconversionid = ".$id[$i];
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
				$sql = "delete from productconversion where productconversionid = ".$id[$i];
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
	}public function actionPurgeproductconversiondetail()
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
				$sql = "delete from productconversiondetail where productconversiondetailid = ".$id[$i];
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

		//masukkan judul
		$this->pdf->title=$this->getCatalog('productconversion');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('productconversionid'),$this->getCatalog('product'),$this->getCatalog('qty'),$this->getCatalog('uom'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productconversionid'],$row1['productname'],$row1['qty'],$row1['uomcode'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productconversionid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productconversionid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(3, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}