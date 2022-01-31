<?php

class RepaccpayController extends AdminController
{
	protected $menuname = 'repaccpay';		
	public $module = 'accounting';
	protected $pageTitle = 'Report AP';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
  {
    parent::actionDownPDF();
    if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['supplier']) && isset($_GET['invoice']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1)
			{
        $this->RincianBiayaEkspedisiPerDokumen($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 2)
			{
        $this->RekapBiayaEkspedisiPerDokumen($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 3)
			{
        $this->RekapBiayaEkspedisiPerBarang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } 
			else
			if ($_GET['lro'] == 4)
			{
        $this->RincianPembayaranHutangPerDokumen($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 5)
			{
        $this->KartuHutang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 6)
			{
        $this->RekapHutangPerSupplier($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 7)
			{
        $this->RincianPembeliandanReturBeliBelumLunas($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 8)
			{
        $this->RincianUmurHutangperSTTB($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 9)
			{
        $this->RekapUmurHutangperSupplier($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 10)
			{
        $this->RekapInvoiceAPPerDokumenBelumStatusMax($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 11)
			{
        $this->RekapPermohonanPembayaranPerDokumenBelumStatusMax($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 12)
			{
        $this->RekapNotaReturPembelianPerDokumenBelumStatusMax($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
    }
  }
	//1
  public function RincianBiayaEkspedisiperDokumen($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $grandqty   = 0;
    $grandtotal = 0;
    $grandbiaya = 0;
    $sql        = "select distinct a.ekspedisiid,a.ekspedisino, a.docdate as tanggal,c.pono
					from ekspedisi a
					join ekspedisipo b on b.ekspedisiid = a.ekspedisiid
					join poheader c on c.poheaderid = b.poheaderid
					join eksmat d on d.ekspedisiid = a.ekspedisiid
					join productplant e on e.productid = d.productid
					join sloc f on f.slocid = e.slocid
					join product g on g.productid = d.productid
					where a.companyid = " . $companyid . " and a.recordstatus = 3
					and f.sloccode like '%" . $sloc . "%' and g.productname like '%" . $product . "%'
					and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Biaya Ekspedisi Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['ekspedisino']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'No. PO');
      $this->pdf->text(40, $this->pdf->gety() + 15, ': ' . $row['pono']);
      $this->pdf->text(130, $this->pdf->gety() + 10, 'Tanggal');
      $this->pdf->text(160, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
      $sql1        = "select a.ekspedisino,c.qty,c.expense as biaya,d.productname,d.productid,f.uomcode,
						(select zz.netprice
							from podetail zz
							where zz.poheaderid = b.poheaderid and zz.productid = c.productid limit 1) as harga
						from ekspedisi a
						join ekspedisipo b on b.ekspedisiid = a.ekspedisiid
						join eksmat c on c.ekspedisiid = a.ekspedisiid
						join product d on d.productid = c.productid
						join productplant e on e.productid = d.productid
						join unitofmeasure f on f.unitofmeasureid = c.uomid
						join poheader g on g.poheaderid = b.poheaderid
						join podetail h on h.poheaderid = g.poheaderid
						join sloc i on i.slocid = h.slocid
						where a.companyid = " . $companyid . " and a.recordstatus = 3
						and a.ekspedisiid = '" . $row['ekspedisiid'] . "' and d.productname like '%" . $product . "%' and i.sloccode like '%" . $sloc . "%'
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                        and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' group by productname";
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $total       = 0;
      $biaya       = 0;
      $this->pdf->sety($this->pdf->gety() + 18);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        60,
        30,
        30,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty',
        'Jumlah',
        'Biaya Ekspedisi'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          Yii::app()->format->formatNumber($row1['qty'] * $row1['harga']),
          Yii::app()->format->formatNumber($row1['biaya'])
        ));
        $totalqty += $row1['qty'];
        $total += ($row1['qty'] * $row1['harga']);
        $biaya += $row1['biaya'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->format->formatNumber($total),
        Yii::app()->format->formatNumber($biaya)
      ));
      $grandqty += $totalqty;
      $grandtotal += $total;
      $grandbiaya += $biaya;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->colalign = array(
      'C',
      'R',
      'R',
      'R'
    );
    $this->pdf->setwidths(array(
      15,
      45,
      60,
      60
    ));
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      '',
      'GRAND QTY:  ' . Yii::app()->format->formatCurrency($grandqty),
      'GRAND JUMLAH:   ' . Yii::app()->format->formatCurrency($grandtotal),
      'GRAND BIAYA:  ' . Yii::app()->format->formatCurrency($grandbiaya)
    ));
    $this->pdf->Output();
  }
  //2
	public function RekapBiayaEkspedisiPerDokumen($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.ekspedisino as dokumen,a.docdate as tanggal,a.amount as biaya,i.fullname as supplier , j.invoiceno as no_doc,l.productname,m.sloccode,
                         (select sum(zz.qty*(select xx.netprice
                         from podetail xx
                         where xx.poheaderid = c.poheaderid
                         and xx.productid = zz.productid))
                         from eksmat zz
                         left join ekspedisipo b on b.ekspedisipoid = zz.ekspedisipoid
                         left join poheader c on c.poheaderid = b.poheaderid
                         left join addressbook f on f.addressbookid = c.poheaderid                   
                         where zz.ekspedisiid = a.ekspedisiid) as jumlah
                         from ekspedisi a
                         join ekspedisipo g on g.ekspedisiid = a.ekspedisiid
                         join poheader h on h.poheaderid = g.poheaderid 
                         join addressbook i on i.addressbookid = h.addressbookid
                         left join invoiceap j on j.addressbookid = h.addressbookid
                     	 left join podetail k on k.podetailid = h.poheaderid
                     	 left join product l on l.productid = k.productid
                     	 left join sloc m on m.slocid = k.slocid
                     	 
                         where a.ekspedisino is not null and a.recordstatus = 3 and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
                         and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.sloccode like '%" . $sloc . "%' and l.productname like '%" . $product . "%' and j.invoiceno like '%" . $invoice . "%' and i.fullname like '%" . $supplier . "%' and a.ekspedisiid in
                         (select d.ekspedisiid from ekspedisipo d
                         left join poheader p on p.poheaderid = d.poheaderid
                         where p.companyid =  " . $companyid . ")";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Biaya Ekspedisi Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
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
      10,
      25,
      25,
      50,
      25,
      25,
      30
    ));
    $this->pdf->colheader = array(
      'No',
      'No Bukti',
      'Tanggal',
      'Supplier',
      'No.Dokumen',
      'Jumlah',
      'Biaya Ekspedisi'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'C',
      'C',
      'C',
      'R',
      'R'
    );
    $total                     = 0;
    $i                         = 0;
    $biaya                     = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->row(array(
        $i,
        $row['dokumen'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])),
        $row['supplier'],
        $row['no_doc'],
        Yii::app()->format->formatCurrency($row['jumlah']),
        Yii::app()->format->formatCurrency($row['biaya'])
      ));
      $total += $row['jumlah'];
      $biaya += $row['biaya'];
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      '',
      Yii::app()->format->formatNumber($total),
      Yii::app()->format->formatNumber($biaya)
    ));
    $this->pdf->checkPageBreak(20);
    $this->pdf->Output();
  }
  //3
	
	//4
	public function RincianPembayaranHutangPerDokumen($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
	{
      parent::actionDownPDF();
      $totalamount1=0;$totalpayamount1=0;$totalsisa1=0;
      $sql = "select distinct e.cashbankoutno,e.cashbankoutid,e.docdate as cbdate,f.reqpayno,f.docdate as rpdate
              from cashbankout e
              join cbapinv a on a.cashbankoutid=e.cashbankoutid
              join invoiceap b on b.invoiceapid=a.invoiceapid
              join addressbook c on c.addressbookid=b.addressbookid
              join account d on d.accountid=a.accountid
              join reqpay f on f.reqpayid=e.reqpayid
              where e.recordstatus=3 and e.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.cashbankoutno like '%".$invoice."%'
              and e.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
              order by cashbankoutno";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
        $this->pdf->title='Rincian Pembayaran Hutang Per Dokumen';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');		
               
		foreach($dataReader as $row)
        {
          $this->pdf->setFont('Arial','B',9);
          $this->pdf->text(10,$this->pdf->gety()+2,'No ');
          $this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cashbankoutno']);
          $this->pdf->text(160,$this->pdf->gety()+2,'No ');
          $this->pdf->text(170,$this->pdf->gety()+2,': '.$row['reqpayno']);
          $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');
          $this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cbdate'])));
          $this->pdf->text(160,$this->pdf->gety()+6,'Tgl ');
          $this->pdf->text(170,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['rpdate'])));
          $sql1 = " select b.invoiceno,c.fullname,b.invoicedate,b.amount,a.payamount,d.accountname,b.amount - a.payamount as sisa
                    from cbapinv a
                    join invoiceap b on b.invoiceapid=a.invoiceapid
                    join addressbook c on c.addressbookid=b.addressbookid
                    join account d on d.accountid=a.accountid
                    where a.cashbankoutid = '".$row['cashbankoutid']."'  ";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          
          $this->pdf->setFont('Arial','',8);
          $this->pdf->sety($this->pdf->gety()+10);    
          $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
          $this->pdf->setwidths(array(10,30,60,20,35,35,50,35));
          $this->pdf->colheader = array('No','No Invoice','Customer','Tgl Invoice','Saldo Invoice','Nilai bayar','Akun','Sisa');
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array('C','L','L','C','R','R','R','R','R');
          $i=0;$totalamount=0;$totalpayamount=0;$totalsisa=0; 
          foreach ($dataReader1 as $row1)
          {
            $i=$i+1;
				$this->pdf->row(array($i,$row1['invoiceno'],
				$row1['fullname'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
				Yii::app()->format->formatCurrency($row1['amount']/$per),						
				Yii::app()->format->formatCurrency($row1['payamount']/$per),                        
				$row1['accountname'],
				Yii::app()->format->formatCurrency($row1['sisa']/$per ),
				));
            $totalamount += ($row1['amount']/$per);
            $totalpayamount += ($row1['payamount']/$per);
            $totalsisa += ($row1['sisa']/$per );

          } 
          $this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array('','TOTAL ',$row['cashbankoutno'],'',
			Yii::app()->format->formatCurrency($totalamount),					
			Yii::app()->format->formatCurrency($totalpayamount),'',
			Yii::app()->format->formatCurrency($totalsisa)));
          $this->pdf->sety($this->pdf->gety()+5); 
          
          $totalamount1 += $totalamount;
          $totalpayamount1 += $totalpayamount;
          $totalsisa1 += $totalsisa;
          $this->pdf->checkPageBreak(25);          
        }
        
        $this->pdf->setFont('Arial','BI',10);
		$this->pdf->row(array('','','GRAND TOTAL','',
			Yii::app()->format->formatCurrency($totalamount1),					
			Yii::app()->format->formatCurrency($totalpayamount1),'',
			Yii::app()->format->formatCurrency($totalsisa1)));
    
      $this->pdf->Output();
	}
  //5
	public function KartuHutang($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $penambahan1 = 0;
    $dibayar1    = 0;
    $bank1       = 0;
    $diskon1     = 0;
    $retur1      = 0;
    $ob1         = 0;
    $saldo1      = 0;
    $sql         = "select distinct addressbookid,fullname,saldoawal
						from (select a.addressbookid,a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as dibayar
						from addressbook a where a.fullname like '%" . $supplier . "%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Kartu Hutang';
    $this->pdf->subtitle = 'Dari Tgl : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, $row['fullname']);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        25,
        20,
        40,
        35,
        35,
        35
      ));
      $this->pdf->colheader = array(
        'Dokumen',
        'Tanggal',
        'U/ Byr INV',
        'Penambahan',
        'Dibayar',
        'Saldo'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
        'C',
        'C',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->sety($this->pdf->gety() + 0);
      $this->pdf->row(array(
        'Saldo Awal',
        '',
        '',
        '',
        '',
        Yii::app()->format->formatCurrency($row['saldoawal'] / $per)
      ));
      $penambahan  = 0;
      $dibayar     = 0;
      $bank        = 0;
      $diskon      = 0;
      $retur       = 0;
      $ob          = 0;
      $sql2        = "select * from
				(select a.invoiceno as dokumen,a.invoicedate as tanggal,ifnull(b.grno,'-') as ref,a.amount as penambahan,'0' as dibayar
				from invoiceap a
				join grheader b on b.grheaderid=a.grheaderid
				join poheader c on c.poheaderid=b.poheaderid
				where a.recordstatus=3 and a.companyid=" . $companyid . " 
				and a.addressbookid=" . $row['addressbookid'] . "
				and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					union
				select d.cashbankoutno as dokumen,d.docdate as tanggal,concat(ifnull(h.grno,'-'),' / ',ifnull(g.invoiceno,'-')) as ref,'0' as penambahan,c.payamount as dibayar
				from cbapinv c
				join cashbankout d on d.cashbankoutid=c.cashbankoutid
				join invoiceap g on g.invoiceapid=c.invoiceapid
				join grheader h on h.grheaderid=g.grheaderid
				where d.recordstatus=3
				and d.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and c.invoiceapid in (select b.invoiceapid
				from invoiceap b
				join grheader e on e.grheaderid=b.grheaderid
				join poheader f on f.poheaderid=e.poheaderid
				where b.recordstatus=3
				and b.companyid=" . $companyid . " and b.addressbookid = " . $row['addressbookid'] . "
				and b.receiptdate<='" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
				) z
				order by tanggal,dokumen";
		$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
      foreach ($dataReader2 as $row2) {
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->row(array(
          $row2['dokumen'],
          date(Yii::app()->params['dateviewfromdb'], strtotime($row2['tanggal'])),
          $row2['ref'],
          Yii::app()->format->formatCurrency($row2['penambahan'] / $per),
          Yii::app()->format->formatCurrency(-$row2['dibayar'] / $per),
          ''
        ));
        $penambahan += $row2['penambahan'] / $per;
        $dibayar += $row2['dibayar'] / $per;
      }
      $this->pdf->SetFont('Arial', 'B', 8);
      $this->pdf->setwidths(array(
        85,
        35,
        35,
        35,
        30,
        30,
        30,
        30
      ));
      $this->pdf->coldetailalign = array(
        'C',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R',
        'R'
      );
      $this->pdf->row(array(
        'TOTAL ' . $row['fullname'],
        Yii::app()->format->formatCurrency($penambahan),
        Yii::app()->format->formatCurrency(-$dibayar),
        Yii::app()->format->formatCurrency($row['saldoawal'] / $per + $penambahan - $dibayar)
      ));
      $penambahan1 += $penambahan;
      $dibayar1 += $dibayar;
      $saldo1 += $row['saldoawal'] / $per;
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->checkPageBreak(5);
    }
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->setwidths(array(
      50,
      35,
      35,
      35,
      35,
      30,
      30,
      30,
      30
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
    $this->pdf->row(array(
      '',
      'Saldo Awal',
      'Penambahan',
      'Dibayar',
      'Saldo Akhir'
    ));
    $this->pdf->SetFont('Arial', 'BI', 8);
    $this->pdf->setwidths(array(
      50,
      35,
      35,
      35,
      35,
      30,
      30,
      30,
      30
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
    $this->pdf->row(array(
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($saldo1),
      Yii::app()->format->formatCurrency($penambahan1),
      Yii::app()->format->formatCurrency(-$dibayar1),
      Yii::app()->format->formatCurrency($saldo1 + $penambahan1 - $dibayar1)
    ));
    $this->pdf->Output();
  }
  //6
	public function RekapHutangPerSupplier($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql        = "select *
						from (select a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as dibayar
						from addressbook a where a.fullname like '%" . $supplier . "%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Hutang Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
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
      10,
      50,
      30,
      30,
      30,
      40
    ));
    $this->pdf->colheader = array(
      'No',
      'Supplier',
      'Saldo Awal',
      'Hutang',
      'Dibayar',
      'Saldo Akhir'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'R',
      'R',
      'R',
      'R'
    );
    $i                         = 0;
    $saldoawal                 = 0;
    $hutang                    = 0;
    $dibayar                   = 0;
    $saldoakhir                = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['saldoawal'] / $per),
        Yii::app()->format->formatCurrency($row['hutang'] / $per),
        Yii::app()->format->formatCurrency($row['dibayar'] / $per),
        Yii::app()->format->formatCurrency(($row['saldoawal'] + $row['hutang'] - $row['dibayar']) / $per)
      ));
      $saldoawal += $row['saldoawal'] / $per;
      $hutang += $row['hutang'] / $per;
      $dibayar += $row['dibayar'] / $per;
      $saldoakhir += ($row['saldoawal'] + $row['hutang'] - $row['dibayar']) / $per;
    }
    $this->pdf->setFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      '',
      'TOTAL',
      Yii::app()->format->formatCurrency($saldoawal),
      Yii::app()->format->formatCurrency($hutang),
      Yii::app()->format->formatCurrency($dibayar),
      Yii::app()->format->formatCurrency($saldoakhir)
    ));
    $this->pdf->Output();
  }
  //7
	public function RincianPembeliandanReturBeliBelumLunas($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $nilaitot1  = 0;
    $dibayar1   = 0;
    $sisa1      = 0;
    $sql        = "select distinct addressbookid,fullname
					from (select *
					from (select d.addressbookid, d.fullname, a.amount,
					ifnull((select sum(payamount) from cbapinv j
					left join cashbankout k on k.cashbankoutid=j.cashbankoutid
					where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
					and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					group by invoiceapid),0) as payamount
					from invoiceap a
					left join grheader b on b.grheaderid = a.grheaderid
					join poheader c on c.poheaderid = a.poheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . " 
					and d.fullname like '%" . $supplier . "%'
					and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
					where amount > payamount) zz
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pembelian & Retur Beli Belum Lunas';
    $this->pdf->subtitle = 'Per Tanggal : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 0);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, $row['fullname']);
      $sql1        = "select *
				from (select a.invoiceno,b.grno,a.invoicedate,e.paydays,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
				datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,a.amount, 
				ifnull((select sum(payamount) from cbapinv j
				left join cashbankout k on k.cashbankoutid=j.cashbankoutid
				where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
				and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				group by invoiceapid),0) as payamount
				from invoiceap a
				left join grheader b on b.grheaderid = a.grheaderid
				inner join poheader c on c.poheaderid = a.poheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
				and d.addressbookid = '" . $row['addressbookid'] . "'						
				and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where z.amount > z.payamount
				order by invoicedate,invoiceno";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 7);
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
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        20,
        22,
        20,
        20,
        10,
        30,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Dokumen',
        'Referensi',
        'Tanggal',
        'j_tempo',
        'Umur',
        'Nilai',
        'Kum_bayar',
        'Sisa'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      $i        = 0;
      $nilaitot = 0;
      $dibayar  = 0;
      $sisa     = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['invoiceno'],
          $row1['grno'],
          date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
          date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
          $row1['umur'],
          Yii::app()->format->formatCurrency($row1['amount'] / $per),
          Yii::app()->format->formatCurrency($row1['payamount'] / $per),
          Yii::app()->format->formatCurrency(($row1['amount'] / $per) - ($row1['payamount'] / $per))
        ));
        $nilaitot += $row1['amount'] / $per;
        $dibayar += $row1['payamount'] / $per;
        $sisa += (($row1['amount'] / $per) - ($row1['payamount'] / $per));
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'Total:',
        '',
        Yii::app()->format->formatCurrency($nilaitot),
        Yii::app()->format->formatCurrency($dibayar),
        Yii::app()->format->formatCurrency($sisa)
      ));
      $nilaitot1 += $nilaitot;
      $dibayar1 += $dibayar;
      $sisa1 += $sisa;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'BI', 9);
    $this->pdf->coldetailalign = array(
      'R',
      'R',
      'R',
      'R'
    );
    $this->pdf->setwidths(array(
      95,
      30,
      35,
      30
    ));
    $this->pdf->row(array(
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($nilaitot1),
      Yii::app()->format->formatCurrency($dibayar1),
      Yii::app()->format->formatCurrency($sisa1)
    ));
    $this->pdf->Output();
  }
  //8
	public function RincianUmurHutangperSTTB($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $total2sd0    = 0;
    $total20sd30  = 0;
    $total231sd60 = 0;
    $total261sd90 = 0;
    $total2sd90   = 0;
    $totaltempo2  = 0;
    $total2       = 0;
    $sql          = "select distinct addressbookid,fullname
					from (select *
					from (select d.addressbookid, d.fullname, a.amount,
					ifnull((select sum(payamount) from cbapinv j
					left join cashbankout k on k.cashbankoutid=j.cashbankoutid
					where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
					and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					group by invoiceapid),0) as payamount
					from invoiceap a
					join grheader b on b.grheaderid = a.grheaderid
					join poheader c on c.poheaderid = b.poheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . " 
					and d.fullname like '%" . $supplier . "%'
					and a.invoicedate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
					where amount > payamount) zz
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Umur Hutang Per Supplier';
    $this->pdf->subtitle = 'Per Tanggal : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    $this->pdf->sety($this->pdf->gety() + 0);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 3, ': ' . $row['fullname']);
      $sql1        = "select z.*,
														case when umurtempo < 0 then totamount else 0 end as sd0,
														case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
														case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
														case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
														case when umurtempo > 90 then totamount else 0 end as sd90
												from
												(select concat(ifnull(a.invoiceno,'-'),' / ',ifnull(b.grno,'-')) as invoiceno, a.invoicedate,
												datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,
												datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												a.amount-ifnull((select sum(payamount) from cbapinv j
												left join cashbankout k on k.cashbankoutid=j.cashbankoutid
												where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
												and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
												group by invoiceapid),0) as totamount,e.paydays
												from invoiceap a
												inner join grheader b on b.grheaderid = a.grheaderid
												inner join poheader c on c.poheaderid = b.poheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
												and d.addressbookid = '" . $row['addressbookid'] . "'						
												and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z
												where totamount > 0";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 6);
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->colalign = array(
        'L',
        'L',
        'L',
        'L',
        'L',
        'L',
        'C',
        'R',
        'R'
      );
      $this->pdf->setwidths(array(
        10,
        55,
        12,
        12,
        27,
        27,
        81,
        27,
        32
      ));
      $this->pdf->colheader = array(
        '|',
        '|',
        '|',
        '|',
        '|',
        '|',
        'Sudah Jatuh Tempo',
        '|',
        '|'
      );
      $this->pdf->RowHeader();
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
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        55,
        12,
        12,
        27,
        27,
        27,
        27,
        27,
        27,
        32
      ));
      $this->pdf->colheader = array(
        'No',
        'No Invoice',
        'T.O.P',
        'Umur',
        'Belum JTT',
        '0-30 Hari',
        '31-60 Hari',
        '61-90 Hari',
        '> 90 Hari',
        'Jumlah',
        'Total'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'C',
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
      $this->pdf->setFont('Arial', '', 8);
      $totalsd0    = 0;
      $total0sd30  = 0;
      $total31sd60 = 0;
      $total61sd90 = 0;
      $totalsd90   = 0;
      $totaltempo  = 0;
      $total       = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['invoiceno'],
          $row1['paydays'],
          $row1['umur'],
          Yii::app()->format->formatCurrency($row1['sd0'] / $per),
          Yii::app()->format->formatCurrency($row1['0sd30'] / $per),
          Yii::app()->format->formatCurrency($row1['31sd60'] / $per),
          Yii::app()->format->formatCurrency($row1['61sd90'] / $per),
          Yii::app()->format->formatCurrency($row1['sd90'] / $per),
          Yii::app()->format->formatCurrency(($row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per),
          Yii::app()->format->formatCurrency(($row1['sd0'] + $row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per)
        ));
        $totalsd0 += $row1['sd0'] / $per;
        $total0sd30 += $row1['0sd30'] / $per;
        $total31sd60 += $row1['31sd60'] / $per;
        $total61sd90 += $row1['61sd90'] / $per;
        $totalsd90 += $row1['sd90'] / $per;
        $totaltempo += ($row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per;
        $total += ($row1['sd0'] + $row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per;
      }
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->row(array(
        '',
        'TOTAL ' . $row['fullname'],
        '',
        '',
        Yii::app()->format->formatCurrency($totalsd0),
        Yii::app()->format->formatCurrency($total0sd30),
        Yii::app()->format->formatCurrency($total31sd60),
        Yii::app()->format->formatCurrency($total61sd90),
        Yii::app()->format->formatCurrency($totalsd90),
        Yii::app()->format->formatCurrency($totaltempo),
        Yii::app()->format->formatCurrency($total)
      ));
      $total2sd0 += $totalsd0;
      $total20sd30 += $total0sd30;
      $total231sd60 += $total31sd60;
      $total261sd90 += $total61sd90;
      $total2sd90 += $totalsd90;
      $totaltempo2 += $totaltempo;
      $total2 += $total;
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->checkPageBreak(30);
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->coldetailalign = array(
      'C',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R'
    );
    $this->pdf->setwidths(array(
      89,
      27,
      27,
      27,
      27,
      27,
      27,
      32
    ));
    $this->pdf->setFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'Grand Total :',
      Yii::app()->format->formatCurrency($total2sd0),
      Yii::app()->format->formatCurrency($total20sd30),
      Yii::app()->format->formatCurrency($total231sd60),
      Yii::app()->format->formatCurrency($total261sd90),
      Yii::app()->format->formatCurrency($total2sd90),
      Yii::app()->format->formatCurrency($totaltempo2),
      Yii::app()->format->formatCurrency($total2)
    ));
    $this->pdf->Output();
  }
  //9
	public function RekapUmurHutangperSupplier($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql        = "select *,sum(sd0) as belumjatuhtempo, sum(0sd30) as sum0sd30,sum(31sd60) as sum31sd60, sum(61sd90) as sum61sd90, sum(sd90) as sumsd90
				from (select *,
				case when umurtempo < 0 then totamount else 0 end as sd0,
				case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
				case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
				case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
				case when umurtempo > 90 then totamount else 0 end as sd90
				from (select a.invoicedate,
				datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,
				datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,d.fullname,
				a.amount-ifnull((select sum(payamount) from cbapinv j
				left join cashbankout k on k.cashbankoutid=j.cashbankoutid
				where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
				and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				group by invoiceapid),0) as totamount,e.paydays
				from invoiceap a
				inner join grheader b on b.grheaderid = a.grheaderid
				inner join poheader c on c.poheaderid = b.poheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
				and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z 
				where totamount>0)zz
				group by fullname
				order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Umur Hutang Per Supplier';
    $this->pdf->subtitle = 'Per Tanggal : ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign = array(
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
      10,
      75,
      30,
      30,
      30,
      30,
      30,
      35
    ));
    $this->pdf->colheader = array(
      'No',
      'Nama Supplier',
      'Belum Jatuh Tempo',
      '0-30 Hari',
      '31-60 Hari',
      '61-90 Hari',
      '> 90 Hari',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R'
    );
    $totalsd0                  = 0;
    $total0sd30                = 0;
    $total31sd60               = 0;
    $total61sd90               = 0;
    $totalsd90                 = 0;
    $total                     = 0;
    $i                         = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->row(array(
        $i,
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['belumjatuhtempo'] / $per),
        Yii::app()->format->formatCurrency($row['sum0sd30'] / $per),
        Yii::app()->format->formatCurrency($row['sum31sd60'] / $per),
        Yii::app()->format->formatCurrency($row['sum61sd90'] / $per),
        Yii::app()->format->formatCurrency($row['sumsd90'] / $per),
        Yii::app()->format->formatCurrency(($row['belumjatuhtempo'] + $row['sum0sd30'] + $row['sum31sd60'] + $row['sum61sd90'] + $row['sumsd90']) / $per)
      ));
      $totalsd0 += $row['belumjatuhtempo'] / $per;
      $total0sd30 += $row['sum0sd30'] / $per;
      $total31sd60 += $row['sum31sd60'] / $per;
      $total61sd90 += $row['sum61sd90'] / $per;
      $totalsd90 += $row['sumsd90'] / $per;
      $total += ($row['belumjatuhtempo'] + $row['sum0sd30'] + $row['sum31sd60'] + $row['sum61sd90'] + $row['sumsd90']) / $per;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      '',
      'Total :',
      Yii::app()->format->formatCurrency($totalsd0),
      Yii::app()->format->formatCurrency($total0sd30),
      Yii::app()->format->formatCurrency($total31sd60),
      Yii::app()->format->formatCurrency($total61sd90),
      Yii::app()->format->formatCurrency($totalsd90),
      Yii::app()->format->formatCurrency($total)
    ));
    $this->pdf->checkPageBreak(20);
    $this->pdf->Output();
  }
  //10
	public function RekapInvoiceAPPerDokumenBelumStatusMax($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.invoiceapid, a.invoiceno,a.invoicedate, b.pono, b.headernote, a.statusname
				from invoiceap a
				join poheader b on b.poheaderid = a.poheaderid
				where a.invoicedate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and a.recordstatus between 1 and (3-1)
				and b.pono is not null
				and a.companyid = " . $companyid . "
				order by a.recordstatus";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Invoice AP Per Dokumen Belum Status Max';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      25,
      25,
      60,
      25,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'ID Transaksi',
      'No Transaksi',
      'Tanggal',
      'No Referensi',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $totalnominal1             = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['invoiceapid'],
        $row['invoiceno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
        $row['pono'],
        $row['headernote'],
        $row['statusname']
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //11
	public function RekapPermohonanPembayaranPerDokumenBelumStatusMax($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select a.reqpayid, a.reqpayno, a.docdate, a.headernote, a.recordstatus
				from reqpay a
				where a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
				and a.recordstatus between 1 and (6-1)
				and a.companyid = " . $companyid . "
				order by a.recordstatus";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Permohonan Pembayaran Per Dokumen Belum Status Max';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      25,
      25,
      60,
      25,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'ID Transaksi',
      'No Transaksi',
      'Tanggal',
      'No Referensi',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $totalnominal1             = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['reqpayid'],
        $row['reqpayno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        '',
        $row['headernote'],
        findstatusname("apppayreq", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //12
	public function RekapNotaReturPembelianPerDokumenBelumStatusMax($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select a.notagrreturid,a.notagrreturno,a.docdate,b.grreturno,a.headernote,a.recordstatus
				from notagrretur a
				join grretur b on b.grreturid=a.grreturid
				where a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and a.recordstatus between 1 and (3-1)
				and a.companyid = " . $companyid . "
				order by a.recordstatus";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Nota Retur Pembelian Per Dokumen Belum Status Max';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      25,
      25,
      60,
      25,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'ID Transaksi',
      'No Transaksi',
      'Tanggal',
      'No Referensi',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'L',
      'L'
    );
    $totalnominal1             = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['notagrreturid'],
        $row['notagrreturno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        $row['grreturno'],
        $row['headernote'],
        findstatusname("appcutar", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  
	
	
	public function actionDownXLS()
  {
    parent::actionDownXLS();
    if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['supplier']) && isset($_GET['invoice']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1)
			{
        $this->RincianBiayaEkspedisiPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 2)
			{
        $this->RekapBiayaEkspedisiPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 3)
			{
        $this->RekapBiayaEkspedisiPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 4)
			{
        $this->RincianPembayaranHutangPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else
			if ($_GET['lro'] == 5)
			{
        $this->KartuHutangXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 6)
			{
        $this->RekapHutangPerSupplierXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 7)
			{
        $this->RincianPembeliandanReturBeliBelumLunasXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 8)
			{
        $this->RincianUmurHutangperSTTBXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
			else
			if ($_GET['lro'] == 9)
			{
        $this->RekapUmurHutangperSupplierXLS($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['supplier'], $_GET['invoice'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }
    }
  }
  //1
	
	//2
	
	//3
	
	//4
	public function RincianPembayaranHutangPerDokumenXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpembayaranhutangperdokumen';
    parent::actionDownXLS();
    {
      $sql = "select distinct e.cashbankoutno,e.cashbankoutid,e.docdate as cbdate,f.reqpayno,f.docdate as rpdate
              from cashbankout e
              join cbapinv a on a.cashbankoutid=e.cashbankoutid
              join invoiceap b on b.invoiceapid=a.invoiceapid
              join addressbook c on c.addressbookid=b.addressbookid
              join account d on d.accountid=a.accountid
              join reqpay f on f.reqpayid=e.reqpayid
              where e.recordstatus=3 and e.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.cashbankoutno like '%".$invoice."%'
              and e.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
              order by cashbankoutno";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
      
        foreach($dataReader as $row)
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
            ->setCellValueByColumnAndRow(2,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
            ->setCellValueByColumnAndRow(7,1,GetCompanyCode($companyid));
        $line=4;
        $totalamount1=0;$totalpayamount1=0;$totalsisa1=0;       
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0,$line,'No :')
                    ->setCellValueByColumnAndRow(1,$line,$row['cashbankoutno'])
                    ->setCellValueByColumnAndRow(2,$line,'No :')
                    ->setCellValueByColumnAndRow(3,$line,$row['reqpayno']);														
            $line++;

            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,'Tgl :')
                ->setCellValueByColumnAndRow(1,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['cbdate'])))
                ->setCellValueByColumnAndRow(2,$line,'Tgl :')
                ->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['rpdate'])));														
            $line++;

            $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0,$line,'No')
                    ->setCellValueByColumnAndRow(1,$line,'No. Invoice')
                    ->setCellValueByColumnAndRow(2,$line,'Customer')					
                    ->setCellValueByColumnAndRow(3,$line,'Tgl Invoice')
                    ->setCellValueByColumnAndRow(4,$line,'Saldo Invoice')
                    ->setCellValueByColumnAndRow(5,$line,'Nilai Bayar')
                    ->setCellValueByColumnAndRow(6,$line,'Akun')
                    ->setCellValueByColumnAndRow(7,$line,'Sisa');
            $line++;
            $sql1 = " select b.invoiceno,c.fullname,b.invoicedate,b.amount,a.payamount,d.accountname,b.amount - a.payamount as sisa
                    from cbapinv a
                    join invoiceap b on b.invoiceapid=a.invoiceapid
                    join addressbook c on c.addressbookid=b.addressbookid
                    join account d on d.accountid=a.accountid
                    where a.cashbankoutid = '".$row['cashbankoutid']."'  ";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $i=0;$totalamount=0;$totalpayamount=0;$totalsisa=0;
          
          foreach($dataReader1 as $row1)
          {
            $i+=1;
            $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,$i)
              ->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
              ->setCellValueByColumnAndRow(2,$line,$row1['fullname'])
              ->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])))
              ->setCellValueByColumnAndRow(4,$line,$row1['amount'])
              ->setCellValueByColumnAndRow(5,$line,$row1['payamount'])					
              ->setCellValueByColumnAndRow(6,$line,$row1['accountname'])
              ->setCellValueByColumnAndRow(7,$line,$row1['sisa']);
            $line+=1;
            
            $totalamount += $row1['amount'];
            $totalpayamount += $row1['payamount'];
            $totalsisa += $row1['sisa'];
            
          }
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row['cashbankoutno'])										
              ->setCellValueByColumnAndRow(4,$line,($totalamount))
              ->setCellValueByColumnAndRow(5,$line,($totalpayamount))
              ->setCellValueByColumnAndRow(7,$line,($totalsisa));
          $line+=2;
          $totalamount1 += $totalamount;
          $totalpayamount1 += $totalpayamount;
          $totalsisa1 += $totalsisa;
          
		}
      
      $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL ')										
              ->setCellValueByColumnAndRow(4,$line,($totalamount1))
              ->setCellValueByColumnAndRow(5,$line,($totalpayamount1))
              ->setCellValueByColumnAndRow(7,$line,($totalsisa1));
      $line+=2;
    }
    
    
    $this->getFooterXLS($this->phpExcel);
  }
  //5
	public function KartuHutangXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'kartuhutang';
    parent::actionDownXLS();
    $penambahan1 = 0;
    $dibayar1    = 0;
    $bank1       = 0;
    $diskon1     = 0;
    $retur1      = 0;
    $ob1         = 0;
    $saldo1      = 0;
    $sql         = "select distinct addressbookid,fullname,saldoawal
						from (select a.addressbookid,a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as dibayar
						from addressbook a where a.fullname like '%" . $supplier . "%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row['fullname']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, 'Tanggal')->setCellValueByColumnAndRow(2, $line, 'U/ Byr INV')->setCellValueByColumnAndRow(3, $line, 'Penambahan')->setCellValueByColumnAndRow(4, $line, 'Dibayar')->setCellValueByColumnAndRow(5, $line, 'Saldo');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Saldo Awal')->setCellValueByColumnAndRow(5, $line, ($row['saldoawal'] / $per));
      $line++;
      $penambahan  = 0;
      $dibayar     = 0;
      $bank        = 0;
      $diskon      = 0;
      $retur       = 0;
      $ob          = 0;
      $sql1        = "select * from
				(select a.invoiceno as dokumen,a.invoicedate as tanggal,ifnull(b.grno,'-') as ref,a.amount as penambahan,'0' as dibayar
				from invoiceap a
				join grheader b on b.grheaderid=a.grheaderid
				join poheader c on c.poheaderid=b.poheaderid
				where a.recordstatus=3 and a.companyid=" . $companyid . " 
				and a.addressbookid=" . $row['addressbookid'] . "
				and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					union
				select d.cashbankoutno as dokumen,d.docdate as tanggal,concat(ifnull(h.grno,'-'),' / ',ifnull(g.invoiceno,'-')) as ref,'0' as penambahan,c.payamount as dibayar
				from cbapinv c
				join cashbankout d on d.cashbankoutid=c.cashbankoutid
				join invoiceap g on g.invoiceapid=c.invoiceapid
				join grheader h on h.grheaderid=g.grheaderid
				where d.recordstatus=3
				and d.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and c.invoiceapid in (select b.invoiceapid
				from invoiceap b
				join grheader e on e.grheaderid=b.grheaderid
				join poheader f on f.poheaderid=e.poheaderid
				where b.recordstatus=3
				and b.companyid=" . $companyid . " and b.addressbookid = " . $row['addressbookid'] . "
				and b.receiptdate<='" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
				) z
				order by tanggal,dokumen";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row1['dokumen'])->setCellValueByColumnAndRow(1, $line, $row1['tanggal'])->setCellValueByColumnAndRow(2, $line, $row1['ref'])->setCellValueByColumnAndRow(3, $line, ($row1['penambahan'] / $per))->setCellValueByColumnAndRow(4, $line, ($row1['dibayar'] / $per));
        $line++;
        $penambahan += $row1['penambahan'] / $per;
        $dibayar += $row1['dibayar'] / $per;
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total ' . $row['fullname'])->setCellValueByColumnAndRow(3, $line, ($penambahan))->setCellValueByColumnAndRow(4, $line, ($dibayar))->setCellValueByColumnAndRow(5, $line, (($row['saldoawal'] / $per) + $penambahan - $dibayar - $bank - $diskon - $retur - $ob));
      $line++;
      $penambahan1 += $penambahan;
      $dibayar1 += $dibayar;
      $saldo1 += $row['saldoawal'] / $per;
      $line += 1;
    }
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, ($saldo1))->setCellValueByColumnAndRow(3, $line, ($penambahan1))->setCellValueByColumnAndRow(4, $line, ($dibayar1))->setCellValueByColumnAndRow(5, $line, ($saldo1 + $penambahan1 - $dibayar1));
    $line++;
    $this->getFooterXLS($this->phpExcel);
  }
  //6
	public function RekapHutangPerSupplierXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekaphutangpersupplier';
    parent::actionDownXLS();
    $sql        = "select *
						from (select a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=" . $companyid . " and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as dibayar
						from addressbook a where a.fullname like '%" . $supplier . "%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $line = 4;
    $this->phpExcel->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold(true);
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Supplier')->setCellValueByColumnAndRow(2, $line, 'Saldo Awal')->setCellValueByColumnAndRow(3, $line, 'Hutang')->setCellValueByColumnAndRow(4, $line, 'Dibayar')->setCellValueByColumnAndRow(5, $line, 'Saldo Akhir');
    $line++;
    $i          = 0;
    $saldoawal  = 0;
    $hutang     = 0;
    $dibayar    = 0;
    $saldoakhir = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row['fullname'])->setCellValueByColumnAndRow(2, $line, ($row['saldoawal'] / $per))->setCellValueByColumnAndRow(3, $line, ($row['hutang'] / $per))->setCellValueByColumnAndRow(4, $line, ($row['dibayar'] / $per))->setCellValueByColumnAndRow(5, $line, (($row['saldoawal'] + $row['hutang'] - $row['dibayar']) / $per));
      $line++;
      $saldoawal += $row['saldoawal'] / $per;
      $hutang += $row['hutang'] / $per;
      $dibayar += $row['dibayar'] / $per;
      $saldoakhir += ($row['saldoawal'] + $row['hutang'] - $row['dibayar']) / $per;
    }
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'TOTAL')->setCellValueByColumnAndRow(2, $line, ($saldoawal))->setCellValueByColumnAndRow(3, $line, ($hutang))->setCellValueByColumnAndRow(4, $line, ($dibayar))->setCellValueByColumnAndRow(5, $line, ($saldoakhir));
    $line++;
    $line += 1;
    $this->getFooterXLS($this->phpExcel);
  }
  //7
	public function RincianPembeliandanReturBeliBelumLunasXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpembeliandanreturbelibelumlunas';
    parent::actionDownXLS();
    $nilaitot1  = 0;
    $dibayar1   = 0;
    $sisa1      = 0;
    $sql        = "select distinct addressbookid,fullname
          from (select *
          from (select d.addressbookid, d.fullname, a.amount,
          ifnull((select sum(payamount) from cbapinv j
          left join cashbankout k on k.cashbankoutid=j.cashbankoutid
          where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
          and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
          group by invoiceapid),0) as payamount
          from invoiceap a
          left join grheader b on b.grheaderid = a.grheaderid
          join poheader c on c.poheaderid = a.poheaderid
          join addressbook d on d.addressbookid = c.addressbookid
          where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . " 
          and d.fullname like '%" . $supplier . "%'
          and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
          where amount > payamount) zz
          order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row['fullname']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Dokumen')->setCellValueByColumnAndRow(2, $line, 'Referensi')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, 'j_tempo')->setCellValueByColumnAndRow(5, $line, 'Umur')->setCellValueByColumnAndRow(6, $line, 'Nilai')->setCellValueByColumnAndRow(7, $line, 'Kum_bayar')->setCellValueByColumnAndRow(8, $line, 'Sisa');
      $line++;
      $sql1        = "select *
        from (select a.invoiceno,b.grno,a.invoicedate,e.paydays,
        date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
        datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,a.amount, 
        ifnull((select sum(payamount) from cbapinv j
        left join cashbankout k on k.cashbankoutid=j.cashbankoutid
        where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
        and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
        group by invoiceapid),0) as payamount
        from invoiceap a
        left join grheader b on b.grheaderid = a.grheaderid
        inner join poheader c on c.poheaderid = a.poheaderid
        inner join addressbook d on d.addressbookid = c.addressbookid
        inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
        where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
        and d.addressbookid = '" . $row['addressbookid'] . "'           
        and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
        where z.amount > z.payamount
        order by invoicedate,invoiceno";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $nilaitot    = 0;
      $dibayar     = 0;
      $sisa        = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['invoiceno'])->setCellValueByColumnAndRow(2, $line, $row1['grno'])->setCellValueByColumnAndRow(3, $line, $row1['invoicedate'])->setCellValueByColumnAndRow(4, $line, $row1['jatuhtempo'])->setCellValueByColumnAndRow(5, $line, $row1['umur'])->setCellValueByColumnAndRow(6, $line, $row1['amount'] / $per)->setCellValueByColumnAndRow(7, $line, $row1['payamount'] / $per)->setCellValueByColumnAndRow(8, $line, ($row1['amount'] / $per) - ($row1['payamount'] / $per));
        $line++;
        $nilaitot += $row1['amount'] / $per;
        $dibayar += $row1['payamount'] / $per;
        $sisa += (($row1['amount'] / $per) - ($row1['payamount'] / $per));
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $line, 'Total')->setCellValueByColumnAndRow(6, $line, $nilaitot)->setCellValueByColumnAndRow(7, $line, $dibayar)->setCellValueByColumnAndRow(8, $line, $sisa);
      $line += 1;
      $nilaitot1 += $nilaitot;
      $dibayar1 += $dibayar;
      $sisa1 += $sisa;
    }
    $line += 1;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $line, 'GRAND TOTAL ')->setCellValueByColumnAndRow(6, $line, $nilaitot1)->setCellValueByColumnAndRow(7, $line, $dibayar1)->setCellValueByColumnAndRow(8, $line, $sisa1);
    $this->getFooterXLS($this->phpExcel);
  }
  //8
	public function RincianUmurHutangperSTTBXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianumurhutangpersttb';
    parent::actionDownXLS();
    $total2sd0    = 0;
    $total20sd30  = 0;
    $total231sd60 = 0;
    $total261sd90 = 0;
    $total2sd90   = 0;
    $total2       = 0;
    $sql          = "select distinct addressbookid,fullname
					from (select *
					from (select d.addressbookid, d.fullname, a.amount,
					ifnull((select sum(payamount) from cbapinv j
					left join cashbankout k on k.cashbankoutid=j.cashbankoutid
					where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
					and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					group by invoiceapid),0) as payamount
					from invoiceap a
					join grheader b on b.grheaderid = a.grheaderid
					join poheader c on c.poheaderid = b.poheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . " 
					and d.fullname like '%" . $supplier . "%'
					and a.invoicedate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
					where amount > payamount) zz
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(9, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->getActiveSheet()->getStyle(1, $line)->getFont()->setBold(true);
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Supplier')->setCellValueByColumnAndRow(1, $line, $row['fullname']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'No. Invoice')->setCellValueByColumnAndRow(2, $line, 'T.O.P')->setCellValueByColumnAndRow(3, $line, 'Umur')->setCellValueByColumnAndRow(4, $line, 'Belum Jatuh Tempo')->setCellValueByColumnAndRow(5, $line, '0-30 Hari')->setCellValueByColumnAndRow(6, $line, '31-60 Hari')->setCellValueByColumnAndRow(7, $line, '61-90 Hari')->setCellValueByColumnAndRow(8, $line, '>90 Hari')->setCellValueByColumnAndRow(9, $line, 'Total');
      $line++;
      $sql1        = "select z.*,
														case when umurtempo < 0 then totamount else 0 end as sd0,
														case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
														case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
														case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
														case when umurtempo > 90 then totamount else 0 end as sd90
												from
												(select concat(ifnull(a.invoiceno,'-'),' / ',ifnull(b.grno,'-')) as invoiceno, a.invoicedate,
												datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,
												datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												a.amount-ifnull((select sum(payamount) from cbapinv j
												left join cashbankout k on k.cashbankoutid=j.cashbankoutid
												where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
												and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
												group by invoiceapid),0) as totamount,e.paydays
												from invoiceap a
												inner join grheader b on b.grheaderid = a.grheaderid
												inner join poheader c on c.poheaderid = b.poheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
												and d.addressbookid = '" . $row['addressbookid'] . "'						
												and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z
												where totamount > 0";
		$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalsd0    = 0;
      $total0sd30  = 0;
      $total31sd60 = 0;
      $total61sd90 = 0;
      $totalsd90   = 0;
      $total       = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['invoiceno'])->setCellValueByColumnAndRow(2, $line, $row1['paydays'])->setCellValueByColumnAndRow(3, $line, $row1['umur'])->setCellValueByColumnAndRow(4, $line, ($row1['sd0'] / $per))->setCellValueByColumnAndRow(5, $line, ($row1['0sd30'] / $per))->setCellValueByColumnAndRow(6, $line, ($row1['31sd60'] / $per))->setCellValueByColumnAndRow(7, $line, ($row1['61sd90'] / $per))->setCellValueByColumnAndRow(8, $line, ($row1['sd90'] / $per))->setCellValueByColumnAndRow(9, $line, (($row1['sd0'] + $row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per));
        $line++;
        $totalsd0 += $row1['sd0'] / $per;
        $total0sd30 += $row1['0sd30'] / $per;
        $total31sd60 += $row1['31sd60'] / $per;
        $total61sd90 += $row1['61sd90'] / $per;
        $totalsd90 += $row1['sd90'] / $per;
        $total += ($row1['sd0'] + $row1['0sd30'] + $row1['31sd60'] + $row1['61sd90'] + $row1['sd90']) / $per;
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(4, $line, ($totalsd0))->setCellValueByColumnAndRow(5, $line, ($total0sd30))->setCellValueByColumnAndRow(6, $line, ($total31sd60))->setCellValueByColumnAndRow(7, $line, ($total61sd90))->setCellValueByColumnAndRow(8, $line, ($totalsd90))->setCellValueByColumnAndRow(9, $line, ($total));
      $line++;
      $total2sd0 += $totalsd0;
      $total20sd30 += $total0sd30;
      $total231sd60 += $total31sd60;
      $total261sd90 += $total61sd90;
      $total2sd90 += $totalsd90;
      $total2 += $total;
      $line += 1;
    }
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')->setCellValueByColumnAndRow(4, $line, ($total2sd0))->setCellValueByColumnAndRow(5, $line, ($total20sd30))->setCellValueByColumnAndRow(6, $line, ($total231sd60))->setCellValueByColumnAndRow(7, $line, ($total261sd90))->setCellValueByColumnAndRow(8, $line, ($total2sd90))->setCellValueByColumnAndRow(9, $line, ($total2));
    $line++;
    $this->getFooterXLS($this->phpExcel);
  }
  //9
	public function RekapUmurHutangperSupplierXLS($companyid, $sloc, $product, $supplier, $invoice, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekapumurhutangpersupplier';
    parent::actionDownXLS();
    $sql        = "select *,sum(sd0) as belumjatuhtempo, sum(0sd30) as sum0sd30,sum(31sd60) as sum31sd60, sum(61sd90) as sum61sd90, sum(sd90) as sumsd90
				from (select *,
				case when umurtempo < 0 then totamount else 0 end as sd0,
				case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
				case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
				case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
				case when umurtempo > 90 then totamount else 0 end as sd90
				from (select a.invoicedate,
				datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',a.invoicedate) as umur,
				datediff('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,d.fullname,
				a.amount-ifnull((select sum(payamount) from cbapinv j
				left join cashbankout k on k.cashbankoutid=j.cashbankoutid
				where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
				and k.docdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				group by invoiceapid),0) as totamount,e.paydays
				from invoiceap a
				inner join grheader b on b.grheaderid = a.grheaderid
				inner join poheader c on c.poheaderid = b.poheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = " . $companyid . "
				and a.receiptdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z 
				where totamount>0)zz
				group by fullname
				order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(7, 1, GetCompanyCode($companyid));
    $line        = 4;
    $i           = 0;
    $totalsd0    = 0;
    $total0sd30  = 0;
    $total31sd60 = 0;
    $total61sd90 = 0;
    $totalsd90   = 0;
    $total       = 0;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Supplier')->setCellValueByColumnAndRow(2, $line, 'Belum Jatuh Tempo')->setCellValueByColumnAndRow(3, $line, '0-30 Hari')->setCellValueByColumnAndRow(4, $line, '31-60 Hari')->setCellValueByColumnAndRow(5, $line, '61-90 Hari')->setCellValueByColumnAndRow(6, $line, '>90 Hari')->setCellValueByColumnAndRow(7, $line, 'Total');
    $line++;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row['fullname'])->setCellValueByColumnAndRow(2, $line, ($row['belumjatuhtempo'] / $per))->setCellValueByColumnAndRow(3, $line, ($row['sum0sd30'] / $per))->setCellValueByColumnAndRow(4, $line, ($row['sum31sd60'] / $per))->setCellValueByColumnAndRow(5, $line, ($row['sum61sd90'] / $per))->setCellValueByColumnAndRow(6, $line, ($row['sumsd90'] / $per))->setCellValueByColumnAndRow(7, $line, (($row['belumjatuhtempo'] + $row['sum0sd30'] + $row['sum31sd60'] + $row['sum61sd90'] + $row['sumsd90']) / $per));
      $line++;
      $totalsd0 += $row['belumjatuhtempo'] / $per;
      $total0sd30 += $row['sum0sd30'] / $per;
      $total31sd60 += $row['sum31sd60'] / $per;
      $total61sd90 += $row['sum61sd90'] / $per;
      $totalsd90 += $row['sumsd90'] / $per;
      $total += ($row['belumjatuhtempo'] + $row['sum0sd30'] + $row['sum31sd60'] + $row['sum61sd90'] + $row['sumsd90']) / $per;
    }
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, ($totalsd0))->setCellValueByColumnAndRow(3, $line, ($total0sd30))->setCellValueByColumnAndRow(4, $line, ($total31sd60))->setCellValueByColumnAndRow(5, $line, ($total61sd90))->setCellValueByColumnAndRow(6, $line, ($totalsd90))->setCellValueByColumnAndRow(7, $line, ($total));
    $line++;
    $this->getFooterXLS($this->phpExcel);
  }

}

