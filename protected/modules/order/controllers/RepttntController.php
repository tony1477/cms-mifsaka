<?php

class RepttntController extends AdminController
{
	protected $menuname = 'repttnt';		
	public $module = 'order';
	protected $pageTitle = 'Daftar TTNT';
	public $wfname = 'appttnt';
	protected $sqldata = "
			select t.*,t.docdate,t.docno,c.companyname,t.employeeid,b.fullname as fullname,t.description, t.statusname
				from ttnt t
				left join employee b on b.employeeid = t.employeeid
				left join company c on c.companyid = t.companyid ";
        
	protected $sqlcount = 'select count(1)		
                from ttnt t
                left join employee b on b.employeeid = t.employeeid
                left join company c on c.companyid = t.companyid ';
		
	protected $sqldatattntdetail = 'select t.*,b.invoicedate,c.gino,d.sono,e.fullname,b.invoiceno,b.amount,b.payamount,
					adddate(b.invoicedate,f.paydays) as jatuhtempo,
					datediff(current_date(),b.invoicedate) as umur, g.fullname as sales
				from ttntdetail t 
				 left join invoice b on b.invoiceid = t.invoiceid 
				 left join giheader c on c.giheaderid = b.giheaderid 
				 left join soheader d on d.soheaderid = c.soheaderid 
				 left join addressbook e on e.addressbookid = d.addressbookid 
				 left join paymentmethod f on f.paymentmethodid = d.paymentmethodid
				 left join employee g on g.employeeid = d.employeeid 
				 ';
	protected $sqlcountttntdetail = 'select count(1) 
		from ttntdetail t 
		left join invoice b on b.invoiceid = t.invoiceid 
		left join giheader c on c.giheaderid = b.giheaderid 
		left join soheader d on d.soheaderid = c.soheaderid 
		left join addressbook e on e.addressbookid = d.addressbookid 
		left join paymentmethod f on f.paymentmethodid = d.paymentmethodid';

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where t.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['docdate'])) && (isset($_REQUEST['companyname'])))
		{				
			$where .= " and t.docdate like '%". $_REQUEST['docdate']."%' 
						and c.companyname like '%". $_REQUEST['companyname']."%'
						and b.fullname like '%". $_REQUEST['fullname']."%'
						and t.description like '%". $_REQUEST['description']."%'
						"; 
		}
		if (isset($_REQUEST['ttntid']))
			{
				if (($_REQUEST['ttntid'] !== '0') && ($_REQUEST['ttntid'] !== ''))
				{
					$where .= " and t.ttntid in (".$_REQUEST['ttntid'].")";
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
//		var_dump($this->sqldata);
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'ttntid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'ttntid', 'docdate','docno','fullname','description', 'companyname','recordstatus'
        ),
				'defaultOrder' => array( 
					'ttntid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['ttntid']))
		{
			$this->sqlcountttntdetail .= ' where ttntid = '.$_REQUEST['ttntid'];
			$this->sqldatattntdetail .= ' where ttntid = '.$_REQUEST['ttntid'];
		}
		if (isset($_REQUEST['ttntdetailid']))
		{
			$this->sqlcountttntdetail .= ' where ttntdetailid = '.$_REQUEST['ttntdetailid'];
			$this->sqldatattntdetail .= ' where ttntdetailid = '.$_REQUEST['ttntdetailid'];
		}
		$sqlcountttntdetail = Yii::app()->db->createCommand($this->sqlcountttntdetail)->queryScalar();
		$dataProviderttntdetail=new CSqlDataProvider($this->sqldatattntdetail,array(
			'totalItemCount'=>$sqlcountttntdetail,
			'keyField'=>'ttntdetailid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'ttntdetailid', 'invoiceno','sono','fullname','gino','amount','payamount','sales','umur'
        ),
				'defaultOrder' => array( 
					'ttntid' => CSort::SORT_ASC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderttntdetail'=>$dataProviderttntdetail));
	}
	
	public function actionDownPDF()
  {
    parent::actionDownPDF();
    ob_start();
    $sql = "select a.ttntid,a.companyid,a.docno,b.fullname as employeename,a.docdate
				from ttnt a 
				inner join employee b on b.employeeid = a.employeeid ";
    if ($_GET['ttntid'] !== '') {
      $sql = $sql . "where a.ttntid in (" . $_GET['ttntid'] . ")";
    }
    $command             = Yii::app()->db->createCommand($sql);
    $dataReader          = $command->queryAll();
		foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $row['companyid'];
    }
    $this->pdf->isheader = false;
    $this->pdf->AddPage('L', 'Letter');
    foreach ($dataReader as $row) {
			$digit = substr($row['docno'],-4);
        $string = ltrim($digit,'0');
        $nilai = eja($string);
        $x = str_replace('Koma','',$nilai);
      $i      = 0;
      $total2 = 0;
      $this->pdf->SetFont('Arial', '', 12);
      $this->pdf->text(10, $this->pdf->gety() + 0, 'Tanda Terima Nota Tagihan');
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'TTNT No. ');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['docno'].' ( '.$x.')');
      $this->pdf->text(10, $this->pdf->gety() + 10, 'TTNT Date ');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Sales ');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['employeename']);
      $sql1        = "select distinct e.addressbookid,e.fullname
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					where a.ttntid = " . $row['ttntid'] . " order by fullname ";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        8,
        40,
        17,
        21,
        17,
        25,
        20,
        20,
        20,
        20,
        20,
        20,
        20
      ));
      $this->pdf->setbordercell(array(
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB'
      ));
      $this->pdf->colheader = array(
        'No.',
        'Customer',
        'Tgl. Inv.',
        'No. Inv.',
        'Tgl. JTT',
        'Nilai Inv.',
        'Tunai',
        'Bank',
        'Diskon',
        'Retur',
        'Ov. Booking',
        'Sisa',
        'Ket.'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
        'L',
        'C',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $total               = 0;
        $this->pdf->colalign = array(
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C',
          'C'
        );
        $this->pdf->setwidths(array(
          8,
          40,
          17,
          21,
          17,
          25,
          20,
          20,
          20,
          20,
          20,
          20,
          20
        ));
        $this->pdf->setbordercell(array(
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB'
        ));
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'C',
          'L',
          'C',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        $sql2        = "select b.invoiceno,d.sono,e.fullname,b.invoicedate,adddate(b.invoicedate,f.paydays) as jatuhtempo, a.amount,
					b.amount-ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=getwfmaxstatbywfname('appcutar') and f.invoiceid=a.invoiceid and g.docdate <= h.docdate),0) as saldoinvoice
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					join ttnt h on h.ttntid=a.ttntid
					where a.ttntid = " . $row['ttntid'] . " and e.addressbookid = " . $row1['addressbookid'] . " order by fullname ";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['fullname'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
            $row2['invoiceno'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo'])),
            number_format($row2['saldoinvoice'],4,',','.'),
            '',
            '',
            '',
            '',
            '',
            '',
            ''
          ));
          $total += $row2['saldoinvoice'];
        }
        $this->pdf->setwidths(array(
          103,
          25,
          20,
          20,
          20,
          20,
          20,
          20,
          20
        ));
        $this->pdf->setbordercell(array(
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB',
          'LTRB'
        ));
        $this->pdf->coldetailalign = array(
          'R',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->row(array(
          'TOTAL ' . $row1['fullname'] . '  >>> ',
          number_format($total,4,',','.'),
          '',
          '',
          '',
          '',
          '',
          '',
          ''
        ));
        $total2 += $total;
      }
      $this->pdf->setwidths(array(
        103,
        25,
        20,
        20,
        20,
        20,
        20,
        20,
        20
      ));
      $this->pdf->setbordercell(array(
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB',
        'LTRB'
      ));
      $this->pdf->coldetailalign = array(
        'C',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->row(array(
        'GRAND TOTAL  >>> ',
        number_format($total2,4,',','.'),
        '',
        '',
        '',
        '',
        '',
        '',
        ''
      ));
      $this->pdf->checkNewPage(15);
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->text(35, $this->pdf->gety(), '        PENYERAHAN INVOICE');
      $this->pdf->text(125, $this->pdf->gety(), 'FISIK UANG TUNAI');
      $this->pdf->text(200, $this->pdf->gety(), '    PENGEMBALIAN INVOICE');
      $this->pdf->text(15, $this->pdf->gety() + 4, '       Diserahkan oleh,');
      $this->pdf->text(70, $this->pdf->gety() + 4, '     Diterima oleh,');
      $this->pdf->text(125, $this->pdf->gety() + 4, '     Diterima oleh,');
      $this->pdf->text(180, $this->pdf->gety() + 4, ' Diserahkan oleh,');
      $this->pdf->text(235, $this->pdf->gety() + 4, '    Diterima oleh,');
      $this->pdf->text(15, $this->pdf->gety() + 25, '     ..............................');
      $this->pdf->text(70, $this->pdf->gety() + 25, ' ..............................');
      $this->pdf->text(125, $this->pdf->gety() + 25, '..............................');
      $this->pdf->text(180, $this->pdf->gety() + 25, '..............................');
      $this->pdf->text(235, $this->pdf->gety() + 25, '..............................');
      $this->pdf->text(24, $this->pdf->gety() + 28, 'Admin AR');
      $this->pdf->text(78, $this->pdf->gety() + 28, 'Sales');
      $this->pdf->text(129, $this->pdf->gety() + 28, 'Admin Kasir');
      $this->pdf->text(188, $this->pdf->gety() + 28, 'Sales');
      $this->pdf->text(240, $this->pdf->gety() + 28, 'Admin AR');
    }
    $this->pdf->Output();
  }
