<?php

class ReportaccController extends AdminController
{
	protected $menuname = 'reportacc';		
	public $module = 'accounting';
	protected $pageTitle = 'Laporan Akuntansi';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
		
	public function actionDownPDF()
	{
	  parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['materialgroup']) && isset($_GET['customer']) && isset($_GET['account']) 
						&& isset($_GET['startacccode']) && isset($_GET['endacccode'])&& isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 1)
			{
							$this->RincianJurnalTransaksi($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startacccode'],$_GET['endacccode'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 2)
			{
							$this->BukuBesar($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startacccode'],$_GET['endacccode'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 3)
			{
							$this->NeracaUjiCoba($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 4)
			{
							$this->LabaRugiUjiCoba($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 5)
			{
							$this->RincianUmurPiutangGiro($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
							$this->RekapUmurPiutangGiro($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
							$this->RincianGiroCairEkstern($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
							$this->RincianGiroTolakEkstern($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
							$this->RincianGiroOpnameEkstern($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
							$this->RincianUmurHutangGiro($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
							$this->RekapUmurHutangGiro($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
							$this->RincianGiroCairIntern($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 13)
			{
							$this->RincianGiroTolakIntern($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 14)
			{
							$this->RekapJurnalUmumPerDokumenBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 15)
			{
							$this->RekapPenerimaanKasBankPerDokumentBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 16)
			{
							$this->RekapPengeluaranKasBankPerDokumentBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 17)
			{
							$this->RekapCashBankPerDokumentBelumStatusMax($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	//1
	public function RincianJurnalTransaksi($companyid,$sloc,$product,$materialgroup,$customer,$account,$startacccode,$endacccode,$startdate,$enddate,$per)
  {
    parent::actionDownPDF();
    $debit=0;$credit=0;
    $sql = "select distinct a.genjournalid,
						ifnull(b.companyname,'-')as company,
						ifnull(a.journalno,'-')as journalno,
						ifnull(a.referenceno,'-')as referenceno,
						a.journaldate,a.postdate,
						ifnull(a.journalnote,'-')as journalnote,a.recordstatus
						from genjournal a
						join company b on b.companyid = a.companyid
						join genledger c on c.genjournalid = a.genjournalid
						join account d on d.accountid = c.accountid
						where a.companyid = ".$companyid." and d.accountname like '%".$account."%'
						and a.journaldate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						 and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						";
			if (($_GET['startacccode'] !== '')&&($_GET['endacccode'] !== '')) {
						$sql = $sql . "and d.accountcode between '".$_GET['startacccode']."' and '".$_GET['endacccode']."'
						";
					}
    
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
    foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title = $this->getcatalog('genjournal');
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 10);
    $this->pdf->AliasNBPages();
    foreach ($dataReader as $row) 
		{
			$this->pdf->setFont('Arial', 'B', 10);
      $this->pdf->text(15, $this->pdf->gety() + 5, 'No Journal ');
      $this->pdf->text(50, $this->pdf->gety() + 5, ': ' . $row['journalno']);
      $this->pdf->text(15, $this->pdf->gety() + 10, 'Ref No ');
      $this->pdf->text(50, $this->pdf->gety() + 10, ': ' . $row['referenceno']);
      $this->pdf->text(15, $this->pdf->gety() + 15, 'Tgl Jurnal ');
      $this->pdf->text(50, $this->pdf->gety() + 15, ': ' . $row['journaldate']);
      $sql1 = "select b.accountcode,b.accountname, a.debit,a.credit,c.symbol,a.detailnote,a.ratevalue
							from journaldetail a
							left join account b on b.accountid = a.accountid
							left join currency c on c.currencyid = a.currencyid
							where a.genjournalid = '" . $row['genjournalid'] . "'
							order by journaldetailid ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,30,30,10,55));
      $this->pdf->colheader = array('No','Account','Debit','Credit','Rate','Detail Note');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->coldetailalign = array('C','L','R','R','R','L');
      $i=0;
      foreach ($dataReader1 as $row1) 
			{
        $i=$i+1;
        $debit  = $debit + ($row1['debit']/$per * $row1['ratevalue']);
        $credit = $credit + ($row1['credit']/$per * $row1['ratevalue']);
        $this->pdf->row(array(
          $i,
          $row1['accountcode'] . ' ' . $row1['accountname'],
          Yii::app()->numberFormatter->formatCurrency($row1['debit']/$per, $row1['symbol']),
          Yii::app()->numberFormatter->formatCurrency($row1['credit']/$per, $row1['symbol']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"], $row1['ratevalue']),
          $row1['detailnote']
        ));
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->formatCurrency($debit, $row1['symbol']),
        Yii::app()->numberFormatter->formatCurrency($credit, $row1['symbol']),
        '',
        ''
      ));
      $this->pdf->sety($this->pdf->gety());
      $this->pdf->border = false;
      $this->pdf->setwidths(array(
        20,
        175
      ));
      $this->pdf->row(array(
        'Note',
        $row['journalnote']
      ));
      $this->pdf->CheckNewPage(35);
    }
    $this->pdf->Output();
  }
	//2
  public function BukuBesar($companyid,$sloc,$product,$materialgroup,$customer,$account,$startacccode,$endacccode,$startdate,$enddate,$per)
  {
    parent::actionDownPDF();
    $totalawal1=0;$totaldebit1=0;$totalcredit1=0;
    $sql = "select distinct b.accountid,b.accountname,b.accountcode
            from genledger b 
            where b.companyid = '".$companyid."' and b.accountname like '%".$account."%'
            and b.journaldate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";

					if (($_GET['startacccode'] !== '')&&($_GET['endacccode'] !== '')) {
						$sql = $sql . "and b.accountcode between '".$_GET['startacccode']."' and '".$_GET['endacccode']."'
						";
					}
    $sql = $sql . " order by b.accountcode";

    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

    foreach($dataReader as $row)
    {
        $this->pdf->companyid = $companyid;
    }
    $this->pdf->title='Buku Besar';
    $this->pdf->subtitle = 'Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');

    foreach($dataReader as $row)
    {
      $sql1 = "select sum(ifnull(zz.debit,0)-ifnull(zz.credit,0)) as saldoawal
            from genledger zz 
            where zz.accountid = '".$row['accountid']."'
            and zz.journaldate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'";

      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach($dataReader1 as $row1)
      {
        $this->pdf->SetFont('Arial','',10);
        //$this->pdf->text(10,$this->pdf->gety()+10,$row['accountcode']);
        $this->pdf->text(10,$this->pdf->gety()+5,$row['accountcode']);
        $this->pdf->text(40,$this->pdf->gety()+5,' '.$row['accountname']);
        $this->pdf->text(235,$this->pdf->gety()+5,'Saldo Awal :  '.Yii::app()->format->formatCurrency($row1['saldoawal']/$per));

        $sql2 = "select a.journalno,a.journaldate,a.referenceno,a.journalnote,b.debit,b.credit,b.detailnote
               from genjournal a
               join journaldetail b on b.genjournalid = a.genjournalid
               where a.recordstatus = 3 and b.accountid = '".$row['accountid']."'
               and a.journaldate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
               and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
               order by a.journaldate,a.referenceno";

        $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $saldo=0;$i=0;

        $this->pdf->setFont('Arial','B',8);
        $this->pdf->sety($this->pdf->gety()+7);
        $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
        $this->pdf->setwidths(array(10,18,17,22,30,100,25,25,28));
        $this->pdf->colheader = array('No','Dokumen','Tanggal','Referensi','Keterangan','Uraian','Debet','Credit','Saldo');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('R','C','C','C','L','L','R','R','R');		
        $saldo=0;$i=0;$totaldebit=0;$totalcredit=0;

        foreach($dataReader2 as $row2)
        {
          $i+=1;
          $this->pdf->setFont('Arial','',8);
          $this->pdf->row(array(
            $i,
            $row2['journalno'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row2['journaldate'])),
            $row2['referenceno'],$row2['journalnote'],
            $row2['detailnote'],
            Yii::app()->format->formatCurrency($row2['debit']/$per),
            Yii::app()->format->formatCurrency($row2['credit']/$per),'-'
          ));
          $totaldebit += $row2['debit']/$per;
          $totalcredit += $row2['credit']/$per;		               
        }
        $this->pdf->row(array(
          '','','','','','TOTAL : ',
          Yii::app()->format->formatCurrency($totaldebit),
          Yii::app()->format->formatCurrency($totalcredit),
          Yii::app()->format->formatCurrency(($row1['saldoawal']/$per) + $totaldebit - $totalcredit)
        ));
        $totalawal1 += $row1['saldoawal']/$per;
        $totaldebit1 += $totaldebit;
        $totalcredit1 += $totalcredit;

        $this->pdf->sety($this->pdf->gety()+5);
        $this->pdf->checkPageBreak(10);
      }
    }
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->setwidths(array(10,50,5,35));
		$this->pdf->coldetailalign = array('C','L','C','R');
		
		$this->pdf->row(array(
			'','TOTAL SALDO AWAL ',':',
			Yii::app()->format->formatCurrency($totalawal1)
			));
		$this->pdf->row(array(
			'','TOTAL MUTASI DEBIT ',':',
			Yii::app()->format->formatCurrency($totaldebit1)
			));
		$this->pdf->row(array(
			'','TOTAL MUTASI CREDIT ',':',
			Yii::app()->format->formatCurrency($totalcredit1)
			));
		$this->pdf->row(array(
			'','TOTAL SALDO AKHIR ',':',
			Yii::app()->format->formatCurrency($totalawal1 + $totaldebit1 - $totalcredit1)
			));		
						
    $this->pdf->Output();
  }
	//3
	public function NeracaUjiCoba($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
  {
		parent::actionDownPDF();
		$i=0;$bulanini=0;$bulanlalu=0;
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode < '19%') z 
					where z.bulanini <> 0 or z.bulanlalu <> 0
					order by accountcode asc";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Neraca - Uji Coba';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety());
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->setwidths(array(10,80,30,35,35));
		$this->pdf->colheader = array('No','Nama Akun','Kode Akun','Bulan Ini','Bulan Lalu');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','R','R');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',8);
			$i+=1;
			$this->pdf->row(array(
				$i,$row['accountname'],
				$row['accountcode'],
				Yii::app()->format->formatCurrency($row['bulanini']/$per),
				Yii::app()->format->formatCurrency($row['bulanlalu']/$per),
			));
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->row(array(
			'','',
			'TOTAL AKTIVA',
			Yii::app()->format->formatCurrency($bulanini),
			Yii::app()->format->formatCurrency($bulanlalu),
		));
				
		$i=0;$bulanini=0;$bulanlalu=0;
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode between '2%' and '29%'
					order by a.accountcode asc) z where z.bulanini <> 0 or z.bulanlalu <> 0";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Neraca - Uji Coba';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety());
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->setwidths(array(10,80,30,35,35));
		$this->pdf->colheader = array('No','Nama Akun','Kode Akun','Bulan Ini','Bulan Lalu');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','R','R');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',8);
			$i+=1;
			$this->pdf->row(array(
				$i,$row['accountname'],
				$row['accountcode'],
				Yii::app()->format->formatCurrency($row['bulanini']/$per),
				Yii::app()->format->formatCurrency($row['bulanlalu']/$per),
			));
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->row(array(
			'','',
			'TOTAL PASIVA',
			Yii::app()->format->formatCurrency($bulanini),
			Yii::app()->format->formatCurrency($bulanlalu),
		));	
		
		$this->pdf->Output();
	}
	//4
	public function LabaRugiUjiCoba($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
  {
		parent::actionDownPDF();
		$i=0;$bulanini=0;$bulanlalu=0;
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					and year(c.journaldate) = year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month)))
					and year(c.journaldate) = year(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month)))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode > '3%'
					order by a.accountcode asc) z where z.bulanini <> 0 or z.bulanlalu <> 0";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Laba (Rugi) - Uji Coba';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety());
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->setwidths(array(10,80,30,35,35));
		$this->pdf->colheader = array('No','Nama Akun','Kode Akun','Bulan Ini','Bulan Lalu');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','R','R');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',8);
			$i+=1;
			$this->pdf->row(array(
				$i,$row['accountname'],
				$row['accountcode'],
				Yii::app()->format->formatCurrency($row['bulanini']/$per),
				Yii::app()->format->formatCurrency($row['bulanlalu']/$per),
			));
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->row(array(
			'','LABA (RUGI) BERSIH',
			'',
			Yii::app()->format->formatCurrency($bulanini),
			Yii::app()->format->formatCurrency($bulanlalu),
		));
				
		$this->pdf->Output();
	}
	//5
	public function RincianUmurPiutangGiro($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Umur Piutang Giro';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,20,30,120,30));
			$this->pdf->colheader = array('',' ','','Tanggal','Sudah','Belum Jatuh Tempo','');
			$this->pdf->RowHeader();
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,20,30,30,30,30,30,30));
			$this->pdf->colheader = array('No','Nama Bank','No Cek/Giro','J_Tempo','J_Tempo','1-30 Hari','31-60 Hari','61-90 Hari','> 90 Hari','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(10,40,25,20,30,30,30,30,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select *,
							case when umur > 0 then amount else 0 end as amounttempo,
							case when umur <= 0 and umur >= -30 then amount else 0 end as 1sd30,
							case when umur <= -31 and umur >= -60 then amount else 0 end as 31sd60,
							case when umur <= -61 and umur >= -90 then amount else 0 end as 61sd90,
							case when umur < -90 then amount else 0 end as sd90
							from
							(select c.bankname,a.chequeno,a.tgltempo,a.amount,
							datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.tgltempo) as umur
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							)z order by tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					Yii::app()->format->formatCurrency($row1['amounttempo']/$per),
					Yii::app()->format->formatCurrency($row1['1sd30']/$per),
					Yii::app()->format->formatCurrency($row1['31sd60']/$per),
					Yii::app()->format->formatCurrency($row1['61sd90']/$per),
					Yii::app()->format->formatCurrency($row1['sd90']/$per),
					Yii::app()->format->formatCurrency($row1['amount']/$per),
				));
				$amounttempo += ($row1['amounttempo']/$per);
				$amount1sd30 += ($row1['1sd30']/$per);
				$amount31sd60 += ($row1['31sd60']/$per);
				$amount61sd90 += ($row1['61sd90']/$per);
				$amountsd90 += ($row1['sd90']/$per);
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(95,30,30,30,30,30,30));
			$this->pdf->coldetailalign = array('R','R','R','R','R','R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amounttempo),
				Yii::app()->format->formatCurrency($amount1sd30),
				Yii::app()->format->formatCurrency($amount31sd60),
				Yii::app()->format->formatCurrency($amount61sd90),
				Yii::app()->format->formatCurrency($amountsd90),
				Yii::app()->format->formatCurrency($amount),
			));
			$amounttempo2 += $amounttempo;
			$amount1sd302 += $amount1sd30;
			$amount31sd602 += $amount31sd60;
			$amount61sd902 += $amount61sd90;
			$amountsd902 += $amountsd90;
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(95,30,30,30,30,30,30));
		$this->pdf->coldetailalign = array('R','R','R','R','R','R','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO',
			Yii::app()->format->formatCurrency($amounttempo2),
			Yii::app()->format->formatCurrency($amount1sd302),
			Yii::app()->format->formatCurrency($amount31sd602),
			Yii::app()->format->formatCurrency($amount61sd902),
			Yii::app()->format->formatCurrency($amountsd902),
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//6
	public function RekapUmurPiutangGiro($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "	select *
					from (select a.fullname,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <'".date(Yii::app()->params['datetodb'], strtotime($startdate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."')),0) as saldoawal,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as debit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and ((b.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					or (b.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))),0) as credit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')),0) as saldoakhir,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur > 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd0,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -30 and 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd30,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -60 and -31 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd60,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -90 and -61 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd90,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur < -90 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd91
					from addressbook a
					where a.iscustomer= 1 and a.fullname like '%".$customer."%') z
					where saldoawal <> 0 or debit <> 0 or credit <> 0 or saldoakhir <> 0
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Umur Piutang Giro';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,40,100,25,100));
			$this->pdf->colheader = array('','Nama','Mutasi','Sudah','Belum Jatuh Tempo');
			$this->pdf->RowHeader();
			$this->pdf->setwidths(array(7,40,25,25,25,25,25,25,25,25,25));
			$this->pdf->colheader = array('No','Customer','S.Awal','Debit','Credit','S.Akhir','JTT','1-30 Hari','31-60 Hari','61-90 Hari','>90 Hari');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','R','R','R','R','R','R','R','R','R','R');
			$i=0;$totalsaldoawal=0;$totaldebit=0;$totalcredit=0;$totalsaldoakhir=0;$totalsd0=0;$totalsd30=0;$totalsd60=0;$totalsd90=0;$totalsd91=0;

		foreach($dataReader as $row)
		{	
			$i+=1;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->row(array(
				$i,
				$row['fullname'],
				Yii::app()->format->formatCurrency($row['saldoawal']/$per),
				Yii::app()->format->formatCurrency($row['debit']/$per),
				Yii::app()->format->formatCurrency($row['credit']/$per),
				Yii::app()->format->formatCurrency($row['saldoakhir']/$per),
				Yii::app()->format->formatCurrency($row['sd0']/$per),
				Yii::app()->format->formatCurrency($row['sd30']/$per),
				Yii::app()->format->formatCurrency($row['sd60']/$per),
				Yii::app()->format->formatCurrency($row['sd90']/$per),
				Yii::app()->format->formatCurrency($row['sd90']/$per),
			));
			$totalsaldoawal += ($row['saldoawal']/$per);
			$totaldebit += ($row['debit']/$per);
			$totalcredit += ($row['credit']/$per);
			$totalsaldoakhir += ($row['saldoakhir']/$per);
			$totalsd0 += ($row['sd0']/$per);
			$totalsd30 += ($row['sd30']/$per);
			$totalsd60 += ($row['sd60']/$per);
			$totalsd90 += ($row['sd90']/$per);
			$totalsd91 += ($row['sd91']/$per);
			$this->pdf->checkPageBreak(0);
		}
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'',
			'GRAND TOTAL ',
			Yii::app()->format->formatCurrency($totalsaldoawal),
			Yii::app()->format->formatCurrency($totaldebit),
			Yii::app()->format->formatCurrency($totalcredit),
			Yii::app()->format->formatCurrency($totalsaldoakhir),
			Yii::app()->format->formatCurrency($totalsd0),
			Yii::app()->format->formatCurrency($totalsd30),
			Yii::app()->format->formatCurrency($totalsd60),
			Yii::app()->format->formatCurrency($totalsd90),
			Yii::app()->format->formatCurrency($totalsd91),
		));
		$this->pdf->Output();
	}
	//7	
	public function RincianGiroCairEkstern($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Cek/Giro Cair - Ekstern';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->colheader = array('No','Nama Bank','No. Cek / Giro','Tgl C/G','J_Tempo','Tgl Cair','Nilai Giro','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tglcair,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair != '1970-01-01' or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tglcair";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcair'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),'',
				));
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C');
			$this->pdf->setwidths(array(132,30));
			$this->pdf->coldetailalign = array('R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amount),
			));
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(132,30));
		$this->pdf->coldetailalign = array('L','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO  -- >',
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//8
	public function RincianGiroTolakEkstern($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tgltolak != '1970-01-01'
						and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Cek/Giro Tolak - Ekstern';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->colheader = array('No','Nama Bank','No. Cek / Giro','Tgl C/G','J_Tempo','Tgl Tolak','Nilai Giro','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tgltolak,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tgltolak != '1970-01-01'
							and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tgltolak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltolak'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),'',
				));
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C');
			$this->pdf->setwidths(array(132,30));
			$this->pdf->coldetailalign = array('R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amount),
			));
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(132,30));
		$this->pdf->coldetailalign = array('L','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO  -- >',
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//9
	public function RincianGiroOpnameEkstern($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname,tgltempo";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Cek/Giro Opname - Ekstern';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,20,40,40,20,20,30,10));
			$this->pdf->colheader = array('No','Tanggal','Dari Customer','Nama Bank','No. Cek/Giro','J_Tempo','Nilai Giro','V');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','L','R','R','R','C');

		foreach($dataReader as $row)
		{	
			$this->pdf->setwidths(array(7,20,40,40,20,20,30,10));
			$this->pdf->coldetailalign = array('R','L','L','L','R','R','R','C');
			$i=0;$amount=0;
			$sql1 = "select a.tglcheque,b.fullname,c.bankname,a.chequeno,a.tgltempo,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname,tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+0);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])),
					$row1['fullname'],
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),'[     ]',
				));
				$amount += ($row1['amount']/$per);
			}
			$amount2 += $amount;
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','',8);
		$this->pdf->setwidths(array(92,50,5,30));
		$this->pdf->coldetailalign = array('C','L','R','R');
		$this->pdf->row(array(
			'','SALDO ADM (PEMBUKUAN)',':',
			Yii::app()->format->formatCurrency($amount2),
		));
		$this->pdf->row(array(
			'','SALDO CHECK FISIK',':','',
		));
		$this->pdf->row(array(
			'','SELISIH',':','',
		));
			
		$this->pdf->setFont('Arial','',9);
		$this->pdf->sety($this->pdf->gety()+10);
		/*$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
		$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');*/
		$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(65,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(115,$this->pdf->gety(),'  Diketahui oleh,');$this->pdf->text(165,$this->pdf->gety(),'   Disetujui oleh,');
		$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(65,$this->pdf->gety()+22,'.........................');$this->pdf->text(115,$this->pdf->gety()+22,'...........................');$this->pdf->text(165,$this->pdf->gety()+22,'.............................');
		$this->pdf->text(15,$this->pdf->gety()+25,'        Kasir');$this->pdf->text(65,$this->pdf->gety()+25,'     Controller');$this->pdf->text(115,$this->pdf->gety()+25,'Chief Accounting');$this->pdf->text(165,$this->pdf->gety()+25,'Pimpinan Cabang');
		$this->pdf->checkNewPage(25);
		
		$this->pdf->Output();
	}
	//10
	public function RincianUmurHutangGiro($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Umur Hutang Giro';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,20,30,120,30));
			$this->pdf->colheader = array('',' ','','Tanggal','Sudah','Belum Jatuh Tempo','');
			$this->pdf->RowHeader();
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,20,30,30,30,30,30,30));
			$this->pdf->colheader = array('No','Nama Bank','No Cek/Giro','J_Tempo','J_Tempo','1-30 Hari','31-60 Hari','61-90 Hari','> 90 Hari','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(10,40,25,20,30,30,30,30,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select *,
							case when umur >= 0 then amount else 0 end as amounttempo,
							case when umur <= -1 and umur >= -30 then amount else 0 end as 1sd30,
							case when umur <= -31 and umur >= -60 then amount else 0 end as 31sd60,
							case when umur <= -61 and umur >= -90 then amount else 0 end as 61sd90,
							case when umur < -90 then amount else 0 end as sd90
							from
							(select c.bankname,a.chequeno,a.tgltempo,a.amount,
							datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.tgltempo) as umur
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							)z order by tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					Yii::app()->format->formatCurrency($row1['amounttempo']/$per),
					Yii::app()->format->formatCurrency($row1['1sd30']/$per),
					Yii::app()->format->formatCurrency($row1['31sd60']/$per),
					Yii::app()->format->formatCurrency($row1['61sd90']/$per),
					Yii::app()->format->formatCurrency($row1['sd90']/$per),
					Yii::app()->format->formatCurrency($row1['amount']/$per),
				));
				$amounttempo += ($row1['amounttempo']/$per);
				$amount1sd30 += ($row1['1sd30']/$per);
				$amount31sd60 += ($row1['31sd60']/$per);
				$amount61sd90 += ($row1['61sd90']/$per);
				$amountsd90 += ($row1['sd90']/$per);
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(95,30,30,30,30,30,30));
			$this->pdf->coldetailalign = array('R','R','R','R','R','R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amounttempo),
				Yii::app()->format->formatCurrency($amount1sd30),
				Yii::app()->format->formatCurrency($amount31sd60),
				Yii::app()->format->formatCurrency($amount61sd90),
				Yii::app()->format->formatCurrency($amountsd90),
				Yii::app()->format->formatCurrency($amount),
			));
			$amounttempo2 += $amounttempo;
			$amount1sd302 += $amount1sd30;
			$amount31sd602 += $amount31sd60;
			$amount61sd902 += $amount61sd90;
			$amountsd902 += $amountsd90;
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(95,30,30,30,30,30,30));
		$this->pdf->coldetailalign = array('R','R','R','R','R','R','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO',
			Yii::app()->format->formatCurrency($amounttempo2),
			Yii::app()->format->formatCurrency($amount1sd302),
			Yii::app()->format->formatCurrency($amount31sd602),
			Yii::app()->format->formatCurrency($amount61sd902),
			Yii::app()->format->formatCurrency($amountsd902),
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//11
	public function RekapUmurHutangGiro($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select *
					from (select a.fullname,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <'".date(Yii::app()->params['datetodb'], strtotime($startdate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."')),0) as saldoawal,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as debit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and ((b.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					or (b.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))),0) as credit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')),0) as saldoakhir,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur > 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd0,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -30 and 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd30,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -60 and -31 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd60,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -90 and -61 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd90,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur < -90 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd91
					from addressbook a
					where a.isvendor= 1 and a.fullname like '%".$customer."%') z
					where saldoawal <> 0 or debit <> 0 or credit <> 0 or saldoakhir <> 0
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Umur Hutang Giro';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,40,100,25,100));
			$this->pdf->colheader = array('','Nama','Mutasi','Sudah','Belum Jatuh Tempo');
			$this->pdf->RowHeader();
			$this->pdf->setwidths(array(7,40,25,25,25,25,25,25,25,25,25));
			$this->pdf->colheader = array('No','Customer','S.Awal','Debit','Credit','S.Akhir','JTT','1-30 Hari','31-60 Hari','61-90 Hari','>90 Hari');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','R','R','R','R','R','R','R','R','R','R');
			$i=0;$totalsaldoawal=0;$totaldebit=0;$totalcredit=0;$totalsaldoakhir=0;$totalsd0=0;$totalsd30=0;$totalsd60=0;$totalsd90=0;$totalsd91=0;

		foreach($dataReader as $row)
		{	
			$i+=1;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->row(array(
				$i,
				$row['fullname'],
				Yii::app()->format->formatCurrency($row['saldoawal']/$per),
				Yii::app()->format->formatCurrency($row['debit']/$per),
				Yii::app()->format->formatCurrency($row['credit']/$per),
				Yii::app()->format->formatCurrency($row['saldoakhir']/$per),
				Yii::app()->format->formatCurrency($row['sd0']/$per),
				Yii::app()->format->formatCurrency($row['sd30']/$per),
				Yii::app()->format->formatCurrency($row['sd60']/$per),
				Yii::app()->format->formatCurrency($row['sd90']/$per),
				Yii::app()->format->formatCurrency($row['sd90']/$per),
			));
			$totalsaldoawal += ($row['saldoawal']/$per);
			$totaldebit += ($row['debit']/$per);
			$totalcredit += ($row['credit']/$per);
			$totalsaldoakhir += ($row['saldoakhir']/$per);
			$totalsd0 += ($row['sd0']/$per);
			$totalsd30 += ($row['sd30']/$per);
			$totalsd60 += ($row['sd60']/$per);
			$totalsd90 += ($row['sd90']/$per);
			$totalsd91 += ($row['sd91']/$per);
			$this->pdf->checkPageBreak(0);
		}
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->row(array(
			'',
			'GRAND TOTAL ',
			Yii::app()->format->formatCurrency($totalsaldoawal),
			Yii::app()->format->formatCurrency($totaldebit),
			Yii::app()->format->formatCurrency($totalcredit),
			Yii::app()->format->formatCurrency($totalsaldoakhir),
			Yii::app()->format->formatCurrency($totalsd0),
			Yii::app()->format->formatCurrency($totalsd30),
			Yii::app()->format->formatCurrency($totalsd60),
			Yii::app()->format->formatCurrency($totalsd90),
			Yii::app()->format->formatCurrency($totalsd91),
		));
		$this->pdf->Output();
	}
	//12
	public function RincianGiroCairIntern($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Cek/Giro Cair - Intern';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->colheader = array('No','Nama Bank','No. Cek / Giro','Tgl C/G','J_Tempo','Tgl Cair','Nilai Giro','Keterangan');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tglcair,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tglcair";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcair'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),'',
				));
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C');
			$this->pdf->setwidths(array(132,30));
			$this->pdf->coldetailalign = array('R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amount),
			));
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(132,30));
		$this->pdf->coldetailalign = array('L','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO  -- >',
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//13
	public function RincianGiroTolakIntern($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tgltolak != '1970-01-01' 
						and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Cek/Giro Tolak - Intern';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
		$this->pdf->colheader = array('No','Nama Bank','No. Cek / Giro','Tgl C/G','J_Tempo','Tgl Tolak','Nilai Giro','Keterangan');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');

		foreach($dataReader as $row)
		{	
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(10,$this->pdf->gety()+5,$row['fullname']);
			$this->pdf->setwidths(array(7,40,25,20,20,20,30,30));
			$this->pdf->coldetailalign = array('R','L','L','C','R','R','R','R');
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tgltolak,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tgltolak != '1970-01-01' 
							and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tgltolak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+6);
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,
					$row1['bankname'],
					$row1['chequeno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])),
					date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltolak'])),
					Yii::app()->format->formatCurrency($row1['amount']/$per),'',
				));
				$amount += ($row1['amount']/$per);
			}
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C');
			$this->pdf->setwidths(array(132,30));
			$this->pdf->coldetailalign = array('R','R');
			$this->pdf->row(array(
				'TOTAL CEK / GIRO '.$row['fullname'],
				Yii::app()->format->formatCurrency($amount),
			));
			$amount2 += $amount;	
			
			$this->pdf->sety($this->pdf->gety()+3);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C');
		$this->pdf->setwidths(array(132,30));
		$this->pdf->coldetailalign = array('L','R');
		$this->pdf->row(array(
			'GRAND TOTAL CEK / GIRO  -- >',
			Yii::app()->format->formatCurrency($amount2),
		));
				
		$this->pdf->Output();
	}
	//14
	public function RekapJurnalUmumPerDokumenBelumStatusMax($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.genjournalid,a.journalno,a.referenceno,a.journaldate,a.journalnote,a.recordstatus
						from genjournal a
						join journaldetail b on b.genjournalid = a.genjournalid
						where a.journaldate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and a.recordstatus between 1 and (3-1)
						and a.referenceno is not null
						and a.companyid like '".$companyid."'
						order by a.journaldate,a.journalno";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Jurnal Umum Per Dokumen Belum Status Max';
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
					$i,$row['genjournalid'],$row['journalno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])),
					$row['referenceno'],$row['journalnote'],Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus'])
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}
	//15
	public function RekapPenerimaanKasBankPerDokumentBelumStatusMax($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		parent::actionDownPDF();
			$sql = "select distinct a.cbinid,a.cbinno,a.docdate,b.docno,a.headernote,a.recordstatus
							from cbin a
							join ttnt b on b.ttntid = a.ttntid
							where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and a.recordstatus between 1 and (3-1)
							and b.docno is not null
							and b.companyid = ".$companyid."
							order by a.docdate,a.cbinno";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Penerimaan Kas/Bank Per Dokumen Belum Status Max';
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
					$i,$row['cbinid'],$row['cbinno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
					$row['docno'],$row['headernote'],Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus'])
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}
	//16
	public function RekapPengeluaranKasBankPerDokumentBelumStatusMax($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql="select a.cashbankoutid,a.cashbankoutno,a.docdate,b.reqpayno,b.headernote,a.recordstatus
					from cashbankout a
					join reqpay b on b.reqpayid = a.cashbankoutid
					where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and a.recordstatus between 1 and (3-1)
					and b.reqpayno is not null
					and a.companyid = ".$companyid." 
					order by a.docdate,a.cashbankoutno";
														
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Pengeluaran Kas/Bank Per Dokumen Belum Status Max';
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
				$i,$row['cashbankoutid'],$row['cashbankoutno'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
				$row['reqpayno'],$row['headernote'],Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus'])
			));
						 
			$this->pdf->checkPageBreak(20);
		}
		
		$this->pdf->Output();
	}
	//17
	public function RekapCashBankPerDokumentBelumStatusMax($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql ="select distinct a.cbid,a.cashbankno,a.docdate,a.receiptno,a.headernote,a.recordstatus,a.statusname
					from cb a
					where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
					and a.receiptno is not null
					and a.recordstatus between 1 and (3-1)
					and a.companyid = ".$companyid." 
					order by a.docdate,a.cashbankno";
														
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Cash Bank Per Dokumen Belum Status Max';
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
					$i,$row['cbid'],$row['cashbankno'],
					date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
					$row['receiptno'],$row['headernote'],$row['statusname']
				));
               
				$this->pdf->checkPageBreak(20);
			}
			
			$this->pdf->Output();
	}
	//18
	public function LampiranNeraca1($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
  {
		parent::actionDownload();
		$totalawal1=0;$totaldebit1=0;$totalcredit1=0;
		$sql = "SELECT *
						FROM (SELECT a.accountname, a.accountcode,
            ifnull((SELECT SUM(b.debit-b.credit) FROM genledger b join genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND c.journaldate < '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."'),0) as saldoawal,
            ifnull((SELECT SUM(b.debit) FROM genledger b  join genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND c.journaldate BETWEEN '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."' AND '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as debit, 
            ifnull((SELECT SUM(b.credit) FROM genledger b join genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND c.journaldate BETWEEN '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."' AND '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as credit, 
            ifnull((SELECT SUM(b.debit-b.credit) FROM genledger b join genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND c.journaldate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as saldoakhir
							from repneraca a
							where a.companyid = '".$companyid."' AND LOWER(a.accountname) <> LOWER('AKTIVA LANCAR') AND LOWER(a.accountname) <> LOWER('AKTIVA TETAP') AND LOWER(a.accountname) <> LOWER('AKTIVA LAIN-LAIN') AND LOWER(a.accountname) <> LOWER('AKTIVA') AND LOWER(a.accountname) <> LOWER('KEWAJIBAN LANCAR') AND LOWER(a.accountname) <> LOWER('KEWAJIBAN JANGKA PANJANG') AND LOWER(a.accountname) <> LOWER('EKUITAS') AND LOWER(a.accountname) <> LOWER('PASIVA') AND LOWER(a.accountname) <> LOWER('PERSEDIAAN')) z
							WHERE saldoawal <> 0 or debit <> 0 or credit <> 0 or saldoakhir <> 0";

    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
    
    foreach($dataReader as $row)
    {
        $this->pdf->companyid = $companyid;
    }
    $this->pdf->title='Lampiran Neraca';
    $this->pdf->subtitle = 'Dari : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) .' - '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P','A4');
            
    foreach($dataReader as $row)
    {
      $this->pdf->SetFont('Arial','B',10);
      //$this->pdf->text(10,$this->pdf->gety()+10,$row['accountcode']);
			$this->pdf->text(10,$this->pdf->gety()+3,'MUTASI '.$row['accountname']);
                
			$sql1 = "select a.accountname,
                ifnull((SELECT SUM(b.debit-b.credit) FROM genledger b JOIN genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND b.journaldate < '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."'),0) as saldoawal,
                ifnull((SELECT SUM(b.debit) FROM genledger b JOIN genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND b.journaldate BETWEEN '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."' AND '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as debit, 
                ifnull((SELECT SUM(b.credit) FROM genledger b JOIN genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND b.journaldate BETWEEN '".date(Yii::app()->params['datetodb'], strtotime($startdate)) ."' AND '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as credit, 
                ifnull((SELECT SUM(b.debit-b.credit) FROM genledger b JOIN genjournal c on c.genjournalid=b.genjournalid WHERE c.recordstatus=3 and b.companyid=a.companyid AND b.accountcode BETWEEN a.accountcode AND concat(a.accountcode,'9999999999') AND b.journaldate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate)) ."'),0) as saldoakhir
						 from account a
						 where a.recordstatus = 1 and a.parentaccountid = (SELECT b.accountid FROM account b WHERE b.accountcode='".$row['accountcode']."' AND b.companyid='".$companyid."')
						 order by a.accountid";
			
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();
      $saldo=0;$i=0;
                
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->sety($this->pdf->gety()+7);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,70,28,28,28,28));
      $this->pdf->colheader = array('No','Keterangan','Saldo Awal','Debit','Kredit','Saldo Akhir');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('C','L','R','R','R','R');		
      $saldo=0;$i=0;$totaldebit=0;$totalcredit=0;
          
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->row(array(
      '',$row['accountname'],
      Yii::app()->format->formatCurrency($row['saldoawal']/$per),
      Yii::app()->format->formatCurrency($row['debit']/$per),
      Yii::app()->format->formatCurrency($row['credit']/$per),
      Yii::app()->format->formatCurrency($row['saldoakhir']/$per)
      ));	
                
      foreach($dataReader1 as $row1)
      {
          $i+=1;
          $this->pdf->setFont('Arial','',8);
          $this->pdf->row(array(
          $i,$row1['accountname'],
          Yii::app()->format->formatCurrency($row1['saldoawal']/$per),
          Yii::app()->format->formatCurrency($row1['debit']/$per),
          Yii::app()->format->formatCurrency($row1['credit']/$per),
          Yii::app()->format->formatCurrency($row1['saldoakhir']/$per)
          ));	    
      }
    	$this->pdf->checkPageBreak(250);
  	}
						
  	$this->pdf->Output();
  }
	
	
	
	
	
	
	
	
	
	public function actionDownXLS()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['materialgroup']) && isset($_GET['customer']) && isset($_GET['account']) 
			&& isset($_GET['startacccode']) && isset($_GET['endacccode'])&& isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 1)
			{
				$this->RincianJurnalTransaksiXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startacccode'],$_GET['endacccode'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 2)
			{
				$this->BukuBesarXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startacccode'],$_GET['endacccode'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 3)
			{
				$this->NeracaUjiCobaXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 4)
			{
				$this->LabaRugiUjiCobaXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 5)
			{
				$this->RincianUmurPiutangGiroXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RekapUmurPiutangGiroXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RincianGiroCairEksternXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RincianGiroTolakEksternXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RincianGiroOpnameEksternXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RincianUmurHutangGiroXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->RekapUmurHutangGiroXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
				$this->RincianGiroCairInternXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 13)
			{
				$this->RincianGiroTolakInternXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 14)
			{
				$this->RekapJurnalUmumPerDokumenBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 15)
			{
				$this->RekapPenerimaanKasBankPerDokumentBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 16)
			{
				$this->RekapPengeluaranKasBankPerDokumentBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 17)
			{
				$this->RekapCashBankPerDokumentBelumStatusMaxXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['materialgroup'],$_GET['customer'],$_GET['account'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	//1
	public function RincianJurnalTransaksiXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startacccode,$endacccode,$startdate,$enddate,$per)
  {
		$this->menuname='rincianjurnaltransaksi';
		parent::actionDownxls();
    $debit=0;$credit=0;
    $sql = "select distinct a.genjournalid,
						ifnull(b.companyname,'-')as company,
						ifnull(a.journalno,'-')as journalno,
						ifnull(a.referenceno,'-')as referenceno,
						a.journaldate,a.postdate,
						ifnull(a.journalnote,'-')as journalnote,a.recordstatus
						from genjournal a
						join company b on b.companyid = a.companyid
						join genledger c on c.genjournalid = a.genjournalid
						join account d on d.accountid = c.accountid
						where a.companyid = ".$companyid." and d.accountname like '%".$account."%'
						and a.journaldate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						 and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						";
			if (($_GET['startacccode'] !== '')&&($_GET['endacccode'] !== '')) {
						$sql = $sql . "and d.accountcode between '".$_GET['startacccode']."' and '".$_GET['endacccode']."'
						";
					}
    
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();

		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
    foreach ($dataReader as $row) 
		{
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No Journal')
					->setCellValueByColumnAndRow(1,$line,': ' . $row['journalno']);
			$line++;
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Ref No ')
					->setCellValueByColumnAndRow(1,$line,': ' . $row['referenceno']);
			$line++;
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Tgl Jurnal ')
					->setCellValueByColumnAndRow(1,$line,': ' . $row['journaldate']);
			$line++;

      $sql1 = "select b.accountcode,b.accountname, a.debit,a.credit,c.symbol,a.detailnote,a.ratevalue
							from journaldetail a
							left join account b on b.accountid = a.accountid
							left join currency c on c.currencyid = a.currencyid
							where a.genjournalid = '" . $row['genjournalid'] . "'
							order by journaldetailid ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Account')
					->setCellValueByColumnAndRow(2,$line,'Debit')
					->setCellValueByColumnAndRow(3,$line,'Credit')
					->setCellValueByColumnAndRow(4,$line,'Rate')
					->setCellValueByColumnAndRow(5,$line,'Detail Note');
			$line++;
      $i=0;
      foreach ($dataReader1 as $row1) 
			{
        $i=$i+1;
        $debit  = $debit + ($row1['debit']/$per * $row1['ratevalue']);
        $credit = $credit + ($row1['credit']/$per * $row1['ratevalue']);
        $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['accountcode'] . ' ' . $row1['accountname'])
					->setCellValueByColumnAndRow(2,$line,$row1['debit']/$per)
					->setCellValueByColumnAndRow(3,$line,$row1['credit']/$per)
					->setCellValueByColumnAndRow(4,$line,$row1['ratevalue'])
					->setCellValueByColumnAndRow(5,$line,$row1['detailnote']);
				$line++;
      }
      $this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Total')
				->setCellValueByColumnAndRow(2,$line,$debit)
				->setCellValueByColumnAndRow(3,$line,$row1['credit']/$per);
			$line++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'Note')
				->setCellValueByColumnAndRow(2,$line,': ' . $row['journalnote']);
			$line+=2;
    }
		$this->getFooterXLS($this->phpExcel);
  }
	//2
	public function BukuBesarXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startacccode,$endacccode,$startdate,$enddate,$per)
	{
		$this->menuname='bukubesar';
		parent::actionDownxls();
		$totalawal1=0;$totaldebit1=0;$totalcredit1=0;
		$sql = "select distinct b.accountid,b.accountname,b.accountcode
							from genledger b 
							where b.companyid = '".$companyid."' and b.accountname like '%".$account."%'
							and b.journaldate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";

					if (($_GET['startacccode'] !== '')&&($_GET['endacccode'] !== '')) {
						$sql = $sql . "and b.accountcode between '".$_GET['startacccode']."' and '".$_GET['endacccode']."'
						";
					}
    $sql = $sql . " order by b.accountcode";
					
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
      ->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
      ->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
    $line=4;				
    foreach($dataReader as $row)
    {
       $sql1 = "select sum(ifnull(zz.debit,0)-ifnull(zz.credit,0)) as saldoawal
            from genledger zz 
            where zz.accountid = '".$row['accountid']."'
            and zz.journaldate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'";

      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach($dataReader1 as $row1)
      { 
        $this->phpExcel->setActiveSheetIndex(0)						
          ->setCellValueByColumnAndRow(0,$line,$row['accountcode'])
          ->setCellValueByColumnAndRow(2,$line,$row['accountname'])
          ->setCellValueByColumnAndRow(7,$line,'Saldo Awal : '.$row1['saldoawal']/$per);							
        $line++;

        $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0,$line,'No')
          ->setCellValueByColumnAndRow(1,$line,'No. Dokumen')
          ->setCellValueByColumnAndRow(2,$line,'Tanggal')					
          ->setCellValueByColumnAndRow(3,$line,'Referensi')
          ->setCellValueByColumnAndRow(4,$line,'Keterangan')
          ->setCellValueByColumnAndRow(5,$line,'Uraian')
          ->setCellValueByColumnAndRow(6,$line,'Debet')
          ->setCellValueByColumnAndRow(7,$line,'Credit')
          ->setCellValueByColumnAndRow(8,$line,'Saldo');
        $line++;
        $sql2 = "select a.journalno,a.journaldate,a.referenceno,a.journalnote,b.debit,b.credit,b.detailnote
               from genjournal a
               join journaldetail b on b.genjournalid = a.genjournalid
               where a.recordstatus = 3 and b.accountid = '".$row['accountid']."'
               and a.journaldate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
               and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
               order by a.journaldate,a.referenceno";

        $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $saldo=0;$i=0;$totaldebit=0;$totalcredit=0;         

        foreach($dataReader2 as $row2)
        {
          $i+=1;
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,$i)
              ->setCellValueByColumnAndRow(1,$line,$row2['journalno'])
              ->setCellValueByColumnAndRow(2,$line,$row2['journaldate'])
              ->setCellValueByColumnAndRow(3,$line,$row2['referenceno'])
              ->setCellValueByColumnAndRow(4,$line,$row2['journalnote'])
              ->setCellValueByColumnAndRow(5,$line,$row2['detailnote'])
              ->setCellValueByColumnAndRow(6,$line,$row2['debit']/$per)							
              ->setCellValueByColumnAndRow(7,$line,$row2['credit']/$per)
              ->setCellValueByColumnAndRow(8,$line,'-');
          $line++;
          //$saldo += (($row1['debit']/$per) - ($row1['credit']/$per)) + ($row['saldoawal']/$per);
          $totaldebit += $row2['debit']/$per;
          $totalcredit += $row2['credit']/$per;
        }
        $saldo = ($row1['saldoawal']/$per) + $totaldebit - $totalcredit;
        $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(5,$line,'TOTAL : ')									
              ->setCellValueByColumnAndRow(6,$line,$totaldebit)
              ->setCellValueByColumnAndRow(7,$line,$totalcredit)
              ->setCellValueByColumnAndRow(8,$line,$saldo);
        $line++;
        $line += 1;
        $totalawal1 += $row1['saldoawal']/$per;
        $totaldebit1 += $totaldebit;
        $totalcredit1 += $totalcredit;
      }
    }
    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1,$line,'TOTAL	SALDO AWAL')									
      ->setCellValueByColumnAndRow(3,$line,$totalawal1);
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1,$line,'TOTAL	MUTASI MASUK')									
      ->setCellValueByColumnAndRow(3,$line,$totaldebit1);
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1,$line,'TOTAL	MUTASI KELUAR')									
      ->setCellValueByColumnAndRow(3,$line,$totalcredit1);
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1,$line,'TOTAL	SALDO AKHIR')									
      ->setCellValueByColumnAndRow(3,$line,$totalawal1+$totaldebit1-$totalcredit1);
		
		$this->getFooterXLS($this->phpExcel);
	}
	//3
	public function NeracaUjiCobaXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='neracaujicoba';
		parent::actionDownxls();
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode < '19%') z 
					where z.bulanini <> 0 or z.bulanlalu <> 0
					order by accountcode asc";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
		$line=4;
		$i=0;$bulanini=0;$bulanlalu=0;			
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Akun')
					->setCellValueByColumnAndRow(2,$line,'Kode Akun')					
					->setCellValueByColumnAndRow(3,$line,'Bulan Ini')
					->setCellValueByColumnAndRow(4,$line,'Bulan Lalu');
		$line++;
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['accountname'])
					->setCellValueByColumnAndRow(2,$line,$row['accountcode'])
					->setCellValueByColumnAndRow(3,$line,$row['bulanini']/$per)
					->setCellValueByColumnAndRow(4,$line,$row['bulanlalu']/$per)	;
			$line++;
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'TOTAL AKTIVA')			
					->setCellValueByColumnAndRow(3,$line,$bulanini)										
					->setCellValueByColumnAndRow(4,$line,$bulanlalu);
		$line++;
		
		$i=0;$bulanini=0;$bulanlalu=0;
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue)
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and c.journaldate <= last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode between '2%' and '29%'
					order by a.accountcode asc) z where z.bulanini <> 0 or z.bulanlalu <> 0";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
		$line++;
					
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Akun')
					->setCellValueByColumnAndRow(2,$line,'Kode Akun')					
					->setCellValueByColumnAndRow(3,$line,'Bulan Ini')
					->setCellValueByColumnAndRow(4,$line,'Bulan Lalu');
		$line++;
		
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['accountname'])
					->setCellValueByColumnAndRow(2,$line,$row['accountcode'])
					->setCellValueByColumnAndRow(3,$line,$row['bulanini']/$per)
					->setCellValueByColumnAndRow(4,$line,$row['bulanlalu']/$per)	;
			$line++;
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'TOTAL AKTIVA')			
					->setCellValueByColumnAndRow(3,$line,$bulanini)										
					->setCellValueByColumnAndRow(4,$line,$bulanlalu);
		$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//4
	public function LabaRugiUjiCobaXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='labarugiujicoba';
		parent::actionDownxls();
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					and year(c.journaldate) = year('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
					group by accountid asc),0) as bulanini,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month)))
					and year(c.journaldate) = year(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',interval 1 month)))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode > '3%'
					order by a.accountcode asc) z where z.bulanini <> 0 or z.bulanlalu <> 0";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(4,1,$this->GetCompanyCode($companyid));
		$line=4;
		$i=0;$bulanini=0;$bulanlalu=0;			
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Akun')
					->setCellValueByColumnAndRow(2,$line,'Kode Akun')					
					->setCellValueByColumnAndRow(3,$line,'Bulan Ini')
					->setCellValueByColumnAndRow(4,$line,'Bulan Lalu');
		$line++;
		
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['accountname'])
					->setCellValueByColumnAndRow(2,$line,$row['accountcode'])
					->setCellValueByColumnAndRow(3,$line,$row['bulanini']/$per)
					->setCellValueByColumnAndRow(4,$line,$row['bulanlalu']/$per);
			$line++;
			
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'LABA (RUGI) BERSIH')			
					->setCellValueByColumnAndRow(3,$line,$bulanini)										
					->setCellValueByColumnAndRow(4,$line,$bulanlalu);
		$line++;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//5
	public function RincianUmurPiutangGiroXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rincianumurpiutanggiro';
		parent::actionDownxls();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(9,1,$this->GetCompanyCode($companyid));
		$line=4;
			

		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'Sudah')
					->setCellValueByColumnAndRow(6,$line,'Belum Jatuh Tempo');
		$line++;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'J_Tempo')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'1-30 Hari')
					->setCellValueByColumnAndRow(6,$line,'31-60 Hari')
					->setCellValueByColumnAndRow(7,$line,'61-90 Hari')
					->setCellValueByColumnAndRow(8,$line,'>90 Hari')
					->setCellValueByColumnAndRow(9,$line,'Jumlah');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select *,
							case when umur >= 0 then amount else 0 end as amounttempo,
							case when umur <= -1 and umur >= -30 then amount else 0 end as 1sd30,
							case when umur <= -31 and umur >= -60 then amount else 0 end as 31sd60,
							case when umur <= -61 and umur >= -90 then amount else 0 end as 61sd90,
							case when umur < -90 then amount else 0 end as sd90
							from
							(select c.bankname,a.chequeno,a.tgltempo,a.amount,
							datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.tgltempo) as umur
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							)z order by tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;	$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(4,$line,$row1['amounttempo']/$per)
						->setCellValueByColumnAndRow(5,$line,$row1['1sd30']/$per)
						->setCellValueByColumnAndRow(6,$line,$row1['31sd60']/$per)
						->setCellValueByColumnAndRow(7,$line,$row1['61sd90']/$per)
						->setCellValueByColumnAndRow(8,$line,$row1['sd90']/$per)
						->setCellValueByColumnAndRow(9,$line,$row1['amount']/$per);
				$line++;
				$amounttempo += ($row1['amounttempo']/$per);
				$amount1sd30 += ($row1['1sd30']/$per);
				$amount31sd60 += ($row1['31sd60']/$per);
				$amount61sd90 += ($row1['61sd90']/$per);
				$amountsd90 += ($row1['sd90']/$per);
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(2,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(4,$line,$amounttempo)								
					->setCellValueByColumnAndRow(5,$line,$amount1sd30)
					->setCellValueByColumnAndRow(6,$line,$amount31sd60)
					->setCellValueByColumnAndRow(7,$line,$amount61sd90)
					->setCellValueByColumnAndRow(8,$line,$amountsd90)
					->setCellValueByColumnAndRow(9,$line,$amount);
			$line+=2;
			$amounttempo2 += $amounttempo;
			$amount1sd302 += $amount1sd30;
			$amount31sd602 += $amount31sd60;
			$amount61sd902 += $amount61sd90;
			$amountsd902 += $amountsd90;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(2,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(4,$line,$amounttempo2)								
					->setCellValueByColumnAndRow(5,$line,$amount1sd302)
					->setCellValueByColumnAndRow(6,$line,$amount31sd602)
					->setCellValueByColumnAndRow(7,$line,$amount61sd902)
					->setCellValueByColumnAndRow(8,$line,$amountsd902)
					->setCellValueByColumnAndRow(9,$line,$amount2);
			$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//6
	public function RekapUmurPiutangGiroXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rekapumurpiutanggiro';
		parent::actionDownxls();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "	select *
					from (select a.fullname,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <'".date(Yii::app()->params['datetodb'], strtotime($startdate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."')),0) as saldoawal,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as debit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and ((b.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					or (b.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))),0) as credit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 1 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')),0) as saldoakhir,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur > 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd0,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -30 and 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd30,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -60 and -31 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd60,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -90 and -61 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd90,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur < -90 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 1 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd91
					from addressbook a
					where a.iscustomer= 1 and a.fullname like '%".$customer."%') z
					where saldoawal <> 0 or debit <> 0 or credit <> 0 or saldoakhir <> 0
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=6;

		$i=0;$totalsaldoawal=0;$totaldebit=0;$totalcredit=0;$totalsaldoakhir=0;$totalsd0=0;$totalsd30=0;$totalsd60=0;$totalsd90=0;$totalsd91=0;

		foreach($dataReader as $row)
		{	
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row['fullname'])
				->setCellValueByColumnAndRow(2,$line,$row['saldoawal']/$per)
				->setCellValueByColumnAndRow(3,$line,$row['debit']/$per)
				->setCellValueByColumnAndRow(4,$line,$row['credit']/$per)
				->setCellValueByColumnAndRow(5,$line,$row['saldoakhir']/$per)
				->setCellValueByColumnAndRow(6,$line,$row['sd0']/$per)
				->setCellValueByColumnAndRow(7,$line,$row['sd30']/$per)
				->setCellValueByColumnAndRow(8,$line,$row['sd60']/$per)
				->setCellValueByColumnAndRow(9,$line,$row['sd90']/$per)
				->setCellValueByColumnAndRow(10,$line,$row['sd91']/$per);
			$line++;
			$totalsaldoawal += ($row['saldoawal']/$per);
			$totaldebit += ($row['debit']/$per);
			$totalcredit += ($row['credit']/$per);
			$totalsaldoakhir += ($row['saldoakhir']/$per);
			$totalsd0 += ($row['sd0']/$per);
			$totalsd30 += ($row['sd30']/$per);
			$totalsd60 += ($row['sd60']/$per);
			$totalsd90 += ($row['sd90']/$per);
			$totalsd91 += ($row['sd91']/$per);
			$this->pdf->checkPageBreak(0);
		}
		$line+=1;
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(2,$line,$totalsaldoawal)
			->setCellValueByColumnAndRow(3,$line,$totaldebit)
			->setCellValueByColumnAndRow(4,$line,$totalcredit)
			->setCellValueByColumnAndRow(5,$line,$totalsaldoakhir)
			->setCellValueByColumnAndRow(6,$line,$totalsd0)
			->setCellValueByColumnAndRow(7,$line,$totalsd30)
			->setCellValueByColumnAndRow(8,$line,$totalsd60)
			->setCellValueByColumnAndRow(9,$line,$totalsd90)
			->setCellValueByColumnAndRow(10,$line,$totalsd91);
		$this->getFooterXLS($this->phpExcel);
	}
        //7
	public function RincianGiroCairEksternXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rinciangirocairekstern';
		parent::actionDownxls();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tglcair != '1970-01-01' 
						and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'Tgl C/G')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'Tgl Cair')
					->setCellValueByColumnAndRow(6,$line,'Nilai Giro')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tglcair,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair != '1970-01-01' or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tglcair";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$amount=0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])))
						->setCellValueByColumnAndRow(4,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(5,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcair'])))						
						->setCellValueByColumnAndRow(6,$line,$row1['amount']/$per);
				$line++;
				
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(6,$line,$amount) ;
			$line+=2;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(6,$line,$amount2);
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//8
	public function RincianGiroTolakEksternXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rinciangirotolakekstern';
		parent::actionDownxls();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tgltolak != '1970-01-01'
						and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'Tgl C/G')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'Tgl Tolak')
					->setCellValueByColumnAndRow(6,$line,'Nilai Giro')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tgltolak,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tgltolak != '1970-01-01'
							and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tgltolak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$amount=0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])))
						->setCellValueByColumnAndRow(4,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(5,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltolak'])))						
						->setCellValueByColumnAndRow(6,$line,$row1['amount']/$per);
				$line++;
				
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(6,$line,$amount);
			$line+=2;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(6,$line,$amount2) ;
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//9
	public function RincianGiroOpnameEksternXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rinciangiroopnameekstern';
		parent::actionDownxls();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname,tgltempo";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Tanggal')
					->setCellValueByColumnAndRow(2,$line,'Dari Customer')					
					->setCellValueByColumnAndRow(3,$line,'Nama Bank')
					->setCellValueByColumnAndRow(4,$line,'No. Cek/Giro')
					->setCellValueByColumnAndRow(5,$line,'J_Tempo')
					->setCellValueByColumnAndRow(6,$line,'Nilai Giro')
					->setCellValueByColumnAndRow(7,$line,'V');
		$line++;
		
		foreach($dataReader as $row)
		{
			$sql1 = "select a.tglcheque,b.fullname,c.bankname,a.chequeno,a.tgltempo,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 1 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							order by fullname,tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+0);
			$i=0;$amount=0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])))
						->setCellValueByColumnAndRow(2,$line,$row1['fullname'])
						->setCellValueByColumnAndRow(3,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(4,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(5,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))						
						->setCellValueByColumnAndRow(6,$line,$row1['amount']/$per)
						->setCellValueByColumnAndRow(7,$line,'[  ]') ;
				$line++;
				
				$amount += ($row1['amount']/$per);
			}
			$amount2 += $amount;
			
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'SALDO ADM (PEMBUKUAN)')	
					->setCellValueByColumnAndRow(5,$line,' : ')
					->setCellValueByColumnAndRow(6,$line,$amount2);
		$line+=1;
		
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'SALDO CHECK FISIK') 
					->setCellValueByColumnAndRow(5,$line,' : ') ;
		$line+=1;
		
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(4,$line,'SELISIH') 
					->setCellValueByColumnAndRow(5,$line,' : ') ;
		$line+=3;
		
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'Dibuat oleh,') 
					->setCellValueByColumnAndRow(2,$line,'Diperiksa oleh,')
					->setCellValueByColumnAndRow(4,$line,'Diiketahui oleh,')
					->setCellValueByColumnAndRow(5,$line,'Disetujui oleh,');
		$line+=6;
		
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'........................') 
					->setCellValueByColumnAndRow(2,$line,'........................')
					->setCellValueByColumnAndRow(4,$line,'........................')
					->setCellValueByColumnAndRow(5,$line,'........................');
		$line+=1;
		
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'Kasir') 
					->setCellValueByColumnAndRow(2,$line,'Controller')
					->setCellValueByColumnAndRow(4,$line,'Chief Accounting')
					->setCellValueByColumnAndRow(5,$line,'Pimpinan Cabang');
		$line+=1;		
		
		$this->getFooterXLS($this->phpExcel);
	}
	//10
	public function RincianUmurHutangGiroXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rincianumurhutanggiro';
		parent::actionDownxls();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
						and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(9,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'Sudah')
					->setCellValueByColumnAndRow(6,$line,'Belum Jatuh Tempo');
		$line++;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'J_Tempo')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'1-30 Hari')
					->setCellValueByColumnAndRow(6,$line,'31-60 Hari')
					->setCellValueByColumnAndRow(7,$line,'61-90 Hari')
					->setCellValueByColumnAndRow(8,$line,'>90 Hari')
					->setCellValueByColumnAndRow(9,$line,'Jumlah');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select *,
							case when umur >= 0 then amount else 0 end as amounttempo,
							case when umur <= -1 and umur >= -30 then amount else 0 end as 1sd30,
							case when umur <= -31 and umur >= -60 then amount else 0 end as 31sd60,
							case when umur <= -61 and umur >= -90 then amount else 0 end as 61sd90,
							case when umur < -90 then amount else 0 end as sd90
							from
							(select c.bankname,a.chequeno,a.tgltempo,a.amount,
							datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',a.tgltempo) as umur
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is null or a.tglcair = '1970-01-01' or a.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							and (a.tgltolak is null or a.tgltolak = '1970-01-01' or a.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
							)z order by tgltempo";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$amounttempo=0;$amount1sd30=0;$amount31sd60=0;$amount61sd90=0;$amountsd90=0;$amount=0;
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(4,$line,$row1['amounttempo']/$per)
						->setCellValueByColumnAndRow(5,$line,$row1['1sd30']/$per)
						->setCellValueByColumnAndRow(6,$line,$row1['31sd60']/$per)
						->setCellValueByColumnAndRow(7,$line,$row1['61sd90']/$per)
						->setCellValueByColumnAndRow(8,$line,$row1['sd90']/$per)
						->setCellValueByColumnAndRow(9,$line,$row1['amount']/$per);
				$line++;
				
				$amounttempo += ($row1['amounttempo']/$per);
				$amount1sd30 += ($row1['1sd30']/$per);
				$amount31sd60 += ($row1['31sd60']/$per);
				$amount61sd90 += ($row1['61sd90']/$per);
				$amountsd90 += ($row1['sd90']/$per);
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(2,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(4,$line,$amounttempo)							
					->setCellValueByColumnAndRow(5,$line,$amount1sd30)
					->setCellValueByColumnAndRow(6,$line,$amount31sd60)
					->setCellValueByColumnAndRow(7,$line,$amount61sd90)
					->setCellValueByColumnAndRow(8,$line,$amountsd90)
					->setCellValueByColumnAndRow(9,$line,$amount);
			$line+=2;
			
			$amounttempo2 += $amounttempo;
			$amount1sd302 += $amount1sd30;
			$amount31sd602 += $amount31sd60;
			$amount61sd902 += $amount61sd90;
			$amountsd902 += $amountsd90;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(2,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(4,$line,$amounttempo2)										
					->setCellValueByColumnAndRow(5,$line,$amount1sd302)
					->setCellValueByColumnAndRow(6,$line,$amount31sd602)
					->setCellValueByColumnAndRow(7,$line,$amount61sd902)
					->setCellValueByColumnAndRow(8,$line,$amountsd902)
					->setCellValueByColumnAndRow(9,$line,$amount2);
			$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//11
	public function RekapUmurHutangGiroXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rekapumurhutanggiro';
		parent::actionDownxls();
		$amounttempo2=0;$amount1sd302=0;$amount31sd602=0;$amount61sd902=0;$amountsd902=0;$amount2=0;
		$sql = "select *
					from (select a.fullname,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <'".date(Yii::app()->params['datetodb'], strtotime($startdate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak >= '".date(Yii::app()->params['datetodb'], strtotime($startdate))."')),0) as saldoawal,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'),0) as debit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and ((b.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					or (b.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'))),0) as credit,
					ifnull((select sum(b.amount)
					from cheque b
					where b.iscustomer = 0 and b.companyid = ".$companyid." and b.addressbookid=a.addressbookid
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')),0) as saldoakhir,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur > 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd0,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -30 and 0 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd30,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -60 and -31 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd60,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur between -90 and -61 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd90,
					ifnull((select sum(amount)
					from (select addressbookid,case when umur < -90 then amount else 0 end as amount
					from (select b.amount,b.addressbookid,datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',b.tgltempo) as umur
					from cheque b
					where b.recordstatus = 1 and b.iscustomer = 0 and b.companyid = ".$companyid."
					and b.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and (b.tglcair is null or b.tglcair = '1970-01-01' or b.tglcair > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."') 
					and (b.tgltolak is null or b.tgltolak = '1970-01-01' or b.tgltolak > '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')) z) zz 
					where zz.addressbookid=a.addressbookid),0) as sd91
					from addressbook a
					where a.isvendor= 1 and a.fullname like '%".$customer."%') z
					where saldoawal <> 0 or debit <> 0 or credit <> 0 or saldoakhir <> 0
					order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=6;

		$i=0;$totalsaldoawal=0;$totaldebit=0;$totalcredit=0;$totalsaldoakhir=0;$totalsd0=0;$totalsd30=0;$totalsd60=0;$totalsd90=0;$totalsd91=0;

		foreach($dataReader as $row)
		{	
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$i)
				->setCellValueByColumnAndRow(1,$line,$row['fullname'])
				->setCellValueByColumnAndRow(2,$line,$row['saldoawal']/$per)
				->setCellValueByColumnAndRow(3,$line,$row['debit']/$per)
				->setCellValueByColumnAndRow(4,$line,$row['credit']/$per)
				->setCellValueByColumnAndRow(5,$line,$row['saldoakhir']/$per)
				->setCellValueByColumnAndRow(6,$line,$row['sd0']/$per)
				->setCellValueByColumnAndRow(7,$line,$row['sd30']/$per)
				->setCellValueByColumnAndRow(8,$line,$row['sd60']/$per)
				->setCellValueByColumnAndRow(9,$line,$row['sd90']/$per)
				->setCellValueByColumnAndRow(10,$line,$row['sd91']/$per);
			$line++;
			$totalsaldoawal += ($row['saldoawal']/$per);
			$totaldebit += ($row['debit']/$per);
			$totalcredit += ($row['credit']/$per);
			$totalsaldoakhir += ($row['saldoakhir']/$per);
			$totalsd0 += ($row['sd0']/$per);
			$totalsd30 += ($row['sd30']/$per);
			$totalsd60 += ($row['sd60']/$per);
			$totalsd90 += ($row['sd90']/$per);
			$totalsd91 += ($row['sd91']/$per);
			$this->pdf->checkPageBreak(0);
		}
		$line+=1;
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL ')
			->setCellValueByColumnAndRow(2,$line,$totalsaldoawal)
			->setCellValueByColumnAndRow(3,$line,$totaldebit)
			->setCellValueByColumnAndRow(4,$line,$totalcredit)
			->setCellValueByColumnAndRow(5,$line,$totalsaldoakhir)
			->setCellValueByColumnAndRow(6,$line,$totalsd0)
			->setCellValueByColumnAndRow(7,$line,$totalsd30)
			->setCellValueByColumnAndRow(8,$line,$totalsd60)
			->setCellValueByColumnAndRow(9,$line,$totalsd90)
			->setCellValueByColumnAndRow(10,$line,$totalsd91);
		$this->getFooterXLS($this->phpExcel);
	}
	//12
	public function RincianGiroCairInternXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rinciangirocairintern';
		parent::actionDownxls();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tglcair != '1970-01-01' 
						and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'Tgl C/G')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'Tgl Cair')
					->setCellValueByColumnAndRow(6,$line,'Nilai Giro')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tglcair,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tglcair is not null or a.tglcair <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tglcair != '1970-01-01' 
							and a.tglcair between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tglcair";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();		
			$i=0;$amount=0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])))
						->setCellValueByColumnAndRow(4,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(5,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcair'])))						
						->setCellValueByColumnAndRow(6,$line,$row1['amount']/$per);
				$line++;
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(6,$line,$amount);
			$line+=2;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(6,$line,$amount2);
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//13
	public function RincianGiroTolakInternXLS($companyid,$sloc,$product,$materialgroup,$customer,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rinciangirotolakintern';
		parent::actionDownxls();
		$amount2=0;
		$sql = "select distinct b.addressbookid,b.fullname
						from cheque a
						left join addressbook b on b.addressbookid=a.addressbookid
						left join bank c on c.bankid=a.bankid
						where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0
						and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
						and a.tgltolak != '1970-01-01' 
						and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by fullname" ;
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(7,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Bank')
					->setCellValueByColumnAndRow(2,$line,'No Cek/Giro')					
					->setCellValueByColumnAndRow(3,$line,'Tgl C/G')
					->setCellValueByColumnAndRow(4,$line,'J_Tempo')
					->setCellValueByColumnAndRow(5,$line,'Tgl Tolak')
					->setCellValueByColumnAndRow(6,$line,'Nilai Giro')
					->setCellValueByColumnAndRow(7,$line,'Keterangan');
		$line++;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)						
					->setCellValueByColumnAndRow(0,$line,$row['fullname']);							
			$line++;
			
			$sql1 = "select c.bankname,a.chequeno,a.tglcheque,a.tgltempo,a.tgltolak,a.amount
							from cheque a
							left join addressbook b on b.addressbookid=a.addressbookid
							left join bank c on c.bankid=a.bankid
							where a.recordstatus = 1 and a.companyid = ".$companyid." and a.iscustomer = 0 and b.addressbookid = '".$row['addressbookid']."'
							and a.tglbayar <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and (a.tgltolak is not null or a.tgltolak <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.tgltolak != '1970-01-01' 
							and a.tgltolak between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							order by tgltolak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$amount=0;
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row1['bankname'])
						->setCellValueByColumnAndRow(2,$line,$row1['chequeno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcheque'])))
						->setCellValueByColumnAndRow(4,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltempo'])))
						->setCellValueByColumnAndRow(5,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltolak'])))						
						->setCellValueByColumnAndRow(6,$line,$row1['amount']/$per);
				$line++;
				
				$amount += ($row1['amount']/$per);
			}
			$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'TOTAL CEK/GIRO '.$row['fullname'])			
					->setCellValueByColumnAndRow(6,$line,$amount);
			$line+=2;
			$amount2 += $amount;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(3,$line,'GRAND TOTAL CEK/GIRO ')			
					->setCellValueByColumnAndRow(6,$line,$amount2);
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//14
	public function RekapJurnalUmumPerDokumenBelumStatusMaxXLS($companyid,$sloc,$storagebin,$sales,$product,$account,$startdate,$enddate,$per)
	{
		$this->menuname='rekapjurnalumumperdokumenbelumstatusmax';
		parent::actionDownxls();
		$sql = "select distinct a.genjournalid,a.journalno,a.referenceno,a.journaldate,a.journalnote,a.recordstatus
						from genjournal a
						join journaldetail b on b.genjournalid = a.genjournalid
						where a.journaldate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and a.recordstatus between 1 and (3-1)
						and a.referenceno is not null
						and a.companyid like '".$companyid."'
						order by a.journaldate,a.journalno";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)				
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
		$line=4;
		
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
				->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
				->setCellValueByColumnAndRow(3,$line,'Tanggal')
				->setCellValueByColumnAndRow(4,$line,'No Referensi')
				->setCellValueByColumnAndRow(5,$line,'Keterangan')
				->setCellValueByColumnAndRow(6,$line,'Status') ;
		$line++;
		$i=0;
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['genjournalid'])
					->setCellValueByColumnAndRow(2,$line,$row['journalno'])
					->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])))
					->setCellValueByColumnAndRow(4,$line,$row['referenceno'])
					->setCellValueByColumnAndRow(5,$line,$row['journalnote'])
					->setCellValueByColumnAndRow(6,$line,Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus']))	;
			$line++;
		}
		
		$this->getFooterXLS($this->phpExcel);
	}
	//15
	public function RekapPenerimaanKasBankPerDokumentBelumStatusMaxXLS($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		$this->menuname='rekappenerimaankasbankperdokumenbelumstatusmax';
		parent::actionDownxls();
		$sql = "select distinct a.cbinid,a.cbinno,a.docdate,b.docno,a.headernote,a.recordstatus
							from cbin a
							join ttnt b on b.ttntid = a.ttntid
							where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							and a.recordstatus between 1 and (3-1)
							and b.docno is not null
							and b.companyid = ".$companyid."
							order by a.docdate,a.cbinno";
		
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
					->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'No Referensi')
					->setCellValueByColumnAndRow(5,$line,'Keterangan')
					->setCellValueByColumnAndRow(6,$line,'Status') ;
			$line++;	
			$i=0;
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['cbinid'])
						->setCellValueByColumnAndRow(2,$line,$row['cbinno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])))
						->setCellValueByColumnAndRow(4,$line,$row['docno'])
						->setCellValueByColumnAndRow(5,$line,$row['headernote'])
						->setCellValueByColumnAndRow(6,$line,Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus']))	;
				$line++;
			}
		
		$this->getFooterXLS($this->phpExcel);
	}
	//16
	public function RekapPengeluaranKasBankPerDokumentBelumStatusMaxXLS($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		$this->menuname='rekappengeluarankasbankperdokumenbelumstatusmax';
		parent::actionDownxls();
		$sql="select a.cashbankoutid,a.cashbankoutno,a.docdate,b.reqpayno,b.headernote,a.recordstatus
					from cashbankout a
					join reqpay b on b.reqpayid = a.cashbankoutid
					where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and a.recordstatus between 1 and (3-1)
					and b.reqpayno is not null
					and a.companyid = ".$companyid." 
					order by a.docdate,a.cashbankoutno";
														
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
					->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'No Referensi')
					->setCellValueByColumnAndRow(5,$line,'Keterangan')
					->setCellValueByColumnAndRow(6,$line,'Status') ;
			$line++;	
			$i=0;		
			foreach($dataReader as $row)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['cbinid'])
						->setCellValueByColumnAndRow(2,$line,$row['cbinno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])))
						->setCellValueByColumnAndRow(4,$line,$row['docno'])
						->setCellValueByColumnAndRow(5,$line,$row['headernote'])
						->setCellValueByColumnAndRow(6,$line,Wfstatus::model()->findstatusname("apppayreq",$row['recordstatus']))	;
				$line++;
			}	
		$this->getFooterXLS($this->phpExcel);
	}
	//17 
	public function RekapCashBankPerDokumentBelumStatusMaxXLS($companyid,$sloc,$storagebin,$sales,$product,$salesarea,$startdate,$enddate)
	{
		$this->menuname='rekapcashbankperdokumenbelumstatusmax';
		parent::actionDownxls();
		$sql ="select distinct a.cbid,a.cashbankno,a.docdate,a.receiptno,a.headernote,a.recordstatus,a.statusname
					from cb a
					where a.docdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
					and a.receiptno is not null
					and a.recordstatus between 1 and (3-1)
					and a.companyid = ".$companyid." 
					order by a.docdate,a.cashbankno";
														
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
			$this->phpExcel->setActiveSheetIndex(0)	
				->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
				->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
				->setCellValueByColumnAndRow(6,1,$this->GetCompanyCode($companyid));
			$line=4;
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'ID Transaksi')
					->setCellValueByColumnAndRow(2,$line,'No Transaksi')					
					->setCellValueByColumnAndRow(3,$line,'Tanggal')
					->setCellValueByColumnAndRow(4,$line,'No Referensi')
					->setCellValueByColumnAndRow(5,$line,'Keterangan')
					->setCellValueByColumnAndRow(6,$line,'Status') ;
			$line++;	
			$i=0;	
		
		foreach($dataReader as $row)
		{
			$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,$i)
						->setCellValueByColumnAndRow(1,$line,$row['cbid'])
						->setCellValueByColumnAndRow(2,$line,$row['cashbankno'])
						->setCellValueByColumnAndRow(3,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])))
						->setCellValueByColumnAndRow(4,$line,$row['receiptno'])
						->setCellValueByColumnAndRow(5,$line,$row['headernote'])
						->setCellValueByColumnAndRow(6,$line,$row['statusname']);
				$line++;
		}
		
		$this->getFooterXLS($this->phpExcel);
	}
		
}
