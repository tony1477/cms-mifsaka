<?php

class SupplierController extends AdminController
{
	protected $menuname = 'supplier';
	public $module = 'Common';
	protected $pageTitle = 'Supplier';
	public $wfname = '';
	protected $sqldata = "select a0.addressbookid,a0.fullname,a0.isvendor,a0.currentdebt,a0.taxno,a0.bankname,a0.bankaccountno,a0.accountowner,a0.recordstatus,a0.logo 
    from addressbook a0 
  ";
protected $sqldataaddress = "select a0.addressid,a0.addressbookid,a0.addresstypeid,a0.addressname,a0.rt,a0.rw,a0.cityid,a0.phoneno,a0.faxno,a0.lat,a0.lng,a1.addresstypename as addresstypename,a2.cityname as cityname 
    from address a0 
    left join addresstype a1 on a1.addresstypeid = a0.addresstypeid
    left join city a2 on a2.cityid = a0.cityid
  ";
protected $sqldataaddresscontact = "select a0.addresscontactid,a0.contacttypeid,a0.addressbookid,a0.addresscontactname,a0.phoneno,a0.mobilephone,a0.emailaddress,a1.contacttypename as contacttypename 
    from addresscontact a0 
    left join contacttype a1 on a1.contacttypeid = a0.contacttypeid
  ";
protected $sqldataaddressaccount = "select a0.addressaccountid,a0.companyid,a0.addressbookid,a0.acchutangid,a0.recordstatus,a1.companyname as companyname,a2.accountcode as acchutangname 
    from addressaccount a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.acchutangid
  ";
  protected $sqlcount = "select count(1) 
    from addressbook a0 
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
protected $sqlcountaddressaccount = "select count(1) 
    from addressaccount a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.acchutangid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where isvendor=1";
		/*if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['taxno'])) && (isset($_REQUEST['bankname'])) && (isset($_REQUEST['bankaccountno'])) && (isset($_REQUEST['accountowner'])))
		{				
			$where .=  " 
and a0.fullname like '%". $_REQUEST['fullname']."%' 
and a0.taxno like '%". $_REQUEST['taxno']."%' 
and a0.bankname like '%". $_REQUEST['bankname']."%' 
and a0.bankaccountno like '%". $_REQUEST['bankaccountno']."%' 
and a0.accountowner like '%". $_REQUEST['accountowner']."%'"; 
		}*/
if (isset($_REQUEST['fullname']) && ($_REQUEST['fullname']!='')){
            $where .=  " and a0.fullname like '%{$_REQUEST['fullname']}%'";
        } 
        if(isset($_REQUEST['taxno']) && ($_REQUEST['taxno']!='')){
            $where .= " and a0.taxno like '%". $_REQUEST['taxno']."%' ";
        } 
        if (isset($_REQUEST['bankname']) && ($_REQUEST['bankname']!='')){
            $where .= " and a0.bankname like '%". $_REQUEST['bankname']."%' ";
        }
        if(isset($_REQUEST['bankaccountno']) && ($_REQUEST['bankaccountno']!='')){
            $where .= " and a0.bankaccountno like '%". $_REQUEST['bankaccountno']."%' ";
        }
        if(isset($_REQUEST['accountowner']) && ($_REQUEST['accountowner']!='')){
            $where .= " and a0.accountowner like '%". $_REQUEST['accountowner']."%'";
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
	
		public function actionUpload()
	{
		$this->storeFolder = dirname('__FILES__').'/images/logoab/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
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
					 'addressbookid','fullname','isvendor','currentdebt','taxno','bankname','bankaccountno','accountowner','recordstatus'
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
		if (isset($_REQUEST['addressbookid']))
		{
			$this->sqlcountaddresscontact .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
			$this->sqldataaddresscontact .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
		}
		$countaddresscontact = Yii::app()->db->createCommand($this->sqlcountaddresscontact)->queryScalar();
$dataProvideraddresscontact=new CSqlDataProvider($this->sqldataaddresscontact,array(
					'totalItemCount'=>$countaddresscontact,
					'keyField'=>'addresscontactid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'addresscontactid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['addressbookid']))
		{
			$this->sqlcountaddressaccount .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
			$this->sqldataaddressaccount .= ' where a0.addressbookid = '.$_REQUEST['addressbookid'];
		}
		$countaddressaccount = Yii::app()->db->createCommand($this->sqlcountaddressaccount)->queryScalar();
$dataProvideraddressaccount=new CSqlDataProvider($this->sqldataaddressaccount,array(
					'totalItemCount'=>$countaddressaccount,
					'keyField'=>'addressaccountid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'addressaccountid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvideraddress'=>$dataProvideraddress,'dataProvideraddresscontact'=>$dataProvideraddresscontact,'dataProvideraddressaccount'=>$dataProvideraddressaccount));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into addressbook (recordstatus) values (1)";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'addressbookid'=>$id,
			"currentdebt" =>0
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
  public function actionCreateaddressaccount()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"companyid" => $company["companyid"],										"companyname" => $company["companyname"]
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
          'isvendor'=>$model['isvendor'],
          'taxno'=>$model['taxno'],
          'bankname'=>$model['bankname'],
          'bankaccountno'=>$model['bankaccountno'],
          'accountowner'=>$model['accountowner'],
          'logo'=>$model['logo'],
          'recordstatus'=>$model['recordstatus'],

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
          'emailaddress'=>$model['emailaddress'],
          'contacttypename'=>$model['contacttypename'],

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
          'acchutangid'=>$model['acchutangid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'acchutangname'=>$model['acchutangname'],

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
      array('taxno','string','emptytaxno'),
      array('bankname','string','emptybankname'),
      array('bankaccountno','string','emptybankaccountno'),
      array('accountowner','string','emptyaccountowner'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressbookid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateSupplier (:addressbookid
,:fullname
,:taxno
,:bankaccountno
,:bankname
,:accountowner
,:logo
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':addressbookid',$_POST['addressbookid'],PDO::PARAM_STR);
				$command->bindvalue(':fullname',(($_POST['fullname']!=='')?$_POST['fullname']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankname',(($_POST['bankname']!=='')?$_POST['bankname']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankaccountno',(($_POST['bankaccountno']!=='')?$_POST['bankaccountno']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountowner',(($_POST['accountowner']!=='')?$_POST['accountowner']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
        $command->bindvalue(':logo',(($_POST['logo']!=='')?$_POST['logo']:null),PDO::PARAM_STR);
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
      array('phoneno','string','emptyphoneno'),
      array('faxno','string','emptyfaxno'),
      array('lat','string','emptylatitude'),
      array('lng','string','emptylongitude'),
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
			      set addressbookid = :addressbookid,addresstypeid = :addresstypeid,addressname = :addressname,rt = :rt,rw = :rw,cityid = :cityid,phoneno = :phoneno,faxno = :faxno,lat = :lat ,lng = :lng 
			      where addressid = :addressid';
				}
				else
				{
					$sql = 'insert into address (addressbookid,addresstypeid,addressname,rt,rw,cityid,phoneno,faxno,lat,lng) 
			      values (:addressbookid,:addresstypeid,:addressname,:rt,:rw,:cityid,:phoneno,:faxno,:lat,:lng)';
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
      array('phoneno','string','emptyphoneno'),
      array('mobilephone','string','emptymobilephone'),
      array('emailaddress','string','emptyemailaddress'),
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
			      set contacttypeid = :contacttypeid,addressbookid = :addressbookid,addresscontactname = :addresscontactname,phoneno = :phoneno,mobilephone = :mobilephone,emailaddress = :emailaddress 
			      where addresscontactid = :addresscontactid';
				}
				else
				{
					$sql = 'insert into addresscontact (contacttypeid,addressbookid,addresscontactname,phoneno,mobilephone,emailaddress) 
			      values (:contacttypeid,:addressbookid,:addresscontactname,:phoneno,:mobilephone,:emailaddress)';
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
        $command->bindvalue(':emailaddress',(($_POST['emailaddress']!=='')?$_POST['emailaddress']:null),PDO::PARAM_STR);
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
				
public function actionSaveaddressaccount()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('addressbookid','string','emptyaddressbookid'),
      array('acchutangid','string','emptyacchutangid'),
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
			      set companyid = :companyid,addressbookid = :addressbookid,acchutangid = :acchutangid,recordstatus = :recordstatus 
			      where addressaccountid = :addressaccountid';
				}
				else
				{
					$sql = 'insert into addressaccount (companyid,addressbookid,acchutangid,recordstatus) 
			      values (:companyid,:addressbookid,:acchutangid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addressaccountid',$_POST['addressaccountid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':acchutangid',(($_POST['acchutangid']!=='')?$_POST['acchutangid']:null),PDO::PARAM_STR);
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
	}public function actionPurgeaddress()
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
	}public function actionPurgeaddresscontact()
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
	}public function actionPurgeaddressaccount()
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('supplier');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('addressbookid'),$this->getCatalog('fullname'),$this->getCatalog('isvendor'),$this->getCatalog('currentdebt'),$this->getCatalog('taxno'),$this->getCatalog('bankname'),$this->getCatalog('bankaccountno'),$this->getCatalog('accountowner'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['addressbookid'],$row1['fullname'],$row1['isvendor'],$row1['currentdebt'],$row1['taxno'],$row1['bankname'],$row1['bankaccountno'],$row1['accountowner'],$row1['recordstatus']));
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
->setCellValueByColumnAndRow(2,4,$this->getCatalog('isvendor'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('currentdebt'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('taxno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('bankname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('bankaccountno'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('accountowner'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['addressbookid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['isvendor'])
->setCellValueByColumnAndRow(3, $i+1, $row1['currentdebt'])
->setCellValueByColumnAndRow(4, $i+1, $row1['taxno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['bankname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['bankaccountno'])
->setCellValueByColumnAndRow(7, $i+1, $row1['accountowner'])
->setCellValueByColumnAndRow(8, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
