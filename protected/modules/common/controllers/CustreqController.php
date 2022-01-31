<?php

class CustreqController extends AdminController
{
	protected $menuname = 'custreq';
	public $module = 'Order';
	protected $pageTitle = 'Pendaftaran Customer Baru';
	public $wfname = 'appcustreq';
	protected $sqldata = "select a0.custreqid,a0.custreqno,a0.reqdate,a0.companyid,a0.custcode,a0.fullname,a0.address,a0.cityid,a0.provinceid,a0. 
    from custreq a0 
    left join company a1 on a1.companyid = a0.companyid
    left join city a2 on a2.cityid = a0.cityid
    left join province a3 on a3.provinceid = a0.provinceid
    left join country a4 on a4.countryid = a0.countryid
    left join religion a5 on a5.religionid = a0.religionid
    left join taxgroup a6 on a6.taxgroupid = a0.taxgroupid
    left join employee a7 on a7.employeeid = a0.employeeid
    left join paymentmethod a8 on a8.paymentmethodid = a0.paymentid
    left join pricecategory a9 on a9.pricecategoryid = a0.pricecategoryid
    left join salesarea a10 on a10.salesareaid = a0.salesareaid
    left join custcategory a11 on a11.custcategoryid = a0.custcategoryid
    left join custgrade a12 on a12.custgradeid = a0.custgradeid
    left join groupcustomer a13 on a13.groupcustomerid = a0.groupcustomerid
  ";
  protected $sqlcount = "select count(1) 
    from custreq a0 
    left join company a1 on a1.companyid = a0.companyid
    left join city a2 on a2.cityid = a0.cityid
    left join province a3 on a3.provinceid = a0.provinceid
    left join country a4 on a4.countryid = a0.countryid
    left join religion a5 on a5.religionid = a0.religionid
    left join taxgroup a6 on a6.taxgroupid = a0.taxgroupid
    left join employee a7 on a7.employeeid = a0.employeeid
    left join paymentmethod a8 on a8.paymentmethodid = a0.paymentid
    left join pricecategory a9 on a9.pricecategoryid = a0.pricecategoryid
    left join groupcustomer a13 on a13.groupcustomerid = a0.groupcustomerid
    left join salesarea a10 on a10.salesareaid = a0.salesareaid
    left join custcategory a11 on a11.custcategoryid = a0.custcategoryid
    left join custgrade a12 on a12.custgradeid = a0.custgradeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').") and a0.recordstatus in (".getUserRecordStatus('listcustreq').")";

		if (isset($_REQUEST['custcode']) && ($_REQUEST['custcode']!=''))
      $where .= " and a0.custcode like '%". $_REQUEST['custcode']."%'  ";
    
    if (isset($_REQUEST['fullname']) && ($_REQUEST['fullname']!=''))
      $where .= " and a0.fullname like '%". $_REQUEST['fullname']."%' ";
      
    if (isset($_REQUEST['zipcode']) && ($_REQUEST['zipcode']!=''))
      $where .= " and a0.zipcode like '%". $_REQUEST['zipcode']."%' ";

    if (isset($_REQUEST['phoneno']) && ($_REQUEST['phoneno']!=''))
      $where .= " and a0.phoneno like '%". $_REQUEST['phoneno']."%' ";

    if (isset($_REQUEST['mobileno']) && ($_REQUEST['mobileno']!=''))
      $where .= " and a0.mobileno like '%". $_REQUEST['mobileno']."%' ";
      
    if (isset($_REQUEST['faxno']) && ($_REQUEST['faxno']!='')) 
      $where .= " and a0.faxno like '%". $_REQUEST['faxno']."%' ";
      
    if (isset($_REQUEST['idno']) && ($_REQUEST['idno']!='')) 
      $where .= " and a0.idno like '%". $_REQUEST['idno']."%' ";
    
    if (isset($_REQUEST['contactperson']) && ($_REQUEST['contactperson']!='')) 
      $where .= " and a0.contactperson like '%". $_REQUEST['contactperson']."%' ";
       
    if (isset($_REQUEST['owner']) && ($_REQUEST['owner']!='')) 
      $where .= " and a0.owner like '%". $_REQUEST['owner']."%' "; 
      
    if (isset($_REQUEST['homeno']) && ($_REQUEST['homeno']!='')) 
      $where .=  " and a0.homeno like '%". $_REQUEST['homeno']."%' ";
      
    if (isset($_REQUEST['buildingstatus']) && ($_REQUEST['buildingstatus']!='')) 
      $where .= " and a0.buildingstatus like '%". $_REQUEST['buildingstatus']."%' ";
      
    if (isset($_REQUEST['pramuniaga']) && ($_REQUEST['pramuniaga']!='')) 
      $where .= " and a0.pramuniaga like '%". $_REQUEST['pramuniaga']."%' ";
      
