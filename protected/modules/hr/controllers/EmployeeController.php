<?php

class EmployeeController extends AdminController
{
	protected $menuname = 'employee';
	public $module = 'Hr';
	protected $pageTitle = 'Karyawan';
	public $wfname = 'appemployee';
	protected $sqldata = "select a0.employeeid,a0.fullname,a0.addressbookid,a0.oldnik,a0.positionid,a0.employeetypeid,a0.sexid,a0.birthcityid,a0.birthdate,a0.religionid,a0.maritalstatusid,a0.referenceby,a0.joindate,a0.employeestatusid,a0.istrial,a0.barcode,a0.photo,a0.resigndate,a0.levelorgid,a0.email,a0.phoneno,a0.alternateemail,a0.hpno,a0.taxno,a0.dplkno,a0.hpno2,a0.accountno,a3.positionname as positionname,a4.employeetypename as employeetypename,a5.sexname as sexname,a6.cityname as birthcityname,a7.religionname as religionname,a8.maritalstatusname as maritalstatusname,a9.employeestatusname as employeestatusname,a10.levelorgname as levelorgname, a0.addressbookid, a0.bpjskesno
    from employee a0 
    left join position a3 on a3.positionid = a0.positionid
    left join employeetype a4 on a4.employeetypeid = a0.employeetypeid
    left join sex a5 on a5.sexid = a0.sexid
    left join city a6 on a6.cityid = a0.birthcityid
    left join religion a7 on a7.religionid = a0.religionid
    left join maritalstatus a8 on a8.maritalstatusid = a0.maritalstatusid
    left join employeestatus a9 on a9.employeestatusid = a0.employeestatusid
    left join levelorg a10 on a10.levelorgid = a0.levelorgid
  ";
	protected $sqldataaddress = "select a0.addressid,a0.addressbookid,a0.addresstypeid,a0.addressname,a0.rt,a0.rw,a0.cityid,a0.phoneno,a0.faxno,a0.lat,a0.lng,a0.foto,a1.addresstypename as addresstypename,a2.cityname as cityname 
    from address a0 
    left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
    left join city a2 on a2.cityid = a0.cityid
    left join employee a3 on a3.addressbookid = a0.addressbookid
  ";
	protected $sqldataemployeeidentity = "select a0.employeeidentityid,a0.employeeid,a0.identitytypeid,a0.identityname,a0.recordstatus,a1.identitytypename as identitytypename,a0.expiredate,a0.foto 
    from employeeidentity a0 
    left join identitytype a1 on a1.identitytypeid = a0.identitytypeid
    
  ";
	protected $sqldataemployeefamily = "select a0.employeefamilyid,a0.employeeid,a0.familyrelationid,a0.familyname,a0.sexid,a0.cityid,a0.birthdate,a0.educationid,a0.occupationid,a0.recordstatus,a1.familyrelationname as familyrelationname,a2.sexname as sexname,a3.cityname as cityname,a4.educationname as educationname,a5.occupationname as occupationname,a0.bpjskesno
    from employeefamily a0 
    left join familyrelation a1 on a1.familyrelationid = a0.familyrelationid
    left join sex a2 on a2.sexid = a0.sexid
    left join city a3 on a3.cityid = a0.cityid
    left join education a4 on a4.educationid = a0.educationid
    left join occupation a5 on a5.occupationid = a0.occupationid
  ";
	protected $sqldataemployeeeducation = "select a0.employeeeducationid,a0.employeeid,a0.educationid,a0.schoolname,a0.cityid,a0.yeargraduate,a0.isdiploma,a0.schooldegree,a0.recordstatus,a1.educationname as educationname,a2.cityname as cityname,a0.attach
    from employeeeducation a0 
    left join education a1 on a1.educationid = a0.educationid
    left join city a2 on a2.cityid = a0.cityid
  ";
	protected $sqldataemployeeinformal = "select a0.employeeinformalid,a0.employeeid,a0.informalname,a0.organizer,a0.period,a0.isdiploma,a0.sponsoredby,a0.recordstatus,a0.attach
    from employeeinformal a0 
  ";
	protected $sqldataemployeewo = "select employeewoid, employeeid, employer, addressname, telp, firstposition, lastposition, startdate, enddate, spvname, spvposition, spvphone, payamount, reasonleave, attach, recordstatus
    from employeewo a0 
  ";
    
	protected $sqldataemployeecontract = "select a0.contractid,a0.employeeid,a0.contracttype,a0.startdate,a0.enddate,a0.description,a0.recordstatus,a0.attach
    from employeecontract a0 
	";
    
	protected $sqldataemployeeorgstruc = "select a0.*, substring_index(substring_index(structurename, ',', 1), ',', - 1) as structurename, substring_index(substring_index(structurename, ',', 2), ',', - 1) as department, substring_index(substring_index(structurename, ',', 3), ',', - 1) as divisi,a2.companyname,a0.attach,a0.startdate,a0.enddate
    from employeeorgstruc a0 
    left join orgstructure a1 on a1.orgstructureid = a0.orgstructureid 
		left join company a2 on a2.companyid=a1.companyid 
	";
    
  	protected $sqlcount = "select count(1) 
    from employee a0 
    left join position a3 on a3.positionid = a0.positionid
    left join employeetype a4 on a4.employeetypeid = a0.employeetypeid
    left join sex a5 on a5.sexid = a0.sexid
    left join city a6 on a6.cityid = a0.birthcityid
    left join religion a7 on a7.religionid = a0.religionid
    left join maritalstatus a8 on a8.maritalstatusid = a0.maritalstatusid
    left join employeestatus a9 on a9.employeestatusid = a0.employeestatusid
    left join levelorg a10 on a10.levelorgid = a0.levelorgid
  ";
	protected $sqlcountaddress = "select count(1) 
    from address a0 
    left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
    left join city a2 on a2.cityid = a0.cityid
    left join employee a3 on a3.addressbookid = a0.addressbookid
  ";
	protected $sqlcountemployeeidentity = "select count(1) 
    from employeeidentity a0 
    left join identitytype a1 on a1.identitytypeid = a0.identitytypeid
  ";
	protected $sqlcountemployeefamily = "select count(1) 
    from employeefamily a0 
    left join familyrelation a1 on a1.familyrelationid = a0.familyrelationid
    left join sex a2 on a2.sexid = a0.sexid
    left join city a3 on a3.cityid = a0.cityid
    left join education a4 on a4.educationid = a0.educationid
    left join occupation a5 on a5.occupationid = a0.occupationid
  ";
	protected $sqlcountemployeeeducation = "select count(1) 
    from employeeeducation a0 
    left join education a1 on a1.educationid = a0.educationid
    left join city a2 on a2.cityid = a0.cityid
  ";
	protected $sqlcountemployeeinformal = "select count(1) 
    from employeeinformal a0 
  ";
	protected $sqlcountemployeewo = "select count(1) 
    from employeewo a0 
  ";
    
	protected $sqlcountemployeecontract = "select count(1) 
    from employeecontract a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";
    
