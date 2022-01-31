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
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product'])&& isset($_GET['supplier']) && isset($_GET['invoice']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 1)
			{
				$this->RincianBiayaEkspedisiPerDokumen($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 2)
			{
				$this->RekapBiayaEkspedisiPerDokumen($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 3)
			{
				$this->RekapBiayaEkspedisiPerBarang($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 4)
			{
				$this->RincianPembayaranHutangPerDokumen($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 5)
			{
				$this->KartuHutang($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RekapHutangPerSupplier($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RincianPembeliandanReturBeliBelumLunas($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RincianUmurHutangperSTTB($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RekapUmurHutangperSupplier($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['supplier'],$_GET['invoice'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	//1
	public function RekapBiayaEkspedisiPerDokumen($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.ekspedisino as dokumen,a.docdate as tanggal,a.amount as biaya,i.fullname as supplier , j.invoiceno as no_doc,l.productname,m.sloccode,
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
                     	 
                         where a.ekspedisino is not null and a.recordstatus = 3 and a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
                         and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and m.sloccode like '%".$sloc."%' and l.productname like '%".$product."%' and j.invoiceno like '%".$invoice."%' and i.fullname like '%".$supplier."%' and a.ekspedisiid in
                         (select d.ekspedisiid from ekspedisipo d
                         left join poheader p on p.poheaderid = d.poheaderid
                         where p.companyid =  ".$companyid.")";

		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Biaya Ekspedisi Per Dokumen';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,22,20,55,20,35,35));
			$this->pdf->colheader = array('No','No Bukti','Tanggal','Supplier','No.Dokumen','Jumlah','Biaya Ekspedisi');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','C','L','L','R','R');		
			$total = 0;$i=0;$biaya=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['dokumen'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])),
                                        $row['supplier'],$row['no_doc'],                                        
					Yii::app()->format->formatCurrency($row['jumlah']),
					Yii::app()->format->formatCurrency($row['biaya'])
                                        
                                    
				));
                                $total += $row['jumlah'];
                                $biaya += $row['biaya'];
                                
			}
						$this->pdf->sety($this->pdf->gety()+5);
						$this->pdf->setFont('Arial','B',9);
                        $this->pdf->row(array(
                                '','','','GRAND TOTAL'
					,'',
					Yii::app()->format->formatNumber($biaya)
					,
					Yii::app()->format->formatNumber($total)
                        ));
                        $this->pdf->checkPageBreak(20);
			$this->pdf->Output();
	}

        //2
	public function RincianPembayaranHutangPerDokumen($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.ekspedisino as dokumen,a.docdate as tanggal,a.amount as biaya,i.fullname as supplier , j.invoiceno as no_doc,l.productname,m.sloccode,
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
                     	 
                         where a.ekspedisino is not null and a.recordstatus = 3 and a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
                         and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and m.sloccode like '%%' and l.productname like '%%' and j.invoiceno like '%%' and i.fullname like '%%' and a.ekspedisiid in
                         (select d.ekspedisiid from ekspedisipo d
                         left join poheader p on p.poheaderid = d.poheaderid
                         where p.companyid =  ".$companyid.")";

		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Pembayaran Hutang Per Dokumen';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,22,20,52,20,35,35));
			$this->pdf->colheader = array('No','No Bukti','Tanggal','Supplier','No.Dokumen','Jumlah','Biaya Ekspedisi');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','C','L','C','R','R');		
			$total = 0;$i=0;$biaya=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['dokumen'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])),
                                        $row['supplier'],$row['no_doc'],                                        
					Yii::app()->format->formatCurrency($row['jumlah']),
					Yii::app()->format->formatCurrency($row['biaya'])
                                        
                                    
				));
                                $total += $row['jumlah'];
                                $biaya += $row['biaya'];
                                
			}
						$this->pdf->sety($this->pdf->gety()+5);
						$this->pdf->setFont('Arial','B',9);
                        $this->pdf->row(array(
                                '','','','GRAND TOTAL','',
					Yii::app()->format->formatNumber($total),
					Yii::app()->format->formatNumber($biaya),
                        ));
                        $this->pdf->checkPageBreak(20);
			$this->pdf->Output();
	}
	//3
	public function KartuHutang($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$penambahan1=0;$dibayar1=0;$bank1=0;$diskon1=0;$retur1=0;$ob1=0;$saldo1=0;
    $sql = "select distinct addressbookid,fullname,saldoawal
						from (select a.addressbookid,a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as dibayar
						from addressbook a where a.fullname like '%".$supplier."%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";
				
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Kartu Hutang';
		$this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+3,$row['fullname']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(25,20,40,35,35,35));
			$this->pdf->colheader = array('Dokumen','Tanggal','U/ Byr INV','Penambahan','Dibayar','Saldo');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','R','R','R');
			
			
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->row(array(
				'Saldo Awal','','','','',
				Yii::app()->format->formatCurrency($row['saldoawal']/$per),
			));
			
			$penambahan=0;$dibayar=0;$bank=0;$diskon=0;$retur=0;$ob=0;
			$sql2 = "select * from
				(select a.invoiceno as dokumen,a.invoicedate as tanggal,ifnull(b.grno,'-') as ref,a.amount as penambahan,'0' as dibayar
				from invoiceap a
				join grheader b on b.grheaderid=a.grheaderid
				join poheader c on c.poheaderid=b.poheaderid
				where a.recordstatus=3 and a.companyid=".$companyid." 
				and a.addressbookid=".$row['addressbookid']."
				and a.receiptdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
				select d.cashbankoutno as dokumen,d.docdate as tanggal,concat(ifnull(h.grno,'-'),' / ',ifnull(g.invoiceno,'-')) as ref,'0' as penambahan,c.payamount as dibayar
				from cbapinv c
				join cashbankout d on d.cashbankoutid=c.cashbankoutid
				join invoiceap g on g.invoiceapid=c.invoiceapid
				join grheader h on h.grheaderid=g.grheaderid
				where d.recordstatus=3
				and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and c.invoiceapid in (select b.invoiceapid
				from invoiceap b
				join grheader e on e.grheaderid=b.grheaderid
				join poheader f on f.poheaderid=e.poheaderid
				where b.recordstatus=3
				and b.companyid=".$companyid." and b.addressbookid = ".$row['addressbookid']."
				and b.receiptdate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
				) z
				order by tanggal,dokumen";
			$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
			
			foreach($dataReader2 as $row2)
			{
				$this->pdf->SetFont('Arial','',8);				
				$this->pdf->row(array(
					$row2['dokumen'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row2['tanggal'])),
					$row2['ref'],
					Yii::app()->format->formatCurrency($row2['penambahan']/$per),
					Yii::app()->format->formatCurrency(-$row2['dibayar']/$per),
					'',
				));
				$penambahan += $row2['penambahan']/$per;
				$dibayar += $row2['dibayar']/$per;
			}
			$this->pdf->SetFont('Arial','B',8);
			$this->pdf->setwidths(array(85,35,35,35,30,30,30,30));
			$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R');				
			$this->pdf->row(array(
				'TOTAL '.$row['fullname'],
				Yii::app()->format->formatCurrency($penambahan),
				Yii::app()->format->formatCurrency(-$dibayar),
				Yii::app()->format->formatCurrency($row['saldoawal']/$per+$penambahan-$dibayar),
			));		
			$penambahan1 += $penambahan;
			$dibayar1 += $dibayar;
			$saldo1 += $row['saldoawal']/$per;
			
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(5);
		}
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->setwidths(array(50,35,35,35,35,30,30,30,30));
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');				
		$this->pdf->row(array(
			'',
			'Saldo Awal',
			'Penambahan',
			'Dibayar',
			'Saldo Akhir',
		));
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->setwidths(array(50,35,35,35,35,30,30,30,30));
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');				
		$this->pdf->row(array(
			'GRAND TOTAL',
			Yii::app()->format->formatCurrency($saldo1),
			Yii::app()->format->formatCurrency($penambahan1),
			Yii::app()->format->formatCurrency(-$dibayar1),
			Yii::app()->format->formatCurrency($saldo1+$penambahan1-$dibayar1),
		));
		
		$this->pdf->Output();
	}
        //4
	 public function RekapHutangPerSupplier($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = 	"select *
						from (select a.fullname,
						ifnull((select sum(ifnull(d.amount,0)-ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0) as saldoawal,
						ifnull((select sum(ifnull(d.amount,0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as hutang,
						ifnull((select sum(ifnull((select sum(ifnull(b.payamount,0))
						from cbapinv b
						join cashbankout c on c.cashbankoutid=b.cashbankoutid
						where c.recordstatus=3 and b.invoiceapid=d.invoiceapid 
						and c.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoiceap d
						join grheader e on e.grheaderid=d.grheaderid
						join poheader f on f.poheaderid=e.poheaderid
						where d.recordstatus=3 and d.companyid=".$companyid." and d.addressbookid=a.addressbookid 
						and d.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as dibayar
						from addressbook a where a.fullname like '%".$supplier."%') z
						where z.saldoawal<>0 or z.hutang<>0 or z.dibayar<>0
						order by fullname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Hutang Per Supplier';
		$this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,50,30,30,30,40));
		$this->pdf->colheader = array('No','Supplier','Saldo Awal','Hutang','Dibayar','Saldo Akhir');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R');		
		$i=0;$saldoawal=0;$hutang=0;$dibayar=0;$saldoakhir=0;
		
		foreach($dataReader as $row)
		{
			
			$i+=1;
			$this->pdf->setFont('Arial','',7);
			$this->pdf->row(array(
			$i,$row['fullname'],
			Yii::app()->format->formatCurrency($row['saldoawal']/$per),
			Yii::app()->format->formatCurrency($row['hutang']/$per),
			Yii::app()->format->formatCurrency($row['dibayar']/$per),
			Yii::app()->format->formatCurrency(($row['saldoawal'] + $row['hutang'] - $row['dibayar'])/$per),
			));

			$saldoawal += $row['saldoawal']/$per;
			$hutang += $row['hutang']/$per;
			$dibayar += $row['dibayar']/$per;
			$saldoakhir += ($row['saldoawal'] + $row['hutang'] - $row['dibayar'])/$per;			
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->row(array(
		'','TOTAL',
		Yii::app()->format->formatCurrency($saldoawal),
		Yii::app()->format->formatCurrency($hutang),
		Yii::app()->format->formatCurrency($dibayar),
		Yii::app()->format->formatCurrency($saldoakhir),
		));
		$this->pdf->Output();
	}
	//5
	public function RincianBiayaEkspedisiperDokumen($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate)
        {
            parent::actionDownPDF();
			$grandqty = 0;
            $grandtotal = 0;
            $grandbiaya = 0;
            $sql = "select distinct a.ekspedisiid,a.ekspedisino, a.docdate as tanggal,c.pono
					from ekspedisi a
					join ekspedisipo b on b.ekspedisiid = a.ekspedisiid
					join poheader c on c.poheaderid = b.poheaderid
					join eksmat d on d.ekspedisiid = a.ekspedisiid
					join productplant e on e.productid = d.productid
					join sloc f on f.slocid = e.slocid
					join product g on g.productid = d.productid
					where a.companyid = ".$companyid." and a.recordstatus = 3
					and f.sloccode like '%".$sloc."%' and g.productname like '%".$product."%'
					and a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                    and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
           $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='Rincian Biaya Ekspedisi Per Dokumen';
            $this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
            
            $this->pdf->sety($this->pdf->gety()+5);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['ekspedisino']);
				$this->pdf->text(10,$this->pdf->gety()+15,'No. PO');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row['pono']);
                $this->pdf->text(130,$this->pdf->gety()+10,'Tanggal');$this->pdf->text(160,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
                
                $sql1 = "select a.ekspedisino,c.qty,c.expense as biaya,d.productname,d.productid,f.uomcode,
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
						where a.companyid = ".$companyid." and a.recordstatus = 3
						and a.ekspedisiid = '".$row['ekspedisiid']."' and d.productname like '%".$product."%' and i.sloccode like '%".$sloc."%'
						and a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                        and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by productname";
				
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $i=0;$totalqty=0;$total=0;$biaya=0;
                $this->pdf->sety($this->pdf->gety()+18);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,60,30,30,30,30));
                $this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Jumlah','Biaya Ekspedisi');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','L','C','R','R','R');
                $this->pdf->setFont('Arial','',8);
                
                foreach($dataReader1 as $row1)
                {
                    $i+=1; 
                        $this->pdf->row(array(
                                $i,$row1['productname'],$row1['uomcode'],
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
                                Yii::app()->format->formatNumber($row1['qty']*$row1['harga']),
                                Yii::app()->format->formatNumber($row1['biaya'])
                        ));
                        $totalqty += $row1['qty'];
                        $total +=($row1['qty']*$row1['harga']);
                        $biaya += $row1['biaya'];
                }
                $this->pdf->row(array(
                        '','Total','',
                        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totalqty),
                        Yii::app()->format->formatNumber($total),
                        Yii::app()->format->formatNumber($biaya),
                ));
						$grandqty += $totalqty;
                        $grandtotal += $total;
                        $grandbiaya += $biaya;
                $this->pdf->checkPageBreak(20);
            }
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','R','R','R');
			$this->pdf->setwidths(array(15,45,60,60));
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
					'','GRAND QTY:  '.Yii::app()->format->formatCurrency($grandqty),
						'GRAND JUMLAH:   '.Yii::app()->format->formatCurrency($grandtotal),
						'GRAND BIAYA:  '.Yii::app()->format->formatCurrency($grandbiaya),	
			));
            $this->pdf->Output();
        }
	//6
	public function RincianUmurHutangperBPnB($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate)
        {
            parent::actionDownPDF();
			$totdibayar = 0;
                        $totpiutang = 0;
                        $totsaldo = 0;
            $sql = "select a.cashbankarid,a.cashbankarno as dokumen,a.docdate as tanggal,b.docno as ttntno
                    from cashbankar a
                    left join ttnt b on b.ttntid = a.ttntid
                    where a.cashbankarno is not null and a.companyid = ".$companyid." and 
                    a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                    and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='Rincian Umur Hutang per BPnP';
            $this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
            
            $this->pdf->sety($this->pdf->gety()+5);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['dokumen']);
                $this->pdf->text(130,$this->pdf->gety()+10,'Tanggal');$this->pdf->text(160,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
                $this->pdf->text(10,$this->pdf->gety()+15,'Referensi');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row['ttntno']);
                $sql1 = "select b.invoiceno,a.payamount as dibayar,b.amount as piutang,(b.amount-a.payamount) as saldo, e.fullname
                        from cbarinv a
                        left join invoice b on b.invoiceid = a.invoiceid
                        join giheader c on c.giheaderid = b.giheaderid
                        join soheader d on d.soheaderid = c.soheaderid
                        left join addressbook e on e.addressbookid = d.addressbookid
						where a.cashbankarid=".$row['cashbankarid'];
						
				//select b.invoiceno,a.payamount as dibayar,b.amount as piutang,(b.amount-a.payamount) as saldo
                  //          from cbarinv a
                    //        left join invoice b on b.invoiceid = a.invoiceid
                      //      where a.cashbankarid=".$row['cashbankarid'];
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $i=0;$dibayar=0;$saldo=0;$piutang=0;
                $this->pdf->sety($this->pdf->gety()+18);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,30,40,35,35,35));
                $this->pdf->colheader = array('No','Invoice','Customer','Pembayaran','Piutang','Saldo');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','L','L','R','R','R');
                $this->pdf->setFont('Arial','',8);
                
                foreach($dataReader1 as $row1)
                {
                    $i+=1;
                        $this->pdf->row(array(
                                $i,$row1['invoiceno'],$row1['fullname'],
								Yii::app()->format->formatNumber($row1['dibayar']),
                                Yii::app()->format->formatNumber($row1['piutang']),
                                Yii::app()->format->formatNumber($row1['saldo'])
                        ));
                        $dibayar += $row1['dibayar'];
                        $piutang += $row1['piutang'];
                        $saldo += $row1['saldo'];
                }
                $this->pdf->row(array(
                        '','','Total',
                        Yii::app()->format->formatNumber($dibayar),
                        Yii::app()->format->formatNumber($piutang),
                        Yii::app()->format->formatNumber($saldo),
                ));
				$totdibayar += $dibayar;
                        $totpiutang += $piutang;
                        $totsaldo += $saldo;
                $this->pdf->checkPageBreak(20);
            }
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','R','R','R');
			$this->pdf->setwidths(array(15,55,55,55));
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
					'','GRAND Total:  '.Yii::app()->format->formatCurrency($totdibayar),
						'GRAND Piutang:   '.Yii::app()->format->formatCurrency($totpiutang),
						'GRAND Saldo:  '.Yii::app()->format->formatCurrency($totsaldo)	
			));
            $this->pdf->Output();
        }
				
				public function RekapUmurHutangperSupplier($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select *,sum(sd0) as belumjatuhtempo, sum(0sd30) as sum0sd30,sum(31sd60) as sum31sd60, sum(61sd90) as sum61sd90, sum(sd90) as sumsd90
				from (select *,
				case when umurtempo < 0 then totamount else 0 end as sd0,
				case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
				case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
				case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
				case when umurtempo > 90 then totamount else 0 end as sd90
				from (select a.invoicedate,
				datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
				datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,d.fullname,
				a.amount-ifnull((select sum(payamount) from cbapinv j
				left join cashbankout k on k.cashbankoutid=j.cashbankoutid
				where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
				and k.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				group by invoiceapid),0) as totamount,e.paydays
				from invoiceap a
				inner join grheader b on b.grheaderid = a.grheaderid
				inner join poheader c on c.poheaderid = b.poheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
				and a.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z 
				where totamount>0)zz
				group by fullname
				order by fullname";

		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Umur Hutang Per Supplier';
			$this->pdf->subtitle='Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('L');
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,75,30,30,30,30,30,35));
                $this->pdf->colheader = array('No','Nama Supplier','Belum Jatuh Tempo','0-30 Hari','31-60 Hari','61-90 Hari','> 90 Hari','Total');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R');		
			$totalsd0 = 0;
			$total0sd30 = 0;
      $total31sd60 = 0;
      $total61sd90 = 0;
			$totalsd90 = 0;
			$total = 0;$i=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['fullname'],
								Yii::app()->format->formatCurrency($row['belumjatuhtempo']/$per),
								Yii::app()->format->formatCurrency($row['sum0sd30']/$per),
								Yii::app()->format->formatCurrency($row['sum31sd60']/$per),
								Yii::app()->format->formatCurrency($row['sum61sd90']/$per),
								Yii::app()->format->formatCurrency($row['sumsd90']/$per),
                Yii::app()->format->formatCurrency(($row['belumjatuhtempo']+$row['sum0sd30']+$row['sum31sd60']+$row['sum61sd90']+$row['sumsd90'])/$per)
				));
            			$totalsd0 += $row['belumjatuhtempo']/$per;
						$total0sd30 += $row['sum0sd30']/$per;
            			$total31sd60 += $row['sum31sd60']/$per;
						$total61sd90 += $row['sum61sd90']/$per;
						$totalsd90 += $row['sumsd90']/$per;
						$total += ($row['belumjatuhtempo']+$row['sum0sd30']+$row['sum31sd60']+$row['sum61sd90']+$row['sumsd90'])/$per;
			}
						$this->pdf->sety($this->pdf->gety()+5);
						$this->pdf->setFont('Arial','B',9);
                        $this->pdf->row(array(
                                '','Total :',
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
				
				public function RincianUmurHutangperSTTB($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
	{
            parent::actionDownPDF();
						$total2sd0 = 0;
						$total20sd30 = 0;
                        $total231sd60 = 0;
                        $total261sd90 = 0;
						$total2sd90 = 0;
						$totaltempo2 = 0;
						$total2 = 0;
			//$this->pdf->AddPage('L');
            $sql ="select distinct addressbookid,fullname
					from (select *
					from (select d.addressbookid, d.fullname, a.amount,
					ifnull((select sum(payamount) from cbapinv j
					left join cashbankout k on k.cashbankoutid=j.cashbankoutid
					where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
					and k.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					group by invoiceapid),0) as payamount
					from invoiceap a
					join grheader b on b.grheaderid = a.grheaderid
					join poheader c on c.poheaderid = b.poheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$supplier."%'
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount) zz
					order by fullname";
								
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='Rincian Umur Hutang Per Supplier';
            $this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('L');
			
            $this->pdf->sety($this->pdf->gety()+0);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+3,'Supplier');$this->pdf->text(30,$this->pdf->gety()+3,': '.$row['fullname']);
                $sql1 = "select z.*,
														case when umurtempo < 0 then totamount else 0 end as sd0,
														case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
														case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
														case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
														case when umurtempo > 90 then totamount else 0 end as sd90
												from
												(select concat(ifnull(a.invoiceno,'-'),' / ',ifnull(b.grno,'-')) as invoiceno, a.invoicedate,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												a.amount-ifnull((select sum(payamount) from cbapinv j
												left join cashbankout k on k.cashbankoutid=j.cashbankoutid
												where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
												and k.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
												group by invoiceapid),0) as totamount,e.paydays
												from invoiceap a
												inner join grheader b on b.grheaderid = a.grheaderid
												inner join poheader c on c.poheaderid = b.poheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
												and d.addressbookid = '".$row['addressbookid']."'						
												and a.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where totamount > 0";



                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $this->pdf->sety($this->pdf->gety()+6);
                $this->pdf->setFont('Arial','',8);
								$this->pdf->colalign = array('L','L','L','L','L','L','C','R','R');
                $this->pdf->setwidths(array(10,55,12,12,27,27,81,27,32));
								$this->pdf->colheader = array('|','|','|','|','|','|','Sudah Jatuh Tempo','|','|');
								$this->pdf->RowHeader();
								$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,55,12,12,27,27,27,27,27,27,32));
                $this->pdf->colheader = array('No','No Invoice','T.O.P','Umur','Belum JTT','0-30 Hari','31-60 Hari','61-90 Hari','> 90 Hari','Jumlah','Total');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','C','R','R','R','R','R','R','R','R','R');
                $this->pdf->setFont('Arial','',8);
						$totalsd0 = 0;
						$total0sd30 = 0;
            $total31sd60 = 0;
            $total61sd90 = 0;
						$totalsd90 = 0;
						$totaltempo = 0;
						$total = 0;$i=0;
                foreach($dataReader1 as $row1)
                {
                    $i+=1;
                        $this->pdf->row(array(
                                $i,$row1['invoiceno'],
								$row1['paydays'],$row1['umur'],
								Yii::app()->format->formatCurrency($row1['sd0']/$per),
								Yii::app()->format->formatCurrency($row1['0sd30']/$per),
								Yii::app()->format->formatCurrency($row1['31sd60']/$per),
								Yii::app()->format->formatCurrency($row1['61sd90']/$per),
								Yii::app()->format->formatCurrency($row1['sd90']/$per),
                Yii::app()->format->formatCurrency(($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['sd90'])/$per),
                Yii::app()->format->formatCurrency(($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['sd90'])/$per)
                        )); 
                        $totalsd0 += $row1['sd0']/$per;
												$total0sd30 += $row1['0sd30']/$per;
                        $total31sd60 += $row1['31sd60']/$per;
                        $total61sd90 += $row1['61sd90']/$per;
												$totalsd90 += $row1['sd90']/$per;
												$totaltempo += ($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['sd90'])/$per;
												$total += ($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['sd90'])/$per;
                } 
							$this->pdf->setFont('Arial','B',8);
                $this->pdf->row(array(
                        '','TOTAL '.$row['fullname'],'','',
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
						$this->pdf->sety($this->pdf->gety()+5);
            $this->pdf->checkPageBreak(30);
            } 
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R');
			$this->pdf->setwidths(array(89,27,27,27,27,27,27,32));
			$this->pdf->setFont('Arial','BI',9);
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
				
				public function RincianPembeliandanReturBeliBelumLunas($companyid,$sloc,$product,$supplier,$invoice,$startdate,$enddate,$per)
  {
		parent::actionDownPDF();
		$nilaitot1 = 0;$dibayar1 = 0;$sisa1 = 0;
    $sql = "select distinct addressbookid,fullname
					from (select *
					from (select d.addressbookid, d.fullname, a.amount,
					ifnull((select sum(payamount) from cbapinv j
					left join cashbankout k on k.cashbankoutid=j.cashbankoutid
					where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
					and k.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					group by invoiceapid),0) as payamount
					from invoiceap a
					join grheader b on b.grheaderid = a.grheaderid
					join poheader c on c.poheaderid = b.poheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$supplier."%'
					and a.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount) zz
					order by fullname";
		 $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Pembelian & Retur Beli Belum Lunas';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety()+0);
	 
		foreach($dataReader as $row)
		{                
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$sql1 = "select *
				from (select a.invoiceno,b.grno,a.invoicedate,e.paydays,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
				datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount, 
				ifnull((select sum(payamount) from cbapinv j
				left join cashbankout k on k.cashbankoutid=j.cashbankoutid
				where k.recordstatus=3 and j.invoiceapid=a.invoiceapid
				and k.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				group by invoiceapid),0) as payamount
				from invoiceap a
				inner join grheader b on b.grheaderid = a.grheaderid
				inner join poheader c on c.poheaderid = b.poheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
				and d.addressbookid = '".$row['addressbookid']."'						
				and a.receiptdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
				where z.amount > z.payamount
				order by invoicedate,invoiceno";
							
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+7);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,20,20,20,20,10,30,30,30));
			$this->pdf->colheader = array('No','Dokumen','Referensi','Tanggal','j_tempo','Umur','Nilai','Kum_bayar','Sisa');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','C','C','C','R','R','R');
			$this->pdf->setFont('Arial','',8);
			$i=0;$nilaitot = 0;$dibayar = 0;$sisa = 0;
									
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->row(array(
					$i,$row1['invoiceno'],$row1['grno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
					$row1['umur'],
					Yii::app()->format->formatCurrency($row1['amount']/$per),
					Yii::app()->format->formatCurrency($row1['payamount']/$per),
					Yii::app()->format->formatCurrency(($row1['amount']/$per)-($row1['payamount']/$per)),
				));
				$nilaitot += $row1['amount']/$per;
				$dibayar += $row1['payamount']/$per;
				$sisa += (($row1['amount']/$per)-($row1['payamount']/$per));
							
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
				'','','','','Total:','',
				Yii::app()->format->formatCurrency($nilaitot),
				Yii::app()->format->formatCurrency($dibayar),
				Yii::app()->format->formatCurrency($sisa),
			));
			$nilaitot1 += $nilaitot;
			$dibayar1 += $dibayar;
			$sisa1 += $sisa;
		}
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->coldetailalign = array('R','R','R','R');
		$this->pdf->setwidths(array(95,30,35,30));
		$this->pdf->row(array(
		'GRAND TOTAL',
		Yii::app()->format->formatCurrency($nilaitot1),
		Yii::app()->format->formatCurrency($dibayar1),
		Yii::app()->format->formatCurrency($sisa1),
		));

		$this->pdf->Output();
	}
	
        //8 
        public function RincianFakturdanReturJualBelumLunasPerSales($companyid,$sloc,$materialgroup,$customer,$product,$startdate,$enddate,$per)
  {
      parent::actionDownPDF();
			$nilaitot2 = 0;$dibayar2 = 0;$sisa2 = 0;
				$sql="select distinct employeeid, fullname
				from(select h.employeeid, h.fullname,a.amount,
				ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
				from cutarinv f
				join cutar g on g.cutarid=f.cutarid
				where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamountcut
				from invoice a
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				join addressbook d on d.addressbookid = c.addressbookid				
				join employee h on h.employeeid = c.employeeid
				where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 				
				and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
				where amount > payamountcut
				order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Faktur & Retur Jual Belum Lunas Per Sales';
			$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');

			$this->pdf->sety($this->pdf->gety()+0);
		 
			foreach($dataReader as $row)
			{                
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'SALESMAN ');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$this->pdf->sety($this->pdf->gety()+5);
				$nilaitot1 = 0;$dibayar1 = 0;$sisa1 = 0;
				$sql1 = "select distinct addressbookid, fullname
						from(select d.addressbookid, d.fullname,a.amount,
						ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
						from cutarinv f
						join cutar g on g.cutarid=f.cutarid
						where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamountcut
						from invoice a
						join giheader b on b.giheaderid = a.giheaderid
						join soheader c on c.soheaderid = b.soheaderid
						join addressbook d on d.addressbookid = c.addressbookid						
						where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and c.employeeid = ".$row['employeeid'].")z
						where amount > payamountcut 
						order by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{                
					$this->pdf->SetFont('Arial','',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Customer ');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row1['fullname']);
					$this->pdf->sety($this->pdf->gety()+5);
					
					$sql2 =	" select *,
								case when umurtempo < 1 then sisa else 0 end as sd0,
								case when umurtempo > 0 and umurtempo <= 30 then sisa else 0 end as 0sd30,
								case when umurtempo > 30 and umurtempo <= 60 then sisa else 0 end as 31sd60,
								case when umurtempo > 60 and umurtempo <= 90 then sisa else 0 end as 61sd90,
								case when umurtempo > 90 then sisa else 0 end as sd90
								from(select *, nilai-payamount as sisa
								from(select *
								from
								(select distinct a.invoiceno,h.addressbookid,h.fullname,a.amount as nilai,
								ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
								from cutarinv f
								join cutar g on g.cutarid=f.cutarid
								where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,a.invoicedate,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',
								date_add(a.invoicedate,interval d.paydays day)) as umurtempo,
								date_add(a.invoicedate,interval d.paydays day) as jatuhtempo,d.paydays
								from invoice a
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join paymentmethod d on d.paymentmethodid = c.paymentmethodid
								join addressbook h on h.addressbookid = c.addressbookid
								where c.companyid = ".$companyid." and a.recordstatus = 3 
								and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								) zz where zz.nilai > payamount and addressbookid = '".$row1['addressbookid']."'
								order by fullname)zzz)zzzz";

									
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,20,25,25,15,30,35,30));
					$this->pdf->colheader = array('No','Dokumen','Tanggal','j_tempo','Umur','Nilai','Kum_bayar','Sisa');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('C','C','C','C','C','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$i=0;$nilaitot = 0;$dibayar = 0;$sisa = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['invoiceno'],
							date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
							date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo']/$per)),
							$row2['umur'],
							Yii::app()->format->formatCurrency($row2['nilai']/$per),
							Yii::app()->format->formatCurrency($row2['payamount']/$per),
							Yii::app()->format->formatCurrency(($row2['nilai']-$row2['payamount'])/$per),
						));
						$nilaitot += $row2['nilai']/$per;
						$dibayar += $row2['payamount']/$per;
						$sisa += ($row2['nilai']-$row2['payamount'])/$per;

						
						$this->pdf->checkPageBreak(20);
					}
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->coldetailalign = array('R','R','R','R');
					$this->pdf->setwidths(array(95,30,35,30));
					$this->pdf->row(array(
						'TOTAL '.$row1['fullname'],
						Yii::app()->format->formatCurrency($nilaitot),
						Yii::app()->format->formatCurrency($dibayar),
						Yii::app()->format->formatCurrency($sisa),
					));
					$nilaitot1 += $nilaitot;
					$dibayar1 += $dibayar;
					$sisa1 += $sisa;
				}
				$this->pdf->sety($this->pdf->gety()+5);
					$this->pdf->setFont('Arial','BI',9);
					$this->pdf->coldetailalign = array('R','R','R','R');
					$this->pdf->setwidths(array(95,30,35,30));
					$this->pdf->row(array(
					'TOTAL SALESMAN '.$row['fullname'],
					Yii::app()->format->formatCurrency($nilaitot1),
					Yii::app()->format->formatCurrency($dibayar1),
					Yii::app()->format->formatCurrency($sisa1),
				));
				$nilaitot2 += $nilaitot1;
				$dibayar2 += $dibayar1;
				$sisa2 += $sisa1;
			}
			$this->pdf->sety($this->pdf->gety()+5);
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->coldetailalign = array('R','R','R','R');
				$this->pdf->setwidths(array(95,30,35,30));
				$this->pdf->row(array(
				'GRAND TOTAL',
				Yii::app()->format->formatCurrency($nilaitot2),
				Yii::app()->format->formatCurrency($dibayar2),
				Yii::app()->format->formatCurrency($sisa2),
			));            
			
			$this->pdf->Output();
    }
        
        //9
       public function RekapKontrolPiutangCustomervsPlafon($companyid,$sloc,$materialgroup,$customer,$product,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalbelum=0;$totalsudah=0;$totalnilai=0;$totalplafon=0;
		$sql = "select distinct d.addressbookid,d.fullname
				from invoice a
				join giheader b on b.giheaderid=a.giheaderid
				join soheader c on c.soheaderid=b.soheaderid
				join addressbook d on d.addressbookid=c.addressbookid
				join paymentmethod e on e.paymentmethodid=c.paymentmethodid
				where a.amount > a.payamount and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
				and a.amount > a.payamount and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Kontrol Piutang Customer VS Plafon';
			$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');

			$this->pdf->sety($this->pdf->gety()+3);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,50,27,27,27,27,27));
					$this->pdf->colheader = array('No','Customer','Belum JT','Sudah JT','Jumlah','Plafon','Over/(Under)');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('C','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$i=0;
					
					
		 
			foreach($dataReader as $row)
			{
				$sql1 = "select fullname,sum(belum) as belum,sum(sudah) as sudah,sum(nilai) as nilai,plafon from
								(select z.*,
								case when umur <= paydays then nilai else 0 end as belum,
								case when umur > paydays then nilai else 0 end as sudah
								from
								(select distinct a.invoiceno,a.invoicedate,date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,e.paydays,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount-a.payamount as nilai,d.creditlimit as plafon,d.fullname
								from invoice a
								join giheader b on b.giheaderid=a.giheaderid
								join soheader c on c.soheaderid=b.soheaderid
								join addressbook d on d.addressbookid=c.addressbookid
								join paymentmethod e on e.paymentmethodid=c.paymentmethodid
								where a.amount > a.payamount and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
								and a.amount > a.payamount and d.addressbookid = ".$row['addressbookid']."
								and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								order by invoicedate) z)zz group by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();			
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->SetFont('Arial','',8);
					$this->pdf->sety($this->pdf->gety()+0);
					$this->pdf->row(array($i,$row['fullname'],						
						Yii::app()->format->formatCurrency($row1['belum']),
						Yii::app()->format->formatCurrency($row1['sudah']),
						Yii::app()->format->formatCurrency($row1['nilai']),
						Yii::app()->format->formatCurrency($row1['plafon']),
						Yii::app()->format->formatCurrency($row1['nilai'] - $row1['plafon']),
					));
					$totalbelum += $row1['belum'];
					$totalsudah += $row1['sudah'];
					$totalnilai += $row1['nilai'];
					$totalplafon += $row1['plafon'];
				}
				
			}
			$this->pdf->SetFont('Arial','B',8);
				$this->pdf->sety($this->pdf->gety()+4);
				$this->pdf->row(array(
					'','TOTAL',
					Yii::app()->format->formatCurrency($totalbelum),
					Yii::app()->format->formatCurrency($totalsudah),
					Yii::app()->format->formatCurrency($totalnilai),
					Yii::app()->format->formatCurrency($totalplafon),
					Yii::app()->format->formatCurrency($totalnilai - $totalplafon),
					
					));
		
		
		
		
		$this->pdf->Output();
	}
        //10
        public function RincianKontrolPiutangCustomervsPlafon($companyid,$sloc,$materialgroup,$customer,$product,$startdate,$enddate,$per)
  {
      parent::actionDownPDF();
			$totalbelum1=0;$totalsudah1=0;$totalnilai1=0;$totalplafon1=0;
      $sql = "select distinct d.addressbookid,d.fullname
				from invoice a
				join giheader b on b.giheaderid=a.giheaderid
				join soheader c on c.soheaderid=b.soheaderid
				join addressbook d on d.addressbookid=c.addressbookid
				join paymentmethod e on e.paymentmethodid=c.paymentmethodid
				where a.amount > a.payamount and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
				and a.amount > a.payamount and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Kontrol Piutang Customer VS Plafon';
			$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');

			
		 
			foreach($dataReader as $row)
			{                
				$totalbelum=0;$totalsudah=0;$totalnilai=0;
				$this->pdf->setFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'CUSTOMER ');$this->pdf->text(30,$this->pdf->gety()+5,' : '.$row['fullname']);
				
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,20,17,17,10,22,22,25,25,25));
				$this->pdf->colheader = array('No','Dokumen','Tanggal','J_Tempo','Umur','Belum JT','Sudah JT','Jumlah','Plafon','Over/(Under)');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('C','C','C','C','C','R','R','R','R','R');
				$this->pdf->sety($this->pdf->gety()+1);
				
				$i=0;$nilaitot = 0;$dibayar = 0;$sisa = 0;$i=0;
				$sql1 = "select z.*,
								case when umur <= paydays then nilai else 0 end as belum,
								case when umur > paydays then nilai else 0 end as sudah
								from
								(select distinct a.invoiceno,a.invoicedate,date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,e.paydays,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount-a.payamount as nilai,d.creditlimit
								from invoice a
								join giheader b on b.giheaderid=a.giheaderid
								join soheader c on c.soheaderid=b.soheaderid
								join addressbook d on d.addressbookid=c.addressbookid
								join paymentmethod e on e.paymentmethodid=c.paymentmethodid
								where a.amount > a.payamount and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
								and a.amount > a.payamount and d.addressbookid = ".$row['addressbookid']."
								and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								order by invoicedate) z";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();		
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->SetFont('Arial','',8);					
					$this->pdf->row(array(
						$i,$row1['invoiceno'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
						$row1['umur'],
						Yii::app()->format->formatCurrency($row1['belum']),
						Yii::app()->format->formatCurrency($row1['sudah']),
						'',
						'',
						'',
					));
					
					$totalbelum += $row1['belum'];
					$totalsudah += $row1['sudah'];
					$totalnilai += $row1['nilai'];
				}
				$this->pdf->SetFont('Arial','B',8);
				$this->pdf->coldetailalign = array('R','R','R','R','R','R');
			$this->pdf->setwidths(array(74,22,22,25,25,25));
				$this->pdf->sety($this->pdf->gety()+0);
				$this->pdf->row(array(
					'SUB TOTAL',
					Yii::app()->format->formatCurrency($totalbelum),
					Yii::app()->format->formatCurrency($totalsudah),
					Yii::app()->format->formatCurrency($totalnilai),
					Yii::app()->format->formatCurrency($row1['creditlimit']),
					Yii::app()->format->formatCurrency($totalnilai - $row1['creditlimit']),
				));
				
					$totalbelum1 += $totalbelum;
					$totalsudah1 += $totalsudah;
					$totalnilai1 += $totalnilai;
					$totalplafon1 += $row1['creditlimit'];
			}
			
			$this->pdf->coldetailalign = array('C','R','R','R','R','R');
			$this->pdf->setwidths(array(58,27,27,27,27,27));
			$this->pdf->SetFont('Arial','BI',8);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->row(array(
				'TOTAL',
				Yii::app()->format->formatCurrency($totalbelum1),
				Yii::app()->format->formatCurrency($totalsudah1),
				Yii::app()->format->formatCurrency($totalnilai1),
				Yii::app()->format->formatCurrency($totalplafon1),
				Yii::app()->format->formatCurrency($totalnilai1 - $totalplafon1),
			));         
			
			$this->pdf->Output();
    }
	
	//11
        
        public function RekapPenjualanPerAreaPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct zg.salesareaid,zg.areaname
				   from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				   join addressbook zf on zf.addressbookid = za.addressbookid
				   left join salesarea zg on zg.salesareaid = zf.salesareaid
				   join product zh on zh.productid = zc.productid
				   join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$sales."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by zg.areaname order by zg.areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan Per Area Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['areaname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select productid,productname,description as barang,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,l.description,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and 
						  e.fullname like '%".$sales."%' and f.salesareaid = ".$row['salesareaid']." and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['giqty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['giqty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL AREA '.$row['areaname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //12
        public function RekapPenjualanPerAreaPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct zg.salesareaid,zg.areaname
				   from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				   join addressbook zf on zf.addressbookid = za.addressbookid
				   left join salesarea zg on zg.salesareaid = zf.salesareaid
				   join product zh on zh.productid = zc.productid
				   join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$sales."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by zg.areaname order by zg.areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan Per Area Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['areaname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
				from soheader za 
				join giheader zb on zb.soheaderid = za.soheaderid
				join gidetail zc on zc.giheaderid = zb.giheaderid
				join sodetail zs on zs.sodetailid = zc.sodetailid
				left join employee zd on zd.employeeid = za.employeeid
				join product ze on ze.productid = zs.productid
				left join addressbook zf on zf.addressbookid = za.addressbookid
				left join salesarea zg on zg.salesareaid = zf.salesareaid
				join sloc zh on zh.slocid = zc.slocid
				join invoice zi on zi.giheaderid = zc.giheaderid
				join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
				join materialgroup zk on zk.materialgroupid=zj.materialgroupid
				where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
				zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
				zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zg.salesareaid = ".$row['salesareaid']." and
				zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'	order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productid,productname,sum(qty) as giqty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
							e.fullname like '%".$sales."%' and f.salesareaid = ".$row['salesareaid']." and i.productname like '%".$product."%' 
							and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']."
							and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)zz group by productid order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['giqty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['giqty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL AREA '.$row['areaname'],
				Yii::app()->format->formatNumber($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(20);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
	}
        //13
	public function RincianReturPenjualanPerDokumen($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;
		$sql = "select distinct b.notagirid,b.notagirno,i.fullname as customer,d.gireturdate,j.paycode,h.taxid,b.headernote
						from notagirpro a
						left join notagir b on b.notagirid=a.notagirid
						left join gireturdetail c on c.gireturdetailid=a.gireturdetailid
						left join giretur d on d.gireturid=b.gireturid
						left join product e on e.productid=a.productid
						left join gidetail f on f.gidetailid=c.gidetailid
						left join giheader g on g.giheaderid=d.giheaderid
						left join soheader h on h.soheaderid=g.soheaderid
						left join addressbook i on i.addressbookid=h.addressbookid
						left join paymentmethod j on j.paymentmethodid=h.paymentmethodid
						left join sloc k on k.slocid=a.slocid
						left join employee l on l.employeeid = h.employeeid
						where k.sloccode like '%".$sloc."%' and b.recordstatus = 3 and i.fullname like '%".$customer."%' and 
						h.companyid = ".$companyid." and e.productname like '%".$product."%' and l.fullname like '%".$sales."%' and
						d.gireturdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Retur Penjualan Per Dokumen';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->sety($this->pdf->gety()+5);
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+0,'Dokumen');$this->pdf->text(40,$this->pdf->gety()+0,': '.$row['notagirno']);
			$this->pdf->text(10,$this->pdf->gety()+5,'Customer');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['customer']);
			$this->pdf->text(130,$this->pdf->gety()+0,'Tanggal');$this->pdf->text(160,$this->pdf->gety()+0,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])));
			$this->pdf->text(130,$this->pdf->gety()+5,'T.O.P');$this->pdf->text(160,$this->pdf->gety()+5,': '.$row['paycode'].' HARI');                
			$sql1 = "select *,(nominal-netto) as disc from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and b.notagirid = ".$row['notagirid']." 
							and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)z order by notagirno,notagirproid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;
			$this->pdf->sety($this->pdf->gety()+8);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,60,20,20,30,50));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Harga','Jumlah','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R');
			$this->pdf->setFont('Arial','',8);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->row(array(
					$i,$row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),
					Yii::app()->format->formatCurrency($row1['price']/$per),
					Yii::app()->format->formatCurrency($row1['nominal']/$per),
					$row1['headernote'],
				));
				$totalqty += $row1['qty'];
				$totalnominal += $row1['nominal']/$per;
				$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$totalnetto += $row1['netto']/$per;

			}
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','Keterangan : '.$row['headernote'],
				Yii::app()->format->formatNumber($totalqty),
				'','Nominal',
				Yii::app()->format->formatCurrency($totalnominal),
			));
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','','',
				'','Diskon',
				Yii::app()->format->formatCurrency($totaldiskon),
			));
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','','',
				'','Netto',
				Yii::app()->format->formatCurrency($totalnetto),
			));
						
			$totalnominal1 += $totalnominal;
			$totaldiskon1 += $totaldiskon;
			$totalnetto1 += $totalnetto;
			$this->pdf->sety($this->pdf->gety()+15);
			$this->pdf->checkPageBreak(10);
		}

		$this->pdf->colalign = array('R','R','R');
		$this->pdf->setwidths(array(60,60,60));
		$this->pdf->setFont('Arial','B',9);
		$this->pdf->row(array(
			'GRAND TOTAL  '.Yii::app()->format->formatCurrency($totalnominal1),
			'TOTAL DISCOUNT  '.Yii::app()->format->formatCurrency($totaldiskon1),
			'TOTAL NETTO  '.Yii::app()->format->formatCurrency($totalnetto1),
		));
		$this->pdf->Output();
	}
	
        //14
        public function RekapReturPenjualanPerDokumen($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		
		$this->pdf->title='Rekap Retur Penjualan Per Dokumen';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		$i=0;$nominal=0;$diskon=0;$netto=0;

		$this->pdf->sety($this->pdf->gety()+10);
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,22,18,58,30,30,30));
		$this->pdf->colheader = array('No','Dokumen','Tanggal','Customer','Nominal','Diskon','Netto');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','L','R','R','R');
		
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->row(array(
				$i,$row['notagirno'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])),
				$row['fullname'],
				Yii::app()->format->formatCurrency($row['nominal']/$per),
				Yii::app()->format->formatCurrency(($row['nominal']/$per) - ($row['netto']/$per)),
				Yii::app()->format->formatCurrency($row['netto']/$per),
			));
			$nominal += $row['nominal']/$per;
			$diskon += ($row['nominal']/$per) - ($row['netto']/$per);
			$netto += $row['netto']/$per;
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->row(array(
			'','','','GRAND TOTAL',
				Yii::app()->format->formatCurrency($nominal),
				Yii::app()->format->formatCurrency($diskon),
				Yii::app()->format->formatCurrency($netto),
		));
		$this->pdf->Output();
	}
        //15
        public function RekapReturPenjualanPerCustomer($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
  {
        parent::actionDownPDF();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;$totalnominal2=0;$totaldiskon2=0;$totalnetto2=0;
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
				
           $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            
            $this->pdf->title='Rekap Retur Penjualan Per Customer';
            $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
            foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Customer');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['fullname']);
				$sql1 = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,a.qty,
							(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalppn = 0;$totalnominal=0;$total=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+15);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,22,20,25,25,25,55));
				$this->pdf->colheader = array('No','No Dokumen','Tanggal','Nominal','Diskon','Netto','Keterangan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','R','R','C');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;
				$totaldiskon = 0;
				$totalnetto = 0;
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['notagirno'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['gireturdate'])),
						Yii::app()->format->formatCurrency($row1['nominal']/$per),
						Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
						Yii::app()->format->formatCurrency($row1['netto']/$per),$row1['headernote']
					));
					$totalnominal += $row1['nominal']/$per;
					$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
					$totalnetto += $row1['netto']/$per;
				}
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
						'','Total ','',
						Yii::app()->format->formatCurrency($totalnominal),
						Yii::app()->format->formatCurrency($totaldiskon),
						Yii::app()->format->formatCurrency($totalnetto),
					));
					$totalnominal1 += $totalnominal;
					$totaldiskon1 += $totaldiskon;
					$totalnetto1 += $totalnetto;
				$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(40,50,50,40));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'TOTAL',
						'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISKON : '.Yii::app()->format->formatCurrency($totaldiskon1),
						'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
        }
        
        //16
        public function RekapReturPenjualanPerSales($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;$totalnominal2=0;$totaldiskon2=0;$totalnetto2=0;
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Sales';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
						
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Sales');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['fullname']);
				$sql1 = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaldiskon = 0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+15);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,30,25,30,30));
				$this->pdf->colheader = array('No','Nama Customer','Nominal','Diskon','Netto');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);

				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['fullname'],
						Yii::app()->format->formatCurrency($row1['nominal']/$per),
						Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
						Yii::app()->format->formatCurrency($row1['netto']/$per),
					));
					$totalnominal += $row1['nominal']/$per;
					$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
					$totalnetto += $row1['netto']/$per;
				}
				$this->pdf->row(array(
						'','Total Sales',
						Yii::app()->format->formatCurrency($totalnominal),
						Yii::app()->format->formatCurrency($totaldiskon),
						Yii::app()->format->formatCurrency($totalnetto),
					));
					$totalnominal1 += $totalnominal;
					$totaldiskon1 += $totaldiskon;
					$totalnetto1 += $totalnetto;
				$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(40,50,50,40));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'TOTAL',
						'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISKON : '.Yii::app()->format->formatCurrency($totaldiskon1),
						'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	} 
        //17
       public function RekapReturPenjualanPerBarang($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
            parent::actionDownPDF();
					$totalnominal1 = 0;
					$totaldiskon1 = 0;
					$totalnetto1 = 0;
					$sql = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
			
           $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            
            $this->pdf->title='Rekap Retur Penjualan Per Barang';
            $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
			
            $this->pdf->sety($this->pdf->gety()+0);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+10,'Divisi');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
                $sql1 = "select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							(a.qty*g.price) as nom,a.price,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and n.materialgroupid = ".$row['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname order by productname";
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;$i=0;
                $this->pdf->sety($this->pdf->gety()+15);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,60,15,25,30,25,30));
                $this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','L','C','R','R','R','R');
                $this->pdf->setFont('Arial','',8);
               
                foreach($dataReader1 as $row1)
                {
                    $i+=1;
                        $this->pdf->row(array(
                                $i,$row1['productname'],
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
                                Yii::app()->format->formatCurrency($row1['harga']/$per),
																Yii::app()->format->formatCurrency($row1['nominal']/$per),
                                Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
                                Yii::app()->format->formatCurrency($row1['netto']/$per),
                        ));
                        $totalqty += $row1['qty'];
                        $totalnominal += $row1['nominal']/$per;
												$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
                        $totalnetto += $row1['netto']/$per;
                }
                $this->pdf->row(array(
                        '','Total : '.$row['description'],
                        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totalqty),'',
                        Yii::app()->format->formatCurrency($totalnominal),
                        Yii::app()->format->formatCurrency($totaldiskon),
                        Yii::app()->format->formatCurrency($totalnetto),
                ));
					$totalnominal1 += $totalnominal;
					$totaldiskon1 += $totaldiskon;
					$totalnetto1 += $totalnetto;
                $this->pdf->checkPageBreak(20);
            }
			
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->sety($this->pdf->gety()+5);
				$this->pdf->row(array(
						'','GRAND TOTAL','','',
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldiskon1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
            $this->pdf->Output();
    }
        //18
        public function RekapReturPenjualanPerArea($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
			$totalqty1 = 0;
			$totalnominal1 = 0;
			$totaldiskon1 = 0;
			$totalnetto1 = 0;
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Retur Penjualan Per Area';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'Area');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['areaname']);
			$sql1 = "select distinct a.materialgroupid,a.description,f.productid
					from materialgroup a
					join productplant b on b.materialgroupid = a.materialgroupid
					join gireturdetail e on e.productid = b.productid
					join gidetail c on c.gidetailid = e.gidetailid
					join product f on f.productid = e.productid
					join giheader g on g.giheaderid = c.giheaderid
					join soheader h on h.soheaderid = g.soheaderid
					join addressbook i on i.addressbookid = h.addressbookid
					join salesarea j on j.salesareaid = i.salesareaid
					join giretur k on k.gireturid = e.gireturid
					where k.recordstatus = 3 and h.companyid = ".$companyid." and f.productname like '%".$product."%'
					and j.salesareaid = ".$row['salesareaid']."
					and k.gireturdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					group by description";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(10,$this->pdf->gety()+15,'Grup Material');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row1['description']);
					$sql2 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
							and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid";
					
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$totalnetto = 0;$totalnominal=0;$totaldiskon=0;$i=0;$totalqty=0;
					$this->pdf->sety($this->pdf->gety()+20);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,80,20,30,20,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Nominal','Diskon','Netto');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('L','L','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					foreach($dataReader2 as $row2)
					{
                        $i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['qty']),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldiskon += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;
					}
					$this->pdf->row(array(
							'','Total '.$row1['description'],
							Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldiskon),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldiskon1 += $totaldiskon;
						$totalnetto1 += $totalnetto;
					$this->pdf->checkPageBreak(20);
				}
		}
			$this->pdf->colalign = array('C','C','C','C');
			$this->pdf->setwidths(array(50,50,40,40));
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
					'TOTAL :',
						'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISKON : '.Yii::app()->format->formatCurrency($totaldiskon1),
						'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1),
			));
		$this->pdf->Output();
	}
        //19
        public function RekapReturPenjualanPerCustomerPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Customer Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Customer');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL CUSTOMER '.$row['fullname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatCurrency($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //20
        public function RekapReturPenjualanPerCustomerPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Customer Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'CUSTOMER');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['fullname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' 
							and m.areaname like '%".$salesarea."%' and k.addressbookid = ".$row['addressbookid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
							(select distinct a.notagirproid,i.productname,a.qty,g.price,(a.qty*g.price) as nom,(a.qty*a.price) as nett
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL CUSTOMER '.$row['fullname'],
				Yii::app()->format->formatNumber($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(20);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
	}
        //21
        public function RekapReturPenjualanPerSalesPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
            parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Sales Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Sales');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL SALES '.$row['fullname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //22
        public function RekapReturPenjualanPerSalesPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Sales Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Sales');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['fullname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' 
							and m.areaname like '%".$salesarea."%' and l.employeeid = ".$row['employeeid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
							(select distinct a.notagirproid,i.productname,a.qty,g.price,(a.qty*g.price) as nom,(a.qty*a.price) as nett
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL SALES '.$row['fullname'],
				Yii::app()->format->formatNumber($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(15);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
	}
        //23
        public function RekapReturPenjualanPerAreaPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Area Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['areaname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL AREA '.$row['areaname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //24
        public function RekapReturPenjualanPerAreaPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Area Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['areaname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' 
							and m.areaname like '%".$salesarea."%' and m.salesareaid = ".$row['salesareaid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
							(select distinct a.notagirproid,i.productname,a.qty,g.price,(a.qty*g.price) as nom,(a.qty*a.price) as nett
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL AREA '.$row['areaname'],
				Yii::app()->format->formatNumber($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(20);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
	}
        //25
        public function RincianPenjualanReturPenjualanPerDokumen($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$total1=0;$totaldisc1=0;$totalnetto1=0;$disc= 0;
		$sql = "select a.invoiceid,a.invoiceno, b.gino, a.invoicedate, d.fullname as customer,h.fullname as sales, e.paydays, c.shipto, a.headernote
				from invoice a
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				join addressbook d on d.addressbookid = c.addressbookid
				join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				join gidetail f on f.giheaderid = b.giheaderid
				join sloc g on g.slocid = f.slocid
				join employee h on h.employeeid = c.employeeid
				join product i on i.productid = f.productid
				join salesarea j on j.salesareaid = d.salesareaid
				where a.recordstatus = 3 and c.companyid = ".$companyid." and g.sloccode like '%".$sloc."%'
				and d.fullname like '%".$customer."%' and h.fullname like '%".$sales."%' and i.productname like '%".$product."%'
				and j.areaname like '%".$salesarea."%' and b.gino is not null
				and a.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by invoiceno order by invoicedate";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Penjualan - Retur Per Dokumen';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'No Bukti');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['invoiceno']);
				$this->pdf->text(10,$this->pdf->gety()+20,'No SJ');$this->pdf->text(30,$this->pdf->gety()+20,': '.$row['gino']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Sales');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['sales']);
				$this->pdf->text(10,$this->pdf->gety()+25,'T.O.P');$this->pdf->text(30,$this->pdf->gety()+25,': '.$row['paydays'].' HARI');
				$this->pdf->text(150,$this->pdf->gety()+10,''.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
				$this->pdf->text(150,$this->pdf->gety()+15,'Kepada YTH');
				$this->pdf->text(150,$this->pdf->gety()+20,''.$row['customer']);
				$this->pdf->text(150,$this->pdf->gety()+25,''.$row['shipto']);
				$sql1 = "select distinct ss.gidetailid,a.invoiceno,i.productname,k.uomcode,ss.qty,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nominal,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and c.companyid = ".$companyid." 
							and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' 
							  and e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' 
							  and i.productname like '%".$product."%' and a.invoiceid = ".$row['invoiceid']." 
							  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+27);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,85,20,15,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Price','Total');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','L','R','R');
				$this->pdf->setFont('Arial','',8);
				$total = 0;
				$totalqty = 0;
				$diskon =0;
				$netto = 0;
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],
						Yii::app()->format->formatCurrency($row1['price']/$per),
						Yii::app()->format->formatCurrency($row1['nominal']/$per),
					));
					$totalqty += $row1['qty'];
					$total += $row1['nominal']/$per;
					$netto += $row1['nett']/$per;
					$diskon = $total - $netto ;
					$bilangan = explode(".",$netto);
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						'Nominal',
						Yii::app()->format->formatCurrency($total),
					));
				$this->pdf->row(array(
						'','',
						'',
						'',
						'Diskon',
						Yii::app()->format->formatCurrency($diskon),
					));
				$this->pdf->row(array(
						'',
						'Terbilang : '.$this->eja($bilangan[0]),
						'',
						'',
						'Netto',
						Yii::app()->format->formatCurrency($netto),
					));
					$this->pdf->row(array(
						'',
						'Note : '.$row['headernote'],
						'',
						'',
						'',
						'',
					));
					$totalqty1 += $totalqty;
					$total1 += $total;
					$totaldisc1 += $diskon;
					$totalnetto1 += $netto;
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->coldetailalign = array('C','R','R','R','R');
			$this->pdf->setwidths(array(40,30,40,40,40));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'TOTAL PENJUALAN ',
					'QTY  '.Yii::app()->format->formatNumber($totalqty1),
					'NOMINAL  '.Yii::app()->format->formatCurrency($total1),
					'DISKON  '.Yii::app()->format->formatCurrency($totaldisc1),
					'NETTO  '.Yii::app()->format->formatCurrency($totalnetto1),
						
			));
			
			$totqty1=0;$totalnom1=0;$totaldisk1=0;$totalnett1=0;
		$sql = "select distinct b.notagirid,b.notagirno,i.fullname as customer,d.gireturdate,j.paycode,h.taxid,b.headernote
						from notagirpro a
						left join notagir b on b.notagirid=a.notagirid
						left join gireturdetail c on c.gireturdetailid=a.gireturdetailid
						left join giretur d on d.gireturid=b.gireturid
						left join product e on e.productid=a.productid
						left join gidetail f on f.gidetailid=c.gidetailid
						left join giheader g on g.giheaderid=d.giheaderid
						left join soheader h on h.soheaderid=g.soheaderid
						left join addressbook i on i.addressbookid=h.addressbookid
						left join paymentmethod j on j.paymentmethodid=h.paymentmethodid
						left join sloc k on k.slocid=a.slocid
						left join employee l on l.employeeid = h.employeeid
						where k.sloccode like '%".$sloc."%' and b.recordstatus = 3 and i.fullname like '%".$customer."%' and 
						h.companyid = ".$companyid." and e.productname like '%".$product."%' and l.fullname like '%".$sales."%' and
						d.gireturdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Penjualan - Retur Per Dokumen';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->sety($this->pdf->gety()+5);
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'Dokumen');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['notagirno']);
			$this->pdf->text(10,$this->pdf->gety()+10,'Customer');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['customer']);
			$this->pdf->text(130,$this->pdf->gety()+5,'Tanggal');$this->pdf->text(160,$this->pdf->gety()+5,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])));
			$this->pdf->text(130,$this->pdf->gety()+10,'T.O.P');$this->pdf->text(160,$this->pdf->gety()+10,': '.$row['paycode'].' HARI');                
			$sql1 = "select *,(nominal-netto) as disc from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and b.notagirid = ".$row['notagirid']." 
							and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)z order by notagirno,notagirproid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totqty=0;$totalnom=0;$totaldisk=0;$totalnett=0;
			$this->pdf->sety($this->pdf->gety()+12);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,60,20,20,30,50));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Harga','Jumlah','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R');
			$this->pdf->setFont('Arial','',8);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->row(array(
					$i,$row1['productname'],
					Yii::app()->format->formatNumber($row1['qty']),
					Yii::app()->format->formatCurrency($row1['price']/$per),
					Yii::app()->format->formatCurrency($row1['nominal']/$per),
					$row1['headernote'],
				));
				$totqty += $row1['qty'];
				$totalnom += $row1['nominal']/$per;
				$totaldisk += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$totalnett += $row1['netto']/$per;

			}
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','Keterangan : '.$row['headernote'],
				Yii::app()->format->formatNumber($totqty),
				'','Nominal',
				Yii::app()->format->formatCurrency($totalnom),
			));
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','','',
				'','Diskon',
				Yii::app()->format->formatCurrency($totaldisk),
			));
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
				'','','',
				'','Netto',
				Yii::app()->format->formatCurrency($totalnett),
			));
						
			$totqty1 += $totqty;
			$totalnom1 += $totalnom;
			$totaldisk1 += $totaldisk;
			$totalnett1 += $totalnett;			
			$this->pdf->checkPageBreak(20);
		}

		$this->pdf->coldetailalign = array('C','R','R','R','R');
			$this->pdf->setwidths(array(40,30,40,40,40));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'TOTAL RETUR PENJUALAN ',
					'QTY  '.Yii::app()->format->formatCurrency($totqty1),
					'NOMINAL  '.Yii::app()->format->formatCurrency($totalnom1),
					'DISKON  '.Yii::app()->format->formatCurrency($totaldisk1),
					'NETTO  '.Yii::app()->format->formatCurrency($totalnett1),						
			));
			$this->pdf->sety($this->pdf->gety()+10);			
			
			$this->pdf->coldetailalign = array('C','R','R','R','R');
			$this->pdf->setwidths(array(30,30,45,40,45));
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
					'GRAND TOTAL',
					'QTY  '.Yii::app()->format->formatCurrency($totalqty1-$totqty1),
					'NOMINAL  '.Yii::app()->format->formatCurrency($total1-$totalnom1),
					'DISKON  '.Yii::app()->format->formatCurrency($totaldisc1-$totaldisk1),
					'NETTO  '.Yii::app()->format->formatCurrency($totalnetto1-$totalnett1),
			));
			
			$this->pdf->Output();
	}
        //26
        public function RekapPenjualanReturPenjualanPerDokumen($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;$totalnominal2=0;$totalppn2=0;$totaljumlah2=0;
		$sql = "select invoiceno,invoicedate,fullname,headernote,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
				(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
						where a.recordstatus = 3 and a.invoiceno is not null and
                  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
                  e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
                  a.invoiceno is not null and a.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by invoiceno
                  )z group by invoiceno"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Dokumen';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
                        $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,20,20,40,30,25,25,25));
			$this->pdf->colheader = array('No','No Bukti','Tanggal','Customer','Nominal','Disc','Jumlah','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','L','L','R','R','R','L');		
			$total = 0;$i=0;$totalqty=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',7);
				$this->pdf->row(array(
					$i,$row['invoiceno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
					$row['fullname'],
					Yii::app()->format->formatCurrency($row['nominal']/$per),
					Yii::app()->format->formatCurrency($row['disc']/$per),
					Yii::app()->format->formatCurrency($row['netto']/$per),
					$row['headernote']
				));				
                $totalnominal1 += $row['nominal']/$per;
                $totaldisc1 += $row['disc']/$per;
                $totaljumlah1 += $row['netto']/$per;
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->colalign = array('C','C','C','C');
			$this->pdf->setwidths(array(40,50,50,50));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'TOTAL PENJUALAN',
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totaljumlah1),
			));
			
			$sqlo = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
           
            $dataReadero=Yii::app()->db->createCommand($sqlo)->queryAll();
            foreach($dataReadero as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            
            $this->pdf->title='Rekap Retur Penjualan Per Dokumen';
            $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
            $i=0;

            $this->pdf->sety($this->pdf->gety()+10);
            $this->pdf->setFont('Arial','B',10);
            $this->pdf->colalign = array('C','C','C','C','C','C','C');
            $this->pdf->setwidths(array(10,22,30,40,30,25,30));
            $this->pdf->colheader = array('No','Dokumen','Tanggal','Customer','Nominal','Diskons','Total');
            $this->pdf->RowHeader();
            $this->pdf->coldetailalign = array('L','L','L','L','R','R','R');
            
            foreach($dataReadero as $row)
            {
                $i+=1;
                $this->pdf->SetFont('Arial','',8);
                $this->pdf->row(array(
                        $i,$row['notagirno'],
                        $row['gireturdate'],
                        $row['fullname'],
                        Yii::app()->format->formatCurrency($row['nominal']/$per),
                        Yii::app()->format->formatCurrency(($row['nominal']/$per) - ($row['netto']/$per)),
                        Yii::app()->format->formatCurrency($row['netto']/$per),
                ));
                $totalnominal2 += $row['nominal']/$per;
                $totalppn2 += ($row['nominal']/$per) - ($row['netto']/$per);
                $totaljumlah2 += $row['netto']/$per;
                $this->pdf->checkPageBreak(20);
            }
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
					'','','','TOTAL RETUR',
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totalppn2),
						Yii::app()->format->formatCurrency($totaljumlah2),
			));			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->colalign = array('R','R','R','R','R');
                        $this->pdf->setwidths(array(40,50,35,35,35,));
			$this->pdf->row(array(
				'','GRAND TOTAL RETUR',
						Yii::app()->format->formatCurrency($totalnominal1-$totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc1-$totalppn2),
						Yii::app()->format->formatCurrency($totaljumlah1-$totaljumlah2),
			));
			$this->pdf->Output();
	}
        //27
        public function RekapPenjualanReturPenjualanPerCustomer($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;$totalnominal2=0;$totaldiskon2=0;$totalnetto2=0;
		$sql = "select distinct addressbookid,fullname from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
            
		$this->pdf->title='Rekap Penjualan - Retur Per Customer';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'Customer');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['fullname']);
			$sql1 = "select * from
							(select invoiceno as dokumen,invoicedate as tanggal,sum(nom) as nominal,(sum(nom)-sum(nett)) as diskon,sum(nett) as netto,headernote from
							(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						  from gidetail zzb 
						  join sodetail zza on zza.sodetailid = zzb.sodetailid
						  where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
							e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
							a.invoiceno is not null and a.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and d.addressbookid = ".$row['addressbookid']." order by invoiceno)z group by invoiceno
							union
							select notagirno as dokumen,gireturdate as tanggal,sum(nom) as nominal,sum(disc) as diskon,sum(nett) as netto,headernote from
							(select distinct a.notagirproid,b.notagirno,(-1*a.qty*g.price) as nom,(-1*a.qty*g.price)-(-1*a.qty*a.price) as disc,
							(-1*a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno)zz order by dokumen";
					
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totalppn = 0;$totalnominal=0;$total=0;$i=0;
			$this->pdf->sety($this->pdf->gety()+15);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,22,20,25,25,25,55));
			$this->pdf->colheader = array('No','No Dokumen','Tanggal','Nominal','Diskon','Netto','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','L');
			$this->pdf->setFont('Arial','',8);
			$totalnominal = 0;
			$totaldiskon = 0;
			$totalnetto = 0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->row(array(
					$i,$row1['dokumen'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tanggal'])),
					Yii::app()->format->formatCurrency($row1['nominal']/$per),
					Yii::app()->format->formatCurrency($row1['diskon']/$per),
					Yii::app()->format->formatCurrency($row1['netto']/$per),$row1['headernote']
				));
			$totalnominal += $row1['nominal']/$per;
			$totaldiskon += $row1['diskon']/$per;
			$totalnetto += $row1['netto']/$per;
			}
			$this->pdf->row(array(
				'','Total ','',
				Yii::app()->format->formatCurrency($totalnominal),
				Yii::app()->format->formatCurrency($totaldiskon),
				Yii::app()->format->formatCurrency($totalnetto),
			));
			$totalnominal1 += $totalnominal;
			$totaldiskon1 += $totaldiskon;
			$totalnetto1 += $totalnetto;
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->setwidths(array(40,40,50,40));
		$this->pdf->setFont('Arial','B',9);
		$this->pdf->row(array(
			'TOTAL',
			'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
			'DISKON : '.Yii::app()->format->formatCurrency($totaldiskon1),
			'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1),
		));
					
		$this->pdf->Output();
  }
        //28
        public function RekapPenjualanReturPenjualanPerSales($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;$totalnominal2=0;$totalppn2=0;$totaljumlah2=0;
		$sql = "select distinct employeeid,fullname from
			(select distinct k.employeeid,k.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join addressbook f on f.addressbookid = b.addressbookid
				join salesarea g on g.salesareaid = f.salesareaid
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				join employee k on k.employeeid = b.employeeid
				where j.recordstatus = 3 and j.invoiceno is not null 
				and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and f.fullname like '%".$customer."%' and k.fullname like '%".$sales."%'
				and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Sales';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
						
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Sales');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$sql1 = "select distinct fullname,sum(nominal) as nominal,sum(disc) as disc,sum(netto) as netto from
							(select fullname,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
							(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
                  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
                  e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
                  a.invoiceno is not null and a.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
					and e.employeeid = ".$row['employeeid'].")z group by fullname
					union
					select fullname, -1*sum(nom) as nominal, -1*(sum(nom)-sum(nett)) as disc, -1*sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by fullname) zz group by fullname order by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,30,30,30,30));
				$this->pdf->colheader = array('No','Nama Customer','Nominal','Disc','Netto');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;
				$totaldisc = 0;
				$total = 0;
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['fullname'],
						Yii::app()->format->formatCurrency($row1['nominal']/$per),
						Yii::app()->format->formatCurrency($row1['disc']/$per),
						Yii::app()->format->formatCurrency($row1['netto']/$per),
					));
					$totalnominal += $row1['nominal']/$per;
					$totaldisc += $row1['disc']/$per;
					$total += $row1['netto']/$per;
				}
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
						'','TOTAL SALES',
						Yii::app()->format->formatCurrency($totalnominal),
						Yii::app()->format->formatCurrency($totaldisc),
						Yii::app()->format->formatCurrency($total),
					));
					$totalnominal1 += $totalnominal;
					$totaldisc1 += $totaldisc;
					$totaljumlah1 += $total;
				$this->pdf->sety($this->pdf->gety()+5);	
				$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(30,50,50,50));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'TOTAL',
						'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISCOUNT : '.Yii::app()->format->formatCurrency($totaldisc1),
						'NETTO : '.Yii::app()->format->formatCurrency($totaljumlah1),
					));
			$this->pdf->Output();
	}
        //29
        public function RekapPenjualanReturPenjualanPerBarang($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
      parent::actionDownPDF();
			$totalqty1 = 0;$totalnominal1 = 0;$totaldiskon1 = 0;$totalnetto1 = 0;				
			$sql = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
			
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            
            $this->pdf->title='Rekap Penjualan - Retur Per Barang';
            $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');
			
            $this->pdf->sety($this->pdf->gety()+0);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+10,'Divisi');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
                $sql1 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row['materialgroupid']."
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row['materialgroupid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;$i=0;
                $this->pdf->sety($this->pdf->gety()+15);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,60,15,20,30,25,30));
                $this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
                $this->pdf->setFont('Arial','',8);
               
                foreach($dataReader1 as $row1)
                {
                    $i+=1;
                        $this->pdf->row(array(
                                $i,$row1['productname'],
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
                                Yii::app()->format->formatCurrency($row1['harga']/$per),
																Yii::app()->format->formatCurrency($row1['nominal']/$per),
                                Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
                                Yii::app()->format->formatCurrency($row1['netto']/$per),
                        ));
                        $totalqty += $row1['qty'];
                        $totalnominal += $row1['nominal']/$per;
												$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
                        $totalnetto += $row1['netto']/$per;
                }
                $this->pdf->row(array(
                        '','Total : '.$row['description'],
                        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totalqty),'',
                        Yii::app()->format->formatCurrency($totalnominal),
                        Yii::app()->format->formatCurrency($totaldiskon),
                        Yii::app()->format->formatCurrency($totalnetto),
                ));
					$totalqty1 += $totalqty;
					$totalnominal1 += $totalnominal;
					$totaldiskon1 += $totaldiskon;
					$totalnetto1 += $totalnetto;
                $this->pdf->checkPageBreak(20);
            }
			
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->colalign = array('C','R','R','R');
				$this->pdf->setwidths(array(30,30,45,40,45));
				$this->pdf->sety($this->pdf->gety()+5);
				$this->pdf->row(array(
						'GRAND TOTAL',
						'QTY  '.Yii::app()->format->formatCurrency($totalqty1),
						'NOMINAL  '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISKON  '.Yii::app()->format->formatCurrency($totaldiskon1),
						'NETTO  '.Yii::app()->format->formatCurrency($totalnetto1),
					));
            $this->pdf->Output();
    }
        //30
        public function RekapPenjualanReturPenjualanPerArea($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
			$totalqty1 = 0;
			$totalnominal1 = 0;
			$totaldiskon1 = 0;
			$totalnetto1 = 0;
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$sales."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Retur Penjualan Per Area';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'Area');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row['areaname']);
			$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zg.salesareaid = ".$row['salesareaid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(10,$this->pdf->gety()+15,'Grup Material');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and f.salesareaid = ".$row['salesareaid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty),-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,a.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$totalnetto = 0;$totalnominal=0;$totaldiskon=0;$i=0;$totalqty=0;
					$this->pdf->sety($this->pdf->gety()+20);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,80,20,30,20,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Nominal','Diskon','Netto');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('L','L','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					foreach($dataReader2 as $row2)
					{
                        $i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['qty']),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldiskon += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;
					}
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','Total '.$row1['description'],
							Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldiskon),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldiskon1 += $totaldiskon;
						$totalnetto1 += $totalnetto;
					$this->pdf->checkPageBreak(20);
				}
		}
			$this->pdf->colalign = array('C','R','R','R');
			$this->pdf->setwidths(array(30,30,45,40,45));
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->row(array(
			'GRAND TOTAL :',
			'QTY  '.Yii::app()->format->formatNumber($totalqty1),
			'NOMINAL  '.Yii::app()->format->formatCurrency($totalnominal1),
			'DISKON  '.Yii::app()->format->formatCurrency($totaldiskon1),
			'NETTO  '.Yii::app()->format->formatCurrency($totalnetto1),
			));
		$this->pdf->Output();
	}
        //31
        public function RekapPenjualanReturPenjualanPerCustomerPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select * from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Customer Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Customer');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.addressbookid = ".$row['addressbookid']." and
						  e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by barang) zz group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL CUSTOMER '.$row['fullname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
        }
        //32
        public function RekapPenjualanReturPenjualanPerCustomerPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totaljumlah1=0;$totalnominal2=0;$totalppn2=0;$totaljumlah2=0;
		$sql = "select distinct addressbookid,fullname from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Customer Per Barang - Rincian';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Customer');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zf.addressbookid = ".$row['addressbookid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','',10);
					$this->pdf->text(10,$this->pdf->gety()+10,'Material Group');$this->pdf->text(40,$this->pdf->gety()+10,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and d.addressbookid = ".$row['addressbookid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+15);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,20,20,30,20,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;
						
					}
					$this->pdf->row(array(
							'','Total '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totaljumlah1 += $totalnetto;
						
					$this->pdf->checkPageBreak(20);
				}
			}
				$this->pdf->colalign = array('C','C','C','C','C');
				$this->pdf->setwidths(array(20,40,40,40,40));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'TOTAL',
						'QTY : '.Yii::app()->format->formatNumber($totalqty1),
						'NOMINAL : '.Yii::app()->format->formatCurrency($totalnominal1),
						'DISCOUNT : '.Yii::app()->format->formatCurrency($totaldisc1),
						'JUMLAH : '.Yii::app()->format->formatCurrency($totaljumlah1),
					));
			$this->pdf->Output();
	}
        //33
        public function RekapPenjualanReturPenjualanPerSalesPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct employeeid,fullname from
			(select distinct k.employeeid,k.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join addressbook f on f.addressbookid = b.addressbookid
				join salesarea g on g.salesareaid = f.salesareaid
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				join employee k on k.employeeid = b.employeeid
				where j.recordstatus = 3 and j.invoiceno is not null 
				and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and f.fullname like '%".$customer."%' and k.fullname like '%".$sales."%'
				and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Sales Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Sales');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from 
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and e.employeeid = ".$row['employeeid']." and
						  e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z group by barang) zz 
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL SALES '.$row['fullname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //34
        public function RekapPenjualanReturPenjualanPerSalesPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct employeeid,fullname from
			(select distinct k.employeeid,k.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join addressbook f on f.addressbookid = b.addressbookid
				join salesarea g on g.salesareaid = f.salesareaid
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				join employee k on k.employeeid = b.employeeid
				where j.recordstatus = 3 and j.invoiceno is not null 
				and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and f.fullname like '%".$customer."%' and k.fullname like '%".$sales."%'
				and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Sales Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Sales');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['fullname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zd.employeeid = ".$row['employeeid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and e.employeeid = ".$row['employeeid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL SALES '.$row['fullname'],
				Yii::app()->format->formatCurrency($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(20);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatCurrency($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
	}
        //35
        public function RekapPenjualanReturPenjualanPerAreaPerBarangTotal($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$sales."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Area Per Barang - Total';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
									
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['areaname']);
				$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+8);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,60,20,35,30,35));
				$this->pdf->colheader = array('No','Material Group','Qty','Total','Disc','Netto');
				$this->pdf->RowHeader();
				
				$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and f.salesareaid = ".$row['salesareaid']." and
						  e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z group by barang) zz 
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->coldetailalign = array('L','L','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				$totalnominal = 0;$totalqty = 0;$totaldisc = 0;$totalnetto = 0;
					
				foreach($dataReader1 as $row1)
				{
						$i+=1;
						$this->pdf->row(array(
							$i,$row1['barang'],
							Yii::app()->format->formatNumber($row1['qty']),
							Yii::app()->format->formatCurrency($row1['nominal']/$per),
							Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)),
							Yii::app()->format->formatCurrency($row1['netto']/$per),
						));
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;						
				}
					$this->pdf->setFont('Arial','B',9);
					$this->pdf->row(array(
							'','TOTAL AREA '.$row['areaname'],
							Yii::app()->format->formatNumber($totalqty),
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
					$this->pdf->sety($this->pdf->gety()+3);	
					$this->pdf->checkPageBreak(20);
			}
				$this->pdf->colalign = array('L','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatNumber($totalqty1),
						Yii::app()->format->formatCurrency($totalnominal1),
						Yii::app()->format->formatCurrency($totaldisc1),
						Yii::app()->format->formatCurrency($totalnetto1),
					));
					
			$this->pdf->Output();
	}
        //36
        public function RekapPenjualanReturPenjualanPerAreaPerBarangRincian($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalnominal2=0;$totalqty2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$sales."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Area Per Barang (Rincian)';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','B',10);
				$this->pdf->text(10,$this->pdf->gety()+5,'Area');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row['areaname']);
				$this->pdf->sety($this->pdf->gety()+8);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,60,15,20,30,25,30));
					$this->pdf->colheader = array('No','Nama Barang','Qty','Price','Total','Disc','Netto');
					$this->pdf->RowHeader();
					$totalnominal1=0;$totalqty1=0;$totaldisc1=0;$totalnetto1=0;
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$sales."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zg.salesareaid = ".$row['salesareaid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->SetFont('Arial','B',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Material Group');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['description']);
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$sales."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and f.salesareaid = ".$row['salesareaid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$sales."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$totalnominal = 0;
					$totalqty = 0;
					$totaldisc = 0;
					$totalnetto = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['productname'],
							Yii::app()->format->formatNumber($row2['qty']),
							Yii::app()->format->formatCurrency($row2['harga']/$per),
							Yii::app()->format->formatCurrency($row2['nominal']/$per),
							Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)),
							Yii::app()->format->formatCurrency($row2['netto']/$per),
						));
						$totalqty += $row2['qty'];
						$totalnominal += $row2['nominal']/$per;
						$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
						$totalnetto += $row2['netto']/$per;						
					}
					
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->row(array(
							'','TOTAL '.$row1['description'],
							Yii::app()->format->formatNumber($totalqty),'',
							Yii::app()->format->formatCurrency($totalnominal),
							Yii::app()->format->formatCurrency($totaldisc),
							Yii::app()->format->formatCurrency($totalnetto),
						));
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldisc1 += $totaldisc;
						$totalnetto1 += $totalnetto;
										
				}
			
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
				'','TOTAL AREA '.$row['areaname'],
				Yii::app()->format->formatNumber($totalqty1),'',
				Yii::app()->format->formatCurrency($totalnominal1),
				Yii::app()->format->formatCurrency($totaldisc1),
				Yii::app()->format->formatCurrency($totalnetto1),
				));
				$totalqty2 += $totalqty1;
				$totalnominal2 += $totalnominal1;
				$totaldisc2 += $totaldisc1;
				$totalnetto2 += $totalnetto1;
				
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(20);
			
			}
			
				$this->pdf->colalign = array('C','R','R','R','R');
				$this->pdf->setwidths(array(70,20,35,30,35));
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->row(array(
						'GRAND TOTAL',
						Yii::app()->format->formatCurrency($totalqty2),
						Yii::app()->format->formatCurrency($totalnominal2),
						Yii::app()->format->formatCurrency($totaldisc2),
						Yii::app()->format->formatCurrency($totalnetto2),
					));
			$this->pdf->Output();
			
			
			
			
			
			
	}
        //37
        public function RincianSalesOrderOutstanding($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select a.soheaderid,a.sodate,a.sono,b.fullname as customer,d.fullname as sales,g.slocid,a.headernote,
			c.paydays
			from soheader a
			join addressbook b on b.addressbookid = a.addressbookid
			join paymentmethod c on c.paymentmethodid = a.paymentmethodid
			join employee d on d.employeeid = a.employeeid
			join salesarea e on e.salesareaid = b.salesareaid
			join sodetail f on f.soheaderid = a.soheaderid
			join sloc g on g.slocid = f.slocid
			where a.recordstatus > 2 and f.qty > f.giqty and a.companyid = ".$companyid." and 
			d.fullname like '%".$sales."%' and b.fullname like '%".$customer."%' and e.areaname like '%".$salesarea."%' and 
			a.sodate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
			'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
			and f.productid in 
			(select x.productid 
			from sodetail x 
			join product xx on xx.productid = x.productid 
			join sloc xa on xa.slocid = x.slocid
			where xx.productname like '%".$product."%' and x.giqty < x.qty and xx.isstock = 1 and 
			xa.sloccode like '%".$sloc."%') group by soheaderid";	
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Sales Order Outstanding';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'No SO');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['sono']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Sales');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['sales']);
				$this->pdf->text(10,$this->pdf->gety()+20,'Customer');$this->pdf->text(30,$this->pdf->gety()+20,': '.$row['customer']);
				$this->pdf->text(150,$this->pdf->gety()+10,'Tgl SO');$this->pdf->text(180,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['sodate'])));
				$this->pdf->text(150,$this->pdf->gety()+20,'T.O.P');$this->pdf->text(180,$this->pdf->gety()+20,': '.$row['paydays'].' HARI');
				
				$sql1 = "select productname, giqty, qty, price, uomcode, jumlah, amountafterdisc from (select b.productname, a.qty, a.giqty, c.uomcode,a.price,(qty * price) + (e.taxvalue * qty * price / 100) as jumlah, a.qty-ifnull(a.giqty,0) as sisa, gettotalamountdiscso(a.soheaderid) as amountafterdisc
						from sodetail a 
						inner join product b on b.productid = a.productid
						inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
						left join currency d on d.currencyid = a.currencyid
						left join soheader f on f.soheaderid = a.soheaderid 
						left join tax e on e.taxid = f.taxid
						join product g on g.productid = a.productid
						where b.productname like '%".$product."%' and g.isstock = 1 and a.soheaderid = '".$row['soheaderid']."') z 
						where sisa > 0";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;$totalgiqty=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,65,20,20,15,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Qty Gi','Satuan','Harga','Jumlah');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','C','R','R');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),
						Yii::app()->format->formatNumber($row1['giqty']),
						$row1['uomcode'],
						Yii::app()->format->formatCurrency($row1['price']/$per),
						Yii::app()->format->formatCurrency($row1['jumlah']/$per),
					));
					$totalqty += $row1['qty'];
					$totalgiqty += $row1['giqty'];
					$total += $row1['jumlah']/$per;
					$disc = ($row1['amountafterdisc']/$per) - $total;

				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),
						Yii::app()->format->formatNumber($totalgiqty),'',
						Yii::app()->format->formatCurrency($total),
					));
				$this->pdf->row(array(
						'','',
						'',
						'',
						'Disc',
						Yii::app()->format->formatCurrency($disc),
					));
				$this->pdf->row(array(
						'','',
						'',
						'',
						'Netto',
						Yii::app()->format->formatCurrency($row1['amountafterdisc']/$per),
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
        //38
        public function RekapSuratJalanBelumDibuatkanFaktur($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select a.gino,a.gidate,c.fullname as customer,d.fullname as sales,a.headernote
                        from giheader a
                        join soheader b on b.soheaderid = a.soheaderid
                        join addressbook c on c.addressbookid = b.addressbookid
                        join employee d on d.employeeid = b.employeeid
                        join salesarea e on e.salesareaid = c.salesareaid
                        join gidetail f on f.giheaderid = a.giheaderid
                        join sloc g on g.slocid = f.slocid
                        join product h on h.productid = f.productid
                        where a.giheaderid not in
                        (select t.giheaderid from invoice t)
                        and a.gino is not null
                        and b.companyid = ".$companyid." and g.sloccode like '%".$sloc."%' and c.fullname like '%".$customer."%' and
                         d.fullname like '%".$sales."%' and e.areaname like '%".$salesarea."%' and h.productname like '%".$product."%' and
                         a.gidate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
			and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by gino,customer,sales order by gino";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Surat Jalan Belum Dibuatkan Faktur';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
                        $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,20,20,60,55,25));
			$this->pdf->colheader = array('No','No Bukti','Tanggal','Customer','Sales','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','C','C','L','L','L');		
			$total = 0;$i=0;$totalqty=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',7);
				$this->pdf->row(array(
					$i,$row['gino'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])),
					$row['customer'],
					$row['sales'],
					$row['headernote']
				));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
        //39
        public function RekapPenjualanPerCustomerPerBulanPerTahun($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
				where zz.jumlah <> 0"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan Per Customer Per Bulan';
			$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
			$this->pdf->AddPage('P',array(400,140));
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');		
			
			foreach($dataReader as $row)
			{
				$this->pdf->setFont('Arial','',7);
				$i=$i+1;
				$this->pdf->row(array(
					$i,$row['fullname'],
					Yii::app()->format->formatCurrency($row['januari']/$per),
					Yii::app()->format->formatCurrency($row['februari']/$per),
					Yii::app()->format->formatCurrency($row['maret']/$per),
					Yii::app()->format->formatCurrency($row['april']/$per),
					Yii::app()->format->formatCurrency($row['mei']/$per),
					Yii::app()->format->formatCurrency($row['juni']/$per),
					Yii::app()->format->formatCurrency($row['juli']/$per),
					Yii::app()->format->formatCurrency($row['agustus']/$per),
					Yii::app()->format->formatCurrency($row['september']/$per),
					Yii::app()->format->formatCurrency($row['oktober']/$per),
					Yii::app()->format->formatCurrency($row['nopember']/$per),
					Yii::app()->format->formatCurrency($row['desember']/$per),
					Yii::app()->format->formatCurrency($row['jumlah']/$per)
				));
				$totaljanuari += $row['januari']/$per;
        $totalfebruari += $row['februari']/$per;
				$totalmaret += $row['maret']/$per;
				$totalapril += $row['april']/$per;
				$totalmei += $row['mei']/$per;
				$totaljuni += $row['juni']/$per;
				$totaljuli += $row['juli']/$per;
				$totalagustus += $row['agustus']/$per;
				$totalseptember += $row['september']/$per;
				$totaloktober += $row['oktober']/$per;
				$totalnopember += $row['nopember']/$per;
				$totaldesember += $row['desember']/$per;
				$totaljumlah += $row['jumlah']/$per;
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'','TOTAL',
						Yii::app()->format->formatCurrency($totaljanuari),
						Yii::app()->format->formatCurrency($totalfebruari),
						Yii::app()->format->formatCurrency($totalmaret),
						Yii::app()->format->formatCurrency($totalapril),
						Yii::app()->format->formatCurrency($totalmei),
						Yii::app()->format->formatCurrency($totaljuni),
						Yii::app()->format->formatCurrency($totaljuli),
						Yii::app()->format->formatCurrency($totalagustus),
						Yii::app()->format->formatCurrency($totalseptember),
						Yii::app()->format->formatCurrency($totaloktober),
						Yii::app()->format->formatCurrency($totalnopember),
						Yii::app()->format->formatCurrency($totaldesember),
						Yii::app()->format->formatCurrency($totaljumlah),
			));
			$this->pdf->Output();
	}
        //40
        public function RekapReturPenjualanPerCustomerPerBulanPerTahun($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
				where zz.jumlah <> 0"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Retur Penjualan Per Customer Per Bulan';
			$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
			$this->pdf->AddPage('P',array(400,140));
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');		
			
			foreach($dataReader as $row)
			{
				$this->pdf->setFont('Arial','',7);
				$i=$i+1;
				$this->pdf->row(array(
					$i,$row['fullname'],
					Yii::app()->format->formatCurrency($row['januari']/$per),
					Yii::app()->format->formatCurrency($row['februari']/$per),
					Yii::app()->format->formatCurrency($row['maret']/$per),
					Yii::app()->format->formatCurrency($row['april']/$per),
					Yii::app()->format->formatCurrency($row['mei']/$per),
					Yii::app()->format->formatCurrency($row['juni']/$per),
					Yii::app()->format->formatCurrency($row['juli']/$per),
					Yii::app()->format->formatCurrency($row['agustus']/$per),
					Yii::app()->format->formatCurrency($row['september']/$per),
					Yii::app()->format->formatCurrency($row['oktober']/$per),
					Yii::app()->format->formatCurrency($row['nopember']/$per),
					Yii::app()->format->formatCurrency($row['desember']/$per),
					Yii::app()->format->formatCurrency($row['jumlah']/$per)
				));
				$totaljanuari += $row['januari']/$per;
        $totalfebruari += $row['februari']/$per;
				$totalmaret += $row['maret']/$per;
				$totalapril += $row['april']/$per;
				$totalmei += $row['mei']/$per;
				$totaljuni += $row['juni']/$per;
				$totaljuli += $row['juli']/$per;
				$totalagustus += $row['agustus']/$per;
				$totalseptember += $row['september']/$per;
				$totaloktober += $row['oktober']/$per;
				$totalnopember += $row['nopember']/$per;
				$totaldesember += $row['desember']/$per;
				$totaljumlah += $row['jumlah']/$per;
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'','TOTAL',
						Yii::app()->format->formatCurrency($totaljanuari),
						Yii::app()->format->formatCurrency($totalfebruari),
						Yii::app()->format->formatCurrency($totalmaret),
						Yii::app()->format->formatCurrency($totalapril),
						Yii::app()->format->formatCurrency($totalmei),
						Yii::app()->format->formatCurrency($totaljuni),
						Yii::app()->format->formatCurrency($totaljuli),
						Yii::app()->format->formatCurrency($totalagustus),
						Yii::app()->format->formatCurrency($totalseptember),
						Yii::app()->format->formatCurrency($totaloktober),
						Yii::app()->format->formatCurrency($totalnopember),
						Yii::app()->format->formatCurrency($totaldesember),
						Yii::app()->format->formatCurrency($totaljumlah),
			));
			$this->pdf->Output();
	}
        //41
        public function RekapPenjualanReturPenjualanPerCustomerPerBulanPerTahun($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
				where zz.jumlah <> 0"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan - Retur Per Customer Per Bulan';
			$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
			$this->pdf->AddPage('P',array(400,140));
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');		
			
			foreach($dataReader as $row)
			{
				$this->pdf->setFont('Arial','',7);
				$i=$i+1;
				$this->pdf->row(array(
					$i,$row['fullname'],
					Yii::app()->format->formatCurrency($row['januari']/$per),
					Yii::app()->format->formatCurrency($row['februari']/$per),
					Yii::app()->format->formatCurrency($row['maret']/$per),
					Yii::app()->format->formatCurrency($row['april']/$per),
					Yii::app()->format->formatCurrency($row['mei']/$per),
					Yii::app()->format->formatCurrency($row['juni']/$per),
					Yii::app()->format->formatCurrency($row['juli']/$per),
					Yii::app()->format->formatCurrency($row['agustus']/$per),
					Yii::app()->format->formatCurrency($row['september']/$per),
					Yii::app()->format->formatCurrency($row['oktober']/$per),
					Yii::app()->format->formatCurrency($row['nopember']/$per),
					Yii::app()->format->formatCurrency($row['desember']/$per),
					Yii::app()->format->formatCurrency($row['jumlah']/$per)
				));
				$totaljanuari += $row['januari']/$per;
        $totalfebruari += $row['februari']/$per;
				$totalmaret += $row['maret']/$per;
				$totalapril += $row['april']/$per;
				$totalmei += $row['mei']/$per;
				$totaljuni += $row['juni']/$per;
				$totaljuli += $row['juli']/$per;
				$totalagustus += $row['agustus']/$per;
				$totalseptember += $row['september']/$per;
				$totaloktober += $row['oktober']/$per;
				$totalnopember += $row['nopember']/$per;
				$totaldesember += $row['desember']/$per;
				$totaljumlah += $row['jumlah']/$per;
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array(
					'','TOTAL',
						Yii::app()->format->formatCurrency($totaljanuari),
						Yii::app()->format->formatCurrency($totalfebruari),
						Yii::app()->format->formatCurrency($totalmaret),
						Yii::app()->format->formatCurrency($totalapril),
						Yii::app()->format->formatCurrency($totalmei),
						Yii::app()->format->formatCurrency($totaljuni),
						Yii::app()->format->formatCurrency($totaljuli),
						Yii::app()->format->formatCurrency($totalagustus),
						Yii::app()->format->formatCurrency($totalseptember),
						Yii::app()->format->formatCurrency($totaloktober),
						Yii::app()->format->formatCurrency($totalnopember),
						Yii::app()->format->formatCurrency($totaldesember),
						Yii::app()->format->formatCurrency($totaljumlah),
			));
			$this->pdf->Output();
	}
	public function RekapPeriodik($companyid,$sloc,$customer,$sales,$product,$salesarea,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select fullname,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 1 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as januari,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 2 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as februari,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 3 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as maret,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 4 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as april,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 5 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as mei,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 6 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as juni,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 7 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as juli,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 8 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as agustus,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 9 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as september,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 10 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as oktober,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 11 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as november,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where a.addressbookid = b.addressbookid and month(a.sodate) = 12 and year(a.sodate) = year('".Yii::app()->format->formatDateSQL($startdate)."')
) as desember
from addressbook b
where iscustomer = 1
order by fullname";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan Periodik';
			$this->pdf->AddPage('L',array(200,350));
			$this->pdf->sety($this->pdf->gety()+20);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,40,22,22,22,22,22,22,22,22,22,22,22,22));
      $this->pdf->colheader = array('No','Customer','Jan','Feb','Mar','Apr','Mei','Juni','Jul','Agt',
	'Sep','Okt','Nov','Des');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
			$i=0;$januari=0;$februari=0;$maret=0;$april=0;$mei=0;$juni=0;$juli=0;$agustus=0;$september=0;$oktober=0;$november=0;$desember=0;
			foreach($dataReader as $row)
			{

					$i+=1;
					$this->pdf->rowstyles = array(
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7),
						array('Arial','',7)
						);
					$this->pdf->row(array(
						$i,$row['fullname'],
						Yii::app()->format->formatCurrency($row['januari']),
						Yii::app()->format->formatCurrency($row['februari']),
						Yii::app()->format->formatCurrency($row['maret']),
						Yii::app()->format->formatCurrency($row['april']),
						Yii::app()->format->formatCurrency($row['mei']),
						Yii::app()->format->formatCurrency($row['juni']),
						Yii::app()->format->formatCurrency($row['juli']),
						Yii::app()->format->formatCurrency($row['agustus']),
						Yii::app()->format->formatCurrency($row['september']),
						Yii::app()->format->formatCurrency($row['oktober']),
						Yii::app()->format->formatCurrency($row['november']),
						Yii::app()->format->formatCurrency($row['desember']),
					));
					$januari+= $row['januari'];
					$februari+= $row['februari'];
					$maret+= $row['maret'];
					$april+= $row['april'];
					$mei+= $row['mei'];
					$juni+= $row['juni'];
					$juli+= $row['juli'];
					$agustus+= $row['agustus'];
					$september+= $row['september'];
					$oktober+= $row['oktober'];
					$november+= $row['november'];
					$desember+= $row['desember'];
					
				$this->pdf->checkPageBreak(20);
			}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatCurrency($januari),
						Yii::app()->format->formatCurrency($februari),
						Yii::app()->format->formatCurrency($maret),
						Yii::app()->format->formatCurrency($april),
						Yii::app()->format->formatCurrency($mei),
						Yii::app()->format->formatCurrency($juni),
						Yii::app()->format->formatCurrency($juli),
						Yii::app()->format->formatCurrency($agustus),
						Yii::app()->format->formatCurrency($september),
						Yii::app()->format->formatCurrency($oktober),
						Yii::app()->format->formatCurrency($november),
						Yii::app()->format->formatCurrency($desember),
					));		
			$this->pdf->Output();
	}
       
	public function RekapPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Penjualan Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'JENIS CUSTOMER ');$this->pdf->text(45,$this->pdf->gety()+5,': '.$row['jenis']);
			$this->pdf->sety($this->pdf->gety()+7);
			$sql1 = "select * from
					(select z.fullname,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
					from addressbook z
					where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
					and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
					where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setFont('Arial','',7);
					$i=$i+1;
					$this->pdf->row(array(
						$i,$row1['fullname'],
						Yii::app()->format->formatCurrency($row1['januari']/$per),
						Yii::app()->format->formatCurrency($row1['februari']/$per),
						Yii::app()->format->formatCurrency($row1['maret']/$per),
						Yii::app()->format->formatCurrency($row1['april']/$per),
						Yii::app()->format->formatCurrency($row1['mei']/$per),
						Yii::app()->format->formatCurrency($row1['juni']/$per),
						Yii::app()->format->formatCurrency($row1['juli']/$per),
						Yii::app()->format->formatCurrency($row1['agustus']/$per),
						Yii::app()->format->formatCurrency($row1['september']/$per),
						Yii::app()->format->formatCurrency($row1['oktober']/$per),
						Yii::app()->format->formatCurrency($row1['nopember']/$per),
						Yii::app()->format->formatCurrency($row1['desember']/$per),
						Yii::app()->format->formatCurrency($row1['jumlah']/$per)
					));
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
				$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
					'','TOTAL '.$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}

