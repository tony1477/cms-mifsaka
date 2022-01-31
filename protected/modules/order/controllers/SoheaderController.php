<?php

class SoheaderController extends AdminController
{
	protected $menuname = 'soheader';		
	public $module = 'order';
	protected $pageTitle = 'Sales Order';
	public $wfname = 'appso';
	protected $sqldata = "
			select a.*, b.companyname, c.fullname, d.fullname as salesname, e.paycode, e.paymentname, f.taxcode,f.taxvalue,
			c.currentlimit, c.creditlimit, a.statusname, a.totalbefdisc, a.shipto, a.billto, a.totalaftdisc, c.top,	c.overdue,
			case when (((a.currentlimit + a.totalaftdisc + a.pendinganso) > c.creditlimit) and (c.top > 0)) then 1  
			when (((a.currentlimit + a.totalaftdisc + a.pendinganso) <= c.creditlimit) and (c.top > 0)) then 2  
			when (((a.currentlimit + a.totalaftdisc + a.pendinganso) > c.creditlimit) and (c.top <= 0)) then 3
			else 4 end as warna,a.pendinganso, isdisplay, sotype, a.packageid, g.packagename, a.materialtypeid,h.description,
			case when sotype = 1 then 'UMUM' when sotype = 2 then 'PAKET' when sotype = 3 then 'CABANG' end as sotypename,
			case when sotype = 1 then h.description when sotype = 2 then g.docno when sotype = 3 then pono end as nodokumen,
			qtypackage,a.createddate,a.updatedate
		from soheader a
		left join company b on b.companyid = a.companyid
		left join addressbook c on c.addressbookid = a.addressbookid 
		left join employee d on d.employeeid = a.employeeid
		left join paymentmethod e on e.paymentmethodid = a.paymentmethodid 
		left join tax f on f.taxid = a.taxid 
		left join packages g on g.packageid = a.packageid 
		left join materialtype h on h.materialtypeid = a.materialtypeid ";
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

  protected $sqlcustomerinfo1 = "select addressbookid, fullname from addressbook ";
  
