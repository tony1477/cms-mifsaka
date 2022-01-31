<?php

class InvoiceapController extends AdminController
{
	protected $menuname = 'invoiceap';
	public $module = 'Accounting';
	protected $pageTitle = 'Account Payable';
	public $wfname = 'appinvap';
	protected $sqldata = "select a0.invoiceapid,a0.companyid,a0.invoiceno,a0.invoicedate,a0.poheaderid,a0.addressbookid,a0.taxno,a0.taxdate,a0.amount,a0.currencyid,a0.currencyrate,a0.taxid,a0.paymentmethodid,a0.journalno,a0.recordstatus,a0.payamount,a0.receiptdate,a0.grheaderid,a1.companyname as companyname,a2.pono as pono,a3.fullname as fullname,a4.taxcode as taxcode,a5.currencyname as currencyname,a6.taxcode as taxcode,a7.paycode as paycode,a8.grno as grno,a0.statusname  
    from invoiceap a0 
    left join company a1 on a1.companyid = a0.companyid
    left join poheader a2 on a2.poheaderid = a0.poheaderid
    left join addressbook a3 on a3.addressbookid = a0.addressbookid
    left join tax a4 on a4.taxid = a0.taxno
    left join currency a5 on a5.currencyid = a0.currencyid
    left join tax a6 on a6.taxid = a0.taxid
    left join paymentmethod a7 on a7.paymentmethodid = a0.paymentmethodid
    left join grheader a8 on a8.grheaderid = a0.grheaderid
  ";
protected $sqldatainvoiceapmat = "select a0.invoiceapmatid,a0.invoiceapid,a0.podetailid,a0.productid,a0.uomid,a0.qty,a0.grdetailid,a1.productname as productname,a2.uomcode as uomcode 
    from invoiceapmat a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqldatainvoiceapjurnal = "select a0.invoiceapjurnalid,a0.invoiceapid,a0.accountid,a0.debet,a0.credit,a0.description,a0.currencyid,a0.currencyrate,a1.accountname as accountname,a2.currencyname as currencyname 
    from invoiceapjurnal a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from invoiceap a0 
    left join company a1 on a1.companyid = a0.companyid
    left join poheader a2 on a2.poheaderid = a0.poheaderid
    left join addressbook a3 on a3.addressbookid = a0.addressbookid
    left join tax a4 on a4.taxid = a0.taxno
    left join currency a5 on a5.currencyid = a0.currencyid
    left join tax a6 on a6.taxid = a0.taxid
    left join paymentmethod a7 on a7.paymentmethodid = a0.paymentmethodid
    left join grheader a8 on a8.grheaderid = a0.grheaderid
  ";
protected $sqlcountinvoiceapmat = "select count(1) 
    from invoiceapmat a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
  ";
protected $sqlcountinvoiceapjurnal = "select count(1) 
    from invoiceapjurnal a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appinvap')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listinvap').")
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['invoiceno'])) && (isset($_REQUEST['currencyrate'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['pono'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['taxcode'])) && (isset($_REQUEST['currencyname'])) && (isset($_REQUEST['taxcode'])) && (isset($_REQUEST['paycode'])) && (isset($_REQUEST['grno'])))
		{				
			$where .=  " 
and a0.invoiceno like '%". $_REQUEST['invoiceno']."%' 
and a0.currencyrate like '%". $_REQUEST['currencyrate']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.pono like '%". $_REQUEST['pono']."%' 
and a3.fullname like '%". $_REQUEST['fullname']."%' 
and a4.taxcode like '%". $_REQUEST['taxcode']."%' 
and a5.currencyname like '%". $_REQUEST['currencyname']."%' 
and a6.taxcode like '%". $_REQUEST['taxcode']."%' 
and a7.paycode like '%". $_REQUEST['paycode']."%' 
and a8.grno like '%". $_REQUEST['grno']."%'"; 
		}
		if (isset($_REQUEST['invoiceapid']))
			{
				if (($_REQUEST['invoiceapid'] !== '0') && ($_REQUEST['invoiceapid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.invoiceapid in (".$_REQUEST['invoiceapid'].")";
					}
					else
					{
						$where .= " and a0.invoiceapid in (".$_REQUEST['invoiceapid'].")";
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
			'keyField'=>'invoiceapid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'invoiceapid','companyid','invoiceno','invoicedate','poheaderid','addressbookid','taxno','taxdate','amount','currencyid','currencyrate','taxid','paymentmethodid','journalno','recordstatus','payamount','receiptdate','grheaderid'
				),
				'defaultOrder' => array( 
					'invoiceapid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['invoiceapid']))
		{
			$this->sqlcountinvoiceapmat .= ' where a0.invoiceapid = '.$_REQUEST['invoiceapid'];
			$this->sqldatainvoiceapmat .= ' where a0.invoiceapid = '.$_REQUEST['invoiceapid'];
		}
		$countinvoiceapmat = Yii::app()->db->createCommand($this->sqlcountinvoiceapmat)->queryScalar();
$dataProviderinvoiceapmat=new CSqlDataProvider($this->sqldatainvoiceapmat,array(
					'totalItemCount'=>$countinvoiceapmat,
					'keyField'=>'invoiceapmatid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'invoiceapmatid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['invoiceapid']))
		{
			$this->sqlcountinvoiceapjurnal .= ' where a0.invoiceapid = '.$_REQUEST['invoiceapid'];
			$this->sqldatainvoiceapjurnal .= ' where a0.invoiceapid = '.$_REQUEST['invoiceapid'];
		}
		$countinvoiceapjurnal = Yii::app()->db->createCommand($this->sqlcountinvoiceapjurnal)->queryScalar();
$dataProviderinvoiceapjurnal=new CSqlDataProvider($this->sqldatainvoiceapjurnal,array(
					'totalItemCount'=>$countinvoiceapjurnal,
					'keyField'=>'invoiceapjurnalid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'invoiceapjurnalid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderinvoiceapmat'=>$dataProviderinvoiceapmat,'dataProviderinvoiceapjurnal'=>$dataProviderinvoiceapjurnal));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into invoiceap (recordstatus) values (".$this->findstatusbyuser('insinvap').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'invoiceapid'=>$id,
			"invoicedate" =>date("Y-m-d"),
      "taxdate" =>date("Y-m-d"),
      "amount" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0,
      "recordstatus" =>$this->findstatusbyuser("insinvap"),
      "payamount" =>0,
      "receiptdate" =>date("Y-m-d")
		));
	}
  public function actionCreateinvoiceapmat()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
  public function actionCreateinvoiceapjurnal()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"debet" =>0,
      "credit" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.invoiceapid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'invoiceno'=>$model['invoiceno'],
          'invoicedate'=>$model['invoicedate'],
          'poheaderid'=>$model['poheaderid'],
          'addressbookid'=>$model['addressbookid'],
          'taxno'=>$model['taxno'],
          'taxdate'=>$model['taxdate'],
          'amount'=>$model['amount'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'taxid'=>$model['taxid'],
          'paymentmethodid'=>$model['paymentmethodid'],
          'journalno'=>$model['journalno'],
          'receiptdate'=>$model['receiptdate'],
          'grheaderid'=>$model['grheaderid'],
          'companyname'=>$model['companyname'],
          'pono'=>$model['pono'],
          'fullname'=>$model['fullname'],
          'taxcode'=>$model['taxcode'],
          'currencyname'=>$model['currencyname'],
          'taxcode'=>$model['taxcode'],
          'paycode'=>$model['paycode'],
          'grno'=>$model['grno'],

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

  public function actionUpdateinvoiceapmat()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatainvoiceapmat.' where invoiceapmatid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateinvoiceapjurnal()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatainvoiceapjurnal.' where invoiceapjurnalid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'accountid'=>$model['accountid'],
          'debet'=>$model['debet'],
          'credit'=>$model['credit'],
          'description'=>$model['description'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'accountname'=>$model['accountname'],
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
      array('invoiceno','string','emptyinvoiceno'),
      array('invoicedate','string','emptyinvoicedate'),
      array('poheaderid','string','emptypoheaderid'),
      array('addressbookid','string','emptyaddressbookid'),
      array('currencyid','string','emptycurrencyid'),
      array('currencyrate','string','emptycurrencyrate'),
      array('taxid','string','emptytaxid'),
      array('paymentmethodid','string','emptypaymentmethodid'),
    ));
		if ($error == false)
		{
			$id = $_POST['invoiceapid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateInvoiceAP (:companyid
,:invoiceno
,:invoicedate
,:poheaderid
,:addressbookid
,:taxno
,:taxdate
,:amount
,:currencyid
,:currencyrate
,:taxid
,:paymentmethodid
,:journalno
,:receiptdate
,:grheaderid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':invoiceapid',$_POST['invoiceapid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':invoiceno',(($_POST['invoiceno']!=='')?$_POST['invoiceno']:null),PDO::PARAM_STR);
        $command->bindvalue(':invoicedate',(($_POST['invoicedate']!=='')?$_POST['invoicedate']:null),PDO::PARAM_STR);
        $command->bindvalue(':poheaderid',(($_POST['poheaderid']!=='')?$_POST['poheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxdate',(($_POST['taxdate']!=='')?$_POST['taxdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':amount',(($_POST['amount']!=='')?$_POST['amount']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxid',(($_POST['taxid']!=='')?$_POST['taxid']:null),PDO::PARAM_STR);
        $command->bindvalue(':paymentmethodid',(($_POST['paymentmethodid']!=='')?$_POST['paymentmethodid']:null),PDO::PARAM_STR);
        $command->bindvalue(':journalno',(($_POST['journalno']!=='')?$_POST['journalno']:null),PDO::PARAM_STR);
        $command->bindvalue(':receiptdate',(($_POST['receiptdate']!=='')?$_POST['receiptdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':grheaderid',(($_POST['grheaderid']!=='')?$_POST['grheaderid']:null),PDO::PARAM_STR);
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
public function actionSaveinvoiceapmat()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['invoiceapmatid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update invoiceapmat 
			      set  
			      where invoiceapmatid = :invoiceapmatid';
				}
				else
				{
					$sql = 'insert into invoiceapmat () 
			      values ()';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':invoiceapmatid',$_POST['invoiceapmatid'],PDO::PARAM_STR);
				}
				
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
				
public function actionSaveinvoiceapjurnal()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('accountid','string','emptyaccountid'),
      array('description','string','emptydescription'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['invoiceapjurnalid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update invoiceapjurnal 
			      set accountid = :accountid,debet = :debet,credit = :credit,description = :description,currencyid = :currencyid,currencyrate = :currencyrate 
			      where invoiceapjurnalid = :invoiceapjurnalid';
				}
				else
				{
					$sql = 'insert into invoiceapjurnal (accountid,debet,credit,description,currencyid,currencyrate) 
			      values (:accountid,:debet,:credit,:description,:currencyid,:currencyrate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':invoiceapjurnalid',$_POST['invoiceapjurnalid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':debet',(($_POST['debet']!=='')?$_POST['debet']:null),PDO::PARAM_STR);
        $command->bindvalue(':credit',(($_POST['credit']!=='')?$_POST['credit']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveinvoiceap(:vid,:vcreatedby)';
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
				$sql = 'call rejectinvoiceap(:vid,:vcreatedby)';
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
				$sql = "delete from invoiceap where invoiceapid = ".$id[$i];
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
	}public function actionPurgeinvoiceapmat()
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
				$sql = "delete from invoiceapmat where invoiceapmatid = ".$id[$i];
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
	}public function actionPurgeinvoiceapjurnal()
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
				$sql = "delete from invoiceapjurnal where invoiceapjurnalid = ".$id[$i];
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
		$sql = "select journalno,invoiceapid,invoiceno,f.pono,fullname,amount,symbol,currencyrate,a.invoicedate,concat('Pencatatan Invoice Supplier No ',invoiceno) as headernote, taxvalue,a.recordstatus,
	   (select addressname from address e where e.addressbookid = f.addressbookid limit 1) as addressname,
	   (select cityname from address e left join city f on f.cityid = e.cityid where e.addressbookid = f.addressbookid limit 1) as cityname
		from invoiceap a 
		left join poheader f on f.poheaderid = a.poheaderid
		left join currency b on b.currencyid = a.currencyid 
		left join tax c on c.taxid = a.taxid 
		left join addressbook d on d.addressbookid = f.addressbookid ";
		if ($_GET['invoiceapid'] !== '') {
				$sql = $sql . "where a.invoiceapid in (".$_GET['invoiceapid'].")";
		}
		$sql = $sql . " order by invoiceapid ";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title='Journal Adjustment';
	  $this->pdf->AddPage('P');
	  

    foreach($dataReader as $row)
    {
		//$this->pdf->rect(10,60,190,15);
		$this->pdf->setFont('Arial','B',9);
		$this->pdf->text(15,$this->pdf->gety()+5,'PO No: '.$row['pono']);
		$this->pdf->text(120,$this->pdf->gety()+5,'Tanggal: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
		$this->pdf->text(15,$this->pdf->gety()+10,'J.NO: '.$row['journalno']);
		$this->pdf->text(120,$this->pdf->gety()+10,'Supplier: '.$row['fullname']);
	  
      $sql1 = "select accountcode, accountname,debet,credit,a.currencyid,currencyrate,a.description,symbol
        from invoiceapjurnal a
		left join currency b on b.currencyid = a.currencyid
		left join account d on d.accountid = a.accountid 
        where invoiceapid = ".$row['invoiceapid'] . " order by debet desc ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $this->pdf->SetY($this->pdf->gety()+15);
			$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(30,40,30,30,10,50));
      //$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->colheader = array('Account Code','Account Name','Debit','Credit','Rate','Description');
      $this->pdf->RowHeader();
			$this->pdf->setFont('Arial','',8);
      //$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
      $this->pdf->coldetailalign = array('L','L','R','R','R','L');
			$debit=0;
			$credit=0;
      foreach($dataReader1 as $row1)
      {
				$debit = $debit + ($row1['debet']*$row1['currencyrate']);
				$credit = $credit + ($row1['credit']*$row1['currencyrate']);
        $this->pdf->row(array($row1['accountcode'],$row1['accountname'],
						Yii::app()->format->formatCurrency($row1['debet']),
						Yii::app()->format->formatCurrency($row1['credit']),
						Yii::app()->format->formatCurrency($row1['currencyrate']),
						$row1['description']
				));
      }
			$this->pdf->row(array('',
			'Total',
			Yii::app()->format->formatCurrency($debit),
			Yii::app()->format->formatCurrency($credit),
			'',
			''
));
$this->pdf->sety($this->pdf->gety()+5);
$this->pdf->setwidths(array(15,170));
$this->pdf->row(array('Note',
			$row['headernote']
));

$this->pdf->sety($this->pdf->gety()+1);
$this->pdf->setwidths(array(15,170));
$this->pdf->row(array('Nilai',
			Yii::app()->numberFormatter->formatCurrency($row['amount'],$row['symbol'])
));
			$this->pdf->checkNewPage(20);
			$this->pdf->setFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+45,'Prepared By');
			$this->pdf->text(10,$this->pdf->gety()+75,'__________________');
			$this->pdf->text(90,$this->pdf->gety()+45,'Approved By');
			$this->pdf->text(90,$this->pdf->gety()+75,'__________________');
			$this->pdf->text(150,$this->pdf->gety()+45,'Received By');
			$this->pdf->text(150,$this->pdf->gety()+75,'__________________');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('invoiceapid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('invoiceno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('invoicedate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('pono'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('taxdate'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('amount'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('paycode'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('journalno'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('payamount'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('receiptdate'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('grno'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['invoiceapid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['invoiceno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['invoicedate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['pono'])
->setCellValueByColumnAndRow(5, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(7, $i+1, $row1['taxdate'])
->setCellValueByColumnAndRow(8, $i+1, $row1['amount'])
->setCellValueByColumnAndRow(9, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(10, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(11, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(12, $i+1, $row1['paycode'])
->setCellValueByColumnAndRow(13, $i+1, $row1['journalno'])
->setCellValueByColumnAndRow(14, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(15, $i+1, $row1['payamount'])
->setCellValueByColumnAndRow(16, $i+1, $row1['receiptdate'])
->setCellValueByColumnAndRow(17, $i+1, $row1['grno']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}