public function RekapReturPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Retur Penjualan Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'JENIS CUSTOMER ');$this->pdf->text(45,$this->pdf->gety()+5,': '.$row['jenis']);
			$this->pdf->sety($this->pdf->gety()+7);
			$sql1 = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setFont('Arial','',7);
					$i=$i+1;
					$this->pdf->row(array(
						$i,$row1['fullname'],
						Yii::app()->format->formatCurrency($row1['januari']/$per),
						Yii::app()->format->formatCurrency($row1['februari']/$per),
						Yii::app()->format->formatCurrency($row1['maret']/$per),
						Yii::app()->format->formatCurrency($row1['april']/$per),
						Yii::app()->format->formatCurrency($row1['mei']/$per),
						Yii::app()->format->formatCurrency($row1['juni']/$per),
						Yii::app()->format->formatCurrency($row1['juli']/$per),
						Yii::app()->format->formatCurrency($row1['agustus']/$per),
						Yii::app()->format->formatCurrency($row1['september']/$per),
						Yii::app()->format->formatCurrency($row1['oktober']/$per),
						Yii::app()->format->formatCurrency($row1['nopember']/$per),
						Yii::app()->format->formatCurrency($row1['desember']/$per),
						Yii::app()->format->formatCurrency($row1['jumlah']/$per)
					));
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
				$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
					'','TOTAL '.$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}

	public function RekapPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Penjualan - Retur Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'JENIS CUSTOMER ');$this->pdf->text(45,$this->pdf->gety()+5,': '.$row['jenis']);
			$this->pdf->sety($this->pdf->gety()+7);
			$sql1 = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setFont('Arial','',7);
					$i=$i+1;
					$this->pdf->row(array(
						$i,$row1['fullname'],
						Yii::app()->format->formatCurrency($row1['januari']/$per),
						Yii::app()->format->formatCurrency($row1['februari']/$per),
						Yii::app()->format->formatCurrency($row1['maret']/$per),
						Yii::app()->format->formatCurrency($row1['april']/$per),
						Yii::app()->format->formatCurrency($row1['mei']/$per),
						Yii::app()->format->formatCurrency($row1['juni']/$per),
						Yii::app()->format->formatCurrency($row1['juli']/$per),
						Yii::app()->format->formatCurrency($row1['agustus']/$per),
						Yii::app()->format->formatCurrency($row1['september']/$per),
						Yii::app()->format->formatCurrency($row1['oktober']/$per),
						Yii::app()->format->formatCurrency($row1['nopember']/$per),
						Yii::app()->format->formatCurrency($row1['desember']/$per),
						Yii::app()->format->formatCurrency($row1['jumlah']/$per)
					));
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
				$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
					'','TOTAL '.$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}
	public function RekapTotalPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Total Penjualan Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$sql1 = "select * from
					(select z.fullname,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
					from addressbook z
					where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
					and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
					where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$i=$i+1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}
	public function RincianSalesOrderPerDokumen($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select a.soheaderid,a.sodate,a.sono,b.fullname as customer,d.fullname as sales,g.slocid,a.headernote,
			c.paydays
			from soheader a
			join addressbook b on b.addressbookid = a.addressbookid
			join paymentmethod c on c.paymentmethodid = a.paymentmethodid
			join employee d on d.employeeid = a.employeeid
			join salesarea e on e.salesareaid = b.salesareaid
			join sodetail f on f.soheaderid = a.soheaderid
			join sloc g on g.slocid = f.slocid
			where a.recordstatus = 6 and b.fullname like '%".$customer."%' and a.companyid = ".$companyid." and 
			d.fullname like '%".$employee."%' and e.areaname like '%".$salesarea."%' and 
			a.sodate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
			'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
			and f.productid in 
			(select x.productid 
			from productplant x 
			join product xx on xx.productid = x.productid 
			join sloc xa on xa.slocid = x.slocid
			where xx.productname like '%".$product."%' and 
			xa.sloccode like '%".$sloc."%') group by soheaderid";	
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Sales Order Per Dokumen';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'No SO');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['sono']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Sales');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['sales']);
				$this->pdf->text(10,$this->pdf->gety()+20,'Customer');$this->pdf->text(30,$this->pdf->gety()+20,': '.$row['customer']);
				$this->pdf->text(150,$this->pdf->gety()+10,'Tgl SO');$this->pdf->text(180,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['sodate'])));
				$this->pdf->text(150,$this->pdf->gety()+20,'T.O.P');$this->pdf->text(180,$this->pdf->gety()+20,': '.$row['paydays'].' HARI');
				$sql1 = "select b.productname, a.qty,c.uomcode,a.price,(qty * price) + (e.taxvalue * qty * price / 100) as jumlah,
						gettotalamountdiscso(a.soheaderid) as amountafterdisc
						from sodetail a 
						inner join product b on b.productid = a.productid
						inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
						left join currency d on d.currencyid = a.currencyid
						left join soheader f on f.soheaderid = a.soheaderid 
						left join tax e on e.taxid = f.taxid
						where b.productname like '%".$product."%' and a.soheaderid = '".$row['soheaderid']."'";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,20,20,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Harga','Jumlah');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','C','R','R');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],
						Yii::app()->format->formatCurrency($row1['price']/$per),
						Yii::app()->format->formatCurrency($row1['jumlah']/$per),
					));
					$totalqty += $row1['qty'];
					$total += $row1['jumlah']/$per;
					$disc = ($row1['amountafterdisc']/$per) - $total;
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						'',
						Yii::app()->format->formatCurrency($total),
					));
				$this->pdf->row(array(
						'','',
						'',
						'',
						'Disc',
						Yii::app()->format->formatCurrency($disc),
					));
				$this->pdf->row(array(
						'','',
						'',
						'',
						'Netto',
						Yii::app()->format->formatCurrency($row1['amountafterdisc']/$per),
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}

public function RekapTotalReturPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Total Retur Penjualan Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$sql1 = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$i=$i+1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}
	public function RekapTotalPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahun($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
				
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Total Penjualan - Retur Per Jenis Customer Per Bulan';
		$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
		$this->pdf->AddPage('P',array(400,140));
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row)
		{	
			$sql1 = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
				
				
				foreach($dataReader1 as $row1)
				{
					$totaljanuari += $row1['januari']/$per;
					$totalfebruari += $row1['februari']/$per;
					$totalmaret += $row1['maret']/$per;
					$totalapril += $row1['april']/$per;
					$totalmei += $row1['mei']/$per;
					$totaljuni += $row1['juni']/$per;
					$totaljuli += $row1['juli']/$per;
					$totalagustus += $row1['agustus']/$per;
					$totalseptember += $row1['september']/$per;
					$totaloktober += $row1['oktober']/$per;
					$totalnopember += $row1['nopember']/$per;
					$totaldesember += $row1['desember']/$per;
					$totaljumlah += $row1['jumlah']/$per;
					$this->pdf->checkPageBreak(20);
				}
				$i=$i+1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row['jenis'],
					Yii::app()->format->formatCurrency($totaljanuari),
					Yii::app()->format->formatCurrency($totalfebruari),
					Yii::app()->format->formatCurrency($totalmaret),
					Yii::app()->format->formatCurrency($totalapril),
					Yii::app()->format->formatCurrency($totalmei),
					Yii::app()->format->formatCurrency($totaljuni),
					Yii::app()->format->formatCurrency($totaljuli),
					Yii::app()->format->formatCurrency($totalagustus),
					Yii::app()->format->formatCurrency($totalseptember),
					Yii::app()->format->formatCurrency($totaloktober),
					Yii::app()->format->formatCurrency($totalnopember),
					Yii::app()->format->formatCurrency($totaldesember),
					Yii::app()->format->formatCurrency($totaljumlah),
				));
				
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->pdf->colalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaljanuari1),
			Yii::app()->format->formatCurrency($totalfebruari1),
			Yii::app()->format->formatCurrency($totalmaret1),
			Yii::app()->format->formatCurrency($totalapril1),
			Yii::app()->format->formatCurrency($totalmei1),
			Yii::app()->format->formatCurrency($totaljuni1),
			Yii::app()->format->formatCurrency($totaljuli1),
			Yii::app()->format->formatCurrency($totalagustus1),
			Yii::app()->format->formatCurrency($totalseptember1),
			Yii::app()->format->formatCurrency($totaloktober1),
			Yii::app()->format->formatCurrency($totalnopember1),
			Yii::app()->format->formatCurrency($totaldesember1),
			Yii::app()->format->formatCurrency($totaljumlah1),
		));
		
		$this->pdf->Output();
	}

        public function actionDownXLS()
	{
	  parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['customer']) && isset($_GET['sales']) && isset($_GET['product']) && isset($_GET['salesarea']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 1)
			{
				$this->RincianPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 2)
			{
				$this->RekapPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 3)
			{
				$this->RekapPenjualanPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 4)
			{
				$this->RekapPenjualanPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 5)
			{
				$this->RekapPenjualanPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RekapPenjualanPerAreaXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RekapPenjualanPerCustomerPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RekapPenjualanPerCustomerPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RekapPenjualanPerSalesPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RekapPenjualanPerSalesPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->RekapPenjualanPerAreaPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
				$this->RekapPenjualanPerAreaPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 13)
			{
				$this->RincianReturPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 14)
			{
				$this->RekapReturPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 15)
			{
				$this->RekapReturPenjualanPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 16)
			{
				$this->RekapReturPenjualanPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 17)
			{
				$this->RekapReturPenjualanPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 18)
			{
				$this->RekapReturPenjualanPerAreaXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 19)
			{
				$this->RekapReturPenjualanPerCustomerPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 20)
			{
				$this->RekapReturPenjualanPerCustomerPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 21)
			{
				$this->RekapReturPenjualanPerSalesPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 22)
			{
				$this->RekapReturPenjualanPerSalesPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 23)
			{
				$this->RekapReturPenjualanPerAreaPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 24)
			{
				$this->RekapReturPenjualanPerAreaPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 25)
			{
				$this->RincianPenjualanReturPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 26)
			{
				$this->RekapPenjualanReturPenjualanPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 27)
			{
				$this->RekapPenjualanReturPenjualanPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 28)
			{
				$this->RekapPenjualanReturPenjualanPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 29)
			{
				$this->RekapPenjualanReturPenjualanPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 30)
			{
				$this->RekapPenjualanReturPenjualanPerAreaXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 31)
			{
				$this->RekapPenjualanReturPenjualanPerCustomerPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 32)
			{
				$this->RekapPenjualanReturPenjualanPerCustomerPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 33)
			{
				$this->RekapPenjualanReturPenjualanPerSalesPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 34)
			{
				$this->RekapPenjualanReturPenjualanPerSalesPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 35)
			{
				$this->RekapPenjualanReturPenjualanPerAreaPerBarangTotalXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 36)
			{
				$this->RekapPenjualanReturPenjualanPerAreaPerBarangRincianXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 37)
			{
				$this->RincianSalesOrderOutstandingXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
            else
			if ($_GET['lro'] == 38)
			{
				$this->RekapSuratJalanBelumDibuatkanFakturXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
            else
			if ($_GET['lro'] == 39)
			{
				$this->RekapPenjualanPerCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 40)
			{
				$this->RekapReturPenjualanPerCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 41)
			{
				$this->RekapReturPenjualanPerCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 42)
			{
				$this->RekapPenjualanReturPenjualanPerCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 43)
			{
				$this->RekapPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 44)
			{
				$this->RekapReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 45)
			{
				$this->RekapPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 46)
			{
				$this->RekapTotalPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 47)
			{
				$this->RekapTotalReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 48)
			{
				$this->RekapTotalPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($_GET['company'],$_GET['sloc'],$_GET['customer'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
        
        public function RincianPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rincianpenjualanperdokumen';
		parent::actionDownxls();	
		$total1=0;$totaldisc1=0;$totalnetto1=0;					
		$sql = "select a.invoiceid,a.invoiceno, b.gino, a.invoicedate, d.fullname as customer,h.fullname as sales, e.paydays, c.shipto, a.headernote
								from invoice a
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join paymentmethod e on e.paymentmethodid = c.paymentmethodid
								join gidetail f on f.giheaderid = b.giheaderid
								join sloc g on g.slocid = f.slocid
								join employee h on h.employeeid = c.employeeid
								join product i on i.productid = f.productid
								join salesarea j on j.salesareaid = d.salesareaid
								where a.recordstatus = 3 and c.companyid = ".$companyid." and g.sloccode like '%".$sloc."%'
								and d.fullname like '%".$customer."%' and h.fullname like '%".$employee."%' and i.productname like '%".$product."%'
								and j.areaname like '%".$salesarea."%' and b.gino is not null
								and a.invoicedate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
								'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by invoiceno order by invoicedate";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
			$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No. Bukti')
					->setCellValueByColumnAndRow(1,$line,': '.$row['invoiceno'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['invoicedate']);
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['sales'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'Kepada Yth,');
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No. SJ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['gino'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['customer']);
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'T.O.P')
					->setCellValueByColumnAndRow(1,$line,': '.$row['paydays'].' HARI')
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['shipto']);				
				
				$line++;						
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Barang')
					->setCellValueByColumnAndRow(2,$line,'Qty')
					->setCellValueByColumnAndRow(3,$line,'Unit')
					->setCellValueByColumnAndRow(4,$line,'Price')
					->setCellValueByColumnAndRow(5,$line,'Total');
				$line++;
				$sql1 = "select distinct ss.gidetailid,a.invoiceno,i.productname,k.uomcode,ss.qty,
										(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
										(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nominal,
										(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
										from gidetail zzb 
										join sodetail zza on zza.sodetailid = zzb.sodetailid
										where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
										from invoice a 
										join giheader b on b.giheaderid = a.giheaderid
										join soheader c on c.soheaderid = b.soheaderid
										join addressbook d on d.addressbookid = c.addressbookid
										join employee e on e.employeeid = c.employeeid
										join salesarea f on f.salesareaid = d.salesareaid
										join sodetail g on g.soheaderid = b.soheaderid
										join gidetail ss on ss.giheaderid = b.giheaderid
										join sloc h on h.slocid = ss.slocid
										join product i on i.productid = ss.productid
										join productplant j on j.productid = i.productid
										join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
										where a.recordstatus = 3 and c.companyid = ".$companyid." 
										and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' 
										and e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' 
										and i.productname like '%".$product."%' and a.invoiceid = ".$row['invoiceid']." 
										and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
										and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty=0;$i=0;$total=0;$diskon=0;$netto=0;
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,$row1['qty'])
							->setCellValueByColumnAndRow(3,$line,$row1['uomcode'])
							->setCellValueByColumnAndRow(4,$line,$row1['price']/$per)
							->setCellValueByColumnAndRow(5,$line,$row1['nominal']/$per);
							$line++;						
							$totalqty += $row1['qty'];
							$total += $row1['nominal']/$per;							
							$netto += $row1['nett']/$per;
							$diskon += ($row1['nominal']/$per) - ($row1['nett']/$per);
							$bilangan = explode(".",$netto);
				}
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,'')
							->setCellValueByColumnAndRow(1,$line,'Total')
							->setCellValueByColumnAndRow(2,$line,$totalqty)
							->setCellValueByColumnAndRow(3,$line,'')
							->setCellValueByColumnAndRow(4,$line,'Nominal')
							->setCellValueByColumnAndRow(5,$line,$total);
							$line+= 1;
							
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,'')
							->setCellValueByColumnAndRow(1,$line,'')
							->setCellValueByColumnAndRow(2,$line,'')
							->setCellValueByColumnAndRow(3,$line,'')
							->setCellValueByColumnAndRow(4,$line,'Diskon')
							->setCellValueByColumnAndRow(5,$line,$diskon);
				
				$line++;	
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'')
					->setCellValueByColumnAndRow(1,$line,'Terbilang : '.$this->eja($bilangan[0]))
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'Netto')
					->setCellValueByColumnAndRow(5,$line,$netto);		
					
					
				$line++;	
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'')
					->setCellValueByColumnAndRow(1,$line,'Note : '.$row['headernote']);
					
					$line+= 2;
					$total1 += $total;
					$totaldisc1 += $diskon;
					$totalnetto1 += $netto;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'')	
				->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,'TOTAL DISCOUNT')				
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,'TOTAL NETTO');
				
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'')
				->setCellValueByColumnAndRow(1,$line,$total1)
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,$totaldisc1)
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,$totalnetto1);
				
				
	$this->getFooterXLS($this->phpExcel);	
	
	
	}
        
        public function RekapPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperdokumen';
		parent::actionDownXLS();
		$sql = "select invoiceno,invoicedate,fullname,headernote,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
							(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						  from gidetail zzb 
						  join sodetail zza on zza.sodetailid = zzb.sodetailid
						  where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
              c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
              e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
              a.invoiceno is not null and a.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by invoiceno
              )z group by invoiceno"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			$i=0;$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'No. Bukti')
					->setCellValueByColumnAndRow(2,$line,'Tanggal')
					->setCellValueByColumnAndRow(3,$line,'Customer')
					->setCellValueByColumnAndRow(4,$line,'Nominal')
					->setCellValueByColumnAndRow(5,$line,'Disc')
					->setCellValueByColumnAndRow(6,$line,'Netto')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');					
					$line++;
			foreach($dataReader as $row)
			{												
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row['invoiceno'])
							->setCellValueByColumnAndRow(2,$line,$row['invoicedate'])
							->setCellValueByColumnAndRow(3,$line,$row['fullname'])
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row['nominal']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row['disc']/$per))
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row['netto']/$per))
							->setCellValueByColumnAndRow(7,$line,$row['headernote']);
							$line++;
					
					$line+= 0;
					$totalnominal1 += $row['nominal']/$per;
          $totaldisc1 += $row['disc']/$per;
          $totaljumlah1 += $row['netto']/$per;				
							
			}
				$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'')	
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,'TOTAL')				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totaljumlah1));
		
		$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerCustomerXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpercustomer';
		parent::actionDownXLS();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
		$sql = "select a.addressbookid, a.fullname
				from addressbook a 
				where a.fullname like '%".$customer."%' and 
				a.addressbookid in 
				(select b.addressbookid from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	         join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
            join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$employee."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
				k.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."')";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
			$sql1 = "select invoiceno,invoicedate,fullname,headernote,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
				(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
				(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
				(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
				(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
				 from gidetail zzb 
				 join sodetail zza on zza.sodetailid = zzb.sodetailid
				 where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
				from invoice a 
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				join addressbook d on d.addressbookid = c.addressbookid
				join employee e on e.employeeid = c.employeeid
				join salesarea f on f.salesareaid = d.salesareaid
				join sodetail g on g.soheaderid = b.soheaderid
				join gidetail ss on ss.giheaderid = b.giheaderid
				join sloc h on h.slocid = ss.slocid
				join product i on i.productid = ss.productid
				join productplant j on j.productid = i.productid
				join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
				where a.recordstatus = 3 and a.invoiceno is not null and
					c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
					e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
					a.invoiceno is not null and a.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
					and d.addressbookid = ".$row['addressbookid']." order by invoiceno
			)z group by invoiceno"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'No Dokumen')
				->setCellValueByColumnAndRow(2,$line,'Tanggal')
				->setCellValueByColumnAndRow(3,$line,'Nominal')
				->setCellValueByColumnAndRow(4,$line,'Disc')
				->setCellValueByColumnAndRow(5,$line,'Netto')
				->setCellValueByColumnAndRow(6,$line,'Keterangan')
				;
			foreach($dataReader1 as $row1)
			{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
				->setCellValueByColumnAndRow(2,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['nominal']))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row1['disc']))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($row1['netto']))
				->setCellValueByColumnAndRow(6,$line,$row1['headernote']);
				$totalnominal += $row1['nominal'];
				$totaldisc += $row1['disc'];
				$total += $row1['netto'];
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Customer '. $row['fullname'])
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total));
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totaljumlah1 += $total;
			$line += 2;
		}
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total ')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaljumlah1));
		$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerSalesXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpersales';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$total1=0;				
		$sql = "select a.employeeid,a.fullname
							from employee a 
							where a.fullname like '%".$employee."%' and 
							a.employeeid in 
							(select employeeid from soheader b
							join sodetail c on c.soheaderid = b.soheaderid
							join gidetail d on d.sodetailid = c.sodetailid
							join product e on e.productid = d.productid
							join addressbook f on f.addressbookid = b.addressbookid
							join salesarea g on g.salesareaid = f.salesareaid
							join giheader h on h.giheaderid = d.giheaderid
							join sloc i on i.slocid = d.slocid
							join invoice j on j.giheaderid = h.giheaderid
							where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$customer."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
							g.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."')";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
			$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'');
					
				$line++;						
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Customer')
					->setCellValueByColumnAndRow(2,$line,'Nominal')
					->setCellValueByColumnAndRow(3,$line,'Disc')
					->setCellValueByColumnAndRow(4,$line,'Netto');
				$line++;				
				$sql1 = "select invoiceno,invoicedate,fullname,headernote,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
										(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
										(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
										(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
										(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
										from gidetail zzb 
										join sodetail zza on zza.sodetailid = zzb.sodetailid
										where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
										from invoice a 
										join giheader b on b.giheaderid = a.giheaderid
										join soheader c on c.soheaderid = b.soheaderid
										join addressbook d on d.addressbookid = c.addressbookid
										join employee e on e.employeeid = c.employeeid
										join salesarea f on f.salesareaid = d.salesareaid
										join sodetail g on g.soheaderid = b.soheaderid
										join gidetail ss on ss.giheaderid = b.giheaderid
										join sloc h on h.slocid = ss.slocid
										join product i on i.productid = ss.productid
										join productplant j on j.productid = i.productid
										join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
										where a.recordstatus = 3 and a.invoiceno is not null and
										c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
										e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
										a.invoiceno is not null and a.invoicedate between 
										'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
										'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
										and e.employeeid = ".$row['employeeid']." order by fullname
										)z group by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
				
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['fullname'])
							->setCellValueByColumnAndRow(2,$line,$row1['nominal']/$per)
							->setCellValueByColumnAndRow(3,$line,$row1['disc']/$per)
							->setCellValueByColumnAndRow(4,$line,$row1['netto']/$per);
							$line++;						
							$totalnominal += $row1['nominal']/$per;
							$totaldisc += $row1['disc']/$per;							
							$total += $row1['netto']/$per;							
				}
				$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'Total Sales')
							->setCellValueByColumnAndRow(2,$line,$totalnominal)
							->setCellValueByColumnAndRow(3,$line,$totaldisc)
							->setCellValueByColumnAndRow(4,$line,$total);
							$line+= 2;
							$totalnominal1 += $totalnominal;
							$totaldisc1 += $totaldisc;
							$total1 += $total;
			}
			$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'TOTAL')
							->setCellValueByColumnAndRow(2,$line,$totalnominal1)
							->setCellValueByColumnAndRow(3,$line,$totaldisc1)
							->setCellValueByColumnAndRow(4,$line,$total1);
		$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerBarangXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperbarang';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;						
		$sql = "select distinct a.materialgroupid,a.materialgroupcode,a.description
							from materialgroup a
							join productplant b on b.materialgroupid = a.materialgroupid
							join product c on c.productid = b.productid
							join sloc d on d.slocid = b.slocid
							join plant e on e.plantid = d.plantid
							join company f on f.companyid = e.companyid
							where f.companyid = ".$companyid." and b.productid in
							(
							select zc.productid
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							where zi.recordstatus = 3 and zc.slocid = b.slocid and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Divisi')
					->setCellValueByColumnAndRow(1,$line,': '.$row['description'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'');
					
				$line++;						
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Barang')
					->setCellValueByColumnAndRow(2,$line,'Qty')
					->setCellValueByColumnAndRow(3,$line,'Price')
					->setCellValueByColumnAndRow(4,$line,'Total')
					->setCellValueByColumnAndRow(5,$line,'Disc')
					->setCellValueByColumnAndRow(6,$line,'Netto');
				$line++;
				$sql1 = "select productid,productname,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
									(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
									(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
									(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
									(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
									from gidetail zzb 
									join sodetail zza on zza.sodetailid = zzb.sodetailid
									where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
									from invoice a 
									join giheader b on b.giheaderid = a.giheaderid
									join soheader c on c.soheaderid = b.soheaderid
									join addressbook d on d.addressbookid = c.addressbookid
									join employee e on e.employeeid = c.employeeid
									join salesarea f on f.salesareaid = d.salesareaid
									join sodetail g on g.soheaderid = b.soheaderid
									join gidetail ss on ss.giheaderid = b.giheaderid
									join sloc h on h.slocid = ss.slocid
									join product i on i.productid = ss.productid
									join productplant j on j.productid = i.productid and j.slocid=g.slocid
									join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
									where a.recordstatus = 3 and a.invoiceno is not null and
									c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
									e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
									and a.invoiceno is not null and j.materialgroupid = ".$row['materialgroupid']."
									and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
									and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
									)zz group by productid order by productname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty=0;$totalnetto=0;$totaldisc=0;$totalnominal=0;$i=0;
				
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,$row1['giqty'])
							->setCellValueByColumnAndRow(3,$line,$row1['harga']/$per)
							->setCellValueByColumnAndRow(4,$line,$row1['nominal']/$per)
							->setCellValueByColumnAndRow(5,$line,($row1['nominal']/$per) - ($row1['netto']/$per))
							->setCellValueByColumnAndRow(6,$line,$row1['netto']/$per);
							$line++;						
							$totalqty += $row1['giqty'];
							$totalnominal += $row1['nominal']/$per;
							$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
							$totalnetto += $row1['netto']/$per;
				}
				$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'Total '.$row['description'])
							->setCellValueByColumnAndRow(2,$line,$totalqty)
							->setCellValueByColumnAndRow(4,$line,$totalnominal)
							->setCellValueByColumnAndRow(5,$line,$totaldisc)
							->setCellValueByColumnAndRow(6,$line,$totalnetto);
							$line+= 2;
							$totalnominal1 += $totalnominal;
							$totaldisc1 += $totaldisc;
							$totalnetto1 += $totalnetto;
			}
			$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'TOTAL')
							->setCellValueByColumnAndRow(4,$line,$totalnominal1)
							->setCellValueByColumnAndRow(5,$line,$totaldisc1)
							->setCellValueByColumnAndRow(6,$line,$totalnetto1);
							$line+= 2;
		
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapPenjualanPerAreaXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperarea';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totaljumlah2=0;					
		$sql = "select distinct zg.salesareaid,zg.areaname
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join employee zd on zd.employeeid = za.employeeid
							join invoice ze on ze.giheaderid = zc.giheaderid
							join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join product zh on zh.productid = zc.productid
							join sloc zi on zi.slocid = zc.slocid
							where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
							and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
							and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
							and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
              group by zg.areaname";
				
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
			$line=4;				
		foreach($dataReader as $row)
		{		
				$sql1 = "select distinct a.materialgroupid,a.description,b.productid
										from materialgroup a
										join productplant b on b.materialgroupid = a.materialgroupid
										join product c on c.productid = b.productid
										join sloc d on d.slocid = b.slocid
										join gidetail e on e.productid = c.productid
										join giheader f on f.giheaderid = e.giheaderid
										join soheader g on g.soheaderid = f.soheaderid
										join addressbook h on h.addressbookid = g.addressbookid
										join salesarea i on i.salesareaid = h.salesareaid
										join invoice j on j.giheaderid = f.giheaderid
										join employee k on k.employeeid = g.employeeid
										where j.recordstatus = 3 and g.companyid = ".$companyid." and i.salesareaid = ".$row['salesareaid']." and k.fullname like '%".$employee."%' 
										and c.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and h.fullname like '%".$customer."%' 
										and j.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
										and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by a.description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$totalqty1 = 0;
				$totalnominal1 = 0;
				$totaldisc1 = 0;
				$totaljumlah1 = 0;
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Area')
						->setCellValueByColumnAndRow(1,$line,': '.$row['areaname'])
						->setCellValueByColumnAndRow(2,$line,'')
						->setCellValueByColumnAndRow(3,$line,'')
						->setCellValueByColumnAndRow(4,$line,'');
						
					$line++;		
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Grup Material')
						->setCellValueByColumnAndRow(1,$line,': '.$row1['description'])
						->setCellValueByColumnAndRow(2,$line,'')
						->setCellValueByColumnAndRow(3,$line,'')
						->setCellValueByColumnAndRow(4,$line,'');			
			
					$line++;						
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')					
						->setCellValueByColumnAndRow(3,$line,'Nominal')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
					$line++;
					$sql2 = "select productid,productname,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
										(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
										(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
										(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
										(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
										from gidetail zzb 
										join sodetail zza on zza.sodetailid = zzb.sodetailid
										where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
										from invoice a 
										join giheader b on b.giheaderid = a.giheaderid
										join soheader c on c.soheaderid = b.soheaderid
										join addressbook d on d.addressbookid = c.addressbookid
										join employee e on e.employeeid = c.employeeid
										join salesarea f on f.salesareaid = d.salesareaid
										join sodetail g on g.soheaderid = b.soheaderid
										join gidetail ss on ss.giheaderid = b.giheaderid
										join sloc h on h.slocid = ss.slocid
										join product i on i.productid = ss.productid
										join productplant j on j.productid = i.productid and j.slocid=g.slocid
										join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
										where a.recordstatus = 3 and a.invoiceno is not null and
										c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
										e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
										a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
        					  '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
										and j.materialgroupid = ".$row1['materialgroupid']." and f.salesareaid = ".$row['salesareaid']."
										) zz group by productid";
					
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$totalgrupdisc = 0;$totalgrupnominal=0;$totalgrup=0;$i=0;$totalgrupqty=0;
					foreach($dataReader2 as $row2)
					{
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row2['productname'])
							->setCellValueByColumnAndRow(2,$line,$row2['giqty'])							
							->setCellValueByColumnAndRow(3,$line,$row2['nominal']/$per)
							->setCellValueByColumnAndRow(4,$line,($row2['nominal']/$per) - ($row2['netto']/$per))
							->setCellValueByColumnAndRow(5,$line,$row2['netto']/$per);
							$line++;
							$totalgrupqty += $row2['giqty'];
							$totalgrupnominal += $row2['nominal']/$per;
							$totalgrupdisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
							$totalgrup += $row2['netto']/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'Total '.$row1['description'])
							->setCellValueByColumnAndRow(2,$line,$totalgrupqty)
							->setCellValueByColumnAndRow(3,$line,$totalgrupnominal)
							->setCellValueByColumnAndRow(4,$line,$totalgrupdisc)
							->setCellValueByColumnAndRow(5,$line,$totalgrup);
							$line+= 1;
							$totalqty1 += $totalgrupqty;
							$totalnominal1 = $totalgrupnominal;
							$totaldisc1 = $totalgrupdisc;
							$totaljumlah1 = $totalgrup;
							
				}
				$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'Total '.$row['areaname'])
							->setCellValueByColumnAndRow(2,$line,$totalqty1)
							->setCellValueByColumnAndRow(3,$line,$totalnominal1)
							->setCellValueByColumnAndRow(4,$line,$totaldisc1)
							->setCellValueByColumnAndRow(5,$line,$totaljumlah1);
							$line+= 2;		
							$totalqty2 += $totalqty1;
							$totalnominal2 += $totalnominal1;
							$totaldisc2 += $totaldisc1;
							$totaljumlah2 += $totaljumlah1;
		}
		$this->phpExcel->setActiveSheetIndex(0)							
							->setCellValueByColumnAndRow(1,$line,'TOTAL')
							->setCellValueByColumnAndRow(3,$line,$totalnominal2)
							->setCellValueByColumnAndRow(4,$line,$totaldisc2)
							->setCellValueByColumnAndRow(5,$line,$totaljumlah2);
							$line+= 2;
							
	$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerCustomerPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpercustomerperbarangtotal';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
		$sql = "select a.addressbookid, a.fullname
				from addressbook a 
				where a.fullname like '%".$customer."%' and 
				a.addressbookid in 
				(select b.addressbookid from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	         join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
            join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$employee."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
				k.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
			$sql1 = "select productid,productname,description as barang,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,l.description,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.addressbookid = ".$row['addressbookid']." and
						  e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						)zz group by barang"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Material Group')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Total')
				->setCellValueByColumnAndRow(4,$line,'Disc')
				->setCellValueByColumnAndRow(5,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['barang'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row1['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['nominal']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($row1['netto']/$per));
				$totalnominal += $row1['nominal']/$per;
				$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$total += $row1['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Customer '. $row['fullname'])
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total));
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totaljumlah1 += $total;
			$line += 2;
		}
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total ')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaljumlah1));
		$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerCustomerPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpercustomerperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select a.addressbookid, a.fullname
				from addressbook a 
				where a.fullname like '%".$customer."%' and 
				a.addressbookid in 
				(select b.addressbookid from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
			  join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$employee."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
				k.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
			$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
			$sql1 = "select distinct a.materialgroupid,a.materialgroupcode,a.description
						from materialgroup a
						join productplant b on b.materialgroupid = a.materialgroupid
						join product c on c.productid = b.productid
						join sloc d on d.slocid = b.slocid
						join plant e on e.plantid = d.plantid
						join company f on f.companyid = e.companyid
						where f.companyid = ".$companyid." and b.productid in
						(
						select zc.productid
						from soheader za 
						join giheader zb on zb.soheaderid = za.soheaderid
						join gidetail zc on zc.giheaderid = zb.giheaderid
						join sodetail zs on zs.sodetailid = zc.sodetailid
						left join employee zd on zd.employeeid = za.employeeid
						join product ze on ze.productid = zs.productid
						left join addressbook zf on zf.addressbookid = za.addressbookid
						left join salesarea zg on zg.salesareaid = zf.salesareaid
						join sloc zh on zh.slocid = zc.slocid
						join invoice zi on zi.giheaderid = zc.giheaderid
						where zi.recordstatus = 3 and zc.slocid = b.slocid and zi.invoiceno is not null and za.companyid = ".$companyid." and
						zf.addressbookid = ".$row['addressbookid']." and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
						zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and
						zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by description asc"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
						$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Price')
				->setCellValueByColumnAndRow(4,$line,'Total')
				->setCellValueByColumnAndRow(5,$line,'Disc')
				->setCellValueByColumnAndRow(6,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Material Group')
				->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
				$totalqty = 0;$totaldisc = 0;$totalnominal=0;$totalnetto=0;$i=0;
				$sql2 = "select productid,productname,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.addressbookid = ".$row['addressbookid']." and
							e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
							and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']."
							and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)zz group by productid order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				foreach($dataReader2 as $row2)
				{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row2['productname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row2['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row2['harga']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row2['nominal']/$per))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($row2['netto']/$per));
				$totalqty += $row2['giqty'];
				$totalnominal += $row2['nominal']/$per;
				$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
				$totalnetto += $row2['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Material Group '. $row1['description'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto));
			$totalqty1 += $totalqty;
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totalnetto1 += $totalnetto;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Customer '. $row['fullname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto1));
			$totalqty2 += $totalqty1;
			$totalnominal2 += $totalnominal1;
			$totaldisc2 += $totaldisc1;
			$totalnetto2 += $totalnetto1;
			$line+= 2;
		}
		$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Grand Total')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty2))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal2))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc2))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto2));
		$line += 1;
		$this->getFooterXLS($this->phpExcel);
	}
        
        public function RekapPenjualanPerSalesPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpersalesperbarangtotal';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
		$sql = "select a.employeeid,a.fullname
				from employee a 
				where a.fullname like '%".$employee."%' and 
				a.employeeid in 
				(select employeeid from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join addressbook f on f.addressbookid = b.addressbookid
				join salesarea g on g.salesareaid = f.salesareaid
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$customer."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
				g.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Sales')
				->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
			$sql1 = "select productid,productname,description as barang,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,l.description,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and 
						  e.employeeid = ".$row['employeeid']." and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						)zz group by barang"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Material Group')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Total')
				->setCellValueByColumnAndRow(4,$line,'Disc')
				->setCellValueByColumnAndRow(5,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['barang'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row1['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['nominal']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($row1['netto']/$per));
				$totalnominal += $row1['nominal']/$per;
				$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$total += $row1['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Sales '. $row['fullname'])
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total));
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totaljumlah1 += $total;
			$line += 2;
		}
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total ')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaljumlah1));
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapPenjualanPerSalesPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpersalesperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select a.employeeid,a.fullname
				from employee a 
				where a.fullname like '%".$employee."%' and 
				a.employeeid in 
				(select employeeid from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join addressbook f on f.addressbookid = b.addressbookid
				join salesarea g on g.salesareaid = f.salesareaid
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and f.fullname like '%".$customer."%' and i.sloccode like '%".$sloc."%' and e.productname like '%".$product."%' and
				g.areaname like '%".$salesarea."%' and j.invoiceno is not null and j.invoicedate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
				'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by fullname asc";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Sales')
				->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
			$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
			$sql1 = "select distinct a.materialgroupid,a.materialgroupcode,a.description
						from materialgroup a
						join productplant b on b.materialgroupid = a.materialgroupid
						join product c on c.productid = b.productid
						join sloc d on d.slocid = b.slocid
						join plant e on e.plantid = d.plantid
						join company f on f.companyid = e.companyid
						where f.companyid = ".$companyid." and b.productid in
						(
						select zc.productid
						from soheader za 
						join giheader zb on zb.soheaderid = za.soheaderid
						join gidetail zc on zc.giheaderid = zb.giheaderid
						join sodetail zs on zs.sodetailid = zc.sodetailid
						left join employee zd on zd.employeeid = za.employeeid
						join product ze on ze.productid = zs.productid
						left join addressbook zf on zf.addressbookid = za.addressbookid
						left join salesarea zg on zg.salesareaid = zf.salesareaid
						join sloc zh on zh.slocid = zc.slocid
						join invoice zi on zi.giheaderid = zc.giheaderid
						where zi.recordstatus = 3 and zc.slocid = b.slocid and zi.invoiceno is not null and za.companyid = ".$companyid." and
						zf.fullname like '%".$customer."%'  and zd.employeeid = ".$row['employeeid']." and ze.productname like '%".$product."%' and
						zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and
						zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by description asc"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
						$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Price')
				->setCellValueByColumnAndRow(4,$line,'Total')
				->setCellValueByColumnAndRow(5,$line,'Disc')
				->setCellValueByColumnAndRow(6,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Material Group')
				->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
				$totalqty = 0;$totaldisc = 0;$totalnominal=0;$totalnetto=0;$i=0;
				$sql2 = "select productid,productname,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
							e.employeeid = ".$row['employeeid']." and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
							and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']."
							and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)zz group by productid order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				foreach($dataReader2 as $row2)
				{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row2['productname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row2['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row2['harga']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row2['nominal']/$per))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($row2['netto']/$per));
				$totalqty += $row2['giqty'];
				$totalnominal += $row2['nominal']/$per;
				$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
				$totalnetto += $row2['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Material Group '. $row1['description'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto));
			$totalqty1 += $totalqty;
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totalnetto1 += $totalnetto;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Sales '. $row['fullname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto1));
			$totalqty2 += $totalqty1;
			$totalnominal2 += $totalnominal1;
			$totaldisc2 += $totaldisc1;
			$totalnetto2 += $totalnetto1;
			$line+= 2;
		}
		$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Grand Total')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty2))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal2))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc2))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto2));
		$line += 1;
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapPenjualanPerAreaPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperareaperbarangtotal';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
		$sql = "select distinct zg.salesareaid,zg.areaname
				   from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				   join addressbook zf on zf.addressbookid = za.addressbookid
				   left join salesarea zg on zg.salesareaid = zf.salesareaid
				   join product zh on zh.productid = zc.productid
				   join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by zg.areaname order by zg.areaname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Area')
				->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
			$sql1 = "select productid,productname,description as barang,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,l.description,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and 
						  e.fullname like '%".$employee."%' and f.salesareaid = ".$row['salesareaid']." and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						)zz group by barang"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Material Group')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Total')
				->setCellValueByColumnAndRow(4,$line,'Disc')
				->setCellValueByColumnAndRow(5,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['barang'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row1['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['nominal']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency(($row1['nominal']/$per) - ($row1['netto']/$per)))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($row1['netto']/$per));
				$totalnominal += $row1['nominal']/$per;
				$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$total += $row1['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Area '. $row['areaname'])
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total));
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totaljumlah1 += $total;
			$line += 2;
		}
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total ')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaljumlah1));
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapPenjualanPerAreaPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperareaperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct zg.salesareaid,zg.areaname
				   from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				   join addressbook zf on zf.addressbookid = za.addressbookid
				   left join salesarea zg on zg.salesareaid = zf.salesareaid
				   join product zh on zh.productid = zc.productid
				   join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by zg.areaname order by zg.areaname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Area')
				->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
			$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
			$sql1 = "select distinct a.materialgroupid,a.materialgroupcode,a.description
						from materialgroup a
						join productplant b on b.materialgroupid = a.materialgroupid
						join product c on c.productid = b.productid
						join sloc d on d.slocid = b.slocid
						join plant e on e.plantid = d.plantid
						join company f on f.companyid = e.companyid
						where f.companyid = ".$companyid." and b.productid in
						(
						select zc.productid
						from soheader za 
						join giheader zb on zb.soheaderid = za.soheaderid
						join gidetail zc on zc.giheaderid = zb.giheaderid
						join sodetail zs on zs.sodetailid = zc.sodetailid
						left join employee zd on zd.employeeid = za.employeeid
						join product ze on ze.productid = zs.productid
						left join addressbook zf on zf.addressbookid = za.addressbookid
						left join salesarea zg on zg.salesareaid = zf.salesareaid
						join sloc zh on zh.slocid = zc.slocid
						join invoice zi on zi.giheaderid = zc.giheaderid
						where zi.recordstatus = 3 and zc.slocid = b.slocid and zi.invoiceno is not null and za.companyid = ".$companyid." and
						zf.fullname like '%".$customer."%'  and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
						zg.salesareaid = ".$row['salesareaid']." and zh.sloccode like '%".$sloc."%' and
						zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') order by description asc"; 
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
						$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Price')
				->setCellValueByColumnAndRow(4,$line,'Total')
				->setCellValueByColumnAndRow(5,$line,'Disc')
				->setCellValueByColumnAndRow(6,$line,'Netto')
				;
			foreach($dataReader1 as $row1)
			{
				$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Material Group')
				->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
				$totalqty = 0;$totaldisc = 0;$totalnominal=0;$totalnetto=0;$i=0;
				$sql2 = "select productid,productname,sum(qty) as giqty,harga,sum(nom) as nominal,sum(nett) as netto from
						(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as harga,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
							e.fullname like '%".$employee."%' and f.salesareaid = ".$row['salesareaid']." and i.productname like '%".$product."%' 
							and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']."
							and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)zz group by productid order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				foreach($dataReader2 as $row2)
				{
				$i+=1;$line++;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row2['productname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row2['giqty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row2['harga']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row2['nominal']/$per))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency(($row2['nominal']/$per) - ($row2['netto']/$per)))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($row2['netto']/$per));
				$totalqty += $row2['giqty'];
				$totalnominal += $row2['nominal']/$per;
				$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
				$totalnetto += $row2['netto']/$per;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Material Group '. $row1['description'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto));
			$totalqty1 += $totalqty;
			$totalnominal1 += $totalnominal;
			$totaldisc1 += $totaldisc;
			$totalnetto1 += $totalnetto;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total Area '. $row['areaname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty1))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc1))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto1));
			$totalqty2 += $totalqty1;
			$totalnominal2 += $totalnominal1;
			$totaldisc2 += $totaldisc1;
			$totalnetto2 += $totalnetto1;
			$line+= 2;
		}
		$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Grand Total')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totalqty2))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($totalnominal2))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($totaldisc2))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($totalnetto2));
		$line += 1;
		$this->getFooterXLS($this->phpExcel);
	}
        public function RincianReturPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rincianreturpenjualanperdokumen';
		parent::actionDownxls();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;		
		$sql = "select distinct b.notagirid,b.notagirno,i.fullname as customer,d.gireturdate,j.paycode,h.taxid,b.headernote
						from notagirpro a
						left join notagir b on b.notagirid=a.notagirid
						left join gireturdetail c on c.gireturdetailid=a.gireturdetailid
						left join giretur d on d.gireturid=b.gireturid
						left join product e on e.productid=a.productid
						left join gidetail f on f.gidetailid=c.gidetailid
						left join giheader g on g.giheaderid=d.giheaderid
						left join soheader h on h.soheaderid=g.soheaderid
						left join addressbook i on i.addressbookid=h.addressbookid
						left join paymentmethod j on j.paymentmethodid=h.paymentmethodid
						left join sloc k on k.slocid=a.slocid
						left join employee l on l.employeeid = h.employeeid
						where k.sloccode like '%".$sloc."%' and b.recordstatus = 3 and i.fullname like '%".$customer."%' and 
						h.companyid = ".$companyid." and e.productname like '%".$product."%' and l.fullname like '%".$employee."%' and
						d.gireturdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Dokumen')
				->setCellValueByColumnAndRow(1,$line,': '.$row['notagirno'])
				->setCellValueByColumnAndRow(4,$line,'Tanggal')
				->setCellValueByColumnAndRow(5,$line,': '.$row['gireturdate']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['customer'])
				->setCellValueByColumnAndRow(4,$line,'T.O.P')
				->setCellValueByColumnAndRow(5,$line,': '.$row['paycode'].' HARI');
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Harga')
				->setCellValueByColumnAndRow(4,$line,'Jumlah')
				->setCellValueByColumnAndRow(5,$line,'Keterangan');
			$line++;
			$sql1 = "select *,(nominal-netto) as disc from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and b.notagirid = ".$row['notagirid']." 
							and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)z order by notagirno,notagirproid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['productname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row1['qty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['price']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row1['nominal']/$per))
				->setCellValueByColumnAndRow(5,$line,$row['headernote']);
				$line++;
				$totalqty += $row1['qty'];
				$totalnominal += $row1['nominal']/$per;
				$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$totalnetto += $row1['netto']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Keterangan : '.$row1['headernote'])
				->setCellValueByColumnAndRow(4,$line,'Nominal')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnominal));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(4,$line,'Diskon')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(4,$line,'Netto')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
			$line++;
			$totalnominal1 += $totalnominal;
			$totaldiskon1 += $totaldiskon;
			$totalnetto1 += $totalnetto;
			$line+=1;
		}
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
				->setCellValueByColumnAndRow(1,$line,Yii::app()->format->formatCurrency ($totalnominal1))
				->setCellValueByColumnAndRow(2,$line,'TOTAL DISCOUNT')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totaldiskon1))
				->setCellValueByColumnAndRow(4,$line,'TOTAL NETTO')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
			$line++;
			
			
			
		
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperdokumen';
		parent::actionDownxls();
		$nominal=0;$diskon=0;$netto=0;		
		$sql = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		$i=0;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Dokumen')
				->setCellValueByColumnAndRow(2,$line,'Tanggal')
				->setCellValueByColumnAndRow(3,$line,'Customer')
				->setCellValueByColumnAndRow(4,$line,'Nominal')
				->setCellValueByColumnAndRow(5,$line,'Diskon')
				->setCellValueByColumnAndRow(6,$line,'Netto');
		$line++;
		foreach($dataReader as $row)
		{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['notagirno'])
					->setCellValueByColumnAndRow(2,$line,$row['gireturdate'])
					->setCellValueByColumnAndRow(3,$line,$row['fullname'])
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row['nominal']/$per))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row['nominal']/$per) - ($row['netto']/$per)))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row['netto']/$per));
				$line++;
				$nominal += $row['nominal']/$per;
				$diskon += ($row['nominal']/$per) - ($row['netto']/$per);
				$netto += $row['netto']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL')
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($nominal))				
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($diskon))				
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($netto));
			$line++;
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerCustomerXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpercustomer';
		parent::actionDownxls();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;							
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
				
           $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
						foreach($dataReader as $row)	
						{
							$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'Customer')
								->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
							$line++;
							
							$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'No')
								->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
								->setCellValueByColumnAndRow(2,$line,'Tanggal')
								->setCellValueByColumnAndRow(3,$line,'Nominal')
								->setCellValueByColumnAndRow(4,$line,'Diskon')
								->setCellValueByColumnAndRow(5,$line,'Netto')
								->setCellValueByColumnAndRow(6,$line,'Keterangan');
							$line++;
							$sql1 = "select *, sum(nom) as nominal, sum(nett) as netto from
												(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
												g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
												from notagirpro a
												join notagir b on b.notagirid=a.notagirid
												join gireturdetail c on c.gireturdetailid=a.gireturdetailid
												join giretur d on d.gireturid=b.gireturid
												join gidetail e on e.gidetailid=c.gidetailid
												join giheader f on f.giheaderid=d.giheaderid
												join sodetail g on g.sodetailid=e.sodetailid
												join soheader h on h.soheaderid=f.soheaderid
												join product i on i.productid = a.productid
												join sloc j on j.slocid = a.slocid
												join addressbook k on k.addressbookid = h.addressbookid
												join employee l on l.employeeid = h.employeeid
												join salesarea m on m.salesareaid = k.salesareaid
												where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
												and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
												and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
												'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
												and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
												)z group by notagirno";
				
										$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
										$totaldiskon= 0;$totalnominal=0;$totalnetto=0;$i=0;
				
							foreach($dataReader1 as $row1)
							{
								$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['notagirno'])
									->setCellValueByColumnAndRow(2,$line,$row1['gireturdate'])									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per))
									->setCellValueByColumnAndRow(6,$line,$row1['headernote']);
								$line++;
								$totalnominal += $row1['nominal']/$per;
								$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;
								
							}
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'Total')
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalnominal1 += $totalnominal;
								$totaldiskon1 += $totaldiskon;
								$totalnetto1 += $totalnetto;
								
								$line+=1;
						}
						$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'TOTAL')
									->setCellValueByColumnAndRow(1,$line,'NOMINAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalnominal1))
									->setCellValueByColumnAndRow(3,$line,'DISKON')
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon1))
									->setCellValueByColumnAndRow(5,$line,'NETTO')
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerSalesXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpersales';
		parent::actionDownxls();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;							
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'Sales')
								->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
							$line++;
							
				$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'No')
								->setCellValueByColumnAndRow(1,$line,'Nama Customer')
								->setCellValueByColumnAndRow(2,$line,'Nominal')
								->setCellValueByColumnAndRow(3,$line,'Diskon')
								->setCellValueByColumnAndRow(4,$line,'Netto');
							$line++;
							$sql1 = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaldiskon = 0;$totalnominal=0;$totalnetto=0;$i=0;
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['fullname'])																	
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalnominal += $row1['nominal']/$per;
								$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;
				}	
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'Total Sales')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalnominal1 += $totalnominal;
								$totaldiskon1 += $totaldiskon;
								$totalnetto1 += $totalnetto;
								$line+=1;
								
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalnominal1))									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totaldiskon1))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
			
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerBarangXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperbarang';
		parent::actionDownxls();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;							
		$sql = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
			
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
						foreach($dataReader as $row)
						{
							$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'Divisi')
								->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
							$line++;
							
							$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,'No')
								->setCellValueByColumnAndRow(1,$line,'Nama Barang')
								->setCellValueByColumnAndRow(2,$line,'Qty')
								->setCellValueByColumnAndRow(3,$line,'Price')
								->setCellValueByColumnAndRow(4,$line,'Total')
								->setCellValueByColumnAndRow(5,$line,'Disc')
								->setCellValueByColumnAndRow(6,$line,'Netto');
							$line++;
							$sql1 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and n.materialgroupid = ".$row['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productname";
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;$i=0;
								
							foreach($dataReader1 as $row1)
							{
								$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))							
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['price']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
                $totalnominal += $row1['nominal']/$per;
								$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
                $totalnetto += $row1['netto']/$per;
								
							}	
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'Total : '.$row['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalnominal1 += $totalnominal;
								$totaldiskon1 += $totaldiskon;
								$totalnetto1 += $totalnetto;
								$line+=1;
						}
						$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')								
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon1))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerAreaXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperareabarang';
		parent::actionDownxls();
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;								
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
					$line++;
			$sql1 = "select distinct a.materialgroupid,a.description,f.productid
					from materialgroup a
					join productplant b on b.materialgroupid = a.materialgroupid
					join gireturdetail e on e.productid = b.productid
					join gidetail c on c.gidetailid = e.gidetailid
					join product f on f.productid = e.productid
					join giheader g on g.giheaderid = c.giheaderid
					join soheader h on h.soheaderid = g.soheaderid
					join addressbook i on i.addressbookid = h.addressbookid
					join salesarea j on j.salesareaid = i.salesareaid
					join giretur k on k.gireturid = e.gireturid
					where k.recordstatus = 3 and h.companyid = ".$companyid." and f.productname like '%".$product."%'
					and j.salesareaid = ".$row['salesareaid']."
					and k.gireturdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					group by description";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Grup Material')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Nominal')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
					$line++;
					$sql2 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
							and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid";
					
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$totalnetto = 0;$totalnominal=0;$totaldiskon=0;$i=0;$totalqty=0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))							
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldiskon += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;
								
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'Total '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalnominal1 += $totalnominal;
								$totaldiskon1 += $totaldiskon;
								$totalnetto1 += $totalnetto;
								
								$line+=1;
				}
				
		}
		$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL')								
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
        public function RekapReturPenjualanPerCustomerPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpercustomerperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;								
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Customer')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
					$line++;
					
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
					$line++;
					$sql1 = "select *,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,
							k.fullname,d.gireturdate,n.materialgroupid,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by materialgroupid order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;								
								
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['barang'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))							
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
								$totalnominal += $row1['nominal']/$per;
								$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL CUSTOMER '.$row1['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')	
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
      public function RekapReturPenjualanPerCustomerPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpercustomerperbarangrincian';
		parent::actionDownxls();
		$totaldisc2=0;$totalqty2=0;$totalnominal2=0;$totalnetto2=0;
		$sql = "select distinct k.addressbookid,k.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Customer')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
					$line++;
					$totaldisc1=0;$totalqty1=0;$totalnominal1=0;$totalnetto1=0;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
					$line++;
					$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' 
							and m.areaname like '%".$salesarea."%' and k.addressbookid = ".$row['addressbookid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					
					$sql2 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;	
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}  
	public function RekapReturPenjualanPerSalesPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpersalesperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;	
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
					
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')						
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
				$line++;
				$sql1 = "select *,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,
							k.fullname,d.gireturdate,n.materialgroupid,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by materialgroupid order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;							
								
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['barang'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
								$totalnominal += $row1['nominal']/$per;
								$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;	
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL SALES '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapReturPenjualanPerSalesPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpersalesperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;	
				
		$sql = "select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
					$line++;
					$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' 
							and m.areaname like '%".$salesarea."%' and l.employeeid = ".$row['employeeid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;						
								
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					$sql2 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL SALES '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;
			
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapReturPenjualanPerAreaPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperareaperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')						
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
				$line++;
				$sql1 = "select *,sum(nom) as nominal,sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,
							k.fullname,d.gireturdate,n.materialgroupid,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
							group by materialgroupid order by barang";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['barang'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
								$totalnominal += $row1['nominal']/$per;
								$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;	
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL AREA '.$row['areaname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapReturPenjualanPerAreaPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperareaperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;	
		$sql = "select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
				$line++;
				$sql1 = "select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' 
							and m.areaname like '%".$salesarea."%' and m.salesareaid = ".$row['salesareaid']."
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;	
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					$sql2 = "select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']."
							and n.materialgroupid = ".$row1['materialgroupid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$totaldisc=0;$totalqty=0;$totalnominal=0;$totalnetto=0;$i=0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL AREA '.$row['areaname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;	
			
		$this->getFooterXLS($this->phpExcel);		
	}
	public function RincianPenjualanReturPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rincianpenjualanperdokumen';
		parent::actionDownxls();
		$sql = "select a.invoiceid,a.invoiceno, b.gino, a.invoicedate, d.fullname as customer,h.fullname as sales, e.paydays, c.shipto, a.headernote
				from invoice a
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				join addressbook d on d.addressbookid = c.addressbookid
				join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				join gidetail f on f.giheaderid = b.giheaderid
				join sloc g on g.slocid = f.slocid
				join employee h on h.employeeid = c.employeeid
				join product i on i.productid = f.productid
				join salesarea j on j.salesareaid = d.salesareaid
				where a.recordstatus = 3 and c.companyid = ".$companyid." and g.sloccode like '%".$sloc."%'
				and d.fullname like '%".$customer."%' and h.fullname like '%".$employee."%' and i.productname like '%".$product."%'
				and j.areaname like '%".$salesarea."%' and b.gino is not null
				and a.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by invoiceno order by invoicedate";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
			$totalqty1=0;$total1=0;$totaldisc1=0;$totalnetto1=0;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No. Bukti')
					->setCellValueByColumnAndRow(1,$line,': '.$row['invoiceno'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['invoicedate']);
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['sales'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'Kepada Yth,');
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No. SJ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['gino'])
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['customer']);
					
				$line++;
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'T.O.P')
					->setCellValueByColumnAndRow(1,$line,': '.$row['paydays'].' HARI')
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,$row['shipto']);				
				
				$line++;						
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Barang')
					->setCellValueByColumnAndRow(2,$line,'Qty')
					->setCellValueByColumnAndRow(3,$line,'Unit')
					->setCellValueByColumnAndRow(4,$line,'Price')
					->setCellValueByColumnAndRow(5,$line,'Total');
				$line++;
				$sql1 = "select distinct ss.gidetailid,a.invoiceno,i.productname,k.uomcode,ss.qty,
										(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
										(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nominal,
										(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
										from gidetail zzb 
										join sodetail zza on zza.sodetailid = zzb.sodetailid
										where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
										from invoice a 
										join giheader b on b.giheaderid = a.giheaderid
										join soheader c on c.soheaderid = b.soheaderid
										join addressbook d on d.addressbookid = c.addressbookid
										join employee e on e.employeeid = c.employeeid
										join salesarea f on f.salesareaid = d.salesareaid
										join sodetail g on g.soheaderid = b.soheaderid
										join gidetail ss on ss.giheaderid = b.giheaderid
										join sloc h on h.slocid = ss.slocid
										join product i on i.productid = ss.productid
										join productplant j on j.productid = i.productid
										join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
										where a.recordstatus = 3 and c.companyid = ".$companyid." 
										and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' 
										and e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' 
										and i.productname like '%".$product."%' and a.invoiceid = ".$row['invoiceid']." 
										and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
										and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty=0;$i=0;$total=0;$diskon=0;$netto=0;
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))
							->setCellValueByColumnAndRow(3,$line,$row1['uomcode'])
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['price']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per));
							$line++;						
							$totalqty += $row1['qty'];
							$total += $row1['nominal']/$per;							
							$netto += $row1['nett']/$per;
							$diskon += ($row1['nominal']/$per) - ($row1['nett']/$per);
							$bilangan = explode(".",$netto);
				}
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,'')
							->setCellValueByColumnAndRow(1,$line,'Total')
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
							->setCellValueByColumnAndRow(3,$line,'')
							->setCellValueByColumnAndRow(4,$line,'Nominal')
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($total));
							$line+= 1;
							
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,'')
							->setCellValueByColumnAndRow(1,$line,'')
							->setCellValueByColumnAndRow(2,$line,'')
							->setCellValueByColumnAndRow(3,$line,'')
							->setCellValueByColumnAndRow(4,$line,'Diskon')
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($diskon));
				
				$line++;	
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'')
					->setCellValueByColumnAndRow(1,$line,'Terbilang : '.$this->eja($bilangan[0]))
					->setCellValueByColumnAndRow(2,$line,'')
					->setCellValueByColumnAndRow(3,$line,'')
					->setCellValueByColumnAndRow(4,$line,'Netto')
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($netto));		
					
					
				$line++;	
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'')
					->setCellValueByColumnAndRow(1,$line,'Note : '.$row['headernote']);
					
					$line+= 2;
					$total1 += $total;
					$totaldisc1 += $diskon;
					$totalnetto1 += $netto;
					$totalqty1 += $totalqty;
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)					
				->setCellValueByColumnAndRow(0,$line,'TOTAL PENJUALAN')				
				->setCellValueByColumnAndRow(2,$line,'QTY : '.Yii::app()->format->formatCurrency ($totalqty1))			
				->setCellValueByColumnAndRow(3,$line,'NOMINAL : '.Yii::app()->format->formatCurrency ($total1))
				->setCellValueByColumnAndRow(4,$line,'DISKON : '.Yii::app()->format->formatCurrency ($totaldisc1))
				->setCellValueByColumnAndRow(5,$line,'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1));
				
				
				
				
				
			$line++;			
			$totalnom1=0;$totaldisk1=0;$totalnett1=0;$totqty1=0;
			$sql = "select distinct b.notagirid,b.notagirno,i.fullname as customer,d.gireturdate,j.paycode,h.taxid,b.headernote
						from notagirpro a
						left join notagir b on b.notagirid=a.notagirid
						left join gireturdetail c on c.gireturdetailid=a.gireturdetailid
						left join giretur d on d.gireturid=b.gireturid
						left join product e on e.productid=a.productid
						left join gidetail f on f.gidetailid=c.gidetailid
						left join giheader g on g.giheaderid=d.giheaderid
						left join soheader h on h.soheaderid=g.soheaderid
						left join addressbook i on i.addressbookid=h.addressbookid
						left join paymentmethod j on j.paymentmethodid=h.paymentmethodid
						left join sloc k on k.slocid=a.slocid
						left join employee l on l.employeeid = h.employeeid
						where k.sloccode like '%".$sloc."%' and b.recordstatus = 3 and i.fullname like '%".$customer."%' and 
						h.companyid = ".$companyid." and e.productname like '%".$product."%' and l.fullname like '%".$employee."%' and
						d.gireturdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Dokumen')
				->setCellValueByColumnAndRow(1,$line,': '.$row['notagirno'])
				->setCellValueByColumnAndRow(4,$line,'Tanggal')
				->setCellValueByColumnAndRow(5,$line,': '.$row['gireturdate']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['customer'])
				->setCellValueByColumnAndRow(4,$line,'T.O.P')
				->setCellValueByColumnAndRow(5,$line,': '.$row['paycode'].' HARI');
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Harga')
				->setCellValueByColumnAndRow(4,$line,'Jumlah')
				->setCellValueByColumnAndRow(5,$line,'Keterangan');
			$line++;
			$sql1 = "select *,(nominal-netto) as disc from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nominal,a.price as harga,(a.qty*a.price) as netto,b.headernote
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and b.notagirid = ".$row['notagirid']." 
							and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							)z order by notagirno,notagirproid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row1['productname'])
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($row1['qty']))
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($row1['price']/$per))
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($row1['nominal']/$per))
				->setCellValueByColumnAndRow(5,$line,$row['headernote']);
				$line++;
				$totalqty += $row1['qty'];
				$totalnominal += $row1['nominal']/$per;
				$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
				$totalnetto += $row1['netto']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Keterangan : '.$row1['headernote'])
				->setCellValueByColumnAndRow(4,$line,'Nominal')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnominal));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(4,$line,'Diskon')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon));
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(4,$line,'Netto')
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
			$line++;
			$totqty1 += $totalqty;
			$totalnom1 += $totalnominal;
			$totaldisk1 += $totaldiskon;
			$totalnett1 += $totalnetto;
			$line+=1;
			
		}
		$this->phpExcel->setActiveSheetIndex(0)					
				->setCellValueByColumnAndRow(0,$line,'TOTAL RETUR PENJUALAN')				
				->setCellValueByColumnAndRow(2,$line,'QTY : '.Yii::app()->format->formatCurrency ($totqty1))			
				->setCellValueByColumnAndRow(3,$line,'NOMINAL : '.Yii::app()->format->formatCurrency ($totalnom1))
				->setCellValueByColumnAndRow(4,$line,'DISKON : '.Yii::app()->format->formatCurrency ($totaldisk1))
				->setCellValueByColumnAndRow(5,$line,'NETTO : '.Yii::app()->format->formatCurrency($totalnett1));				
			$line++;
			
			$line+=1;			
			$this->phpExcel->setActiveSheetIndex(0)					
				->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')				
				->setCellValueByColumnAndRow(2,$line,'QTY : '.Yii::app()->format->formatCurrency ($totalqty1 - $totqty1))			
				->setCellValueByColumnAndRow(3,$line,'NOMINAL : '.Yii::app()->format->formatCurrency ($total1 - $totalnom1))
				->setCellValueByColumnAndRow(4,$line,'DISKON : '.Yii::app()->format->formatCurrency ($totaldisc1 - $totaldisk1))
				->setCellValueByColumnAndRow(5,$line,'NETTO : '.Yii::app()->format->formatCurrency($totalnetto1 - $totalnett1));
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerDokumenXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturperdokumen';
		parent::actionDownxls();
		$sql = "select invoiceno,invoicedate,fullname,headernote,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
							(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						  from gidetail zzb 
						  join sodetail zza on zza.sodetailid = zzb.sodetailid
						  where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
              c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
              e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
              a.invoiceno is not null and a.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by invoiceno
              )z group by invoiceno"; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			$i=0;$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'No. Bukti')
					->setCellValueByColumnAndRow(2,$line,'Tanggal')
					->setCellValueByColumnAndRow(3,$line,'Customer')
					->setCellValueByColumnAndRow(4,$line,'Nominal')
					->setCellValueByColumnAndRow(5,$line,'Disc')
					->setCellValueByColumnAndRow(6,$line,'Netto')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');					
					$line++;
			foreach($dataReader as $row)
			{												
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row['invoiceno'])
							->setCellValueByColumnAndRow(2,$line,$row['invoicedate'])
							->setCellValueByColumnAndRow(3,$line,$row['fullname'])
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row['nominal']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row['disc']/$per))
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row['netto']/$per))
							->setCellValueByColumnAndRow(7,$line,$row['headernote']);
							$line++;				
					
					$totalnominal1 += $row['nominal']/$per;
          $totaldisc1 += $row['disc']/$per;
          $totaljumlah1 += $row['netto']/$per;				
							
			}
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)				
				->setCellValueByColumnAndRow(3,$line,'TOTAL PENJUALAN')				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totaljumlah1));

			
			
		$line++;
		$nominal=0;$diskon=0;$netto=0;		
		$sql = "select *, sum(nom) as nominal, sum(nett) as netto from
							(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
							g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)		
		$line++;
		$i=0;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Dokumen')
				->setCellValueByColumnAndRow(2,$line,'Tanggal')
				->setCellValueByColumnAndRow(3,$line,'Customer')
				->setCellValueByColumnAndRow(4,$line,'Nominal')
				->setCellValueByColumnAndRow(5,$line,'Diskon')
				->setCellValueByColumnAndRow(6,$line,'Netto');
		$line++;
		foreach($dataReader as $row)
		{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['notagirno'])
					->setCellValueByColumnAndRow(2,$line,$row['gireturdate'])
					->setCellValueByColumnAndRow(3,$line,$row['fullname'])
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row['nominal']/$per))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row['nominal']/$per) - ($row['netto']/$per)))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row['netto']/$per));
				$line++;
				$nominal += $row['nominal']/$per;
				$diskon += ($row['nominal']/$per) - ($row['netto']/$per);
				$netto += $row['netto']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'TOTAL RETUR')
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($nominal))				
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($diskon))				
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($netto));
			$line++;
		
		
		$line++;
			$this->phpExcel->setActiveSheetIndex(0)				
				->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL')				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1 - $nominal))
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1 - $diskon))
				->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totaljumlah1 - $netto));
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerCustomerXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpercustomer';
		parent::actionDownxls();
		$sql = "select distinct addressbookid,fullname from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$employee."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
		
		$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;
			
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Customer')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
						->setCellValueByColumnAndRow(2,$line,'Tanggal')
						->setCellValueByColumnAndRow(3,$line,'Nominal')
						->setCellValueByColumnAndRow(4,$line,'Diskon')
						->setCellValueByColumnAndRow(5,$line,'Netto')
						->setCellValueByColumnAndRow(6,$line,'Keterangan');
					$line++;
					$sql1 = "select * from
							(select invoiceno as dokumen,invoicedate as tanggal,sum(nom) as nominal,(sum(nom)-sum(nett)) as diskon,sum(nett) as netto,headernote from
							(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
							(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						  from gidetail zzb 
						  join sodetail zza on zza.sodetailid = zzb.sodetailid
						  where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							where a.recordstatus = 3 and a.invoiceno is not null and
							c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
							e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
							a.invoiceno is not null and a.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and d.addressbookid = ".$row['addressbookid']." order by invoiceno)z group by invoiceno
							union
							select notagirno as dokumen,gireturdate as tanggal,sum(nom) as nominal,sum(disc) as diskon,sum(nett) as netto,headernote from
							(select distinct a.notagirproid,b.notagirno,(-1*a.qty*g.price) as nom,(-1*a.qty*g.price)-(-1*a.qty*a.price) as disc,
							(-1*a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
							)z group by notagirno)zz order by dokumen";
					
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totaldiskon = 0;$totalnominal=0;$totalnetto=0;$i=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row1['dokumen'])
							->setCellValueByColumnAndRow(2,$line,$row1['tanggal'])									
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['diskon']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per))
							->setCellValueByColumnAndRow(6,$line,$row1['headernote']);
				$line++;
				$totalnominal += $row1['nominal']/$per;
				$totaldiskon += $row1['diskon']/$per;
				$totalnetto += $row1['netto']/$per;
				
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'TOTAL')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
			$line++;
			$totalnominal1 += $totalnominal;
			$totaldiskon1 += $totaldiskon;
			$totalnetto1 += $totalnetto;
			$line+=1;
		}
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'TOTAL')
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon1))				
				->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
			$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerSalesXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpersales';
		parent::actionDownxls();
		$totalnominal1=0;$totaldisc1=0;$totaljumlah1=0;		
		$sql = "select distinct employeeid,fullname from
							(select distinct k.employeeid,k.fullname
							from soheader b
							join sodetail c on c.soheaderid = b.soheaderid
							join gidetail d on d.sodetailid = c.sodetailid
							join product e on e.productid = d.productid
							join addressbook f on f.addressbookid = b.addressbookid
							join salesarea g on g.salesareaid = f.salesareaid
							join giheader h on h.giheaderid = d.giheaderid
							join sloc i on i.slocid = d.slocid
							join invoice j on j.giheaderid = h.giheaderid
							join employee k on k.employeeid = b.employeeid
							where j.recordstatus = 3 and j.invoiceno is not null 
							and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
							and f.fullname like '%".$customer."%' and k.fullname like '%".$employee."%'
							and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							union
							select distinct l.employeeid,l.fullname
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Customer')
						->setCellValueByColumnAndRow(2,$line,'Nominal')
						->setCellValueByColumnAndRow(3,$line,'Disc')
						->setCellValueByColumnAndRow(4,$line,'Netto');
				$line++;
				$sql1 = "select fullname,sum(nominal) as nominal,sum(disc) as disc,sum(netto) as netto from
								(select fullname,sum(nom) as nominal,(sum(nom)-sum(nett)) as disc,sum(nett) as netto from
								(select distinct ss.gidetailid,a.invoiceno,a.invoicedate,d.fullname,i.productname,k.uomcode,ss.qty,a.headernote,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
                c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
                e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' and a.invoiceno is not null and 
                a.invoiceno is not null and a.invoicedate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
								'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
								and e.employeeid = ".$row['employeeid'].")z group by fullname
								union
								select fullname, -1*sum(nom) as nominal, -1*(sum(nom)-sum(nett)) as disc, -1*sum(nett) as netto from
								(select distinct a.notagirproid,b.notagirno,replace(f.gino,'SJ','INV') as invoiceno,i.productname,a.qty,
								g.price,(a.qty*g.price) as nom,a.price as harga,(a.qty*a.price) as nett,b.headernote,k.fullname,d.gireturdate
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by notagirno,notagirproid
								)z group by fullname) zz group by fullname order by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totaldisc = 0;$totalnominal=0;$total=0;$i=0;
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row1['fullname'])															
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['disc']/$per))
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
					$line++;
					$totalnominal += $row1['nominal']/$per;
					$totaldisc += $row1['disc']/$per;
					$total += $row1['netto']/$per;
				}
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'TOTAL SALES')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalnominal))				
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totaldisc))				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($total));
				$line++;
				$totalnominal1 += $totalnominal;
				$totaldisc1 += $totaldisc;
				$totaljumlah1 += $total;
				$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'TOTAL')
				->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
				->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
				->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaljumlah1));
				$line++;
		
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerBarangXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturperbarang';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;
		$sql = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
			
       $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
        foreach($dataReader as $row)
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
				foreach($dataReader as $row)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Divisi')
					->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
					$line++;
					
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Barang')
					->setCellValueByColumnAndRow(2,$line,'Qty')
					->setCellValueByColumnAndRow(3,$line,'Price')
					->setCellValueByColumnAndRow(4,$line,'Total')
					->setCellValueByColumnAndRow(5,$line,'Disc')
					->setCellValueByColumnAndRow(6,$line,'Netto');					
					$line++;
					$sql1 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row['materialgroupid']."
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row['materialgroupid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
                
						$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
            $totalqty=0;$totalnominal=0;$totaldiskon=0;$totalnetto=0;$i=0;
								
						foreach($dataReader1 as $row1)
						{
							$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['harga']))
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per - $row1['netto']/$per))
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
							$line++;
							
							$totalqty += $row1['qty'];
              $totalnominal += $row1['nominal']/$per;
							$totaldiskon += ($row1['nominal']/$per) - ($row1['netto']/$per);
              $totalnetto += $row1['netto']/$per;
						}
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,$line,'TOTAL : '.$row['description'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))	
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
						$line++;
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldiskon1 += $totaldiskon;
						$totalnetto1 += $totalnetto;
						$line += 1;
				}
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))	
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldiskon1))				
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
						$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerAreaXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturperarea';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldiskon2=0;$totalnetto2=0;	
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
					$line++;
					$sql1 = "select materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zg.salesareaid = ".$row['salesareaid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$totalqty1=0;$totalnominal1=0;$totaldiskon1=0;$totalnetto1=0;				
						
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Group Material')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Barang')
					->setCellValueByColumnAndRow(2,$line,'Qty')					
					->setCellValueByColumnAndRow(3,$line,'Nominal')
					->setCellValueByColumnAndRow(4,$line,'Disc')
					->setCellValueByColumnAndRow(5,$line,'Netto');					
					$line++;
					$sql2 = "select productname,sum(qty) as qty,sum(harga)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and f.salesareaid = ".$row['salesareaid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty),-1*sum(price)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,a.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$totalnetto = 0;$totalnominal=0;$totaldiskon=0;$i=0;$totalqty=0;
					
					foreach($dataReader2 as $row2)
					{
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row2['productname'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))							
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per - $row2['netto']/$per))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
							$line++;
							$totalqty += $row2['qty'];
							$totalnominal += $row2['nominal']/$per;
							$totaldiskon += ($row2['nominal']/$per) - ($row2['netto']/$per);
							$totalnetto += $row2['netto']/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,$line,'Total '.$row1['description'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))	
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon))				
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
						$line++;
						$totalqty1 += $totalqty;
						$totalnominal1 += $totalnominal;
						$totaldiskon1 += $totaldiskon;
						$totalnetto1 += $totalnetto;
						
				}
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row['areaname'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))	
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon1))				
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
						$line++;
						$totalqty2 += $totalqty1;
						$totalnominal2 += $totalnominal1;
						$totaldiskon2 += $totaldiskon1;
						$totalnetto2 += $totalnetto1;
						
						$line += 1;
		}
		$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))	
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldiskon2))				
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto2));
						$line++;
						
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerCustomerPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpercustomerperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;					
								
		$sql = "select distinct addressbookid,fullname from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$employee."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Customer')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
				$line++;
				$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.addressbookid = ".$row['addressbookid']." and
						  e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z group by barang) zz 
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;							
								
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['barang'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
								$totalnominal += $row1['nominal']/$per;
								$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;	
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL CUSTOMER '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;					
								
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerCustomerPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpercustomerperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;				
								
		$sql = "select distinct addressbookid,fullname from 
				(select distinct g.addressbookid,g.fullname
				from soheader b
				join sodetail c on c.soheaderid = b.soheaderid
				join gidetail d on d.sodetailid = c.sodetailid
				join product e on e.productid = d.productid
				join employee f on f.employeeid = b.employeeid
	      join addressbook g on g.addressbookid = b.addressbookid  
				join giheader h on h.giheaderid = d.giheaderid
				join sloc i on i.slocid = d.slocid
				join invoice j on j.giheaderid = h.giheaderid
        join salesarea k on k.salesareaid = g.salesareaid
				where j.recordstatus = 3 and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
				and g.fullname like '%".$customer."%' and f.fullname like '%".$employee."%' 
				and e.productname like '%".$product."%' and	k.areaname like '%".$salesarea."%' 
				and j.invoiceno is not null and j.invoicedate between	'". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and	'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				union
				select distinct k.addressbookid,k.fullname
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join gireturdetail c on c.gireturdetailid=a.gireturdetailid
				join giretur d on d.gireturid=b.gireturid
				join gidetail e on e.gidetailid=c.gidetailid
				join giheader f on f.giheaderid=d.giheaderid
				join sodetail g on g.sodetailid=e.sodetailid
				join soheader h on h.soheaderid=f.soheaderid
				join product i on i.productid = a.productid
				join sloc j on j.slocid = a.slocid
				join addressbook k on k.addressbookid = h.addressbookid
				join employee l on l.employeeid = h.employeeid
				join salesarea m on m.salesareaid = k.salesareaid
				where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
				and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
				and i.productname like '%".$product."%' and d.gireturdate between 
				'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Customer')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zf.addressbookid = ".$row['addressbookid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;							
								
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
				
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
					$line++;
					
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and d.addressbookid = ".$row['addressbookid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and k.addressbookid = ".$row['addressbookid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;						
								
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'Total '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL CUSTOMER '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerSalesPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpersalesperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;
		$sql = "select distinct employeeid,fullname from
					(select distinct k.employeeid,k.fullname
					from soheader b
					join sodetail c on c.soheaderid = b.soheaderid
					join gidetail d on d.sodetailid = c.sodetailid
					join product e on e.productid = d.productid
					join addressbook f on f.addressbookid = b.addressbookid
					join salesarea g on g.salesareaid = f.salesareaid
					join giheader h on h.giheaderid = d.giheaderid
					join sloc i on i.slocid = d.slocid
					join invoice j on j.giheaderid = h.giheaderid
					join employee k on k.employeeid = b.employeeid
					where j.recordstatus = 3 and j.invoiceno is not null 
					and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
					and f.fullname like '%".$customer."%' and k.fullname like '%".$employee."%'
					and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct l.employeeid,l.fullname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
					and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
					and i.productname like '%".$product."%' and d.gireturdate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')						
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
					$line++;
					$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and e.employeeid = ".$row['employeeid']." and
						  e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z group by barang) zz 
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;					
						
				foreach($dataReader1 as $row1)
				{
					$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row1['barang'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))									
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
								$line++;
								$totalqty += $row1['qty'];
								$totalnominal += $row1['nominal']/$per;
								$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
								$totalnetto += $row1['netto']/$per;
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL SALES  '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerSalesPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpersalesperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;						
								
		$sql = "select distinct employeeid,fullname from
					(select distinct k.employeeid,k.fullname
					from soheader b
					join sodetail c on c.soheaderid = b.soheaderid
					join gidetail d on d.sodetailid = c.sodetailid
					join product e on e.productid = d.productid
					join addressbook f on f.addressbookid = b.addressbookid
					join salesarea g on g.salesareaid = f.salesareaid
					join giheader h on h.giheaderid = d.giheaderid
					join sloc i on i.slocid = d.slocid
					join invoice j on j.giheaderid = h.giheaderid
					join employee k on k.employeeid = b.employeeid
					where j.recordstatus = 3 and j.invoiceno is not null 
					and b.companyid = ".$companyid." and i.sloccode like '%".$sloc."%' 
					and f.fullname like '%".$customer."%' and k.fullname like '%".$employee."%'
					and e.productname like '%".$product."%' and g.areaname like '%".$salesarea."%' and j.invoicedate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct l.employeeid,l.fullname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
					and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
					and i.productname like '%".$product."%' and d.gireturdate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Sales')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
				$line++;
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zd.employeeid = ".$row['employeeid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;						
						
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
				$line++;
				$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and e.employeeid = ".$row['employeeid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and l.employeeid = ".$row['employeeid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;				
						
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;	
								
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL SALES '.$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerAreaPerBarangTotalXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturperareaperbarangtotal';
		parent::actionDownxls();
		$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;	
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Material Group')
						->setCellValueByColumnAndRow(2,$line,'Qty')						
						->setCellValueByColumnAndRow(3,$line,'Total')
						->setCellValueByColumnAndRow(4,$line,'Disc')
						->setCellValueByColumnAndRow(5,$line,'Netto');
				$line++;
				$sql1 = "select barang,sum(qty) as qty,sum(nominal) as nominal,sum(netto) as netto from
							(select barang,sum(qty) as qty,sum(nom) as nominal,sum(nett) as netto from
							(select distinct ss.gidetailid,ss.qty,l.description as barang,
							(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
							(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
						   from gidetail zzb 
						   join sodetail zza on zza.sodetailid = zzb.sodetailid
						   where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
							from invoice a 
							join giheader b on b.giheaderid = a.giheaderid
							join soheader c on c.soheaderid = b.soheaderid
							join addressbook d on d.addressbookid = c.addressbookid
							join employee e on e.employeeid = c.employeeid
							join salesarea f on f.salesareaid = d.salesareaid
							join sodetail g on g.soheaderid = b.soheaderid
							join gidetail ss on ss.giheaderid = b.giheaderid
							join sloc h on h.slocid = ss.slocid
							join product i on i.productid = ss.productid
							join productplant j on j.productid = i.productid and j.slocid=g.slocid
							join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
							join materialgroup l on l.materialgroupid = j.materialgroupid
							where a.recordstatus = 3 and a.invoiceno is not null and
						  c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and f.salesareaid = ".$row['salesareaid']." and
						  e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
						  and a.invoiceno is not null
						  and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						  and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz group by barang
							union
							select barang,-1*sum(qty) as qty,-1*sum(nom) as nominal,-1*sum(nett) as netto from 
							(select distinct a.notagirproid,a.qty,(a.qty*g.price) as nom,(a.qty*a.price) as nett,o.description as barang
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z group by barang) zz 
							group by barang order by barang";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;									
						
				foreach($dataReader1 as $row1)
				{
					$i+=1;
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row1['barang'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))									
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['nominal']/$per))									
							->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency (($row1['nominal']/$per) - ($row1['netto']/$per)))
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['netto']/$per));
						$line++;
						
						$totalqty += $row1['qty'];
						$totalnominal += $row1['nominal']/$per;
						$totaldisc += ($row1['nominal']/$per) - ($row1['netto']/$per);
						$totalnetto += $row1['netto']/$per;	
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL AREA '.$row['areaname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
								
								$line += 1;
								
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
		
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerAreaPerBarangRincianXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturperareaperbarangrincian';
		parent::actionDownxls();
		$totalqty2=0;$totalnominal2=0;$totaldisc2=0;$totalnetto2=0;
		$sql = "select distinct salesareaid,areaname from
					(select distinct zg.salesareaid,zg.areaname
				  from soheader za 
					join giheader zb on zb.soheaderid = za.soheaderid
					join gidetail zc on zc.giheaderid = zb.giheaderid
					join employee zd on zd.employeeid = za.employeeid
					join invoice ze on ze.giheaderid = zc.giheaderid
				  join addressbook zf on zf.addressbookid = za.addressbookid
				  left join salesarea zg on zg.salesareaid = zf.salesareaid
				  join product zh on zh.productid = zc.productid
				  join sloc zi on zi.slocid = zc.slocid
					where ze.recordstatus = 3 and za.companyid = ".$companyid." and zi.sloccode like '%".$sloc."%' 
					and zd.fullname like '%".$employee."%' and zh.productname like '%".$product."%' 
					and zg.areaname like '%".$salesarea."%' and zf.fullname like '%".$customer."%'
					and ze.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
					select distinct m.salesareaid,m.areaname
					from notagirpro a
					join notagir b on b.notagirid=a.notagirid
					join gireturdetail c on c.gireturdetailid=a.gireturdetailid
					join giretur d on d.gireturid=b.gireturid
					join gidetail e on e.gidetailid=c.gidetailid
					join giheader f on f.giheaderid=d.giheaderid
					join sodetail g on g.sodetailid=e.sodetailid
					join soheader h on h.soheaderid=f.soheaderid
					join product i on i.productid = a.productid
					join sloc j on j.slocid = a.slocid
					join addressbook k on k.addressbookid = h.addressbookid
					join employee l on l.employeeid = h.employeeid
					join salesarea m on m.salesareaid = k.salesareaid
					join productplant n on n.productid=a.productid and n.slocid=a.slocid
					where b.recordstatus = 3 and h.companyid = ".$companyid." and k.fullname like '%".$customer."%' 
					and j.sloccode like '%".$sloc."%' and i.productname like '%".$product."%' 
					and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%' and d.gireturdate 
					between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')zz order by areaname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
							
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Area')
					->setCellValueByColumnAndRow(1,$line,': '.$row['areaname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Qty')
						->setCellValueByColumnAndRow(3,$line,'Price')
						->setCellValueByColumnAndRow(4,$line,'Total')
						->setCellValueByColumnAndRow(5,$line,'Disc')
						->setCellValueByColumnAndRow(6,$line,'Netto');
				$line++;
				$sql1 = "select distinct materialgroupid,materialgroupcode,description from 
							(select distinct zk.materialgroupid,zk.materialgroupcode,zk.description
							from soheader za 
							join giheader zb on zb.soheaderid = za.soheaderid
							join gidetail zc on zc.giheaderid = zb.giheaderid
							join sodetail zs on zs.sodetailid = zc.sodetailid
							left join employee zd on zd.employeeid = za.employeeid
							join product ze on ze.productid = zs.productid
							left join addressbook zf on zf.addressbookid = za.addressbookid
							left join salesarea zg on zg.salesareaid = zf.salesareaid
							join sloc zh on zh.slocid = zc.slocid
							join invoice zi on zi.giheaderid = zc.giheaderid
							join productplant zj on zj.productid=zc.productid and zj.slocid=zc.slocid
							join materialgroup zk on zk.materialgroupid=zj.materialgroupid
							where zi.recordstatus = 3 and zi.invoiceno is not null and za.companyid = ".$companyid." and
							zf.fullname like '%".$customer."%' and zd.fullname like '%".$employee."%' and ze.productname like '%".$product."%' and
							zg.areaname like '%".$salesarea."%' and zh.sloccode like '%".$sloc."%' and zg.salesareaid = ".$row['salesareaid']." and
							zi.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'						
							union
							select distinct o.materialgroupid,o.materialgroupcode,o.description
							from notagirpro a
							join notagir b on b.notagirid=a.notagirid
							join gireturdetail c on c.gireturdetailid=a.gireturdetailid
							join giretur d on d.gireturid=b.gireturid
							join gidetail e on e.gidetailid=c.gidetailid
							join giheader f on f.giheaderid=d.giheaderid
							join sodetail g on g.sodetailid=e.sodetailid
							join soheader h on h.soheaderid=f.soheaderid
							join product i on i.productid = a.productid
							join sloc j on j.slocid = a.slocid
							join addressbook k on k.addressbookid = h.addressbookid
							join employee l on l.employeeid = h.employeeid
							join salesarea m on m.salesareaid = k.salesareaid
							join productplant n on n.productid=a.productid and n.slocid=a.slocid
							join materialgroup o on o.materialgroupid=n.materialgroupid
							where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
							and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
							and i.productname like '%".$product."%' and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
							'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z order by description";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty1=0;$totalnominal1=0;$totaldisc1=0;$totalnetto1=0;	
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Material Group')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);
					$line++;
					$sql2 = "select productname,sum(qty) as qty,sum(harga*qty)/sum(qty) as harga,sum(nominal) as nominal,sum(netto) as netto from 
								(select productname,sum(qty) as qty,sum(price*qty)/sum(qty) as harga,sum(nom) as nominal,sum(nett) as netto from
								(select distinct ss.gidetailid,d.fullname,i.productid,i.productname,k.uomcode,ss.qty,
								(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid) as price,
								(ss.qty*(select xx.price from sodetail xx where xx.sodetailid=ss.sodetailid)) as nom,
								(select getamountdiscso(zza.soheaderid,zza.sodetailid,zzb.qty)
								from gidetail zzb 
								join sodetail zza on zza.sodetailid = zzb.sodetailid
								where zzb.giheaderid = b.giheaderid and zzb.productid = i.productid and zzb.gidetailid=ss.gidetailid) as nett
								from invoice a 
								join giheader b on b.giheaderid = a.giheaderid
								join soheader c on c.soheaderid = b.soheaderid
								join addressbook d on d.addressbookid = c.addressbookid
								join employee e on e.employeeid = c.employeeid
								join salesarea f on f.salesareaid = d.salesareaid
								join sodetail g on g.soheaderid = b.soheaderid
								join gidetail ss on ss.giheaderid = b.giheaderid
								join sloc h on h.slocid = ss.slocid
								join product i on i.productid = ss.productid
								join productplant j on j.productid = i.productid and j.slocid=g.slocid
								join unitofmeasure k on k.unitofmeasureid = ss.unitofmeasureid
								where a.recordstatus = 3 and a.invoiceno is not null and
								c.companyid = ".$companyid." and h.sloccode like '%".$sloc."%' and d.fullname like '%".$customer."%' and
								e.fullname like '%".$employee."%' and f.areaname like '%".$salesarea."%' and i.productname like '%".$product."%' 
								and a.invoiceno is not null and j.materialgroupid = ".$row1['materialgroupid']." and f.salesareaid = ".$row['salesareaid']." 
								and a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								)z group by productname
								union
								select productname,-1*sum(qty) as qty,-1*sum(price*qty)/sum(qty) as harga,-1*sum(nom) as nominal,-1*sum(nett) as netto from
								(select distinct a.notagirproid,i.productname,a.qty,(a.qty*g.price) as nom,g.price,(a.qty*a.price) as nett
								from notagirpro a
								join notagir b on b.notagirid=a.notagirid
								join gireturdetail c on c.gireturdetailid=a.gireturdetailid
								join giretur d on d.gireturid=b.gireturid
								join gidetail e on e.gidetailid=c.gidetailid
								join giheader f on f.giheaderid=d.giheaderid
								join sodetail g on g.sodetailid=e.sodetailid
								join soheader h on h.soheaderid=f.soheaderid
								join product i on i.productid = a.productid
								join sloc j on j.slocid = a.slocid
								join addressbook k on k.addressbookid = h.addressbookid
								join employee l on l.employeeid = h.employeeid
								join salesarea m on m.salesareaid = k.salesareaid
								join productplant n on n.productid=a.productid and n.slocid=a.slocid
								where h.companyid = ".$companyid." and b.recordstatus = 3 and j.sloccode like '%".$sloc."%' 
								and k.fullname like '%".$customer."%' and l.fullname like '%".$employee."%' and m.areaname like '%".$salesarea."%'
								and i.productname like '%".$product."%' and n.materialgroupid = ".$row1['materialgroupid']." 
								and m.salesareaid = ".$row['salesareaid']." and d.gireturdate between 
								'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
								and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z group by productname)zz 
								group by productname order by productname";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$i=0;$totalqty=0;$totalnominal=0;$totaldisc=0;$totalnetto=0;					
								
					foreach($dataReader2 as $row2)
					{
						$i+=1;
								$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row2['productname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row2['qty']))
									->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row2['harga']/$per))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($row2['nominal']/$per))									
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency (($row2['nominal']/$per) - ($row2['netto']/$per)))
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row2['netto']/$per));
								$line++;
								$totalqty += $row2['qty'];
								$totalnominal += $row2['nominal']/$per;
								$totaldisc += ($row2['nominal']/$per) - ($row2['netto']/$per);
								$totalnetto += $row2['netto']/$per;	
					}
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL '.$row1['description'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto));
								$line++;
								$totalqty1 += $totalqty;
								$totalnominal1 += $totalnominal;
								$totaldisc1 += $totaldisc;
								$totalnetto1 += $totalnetto;
				}
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'TOTAL AREA '.$row['areaname'])
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty1))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal1))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc1))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto1));
								$line++;
								$totalqty2 += $totalqty1;
								$totalnominal2 += $totalnominal1;
								$totaldisc2 += $totaldisc1;
								$totalnetto2 += $totalnetto1;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
									->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($totalqty2))
									->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency ($totalnominal2))				
									->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($totaldisc2))				
									->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($totalnetto2));
								$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RincianSalesOrderOutstandingXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rinciansalesorderoutstanding';
		parent::actionDownxls();
		$sql = "select a.soheaderid,a.sodate,a.sono,b.fullname as customer,d.fullname as sales,g.slocid,a.headernote,
							c.paydays
							from soheader a
							join addressbook b on b.addressbookid = a.addressbookid
							join paymentmethod c on c.paymentmethodid = a.paymentmethodid
							join employee d on d.employeeid = a.employeeid
							join salesarea e on e.salesareaid = b.salesareaid
							join sodetail f on f.soheaderid = a.soheaderid
							join sloc g on g.slocid = f.slocid
							where a.recordstatus > 2 and f.qty > f.giqty and a.companyid = ".$companyid." and 
							d.fullname like '%".$employee."%' and b.fullname like '%".$customer."%' and e.areaname like '%".$salesarea."%' and 
							a.sodate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
							'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and f.productid in 
							(select x.productid 
							from sodetail x 
							join product xx on xx.productid = x.productid 
							join sloc xa on xa.slocid = x.slocid
							where xx.productname like '%".$product."%' and x.giqty < x.qty and xx.isstock = 1 and 
							xa.sloccode like '%".$sloc."%') group by soheaderid";	
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No. SO')
				->setCellValueByColumnAndRow(1,$line,': '.$row['sono'])
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,'')
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,'Tgl. SO')
				->setCellValueByColumnAndRow(6,$line,': '.$row['sodate']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Sales')
				->setCellValueByColumnAndRow(1,$line,': '.$row['sales'])
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,'')
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,'T.O.P')
				->setCellValueByColumnAndRow(6,$line,': '.$row['paydays']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Customer')
				->setCellValueByColumnAndRow(1,$line,': '.$row['customer'])
				->setCellValueByColumnAndRow(2,$line,'')
				->setCellValueByColumnAndRow(3,$line,'')
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,'')
				->setCellValueByColumnAndRow(6,$line,'');
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Qty Gi')
				->setCellValueByColumnAndRow(4,$line,'Satuan')
				->setCellValueByColumnAndRow(5,$line,'Harga')
				->setCellValueByColumnAndRow(6,$line,'Jumlah');
				$line++;
				$sql1 = "select productname, giqty, qty, price, uomcode, jumlah, amountafterdisc from (select b.productname, a.qty, a.giqty, c.uomcode,a.price,(qty * price) + (e.taxvalue * qty * price / 100) as jumlah, a.qty-ifnull(a.giqty,0) as sisa, gettotalamountdiscso(a.soheaderid) as amountafterdisc
										from sodetail a 
										inner join product b on b.productid = a.productid
										inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
										left join currency d on d.currencyid = a.currencyid
										left join soheader f on f.soheaderid = a.soheaderid 
										left join tax e on e.taxid = f.taxid
										join product g on g.productid = a.productid
										where b.productname like '%".$product."%' and g.isstock = 1 and a.soheaderid = '".$row['soheaderid']."') z 
										where sisa > 0";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;$totalgiqty=0;
				
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])
							->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency ($row1['qty']))
							->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency ($row1['giqty']))
							->setCellValueByColumnAndRow(4,$line,$row1['uomcode'])
							->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['price']/$per))
							->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency ($row1['jumlah']/$per));
							$line++;
					$totalqty += $row1['qty'];
					$totalgiqty += $row1['giqty'];
					$total += $row1['jumlah']/$per;
					$disc = ($row1['amountafterdisc']/$per) - $total;
				}
				$this->phpExcel->setActiveSheetIndex(0)														
											->setCellValueByColumnAndRow(1,$line,'Total')
											->setCellValueByColumnAndRow(2,$line,$totalqty)
											->setCellValueByColumnAndRow(3,$line,$totalgiqty)
											->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($total));
											$line++;
											
				$this->phpExcel->setActiveSheetIndex(0)														
											->setCellValueByColumnAndRow(4,$line,'Disc')
											->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($disc));
											$line++;							
				$this->phpExcel->setActiveSheetIndex(0)														
											->setCellValueByColumnAndRow(4,$line,'Netto')
											->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency ($row1['amountafterdisc']/$per));
											$line++;	
											$line+= 1;
			}
			
			
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapSuratJalanBelumDibuatkanFakturXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapsuratjalanbelumdibuatkanfaktur';
		parent::actionDownxls();
		$sql = "select a.gino,a.gidate,c.fullname as customer,d.fullname as sales,a.headernote
                        from giheader a
                        join soheader b on b.soheaderid = a.soheaderid
                        join addressbook c on c.addressbookid = b.addressbookid
                        join employee d on d.employeeid = b.employeeid
                        join salesarea e on e.salesareaid = c.salesareaid
                        join gidetail f on f.giheaderid = a.giheaderid
                        join sloc g on g.slocid = f.slocid
                        join product h on h.productid = f.productid
                        where a.giheaderid not in
                        (select t.giheaderid from invoice t)
                        and a.gino is not null
                        and b.companyid = ".$companyid." and g.sloccode like '%".$sloc."%' and c.fullname like '%".$customer."%' and
                         d.fullname like '%".$employee."%' and e.areaname like '%".$salesarea."%' and h.productname like '%".$product."%' and
                         a.gidate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
			and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by gino,customer,sales order by gino";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'No. Bukti')
				->setCellValueByColumnAndRow(2,$line,'Tanggal')
				->setCellValueByColumnAndRow(3,$line,'Customer')
				->setCellValueByColumnAndRow(4,$line,'Sales')
				->setCellValueByColumnAndRow(5,$line,'Keterangan');
				$line++;
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i+=1)
							->setCellValueByColumnAndRow(1,$line,$row['gino'])
							->setCellValueByColumnAndRow(2,$line,$row['gidate'])
							->setCellValueByColumnAndRow(3,$line,$row['customer'])
							->setCellValueByColumnAndRow(4,$line,$row['sales'])
							->setCellValueByColumnAndRow(5,$line,$row['headernote']);
							$line++;
			}
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanPerCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanpercustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
		$sql = "select * from
					(select z.fullname,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
					from addressbook z
					where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
					where zz.jumlah <> 0";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;
			
		foreach($dataReader as $row)
		{
			$i=$i+1;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row['fullname'])
				->setCellValueByColumnAndRow(2,$line,$row['januari']/$per)
				->setCellValueByColumnAndRow(3,$line,$row['februari']/$per)
				->setCellValueByColumnAndRow(4,$line,$row['maret']/$per)
				->setCellValueByColumnAndRow(5,$line,$row['april']/$per)
				->setCellValueByColumnAndRow(6,$line,$row['mei']/$per)
				->setCellValueByColumnAndRow(7,$line,$row['juni']/$per)
				->setCellValueByColumnAndRow(8,$line,$row['juli']/$per)
				->setCellValueByColumnAndRow(9,$line,$row['agustus']/$per)
				->setCellValueByColumnAndRow(10,$line,$row['september']/$per)
				->setCellValueByColumnAndRow(11,$line,$row['oktober']/$per)
				->setCellValueByColumnAndRow(12,$line,$row['nopember']/$per)
				->setCellValueByColumnAndRow(13,$line,$row['desember']/$per)
				->setCellValueByColumnAndRow(14,$line,$row['jumlah']/$per);
			$line++;
			
			$totaljanuari += $row['januari']/$per;
			$totalfebruari += $row['februari']/$per;
			$totalmaret += $row['maret']/$per;
			$totalapril += $row['april']/$per;
			$totalmei += $row['mei']/$per;
			$totaljuni += $row['juni']/$per;
			$totaljuli += $row['juli']/$per;
			$totalagustus += $row['agustus']/$per;
			$totalseptember += $row['september']/$per;
			$totaloktober += $row['oktober']/$per;
			$totalnopember += $row['nopember']/$per;
			$totaldesember += $row['desember']/$per;
			$totaljumlah += $row['jumlah']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari)
			->setCellValueByColumnAndRow(4,$line,$totalmaret)
			->setCellValueByColumnAndRow(5,$line,$totalapril)
			->setCellValueByColumnAndRow(6,$line,$totalmei)
			->setCellValueByColumnAndRow(7,$line,$totaljuni)
			->setCellValueByColumnAndRow(8,$line,$totaljuli)
			->setCellValueByColumnAndRow(9,$line,$totalagustus)
			->setCellValueByColumnAndRow(10,$line,$totalseptember)
			->setCellValueByColumnAndRow(11,$line,$totaloktober)
			->setCellValueByColumnAndRow(12,$line,$totalnopember)
			->setCellValueByColumnAndRow(13,$line,$totaldesember)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah);
		$line+=2;
		
			
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapReturPenjualanPerCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanpercustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
		$sql = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
				where zz.jumlah <> 0";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;
			
		foreach($dataReader as $row)
		{
			$i=$i+1;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row['fullname'])
				->setCellValueByColumnAndRow(2,$line,$row['januari']/$per)
				->setCellValueByColumnAndRow(3,$line,$row['februari']/$per)
				->setCellValueByColumnAndRow(4,$line,$row['maret']/$per)
				->setCellValueByColumnAndRow(5,$line,$row['april']/$per)
				->setCellValueByColumnAndRow(6,$line,$row['mei']/$per)
				->setCellValueByColumnAndRow(7,$line,$row['juni']/$per)
				->setCellValueByColumnAndRow(8,$line,$row['juli']/$per)
				->setCellValueByColumnAndRow(9,$line,$row['agustus']/$per)
				->setCellValueByColumnAndRow(10,$line,$row['september']/$per)
				->setCellValueByColumnAndRow(11,$line,$row['oktober']/$per)
				->setCellValueByColumnAndRow(12,$line,$row['nopember']/$per)
				->setCellValueByColumnAndRow(13,$line,$row['desember']/$per)
				->setCellValueByColumnAndRow(14,$line,$row['jumlah']/$per);
			$line++;
			
			$totaljanuari += $row['januari']/$per;
			$totalfebruari += $row['februari']/$per;
			$totalmaret += $row['maret']/$per;
			$totalapril += $row['april']/$per;
			$totalmei += $row['mei']/$per;
			$totaljuni += $row['juni']/$per;
			$totaljuli += $row['juli']/$per;
			$totalagustus += $row['agustus']/$per;
			$totalseptember += $row['september']/$per;
			$totaloktober += $row['oktober']/$per;
			$totalnopember += $row['nopember']/$per;
			$totaldesember += $row['desember']/$per;
			$totaljumlah += $row['jumlah']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari)
			->setCellValueByColumnAndRow(4,$line,$totalmaret)
			->setCellValueByColumnAndRow(5,$line,$totalapril)
			->setCellValueByColumnAndRow(6,$line,$totalmei)
			->setCellValueByColumnAndRow(7,$line,$totaljuni)
			->setCellValueByColumnAndRow(8,$line,$totaljuli)
			->setCellValueByColumnAndRow(9,$line,$totalagustus)
			->setCellValueByColumnAndRow(10,$line,$totalseptember)
			->setCellValueByColumnAndRow(11,$line,$totaloktober)
			->setCellValueByColumnAndRow(12,$line,$totalnopember)
			->setCellValueByColumnAndRow(13,$line,$totaldesember)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah);
		$line+=2;
		
			
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanReturPenjualanPerCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpenjualanpercustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
		$sql = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz
				where zz.jumlah <> 0";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;
			
		foreach($dataReader as $row)
		{
			$i=$i+1;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row['fullname'])
				->setCellValueByColumnAndRow(2,$line,$row['januari']/$per)
				->setCellValueByColumnAndRow(3,$line,$row['februari']/$per)
				->setCellValueByColumnAndRow(4,$line,$row['maret']/$per)
				->setCellValueByColumnAndRow(5,$line,$row['april']/$per)
				->setCellValueByColumnAndRow(6,$line,$row['mei']/$per)
				->setCellValueByColumnAndRow(7,$line,$row['juni']/$per)
				->setCellValueByColumnAndRow(8,$line,$row['juli']/$per)
				->setCellValueByColumnAndRow(9,$line,$row['agustus']/$per)
				->setCellValueByColumnAndRow(10,$line,$row['september']/$per)
				->setCellValueByColumnAndRow(11,$line,$row['oktober']/$per)
				->setCellValueByColumnAndRow(12,$line,$row['nopember']/$per)
				->setCellValueByColumnAndRow(13,$line,$row['desember']/$per)
				->setCellValueByColumnAndRow(14,$line,$row['jumlah']/$per);
			$line++;
			
			$totaljanuari += $row['januari']/$per;
			$totalfebruari += $row['februari']/$per;
			$totalmaret += $row['maret']/$per;
			$totalapril += $row['april']/$per;
			$totalmei += $row['mei']/$per;
			$totaljuni += $row['juni']/$per;
			$totaljuli += $row['juli']/$per;
			$totalagustus += $row['agustus']/$per;
			$totalseptember += $row['september']/$per;
			$totaloktober += $row['oktober']/$per;
			$totalnopember += $row['nopember']/$per;
			$totaldesember += $row['desember']/$per;
			$totaljumlah += $row['jumlah']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari)
			->setCellValueByColumnAndRow(4,$line,$totalmaret)
			->setCellValueByColumnAndRow(5,$line,$totalapril)
			->setCellValueByColumnAndRow(6,$line,$totalmei)
			->setCellValueByColumnAndRow(7,$line,$totaljuni)
			->setCellValueByColumnAndRow(8,$line,$totaljuli)
			->setCellValueByColumnAndRow(9,$line,$totalagustus)
			->setCellValueByColumnAndRow(10,$line,$totalseptember)
			->setCellValueByColumnAndRow(11,$line,$totaloktober)
			->setCellValueByColumnAndRow(12,$line,$totalnopember)
			->setCellValueByColumnAndRow(13,$line,$totaldesember)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah);
		$line+=2;
		
			
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'JENIS CUSTOMER')
				->setCellValueByColumnAndRow(2,$line,': '.$row['jenis']);
			$line++;
			$sql1 = "select * from
					(select z.fullname,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
					from addressbook z
					where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
					and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
					where zz.jumlah <> 0"; 
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No.')
				->setCellValueByColumnAndRow(1,$line,'Customer')
				->setCellValueByColumnAndRow(2,$line,'Januari')
				->setCellValueByColumnAndRow(3,$line,'Februari')
				->setCellValueByColumnAndRow(4,$line,'Maret')
				->setCellValueByColumnAndRow(5,$line,'April')
				->setCellValueByColumnAndRow(6,$line,'Mei')
				->setCellValueByColumnAndRow(7,$line,'Juni')
				->setCellValueByColumnAndRow(8,$line,'Juli')
				->setCellValueByColumnAndRow(9,$line,'Agustus')
				->setCellValueByColumnAndRow(10,$line,'September')
				->setCellValueByColumnAndRow(11,$line,'Oktober')
				->setCellValueByColumnAndRow(12,$line,'Nopember')
				->setCellValueByColumnAndRow(13,$line,'Desember')
				->setCellValueByColumnAndRow(14,$line,'Total');
				$line++;
			
			foreach($dataReader1 as $row1)
			{
				$i=$i+1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['fullname'])
					->setCellValueByColumnAndRow(2,$line,$row1['januari']/$per)
					->setCellValueByColumnAndRow(3,$line,$row1['februari']/$per)
					->setCellValueByColumnAndRow(4,$line,$row1['maret']/$per)
					->setCellValueByColumnAndRow(5,$line,$row1['april']/$per)
					->setCellValueByColumnAndRow(6,$line,$row1['mei']/$per)
					->setCellValueByColumnAndRow(7,$line,$row1['juni']/$per)
					->setCellValueByColumnAndRow(8,$line,$row1['juli']/$per)
					->setCellValueByColumnAndRow(9,$line,$row1['agustus']/$per)
					->setCellValueByColumnAndRow(10,$line,$row1['september']/$per)
					->setCellValueByColumnAndRow(11,$line,$row1['oktober']/$per)
					->setCellValueByColumnAndRow(12,$line,$row1['nopember']/$per)
					->setCellValueByColumnAndRow(13,$line,$row1['desember']/$per)
					->setCellValueByColumnAndRow(14,$line,$row1['jumlah']/$per);
				$line++;
				
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'TOTAL '.$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line+=2;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekapreturpenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'JENIS CUSTOMER')
				->setCellValueByColumnAndRow(2,$line,': '.$row['jenis']);
			$line++;
			$sql1 = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
			
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No.')
				->setCellValueByColumnAndRow(1,$line,'Customer')
				->setCellValueByColumnAndRow(2,$line,'Januari')
				->setCellValueByColumnAndRow(3,$line,'Februari')
				->setCellValueByColumnAndRow(4,$line,'Maret')
				->setCellValueByColumnAndRow(5,$line,'April')
				->setCellValueByColumnAndRow(6,$line,'Mei')
				->setCellValueByColumnAndRow(7,$line,'Juni')
				->setCellValueByColumnAndRow(8,$line,'Juli')
				->setCellValueByColumnAndRow(9,$line,'Agustus')
				->setCellValueByColumnAndRow(10,$line,'September')
				->setCellValueByColumnAndRow(11,$line,'Oktober')
				->setCellValueByColumnAndRow(12,$line,'Nopember')
				->setCellValueByColumnAndRow(13,$line,'Desember')
				->setCellValueByColumnAndRow(14,$line,'Total');
				$line++;
			
			foreach($dataReader1 as $row1)
			{
				$i=$i+1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['fullname'])
					->setCellValueByColumnAndRow(2,$line,$row1['januari']/$per)
					->setCellValueByColumnAndRow(3,$line,$row1['februari']/$per)
					->setCellValueByColumnAndRow(4,$line,$row1['maret']/$per)
					->setCellValueByColumnAndRow(5,$line,$row1['april']/$per)
					->setCellValueByColumnAndRow(6,$line,$row1['mei']/$per)
					->setCellValueByColumnAndRow(7,$line,$row1['juni']/$per)
					->setCellValueByColumnAndRow(8,$line,$row1['juli']/$per)
					->setCellValueByColumnAndRow(9,$line,$row1['agustus']/$per)
					->setCellValueByColumnAndRow(10,$line,$row1['september']/$per)
					->setCellValueByColumnAndRow(11,$line,$row1['oktober']/$per)
					->setCellValueByColumnAndRow(12,$line,$row1['nopember']/$per)
					->setCellValueByColumnAndRow(13,$line,$row1['desember']/$per)
					->setCellValueByColumnAndRow(14,$line,$row1['jumlah']/$per);
				$line++;
				
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'TOTAL '.$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line+=2;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}
public function RekapPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanreturpenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'JENIS CUSTOMER')
				->setCellValueByColumnAndRow(2,$line,': '.$row['jenis']);
			$line++;
			$sql1 = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
		
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No.')
				->setCellValueByColumnAndRow(1,$line,'Customer')
				->setCellValueByColumnAndRow(2,$line,'Januari')
				->setCellValueByColumnAndRow(3,$line,'Februari')
				->setCellValueByColumnAndRow(4,$line,'Maret')
				->setCellValueByColumnAndRow(5,$line,'April')
				->setCellValueByColumnAndRow(6,$line,'Mei')
				->setCellValueByColumnAndRow(7,$line,'Juni')
				->setCellValueByColumnAndRow(8,$line,'Juli')
				->setCellValueByColumnAndRow(9,$line,'Agustus')
				->setCellValueByColumnAndRow(10,$line,'September')
				->setCellValueByColumnAndRow(11,$line,'Oktober')
				->setCellValueByColumnAndRow(12,$line,'Nopember')
				->setCellValueByColumnAndRow(13,$line,'Desember')
				->setCellValueByColumnAndRow(14,$line,'Total');
				$line++;
			
			foreach($dataReader1 as $row1)
			{
				$i=$i+1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['fullname'])
					->setCellValueByColumnAndRow(2,$line,$row1['januari']/$per)
					->setCellValueByColumnAndRow(3,$line,$row1['februari']/$per)
					->setCellValueByColumnAndRow(4,$line,$row1['maret']/$per)
					->setCellValueByColumnAndRow(5,$line,$row1['april']/$per)
					->setCellValueByColumnAndRow(6,$line,$row1['mei']/$per)
					->setCellValueByColumnAndRow(7,$line,$row1['juni']/$per)
					->setCellValueByColumnAndRow(8,$line,$row1['juli']/$per)
					->setCellValueByColumnAndRow(9,$line,$row1['agustus']/$per)
					->setCellValueByColumnAndRow(10,$line,$row1['september']/$per)
					->setCellValueByColumnAndRow(11,$line,$row1['oktober']/$per)
					->setCellValueByColumnAndRow(12,$line,$row1['nopember']/$per)
					->setCellValueByColumnAndRow(13,$line,$row1['desember']/$per)
					->setCellValueByColumnAndRow(14,$line,$row1['jumlah']/$per);
				$line++;
				
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'TOTAL '.$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line+=2;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapTotalPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekaptotalpenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;		
		
		foreach($dataReader as $row)
		{
			$sql1 = "select * from
					(select z.fullname,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
					(select ifnull(sum(ifnull(a.amount,0)),0)
					from invoice a 
					join giheader aa on aa.giheaderid=a.giheaderid
					join soheader aaa on aaa.soheaderid=aa.soheaderid
					where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
					from addressbook z
					where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
					and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
					where zz.jumlah <> 0"; 
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
		
					
			foreach($dataReader1 as $row1)
			{
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line++;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapTotalReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekaptotalreturpenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;		
		
		foreach($dataReader as $row)
		{
			$sql1 = "select * from
				(select z.fullname,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as januari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as februari,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as maret,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as april,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as mei,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juni,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as juli,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as agustus,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as september,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as oktober,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as nopember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as desember,
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
					
			foreach($dataReader1 as $row1)
			{
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line++;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}
	public function RekapTotalPenjualanReturPenjualanPerJenisCustomerPerBulanPerTahunXLS($companyid,$sloc,$customer,$employee,$product,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekaptotalpenjualanreturpenjualanperjeniscustomerperbulanpertahun';
		parent::actionDownxls();
		$i=0;$totaljanuari1=0;$totalfebruari1=0;$totalmaret1=0;$totalapril1=0;$totalmei1=0;$totaljuni1=0;$totaljuli1=0;$totalagustus1=0;$totalseptember1=0;$totaloktober1=0;$totalnopember1=0;$totaldesember1=0;$totaljumlah1=0;
		$sql = "select distinct b.accountid,replace(b.accountname,'PIUTANG DAGANG ','') as jenis
					from addressbook a
					join account b on b.accountid=a.accpiutangid";
					
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'No.')
			->setCellValueByColumnAndRow(1,$line,'Customer')
			->setCellValueByColumnAndRow(2,$line,'Januari')
			->setCellValueByColumnAndRow(3,$line,'Februari')
			->setCellValueByColumnAndRow(4,$line,'Maret')
			->setCellValueByColumnAndRow(5,$line,'April')
			->setCellValueByColumnAndRow(6,$line,'Mei')
			->setCellValueByColumnAndRow(7,$line,'Juni')
			->setCellValueByColumnAndRow(8,$line,'Juli')
			->setCellValueByColumnAndRow(9,$line,'Agustus')
			->setCellValueByColumnAndRow(10,$line,'September')
			->setCellValueByColumnAndRow(11,$line,'Oktober')
			->setCellValueByColumnAndRow(12,$line,'Nopember')
			->setCellValueByColumnAndRow(13,$line,'Desember')
			->setCellValueByColumnAndRow(14,$line,'Total');
		$line++;		
		
		foreach($dataReader as $row)
		{
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			$sql1 = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=1 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=1 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as januari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=2 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=2 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as februari,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=3 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=3 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as maret,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=4 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=4 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as april,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=5 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=5 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as mei,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=6 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=6 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juni,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=7 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=7 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as juli,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=8 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=8 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as agustus,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=9 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=9 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as september,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=10 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=10 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as oktober,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=11 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=11 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as nopember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and month(aa.gidate)=12 and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and month(d.gidate)=12 and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as desember,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and year(aa.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and year(d.gidate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as jumlah
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null 
				and z.accpiutangid = ".$row['accountid']." order by fullname asc) zz
				where zz.jumlah <> 0"; 
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
					
			foreach($dataReader1 as $row1)
			{
				$totaljanuari += $row1['januari']/$per;
				$totalfebruari += $row1['februari']/$per;
				$totalmaret += $row1['maret']/$per;
				$totalapril += $row1['april']/$per;
				$totalmei += $row1['mei']/$per;
				$totaljuni += $row1['juni']/$per;
				$totaljuli += $row1['juli']/$per;
				$totalagustus += $row1['agustus']/$per;
				$totalseptember += $row1['september']/$per;
				$totaloktober += $row1['oktober']/$per;
				$totalnopember += $row1['nopember']/$per;
				$totaldesember += $row1['desember']/$per;
				$totaljumlah += $row1['jumlah']/$per;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$row['jenis'])
				->setCellValueByColumnAndRow(1,$line,'')
				->setCellValueByColumnAndRow(2,$line,$totaljanuari)
				->setCellValueByColumnAndRow(3,$line,$totalfebruari)
				->setCellValueByColumnAndRow(4,$line,$totalmaret)
				->setCellValueByColumnAndRow(5,$line,$totalapril)
				->setCellValueByColumnAndRow(6,$line,$totalmei)
				->setCellValueByColumnAndRow(7,$line,$totaljuni)
				->setCellValueByColumnAndRow(8,$line,$totaljuli)
				->setCellValueByColumnAndRow(9,$line,$totalagustus)
				->setCellValueByColumnAndRow(10,$line,$totalseptember)
				->setCellValueByColumnAndRow(11,$line,$totaloktober)
				->setCellValueByColumnAndRow(12,$line,$totalnopember)
				->setCellValueByColumnAndRow(13,$line,$totaldesember)
				->setCellValueByColumnAndRow(14,$line,$totaljumlah);
			$line++;
			
			$totaljanuari1 += $totaljanuari;
			$totalfebruari1 += $totalfebruari;
			$totalmaret1 += $totalmaret;
			$totalapril1 += $totalapril;
			$totalmei1 += $totalmei;
			$totaljuni1 += $totaljuni;
			$totaljuli1 += $totaljuli;
			$totalagustus1 += $totalagustus;
			$totalseptember1 += $totalseptember;
			$totaloktober1 += $totaloktober;
			$totalnopember1 += $totalnopember;
			$totaldesember1 += $totaldesember;
			$totaljumlah1 += $totaljumlah;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(1,$line,'')
			->setCellValueByColumnAndRow(2,$line,$totaljanuari1)
			->setCellValueByColumnAndRow(3,$line,$totalfebruari1)
			->setCellValueByColumnAndRow(4,$line,$totalmaret1)
			->setCellValueByColumnAndRow(5,$line,$totalapril1)
			->setCellValueByColumnAndRow(6,$line,$totalmei1)
			->setCellValueByColumnAndRow(7,$line,$totaljuni1)
			->setCellValueByColumnAndRow(8,$line,$totaljuli1)
			->setCellValueByColumnAndRow(9,$line,$totalagustus1)
			->setCellValueByColumnAndRow(10,$line,$totalseptember1)
			->setCellValueByColumnAndRow(11,$line,$totaloktober1)
			->setCellValueByColumnAndRow(12,$line,$totalnopember1)
			->setCellValueByColumnAndRow(13,$line,$totaldesember1)
			->setCellValueByColumnAndRow(14,$line,$totaljumlah1);
		
		$this->getFooterXLS($this->phpExcel);
	}

}

