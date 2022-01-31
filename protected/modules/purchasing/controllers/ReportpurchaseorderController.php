<?php

class ReportpurchaseorderController extends AdminController
{
	protected $menuname = 'reportpurchaseorder';
	public $module = 'Purchasing';
	protected $pageTitle = 'Daftar Purchase Order';
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
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a1.companyid in (".getUserObjectValues('company').")";
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