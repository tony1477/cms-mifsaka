<?php

class RepaccrecController extends AdminController
{
	protected $menuname = 'repaccrec';		
	public $module = 'accounting';
	protected $pageTitle = 'Report AR';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['materialgroup']) && isset($_GET['salesarea']) && isset($_GET['umurpiutang']) && isset($_GET['customer']) && isset($_GET['product']) && isset($_GET['sales']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 99)
			{
				$this->RincianFakturdanReturJualBelumLunasGabungan($_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 1)
			{
				$this->RincianPelunasanPiutangPerDokumen($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 2)
			{
				$this->RekapPelunasanPiutangPerDivisi($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 3)
			{
				$this->KartuPiutangDagang($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 4)
			{
				$this->RekapPiutangDagangPerCustomer($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 5)
			{
				$this->RincianFakturdanReturJualBelumLunas($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RincianUmurPiutangDagangPerCustomer($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RekapUmurPiutangDagangPerCustomer($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RincianFakturdanReturJualBelumLunasPerSales($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RekapKontrolPiutangCustomervsPlafon($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RincianKontrolPiutangCustomervsPlafon($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->KonfirmasiPiutangDagang($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
				$this->RekapInvoiceARPerDokumenBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 13)
			{
				$this->RekapNotaReturPenjualanPerBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 14)
			{
				$this->RekapPelunasanPiutangPerDokumenBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 15)
			{
				$this->RincianPelunasanPiutangPerSales($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 16)
			{
				$this->RekapPelunasanPiutangPerSales($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 17)
			{
				$this->RincianPelunasanPiutangPerSalesPerJenisBarang($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 18)
			{
				$this->RekapPelunasanPiutangPerSalesPerJenisBarang($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 19)
			{
				$this->RekapPenjualanVSPelunasanPerBulanPerCustomer($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
      else
			if ($_GET['lro'] == 20)
			{
				$this->RekapPiutangVSPelunasanPerBulanPerCustomer($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
            else
			if ($_GET['lro'] == 'test')
			{
				$this->test($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	//99
	public function RincianFakturdanReturJualBelumLunasGabungan($sloc,$materialgroup,$customer,$product,$sales,$umurpiutang,$startdate,$enddate,$per)
  {
     parent::actionDownPDF();
			$nilaitot1 = 0;$dibayar1 = 0;$sisa1 = 0;
     $sql = "select distinct addressbookid,fullname
					from (select d.addressbookid,d.fullname,a.amount,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid

					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					";
					if ($_GET['umurpiutang'] !== '') 
					{
							$sql = $sql . "and  umur > ".$_GET['umurpiutang']." order by fullname";
					}
					else 
					{
							$sql = $sql . "order by fullname";
					}
       $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
						
            $this->pdf->title='Rincian Faktur & Retur Jual Belum Lunas Gabungan';
            $this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');

            $this->pdf->sety($this->pdf->gety()+0);
           
            foreach($dataReader as $row)
            {                
				$this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
                $sql1 = " select *, (amount-payamount) as sisa,(amount) as nilai
												from (select a.invoiceno,a.invoicedate,e.paydays,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,ff.fullname as sales,
												ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,c.companyid
												from invoice a
												inner join giheader b on b.giheaderid = a.giheaderid
												inner join soheader c on c.soheaderid = b.soheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												inner join employee ff on ff.employeeid = c.employeeid

												where d.fullname like '%".$customer."%' and ff.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null
												and d.addressbookid = '".$row['addressbookid']."'						
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where amount > payamount
												";
												if ($_GET['umurpiutang'] !== '') 
												{
														$sql1 = $sql1 . "and  umur > ".$_GET['umurpiutang']." order by umurtempo asc,invoiceno";
												}
												else 
												{
														$sql1 = $sql1 . "order by umurtempo asc,invoiceno";
												}
						
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                //$piutang =0;
                //$dibayar=0;
                //$saldo=0;
                
                $this->pdf->sety($this->pdf->gety()+7);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,22,20,20,13,13,25,22,25,25));
                $this->pdf->colheader = array('No','Dokumen','Tanggal','j_tempo','Umur','UT','Nilai','Kum_bayar','Sisa','Sales');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('C','C','C','C','C','C','R','R','R','L');
                $this->pdf->setFont('Arial','',8);
             $i=0;
			 $nilaitot = 0;
                        $dibayar = 0;
                        $sisa = 0;
                foreach($dataReader1 as $row1)
                {
				$i+=1;
                    $this->pdf->row(array(
                                $i,$row1['invoiceno'].'-'.$row1['companyid'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
					$row1['umur'],
					$row1['umurtempo'],
					Yii::app()->format->formatCurrency($row1['nilai']/$per),
					Yii::app()->format->formatCurrency($row1['payamount']/$per),
					Yii::app()->format->formatCurrency(($row1['nilai']-$row1['payamount'])/$per),
					$row1['sales'],
                        ));
                        $nilaitot += $row1['nilai']/$per;
                        $dibayar += $row1['payamount']/$per;
                        $sisa += ($row1['nilai']-$row1['payamount'])/$per;
						
                $this->pdf->checkPageBreak(20);
                }
						$this->pdf->setFont('Arial','B',8);
                        $this->pdf->row(array(
                        '','','','Total:','','',
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
	//1
	public function RincianPelunasanPiutangPerDokumen($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
	  parent::actionDownPDF();
		$totalall = 0;$totalall1 = 0;$totalall2 = 0;$totalall3 = 0;$totalall4 = 0;$totalall5 = 0;$totalall6 = 0;$totalall7 = 0;
		$sql = "select distinct a.cutarid,a.cutarno,a.docdate as cutardate,c.docno as ttntno,c.docdate as ttntdate,b.companyid
						from cutar a
						join company b on b.companyid = a.companyid
						join ttnt c on c.ttntid = a.ttntid
						join cutarinv d on d.cutarid = a.cutarid
						join invoice e on e.invoiceid = d.invoiceid
						join giheader f on f.giheaderid = e.giheaderid
						join soheader g on g.soheaderid = f.soheaderid						
						left join employee h on h.employeeid = g.employeeid
						join addressbook i on i.addressbookid = g.addressbookid
						where i.fullname like '%".$customer."%' and h.fullname like '%".$sales."%' and a.cutarno is not null and a.companyid = ".$companyid." and 
						a.recordstatus=3 and
						a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Rincian Pelunasan Piutang Per Dokumen';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		// definisi font
                
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cutarno']);
			$this->pdf->text(160,$this->pdf->gety()+2,'TTNT ');$this->pdf->text(170,$this->pdf->gety()+2,': '.$row['ttntno']);
			$this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cutardate'])));
			$this->pdf->text(160,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(170,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));
			$sql1 = "select*,(saldo-(tunai+bank+diskon+retur+ob)) as sisa
						from(select f.fullname,c.invoiceno,c.invoicedate,sum(saldoinvoice)as saldo,sum(cashamount) as tunai,sum(a.bankamount) as bank,sum(a.discamount) as diskon,sum(a.returnamount) as retur,sum(a.obamount) as ob,
						sum(cashamount)+sum(a.bankamount)+sum(a.discamount)+sum(a.returnamount)+sum(a.obamount) as jumlah
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid = a.invoiceid
						join giheader d on d.giheaderid = c.giheaderid
						join soheader e on e.soheaderid= d.soheaderid
						join addressbook f on f.addressbookid = e.addressbookid						
						left join employee g on g.employeeid = e.employeeid
						where f.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3 and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						and a.cutarid = ".$row['cutarid']."
						group by invoiceno)z
						";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
									
			$total = 0;$totalqty=0;
			$total1 = 0;$totalqty1=0;
			$total2 = 0;$totalqty2=0;
			$total3 = 0;$totalqty3=0;
			$total4 = 0;$totalqty4=0;
			$total5 = 0;$totalqty5=0;
			$total6 = 0;$totalqty6=0;
			$total7 = 0;$totalqty7=0;
			$this->pdf->setFont('Arial','',8);
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
				$this->pdf->row(array($i,$row1['invoiceno'],
				$row1['fullname'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
				Yii::app()->format->formatCurrency($row1['saldo']/$per),						
				Yii::app()->format->formatCurrency($row1['tunai']/$per),
				Yii::app()->format->formatCurrency($row1['bank']/$per),
				Yii::app()->format->formatCurrency($row1['diskon']/$per),
				Yii::app()->format->formatCurrency($row1['retur']/$per),
				Yii::app()->format->formatCurrency($row1['ob']/$per),                        
				Yii::app()->format->formatCurrency($row1['jumlah']/$per),
				Yii::app()->format->formatCurrency($row1['sisa']/$per),
				));
						
				$total += ($row1['saldo']/$per);
				$total1 += ($row1['tunai']/$per);
				$total2 += ($row1['bank']/$per);
				$total3 += ($row1['diskon']/$per);
				$total4 += ($row1['retur']/$per);
				$total5 += ($row1['ob']/$per);
				$total6 += ($row1['jumlah']/$per);
				$total7 += ($row1['sisa']/$per);
			}
					
			$this->pdf->setFont('Arial','BI',8);
			$this->pdf->row(array('','TOTAL ',$row['cutarno'],'',
			Yii::app()->format->formatCurrency($total),					
			Yii::app()->format->formatCurrency($total1),
			Yii::app()->format->formatCurrency($total2),
			Yii::app()->format->formatCurrency($total3),
			Yii::app()->format->formatCurrency($total4),
			Yii::app()->format->formatCurrency($total5),
			Yii::app()->format->formatCurrency($total6),
			Yii::app()->format->formatCurrency($total7)));
			
			$totalall += $total;
			$totalall1 += $total1;
			$totalall2 += $total2;
			$totalall3 += $total3;
			$totalall4 += $total4;
			$totalall5 += $total5;
			$totalall6 += $total6;
			$totalall7 += $total7;
			
			$this->pdf->sety($this->pdf->gety()+10);
		}
		
		$this->pdf->setFont('Arial','BI',8);
		$this->pdf->row(array('','','GRAND TOTAL','',
			Yii::app()->format->formatCurrency($totalall),					
			Yii::app()->format->formatCurrency($totalall1),
			Yii::app()->format->formatCurrency($totalall2),
			Yii::app()->format->formatCurrency($totalall3),
			Yii::app()->format->formatCurrency($totalall4),
			Yii::app()->format->formatCurrency($totalall5),
			Yii::app()->format->formatCurrency($totalall6),
			Yii::app()->format->formatCurrency($totalall7)));
		$this->pdf->Output();
	}
	//2
	public function RekapPelunasanPiutangPerDivisi($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql ="select distinct a.cutarid, sum(cashamount) as tunai,sum(a.bankamount) as bank,sum(a.discamount) as diskon,sum(a.returnamount) as retur,sum(a.obamount) as ob,
				sum(cashamount)+sum(a.bankamount)+sum(a.discamount)+sum(a.returnamount)+sum(a.obamount) as jumlah,
				(select xx.description from materialgroup xx 
				join productplant zz on zz.materialgroupid = xx.materialgroupid
				join sodetail yy on yy.productid = zz.productid
				where yy.soheaderid = e.soheaderid limit 1
				) as materialgroupname
				from cutarinv a
				join cutar b on b.cutarid=a.cutarid
				join invoice c on c.invoiceid=a.invoiceid
				join giheader d on d.giheaderid = c.giheaderid
				join soheader e on e.soheaderid = d.soheaderid 
				join employee f on f.employeeid = e.employeeid
				join addressbook g on g.addressbookid = e.addressbookid
				where b.companyid = ".$companyid." and g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
				and b.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				group by materialgroupname";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Pelunasan Piutang Per Divisi';
		$this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');
		$this->pdf->setFont('Arial','B',9);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','R');
		$this->pdf->setwidths(array(10,50,38,38,38,30,35,38));
		$this->pdf->colheader = array('No','Devisi/Jenis','Tunai','Bank','Discont','Retur','PDMK/OB','Jumlah');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','C','R','R');		
		$i=0;$cash=0;$bank=0;$obamount=0;$jumlah=0;$retur=0;$diskon=0;$total=0;
		
		foreach($dataReader as $row)
		{
			
			$i+=1;
			$this->pdf->setFont('Arial','',9);
			$this->pdf->row(array(
			$i,$row['materialgroupname'],
			Yii::app()->format->formatCurrency($row['tunai']/$per),
			Yii::app()->format->formatCurrency($row['bank']/$per),
			Yii::app()->format->formatCurrency($row['diskon']/$per),
			Yii::app()->format->formatCurrency($row['retur']/$per),
			Yii::app()->format->formatCurrency($row['ob']/$per),
			Yii::app()->format->formatCurrency($row['jumlah']/$per),
			));

			$cash += $row['tunai']/$per;
			$bank += $row['bank']/$per;
			$diskon += $row['diskon']/$per;
			$retur += $row['retur']/$per;
			$obamount += $row['ob']/$per;
			$total += $row['jumlah']/$per;			
		}
		$this->pdf->setFont('Arial','BI',10);
		$this->pdf->row(array(
		'','GRAND TOTAL',
		Yii::app()->format->formatCurrency($cash),
		Yii::app()->format->formatCurrency($bank),
		Yii::app()->format->formatCurrency($diskon),
		Yii::app()->format->formatCurrency($retur),
		Yii::app()->format->formatCurrency($obamount),
		Yii::app()->format->formatCurrency($total),
		));
		$this->pdf->Output();
	}
	//3
	public function KartuPiutangDagang($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
  {
    parent::actionDownPDF();
		$penambahan1=0;$tunai1=0;$bank1=0;$diskon1=0;$retur1=0;$ob1=0;$saldo1=0;
    $sql = "select *
						from (select a.fullname,a.addressbookid,
						ifnull((select sum(ifnull(b.amount,0)-ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '".$customer."' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."	and b.invoicedate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and f.addressbookid=a.addressbookid),0) as saldo,
						ifnull((select sum(ifnull(h.amount,0))
						from invoice h
						join giheader i on i.giheaderid=h.giheaderid
						join soheader j on j.soheaderid=i.soheaderid
						join employee k on k.employeeid = j.employeeid
						join addressbook l on l.addressbookid = j.addressbookid
						where l.fullname like '%".$customer."%' and k.fullname like '%".$sales."%' and h.recordstatus=3
						and j.companyid=".$companyid." and j.addressbookid=a.addressbookid
						and h.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as piutang,
						ifnull((select sum(ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."
						and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and f.addressbookid=a.addressbookid),0) as dibayar
						from addressbook a
						where a.fullname like '%".$customer."%') z
						where z.saldo<>0 or z.piutang<>0 or z.dibayar<>0
						order by fullname";
				
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Kartu Piutang Dagang';
		$this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');

		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+3,$row['fullname']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(22,20,20,30,30,30,30,30,30,30));
			$this->pdf->colheader = array('Dokumen','Tanggal','U/ Byr INV','Penambahan','Tunai','Bank','Diskon','Retur','OB','Saldo');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','R','R','R','R','R','R','R');
			
			
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->row(array(
				'Saldo Awal','','','','','','','','',
				Yii::app()->format->formatCurrency($row['saldo']/$per),
			));
			
			$penambahan=0;$tunai=0;$bank=0;$diskon=0;$retur=0;$ob=0;
			$sql2 = "select * from
				(select distinct a.invoiceno as dokumen,a.invoicedate as tanggal,'-' as ref,a.amount as penambahan,'0' as tunai,'0' as bank,'0' as diskon,'0' as retur,'0' as ob
				from invoice a
				left join giheader b on b.giheaderid = a.giheaderid
				left join soheader c on c.soheaderid = b.soheaderid
				left join cbarinv d on d.invoiceid = a.invoiceid
				join employee e on e.employeeid = c.employeeid
				join addressbook f on f.addressbookid = c.addressbookid
				where f.fullname like '%".$customer."%' and c.companyid = ".$companyid." and a.recordstatus = 3 and a.invoiceno is not null and
				c.addressbookid = ".$row['addressbookid']." and
				a.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
				select d.cutarno as dokumen,d.docdate as tanggal,g.invoiceno as ref,'0' as penambahan,ifnull(c.cashamount,0) as tunai,ifnull(c.bankamount,0) as bank,ifnull(c.discamount,0) as diskon,
				ifnull(c.returnamount,0) as retur,ifnull(c.obamount,0) as ob
				from cutarinv c
				join cutar d on d.cutarid=c.cutarid
				join invoice g on g.invoiceid=c.invoiceid
				left join giheader h on h.giheaderid = g.giheaderid
				left join soheader i on i.soheaderid = h.soheaderid
				join addressbook j on j.addressbookid = i.addressbookid
				join employee k on k.employeeid = i.employeeid
				where d.recordstatus=3
				and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and c.invoiceid in (select b.invoiceid
				from invoice b
				join giheader e on e.giheaderid=b.giheaderid
				join soheader f on f.soheaderid=e.soheaderid
				join employee g on g.employeeid = f.employeeid
				join addressbook h on h.addressbookid = f.addressbookid
				where h.fullname like '".$customer."' and g.fullname like '%".$sales."%' and b.recordstatus=3
				and f.companyid=".$companyid." and f.addressbookid = ".$row['addressbookid']."
				and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
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
					Yii::app()->format->formatCurrency(-$row2['tunai']/$per),
					Yii::app()->format->formatCurrency(-$row2['bank']/$per),
					Yii::app()->format->formatCurrency(-$row2['diskon']/$per),
					Yii::app()->format->formatCurrency(-$row2['retur']/$per),
					Yii::app()->format->formatCurrency(-$row2['ob']/$per),
					'',
				));
				$penambahan += $row2['penambahan']/$per;
				$tunai += $row2['tunai']/$per;
				$bank += $row2['bank']/$per;
				$diskon += $row2['diskon']/$per;
				$retur += $row2['retur']/$per;
				$ob += $row2['ob']/$per;
			}
			$this->pdf->SetFont('Arial','B',8);
			$this->pdf->setwidths(array(62,30,30,30,30,30,30,30));
			$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R');				
			$this->pdf->row(array(
				'TOTAL '.$row['fullname'],
				Yii::app()->format->formatCurrency($penambahan),
				Yii::app()->format->formatCurrency(-$tunai),
				Yii::app()->format->formatCurrency(-$bank),
				Yii::app()->format->formatCurrency(-$diskon),
				Yii::app()->format->formatCurrency(-$retur),
				Yii::app()->format->formatCurrency(-$ob),
				Yii::app()->format->formatCurrency($row['saldo']/$per+$penambahan-$tunai-$bank-$diskon-$retur-$ob),
			));		
			$penambahan1 += $penambahan;
			$tunai1 += $tunai;
			$bank1 += $bank;
			$diskon1 += $diskon;
			$retur1 += $retur;
			$ob1 += $ob;
			$saldo1 += $row['saldo']/$per;
			
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(5);
		}
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->setwidths(array(30,30,30,30,30,30,30,30,30));
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');				
		$this->pdf->row(array(
			'',
			'',
			'Penambahan',
			'Tunai',
			'Bank',
			'Diskon',
			'Retur',
			'OB',
			'Saldo',
		));
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->setwidths(array(30,30,30,30,30,30,30,30,30));
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');				
		$this->pdf->row(array(
			'GRAND TOTAL',
			Yii::app()->format->formatCurrency($saldo1),
			Yii::app()->format->formatCurrency($penambahan1),
			Yii::app()->format->formatCurrency(-$tunai1),
			Yii::app()->format->formatCurrency(-$bank1),
			Yii::app()->format->formatCurrency(-$diskon1),
			Yii::app()->format->formatCurrency(-$retur1),
			Yii::app()->format->formatCurrency(-$ob1),
			Yii::app()->format->formatCurrency($saldo1+$penambahan1-$tunai1-$bank1-$diskon1-$retur1-$ob1),
		));
		
		$this->pdf->Output();
	}
  //4
  public function RekapPiutangDagangPerCustomer($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = 	"select *
						from (select a.fullname,
						ifnull((select sum(ifnull(b.amount,0)-ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						join invoice e on e.invoiceid = c.invoiceid
						join giheader f on f.giheaderid = e.giheaderid
						join soheader g on g.soheaderid = f.soheaderid
						join employee h on h.employeeid = g.employeeid
						join addressbook i on i.addressbookid = g.addressbookid
						where i.fullname like '%".$customer."%' and h.fullname like '%".$sales."%' and d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."	and b.invoicedate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and f.addressbookid=a.addressbookid),0) as saldoawal,
						ifnull((select sum(ifnull(h.amount,0))
						from invoice h
						join giheader i on i.giheaderid=h.giheaderid
						join soheader j on j.soheaderid=i.soheaderid
						join employee k on k.employeeid = j.employeeid
						join addressbook l on l.addressbookid = j.addressbookid					
						where l.fullname like '%".$customer."%' and k.fullname like '%".$sales."%' and h.recordstatus=3
						and j.companyid=".$companyid." and j.addressbookid=a.addressbookid
						and h.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as piutang,
						ifnull((select sum(ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."
						and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and f.addressbookid=a.addressbookid),0) as dibayar
						from addressbook a
						where a.fullname like '%".$customer."%') z
						where z.saldoawal<>0 or z.piutang<>0 or z.dibayar<>0
						order by fullname";


		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Piutang Dagang Per Customer';
		$this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,50,30,30,30,40));
		$this->pdf->colheader = array('No','Customer','Saldo Awal','Piutang','Dibayar','Saldo Akhir');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','R','R','R','R');		
		$i=0;$saldoawal=0;$piutang=0;$dibayar=0;$saldoakhir=0;
		
		foreach($dataReader as $row)
		{
			
			$i+=1;
			$this->pdf->setFont('Arial','',7);
			$this->pdf->row(array(
			$i,$row['fullname'],
			Yii::app()->format->formatCurrency($row['saldoawal']/$per),
			Yii::app()->format->formatCurrency($row['piutang']/$per),
			Yii::app()->format->formatCurrency($row['dibayar']/$per),
			Yii::app()->format->formatCurrency(($row['saldoawal'] + $row['piutang'] - $row['dibayar'])/$per),
			));

			$saldoawal += $row['saldoawal']/$per;
			$piutang += $row['piutang']/$per;
			$dibayar += $row['dibayar']/$per;
			$saldoakhir += ($row['saldoawal'] + $row['piutang'] - $row['dibayar'])/$per;			
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->row(array(
		'','TOTAL',
		Yii::app()->format->formatCurrency($saldoawal),
		Yii::app()->format->formatCurrency($piutang),
		Yii::app()->format->formatCurrency($dibayar),
		Yii::app()->format->formatCurrency($saldoakhir),
		));
		$this->pdf->Output();
	}
	//5
	public function RincianFakturdanReturJualBelumLunas($companyid,$sloc,$materialgroup,$customer,$product,$sales,$umurpiutang,$startdate,$enddate,$per)
  {
     parent::actionDownPDF();
			$nilaitot1 = 0;$dibayar1 = 0;$sisa1 = 0;
     $sql = "select distinct addressbookid,fullname,lat,lng
					from (select d.addressbookid,d.fullname,a.amount,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,(select round(h.lat,6) from address h where h.addressbookid=d.addressbookid Limit 1) as lat,(select round(h.lng,6) from address h where h.addressbookid=d.addressbookid Limit 1) as lng
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid

					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					";
					if ($_GET['umurpiutang'] !== '') 
					{
							$sql = $sql . "and  umur > ".$_GET['umurpiutang']." order by fullname";
					}
					else 
					{
							$sql = $sql . "order by fullname";
					}
       $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='Rincian Faktur & Retur Jual Belum Lunas';
            $this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');

            $this->pdf->sety($this->pdf->gety()+0);
           
            foreach($dataReader as $row)
            {                
				$this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
                $this->pdf->text(145,$this->pdf->gety()+5,'Koordinat:');
                $this->pdf->text(168,$this->pdf->gety()+5,$row['lat'].',');
                $this->pdf->text(185,$this->pdf->gety()+5,$row['lng']);
                $sql1 = " select *, (amount-payamount) as sisa,(amount) as nilai
												from (select a.invoiceno,a.invoicedate,e.paydays,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,ff.fullname as sales,
												ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
												from invoice a
												inner join giheader b on b.giheaderid = a.giheaderid
												inner join soheader c on c.soheaderid = b.soheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												inner join employee ff on ff.employeeid = c.employeeid

												where d.fullname like '%".$customer."%' and ff.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
												and d.addressbookid = '".$row['addressbookid']."'						
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where amount > payamount
												";
												if ($_GET['umurpiutang'] !== '') 
												{
														$sql1 = $sql1 . "and  umur > ".$_GET['umurpiutang']." order by umurtempo";
												}
												else 
												{
														$sql1 = $sql1 . "order by umurtempo";
												}
						
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                //$piutang =0;
                //$dibayar=0;
                //$saldo=0;
                
                $this->pdf->sety($this->pdf->gety()+7);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,20,20,20,13,13,25,25,25,25));
                $this->pdf->colheader = array('No','Dokumen','Tanggal','j_tempo','Umur','UT','Nilai','Kum_bayar','Sisa','Sales');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('C','C','C','C','C','C','R','R','R','L');
                $this->pdf->setFont('Arial','',8);
             $i=0;
			 $nilaitot = 0;
                        $dibayar = 0;
                        $sisa = 0;
                foreach($dataReader1 as $row1)
                {
				$i+=1;
                    $this->pdf->row(array(
                                $i,$row1['invoiceno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
					$row1['umur'],
					$row1['umurtempo'],
					Yii::app()->format->formatCurrency($row1['nilai']/$per),
					Yii::app()->format->formatCurrency($row1['payamount']/$per),
					Yii::app()->format->formatCurrency(($row1['nilai']-$row1['payamount'])/$per),
					$row1['sales'],
                        ));
                        $nilaitot += $row1['nilai']/$per;
                        $dibayar += $row1['payamount']/$per;
                        $sisa += ($row1['nilai']-$row1['payamount'])/$per;
						
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
	//6
	public function RincianUmurPiutangDagangPerCustomer($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
  {
            parent::actionDownPDF();
						$total2sd0 = 0;
						$total20sd30 = 0;
                        $total231sd60 = 0;
                        $total261sd90 = 0;
                        $total291sd120 = 0;
						$total2sd120 = 0;
						$totaltempo2 = 0;
						$total2 = 0;
			//$this->pdf->AddPage('L');
            $sql ="select distinct addressbookid,fullname
					from (select d.addressbookid,d.fullname,a.amount,
					ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
						from cutarinv o
						join cutar p on p.cutarid=o.cutarid
						where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid
					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount order by fullname";
								
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='Rincian Umur Piutang Dagang Per Customer';
            $this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('L');
			
            $this->pdf->sety($this->pdf->gety()+0);
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','',10);
                $this->pdf->text(10,$this->pdf->gety()+3,'Customer');$this->pdf->text(30,$this->pdf->gety()+3,': '.$row['fullname']);
                $sql1 = "select z.*,
														case when umurtempo < 0 then totamount else 0 end as sd0,
														case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
														case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
														case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
														case when umurtempo > 90 and umurtempo <= 120 then totamount else 0 end as 91sd120,
														case when umurtempo > 120 then totamount else 0 end as sd120
												from
												(select distinct a.invoiceno, a.invoicedate, datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',date_add(a.invoicedate,interval d.paydays day)) as umurtempo,
												date_add(a.invoicedate,interval d.paydays day) as jatuhtempo,
												a.amount-ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
													from cutarinv o
													join cutar p on p.cutarid=o.cutarid
													where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as totamount,d.paydays
												from invoice a
												join giheader b on b.giheaderid = a.giheaderid
												join soheader c on c.soheaderid = b.soheaderid
												join paymentmethod d on d.paymentmethodid = c.paymentmethodid
												join employee e on e.employeeid = c.employeeid
												where  e.fullname like '%".$sales."%' and c.companyid = ".$companyid." and a.recordstatus = 3 and c.addressbookid = '".$row['addressbookid']."' 
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where totamount > 0";



                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $this->pdf->sety($this->pdf->gety()+6);
                $this->pdf->setFont('Arial','',8);
								$this->pdf->colalign = array('L','L','L','L','L','L','C','R','R');
                $this->pdf->setwidths(array(8,20,12,12,30,30,106,30,35));
								$this->pdf->colheader = array('|','|','|','|','|','|','Sudah Jatuh Tempo','|','|');
								$this->pdf->RowHeader();
								$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(8,20,12,12,28,28,28,28,28,28,28,35));
                $this->pdf->colheader = array('No','No Invoice','T.O.P','Umur','Belum Jatuh Tempo','0-30 Hari','31-60 Hari','61-90 Hari','91-120 Hari','> 120 Hari','Jumlah','Total');
                $this->pdf->RowHeader();
                $this->pdf->coldetailalign = array('L','C','R','R','R','R','R','R','R','R','R','R');
                $this->pdf->setFont('Arial','',8);
						$totalsd0 = 0;
						$total0sd30 = 0;
            $total31sd60 = 0;
            $total61sd90 = 0;
            $total91sd120 = 0;
						$totalsd120 = 0;
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
								Yii::app()->format->formatCurrency($row1['91sd120']/$per),
								Yii::app()->format->formatCurrency($row1['sd120']/$per),
                Yii::app()->format->formatCurrency(($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per),
                Yii::app()->format->formatCurrency(($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per)
                        )); 
                        $totalsd0 += $row1['sd0']/$per;
												$total0sd30 += $row1['0sd30']/$per;
                        $total31sd60 += $row1['31sd60']/$per;
                        $total61sd90 += $row1['61sd90']/$per;
                        $total91sd120 += $row1['91sd120']/$per;
												$totalsd120 += $row1['sd120']/$per;
												$totaltempo += ($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per;
												$total += ($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per;
                } 
							$this->pdf->setFont('Arial','B',8);
                $this->pdf->row(array(
                        '','Total','','',
						Yii::app()->format->formatCurrency($totalsd0),
						Yii::app()->format->formatCurrency($total0sd30),
						Yii::app()->format->formatCurrency($total31sd60),
						Yii::app()->format->formatCurrency($total61sd90),
						Yii::app()->format->formatCurrency($total91sd120),
						Yii::app()->format->formatCurrency($totalsd120),
						Yii::app()->format->formatCurrency($totaltempo),
                        Yii::app()->format->formatCurrency($total)
                ));
						$total2sd0 += $totalsd0;
						$total20sd30 += $total0sd30;
            $total231sd60 += $total31sd60;
            $total261sd90 += $total61sd90;
            $total291sd120 += $total91sd120;
						$total2sd120 += $totalsd120;
						$totaltempo2 += $totaltempo;
						$total2 += $total;
						$this->pdf->sety($this->pdf->gety()+5);
            $this->pdf->checkPageBreak(30);
            } 
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->colalign = array('C','R','R','R','R','R','R','R','R');
			$this->pdf->setwidths(array(52,28,28,28,28,28,28,28,35));
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->row(array(
			'Grand Total :',
					Yii::app()->format->formatCurrency($total2sd0),
					Yii::app()->format->formatCurrency($total20sd30),
						Yii::app()->format->formatCurrency($total231sd60),
						Yii::app()->format->formatCurrency($total261sd90),
						Yii::app()->format->formatCurrency($total291sd120),
						Yii::app()->format->formatCurrency($total2sd120),
						Yii::app()->format->formatCurrency($totaltempo2),
                        Yii::app()->format->formatCurrency($total2)	
			));
            $this->pdf->Output();
        }
	//7
	public function RekapUmurPiutangDagangPerCustomer($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select *,sum(sd0) as belumjatuhtempo, sum(0sd30) as sum0sd30,sum(31sd60) as sum31sd60, sum(61sd90) as sum61sd90, sum(sd90) as sumsd90
				from (select *,
				case when umurtempo < 0 then totamount else 0 end as sd0,
				case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
				case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
				case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
				case when umurtempo > 90 then totamount else 0 end as sd90
				from(select *,amount - payamount as totamount
				from (select d.fullname,e.paydays,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',
				date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
				datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,
				ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
				from cutarinv f
				join cutar g on g.cutarid=f.cutarid
				where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
				from invoice a
				inner join giheader b on b.giheaderid = a.giheaderid
				inner join soheader c on c.soheaderid = b.soheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				inner join employee f on f.employeeid = c.employeeid			
				where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 	
				and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z)zz 
				where amount > payamount)zzz
				group by fullname
				order by fullname";

		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Umur Piutang Dagang Per Customer';
			$this->pdf->subtitle='Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('L');
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,45,35,35,35,35,35,40));
                $this->pdf->colheader = array('No','Nama Customer','Belum Jatuh Tempo','0-30 Hari','31-60 Hari','61-90 Hari','> 90 Hari','Total');
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
	//8
	public function RincianFakturdanReturJualBelumLunasPerSales($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
  {
      parent::actionDownPDF();
			$nilaitot2 = 0;$dibayar2 = 0;$sisa2 = 0;
      $sql = "select distinct employeeid,fullname
						from (select f.employeeid,f.fullname,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid=c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by fullname";
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
				$sql1 = "select distinct addressbookid,fullname
						from (select d.addressbookid,d.fullname,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c. employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and c.employeeid = '".$row['employeeid']."'
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				foreach($dataReader1 as $row1)
				{                
					$this->pdf->SetFont('Arial','',9);
					$this->pdf->text(10,$this->pdf->gety()+5,'Customer ');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row1['fullname']);
					$this->pdf->sety($this->pdf->gety()+5);
					
					$sql2 = "select *
						from (select a.invoiceno,a.invoicedate,e.paydays,
						date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
						datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
						datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and d.addressbookid = '".$row1['addressbookid']."' and c.employeeid = '".$row['employeeid']."'
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by umurtempo";						
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					
					$this->pdf->sety($this->pdf->gety()+7);
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(10,20,25,25,15,15,30,25,30));
					$this->pdf->colheader = array('No','Dokumen','Tanggal','j_tempo','Umur','UT','Nilai','Kum_bayar','Sisa');
					$this->pdf->RowHeader();
					$this->pdf->coldetailalign = array('C','C','C','C','C','C','R','R','R');
					$this->pdf->setFont('Arial','',8);
					$i=0;$nilaitot = 0;$dibayar = 0;$sisa = 0;
					
					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array(
							$i,$row2['invoiceno'],
							date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
							date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo'])),
							$row2['umur'],
							$row2['umurtempo'],
							Yii::app()->format->formatCurrency($row2['amount']/$per),
							Yii::app()->format->formatCurrency($row2['payamount']/$per),
							Yii::app()->format->formatCurrency(($row2['amount']-$row2['payamount'])/$per),
						));
						$nilaitot += $row2['amount']/$per;
						$dibayar += $row2['payamount']/$per;
						$sisa += ($row2['amount']-$row2['payamount'])/$per;
						
						$this->pdf->checkPageBreak(20);
					}
					$this->pdf->setFont('Arial','B',8);
					$this->pdf->coldetailalign = array('R','R','R','R');
					$this->pdf->setwidths(array(110,30,25,30));
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
					$this->pdf->setwidths(array(110,30,25,30));
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
	public function RekapKontrolPiutangCustomervsPlafon($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalbelum=0;$totalsudah=0;$totalnilai=0;$totalplafon=0;
		$sql = "select fullname,sum(belum) as belum,sum(sudah) as sudah,sum(nilai) as nilai,plafon from
								(select z.*,
								case when umur <= paydays then nilai else 0 end as belum,
								case when umur > paydays then nilai else 0 end as sudah
								from
								(select distinct a.invoiceno,a.invoicedate,date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,e.paydays,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
								a.amount-(ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0)) as nilai,
								d.creditlimit as plafon,d.fullname
								from invoice a
								join giheader b on b.giheaderid=a.giheaderid
								join soheader c on c.soheaderid=b.soheaderid
								join addressbook d on d.addressbookid=c.addressbookid
								join paymentmethod e on e.paymentmethodid=c.paymentmethodid
								join employee f on f.employeeid = c.employeeid
								where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
								and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								order by invoicedate) z where nilai > 0) zz group by fullname order by fullname";
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
					$i+=1;
					$this->pdf->SetFont('Arial','',8);
					$this->pdf->sety($this->pdf->gety()+0);
					$this->pdf->row(array($i,$row['fullname'],						
						Yii::app()->format->formatCurrency($row['belum']/$per),
						Yii::app()->format->formatCurrency($row['sudah']/$per),
						Yii::app()->format->formatCurrency($row['nilai']/$per),
						Yii::app()->format->formatCurrency($row['plafon']/$per),
						Yii::app()->format->formatCurrency(($row['nilai'] - $row['plafon'])/$per),
					));
					$totalbelum += $row['belum']/$per;
					$totalsudah += $row['sudah']/$per;
					$totalnilai += $row['nilai']/$per;
					$totalplafon += $row['plafon']/$per;
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
	
	/*public function RekapKontrolPiutangCustomervsPlafon($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$totalbelum=0;$totalsudah=0;$totalnilai=0;$totalplafon=0;
		
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
					
					
		 
			
				$sql1 = 	"select *,sum(amount) as sumamount,sum(creditlimit)as sumcreditlimit,sum(payamount)as sumpayamount,sum(sisa) as 							sumsisa,sum(belum) as sumbelum,sum(sudah)as sumsudah
											from(select zz.*,
											case when umur <= paydays then amount else 0 end as belum,
											case when umur > paydays then amount else 0 end as sudah
											from
											(select *, (amount-payamount) as sisa
											from (select a.invoiceno,a.invoicedate,e.paydays,d.fullname as customer,
											date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
											datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,d.creditlimit,
											ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
											from cutarinv f
											join cutar g on g.cutarid=f.cutarid
											where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
											from invoice a
											inner join giheader b on b.giheaderid = a.giheaderid
											inner join soheader c on c.soheaderid = b.soheaderid
											inner join addressbook d on d.addressbookid = c.addressbookid
											inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
											where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
											and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z)zz)zzz
											where amount > payamount
											group by customer
											order by invoiceno";




								
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();			
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->SetFont('Arial','',8);
					$this->pdf->sety($this->pdf->gety()+0);
					$this->pdf->row(array($i,$row1['customer'],						
						Yii::app()->format->formatCurrency($row1['sumbelum']/$per),
						Yii::app()->format->formatCurrency($row1['sumsudah']/$per),
						Yii::app()->format->formatCurrency($row1['sumamount']/$per),
						Yii::app()->format->formatCurrency($row1['sumcreditlimit']/$per),
						Yii::app()->format->formatCurrency($row1['sumamount']/$per - $row1['sumcreditlimit']/$per),
					));
					$totalbelum += $row1['sumbelum']/$per;
					$totalsudah += $row1['sumsudah']/$per;
					$totalnilai += $row1['sumamount']/$per;
					$totalplafon += $row1['sumcreditlimit']/$per;
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
	}*/
	//10
	public function RincianKontrolPiutangCustomervsPlafon($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
  {
      parent::actionDownPDF();
			$totalbelum1=0;$totalsudah1=0;$totalnilai1=0;$totalplafon1=0;
      $sql ="select distinct addressbookid,fullname
						from (select d.addressbookid,d.fullname,a.amount,
						ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
						from cutarinv f
						join cutar g on g.cutarid=f.cutarid
						where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						join giheader b on b.giheaderid = a.giheaderid
						join soheader c on c.soheaderid = b.soheaderid
						join addressbook d on d.addressbookid = c.addressbookid
						join employee e on e.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
						and d.fullname like '%".$customer."%' 
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
						where amount > payamount
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
				$totalbelum=0;$totalsudah=0;$totalnilai=0;$totalcreditlimit=0;
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
									$sql1 ="select zz.*,
												case when umur <= paydays then sisa else 0 end as belum,
												case when umur > paydays then sisa else 0 end as sudah
												from
												(select *, (amount-payamount) as sisa,(amount) as nilai
												from (select a.invoiceno,a.invoicedate,e.paydays,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,d.creditlimit,
												ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
												from invoice a
												inner join giheader b on b.giheaderid = a.giheaderid
												inner join soheader c on c.soheaderid = b.soheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												inner join employee f on f.employeeid = c.employeeid
												where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."  
												and d.addressbookid = ".$row['addressbookid']."
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z)zz
												where amount > payamount 
												order by invoiceno";
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
						Yii::app()->format->formatCurrency($row1['belum']/$per),
						Yii::app()->format->formatCurrency($row1['sudah']/$per),
						Yii::app()->format->formatCurrency($row1['sisa']/$per),						
						'',
						'',
					));
					
					$totalbelum += $row1['belum']/$per;
					$totalsudah += $row1['sudah']/$per;
					$totalnilai += $row1['sisa']/$per;
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
					Yii::app()->format->formatCurrency($row1['creditlimit']/$per),
					Yii::app()->format->formatCurrency($totalnilai - ($row1['creditlimit']/$per)),
				));
				
					$totalbelum1 += $totalbelum;
					$totalsudah1 += $totalsudah;
					$totalnilai1 += $totalnilai;
					$totalplafon1 += ($row1['creditlimit']/$per);
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
	public function KonfirmasiPiutangDagang($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
  {
		parent::actionDownPDF();
		$totalbelum1=0;$totalsudah1=0;$totalnilai1=0;$totalplafon1=0;
		$sql ="select distinct addressbookid,fullname,alamat,phoneno
					from (select d.addressbookid,d.fullname,a.amount,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,
					(select h.addressname	from address h where h.addressbookid=d.addressbookid Limit 1) as alamat,
					(select i.phoneno	from address i where i.addressbookid=d.addressbookid Limit 1) as phoneno
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid			
					where d.fullname like '%".$customer."%' and e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Konfirmasi Piutang';
		/*$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));*/
		$this->pdf->AddPage('P');
		
		foreach($dataReader as $row)
		{                
			$i=0;$totalamount=0;$totalpayamount=0;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->text(10,$this->pdf->gety()+0,'Kepada YTH,');$this->pdf->text(135,$this->pdf->gety()+5,'Note : Bukti Konfirmasi ini tidak untuk Penagihan');
			$this->pdf->text(15,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->text(10,$this->pdf->gety()+10,'Di Tempat');
			$this->pdf->setFont('Arial','BU',10);
			$this->pdf->text(80,$this->pdf->gety()+15,'Hal : KONFIRMASI PIUTANG');
			$this->pdf->setFont('Arial','',8);
			$this->pdf->text(10,$this->pdf->gety()+25,'Dengan Hormat,');
			$this->pdf->text(10,$this->pdf->gety()+32,'Dalam rangka kegiatan rutin dan tertib administrasi, maka dengan ini kami mohon kesediaan Bapak / Ibu Relasi kami untuk dapat memberikan informasi');
			$this->pdf->text(10,$this->pdf->gety()+35,'atas saldo tagihan perusahaan kami yang masih tersisa terhadap :');
			$this->pdf->text(25,$this->pdf->gety()+40,'Toko / Customer');$this->pdf->text(50,$this->pdf->gety()+40,': '.$row['fullname']);
			$this->pdf->text(110,$this->pdf->gety()+40,'No. Telepon');$this->pdf->text(130,$this->pdf->gety()+40,': '.$row['phoneno']);
			$this->pdf->text(25,$this->pdf->gety()+44,'Alamat');$this->pdf->text(50,$this->pdf->gety()+44,': '.$row['alamat']);
			$this->pdf->text(25,$this->pdf->gety()+48,'Per Tanggal');$this->pdf->text(50,$this->pdf->gety()+48,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->text(10,$this->pdf->gety()+55,'Dengan perincian sebagai berikut :');
			
			$i=0;$nilaitot = 0;$dibayar = 0;$sisa = 0;$i=0;
			$sql1 ="select *
						from (select a.invoiceno,a.invoicedate,e.paydays,
						date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
						datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,d.creditlimit,
						ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
						from cutarinv f
						join cutar g on g.cutarid=f.cutarid
						where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."  
						and d.addressbookid = ".$row['addressbookid']."
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount 
						order by invoiceno";
						
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+60);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(8,20,17,17,25,22,25,9,48));
			$this->pdf->colheader = array('No','Dokumen','Tanggal','J_Tempo','Nilai Invoice','Jml_Cicilan','Sisa Invoice','Umur','Sales');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','C','C','R','R','R','R');
			$this->pdf->sety($this->pdf->gety()+1);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->SetFont('Arial','',8);					
				$this->pdf->row(array(
					$i,$row1['invoiceno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),
					Yii::app()->format->formatCurrency($row1['payamount']/$per),
					Yii::app()->format->formatCurrency(($row1['amount']-$row1['payamount'])/$per),
					$row1['umur'],
				));
				$totalamount += $row1['amount']/$per;
				$totalpayamount += $row1['payamount']/$per;
			}
			$this->pdf->text(35,$this->pdf->gety()+5,'Saldo Piutang Dagang');
			$this->pdf->text(70,$this->pdf->gety()+5,': ');
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(75,$this->pdf->gety()+5,Yii::app()->format->formatCurrency(($totalamount-$totalpayamount)));
			
			$this->pdf->SetFont('Arial','',8);
			$this->pdf->text(10,$this->pdf->gety()+12,'Mengingat pentingnya hal ini, maka kami sangat mengharapkan bantuannya dan jika dari jumlah tersebut diatas ada yang tidak setuju');
			$this->pdf->text(10,$this->pdf->gety()+16,'mohon penjelasannya.');
			$this->pdf->text(20,$this->pdf->gety()+21,'Alasan :');
			$this->pdf->text(32,$this->pdf->gety()+43,'Menyetujui,');
			$this->pdf->text(20,$this->pdf->gety()+66,'( TTd / Cap Toko /Nama Jelas )');
			$this->pdf->text(90,$this->pdf->gety()+43,'Mengetahui,');
			$this->pdf->text(85,$this->pdf->gety()+66,'(         FM / BM         )');
			$this->pdf->text(150,$this->pdf->gety()+43,'Hormat kami,');
			$this->pdf->text(145,$this->pdf->gety()+66,'(                                  )');
			$this->pdf->text(10,$this->pdf->gety()+75,'Catatan : Konfirmasi ini bukan sebagai bukti penagihan');
			
			$this->pdf->checkPageBreak(200);
		}   
		$this->pdf->Output();
   }
	//12
	public function RekapInvoiceARPerDokumenBelumStatusMax($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
			$sql ="select distinct a.invoiceid, a.invoiceno, a.invoicedate, b.gino, a.headernote, c.companyid, a.recordstatus,a.statusname
				from invoice a
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				where a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and a.recordstatus between 1 and (3-1)
				and a.invoiceno is not null
				and c.companyid = ".$companyid."
				order by a.recordstatus";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Invoice AR Per Dokumen Belum Status Max';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
                        $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','L','L');
			$this->pdf->setwidths(array(10,20,25,25,25,60,25,25));
			$this->pdf->colheader = array('No','ID Transaksi','No Transaksi','Tanggal','No Referensi','Keterangan','Status');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','C','C','L','L',);		
			$totalnominal1=0;$i=0;$totaldisc1=0;$totaljumlah1=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',7);
				$this->pdf->row(array(
					$i,$row['invoiceid'],$row['invoiceno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
					$row['gino'],$row['headernote'],$row['statusname']
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}
	//13
	public function RekapNotaReturPenjualanPerBelumStatusMax($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
			$sql ="select distinct a.notagirid, a.notagirno, a.docdate, b.gireturno, a.headernote, a.recordstatus, a.companyid, a.statusname
				from notagir a
				join giretur b on b.gireturid = a.gireturid
				where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and a.recordstatus between 1 and (3-1)
				and b.gireturno is not null
				and a.companyid = ".$companyid."
				order by a.recordstatus";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Nota Retur Penjualan Per Dokumen Belum Status Max';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
                        $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','L','L');
			$this->pdf->setwidths(array(10,20,25,25,25,60,25,25));
			$this->pdf->colheader = array('No','ID Transaksi','No Transaksi','Tanggal','No Referensi','Keterangan','Status');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','C','C','L','L',);		
			$totalnominal1=0;$i=0;$totaldisc1=0;$totaljumlah1=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',7);
				$this->pdf->row(array(
					$i,$row['notagirid'],$row['notagirno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
					$row['gireturno'],$row['headernote'],$row['statusname']
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}
	//14
	public function RekapPelunasanPiutangPerDokumenBelumStatusMax($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
			$sql ="select distinct a.cutarid,a.cutarno,a.docdate, b.docno,a.headernote,a.recordstatus,a.statusname
				from cutar a
				join ttnt b on b.ttntid = a.ttntid
				where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and a.recordstatus between 1 and (3-1)
				and b.docno is not null
				and a.companyid = ".$companyid."
				order by a.recordstatus";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Pelunasan Piutang Per Dokumen Belum Status Max';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			$this->pdf->setFont('Arial','B',8);
                        $this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->colalign = array('C','C','C','C','C','L','L');
			$this->pdf->setwidths(array(10,20,25,25,25,60,25,25));
			$this->pdf->colheader = array('No','ID Transaksi','No Transaksi','Tanggal','No Referensi','Keterangan','Status');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','C','C','C','C','L','L',);		
			$totalnominal1=0;$i=0;$totaldisc1=0;$totaljumlah1=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',7);
				$this->pdf->row(array(
					$i,$row['cutarid'],$row['cutarno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
					$row['docno'],$row['headernote'],$row['statusname']
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}	
	//15
	public function RincianPelunasanPiutangPerSales($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
	  parent::actionDownPDF();
		$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Rincian Pelunasan Piutang Per Sales';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','F4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		$this->pdf->sety($this->pdf->gety()+5);
		// definisi font
                
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+2,'SALES ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['fullname']);
			$sql1 = "select *,
								case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
								case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
								case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
								case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
								case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
								case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
								case when umur > 90 then nilaibayar else 0 end as sd91								
						from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
						a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
						and l.productname like '%".$product."%'
						and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid'].") z
						order by docdate,fullname
						";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
									
			$i=0;
			$totaldisc=0;
			$totalnilaibayar=0;
			$total0sd30=0;
			$total31sd45=0;
			$total46sd60=0;
			$total61sd63=0;
			$total64sd70=0;
			$total71sd90=0;
			$totalsd91=0;
			$this->pdf->setFont('Arial','B',7.2);
			$this->pdf->sety($this->pdf->gety()+5);    
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,17,14,14,49,7,20,20,22,20,20,20,20,20,20,20));
			$this->pdf->colheader = array('No','No Invoice','Tanggal','Tgl Byr','Customer','Hari','Nil. Faktur','Disc/Ret','Jmlh Bayar','0 - 30 Hari','31 - 45 Hari','46 - 60 Hari','61 - 63 Hari','64 - 70 Hari','71 - 90 Hari','> 90 Hari');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','C','C','C','L','C','R','R','R','R','R','R','R','R','R','R');
			
			foreach($dataReader1 as $row1)							
			{
				$this->pdf->setFont('Arial','',6.5);
				$i=$i+1;
				$this->pdf->row(array($i,$row1['invoiceno'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
				date(Yii::app()->params['dateviewfromdb'], strtotime($row1['docdate'])),
				$row1['fullname'],
				$row1['umur'],
				Yii::app()->format->formatCurrency($row1['amount']/$per),
				Yii::app()->format->formatCurrency($row1['disc']/$per),
				Yii::app()->format->formatCurrency($row1['nilaibayar']/$per),
				Yii::app()->format->formatCurrency($row1['0sd30']/$per),
				Yii::app()->format->formatCurrency($row1['31sd45']/$per),
				Yii::app()->format->formatCurrency($row1['46sd60']/$per),
				Yii::app()->format->formatCurrency($row1['61sd63']/$per),
				Yii::app()->format->formatCurrency($row1['64sd70']/$per),
				Yii::app()->format->formatCurrency($row1['71sd90']/$per),
				Yii::app()->format->formatCurrency($row1['sd91']/$per),
				));
						
				$totaldisc += ($row1['disc']/$per);
				$totalnilaibayar += ($row1['nilaibayar']/$per);
				$total0sd30 += ($row1['0sd30']/$per);
				$total31sd45 += ($row1['31sd45']/$per);
				$total46sd60 += ($row1['46sd60']/$per);
				$total61sd63 += ($row1['61sd63']/$per);
				$total64sd70 += ($row1['64sd70']/$per);
				$total71sd90 += ($row1['71sd90']/$per);
				$totalsd91 += ($row1['sd91']/$per);
			}
						
			$this->pdf->setFont('Arial','B',6.5);
			$this->pdf->row(array('','','','','TOTAL SALES '.$row['fullname'],'','',
			Yii::app()->format->formatCurrency($totaldisc),			
			Yii::app()->format->formatCurrency($totalnilaibayar),			
			Yii::app()->format->formatCurrency($total0sd30),
			Yii::app()->format->formatCurrency($total31sd45),
			Yii::app()->format->formatCurrency($total46sd60),
			Yii::app()->format->formatCurrency($total61sd63),
			Yii::app()->format->formatCurrency($total64sd70),
			Yii::app()->format->formatCurrency($total71sd90),
			Yii::app()->format->formatCurrency($totalsd91),));
			
			$totaldisc1 += $totaldisc;
			$totalnilaibayar1 += $totalnilaibayar;
			$total0sd301 += $total0sd30;
			$total31sd451 += $total31sd45;
			$total46sd601 += $total46sd60;
			$total61sd631 += $total61sd63;
			$total64sd701 += $total64sd70;
			$total71sd901 += $total71sd90;
			$totalsd911 += $totalsd91;
			
			$this->pdf->sety($this->pdf->gety()+5);
			
			$this->pdf->checkPageBreak(20);
		}
		
		$this->pdf->setFont('Arial','BI',6.5);
		$this->pdf->row(array('','','','','GRAND TOTAL','','',
			Yii::app()->format->formatCurrency($totaldisc1),			
			Yii::app()->format->formatCurrency($totalnilaibayar1),			
			Yii::app()->format->formatCurrency($total0sd301),
			Yii::app()->format->formatCurrency($total31sd451),
			Yii::app()->format->formatCurrency($total46sd601),
			Yii::app()->format->formatCurrency($total61sd631),
			Yii::app()->format->formatCurrency($total64sd701),
			Yii::app()->format->formatCurrency($total71sd901),
			Yii::app()->format->formatCurrency($totalsd911),));
				
		$this->pdf->Output();
	}
	//16
	public function RekapPelunasanPiutangPerSales($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
	  parent::actionDownPDF();
		$i=0;$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Rekap Pelunasan Piutang Per Sales';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		$this->pdf->sety($this->pdf->gety()+5);
		// definisi font
    
		$this->pdf->setFont('Arial','B',8.5);
		$this->pdf->sety($this->pdf->gety()+5);    
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(8,50,23,25,25,25,25,25,25,25,25));
		$this->pdf->colheader = array('No','Nama Sales','Disc/Ret','Jmlh Bayar','0 - 30 Hari','31 - 45 Hari','46 - 60 Hari','61 - 63 Hari','64 - 70 Hari','71 - 90 Hari','> 90 Hari');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','R','R','R','R','R','R','R','R','R');
			
		foreach($dataReader as $row)
		{
			$sql1 = "select *,
								case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
								case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
								case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
								case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
								case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
								case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
								case when umur > 90 then nilaibayar else 0 end as sd91								
						from (select c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
						a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
						and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						and l.productname like '%".$product."%' 
						and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid'].") z
						order by docdate,fullname
						";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
									
			$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
			
			foreach($dataReader1 as $row1)							
			{
				$totaldisc += ($row1['disc']/$per);
				$totalnilaibayar += ($row1['nilaibayar']/$per);
				$total0sd30 += ($row1['0sd30']/$per);
				$total31sd45 += ($row1['31sd45']/$per);
				$total46sd60 += ($row1['46sd60']/$per);
				$total61sd63 += ($row1['61sd63']/$per);
				$total64sd70 += ($row1['64sd70']/$per);
				$total71sd90 += ($row1['71sd90']/$per);
				$totalsd91 += ($row1['sd91']/$per);
			}
			$this->pdf->setFont('Arial','',7);
			$i=$i+1;
			$this->pdf->row(array($i,$row['fullname'],
			Yii::app()->format->formatCurrency($totaldisc),			
			Yii::app()->format->formatCurrency($totalnilaibayar),			
			Yii::app()->format->formatCurrency($total0sd30),
			Yii::app()->format->formatCurrency($total31sd45),
			Yii::app()->format->formatCurrency($total46sd60),
			Yii::app()->format->formatCurrency($total61sd63),
			Yii::app()->format->formatCurrency($total64sd70),
			Yii::app()->format->formatCurrency($total71sd90),
			Yii::app()->format->formatCurrency($totalsd91),));
			
			$totaldisc1 += $totaldisc;
			$totalnilaibayar1 += $totalnilaibayar;
			$total0sd301 += $total0sd30;
			$total31sd451 += $total31sd45;
			$total46sd601 += $total46sd60;
			$total61sd631 += $total61sd63;
			$total64sd701 += $total64sd70;
			$total71sd901 += $total71sd90;
			$totalsd911 += $totalsd91;
			
			$this->pdf->checkPageBreak(20);
		}
		
		$this->pdf->setFont('Arial','BI',8);
		$this->pdf->row(array('','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaldisc1),			
			Yii::app()->format->formatCurrency($totalnilaibayar1),			
			Yii::app()->format->formatCurrency($total0sd301),
			Yii::app()->format->formatCurrency($total31sd451),
			Yii::app()->format->formatCurrency($total46sd601),
			Yii::app()->format->formatCurrency($total61sd631),
			Yii::app()->format->formatCurrency($total64sd701),
			Yii::app()->format->formatCurrency($total71sd901),
			Yii::app()->format->formatCurrency($totalsd911)));
				
		$this->pdf->Output();
	}
	//17
	public function RincianPelunasanPiutangPerSalesPerJenisBarang($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
	  parent::actionDownPDF();
		$totaldisc2 = 0;$totalnilaibayar2 = 0;$total0sd302 = 0;$total31sd452 = 0;$total46sd602 = 0;$total61sd632 = 0;$total64sd702 = 0;$total71sd902 = 0;$totalsd912 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Rincian Pelunasan Piutang Per Sales Per Jenis Barang';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','F4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		$this->pdf->sety($this->pdf->gety()+5);
		// definisi font
                
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+2,'SALES ');$this->pdf->text(25,$this->pdf->gety()+2,': '.$row['fullname']);
			$this->pdf->sety($this->pdf->gety()+5);
			$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
			$sql1 = "select distinct i.slocid,i.description
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join gidetail h on h.giheaderid=d.giheaderid
							join sloc i on i.slocid=h.slocid
							join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
							b.recordstatus=3 and f.employeeid = ".$row['employeeid']." and j.areaname like '%".$salesarea."%' and
							l.productname like '%".$product."%' and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
									
			foreach($dataReader1 as $row1)
			{
				$i=0;$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(10,$this->pdf->gety()+2,'JENIS BARANG ');$this->pdf->text(35,$this->pdf->gety()+2,': '.$row1['description']);
				$sql2 = "select *,
									case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
									case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
									case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
									case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
									case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
									case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
									case when umur > 90 then nilaibayar else 0 end as sd91								
							from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
							a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar,
							(select h.slocid from gidetail h where h.giheaderid=d.giheaderid Limit 1) as slocid
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
							and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and l.productname like '%".$product."%' 
							and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid']." ) z
							where z.slocid = ".$row1['slocid']."
							order by docdate,fullname
							";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
										
				$this->pdf->setFont('Arial','B',7.2);
				$this->pdf->sety($this->pdf->gety()+5);    
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(6,17,14,14,49,7,20,20,22,20,20,20,20,20,20,20));
				$this->pdf->colheader = array('No','No Invoice','Tanggal','Tgl Byr','Customer','Hari','Nil. Faktur','Disc/Ret','Jmlh Bayar','0 - 30 Hari','31 - 45 Hari','46 - 60 Hari','61 - 63 Hari','64 - 70 Hari','71 - 90 Hari','> 90 Hari');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('R','C','C','C','L','C','R','R','R','R','R','R','R','R','R','R');
				
				foreach($dataReader2 as $row2)							
				{
					$this->pdf->setFont('Arial','',6.5);
					$i=$i+1;
					$this->pdf->row(array($i,$row2['invoiceno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row2['docdate'])),
					$row2['fullname'],
					$row2['umur'],
					Yii::app()->format->formatCurrency($row2['amount']/$per),
					Yii::app()->format->formatCurrency($row2['disc']/$per),
					Yii::app()->format->formatCurrency($row2['nilaibayar']/$per),
					Yii::app()->format->formatCurrency($row2['0sd30']/$per),
					Yii::app()->format->formatCurrency($row2['31sd45']/$per),
					Yii::app()->format->formatCurrency($row2['46sd60']/$per),
					Yii::app()->format->formatCurrency($row2['61sd63']/$per),
					Yii::app()->format->formatCurrency($row2['64sd70']/$per),
					Yii::app()->format->formatCurrency($row2['71sd90']/$per),
					Yii::app()->format->formatCurrency($row2['sd91']/$per),
					));
							
					$totaldisc += ($row2['disc']/$per);
					$totalnilaibayar += ($row2['nilaibayar']/$per);
					$total0sd30 += ($row2['0sd30']/$per);
					$total31sd45 += ($row2['31sd45']/$per);
					$total46sd60 += ($row2['46sd60']/$per);
					$total61sd63 += ($row2['61sd63']/$per);
					$total64sd70 += ($row2['64sd70']/$per);
					$total71sd90 += ($row2['71sd90']/$per);
					$totalsd91 += ($row2['sd91']/$per);
					
				}
				$this->pdf->setFont('Arial','B',6.5);
				$this->pdf->row(array('','','','','TOTAL GUDANG '.$row1['description'],'','',
				Yii::app()->format->formatCurrency($totaldisc),			
				Yii::app()->format->formatCurrency($totalnilaibayar),			
				Yii::app()->format->formatCurrency($total0sd30),
				Yii::app()->format->formatCurrency($total31sd45),
				Yii::app()->format->formatCurrency($total46sd60),
				Yii::app()->format->formatCurrency($total61sd63),
				Yii::app()->format->formatCurrency($total64sd70),
				Yii::app()->format->formatCurrency($total71sd90),
				Yii::app()->format->formatCurrency($totalsd91),));
				
				$totaldisc1 += $totaldisc;
				$totalnilaibayar1 += $totalnilaibayar;
				$total0sd301 += $total0sd30;
				$total31sd451 += $total31sd45;
				$total46sd601 += $total46sd60;
				$total61sd631 += $total61sd63;
				$total64sd701 += $total64sd70;
				$total71sd901 += $total71sd90;
				$totalsd911 += $totalsd91;
			
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->setFont('Arial','B',6.5);
			$this->pdf->row(array('','','','','TOTAL SALES '.$row['fullname'],'','',
			Yii::app()->format->formatCurrency($totaldisc1),			
			Yii::app()->format->formatCurrency($totalnilaibayar1),			
			Yii::app()->format->formatCurrency($total0sd301),
			Yii::app()->format->formatCurrency($total31sd451),
			Yii::app()->format->formatCurrency($total46sd601),
			Yii::app()->format->formatCurrency($total61sd631),
			Yii::app()->format->formatCurrency($total64sd701),
			Yii::app()->format->formatCurrency($total71sd901),
			Yii::app()->format->formatCurrency($totalsd911),));
			
			$totaldisc2 += $totaldisc1;
			$totalnilaibayar2 += $totalnilaibayar1;
			$total0sd302 += $total0sd301;
			$total31sd452 += $total31sd451;
			$total46sd602 += $total46sd601;
			$total61sd632 += $total61sd631;
			$total64sd702 += $total64sd701;
			$total71sd902 += $total71sd901;
			$totalsd912 += $totalsd911;
			
			$this->pdf->sety($this->pdf->gety()+5);
		}
		
		$this->pdf->setFont('Arial','BI',6.5);
		$this->pdf->row(array('','','','','GRAND TOTAL','','',
			Yii::app()->format->formatCurrency($totaldisc2),			
			Yii::app()->format->formatCurrency($totalnilaibayar2),			
			Yii::app()->format->formatCurrency($total0sd302),
			Yii::app()->format->formatCurrency($total31sd452),
			Yii::app()->format->formatCurrency($total46sd602),
			Yii::app()->format->formatCurrency($total61sd632),
			Yii::app()->format->formatCurrency($total64sd702),
			Yii::app()->format->formatCurrency($total71sd902),
			Yii::app()->format->formatCurrency($totalsd912),));
				
		$this->pdf->Output();
	}
	//18
	public function RekapPelunasanPiutangPerSalesPerJenisBarang($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
	  parent::actionDownPDF();
		$totaldisc2 = 0;$totalnilaibayar2 = 0;$total0sd302 = 0;$total31sd452 = 0;$total46sd602 = 0;$total61sd632 = 0;$total64sd702 = 0;$total71sd902 = 0;$totalsd912 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title='Rekap Pelunasan Piutang Per Sales Per Jenis Barang';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		$this->pdf->sety($this->pdf->gety()+5);
		// definisi font
                
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+2,'SALES ');$this->pdf->text(25,$this->pdf->gety()+2,': '.$row['fullname']);
			$i=0;$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
			$sql1 = "select distinct i.slocid,i.description
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join gidetail h on h.giheaderid=d.giheaderid
							join sloc i on i.slocid=h.slocid
							join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
							b.recordstatus=3 and j.areaname like '%".$salesarea."%' and f.employeeid = ".$row['employeeid']." and
							l.productname like '%".$product."%' and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->setFont('Arial','B',8.5);
			$this->pdf->sety($this->pdf->gety()+5);    
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(8,50,23,25,25,25,25,25,25,25,25));
			$this->pdf->colheader = array('No','Nama Sales','Disc/Ret','Jmlh Bayar','0 - 30 Hari','31 - 45 Hari','46 - 60 Hari','61 - 63 Hari','64 - 70 Hari','71 - 90 Hari','> 90 Hari');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','R','R','R','R','R','R','R','R','R');
									
			foreach($dataReader1 as $row1)
			{
				$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
				$sql2 = "select *,
									case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
									case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
									case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
									case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
									case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
									case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
									case when umur > 90 then nilaibayar else 0 end as sd91								
							from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
							a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar,
							(select h.slocid from gidetail h where h.giheaderid=d.giheaderid Limit 1) as slocid
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
							and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and l.productname like '%".$product."%' 
							and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid']." ) z
							where z.slocid = ".$row1['slocid']."
							order by docdate,fullname
							";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				foreach($dataReader2 as $row2)							
				{							
					$totaldisc += ($row2['disc']/$per);
					$totalnilaibayar += ($row2['nilaibayar']/$per);
					$total0sd30 += ($row2['0sd30']/$per);
					$total31sd45 += ($row2['31sd45']/$per);
					$total46sd60 += ($row2['46sd60']/$per);
					$total61sd63 += ($row2['61sd63']/$per);
					$total64sd70 += ($row2['64sd70']/$per);
					$total71sd90 += ($row2['71sd90']/$per);
					$totalsd91 += ($row2['sd91']/$per);					
				}
				$this->pdf->setFont('Arial','',7);
				$i=$i+1;
				$this->pdf->row(array($i,$row1['description'],
				Yii::app()->format->formatCurrency($totaldisc),			
				Yii::app()->format->formatCurrency($totalnilaibayar),			
				Yii::app()->format->formatCurrency($total0sd30),
				Yii::app()->format->formatCurrency($total31sd45),
				Yii::app()->format->formatCurrency($total46sd60),
				Yii::app()->format->formatCurrency($total61sd63),
				Yii::app()->format->formatCurrency($total64sd70),
				Yii::app()->format->formatCurrency($total71sd90),
				Yii::app()->format->formatCurrency($totalsd91),));
				
				$totaldisc1 += $totaldisc;
				$totalnilaibayar1 += $totalnilaibayar;
				$total0sd301 += $total0sd30;
				$total31sd451 += $total31sd45;
				$total46sd601 += $total46sd60;
				$total61sd631 += $total61sd63;
				$total64sd701 += $total64sd70;
				$total71sd901 += $total71sd90;
				$totalsd911 += $totalsd91;
			
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->setFont('Arial','B',7);
			$this->pdf->row(array('','TOTAL SALES '.$row['fullname'],
			Yii::app()->format->formatCurrency($totaldisc1),			
			Yii::app()->format->formatCurrency($totalnilaibayar1),			
			Yii::app()->format->formatCurrency($total0sd301),
			Yii::app()->format->formatCurrency($total31sd451),
			Yii::app()->format->formatCurrency($total46sd601),
			Yii::app()->format->formatCurrency($total61sd631),
			Yii::app()->format->formatCurrency($total64sd701),
			Yii::app()->format->formatCurrency($total71sd901),
			Yii::app()->format->formatCurrency($totalsd911),));
			
			$totaldisc2 += $totaldisc1;
			$totalnilaibayar2 += $totalnilaibayar1;
			$total0sd302 += $total0sd301;
			$total31sd452 += $total31sd451;
			$total46sd602 += $total46sd601;
			$total61sd632 += $total61sd631;
			$total64sd702 += $total64sd701;
			$total71sd902 += $total71sd901;
			$totalsd912 += $totalsd911;
			
			$this->pdf->sety($this->pdf->gety()+5);
		}
		
		$this->pdf->setFont('Arial','BI',8);
		$this->pdf->row(array('','GRAND TOTAL',
			Yii::app()->format->formatCurrency($totaldisc2),			
			Yii::app()->format->formatCurrency($totalnilaibayar2),			
			Yii::app()->format->formatCurrency($total0sd302),
			Yii::app()->format->formatCurrency($total31sd452),
			Yii::app()->format->formatCurrency($total46sd602),
			Yii::app()->format->formatCurrency($total61sd632),
			Yii::app()->format->formatCurrency($total64sd702),
			Yii::app()->format->formatCurrency($total71sd902),
			Yii::app()->format->formatCurrency($totalsd912),));
				
		$this->pdf->Output();
	}
	//19
     public function RekapPenjualanVSPelunasanPerBulanPerCustomer($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
         $company_penj = ' and aaa.companyid = :company';
         $company_byr = ' and c1.companyid = :company';
         if(isset($customer) && $customer!==''){
             $limit = 'limit 1';
             $do_loop = TRUE;
         }else{
             $limit = '';
             $do_loop = FALSE;
             if(isset($companyid) && $companyid==''){
                 $company_penj = '';
                 $company_byr = '';
             }
         }
         
         
		parent::actionDownPDF();
         $dataReader = array();
		$sql = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=1 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=1 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) ) as penj_jan, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=1 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jan,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=2 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=2 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_feb, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=2 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_feb,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=3 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=3 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_mar, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=3 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_mar,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=4 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=4 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_apr, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=4 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_apr,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=5 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=5 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_mei, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=5 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_mei,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=6 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=6 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_jun, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=6 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jun,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=7 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=7 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_jul, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=7 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jul,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=8 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=8 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_agus, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=8 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_agus,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=9 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=9 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_sept, 
                
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=9 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_sept,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=10 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=10 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_okt, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=10 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_okt,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=11 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=11 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_nov, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=11 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_nov,
                
               
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(aa.gidate)=12 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and month(c.gireturdate)=12 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_des, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and month(g1.docdate)=12 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_des,
                
                ((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join addressbook f on f.addressbookid = aaa.addressbookid
				where a.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader aaa on aaa.soheaderid=d.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where b.recordstatus=3 {$company_penj} and aaa.addressbookid=z.addressbookid and f.fullname like '%".$customer."%' and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))) as penj_total, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join addressbook d1 on d1.addressbookid = c1.addressbookid
                where g1.recordstatus=3  {$company_byr} and d1.fullname like '%".$customer."%' and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_total
                
                
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname like '%{$customer}%' and z.fullname is not null {$limit} ) zz 
                where penj_jan<>0 or byr_jan<>0 or penj_feb<>0 or byr_feb<>0 or penj_mar<>0 or byr_mar<>0 or penj_apr<>0 or byr_apr<>0 or penj_mei<>0 or byr_mei<>0 or penj_jun<>0 or byr_jun<>0 or penj_jul<>0 or byr_jul<>0 or penj_agus<>0 or byr_agus<>0 or penj_sept<>0 or byr_sept<>0 or penj_okt<>0 or byr_okt<>0 or penj_nov<>0 or byr_nov<>0 or penj_des<>0 or byr_des<>0 "; 
		      
            $command = Yii::app()->db->createCommand($sql);
            if($do_loop){
                if($companyid!==''){
                    $company = $companyid;
                    $command->bindvalue(':company',$company,PDO::PARAM_STR);
                    $dataReader[1]=$command->queryAll();
                    $l=1;
                }else{
                    $sqlcount = 'select count(companyid) from company';
                    $count = Yii::app()->db->createCommand($sqlcount)->queryScalar();
                    for($a=1; $a<=$count; $a++){
                        $company[$a] = $a;
                        $command->bindvalue(':company',$a,PDO::PARAM_INT);
                        $dataReader[$a]=$command->queryAll();
                    }
                    $l=$count;
                }
            }else{  
                if($companyid!==''){
                    $company[1] = $companyid;    
                }
                $command->bindvalue(':company',$companyid,PDO::PARAM_STR);
                $dataReader[1]=$command->queryAll();
                $l=1;
            }
			
            //$comamnd->queryAll();
			$i=0;$totaljual1=0;$totalbyr1=0;$totaljual2=0;$totalbyr2=0;$totaljual3=0;$totalbyr3=0;$totaljual4=0;             $totalbyr4=0;$totaljual5=0;$totalbyr5=0;$totaljual6=0;$totalbyr6=0;$totaljual7=0;$totalbyr7=0;$totaljual8=0;
            $totalbyr8=0;$totaljual9=0;$totalbyr9=0;$totaljual10=0;$totalbyr10=0;$totaljual11=0;$totalbyr11=0;$totaljual12=0;
            $totalbyr12=0;$totaljual=0;$totalbyr=0;
             
            //var_dump($dataReader[10]);
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penjualan VS Pelunasan Per Bulan Per Customer';
			$this->pdf->subtitle='Per Tahun '.date('Y', strtotime($startdate));
			$this->pdf->AddPage('P',array(500,150));
			$this->pdf->setY($this->pdf->getY()+2);
            //print_r($dataReader);
         
            for($j=1; $j<=$l; $j++){
            
                $this->pdf->setFont('Arial','B',10);
                $this->pdf->sety($this->pdf->gety()+0);
                if(isset($company[$j]) && $company!=''){
                    $companycode = $this->getCompanyCode($company[$j]);
                }else{
                    $companycode = 'GROUP';
                }
                $this->pdf->text(10,$this->pdf->getY(),'Perusahaan : '.$companycode);
                $this->pdf->setFont('Arial','B',8);
                $this->pdf->sety($this->pdf->gety()+3);
                $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,35,34,34,34,34,34,34,34,34,34,34,34,34,34));
                $this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
                $this->pdf->RowHeader();

                $this->pdf->sety($this ->pdf->gety()+0,5);
                $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
                $this->pdf->setwidths(array(10,35,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,20,20));
                $this->pdf->colheader = array('','','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar');
                if($j==1){
                    $this->pdf->RowHeader();   
                }
                $this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
                $this->pdf->setbordercell(array('TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB'));		
                $this->pdf->checkPageBreak(15);
                foreach($dataReader[$j] as $row)
                {
                    $this->pdf->setFont('Arial','',7);
                    $i=$i+1;
                    $this->pdf->row(array(
                        $i,$row['fullname'],
                        Yii::app()->format->formatNumberWODecimal($row['penj_jan']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jan']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_feb']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_feb']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_mar']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_mar']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_apr']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_apr']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_mei']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_mei']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_jun']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jun']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_jul']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jul']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_agus']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_agus']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_sept']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_sept']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_okt']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_okt']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_nov']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_nov']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_des']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_des']/$per),
                        Yii::app()->format->formatNumberWODecimal($row['penj_total']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_total']/$per)

                    ));

                    $totaljual1 += $row['penj_jan']/$per;
                    $totalbyr1 += $row['byr_jan']/$per;
                    $totaljual2 += $row['penj_feb']/$per;
                    $totalbyr2 += $row['byr_feb']/$per;
                    $totaljual3 += $row['penj_mar']/$per;
                    $totalbyr3 += $row['byr_mar']/$per;
                    $totaljual4 += $row['penj_apr']/$per;
                    $totalbyr4 += $row['byr_apr']/$per;
                    $totaljual5 += $row['penj_mei']/$per;
                    $totalbyr5 += $row['byr_mei']/$per;
                    $totaljual6 += $row['penj_jun']/$per;
                    $totalbyr6 += $row['byr_jun']/$per;
                    $totaljual7 += $row['penj_jul']/$per;
                    $totalbyr7 += $row['byr_jul']/$per;
                    $totaljual8 += $row['penj_agus']/$per;
                    $totalbyr8 += $row['byr_agus']/$per;
                    $totaljual9 += $row['penj_sept']/$per;
                    $totalbyr9 += $row['byr_sept']/$per;
                    $totaljual10 += $row['penj_okt']/$per;
                    $totalbyr10 += $row['byr_okt']/$per;
                    $totaljual11 += $row['penj_nov']/$per;
                    $totalbyr11 += $row['byr_nov']/$per;
                    $totaljual12 += $row['penj_des']/$per;
                    $totalbyr12 += $row['byr_des']/$per;
                    $totaljual += $row['penj_total']/$per;
                    $totalbyr += $row['byr_total']/$per;
                    $this->pdf->checkPageBreak(20);

                }
                $this->pdf->setY($this->pdf->getY()+5);
            }
                 
			$this->pdf->setFont('Arial','BI',10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,35,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,20,20));
			/*$this->pdf->colheader = array('','','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar');
            $this->pdf->RowHeader();*/
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');		
			$this->pdf->row(array(
					'','TOTAL',
                    Yii::app()->format->formatNumberWODecimal($totaljual1),
                    Yii::app()->format->formatNumberWODecimal($totalbyr1),
                    Yii::app()->format->formatNumberWODecimal($totaljual2),
                    Yii::app()->format->formatNumberWODecimal($totalbyr2),
                    Yii::app()->format->formatNumberWODecimal($totaljual3),
                    Yii::app()->format->formatNumberWODecimal($totalbyr3),
                    Yii::app()->format->formatNumberWODecimal($totaljual4),
                    Yii::app()->format->formatNumberWODecimal($totalbyr4),
                    Yii::app()->format->formatNumberWODecimal($totaljual5),
                    Yii::app()->format->formatNumberWODecimal($totalbyr5),
                    Yii::app()->format->formatNumberWODecimal($totaljual6),
                    Yii::app()->format->formatNumberWODecimal($totalbyr6),
                    Yii::app()->format->formatNumberWODecimal($totaljual7),
                    Yii::app()->format->formatNumberWODecimal($totalbyr7),
                    Yii::app()->format->formatNumberWODecimal($totaljual8),
                    Yii::app()->format->formatNumberWODecimal($totalbyr8),
                    Yii::app()->format->formatNumberWODecimal($totaljual9),
                    Yii::app()->format->formatNumberWODecimal($totalbyr9),
                    Yii::app()->format->formatNumberWODecimal($totaljual10),
                    Yii::app()->format->formatNumberWODecimal($totalbyr10),
                    Yii::app()->format->formatNumberWODecimal($totaljual11),
                    Yii::app()->format->formatNumberWODecimal($totalbyr11),
                    Yii::app()->format->formatNumberWODecimal($totaljual12),
                    Yii::app()->format->formatNumberWODecimal($totalbyr12),
                    Yii::app()->format->formatNumberWODecimal($totaljual),
                    Yii::app()->format->formatNumberWODecimal($totalbyr),
						
			));
                
			$this->pdf->Output();
      
      
	}
  //20
     public function RekapPiutangVSPelunasanPerBulanPerCustomer($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select * from
				(select z.fullname,
				(select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-01-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-01-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jan, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=1 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jan,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-02-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-02-01'))) zz where zz.addressbookid = z.addressbookid) as piu_feb, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=2 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_feb,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-03-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-03-01'))) zz where zz.addressbookid = z.addressbookid) as piu_mar, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=3 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_mar,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-04-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-04-01'))) zz where zz.addressbookid = z.addressbookid) as piu_apr, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=4 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_apr,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-05-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-05-01'))) zz where zz.addressbookid = z.addressbookid) as piu_mei, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=5 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_mei,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-06-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-06-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jun, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=6 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jun,
               
               
               (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-07-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-07-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jul, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=7 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jul,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-08-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-08-01'))) zz where zz.addressbookid = z.addressbookid) as piu_agus, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=8 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_agus,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-09-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-09-01'))) zz where zz.addressbookid = z.addressbookid) as piu_sept, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=9 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_sept,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-10-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-10-01'))) zz where zz.addressbookid = z.addressbookid) as piu_okt, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=10 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_okt,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-11-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-11-01'))) zz where zz.addressbookid = z.addressbookid) as piu_nov, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=11 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_nov,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-12-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-12-01'))) zz where zz.addressbookid = z.addressbookid) as piu_des, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=12 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_des,
                
                
				(select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' 
               ) zz where zz.addressbookid = z.addressbookid) as piu_total, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_total
                
					 
                
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz 
                
                where piu_jan<>0 or byr_jan<>0 or piu_feb<>0 or byr_feb<>0 or piu_mar<>0 or byr_mar<>0 or piu_apr<>0 or byr_apr<>0 or piu_mei<>0 or byr_mei<>0 or piu_jun<>0 or byr_jun<>0 or piu_jul<>0 or byr_jul<>0 or piu_agus<>0 or byr_agus<>0 or piu_sept<>0 or byr_sept<>0 or piu_okt<>0 or byr_okt<>0 or piu_nov<>0 or byr_nov<>0 or piu_des<>0 or byr_des<>0 "; 
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;$totalpiu1=0;$totalbyr1=0;$totalpiu2=0;$totalbyr2=0;$totalpiu3=0;$totalbyr3=0;$totalpiu4=0;             $totalbyr4=0;$totalpiu5=0;$totalbyr5=0;$totalpiu6=0;$totalbyr6=0;$totalpiu7=0;$totalbyr7=0;$totalpiu8=0;
            $totalbyr8=0;$totalpiu9=0;$totalbyr9=0;$totalpiu10=0;$totalbyr10=0;$totalpiu11=0;$totalbyr11=0;$totalpiu12=0;
            $totalbyr12=0;$totalpiu=0;$totalbyr=0;
             
						
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Piutang VS Pelunasan Per Bulan Per Customer';
			$this->pdf->subtitle='Per Tahun '.date('Y', strtotime($startdate));
			$this->pdf->AddPage('P',array(500,150));
			
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,35,34,34,34,34,34,34,34,34,34,34,34,34,34));
			$this->pdf->colheader = array('No','Customer','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember','Total');
			$this->pdf->RowHeader();
        
            $this->pdf->sety($this ->pdf->gety()+0,5);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,35,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,20,20));
			$this->pdf->colheader = array('','','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar','piutang','bayar');
            $this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
      $this->pdf->setbordercell(array('TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB'));
			
			foreach($dataReader as $row)
			{
				$this->pdf->setFont('Arial','',7);
				$i=$i+1;
				$this->pdf->row(array(
					$i,$row['fullname'],
					Yii::app()->format->formatNumberWODecimal($row['piu_jan']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jan']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_feb']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_feb']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_mar']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_mar']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_apr']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_apr']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_mei']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_mei']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_jun']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jun']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_jul']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_jul']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_agus']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_agus']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_sept']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_sept']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_okt']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_okt']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_nov']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_nov']/$per),
					Yii::app()->format->formatNumberWODecimal($row['piu_des']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_des']/$per),
                    Yii::app()->format->formatNumberWODecimal($row['piu_total']/$per),Yii::app()->format->formatNumberWODecimal($row['byr_total']/$per)
                   
				));
              
              
              $totalpiu1 += $row['piu_jan']/$per;
              $totalbyr1 += $row['byr_jan']/$per;
              $totalpiu2 += $row['piu_feb']/$per;
              $totalbyr2 += $row['byr_feb']/$per;
              $totalpiu3 += $row['piu_mar']/$per;
              $totalbyr3 += $row['byr_mar']/$per;
              $totalpiu4 += $row['piu_apr']/$per;
              $totalbyr4 += $row['byr_apr']/$per;
              $totalpiu5 += $row['piu_mei']/$per;
              $totalbyr5 += $row['byr_mei']/$per;
              $totalpiu6 += $row['piu_jun']/$per;
              $totalbyr6 += $row['byr_jun']/$per;
              $totalpiu7 += $row['piu_jul']/$per;
              $totalbyr7 += $row['byr_jul']/$per;
              $totalpiu8 += $row['piu_agus']/$per;
              $totalbyr8 += $row['byr_agus']/$per;
              $totalpiu9 += $row['piu_sept']/$per;
              $totalbyr9 += $row['byr_sept']/$per;
              $totalpiu10 += $row['piu_okt']/$per;
              $totalbyr10 += $row['byr_okt']/$per;
              $totalpiu11 += $row['piu_nov']/$per;
              $totalbyr11 += $row['byr_nov']/$per;
              $totalpiu12 += $row['piu_des']/$per;
              $totalbyr12 += $row['byr_des']/$per;
              $totalpiu12 += $row['piu_total']/$per;
              $totalbyr12 += $row['byr_total']/$per;
              
              
              $this->pdf->checkPageBreak(20);
              }
      
      
              
				
				
                 
			$this->pdf->setFont('Arial','BI',10);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,35,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,17,20,20));
			/*$this->pdf->colheader = array('','','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar','jual','bayar');
            $this->pdf->RowHeader();*/
			$this->pdf->coldetailalign = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');		
			$this->pdf->row(array(
					'','TOTAL',
                    Yii::app()->format->formatNumberWODecimal($totalpiu1),
                    Yii::app()->format->formatNumberWODecimal($totalbyr1),
                    Yii::app()->format->formatNumberWODecimal($totalpiu2),
                    Yii::app()->format->formatNumberWODecimal($totalbyr2),
                    Yii::app()->format->formatNumberWODecimal($totalpiu3),
                    Yii::app()->format->formatNumberWODecimal($totalbyr3),
                    Yii::app()->format->formatNumberWODecimal($totalpiu4),
                    Yii::app()->format->formatNumberWODecimal($totalbyr4),
                    Yii::app()->format->formatNumberWODecimal($totalpiu5),
                    Yii::app()->format->formatNumberWODecimal($totalbyr5),
                    Yii::app()->format->formatNumberWODecimal($totalpiu6),
                    Yii::app()->format->formatNumberWODecimal($totalbyr6),
                    Yii::app()->format->formatNumberWODecimal($totalpiu7),
                    Yii::app()->format->formatNumberWODecimal($totalbyr7),
                    Yii::app()->format->formatNumberWODecimal($totalpiu8),
                    Yii::app()->format->formatNumberWODecimal($totalbyr8),
                    Yii::app()->format->formatNumberWODecimal($totalpiu9),
                    Yii::app()->format->formatNumberWODecimal($totalbyr9),
                    Yii::app()->format->formatNumberWODecimal($totalpiu10),
                    Yii::app()->format->formatNumberWODecimal($totalbyr10),
                    Yii::app()->format->formatNumberWODecimal($totalpiu11),
                    Yii::app()->format->formatNumberWODecimal($totalbyr11),
                    Yii::app()->format->formatNumberWODecimal($totalpiu12),
                    Yii::app()->format->formatNumberWODecimal($totalbyr12),
                    Yii::app()->format->formatNumberWODecimal($totalpiu),
                    Yii::app()->format->formatNumberWODecimal($totalbyr)
                   
						
			));
       
       
			$this->pdf->Output();
      
      
	}
    
    public function test(){
        
        //echo 'as';
        parent::actionDownPDF();
        $res = array();
        $sql = 'select * from company where companyid = :companyid';
        $command = Yii::app()->db->createCommand($sql);
        $new = 1;
        $command->bindvalue(':companyid',$new);
        //$res = $command->exec();
        $res[1] = $command->queryAll();
        $new = 2;
        $command->bindvalue(':companyid',$new);
        //$res = $command->exec();
        $res[2] = $command->queryAll();
        foreach($res[1] as $row){
            echo $row['companycode'];
        }
        foreach($res[2] as $row){
            echo $row['companycode'];
        }
        
        //var_dump($res1);
        //var_dump($res);
        
    }
	
	
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['materialgroup']) && isset($_GET['customer']) && isset($_GET['product']) && isset($_GET['sales']) && isset($_GET['salesarea']) && isset($_GET['umurpiutang']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 99)
			{
				$this->RincianFakturdanReturJualBelumLunasGabunganXLS($_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 1)
			{
				$this->RincianPelunasanPiutangPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 2)
			{
				$this->RekapPelunasanPiutangPerDivisiXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 3)
			{
				$this->KartuPiutangDagangXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 4)
			{
				$this->RekapPiutangDagangPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 5)
			{
				$this->RincianFakturdanReturJualBelumLunasXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['umurpiutang'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RincianUmurPiutangDagangPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RekapUmurPiutangDagangPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RincianFakturdanReturJualBelumLunasPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RekapKontrolPiutangCustomervsPlafonXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RincianKontrolPiutangCustomervsPlafonXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->KonfirmasiPiutangDagangXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
				$this->RekapInvoiceARPerDokumenBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 13)
			{
				$this->RekapNotaReturPenjualanPerDokumenBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 14)
			{
				$this->RekapPelunasanPiutangPerDokumenBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 15)
			{
				$this->RincianPelunasanPiutangPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 16)
			{
				$this->RekapPelunasanPiutangPerSalesXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 17)
			{
				$this->RincianPelunasanPiutangPerSalesPerJenisBarangXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 18)
			{
				$this->RekapPelunasanPiutangPerSalesPerJenisBarangXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
      else
      if ($_GET['lro'] == 19)
			{
				$this->RekapPenjualanVSPelunasanPerBulanPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
      else
      if ($_GET['lro'] == 20)
			{
				$this->RekapPiutangVSPelunasanPerBulanPerCustomerXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['sales'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	//99
	public function RincianFakturdanReturJualBelumLunasGabunganXLS($sloc,$materialgroup,$customer,$product,$sales,$umurpiutang,$startdate,$enddate,$per)			
	{
		$this->menuname='rincianfakturdanreturjualbelumlunasgabungan';
		parent::actionDownxls();
		$nilaitot1=0;$dibayar1=0; $sisa1=0;
		$sql = "select distinct addressbookid,fullname
					from (select d.addressbookid,d.fullname,a.amount,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid
					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					";
					if ($_GET['umurpiutang'] !== '') 
					{
							$sql = $sql . "and  umur > ".$_GET['umurpiutang']." order by fullname";
					}
					else 
					{
							$sql = $sql . "order by fullname";
					}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,'Gabungan');
		$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
				->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
				
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
				->setCellValueByColumnAndRow(2,$line,'Tanggal')					
				->setCellValueByColumnAndRow(3,$line,'J_Tempo')
				->setCellValueByColumnAndRow(4,$line,'Umur')
				->setCellValueByColumnAndRow(5,$line,'UT')
				->setCellValueByColumnAndRow(6,$line,'Nilai')
				->setCellValueByColumnAndRow(7,$line,'Kum_Bayar')
				->setCellValueByColumnAndRow(8,$line,'Sisa')
				->setCellValueByColumnAndRow(9,$line,'Sales');
			$line++;
			$sql1 = " select *, (amount-payamount) as sisa,(amount) as nilai
							from (select a.invoiceno,a.invoicedate,e.paydays,
							date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
							datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
							datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,ff.fullname as sales,
							ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
							from cutarinv f
							join cutar g on g.cutarid=f.cutarid
							where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,c.companyid
							from invoice a
							inner join giheader b on b.giheaderid = a.giheaderid
							inner join soheader c on c.soheaderid = b.soheaderid
							inner join addressbook d on d.addressbookid = c.addressbookid
							inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
							inner join employee ff on ff.employeeid = c.employeeid

							where d.fullname like '%".$customer."%' and ff.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null
							and d.addressbookid = '".$row['addressbookid']."'						
							and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
							where amount > payamount
							";
							if ($_GET['umurpiutang'] !== '') 
							{
									$sql1 = $sql1 . "and  umur > ".$_GET['umurpiutang']." order by umurtempo asc,invoiceno";
							}
							else 
							{
									$sql1 = $sql1 . "order by umurtempo asc,invoiceno";
							}
					
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$nilaitot=0;$dibayar=0; $sisa=0;            
							 
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
					->setCellValueByColumnAndRow(2,$line,$row1['invoicedate'])
					->setCellValueByColumnAndRow(3,$line,$row1['jatuhtempo'])
					->setCellValueByColumnAndRow(4,$line,$row1['umur'])
					->setCellValueByColumnAndRow(5,$line,$row1['umurtempo'])
					->setCellValueByColumnAndRow(6,$line,($row1['nilai']/$per))							
					->setCellValueByColumnAndRow(7,$line,($row1['payamount']/$per))					
					->setCellValueByColumnAndRow(8,$line,(($row1['nilai']/$per)-($row1['payamount']/$per)))
					->setCellValueByColumnAndRow(9,$line,$row1['sales']);
				$line++;
				$nilaitot += $row1['nilai']/$per;
				$dibayar += $row1['payamount']/$per;
				$sisa += (($row1['nilai']/$per)-($row1['payamount']/$per));
	
				
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'Total')										
				->setCellValueByColumnAndRow(6,$line,($nilaitot))
				->setCellValueByColumnAndRow(7,$line,($dibayar))
				->setCellValueByColumnAndRow(8,$line,($sisa));
			$line++;
			$nilaitot1 += $nilaitot;
			$dibayar1 += $dibayar;
			$sisa1 += $sisa;
			$line += 1;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL')										
			->setCellValueByColumnAndRow(6,$line,($nilaitot1))
			->setCellValueByColumnAndRow(7,$line,($dibayar1))
			->setCellValueByColumnAndRow(8,$line,($sisa1));
		$line++;
			
		$this->getFooterXLS($this->phpExcel);
	}	
	//1
	public function RincianPelunasanPiutangPerDokumenXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rincianpelunasanpiutangperdokumen';
		parent::actionDownxls();
		$totalsaldo2=0;$totaltunai2=0;$totalbank2=0;$totaldiskon2=0;$totalretur2=0;$totalob2=0;$totaljumlah2=0;$totalsisa2=0;
		$sql = "select distinct a.cutarid,a.cutarno,a.docdate as cutardate,c.docno as ttntno,c.docdate as ttntdate,b.companyid
						from cutar a
						join company b on b.companyid = a.companyid
						join ttnt c on c.ttntid = a.ttntid
						join cutarinv d on d.cutarid = a.cutarid
						join invoice e on e.invoiceid = d.invoiceid
						join giheader f on f.giheaderid = e.giheaderid
						join soheader g on g.soheaderid = f.soheaderid						
						left join employee h on h.employeeid = g.employeeid
						join addressbook i on i.addressbookid = g.addressbookid
						where i.fullname like '%".$customer."%' and h.fullname like '%".$sales."%' and a.cutarno is not null and a.companyid = ".$companyid." and 
						a.recordstatus=3 and
						a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))

												
							->setCellValueByColumnAndRow(3,1,$this->GetCompanyCode($companyid));
							$line=4;				
						foreach($dataReader as $row)
						{
							//$this->phpExcel->getActiveSheet()->getStyle(1,$line)->getFont()->setBold(true);
							
								$this->phpExcel->setActiveSheetIndex(0)
							        ->setCellValueByColumnAndRow(0,$line,'No:')
									->setCellValueByColumnAndRow(1,$line,$row['cutarno'])
									->setCellValueByColumnAndRow(2,$line,'TTNT:')
									->setCellValueByColumnAndRow(3,$line,$row['ttntno']);														
									$line++;
									
							 $this->phpExcel->setActiveSheetIndex(0)
							        ->setCellValueByColumnAndRow(0,$line,'Tgl :')
									->setCellValueByColumnAndRow(1,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['cutardate'])))
									->setCellValueByColumnAndRow(2,$line,'Tgl :')
									->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));														
									$line++;
									
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'No')
									->setCellValueByColumnAndRow(1,$line,'No. Invoice')
									->setCellValueByColumnAndRow(2,$line,'Customer')					
									->setCellValueByColumnAndRow(3,$line,'Tgl Invoice')
									->setCellValueByColumnAndRow(4,$line,'Saldo Invoice')
									->setCellValueByColumnAndRow(5,$line,'Tunai')
									->setCellValueByColumnAndRow(6,$line,'Bank')
									->setCellValueByColumnAndRow(7,$line,'Diskon')
									->setCellValueByColumnAndRow(8,$line,'Retur')
									->setCellValueByColumnAndRow(9,$line,'OB')
									->setCellValueByColumnAndRow(10,$line,'Jumlah')
									->setCellValueByColumnAndRow(11,$line,'Sisa');
							$line++;
							$sql1 = "select*,(saldo-(tunai+bank+diskon+retur+ob)) as sisa
						from(select f.fullname,c.invoiceno,c.invoicedate,sum(saldoinvoice)as saldo,sum(cashamount) as tunai,sum(a.bankamount) as bank,sum(a.discamount) as diskon,sum(a.returnamount) as retur,sum(a.obamount) as ob,
						sum(cashamount)+sum(a.bankamount)+sum(a.discamount)+sum(a.returnamount)+sum(a.obamount) as jumlah
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid = a.invoiceid
						join giheader d on d.giheaderid = c.giheaderid
						join soheader e on e.soheaderid= d.soheaderid
						join addressbook f on f.addressbookid = e.addressbookid						
						left join employee g on g.employeeid = e.employeeid
						where f.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3 and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						and a.cutarid = ".$row['cutarid']."
						group by invoiceno)z
						";

                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $i=0;$totalsaldo=0;$totaltunai=0;$totalbank=0;$totaldiskon=0;$totalretur=0;$totalob=0;$totaljumlah=0;$totalsisa=0;									
								foreach($dataReader1 as $row1)
								{
									$i+=1;
									$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,$i)
								->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
								->setCellValueByColumnAndRow(2,$line,$row1['fullname'])
								->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])))
								->setCellValueByColumnAndRow(4,$line,($row1['saldo']/$per))
								->setCellValueByColumnAndRow(5,$line,($row1['tunai']/$per))					
								->setCellValueByColumnAndRow(6,$line,($row1['bank']/$per))					
							    ->setCellValueByColumnAndRow(7,$line,($row1['diskon']/$per))
								->setCellValueByColumnAndRow(8,$line,($row1['retur']/$per))
								->setCellValueByColumnAndRow(9,$line,($row1['ob']/$per))
								->setCellValueByColumnAndRow(10,$line,($row1['jumlah']/$per))
								->setCellValueByColumnAndRow(11,$line,($row1['sisa']/$per));
									$line++;
									$totalsaldo += $row1['saldo']/$per;
									$totaltunai += $row1['tunai']/$per;
									$totalbank += $row1['bank']/$per;
                  					$totaldiskon += $row1['diskon']/$per;
                  					$totalretur += $row1['retur']/$per;
									$totalob += $row1['ob']/$per;
									$totaljumlah += $row1['jumlah']/$per;
									$totalsisa += $row1['sisa']/$per;
								}
								$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'Total')										
										->setCellValueByColumnAndRow(4,$line,($totalsaldo))
										->setCellValueByColumnAndRow(5,$line,($totaltunai))
										->setCellValueByColumnAndRow(6,$line,($totalbank))
										->setCellValueByColumnAndRow(7,$line,($totaldiskon))
										->setCellValueByColumnAndRow(8,$line,($totalretur))
										->setCellValueByColumnAndRow(9,$line,($totalob))
										->setCellValueByColumnAndRow(10,$line,($totaljumlah))
										->setCellValueByColumnAndRow(11,$line,($totalsisa));
								$line++;
									$totalsaldo2 += $totalsaldo;
									$totaltunai2 += $totaltunai;
									$totalbank2 += $totalbank;
                  					$totaldiskon2 += $totaldiskon;
                  					$totalretur2 += $totalretur;
									$totalob2 += $totalob;
									$totaljumlah2 += $totaljumlah;
									$totalsisa2 += $totalsisa;
								$line += 1;
						}
						$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'Grand Total')										
										->setCellValueByColumnAndRow(4,$line,($totalsaldo2))
										->setCellValueByColumnAndRow(5,$line,($totaltunai2))
										->setCellValueByColumnAndRow(6,$line,($totalbank2))
										->setCellValueByColumnAndRow(7,$line,($totaldiskon2))
										->setCellValueByColumnAndRow(8,$line,($totalretur2))
										->setCellValueByColumnAndRow(9,$line,($totalob2))
										->setCellValueByColumnAndRow(10,$line,($totaljumlah2))
										->setCellValueByColumnAndRow(11,$line,($totalsisa2));
								$line++;
		
		
		$this->getFooterXLS($this->phpExcel);
	}
	//2
	public function RekapPelunasanPiutangPerDivisiXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekappelunasanpiutangperdivisi';
		parent::actionDownxls();
		$sql ="select distinct a.cutarid, sum(cashamount) as tunai,sum(a.bankamount) as bank,sum(a.discamount) as diskon,sum(a.returnamount) as retur,sum(a.obamount) as ob,
				sum(cashamount)+sum(a.bankamount)+sum(a.discamount)+sum(a.returnamount)+sum(a.obamount) as jumlah,
				(select xx.description from materialgroup xx 
				join productplant zz on zz.materialgroupid = xx.materialgroupid
				join sodetail yy on yy.productid = zz.productid
				where yy.soheaderid = e.soheaderid limit 1
				) as materialgroupname
				from cutarinv a
				join cutar b on b.cutarid=a.cutarid
				join invoice c on c.invoiceid=a.invoiceid
				join giheader d on d.giheaderid = c.giheaderid
				join soheader e on e.soheaderid = d.soheaderid 
				join employee f on f.employeeid = e.employeeid
				join addressbook g on g.addressbookid = e.addressbookid
				where b.companyid = ".$companyid." and g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
				and b.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				group by materialgroupname";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))							
							->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
							$line=4;
			$i=0;$totaltunai=0;$totalbank=0; $totaldiskon=0;$totalretur=0;$totalob=0;$totaljumlah=0;		
					
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'No')
									->setCellValueByColumnAndRow(1,$line,'Devisi/Jenis')
									->setCellValueByColumnAndRow(2,$line,'Tunai')								
									->setCellValueByColumnAndRow(3,$line,'Bank')
									->setCellValueByColumnAndRow(4,$line,'Diskon')
									->setCellValueByColumnAndRow(5,$line,'Retur')
									->setCellValueByColumnAndRow(6,$line,'PDMK/OB')
									->setCellValueByColumnAndRow(7,$line,'Jumlah');
							$line++;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['materialgroupname'])						
						->setCellValueByColumnAndRow(2,$line,($row['tunai']/$per))
						->setCellValueByColumnAndRow(3,$line,($row['bank']/$per))							
						->setCellValueByColumnAndRow(4,$line,($row['diskon']/$per))					
						->setCellValueByColumnAndRow(5,$line,($row['retur']/$per))
						->setCellValueByColumnAndRow(6,$line,($row['ob']/$per))
						->setCellValueByColumnAndRow(7,$line,($row['jumlah']/$per));
					$line++;
					$totaltunai += $row['tunai']/$per;
					$totalbank += $row['bank']/$per;
          			$totaldiskon += $row['diskon']/$per;
					$totalretur += $row['retur']/$per;
					$totalob += $row['ob']/$per;
					$totaljumlah += $row['jumlah']/$per;
					
			}
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'Total')										
										->setCellValueByColumnAndRow(2,$line,($totaltunai))
										->setCellValueByColumnAndRow(3,$line,($totalbank))
										->setCellValueByColumnAndRow(4,$line,($totaldiskon))
										->setCellValueByColumnAndRow(5,$line,($totalretur))
										->setCellValueByColumnAndRow(6,$line,($totalob))
										->setCellValueByColumnAndRow(7,$line,($totaljumlah));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	//3
	public function KartuPiutangDagangXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='kartupiutangdagang';
		parent::actionDownxls();
		$penambahan1=0;$tunai1=0;$bank1=0;$diskon1=0;$retur1=0;$ob1=0;$saldo1=0;     
            
		$sql = "select *
						from (select a.fullname,a.addressbookid,
						ifnull((select sum(ifnull(b.amount,0)-ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '".$customer."' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."	and b.invoicedate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and f.addressbookid=a.addressbookid),0) as saldo,
						ifnull((select sum(ifnull(h.amount,0))
						from invoice h
						join giheader i on i.giheaderid=h.giheaderid
						join soheader j on j.soheaderid=i.soheaderid
						join employee k on k.employeeid = j.employeeid
						join addressbook l on l.addressbookid = j.addressbookid
						where l.fullname like '%".$customer."%' and k.fullname like '%".$sales."%' and h.recordstatus=3
						and j.companyid=".$companyid." and j.addressbookid=a.addressbookid
						and h.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as piutang,
						ifnull((select sum(ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."
						and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and f.addressbookid=a.addressbookid),0) as dibayar
						from addressbook a
						where a.fullname like '%".$customer."%') z
						where z.saldo<>0 or z.piutang<>0 or z.dibayar<>0
						order by fullname";
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
				->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;	
									
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Dokumen')
				->setCellValueByColumnAndRow(1,$line,'Tanggal')
				->setCellValueByColumnAndRow(2,$line,'U/ Byr INV')					
				->setCellValueByColumnAndRow(3,$line,'Penambahan')
				->setCellValueByColumnAndRow(4,$line,'Tunai')
				->setCellValueByColumnAndRow(5,$line,'Bank')
				->setCellValueByColumnAndRow(6,$line,'Diskon')
				->setCellValueByColumnAndRow(7,$line,'Retur')
				->setCellValueByColumnAndRow(8,$line,'OB')
				->setCellValueByColumnAndRow(9,$line,'Saldo');
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Saldo Awal')
				->setCellValueByColumnAndRow(9,$line,($row['saldo']/$per));
			$line++;
			
			$penambahan=0;$tunai=0;$bank=0;$diskon=0;$retur=0;$ob=0;
			$sql2 = "select * from
				(select distinct a.invoiceno as dokumen,a.invoicedate as tanggal,'-' as ref,a.amount as penambahan,'0' as tunai,'0' as bank,'0' as diskon,'0' as retur,'0' as ob
				from invoice a
				left join giheader b on b.giheaderid = a.giheaderid
				left join soheader c on c.soheaderid = b.soheaderid
				left join cbarinv d on d.invoiceid = a.invoiceid
				join employee e on e.employeeid = c.employeeid
				join addressbook f on f.addressbookid = c.addressbookid
				where f.fullname like '%".$customer."%' and c.companyid = ".$companyid." and a.recordstatus = 3 and a.invoiceno is not null and
				c.addressbookid = ".$row['addressbookid']." and
				a.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					union
				select d.cutarno as dokumen,d.docdate as tanggal,g.invoiceno as ref,'0' as penambahan,ifnull(c.cashamount,0) as tunai,ifnull(c.bankamount,0) as bank,ifnull(c.discamount,0) as diskon,
				ifnull(c.returnamount,0) as retur,ifnull(c.obamount,0) as ob
				from cutarinv c
				join cutar d on d.cutarid=c.cutarid
				join invoice g on g.invoiceid=c.invoiceid
				left join giheader h on h.giheaderid = g.giheaderid
				left join soheader i on i.soheaderid = h.soheaderid
				join addressbook j on j.addressbookid = i.addressbookid
				join employee k on k.employeeid = i.employeeid
				where d.recordstatus=3
				and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and c.invoiceid in (select b.invoiceid
				from invoice b
				join giheader e on e.giheaderid=b.giheaderid
				join soheader f on f.soheaderid=e.soheaderid
				join employee g on g.employeeid = f.employeeid
				join addressbook h on h.addressbookid = f.addressbookid
				where h.fullname like '".$customer."' and g.fullname like '%".$sales."%' and b.recordstatus=3
				and f.companyid=".$companyid." and f.addressbookid = ".$row['addressbookid']."
				and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
				) z
				order by tanggal,dokumen";
			$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();            
							
			foreach($dataReader2 as $row2)
			{
					
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$row2['dokumen'])
					->setCellValueByColumnAndRow(1,$line,$row2['tanggal'])
					->setCellValueByColumnAndRow(2,$line,$row2['ref'])							
					->setCellValueByColumnAndRow(3,$line,($row2['penambahan']/$per))					
					->setCellValueByColumnAndRow(4,$line,($row2['tunai']/$per))
					->setCellValueByColumnAndRow(5,$line,($row2['bank']/$per))
					->setCellValueByColumnAndRow(6,$line,($row2['diskon']/$per))
					->setCellValueByColumnAndRow(7,$line,($row2['retur']/$per))
					->setCellValueByColumnAndRow(8,$line,($row2['ob']/$per));
				$line++;
				$penambahan += $row2['penambahan']/$per;
				$tunai += $row2['tunai']/$per;
				$bank += $row2['bank']/$per;
				$diskon += $row2['diskon']/$per;
				$retur += $row2['retur']/$per;
				$ob += $row2['ob']/$per; 
					
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total '.$row['fullname'])
				->setCellValueByColumnAndRow(3,$line,($penambahan))
				->setCellValueByColumnAndRow(4,$line,($tunai))
				->setCellValueByColumnAndRow(5,$line,($bank))
				->setCellValueByColumnAndRow(6,$line,($diskon))
				->setCellValueByColumnAndRow(7,$line,($retur))
				->setCellValueByColumnAndRow(8,$line,($ob))
				->setCellValueByColumnAndRow(9,$line,(($row['saldo']/$per)+$penambahan-$tunai-$bank-$diskon-$retur-$ob));
			$line++;
			$penambahan1 += $penambahan;
			$tunai1 += $tunai;
			$bank1 += $bank;
			$diskon1 += $diskon;
			$retur1 += $retur;
			$ob1 += $ob;
			$saldo1 += $row['saldo']/$per;
			$line += 1;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'Grand Total')
			->setCellValueByColumnAndRow(2,$line,($saldo1))
			->setCellValueByColumnAndRow(3,$line,($penambahan1))
			->setCellValueByColumnAndRow(4,$line,($tunai1))
			->setCellValueByColumnAndRow(5,$line,($bank1))
			->setCellValueByColumnAndRow(6,$line,($diskon1))
			->setCellValueByColumnAndRow(7,$line,($retur1))
			->setCellValueByColumnAndRow(8,$line,($ob1))
			->setCellValueByColumnAndRow(9,$line,($saldo1+$penambahan1-$tunai1-$bank1-$diskon1-$retur1-$ob1));
		$line++;
	
		$this->getFooterXLS($this->phpExcel);
	}	
	//4
	public function RekapPiutangDagangPerCustomerXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekappiutangdagangpercustomer';
		parent::actionDownxls();
		
		$sql = 	"select *
						from (select a.fullname,
						ifnull((select sum(ifnull(b.amount,0)-ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						join invoice e on e.invoiceid = c.invoiceid
						join giheader f on f.giheaderid = e.giheaderid
						join soheader g on g.soheaderid = f.soheaderid
						join employee h on h.employeeid = g.employeeid
						join addressbook i on i.addressbookid = g.addressbookid
						where i.fullname like '%".$customer."%' and h.fullname like '%".$sales."%' and d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."	and b.invoicedate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and f.addressbookid=a.addressbookid),0) as saldoawal,
						ifnull((select sum(ifnull(h.amount,0))
						from invoice h
						join giheader i on i.giheaderid=h.giheaderid
						join soheader j on j.soheaderid=i.soheaderid
						join employee k on k.employeeid = j.employeeid
						join addressbook l on l.addressbookid = j.addressbookid					
						where l.fullname like '%".$customer."%' and k.fullname like '%".$sales."%' and h.recordstatus=3
						and j.companyid=".$companyid." and j.addressbookid=a.addressbookid
						and h.invoicedate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as piutang,
						ifnull((select sum(ifnull((select sum((ifnull(c.cashamount,0)+ifnull(c.bankamount,0)+ifnull(c.discamount,0)+ifnull(c.returnamount,0)+ifnull(c.obamount,0))*ifnull(c.currencyrate,0))
						from cutarinv c
						join cutar d on d.cutarid=c.cutarid
						where d.recordstatus=3 and c.invoiceid=b.invoiceid and d.companyid=".$companyid."
						and d.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0))
						from invoice b
						join giheader e on e.giheaderid=b.giheaderid
						join soheader f on f.soheaderid=e.soheaderid
						join employee g on g.employeeid = f.employeeid
						join addressbook h on h.addressbookid = f.addressbookid
						where h.fullname like '%".$customer."%' and g.fullname like '%".$sales."%' and b.recordstatus=3
						and f.companyid=".$companyid."
						and b.invoicedate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and f.addressbookid=a.addressbookid),0) as dibayar
						from addressbook a
						where a.fullname like '%".$customer."%') z
						where z.saldoawal<>0 or z.piutang<>0 or z.dibayar<>0
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
							$line=4;
$this->phpExcel->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold(true);
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Customer')
						->setCellValueByColumnAndRow(2,$line,'Saldo Awal')					
						->setCellValueByColumnAndRow(3,$line,'Piutang')
						->setCellValueByColumnAndRow(4,$line,'Dibayar')
						->setCellValueByColumnAndRow(5,$line,'Saldo Akhir');
					$line++;
					
				$i=0;$saldoawal=0;$piutang=0;$dibayar=0;$saldoakhir=0;				
								
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row['fullname'])
							->setCellValueByColumnAndRow(2,$line,($row['saldoawal']/$per))							
							->setCellValueByColumnAndRow(3,$line,($row['piutang']/$per))					
							->setCellValueByColumnAndRow(4,$line,($row['dibayar']/$per))
							->setCellValueByColumnAndRow(5,$line,(($row['saldoawal'] + $row['piutang'] - $row['dibayar'])/$per));
							$line++;
							$saldoawal += $row['saldoawal']/$per;
							$piutang += $row['piutang']/$per;
							$dibayar += $row['dibayar']/$per;
							$saldoakhir += ($row['saldoawal'] + $row['piutang'] - $row['dibayar'])/$per;	
							
		}
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,$line,'TOTAL')
						->setCellValueByColumnAndRow(2,$line,($saldoawal))
						->setCellValueByColumnAndRow(3,$line,($piutang))
						->setCellValueByColumnAndRow(4,$line,($dibayar))
						->setCellValueByColumnAndRow(5,$line,($saldoakhir));
						$line++;
						$line += 1;
		$this->getFooterXLS($this->phpExcel);
	}	
	//5
	public function RincianFakturdanReturJualBelumLunasXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$umurpiutang,$startdate,$enddate,$per)			
	{
		//$_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['customer'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']
		$this->menuname='rincianfakturdanreturjualbelumlunas';
		parent::actionDownxls();
		$nilaitot1=0;$dibayar1=0; $sisa1=0;
		$sql = "select distinct addressbookid,fullname,lat,lng
					from (select d.addressbookid,d.fullname,a.amount,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,(select round(h.lat,6) from address h where h.addressbookid=d.addressbookid Limit 1) as lat,(select round(h.lng,6) from address h where h.addressbookid=d.addressbookid Limit 1) as lng
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid

					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					";
					if ($_GET['umurpiutang'] !== '') 
					{
							$sql = $sql . "and  umur > ".$_GET['umurpiutang']." order by fullname";
					}
					else 
					{
							$sql = $sql . "order by fullname";
					}
         $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
      foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
							$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)						
						->setCellValueByColumnAndRow(0,$line,$row['fullname'])
						->setCellValueByColumnAndRow(8,$line,'Koordinat:')
						->setCellValueByColumnAndRow(9,$line,$row['lat'].','.$row['lng']);
					$line++;
					
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
						->setCellValueByColumnAndRow(2,$line,'Tanggal')					
						->setCellValueByColumnAndRow(3,$line,'J_Tempo')
						->setCellValueByColumnAndRow(4,$line,'Umur')
						->setCellValueByColumnAndRow(5,$line,'UT')
						->setCellValueByColumnAndRow(6,$line,'Nilai')
						->setCellValueByColumnAndRow(7,$line,'Kum_Bayar')
						->setCellValueByColumnAndRow(8,$line,'Sisa')
						->setCellValueByColumnAndRow(9,$line,'Sales');
					$line++;
					$sql1 = " select *, (amount-payamount) as sisa,(amount) as nilai
												from (select a.invoiceno,a.invoicedate,e.paydays,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,ff.fullname as sales,
												ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
												from invoice a
												inner join giheader b on b.giheaderid = a.giheaderid
												inner join soheader c on c.soheaderid = b.soheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												inner join employee ff on ff.employeeid = c.employeeid

												where d.fullname like '%".$customer."%' and ff.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
												and d.addressbookid = '".$row['addressbookid']."'						
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where amount > payamount
												";
												if ($_GET['umurpiutang'] !== '') 
												{
														$sql1 = $sql1 . "and  umur > ".$_GET['umurpiutang']." order by umurtempo";
												}
												else 
												{
														$sql1 = $sql1 . "order by umurtempo";
												}
						
								$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
								$i=0;$nilaitot=0;$dibayar=0; $sisa=0;            
                 
								foreach($dataReader1 as $row1)
								{
									$i+=1;
									$this->phpExcel->setActiveSheetIndex(0)
											->setCellValueByColumnAndRow(0,$line,$i)
											->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
											->setCellValueByColumnAndRow(2,$line,$row1['invoicedate'])
											->setCellValueByColumnAndRow(3,$line,$row1['jatuhtempo'])
											->setCellValueByColumnAndRow(4,$line,$row1['umur'])
											->setCellValueByColumnAndRow(5,$line,$row1['umurtempo'])
											->setCellValueByColumnAndRow(6,$line,($row1['nilai']/$per))							
											->setCellValueByColumnAndRow(7,$line,($row1['payamount']/$per))					
											->setCellValueByColumnAndRow(8,$line,(($row1['nilai']/$per)-($row1['payamount']/$per)))
											->setCellValueByColumnAndRow(9,$line,$row1['sales']);
									$line++;
									$nilaitot += $row1['nilai']/$per;
                  $dibayar += $row1['payamount']/$per;
                  $sisa += (($row1['nilai']/$per)-($row1['payamount']/$per));
						
									
								}
								$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(3,$line,'Total')										
										->setCellValueByColumnAndRow(6,$line,($nilaitot))
										->setCellValueByColumnAndRow(7,$line,($dibayar))
										->setCellValueByColumnAndRow(8,$line,($sisa));
								$line++;
								$nilaitot1 += $nilaitot;
								$dibayar1 += $dibayar;
								$sisa1 += $sisa;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL')										
										->setCellValueByColumnAndRow(6,$line,($nilaitot1))
										->setCellValueByColumnAndRow(7,$line,($dibayar1))
										->setCellValueByColumnAndRow(8,$line,($sisa1));
								$line++;
			
		$this->getFooterXLS($this->phpExcel);
	}	
	//6
	public function RincianUmurPiutangDagangPerCustomerXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rincianumurpiutangdagangpercustomer';
		parent::actionDownxls();
		$total2sd0=0;$total20sd30=0;$total231sd60=0;$total261sd90=0;$total291sd120=0;$total2sd120=0;$totaltempo2=0;$total2=0;
		$sql ="select distinct addressbookid,fullname
					from (select d.addressbookid,d.fullname,a.amount,
					ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
						from cutarinv o
						join cutar p on p.cutarid=o.cutarid
						where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid
					where e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount order by fullname";
								
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            foreach($dataReader as $row)
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))							
							->setCellValueByColumnAndRow(9,1,$this->GetCompanyCode($companyid));
							$line=4;				
						foreach($dataReader as $row)
						{
							$this->phpExcel->getActiveSheet()->getStyle(1,$line)->getFont()->setBold(true);
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'Customer')
									->setCellValueByColumnAndRow(1,$line,$row['fullname']);							
									$line++;
									
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'No')
									->setCellValueByColumnAndRow(1,$line,'No. Invoice')
									->setCellValueByColumnAndRow(2,$line,'T.O.P')					
									->setCellValueByColumnAndRow(3,$line,'Umur')
									->setCellValueByColumnAndRow(4,$line,'Belum Jatuh Tempo')
									->setCellValueByColumnAndRow(5,$line,'0-30 Hari')
									->setCellValueByColumnAndRow(6,$line,'31-60 Hari')
									->setCellValueByColumnAndRow(7,$line,'61-90 Hari')
									->setCellValueByColumnAndRow(8,$line,'91-120 Hari')
									->setCellValueByColumnAndRow(9,$line,'>120 Hari')
									->setCellValueByColumnAndRow(10,$line,'Jumlah')
									->setCellValueByColumnAndRow(11,$line,'Total');
							$line++;
							$sql1 = "select z.*,
														case when umurtempo < 0 then totamount else 0 end as sd0,
														case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
														case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
														case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
														case when umurtempo > 90 and umurtempo <= 120 then totamount else 0 end as 91sd120,
														case when umurtempo > 120 then totamount else 0 end as sd120
												from
												(select distinct a.invoiceno, a.invoicedate, datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',date_add(a.invoicedate,interval d.paydays day)) as umurtempo,
												date_add(a.invoicedate,interval d.paydays day) as jatuhtempo,
												a.amount-ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
													from cutarinv o
													join cutar p on p.cutarid=o.cutarid
													where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as totamount,d.paydays
												from invoice a
												join giheader b on b.giheaderid = a.giheaderid
												join soheader c on c.soheaderid = b.soheaderid
												join paymentmethod d on d.paymentmethodid = c.paymentmethodid
												join employee e on e.employeeid = c.employeeid
												where  e.fullname like '%".$sales."%' and c.companyid = ".$companyid." and a.recordstatus = 3 and c.addressbookid = '".$row['addressbookid']."' 
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
												where totamount > 0";

                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $i=0;$totalsd0=0;$total0sd30=0;$total31sd60=0;$total61sd90=0;$total91sd120=0;$totalsd120=0;$totaltempo=0;$total=0;								
								foreach($dataReader1 as $row1)
								{
									$i+=1;
									$this->phpExcel->setActiveSheetIndex(0)
											->setCellValueByColumnAndRow(0,$line,$i)
											->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
											->setCellValueByColumnAndRow(2,$line,$row1['paydays'])
											->setCellValueByColumnAndRow(3,$line,$row1['umur'])
											->setCellValueByColumnAndRow(4,$line,($row1['sd0']/$per))
											->setCellValueByColumnAndRow(5,$line,($row1['0sd30']/$per))							
											->setCellValueByColumnAndRow(6,$line,($row1['31sd60']/$per))					
											->setCellValueByColumnAndRow(7,$line,($row1['61sd90']/$per))
											->setCellValueByColumnAndRow(8,$line,($row1['91sd120']/$per))
											->setCellValueByColumnAndRow(9,$line,($row1['sd120']/$per))
											->setCellValueByColumnAndRow(10,$line,(($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per))
											->setCellValueByColumnAndRow(11,$line,(($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per));
									$line++;
									$totalsd0 += $row1['sd0']/$per;
									$total0sd30 += $row1['0sd30']/$per;
									$total31sd60 += $row1['31sd60']/$per;
									$total61sd90 += $row1['61sd90']/$per;
									$total61sd90 += $row1['91sd120']/$per;
									$totalsd120 += $row1['sd120']/$per;
									$totaltempo += ($row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per;
									$total += ($row1['sd0']+$row1['0sd30']+$row1['31sd60']+$row1['61sd90']+$row1['91sd120']+$row1['sd120'])/$per;
									
								}
								$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'Total')										
										->setCellValueByColumnAndRow(4,$line,($totalsd0))
										->setCellValueByColumnAndRow(5,$line,($total0sd30))
										->setCellValueByColumnAndRow(6,$line,($total31sd60))
										->setCellValueByColumnAndRow(7,$line,($total61sd90))
										->setCellValueByColumnAndRow(8,$line,($total91sd120))
										->setCellValueByColumnAndRow(9,$line,($totalsd120))
										->setCellValueByColumnAndRow(10,$line,($totaltempo))
										->setCellValueByColumnAndRow(11,$line,($total));
								$line++;
								$total2sd0 += $totalsd0;
								$total20sd30 += $total0sd30;
								$total231sd60 += $total31sd60;
								$total261sd90 += $total61sd90;
								$total291sd120 += $total91sd120;
								$total2sd120 += $totalsd120;
								$totaltempo2 += $totaltempo;
								$total2 += $total;
								$line += 1;
						}
						$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')										
										->setCellValueByColumnAndRow(4,$line,($total2sd0))
										->setCellValueByColumnAndRow(5,$line,($total20sd30))
										->setCellValueByColumnAndRow(6,$line,($total231sd60))
										->setCellValueByColumnAndRow(7,$line,($total261sd90))
										->setCellValueByColumnAndRow(8,$line,($total291sd120))
										->setCellValueByColumnAndRow(9,$line,($total2sd120))
										->setCellValueByColumnAndRow(10,$line,($totaltempo2))
										->setCellValueByColumnAndRow(11,$line,($total2));
								$line++;
		
		
		$this->getFooterXLS($this->phpExcel);
	}
	//7
	public function RekapUmurPiutangDagangPerCustomerXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekapumurpiutangdagangpercustomer';
		parent::actionDownxls();
		$sql = "select *,sum(sd0) as belumjatuhtempo, sum(0sd30) as sum0sd30,sum(31sd60) as sum31sd60, sum(61sd90) as sum61sd90, sum(sd90) as sumsd90
				from (select *,
				case when umurtempo < 0 then totamount else 0 end as sd0,
				case when umurtempo >= 0 and umurtempo <= 30 then totamount else 0 end as 0sd30,
				case when umurtempo > 30 and umurtempo <= 60 then totamount else 0 end as 31sd60,
				case when umurtempo > 60 and umurtempo <= 90 then totamount else 0 end as 61sd90,
				case when umurtempo > 90 then totamount else 0 end as sd90
				from(select *,amount - payamount as totamount
				from (select d.fullname,e.paydays,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',
				date_add(a.invoicedate,interval e.paydays day)) as umurtempo,
				date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
				datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,
				ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
				from cutarinv f
				join cutar g on g.cutarid=f.cutarid
				where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
				from invoice a
				inner join giheader b on b.giheaderid = a.giheaderid
				inner join soheader c on c.soheaderid = b.soheaderid
				inner join addressbook d on d.addressbookid = c.addressbookid
				inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
				inner join employee f on f.employeeid = c.employeeid			
				where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 	
				and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z)zz 
				where amount > payamount)zzz
				group by fullname
				order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))							
							->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
							$line=4;
			$i=0;$totalsd0=0;$total0sd30=0; $total31sd60=0;$total61sd90=0;$totalsd90=0;$total=0;		
					
			$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'No')
									->setCellValueByColumnAndRow(1,$line,'Nama Customer')
									->setCellValueByColumnAndRow(2,$line,'Belum Jatuh Tempo')								
									->setCellValueByColumnAndRow(3,$line,'0-30 Hari')
									->setCellValueByColumnAndRow(4,$line,'31-60 Hari')
									->setCellValueByColumnAndRow(5,$line,'61-90 Hari')
									->setCellValueByColumnAndRow(6,$line,'>90 Hari')
									->setCellValueByColumnAndRow(7,$line,'Total');
							$line++;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['fullname'])						
						->setCellValueByColumnAndRow(2,$line,($row['belumjatuhtempo']/$per))
						->setCellValueByColumnAndRow(3,$line,($row['sum0sd30']/$per))							
						->setCellValueByColumnAndRow(4,$line,($row['sum31sd60']/$per))					
						->setCellValueByColumnAndRow(5,$line,($row['sum61sd90']/$per))
						->setCellValueByColumnAndRow(6,$line,($row['sumsd90']/$per))
						->setCellValueByColumnAndRow(7,$line,(($row['belumjatuhtempo']+$row['sum0sd30']+$row['sum31sd60']+$row['sum61sd90']+$row['sumsd90'])/$per));
					$line++;
					$totalsd0 += $row['belumjatuhtempo']/$per;
					$total0sd30 += $row['sum0sd30']/$per;
          			$total31sd60 += $row['sum31sd60']/$per;
					$total61sd90 += $row['sum61sd90']/$per;
					$totalsd90 += $row['sumsd90']/$per;
					$total += ($row['belumjatuhtempo']+$row['sum0sd30']+$row['sum31sd60']+$row['sum61sd90']+$row['sumsd90'])/$per;
					
			}
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'Total')										
										->setCellValueByColumnAndRow(2,$line,($totalsd0))
										->setCellValueByColumnAndRow(3,$line,($total0sd30))
										->setCellValueByColumnAndRow(4,$line,($total31sd60))
										->setCellValueByColumnAndRow(5,$line,($total61sd90))
										->setCellValueByColumnAndRow(6,$line,($totalsd90))
										->setCellValueByColumnAndRow(7,$line,($total));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	//8
	public function RincianFakturdanReturJualBelumLunasPerSalesXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rincianfakturdanreturjualbelumlunaspersales';
		parent::actionDownxls();
		$nilaitot2=0;$dibayar2=0;$sisa2=0;
		$sql = "select distinct employeeid,fullname
						from (select f.employeeid,f.fullname,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid=c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
							$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'SALESMAN')
									->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);							
						$line++;
						$sql1 = "select distinct addressbookid,fullname
						from (select d.addressbookid,d.fullname,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c. employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and c.employeeid = '".$row['employeeid']."'
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by fullname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$nilaitot1=0;$dibayar1=0;$sisa1=0;			
					
				foreach($dataReader1 as $row1)
				{
					$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,'Customer')
									->setCellValueByColumnAndRow(1,$line,': '.$row1['fullname']);							
						$line++;
						
						
					$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
						->setCellValueByColumnAndRow(2,$line,'Tanggal')					
						->setCellValueByColumnAndRow(3,$line,'J_Tempo')
						->setCellValueByColumnAndRow(4,$line,'Umur')
						->setCellValueByColumnAndRow(5,$line,'UT')
						->setCellValueByColumnAndRow(6,$line,'Nilai')
						->setCellValueByColumnAndRow(7,$line,'Kum_Bayar')
						->setCellValueByColumnAndRow(8,$line,'Sisa');
						$line++;
						
						$sql2 = "select *
						from (select a.invoiceno,a.invoicedate,e.paydays,
						date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
						datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
						datediff(date_add(a.invoicedate, INTERVAL e.paydays DAY),'".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as umurtempo,a.amount,
						ifnull((select sum((ifnull(o.cashamount,0)+ifnull(o.bankamount,0)+ifnull(o.discamount,0)+ifnull(o.returnamount,0)+ifnull(o.obamount,0))*ifnull(o.currencyrate,0))
							from cutarinv o
							join cutar p on p.cutarid=o.cutarid
							where p.recordstatus=3 and o.invoiceid=a.invoiceid and p.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."
						and d.addressbookid = '".$row1['addressbookid']."' and c.employeeid = '".$row['employeeid']."'
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount order by umurtempo";						
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
					$i=0;$nilaitot=0;$dibayar=0;$sisa=0;					
									
					foreach($dataReader2 as $row2)
					{
						$i+=1;
									$this->phpExcel->setActiveSheetIndex(0)
											->setCellValueByColumnAndRow(0,$line,$i)
											->setCellValueByColumnAndRow(1,$line,$row2['invoiceno'])
											->setCellValueByColumnAndRow(2,$line,$row2['invoicedate'])
											->setCellValueByColumnAndRow(3,$line,$row2['jatuhtempo'])
											->setCellValueByColumnAndRow(4,$line,$row2['umur'])
											->setCellValueByColumnAndRow(5,$line,$row2['umurtempo'])
											->setCellValueByColumnAndRow(6,$line,($row2['amount']/$per))							
											->setCellValueByColumnAndRow(7,$line,($row2['payamount']/$per))					
											->setCellValueByColumnAndRow(8,$line,(($row2['amount']-$row2['payamount'])/$per));
									$line++;
									$nilaitot += $row2['amount']/$per;
									$dibayar += $row2['payamount']/$per;
									$sisa += ($row2['amount']-$row2['payamount'])/$per;
					}
					$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(4,$line,'TOTAL '.$row1['fullname'])									
										->setCellValueByColumnAndRow(6,$line,($nilaitot))
										->setCellValueByColumnAndRow(7,$line,($dibayar))
										->setCellValueByColumnAndRow(8,$line,($sisa));
								$line++;
								$nilaitot1 += $nilaitot;
								$dibayar1 += $dibayar;
								$sisa1 += $sisa;
								$line += 1;
				}
				$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(4,$line,'TOTAL SALES '.$row['fullname'])									
										->setCellValueByColumnAndRow(6,$line,($nilaitot1))
										->setCellValueByColumnAndRow(7,$line,($dibayar1))
										->setCellValueByColumnAndRow(8,$line,($sisa1));
								$line++;
								$nilaitot2 += $nilaitot1;
								$dibayar2 += $dibayar1;
								$sisa2 += $sisa1;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(4,$line,'GRAND TOTAL')									
										->setCellValueByColumnAndRow(6,$line,($nilaitot2))
										->setCellValueByColumnAndRow(7,$line,($dibayar2))
										->setCellValueByColumnAndRow(8,$line,($sisa2));
								$line++;
		
		$this->getFooterXLS($this->phpExcel);
		
	}
	//9
	public function RekapKontrolPiutangCustomervsPlafonXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekapkontrolpiutangcustomervsplafon';
		parent::actionDownxls();
		$totalbelum=0;$totalsudah=0;$totalnilai=0;$totalplafon=0;			
					
		$sql = "select fullname,sum(belum) as belum,sum(sudah) as sudah,sum(nilai) as nilai,plafon from
								(select z.*,
								case when umur <= paydays then nilai else 0 end as belum,
								case when umur > paydays then nilai else 0 end as sudah
								from
								(select distinct a.invoiceno,a.invoicedate,date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,e.paydays,
								datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,
								a.amount-(ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0)) as nilai,
								d.creditlimit as plafon,d.fullname
								from invoice a
								join giheader b on b.giheaderid=a.giheaderid
								join soheader c on c.soheaderid=b.soheaderid
								join addressbook d on d.addressbookid=c.addressbookid
								join paymentmethod e on e.paymentmethodid=c.paymentmethodid
								join employee f on f.employeeid = c.employeeid
								where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
								and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
								order by invoicedate) z where nilai > 0) zz group by fullname order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			$i=0;
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))							
							->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
							$line=4;	
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Customer')
						->setCellValueByColumnAndRow(2,$line,'Belum JT')					
						->setCellValueByColumnAndRow(3,$line,'Sudah JT')
						->setCellValueByColumnAndRow(4,$line,'Jumlah')
						->setCellValueByColumnAndRow(5,$line,'Plafon')						
						->setCellValueByColumnAndRow(6,$line,'Over/(Under)');
					$line++;		
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['fullname'])							
						->setCellValueByColumnAndRow(2,$line,($row['belum']/$per))
						->setCellValueByColumnAndRow(3,$line,($row['sudah']/$per))							
						->setCellValueByColumnAndRow(4,$line,($row['nilai']/$per))					
						->setCellValueByColumnAndRow(5,$line,($row['plafon']/$per))
						->setCellValueByColumnAndRow(6,$line,(($row['nilai'] - $row['plafon'])/$per));
				$line++;
				$totalbelum += $row['belum']/$per;
				$totalsudah += $row['sudah']/$per;
				$totalnilai += $row['nilai']/$per;
				$totalplafon += $row['plafon']/$per;			
			}
				
			$line += 1;
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(1,$line,'TOTAL')									
										->setCellValueByColumnAndRow(2,$line,($totalbelum))
										->setCellValueByColumnAndRow(3,$line,($totalsudah))
										->setCellValueByColumnAndRow(4,$line,($totalnilai))
										->setCellValueByColumnAndRow(5,$line,($totalplafon))
										->setCellValueByColumnAndRow(6,$line,($totalnilai - $totalplafon));
								$line++;
		$this->getFooterXLS($this->phpExcel);
	}
	//10
	public function RincianKontrolPiutangCustomervsPlafonXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rinciankontrolpiutangcustomervsplafon';
		parent::actionDownxls();
		$totalbelum1=0;$totalsudah1=0;$totalnilai1=0;$totalplafon1=0;								
								
		$sql ="select distinct addressbookid,fullname
						from (select d.addressbookid,d.fullname,a.amount,
						ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
						from cutarinv f
						join cutar g on g.cutarid=f.cutarid
						where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						join giheader b on b.giheaderid = a.giheaderid
						join soheader c on c.soheaderid = b.soheaderid
						join addressbook d on d.addressbookid = c.addressbookid
						join employee e on e.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
						and d.fullname like '%".$customer."%' 
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
						where amount > payamount
						order by fullname";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))							
							->setCellValueByColumnAndRow(9,1,$this->GetCompanyCode($companyid));
							$line=4;				
			foreach($dataReader as $row)
			{
				$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'CUSTOMER : '.$row['fullname']);							
					$line++;
					
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Dokumen')
						->setCellValueByColumnAndRow(2,$line,'Tanggal')					
						->setCellValueByColumnAndRow(3,$line,'J_Tempo')
						->setCellValueByColumnAndRow(4,$line,'Umur')
						->setCellValueByColumnAndRow(5,$line,'Belum JT')
						->setCellValueByColumnAndRow(6,$line,'Sudah JT')
						->setCellValueByColumnAndRow(7,$line,'Jumlah')
						->setCellValueByColumnAndRow(8,$line,'Plafon')
						->setCellValueByColumnAndRow(9,$line,'Over/(Under)');
					$line++;
					$sql1 ="select zz.*,
												case when umur <= paydays then sisa else 0 end as belum,
												case when umur > paydays then sisa else 0 end as sudah
												from
												(select *, (amount-payamount) as sisa,(amount) as nilai
												from (select a.invoiceno,a.invoicedate,e.paydays,
												date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
												datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,d.creditlimit,
												ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
												from cutarinv f
												join cutar g on g.cutarid=f.cutarid
												where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
												from invoice a
												inner join giheader b on b.giheaderid = a.giheaderid
												inner join soheader c on c.soheaderid = b.soheaderid
												inner join addressbook d on d.addressbookid = c.addressbookid
												inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
												inner join employee f on f.employeeid = c.employeeid
												where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."  
												and d.addressbookid = ".$row['addressbookid']."
												and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z)zz
												where amount > payamount 
												order by invoiceno";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();			
				$i=0;$totalbelum=0;$totalsudah=0;$totalnilai=0;
						
						
				foreach($dataReader1 as $row1)
				{
					$i+=1;
						$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,$i)
								->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
								->setCellValueByColumnAndRow(2,$line,$row1['invoicedate'])
								->setCellValueByColumnAndRow(3,$line,$row1['jatuhtempo'])
								->setCellValueByColumnAndRow(4,$line,$row1['umur'])
								->setCellValueByColumnAndRow(5,$line,($row1['belum']/$per))
								->setCellValueByColumnAndRow(6,$line,($row1['sudah']/$per))							
								->setCellValueByColumnAndRow(7,$line,($row1['sisa']/$per))					
								->setCellValueByColumnAndRow(8,$line,'')
								->setCellValueByColumnAndRow(9,$line,'');
						$line++;
						$totalbelum += $row1['belum']/$per;
						$totalsudah += $row1['sudah']/$per;
						$totalnilai += $row1['sisa']/$per;
						
				}
				$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(4,$line,'SUB TOTAL')									
										->setCellValueByColumnAndRow(5,$line,($totalbelum))
										->setCellValueByColumnAndRow(6,$line,($totalsudah))
										->setCellValueByColumnAndRow(7,$line,($totalnilai))
										->setCellValueByColumnAndRow(8,$line,($row1['creditlimit']/$per))
										->setCellValueByColumnAndRow(9,$line,($totalnilai - ($row1['creditlimit']/$per)));
								$line++;
								$totalbelum1 += $totalbelum;
								$totalsudah1 += $totalsudah;
								$totalnilai1 += $totalnilai;
								$totalplafon1 += $row1['creditlimit']/$per;
								$line += 1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
										->setCellValueByColumnAndRow(4,$line,'TOTAL')									
										->setCellValueByColumnAndRow(5,$line,($totalbelum1))
										->setCellValueByColumnAndRow(6,$line,($totalsudah1))
										->setCellValueByColumnAndRow(7,$line,($totalnilai1))
										->setCellValueByColumnAndRow(8,$line,($totalplafon1))
										->setCellValueByColumnAndRow(9,$line,($totalnilai1 - $totalplafon1));
								$line++;
								
								
		$this->getFooterXLS($this->phpExcel);
	}
	//11
	public function KonfirmasiPiutangDagangXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='konfirmasipiutangdagang';
		parent::actionDownxls();
				$sql ="select distinct addressbookid,fullname,alamat,phoneno
					from (select d.addressbookid,d.fullname,a.amount,
					ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount,
					(select h.addressname	from address h where h.addressbookid=d.addressbookid Limit 1) as alamat,
					(select i.phoneno	from address i where i.addressbookid=d.addressbookid Limit 1) as phoneno
					from invoice a
					join giheader b on b.giheaderid = a.giheaderid
					join soheader c on c.soheaderid = b.soheaderid
					join addressbook d on d.addressbookid = c.addressbookid
					join employee e on e.employeeid = c.employeeid			
					where d.fullname like '%".$customer."%' and e.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
					and d.fullname like '%".$customer."%' 
					and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') z
					where amount > payamount
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
							$line=4;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'Kepada YTH,');
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)							
						->setCellValueByColumnAndRow(1,$line,$row['fullname'])
						->setCellValueByColumnAndRow(8,$line,'Note : Bukti Konfirmasi ini tidak untuk Penagihan');
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'Di Tempat');
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(4,$line,'Hal : KONFIRMASI PIUTANG');
					$line+=3;
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(0,$line,'Dengan Hormat,');
					$line+=2;
			$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'Dalam rangka kegiatan rutin dan tertib administrasi, maka dengan ini kami mohon kesediaan Bapak / Ibu Relasi kami untuk dapat memberikan informasi');
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'atas saldo tagihan perusahaan kami yang masih tersisa terhadap :');
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,$line,'Toko / Customer')
						->setCellValueByColumnAndRow(2,$line,' : '.$row['fullname'])
						->setCellValueByColumnAndRow(5,$line,'No. Telepon')
						->setCellValueByColumnAndRow(6,$line,' : '.$row['phoneno']);							
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,$line,'Alamat')
						->setCellValueByColumnAndRow(2,$line,' : '.$row['alamat']);							
					$line++;
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,$line,'Per Tanggal')
						->setCellValueByColumnAndRow(2,$line,' : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));							
					$line+=2;
			$this->phpExcel->setActiveSheetIndex(0)	
						->setCellValueByColumnAndRow(0,$line,'Dengan perincian sebagai berikut : ');
					$line+=2;
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Dokumen')
						->setCellValueByColumnAndRow(2,$line,'Tanggal')					
						->setCellValueByColumnAndRow(3,$line,'J_Tempo')
						->setCellValueByColumnAndRow(4,$line,'Nilai Invoice')
						->setCellValueByColumnAndRow(5,$line,'Jml_Cicilan')
						->setCellValueByColumnAndRow(6,$line,'Sisa Invoice')
						->setCellValueByColumnAndRow(7,$line,'Umur')
						->setCellValueByColumnAndRow(8,$line,'Sales');
					$line++;
					
				$sql1 ="select *
						from (select a.invoiceno,a.invoicedate,e.paydays,
						date_add(a.invoicedate,interval e.paydays day) as jatuhtempo,
						datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.invoicedate) as umur,a.amount,d.creditlimit,
						ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
						from cutarinv f
						join cutar g on g.cutarid=f.cutarid
						where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as payamount
						from invoice a
						inner join giheader b on b.giheaderid = a.giheaderid
						inner join soheader c on c.soheaderid = b.soheaderid
						inner join addressbook d on d.addressbookid = c.addressbookid
						inner join paymentmethod e on e.paymentmethodid = c.paymentmethodid
						inner join employee f on f.employeeid = c.employeeid
						where d.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid."  
						and d.addressbookid = ".$row['addressbookid']."
						and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
						where amount > payamount 
						order by invoiceno";
						
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();	
			$i=0;$totalamount=0;$totalpayamount=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
					->setCellValueByColumnAndRow(2,$line,$row1['invoicedate'])
					->setCellValueByColumnAndRow(3,$line,$row1['jatuhtempo'])	
					->setCellValueByColumnAndRow(4,$line,($row1['amount']/$per))
					->setCellValueByColumnAndRow(5,$line,($row1['payamount']/$per))						
					->setCellValueByColumnAndRow(6,$line,(($row1['amount'] - $row1['payamount'])/$per))
					->setCellValueByColumnAndRow(7,$line,$row1['umur']);
				$line+=1;			
							
			}
			$totalamount += $row1['amount']/$per;
			$totalpayamount += $row1['payamount']/$per;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'Saldo Piutang Dagang')
				->setCellValueByColumnAndRow(4,$line,' : '.($row1['amount']-$row1['payamount'])/$per);							
			$line+=2;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(0,$line,'Mengingat pentingnya hal ini, maka kami sangat mengharapkan bantuannya dan jika dari jumlah tersebut diatas ada yang tidak setuju');
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(0,$line,'mohon penjelasannya.');
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,$line,'Alasan :');
			$line+=6;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,$line,'Menyetujui,')
				->setCellValueByColumnAndRow(4,$line,'Mengetahui,')
				->setCellValueByColumnAndRow(7,$line,'Hormat kami,');
			$line+=6;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,$line,'( TTd / Cap Toko /Nama Jelas )')
				->setCellValueByColumnAndRow(4,$line,'(         FM / BM         )')
				->setCellValueByColumnAndRow(7,$line,'(                                  )');
			$line+=2;
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(0,$line,'Catatan : Konfirmasi ini bukan sebagai bukti penagihan');
			$line+=3;
			
		}
		$this->getFooterXLS($this->phpExcel);
	}	
	//12
	public function RekapInvoiceARPerDokumenBelumStatusMaxXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekapinvoicearperdokumenbelumstatusmax';
		parent::actionDownxls();
		$sql ="select distinct a.invoiceid, a.invoiceno, a.invoicedate, b.gino, a.headernote, c.companyid, a.recordstatus, a.statusname
				from invoice a
				join giheader b on b.giheaderid = a.giheaderid
				join soheader c on c.soheaderid = b.soheaderid
				where a.invoicedate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and a.recordstatus between 1 and (3-1)
				and a.invoiceno is not null
				and c.companyid = ".$companyid."
				order by a.recordstatus";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();			
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)				
						->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
						->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$line=4;	
			$i=0;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
						->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
						->setCellValueByColumnAndRow(3,$line,'Tanggal')
						->setCellValueByColumnAndRow(4,$line,'No Referensi')
						->setCellValueByColumnAndRow(5,$line,'Keterangan')
						->setCellValueByColumnAndRow(6,$line,'Status');
			$line++;	
			
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['invoiceid'])
					->setCellValueByColumnAndRow(2,$line,$row['invoiceno'])
					->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])))
					->setCellValueByColumnAndRow(4,$line,$row['gino'])
					->setCellValueByColumnAndRow(5,$line,$row['headernote'])				
					->setCellValueByColumnAndRow(6,$line,$row['statusname']);
				$line++;				
			}
			
		$this->getFooterXLS($this->phpExcel);
	}
	//13
	public function RekapNotaReturPenjualanPerDokumenBelumStatusMaxXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
		$this->menuname='rekapnotareturpenjualanperdokumenbelumstatusmax';
		parent::actionDownxls();
			$sql ="select distinct a.notagirid, a.notagirno, a.docdate, b.gireturno, a.headernote, a.recordstatus, a.companyid, a.statusname
				from notagir a
				join giretur b on b.gireturid = a.gireturid
				where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and a.recordstatus between 1 and (3-1)
				and b.gireturno is not null
				and a.companyid = ".$companyid."
				order by a.recordstatus";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)				
						->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
						->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$line=4;	
			$i=0;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
						->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
						->setCellValueByColumnAndRow(3,$line,'Tanggal')
						->setCellValueByColumnAndRow(4,$line,'No Referensi')
						->setCellValueByColumnAndRow(5,$line,'Keterangan')
						->setCellValueByColumnAndRow(6,$line,'Status');
			$line++;			
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['notagirid'])
					->setCellValueByColumnAndRow(2,$line,$row['notagirno'])
					->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])))
					->setCellValueByColumnAndRow(4,$line,$row['gireturno'])
					->setCellValueByColumnAndRow(5,$line,$row['headernote'])				
					->setCellValueByColumnAndRow(6,$line,$row['statusname']);
				$line++;
			}
		$this->getFooterXLS($this->phpExcel);
	}
	//14
	public function RekapPelunasanPiutangPerDokumenBelumStatusMaxXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$startdate,$enddate,$per)
	{
	$this->menuname='rekappelunasanpiutangperdokumenbelumstatusmax';
	parent::actionDownxls();	
		$sql ="select distinct a.cutarid,a.cutarno,a.docdate, b.docno,a.headernote,a.recordstatus,a.statusname
						from cutar a
						join ttnt b on b.ttntid = a.ttntid
						where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."'
						and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and a.recordstatus between 1 and (3-1)
						and b.docno is not null
						and a.companyid = ".$companyid."
						order by a.recordstatus";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)				
					->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;	
		$i=0;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
					->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'No Referensi')
					->setCellValueByColumnAndRow(5,$line,'Keterangan')
					->setCellValueByColumnAndRow(6,$line,'Status');
		$line++;
		
		foreach($dataReader as $row)
		{
			$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['cutarid'])
					->setCellValueByColumnAndRow(2,$line,$row['cutarno'])
					->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])))
					->setCellValueByColumnAndRow(4,$line,$row['docno'])
					->setCellValueByColumnAndRow(5,$line,$row['headernote'])				
					->setCellValueByColumnAndRow(6,$line,$row['statusname']);
				$line++;
		}
	
	$this->getFooterXLS($this->phpExcel);
	}	
	//15
	public function RincianPelunasanPiutangPerSalesXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rincianpelunasanpiutangpersales';
		parent::actionDownxls();
		$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)				
					->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;	
		$i=0;
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(0,$line,'SALES ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);							
			$line++;
				
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'No Invoice')
					->setCellValueByColumnAndRow(2,$line,'Tanggal')					
					->setCellValueByColumnAndRow(3,$line,'Tgl Byr')
					->setCellValueByColumnAndRow(4,$line,'Customer')
					->setCellValueByColumnAndRow(5,$line,'Hari')
					->setCellValueByColumnAndRow(6,$line,'Nil. Faktur')
					->setCellValueByColumnAndRow(7,$line,'Disc/Ret')
					->setCellValueByColumnAndRow(8,$line,'Jmlh Bayar')
					->setCellValueByColumnAndRow(9,$line,'0-30 Hari')
					->setCellValueByColumnAndRow(10,$line,'31-45 Hari')
					->setCellValueByColumnAndRow(11,$line,'46-60 Hari')
					->setCellValueByColumnAndRow(12,$line,'61-63 Hari')
					->setCellValueByColumnAndRow(13,$line,'64-70 Hari')
					->setCellValueByColumnAndRow(14,$line,'71-90 Hari')
					->setCellValueByColumnAndRow(15,$line,'>90 Hari');
			$line++;
			
			$sql1 = "select *,
								case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
								case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
								case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
								case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
								case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
								case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
								case when umur > 90 then nilaibayar else 0 end as sd91								
								from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
								a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar
								from cutarinv a
								join cutar b on b.cutarid=a.cutarid
								join invoice c on c.invoiceid=a.invoiceid
								join giheader d on d.giheaderid=c.giheaderid
								join soheader e on e.soheaderid=d.soheaderid
								join employee f on f.employeeid=e.employeeid
								join addressbook g on g.addressbookid=e.addressbookid
								join salesarea j on j.salesareaid=g.salesareaid
								join gidetail k on k.giheaderid=d.giheaderid
								join product l on l.productid=k.productid
								where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
								and l.productname like '%".$product."%'
								and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
								and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid'].") z
								order by docdate,fullname
								";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
			
			foreach($dataReader1 as $row1)
				{
					$i+=1;
						$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,$i)
								->setCellValueByColumnAndRow(1,$line,$row1['invoiceno'])
								->setCellValueByColumnAndRow(2,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])))
								->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['docdate'])))
								->setCellValueByColumnAndRow(4,$line,$row1['fullname'])
								->setCellValueByColumnAndRow(5,$line,$row1['umur'])
								->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($row1['amount']/$per))							
								->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($row1['disc']/$per))					
								->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($row1['nilaibayar']/$per))
								->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($row1['0sd30']/$per))
								->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($row1['31sd45']/$per))
								->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($row1['46sd60']/$per))
								->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($row1['61sd63']/$per))
								->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($row1['64sd70']/$per))
								->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($row1['71sd90']/$per))
								->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($row1['sd91']/$per));
						$line++;
						
					$totaldisc += ($row1['disc']/$per);
					$totalnilaibayar += ($row1['nilaibayar']/$per);
					$total0sd30 += ($row1['0sd30']/$per);
					$total31sd45 += ($row1['31sd45']/$per);
					$total46sd60 += ($row1['46sd60']/$per);
					$total61sd63 += ($row1['61sd63']/$per);
					$total64sd70 += ($row1['64sd70']/$per);
					$total71sd90 += ($row1['71sd90']/$per);
					$totalsd91 += ($row1['sd91']/$per);				
						
				}
				$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'TOTAL SALES '.$row['fullname'])				
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($totaldisc))										
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($totalnilaibayar))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total0sd30))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($total31sd45))
					->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($total46sd60))
					->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($total61sd63))
					->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($total64sd70))
					->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($total71sd90))
					->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($totalsd91));
				$line+=2;
				
				$totaldisc1 += $totaldisc;
				$totalnilaibayar1 += $totalnilaibayar;
				$total0sd301 += $total0sd30;
				$total31sd451 += $total31sd45;
				$total46sd601 += $total46sd60;
				$total61sd631 += $total61sd63;
				$total64sd701 += $total64sd70;
				$total71sd901 += $total71sd90;
				$totalsd911 += $totalsd91;
			
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'GRAND TOTAL ')				
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($totaldisc1))										
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($totalnilaibayar1))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total0sd301))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($total31sd451))
					->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($total46sd601))
					->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($total61sd631))
					->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($total64sd701))
					->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($total71sd901))
					->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($totalsd911));
				$line++;		
		
		$this->getFooterXLS($this->phpExcel);
	}
	//16
	public function RekapPelunasanPiutangPerSalesXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappelunasanpiutangpersales';
		parent::actionDownxls();
		$i=0;$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		
		$this->phpExcel->setActiveSheetIndex(0)				
					->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;		
		$i=0;
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Sales')
						->setCellValueByColumnAndRow(2,$line,'Disc/Ret')					
						->setCellValueByColumnAndRow(3,$line,'Jmlh Bayar')
						->setCellValueByColumnAndRow(4,$line,'0-30 Hari')
						->setCellValueByColumnAndRow(5,$line,'31-45 Hari')
						->setCellValueByColumnAndRow(6,$line,'46-60 Hari')
						->setCellValueByColumnAndRow(7,$line,'61-63 Hari')
						->setCellValueByColumnAndRow(8,$line,'64-70 Hari')
						->setCellValueByColumnAndRow(9,$line,'71-90 Hari')
						->setCellValueByColumnAndRow(10,$line,'>90 Hari');
		$line++;
		foreach($dataReader as $row)	
		{
					
			$sql1 = "select *,
								case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
								case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
								case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
								case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
								case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
								case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
								case when umur > 90 then nilaibayar else 0 end as sd91								
								from (select c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
								a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar
								from cutarinv a
								join cutar b on b.cutarid=a.cutarid
								join invoice c on c.invoiceid=a.invoiceid
								join giheader d on d.giheaderid=c.giheaderid
								join soheader e on e.soheaderid=d.soheaderid
								join employee f on f.employeeid=e.employeeid
								join addressbook g on g.addressbookid=e.addressbookid
								join salesarea j on j.salesareaid=g.salesareaid
								join gidetail k on k.giheaderid=d.giheaderid
								join product l on l.productid=k.productid
								where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
								and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
								and l.productname like '%".$product."%' 
								and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid'].") z
								order by docdate,fullname
								";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
								
			$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
			
			foreach($dataReader1 as $row1)
			{
				$totaldisc += ($row1['disc']/$per);
				$totalnilaibayar += ($row1['nilaibayar']/$per);
				$total0sd30 += ($row1['0sd30']/$per);
				$total31sd45 += ($row1['31sd45']/$per);
				$total46sd60 += ($row1['46sd60']/$per);
				$total61sd63 += ($row1['61sd63']/$per);
				$total64sd70 += ($row1['64sd70']/$per);
				$total71sd90 += ($row1['71sd90']/$per);
				$totalsd91 += ($row1['sd91']/$per);
			}
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['fullname'])										
					->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totaldisc))					
					->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnilaibayar))
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($total0sd30))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total31sd45))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($total46sd60))
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($total61sd63))
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($total64sd70))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total71sd90))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($totalsd91));
			$line++;	
			$totaldisc1 += $totaldisc;
			$totalnilaibayar1 += $totalnilaibayar;
			$total0sd301 += $total0sd30;
			$total31sd451 += $total31sd45;
			$total46sd601 += $total46sd60;
			$total61sd631 += $total61sd63;
			$total64sd701 += $total64sd70;
			$total71sd901 += $total71sd90;
			$totalsd911 += $totalsd91;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL ')				
					->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totaldisc1))										
					->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnilaibayar1))
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($total0sd301))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total31sd451))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($total46sd601))
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($total61sd631))
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($total64sd701))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total71sd901))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($totalsd911));
				$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//17
	public function RincianPelunasanPiutangPerSalesPerJenisBarangXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rincianpelunasanpiutangpersalesperjenisbarang';
		parent::actionDownxls();
		$totaldisc2 = 0;$totalnilaibayar2 = 0;$total0sd302 = 0;$total31sd452 = 0;$total46sd602 = 0;$total61sd632 = 0;$total64sd702 = 0;$total71sd902 = 0;$totalsd912 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
		foreach($dataReader as $row)		
		$this->phpExcel->setActiveSheetIndex(0)				
					->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;		
		$i=0;
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(0,$line,'SALES ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);							
			$line++;			
			
			$sql1 = "select distinct i.slocid,i.description
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join gidetail h on h.giheaderid=d.giheaderid
							join sloc i on i.slocid=h.slocid
							join salesarea j on j.salesareaid=g.salesareaid
							join gidetail k on k.giheaderid=d.giheaderid
							join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
							b.recordstatus=3 and f.employeeid = ".$row['employeeid']." and j.areaname like '%".$salesarea."%' and
							l.productname like '%".$product."%' and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();		
			$totaldisc1 = 0;$totalnilaibayar1 = 0;$total0sd301 = 0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
			foreach($dataReader1 as $row1)
			{
				$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(0,$line,'JENIS BARANG ')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['description']);							
				$line++;
				
				$sql2 = "select *,
									case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
									case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
									case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
									case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
									case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
									case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
									case when umur > 90 then nilaibayar else 0 end as sd91								
							from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
							a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar,
							(select h.slocid from gidetail h where h.giheaderid=d.giheaderid Limit 1) as slocid
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join salesarea j on j.salesareaid=g.salesareaid
							join gidetail k on k.giheaderid=d.giheaderid
							join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
							and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and l.productname like '%".$product."%' 
							and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid']." ) z
							where z.slocid = ".$row1['slocid']."
							order by docdate,fullname
							";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				$i=0;$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
				
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'No Invoice')
					->setCellValueByColumnAndRow(2,$line,'Tanggal')					
					->setCellValueByColumnAndRow(3,$line,'Tgl Byr')
					->setCellValueByColumnAndRow(4,$line,'Customer')
					->setCellValueByColumnAndRow(5,$line,'Hari')
					->setCellValueByColumnAndRow(6,$line,'Nil. Faktur')
					->setCellValueByColumnAndRow(7,$line,'Disc/Ret')
					->setCellValueByColumnAndRow(8,$line,'Jmlh Bayar')
					->setCellValueByColumnAndRow(9,$line,'0-30 Hari')
					->setCellValueByColumnAndRow(10,$line,'31-45 Hari')
					->setCellValueByColumnAndRow(11,$line,'46-60 Hari')
					->setCellValueByColumnAndRow(12,$line,'61-63 Hari')
					->setCellValueByColumnAndRow(13,$line,'64-70 Hari')
					->setCellValueByColumnAndRow(14,$line,'71-90 Hari')
					->setCellValueByColumnAndRow(15,$line,'>90 Hari');
				$line++;
				
				foreach($dataReader2 as $row2)
				{
					$i+=1;
						$this->phpExcel->setActiveSheetIndex(0)
								->setCellValueByColumnAndRow(0,$line,$i)
								->setCellValueByColumnAndRow(1,$line,$row2['invoiceno'])
								->setCellValueByColumnAndRow(2,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])))
								->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row2['docdate'])))
								->setCellValueByColumnAndRow(4,$line,$row2['fullname'])
								->setCellValueByColumnAndRow(5,$line,$row2['umur'])
								->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($row2['amount']/$per))							
								->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($row2['disc']/$per))					
								->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($row2['nilaibayar']/$per))
								->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($row2['0sd30']/$per))
								->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($row2['31sd45']/$per))
								->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($row2['46sd60']/$per))
								->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($row2['61sd63']/$per))
								->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($row2['64sd70']/$per))
								->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($row2['71sd90']/$per))
								->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($row2['sd91']/$per));
						$line++;
						
					$totaldisc += ($row2['disc']/$per);
					$totalnilaibayar += ($row2['nilaibayar']/$per);
					$total0sd30 += ($row2['0sd30']/$per);
					$total31sd45 += ($row2['31sd45']/$per);
					$total46sd60 += ($row2['46sd60']/$per);
					$total61sd63 += ($row2['61sd63']/$per);
					$total64sd70 += ($row2['64sd70']/$per);
					$total71sd90 += ($row2['71sd90']/$per);
					$totalsd91 += ($row2['sd91']/$per);
				}
				$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'TOTAL GUDANG '.$row1['description'])				
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($totaldisc))										
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($totalnilaibayar))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total0sd30))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($total31sd45))
					->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($total46sd60))
					->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($total61sd63))
					->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($total64sd70))
					->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($total71sd90))
					->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($totalsd91));
				$line+=2;
				
				$totaldisc1 += $totaldisc;
				$totalnilaibayar1 += $totalnilaibayar;
				$total0sd301 += $total0sd30;
				$total31sd451 += $total31sd45;
				$total46sd601 += $total46sd60;
				$total61sd631 += $total61sd63;
				$total64sd701 += $total64sd70;
				$total71sd901 += $total71sd90;
				$totalsd911 += $totalsd91;
			
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'TOTAL SALES '.$row['fullname'])				
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($totaldisc1))										
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($totalnilaibayar1))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total0sd301))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($total31sd451))
					->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($total46sd601))
					->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($total61sd631))
					->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($total64sd701))
					->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($total71sd901))
					->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($totalsd911));
				$line+=2;	
			$totaldisc2 += $totaldisc1;
			$totalnilaibayar2 += $totalnilaibayar1;
			$total0sd302 += $total0sd301;
			$total31sd452 += $total31sd451;
			$total46sd602 += $total46sd601;
			$total61sd632 += $total61sd631;
			$total64sd702 += $total64sd701;
			$total71sd902 += $total71sd901;
			$totalsd912 += $totalsd911;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'GRAND TOTAL ')				
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($totaldisc2))										
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($totalnilaibayar2))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total0sd302))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($total31sd452))
					->setCellValueByColumnAndRow(11,$line,Yii::app()->format->formatCurrency($total46sd602))
					->setCellValueByColumnAndRow(12,$line,Yii::app()->format->formatCurrency($total61sd632))
					->setCellValueByColumnAndRow(13,$line,Yii::app()->format->formatCurrency($total64sd702))
					->setCellValueByColumnAndRow(14,$line,Yii::app()->format->formatCurrency($total71sd902))
					->setCellValueByColumnAndRow(15,$line,Yii::app()->format->formatCurrency($totalsd912));
		$line+=2;
		$this->getFooterXLS($this->phpExcel);
	}
	//18
	public function RekapPelunasanPiutangPerSalesPerJenisBarangXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappelunasanpiutangpersalesperjenisbarang';
		parent::actionDownxls();
		$totaldisc2 = 0;$totalnilaibayar2 = 0;$total0sd302 = 0;$total31sd452 = 0;$total46sd602 = 0;$total61sd632 = 0;$total64sd702 = 0;$total71sd902 = 0;$totalsd912 = 0;
		$sql = "select distinct f.employeeid,f.fullname,e.companyid
						from cutarinv a
						join cutar b on b.cutarid=a.cutarid
						join invoice c on c.invoiceid=a.invoiceid
						join giheader d on d.giheaderid=c.giheaderid
						join soheader e on e.soheaderid=d.soheaderid
						join employee f on f.employeeid=e.employeeid
						join addressbook g on g.addressbookid=e.addressbookid
						join salesarea j on j.salesareaid=g.salesareaid
						join gidetail k on k.giheaderid=d.giheaderid
						join product l on l.productid=k.productid
						where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
						b.recordstatus=3 and j.areaname like '%".$salesarea."%' and l.productname like '%".$product."%' and
						b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		
		$this->phpExcel->setActiveSheetIndex(0)				
					->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;		
		
                
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(0,$line,'SALES ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['fullname']);							
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Sales')
						->setCellValueByColumnAndRow(2,$line,'Disc/Ret')					
						->setCellValueByColumnAndRow(3,$line,'Jmlh Bayar')
						->setCellValueByColumnAndRow(4,$line,'0-30 Hari')
						->setCellValueByColumnAndRow(5,$line,'31-45 Hari')
						->setCellValueByColumnAndRow(6,$line,'46-60 Hari')
						->setCellValueByColumnAndRow(7,$line,'61-63 Hari')
						->setCellValueByColumnAndRow(8,$line,'64-70 Hari')
						->setCellValueByColumnAndRow(9,$line,'71-90 Hari')
						->setCellValueByColumnAndRow(10,$line,'>90 Hari');
			$line++;
			$i=0;$totaldisc1=0;$totalnilaibayar1=0;$total0sd301=0;$total31sd451 = 0;$total46sd601 = 0;$total61sd631 = 0;$total64sd701 = 0;$total71sd901 = 0;$totalsd911 = 0;
			$sql1 = "select distinct i.slocid,i.description
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join gidetail h on h.giheaderid=d.giheaderid
							join sloc i on i.slocid=h.slocid
							join salesarea j on j.salesareaid=g.salesareaid
							join gidetail k on k.giheaderid=d.giheaderid
							join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.cutarno is not null and e.companyid = ".$companyid." and 
							b.recordstatus=3 and j.areaname like '%".$salesarea."%' and f.employeeid = ".$row['employeeid']." and
							l.productname like '%".$product."%' and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			foreach($dataReader1 as $row1)
			{
				
				$sql2 = "select *,
									case when umur >= 0 and umur <= 30 then nilaibayar else 0 end as 0sd30,
									case when umur > 30 and umur <= 45 then nilaibayar else 0 end as 31sd45,
									case when umur > 45 and umur <= 60 then nilaibayar else 0 end as 46sd60,
									case when umur > 60 and umur <= 63 then nilaibayar else 0 end as 61sd63,
									case when umur > 63 and umur <= 70 then nilaibayar else 0 end as 64sd70,
									case when umur > 70 and umur <= 90 then nilaibayar else 0 end as 71sd90,
									case when umur > 90 then nilaibayar else 0 end as sd91								
							from (select distinct c.invoiceno,c.invoicedate,b.docdate,g.fullname,datediff(b.docdate,c.invoicedate) as umur,c.amount,
							a.discamount+a.returnamount as disc,a.cashamount+a.bankamount+a.obamount as nilaibayar,
							(select h.slocid from gidetail h where h.giheaderid=d.giheaderid Limit 1) as slocid
							from cutarinv a
							join cutar b on b.cutarid=a.cutarid
							join invoice c on c.invoiceid=a.invoiceid
							join giheader d on d.giheaderid=c.giheaderid
							join soheader e on e.soheaderid=d.soheaderid
							join employee f on f.employeeid=e.employeeid
							join addressbook g on g.addressbookid=e.addressbookid
							join salesarea j on j.salesareaid=g.salesareaid
							join gidetail k on k.giheaderid=d.giheaderid
							join product l on l.productid=k.productid
							where g.fullname like '%".$customer."%' and f.fullname like '%".$sales."%' and b.recordstatus=3 
							and b.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
							and l.productname like '%".$product."%' 
							and j.areaname like '%".$salesarea."%' and e.companyid = ".$companyid." and f.employeeid = ".$row['employeeid']." ) z
							where z.slocid = ".$row1['slocid']."
							order by docdate,fullname
							";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				
				$totaldisc=0;$totalnilaibayar=0;$total0sd30=0;$total31sd45=0;$total46sd60=0;$total61sd63=0;$total64sd70=0;$total71sd90=0;$totalsd91=0;
				foreach($dataReader2 as $row2)
				{
					$totaldisc += ($row2['disc']/$per);
					$totalnilaibayar += ($row2['nilaibayar']/$per);
					$total0sd30 += ($row2['0sd30']/$per);
					$total31sd45 += ($row2['31sd45']/$per);
					$total46sd60 += ($row2['46sd60']/$per);
					$total61sd63 += ($row2['61sd63']/$per);
					$total64sd70 += ($row2['64sd70']/$per);
					$total71sd90 += ($row2['71sd90']/$per);
					$totalsd91 += ($row2['sd91']/$per);
				}
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['description'])										
						->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totaldisc))					
						->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnilaibayar))
						->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($total0sd30))
						->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total31sd45))
						->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($total46sd60))
						->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($total61sd63))
						->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($total64sd70))
						->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total71sd90))
						->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($totalsd91));
				$line++;
				
				$totaldisc1 += $totaldisc;
				$totalnilaibayar1 += $totalnilaibayar;
				$total0sd301 += $total0sd30;
				$total31sd451 += $total31sd45;
				$total46sd601 += $total46sd60;
				$total61sd631 += $total61sd63;
				$total64sd701 += $total64sd70;
				$total71sd901 += $total71sd90;
				$totalsd911 += $totalsd91;			
				
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'TOTAL SALES '.$row['fullname'])				
					->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totaldisc1))										
					->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnilaibayar1))
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($total0sd301))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total31sd451))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($total46sd601))
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($total61sd631))
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($total64sd701))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total71sd901))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($totalsd911));
			$line+=2;
			$totaldisc2 += $totaldisc1;
			$totalnilaibayar2 += $totalnilaibayar1;
			$total0sd302 += $total0sd301;
			$total31sd452 += $total31sd451;
			$total46sd602 += $total46sd601;
			$total61sd632 += $total61sd631;
			$total64sd702 += $total64sd701;
			$total71sd902 += $total71sd901;
			$totalsd912 += $totalsd911;
				
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL ')				
					->setCellValueByColumnAndRow(2,$line,Yii::app()->format->formatCurrency($totaldisc2))										
					->setCellValueByColumnAndRow(3,$line,Yii::app()->format->formatCurrency($totalnilaibayar2))
					->setCellValueByColumnAndRow(4,$line,Yii::app()->format->formatCurrency($total0sd302))
					->setCellValueByColumnAndRow(5,$line,Yii::app()->format->formatCurrency($total31sd452))
					->setCellValueByColumnAndRow(6,$line,Yii::app()->format->formatCurrency($total46sd602))
					->setCellValueByColumnAndRow(7,$line,Yii::app()->format->formatCurrency($total61sd632))
					->setCellValueByColumnAndRow(8,$line,Yii::app()->format->formatCurrency($total64sd702))
					->setCellValueByColumnAndRow(9,$line,Yii::app()->format->formatCurrency($total71sd902))
					->setCellValueByColumnAndRow(10,$line,Yii::app()->format->formatCurrency($totalsd912));
		$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//19
    public function RekapPenjualanVSPelunasanPerBulanPerCustomerXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappenjualanvspelunasanpercustomer';
		parent::actionDownxls();
		$total2sd0=0;$total20sd30=0;$total231sd60=0;$total261sd90=0;$total291sd120=0;$total2sd120=0;$totaltempo2=0;$total2=0;
		$sql = "select * from
				(select z.fullname,
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=1 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=1 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_jan, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=1 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jan,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=2 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=2 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_feb, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=2 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_feb,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=3 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=3 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_mar, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=3 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_mar,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=4 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=4 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_apr, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=4 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_apr,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=5 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=5 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_mei, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=5 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_mei,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=6 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=6 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_jun, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=6 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jun,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=7 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=7 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_jul, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=7 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_jul,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=8 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=8 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_agus, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=8 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_agus,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=9 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=9 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_sept, 
                
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=9 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_sept,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=10 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=10 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_okt, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=10 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_okt,
                
                
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=11 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=11 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_nov, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=11 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_nov,
                
               
				((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(aa.gidate)=12 and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and month(c.gireturdate)=12 and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_des, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=12 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_des,
                
                ((select ifnull(sum(ifnull(a.amount,0)),0)
				from invoice a 
				join giheader aa on aa.giheaderid=a.giheaderid
				join soheader aaa on aaa.soheaderid=aa.soheaderid
                join employee f on f.employeeid=aaa.employeeid
				where a.recordstatus=3 and aaa.companyid = ".$companyid." and aaa.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and year(aa.gidate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))
				-
				(select ifnull(sum(ifnull(a.qty,0)*ifnull(a.price,0)),0)
				from notagirpro a
				join notagir b on b.notagirid=a.notagirid
				join giretur c on c.gireturid=b.gireturid
				join giheader d on d.giheaderid=c.giheaderid
				join soheader e on e.soheaderid=d.soheaderid
                join employee f on f.employeeid=e.employeeid
				where b.recordstatus=3 and e.companyid = ".$companyid." and e.addressbookid=z.addressbookid and f.fullname like '%".$sales."%' and year(c.gireturdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'))) as penj_total, 
                
                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."') and c1.addressbookid = z.addressbookid ) as byr_total
                
                
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz 
                where penj_jan<>0 or byr_jan<>0 or penj_feb<>0 or byr_feb<>0 or penj_mar<>0 or byr_mar<>0 or penj_apr<>0 or byr_apr<>0 or penj_mei<>0 or byr_mei<>0 or penj_jun<>0 or byr_jun<>0 or penj_jul<>0 or byr_jul<>0 or penj_agus<>0 or byr_agus<>0 or penj_sept<>0 or byr_sept<>0 or penj_okt<>0 or byr_okt<>0 or penj_nov<>0 or byr_nov<>0 or penj_des<>0 or byr_des<>0 "; 
								
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            $i=1;
        $line=6;
      $this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,'Per Tahun')							
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
            foreach($dataReader as $row){
						$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)							
							->setCellValueByColumnAndRow(1,$line,$row['fullname'])
                            ->setCellValueByColumnAndRow(2,$line,$row['penj_jan']/$per)
                          ->setCellValueByColumnAndRow(3,$line,$row['byr_jan']/$per)
                          ->setCellValueByColumnAndRow(4,$line,$row['penj_feb']/$per)
                          ->setCellValueByColumnAndRow(5,$line,$row['byr_feb']/$per)
                          ->setCellValueByColumnAndRow(6,$line,$row['penj_mar']/$per)
                          ->setCellValueByColumnAndRow(7,$line,$row['byr_mar']/$per)
                          ->setCellValueByColumnAndRow(8,$line,$row['penj_apr']/$per)
                          ->setCellValueByColumnAndRow(9,$line,$row['byr_apr']/$per)
                          ->setCellValueByColumnAndRow(10,$line,$row['penj_mei']/$per)
                          ->setCellValueByColumnAndRow(11,$line,$row['byr_mei']/$per)
                          ->setCellValueByColumnAndRow(12,$line,$row['penj_jun']/$per)
                           ->setCellValueByColumnAndRow(13,$line,$row['byr_jun']/$per)
                          ->setCellValueByColumnAndRow(14,$line,$row['penj_jul']/$per)
                           ->setCellValueByColumnAndRow(15,$line,$row['byr_jul']/$per)
                          ->setCellValueByColumnAndRow(16,$line,$row['penj_agus']/$per)
                           ->setCellValueByColumnAndRow(17,$line,$row['byr_agus']/$per)
                          ->setCellValueByColumnAndRow(18,$line,$row['penj_sept']/$per)
                           ->setCellValueByColumnAndRow(19,$line,$row['byr_sept']/$per)
                          ->setCellValueByColumnAndRow(20,$line,$row['penj_okt']/$per)
                           ->setCellValueByColumnAndRow(21,$line,$row['byr_okt']/$per)
                          ->setCellValueByColumnAndRow(22,$line,$row['penj_nov']/$per)
                           ->setCellValueByColumnAndRow(23,$line,$row['byr_nov']/$per)
                          ->setCellValueByColumnAndRow(24,$line,$row['penj_des']/$per)
                           ->setCellValueByColumnAndRow(25,$line,$row['byr_des']/$per)
                          ->setCellValueByColumnAndRow(26,$line,$row['penj_total']/$per)
                           ->setCellValueByColumnAndRow(27,$line,$row['byr_total']/$per);
							$line++; $i++;
                          
						

               
						}
					
		
		$this->getFooterXLS($this->phpExcel);
	}
  //20
    public function RekapPiutangVSPelunasanPerBulanPerCustomerXLS($companyid,$sloc,$materialgroup,$customer,$product,$sales,$salesarea,$startdate,$enddate,$per)
	{
		$this->menuname='rekappiutangvspelunasanperbulanpercustomer';
		parent::actionDownxls();
		$sql = "select * from
				(select z.fullname,
				(select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-01-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-01-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jan, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=1 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jan,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-02-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-02-01'))) zz where zz.addressbookid = z.addressbookid) as piu_feb, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=2 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_feb,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-03-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-03-01'))) zz where zz.addressbookid = z.addressbookid) as piu_mar, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=3 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_mar,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-04-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-04-01'))) zz where zz.addressbookid = z.addressbookid) as piu_apr, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=4 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_apr,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-05-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-05-01'))) zz where zz.addressbookid = z.addressbookid) as piu_mei, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=5 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_mei,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-06-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-06-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jun, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=6 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jun,
               
               
               (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-07-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-07-01'))) zz where zz.addressbookid = z.addressbookid) as piu_jul, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=7 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_jul,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-08-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-08-01'))) zz where zz.addressbookid = z.addressbookid) as piu_agus, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=8 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_agus,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-09-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-09-01'))) zz where zz.addressbookid = z.addressbookid) as piu_sept, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=9 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_sept,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-10-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-10-01'))) zz where zz.addressbookid = z.addressbookid) as piu_okt, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=10 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_okt,
                
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-11-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-11-01'))) zz where zz.addressbookid = z.addressbookid) as piu_nov, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=11 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_nov,
                
                (select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid and g.docdate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-12-01'))),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' and a.invoicedate <= LAST_DAY(CONCAT(YEAR('".date(Yii::app()->params['datetodb'], strtotime($startdate))."'),'-12-01'))) zz where zz.addressbookid = z.addressbookid) as piu_des, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and month(g1.docdate)=12 and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_des,
                
                
				(select ifnull(sum(amount),0) from (select c.addressbookid,a.amount - ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
                from cutarinv f
                join cutar g on g.cutarid=f.cutarid
                where g.recordstatus=3 and f.invoiceid=a.invoiceid),0) as amount
                from invoice a
                inner join giheader b on b.giheaderid = a.giheaderid
                inner join soheader c on c.soheaderid = b.soheaderid
                inner join employee ff on ff.employeeid = c.employeeid
                WHERE a.recordstatus=3 and c.companyid= ".$companyid." and ff.fullname like '%".$sales."%' 
               ) zz where zz.addressbookid = z.addressbookid) as piu_total, 

                (select ifnull(sum((ifnull(f1.cashamount,0)+ifnull(f1.bankamount,0)+ifnull(f1.discamount,0)+ifnull(f1.returnamount,0)+ifnull(f1.obamount,0))*ifnull(f1.currencyrate,0)),0)
                from cutarinv f1
                join invoice a1 on a1.invoiceid = f1.invoiceid
                join cutar g1 on g1.cutarid=f1.cutarid
                join giheader b1 on b1.giheaderid = a1.giheaderid
                join soheader c1 on c1.soheaderid = b1.soheaderid
                join employee d1 on d1.employeeid = c1.employeeid
                where g1.recordstatus=3  AND c1.companyid= ".$companyid." and d1.fullname like '%".$sales."%' and year(g1.docdate)=year('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and c1.addressbookid = z.addressbookid ) as byr_total
                
					 
                
				from addressbook z
				where z.recordstatus=1 and z.iscustomer=1 and z.fullname is not null order by fullname asc) zz 
                
                where piu_jan<>0 or byr_jan<>0 or piu_feb<>0 or byr_feb<>0 or piu_mar<>0 or byr_mar<>0 or piu_apr<>0 or byr_apr<>0 or piu_mei<>0 or byr_mei<>0 or piu_jun<>0 or byr_jun<>0 or piu_jul<>0 or byr_jul<>0 or piu_agus<>0 or byr_agus<>0 or piu_sept<>0 or byr_sept<>0 or piu_okt<>0 or byr_okt<>0 or piu_nov<>0 or byr_nov<>0 or piu_des<>0 or byr_des<>0 "; 
								
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            /*
            $this->phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,2,'Rekap Piutang VS Pelunasan Per Bulan Per Customer')
                                                   ->setCellValueByColumnAndRow(1,3,'Per Tahun : '.date(Yii::app()->params['datetodb'], strtotime($startdate)))
                                                   ->setCellValueByColumnAndRow(0,4,'No')
                                                   ->setCellValueByColumnAndRow(1,4,'Customer')
                                                   ->mergeCells('C4:D4')
                                                   ->setCellValueByColumnAndRow(2,4,'Januari')
                                                   ->mergeCells('E4:F4')
                                                   ->setCellValueByColumnAndRow(4,4,'Februari')
                                                   ->mergeCells('G4:H4')
                                                   ->setCellValueByColumnAndRow(6,4,'Maret')
                                                   ->mergeCells('I4:J4')
                                                   ->setCellValueByColumnAndRow(8,4,'April')
                                                   ->mergeCells('K4:L4')
                                                   ->setCellValueByColumnAndRow(10,4,'Mei')
                                                   ->mergeCells('M4:N4')
                                                   ->setCellValueByColumnAndRow(12,4,'Juni')
                                                   ->mergeCells('O4:P4')
                                                   ->setCellValueByColumnAndRow(14,4,'Juli')
                                                   ->mergeCells('Q4:R4')
                                                   ->setCellValueByColumnAndRow(16,4,'Agustus')
                                                   ->mergeCells('S4:T4')
                                                   ->setCellValueByColumnAndRow(18,4,'September')
                                                   ->mergeCells('U4:V4')
                                                   ->setCellValueByColumnAndRow(20,4,'Oktober')
                                                   ->mergeCells('W4:X4')
                                                   ->setCellValueByColumnAndRow(22,4,'November')
                                                   ->mergeCells('Y4:Z4')
                                                   ->setCellValueByColumnAndRow(24,4,'Desember')
                                                   ->mergeCells('AA4:AB4')
                                                   ->setCellValueByColumnAndRow(26,4,'Total');
        
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,5,'')
                                                   ->setCellValueByColumnAndRow(1,5,'')
                                                   ->setCellValueByColumnAndRow(2,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(3,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(4,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(5,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(6,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(7,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(8,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(9,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(10,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(11,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(12,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(13,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(14,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(15,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(16,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(17,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(18,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(19,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(20,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(21,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(22,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(23,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(24,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(25,5,'Pelunasan')
                                                   ->setCellValueByColumnAndRow(26,5,'Piutang')
                                                   ->setCellValueByColumnAndRow(27,5,'Pelunasan');
            */
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,2,'')
                                                   ->setCellValueByColumnAndRow(3,2,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)));
            $line=6;
		    $i=1;
						foreach($dataReader as $row)
						{
							$this->phpExcel->getActiveSheet()->getStyle(1,$line)->getFont()->setBold(true);
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0,$line,$i)
									->setCellValueByColumnAndRow(1,$line,$row['fullname'])
									->setCellValueByColumnAndRow(2,$line,$row['piu_jan']/$per)							
									->setCellValueByColumnAndRow(3,$line,$row['byr_jan']/$per)							
									->setCellValueByColumnAndRow(4,$line,$row['piu_feb']/$per)							
									->setCellValueByColumnAndRow(5,$line,$row['byr_feb']/$per)							
									->setCellValueByColumnAndRow(6,$line,$row['piu_mar']/$per)							
									->setCellValueByColumnAndRow(7,$line,$row['byr_mar']/$per)							
                                    ->setCellValueByColumnAndRow(8,$line,$row['piu_apr']/$per)							
									->setCellValueByColumnAndRow(9,$line,$row['byr_apr']/$per)							
									->setCellValueByColumnAndRow(10,$line,$row['piu_mei']/$per)							
									->setCellValueByColumnAndRow(11,$line,$row['byr_mei']/$per)							
									->setCellValueByColumnAndRow(12,$line,$row['piu_jun']/$per)							
									->setCellValueByColumnAndRow(13,$line,$row['byr_jun']/$per)							
									->setCellValueByColumnAndRow(14,$line,$row['piu_jul']/$per)							
									->setCellValueByColumnAndRow(15,$line,$row['byr_jul']/$per)							
									->setCellValueByColumnAndRow(16,$line,$row['piu_agus']/$per)							
									->setCellValueByColumnAndRow(17,$line,$row['byr_agus']/$per)							
									->setCellValueByColumnAndRow(18,$line,$row['piu_sept']/$per)							
									->setCellValueByColumnAndRow(19,$line,$row['byr_sept']/$per)							
									->setCellValueByColumnAndRow(20,$line,$row['piu_okt']/$per)							
									->setCellValueByColumnAndRow(21,$line,$row['byr_okt']/$per)							
									->setCellValueByColumnAndRow(22,$line,$row['piu_nov']/$per)							
									->setCellValueByColumnAndRow(23,$line,$row['byr_nov']/$per)							
									->setCellValueByColumnAndRow(24,$line,$row['piu_des']/$per)							
									->setCellValueByColumnAndRow(25,$line,$row['byr_des']/$per)							
									->setCellValueByColumnAndRow(26,$line,$row['piu_total']/$per)							
									->setCellValueByColumnAndRow(27,$line,$row['byr_total']/$per);
				            $i++;
							$line++;
                        }
		$this->getFooterXLS($this->phpExcel);
	}
	
}

