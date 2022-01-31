<?php

class RepsalestargetController extends AdminController
{
	protected $menuname = 'repsalestarget';		
	public $module = 'order';
	protected $pageTitle = 'Daftar Sales Target';
	public $wfname = 'listst';
	protected $sqldata = "select t.*, b.fullname, c.username, a.companyname
        from `salestarget` `t`
        left join `company` `a` ON a.companyid = t.companyid
        left join `employee` `b` ON b.employeeid = t.employeeid
        left join `useraccess` `c` ON c.useraccessid = t.useraccessid ";
	protected $sqlcount = 'select count(1) 
		from `salestarget` `t`
        left join `company` `a` ON a.companyid = t.companyid
        left join `employee` `b` ON b.employeeid = t.employeeid
        left join `useraccess` `c` ON c.useraccessid = t.useraccessid ';
		
	protected $sqldatasalestargetdet = 'select t.*, a.productname, c.sloccode, d.uomcode, b.description, e.custcategoryname
         from salestargetdet t
         left join product a on a.productid = t.productid
         left join materialgroup b on b.materialgroupid = t.materialgroupid
         left join sloc c on c.slocid = t.slocid
         left join unitofmeasure d on d.unitofmeasureid = t.unitofmeasureid
         left join custcategory e on e.custcategoryid = t.custcategoryid';
	protected $sqlcountsalestargetdet = 'select count(1) 
        from salestargetdet t
        left join product a on a.productid = t.productid
        left join materialgroup b on b.materialgroupid = t.materialgroupid
        left join sloc c on c.slocid = t.slocid
        left join unitofmeasure d on d.unitofmeasureid = t.unitofmeasureid  ';
	
	protected function getSQL()
	{
            
		//$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where t.recordstatus <> 0 and t.companyid in (".getUserObjectValues('company').")" ;
        
		if ((isset($_REQUEST['salestargetid'])) && $_REQUEST['salestargetid']!=='' && $_REQUEST['salestargetid']!=0)
		{				   
            $where .=" and (coalesce(salestargetid,'') like {$_REQUEST['salestargetid']})";
        }
        if ((isset($_REQUEST['fullname'])) && $_REQUEST['fullname']!=='')
		{				   
            $where .=" and (coalesce(fullname,'') like '%{$_REQUEST['fullname']}%')";
        }
        if ((isset($_REQUEST['companyname'])) && $_REQUEST['companyname']!=='')
		{				   
            $where .=" and (coalesce(companyname,'') like '%{$_REQUEST['companyname']}%')";
        }
        if ((isset($_REQUEST['docno'])) && $_REQUEST['docno']!=='')
		{				   
            $where .=" and (coalesce(docno,'') like '%{$_REQUEST['docno']}%')";
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
			'keyField'=>'salestargetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'salestargetid','employeeid','companyid','docno','docdate','perioddate', 'useraccessid', 'recordstatus',
        ),
				'defaultOrder' => array( 
					'salestargetid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['salestargetdetid']))
		{
			$this->sqlcountsalestargetdet .= ' where salestargetdetid = '.$_REQUEST['salestargetdetid'];
			$this->sqldatasalestargetdet .= ' where salestargetdetid = '.$_REQUEST['salestargetdetid'];
		}
		if (isset($_REQUEST['salestargetid']))
		{
			$this->sqlcountsalestargetdet .= ' where salestargetid = '.$_REQUEST['salestargetid'];
			$this->sqldatasalestargetdet .= ' where salestargetid = '.$_REQUEST['salestargetid'];
		}
		$countsalestargetdet = Yii::app()->db->createCommand($this->sqlcountsalestargetdet)->queryScalar();
		$dataProvidersalestargetdet=new CSqlDataProvider($this->sqldatasalestargetdet,array(
			'totalItemCount'=>$countsalestargetdet,
			'keyField'=>'salestargetdetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'salestargetdetid', 'materialgroupid', 'productid', 'qty', 'slocid', 'unitofmeasureid', 'price',
        ),
				'defaultOrder' => array( 
					'salestargetdetid' => CSort::SORT_ASC
				),
			),
		));
		
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersalestargetdet'=>$dataProvidersalestargetdet));
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
    
