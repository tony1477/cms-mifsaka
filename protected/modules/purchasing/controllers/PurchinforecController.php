<?php

class PurchinforecController extends AdminController
{
	protected $menuname = 'purchinforec';
	public $module = 'Purchasing';
	protected $pageTitle = 'Penawaran / Sejarah Pembelian';
	public $wfname = '';
	protected $sqldata = "select a0.purchinforecid,a0.addressbookid,a0.productid,a0.deliverytime,a0.purchasinggroupid,a0.underdelvtol,a0.overdelvtol,a0.price,a0.currencyid,a0.biddate,a0.recordstatus,a1.fullname as fullname,a2.productname as productname,a3.purchasinggroupcode as purchasinggroupcode,a4.currencyname as currencyname 
    from purchinforec a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join product a2 on a2.productid = a0.productid
    left join purchasinggroup a3 on a3.purchasinggroupid = a0.purchasinggroupid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from purchinforec a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join product a2 on a2.productid = a0.productid
    left join purchasinggroup a3 on a3.purchasinggroupid = a0.purchasinggroupid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['productname'])) && (isset($_REQUEST['currencyname'])) && (isset($_REQUEST['startdate'])) && (isset($_REQUEST['enddate'])) )
		{				
			$where .= " where a1.fullname like '%". $_REQUEST['fullname']."%' 
and a2.productname like '%". $_REQUEST['productname']."%' 
and a4.currencyname like '%". $_REQUEST['currencyname']."%'
and a0.biddate between '" . date(Yii::app()->params['datetodb'], strtotime($_REQUEST['startdate'])) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($_REQUEST['enddate'])) . "'"; 
		}
		if (isset($_REQUEST['purchinforecid']))
			{
				if (($_REQUEST['purchinforecid'] !== '0') && ($_REQUEST['purchinforecid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.purchinforecid in (".$_REQUEST['purchinforecid'].")";
					}
					else
					{
						$where .= " and a0.purchinforecid in (".$_REQUEST['purchinforecid'].")";
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
			'keyField'=>'purchinforecid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'purchinforecid','addressbookid','productid','deliverytime','purchasinggroupid','underdelvtol','overdelvtol','price','currencyid','biddate','recordstatus'
				),
				'defaultOrder' => array( 
					'purchinforecid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"price" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "biddate" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.purchinforecid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'purchinforecid'=>$model['purchinforecid'],
          'addressbookid'=>$model['addressbookid'],
          'productid'=>$model['productid'],
          'deliverytime'=>$model['deliverytime'],
          'purchasinggroupid'=>$model['purchasinggroupid'],
          'underdelvtol'=>$model['underdelvtol'],
          'overdelvtol'=>$model['overdelvtol'],
          'price'=>$model['price'],
          'currencyid'=>$model['currencyid'],
          'biddate'=>$model['biddate'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'productname'=>$model['productname'],
          'purchasinggroupcode'=>$model['purchasinggroupcode'],
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
			array('addressbookid','string','emptyaddressbookid'),
      array('productid','string','emptyproductid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['purchinforecid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update purchinforec 
			      set addressbookid = :addressbookid,productid = :productid,deliverytime = :deliverytime,purchasinggroupid = :purchasinggroupid,underdelvtol = :underdelvtol,overdelvtol = :overdelvtol,price = :price,currencyid = :currencyid,biddate = :biddate,recordstatus = :recordstatus 
			      where purchinforecid = :purchinforecid';
				}
				else
				{
					$sql = 'insert into purchinforec (addressbookid,productid,deliverytime,purchasinggroupid,underdelvtol,overdelvtol,price,currencyid,biddate,recordstatus) 
			      values (:addressbookid,:productid,:deliverytime,:purchasinggroupid,:underdelvtol,:overdelvtol,:price,:currencyid,:biddate,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':purchinforecid',$_POST['purchinforecid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':deliverytime',(($_POST['deliverytime']!=='')?$_POST['deliverytime']:null),PDO::PARAM_STR);
        $command->bindvalue(':purchasinggroupid',(($_POST['purchasinggroupid']!=='')?$_POST['purchasinggroupid']:null),PDO::PARAM_STR);
        $command->bindvalue(':underdelvtol',(($_POST['underdelvtol']!=='')?$_POST['underdelvtol']:null),PDO::PARAM_STR);
        $command->bindvalue(':overdelvtol',(($_POST['overdelvtol']!=='')?$_POST['overdelvtol']:null),PDO::PARAM_STR);
        $command->bindvalue(':price',(($_POST['price']!=='')?$_POST['price']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':biddate',(($_POST['biddate']!=='')?$_POST['biddate']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from purchinforec where purchinforecid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update purchinforec set recordstatus = 0 where purchinforecid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update purchinforec set recordstatus = 1 where purchinforecid = ".$id[$i];
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
				$sql = "delete from purchinforec where purchinforecid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('purchinforec');
		$this->pdf->AddPage('L');
        $this->pdf->setFont('Arial', '', 8);
		$this->pdf->colalign = array('C','L','L','L','L','L','L','L','L','L','L');
		$this->pdf->colheader = array($this->getCatalog('purchinforecid'),$this->getCatalog('addressbook'),$this->getCatalog('product'),$this->getCatalog('deliverytime'),$this->getCatalog('underdelvtol'),$this->getCatalog('overdelvtol'),$this->getCatalog('price'),$this->getCatalog('biddate'));
		$this->pdf->setwidths(array(10,35,40,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('C','L','L','L','L','L','L','L','C','C','C');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['purchinforecid'],$row1['fullname'],$row1['productname'],$row1['deliverytime'],$row1['purchasinggroupcode'],$row1['underdelvtol'],$row1['overdelvtol'],$row1['price'],$row1['currencyname'],$row1['biddate']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('purchinforecid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('deliverytime'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('purchasinggroupcode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('underdelvtol'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('overdelvtol'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('price'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('biddate'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['purchinforecid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['deliverytime'])
->setCellValueByColumnAndRow(4, $i+1, $row1['purchasinggroupcode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['underdelvtol'])
->setCellValueByColumnAndRow(6, $i+1, $row1['overdelvtol'])
->setCellValueByColumnAndRow(7, $i+1, $row1['price'])
->setCellValueByColumnAndRow(8, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(9, $i+1, $row1['biddate'])
->setCellValueByColumnAndRow(10, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}