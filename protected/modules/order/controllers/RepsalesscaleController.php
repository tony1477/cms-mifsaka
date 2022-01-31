<?php

class RepsalesscaleController extends AdminController
{
	protected $menuname = 'repsalesscale';		
	public $module = 'order';
	protected $pageTitle = 'Daftar Skala Penjualan';
	public $wfname = 'listss';
	protected $sqldata = "select t.*, a.companyname
        from `salesscale` `t`
        left join `company` `a` on a.companyid = t.companyid ";
	protected $sqlcount = 'select count(1) 
		from `salesscale` `t`
        left join `company` `a` on a.companyid = t.companyid ';
		
	protected $sqldatasalesscaledet = 'select t.*, a.description
         from salesscaledet t
         left join materialgroup a on a.materialgroupid = t.materialgroupid ';
	protected $sqlcountsalesscaledet = 'select count(1) 
        from salesscaledet t
        left join materialgroup a on a.materialgroupid = t.materialgroupid ';
    protected $sqldatasalesscalecat = "select t.*, a1.custcategoryname
    from salesscalecat t
    left join custcategory a1 on a1.custcategoryid = t.custcategoryid
    ";
    protected $sqlcountsalesscalecat = "select count(1)
    from salesscalecat t
    left join custcategory a1 on a1.custcategoryid = t.custcategoryid
    ";
	
	protected function getSQL()
	{
            
		//$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where t.recordstatus <> 0 and t.companyid in (".getUserObjectValues('company').")" ;
        
		if ((isset($_REQUEST['salesscaleid'])) && $_REQUEST['salesscaleid']!=='' && $_REQUEST['salesscaleid']!=0)
		{				   
            $where .=" and (coalesce(salesscaleid,'') like {$_REQUEST['salesscaleid']})";
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
			'keyField'=>'salesscaleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'salesscaleid','companyid','docno','docdate','perioddate', 'recordstatus','paramspv','minscale','spvscale'
        ),
				'defaultOrder' => array( 
					'salesscaleid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['salesscaledetid']))
		{
			$this->sqlcountsalesscaledet .= ' where salesscaledetid = '.$_REQUEST['salesscaledetid'];
			$this->sqldatasalesscaledet .= ' where salesscaledetid = '.$_REQUEST['salesscaledetid'];
		}
		if (isset($_REQUEST['salesscaleid']))
		{
			$this->sqlcountsalesscaledet .= ' where salesscaleid = '.$_REQUEST['salesscaleid'];
			$this->sqldatasalesscaledet .= ' where salesscaleid = '.$_REQUEST['salesscaleid'];
            $this->sqlcountsalesscalecat .= ' where t.salesscaleid = '.$_REQUEST['salesscaleid'];
			$this->sqldatasalesscalecat .= ' where t.salesscaleid = '.$_REQUEST['salesscaleid'];
		}
		$countsalesscaledet = Yii::app()->db->createCommand($this->sqlcountsalesscaledet)->queryScalar();
		$dataProvidersalesscaledet=new CSqlDataProvider($this->sqldatasalesscaledet,array(
			'totalItemCount'=>$countsalesscaledet,
			'keyField'=>'salesscaledetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'salesscaledetid', 'materialgroupid', 'gt120', 'gt100', 'gt90', 'gt80', 'gt70',
        ),
				'defaultOrder' => array( 
					'salesscaledetid' => CSort::SORT_ASC
				),
			),
		));
        
        $countsalesscalecat = Yii::app()->db->createCommand($this->sqlcountsalesscalecat)->queryScalar();
        
        $dataProvidersalesscalecat = new CSqlDataProvider($this->sqldatasalesscalecat,array(
					'totalItemCount'=>$countsalesscalecat,
					'keyField'=>'salesscalecatid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'salesscalecatid' => CSort::SORT_DESC
						),
					),
					));
		
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersalesscaledet'=>$dataProvidersalesscaledet,'dataProvidersalesscalecat'=>$dataProvidersalesscalecat));
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