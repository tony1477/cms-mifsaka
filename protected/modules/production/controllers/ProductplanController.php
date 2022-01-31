<?php

class ProductplanController extends AdminController
{
	protected $menuname = 'productplan';
	public $module = 'Production';
	protected $pageTitle = 'Surat Perintah Produksi (SPP)';
	public $wfname = 'appprodplan';
	protected $sqldata = "select a0.productplanid,a0.companyid,a0.soheaderid,a0.productplanno,a0.productplandate,a0.description,a0.recordstatus,a0.isbarcode,a1.companyname as companyname,a2.sono as sono,a0.statusname  
    from productplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join soheader a2 on a2.soheaderid = a0.soheaderid
  ";
protected $sqldataproductplanfg = "select a0.productplanfgid,a0.productplanid,a0.productid,a0.qty,a0.uomid,a0.slocid,a0.bomid,a0.startdate,a0.enddate,a0.qtyres,a0.description,a0.sodetailid,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.bomversion as bomversion 
    from productplanfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid = a0.bomid
  ";
protected $sqldataproductplandetail = "select a0.productplandetailid,a0.productplanid,a0.productplanfgid,a0.productid,a0.qty,a0.uomid,a0.fromslocid,a0.toslocid,a0.bomid,a0.reqdate,a0.qtyres,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.sloccode as toslocid 
    from productplandetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.fromslocid
    left join sloc a4 on a4.slocid = a0.toslocid
  ";
  protected $sqlcount = "select count(1) 
    from productplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join soheader a2 on a2.soheaderid = a0.soheaderid
  ";
protected $sqlcountproductplanfg = "select count(1) 
    from productplanfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid = a0.bomid
  ";
protected $sqlcountproductplandetail = "select count(1) 
    from productplandetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.fromslocid
    left join sloc a4 on a4.slocid = a0.toslocid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appprodplan')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listprodplan').") 
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectWfValues('company','appprodplan').")";
		if ((isset($_REQUEST['productplanno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['sono'])))
		{				
			$where .=  " 
and a0.productplanno like '%". $_REQUEST['productplanno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.sono like '%". $_REQUEST['sono']."%'"; 
		}
		if (isset($_REQUEST['productplanid']))
			{
				if (($_REQUEST['productplanid'] !== '0') && ($_REQUEST['productplanid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productplanid in (".$_REQUEST['productplanid'].")";
					}
					else
					{
						$where .= " and a0.productplanid in (".$_REQUEST['productplanid'].")";
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
			'keyField'=>'productplanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productplanid','companyid','soheaderid','productplanno','productplandate','description','recordstatus','isbarcode'
				),
				'defaultOrder' => array( 
					'productplanid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productplanid']))
		{
			$this->sqlcountproductplanfg .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$this->sqldataproductplanfg .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$count = Yii::app()->db->createCommand($this->sqlcountproductplanfg)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldataproductplanfg .= " limit 0";
		}
		$countproductplanfg = $count;
		$dataProviderproductplanfg=new CSqlDataProvider($this->sqldataproductplanfg,array(
			'totalItemCount'=>$countproductplanfg,
			'keyField'=>'productplanfgid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'productplanfgid' => CSort::SORT_DESC
				),
			),
			));
			
		if (isset($_REQUEST['productplanid']))
		{
			$this->sqlcountproductplandetail .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$this->sqldataproductplandetail .= ' where a0.productplanid = '.$_REQUEST['productplanid'];
			$count = Yii::app()->db->createCommand($this->sqlcountproductplandetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldataproductplandetail .= " limit 0";
		}
		$countproductplandetail = $count;
		$dataProviderproductplandetail=new CSqlDataProvider($this->sqldataproductplandetail,array(
			'totalItemCount'=>$countproductplandetail,
			'keyField'=>'productplandetailid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'productplandetailid' => CSort::SORT_DESC
				),
			),
			));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductplanfg'=>$dataProviderproductplanfg,'dataProviderproductplandetail'=>$dataProviderproductplandetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into productplan (recordstatus) values (".$this->findstatusbyuser('insprodplan').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'productplanid'=>$id,
			"productplandate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insprodplan")
		));
	}
  public function actionCreateproductplanfg()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "startdate" =>date("Y-m-d"),
      "enddate" =>date("Y-m-d"),
      "qtyres" =>0
		));
	}
  public function actionCreateproductplandetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "reqdate" =>date("Y-m-d"),
      "qtyres" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productplanid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'productplanid'=>$model['productplanid'],
          'companyid'=>$model['companyid'],
          'soheaderid'=>$model['soheaderid'],
          'productplandate'=>$model['productplandate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'sono'=>$model['sono'],

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

  public function actionUpdateproductplanfg()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductplanfg.' where productplanfgid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'bomid'=>$model['bomid'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'qtyres'=>$model['qtyres'],
          'description'=>$model['description'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'bomversion'=>$model['bomversion'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateproductplandetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductplandetail.' where productplandetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'fromslocid'=>$model['fromslocid'],
          'toslocid'=>$model['toslocid'],
          'reqdate'=>$model['reqdate'],
          'qtyres'=>$model['qtyres'],
          'description'=>$model['description'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'toslocid'=>$model['toslocid'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
			array('productplandate','string','emptyproductplandate'),
    ));
		if ($error == false)
		{
			$id = $_POST['productplanid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateProductPlan (:productplanid
,:companyid
,:soheaderid
,:productplandate
,:description
,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':productplanid',$_POST['productplanid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':soheaderid',(($_POST['soheaderid']!=='')?$_POST['soheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productplandate',(($_POST['productplandate']!=='')?$_POST['productplandate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
public function actionSaveproductplanfg()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('bomid','string','emptybomid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productplanfgid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call UpdateProductPlanFG (:productplanfgid
,:companyid
,:productplanid
,:productid
,:qty
,:uomid
,:slocid
,:bomid
,:startdate
,:enddate
,:description
,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertProductPlanFG (:companyid
,:productplanid
,:productid
,:qty
,:uomid
,:slocid
,:bomid
,:startdate
,:enddate
,:description
,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':productplanfgid',$_POST['productplanfgid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':bomid',(($_POST['bomid']!=='')?$_POST['bomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':startdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':enddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
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
				
public function actionSaveproductplandetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productplanid','string','emptyproductplanid'),
      array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('fromslocid','string','emptyfromslocid'),
      array('toslocid','string','emptytoslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productplandetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update productplandetail 
			      set productid = :productid,qty = :qty,uomid = :uomid,fromslocid = :fromslocid,toslocid = :toslocid,reqdate = :reqdate,qtyres = :qtyres,description = :description 
			      where productplandetailid = :productplandetailid';
				}
				else
				{
					$sql = 'insert into productplandetail (productid,qty,uomid,fromslocid,toslocid,reqdate,qtyres,description) 
			      values (:productid,:qty,:uomid,:fromslocid,:toslocid,:reqdate,:qtyres,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':productplandetailid',$_POST['productplandetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':fromslocid',(($_POST['fromslocid']!=='')?$_POST['fromslocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':toslocid',(($_POST['toslocid']!=='')?$_POST['toslocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':reqdate',(($_POST['reqdate']!=='')?$_POST['reqdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':qtyres',(($_POST['qtyres']!=='')?$_POST['qtyres']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveproductplan(:vid,:vcreatedby)';
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
				$sql = 'call Deleteproductplan(:vid,:vcreatedby)';
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
				$sql = "delete from productplan where productplanid = ".$id[$i];
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
	}public function actionPurgeproductplanfg()
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
				$sql = "delete from productplanfg where productplanfgid = ".$id[$i];
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
	}public function actionPurgeproductplandetail()
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
				$sql = "delete from productplandetail where productplandetailid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('productplan');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('productplanid'),$this->getCatalog('company'),$this->getCatalog('soheader'),$this->getCatalog('productplanno'),$this->getCatalog('productplandate'),$this->getCatalog('description'),$this->getCatalog('recordstatus'),$this->getCatalog('isbarcode'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productplanid'],$row1['companyname'],$row1['sono'],$row1['productplanno'],$row1['productplandate'],$row1['description'],$row1['recordstatus'],$row1['isbarcode']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productplanid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sono'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('productplanno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('productplandate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('isbarcode'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['productplanid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sono'])
->setCellValueByColumnAndRow(3, $i+1, $row1['productplanno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['productplandate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['description'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(7, $i+1, $row1['isbarcode']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}