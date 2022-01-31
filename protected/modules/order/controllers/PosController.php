<?php

class PosController extends AdminController
{
	protected $menuname = 'soheader';		
	public $module = 'order';
	protected $pageTitle = 'Point of Sales';
	public $wfname = 'appso';
	protected $sqldata = "
			select a.*, b.companyname, c.fullname, d.fullname as salesname, e.paycode, e.paymentname, f.taxcode,f.taxvalue,
			c.currentlimit, c.creditlimit, a.statusname, a.totalbefdisc, a.shipto, a.billto, a.totalaftdisc, c.top,	c.overdue,
			case when (((hutang + totalaftdisc + 
				(select ifnull(sum(ifnull(getamountdiscso(za.soheaderid,z.sodetailid,z.qty-z.giqty),0)),0)
				from sodetail z
				join soheader za on z.soheaderid=za.soheaderid
				where za.recordstatus=6 and z.qty>z.giqty and za.addressbookid=a.addressbookid and za.soheaderid<>a.soheaderid)) > creditlimit) and (top < 0)) then 1  
			when (((hutang + totalaftdisc + 
				(select ifnull(sum(ifnull(getamountdiscso(za.soheaderid,z.sodetailid,z.qty-z.giqty),0)),0)
				from sodetail z
				join soheader za on z.soheaderid=za.soheaderid
				where za.recordstatus=6 and z.qty>z.giqty and za.addressbookid=a.addressbookid and za.soheaderid<>a.soheaderid)) <= creditlimit) and (top < 0)) then 2  
			when (((hutang + totalaftdisc + (select ifnull(sum(ifnull(getamountdiscso(za.soheaderid,z.sodetailid,z.qty-z.giqty),0)),0)
				from sodetail z
				join soheader za on z.soheaderid=za.soheaderid
				where za.recordstatus=6 and z.qty>z.giqty and za.addressbookid=a.addressbookid and za.soheaderid<>a.soheaderid)) > creditlimit) and (top >= 0)) then 3
			else 4 end as warna,
			(select ifnull(sum(ifnull(getamountdiscso(za.soheaderid,z.sodetailid,z.qty-z.giqty),0)),0)
				from sodetail z
				join soheader za on z.soheaderid=za.soheaderid
				where za.recordstatus=6 and z.qty>z.giqty and za.addressbookid=a.addressbookid and za.soheaderid<>a.soheaderid) as pendinganso 
		from soheader a
		left join company b on b.companyid = a.companyid
		left join addressbook c on c.addressbookid = a.addressbookid 
		left join employee d on d.employeeid = a.employeeid
		left join paymentmethod e on e.paymentmethodid = a.paymentmethodid 
		left join tax f on f.taxid = a.taxid ";
	protected $sqlcount = 'select count(1) 
		from soheader a
		left join company b on b.companyid = a.companyid
		left join addressbook c on c.addressbookid = a.addressbookid 
		left join employee d on d.employeeid = a.employeeid
		left join paymentmethod e on e.paymentmethodid = a.paymentmethodid 
		left join tax f on f.taxid = a.taxid ';
		
	protected $sqldatasodetail = 'select t.*,a.productname,b.uomcode,c.currencyname,d.sloccode,
			(t.price * t.qty * t.currencyrate) as total,
			(select sum(z.qty) from productstock z 
         where z.productid = t.productid and z.unitofmeasureid = t.unitofmeasureid and z.slocid = t.slocid) as qtystock
			from sodetail t 
			left join product a on a.productid = t.productid
			left join unitofmeasure b on b.unitofmeasureid = t.unitofmeasureid 
			left join currency c on c.currencyid = t.currencyid 
			left join sloc d on d.slocid = t.slocid ';
	protected $sqlcountsodetail = 'select count(1) 
		from sodetail a 
		left join product b on b.productid = a.productid 
		left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid 
		left join sloc d on d.slocid = a.slocid 
		left join currency e on e.currencyid = a.currencyid ';
	
