<?php

class CustomerController extends AdminController
{
	protected $menuname = 'customer';
	public $module = 'Common';
	protected $pageTitle = 'Customer';
	public $wfname = '';
	protected $sqldata = "select a0.addressbookid,a0.fullname,a0.iscustomer,a0.currentlimit,a0.taxno,a0.creditlimit,a0.isstrictlimit,a0.bankname,a0.bankaccountno,a0.accountowner,a0.salesareaid,a0.pricecategoryid,a0.overdue,a0.invoicedate,a0.recordstatus,a1.areaname as areaname,a2.categoryname as categoryname,a3.groupcustomerid,a3.groupname as groupname, a0.ktpno,
    a4.paycode,a5.taxcode,a0.taxid,a0.paymentmethodid, a0.custcategoryid, a0.custgradeid, a0.provinceid,a0.marketareaid,ifnull(a0.customertypeid,0) as customertypeid,a0.husbandbirthdate,a0.wifebirthdate,a0.weddingdate,a6.custcategoryname, a7.custgradename,a8.provincename,a9.marketname,a10.customertypename
    from addressbook a0 
    left join salesarea a1 on a1.salesareaid = a0.salesareaid
    left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
    left join groupcustomer a3 on a3.groupcustomerid = a0.groupcustomerid
    left join paymentmethod a4 on a4.paymentmethodid = a0.paymentmethodid
    left join tax a5 on a5.taxid = a0.taxid
    left join custcategory a6 on a6.custcategoryid = a0.custcategoryid
    left join custgrade a7 on a7.custgradeid = a0.custgradeid
    left join province a8 on a8.provinceid = a0.provinceid
    left join marketarea a9 on a9.marketareaid = a0.marketareaid
    left join customertype a10 on a10.customertypeid = a0.customertypeid
  ";
  protected $sqldataaddress = "select a0.addressid,a0.addressbookid,a0.addresstypeid,a0.addressname,a0.rt,a0.rw,a0.cityid,a0.phoneno,a0.faxno,a0.lat,a0.lng,a1.addresstypename as addresstypename,a2.cityname as cityname,a0.foto 
      from address a0 
      left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
      left join city a2 on a2.cityid = a0.cityid
    ";
  protected $sqldataaddresscontact = "select a0.addresscontactid,a0.contacttypeid,a0.addressbookid,a0.addresscontactname,a0.phoneno,a0.mobilephone,a0.emailaddress,a1.contacttypename as contacttypename, a0.ktp, a0.wanumber, a0.telegramid
      from addresscontact a0 
      left join contacttype a1 on a1.contacttypeid = a0.contacttypeid
    ";
  protected $sqldatacustomerdisc = "select a0.custdiscid, a0.materialtypeid, a1.description, a0.discvalue,a0.addressbookid,a0.sopaymethodid, a0.realpaymethodid, a2.paycode as sopaycode, a3.paycode as realpaycode
      from custdisc a0 
      left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
      left join paymentmethod a2 on a2.paymentmethodid = a0.sopaymethodid
      left join paymentmethod a3 on a3.paymentmethodid = a0.realpaymethodid
    ";
  protected $sqldataaddressaccount = "select a0.addressaccountid,a0.companyid,a0.addressbookid,a0.accpiutangid,a0.recordstatus,a1.companyname as companyname,a2.accountcode as accpiutangname 
      from addressaccount a0 
      left join company a1 on a1.companyid = a0.companyid
      left join account a2 on a2.accountid = a0.accpiutangid
    ";
  protected $sqldatacustomerpotensi = "select a0.addresspotensiid,a0.grouplineid,a0.amount,a0.recordstatus,a1.groupname as grouplinename
    from addresspotensi a0
    left join groupline a1 on a1.grouplineid = a0.grouplineid
  ";
  protected $sqlcount = "select count(1) 
      from addressbook a0 
      left join salesarea a1 on a1.salesareaid = a0.salesareaid
      left join pricecategory a2 on a2.pricecategoryid = a0.pricecategoryid
      left join groupcustomer a3 on a3.groupcustomerid = a0.groupcustomerid
      left join paymentmethod a4 on a4.paymentmethodid = a0.paymentmethodid
      left join tax a5 on a5.taxid = a0.taxid 
      left join custcategory a6 on a6.custcategoryid = a0.custcategoryid
      left join custgrade a7 on a7.custgradeid = a0.custgradeid
      left join province a8 on a8.provinceid = a0.provinceid
      left join marketarea a9 on a9.marketareaid = a0.marketareaid
      left join customertype a10 on a10.customertypeid = a0.customertypeid
    ";
  protected $sqlcountaddress = "select count(1) 
      from address a0 
      left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
      left join city a2 on a2.cityid = a0.cityid
    ";
  protected $sqlcountaddresscontact = "select count(1) 
      from addresscontact a0 
      left join contacttype a1 on a1.contacttypeid = a0.contacttypeid
    ";
  protected $sqlcountcustomerdisc = "select count(1) 
      from custdisc a0 
      left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
      left join paymentmethod a2 on a2.paymentmethodid = a0.sopaymethodid
      left join paymentmethod a3 on a3.paymentmethodid = a0.realpaymethodid
    ";
  protected $sqlcountaddressaccount = "select count(1) 
      from addressaccount a0 
      left join company a1 on a1.companyid = a0.companyid
      left join account a2 on a2.accountid = a0.accpiutangid
    ";
  protected $sqlcountcustomerpotensi = "select count(1)
    from addresspotensi a0
    left join groupline a1 on a1.grouplineid = a0.grouplineid
    ";
  protected function getSQL()
  {
    $this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
    $where = "where iscustomer=1";
    if (isset($_REQUEST['fullname'])) {
            $where .= " and coalesce(a0.fullname,'') like '%". $_REQUEST['fullname']."%' ";
    }
    if(isset($_REQUEST['areaname'])){
        $where .= " and coalesce(a1.areaname,'') like '%". $_REQUEST['areaname']."%' ";
    }
    if(isset($_REQUEST['provincename'])){
        $where .= " and coalesce(a8.provincename,'') like '%". $_REQUEST['provincename']."%' ";
    }
    if(isset($_REQUEST['marketname'])){
        $where .= " and coalesce(a9.marketname,'') like '%". $_REQUEST['marketname']."%' ";
    }
    if(isset($_REQUEST['categoryname'])){
        $where .= " and coalesce(a2.categoryname,'') like '%". $_REQUEST['categoryname']."%' ";
    }
    if(isset($_REQUEST['groupname'])) {
        $where .= " and coalesce(a3.groupname,'') like '%". $_REQUEST['groupname']."%' ";
    }
    if(isset($_REQUEST['overdue'])){
        $where .="     and coalesce(a0.overdue,'') like '%". $_REQUEST['overdue']."%'";
    }
    if (isset($_REQUEST['addressbookid']))
    {
      if (($_REQUEST['addressbookid'] != '0') && ($_REQUEST['addressbookid'] != '') && ($_REQUEST['addressbookid'] != null))
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
    
  public function actiongetdata()
  {
    $address = Yii::app()->db->createCommand($this->sqldataaddress. " where addressbookid = ".$_REQUEST['id'])->queryRow();
    $customer = Yii::app()->db->createCommand($this->sqldata. " where addressbookid = ".$_REQUEST['id'])->queryRow();
    echo CJSON::encode(array(
      'status'=>'success',
      'shiptoname'=> $address['addressname']. ' ' . $address['cityname'],
      'billtoname'=> $address['addressname']. ' ' . $address['cityname'],
      'taxid'=> $customer['taxid'],
      'taxcode'=> $customer['taxcode'],
      'paycode'=> $customer['paycode'],
      'paymentmethodid'=> $customer['paymentmethodid'],
      ));
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
            'addressbookid','fullname','iscustomer','currentlimit','taxno','creditlimit','isstrictlimit','bankname','bankaccountno','accountowner','salesareaid','pricecategoryid','overdue','invoicedate','groupcustomerid','recordstatus','taxid','paymentmethodid','custgradeid','custcategoryid','provinceid','marketareaid','customertypeid','husbandbirthdate','wifebirthdate','weddingdate'
          ),
          'defaultOrder' => array( 
            'addressbookid' => CSort::SORT_DESC
          ),
        ),
      ));
      if (isset($_REQUEST['addressbookid']))
      {
        $this->sqlcountaddress .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
        $this->sqldataaddress .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
        $count = Yii::app()->db->createCommand($this->sqlcountaddress)->queryScalar();
        $pagination = array(
          'pageSize'=>$this->getParameter('DefaultPageSize'),
          'pageVar'=>'page',
        );
      }
      else
      {
        $count = 0;
        $pagination = false;
        $this->sqldataaddress .= " limit 0";
      }
      $countaddress = $count;
      $dataProvideraddress=new CSqlDataProvider($this->sqldataaddress,array(
                'totalItemCount'=>$countaddress,
                'keyField'=>'addressid',
                'pagination'=>$pagination,
                'sort'=>array(
                  'defaultOrder' => array( 
                    'addressid' => CSort::SORT_DESC
                  ),
                ),
                ));
          if (isset($_REQUEST['addressbookid']))
          {
            $this->sqlcountaddresscontact .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $this->sqldataaddresscontact .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $count = Yii::app()->db->createCommand($this->sqlcountaddresscontact)->queryScalar();
            $pagination = array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
            );
          }
          else
          {
            $count = 0;
            $pagination = false;
            $this->sqldataaddresscontact .= " limit 0";
          }
          
          $countaddresscontact = $count;
      $dataProvideraddresscontact=new CSqlDataProvider($this->sqldataaddresscontact,array(
                'totalItemCount'=>$countaddresscontact,
                'keyField'=>'addresscontactid',
                'pagination'=>$pagination,
                'sort'=>array(
                  'defaultOrder' => array( 
                    'addresscontactid' => CSort::SORT_DESC
                  ),
                ),
                ));
              if (isset($_REQUEST['addressbookid']))
          {
            $this->sqlcountcustomerdisc .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $this->sqldatacustomerdisc .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $count = Yii::app()->db->createCommand($this->sqlcountcustomerdisc)->queryScalar();
            $pagination = array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
            );
          }
          else
          {
            $count = 0;
            $pagination = false;
            $this->sqldatacustomerdisc .= " limit 0";
          }
          $countcustomerdisc = Yii::app()->db->createCommand($this->sqlcountcustomerdisc)->queryScalar();
      $dataProvidercustomerdisc=new CSqlDataProvider($this->sqldatacustomerdisc,array(
                'totalItemCount'=>$countcustomerdisc,
                'keyField'=>'custdiscid',
                'pagination'=>$pagination,
                'sort'=>array(
                  'defaultOrder' => array( 
                    'addressaccountid' => CSort::SORT_DESC
                  ),
                ),
                ));
          if (isset($_REQUEST['addressbookid']))
          {
            $this->sqlcountaddressaccount .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $this->sqldataaddressaccount .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $count = Yii::app()->db->createCommand($this->sqlcountaddressaccount)->queryScalar();
            $pagination = array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
            );
          }
          else
          {
            $count = 0;
            $pagination = false;
            $this->sqldataaddressaccount .= " limit 0";
          }
          $countaddressaccount = Yii::app()->db->createCommand($this->sqlcountaddressaccount)->queryScalar();
          $dataProvideraddressaccount=new CSqlDataProvider($this->sqldataaddressaccount,array(
					'totalItemCount'=>$countaddressaccount,
					'keyField'=>'addressaccountid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'addressaccountid' => CSort::SORT_DESC
						),
					),
					));
          if (isset($_REQUEST['addressbookid']))
          {
            $this->sqlcountcustomerpotensi .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $this->sqldatacustomerpotensi .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
            $count = Yii::app()->db->createCommand($this->sqlcountcustomerpotensi)->queryScalar();
            $pagination = array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
            );
          }
          else
          {
            $count = 0;
            $pagination = false;
            $this->sqldatacustomerpotensi .= " limit 0";
          }
          $countcustomerpotensi = Yii::app()->db->createCommand($this->sqlcountcustomerpotensi)->queryScalar();
          $dataProvidercustomerpotensi=new CSqlDataProvider($this->sqldatacustomerpotensi,array(
                'totalItemCount'=>$countcustomerpotensi,
                'keyField'=>'addresspotensiid',
                'pagination'=>$pagination,
                'sort'=>array(
                  'defaultOrder' => array( 
                    'addersspotensiid' => CSort::SORT_DESC
                  ),
                ),
                ));
          //$customertype = arary();
          $sqlcust = Yii::app()->db->createCommand('select customertypeid,customertypename from customertype where recordstatus=1')->queryAll();
          foreach($sqlcust as $rows) {
            $customertype[] = array(
              'id' => $rows['customertypeid'],
              'name' => $rows['customertypename']
            );
          }

          $sqlgroupline = Yii::app()->db->createCommand('select grouplineid,groupname from groupline')->queryAll();
          foreach($sqlgroupline as $rowx) {
            $groupline[] = array(
              'id' => $rowx['grouplineid'],
              'name' => $rowx['groupname']
            );
          }
    		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvideraddress'=>$dataProvideraddress,'dataProvideraddresscontact'=>$dataProvideraddresscontact,'dataProvidercustomerdisc'=>$dataProvidercustomerdisc,'dataProvideraddressaccount'=>$dataProvideraddressaccount,'dataProvidercustomerpotensi'=>$dataProvidercustomerpotensi,'customertype'=>$customertype,'groupline'=>$groupline));
	}
	public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/addressbook/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/addressbook/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/addressbook/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
  public function actionUploadktp()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/addressbook/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/addressbook/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/addressbook/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
  public function actionUploadinfo()
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
			
			
			for ($row = 3;$row <= $highestRow; $row++)
			{	
				$nourut = $sheet->getCellByColumnAndRow(0, $row)->getValue();
                if($nourut == '') {
                    $nourut = '';
                }
                $fullname = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                $abid = Yii::app()->db->createCommand("select addressbookid from addressbook where fullname = '".$fullname."'")->queryScalar();
                if ($abid != '') {					
                    $materialtype = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                    $materialtypeid = Yii::app()->db->createCommand("select materialtypeid from materialtype where description = '".$materialtype."'")->queryScalar();
                    $discvalue = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                    $sopaymethod = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                    $sopaymethodid = Yii::app()->db->createCommand("select paymentmethodid from paymentmethod where paycode = '".$sopaymethod."'")->queryScalar();
                    $realpaymethod = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                    $realpaymethodid = Yii::app()->db->createCommand("select paymentmethodid from paymentmethod where paycode = '".$realpaymethod."'")->queryScalar();
                    if($nourut!='') {
                        $sql = 'call Updatecustomerdisc(:vid,:vaddressbookid,:vmaterialtypeid,:vdiscvalue,:vsopaymethodid,:vrealpaymethodid,:vcreatedby)';
				    }
                    else
                    {
                        $sql = 'call Insertcustomerdisc(:vaddressbookid,:vmaterialtypeid,:vdiscvalue,:vsopaymethodid,:vrealpaymethodid,:vcreatedby)';
                    }
                    $command = $connection->createCommand($sql);
                    if ($nourut !== '')
                    {
                        $command->bindvalue(':vid',$_POST['custdiscid'],PDO::PARAM_STR);
                    }
                    $command->bindvalue(':vaddressbookid',$abid,PDO::PARAM_STR);
                    $command->bindvalue(':vmaterialtypeid',$materialtypeid,PDO::PARAM_STR);
                    $command->bindvalue(':vdiscvalue',$discvalue,PDO::PARAM_STR);
                    $command->bindvalue(':vsopaymethodid',$sopaymethodid,PDO::PARAM_STR);
                    $command->bindvalue(':vrealpaymethodid',$realpaymethodid,PDO::PARAM_STR);
                    $command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
                    $command->execute();
                }
                    
                //get id addressbookid
			}
			$this->getMessage('success',"alreadysaved");
		}	
		catch (Exception $e)
		{
			$this->getMessage('error',$e->getMessage());
		}		
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into addressbook (recordstatus,iscustomer) values (1,1)";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'addressbookid'=>$id,
			"iscustomer"=>1,
      "currentlimit" =>0,
      "creditlimit" =>0,
      "invoicedate" =>date("Y-m-d")
		));
	}
  public function actionCreateaddress()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreateaddresscontact()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreatecustomerdisc()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}
  public function actionCreateaddressaccount()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"companyid" => $company["companyid"],										
            "companyname" => $company["companyname"]
		));
	}
  public function actionCreatecustomerpotensi()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
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
          'taxno'=>$model['taxno'],
          'ktpno'=>$model['ktpno'],
          'creditlimit'=>$model['creditlimit'],
          'isstrictlimit'=>$model['isstrictlimit'],
          'bankname'=>$model['bankname'],
          'bankaccountno'=>$model['bankaccountno'],
          'accountowner'=>$model['accountowner'],
          'salesareaid'=>$model['salesareaid'],
          'pricecategoryid'=>$model['pricecategoryid'],
          'groupcustomerid'=>$model['groupcustomerid'],
          'overdue'=>$model['overdue'],
          'recordstatus'=>$model['recordstatus'],
          'areaname'=>$model['areaname'],
          'categoryname'=>$model['categoryname'],
          'groupname'=>$model['groupname'],
          'taxid'=>$model['taxid'],
          'taxcode'=>$model['taxcode'],
          'paymentmethodid'=>$model['paymentmethodid'],
          'paycode'=>$model['paycode'],
          'custcategoryid'=>$model['custcategoryid'],
          'custcategoryname'=>$model['custcategoryname'],
          'custgradeid'=>$model['custgradeid'],
          'custgradename'=>$model['custgradename'],
          'provinceid'=>$model['provinceid'],
          'provincename'=>$model['provincename'],
          'marketareaid'=>$model['marketareaid'],
          'marketname'=>$model['marketname'],
          'customertypeid'=>$model['customertypeid'],
          'customertypename'=>$model['customertypename'],
          'husbandbirthdate'=>$model['husbandbirthdate'],
          'wifebirthdate'=>$model['wifebirthdate'],
          'weddingdate'=>$model['weddingdate'],
				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateaddress()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataaddress.' where addressid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addressid'=>$model['addressid'],
          'addressbookid'=>$model['addressbookid'],
          'addresstypeid'=>$model['addresstypeid'],
          'addressname'=>$model['addressname'],
          'rt'=>$model['rt'],
          'rw'=>$model['rw'],
          'cityid'=>$model['cityid'],
          'phoneno'=>$model['phoneno'],
          'faxno'=>$model['faxno'],
          'lat'=>$model['lat'],
          'lng'=>$model['lng'],
          'foto'=>$model['foto'],
          'addresstypename'=>$model['addresstypename'],
          'cityname'=>$model['cityname'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateaddresscontact()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataaddresscontact.' where addresscontactid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
          'status'=>'success',
          'addresscontactid'=>$model['addresscontactid'],
          'contacttypeid'=>$model['contacttypeid'],
          'addressbookid'=>$model['addressbookid'],
          'addresscontactname'=>$model['addresscontactname'],
          'phoneno'=>$model['phoneno'],
          'mobilephone'=>$model['mobilephone'],
          'wanumber'=>$model['wanumber'],
          'telegramid'=>$model['telegramid'],
          'emailaddress'=>$model['emailaddress'],
          'ktp'=>$model['ktp'],
          'contacttypename'=>$model['contacttypename'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdatecustomerdisc()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatacustomerdisc.' where custdiscid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'custdiscid'=>$model['custdiscid'],
          'materialtypeid'=>$model['materialtypeid'],
          'addressbookid'=>$model['addressbookid'],
          'description'=>$model['description'],
          'discvalue'=>$model['discvalue'],
          'sopaymethodid'=>$model['sopaymethodid'],
          'realpaymethodid'=>$model['realpaymethodid'],
          'sopaycode'=>$model['sopaycode'],
          'realpaycode'=>$model['realpaycode'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateaddressaccount()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataaddressaccount.' where addressaccountid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addressaccountid'=>$model['addressaccountid'],
          'companyid'=>$model['companyid'],
          'addressbookid'=>$model['addressbookid'],
          'accpiutangid'=>$model['accpiutangid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'accpiutangname'=>$model['accpiutangname'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdatecustomerpotensi()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatacustomerpotensi.' where addresspotensiid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addresspotensiid'=>$model['addresspotensiid'],
          'grouplineid'=>$model['grouplineid'],
          'grouplinename'=>$model['grouplinename'],
          'amount'=>$model['amount'],
          'recordstatus'=>$model['recordstatus'],

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
      //array('taxno','string','emptytaxno'),
      array('creditlimit','string','emptycreditlimit'),
      //array('overdue','string','emptyoverdue'),
      array('taxid','string','emptytaxid'),
      array('paymentmethodid','string','emptypaymentmethodid'),
      array('custcategoryid','string','emptycustcategoryid'),
      array('custgradeid','string','emptycustgradeid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressbookid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateCustomer(:vid,:vfullname,:vtaxno,:vktpno,:vhusbandbirthdate,:vwifebirthdate,:vweddingdate,:vcreditlimit,:visstrictlimit,:vsalesareaid,:vpricecategoryid,:vgroupcustomerid,:vcustcategoryid,:vcustgradeid,:vbankname,:vbankaccountno,:vaccountowner,:voverdue,:vtaxid,:vpaymentmethodid,:vprovinceid,:vmarketareaid,:vcustomertypeid,:vrecordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['addressbookid'],PDO::PARAM_STR);
				$command->bindvalue(':vfullname',(($_POST['fullname']!=='')?$_POST['fullname']:null),PDO::PARAM_STR);
        $command->bindvalue(':vtaxno',$_POST['taxno'],PDO::PARAM_STR);
        $command->bindvalue(':vktpno',$_POST['ktpno'],PDO::PARAM_STR);
        $command->bindvalue(':vhusbandbirthdate',$_POST['husbandbirthdate'],PDO::PARAM_STR);
        $command->bindvalue(':vwifebirthdate',$_POST['wifebirthdate'],PDO::PARAM_STR);
        $command->bindvalue(':vweddingdate',$_POST['weddingdate'],PDO::PARAM_STR);
        $command->bindvalue(':vcreditlimit',(($_POST['creditlimit']!=='')?$_POST['creditlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':visstrictlimit',(($_POST['isstrictlimit']!=='')?$_POST['isstrictlimit']:null),PDO::PARAM_STR);
        $command->bindvalue(':vsalesareaid',(($_POST['salesareaid']!=='')?$_POST['salesareaid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vpricecategoryid',(($_POST['pricecategoryid']!=='')?$_POST['pricecategoryid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vgroupcustomerid',(($_POST['groupcustomerid']!=='')?$_POST['groupcustomerid']:null),PDO::PARAM_STR);   
        $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);   
        $command->bindvalue(':vcustgradeid',(($_POST['custgradeid']!=='')?$_POST['custgradeid']:null),PDO::PARAM_STR);   
        $command->bindvalue(':vbankname',(($_POST['bankname']!=='')?$_POST['bankname']:null),PDO::PARAM_STR);
        $command->bindvalue(':vbankaccountno',(($_POST['bankaccountno']!=='')?$_POST['bankaccountno']:null),PDO::PARAM_STR);
        $command->bindvalue(':vaccountowner',(($_POST['accountowner']!=='')?$_POST['accountowner']:null),PDO::PARAM_STR);
        $command->bindvalue(':voverdue',(($_POST['overdue']!=='')?$_POST['overdue']:null),PDO::PARAM_STR);
        $command->bindvalue(':vtaxid',(($_POST['taxid']!=='')?$_POST['taxid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vpaymentmethodid',(($_POST['paymentmethodid']!=='')?$_POST['paymentmethodid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vprovinceid',(($_POST['provinceid']!=='')?$_POST['provinceid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vmarketareaid',(($_POST['marketareaid']!=='')?$_POST['marketareaid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcustomertypeid',(($_POST['customertypeid']!=='')?$_POST['customertypeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				//var_dump($command);
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
	public function actionSaveaddress()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('addressbookid','string','emptyaddressbookid'),
      array('addresstypeid','string','emptyaddresstypeid'),
      array('addressname','string','emptyaddressname'),
      array('cityid','string','emptycityid'),
      array('phoneno','string','emptyphoneno'),
      array('faxno','string','emptyfaxno'),
      array('lat','string','emptylat'),
      array('lng','string','emptylng'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update address 
			      set addressbookid = :addressbookid,addresstypeid = :addresstypeid,addressname = :addressname,rt = :rt,rw = :rw,
							cityid = :cityid,phoneno = :phoneno,faxno = :faxno,lat = :lat, lng = :lng, foto = :foto
			      where addressid = :addressid';
				}
				else
				{
					$sql = 'insert into address (addressbookid,addresstypeid,addressname,rt,rw,cityid,phoneno,faxno,lat,lng,foto) 
			      values (:addressbookid,:addresstypeid,:addressname,:rt,:rw,:cityid,:phoneno,:faxno,:lat,:lng,:foto)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addressid',$_POST['addressid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addresstypeid',(($_POST['addresstypeid']!=='')?$_POST['addresstypeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressname',(($_POST['addressname']!=='')?$_POST['addressname']:null),PDO::PARAM_STR);
        $command->bindvalue(':rt',(($_POST['rt']!=='')?$_POST['rt']:null),PDO::PARAM_STR);
        $command->bindvalue(':rw',(($_POST['rw']!=='')?$_POST['rw']:null),PDO::PARAM_STR);
        $command->bindvalue(':cityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
        $command->bindvalue(':phoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
        $command->bindvalue(':faxno',(($_POST['faxno']!=='')?$_POST['faxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':lat',(($_POST['lat']!=='')?$_POST['lat']:null),PDO::PARAM_STR);
        $command->bindvalue(':lng',(($_POST['lng']!=='')?$_POST['lng']:null),PDO::PARAM_STR);
        $command->bindvalue(':foto',(($_POST['foto']!=='')?$_POST['foto']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				//$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
	public function actionSaveaddresscontact()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('contacttypeid','string','emptycontacttypeid'),
            array('addressbookid','string','emptyaddressbookid'),
            array('addresscontactname','string','emptyaddresscontactname'),
      
    ));
		if ($error == false)
		{
			$id = $_POST['addresscontactid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update addresscontact 
			      set contacttypeid = :contacttypeid,addressbookid = :addressbookid,addresscontactname = :addresscontactname,phoneno = :phoneno,mobilephone = :mobilephone,wanumber = :wanumber,telegramid = :telegramid,emailaddress = :emailaddress, ktp = :ktp
			      where addresscontactid = :addresscontactid';
				}
				else
				{
					$sql = 'insert into addresscontact (contacttypeid,addressbookid,addresscontactname,phoneno,mobilephone,wanumber,telegramid,emailaddress,ktp) 
			      values (:contacttypeid,:addressbookid,:addresscontactname,:phoneno,:mobilephone,:wanumber,:telegramid,:emailaddress,:ktp)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addresscontactid',$_POST['addresscontactid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':contacttypeid',(($_POST['contacttypeid']!=='')?$_POST['contacttypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
                $command->bindvalue(':addresscontactname',(($_POST['addresscontactname']!=='')?$_POST['addresscontactname']:null),PDO::PARAM_STR);
                $command->bindvalue(':phoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
                $command->bindvalue(':mobilephone',(($_POST['mobilephone']!=='')?$_POST['mobilephone']:null),PDO::PARAM_STR);
                $command->bindvalue(':wanumber',(($_POST['wanumber']!=='')?$_POST['wanumber']:null),PDO::PARAM_STR);
                $command->bindvalue(':telegramid',(($_POST['telegramid']!=='')?$_POST['telegramid']:null),PDO::PARAM_STR);
                $command->bindvalue(':emailaddress',(($_POST['emailaddress']!=='')?$_POST['emailaddress']:null),PDO::PARAM_STR);
                $command->bindvalue(':ktp',(($_POST['ktp']!=='')?$_POST['ktp']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				//$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
  public function actionSavecustomerdisc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('addressbookid','string','emptyaddressbookid'),
      array('materialtypeid','string','emptymaterialtypeid'),
      array('discvalue','string','emptydiscvalue'),
    ));
		if ($error == false)
		{
			$id = $_POST['custdiscid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatecustomerdisc(:vid,:vaddressbookid,:vmaterialtypeid,:vdiscvalue,:vsopaymethodid,:vrealpaymethodid,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertcustomerdisc(:vaddressbookid,:vmaterialtypeid,:vdiscvalue,:vsopaymethodid,:vrealpaymethodid,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['custdiscid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmaterialtypeid',(($_POST['materialtypeid']!=='')?$_POST['materialtypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdiscvalue',(($_POST['discvalue']!=='')?$_POST['discvalue']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsopaymethodid',(($_POST['sopaymethodid']!=='')?$_POST['sopaymethodid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrealpaymethodid',(($_POST['realpaymethodid']!=='')?$_POST['realpaymethodid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
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
	public function actionSaveaddressaccount()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('addressbookid','string','emptyaddressbookid'),
      array('accpiutangid','string','emptyaccpiutangid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressaccountid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update addressaccount 
			      set companyid = :companyid,addressbookid = :addressbookid,accpiutangid = :accpiutangid,recordstatus = :recordstatus 
			      where addressaccountid = :addressaccountid';
				}
				else
				{
					$sql = 'insert into addressaccount (companyid,addressbookid,accpiutangid,recordstatus) 
			      values (:companyid,:addressbookid,:accpiutangid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addressaccountid',$_POST['addressaccountid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accpiutangid',(($_POST['accpiutangid']!=='')?$_POST['accpiutangid']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				//$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
  public function actionSavecustomerpotensi()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('addressbookid','string','emptyaddressbookid'),
      array('grouplineid','string','emptygrouplineid'),
      array('amount','string','emptyamount'),
    ));
		if ($error == false)
		{
			$id = $_POST['addresspotensiid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id === '')
				{
					$sql = 'call Insertcustomerpotensi(:vaddressbookid,:vgrouplineid,:vamount,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Updatecustomerpotensi(:vid,:vaddressbookid,:vgrouplineid,:vamount,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['addresspotensiid'],PDO::PARAM_STR);
				}
        $command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vgrouplineid',(($_POST['grouplineid']!=='')?$_POST['grouplineid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vamount',(($_POST['amount']!=='')?$_POST['amount']:null),PDO::PARAM_STR);
        $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
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
	public function actionPurgeaddress()
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
				$sql = "delete from address where addressid = ".$id[$i];
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
	public function actionPurgeaddresscontact()
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
				$sql = "delete from addresscontact where addresscontactid = ".$id[$i];
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
  public function actionPurgecustomerdisc()
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
					$sql = "call Purgedisc(:vid,:vcreatedby)";
					$command = $connection->createCommand($sql);
					$command->bindvalue(':vid',$id[$i],PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
					$command->execute();
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
	public function actionPurgeaddressaccount()
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
				$sql = "delete from addressaccount where addressaccountid = ".$id[$i];
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
	public function actionPurgecustomerpotensi()
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
					$sql = "call Purgepotensi(:vid,:vcreatedby)";
					$command = $connection->createCommand($sql);
					$command->bindvalue(':vid',$id[$i],PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
					$command->execute();
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
        $this->pdf->title=$this->getCatalog('customer');
        $this->pdf->AddPage('L');
        $this->pdf->setFont('Arial','',9);
        $this->pdf->colalign = array('C','C','C','R','C','C','C','C');
        $this->pdf->colheader = array('Nama ',$this->getCatalog('currentlimit'),$this->getCatalog('taxno'),$this->getCatalog('creditlimit'),$this->getCatalog('bankname'),$this->getCatalog('salesarea'),$this->getCatalog('groupcustomer'),$this->getCatalog('overdue'));
        $this->pdf->setwidths(array(30,30,15,40,40,40,30,40));
        $this->pdf->Rowheader();
        $this->pdf->coldetailalign = array('L','R','L','R','L','L','L','L');
        
        foreach($dataReader as $row1)
        {
            //masukkan baris untuk cetak
          $this->pdf->row(array($row1['fullname'],
                                number_format($row1['currentlimit'],'2',',','.'),
                                $row1['taxno'],
                                number_format($row1['creditlimit'],'2',',','.'),
                                $row1['bankname'].' '.$row1['bankaccountno']. 'an '.$row1['accountowner'],
                                $row1['areaname'],
                                $row1['groupname'],
                                $row1['overdue']));
        }
        // me-render ke browser
        $this->pdf->Output();
    }
    public function actionDownPDF1()
    {
	  parent::actionDownPDF();
    $company = filter_input(INPUT_GET,'company');
    $now = date('Y-m-d');

    $month = date('m',strtotime($now));
    $year = date('Y',strtotime($now));
      
    $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -3 month');
    $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');
	  $prev_month_ts3 = strtotime(''.$year.'-'.$month.'-01 -1 month');
      
    $month1 = date('Y-m-d', $prev_month_ts1);
    $month2 = date('Y-m-t', $prev_month_ts2);
	  $month3 = date('Y-m-t', $prev_month_ts3);

    $date1 = date("Y-m-t", strtotime("-3 month"));
    $date2 = date("Y-m-t", strtotime("-2 month"));
    $date3 = date("Y-m-t", strtotime("-1 month"));
   
	  $sql = "select t.addressbookid, t.fullname, a.custdiscid,a.materialtypeid, a.discvalue, a.sopaymethodid, a.realpaymethodid,b.`description`, a.custdiscid,
              e.paycode as sopaycode, f.paycode as realpaycode
						from addressbook t
						left join custdisc a on a.addressbookid = t.addressbookid
            left join materialtype b on b.materialtypeid = a.materialtypeid
						left join salesarea c on c.salesareaid = t.salesareaid
            ".($company !='' ? 'left join addressaccount g on g.addressbookid=t.addressbookid' :'')."
            ".($company !='' ? 'left join company h on h.companyid=g.companyid':'')."
						left join groupcustomer d on d.groupcustomerid = t.groupcustomerid
            left join paymentmethod e on e.paymentmethodid = a.sopaymethodid
            left join paymentmethod f on f.paymentmethodid = a.realpaymethodid
						where t.iscustomer = 1 ".($company !='' ? " and h.companyname like '%{$company}%'":'')."";
		$addressbookid = filter_input(INPUT_GET,'addressbookid');
		$fullname = filter_input(INPUT_GET,'fullname');
		$bankname = filter_input(INPUT_GET,'bankname');
		$accountowner = filter_input(INPUT_GET,'accountowner');
		$areaname = filter_input(INPUT_GET,'areaname');
        $groupcustomer = filter_input(INPUT_GET,'groupcustomer');
		$sql .= " and coalesce(t.addressbookid,'') like '%".$addressbookid."%' 
			and coalesce(fullname,'') like '%".$fullname."%'
			and coalesce(bankname,'') like '%".$bankname."%'
			and coalesce(accountowner,'') like '%".$accountowner."%'
			and coalesce(areaname,'') like '%".$areaname."%'
            and coalesce(groupname,'') like '%".$groupcustomer."%'
			";
		if ($_GET['addressbookid'] !== '') 
		{
				$sql = $sql . " and t.addressbookid in (".$_GET['id'].")";
		}
		$sql = $sql . " order by fullname asc ";
		$command=Yii::app()->db->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->title=GetCatalog('customer');
		$this->pdf->AddPage('L','A4');
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L');
		$this->pdf->colheader = array(GetCatalog('ID'),
                                      GetCatalog('fullname'),
                                      GetCatalog('materialtype'),
                                      GetCatalog('discvalue'),
                                      GetCatalog('topso'),
                                      GetCatalog('topreal'),
                                      date('M',strtotime($date1)),
                                      date('M',strtotime($date2)),
                                      date('M',strtotime($date3)));
                                      
		$this->pdf->setwidths(array(10,60,32,20,15,25,25,25,25,25,25));
		$this->pdf->Rowheader();
		$this->pdf->setFont('Arial','',8);
		$this->pdf->coldetailalign = array('L','L','L','R','L','L','L','L','L');
		foreach($dataReader as $row1) {
		  $this->pdf->row(array($row1['custdiscid'],$row1['fullname'],$row1['description'],$row1['discvalue'],$row1['sopaycode'],$row1['realpaycode'],
        Yii::app()->format->formatCurrency(getAmountCustomer($row1['addressbookid'],'{$month1}','{$date1}')),
        Yii::app()->format->formatCurrency(getAmountCustomer($row1['addressbookid'],'{$month2}','{$date2}')),
        Yii::app()->format->formatCurrency(getAmountCustomer($row1['addressbookid'],'{$month3}','{$date3}'))
      ));
		}
		$this->pdf->Output();
	}
	public function actionDownPDF1_old()
    {
	  parent::actionDownPDF();
	  $sql = "select t.addressbookid, t.fullname, a.custdiscid,a.materialtypeid, a.discvalue, a.sopaymethodid, a.realpaymethodid,b.`description`, a.custdiscid,
              e.paycode as sopaycode, f.paycode as realpaycode
						from addressbook t
						left join custdisc a on a.addressbookid = t.addressbookid
                        left join materialtype b on b.materialtypeid = a.materialtypeid
						left join salesarea c on c.salesareaid = t.salesareaid
						left join groupcustomer d on d.groupcustomerid = t.groupcustomerid
                        left join paymentmethod e on e.paymentmethodid = a.sopaymethodid
                        left join paymentmethod f on f.paymentmethodid = a.realpaymethodid
						where t.iscustomer = 1 ";
		$addressbookid = filter_input(INPUT_GET,'addressbookid');
		$fullname = filter_input(INPUT_GET,'fullname');
		$bankname = filter_input(INPUT_GET,'bankname');
		$accountowner = filter_input(INPUT_GET,'accountowner');
		$areaname = filter_input(INPUT_GET,'areaname');
        $groupcustomer = filter_input(INPUT_GET,'groupcustomer');
		$sql .= " and coalesce(t.addressbookid,'') like '%".$addressbookid."%' 
			and coalesce(fullname,'') like '%".$fullname."%'
			and coalesce(bankname,'') like '%".$bankname."%'
			and coalesce(accountowner,'') like '%".$accountowner."%'
			and coalesce(areaname,'') like '%".$areaname."%'
            and coalesce(groupname,'') like '%".$groupcustomer."%'
			";
		if ($_GET['addressbookid'] !== '') 
		{
				$sql = $sql . " and t.addressbookid in (".$_GET['id'].")";
		}
		$sql = $sql . " order by fullname asc ";
		$command=Yii::app()->db->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->title=GetCatalog('customer');
		$this->pdf->AddPage('P','A4');
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('L','L','L','L','L','L');
		$this->pdf->colheader = array(GetCatalog('ID'),
                                      GetCatalog('fullname'),
                                      GetCatalog('materialtype'),
                                      GetCatalog('discvalue'),
                                      GetCatalog('topso'),
                                      GetCatalog('topreal'));
		$this->pdf->setwidths(array(10,60,32,25,25,25));
		$this->pdf->Rowheader();
		$this->pdf->setFont('Arial','',8);
		$this->pdf->coldetailalign = array('L','L','L','R','L','L');
		foreach($dataReader as $row1) {
		  $this->pdf->row(array($row1['custdiscid'],$row1['fullname'],$row1['description'],$row1['discvalue'],$row1['sopaycode'],$row1['realpaycode']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('addressbookid'))
    ->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
    ->setCellValueByColumnAndRow(2,4,$this->getCatalog('iscustomer'))
    ->setCellValueByColumnAndRow(3,4,$this->getCatalog('currentlimit'))
    ->setCellValueByColumnAndRow(4,4,$this->getCatalog('taxno'))
    ->setCellValueByColumnAndRow(5,4,$this->getCatalog('creditlimit'))
    ->setCellValueByColumnAndRow(6,4,$this->getCatalog('isstrictlimit'))
    ->setCellValueByColumnAndRow(7,4,$this->getCatalog('bankname'))
    ->setCellValueByColumnAndRow(8,4,$this->getCatalog('bankaccountno'))
    ->setCellValueByColumnAndRow(9,4,$this->getCatalog('accountowner'))
    ->setCellValueByColumnAndRow(10,4,$this->getCatalog('areaname'))
    ->setCellValueByColumnAndRow(11,4,$this->getCatalog('categoryname'))
    ->setCellValueByColumnAndRow(12,4,$this->getCatalog('overdue'))
    ->setCellValueByColumnAndRow(13,4,$this->getCatalog('invoicedate'))
    ->setCellValueByColumnAndRow(13,4,$this->getCatalog('groupname'))
    ->setCellValueByColumnAndRow(14,4,$this->getCatalog('recordstatus'));
        foreach($dataReader as $row1)
        {
            $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0, $i+1, $row1['addressbookid'])
    ->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
    ->setCellValueByColumnAndRow(2, $i+1, $row1['iscustomer'])
    ->setCellValueByColumnAndRow(3, $i+1, $row1['currentlimit'])
    ->setCellValueByColumnAndRow(4, $i+1, $row1['taxno'])
    ->setCellValueByColumnAndRow(5, $i+1, $row1['creditlimit'])
    ->setCellValueByColumnAndRow(6, $i+1, $row1['isstrictlimit'])
    ->setCellValueByColumnAndRow(7, $i+1, $row1['bankname'])
    ->setCellValueByColumnAndRow(8, $i+1, $row1['bankaccountno'])
    ->setCellValueByColumnAndRow(9, $i+1, $row1['accountowner'])
    ->setCellValueByColumnAndRow(10, $i+1, $row1['areaname'])
    ->setCellValueByColumnAndRow(11, $i+1, $row1['categoryname'])
    ->setCellValueByColumnAndRow(12, $i+1, $row1['overdue'])
    ->setCellValueByColumnAndRow(13, $i+1, $row1['invoicedate'])
    ->setCellValueByColumnAndRow(13, $i+1, $row1['groupname'])
    ->setCellValueByColumnAndRow(14, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
  public function actionDownxls1()
    {
		$this->menuname='customerinfo';
		parent::actionDownxls();
    $company = filter_input(INPUT_GET,'company');
    $now = date('Y-m-d');

    $month = date('m',strtotime($now));
    $year = date('Y',strtotime($now));
      
    $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -3 month');
    $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -2 month');
	  $prev_month_ts3 = strtotime(''.$year.'-'.$month.'-01 -1 month');
      
    $month1 = date('Y-m-d', $prev_month_ts1);
    $month2 = date('Y-m-t', $prev_month_ts2);
	  $month3 = date('Y-m-t', $prev_month_ts3);

    $date1 = date("Y-m-t", strtotime("-3 month"));
    $date2 = date("Y-m-t", strtotime("-2 month"));
    $date3 = date("Y-m-t", strtotime("-1 month"));

		 $sql = "select t.addressbookid, t.fullname, a.custdiscid,a.materialtypeid, a.discvalue, a.sopaymethodid, a.realpaymethodid,b.`description`, a.custdiscid,
              e.paycode as sopaycode, f.paycode as realpaycode
						from addressbook t
						left join custdisc a on a.addressbookid = t.addressbookid
            left join materialtype b on b.materialtypeid = a.materialtypeid
            ".($company !='' ? 'left join addressaccount g on g.addressbookid=t.addressbookid' :'')."
            ".($company !='' ? 'left join company h on h.companyid=g.companyid':'')."
						left join salesarea c on c.salesareaid = t.salesareaid
						left join groupcustomer d on d.groupcustomerid = t.groupcustomerid
                        left join paymentmethod e on e.paymentmethodid = a.sopaymethodid
                        left join paymentmethod f on f.paymentmethodid = a.realpaymethodid
						where t.iscustomer = 1 ".($company !='' ? " and h.companyname like '%{$company}%'":'')."";
		$addressbookid = filter_input(INPUT_GET,'addressbookid');
		$fullname = filter_input(INPUT_GET,'fullname');
		$bankname = filter_input(INPUT_GET,'bankname');
		$accountowner = filter_input(INPUT_GET,'accountowner');
		$areaname = filter_input(INPUT_GET,'areaname');
        $groupcustomer = filter_input(INPUT_GET,'groupcustomer');
		$sql .= " and coalesce(t.addressbookid,'') like '%".$addressbookid."%' 
			and coalesce(fullname,'') like '%".$fullname."%'
			and coalesce(bankname,'') like '%".$bankname."%'
			and coalesce(accountowner,'') like '%".$accountowner."%'
			and coalesce(areaname,'') like '%".$areaname."%'
            and coalesce(groupname,'') like '%".$groupcustomer."%'
			";
		if ($_GET['addressbookid'] !== '') 
		{
				$sql = $sql . " and t.addressbookid in (".$_GET['id'].")";
		}
		$sql = $sql . " order by fullname asc ";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();	
		$i=3;
		foreach($dataReader as $row1) {
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$i,$row1['custdiscid'])
				->setCellValueByColumnAndRow(1,$i,$row1['fullname'])							
				->setCellValueByColumnAndRow(2,$i,$row1['description'])
				->setCellValueByColumnAndRow(3,$i,$row1['discvalue'])
				->setCellValueByColumnAndRow(4,$i,$row1['sopaycode'])
				->setCellValueByColumnAndRow(5,$i,$row1['realpaycode'])
				->setCellValueByColumnAndRow(6,$i,getAmountCustomer($row1['addressbookid'],'{$month1}','{$date1}'))
				->setCellValueByColumnAndRow(7,$i,getAmountCustomer($row1['addressbookid'],'{$month2}','{$date2}'))
				->setCellValueByColumnAndRow(8,$i,getAmountCustomer($row1['addressbookid'],'{$month3}','{$date3}'));
			$i++;
		}
		$this->getFooterXLS($this->phpExcel);
	}
	public function actionDownxls1_old()
    {
		$this->menuname='customerinfo';
		parent::actionDownxls();
		 $sql = "select t.addressbookid, t.fullname, a.custdiscid,a.materialtypeid, a.discvalue, a.sopaymethodid, a.realpaymethodid,b.`description`, a.custdiscid,
              e.paycode as sopaycode, f.paycode as realpaycode
						from addressbook t
						left join custdisc a on a.addressbookid = t.addressbookid
                        left join materialtype b on b.materialtypeid = a.materialtypeid
						left join salesarea c on c.salesareaid = t.salesareaid
						left join groupcustomer d on d.groupcustomerid = t.groupcustomerid
                        left join paymentmethod e on e.paymentmethodid = a.sopaymethodid
                        left join paymentmethod f on f.paymentmethodid = a.realpaymethodid
						where t.iscustomer = 1 ";
		$addressbookid = filter_input(INPUT_GET,'addressbookid');
		$fullname = filter_input(INPUT_GET,'fullname');
		$bankname = filter_input(INPUT_GET,'bankname');
		$accountowner = filter_input(INPUT_GET,'accountowner');
		$areaname = filter_input(INPUT_GET,'areaname');
        $groupcustomer = filter_input(INPUT_GET,'groupcustomer');
		$sql .= " and coalesce(t.addressbookid,'') like '%".$addressbookid."%' 
			and coalesce(fullname,'') like '%".$fullname."%'
			and coalesce(bankname,'') like '%".$bankname."%'
			and coalesce(accountowner,'') like '%".$accountowner."%'
			and coalesce(areaname,'') like '%".$areaname."%'
            and coalesce(groupname,'') like '%".$groupcustomer."%'
			";
		if ($_GET['addressbookid'] !== '') 
		{
				$sql = $sql . " and t.addressbookid in (".$_GET['id'].")";
		}
		$sql = $sql . " order by fullname asc ";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();	
		$i=3;
		foreach($dataReader as $row1) {
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$i,$row1['custdiscid'])
				->setCellValueByColumnAndRow(1,$i,$row1['fullname'])							
				->setCellValueByColumnAndRow(2,$i,$row1['description'])
				->setCellValueByColumnAndRow(3,$i,$row1['discvalue'])
				->setCellValueByColumnAndRow(4,$i,$row1['sopaycode'])
				->setCellValueByColumnAndRow(5,$i,$row1['realpaycode']);
			$i++;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