	protected $sqlcountemployeeorgstruc = "select count(1) 
    from employeeorgstruc a0 
    left join orgstructure a1 on a0.orgstructureid = a1.orgstructureid 
		left join company a2 on a2.companyid=a1.companyid 
  ";
/*	
+ '&employeeid='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&resigndate='+$("input[name='dlg_search_resigndate']").val()
*/
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.fullname is not null ";
		if (isset($_REQUEST['id']))
		{
			if (($_REQUEST['id'] !== '0') && ($_REQUEST['id'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.employeeid in (".$_REQUEST['id'].")";
				}
				else
				{
					$where .= " and a0.employeeid in (".$_REQUEST['id'].")";
				}
			}
		}
		if ((isset($_REQUEST['companyname'])) && $_REQUEST['companyname']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeeorgstruc b0 join orgstructure b1 on b1.orgstructureid = b0.orgstructureid join company b2 on b2.companyid = b1.companyid where b0.recordstatus=1 and b2.companyname like '%". $_REQUEST['companyname']."%') ";
		}
		if ((isset($_REQUEST['fullname'])) && $_REQUEST['fullname']!=='')
		{				
			$where .= " and a0.fullname like '%". $_REQUEST['fullname']."%' ";
		}
		if ((isset($_REQUEST['oldnik'])) && $_REQUEST['oldnik']!=='')
		{				
			$where .= " and a0.oldnik like '%". $_REQUEST['oldnik']."%' ";
		}
		if((isset($_REQUEST['employeetypename'])) && $_REQUEST['employeetypename']!=='')
		{
			$where .= " and a4.employeetypename like '%". $_REQUEST['employeetypename']."%' ";
		}
		if((isset($_REQUEST['sexname'])) && $_REQUEST['sexname']!=='')
		{
			$where .= " and a5.sexname like '%". $_REQUEST['sexname']."%' ";
		}
		if((isset($_REQUEST['birthdate'])) && $_REQUEST['birthdate']!=='')
		{
			$where .= " and a0.birthdate like '%". $_REQUEST['birthdate']."%' ";
		}
		if((isset($_REQUEST['religionname'])) && $_REQUEST['religionname']!=='')
		{
			$where .= " and a7.religionname like '%". $_REQUEST['religionname']."%' ";
		}
		if((isset($_REQUEST['employeestatusname'])) && $_REQUEST['employeestatusname']!=='')
		{
			$where .= " and a9.employeestatusname like '%". $_REQUEST['employeestatusname']."%' "; 
		}
		if ((isset($_REQUEST['contract'])) && $_REQUEST['contract']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeecontract b0 where b0.recordstatus=1 and b0.enddate like '%". $_REQUEST['contract']."%') ";
		}
		if((isset($_REQUEST['isresign'])) && $_REQUEST['isresign']!=='')
		{
			if ($_REQUEST['isresign'] == 'Yes')
			{
				$where .= " and a0.resigndate > '1970-01-01' ";
			}
			else
			{
				$where .= " and (a0.resigndate <= '1970-01-01' or a0.resigndate is null) ";
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
			'keyField'=>'employeeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'employeeid','fullname','addressbookid','addressid','addresstypeid','oldnik','positionid','employeetypeid','sexid','birthcityid','birthdate','religionid','maritalstatusid','referenceby','joindate','istrial','employeestatusid','istrial','barcode','photo','resigndate','levelorgid','email','phoneno','alternateemail','hpno','taxno','dplkno','bpjskesno','hpno2','accountno'
				),
				'defaultOrder' => array( 
					'employeeid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountaddress .= ' where a3.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataaddress .= ' where a3.employeeid = '.$_REQUEST['employeeid'];
		}
		$countaddress = Yii::app()->db->createCommand($this->sqlcountaddress)->queryScalar();
		$dataProvideraddress=new CSqlDataProvider($this->sqldataaddress,array(
					'totalItemCount'=>$countaddress,
					'keyField'=>'addressid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'addressid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeeidentity .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeeidentity .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeeidentity = Yii::app()->db->createCommand($this->sqlcountemployeeidentity)->queryScalar();
		$dataProvideremployeeidentity=new CSqlDataProvider($this->sqldataemployeeidentity,array(
					'totalItemCount'=>$countemployeeidentity,
					'keyField'=>'employeeidentityid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeeidentityid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeefamily .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeefamily .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeefamily = Yii::app()->db->createCommand($this->sqlcountemployeefamily)->queryScalar();
		$dataProvideremployeefamily=new CSqlDataProvider($this->sqldataemployeefamily,array(
					'totalItemCount'=>$countemployeefamily,
					'keyField'=>'employeefamilyid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeefamilyid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeeeducation .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeeeducation .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeeeducation = Yii::app()->db->createCommand($this->sqlcountemployeeeducation)->queryScalar();
		$dataProvideremployeeeducation=new CSqlDataProvider($this->sqldataemployeeeducation,array(
					'totalItemCount'=>$countemployeeeducation,
					'keyField'=>'employeeeducationid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeeeducationid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeeinformal .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeeinformal .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeeinformal = Yii::app()->db->createCommand($this->sqlcountemployeeinformal)->queryScalar();
		$dataProvideremployeeinformal=new CSqlDataProvider($this->sqldataemployeeinformal,array(
					'totalItemCount'=>$countemployeeinformal,
					'keyField'=>'employeeinformalid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeeinformalid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeewo .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeewo .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeewo = Yii::app()->db->createCommand($this->sqlcountemployeewo)->queryScalar();
		$dataProvideremployeewo=new CSqlDataProvider($this->sqldataemployeewo,array(
					'totalItemCount'=>$countemployeewo,
					'keyField'=>'employeewoid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeewoid' => CSort::SORT_DESC
						),
					),
					));
        
        if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeecontract .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeecontract .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeecontract = Yii::app()->db->createCommand($this->sqlcountemployeecontract)->queryScalar();
        $dataProvideremployeecontract=new CSqlDataProvider($this->sqldataemployeecontract,array(
					'totalItemCount'=>$countemployeecontract,
					'keyField'=>'contractid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'contractid' => CSort::SORT_DESC
						),
					),
					));
        
        if (isset($_REQUEST['employeeid']))
		{
			$this->sqlcountemployeeorgstruc .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
			$this->sqldataemployeeorgstruc .= ' where a0.employeeid = '.$_REQUEST['employeeid'];
		}
		$countemployeeorgstruc = Yii::app()->db->createCommand($this->sqlcountemployeeorgstruc)->queryScalar();
        $dataProvideremployeeorgstruc=new CSqlDataProvider($this->sqldataemployeeorgstruc,array(
					'totalItemCount'=>$countemployeeorgstruc,
					'keyField'=>'employeeorgstrucid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'employeeorgstrucid' => CSort::SORT_DESC
						),
					),
					));
        
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvideraddress'=>$dataProvideraddress,'dataProvideremployeeidentity'=>$dataProvideremployeeidentity,'dataProvideremployeefamily'=>$dataProvideremployeefamily,'dataProvideremployeeeducation'=>$dataProvideremployeeeducation,'dataProvideremployeeinformal'=>$dataProvideremployeeinformal,'dataProvideremployeewo'=>$dataProvideremployeewo,'dataProvideremployeecontract'=>$dataProvideremployeecontract,'dataProvideremployeeorgstruc'=>$dataProvideremployeeorgstruc));
	}
  public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function actionUploadidentity()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/identity'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/identity/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/identity/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadeducation()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/education'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/education/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/education/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadinformal()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/informal'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/informal/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/informal/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadwo()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/wo'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/wo/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/wo/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadcontract()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/contract'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/contract/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/contract/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionUploadorgstruc()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/orgstruc'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/orgstruc/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/orgstruc/';
		parent::actionUpload();
		echo $this->uploaded_file;
	}
	public function actionCreate()
	{
		parent::actionCreate();
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
		try
		{   
            $sql = "insert into employee (oldnik) values ('-')";
            $connection->createCommand($sql)->execute();
            
            $sql1 = "select last_insert_id()";
            $employeeid = $connection->createCommand($sql1)->queryScalar();
            
            $sql = "insert into addressbook (isemployee,fullname) values ('1','karyawan baru')";
            $connection->createCommand($sql)->execute();
            
            $sql2 = "select last_insert_id()";
            $addressbookid = $connection->createCommand($sql2)->queryScalar();
            
            $update = "update employee set addressbookid = {$addressbookid} where employeeid = {$employeeid}";
            $cmd = $connection->createCommand($update)->execute();
            $transaction->commit();
        }
        catch (CDbException $e)
        {
            $transaction->rollBack();
			$this->getMessage('error',$e->getMessage());
        }
        
        echo CJSON::encode(array(
			'status'=>'success',
			'employeeid'=>$employeeid,
            'addressbookid'=>$addressbookid,
			"birthdate" =>date("Y-m-d"),
            "joindate" =>date("Y-m-d"),
            "oldnik"=>'-'
		));
	}
  public function actionCreateaddress()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}
  public function actionCreateemployeeidentity()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreateemployeefamily()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"birthdate" =>date("Y-m-d")
		));
	}
  public function actionCreateemployeeeducation()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"yeargraduate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insemployee")
		));
	}
  public function actionCreateemployeeinformal()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreateemployeewo()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreateemployeecontract()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
            'startdate'=>date('Y-m-d'),
            'enddate'=>date('Y-m-d'),
		));
	}
  public function actionCreateemployeeorgstructure()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.employeeid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'employeeid'=>$model['employeeid'],
                        'addressbookid'=>$model['addressbookid'],
						'fullname'=>$model['fullname'],
						'oldnik'=>$model['oldnik'],
						'positionid'=>$model['positionid'],
						'employeetypeid'=>$model['employeetypeid'],
						'sexid'=>$model['sexid'],
						'birthcityid'=>$model['birthcityid'],
						'birthdate'=>$model['birthdate'],
						'religionid'=>$model['religionid'],
						'maritalstatusid'=>$model['maritalstatusid'],
						'referenceby'=>$model['referenceby'],
						'joindate'=>$model['joindate'],
						'employeestatusid'=>$model['employeestatusid'],
						'barcode'=>$model['barcode'],
						'photo'=>$model['photo'],
						'resigndate'=>$model['resigndate'],
						'levelorgid'=>$model['levelorgid'],
						'email'=>$model['email'],
						'phoneno'=>$model['phoneno'],
						'alternateemail'=>$model['alternateemail'],
						'hpno'=>$model['hpno'],
						'taxno'=>$model['taxno'],
						'dplkno'=>$model['dplkno'],
						'hpno2'=>$model['hpno2'],
						'accountno'=>$model['accountno'],
						'istrial'=>$model['istrial'],
						'positionname'=>$model['positionname'],
						'employeetypename'=>$model['employeetypename'],
						'sexname'=>$model['sexname'],
						'birthcityname'=>$model['birthcityname'],
						'religionname'=>$model['religionname'],
						'maritalstatusname'=>$model['maritalstatusname'],
						'employeestatusname'=>$model['employeestatusname'],
						'levelorgname'=>$model['levelorgname'],
						'bpjskesno'=>$model['bpjskesno'],

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
			$model = Yii::app()->db->createCommand($this->sqldataaddress.' where addressid = '.$id.'')->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
                    'addressid'=>$model['addressid'],
					'addresstypeid'=>$model['addresstypeid'],
                    'addressbookid'=>$model['addressbookid'],
					'addressname'=>$model['addressname'],
					'rt'=>$model['rt'],
					'rw'=>$model['rw'],
					'cityid'=>$model['cityid'],
					'lat'=>$model['lat'],
					'lng'=>$model['lng'],
					'addresstypename'=>$model['addresstypename'],
					'cityname'=>$model['cityname'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeeidentity()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
            #$employeeid = $_POST['employeeid'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeeidentity.' where employeeidentityid = '.$id)->queryRow();
			#$model = Yii::app()->db->createCommand($this->sqldataemployeeidentity.' where a2.employeeid = '.$employeeid)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'employeeidentityid'=>$model['employeeidentityid'],
					'identitytypeid'=>$model['identitytypeid'],
					'identityname'=>$model['identityname'],
					'expiredate'=>$model['expiredate'],
					'foto'=>$model['foto'],
					'recordstatus'=>$model['recordstatus'],
					'identitytypename'=>$model['identitytypename'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeefamily()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeefamily.' where employeefamilyid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'employeefamilyid'=>$model['employeefamilyid'],
					'familyrelationid'=>$model['familyrelationid'],
					'familyname'=>$model['familyname'],
					'sexid'=>$model['sexid'],
					'cityid'=>$model['cityid'],
					'birthdate'=>$model['birthdate'],
					'educationid'=>$model['educationid'],
					'occupationid'=>$model['occupationid'],
					'bpjskesno'=>$model['bpjskesno'],
					'recordstatus'=>$model['recordstatus'],
					'familyrelationname'=>$model['familyrelationname'],
					'sexname'=>$model['sexname'],
					'cityname'=>$model['cityname'],
					'educationname'=>$model['educationname'],
					'occupationname'=>$model['occupationname'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeeeducation()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeeeducation.' where employeeeducationid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'employeeeducationid'=>$model['employeeeducationid'],
					'educationid'=>$model['educationid'],
					'schoolname'=>$model['schoolname'],
					'cityid'=>$model['cityid'],
					'yeargraduate'=>$model['yeargraduate'],
					'isdiploma'=>$model['isdiploma'],
					'schooldegree'=>$model['schooldegree'],
					'recordstatus'=>$model['recordstatus'],
					'educationname'=>$model['educationname'],
					'cityname'=>$model['cityname'],
					'attach'=>$model['attach'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeeinformal()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeeinformal.' where employeeinformalid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'employeeinformalid'=>$model['employeeinformalid'],
					'informalname'=>$model['informalname'],
					'organizer'=>$model['organizer'],
					'period'=>$model['period'],
					'isdiploma'=>$model['isdiploma'],
					'sponsoredby'=>$model['sponsoredby'],
					'attach'=>$model['attach'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeewo()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeewo.' where employeewoid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'employeewoid'=>$model['employeewoid'],
					'employer'=>$model['employer'],
					'addressname'=>$model['addressname'],
					'telp'=>$model['telp'],
					'firstposition'=>$model['firstposition'],
					'lastposition'=>$model['lastposition'],
					'startdate'=>$model['startdate'],
					'enddate'=>$model['enddate'],
					'spvname'=>$model['spvname'],
					'spvposition'=>$model['spvposition'],
					'spvphone'=>$model['spvphone'],
					'payamount'=>$model['payamount'],
					'reasonleave'=>$model['reasonleave'],
					'attach'=>$model['attach'],
					'recordstatus'=>$model['recordstatus'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeecontract()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeecontract.' where contractid = '.$id.'')->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
                    'contractid'=>$model['contractid'],
					'contracttype'=>$model['contracttype'],
                    'startdate'=>$model['startdate'],
                    'enddate'=>$model['enddate'],
                    'description'=>$model['description'],
          			'attach'=>$model['attach'],
                    'recordstatus'=>$model['recordstatus'],
				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateemployeeorgstructure()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataemployeeorgstruc.' where employeeorgstrucid = '.$id.'')->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
                    'employeeorgstrucid'=>$model['employeeorgstrucid'],
					'employeeid'=>$model['employeeid'],
                    'orgstructureid'=>$model['orgstructureid'],
                    'startdate'=>$model['startdate'],
                    'enddate'=>$model['enddate'],
                    'structurename'=>$model['structurename'],
         			'attach'=>$model['attach'],
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
			//array('companyid','string','emptycompanyid'),
      array('fullname','string','emptyfullname'),
      array('addressbookid','string','emptyaddressbookid'),
      array('positionid','string','emptypositionid'),
      array('employeetypeid','string','emptyemployeetypeid'),
      array('sexid','string','emptysexid'),
      #array('addressid','string','emptyaddressid'),
      array('birthcityid','string','emptybirthcityid'),
      array('maritalstatusid','string','emptymaritalstatusid'),
      #array('referenceby','string','emptyreferenceby'),
      array('employeestatusid','string','emptyemployeestatusid'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updateemployeecms(:vid,:vfullname,:vaddressbookid,:voldnik,:vpositionid,:vemployeetypeid,:vsexid,:vbirthcityid,:vbirthdate,:vreligionid,:vmaritalstatusid,:vreferenceby,:vjoindate,:vemployeestatusid,:vistrial,:vbarcode,:vphoto,:vresigndate,:vlevelorgid,:vemail,:vphoneno,:valternateemail,:vhpno,:vtaxno,:vdplkno,:vbpjskesno,:vhpno2,:vaccountno,:vlastupdateby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['employeeid'],PDO::PARAM_STR);
                $command->bindvalue(':vfullname',(($_POST['fullname']!=='')?$_POST['fullname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
                $command->bindvalue(':voldnik',(($_POST['oldnik']!=='')?$_POST['oldnik']:null),PDO::PARAM_STR);
                //$command->bindvalue(':vorgstructureid','3',PDO::PARAM_STR);
                $command->bindvalue(':vpositionid',(($_POST['positionid']!=='')?$_POST['positionid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vemployeetypeid',(($_POST['employeetypeid']!=='')?$_POST['employeetypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsexid',(($_POST['sexid']!=='')?$_POST['sexid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbirthcityid',(($_POST['birthcityid']!=='')?$_POST['birthcityid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbirthdate',(($_POST['birthdate']!=='')?$_POST['birthdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vreligionid',(($_POST['religionid']!=='')?$_POST['religionid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmaritalstatusid',(($_POST['maritalstatusid']!=='')?$_POST['maritalstatusid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vreferenceby',(($_POST['referenceby']!=='')?$_POST['referenceby']:null),PDO::PARAM_STR);
                $command->bindvalue(':vjoindate',(($_POST['joindate']!=='')?$_POST['joindate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vemployeestatusid',(($_POST['employeestatusid']!=='')?$_POST['employeestatusid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vistrial',(($_POST['istrial']!=='')?$_POST['istrial']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbarcode',(($_POST['barcode']!=='')?$_POST['barcode']:null),PDO::PARAM_STR);
                $command->bindvalue(':vphoto',(($_POST['photo']!=='')?$_POST['photo']:null),PDO::PARAM_STR);
                $command->bindvalue(':vresigndate',(($_POST['resigndate']!=='')?$_POST['resigndate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlevelorgid',(($_POST['levelorgid']!=='')?$_POST['levelorgid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vemail',(($_POST['email']!=='')?$_POST['email']:null),PDO::PARAM_STR);
                $command->bindvalue(':vphoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
                $command->bindvalue(':valternateemail',(($_POST['alternateemail']!=='')?$_POST['alternateemail']:null),PDO::PARAM_STR);
                $command->bindvalue(':vhpno',(($_POST['hpno']!=='')?$_POST['hpno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdplkno',(($_POST['dplkno']!=='')?$_POST['dplkno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbpjskesno',(($_POST['bpjskesno']!=='')?$_POST['bpjskesno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vhpno2',(($_POST['hpno2']!=='')?$_POST['hpno2']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccountno',(($_POST['accountno']!=='')?$_POST['accountno']:null),PDO::PARAM_STR);
				$command->bindvalue(':vlastupdateby',Yii::app()->user->id,PDO::PARAM_STR);
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
	public function actionSaveaddress()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('addressbookid','string','emptyaddressbookid'),
      array('addresstypeid','string','emptyaddresstypeid'),
      array('addressname','string','emptyaddressname'),
      array('rt','string','emptyrt'),
      array('rw','string','emptyrw'),
      array('cityid','string','emptycityid'),
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
					$sql = 'call updateaddress(:vaddressid,:vaddressbookid,:vaddresstypeid,:vaddressname,:vrt,:vrw,:vcityid,:vphoneno,:vfaxno,:vlat,:vlng,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertaddress(:vaddressbookid,:vaddresstypeid,:vaddressname,:vrt,:vrw,:vcityid,:vphoneno,:vfaxno,:vlat,:vlng,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vaddressid',$_POST['addressid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vaddresstypeid',(($_POST['addresstypeid']!=='')?$_POST['addresstypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaddressname',(($_POST['addressname']!=='')?$_POST['addressname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrt',(($_POST['rt']!=='')?$_POST['rt']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrw',(($_POST['rw']!=='')?$_POST['rw']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vphoneno',null,PDO::PARAM_STR);
                $command->bindvalue(':vfaxno',null,PDO::PARAM_STR);
                $command->bindvalue(':vlat',(($_POST['lat']!=='')?$_POST['lat']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlng',(($_POST['lng']!=='')?$_POST['lng']:null),PDO::PARAM_STR);
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
	public function actionSaveemployeeidentity()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
      array('identitytypeid','string','emptyidentitytypeid'),
      array('identityname','string','emptyidentityname'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeeidentityid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeeidentity(:vid,:vemployeeid,:videntitytypeid,:videntityname,:vexpiredate,:vfoto,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeeidentity(:vemployeeid,:videntitytypeid,:videntityname,:vexpiredate,:vfoto,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeeidentityid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':videntitytypeid',(($_POST['identitytypeid']!=='')?$_POST['identitytypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':videntityname',(($_POST['identityname']!=='')?$_POST['identityname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vexpiredate',(($_POST['expiredate']!=='')?$_POST['expiredate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vfoto',(($_POST['foto']!=='')?$_POST['foto']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
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
	public function actionSaveemployeefamily()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
      array('familyrelationid','string','emptyfamilyrelationid'),
      array('familyname','string','emptyfamilyname'),
      array('sexid','string','emptysexid'),
      array('cityid','string','emptycityid'),
      array('educationid','string','emptyeducationid'),
      array('occupationid','string','emptyoccupationid'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeefamilyid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeefamily(:vemployeefamilyid,:vemployeeid,:vfamilyrelationid,:vfamilyname,:vsexid,:vcityid,:vbirthdate,:veducationid,:voccupationid,:vbpjskesno,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeefamily(:vemployeeid,:vfamilyrelationid,:vfamilyname,:vsexid,:vcityid,:vbirthdate,:veducationid,:voccupationid,:vbpjskesno,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vemployeefamilyid',$_POST['employeefamilyid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vfamilyrelationid',(($_POST['familyrelationid']!=='')?$_POST['familyrelationid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vfamilyname',(($_POST['familyname']!=='')?$_POST['familyname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsexid',(($_POST['sexid']!=='')?$_POST['sexid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbirthdate',(($_POST['birthdate']!=='')?$_POST['birthdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':veducationid',(($_POST['educationid']!=='')?$_POST['educationid']:null),PDO::PARAM_STR);
                $command->bindvalue(':voccupationid',(($_POST['occupationid']!=='')?$_POST['occupationid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbpjskesno',(($_POST['bpjskesno']!=='')?$_POST['bpjskesno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
	public function actionSaveemployeeeducation()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
      array('educationid','string','emptyeducationid'),
      array('cityid','string','emptycityid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeeeducationid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeeeducation(:vid,:vemployeeid,:veducationid,:vschoolname,:vcityid,:vyeargraduate,:visdiploma,:vschooldegree,:vattach,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeeeducation(:vemployeeid,:veducationid,:vschoolname,:vcityid,:vyeargraduate,:visdiploma,:vschooldegree,:vattach,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeeeducationid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':veducationid',(($_POST['educationid']!=='')?$_POST['educationid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vschoolname',(($_POST['schoolname']!=='')?$_POST['schoolname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vyeargraduate',(($_POST['yeargraduate']!=='')?$_POST['yeargraduate']:null),PDO::PARAM_STR);
                $command->bindvalue(':visdiploma',(($_POST['isdiploma']!=='')?$_POST['isdiploma']:null),PDO::PARAM_STR);
                $command->bindvalue(':vschooldegree',(($_POST['schooldegree']!=='')?$_POST['schooldegree']:null),PDO::PARAM_STR);
                $command->bindvalue(':vattach',(($_POST['attach']!=='')?$_POST['attach']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
	public function actionSaveemployeeinformal()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeeinformalid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeeinformal(:vid,:vemployeeid,:vinformalname,:vorganizer,:vperiod,:visdiploma,:vsponsoredby,:vattach,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeeinformal(:vemployeeid,:vinformalname,:vorganizer,:vperiod,:visdiploma,:vsponsoredby,:vattach,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeeinformalid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vinformalname',(($_POST['informalname']!=='')?$_POST['informalname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vorganizer',(($_POST['organizer']!=='')?$_POST['organizer']:null),PDO::PARAM_STR);
                $command->bindvalue(':vperiod',(($_POST['period']!=='')?$_POST['period']:null),PDO::PARAM_STR);
                $command->bindvalue(':visdiploma',(($_POST['isdiploma']!=='')?$_POST['isdiploma']:null),PDO::PARAM_STR);
                $command->bindvalue(':vsponsoredby',(($_POST['sponsoredby']!=='')?$_POST['sponsoredby']:null),PDO::PARAM_STR);
                $command->bindvalue(':vattach',(($_POST['attach']!=='')?$_POST['attach']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
	public function actionSaveemployeewo()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeewoid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeewo(:vid,:vemployeeid,:vemployer,:vaddressname,:vtelp,:vfirstposition,:vlastposition,:vstartdate,:venddate,:vspvname,:vspvposition,:vspvphone,:vpayamount,:vreasonleave,:vattach,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeewo(:vemployeeid,:vemployer,:vaddressname,:vtelp,:vfirstposition,:vlastposition,:vstartdate,:venddate,:vspvname,:vspvposition,:vspvphone,:vpayamount,:vreasonleave,:vattach,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeewoid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vemployer',(($_POST['employer']!=='')?$_POST['employer']:null),PDO::PARAM_STR);
				$command->bindvalue(':vaddressname',(($_POST['addressname']!=='')?$_POST['addressname']:null),PDO::PARAM_STR);
				$command->bindvalue(':vtelp',(($_POST['telp']!=='')?$_POST['telp']:null),PDO::PARAM_STR);
				$command->bindvalue(':vfirstposition',(($_POST['firstposition']!=='')?$_POST['firstposition']:null),PDO::PARAM_STR);
				$command->bindvalue(':vlastposition',(($_POST['lastposition']!=='')?$_POST['lastposition']:null),PDO::PARAM_STR);
				$command->bindvalue(':vstartdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
				$command->bindvalue(':venddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
				$command->bindvalue(':vspvname',(($_POST['spvname']!=='')?$_POST['spvname']:null),PDO::PARAM_STR);
				$command->bindvalue(':vspvposition',(($_POST['spvposition']!=='')?$_POST['spvposition']:null),PDO::PARAM_STR);
				$command->bindvalue(':vspvphone',(($_POST['spvphone']!=='')?$_POST['spvphone']:null),PDO::PARAM_STR);
				$command->bindvalue(':vpayamount',(($_POST['payamount']!=='')?$_POST['payamount']:null),PDO::PARAM_STR);
				$command->bindvalue(':vreasonleave',(($_POST['reasonleave']!=='')?$_POST['reasonleave']:null),PDO::PARAM_STR);
                $command->bindvalue(':vattach',(($_POST['attach']!=='')?$_POST['attach']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
	public function actionSaveemployeecontract()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
            array('employeeid','string','emptyemployeeid'),
            array('contracttype','string','emptycontracttype'),
            array('startdate','string','emptystartdate'),
            array('enddate','string','emptyenddate'),
    ));
		if ($error == false)
		{
			$id = $_POST['contractid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeecontract(:vid,:vemployeeid,:vcontracttype,:vstartdate,:venddate,:vdescription,:vattach,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeecontract (:vemployeeid,:vcontracttype,:vstartdate,:venddate,:vdescription,:vattach,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['contractid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vcontracttype',(($_POST['contracttype']!=='')?$_POST['contracttype']:null),PDO::PARAM_STR);
				$command->bindvalue(':vstartdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':venddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdescription',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
                $command->bindvalue(':vattach',(($_POST['attach']!=='')?$_POST['attach']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
  public function actionSaveemployeeorgstructure()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
            array('employeeid','string','emptyemployeeid'),
            array('orgstructureid','string','emptycontracttype'),
            array('startdate','string','emptystartdate'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeeorgstrucid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updateemployeeorgstruc(:vid,:vemployeeid,:vorgstructureid,:vstartdate,:venddate,:vattach,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertemployeeorgstruc(:vemployeeid,:vorgstructureid,:vstartdate,:venddate,:vattach,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeeorgstrucid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vorgstructureid',(($_POST['orgstructureid']!=='')?$_POST['orgstructureid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vstartdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
				$command->bindvalue(':venddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
				$command->bindvalue(':vattach',(($_POST['attach']!=='')?$_POST['attach']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveemployee(:vid,:vcreatedby)';
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
  public function actionPurgeemployeeidentity()
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
				$sql = "delete from employeeidentity where employeeidentityid = ".$id[$i];
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
  public function actionPurgeemployeefamily()
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
				$sql = "delete from employeefamily where employeefamilyid = ".$id[$i];
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
  public function actionPurgeemployeeeducation()
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
				$sql = "delete from employeeeducation where employeeeducationid = ".$id[$i];
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
  public function actionPurgeemployeeinformal()
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
				$sql = "delete from employeeinformal where employeeinformalid = ".$id[$i];
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
  public function actionPurgeemployeewo()
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
				$sql = "delete from employeewo where employeewoid = ".$id[$i];
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
  public function actionPurgeemployeecontract()
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
				$sql = "delete from employeecontract where contractid = ".$id[$i];
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
  public function actionpurgeemployeeorgstructure()
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
				$sql = "delete from employeeorgstruc where employeeorgstrucid = ".$id[$i];
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
				$sql = 'call Deleteemployee(:vid,:vcreatedby)';
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
        $this->pdf->title='Rincian Data Karyawan';
        //$this->pdf->subtitle='Periode :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
        
		$sql = "select a0.employeeid,a0.fullname,a0.addressbookid,a0.oldnik,a0.positionid,a0.employeetypeid,a0.sexid,a0.birthcityid,a0.birthdate,a0.religionid,a0.maritalstatusid,a0.referenceby,a0.joindate,a0.employeestatusid,a0.istrial,a0.barcode,a0.photo,a0.resigndate,a0.levelorgid,a0.email,a0.phoneno,a0.alternateemail,a0.hpno,a0.taxno,a0.dplkno,a0.hpno2,a0.accountno,a1.companyname as companyname,a2.structurename as structurename,a3.positionname as positionname,a4.employeetypename as employeetypename,a5.sexname as sexname,a6.cityname as cityname,a7.religionname as religionname,a8.maritalstatusname as maritalstatusname,a9.employeestatusname as employeestatusname,a10.levelorgname as levelorgname, a0.addressbookid
        from employee a0 
        left join position a3 on a3.positionid = a0.positionid
        left join employeetype a4 on a4.employeetypeid = a0.employeetypeid
        left join sex a5 on a5.sexid = a0.sexid
        left join city a6 on a6.cityid = a0.birthcityid
        left join religion a7 on a7.religionid = a0.religionid
        left join maritalstatus a8 on a8.maritalstatusid = a0.maritalstatusid
        left join employeestatus a9 on a9.employeestatusid = a0.employeestatusid
        left join levelorg a10 on a10.levelorgid = a0.levelorgid 
        left join employeeorgstruc a11 on a11.employeeid = a0.employeeid 
        left join orgstructure a2 on a2.orgstructureid = a11.orgstructureid
        left join company a1 on a1.companyid = a2.companyid ";
        
        if ($_GET['employee_0_employeeid'] !== '') {
				$where =  " where a0.employeeid in (".$_GET['employee_0_employeeid'].")";
		}else{
            $where='';
        }
        
        if(isset($companyid) && $companyid!=''){
            $where .= " AND a2.companyid = '".$companyid."'";
        }
        $connection = Yii::app()->db;
		$command=$connection->createCommand($sql.$where);
		$dataReader=$command->queryAll();

		//masukkan judul
		//$this->pdf->title=$this->getcatalog('employee');
		$this->pdf->AddPage('P');
		$this->pdf->AliasNBPages();
		$this->pdf->SetFont('Arial','',10);
        
		foreach($dataReader as $row)
		{
			//masukkan baris untuk cetak
            $this->pdf->checkNewPage(125);
			$this->pdf->text(10,$this->pdf->gety()+5,'Nama ');$this->pdf->text(48,$this->pdf->gety()+5,': '.$row['fullname']);
			$this->pdf->text(10,$this->pdf->gety()+10,'Posisi');$this->pdf->text(48,$this->pdf->gety()+10,': '.$row['positionname']);
            $this->pdf->setY($this->pdf->getY()-5);
			$this->pdf->text(10,$this->pdf->gety()+20,'Level ');$this->pdf->text(48,$this->pdf->gety()+20,': '.$row['levelorgname']);
			$this->pdf->text(10,$this->pdf->gety()+25,'NIK ');$this->pdf->text(48,$this->pdf->gety()+25,': '.$row['oldnik']);
			$this->pdf->text(10,$this->pdf->gety()+35,'Jenis Karyawan');$this->pdf->text(48,$this->pdf->gety()+35,': '.$row['employeetypename']);
			$this->pdf->text(10,$this->pdf->gety()+40,'Jenis Kelamin');$this->pdf->text(48,$this->pdf->gety()+40,': '.$row['sexname']);
			$this->pdf->text(10,$this->pdf->gety()+45,'Kota Kelahiran');$this->pdf->text(48,$this->pdf->gety()+45,': '.$row['cityname']);
			$this->pdf->text(10,$this->pdf->gety()+50,'Tanggal Lahir');$this->pdf->text(48,$this->pdf->gety()+50,': '.$row['birthdate']);
			$this->pdf->text(10,$this->pdf->gety()+55,'Agama');$this->pdf->text(48,$this->pdf->gety()+55,': '.$row['religionname']);
			$this->pdf->text(10,$this->pdf->gety()+60,'Status Nikah');$this->pdf->text(48,$this->pdf->gety()+60,': '.$row['maritalstatusname']);
			$this->pdf->text(10,$this->pdf->gety()+65,'Referensi');$this->pdf->text(48,$this->pdf->gety()+65,': '.$row['referenceby']);
			$this->pdf->text(10,$this->pdf->gety()+70,'Tgl Gabung');$this->pdf->text(48,$this->pdf->gety()+70,': '.$row['joindate']);
			$this->pdf->text(10,$this->pdf->gety()+75,'Status Karywan');$this->pdf->text(48,$this->pdf->gety()+75,': '.$row['employeestatusname']);
			$this->pdf->text(10,$this->pdf->gety()+80,'Percobaaan');$this->pdf->text(48,$this->pdf->gety()+80,': '.$row['istrial']);
			$this->pdf->text(10,$this->pdf->gety()+85,'Tanggal Resign');$this->pdf->text(48,$this->pdf->gety()+85,': '.$row['resigndate']);
			$this->pdf->text(10,$this->pdf->gety()+90,'Email');$this->pdf->text(48,$this->pdf->gety()+90,': '.$row['email']);
			$this->pdf->text(10,$this->pdf->gety()+95,'Telp');$this->pdf->text(48,$this->pdf->gety()+95,': '.$row['phoneno']);
			$this->pdf->text(10,$this->pdf->gety()+100,'Email Cadangan');$this->pdf->text(48,$this->pdf->gety()+100,': '.$row['alternateemail']);
			$this->pdf->text(10,$this->pdf->gety()+105,'No HP');$this->pdf->text(48,$this->pdf->gety()+105,': '.$row['hpno']);
			$this->pdf->text(10,$this->pdf->gety()+110,'No HP ke-2');$this->pdf->text(48,$this->pdf->gety()+110,': '.$row['hpno2']);
			$this->pdf->text(10,$this->pdf->gety()+115,'NPWP');$this->pdf->text(48,$this->pdf->gety()+115,': '.$row['taxno']);
			$this->pdf->text(10,$this->pdf->gety()+120,'No. Kartu BPJS');$this->pdf->text(48,$this->pdf->gety()+120,': '.$row['dplkno']);
			$this->pdf->text(10,$this->pdf->gety()+125,'No. Rekening Bank');$this->pdf->text(48,$this->pdf->gety()+125,': '.$row['accountno']);
			$this->pdf->text(10,$this->pdf->gety()+128,'_________________________________________________________________________________________________');
        
        if (isset($employeeid) && $employeeid!='') {
				$where1 =  " where a3.employeeid in (".$employeeid.") ";
		}else{
            $where1 = " where a3.employeeid in (".$row['employeeid'].")";
        }
        $this->pdf->Ln(5);
        
        $this->pdf->checkNewPage(25);
        $this->pdf->text(10,$this->pdf->gety()+133,'Struktur Organisasi');
        $sqly = "select substring_index(substring_index(a1.structurename, ',', 1), ',', - 1) as structurename, substring_index(substring_index(a1.structurename, ',', 2), ',', - 1) as dept, 
                 substring_index(substring_index(a1.structurename, ',', 3), ',', - 1) as divisi, a2.companycode
                 from employeeorgstruc a0 
                 left join orgstructure a1 on a1.orgstructureid = a0.orgstructureid
                 left join company a2 on a2.companyid = a1.companyid
                 where a0.employeeid = '".$row['employeeid']."'";
        $commandy=$connection->createCommand($sqly);
        $dataReadery=$commandy->queryAll();
        $this->pdf->sety($this->pdf->gety()+135);
        $this->pdf->setFont('Arial','',9);
        $this->pdf->colalign = array('L','L','L','L','C');
        $this->pdf->setwidths(array(10,50,50,50,20));
        $this->pdf->colheader = array('No','Struktur','Deparment','Divisi','Perusahaan');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('L','L','L','L','C');
        $i3y=0;
        foreach($dataReadery as $rowy)
        {
            $i3y+=1;
            $this->pdf->row(array($i3y,
            $rowy['structurename'],
            $rowy['dept'],
            $rowy['divisi'],
            $rowy['companycode']));

        }
        
        $connection = Yii::app()->db;
        //$command=$connection->createCommand($this->sqldataaddress.$where1);
        $sqladdress = "select a0.addressid,a0.addressbookid,a0.addresstypeid,a0.addressname,a0.rt,a0.rw,a0.cityid,a0.phoneno,a0.faxno,a0.lat,a0.lng,a0.foto,a1.addresstypename as 
                       addresstypename,a2.cityname as cityname 
                       from address a0 
                       left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
                       left join city a2 on a2.cityid = a0.cityid
                       left join employee a3 on a3.addressbookid = a0.addressbookid ";
        $command = $connection->createCommand($sqladdress.$where1);
        $getaddress=$command->queryAll();
        $this->pdf->checkNewPage(25);
        $this->pdf->text(10,$this->pdf->gety()+8,'Alamat Karyawan');
        $this->pdf->setY($this->pdf->getY()+10);
        $this->pdf->colalign = array('L','L','L','L','L','L');
        $this->pdf->setwidths(array(7,45,90,20,15,15));
        $this->pdf->colheader = array('No','Jenis Alamat','Alamat','Kota','Lat','Lng');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('C','L','L','L','L','L');
        $xy=0;
        foreach($getaddress as $res)
        {
            $xy+=1;
            $this->pdf->row(array($xy,
            $res['addresstypename'],
            $res['addressname'].' RT '.$res['rt'].' RW '.$res['rw'],
            $res['cityname'],
            $res['lat'],
            $res['lng']));

        }
        /*
        foreach($getaddress as $res){
            $this->pdf->text(10,$this->pdf->gety()+135,'Jenis Alamat');$this->pdf->text(48,$this->pdf->gety()+135,': '.$res['addresstypename']);
			$this->pdf->text(10,$this->pdf->gety()+140,'Alamat');$this->pdf->text(48,$this->pdf->gety()+140,': '.$res['addressname']);
			$this->pdf->text(10,$this->pdf->gety()+145,'RT');$this->pdf->text(48,$this->pdf->gety()+145,': '.$res['rt']);
			$this->pdf->text(10,$this->pdf->gety()+150,'RW');$this->pdf->text(48,$this->pdf->gety()+150,': '.$res['rw']);
			$this->pdf->text(10,$this->pdf->gety()+155,'Kota');$this->pdf->text(48,$this->pdf->gety()+155,': '.$res['cityname']);
			$this->pdf->text(10,$this->pdf->gety()+160,'Lattitude');$this->pdf->text(48,$this->pdf->gety()+160,': '.$res['lat']);
			$this->pdf->text(10,$this->pdf->gety()+165,'Longitude');$this->pdf->text(48,$this->pdf->gety()+165,': '.$res['lng']);
            $this->pdf->sety($this->pdf->getY()+40);
				
		}*/
            
            $this->pdf->checkNewPage(25);
            $this->pdf->text(10,$this->pdf->gety()+13,'Kemampuan Bahasa Karyawan');
				$sql3 = "select c.languagename, d.languagevaluename
						from employee a
						left join employeeforeignlanguage b on b.employeeid = a.employeeid
						left join language c on c.languageid = b.languageid 
						left join languagevalue d on d.languagevalueid = b.languagevalueid
						where a.employeeid = ".$row['employeeid'];
				$command3=$connection->createCommand($sql3);
				$dataReader3=$command3->queryAll();
				$this->pdf->sety($this->pdf->gety()+15);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L');
				$this->pdf->setwidths(array(10,40,30));
				$this->pdf->colheader = array('No','Bahasa','Nilai Bahasa');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L');
				$i3=0;
				foreach($dataReader3 as $row3)
				{
					$i3+=1;
					$this->pdf->row(array($i3,
					$row3['languagename'],
					$row3['languagevaluename']));
                    
				}
                $this->pdf->checkNewPage(25);
                $this->pdf->setFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+13,'Identitas Keluarga Karyawan');
                $sql1 = "select b.familyname,c.sexname,d.cityname,b.birthdate,e.educationname,f.occupationname, g.familyrelationname
					from employee a
					left join employeefamily b on b.employeeid = a.employeeid
					left join sex c on c.sexid = b.sexid
					left join city d on d.cityid = b.cityid
					left join education e on e.educationid = b.educationid
					left join occupation f on f.occupationid = b.occupationid
                    left join familyrelation g on g.familyrelationid = b.familyrelationid
					where a.employeeid = ".$row['employeeid'];
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				$this->pdf->sety($this->pdf->gety()+15);
                $this->pdf->checkNewPage(25);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,25,25,25,20,30,20,40));
				$this->pdf->colheader = array('No','Nama','Hubungan','Jenis Kelamin','Kota','Tanggal Lahir','Pendidikan','Pekerjaan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L','C','L');
				//$this->pdf->setFont('Arial','',8);
				$i=0;
                $this->pdf->setFont('Arial','',9);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					//masukkan baris untuk cetak
					$this->pdf->row(array($i,
					$row1['familyname'],
					$row1['familyrelationname'],
					$row1['sexname'],
					$row1['cityname'],
					$row1['birthdate'],
					$row1['educationname'],
					$row1['occupationname'],
					));
				}
                
                $this->pdf->checkNewPage(25);
                $this->pdf->setFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+18,'Pendidikan Karyawan');
				$sql2 = "select c.educationname, b.schoolname, d.cityname, b.yeargraduate, b.isdiploma, b.schooldegree
						from employee a
						left join employeeeducation b on b.employeeid = a.employeeid
						left join education c on c.educationid = b.educationid
						left join city d on d.cityid = b.cityid
						where a.employeeid = ".$row['employeeid'];
				$command2=$connection->createCommand($sql2);
				$dataReader2=$command2->queryAll();
				$this->pdf->sety($this->pdf->gety()+20);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,30,30,20,40));
				$this->pdf->colheader = array('No','Pendidikan','Nama Sekolah','Asal Sekolah ','Tanggal Lulus','Sertifikat','Gelar');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','C','L');
				$ii=0;
                $this->pdf->setFont('Arial','',9);
				foreach($dataReader2 as $row2)
				{
                    $y = $this->pdf->gety()+20;
					$ii+=1;
					$this->pdf->row(array($ii,
					$row2['educationname'],
					$row2['schoolname'],
					$row2['cityname'],
					$row2['yeargraduate'],
					$row2['isdiploma'],
					$row2['schooldegree']));
				}
            
                $this->pdf->setFont('Arial','',10);
                $this->pdf->checkNewPage(25);
		        $this->pdf->text(10,$this->pdf->gety()+8,'Identitas Karyawan');
				$sql4 = "select distinct c.identitytypename,b.identityname
						from employee a
						left join employeeidentity b on b.employeeid = a.employeeid
						left join identitytype c on c.identitytypeid = b.identitytypeid
						where a.employeeid = ".$row['employeeid'];
				$command4=$connection->createCommand($sql4);
				$dataReader4=$command4->queryAll();
				$this->pdf->sety($this->pdf->gety()+10);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L');
				$this->pdf->setwidths(array(10,50,40));
				$this->pdf->colheader = array('No','Jenis Idetitas','Nomor Identitas');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L');
				$i4=0;
                $this->pdf->setFont('Arial','',9);
				foreach($dataReader4 as $row4)
				{
					$i4+=1;
					$this->pdf->row(array($i4,
					$row4['identitytypename'],
					$row4['identityname']));
				}
                $this->pdf->setFont('Arial','',10);
                $this->pdf->checkNewPage(25);
                $this->pdf->text(10,$this->pdf->gety()+5,'Informal Karyawan');
				$sql5 = "select b.informalname, b.organizer, b.period, b.isdiploma, b.sponsoredby
						from employee a
						join employeeinformal b on b.employeeid = a.employeeid
						where a.employeeid = ".$row['employeeid'];
				$command5=$connection->createCommand($sql5);
				$dataReader5=$command5->queryAll();
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,25,35,30));
				$this->pdf->colheader = array('No','Kursus','Pelaksana','Periode','Sertifikat','Biaya Sponsor');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L');
				$i5=0;
                $this->pdf->setFont('Arial','',9);
				foreach($dataReader5 as $row5)
				{
					$i5+=1;
					$this->pdf->row(array($i5,
					$row5['informalname'],
					$row5['organizer'],
					$row5['period'],
					$row5['isdiploma'],
					$row5['sponsoredby']));
				}
            
                $this->pdf->checkNewPage(25);
                $this->pdf->setFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+15,'Pengalaman Kerja Karyawan');
				$sql6 = "select b.employer, b.addressname, b.telp, b.firstposition, b.lastposition, b.startdate, b.enddate, b.spvname, b.spvposition, b.spvphone, b.payamount, b.reasonleave, b.attach, b.recordstatus
						from employee a
						join employeewo b on b.employeeid = a.employeeid
						where a.employeeid = ".$row['employeeid'];
				$command6=$connection->createCommand($sql6);
				$dataReader6=$command6->queryAll();
				$this->pdf->sety($this->pdf->gety()+18);
				$this->pdf->setFont('Arial','',9);
				$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
				$this->pdf->setwidths(array(8,20,20,10,10,30,10,10,10,10,10,10,10,10,10));
				$this->pdf->colheader = array('No','Perusahaan','Alamat','No. Telp','Jabatan Awal','Jabatan Terakhir','Tgl. Mulai','Tgl. Selesai','Nama Atasan Langsung','Jabatan (Atasan)','No. HP Atasan','Gaji Terakhir','Alasan Keluar','Lampiran','Status');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
				$i6=0;
                $this->pdf->setFont('Arial','',9);
				foreach($dataReader6 as $row6)
				{
					$i6+=1;
					$this->pdf->row(array($i6,
						$row6['employer'],
						$row6['addressname'],
						$row6['telp'],
						$row6['firstposition'],
						$row6['lastposition'],
						$row6['startdate'],
						$row6['enddate'],
						$row6['spvname'],
						$row6['spvposition'],
						$row6['spvphone'],
						$row6['payamount'],
						$row6['reasonleave'],
						$row6['attach'],
						$row6['recordstatus'],
					));
				}
            
            
            $this->pdf->checkNewPage(25);
            $this->pdf->setFont('Arial','',10);
            $this->pdf->text(10,$this->pdf->gety()+15,'Kontrak Karyawan');
            $sql7 = "select a.*
                    from employeecontract a
                    left join employee b on b.employeeid = a.employeeid
                    where b.employeeid = '".$row['employeeid']."'";
            $command7=$connection->createCommand($sql7);
            $dataReader7=$command7->queryAll();
            $this->pdf->sety($this->pdf->gety()+17);
            $this->pdf->setFont('Arial','',9);
            $this->pdf->colalign = array('L','C','C','C','C');
            $this->pdf->setwidths(array(10,40,30,30,70));
            $this->pdf->colheader = array('No','Kontrak Ke','Tanggal Mulai','Tanggal Akhir','Keterangan');
            $this->pdf->RowHeader();
            $this->pdf->coldetailalign = array('L','C','C','C','C');
            $i7=0;
            $this->pdf->setFont('Arial','',9);
            foreach($dataReader7 as $row7)
            {
                $i7+=1;
                $this->pdf->row(array($i7,
                $row7['contracttype'],
                $row7['startdate'],
                $row7['enddate'],
                $row7['description']));
            }
        $this->pdf->sety($this->pdf->gety()+15);
            //$this->pdf->text(10,$this->pdf->gety(),'______________________________________________________________________________________________________');
        }
        //$this->pdf->checkPageBreak(250);
        
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		$this->menuname='rinciandatakaryawan';
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('employeeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('structurename'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('positionname'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('employeetypename'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('sexname'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('cityname'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('birthdate'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('religionname'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('maritalstatusname'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('referenceby'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('joindate'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('employeestatusname'))
->setCellValueByColumnAndRow(22,4,$this->getCatalog('resigndate'))
->setCellValueByColumnAndRow(23,4,$this->getCatalog('levelorgname'))
->setCellValueByColumnAndRow(24,4,$this->getCatalog('email'))
->setCellValueByColumnAndRow(26,4,$this->getCatalog('alternateemail'))
->setCellValueByColumnAndRow(27,4,$this->getCatalog('hpno'))
->setCellValueByColumnAndRow(28,4,$this->getCatalog('taxno'))
->setCellValueByColumnAndRow(29,4,$this->getCatalog('dplkno'))
->setCellValueByColumnAndRow(30,4,$this->getCatalog('hpno2'))
->setCellValueByColumnAndRow(31,4,$this->getCatalog('accountno'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['employeeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(7, $i+1, $row1['oldnik'])
->setCellValueByColumnAndRow(8, $i+1, $row1['structurename'])
->setCellValueByColumnAndRow(9, $i+1, $row1['positionname'])
->setCellValueByColumnAndRow(10, $i+1, $row1['employeetypename'])
->setCellValueByColumnAndRow(11, $i+1, $row1['sexname'])
->setCellValueByColumnAndRow(12, $i+1, $row1['cityname'])
->setCellValueByColumnAndRow(13, $i+1, $row1['birthdate'])
->setCellValueByColumnAndRow(14, $i+1, $row1['religionname'])
->setCellValueByColumnAndRow(15, $i+1, $row1['maritalstatusname'])
->setCellValueByColumnAndRow(16, $i+1, $row1['referenceby'])
->setCellValueByColumnAndRow(17, $i+1, $row1['joindate'])
->setCellValueByColumnAndRow(18, $i+1, $row1['employeestatusname'])
->setCellValueByColumnAndRow(22, $i+1, $row1['resigndate'])
->setCellValueByColumnAndRow(23, $i+1, $row1['levelorgname'])
->setCellValueByColumnAndRow(24, $i+1, $row1['email'])
->setCellValueByColumnAndRow(26, $i+1, $row1['alternateemail'])
->setCellValueByColumnAndRow(27, $i+1, $row1['hpno'])
->setCellValueByColumnAndRow(28, $i+1, $row1['taxno'])
->setCellValueByColumnAndRow(29, $i+1, $row1['dplkno'])
->setCellValueByColumnAndRow(30, $i+1, $row1['hpno2'])
->setCellValueByColumnAndRow(31, $i+1, $row1['accountno']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
	public function actionDownPDFBaru()
	{
	  parent::actionDownPDF();
		//masukkan perintah download
		$sql = "select fullname,b.positionname,c.structurename,d.levelorgname,a.employeeid
				from employee a
				left outer join position b on b.positionid = a.positionid
				left outer join orgstructure c on c.orgstructureid = a.orgstructureid
				left outer join levelorg d on d.levelorgid = a.levelorgid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.employeeid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		$this->pdf->title=getCatalog('employee');
		$this->pdf->AddPage('P');
		$this->pdf->AliasNBPages();
		
		foreach($dataReader as $row)
		{
			//masukkan baris untuk cetak
			$this->pdf->text(10,$this->pdf->gety()+5,'Nama ');$this->pdf->text(48,$this->pdf->gety()+5,': '.$row['fullname']);
			$this->pdf->text(10,$this->pdf->gety()+10,'Posisi ');$this->pdf->text(48,$this->pdf->gety()+10,': '.$row['positionname']);
			$this->pdf->text(10,$this->pdf->gety()+15,'Struktur Organisasi ');$this->pdf->text(48,$this->pdf->gety()+15,': '.$row['structurename']);
			$this->pdf->text(10,$this->pdf->gety()+20,'Level ');$this->pdf->text(48,$this->pdf->gety()+20,': '.$row['levelorgname']);
			$this->pdf->text(10,$this->pdf->gety()+27,'Family');
			$sql1 = "select b.familyname,c.sexname,d.cityname,b.birthdate,e.educationname,f.occupationname
					from employee a
					left join employeefamily b on b.employeeid = a.employeeid
					left join sex c on c.sexid = a.sexid
					left join city d on d.cityid = b.cityid
					left join education e on e.educationid = b.educationid
					left join occupation f on f.occupationid = b.occupationid
					where a.employeeid = ".$row['employeeid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,30,30,20,40));
				$this->pdf->colheader = array('No','Nama Family','Jenis Kelamin','Tempat Tinggal','Tanggal Lahir','Pendidikan','Pekerjaan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','C','L');
				//$this->pdf->setFont('Arial','',8);
				$i=0;
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					//masukkan baris untuk cetak
					$this->pdf->row(array($i,
					$row1['familyname'],
					$row1['sexname'],
					$row1['cityname'],
					$row1['birthdate'],
					$row1['educationname'],
					$row1['occupationname'],
					));
				}
			
				$this->pdf->text(10,$this->pdf->gety()+27,'Pendidikan Karyawan');
				$sql2 = "select c.educationname, b.schoolname, d.cityname, b.yeargraduate, b.isdiploma, b.schooldegree
						from employee a
						left join employeeeducation b on b.employeeid = a.employeeid
						left join education c on c.educationid = b.educationid
						left join city d on d.cityid = b.cityid
						where a.employeeid = ".$row['employeeid'];
				$command2=$this->connection->createCommand($sql2);
				$dataReader2=$command2->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,30,30,20,40));
				$this->pdf->colheader = array('No','Pendidikan','Nama Sekolah','Asal Sekolah ','Tanggal Lulus','Sertifikat','Gelar');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','C','L');
				$ii=0;
				foreach($dataReader2 as $row2)
				{
					$ii+=1;
					$this->pdf->row(array($ii,
					$row2['educationname'],
					$row2['schoolname'],
					$row2['cityname'],
					$row2['yeargraduate'],
					$row2['isdiploma'],
					$row2['schooldegree']));
				}
				$this->pdf->text(10,$this->pdf->gety()+27,'Kemampuan Bahasa Karyawan');
				$sql3 = "select c.languagename, d.languagevaluename
						from employee a
						left join employeeforeignlanguage b on b.employeeid = a.employeeid
						left join language c on c.languageid = b.languageid 
						left join languagevalue d on d.languagevalueid = b.languagevalueid
						where a.employeeid = ".$row['employeeid'];
				$command3=$this->connection->createCommand($sql3);
				$dataReader3=$command3->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L');
				$this->pdf->setwidths(array(10,40,30));
				$this->pdf->colheader = array('No','Bahasa','Nilai Bahasa');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L');
				$i3=0;
				foreach($dataReader3 as $row3)
				{
					$i3+=1;
					$this->pdf->row(array($i3,
					$row3['languagename'],
					$row3['languagevaluename']));
				}
				$this->pdf->text(10,$this->pdf->gety()+27,'Identitas Karyawan');
				$sql4 = "select distinct c.identitytypename,b.identityname
						from employee a
						left join employeeidentity b on b.employeeid = a.employeeid
						left join identitytype c on c.identitytypeid = b.identitytypeid
						where a.employeeid = ".$row['employeeid'];
				$command4=$this->connection->createCommand($sql4);
				$dataReader4=$command4->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L');
				$this->pdf->setwidths(array(10,50,40));
				$this->pdf->colheader = array('No','Jenis Idetitas','Nomor Identitas');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L');
				$i4=0;
				foreach($dataReader4 as $row4)
				{
					$i4+=1;
					$this->pdf->row(array($i4,
					$row4['identitytypename'],
					$row4['identityname']));
				}
				$this->pdf->text(10,$this->pdf->gety()+27,'Informal Karyawan');
				$sql5 = "select b.informalname, b.organizer, b.period, b.isdiploma, b.sponsoredby
						from employee a
						join employeeinformal b on b.employeeid = a.employeeid
						where a.employeeid = ".$row['employeeid'];
				$command5=$this->connection->createCommand($sql5);
				$dataReader5=$command5->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,25,35,30));
				$this->pdf->colheader = array('No','Kursus','Pelaksana','Periode','Sertifikat','Biaya Sponsor');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L');
				$i5=0;
				foreach($dataReader5 as $row5)
				{
					$i5+=1;
					$this->pdf->row(array($i5,
					$row5['informalname'],
					$row5['organizer'],
					$row5['period'],
					$row5['isdiploma'],
					$row5['sponsoredby']));
				}
				$this->pdf->text(10,$this->pdf->gety()+27,'Pengalaman Kerja Karyawan');
				$sql6 = "select b.informalname, b.organizer, b.period, b.isdiploma, b.sponsoredby
						from employee a
						join employeewo b on b.employeeid = a.employeeid
						where a.employeeid = ".$row['employeeid'];
				$command6=$this->connection->createCommand($sql6);
				$dataReader6=$command6->queryAll();
				$this->pdf->sety($this->pdf->gety()+29);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('L','L','L','L','L','L');
				$this->pdf->setwidths(array(10,30,30,25,35,30));
				$this->pdf->colheader = array('No','Kegiatan','Pelaksana','Periode','Sertifikat','Biaya Sponsor');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L');
				$i6=0;
				foreach($dataReader6 as $row6)
				{
					$i6+=1;
					$this->pdf->row(array($i6,
					$row6['informalname'],
					$row6['organizer'],
					$row6['period'],
					$row6['isdiploma'],
					$row6['sponsoredby']));
				}
				
				$sql7 = "select *
					from employee a
					join reportin b on b.employeeid = a.employeeid
					where a.employeeid = ".$row['employeeid'];
				$command7=$this->connection->createCommand($sql7);
				$dataReader7=$command7->queryAll();
				$this->pdf->isheader=false;
				$this->pdf->AddPage('L','Legal');
				$this->pdf->text(10,$this->pdf->gety()+0,'Absensi Tahun Berjalan');
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->setFont('Arial','',7);
				//$this->pdf->setx(5);
				$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L',
											'L','L','L','L','L','L','L','L','L','L',
											'L','L','L','L','L','L','L','L','L','L',
											'L','L');
				$this->pdf->setwidths(array(9,9,9,9,9,9,9,9,9,9,
											9,9,9,9,9,9,9,9,10,10,
											10,10,10,10,10,10,10,10,10,10,
											10,10));
				$this->pdf->colheader = array('s1 / s16','d1 / d16','s2 / s17','d2 / d17','s3 / s18','d3 / d18','s4 / s19','d4 / d19','s5 / s20','d5 / d20',
											's6 / s21','d6 / d21','s7 / s22','d7 / d22','s8 / s23','d8 / d23','s9 / s24','d9 / d24','s10 / s25','d10 / d25',
											's11 / s26','d11 / d26','s12 / s27','d12 / d27','s13 / s28','d13 / d28','s14 / s29','d14 / d29','s15 / s30','d15 / d30',
											's31       ','d31      ');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L',
													'L','L','L','L','L','L','L','L','L','L',
													'L','L','L','L','L','L','L','L','L','L',
													'L','L');
				foreach($dataReader7 as $row7)
				{
					$this->pdf->row(array(
					$row7['s1'],$row7['d1'],$row7['s2'],$row7['d2'],$row7['s3'],$row7['d3'],$row7['s4'],$row7['d4'],$row7['s5'],$row7['d5'],
					$row7['s6'],$row7['d6'],$row7['s7'],$row7['d7'],$row7['s8'],$row7['d8'],$row7['s9'],$row7['d9'],$row7['s10'],$row7['d10'],
					$row7['s11'],$row7['d11'],$row7['s12'],$row7['d12'],$row7['s13'],$row7['d13'],$row7['s14'],$row7['d14'],$row7['s15'],$row7['d15'],
					));
					
					$this->pdf->row(array(
					$row7['s16'],$row7['d16'],$row7['s17'],$row7['d17'],$row7['s18'],$row7['d18'],$row7['s19'],$row7['d19'],$row7['s20'],$row7['d20'],
					$row7['s21'],$row7['d21'],$row7['s22'],$row7['d22'],$row7['s23'],$row7['d23'],$row7['s24'],$row7['d24'],$row7['s25'],$row7['d25'],
					$row7['s26'],$row7['d26'],$row7['s27'],$row7['d27'],$row7['s28'],$row7['d28'],$row7['s29'],$row7['d29'],$row7['s30'],$row7['d30'],
					$row7['s31'],$row7['d31']
					));
				}
				$this->pdf->checkPageBreak(20);
		}
		$this->pdf->Output();
	}
	public function actionDownxlsBaru()
	{
		parent::actionDownload();
		$sql = "select fullname,addressbookid,oldnik,orgstructureid,positionid,employeetypeid,sexid,birthcityid,birthdate,religionid,maritalstatusid,referenceby,joindate,employeestatusid,istrial,barcode,photo,resigndate,levelorgid,email,phoneno,alternateemail,hpno,taxno,dplkno,hpno2,accountno
				from employee a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.employeeid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		 $excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0,1,getCatalog('fullname'))
                ->setCellValueByColumnAndRow(1,1,getCatalog('addressbookid'))
                ->setCellValueByColumnAndRow(2,1,getCatalog('oldnik'))
                ->setCellValueByColumnAndRow(4,1,getCatalog('orgstructureid'))
                ->setCellValueByColumnAndRow(5,1,getCatalog('positionid'))
                ->setCellValueByColumnAndRow(6,1,getCatalog('employeetypeid'))
                ->setCellValueByColumnAndRow(7,1,getCatalog('sexid'))
                ->setCellValueByColumnAndRow(8,1,getCatalog('birthcityid'))
                ->setCellValueByColumnAndRow(9,1,getCatalog('birthdate'))
                ->setCellValueByColumnAndRow(10,1,getCatalog('religionid'))
                ->setCellValueByColumnAndRow(11,1,getCatalog('maritalstatusid'))
                ->setCellValueByColumnAndRow(12,1,getCatalog('referenceby'))
                ->setCellValueByColumnAndRow(13,1,getCatalog('joindate'))
                ->setCellValueByColumnAndRow(14,1,getCatalog('employeestatusid'))
                ->setCellValueByColumnAndRow(15,1,getCatalog('istrial'))
                ->setCellValueByColumnAndRow(16,1,getCatalog('barcode'))
                ->setCellValueByColumnAndRow(17,1,getCatalog('photo'))
                ->setCellValueByColumnAndRow(18,1,getCatalog('resigndate'))
                ->setCellValueByColumnAndRow(19,1,getCatalog('levelorgid'))
                ->setCellValueByColumnAndRow(20,1,getCatalog('email'))
                ->setCellValueByColumnAndRow(21,1,getCatalog('phoneno'))
                ->setCellValueByColumnAndRow(22,1,getCatalog('alternateemail'))
                ->setCellValueByColumnAndRow(23,1,getCatalog('hpno'))
                ->setCellValueByColumnAndRow(24,1,getCatalog('taxno'))
                ->setCellValueByColumnAndRow(25,1,getCatalog('dplkno'))
                ->setCellValueByColumnAndRow(26,1,getCatalog('hpno2'))
                ->setCellValueByColumnAndRow(27,1,getCatalog('accountno'))
                ;		foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['fullname'])
                ->setCellValueByColumnAndRow(1, $i+1, $row1['addressbookid'])
                ->setCellValueByColumnAndRow(2, $i+1, $row1['oldnik'])
                ->setCellValueByColumnAndRow(4, $i+1, $row1['orgstructureid'])
                ->setCellValueByColumnAndRow(5, $i+1, $row1['positionid'])
                ->setCellValueByColumnAndRow(6, $i+1, $row1['employeetypeid'])
                ->setCellValueByColumnAndRow(7, $i+1, $row1['sexid'])
                ->setCellValueByColumnAndRow(8, $i+1, $row1['birthcityid'])
                ->setCellValueByColumnAndRow(9, $i+1, $row1['birthdate'])
                ->setCellValueByColumnAndRow(10, $i+1, $row1['religionid'])
                ->setCellValueByColumnAndRow(11, $i+1, $row1['maritalstatusid'])
                ->setCellValueByColumnAndRow(12, $i+1, $row1['referenceby'])
                ->setCellValueByColumnAndRow(13, $i+1, $row1['joindate'])
                ->setCellValueByColumnAndRow(14, $i+1, $row1['employeestatusid'])
                ->setCellValueByColumnAndRow(15, $i+1, $row1['istrial'])
                ->setCellValueByColumnAndRow(16, $i+1, $row1['barcode'])
                ->setCellValueByColumnAndRow(17, $i+1, $row1['photo'])
                ->setCellValueByColumnAndRow(18, $i+1, $row1['resigndate'])
                ->setCellValueByColumnAndRow(19, $i+1, $row1['levelorgid'])
                ->setCellValueByColumnAndRow(20, $i+1, $row1['email'])
                ->setCellValueByColumnAndRow(21, $i+1, $row1['phoneno'])
                ->setCellValueByColumnAndRow(22, $i+1, $row1['alternateemail'])
                ->setCellValueByColumnAndRow(23, $i+1, $row1['hpno'])
                ->setCellValueByColumnAndRow(24, $i+1, $row1['taxno'])
                ->setCellValueByColumnAndRow(25, $i+1, $row1['dplkno'])
                ->setCellValueByColumnAndRow(26, $i+1, $row1['hpno2'])
                ->setCellValueByColumnAndRow(27, $i+1, $row1['accountno'])
                ;		$i+=1;
		}
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="employee.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save('php://output');
		unset($excel);
	}
	public function actionDownPDF1()
	{
		parent::actionDownPDF();
		$this->pdf->title='Rekap Data Karyawan';
    
		$sql = "SELECT a0.employeeid,a0.fullname,a0.oldnik,a0.birthdate,a3.positionname,a0.joindate,a7.religionname,a10.employeetypename,a11.startdate,a11.enddate,a11.contracttype
						FROM employee a0
						left join position a3 on a3.positionid = a0.positionid
						left join employeetype a4 on a4.employeetypeid = a0.employeetypeid
						left join sex a5 on a5.sexid = a0.sexid
						left join religion a7 on a7.religionid = a0.religionid
						left join employeestatus a9 on a9.employeestatusid = a0.employeestatusid
						LEFT JOIN employeetype a10 ON a10.employeetypeid=a0.employeetypeid
						LEFT JOIN employeecontract a11 ON a11.employeeid=a0.employeeid AND a11.recordstatus=1
		";
		$where = " where a0.fullname is not null ";
    if (isset($_REQUEST['id']))
		{
			if (($_REQUEST['id'] !== '0') && ($_REQUEST['id'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.employeeid in (".$_REQUEST['id'].")";
				}
				else
				{
					$where .= " and a0.employeeid in (".$_REQUEST['id'].")";
				}
			}
		}
		if ((isset($_REQUEST['companyname'])) && $_REQUEST['companyname']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeeorgstruc b0 join orgstructure b1 on b1.orgstructureid = b0.orgstructureid join company b2 on b2.companyid = b1.companyid where b0.recordstatus=1 and b2.companyname like '%". $_REQUEST['companyname']."%') ";
		}
		if ((isset($_REQUEST['fullname'])) && $_REQUEST['fullname']!=='')
		{				
			$where .= " and a0.fullname like '%". $_REQUEST['fullname']."%' ";
		}
		if ((isset($_REQUEST['oldnik'])) && $_REQUEST['oldnik']!=='')
		{				
			$where .= " and a0.oldnik like '%". $_REQUEST['oldnik']."%' ";
		}
		if((isset($_REQUEST['employeetypename'])) && $_REQUEST['employeetypename']!=='')
		{
			$where .= " and a4.employeetypename like '%". $_REQUEST['employeetypename']."%' ";
		}
		if((isset($_REQUEST['sexname'])) && $_REQUEST['sexname']!=='')
		{
			$where .= " and a5.sexname like '%". $_REQUEST['sexname']."%' ";
		}
		if((isset($_REQUEST['birthdate'])) && $_REQUEST['birthdate']!=='')
		{
			$where .= " and a0.birthdate like '%". $_REQUEST['birthdate']."%' ";
		}
		if((isset($_REQUEST['religionname'])) && $_REQUEST['religionname']!=='')
		{
			$where .= " and a7.religionname like '%". $_REQUEST['religionname']."%' ";
		}
		if((isset($_REQUEST['employeestatusname'])) && $_REQUEST['employeestatusname']!=='')
		{
			$where .= " and a9.employeestatusname like '%". $_REQUEST['employeestatusname']."%' "; 
		}
		if ((isset($_REQUEST['contract'])) && $_REQUEST['contract']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeecontract b0 where b0.recordstatus=1 and b0.enddate like '%". $_REQUEST['contract']."%') ";
		}
		if((isset($_REQUEST['isresign'])) && $_REQUEST['isresign']!=='')
		{
			if ($_REQUEST['isresign'] == 'Yes')
			{
				$where .= " and a0.resigndate > '1970-01-01' ";
			}
			else
			{
				$where .= " and (a0.resigndate <= '1970-01-01' or a0.resigndate is null) ";
			}
		}
		$dataReader=Yii::app()->db->createCommand($sql.$where)->queryAll();

		//masukkan judul
		//$this->pdf->title=$this->getcatalog('employee');
		$this->pdf->AddPage('L');
		$this->pdf->AliasNBPages();
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,50,15,18,35,18,35,35,40,25));
		$this->pdf->colheader = array('ID','Nama Karyawan','NIK','Tgl. Lahir','Jabatan','Tgl. Masuk','Agama','Jenis Karyawan','Periode Kontrak','Kontrak Ke');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
        
		foreach($dataReader as $row)
		{
			$this->pdf->row(array(
				$row['employeeid'],
				$row['fullname'],
				$row['oldnik'],
				$row['birthdate'],
				$row['positionname'],
				$row['joindate'],
				$row['religionname'],
				$row['employeetypename'],
				date(Yii::app()->params['dateviewfromdb'],strtotime($row['startdate'])).' s/d '.date(Yii::app()->params['dateviewfromdb'],strtotime($row['enddate'])),
				$row['contracttype']
			));
			$this->pdf->checkNewPage(0);
		}
		//$this->pdf->checkPageBreak(250);
        
		$this->pdf->Output();
	}
	public function actionDownXLS1()
	{
		$this->menuname='rekapdatakaryawanhr';
		parent::actionDownXLS();
		$sql = "SELECT a0.employeeid,a0.fullname,a0.oldnik,a0.birthdate,a3.positionname,a0.joindate,a7.religionname,a10.employeetypename,a11.startdate,a11.enddate,a11.contracttype
						FROM employee a0
						left join position a3 on a3.positionid = a0.positionid
						left join employeetype a4 on a4.employeetypeid = a0.employeetypeid
						left join sex a5 on a5.sexid = a0.sexid
						left join religion a7 on a7.religionid = a0.religionid
						left join employeestatus a9 on a9.employeestatusid = a0.employeestatusid
						LEFT JOIN employeetype a10 ON a10.employeetypeid=a0.employeetypeid
						LEFT JOIN employeecontract a11 ON a11.employeeid=a0.employeeid AND a11.recordstatus=1
		";
		$where = " where a0.fullname is not null ";
    if (isset($_REQUEST['id']))
		{
			if (($_REQUEST['id'] !== '0') && ($_REQUEST['id'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.employeeid in (".$_REQUEST['id'].")";
				}
				else
				{
					$where .= " and a0.employeeid in (".$_REQUEST['id'].")";
				}
			}
		}
		if ((isset($_REQUEST['companyname'])) && $_REQUEST['companyname']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeeorgstruc b0 join orgstructure b1 on b1.orgstructureid = b0.orgstructureid join company b2 on b2.companyid = b1.companyid where b0.recordstatus=1 and b2.companyname like '%". $_REQUEST['companyname']."%') ";
		}
		if ((isset($_REQUEST['fullname'])) && $_REQUEST['fullname']!=='')
		{				
			$where .= " and a0.fullname like '%". $_REQUEST['fullname']."%' ";
		}
		if ((isset($_REQUEST['oldnik'])) && $_REQUEST['oldnik']!=='')
		{				
			$where .= " and a0.oldnik like '%". $_REQUEST['oldnik']."%' ";
		}
		if((isset($_REQUEST['employeetypename'])) && $_REQUEST['employeetypename']!=='')
		{
			$where .= " and a4.employeetypename like '%". $_REQUEST['employeetypename']."%' ";
		}
		if((isset($_REQUEST['sexname'])) && $_REQUEST['sexname']!=='')
		{
			$where .= " and a5.sexname like '%". $_REQUEST['sexname']."%' ";
		}
		if((isset($_REQUEST['birthdate'])) && $_REQUEST['birthdate']!=='')
		{
			$where .= " and a0.birthdate like '%". $_REQUEST['birthdate']."%' ";
		}
		if((isset($_REQUEST['religionname'])) && $_REQUEST['religionname']!=='')
		{
			$where .= " and a7.religionname like '%". $_REQUEST['religionname']."%' ";
		}
		if((isset($_REQUEST['employeestatusname'])) && $_REQUEST['employeestatusname']!=='')
		{
			$where .= " and a9.employeestatusname like '%". $_REQUEST['employeestatusname']."%' "; 
		}
		if ((isset($_REQUEST['contract'])) && $_REQUEST['contract']!=='')
		{				
			$where .= " and a0.employeeid in (select b0.employeeid from employeecontract b0 where b0.recordstatus=1 and b0.enddate like '%". $_REQUEST['contract']."%') ";
		}
		if((isset($_REQUEST['isresign'])) && $_REQUEST['isresign']!=='')
		{
			if ($_REQUEST['isresign'] == 'Yes')
			{
				$where .= " and a0.resigndate > '1970-01-01' ";
			}
			else
			{
				$where .= " and (a0.resigndate <= '1970-01-01' or a0.resigndate is null) ";
			}
		}
		$dataReader=Yii::app()->db->createCommand($sql.$where)->queryAll();
		$i=3;
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,3,$this->getCatalog('employeeid'))
			->setCellValueByColumnAndRow(1,3,$this->getCatalog('fullname'))
			->setCellValueByColumnAndRow(2,3,$this->getCatalog('oldnik'))
			->setCellValueByColumnAndRow(3,3,$this->getCatalog('birthdate'))
			->setCellValueByColumnAndRow(4,3,$this->getCatalog('positionname'))
			->setCellValueByColumnAndRow(5,3,$this->getCatalog('joindate'))
			->setCellValueByColumnAndRow(6,3,$this->getCatalog('religionname'))
			->setCellValueByColumnAndRow(7,3,$this->getCatalog('employeetypename'))
			->setCellValueByColumnAndRow(8,3,$this->getCatalog('period'))
			->setCellValueByColumnAndRow(9,3,$this->getCatalog('contracttype'));
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row['employeeid'])
				->setCellValueByColumnAndRow(1, $i+1, $row['fullname'])
				->setCellValueByColumnAndRow(2, $i+1, $row['oldnik'])
				->setCellValueByColumnAndRow(3, $i+1, $row['birthdate'])
				->setCellValueByColumnAndRow(4, $i+1, $row['positionname'])
				->setCellValueByColumnAndRow(5, $i+1, $row['joindate'])
				->setCellValueByColumnAndRow(6, $i+1, $row['religionname'])
				->setCellValueByColumnAndRow(7, $i+1, $row['employeetypename'])
				->setCellValueByColumnAndRow(8, $i+1, date(Yii::app()->params['dateviewfromdb'],strtotime($row['startdate'])).' s/d '.date(Yii::app()->params['dateviewfromdb'],strtotime($row['enddate'])))
				->setCellValueByColumnAndRow(9, $i+1, $row['contracttype']);
			$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