  protected $sqlcustomerinfo = "
    select *, (amount-payamount) as sisa,(amount) as nilai
    from (select b.giheaderid,if(c.isdisplay=1,concat(a.invoiceno,'_D'),a.invoiceno) as invoiceno,a.invoicedate,e.paydays,
    date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
    datediff(curdate(),a.invoicedate) as umur,
    datediff(curdate(),date_add(a.invoicedate, INTERVAL e.paydays DAY)) as umurtempo,a.amount,ff.fullname as sales,
    ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
    from cutarinv f
    join cutar g on g.cutarid=f.cutarid
    where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
    from invoice a
    inner join giheader b on b.giheaderid = a.giheaderid
    inner join soheader c on c.soheaderid = b.soheaderid
    inner join addressbook d on d.addressbookid = c.addressbookid
    inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
    inner join employee ff on ff.employeeid = c.employeeid
  ";

  protected $sqlcountcustomer1 = "select ifnull(count(1),0) from addressbook ";
  protected $sqlcountcustomer = "
    select ifnull(count(1),0) 
    from (select b.giheaderid,if(c.isdisplay=1,concat(a.invoiceno,'_D'),a.invoiceno) as invoiceno,a.invoicedate,e.paydays,
    date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
    datediff(curdate(),a.invoicedate) as umur,
    datediff(curdate(),date_add(a.invoicedate, INTERVAL e.paydays DAY)) as umurtempo,a.amount,ff.fullname as sales,
    ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
    from cutarinv f
    join cutar g on g.cutarid=f.cutarid
    where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
    from invoice a
    inner join giheader b on b.giheaderid = a.giheaderid
    inner join soheader c on c.soheaderid = b.soheaderid
    inner join addressbook d on d.addressbookid = c.addressbookid
    inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
    inner join employee ff on ff.employeeid = c.employeeid
  ";
	
	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appso')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a.recordstatus in (".getUserRecordStatus('listso').")
		and (a.soheaderid in (select distinct a1.soheaderid from sodetail a1 join sloc b1 on b1.slocid=a1.slocid where b1.plantid in (".getUserObjectValues('plant')."))
		or a.soheaderid in (select yy.soheaderid from sodetail xx right join soheader yy on xx.soheaderid = yy.soheaderid where yy.companyid in(".getUserObjectWfValues('company','appso').") and xx.slocid is null))
		and a.recordstatus < {$maxstat} and a.companyid in (".getUserObjectWfValues('company','appso').")
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
	
    public function actioncheckMaterialtype() {
        // delete sodetail and sodisc
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        //$cmd = Yii::app()->db->createCommand;
        try {
            $sql = "call setMaterialtypeCustomer(:vsoheaderid,:vaddressbookid,:vmaterialtypeid,:vcreatedby)";
            $command = $connection->createCommand($sql);
            $command->bindvalue(':vsoheaderid', $_POST['soheaderid'], PDO::PARAM_INT);
            $command->bindvalue(':vaddressbookid', $_POST['addressbookid'], PDO::PARAM_INT);
            $command->bindvalue(':vmaterialtypeid', $_POST['materialtypeid'], PDO::PARAM_INT);
            $command->bindvalue(':vcreatedby', Yii::app()->user->id, PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            
            if (isset($_POST['materialtypeid'])) {
                $q = Yii::app()->db->createCommand("select ifnull(iseditpriceso,0) as iseditpriceso, ifnull(iseditdiscso,0) as iseditdiscso,ifnull(isedittop,0) as isedittop, (select sopaymethodid from custdisc where addressbookid = {$_REQUEST['addressbookid']} and materialtypeid = {$_REQUEST['materialtypeid']}) as paymentmethodid
                from materialtype where materialtypeid = ".$_POST['materialtypeid'])->queryRow();
            }
            $paycode = Yii::app()->db->createCommand('select paycode from paymentmethod where paymentmethodid = '.$q['paymentmethodid'])->queryScalar();
            echo json_encode (array(
                'status' => 'success',
                'iseditpriceso' => $q['iseditpriceso'],
                'iseditdiscso' => $q['iseditdiscso'],
                'isedittop' => $q['isedittop'],
                'paymentmethodid' => $q['paymentmethodid'],
                'paycode' => $paycode,
                'div' => $this->getCatalog('alreadysaved')
            ));
            //$this->getMessage('success','alreadysaved');
      }
      catch (Exception $e) {
        $transaction->rollBack();
        $this->GetMessage(true, $e->getMessage(), 1);
      }
      
    }
    
    protected function checkAccessSO($soheaderid){
        if($soheaderid!='') {
            //$sqlcheckSO = Yii::app()->db->createCommand()
            return true;
        }
        else
        {
            return false;
        }
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
	
    public function actionGeneratepackagedetail()
    {
        if (isset($_POST['soheaderid']) && isset($_POST['packageid'])) {
      
      $connection  = Yii::app()->db;
      $transaction = $connection->beginTransaction();
      try {
        $sql     = 'call GeneratePackageSO(:vid, :vhid,:vcompanyid, :vqty,:vaddressbookid,:vcreatedby)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $_POST['packageid'], PDO::PARAM_INT);
        $command->bindvalue(':vhid', $_POST['soheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vcompanyid', $_POST['companyid'], PDO::PARAM_INT);
        $command->bindvalue(':vqty', $_POST['qty'], PDO::PARAM_INT);
        $command->bindvalue(':vaddressbookid', $_REQUEST['addressbookid'], PDO::PARAM_INT);
        $command->bindvalue(':vcreatedby', Yii::app()->user->id, PDO::PARAM_STR);
        $command->execute();
        
        /*  
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
        */
        //$this->getMessage('success','alreadysaved');
        $query = Yii::app()->db->createCommand("select paymentmethodid, paycode from paymentmethod where paymentmethodid = (select paymentmethodid from packages a where a.packageid = {$_REQUEST['packageid']})")->queryRow();
        $transaction->commit();
        echo json_encode (array(
                'status' => 'success',
                //'iseditpriceso' => $q['iseditpriceso'],
                //'iseditdiscso' => $q['iseditdiscso'],
                'paymentmethodid' => $query['paymentmethodid'],
                'paycode' => $query['paycode'],
                'div' => $this->getCatalog('alreadysaved')
        ));
      }
      catch (Exception $e) {
        $transaction->rollBack();
        $this->GetMessage(true, $e->getMessage(), 1);
      }
    }
    Yii::app()->end();   
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
  public function actiongetTop() {
        $paydays = $_POST['payday'];
        $sql = "select paymentmethodid, paycode from paymentmethod where paydays=".$paydays;
        $q = Yii::app()->db->createCommand($sql)->queryRow();
        echo json_encode (array(
            'status' => 'success',
            'paycode' => $q['paycode'],
            'paymentmethodid' => $q['paymentmethodid']
        ));
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
             'employeeid','pocustno','pendinganso', 'totalaftdisc','isdisplay','nodokumen'
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

    $companyid='null';
    $addressbookid = 0;
    if(isset($_REQUEST['addressbookid'])) {
      $companyid = $_REQUEST['companyid'];
      $addressbookid = $_REQUEST['addressbookid'];
    }
    $wheres = " where d.fullname like '%%' and ff.fullname like '%%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = 
    ".$companyid." 
    and d.addressbookid = ".$addressbookid."
    and a.invoicedate <= curdate())z
    where amount > payamount 
    order by umur desc";

    //$wheres = " where addressbookid  = ".$addressbookid;
    //$this->sqlcustomerinfo.$wheres;

    $countcustomerinfo = Yii::app()->db->createCommand($this->sqlcountcustomer.$wheres)->queryScalar();
   $dataProviderCustomerinfo = new CSqlDataProvider($this->sqlcustomerinfo.$wheres,array(
			'totalItemCount'=>$countcustomerinfo,
			'keyField'=>'invoiceno',
			'pagination'=> array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'defaultOrder' => array( 
					'umur' => CSort::SORT_DESC
				),
			),
		));
        
        $sotype = array('JENIS MATERIAL','PAKET','CABANG');
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersodetail'=>$dataProvidersodetail,
			'dataProvidersodisc'=>$dataProvidersodisc,'sotype'=>$sotype,'dataProviderCustomerinfo'=>$dataProviderCustomerinfo));
	}

  public function actionCustomerinfo() {
      $sql = "select ifnull(sum(amount-payamount),0) as piutang, za.creditlimit,getpendinganso(soheaderid,z.addressbookid) as pendinganso
							from (select b.giheaderid,a.invoicedate,a.amount,d.addressbookid,c.soheaderid,
              datediff(curdate(),a.invoicedate) as umur,
							ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
							from cutarinv f
							join cutar g on g.cutarid=f.cutarid
							where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
							from invoice a
							inner join giheader b on b.giheaderid = a.giheaderid
							inner join soheader c on c.soheaderid = b.soheaderid
							inner join addressbook d on d.addressbookid = c.addressbookid
							inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
							inner join employee ff on ff.employeeid = c.employeeid
							where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$_REQUEST['companyid']." 
							and d.addressbookid = '".$_REQUEST['addressbookid']."' 
							and a.invoicedate <= curdate())z
              join addressbook za on za.addressbookid = z.addressbookid
							where amount > payamount
              and za.addressbookid = ".$_REQUEST['addressbookid']."
              order by umur desc";

      $q = Yii::app()->db->createCommand($sql)->queryRow();
      $sisa = $q['creditlimit'] - $q['piutang'] - $q['pendinganso'];
      echo CJSON::encode(array(
          'status' => 'success',
          'plafon'=> Yii::app()->format->formatNumber($q['creditlimit']),
          'piutang' => Yii::app()->format->formatNumber($q['piutang']),
          'pendinganso' => Yii::app()->format->formatNumber($q['pendinganso']),
          'sisa' => Yii::app()->format->formatCurrency($sisa),
				));
				Yii::app()->end();
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
					'isdisplay'=>$model['isdisplay'],
					'sotype'=>$model['sotype'],
					'packageid'=>$model['packageid'],
					'qtypkg'=>$model['qtypackage'],
					'packagename'=>$model['packagename'],
                    'materialtypeid'=>$model['materialtypeid'],
					'description'=>$model['description'],
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

     public function actionGetAttr() {
      $materialtypeid = $_REQUEST['materialtypeid'];
      $sql = "select ifnull(iseditpriceso,0) as iseditpriceso, ifnull(iseditdiscso,0) as iseditdiscso, ifnull(isedittop,0) as isedittop
      from materialtype a 
      where a.materialtypeid = ".$materialtypeid;
      $q = Yii::app()->db->createCommand($sql)->queryRow();
      echo CJSON::encode(array(
          'iseditpriceso' => $q['iseditpriceso'],
          'iseditdiscso' => $q['iseditdiscso'],
          'isedittop' => $q['isedittop'],
      ));
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
					'isbonus'=>$model['isbonus'],
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
				$sql = 'call Updatesoheader(:vid,:vsodate,:vcompanyid,:vpoheaderid,:visdisplay,:vsotype,:vmaterialtypeid,:vpackageid,:vqtypkg,:vaddressbookid,:vpocustno,:vemployeeid,:vpaymentmethodid,:vtaxid,:vshipto,:vbillto,:vheadernote,:vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['soheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':vsodate',date(Yii::app()->params['datetodb'], strtotime($_POST['sodate'])),PDO::PARAM_STR);
				$command->bindvalue(':vcompanyid',$_POST['companyid'],PDO::PARAM_STR);
                $command->bindvalue(':vpoheaderid', $_POST['poheaderid'], PDO::PARAM_STR);
				$command->bindvalue(':visdisplay',$_POST['isdisplay'],PDO::PARAM_STR);
				$command->bindvalue(':vsotype',$_POST['sotype'],PDO::PARAM_STR);
				$command->bindvalue(':vmaterialtypeid',$_POST['materialtypeid'],PDO::PARAM_STR);
				$command->bindvalue(':vpackageid',$_POST['packageid'],PDO::PARAM_STR);
				$command->bindvalue(':vqtypkg',($_POST['qtypackage']!='' ? $_POST['qtypackage'] : 0),PDO::PARAM_STR);
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
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try {
				if ($id == '') {
					$sql     = 'call Insertsodetail(:vsoheaderid,:vproductid,:vqty,:vuomid,:vslocid,:vprice,:vcurrencyid,:vcurrencyrate,:vdescription,:vdelvdate,:visbonus,:vcreatedby)';
					$command = Yii::app()->db->createCommand($sql);
				} else {
					$sql     = 'call Updatesodetail(:vid,:vsoheaderid,:vproductid,:vqty,:vuomid,:vslocid,:vprice,:vcurrencyid,:vcurrencyrate,:vdescription,:vdelvdate,:visbonus,:vcreatedby)';
					$command = Yii::app()->db->createCommand($sql);
					$command->bindvalue(':vid', $_POST['sodetailid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':vsoheaderid', $_POST['soheaderid'], PDO::PARAM_STR);
				$command->bindvalue(':vproductid', $_POST['productid'], PDO::PARAM_STR);
				$command->bindvalue(':vqty', $_POST['qty'], PDO::PARAM_STR);
				$command->bindvalue(':vuomid', $_POST['unitofmeasureid'], PDO::PARAM_STR);
				$command->bindvalue(':vslocid', $_POST['slocid'], PDO::PARAM_STR);
				$command->bindvalue(':vprice', $_POST['price'], PDO::PARAM_STR);
				$command->bindvalue(':vcurrencyid', $_POST['currencyid'], PDO::PARAM_STR);
				$command->bindvalue(':vcurrencyrate', $_POST['currencyrate'], PDO::PARAM_STR);
				$command->bindvalue(':vdescription', $_POST['itemnote'], PDO::PARAM_STR);
				$command->bindvalue(':vdelvdate', date(Yii::app()->params['datetodb'], strtotime($_POST['delvdate'])), PDO::PARAM_STR);
				$command->bindvalue(':visbonus', $_POST['isbonus'], PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
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
			try {
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				if ($id == '') {
					$sql     = 'call Insertsodisc(:vsoheaderid,:vdiscvalue,:vcreatedby)';
					$command = $connection->createCommand($sql);
				} else {
					$sql     = 'call Updatesodisc(:vid,:vsoheaderid,:vdiscvalue,:vcreatedby)';
					$command = $connection->createCommand($sql);
					$command->bindvalue(':vid', $_POST['sodiscid'], PDO::PARAM_STR);
				}
				$command->bindvalue(':vsoheaderid', $_POST['soheaderid'], PDO::PARAM_STR);
				$command->bindvalue(':vdiscvalue', $_POST['discvalue'], PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
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
	
	private function SendNotifWaCustomer($menuname,$idarray)
	{
    // getrecordstatus
		$ids = null;
		if(is_array($idarray)==TRUE) {
			foreach($idarray as $id) {
				$sql = "select soheaderid
							from soheader
							where recordstatus = getwfmaxstatbywfname('appso') and soheaderid = ".$id;
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
			if($ids != null) {
				$getCustomer = "select a.soheaderid,c.fullname, a.companyid, a.sodate, a.sono, d.companycode, a.totalbefdisc, a.totalaftdisc, replace((select wanumber from addresscontact z where z.addressbookid = a.addressbookid AND z.wanumber LIKE '+%' AND z.wanumber NOT LIKE '% %' AND z.wanumber NOT LIKE '%-%' AND length(z.wanumber) > 10 limit 1),'+','') as wanumber, (select telegramid from addresscontact z where z.addressbookid = a.addressbookid  limit 1) as telegramid
											from soheader a
											join addressbook c on c.addressbookid = a.addressbookid
											join company d on d.companyid = a.companyid
											where a.soheaderid in ({$ids})
											group by soheaderid
				";

				$res = Yii::app()->db->createCommand($getCustomer)->queryAll();
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$getWaNumber = "select e.productname, (b.qty) as qty, (b.price) as price, f.uomcode, (b.qty*price) as nilai
										from soheader a
										join sodetail b on b.soheaderid = a.soheaderid
										join product e on e.productid = b.productid
										left join unitofmeasure f on f.unitofmeasureid = b.unitofmeasureid
										where a.soheaderid = {$row['soheaderid']}
										-- group by productname 
										order by b.sodetailid
					";
		
					$pesanw = '';
					$pesant = '';
					$sendtocustomer = '';
					$i=1;
					$res1 = Yii::app()->db->createCommand($getWaNumber)->queryAll();
					$bilangan = explode(".", $row['totalaftdisc']);
					
					$sql2 = "select a.discvalue
					from sodisc a
					where a.soheaderid = {$row['soheaderid']}";
					$dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
					$discvaluew   = '';
					$discvaluet   = '';
					foreach ($dataReader2 as $row2) {
						if ($discvaluew == '') {
							$discvaluew = Yii::app()->format->formatCurrency($row2['discvalue']);
						} else {
							$discvaluew = $discvaluew . ' +' . Yii::app()->format->formatCurrency($row2['discvalue']);
						}
						if ($discvaluet == '') {
							$discvaluet = Yii::app()->format->formatCurrency($row2['discvalue']);
						} else {
							$discvaluet = $discvaluet . ' ' . Yii::app()->format->formatCurrency($row2['discvalue']);
						}
					}
					
					foreach($res1 as $row1) {
						$pesant .= $i.". ".Yii::app()->format->formatCurrency($row1['qty'])." ".$row1['uomcode']." ".$row1['productname']." @ Rp.".Yii::app()->format->formatCurrency($row1['price'])." Jumlah Rp.".Yii::app()->format->formatCurrency($row1['nilai'])."%0A%0A";
						//$pesant .= "";
						
						$pesanw .= $i.". ".Yii::app()->format->formatCurrency($row1['qty'])." ".$row1['uomcode']." ".$row1['productname']."\n\n";
						
						$pesanwfull .= $i.". ".Yii::app()->format->formatCurrency($row1['qty'])." ".$row1['uomcode']." ".$row1['productname']." @ Rp.".Yii::app()->format->formatCurrency($row1['price'])." Jumlah Rp.".Yii::app()->format->formatCurrency($row1['nilai'])."\n\n";
						$i++;
					}
					if ($wanumber > 0)
					{$sendtocustomer = "\n\n*SUDAH TERKIRIM ke No WA Customer*\n".$wanumber;}
					else
					{$sendtocustomer = "\n\n*BELUM ADA No WA Customer*\n".$row['fullname'];}
					
					$pesanwa = 
					"*KONFIRMASI PESANAN PELANGGAN*\n\nTerima kasih atas pesanan Customer ".$row['companycode']." :\n*".$row['fullname']."*\n\nPada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['sodate']))." No. ".$row['sono']." dengan rincian sebagai berikut:\n\n".$pesanw."*Apabila* :\n1. Sudah Sesuai, abaikan pesan ini.\n2. Tidak Sesuai, silahkan konfirmasi dengan klik >> https://t.me/kangaroospringbed_bot atau https://wa.me/6285272087379 , dengan melampirkan pesan ini.\n\nTerima kasih atas perhatian dan kerjasama pelanggan setia AKA Group.\n\n*JANGAN BALAS KE NO WA INI*\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesannowa = 
					"*Tidak Ada No WA* atau *No WA Belum Tepat* (PESANAN)\n\nCustomer ".$row['companycode']." :\n*".$row['fullname']."*\n\nPada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['sodate']))." No. ".$row['sono']."\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesanwafull = 
					"*KONFIRMASI PESANAN PELANGGAN*\n\nTerima kasih atas pesanan Customer ".$row['companycode']." :\n*".$row['fullname']."*\n\nPada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['sodate']))." No. ".$row['sono']." dengan rincian sebagai berikut:\n\n".$pesanwfull."*Total Pesanan Sblm Diskon* : ".Yii::app()->format->formatCurrency($row['totalbefdisc'])."\n*Diskon* ({$discvaluew} ): Rp. ".Yii::app()->format->formatCurrency($row['totalbefdisc'] - $row['totalaftdisc'])."\n\n*Total Pesanan Stlh Diskon* : Rp. ".Yii::app()->format->formatCurrency($row['totalaftdisc'])."\n(" . eja($bilangan[0]) . ")\n\n*Apabila* :\n1. Sudah Sesuai, abaikan pesan ini.\n2. Tidak Sesuai, silahkan konfirmasi dengan klik >> https://t.me/kangaroospringbed_bot atau https://wa.me/6285272087379 , dengan melampirkan pesan ini.\n\nTerima kasih atas perhatian dan kerjasama pelanggan setia AKA Group.\n\n*JANGAN BALAS KE NO WA INI*\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;

					if ($companyid == 1) {$telegroupid = "-1001435078485";} //AKA
					else if ($companyid == 11) {$telegroupid = "-1001435078485";} //UD1
					else if ($companyid == 12) {$telegroupid = "-1001435078485";} //UD2
					else if ($companyid == 21) {$telegroupid = "-1001196054232";} //AKS
					else if ($companyid == 17) {$telegroupid = "-1001211726344";} //AMIN 
					else if ($companyid == 20) {$telegroupid = "-1001442360059";} //AKM
					else if ($companyid == 18) {$telegroupid = "-1001257116233";} //AJM
					else if ($companyid == 7)  {$telegroupid = "-1001402373281";} //AMI
					else if ($companyid == 15) {$telegroupid = "-1001264861899";} //AGEM
					else if ($companyid == 14) {$telegroupid = "-1001406450805";} //AKP
					
					//device-key
					$indosat = "d4987114-8563-4fdf-b15c-ed328057fae2";
					$siaga = "bf1ea6ba-ecc5-488e-9d6a-d75947ecebcf";
					$as = "";

					$teleuserid =  '1021823837'; //telegram ADS
					//$wano = '6281717212109'; //wa ADS
					$wano = '6285888885050'; //wa ADS
					$nowanumber = '6285265644828';
					//$wano = '6285376361879';
					$auditgroup = '628127090802-1580887417';
					
					sendwajapri($siaga,$pesanwa,$wano);
/*				//Whatsva v3
					$ch = curl_init();
					curl_setopt_array($ch, array(
						CURLOPT_URL => Yii::app()->params['whatsva']."/sendText?id_device=1&message=".urlencode($pesanwa)."&tujuan=".$wano."@s.whatsapp.net",
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
			
				//Whatsva v4
					$ch = curl_init();
					curl_setopt_array($ch, array(
					CURLOPT_URL => "https://v4.whatsva.com/api/sendText?id_device=22&tujuan=".$wano."@s.whatsapp.net&message=".urlencode("*Whatsva Versi 4*\n\n".$pesanwa)."&id_user=44",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_HTTPHEADER => array(
							"apikey: BKHrsz3l"
						),
					));
					echo $res = curl_exec($ch);
*/				
					if ($companyid <> 18)
					{
						if ($wanumber > 0)
						{
						//Whatsapp Customer
							sendwajapri($siaga,$pesanwa,$wanumber);
/*							$ch = curl_init();
							curl_setopt_array($ch, array(
								CURLOPT_URL => Yii::app()->params['whatsva']."/sendText?id_device=1&message=".urlencode($pesanwa)."&tujuan=".$wanumber."@s.whatsapp.net",
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
							
							if ($res != '{"success":true,"message":"berhasil"}') {if ($wanumber > 0) {if ($res != '') {$sendtocustomer = "\n\n*TIDAK TERKIRIM ke No WA Customer*\n".$wanumber." (".$row['fullname'].")\n".$res;} else {$sendtocustomer = "\n\n*GAGAL TERKIRIM ke No WA Customer*\n".$wanumber." (".$row['fullname'].")\n";}}}
*/							
							sendwagroup("d4987114-8563-4fdf-b15c-ed328057fae2",$pesanwa."\n\n_Tes Chatfire CMS_","6281717212109-1615804565");
						}
						else
						{
							//Whatsapp Group Tidak Ada No WA Customer
							sendwagroup($siaga,$pesannowa,$auditgroup);
/*							$ch = curl_init();
							curl_setopt_array($ch, array(
								CURLOPT_URL => Yii::app()->params['whatsva']."/sendText?id_device=1&message=".urlencode($pesannowa)."&tujuan=".$auditgroup."@g.us",
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
							
							//Whatsapp Japri Tidak Ada No WA Customer
							$ch = curl_init();
							curl_setopt_array($ch, array(
								CURLOPT_URL => Yii::app()->params['whatsva']."/sendText?id_device=1&message=".urlencode($pesannowa)."&tujuan=".$nowanumber."@s.whatsapp.net",
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
							$res = curl_exec($ch);*/
						}
						
/*						$url = Yii::app()->params['ip'].'send_message';
						$data = array(
							"phone_no"=> $wanumber,
							"key"		=> Yii::app()->params['key'],
							"message"	=> $pesanwa
						);
						$data_string = json_encode($data);

						$ch = curl_init($url);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_VERBOSE, 0);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
						curl_setopt($ch, CURLOPT_TIMEOUT, 360);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen($data_string))
						);
						$res=curl_exec($ch);
						if ($res != 'Success') {if ($wanumber > 0) {if ($res != '') {$sendtocustomer = "\n\n*TIDAK TERKIRIM ke No WA Customer*\n".$wanumber." (".$row['fullname'].")\n".$res;} else {$sendtocustomer = "\n\n*GAGAL TERKIRIM ke No WA Customer*\n".$wanumber." (".$row['fullname'].")\n";}}}
						//echo $data_string;
*/						
					//Telegram
						if ($telegramid > 0)
						{
							$url = Yii::app()->params['tele']."/sendMessage?chat_id=".$telegramid."&text=".urlencode($pesanwa);
							$ch = curl_init();
							$optArray = array(
								CURLOPT_URL => $url,
								CURLOPT_RETURNTRANSFER => true
							);
							curl_setopt_array($ch, $optArray);
							$result = curl_exec($ch);
						}
					}

					$url = Yii::app()->params['tele']."/sendMessage?chat_id=".$telegroupid."&text=".urlencode($pesanwa.$sendtocustomer);
					$ch = curl_init();
					$optArray = array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true
					);
					curl_setopt_array($ch, $optArray);
					$result = curl_exec($ch);
				}
				curl_close($ch);    
			}
			else
			{
				foreach($idarray as $id) {
					$sql = "select soheaderid
								from soheader
								where soheaderid = ".$id;
					if($ids == null) {
						$ids = Yii::app()->db->createCommand($sql)->queryScalar();
					}
					else
					{
						$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
					}
					//var_dump($idarray);
				}
				$getSalesOrder = "select a.soheaderid, c.fullname, a.sodate, a.sono, d.companycode, a.totalbefdisc, a.totalaftdisc, a.statusname, a.creditlimit, a.currentlimit, a.pendinganso, a.currentlimit+a.pendinganso+a.totalaftdisc as total, a.top, b.fullname as sales
											from soheader a
											join employee b on b.employeeid = a.employeeid
											join addressbook c on c.addressbookid = a.addressbookid
											join company d on d.companyid = a.companyid
											where a.soheaderid in ({$ids})
											group by soheaderid
				";

				$res = Yii::app()->db->createCommand($getSalesOrder)->queryAll();
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$pesanwa = 
					"Sales Order No.: ".$row['sono']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['sodate']))."\nCustomer ".$row['companycode'].": *".$row['fullname']."*\nSales: ".$row['sales']."\n\nDengan Rincian:\nPiutang Rp. ".Yii::app()->format->formatCurrency($row['currentlimit'])."\nPendingan SO Rp. ".Yii::app()->format->formatCurrency($row['pendinganso'])."\nSO stlh diskon Rp.".Yii::app()->format->formatCurrency($row['totalaftdisc'])."\nTotal Rp. ".Yii::app()->format->formatCurrency($row['total'])." *VS* Plafon Rp. ".Yii::app()->format->formatCurrency($row['creditlimit'])."\nUmur Piutang: ".$row['top']."\n\nTelah disetujui oleh bagian terkait dengan status *".$row['statusname']."*, silahkan _*Review*_ lalu _*Approve*_ / _*Reject*_ pada Aplikasi ERP AKA Group.\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesantele = 
					"Sales Order No.: ".$row['sono']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['sodate']))."\nCustomer ".$row['companycode'].": ".$row['fullname']."\nSales: ".$row['sales']."\n\nDengan Rincian:\nPiutang Rp. ".Yii::app()->format->formatCurrency($row['currentlimit'])."\nPendingan SO Rp. ".Yii::app()->format->formatCurrency($row['pendinganso'])."\nSO stlh diskon Rp.".Yii::app()->format->formatCurrency($row['totalaftdisc'])."\nTotal Rp. ".Yii::app()->format->formatCurrency($row['total'])." VS Plafon Rp. ".Yii::app()->format->formatCurrency($row['creditlimit'])."\nUmur Piutang: ".$row['top']."\n\nTelah disetujui oleh bagian terkait dengan status ".$row['statusname'].", silahkan Review lalu Approve / Reject pada Aplikasi ERP AKA Group.\n\nPesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)\n".
					$time;
					
					$getWaNumber = "SELECT e.useraccessid,b.groupaccessid,replace(e.wanumber,'+','') as wanumber,e.telegramid
									FROM soheader a
									JOIN wfgroup b ON b.wfbefstat=a.recordstatus AND b.workflowid=15
									JOIN groupmenuauth c ON c.groupaccessid=b.groupaccessid AND c.menuauthid=5 AND c.menuvalueid=a.companyid
									JOIN groupmenuauth c2 ON c2.groupaccessid=b.groupaccessid AND c2.menuauthid=22 AND c2.menuvalueid=(SELECT a1.plantid FROM sloc a1 JOIN sodetail b1 ON b1.slocid=a1.slocid WHERE b1.soheaderid=a.soheaderid LIMIT 1)
									JOIN usergroup d ON d.groupaccessid=c.groupaccessid
									JOIN useraccess e ON e.useraccessid=d.useraccessid AND e.recordstatus=1 AND e.useraccessid<>2 AND e.useraccessid<>106
									-- AND e.useraccessid<>3
									WHERE a.soheaderid = {$row['soheaderid']}
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
							CURLOPT_URL => Yii::app()->params['whatsva']."/sendText?id_device=1&message=".urlencode($pesanwa)."&tujuan=".$wanumber."@s.whatsapp.net",
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
        $this->SendNotifWaCustomer($this->menuname,$id);
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
			for ($i = 0; $i < count($ids);$i++)
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
	
	/*public function actionDownPDF()
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
	*/
	public function actionDownPDF() {
    parent::actionDownPDF();
    $sql = "select a.companyid, a.soheaderid,a.sono, b.fullname as customername, a.sodate, c.paymentname, e.taxcode, e.taxvalue,
			a.addressbookid, a.headernote,a.recordstatus,a.shipto,a.billto,d.fullname as salesname, a.isdisplay
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
		if($row['isdisplay'])
			$this->pdf->Image('images/DISPLAY.jpg', 0, 8, 210, 135);
      if ($row['addressbookid'] > 0) {
        $sql1        = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.lat, a.lng
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
        ' : ' . $row['customername'].'   ('.$row1['lat'].','.$row1['lng'].')',
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
        ($row['isdisplay']==1) ? ' : LANGSUNG BAYAR SAAT TERJUAL' : ' : ' . $row['paymentname']
      ));
      $sql1        = "select a.soheaderid,c.uomcode,a.qty,a.price * a.currencyrate as price,(qty * price * currencyrate) as total,(e.taxvalue * qty * price * currencyrate/ 100) as ppn,b.productname,
			d.symbol,d.i18n,a.itemnote,a.delvdate
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
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        15,
        15,
        60,
        30,
        20,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'Qty',
        'Units',
        'Description',
        'Item Note',
        'Unit Price',
        'Total',
        'Tgl Kirim'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'R',
        'C',
        'L',
        'L',
        'R',
        'R',
        'R',
        'L'
      );
      foreach ($dataReader1 as $row1) {
        $this->pdf->row(array(
          Yii::app()->format->formatNumber($row1['qty']),
          $row1['uomcode'],
          $row1['productname'],
          $row1['itemnote'],
          Yii::app()->format->formatNumber($row1['price']),
          Yii::app()->format->formatNumber($row1['total']),
          date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate']))
        ));
        $total    = $row1['total'] + $total;
        $totalqty = $row1['qty'] + $totalqty;
      }
      $this->pdf->row(array(
        Yii::app()->format->formatNumber($totalqty),
        '',
        'Total',
        '',
        Yii::app()->format->formatNumber($total)
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
      $totalbefdisc                 = Yii::app()->db->createCommand('select gettotalbefdisc('.$row['soheaderid'].')')->queryScalar();
      $hrgaftdisc                 = Yii::app()->db->createCommand('select gettotalamountdiscso('.$row['soheaderid'].')')->queryScalar();
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
        Yii::app()->format->formatNumber($totalbefdisc - $hrgaftdisc)
      ));
      $bilangan = explode(".", $hrgaftdisc);
      $this->pdf->row(array(
        'Harga Sesudah Diskon',
        Yii::app()->format->formatCurrency($hrgaftdisc) . ' (' . eja($bilangan[0]) . ')'
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
      if ($this->pdf->checkNewPage(10)){if ($row['isdisplay']) $this->pdf->Image('images/DISPLAY.jpg', 0, 8, 210, 135);}
      $this->pdf->checkNewPage(10);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->text(10, $this->pdf->gety(), 'Pembuat');
      $this->pdf->text(50, $this->pdf->gety(), 'Mengetahui');
      $this->pdf->text(10, $this->pdf->gety() + 15, '........................');
      $this->pdf->text(50, $this->pdf->gety() + 15, '........................');
    }
    $this->pdf->Output();
  }
	public function actionDownpdfcustomer() {
    parent::actionDownPDF();
    $row = Yii::app()->db->createCommand("select addressbookid,companyid from soheader where soheaderid = ".$_GET['soheaderid'])->queryRow();
    
    $sql = "select ifnull(sum(amount-payamount),0) as piutang, za.creditlimit,getpendinganso(soheaderid,z.addressbookid) as pendinganso
							from (select b.giheaderid,a.invoicedate,a.amount,d.addressbookid,c.soheaderid,
              datediff(curdate(),a.invoicedate) as umur,
							ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
							from cutarinv f
							join cutar g on g.cutarid=f.cutarid
							where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
							from invoice a
							inner join giheader b on b.giheaderid = a.giheaderid
							inner join soheader c on c.soheaderid = b.soheaderid
							inner join addressbook d on d.addressbookid = c.addressbookid
							inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
							inner join employee ff on ff.employeeid = c.employeeid
							where a.recordstatus=3 and a.invoiceno is not null and c.companyid =  '".$row['companyid']."'
							and d.addressbookid = '".$row['addressbookid']."' 
							and a.invoicedate <= curdate())z
              join addressbook za on za.addressbookid = z.addressbookid
							where amount > payamount
              and za.addressbookid = ".$row['addressbookid']."
              order by umur desc";

      $qinfo = Yii::app()->db->createCommand($sql)->queryRow();

    $sql1 = "select *, (amount-payamount) as sisa,(amount) as nilai
    from (select b.giheaderid,if(c.isdisplay=1,concat(a.invoiceno,'_D'),a.invoiceno) as invoiceno,a.invoicedate,e.paydays,a.companyid,
    date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
    datediff(curdate(),a.invoicedate) as umur,
    datediff(curdate(),date_add(a.invoicedate, INTERVAL e.paydays DAY)) as umurtempo,a.amount,ff.fullname as sales,
    ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
    from cutarinv f
    join cutar g on g.cutarid=f.cutarid
    where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= curdate()),0) as payamount
    from invoice a
    inner join giheader b on b.giheaderid = a.giheaderid
    inner join soheader c on c.soheaderid = b.soheaderid
    inner join addressbook d on d.addressbookid = c.addressbookid
    inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
    inner join employee ff on ff.employeeid = c.employeeid
    where d.fullname like '%%' and ff.fullname like '%%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = 
    ".$row['companyid']." 
    and d.addressbookid = ".$row['addressbookid']."
    and a.invoicedate <= curdate())z
    where amount > payamount 
    order by umur desc
    ";

    $dataReader = Yii::app()->db->createCommand($sql1)->queryAll();
    //foreach ($dataReader as $row) {
      $this->pdf->companyid = $row['companyid'];
    //}
    $this->pdf->title = 'Customer Info';
    $this->pdf->AddPage('P', 'A4');
    $this->pdf->AliasNbPages();
    $this->pdf->AddFont('Tahoma', '', 'tahoma.php');
    $this->pdf->SetFont('Tahoma');

    $this->pdf->setFont('Arial','B',10);
    $this->pdf->setY($this->pdf->getY());
    $this->pdf->text(10,$this->pdf->getY()+5,'Plafon : '.Yii::app()->format->formatCurrency($qinfo['creditlimit']));
    $this->pdf->text(100,$this->pdf->getY()+5,'Pendingan : '.Yii::app()->format->formatCurrency($qinfo['pendinganso']));
    $this->pdf->text(10,$this->pdf->getY()+10,'Piutang : '.Yii::app()->format->formatCurrency($qinfo['piutang']));
    $this->pdf->text(100,$this->pdf->getY()+10,'Sisa (Kurang): '.Yii::app()->format->formatCurrency($qinfo['creditlimit']-$qinfo['pendinganso']-$qinfo['piutang']));

    $this->pdf->setFont('Arial','',10);
    $this->pdf->setY($this->pdf->getY()+15);
		
      $this->pdf->SetFontSize(8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        50,
        100,
        30,
        60
      ));
      
      $total       = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 0);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        25,
        25,
        30,
        30,
        20,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'Invoice',
        'Nilai Invoice',
        'Total Dibayar',
        'Sisa',
        'Umur',
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'R',
        'C',
        'L',
        'L',
        'L'
      );
      foreach ($dataReader as $row1) {
        $this->pdf->row(array(
          $row1['invoiceno'],
          Yii::app()->format->formatNumber($row1['amount']),
          Yii::app()->format->formatNumber($row1['payamount']),
          Yii::app()->format->formatNumber($row1['amount']-$row1['payamount']),
          $row1['umur'],
        ));
        //$total    = $row1['total'] + $total;
        //$totalqty = $row1['qty'] + $totalqty;
      }
      
      
      
      $this->pdf->checkNewPage(10);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->text(10, $this->pdf->gety(), 'Pembuat');
      $this->pdf->text(50, $this->pdf->gety(), 'Mengetahui');
      $this->pdf->text(10, $this->pdf->gety() + 15, '........................');
      $this->pdf->text(50, $this->pdf->gety() + 15, '........................');
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
