<?php

class PodirectController extends AdminController
{
	protected $menuname = 'podirect';
	public $module = 'Purchasing';
	protected $pageTitle = 'PO Trading';
	public $wfname = 'apppo';
	protected $sqldata = "select distinct t.*,a.description,b.fullname,c.paycode,d.companyname,e.taxcode
            from `poheader` `t`
            left join `purchasinggroup` `a` on a.purchasinggroupid = t.purchasinggroupid
            left join `addressbook` `b` on b.addressbookid = t.addressbookid
            left join `paymentmethod` `c` on c.paymentmethodid = t.paymentmethodid
            left join `company` `d` on d.companyid = t.companyid
            left join `tax` `e` on e.taxid = t.taxid
            left join `podetail` `f` on f.poheaderid = t.poheaderid
  ";
protected $sqldatapodetail = "select t.*,a.productname,b.uomcode,c.currencyname,c.symbol,
t.poqty - t.qtyres as saldoqty, t.poqty*t.netprice as total, d.sloccode
    from podetail t
    left join product a on a.productid = t.productid
    left join unitofmeasure b on b.unitofmeasureid = t.unitofmeasureid
    left join currency c on c.currencyid = t.currencyid
    left join sloc d on d.slocid = t.slocid
  ";
  protected $sqlcount = "select count(distinct t.poheaderid)
    from `poheader` `t`
    left join `purchasinggroup` `a` on a.purchasinggroupid = t.purchasinggroupid
    left join `addressbook` `b` on b.addressbookid = t.addressbookid
    left join `paymentmethod` `c` on c.paymentmethodid = t.paymentmethodid
    left join `company` `d` on d.companyid = t.companyid
    left join `tax` `e` on e.taxid = t.taxid
    left join `podetail` `f` on f.poheaderid = t.poheaderid
  ";
protected $sqlcountpodetail = "select count(1) 
    from podetail t
    left join product a on a.productid = t.productid
    left join unitofmeasure b on b.unitofmeasureid = t.unitofmeasureid
    left join currency c on c.currencyid = t.currencyid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('apppo')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where f.prmaterialid is null
					and t.recordstatus < {$maxstat}
					and t.recordstatus in (".getUserRecordStatus('listpo').") and 
						t.companyid in (".getUserObjectValues('company').")";
        
