<?php

class PoheaderController extends AdminController
{
	protected $menuname = 'poheader';
	public $module = 'Purchasing';
	protected $pageTitle = 'Purchase Order';
	public $wfname = 'apppo';
	protected $sqldata = "select a0.poheaderid,a0.companyid,a0.printke,a0.pono,a0.docdate,a0.purchasinggroupid,a0.addressbookid,a0.paymentmethodid,a0.taxid,a0.shipto,a0.billto,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.purchasinggroupcode as purchasinggroupcode,a3.fullname as fullname,a4.paycode as paycode,a4.paymentname,a5.taxcode as taxcode,a0.statusname
    from poheader a0 
    left join company a1 on a1.companyid = a0.companyid
    left join purchasinggroup a2 on a2.purchasinggroupid = a0.purchasinggroupid
    left join addressbook a3 on a3.addressbookid = a0.addressbookid
    left join paymentmethod a4 on a4.paymentmethodid = a0.paymentmethodid
    left join tax a5 on a5.taxid = a0.taxid
  ";
protected $sqldatapodetail = "select a0.podetailid,a0.poheaderid,a0.prmaterialid,a0.productid,a0.poqty,a0.unitofmeasureid,a0.delvdate,a0.netprice,a0.currencyid,a0.ratevalue,a0.diskon,a0.underdelvtol,a0.overdelvtol,a0.itemtext,a1.productname as productname,a2.uomcode as uomcode,a3.currencyname as currencyname 
			,a0.qtyres,(a0.poqty - a0.qtyres) as saldoqty,((a0.poqty * a0.netprice) - a0.diskon) as total
    from podetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from poheader a0 
    left join company a1 on a1.companyid = a0.companyid
    left join purchasinggroup a2 on a2.purchasinggroupid = a0.purchasinggroupid
    left join addressbook a3 on a3.addressbookid = a0.addressbookid
    left join paymentmethod a4 on a4.paymentmethodid = a0.paymentmethodid
    left join tax a5 on a5.taxid = a0.taxid
  ";
protected $sqlcountpodetail = "select count(1) 
    from podetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('apppo')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listpo').")
				and a0.recordstatus <> {$maxstat}
				and	a1.companyid in (".getUserObjectValues('company').")
and a0.poheaderid in (select a6.poheaderid from podetail a6 join prmaterial a7 on a7.prmaterialid=a6.prmaterialid where a7.prmaterialid is not null) ";
		if ((isset($_REQUEST['pono'])) && (isset($_REQUEST['headernote'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['paycode'])) && (isset($_REQUEST['taxcode'])))
		{				
			$where .=  " 
and a0.pono like '%". $_REQUEST['pono']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a3.fullname like '%". $_REQUEST['fullname']."%' 
and a4.paycode like '%". $_REQUEST['paycode']."%' 
and a5.taxcode like '%". $_REQUEST['taxcode']."%'"; 
		}
		if (isset($_REQUEST['poheaderid']))
			{
				if (($_REQUEST['poheaderid'] !== '0') && ($_REQUEST['poheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.poheaderid in (".$_REQUEST['poheaderid'].")";
					}
					else
					{
						$where .= " and a0.poheaderid in (".$_REQUEST['poheaderid'].")";
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
			'keyField'=>'poheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'poheaderid','companyid','pono','docdate','purchasinggroupid','addressbookid','paymentmethodid','taxid','shipto','billto','headernote','statusname'
				),
				'defaultOrder' => array( 
					'poheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['poheaderid']))
		{
			$this->sqlcountpodetail .= ' where a0.poheaderid = '.$_REQUEST['poheaderid'];
			$this->sqldatapodetail .= ' where a0.poheaderid = '.$_REQUEST['poheaderid'];
		}
		$countpodetail = Yii::app()->db->createCommand($this->sqlcountpodetail)->queryScalar();
$dataProviderpodetail=new CSqlDataProvider($this->sqldatapodetail,array(
					'totalItemCount'=>$countpodetail,
					'keyField'=>'podetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'podetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderpodetail'=>$dataProviderpodetail));
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into poheader (recordstatus) values (".$this->findstatusbyuser('inspo').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'poheaderid'=>$id,
      "docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inspo")
		));
	}
	public function actionCreatepodetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"poqty" =>0,
      "delvdate" =>date("Y-m-d"),
      "netprice" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),
			"currencyname" => $this->GetParameter("basecurrency"),
      "ratevalue" =>1,
      "diskon" =>0,
			"underdelvtol"=>0,
			"overdelvtol"=>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.poheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'poheaderid'=>$model['poheaderid'],
          'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'purchasinggroupid'=>$model['purchasinggroupid'],
          'addressbookid'=>$model['addressbookid'],
          'paymentmethodid'=>$model['paymentmethodid'],
          'taxid'=>$model['taxid'],
          'shipto'=>$model['shipto'],
          'billto'=>$model['billto'],
          'headernote'=>$model['headernote'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'purchasinggroupcode'=>$model['purchasinggroupcode'],
          'fullname'=>$model['fullname'],
          'paycode'=>$model['paycode'],
          'taxcode'=>$model['taxcode'],

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
	public function actionUpdatepodetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapodetail.' where podetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'podetailid'=>$model['podetailid'],
          'poheaderid'=>$model['poheaderid'],
          'prmaterialid'=>$model['prmaterialid'],
          'productid'=>$model['productid'],
          'poqty'=>$model['poqty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'delvdate'=>$model['delvdate'],
          'netprice'=>$model['netprice'],
          'currencyid'=>$model['currencyid'],
          'ratevalue'=>$model['ratevalue'],
          'diskon'=>$model['diskon'],
          'underdelvtol'=>$model['underdelvtol'],
          'overdelvtol'=>$model['overdelvtol'],
          'itemtext'=>$model['itemtext'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'currencyname'=>$model['currencyname'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionGenerateaddress()
	{
		$product = null;
		if(isset($_REQUEST['id']))
	  {
			$product = Yii::app()->db->createCommand()
				->select('t.*')
				->from('company t')
				->where('t.companyid = '.$_REQUEST['id'])
				->queryRow();
		}
		if (Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
				'shipto'=> $product['address'],
				'billto'=> $product['billto'],
				));
			Yii::app()->end();
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('addressbookid','string','emptyaddressbookid'),
      array('paymentmethodid','string','emptypaymentmethodid'),
      array('taxid','string','emptytaxid'),
      array('headernote','string','emptyheadernote'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['poheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdatePOHeader (:poheaderid
,:purchasinggroupid
,:docdate
,:addressbookid
,:headernote
,:paymentmethodid
,:shipto
,:billto
,:companyid
,:taxid
,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':poheaderid',$_POST['poheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':purchasinggroupid',(($_POST['purchasinggroupid']!=='')?$_POST['purchasinggroupid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':paymentmethodid',(($_POST['paymentmethodid']!=='')?$_POST['paymentmethodid']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxid',(($_POST['taxid']!=='')?$_POST['taxid']:null),PDO::PARAM_STR);
        $command->bindvalue(':shipto',(($_POST['shipto']!=='')?$_POST['shipto']:null),PDO::PARAM_STR);
        $command->bindvalue(':billto',(($_POST['billto']!=='')?$_POST['billto']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
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
	public function actionSavepodetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('prmaterialid','string','emptyprmaterialid'),
      array('productid','string','emptyproductid'),
      array('poqty','string','emptypoqty'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('netprice','string','emptynetprice'),
      array('currencyid','string','emptycurrencyid'),
      array('ratevalue','string','emptyratevalue'),
      array('diskon','string','emptydiskon'),
      array('underdelvtol','string','emptyunderdelvtol'),
      array('overdelvtol','string','emptyoverdelvtol'),
    ));
		if ($error == false)
		{
			$id = $_POST['podetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update podetail 
			      set poheaderid = :poheaderid,prmaterialid = :prmaterialid,productid = :productid,poqty = :poqty,unitofmeasureid = :unitofmeasureid,delvdate = :delvdate,netprice = :netprice,currencyid = :currencyid,ratevalue = :ratevalue,diskon = :diskon,underdelvtol = :underdelvtol,overdelvtol = :overdelvtol,itemtext = :itemtext 
			      where podetailid = :podetailid';
				}
				else
				{
					$sql = 'insert into podetail (poheaderid,prmaterialid,productid,poqty,unitofmeasureid,delvdate,netprice,currencyid,ratevalue,diskon,underdelvtol,overdelvtol,itemtext) 
			      values (:poheaderid,:prmaterialid,:productid,:poqty,:unitofmeasureid,:delvdate,:netprice,:currencyid,:ratevalue,:diskon,:underdelvtol,:overdelvtol,:itemtext)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':podetailid',$_POST['podetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':poheaderid',(($_POST['poheaderid']!=='')?$_POST['poheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':prmaterialid',(($_POST['prmaterialid']!=='')?$_POST['prmaterialid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':poqty',(($_POST['poqty']!=='')?$_POST['poqty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':delvdate',(($_POST['delvdate']!=='')?$_POST['delvdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':netprice',(($_POST['netprice']!=='')?$_POST['netprice']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':ratevalue',(($_POST['ratevalue']!=='')?$_POST['ratevalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':diskon',(($_POST['diskon']!=='')?$_POST['diskon']:null),PDO::PARAM_STR);
        $command->bindvalue(':underdelvtol',(($_POST['underdelvtol']!=='')?$_POST['underdelvtol']:null),PDO::PARAM_STR);
        $command->bindvalue(':overdelvtol',(($_POST['overdelvtol']!=='')?$_POST['overdelvtol']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemtext',(($_POST['itemtext']!=='')?$_POST['itemtext']:null),PDO::PARAM_STR);
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
	private function SendNotifWa($menuname,$idarray) {
    // getrecordstatus
		$ids = null;
		if(is_array($idarray)==TRUE) {
			foreach($idarray as $id) {
				$sql = "select poheaderid
							from poheader
							where recordstatus = getwfmaxstatbywfname('apppo') and poheaderid = ".$id;
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
					$sql = "select poheaderid
								from poheader
								where poheaderid = ".$id;
					if($ids == null) {
						$ids = Yii::app()->db->createCommand($sql)->queryScalar();
					}
					else
					{
						$ids .= ','.Yii::app()->db->createCommand($sql)->queryScalar();
					}
					//var_dump($idarray);
				}
				$getSalesOrder = "select a.poheaderid,c.fullname,a.docdate AS podate,d.companycode,(SELECT SUM((a1.poqty * a1.netprice * a1.ratevalue) * ((100+b.taxvalue)/100)) FROM podetail a1 WHERE a1.poheaderid=a.poheaderid) AS povalue,e.paycode,a.statusname,
				ifnull((SELECT SUM((a1.poqty * a1.netprice * a1.ratevalue) * ((100+b.taxvalue)/100)) FROM podetail a1 WHERE a1.poheaderid=a.poheaderid),0) AS povalue,
				ifnull((select SUM(amount-payamount)
				from (select e3.paydays,
				datediff(now(),a3.invoicedate) as umur,a3.amount, 
				ifnull((select sum(payamount) from cbapinv j3
				left join cashbankout k3 on k3.cashbankoutid=j3.cashbankoutid
				where k3.recordstatus=3 and j3.invoiceapid=a3.invoiceapid
				and k3.docdate <= now()
				group by invoiceapid),0) as payamount,a3.addressbookid
				from invoiceap a3
				left join grheader b3 on b3.grheaderid = a3.grheaderid
				inner join poheader c3 on c3.poheaderid = a3.poheaderid
				inner join addressbook d3 on d3.addressbookid = c3.addressbookid
				inner join paymentmethod e3 on e3.paymentmethodid = c3.paymentmethodid
				where a3.recordstatus=3 and a3.invoiceno is not null			
				and a3.receiptdate <= now()) z
				where z.amount > z.payamount and z.addressbookid = a.addressbookid),0) AS hutang,
				ifnull((select SUM(amount-payamount)
				from (select e3.paydays,
				datediff(now(),a3.invoicedate) as umur,a3.amount, 
				ifnull((select sum(payamount) from cbapinv j3
				left join cashbankout k3 on k3.cashbankoutid=j3.cashbankoutid
				where k3.recordstatus=3 and j3.invoiceapid=a3.invoiceapid
				and k3.docdate <= now()
				group by invoiceapid),0) as payamount,a3.addressbookid
				from invoiceap a3
				left join grheader b3 on b3.grheaderid = a3.grheaderid
				inner join poheader c3 on c3.poheaderid = a3.poheaderid
				inner join addressbook d3 on d3.addressbookid = c3.addressbookid
				inner join paymentmethod e3 on e3.paymentmethodid = c3.paymentmethodid
				where a3.recordstatus=3 and a3.invoiceno is not null			
				and a3.receiptdate <= now()) z
				where z.amount > z.payamount and z.addressbookid = a.addressbookid and umur >= paydays),0) AS hutangjtt
								from poheader a
								join tax b on b.taxid = a.taxid
								join addressbook c on c.addressbookid = a.addressbookid
								join company d on d.companyid = a.companyid
								JOIN paymentmethod e ON e.paymentmethodid=a.paymentmethodid
								where a.poheaderid IN ({$ids})
								group by poheaderid
				";

				$res = Yii::app()->db->createCommand($getSalesOrder)->queryAll();
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$pesanwa = 
					"ID Purchase Order ".$row['companycode'].": ".$row['poheaderid']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['podate']))."\nSupplier : *".$row['fullname']."\n\nTotal PO Rp. ".Yii::app()->format->formatCurrency($row['povalue'])."\nTotal Hutang Rp. ".Yii::app()->format->formatCurrency($row['hutang'])."\nHutang JTT Rp. ".Yii::app()->format->formatCurrency($row['hutangjtt'])."\n\nTelah disetujui oleh bagian terkait dengan status *".$row['statusname']."*, silahkan _*Review*_ lalu _*Approve*_ / _*Reject*_ pada Aplikasi ERP AKA Group.\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".
					$time;
					
					$pesantele = 
					"ID Purchase Order ".$row['companycode'].": ".$row['poheaderid']."\nTanggal: ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['podate']))."\nSupplier : ".$row['fullname']."\n\nTotal PO Rp. ".Yii::app()->format->formatCurrency($row['povalue'])."\nTotal Hutang Rp. ".Yii::app()->format->formatCurrency($row['hutang'])."\nHutang JTT Rp. ".Yii::app()->format->formatCurrency($row['hutangjtt'])."\n\nTelah disetujui oleh bagian terkait dengan status ".$row['statusname'].", silahkan Review lalu Approve / Reject pada Aplikasi ERP AKA Group.\n\nPesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)\n".
					$time;
					
					$getWaNumber = "SELECT e.useraccessid,b.groupaccessid,replace(e.wanumber,'+','') as wanumber,e.telegramid
									FROM poheader a
									JOIN wfgroup b ON b.wfbefstat=a.recordstatus AND b.workflowid=1
									JOIN groupmenuauth c ON c.groupaccessid=b.groupaccessid AND c.menuauthid=5 AND c.menuvalueid=a.companyid
									JOIN usergroup d ON d.groupaccessid=c.groupaccessid
									JOIN useraccess e ON e.useraccessid=d.useraccessid AND e.recordstatus=1 AND e.useraccessid<>2 AND e.useraccessid<>106
									-- AND e.useraccessid<>3
									WHERE a.poheaderid = {$row['poheaderid']}
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
				$sql = 'call Approvepo(:vid,:vcreatedby)';
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
				$sql = 'call DeletePO(:vid,:vcreatedby)';
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
				$sql = "delete from poheader where poheaderid = ".$id[$i];
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
	public function actionPurgepodetail()
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
				$sql = "delete from podetail where podetailid = ".$id[$i];
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
		$sql = "select a.companyid,(select companyname from company zz where zz.companyid = a.companyid) as companyname,
		b.fullname, a.pono, a.docdate,b.addressbookid,a.poheaderid,c.paymentname,a.headernote,a.printke,a.poheaderid,
			ifnull(a.printke,0) as printke,a.recordstatus,a.shipto,a.billto
      from poheader a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid
      left join tax d on d.taxid = a.taxid ";
			if ($_GET['poheaderid'] !== '') {
					$sql = $sql . "where a.poheaderid in (".$_GET['poheaderid'].")";
			}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
    {
			$this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('poheader');
	  $this->pdf->AddPage('P','Letter');
		$this->pdf->AliasNbPages();
	  $this->pdf->isprint=true;

    foreach($dataReader as $row)
    {
			$sql1 = "update poheader set printke = ifnull(printke,0) + 1
				where poheaderid = ".$row['poheaderid'];
			$command1=Yii::app()->db->createCommand($sql1);
			$this->pdf->printke = $row['printke'];
			$command1->execute();
      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.faxno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'].
        " order by addressid ".
        " limit 1";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$contact = '';
			$addressname = '';
			$phoneno = '';
			$faxno = '';
      foreach($dataReader1 as $row1)
      {
				$addressname = $row1['addressname'];
				$phoneno = $row1['phoneno'];
				$faxno = $row1['faxno'];
			}
			
			$sql2 = "select ifnull(a.addresscontactname,'') as addresscontactname, ifnull(a.phoneno,'') as phoneno, ifnull(a.mobilephone,'') as mobilephone
					from addresscontact a
					where addressbookid = ".$row['addressbookid'].
					" order by addresscontactid ".
					" limit 1";
			$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
			foreach($dataReader2 as $row2)
			{
				$contact = $row2['addresscontactname'];
			}
			$this->pdf->setFont('Arial','',10);
			$this->pdf->Rect(10,10,202,30);        
			$this->pdf->text(15,15,'Supplier');$this->pdf->text(40,15,': '.$row['fullname']);
			$this->pdf->text(15,20,'Attention');$this->pdf->text(40,20,': '.$contact);
			$this->pdf->text(15,25,'Address');$this->pdf->text(40,25,': '.$addressname);
			$this->pdf->text(15,30,'Phone');$this->pdf->text(40,30,': '.$phoneno);
			$this->pdf->text(15,35,'Fax');$this->pdf->text(40,35,': '.$faxno);
			$this->pdf->text(120,15,'PO No ');$this->pdf->text(150,15,': '.$row['pono']);
			$this->pdf->text(120,20,'PO Date ');$this->pdf->text(150,20,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));

      $sql1 = "select *,(jumlah * (taxvalue / 100)) as ppn, jumlah + (jumlah * (taxvalue / 100)) as total
        from (select a.poheaderid,c.uomcode,a.poqty,a.delvdate,a.netprice,(a.netprice*a.poqty*a.ratevalue) as jumlah,b.productname,
        d.symbol,d.i18n,e.taxvalue,a.itemtext
        from podetail a
				left join poheader f on f.poheaderid = a.poheaderid
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = f.taxid
        where a.poheaderid = ".$row['poheaderid'].") z";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $total = 0;$jumlah = 0;$ppn = 0;
      $this->pdf->sety($this->pdf->gety()+30);
			$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,10,45,22,25,22,25,18,20));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Item', 'Unit Price','Jumlah','PPN','Total','Delivery','Remarks');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('R','C','L','R','R','R','R','R','R','L');
			$this->pdf->setFont('Arial','',8);
	  $symbol = '';
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array(
			Yii::app()->format->formatNumber($row1['poqty']),
			$row1['uomcode'],
			iconv("UTF-8", "ISO-8859-1", $row1['productname']),
            Yii::app()->format->formatCurrency($row1['netprice'], iconv("UTF-8", "ISO-8859-1", $row1['symbol'])),
			           Yii::app()->format->formatCurrency($row1['jumlah'], $row1['symbol']),
			           Yii::app()->format->formatCurrency($row1['ppn'], $row1['symbol']),
			           Yii::app()->format->formatCurrency($row1['total'], $row1['symbol']),
			date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate'])),
			$row1['itemtext']));
        $jumlah = $row1['jumlah'] + $jumlah;
        $ppn = $row1['ppn'] + $ppn;
        $total = $row1['total'] + $total;
$symbol = $row1['symbol'];
      }
	  $this->pdf->row(array('','','','Grand Total',
            Yii::app()->format->formatCurrency($jumlah,$symbol),
            Yii::app()->format->formatCurrency($ppn,$symbol),
            Yii::app()->format->formatCurrency($total,$symbol),'',''));
	  $this->pdf->title='';
	  $this->pdf->checknewpage(100);
		$this->pdf->sety($this->pdf->gety()+5);
	  $this->pdf->setFont('Arial','BU',10);
	  $this->pdf->text(10,$this->pdf->gety()+5,'TERM OF CONDITIONS');

		$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
	  $this->pdf->colheader = array('Item','Description');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L');
			 $this->pdf->setFont('Arial','',8);
	  
	  $this->pdf->row(array(
		'Payment Term',
		$row['paymentname']
	  ));
			  $this->pdf->row(array(
		'Kirim ke',
		$row['shipto']
	  ));
			  $this->pdf->row(array(
		'Tagih ke',
		$row['billto']
	  ));
	  $this->pdf->row(array(
		'Keterangan',
		$row['headernote']
	  ));
	  
	 $this->pdf->setFont('Arial','',8);
	 $this->pdf->CheckPageBreak(60);
	  $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->text(10,$this->pdf->gety()+5,'Thanking you and assuring our best attention we remain.');
      $this->pdf->text(10,$this->pdf->gety()+10,'Sincerrely Yours');
      $this->pdf->text(10,$this->pdf->gety()+15,$row['companyname']);$this->pdf->text(135,$this->pdf->gety()+15,'Confirmed and Accepted by Supplier');
	  
      $this->pdf->text(10,$this->pdf->gety()+35,'');
      $this->pdf->text(10,$this->pdf->gety()+36,'____________________');$this->pdf->text(135,$this->pdf->gety()+36,'__________________________');
	  $this->pdf->setFont('Arial','',8);
      $this->pdf->text(10,$this->pdf->gety()+40,'');

	  $this->pdf->setFont('Arial','BU',7);
	  $this->pdf->text(10,$this->pdf->gety()+55,'#Note: Mohon tidak memberikan gift atau uang kepada staff kami#');
		$this->pdf->text(10,$this->pdf->gety()+60,'#Print ke: '.$row['printke']);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('poheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('pono'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('purchasinggroupcode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('paycode'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('shipto'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('billto'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['poheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['pono'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['purchasinggroupcode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['paycode'])
->setCellValueByColumnAndRow(7, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(8, $i+1, $row1['shipto'])
->setCellValueByColumnAndRow(9, $i+1, $row1['billto'])
->setCellValueByColumnAndRow(10, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(11, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
