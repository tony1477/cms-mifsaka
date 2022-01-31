<?php

class RepinvarController extends AdminController
{
	protected $menuname = 'repinvar';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Account Receivable';
	public $wfname = 'appinvar';
	protected $sqldata = "select a0.invoiceid,a0.invoicedate,a0.invoiceno,a0.giheaderid,a0.amount,a0.currencyid,a0.currencyrate,a0.payamount,a0.headernote,a0.recordstatus,a1.gino as gino,a2.currencyname as currencyname,a0.statusname  
    from invoice a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
    left join currency a2 on a2.currencyid = a0.currencyid 
		left join soheader a3 on a3.soheaderid = a1.giheaderid 
  ";
  protected $sqlcount = "select count(1) 
    from invoice a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
    left join currency a2 on a2.currencyid = a0.currencyid 
		left join soheader a3 on a3.soheaderid = a1.giheaderid 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a3.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['invoiceno'])) && (isset($_REQUEST['gino'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .=  " 
and a0.invoiceno like '%". $_REQUEST['invoiceno']."%' 
and a1.gino like '%". $_REQUEST['gino']."%' 
and a2.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['invoiceid']))
			{
				if (($_REQUEST['invoiceid'] !== '0') && ($_REQUEST['invoiceid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.invoiceid in (".$_REQUEST['invoiceid'].")";
					}
					else
					{
						$where .= " and a0.invoiceid in (".$_REQUEST['invoiceid'].")";
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
			'keyField'=>'invoiceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'invoiceid','invoicedate','invoiceno','giheaderid','amount','currencyid','currencyrate','payamount','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'invoiceid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select f.companyid,a.amount,g.symbol,currencyrate,a.giheaderid,invoiceid,invoiceno,f.sono,d.fullname as customer,a.invoicedate,a.headernote, taxvalue,a.recordstatus,
	   f.shipto as addressname,
	   j.cityname,f.isdisplay,
		 a.recordstatus,date_add(a.invoicedate, INTERVAL e.paydays day) as duedate,b.gino,f.sono,f.soheaderid,h.fullname as sales
		from invoice a 
		left join giheader b on b.giheaderid = a.giheaderid
		left join soheader f on f.soheaderid = b.soheaderid
		left join tax c on c.taxid = f.taxid 
		left join currency g on g.currencyid = a.currencyid
		left join addressbook d on d.addressbookid = f.addressbookid
		left join paymentmethod e on e.paymentmethodid = f.paymentmethodid
		left join employee h on h.employeeid = f.employeeid
		left join company i on i.companyid = f.companyid
		left join city j on j.cityid = i.cityid ";
		if ($_GET['invoiceid'] !== '') {
				$sql = $sql . "where a.invoiceid in (".$_GET['invoiceid'].")";
		}
		$sql = $sql . " order by invoiceid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
    {
			$this->pdf->companyid=$row['companyid'];
		}
	 	$this->pdf->title='Faktur Penitipan Barang';
	  $this->pdf->AddPage('P',array(220,140));
	  $this->pdf->AddFont('tahoma','','tahoma.php');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('tahoma');
		$sodisc = '';
		$sql1 = 'select ifnull(discvalue,0) as discvalue from sodisc z where z.soheaderid = '.$row['soheaderid'];
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
		foreach($dataReader1 as $row1)
    {
			if ($sodisc == '')
			{
				$sodisc = Yii::app()->format->formatNumber($row1['discvalue']);
			}
			else
			{
				$sodisc = $sodisc.'+'.Yii::app()->format->formatNumber($row1['discvalue']);
			}
		}	  
		
		if ($sodisc == '')
		{
			$sodisc = '0';
		}

    foreach($dataReader as $row)
    {
			if($row['isdisplay']==1) $this->pdf->Image('images/DISPLAY.jpg', 0, 8, 210, 135);
		$this->pdf->setFontSize(9);
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(20,70,20,10,10,70));
		$this->pdf->row(array(
		'No',
		' : '.$row['invoiceno'],'','',
		'',
		$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		));
		$this->pdf->row(array(
		'Sales',
		' : '.$row['sales'],'','',
		'',
		'Kepada Yth, ',
		));
		$this->pdf->row(array(
		'No. SO ',
		' : '.$row['sono'],'','',
		'',
		$row['customer'],
		));
		$this->pdf->row(array(
		'T.O.P. ',
		($row['isdisplay']==1) ? ' : LANGSUNG BAYAR SAAT TERJUAL' : ' : ' .date(Yii::app()->params['dateviewfromdb'], strtotime($row['duedate'])),'','',
		'',
		$row['addressname'],
		));

		/*$this->pdf->text(10,$this->pdf->gety()+0,'No ');$this->pdf->text(25,$this->pdf->gety()+0,': '.$row['invoiceno']);
		$this->pdf->text(140,$this->pdf->gety()+0,$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
		$this->pdf->text(10,$this->pdf->gety()+5,'Sales ');$this->pdf->text(25,$this->pdf->gety()+5,': '.$row['sales']);
		$this->pdf->text(140,$this->pdf->gety()+5,'Kepada Yth, ');
		$this->pdf->text(10,$this->pdf->gety()+10,'No. SO ');$this->pdf->text(25,$this->pdf->gety()+10,': '.$row['sono']);
		$this->pdf->text(140,$this->pdf->gety()+10,$row['customer']);
		$this->pdf->text(10,$this->pdf->gety()+15,'T.O.P. ');$this->pdf->text(25,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['duedate'])));
		$this->pdf->text(140,$this->pdf->gety()+15,''.$row['addressname']);*/
			  
      $sql1 = "select * from (select a.sodetailid,d.productname,sum(a.qty) as qty,c.uomcode,f.price,b.symbol,a.itemnote,
	    (price * sum(a.qty) * ifnull(e.taxvalue,0)/100) as taxvalue
        from gidetail a
				inner join sodetail f on f.sodetailid = a.sodetailid
				inner join soheader g on g.soheaderid = f.soheaderid
		inner join product d on d.productid = a.productid
		inner join currency b on b.currencyid = f.currencyid
		inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
		left join tax e on e.taxid = g.taxid
        where a.giheaderid = '".$row['giheaderid'] ."' group by d.productname,a.sodetailid order by a.sodetailid
		) zz order by zz.sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $this->pdf->SetY($this->pdf->gety()+3);
		$this->pdf->setFontSize(9);
      $this->pdf->colalign = array('L','L','C','C','C','C','L','L');
      $this->pdf->setwidths(array(10,95,20,20,25,30));
	  $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Price','Total');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','R','R','R','R');
	  $i=0;$total = 0;$b='';
      foreach($dataReader1 as $row1)
      {
		$i=$i+1;
			$b=$row1['symbol'];
        $this->pdf->row(array($i,$row1['productname'],
			Yii::app()->format->formatNumber($row1['qty']),
			$row1['uomcode'],
			Yii::app()->format->formatCurrency($row1['price'],$row1['symbol']),
			Yii::app()->format->formatCurrency(($row1['price'] * $row1['qty']) + $row1['taxvalue'],$row1['symbol'])));
		$total += ($row1['price'] * $row1['qty']) + $row1['taxvalue'];
      }
      $this->pdf->setaligns(array('L','R','L','R','C','R','R','R'));
        $this->pdf->row(array('','',
			'',
			'',
			'Nominal',
			Yii::app()->format->formatCurrency($total,$b)));
			$this->pdf->row(array('','Disc '.$sodisc.' (%) ',
			'',
			'',
			'Diskon',
			Yii::app()->format->formatCurrency($total-$row['amount'],$b)));
			$this->pdf->row(array('','',
			'',
			'',
			'Netto',
			Yii::app()->format->formatCurrency($row['amount'],$b)));
			$bilangan = explode(".",$row['amount']);
			$this->pdf->iscustomborder=true;
		$this->pdf->setbordercell(array('','','','','','','',''));
					
			$this->pdf->colalign = array('C');
      $this->pdf->setwidths(array(150));
      $this->pdf->coldetailalign = array('L');
	  $this->pdf->row(array('Terbilang : '.$this->eja($bilangan[0]),));
	  $this->pdf->row(array('NOTE : '.$row['headernote'],));
	  
	$this->pdf->checkNewPage(20);
      $this->pdf->text(25,$this->pdf->gety()+5,'Approved By');$this->pdf->text(170,$this->pdf->gety()+5,'Proposed By');
      $this->pdf->text(25,$this->pdf->gety()+25,'_____________ ');$this->pdf->text(170,$this->pdf->gety()+25,'_____________');
	  $this->pdf->text(10,$this->pdf->gety()+30,'Catatan: Pembayaran dengan Cek/Giro dianggap lunas apabila telah dicairkan');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('invoiceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('invoicedate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('invoiceno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('amount'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('payamount'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['invoiceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['invoicedate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['invoiceno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(4, $i+1, $row1['amount'])
->setCellValueByColumnAndRow(5, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(7, $i+1, $row1['payamount'])
->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}