<?php

class ReportsoController extends AdminController
{
	protected $menuname = 'reportso';		
	public $module = 'order';
	protected $pageTitle = 'Daftar Sales Order';
	public $wfname = 'appso';
	protected $sqldata = "
			select a.*, b.companyname, c.fullname, d.fullname as salesname, e.paycode, e.paymentname, f.taxcode,f.taxvalue,
			c.currentlimit, c.creditlimit, a.statusname, a.totalbefdisc, a.shipto, a.billto, a.totalaftdisc, c.top,	c.overdue,
      case when (((a.currentlimit + a.totalaftdisc + a.pendinganso) > c.creditlimit) and (c.top > 0)) then 1  
      when (((a.currentlimit + a.totalaftdisc + a.pendinganso) <= c.creditlimit) and (c.top > 0)) then 2  
      when (((a.currentlimit + a.totalaftdisc + a.pendinganso) > c.creditlimit) and (c.top <= 0)) then 3
			else 4 end as warna,
			(select ifnull(sum(ifnull(getamountdiscso(za.soheaderid,z.sodetailid,z.qty-z.giqty),0)),0)
				from sodetail z
				join soheader za on z.soheaderid=za.soheaderid
				where za.recordstatus=6 and z.qty>z.giqty and za.addressbookid=a.addressbookid and za.soheaderid<>a.soheaderid) as pendinganso,isdisplay,a.createddate,a.updatedate
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
		$where = " where a.companyid in (".getUserObjectValues('company').")
		and a.soheaderid in (select distinct a1.soheaderid from sodetail a1 join sloc b1 on b1.slocid=a1.slocid where b1.plantid in (".getUserObjectValues('plant')."))
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
				if ($where == "")
				{
					$where = " where a.soheaderid in (".$_REQUEST['soheaderid'].")";
				}
				else
				{
					$where .= " and a.soheaderid in (".$_REQUEST['soheaderid'].")";
				}
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
		if (isset($_REQUEST['sodetailid']))
		{
			$this->sqlcountsodetail .= ' where sodetailid = '.$_REQUEST['sodetailid'];
			$this->sqldatasodetail .= ' where sodetailid = '.$_REQUEST['sodetailid'];
		}
		if (isset($_REQUEST['soheaderid']))
		{
			$this->sqlcountsodetail .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$this->sqldatasodetail .= ' where soheaderid = '.$_REQUEST['soheaderid'];
		}
		$countsodetail = Yii::app()->db->createCommand($this->sqlcountsodetail)->queryScalar();
		$dataProvidersodetail=new CSqlDataProvider($this->sqldatasodetail,array(
			'totalItemCount'=>$countsodetail,
			'keyField'=>'sodetailid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'sodetailid', 'productid','unitofmeasureid','qty','unitofmeasureid','currencyid','price','slocid'
        ),
				'defaultOrder' => array( 
					'sodetailid' => CSort::SORT_ASC
				),
			),
		));
		if (isset($_REQUEST['soheaderid']))
		{
			$this->sqlcountsodisc .= ' where soheaderid = '.$_REQUEST['soheaderid'];
			$this->sqldatasodisc .= ' where soheaderid = '.$_REQUEST['soheaderid'];
		}
		$countsodisc = Yii::app()->db->createCommand($this->sqlcountsodisc)->queryScalar();
		$dataProvidersodisc=new CSqlDataProvider($this->sqldatasodisc,array(
			'totalItemCount'=>$countsodisc,
			'keyField'=>'sodiscid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'sodiscid','discvalue'
        ),
				'defaultOrder' => array( 
					'sodiscid' => CSort::SORT_ASC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersodetail'=>$dataProvidersodetail,
			'dataProvidersodisc'=>$dataProvidersodisc));
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
			a.addressbookid, a.headernote,a.recordstatus,a.shipto,a.billto,d.fullname as salesname, isdisplay
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