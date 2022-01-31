<?php
class ReportinventoryController extends AdminController {
  protected $menuname = 'reportinventory';		
	public $module = 'inventory';
	protected $pageTitle = 'Laporan Gudang';
	public function actionIndex() {
		parent::actionIndex();
		$this->render('index');
	}
	public function actionDownPDF() {
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['companyid']) && isset($_GET['sloc']) && isset($_GET['slocto']) && isset($_GET['storagebin']) && isset($_GET['customer']) && isset($_GET['sales']) && isset($_GET['product']) && isset($_GET['salesarea']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['keluar3']))
		{
			switch ($_GET['lro']) {
				case 1: 
					$this->RincianHistoriBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 2: 
					$this->RekapHistoriBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 3: 
					$this->KartuStokBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 4: 
					$this->KartuStokBarangPerRak($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 5: 
					$this->RekapStokBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 6: 
					$this->RekapStokBarangPerHari($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 7: 
					$this->RekapStokBarangDenganRak($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 8: 
					$this->RincianSuratJalanPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 9: 
					$this->RekapSuratJalanPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 10: 
					$this->RekapSuratJalanPerCustomer($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 11: 
					$this->RincianReturJualPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 12: 
					$this->RekapReturJualPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 13: 
					$this->RekapReturJualPerCustomer($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 14: 
					$this->RincianTerimaBarangPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 15: 
					$this->RekapTerimaBarangPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 16: 
					$this->RekapTerimaBarangPerSupplier($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 17: 
					$this->RincianReturBeliPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 18: 
					$this->RekapReturBeliPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 19: 
					$this->RekapReturBeliPerSupplier($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 20: 
					$this->PendinganFpb($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 21: 
					$this->PendinganFpp($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 22: 
					$this->RincianTransferGudangKeluarPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 23: 
					$this->RekapTransferGudangKeluarPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 24: 
					$this->RincianTransferGudangMasukPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 25: 
					$this->RekapTransferGudangMasukPerBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 26: 
					$this->RekapStokBarangAdaTransaksi($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 27: 
					$this->RekapSTTBPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 28: 
					$this->RekapReturBeliPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 29: 
					$this->RekapSuratJalanPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 30: 
					$this->RekapReturPenjualanPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 31: 
					$this->RekapTransferPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 32: 
					$this->RekapStockOpnamePerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 33: 
					$this->RekapKonversiPerDokumentBelumStatusMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 34: 
					$this->RawMaterialGudangAsalBelumAdaDataGudangFPB($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 35: 
					$this->RawMaterialGudangTujuanBelumAdaDataGudangFPB($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 36: 
					$this->RekapFPBBelumTransferPerDokumen($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 37: 
					$this->RAWMaterialBelumAdaGudangStockOpname($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 38: 
          $this->LaporanFPBStatusBelumMax($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 39: 
					$this->LaporanKetersediaanBarang($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 40: 
          $this->LaporanMaterialNotMoving($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 41: 
          $this->LaporanMaterialSlowMoving($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 42: 
          $this->LaporanMaterialFastMoving($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 43: 
          $this->LaporanHarian($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 44: 
          $this->LaporanRekapMonitoringStock($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				case 45: 
          $this->LaporanRincianMonitoringStock($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
					break;
				default:
					echo 'Tidak ada Laporan';
			}
		}
	}
								
	//1
	public function RincianHistoriBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select * from (select distinct a.productid,b.productname,c.description,d.slocid,
					(select ifnull(sum(x.qty),0) from productstockdet x
						where x.productid = a.productid and x.slocid = d.slocid and
                        x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal 			
                    from productplant a
                    inner join product b on b.productid=a.productid
                    inner join materialgroup c on c.materialgroupid=a.materialgroupid
					inner join sloc d on d.slocid = a.slocid
					inner join plant e on e.plantid = d.plantid
					inner join company f on f.companyid = e.companyid
					inner join productstockdet g on g.productid = a.productid and g.slocid = a.slocid
                    where f.companyid = " . $companyid . " and d.sloccode like '%" . $sloc . "%'
					and b.productname like '%" . $product . "%' 
                    and g.storagedesc like '%".$storagebin."%'
                    and g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname
					)z where awal > 0 or awal < 0";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->companyid = $companyid;
    $this->pdf->title    = 'Rincian Histori Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    $this->pdf->sety($this->pdf->gety() + 5);
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
      39,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Dokumen',
      'Tanggal',
      'Saldo Awal',
      'Beli',
      'R.Jual',
      'Trf In',
      'Prod',
      'Jual',
      'R.Beli',
      'Trf Out',
      'Pemakaian',
      'Koreksi',
      'Saldo'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, $row['productname']);
      $sql1        = "select *,(awal+beli+returjual+trfin+produksi+jual+returbeli+trfout+pemakaian+koreksi+konversiin+konversiout) as saldo
                        from
                        (select referenceno as dokumen,transdate as tanggal,awal,slocid,
                        case when instr(referenceno,'GR-') > 0 then qty else 0 end as beli,
                        case when instr(referenceno,'GIR-') > 0 then qty else 0 end as returjual, 
                        case when (instr(referenceno,'TFS-') > 0) and (qty > 0) then qty else 0 end as trfin, 
                        case when (instr(referenceno,'OP-') > 0) and (qty > 0) then qty else 0 end as produksi,
                        case when instr(referenceno,'SJ-') > 0 then qty else 0 end as jual,
                        case when instr(referenceno,'GRR-') > 0 then qty else 0 end as returbeli,
                        case when (instr(referenceno,'TFS-') > 0) and (qty < 0) then qty else 0 end as trfout,
                        case when (instr(referenceno,'OP-') > 0) and (qty < 0) then qty else 0 end as pemakaian,
                        case when instr(referenceno,'TSO-') > 0 then qty else 0 end as koreksi,
						case when (instr(referenceno,'konversi') > 0) and (qty > 0) then qty else 0 end as konversiin,
						case when (instr(referenceno,'konversi') > 0) and (qty < 0) then qty else 0 end as konversiout
                        from
						(select a.referenceno,a.transdate,a.qty,a.slocid,
						(select ifnull(sum(x.qty),0) from productstockdet x
						where x.productid = '" . $row['productid'] . "' and x.slocid = '" . $row['slocid'] . "' and
                        x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
                        from productstockdet a
                        inner join sloc b on b.slocid = a.slocid
                        inner join plant c on c.plantid = b.plantid
                        inner join company d on d.companyid = c.companyid
						inner join product e on e.productid = a.productid
                        where a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
						and a.storagedesc like '%".$storagebin."%' 
						and a.productid = '" . $row['productid'] . "'
						)z where awal > 0 or awal < 0 )zz";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $awal        = 0;
      $beli        = 0;
      $r_jual      = 0;
      $trfin       = 0;
      $prod        = 0;
      $jual        = 0;
      $r_beli      = 0;
      $trfout      = 0;
      $pemakaian   = 0;
      $koreksi     = 0;
      $total       = 0;
      $this->pdf->sety($this->pdf->gety() + 10);
      $this->pdf->coldetailalign = array(
        'L',
        'C',
        'C',
        'R',
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
      foreach ($dataReader1 as $row1) {
        $this->pdf->row(array(
          $row1['dokumen'],
          date(Yii::app()->params['datefromdb'], strtotime($row1['tanggal'])),
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['beli']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['returjual']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['trfin']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['produksi']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['jual']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['returbeli']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['trfout']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['pemakaian']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['koreksi'] + $row1['konversiin'] + $row1['konversiout'])
        ));
        $awal = $row1['awal'];
        $beli += $row1['beli'];
        $r_jual += $row1['returjual'];
        $trfin += $row1['trfin'];
        $prod += $row1['produksi'];
        $jual += $row1['jual'];
        $r_beli += $row1['returbeli'];
        $trfout += $row1['trfout'];
        $pemakaian += $row1['pemakaian'];
        $koreksi += $row1['koreksi'] + $row1['konversiin'] + $row1['konversiout'];
        $total = $awal + $beli + $r_jual + $trfin + $prod + $jual + $r_beli + $trfout + $pemakaian + $koreksi;
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $beli),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $r_jual),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $trfin),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $prod),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $jual),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $r_beli),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $trfout),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pemakaian),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $koreksi),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //2
	public function RekapHistoriBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select b.productid,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and 
					g.productname like '%" . $product . "%' and g.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.storagedesc like '%".$storagebin."%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->companyid = $companyid;
    $this->pdf->title    = 'Rekap Histori Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    $this->pdf->sety($this->pdf->gety() + 6);
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
      50,
      15,
      15,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Beli',
      'R.Jual',
      'Trf In',
      'Prod',
      'Jual',
      'R.Beli',
      'Trf Out',
      'Pemakaian',
      'Koreksi',
      'Saldo'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $sql1        = "select *,(awal+beli+returjual+trfin+produksi+jual+returbeli+trfout+pemakaian+koreksi) as saldo
                            from
                            (select 
                            (
                            select distinct a.productname from product a
                            where a.productid = t.productid
                            ) as barang,
                            v.uomcode as satuan,
														(
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid 
														and aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
														and aw.slocid = t.slocid 
														and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
														and c.storagedesc like '%".$storagebin."%'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi
                            from productplant t
							join sloc u on u.slocid = t.slocid
							join unitofmeasure v on v.unitofmeasureid = t.unitofissue
                            where t.productid = '" . $row['productid'] . "' and t.slocid = '" . $row['slocid'] . "')z
							ORDER BY barang";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 3);
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
        50,
        15,
        15,
        20,
        20,
        20,
        20,
        20,
        20,
        20,
        20,
        20,
        20,
        20
      ));
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'R',
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
      $this->pdf->setFont('Arial', '', 7);
      foreach ($dataReader1 as $row1) {
        $this->pdf->row(array(
          $row1['barang'],
          $row1['satuan'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['awal']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['beli']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['returjual']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['trfin']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['produksi']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['jual']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['returbeli']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['trfout']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['pemakaian']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['koreksi']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['saldo'])
        ));
        $this->pdf->checkPageBreak(20);
      }
    }
    $this->pdf->Output();
  }
  //3
	public function KartuStokBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct a.description,a.materialgroupid
									from materialgroup a
									join productplant b on b.materialgroupid=a.materialgroupid
									join sloc c on c.slocid = b.slocid
									join plant d on d.plantid = c.plantid
									join company e on e.companyid = d.companyid
									join product f on f.productid = b.productid
									where e.companyid = " . $companyid . " and f.productid in
									(select z.productid 
									from productstockdet z
									join sloc za on za.slocid = z.slocid
									join plant zb on zb.plantid = za.plantid
									join company zc on zc.companyid = zb.companyid
									join product zd on zd.productid = z.productid
									where zc.companyid = " . $companyid . " and z.slocid = b.slocid 
									and za.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
									and z.storagedesc like '%".$storagebin."%' )
									order by description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->companyid = $companyid;
    $this->pdf->title    = 'Kartu Stock Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 0);
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
      40,
      30,
      30,
      30,
      30,
      30
    ));
    $this->pdf->colheader = array(
      'Dokumen',
      'Tanggal',
      'Saldo Awal',
      'Masuk',
      'Keluar',
      'Saldo Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 5, ': ' . $row['description']);
      $awal1       = 0;
      $masuk1      = 0;
      $keluar1     = 0;
      $saldo1      = 0;
      $sql1        = "select distinct productid,productname,slocid,sloccode from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,
					(select ifnull(sum(x.qty),0) from productstockdet x
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and e.materialgroupid = '" . $row['materialgroupid'] . "'
				and a.storagedesc like '%".$storagebin."%' 
				and g.productname like '%" . $product . "%' and 
				a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz) zzzz
				order by productname,sloccode";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, $row1['productname']);
        $this->pdf->text(170, $this->pdf->gety() + 10, $row1['sloccode']);
        $sql2        = "select awal,dokumen,tanggal,masuk,keluar,(awal+masuk+keluar) as saldo
                        from
                        (select awal,dokumen,tanggal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
                        from
                        (select referenceno as dokumen, transdate as tanggal,slocid,awal,
                        case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
                        case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
                        case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
                        case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
												case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
                        case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
                        case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
                        case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
                        case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
												case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
                        case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
                        from
                        (select a.referenceno,a.transdate,a.qty,a.slocid,
													(select ifnull(sum(x.qty),0) from productstockdet x
													where x.productid = '" . $row1['productid'] . "' and x.slocid = '" . $row1['slocid'] . "' and
                        x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
                        from productstockdet a
                        join sloc b on b.slocid = a.slocid
                        join plant c on c.plantid = b.plantid
                        join company d on d.companyid = c.companyid
                        where a.productid = '" . $row1['productid'] . "' and a.slocid = '" . $row1['slocid'] . "' and a.storagedesc like '%".$storagebin."%' and
												a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $awal        = 0;
        $masuk       = 0;
        $keluar      = 0;
        $saldo       = 0;
        $this->pdf->sety($this->pdf->gety() + 12);
        $this->pdf->coldetailalign = array(
          'L',
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $this->pdf->row(array(
            $row2['dokumen'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row2['tanggal'])),
            '',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['masuk']),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['keluar']),
            ''
          ));
          $awal = $row2['awal'];
          $masuk += $row2['masuk'];
          $keluar += $row2['keluar'];
          $saldo = $awal + $masuk + $keluar;
        }
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->row(array(
          '',
          'Total',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $saldo1 += $saldo;
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->row(array(
        '',
        'Grand Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo1)
      ));
    }
    $this->pdf->Output();
  }
  //4
	public function KartuStokBarangPerRak($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $saldo2     = 0;
    $sql        = "select distinct a.description,a.materialgroupid
									from materialgroup a
									join productplant b on b.materialgroupid=a.materialgroupid
									join sloc c on c.slocid = b.slocid
									join plant d on d.plantid = c.plantid
									join company e on e.companyid = d.companyid
									join product f on f.productid = b.productid
									where e.companyid = " . $companyid . " and f.productid in
									(select z.productid 
									from productstockdet z
									join sloc za on za.slocid = z.slocid
									join plant zb on zb.plantid = za.plantid
									join company zc on zc.companyid = zb.companyid
									join product zd on zd.productid = z.productid
									where zc.companyid = " . $companyid . " and z.slocid = b.slocid 
									and z.storagedesc like '%".$storagebin."%' 
									and za.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%')
									order by description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->companyid = $companyid;
    $this->pdf->title    = 'Kartu Stock Barang Per Rak';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 8);
      $this->pdf->text(9, $this->pdf->gety() + 10, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['description']);
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $saldo1  = 0;
      $this->pdf->sety($this->pdf->gety() + 0);
      $this->pdf->setFont('Arial', 'B', 8);
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
        40,
        20,
        28,
        25,
        25,
        25,
        30,
        28
      ));
      $this->pdf->colheader = array(
        'Dokumen',
        'Tanggal',
        'Saldo Awal',
        'Masuk',
        'Keluar',
        'Rak',
        'Saldo Akhir'
      );
      $this->pdf->RowHeader();
      $sql1        = "select distinct productid,productname,slocid,sloccode,storagebinid,rak from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,storagebinid,rak,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,f.storagebinid,f.description as rak,
					(select ifnull(sum(x.qty),0) from productstockdet x
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '2016-04-01') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' 
				and g.productname like '%" . $product . "%' and e.materialgroupid = " . $row['materialgroupid'] . "
				and a.storagedesc like '%".$storagebin."%' 
				and a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz) zzzz
				order by productname,sloccode,rak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->text(10, $this->pdf->gety() + 10, $row1['productname']);
        $this->pdf->text(160, $this->pdf->gety() + 10, $row1['sloccode']);
        $awal        = 0;
        $masuk       = 0;
        $keluar      = 0;
        $saldo       = 0;
        $sql2        = "select awal,dokumen,tanggal,sum(masuk) as totmasuk,sum(keluar) as totkeluar,sum(awal+masuk+keluar) as saldo
					from
					(select awal,dokumen,tanggal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
					from
					(select referenceno as dokumen, transdate as tanggal,slocid,awal,
					case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
					case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
					case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
					case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
					case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
					case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
					case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
					from
					(select a.referenceno,a.transdate,a.qty,a.slocid,
						(select ifnull(sum(x.qty),0) from productstockdet x
						where x.productid = '" . $row1['productid'] . "' and x.slocid = '" . $row1['slocid'] . "' and
						x.storagebinid = " . $row1['storagebinid'] . " and
					x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
					group by storagebinid) as awal
					from productstockdet a
					join sloc b on b.slocid = a.slocid
					join plant c on c.plantid = b.plantid
					join company d on d.companyid = c.companyid
					where a.productid = '" . $row1['productid'] . "' and a.slocid = '" . $row1['slocid'] . "' and a.storagedesc like '%".$storagebin."%' and
					a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.storagebinid = " . $row1['storagebinid'] . ") z) zz) zzz group by dokumen";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 12);
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'C',
          'R',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $this->pdf->row(array(
            $row2['dokumen'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row2['tanggal'])),
            '',
            Yii::app()->format->formatNumber($row2['totmasuk']),
            Yii::app()->format->formatNumber($row2['totkeluar']),
            $row1['rak'],
            ''
          ));
          $awal = $row2['awal'];
          $masuk += $row2['totmasuk'];
          $keluar += $row2['totkeluar'];
          $saldo = $awal + $masuk + $keluar;
        }
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->row(array(
          '',
          'Total',
          Yii::app()->format->formatNumber($awal),
          Yii::app()->format->formatNumber($masuk),
          Yii::app()->format->formatNumber($keluar),
          '',
          Yii::app()->format->formatNumber($saldo)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $saldo1 += $saldo;
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->row(array(
        '',
        'Sub Total',
        Yii::app()->format->formatNumber($awal1),
        Yii::app()->format->formatNumber($masuk1),
        Yii::app()->format->formatNumber($keluar1),
        '',
        Yii::app()->format->formatNumber($saldo1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $saldo2 += $saldo1;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->setFont('Arial', 'B', 10);
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->row(array(
      '',
      'Grand Total',
      Yii::app()->format->formatNumber($awal2),
      Yii::app()->format->formatNumber($masuk2),
      Yii::app()->format->formatNumber($keluar2),
      '',
      Yii::app()->format->formatNumber($saldo2)
    ));
    $this->pdf->Output();
  }
  //?
	public function ReportKartuStokBarangPerRak($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct a.description
			from materialgroup a
			join productplant b on b.materialgroupid=a.materialgroupid
			join sloc c on c.slocid = b.slocid
			join plant d on d.plantid = c.plantid
			join company e on e.companyid = d.companyid
			join product f on f.productid = b.productid
			where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and f.productid in
			(select z.productid 
			from productstockdet z
			join sloc za on za.slocid = z.slocid
			join plant zb on zb.plantid = za.plantid
			join company zc on zc.companyid = zb.companyid
			join product zd on zd.productid = z.productid
			where zc.companyid = " . $companyid . " and z.slocid = b.slocid and zd.productname like '%" . $product . "%')
			order by description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Report Kartu Stock Barang Per Rak';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 0);
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
      40,
      30,
      30,
      30,
      30,
      30
    ));
    $this->pdf->colheader = array(
      'Dokumen',
      'Tanggal',
      'Saldo Awal',
      'Masuk',
      'Keluar',
      'Saldo Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 5, ': ' . $row['description']);
      $awal1       = 0;
      $masuk1      = 0;
      $keluar1     = 0;
      $saldo1      = 0;
      $sql1        = "select distinct productid,productname,slocid,sloccode,storagebinid,rak from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,storagebinid,rak,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,f.storagebinid,f.description as rak,
					(select ifnull(sum(x.qty),0) from productstockdet x
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '2016-04-01') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and g.productname like '%" . $product . "%' and 
				a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz) zzzz
				order by productname,sloccode,rak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, $row1['productname']);
        $this->pdf->text(100, $this->pdf->gety() + 10, $row1['rak']);
        $this->pdf->text(170, $this->pdf->gety() + 10, $row1['sloccode']);
        $awal        = 0;
        $masuk       = 0;
        $keluar      = 0;
        $saldo       = 0;
        $sql2        = "select awal,dokumen,tanggal,masuk,keluar,(awal+masuk+keluar) as saldo
					from
					(select awal,dokumen,tanggal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
					from
					(select referenceno as dokumen, transdate as tanggal,slocid,awal,
					case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
					case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
					case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
					case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
					case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
					case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
					case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
					from
					(select a.referenceno,a.transdate,a.qty,a.slocid,
						(select ifnull(sum(x.qty),0) from productstockdet x
						where x.productid = '" . $row1['productid'] . "' and x.slocid = '" . $row1['slocid'] . "' and
						x.storagebinid = " . $row1['storagebinid'] . " and
					x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
					group by storagebinid) as awal
					from productstockdet a
					join sloc b on b.slocid = a.slocid
					join plant c on c.plantid = b.plantid
					join company d on d.companyid = c.companyid
					where a.productid = '" . $row1['productid'] . "' and a.slocid = '" . $row1['slocid'] . "' and
					a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.storagebinid = " . $row1['storagebinid'] . ") z) zz) zzz";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 12);
        $this->pdf->coldetailalign = array(
          'L',
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $this->pdf->row(array(
            $row2['dokumen'],
            date(Yii::app()->params['datetodb'], strtotime($row2['tanggal'])),
            '',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['masuk']),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['keluar']),
            ''
          ));
          $awal = $row2['awal'];
          $masuk += $row2['masuk'];
          $keluar += $row2['keluar'];
          $saldo = $awal + $masuk + $keluar;
        }
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->row(array(
          '',
          'Total',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $saldo1 += $saldo;
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->row(array(
        '',
        'Grand Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo1)
      ));
    }
    $this->pdf->Output();
  }
  //5
	public function RekapStokBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    if($companyid > 0) {
      $joincom = ""; 
      $joincom1 = ""; 
      $wherecom = "  e.companyid = ".$companyid." "; 
      $wherecom1 = "  zc.companyid = ".$companyid." ";
    }
    else {
      $joincom = " join company a9 on a9.companyid=e.companyid "; 
      $joincom1 = " join company a9 on a9.companyid=g.companyid "; 
      $wherecom = " e.isgroup = 1"; 
      $wherecom1 = "  zc.isgroup = 1";
    }
    
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where {$wherecom} and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
				order by c.sloccode";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where {$wherecom} and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by a.description";
    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid,g.productname
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant f on f.plantid = d.plantid
                    join company e on e.companyid = f.companyid
                    join product g on g.productid = b.productid
                    where {$wherecom} and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by g.productname";
    $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            and a.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            and b.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and aw.unitofmeasureid = t.unitofissue and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and c.unitofmeasureid = t.unitofissue and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and d.unitofmeasureid = t.unitofissue and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and e.unitofmeasureid = t.unitofissue and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and f.unitofmeasureid = t.unitofissue and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and g.unitofmeasureid = t.unitofissue and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and h.unitofmeasureid = t.unitofissue and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and i.unitofmeasureid = t.unitofissue and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and j.unitofmeasureid = t.unitofissue and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and k.unitofmeasureid = t.unitofissue and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and l.unitofmeasureid = t.unitofissue and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and l.storagedesc like '%".$storagebin."%'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and m.unitofmeasureid = t.unitofissue and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.storagedesc like '%".$storagebin."%'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' order by barang) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
    $dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
    $this->pdf->Output();
  }
	public function RekapStokBarang_old($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
				order by c.sloccode";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by a.description";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by g.productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            and a.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            and b.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and aw.unitofmeasureid = t.unitofissue and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and c.unitofmeasureid = t.unitofissue and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and d.unitofmeasureid = t.unitofissue and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and e.unitofmeasureid = t.unitofissue and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and f.unitofmeasureid = t.unitofissue and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and g.unitofmeasureid = t.unitofissue and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and h.unitofmeasureid = t.unitofissue and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and i.unitofmeasureid = t.unitofissue and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and j.unitofmeasureid = t.unitofissue and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and k.unitofmeasureid = t.unitofissue and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and l.unitofmeasureid = t.unitofissue and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and l.storagedesc like '%".$storagebin."%'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and m.unitofmeasureid = t.unitofissue and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.storagedesc like '%".$storagebin."%'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' order by barang) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
    $this->pdf->Output();
  }
  //6
	public function RekapStokBarangPerHari($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct b.productname,c.uomcode,d.sloccode,
                    (
                        select ifnull(sum(ab.qty),0) 
                        from productstockdet ab
                        where year(ab.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ab.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ab.transdate)=1
                        and ab.productid = a.productid
                        and ab.unitofmeasureid = a.unitofissue
                        and ab.slocid = a.slocid 
												and ab.storagedesc like '%".$storagebin."%' 
                    ) as d1,
                    (
                        select ifnull(sum(ac.qty),0) 
                        from productstockdet ac
                        where year(ac.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ac.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ac.transdate)=2
                        and ac.productid = a.productid
                        and ac.unitofmeasureid = a.unitofissue
                        and ac.slocid = a.slocid 
												and ac.storagedesc like '%".$storagebin."%' 
                    ) as d2,
                    (
                        select ifnull(sum(ad.qty),0) 
                        from productstockdet ad
                        where year(ad.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ad.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ad.transdate)=3
                        and ad.productid = a.productid
                        and ad.unitofmeasureid = a.unitofissue
                        and ad.slocid = a.slocid 
												and ad.storagedesc like '%".$storagebin."%' 
                    ) as d3,
                    (
                        select ifnull(sum(ae.qty),0) 
                        from productstockdet ae
                        where year(ae.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ae.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ae.transdate)=4
                        and ae.productid = a.productid
                        and ae.unitofmeasureid = a.unitofissue
                        and ae.slocid = a.slocid 
												and ae.storagedesc like '%".$storagebin."%' 
                    ) as d4,
                    (
                        select ifnull(sum(af.qty),0) 
                        from productstockdet af
                        where year(af.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(af.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(af.transdate)=5
                        and af.productid = a.productid
                        and af.unitofmeasureid = a.unitofissue
                        and af.slocid = a.slocid 
												and af.storagedesc like '%".$storagebin."%' 
                    ) as d5,
                    (
                        select ifnull(sum(ag.qty),0) 
                        from productstockdet ag
                        where year(ag.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ag.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ag.transdate)=6
                        and ag.productid = a.productid
                        and ag.unitofmeasureid = a.unitofissue
                        and ag.slocid = a.slocid 
												and ag.storagedesc like '%".$storagebin."%' 
                    ) as d6,
                    (
                        select ifnull(sum(ah.qty),0) 
                        from productstockdet ah
                        where year(ah.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ah.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ah.transdate)=7
                        and ah.productid = a.productid
                        and ah.unitofmeasureid = a.unitofissue
                        and ah.slocid = a.slocid 
												and ah.storagedesc like '%".$storagebin."%' 
                    ) as d7,
                    (
                        select ifnull(sum(ai.qty),0) 
                        from productstockdet ai
                        where year(ai.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ai.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ai.transdate)=8
                        and ai.productid = a.productid
                        and ai.unitofmeasureid = a.unitofissue
                        and ai.slocid = a.slocid 
												and ai.storagedesc like '%".$storagebin."%' 
                    ) as d8,
                    (
                        select ifnull(sum(aj.qty),0) 
                        from productstockdet aj
                        where year(aj.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(aj.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(aj.transdate)=9
                        and aj.productid = a.productid
                        and aj.unitofmeasureid = a.unitofissue
                        and aj.slocid = a.slocid 
												and aj.storagedesc like '%".$storagebin."%' 
                    ) as d9,
                    (
                        select ifnull(sum(ak.qty),0) 
                        from productstockdet ak
                        where year(ak.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ak.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ak.transdate)=10
                        and ak.productid = a.productid
                        and ak.unitofmeasureid = a.unitofissue
                        and ak.slocid = a.slocid 
												and ak.storagedesc like '%".$storagebin."%' 
                    ) as d10,
                    (
                        select ifnull(sum(al.qty),0) 
                        from productstockdet al
                        where year(al.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(al.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(al.transdate)=11
                        and al.productid = a.productid
                        and al.unitofmeasureid = a.unitofissue
                        and al.slocid = a.slocid 
												and al.storagedesc like '%".$storagebin."%' 
                    ) as d11,
                    (
                        select ifnull(sum(am.qty),0) 
                        from productstockdet am
                        where year(am.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(am.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(am.transdate)=12
                        and am.productid = a.productid
                        and am.unitofmeasureid = a.unitofissue
                        and am.slocid = a.slocid 
												and am.storagedesc like '%".$storagebin."%' 
                    ) as d12,
                    (
                        select ifnull(sum(an.qty),0) 
                        from productstockdet an
                        where year(an.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(an.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(an.transdate)=13
                        and an.productid = a.productid
                        and an.unitofmeasureid = a.unitofissue
                        and an.slocid = a.slocid 
												and an.storagedesc like '%".$storagebin."%' 
                    ) as d13,
                    (
                        select ifnull(sum(ao.qty),0) 
                        from productstockdet ao
                        where year(ao.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ao.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ao.transdate)=14
                        and ao.productid = a.productid
                        and ao.unitofmeasureid = a.unitofissue
                        and ao.slocid = a.slocid 
												and ao.storagedesc like '%".$storagebin."%' 
                    ) as d14,
                    (
                        select ifnull(sum(ap.qty),0) 
                        from productstockdet ap
                        where year(ap.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ap.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ap.transdate)=15
                        and ap.productid = a.productid
                        and ap.unitofmeasureid = a.unitofissue
                        and ap.slocid = a.slocid 
												and ap.storagedesc like '%".$storagebin."%' 
                    ) as d15,
                    (
                        select ifnull(sum(aq.qty),0) 
                        from productstockdet aq
                        where year(aq.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(aq.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(aq.transdate)=16
                        and aq.productid = a.productid
                        and aq.unitofmeasureid = a.unitofissue
                        and aq.slocid = a.slocid 
												and aq.storagedesc like '%".$storagebin."%' 
                    ) as d16,
                    (
                        select ifnull(sum(ar.qty),0) 
                        from productstockdet ar
                        where year(ar.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ar.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ar.transdate)=17
                        and ar.productid = a.productid
                        and ar.unitofmeasureid = a.unitofissue
                        and ar.slocid = a.slocid 
												and ar.storagedesc like '%".$storagebin."%' 
                    ) as d17,
                    (
                        select ifnull(sum(at.qty),0) 
                        from productstockdet at
                        where year(at.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(at.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(at.transdate)=18
                        and at.productid = a.productid
                        and at.unitofmeasureid = a.unitofissue
                        and at.slocid = a.slocid 
												and at.storagedesc like '%".$storagebin."%' 
                    ) as d18,
                    (
                        select ifnull(sum(au.qty),0) 
                        from productstockdet au
                        where year(au.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(au.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(au.transdate)=19
                        and au.productid = a.productid
                        and au.unitofmeasureid = a.unitofissue
                        and au.slocid = a.slocid 
												and au.storagedesc like '%".$storagebin."%' 
                    ) as d19,
                    (
                        select ifnull(sum(av.qty),0) 
                        from productstockdet av
                        where year(av.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(av.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(av.transdate)=20
                        and av.productid = a.productid
                        and av.unitofmeasureid = a.unitofissue
                        and av.slocid = a.slocid 
												and av.storagedesc like '%".$storagebin."%' 
                    ) as d20,
                    (
                        select ifnull(sum(aw.qty),0) 
                        from productstockdet aw
                        where year(aw.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(aw.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(aw.transdate)=21
                        and aw.productid = a.productid
                        and aw.unitofmeasureid = a.unitofissue
                        and aw.slocid = a.slocid 
												and aw.storagedesc like '%".$storagebin."%' 
                    ) as d21,
                    (
                        select ifnull(sum(ax.qty),0) 
                        from productstockdet ax
                        where year(ax.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ax.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ax.transdate)=22
                        and ax.productid = a.productid
                        and ax.unitofmeasureid = a.unitofissue
                        and ax.slocid = a.slocid 
												and ax.storagedesc like '%".$storagebin."%' 
                    ) as d22,
                    (
                        select ifnull(sum(ay.qty),0) 
                        from productstockdet ay
                        where year(ay.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ay.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ay.transdate)=23
                        and ay.productid = a.productid
                        and ay.unitofmeasureid = a.unitofissue
                        and ay.slocid = a.slocid 
												and ay.storagedesc like '%".$storagebin."%' 
                    ) as d23,
                    (
                        select ifnull(sum(az.qty),0) 
                        from productstockdet az
                        where year(az.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(az.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(az.transdate)=24
                        and az.productid = a.productid
                        and az.unitofmeasureid = a.unitofissue
                        and az.slocid = a.slocid 
												and az.storagedesc like '%".$storagebin."%' 
                    ) as d24,
                    (
                        select ifnull(sum(ba.qty),0) 
                        from productstockdet ba
                        where year(ba.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(ba.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(ba.transdate)=25
                        and ba.productid = a.productid
                        and ba.unitofmeasureid = a.unitofissue
                        and ba.slocid = a.slocid 
												and ba.storagedesc like '%".$storagebin."%' 
                    ) as d25,
                    (
                        select ifnull(sum(bb.qty),0) 
                        from productstockdet bb
                        where year(bb.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(bb.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(bb.transdate)=26
                        and bb.productid = a.productid
                        and bb.unitofmeasureid = a.unitofissue
                        and bb.slocid = a.slocid 
												and bb.storagedesc like '%".$storagebin."%' 
                    ) as d26,
                    (
                        select ifnull(sum(bc.qty),0) 
                        from productstockdet bc
                        where year(bc.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(bc.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(bc.transdate)=27
                        and bc.productid = a.productid
                        and bc.unitofmeasureid = a.unitofissue
                        and bc.slocid = a.slocid 
												and bc.storagedesc like '%".$storagebin."%' 
                    ) as d27,
                    (
                        select ifnull(sum(bd.qty),0) 
                        from productstockdet bd
                        where year(bd.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(bd.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(bd.transdate)=28
                        and bd.productid = a.productid
                        and bd.unitofmeasureid = a.unitofissue
                        and bd.slocid = a.slocid 
												and bd.storagedesc like '%".$storagebin."%' 
                    ) as d28,
                    (
                        select ifnull(sum(be.qty),0) 
                        from productstockdet be
                        where year(be.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(be.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(be.transdate)=29
                        and be.productid = a.productid
                        and be.unitofmeasureid = a.unitofissue
                        and be.slocid = a.slocid 
												and be.storagedesc like '%".$storagebin."%' 
                    ) as d29,
                    (
                        select ifnull(sum(bf.qty),0) 
                        from productstockdet bf
                        where year(bf.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(bf.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(bf.transdate)=30
                        and bf.productid = a.productid
                        and bf.unitofmeasureid = a.unitofissue
                        and bf.slocid = a.slocid 
												and bf.storagedesc like '%".$storagebin."%' 
                    ) as d30,
                    (
                        select ifnull(sum(bg.qty),0) 
                        from productstockdet bg
                        where year(bg.transdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') 
                        and month(bg.transdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
                        and day(bg.transdate)=31
                        and bg.productid = a.productid
                        and bg.unitofmeasureid = a.unitofissue
                        and bg.slocid = a.slocid 
												and bg.storagedesc like '%".$storagebin."%' 
                    ) as d31
                    from productplant a
                    join product b on b.productid=a.productid
                    join unitofmeasure c on c.unitofmeasureid=a.unitofissue
                    join sloc d on d.slocid=a.slocid
                    join plant e on e.plantid=d.plantid
                    join company f on f.companyid=e.companyid
                    where f.companyid='" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and b.productname like '%" . $product . "%'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang Per Hari';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->setFont('Arial', 'B', 6);
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
      20,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8,
      8
    ));
    $this->pdf->colheader = array(
      'Item',
      'Unit',
      '1',
      '2',
      '3',
      '4',
      '5',
      '6',
      '7',
      '8',
      '9',
      '10',
      '11',
      '12',
      '13',
      '14',
      '15',
      '16',
      '17',
      '18',
      '19',
      '20',
      '21',
      '22',
      '23',
      '24',
      '25',
      '26',
      '27',
      '28',
      '29',
      '30',
      '31'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
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
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 6);
      $this->pdf->row(array(
        $row['productname'],
        $row['uomcode'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d1']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d2']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d3']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d4']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d5']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d6']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d7']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d8']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d9']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d10']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d11']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d12']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d13']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d14']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d15']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d16']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d17']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d18']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d19']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d20']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d21']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d22']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d23']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d24']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d25']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d26']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d27']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d28']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d29']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d30']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['d31'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //7
	public function RekapStokBarangDenganRak($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.storagedesc like '%" . $storagebin . "%' and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang Dengan Rak';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 8);
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
      60,
      20,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Rak',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.storagedesc like '%" . $storagebin . "%' and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid,b.unitofissue,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
										join storagebin zd on zd.storagebinid=z.storagebinid
                    where zc.companyid = " . $companyid . " and z.storagedesc like '%" . $storagebin . "%' and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from 
							(select barang,productid,satuan,unitofmeasureid,rak,storagebinid,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,productid,satuan,unitofmeasureid,rak,storagebinid,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
                            from
                            (select 
                            s.productname as barang,s.productid,b.uomcode as satuan,b.unitofmeasureid,t.storagedesc as rak,t.storagebinid,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.storagebinid = t.storagebinid and
                            aw.unitofmeasureid = t.unitofmeasureid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
														and aw.storagedesc like '%" . $storagebin . "%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.storagebinid = t.storagebinid and
														c.unitofmeasureid = t.unitofmeasureid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and c.storagedesc like '%" . $storagebin . "%'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.storagebinid = t.storagebinid and
                            d.unitofmeasureid = t.unitofmeasureid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and d.storagedesc like '%" . $storagebin . "%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.storagebinid = t.storagebinid and
                            e.unitofmeasureid = t.unitofmeasureid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and e.storagedesc like '%" . $storagebin . "%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.storagebinid = t.storagebinid and
                            f.unitofmeasureid = t.unitofmeasureid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and f.storagedesc like '%" . $storagebin . "%'
                            ) as produksi,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like '%konversi%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.storagebinid = t.storagebinid and
                            f.unitofmeasureid = t.unitofmeasureid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and f.storagedesc like '%" . $storagebin . "%'
                            ) as konversiin,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.storagebinid = t.storagebinid and
                            g.unitofmeasureid = t.unitofmeasureid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and g.storagedesc like '%" . $storagebin . "%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.storagebinid = t.storagebinid and
                            h.unitofmeasureid = t.unitofmeasureid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and h.storagedesc like '%" . $storagebin . "%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.storagebinid = t.storagebinid and
                            i.unitofmeasureid = t.unitofmeasureid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and i.storagedesc like '%" . $storagebin . "%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.storagebinid = t.storagebinid and
                            j.unitofmeasureid = t.unitofmeasureid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and j.storagedesc like '%" . $storagebin . "%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like '%konversi%' and
                            k.qty < 0 and
                            k.slocid = t.slocid and
                            k.storagebinid = t.storagebinid and
                            k.unitofmeasureid = t.unitofmeasureid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and k.storagedesc like '%" . $storagebin . "%'
                            ) as konversiout,
                            (
                            select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like 'TSO-%' and
                            l.slocid = t.slocid and
                            l.storagebinid = t.storagebinid and
                            l.unitofmeasureid = t.unitofmeasureid and
                            l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
														and l.storagedesc like '%" . $storagebin . "%'
                            ) as koreksi
                            from productstock t
							join productplant r on r.productid=t.productid and r.unitofissue=t.unitofmeasureid and t.slocid=r.slocid
							join materialgroup u on u.materialgroupid = r.materialgroupid
							join sloc v on v.slocid = t.slocid
							join product s on s.productid=t.productid
							join unitofmeasure b on b.unitofmeasureid=t.unitofmeasureid
							where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and t.storagedesc like '%" . $storagebin . "%' and v.slocid = '" . $row['slocid'] . "' and t.unitofmeasureid = '".$row2['unitofissue']."') z) zz )zzz where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->setFont('Arial', '', 8);
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
              60,
              20,
              20,
              20,
              20,
              20,
              20
            ));
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              $row3['rak'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $this->pdf->setwidths(array(
          10,
          15,
          80,
          20,
          20,
          20,
          20
        ));
        $this->pdf->colalign = array(
          'L',
          'R',
          'R',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', 'B', 9);
        $this->pdf->row(array(
          '',
          '',
          'TOTAL ' . $row['sloccode'] . ' - ' . $row1['divisi'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalawal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalmasuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalkeluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalakhir)
        ));
      }
    }
    $this->pdf->Output();
  }
  //8
	public function RincianSuratJalanPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct b.giheaderid,b.gino,b.gidate,a.sono,c.fullname as customer,d.fullname as sales,e.areaname 
                   from giheader b 
                   join soheader a on a.soheaderid = b.soheaderid
                   join addressbook c on c.addressbookid=a.addressbookid
                   join employee d on d.employeeid=a.employeeid
      				 join salesarea e on e.salesareaid=c.salesareaid
      				 join gidetail f on f.giheaderid=b.giheaderid
      				 join sloc h on h.slocid = f.slocid
					where b.gino is not null and a.companyid = " . $companyid . " and b.recordstatus = 3 and h.sloccode like '%" . $sloc . "%' 
					and d.fullname like '%" . $sales . "%'  and e.areaname like '%" . $salesarea . "%'  and 
					b.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
					and f.productid in (select x.productid 
					from productplant x join product xx on xx.productid = x.productid 
					where xx.productname like '%" . $product . "%'  and x.slocid = f.slocid)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->companyid = $companyid;
    $this->pdf->title    = 'Rincian Surat Jalan Per Dokumen (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 8);
      $this->pdf->text(10, $this->pdf->gety() + 0, 'No ');
      $this->pdf->text(25, $this->pdf->gety() + 0, ': ' . $row['gino']);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Sales ');
      $this->pdf->text(25, $this->pdf->gety() + 5, ': ' . $row['sales']);
      $this->pdf->text(120, $this->pdf->gety() + 0, $row['areaname'] . ', ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])));
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No. SO ');
      $this->pdf->text(25, $this->pdf->gety() + 10, ': ' . $row['sono']);
      $this->pdf->text(120, $this->pdf->gety() + 5, 'Kepada Yth, ');
      $this->pdf->text(120, $this->pdf->gety() + 10, $row['customer']);
      $sql1        = "select c.productname, a.qty,d.uomcode,b.itemnote,e.headernote,c.productid
                        from gidetail a 
                        join sodetail b on b.sodetailid = a.sodetailid
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join giheader e on e.giheaderid = a.giheaderid
                        where a.giheaderid = " . $row['giheaderid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'L',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemnote']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row1['headernote'],
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //9
	public function RekapSuratJalanPerBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3) {
    parent::actionDownPDF();
    $sql        = "select distinct b.materialgroupid,b.materialgroupcode,b.description
                    from giheader zb
                    join soheader za on za.soheaderid = zb.soheaderid 
                    join gidetail zc on zc.giheaderid = zb.giheaderid
					join sloc zd on zd.slocid = zc.slocid
					join product ze on ze.productid = zc.productid
                    join addressbook zf on zf.addressbookid=za.addressbookid
					join salesarea zg on zg.salesareaid = zf.salesareaid
                    join employee zh on zh.employeeid = za.employeeid
                    join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
										join storagebin c on c.storagebinid = zc.storagebinid 
                    where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' and za.companyid = " . $companyid . " 
					and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' and
					zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                    and c.description like '%".$storagebin."%' ";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Surat Jalan Per Barang (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 3, ': ' . $row['description']);
      $sql1        = "select productname,uomcode, sum(qty) as qty from 
						(select a.productid,c.productname,a.qty, f.uomcode
						from gidetail a
						join giheader b on b.giheaderid = a.giheaderid
						join product c on c.productid = a.productid
						join sloc d on d.slocid = a.slocid
						join productplant e on e.productid = c.productid and e.slocid = a.slocid and e.unitofissue = a.unitofmeasureid
						join unitofmeasure f on f.unitofmeasureid = e.unitofissue
						join plant g on g.plantid = d.plantid
						join soheader i on i.soheaderid = b.soheaderid
						join addressbook j on j.addressbookid = i.addressbookid
						join employee k on k.employeeid = i.employeeid
						join salesarea l on l.salesareaid = j.salesareaid 
						join storagebin m on m.storagebinid = a.storagebinid 
						where e.materialgroupid = '" . $row['materialgroupid'] . "' and i.companyid = " . $companyid . " 
						and k.fullname like '%" . $sales . "%' and b.recordstatus = 3  and l.areaname like '%" . $salesarea . "%' 
						and m.description like '%".$storagebin."%' 
						and c.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and b.gidate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z group by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 7);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total -> ' . $row['description'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    $this->pdf->Output();
  }
  //10
	public function RekapSuratJalanPerCustomer($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct zf.addressbookid, zf.fullname
                    from giheader zb
                    join soheader za on za.soheaderid = zb.soheaderid 
                    join gidetail zc on zc.giheaderid = zb.giheaderid
										join sloc zd on zd.slocid = zc.slocid
										join product ze on ze.productid = zc.productid
                    join addressbook zf on zf.addressbookid=za.addressbookid
										join salesarea zg on zg.salesareaid = zf.salesareaid
										join employee zh on zh.employeeid = za.employeeid
                    join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' and za.companyid = " . $companyid . " 
										and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' 
										and zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
										order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Surat Jalan Per Customer';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Customer');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['fullname']);
      $sql1        = "select distinct b.materialgroupid,b.materialgroupcode,b.description
						from giheader zb
						join soheader za on za.soheaderid = zb.soheaderid 
						join gidetail zc on zc.giheaderid = zb.giheaderid
						join sloc zd on zd.slocid = zc.slocid
						join product ze on ze.productid = zc.productid
						join addressbook zf on zf.addressbookid=za.addressbookid
						join salesarea zg on zg.salesareaid = zf.salesareaid
						join employee zh on zh.employeeid = za.employeeid
						join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
						join materialgroup b on b.materialgroupid = a.materialgroupid
						where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' 
						and za.companyid = " . $companyid . " and zf.addressbookid = " . $row['addressbookid'] . "
						and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' and
						zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
        $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row1['description']);
        $sql2        = "select distinct a.productid,e.productname,f.uomcode,
                        (
                        select sum(zzb.qty)
                        from gidetail zzb 
                        join giheader zzc on zzc.giheaderid = zzb.giheaderid
                        where zzb.productid = a.productid
                        and zzb.slocid = a.slocid
                        and zzc.recordstatus = 3
                        ) as qty
                        from productplant a
                        join product e on e.productid = a.productid
                        join unitofmeasure f on f.unitofmeasureid = a.unitofissue
                        join sloc b on b.slocid = a.slocid
                        join plant c on c.plantid = b.plantid
                        join company d on d.companyid = c.companyid
                        where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and 
						a.materialgroupid = " . $row1['materialgroupid'] . " and a.productid in
                        (select za.productid
                        from gidetail za 
                        join giheader zb on zb.giheaderid = za.giheaderid
                        join soheader zc on zc.soheaderid = zb.soheaderid
                        join product zd on zd.productid = za.productid
                        where zc.addressbookid = " . $row['addressbookid'] . " and zd.productname like '%" . $product . "%' and
						zb.recordstatus = 3 and za.slocid = a.slocid and zc.companyid = " . $companyid . " and zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalqty    = 0;
        $i           = 0;
        $this->pdf->sety($this->pdf->gety() + 15);
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array(
          'C',
          'C',
          'C',
          'C'
        );
        $this->pdf->setwidths(array(
          10,
          120,
          30,
          30
        ));
        $this->pdf->colheader = array(
          'No',
          'Nama Barang',
          'Satuan',
          'Qty'
        );
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['qty'])
          ));
          $totalqty += $row2['qty'];
        }
        $this->pdf->row(array(
          '',
          'Total -> ' . $row1['description'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
        ));
        $this->pdf->checkPageBreak(20);
      }
    }
    $this->pdf->Output();
  }
  //11
	public function RincianReturJualPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct zd.gireturid,zd.gireturno,zg.fullname as customer,zh.fullname as sales,zd.gireturdate,zi.areaname,zb.gino 
                    from giretur zd
                    join giheader zb on zb.giheaderid = zd.giheaderid 
                    join gireturdetail ze on ze.gireturid = zd.gireturid
                    join soheader za on za.soheaderid = zb.soheaderid
                    join product zf on zf.productid = ze.productid
										join addressbook zg on zg.addressbookid = za.addressbookid
                    join employee zh on zh.employeeid = za.employeeid
                    join salesarea zi on zi.salesareaid = zg.salesareaid
                    join sloc zj on zj.slocid = ze.slocid
                    join productplant a on a.productid = ze.productid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zd.recordstatus = 3 and za.companyid = " . $companyid . " 
										and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
										and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Retur Jual Per Dokumen (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 0, 'No ');
      $this->pdf->text(25, $this->pdf->gety() + 0, ': ' . $row['gireturno']);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Sales ');
      $this->pdf->text(25, $this->pdf->gety() + 5, ': ' . $row['sales']);
      $this->pdf->text(140, $this->pdf->gety() + 0, $row['areaname'] . ', ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])));
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No. SJ ');
      $this->pdf->text(25, $this->pdf->gety() + 10, ': ' . $row['gino']);
      $this->pdf->text(140, $this->pdf->gety() + 5, 'Customer: ');
      $this->pdf->text(140, $this->pdf->gety() + 10, $row['customer']);
      $sql1        = "select distinct ze.productname,zk.uomcode,za.itemnote,zb.headernote,
                        (
                        select sum(zzb.qty)
                        from gireturdetail zzb 
                        join giretur zzc on zzc.gireturid = zzb.gireturid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3 and zzc.gireturid = zb.gireturid
                        ) as qty
                        from gireturdetail za 
                        join giretur zb on zb.gireturid = za.gireturid
                        join giheader zc on zc.giheaderid = zb.giheaderid
                        join soheader zd on zd.soheaderid = zc.soheaderid
                        join product ze on ze.productid = za.productid
												join addressbook zf on zf.addressbookid = zd.addressbookid
                        join employee zg on zg.employeeid = zd.employeeid
                        join salesarea zh on zh.salesareaid = zf.salesareaid
                        join productplant zi on zi.productid = za.productid
                        join sloc zj on zj.slocid = za.slocid
                        join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
                        where zb.recordstatus = 3 and zd.companyid = " . $companyid . " and za.gireturid = " . $row['gireturid'] . "
                        and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%'  
												and ze.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'   
												and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemnote']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //12
	public function RekapReturJualPerBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.materialgroupid,b.materialgroupcode,b.description  
                    from giretur zd
                    join giheader zb on zb.giheaderid = zd.giheaderid 
                    join gireturdetail ze on ze.gireturid = zd.gireturid
                    join soheader za on za.soheaderid = zb.soheaderid
                    join product zf on zf.productid = ze.productid
										join addressbook zg on zg.addressbookid = za.addressbookid
                    join employee zh on zh.employeeid = za.employeeid
                    join salesarea zi on zi.salesareaid = zg.salesareaid
                    join sloc zj on zj.slocid = ze.slocid
                    join productplant a on a.productid = ze.productid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zd.recordstatus = 3 and za.companyid = " . $companyid . " 
										and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
										and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Jual Per Barang (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 3, ': ' . $row['description']);
      $sql1        = "select distinct za.productid,ze.productname,zk.uomcode,
                        (
                        select sum(zzb.qty)
                        from gireturdetail zzb 
                        join giretur zzc on zzc.gireturid = zzb.gireturid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3 and zzc.gireturid = zb.gireturid
                        ) as qty
                        from gireturdetail za 
                        join giretur zb on zb.gireturid = za.gireturid
                        join giheader zc on zc.giheaderid = zb.giheaderid
                        join soheader zd on zd.soheaderid = zc.soheaderid
                        join product ze on ze.productid = za.productid
												join addressbook zf on zf.addressbookid = zd.addressbookid
                        join employee zg on zg.employeeid = zd.employeeid
                        join salesarea zh on zh.salesareaid = zf.salesareaid
                        join productplant zi on zi.productid = za.productid
                        join sloc zj on zj.slocid = za.slocid
                        join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
                        where zb.recordstatus = 3 and zd.companyid = " . $companyid . "
                        and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%' and zj.sloccode like '%" . $sloc . "%' 
												and ze.productname like '%" . $product . "%' and zi.materialgroupid = " . $row['materialgroupid'] . "  
												and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 7);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total -> ' . $row['description'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    $this->pdf->Output();
  }
  //13
	public function RekapReturJualPerCustomer($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct c.addressbookid,d.fullname 
                    from giretur a
                    join giheader b on b.giheaderid = a.giheaderid
                    join soheader c on c.soheaderid = b.soheaderid
                    join addressbook d on d.addressbookid = c.addressbookid
                    join gireturdetail e on e.gireturid = a.gireturid
										join sloc f on f.slocid = e.slocid
										join product g on g.productid = e.productid
                    join employee h on h.employeeid = c.employeeid
                    join salesarea i on i.salesareaid = d.salesareaid
                    where a.recordstatus = 3 and f.sloccode like '%" . $sloc . "%' and c.companyid = " . $companyid . " 
                    and h.fullname like '%" . $sales . "%' and i.areaname like '%" . $salesarea . "%' and g.productname like '%" . $product . "%' 
                    and a.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Penjualan Per Customer';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 10);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Customer');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['fullname']);
      $sql1        = "select distinct b.materialgroupid,b.materialgroupcode,b.description  
													from giretur zd
													join giheader zb on zb.giheaderid = zd.giheaderid 
													join gireturdetail ze on ze.gireturid = zd.gireturid
													join soheader za on za.soheaderid = zb.soheaderid
													join product zf on zf.productid = ze.productid
													join addressbook zg on zg.addressbookid = za.addressbookid
													join employee zh on zh.employeeid = za.employeeid
													join salesarea zi on zi.salesareaid = zg.salesareaid
													join sloc zj on zj.slocid = ze.slocid
													join productplant a on a.productid = ze.productid
													join materialgroup b on b.materialgroupid = a.materialgroupid
													where zd.recordstatus = 3 and za.companyid = " . $companyid . " and zg.addressbookid = " . $row['addressbookid'] . "
													and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
													and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
													and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
        $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row1['description']);
        $sql2        = "select distinct za.productid,ze.productname,zk.uomcode,
														(select sum(zzb.qty)
														from gireturdetail zzb 
														join giretur zzc on zzc.gireturid = zzb.gireturid
														where zzb.productid = za.productid
														and zzb.slocid = za.slocid
														and zzc.recordstatus = 3
														) as qty
														from gireturdetail za 
														join giretur zb on zb.gireturid = za.gireturid
														join giheader zc on zc.giheaderid = zb.giheaderid
														join soheader zd on zd.soheaderid = zc.soheaderid
														join product ze on ze.productid = za.productid
														join addressbook zf on zf.addressbookid = zd.addressbookid
														join employee zg on zg.employeeid = zd.employeeid
														join salesarea zh on zh.salesareaid = zf.salesareaid
														join productplant zi on zi.productid = za.productid
														join sloc zj on zj.slocid = za.slocid
														join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
														where zb.recordstatus = 3 and zd.companyid = " . $companyid . " and zf.addressbookid = " . $row['addressbookid'] . "
														and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%' and zj.sloccode like '%" . $sloc . "%' 
														and ze.productname like '%" . $product . "%' and zi.materialgroupid = " . $row1['materialgroupid'] . " 
														and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
														and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalqty    = 0;
        $i           = 0;
        $this->pdf->sety($this->pdf->gety() + 15);
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array(
          'C',
          'C',
          'C',
          'C'
        );
        $this->pdf->setwidths(array(
          10,
          120,
          30,
          30
        ));
        $this->pdf->colheader = array(
          'No',
          'Nama Barang',
          'Satuan',
          'Qty'
        );
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['qty'])
          ));
          $totalqty += $row2['qty'];
        }
        $this->pdf->row(array(
          '',
          'Total',
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
        ));
        $this->pdf->checkPageBreak(20);
      }
    }
    $this->pdf->Output();
  }
  //14
	public function RincianTerimaBarangPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.grheaderid,b.grno,c.fullname as supplier,b.grdate,a.pono
                    from grheader b 
                    join poheader a on a.poheaderid = b.poheaderid
                    join addressbook c on c.addressbookid=a.addressbookid
										join grdetail e on e.grheaderid = b.grheaderid
										join sloc f on f.slocid = e.slocid
                    join product g on g.productid = e.productid
                    where b.recordstatus = 3 and f.sloccode like '%" . $sloc . "%' and b.grno is not null 
                    and a.companyid = " . $companyid . " and g.productname like '%" . $product . "%'
                    and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Terima Barang Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(20, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['grno']);
      $this->pdf->text(20, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(40, $this->pdf->gety() + 15, ': ' . $row['supplier']);
      $this->pdf->text(130, $this->pdf->gety() + 10, 'Tanggal');
      $this->pdf->text(160, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(130, $this->pdf->gety() + 15, 'Nomor PO');
      $this->pdf->text(160, $this->pdf->gety() + 15, ': ' . $row['pono']);
      $sql1        = "select zd.productid,zd.productname,zf.uomcode,za.itemtext,zb.headernote,za.qty
                        from grdetail za
                        join grheader zb on zb.grheaderid = za.grheaderid
                        join poheader zc on zc.poheaderid = zb.poheaderid
                        join product zd on zd.productid = za.productid
                        join sloc ze on ze.slocid = za.slocid
                        join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
                        where zb.recordstatus = 3 and zd.productname like '%" . $product . "%'
                        and ze.sloccode like '%" . $sloc . "%' and za.grheaderid = " . $row['grheaderid'] . " ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'L',
        'R',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        ''
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ',
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //15
	public function RekapTerimaBarangPerBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct zg.materialgroupid,zg.materialgroupcode,zg.description 
                    from grdetail za
                    join grheader zb on zb.grheaderid = za.grheaderid
                    join poheader zc on zc.poheaderid = zb.poheaderid
                    join product zd on zd.productid = za.productid
                    join sloc ze on ze.slocid = za.slocid
                    join productplant zf on zf.productid = za.productid and zf.slocid = za.slocid
                    join materialgroup zg on zg.materialgroupid = zf.materialgroupid
                    where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
                    and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
                    and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Terima Barang Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 3, ': ' . $row['description']);
      $sql1        = "select distinct za.productid,zd.productname,zf.uomcode,
                        (
                        select sum(zzb.qty)
                        from grdetail zzb 
                        join grheader zzc on zzc.grheaderid = zzb.grheaderid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3
                        ) as qty
                        from grdetail za 
                        join grheader zb on zb.grheaderid = za.grheaderid
                        join poheader zc on zc.poheaderid = zb.poheaderid
                        join product zd on zd.productid = za.productid
                        join sloc ze on ze.slocid = za.slocid
                        join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
                        join productplant zg on zg.productid = za.productid 
                        where zb.recordstatus = 3 and zc.companyid = " . $companyid . " and zg.materialgroupid = '" . $row['materialgroupid'] . "'
                        and zd.productname like '%" . $product . "%' and ze.sloccode like '%" . $sloc . "%' 
                        and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 7);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total -> ' . $row['description'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    $this->pdf->Output();
  }
  //16
	public function RekapTerimaBarangPerSupplier($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct zf.addressbookid,zf.fullname as supplier 
                    from grdetail za
                    join grheader zb on zb.grheaderid = za.grheaderid
                    join poheader zc on zc.poheaderid = zb.poheaderid
                    join product zd on zd.productid = za.productid
                    join sloc ze on ze.slocid = za.slocid
                    join addressbook zf on zf.addressbookid = zc.addressbookid
                    where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
                    and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
                    and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Terima Barang Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 10);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['supplier']);
      $sql1        = "select distinct zg.materialgroupid,zg.materialgroupcode,zg.description,ze.sloccode 
															from grdetail za
															join grheader zb on zb.grheaderid = za.grheaderid
															join poheader zc on zc.poheaderid = zb.poheaderid
															join product zd on zd.productid = za.productid
															join sloc ze on ze.slocid = za.slocid
															join productplant zf on zf.productid = za.productid
															join materialgroup zg on zg.materialgroupid = zf.materialgroupid
															join addressbook zh on zh.addressbookid = zc.addressbookid
															where zb.recordstatus = 3 and zh.addressbookid = " . $row['addressbookid'] . "
															and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%' and zc.companyid = " . $companyid . "
															and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
															and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
        $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row1['description']);
        $sql2        = "select distinct za.productid,zd.productname,zf.uomcode,
																	(
																	select sum(zzb.qty)
																	from grdetail zzb 
																	join grheader zzc on zzc.grheaderid = zzb.grheaderid
																	where zzb.productid = za.productid
																	and zzb.slocid = za.slocid
																	and zzc.recordstatus = 3
																	) as qty
																	from grdetail za 
																	join grheader zb on zb.grheaderid = za.grheaderid
																	join poheader zc on zc.poheaderid = zb.poheaderid
																	join product zd on zd.productid = za.productid
																	join sloc ze on ze.slocid = za.slocid
																	join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
																	join productplant zg on zg.productid = za.productid 
																	join addressbook zh on zh.addressbookid = zc.addressbookid
																	where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
																	and zg.materialgroupid = " . $row1['materialgroupid'] . " and zh.addressbookid = " . $row['addressbookid'] . "
																	and zd.productname like '%" . $product . "%' and ze.sloccode like '%" . $sloc . "%' 
																	and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
																	and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalqty    = 0;
        $i           = 0;
        $this->pdf->sety($this->pdf->gety() + 15);
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array(
          'C',
          'C',
          'C',
          'C'
        );
        $this->pdf->setwidths(array(
          10,
          120,
          30,
          30
        ));
        $this->pdf->colheader = array(
          'No',
          'Nama Barang',
          'Satuan',
          'Qty'
        );
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['qty'])
          ));
          $totalqty += $row2['qty'];
        }
        $this->pdf->row(array(
          '',
          'Total -> ' . $row1['description'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
        ));
        $this->pdf->checkPageBreak(20);
      }
    }
    $this->pdf->Output();
  }
  //17
	public function RincianReturBeliPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select a.grreturid,a.grreturno,c.fullname as supplier,a.grreturdate,d.slocid
                    from grretur a
                    left join poheader b on b.poheaderid=a.poheaderid
                    left join addressbook c on c.addressbookid=b.addressbookid
                    left join grreturdetail d on d.grreturid = a.grreturid
										left join sloc e on e.slocid = d.slocid
                    where a.grreturno is not null and e.sloccode like '%" . $sloc . "%' and b.companyid = " . $companyid . " and 
                    a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.productid in
										(select x.productid from productplant x join product xx on xx.productid = x.productid 
										where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Retur Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(20, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['grreturno']);
      $this->pdf->text(20, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(40, $this->pdf->gety() + 15, ': ' . $row['supplier']);
      $this->pdf->text(130, $this->pdf->gety() + 10, 'Tanggal');
      $this->pdf->text(160, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
      $sql1        = "select d.productname,e.uomcode,a.qty,a.itemnote,f.headernote 
														from grreturdetail a
														inner join grdetail b on b.grdetailid=a.grdetailid
														inner join podetail c on c.podetailid=a.podetailid
														inner join product d on d.productid=a.productid
														inner join unitofmeasure e on e.unitofmeasureid=a.uomid
														inner join grretur f on f.grreturid=a.grreturid
														where a.slocid = '" . $row['slocid'] . "' and a.grreturid = " . $row['grreturid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'L',
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
          $row1['itemnote']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row1['headernote'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //18
	public function RekapReturBeliPerBarang($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.materialgroupid, a.materialgroupcode, a.description
                    from materialgroup a 
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join grreturdetail g on g.slocid = b.slocid
                    where f.companyid = " . $companyid . " and d.sloccode like '%" . $sloc . "%' and b.productid in
                    (select zd.productid 
                    from poheader za
                    join grheader zb on zb.poheaderid = za.poheaderid
                    join grdetail zc on zc.grheaderid = zb.grheaderid
                    join grreturdetail zd on zd.grdetailid = zc.grdetailid
                    join grretur zx on zx.grreturid = zd.grreturid
                    join product ze on ze.productid = zd.productid
                    where ze.productname like '%" . $product . "%' and za.companyid = " . $companyid . " and 
                    zx.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
    $command    = $this->connection->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1        = "select distinct b.productname,c.uomcode,a.qty,e.materialgroupid 
                        from grreturdetail a
                        join grretur f on f.grreturid = a.grreturid
                        inner join product b on b.productid=a.productid
                        inner join unitofmeasure c on c.unitofmeasureid=a.uomid
                        inner join productplant d on d.productid=a.productid
                        inner join materialgroup e on e.materialgroupid=d.materialgroupid
                        join poheader g on g.poheaderid = f.poheaderid
                        where e.materialgroupid = '" . $row['materialgroupid'] . "' 
                        and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                        and g.companyid = {$companyid} and f.recordstatus=3";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total -> ' . $row['description'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //19
	public function RekapReturBeliPerSupplier($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct c.addressbookid,c.fullname as supplier
                    from grretur a
                    join poheader b on b.poheaderid = a.poheaderid
                    join addressbook c on c.addressbookid = b.addressbookid
                    join grreturdetail d on d.grreturid = a.grreturid
										join sloc e on e.slocid = d.slocid
                    where a.recordstatus = 3 and e.sloccode like '%" . $sloc . "%' and b.companyid = " . $companyid . " and 
										b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.productid in
										(select x.productid from productplant x join product xx on xx.productid = x.productid 
										where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 10);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['supplier']);
      $sql1        = "select distinct a.materialgroupid,a.materialgroupcode,a.description 
                    from materialgroup a 
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join grreturdetail g on g.slocid = b.slocid
                    where f.companyid = " . $companyid . " and d.sloccode like '%" . $sloc . "%' and b.productid in
                    (select zc.productid 
                    from poheader za
                    join grretur zb on zb.poheaderid = za.poheaderid
                    join grreturdetail zc on zc.grreturid = zc.grreturid										
                    where za.companyid = " . $companyid . " and za.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
        $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row1['description']);
        $sql2        = "select distinct a.productid,e.productname,f.uomcode,
                        (
                        select sum(zzb.qty)
                        from grreturdetail zzb 
                        join grretur zzc on zzc.grreturid = zzb.grreturid
                        where zzb.productid = a.productid
                        and zzb.slocid = a.slocid
                        and zzc.recordstatus = 3
                        ) as qty
                        from productplant a
                        join product e on e.productid = a.productid
                        join unitofmeasure f on f.unitofmeasureid = a.unitofissue
                        join sloc b on b.slocid = a.slocid
                        join plant c on c.plantid = b.plantid
                        join company d on d.companyid = c.companyid
                        where d.companyid = " . $companyid . " and a.materialgroupid = " . $row1['materialgroupid'] . " and a.productid in
                        (select za.productid
                        from grreturdetail za 
                        join grretur zb on zb.grreturid = za.grreturid
                        join poheader zc on zc.poheaderid = zb.poheaderid
                        where zc.addressbookid = " . $row['addressbookid'] . " and zb.recordstatus = 3 and za.slocid = a.slocid and zc.companyid = " . $companyid . " and zc.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalqty    = 0;
        $i           = 0;
        $this->pdf->sety($this->pdf->gety() + 15);
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array(
          'C',
          'C',
          'C',
          'C'
        );
        $this->pdf->setwidths(array(
          10,
          120,
          30,
          30
        ));
        $this->pdf->colheader = array(
          'No',
          'Nama Barang',
          'Satuan',
          'Qty'
        );
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array(
          'L',
          'L',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', '', 8);
        foreach ($dataReader2 as $row2) {
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row2['qty'])
          ));
          $totalqty += $row2['qty'];
        }
        $this->pdf->row(array(
          '',
          'Total -> ' . $row1['description'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
        ));
        $this->pdf->checkPageBreak(20);
      }
    }
    $this->pdf->Output();
  }
  //20
	public function PendinganFpb($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.deliveryadviceid,a.dano,a.dadate as tanggal,b.description,b.sloccode,
					c.productplanno as spp,d.sono as so,e.productoutputno as op,a.headernote as note
					from deliveryadvice a
					left join sloc b on b.slocid = a.slocid
					left join productplan c on c.productplanid = a.productplanid 
					left join soheader d on d.soheaderid = a.soheaderid 
					left join productoutput e on e.productoutputid = a.productoutputid
					join deliveryadvicedetail f on f.deliveryadviceid = a.deliveryadviceid
                    left join sloc i on i.slocid = f.slocid
					join plant g on g.plantid = b.plantid
					join company h on h.companyid = g.companyid
					where a.recordstatus = 3 and h.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and i.sloccode like '%".$slocto."%' and
					a.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and 
					f.productid in 
					(
					select za.productid
					from deliveryadvicedetail za
					join product zb on zb.productid = za.productid
					where za.deliveryadviceid = a.deliveryadviceid and 
					zb.productname like '%" . $product . "%' and
					za.giqty < za.qty
					)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Pendingan FPB';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 2, 'No ');
      $this->pdf->text(30, $this->pdf->gety() + 2, ': ' . $row['dano']);
      $this->pdf->text(120, $this->pdf->gety() + 2, 'SPP ');
      $this->pdf->text(130, $this->pdf->gety() + 2, ': ' . $row['spp']);
      $this->pdf->text(120, $this->pdf->gety() + 6, 'SO ');
      $this->pdf->text(130, $this->pdf->gety() + 6, ': ' . $row['so']);
      $this->pdf->text(120, $this->pdf->gety() + 10, 'OP ');
      $this->pdf->text(130, $this->pdf->gety() + 10, ': ' . $row['op']);
      $this->pdf->text(10, $this->pdf->gety() + 6, 'Tgl ');
      $this->pdf->text(30, $this->pdf->gety() + 6, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
      $this->pdf->text(120, $this->pdf->gety() + 14, 'SLOC ');
      $this->pdf->text(130, $this->pdf->gety() + 14, ': ' . $row['sloccode'] . ' - ' . $row['description']);
      $sql1         = "select b.productname, a.qty,a.giqty,a.prqty,a.poqty,a.grqty,
						c.uomcode,a.itemtext,(a.qty-a.giqty) as selisih
                        from deliveryadvicedetail a 
                        join product b on b.productid = a.productid
                        join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
                        where b.productname like '%" . $product . "%' and a.deliveryadviceid = " . $row['deliveryadviceid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i            = 0;
      $totalqty     = 0;
      $totaltrf     = 0;
      $totalpr      = 0;
      $totalpo      = 0;
      $totalgr      = 0;
      $totalselisih = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        50,
        20,
        20,
        20,
        20,
        20,
        20,
        15
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Trf Qty',
        'Pr Qty',
        'Po Qty',
        'Gr Qty',
        'Selisih',
        'Note'
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
        'R',
        'C'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['giqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['prqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['grqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['selisih']),
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
        $totaltrf += $row1['giqty'];
        $totalpr += $row1['prqty'];
        $totalpo += $row1['poqty'];
        $totalgr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totaltrf),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalpr),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalpo),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgr),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalselisih)
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row['note'],
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //21
	public function PendinganFpp($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct f.description,h.companyid,a.prno,a.prdate,a.headernote as note,a.prheaderid,a.headernote,b.dano
											from prheader a
											inner join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
											inner join prmaterial c on c.prheaderid = a.prheaderid
											inner join sloc f on f.slocid = b.slocid
											inner join product g on g.productid = c.productid
											inner join plant h on h.plantid = f.plantid
											where a.recordstatus = 3 and c.poqty < c.qty and h.companyid = " . $companyid . " 
											and f.sloccode like '%" . $sloc . "%' and g.productname like '%" . $product . "%'
											and a.prdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
											and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Pendingan FPP';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 2, 'No ');
      $this->pdf->text(30, $this->pdf->gety() + 2, ': ' . $row['prno']);
      $this->pdf->text(10, $this->pdf->gety() + 6, 'Tgl ');
      $this->pdf->text(30, $this->pdf->gety() + 6, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['prdate'])));
      $this->pdf->text(120, $this->pdf->gety() + 2, 'Gudang ');
      $this->pdf->text(140, $this->pdf->gety() + 2, ': ' . $row['description']);
      $this->pdf->text(120, $this->pdf->gety() + 6, 'No FPB ');
      $this->pdf->text(140, $this->pdf->gety() + 6, ': ' . $row['dano']);
      $sql1         = "select d.productname, a.qty,a.poqty,a.grqty,
										(select sum(xx.qty) from deliveryadvicedetail xx
										where xx.deliveryadvicedetailid = a.deliveryadvicedetailid and xx.productid = a.productid) as daqty,
										e.uomcode,a.itemtext,(a.qty-a.poqty) as selisih
                    from prmaterial a
                    join prheader b on b.prheaderid = a.prheaderid
                    join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
                    join product d on d.productid = a.productid
                    join unitofmeasure e on e.unitofmeasureid = a.unitofmeasureid
                    join sloc f on f.slocid = c.slocid
                    where d.productname like '%" . $product . "%' and a.prheaderid = " . $row['prheaderid'] . "
                    and f.sloccode like '%" . $sloc . "%' and a.poqty < a.qty
                    and b.prdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i            = 0;
      $totalqty     = 0;
      $totaltrf     = 0;
      $totalda      = 0;
      $totalpo      = 0;
      $totalgr      = 0;
      $totalselisih = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
      $this->pdf->setFont('Arial', 'B', 8);
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
        50,
        20,
        20,
        20,
        20,
        20,
        15
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Fr Qty',
        'Po Qty',
        'Gr Qty',
        'Selisih',
        'Note'
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
        'C'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['daqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['grqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['selisih']),
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
        $totalda += $row1['daqty'];
        $totalpo += $row1['poqty'];
        $totalgr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalda),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalpo),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgr),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalselisih)
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row['note'],
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //22
	public function RincianTransferGudangKeluarPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.transstockid,b.transstockno,					
					(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = b.slocfromid) as fromsloc,
					(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = b.sloctoid) as tosloc,
					b.docdate,a.dano
                    from deliveryadvice a
                    join transstock b on b.deliveryadviceid=a.deliveryadviceid
                    join sloc c on c.slocid = b.slocfromid
                    join plant d on d.plantid = c.plantid
                    join transstockdet e on e.transstockid = b.transstockid
					where b.transstockno is not null and d.companyid = " . $companyid . " and b.recordstatus > (3-1) and 
					c.sloccode like '%" . $sloc . "%' and
					b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					and e.productid in (select x.productid 
					from productplant x join product xx on xx.productid = x.productid 
					where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Transfer Gudang Keluar Per Dokumen (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'No. TS ');
      $this->pdf->text(25, $this->pdf->gety() + 5, ': ' . $row['transstockno']);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No. FPB ');
      $this->pdf->text(25, $this->pdf->gety() + 10, ': ' . $row['dano']);
      $this->pdf->text(90, $this->pdf->gety() + 5, 'Gudang Asal ');
      $this->pdf->text(120, $this->pdf->gety() + 5, ': ' . $row['fromsloc']);
      $this->pdf->text(90, $this->pdf->gety() + 10, 'Gudang Tujuan ');
      $this->pdf->text(120, $this->pdf->gety() + 10, ': ' . $row['tosloc']);
      $sql1        = "select c.productname, a.qty,d.uomcode,a.itemtext,e.headernote
                        from transstockdet a 
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join transstock e on e.transstockid=a.transstockid
                        where c.productname like '%" . $product . "%' and a.transstockid = " . $row['transstockid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        70
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row1['headernote'],
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //23
	public function RekapTransferGudangKeluarPerBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.sloctoid,a.slocfromid,
					(select sloccode from sloc d where d.slocid = a.slocfromid) as fromsloccode,
					(select description from sloc d where d.slocid = a.slocfromid) as fromslocdesc,
					(select sloccode from sloc d where d.slocid = a.sloctoid) as tosloccode,	
					(select description from sloc d where d.slocid = a.sloctoid) as toslocdesc
					from transstock a
					join transstockdet b on b.transstockid = a.transstockid
					join product c on c.productid = b.productid
					join sloc e on e.slocid = a.slocfromid
					where a.recordstatus > (3-1) and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%'
					and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Transfer Gudang Keluar Per Barang (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Asal');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tujuan');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from transstockdet a
						join product b on b.productid = a.productid
						join transstock c on c.transstockid = a.transstockid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join sloc e on e.slocid = c.slocfromid
						where c.recordstatus > (3-1) and c.slocfromid = " . $row['slocfromid'] . " and e.sloccode like '%" . $sloc . "%' 
						and c.sloctoid = " . $row['sloctoid'] . " and b.productname like '%" . $product . "%' 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' group by productid,productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'TOTAL',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    $this->pdf->Output();
  }
  //24
	public function RincianTransferGudangMasukPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.transstockid,b.transstockno,					
											(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = b.slocfromid) as fromsloc,
											(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = b.sloctoid) as tosloc,
											b.docdate,a.dano
											from deliveryadvice a
											join transstock b on b.deliveryadviceid=a.deliveryadviceid
											join sloc c on c.slocid = b.sloctoid
											join plant d on d.plantid = c.plantid
											join transstockdet e on e.transstockid = b.transstockid
											where b.transstockno is not null and d.companyid = " . $companyid . " and b.recordstatus = 5 and 
											c.sloccode like '%" . $sloc . "%' and
											b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
											and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
											and e.productid in (select x.productid 
											from productplant x join product xx on xx.productid = x.productid 
											where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Transfer Gudang Masuk Per Dokumen (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'No. TS ');
      $this->pdf->text(25, $this->pdf->gety() + 5, ': ' . $row['transstockno']);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No. FPB ');
      $this->pdf->text(25, $this->pdf->gety() + 10, ': ' . $row['dano']);
      $this->pdf->text(100, $this->pdf->gety() + 5, 'Gudang Asal ');
      $this->pdf->text(130, $this->pdf->gety() + 5, ': ' . $row['fromsloc']);
      $this->pdf->text(100, $this->pdf->gety() + 10, 'Gudang Tujuan ');
      $this->pdf->text(130, $this->pdf->gety() + 10, ': ' . $row['tosloc']);
      $sql1        = "select c.productname, a.qty,d.uomcode,a.itemtext,e.headernote
                        from transstockdet a 
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join transstock e on e.transstockid=a.transstockid
                        where c.productname like '%" . $product . "%' and a.transstockid = " . $row['transstockid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        70
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row1['headernote'],
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //25
	public function RekapTransferGudangMasukPerBarang($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.sloctoid,a.slocfromid,
					(select sloccode from sloc d where d.slocid = a.slocfromid) as fromsloccode,
					(select description from sloc d where d.slocid = a.slocfromid) as fromslocdesc,
					(select sloccode from sloc d where d.slocid = a.sloctoid) as tosloccode,	
					(select description from sloc d where d.slocid = a.sloctoid) as toslocdesc
					from transstock a
					join transstockdet b on b.transstockid = a.transstockid
					join product c on c.productid = b.productid
					join sloc e on e.slocid = a.sloctoid
					where a.recordstatus = 5 and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
					and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Transfer Gudang Masuk Per Barang (Qty)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Asal');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tujuan');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      $sql1        = "select a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from transstockdet a
						join product b on b.productid = a.productid
						join transstock c on c.transstockid = a.transstockid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join sloc e on e.slocid = c.sloctoid
						where c.recordstatus = 5 and c.slocfromid = " . $row['slocfromid'] . " and e.sloccode like '%" . $sloc . "%' 
						and c.sloctoid = " . $row['sloctoid'] . " and b.productname like '%" . $product . "%' 
						and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						group by productid,productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 20);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        120,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'TOTAL ',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    $this->pdf->Output();
  }
  //26
	public function RekapStokBarangAdaTransaksi($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang - Ada Transaksi Keluar Masuk';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct aa.productname 
                            from productstockdet a
                            join product aa on aa.productid = a.productid
                            join sloc ab on ab.slocid = a.slocid
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            ) as barang,
                            (
                            select distinct bb.uomcode 
                            from productstockdet b
                            join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
                            join sloc ba on ba.slocid = b.slocid
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            join sloc aaw on aaw.slocid = aw.slocid
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            join sloc cc on cc.slocid = c.slocid
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            join sloc dd on dd.slocid = d.slocid
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            join sloc ee on ee.slocid = e.slocid
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            join sloc ff on ff.slocid = f.slocid
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            join sloc gg on gg.slocid = g.slocid
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            join sloc hh on hh.slocid = h.slocid
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            join sloc ii on ii.slocid = i.slocid
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            join sloc jj on jj.slocid = j.slocid
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            join sloc kk on kk.slocid = k.slocid
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            join sloc ll on ll.slocid = l.slocid
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            join sloc mm on mm.slocid = m.slocid
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . " order by barang') z) zz )zzz where masuk <> 0 or keluar <> 0 
							order by barang asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
    $this->pdf->Output();
  }
  //27
	public function RekapSTTBPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.grheaderid,a.grno,a.grdate,b.pono,b.headernote,a.recordstatus
						from grheader a
						join poheader b on b.poheaderid = a.poheaderid
						join podetail c on c.poheaderid = b.poheaderid
						join product d on d.productid = c.productid
						join sloc e on e.slocid = c.slocid
						where a.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						and a.recordstatus between 1 and (3-1)
						and a.grheaderid is not null and d.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%' and
						b.companyid =  " . $companyid . "
						order by a.grdate,a.recordstatus,a.grno
						";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap STTB Per Dokumen Status Belum Max';
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
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      25,
      25,
      50,
      40,
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
      'C',
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
        $row['grheaderid'],
        $row['grno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])),
        $row['pono'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appgr", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //28
	public function RekapReturBeliPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.grreturid,a.grreturno,a.grreturdate,b.pono,b.headernote,a.recordstatus
							from grretur a
							join poheader b on b.poheaderid = a.poheaderid
							join grreturdetail c on c.grreturid = a.grreturid
							join product d on d.productid = c.productid
							join poheader e on e.poheaderid = a.poheaderid
							join sloc f on f.slocid = c.slocid
							where a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							and a.recordstatus between 1 and (3-1) and a.grreturid is not null
							and e.companyid = " . $companyid . " and d.productname like '%" . $product . "%' and f.sloccode like '%" . $sloc . "%'
							order by a.grreturdate,b.recordstatus,a.grreturno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap Retur Pembelian Per Dokumen Status Belum Max';
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
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      25,
      25,
      50,
      40,
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
      'C',
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
        $row['grreturid'],
        $row['grreturno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])),
        $row['pono'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appgrretur", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //29
	public function RekapSuratJalanPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.giheaderid,a.gino,a.gidate,b.sono,a.headernote,a.recordstatus
								from giheader a
								join soheader b on b.soheaderid = a.soheaderid
								join sodetail c on c.soheaderid = b.soheaderid
								join product d on d.productid = c.productid
								join sloc e on e.slocid = c.slocid
								where a.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								and a.recordstatus between 1 and (3-1) 
								and b.companyid = " . $companyid . " and d.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%'
								order by a.gidate,a.recordstatus,a.gino";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap Surat Jalan Per Dokumen Status Belum Max';
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
        $row['giheaderid'],
        $row['gino'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])),
        $row['sono'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appgi", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //30
	public function RekapReturPenjualanPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.gireturid,a.gireturno,a.gireturdate,b.gino,a.headernote,a.recordstatus
					 from giretur a 
					 join giheader b on b.giheaderid = a.giheaderid
					 join gidetail c on c.giheaderid = a.giheaderid
					 join product d on d.productid = c.productid
					 join sloc e on e.slocid = c.slocid
					 join plant f on f.plantid=e.plantid
					 where a.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					 and a.recordstatus between 1 and (3-1)
					 and d.productname like '%%" . $product . "%%'
					 and e.sloccode like '%%" . $sloc . "%%'
					 and f.companyid = " . $companyid . "
					 order by a.gireturdate,a.recordstatus,a.gireturno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap Retur Penjualan Per Dokumen Status Belum Max';
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
        $row['gireturid'],
        $row['gireturno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])),
        $row['gino'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appgiretur", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //31
	public function RekapTransferPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.transstockid,a.transstockno,a.docdate,ifnull((select b.dano from deliveryadvice b where b.deliveryadviceid=a.deliveryadviceid),(select b.productoutputno from productoutput b where b.productoutputid=a.productoutputid)) as dano,a.headernote,a.recordstatus,
								e.sloccode as slocfrom,f.sloccode as slocto
							from transstock a
							join transstockdet c on c.transstockid = a.transstockid
							join product d on d.productid = c.productid
							join sloc e on e.slocid = a.slocfromid							
							join sloc f on f.slocid = a.sloctoid
							join plant g on g.plantid = e.plantid
							where g.companyid = " . $companyid . "
							and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							and a.recordstatus between 1 and (5-1)
							and d.productname like '%" . $product . "%'
							and (e.sloccode like '%" . $sloc . "%' or f.sloccode like '%" . $sloc . "%')
							order by a.docdate,a.recordstatus,a.transstockno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap Transfer Per Dokumen Status Belum Max';
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
      'C',
      'C',
      'C'
    );
    $this->pdf->setwidths(array(
      10,
      15,
      20,
      18,
      20,
      20,
      20,
      35,
      38
    ));
    $this->pdf->colheader = array(
      'No',
      'ID',
      'No Transaksi',
      'Tanggal',
      'No Referensi',
      'Asal',
      'Tujuan',
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
        $row['transstockid'],
        $row['transstockno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        $row['dano'],
        $row['slocfrom'],
        $row['slocto'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appts", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //32
	public function RekapStockOpnamePerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.bsheaderid,a.bsdate,a.bsheaderno,d.sloccode,a.headernote,a.recordstatus
								from bsheader a
								join bsdetail b on b.bsheaderid = a.bsheaderid
								join product c on c.productid = b.productid
								join sloc d on d.slocid = a.slocid
								join plant e on e.plantid = d.plantid
								where a.bsdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								and a.recordstatus between 1 and (5-1)
								and c.productname like '%" . $product . "%'
								and d.sloccode like '%" . $sloc . "%'
								and e.companyid = " . $companyid . "
								order by a.recordstatus";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    $this->pdf->companyid = $companyid;
    
    $this->pdf->title    = 'Rekap Stock Opname Per Dokumen Status Belum Max';
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
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      20,
      25,
      20,
      20,
      22,
      50,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'ID Transaksi',
      'No Transaksi',
      'Tanggal',
      'No Referensi',
      'Gudang',
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
        $row['bsheaderid'],
        $row['bsheaderno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['bsdate'])),
        '-',
        $row['sloccode'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("appbs", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //33
	public function RekapkonversiPerDokumentBelumStatusMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.productconvertid,a.qty,a.recordstatus,d.productname,e.uomcode,f.sloccode,Getwfstatusbywfname('appconvert',a.recordstatus) as statusname
								from productconvert a
								join productconvertdetail b on b.productconvertid = a.productconvertid
								join productconversion c on c.productconversionid = a.productconversionid
								join product d on c.productid = d.productid
								join unitofmeasure e on e.unitofmeasureid = a.uomid
								join sloc f on f.slocid = a.slocid
								join plant g on g.plantid = f.plantid
								where  a.recordstatus between 1 and (3-1)
								and g.companyid = ".$companyid."
								and d.productname like '%" . $product . "%'
								and f.sloccode like '%" . $sloc . "%'
								and date(a.createddate) between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								order by a.recordstatus";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Opname Per Dokumen Status Belum Max';
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
        $row['bsheaderid'],
        $row['bsheaderno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['bsdate'])),
        '-',
        $row['headernote'],
        Wfstatus::model()->findstatusname("apppayreq", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //34
	public function RawMaterialGudangAsalBelumAdaDataGudangFPB($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select a.deliveryadviceid,a.reqdate,b.dano,e.sloccode
				from deliveryadvicedetail a
				join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
				join product c on c.productid = a.productid
				join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
				join sloc e on e.slocid = b.slocid
				join plant f on f.plantid = e.plantid
				where b.slocid not in (select x.slocid
				from productplant x where x.productid = a.productid) 
				and b.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
				and b.recordstatus > 0 and getcompanyfromsloc(b.slocid) = " . $companyid . "
				and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%'
				and f.companyid = " . $companyid . "
				order by a.deliveryadviceid";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Raw Material Gudang Asal Belum Ada di Data Gudang FPB';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 2, 'No  ');
      $this->pdf->text(25, $this->pdf->gety() + 2, ': ' . $row['dano']);
      $this->pdf->text(65, $this->pdf->gety() + 2, 'ID  ');
      $this->pdf->text(70, $this->pdf->gety() + 2, ': ' . $row['deliveryadviceid']);
      $this->pdf->text(95, $this->pdf->gety() + 2, 'Gudang  ');
      $this->pdf->text(110, $this->pdf->gety() + 2, ': ' . $row['sloccode']);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'Tanggal  ');
      $this->pdf->text(25, $this->pdf->gety() + 7, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['reqdate'])));
      $sql1 = "select a.deliveryadviceid,c.productname,a.qty,d.uomcode,a.itemtext
					from deliveryadvicedetail a
					join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
					join product c on c.productid = a.productid
					join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
					join sloc e on e.slocid = b.slocid
					where b.slocid not in (
					select x.slocid
					from productplant x where x.productid = a.productid 
					) and b.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
					and b.recordstatus > 0 and  a.deliveryadviceid = " . $row['deliveryadviceid'];
      "
					order by a.deliveryadviceid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang/Service',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'L',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //35
	public function RawMaterialGudangTujuanBelumAdaDataGudangFPB($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.deliveryadviceid,a.reqdate,b.dano,e.sloccode
				from deliveryadvicedetail a
				join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
				join product c on c.productid = a.productid
				join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
				join sloc e on e.slocid = a.slocid
				join plant f on f.plantid = e.plantid
				where a.slocid not in (select x.slocid
				from productplant x where x.productid = a.productid) 
				and b.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
				and b.recordstatus > 0 and getcompanyfromsloc(b.slocid) = " . $companyid . "
				and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%'
				and f.companyid = " . $companyid . "
				order by a.deliveryadviceid";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Raw Material Gudang Tujuan Belum Ada di Data Gudang FPB';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 2);
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 2, 'No  ');
      $this->pdf->text(25, $this->pdf->gety() + 2, ': ' . $row['dano']);
      $this->pdf->text(65, $this->pdf->gety() + 2, 'ID  ');
      $this->pdf->text(70, $this->pdf->gety() + 2, ': ' . $row['deliveryadviceid']);
      $this->pdf->text(95, $this->pdf->gety() + 2, 'Gudang  ');
      $this->pdf->text(110, $this->pdf->gety() + 2, ': ' . $row['sloccode']);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'Tanggal  ');
      $this->pdf->text(25, $this->pdf->gety() + 7, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['reqdate'])));
      $sql1 = "select a.deliveryadviceid,c.productname,a.qty,d.uomcode,a.itemtext
					from deliveryadvicedetail a
					join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
					join product c on c.productid = a.productid
					join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
					join sloc e on e.slocid = a.slocid
					where a.slocid not in (
					select x.slocid
					from productplant x where x.productid = a.productid 
					) and b.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
					and b.recordstatus > 0 and  a.deliveryadviceid = " . $row['deliveryadviceid'];
      "
					order by a.deliveryadviceid";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        75,
        20,
        20,
        60
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang/Service',
        'Qty',
        'Satuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'L',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->Output();
  }
  //36
	public function RekapFPBBelumTransferPerDokumen($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.transstockid,a.transstockno,a.docdate,b.dano,a.headernote,a.recordstatus
							from transstock a
							join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
							join deliveryadvicedetail c on c.deliveryadviceid = b.deliveryadviceid
							join product d on d.productid = c.productid
							join sloc e on e.slocid = c.slocid
							join plant f on f.plantid = e.plantid
							join company g on g.companyid = f.companyid
							where a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							and a.recordstatus between 1 and (5-1)
							and b.dano is not null
							and d.productname like '%" . $product . "%'
							and e.sloccode like '%" . $sloc . "%'
							and g.companyid = ".$companyid."
							order by a.recordstatus";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap FPB Belum Ada Transfer Per Dokumen ';
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
        $row['transstockid'],
        $row['transstockno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        $row['dano'],
        $row['headernote'],
        Wfstatus::model()->findstatusname("apppayreq", $row['recordstatus'])
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //37
	public function RAWMaterialBelumAdaGudangStockOpname($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql        = "select distinct c.productname, b.qty, e.uomcode,a.bsdate,d.sloccode,a.headernote
						from bsheader a
						join bsdetail b on b.bsheaderid = a.bsheaderid
						join product c on c.productid = b.productid
						join sloc d on d.slocid = a.slocid
						join unitofmeasure e on e.unitofmeasureid = b.unitofmeasureid
						where a.recordstatus > 0 and a.bsdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'  and
						c.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and
						a.slocid not in (select x.slocid from productplant x where x.productid = b.productid)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Raw Material Belum Ada di Data Gudang - Stock Opname';
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
      55,
      20,
      25,
      20,
      25,
      40
    ));
    $this->pdf->colheader = array(
      'No',
      'ID Transaksi',
      'QTY',
      'Tanggal',
      'Satuan',
      'Gudang',
      'Keterangan'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'L',
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
        $row['productname'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['qty']),
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['bsdate'])),
        $row['uomcode'],
        $row['sloccode'],
        $row['headernote']
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //38
	public function LaporanFPBStatusBelumMax($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql = "SELECT 
            IF(jenis='SPP',(SELECT productplanid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),
            IF(jenis='OP',(SELECT productoutputid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),
            IF(jenis='SO',(SELECT soheaderid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),''))) as id_jenis, deliveryadviceid, jenis, dadate, dano, statusname, username, headernote
            FROM (SELECT IF((productplanid is not null) or (productplanid<>''),'SPP',IF((productoutputid is not null) or (productoutputid<>''),'OP',IF((soheaderid is not null) or (soheaderid<>''),'SO','UMUM'))) as jenis, deliveryadviceid, b.username, y.dadate, y.dano, y.statusname, y.recordstatus, y.headernote, y.slocid
                FROM deliveryadvice y
                JOIN useraccess b ON b.useraccessid = y.useraccessid) zz
                WHERE zz.recordstatus<3 
								AND zz.recordstatus <> 0
                AND slocid IN (
                SELECT xa.slocid
                FROM sloc xa
                JOIN plant xb ON xb.plantid = xa.plantid
                JOIN company xc ON xc.companyid = xb.companyid
                WHERE xc.companyid = ".$companyid." AND xa.slocid = zz.slocid)
            AND zz.dadate BETWEEN ('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') AND ('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
            ORDER BY deliveryadviceid DESC";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan FPB Status Belum Max';
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
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      15,
      25,
      20,
      25,
      15,
      45,
      30
    ));
    $this->pdf->colheader = array(
      'No',
      'ID FPB',
      'No FPB',
      'Tanggal',
      'User',
      'Jenis ',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L'
    );
      $i=0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->row(array(
        $i,
        $row['deliveryadviceid'],
        $row['dano'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])),
        $row['username'],
        $row['jenis'],
        $row['headernote'],
        $row['statusname']
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
	/*public function LaporanFPBStatusBelumMax($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $sql = "SELECT 
            IF(jenis='SPP',(SELECT productplanid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),
            IF(jenis='OP',(SELECT productoutputid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),
            IF(jenis='SO',(SELECT soheaderid FROM deliveryadvice a WHERE a.deliveryadviceid = zz.deliveryadviceid),''))) as id_jenis, deliveryadviceid, jenis, dadate, dano, statusname, username, headernote
            FROM (SELECT IF((productplanid is not null) or (productplanid<>''),'SPP',IF((productoutputid is not null) or (productoutputid<>''),'OP',IF((soheaderid is not null) or (soheaderid<>''),'SO',''))) as jenis, deliveryadviceid, b.username, y.dadate, y.dano, y.statusname, y.recordstatus, y.headernote, y.slocid
                FROM deliveryadvice y
                JOIN useraccess b ON b.useraccessid = y.useraccessid) zz
                WHERE zz.recordstatus<3 
								AND zz.recordstatus <> 0
                AND slocid IN (
                SELECT xa.slocid
                FROM sloc xa
                JOIN plant xb ON xb.plantid = xa.plantid
                JOIN company xc ON xc.companyid = xb.companyid
                WHERE xc.companyid = ".$companyid." AND xa.slocid = zz.slocid)
            AND zz.dadate BETWEEN ('" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') AND ('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
            ORDER BY deliveryadviceid DESC";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan FPB Status Belum Max';
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
      'L',
      'L'
    );
    $this->pdf->setwidths(array(
      10,
      25,
      25,
      25,
      15,
      30,
      35,
      30
    ));
    $this->pdf->colheader = array(
      'No',
      'No FPB',
      'Tanggal Request',
      'User Request',
      'Jenis ',
      'ID Jenis',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'L',
      'L',
      'L',
      'C',
      'L',
      'L',
      'L'
    );
      $i=0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 10);
      $this->pdf->row(array(
        $i,
        $row['dano'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])),
        $row['username'],
        $row['jenis'],
        $row['id_jenis'],
        $row['headernote'],
        $row['statusname']
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }*/
  //39
	public function LaporanKetersediaanBarang($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    parent::actionDownload();
    $sql        = "select *
                    from (SELECT b.productname, b.sloccode, b.uomcode,a.minstock,a.maxvalue,SUM(b.qty) as qty,SUM(b.qty)-a.minstock as tomin,SUM(b.qty)-a.maxvalue as tomax
                    FROM mrp a
                    LEFT JOIN productstock b ON b.productid = a.productid AND b.unitofmeasureid = a.uomid AND a.slocid = b.slocid 
                    LEFT JOIN product c on c.productid = a.productid
                    LEFT JOIN sloc d on d.slocid = a.slocid
                    LEFT JOIN plant e on e.plantid = d.plantid
                      WHERE a.recordstatus = 1 and e.companyid = ".$companyid."
                      AND b.sloccode like '%".$sloc."%'
                      AND b.productname like '%".$product ."%'
                    GROUP By  b.productid) z
                    order by sloccode,tomin
                     -- HAVING qty <= a.reordervalue
    ";
      
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title= 'Laporan Ketersediaan Barang';
    $this->pdf->subtitle = 'Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    //$this->pdf->sety($this->pdf->gety() + 10);
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
      80,
      20,
      12,
      15,
      15,
      15,
      15,
      15
    ));
    $this->pdf->colheader = array(
      'No',
      'Nama Barang',
      'Gudang',
      'Satuan',
      'Min',
      'Max',
      'Stock',
      'To Min',
      'To Max'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'C',
      'L',
      'C',
      'C',
      'R',
      'R',
      'R',
      'R',
      'R'
    );
      $i                         = 0;
    foreach ($dataReader as $row) {
    
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['productname'],
        $row['sloccode'],
        $row['uomcode'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['minstock']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['maxvalue']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['qty']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['tomin']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['tomax'])
        
        
      ));
        $this->pdf->SetAutoPageBreak(FALSE);
        
        if($this->pdf->getY()+20 >= $this->pdf->PageBreakTrigger)
        {
            
            $this->pdf->AddPage('P');
            $this->pdf->setFont('Arial', 'B', 8);
            //$this->pdf->sety($this->pdf->gety() + 10);
            $this->pdf->colheader = array(
              'No',
              'Nama Barang',
              'Gudang',
              'Satuan',
              'Min',
              'Max',
              'Stock',
              'To Min',
              'To Max'
            );
            $this->pdf->RowHeader();
        }
    }
    
    $this->pdf->Output();
  }
  //40
	public function LaporanMaterialNotMoving($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Material Not Moving';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . " ') z) zz) zzz 
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 =0 order by keluar2 asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
    $this->pdf->Output();
  }
  //41
	public function LaporanMaterialSlowMoving($companyid, $sloc, $slocto,$storagebin, $sales, $product, $salesarea, $startdate, $enddate,$keluar3)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Material Slow Moving';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
      
    
    if($keluar3==0){
        $this->pdf->SetFont('helvetica','B',20);
        $this->pdf->text(70, 50, 'Anda Belum Mengisi');
        $this->pdf->text(90, 60, 'QTY Keluar,');
        $this->pdf->text(50, 70, 'Silahkan Isi Dahulu QTY Keluar');
    }else{  
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        
        $this->pdf->sety($this->pdf->gety() + 8);
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "') z) zz )zzz 
							where barang like '%" . $product . "%' and (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 > - " . $keluar3 . "  order by keluar2 asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    )); }
    $this->pdf->Output();
  }
  //42
	public function LaporanMaterialFastMoving($companyid, $sloc, $slocto,$storagebin, $sales, $product, $salesarea, $startdate, $enddate,$keluar3)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Material Fast Moving';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
     if($keluar3==0){
        $this->pdf->SetFont('helvetica','B',20);
        $this->pdf->text(70, 50, 'Anda Belum Mengisi');
        $this->pdf->text(90, 60, 'QTY Keluar,');
        $this->pdf->text(50, 70, 'Silahkan Isi Dahulu QTY Keluar');
    }else{    
    $this->pdf->sety($this->pdf->gety() + 5);
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
      80,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Satuan',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $this->pdf->sety($this->pdf->gety() + 8);
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "') z) zz )zzz 
							where barang like '%" . $product . "%' and (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 < - " . $keluar3 . "  order by keluar2 asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
          }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
     }
    $this->pdf->Output();
  }    
  //43
	public function LaporanHarian1($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate,$per)
	{
			parent::actionDownPDF();
			
			/* 
			Begin
			Left Section 
			*/
			$this->pdf->title    = 'Laporan Harian';
			$this->pdf->subtitle = 'Per Tgl :' .date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			$this->pdf->text(10,20,'1. PRODUKSI VS PENJUALAN');
			
			$month = date('m',strtotime($startdate));
			$year = date('Y',strtotime($startdate));
			$x = 10;
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Kangaroo Premium (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- Matras'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- Divan'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Sandaran');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Bed Sorong');
			$this->pdf->setY($this->pdf->getY()+25);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Kangaroo Regular (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- Matras'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- Divan'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Sandaran');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Bed Sorong');
			$this->pdf->setY($this->pdf->getY()+25);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Kangaroo Non Regular (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- Matras'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- Divan'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Sandaran');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Bed Sorong');
			$this->pdf->setY($this->pdf->getY()+25);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Kasur Busa (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+20,'Balokan (hari/kumulatif)');
			$this->pdf->setY($this->pdf->getY()+20);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'WIP Rangka (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- Matras'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- Bed Sorong Induk'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Sandaran Anak');
			$this->pdf->setY($this->pdf->getY()+21);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'WIP Kain (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- Matras'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- Divan'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Sandaran');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Bed Sorong');
			$this->pdf->text($x,$this->pdf->getY()+29,'- Tabeng Border');
			$this->pdf->text($x,$this->pdf->getY()+33,'- Bordir');
			$this->pdf->setY($this->pdf->getY()+33);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Panel (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- LP 3 PK'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- LP 2 PK'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- MR');
			$this->pdf->text($x,$this->pdf->getY()+25,'- MT');
			$this->pdf->text($x,$this->pdf->getY()+29,'- LA');
			$this->pdf->setY($this->pdf->getY()+29);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Plastik (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- LP '); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- '); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+21,'- Kursi');
			$this->pdf->setY($this->pdf->getY()+21);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+10,'Sofa (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+13,'- LP 3 PK'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+17,'- LP 2 PK'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->setY($this->pdf->getY()+17);
			
			$this->pdf->setFont('Arial','B',10);
			$this->pdf->text($x,$this->pdf->getY()+8,'Centian (hari/kumulatif)');
			$this->pdf->setFont('Arial','',9);
			$this->pdf->setY(15);
			
			/* 
			End
			Left Section 
			*/
			
			/*
			Begin
			Right Section
			*/
			$x = 100;
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,20,'2. PENJUALAN TOKO Rp. (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+10,'- Springbed'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+13,'- Kasur busa'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+16,'- Centian');
			$this->pdf->text($x,$this->pdf->getY()+19,'- Sofa');
			$this->pdf->text($x,$this->pdf->getY()+22,'- Toppan');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Hachiko');
			$this->pdf->text($x,$this->pdf->getY()+28,'- Hachiko Container');
			$this->pdf->text($x,$this->pdf->getY()+31,'- Barang umum');
			$this->pdf->text($x,$this->pdf->getY()+34,'- Panel cina');
			$this->pdf->text($x,$this->pdf->getY()+37,'- Barang impor');
			$this->pdf->text($x,$this->pdf->getY()+40,'- Sampah');
			$this->pdf->text($x,$this->pdf->getY()+43,'- Total Penjulan toko');
			$this->pdf->setY($this->pdf->getY()+45);
			
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,65,'3. PENJUALAN CABANG Rp. (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+10,'- Springbed'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+13,'- Kasur busa'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+16,'- Centian');
			$this->pdf->text($x,$this->pdf->getY()+19,'- Sofa');
			$this->pdf->text($x,$this->pdf->getY()+22,'- Toppan');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Hachiko');
			$this->pdf->text($x,$this->pdf->getY()+28,'- Hachiko Container');
			$this->pdf->text($x,$this->pdf->getY()+31,'- Barang umum');
			$this->pdf->text($x,$this->pdf->getY()+34,'- Panel cina');
			$this->pdf->text($x,$this->pdf->getY()+37,'- Barang impor');
			$this->pdf->text($x,$this->pdf->getY()+40,'- Total Penjualan Cabang');
			$this->pdf->setY($this->pdf->getY()+42);
			
			/*
			$this->pdf->setFont('Arial','B',12);
			$this->pdf->text(100,108,'PENJUALAN UD1 & UD2');
			
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,113,'4.PENJUALAN TOKO Rp. (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+10,'- Springbed (DV+SD)'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+13,'- Centian'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+16,'- Sofa');
			$this->pdf->text($x,$this->pdf->getY()+19,'- Barang Umum');
			$this->pdf->text($x,$this->pdf->getY()+22,'- Sampah');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Total Penjualan Toko');            
			$this->pdf->setY($this->pdf->getY()+25);
			
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,140,'5.PENJUALAN CABANG Rp. (hari/kumulatif)');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+10,'- Springbed (DV+SD)'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+13,'- Centian'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+16,'- Sofa');
			$this->pdf->text($x,$this->pdf->getY()+19,'- Barang Umum');
			$this->pdf->text($x,$this->pdf->getY()+22,'- Sampah');
			$this->pdf->text($x,$this->pdf->getY()+25,'- Total Penjualan Cabang');
			$this->pdf->text($x,$this->pdf->getY()+28,'- Total Penjualan UD All Product');
			$this->pdf->setY($this->pdf->getY()+30);
			*/
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,108,'6.PIUTANG DAGANG');
			
			$this->pdf->setFont('Arial','',9);
			$this->pdf->text($x,$this->pdf->getY()+10,'- 0 sd 60 hari'); // $this->pdf->text(50,$this->pdf->getY()+13,' : 10/20');
			$this->pdf->text($x,$this->pdf->getY()+13,'- 61 sd 90 hari'); // $this->pdf->text(50,$this->pdf->getY()+17,' : 11/17');
			$this->pdf->text($x,$this->pdf->getY()+16,'- 91 sd 120 hari');
			$this->pdf->text($x,$this->pdf->getY()+19,'- > 120 hari');
			$this->pdf->text($x,$this->pdf->getY()+22,'- Total Piutang Dagang');
			$this->pdf->setY($this->pdf->getY()+23);
			
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,132,'7.PIUTANG CABANG');
			
			$this->pdf->setFont('Arial','',9);
			$sqlcompany = "select companyid,companycode from company where companyid <> ".$companyid.' order by companyid asc';
			$company = $this->connection->createCommand($sqlcompany)->queryAll();
			$y = intval(10);
			foreach($company as $row){
					$this->pdf->text($x,$this->pdf->getY()+$y,'- Cabang '.$row['companycode']);
					
					
					$sqlaccrec = "select sum(amount-payamount) as sisa
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
									where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$row['companyid']."
									and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z";
					$row = $this->connection->createCommand($sqlaccrec)->queryRow();
					$this->pdf->text(145,$this->pdf->getY()+$y,' : '.number_format($row['sisa']),0,'.',',');
					$y1 = 3;
					$y = $y1+$y; 
					
			}
			$this->pdf->text($x,$this->pdf->getY()+$y,'- Total Piutang Cabang');
			$this->pdf->setY($this->pdf->getY()+28);
			
			$this->pdf->setFont('Arial','',12);
			$this->pdf->text(100,225,'8.TAGIHAN HARI INI VS KUMULATIF');
			
			$this->pdf->setY(15);
			
			/*
			End
			Right Section
			*/
			
			
			/* 
			Begin
			Data Section 
			*/
			$this->pdf->setFont('Arial','',9);
			// production
			$select_prod = "select ifnull(sum(y.qtyoutput),0) as jumlah ";
			$select_qty_sales = "select ifnull(sum(b.qty),0) as jumlah ";
			$select_price_sales = "select ifnull(sum(c.totalaftdisc),0) as jumlah ";
			$from_prod = "from productoutput x 
									join productoutputfg y on x.productoutputid = y.productoutputid
									join product d on d.productid = y.productid ";
			
			$from_sales = "from giheader a
									join gidetail b on a.giheaderid = b.giheaderid
									join soheader c on c.soheaderid = a.soheaderid
									join product d on d.productid = b.productid ";
			$join_ab = "join addressbook e on e.addressbookid = c.addressbookid ";
			
			$where_prod_day = "where x.recordstatus = 3 and x.productoutputdate = '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and x.companyid = ".$companyid;
			$where_sales_day = "where a.recordstatus = 3 and a.gidate = '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and c.companyid = ".$companyid;
			
			$where_prod_kum = "where x.recordstatus = 3 
													and x.productoutputdate between '".$year.'-'.$month."-01' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and x.companyid = ".$companyid;
			
			$where_sales_kum = "where a.recordstatus = 3 and 
													a.gidate between '".$year.'-'.$month."-01' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and c.companyid = ".$companyid;
			
			
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like '%premium%' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+25);
			
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like '%kangaroo regular%' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
				 $kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			
			$this->pdf->setY($this->pdf->getY()+25);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like '%non regular%' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+25);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'kasur busa' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(10,$this->pdf->getY()+13+$y,'Produksi VS Penjualan : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+10);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'balokan' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(10,$this->pdf->getY()+13+$y,'Produksi VS Penjualan : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+10);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'wip rangka%' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+21.5);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'wip kain%' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+15.5);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'tabeng bordir' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			$this->pdf->setY($this->pdf->getY()+3.5);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'bordir' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(40,$this->pdf->getY()+13+$y,' : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			
			$this->pdf->setY($this->pdf->getY()+80);
			$premium = "select materialtypeid from materialtype where recordstatus = 1 and description like 'centian' order by nourut asc";
			$sql = $this->connection->createCommand($premium)->queryAll();
			$connection = $this->connection;
			$y = 0;
			foreach($sql as $rows){
					$kumprodprem = $select_prod.$from_prod.$where_prod_kum.' and d.materialtypeid = '.$rows['materialtypeid'];
					$kumprodpremium = $connection->createCommand($kumprodprem)->queryRow();
					
					$dayprodprem = $select_prod.$from_prod.$where_prod_day.' and d.materialtypeid = '.$rows['materialtypeid'];
					$dayprodpremium = $connection->createCommand($dayprodprem)->queryRow();
					
					$kumsalesprem = $select_qty_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and recordstatus  = 1) ';
					$kumsalespremium = $connection->createCommand($kumsalesprem)->queryRow();
					
					$daysalesprem = $select_qty_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$rows['materialtypeid']. ' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and recordstatus  = 1) ';
					$daysalespremium = $connection->createCommand($daysalesprem)->queryRow();
					
					$this->pdf->text(10,$this->pdf->getY()+13+$y,'Produksi VS Penjualan : '.
					number_format($dayprodpremium['jumlah'],0,',','.').'/'.number_format($kumprodpremium['jumlah'],0,',','.'). ' VS '.
					number_format($daysalespremium['jumlah'],0,',','.').'/'.number_format($kumsalespremium['jumlah'],0,',','.'));
					$y = $y+4;
			}
			
			/* Right */
			$x = 145;
			$this->pdf->setY(15);
			
			// 1
			$sqlmaterialid1 = "select group_concat(materialtypeid) as materialtypeid from materialtype where description like ('matras%') or (description like ('divan%') or description like ('sandaran%')) and description not like ('sandaran bs%') and description not like ('sandaran bed%')";
			$material1 = $this->connection->createCommand($sqlmaterialid1)->queryRow();
			$connection = $this->connection;
			$y = 0;
					
			$kumsalspr = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid in ('.$material1['materialtypeid'].') and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and isvendor=0) ';
			$kumsalesspr = $connection->createCommand($kumsalspr)->queryRow();
					
			$daysalspr = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid in ('.$material1['materialtypeid'].') and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and z.isvendor=0) ';
			$daysalesspr = $connection->createCommand($daysalspr)->queryRow();
					
			$sqlmaterialid2 = "select materialtypeid as materialtypeid from materialtype where description like ('kasur busa')";
			$material2 = $this->connection->createCommand($sqlmaterialid2)->queryRow();
			
			$kumsalkb = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material2['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsaleskb = $connection->createCommand($kumsalkb)->queryRow();
					
			$daysalkb = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material2['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysaleskb = $connection->createCommand($daysalkb)->queryRow();
			
			$sqlmaterialid3 = "select materialtypeid as materialtypeid from materialtype where description like ('centian')";
			$material3 = $this->connection->createCommand($sqlmaterialid3)->queryRow();
			
			$kumsalcen = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material3['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsalescen = $connection->createCommand($kumsalcen)->queryRow();
					
			$daysalcen = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material3['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysalescen = $connection->createCommand($daysalcen)->queryRow();
			
			$sqlmaterialid4 = "select materialtypeid as materialtypeid from materialtype where description like ('sofa')";
			$material4 = $this->connection->createCommand($sqlmaterialid4)->queryRow();
			
			$kumsalsf = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material4['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsalessf = $connection->createCommand($kumsalsf)->queryRow();
					
			$daysalsf = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material4['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysalessf = $connection->createCommand($daysalsf)->queryRow();
			
			$sqlmaterialid5 = "select materialtypeid as materialtypeid from materialtype where description like ('toppan')";
			$material5 = $this->connection->createCommand($sqlmaterialid5)->queryRow();
			
			$kumsalhc = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material5['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsaleshc = $connection->createCommand($kumsalhc)->queryRow();
					
			$daysalhc = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material5['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysaleshc = $connection->createCommand($daysalhc)->queryRow();
			
			$sqlmaterialid6 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko')";
			$material6 = $this->connection->createCommand($sqlmaterialid6)->queryRow();
			
			$kumsaltp = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material6['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsalestp = $connection->createCommand($kumsaltp)->queryRow();
					
			$daysaltp = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material6['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysalestp = $connection->createCommand($daysaltp)->queryRow();
			
			$sqlmaterialid7 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko container')";
			$material7 = $this->connection->createCommand($sqlmaterialid7)->queryRow();
			
			$kumsalhck = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material7['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsaleshck = $connection->createCommand($kumsalhck)->queryRow();
					
			$daysalhck = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material7['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysaleshck = $connection->createCommand($daysalhck)->queryRow();
			
			$sqlmaterialid10 = "select materialtypeid as materialtypeid from materialtype where description like ('barang impor')";
			$material10 = $this->connection->createCommand($sqlmaterialid10)->queryRow();
			
			$kumsalbi = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material10['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsalesbi = $connection->createCommand($kumsalbi)->queryRow();
					
			$daysalbi = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material10['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysalesbi = $connection->createCommand($daysalbi)->queryRow();
			
			$sqlmaterialid11 = "select materialtypeid as materialtypeid from materialtype where description like ('sampah')";
			$material11 = $this->connection->createCommand($sqlmaterialid11)->queryRow();
			
			$kumsalsmh = $select_price_sales.$from_sales.$where_sales_kum.' and d.materialtypeid = '.$material11['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and isvendor=0) ';
			$kumsalessmh = $connection->createCommand($kumsalsmh)->queryRow();
					
			$daysalsmh = $select_price_sales.$from_sales.$where_sales_day.'  and d.materialtypeid = '.$material11['materialtypeid'].' and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus = 1 and z.isvendor=0) ';
			$daysalessmh = $connection->createCommand($daysalsmh)->queryRow();
			
			$kumsaltotal = $select_price_sales.$from_sales.$where_sales_kum.' and c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and isvendor=0) ';
			$kumsalestotal = $connection->createCommand($kumsaltotal)->queryRow();
					
			$daysaltotal = $select_price_sales.$from_sales.$where_sales_day.'  and  c.addressbookid in (select addressbookid from addressbook z where z.iscustomer = 1  and recordstatus  = 1 and z.isvendor=0) ';
			$daysalestotal = $connection->createCommand($daysaltotal)->queryRow();
			
			$this->pdf->text(145,$this->pdf->getY()+10,' : '.
			number_format($daysalesspr['jumlah']/$per,0,',','.').'/'.number_format($kumsalesspr['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+13,' : '.
			number_format($daysaleskb['jumlah']/$per,0,',','.').'/'.number_format($kumsaleskb['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+16,' : '.
			number_format($daysalescen['jumlah']/$per,0,',','.').'/'.number_format($kumsalescen['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+19,' : '.
			number_format($daysalessf['jumlah']/$per,0,',','.').'/'.number_format($kumsalessf['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+22,' : '.
			number_format($daysaleshc['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshc['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+25,' : '.
			number_format($daysalestp['jumlah']/$per,0,',','.').'/'.number_format($kumsalestp['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+28,' : '.
			number_format($daysaleshck['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshck['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+31,' : Barang umum '.
			number_format($daysaleshck['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshck['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+34,' : Panel Cina '.
			number_format($daysaleshck['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshck['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+37,' : '.
			number_format($daysalesbi['jumlah']/$per,0,',','.').'/'.number_format($kumsalesbi['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+40,' : '.
			number_format($daysalessmh['jumlah']/$per,0,',','.').'/'.number_format($kumsalessmh['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+43,' : '.
			number_format($daysalestotal['jumlah']/$per,0,',','.').'/'.number_format($kumsalestotal['jumlah']/$per,0,',','.'));
			
			// 2
			$this->pdf->setY($this->pdf->getY()+45);
			
			$sqlmaterialid1 = "select group_concat(materialtypeid) as materialtypeid from materialtype where description like ('matras%') or (description like ('divan%') or description like ('sandaran%')) and description not like ('sandaran bs%') and description not like ('sandaran bed%')";
			$material1 = $this->connection->createCommand($sqlmaterialid1)->queryRow();
			$connection = $this->connection;
			$y = 0;
			$groupcustomerid = $this->connection->createCommand("select groupcustomerid from groupcustomer b where b.groupname = 'cabang'")->queryScalar();
					
			$kumsalspr = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid in ('.$material1['materialtypeid'].') and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalesspr = $connection->createCommand($kumsalspr)->queryRow();
					
			$daysalspr = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid in ('.$material1['materialtypeid'].') and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalesspr = $connection->createCommand($daysalspr)->queryRow();
					
			$sqlmaterialid2 = "select materialtypeid as materialtypeid from materialtype where description like ('kasur busa')";
			$material2 = $this->connection->createCommand($sqlmaterialid2)->queryRow();
			
			$kumsalkb = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material2['materialtypeid'].' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsaleskb = $connection->createCommand($kumsalkb)->queryRow();
					
			$daysalkb = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material2['materialtypeid'].' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysaleskb = $connection->createCommand($daysalkb)->queryRow();
			
			$sqlmaterialid3 = "select materialtypeid as materialtypeid from materialtype where description like ('centian')";
			$material3 = $this->connection->createCommand($sqlmaterialid3)->queryRow();
			
			$kumsalcen = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material3['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalescen = $connection->createCommand($kumsalcen)->queryRow();
					
			$daysalcen = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material3['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalescen = $connection->createCommand($daysalcen)->queryRow();
			
			$sqlmaterialid4 = "select materialtypeid as materialtypeid from materialtype where description like ('sofa')";
			$material4 = $this->connection->createCommand($sqlmaterialid4)->queryRow();
			
			$kumsalsf = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material4['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalessf = $connection->createCommand($kumsalsf)->queryRow();
					
			$daysalsf = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material4['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalessf = $connection->createCommand($daysalsf)->queryRow();
			
			$sqlmaterialid5 = "select materialtypeid as materialtypeid from materialtype where description like ('toppan')";
			$material5 = $this->connection->createCommand($sqlmaterialid5)->queryRow();
			
			$kumsaltp = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material5['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalestp = $connection->createCommand($kumsaltp)->queryRow();
					
			$daysaltp = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material5['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalestp = $connection->createCommand($daysaltp)->queryRow();
			
			$sqlmaterialid6 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko')";
			$material6 = $this->connection->createCommand($sqlmaterialid6)->queryRow();
			
			$kumsalhc = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material6['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsaleshc = $connection->createCommand($kumsalhc)->queryRow();
					
			$daysalhc = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material6['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysaleshc = $connection->createCommand($daysalhc)->queryRow();
			
			$sqlmaterialid7 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko container')";
			$material7 = $this->connection->createCommand($sqlmaterialid7)->queryRow();
			
			$kumsalhck = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material7['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsaleshck = $connection->createCommand($kumsalhck)->queryRow();
					
			$daysalhck = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material7['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysaleshck = $connection->createCommand($daysalhck)->queryRow();
			
			$sqlmaterialid8 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko')";
			$material8 = $this->connection->createCommand($sqlmaterialid8)->queryRow();
			
			$kumsalbu = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material8['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalesbu = $connection->createCommand($kumsalbu)->queryRow();
					
			$daysalbu = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material8['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalesbu = $connection->createCommand($daysalbu)->queryRow();
			
			$sqlmaterialid9 = "select materialtypeid as materialtypeid from materialtype where description like ('hachiko')";
			$material9 = $this->connection->createCommand($sqlmaterialid9)->queryRow();
			
			$kumsalpnl = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material9['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalespnl = $connection->createCommand($kumsalpnl)->queryRow();
					
			$daysalpnl = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material9['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalespnl = $connection->createCommand($daysalpnl)->queryRow();
			
			$sqlmaterialid10 = "select materialtypeid as materialtypeid from materialtype where description like ('barang impor')";
			$material3 = $this->connection->createCommand($sqlmaterialid3)->queryRow();
			
			$kumsalbi = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and d.materialtypeid = '.$material10['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalesbi = $connection->createCommand($kumsalbi)->queryRow();
					
			$daysalbi = $select_price_sales.$from_sales.$join_ab.$where_sales_day.'  and d.materialtypeid = '.$material10['materialtypeid'].' and e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalesbi = $connection->createCommand($daysalbi)->queryRow();
			
			$kumsaltotal = $select_price_sales.$from_sales.$join_ab.$where_sales_kum.' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$kumsalestotal = $connection->createCommand($kumsaltotal)->queryRow();
					
			$daysaltotal = $select_price_sales.$from_sales.$join_ab.$where_sales_day.' and  e.groupcustomerid = '.$groupcustomerid. ' and c.companyid <> '.$companyid;
			$daysalestotal = $connection->createCommand($daysaltotal)->queryRow();
			
			$this->pdf->text(145,$this->pdf->getY()+10,' : '.
			number_format($daysalesspr['jumlah']/$per,0,',','.').'/'.number_format($kumsalesspr['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+13,' : '.
			number_format($daysaleskb['jumlah']/$per,0,',','.').'/'.number_format($kumsaleskb['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+16,' : '.
			number_format($daysalescen['jumlah']/$per,0,',','.').'/'.number_format($kumsalescen['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+19,' : '.
			number_format($daysalessf['jumlah']/$per,0,',','.').'/'.number_format($kumsalessf['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+22,' : '.
			number_format($daysalestp['jumlah']/$per,0,',','.').'/'.number_format($kumsalestp['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+25,' : '.
			number_format($daysaleshc['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshc['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+28,' : '.
			number_format($daysaleshck['jumlah']/$per,0,',','.').'/'.number_format($kumsaleshck['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+31,' : '.
			number_format($daysalesbu['jumlah']/$per,0,',','.').'/'.number_format($kumsalesbu['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+34,' : '.
			number_format($daysalespnl['jumlah']/$per,0,',','.').'/'.number_format($kumsalespnl['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+37,' : '.
			number_format($daysalesbi['jumlah']/$per,0,',','.').'/'.number_format($kumsalesbi['jumlah']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+40,' : '.
			number_format($daysalestotal['jumlah']/$per,0,',','.').'/'.number_format($kumsalestotal['jumlah']/$per,0,',','.'));
			
			 // 3
			$this->pdf->setY($this->pdf->getY()+42);
			
		 $y = 0;
			
		 $sqlaccrec = "select sum(amount-payamount) as sisa
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
									where a.recordstatus=3 and a.invoiceno is not null and c.companyid = ".$companyid." 
									and a.invoicedate <= '".date(Yii::app()->params['datetodb'], strtotime($enddate))."')z
									where amount > payamount ";
			
			$sqlrec1 = $sqlaccrec.' and umur <= 60';
			$top60 = $connection->createCommand($sqlrec1)->queryRow();
					
			$sqlrec2 = $sqlaccrec.' and umur > 60 and umur <= 90';
			$top90 = $connection->createCommand($sqlrec2)->queryRow();
			
			$sqlrec3 = $sqlaccrec.' and umur > 90 and umur <= 120';
			$top120 = $connection->createCommand($sqlrec3)->queryRow();
			
			$sqlrec4 = $sqlaccrec.' and umur > 120';
			$top120top = $connection->createCommand($sqlrec4)->queryRow();
			
			$sqlrec5 = $sqlaccrec;
			$toptotal = $connection->createCommand($sqlrec5)->queryRow();
			
			$this->pdf->text(145,$this->pdf->getY()+10,' : '.number_format($top60['sisa']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+13,' : '.number_format($top90['sisa']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+16,' : '.number_format($top120['sisa']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+19,' : '.number_format($top120top['sisa']/$per,0,',','.'));
			$this->pdf->text(145,$this->pdf->getY()+22,' : '.number_format($toptotal['sisa']/$per,0,',','.'));
			
			
			// 7
			$this->pdf->setY($this->pdf->getY()+70);
			$sqltagihan = "select sum(d.amount)
									from cbin a
									join ttnt b on a.ttntid = b.ttntid
									join ttntdetail c on c.ttntid = b.ttntid
									join invoice d on c.invoiceid = d.invoiceid
									where b.iscbin = 1 and a.recordstatus = 3 ";
			$day = "and a.docdate = curdate() ";
			$kum = "and a.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
									
			$tagihan_day = $this->connection->createCommand($sqltagihan.$day)->queryScalar();
			$tagihan_kum = $this->connection->createCommand($sqltagihan.$kum)->queryScalar();
			
			$this->pdf->text(100,$this->pdf->getY()+28,'  '.
			number_format($tagihan_day/$per,0,',','.').' VS '.number_format($tagihan_kum/$per,0,',','.'));
			
			/* 
			End
			Data Section 
			*/
			$this->pdf->Output('Laporan Harian per: '.$startdate,'I');
	}
	public function LaporanHarian($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate,$per)
    {
    parent::actionDownload();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    
    if($sloc != ''){
        
    $sql        = "select distinct c.sloccode,c.slocid
                 from materialgroup a
                 join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
                 join storagebin g on g.slocid = c.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                 where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
				 f.productname like '%" . $product . "%' and g.description like '%".$storagebin."%'
                 and c.recordstatus=1 ";
    $command    = $this->connection->createCommand($sql);
    $maxso = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appso')")->queryScalar();
    $maxgi = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgi')")->queryScalar();
    $maxscanop = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appscanhp')")->queryScalar();
        
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Stock Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P',array(300,300));
    $this->pdf->sety($this->pdf->gety() + 5);
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
    );
    $this->pdf->setwidths(array(
      80,
      20,
      20,
      20,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang                                                                                                  ',
      'Satuan                 ',
      'Stock Ready       ',
      'Umur Stock        ',
      'Buffer Request',
      '       Qty SO       ',
      'Pendingan SO',
      '           Qty SJ           ',
      'TRF Gudang Produksi'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				    join sloc c on c.slocid = b.slocid
				    join plant d on d.plantid = c.plantid
				    join company e on e.companyid = d.companyid
				    join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstock z
                    where z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue
                    and z.storagedesc like '%".$storagebin."%' and z.qty <> 0) ";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
          
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi'].'->'.$row1['materialgroupid']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $this->pdf->setY($this->pdf->getY()+5);
        /*
          $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')";
        $command2    = $this->connection->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        */
        $this->pdf->sety($this->pdf->gety() + 8);
        //foreach ($dataReader2 as $row2) {
            $sql3 = "select *,if(akhir >= pendinganso, pendinganso, akhir) as qtygis from (select distinct b.productname,f.uomcode,
                (select sum(qty)
                from productstockdet za 
                where za.productid = b.productid and za.slocid = a.slocid and za.unitofmeasureid = a.unitofissue and za.transdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and za.storagedesc like '%".$storagebin."%' ) as akhir,
                ifnull((select datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',datehp) as umur from tempscan ca 
                where ca.productid = b.productid and ca.slocid = c.slocid 
                and isapprovehp={$maxscanop} and transstockid is not null and soheaderid is null and giheaderid is null and isapprovegi=0 order by datehp desc 
                limit 1),datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."','2019-09-01')) as umur,
                (select ifnull((select reordervalue from mrp a1 where a1.productid = b.productid and a1.slocid = a.slocid and a1.uomid = a.unitofissue and a1.recordstatus=1),0)) as buffer,
                (select ifnull(sum(qty-giqty),0)
                from sodetail a2 
                join soheader b2 on b2.soheaderid = a2.soheaderid
                where b2.companyid={$companyid} and b2.recordstatus={$maxso} and b2.sodate = '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                and a2.productid = b.productid
                and a2.qty > a2.giqty) qtyso,
                (select ifnull(sum(qty-giqty),0)
                from sodetail a3 
                join soheader b3 on b3.soheaderid = a3.soheaderid
                where b3.companyid={$companyid} and b3.recordstatus={$maxso} and b3.sodate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                and a3.productid = b.productid
                and a3.qty > a3.giqty) pendinganso,
                (select ifnull(sum(qty) ,0)
                from gidetail a4 
                join giheader b4 on b4.giheaderid = a4.giheaderid
                where b4.companyid = {$companyid} and b4.recordstatus={$maxgi} and b4.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a4.productid = b.productid) as qtygi,
                (select ifnull(sum(qtyori),0)
                from tempscan a5
                where a5.productid = b.productid 
                and a5.productoutputid is not null and a5.productoutputfgid is not null and a5.isapprovehp={$maxscanop} and a5.isean=0 and a5.transstockid is not null and a5.transstockdetid is not null and datehp = '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') as qtyscan
                from materialgroup e 
                join productplant a on a.materialgroupid = e.materialgroupid
                join product b on b.productid = a.productid
                join sloc c on c.slocid = a.slocid
                -- join storagebin d on d.slocid = c.slocid
                join unitofmeasure f on f.unitofmeasureid = a.unitofissue
                where c.slocid = {$row['slocid']} and a.recordstatus = 1 
                and e.materialgroupid = {$row1['materialgroupid']} and b.productname like '%".$product."%'
                and b.productid in (select productid za
                from productstock za 
                where za.storagedesc like '%".$storagebin."%' and za.unitofmeasureid = a.unitofissue and za.slocid = c.slocid))z
                where akhir<>0 or qtyso <> 0 or pendinganso <> 0 or qtygi <> 0 or qtyscan <> 0 ";
            
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
          $command3    = $this->connection->createCommand($sql3);
          $dataReader3 = $command3->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['productname'],
              $row3['uomcode'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['umur']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['buffer']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtyso']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['pendinganso']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtygis']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtyscan']),
            ));
            /*
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
            */
          //}
        }
        /*  
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
        */
      }
        $this->pdf->setY($this->pdf->getY()+5);
        $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2)
    ));
    $this->pdf->Output();
    }
    else
    {
        $this->pdf->companyid = $companyid;
        
        $this->pdf->title    = 'Rekap Stock Barang';
        $this->pdf->AddPage('P');
        $this->pdf->text(10,15,'Harap Diisi Kolom Gudang');
        $this->pdf->Output();
    }
    }
	//44
  public function LaporanRekapMonitoringStock($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $pendingfpp2     = 0;
    $pendingpo2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Rekap Monitoring Stock';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P',array(230,297));
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 8);
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
      80,
      15,
      20,
      20,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang                                                                                      ',
      'Satuan      ',
      '              Awal           ',
      '           Masuk           ',
      '           Keluar           ',
      '             Akhir            ',
      'Pendingan FPP',
      'Pendingan PO'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $pendingfpp1  = 0;
      $pendingpo1  = 0;
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 7, 'GUDANG');
      $this->pdf->text(28, $this->pdf->gety() + 7, ': ' . $row['sloccode']);
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue
                    and z.storagedesc like '%".$storagebin."%')";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->pdf->sety($this->pdf->gety() + 5);
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        $pendingfpp = 0;
        $pendingpo = 0;
        $this->pdf->SetFont('Arial', 'BI', 9);
        $this->pdf->text(15, $this->pdf->gety() + 7, 'MATERIAL GROUP');
        $this->pdf->text(45, $this->pdf->gety() + 7, ': ' . $row1['divisi']);
        $this->pdf->text(80, $this->pdf->gety() + 7, '');
        $this->pdf->text(165, $this->pdf->gety() + 7, '' . $row['sloccode']);
        $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        $this->pdf->sety($this->pdf->gety() + 8);
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,pendingfpp,pendingpo
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,pendingfpp,pendingpo
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            and a.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            and b.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and l.storagedesc like '%".$storagebin."%'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.storagedesc like '%".$storagebin."%'
                            ) as konversiout,
                            (
                            select sum(a.qty) - sum(a.poqty) as pendingfpp
                            from prmaterial a
                            join prheader b on b.prheaderid = a.prheaderid
                            join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
                            where c.slocid = {$row['slocid']}  and a.productid = t.productid
                            and b.recordstatus=3
                            -- and b.prdate between '2019-10-14' and 
                            having pendingfpp > 0
                            ) as pendingfpp,
                            (
                            select sum(poqty) - sum(qtyres) as pendingpo
                            from podetail `xa` 
                            join poheader xb on xb.poheaderid = `xa`.poheaderid
                            where `xa`.productid = t.productid and `xa`.slocid = {$row['slocid']}
                            and xb.recordstatus=5
                            having pendingpo > 0 
                            ) as pendingpo
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' and t.recordstatus=1 order by barang ) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
          $this->pdf->sety($this->pdf->gety());
          $this->pdf->coldetailalign = array(
            'L',
            'C',
            'R',
            'R',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
          $command3    = Yii::app()->db->createCommand($sql3);
          $dataReader3 = $command3->queryAll();
          foreach ($dataReader3 as $row3) {
            $this->pdf->row(array(
              $row3['barang'],
              $row3['satuan'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['awal']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['masuk']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['keluar']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['pendingfpp']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['pendingpo'])
            ));
            $awal += $row3['awal'];
            $masuk += $row3['masuk'];
            $keluar += $row3['keluar'];
            $akhir += $row3['akhir'];
            $pendingfpp += $row3['pendingfpp'];
            $pendingpo += $row3['pendingpo'];
          }
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->row(array(
          'JUMLAH ' . $row1['divisi'],
          '',
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingfpp),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingpo)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $akhir1 += $akhir;
        $pendingfpp1 += $pendingfpp;
        $pendingpo1 += $pendingpo;
      }
      $this->pdf->row(array(
        'TOTAL ' . $row['sloccode'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingfpp1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingpo1)
      ));
      $awal2 += $awal1;
      $masuk2 += $masuk1;
      $keluar2 += $keluar1;
      $akhir2 += $akhir1;
      $pendingfpp2 += $pendingfpp1;
      $pendingpo2 += $pendingpo1;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial', 'BI', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $akhir2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingfpp2),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $pendingpo2)
    ));
    $this->pdf->Output();
  }
  //45
  public function LaporanRincianMonitoringStock($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.description,a.materialgroupid
									from materialgroup a
									join productplant b on b.materialgroupid=a.materialgroupid
									join sloc c on c.slocid = b.slocid
									join plant d on d.plantid = c.plantid
									join company e on e.companyid = d.companyid
									join product f on f.productid = b.productid
									where e.companyid = " . $companyid . " and f.productid in
									(select z.productid 
									from productstockdet z
									join sloc za on za.slocid = z.slocid
									join plant zb on zb.plantid = za.plantid
									join company zc on zc.companyid = zb.companyid
									join product zd on zd.productid = z.productid
									where zc.companyid = " . $companyid . " and z.slocid = b.slocid 
									and za.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
                                    and z.storagedesc like '%".$storagebin."%' )
									order by description";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Rincian Stock';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 0);
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->colalign = array(
      'C',
      'C',
      'R',
      'R',
      'R',
      'R'
    );
    $this->pdf->setwidths(array(
      80,
      30,
      20,
      20,
      20,
      20
    ));
    $this->pdf->colheader = array(
      'Nama Barang',
      'Gudang',
      'Awal',
      'Masuk',
      'Keluar',
      'Akhir'
    );
    $this->pdf->RowHeader();
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 5, ': ' . $row['description']);
      $awal1       = 0;
      $masuk1      = 0;
      $keluar1     = 0;
      $saldo1      = 0;
      $sql1        = "select productid,productname,slocid,sloccode,sum(masuk) as masuk ,sum(keluar) as keluar,awal, awal + (sum(masuk) + sum(keluar)) as saldo  from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,
					(select ifnull(sum(x.qty),0) from productstockdet x
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and e.materialgroupid = '" . $row['materialgroupid'] . "'
                and a.storagedesc like '%".$storagebin."%'
				and g.productname like '%" . $product . "%' 
				-- and a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                -- and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                ) z) zz) zzz) zzzz
                group by productname
				order by productname,sloccode";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->pdf->setY($this->pdf->getY()+7);
      $awal        = 0;
      $masuk       = 0;
      $keluar      = 0;
      $saldo       = 0;
      foreach ($dataReader1 as $row1) {
        $totalpendingfpp = 0;
        $totalpendingpo = 0;
        $this->pdf->SetFont('Arial', '', 8);
        /*
        $this->pdf->text(10, $this->pdf->gety() + 10, $row1['productname']);
        $this->pdf->text(170, $this->pdf->gety() + 10, $row1['sloccode']);
        $this->pdf->text(60, $this->pdf->gety() + 10, $row1['masuk']);
        $this->pdf->text(100, $this->pdf->gety() + 10, $row1['keluar']);
        $this->pdf->text(120, $this->pdf->gety() + 10, $row1['saldo']);
        */
        //$this->pdf->setwidths(array(70,25,20,20,20,20));
        $this->pdf->setwidths(array(
          80,
          30,
          20,
          20,
          20,
          20
        ));
        $this->pdf->coldetailalign = array(
          'L',
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->row(array(
            $row1['productname'],
            $row1['sloccode'],
            number_format($row1['awal'],2,',','.'),
            number_format($row1['masuk'],2,',','.'),
            number_format($row1['keluar'],2,',','.'),
            number_format($row1['saldo'],2,',','.'),
        ));
        $sql2 = "
            select * from (
            select 0 as pendingpo, '-' as pono, (a.qty) - (a.poqty) as pendingfpp, b.prno,a.prmaterialid
            from prmaterial a
            join prheader b on b.prheaderid = a.prheaderid
            join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
            where c.slocid = {$row1['slocid']}  and a.productid = {$row1['productid']}
            and b.recordstatus=3
            and b.prdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
            '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
            and a.qty > a.poqty
            union
            select (poqty) - (qtyres) as pendingpo, xb.pono, 0 as pendingfpp, '-' as prno,`xa`.podetailid
            from podetail `xa` 
            join poheader xb on xb.poheaderid = `xa`.poheaderid
            where `xa`.productid = {$row1['productid']} and `xa`.slocid = {$row1['slocid']}
            and xb.recordstatus=5
            and xb.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
            and poqty > qtyres
            ) z
        ";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        
        $this->pdf->sety($this->pdf->gety());
        $this->pdf->coldetailalign = array(
          'L',
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->setFont('Arial', 'U',8);
        $this->pdf->setwidths(array(
          40,
          30,
          30,
          30,
          30,
          30
        ));
        //$f=0;
        foreach ($dataReader2 as $row2) {
          //$f=1;
          if($row2['prno']=='-')
          {
              $strpr = '';
              $prno = '';
              $pendingfpp = '';
              $strpo = 'PENDINGAN PO';
              $pono = $row2['pono'];
              $pendingpo = Yii::app()->format->formatCurrency($row2['pendingpo']);
          }
          else
          {
              $strpr = 'PENDINGAN FPP';
              $prno = $row2['prno'];
              $pendingfpp = Yii::app()->format->formatCurrency($row2['pendingfpp']);
              $strpo = '';
              $pono = '';
              $pendingpo = '';
          }
          $this->pdf->row(array(
            $strpr,
            $prno,
            $pendingfpp,
            $strpo,
            $pono,
            $pendingpo
          ));
          $totalpendingfpp  += $row2['pendingfpp'];
          $totalpendingpo += $row2['pendingpo'];
        }
        $awal = $row1['awal'];
        $masuk = $row1['masuk'];
        $keluar = $row1['keluar'];
        $saldo = $awal + $masuk + $keluar;
        $this->pdf->setwidths(array(
          30,
          80,
          20,
          20,
          20,
          20
        ));
        $this->pdf->setFont('Arial', 'B', 9);
        
          $this->pdf->row(array(
          'Total',
          'PENDING FPP : '.$totalpendingfpp.' PENDING PO : '.$totalpendingpo,
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo)
        ));
        $awal1 += $awal;
        $masuk1 += $masuk;
        $keluar1 += $keluar;
        $saldo1 += $saldo;
        //if($f==1)
            $this->pdf->setY($this->pdf->getY()+5);
        
        $this->pdf->checkPageBreak(20);
      }
        
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->sety($this->pdf->gety() + 5);
        
      $this->pdf->row(array(
        '',
        'Grand Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $awal1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $masuk1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $keluar1),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $saldo1)
      ));
      $this->pdf->sety($this->pdf->gety() + 5);
    }
    $this->pdf->Output();
  }
  
	
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['companyid']) && isset($_GET['sloc']) && isset($_GET['storagebin']) && isset($_GET['sales']) && isset($_GET['product']) && isset($_GET['salesarea']) && isset($_GET['startdate']) && isset($_GET['enddate']))		
		{
			if ($_GET['lro'] == 1) {
        $this->RincianHistoriBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapHistoriBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 3) {
        $this->KartuStokBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 4) {
        $this->KartuStokBarangPerRakXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 5) {
        $this->RekapStokBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 6) {
        $this->RekapStokBarangPerHariXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 7) {
        $this->RekapStokBarangDenganRakXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 8) {
        $this->RincianSuratJalanPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 9) {
        $this->RekapSuratJalanPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapSuratJalanPerCustomerXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 11) {
        $this->RincianReturJualPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapReturJualPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 13) {
        $this->RekapReturJualPerCustomerXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 14) {
        $this->RincianTerimaBarangPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 15) {
        $this->RekapTerimaBarangPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 16) {
        $this->RekapTerimaBarangPerSupplierXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 17) {
        $this->RincianReturBeliPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 18) {
        $this->RekapReturBeliPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 19) {
        $this->RekapReturBeliPerSupplierXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 20) {
        $this->PendinganFpbXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 21) {
        $this->PendinganFppXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 22) {
        $this->RincianTransferGudangKeluarPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 23) {
        $this->RekapTransferGudangKeluarPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 24) {
        $this->RincianTransferGudangMasukPerDokumenXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 25) {
        $this->RekapTransferGudangMasukPerBarangXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 26) {
        $this->RekapStokBarangAdaTransaksiXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'], $_GET['storagebin'],$_GET['customer'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 40) {
        $this->LaporanMaterialNotMovingXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'],$_GET['storagebin'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
			} else if ($_GET['lro'] == 41) {
				$this->LaporanMaterialSlowMovingXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'],$_GET['storagebin'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
			} else if ($_GET['lro'] == 42) {
				$this->LaporanMaterialFastMovingXLS($_GET['companyid'], $_GET['sloc'], $_GET['slocto'],$_GET['storagebin'], $_GET['sales'], $_GET['product'], $_GET['salesarea'], $_GET['startdate'], $_GET['enddate'],$_GET['keluar3']);
			} else if ($_GET['lro'] == 43) {
        $this->LaporanHarianXLS($_GET['companyid'],$_GET['sloc'],$_GET['slocto'], $_GET['storagebin'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
      } else if ($_GET['lro'] == 44) {
        $this->LaporanRekapMonitoringStockXLS($_GET['companyid'],$_GET['sloc'],$_GET['slocto'], $_GET['storagebin'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['keluar3']);
      } else if ($_GET['lro'] == 45) {
        $this->LaporanRincianMonitoringStockXLS($_GET['companyid'],$_GET['sloc'],$_GET['slocto'], $_GET['storagebin'],$_GET['sales'],$_GET['product'],$_GET['salesarea'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
      }
		}
	}
	//3
	public function KartuStokBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'kartustokbarang';
    parent::actionDownxls();
    $sql        = "select distinct a.description
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					 join sloc c on c.slocid = b.slocid
					 join plant d on d.plantid = c.plantid
					 join company e on e.companyid = d.companyid
					 join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and f.productid in
					(select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
					join product zd on zd.productid = z.productid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and zd.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalsaldo2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, 'Tanggal')->setCellValueByColumnAndRow(2, $line, 'Saldo Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Saldo Akhir');
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalsaldo1  = 0;
      $sql1         = "select distinct productid,productname,slocid,sloccode from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '2016-04-01' and 
				'2016-04-29') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '2016-04-01' and 
				'2016-04-29') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,
					(select ifnull(sum(x.qty),0) from productstockdet x
					join sloc xb on xb.slocid = x.slocid 
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '2016-04-01') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and g.productname like '%" . $product . "%' and 
				a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz) zzzz
				order by productname,sloccode";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $totalawal   = 0;
      $totalmasuk  = 0;
      $totalkeluar = 0;
      $totalsaldo  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['productname'])->setCellValueByColumnAndRow(5, $line, 'Gudang')->setCellValueByColumnAndRow(6, $line, ': ' . $row1['sloccode']);
        $sql2        = "select awal,dokumen,tanggal,masuk,keluar,(awal+masuk+keluar) as saldo
                        from
                        (select awal,dokumen,tanggal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
                        from
                        (select referenceno as dokumen, transdate as tanggal,slocid,awal,
                        case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
                        case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
                        case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
                        case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
						case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
                        case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
                        case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
                        case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
                        case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
						case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
                        case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
                        from
                        (select a.referenceno,a.transdate,a.qty,a.slocid,
													(select ifnull(sum(x.qty),0) from productstockdet x
													join sloc xb on xb.slocid = x.slocid 
													where x.productid = '" . $row1['productid'] . "' and x.slocid = '" . $row1['slocid'] . "' and
                        x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
                        from productstockdet a
                        join sloc b on b.slocid = a.slocid
                        join plant c on c.plantid = b.plantid
                        join company d on d.companyid = c.companyid
                        where a.productid = '" . $row1['productid'] . "' and a.slocid = '" . $row1['slocid'] . "' and
												a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
												'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row2['dokumen'])->setCellValueByColumnAndRow(1, $line, $row2['tanggal'])->setCellValueByColumnAndRow(2, $line, $row2['awal'])->setCellValueByColumnAndRow(3, $line, $row2['masuk'])->setCellValueByColumnAndRow(4, $line, $row2['keluar'])->setCellValueByColumnAndRow(5, $line, $row2['saldo']);
          $totalawal += $row2['awal'];
          $totalmasuk += $row2['masuk'];
          $totalkeluar += $row2['keluar'];
          $totalsaldo += $row2['saldo'];
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total' . $row1['productname'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalsaldo);
        $totalawal1 += $row2['awal'];
        $totalmasuk1 += $row2['masuk'];
        $totalkeluar1 += $row2['keluar'];
        $totalsaldo1 += $row2['saldo'];
      }
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total' . $row['description'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalsaldo1);
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //4
	public function KartuStokBarangPerRakXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'kartustokbarangperrak';
    parent::actionDownxls();
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalsaldo2  = 0;
    $sql          = "select distinct a.description, b.slocid
			from materialgroup a
			join productplant b on b.materialgroupid=a.materialgroupid
			join sloc c on c.slocid = b.slocid
			join plant d on d.plantid = c.plantid
			join company e on e.companyid = d.companyid
			join product f on f.productid = b.productid
			where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and f.productid in
			(select z.productid 
			from productstockdet z
			join sloc za on za.slocid = z.slocid
			join plant zb on zb.plantid = za.plantid
			join company zc on zc.companyid = zb.companyid
			join product zd on zd.productid = z.productid
			where zc.companyid = " . $companyid . " and z.slocid = b.slocid and zd.productname like '%" . $product . "%'
			and z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
			and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
			order by description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalsaldo2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, 'Tanggal')->setCellValueByColumnAndRow(2, $line, 'Saldo Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Saldo Akhir');
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalsaldo1  = 0;
      $sql1         = "select distinct productid,productname,slocid,sloccode,storagebinid,rak from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,storagebinid,rak,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,storagebinid,rak,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,f.storagebinid,f.description as rak,
					(select ifnull(sum(x.qty),0) from productstockdet x
					join sloc xb on xb.slocid = x.slocid 
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '2016-04-01') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' 
				and g.productname like '%" . $product . "%' and a.slocid = " . $row['slocid'] . "
				and a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz) zzz) zzzz
				order by productname,sloccode,rak";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['productname'])->setCellValueByColumnAndRow(2, $line, 'Rak')->setCellValueByColumnAndRow(3, $line, ': ' . $row1['rak'])->setCellValueByColumnAndRow(5, $line, 'Gudang')->setCellValueByColumnAndRow(6, $line, ': ' . $row1['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalsaldo  = 0;
        $sql2        = "select awal,dokumen,tanggal,sum(masuk) as totmasuk,sum(keluar) as totkeluar,sum(awal+masuk+keluar) as saldo
					from
					(select awal,dokumen,tanggal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
					from
					(select referenceno as dokumen, transdate as tanggal,slocid,awal,
					case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
					case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
					case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
					case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
					case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
					case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
					case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
					case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
					case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
					from
					(select a.referenceno,a.transdate,a.qty,a.slocid,
						(select ifnull(sum(x.qty),0) from productstockdet x
						join sloc xb on xb.slocid = x.slocid 
						where x.productid = '" . $row1['productid'] . "' and x.slocid = '" . $row1['slocid'] . "' and
						x.storagebinid = " . $row1['storagebinid'] . " and
					x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'
					group by storagebinid) as awal
					from productstockdet a
					join sloc b on b.slocid = a.slocid
					join plant c on c.plantid = b.plantid
					join company d on d.companyid = c.companyid
					where a.productid = '" . $row1['productid'] . "' and a.slocid = '" . $row1['slocid'] . "' and
					a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.storagebinid = " . $row1['storagebinid'] . ") z) zz) zzz group by dokumen";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row2['dokumen'])->setCellValueByColumnAndRow(1, $line, $row2['tanggal'])->setCellValueByColumnAndRow(3, $line, $row2['totmasuk'])->setCellValueByColumnAndRow(4, $line, $row2['totkeluar']);
          $totalmasuk += $row2['totmasuk'];
          $totalkeluar += $row2['totkeluar'];
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total' . $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row2['awal'])->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $row2['saldo']);
        $totalawal1 += $row2['awal'];
        $totalmasuk1 += $totalmasuk;
        $totalkeluar1 += $totalkeluar;
        $totalsaldo1 += $row2['awal'] + $totalmasuk + $totalkeluar;
      }
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total' . $row['description'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalsaldo1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalmasuk1;
      $totalkeluar2 += $totalkeluar1;
      $totalsaldo2 += $totalawal1 + $totalmasuk1 + $totalkeluar1;
    }
    $line += 2;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalsaldo2);
    $this->getFooterXLS($this->phpExcel);
  }
  //5
	public function RekapStokBarangXLS($companyid, $sloc, $slocto, $storagebin,$customer,$sales, $product, $salesarea, $startdate, $enddate,$keluar3)
  {
    $this->menuname = 'rekapstokbarang';
    parent::actionDownxls();
    if($companyid > 0) {
      $joincom = ""; 
      $joincom1 = ""; 
      $wherecom = "  e.companyid = ".$companyid." "; 
      $wherecom1 = "  zc.companyid = ".$companyid." ";
    }
    else {
      $joincom = " join company a9 on a9.companyid=e.companyid "; 
      $joincom1 = " join company a9 on a9.companyid=g.companyid "; 
      $wherecom = " e.isgroup = 1"; 
      $wherecom1 = "  zc.isgroup = 1";
    }
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where {$wherecom} and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
				order by c.sloccode";
    $command    = $this->connection->createCommand($sql);
    $dataReader = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where {$wherecom} and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by a.description";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $sql2        = "select b.productid,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant f on f.plantid = d.plantid
                    join company e on e.companyid = f.companyid
                    join product g on g.productid = b.productid
                    where {$wherecom} and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
							      g.productname like '%" . $product . "%' and b.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where {$wherecom1} and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by g.productname";
        $command2    = $this->connection->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            and a.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            and b.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and aw.unitofmeasureid = t.unitofissue and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and c.unitofmeasureid = t.unitofissue and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and d.unitofmeasureid = t.unitofissue and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and e.unitofmeasureid = t.unitofissue and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and f.unitofmeasureid = t.unitofissue and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and g.unitofmeasureid = t.unitofissue and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and h.unitofmeasureid = t.unitofissue and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and i.unitofmeasureid = t.unitofissue and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and j.unitofmeasureid = t.unitofissue and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and k.unitofmeasureid = t.unitofissue and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and l.unitofmeasureid = t.unitofissue and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and l.storagedesc like '%".$storagebin."%'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and m.unitofmeasureid = t.unitofissue and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.storagedesc like '%".$storagebin."%'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' order by barang) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
          $command3    = $this->connection->createCommand($sql3);
          $dataReader3 = $command3->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }
	public function RekapStokBarangXLS_old($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapstokbarang';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
				order by c.sloccode";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by a.description";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $sql2        = "select b.productid,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
							      g.productname like '%" . $product . "%' and b.productid in
                    (select distinct z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%')
					order by g.productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            and a.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            and b.storagedesc like '%".$storagebin."%'
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and aw.unitofmeasureid = t.unitofissue and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid and aw.storagedesc like '%".$storagebin."%'
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and c.unitofmeasureid = t.unitofissue and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and d.unitofmeasureid = t.unitofissue and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.storagedesc like '%".$storagebin."%'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and e.unitofmeasureid = t.unitofissue and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and e.storagedesc like '%".$storagebin."%'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and f.unitofmeasureid = t.unitofissue and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.storagedesc like '%".$storagebin."%'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and g.unitofmeasureid = t.unitofissue and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and g.storagedesc like '%".$storagebin."%'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and h.unitofmeasureid = t.unitofissue and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and h.storagedesc like '%".$storagebin."%'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and i.unitofmeasureid = t.unitofissue and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and i.storagedesc like '%".$storagebin."%'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and j.unitofmeasureid = t.unitofissue and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and j.storagedesc like '%".$storagebin."%'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and k.unitofmeasureid = t.unitofissue and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and k.storagedesc like '%".$storagebin."%'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and l.unitofmeasureid = t.unitofissue and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and l.storagedesc like '%".$storagebin."%'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and m.unitofmeasureid = t.unitofissue and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and m.storagedesc like '%".$storagebin."%'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' order by barang) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }
  //7
	public function RekapStokBarangDenganRakXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapstokbarangdenganrak';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    join storagebin zd on zd.slocid = za.slocid
                    where zc.companyid = " . $companyid . " and zd.description like '%" . $storagebin . "%' and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Rak')->setCellValueByColumnAndRow(3, $line, 'Awal')->setCellValueByColumnAndRow(4, $line, 'Masuk')->setCellValueByColumnAndRow(5, $line, 'Keluar')->setCellValueByColumnAndRow(6, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    join storagebin zd on zd.slocid = za.slocid
                    where zc.companyid = " . $companyid . " and zd.description like '%" . $storagebin . "%' and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(6, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $sql2        = "select distinct b.productid,b.unitofissue,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
							      g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    join storagebin zd on zd.slocid = za.slocid
                    where zc.companyid = " . $companyid . " and zd.description like '%" . $storagebin . "%' and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from 
							(select barang,productid,satuan,unitofmeasureid,rak,storagebinid,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,productid,satuan,unitofmeasureid,rak,storagebinid,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
                            from
                            (select 
                            s.productname as barang,s.productid,b.uomcode as satuan,b.unitofmeasureid,n.description as rak,n.storagebinid,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.storagebinid = t.storagebinid and
                            aw.unitofmeasureid = t.unitofmeasureid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.storagebinid = t.storagebinid and
														c.unitofmeasureid = t.unitofmeasureid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.storagebinid = t.storagebinid and
                            d.unitofmeasureid = t.unitofmeasureid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.storagebinid = t.storagebinid and
                            e.unitofmeasureid = t.unitofmeasureid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.storagebinid = t.storagebinid and
                            f.unitofmeasureid = t.unitofmeasureid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like '%konversi%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.storagebinid = t.storagebinid and
                            f.unitofmeasureid = t.unitofmeasureid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.storagebinid = t.storagebinid and
                            g.unitofmeasureid = t.unitofmeasureid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.storagebinid = t.storagebinid and
                            h.unitofmeasureid = t.unitofmeasureid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.storagebinid = t.storagebinid and
                            i.unitofmeasureid = t.unitofmeasureid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.storagebinid = t.storagebinid and
                            j.unitofmeasureid = t.unitofmeasureid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like '%konversi%' and
                            k.qty < 0 and
                            k.slocid = t.slocid and
                            k.storagebinid = t.storagebinid and
                            k.unitofmeasureid = t.unitofmeasureid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout,
                            (
                            select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like 'TSO-%' and
                            l.slocid = t.slocid and
                            l.storagebinid = t.storagebinid and
                            l.unitofmeasureid = t.unitofmeasureid and
                            l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi
                            from productstock t
							join productplant r on r.productid=t.productid and r.unitofissue=t.unitofmeasureid and t.slocid=r.slocid
							join materialgroup u on u.materialgroupid = r.materialgroupid
							join sloc v on v.slocid = t.slocid
							join product s on s.productid=t.productid
							join unitofmeasure b on b.unitofmeasureid=t.unitofmeasureid
                     join storagebin n on n.storagebinid=t.storagebinid
							where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and n.description like '%" . $storagebin . "%' and v.slocid = '" . $row['slocid'] . "' and t.unitofmeasureid = '".$row2['unitofissue']."') z) zz )zzz where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 order by barang asc";
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['rak'])->setCellValueByColumnAndRow(3, $line, $row3['awal'])->setCellValueByColumnAndRow(4, $line, $row3['masuk'])->setCellValueByColumnAndRow(5, $line, $row3['keluar'])->setCellValueByColumnAndRow(6, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(3, $line, $totalawal)->setCellValueByColumnAndRow(4, $line, $totalmasuk)->setCellValueByColumnAndRow(5, $line, $totalkeluar)->setCellValueByColumnAndRow(6, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(3, $line, $totalawal1)->setCellValueByColumnAndRow(4, $line, $totalmasuk1)->setCellValueByColumnAndRow(5, $line, $totalkeluar1)->setCellValueByColumnAndRow(6, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(3, $line, $totalawal2)->setCellValueByColumnAndRow(4, $line, $totalmasuk2)->setCellValueByColumnAndRow(5, $line, $totalkeluar2)->setCellValueByColumnAndRow(6, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }
  //8
	public function RincianSuratJalanPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rinciansuratjalanperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct b.giheaderid,b.gino,b.gidate,a.sono,c.fullname as customer,d.fullname as sales,e.areaname,b.headernote 
                  from giheader b 
                  join soheader a on a.soheaderid = b.soheaderid
                  join addressbook c on c.addressbookid=a.addressbookid
                  join employee d on d.employeeid=a.employeeid
									join salesarea e on e.salesareaid=c.salesareaid
									join gidetail f on f.giheaderid=b.giheaderid
									join sloc h on h.slocid = f.slocid
									where b.gino is not null and a.companyid = " . $companyid . " and b.recordstatus = 3 and h.sloccode like '%" . $sloc . "%' 
									and d.fullname like '%" . $sales . "%'  and e.areaname like '%" . $salesarea . "%'  and 
									b.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
									and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
									and f.productid in (select x.productid 
									from productplant x join product xx on xx.productid = x.productid 
									where xx.productname like '%" . $product . "%'  and x.slocid = f.slocid)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. SJ')->setCellValueByColumnAndRow(1, $line, ': ' . $row['gino'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Area')->setCellValueByColumnAndRow(4, $line, ': ' . $row['areaname']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Sales')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sales'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Kepada Yth,')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. SO')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sono'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Customer')->setCellValueByColumnAndRow(4, $line, ': ' . $row['customer']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
      $line++;
      $sql1        = "select c.productname, a.qty,d.uomcode,b.itemnote,e.headernote,c.productid
                        from gidetail a 
                        join sodetail b on b.sodetailid = a.sodetailid
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join giheader e on e.giheaderid = a.giheaderid
                        where a.giheaderid = " . $row['giheaderid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, $row1['headernote']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan')->setCellValueByColumnAndRow(2, $line, ': ' . $row['headernote']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //9
	public function RekapSuratJalanPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapsuratjalanperbarang';
    parent::actionDownxls();
    $sql        = "select distinct b.materialgroupid,b.materialgroupcode,b.description
                    from giheader zb
                    join soheader za on za.soheaderid = zb.soheaderid 
                    join gidetail zc on zc.giheaderid = zb.giheaderid
										join sloc zd on zd.slocid = zc.slocid
										join product ze on ze.productid = zc.productid
                    join addressbook zf on zf.addressbookid=za.addressbookid
										join salesarea zg on zg.salesareaid = zf.salesareaid
                    join employee zh on zh.employeeid = za.employeeid
                    join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' and za.companyid = " . $companyid . " 
										and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' and
										zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $i        = 0;
      $totalqty = 0;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select productname,uomcode, sum(qty) as qty from 
						(select a.productid,c.productname,a.qty, f.uomcode
						from gidetail a
						join giheader b on b.giheaderid = a.giheaderid
						join product c on c.productid = a.productid
						join sloc d on d.slocid = a.slocid
						join productplant e on e.productid = c.productid and e.slocid = a.slocid and e.unitofissue = a.unitofmeasureid
						join unitofmeasure f on f.unitofmeasureid = e.unitofissue
						join plant g on g.plantid = d.plantid
						join soheader i on i.soheaderid = b.soheaderid
						join addressbook j on j.addressbookid = i.addressbookid
						join employee k on k.employeeid = i.employeeid
						join salesarea l on l.salesareaid = j.salesareaid
						where e.materialgroupid = '" . $row['materialgroupid'] . "' and i.companyid = " . $companyid . " 
						and k.fullname like '%" . $sales . "%' and b.recordstatus = 3  and l.areaname like '%" . $salesarea . "%'
						and c.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and b.gidate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')z group by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //10
	public function RekapSuratJalanPerCustomerXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapsuratjalanpercustomer';
    parent::actionDownxls();
    $sql        = "select distinct zf.addressbookid, zf.fullname
                    from giheader zb
                    join soheader za on za.soheaderid = zb.soheaderid 
                    join gidetail zc on zc.giheaderid = zb.giheaderid
										join sloc zd on zd.slocid = zc.slocid
										join product ze on ze.productid = zc.productid
                    join addressbook zf on zf.addressbookid=za.addressbookid
										join salesarea zg on zg.salesareaid = zf.salesareaid
										join employee zh on zh.employeeid = za.employeeid
                    join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' and za.companyid = " . $companyid . " 
										and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' 
										and zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
										order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Customer')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fullname']);
      $line++;
      $sql1        = "select distinct b.materialgroupid,b.materialgroupcode,b.description
						from giheader zb
						join soheader za on za.soheaderid = zb.soheaderid 
						join gidetail zc on zc.giheaderid = zb.giheaderid
						join sloc zd on zd.slocid = zc.slocid
						join product ze on ze.productid = zc.productid
						join addressbook zf on zf.addressbookid=za.addressbookid
						join salesarea zg on zg.salesareaid = zf.salesareaid
						join employee zh on zh.employeeid = za.employeeid
						join productplant a on a.productid = zc.productid and a.slocid = zc.slocid
						join materialgroup b on b.materialgroupid = a.materialgroupid
						where zb.recordstatus = 3 and zd.sloccode like '%" . $sloc . "%' 
						and za.companyid = " . $companyid . " and zf.addressbookid = " . $row['addressbookid'] . "
						and ze.productname like '%" . $product . "%' and zg.areaname like '%" . $salesarea . "%' and zh.fullname like '%" . $sales . "%' and
						zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1)
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      foreach ($dataReader1 as $row1) {
        $i           = 0;
        $totalqty    = 0;
        $sql2        = "select distinct a.productid,e.productname,f.uomcode,
                        (
                        select sum(zzb.qty)
                        from gidetail zzb 
                        join giheader zzc on zzc.giheaderid = zzb.giheaderid
                        where zzb.productid = a.productid
                        and zzb.slocid = a.slocid
                        and zzc.recordstatus = 3
                        ) as qty
                        from productplant a
                        join product e on e.productid = a.productid
                        join unitofmeasure f on f.unitofmeasureid = a.unitofissue
                        join sloc b on b.slocid = a.slocid
                        join plant c on c.plantid = b.plantid
                        join company d on d.companyid = c.companyid
                        where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and 
												a.materialgroupid = " . $row1['materialgroupid'] . " and a.productid in
                        (select za.productid
                        from gidetail za 
                        join giheader zb on zb.giheaderid = za.giheaderid
                        join soheader zc on zc.soheaderid = zb.soheaderid
                        join product zd on zd.productid = za.productid
                        where zc.addressbookid = " . $row['addressbookid'] . " and zd.productname like '%" . $product . "%' and
												zb.recordstatus = 3 and za.slocid = a.slocid and zc.companyid = " . $companyid . " and zb.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row2['productname'])->setCellValueByColumnAndRow(2, $line, $row2['uomcode'])->setCellValueByColumnAndRow(3, $line, $row2['qty']);
          $line++;
          $totalqty += $row2['qty'];
        }
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row1['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
        $line++;
        $line += 1;
      }
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //11
	public function RincianReturJualPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rincianreturjualperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct zd.gireturid,zd.gireturno,zg.fullname as customer,zh.fullname as sales,zd.gireturdate,zi.areaname,zb.gino 
                    from giretur zd
                    join giheader zb on zb.giheaderid = zd.giheaderid 
                    join gireturdetail ze on ze.gireturid = zd.gireturid
                    join soheader za on za.soheaderid = zb.soheaderid
                    join product zf on zf.productid = ze.productid
										join addressbook zg on zg.addressbookid = za.addressbookid
                    join employee zh on zh.employeeid = za.employeeid
                    join salesarea zi on zi.salesareaid = zg.salesareaid
                    join sloc zj on zj.slocid = ze.slocid
                    join productplant a on a.productid = ze.productid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zd.recordstatus = 3 and za.companyid = " . $companyid . " 
										and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
										and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. GIR')->setCellValueByColumnAndRow(1, $line, ': ' . $row['gireturno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Area')->setCellValueByColumnAndRow(4, $line, ': ' . $row['areaname']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Sales')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sales'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Customer,')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. SJ')->setCellValueByColumnAndRow(1, $line, ': ' . $row['gino'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(3, $line, '' . $row['customer']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
      $line++;
      $sql1        = "select distinct ze.productname,zk.uomcode,za.itemnote,zb.headernote,
                        (
                        select sum(zzb.qty)
                        from gireturdetail zzb 
                        join giretur zzc on zzc.gireturid = zzb.gireturid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3 and zzc.gireturid = zb.gireturid
                        ) as qty
                        from gireturdetail za 
                        join giretur zb on zb.gireturid = za.gireturid
                        join giheader zc on zc.giheaderid = zb.giheaderid
                        join soheader zd on zd.soheaderid = zc.soheaderid
                        join product ze on ze.productid = za.productid
												join addressbook zf on zf.addressbookid = zd.addressbookid
                        join employee zg on zg.employeeid = zd.employeeid
                        join salesarea zh on zh.salesareaid = zf.salesareaid
                        join productplant zi on zi.productid = za.productid
                        join sloc zj on zj.slocid = za.slocid
                        join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
                        where zb.recordstatus = 3 and zd.companyid = " . $companyid . " and za.gireturid = " . $row['gireturid'] . "
                        and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%'  
												and ze.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'   
												and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line++;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //12
	public function RekapReturJualPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapreturjualperbarang';
    parent::actionDownxls();
    $sql        = "select distinct b.materialgroupid,b.materialgroupcode,b.description  
                    from giretur zd
                    join giheader zb on zb.giheaderid = zd.giheaderid 
                    join gireturdetail ze on ze.gireturid = zd.gireturid
                    join soheader za on za.soheaderid = zb.soheaderid
                    join product zf on zf.productid = ze.productid
										join addressbook zg on zg.addressbookid = za.addressbookid
                    join employee zh on zh.employeeid = za.employeeid
                    join salesarea zi on zi.salesareaid = zg.salesareaid
                    join sloc zj on zj.slocid = ze.slocid
                    join productplant a on a.productid = ze.productid
                    join materialgroup b on b.materialgroupid = a.materialgroupid
                    where zd.recordstatus = 3 and za.companyid = " . $companyid . " 
										and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
										and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct za.productid,ze.productname,zk.uomcode,
                        (
                        select sum(zzb.qty)
                        from gireturdetail zzb 
                        join giretur zzc on zzc.gireturid = zzb.gireturid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3 and zzc.gireturid = zb.gireturid
                        ) as qty
                        from gireturdetail za 
                        join giretur zb on zb.gireturid = za.gireturid
                        join giheader zc on zc.giheaderid = zb.giheaderid
                        join soheader zd on zd.soheaderid = zc.soheaderid
                        join product ze on ze.productid = za.productid
												join addressbook zf on zf.addressbookid = zd.addressbookid
                        join employee zg on zg.employeeid = zd.employeeid
                        join salesarea zh on zh.salesareaid = zf.salesareaid
                        join productplant zi on zi.productid = za.productid
                        join sloc zj on zj.slocid = za.slocid
                        join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
                        where zb.recordstatus = 3 and zd.companyid = " . $companyid . "
                        and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%' and zj.sloccode like '%" . $sloc . "%' 
												and ze.productname like '%" . $product . "%' and zi.materialgroupid = " . $row['materialgroupid'] . "  
												and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
      }
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //13
	public function RekapReturJualPerCustomerXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapreturjualpercustomer';
    parent::actionDownxls();
    $sql        = "select distinct c.addressbookid,d.fullname 
                    from giretur a
                    join giheader b on b.giheaderid = a.giheaderid
                    join soheader c on c.soheaderid = b.soheaderid
                    join addressbook d on d.addressbookid = c.addressbookid
                    join gireturdetail e on e.gireturid = a.gireturid
										join sloc f on f.slocid = e.slocid
										join product g on g.productid = e.productid
                    join employee h on h.employeeid = c.employeeid
                    join salesarea i on i.salesareaid = d.salesareaid
                    where a.recordstatus = 3 and f.sloccode like '%" . $sloc . "%' and c.companyid = " . $companyid . " 
                    and h.fullname like '%" . $sales . "%' and i.areaname like '%" . $salesarea . "%' and g.productname like '%" . $product . "%' 
                    and a.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Customer')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fullname']);
      $line++;
      $sql1        = "select distinct b.materialgroupid,b.materialgroupcode,b.description  
													from giretur zd
													join giheader zb on zb.giheaderid = zd.giheaderid 
													join gireturdetail ze on ze.gireturid = zd.gireturid
													join soheader za on za.soheaderid = zb.soheaderid
													join product zf on zf.productid = ze.productid
													join addressbook zg on zg.addressbookid = za.addressbookid
													join employee zh on zh.employeeid = za.employeeid
													join salesarea zi on zi.salesareaid = zg.salesareaid
													join sloc zj on zj.slocid = ze.slocid
													join productplant a on a.productid = ze.productid
													join materialgroup b on b.materialgroupid = a.materialgroupid
													where zd.recordstatus = 3 and za.companyid = " . $companyid . " and zg.addressbookid = " . $row['addressbookid'] . "
													and zh.fullname like '%" . $sales . "%' and zf.productname like '%" . $product . "%' and zj.sloccode like '%" . $sloc . "%'
													and zi.areaname like '%" . $salesarea . "%' and zd.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
													and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['description']);
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
        $line++;
        $i           = 0;
        $totalqty    = 0;
        $sql2        = "select distinct za.productid,ze.productname,zk.uomcode,
														(select sum(zzb.qty)
														from gireturdetail zzb 
														join giretur zzc on zzc.gireturid = zzb.gireturid
														where zzb.productid = za.productid
														and zzb.slocid = za.slocid
														and zzc.recordstatus = 3
														) as qty
														from gireturdetail za 
														join giretur zb on zb.gireturid = za.gireturid
														join giheader zc on zc.giheaderid = zb.giheaderid
														join soheader zd on zd.soheaderid = zc.soheaderid
														join product ze on ze.productid = za.productid
														join addressbook zf on zf.addressbookid = zd.addressbookid
														join employee zg on zg.employeeid = zd.employeeid
														join salesarea zh on zh.salesareaid = zf.salesareaid
														join productplant zi on zi.productid = za.productid
														join sloc zj on zj.slocid = za.slocid
														join unitofmeasure zk on zk.unitofmeasureid = za.uomid 
														where zb.recordstatus = 3 and zd.companyid = " . $companyid . " and zf.addressbookid = " . $row['addressbookid'] . "
														and zg.fullname like '%" . $sales . "%' and zh.areaname like '%" . $salesarea . "%' and zj.sloccode like '%" . $sloc . "%' 
														and ze.productname like '%" . $product . "%' and zi.materialgroupid = " . $row1['materialgroupid'] . " 
														and zb.gireturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
														and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row2['productname'])->setCellValueByColumnAndRow(2, $line, $row2['uomcode'])->setCellValueByColumnAndRow(3, $line, $row2['qty']);
          $line++;
          $totalqty += $row2['qty'];
        }
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
        $line++;
        $line += 1;
      }
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //14
	public function RincianTerimaBarangPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rincianterimabarangperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct b.grheaderid,b.grno,c.fullname as supplier,b.grdate,a.pono
                    from grheader b 
                    join poheader a on a.poheaderid = b.poheaderid
                    join addressbook c on c.addressbookid=a.addressbookid
										join grdetail e on e.grheaderid = b.grheaderid
										join sloc f on f.slocid = e.slocid
                    join product g on g.productid = e.productid
                    where b.recordstatus = 3 and f.sloccode like '%" . $sloc . "%' and b.grno is not null 
                    and a.companyid = " . $companyid . " and g.productname like '%" . $product . "%'
                    and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['grno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, ': ' . $row['grdate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Supplier')->setCellValueByColumnAndRow(1, $line, ': ' . $row['supplier'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Nomor PO')->setCellValueByColumnAndRow(4, $line, ': ' . $row['pono']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
      $line++;
      $sql1        = "select zd.productid,zd.productname,zf.uomcode,za.itemtext,zb.headernote,za.qty
                        from grdetail za
                        join grheader zb on zb.grheaderid = za.grheaderid
                        join poheader zc on zc.poheaderid = zb.poheaderid
                        join product zd on zd.productid = za.productid
                        join sloc ze on ze.slocid = za.slocid
                        join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
                        where zb.recordstatus = 3 and zd.productname like '%" . $product . "%'
                        and ze.sloccode like '%" . $sloc . "%' and za.grheaderid = " . $row['grheaderid'] . " ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan')->setCellValueByColumnAndRow(2, $line, ': ' . $row1['headernote']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //15
	public function RekapTerimaBarangPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapterimabarangperbarang';
    parent::actionDownxls();
    $sql        = "select distinct zg.materialgroupid,zg.materialgroupcode,zg.description 
                    from grdetail za
                    join grheader zb on zb.grheaderid = za.grheaderid
                    join poheader zc on zc.poheaderid = zb.poheaderid
                    join product zd on zd.productid = za.productid
                    join sloc ze on ze.slocid = za.slocid
                    join productplant zf on zf.productid = za.productid and zf.slocid = za.slocid
                    join materialgroup zg on zg.materialgroupid = zf.materialgroupid
                    where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
                    and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
                    and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct za.productid,zd.productname,zf.uomcode,
                        (
                        select sum(zzb.qty)
                        from grdetail zzb 
                        join grheader zzc on zzc.grheaderid = zzb.grheaderid
                        where zzb.productid = za.productid
                        and zzb.slocid = za.slocid
                        and zzc.recordstatus = 3
                        ) as qty
                        from grdetail za 
                        join grheader zb on zb.grheaderid = za.grheaderid
                        join poheader zc on zc.poheaderid = zb.poheaderid
                        join product zd on zd.productid = za.productid
                        join sloc ze on ze.slocid = za.slocid
                        join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
                        join productplant zg on zg.productid = za.productid 
                        where zb.recordstatus = 3 and zc.companyid = " . $companyid . " and zg.materialgroupid = '" . $row['materialgroupid'] . "'
                        and zd.productname like '%" . $product . "%' and ze.sloccode like '%" . $sloc . "%' 
                        and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
												and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line++;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //16
	public function RekapTerimaBarangPerSupplierXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapterimabarangpersupplier';
    parent::actionDownxls();
    $sql        = "select distinct zf.addressbookid,zf.fullname as supplier 
                    from grdetail za
                    join grheader zb on zb.grheaderid = za.grheaderid
                    join poheader zc on zc.poheaderid = zb.poheaderid
                    join product zd on zd.productid = za.productid
                    join sloc ze on ze.slocid = za.slocid
                    join addressbook zf on zf.addressbookid = zc.addressbookid
                    where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
                    and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
                    and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $sql1        = "select distinct zg.materialgroupid,zg.materialgroupcode,zg.description,ze.sloccode 
															from grdetail za
															join grheader zb on zb.grheaderid = za.grheaderid
															join poheader zc on zc.poheaderid = zb.poheaderid
															join product zd on zd.productid = za.productid
															join sloc ze on ze.slocid = za.slocid
															join productplant zf on zf.productid = za.productid
															join materialgroup zg on zg.materialgroupid = zf.materialgroupid
															join addressbook zh on zh.addressbookid = zc.addressbookid
															where zb.recordstatus = 3 and zh.addressbookid = " . $row['addressbookid'] . "
															and ze.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%' and zc.companyid = " . $companyid . "
															and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
															and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Supplier')->setCellValueByColumnAndRow(1, $line, ': ' . $row['supplier'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['description'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
        $line++;
        $sql2        = "select distinct za.productid,zd.productname,zf.uomcode,
																	(
																	select sum(zzb.qty)
																	from grdetail zzb 
																	join grheader zzc on zzc.grheaderid = zzb.grheaderid
																	where zzb.productid = za.productid
																	and zzb.slocid = za.slocid
																	and zzc.recordstatus = 3
																	) as qty
																	from grdetail za 
																	join grheader zb on zb.grheaderid = za.grheaderid
																	join poheader zc on zc.poheaderid = zb.poheaderid
																	join product zd on zd.productid = za.productid
																	join sloc ze on ze.slocid = za.slocid
																	join unitofmeasure zf on zf.unitofmeasureid = za.unitofmeasureid
																	join productplant zg on zg.productid = za.productid 
																	join addressbook zh on zh.addressbookid = zc.addressbookid
																	where zb.recordstatus = 3 and zc.companyid = " . $companyid . " 
																	and zg.materialgroupid = " . $row1['materialgroupid'] . " and zh.addressbookid = " . $row['addressbookid'] . "
																	and zd.productname like '%" . $product . "%' and ze.sloccode like '%" . $sloc . "%' 
																	and zb.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
																	and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productname";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        $totalqty    = 0;
        $i           = 0;
        foreach ($dataReader2 as $row2) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row2['productname'])->setCellValueByColumnAndRow(2, $line, $row2['uomcode'])->setCellValueByColumnAndRow(3, $line, $row2['qty']);
          $line++;
          $totalqty += $row2['qty'];
        }
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row1['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
        $line++;
        $line += 1;
      }
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //17
	public function RincianReturBeliPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rincianreturpembelianperdokumen';
    parent::actionDownxls();
    $sql        = "select a.grreturid,a.grreturno,c.fullname as supplier,a.grreturdate,d.slocid
                    from grretur a
                    left join poheader b on b.poheaderid=a.poheaderid
                    left join addressbook c on c.addressbookid=b.addressbookid
                    left join grreturdetail d on d.grreturid = a.grreturid
										left join sloc e on e.slocid = d.slocid
                    where a.grreturno is not null and e.sloccode like '%" . $sloc . "%' and b.companyid = " . $companyid . " and 
                    a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.productid in
										(select x.productid from productplant x join product xx on xx.productid = x.productid 
										where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['grreturno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, ': ' . $row['grreturdate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Supplier')->setCellValueByColumnAndRow(1, $line, ': ' . $row['supplier'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $sql1        = "select d.productname,e.uomcode,a.qty,a.itemnote,f.headernote 
														from grreturdetail a
														inner join grdetail b on b.grdetailid=a.grdetailid
														inner join podetail c on c.podetailid=a.podetailid
														inner join product d on d.productid=a.productid
														inner join unitofmeasure e on e.unitofmeasureid=a.uomid
														inner join grretur f on f.grreturid=a.grreturid
														where a.slocid = '" . $row['slocid'] . "' and a.grreturid = " . $row['grreturid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty'])->setCellValueByColumnAndRow(4, $line, $row1['itemnote']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan')->setCellValueByColumnAndRow(2, $line, ': ' . $row1['headernote']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //18
	public function RekapReturBeliPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    $this->menuname = 'rekapreturbeliperbarang';
    parent::actionDownxls();
    $sql        = "select distinct a.materialgroupid, a.materialgroupcode, a.description
                    from materialgroup a 
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join grreturdetail g on g.slocid = b.slocid
                    where f.companyid = " . $companyid . " and d.sloccode like '%" . $sloc . "%' and b.productid in
                    (select zd.productid 
                    from poheader za
                    join grheader zb on zb.poheaderid = za.poheaderid
                    join grdetail zc on zc.grheaderid = zb.grheaderid
                    join grreturdetail zd on zd.grdetailid = zc.grdetailid
                    join grretur zx on zx.grreturid = zd.grreturid
                    join product ze on ze.productid = zd.productid
                    where ze.productname like '%" . $product . "%' and za.companyid = " . $companyid . " and 
                    zx.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
    $command    = $this->connection->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')
          ->setCellValueByColumnAndRow(1, $line, ': ' . $row['description'])
          ->setCellValueByColumnAndRow(2, $line, '')
          ->setCellValueByColumnAndRow(3, $line, '')
          ->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, 'No')
            ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
            ->setCellValueByColumnAndRow(2, $line, 'Satuan')
            ->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct b.productname,c.uomcode,a.qty,e.materialgroupid 
                        from grreturdetail a
                        join grretur f on f.grreturid = a.grreturid
                        inner join product b on b.productid=a.productid
                        inner join unitofmeasure c on c.unitofmeasureid=a.uomid
                        inner join productplant d on d.productid=a.productid
                        inner join materialgroup e on e.materialgroupid=d.materialgroupid
                        join poheader g on g.poheaderid = f.poheaderid
                        where e.materialgroupid = '" . $row['materialgroupid'] . "' 
                        and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                        and g.companyid = {$companyid} and f.recordstatus=3 ";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line++;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //20
	public function PendinganFpbXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    $this->menuname = 'pendinganfpb';
    parent::actionDownxls();
     $sql        = "select distinct a.deliveryadviceid,a.dano,a.dadate as tanggal,b.description,b.sloccode,
					c.productplanno as spp,d.sono as so,e.productoutputno as op,a.headernote as note
					from deliveryadvice a
					left join sloc b on b.slocid = a.slocid
					left join productplan c on c.productplanid = a.productplanid 
					left join soheader d on d.soheaderid = a.soheaderid 
					left join productoutput e on e.productoutputid = a.productoutputid
					join deliveryadvicedetail f on f.deliveryadviceid = a.deliveryadviceid
                    left join sloc i on i.slocid = f.slocid
					join plant g on g.plantid = b.plantid
					join company h on h.companyid = g.companyid
					where a.recordstatus = 3 and h.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and i.sloccode like '%".$slocto."%' and
					a.dadate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and 
					f.productid in 
					(
					select za.productid
					from deliveryadvicedetail za
					join product zb on zb.productid = za.productid
					where za.deliveryadviceid = a.deliveryadviceid and 
					zb.productname like '%" . $product . "%' and
					za.giqty < za.qty
					)";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. FPB')->setCellValueByColumnAndRow(1, $line, ': ' . $row['dano'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'SPP')->setCellValueByColumnAndRow(4, $line, ': ' . $row['spp']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['tanggal'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'SO')->setCellValueByColumnAndRow(4, $line, ': ' . $row['so']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'OP')->setCellValueByColumnAndRow(4, $line, ': ' . $row['op']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'SLOC')->setCellValueByColumnAndRow(4, $line, ': ' . $row['sloccode'] . ' - ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Trf Qty')->setCellValueByColumnAndRow(4, $line, 'Pr Qty')->setCellValueByColumnAndRow(5, $line, 'Po Qty')->setCellValueByColumnAndRow(6, $line, 'Gr Qty')->setCellValueByColumnAndRow(7, $line, 'Selisih')->setCellValueByColumnAndRow(8, $line, 'Note');
      $line++;
       $sql1         = "select b.productname, a.qty,a.giqty,a.prqty,a.poqty,a.grqty,
						c.uomcode,a.itemtext,(a.qty-a.giqty) as selisih
                        from deliveryadvicedetail a 
                        join product b on b.productid = a.productid
                        join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
                        where b.productname like '%" . $product . "%' and a.deliveryadviceid = " . $row['deliveryadviceid'];
      $command1     = Yii::app()->db->createCommand($sql1);
      $dataReader1  = $command1->queryAll();
      $i            = 0;
      $totalqty     = 0;
      $totaltrf     = 0;
      $totalpr      = 0;
      $totalpo      = 0;
      $totalgr      = 0;
      $totalselisih = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i += 1)
            ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
            ->setCellValueByColumnAndRow(2, $line, $row1['qty'])
            ->setCellValueByColumnAndRow(3, $line, $row1['giqty'])
            ->setCellValueByColumnAndRow(4, $line, $row1['prqty'])
            ->setCellValueByColumnAndRow(5, $line, $row1['poqty'])
            ->setCellValueByColumnAndRow(6, $line, $row1['grqty'])
            ->setCellValueByColumnAndRow(7, $line, $row1['selisih'])
            ->setCellValueByColumnAndRow(8, $line, $row1['itemtext']);
        $line++;
        $totalqty += $row1['qty'];
        $totaltrf += $row1['giqty'];
        $totalpr += $row1['prqty'];
        $totalpo += $row1['poqty'];
        $totalgr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
        
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(2, $line, $totalqty)->setCellValueByColumnAndRow(3, $line, $totaltrf)->setCellValueByColumnAndRow(4, $line, $totalpr)->setCellValueByColumnAndRow(5, $line, $totalpo)->setCellValueByColumnAndRow(6, $line, $totalgr)->setCellValueByColumnAndRow(7, $line, $totalselisih);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, '')
          ->setCellValueByColumnAndRow(1, $line, '')
          ->setCellValueByColumnAndRow(2, $line, '')
          ->setCellValueByColumnAndRow(3, $line, '')
          ->setCellValueByColumnAndRow(4, $line, '')
          ->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row['note']);
      $line = $line +3;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //21
	public function PendinganFppXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'pendinganfpp';
    parent::actionDownxls();
    $sql        = "select distinct f.description,h.companyid,a.prno,a.prdate,a.headernote as note,a.prheaderid,a.headernote,b.dano
											from prheader a
											inner join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid
											inner join prmaterial c on c.prheaderid = a.prheaderid
											inner join sloc f on f.slocid = b.slocid
											inner join product g on g.productid = c.productid
											inner join plant h on h.plantid = f.plantid
											where a.recordstatus = 3 and c.poqty < c.qty and h.companyid = " . $companyid . " 
											and f.sloccode like '%" . $sloc . "%' and g.productname like '%" . $product . "%'
											and a.prdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
											and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. FPP')->setCellValueByColumnAndRow(1, $line, ': ' . $row['prno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Gudang')->setCellValueByColumnAndRow(4, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['prdate'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'No. FPB')->setCellValueByColumnAndRow(4, $line, ': ' . $row['dano']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Fr Qty')->setCellValueByColumnAndRow(4, $line, 'Po Qty')->setCellValueByColumnAndRow(5, $line, 'Gr Qty')->setCellValueByColumnAndRow(6, $line, 'Selisih')->setCellValueByColumnAndRow(7, $line, 'Note');
      $line++;
      $sql1         = "select d.productname, a.qty,a.poqty,a.grqty,
										(select sum(xx.qty) from deliveryadvicedetail xx
										where xx.deliveryadvicedetailid = a.deliveryadvicedetailid and xx.productid = a.productid) as daqty,
										e.uomcode,a.itemtext,(a.qty-a.poqty) as selisih
                    from prmaterial a
                    join prheader b on b.prheaderid = a.prheaderid
                    join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
                    join product d on d.productid = a.productid
                    join unitofmeasure e on e.unitofmeasureid = a.unitofmeasureid
                    join sloc f on f.slocid = c.slocid
                    where d.productname like '%" . $product . "%' and a.prheaderid = " . $row['prheaderid'] . "
                    and f.sloccode like '%" . $sloc . "%' and a.poqty < a.qty
                    and b.prdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i            = 0;
      $totalqty     = 0;
      $totaltrf     = 0;
      $totalda      = 0;
      $totalpo      = 0;
      $totalgr      = 0;
      $totalselisih = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['daqty'])->setCellValueByColumnAndRow(4, $line, $row1['poqty'])->setCellValueByColumnAndRow(5, $line, $row1['grqty'])->setCellValueByColumnAndRow(6, $line, $row1['selisih'])->setCellValueByColumnAndRow(7, $line, $row1['itemtext']);
        $line++;
        $totalqty += $row1['qty'];
        $totalda += $row1['daqty'];
        $totalpo += $row1['poqty'];
        $totalgr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total -> ' . $row['description'])->setCellValueByColumnAndRow(2, $line, $totalqty)->setCellValueByColumnAndRow(3, $line, $totalda)->setCellValueByColumnAndRow(4, $line, $totalpo)->setCellValueByColumnAndRow(5, $line, $totalgr)->setCellValueByColumnAndRow(6, $line, $totalselisih);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row['note']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //22
	public function RincianTransferGudangKeluarPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rinciantransfergudangkeluarperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct b.transstockid,b.transstockno,					
										(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = b.slocfromid) as fromsloc,
										(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = b.sloctoid) as tosloc,
										b.docdate,a.dano,c.description
                    from deliveryadvice a
                    join transstock b on b.deliveryadviceid=a.deliveryadviceid
                    join sloc c on c.slocid = b.slocfromid
                    join plant d on d.plantid = c.plantid
                    join transstockdet e on e.transstockid = b.transstockid
										where b.transstockno is not null and d.companyid = " . $companyid . " and b.recordstatus > (3-1) and 
										c.sloccode like '%" . $sloc . "%' and
										b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
										and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
										and e.productid in (select x.productid 
										from productplant x join product xx on xx.productid = x.productid 
										where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. TS')->setCellValueByColumnAndRow(1, $line, ': ' . $row['transstockno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Gudang Asal')->setCellValueByColumnAndRow(4, $line, ': ' . $row['fromsloc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. FPB')->setCellValueByColumnAndRow(1, $line, ': ' . $row['dano'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Gudang Tujuan')->setCellValueByColumnAndRow(4, $line, ': ' . $row['tosloc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Keterangan');
      $line++;
      $sql1        = "select c.productname, a.qty,d.uomcode,a.itemtext,e.headernote
                        from transstockdet a 
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join transstock e on e.transstockid=a.transstockid
                        where c.productname like '%" . $product . "%' and a.transstockid = " . $row['transstockid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, $row1['itemtext']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row1['headernote']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //23
	public function RekapTransferGudangKeluarPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekaptransfergudangkeluarperbarang';
    parent::actionDownxls();
    $sql        = "select distinct a.sloctoid,a.slocfromid,
								(select sloccode from sloc d where d.slocid = a.slocfromid) as fromsloccode,
								(select description from sloc d where d.slocid = a.slocfromid) as fromslocdesc,
								(select sloccode from sloc d where d.slocid = a.sloctoid) as tosloccode,	
								(select description from sloc d where d.slocid = a.sloctoid) as toslocdesc
								from transstock a
								join transstockdet b on b.transstockid = a.transstockid
								join product c on c.productid = b.productid
								join sloc e on e.slocid = a.slocfromid
								where a.recordstatus > (3-1) and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%'
								and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
								and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang Asal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fromsloccode'] . '-' . $row['fromslocdesc'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang Tujuan')->setCellValueByColumnAndRow(1, $line, ': ' . $row['tosloccode'] . '-' . $row['toslocdesc'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
													from transstockdet a
													join product b on b.productid = a.productid
													join transstock c on c.transstockid = a.transstockid
													join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
													join sloc e on e.slocid = c.slocfromid
													where c.recordstatus > (3-1) and c.slocfromid = " . $row['slocfromid'] . " and e.sloccode like '%" . $sloc . "%' 
													and c.sloctoid = " . $row['sloctoid'] . " and b.productname like '%" . $product . "%' 
													and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
													and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' group by productid,productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line++;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //24
	public function RincianTransferGudangMasukPerDokumenXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rinciantransfergudangmasukperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct b.transstockid,b.transstockno,					
											(select concat(z.sloccode,' - ',z.description) from sloc z where z.slocid = b.slocfromid) as fromsloc,
											(select concat(zz.sloccode,' - ',zz.description) from sloc zz where zz.slocid = b.sloctoid) as tosloc,
											b.docdate,a.dano
											from deliveryadvice a
											join transstock b on b.deliveryadviceid=a.deliveryadviceid
											join sloc c on c.slocid = b.sloctoid
											join plant d on d.plantid = c.plantid
											join transstockdet e on e.transstockid = b.transstockid
											where b.transstockno is not null and d.companyid = " . $companyid . " and b.recordstatus = 5 and 
											c.sloccode like '%" . $sloc . "%' and
											b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
											and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
											and e.productid in (select x.productid 
											from productplant x join product xx on xx.productid = x.productid 
											where xx.productname like '%" . $product . "%')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. TS')->setCellValueByColumnAndRow(1, $line, ': ' . $row['transstockno'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Gudang Asal')->setCellValueByColumnAndRow(4, $line, ': ' . $row['fromsloc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. FPB')->setCellValueByColumnAndRow(1, $line, ': ' . $row['dano'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, 'Gudang Tujuan')->setCellValueByColumnAndRow(4, $line, ': ' . $row['tosloc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan');
      $line++;
      $sql1        = "select c.productname, a.qty,d.uomcode,a.itemtext,e.headernote
                        from transstockdet a 
                        join product c on c.productid = a.productid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join transstock e on e.transstockid=a.transstockid
                        where c.productname like '%" . $product . "%' and a.transstockid = " . $row['transstockid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, '')->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row1['headernote']);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //25
	public function RekapTransferGudangMasukPerBarangXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekaptransfergudangmasukperbarang';
    parent::actionDownxls();
    $sql        = "select distinct a.sloctoid,a.slocfromid,
								(select sloccode from sloc d where d.slocid = a.slocfromid) as fromsloccode,
								(select description from sloc d where d.slocid = a.slocfromid) as fromslocdesc,
								(select sloccode from sloc d where d.slocid = a.sloctoid) as tosloccode,	
								(select description from sloc d where d.slocid = a.sloctoid) as toslocdesc
								from transstock a
								join transstockdet b on b.transstockid = a.transstockid
								join product c on c.productid = b.productid
								join sloc e on e.slocid = a.sloctoid
								where a.recordstatus = 5 and e.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
								and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
								and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang Asal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fromsloccode'] . '-' . $row['fromslocdesc'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang Tujuan')->setCellValueByColumnAndRow(1, $line, $row['tosloccode'] . '-' . $row['toslocdesc'])->setCellValueByColumnAndRow(2, $line, '')->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select a.productid,b.productname,d.uomcode,sum(a.qty) as qty
													from transstockdet a
													join product b on b.productid = a.productid
													join transstock c on c.transstockid = a.transstockid
													join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
													join sloc e on e.slocid = c.sloctoid
													where c.recordstatus = 5 and c.slocfromid = " . $row['slocfromid'] . " and e.sloccode like '%" . $sloc . "%' 
													and c.sloctoid = " . $row['sloctoid'] . " and b.productname like '%" . $product . "%' 
													and c.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
													and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
													group by productid,productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line++;
      $line += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //26
	public function RekapStokBarangAdaTransaksiXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'rekapstokbarangadatransaksi';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $sql2        = "select b.productid,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
							      g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3        = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar
                            from
                            (select 
                            (
                            select distinct aa.productname 
                            from productstockdet a
                            join product aa on aa.productid = a.productid
                            join sloc ab on ab.slocid = a.slocid
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            ) as barang,
                            (
                            select distinct bb.uomcode 
                            from productstockdet b
                            join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
                            join sloc ba on ba.slocid = b.slocid
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            join sloc aaw on aaw.slocid = aw.slocid
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            join sloc cc on cc.slocid = c.slocid
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            join sloc dd on dd.slocid = d.slocid
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            join sloc ee on ee.slocid = e.slocid
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            join sloc ff on ff.slocid = f.slocid
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            join sloc gg on gg.slocid = g.slocid
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            join sloc hh on hh.slocid = h.slocid
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            join sloc ii on ii.slocid = i.slocid
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            join sloc jj on jj.slocid = j.slocid
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            join sloc kk on kk.slocid = k.slocid
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            join sloc ll on ll.slocid = l.slocid
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            join sloc mm on mm.slocid = m.slocid
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . " order by barang') z) zz )zzz 
							where masuk <> 0 or keluar <> 0 
							order by barang asc";
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }
	//33
	public function RekapKonversiPerDokumentBelumStatusMaxXLS($companyid, $sloc, $slocto, $storagebin, $customer, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
 {
    $this->menuname = 'RekapKonversiPerDokumentBelumStatusMax';
    parent::actionDownxls();
    $sql        = "select distinct a.productconvertid,a.qty,a.recordstatus,d.productname,e.uomcode,f.sloccode,Getwfstatusbywfname('appconvert',a.recordstatus) as statusname
								from productconvert a
								join productconvertdetail b on b.productconvertid = a.productconvertid
								join productconversion c on c.productconversionid = a.productconversionid
								join product d on c.productid = d.productid
								join unitofmeasure e on e.unitofmeasureid = a.uomid
								join sloc f on f.slocid = a.slocid
								join plant g on g.plantid = f.plantid
								where  a.recordstatus between 1 and (3-1)
								and g.companyid = ".$companyid."
								and d.productname like '%" . $product . "%'
								and f.sloccode like '%" . $sloc . "%'
								and date(a.createddate) between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								order by a.recordstatus";
    $command    = $this->connection->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
      ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
     
    $line = 4;
    
      $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(0, $line, 'No')
      ->setCellValueByColumnAndRow(1, $line, 'ID')
      ->setCellValueByColumnAndRow(2, $line, 'Material/Service')
      ->setCellValueByColumnAndRow(3, $line, 'QTY')
      ->setCellValueByColumnAndRow(4, $line, 'Gudang')
      ->setCellValueByColumnAndRow(5, $line, 'Satuan')
      ->setCellValueByColumnAndRow(6, $line, 'Status');
      $line++;
     $i=1;
      foreach ($dataReader as $row) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i += 1)
            ->setCellValueByColumnAndRow(1, $line, $row['productconvertid'])
            ->setCellValueByColumnAndRow(2, $line, $row['productname'])
            ->setCellValueByColumnAndRow(3, $line, $row['qty'])
            ->setCellValueByColumnAndRow(4, $line, $row['sloccode'])
            ->setCellValueByColumnAndRow(5, $line, $row['uomcode'])
            ->setCellValueByColumnAndRow(6, $line, $row['statusname']);
        $line++;
        
      }
      
    $this->getFooterXLS($this->phpExcel);
  }
	//39
	public function LaporanKetersediaanBarangXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
	{
			$this->menuname = 'laporanketersediaanbarang';
			parent::actionDownxls();
			
			$sql        = "select *
									from (SELECT b.productname, b.sloccode, b.uomcode,a.minstock,a.maxvalue,SUM(b.qty) as qty,SUM(b.qty)-a.minstock as tomin,SUM(b.qty)-a.maxvalue as tomax
									FROM mrp a
									LEFT JOIN productstock b ON b.productid = a.productid AND b.unitofmeasureid = a.uomid AND a.slocid = b.slocid 
									LEFT JOIN product c on c.productid = a.productid
									LEFT JOIN sloc d on d.slocid = a.slocid
									LEFT JOIN plant e on e.plantid = d.plantid
										WHERE a.recordstatus = 1 and e.companyid = ".$companyid."
										AND b.sloccode like '%".$sloc."%'
										AND b.productname like '%".$product ."%'
									GROUP By  b.productid) z
									order by sloccode,tomin
									 -- HAVING qty <= a.reordervalue";
			$command    = Yii::app()->db->createCommand($sql);
			$dataReader = $command->queryAll();
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
			
			$line = 3;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $line, 'Nama Barang')
					->setCellValueByColumnAndRow(1, $line, 'Gudang')
					->setCellValueByColumnAndRow(2, $line, 'Satuan')
					->setCellValueByColumnAndRow(3, $line, 'Min')
					->setCellValueByColumnAndRow(4, $line, 'Max')
					->setCellValueByColumnAndRow(5, $line, 'Stock')
					->setCellValueByColumnAndRow(6, $line, 'To Min')
					->setCellValueByColumnAndRow(7, $line, 'To Max');
			$line++;
			
			foreach($dataReader as $row) {
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0, $line, $row['productname'])
							->setCellValueByColumnAndRow(1, $line, $row['sloccode'])
							->setCellValueByColumnAndRow(2, $line, $row['uomcode'])
							->setCellValueByColumnAndRow(3, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['minstock']))
							->setCellValueByColumnAndRow(4, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['minstock']))
							->setCellValueByColumnAndRow(5, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['qty']))
							->setCellValueByColumnAndRow(6, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['tomin']))
							->setCellValueByColumnAndRow(7, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['tomax']));
					$line++;
			}
			
			
			$this->getFooterXLS($this->phpExcel);
	}
	//40
	public function LaporanMaterialNotMovingXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'Laporanmaterialnotmoving';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
          $sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3 = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "') z) zz) zzz 
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 =0 order by keluar2 asc";
          $command3    = Yii::app()->db->createCommand($sql3);
          $dataReader3 = $command3->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalmasuk;
        $totalkeluar1 += $totalkeluar;
        $totalakhir1 += $totalakhir;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalmasuk1;
      $totalkeluar2 += $totalkeluar1;
      $totalakhir2 += $totalakhir1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }
	//41
	public function LaporanMaterialSlowMovingXLS($companyid, $sloc, $slocto,$storagebin, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'Laporanmaterialslowmoving';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
     
          $sql3        = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where  u.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					        v.slocid = '" . $row['slocid'] . "' group by barang ) z) zz )zzz 
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 > - " . $keluar3 . "  order by keluar2 asc";
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }      
  //42
	public function LaporanMaterialFastMovingXLS($companyid, $sloc, $slocto,$storagebin, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'Laporanmaterialfastmoving';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
     
          $sql3        = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,keluar2
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,(jual+returbeli+trfout+pemakaian+konversiout) as keluar2
                            from
                            (select 
                            (
                            select distinct a.productname 
                            from productstockdet a
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
														limit 1
                            ) as barang,
                            (
                            select distinct b.uomcode 
                            from productstockdet b
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
														limit 1
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where  u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . " order by keluar2') z) zz )zzz 
							where (awal <> 0 or masuk <> 0  or akhir <> 0 or keluar <> 0) and keluar2 < - " . $keluar3 . "  order by keluar2 asc";
					$dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
          }
        
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalawal;
        $totalkeluar1 += $totalawal;
        $totalakhir1 += $totalawal;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalawal1;
      $totalkeluar2 += $totalawal1;
      $totalakhir2 += $totalawal1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2);
    $this->getFooterXLS($this->phpExcel);
  }    
	//43
	public function LaporanHarianXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate, $keluar3)
  {
    $this->menuname = 'laporanharian';
    parent::actionDownxls();
    $awal2      = 0;
    $masuk2     = 0;
    $keluar2    = 0;
    $akhir2     = 0;
    $sql        = "select distinct c.sloccode,c.slocid
                 from materialgroup a
                 join productplant b on b.materialgroupid=a.materialgroupid
				 join sloc c on c.slocid = b.slocid
                 join storagebin g on g.slocid = c.slocid
				 join plant d on d.plantid = c.plantid
				 join company e on e.companyid = d.companyid
				 join product f on f.productid = b.productid
                 where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
				 f.productname like '%" . $product . "%' and g.description like '%".$storagebin."%'
                 and c.recordstatus=1";
    $command    = $this->connection->createCommand($sql);
    $companycode = Yii::app()->db->createCommand("select companycode from company where companyid=".$companyid)->queryScalar();
    $maxso = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appso')")->queryScalar();
    $maxgi = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgi')")->queryScalar();
    $maxscanop = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appscanhp')")->queryScalar();
    $dataReader = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, 1, "LAPORAN STOCK FINISHED GOODS PT. {$companycode} PER TANGGAL : ".date(Yii::app()->params['dateviewfromdb'],strtotime($enddate)));
    $line=3;
    foreach ($dataReader as $row) {
      $awal1   = 0;
      $masuk1  = 0;
      $keluar1 = 0;
      $akhir1  = 0;
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
				    join sloc c on c.slocid = b.slocid
				    join plant d on d.plantid = c.plantid
				    join company e on e.companyid = d.companyid
				    join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and c.slocid = '" . $row['slocid'] . "' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstock z
                    where z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue
                    and z.storagedesc like '%".$storagebin."%' and z.qty <> 0)";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, 'Gudang : ')
                    ->setCellValueByColumnAndRow(2, $line, $row['sloccode']);
      $line++;
      foreach ($dataReader1 as $row1) {
        $awal   = 0;
        $masuk  = 0;
        $keluar = 0;
        $akhir  = 0;
        
        $this->phpExcel->setActiveSheetIndex(0)->getRowDimension($line)->setRowHeight(25);
        $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, 'Material Group')
                    ->setCellValueByColumnAndRow(2, $line, $row['sloccode']);
        $line++;
        /*$sql2        = "select distinct b.productid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.sloccode like '%" . $sloc . "%' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
					g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue and z.storagedesc like '%".$storagebin."%') limit 10";
        $command2    = $this->connection->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
        */
            $sql3 = "select *,if(akhir >= pendinganso, pendinganso, akhir) as qtygis from (select distinct b.productname,f.uomcode,
                (select sum(qty)
                from productstockdet za 
                where za.productid = b.productid and za.slocid = a.slocid and za.unitofmeasureid = a.unitofissue and za.transdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and za.storagedesc like '%".$storagebin."%' ) as akhir,
                ifnull((select datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."',datehp) as umur from tempscan ca 
                where ca.productid = b.productid and ca.slocid = c.slocid 
                and isapprovehp={$maxscanop} and transstockid is not null and soheaderid is null and giheaderid is null and isapprovegi=0 order by datehp desc 
                limit 1),datediff('".date(Yii::app()->params['datetodb'], strtotime($enddate))."','2019-09-01')) as umur,
                (select ifnull((select reordervalue from mrp a1 where a1.productid = b.productid and a1.slocid = a.slocid and a1.uomid = a.unitofissue and a1.recordstatus=1),0)) as buffer,
                (select ifnull(sum(qty-giqty),0)
                from sodetail a2 
                join soheader b2 on b2.soheaderid = a2.soheaderid
                where b2.companyid={$companyid} and b2.recordstatus={$maxso} and b2.sodate = '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                and a2.productid = b.productid
                and a2.qty > a2.giqty) qtyso,
                (select ifnull(sum(qty-giqty),0)
                from sodetail a3 
                join soheader b3 on b3.soheaderid = a3.soheaderid
                where b3.companyid={$companyid} and b3.recordstatus={$maxso} and b3.sodate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                and a3.productid = b.productid
                and a3.qty > a3.giqty) pendinganso,
                (select ifnull(sum(qty) ,0)
                from gidetail a4 
                join giheader b4 on b4.giheaderid = a4.giheaderid
                where b4.companyid = {$companyid} and b4.recordstatus={$maxgi} and b4.gidate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a4.productid = b.productid) as qtygi,
                (select ifnull(sum(qtyori),0)
                from tempscan a5
                where a5.productid = b.productid 
                and a5.productoutputid is not null and a5.productoutputfgid is not null and a5.isapprovehp={$maxscanop} and a5.isean=0 and a5.transstockid is not null and a5.transstockdetid is not null and datehp = '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') as qtyscan
                from materialgroup e 
                join productplant a on a.materialgroupid = e.materialgroupid
                join product b on b.productid = a.productid
                join sloc c on c.slocid = a.slocid
                -- join storagebin d on d.slocid = c.slocid
                join unitofmeasure f on f.unitofmeasureid = a.unitofissue
                where c.slocid = {$row['slocid']} and a.recordstatus = 1 
                and e.materialgroupid = {$row1['materialgroupid']} and b.productname like '%".$product."%'
                and b.productid in (select productid za
                from productstock za 
                where za.storagedesc like '%".$storagebin."%' and za.unitofmeasureid = a.unitofissue and za.slocid = c.slocid))z
                where akhir<>0 or qtyso <> 0 or pendinganso <> 0 or qtygi <> 0 or qtyscan <> 0 ";
            $command3    = $this->connection->createCommand($sql3);
          
          $dataReader3 = $command3->queryAll();
            foreach ($dataReader3 as $row3) {
                $this->phpExcel->setActiveSheetIndex(0)->getRowDimension($line)->setRowHeight(40);
                $this->phpExcel->setActiveSheetIndex(0)
                     ->setCellValueByColumnAndRow(0, $line, $row3['productname'])
                     ->setCellValueByColumnAndRow(1, $line, $row3['uomcode'])
                     ->setCellValueByColumnAndRow(2, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['akhir']))
                     ->setCellValueByColumnAndRow(3, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['umur']))
                     ->setCellValueByColumnAndRow(4, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['buffer']))
                     ->setCellValueByColumnAndRow(5, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtyso']))
                     ->setCellValueByColumnAndRow(6, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['pendinganso']))
                     ->setCellValueByColumnAndRow(7, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtygis']))
                     ->setCellValueByColumnAndRow(8, $line, Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qtyscan']));
                     
                $line++;
            //}
        }
        $line++;
      }
    }
      
    $this->getFooterXLS($this->phpExcel);
  }
	//44
  public function LaporanRekapMonitoringStockXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    $this->menuname = 'rekapstokbarang';
    parent::actionDownxls();
    $sql        = "select distinct c.sloccode,c.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
					join sloc c on c.slocid = b.slocid
					join plant d on d.plantid = c.plantid
					join company e on e.companyid = d.companyid
					join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.sloccode like '%" . $sloc . "%' and 
					f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalakhir2  = 0;
    $pendingfpp2     = 0;
    $pendingpo2     = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Satuan')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir')->setCellValueByColumnAndRow(6, $line, 'Pending FPP')->setCellValueByColumnAndRow(7, $line, 'Pending PO');
      $sql1        = "select distinct a.description as divisi,a.materialgroupid
                    from materialgroup a
                    join productplant b on b.materialgroupid=a.materialgroupid
										join sloc c on c.slocid = b.slocid
										join plant d on d.plantid = c.plantid
										join company e on e.companyid = d.companyid
										join product f on f.productid = b.productid
                    where e.companyid = " . $companyid . " and c.slocid = '" . $row['slocid'] . "' and 
										f.productname like '%" . $product . "%' and f.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = c.slocid and z.unitofmeasureid = b.unitofissue)";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'GUDANG')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalakhir1  = 0;
      $pendingfpp1  = 0;
      $pendingpo1  = 0;
      foreach ($dataReader1 as $row1) {
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row1['divisi'])->setCellValueByColumnAndRow(5, $line, $row['sloccode']);
        $totalawal   = 0;
        $totalmasuk  = 0;
        $totalkeluar = 0;
        $totalakhir  = 0;
        $pendingfpp = 0;
        $pendingpo = 0;
        $sql2        = "select distinct b.productid,a.materialgroupid,a.description as divisi,d.slocid
                    from materialgroup a
                    join productplant b on b.materialgroupid = a.materialgroupid
                    join sloc d on d.slocid = b.slocid
                    join plant e on e.plantid = d.plantid
                    join company f on f.companyid = e.companyid
                    join product g on g.productid = b.productid
                    where f.companyid = '" . $companyid . "' and d.slocid = '" . $row['slocid'] . "' and a.materialgroupid = '" . $row1['materialgroupid'] . "' and 
							      g.productname like '%" . $product . "%' and b.productid in
                    (select z.productid 
                    from productstockdet z
                    join sloc za on za.slocid = z.slocid
                    join plant zb on zb.plantid = za.plantid
                    join company zc on zc.companyid = zb.companyid
                    where zc.companyid = " . $companyid . " and z.slocid = b.slocid and z.unitofmeasureid = b.unitofissue)";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
          $sql3        = "select * from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,pendingfpp,pendingpo
                            from
                            (select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,pendingfpp,pendingpo
                            from
                            (select 
                            (
                            select distinct aa.productname 
                            from productstockdet a
                            join product aa on aa.productid = a.productid
                            join sloc ab on ab.slocid = a.slocid
                            where a.productid = t.productid and
                            a.unitofmeasureid = t.unitofissue
                            ) as barang,
                            (
                            select distinct bb.uomcode 
                            from productstockdet b
                            join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
                            join sloc ba on ba.slocid = b.slocid
                            where b.productid = t.productid and
                            b.unitofmeasureid = t.unitofissue
                            ) as satuan,
                            (
                            select ifnull(sum(aw.qty),0) 
                            from productstockdet aw
                            join sloc aaw on aaw.slocid = aw.slocid
                            where aw.productid = t.productid and
                            aw.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and
                            aw.slocid = t.slocid
                            ) as awal,
                            (
                            select ifnull(sum(c.qty),0) 
                            from productstockdet c
                            join sloc cc on cc.slocid = c.slocid
                            where c.productid = t.productid and
                            c.referenceno like 'GR-%' and
                            c.slocid = t.slocid and
                            c.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as beli,
                            (
                            select ifnull(sum(d.qty),0) 
                            from productstockdet d
                            join sloc dd on dd.slocid = d.slocid
                            where d.productid = t.productid and
                            d.referenceno like 'GIR-%' and
                            d.slocid = t.slocid and
                            d.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returjual,
                            (
                            select ifnull(sum(e.qty),0) 
                            from productstockdet e
                            join sloc ee on ee.slocid = e.slocid
                            where e.productid = t.productid and
                            e.referenceno like 'TFS-%' and
                            e.qty > 0 and
                            e.slocid = t.slocid and
                            e.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfin,
                            (
                            select ifnull(sum(f.qty),0) 
                            from productstockdet f
                            join sloc ff on ff.slocid = f.slocid
                            where f.productid = t.productid and
                            f.referenceno like 'OP-%' and
                            f.qty > 0 and
                            f.slocid = t.slocid and
                            f.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as produksi,
                            (
                            select ifnull(sum(g.qty),0) 
                            from productstockdet g
                            join sloc gg on gg.slocid = g.slocid
                            where g.productid = t.productid and
                            g.referenceno like 'SJ-%' and
                            g.slocid = t.slocid and
                            g.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as jual,
                            (
                            select ifnull(sum(h.qty),0) 
                            from productstockdet h
                            join sloc hh on hh.slocid = h.slocid
                            where h.productid = t.productid and
                            h.referenceno like 'GRR-%' and
                            h.slocid = t.slocid and
                            h.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as returbeli,
                            (
                            select ifnull(sum(i.qty),0) 
                            from productstockdet i
                            join sloc ii on ii.slocid = i.slocid
                            where i.productid = t.productid and
                            i.referenceno like 'TFS-%' and
                            i.qty < 0 and
                            i.slocid = t.slocid and
                            i.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as trfout,
                            (
                            select ifnull(sum(j.qty),0) 
                            from productstockdet j
                            join sloc jj on jj.slocid = j.slocid
                            where j.productid = t.productid and
                            j.referenceno like 'OP-%' and
                            j.qty < 0 and
                            j.slocid = t.slocid and
                            j.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as pemakaian,
                            (
                            select ifnull(sum(k.qty),0) 
                            from productstockdet k
                            join sloc kk on kk.slocid = k.slocid
                            where k.productid = t.productid and
                            k.referenceno like 'TSO-%' and
                            k.slocid = t.slocid and
                            k.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as koreksi,
							(select ifnull(sum(l.qty),0) 
                            from productstockdet l
                            join sloc ll on ll.slocid = l.slocid
                            where l.productid = t.productid and
                            l.referenceno like '%konversi%' and
                            l.qty > 0 and
                            l.slocid = t.slocid
							and l.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiin,
							(
                            select ifnull(sum(m.qty),0) 
                            from productstockdet m
                            join sloc mm on mm.slocid = m.slocid
                            where m.productid = t.productid and
                            m.referenceno like '%konversi%' and
                            m.qty < 0 and
                            m.slocid = t.slocid and
                            m.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                            ) as konversiout,
                            ifnull((
                            select sum(a.qty) - sum(a.poqty) as pendingfpp
                            from prmaterial a
                            join prheader b on b.prheaderid = a.prheaderid
                            join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
                            where c.slocid = {$row['slocid']}  and a.productid = t.productid
                            and b.recordstatus=3
                            -- and b.prdate between '2019-10-14' and 
                            having pendingfpp > 0
                            ),0) as pendingfpp,
                            ifnull((
                            select sum(poqty) - sum(qtyres) as pendingpo
                            from podetail `xa` 
                            join poheader xb on xb.poheaderid = `xa`.poheaderid
                            where `xa`.productid = t.productid and `xa`.slocid = {$row['slocid']}
                            and xb.recordstatus=5
                            having pendingpo > 0 
                            ),0) as pendingpo
                            from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
                            where t.productid = '" . $row2['productid'] . "' and u.materialgroupid = '" . $row1['materialgroupid'] . "' 
							and v.slocid = '" . $row['slocid'] . "' and t.recordstatus=1 order by barang) z) zz )zzz 
							where awal <> 0 or masuk <> 0 or keluar <> 0 or akhir <> 0 
							order by barang asc";
          $command3    = Yii::app()->db->createCommand($sql3);
          $dataReader3 = $command3->queryAll();
          foreach ($dataReader3 as $row3) {
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $row3['barang'])->setCellValueByColumnAndRow(1, $line, $row3['satuan'])->setCellValueByColumnAndRow(2, $line, $row3['awal'])->setCellValueByColumnAndRow(3, $line, $row3['masuk'])->setCellValueByColumnAndRow(4, $line, $row3['keluar'])->setCellValueByColumnAndRow(5, $line, $row3['akhir'])->setCellValueByColumnAndRow(6, $line, $row3['pendingfpp'])->setCellValueByColumnAndRow(7, $line, $row3['pendingpo']);
            $totalawal += $row3['awal'];
            $totalmasuk += $row3['masuk'];
            $totalkeluar += $row3['keluar'];
            $totalakhir += $row3['akhir'];
            $pendingfpp += $row3['pendingfpp'];
            $pendingpo += $row3['pendingpo'];
          }
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total Material Group ' . $row1['divisi'])->setCellValueByColumnAndRow(2, $line, $totalawal)->setCellValueByColumnAndRow(3, $line, $totalmasuk)->setCellValueByColumnAndRow(4, $line, $totalkeluar)->setCellValueByColumnAndRow(5, $line, $totalakhir)->setCellValueByColumnAndRow(6, $line, $pendingfpp)->setCellValueByColumnAndRow(7, $line, $pendingpo);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalmasuk;
        $totalkeluar1 += $totalkeluar;
        $totalakhir1 += $totalakhir;
        $pendingfpp1 += $pendingfpp;
        $pendingpo1 += $pendingpo;
        $line += 1;
      }
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Total Gudang ' . $row['sloccode'])->setCellValueByColumnAndRow(2, $line, $totalawal1)->setCellValueByColumnAndRow(3, $line, $totalmasuk1)->setCellValueByColumnAndRow(4, $line, $totalkeluar1)->setCellValueByColumnAndRow(5, $line, $totalakhir1)->setCellValueByColumnAndRow(6, $line, $pendingfpp1)->setCellValueByColumnAndRow(7, $line, $pendingpo1);
      $totalawal2 += $totalawal1;
      $totalmasuk2 += $totalmasuk1;
      $totalkeluar2 += $totalkeluar1;
      $totalakhir2 += $totalakhir1;
      $pendingfpp2 += $pendingfpp1;
      $pendingpo2 += $pendingpo1;
      $line += 2;
    }
    $line++;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalawal2)->setCellValueByColumnAndRow(3, $line, $totalmasuk2)->setCellValueByColumnAndRow(4, $line, $totalkeluar2)->setCellValueByColumnAndRow(5, $line, $totalakhir2)->setCellValueByColumnAndRow(6, $line, $pendingfpp2)->setCellValueByColumnAndRow(7, $line, $pendingpo2);
    $this->getFooterXLS($this->phpExcel);
  }
  //45
  public function LaporanRincianMonitoringStockXLS($companyid, $sloc, $slocto, $storagebin, $sales, $product, $salesarea, $startdate, $enddate)
  {
    $this->menuname = 'rincianmonitoringstock';
    parent::actionDownxls();
    $sql        = "select distinct a.description,a.materialgroupid
									from materialgroup a
									join productplant b on b.materialgroupid=a.materialgroupid
									join sloc c on c.slocid = b.slocid
									join plant d on d.plantid = c.plantid
									join company e on e.companyid = d.companyid
									join product f on f.productid = b.productid
									where e.companyid = " . $companyid . " and f.productid in
									(select z.productid 
									from productstockdet z
									join sloc za on za.slocid = z.slocid
									join plant zb on zb.plantid = za.plantid
									join company zc on zc.companyid = zb.companyid
									join product zd on zd.productid = z.productid
									where zc.companyid = " . $companyid . " and z.slocid = b.slocid 
									and za.sloccode like '%" . $sloc . "%' and zd.productname like '%" . $product . "%'
									and z.storagedesc like '%".$storagebin."%' )
									order by description";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $totalawal2   = 0;
    $totalmasuk2  = 0;
    $totalkeluar2 = 0;
    $totalsaldo2  = 0;
    $line         = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Nama Barang')->setCellValueByColumnAndRow(1, $line, 'Gudang')->setCellValueByColumnAndRow(2, $line, 'Awal')->setCellValueByColumnAndRow(3, $line, 'Masuk')->setCellValueByColumnAndRow(4, $line, 'Keluar')->setCellValueByColumnAndRow(5, $line, 'Akhir');
      $totalawal1   = 0;
      $totalmasuk1  = 0;
      $totalkeluar1 = 0;
      $totalsaldo1  = 0;
      $sql1        = "select productid,productname,slocid,sloccode,sum(masuk) as masuk ,sum(keluar) as keluar,awal, awal + (sum(masuk) + sum(keluar)) as saldo  from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,masuk,keluar,(awal+masuk+keluar) as saldo
				from
				(select productid,productname,awal,dokumen,tanggal,slocid,sloccode,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+konversiout+koreksi) as keluar
				from
				(select productid,productname,referenceno as dokumen, transdate as tanggal,slocid,sloccode,awal,
				case when instr(referenceno,'GR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as beli,
				case when instr(referenceno,'GIR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returjual,
				case when (instr(referenceno,'TFS-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as trfin,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as produksi,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty > 0) then qty else 0 end as konversiin,
				case when instr(referenceno,'SJ-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as jual,
				case when instr(referenceno,'GRR-') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as returbeli,
				case when (instr(referenceno,'TFS') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as trfout,
				case when (instr(referenceno,'OP-') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as pemakaian,
				case when (instr(referenceno,'konversi') > 0) and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and (qty < 0) then qty else 0 end as konversiout,
				case when instr(referenceno,'TSO') > 0 and (z.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
				'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') then qty else 0 end as koreksi
				from
				(select a.productid,g.productname,a.referenceno,a.transdate,a.qty,b.slocid,b.sloccode,
					(select ifnull(sum(x.qty),0) from productstockdet x
					where x.productid = a.productid and x.slocid = a.slocid and
				x.transdate < '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "') as awal
				from productstockdet a
				join sloc b on b.slocid = a.slocid
				join plant c on c.plantid = b.plantid
				join company d on d.companyid = c.companyid
				join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.unitofmeasureid
				join storagebin f on f.storagebinid=a.storagebinid
				join product g on g.productid=a.productid
				where d.companyid = " . $companyid . " and b.sloccode like '%" . $sloc . "%' and e.materialgroupid = '" . $row['materialgroupid'] . "'
                and a.storagedesc like '%".$storagebin."%'
				and g.productname like '%" . $product . "%' 
				-- and a.transdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                -- and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                ) z) zz) zzz) zzzz
                group by productname
				order by productname,sloccode";
      $command1     = Yii::app()->db->createCommand($sql1);
      $dataReader1  = $command1->queryAll();
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Material Group')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $totalawal   = 0;
      $totalmasuk  = 0;
      $totalkeluar = 0;
      $totalsaldo  = 0;
      foreach ($dataReader1 as $row1) {
        $totalpendingfpp = 0;
        $totalpendingpo = 0;
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $row1['productname'])
            ->setCellValueByColumnAndRow(1, $line, $row1['sloccode'])
            ->setCellValueByColumnAndRow(2, $line, $row1['awal'])
            ->setCellValueByColumnAndRow(3, $line, $row1['masuk'])
            ->setCellValueByColumnAndRow(4, $line, $row1['keluar'])
            ->setCellValueByColumnAndRow(5, $line, $row1['saldo']);
        $sql2 = "
            select * from (
            select 0 as pendingpo, '-' as pono, (a.qty) - (a.poqty) as pendingfpp, b.prno,a.prmaterialid
            from prmaterial a
            join prheader b on b.prheaderid = a.prheaderid
            join deliveryadvice c on c.deliveryadviceid = b.deliveryadviceid
            where c.slocid = {$row1['slocid']}  and a.productid = {$row1['productid']}
            and b.recordstatus=3
            and b.prdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
            '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
            and a.qty > a.poqty
            union
            select (poqty) - (qtyres) as pendingpo, xb.pono, 0 as pendingfpp, '-' as prno,`xa`.podetailid
            from podetail `xa` 
            join poheader xb on xb.poheaderid = `xa`.poheaderid
            where `xa`.productid = {$row1['productid']} and `xa`.slocid = {$row1['slocid']}
            and xb.recordstatus=5
            and xb.docdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
            and poqty > qtyres
            ) z
        ";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        foreach ($dataReader2 as $row2) {
          if($row2['prno']=='-')
          {
              $strpr = '';
              $prno = '';
              $pendingfpp = '';
              $strpo = 'PENDINGAN PO';
              $pono = $row2['pono'];
              $pendingpo = $row2['pendingpo'];
          }
          else
          {
              $strpr = 'PENDINGAN FPP';
              $prno = $row2['prno'];
              $pendingfpp = $row2['pendingfpp'];
              $strpo = '';
              $pono = '';
              $pendingpo = '';
          }
          
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0, $line, $strpr)
              ->setCellValueByColumnAndRow(1, $line, $prno)
              ->setCellValueByColumnAndRow(2, $line, $pendingfpp)
              ->setCellValueByColumnAndRow(3, $line, $strpo)
              ->setCellValueByColumnAndRow(4, $line, $pono)
              ->setCellValueByColumnAndRow(5, $line, $pendingpo);
            
            $totalpendingfpp  += $row2['pendingfpp'];
            $totalpendingpo += $row2['pendingpo'];
        }
        $totalawal = $row1['awal'];
        $totalmasuk = $row1['masuk'];
        $totalkeluar = $row1['keluar'];
        $totalsaldo = $totalawal + $totalmasuk + $totalkeluar;
        
        $line++;
        
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, 'Total' )
            ->setCellValueByColumnAndRow(1, $line, 'PENDING FPP : '.$totalpendingfpp.' PENDING PO : '. $totalpendingpo )
            ->setCellValueByColumnAndRow(2, $line, $totalawal)
            ->setCellValueByColumnAndRow(3, $line, $totalmasuk)
            ->setCellValueByColumnAndRow(4, $line, $totalkeluar)
            ->setCellValueByColumnAndRow(5, $line, $totalsaldo);
        $totalawal1 += $totalawal;
        $totalmasuk1 += $totalmasuk;
        $totalkeluar1 += $totalkeluar;
        $totalsaldo1 += $totalsaldo;
      }
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'GRAND TOTAL' . $row['description'])
          ->setCellValueByColumnAndRow(2, $line, $totalawal1)
          ->setCellValueByColumnAndRow(3, $line, $totalmasuk1)
          ->setCellValueByColumnAndRow(4, $line, $totalkeluar1)
          ->setCellValueByColumnAndRow(5, $line, $totalsaldo1);
    }
    $this->getFooterXLS($this->phpExcel);
  }
}