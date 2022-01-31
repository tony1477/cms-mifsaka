<?php

class CutarController extends AdminController
{
	protected $menuname = 'cutar';
	public $module = 'Accounting';
	protected $pageTitle = 'Pelunasan Piutang';
	public $wfname = 'appcutar';
	protected $sqldata = "select a0.cutarid,a0.docdate,a0.companyid,a0.cutarno,a0.ttntid,a0.cbinid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.docno as docno,a3.cbinno as cbinno,a0.statusname  
    from cutar a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
    left join cbin a3 on a3.cbinid = a0.cbinid
  ";
protected $sqldatacutarinv = "select a0.cutarinvid,a0.cutarid,a0.invoiceid,a0.saldoinvoice,a0.invoicedate,a0.cashamount,a0.bankamount,a0.discamount,a0.returnamount,a0.obamount,a0.currencyid,a0.currencyrate,a0.description,a1.invoiceno as invoiceno,a2.invoicedate as invoicedate,a3.currencyname as currencyname 
    from cutarinv a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
    left join invoice a2 on a2.invoiceid = a0.invoiceid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from cutar a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
    left join cbin a3 on a3.cbinid = a0.cbinid
  ";
protected $sqlcountcutarinv = "select count(1) 
    from cutarinv a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
    left join invoice a2 on a2.invoiceid = a0.invoiceid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appcutar')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listcutar').") 
			and a0.recordstatus < {$maxstat}
			and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['cutarno'])) && (isset($_REQUEST['headernote'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['docno'])) && (isset($_REQUEST['cbinno'])))
		{				
			$where .=  " 
and a0.cutarno like '%". $_REQUEST['cutarno']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.docno like '%". $_REQUEST['docno']."%' 
and a3.cbinno like '%". $_REQUEST['cbinno']."%'"; 
		}
		if (isset($_REQUEST['cutarid']))
			{
				if (($_REQUEST['cutarid'] !== '0') && ($_REQUEST['cutarid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.cutarid in (".$_REQUEST['cutarid'].")";
					}
					else
					{
						$where .= " and a0.cutarid in (".$_REQUEST['cutarid'].")";
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
			'keyField'=>'cutarid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cutarid','docdate','companyid','cutarno','ttntid','cbinid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'cutarid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['cutarid']))
		{
			$this->where .= ' where a0.cutarid = '.$_REQUEST['cutarid'];
			$this->where .= ' where a0.cutarid = '.$_REQUEST['cutarid'];
		}
		$countcutarinv = Yii::app()->db->createCommand($this->sqlcountcutarinv)->queryScalar();
$dataProvidercutarinv=new CSqlDataProvider($this->sqldatacutarinv,array(
					'totalItemCount'=>$countcutarinv,
					'keyField'=>'cutarinvid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'cutarinvid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercutarinv'=>$dataProvidercutarinv));
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into cutar (recordstatus) values (".findstatusbyuser('inscutar').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'cutarid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>findstatusbyuser("inscutar")
		));
	}
  public function actionCreatecutarinv()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"saldoinvoice" =>0,
      "invoicedate" =>date("Y-m-d"),
      "cashamount" =>0,
      "bankamount" =>0,
      "discamount" =>0,
      "returnamount" =>0,
      "obamount" =>0,
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.cutarid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'docdate'=>$model['docdate'],
          'companyid'=>$model['companyid'],
          'ttntid'=>$model['ttntid'],
          'companyname'=>$model['companyname'],
          'docno'=>$model['docno'],
          'cbinno'=>$model['cbinno'],

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
	public function actionUpdatecutarinv()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatacutarinv.' where cutarinvid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'cashamount'=>$model['cashamount'],
          'bankamount'=>$model['bankamount'],
          'discamount'=>$model['discamount'],
          'returnamount'=>$model['returnamount'],
          'obamount'=>$model['obamount'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'description'=>$model['description'],
          'invoiceno'=>$model['invoiceno'],
          'invoicedate'=>$model['invoicedate'],
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
      array('ttntid','string','emptyttntid'),
    ));
		if ($error == false)
		{
			$id = $_POST['cutarid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateCutar (:docdate
,:companyid
,:ttntid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':cutarid',$_POST['cutarid'],PDO::PARAM_STR);
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':ttntid',(($_POST['ttntid']!=='')?$_POST['ttntid']:null),PDO::PARAM_STR);
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
	public function actionSavecutarinv()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['cutarinvid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update cutarinv 
			      set cashamount = :cashamount,bankamount = :bankamount,discamount = :discamount,returnamount = :returnamount,obamount = :obamount,currencyid = :currencyid,currencyrate = :currencyrate,description = :description 
			      where cutarinvid = :cutarinvid';
				}
				else
				{
					$sql = 'insert into cutarinv (cashamount,bankamount,discamount,returnamount,obamount,currencyid,currencyrate,description) 
			      values (:cashamount,:bankamount,:discamount,:returnamount,:obamount,:currencyid,:currencyrate,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':cutarinvid',$_POST['cutarinvid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':cashamount',(($_POST['cashamount']!=='')?$_POST['cashamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankamount',(($_POST['bankamount']!=='')?$_POST['bankamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':discamount',(($_POST['discamount']!=='')?$_POST['discamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':returnamount',(($_POST['returnamount']!=='')?$_POST['returnamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':obamount',(($_POST['obamount']!=='')?$_POST['obamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
	private function SendNotifWaCustomer($menuname,$idarray)
	{
    // getrecordstatus
    $ids = null;
		if(is_array($idarray)==TRUE) {
			foreach($idarray as $id) {
				$sql = "select cutarid
							from cutar
							where recordstatus = getwfmaxstatbywfname('appcutar')
							and cutarid <> 78523
							and cutarid = ".$id;
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
				/*$getWaNumber = "select distinct f.fullname, g.wanumber,sum(bankamount) as bankamount, sum(cashamount) as cashamount, sum(returnamount) as retur
												from cutarinv a
												join cutar b on b.cutarid = a.cutarid
												-- join ttnt c on c.ttntid = b.ttntid
												join invoice c on c.invoiceid = a.invoiceid
												join giheader d on d.giheaderid = c.giheaderid
												join soheader e on e.soheaderid = d.soheaderid
												left join addressbook f on f.addressbookid = e.addressbookid
												left join addresscontact g on g.addressbookid = f.addressbookid
												where b.cutarid in ({$ids})
												group by fullname"
				;*/
				
				$getCustomer = "select distinct f.fullname, e.addressbookid, b.cutarno, docdate, g.companycode, b.cutarid, replace((select wanumber from addresscontact z where z.addressbookid = f.addressbookid AND z.wanumber LIKE '+%' AND z.wanumber NOT LIKE '% %' AND z.wanumber NOT LIKE '%-%' AND length(z.wanumber) > 10 limit 1),'+','') as wanumber, (select telegramid from addresscontact z where z.addressbookid = f.addressbookid  limit 1) as telegramid, b.companyid
											from cutarinv a
											join cutar b on b.cutarid = a.cutarid
											join invoice c on c.invoiceid = a.invoiceid
											join giheader d on d.giheaderid = c.giheaderid
											join soheader e on e.soheaderid = d.soheaderid
											left join addressbook f on f.addressbookid = e.addressbookid
											left join company g on g.companyid = e.companyid
											where b.cutarid in ({$ids})
											and b.cutarid <> 78523
				";

				$res = Yii::app()->db->createCommand($getCustomer)->queryAll();  
				
				foreach($res as $row) {
					$companyid = $row['companyid'];
					$wanumber = $row['wanumber'];
					$telegramid = $row['telegramid'];
					$time = date('Y-m-d H:i:s');
					
					$getWaNumber = "select *, if(sisa=0,'LUNAS','BELUM LUNAS') as status 
											from (select c.invoiceno, c.payamount - (a.cashamount+a.bankamount+a.returnamount+a.discamount+a.obamount) as payamount, c.amount, c.amount - c.payamount + (a.cashamount+a.bankamount+a.returnamount+a.discamount+a.obamount) as saldoinvoice, a.cashamount, a.bankamount, a.returnamount, a.discamount, obamount, (c.amount - c.payamount) as sisa
											from cutarinv a
											join cutar b on b.cutarid = a.cutarid
											-- join ttnt c on c.ttntid = b.ttntid
											join invoice c on c.invoiceid = a.invoiceid
											join giheader d on d.giheaderid = c.giheaderid
											join soheader e on e.soheaderid = d.soheaderid
											left join addressbook f on f.addressbookid = e.addressbookid
											-- left join addresscontact g on g.addressbookid = f.addressbookid
											where b.cutarid = {$row['cutarid']} and f.addressbookid = {$row['addressbookid']}
											and b.cutarid <> 78523) z";
					$res1 = Yii::app()->db->createCommand($getWaNumber)->queryAll();
					$pesanw = '';
					$pesant = '';
					$i=1;
					$subcash = 0;
					$subbank = 0;
					$subdisc = 0;
					$subreturn = 0;
					$subob   = 0;
					$subsisa   = 0;
					foreach($res1 as $row1) {
			//whatsapp1
						if($row1['cashamount'] == 0) {$cashw="";} else {$cashw = "\n    _Tunai_ : Rp. ".Yii::app()->format->formatCurrency($row1['cashamount']);}
						if($row1['bankamount'] == 0) {$bankw="";} else {$bankw = "\n    _KU_ : Rp. ".Yii::app()->format->formatCurrency($row1['bankamount']);}
						if($row1['discamount'] == 0) {$discw="";} else {$discw = "\n    _Diskon_ : Rp. ".Yii::app()->format->formatCurrency($row1['discamount']);}
						if($row1['returnamount'] == 0) {$returnw="";} else {$returnw = "\n    _Retur_ : Rp. ".Yii::app()->format->formatCurrency($row1['returnamount']);}
						if($row1['obamount'] == 0) {$obw="";} else {$obw = "\n    _OB_ : Rp. ".Yii::app()->format->formatCurrency($row1['obamount']);}
						//if($row1['sisa'] == 0) {$sisaw="";} else {$sisaw = "\nSisa : Rp. ".Yii::app()->format->formatCurrency($row1['sisa']).' '.$row1['status']."\n\n";}
						
						$pesanw .=  $i.". ".$row1['invoiceno']." Rp. ".Yii::app()->format->formatCurrency($row1['amount'])."\n    Kum. Bayar : Rp. ".Yii::app()->format->formatCurrency($row1['payamount'])."\n    Saldo Invoice : Rp. ".Yii::app()->format->formatCurrency($row1['saldoinvoice'])."\n_Pelunasan secara_ :".$cashw.$bankw.$discw.$returnw.$obw."\nSisa : Rp. ".Yii::app()->format->formatCurrency($row1['sisa']). " *".$row1['status']."*\n\n";
						
			//telegram1
						if($row1['cashamount'] == 0) {$casht="";} else {$casht = "%0A    <i>Tunai</i> : Rp. ".Yii::app()->format->formatCurrency($row1['cashamount']);}
						if($row1['bankamount'] == 0) {$bankt="";} else {$bankt = "%0A    <i>KU</i> : Rp. ".Yii::app()->format->formatCurrency($row1['bankamount']);}
						if($row1['discamount'] == 0) {$disct="";} else {$disct = "%0A    <i>Diskon</i> : Rp. ".Yii::app()->format->formatCurrency($row1['discamount']);}
						if($row1['returnamount'] == 0) {$returnt="";} else {$returnt = "%0A    <i>Retur</i> : Rp. ".Yii::app()->format->formatCurrency($row1['returnamount']);}
						if($row1['obamount'] == 0) {$obt="";} else {$obt = "%0A    <i>OB</i> : Rp. ".Yii::app()->format->formatCurrency($row1['obamount']);}
						//if($row1['sisa'] == 0) {$sisat="";} else {$sisat = "%0ASisa : Rp. ".Yii::app()->format->formatCurrency($row1['sisa']).' '.$row1['status']."%0A%0A";}
						
						$pesant .=  $i.". ".$row1['invoiceno']." Rp. ".Yii::app()->format->formatCurrency($row1['amount'])."%0A    Kum. Bayar : Rp. ".Yii::app()->format->formatCurrency($row1['payamount'])."%0A    Saldo Invoice : Rp. ".Yii::app()->format->formatCurrency($row1['saldoinvoice'])."%0A<i>Pelunasan secara</i> :".$casht.$bankt.$disct.$returnt.$obt."%0ASisa : Rp. ".Yii::app()->format->formatCurrency($row1['sisa']). " <b>".$row1['status']."</b>%0A%0A";
						
						$i++;
						$subcash = $subcash + $row1['cashamount'];
						$subbank = $subbank + $row1['bankamount'];
						$subdisc = $subdisc + $row1['discamount'];
						$subreturn = $subreturn + $row1['returnamount'];
						$subob = $subob + $row1['obamount'];
						$subsisa = $subsisa + $row1['sisa'];
					}
					if ($wanumber > 0)
					{$sendtocustomer = "\n\n*SUDAH TERKIRIM ke No WA Customer*\n".$wanumber;}
					else
					{$sendtocustomer = "\n\n*BELUM ADA No WA Customer*\n".$row['fullname'];}
					
			//whatsapp2
					if($subcash == 0) {$totcashw="";} else {$totcashw = "Total Tunai : Rp. ".Yii::app()->format->formatCurrency($subcash)."\n";}
					if($subbank == 0) {$totbankw="";} else {$totbankw = "Total KU : Rp. ".Yii::app()->format->formatCurrency($subbank)."\n";}
					if($subdisc == 0) {$totdiscw="";} else {$totdiscw = "Total Diskon : Rp. ".Yii::app()->format->formatCurrency($subdisc)."\n";}
					if($subreturn == 0) {$totreturnw="";} else {$totreturnw = "Total Retur : Rp. ".Yii::app()->format->formatCurrency($subreturn)."\n";}
					if($subob == 0) {$totobw="";} else {$totobw = "Total OB : Rp. ".Yii::app()->format->formatCurrency($subob)."\n";}
					//if($subsisa == 0) {$totsisaw="";} else {$totsisaw = "Total Sisa : Rp. ".Yii::app()->format->formatCurrency($subsisa)."\n";}
					
					if ($i > 2) {$totalpesanw = $totcashw.$totbankw.$totdiscw.$totreturnw.$totobw."\n";} else {$totalpesanw = "";}
					
					$pesanwa = "*KONFIRMASI PELUNASAN PIUTANG*\n\nTerima kasih atas pelunasan Customer {$row['companycode']} :\n*".$row['fullname']."*\n\nPada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['docdate']))." No. {$row['cutarno']} dengan rincian sebagai berikut :\n\n".$pesanw.$totalpesanw."*Apabila :*\n1. Sudah Sesuai, abaikan pesan ini.\n2. Tidak Sesuai, silahkan konfirmasi dengan klik >> https://t.me/kangaroospringbed_bot atau https://wa.me/6285272087379 , dengan melampirkan pesan ini.\n\nTerima kasih atas perhatian dan kerjasama pelanggan setia AKA Group.\n\n*JANGAN BALAS KE NO WA INI !!!*\n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".$time;
					
					$pesannowa = "*Tidak Ada No WA* atau *No WA Belum Tepat* (PELUNASAN)\n\nCustomer {$row['companycode']} :\n*".$row['fullname']."*\n\nPada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['docdate']))." No. {$row['cutarno']} \n\n_*Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)*_\n".$time;
					
			//telegram2
					if($subcash == 0) {$totcasht="";} else {$totcasht = "Total Tunai : Rp. ".Yii::app()->format->formatCurrency($subcash)."%0A";}
					if($subbank == 0) {$totbankt="";} else {$totbankt = "Total KU : Rp. ".Yii::app()->format->formatCurrency($subbank)."%0A";}
					if($subdisc == 0) {$totdisct="";} else {$totdisct = "Total Diskon : Rp. ".Yii::app()->format->formatCurrency($subdisc)."%0A";}
					if($subreturn == 0) {$totreturnt="";} else {$totreturnt = "Total Retur : Rp. ".Yii::app()->format->formatCurrency($subreturn)."%0A";}
					if($subob == 0) {$totobt="";} else {$totobt = "Total OB : Rp. ".Yii::app()->format->formatCurrency($subob)."%0A";}
					//if($subsisa == 0) {$totsisat="";} else {$totsisat = "Total Sisa : Rp. ".Yii::app()->format->formatCurrency($subsisa)."%0A";}
					
					if ($i > 2) {$totalpesant = $totcasht.$totbankt.$totdisct.$totreturnt.$totobt."%0A";} else {$totalpesant = "";}
					
					$pesantele = "<b>KONFIRMASI PELUNASAN PIUTANG</b>%0A%0ATerima kasih atas pelunasan Customer {$row['companycode']} :%0A<b>".$row['fullname']."</b>%0A%0APada Tanggal ".date(Yii::app()->params['dateviewfromdb'],strtotime($row['docdate']))." No. {$row['cutarno']} dengan rincian sebagai berikut :%0A%0A".$pesant.$totalpesant."<b>Apabila :</b>%0A1. Sudah Sesuai, abaikan pesan ini.%0A2. Tidak Sesuai, silahkan konfirmasi dengan klik >> https://t.me/kangaroospringbed_bot atau https://wa.me/6285272087379 , dengan melampirkan pesan ini.%0A%0ATerima kasih atas perhatian dan kerjasama pelanggan setia AKA Group.%0A%0A<b>JANGAN BALAS KE NO WA INI !!!</b>%0A%0A<b><i>Pesan ini dikirim Otomatis oleh SIAGA (System Information AKA Group - Automatic)</i></b>%0A".$time.$sendtocustomer;

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
					
/*					$url = Yii::app()->params['tele']."/sendMessage?chat_id=".$telegroupid."&text=".$pesantele."&parse_mode=html";
					$ch = curl_init($url);
					curl_exec ($ch);
					curl_reset($ch);*/
					
					if ($wanumber > 0)
					{
					//Whatsapp Customer
						sendwajapri($siaga,$pesanwa,$wanumber);
/*						$ch = curl_init();
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
						sendwagroup($siaga,$pesanwa."\n\n_Tes Chatfire CMS_","6281717212109-1615804565");
					}
					else
					{
						//Whatsapp Group Tidak Ada No WA Customer
						sendwajapri($siaga,$pesannowa,$auditgroup);
/*						$ch = curl_init();
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
					
/*					$url = Yii::app()->params['ip'].'send_message';
					$data = array(
						"phone_no"=> $wanumber,
						"key"		=> Yii::app()->params['key'],
						"message"	=> $pesanwa,
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
					
					$url = Yii::app()->params['ip'].'send_message';
					$data = array(
						"phone_no"=> $wanum,
						"key"		=> Yii::app()->params['key'],
						"message"	=> $pesanwa,
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
					curl_exec($ch);
*/
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
				$sql = 'call Approvecutar(:vid,:vcreatedby)';
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
				$sql = 'call Deletecutar(:vid,:vcreatedby)';
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
				$sql = "delete from cutar where cutarid = ".$id[$i];
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
	public function actionPurgecutarinv()
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
				$sql = "delete from cutarinv where cutarinvid = ".$id[$i];
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
		$sql = "select distinct a.cutarid,a.cutarno,a.docdate as cutardate,c.docno as ttntno,c.docdate as ttntdate,b.companyid
                        from cutar a
                        left join company b on b.companyid = a.companyid
                        left join ttnt c on c.ttntid = a.ttntid
                        left join cutarinv d on d.cutarid = a.cutarid ";
		if ($_GET['cutarid'] !== '') {
				$sql = $sql . "where a.cutarid in (".$_GET['cutarid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('cutar');
                $this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(8);
                    $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cutarno']);
                    $this->pdf->text(160,$this->pdf->gety()+2,'TTNT ');$this->pdf->text(170,$this->pdf->gety()+2,': '.$row['ttntno']);
                    $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cutardate'])));
                    $this->pdf->text(160,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(170,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));
                    $sql1 = "select a.cutarid,b.invoiceno,f.fullname,b.invoicedate,a.saldoinvoice,a.cashamount,a.bankamount,a.discamount,a.returnamount,a.obamount,
							(a.cashamount+a.bankamount+a.discamount+a.returnamount+a.obamount) as jumlah,c.currencyname,a.currencyrate,a.description,
							(a.saldoinvoice-(a.cashamount+a.bankamount+a.discamount+a.returnamount+a.obamount)) as sisa
                            from cutarinv a
                            left join invoice b on b.invoiceid = a.invoiceid
                            left join currency c on c.currencyid = a.currencyid
							left join giheader d on d.giheaderid=b.giheaderid
                            left join soheader e on e.soheaderid=d.soheaderid
                            left join addressbook f on f.addressbookid=e.addressbookid
                            where a.cutarid = ".$row['cutarid'];
                    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                    
					$total = 0;$totalqty=0;
					$total1 = 0;$totalqty1=0;
					$total2 = 0;$totalqty2=0;
					$total3 = 0;$totalqty3=0;
					$total4 = 0;$totalqty4=0;
					$total5 = 0;$totalqty5=0;
					$total6 = 0;$totalqty6=0;
					$total7 = 0;$totalqty7=0;
                    $this->pdf->sety($this->pdf->gety()+10);    
                    $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
                    $this->pdf->setwidths(array(10,20,30,20,25,25,25,25,25,25,25,25));
                    $this->pdf->colheader = array('No','No Invoice','Customer','Tgl Invoice','Saldo Invoice','Tunai','Bank','Diskon','Retur','OB','Jumlah','Sisa');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('C','L','L','C','R','R','R','R','R','R','R','R');
                    $i=0;
                    foreach($dataReader1 as $row1)
					
					
					{
                        $i=$i+1;
												$this->pdf->setFont('Arial','',7);
                        $this->pdf->row(array($i,$row1['invoiceno'],
						$row1['fullname'],
                        date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
                        Yii::app()->format->formatNumber($row1['saldoinvoice']),						
						Yii::app()->format->formatNumber($row1['cashamount']),
						Yii::app()->format->formatNumber($row1['bankamount']),
						Yii::app()->format->formatNumber($row1['discamount']),
						Yii::app()->format->formatNumber($row1['returnamount']),
						Yii::app()->format->formatNumber($row1['obamount']),                        
						Yii::app()->format->formatNumber($row1['jumlah']),
						Yii::app()->format->formatNumber($row1['sisa']))
                        );
						
					$total = $row1['saldoinvoice'] + $total;
					$total1 = $row1['cashamount'] + $total1;
					$total2 = $row1['bankamount'] + $total2;
					$total3 = $row1['discamount'] + $total3;
					$total4 = $row1['returnamount'] + $total4;
					$total5 = $row1['obamount'] + $total5;
					$total6 = $row1['jumlah'] + $total6;
					$total7 = $row1['sisa'] + $total7;
					}
					
					$this->pdf->setbordercell(array('TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB'));
					$this->pdf->row(array('','','Total','',
					Yii::app()->format->formatNumber($total),					
					Yii::app()->format->formatNumber($total1),
					Yii::app()->format->formatNumber($total2),
					Yii::app()->format->formatNumber($total3),
					Yii::app()->format->formatNumber($total4),
					Yii::app()->format->formatNumber($total5),
					Yii::app()->format->formatNumber($total6),
					Yii::app()->format->formatNumber($total7)));
					                
                    //      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
                $this->pdf->checkNewPage(40);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'   Admin AR');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cutarid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cutarno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('cbinno'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cutarid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cutarno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['cbinno'])
->setCellValueByColumnAndRow(6, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}