    if (isset($_REQUEST['taxno']) && ($_REQUEST['taxno']!='')) 
      $where .= " and a0.taxno like '%". $_REQUEST['taxno']."%' ";
      
    if (isset($_REQUEST['bankname']) && ($_REQUEST['bankname']!='')) 
      $where .= " and a0.bankname like '%". $_REQUEST['bankname']."%'";
      
    if (isset($_REQUEST['taxname']) && ($_REQUEST['taxname']!='')) 
      $where .= " and a0.taxname like '%". $_REQUEST['taxname']."%'";
      
    if (isset($_REQUEST['accountno']) && ($_REQUEST['accountno']!='')) 
      $where .= " and a0.accountno like '%". $_REQUEST['accountno']."%' ";
    
    if (isset($_REQUEST['accountname']) && ($_REQUEST['accountname']!='')) 
      $where .= " and a0.accountname like '%". $_REQUEST['accountname']."%'  ";
      
    if (isset($_REQUEST['companyname']) && ($_REQUEST['companyname']!='')) 
      $where .= " and a1.companyname like '%". $_REQUEST['companyname']."%' ";
    
    if (isset($_REQUEST['cityname']) && ($_REQUEST['cityname']!='')) 
      $where .= " and a2.cityname like '%". $_REQUEST['cityname']."%' ";
      
    if (isset($_REQUEST['provincename']) && ($_REQUEST['provincename']!='')) 
      $where .= " and a3.provincename like '%". $_REQUEST['provincename']."%' ";
      
    if (isset($_REQUEST['countryname']) && ($_REQUEST['countryname']!='')) 
      $where .= " and a4.countryname like '%". $_REQUEST['countryname']."%' ";
      
    if (isset($_REQUEST['religionname']) && ($_REQUEST['religionname']!='')) 
      $where .= " and a5.religionname like '%". $_REQUEST['religionname']."%' ";
      
    if (isset($_REQUEST['taxgroupname']) && ($_REQUEST['taxgroupname']!='')) 
      $where .= " and a6.taxgroupname like '%". $_REQUEST['taxgroupname']."%'";
      
    if (isset($_REQUEST['salesname']) && ($_REQUEST['salesname']!='')) 
      $where .= " and a7.fullname like '%". $_REQUEST['salesname']."%' ";
    
    if (isset($_REQUEST['paycode']) && ($_REQUEST['paycode']!='')) 
      $where .= " and a8.paycode like '%". $_REQUEST['paycode']."%' ";
      
    if (isset($_REQUEST['categoryname']) && ($_REQUEST['categoryname']!=''))
      $where .= " and a9.categoryname like '%". $_REQUEST['categoryname']."%' ";
      
    if (isset($_REQUEST['custcategoryname']) && ($_REQUEST['custcategoryname']!=''))
      $where .= " and a11.custcategoryname like '%". $_REQUEST['custcategoryname']."%' ";
      
    if (isset($_REQUEST['groupname']) && ($_REQUEST['groupname']!='')) 
      $where .= " and a12.groupname like '%". $_REQUEST['groupname']."%' ";
      
