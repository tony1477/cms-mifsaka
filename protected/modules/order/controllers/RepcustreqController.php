<?php

class RepcustreqController extends AdminController
{
	protected $menuname = 'repcustreq';
	public $module = 'Order';
	protected $pageTitle = 'Daftar Customer Baru';
	public $wfname = 'appcustreq';
	protected $sqldata = "select a0.custreqid,a0.custreqno,a0.reqdate,a0.companyid,a0.custcode,a0.fullname,a0.address,a0.cityid,a0.provinceid,a0.zipcode,a0.countryid,a0.phoneno,a0.mobileno,a0.wanumber,a0.faxno,a0.idno,a0.contactperson,a0.birthdatetoko,a0.husbandbirthdate,a0.wifebirthdate,a0.weddingdate,a0.owner,a0.homeno,a0.owneraddress,a0.religionid,a0.buildingstatus,a0.empno,a0.pramuniaga,a0.taxgroupid,a0.taxno,a0.bankname,a0.taxname,a0.bankaddress,a0.taxaddress,a0.accountno,a0.accountname,a0.birthdatetoko,a0.employeeid,a0.creditlimit,a0.paymentid,a0.pricecategoryid,a0.groupcustomerid,a0.salesareaid,a0.lat,a0.lng,a0.custcategoryid,a0.custgradeid,a0.recordstatus,a1.companyname as companyname,a2.cityname as cityname,a3.provincename as provincename,a4.countryname as countryname,a5.religionname as religionname,a6.taxgroupname as taxgroupname,a7.fullname as salesname,a8.paycode as paycode,a9.categoryname as categoryname,a13.groupname as groupname,a10.areaname as areaname,a11.custcategoryname as custcategoryname,a12.custgradename as custgradename,getwfstatusbywfname('appcustreq',a0.recordstatus) as statusname, custktp, custphoto
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
		$where = "where a0.companyid in (".getUserObjectValues('company').")";

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
					 'custreqid','custreqno','reqdate','companyid','custcode','fullname','address','cityid','provinceid','zipcode','countryid','phoneno','mobileno','faxno','idno','contactperson','husbandbirthdate','wifebirthdate','weddingdate','owner','homeno','owneraddress','religionid','buildingstatus','empno','pramuniaga','taxgroupid','taxno','bankname','taxname','bankaddress','taxaddress','accountno','accountname','birthdatetoko','employeeid','creditlimit','paymentid','pricecategoryid','salesareaid','lat','lng','custcategoryid','custgradeid','recordstatus','groupcustomerid'
				),
				'defaultOrder' => array( 
					'custreqid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionDownPDF()
  {
    parent::actionDownPDF();
    $sql = "select a0.reqdate,a1.companyname,a0.custcode,a0.fullname,a0.address,a2.cityname,a3.provincename,a4.countryname,
          a0.zipcode,a0.phoneno,a0.mobileno,a0.faxno,a0.idno,a0.contactperson,a0.husbandbirthdate,a0.wifebirthdate,a0.weddingdate,a0.owner,a0.homeno,a0.owneraddress,
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
      $this->pdf->row(array('No. Fax',' : '.$row['faxno']));
      $this->pdf->row(array('No. KTP/SIM',' : '.$row['idno']));
      $this->pdf->row(array('Kontak Person',' : '.$row['contactperson']));
      $this->pdf->row(array('Tgl Lahir',' : '.$row['birthdate']));
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
->setCellValueByColumnAndRow(13,4,$this->getCatalog('faxno'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('idno'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('contactperson'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('birthdate'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('owner'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('homeno'))
->setCellValueByColumnAndRow(19,4,$this->getCatalog('owneraddress'))
->setCellValueByColumnAndRow(20,4,$this->getCatalog('religionname'))
->setCellValueByColumnAndRow(21,4,$this->getCatalog('buildingstatus'))
->setCellValueByColumnAndRow(22,4,$this->getCatalog('empno'))
->setCellValueByColumnAndRow(23,4,$this->getCatalog('pramuniaga'))
->setCellValueByColumnAndRow(24,4,$this->getCatalog('taxgroupname'))
->setCellValueByColumnAndRow(25,4,$this->getCatalog('taxno'))
->setCellValueByColumnAndRow(26,4,$this->getCatalog('bankname'))
->setCellValueByColumnAndRow(27,4,$this->getCatalog('taxname'))
->setCellValueByColumnAndRow(28,4,$this->getCatalog('bankaddress'))
->setCellValueByColumnAndRow(29,4,$this->getCatalog('taxaddress'))
->setCellValueByColumnAndRow(30,4,$this->getCatalog('accountno'))
->setCellValueByColumnAndRow(31,4,$this->getCatalog('accountname'))
->setCellValueByColumnAndRow(32,4,$this->getCatalog('birthdatetoko'))
->setCellValueByColumnAndRow(33,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(34,4,$this->getCatalog('creditlimit'))
->setCellValueByColumnAndRow(35,4,$this->getCatalog('paycode'))
->setCellValueByColumnAndRow(36,4,$this->getCatalog('categoryname'))
->setCellValueByColumnAndRow(37,4,$this->getCatalog('areaname'))
->setCellValueByColumnAndRow(38,4,$this->getCatalog('lat'))
->setCellValueByColumnAndRow(39,4,$this->getCatalog('lng'))
->setCellValueByColumnAndRow(40,4,$this->getCatalog('custcategoryname'))
->setCellValueByColumnAndRow(41,4,$this->getCatalog('custgradename'))
->setCellValueByColumnAndRow(41,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(42,4,$this->getCatalog('recordstatus'));
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
->setCellValueByColumnAndRow(13, $i+1, $row1['faxno'])
->setCellValueByColumnAndRow(14, $i+1, $row1['idno'])
->setCellValueByColumnAndRow(15, $i+1, $row1['contactperson'])
->setCellValueByColumnAndRow(16, $i+1, $row1['birthdate'])
->setCellValueByColumnAndRow(17, $i+1, $row1['owner'])
->setCellValueByColumnAndRow(18, $i+1, $row1['homeno'])
->setCellValueByColumnAndRow(19, $i+1, $row1['owneraddress'])
->setCellValueByColumnAndRow(20, $i+1, $row1['religionname'])
->setCellValueByColumnAndRow(21, $i+1, $row1['buildingstatus'])
->setCellValueByColumnAndRow(22, $i+1, $row1['empno'])
->setCellValueByColumnAndRow(23, $i+1, $row1['pramuniaga'])
->setCellValueByColumnAndRow(24, $i+1, $row1['taxgroupname'])
->setCellValueByColumnAndRow(25, $i+1, $row1['taxno'])
->setCellValueByColumnAndRow(26, $i+1, $row1['bankname'])
->setCellValueByColumnAndRow(27, $i+1, $row1['taxname'])
->setCellValueByColumnAndRow(28, $i+1, $row1['bankaddress'])
->setCellValueByColumnAndRow(29, $i+1, $row1['taxaddress'])
->setCellValueByColumnAndRow(30, $i+1, $row1['accountno'])
->setCellValueByColumnAndRow(31, $i+1, $row1['accountname'])
->setCellValueByColumnAndRow(32, $i+1, $row1['birthdatetoko'])
->setCellValueByColumnAndRow(33, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(34, $i+1, $row1['creditlimit'])
->setCellValueByColumnAndRow(35, $i+1, $row1['paycode'])
->setCellValueByColumnAndRow(36, $i+1, $row1['categoryname'])
->setCellValueByColumnAndRow(37, $i+1, $row1['areaname'])
->setCellValueByColumnAndRow(38, $i+1, $row1['lat'])
->setCellValueByColumnAndRow(39, $i+1, $row1['lng'])
->setCellValueByColumnAndRow(40, $i+1, $row1['custcategoryname'])
->setCellValueByColumnAndRow(40, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(41, $i+1, $row1['custgradename'])
->setCellValueByColumnAndRow(42, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
