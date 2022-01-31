<?php

class AddressbookController extends AdminController
{
	protected $menuname = 'addressbook';
	public $module = 'Common';
	protected $pageTitle = 'Pihak ke 3';
	public $wfname = '';
	protected $sqldata = "select a0.addressbookid,a0.fullname,a0.iscustomer,a0.isemployee,a0.isvendor,a0.ishospital,a0.currentlimit,a0.currentdebt,a0.taxno,a0.creditlimit,a0.isstrictlimit,a0.bankname,a0.bankaccountno,a0.accountowner,a0.salesareaid,a0.pricecategoryid,a0.overdue,a0.invoicedate,a0.recordstatus,a1.areaname as areaname,a2.categoryname as categoryname 
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
  ";
  protected $sqlcount = "select count(1) 
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['fullname'])))
		{				
			$where .= " where a0.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
		if (isset($_REQUEST['addressbookid']))
			{
				if (($_REQUEST['addressbookid'] !== '0') && ($_REQUEST['addressbookid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.addressbookid in (".$_REQUEST['addressbookid'].")";
					}
					else
					{
						$where .= " and a0.addressbookid in (".$_REQUEST['addressbookid'].")";
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
			'keyField'=>'addressbookid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'addressbookid','fullname','iscustomer','isemployee','isvendor','ishospital','currentlimit','currentdebt','taxno','creditlimit','isstrictlimit','bankname','bankaccountno','accountowner','salesareaid','pricecategoryid','overdue','invoicedate','recordstatus'
				),
				'defaultOrder' => array( 
					'addressbookid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"currentlimit" =>0,
      "currentdebt" =>0,
      "creditlimit" =>0,
      "invoicedate" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.addressbookid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addressbookid'=>$model['addressbookid'],
          'fullname'=>$model['fullname'],
          'iscustomer'=>$model['iscustomer'],
          'isemployee'=>$model['isemployee'],
          'isvendor'=>$model['isvendor'],
          'ishospital'=>$model['ishospital'],
          'currentlimit'=>$model['currentlimit'],
          'currentdebt'=>$model['currentdebt'],
          'taxno'=>$model['taxno'],
          'creditlimit'=>$model['creditlimit'],
          'isstrictlimit'=>$model['isstrictlimit'],
          'bankname'=>$model['bankname'],
          'bankaccountno'=>$model['bankaccountno'],
          'accountowner'=>$model['accountowner'],
          'salesareaid'=>$model['salesareaid'],
          'pricecategoryid'=>$model['pricecategoryid'],
          'overdue'=>$model['overdue'],
          'invoicedate'=>$model['invoicedate'],
          'recordstatus'=>$model['recordstatus'],
          'areaname'=>$model['areaname'],
          'categoryname'=>$model['categoryname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('fullname','string','emptyfullname'),
      array('currentlimit','string','emptycurrentlimit'),
      array('currentdebt','string','emptycurrentdebt'),
      array('taxno','string','emptytaxno'),
      array('creditlimit','string','emptycreditlimit'),
      array('isstrictlimit','string','emptyisstrictlimit'),
      array('bankname','string','emptybankname'),
      array('bankaccountno','string','emptybankaccountno'),
      array('accountowner','string','emptyaccountowner'),
      array('overdue','string','emptyoverdue'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressbookid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update addressbook 
			      set fullname = :fullname,iscustomer = :iscustomer,isemployee = :isemployee,isvendor = :isvendor,ishospital = :ishospital,currentlimit = :currentlimit,currentdebt = :currentdebt,taxno = :taxno,creditlimit = :creditlimit,isstrictlimit = :isstrictlimit,bankname = :bankname,bankaccountno = :bankaccountno,accountowner = :accountowner,salesareaid = :salesareaid,pricecategoryid = :pricecategoryid,overdue = :overdue,invoicedate = :invoicedate,recordstatus = :recordstatus 
			      where addressbookid = :addressbookid';
				}
				else
				{
					$sql = 'insert into addressbook (fullname,iscustomer,isemployee,isvendor,ishospital,currentlimit,currentdebt,taxno,creditlimit,isstrictlimit,bankname,bankaccountno,accountowner,salesareaid,pricecategoryid,overdue,invoicedate,recordstatus) 
			      values (:fullname,:iscustomer,:isemployee,:isvendor,:ishospital,:currentlimit,:currentdebt,:taxno,:creditlimit,:isstrictlimit,:bankname,:bankaccountno,:accountowner,:salesareaid,:pricecategoryid,:overdue,:invoicedate,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addressbookid',$_POST['addressbookid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':fullname',(($_POST['fullname']!=='')?$_POST['fullname']:null),PDO::PARAM_STR);
        $command->bindvalue(':iscustomer',(($_POST['iscustomer']!=='')?$_POST['iscustomer']:null),PDO::PARAM_STR);
        $command->bindvalue(':isemployee',(($_POST['isemployee']!=='')?$_POST['isemployee']:null),PDO::PARAM_STR);
        $command->bindvalue(':isvendor',(($_POST['isvendor']!=='')?$_POST['isvendor']:null),PDO::PARAM_STR);
        $command->bindvalue(':ishospital',(($_POST['ishospital']!=='')?$_POST['ishospital']:null),PDO::PARAM_STR);
        $command->bindvalue(':currentlimit',(($_POST['currentlimit']!=='')?$_POST['currentlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':currentdebt',(($_POST['currentdebt']!=='')?$_POST['currentdebt']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':creditlimit',(($_POST['creditlimit']!=='')?$_POST['creditlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':isstrictlimit',(($_POST['isstrictlimit']!=='')?$_POST['isstrictlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankname',(($_POST['bankname']!=='')?$_POST['bankname']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankaccountno',(($_POST['bankaccountno']!=='')?$_POST['bankaccountno']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountowner',(($_POST['accountowner']!=='')?$_POST['accountowner']:null),PDO::PARAM_STR);
        $command->bindvalue(':salesareaid',(($_POST['salesareaid']!=='')?$_POST['salesareaid']:null),PDO::PARAM_STR);
        $command->bindvalue(':pricecategoryid',(($_POST['pricecategoryid']!=='')?$_POST['pricecategoryid']:null),PDO::PARAM_STR);
        $command->bindvalue(':overdue',(($_POST['overdue']!=='')?$_POST['overdue']:null),PDO::PARAM_STR);
        $command->bindvalue(':invoicedate',(($_POST['invoicedate']!=='')?$_POST['invoicedate']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from addressbook where addressbookid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update addressbook set recordstatus = 0 where addressbookid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update addressbook set recordstatus = 1 where addressbookid = ".$id[$i];
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
				$sql = "delete from addressbook where addressbookid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('addressbook');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('addressbookid'),$this->getCatalog('fullname'),$this->getCatalog('iscustomer'),$this->getCatalog('isemployee'),$this->getCatalog('isvendor'),$this->getCatalog('ishospital'),$this->getCatalog('currentlimit'),$this->getCatalog('currentdebt'),$this->getCatalog('taxno'),$this->getCatalog('creditlimit'),$this->getCatalog('isstrictlimit'),$this->getCatalog('bankname'),$this->getCatalog('bankaccountno'),$this->getCatalog('accountowner'),$this->getCatalog('salesarea'),$this->getCatalog('pricecategory'),$this->getCatalog('overdue'),$this->getCatalog('invoicedate'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15,15,15,15,40,40,40,40,15,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['addressbookid'],$row1['fullname'],$row1['iscustomer'],$row1['isemployee'],$row1['isvendor'],$row1['ishospital'],$row1['currentlimit'],$row1['currentdebt'],$row1['taxno'],$row1['creditlimit'],$row1['isstrictlimit'],$row1['bankname'],$row1['bankaccountno'],$row1['accountowner'],$row1['areaname'],$row1['categoryname'],$row1['overdue'],$row1['invoicedate'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('addressbookid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('iscustomer'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('isemployee'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('isvendor'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('ishospital'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currentlimit'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('currentdebt'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('taxno'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('creditlimit'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('isstrictlimit'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('bankname'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('bankaccountno'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('accountowner'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('areaname'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('categoryname'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('overdue'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('invoicedate'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['addressbookid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['iscustomer'])
->setCellValueByColumnAndRow(3, $i+1, $row1['isemployee'])
->setCellValueByColumnAndRow(4, $i+1, $row1['isvendor'])
->setCellValueByColumnAndRow(5, $i+1, $row1['ishospital'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currentlimit'])
->setCellValueByColumnAndRow(7, $i+1, $row1['currentdebt'])
->setCellValueByColumnAndRow(8, $i+1, $row1['taxno'])
->setCellValueByColumnAndRow(9, $i+1, $row1['creditlimit'])
->setCellValueByColumnAndRow(10, $i+1, $row1['isstrictlimit'])
->setCellValueByColumnAndRow(11, $i+1, $row1['bankname'])
->setCellValueByColumnAndRow(12, $i+1, $row1['bankaccountno'])
->setCellValueByColumnAndRow(13, $i+1, $row1['accountowner'])
->setCellValueByColumnAndRow(14, $i+1, $row1['areaname'])
->setCellValueByColumnAndRow(15, $i+1, $row1['categoryname'])
->setCellValueByColumnAndRow(16, $i+1, $row1['overdue'])
->setCellValueByColumnAndRow(17, $i+1, $row1['invoicedate'])
->setCellValueByColumnAndRow(18, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}