    public function actionDownPDFRekap()
	{
		parent::actionDownPDF();
		//$this->getSQL();
		//$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
        
		$sql = "select c.productname, sum(b.qty) as qty, d.uomcode, e.description, f.custcategoryname, ifnull(sum(b.qty*b.price),0) as price, g.fullname, a.employeeid, parentmatgroupid
                from salestarget a
                join salestargetdet b on b.salestargetid = a.salestargetid
                join product c on c.productid = b.productid
                join unitofmeasure d on d.unitofmeasureid = b.unitofmeasureid
                left join materialgroup e on e.materialgroupid = b.materialgroupid
                left join custcategory f on f.custcategoryid = b.custcategoryid
                left join employee g on g.employeeid = a.employeeid ";

        if ($_GET['salestargetid'] !== '') 
		{
				$sql = $sql . "where a.salestargetid in({$_GET['salestargetid']})
                group by b.productid ";
		}
		$this->pdf->AddPage('P','A4');				
		$res1 = Yii::app()->db->createCommand($sql)->queryAll();
        $this->pdf->colalign = array('C','C','L','C','C');
		$this->pdf->setwidths(array(10,120,17,17,30));
		$this->pdf->colheader = array('No',getCatalog('productname'),getCatalog('qty'),getCatalog('uom'),getCatalog('price'));
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('C','L','L','C','R');
		$i=1;
		$this->pdf->setFont('Arial','',10);
        $totalqty=0;
        $totalprice=0;
        $this->pdf->setFont('Arial','',8);
        foreach($res1 as $row1)
        {
            $this->pdf->row(array($i,$row1['productname'],
                                  Yii::app()->format->formatNumber($row1['qty']),
                                  $row1['uomcode'],
                                  Yii::app()->format->formatCurrency($row1['price'])));
            $i++;
            $totalqty = $totalqty + $row1['qty'];
            $totalprice = $totalprice + $row1['price'];
        }
        $this->pdf->setY($this->pdf->getY()+5);
        $this->pdf->setFont('Arial','B',10);
        $this->pdf->setwidths(array(10,80,30,80));
        $this->pdf->colalign = array('C','L','L','R');
        $this->pdf->row(array('','TOTAL ',
                                  Yii::app()->format->formatNumber($totalqty),
                                  Yii::app()->format->formatCurrency($totalprice)));
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
    
    public function actionDownXlsrekap() {
    $this->menuname = 'rekapsalestarget';
    parent::actionDownxls();
    $sql = "select c.productname, sum(b.qty) as qty, d.uomcode, e.description, f.custcategoryname, ifnull(sum(b.qty*b.price),0) as price, g.fullname, a.employeeid, parentmatgroupid, a.perioddate, a.companyid
                from salestarget a
                join salestargetdet b on b.salestargetid = a.salestargetid
                join product c on c.productid = b.productid
                join unitofmeasure d on d.unitofmeasureid = b.unitofmeasureid
                left join materialgroup e on e.materialgroupid = b.materialgroupid
                left join custcategory f on f.custcategoryid = b.custcategoryid
                left join employee g on g.employeeid = a.employeeid ";

    if ($_GET['salestargetid'] !== '') 
    {
            $sql = $sql . "where a.salestargetid in({$_GET['salestargetid']})
            group by b.productid ";
    }
    $i=1;
    $line=4;
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $dataReader1 = Yii::app()->db->createCommand($sql)->queryRow();
    foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($row['perioddate'])))
						->setCellValueByColumnAndRow(3,1,GetCompanyCode($row['companyid']));
    
    foreach ($dataReader as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line + 1, $i)
            ->setCellValueByColumnAndRow(1, $line + 1, $row1['productname'])
            ->setCellValueByColumnAndRow(2, $line + 1, $row1['qty'])
            ->setCellValueByColumnAndRow(3, $line + 1, $row1['uomcode'])
            ->setCellValueByColumnAndRow(4, $line + 1, $row1['price']);
      $i += 1;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
}