    if (isset($_REQUEST['custgradename']) && ($_REQUEST['custgradename']!=''))
			$where .= " and a13.custgradename like '%". $_REQUEST['custgradename']."%' ";
		if (isset($_REQUEST['custreqid']))
			{
				if (($_REQUEST['custreqid'] !== '0') && ($_REQUEST['custreqid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.custreqid in (".$_REQUEST['custreqid'].")";
					}
					else
					{
						$where .= " and a0.custreqid in (".$_REQUEST['custreqid'].")";
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
			'keyField'=>'custreqid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'custreqid','custreqno','reqdate','companyid','custcode','fullname','address','cityid','provinceid','zipcode','countryid','phoneno','mobileno','wanumber','faxno','idno','contactperson','husbandbirthdate','wifebirthday','weddingdate','owner','homeno','owneraddress','religionid','buildingstatus','empno','pramuniaga','taxgroupid','taxno','bankname','taxname','bankaddress','taxaddress','accountno','accountname','birthdatetoko','employeeid','creditlimit','paymentid','pricecategoryid','salesareaid','lat','lng','custcategoryid','custgradeid','recordstatus','groupcustomerid'
				),
				'defaultOrder' => array( 
					'custreqid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"reqdate" =>date("Y-m-d"),
      "birthdatetoko" =>date("Y-m-d"),
      "creditlimit" =>0,
      "recordstatus" =>$this->findstatusbyuser("inscustreq")
		));
	}
	public function actionUploadcustktp()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/addressbook/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/addressbook/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/addressbook/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadcustphoto()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/addressbook/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/addressbook/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/addressbook/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.custreqid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'custreqid'=>$model['custreqid'],
          'custreqno'=>$model['custreqno'],
          'reqdate'=>$model['reqdate'],
          'companyid'=>$model['companyid'],
          'custcode'=>$model['custcode'],
          'fullname'=>$model['fullname'],
          'address'=>$model['address'],
          'cityid'=>$model['cityid'],
          'provinceid'=>$model['provinceid'],
          'zipcode'=>$model['zipcode'],
          'countryid'=>$model['countryid'],
          'phoneno'=>$model['phoneno'],
          'mobileno'=>$model['mobileno'],
          'wanumber'=>$model['wanumber'],
          'faxno'=>$model['faxno'],
          'idno'=>$model['idno'],
          'contactperson'=>$model['contactperson'],
          'husbandbirthdate'=>$model['husbandbirthdate'],
          'wifebirthdate'=>$model['wifebirthdate'],
          'weddingdate'=>$model['weddingdate'],
          'owner'=>$model['owner'],
          'homeno'=>$model['homeno'],
          'owneraddress'=>$model['owneraddress'],
          'religionid'=>$model['religionid'],
          'buildingstatus'=>$model['buildingstatus'],
          'empno'=>$model['empno'],
          'pramuniaga'=>$model['pramuniaga'],
          'taxgroupid'=>$model['taxgroupid'],
          'taxno'=>$model['taxno'],
          'bankname'=>$model['bankname'],
          'taxname'=>$model['taxname'],
          'bankaddress'=>$model['bankaddress'],
          'taxaddress'=>$model['taxaddress'],
          'accountno'=>$model['accountno'],
          'accountname'=>$model['accountname'],
          'birthdatetoko'=>$model['birthdatetoko'],
          'employeeid'=>$model['employeeid'],
          'creditlimit'=>$model['creditlimit'],
          'paymentid'=>$model['paymentid'],
          'pricecategoryid'=>$model['pricecategoryid'],
          'groupcustomerid'=>$model['groupcustomerid'],
          'salesareaid'=>$model['salesareaid'],
          'lat'=>$model['lat'],
          'lng'=>$model['lng'],
          'custcategoryid'=>$model['custcategoryid'],
          'custgradeid'=>$model['custgradeid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'cityname'=>$model['cityname'],
          'provincename'=>$model['provincename'],
          'countryname'=>$model['countryname'],
          'religionname'=>$model['religionname'],
          'taxgroupname'=>$model['taxgroupname'],
          'salesname'=>$model['salesname'],
          'paycode'=>$model['paycode'],
          'categoryname'=>$model['categoryname'],
          'groupname'=>$model['groupname'],
          'areaname'=>$model['areaname'],
          'custcategoryname'=>$model['custcategoryname'],
          'custgradename'=>$model['custgradename'],
          'custphoto'=>$model['custphoto'],
          'custktp'=>$model['custktp'],

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
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
	  array('reqdate','string','emptyreqdate'),
      array('companyid','string','emptycompany'),
      array('fullname','string','emptycustomer'),
      array('address','string','emptyaddress'),
      array('cityid','string','emptycityname'),
      array('provinceid','string','emptyprovincename'),
      array('zipcode','string','emptyzipcode'),
      array('countryid','string','emptycountryname'),
      array('wanumber','string','emptywanumber'),
      array('idno','string','emptyidno'),
      array('contactperson','string','emptycontactperson'),
      array('owner','string','emptyowner'),
      array('owneraddress','string','emptyowneraddress'),
      array('religionid','string','emptyreligion'),
      array('empno','string','emptyempno'),
      array('taxgroupid','string','emptytaxgroup'),
      array('employeeid','string','emptysales'),
      array('creditlimit','string','emptycreditlimit'),
      array('paymentid','string','emptypayment'),
      array('pricecategoryid','string','emptypricecategory'),
      array('groupcustomerid','string','emptygroupcustomer'),
      array('salesareaid','string','emptysalesarea'),
      array('lat','string','emptylat'),
      array('lng','string','emptylng'),
      array('custktp','string','emptycustktp'),
      array('custphoto','string','emptycustphoto'),
    ));
		if ($error == false)
		{
			$id = $_POST['custreqid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id == '') {
                    $sql     = 'call InsertCustreq(:vreqdate,:vcompanyid,:vcustcode,:vfullname,:vaddress,:vcityid,:vprovinceid,:vzipcode,:vcountryid,:vphoneno,:vmobileno,:vwanumber,:vfaxno,:vidno,:vcontactperson,:vhusbandbirthdate,:vwifebirthdate,:vweddingdate,:vowner,:vhomeno,:vowneraddress,:vreligionid,:vbuildingstatus,:vempno,:vpramuniaga,:vtaxgroupid,:vtaxno,:vbankname,:vtaxname,:vbankaddress,:vtaxaddress,:vaccountno,:vaccountname,:vbirthdatetoko,:vemployeeid,:vcreditlimit,:vpaymentid,:vpricecategoryid,:vsalesareaid,:vlat,:vlng,:vcustcategoryid,:vcustgradeid,:vgroupcustomerid,:vcustphoto,
                    :vcustktp,:vcreatedby)';
                    $command = $connection->createCommand($sql);
                } else {
                    $sql     = 'call UpdateCustreq(:vid,:vreqdate,:vcompanyid,:vcustcode,:vfullname,:vaddress,:vcityid,:vprovinceid,:vzipcode,:vcountryid,:vphoneno,:vmobileno,:vwanumber,:vfaxno,:vidno,:vcontactperson,:vhusbandbirthdate,:vwifebirthdate,:vweddingdate,:vowner,:vhomeno,:vowneraddress,:vreligionid,:vbuildingstatus,:vempno,:vpramuniaga,:vtaxgroupid,:vtaxno,:vbankname,:vtaxname,:vbankaddress,:vtaxaddress,:vaccountno,:vaccountname,:vbirthdatetoko,:vemployeeid,:vcreditlimit,:vpaymentid,:vpricecategoryid,:vsalesareaid,:vlat,:vlng,:vcustcategoryid,:vcustgradeid,:vgroupcustomerid,:vcustphoto,
                    :vcustktp,:vcreatedby)';
                    $command = $connection->createCommand($sql);
                    $command->bindvalue(':vid', $_POST['custreqid'], PDO::PARAM_STR);
                }
                $command->bindvalue(':vreqdate',(($_POST['reqdate']!=='')?date(Yii::app()->params['datetodb'],strtotime($_POST['reqdate'])):null),PDO::PARAM_STR);
                $command->bindvalue(':vcompanyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcode',(($_POST['custcode']!=='')?$_POST['custcode']:null),PDO::PARAM_STR);
                $command->bindvalue(':vfullname',(($_POST['fullname']!=='')?$_POST['fullname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaddress',(($_POST['address']!=='')?$_POST['address']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vprovinceid',(($_POST['provinceid']!=='')?$_POST['provinceid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vzipcode',(($_POST['zipcode']!=='')?$_POST['zipcode']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcountryid',(($_POST['countryid']!=='')?$_POST['countryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vphoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmobileno',(($_POST['mobileno']!=='')?$_POST['mobileno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vwanumber',(($_POST['wanumber']!=='')?$_POST['wanumber']:null),PDO::PARAM_STR);
                $command->bindvalue(':vfaxno',(($_POST['faxno']!=='')?$_POST['faxno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vidno',(($_POST['idno']!=='')?$_POST['idno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcontactperson',(($_POST['contactperson']!=='')?$_POST['contactperson']:null),PDO::PARAM_STR);
                $command->bindvalue(':vhusbandbirthdate',(($_POST['husbandbirthdate']!=='')?$_POST['husbandbirthdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vwifebirthdate',(($_POST['wifebirthdate']!=='')?$_POST['wifebirthdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vweddingdate',(($_POST['weddingdate']!=='')?$_POST['weddingdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vowner',(($_POST['owner']!=='')?$_POST['owner']:null),PDO::PARAM_STR);
                $command->bindvalue(':vhomeno',(($_POST['homeno']!=='')?$_POST['homeno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vowneraddress',(($_POST['owneraddress']!=='')?$_POST['owneraddress']:null),PDO::PARAM_STR);
                $command->bindvalue(':vreligionid',(($_POST['religionid']!=='')?$_POST['religionid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbuildingstatus',(($_POST['buildingstatus']!=='')?$_POST['buildingstatus']:null),PDO::PARAM_STR);
                $command->bindvalue(':vempno',(($_POST['empno']!=='')?$_POST['empno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpramuniaga',(($_POST['pramuniaga']!=='')?$_POST['pramuniaga']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxgroupid',(($_POST['taxgroupid']!=='')?$_POST['taxgroupid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbankname',(($_POST['bankname']!=='')?$_POST['bankname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxname',(($_POST['taxname']!=='')?$_POST['taxname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbankaddress',(($_POST['bankaddress']!=='')?$_POST['bankaddress']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxaddress',(($_POST['taxaddress']!=='')?$_POST['taxaddress']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccountno',(($_POST['accountno']!=='')?$_POST['accountno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccountname',(($_POST['accountname']!=='')?$_POST['accountname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbirthdatetoko',(($_POST['birthdatetoko']!=='')?$_POST['birthdatetoko']:null),PDO::PARAM_STR);
                $command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreditlimit',(($_POST['creditlimit']!=='')?$_POST['creditlimit']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpaymentid',(($_POST['paymentid']!=='')?$_POST['paymentid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpricecategoryid',(($_POST['pricecategoryid']!=='')?$_POST['pricecategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsalesareaid',(($_POST['salesareaid']!=='')?$_POST['salesareaid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlat',(($_POST['lat']!=='')?$_POST['lat']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlng',(($_POST['lng']!=='')?$_POST['lng']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustgradeid',(($_POST['custgradeid']!=='')?$_POST['custgradeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgroupcustomerid',(($_POST['groupcustomerid']!=='')?$_POST['groupcustomerid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustphoto',(($_POST['custphoto']!=='')?$_POST['custphoto']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustktp',(($_POST['custktp']!=='')?$_POST['custktp']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
	private function SendNotifWa($menuname,$idarray)
	{
    // getrecordstatus
		$ids = null;
		if(is_array($idarray)==TRUE) {
			foreach($idarray as $id) {
				$sql = "select custreqid
							from custreq
							where recordstatus = getwfmaxstatbywfname('appcustreq') and custreqid = ".$id;
				if($ids == null) {
					$ids = Yii::app()->db->createCommand($sql)->queryScalar();
				}
				else
				{
					$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
				}
				//var_dump($idarray);
			}
			// get customer number
			if($ids == null) {
				foreach($idarray as $id) {
					$sql = "select custreqid
								from custreq
								where custreqid = ".$id;
					if($ids == null) {
						$ids = Yii::app()->db->createCommand($sql)->queryScalar();
					}
					else
					{
						$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
					}
					//var_dump($idarray);
				}
				$getSalesOrder = "select a.custreqid, a.fullname, a.address, a.companyid, a.reqdate, a.custreqno, d.companycode, a.creditlimit, b.cityname, c.provincename, e.fullname as sales, getwfstatusbywfname('appcustreq',a.recordstatus) as statusname
								from custreq a
								join city b on b.cityid = a.cityid 
								join province c on c.provinceid = a.provinceid 
								join company d on d.companyid = a.companyid
								join employee e on e.employeeid = a.employeeid
								where a.custreqid in ({$ids})
								group by custreqid
				";

				$res = Yii::app()->db->createCommand($getSalesOrder)->queryAll();
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$pesanwa = 
					"Pendaftaran Customer No.: ".$row['custreqno']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['reqdate']))."\nSales: ".$row['sales']."\n\nCustomer Baru ".$row['companycode'].": *".$row['fullname']."*\nAlamat Customer: ".$row['address']."\nKredit Limit Rp.".Yii::app()->format->formatCurrency($row['creditlimit'])."\n\nTelah disetujui oleh bagian terkait dengan status *".$row['statusname']."*, silahkan _*Review*_ lalu _*Approve*_ / _*Reject*_ pada Aplikasi ERP AKA Group.\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesantele = 
					"Pendaftaran Customer No.: ".$row['custreqno']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['reqdate']))."\nSales: ".$row['sales']."\n\nCustomer Baru ".$row['companycode'].": ".$row['fullname']."\nAlamat Customer: ".$row['address']."\nKredit Limit Rp.".Yii::app()->format->formatCurrency($row['creditlimit'])."\n\nTelah disetujui oleh bagian terkait dengan status ".$row['statusname'].", silahkan Review lalu Approve / Reject pada Aplikasi ERP AKA Group.\n\nPesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)\n".
					$time;
					
					$getWaNumber = "SELECT e.useraccessid,b.groupaccessid,replace(e.wanumber,'+','') as wanumber,e.telegramid
									FROM custreq a
									JOIN wfgroup b ON b.wfbefstat=a.recordstatus AND b.workflowid=190
									JOIN groupmenuauth c ON c.groupaccessid=b.groupaccessid AND c.menuauthid=5 AND c.menuvalueid=a.companyid
									JOIN usergroup d ON d.groupaccessid=c.groupaccessid
									JOIN useraccess e ON e.useraccessid=d.useraccessid AND e.recordstatus=1 AND e.useraccessid<>2 AND e.useraccessid<>106
									-- AND e.useraccessid<>3
									WHERE a.custreqid = {$row['custreqid']}
					";
					$res1 = Yii::app()->db->createCommand($getWaNumber)->queryAll();
					
					foreach($res1 as $row1)
					{
						$wanumber = $row1['wanumber'];
						$telegramid = $row1['telegramid'];
						if ($row1['useraccessid'] == 3){$ui=" - cms ".$row1['groupaccessid'];}else{$ui="";}
    /*					//Whatsapp Japri
						$ch = curl_init();
						curl_setopt_array($ch, array(
							CURLOPT_URL => "http://akagroup.co.id:8888/api/sendText?id_device=1&message=".urlencode($pesanwa)."&tujuan=".$wanumber."@s.whatsapp.net",
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
							  CURLOPT_HTTPHEADER => array(
								"apikey: t0k3nb4ruwh4ts4k4"
							  ),
						));
						$res = curl_exec($ch);
    */						
						if ($telegramid > 0)
						{
							$url = Yii::app()->params['tele']."/sendMessage?chat_id=".$telegramid."&text=".urlencode($pesantele.$ui);
							$ch = curl_init();
							$optArray = array(
								CURLOPT_URL => $url,
								CURLOPT_RETURNTRANSFER => true
							);
							curl_setopt_array($ch, $optArray);
							$result = curl_exec($ch);
						}
					}
				curl_close($ch);
				}
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
				$sql = 'call Approvecustreq(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->SendNotifWa($this->menuname,$id);
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
				$sql = 'call Deletecustreq(:vid,:vcreatedby)';
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
				$sql = "delete from custreq where custreqid = ".$id[$i];
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
    $sql = "select a0.reqdate,a1.companyname,a0.custcode,a0.fullname,a0.address,a2.cityname,a3.provincename,a4.countryname,
          a0.zipcode,a0.phoneno,a0.mobileno,a0.wanumber,a0.faxno,a0.idno,a0.contactperson,a0.husbandbirthdate,a0.wifebirthdate,a0.weddingdate,a0.owner,a0.homeno,a0.owneraddress,
          a5.religionname,a0.buildingstatus,a0.empno,a0.pramuniaga,a6.taxgroupname,a0.taxno,a0.bankname,a0.taxname,a0.bankaddress,
          a0.taxaddress,a0.accountno,a0.accountname,a0.birthdatetoko,a7.fullname,a0.creditlimit,a8.paycode,a9.categoryname,
          a10.areaname,a0.lat,a0.lng,a11.custcategoryname,a12.custogradedesc,a13.groupcustomerid,a13.groupname
          from custreq a0 
          join company a1 on a1.companyid = a0.companyid
          join city a2 on a2.cityid = a0.cityid
          join province a3 on a3.provinceid = a0.provinceid
          join country a4 on a4.countryid = a0.countryid
          join religion a5 on a5.religionid = a0.religionid
          join taxgroup a6 on a6.taxgroupid = a0.taxgroupid
          join employee a7 on a7.employeeid = a0.employeeid
          join paymentmethod a8 on a8.paymentmethodid = a0.paymentid
          join pricecategory a9 on a9.pricecategoryid = a0.pricecategoryid
          join salesarea a10 on a10.salesareaid = a0.salesareaid
          join custcategory a11 on a11.custcategoryid = a0.custcategoryid
          join custgrade a12 on a12.custgradeid = a0.custgradeid
          left join groupcustomer a13 on a13.groupcustomerid = a0.groupcustomerid
          " ;
    
    if (isset($_GET['custreq_0_custreqid']) && $_GET['custreq_0_custreqid']!='')
    {
      $where=" where a0.custreqid='".$_GET['custreq_0_custreqid']."'";
    }
    else 
    {
      $where='';
    }
    $dataReader = Yii::app()->db->createCommand($sql.$where)->queryAll();
  
    $this->pdf->title = 'Pendaftaran Customer Baru';
    $this->pdf->AddPage('P');
    $this->pdf->AliasNbPages();
    $this->pdf->AddFont('Tahoma', '', 'tahoma.php');
    $this->pdf->SetFont('Tahoma');
    $this->pdf->checkNewPage(20);
    foreach ($dataReader as $row) 
    {
      $this->pdf->SetFontSize(10);
      $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(40,150));
      $this->pdf->row(array('Tgl Request',' : '. date(Yii::app()->params['dateviewfromdb'], strtotime($row['reqdate']))));
      $this->pdf->row(array('Perusahaan',' : '.$row['companyname']));
      $this->pdf->row(array('Kode Customer',' : '.$row['custcode']));
      $this->pdf->row(array('Nama Lengkap',' : '.$row['fullname']));
      $this->pdf->row(array('Alamat',' : '.$row['address']));
      $this->pdf->row(array('Kota',' : '.$row['cityname']));
      $this->pdf->row(array('Provinsi',' : '.$row['provincename']));
      $this->pdf->row(array('Negara',' : '.$row['countryname']));
      $this->pdf->row(array('Kode Pos',' : '.$row['zipcode']));
      $this->pdf->row(array('Nomor Telepon',' : '.$row['phoneno']));
      $this->pdf->row(array('No. HP',' : '.$row['mobileno']));
      $this->pdf->row(array('No. WA',' : '.$row['wanumber']));
      $this->pdf->row(array('No. Fax',' : '.$row['faxno']));
      $this->pdf->row(array('No. KTP/SIM',' : '.$row['idno']));
      $this->pdf->row(array('Kontak Person',' : '.$row['contactperson']));
      $this->pdf->row(array('Tgl Lahir Suami',' : '.$row['husbandbirthdate']));
      $this->pdf->row(array('Tgl Lahir Istri',' : '.$row['wifebirthdate']));
      $this->pdf->row(array('Tanggal Pernikahan',' : '.$row['weddingdate']));
      $this->pdf->row(array('Pemilik',' : '.$row['owner']));
      $this->pdf->row(array('Telepon Rumah',' : '.$row['homeno']));
      $this->pdf->row(array('Alamat Pemilik',' : '.$row['owneraddress']));
      $this->pdf->row(array('Agama',' : '.$row['religionname']));
      $this->pdf->row(array('Status Gedung',' : '.$row['buildingstatus']));
      $this->pdf->row(array('Jumlah Karyawan',' : '.$row['empno']));
      $this->pdf->row(array('Pramuniaga',' : '.$row['pramuniaga']));
      $this->pdf->row(array('Grup Pajak',' : '.$row['taxgroupname']));
      $this->pdf->row(array('No. NPWP',' : '.$row['taxno']));
      $this->pdf->row(array('Nama Bank',' : '.$row['bankname']));
      $this->pdf->row(array('Nama NPWP',' : '.$row['taxname']));
      $this->pdf->row(array('Alamat Bank',' : '.$row['bankaddress']));
      $this->pdf->row(array('Alamat NPWP',' : '.$row['taxaddress']));
      $this->pdf->row(array('No. Tabungan',' : '.$row['accountno']));
      $this->pdf->row(array('Nama Akun ',' : '.$row['accountname']));
      $this->pdf->row(array('Tgl Lahir Toko ',' : '.$row['birthdatetoko']));
      $this->pdf->row(array('Sales ',' : '.$row['fullname']));
      $this->pdf->row(array('Kredit Limit ',' : '.$row['creditlimit']));
      $this->pdf->row(array('Kode Pembayaran ',' : '.$row['paycode']));
      $this->pdf->row(array('Kategori Harga ',' : '.$row['categoryname']));
      $this->pdf->row(array('Area Penjualan ',' : '.$row['areaname']));
      $this->pdf->row(array('Latitude ',' : '.$row['lat']));
      $this->pdf->row(array('Longitude ',' : '.$row['lng']));
      $this->pdf->row(array('Kategori Customer ',' : '.$row['custcategoryname']));
      $this->pdf->row(array('Customer Grade ',' : '.$row['custogradedesc']));
      $this->pdf->row(array('Nama Group ',' : '.$row['groupname']));
      $this->pdf->checkNewPage(50);
      
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('custreqid'))
      ->setCellValueByColumnAndRow(1,4,$this->getCatalog('custreqno'))
      ->setCellValueByColumnAndRow(2,4,$this->getCatalog('reqdate'))
      ->setCellValueByColumnAndRow(3,4,$this->getCatalog('companyname'))
      ->setCellValueByColumnAndRow(4,4,$this->getCatalog('custcode'))
      ->setCellValueByColumnAndRow(5,4,$this->getCatalog('fullname'))
      ->setCellValueByColumnAndRow(6,4,$this->getCatalog('address'))
      ->setCellValueByColumnAndRow(7,4,$this->getCatalog('cityname'))
      ->setCellValueByColumnAndRow(8,4,$this->getCatalog('provincename'))
      ->setCellValueByColumnAndRow(9,4,$this->getCatalog('zipcode'))
      ->setCellValueByColumnAndRow(10,4,$this->getCatalog('countryname'))
      ->setCellValueByColumnAndRow(11,4,$this->getCatalog('phoneno'))
      ->setCellValueByColumnAndRow(12,4,$this->getCatalog('mobileno'))
      ->setCellValueByColumnAndRow(13,4,$this->getCatalog('wanumber'))
      ->setCellValueByColumnAndRow(14,4,$this->getCatalog('faxno'))
      ->setCellValueByColumnAndRow(15,4,$this->getCatalog('idno'))
      ->setCellValueByColumnAndRow(16,4,$this->getCatalog('contactperson'))
      ->setCellValueByColumnAndRow(17,4,$this->getCatalog('husbandbirthdate'))
      ->setCellValueByColumnAndRow(18,4,$this->getCatalog('owner'))
      ->setCellValueByColumnAndRow(19,4,$this->getCatalog('homeno'))
      ->setCellValueByColumnAndRow(20,4,$this->getCatalog('owneraddress'))
      ->setCellValueByColumnAndRow(21,4,$this->getCatalog('religionname'))
      ->setCellValueByColumnAndRow(22,4,$this->getCatalog('buildingstatus'))
      ->setCellValueByColumnAndRow(23,4,$this->getCatalog('empno'))
      ->setCellValueByColumnAndRow(24,4,$this->getCatalog('pramuniaga'))
      ->setCellValueByColumnAndRow(25,4,$this->getCatalog('taxgroupname'))
      ->setCellValueByColumnAndRow(26,4,$this->getCatalog('taxno'))
      ->setCellValueByColumnAndRow(27,4,$this->getCatalog('bankname'))
      ->setCellValueByColumnAndRow(28,4,$this->getCatalog('taxname'))
      ->setCellValueByColumnAndRow(29,4,$this->getCatalog('bankaddress'))
      ->setCellValueByColumnAndRow(30,4,$this->getCatalog('taxaddress'))
      ->setCellValueByColumnAndRow(31,4,$this->getCatalog('accountno'))
      ->setCellValueByColumnAndRow(32,4,$this->getCatalog('accountname'))
      ->setCellValueByColumnAndRow(33,4,$this->getCatalog('birthdatetoko'))
      ->setCellValueByColumnAndRow(34,4,$this->getCatalog('fullname'))
      ->setCellValueByColumnAndRow(35,4,$this->getCatalog('creditlimit'))
      ->setCellValueByColumnAndRow(36,4,$this->getCatalog('paycode'))
      ->setCellValueByColumnAndRow(37,4,$this->getCatalog('categoryname'))
      ->setCellValueByColumnAndRow(38,4,$this->getCatalog('areaname'))
      ->setCellValueByColumnAndRow(39,4,$this->getCatalog('lat'))
      ->setCellValueByColumnAndRow(40,4,$this->getCatalog('lng'))
      ->setCellValueByColumnAndRow(41,4,$this->getCatalog('custcategoryname'))
      ->setCellValueByColumnAndRow(42,4,$this->getCatalog('custgradename'))
      ->setCellValueByColumnAndRow(43,4,$this->getCatalog('groupname'))
      ->setCellValueByColumnAndRow(44,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['custreqid'])
        ->setCellValueByColumnAndRow(1, $i+1, $row1['custreqno'])
        ->setCellValueByColumnAndRow(2, $i+1, $row1['reqdate'])
        ->setCellValueByColumnAndRow(3, $i+1, $row1['companyname'])
        ->setCellValueByColumnAndRow(4, $i+1, $row1['custcode'])
        ->setCellValueByColumnAndRow(5, $i+1, $row1['fullname'])
        ->setCellValueByColumnAndRow(6, $i+1, $row1['address'])
        ->setCellValueByColumnAndRow(7, $i+1, $row1['cityname'])
        ->setCellValueByColumnAndRow(8, $i+1, $row1['provincename'])
        ->setCellValueByColumnAndRow(9, $i+1, $row1['zipcode'])
        ->setCellValueByColumnAndRow(10, $i+1, $row1['countryname'])
        ->setCellValueByColumnAndRow(11, $i+1, $row1['phoneno'])
        ->setCellValueByColumnAndRow(12, $i+1, $row1['mobileno'])
        ->setCellValueByColumnAndRow(13, $i+1, $row1['wanumber'])
        ->setCellValueByColumnAndRow(14, $i+1, $row1['faxno'])
        ->setCellValueByColumnAndRow(15, $i+1, $row1['idno'])
        ->setCellValueByColumnAndRow(16, $i+1, $row1['contactperson'])
        ->setCellValueByColumnAndRow(17, $i+1, $row1['husbandbirthdate'])
        ->setCellValueByColumnAndRow(18, $i+1, $row1['owner'])
        ->setCellValueByColumnAndRow(19, $i+1, $row1['homeno'])
        ->setCellValueByColumnAndRow(20, $i+1, $row1['owneraddress'])
        ->setCellValueByColumnAndRow(21, $i+1, $row1['religionname'])
        ->setCellValueByColumnAndRow(22, $i+1, $row1['buildingstatus'])
        ->setCellValueByColumnAndRow(23, $i+1, $row1['empno'])
        ->setCellValueByColumnAndRow(24, $i+1, $row1['pramuniaga'])
        ->setCellValueByColumnAndRow(25, $i+1, $row1['taxgroupname'])
        ->setCellValueByColumnAndRow(26, $i+1, $row1['taxno'])
        ->setCellValueByColumnAndRow(27, $i+1, $row1['bankname'])
        ->setCellValueByColumnAndRow(28, $i+1, $row1['taxname'])
        ->setCellValueByColumnAndRow(29, $i+1, $row1['bankaddress'])
        ->setCellValueByColumnAndRow(30, $i+1, $row1['taxaddress'])
        ->setCellValueByColumnAndRow(31, $i+1, $row1['accountno'])
        ->setCellValueByColumnAndRow(32, $i+1, $row1['accountname'])
        ->setCellValueByColumnAndRow(33, $i+1, $row1['birthdatetoko'])
        ->setCellValueByColumnAndRow(34, $i+1, $row1['fullname'])
        ->setCellValueByColumnAndRow(35, $i+1, $row1['creditlimit'])
        ->setCellValueByColumnAndRow(36, $i+1, $row1['paycode'])
        ->setCellValueByColumnAndRow(37, $i+1, $row1['categoryname'])
        ->setCellValueByColumnAndRow(38, $i+1, $row1['areaname'])
        ->setCellValueByColumnAndRow(39, $i+1, $row1['lat'])
        ->setCellValueByColumnAndRow(40, $i+1, $row1['lng'])
        ->setCellValueByColumnAndRow(41, $i+1, $row1['custcategoryname'])
        ->setCellValueByColumnAndRow(42, $i+1, $row1['groupname'])
        ->setCellValueByColumnAndRow(43, $i+1, $row1['custgradename'])
        ->setCellValueByColumnAndRow(44, $i+1, $row1['recordstatus']);
            $i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
