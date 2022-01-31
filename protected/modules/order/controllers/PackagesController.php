<?php

class PackagesController extends AdminController
{
	protected $menuname = 'packages';
	public $module = 'Order';
	protected $pageTitle = 'packages';
	public $wfname = 'apppkg';
	protected $sqldata = "select distinct a0.packageid,a0.docno,a0.packagename,a0.docdate,a0.startdate,a0.enddate,a0.headernote,a0.recordstatus,a0.statusname,
    -- a1.companyname as companyname,a2.fullname as fullname
    case 
		when packagetype = 1 then 'All Customer' 
		when packagetype = 2 then 'Untuk Perusahaan'
		when packagetype = 3 then 'Untuk Customer'
		when packagetype = 4 then 'Untuk Perusahaan dan Customer' end as packagetypename, a0.packagetype,
		ifnull(a0.companyid,'-') as companyid,
		ifnull(a0.customerid,'-') as customerid,a0.paymentmethodid,a3.paycode
    from packages a0 
    left join tempcompany a1 on a1.tableid = a0.packageid
    left join tempcustomer a2 on a2.tableid = a0.packageid
    left join paymentmethod a3 on a3.paymentmethodid = a0.paymentmethodid
  ";
protected $sqldatapackagedetail = "select a0.packagedetailid,a0.packageid,a0.productid,a0.qty,a0.unitofmeasureid,a0.price,a1.productname as productname,a2.uomcode as uomcode,isbonus 
    from packagedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
  ";
	
protected $sqlmultidata= "call getDataMulti(:vpackageid,:vdataid,:vtype)";
	
protected $sqltempcompany = "select * from tempcompany ";
	
protected $sqltempcustomer = "select * from tempcustomer ";

protected $sqldatapackagedisc = "select a0.packagediscid,a0.packageid,a0.discvalue 
    from packagedisc a0 
  ";
  protected $sqlcount = "select count(distinct a0.packageid) 
    from packages a0 
    left join tempcompany a1 on a1.tableid = a0.packageid
    left join tempcustomer a2 on a2.tableid = a0.packageid
  ";
protected $sqlcountpackagedetail = "select count(1) 
    from packagedetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
  ";
protected $sqlcountpackagedisc = "select count(1) 
    from packagedisc a0 
  ";

protected $sqldatacompany = "select companyid
		from packages a0 ";
	
protected $sqldatacustomer = "select customerid
		from packages a0 ";

protected $sqlcountdatacompany = "select char_length(companyid) - char_length(replace(companyid, ',', ''))+1 
from packages a0
  ";
	
protected $sqlcountdatacustomer = "select char_length(customerid) - char_length(replace(customerid, ',', ''))+1 
from packages a0
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where ((a1.companyid in (".getUserObjectWfValues('company','apppkg').")) or (a0.customerid is null and a0.companyid is null) or (a2.customerid is not null and a1.companyid is null)) and a0.recordstatus in(".getUserRecordStatus('listpkg').")";
		if ((isset($_REQUEST['docno'])) && (isset($_REQUEST['packagename'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['fullname'])))
		{				
			$where .=  " and a0.docno like '%". $_REQUEST['docno']."%' 
                        and a0.packagename like '%". $_REQUEST['packagename']."%' 
                        and a1.companyname like '%". $_REQUEST['companyname']."%' 
                        and a2.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
		if (isset($_REQUEST['packageid']))
			{
				if (($_REQUEST['packageid'] !== '0') && ($_REQUEST['packageid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.packageid in (".$_REQUEST['packageid'].")";
					}
					else
					{
						$where .= " and a0.packageid in (".$_REQUEST['packageid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionGetMultiCompany()
	{
        $arr = explode(',',$_REQUEST['companyid']);
        $val=0;
        for($i=0; $i<count($arr); $i++) {
            //check data
            $q = Yii::app()->db->createCommand("select find_in_set(".$arr[$i].",companyid) from packages where packageid = {$_REQUEST['packageid']}")->queryScalar();
            if($q==0) {
                if($val==0) {
                    $val = $arr[$i];
                }
                else {
                    $val = $val.','.$arr[$i];
                }
            }
        }
		
		if($val!=0) {
             $checkcompany = Yii::app()->db->createCommand("select ifnull(companyid,0) from packages where packageid = ".$_REQUEST['packageid'])->queryScalar();
                
            if($checkcompany!=0) {
                $update = " concat(companyid,',','{$val}')";
            }
            else {
                $update = "'{$val}'";
            }
            $insert = Yii::app()->db->createCommand("update packages set companyid = {$update} where packageid = {$_REQUEST['packageid']}")->execute();
            
            $companyid = Yii::app()->db->createCommand("select companyid from packages where packageid = ".$_REQUEST['packageid'])->queryScalar();
            
			$exec = "call getDataMulti(:vid,:vdata,:vtype)";
			$command = Yii::app()->db->createCommand($exec);
			$command->bindvalue(':vid',$_REQUEST['packageid'],PDO::PARAM_STR);
			$command->bindvalue(':vdata',$companyid,PDO::PARAM_STR);
			$command->bindvalue(':vtype','company',PDO::PARAM_STR);
			$command->execute();
			
			$qcompany = "select group_concat(companyname separator ', ') from company where companyid in ({$companyid})";
			$company = Yii::app()->db->createCommand($qcompany)->queryScalar();
			echo CJSON::encode(array(
				'status'=>'success',
				'companyname' => $company,
                'companyid'=>$companyid));
			Yii::app()->end();
		}
		else
		{
			$error = 'duplicate';
			throw new Exception($error);
		}
	}
    
    public function actionCancelMultiCompany()
	{
		//updte rows first
		
		//if($val!=0) {
        $connection = Yii::app()->db;
        //$transaction = $connection->beginTransaction();
        try {
            $delete = Yii::app()->db->createCommand("delete from tempcompany where tableid = ".$_REQUEST['packageid']. " and companyid in({$_REQUEST['companyid']})")->execute();

            if($delete==true) {
                $companyid = Yii::app()->db->createCommand("select group_concat(companyid) from tempcompany where tableid = ".$_REQUEST['packageid'])->queryScalar();

                $update = Yii::app()->db->createCommand("update packages set companyid = '".$companyid."' where packageid = ".$_REQUEST['packageid'])->execute();
                //$transaction->commit();
                
                $qcompname = "select group_concat(companyname) from company where companyid in ($companyid)";
                $compname = Yii::app()->db->createCommand($qcompname)->queryScalar();
                echo CJSON::encode(array(
                    'status'=>'success',
                    'companyname' => $compname,
                    'multicompanyid' => $companyid));
                Yii::app()->end();
                
            }
            else
            {
                $error = 'error delete';
                throw new Exception($error);
            }
        }
        catch (CDbException $e)
        {
            //$transaction->rollBack();
            $this->getMessage('error',$e->getMessage());
        }
        
	}
	
	public function actionGetMultiCustomer()
	{
		//updte rows first
		$arr = explode(',',$_REQUEST['customerid']);
        $val=0;
        for($i=0; $i<count($arr); $i++) {
            //check data
            $q = Yii::app()->db->createCommand("select find_in_set(".$arr[$i].",customerid) from packages where packageid = {$_REQUEST['packageid']}")->queryScalar();
            if($q==0) {
                if($val==0) {
                    $val = $arr[$i];
                }
                else {
                    $val = $val.','.$arr[$i];
                }
            }
        }
		
		if($val!=0) {
            $checkcustomer = Yii::app()->db->createCommand("select ifnull(customerid,0) from packages where packageid = ".$_REQUEST['packageid'])->queryScalar();
                
            if($checkcustomer!=0) {
                $update = " concat(customerid,',','{$val}')";
            }
            else {
                $update = "'{$val}'";
            }
            
            $insert = Yii::app()->db->createCommand("update packages set customerid = {$update} where packageid = {$_REQUEST['packageid']}")->execute();
            
            $customerid = Yii::app()->db->createCommand("select customerid from packages where packageid = ".$_REQUEST['packageid'])->queryScalar();
            
			$exec = "call getDataMulti(:vid,:vdata,:vtype)";
			$command = Yii::app()->db->createCommand($exec);
			$command->bindvalue(':vid',$_REQUEST['packageid'],PDO::PARAM_STR);
			$command->bindvalue(':vdata',$customerid,PDO::PARAM_STR);
			$command->bindvalue(':vtype','customer',PDO::PARAM_STR);
			$command->execute();
			
			$qfullname = "select group_concat(fullname) from addressbook where addressbookid in ($customerid)";
			$fullname = Yii::app()->db->createCommand($qfullname)->queryScalar();
			echo CJSON::encode(array(
				'status'=>'success',
				'fullname' => $fullname,
                'customerid'=>$customerid));
			Yii::app()->end();
		}
		else
		{
			$error = 'duplicate';
			throw new Exception($error);
		}
	}
    
    public function actionCancelMultiCustomer()
	{
		//updte rows first
		
		//if($val!=0) {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $delete = Yii::app()->db->createCommand("delete from tempcustomer where tableid = ".$_REQUEST['packageid']. " and customerid in({$_REQUEST['customerid']})")->execute();

            if($delete==true) {
                $customerid = Yii::app()->db->createCommand("select group_concat(customerid) from tempcustomer where tableid = ".$_REQUEST['packageid'])->queryScalar();

                $update = Yii::app()->db->createCommand("update packages set customerid = '".$customerid."' where packageid = ".$_REQUEST['packageid'])->execute();
                $transaction->commit();
                
                $qfullname = "select group_concat(fullname) from addressbook where addressbookid in ($customerid)";
                $fullname = Yii::app()->db->createCommand($qfullname)->queryScalar();
                echo CJSON::encode(array(
                    'status'=>'success',
                    'fullname' => $fullname,
                    'multicustomer' => $customerid));
                Yii::app()->end();
                
            }
            else
            {
                $error = 'error delete';
                throw new Exception($error);
            }
        }
        catch (CDbException $e)
        {
            $transaction->rollBack();
            $this->getMessage('error',$e->getMessage());
        }
        
	}
	
	public function actionGetCompanies()
	{
		$sql = "select group_concat(companyname) as companyname from company where companyid in(".$_REQUEST['companies'].")";
		$model = Yii::app()->db->createCommand($sql)->queryScalar();
		
		$result = array();
		$row = array();
		//$result['status'] = 'success';
		echo CJSON::encode(array('status'=>'success','companyname'=> $model));
		Yii::app()->end();
	}
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'packageid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'packageid','docno','packagename','companyid','docdate','customerid','startdate','enddate','headernote','recordstatus','statusname','packagetype','paymentmethodid'
				),
				'defaultOrder' => array( 
					'packageid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['packageid']))
		{
			$this->sqlcountpackagedetail .= ' where a0.packageid = '.$_REQUEST['packageid'];
			$this->sqldatapackagedetail .= ' where a0.packageid = '.$_REQUEST['packageid'];
		}
		$countpackagedetail = Yii::app()->db->createCommand($this->sqlcountpackagedetail)->queryScalar();
$dataProviderpackagedetail=new CSqlDataProvider($this->sqldatapackagedetail,array(
					'totalItemCount'=>$countpackagedetail,
					'keyField'=>'packagedetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'packagedetailid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['packageid']))
		{
			$this->sqlcountpackagedisc .= ' where a0.packageid = '.$_REQUEST['packageid'];
			$this->sqldatapackagedisc .= ' where a0.packageid = '.$_REQUEST['packageid'];
		}
		$countpackagedisc = Yii::app()->db->createCommand($this->sqlcountpackagedisc)->queryScalar();
$dataProviderpackagedisc=new CSqlDataProvider($this->sqldatapackagedisc,array(
					'totalItemCount'=>$countpackagedisc,
					'keyField'=>'packagediscid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'packagediscid' => CSort::SORT_DESC
						),
					),
					));
	
		if (isset($_REQUEST['packageid']))
		{
			//$this->sqlcountpackagedisc .= ' where a0.packageid = '.$_REQUEST['packageid'];
			$this->sqldatacompany .= ' where packageid = '.$_REQUEST['packageid'];
			$this->sqldatacustomer .= ' where packageid = '.$_REQUEST['packageid'];
		
            
			$rescompany = Yii::app()->db->createCommand($this->sqldatacompany)->queryScalar();
			$rescustomer = Yii::app()->db->createCommand($this->sqldatacustomer)->queryScalar();
            if($rescompany > 0) {
			$command = Yii::app()->db->createCommand($this->sqlmultidata);
			$command->bindvalue(':vpackageid',$_REQUEST['packageid'],PDO::PARAM_STR);
			$command->bindvalue(':vdataid',$rescompany,PDO::PARAM_STR);
			$command->bindvalue(':vtype','company',PDO::PARAM_STR);
			$command->execute();
            }
            if($rescustomer>0) {
			$sqlcustomer = "call getDataMulti({$_REQUEST['packageid']},'{$rescustomer}','customer')";
		    $qcustomer = Yii::app()->db->createCommand($sqlcustomer)->execute();
            }
            
			$countdatacompany = Yii::app()->db->createCommand($this->sqlcountdatacompany)->queryScalar();
			$countdatacustomer = Yii::app()->db->createCommand($this->sqlcountdatacustomer)->queryScalar();
            
            $this->sqltempcompany .= ' where tableid = '.$_REQUEST['packageid'];
            $this->sqltempcustomer .= ' where tableid = '.$_REQUEST['packageid'];
		}
		else
		{
			$sqlcompany = "select 0 as companyid, '' as companyname";
			$sqlcustomer = "select 0 as customerid, '' as fullname, '' as groupname, '' as areaname, '' as custogradedesc ";
			$countdatacompany = 0;
			$countdatacustomer = 0;
			
		}
			$dataCompany=new CSqlDataProvider($this->sqltempcompany,array(
					'totalItemCount'=>10,
					'keyField'=>'companyid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'companyid' => CSort::SORT_DESC
						),
					),
					));
			
			$dataCustomer=new CSqlDataProvider($this->sqltempcustomer,array(
					'totalItemCount'=>10,
					'keyField'=>'customerid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'fullname' => CSort::SORT_DESC
						),
					),
					));
		
