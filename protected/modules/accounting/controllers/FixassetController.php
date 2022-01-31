<?php

class FixassetController extends AdminController
{
	protected $menuname = 'fixasset';
	public $module = 'Accounting';
	protected $pageTitle = 'Fix Asset';
	public $wfname = '';
	protected $sqldata = "select a0.fixassetid,a0.companyid,a0.assetno,a0.slocaccid,a0.buydate,a0.productid,a0.qty,a0.uomid,a0.price,a0.nilairesidu,a0.metode,a0.currencyid,a0.currencyrate,a0.umur,a0.recordstatus,a1.companyname as companyname,a6.sloccode as sloccode,a3.productname as productname,a4.uomcode as uomcode,a5.currencyname as currencyname 
    from fixasset a0 
    left join company a1 on a1.companyid = a0.companyid
    left join slocaccounting a2 on a2.slocaccid = a0.slocaccid
    left join product a3 on a3.productid = a0.productid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
    left join currency a5 on a5.currencyid = a0.currencyid 
		left join sloc a6 on a6.slocid = a2.slocid 
  ";
  protected $sqlcount = "select count(1) 
    from fixasset a0 
    left join company a1 on a1.companyid = a0.companyid
    left join slocaccounting a2 on a2.slocaccid = a0.slocaccid
    left join product a3 on a3.productid = a0.productid
    left join unitofmeasure a4 on a4.unitofmeasureid = a0.uomid
    left join currency a5 on a5.currencyid = a0.currencyid
		left join sloc a6 on a6.slocid = a2.slocid 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['assetno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['sloccode'])) && (isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .= " where a0.assetno like '%". $_REQUEST['assetno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a6.sloccode like '%". $_REQUEST['sloccode']."%' 
and a3.productname like '%". $_REQUEST['productname']."%' 
and a4.uomcode like '%". $_REQUEST['uomcode']."%' 
and a5.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['fixassetid']))
			{
				if (($_REQUEST['fixassetid'] !== '0') && ($_REQUEST['fixassetid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.fixassetid in (".$_REQUEST['fixassetid'].")";
					}
					else
					{
						$where .= " and a0.fixassetid in (".$_REQUEST['fixassetid'].")";
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
			'keyField'=>'fixassetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'fixassetid','companyid','assetno','slocaccid','buydate','productid','qty','uomid','price','nilairesidu','metode','currencyid','currencyrate','umur','recordstatus'
				),
				'defaultOrder' => array( 
					'fixassetid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"buydate" =>date("Y-m-d"),
      "qty" =>0,
      "price" =>0,
      "nilairesidu" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>1,
      "umur" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.fixassetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'fixassetid'=>$model['fixassetid'],
          'companyid'=>$model['companyid'],
          'assetno'=>$model['assetno'],
          'slocaccid'=>$model['slocaccid'],
          'buydate'=>$model['buydate'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'price'=>$model['price'],
          'nilairesidu'=>$model['nilairesidu'],
          'metode'=>$model['metode'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'umur'=>$model['umur'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'sloccode'=>$model['sloccode'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
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
			array('companyid','string','emptycompanyid'),
      array('assetno','string','emptyassetno'),
      array('slocaccid','string','emptyslocaccid'),
      array('buydate','string','emptybuydate'),
      array('productid','string','emptyproductid'),
      array('qty','string','emptyqty'),
      array('uomid','string','emptyuomid'),
      array('price','string','emptyprice'),
      array('nilairesidu','string','emptynilairesidu'),
      array('metode','string','emptymetode'),
      array('currencyid','string','emptycurrencyid'),
      array('currencyrate','string','emptycurrencyrate'),
      array('umur','string','emptyumur'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['fixassetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update fixasset 
			      set companyid = :companyid,assetno = :assetno,slocaccid = :slocaccid,buydate = :buydate,productid = :productid,qty = :qty,uomid = :uomid,price = :price,nilairesidu = :nilairesidu,metode = :metode,currencyid = :currencyid,currencyrate = :currencyrate,umur = :umur,recordstatus = :recordstatus 
			      where fixassetid = :fixassetid';
				}
				else
				{
					$sql = 'insert into fixasset (companyid,assetno,slocaccid,buydate,productid,qty,uomid,price,nilairesidu,metode,currencyid,currencyrate,umur,recordstatus) 
			      values (:companyid,:assetno,:slocaccid,:buydate,:productid,:qty,:uomid,:price,:nilairesidu,:metode,:currencyid,:currencyrate,:umur,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':fixassetid',$_POST['fixassetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':assetno',(($_POST['assetno']!=='')?$_POST['assetno']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocaccid',(($_POST['slocaccid']!=='')?$_POST['slocaccid']:null),PDO::PARAM_STR);
        $command->bindvalue(':buydate',(($_POST['buydate']!=='')?$_POST['buydate']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':price',(($_POST['price']!=='')?$_POST['price']:null),PDO::PARAM_STR);
        $command->bindvalue(':nilairesidu',(($_POST['nilairesidu']!=='')?$_POST['nilairesidu']:null),PDO::PARAM_STR);
        $command->bindvalue(':metode',(($_POST['metode']!=='')?$_POST['metode']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':umur',(($_POST['umur']!=='')?$_POST['umur']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from fixasset where fixassetid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update fixasset set recordstatus = 0 where fixassetid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update fixasset set recordstatus = 1 where fixassetid = ".$id[$i];
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
				$sql = "delete from fixasset where fixassetid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('fixasset');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('fixassetid'),$this->getCatalog('company'),$this->getCatalog('assetno'),$this->getCatalog('slocacc'),$this->getCatalog('buydate'),$this->getCatalog('product'),$this->getCatalog('qty'),$this->getCatalog('uom'),$this->getCatalog('price'),$this->getCatalog('nilairesi'),$this->getCatalog('metode'),$this->getCatalog('currency'),$this->getCatalog('currencyrate'),$this->getCatalog('umur'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,15,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['fixassetid'],$row1['companyname'],$row1['assetno'],$row1['sloccode'],$row1['buydate'],$row1['productname'],$row1['qty'],$row1['uomcode'],$row1['price'],$row1['nilairesidu'],$row1['metode'],$row1['currencyname'],$row1['currencyrate'],$row1['umur'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('fixassetid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('assetno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('buydate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('qty'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('price'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('nilairesidu'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('metode'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('umur'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['fixassetid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['assetno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['buydate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['qty'])
->setCellValueByColumnAndRow(7, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(8, $i+1, $row1['price'])
->setCellValueByColumnAndRow(9, $i+1, $row1['nilairesidu'])
->setCellValueByColumnAndRow(10, $i+1, $row1['metode'])
->setCellValueByColumnAndRow(11, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(12, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(13, $i+1, $row1['umur'])
->setCellValueByColumnAndRow(14, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}