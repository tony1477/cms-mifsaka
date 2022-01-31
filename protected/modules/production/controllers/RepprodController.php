<?php

class RepprodController extends AdminController
{
	protected $menuname = 'repprod';		
	public $module = 'production';
	protected $pageTitle = 'Laporan Produksi';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['fullname']) && isset($_GET['product']) && isset($_GET['productcollectid']) && isset($_GET['startdate']) && isset($_GET['enddate'])) 
		{
		  if ($_GET['lro'] == 1) {
			$this->RincianProduksiPerDokumen($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 2) {
			$this->RekapProduksiPerGroupMaterialPerBarang($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 3) {
			$this->RincianPemakaianPerDokumen($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 4) {
			$this->RekapPemakaianPerGudangPerBarang($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 5) {
			$this->PerbandinganPlanningOutput($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 6) {
			$this->RwBelumAdaGudangAsal($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 7) {
			$this->RwBelumAdaGudangTujuan($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 8) {
			$this->PendinganProduksi($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 9) {
			$this->RincianPendinganProduksiPerBarang($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 10) {
			$this->RekapPendinganProduksiPerBarang($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 11) {
			$this->RekapProduksiPerBarangPerHari($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 12) {
			$this->RekapHasilProduksiPerDokumentBelumStatusMax($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 13) {
			$this->RekapProduksiPerBarangPerBulan($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 14) {
			$this->JadwalProduksi($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 15) {
			$this->LaporanSPPStatusBelumMax($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 16) {
			$this->LaporanPerbandingan($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 17) {
			$this->LaporanMaterialSPP($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 18) {
			$this->LaporanHasilScan($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 19) {
			$this->LaporanHasilOperatorPerManPower($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 20) {
			$this->LaporanCTPerForemanPerDokumen($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 21) {
			$this->LaporanRincianHasilProduksiPerGMprocess($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 22) {
			$this->LaporanRekapHasilProduksiPerGMprocess($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 23) {
			$this->RekapPemakaianPerBarang($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 99) {
			$this->LaporanProductDetailSPP($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else {
			echo GetCatalog('reportdoesnotexist');
		  }
		}
	}
	//1
  public function RincianProduksiPerDokumen($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql = "select distinct a.productoutputno,a.productoutputdate,a.productoutputid,e.productplanno as spp
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
        join employee f on f.employeeid = e.employeeid
				where a.recordstatus = 3 and a.productoutputno is not null and d.sloccode like '%" . $sloc . "%' 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%'
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.fullname like '%{$fullname}%' order by productoutputdate";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Produksi Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['productoutputno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['productoutputdate'])));
      $this->pdf->text(135, $this->pdf->gety() + 10, 'No SPP');
      $this->pdf->text(150, $this->pdf->gety() + 10, ': ' . $row['spp']);
      $sql1        = "select distinct b.productname,a.qtyoutput,c.uomcode,a.description ,d.description as sloc
						from productoutputfg a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join sloc d on d.slocid = a.slocid
						where b.productname like '%" . $product . "%' and a.productoutputid = " . $row['productoutputid'];
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 20);
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
        80,
        20,
        20,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Gudang',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatNumber($row1['qtyoutput']),
          $row1['uomcode'],
          $row1['sloc'],
          $row1['description']
        ));
        $totalqty += $row1['qtyoutput'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //2
  public function RekapProduksiPerGroupMaterialPerBarang($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $wherecom = " and a9.isgroup = 1"; $wherecom1 = " and a9.isgroup = 1}";
      //$product = getSymbolicWord('&product=','&startdate=');
		$totalqty1=0;
		$totalct1=0;
    $sql = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
        left join employee h on h.employeeid = a.employeeid
				where a.productoutputno is not null  and a.recordstatus = 3 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and h.fullname like '%{$fullname}%'
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" .$product. "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				order by g.description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Produksi Per Material Group Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'MATERIAL GROUP');
      $this->pdf->text(45, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1        = "select distinct productname,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput, sum(qtyoutput*cycletime)/60 as cycletime from  
					(select distinct b.productname,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid,cycletime
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
					left join employee h on h.employeeid = d.employeeid
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					and h.fullname like '%{$fullname}%' ".getFieldTable($productcollectid,'b','productcollectid')."
          ".getCompanyGroup($companyid,'d')." and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode,materialgroupid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty   = 0;
      $totalct    = 0;
      $i          = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        90,
        30,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty',
        'Cycletime'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
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
          Yii::app()->format->formatNumber($row1['qtyoutput']),
          Yii::app()->format->formatNumber($row1['cycletime'])
        ));
        $totalqty += $row1['qtyoutput'];
        $totalct += $row1['cycletime'];
      }
      $this->pdf->row(array(
        '',
        'Total ' . $row['description'],
        '',
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalct)
      ));
			$totalqty1 += $totalqty;
			$totalct1 += $totalct;
      $this->pdf->checkPageBreak(20);
    }
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->setFont('Arial', 'B', 9);
		$this->pdf->row(array(
			'',
			'GRAND TOTAL ',
			'',
			Yii::app()->format->formatNumber($totalqty1),
			Yii::app()->format->formatNumber($totalct1)
		));
    $this->pdf->Output();
  }
  //3
  public function RincianPemakaianPerDokumen($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.productoutputid,a.productoutputno as dokumen,a.productoutputdate as tanggal,e.sloccode
				from productoutput a
				join productplan b on b.productplanid = a.productplanid
				join productoutputdetail c on c.productoutputid = a.productoutputid
				join product d on d.productid = c.productid
				join sloc e on e.slocid = c.toslocid
        left join employee f on f.employeeid = a.employeeid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'d','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and e.sloccode like '%" . $sloc . "%' 
				and d.productname like '%" . $product . "%' and f.fullname like '%{$fullname}%'
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productoutputdate";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title = 'Rincian Pemakaian Per Dokumen';
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['dokumen']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
      $this->pdf->text(10, $this->pdf->gety() + 20, 'Gudang');
      $this->pdf->text(30, $this->pdf->gety() + 20, ': ' . $row['sloccode']);
      $sql1        = "select distinct b.productname,a.qty,c.uomcode,e.description as rak,a.description,
					getslocdesc(a.fromslocid) as sumber,
					getslocdesc(a.toslocid) as tujuan
						from productoutputdetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplant d on d.productid = a.productid
						join storagebin e on e.storagebinid = a.storagebinid
						join sloc f on f.slocid = d.slocid
						join productoutput g on g.productoutputid = a.productoutputid
						join productplan h on h.productplanid = g.productplanid
						where a.productoutputid = " . $row['productoutputid']."
            ".getFieldTable($productcollectid,'b','productcollectid')."";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 25);
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
        40,
        20,
        20,
        20,
        25,
        25,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Rak',
        'Asal',
        'Tujuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L',
        'L',
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatNumber($row1['qty']),
          $row1['uomcode'],
          $row1['rak'],
          $row1['sumber'],
          $row1['tujuan'],
          $row1['description']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqty),
        '',
        '',
        '',
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //4
  public function RekapPemakaianPerGudangPerBarang($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.toslocid,a.fromslocid,
					e.sloccode fromsloccode,
			e.description as fromslocdesc,
			f.sloccode as tosloccode,	
			f.description as toslocdesc
					from productoutputdetail a
					join product b on b.productid = a.productid
					join productoutput c on c.productoutputid = a.productoutputid
					join sloc e on e.slocid = a.fromslocid
					join sloc f on f.slocid = a.toslocid
          left join employee g on g.employeeid = c.employeeid
					where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
          ".getCompanyGroup($companyid,'c')." and g.fullname like '%{$fullname}%'
          and (e.sloccode like '%" . $sloc . "%' or f.sloccode like '%" . $sloc . "%') 
					and b.productname like '%" . $product . "%' and c.productoutputdate between 
					'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pemakaian Per Gudang Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Asal');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tujuan');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
            left join employee e on e.employeeid = c.employeeid
						where c.recordstatus = 3 and a.fromslocid = " . $row['fromslocid'] . " and a.toslocid = " . $row['toslocid'] . " 
            ".getFieldTable($productcollectid,'b','productcollectid')." and e.fullname like '%{$fullname}%'
            and b.productname like '%" . $product . "%' and c.productoutputdate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
						'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						group by productid,productname";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
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
          Yii::app()->format->formatNumber($row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        '',
        Yii::app()->format->formatNumber($totalqty)
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //5
  public function PerbandinganPlanningOutput($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.productplanno,a.productplandate,a.productplanid,d.sloccode,d.description as slocdesc
				from productplan a
				join productplanfg b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
        left join employee e on e.employeeid = a.employeeid
				where a.recordstatus = 3 and a.productplanno is not null 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and e.fullname like '%{$fullname}%'
         and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' and
				a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Perbandingan Planning Output';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['productplanno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
      $this->pdf->text(100, $this->pdf->gety() + 10, 'Sloc');
      $this->pdf->text(130, $this->pdf->gety() + 10, ': ' . $row['sloccode'] . '-' . $row['slocdesc']);
      $this->pdf->text(10, $this->pdf->gety() + 22, 'FG');
      $sql1         = "select b.productname,a.qty as qtyplan, (
					select ifnull(sum(ifnull(c.qtyoutput,0)),0)
					from productoutputfg c
					join productoutput g on g.productoutputid = c.productoutputid 
					where c.productplanfgid = a.productplanfgid and g.productplanid=a.productplanid and g.recordstatus = 3
					) as qtyout,d.uomcode,f.sloccode,f.description as slocdesc
					from productplanfg a 
					inner join product b on b.productid = a.productid 
					inner join unitofmeasure d on d.unitofmeasureid = a.uomid
					inner join sloc f on f.slocid = a.slocid
          join productplan h on h.productplanid = a.productplanid
          left join employee i on i.employeeid = h.employeeid
					where a.productplanid = " . $row['productplanid']."
          ".getFieldTable($productcollectid,'b','productcollectid')."
          and i.fullname like '%{$fullname}%'";
      $command1     = Yii::app()->db->createCommand($sql1);
      $dataReader1  = $command1->queryAll();
      $totalqtyplan = 0;
      $i            = 0;
      $totalqtyout  = 0;
      $this->pdf->sety($this->pdf->gety() + 25);
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
        120,
        20,
        20,
        20
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty Plan',
        'Qty Out',
        'Satuan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
          Yii::app()->format->formatNumber($row1['qtyplan']),
          Yii::app()->format->formatNumber($row1['qtyout']),
          $row1['uomcode']
        ));
        $totalqtyplan += $row1['qtyplan'];
        $totalqtyout += $row1['qtyout'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqtyplan),
        Yii::app()->format->formatNumber($totalqtyout),
        ''
      ));
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Detail');
      $sql2          = "select distinct b.productname, a.qty as qtyplan,ifnull(f.qty,0) as qtyout, c.uomcode, a.description
				from productplandetail a
				left join productoutputdetail f on f.productplandetailid = a.productplandetailid
				left join product b on b.productid = a.productid
				left join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.bomid
				left join sloc e on e.slocid = a.fromslocid 
				left join productoutput g on g.productoutputid=f.productoutputid
        left join employee h on h.employeeid = g.employeeid
				where g.recordstatus = 3 and b.isstock = 1 
        ".getFieldTable($productcollectid,'b','productcollectid')."        
        and g.productplanid = " . $row['productplanid'];
      $command2      = Yii::app()->db->createCommand($sql2);
      $dataReader2   = $command2->queryAll();
      $totalqtyplan1 = 0;
      $ii            = 0;
      $totalqtyout1  = 0;
      $this->pdf->sety($this->pdf->gety() + 10);
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
        120,
        20,
        20,
        20
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty Plan',
        'Qty Out',
        'Satuan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'R',
        'C'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader2 as $row2) {
        $ii += 1;
        $this->pdf->row(array(
          $ii,
          $row2['productname'],
          Yii::app()->format->formatNumber($row2['qtyplan']),
          Yii::app()->format->formatNumber($row2['qtyout']),
          $row2['uomcode']
        ));
        $totalqtyplan1 += $row2['qtyplan'];
        $totalqtyout1 += $row2['qtyout'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqtyplan1),
        Yii::app()->format->formatNumber($totalqtyout1),
        ''
      ));
      $this->pdf->AddPage();
    }
    $this->pdf->Output();
  }
  //6
  public function RwBelumAdaGudangAsal($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.productplanno,a.productplandate,a.productplanid
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.fromslocid
				where a.recordstatus > 0 and d.sloccode like '%" . $sloc . "%' 
				and a.companyid = " . $companyid . " and c.productname like '%" . $product . "%'
				and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'				
				and b.fromslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid and xx.recordstatus=1)
        ";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title = 'Raw Material Gudang Asal Belum Ada di Data Gudang - SPP';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['productplanno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
      $sql1        = "select distinct b.productname,a.qty,c.uomcode,d.description,d.productplandate,
						(select sloccode from sloc xx where xx.slocid = a.fromslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.fromslocid
						where b.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%' 
						and d.companyid = " . $companyid . " and d.recordstatus > 0
						and d.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.productplanid = " . $row['productplanid'] . "
						and a.fromslocid not in (select x.slocid from productplant x where x.productid = a.productid and x.recordstatus=1)";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 25);
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
        80,
        20,
        20,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Gudang Asal',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatNumber($row1['qty']),
          $row1['uomcode'],
          $row1['sloc'],
          $row1['description']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //7
  public function RwBelumAdaGudangTujuan($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct a.productplanno,a.productplandate,a.productplanid,a.recordstatus
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.toslocid
				where d.sloccode like '%" . $sloc . "%' and a.recordstatus > 0 
				and a.companyid = " . $companyid . " and c.productname like '%" . $product . "%'
				and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and b.toslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid)";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title = 'Raw Material Gudang Tujuan Belum Ada di Data Gudang - SPP';
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['productplanno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
      $sql1        = "select distinct b.productname,a.qty,c.uomcode,d.description,
						(select sloccode from sloc xx where xx.slocid = a.toslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.toslocid
						where b.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%'
						and d.companyid = " . $companyid . " and d.recordstatus > 0 and a.productplanid = " . $row['productplanid'] . "
						and d.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						and a.toslocid not in (select x.slocid from productplant x where x.productid = a.productid)";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 25);
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
        80,
        20,
        20,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Gudang Tujuan',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatNumber($row1['qty']),
          $row1['uomcode'],
          $row1['sloc'],
          $row1['description']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqty),
        '',
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //8
  public function PendinganProduksi($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql = "select distinct a.productplanno,a.productplandate,a.productplanid
			   from productplan a
			   join productplanfg b on b.productplanid = a.productplanid
			   join product c on c.productid = b.productid
			   join sloc d on d.slocid = b.slocid
         left join employee e on e.employeeid = a.employeeid
			   where a.recordstatus = 3 and a.productplanno is not null and d.sloccode like '%" . $sloc . "%' 
			   ".getFieldTable($productcollectid,'c','productcollectid')."
         ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
			   and b.startdate <= curdate() and e.fullname like '%{$fullname}%'
				 and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
			   and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productplanno";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title = 'Pendingan Produksi Per Dokumen';
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    $alltotalqty       = 0;
    $alltotalqtyoutput = 0;
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['productplanno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
      $sql1           = "select b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,c.uomcode,d.description as sloc
						from productplanfg a						
						join product b on b.productid = a.productid						
						join unitofmeasure c on c.unitofmeasureid = a.uomid						
						join sloc d on d.slocid = a.slocid
						join productplan e on e.productplanid = a.productplanid						
            left join employee f on f.employeeid = e.employeeid
						where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres
						".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
						and a.startdate <= curdate() and f.fullname like '%{$fullname}%'
						and e.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.productplanid = " . $row['productplanid'];
      $command1       = Yii::app()->db->createCommand($sql1);
      $dataReader1    = $command1->queryAll();
      $total          = 0;
      $i              = 0;
      $totalqty       = 0;
      $totalqtyoutput = 0;
      $this->pdf->sety($this->pdf->gety() + 25);
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
        10,
        70,
        20,
        20,
        20,
        30,
        20
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'QtyOutput',
        'Satuan',
        'Gudang',
        'Selisih'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'R',
        'C',
        'L',
        'L'
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatNumber($row1['qty']),
          Yii::app()->format->formatNumber($row1['qtyoutput']),
          $row1['uomcode'],
          $row1['sloc'],
          $row1['selisih']
        ));
        $totalqty += $row1['qty'];
        $totalqtyoutput += $row1['qtyoutput'];
        $alltotalqty += $row1['qty'];
        $alltotalqtyoutput += $row1['qtyoutput'];
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtyoutput),
        ''
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->row(array(
      '',
      'Total Keseluruhan',
      Yii::app()->format->formatNumber($alltotalqty),
      Yii::app()->format->formatNumber($alltotalqtyoutput),
      '',
      Yii::app()->format->formatNumber($alltotalqty - $alltotalqtyoutput)
    ));
    $this->pdf->Output();
  }
  //9
  public function RincianPendinganProduksiPerBarang($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql = "select distinct d.description,d.slocid
						 from productplan a
						 join productplanfg b on b.productplanid = a.productplanid
						 join product c on c.productid = b.productid
						 join sloc d on d.slocid = b.slocid
             left join employee e on e.employeeid = a.employeeid
						 where a.recordstatus = 3 and d.sloccode like '%" . $sloc . "%' 
						 ".getFieldTable($productcollectid,'c','productcollectid')." and e.fullname like '%{$fullname}%'
             ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
						 and b.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command           = Yii::app()->db->createCommand($sql);
    $dataReader        = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pendingan Produksi Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $this->pdf->SetFont('Arial', '', 9);
      $sql1           = "select distinct b.productname,b.productid
                        from productplanfg a	
                        join product b on b.productid = a.productid	
                        join unitofmeasure c on c.unitofmeasureid = a.uomid	
                        join sloc d on d.slocid = a.slocid
                        join productplan e on e.productplanid = a.productplanid	
                        left join employee f on f.employeeid = e.employeeid
                        where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres ".getFieldTable($productcollectid,'b','productcollectid')."
                        ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
                        and e.productplanno is not null and f.fullname like '%{$fullname}%'
                        and a.startdate <= now() and a.startdate >= date_sub(now(),interval 1 MONTH)
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                        and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                        and a.slocid = " . $row['slocid'] . " ";
      $command1       = Yii::app()->db->createCommand($sql1);
      $dataReader1    = $command1->queryAll();
      $totalqty       = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->setY($this->pdf->getY()+5);
      foreach ($dataReader1 as $row1) {
        $this->pdf->checkPageBreak(30);
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->text(10, $this->pdf->gety() + 15, 'Nama Barang ');
        $this->pdf->text(33, $this->pdf->gety() + 15, ': ' . $row1['productname']);
        $sql2        = "select e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
                                            c.uomcode,d.description as sloc,e.productplanno,e.productplandate,a.startdate
                                            from productplanfg a	
                                            join product b on b.productid = a.productid	
                                            join unitofmeasure c on c.unitofmeasureid = a.uomid	
                                            join sloc d on d.slocid = a.slocid
                                            join productplan e on e.productplanid = a.productplanid	
                                            where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres
                                            and e.companyid = " . $companyid . " and e.recordstatus = 3
                                            and e.productplanno is not null
                                            and a.startdate <= now() and a.startdate >= date_sub(now(),interval 1 MONTH)
                                            and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                                            and b.productid = " . $row1['productid'] . " and d.slocid = " . $row['slocid'] . "";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        $this->pdf->sety($this->pdf->gety() + 18);
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
          10,
          40,
          25,
          15,
          35,
          35,
          35
        ));
        $this->pdf->colheader = array(
          'No',
          'No SPP',
          'Tgl Mulai',
          'Satuan',
          'Qty SPP',
          'Qty OP',
          'Selisih'
        );
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array(
          'C',
          'L',
          'C',
          'C',
          'R',
          'R',
          'R'
        );
        $i                         = 0;
        $jumlahqty                 = 0;
        $jumlahqtyoutput           = 0;
        $jumlahselisih             = 0;
        foreach ($dataReader2 as $row2) {
            //$this->pdf->setY($this->pdf->getY()+20);
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productplanno'],
            $row2['startdate'],
            $row2['uomcode'],
            Yii::app()->format->formatNumber($row2['qty']),
            Yii::app()->format->formatNumber($row2['qtyoutput']),
            Yii::app()->format->formatNumber($row2['selisih'])
          ));
          $jumlahqty += $row2['qty'];
          $jumlahqtyoutput += $row2['qtyoutput'];
          $jumlahselisih += $row2['selisih'];
        }
          
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->row(array(
          '',
          'Jumlah ',
          '',
          '',
          Yii::app()->format->formatNumber($jumlahqty),
          Yii::app()->format->formatNumber($jumlahqtyoutput),
          Yii::app()->format->formatNumber($jumlahselisih)
        ));
        $totalqty += $jumlahqty;
        $totalqtyoutput += $jumlahqtyoutput;
        $totalselisih += $jumlahselisih;
        
      }
        
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->row(array(
        '',
        'Total ' . $row['description'],
        '',
        '',
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtyoutput),
        Yii::app()->format->formatNumber($totalselisih)
      ));
      $subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
      
      $this->pdf->checkPageBreak(20);
    }
      
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 11);
    $this->pdf->row(array(
      '',
      'Grand Total ',
      '',
      '',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));
    
    $this->pdf->Output();
  }
  //10
  public function RekapPendinganProduksiPerBarang($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct d.description,d.slocid
						 from productplan a
						 join productplanfg b on b.productplanid = a.productplanid
						 join product c on c.productid = b.productid
						 join sloc d on d.slocid = b.slocid
             left join employee e on e.employeeid = a.employeeid
						 where a.recordstatus = 3 and d.sloccode like '%" . $sloc . "%' 
						 ".getFieldTable($productcollectid,'c','productcollectid')." and e.fullname like '%{$fullname}%'
             ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
						 and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productplanno";
    $command           = Yii::app()->db->createCommand($sql);
    $dataReader        = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pendingan Produksi Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1           = "select *,sum(qty) as sumqty,sum(qtyoutput) as sumqtyoutput,sum(selisih) as sumselisih
                                    from
                                     (select e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
                                    c.uomcode,d.description as sloc,e.productplanno,e.productplandate	
                                    from productplanfg a	
                                    join product b on b.productid = a.productid	
                                    join unitofmeasure c on c.unitofmeasureid = a.uomid	
                                    join sloc d on d.slocid = a.slocid
                                    join productplan e on e.productplanid = a.productplanid
                                    left join employee f on f.employeeid = e.employeeid
                                    where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres and f.fullname like '%{$fullname}%'
                                    ".getFieldTable($productcollectid,'b','productcollectid')."
                                    ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
                                    and e.productplanno is not null
                                    and e.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                                    and a.slocid = " . $row['slocid'] . " order by productname) z group by productname";
      $command1       = Yii::app()->db->createCommand($sql1);
      $dataReader1    = $command1->queryAll();
      $totalqty       = 0;
      $i              = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->sety($this->pdf->gety() + 18);
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
        10,
        70,
        25,
        25,
        25,
        25,
        35
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty SPP',
        'Qty OP',
        'Selisih'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
        'L',
        'C',
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
          Yii::app()->format->formatNumber($row1['sumqty']),
          Yii::app()->format->formatNumber($row1['sumqtyoutput']),
          Yii::app()->format->formatNumber($row1['sumselisih'])
        ));
        $totalqty += $row1['sumqty'];
        $totalqtyoutput += $row1['sumqtyoutput'];
        $totalselisih += $row1['sumselisih'];
      }
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->row(array(
        '',
        'Total ' . $row['description'],
        '',
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtyoutput),
        Yii::app()->format->formatNumber($totalselisih)
      ));
      $subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 11);
    $this->pdf->row(array(
      '',
      'Grand Total ',
      '',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));
    $this->pdf->Output();
  }
  //11
  public function RekapProduksiPerBarangPerHari($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
        left join employee h on h.employeeid = a.employeeid
				where a.productoutputno is not null and a.companyid = {$companyid}
        and a.recordstatus = 3 and h.fullname like '%{$fullname}%'
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Produksi Per Material Group Per Barang Per Hari';
    $this->pdf->subtitle = 'Periode : ' . date('F Y',strtotime($enddate));
    $this->pdf->AddPage('L', 'Legal');
    foreach ($dataReader as $row)
    {
      $this->pdf->SetFont('Arial', '', 7);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'MATERIAL GROUP');
      $this->pdf->text(45, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1 = "select distinct productname,productid,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput, d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31 from 
								(select distinct b.productname,b.productid,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid,(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 1 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d1,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 2 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d2,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 3 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d3,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 4 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d4,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 5 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d5,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 6 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d6,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 7 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d7,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 8 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d8,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 9 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d9,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 10 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d10,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 11 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d11,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 12 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d12,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 13 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d13,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 14 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d14,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 15 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d15,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 16 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d16,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 17
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d17,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 18 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d18,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 19 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d19,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 20 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d20,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 21 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d21,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 22 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d22,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 23 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d23,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 24 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d24,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 25 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d25,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 26 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d26,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 27 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d27,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 28 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d28,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 29 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d29,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 30 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								) as d30,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 31 
								and l.recordstatus = 3 and k.productid = a.productid and l.companyid = d.companyid 
								)as d31

								from productoutputfg a
								inner join product b on b.productid = a.productid
								inner join productoutput d on d.productoutputid = a.productoutputid
								inner join unitofmeasure e on e.unitofmeasureid = a.uomid
								inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
								join sloc f on f.slocid = a.slocid
								join productplan g on g.productplanid = d.productplanid 
								where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
								and g.companyid = " . $companyid . " and year(d.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and month(d.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and c.materialgroupid = " . $row['materialgroupid'] . " ) z 
								group by productname,uomcode,materialgroupid";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        8,
        35,
        10,
        10,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9,
        9
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty',
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
        'C',
        'L',
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
      $this->pdf->setFont('Arial', '', 6);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          $row1['uomcode'],
          Yii::app()->format->formatNum($row1['qtyoutput']),
          Yii::app()->format->formatNum($row1['d1']),
          Yii::app()->format->formatNum($row1['d2']),
          Yii::app()->format->formatNum($row1['d3']),
          Yii::app()->format->formatNum($row1['d4']),
          Yii::app()->format->formatNum($row1['d5']),
          Yii::app()->format->formatNum($row1['d6']),
          Yii::app()->format->formatNum($row1['d7']),
          Yii::app()->format->formatNum($row1['d8']),
          Yii::app()->format->formatNum($row1['d9']),
          Yii::app()->format->formatNum($row1['d10']),
          Yii::app()->format->formatNum($row1['d11']),
          Yii::app()->format->formatNum($row1['d12']),
          Yii::app()->format->formatNum($row1['d13']),
          Yii::app()->format->formatNum($row1['d14']),
          Yii::app()->format->formatNum($row1['d15']),
          Yii::app()->format->formatNum($row1['d16']),
          Yii::app()->format->formatNum($row1['d17']),
          Yii::app()->format->formatNum($row1['d18']),
          Yii::app()->format->formatNum($row1['d19']),
          Yii::app()->format->formatNum($row1['d20']),
          Yii::app()->format->formatNum($row1['d21']),
          Yii::app()->format->formatNum($row1['d22']),
          Yii::app()->format->formatNum($row1['d23']),
          Yii::app()->format->formatNum($row1['d24']),
          Yii::app()->format->formatNum($row1['d25']),
          Yii::app()->format->formatNum($row1['d26']),
          Yii::app()->format->formatNum($row1['d27']),
          Yii::app()->format->formatNum($row1['d28']),
          Yii::app()->format->formatNum($row1['d29']),
          Yii::app()->format->formatNum($row1['d30']),
          Yii::app()->format->formatNum($row1['d31'])
        ));
        $totalqty += $row1['qtyoutput'];
      }
      $this->pdf->row(array(
        '',
        'Total ' . $row['description'],
        '',
        Yii::app()->format->formatNumber($totalqty)
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //12
  public function RekapHasilProduksiPerDokumentBelumStatusMax($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.productoutputid,b.productoutputid,b.recordstatus,
					b.productoutputno,b.productoutputdate,c.productplanno,b.description,b.statusname
					from productoutput b
					join productplan c on c.productplanid = b.productplanid
					join productoutputfg d on d.productoutputid = b.productoutputid
					join product e on e.productid = d.productid
					join sloc f on f.slocid = d.slocid
					where e.productname like '%" . $product . "%' and f.sloccode like '%" . $sloc . "%' 
					and c.companyid = " . $companyid . "
					and b.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					and b.recordstatus between 1 and (3-1) and b.productplanid is not null 
					order by b.recordstatus";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Hasil Produksi Per Dokumen Status Belum Max';
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
      30,
      30,
      50,
      20
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
      'C'
    );
    $i=0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['productoutputid'],
        $row['productoutputno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['productoutputdate'])),
        $row['productplanno'],
        $row['description'],
        $row['statusname']
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->setwidths(array(
      40,
      50,
      40,
      40
    ));
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->Output();
  }
  //13
  public function RekapProduksiPerBarangPerBulanXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rekapproduksiperbarangperbulan';
      parent::actionDownxls();
      
      $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and year(a.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
				order by g.description
			";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $grandtotaljanuari = 0;
      $grandtotalfebruari = 0;
      $grandtotalmaret = 0;
      $grandtotalapril = 0;
      $grandtotalmei = 0;
      $grandtotaljuni = 0;
      $grandtotaljuli = 0;
      $grandtotalagustus = 0;
      $grandtotalseptember = 0;
      $grandtotaloktober = 0;
      $grandtotalnopember = 0;
      $grandtotaldesember = 0;
      $grandtotal = 0;
      
      $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(1, 2, date('Y',strtotime($enddate)));
      
      $line=4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'MATERIAL GROUP')
               ->setCellValueByColumnAndRow(1, $line, ': '. $row['description']);
          $line++;
          
          $sql1        = "select *
					from (select distinct b.productname,e.uomcode,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 1 and m.materialgroupid = c.materialgroupid),0) as januari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 2 and m.materialgroupid = c.materialgroupid),0) as februari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 3 and m.materialgroupid = c.materialgroupid),0) as maret,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 4 and m.materialgroupid = c.materialgroupid),0) as april,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 5 and m.materialgroupid = c.materialgroupid),0) as mei,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 6 and m.materialgroupid = c.materialgroupid),0) as juni,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 7 and m.materialgroupid = c.materialgroupid),0) as juli,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 8 and m.materialgroupid = c.materialgroupid),0) as agustus,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 9 and m.materialgroupid = c.materialgroupid),0) as september,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 10 and m.materialgroupid = c.materialgroupid),0) as oktober,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 11 and m.materialgroupid = c.materialgroupid),0) as nopember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 12 and m.materialgroupid = c.materialgroupid),0) as desember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and m.materialgroupid = c.materialgroupid),0) as jumlah
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
          left join employee h on h.employeeid = d.employeeid
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					".getFieldTable($productcollectid,'b','productcollectid')." and h.fullname like '%{$fullname}%'
          ".getCompanyGroup($companyid,'d')." and year(d.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      
      $totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
      $i = 0;
          
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'No')
               ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
               ->setCellValueByColumnAndRow(2, $line, 'Satuan')
               ->setCellValueByColumnAndRow(3, $line, '1')
               ->setCellValueByColumnAndRow(4, $line, '2')
               ->setCellValueByColumnAndRow(5, $line, '3')
               ->setCellValueByColumnAndRow(6, $line, '4')
               ->setCellValueByColumnAndRow(7, $line, '5')
               ->setCellValueByColumnAndRow(8, $line, '6')
               ->setCellValueByColumnAndRow(9, $line, '7')
               ->setCellValueByColumnAndRow(10, $line, '8')
               ->setCellValueByColumnAndRow(11, $line, '9')
               ->setCellValueByColumnAndRow(12, $line, '10')
               ->setCellValueByColumnAndRow(13, $line, '11')
               ->setCellValueByColumnAndRow(14, $line, '12')
               ->setCellValueByColumnAndRow(15, $line, 'Jumlah');
          $line++;
           
          foreach($dataReader1 as $row1)
          {
              $i+=1;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, $i)
                ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
                ->setCellValueByColumnAndRow(3, $line, $row1['januari'])
                ->setCellValueByColumnAndRow(4, $line, $row1['februari'])
                ->setCellValueByColumnAndRow(5, $line, $row1['maret'])
                ->setCellValueByColumnAndRow(6, $line, $row1['april'])
                ->setCellValueByColumnAndRow(7, $line, $row1['mei'])
                ->setCellValueByColumnAndRow(8, $line, $row1['juni'])
                ->setCellValueByColumnAndRow(9, $line, $row1['juli'])
                ->setCellValueByColumnAndRow(10, $line, $row1['agustus'])
                ->setCellValueByColumnAndRow(11, $line, $row1['september'])
                ->setCellValueByColumnAndRow(12, $line, $row1['oktober'])
                ->setCellValueByColumnAndRow(13, $line, $row1['nopember'])
                ->setCellValueByColumnAndRow(14, $line, $row1['desember'])
                ->setCellValueByColumnAndRow(15, $line, $row1['jumlah']);
              
              $totaljanuari += $row1['januari'];
              $totalfebruari += $row1['februari'];
              $totalmaret += $row1['maret'];
              $totalapril += $row1['april'];
              $totalmei += $row1['mei'];
              $totaljuni += $row1['juni'];
              $totaljuli += $row1['juli'];
              $totalagustus += $row1['agustus'];
              $totalseptember += $row1['september'];
              $totaloktober += $row1['oktober'];
              $totalnopember += $row1['nopember'];
              $totaldesember += $row1['desember'];
              $totaljumlah += $row1['jumlah'];
              
              $line++;
          }
          
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(1, $line, 'Total '.$row['description'])
               ->setCellValueByColumnAndRow(3, $line, $totaljanuari)
               ->setCellValueByColumnAndRow(4, $line, $totalfebruari)
               ->setCellValueByColumnAndRow(5, $line, $totalmaret)
               ->setCellValueByColumnAndRow(6, $line, $totalapril)
               ->setCellValueByColumnAndRow(7, $line, $totalmei)
               ->setCellValueByColumnAndRow(8, $line, $totaljuni)
               ->setCellValueByColumnAndRow(9, $line, $totaljuli)
               ->setCellValueByColumnAndRow(10, $line, $totalagustus)
               ->setCellValueByColumnAndRow(11, $line, $totalseptember)
               ->setCellValueByColumnAndRow(12, $line, $totaloktober)
               ->setCellValueByColumnAndRow(13, $line, $totalnopember)
               ->setCellValueByColumnAndRow(14, $line, $totaldesember)
               ->setCellValueByColumnAndRow(15, $line, $totaljumlah);
              
          $line+=2;
          $grandtotaljanuari += $totaljanuari;
          $grandtotalfebruari += $totalfebruari;
          $grandtotalmaret += $totalmaret;
          $grandtotalapril += $totalapril;
          $grandtotalmei += $totalmei;
          $grandtotaljuni += $totaljuni;
          $grandtotaljuli += $totaljuli;
          $grandtotalagustus += $totalagustus;
          $grandtotalseptember += $totalseptember;
          $grandtotaloktober += $totaloktober;
          $grandtotalnopember += $totalnopember;
          $grandtotaldesember += $totaldesember;
          $grandtotal += $totaljumlah;
      }
      
      $this->phpExcel->setActiveSheetIndex(0)
           ->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')
           ->setCellValueByColumnAndRow(3, $line, $grandtotaljanuari)
           ->setCellValueByColumnAndRow(4, $line, $grandtotalfebruari)
           ->setCellValueByColumnAndRow(5, $line, $grandtotalmaret)
           ->setCellValueByColumnAndRow(6, $line, $grandtotalapril)
           ->setCellValueByColumnAndRow(7, $line, $grandtotalmei)
           ->setCellValueByColumnAndRow(8, $line, $grandtotaljuni)
           ->setCellValueByColumnAndRow(9, $line, $grandtotaljuli)
           ->setCellValueByColumnAndRow(10, $line, $grandtotalagustus)
           ->setCellValueByColumnAndRow(11, $line, $grandtotalseptember)
           ->setCellValueByColumnAndRow(12, $line, $grandtotaloktober)
           ->setCellValueByColumnAndRow(13, $line, $grandtotalnopember)
           ->setCellValueByColumnAndRow(14, $line, $grandtotaldesember)
           ->setCellValueByColumnAndRow(15, $line, $grandtotal);
      $this->getFooterXLS($this->phpExcel);
  }
  /*public function RekapProduksiPerBarangPerBulan($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and year(a.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
				order by g.description
		";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Produksi Per Material Group Per Barang Per Bulan';
    $this->pdf->subtitle = 'Per Tahun : ' . date('Y', strtotime($enddate));
    $this->pdf->AddPage('L','F4');
    $grandtotaljanuari = 0;
    $grandtotalfebruari = 0;
    $grandtotalmaret = 0;
    $grandtotalapril = 0;
    $grandtotalmei = 0;
    $grandtotaljuni = 0;
    $grandtotaljuli = 0;
    $grandtotalagustus = 0;
    $grandtotalseptember = 0;
    $grandtotaloktober = 0;
    $grandtotalnopember = 0;
    $grandtotaldesember = 0;
    $grandtotal = 0;
        
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'MATERIAL GROUP');
      $this->pdf->text(45, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1        = "select *
					from (select distinct b.productname,e.uomcode,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 1 and m.materialgroupid = c.materialgroupid),0) as januari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 2 and m.materialgroupid = c.materialgroupid),0) as februari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 3 and m.materialgroupid = c.materialgroupid),0) as maret,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 4 and m.materialgroupid = c.materialgroupid),0) as april,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 5 and m.materialgroupid = c.materialgroupid),0) as mei,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 6 and m.materialgroupid = c.materialgroupid),0) as juni,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 7 and m.materialgroupid = c.materialgroupid),0) as juli,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 8 and m.materialgroupid = c.materialgroupid),0) as agustus,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 9 and m.materialgroupid = c.materialgroupid),0) as september,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 10 and m.materialgroupid = c.materialgroupid),0) as oktober,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 11 and m.materialgroupid = c.materialgroupid),0) as nopember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 12 and m.materialgroupid = c.materialgroupid),0) as desember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and m.materialgroupid = c.materialgroupid),0) as jumlah
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
          left join employee h on h.employeeid = d.employeeid
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					".getFieldTable($productcollectid,'b','productcollectid')." and h.fullname like '%{$fullname}%'
          ".getCompanyGroup($companyid,'d')." and year(d.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
      $i           = 0;
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
        90,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        15,
        20
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
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
        'Jumlah',
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
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
        'R',
        'R',
        'R',
        'R',
        'R',
      );
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          $row1['uomcode'],
          Yii::app()->format->formatCurrency($row1['januari']),
          Yii::app()->format->formatCurrency($row1['februari']),
          Yii::app()->format->formatCurrency($row1['maret']),
          Yii::app()->format->formatCurrency($row1['april']),
          Yii::app()->format->formatCurrency($row1['mei']),
          Yii::app()->format->formatCurrency($row1['juni']),
          Yii::app()->format->formatCurrency($row1['juli']),
          Yii::app()->format->formatCurrency($row1['agustus']),
          Yii::app()->format->formatCurrency($row1['september']),
          Yii::app()->format->formatCurrency($row1['oktober']),
          Yii::app()->format->formatCurrency($row1['nopember']),
          Yii::app()->format->formatCurrency($row1['desember']),
          Yii::app()->format->formatCurrency($row1['jumlah']),
        ));
        $totaljanuari += $row1['januari'];
        $totalfebruari += $row1['februari'];
        $totalmaret += $row1['maret'];
        $totalapril += $row1['april'];
        $totalmei += $row1['mei'];
        $totaljuni += $row1['juni'];
        $totaljuli += $row1['juli'];
        $totalagustus += $row1['agustus'];
        $totalseptember += $row1['september'];
        $totaloktober += $row1['oktober'];
        $totalnopember += $row1['nopember'];
        $totaldesember += $row1['desember'];
        $totaljumlah += $row1['jumlah'];
      }
      $this->pdf->row(array(
        '',
        'TOTAL ' . $row['description'],
        '',
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
        $grandtotaljanuari += $totaljanuari;
        $grandtotalfebruari += $totalfebruari;
        $grandtotalmaret += $totalmaret;
        $grandtotalapril += $totalapril;
        $grandtotalmei += $totalmei;
        $grandtotaljuni += $totaljuni;
        $grandtotaljuli += $totaljuli;
        $grandtotalagustus += $totalagustus;
        $grandtotalseptember += $totalseptember;
        $grandtotaloktober += $totaloktober;
        $grandtotalnopember += $totalnopember;
        $grandtotaldesember += $totaldesember;
        $grandtotal += $totaljumlah;
        
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->setY($this->pdf->getY()+5);
    $this->pdf->setFont('Arial','B',9);
    $this->pdf->row(array(
    '',
    'GRAND TOTAL',
    '',
    Yii::app()->format->formatCurrency($grandtotaljanuari),
        Yii::app()->format->formatCurrency($grandtotalfebruari),
        Yii::app()->format->formatCurrency($grandtotalmaret),
        Yii::app()->format->formatCurrency($grandtotalapril),
        Yii::app()->format->formatCurrency($grandtotalmei),
        Yii::app()->format->formatCurrency($grandtotaljuni),
        Yii::app()->format->formatCurrency($grandtotaljuli),
        Yii::app()->format->formatCurrency($grandtotalagustus),
        Yii::app()->format->formatCurrency($grandtotalseptember),
        Yii::app()->format->formatCurrency($grandtotaloktober),
        Yii::app()->format->formatCurrency($grandtotalnopember),
        Yii::app()->format->formatCurrency($grandtotaldesember),
        Yii::app()->format->formatCurrency($grandtotal),
    ));
    $this->pdf->Output();
  }*/
  //14
  public function JadwalProduksi($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct startdate
                  from productplanfg a
                  join productplan b on b.productplanid=a.productplanid
                  join sloc c on c.slocid=a.slocid
                  join product d on d.productid=a.productid
                  where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                  and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' 
                  and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) 
    {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Jadwal Produksi (SPP)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P','A4');
    foreach ($dataReader as $row) 
    {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety()+5, 'Tanggal');
      $this->pdf->text(25, $this->pdf->gety()+5, ': ' . $row['startdate']);
      $sql1        = "select distinct f.materialgroupid,f.description
                      from productplanfg a
                      join productplan b on b.productplanid=a.productplanid
                      join sloc c on c.slocid=a.slocid
                      join product d on d.productid=a.productid
                      join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                      join materialgroup f on f.materialgroupid=e.materialgroupid
                      where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                      and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."'
                      and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                      order by description";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      foreach ($dataReader1 as $row1)
      {
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->sety($this->pdf->gety()+5);
        $this->pdf->text(10, $this->pdf->gety()+5, 'Material Group');
        $this->pdf->text(45, $this->pdf->gety()+5, ': ' . $row1['description']);
        $this->pdf->sety($this->pdf->gety()+7);        
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
        $this->pdf->setwidths(array(8,22,70,15,20,20,20,20));
        $this->pdf->colheader = array('No','SPP','Nama Barang','Satuan','Qty','Tgl Mulai','Tgl Selesai','Cycletime');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('C','C','L','C','R','C','C','R');
        
        $sql2        = "select b.productplanno,d.productname,g.uomcode,a.qty,a.startdate,a.enddate,(select (a.qty*a.cycletime)/60) as cycletime
                        from productplanfg a
                        join productplan b on b.productplanid=a.productplanid
                        join sloc c on c.slocid=a.slocid
                        join product d on d.productid=a.productid
                        join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                        join materialgroup f on f.materialgroupid=e.materialgroupid
                        join unitofmeasure g on g.unitofmeasureid=a.uomid
                        where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                        and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."' and f.materialgroupid = ".$row1['materialgroupid']."
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        $i=0;$totalqty=0;$totalct=0;
        foreach ($dataReader2 as $row2)
        {
          $this->pdf->SetFont('Arial', '', 8);
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productplanno'],
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->format->formatCurrency($row2['qty']),
            $row2['startdate'],
            $row2['enddate'],
            Yii::app()->format->formatCurrency($row2['cycletime']),
          ));
          $totalqty += $row2['qty'];
          $totalct += $row2['cycletime'];
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->coldetailalign = array('C','C','R','C','R','C','C','R');
        $this->pdf->row(array(
          '','',
          'JUMLAH '.$row1['description'],
          '>>>>>',
          Yii::app()->format->formatCurrency($totalqty),
          '','',
          Yii::app()->format->formatCurrency($totalct)
        ));
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->sety($this->pdf->gety()+5);
    }
    $this->pdf->Output();
  }
  /*public function JadwalProduksi($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct startdate
                  from productplanfg a
                  join productplan b on b.productplanid=a.productplanid
                  join sloc c on c.slocid=a.slocid
                  join product d on d.productid=a.productid
                  where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                  and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' 
                  and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
    $command    = Yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) 
    {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Jadwal Produksi (SPP)';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P','A4');
    foreach ($dataReader as $row) 
    {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety()+5, 'Tanggal');
      $this->pdf->text(25, $this->pdf->gety()+5, ': ' . $row['startdate']);
      $sql1        = "select distinct f.materialgroupid,f.description
                      from productplanfg a
                      join productplan b on b.productplanid=a.productplanid
                      join sloc c on c.slocid=a.slocid
                      join product d on d.productid=a.productid
                      join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                      join materialgroup f on f.materialgroupid=e.materialgroupid
                      where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                      and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."'
                      and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                      order by description";
      $command1    = Yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      foreach ($dataReader1 as $row1)
      {
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->sety($this->pdf->gety()+5);
        $this->pdf->text(10, $this->pdf->gety()+5, 'Material Group');
        $this->pdf->text(45, $this->pdf->gety()+5, ': ' . $row1['description']);
        $this->pdf->sety($this->pdf->gety()+7);        
        $this->pdf->setFont('Arial', 'B', 8);
        $this->pdf->colalign = array('C','C','C','C','C','C','C');
        $this->pdf->setwidths(array(8,22,90,15,20,20,20));
        $this->pdf->colheader = array('No','SPP','Nama Barang','Satuan','Qty','Tgl Mulai','Tgl Selesai');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('C','C','L','C','R','C','C');
        
        $sql2        = "select b.productplanno,d.productname,g.uomcode,a.qty,a.startdate,a.enddate
                        from productplanfg a
                        join productplan b on b.productplanid=a.productplanid
                        join sloc c on c.slocid=a.slocid
                        join product d on d.productid=a.productid
                        join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                        join materialgroup f on f.materialgroupid=e.materialgroupid
                        join unitofmeasure g on g.unitofmeasureid=a.uomid
                        where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                        and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."' and f.materialgroupid = ".$row1['materialgroupid']."
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
        $command2    = Yii::app()->db->createCommand($sql2);
        $dataReader2 = $command2->queryAll();
        $i=0;$totalqty=0;
        foreach ($dataReader2 as $row2)
        {
          $this->pdf->SetFont('Arial', '', 8);
          $i += 1;
          $this->pdf->row(array(
            $i,
            $row2['productplanno'],
            $row2['productname'],
            $row2['uomcode'],
            Yii::app()->format->formatCurrency($row2['qty']),
            $row2['startdate'],
            $row2['enddate']
          ));
          $totalqty += $row2['qty'];
        }
        $this->pdf->SetFont('Arial', 'BI', 8);
        $this->pdf->coldetailalign = array('C','C','R','C','R','C','C');
        $this->pdf->row(array(
          '','',
          'JUMLAH '.$row1['description'],
          '>>>>>',
          Yii::app()->format->formatCurrency($totalqty),
          '',''
        ));
        $this->pdf->checkPageBreak(20);
      }
      $this->pdf->sety($this->pdf->gety()+5);
    }
    $this->pdf->Output();
  }*/
  //15
  public function LaporanSPPStatusBelumMax($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
			parent::actionDownPDF();
			$sql = "select distinct a.productplanid,a.companyid, a.productplanno, a.statusname, productplandate, a.description, a.recordstatus, group_concat(c.productname) as productname, d.sloccode, e.companycode
							from productplan a
							join productplanfg b on b.productplanid = a.productplanid
							join product c on c.productid = b.productid
							join sloc d on d.slocid = b.slocid
							join company e on e.companyid = a.companyid
							where a.recordstatus between 1 and 2
							and a.productplandate between ('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
							and ('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.companyid = ".$companyid."
							and d.sloccode like '%".$sloc."%'
							and c.productname like '%".$product."%'
							group by a.productplanid 
							order by a.productplanid desc";
			
			$command=Yii::app()->db->createCommand($sql);
            $dataReader=$command->queryAll();
			foreach ($dataReader as $row) 
            {
					$this->pdf->companyid = $companyid;
			}
			
			$this->pdf->title    = 'Laporan SPP Status Belum Max';
			$this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('L');
			$this->pdf->sety($this->pdf->gety() + 5);
			$this->pdf->SetFont('Arial','',9);
			$this->pdf->colalign = array(
		'C',
		'L',
		'L',
		'C',
		'C',
		'C',
		'C',
		'C',
		'C'
    );
    $this->pdf->setwidths(array(
      15,
      35,
      25,
      25,
      70,
      30,
      40,
      30
    ));
    $this->pdf->colheader = array(
      'No',
      'ID',
      'NO SPP',
          'Tanggal SPP',
      'Product',
      'Gudang',
      'Keterangan',
      'Status'
    );
    $this->pdf->RowHeader();        
    $i=1;
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L'
    );
    foreach($dataReader as $row){
        $this->pdf->row(array(
        $i,
        $row['productplanid'],
        $row['productplanno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])),
        $row['productname'],
        $row['sloccode'],
        $row['description'],
        $row['statusname']
              ));
        $i++;
    }
    $this->pdf->Output();
	}
  //16
  public function LaporanPerbandingan($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
			parent::actionDownPDF();
			$sql = "select *, qtystock-pendinganso as lbstock
							from (select distinct productid, a.productname,d.uomcode,
							(select sum(g.qty)
							from productstockdet g
							where g.productid=a.productid
							and g.unitofmeasureid=a.unitofmeasureid
							and g.slocid=a.slocid
							and g.transdate<='2017-08-13') as qtystock,
							(select ifnull(sum(e.qty-e.giqty),0)
							from sodetail e
							join soheader f on f.soheaderid=e.soheaderid
							where f.recordstatus=6
							and f.companyid=c.companyid
							and e.productid=a.productid
							and e.unitofmeasureid=a.unitofmeasureid
							and f.sodate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as pendinganso
							from productstock a
							join sloc b on b.slocid=a.slocid
							join plant c on c.plantid=b.plantid
							join unitofmeasure d on d.unitofmeasureid=a.unitofmeasureid
							where c.companyid = ".$companyid."
							and c.plantcode like '%%'
							and (a.productname like 'matras%'
							or a.productname like 'divan%'
							or a.productname like 'bed sorong%'
							or a.productname like 'sandaran%')
							order by productname) z";
			
			$command=Yii::app()->db->createCommand($sql);$dataReader=$command->queryAll();
			foreach ($dataReader as $row) 
      {
              $this->pdf->companyid = $companyid;
          }
          
          $this->pdf->title    = 'Laporan Perbandingan';
          $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
          $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
          $this->pdf->AddPage('L',array(200,355));
          $this->pdf->sety($this->pdf->gety() + 5);
          $this->pdf->SetFont('Arial','',10);
          $y = $this->pdf->getY();
          
          
          $this->pdf->text(15,$y,'No'); 
          $this->pdf->text(40,$y,'Product');
          $this->pdf->text(85,$y,'Stok Awal');
          $this->pdf->text(105,$y,'Pendingan');
          $this->pdf->text(125,$y,'Lebih /');
          $this->pdf->text(160,$y,'WIP '); 
          $this->pdf->text(195,$y,'WIP '); 
          $this->pdf->text(228,$y,'WIP ');
          $this->pdf->text(263,$y,'WIP ');
          $this->pdf->text(295,$y,'WIP ');
          $this->pdf->text(332,$y,'WIP ');
          
          $y = $this->pdf->getY()+5;
          $this->pdf->text(110,$y,'SO');
          $this->pdf->text(125,$y,'Kurang');
          $this->pdf->text(160,$y,'Kain ');
          $this->pdf->text(190,$y,'Rangka Per');
          $this->pdf->text(215,$y,'Rangka Bed Sorong');
          $this->pdf->text(255,$y,'Rangka Divan');
          $this->pdf->text(285,$y,'Rangka Sandaran');
          $this->pdf->text(330,$y,'Centian');
      
          $this->pdf->setY($this->pdf->getY()+7);
          //$this->pdf->setX(-1);
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
                    15,
                    60,
                    20,
                    20,
                    20,
                    35,
                    35,
                    35,
                    35,
                    35,
                    36,
                ));
          
            $this->pdf->RowHeader();        
              $i=1;
              $this->pdf->coldetailalign = array(
                    'C',
                    'L',
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
            foreach($dataReader as $row){
          if($row['lbstock']<0) {
              $sqlwipkain = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'wip kain%'";
              $res_kain = Yii::app()->db->createCommand($sqlwipkain)->queryAll();
              //$wipkain=$res->queryAll();
              $wipkain = '';
              foreach($res_kain as $row_kain){
                      $sqldetail_kain = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                      from productstockdet g
                        where g.productid=".$row_kain['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query = Yii::app()->db->createCommand($sqldetail_kain)->queryAll();
                      foreach($query as $row2_kain){
                          $wipkain .= $row2_kain['ukuran'].' => '.number_format($row2_kain['qty'],1)." \n";
                      }
              }
              
          }else{
              $wipkain = 0;
          }
          
          if($row['lbstock']<0) {
              $sqlwiprangkaper = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 
                        AND a.productname like 'rangka per%'";
              $res_rangkaper= Yii::app()->db->createCommand($sqlwiprangkaper)->queryAll();
              //$wipkain=$res->queryAll();
              $wiprangkaper = '';
              foreach($res_rangkaper as $row_rangkaper){
                      $sqldetail_rangkaper = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                      from productstockdet g
                        where g.productid=".$row_rangkaper['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query_rangkaper = Yii::app()->db->createCommand($sqldetail_rangkaper)->queryAll();
                      foreach($query_rangkaper as $row2_rangkaper){
                          $wiprangkaper .= $row2_rangkaper['ukuran'].' => '.number_format($row2_rangkaper['qty'],1)." \n";
                      }
              }
              
          }else{
              $wiprangkaper = 0;
          }
          
          if($row['lbstock']<0) {
              $sqlwiprangkabed = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'rangka bed sorong%'";
              $res_rangkabed= Yii::app()->db->createCommand($sqlwiprangkabed)->queryAll();
              //$wipkain=$res->queryAll();
              $wiprangkabed = '';
              foreach($res_rangkabed as $row_rangkabed){
                      $sqldetail_rangkabed = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                        from productstockdet g
                      where g.productid=".$row_rangkabed['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query_rangkabed = Yii::app()->db->createCommand($sqldetail_rangkabed)->queryAll();
                      foreach($query_rangkabed as $row2_rangkabed){
                          $wiprangkabed .= $row2_rangkabed['ukuran'].' => '.number_format($row2_rangkabed['qty'],1)." \n";
                      }
              }
              
          }else{
              $wiprangkabed = 0;
          }
          
          if($row['lbstock']<0) {
              $sqlwiprangkadivan = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 
                        AND a.productname like 'rangka divan%'";
              $res_rangkadivan= Yii::app()->db->createCommand($sqlwiprangkadivan)->queryAll();
              $sqlcount_divan = "select ifnull(count(1),0)
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'rangka divan%'";
              //$wipkain=$res->queryAll();
              $count_divan = Yii::app()->db->createCommand($sqlcount_divan)->queryScalar();
              $wiprangkadivan = '';
              if($count_divan=='0'){
                      $wiprangkadivan = '-';
                  }else{
              foreach($res_rangkadivan as $row_rangkadivan){
                      $sqldetail_rangkadivan = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                        from productstockdet g
                        where g.productid=".$row_rangkadivan['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query_rangkadivan = Yii::app()->db->createCommand($sqldetail_rangkadivan)->queryAll();
                      foreach($query_rangkadivan as $row2_rangkadivan){
                          $wiprangkadivan .= $row2_rangkadivan['ukuran'].' => '.number_format($row2_rangkadivan['qty'],1)." \n";
                      }
                  }
              }
              
          }else{
              $wiprangkadivan = 0;
          }
          
          if($row['lbstock']<0) {
              $sqlwiprangkasandaran = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'sandaran%'";
              $sqlcount_sandaran = "select ifnull(count(1),0)
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'sandaran%'";
              $count_sandaran = Yii::app()->db->createCommand($sqlcount_sandaran)->queryScalar();
              $res_rangkasandaran= Yii::app()->db->createCommand($sqlwiprangkasandaran)->queryAll();
              //$wipkain=$res->queryAll();
              $wiprangkasandaran = '';
              if($count_sandaran=='0'){
                      $wiprangkasandaran = '-';
                  }else{
                  foreach($res_rangkasandaran as $row_rangkasandaran){
                      $sqldetail_rangkasandaran = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                        from productstockdet g
                        where g.productid=".$row_rangkasandaran['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query_rangkasandaran = Yii::app()->db->createCommand($sqldetail_rangkasandaran)->queryAll();
                      foreach($query_rangkasandaran as $row2_rangkasandaran){
                          $wiprangkasandaran .= $row2_rangkasandaran['ukuran'].' => '.number_format($row2_rangkasandaran['qty'],1)." \n";
                      }
                  }
              }
              
          }else{
              $wiprangkasandaran = 0;
          }
          
          if($row['lbstock']<0) {
              $sqlwipcentian = "select c.productid as idwip, a.productname, b.productid
                        from billofmaterial b
                        left join bomdetail c on c.bomid = b.bomid
                        left join product a on a.productid = c.productid 
                        where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'centian%'";
              $res_centian= Yii::app()->db->createCommand($sqlwipcentian)->queryAll();
              //$wipkain=$res->queryAll();
              $wipcentian = '';
              foreach($res_centian as $row_centian){
                      $sqldetail_centian = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                        from productstockdet g
                      where g.productid=".$row_centian['idwip']."
                      and g.transdate<='2017-08-13'";
                      $query_centian = yii::app()->db->createCommand($sqldetail_centian)->queryAll();
                      foreach($query_centian as $row2_centian){
                          $wipcentian .= $row2_centian['ukuran'].' => '.number_format($row2_centian['qty'],1)." \n";
                      }
              }
              
          }else{
              $wipcentian = 0;
          }
          
                $this->pdf->setFont('Arial','',8);
          $this->pdf->row(array(
          $i,
          $row['productname'],
          number_format($row['qtystock'],0),
          number_format($row['pendinganso'],0),
          number_format($row['lbstock'],0),
          $wipkain,
          $wiprangkaper,
          $wiprangkabed,
          $wiprangkadivan,
          $wiprangkasandaran,
          $wipcentian
              ));
          $i++;
      }
			/*
    foreach($dataReader as $row){
        if($row['lbstock']<0) {
            $sqlwip = "SELECT IFNULL(COUNT(1),0) as jumlah, c.productid as idwip, a.productname, b.productid
                      FROM billofmaterial b
                      LEFT JOIN bomdetail c ON c.bomid = b.bomid
                      LEFT JOIN product a ON a.productid = c.productid 
                      WHERE b.productid = ".$row['productid']." AND a.isstock = 1 
                      AND a.productname like 'wip kain%'";
            $res = yii::app()->db->createCommand($sqlwip);
            $wipkain=$res->queryAll();
            foreach($wipkain as $row1){
                $sqldetail = "SELECT SUM(g.qty)
                            FROM productstockdet g
                            WHERE g.productid=".$row1['idwip']."
                            AND g.transdate<='2017-08-13'";
                $query = array();
                $query[] = yii::app()->db->createCommand($sqldetail)->queryScalar();
                
            }
            
        }else{
            $wipkain = 0;
        }
        $this->pdf->row(array(
        $i,
        $row['productname'].' '.$row['productid'],
        $row['qtystock'],
        $row['pendinganso'],
        $row['lbstock'],
        $wipkain,
        $row['pendinganso'],
        $row['pendinganso'],
        $row['pendinganso'],
        $row['pendinganso'],
        $row['pendinganso']
            ));
        $i++;
    }
    */
    $this->pdf->Output();
	}
  //17
  public function LaporanMaterialSPP($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
			parent::actionDownPDF();
			$id = '';
			 $sql = "select distinct concat(b.productplanfgid,',') as id, sum(qtyoutput) as qtyop, sum(qty) as qtyspp
							-- SELECT a.productplanid, a.productplanno, c.productoutputid, sum(qtyoutput) as qtyop, sum(qty) as qtyspp, b.productid
							from productplan a 
							join productplanfg b on a.productplanid = b.productplanid
							join productoutput c on c.productplanid = a.productplanid
							join productoutputfg d on d.productoutputid = c.productoutputid 
                            -- and d.productplanfgid = b.productplanfgid
							where a.productplandate between ('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and ('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
							and a.recordstatus = 3 and c.recordstatus = 3
							group by b.productplanfgid
							having qtyspp > qtyop";
			
			$command=Yii::app()->db->createCommand($sql);
			$dataReader=$command->queryAll();
			foreach ($dataReader as $row) 
	    {
					$this->pdf->companyid = $companyid;
			}
			foreach($dataReader as $row){
					$id .= $row['id'];
			}
			$id .= '-1';
			$this->pdf->title    = 'Laporan Material Check SPP';
			$this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('L','A4');
			$this->pdf->sety($this->pdf->gety() + 5);
			$this->pdf->SetFont('Arial','',10);
			$y = $this->pdf->getY();   
			
			$this->pdf->colalign = array(
		'C',
		'L',
		'C',
		'C',
		'C',
		'C',
		'C',
        'C'
      );
      $this->pdf->setwidths(array(
        15,
        100,
        25,
        25,
        25,
        27,
        30,
            20
      ));
          
      $this->pdf->colheader = array(
        'NO',
        'Product Name',
        'Satuan',
        'Jumlah (SPP)',
        'Qty Needed',
        'Stock',
        'Plus/Minus',
            'Link SPP'
      );

      $this->pdf->RowHeader();        
      $i=1;
      $this->pdf->coldetailalign = array(
        'C',
        'L',
        'C',
        'C',
        'R',
        'R',
        'R',
            'C'
      );
          $sql1 = "select b.productid, b.productname, sum(qty-qtyres) as qtyneed, c.uomcode,group_concat(distinct a.productplanid) as count
                  from productplandetail a
                  join product b on a.productid = b.productid
                  join unitofmeasure c on c.unitofmeasureid = a.uomid
                  where productplanfgid in (".$id.") and b.isstock = 1
                  group by productid 
                  having qtyneed > 0
                  order by productname ";
          
          $cmd1 = Yii::app()->db->createCommand($sql1)->queryAll();
          foreach($cmd1 as $row1){
              $explode = explode(',',$row1['count'],-1);
              $count = count($explode);
              $sqlstock = "select sum(qty+qtyinprogress)
                          from productstock
                          where productid =".$row1['productid']."";
              $stock = Yii::app()->db->createCommand($sqlstock)->queryScalar();
                        $url = '&company='.$companyid.'&sloc='.$sloc.'&product='.$row1['productname'].'&startdate='.$startdate.'&enddate='.$enddate;
                        $this->pdf->checkNewPage(10);
                        $this->pdf->Cell(260,5,'Lihat ','','','R',false,Yii::app()->createUrl('production/repprod/downpdf?lro=99'.$url)); 
                        $this->pdf->setX(5);
                        $this->pdf->row(array(
                            $i,
                            $row1['productname'],
                            //.$row1['productid'],
                            $row1['uomcode'],
                            ($count+1),
                            number_format($row1['qtyneed'],4),
                            number_format($stock,4),
                            number_format($stock - $row1['qtyneed'],4),
                        ));
          $i++;
      }
			
			$this->pdf->Output();
	}
  //18
  public function LaporanHasilScan($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct d.description,d.slocid
							from productoutput b
							join productoutputfg c on c.productoutputid=b.productoutputid
							join sloc d on d.slocid=c.slocid
							join product e on e.productid=c.productid
							join unitofmeasure f on f.unitofmeasureid=c.uomid
              left join employee g on g.employeeid = b.employeeid
						  where d.sloccode like '%" . $sloc . "%' ".getFieldTable($productcollectid,'e','productcollectid')."
              ".getCompanyGroup($companyid,'b')."
						  and e.productname like '%" . $product . "%' and g.fullname like '%{$fullname}%'
						  and b.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by slocid";
    $command           = yii::app()->db->createCommand($sql);
    $dataReader        = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Laporan Hasil Produksi Menggunakan Scan';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1           = "select d.productname,e.uomcode,sum(b.qtyoutput) as qtyoutput,a.productoutputno,a.productoutputdate,(select ifnull(sum(f.qtyori),0) from tempscan f where f.productoutputfgid= b.productoutputfgid) as qtyori
												from productoutput a
												join productoutputfg b on b.productoutputid=a.productoutputid
												join sloc c on c.slocid=b.slocid
												join product d on d.productid=b.productid
												join unitofmeasure e on e.unitofmeasureid=b.uomid
                        left join employee f on f.employeeid = a.employeeid
						 where c.slocid = ".$row['slocid']." ".getFieldTable($productcollectid,'d','productcollectid')."
            ".getCompanyGroup($companyid,'a')." and c.sloccode like '%" . $sloc . "%' 
						 and d.productname like '%" . $product . "%'
						 and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						 group by productname,uomcode,productoutputno
						 order by productname,productoutputdate,productoutputno";
      $command1       = yii::app()->db->createCommand($sql1);
      $dataReader1    = $command1->queryAll();
      $totalqty       = 0;
      $i              = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->sety($this->pdf->gety() + 18);
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
        10,
        100,
        12,
        15,
        15,
        22,
        20
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty OP',
        'Qty Scan',
        'No. Dok.',
        'Tanggal'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
        'L',
        'C',
        'R',
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
          Yii::app()->format->formatCurrency($row1['qtyoutput']),
          Yii::app()->format->formatCurrency($row1['qtyori']),
          $row1['productoutputno'],
          $row1['productoutputdate']
        ));
        $totalqty += $row1['qtyori'];
        $totalqtyoutput += $row1['qtyoutput'];
      }
      $this->pdf->setFont('Arial', 'B', 9);
      $this->pdf->row(array(
        '',
        'Total ' . $row['description'],
        '',
        Yii::app()->format->formatCurrency($totalqtyoutput),
        Yii::app()->format->formatCurrency($totalqty),'','',
      ));
      $subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
    }
    /*$this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'B', 11);
    $this->pdf->row(array(
      '',
      'Grand Total ',
      '',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));*/
    $this->pdf->Output();
  }
  //19
  public function LaporanHasilOperatorPerManPower($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      parent::actionDownPDF();
      $day1 = 420;
      $day5 = 360;
      $day6 = 360;
      $totalday=0;
      //$price = 267; old
      // new
      $price = 271;
      
      $sql = "select employeeid, fullname, headernote, isover, operatoroutputid, sum(ctover) as ctover from (select a.employeeid, c.fullname, b.headernote,isover,ctover,b.operatoroutputid
            from operatoroutputdet a
            join operatoroutput b on b.operatoroutputid = a.operatoroutputid
            join employee c on c.employeeid = a.employeeid
            join sloc e on e.slocid = b.slocid
            where b.opoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and c.fullname like '%{$fullname}%'
            and e.sloccode like '%{$sloc}%'
            and b.recordstatus= getwfmaxstatbywfname('appopoutput')
            and isover=0
            union
            select a.employeeid, c.fullname, if(b.headernote<>'',b.headernote,if(a.description<>'',concat('KET ',a.description),'LEMBUR')) as headernote,isover,ctover,b.operatoroutputid
            from operatoroutputdet a
            join operatoroutput b on b.operatoroutputid = a.operatoroutputid
            join employee c on c.employeeid = a.employeeid
            join sloc e on e.slocid = b.slocid
            where b.opoutputdate between  '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and b.companyid = {$companyid}
            and c.fullname like '%{$fullname}%'
            and e.sloccode like '%{$sloc}%'
            and b.recordstatus= getwfmaxstatbywfname('appopoutput')
            and isover=1 ) z
            group by employeeid,isover
            order by fullname";
      
      $command = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      foreach ($dataReader as $row) {
        $this->pdf->companyid = $companyid;
      }
      $this->pdf->title    = 'Laporan Hasil Operator Per Man Power';
      $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
      $this->pdf->AddPage('P');
      
      $dates = dateRange($startdate,$enddate);
      for($j=0; $j<count($dates); $j++)
      {
          if(date('l',strtotime($dates[$j]))=='Monday' || date('l',strtotime($dates[$j]))=='Tuesday' || date('l',strtotime($dates[$j]))=='Wednesday' || date('l',strtotime($dates[$j]))=='Thursday')
          {
              $totalday += $day1;
          }
          else if(date('l',strtotime($dates[$j]))=='Friday')
          {
              $totalday += $day5; 
          }
          else if(date('l',strtotime($dates[$j]))=='Saturday')
          {
              $totalday += $day6; 
          }
          else
          {
              $totalday += 0; 
          }
      }
      $isover=0;$totalct2=0;$totalqty2=0;
      foreach($dataReader as $row)
      {
          $this->pdf->SetFont('Arial', 'B', 10);
          if($row['isover']==0)
          {
              $this->pdf->text(10, $this->pdf->gety() + 5, 'JAM OPERASIONAL ');
              $this->pdf->text(165, $this->pdf->gety() + 10, 'Jumlah CT: '.$totalday);
              $this->pdf->text(10, $this->pdf->gety() + 10, 'Operator : '.$row['fullname']);
          }
          else
          {
              //$this->pdf->setY($this->pdf->getY()+5);
              $totalct1 = $totalct2;
              $totalqty1 = $totalqty2;  
              $this->pdf->text(10, $this->pdf->gety() + 10, 'TAMBAHAN WAKTU / LEMBUR ');
              $this->pdf->text(165, $this->pdf->gety() + 10, 'CT Lembur: '.number_format($row['ctover'],0,'.',','));
          }
          
          $this->pdf->text(10, $this->pdf->gety() + 15, 'Keterangan : '.$row['headernote']);
          if($row['isover']==0)
          {
              $isover = 0;
          }
          else
          {
              $isover = 1;
          }
            $sql1 = "select a.opoutputdate, c.fullname, sum(b.qty) as qty,         
                d.groupname,sum(b.cycletime*qty) as cycletime, b.operatoroutputdetid,b.description,a.headernote
                from operatoroutput a
                join operatoroutputdet b on b.operatoroutputid = a.operatoroutputid
                join employee c on c.employeeid = b.employeeid
                join standardopoutput d on d.standardopoutputid = b.standardopoutputid
                where b.employeeid = ".$row['employeeid']."
                and a.opoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                and a.recordstatus= getwfmaxstatbywfname('appopoutput')
                and a.isover = {$isover}
                group by b.standardopoutputid,opoutputdate
                order by opoutputdate";

          $command1 = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          $i=0;
          //$totalqty1 = 0;
          $totalqty2 = 0;
          //$totalct1 = 0;
          $totalct2 = 0;
          $this->pdf->sety($this->pdf->gety() + 18);
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
            10,
            25,
            70,
            20,
            20,
            32,
            20
          ));
          $this->pdf->colheader = array(
            'No',
            'Tanggal',
            'Nama Grup',
            'Qty Hasil',
            'Cycle Time',
            'Note',
            'Isentif'
          );
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array(
            'C',
            'L',
            'L',
            'R',
            'R',
            'L',
            'R'
          );
          $this->pdf->setFont('Arial', '', 8);
          foreach($dataReader1 as $row1)
          {
              $i += 1;
              $sql2 = "select ifnull(count(1),0)
                      from operatoroutputissue a
                      where a.operatoroutputdetid = ".$row1['operatoroutputdetid'];
              $getcount = yii::app()->db->createCommand($sql2)->queryScalar();
              $this->pdf->row(array(
                $i,
                $row1['opoutputdate'],
                $row1['groupname'],
                Yii::app()->format->formatCurrency($row1['qty']),
                Yii::app()->format->formatCurrency($row1['cycletime']),
                $row1['description'],
              ));
              if($getcount>0)
              {
                $sql3 = "select description, cycletime from operatoroutputissue where operatoroutputdetid = ".$row1['operatoroutputdetid'];
                $command3 = yii::app()->db->createCommand($sql3);
                $dataReader3 = $command3->queryAll();
                foreach($dataReader3 as $row3)
                {
                    $this->pdf->row(array(
                    '',
                    'Issue :' ,
                    $row3['description'],
                    '',
                    Yii::app()->format->formatCurrency($row3['cycletime']),
                    ));
                    $totalct2 += $row3['cycletime'];
                }
              }
              $totalct2 += $row1['cycletime'];
              $totalqty2 += $row1['qty'];
          }
          /*
          if($isover==1)
          {
              $totalct1 = $totalct2;
              $totalqty1 = $totalqty2;
          }*/
          $this->pdf->setFont('Arial','B',9);
          $this->pdf->row(array(
                '',
                'TOTAL',
                '',
                Yii::app()->format->formatCurrency($totalqty2),
                Yii::app()->format->formatCurrency($totalct2),
                '',
              ));
          $this->pdf->checkNewpage(20);
          if($isover==0)
          {
              $this->pdf->setY($this->pdf->getY()+10);
          }
          if($totalct2 > $totalday)
          {
              $this->pdf->setwidths(array(
                10,
                25,
                50,
                60,
                30,
                50
              ));
              $this->pdf->colalign = array(
                'R',
                'R',
                'R',
                'R',
                'R',
                'R'
              );
              $this->pdf->row(array(
                '',
                '',
                'Jumlah Kelebihan CT : ',
                Yii::app()->format->formatCurrency(($totalct2-$totalday)),
                '',
                'Rp. '.Yii::app()->format->formatCurrency(($totalct2-$totalday)*$price),
              ));
          }
          if($isover==1)
          {
              $this->pdf->setwidths(array(
                10,
                25,
                50,
                60,
                30,
                50
              ));
              $this->pdf->colalign = array(
                'R',
                'R',
                'R',
                'R',
                'R',
                'R'
              );
              $this->pdf->row(array(
                '',
                '',
                'Jumlah Hasil (CT) - CT Lembur: ',
                Yii::app()->format->formatCurrency(($totalct2-$row['ctover'])),
                '',
                //'Rp. '.Yii::app()->format->formatCurrency(($totalct-$totalday)*$price),
              ));
              
            if($totalct1 > $totalday)
            {
                $this->pdf->text(10,$this->pdf->getY(),'Kelebihan CT : '.number_format($totalct1-$totalday,0,',','.'));
            }
            else
            {
                $this->pdf->text(10,$this->pdf->getY(),'Kekurangan CT : '.number_format($totalday - $totalct1,0,',','.'));
            }
            
            if($totalct2 > $row['ctover'])
            {
                $this->pdf->text(10,$this->pdf->getY()+5,'Kelebihan CT Lembur: '.number_format($totalct2-$row['ctover'],0,',','.'));
            }
            else
            {
                $this->pdf->text(10,$this->pdf->getY()+5,'Kekurangan CT Lembur: '.number_format($row['ctover']-$totalct2,0,',','.'));
            }
            $this->pdf->Line(10, $this->pdf->getY()+7, 210-10, $this->pdf->getY()+7);
            $this->pdf->setY($this->pdf->getY()+10);
          }
          //$this->pdf->setY($this->pdf->getY()+5);
          //$this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      }
      $this->pdf->Output();
      
  }
  //20
  public function LaporanCTPerForemanPerDokumen($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      parent::actionDownPDF();
      $insentif = 0;
      $hk = 400;
      
      $datetime1 = new DateTime($startdate);
      $datetime2 = new DateTime($enddate);
      $interval = $datetime1->diff($datetime2)->format('%a')+1;
      
      $capacity = $interval * $hk;
      $vinsentif = getUserObjectValues($menuobject='insentif');
      
      $sql = "select distinct b.slocid, c.sloccode, c.description
            from productoutput a
            join productoutputfg b on b.productoutputid = a.productoutputid
            join sloc c on c.slocid = b.slocid
            left join employee d on d.employeeid = a.employeeid
            left join product e on e.productid = b.productid
            where a.companyid = {$companyid} and a.recordstatus = 3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and c.sloccode like '%{$sloc}%' 
            and e.productname like '%{$product}%'";
      if($fullname!='')
      {
        $sql .= " and d.fullname like '%".$fullname."%'";
      }
      $this->pdf->title    = 'Laporan Hasil Produksi By Kapasitas Cycle Time';
      $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
      $this->pdf->AddPage('P',array(240,297));
      $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
      
      if(getUserObjectValues('insentif')==1) {
          $insentif=1;
          $sqlinsentif = "select ifnull(a.price,0)
            from standardinsentif a
            where a.companyid = {$companyid} and (month(a.perioddate) = month('".date(Yii::app()->params['datetodb'],strtotime($startdate))."') 
            or year(perioddate) = year('".date(Yii::app()->params['datetodb'],strtotime($startdate))."')) and a.recordstatus = getwfmaxstatbywfname('appsi')
            order by perioddate desc limit 1";
          $insentif = Yii::app()->db->createCommand($sqlinsentif)->queryScalar();
      }
      
      //$this->pdf->setY($this->pdf->getY()+10);
      foreach($dataReader as $row)
      {
          $this->pdf->setY($this->pdf->getY());
          $this->pdf->setFont('Arial','',9);
          $this->pdf->text(10,$this->pdf->getY()+5,'GUDANG ');
          $this->pdf->text(50,$this->pdf->getY()+5,' : '.$row['description'].' '.$capacity);
          
          $sqlemp = "select group_concat(distinct a.employeeid)
          from productoutput a
          left join productoutputfg b on b.productoutputid = a.productoutputid
          left join employee c on c.employeeid = a.employeeid
          where a.companyid = ".$companyid." and b.slocid = ".$row['slocid']."
          and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."' and a.recordstatus = 3
          and c.fullname like '%{$fullname}%' ";
          $emp = Yii::app()->db->createCommand($sqlemp)->queryScalar();
          
          $sql1 = "select distinct ifnull(c.fullname,'UMUM') as fullname ,ifnull(c.employeeid,0) as employeeid
                  from productoutput a
                  join productoutputfg b on b.productoutputid = a.productoutputid
                  left join employee c on c.employeeid = a.employeeid
                  left join sloc d on d.slocid = b.slocid
                  left join product e on e.productid = b.productid
                  where a.recordstatus = 3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                  and b.slocid = ".$row['slocid']." and e.productname like '%{$product}%' and c.employeeid in({$emp})
                  and c.fullname like '%{$fullname}%'
                  union
                  select distinct c.fullname, a.employeeid
                  from issue a
                  join employee c on c.employeeid = a.employeeid
                  where docdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                  and a.recordstatus = getwfmaxstatbywfname('appissue')
                  and c.fullname like '%{$fullname}%' 
                  and c.employeeid in({$emp})";
          
          /*
          if($fullname!='')
          {
              $sql1 .= " and c.fullname like '%".$fullname."%'";
          }   
          */
          $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
          foreach($dataReader1 as $row1)
          {
              $issue = 0;
              $this->pdf->setFont('Arial','',9);
              
              $sqlforeman = "select ifnull(jumlah,0) as jumlah from foremaninfo where companyid = ".$companyid." and employeeid = ".$row1['employeeid']." and perioddate = '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and recordstatus=1";
              $qforeman = Yii::app()->db->createCommand($sqlforeman)->queryScalar();
            
              $capacity = $qforeman ;
                  
              $this->pdf->setY($this->pdf->getY()+5);
              $this->pdf->text(10,$this->pdf->getY()+10, 'FOREMAN ');
              $this->pdf->text(50,$this->pdf->getY()+10, ' : '.$row1['fullname'].' / '.$qforeman.' OPERATOR');
              
              $this->pdf->setY($this->pdf->getY()+15);
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
                25,
                70,
                15,
                20,
                20,
                25,
                20,
                20
              ));
              $this->pdf->colheader = array(
                'NO',
                'NO. SPP',
                'NAMA BARANG',
                'SATUAN',
                'QTY.SPP',
                'CT.SPP',
                'NO.OP',
                'QTY.OP',
                'CT.OP'
              );
              $this->pdf->RowHeader();
              $this->pdf->coldetailalign = array(
                'C',
                'L',
                'L',
                'C',
                'R',
                'R',
                'L',
                'R',
                'R'
              );
              $this->pdf->setFont('Arial', '', 8);
              $sql2 = "select d.productname, a.productoutputno, b.qtyoutput, ((b.qtyoutput*cycletime)/60) as ctop,
                      ((select (qty*bb.cycletime) 
                       from productplanfg bb 
                       where bb.productplanfgid = b.productplanfgid and bb.productid = b.productid)/60) as ctspp,
                       (select qty
                       from productplanfg bb 
                       where bb.productplanfgid = b.productplanfgid and bb.productid = b.productid) as qtyspp,
                       e.uomcode, f.productplanno
                     from productoutput a 
                     join productoutputfg b on b.productoutputid = a.productoutputid
                     join productplan f on f.productplanid = a.productplanid
                     left join employee c on c.employeeid = a.employeeid
                     join product d on d.productid = b.productid
                     join unitofmeasure e on e.unitofmeasureid = b.uomid
                     where a.recordstatus=3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                     and b.slocid = {$row['slocid']} and d.productname like '%{$product}%'";
              if($row1['employeeid'] > 0) {
                  $sql2 .= " and c.employeeid = ".$row1['employeeid'];
              }
              
              $this->pdf->setY = $this->pdf->getY()+5;
              $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
              $i = 1;
              foreach($dataReader2 as $row2)
              {
                  $this->pdf->row(array(
                    $i,
                    $row2['productplanno'],
                    $row2['productname'],
                    $row2['uomcode'],
                    Yii::app()->format->formatCurrency($row2['qtyspp']),
                    Yii::app()->format->formatCurrency($row2['ctspp']),
                    $row2['productoutputno'],
                    Yii::app()->format->formatCurrency($row2['qtyoutput']),
                    Yii::app()->format->formatCurrency($row2['ctop'])
                    ));
                  $i++;
              }
              
              //if($row1['issued']==1) {
                  $this->pdf->setY($this->pdf->getY()+5);
                  //$this->pdf->text(5,$this->pdf->getY(),'Issued');
                  $sqlissued = "select a.docdate, ifnull((-1*(a.cycletime/60)*a.jumlah),0) as cycletime, a.description
                            from issue a
                            where a.recordstatus = getwfmaxstatbywfname('appissue') 
                            and a.docdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."' 
                            and a.companyid = {$companyid} and a.employeeid = {$row1['employeeid']}";
                  $res = Yii::app()->db->createCommand($sqlissued)->queryAll();
                  //$i=1;
                  foreach($res as $result) {
                       $this->pdf->row(array(
                           $i,
                           date(Yii::app()->params['dateviewfromdb'],strtotime($result['docdate'])),
                           $result['description'],
                           '','','','','',
                           Yii::app()->format->formatCurrency($result['cycletime'])
                    ));
                      $issue = $issue + $result['cycletime'];
                      $i++;
                  }
                            
              //}
              //$x = 5;
              $sqlct = "select datediff('".date(Yii::app()->params['datetodb'],strtotime($enddate))."','".date(Yii::app()->params['datetodb'],strtotime($startdate))."') + 1 as days,
                    sum(ctop) as ctop, sum(cycletime*za.qty)/60 as ctspp
                    from (select sum(b.qtyoutput*cycletime)/60 as ctop, b.productplanfgid
                     from productoutput a 
                     join productoutputfg b on b.productoutputid = a.productoutputid
                     join productplan f on f.productplanid = a.productplanid
                     left join employee c on c.employeeid = a.employeeid
                     join product d on d.productid = b.productid
                     join unitofmeasure e on e.unitofmeasureid = b.uomid
                     where a.recordstatus=3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                     and b.slocid = {$row['slocid']} and a.employeeid = {$row1['employeeid']} and d.productname like '%{$product}%'
                     group by b.productplanfgid
                     )z
                     join productplanfg za on za.productplanfgid = z.productplanfgid";
              $ct = Yii::app()->db->createCommand($sqlct)->queryRow();
              $sqlct = Yii::app()->db->createCommand($sqlct)->queryRow();
              $this->pdf->checkPageBreak(20);
              $this->pdf->text(110,$this->pdf->getY()+5,"TOTAL CYLETIME {$ct['days']} HARI KERJA ");
              $this->pdf->text(160,$this->pdf->getY()+5,' : '.$ct['days']*$hk.' MENIT');
              $this->pdf->text(110,$this->pdf->getY()+10,"STANDARD CAPACITY ");
              $this->pdf->text(160,$this->pdf->getY()+10,' : '.($ct['days']*$hk)*$qforeman.' MENIT');
              $this->pdf->text(110,$this->pdf->getY()+15,'TOTAL CYLETIME SPP ');
              $this->pdf->text(160,$this->pdf->getY()+15,' : '.Yii::app()->format->formatCurrency($ct['ctspp']).' MENIT');
              $this->pdf->text(110,$this->pdf->getY()+20,'TOTAL CYLETIME OP ');
              $this->pdf->text(160,$this->pdf->getY()+20,' : '.Yii::app()->format->formatCurrency(($ct['ctop']+$issue)).' MENIT');
              if($vinsentif==1) {
                  if($qforeman == 0 || $insentif == 0)
                  {
                      $this->pdf->setFont('Arial','B',9);
                      $this->pdf->text(110,$this->pdf->getY()+25,'JUMLAH FOREMAN / INSENTIF BELUM DITENTUKAN');
                  }
                  else
                  {
                      $this->pdf->text(110,$this->pdf->getY()+25,'TOTAL INSENTIF ');
                      $this->pdf->text(160,$this->pdf->getY()+25,' : Rp '.Yii::app()->format->formatCurrency((($ct['ctop']+$issue)-($ct['days']*$hk*$qforeman))*$insentif));
                  }
              }
              //$this->pdf->text(10,$this->pdf->getY()+30,' : Rp '.($ct['ctop'].$issue).' - '.$ct['days'].'X'.$hk.'X'.$qforeman.'X'.$insentif);
              $this->pdf->setY($this->pdf->getY()+20);
              $this->pdf->checkPageBreak(20);
          }
          $this->pdf->setY($this->pdf->getY()+10);
      }
      $this->pdf->Output();
  }
  //21
  public function LaporanRincianHasilProduksiPerGMprocess($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
		parent::actionDownPDF();
		$i=0;$qtyoutput1=0;$qtyoutput2=0;$qtyoutput3=0;$qtyoutput4=0;$qtyoutput5=0;$qtyoutput6=0;
		$sqltgl = "SELECT DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH) AS tgl1,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH) AS tgl2,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH) AS tgl3,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH) AS tgl4,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH) AS tgl5,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH) AS tgl6";
		$title = Yii::app()->db->createCommand($sqltgl)->queryRow();
		
		$sql = "SELECT *
						FROM (SELECT a.productid,a.productname,f.description,c.uomcode
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput1
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput2
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput3
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput4
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput5
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput6
						FROM product a
						JOIN productplant b ON b.productid = a.productid
						JOIN unitofmeasure c ON c.unitofmeasureid = b.unitofissue
						JOIN sloc d ON d.slocid = b.slocid
						JOIN plant e ON e.plantid = d.plantid
						JOIN mgprocess f ON f.mgprocessid = b.mgprocessid
						WHERE a.recordstatus = 1
						AND a.isstock = 1
						AND e.companyid = ".$companyid."
						AND a.productname like '%".$product."%'
						AND d.sloccode like '%".$sloc."%'
						) z
						WHERE qtyoutput1 <> 0 OR qtyoutput2 <> 0 OR qtyoutput3 <> 0 OR qtyoutput4 <> 0 OR qtyoutput5 <> 0 OR qtyoutput6 <> 0
						ORDER BY description
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->pdf->title    = 'Laporan Rincian Hasil Produksi Per Material Group Process';
		$this->pdf->subtitle = 'Periode : ' . date("F Y", strtotime($enddate));
		$this->pdf->AddPage('L','A4'); //array(240,297)
		
		$this->pdf->setY($this->pdf->getY()+0);
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
			'C'
		);
		$this->pdf->setwidths(array(
			10,
			90,
			45,
			15,
			20,
			20,
			20,
			20,
			20,
			20
		));
		$this->pdf->colheader = array(
			'No',
			'NAMA BARANG',
			'MATERIAL GRUP PROSES',
			'SATUAN',
			date("F Y", strtotime($title['tgl1'])),
			date("F Y", strtotime($title['tgl2'])),
			date("F Y", strtotime($title['tgl3'])),
			date("F Y", strtotime($title['tgl4'])),
			date("F Y", strtotime($title['tgl5'])),
			date("F Y", strtotime($title['tgl6']))
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
			'R',
			'R'
		);
		
		//$this->pdf->setY($this->pdf->getY()+10);
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial', '', 8);
			
			//$this->pdf->setY = $this->pdf->getY()+5;
			$i++;
			$this->pdf->row(array(
				$i,
				$row['productname'],
				$row['description'],
				$row['uomcode'],
				Yii::app()->format->formatCurrency($row['qtyoutput1']),
				Yii::app()->format->formatCurrency($row['qtyoutput2']),
				Yii::app()->format->formatCurrency($row['qtyoutput3']),
				Yii::app()->format->formatCurrency($row['qtyoutput4']),
				Yii::app()->format->formatCurrency($row['qtyoutput5']),
				Yii::app()->format->formatCurrency($row['qtyoutput6'])
			));
			$qtyoutput1 += $row['qtyoutput1'];
			$qtyoutput2 += $row['qtyoutput2'];
			$qtyoutput3 += $row['qtyoutput3'];
			$qtyoutput4 += $row['qtyoutput4'];
			$qtyoutput5 += $row['qtyoutput5'];
			$qtyoutput6 += $row['qtyoutput6'];
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->setwidths(array(
			160,
			20,
			20,
			20,
			20,
			20,
			20
		));
		$this->pdf->coldetailalign = array(
			'R',
			'C',
			'R',
			'R',
			'R',
			'R',
			'R',
			'R'
		);
		$this->pdf->row(array(
			'TOTAL >>>',
			Yii::app()->format->formatCurrency($qtyoutput1),
			Yii::app()->format->formatCurrency($qtyoutput2),
			Yii::app()->format->formatCurrency($qtyoutput3),
			Yii::app()->format->formatCurrency($qtyoutput4),
			Yii::app()->format->formatCurrency($qtyoutput5),
			Yii::app()->format->formatCurrency($qtyoutput6)
		));
		$this->pdf->Output();
  }
  //22
  public function LaporanRekapHasilProduksiPerGMprocess($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
		parent::actionDownPDF();
		$i=0;$qtyoutput1=0;$qtyoutput2=0;$qtyoutput3=0;$qtyoutput4=0;$qtyoutput5=0;$qtyoutput6=0;
		$sqltgl = "SELECT DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH) AS tgl1,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH) AS tgl2,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH) AS tgl3,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH) AS tgl4,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH) AS tgl5,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH) AS tgl6";
		$title = Yii::app()->db->createCommand($sqltgl)->queryRow();
		
		$sql = "SELECT description,uomcode,SUM(qtyoutput1) AS qtyoutput1,SUM(qtyoutput2) AS qtyoutput2,SUM(qtyoutput3) AS qtyoutput3,SUM(qtyoutput4) AS qtyoutput4,SUM(qtyoutput5) AS qtyoutput5,SUM(qtyoutput6) AS qtyoutput6
						FROM (SELECT a.productid,a.productname,f.description,c.uomcode
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput1
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput2
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput3
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput4
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput5
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput6
						FROM product a
						JOIN productplant b ON b.productid = a.productid
						JOIN unitofmeasure c ON c.unitofmeasureid = b.unitofissue
						JOIN sloc d ON d.slocid = b.slocid
						JOIN plant e ON e.plantid = d.plantid
						JOIN mgprocess f ON f.mgprocessid = b.mgprocessid
						WHERE a.recordstatus = 1
						AND a.isstock = 1
						AND e.companyid = ".$companyid."
						AND a.productname like '%".$product."%'
						AND d.sloccode like '%".$sloc."%'
						) z
						WHERE qtyoutput1 <> 0 OR qtyoutput2 <> 0 OR qtyoutput3 <> 0 OR qtyoutput4 <> 0 OR qtyoutput5 <> 0 OR qtyoutput6 <> 0
						GROUP BY description
						ORDER BY description
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->pdf->title    = 'Laporan Rekap Hasil Produksi Per Material Group Process';
		$this->pdf->subtitle = 'Periode : ' . date("F Y", strtotime($enddate));
		$this->pdf->AddPage('P','A4'); //array(240,297)
		
		$this->pdf->setY($this->pdf->getY()+0);
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
			45,
			15,
			20,
			20,
			20,
			20,
			20,
			20
		));
		$this->pdf->colheader = array(
			'No',
			'MATERIAL GRUP PROSES',
			'SATUAN',
			date("F Y", strtotime($title['tgl1'])),
			date("F Y", strtotime($title['tgl2'])),
			date("F Y", strtotime($title['tgl3'])),
			date("F Y", strtotime($title['tgl4'])),
			date("F Y", strtotime($title['tgl5'])),
			date("F Y", strtotime($title['tgl6']))
		);
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array(
			'C',
			'L',
			'C',
			'R',
			'R',
			'R',
			'R',
			'R',
			'R'
		);
		
		//$this->pdf->setY($this->pdf->getY()+10);
		foreach($dataReader as $row)
		{
			$this->pdf->setFont('Arial', '', 8);
			
			//$this->pdf->setY = $this->pdf->getY()+5;
			$i++;
			$this->pdf->row(array(
				$i,
				$row['description'],
				$row['uomcode'],
				Yii::app()->format->formatCurrency($row['qtyoutput1']),
				Yii::app()->format->formatCurrency($row['qtyoutput2']),
				Yii::app()->format->formatCurrency($row['qtyoutput3']),
				Yii::app()->format->formatCurrency($row['qtyoutput4']),
				Yii::app()->format->formatCurrency($row['qtyoutput5']),
				Yii::app()->format->formatCurrency($row['qtyoutput6'])
			));
			$qtyoutput1 += $row['qtyoutput1'];
			$qtyoutput2 += $row['qtyoutput2'];
			$qtyoutput3 += $row['qtyoutput3'];
			$qtyoutput4 += $row['qtyoutput4'];
			$qtyoutput5 += $row['qtyoutput5'];
			$qtyoutput6 += $row['qtyoutput6'];
			$this->pdf->checkPageBreak(20);
		}
		$this->pdf->setFont('Arial', 'B', 8);
		$this->pdf->setwidths(array(
			70,
			20,
			20,
			20,
			20,
			20,
			20
		));
		$this->pdf->coldetailalign = array(
			'R',
			'C',
			'R',
			'R',
			'R',
			'R',
			'R',
			'R'
		);
		$this->pdf->row(array(
			'TOTAL >>>',
			Yii::app()->format->formatCurrency($qtyoutput1),
			Yii::app()->format->formatCurrency($qtyoutput2),
			Yii::app()->format->formatCurrency($qtyoutput3),
			Yii::app()->format->formatCurrency($qtyoutput4),
			Yii::app()->format->formatCurrency($qtyoutput5),
			Yii::app()->format->formatCurrency($qtyoutput6)
		));
		$this->pdf->Output();
  }
  //23
  public function RekapPemakaianPerBarang($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    parent::actionDownPDF();
    if($companyid > 0){$joincom = ""; $wherecom = " and c.companyid = ".$companyid." ";}else{$joincom = " join company a9 on a9.companyid=c.companyid "; $wherecom = " and a9.isgroup = 1";}
      $sql        = "select distinct a.toslocid,a.fromslocid,
            e.sloccode fromsloccode,
        e.description as fromslocdesc,
        f.sloccode as tosloccode,	
        f.description as toslocdesc
            from productoutputdetail a
            join product b on b.productid = a.productid
            join productoutput c on c.productoutputid = a.productoutputid
            join sloc e on e.slocid = a.fromslocid
            join sloc f on f.slocid = a.toslocid
            where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'c')."
            -- and (e.sloccode like '%" . $sloc . "%' or f.sloccode like '%" . $sloc . "%') 
            and b.productname like '%" . $product . "%' and c.productoutputdate between 
            '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
            '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
            limit 1
    ";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pemakaian Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      //$this->pdf->text(10, $this->pdf->gety() + 10, 'Asal');
      //$this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      //$this->pdf->text(10, $this->pdf->gety() + 15, 'Tujuan');
      //$this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'c')."
						-- and a.fromslocid = " . $row['fromslocid'] . " and a.toslocid = " . $row['toslocid'] . "
						and b.productname like '%" . $product . "%' and c.productoutputdate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
						'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						group by productname,uomcode";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
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
          Yii::app()->format->formatNumber($row1['qty'])
        ));
        $totalqty += $row1['qty'];
      }
      //$this->pdf->row(array('','Total','',Yii::app()->format->formatNumber($totalqty)));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //99
  public function LaporanProductDetailSPP($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      parent::actionDownPDF();
      $sql = "select * from (select a.productplanno, productplandate, b.startdate, b.enddate, a.description, sum(g.qtyoutput) as qtyoutput, b.qty
              from productplan a 
              join productplanfg b on b.productplanid = a.productplanid
              join productplandetail c on c.productplanid = b.productplanid
              join productoutput f on f.productplanid = a.productplanid
              join productoutputfg g on g.productoutputid = f.productoutputid
              join product d on d.productid = c.productid
              join sloc e on e.slocid = b.slocid
              where d.productname like '%{$product}%' 
              and a.productplandate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."' ".getFieldTable($productcollectid,'d','productcollectid')." ".getCompanyGroup($companyid,'f')."
              and e.sloccode like '%{$sloc}%' and a.recordstatus=3 and f.recordstatus=3
              group by a.productplanid) z where z.qty > z.qtyoutput";
      
      $command=yii::app()->db->createCommand($sql);
      $dataReader=$command->queryAll();
      foreach ($dataReader as $row) 
      {
		    $this->pdf->companyid = $companyid;
      }
			
      $this->pdf->title    = 'Laporan Detail SPP. Product ('.$product.')';
      $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
      $this->pdf->AddPage('L');
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->SetFont('Arial','',9);
      $this->pdf->colalign = array('C','L','L','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,25,25,25,25,35,35,35,35));
      $this->pdf->colheader = array(
        'No',
        'NO SPP',
        'Tanggal SPP',
        'Tanggal Mulai',
        'Tanggal Selesai',
        'Keterangan',
        'Qty SPP',
        'Qty Output',
        'Sisa'
      );
      $this->pdf->RowHeader();        
      $i=1;
      $totalqty=0;$totalqtyoutput=0;
	  $this->pdf->coldetailalign = array('L','L','L','L','L','L','R','R','R');
      foreach($dataReader as $row)
      {
          $this->pdf->row(array(
            $i,
            $row['productplanno'],
            date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])),
            date(Yii::app()->params['dateviewfromdb'], strtotime($row['startdate'])),
            date(Yii::app()->params['dateviewfromdb'], strtotime($row['enddate'])),
            $row['description'],
            $row['qty'],
            $row['qtyoutput'],
            $row['qty']-$row['qtyoutput']
        ));
        $totalqty +=$row['qty'];
        $totalqtyoutput +=$row['qtyoutput'];
        $i++;
	  }
    $this->pdf->setFont('Arial','B',10);
    $this->pdf->row(array(
            '',
            'Total',
            '','','','',
            Yii::app()->format->FormatNumber($totalqty),
            Yii::app()->format->FormatNumber($totalqtyoutput),
            Yii::app()->format->FormatNumber($totalqty-$totalqtyoutput)));
    $this->pdf->Output();
  }
   
	public function actionDownXLS()
	{
	  parent::actionDownXLS();
        $this->RincianProduksiPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		{
		  if ($_GET['lro'] == 1) {
			$this->RincianProduksiPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 2) {
			$this->RekapProduksiPerGroupMaterialPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 3) {
			$this->RincianPemakaianPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 4) {
			$this->RekapPemakaianPerGudangPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 5) {
			$this->PerbandinganPlanningOutputXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 6) {
			$this->RwBelumAdaGudangAsalXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 7) {
			$this->RwBelumAdaGudangTujuanXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 8) {
			$this->PendinganProduksiXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 9) {
			$this->RincianPendinganProduksiPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 10) {
			$this->RekapPendinganProduksiPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 11) {
			$this->RekapProduksiPerBarangPerHariXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 12) {
			$this->RekapHasilProduksiPerDokumentBelumStatusMaxXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 13) {
			$this->RekapProduksiPerBarangPerBulanXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 14) {
			$this->JadwalProduksiXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 15) {
			$this->LaporanSPPStatusBelumMaxXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 16) {
			$this->LaporanPerbandinganXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 17) {
			$this->LaporanMaterialSPPXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 18) {
			$this->LaporanHasilScanXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 19) {
			$this->LaporanHasilOperatorPerManPowerXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 20) {
			$this->LaporanCTPerForemanPerDokumenXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 21) {
			$this->LaporanRincianHasilProduksiPerGMprocessXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 22) {
			$this->LaporanRekapHasilProduksiPerGMprocessXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 23) {
			$this->RekapPemakaianPerBarangXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  } else if ($_GET['lro'] == 99) {
			$this->LaporanProductDetailSPPXLS($_GET['company'], $_GET['sloc'], $_GET['fullname'], $_GET['product'], $_GET['productcollectid'], $_GET['startdate'], $_GET['enddate']);
		  }
		}
	}
  //1
  public function RincianProduksiPerDokumenXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rincianproduksiperdokumen';
    parent::actionDownxls();
    $totalppn       = 0;
    $totalnetto     = 0;
    $totalallqty    = 0;
    $totalalljumlah = 0;
    $sql = "select distinct a.productoutputno,a.productoutputdate,a.productoutputid,e.productplanno as spp
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
        join employee f on f.employeeid = e.employeeid
				where a.recordstatus = 3 and a.productoutputno is not null and d.sloccode like '%" . $sloc . "%' 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%'
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and f.fullname like '%{$fullname}%' order by productoutputdate";
    $command        = yii::app()->db->createCommand($sql);
    $dataReader     = $command->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productoutputno'])->setCellValueByColumnAndRow(5, $line, 'No. SPP')->setCellValueByColumnAndRow(6, $line, ': ' . $row['spp']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productoutputdate'])->setCellValueByColumnAndRow(5, $line, 'Tanggal')->setCellValueByColumnAndRow(6, $line, ': ' . $row['productplandate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Gudang')->setCellValueByColumnAndRow(5, $line, 'Keterangan');
      $line++;
      $i           = 0;
      $totalqty    = 0;
      $sql1        = "select distinct b.productname,a.qtyoutput,c.uomcode,a.description ,d.description as sloc
						from productoutputfg a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join sloc d on d.slocid = a.slocid
						where b.productname like '%" . $product . "%' and a.productoutputid = " . $row['productoutputid'];
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qtyoutput'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, $row1['sloc'])->setCellValueByColumnAndRow(5, $line, $row1['description']);
        $line++;
        $totalqty += $row1['qtyoutput'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, '')->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty)->setCellValueByColumnAndRow(3, $line, '')->setCellValueByColumnAndRow(4, $line, '')->setCellValueByColumnAndRow(5, $line, '');
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //2
  public function RekapProduksiPerGroupMaterialPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rekapproduksipergroupmaterialperbarang';
    parent::actionDownxls();
	  if($companyid > 0){$joincom = ""; $joincom1 = ""; $wherecom = " and e.companyid = ".$companyid." "; $wherecom1 = " and g.companyid = ".$companyid." ";}else{$joincom = " join company a9 on a9.companyid=e.companyid "; $joincom1 = " join company a9 on a9.companyid=g.companyid "; $wherecom = " and a9.isgroup = 1"; $wherecom1 = " and a9.isgroup = 1";}
    $sql = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
        left join employee h on h.employeeid = a.employeeid
				where a.productoutputno is not null  and a.recordstatus = 3 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and h.fullname like '%{$fullname}%'
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" .$product. "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				order by g.description";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'MATERIAL GROUP')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty')->setCellValueByColumnAndRow(4, $line, 'Cycletime');
      $line++;
      $sql1        = "select distinct productname,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput, sum(qtyoutput*cycletime)/60 as cycletime from  
					(select distinct b.productname,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid,cycletime
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
					left join employee h on h.employeeid = d.employeeid
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					and h.fullname like '%{$fullname}%' ".getFieldTable($productcollectid,'b','productcollectid')."
          ".getCompanyGroup($companyid,'d')." and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode,materialgroupid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $totalct    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qtyoutput'])->setCellValueByColumnAndRow(4, $line, $row1['cycletime']);
        $line++;
        $totalqty += $row1['qtyoutput'];
        $totalct += $row1['cycletime'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty)->setCellValueByColumnAndRow(4, $line, $totalct);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  /*public function RekapProduksiPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rekapproduksiperbarang';
    parent::actionDownxls();
    $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
				where a.productoutputno is not null and e.companyid = " . $companyid . " and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				order by g.description";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'MATERIAL GROUP')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct productname,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput from 
								(select distinct b.productname,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid
								from productoutputfg a
								inner join product b on b.productid = a.productid
								inner join productoutput d on d.productoutputid = a.productoutputid
								inner join unitofmeasure e on e.unitofmeasureid = a.uomid
								inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
								join sloc f on f.slocid = a.slocid
								join productplan g on g.productplanid = d.productplanid 
								where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
								and g.companyid = " . $companyid . " and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
								and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . ") z 
								group by productname,uomcode,materialgroupid";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qtyoutput']);
        $line++;
        $totalqty += $row1['qtyoutput'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }*/
  //3
  public function RincianPemakaianPerDokumenXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rincianpemakaianperdokumen';
    parent::actionDownxls();
    $sql        = "select distinct a.productoutputid,a.productoutputno as dokumen,a.productoutputdate as tanggal,e.sloccode
				from productoutput a
				join productplan b on b.productplanid = a.productplanid
				join productoutputdetail c on c.productoutputid = a.productoutputid
				join product d on d.productid = c.productid
				join sloc e on e.slocid = c.toslocid
        left join employee f on f.employeeid = a.employeeid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'d','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and e.sloccode like '%" . $sloc . "%' 
				and d.productname like '%" . $product . "%' and f.fullname like '%{$fullname}%'
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productoutputdate";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(7, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['dokumen']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['tanggal']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang')->setCellValueByColumnAndRow(1, $line, ': ' . $row['sloccode']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Rak')->setCellValueByColumnAndRow(5, $line, 'Asal')->setCellValueByColumnAndRow(6, $line, 'Tujuan')->setCellValueByColumnAndRow(7, $line, 'Keterangan');
      $line++;
      $sql1        = "select distinct b.productname,a.qty,c.uomcode,e.description as rak,a.description,
					getslocdesc(a.fromslocid) as sumber,
					getslocdesc(a.toslocid) as tujuan
						from productoutputdetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplant d on d.productid = a.productid
						join storagebin e on e.storagebinid = a.storagebinid
						join sloc f on f.slocid = d.slocid
						join productoutput g on g.productoutputid = a.productoutputid
						join productplan h on h.productplanid = g.productplanid
						where a.productoutputid = " . $row['productoutputid']."
            ".getFieldTable($productcollectid,'b','productcollectid')."";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, $row1['rak'])->setCellValueByColumnAndRow(5, $line, $row1['sumber'])->setCellValueByColumnAndRow(6, $line, $row1['tujuan'])->setCellValueByColumnAndRow(7, $line, $row1['description']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //4
  public function RekapPemakaianPerGudangPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rekappemakaianpergudangperbarang';
    parent::actionDownxls();
    $sql        = "select distinct a.toslocid,a.fromslocid,
					e.sloccode fromsloccode,
			e.description as fromslocdesc,
			f.sloccode as tosloccode,	
			f.description as toslocdesc
					from productoutputdetail a
					join product b on b.productid = a.productid
					join productoutput c on c.productoutputid = a.productoutputid
					join sloc e on e.slocid = a.fromslocid
					join sloc f on f.slocid = a.toslocid
          left join employee g on g.employeeid = c.employeeid
					where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
          ".getCompanyGroup($companyid,'c')." and g.fullname like '%{$fullname}%'
          and (e.sloccode like '%" . $sloc . "%' or f.sloccode like '%" . $sloc . "%') 
					and b.productname like '%" . $product . "%' and c.productoutputdate between 
					'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
					'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) 
    {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Asal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tujuan')->setCellValueByColumnAndRow(1, $line, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      $line++;
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
            left join employee e on e.employeeid = c.employeeid
						where c.recordstatus = 3 and a.fromslocid = " . $row['fromslocid'] . " and a.toslocid = " . $row['toslocid'] . " 
            ".getFieldTable($productcollectid,'b','productcollectid')." and e.fullname like '%{$fullname}%'
            and b.productname like '%" . $product . "%' and c.productoutputdate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
						'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						group by productid,productname";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //5
  public function PerbandinganPlanningOutputXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'perbandinganplanningoutput';
    parent::actionDownxls();
    $sql        = "select distinct a.productplanno,a.productplandate,a.productplanid,d.sloccode,d.description as slocdesc
				from productplan a
				join productplanfg b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
        left join employee e on e.employeeid = a.employeeid
				where a.recordstatus = 3 and a.productplanno is not null 
        ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and e.fullname like '%{$fullname}%'
         and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' and
				a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productplanno'])->setCellValueByColumnAndRow(3, $line, 'Sloc')->setCellValueByColumnAndRow(4, $line, ': ' . $row['sloccode'] . ' - ' . $row['slocdesc']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productplandate']);
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'FG');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty Plan')->setCellValueByColumnAndRow(3, $line, 'Qty Out')->setCellValueByColumnAndRow(4, $line, 'Satuan');
      $line++;
      $sql1         = "select b.productname,a.qty as qtyplan, (
					select ifnull(sum(ifnull(c.qtyoutput,0)),0)
					from productoutputfg c
					join productoutput g on g.productoutputid = c.productoutputid 
					where c.productplanfgid = a.productplanfgid and g.productplanid=a.productplanid and g.recordstatus = 3
					) as qtyout,d.uomcode,f.sloccode,f.description as slocdesc
					from productplanfg a 
					inner join product b on b.productid = a.productid 
					inner join unitofmeasure d on d.unitofmeasureid = a.uomid
					inner join sloc f on f.slocid = a.slocid
          join productplan h on h.productplanid = a.productplanid
          left join employee i on i.employeeid = h.employeeid
					where a.productplanid = " . $row['productplanid']."
          ".getFieldTable($productcollectid,'b','productcollectid')."
          and i.fullname like '%{$fullname}%'";
      $command1     = yii::app()->db->createCommand($sql1);
      $dataReader1  = $command1->queryAll();
      $totalqtyplan = 0;
      $i            = 0;
      $totalqtyout  = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qtyplan'])->setCellValueByColumnAndRow(3, $line, $row1['qtyout'])->setCellValueByColumnAndRow(4, $line, $row1['uomcode']);
        $line++;
        $totalqtyplan += $row1['qtyplan'];
        $totalqtyout += $row1['qtyout'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqtyplan)->setCellValueByColumnAndRow(3, $line, $totalqtyout);
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Detail');
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty Plan')->setCellValueByColumnAndRow(3, $line, 'Qty Out')->setCellValueByColumnAndRow(4, $line, 'Satuan');
      $line++;
      $sql2          = "select distinct b.productname, a.qty as qtyplan,ifnull(f.qty,0) as qtyout, c.uomcode, a.description
				from productplandetail a
				left join productoutputdetail f on f.productplandetailid = a.productplandetailid
				left join product b on b.productid = a.productid
				left join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.bomid
				left join sloc e on e.slocid = a.fromslocid 
				left join productoutput g on g.productoutputid=f.productoutputid
        left join employee h on h.employeeid = g.employeeid
				where g.recordstatus = 3 and b.isstock = 1 
        ".getFieldTable($productcollectid,'b','productcollectid')."        
        and g.productplanid = " . $row['productplanid'];
      $command2      = yii::app()->db->createCommand($sql2);
      $dataReader2   = $command2->queryAll();
      $totalqtyplan1 = 0;
      $ii            = 0;
      $totalqtyout1  = 0;
      foreach ($dataReader2 as $row2) {
        $ii += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $ii)->setCellValueByColumnAndRow(1, $line, $row2['productname'])->setCellValueByColumnAndRow(2, $line, $row2['qtyplan'])->setCellValueByColumnAndRow(3, $line, $row2['qtyout'])->setCellValueByColumnAndRow(4, $line, $row2['uomcode']);
        $line++;
        $totalqtyplan1 += $row2['qtyplan'];
        $totalqtyout1 += $row2['qtyout'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqtyplan1)->setCellValueByColumnAndRow(3, $line, $totalqtyout1);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //6
  public function RwBelumAdaGudangAsalXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rawbelumadagudangasal';
      parent::actionDownxls();
      
      $sql = "select distinct a.productplanno,a.productplandate,a.productplanid
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.fromslocid
				where a.recordstatus > 0 and d.sloccode like '%" . $sloc . "%' 
				and a.companyid = " . $companyid . " and c.productname like '%" . $product . "%'
				and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and b.fromslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid and xx.recordstatus=1)";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      $line = 4;
      foreach($dataReader as $row)
      {
         $totalqty=0;
         $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Dokumen')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row['productplanno']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Tanggal')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row['productplandate']);
          $line++;
          
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(2, $line, 'Qty')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Gudang Asal')
                ->setCellValueByColumnAndRow(5, $line, 'Keterangan');
          $line++;
          
          $sql1 = "select distinct b.productname,a.qty,c.uomcode,d.description,d.productplandate,
						(select sloccode from sloc xx where xx.slocid = a.fromslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.fromslocid
						where b.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%' 
						and d.companyid = " . $companyid . " and d.recordstatus > 0
						and d.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.productplanid = " . $row['productplanid'] . "
						and a.fromslocid not in (select x.slocid from productplant x where x.productid = a.productid and x.recordstatus=1)";
          $command1    = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          $i=0;
          foreach($dataReader1 as $row1)
          {
              $i+=1;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, $i)
                ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                ->setCellValueByColumnAndRow(2, $line, $row1['qty'])
                ->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])
                ->setCellValueByColumnAndRow(4, $line, $row1['sloc'])
                ->setCellValueByColumnAndRow(5, $line, $row1['description']);
              $line++;
              $totalqty+=$row1['qty'];
          }
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'Total')
                ->setCellValueByColumnAndRow(2, $line, $totalqty);
          $line+=2;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //7
  public function RwBelumAdaGudangTujuanXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rawbelumadagudangtujuan';
      parent::actionDownxls();
      
      $sql = "select distinct a.productplanno,a.productplandate,a.productplanid,a.recordstatus
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.toslocid
				where d.sloccode like '%" . $sloc . "%' and a.recordstatus > 0 
				and a.companyid = " . $companyid . " and c.productname like '%" . $product . "%'
				and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				and b.toslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid)";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      $line = 4;
      foreach($dataReader as $row)
      {
         $totalqty=0;
         $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Dokumen')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row['productplanno']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Tanggal')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row['productplandate']);
          $line++;
          
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(2, $line, 'Qty')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Gudang Asal')
                ->setCellValueByColumnAndRow(5, $line, 'Keterangan');
          $line++;
          
          $sql1 = "select distinct b.productname,a.qty,c.uomcode,d.description,
						(select sloccode from sloc xx where xx.slocid = a.toslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.toslocid
						where b.productname like '%" . $product . "%' and e.sloccode like '%" . $sloc . "%'
						and d.companyid = " . $companyid . " and d.recordstatus > 0 and a.productplanid = " . $row['productplanid'] . "
						and d.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						and a.toslocid not in (select x.slocid from productplant x where x.productid = a.productid)";
          $command1    = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          $i=0;
          foreach($dataReader1 as $row1)
          {
              $i+=1;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, $i)
                ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                ->setCellValueByColumnAndRow(2, $line, $row1['qty'])
                ->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])
                ->setCellValueByColumnAndRow(4, $line, $row1['sloc'])
                ->setCellValueByColumnAndRow(5, $line, $row1['description']);
              $line++;
              $totalqty+=$row1['qty'];
          }
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'Total')
                ->setCellValueByColumnAndRow(2, $line, $totalqty);
          $line+=2;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //8
  public function PendinganProduksiXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'pendinganproduksi';
    parent::actionDownxls();
    $alltotalqty = 0;
    $alltotalqtyoutput = 0; 
    $sql = "select distinct a.productplanno,a.productplandate,a.productplanid
			   from productplan a
			   join productplanfg b on b.productplanid = a.productplanid
			   join product c on c.productid = b.productid
			   join sloc d on d.slocid = b.slocid
         left join employee e on e.employeeid = a.employeeid
			   where a.recordstatus = 3 and a.productplanno is not null and d.sloccode like '%" . $sloc . "%' 
			   ".getFieldTable($productcollectid,'c','productcollectid')."
         ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
			   and b.startdate <= curdate() and e.fullname like '%{$fullname}%'
				 and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
			   and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productplanno";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Dokumen')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productplanno']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['productplandate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'QtyOutput')->setCellValueByColumnAndRow(4, $line, 'Satuan')->setCellValueByColumnAndRow(5, $line, 'Gudang')->setCellValueByColumnAndRow(6, $line, 'Selisih');
      $line++;
      $sql1           = "select b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,c.uomcode,d.description as sloc
						from productplanfg a						
						join product b on b.productid = a.productid						
						join unitofmeasure c on c.unitofmeasureid = a.uomid						
						join sloc d on d.slocid = a.slocid
						join productplan e on e.productplanid = a.productplanid						
            left join employee f on f.employeeid = e.employeeid
						where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres
						".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
						and a.startdate <= curdate() and f.fullname like '%{$fullname}%'
						and e.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and a.productplanid = " . $row['productplanid'];
      $command1       = yii::app()->db->createCommand($sql1);
      $dataReader1    = $command1->queryAll();
      $total          = 0;
      $i              = 0;
      $totalqty       = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['qty'])->setCellValueByColumnAndRow(3, $line, $row1['qtyoutput'])->setCellValueByColumnAndRow(4, $line, $row1['uomcode'])->setCellValueByColumnAndRow(5, $line, $row1['sloc'])->setCellValueByColumnAndRow(6, $line, $row1['selisih']);
        $line++;
        $totalqty += $row1['qty'];
        $totalqtyoutput += $row1['qtyoutput'];
        $totalselisih += $row1['selisih'];
        $alltotalqty += $row1['qty'];
        $alltotalqtyoutput += $row1['qtyoutput'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty)->setCellValueByColumnAndRow(3, $line, $totalqtyoutput)->setCellValueByColumnAndRow(6, $line, $totalselisih);
      $line += 2;
    }
    $this->phpExcel->setActiveSheetIndex(0)
         ->setCellValueByColumnAndRow(1, $line, 'Total Keseluruhan')
         ->setCellValueByColumnAndRow(2, $line, $alltotalqty)
         ->setCellValueByColumnAndRow(3, $line, $alltotalqtyoutput)
         ->setCellValueByColumnAndRow(6, $line, $alltotalqty - $alltotalqtyoutput);
    $this->getFooterXLS($this->phpExcel);
  }
  //9
  public function RincianPendinganProduksiPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rincianpendinganproduksiperbarang';
      parent::actionDownxls();
      
      $subtotalqty       = 0;
      $subtotalqtyoutput = 0;
      $subtotalselisih   = 0;
      $sql = "select distinct d.description,d.slocid
						 from productplan a
						 join productplanfg b on b.productplanid = a.productplanid
						 join product c on c.productid = b.productid
						 join sloc d on d.slocid = b.slocid
             left join employee e on e.employeeid = a.employeeid
						 where a.recordstatus = 3 and d.sloccode like '%" . $sloc . "%' 
						 ".getFieldTable($productcollectid,'c','productcollectid')." and e.fullname like '%{$fullname}%'
             ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
						 and b.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
      $command           = yii::app()->db->createCommand($sql);
      $dataReader        = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      $line=4;
      foreach ($dataReader as $row)
      {
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'GUDANG ')
                ->setCellValueByColumnAndRow(1, $line, ': '.$row['description']);
          
            $line+=2;
            $sql1           = "select distinct b.productname,b.productid
                        from productplanfg a	
                        join product b on b.productid = a.productid	
                        join unitofmeasure c on c.unitofmeasureid = a.uomid	
                        join sloc d on d.slocid = a.slocid
                        join productplan e on e.productplanid = a.productplanid	
                        left join employee f on f.employeeid = e.employeeid
                        where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres ".getFieldTable($productcollectid,'b','productcollectid')."
                        ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
                        and e.productplanno is not null and f.fullname like '%{$fullname}%'
                        and a.startdate <= now() and a.startdate >= date_sub(now(),interval 1 MONTH)
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                        and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                        and a.slocid = " . $row['slocid'] . " ";
          $command1       = yii::app()->db->createCommand($sql1);
          $dataReader1    = $command1->queryAll();
          $totalqty       = 0;
          $totalqtyoutput = 0;
          $totalselisih   = 0;
          
          foreach($dataReader1 as $row1)
          {
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Nama Barang ')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row1['productname']);
              $line++;
              
              $sql2 = "select e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
                                            c.uomcode,d.description as sloc,e.productplanno,e.productplandate,a.startdate
                                            from productplanfg a	
                                            join product b on b.productid = a.productid	
                                            join unitofmeasure c on c.unitofmeasureid = a.uomid	
                                            join sloc d on d.slocid = a.slocid
                                            join productplan e on e.productplanid = a.productplanid	
                                            where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres
                                            and e.companyid = " . $companyid . " and e.recordstatus = 3
                                            and e.productplanno is not null
                                            and a.startdate <= now() and a.startdate >= date_sub(now(),interval 1 MONTH)
                                            and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
                                            and b.productid = " . $row1['productid'] . " and d.slocid = " . $row['slocid'] . "";
              $command2    = yii::app()->db->createCommand($sql2);
              $dataReader2 = $command2->queryAll();
              
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'NO')
                ->setCellValueByColumnAndRow(1, $line, 'NO SPP')
                ->setCellValueByColumnAndRow(2, $line, 'Tgl Mulai')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Qty SPP')
                ->setCellValueByColumnAndRow(5, $line, 'Qty OP')
                ->setCellValueByColumnAndRow(6, $line, 'Selisih');
              $line++;
              $i=0;
              $jumlahqty = 0;
              $jumlahqtyoutput = 0;
              $jumlahselisih = 0;
              foreach($dataReader2 as $row2)
              {  
                  $i+=1;
                  
                  $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, $i)
                    ->setCellValueByColumnAndRow(1, $line,  $row2['productplanno'])
                    ->setCellValueByColumnAndRow(2, $line,  $row2['startdate'])
                    ->setCellValueByColumnAndRow(3, $line,  $row2['uomcode'])
                    ->setCellValueByColumnAndRow(4, $line,  $row2['qty'])
                    ->setCellValueByColumnAndRow(5, $line,  $row2['qtyoutput'])
                    ->setCellValueByColumnAndRow(6, $line,  $row2['selisih']);
                  
                  $jumlahqty += $row2['qty'];
                  $jumlahqtyoutput += $row2['qtyoutput'];
                  $jumlahselisih += $row2['selisih'];
                  $line++;
              }
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'Jumlah')
                ->setCellValueByColumnAndRow(4, $line, $jumlahqty)
                ->setCellValueByColumnAndRow(5, $line, $jumlahqtyoutput)
                ->setCellValueByColumnAndRow(6, $line, $jumlahselisih);
              $line+=2;
              $totalqty += $jumlahqty;
              $totalqtyoutput += $jumlahqtyoutput;
              $totalselisih += $jumlahselisih;
          }
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, 'Total '.$row['description'])
            ->setCellValueByColumnAndRow(4, $line, $totalqty)
            ->setCellValueByColumnAndRow(5, $line, $totalqtyoutput)
            ->setCellValueByColumnAndRow(6, $line, $totalselisih);
              $line+=2;
          
          $subtotalqty += $totalqty;
          $subtotalqtyoutput += $totalqtyoutput;
          $subtotalselisih += $totalselisih;
      }
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $line, 'Grand Total')
        ->setCellValueByColumnAndRow(4, $line, $subtotalqty)
        ->setCellValueByColumnAndRow(5, $line, $subtotalqtyoutput)
        ->setCellValueByColumnAndRow(6, $line, $subtotalselisih);
      
      $this->getFooterXLS($this->phpExcel);
  }
  //10
  public function RekapPendinganProduksiPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rekappendinganproduksiperbarang';
    parent::actionDownxls();
    $subqty        = 0;
    $subqtyoutput  = 0;
    $subqtyselisih = 0;
    $sql               = "select distinct d.description,d.slocid
						 from productplan a
						 join productplanfg b on b.productplanid = a.productplanid
						 join product c on c.productid = b.productid
						 join sloc d on d.slocid = b.slocid
             left join employee e on e.employeeid = a.employeeid
						 where a.recordstatus = 3 and d.sloccode like '%" . $sloc . "%' 
						 ".getFieldTable($productcollectid,'c','productcollectid')." and e.fullname like '%{$fullname}%'
             ".getCompanyGroup($companyid,'a')." and c.productname like '%" . $product . "%' and b.qty > b.qtyres
						 and a.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by productplanno";
    $command       = yii::app()->db->createCommand($sql);
    $dataReader    = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Gudang')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty')->setCellValueByColumnAndRow(4, $line, 'Qty SPP')->setCellValueByColumnAndRow(5, $line, 'Selisi');
      $line++;
      $sql1           = "select *,sum(qty) as sumqty,sum(qtyoutput) as sumqtyoutput,sum(selisih) as sumselisih
                                    from
                                     (select e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
                                    c.uomcode,d.description as sloc,e.productplanno,e.productplandate	
                                    from productplanfg a	
                                    join product b on b.productid = a.productid	
                                    join unitofmeasure c on c.unitofmeasureid = a.uomid	
                                    join sloc d on d.slocid = a.slocid
                                    join productplan e on e.productplanid = a.productplanid
                                    left join employee f on f.employeeid = e.employeeid
                                    where b.productname like '%" . $product . "%' and d.sloccode like '%" . $sloc . "%' and a.qty > a.qtyres and f.fullname like '%{$fullname}%'
                                    ".getFieldTable($productcollectid,'b','productcollectid')."
                                    ".getCompanyGroup($companyid,'e')." and e.recordstatus = 3
                                    and e.productplanno is not null
                                    and e.productplandate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                                    and a.slocid = " . $row['slocid'] . " order by productname) z group by productname";
      $command1        = yii::app()->db->createCommand($sql1);
      $dataReader1     = $command1->queryAll();
      $totalqty        = 0;
      $i               = 0;
      $totalqtyout     = 0;
      $totalqtyselisih = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['sumqty'])->setCellValueByColumnAndRow(4, $line, $row1['sumqtyoutput'])->setCellValueByColumnAndRow(5, $line, $row1['sumselisih']);
        $line++;
        $totalqty += $row1['sumqty'];
        $totalqtyout += $row1['sumqtyoutput'];
        $totalqtyselisih += $row1['sumselisih'];
      }
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total ' . $row['description'])->setCellValueByColumnAndRow(3, $line, $totalqty)->setCellValueByColumnAndRow(4, $line, $totalqtyout)->setCellValueByColumnAndRow(5, $line, $totalqtyselisih);
      $line += 2;
      $subqty += $totalqty;
      $subqtyoutput += $totalqtyout;
      $subqtyselisih += $totalqtyselisih;
    }
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Grand Total: ')->setCellValueByColumnAndRow(3, $line, $subqty)->setCellValueByColumnAndRow(4, $line, $subqtyoutput)->setCellValueByColumnAndRow(5, $line, $subqtyselisih);
    $line += 2;
    $this->getFooterXLS($this->phpExcel);
  }
  //11
  public function RekapProduksiPerBarangPerHariXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rekapproduksiperbarangperhari';
      parent::actionDownxls();
      
      $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
        left join employee h on h.employeeid = a.employeeid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and a.recordstatus = 3 and h.fullname like '%{$fullname}%'
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(1, 2, date('F Y',strtotime($enddate)));
          
      $line = 4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'MATERIAL GROUP ')
               ->setCellValueByColumnAndRow(1, $line, $row['description']);
          $line++;
          
          $sql1        = "select distinct productname,productid,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput,d1, 																						d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31 from 
								(select distinct b.productname,b.productid,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid,(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 1 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d1,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 2 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d2,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 3 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d3,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and day(l.productoutputdate) = 4 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d4,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 5 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d5,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 6 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d6,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 7 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d7,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 8 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d8,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 9 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d9,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 10 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d10,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 11 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d11,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 12 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d12,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 13 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d13,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 14 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d14,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 15 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d15,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 16 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d16,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 17
								and l.recordstatus = 3 and k.productid = a.productid
								) as d17,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 18 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d18,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 19 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d19,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 20 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d20,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 21 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d21,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 22 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d22,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 23 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d23,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 24 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d24,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 25 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d25,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 26 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d26,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 27 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d27,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 28 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d28,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 29 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d29,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 30 
								and l.recordstatus = 3 and k.productid = a.productid
								) as d30,

								(select ifnull(sum(k.qtyoutput),0)
								from productoutputfg k
								join productoutput l on l.productoutputid = k.productoutputid
								where year(l.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') 
								and month(l.productoutputdate) = month('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
								and day(l.productoutputdate) = 31 
								and l.recordstatus = 3 and k.productid = a.productid
								)as d31

								from productoutputfg a
								inner join product b on b.productid = a.productid
								inner join productoutput d on d.productoutputid = a.productoutputid
								inner join unitofmeasure e on e.unitofmeasureid = a.uomid
								inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
								join sloc f on f.slocid = a.slocid
								join productplan g on g.productplanid = d.productplanid
                left join employee h on h.employeeid = d.employeeid
								where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
								".getFieldTable($productcollectid,'b','productcollectid')."
                ".getCompanyGroup($companyid,'d')." and h.fullname like '%{$fullname}%' and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
								and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . " ) z 
								group by productname,uomcode,materialgroupid";
          $command1    = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          $totalqty    = 0;
          $i           = 0;
          
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'No')
               ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
               ->setCellValueByColumnAndRow(2, $line, 'Satuan')
               ->setCellValueByColumnAndRow(3, $line, 'Qty')
               ->setCellValueByColumnAndRow(4, $line, '1')
               ->setCellValueByColumnAndRow(5, $line, '2')
               ->setCellValueByColumnAndRow(6, $line, '3')
               ->setCellValueByColumnAndRow(7, $line, '4')
               ->setCellValueByColumnAndRow(8, $line, '5')
               ->setCellValueByColumnAndRow(9, $line, '6')
               ->setCellValueByColumnAndRow(10, $line, '7')
               ->setCellValueByColumnAndRow(11, $line, '8')
               ->setCellValueByColumnAndRow(12, $line, '9')
               ->setCellValueByColumnAndRow(13, $line, '10')
               ->setCellValueByColumnAndRow(14, $line, '11')
               ->setCellValueByColumnAndRow(15, $line, '12')
               ->setCellValueByColumnAndRow(16, $line, '13')
               ->setCellValueByColumnAndRow(17, $line, '14')
               ->setCellValueByColumnAndRow(18, $line, '15')
               ->setCellValueByColumnAndRow(19, $line, '16')
               ->setCellValueByColumnAndRow(20, $line, '17')
               ->setCellValueByColumnAndRow(21, $line, '18')
               ->setCellValueByColumnAndRow(22, $line, '19')
               ->setCellValueByColumnAndRow(23, $line, '20')
               ->setCellValueByColumnAndRow(24, $line, '21')
               ->setCellValueByColumnAndRow(25, $line, '22')
               ->setCellValueByColumnAndRow(26, $line, '23')
               ->setCellValueByColumnAndRow(27, $line, '24')
               ->setCellValueByColumnAndRow(28, $line, '25')
               ->setCellValueByColumnAndRow(29, $line, '26')
               ->setCellValueByColumnAndRow(30, $line, '27')
               ->setCellValueByColumnAndRow(31, $line, '28')
               ->setCellValueByColumnAndRow(32, $line, '29')
               ->setCellValueByColumnAndRow(33, $line, '30')
               ->setCellValueByColumnAndRow(34, $line, '31');
          
          $line++;
          foreach($dataReader1 as $row1)
          {
              $i+=1;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, $i)
                ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
                ->setCellValueByColumnAndRow(3, $line, $row1['qtyoutput'])
                ->setCellValueByColumnAndRow(4, $line, $row1['d1'])
                ->setCellValueByColumnAndRow(5, $line, $row1['d2'])
                ->setCellValueByColumnAndRow(6, $line, $row1['d3'])
                ->setCellValueByColumnAndRow(7, $line, $row1['d4'])
                ->setCellValueByColumnAndRow(8, $line, $row1['d5'])
                ->setCellValueByColumnAndRow(9, $line, $row1['d6'])
                ->setCellValueByColumnAndRow(10, $line, $row1['d7'])
                ->setCellValueByColumnAndRow(11, $line, $row1['d8'])
                ->setCellValueByColumnAndRow(12, $line, $row1['d9'])
                ->setCellValueByColumnAndRow(13, $line, $row1['d10'])
                ->setCellValueByColumnAndRow(14, $line, $row1['d11'])
                ->setCellValueByColumnAndRow(15, $line, $row1['d12'])
                ->setCellValueByColumnAndRow(16, $line, $row1['d13'])
                ->setCellValueByColumnAndRow(17, $line, $row1['d14'])
                ->setCellValueByColumnAndRow(18, $line, $row1['d15'])
                ->setCellValueByColumnAndRow(19, $line, $row1['d16'])
                ->setCellValueByColumnAndRow(20, $line, $row1['d17'])
                ->setCellValueByColumnAndRow(21, $line, $row1['d18'])
                ->setCellValueByColumnAndRow(22, $line, $row1['d19'])
                ->setCellValueByColumnAndRow(23, $line, $row1['d20'])
                ->setCellValueByColumnAndRow(24, $line, $row1['d21'])
                ->setCellValueByColumnAndRow(25, $line, $row1['d22'])
                ->setCellValueByColumnAndRow(26, $line, $row1['d23'])
                ->setCellValueByColumnAndRow(27, $line, $row1['d24'])
                ->setCellValueByColumnAndRow(28, $line, $row1['d25'])
                ->setCellValueByColumnAndRow(29, $line, $row1['d26'])
                ->setCellValueByColumnAndRow(30, $line, $row1['d27'])
                ->setCellValueByColumnAndRow(31, $line, $row1['d28'])
                ->setCellValueByColumnAndRow(32, $line, $row1['d29'])
                ->setCellValueByColumnAndRow(33, $line, $row1['d30'])
                ->setCellValueByColumnAndRow(34, $line, $row1['d31']);
              $totalqty += $row1['qtyoutput'];
              $line++;
          }
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, 'Total '. $row['description'])
            ->setCellValueByColumnAndRow(3, $line, $totalqty);
          $line+=2;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //12
  public function RekapHasilProduksiPerDokumentBelumStatusMaxXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rekaphasilproduksiperdokumentbelumstatusmax';
      parent::actionDownxls();
      
      $sql = "select distinct b.productoutputid,b.productoutputid,b.recordstatus,
					b.productoutputno,b.productoutputdate,c.productplanno,b.description,b.statusname
					from productoutput b
					join productplan c on c.productplanid = b.productplanid
					join productoutputfg d on d.productoutputid = b.productoutputid
					join product e on e.productid = d.productid
					join sloc f on f.slocid = d.slocid
					where e.productname like '%" . $product . "%' and f.sloccode like '%" . $sloc . "%' 
					and c.companyid = " . $companyid . "
					and b.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
					and b.recordstatus between 1 and (3-1) and b.productplanid is not null 
					order by b.recordstatus";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $line, 'No')
        ->setCellValueByColumnAndRow(1, $line, 'ID Transaksi')
        ->setCellValueByColumnAndRow(2, $line, 'No Dokumen')
        ->setCellValueByColumnAndRow(3, $line, 'Tanggal')
        ->setCellValueByColumnAndRow(4, $line, 'No Referensi')
        ->setCellValueByColumnAndRow(5, $line, 'Keterangan')
        ->setCellValueByColumnAndRow(6, $line, 'Status');
      $i=0;
      $line++;
      foreach($dataReader as $row)
      {
          $i+=1;
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i)
            ->setCellValueByColumnAndRow(1, $line, $row['productoutputid'])
            ->setCellValueByColumnAndRow(2, $line, $row['productoutputno'])
            ->setCellValueByColumnAndRow(3, $line, date(Yii::app()->params['dateviewfromdb'],strtotime($row['productoutputdate'])))
            ->setCellValueByColumnAndRow(4, $line, $row['productplanno'])
            ->setCellValueByColumnAndRow(5, $line, $row['description'])
            ->setCellValueByColumnAndRow(6, $line, $row['statusname']);
          $line++;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //13
  public function RekapProduksiPerBarangPerBulanXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'rekapproduksiperbarangperbulan';
      parent::actionDownxls();
      
      $sql        = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
				where a.productoutputno is not null ".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')." and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and year(a.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
				order by g.description
			";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $grandtotaljanuari = 0;
      $grandtotalfebruari = 0;
      $grandtotalmaret = 0;
      $grandtotalapril = 0;
      $grandtotalmei = 0;
      $grandtotaljuni = 0;
      $grandtotaljuli = 0;
      $grandtotalagustus = 0;
      $grandtotalseptember = 0;
      $grandtotaloktober = 0;
      $grandtotalnopember = 0;
      $grandtotaldesember = 0;
      $grandtotal = 0;
      
      $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(1, 2, date('Y',strtotime($enddate)));
      
      $line=4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'MATERIAL GROUP')
               ->setCellValueByColumnAndRow(1, $line, $row['description']);
          $line++;
          
          $sql1        = "select *
					from (select distinct b.productname,e.uomcode,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 1 and m.materialgroupid = c.materialgroupid),0) as januari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 2 and m.materialgroupid = c.materialgroupid),0) as februari,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 3 and m.materialgroupid = c.materialgroupid),0) as maret,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 4 and m.materialgroupid = c.materialgroupid),0) as april,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 5 and m.materialgroupid = c.materialgroupid),0) as mei,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 6 and m.materialgroupid = c.materialgroupid),0) as juni,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 7 and m.materialgroupid = c.materialgroupid),0) as juli,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 8 and m.materialgroupid = c.materialgroupid),0) as agustus,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 9 and m.materialgroupid = c.materialgroupid),0) as september,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 10 and m.materialgroupid = c.materialgroupid),0) as oktober,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 11 and m.materialgroupid = c.materialgroupid),0) as nopember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and month(n.productoutputdate) = 12 and m.materialgroupid = c.materialgroupid),0) as desember,
					ifnull((select sum(k.qtyoutput)
						from productoutputfg k
						join product l on l.productid = k.productid
						join productoutput n on n.productoutputid = k.productoutputid
						join unitofmeasure o on o.unitofmeasureid = k.uomid
						join productplant m on m.productid = k.productid and m.slocid = k.slocid and m.unitofissue = k.uomid
						join sloc p on p.slocid = k.slocid
						join productplan q on q.productplanid = n.productplanid 
						where n.recordstatus = 3 and k.productid = a.productid and k.slocid = a.slocid and q.companyid = g.companyid 
						and year(n.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
						and m.materialgroupid = c.materialgroupid),0) as jumlah
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
          left join employee h on h.employeeid = d.employeeid
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					".getFieldTable($productcollectid,'b','productcollectid')." and h.fullname like '%{$fullname}%'
          ".getCompanyGroup($companyid,'d')." and year(d.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      
      $totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
      $i = 0;
          
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, 'No')
               ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
               ->setCellValueByColumnAndRow(2, $line, 'Satuan')
               ->setCellValueByColumnAndRow(3, $line, '1')
               ->setCellValueByColumnAndRow(4, $line, '2')
               ->setCellValueByColumnAndRow(5, $line, '3')
               ->setCellValueByColumnAndRow(6, $line, '4')
               ->setCellValueByColumnAndRow(7, $line, '5')
               ->setCellValueByColumnAndRow(8, $line, '6')
               ->setCellValueByColumnAndRow(9, $line, '7')
               ->setCellValueByColumnAndRow(10, $line, '8')
               ->setCellValueByColumnAndRow(11, $line, '9')
               ->setCellValueByColumnAndRow(12, $line, '10')
               ->setCellValueByColumnAndRow(13, $line, '11')
               ->setCellValueByColumnAndRow(14, $line, '12')
               ->setCellValueByColumnAndRow(15, $line, 'Jumlah');
           
          foreach($dataReader1 as $row1)
          {
              $i+=1;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, $i)
                ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
                ->setCellValueByColumnAndRow(3, $line, $row1['januari'])
                ->setCellValueByColumnAndRow(4, $line, $row1['februari'])
                ->setCellValueByColumnAndRow(5, $line, $row1['maret'])
                ->setCellValueByColumnAndRow(6, $line, $row1['april'])
                ->setCellValueByColumnAndRow(7, $line, $row1['mei'])
                ->setCellValueByColumnAndRow(8, $line, $row1['juni'])
                ->setCellValueByColumnAndRow(9, $line, $row1['juli'])
                ->setCellValueByColumnAndRow(10, $line, $row1['agustus'])
                ->setCellValueByColumnAndRow(11, $line, $row1['september'])
                ->setCellValueByColumnAndRow(12, $line, $row1['oktober'])
                ->setCellValueByColumnAndRow(13, $line, $row1['nopember'])
                ->setCellValueByColumnAndRow(14, $line, $row1['desember'])
                ->setCellValueByColumnAndRow(15, $line, $row1['jumlah']);
              
              $totaljanuari += $row1['januari'];
              $totalfebruari += $row1['februari'];
              $totalmaret += $row1['maret'];
              $totalapril += $row1['april'];
              $totalmei += $row1['mei'];
              $totaljuni += $row1['juni'];
              $totaljuli += $row1['juli'];
              $totalagustus += $row1['agustus'];
              $totalseptember += $row1['september'];
              $totaloktober += $row1['oktober'];
              $totalnopember += $row1['nopember'];
              $totaldesember += $row1['desember'];
              $totaljumlah += $row1['jumlah'];
              
              $line++;
          }
          
          $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(1, $line, 'Total '.$row['description'])
               ->setCellValueByColumnAndRow(3, $line, $totaljanuari)
               ->setCellValueByColumnAndRow(4, $line, $totalfebruari)
               ->setCellValueByColumnAndRow(5, $line, $totalmaret)
               ->setCellValueByColumnAndRow(6, $line, $totalapril)
               ->setCellValueByColumnAndRow(7, $line, $totalmei)
               ->setCellValueByColumnAndRow(8, $line, $totaljuni)
               ->setCellValueByColumnAndRow(9, $line, $totaljuli)
               ->setCellValueByColumnAndRow(10, $line, $totalagustus)
               ->setCellValueByColumnAndRow(11, $line, $totalseptember)
               ->setCellValueByColumnAndRow(12, $line, $totaloktober)
               ->setCellValueByColumnAndRow(13, $line, $totalnopember)
               ->setCellValueByColumnAndRow(14, $line, $totaldesember)
               ->setCellValueByColumnAndRow(15, $line, $totaljumlah);
              
          $line+=2;
          $grandtotaljanuari += $totaljanuari;
          $grandtotalfebruari += $totalfebruari;
          $grandtotalmaret += $totalmaret;
          $grandtotalapril += $totalapril;
          $grandtotalmei += $totalmei;
          $grandtotaljuni += $totaljuni;
          $grandtotaljuli += $totaljuli;
          $grandtotalagustus += $totalagustus;
          $grandtotalseptember += $totalseptember;
          $grandtotaloktober += $totaloktober;
          $grandtotalnopember += $totalnopember;
          $grandtotaldesember += $totaldesember;
          $grandtotal += $totaljumlah;
      }
      
      $this->phpExcel->setActiveSheetIndex(0)
           ->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')
           ->setCellValueByColumnAndRow(3, $line, $grandtotaljanuari)
           ->setCellValueByColumnAndRow(4, $line, $grandtotalfebruari)
           ->setCellValueByColumnAndRow(5, $line, $grandtotalmaret)
           ->setCellValueByColumnAndRow(6, $line, $grandtotalapril)
           ->setCellValueByColumnAndRow(7, $line, $grandtotalmei)
           ->setCellValueByColumnAndRow(8, $line, $grandtotaljuni)
           ->setCellValueByColumnAndRow(9, $line, $grandtotaljuli)
           ->setCellValueByColumnAndRow(10, $line, $grandtotalagustus)
           ->setCellValueByColumnAndRow(11, $line, $grandtotalseptember)
           ->setCellValueByColumnAndRow(12, $line, $grandtotaloktober)
           ->setCellValueByColumnAndRow(13, $line, $grandtotalnopember)
           ->setCellValueByColumnAndRow(14, $line, $grandtotaldesember)
           ->setCellValueByColumnAndRow(15, $line, $grandtotal);
      $this->getFooterXLS($this->phpExcel);
  }
  //14
  public function JadwalProduksiXLS($companyid,$sloc,$fullname,$product,$startdate,$enddate)
  {
      $this->menuname='jadwalproduksi';
      parent::actionDownxls();
      
      $sql        = "select distinct startdate
                  from productplanfg a
                  join productplan b on b.productplanid=a.productplanid
                  join sloc c on c.slocid=a.slocid
                  join product d on d.productid=a.productid
                  where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                  and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' 
                  and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0, $line, 'Tanggal')
              ->setCellValueByColumnAndRow(1, $line, ' : '.$row['startdate']);
          $line++;
          $sql1 = "select distinct f.materialgroupid,f.description
                      from productplanfg a
                      join productplan b on b.productplanid=a.productplanid
                      join sloc c on c.slocid=a.slocid
                      join product d on d.productid=a.productid
                      join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                      join materialgroup f on f.materialgroupid=e.materialgroupid
                      where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                      and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."'
                      and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                      order by description";
          $command1    = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          foreach($dataReader1 as $row1)
          {
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Material Group')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row1['description']);
              $line++;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'SPP')
                ->setCellValueByColumnAndRow(2, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Qty')
                ->setCellValueByColumnAndRow(5, $line, 'Tgl Mulai')
                ->setCellValueByColumnAndRow(6, $line, 'Tgl Selesai')
                ->setCellValueByColumnAndRow(7, $line, 'Cycletime');
              $line++;
              
              $sql2 = "select b.productplanno,d.productname,g.uomcode,a.qty,a.startdate,a.enddate,(select (a.qty*a.cycletime)/60) as cycletime
                        from productplanfg a
                        join productplan b on b.productplanid=a.productplanid
                        join sloc c on c.slocid=a.slocid
                        join product d on d.productid=a.productid
                        join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                        join materialgroup f on f.materialgroupid=e.materialgroupid
                        join unitofmeasure g on g.unitofmeasureid=a.uomid
                        where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                        and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."' and f.materialgroupid = ".$row1['materialgroupid']."
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
              $command2    = yii::app()->db->createCommand($sql2);
              $dataReader2 = $command2->queryAll();
              $i=0;$totalqty=0;$totalct=0;
              foreach($dataReader2 as $row2)
              {
                  $i+=1;
                  $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, $i)
                    ->setCellValueByColumnAndRow(1, $line, $row2['productplanno'])
                    ->setCellValueByColumnAndRow(2, $line, $row2['productname'])
                    ->setCellValueByColumnAndRow(3, $line, $row2['uomcode'])
                    ->setCellValueByColumnAndRow(4, $line, $row2['qty'])
                    ->setCellValueByColumnAndRow(5, $line, $row2['startdate'])
                    ->setCellValueByColumnAndRow(6, $line, $row2['enddate'])
                    ->setCellValueByColumnAndRow(7, $line, $row2['cycletime']);
                  $totalqty+=$row2['qty'];
                  $totalct+=$row2['cycletime'];
                  $line++;
              }
              $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(2, $line, 'Jumlah '.$row1['description'])
                    ->setCellValueByColumnAndRow(3, $line, ' >>>>> ')
                    ->setCellValueByColumnAndRow(4, $line, $totalqty)
                    ->setCellValueByColumnAndRow(7, $line, $totalct);
              $line+=2;
          }
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  /*public function JadwalProduksiXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname='jadwalproduksi';
      parent::actionDownxls();
      
      $sql        = "select distinct startdate
                  from productplanfg a
                  join productplan b on b.productplanid=a.productplanid
                  join sloc c on c.slocid=a.slocid
                  join product d on d.productid=a.productid
                  where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                  and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' 
                  and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0, $line, 'Tanggal')
              ->setCellValueByColumnAndRow(1, $line, ' : '.$row['startdate']);
          $line++;
          $sql1 = "select distinct f.materialgroupid,f.description
                      from productplanfg a
                      join productplan b on b.productplanid=a.productplanid
                      join sloc c on c.slocid=a.slocid
                      join product d on d.productid=a.productid
                      join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                      join materialgroup f on f.materialgroupid=e.materialgroupid
                      where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                      and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."'
                      and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' 
                      order by description";
          $command1    = yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          foreach($dataReader1 as $row1)
          {
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Material Group')
                ->setCellValueByColumnAndRow(1, $line, ' : '.$row1['description']);
              $line++;
              $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'SPP')
                ->setCellValueByColumnAndRow(2, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Qty')
                ->setCellValueByColumnAndRow(5, $line, 'Tgl Mulai')
                ->setCellValueByColumnAndRow(6, $line, 'Tgl Selesai');
              $line++;
              
              $sql2 = "select b.productplanno,d.productname,g.uomcode,a.qty,a.startdate,a.enddate
                        from productplanfg a
                        join productplan b on b.productplanid=a.productplanid
                        join sloc c on c.slocid=a.slocid
                        join product d on d.productid=a.productid
                        join productplant e on e.productid=a.productid and e.slocid=a.slocid and e.unitofissue=a.uomid
                        join materialgroup f on f.materialgroupid=e.materialgroupid
                        join unitofmeasure g on g.unitofmeasureid=a.uomid
                        where b.productplanno is not null and b.companyid = " . $companyid . " and b.recordstatus = 3
                        and c.sloccode like '%" . $sloc . "%' and d.productname like '%" . $product . "%' and a.startdate = '".$row['startdate']."' and f.materialgroupid = ".$row1['materialgroupid']."
                        and a.startdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "'  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ";
              $command2    = yii::app()->db->createCommand($sql2);
              $dataReader2 = $command2->queryAll();
              $i=0;$totalqty=0;
              foreach($dataReader2 as $row2)
              {
                  $i+=1;
                  $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $line, $i)
                    ->setCellValueByColumnAndRow(1, $line, $row2['productplanno'])
                    ->setCellValueByColumnAndRow(2, $line, $row2['productname'])
                    ->setCellValueByColumnAndRow(3, $line, $row2['uomcode'])
                    ->setCellValueByColumnAndRow(4, $line, $row2['qty'])
                    ->setCellValueByColumnAndRow(5, $line, $row2['startdate'])
                    ->setCellValueByColumnAndRow(6, $line, $row2['enddate']);
                  $totalqty+=$row2['qty'];
                  $line++;
              }
              $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(2, $line, 'Jumlah '.$row1['description'])
                    ->setCellValueByColumnAndRow(3, $line, ' >>>>> ')
                    ->setCellValueByColumnAndRow(4, $line, $totalqty);
              $line+=2;
          }
      }
      
      $this->getFooterXLS($this->phpExcel);
  }*/
  //15
  public function LaporanSPPStatusBelumMaxXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'laporansppstatusbelummax';
      parent::actionDownxls();
      
      $sql = "select distinct a.productplanid,a.companyid, a.productplanno, a.statusname, productplandate, a.description, a.recordstatus, group_concat(c.productname) as productname, d.sloccode, e.companycode
      from productplan a
      join productplanfg b on b.productplanid = a.productplanid
      join product c on c.productid = b.productid
      join sloc d on d.slocid = b.slocid
      join company e on e.companyid = a.companyid
      where a.recordstatus between 1 and 2
      and a.productplandate between ('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
      and ('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
      and a.companyid = ".$companyid."
      and d.sloccode like '%".$sloc."%'
      and c.productname like '%".$product."%'
      group by a.productplanid 
      order by a.productplanid desc";
      
      $command    = yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $line, 'No')
        ->setCellValueByColumnAndRow(1, $line, 'ID Transaksi')
        ->setCellValueByColumnAndRow(2, $line, 'No Dokumen')
        ->setCellValueByColumnAndRow(3, $line, 'Tanggal')
        ->setCellValueByColumnAndRow(4, $line, 'Product')
        ->setCellValueByColumnAndRow(5, $line, 'Gudang')
        ->setCellValueByColumnAndRow(6, $line, 'Keterangan')
        ->setCellValueByColumnAndRow(7, $line, 'Status');
      $i=0;
      $line++;
      foreach($dataReader as $row)
      {
          $i+=1;
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i)
            ->setCellValueByColumnAndRow(1, $line, $row['productplanid'])
            ->setCellValueByColumnAndRow(2, $line, $row['productplanno'])
            ->setCellValueByColumnAndRow(3, $line, date(Yii::app()->params['dateviewfromdb'],strtotime($row['productplandate'])))
            ->setCellValueByColumnAndRow(4, $line, $row['productname'])
            ->setCellValueByColumnAndRow(5, $line, $row['sloccode'])
            ->setCellValueByColumnAndRow(6, $line, $row['description'])
            ->setCellValueByColumnAndRow(7, $line, $row['statusname']);
          $line++;
      }
      $this->getFooterXLS($this->phpExcel);
  }
  //16
  public function LaporanPerbandinganXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname='laporanperbandingan';
      parent::actionDownxls();
      $sql = "select *, qtystock-pendinganso as lbstock
							from (select distinct productid, a.productname,d.uomcode,
							(select sum(g.qty)
							from productstockdet g
							where g.productid=a.productid
							and g.unitofmeasureid=a.unitofmeasureid
							and g.slocid=a.slocid
							and g.transdate<='2017-08-13') as qtystock,
							(select ifnull(sum(e.qty-e.giqty),0)
							from sodetail e
							join soheader f on f.soheaderid=e.soheaderid
							where f.recordstatus=6
							and f.companyid=c.companyid
							and e.productid=a.productid
							and e.unitofmeasureid=a.unitofmeasureid
							and f.sodate<='".date(Yii::app()->params['datetodb'], strtotime($enddate))."') as pendinganso
							from productstock a
							join sloc b on b.slocid=a.slocid
							join plant c on c.plantid=b.plantid
							join unitofmeasure d on d.unitofmeasureid=a.unitofmeasureid
							where c.companyid = ".$companyid."
							and c.plantcode like '%%'
							and (a.productname like 'matras%'
							or a.productname like 'divan%'
							or a.productname like 'bed sorong%'
							or a.productname like 'sandaran%')
							order by productname) z";
      $command=Yii::app()->db->createCommand($sql);
      $dataReader=$command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
          ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
          ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'No')
          ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
          ->setCellValueByColumnAndRow(2, $line, 'Stock Akhir')
          ->setCellValueByColumnAndRow(3, $line, 'Pendingan SO')
          ->setCellValueByColumnAndRow(4, $line, 'Lebih / Kurang')
          ->setCellValueByColumnAndRow(5, $line, 'WIP Kain')
          ->setCellValueByColumnAndRow(6, $line, 'WIP Rangka Per')
          ->setCellValueByColumnAndRow(7, $line, 'WIP Rangka Bed ')
          ->setCellValueByColumnAndRow(8, $line, 'WIP Rangka Divan')
          ->setCellValueByColumnAndRow(9, $line, 'WIP Rangka Sandaran')
          ->setCellValueByColumnAndRow(10, $line, 'WIP Centian');
          
      foreach($dataReader as $row)
      {
          if($row['lbstock']<0) {
					$sqlwipkain = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'wip kain%'";
					$res_kain = Yii::app()->db->createCommand($sqlwipkain)->queryAll();
					//$wipkain=$res->queryAll();
					$wipkain = '';
					foreach($res_kain as $row_kain){
									$sqldetail_kain = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
									from productstockdet g
								    where g.productid=".$row_kain['idwip']."
									and g.transdate<='2017-08-13'";
									$query = Yii::app()->db->createCommand($sqldetail_kain)->queryAll();
									foreach($query as $row2_kain){
											$wipkain .= $row2_kain['ukuran'].' => '.number_format($row2_kain['qty'],1)." \n";
									}
					}
					
			}else{
					$wipkain = 0;
			}
			
			if($row['lbstock']<0) {
					$sqlwiprangkaper = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 
										 AND a.productname like 'rangka per%'";
					$res_rangkaper= Yii::app()->db->createCommand($sqlwiprangkaper)->queryAll();
					//$wipkain=$res->queryAll();
					$wiprangkaper = '';
					foreach($res_rangkaper as $row_rangkaper){
									$sqldetail_rangkaper = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
									from productstockdet g
								    where g.productid=".$row_rangkaper['idwip']."
									and g.transdate<='2017-08-13'";
									$query_rangkaper = Yii::app()->db->createCommand($sqldetail_rangkaper)->queryAll();
									foreach($query_rangkaper as $row2_rangkaper){
											$wiprangkaper .= $row2_rangkaper['ukuran'].' => '.number_format($row2_rangkaper['qty'],1)." \n";
									}
					}
					
			}else{
					$wiprangkaper = 0;
			}
			
			if($row['lbstock']<0) {
					$sqlwiprangkabed = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'rangka bed sorong%'";
					$res_rangkabed= Yii::app()->db->createCommand($sqlwiprangkabed)->queryAll();
					//$wipkain=$res->queryAll();
					$wiprangkabed = '';
					foreach($res_rangkabed as $row_rangkabed){
									$sqldetail_rangkabed = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                    from productstockdet g
									where g.productid=".$row_rangkabed['idwip']."
									and g.transdate<='2017-08-13'";
									$query_rangkabed = Yii::app()->db->createCommand($sqldetail_rangkabed)->queryAll();
									foreach($query_rangkabed as $row2_rangkabed){
											$wiprangkabed .= $row2_rangkabed['ukuran'].' => '.number_format($row2_rangkabed['qty'],1)." \n";
									}
					}
					
			}else{
					$wiprangkabed = 0;
			}
			
			if($row['lbstock']<0) {
					$sqlwiprangkadivan = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 
										 AND a.productname like 'rangka divan%'";
					$res_rangkadivan= Yii::app()->db->createCommand($sqlwiprangkadivan)->queryAll();
					$sqlcount_divan = "select ifnull(count(1),0)
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'rangka divan%'";
					//$wipkain=$res->queryAll();
					$count_divan = Yii::app()->db->createCommand($sqlcount_divan)->queryScalar();
					$wiprangkadivan = '';
					if($count_divan=='0'){
									$wiprangkadivan = '-';
							}else{
					foreach($res_rangkadivan as $row_rangkadivan){
									$sqldetail_rangkadivan = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                    from productstockdet g
								    where g.productid=".$row_rangkadivan['idwip']."
									and g.transdate<='2017-08-13'";
									$query_rangkadivan = Yii::app()->db->createCommand($sqldetail_rangkadivan)->queryAll();
									foreach($query_rangkadivan as $row2_rangkadivan){
											$wiprangkadivan .= $row2_rangkadivan['ukuran'].' => '.number_format($row2_rangkadivan['qty'],1)." \n";
									}
							}
					}
					
			}else{
					$wiprangkadivan = 0;
			}
			
			if($row['lbstock']<0) {
					$sqlwiprangkasandaran = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'sandaran%'";
					$sqlcount_sandaran = "select ifnull(count(1),0)
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'sandaran%'";
					$count_sandaran = Yii::app()->db->createCommand($sqlcount_sandaran)->queryScalar();
					$res_rangkasandaran= Yii::app()->db->createCommand($sqlwiprangkasandaran)->queryAll();
					//$wipkain=$res->queryAll();
					$wiprangkasandaran = '';
					if($count_sandaran=='0'){
									$wiprangkasandaran = '-';
							}else{
							foreach($res_rangkasandaran as $row_rangkasandaran){
									$sqldetail_rangkasandaran = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                    from productstockdet g
								    where g.productid=".$row_rangkasandaran['idwip']."
									and g.transdate<='2017-08-13'";
									$query_rangkasandaran = Yii::app()->db->createCommand($sqldetail_rangkasandaran)->queryAll();
									foreach($query_rangkasandaran as $row2_rangkasandaran){
											$wiprangkasandaran .= $row2_rangkasandaran['ukuran'].' => '.number_format($row2_rangkasandaran['qty'],1)." \n";
									}
							}
					}
					
			}else{
					$wiprangkasandaran = 0;
			}
			
			if($row['lbstock']<0) {
					$sqlwipcentian = "select c.productid as idwip, a.productname, b.productid
										 from billofmaterial b
										 left join bomdetail c on c.bomid = b.bomid
										 left join product a on a.productid = c.productid 
										 where b.productid = ".$row['productid']." and a.isstock = 1 and a.productname like 'centian%'";
					$res_centian= Yii::app()->db->createCommand($sqlwipcentian)->queryAll();
					//$wipkain=$res->queryAll();
					$wipcentian = '';
					foreach($res_centian as $row_centian){
									$sqldetail_centian = "select sum(g.qty) as qty, concat('Uk. ',right(g.productname,7)) as ukuran
                                    from productstockdet g
									where g.productid=".$row_centian['idwip']."
									and g.transdate<='2017-08-13'";
									$query_centian = Yii::app()->db->createCommand($sqldetail_centian)->queryAll();
									foreach($query_centian as $row2_centian){
											$wipcentian .= $row2_centian['ukuran'].' => '.number_format($row2_centian['qty'],1)." \n";
									}
					}
					
			}else{
					$wipcentian = 0;
			}
          
           $this->phpExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow(0, $line, $i)
               ->setCellValueByColumnAndRow(1, $line, $row['productname'])
               ->setCellValueByColumnAndRow(2, $line, $row['qtystock'])
               ->setCellValueByColumnAndRow(3, $line, $row['pendinganso'])
               ->setCellValueByColumnAndRow(4, $line, $row['lbstock'])
               ->setCellValueByColumnAndRow(5, $line, $wipkain)
               ->setCellValueByColumnAndRow(6, $line, $wiprangkaper)
               ->setCellValueByColumnAndRow(7, $line, $wiprangkabed)
               ->setCellValueByColumnAndRow(8, $line, $wiprangkadivan)
               ->setCellValueByColumnAndRow(9, $line, $wiprangkasandaran)
               ->setCellValueByColumnAndRow(10, $line, $wipcentian);
          $i++;
          $line++;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //17
  public function LaporanMaterialSPPXLS($companyid,$sloc,$fullname,$product,$startdate,$enddate)
  {
      $this->menuname='laporanmaterialspp';
      parent::actionDownxls();
      
      $id = '';
      $sql = "select distinct concat(b.productplanfgid,',') as id, sum(qtyoutput) as qtyop, sum(qty) as qtyspp
                    -- SELECT a.productplanid, a.productplanno, c.productoutputid, sum(qtyoutput) as qtyop, sum(qty) as qtyspp, b.productid
                    from productplan a 
                    join productplanfg b on a.productplanid = b.productplanid
                    join productoutput c on c.productplanid = a.productplanid
                    join productoutputfg d on d.productoutputid = c.productoutputid 
                    -- and d.productplanfgid = b.productplanfgid
                    where a.productplandate between ('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') and ('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
                    and a.recordstatus = 3 and c.recordstatus = 3
                    group by b.productplanfgid
                    having qtyspp > qtyop";
      $command=Yii::app()->db->createCommand($sql);
      $dataReader=$command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
          ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
          ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      foreach($dataReader as $row){
          $id .= $row['id'];
      }
      $id .= '-1';
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'No')
          ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
          ->setCellValueByColumnAndRow(2, $line, 'Satuan')
          ->setCellValueByColumnAndRow(3, $line, 'Jumlah (SPP)')
          ->setCellValueByColumnAndRow(4, $line, 'Qty Dibutuhkan')
          ->setCellValueByColumnAndRow(5, $line, 'Stock')
          ->setCellValueByColumnAndRow(6, $line, 'Plus/Minus');
      
      $line ++;
      
      $sql1 = "select b.productid, b.productname, sum(qty-qtyres) as qtyneed, c.uomcode,group_concat(distinct a.productplanid) as count
							from productplandetail a
							join product b on a.productid = b.productid
							join unitofmeasure c on c.unitofmeasureid = a.uomid
							where productplanfgid in (".$id.") and b.isstock = 1
							group by productid 
							having qtyneed > 0
							order by productname ";
      $cmd1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $i=1;
      foreach($cmd1 as $row1)
      {
          $explode = explode(',',$row1['count'],-1);
          $count = count($explode);
          $sqlstock = "select sum(qty+qtyinprogress)
                    from productstock
                    where productid =".$row1['productid']."";
          $stock = Yii::app()->db->createCommand($sqlstock)->queryScalar();
          
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0, $line, $i)
              ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
              ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
              ->setCellValueByColumnAndRow(3, $line, ($count+1))
              ->setCellValueByColumnAndRow(4, $line, $row1['qtyneed'])
              ->setCellValueByColumnAndRow(5, $line, $stock)
              ->setCellValueByColumnAndRow(6, $line, ($stock - $row1['qtyneed']));
          $line++;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //18
  public function LaporanHasilScanXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname='laporanhasilscan';
      parent::actionDownxls();
      
      $subtotalqty       = 0;
      $subtotalqtyoutput = 0;
      $subtotalselisih   = 0;
      $sql               = "select distinct d.description,d.slocid
							from productoutput b
							join productoutputfg c on c.productoutputid=b.productoutputid
							join sloc d on d.slocid=c.slocid
							join product e on e.productid=c.productid
							join unitofmeasure f on f.unitofmeasureid=c.uomid
              left join employee g on g.employeeid = b.employeeid
						  where d.sloccode like '%" . $sloc . "%' ".getFieldTable($productcollectid,'e','productcollectid')."
              ".getCompanyGroup($companyid,'b')."
						  and e.productname like '%" . $product . "%' and g.fullname like '%{$fullname}%'
						  and b.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by slocid";
      $command           = Yii::app()->db->createCommand($sql);
      $dataReader        = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
          ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
          ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      foreach($dataReader as $row)
      {
           $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'GUDANG ')
          ->setCellValueByColumnAndRow(1, $line, ' : '.$row['description']);
          
          $line++;
          
          $sql1           = "select d.productname,e.uomcode,sum(b.qtyoutput) as qtyoutput,a.productoutputno,a.productoutputdate,(select ifnull(sum(f.qtyori),0) from tempscan f where f.productoutputfgid= b.productoutputfgid) as qtyori
												from productoutput a
												join productoutputfg b on b.productoutputid=a.productoutputid
												join sloc c on c.slocid=b.slocid
												join product d on d.productid=b.productid
												join unitofmeasure e on e.unitofmeasureid=b.uomid
                        left join employee f on f.employeeid = a.employeeid
						 where c.slocid = ".$row['slocid']." ".getFieldTable($productcollectid,'d','productcollectid')."
            ".getCompanyGroup($companyid,'a')." and c.sloccode like '%" . $sloc . "%' 
						 and d.productname like '%" . $product . "%'
						 and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						 and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						 group by productname,uomcode,productoutputno
						 order by productname,productoutputdate,productoutputno";
            $command1       = Yii::app()->db->createCommand($sql1);
            $dataReader1    = $command1->queryAll();
            
            $totalqty       = 0;
            $i              = 0;
            $totalqtyoutput = 0;
            $totalselisih   = 0;
          
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'NO')
                ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(2, $line, 'Satuan')
                ->setCellValueByColumnAndRow(3, $line, 'Qty OP')
                ->setCellValueByColumnAndRow(4, $line, 'Qty Scan')
                ->setCellValueByColumnAndRow(5, $line, 'No. Dok.')
                ->setCellValueByColumnAndRow(6, $line, 'Tanggal');
          
          $line++;
          
          foreach($dataReader1 as $row1)
          {
              $i += 1;
              $this->phpExcel->setActiveSheetIndex(0)
                   ->setCellValueByColumnAndRow(0, $line, $i)
                   ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                   ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
                   ->setCellValueByColumnAndRow(3, $line, $row1['qtyoutput'])
                   ->setCellValueByColumnAndRow(4, $line, $row1['qtyori'])
                   ->setCellValueByColumnAndRow(5, $line, $row1['productoutputno'])
                   ->setCellValueByColumnAndRow(6, $line, $row1['productoutputdate']);
              $line++;
              $totalqty += $row1['qtyori'];
              $totalqtyoutput += $row1['qtyoutput'];
          }
          
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'TOTAL '.$row['description'])
                ->setCellValueByColumnAndRow(3, $line, $totalqtyoutput)
                ->setCellValueByColumnAndRow(4, $line, $totalqty);
          $line++;
      }
      
      $this->getFooterXLS($this->phpExcel);
  }
  //19
  public function LaporanHasilOperatorPerManPowerXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname='laporanhasiloperatorpermanpower';
      parent::actionDownxls();
      
      $day1 = 420;
      $day5 = 360;
      $day6 = 360;
      $totalday=0;
      //$price = 267; old
      // new
      $price = 271;
      
      $sql = "select employeeid, fullname, headernote, isover, operatoroutputid, sum(ctover) as ctover from (select a.employeeid, c.fullname, b.headernote,isover,ctover,b.operatoroutputid
            from operatoroutputdet a
            join operatoroutput b on b.operatoroutputid = a.operatoroutputid
            join employee c on c.employeeid = a.employeeid
            join sloc e on e.slocid = b.slocid
            where b.opoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and c.fullname like '%{$fullname}%'
            and e.sloccode like '%{$sloc}%'
            and b.recordstatus= getwfmaxstatbywfname('appopoutput')
            and isover=0
            union
            select a.employeeid, c.fullname, if(b.headernote<>'',b.headernote,if(a.description<>'',concat('KET ',a.description),'LEMBUR')) as headernote,isover,ctover,b.operatoroutputid
            from operatoroutputdet a
            join operatoroutput b on b.operatoroutputid = a.operatoroutputid
            join employee c on c.employeeid = a.employeeid
            join sloc e on e.slocid = b.slocid
            where b.opoutputdate between  '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and b.companyid = {$companyid}
            and c.fullname like '%{$fullname}%'
            and e.sloccode like '%{$sloc}%'
            and b.recordstatus= getwfmaxstatbywfname('appopoutput')
            and isover=1 ) z
            group by employeeid,isover
            order by fullname";
      
      $command = Yii::app()->db->createCommand($sql);
      $dataReader = $command->queryAll();
      
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
          ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
          ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      
      $line = 4;
      
      $dates = dateRange($startdate,$enddate);
      for($j=0; $j<count($dates); $j++)
      {
          if(date('l',strtotime($dates[$j]))=='Monday' || date('l',strtotime($dates[$j]))=='Tuesday' || date('l',strtotime($dates[$j]))=='Wednesday' || date('l',strtotime($dates[$j]))=='Thursday')
          {
              $totalday += $day1;
          }
          else if(date('l',strtotime($dates[$j]))=='Friday')
          {
              $totalday += $day5; 
          }
          else if(date('l',strtotime($dates[$j]))=='Saturday')
          {
              $totalday += $day6; 
          }
          else
          {
              $totalday += 0; 
          }
      }
      $isover=0;$totalct2=0;$totalqty2=0;
      foreach($dataReader as $row)
      {
          if($row['isover']==0)
          {
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'JAM OPERASIONAL ');
              $line++;
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line,'Operator ')
                  ->setCellValueByColumnAndRow(1, $line, ' : '.$row['fullname'])
                  ->setCellValueByColumnAndRow(5, $line, 'Jumlah CT ')
                  ->setCellValueByColumnAndRow(6, $line, ' : '.$totalday);
              $line++;
          }
          else
          {
              $totalct1 = $totalct2;
              $totalqty1 = $totalqty2;  
              
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'TAMBAHAN WAKTU / LEMBUR ')
                  ->setCellValueByColumnAndRow(5, $line, 'CT Lembur ')
                  ->setCellValueByColumnAndRow(6, $line, ' : '.$row['ctover']);
              $line++;
          }
          $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'Keterangan')
                  ->setCellValueByColumnAndRow(1, $line, ' : '.$row['headernote']);
          $line++;
          
          if($row['isover']==0)
          {
              $isover = 0;
          }
          else
          {
              $isover = 1;
          }
          $sql1 = "select a.opoutputdate, c.fullname, sum(b.qty) as qty,         
                d.groupname,sum(b.cycletime*qty) as cycletime, b.operatoroutputdetid,b.description,a.headernote
                from operatoroutput a
                join operatoroutputdet b on b.operatoroutputid = a.operatoroutputid
                join employee c on c.employeeid = b.employeeid
                join standardopoutput d on d.standardopoutputid = b.standardopoutputid
                where b.employeeid = ".$row['employeeid']."
                and a.opoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                and a.recordstatus= getwfmaxstatbywfname('appopoutput')
                and a.isover = {$isover}
                group by b.standardopoutputid,opoutputdate
                order by opoutputdate";

          $command1 = Yii::app()->db->createCommand($sql1);
          $dataReader1 = $command1->queryAll();
          
          $i=0;
          //$totalqty1 = 0;
          $totalqty2 = 0;
          //$totalct1 = 0;
          $totalct2 = 0;
          
          $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'No')
                  ->setCellValueByColumnAndRow(1, $line, 'Tanggal')
                  ->setCellValueByColumnAndRow(2, $line, 'Nama Grup')
                  ->setCellValueByColumnAndRow(3, $line, 'Qty Hasil')
                  ->setCellValueByColumnAndRow(4, $line, 'Cycle Time')
                  ->setCellValueByColumnAndRow(5, $line, 'Note')
                  ->setCellValueByColumnAndRow(6, $line, 'Insentif');
          $line++;
          
          foreach($dataReader1 as $row1)
          {
              $i += 1;
              $sql2 = "select ifnull(count(1),0)
                      from operatoroutputissue a
                      where a.operatoroutputdetid = ".$row1['operatoroutputdetid'];
              $getcount = Yii::app()->db->createCommand($sql2)->queryScalar();
              
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, $i)
                  ->setCellValueByColumnAndRow(1, $line, $row1['opoutputdate'])
                  ->setCellValueByColumnAndRow(2, $line, $row1['groupname'])
                  ->setCellValueByColumnAndRow(3, $line, $row1['qty'])
                  ->setCellValueByColumnAndRow(4, $line, $row1['cycletime'])
                  ->setCellValueByColumnAndRow(5, $line, $row1['description']);
              $line++;
              
              if($getcount>0)
              {
                $sql3 = "select description, cycletime from operatoroutputissue where operatoroutputdetid = ".$row1['operatoroutputdetid'];
                $command3 = Yii::app()->db->createCommand($sql3);
                $dataReader3 = $command3->queryAll();
                foreach($dataReader3 as $row3)
                {
                    $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(1, $line, 'Issue')
                        ->setCellValueByColumnAndRow(2, $line, ' : '.$row3['description'])
                        ->setCellValueByColumnAndRow(4, $line, ' : '.$row3['cycletime']);
                    $line++;
                    $totalct2 += $row3['cycletime'];
                }
              }
              $totalct2 += $row1['cycletime'];
              $totalqty2 += $row1['qty'];
          }
          
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'TOTAL')
                ->setCellValueByColumnAndRow(3, $line, $totalqty2)
                ->setCellValueByColumnAndRow(4, $line, $totalct2);
            $line++;
          
            if($isover==0)
            {
                $line++;
            }
            if($totalct2 > $totalday)
            {
              
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(2, $line, 'Jumlah Kelebihan CT')
                  ->setCellValueByColumnAndRow(3, $line, ' : '.$totaalct2-$totalday)
                  ->setCellValueByColumnAndRow(5, $line, 'Rp. ')
                  ->setCellValueByColumnAndRow(6, $line, ' : '.($totalct2-$totalday)*$price);
                $line++;
            }
            if($isover==1)
            {
                 $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(2, $line, 'Jumlah Hasil (CT) - CT Lembur')
                    ->setCellValueByColumnAndRow(3, $line, ' : '.($totalct2-$row['ctover']));
                 $line++;
                
              
                if($totalct1 > $totalday)
                {
                     $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0, $line, 'Kelebihan CT ')
                        ->setCellValueByColumnAndRow(1, $line, ' : '.$totalct1-$totalday);
                    $line++;
                }
                else
                {
                    $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0, $line, 'Kekurangan CT ')
                        ->setCellValueByColumnAndRow(1, $line, ' : '.$totalday - $totalct1);
                    $line++;
                }

                if($totalct2 > $row['ctover'])
                {
                    $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0, $line, 'Kelebihan CT Lembur')
                        ->setCellValueByColumnAndRow(1, $line, ' : '.$totalct2 - $row['ctover']);
                    $line++;
                }
                else
                {
                    $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0, $line, 'Kekurangan CT Lembur')
                        ->setCellValueByColumnAndRow(1, $line, ' : '.$row['ctover']-$totalct2);
                    $line++;
                }
                $line = $line + 2;
          }
      }
      $this->getFooterXLS($this->phpExcel);
  }
  //20
  public function LaporanCTPerForemanPerDokumenXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
      $this->menuname = 'laporanctperforemanperdokumen';
      parent::actionDownxls();
      
      $hk = 400;
      $sql = "select distinct b.slocid, c.sloccode, c.description
            from productoutput a
            join productoutputfg b on b.productoutputid = a.productoutputid
            join sloc c on c.slocid = b.slocid
            left join employee d on d.employeeid = a.employeeid
            where a.companyid = {$companyid} and a.recordstatus = 3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
            and c.sloccode like '%{$sloc}%' ";
      if($fullname!='')
      {
        $sql .= " and d.fullname like '%".$fullname."%'";
      }
       
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
          ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
          ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
      $line = 4;
      foreach($dataReader as $row)
      {
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line, 'GUDANG ')
              ->setCellValueByColumnAndRow(1,$line, ' : '.$row['description']);
          $line++;
          
          $sql1 = "select distinct ifnull(c.fullname,'UMUM') as fullname ,ifnull(c.employeeid,0) as employeeid
                  from productoutput a
                  join productoutputfg b on b.productoutputid = a.productoutputid
                  left join employee c on c.employeeid = a.employeeid
                  where a.recordstatus = 3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                  and b.slocid = ".$row['slocid'];
          
          if($fullname!='')
          {
              $sql1 .= " and c.fullname like '%".$fullname."%'";
          }
          
          $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
          foreach($dataReader1 as $row1)
          {
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'FOREMAN')
                  ->setCellValueByColumnAndRow(1, $line, ' : '.$row1['fullname']);
              $line++;
              
              $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $line, 'NO')
                  ->setCellValueByColumnAndRow(1, $line, 'NO.SPP')
                  ->setCellValueByColumnAndRow(2, $line, 'NAMA BARANG')
                  ->setCellValueByColumnAndRow(3, $line, 'SATUAN')
                  ->setCellValueByColumnAndRow(4, $line, 'QTY.SPP')
                  ->setCellValueByColumnAndRow(5, $line, 'CT.SPP')
                  ->setCellValueByColumnAndRow(6, $line, 'NO.OP')
                  ->setCellValueByColumnAndRow(7, $line, 'QTY.OP')
                  ->setCellValueByColumnAndRow(8, $line, 'CT.OP');
              $line++;
              
              $sql2 = "select d.productname, a.productoutputno, b.qtyoutput, (b.qtyoutput*cycletime) as ctop,
                      (select (qty*bb.cycletime) 
                       from productplanfg bb 
                       where bb.productplanfgid = b.productplanfgid and bb.productid = b.productid) as ctspp,
                       (select qty
                       from productplanfg bb 
                       where bb.productplanfgid = b.productplanfgid and bb.productid = b.productid) as qtyspp,
                       e.uomcode, f.productplanno
                     from productoutput a 
                     join productoutputfg b on b.productoutputid = a.productoutputid
                     join productplan f on f.productplanid = a.productplanid
                     left join employee c on c.employeeid = a.employeeid
                     join product d on d.productid = b.productid
                     join unitofmeasure e on e.unitofmeasureid = b.uomid
                     where a.recordstatus=3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                     and b.slocid = {$row['slocid']} ";
              if($row1['employeeid'] > 0) {
                  $sql2 .= " and c.employeeid = ".$row1['employeeid'];
              }
              
              $i=1;
              $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
              foreach($dataReader2 as $row2)
              {
                  $this->phpExcel->setActiveSheetIndex(0)
                      ->setCellValueByColumnAndRow(0, $line, $i)
                      ->setCellValueByColumnAndRow(1, $line, $row2['productplanno'])
                      ->setCellValueByColumnAndRow(2, $line, $row2['productname'])
                      ->setCellValueByColumnAndRow(3, $line, $row2['uomcode'])
                      ->setCellValueByColumnAndRow(4, $line, $row2['qtyspp'])
                      ->setCellValueByColumnAndRow(5, $line, $row2['ctspp'])
                      ->setCellValueByColumnAndRow(6, $line, $row2['productoutputno'])
                      ->setCellValueByColumnAndRow(7, $line, $row2['qtyoutput'])
                      ->setCellValueByColumnAndRow(8, $line, $row2['ctop']);
                  $line++;
                  $i++;
              }
              $line++;
              $sqlct = "select datediff('".date(Yii::app()->params['datetodb'],strtotime($enddate))."','".date(Yii::app()->params['datetodb'],strtotime($startdate))."') + 1 as days,
                    sum(ctop) as ctop, sum(cycletime*za.qty) as ctspp
                    from (select sum(b.qtyoutput*cycletime) as ctop, b.productplanfgid
                     from productoutput a 
                     join productoutputfg b on b.productoutputid = a.productoutputid
                     join productplan f on f.productplanid = a.productplanid
                     left join employee c on c.employeeid = a.employeeid
                     join product d on d.productid = b.productid
                     join unitofmeasure e on e.unitofmeasureid = b.uomid
                     where a.recordstatus=3 and a.productoutputdate between '".date(Yii::app()->params['datetodb'],strtotime($startdate))."' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
                     and b.slocid = {$row['slocid']} and a.employeeid = {$row1['employeeid']}
                     group by b.productplanfgid
                     )z
                     join productplanfg za on za.productplanfgid = z.productplanfgid";
              $ct = Yii::app()->db->createCommand($sqlct)->queryRow();
              //$sqlct = Yii::app()->db->createCommand($sqlct)->queryRow();
              $this->phpExcel->setActiveSheetIndex(0)
                      ->setCellValueByColumnAndRow(3, $line,"TOTAL CYLETIME {$ct['days']} HARI KERJA ")
                      ->setCellValueByColumnAndRow(5, $line,' : '.$ct['days']*$hk.' MENIT');
              $line++;
              $this->phpExcel->setActiveSheetIndex(0)
                      ->setCellValueByColumnAndRow(3, $line,'TOTAL CYLETIME SPP ')
                      ->setCellValueByColumnAndRow(5, $line,' : '.Yii::app()->format->formatCurrency($ct['ctspp']/60).' MENIT');
              $line++;
              $this->phpExcel->setActiveSheetIndex(0)
                      ->setCellValueByColumnAndRow(3, $line,'TOTAL CYLETIME OP ')
                      ->setCellValueByColumnAndRow(5, $line,' : '.Yii::app()->format->formatCurrency($ct['ctop']/60).' MENIT');
                  
              $line = $line + 2;
          }
      }
      $this->getFooterXLS($this->phpExcel);
  }
  //21
  public function LaporanRincianHasilProduksiPerGMprocessXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
		$this->menuname = 'laporanrincianhasilproduksipermgprocess';
		parent::actionDownxls();
		
		$i=0;$qtyoutput1=0;$qtyoutput2=0;$qtyoutput3=0;$qtyoutput4=0;$qtyoutput5=0;$qtyoutput6=0;
		$sqltgl = "SELECT DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH) AS tgl1,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH) AS tgl2,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH) AS tgl3,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH) AS tgl4,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH) AS tgl5,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH) AS tgl6";
		$title = Yii::app()->db->createCommand($sqltgl)->queryRow();
		
		$sql = "SELECT *
						FROM (SELECT a.productid,a.productname,f.description,c.uomcode
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput1
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput2
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput3
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput4
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput5
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput6
						FROM product a
						JOIN productplant b ON b.productid = a.productid
						JOIN unitofmeasure c ON c.unitofmeasureid = b.unitofissue
						JOIN sloc d ON d.slocid = b.slocid
						JOIN plant e ON e.plantid = d.plantid
						JOIN mgprocess f ON f.mgprocessid = b.mgprocessid
						WHERE a.recordstatus = 1
						AND a.isstock = 1
						AND e.companyid = ".$companyid."
						AND a.productname like '%".$product."%'
						AND d.sloccode like '%".$sloc."%'
						) z
						WHERE qtyoutput1 <> 0 OR qtyoutput2 <> 0 OR qtyoutput3 <> 0 OR qtyoutput4 <> 0 OR qtyoutput5 <> 0 OR qtyoutput6 <> 0
						ORDER BY description
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, 2, 'Periode : ' . date("F Y", strtotime($enddate)))
			->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
		
		$line = 4;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $line, 'NO')
				->setCellValueByColumnAndRow(1, $line, 'NAMA BARANG')
				->setCellValueByColumnAndRow(2, $line, 'MATERIAL GRUP PROSES')
				->setCellValueByColumnAndRow(3, $line, 'SATUAN')
				->setCellValueByColumnAndRow(4, $line, date("F Y", strtotime($title['tgl1'])))
				->setCellValueByColumnAndRow(5, $line, date("F Y", strtotime($title['tgl2'])))
				->setCellValueByColumnAndRow(6, $line, date("F Y", strtotime($title['tgl3'])))
				->setCellValueByColumnAndRow(7, $line, date("F Y", strtotime($title['tgl4'])))
				->setCellValueByColumnAndRow(8, $line, date("F Y", strtotime($title['tgl5'])))
				->setCellValueByColumnAndRow(9, $line, date("F Y", strtotime($title['tgl6'])));
		$line++;
		
		foreach($dataReader as $row)
		{
			$i++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $line, $i)
				->setCellValueByColumnAndRow(1, $line, $row['productname'])
				->setCellValueByColumnAndRow(2, $line, $row['description'])
				->setCellValueByColumnAndRow(3, $line, $row['uomcode'])
				->setCellValueByColumnAndRow(4, $line, $row['qtyoutput1'])
				->setCellValueByColumnAndRow(5, $line, $row['qtyoutput2'])
				->setCellValueByColumnAndRow(6, $line, $row['qtyoutput3'])
				->setCellValueByColumnAndRow(7, $line, $row['qtyoutput4'])
				->setCellValueByColumnAndRow(8, $line, $row['qtyoutput5'])
				->setCellValueByColumnAndRow(9, $line, $row['qtyoutput6']);
			$line++;
			$qtyoutput1 += $row['qtyoutput1'];
			$qtyoutput2 += $row['qtyoutput2'];
			$qtyoutput3 += $row['qtyoutput3'];
			$qtyoutput4 += $row['qtyoutput4'];
			$qtyoutput5 += $row['qtyoutput5'];
			$qtyoutput6 += $row['qtyoutput6'];
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(3, $line, 'TOTAL >>>')
			->setCellValueByColumnAndRow(4, $line, $qtyoutput1)
			->setCellValueByColumnAndRow(5, $line, $qtyoutput2)
			->setCellValueByColumnAndRow(6, $line, $qtyoutput3)
			->setCellValueByColumnAndRow(7, $line, $qtyoutput4)
			->setCellValueByColumnAndRow(8, $line, $qtyoutput5)
			->setCellValueByColumnAndRow(9, $line, $qtyoutput6);
		$this->getFooterXLS($this->phpExcel);
  }
  //22
  public function LaporanRekapHasilProduksiPerGMprocessXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
		$this->menuname = 'laporanrekaphasilproduksipermgprocess';
		parent::actionDownxls();
		
		$i=0;$qtyoutput1=0;$qtyoutput2=0;$qtyoutput3=0;$qtyoutput4=0;$qtyoutput5=0;$qtyoutput6=0;
		$sqltgl = "SELECT DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH) AS tgl1,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH) AS tgl2,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH) AS tgl3,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH) AS tgl4,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH) AS tgl5,DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH) AS tgl6";
		$title = Yii::app()->db->createCommand($sqltgl)->queryRow();
		
		$sql = "SELECT description,uomcode,SUM(qtyoutput1) AS qtyoutput1,SUM(qtyoutput2) AS qtyoutput2,SUM(qtyoutput3) AS qtyoutput3,SUM(qtyoutput4) AS qtyoutput4,SUM(qtyoutput5) AS qtyoutput5,SUM(qtyoutput6) AS qtyoutput6
						FROM (SELECT a.productid,a.productname,f.description,c.uomcode
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 7 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput1
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 6 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput2
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 5 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput3
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 4 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput4
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 3 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput5
						,IFNULL((SELECT sum(IFNULL(a1.qtyoutput,0)) FROM productoutputfg a1 WHERE MONTH(a1.outputdate) = MONTH(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND YEAR(a1.outputdate) = YEAR(DATE_SUB('".date(Yii::app()->params['datetodb'],strtotime($enddate))."',INTERVAL 2 MONTH)) AND a1.productid = a.productid AND a1.slocid = b.slocid),0) AS qtyoutput6
						FROM product a
						JOIN productplant b ON b.productid = a.productid
						JOIN unitofmeasure c ON c.unitofmeasureid = b.unitofissue
						JOIN sloc d ON d.slocid = b.slocid
						JOIN plant e ON e.plantid = d.plantid
						JOIN mgprocess f ON f.mgprocessid = b.mgprocessid
						WHERE a.recordstatus = 1
						AND a.isstock = 1
						AND e.companyid = ".$companyid."
						AND a.productname like '%".$product."%'
						AND d.sloccode like '%".$sloc."%'
						) z
						WHERE qtyoutput1 <> 0 OR qtyoutput2 <> 0 OR qtyoutput3 <> 0 OR qtyoutput4 <> 0 OR qtyoutput5 <> 0 OR qtyoutput6 <> 0
						GROUP BY description
						ORDER BY description
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, 2, 'Periode : ' . date("F Y", strtotime($enddate)))
			->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
		
		$line = 4;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $line, 'NO')
				->setCellValueByColumnAndRow(1, $line, 'MATERIAL GRUP PROSES')
				->setCellValueByColumnAndRow(2, $line, 'SATUAN')
				->setCellValueByColumnAndRow(3, $line, date("F Y", strtotime($title['tgl1'])))
				->setCellValueByColumnAndRow(4, $line, date("F Y", strtotime($title['tgl2'])))
				->setCellValueByColumnAndRow(5, $line, date("F Y", strtotime($title['tgl3'])))
				->setCellValueByColumnAndRow(6, $line, date("F Y", strtotime($title['tgl4'])))
				->setCellValueByColumnAndRow(7, $line, date("F Y", strtotime($title['tgl5'])))
				->setCellValueByColumnAndRow(8, $line, date("F Y", strtotime($title['tgl6'])));
		$line++;
		
		foreach($dataReader as $row)
		{
			$i++;
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $line, $i)
				->setCellValueByColumnAndRow(1, $line, $row['description'])
				->setCellValueByColumnAndRow(2, $line, $row['uomcode'])
				->setCellValueByColumnAndRow(3, $line, $row['qtyoutput1'])
				->setCellValueByColumnAndRow(4, $line, $row['qtyoutput2'])
				->setCellValueByColumnAndRow(5, $line, $row['qtyoutput3'])
				->setCellValueByColumnAndRow(6, $line, $row['qtyoutput4'])
				->setCellValueByColumnAndRow(7, $line, $row['qtyoutput5'])
				->setCellValueByColumnAndRow(8, $line, $row['qtyoutput6']);
			$line++;
			$qtyoutput1 += $row['qtyoutput1'];
			$qtyoutput2 += $row['qtyoutput2'];
			$qtyoutput3 += $row['qtyoutput3'];
			$qtyoutput4 += $row['qtyoutput4'];
			$qtyoutput5 += $row['qtyoutput5'];
			$qtyoutput6 += $row['qtyoutput6'];
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(2, $line, 'TOTAL >>>')
			->setCellValueByColumnAndRow(3, $line, $qtyoutput1)
			->setCellValueByColumnAndRow(4, $line, $qtyoutput2)
			->setCellValueByColumnAndRow(5, $line, $qtyoutput3)
			->setCellValueByColumnAndRow(6, $line, $qtyoutput4)
			->setCellValueByColumnAndRow(7, $line, $qtyoutput5)
			->setCellValueByColumnAndRow(8, $line, $qtyoutput6);
		$this->getFooterXLS($this->phpExcel);
  }
  //23
  public function RekapPemakaianPerBarangXLS($companyid, $sloc, $fullname, $product, $productcollectid, $startdate, $enddate)
  {
    $this->menuname = 'rekappemakaianperbarang';
    parent::actionDownxls();
	  if($companyid > 0){$joincom = ""; $wherecom = " and c.companyid = ".$companyid." ";}else{$joincom = " join company a9 on a9.companyid=c.companyid "; $wherecom = " and a9.isgroup = 1";}
    $sql        = "select distinct a.toslocid,a.fromslocid,
            e.sloccode fromsloccode,
        e.description as fromslocdesc,
        f.sloccode as tosloccode,	
        f.description as toslocdesc
            from productoutputdetail a
            join product b on b.productid = a.productid
            join productoutput c on c.productoutputid = a.productoutputid
            join sloc e on e.slocid = a.fromslocid
            join sloc f on f.slocid = a.toslocid
            where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'c')."
            -- and (e.sloccode like '%" . $sloc . "%' or f.sloccode like '%" . $sloc . "%') 
            and b.productname like '%" . $product . "%' and c.productoutputdate between 
            '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
            '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
            limit 1
	  ";
    $command    = yii::app()->db->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(3, 1, GetCompanyCode($companyid));
    $line = 4;
    foreach ($dataReader as $row) 
    {
      //$this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Asal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['fromsloccode'] . ' - ' . $row['fromslocdesc']);
      //$line++;
      //$this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tujuan')->setCellValueByColumnAndRow(1, $line, ': ' . $row['tosloccode'] . ' - ' . $row['toslocdesc']);
      //$line++;
      //$this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Satuan')->setCellValueByColumnAndRow(3, $line, 'Qty');
      //$line++;
      $sql1        = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						where c.recordstatus = 3 ".getFieldTable($productcollectid,'b','productcollectid')."
            ".getCompanyGroup($companyid,'c')."
						-- and a.fromslocid = " . $row['fromslocid'] . " and a.toslocid = " . $row['toslocid'] . "
						and b.productname like '%" . $product . "%' and c.productoutputdate between 
						'" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and 
						'" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						group by productname,uomcode";
      $command1    = yii::app()->db->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $totalqty    = 0;
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])->setCellValueByColumnAndRow(3, $line, $row1['qty']);
        $line++;
        $totalqty += $row1['qty'];
      }
      //$this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(3, $line, $totalqty);
      $line += 2;
    }
    $this->getFooterXLS($this->phpExcel);
  }
  //99
	
}