	protected $sqldatasodisc = 'select a.* 
		from sodisc a  ';
	protected $sqlcountsodisc = 'select count(1) 
		from sodisc a ';
	
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a.recordstatus in (select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join groupaccess c on c.groupaccessid = b.groupaccessid
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where upper(a.wfname) = upper('listso') and upper(e.username)=upper('".Yii::app()->user->name."') and a.companyid in (select gm.menuvalueid from groupmenuauth gm
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(ma.menuobject) = upper('company') and gm.groupaccessid = c.groupaccessid))
				";
		if ((isset($_REQUEST['fullname'])) && (isset($_REQUEST['pocustno'])) && (isset($_REQUEST['salesname']))
			&& (isset($_REQUEST['companyname'])))
		{				
			$where .= " and a.pocustno like '%". $_REQUEST['pocustno']."%' 
				and b.companyname like '%". $_REQUEST['companyname']."%' 
				and c.fullname like '%". $_REQUEST['fullname']."%' 
				and d.fullname like '%". $_REQUEST['salesname']."%'
				"; 
		}
		if (isset($_REQUEST['soheaderid']))
		{
			if (($_REQUEST['soheaderid'] !== '0') && ($_REQUEST['soheaderid'] !== ''))
			{
				$where .= " and a.soheaderid in (".$_REQUEST['soheaderid'].")";
			}
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function getTotal($soheaderid)
	{
		if (isset($soheaderid))
		{
			return Yii::app()->db->createCommand("select sum(a.qty * a.price * a.currencyrate) 
				from sodetail a
				where a.soheaderid = ".$soheaderid)->queryScalar();
		}
		else
			return 0;
	}
	
  public function actionGeneratedetail()
  {
    if (isset($_POST['poheaderid'])) {
      
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        $sql     = 'call GenerateSOPO(:vid, :vhid, :vcompanyid, :vcreatedby)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $_POST['poheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vhid', $_POST['soheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vcompanyid', $_POST['companyid'], PDO::PARAM_INT);
        $command->bindvalue(':vcreatedby', Yii::app()->user->id, PDO::PARAM_STR);
        $command->execute();
        $transaction->commit();
          
        $query = 'select a.fullname as customername, t.paymentmethodid, t.taxid, t.shipto, t.billto, t.headernote, b.paymentname, c.taxcode, t.addressbookid
        from poheader t
        join addressbook a on t.addressbookid = a.addressbookid
        join paymentmethod b on b.paymentmethodid = t.paymentmethodid
        join tax c on c.taxid = t.taxid
        where poheaderid = '.$_POST['poheaderid'];
        
        //$this->getMessage('success','alreadysaved');
        $row = Yii::app()->db->createCommand($query)->queryRow();
        echo CJSON::encode(array(
            'status'=>'success',
            'shipto'=>$row['shipto'],
            'billto'=>$row['billto'],
            'customername'=>$row['customername'],
            'headernote'=>$row['headernote'],
            'addressbookid'=>$row['addressbookid'],
            'taxid'=>$row['taxid'],
            'taxcode'=>$row['taxcode'],
            'paymentmethodid'=>$row['paymentmethodid'],
            'paymentname'=>$row['paymentname']
        ));
        
      }
      catch (Exception $e) {
        $transaction->rollBack();
        $this->GetMessage(true, $e->getMessage(), 1);
      }
    }
    Yii::app()->end();
  }
    
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'soheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'soheaderid', 'sodate','sono','companyid','addressbookid', 'creditlimit', 'top', 'paycode', 'currentlimit',
             'employeeid','pocustno','pendinganso', 'totalaftdisc'
        ),
				'defaultOrder' => array( 
					'soheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['soheaderid']))
		{
			$this->sqlcountsodetail .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$this->sqldatasodetail .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$count = Yii::app()->db->createCommand($this->sqlcountsodetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatasodetail .= " limit 0";
		}
		$countsodetail = $count;
		$dataProvidersodetail=new CSqlDataProvider($this->sqldatasodetail,array(
			'totalItemCount'=>$countsodetail,
			'keyField'=>'sodetailid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'sodetailid' => CSort::SORT_ASC
				),
			),
		));
		if (isset($_REQUEST['soheaderid']))
		{
			$this->sqlcountsodisc .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$this->sqldatasodisc .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$count = Yii::app()->db->createCommand($this->sqlcountsodisc)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatasodisc .= " limit 0";
		}
		$countsodisc = $count;
		$dataProvidersodisc=new CSqlDataProvider($this->sqldatasodisc,array(
			'totalItemCount'=>$countsodisc,
			'keyField'=>'sodiscid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'sodiscid' => CSort::SORT_ASC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersodetail'=>$dataProvidersodetail,
			'dataProvidersodisc'=>$dataProvidersodisc));
	}
	
	public function actionGenerateaddress()
		{
			$product = null;
			if(isset($_POST['id']))
			{
				$depedency = new CDbCacheDependency('SELECT MAX(productplantid) FROM productplant');
				$product = Customeraddress::model()->cache(1000,$depedency)->findbyattributes(array('addressbookid'=>$_POST['id']));
			}
			if (Yii::app()->request->isAjaxRequest)
			{
				$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
				try
				{
					$sql = 'call GenerateCustDisc(:vid, :vhid)';
					$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
					$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
					$command->execute();
					$transaction->commit();
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$transaction->rollBack();
				}
				echo CJSON::encode(array(
				'shipto'=> ($product !== null)?$product->addressname. ' ' . ($product->city!==null)?$product->city->cityname:"":'',
				'billto'=> ($product !== null)?$product->addressname. ' ' . ($product->city!==null)?$product->city->cityname:"":'',
				));
				Yii::app()->end();
			}
		}
	
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into soheader (recordstatus) values (".$this->findstatusbyuser('insso').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$soheaderid = Yii::app()->db->createCommand($sql)->queryScalar();
		echo CJSON::encode(array(
			'status'=>'success',
			'soheaderid'=>$soheaderid,
			'sodate'=>date('Y-m-d'),
			'recordstatus'=>$this->findstatusbyuser('insso')
		));
	}
	
	public function actionCreatesodetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			'currencyid'=>$this->GetParameter('basecurrencyid'),
			'currencyname'=>$this->GetParameter('basecurrency')
		));
	}
	
	public function actionCreatesodisc()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}
	
	public function actionGetdata()
	{
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where a.soheaderid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'soheaderid'=>$model['soheaderid'],
					'sono'=>$model['sono'],
					'sodate'=>$model['sodate'],
					'companyid'=>$model['companyid'],
					'companyname'=>$model['companyname'],
					'addressbookid'=>$model['addressbookid'],
					'fullname'=>$model['fullname'],
					'pocustno'=>$model['pocustno'],
					'employeeid'=>$model['employeeid'],
					'salesname'=>$model['salesname'],
					'paymentmethodid'=>$model['paymentmethodid'],
					'paymentname'=>$model['paymentname'],
					'taxid'=>$model['taxid'],
					'taxcode'=>$model['taxcode'],
					'shipto'=>$model['shipto'],
					'billto'=>$model['billto'],
					'headernote'=>$model['headernote'],
					'invamount'=>$model['invamount'],
					'payamount'=>$model['payamount'],
					'recordstatus'=>$model['recordstatus'],
					));
				Yii::app()->end();
			}
		}
	}
	
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where a.soheaderid = '.$id)->queryRow();
			if ($model !== null)
			{
				//var_dump($this->sqldata);
				echo CJSON::encode(array(
					'status'=>'success',
					'soheaderid'=>$model['soheaderid'],
					'sono'=>$model['sono'],
					'sodate'=>$model['sodate'],
					'companyid'=>$model['companyid'],
					'companyname'=>$model['companyname'],
					'poheaderid'=>$model['poheaderid'],
					'pono'=>$model['pono'],
					'addressbookid'=>$model['addressbookid'],
					'fullname'=>$model['fullname'],
					'pocustno'=>$model['pocustno'],
					'employeeid'=>$model['employeeid'],
					'salesname'=>$model['salesname'],
					'paymentmethodid'=>$model['paymentmethodid'],
					'paymentname'=>$model['paymentname'],
					'taxid'=>$model['taxid'],
					'taxcode'=>$model['taxcode'],
					'shipto'=>$model['shipto'],
					'billto'=>$model['billto'],
					'headernote'=>$model['headernote'],
					'recordstatus'=>$model['recordstatus'],
					));
				Yii::app()->end();
			}
		}
	}
	
	public function actionClose()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			echo CJSON::encode(array(
				'status'=>'success',
				));
			Yii::app()->end();
		}
	}
	
	public function actionUpdatesodetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasodetail.' where sodetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'sodetailid'=>$model['sodetailid'],
					'productid'=>$model['productid'],
					'productname'=>$model['productname'],
					'qty'=>$model['qty'],
					'unitofmeasureid'=>$model['unitofmeasureid'],
					'uomcode'=>$model['uomcode'],
					'slocid'=>$model['slocid'],
					'sloccode'=>$model['sloccode'],
					'price'=>$model['price'],
					'currencyid'=>$model['currencyid'],
					'currencyname'=>$model['currencyname'],
					'currencyrate'=>$model['currencyrate'],
					'delvdate'=>$model['delvdate'],
					'itemnote'=>$model['itemnote'],
					));
				Yii::app()->end();
			}
		}
	}
	
	public function actionUpdatesodisc()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasodisc.' where sodiscid = '.((is_array($id))?$id[0]:$id))->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'sodiscid'=>$model['sodiscid'],
					'soheaderid'=>$model['soheaderid'],
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
			array('sodate','string','emptydocdate'),
			array('companyid','string','emptycompany'),
			array('addressbookid','string','emptycustomer'),
			array('employeeid','string','emptysales'),
			array('paymentmethodid','string','emptypaymentmethod'),
			array('taxid','string','emptytax'),
		));
		if ($error == false)
		{
			$id = $_POST['addressbookid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatesoheader(:vid,:vsodate,:vcompanyid,:vpoheaderid,:vaddressbookid,:vpocustno,:vemployeeid,:vpaymentmethodid,:vtaxid,:vshipto,:vbillto,:vheadernote,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['soheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':vsodate',date(Yii::app()->params['datetodb'], strtotime($_POST['sodate'])),PDO::PARAM_STR);
				$command->bindvalue(':vcompanyid',$_POST['companyid'],PDO::PARAM_STR);
                $command->bindvalue(':vpoheaderid', $_POST['poheaderid'], PDO::PARAM_STR);
				$command->bindvalue(':vaddressbookid',$_POST['addressbookid'],PDO::PARAM_STR);
				$command->bindvalue(':vpocustno',$_POST['pocustno'],PDO::PARAM_STR);
				$command->bindvalue(':vemployeeid',$_POST['employeeid'],PDO::PARAM_STR);
				$command->bindvalue(':vpaymentmethodid',$_POST['paymentmethodid'],PDO::PARAM_STR);
				$command->bindvalue(':vtaxid',$_POST['taxid'],PDO::PARAM_STR);
				$command->bindvalue(':vshipto',$_POST['shiptoid'],PDO::PARAM_STR);
				$command->bindvalue(':vbillto',$_POST['billtoid'],PDO::PARAM_STR);
				$command->bindvalue(':vheadernote',$_POST['headernote'],PDO::PARAM_STR);
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
	
	public function actionSavesodetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('soheaderid','string','emptysoheader'),
			array('productid','string','emptyproduct'),
			array('qty','string','emptyqty'),
			array('unitofmeasureid','string','emptyuom'),
			array('slocid','string','emptysloc'),
			array('price','string','emptyprice'),
			array('currencyid','string','emptycurrency'),
			array('currencyrate','string','emptycurrencyrate'),
		));
		if ($error == false)
		{
			$id = $_POST['sodetailid'];
			$curharga = $_POST['price'];
			$harga = (int)preg_replace("/([^0-9\\,])/i", "", "$curharga");
			if ($id !== '')
			{
				$sql = "update sodetail set 
					soheaderid = ".$_POST['soheaderid'].",
					productid = ".$_POST['productid'].",
					qty = ".$_POST['qty'].",
					unitofmeasureid = ".$_POST['unitofmeasureid'].",
					slocid = ".$_POST['slocid'].",
					price = ".$_POST['price'].",
					currencyid = ".$_POST['currencyid'].",
					currencyrate = ".$_POST['currencyrate'].",
					delvdate = '".date(Yii::app()->params['datetodb'], strtotime($_POST['delvdate']))."',
					itemnote = '".$_POST['itemnote']."'
					where sodetailid = ".$id;
			}
			else
			{
				$sql = "insert into sodetail (soheaderid,productid,qty,unitofmeasureid,slocid,price,currencyid,currencyrate,itemnote,delvdate) 
					values (".$_POST['soheaderid'].",".$_POST['productid'].",".$_POST['qty'].",
						".$_POST['unitofmeasureid'].",".$_POST['slocid'].",".$_POST['price'].",".$_POST['currencyid'].",
						".$_POST['currencyrate'].",'".$_POST['itemnote']."','".date(Yii::app()->params['datetodb'], strtotime($_POST['delvdate']))."')";
			}
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$command = $connection->createCommand($sql);
				$command->execute();
				$this->InsertTranslog($command,$id);
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
	
	public function actionSavesodisc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('soheaderid','string','emptysoheader'),
			array('discvalue','string','emptydiscvalue'),
		));
		if ($error == false)
		{
			$id = $_POST['sodiscid'];
			if ($id !== '')
			{
				$sql = "update sodisc set 
					soheaderid = '".$_POST['soheaderid']."',
					discvalue = ".$_POST['discvalue']."	
					where sodiscid = ".$id;
			}
			else
			{
				$sql = "insert into sodisc (soheaderid,discvalue) 
					values (".$_POST['soheaderid'].",".$_POST['discvalue'].")";
			}
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$command=$connection->createCommand($sql);
				$command->execute();
				$this->InsertTranslog($command,$id);
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
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call ApproveSO(:vid,:vcreatedby)';
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
	
	public function actionReject()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call DeleteSO(:vid,:vcreatedby)';
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
			$id = $_POST['id'];
			$sql = "delete from sodisc where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = "delete from sodetail where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = "delete from soheader where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionPurgesodetail()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			for ($i = 0; $i < count($_POST['id']);$i++)
			{
				$sql = "delete from sodetail where sodetailid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
			}
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionPurgesodisc()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$id = $_POST['id'];
			$sql = "delete from sodisc where sodiscid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionUpload()
	{
		parent::actionUpload();
		if (($handle = fopen($storeFolder.$_FILES['upload']['name'], "r")) !== FALSE) 
		{
			$s = $this->getParameter('csvformat');
			$row=1;
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				while (($data = fgetcsv($handle, 2000, $s )) !== FALSE) 
				{
					if ($row>1)
					{
						$sql = "replace into soheader (soheaderid,fullname,recordstatus) 
							values (".$data[0].",'".$data[1]."',".$data[2].")";
						$connection->createCommand($sql)->execute();
					}
					$row++;
				}					
				$transaction->commit();
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->GetMessage('error',$e->getMessage());
			}
		}
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.companyid, a.soheaderid,a.sono, b.fullname as customername, a.sodate, c.paymentname, e.taxcode, e.taxvalue,
			a.addressbookid, a.headernote,a.recordstatus,a.shipto,a.billto,d.fullname as salesname
      from soheader a
      join addressbook b on b.addressbookid = a.addressbookid
		  join employee d on d.employeeid = a.employeeid
      join paymentmethod c on c.paymentmethodid = a.paymentmethodid
		  join tax e on e.taxid = a.taxid ";
    if ($_GET['soheaderid'] !== '') {
      $sql = $sql . "where a.soheaderid in (" . $_GET['soheaderid'] . ")";
    }
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $row['companyid'];
    }
    $this->pdf->title = 'Sales Order';
    $this->pdf->AddPage('P', array(
      220,
      140
    ));
    $this->pdf->AliasNbPages();
    $this->pdf->AddFont('Tahoma', '', 'tahoma.php');
    $this->pdf->SetFont('Tahoma');
    foreach ($dataReader as $row) {
      if ($row['addressbookid'] > 0) {
        $sql1        = "select b.addresstypename, a.addressname, c.cityname, a.phoneno
					from address a
					left join addresstype b on b.addresstypeid = a.addresstypeid
					left join city c on c.cityid = a.cityid
					where addressbookid = " . $row['addressbookid'] . " order by addressid " . " limit 1";
        $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
        $phone;
        foreach ($dataReader1 as $row1) {
          $phone = $row1['phoneno'];
        }
      }
      $this->pdf->SetFontSize(8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        20,
        100,
        30,
        60
      ));
      $this->pdf->row(array(
        'Customer',
        '',
        'Sales Order No',
        ' : ' . $row['sono']
      ));
      $this->pdf->row(array(
        'Name',
        ' : ' . $row['customername'],
        'SO Date',
        ' : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['sodate']))
      ));
      $this->pdf->row(array(
        'Phone',
        ' : ' . $phone,
        'Sales',
        ' : ' . $row['salesname']
      ));
      $this->pdf->row(array(
        'Address',
        ' : ' . $row['shipto'],
        'Payment',
        ' : ' . $row['paymentname']
      ));
      $sql1        = "select a.soheaderid,c.uomcode,a.qty,a.price,(qty * price) + (e.taxvalue * qty * price / 100) as total,b.productname,
			d.symbol,d.i18n,(e.taxvalue * qty * price / 100) as taxvalue,a.itemnote
			from sodetail a
			left join soheader f on f.soheaderid = a.soheaderid 
			left join product b on b.productid = a.productid
			left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
			left join currency d on d.currencyid = a.currencyid
			left join tax e on e.taxid = f.taxid
			where a.soheaderid = " . $row['soheaderid'];
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $total       = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 0);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        15,
        15,
        70,
        40,
        25,
        35
      ));
      $this->pdf->colheader = array(
        'Qty',
        'Units',
        'Description',
        'Item Note',
        'Unit Price',
        'Total'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'R',
        'C',
        'L',
        'L',
        'R',
        'R',
        'R'
      );
      foreach ($dataReader1 as $row1) {
        $this->pdf->row(array(
          Yii::app()->format->formatNumber($row1['qty']),
          $row1['uomcode'],
          $row1['productname'],
          $row1['itemnote'],
          Yii::app()->format->formatCurrency($row1['price']),
          Yii::app()->format->formatCurrency($row1['total'])
        ));
        $total    = $row1['total'] + $total;
        $totalqty = $row1['qty'] + $totalqty;
      }
      $this->pdf->row(array(
        Yii::app()->format->formatNumber($totalqty),
        '',
        'Total',
        '',
        Yii::app()->format->formatCurrency($total)
      ));
      $sql1        = "select a.discvalue
			from sodisc a
			where a.soheaderid = " . $row['soheaderid'];
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $discvalue   = '';
      foreach ($dataReader1 as $row1) {
        if ($discvalue == '') {
          $discvalue = Yii::app()->format->formatNumber($row1['discvalue']);
        } else {
          $discvalue = $discvalue . ' + ' . Yii::app()->format->formatNumber($row1['discvalue']);
        }
      }
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        35,
        155,
        155,
        155,
        155,
        155
      ));
      $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array(
        'none',
        'none',
        'none',
        'none',
        'none',
        'none'
      ));
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'L',
        'L',
        'L',
        'L'
      );
      $this->pdf->row(array(
        'Diskon (%)',
        $discvalue
      ));
      $cmd                 = Yii::app()->db->createCommand()->selectdistinct('gettotalamountdiscso(t.soheaderid) as amountafterdisc')->from('sodetail t')->where('soheaderid = :soheaderid', array(
        ':soheaderid' => $row['soheaderid']
      ))->queryRow();
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        35,
        155,
        155,
        155,
        155,
        155
      ));
      $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array(
        'none',
        'none',
        'none',
        'none',
        'none',
        'none'
      ));
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'L',
        'L',
        'L',
        'L'
      );
      $this->pdf->row(array(
        'Harga Diskon',
        Yii::app()->format->formatNumber($total - $cmd['amountafterdisc'])
      ));
      $bilangan = explode(".", $cmd['amountafterdisc']);
      $this->pdf->row(array(
        'Harga Sesudah Diskon',
        Yii::app()->format->formatCurrency($cmd['amountafterdisc']) . ' (' . $this->eja($bilangan[0]) . ')'
      ));
      $this->pdf->sety($this->pdf->gety());
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        35,
        155,
        155,
        155,
        155,
        155
      ));
      $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array(
        'none',
        'none',
        'none',
        'none',
        'none',
        'none'
      ));   
			$this->pdf->coldetailalign = array(
        'L',
        'L',
        'L',
        'L',
        'L',
        'L'
      );
      $this->pdf->row(array(
        'Ship To',
        $row['shipto']
      ));
      $this->pdf->row(array(
        'Bill To',
        $row['billto']
      ));
      $this->pdf->row(array(
        'Note',
        $row['headernote']
      ));
      $this->pdf->checkNewPage(10);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->text(10, $this->pdf->gety(), 'Pembuat');
      $this->pdf->text(50, $this->pdf->gety(), 'Mengetahui');
      $this->pdf->text(10, $this->pdf->gety() + 15, '........................');
      $this->pdf->text(50, $this->pdf->gety() + 15, '........................');
    }
    $this->pdf->Output();
	}
	
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$excel=Yii::createComponent('application.extensions.PHPExcel.PHPExcel');
		$i=1;
		$excel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,1,$this->getCatalog('fullname'));
		foreach($dataReader as $row1)
		{
			  $excel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['fullname']);
		$i+=1;
		}
		$this->getFooterXLS($excel);
	}
}
