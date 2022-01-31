<?php

class ReportratioController extends AdminController
{
	protected $menuname = 'groupratio';		
	public $module = 'reportgroup';
	protected $pageTitle = 'Laporan Rasio Keuangan';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1) {
        $this->LaporanRatio($_GET['company'], $_GET['enddate'], $_GET['per']); 
      } else {
        echo $this->getCatalog('reportdoesnotexist');
      }
    }
	}
	//1
    
    public function LaporanRatio($companyid,$date,$per){
      parent::actionDownPDF();
      $connection = Yii::app()->db;
      if($_GET['company']!==''){
          $akt_company = 'select a.accblninitotal';
          $pas_company = 'select a.pasblninitotal';
          $lr_company = 'select a.actualblninitotal';
          $where = ' and a.companyid = '.$_GET['company'];
          $this->pdf->companyid = $companyid;
      }else{
          $akt_company = 'select sum(a.accblninitotal)';
          $pas_company = 'select sum(a.pasblninitotal)';
          $lr_company = 'select sum(a.actualblninitotal)';
          $this->pdf->companyid = 0;
          $where = '';
      }
        
    $akt  = $akt_company ."
            from repneracalajur a 
			where a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			".$where;
    $pas  = $pas_company ."
			from repneracalajur a 
			where a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			".$where;
    $lr   = $lr_company ."
			from repprofitlosslajur a 
			where a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['enddate'])) . "')
			".$where;
    $this->pdf->AddPage('P');
    $this->pdf->SetFont('Arial','B',12);
    $per = $_GET['per'];
    $this->pdf->Cell(0, 0, 'FINANCIAL RATIO', 0, 0, 'C');
    $this->pdf->Cell(-192, 10, 'Per : ' . date("d F Y", strtotime($_GET['enddate'])), 0, 0, 'C');
    
    $sql1 = $akt.' and a.accactivaname = "TOTAL AKTIVA LANCAR" ';
    $aktivalancar = $connection->createCommand($sql1)->queryScalar();
    $sql3 = $akt.' and a.accactivaname = " PERSEDIAAN" ';
    $persediaan = $connection->createCommand($sql3)->queryScalar();
    $sql4 = $akt.' and a.accactivaname = " KAS" ';
    $kas = $connection->createCommand($sql4)->queryScalar();
    $sql5 = $akt.' and a.accactivaname = " BANK" ';
    $bank = $connection->createCommand($sql5)->queryScalar();
    $sql6 = $akt.' and a.accactivaname = "TOTAL AKTIVA" ';
    $aktiva = $connection->createCommand($sql6)->queryScalar();
    $sql13 = $akt.' and a.accactivaname = " PIUTANG DAGANG" ';
    $piutangdagang = $connection->createCommand($sql13)->queryScalar();
    $sql14 = $akt.' and a.accactivaname = " PIUTANG GIRO" ';
    $piutanggiro = $connection->createCommand($sql14)->queryScalar();
    $sql19 = $akt.' and a.accactivaname = " PERSEDIAAN BARANG JADI (FG)" ';
    $fg = $connection->createCommand($sql19)->queryScalar();
    $sql20 = $akt.' and a.accactivaname = " PERSEDIAAN BAHAN BAKU" ';
    $rw = $connection->createCommand($sql20)->queryScalar();
    $sql21 = $akt.' and a.accactivaname = " PERSEDIAAN WIP" ';
    $wip = $connection->createCommand($sql21)->queryScalar();
    
    
    $sql2 = $pas.' and a.accpasivaname = "TOTAL KEWAJIBAN LANCAR" ';
    $kewajibanlancar = $connection->createCommand($sql2)->queryScalar();
    $sql7 = $pas.' and a.accpasivaname = "TOTAL EKUITAS" ';
    $ekuitas = $connection->createCommand($sql7)->queryScalar();
    $sql8 = $pas.' and a.accpasivaname = "TOTAL KEWAJIBAN JANGKA PANJANG" ';
    $kewajibanjangkapanjang = $connection->createCommand($sql8)->queryScalar();
    $sql15 = $pas.' and a.accpasivaname = "HUTANG DAGANG" ';
    $hutangdagang = $connection->createCommand($sql15)->queryScalar();
    $sql16 = $pas.' and a.accpasivaname = "HUTANG GIRO" ';
    $hutanggiro = $connection->createCommand($sql16)->queryScalar();
    $sql17 = $pas.' and a.accpasivaname = "HUTANG AFILIASI" ';
    $hutangafiliasi = $connection->createCommand($sql17)->queryScalar();
    
    $sql9 = $lr.' and a.accountname = "Total PENJUALAN BERSIH BARANG JADI (FG)" ';
    $penjualanbersih = $connection->createCommand($sql9)->queryScalar();
    $sql10 = $lr.' and a.accountname = " LABA (RUGI) BERSIH" ';
    $labarugibersih = $connection->createCommand($sql10)->queryScalar();
    $sql11 = $lr.' and a.accountname = "Total LABA KOTOR BARANG JADI (FG)" ';
    $labakotor = $connection->createCommand($sql11)->queryScalar();
    $sql12 = $lr.' and a.accountname = "Total HARGA POKOK PENJUALAN" ';
    $hpp = $connection->createCommand($sql12)->queryScalar();
    
    $sql18 = "select sum(debit)
              from genledger a
              join genjournal b on b.genjournalid=a.genjournalid
              join account c on c.accountid=a.accountid and c.companyid=b.companyid
              where year(b.journaldate) = year('".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."')
              and month(b.journaldate) = month('".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."')
              and c.accountcode between '110501' and '1105019999999999999999'
              and b.referenceno like 'GR-%'".$where;
    $pembelian = $connection->createCommand($sql18)->queryScalar();
    
    
    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(3,35,'A. Liquiditas Ratio','B');
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(10,42,'- Current Ratio');
    $this->pdf->text(55,39,'Aktiva Lancar');
    $this->pdf->text(40,42,'= ');
    $this->pdf->text(45,40,'_______________________');
    $this->pdf->text(88,42,'x 100% ');
    $this->pdf->text(52,44,'Kewajiban Lancar');
    $this->pdf->text(50,51,Yii::app()->format->formatCurrency($aktivalancar/$per));
    $this->pdf->text(40,54,'= ');
    $this->pdf->text(45,52,'_______________________');
    $this->pdf->text(88,54,'x 100% ');
    $this->pdf->text(50,56,Yii::app()->format->formatCurrency($kewajibanlancar/$per));
    $this->pdf->text(40,62,'= ');
    $this->pdf->text(45,62,Yii::app()->format->formatCurrency(($aktivalancar/$kewajibanlancar)*100).' %');
    
    $this->pdf->text(10,72,'- Quick Ratio');
    $this->pdf->text(47,69,'Aktiva Lancar - Persediaan');
    $this->pdf->text(40,72,'= ');
    $this->pdf->text(45,70,'_______________________');
    $this->pdf->text(88,72,'x 100% ');
    $this->pdf->text(53,74,'Kewajiban Lancar');
    $this->pdf->text(40,84,'= ');
    $this->pdf->text(50,81,Yii::app()->format->formatCurrency(($aktivalancar-($fg+$wip+$rw))/$per));
    $this->pdf->text(45,82,'_______________________');
    $this->pdf->text(50,86,Yii::app()->format->formatCurrency($kewajibanlancar/$per));
    $this->pdf->text(88,84,'x 100% ');
    $this->pdf->text(40,92,'= ');
    $this->pdf->text(45,92,Yii::app()->format->formatCurrency((($aktivalancar - ($fg+$wip+$rw))/$kewajibanlancar)*100).' %');
    
    $this->pdf->text(10,102,'- Cash Ratio');
    $this->pdf->text(40,102,'= ');
    $this->pdf->text(58,99,'Kas & Bank');
    $this->pdf->text(45,100,'_______________________');
    $this->pdf->text(53,104,'Kewajiban Lancar');
    $this->pdf->text(88,102,'x 100% ');
    $this->pdf->text(40,112,'= ');
    $this->pdf->text(50,109,Yii::app()->format->formatCurrency(($kas+$bank)/$per));
    $this->pdf->text(45,110,'_______________________');
    $this->pdf->text(50,114,Yii::app()->format->formatCurrency($kewajibanlancar/$per));
    $this->pdf->text(88,112,'x 100% ');
    $this->pdf->text(40,120,'= ');
    $this->pdf->text(45,120,Yii::app()->format->formatCurrency((($kas + $bank)/$kewajibanlancar)*100).' %');
    
    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(3,135,'B. Solvabilitas Ratio','B');
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(13,140,'Total Assets To');
    $this->pdf->text(10,142,' - ');
    $this->pdf->text(13,145,'Debt ratio');
    $this->pdf->text(40,143,'= ');
    $this->pdf->text(55,140,'Jumlah Aktiva');
    $this->pdf->text(45,141,'_______________________');
    $this->pdf->text(52,145,'Jumlah Kewajiban');
    $this->pdf->text(88,142,'x 100% ');
    $this->pdf->text(40,155,'= ');
    $this->pdf->text(50,152,Yii::app()->format->formatCurrency($aktiva/$per));
    $this->pdf->text(45,153,'_______________________');
    $this->pdf->text(50,157,Yii::app()->format->formatCurrency(($kewajibanlancar+$kewajibanjangkapanjang)/$per));
    $this->pdf->text(88,155,'x 100% ');
    $this->pdf->text(40,163,'= ');
    $this->pdf->text(45,163,Yii::app()->format->formatCurrency(($aktiva/($kewajibanlancar+$kewajibanjangkapanjang))*100).' %');
    
    $this->pdf->text(13,173,'Capital To');
    $this->pdf->text(10,175,' - ');
    $this->pdf->text(13,178,'Total Debt ratio');
    $this->pdf->text(40,174,'= ');
    $this->pdf->text(54 ,172,'Jumlah Ekuitas');
    $this->pdf->text(45,173,'_______________________');
    $this->pdf->text(52,177,'Jumlah Kewajiban');
    $this->pdf->text(88,175,'x 100% ');
    $this->pdf->text(40,187,'= ');
    $this->pdf->text(50,185,Yii::app()->format->formatCurrency($ekuitas/$per));
    $this->pdf->text(45,186,'_______________________');
    $this->pdf->text(50,190,Yii::app()->format->formatCurrency(($kewajibanlancar+$kewajibanjangkapanjang)/$per));
    $this->pdf->text(88,188,'x 100% ');
    $this->pdf->text(40,196,'= ');
    $this->pdf->text(45,196,Yii::app()->format->formatCurrency(($ekuitas/($kewajibanlancar+$kewajibanjangkapanjang))*100).' %');  

    $this->pdf->text(13,206,'Total Debt To');
    $this->pdf->text(10,208,' - ');
    $this->pdf->text(13,211,'Total Assets Ratio');
    $this->pdf->text(40,207,'= ');
    $this->pdf->text(52,205,'Jumlah Kewajiban');
    $this->pdf->text(45,206,'_______________________');
    $this->pdf->text(55,210,'Jumlah Aktiva');
    $this->pdf->text(88,208,'x 100% ');
    $this->pdf->text(40,220,'= ');
    $this->pdf->text(50,218,Yii::app()->format->formatCurrency(($kewajibanlancar+$kewajibanjangkapanjang)/$per));
    $this->pdf->text(45,219,'_______________________');
    $this->pdf->text(50,223,Yii::app()->format->formatCurrency($aktiva/$per));
    $this->pdf->text(88,219,'x 100% ');
    $this->pdf->text(40,229,'= ');
    $this->pdf->text(45,229,Yii::app()->format->formatCurrency((($kewajibanlancar + $kewajibanjangkapanjang)/$aktiva)*100).' %');
    
    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,35,'C. Rentabilitas Ratio','B');
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(113,40,'Net Operating To');
    $this->pdf->text(166,39,'Laba Bersih');
    $this->pdf->text(110,42,'- ');
    $this->pdf->text(150,42,'= ');
    $this->pdf->text(155,40,'_____________________');
    $this->pdf->text(195,42,'x 100% ');
    $this->pdf->text(113,45,'Net Revenue Ratio');
    $this->pdf->text(166,44,'Penjualan Bersih');
    $this->pdf->text(160,51,Yii::app()->format->formatCurrency($labarugibersih/$per));
    $this->pdf->text(150,54,'= ');
    $this->pdf->text(155,52,'_____________________');
    $this->pdf->text(195,54,'x 100% ');
    $this->pdf->text(160,56,Yii::app()->format->formatCurrency($penjualanbersih/$per));
    $this->pdf->text(150,62,'= ');
    $this->pdf->text(155,62,Yii::app()->format->formatCurrency(($labarugibersih/$penjualanbersih)*100).' %'); 
    
    $this->pdf->text(113,69,'Gross Profit To');
    $this->pdf->text(166,69,'Laba Kotor');
    $this->pdf->text(110,72,'- ');
    $this->pdf->text(150,72,'= ');
    $this->pdf->text(155,70,'_____________________');
    $this->pdf->text(195,72,'x 100% ');
    $this->pdf->text(113,74,'Cost of Good Sold');
    $this->pdf->text(170,74,'HPP');
    $this->pdf->text(150,84,'= ');
    $this->pdf->text(155,82,'_____________________');
    $this->pdf->text(195,84,'x 100% ');
    $this->pdf->text(160,81,Yii::app()->format->formatCurrency($labakotor/$per));
    $this->pdf->text(160,86,Yii::app()->format->formatCurrency(-$hpp/$per));
    $this->pdf->text(150,92,'= ');
    $this->pdf->text(155,92,Yii::app()->format->formatCurrency(($labakotor/-$hpp)*100).' %');
    
    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,102,'D. Average Collection Period','B');
    $this->pdf->text(108,107,'(Umur Piutang Dagang)');
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(150,105,'= ');
    $this->pdf->text(166,102,'P/D + P/G');
    $this->pdf->text(155,103,'_____________________');
    $this->pdf->text(163,107,'Penjualan Bersih');
    $this->pdf->text(195,105,'x 30 ');
    $this->pdf->text(150,115,'= ');
    $this->pdf->text(155,113,'_____________________');
    $this->pdf->text(195,115,'x 30 ');
    $this->pdf->text(160,112,Yii::app()->format->formatCurrency(($piutangdagang+$piutanggiro)/$per));
    $this->pdf->text(160,117,Yii::app()->format->formatCurrency($penjualanbersih/$per));
    $this->pdf->text(150,123,'= ');
    $this->pdf->text(155,123,Yii::app()->format->formatCurrency((($piutangdagang+$piutanggiro)/$penjualanbersih)*30).' Hari');  

    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,133,'E. Average Days Inventory','B');
    $this->pdf->text(108,138,'(Umur Persediaan/Stok)'); 
    
    $this->pdf->SetFont('Arial','',9);      
    $this->pdf->text(150,136,'= ');
    $this->pdf->text(165,133,'Persediaan');
    $this->pdf->text(155,134,'_____________________');
    $this->pdf->text(169,138,'HPP');
    $this->pdf->text(195,135,'x 30 ');
    $this->pdf->text(150,148,'= ');
    $this->pdf->text(160,145,Yii::app()->format->formatCurrency(($fg+$wip+$rw)/$per));
    $this->pdf->text(155,146,'_____________________');
    $this->pdf->text(160,150,Yii::app()->format->formatCurrency(-$hpp/$per));
    $this->pdf->text(195,148,'x 30 ');
    $this->pdf->text(150,156,'= ');
    $this->pdf->text(155,156,Yii::app()->format->formatCurrency((($fg+$wip+$rw)/-$hpp)*30).' Hari');

    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,165,'F. Average Payment Period','B');
    $this->pdf->text(108,170,'(Umur Hutang Dagang)'); 
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(150,167,'= ');
    $this->pdf->text(160,165,'H/D + H/G + H/Afiliasi');
    $this->pdf->text(155,166,'_____________________');
    $this->pdf->text(163,170,'Pembelian Kredit');
    $this->pdf->text(195,168,'x 30 ');
    $this->pdf->text(150,180,'= ');
    $this->pdf->text(160,178,Yii::app()->format->formatCurrency(($hutangdagang+$hutanggiro+$hutangafiliasi)/$per));
    $this->pdf->text(155,179,'_____________________');
    $this->pdf->text(160,183,Yii::app()->format->formatCurrency($pembelian/$per));
    $this->pdf->text(195,181,'x 30 ');
    $this->pdf->text(150,189,'= ');
    $this->pdf->text(155,189,Yii::app()->format->formatCurrency((($hutangdagang+$hutanggiro+$hutangafiliasi)/$pembelian)*30).' Hari');

    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,198,'G. ROI / Return On Investment','B');
    $this->pdf->text(105,203,'(Hasil Pengembalian Investasi)'); 
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(150,200,'= ');
    $this->pdf->text(165,198,'Laba Bersih');
    $this->pdf->text(155,199,'_____________________');
    $this->pdf->text(163,203,'Jumlah Aktiva');
    $this->pdf->text(195,201,'x 100% ');
    $this->pdf->text(150,213,'= ');
    $this->pdf->text(160,211,Yii::app()->format->formatCurrency($labarugibersih/$per));
    $this->pdf->text(155,212,'_____________________');
    $this->pdf->text(160,216,Yii::app()->format->formatCurrency($aktiva/$per));
    $this->pdf->text(195,212,'x 100% ');
    $this->pdf->text(150,222,'= ');
    $this->pdf->text(155,222,Yii::app()->format->formatCurrency(($labarugibersih/$aktiva)*100).' %');

    $this->pdf->SetFont('Arial','B',9);
    $this->pdf->text(105,231,'H. ROE / Return On Equity','B');
    $this->pdf->text(105,236,'(Hasil Pengembalian Ekuitas)'); 
    
    $this->pdf->SetFont('Arial','',9);
    $this->pdf->text(150,233,'= ');
    $this->pdf->text(165,231,'Laba Bersih');
    $this->pdf->text(155,232,'_____________________');
    $this->pdf->text(167,236,'Ekuitas');
    $this->pdf->text(195,234,'x 100% ');
    $this->pdf->text(150,246,'= ');
    $this->pdf->text(160,244,Yii::app()->format->formatCurrency($labarugibersih/$per));
    $this->pdf->text(155,245,'_____________________');
    $this->pdf->text(160,249,Yii::app()->format->formatCurrency($ekuitas/$per));
    $this->pdf->text(195,245,'x 100% ');
    $this->pdf->text(150,255,'= ');
    $this->pdf->text(155,255,Yii::app()->format->formatCurrency(($labarugibersih/$ekuitas)*100).' %');
    
    $this->pdf->Output();
    }
  	
}