		$packagetype = array('All Customer','Pilih Perusahaan','Pilih Customer','Pilih Customer dan Perusahaan');
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderpackagedetail'=>$dataProviderpackagedetail,'dataProviderpackagedisc'=>$dataProviderpackagedisc,'packagetype'=>$packagetype,'dataCompany'=>$dataCompany,'dataCustomer'=>$dataCustomer));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into packages (recordstatus) values (".$this->findstatusbyuser('inspkg').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
			'packageid'=>$id,
			"docdate" =>date("Y-m-d"),
      "startdate" =>date("Y-m-d"),
      "enddate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inspkg")
		));
	}
  public function actionCreatepackagedetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "price" =>0
		));
	}
  public function actionCreatepackagedisc()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"discvalue" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.packageid = '.$id)->queryRow();
			$company = Yii::app()->db->createCommand("select group_concat(companyname separator ', ') from tempcompany where tableid = ".$id)->queryScalar();
			$customer = Yii::app()->db->createCommand("select group_concat(fullname separator ', ') from tempcustomer where tableid = ".$id)->queryScalar();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'packageid'=>$model['packageid'],
          'docno'=>$model['docno'],
          'packagename'=>$model['packagename'],
          'packagetype'=>$model['packagetype'],
		  'companies'=>$company,
		  'customers'=>$customer,
          'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'customerid'=>$model['customerid'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'paymentmethodid'=>$model['paymentmethodid'],
          'paycode'=>$model['paycode'],
          'headernote'=>$model['headernote'],

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

  public function actionUpdatepackagedetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapackagedetail.' where packagedetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'packagedetailid'=>$model['packagedetailid'],
          'packageid'=>$model['packageid'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'price'=>$model['price'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'isbonus'=>$model['isbonus'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdatepackagedisc()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapackagedisc.' where packagediscid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'packagediscid'=>$model['packagediscid'],
          'packageid'=>$model['packageid'],
          'discvalue'=>$model['discvalue'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
      array('packagename','string','emptypackagename'),
      array('packagetype','string','emptypackagetype'),
      array('startdate','string','emptystartdate'),
      array('enddate','string','emptyenddate'),
    ));
		if ($error == false)
		{
			$id = $_POST['packageid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdatePackage (:vid,:vdocdate,:vpackagename,:vpackagetype,:vcompanyid,:vcustomerid,:vpaymentmethodid,:vstartdate,:venddate,:vheadernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['packageid'],PDO::PARAM_STR);
                $command->bindvalue(':vdocdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpackagename',(($_POST['packagename']!=='')?$_POST['packagename']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpackagetype',(($_POST['packagetype']!=='')?$_POST['packagetype']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcompanyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustomerid',(($_POST['customerid']!=='')?$_POST['customerid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpaymentmethodid',(($_POST['paymentmethodid']!=='')?$_POST['paymentmethodid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vstartdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':venddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vheadernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
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
public function actionSavepackagedetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('packageid','string','emptypackageid'),
      		array('productid','string','emptyproductid'),
      		//array('unitofmeasureid','string','emptyunitofmeasureid'),
      		array('qty','string','emptyqty'),
      		array('price','string','emptyprice'),
    ));
		if ($error == false)
		{
			$id = $_POST['packagedetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatepackagedetail(:vid,:vpackageid,:vproductid,:vqty,:vuomid,:vprice,:visbonus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertpackagedetail(:vpackageid,:vproductid,:vqty,:vuomid,:vprice,:visbonus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['packagedetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vpackageid',(($_POST['packageid']!=='')?$_POST['packageid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vproductid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vqty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
				$command->bindvalue(':vuomid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
				$command->bindvalue(':vprice',(($_POST['price']!=='')?$_POST['price']:null),PDO::PARAM_STR);
				$command->bindvalue(':visbonus',(($_POST['isbonus']!=='')?$_POST['isbonus']:null),PDO::PARAM_STR);
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
				
public function actionSavepackagedisc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('packageid','string','emptypackageid'),
    ));
		if ($error == false)
		{
			$id = $_POST['packagediscid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call updatepackagedisc(:vid,:vpackageid,:vdiscvalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertpackagedisc(:vpackageid,:vdiscvalue,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['packagediscid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vpackageid',(($_POST['packageid']!=='')?$_POST['packageid']:null),PDO::PARAM_STR);
        		$command->bindvalue(':vdiscvalue',(($_POST['discvalue']!=='')?$_POST['discvalue']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvepackage(:vid,:vcreatedby)';
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
				$sql = 'call Deletepackage(:vid,:vcreatedby)';
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
				$sql = "delete from packages where packageid = ".$id[$i];
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
	}public function actionPurgepackagedetail()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				
				$sql = "call purgepackagedetail(:vid,:vcreatedby)";
				$command = $connection->createCommand($sql);
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
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
	}public function actionPurgepackagedisc()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				
				$sql = "call purgepackagedisc(:vid,:vcreatedby)";
				$command = $connection->createCommand($sql);
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
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
		$this->pdf->title=$this->getCatalog('packages');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('packageid'),$this->getCatalog('docno'),$this->getCatalog('packagename'),$this->getCatalog('company'),$this->getCatalog('docdate'),$this->getCatalog('customer'),$this->getCatalog('startdate'),$this->getCatalog('enddate'),$this->getCatalog('headernote'),$this->getCatalog('recordstatus'),$this->getCatalog('statusname'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['packageid'],$row1['docno'],$row1['packagename'],$row1['companyname'],$row1['docdate'],$row1['fullname'],$row1['startdate'],$row1['enddate'],$row1['headernote'],$row1['recordstatus'],$row1['statusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('packageid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('packagename'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('startdate'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('enddate'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['packageid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['packagename'])
->setCellValueByColumnAndRow(3, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['startdate'])
->setCellValueByColumnAndRow(7, $i+1, $row1['enddate'])
->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(10, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}