/*	public function actionDownPDF()
	{
	  parent::actionDownPDF();
		//masukkan perintah download
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
	  $this->pdf->isheader=false;
	  $this->pdf->AddPage('L','Letter');

		foreach($dataReader as $row)
    {
			$i=0;$total2=0;
			$this->pdf->SetFont('Arial','B',12);
			$this->pdf->text(10,$this->pdf->gety()+0,'Tanda Terima Nota Tagihan');
			$this->pdf->SetFont('Arial','B',9);
      $this->pdf->text(10,$this->pdf->gety()+5,'TTNT No. ');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['docno']);
      $this->pdf->text(10,$this->pdf->gety()+10,'TTNT Date ');$this->pdf->text(30,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(10,$this->pdf->gety()+15,'Sales ');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['fullname']);

			$sql1 = "select distinct e.addressbookid,e.fullname
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					where a.ttntid = ".$row['ttntid']." order by fullname ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+20);
			$this->pdf->setFont('Arial','B',7);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(8,40,17,20,17,25,20,20,20,20,20,20,20));
			$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->colheader = array('No.','Customer','Tgl. Inv.','No. Inv.', 'Tgl. JTT','Nilai Inv.',
				'Tunai','Bank','Diskon','Retur','Over Booking','Sisa','Ket.');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R','R','R','R','R','R');
			$this->pdf->setFont('Arial','',8);
			
			foreach($dataReader1 as $row1)
			{	
				$total = 0;
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(8,40,17,20,17,25,20,20,20,20,20,20,20));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R','R','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				
				$sql2 = "select b.invoiceno,d.sono,e.fullname,b.invoicedate,adddate(b.invoicedate,f.paydays) as jatuhtempo, a.amount,
					b.amount-ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=getwfmaxstatbywfname('appcutar') and f.invoiceid=a.invoiceid and g.docdate < h.docdate),0) as saldoinvoice
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					join ttnt h on h.ttntid=a.ttntid
					where a.ttntid = ".$row['ttntid']." and e.addressbookid = ".$row1['addressbookid']." order by fullname ";
			$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				foreach($dataReader2 as $row2)
				{
					$i+=1;
					$this->pdf->row(array($i,$row2['fullname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
						$row2['invoiceno'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo'])),
						Yii::app()->format->formatNumber($row2['saldoinvoice']),
						'','','','','','','',
						));
					$total += $row2['saldoinvoice'];
				}
				$this->pdf->setwidths(array(102,25,20,20,20,20,20,20,20));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->coldetailalign = array('R','R','R','R','R','R','R','R','R');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array('TOTAL '.$row1['fullname'].'  >>> ',
					Yii::app()->format->formatNumber($total),
					'','','','','','',''));
				$total2 += $total;
			}
			
			$this->pdf->setwidths(array(102,25,20,20,20,20,20,20,20));
			$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array('GRAND TOTAL  >>> ',
				Yii::app()->format->formatNumber($total2),
				'','','','','','',''));

			$this->pdf->checkNewPage(15);
								 
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->text(35,$this->pdf->gety(),'        PENYERAHAN INVOICE');
			$this->pdf->text(125,$this->pdf->gety(),'FISIK UANG TUNAI');
			$this->pdf->text(200,$this->pdf->gety(),'    PENGEMBALIAN INVOICE');
			
			$this->pdf->text(15,$this->pdf->gety()+4,'       Diserahkan oleh,');
			$this->pdf->text(70,$this->pdf->gety()+4,'     Diterima oleh,');
			$this->pdf->text(125,$this->pdf->gety()+4,'     Diterima oleh,');
			$this->pdf->text(180,$this->pdf->gety()+4,' Diserahkan oleh,');
			$this->pdf->text(235,$this->pdf->gety()+4,'    Diterima oleh,');
			
			$this->pdf->text(15,$this->pdf->gety()+25,'     ..............................');
			$this->pdf->text(70,$this->pdf->gety()+25,' ..............................');
			$this->pdf->text(125,$this->pdf->gety()+25,'..............................');
			$this->pdf->text(180,$this->pdf->gety()+25,'..............................');
			$this->pdf->text(235,$this->pdf->gety()+25,'..............................');
			
			$this->pdf->text(24,$this->pdf->gety()+28,'Admin AR');
			$this->pdf->text(78,$this->pdf->gety()+28,'Sales');
			$this->pdf->text(129,$this->pdf->gety()+28,'Admin Kasir');
			$this->pdf->text(188,$this->pdf->gety()+28,'Sales');
			$this->pdf->text(240,$this->pdf->gety()+28,'Admin AR');
		}
	  $this->pdf->Output();
	}
*/
}