		if ((isset($_REQUEST['pono'])) && (isset($_REQUEST['headernote'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['fullname'])))
		{				
			$where .= " and (
                            (coalesce(pono,'') like '%".$_REQUEST['pono']."%') and 
                            (coalesce(b.fullname,'') like '%".$_REQUEST['fullname']."%') and 
                            (coalesce(t.headernote,'') like '%".$_REQUEST['headernote']."%') and 
                            (coalesce(d.companyname,'') like '%".$_REQUEST['companyname']."%'))"; 
		}
		if (isset($_REQUEST['poheaderid']))
			{
				if (($_REQUEST['poheaderid'] !== '0') && ($_REQUEST['poheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where t.poheaderid in (".$_REQUEST['poheaderid'].")";
					}
					else
					{
						$where .= " and t.poheaderid in (".$_REQUEST['poheaderid'].")";
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
					 'poheaderid','companyid','pono','docdate','addressbookid','paymentmethodid','shipto','billto','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'poheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['poheaderid']))
		{
			$this->sqlcountpodetail .= ' where t.poheaderid = '.$_REQUEST['poheaderid'];
			$this->sqldatapodetail .= ' where t.poheaderid = '.$_REQUEST['poheaderid'];
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
    public function actionGenerateproduct()
    {
        if (isset($_POST['productid']))
		{
			$cmd = Yii::app()->db->createCommand()
				->select('t.unitofissue,t.slocid,a.sloccode,d.uomcode')
				->from('productplant t')
				->join('sloc a','a.slocid = t.slocid')
				->join('plant b','b.plantid = a.plantid')
				->join('company c','c.companyid = b.companyid')
                ->join('unitofmeasure d','d.unitofmeasureid = t.unitofissue')
				->where("productid = ".$_POST['productid']." 
									and t.recordstatus = 1
									and t.slocid in (".getUserObjectWfValues('sloc','appso').")")
				->limit(1)
				->queryRow();
			$uomid = $cmd['unitofissue'];
			$uomcode = $cmd['uomcode'];
			$slocid = $cmd['slocid'];
			$sloccode = $cmd['sloccode'];
            
            echo CJSON::encode(array(
				'status'=>'success',
				'uomid'=> $uomid,
				'slocid'=>$slocid,
				'sloccode'=>$sloccode,
				'uomcode'=>$uomcode,
				));
		}
		else
		{
          $this->GetMessage('error','chooseone',1);
		}
    }
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into poheader (recordstatus) values (".$this->findstatusbyuser('inspo').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
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
      "currencyid" => $this->GetParameter("basecurrencyid"), "currencyname" => $this->GetParameter("basecurrency"),
      "ratevalue" =>0,
      "diskon" =>0,
      "qtyres" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.poheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'poheaderid'=>$model['poheaderid'],
          'companyid'=>$model['companyid'],
          'pono'=>$model['pono'],
          'docdate'=>$model['docdate'],
          'purchasinggroupid'=>$model['purchasinggroupid'],
          'addressbookid'=>$model['addressbookid'],
          'paymentmethodid'=>$model['paymentmethodid'],
          'paycode'=>$model['paycode'],
          'taxid'=>$model['taxid'],
          'payamount'=>$model['payamount'],
          'shipto'=>$model['shipto'],
          'billto'=>$model['billto'],
          'headernote'=>$model['headernote'],
          'companyname'=>$model['companyname'],
          'fullname'=>$model['fullname'],
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
			$data = Yii::app()->db->createCommand($this->sqldatapodetail.' where podetailid = '.$id)->queryRow();
			if ($data !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'podetailid' => $data['podetailid'],
                    'prmaterialid' => $data['prmaterialid'],
                    'productid' => $data['productid'],
                    'productname' => $data['productname'],
                    'poqty' => $data['poqty'],
                    'saldoqty' => $data['saldoqty'],
                    'slocid' => $data['slocid'],
                    'sloccode' => $data['sloccode'],
                    'unitofmeasureid' => $data['unitofmeasureid'],
                    'uomcode' => $data['uomcode'],
                    'ratevalue' => $data['ratevalue'],
                    'currencyid' => $data['currencyid'],
                    'currencyname' => $data['currencyname'],
                    'overdelvtol' => $data['overdelvtol'],
                    'qtyres' => $data['qtyres'],
                    'underdelvtol' => $data['underdelvtol'],
                    'diskon' => $data['diskon'],
                    'delvdate' => $data['delvdate'],
                    'netprice' => $data['netprice'],
                    'total' => Yii::app()->format->formatCurrency($data['total']),
                    'itemtext' => $data['itemtext']

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
            array('addressbookid','string','emptyaddressbookid'),
            array('paymentmethodid','string','emptypaymentmethodid'),
            array('taxid','string','emptytaxid'),
            array('headernote','string','emptyheadernote'),
    ));
		if ($error == false)
		{
			$id = $_POST['poheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatepoheader(:vid,:vpurchasinggroupid,:vdocdate,:vaddressbookid,:vheadernote,:vpaymentmethodid,:vshipto,:vbillto,:vcompanyid,:vtaxid,:vcreatedby)';
                
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['poheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':vcompanyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpurchasinggroupid',(($_POST['purchasinggroupid']!=='')?$_POST['purchasinggroupid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vpaymentmethodid',(($_POST['paymentmethodid']!=='')?$_POST['paymentmethodid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtaxid',(($_POST['taxid']!=='')?$_POST['taxid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vshipto',(($_POST['shipto']!=='')?$_POST['shipto']:null),PDO::PARAM_STR);
                $command->bindvalue(':vbillto',(($_POST['billto']!=='')?$_POST['billto']:null),PDO::PARAM_STR);
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
	public function actionSavepodetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('poqty','string','emptypoqty'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('slocid','string','emptyslocid'),
      array('netprice','string','emptynetprice'),
      array('ratevalue','string','emptyratevalue'),
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
					$sql = 'call Updatepodetail(:vid,:vpoheaderid,:vproductid,:vpoqty,:vunitofmeasureid,:vdelvdate,:vnetprice,:vcurrencyid,:vslocid,:vitemtext,:vprdetailid,:vunderdelvtol,:voverdelvtol,:vratevalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertpodetail(:vpoheaderid,:vproductid,:vpoqty,:vunitofmeasureid,:vdelvdate,:vnetprice,:vcurrencyid,:vslocid,:vitemtext,:vprdetailid,:vunderdelvtol,:voverdelvtol,:vratevalue,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['podetailid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':vpoheaderid', $_POST['poheaderid'], PDO::PARAM_STR);
                $command->bindvalue(':vprdetailid', null, PDO::PARAM_STR);
                $command->bindvalue(':vproductid', $_POST['productid'], PDO::PARAM_STR);
                $command->bindvalue(':vpoqty', $_POST['poqty'], PDO::PARAM_STR);
                $command->bindvalue(':vunitofmeasureid', $_POST['unitofmeasureid'],PDO::PARAM_STR);
                $command->bindvalue(':vdelvdate', $_POST['delvdate'], PDO::PARAM_STR);
                $command->bindvalue(':vnetprice', $_POST['netprice'], PDO::PARAM_STR);
                $command->bindvalue(':vcurrencyid', $_POST['currencyid'], PDO::PARAM_STR);
                $command->bindvalue(':vratevalue', $_POST['ratevalue'], PDO::PARAM_STR);
                $command->bindvalue(':vslocid', $_POST['slocid'], PDO::PARAM_STR);
                $command->bindvalue(':vunderdelvtol', $_POST['underdelvtol'], PDO::PARAM_STR);
                $command->bindvalue(':voverdelvtol', $_POST['overdelvtol'], PDO::PARAM_STR);
                $command->bindvalue(':vitemtext', $_POST['itemtext'], PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
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
						if ($row1['useraccessid'] == 3){$ui=" - eui ".$row1['groupaccessid'];}else{$ui="";}
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
				$sql = 'call ApprovePODirect(:vid,:vcreatedby)';
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
    /*
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
    */
    public function actionPurgepodetail()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Purgepodetail(:vid,:vcreatedby)';
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
	public function actionDownPDF() {
    parent::actionDownPDF();
    $sql = "select a.companyid,(select companyname from company zz where zz.companyid = a.companyid) as companyname,
		b.fullname, a.pono, a.docdate,b.addressbookid,a.poheaderid,c.paymentname,a.headernote,a.printke,a.poheaderid,
			ifnull(a.printke,0) as printke,a.recordstatus,a.shipto,a.billto
      from poheader a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid ";
    if ($_GET['poheaderid'] !== '') {
      $sql = $sql . "where a.poheaderid in (" . $_GET['poheaderid'] . ")";
    }
    $connection    = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $row['companyid'];
    }
    $this->pdf->title = GetCatalog('poheader');
    $this->pdf->AddPage('P', 'Letter');
    $this->pdf->AliasNbPages();
    $this->pdf->isprint = true;
    foreach ($dataReader as $row) {
      $sql1               = "update poheader set printke = ifnull(printke,0) + 1
				where poheaderid = " . $row['poheaderid'];
      $command1           = $connection->createCommand($sql1);
      $this->pdf->printke = $row['printke'];
      $command1->execute();
      $sql1        = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.faxno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = " . $row['addressbookid'] . " order by addressid " . " limit 1";
      $command1    = $connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $contact     = '';
      $addressname = '';
      $phoneno     = '';
      $faxno       = '';
      foreach ($dataReader1 as $row1) {
        $addressname = $row1['addressname'];
        $phoneno     = $row1['phoneno'];
        $faxno       = $row1['faxno'];
      }
      $sql2        = "select ifnull(a.addresscontactname,'') as addresscontactname, ifnull(a.phoneno,'') as phoneno, ifnull(a.mobilephone,'') as mobilephone
					from addresscontact a
					where addressbookid = " . $row['addressbookid'] . " order by addresscontactid " . " limit 1";
      $command2    = $connection->createCommand($sql2);
      $dataReader2 = $command2->queryAll();
      foreach ($dataReader2 as $row2) {
        $contact = $row2['addresscontactname'];
      }
      $this->pdf->setFont('Arial', '', 10);
      $this->pdf->Rect(10, 10, 202, 30);
      $this->pdf->text(15, 15, 'Supplier');
      $this->pdf->text(40, 15, ': ' . $row['fullname']);
      $this->pdf->text(15, 20, 'Attention');
      $this->pdf->text(40, 20, ': ' . $contact);
      $this->pdf->text(15, 25, 'Address');
      $this->pdf->text(40, 25, ': ' . $addressname);
      $this->pdf->text(15, 30, 'Phone');
      $this->pdf->text(40, 30, ': ' . $phoneno);
      $this->pdf->text(15, 35, 'Fax');
      $this->pdf->text(40, 35, ': ' . $faxno);
      $this->pdf->text(120, 15, 'PO No ');
      $this->pdf->text(150, 15, ': ' . $row['pono']);
      $this->pdf->text(120, 20, 'PO Date ');
      $this->pdf->text(150, 20, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $sql1        = "select *,(jumlah * (taxvalue / 100)) as ppn, jumlah + (jumlah * (taxvalue / 100)) as total
        from (select a.poheaderid,c.uomcode,a.poqty,a.delvdate,a.netprice,(a.netprice*a.poqty*a.ratevalue) as jumlah,b.productname,
        d.symbol,d.i18n,e.taxvalue,a.itemtext
        from podetail a
				left join poheader f on f.poheaderid = a.poheaderid
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = f.taxid
        where a.poheaderid = ".$row['poheaderid'].") z";
      $command1    = $connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total = 0;$jumlah = 0;$ppn = 0;
      $this->pdf->sety($this->pdf->gety() + 30);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,10,45,22,25,22,25,18,20));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	    $this->pdf->colheader = array('Qty','Units','Item', 'Unit Price','Jumlah','PPN','Total','Delivery','Remarks');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('R','C','L','R','R','R','R','R','R','L');
			$this->pdf->setFont('Arial','',8);
      $symbol = '';
      foreach ($dataReader1 as $row1) {
        $this->pdf->row(array(
          Yii::app()->format->formatCurrency($row1['poqty']),
          $row1['uomcode'],
          iconv("UTF-8", "ISO-8859-1", $row1['productname']),
          Yii::app()->format->formatCurrency($row1['netprice'], iconv("UTF-8", "ISO-8859-1", $row1['symbol'])),
			           Yii::app()->format->formatCurrency($row1['jumlah'], $row1['symbol']),
			           Yii::app()->format->formatCurrency($row1['ppn'], $row1['symbol']),
			           Yii::app()->format->formatCurrency($row1['total'], $row1['symbol']),
          date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate'])),
          $row1['itemtext']
        ));
        $jumlah = $row1['jumlah'] + $jumlah;
        $ppn = $row1['ppn'] + $ppn;
        $total = $row1['total'] + $total;
        $symbol = $row1['symbol'];
      }
      $this->pdf->row(array(
        '',
        '',
        '',
        'Grand Total',
        Yii::app()->format->formatCurrency($jumlah,$symbol),
        Yii::app()->format->formatCurrency($ppn,$symbol),
        Yii::app()->format->formatCurrency($total,$symbol),
        '',
        ''
      ));
      $this->pdf->title = '';
      $this->pdf->checknewpage(100);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->setFont('Arial', 'BU', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'TERM OF CONDITIONS');
      $this->pdf->sety($this->pdf->gety() + 10);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        50,
        140
      ));
      $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array(
        'none',
        'none'
      ));
      $this->pdf->colheader = array(
        'Item',
        'Description'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
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
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->CheckPageBreak(60);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Thanking you and assuring our best attention we remain.');
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Sincerrely Yours');
      $this->pdf->text(10, $this->pdf->gety() + 15, $row['companyname']);
      $this->pdf->text(135, $this->pdf->gety() + 15, 'Confirmed and Accepted by Supplier');
      $this->pdf->text(10, $this->pdf->gety() + 35, '');
      $this->pdf->text(10, $this->pdf->gety() + 36, '____________________');
      $this->pdf->text(135, $this->pdf->gety() + 36, '__________________________');
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->text(10, $this->pdf->gety() + 40, '');
      $this->pdf->setFont('Arial', 'BU', 7);
      $this->pdf->text(10, $this->pdf->gety() + 55, '#Note: Mohon tidak memberikan gift atau uang kepada staff kami#');
      $this->pdf->text(10, $this->pdf->gety() + 60, '#Print ke: ' . $row['printke']);
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
->setCellValueByColumnAndRow(4,4,$this->getCatalog('purchasinggroupid'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('paymentmethodid'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('payamount'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('shipto'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('billto'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('printke'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['poheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['pono'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['purchasinggroupid'])
->setCellValueByColumnAndRow(5, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['paymentmethodid'])
->setCellValueByColumnAndRow(7, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(8, $i+1, $row1['payamount'])
->setCellValueByColumnAndRow(9, $i+1, $row1['shipto'])
->setCellValueByColumnAndRow(10, $i+1, $row1['billto'])
->setCellValueByColumnAndRow(11, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(12, $i+1, $row1['printke'])
->setCellValueByColumnAndRow(17, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}