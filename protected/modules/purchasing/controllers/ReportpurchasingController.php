<?php

class ReportpurchasingController extends AdminController
{
	protected $menuname = 'reportpurchasing';		
	public $module = 'purchasing';
	protected $pageTitle = 'Laporan Pembelian';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['supplier']) && isset($_GET['productcollectid']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1) {
        $this->RincianPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 3) {
        $this->RekapPOPerSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 4) {
        $this->RekapPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 5) {
        $this->RincianPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 6) {
        $this->RekapPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 7) {
        $this->RekapPembelianPerSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 8) {
        $this->RekapPembelianPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 9) {
        $this->RincianReturPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapReturPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 11) {
        $this->RekapReturPembelianPerSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapReturPembelianPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 13) {
        $this->RincianSelisihPembelianReturPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 14) {
        $this->RekapSelisihPembelianReturPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 15) {
        $this->RekapSelisihPembelianReturPerSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 16) {
        $this->RekapSelisihPembelianReturPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 17) {
        $this->PendinganPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 18) {
        $this->RincianPendinganPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 19) {
        $this->RekapPendinganPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 20) {
        $this->LaporanPOStatusBelumMax($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }	else if ($_GET['lro'] == 21) {
        $this->RekapPembelianPerBarangPerTanggal($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 22) {
        $this->LaporanPembelianPerSupplierPerBulanPerTahun($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 23) {
        $this->PendinganPOPerDokumentoSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 24) {
        $this->RincianPendinganPOPerBarangtoSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 25) {
        $this->RekapPendinganPOPerBarangtoSupplier($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 26) {
        $this->RincianPendinganPOPerBarangPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 27) {
        $this->RincianPOPerBarangPerDokumen($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 28) {
        $this->RekapFPPForecast($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else {
        echo $this->getCatalog('reportdoesnotexist');
      }
    }
	}
	//1
  public function RincianPOPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
        
    $sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate, a.headernote
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.recordstatus=5 and a.pono is not null
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
            ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'a')."
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian PO Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    $totalallqty=0;$totalallrp=0;
    if($price==1)
    {
    foreach ($dataReader as $row) 
		{
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No Bukti');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['pono']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['fullname']);
      $this->pdf->text(10, $this->pdf->gety() + 20, 'Keterangan');
      $this->pdf->text(30, $this->pdf->gety() + 20, ': ' . $row['headernote']);
      $this->pdf->text(150, $this->pdf->gety() + 10, 'Tgl Bukti');
      $this->pdf->text(180, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(150, $this->pdf->gety() + 15, 'T.O.P');
      $this->pdf->text(180, $this->pdf->gety() + 15, ': ' . $row['paydays'] . ' HARI');
      $sql1 = "select distinct *,(nominal+ppn) as netto
							from
							(select *,(select nominal*c.taxvalue/100 from tax c where c.taxid=zz.taxid) as ppn
							from 
							(select a.poheaderid,a.taxid,a.pono,g.productname,f.poqty,f.netprice,h.uomcode,f.itemtext,
							(select sum(b.poqty*b.netprice) 
							from podetail b 
							where b.poheaderid=a.poheaderid) as nominal
							from poheader a
							join addressbook d on d.addressbookid=a.addressbookid
							join paymentmethod e on e.paymentmethodid=a.paymentmethodid
							join podetail f on f.poheaderid = a.poheaderid
							join product g on g.productid = f.productid
							join unitofmeasure h on h.unitofmeasureid = f.unitofmeasureid
							where a.pono is not null and g.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%'  
							".getCompanyGroup($companyid,'a')." and a.poheaderid = " . $row['poheaderid'] . "
              ".getFieldTable($productcollectid,'g','productcollectid')."
							and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $total=0;$i=0;$totalqty=0;
      $this->pdf->sety($this->pdf->gety() + 23);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,50,20,15,30,30,38));
      $this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Harga','Jumlah','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','R','R','R');
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) 
			{
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['netprice'] * $row1['poqty']) / $per),
          $row1['itemtext']
        ));
        $totalqty += $row1['poqty'];
        $total += ($row1['netprice'] * $row1['poqty']) / $per;
      }
      $this->pdf->row(array(
        '',
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        '',
        'NOMINAL',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['ppn'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netto'] / $per)
      ));			
			$totalallqty += $row1['poqty'];
			$totalallrp += $row1['netto'] / $per;
    }
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->colalign = array('C','C','C','C','C','C');
    $this->pdf->setwidths(array(25,20,50,25,20,50));
    $this->pdf->row(array(
      '',
      'Total Qty ',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallqty),
      '',
      'Total Netto',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallrp)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //2
	public function RekapPOPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $sql        = "select distinct *,(nominal+ppn) as netto
                    from
                    (select *,(select nominal*c.taxvalue/100 from tax c where c.taxid=zz.taxid) as ppn
                    from 
                    (select a.poheaderid,a.taxid,a.pono,a.docdate,d.fullname,(select sum(b.poqty*b.netprice) 
                    from podetail b where b.poheaderid=a.poheaderid) as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    join podetail e on e.poheaderid = a.poheaderid
                    join product f on f.productid = e.productid
                    where a.recordstatus=5 and a.pono is not null and f.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'f','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap PO Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->setFont('Arial', 'B', 8);
    if($price==1)
    {
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
      25,
      25,
      45,
      30,
      25,
      25,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'No Bukti',
      'Tanggal',
      'Supplier',
      'Nominal',
      'PPN',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'C',
      'L',
      'R',
      'R',
      'R',
      'L'
    );
    $total                     = 0;
    $i                         = 0;
    $totalnetto                = 0;
    $totalppn                  = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['pono'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        $row['fullname'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['nominal'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['ppn'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['netto'] / $per)
      ));
      $total += $row['nominal'] / $per;
      $totalppn += $row['ppn'] / $per;
      $totalnetto += $row['netto'] / $per;
    }
    $this->pdf->row(array(
      '',
      '',
      'Grand Total',
      '',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnetto)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //3
	public function RekapPOPerSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0) { $com = ' and d.isextern = 1';} else { $com = 'and a.companyid = '.$companyid; }
    $sql          = "select fullname,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
                    from
                    (select *,(nominal+ppn) as netto
                    from
                    (select *,(select sum(nominal*c.taxvalue/100) from tax c where c.taxid=zz.taxid) as ppn
                    from 
                    (select a.poheaderid,a.taxid,a.addressbookid,a.pono,a.docdate,d.fullname,
										(select sum(b.poqty*b.netprice) 
                    from podetail b 
										join product e on e.productid=b.productid 
										where b.poheaderid=a.poheaderid and e.productname like '%" . $product . "%' 
                    ".getFieldTable($productcollectid,'e','productcollectid').") as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    where a.recordstatus=5 and a.pono is not null and d.fullname like '%" . $supplier . "%' 
                    {$com}
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz)xx
                    group by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $totalppn     = 0;
    $totalnominal = 0;
    $total        = 0;
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap PO Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->setFont('Arial', 'B', 8);
    if($price==1)
    {
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
      70,
      50,
      20,
      40
    ));
    $this->pdf->colheader = array(
      'No',
      'Nama Supplier',
      'Nominal',
      'PPN',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'L',
      'R',
      'R',
      'R',
      'L'
    );
    $i                         = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['fullname'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['nominal'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['ppn'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['netto'] / $per)
      ));
      $totalnominal += $row['nominal'] / $per;
      $totalppn += $row['ppn'] / $per;
      $total += $row['netto'] / $per;
    }
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
    ));
    $this->pdf->checkPageBreak(20);
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');   
    }
    $this->pdf->Output();
  }
  //4
	public function RekapPOPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');        
    $sql        = "select distinct g.materialgroupid, g.description
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join addressbook c on c.addressbookid = a.addressbookid
                    join paymentmethod d on d.paymentmethodid = a.paymentmethodid
                    join product e on e.productid = b.productid
                    join productplant f on f.productid = b.productid
                    join materialgroup g on g.materialgroupid = f.materialgroupid
                    where a.pono is not null ".getFieldTable($productcollectid,'e','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."
                    and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		$totalqty1     = 0;
		$totalppn1     = 0;
		$totalnominal1 = 0;
		$total1        = 0;
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap PO Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    if($price==1)
    {
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1         = "select distinct productname,uomcode,sum(poqty) as poqty,sum(netprice) as netprice,sum(nominal) as nominal,sum(ppn) as ppn,sum(nominal+ppn) as total	
								from (select distinct f.podetailid,g.productname,f.poqty,f.netprice,h.uomcode,f.poqty*f.netprice as nominal,(f.poqty*f.netprice)*j.taxvalue/100 as ppn
                from poheader a
                join addressbook d on d.addressbookid=a.addressbookid
                join paymentmethod e on e.paymentmethodid=a.paymentmethodid
                join podetail f on f.poheaderid = a.poheaderid
                join product g on g.productid = f.productid
                join unitofmeasure h on h.unitofmeasureid = f.unitofmeasureid
                join productplant i on i.productid = f.productid
                join tax j on j.taxid=a.taxid
                where a.recordstatus=5 and a.pono is not null and g.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' 
                ".getFieldTable($productcollectid,'g','productcollectid')."
                ".getCompanyGroup($companyid,'a')." and i.materialgroupid = " . $row['materialgroupid'] . "
                and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz group by productname";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $i          = 0;
      $totalqty     = 0;
      $totalppn     = 0;
      $totalnominal = 0;
      $total        = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        'QTY',
        'Nominal',
        'PPN',
        'Total'
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
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['nominal'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['ppn'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['total'] / $per)
        ));
        $totalqty += $row1['poqty'];
        $totalnominal += $row1['nominal'] / $per;
        $totalppn += $row1['ppn'] / $per;
        $total += $row1['total'] / $per;
      }
      $this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));			
			$totalqty1 += $totalqty;
			$totalnominal1 += $totalnominal;
			$totalppn1 += $totalppn;
			$total1 += $total;
      $this->pdf->checkPageBreak(20);
    }
		$this->pdf->sety($this->pdf->gety() + 5);
		$this->pdf->row(array(
			'',
			'Grand Total',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty1),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal1),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn1),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total1)
		));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //5
	public function RincianPembelianPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $totalinvoice = 0;
    $sql          = "select distinct a.invoiceapid,b.grheaderid,ifnull(a.invoiceno,0) as invno,a.invoicedate,d.paydays,b.grno,b.grdate,
						e.fullname,c.pono,c.docdate as podate,c.poheaderid,c.companyid
						from invoiceap a
						left join grheader b on b.grheaderid=a.grheaderid
						left join poheader c on c.poheaderid=b.poheaderid
						left join paymentmethod d on d.paymentmethodid=c.paymentmethodid
						left join addressbook e on e.addressbookid=c.addressbookid
            left join grdetail f on f.grheaderid = b.grheaderid
            join product g on g.productid = f.productid
						where a.recordstatus=3  ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'c')." and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by grdate,grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    $totalallqty = 0;
    $totalallrp  = 0;
    if($price==1)
    {
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 0, 'No Invoice');
      $this->pdf->text(30, $this->pdf->gety() + 0, ': ' . $row['invno']);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
      $this->pdf->text(10, $this->pdf->gety() + 10, 'T.O.P.');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['paydays'] . ' HARI');
      $this->pdf->text(80, $this->pdf->gety() + 0, 'No STTB');
      $this->pdf->text(100, $this->pdf->gety() + 0, ': ' . $row['grno']);
      $this->pdf->text(80, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(100, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(80, $this->pdf->gety() + 10, 'Supplier');
      $this->pdf->text(100, $this->pdf->gety() + 10, ': ' . $row['fullname']);
      $this->pdf->text(150, $this->pdf->gety() + 0, 'No PO');
      $this->pdf->text(165, $this->pdf->gety() + 0, ': ' . $row['pono']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(165, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['podate'])));
      $sql1        = "select distinct a.grdetailid,g.productname,a.qty,h.uomcode,c.netprice,(a.qty * c.netprice) as jumlah,
							a.itemtext,i.taxvalue,((a.qty * c.netprice)*(i.taxvalue/100)) as PPN,b.amount 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							where g.productname like '%" . $product . "%'  ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'d')." and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 12);
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
        50,
        20,
        15,
        30,
        30,
        38
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Harga',
        'Jumlah',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['jumlah'] / $per),
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
        $total += $row1['jumlah'] / $per;
        $totalallqty += $row1['qty'];
        $totalallrp += $row1['jumlah'] / $per;
      }
      $this->pdf->row(array(
        '',
        'KETERANGAN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        '',
        'NOMINAL',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['PPN'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total + ($row1['PPN'] / $per))
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'ADJUSMENT',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['amount'] / $per) - ($total + ($row1['PPN'] / $per)))
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'NILAI INVOICE',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['amount'] / $per))
      ));
      $totalinvoice += $row1['amount'] / $per;
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 10);
    }
    $this->pdf->setFont('Arial', 'B', 9);
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
      40,
      30,
      25,
      40,
      30
    ));
    $this->pdf->row(array(
      '',
      'Total Qty ',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallqty),
      '',
      'Total Netto',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallrp)
    ));
    $this->pdf->row(array(
      '',
      'Total Adjustment ',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalinvoice - $totalallrp),
      '',
      'Total Nilai Invoice',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalinvoice)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //6
	public function RekapPembelianPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    if($companyid > 0) {
      $joincom = ""; 
      $joincom1 = ""; 
      $wherecom = " and k.companyid = " . $companyid ; 
      $wherecom1 = "  zc.companyid = ".$companyid." ";
    }
    else {
      $joincom = " join company a9 on a9.companyid=e.companyid "; 
      $joincom1 = " join company a9 on a9.companyid=g.companyid "; 
      $wherecom = " and k.isgroup=1"; 
      $wherecom1 = "  zc.isgroup = 1";
    }
    $price = getUserObjectValues($menuobject='purchasing');
    $sql        = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext,companycode from
							(select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
							a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak, k.companycode
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
              left join company k on k.companyid = d.companyid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							group by invoiceno,grheaderid order by grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    if($price==1)
    {
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
      17,
      15,
      45,
      20,
      18,
      20,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'No Invoice',
      'No STTB',
      'Tanggal',
      'Supplier',
      'Nominal',
      'PPN',
      'Netto',
      'Keterangan'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'C',
      'C',
      'L',
      'R',
      'R',
      'R',
      'L'
    );
    $totalnetto1               = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['invoiceno'],
        $row['grno']. ($companyid==0 ? ' - '.$row['companycode'] : ''),
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['receiptdate'])),
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['jumlah'] / $per),
        Yii::app()->format->formatCurrency($row['PPN'] / $per),
        Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per),
        $row['itemtext']
      ));
      $totaljumlah1 += $row['jumlah'] / $per;
      $totaldisc1 += $row['PPN'] / $per;
      $totalnetto1 += ($row['jumlah'] + $row['PPN']) / $per;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->setwidths(array(
      30,
      50,
      50,
      50
    ));
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      'TOTAL',
      'NOMINAL : ' . Yii::app()->format->formatCurrency($totaljumlah1),
      'PPN : ' . Yii::app()->format->formatCurrency($totaldisc1),
      'NETTO : ' . Yii::app()->format->formatCurrency($totalnetto1)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
	public function RekapPembelianPerDokumen_old($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $sql        = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext from
							(select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
							a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							group by invoiceno,grheaderid order by grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->sety($this->pdf->gety() + 10);
    if($price==1)
    {
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
      17,
      15,
      45,
      20,
      18,
      20,
      25
    ));
    $this->pdf->colheader = array(
      'No',
      'No Invoice',
      'No STTB',
      'Tanggal',
      'Supplier',
      'Nominal',
      'PPN',
      'Netto',
      'Keterangan'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'C',
      'C',
      'L',
      'R',
      'R',
      'R',
      'L'
    );
    $totalnetto1               = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['invoiceno'],
        $row['grno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['receiptdate'])),
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['jumlah'] / $per),
        Yii::app()->format->formatCurrency($row['PPN'] / $per),
        Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per),
        $row['itemtext']
      ));
      $totaljumlah1 += $row['jumlah'] / $per;
      $totaldisc1 += $row['PPN'] / $per;
      $totalnetto1 += ($row['jumlah'] + $row['PPN']) / $per;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->setwidths(array(
      30,
      50,
      50,
      50
    ));
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      'TOTAL',
      'NOMINAL : ' . Yii::app()->format->formatCurrency($totaljumlah1),
      'PPN : ' . Yii::app()->format->formatCurrency($totaldisc1),
      'NETTO : ' . Yii::app()->format->formatCurrency($totalnetto1)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //7
	public function RekapPembelianPerSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
	  if ($companyid == 0) {$com = " and f.isextern = 1 "; $ext = " (Eksternal)";} else {$com = " and d.companyid = ".$companyid." "; $ext = "";}
    $price = getUserObjectValues($menuobject='purchasing');
    $sql        = "select fullname,sum(nom) as nominal,sum(pajak) as PPN from 
						(select distinct a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
						((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
						from grdetail a
						left join invoiceap b on b.grheaderid=a.grheaderid
						left join podetail c on c.podetailid=a.podetailid
						left join poheader d on d.poheaderid=b.poheaderid
						left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
						left join addressbook f on f.addressbookid=d.addressbookid
						left join product g on g.productid=a.productid
						left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
						left join tax i on i.taxid=d.taxid
						where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."
            and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'
						and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						group by fullname order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $totalnominal = 0;
    $totalppn     = 0;
    $totaljumlah  = 0;
    $i            = 0;
    $this->pdf->sety($this->pdf->gety() + 3);
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
      80,
      35,
      30,
      35
    ));
    $this->pdf->colheader = array(
      'No',
      'Nama Supplier',
      'Nominal',
      'PPN',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'R',
      'R',
      'R'
    );
    $this->pdf->setFont('Arial', '', 8);
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->row(array(
        $i,
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['nominal'] / $per),
        Yii::app()->format->formatCurrency($row['PPN'] / $per),
        Yii::app()->format->formatCurrency(($row['nominal'] + $row['PPN'])/ $per)
      ));
      $totalnominal += $row['nominal'] / $per;
      $totalppn += $row['PPN'] / $per;
      $totaljumlah += ($row['nominal'] + $row['PPN']) / $per;
    }
    $this->pdf->sety($this->pdf->gety() + 3);
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($totalnominal),
      Yii::app()->format->formatCurrency($totalppn),
      Yii::app()->format->formatCurrency($totaljumlah)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //8
	public function RekapPembelianPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    if($companyid==0){$com=' f.isgroup = 1';}else {$com = ' f.companyid = '.$companyid;}
    $price = getUserObjectValues($menuobject='purchasing');
    $totalqty1     = 0;
    $totalnominal1 = 0;
    $totalppn1     = 0;
    $sql           = "select distinct a.materialgroupid,a.description
				from materialgroup a
				join productplant b on b.materialgroupid = a.materialgroupid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join plant e on e.plantid = d.plantid
				join company f on f.companyid = e.companyid
				where {$com} and b.productid in
				(select distinct a.productid 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1         = "select g.productname,sum(a.qty) as qty,h.uomcode,c.netprice,sum(a.qty * c.netprice) as nominal,
							a.itemtext,sum((a.qty * c.netprice)*(i.taxvalue/100)) as PPN 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join productplant j on j.productid=a.productid and j.slocid=a.slocid
							where b.recordstatus = 3 and j.recordstatus = 1 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname order by productname";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty     = 0;
      $totalnetto   = 0;
      $totaldisc    = 0;
      $totalnominal = 0;
      $i            = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        60,
        20,
        15,
        28,
        25,
        33
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'QTY',
        'Satuan',
        'Nominal',
        'PPN',
        'Jumlah'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'R',
        'R',
        'R'
      );
      $this->pdf->setFont('Arial', '', 8);
      $totalnominal = 0;
      $totalqty     = 0;
      $totalppn     = 0;
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatCurrency($row1['qty']),
          $row1['uomcode'],
          Yii::app()->format->formatCurrency($row1['nominal'] / $per),
          Yii::app()->format->formatCurrency($row1['PPN'] / $per),
          Yii::app()->format->formatCurrency(($row1['nominal'] + $row1['PPN']) / $per)
        ));
        $totalqty += $row1['qty'] / $per;
        $totalppn += $row1['PPN'] / $per;
        $totalnominal += ($row1['nominal'] + $row1['PPN']) / $per;
      }
      $this->pdf->setFont('Arial', 'BI', 8);
      $this->pdf->row(array(
        '',
        'TOTAL ' . $row['description'],
        Yii::app()->format->formatCurrency($totalqty),
        '',
        '',
        Yii::app()->format->formatCurrency($totalppn),
        Yii::app()->format->formatCurrency($totalnominal)
      ));
      $totalqty1 += $totalqty;
      $totalnominal1 += $totalnominal;
      $totalppn1 += $totalppn;
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
      70,
      38,
      50,
      40
    ));
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->row(array(
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($totalqty1),
      Yii::app()->format->formatCurrency($totalppn1),
      Yii::app()->format->formatCurrency($totalnominal1)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //9
	public function RincianReturPembelianPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
        
    $sql  = "	select distinct *
							from 
							(select a.grreturid,i.notagrreturno as grreturno,g.fullname as supplier,i.docdate as grreturdate,h.paycode							
							from grretur a
							join grreturdetail c on c.grreturid=a.grreturid
							join product d on d.productid=c.productid
							join podetail e on e.podetailid=c.podetailid
							join poheader f on f.poheaderid=e.poheaderid
							join addressbook g on g.addressbookid=f.addressbookid
							join paymentmethod h on h.paymentmethodid=f.paymentmethodid
							join notagrretur i on i.grreturid=a.grreturid
							where i.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'d','productcollectid')."
              ".getCompanyGroup($companyid,'f')." and 
							i.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Retur Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    if($price==1)
    {
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['grreturno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(40, $this->pdf->gety() + 15, ': ' . $row['supplier']);
      $this->pdf->text(130, $this->pdf->gety() + 10, 'Tanggal');
      $this->pdf->text(160, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
      $this->pdf->text(130, $this->pdf->gety() + 15, 'T.O.P');
      $this->pdf->text(160, $this->pdf->gety() + 15, ': ' . $row['paycode'] . ' HARI');
      $sql1 = "select distinct *,(nominal+ppn) as netto
               from (select distinct b.productname,a.qty,c.netprice,(a.qty*c.netprice) as jumlah,a.itemnote,
               (
								select sum(b.netprice*a.qty) 
								from podetail b
								where b.podetailid=c.podetailid 
								and b.productid=c.productid
								) as nominal,
                (select nominal*i.taxvalue/100 from tax i where i.taxid=f.taxid) as ppn
							 from grreturdetail a
							 join product b on b.productid=a.productid
							 join podetail c on c.podetailid=a.podetailid
							 join poheader f on f.poheaderid = c.poheaderid
               ".getFieldTable($productcollectid,'b','productcollectid')."
							 join unitofmeasure d on d.unitofmeasureid=a.uomid
							 where a.grreturid = " . $row['grreturid'] . ")z";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
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
        70,
        10,
        20,
        30,
        50
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Harga',
        'Jumlah',
        'Keterangan'
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
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) 
			{
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          Yii::app()->format->formatCurrency($row1['netprice'] / $per),
          Yii::app()->format->formatCurrency($row1['jumlah'] / $per),
          $row1['itemnote']
        ));
        $totalqty += $row1['qty'];
      }
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row1['itemnote'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        'NOMINAL',
        Yii::app()->format->formatCurrency($row1['nominal'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->format->formatCurrency($row1['ppn'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->format->formatCurrency($row1['netto'] / $per)
      ));
      $this->pdf->checkPageBreak(20);
    }
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');    
    }
    $this->pdf->Output();
  }
  //10
	public function RekapReturPembelianPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $sql  = "select distinct *,(nominal+ppn) as netto
						from
						(select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select f.notagrreturno as grreturno,f.docdate as grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
              ".getCompanyGroup($companyid,'b')." and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						f.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $i       = 0;
    $nominal = 0;
    $ppn     = 0;
    $total   = 0;
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->setFont('Arial', 'B', 10);
    $this->pdf->colalign = array('C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(10,25,20,40,35,25,30));
    $this->pdf->colheader = array(
      'No',
      'Dokumen',
      'Tanggal',
      'Supplier',
      'Nominal',
      'PPN',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'L',
      'L',
      'R',
      'R',
      'R'
    );
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->SetFont('Arial', '', 8);
      $this->pdf->row(array(
        $i,
        $row['grreturno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])),
        $row['supplier'],
        Yii::app()->format->formatCurrency($row['nominal'] / $per),
        Yii::app()->format->formatCurrency($row['ppn'] / $per),
        Yii::app()->format->formatCurrency($row['netto'] / $per)
      ));
      $nominal += $row['nominal'] / $per;
      $ppn += $row['ppn'] / $per;
      $total += $row['netto'] / $per;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->row(array(
      '',
      'Grand Total',
      '',
      '',
      Yii::app()->format->formatCurrency($nominal),
      Yii::app()->format->formatCurrency($ppn),
      Yii::app()->format->formatCurrency($total)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //11
	public function RekapReturPembelianPerSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    if($companyid==0) { $com=' and c.isextern = 1';} else {$com = ' and b.companyid = '.$companyid;}
    $price = getUserObjectValues($menuobject='purchasing');
    $sql = "select supplier,taxid,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
            from (select distinct *,(nominal+ppn) as netto
						from (select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select f.notagrreturno as grreturno,f.docdate as grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
            {$com} and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						f.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z ) zz 
            order by grreturno) zzz group by supplier";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $i       = 0;
    $nominal = 0;
    $ppn     = 0;
    $total   = 0;
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->setFont('Arial', 'B', 10);
    $this->pdf->colalign = array(
      'C',
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->setwidths(array(
      10,
      60,
      40,
      30,
      40
    ));
    $this->pdf->colheader = array(
      'No',
      'Supplier',
      'Nominal',
      'PPN',
      'Total'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'R',
      'R',
      'R'
    );
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->SetFont('Arial', '', 9);
      $this->pdf->row(array(
        $i,
        $row['supplier'],
        Yii::app()->format->formatCurrency($row['nominal'] / $per),
        Yii::app()->format->formatCurrency($row['ppn'] / $per),
        Yii::app()->format->formatCurrency($row['netto'] / $per)
      ));
      $nominal += $row['nominal'] / $per;
      $nominal += $row['ppn'] / $per;
      $total += $row['netto'] / $per;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->SetFont('Arial', 'B', 10);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($nominal),
      Yii::app()->format->formatCurrency($ppn),
      Yii::app()->format->formatCurrency($total)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //12
	public function RekapReturPembelianPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    
    $sql        = "select distinct h.materialgroupid, h.description
                    from grreturdetail a
                    join product b on b.productid=a.productid
                    join podetail c on c.podetailid=a.podetailid
                    join poheader d on d.poheaderid=c.poheaderid
                    join unitofmeasure e on e.unitofmeasureid=a.uomid
                    join grretur f on f.grreturid=a.grreturid
                    join productplant g on g.productid=a.productid
                    join materialgroup h on h.materialgroupid=g.materialgroupid
                    join unitofmeasure i on i.unitofmeasureid=a.uomid
                    join notagrretur j on j.grreturid=f.grreturid
                    where j.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and j.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')." ".getCompanyGroup($companyid,'d')."
                    group by productname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    if($price==1)
    {
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1        = "select *,(nominal+ppn) as netto
                      from
                      (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
                      from
                      (select distinct b.productname,a.qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
                      from grreturdetail a
                      join product b on b.productid=a.productid
                      join podetail c on c.podetailid=a.podetailid
                      join poheader d on d.poheaderid=c.poheaderid
                      join unitofmeasure e on e.unitofmeasureid=a.uomid
                      join grretur f on f.grreturid=a.grreturid
                      join productplant g on g.productid=a.productid and g.slocid = a.slocid and g.unitofissue = c.unitofmeasureid
                      join materialgroup h on h.materialgroupid=g.materialgroupid
                      join unitofmeasure i on i.unitofmeasureid=a.uomid
                      join notagrretur j on j.grreturid=f.grreturid
                      where j.recordstatus = 3 and  b.productname like '%" . $product . "%' and j.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                      and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')." ".getCompanyGroup($companyid,'d')." and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $nominal     = 0;
      $ppn         = 0;
      $total       = 0;
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
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        60,
        20,
        15,
        28,
        25,
        33
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Harga',
        'PPN',
        'Jumlah'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          Yii::app()->format->formatCurrency($row1['nominal'] / $per),
          Yii::app()->format->formatCurrency($row1['ppn'] / $per),
          Yii::app()->format->formatCurrency(($row1['netto'] + $row1['ppn']) / $per)
        ));
        $totalqty += $row1['qty'];
        $ppn += $row1['ppn'] / $per;
        $nominal += $row1['nominal'] / $per;
        $total += ($row1['netto'] + $row1['ppn']) / $per;
      }
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->row(array(
        '',
        'TOTAL ' . $row['description'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        Yii::app()->format->formatCurrency($nominal),
        Yii::app()->format->formatCurrency($ppn),
        Yii::app()->format->formatCurrency($total)
      ));
      $this->pdf->checkPageBreak(20);
    }
    }
    else
    {
        
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //13
	public function RincianSelisihPembelianReturPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $totalinvoice = 0;
    $sql          = "select distinct a.invoiceapid,b.grheaderid,ifnull(a.invoiceno,0) as invno,a.invoicedate,d.paydays,b.grno,b.grdate,
						e.fullname,c.pono,c.docdate as podate,c.poheaderid,c.companyid
						from invoiceap a
						left join grheader b on b.grheaderid=a.grheaderid
						left join poheader c on c.poheaderid=b.poheaderid
						left join paymentmethod d on d.paymentmethodid=c.paymentmethodid
						left join addressbook e on e.addressbookid=c.addressbookid
            left join podetail f on f.poheaderid = c.poheaderid
            join product g on g.productid = f.productid
						where a.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'c')." and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by receiptdate,grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pembelian - Retur Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    if($price==1)
    {
    $totalallqty = 0;
    $totalallrp  = 0;
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 0, 'No Invoice');
      $this->pdf->text(30, $this->pdf->gety() + 0, ': ' . $row['invno']);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
      $this->pdf->text(10, $this->pdf->gety() + 10, 'T.O.P.');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['paydays'] . ' HARI');
      $this->pdf->text(80, $this->pdf->gety() + 0, 'No STTB');
      $this->pdf->text(100, $this->pdf->gety() + 0, ': ' . $row['grno']);
      $this->pdf->text(80, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(100, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(80, $this->pdf->gety() + 10, 'Supplier');
      $this->pdf->text(100, $this->pdf->gety() + 10, ': ' . $row['fullname']);
      $this->pdf->text(150, $this->pdf->gety() + 0, 'No PO');
      $this->pdf->text(165, $this->pdf->gety() + 0, ': ' . $row['pono']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(165, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['podate'])));
      $sql1        = "select distinct a.grdetailid,g.productname,a.qty,h.uomcode,c.netprice,(a.qty * c.netprice) as jumlah,
							a.itemtext,i.taxvalue,((a.qty * c.netprice)*(i.taxvalue/100)) as PPN,b.amount 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							where b.grheaderid = " . $row['grheaderid']." ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $total       = 0;
      $i           = 0;
      $totalqty    = 0;
      $this->pdf->sety($this->pdf->gety() + 12);
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
        50,
        20,
        15,
        30,
        30,
        38
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Satuan',
        'Harga',
        'Jumlah',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
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
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qty']),
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['jumlah'] / $per),
          $row1['itemtext']
        ));
        $totalqty += $row1['qty'];
        $total += $row1['jumlah'] / $per;
        $totalallqty += $row1['qty'];
        $totalallrp += $row1['jumlah'] / $per;
      }
      $this->pdf->row(array(
        '',
        'KETERANGAN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        '',
        'NOMINAL',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['PPN'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total + ($row1['PPN'] / $per))
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'ADJUSMENT',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['amount'] / $per) - ($total + ($row1['PPN'] / $per)))
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        'NILAI INVOICE',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['amount'] / $per))
      ));
      $totalinvoice += $row1['amount'] / $per;
      $this->pdf->checkPageBreak(70);
      $this->pdf->sety($this->pdf->gety() + 10);
      
    }
    $sql2  = "	select distinct *
							from 
							(select a.grreturid,a.grreturno,g.fullname as supplier,a.grreturdate,h.paycode							
							from grretur a
							join grreturdetail c on c.grreturid=a.grreturid
							join product d on d.productid=c.productid
							join podetail e on e.podetailid=c.podetailid
							join poheader f on f.poheaderid=e.poheaderid
							join addressbook g on g.addressbookid=f.addressbookid
							join paymentmethod h on h.paymentmethodid=f.paymentmethodid
							join notagrretur i on i.grreturid=a.grreturid
							where i.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'d','productcollectid')." ".getCompanyGroup($companyid,'f')." and a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z";
    $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
		
    foreach ($dataReader2 as $row2) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pembelian - Retur Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    $this->pdf->sety($this->pdf->gety() + 5);
    foreach ($dataReader2 as $row2) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Dokumen');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row2['grreturno']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(40, $this->pdf->gety() + 15, ': ' . $row2['supplier']);
      $this->pdf->text(130, $this->pdf->gety() + 10, 'Tanggal');
      $this->pdf->text(160, $this->pdf->gety() + 10, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row2['grreturdate'])));
      $this->pdf->text(130, $this->pdf->gety() + 15, 'T.O.P');
      $this->pdf->text(160, $this->pdf->gety() + 15, ': ' . $row2['paycode'] . ' HARI');
      $sql3 = "select distinct *,(nominal+ppn) as netto
               from (select distinct b.productname,a.qty,c.netprice,(a.qty*c.netprice) as jumlah,a.itemnote,
               (
								select sum(bx.netprice*a.qty) 
								from podetail bx
								where bx.podetailid=c.podetailid 
								and bx.productid=c.productid
								) as nominal,
                (select nominal*i.taxvalue/100 from tax i where i.taxid=f.taxid) as ppn
							 from grreturdetail a
							 join product b on b.productid=a.productid
							 join podetail c on c.podetailid=a.podetailid
							 join poheader f on f.poheaderid = c.poheaderid
							 join unitofmeasure d on d.unitofmeasureid=a.uomid
               ".getFieldTable($productcollectid,'b','productcollectid')."
							 where a.grreturid = " . $row2['grreturid'] . ")z";
      $dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
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
        70,
        10,
        20,
        30,
        50
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Harga',
        'Jumlah',
        'Keterangan'
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
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader3 as $row3) 
			{
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row3['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row3['qty']),
          Yii::app()->format->formatCurrency($row3['netprice'] / $per),
          Yii::app()->format->formatCurrency($row3['jumlah'] / $per),
          $row3['itemnote']
        ));
        $totalqty += $row3['qty'];
      }
      $this->pdf->row(array(
        '',
        'Keterangan : ' . $row3['itemnote'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        '',
        'NOMINAL',
        Yii::app()->format->formatCurrency($row3['nominal'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->format->formatCurrency($row3['ppn'] / $per)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->format->formatCurrency($row3['netto'] / $per)
      ));
      $this->pdf->checkPageBreak(50);
    }
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //14
	public function RekapSelisihPembelianReturPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    $sql        = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext from
							(select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
							a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							group by invoiceno,grheaderid order by grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap (Pembelian-Retur) Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $this->pdf->sety($this->pdf->gety() + 10);
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
      20,
      15,
      45,
      22,
      20,
      22,
      20
    ));
    $this->pdf->colheader = array(
      'No',
      'No Invoice',
      'No STTB',
      'Tanggal',
      'Supplier',
      'Nominal',
      'PPN',
      'Netto',
      'Keterangan'
    );
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array(
      'L',
      'L',
      'C',
      'C',
      'L',
      'R',
      'R',
      'R',
      'L'
    );
    $i                         = 0;
    $totalnominal              = 0;
    $totalppn                  = 0;
    $totalnetto                = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,
        $row['invoiceno'],
        $row['grno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['receiptdate'])),
        $row['fullname'],
        Yii::app()->format->formatCurrency($row['jumlah'] / $per),
        Yii::app()->format->formatCurrency($row['PPN'] / $per),
        Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per),
        $row['itemtext']
      ));
      $totalnominal += $row['jumlah'] / $per;
      $totalppn += $row['PPN'] / $per;
      $totalnetto += ($row['jumlah'] + $row['PPN']) / $per;
    }
    $sql1  = "select distinct *,(nominal+ppn) as netto
						from
						(select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select a.grreturno,a.grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
    foreach ($dataReader1 as $row1) {
      $i += 1;
      $this->pdf->SetFont('Arial', '', 7);
      $this->pdf->row(array(
        $i,'-',
        $row1['grreturno'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row1['grreturdate'])),
        $row1['supplier'],
        Yii::app()->format->formatCurrency(-$row1['nominal'] / $per),
        Yii::app()->format->formatCurrency(-$row1['ppn'] / $per),
        Yii::app()->format->formatCurrency(-$row1['netto'] / $per)
      ));
      $totalnominal -= $row1['nominal'] / $per;
      $totalppn -= $row1['ppn'] / $per;
      $totalnetto -= $row1['netto'] / $per;
    }
    $this->pdf->checkPageBreak(10);
    $this->pdf->SetFont('Arial', 'B', 8);
    $this->pdf->row(array(
      '',
      '',
      '',
      '',
      'GRAND TOTAL',
      Yii::app()->format->formatCurrency($totalnominal),
      Yii::app()->format->formatCurrency($totalppn),
      Yii::app()->format->formatCurrency($totalnetto)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //15
	public function RekapSelisihPembelianReturPerSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0){$com = ' and a.isextern = 1'; $company = ' and z.isgroup = 1';}else { $com = ''; $company = ' and z.companyid = '.$companyid;}
    $sql          = "select *
                    from (select fullname,nominal-nominalretur as nom, ppn-ppnretur as pajak, netto-nettoretur as total
                    from (select *,nominal+ppn as netto,nominalretur+ppnretur as nettoretur
                    from (select a.fullname,
                    ifnull((select sum(b.qty * e.netprice)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominal,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid 
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppn,
                    ifnull((select sum(b.qty * e.netprice)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominalretur,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppnretur
                    from addressbook a
                    where a.isvendor=1 {$com}
                    and a.fullname like '%".$supplier."%') z) zz) zzz
                    where nom <> 0 or pajak <> 0 or total <> 0
                    order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $totalppn     = 0;
    $totalnominal = 0;
    $total        = 0;
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap (Pembelian-Retur) Per Supplier';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $this->pdf->sety($this->pdf->gety() + 10);
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
      70,
      40,
      25,
      40
    ));
    $this->pdf->colheader = array(
      'No',
      'Nama Supplier',
      'Nominal',
      'PPN',
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
      'L'
    );
    $i                         = 0;
    foreach ($dataReader as $row) {
      $i += 1;
      $this->pdf->setFont('Arial', '', 8);
      $this->pdf->row(array(
        $i,
        $row['fullname'],
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['nom'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['pajak'] / $per),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row['total'] / $per)
      ));
      $totalnominal += $row['nom'] / $per;
      $totalppn += $row['pajak'] / $per;
      $total += $row['total'] / $per;
    }
    $this->pdf->setFont('Arial', 'B', 8);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
    ));
    $this->pdf->checkPageBreak(20);
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //16
	public function RekapSelisihPembelianReturPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0){$com = ' f.isgroup = 1';}else {$com = ' f.companyid = '.$companyid;}
    
    $sql   = "select distinct materialgroupid, description
              from (select distinct a.materialgroupid,a.description
              from materialgroup a
              join productplant b on b.materialgroupid = a.materialgroupid
              join product c on c.productid = b.productid
              join sloc d on d.slocid = b.slocid
              join plant e on e.plantid = d.plantid
              join company f on f.companyid = e.companyid
              where {$com} and b.productid in
              (select distinct a.productid 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
            union
              select distinct h.materialgroupid, h.description
              from grreturdetail a
              join product b on b.productid=a.productid
              join podetail c on c.podetailid=a.podetailid
              join poheader d on d.poheaderid=c.poheaderid
              join unitofmeasure e on e.unitofmeasureid=a.uomid
              join grretur f on f.grreturid=a.grreturid
              join productplant g on g.productid=a.productid
              join materialgroup h on h.materialgroupid=g.materialgroupid
              join unitofmeasure i on i.unitofmeasureid=a.uomid
              join notagrretur j on j.grreturid=f.grreturid
              where j.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')."
              ".getCompanyGroup($companyid,'d').") z";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap (Pembelian-Retur) Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $this->pdf->sety($this->pdf->gety() + 5);
    $i = 0;
    $totalqty1     = 0;
    $totalppn1     = 0;
    $totalnominal1 = 0;
    $total1        = 0;
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1 = "select distinct productname, sum(qty) as totalqty, uomcode, sum(nominal) as nom, sum(ppn) as pajak, sum(nominal+ppn) as jumlah
              from (select g.productname,sum(a.qty) as qty,h.uomcode,sum(a.qty * c.netprice) as nominal,sum((a.qty * c.netprice)*(i.taxvalue/100)) as ppn 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join productplant j on j.productid=a.productid and j.slocid=a.slocid
							where b.recordstatus = 3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
							and j.recordstatus = 1
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname
            union
              select distinct productname,-qty,uomcode,-nominal,-ppn
              from
              (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
              from
              (select b.productname,(a.qty) as qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
              from grreturdetail a
              join product b on b.productid=a.productid
              join podetail c on c.podetailid=a.podetailid
              join poheader d on d.poheaderid=c.poheaderid
              join unitofmeasure e on e.unitofmeasureid=a.uomid
              join grretur f on f.grreturid=a.grreturid
              join productplant g on g.productid=a.productid
              join materialgroup h on h.materialgroupid=g.materialgroupid
              join unitofmeasure i on i.unitofmeasureid=a.uomid
              join notagrretur j on j.grreturid=f.grreturid
              where j.recordstatus = 3 and g.recordstatus = 1 and b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = " . $companyid . " and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz
              ) x group by productname";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty     = 0;
      $totalppn     = 0;
      $totalnominal = 0;
      $total        = 0;
      $this->pdf->sety($this->pdf->gety() + 15);
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
        'QTY',
        'Nominal',
        'PPN',
        'Total'
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
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['totalqty']),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['nom'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['pajak'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['jumlah'] / $per)
        ));
        $totalqty += $row1['totalqty'];
        $totalnominal += $row1['nom'] / $per;
        $totalppn += $row1['pajak'] / $per;
        $total += $row1['jumlah'] / $per;
      }
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->row(array(
        '',
        'TOTAL',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total)
      ));
      $totalqty1 += $totalqty;
      $totalnominal1 += $totalnominal;
      $totalppn1 += $totalppn;
      $total1 += $total;
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->sety($this->pdf->gety()+5);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty1),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal1),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn1),
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $total1)
    ));
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
	//17
	public function PendinganPOPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    
		$sql = "select distinct poheaderid, pono, fullname, paydays, docdate
		from (select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate, b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.pono is not null ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'a')." and a.recordstatus=5
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono) z
						where poqty > grqty
		";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
		$this->pdf->title    = 'Pendingan PO Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    $this->pdf->sety($this->pdf->gety() + 5);
		
    $totalallqty=0;$totalnetto1=0;
		
		foreach ($dataReader as $row) 
		{
			$this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'No Bukti');
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['pono']);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['fullname']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tgl Bukti');
      $this->pdf->text(180, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(150, $this->pdf->gety() + 10, 'T.O.P');
      $this->pdf->text(180, $this->pdf->gety() + 10, ': ' . $row['paydays'] . ' HARI');
			
			$sql1 = "select *,poqty-grqty as sisa,(poqty-grqty)*netprice as jumlah,(taxvalue/100)*((poqty-grqty)*netprice) as ppn
			from (select b.productname,a.poqty,a.qtyres,c.uomcode,a.netprice,a.itemtext,e.taxvalue,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
							from podetail a
							join product b on b.productid=a.productid
							join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
							join poheader d on d.poheaderid=a.poheaderid
							join tax e on e.taxid=d.taxid
							where b.productname like '%" . $product . "%' 
              ".getFieldTable($productcollectid,'b','productcollectid')."
							and a.poheaderid = " . $row['poheaderid'] . ") z
			where poqty > grqty
			";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$totalnominal=0;$i=0;$totalqty=0;$totalppn=0;$totalnetto=0;$totalgrqty=0;$totalsisa=0;
			
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,50,20,20,20,12,20,22,20));
      $this->pdf->colheader = array('No','Nama Barang','Qty','Qty GR','Sisa','Satuan','Harga','Jumlah','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','R','R','C','R','R','R');
      $this->pdf->setFont('Arial', '', 8);
			
      foreach ($dataReader1 as $row1)
			{
				$i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['grqty']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['sisa']),
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['jumlah'])/$per),
          $row1['itemtext']
        ));
        $totalqty += $row1['poqty'];
				$totalgrqty += $row1['grqty'];
				$totalsisa += $row1['sisa'];
        $totalnominal += ($row1['jumlah']) / $per;
				$totalppn += $row1['ppn'] / $per;        
        $totalnetto += ($row1['jumlah'] + $row1['ppn']) / $per;
				
				
			}
			
			$this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgrqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalsisa),
        '',
        'NOMINAL',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        '',
        'PPN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        '',
        '',
        'NETTO',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnetto)
      ));
			$this->pdf->sety($this->pdf->gety() + 8);
			$this->pdf->checkPageBreak(30);
			
			$totalallqty += ($totalqty - $totalgrqty);
			$totalnetto1 += $totalnetto;
    }
		
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->colalign = array('C','C','C','C','C','C');
    $this->pdf->setwidths(array(25,20,50,25,20,50));
    $this->pdf->row(array(
      '',
      'Total Qty ',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallqty),
      '',
      'Total Netto',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnetto1)
    ));		
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
		$this->pdf->Output();
	}
	//18
	public function RincianPendinganPOPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				ifnull((select sum(f.qty) 
				from grdetail f 
				join grheader h on h.grheaderid=f.grheaderid 
				where h.recordstatus = 3 and f.podetailid=b.podetailid),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pendingan PO Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $this->pdf->SetFont('Arial', '', 9);
      $sql1           = "select distinct productname,productid from (
				select distinct c.productname,c.productid,b.poqty,
				ifnull((select sum(f.qty) 
				from grdetail f 
				join grheader h on h.grheaderid=f.grheaderid 
				where h.recordstatus = 3 and f.podetailid=b.podetailid),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5 
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%' and d.slocid = " . $row['slocid'] . "
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty       = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $this->pdf->checkPageBreak(30);
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->text(10, $this->pdf->gety() + 15, 'Nama Barang ');
        $this->pdf->text(33, $this->pdf->gety() + 15, ': ' . $row1['productname']);
        $sql2        = "select *
				from (select pono, docdate, uomcode, poqty, grqty, (poqty-grqty) as selisih
						from (select b.pono, b.docdate, d.uomcode, a.poqty, 
						ifnull((select sum(c.qty) 
						from grdetail c 
						join grheader h on h.grheaderid=c.grheaderid 
						where h.recordstatus = 3 and c.podetailid=a.podetailid),0) as grqty
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and a.productid = " . $row1['productid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty) zz";
        $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
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
          40,
          25,
          15,
          35,
          35,
          35
        ));
        $this->pdf->colheader = array(
          'No',
          'No PO',
          'Tgl PO',
          'Satuan',
          'Qty PO',
          'Qty GR',
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
          $i += 1;
          $this->pdf->setFont('Arial', '', 8);
          $this->pdf->row(array(
            $i,
            $row2['pono'],
            $row2['docdate'],
            $row2['uomcode'],
            Yii::app()->format->formatNumber($row2['poqty']),
            Yii::app()->format->formatNumber($row2['grqty']),
            Yii::app()->format->formatNumber($row2['selisih'])
          ));
          $jumlahqty += $row2['poqty'];
          $jumlahqtyoutput += $row2['grqty'];
          $jumlahselisih += $row2['selisih'];
        }
        $this->pdf->setFont('Arial', 'BI', 8);
        $this->pdf->setwidths(array(
          10,
          80,
          35,
          35,
          35
        ));
        $this->pdf->coldetailalign = array(
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->row(array(
          '',
          'JUMLAH ' . $row1['productname'],
          Yii::app()->format->formatNumber($jumlahqty),
          Yii::app()->format->formatNumber($jumlahqtyoutput),
          Yii::app()->format->formatNumber($jumlahselisih)
        ));
        $totalqty += $jumlahqty;
        $totalqtyoutput += $jumlahqtyoutput;
        $totalselisih += $jumlahselisih;
      }
      $this->pdf->setFont('Arial', 'BI', 9);
      $this->pdf->row(array(
        '',
        'TOTAL GUDANG ' . $row['description'],
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
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));
    $this->pdf->Output();
  }
  //19
	public function RekapPendinganPOPerBarang($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pendingan PO Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1           = "select *
				from (select distinct productname, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
						from (select e.productname, d.uomcode, a.poqty, 
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5 
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty
						group by productname) zz";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty       = 0;
      $i              = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->sety($this->pdf->gety() + 12);
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
        70,
        25,
        30,
        30,
        30
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Satuan',
        'Qty PO',
        'Qty GR',
        'Selisih'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
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
          Yii::app()->format->formatNumber($row1['poqty']),
          Yii::app()->format->formatNumber($row1['grqty']),
          Yii::app()->format->formatNumber($row1['selisih'])
        ));
        $totalqty += $row1['poqty'];
        $totalqtyoutput += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->pdf->setFont('Arial', 'BI', 9);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        95,
        30,
        30,
        30
      ));
      $this->pdf->coldetailalign = array(
        'C',
        'R',
        'R',
        'R',
        'R'
      );
      $this->pdf->row(array(
        '',
        'TOTAL GUDANG ' . $row['description'],
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtyoutput),
        Yii::app()->format->formatNumber($totalselisih)
      ));
      $subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'BI', 11);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL ',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));
    $this->pdf->Output();
  }
  //20
  public function LaporanPOStatusBelumMax($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql = "SELECT a.poheaderid,c.companycode, a.pono, a.docdate, b.fullname, d.taxcode, a.shipto, a.billto, a.statusname, e.paycode
            FROM poheader a 
            LEFT JOIN addressbook b ON b.addressbookid = a.addressbookid
            LEFT JOIN company c ON c.companyid = a.companyid
            LEFT JOIN tax d ON d.taxid = a.taxid
            LEFT JOIN paymentmethod e ON e.paymentmethodid = a.paymentmethodid
            WHERE a.recordstatus BETWEEN ('1') AND ('4')
            AND docdate BETWEEN ('".date(Yii::app()->params['datetodb'], strtotime($startdate))."') 
            AND ('".date(Yii::app()->params['datetodb'], strtotime($enddate))."')
            ".getCompanyGroup($companyid,'a')."
            AND b.fullname LIKE '%".$supplier."%'
            AND b.isvendor=1";
    
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
    {
      $this->pdf->companyid = $companyid;
    }
      
    $this->pdf->title    = 'Laporan PO Status Belum Max';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('L');
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->SetFont('Arial','',9);
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
      15,
      20,
      25,
      25,
      100,
      20,
      20,
      40
    ));
    $this->pdf->colheader = array(
      'ID',
      'Perusahaan',
      'NO PO',
      'Tanggal PO',
      'Supplier',
      'Pajak',
      'Tempo',
      'Status'
    );
    $this->pdf->RowHeader();        
    $i=1;
    $this->pdf->coldetailalign = array(
      'R',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L',
      'L'
    );
    foreach($dataReader as $row) {
      $this->pdf->row(array(
        $row['poheaderid'],
        $row['companycode'],
        $row['pono'],
        date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
        $row['fullname'],
        $row['taxcode'],
        $row['paycode'],
        $row['statusname']
      ));
      $i++;
    }
    $this->pdf->Output();
  }
	//21
	public function RekapPembelianPerBarangPerTanggal($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    
		$sql        = "select distinct g.productid,g.productname
								from grdetail a
								join grheader b on b.grheaderid=a.grheaderid
								join podetail c on c.podetailid=a.podetailid
								join poheader d on d.poheaderid=c.poheaderid and d.poheaderid=b.poheaderid
								join company e on e.companyid=d.companyid
								join addressbook f on f.addressbookid=d.addressbookid
								join product g on g.productid=a.productid
								where b.recordstatus = 3 ".getFieldTable($productcollectid,'g','productcollectid')."
                ".getCompanyGroup($companyid,'d')." and f.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%' and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' AND '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								order by productname ";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Barang Per Tanggal';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    if($price==1)
    {
    foreach ($dataReader as $row) 
		{
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 3, 'NAMA BARANG :');
      $this->pdf->text(40, $this->pdf->gety() + 3, $row['productname']);
      $sql1        = "select a.delvdate, a.netprice 
                    from podetail a
                    join poheader b on a.poheaderid=b.poheaderid
                    WHERE delvdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' AND '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getCompanyGroup($companyid,'b')." and productid=".$row['productid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty    = 0;
      $i           = 0;
      $this->pdf->sety($this->pdf->gety() + 5);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        40,
        40
      ));
      $this->pdf->colheader = array(
        'No',
        'Tanggal',
        'Harga'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'C',
        'C',
        'C');
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['delvdate'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice']),
          
        ));
        //$totalqty += $row1['qty'];
      }
      /*
      $this->pdf->row(array(
        '',
        'Total -> ' . $row['description'],
        '',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty)
      ));
      */
      $this->pdf->checkPageBreak(20);
      $this->pdf->sety($this->pdf->gety() + 8);
    }
    }
    else
    {
        $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
    }
    $this->pdf->Output();
  }
  //22
  public function LaporanPembelianPerSupplierPerBulanPerTahun($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0){$com= ' and f.isextern = 1'; $supp = ' and z.isextern = 1'; }else{$com = ' and d.companyid = '.$companyid; $supp = '';};
  
		$sql = "select * from
					(select z.fullname,
					(select sum(pajak+nom) from 
					(select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
						((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
						from grdetail a
						left join invoiceap b on b.grheaderid=a.grheaderid
						left join podetail c on c.podetailid=a.podetailid
						left join poheader d on d.poheaderid=b.poheaderid
						left join addressbook f on f.addressbookid=d.addressbookid
						left join product g on g.productid=a.productid
						left join tax i on i.taxid=d.taxid
						where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')." and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=1 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as januari,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=2 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as februari,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=3 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as maret,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=4 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as april,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=5 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as mei,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=6 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as juni,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=7 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as juli,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=8 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as agustus,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=9 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as september,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=10 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as oktober,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=11 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as november,
          (select sum(pajak+nom) from 

          (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=12 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as desember,
          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as jumlah
					from addressbook z 
					where z.recordstatus=1 {$supp} and z.isvendor=1 and z.fullname is not null order by fullname asc) zz
					where zz.jumlah <> 0";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			$i=0;$totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Laporan Pembelian Per Supplier Per Bulan PerTahun';
			$this->pdf->subtitle='Per Tahun '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate));
			$this->pdf->AddPage('P',array(400,170));
			
            if($price==1)
            {
			$this->pdf->setFont('Arial','B',8);
            $this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,40,25,25,25,25,25,25,25,25,25,25,25,25,30));
			$this->pdf->colheader = array('No','Supplier','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember','Total');
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
					Yii::app()->format->formatCurrency($row['november']/$per),
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
				$totalnopember += $row['november']/$per;
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
        }
        else
        {
            $this->pdf->text(10, $this->pdf->gety() + 10, 'Anda Tidak Berhak Melihat Laporan ini');
        }
      $this->pdf->Output();
	}
	//23
	public function PendinganPOPerDokumentoSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
    $price = getUserObjectValues($menuobject='purchasing');
    
		$sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate,c.fullname as suppliername,
        (select companyname from company x where x.companyid = a.companyid) as companyname
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.pono is not null
						and a.recordstatus=5
            ".getFieldTable($productcollectid,'e','productcollectid')."
						and b.poqty > b.qtyres
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
		$this->pdf->title    = 'Rincian Pendingan PO Per Dokumen ke Supplier : '.$supplier;
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
    if($supplier=='' || empty($supplier))
    {
       $this->pdf->text(10, $this->pdf->gety() + 10, 'Harap Diisi Supplier');
    }
    else
    {   
    $this->pdf->sety($this->pdf->gety() + 5);
		
    $totalallqty=0;$totalnetto1=0;
		
		foreach ($dataReader as $row) 
		{
			$this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10,$this->pdf->getY(),'Supplier :');
      $this->pdf->text(10, $this->pdf->gety() + 5, 'No Bukti');
      $this->pdf->text(30, $this->pdf->gety(), ': ' . $row['suppliername']);
      $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['pono']);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Perusahaan ');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['companyname']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tgl Bukti');
      $this->pdf->text(180, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(150, $this->pdf->gety() + 10, 'T.O.P');
      $this->pdf->text(180, $this->pdf->gety() + 10, ': ' . $row['paydays'] . ' HARI');
			
			$sql1 = "select productname,poqty,grqty,poqty-grqty as sisa,uomcode,netprice,(poqty-grqty)*netprice as jumlah,itemtext,(taxvalue/100)*((poqty-grqty)*netprice) as ppn
			from (select b.productname,a.poqty,c.uomcode,a.netprice,a.itemtext,e.taxvalue,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
							from podetail a
							join product b on b.productid=a.productid
							join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
							join poheader d on d.poheaderid=a.poheaderid
							join tax e on e.taxid=d.taxid
							where b.productname like '%" . $product . "%' 
              ".getFieldTable($productcollectid,'b','productcollectid')."
							and a.poheaderid = " . $row['poheaderid'] . ") z
			where poqty > grqty
			";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$totalnominal=0;$i=0;$totalqty=0;$totalppn=0;$totalnetto=0;$totalgrqty=0;$totalsisa=0;
			
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      if($price==1){
          $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
          $this->pdf->setwidths(array(10,50,20,20,20,12,20,22,20));
          $this->pdf->colheader = array('No','Nama Barang','Qty','Qty GR','Sisa','Satuan','Harga','Jumlah','Keterangan');
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array('L','L','R','R','R','C','R','R','R');
      } else {
          $this->pdf->colalign = array('C','C','C','C','C','C','C');
          $this->pdf->setwidths(array(10,80,20,20,20,12,20));
          $this->pdf->colheader = array('No','Nama Barang','Qty','Qty GR','Sisa','Satuan','Keterangan');
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array('L','L','R','R','R','C','R');
      }
      $this->pdf->setFont('Arial', '', 8);
			
      foreach ($dataReader1 as $row1)
			{
				$i += 1;
        if($price==1){
            $this->pdf->row(array(
              $i,
              $row1['productname'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['grqty']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['sisa']),
              $row1['uomcode'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['jumlah'])/$per),
              $row1['itemtext']
            ));
        } else {
            $this->pdf->row(array(
              $i,
              $row1['productname'],
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['grqty']),
              Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['sisa']),
              $row1['uomcode'],
              $row1['itemtext']
            ));
        }
        $totalqty += $row1['poqty'];
				$totalgrqty += $row1['grqty'];
				$totalsisa += $row1['sisa'];
        $totalnominal += ($row1['jumlah']) / $per;
				$totalppn += $row1['ppn'] / $per;        
        $totalnetto += ($row1['jumlah'] + $row1['ppn']) / $per;
			}
        if($price==1){
            $this->pdf->row(array(
            '',
            'Total',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgrqty),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalsisa),
            '',
            'NOMINAL',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnominal)
            ));
            $this->pdf->row(array(
            '',
            '',
            '',
            '',
            '',
            '',
            'PPN',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn)
            ));
            $this->pdf->row(array(
            '',
            '',
            '',
            '',
            '',
            '',
            'NETTO',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnetto)
            ));
        }else {
            $this->pdf->row(array(
            '',
            'Total',
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgrqty),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalsisa),
            ''
            ));
            $this->pdf->row(array(
            '',
            '',
            '',
            '',
            ''
            ));
            $this->pdf->row(array(
            '',
            '',
            '',
            '',
            '',
            '',
            ));
        }
			$this->pdf->sety($this->pdf->gety() + 8);
			$this->pdf->checkPageBreak(30);
			
			$totalallqty += ($totalqty - $totalgrqty);
			$totalnetto1 += $totalnetto;
    }
		
    $this->pdf->setFont('Arial', 'B', 9);
    $this->pdf->colalign = array('C','C','C','C','C','C');
    $this->pdf->setwidths(array(25,20,50,25,20,50));
    $this->pdf->row(array(
      '',
      'Total Qty ',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalallqty),
      '',
      'Total Netto',
      Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalnetto1)
    ));		
    }
		$this->pdf->Output();
	}
	//24
	public function RincianPendinganPOPerBarangtoSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtyoutput = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct description,slocid,companycode,companyid,addressbookid,suppliername
				from (select distinct d.description,d.slocid,b.poqty,a.companyid,a.addressbookid,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty,
        (select companycode from company i where i.companyid = a.companyid) as companycode,e.fullname as suppliername
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5
				and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
        ".getFieldTable($productcollectid,'c','productcollectid')."
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty
				";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pendingan PO Per Barang ke Supplier : '.$supplier;
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 5, 'SUPPLIER ');
      $this->pdf->text(30, $this->pdf->gety() + 5, ' : '.$row['suppliername']);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description'].' ('.$row['companycode'].')');
      $this->pdf->SetFont('Arial', '', 9);
      $sql1           = "select distinct productname,productid from (
				select distinct c.productname,c.productid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5 
				and a.companyid = " . $row['companyid'] . "  and a.addressbookid = ".$row['addressbookid']."
        ".getFieldTable($productcollectid,'c','productcollectid')."
        and c.productname like '%" . $product . "%' 
				and d.slocid = " . $row['slocid'] . "
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty
				";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty       = 0;
      $totalqtyoutput = 0;
      $totalselisih   = 0;
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $this->pdf->checkPageBreak(30);
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->text(10, $this->pdf->gety() + 15, 'Nama Barang ');
        $this->pdf->text(33, $this->pdf->gety() + 15, ': ' . $row1['productname']);
        $sql2        = "select *
				from (select pono, docdate, uomcode, poqty, grqty, (poqty-grqty) as selisih
						from (select b.pono, b.docdate, d.uomcode, a.poqty, 
						ifnull((select sum(c.qty) 
						from grdetail c 
						join grheader h on h.grheaderid=c.grheaderid 
						where h.recordstatus = 3 and c.podetailid=a.podetailid),0) as grqty
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5 and b.addressbookid = ".$row['addressbookid']."
						and b.companyid = " . $row['companyid'] . " and e.productname like '%" . $product . "%' 
						and a.slocid = " . $row['slocid'] . "
						and a.productid = " . $row1['productid'] . "
            ".getFieldTable($productcollectid,'e','productcollectid')."
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty) zz";
        $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
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
          40,
          25,
          15,
          35,
          35,
          35
        ));
        $this->pdf->colheader = array(
          'No',
          'No PO',
          'Tgl PO',
          'Satuan',
          'Qty PO',
          'Qty GR',
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
          $i += 1;
          $this->pdf->setFont('Arial', '', 8);
          $this->pdf->row(array(
            $i,
            $row2['pono'],
            $row2['docdate'],
            $row2['uomcode'],
            Yii::app()->format->formatNumber($row2['poqty']),
            Yii::app()->format->formatNumber($row2['grqty']),
            Yii::app()->format->formatNumber($row2['selisih'])
          ));
          $jumlahqty += $row2['poqty'];
          $jumlahqtyoutput += $row2['grqty'];
          $jumlahselisih += $row2['selisih'];
        }
        $this->pdf->setFont('Arial', 'BI', 8);
        $this->pdf->setwidths(array(
          10,
          80,
          35,
          35,
          35
        ));
        $this->pdf->coldetailalign = array(
          'C',
          'R',
          'R',
          'R',
          'R'
        );
        $this->pdf->row(array(
          '',
          'JUMLAH ' . $row1['productname'],
          Yii::app()->format->formatNumber($jumlahqty),
          Yii::app()->format->formatNumber($jumlahqtyoutput),
          Yii::app()->format->formatNumber($jumlahselisih)
        ));
        $totalqty += $jumlahqty;
        $totalqtyoutput += $jumlahqtyoutput;
        $totalselisih += $jumlahselisih;
      }
      $this->pdf->setFont('Arial', 'BI', 9);
      $this->pdf->row(array(
        '',
        'TOTAL GUDANG ' . $row['description'],
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
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtyoutput),
      Yii::app()->format->formatNumber($subtotalselisih)
    ));
    $this->pdf->Output();
  }
	//25
	public function RekapPendinganPOPerBarangtoSupplier($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
        parent::actionDownPDF();
        $subtotalqty       = 0;
        $subtotalqtyoutput = 0;
        $subtotalselisih   = 0;
        $sql               = "select distinct description,slocid,addressbookid,suppliername,companyid,companycode
                    from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty,
                    a.addressbookid,e.fullname as suppliername, a.companyid,
                    (select companycode from company x where x.companyid = a.companyid) as companycode
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join addressbook e on e.addressbookid = a.addressbookid
                    where a.recordstatus = 5
                    and c.productname like '%" . $product . "%' 
                    ".getFieldTable($productcollectid,'c','productcollectid')."
                    and e.fullname like '%" . $supplier . "%'
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
                    where poqty>grqty";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row) {
          $this->pdf->companyid = $companyid;
        }
        $this->pdf->title    = 'Rekap Pendingan PO Per Barang ke Supplier '.$supplier;
        $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
        $this->pdf->AddPage('P');
        foreach ($dataReader as $row) {
          $this->pdf->SetFont('Arial', 'B', 10);
          $this->pdf->text(10, $this->pdf->gety() + 5, 'SUPPLIER');
          $this->pdf->text(30, $this->pdf->gety() + 5, ': ' . $row['suppliername']);
          $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
          $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description'].' ('.$row['companycode'].')');
          $sql1           = "select *
                    from (select distinct productname, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
                            from (select e.productname, d.uomcode, a.poqty, 
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
                            from podetail a
                            join poheader b on b.poheaderid = a.poheaderid
                            join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                            join product e on e.productid = a.productid
                            join addressbook f on f.addressbookid = b.addressbookid
                            join sloc g on g.slocid = a.slocid
                            where b.recordstatus = 5 and b.addressbookid = ".$row['addressbookid']."
                            and b.companyid = " . $row['companyid'] . " and e.productname like '%" . $product . "%' 
                            and a.slocid = " . $row['slocid'] . " ".getFieldTable($productcollectid,'e','productcollectid')."
                            and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                            and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
                            where poqty>grqty
                            group by productname) zz
                            ";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $totalqty       = 0;
          $i              = 0;
          $totalqtyoutput = 0;
          $totalselisih   = 0;
          $this->pdf->sety($this->pdf->gety() + 12);
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
            70,
            25,
            30,
            30,
            30
          ));
          $this->pdf->colheader = array(
            'No',
            'Nama Barang',
            'Satuan',
            'Qty PO',
            'Qty GR',
            'Selisih'
          );
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array(
            'C',
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
              Yii::app()->format->formatNumber($row1['poqty']),
              Yii::app()->format->formatNumber($row1['grqty']),
              Yii::app()->format->formatNumber($row1['selisih'])
            ));
            $totalqty += $row1['poqty'];
            $totalqtyoutput += $row1['grqty'];
            $totalselisih += $row1['selisih'];
          }
          $this->pdf->setFont('Arial', 'BI', 9);
          $this->pdf->colalign = array(
            'C',
            'C',
            'C',
            'C'
          );
          $this->pdf->setwidths(array(
            10,
            95,
            30,
            30,
            30
          ));
          $this->pdf->coldetailalign = array(
            'C',
            'R',
            'R',
            'R',
            'R'
          );
          $this->pdf->row(array(
            '',
            'TOTAL GUDANG ' . $row['description'],
            Yii::app()->format->formatNumber($totalqty),
            Yii::app()->format->formatNumber($totalqtyoutput),
            Yii::app()->format->formatNumber($totalselisih)
          ));
          $subtotalqty += $totalqty;
          $subtotalqtyoutput += $totalqtyoutput;
          $subtotalselisih += $totalselisih;
        }
        $this->pdf->sety($this->pdf->gety() + 5);
        $this->pdf->setFont('Arial', 'BI', 11);
        $this->pdf->row(array(
          '',
          'GRAND TOTAL ',
          Yii::app()->format->formatNumber($subtotalqty),
          Yii::app()->format->formatNumber($subtotalqtyoutput),
          Yii::app()->format->formatNumber($subtotalselisih)
        ));
        $this->pdf->Output();
  }
	//26
	public function RincianPendinganPOPerBarangPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtygr = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = getwfmaxstatbywfname('apppo')
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pendingan PO Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1           = "select distinct pono, docdate, productname, uomcode, (poqty) as poqty, (grqty) as grqty, (poqty-grqty) as selisih,netprice
						from (select e.productname, d.uomcode, a.poqty, b.pono, b.docdate,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty,a.netprice
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5 
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty       = 0;
      $i              = 0;
      $totalqtygr = 0;
      $totalselisih   = 0;
      $this->pdf->sety($this->pdf->gety() + 12);
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
        27,
        20,
        105,
        25,
        25,
        25,
        15,
        25
      ));
      $this->pdf->colheader = array(
        'No',
        'NO PO',
        'Tanggal PO',
        'Nama Barang',
        'Qty PO',
        'Qty GR',
        'Selisih',
        'Satuan',
        'Harga'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'C',
        'L',
        'R',
        'R',
        'R',
        'C',
        'R'
      );
       $this->pdf->setwidths(array(
        10,
        27,
        20,
        105,
        25,
        25,
        25,
        15,
        25
      ));
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['pono'],
          $row1['docdate'],
          $row1['productname'],
          Yii::app()->format->formatCurrency($row1['poqty']),
          Yii::app()->format->formatCurrency($row1['grqty']),
          Yii::app()->format->formatCurrency($row1['selisih']),
          $row1['uomcode'],
          Yii::app()->format->formatCurrency($row1['netprice']),
        ));
        $totalqty += $row1['poqty'];
        $totalqtygr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->pdf->setFont('Arial', 'BI', 9);
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
        152,
        25,
        25,
        25,
        15,
        25
      ));
      $this->pdf->coldetailalign = array(
        'C',
        'R',
        'R',
        'R',
        'R',
        'C',
        'R'
      );
      $this->pdf->row(array(
        '',
        'TOTAL GUDANG ' . $row['description'],
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtygr),
        Yii::app()->format->formatNumber($totalselisih),
        '',
        ''
      ));
      $subtotalqty += $totalqty;
      $subtotalqtygr += $totalqtygr;
      $subtotalselisih += $totalselisih;
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'BI', 11);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL ',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtygr),
      Yii::app()->format->formatNumber($subtotalselisih),
      '',
      ''
    ));
    $this->pdf->Output();
	}
	//27
	public function RincianPOPerBarangPerDokumen($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
    $subtotalqty       = 0;
    $subtotalqtygr = 0;
    $subtotalselisih   = 0;
    $sql               = "select distinct d.description,d.slocid
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join addressbook e on e.addressbookid = a.addressbookid
                    where a.recordstatus = getwfmaxstatbywfname('apppo')
                    ".getFieldTable($productcollectid,'c','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
                    and e.fullname like '%" . $supplier . "%'
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rincian Pendingan PO Per Gudang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L',array(220,395));
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', 'B', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'GUDANG');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1           = "select distinct pono, docdate, productname, uomcode, (poqty) as poqty, (grqty) as grqty, (poqty-grqty) as selisih,netprice,headernote,fullname
                        from (select e.productname, d.uomcode, a.poqty, b.pono, b.docdate,
                        ifnull((select sum(c.qty) 
                        from grdetail c 
                        join grheader h on h.grheaderid=c.grheaderid 
                        where h.recordstatus = 3 and c.podetailid=a.podetailid),0) as grqty,a.netprice,b.headernote,f.fullname
                        from podetail a
                        join poheader b on b.poheaderid = a.poheaderid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join product e on e.productid = a.productid
                        join addressbook f on f.addressbookid = b.addressbookid
                        join sloc g on g.slocid = a.slocid
                        where b.recordstatus = 5 
                        ".getFieldTable($productcollectid,'e','productcollectid')."
                        ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
                        and f.fullname like '%" . $supplier . "%' 
                        and a.slocid = " . $row['slocid'] . "
                        and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                        and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $totalqty       = 0;
      $i              = 0;
      $totalqtygr = 0;
      $totalselisih   = 0;
      $this->pdf->sety($this->pdf->gety() + 12);
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
        'C'
      );
      $this->pdf->setwidths(array(
        10,
        27,
        65,
        20,
        90,
        25,
        25,
        25,
        15,
        25,
        50
      ));
      $this->pdf->colheader = array(
        'No',
        'NO PO',
        'Nama Supplier',
        'Tanggal PO',
        'Nama Barang',
        'Qty PO',
        'Qty GR',
        'Selisih',
        'Satuan',
        'Harga',
        'Keterangan'
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'L',
        'C',
        'L',
        'R',
        'R',
        'R',
        'C',
        'R',
        'L'
      );
        $this->pdf->setwidths(array(
        10,
        27,
        65,
        20,
        90,
        25,
        25,
        25,
        15,
        25,
        50
      ));
      $this->pdf->setFont('Arial', '', 8);
      foreach ($dataReader1 as $row1) {
        $i += 1;
        $this->pdf->row(array(
          $i,
          $row1['pono'],
          $row1['fullname'],
          $row1['docdate'],
          $row1['productname'],
          Yii::app()->format->formatCurrency($row1['poqty']),
          Yii::app()->format->formatCurrency($row1['grqty']),
          Yii::app()->format->formatCurrency($row1['selisih']),
          $row1['uomcode'],
          Yii::app()->format->formatCurrency($row1['netprice']),
          $row1['headernote'],
        ));
        $totalqty += $row1['poqty'];
        $totalqtygr += $row1['grqty'];
        $totalselisih += $row1['selisih'];
      }
      $this->pdf->setFont('Arial', 'BI', 8);
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
        202,
        25,
        25,
        25,
        15,
        25
      ));
      $this->pdf->coldetailalign = array(
        'C',
        'R',
        'R',
        'R',
        'R',
        'C',
        'R'
      );
      $this->pdf->row(array(
        '',
        'TOTAL GUDANG ' . $row['description'],
        Yii::app()->format->formatNumber($totalqty),
        Yii::app()->format->formatNumber($totalqtygr),
        Yii::app()->format->formatNumber($totalselisih),
        '',
        ''
      ));
      $subtotalqty += $totalqty;
      $subtotalqtygr += $totalqtygr;
      $subtotalselisih += $totalselisih;
      $this->pdf->checkPageBreak(30);
    }
    $this->pdf->sety($this->pdf->gety() + 5);
    $this->pdf->setFont('Arial', 'BI', 11);
    $this->pdf->row(array(
      '',
      'GRAND TOTAL ',
      Yii::app()->format->formatNumber($subtotalqty),
      Yii::app()->format->formatNumber($subtotalqtygr),
      Yii::app()->format->formatNumber($subtotalselisih),
        '',
        ''
    ));
    $this->pdf->Output();
	}
	//28
	public function RekapFPPForecast($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
    parent::actionDownload();

    $this->pdf->title='Rekap FPP Forecast';
    $this->pdf->subtitle='Per Tanggal (Periode) : '.date('F Y',strtotime($enddate));

    $month = date('Y-m',strtotime($enddate));
    $month1 = $month.'-01';
    $this->pdf->addPage('L','F4');

    $sql = "select t.productcollectid, a.collectionname, t.forecastfppid,t.companyid
      from forecastfpp t 
      join productcollection a on a.productcollectid=t.productcollectid
      where t.perioddate='{$month1}'
      ".getFieldTable($productcollectid,'t','productcollectid')."
      and t.companyid=".$companyid;
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $totalqty1=0;
    $totalprice1=0;
    $totalqty2=0;
    $totalprice2=0;
    $totalqty3=0;
    $totalprice3=0;
    $totalqty4=0;
    $totalprice4=0;
    $totalqty5=0;
    $totalprice5=0;
    foreach($dataReader as $row)
    {
      //$this->pdf->setY($this->pdf->getY()+5);
      $this->pdf->setFont('Arial','B',9);
      $this->pdf->coldetailalign = array(
        'L',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
        'C',
      );
      $this->pdf->setwidths(array(
        31,
        59,
        14,
        43,
        43,
        43,
        43,
        43
      ));
      $this->pdf->setbordercell(array('T','T','T','LTBR','LTBR','LTBR','LTBR','LTBR'));
      $this->pdf->row(array(
        getCatalog('productcollection'),
        getCatalog('product'),
        getCatalog('uom'),
        getCatalog('FPP Bulan Ini'),
        getCatalog('FPP Bulan Lalu'),
        getCatalog('Realisasi Pembelian'),
        getCatalog('Saldo Awal'),
        getCatalog('Saldo Akhir')
      ));
      $this->pdf->setbordercell(array('B','B','B','LB','BR','LB','BR','LB','BR','LB','BR','LB','BR'));
      $this->pdf->coldetailalign = array(
        'L',
        'L',
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
        'C'
      );
      $this->pdf->setwidths(array(
        15,
        75,
        14,
        20,
        23,
        20,
        23,
        20,
        23,
        20,
        23,
        20,
        23,
      ));
      $this->pdf->row(array(
          '','','',
          'Qty',
          'Nilai',
          'Qty',
          'Nilai',
          'Qty',
          'Nilai',
          'Qty',
          'Nilai',
          'Qty',
          'Nilai'
      ));
      $this->pdf->setY($this->pdf->getY()+5);
      $this->pdf->setFont('Arial','',9);
      $y = $this->pdf->getY();
      $this->pdf->text(10,$y,$row['collectionname']);
      $this->pdf->setY($this->pdf->getY()+2);
      $sql1="select productid,productname, uomcode, sum(qty1) as qty1, sum(price1) as price1, sum(qty2) as qty2, sum(price2) as price2, sum(qty3) as qty3, sum(price3) as price3 , flag from (select distinct b.productid, b.productname, c.uomcode,a.prqtyreal as qty1,a.price*a.prqtyreal as price1,
      0 as qty2, 0 as price2, 0 as qty3, 0 as price3,'' as flag
      from forecastfppdet a
      join product b on b.productid = a.productid
      join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
      where a.forecastfppid = ".$row['forecastfppid']."
      union
      select distinct a1.productid,b1.productname, c1.uomcode, 0 as qty1, 0 as price1,a1.prqtyreal as qty2, a1.price*a1.prqtyreal as price2,0 as qty3, 0 as price3,'*' as flag
      from forecastfppdet a1
      join forecastfpp a2 on a2.forecastfppid = a1.forecastfppid
      join product b1 on b1.productid = a1.productid
      join unitofmeasure c1 on c1.unitofmeasureid = a1.unitofmeasureid
      where a2.productcollectid = {$row['productcollectid']} and
      a2.companyid = {$row['companyid']} and a2.perioddate = date_add('{$month1}', interval -1 month)
      union
      select a3.productid,g3.productname,h3.uomcode,0 as qty1, 0 as price1, 0 as qty2, 0 as price2, sum(a3.qty) as qty3,sum(a3.qty * c3.netprice) as price3,'**' as flag
      from grdetail a3
      left join invoiceap b3 on b3.grheaderid=a3.grheaderid
      left join podetail c3 on c3.podetailid=a3.podetailid
      left join product g3 on g3.productid=a3.productid
      left join unitofmeasure h3 on h3.unitofmeasureid=a3.unitofmeasureid
      where b3.recordstatus = 3 and b3.companyid={$row['companyid']} and g3.productcollectid={$row['productcollectid']}
      and b3.receiptdate between date_add('{$month1}', interval -1 month) 
      and date_add('{$month1}', interval -1 day)
      group by productname) z
      group by productname";
      
      $i=1;
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $this->pdf->setbordercell(array('','','','','','','','','','','','',''));
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
        'R'
      );
      $this->pdf->setFont('Arial','',8);
      $subqty1=0;
      $subprice1=0;
      $subqty2=0;
      $subprice2=0;
      $subqty3=0;
      $subprice3=0;
      $subqty4=0;
      $subprice4=0;
      $subqty5=0;
      $subprice5=0;
      foreach($dataReader1 as $row1)
      {
        $sAwal = Yii::app()->db->createCommand("select a.productname, sum(a.qty) as qty4, sum(a.qty*a.buyprice) as price4, a.averageprice
          from productdetailhist a
          where a.productid={$row1['productid']} and a.slocid in(
            select x.slocid
            from sloc x
            join plant xa on xa.plantid = x.plantid
            where xa.companyid={$companyid}
          )
          and a.buydate < date_add(date_add(last_day('".date(Yii::app()->params['datetodb'],strtotime($enddate))."'), interval 1 day), interval -2 month)")->queryRow();

        $sAkhir = Yii::app()->db->createCommand("select a.productname, sum(a.qty) as qty5, sum(a.qty*a.buyprice) as price5, a.averageprice
          from productdetailhist a
          where a.productid={$row1['productid']} and a.slocid in(
            select x.slocid
            from sloc x
            join plant xa on xa.plantid = x.plantid
            where xa.companyid={$companyid}
          )
          and a.buydate < date_add('{$month1}', interval -1 day)")->queryRow();        
        
        $this->pdf->row(array(
          $i,
          $row1['productname'].''.$row1['flag'],
          $row1['uomcode'],
          Yii::app()->format->formatNumber($row1['qty1']),
          Yii::app()->format->formatCurrency($row1['price1']/$per),
          Yii::app()->format->formatCurrency($row1['qty2']),
          Yii::app()->format->formatCurrency($row1['price2']/$per),
          Yii::app()->format->formatCurrency($row1['qty3']),
          Yii::app()->format->formatCurrency($row1['price3']/$per),
          Yii::app()->format->formatCurrency($sAwal['qty4']),
          Yii::app()->format->formatCurrency($sAwal['price4']/$per),
          Yii::app()->format->formatCurrency($sAkhir['qty5']),
          Yii::app()->format->formatCurrency($sAkhir['price5']/$per),
        ));
        $i++;
        $subqty1 += ($row1['qty1']);
        $subprice1 += ($row1['price1']);
        $subqty2 += ($row1['qty2']);
        $subprice2 += ($row1['price2']);
        $subqty3 += ($row1['qty3']);
        $subprice3 += ($row1['price3']);
        $subqty4 += ($sAwal['qty4']);
        $subprice4 += ($sAwal['price4']);
        $subqty5 += ($sAkhir['qty5']);
        $subprice5 += ($sAkhir['price5']);
      }
      $this->pdf->setwidths(array(
        15,
        75,
        14,
        43,
        43,
        43,
        43,
        43,
      ));
       $this->pdf->coldetailalign = array(
        'L',
        'C',
        'C',
        'R',
        'R',
        'R',
        'R',
        'R',
      );
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->row(array(
        '',
        'TOTAL '.$row['collectionname'],
        '',
        Yii::app()->format->formatCurrency($subprice1/$per),
        Yii::app()->format->formatCurrency($subprice2/$per),
        Yii::app()->format->formatCurrency($subprice3/$per),
        Yii::app()->format->formatCurrency($subprice4/$per),
        Yii::app()->format->formatCurrency($subprice5/$per)
      ));
      $this->pdf->setFont('Arial','',9);
      $totalqty1+=$subqty1;
      $totalprice1+=$subprice1;
      $totalqty2+=$subqty2;
      $totalprice2+=$subprice2;
      $totalqty3+=$subqty3;
      $totalprice3+=$subprice3;
      $totalqty4+=$subqty4;
      $totalprice4+=$subprice4;
      $totalqty5+=$subqty5;
      $totalprice5+=$subprice5;
      $this->pdf->setY($this->pdf->getY()+10);
    }
    $this->pdf->setY($this->pdf->getY()+10);
    $this->pdf->setFont('Arial','B',10);
    $this->pdf->setwidths(array(
        15,
        75,
        14,
        43,
        43,
        43,
        43,
        43,
      ));
       $this->pdf->coldetailalign = array(
        'L',
        'C',
        'C',
        'R',
        'R',
        'R',
        'R',
        'R',
      );
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->row(array(
        '',
        'GRAND TOTAL ',
        '',
        Yii::app()->format->formatCurrency($totalprice1/$per),
        Yii::app()->format->formatCurrency($totalprice2/$per),
        Yii::app()->format->formatCurrency($totalprice3/$per),
        Yii::app()->format->formatCurrency($totalprice4/$per),
        Yii::app()->format->formatCurrency($totalprice5/$per)
      ));
    $this->pdf->Output();
  }

	
  public function actionDownXLS()
	{
	  parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['supplier']) && isset($_GET['productcollectid']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1) {
        $this->RincianPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 3) {
        $this->RekapPOPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 4) {
        $this->RekapPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 5) {
        $this->RincianPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 6) {
        $this->RekapPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 7) {
        $this->RekapPembelianPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 8) {
        $this->RekapPembelianPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 9) {
        $this->RincianReturPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapReturPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 11) {
        $this->RekapReturPembelianPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapReturPembelianPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 13) {
        $this->RincianSelisihPembelianReturPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 14) {
        $this->RekapSelisihPembelianReturPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 15) {
        $this->RekapSelisihPembelianReturPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 16) {
        $this->RekapSelisihPembelianReturPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 17) {
        $this->PendinganPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 18) {
        $this->RincianPendinganPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 19) {
        $this->RekapPendinganPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 20) {
        $this->LaporanPOStatusBelumMaxXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      }	else if ($_GET['lro'] == 21) {
        $this->RekapPembelianPerBarangPerTanggalXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 22) {
        $this->LaporanPembelianPerSupplierPerBulanPerTahunXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 23) {
        $this->PendinganPOPerDokumentoSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 24) {
        $this->RincianPendinganPOPerBarangtoSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 25) {
        $this->RekapPendinganPOPerBarangtoSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 26) {
        $this->RincianPendinganPOPerBarangPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 27) {
        $this->RincianPOPerBarangPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 28) {
        $this->RekapFPPForecastXLS($_GET['company'], $_GET['supplier'], $_GET['productcollectid'],$_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else {
        echo $this->getCatalog('reportdoesnotexist');
      }
    }
	}
  //1
	public function RincianPOPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpoperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totalppn       = 0;
        $totalnetto     = 0;
        $totalallqty    = 0;
        $totalalljumlah = 0;
        $sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate, a.headernote
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.recordstatus=5 and a.pono is not null
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
            ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'a')."
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
        $line = 4;
        foreach ($dataReader as $row) 
            {
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No. PO')
                ->setCellValueByColumnAndRow(1, $line, ': ' . $row['pono'])
                ->setCellValueByColumnAndRow(5, $line, 'Tgl. PO')
                ->setCellValueByColumnAndRow(6, $line, ': ' . $row['docdate']);
          $line++;

          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Supplier')
                ->setCellValueByColumnAndRow(1, $line, ': ' . $row['fullname'])
                ->setCellValueByColumnAndRow(5, $line, 'T.O.P.')
                ->setCellValueByColumnAndRow(6, $line, ': ' . $row['paydays']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(2, $line, 'Qty')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Harga')
                ->setCellValueByColumnAndRow(5, $line, 'Jumlah')
                ->setCellValueByColumnAndRow(6, $line, 'Keterangan');
          $line++;
          $i           = 0;
          $totalqty    = 0;
          $totaljumlah = 0;
          $sql1 = "select distinct *,(nominal+ppn) as netto
							from
							(select *,(select nominal*c.taxvalue/100 from tax c where c.taxid=zz.taxid) as ppn
							from 
							(select a.poheaderid,a.taxid,a.pono,g.productname,f.poqty,f.netprice,h.uomcode,f.itemtext,
							(select sum(b.poqty*b.netprice) 
							from podetail b 
							where b.poheaderid=a.poheaderid) as nominal
							from poheader a
							join addressbook d on d.addressbookid=a.addressbookid
							join paymentmethod e on e.paymentmethodid=a.paymentmethodid
							join podetail f on f.poheaderid = a.poheaderid
							join product g on g.productid = f.productid
							join unitofmeasure h on h.unitofmeasureid = f.unitofmeasureid
							where a.pono is not null and g.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%'  
							".getCompanyGroup($companyid,'a')." and a.poheaderid = " . $row['poheaderid'] . "
              ".getFieldTable($productcollectid,'g','productcollectid')."
							and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          foreach ($dataReader1 as $row1) 
                {
            $i += 1;
            $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(0, $line, $i)
                            ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                            ->setCellValueByColumnAndRow(2, $line, $row1['poqty'])
                            ->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])
                            ->setCellValueByColumnAndRow(4, $line, $row1['netprice'] / $per)
                            ->setCellValueByColumnAndRow(5, $line, ($row1['netprice'] * $row1['poqty']) / $per)
                            ->setCellValueByColumnAndRow(6, $line, $row1['itemtext']);
            $line++;
            $totalqty += $row1['poqty'];
            $totaljumlah += ($row1['netprice'] * $row1['poqty']) / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, '')
                ->setCellValueByColumnAndRow(1, $line, '')
                ->setCellValueByColumnAndRow(2, $line, $totalqty)
                ->setCellValueByColumnAndRow(3, $line, '')
                ->setCellValueByColumnAndRow(4, $line, '')
                ->setCellValueByColumnAndRow(5, $line, 'Nominal')
                ->setCellValueByColumnAndRow(6, $line, $totaljumlah);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, '')
                ->setCellValueByColumnAndRow(1, $line, '')
                ->setCellValueByColumnAndRow(2, $line, '')
                ->setCellValueByColumnAndRow(3, $line, '')
                ->setCellValueByColumnAndRow(4, $line, '')
                ->setCellValueByColumnAndRow(5, $line, 'PPN')
                ->setCellValueByColumnAndRow(6, $line, $row1['ppn'] / $per);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, '')
                ->setCellValueByColumnAndRow(1, $line, '')
                ->setCellValueByColumnAndRow(2, $line, '')
                ->setCellValueByColumnAndRow(3, $line, '')
                ->setCellValueByColumnAndRow(4, $line, '')
                ->setCellValueByColumnAndRow(5, $line, 'Netto')
                ->setCellValueByColumnAndRow(6, $line, $row1['netto'] / $per);
          $line += 2;
          $totalppn += $row1['ppn'] / $per;
          $totalnetto += $row1['netto'] / $per;
                $totalallqty += $row1['poqty'];
                $totalalljumlah += $totaljumlah / $per;
        }
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, '')
            ->setCellValueByColumnAndRow(1, $line, '')
            ->setCellValueByColumnAndRow(2, $line, 'Total Qty')
            ->setCellValueByColumnAndRow(3, $line, '')
            ->setCellValueByColumnAndRow(4, $line, 'Total Nominal')
            ->setCellValueByColumnAndRow(5, $line, 'Total PPN')
            ->setCellValueByColumnAndRow(6, $line, 'Total Netto');
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, '')
            ->setCellValueByColumnAndRow(1, $line, '')
            ->setCellValueByColumnAndRow(2, $line, $totalallqty)
            ->setCellValueByColumnAndRow(3, $line, '')
            ->setCellValueByColumnAndRow(4, $line, $totalalljumlah)
            ->setCellValueByColumnAndRow(5, $line, $totalppn)
            ->setCellValueByColumnAndRow(6, $line, $totalnetto);
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //2
	public function RekapPOPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappoperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $sql        = "select distinct *,(nominal+ppn) as netto
                    from
                    (select *,(select nominal*c.taxvalue/100 from tax c where c.taxid=zz.taxid) as ppn
                    from 
                    (select a.poheaderid,a.taxid,a.pono,a.docdate,d.fullname,(select sum(b.poqty*b.netprice) 
                    from podetail b where b.poheaderid=a.poheaderid) as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    join podetail e on e.poheaderid = a.poheaderid
                    join product f on f.productid = e.productid
                    where a.recordstatus=5 and a.pono is not null and f.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'f','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."
                    a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz order by pono";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line = 4;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'No. Bukti')->setCellValueByColumnAndRow(2, $line, 'Tanggal')->setCellValueByColumnAndRow(3, $line, 'Supplier')->setCellValueByColumnAndRow(4, $line, 'Nominal')->setCellValueByColumnAndRow(5, $line, 'PPN')->setCellValueByColumnAndRow(6, $line, 'Total');
        $line++;
        $total    = 0;
        $i        = 0;
        $totalppn = 0;
        $totalnetto = 0;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['pono'])->setCellValueByColumnAndRow(2, $line, $row['docdate'])->setCellValueByColumnAndRow(3, $line, $row['fullname'])->setCellValueByColumnAndRow(4, $line, $row['nominal'] / $per)->setCellValueByColumnAndRow(5, $line, $row['ppn'] / $per)->setCellValueByColumnAndRow(6, $line, $row['netto'] / $per);
          $line++;
          $total += $row['nominal'] / $per;
          $totalppn += $row['ppn'] / $per;
          $totalnetto += $row['netto'] / $per;
        }
        $line += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $line, 'Grand Total')->setCellValueByColumnAndRow(4, $line, $total)->setCellValueByColumnAndRow(5, $line, $totalppn)->setCellValueByColumnAndRow(6, $line, $totalnetto);
        $this->getFooterXLS($this->phpExcel);
    }
    
  }
  //3
	public function RekapPOPerSupplierXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappopersupplier';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        if($companyid==0) { $com = ' and d.isextern = 1';} else { $com = 'and a.companyid = '.$companyid; }
    $sql          = "select fullname,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
                    from
                    (select *,(nominal+ppn) as netto
                    from
                    (select *,(select sum(nominal*c.taxvalue/100) from tax c where c.taxid=zz.taxid) as ppn
                    from 
                    (select a.poheaderid,a.taxid,a.addressbookid,a.pono,a.docdate,d.fullname,
										(select sum(b.poqty*b.netprice) 
                    from podetail b 
										join product e on e.productid=b.productid 
										where b.poheaderid=a.poheaderid and e.productname like '%" . $product . "%' 
                    ".getFieldTable($productcollectid,'e','productcollectid').") as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    where a.recordstatus=5 and a.pono is not null and d.fullname like '%" . $supplier . "%' 
                    {$com}
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz)xx
                    group by fullname";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        $totalppn     = 0;
        $totalnominal = 0;
        $total        = 0;
        $i            = 0;
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, GetCompanyCode($companyid));
        $line = 4;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Supplier')->setCellValueByColumnAndRow(2, $line, 'Nominal')->setCellValueByColumnAndRow(3, $line, 'PPN')->setCellValueByColumnAndRow(4, $line, 'Total');
        $line++;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['fullname'])->setCellValueByColumnAndRow(2, $line, $row['nominal'] / $per)->setCellValueByColumnAndRow(3, $line, $row['ppn'] / $per)->setCellValueByColumnAndRow(4, $line, $row['netto'] / $per);
          $line++;
          $totalnominal += $row['nominal'] / $per;
          $totalppn += $row['ppn'] / $per;
          $total += $row['netto'] / $per;
        }
        $line += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Grand Total')->setCellValueByColumnAndRow(2, $line, $totalnominal)->setCellValueByColumnAndRow(4, $line, $totalppn)->setCellValueByColumnAndRow(4, $line, $total);
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //4
	public function RekapPOPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappoperbarang';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totalqty1     = 0;
        $totalppn1     = 0;
        $totalnominal1 = 0;
        $total1        = 0;
        $sql        = "select distinct g.materialgroupid, g.description
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join addressbook c on c.addressbookid = a.addressbookid
                    join paymentmethod d on d.paymentmethodid = a.paymentmethodid
                    join product e on e.productid = b.productid
                    join productplant f on f.productid = b.productid
                    join materialgroup g on g.materialgroupid = f.materialgroupid
                    where a.pono is not null ".getFieldTable($productcollectid,'e','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."
                    and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
        $line = 4;
        foreach ($dataReader as $row) {
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Divisi')->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Nominal')->setCellValueByColumnAndRow(4, $line, 'PPN')->setCellValueByColumnAndRow(5, $line, 'Total');
          $line++;
          $sql1         = "select distinct productname,uomcode,sum(poqty) as poqty,sum(netprice) as netprice,sum(nominal) as nominal,sum(ppn) as ppn,sum(nominal+ppn) as total	
								from (select distinct f.podetailid,g.productname,f.poqty,f.netprice,h.uomcode,f.poqty*f.netprice as nominal,(f.poqty*f.netprice)*j.taxvalue/100 as ppn
                from poheader a
                join addressbook d on d.addressbookid=a.addressbookid
                join paymentmethod e on e.paymentmethodid=a.paymentmethodid
                join podetail f on f.poheaderid = a.poheaderid
                join product g on g.productid = f.productid
                join unitofmeasure h on h.unitofmeasureid = f.unitofmeasureid
                join productplant i on i.productid = f.productid
                join tax j on j.taxid=a.taxid
                where a.recordstatus=5 and a.pono is not null and g.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' 
                ".getFieldTable($productcollectid,'g','productcollectid')."
                ".getCompanyGroup($companyid,'a')." and i.materialgroupid = " . $row['materialgroupid'] . "
                and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz group by productname";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $totalqty     = 0;
          $totalppn     = 0;
          $totalnominal = 0;
          $total        = 0;
          $i            = 0;
          foreach ($dataReader1 as $row1) {
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, $row1['poqty'])->setCellValueByColumnAndRow(3, $line, $row1['nominal'] / $per)->setCellValueByColumnAndRow(4, $line, $row1['ppn'] / $per)->setCellValueByColumnAndRow(5, $line, $row1['total'] / $per);
            $line++;
            $totalqty += $row1['poqty'];
            $totalnominal += $row1['nominal'] / $per;
            $totalppn += $row1['ppn'] / $per;
            $total += $row1['total'] / $per;
          }
          $line += 1;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, $totalqty)->setCellValueByColumnAndRow(3, $line, $totalnominal)->setCellValueByColumnAndRow(4, $line, $totalppn)->setCellValueByColumnAndRow(5, $line, $total);
          $totalqty1 += $totalqty;
                $totalnominal1 += $totalnominal;
                $totalppn1 += $totalppn;
                $total1 += $total;
                $line += 1;
        }
            $line += 1;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'GrandTotal')->setCellValueByColumnAndRow(2, $line, $totalqty1)->setCellValueByColumnAndRow(3, $line, $totalnominal1)->setCellValueByColumnAndRow(4, $line, $totalppn1)->setCellValueByColumnAndRow(5, $line, $total1);
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //5
	public function RincianPembelianPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpembelianperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totalallqty = 0;
        $totalallrp  = 0;
        $totalinvoice =0;
        $sql          = "select distinct a.invoiceapid,b.grheaderid,ifnull(a.invoiceno,0) as invno,a.invoicedate,d.paydays,b.grno,b.grdate,
						e.fullname,c.pono,c.docdate as podate,c.poheaderid,c.companyid
						from invoiceap a
						left join grheader b on b.grheaderid=a.grheaderid
						left join poheader c on c.poheaderid=b.poheaderid
						left join paymentmethod d on d.paymentmethodid=c.paymentmethodid
						left join addressbook e on e.addressbookid=c.addressbookid
            left join grdetail f on f.grheaderid = b.grheaderid
            join product g on g.productid = f.productid
						where a.recordstatus=3  ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'c')." and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by grdate,grno";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line = 4;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. Invoice')->setCellValueByColumnAndRow(1, $line, ': ' . $row['invno'])->setCellValueByColumnAndRow(2, $line, 'No. STTB')->setCellValueByColumnAndRow(3, $line, ': ' . $row['grno'])->setCellValueByColumnAndRow(5, $line, 'No. PO')->setCellValueByColumnAndRow(6, $line, ': ' . $row['pono']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['invoicedate'])->setCellValueByColumnAndRow(2, $line, 'Tanggal')->setCellValueByColumnAndRow(3, $line, ': ' . $row['grdate'])->setCellValueByColumnAndRow(5, $line, 'Tanggal')->setCellValueByColumnAndRow(6, $line, ': ' . $row['podate']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'T.O.P')->setCellValueByColumnAndRow(1, $line, ': ' . $row['paydays'])->setCellValueByColumnAndRow(2, $line, 'Supplier')->setCellValueByColumnAndRow(3, $line, ': ' . $row['fullname'])->setCellValueByColumnAndRow(5, $line, '')->setCellValueByColumnAndRow(6, $line, '');
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Harga')->setCellValueByColumnAndRow(5, $line, 'Jumlah')->setCellValueByColumnAndRow(6, $line, 'Keterangan');
          $line++;
          $sql1        = "select distinct a.grdetailid,g.productname,a.qty,h.uomcode,c.netprice,(a.qty * c.netprice) as jumlah,
							a.itemtext,i.taxvalue,((a.qty * c.netprice)*(i.taxvalue/100)) as PPN,b.amount 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							where g.productname like '%" . $product . "%'  ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'d')." and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $total       = 0;
          $i           = 0;
          $totalqty    = 0;
          foreach ($dataReader1 as $row1) {
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($row1['qty']))->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, Yii::app()->format->formatCurrency($row1['netprice'] / $per))->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row1['jumlah'] / $per))->setCellValueByColumnAndRow(6, $line, $row1['itemtext']);
            $line++;
            $totalqty += $row1['qty'];
            $total += $row1['jumlah'] / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalqty))->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($total));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row1['itemtext'])->setCellValueByColumnAndRow(5, $line, 'NOMINAL')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($total));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'PPN')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($row1['PPN'] / $per));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'NETTO')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($total + ($row1['PPN'] / $per)));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'ADJUSMENT')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency(($row1['amount'] / $per) - ($total + ($row1['PPN'] / $per))));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'NILAI INVOICE')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency(($row1['amount'] / $per)));
          $line += 2;
          $totalallqty += $totalqty;
          $totalallrp += $total;
                $totalinvoice += $row1['amount'] / $per;
        }
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'TOTAL QTY')->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalallqty))->setCellValueByColumnAndRow(5, $line, 'TOTAL NETTO')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($totalallrp));
            $line++;
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'TOTAL ADJUSMENT')->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalinvoice - $totalallrp))->setCellValueByColumnAndRow(5, $line, 'TOTAL NILAI INVOICE')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($totalinvoice));
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //6
	public function RekapPembelianPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid > 0) {
      $joincom = ""; 
      $joincom1 = ""; 
      $wherecom = " and k.companyid = " . $companyid ; 
      $wherecom1 = "  zc.companyid = ".$companyid." ";
    }
    else {
      $joincom = " join company a9 on a9.companyid=e.companyid "; 
      $joincom1 = " join company a9 on a9.companyid=g.companyid "; 
      $wherecom = " and k.isgroup=1"; 
      $wherecom1 = "  zc.isgroup = 1";
    }
    if($price==1)
    {
        $totaljumlah1 = 0;
        $totaldisc1   = 0;
        $totalnetto1  = 0;
        $sql        = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext,companycode from
							(select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
							a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak, k.companycode
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
              left join company k on k.companyid = d.companyid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							group by invoiceno,grheaderid order by grno";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, GetCompanyCode($companyid));
        $line = 4;
        $i    = 0;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'No. Invoice')->setCellValueByColumnAndRow(2, $line, 'No. STTB')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, 'Supplier')->setCellValueByColumnAndRow(5, $line, 'Nominal')->setCellValueByColumnAndRow(6, $line, 'PPN')->setCellValueByColumnAndRow(7, $line, 'Netto')->setCellValueByColumnAndRow(8, $line, 'Keterangan');
        $line++;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i += 1)
            ->setCellValueByColumnAndRow(1, $line, $row['invoiceno'])
            ->setCellValueByColumnAndRow(2, $line, $row['grno'] . ($companyid==0 ? ' - '.$row['companycode'] : ''),)
            ->setCellValueByColumnAndRow(3, $line, $row['receiptdate'])
            ->setCellValueByColumnAndRow(4, $line, $row['fullname'])
            ->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row['jumlah'] / $per))
            ->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($row['PPN'] / $per))
            ->setCellValueByColumnAndRow(7, $line, Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per))->setCellValueByColumnAndRow(8, $line, $row['itemtext']);
          $line++;
          $totaljumlah1 += $row['jumlah'] / $per;
          $totaldisc1 += $row['PPN'] / $per;
          $totalnetto1 += ($row['jumlah'] + $row['PPN']) / $per;
        }
        $line += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, 'NOMINAL')->setCellValueByColumnAndRow(3, $line, Yii::app()->format->formatCurrency($totaljumlah1))->setCellValueByColumnAndRow(4, $line, 'PPN')->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($totaldisc1))->setCellValueByColumnAndRow(6, $line, 'NETTO')->setCellValueByColumnAndRow(7, $line, Yii::app()->format->formatCurrency($totalnetto1));
        $line++;
        $this->getFooterXLS($this->phpExcel);
    }
  }
	public function RekapPembelianPerDokumenXLS_old($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totaljumlah1 = 0;
        $totaldisc1   = 0;
        $totalnetto1  = 0;
        $sql          = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext from
                                (select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
                                a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                                from grdetail a
                                left join invoiceap b on b.grheaderid=a.grheaderid
                                left join podetail c on c.podetailid=a.podetailid
                                left join poheader d on d.poheaderid=b.poheaderid
                                left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
                                left join addressbook f on f.addressbookid=d.addressbookid
                                left join product g on g.productid=a.productid
                                left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
                                left join tax i on i.taxid=d.taxid
                                left join grheader j on j.grheaderid=b.grheaderid
                                where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                                and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
                                group by invoiceno,grheaderid order by grno";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, GetCompanyCode($companyid));
        $line = 4;
        $i    = 0;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'No. Invoice')->setCellValueByColumnAndRow(2, $line, 'No. STTB')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, 'Supplier')->setCellValueByColumnAndRow(5, $line, 'Nominal')->setCellValueByColumnAndRow(6, $line, 'PPN')->setCellValueByColumnAndRow(7, $line, 'Netto')->setCellValueByColumnAndRow(8, $line, 'Keterangan');
        $line++;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['invoiceno'])->setCellValueByColumnAndRow(2, $line, $row['grno'])->setCellValueByColumnAndRow(3, $line, $row['receiptdate'])->setCellValueByColumnAndRow(4, $line, $row['fullname'])->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row['jumlah'] / $per))->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($row['PPN'] / $per))->setCellValueByColumnAndRow(7, $line, Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per))->setCellValueByColumnAndRow(8, $line, $row['itemtext']);
          $line++;
          $totaljumlah1 += $row['jumlah'] / $per;
          $totaldisc1 += $row['PPN'] / $per;
          $totalnetto1 += ($row['jumlah'] + $row['PPN']) / $per;
        }
        $line += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, 'NOMINAL')->setCellValueByColumnAndRow(3, $line, Yii::app()->format->formatCurrency($totaljumlah1))->setCellValueByColumnAndRow(4, $line, 'PPN')->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($totaldisc1))->setCellValueByColumnAndRow(6, $line, 'NETTO')->setCellValueByColumnAndRow(7, $line, Yii::app()->format->formatCurrency($totalnetto1));
        $line++;
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //7
  public function RekapPembelianPerSupplierXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianpersupplier';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
      if ($companyid == 0) {$com = " and f.isextern = 1 "; $ext = " (Eksternal)";} else {$com = " and d.companyid = ".$companyid." "; $ext = "";}
        $totalnominal = 0;
        $totalppn     = 0;
        $totaljumlah  = 0;
        $sql        = "select fullname,sum(nom) as nominal,sum(pajak) as PPN from 
						(select distinct a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
						((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
						from grdetail a
						left join invoiceap b on b.grheaderid=a.grheaderid
						left join podetail c on c.podetailid=a.podetailid
						left join poheader d on d.poheaderid=b.poheaderid
						left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
						left join addressbook f on f.addressbookid=d.addressbookid
						left join product g on g.productid=a.productid
						left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
						left join tax i on i.taxid=d.taxid
						where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."
            and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'
						and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						group by fullname order by fullname";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, GetCompanyCode($companyid));
        $line = 4;
        $i    = 0;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Supplier')->setCellValueByColumnAndRow(2, $line, 'Nominal')->setCellValueByColumnAndRow(3, $line, 'PPN')->setCellValueByColumnAndRow(4, $line, 'Total');
        $line++;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['fullname'])->setCellValueByColumnAndRow(2, $line, ($row['nominal'] / $per))->setCellValueByColumnAndRow(3, $line, ($row['PPN'] / $per))->setCellValueByColumnAndRow(4, $line, (($row['nominal'] + $row['PPN']) / $per));
          $line++;
          $totalnominal += $row['nominal'] / $per;
          $totalppn += $row['PPN'] / $per;
          $totaljumlah += ($row['nominal'] + $row['PPN']) / $per;
        }
        $line += 1;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')->setCellValueByColumnAndRow(2, $line, ($totalnominal))->setCellValueByColumnAndRow(3, $line, ($totalppn))->setCellValueByColumnAndRow(4, $line, ($totaljumlah));
        $this->getFooterXLS($this->phpExcel);
    }
  }
  //8
	public function RekapPembelianPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianperbarang';
    parent::actionDownxls();
    if($companyid==0){$com=' f.isgroup = 1';}else {$com = ' f.companyid = '.$companyid;}
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totalqty1     = 0;
        $totalnominal1 = 0;
        $totalppn1     = 0;
        $sql           = "select distinct a.materialgroupid,a.description
				from materialgroup a
				join productplant b on b.materialgroupid = a.materialgroupid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join plant e on e.plantid = d.plantid
				join company f on f.companyid = e.companyid
				where {$com} and b.productid in
				(select distinct a.productid 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
                ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
                ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line = 4;
        foreach ($dataReader as $row) 
            {
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'Material Group')
                ->setCellValueByColumnAndRow(1, $line, ': ' . $row['description']);
          $line++;

          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $line, 'No')
                ->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
                ->setCellValueByColumnAndRow(2, $line, 'Qty')
                ->setCellValueByColumnAndRow(3, $line, 'Satuan')
                ->setCellValueByColumnAndRow(4, $line, 'Harga')
                ->setCellValueByColumnAndRow(5, $line, 'PPN')
                ->setCellValueByColumnAndRow(6, $line, 'Jumlah');
          $line++;

          $sql1         = "select g.productname,sum(a.qty) as qty,h.uomcode,c.netprice,sum(a.qty * c.netprice) as nominal,
							a.itemtext,sum((a.qty * c.netprice)*(i.taxvalue/100)) as PPN 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join productplant j on j.productid=a.productid and j.slocid=a.slocid
							where b.recordstatus = 3 and j.recordstatus = 1 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname order by productname";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $i            = 0;
          $totalqty     = 0;
          $totalppn     = 0;
          $totalnominal = 0;
          foreach ($dataReader1 as $row1) 
                {
            $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(0, $line, $i += 1)
                            ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
                            ->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($row1['qty']))
                            ->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])
                            ->setCellValueByColumnAndRow(4, $line, Yii::app()->format->formatCurrency($row1['netprice'] / $per))
                            ->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row1['PPN'] / $per))
                            ->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency(($row1['nominal'] + $row1['PPN']) / $per));
            $line++;

            $totalqty += $row1['qty'];
            $totalppn += $row1['PPN'] / $per;
            $totalnominal += ($row1['nominal'] + $row1['PPN']) / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1, $line, 'Total ' . $row['description'])
                ->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalqty))
                ->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($totalppn))
                ->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($totalnominal));
          $line++;
          $totalqty1 += $totalqty;
          $totalnominal1 += $totalnominal;
          $totalppn1 += $totalppn;
          $line += 1;
        }
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')
            ->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalqty1))
            ->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($totalppn1))
            ->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($totalnominal1));
        $this->getFooterXLS($this->phpExcel);
    }
  }
	//9
	public function RincianReturPembelianPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianreturpembelianperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $sql  = "	select distinct *
							from 
							(select a.grreturid,i.notagrreturno as grreturno,g.fullname as supplier,i.docdate as grreturdate,h.paycode							
							from grretur a
							join grreturdetail c on c.grreturid=a.grreturid
							join product d on d.productid=c.productid
							join podetail e on e.podetailid=c.podetailid
							join poheader f on f.poheaderid=e.poheaderid
							join addressbook g on g.addressbookid=f.addressbookid
							join paymentmethod h on h.paymentmethodid=f.paymentmethodid
							join notagrretur i on i.grreturid=a.grreturid
							where i.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'d','productcollectid')."
              ".getCompanyGroup($companyid,'f')." and 
							i.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
            ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
            ->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $line = 4;		

    foreach ($dataReader as $row)
    {
      $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0,$line,'Dokumen ')
                    ->setCellValueByColumnAndRow(1,$line,': '.$row['grreturno'])
                    ->setCellValueByColumnAndRow(4,$line,'Tanggal ')
                    ->setCellValueByColumnAndRow(5,$line,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
      $line++;

            $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0,$line,'Supplier ')
                    ->setCellValueByColumnAndRow(1,$line,': '.$row['supplier'])
                    ->setCellValueByColumnAndRow(4,$line,'T.O.P ')
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

      $sql1 = "select distinct *,(nominal+ppn) as netto
               from (select distinct b.productname,a.qty,c.netprice,(a.qty*c.netprice) as jumlah,a.itemnote,
               (
								select sum(b.netprice*a.qty) 
								from podetail b
								where b.podetailid=c.podetailid 
								and b.productid=c.productid
								) as nominal,
                (select nominal*i.taxvalue/100 from tax i where i.taxid=f.taxid) as ppn
							 from grreturdetail a
							 join product b on b.productid=a.productid
							 join podetail c on c.podetailid=a.podetailid
							 join poheader f on f.poheaderid = c.poheaderid
               ".getFieldTable($productcollectid,'b','productcollectid')."
							 join unitofmeasure d on d.unitofmeasureid=a.uomid
							 where a.grreturid = " . $row['grreturid'] . ")z";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
            $i=0;$totalqty=0;
            foreach ($dataReader1 as $row1)
            {
                $i+=1;
                $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,$i)
                        ->setCellValueByColumnAndRow(1,$line,$row1['productname'])						
                        ->setCellValueByColumnAndRow(2,$line,$row1['qty'])
                        ->setCellValueByColumnAndRow(3,$line,$row1['netprice']/$per)
                        ->setCellValueByColumnAndRow(4,$line,$row1['jumlah']/$per)
                        ->setCellValueByColumnAndRow(5,$line,$row1['itemnote']);
                $line++;

                $totalqty += $row1['qty'];
            }

            $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(1,$line,'Keterangan : '.$row1['itemnote'])	
                        ->setCellValueByColumnAndRow(2,$line,$totalqty) 
                        ->setCellValueByColumnAndRow(4,$line,'NOMINAL ')	
                        ->setCellValueByColumnAndRow(5,$line,$row1['nominal']/$per);
      $line++;

            $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(4,$line,'PPN ')	
                        ->setCellValueByColumnAndRow(5,$line,$row1['ppn']/$per) ;
      $line++;

            $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(4,$line,'NETTO ')	
                        ->setCellValueByColumnAndRow(5,$line,$row1['netto']/$per) ;
      $line+=3;
        }


        $this->getFooterXLS($this->phpExcel);
    }
	}
	//10
	public function RekapReturPembelianPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianperdokumen';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
      $sql  = "select distinct *,(nominal+ppn) as netto
						from
						(select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select f.notagrreturno as grreturno,f.docdate as grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
              ".getCompanyGroup($companyid,'b')." and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						f.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
      $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

          foreach ($dataReader as $row)
        $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
              ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
              ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      $line = 4;
          $i=0;$nominal=0;$ppn=0;$total=0;

          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,'No')
              ->setCellValueByColumnAndRow(1,$line,'Dokumen')
              ->setCellValueByColumnAndRow(2,$line,'Tanggal')
              ->setCellValueByColumnAndRow(3,$line,'Supplier')
              ->setCellValueByColumnAndRow(4,$line,'Nominal')
              ->setCellValueByColumnAndRow(5,$line,'PPN')
              ->setCellValueByColumnAndRow(6,$line,'Total');
        $line++;

      foreach ($dataReader as $row)
          {
              $i+=1;
                  $this->phpExcel->setActiveSheetIndex(0)
                          ->setCellValueByColumnAndRow(0,$line,$i)
                          ->setCellValueByColumnAndRow(1,$line,$row['grreturno'])						
                          ->setCellValueByColumnAndRow(2,$line,date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])))
                          ->setCellValueByColumnAndRow(3,$line,$row['supplier'])	
                          ->setCellValueByColumnAndRow(4,$line,$row['nominal'] / $per)
                          ->setCellValueByColumnAndRow(5,$line,$row['ppn']/$per)
                          ->setCellValueByColumnAndRow(6,$line,$row['netto']/$per);
                  $line++;
                  $nominal += $row['nominal'] / $per;
                  $ppn += $row['ppn'] / $per;
                  $total += $row['netto'] / $per;
          }
          $line+=1;
          $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')
                  ->setCellValueByColumnAndRow(4, $line,$nominal)
                  ->setCellValueByColumnAndRow(5, $line,$ppn)
                  ->setCellValueByColumnAndRow(6, $line,$total);
          $this->getFooterXLS($this->phpExcel);
      }
	}
	//11
	public function RekapReturPembelianPerSupplierXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianpersupplier';
    parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0) { $com=' and c.isextern = 1';} else {$com = ' and b.companyid = '.$companyid;}
    if($price==1)
    {
      $sql = "select supplier,taxid,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
            from (select distinct *,(nominal+ppn) as netto
						from (select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select f.notagrreturno as grreturno,f.docdate as grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
            {$com} and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						f.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z ) zz 
            order by grreturno) zzz group by supplier";
      $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
      
      foreach ($dataReader as $row)
        $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
        ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
      $line = 4;
      $i=0;$nominal=0;$total=0;$ppn=0;
      
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0,$line,'No')
        ->setCellValueByColumnAndRow(1,$line,'Supplier')
        ->setCellValueByColumnAndRow(2,$line,'Nominal')			
        ->setCellValueByColumnAndRow(3,$line,'PPN')
        ->setCellValueByColumnAndRow(4,$line,'Total');
        $line++;
      
      foreach ($dataReader as $row)
      {
        $i+=1;
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,$i)
              ->setCellValueByColumnAndRow(1,$line,$row['supplier'])					
              ->setCellValueByColumnAndRow(2,$line,$row['nominal'] / $per)
              ->setCellValueByColumnAndRow(3,$line,$row['ppn']/$per)
              ->setCellValueByColumnAndRow(4,$line,$row['netto']/$per);
          $line++;
        $nominal += $row['nominal']/$per;
        $ppn += $row['ppn']/$per;
        $total += $row['netto']/$per;	
      }
      $line+=1;
      $this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
				->setCellValueByColumnAndRow(2,$line,$nominal)
				->setCellValueByColumnAndRow(3,$line,$ppn)
				->setCellValueByColumnAndRow(4,$line,$total);
				
		$this->getFooterXLS($this->phpExcel);
        }
	}
	//12
	public function RekapReturPembelianPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianperbarang';
		parent::actionDownxls();		
      $price = getUserObjectValues($menuobject='purchasing');
      if($price==1)
      {
        $sql        = "select distinct h.materialgroupid, h.description
                    from grreturdetail a
                    join product b on b.productid=a.productid
                    join podetail c on c.podetailid=a.podetailid
                    join poheader d on d.poheaderid=c.poheaderid
                    join unitofmeasure e on e.unitofmeasureid=a.uomid
                    join grretur f on f.grreturid=a.grreturid
                    join productplant g on g.productid=a.productid
                    join materialgroup h on h.materialgroupid=g.materialgroupid
                    join unitofmeasure i on i.unitofmeasureid=a.uomid
                    join notagrretur j on j.grreturid=f.grreturid
                    where j.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and j.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')." ".getCompanyGroup($companyid,'d')."
                    group by productname";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        
        foreach ($dataReader as $row)
        
              $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
            ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
            ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line=4;
        $i=0;			
        
        foreach ($dataReader as $row)
        {
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,$line,'Divisi ')
            ->setCellValueByColumnAndRow(1,$line,': '.$row['description'])	;
          $line++;
        
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,'No')
              ->setCellValueByColumnAndRow(1,$line,'Nama Barang')
              ->setCellValueByColumnAndRow(2,$line,'Qty')			
              ->setCellValueByColumnAndRow(3,$line,'Nominal')
              ->setCellValueByColumnAndRow(4,$line,'PPN')
              ->setCellValueByColumnAndRow(5,$line,'Total');
          $line++;
          
          $sql1        = "select *,(nominal+ppn) as netto
                      from
                      (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
                      from
                      (select distinct b.productname,a.qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
                      from grreturdetail a
                      join product b on b.productid=a.productid
                      join podetail c on c.podetailid=a.podetailid
                      join poheader d on d.poheaderid=c.poheaderid
                      join unitofmeasure e on e.unitofmeasureid=a.uomid
                      join grretur f on f.grreturid=a.grreturid
                      join productplant g on g.productid=a.productid and g.slocid = a.slocid and g.unitofissue = c.unitofmeasureid
                      join materialgroup h on h.materialgroupid=g.materialgroupid
                      join unitofmeasure i on i.unitofmeasureid=a.uomid
                      join notagrretur j on j.grreturid=f.grreturid
                      where j.recordstatus = 3 and  b.productname like '%" . $product . "%' and j.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                      and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')." ".getCompanyGroup($companyid,'d')." and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $i=0;$totalqty=0;$ppn=0;$nominal=0;$total=0;
          
          foreach ($dataReader1 as $row1)
          {
            $i+=1;
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,$i)
                ->setCellValueByColumnAndRow(1,$line,$row1['productname'])			
                ->setCellValueByColumnAndRow(2,$line,$row1['qty'])
                ->setCellValueByColumnAndRow(3,$line,$row1['nominal'] / $per)
                ->setCellValueByColumnAndRow(4,$line,$row1['ppn']/$per)
                ->setCellValueByColumnAndRow(5,$line,$row1['netto']/$per);
            $line++;
            
            $totalqty += $row1['qty'];
            $ppn += $row1['ppn'] / $per;
            $nominal += $row1['nominal'] / $per;
            $total += $row1['netto'] / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(1,$line,'Total : '.$row['description'])	
              ->setCellValueByColumnAndRow(2,$line,$totalqty) 
              ->setCellValueByColumnAndRow(3,$line,$nominal)	
              ->setCellValueByColumnAndRow(4,$line,$ppn)
              ->setCellValueByColumnAndRow(5,$line,$total);
          $line+=2;
        }
		
		  $this->getFooterXLS($this->phpExcel);
        }
	}
	//13
	public function RincianSelisihPembelianReturPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianselisihpembelianreturperdokumen';
		parent::actionDownxls();	
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
      $totalallqty = 0;
      $totalallrp  = 0;
      $totalinvoice =0;
      $sql          = "select distinct a.invoiceapid,b.grheaderid,ifnull(a.invoiceno,0) as invno,a.invoicedate,d.paydays,b.grno,b.grdate,
						e.fullname,c.pono,c.docdate as podate,c.poheaderid,c.companyid
						from invoiceap a
						left join grheader b on b.grheaderid=a.grheaderid
						left join poheader c on c.poheaderid=b.poheaderid
						left join paymentmethod d on d.paymentmethodid=c.paymentmethodid
						left join addressbook e on e.addressbookid=c.addressbookid
            left join podetail f on f.poheaderid = c.poheaderid
            join product g on g.productid = f.productid
						where a.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
            ".getCompanyGroup($companyid,'c')." and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by receiptdate,grno";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line = 4;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No. Invoice')->setCellValueByColumnAndRow(1, $line, ': ' . $row['invno'])->setCellValueByColumnAndRow(2, $line, 'No. STTB')->setCellValueByColumnAndRow(3, $line, ': ' . $row['grno'])->setCellValueByColumnAndRow(5, $line, 'No. PO')->setCellValueByColumnAndRow(6, $line, ': ' . $row['pono']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'Tanggal')->setCellValueByColumnAndRow(1, $line, ': ' . $row['invoicedate'])->setCellValueByColumnAndRow(2, $line, 'Tanggal')->setCellValueByColumnAndRow(3, $line, ': ' . $row['grdate'])->setCellValueByColumnAndRow(5, $line, 'Tanggal')->setCellValueByColumnAndRow(6, $line, ': ' . $row['podate']);
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'T.O.P')->setCellValueByColumnAndRow(1, $line, ': ' . $row['paydays'])->setCellValueByColumnAndRow(2, $line, 'Supplier')->setCellValueByColumnAndRow(3, $line, ': ' . $row['fullname'])->setCellValueByColumnAndRow(5, $line, '')->setCellValueByColumnAndRow(6, $line, '');
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Barang')->setCellValueByColumnAndRow(2, $line, 'Qty')->setCellValueByColumnAndRow(3, $line, 'Satuan')->setCellValueByColumnAndRow(4, $line, 'Harga')->setCellValueByColumnAndRow(5, $line, 'Jumlah')->setCellValueByColumnAndRow(6, $line, 'Keterangan');
          $line++;
          $sql1        = "select distinct a.grdetailid,g.productname,a.qty,h.uomcode,c.netprice,(a.qty * c.netprice) as jumlah,
							a.itemtext,i.taxvalue,((a.qty * c.netprice)*(i.taxvalue/100)) as PPN,b.amount 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							where b.grheaderid = " . $row['grheaderid']." ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $total       = 0;
          $i           = 0;
          $totalqty    = 0;
          foreach ($dataReader1 as $row1) {
            $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row1['productname'])->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($row1['qty']))->setCellValueByColumnAndRow(3, $line, $row1['uomcode'])->setCellValueByColumnAndRow(4, $line, Yii::app()->format->formatCurrency($row1['netprice'] / $per))->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row1['jumlah'] / $per))->setCellValueByColumnAndRow(6, $line, $row1['itemtext']);
            $line++;
            $totalqty += $row1['qty'];
            $total += $row1['jumlah'] / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Total')->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalqty))->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($total));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'Keterangan : ' . $row1['itemtext'])->setCellValueByColumnAndRow(5, $line, 'NOMINAL')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($total));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'PPN')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($row1['PPN'] / $per));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'NETTO')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($total + ($row1['PPN'] / $per)));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'ADJUSMENT')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency(($row1['amount'] / $per) - ($total + ($row1['PPN'] / $per))));
          $line++;
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $line, 'NILAI INVOICE')->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency(($row1['amount'] / $per)));
          $line += 2;
          $totalallqty += $totalqty;
          $totalallrp += $total;
                $totalinvoice += $row1['amount'] / $per;
        }
        $line += 3;

        $sql  = "	select distinct *
							from 
							(select a.grreturid,a.grreturno,g.fullname as supplier,a.grreturdate,h.paycode							
							from grretur a
							join grreturdetail c on c.grreturid=a.grreturid
							join product d on d.productid=c.productid
							join podetail e on e.podetailid=c.podetailid
							join poheader f on f.poheaderid=e.poheaderid
							join addressbook g on g.addressbookid=f.addressbookid
							join paymentmethod h on h.paymentmethodid=f.paymentmethodid
							join notagrretur i on i.grreturid=a.grreturid
							where i.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' ".getFieldTable($productcollectid,'d','productcollectid')." ".getCompanyGroup($companyid,'f')." and a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

            foreach ($dataReader as $row)
            {
                $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,'Dokumen ')
                        ->setCellValueByColumnAndRow(1,$line,': '.$row['grreturno'])
                        ->setCellValueByColumnAndRow(4,$line,'Tanggal ')
                        ->setCellValueByColumnAndRow(5,$line,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
          $line++;

                $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,'Supplier ')
                        ->setCellValueByColumnAndRow(1,$line,': '.$row['supplier'])
                        ->setCellValueByColumnAndRow(4,$line,'T.O.P ')
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

                $sql1 = "select distinct *,(nominal+ppn) as netto
               from (select distinct b.productname,a.qty,c.netprice,(a.qty*c.netprice) as jumlah,a.itemnote,
               (
								select sum(bx.netprice*a.qty) 
								from podetail bx
								where bx.podetailid=c.podetailid 
								and bx.productid=c.productid
								) as nominal,
                (select nominal*i.taxvalue/100 from tax i where i.taxid=f.taxid) as ppn
							 from grreturdetail a
							 join product b on b.productid=a.productid
							 join podetail c on c.podetailid=a.podetailid
							 join poheader f on f.poheaderid = c.poheaderid
							 join unitofmeasure d on d.unitofmeasureid=a.uomid
               ".getFieldTable($productcollectid,'b','productcollectid')."
							 where a.grreturid = " . $row['grreturid'] . ")z";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                $i=0;$totalqty=0;
                foreach ($dataReader1 as $row1)
                {
                    $i+=1;
                    $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(0,$line,$i)
                            ->setCellValueByColumnAndRow(1,$line,$row1['productname'])						
                            ->setCellValueByColumnAndRow(2,$line,$row1['qty'])
                            ->setCellValueByColumnAndRow(3,$line,$row1['netprice']/$per)
                            ->setCellValueByColumnAndRow(4,$line,$row1['jumlah']/$per)
                            ->setCellValueByColumnAndRow(5,$line,$row1['itemnote']);
                    $line++;

                    $totalqty += $row1['qty'];
                }

                $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(1,$line,'Keterangan : '.$row1['itemnote'])	
                            ->setCellValueByColumnAndRow(2,$line,$totalqty) 
                            ->setCellValueByColumnAndRow(4,$line,'NOMINAL ')	
                            ->setCellValueByColumnAndRow(5,$line,$row1['nominal']/$per);
          $line++;

                $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(4,$line,'PPN ')	
                            ->setCellValueByColumnAndRow(5,$line,$row1['ppn']/$per) ;
          $line++;

                $this->phpExcel->setActiveSheetIndex(0)
                            ->setCellValueByColumnAndRow(4,$line,'NETTO ')	
                            ->setCellValueByColumnAndRow(5,$line,$row1['netto']/$per) ;
          $line+=3;
            }
            $this->getFooterXLS($this->phpExcel);
        }
	}
	//14
	public function RekapSelisihPembelianReturPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturperdokumen';
		parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($price==1)
    {
        $totalnominal = 0;
        $totalppn     = 0;
        $totalnetto   = 0;
        $sql        = "select distinct invoiceno,grno,receiptdate,fullname,sum(jum) as jumlah,sum(pajak) as PPN,itemtext from
							(select distinct a.grdetailid,b.grheaderid,j.grno,b.invoiceno,b.receiptdate,f.fullname,(a.qty * c.netprice) as jum,
							a.itemtext,((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							group by invoiceno,grheaderid order by grno";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($dataReader as $row)
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, GetCompanyCode($companyid));
        $line = 4;
        $i    = 0;
        $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'No. Invoice')->setCellValueByColumnAndRow(2, $line, 'No. STTB')->setCellValueByColumnAndRow(3, $line, 'Tanggal')->setCellValueByColumnAndRow(4, $line, 'Supplier')->setCellValueByColumnAndRow(5, $line, 'Nominal')->setCellValueByColumnAndRow(6, $line, 'PPN')->setCellValueByColumnAndRow(7, $line, 'Netto')->setCellValueByColumnAndRow(8, $line, 'Keterangan');
        $line++;
        foreach ($dataReader as $row) {
          $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['invoiceno'])->setCellValueByColumnAndRow(2, $line, $row['grno'])->setCellValueByColumnAndRow(3, $line, $row['receiptdate'])->setCellValueByColumnAndRow(4, $line, $row['fullname'])->setCellValueByColumnAndRow(5, $line, Yii::app()->format->formatCurrency($row['jumlah'] / $per))->setCellValueByColumnAndRow(6, $line, Yii::app()->format->formatCurrency($row['PPN'] / $per))->setCellValueByColumnAndRow(7, $line, Yii::app()->format->formatCurrency(($row['jumlah'] + $row['PPN']) / $per))->setCellValueByColumnAndRow(8, $line, $row['itemtext']);
          $line++;
          $totalnominal += $row['jumlah'] / $per;
          $totalppn += $row['PPN'] / $per;
          $totalnetto += ($row['jumlah'] + $row['PPN']) / $per;
        }
        $sql1  = "select distinct *,(nominal+ppn) as netto
						from
						(select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
						from
						(select a.grreturno,a.grreturdate,c.fullname as supplier,b.taxid,
						(
						select sum(d.qty*f.netprice) 
						from grreturdetail d
						join podetail f on f.podetailid=d.podetailid
						where d.grreturid=a.grreturid
						) as nominal
						from grretur a
						join poheader b on b.poheaderid=a.poheaderid                   
						join addressbook c on c.addressbookid=b.addressbookid
						join podetail d on d.poheaderid = b.poheaderid
						join product e on e.productid = d.productid
            join notagrretur f on f.grreturid=a.grreturid
						where f.recordstatus = 3 ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
        $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

        foreach ($dataReader1 as $row1)
        {
            $i+=1;
                $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,$i)
                        ->setCellValueByColumnAndRow(1,$line,'-')					
                        ->setCellValueByColumnAndRow(2,$line,$row1['grreturno'])					
                        ->setCellValueByColumnAndRow(3,$line,$row1['grreturdate'])
                        ->setCellValueByColumnAndRow(4,$line,$row1['supplier'])
                        ->setCellValueByColumnAndRow(5,$line,-$row1['nominal']/$per)
                        ->setCellValueByColumnAndRow(6,$line,-$row1['ppn']/$per)
                        ->setCellValueByColumnAndRow(7,$line,-$row1['netto']/$per);
                $line++;

            $totalnominal -= $row1['nominal'] / $per;
      $totalppn -= $row1['ppn'] / $per;
      $totalnetto -= $row1['netto'] / $per;
        }

        $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(4, $line, 'GRAND TOTAL')
                ->setCellValueByColumnAndRow(5, $line,$totalnominal)
                ->setCellValueByColumnAndRow(6, $line,$totalppn)
                ->setCellValueByColumnAndRow(7, $line,$totalnetto);

        $this->getFooterXLS($this->phpExcel);
    }
	}
	//15
	public function RekapSelisihPembelianReturPerSupplierXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturpersupplier';
		parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
     if($companyid==0){$com = ' and a.isextern = 1'; $company = ' and z.isgroup = 1';}else { $com = ''; $company = ' and z.companyid = '.$companyid;}
    if($price==1)
    {
        $sql          = "select *
                    from (select fullname,nominal-nominalretur as nom, ppn-ppnretur as pajak, netto-nettoretur as total
                    from (select *,nominal+ppn as netto,nominalretur+ppnretur as nettoretur
                    from (select a.fullname,
                    ifnull((select sum(b.qty * e.netprice)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominal,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid 
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppn,
                    ifnull((select sum(b.qty * e.netprice)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominalretur,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join company z on z.companyid = d.companyid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 {$company} and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppnretur
                    from addressbook a
                    where a.isvendor=1 {$com}
                    and a.fullname like '%".$supplier."%') z) zz) zzz
                    where nom <> 0 or pajak <> 0 or total <> 0
                    order by fullname";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

            $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
                        ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
                        ->setCellValueByColumnAndRow(4, 1, GetCompanyCode($companyid));
            $line=4;
            $i=0;$totalnominal=0;$totalppn=0;$total=0;

            $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,'No')
                        ->setCellValueByColumnAndRow(1,$line,'Nama Supplier')
                        ->setCellValueByColumnAndRow(2,$line,'Nominal')			
                        ->setCellValueByColumnAndRow(3,$line,'PPN')
                        ->setCellValueByColumnAndRow(4,$line,'Total');
        $line++;

        foreach ($dataReader as $row)
        {
            $i+=1;
                $this->phpExcel->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow(0,$line,$i)
                        ->setCellValueByColumnAndRow(1,$line,$row['fullname'])					
                        ->setCellValueByColumnAndRow(2,$line,$row['nom'] / $per)
                        ->setCellValueByColumnAndRow(3,$line,$row['pajak']/$per)
                        ->setCellValueByColumnAndRow(4,$line,$row['total']/$per);
                $line++;

            $totalnominal += $row['nom'] / $per;
      $totalppn += $row['pajak'] / $per;
      $total += $row['total'] / $per;
        }
        $line+=2;
        $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1,$line,'GRAND TOTAL')
                ->setCellValueByColumnAndRow(2,$line,$totalnominal)
                ->setCellValueByColumnAndRow(3,$line,$totalppn)
                ->setCellValueByColumnAndRow(4,$line,$total);
        $line++;

        $this->getFooterXLS($this->phpExcel);
    }
	}
	//16
	public function RekapSelisihPembelianReturPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturperbarang';
		parent::actionDownxls();
    $price = getUserObjectValues($menuobject='purchasing');
    if($companyid==0){$com = ' f.isgroup = 1';}else {$com = ' f.companyid = '.$companyid;}
    if($price==1)
    {
        $sql   = "select distinct materialgroupid, description
              from (select distinct a.materialgroupid,a.description
              from materialgroup a
              join productplant b on b.materialgroupid = a.materialgroupid
              join product c on c.productid = b.productid
              join sloc d on d.slocid = b.slocid
              join plant e on e.plantid = d.plantid
              join company f on f.companyid = e.companyid
              where {$com} and b.productid in
              (select distinct a.productid 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join grheader j on j.grheaderid=b.grheaderid
							where b.recordstatus=3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')
            union
              select distinct h.materialgroupid, h.description
              from grreturdetail a
              join product b on b.productid=a.productid
              join podetail c on c.podetailid=a.podetailid
              join poheader d on d.poheaderid=c.poheaderid
              join unitofmeasure e on e.unitofmeasureid=a.uomid
              join grretur f on f.grreturid=a.grreturid
              join productplant g on g.productid=a.productid
              join materialgroup h on h.materialgroupid=g.materialgroupid
              join unitofmeasure i on i.unitofmeasureid=a.uomid
              join notagrretur j on j.grreturid=f.grreturid
              where j.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getFieldTable($productcollectid,'b','productcollectid')."
              ".getCompanyGroup($companyid,'d').") z";
        $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        
        $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
              ->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
              ->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
        $line=4;
        $totalqty1     = 0;
        $totalppn1     = 0;
        $totalnominal1 = 0;
        $total1        = 0;
        
        foreach ($dataReader as $row)
        {
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,'Divisi ')
              ->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
          $line++;
          
          $this->phpExcel->setActiveSheetIndex(0)
              ->setCellValueByColumnAndRow(0,$line,'No')
              ->setCellValueByColumnAndRow(1,$line,'Nama Barang')
              ->setCellValueByColumnAndRow(2,$line,'Qty')				
              ->setCellValueByColumnAndRow(3,$line,'Nominal')
              ->setCellValueByColumnAndRow(4,$line,'PPN')
              ->setCellValueByColumnAndRow(5,$line,'Total');
          $line++;
          
          $sql1 = "select distinct productname, sum(qty) as totalqty, uomcode, sum(nominal) as nom, sum(ppn) as pajak, sum(nominal+ppn) as jumlah
              from (select g.productname,sum(a.qty) as qty,h.uomcode,sum(a.qty * c.netprice) as nominal,sum((a.qty * c.netprice)*(i.taxvalue/100)) as ppn 
							from grdetail a
							left join invoiceap b on b.grheaderid=a.grheaderid
							left join podetail c on c.podetailid=a.podetailid
							left join poheader d on d.poheaderid=b.poheaderid
							left join paymentmethod e on e.paymentmethodid=d.paymentmethodid
							left join addressbook f on f.addressbookid=d.addressbookid
							left join product g on g.productid=a.productid
							left join unitofmeasure h on h.unitofmeasureid=a.unitofmeasureid
							left join tax i on i.taxid=d.taxid
							left join productplant j on j.productid=a.productid and j.slocid=a.slocid
							where b.recordstatus = 3 ".getFieldTable($productcollectid,'g','productcollectid')."
              ".getCompanyGroup($companyid,'d')." and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
							and j.recordstatus = 1
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname
            union
              select distinct productname,-qty,uomcode,-nominal,-ppn
              from
              (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
              from
              (select b.productname,(a.qty) as qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
              from grreturdetail a
              join product b on b.productid=a.productid
              join podetail c on c.podetailid=a.podetailid
              join poheader d on d.poheaderid=c.poheaderid
              join unitofmeasure e on e.unitofmeasureid=a.uomid
              join grretur f on f.grreturid=a.grreturid
              join productplant g on g.productid=a.productid
              join materialgroup h on h.materialgroupid=g.materialgroupid
              join unitofmeasure i on i.unitofmeasureid=a.uomid
              join notagrretur j on j.grreturid=f.grreturid
              where j.recordstatus = 3 and g.recordstatus = 1 and b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = " . $companyid . " and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz
              ) x group by productname";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
          $i=0;$totalqty=0;$totalnominal=0;$totalppn=0;$total=0;
          
          foreach ($dataReader1 as $row1)
          {
            $i+=1;
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,$i)
                ->setCellValueByColumnAndRow(1,$line,$row1['productname'])					
                ->setCellValueByColumnAndRow(2,$line,$row1['totalqty'])
                ->setCellValueByColumnAndRow(3,$line,$row1['nom']/$per)
                ->setCellValueByColumnAndRow(4,$line,$row1['pajak']/$per)
                ->setCellValueByColumnAndRow(5,$line,$row1['jumlah']/$per);
            $line++;
            
            $totalqty += $row1['totalqty'];
            $totalnominal += $row1['nom'] / $per;
            $totalppn += $row1['pajak'] / $per;
            $total += $row1['jumlah'] / $per;
          }
          $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, 'TOTAL')
            ->setCellValueByColumnAndRow(2, $line,$totalqty)
            ->setCellValueByColumnAndRow(3, $line,$totalnominal)
            ->setCellValueByColumnAndRow(4, $line,$totalppn)
            ->setCellValueByColumnAndRow(5, $line,$total);
          $totalqty1 += $totalqty;
          $totalnominal1 += $totalnominal;
          $totalppn1 += $totalppn;
          $total1 += $total;
          $line+=2;
        }
        $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(1, $line, 'GRAMD TOTAL')
        ->setCellValueByColumnAndRow(2, $line,$totalqty1)
        ->setCellValueByColumnAndRow(3, $line,$totalnominal1)
        ->setCellValueByColumnAndRow(4, $line,$totalppn1)
        ->setCellValueByColumnAndRow(5, $line,$total1);
		$this->getFooterXLS($this->phpExcel);
        }
	}
	//17
	public function PendinganPOPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'pendinganpoperdokumen';
		parent::actionDownxls();
		$sql = "select *
		from (select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate, b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.pono is not null ".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'a')." and a.recordstatus=5
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono) z
						where poqty > grqty
		";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$totalallqty=0;$totalnetto1=0;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(7, 1, GetCompanyCode($companyid));
		$line=4;
    foreach ($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $line, 'No. PO')
					->setCellValueByColumnAndRow(1, $line, ': ' . $row['pono'])
					->setCellValueByColumnAndRow(5, $line, 'Tgl. PO')
					->setCellValueByColumnAndRow(6, $line, ': ' . $row['docdate']);
      $line++;
			
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $line, 'Supplier')
					->setCellValueByColumnAndRow(1, $line, ': ' . $row['fullname'])
					->setCellValueByColumnAndRow(5, $line, 'T.O.P.')
					->setCellValueByColumnAndRow(6, $line, ': ' . $row['paydays']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $line, 'No')
					->setCellValueByColumnAndRow(1, $line, 'Nama Barang')
					->setCellValueByColumnAndRow(2, $line, 'Qty')
					->setCellValueByColumnAndRow(3, $line, 'Qty GR')
					->setCellValueByColumnAndRow(4, $line, 'Satuan')
					->setCellValueByColumnAndRow(5, $line, 'Harga')
					->setCellValueByColumnAndRow(6, $line, 'Jumlah')
					->setCellValueByColumnAndRow(7, $line, 'Keterangan');
      $line++;
			
			$sql1 = "select *,poqty-grqty as sisa,(poqty-grqty)*netprice as jumlah,(taxvalue/100)*((poqty-grqty)*netprice) as ppn
			from (select b.productname,a.poqty,a.qtyres,c.uomcode,a.netprice,a.itemtext,e.taxvalue,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
							from podetail a
							join product b on b.productid=a.productid
							join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
							join poheader d on d.poheaderid=a.poheaderid
							join tax e on e.taxid=d.taxid
							where b.productname like '%" . $product . "%' 
              ".getFieldTable($productcollectid,'b','productcollectid')."
							and a.poheaderid = " . $row['poheaderid'] . ") z
			where poqty > grqty
			";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalgrqty=0;$totalnominal=0;$totalnetto=0;$totalppn=0;
			foreach ($dataReader1 as $row1)
			{
				$i += 1;
        $this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0, $line, $i)
						->setCellValueByColumnAndRow(1, $line, $row1['productname'])
						->setCellValueByColumnAndRow(2, $line, $row1['poqty'])
						->setCellValueByColumnAndRow(3, $line, $row1['grqty'])
						->setCellValueByColumnAndRow(4, $line, $row1['uomcode'])
						->setCellValueByColumnAndRow(5, $line, $row1['netprice'] / $per)
						->setCellValueByColumnAndRow(6, $line, $row1['jumlah'] / $per)
						->setCellValueByColumnAndRow(7, $line, $row1['itemtext']);
        $line++;
				$totalqty += $row1['poqty'];
				$totalgrqty += $row1['grqty'];
        $totalnominal += ($row1['jumlah']) / $per;        
        $totalnetto += $row1['jumlah'] / $per;
				$totalppn += $row1['ppn'] / $per;
				
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(1, $line, 'Total')
				->setCellValueByColumnAndRow(2, $line,$totalqty)
				->setCellValueByColumnAndRow(3, $line,$totalgrqty)
				->setCellValueByColumnAndRow(5, $line,'NOMINAL')
				->setCellValueByColumnAndRow(6, $line,$totalnominal);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)				
				->setCellValueByColumnAndRow(5, $line,'PPN')
				->setCellValueByColumnAndRow(6, $line,$totalppn);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)				
				->setCellValueByColumnAndRow(5, $line,'NETTO')
				->setCellValueByColumnAndRow(6, $line,$totalnetto);
			$line+=2;
			
			$totalallqty += ($totalqty - $totalgrqty);
			$totalnetto1 += $totalnetto;
		}
		$this->phpExcel->setActiveSheetIndex(0)				
				->setCellValueByColumnAndRow(1, $line,'Total Qty')
				->setCellValueByColumnAndRow(3, $line,$totalallqty)
				->setCellValueByColumnAndRow(5, $line,'Total Netto')
				->setCellValueByColumnAndRow(6, $line,$totalnetto1);
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//18
	public function RincianPendinganPOPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianpendinganpoperbarang';
		parent::actionDownxls();
		$subtotalqty=0;$subtotalqtyoutput=0;$subtotalselisih=0;
		$sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(6, 1, GetCompanyCode($companyid));
		$line=4;
    foreach ($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'GUDANG ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
      $line++;
			
			$sql1           = "select distinct productname,productid from (
				select distinct c.productname,c.productid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5 
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%' and d.slocid = " . $row['slocid'] . "
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totalqty=0;$totalqtyoutput=0;$totalselisih=0;
			
			foreach ($dataReader1 as $row1)
			{
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Nama Barang ')
					->setCellValueByColumnAndRow(1,$line,': '.$row1['productname']);
				$line++;
				
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'No PO')
						->setCellValueByColumnAndRow(2,$line,'Tgl PO')				
						->setCellValueByColumnAndRow(3,$line,'Satuan')
						->setCellValueByColumnAndRow(4,$line,'Qty PO')
						->setCellValueByColumnAndRow(5,$line,'Qty GR')
						->setCellValueByColumnAndRow(6,$line,'Selisih');
				$line++;
				
				$sql2        = "select *
				from (select pono, docdate, uomcode, poqty, grqty, (poqty-grqty) as selisih
						from (select b.pono, b.docdate, d.uomcode, a.poqty, 
						ifnull((select sum(c.qty) 
						from grdetail c 
						join grheader h on h.grheaderid=c.grheaderid 
						where h.recordstatus = 3 and c.podetailid=a.podetailid),0) as grqty
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and a.productid = " . $row1['productid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty) zz";
        $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				$i=0;$jumlahqty=0;$jumlahqtyoutput=0;$jumlahselisih=0;
				
				foreach ($dataReader2 as $row2)
				{
					$i+=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row2['pono'])					
							->setCellValueByColumnAndRow(2,$line,$row2['docdate'])
							->setCellValueByColumnAndRow(3,$line,$row2['uomcode'])
							->setCellValueByColumnAndRow(4,$line,$row2['poqty'])
							->setCellValueByColumnAndRow(5,$line,$row2['grqty'])
							->setCellValueByColumnAndRow(6,$line,$row2['selisih']);
					$line++;
					
					$jumlahqty += $row2['poqty'];
          $jumlahqtyoutput += $row2['grqty'];
          $jumlahselisih += $row2['selisih'];
				}
				$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1, $line, 'JUMLAH '.$row1['productname'])
						->setCellValueByColumnAndRow(4, $line,$jumlahqty)
						->setCellValueByColumnAndRow(5, $line,$jumlahqtyoutput)
						->setCellValueByColumnAndRow(6, $line,$jumlahselisih) ;
				$line++;
				
				$totalqty += $jumlahqty;
        $totalqtyoutput += $jumlahqtyoutput;
        $totalselisih += $jumlahselisih;
			}
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1, $line, 'TOTAL GUDANG '.$row['description'])
						->setCellValueByColumnAndRow(4, $line,$totalqty)
						->setCellValueByColumnAndRow(5, $line,$totalqtyoutput)
						->setCellValueByColumnAndRow(6, $line,$totalselisih) ;
			$line+=2;
			
			$subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
		}
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL ')
						->setCellValueByColumnAndRow(4, $line,$subtotalqty)
						->setCellValueByColumnAndRow(5, $line,$subtotalqtyoutput)
						->setCellValueByColumnAndRow(6, $line,$subtotalselisih) ;
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//19
	public function RekapPendinganPOPerBarangXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekappendinganpoperbarang';
		parent::actionDownxls();
		$subtotalqty=0;$subtotalqtyoutput=0;$subtotalselisih=0;
		$sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = 5
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
		$line=4;
    foreach ($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'GUDANG ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
      $line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Nama Barang')
						->setCellValueByColumnAndRow(2,$line,'Satuan')				
						->setCellValueByColumnAndRow(3,$line,'Qty PO')
						->setCellValueByColumnAndRow(4,$line,'Qty GR')						
						->setCellValueByColumnAndRow(5,$line,'Selisih');
			$line++;
			
			$sql1           = "select *
				from (select distinct productname, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
						from (select e.productname, d.uomcode, a.poqty, 
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5 
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty
						group by productname) zz";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalqtyoutput=0;$totalselisih=0;
			foreach ($dataReader1 as $row1)
			{
				$i+=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row1['productname'])							
							->setCellValueByColumnAndRow(2,$line,$row1['uomcode'])
							->setCellValueByColumnAndRow(3,$line,$row1['poqty'])
							->setCellValueByColumnAndRow(4,$line,$row1['grqty'])
							->setCellValueByColumnAndRow(5,$line,$row1['selisih']);
					$line++;
					
				$totalqty += $row1['poqty'];
        $totalqtyoutput += $row1['grqty'];
        $totalselisih += $row1['selisih'];
			}
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1, $line, 'TOTAL GUDANG '.$row['description'])
						->setCellValueByColumnAndRow(3, $line,$totalqty)
						->setCellValueByColumnAndRow(4, $line,$totalqtyoutput)
						->setCellValueByColumnAndRow(5, $line,$totalselisih) ;
			$line+=2;
			
			$subtotalqty += $totalqty;
      $subtotalqtyoutput += $totalqtyoutput;
      $subtotalselisih += $totalselisih;
		}
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')
						->setCellValueByColumnAndRow(3, $line,$subtotalqty)
						->setCellValueByColumnAndRow(4, $line,$subtotalqtyoutput)
						->setCellValueByColumnAndRow(5, $line,$subtotalselisih) ;
		$line+=2;
		
		$this->getFooterXLS($this->phpExcel);
	}
	//21
	public function RekapPembelianPerBarangPerTanggalXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'RekapPembelianPerBarangPerTanggal';
		parent::actionDownxls();
		$sql        = "select distinct g.productid,g.productname
								from grdetail a
								join grheader b on b.grheaderid=a.grheaderid
								join podetail c on c.podetailid=a.podetailid
								join poheader d on d.poheaderid=c.poheaderid and d.poheaderid=b.poheaderid
								join company e on e.companyid=d.companyid
								join addressbook f on f.addressbookid=d.addressbookid
								join product g on g.productid=a.productid
								where b.recordstatus = 3 ".getFieldTable($productcollectid,'g','productcollectid')."
                ".getCompanyGroup($companyid,'d')." and f.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%' and b.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' AND '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
								order by productname ";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
		$line=4;
    foreach ($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'Nama Barang ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['productname']);
      $line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'No')
						->setCellValueByColumnAndRow(1,$line,'Tanggal')
						->setCellValueByColumnAndRow(2,$line,'Harga');
			$line++;
			
			$sql1        = "select a.delvdate, a.netprice 
                    from podetail a
                    join poheader b on a.poheaderid=b.poheaderid
                    WHERE delvdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' AND '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' ".getCompanyGroup($companyid,'b')." and productid=".$row['productid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalqtyoutput=0;$totalselisih=0;
			foreach ($dataReader1 as $row1)
			{
				$i+=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0,$line,$i)
							->setCellValueByColumnAndRow(1,$line,$row1['delvdate'])							
							->setCellValueByColumnAndRow(2,$line,$row1['netprice']);
				$line+=1;
			}
		
			$line+=1;
			
		
		}
		
		$line+=2;
    
		$this->getFooterXLS($this->phpExcel);
	}
	//22    
	public function LaporanPembelianPerSupplierPerBulanPerTahunXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
		$this->menuname='laporanpembelianpersupplierperbulanpertahun';
		parent::actionDownxls();
		$price = getUserObjectValues($menuobject='purchasing');
        if($price==1)$i=0;
            { $totaljanuari=0;$totalfebruari=0;$totalmaret=0;$totalapril=0;$totalmei=0;$totaljuni=0;$totaljuli=0;$totalagustus=0;$totalseptember=0;$totaloktober=0;$totalnopember=0;$totaldesember=0;$totaljumlah=0;
            $sql = "select * from
					(select z.fullname,
					(select sum(pajak+nom) from 
					(select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
						((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
						from grdetail a
						left join invoiceap b on b.grheaderid=a.grheaderid
						left join podetail c on c.podetailid=a.podetailid
						left join poheader d on d.poheaderid=b.poheaderid
						left join addressbook f on f.addressbookid=d.addressbookid
						left join product g on g.productid=a.productid
						left join tax i on i.taxid=d.taxid
						where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')." and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=1 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as januari,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=2 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as februari,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=3 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as maret,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=4 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as april,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=5 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as mei,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=6 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as juni,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=7 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as juli,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=8 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as agustus,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=9 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as september,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=10 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as oktober,

          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=11 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as november,
          (select sum(pajak+nom) from 

          (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  month(b.receiptdate)=12 and year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as desember,
          (select sum(pajak+nom) from 
                    (select distinct f.addressbookid, f.isvendor, a.grdetailid,f.fullname,a.qty,c.netprice,(a.qty * c.netprice) as nom,
                      ((a.qty * c.netprice)*(i.taxvalue/100)) as pajak 
                      from grdetail a
                      left join invoiceap b on b.grheaderid=a.grheaderid
                      left join podetail c on c.podetailid=a.podetailid
                      left join poheader d on d.poheaderid=b.poheaderid
                      left join addressbook f on f.addressbookid=d.addressbookid
                      left join product g on g.productid=a.productid
                      left join tax i on i.taxid=d.taxid
                      where b.recordstatus = 3 {$com} ".getFieldTable($productcollectid,'g','productcollectid')."  and g.productname like '%{$product}%' and f.fullname like '%{$supplier}%' and  year(b.receiptdate)=year('". date(Yii::app()->params['datetodb'], strtotime($startdate))."')) zx where zx.addressbookid = z.addressbookid and zx.isvendor=1  
          group by fullname order by fullname) as jumlah
					from addressbook z 
					where z.recordstatus=1 {$supp} and z.isvendor=1 and z.fullname is not null order by fullname asc) zz
					where zz.jumlah <> 0";

            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
                ->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
                ->setCellValueByColumnAndRow(6,1,GetCompanyCode($companyid));
            $line=4;

            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,'No.')
                ->setCellValueByColumnAndRow(1,$line,'Supplier')
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
                ->setCellValueByColumnAndRow(12,$line,'November')
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
                    ->setCellValueByColumnAndRow(12,$line,$row['november']/$per)
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
                $totalnopember += $row['november']/$per;
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
	}    
	//26
	public function RincianPendinganPOPerBarangPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
			$this->menuname='dailymonitoringPO';
			parent::actionDownxls();
			
			$subtotalqty = 0;
			$subtotalqtygr = 0;
			$subtotalselisih = 0;
			$sql               = "select distinct description,slocid
				from (select distinct d.description,d.slocid,b.poqty,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = b.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty
				from poheader a
				join podetail b on b.poheaderid = a.poheaderid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join addressbook e on e.addressbookid = a.addressbookid
				where a.recordstatus = getwfmaxstatbywfname('apppo')
				".getFieldTable($productcollectid,'c','productcollectid')."
        ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty";
			
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
			
			$line=3;
			
			foreach($dataReader as $row)
			{
					
          $sql1           = "select distinct pono, docdate, productname, uomcode, (poqty) as poqty, (grqty) as grqty, (poqty-grqty) as selisih,netprice
						from (select e.productname, d.uomcode, a.poqty, b.pono, b.docdate,
				IFNULL((select sum(ifnull(a1.qty,0)) 
				from grdetail a1 
				join grheader b1 on b1.grheaderid=a1.grheaderid 
				where b1.recordstatus = 3 and a1.podetailid = a.podetailid and b1.grdate <= '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as grqty,a.netprice
						from podetail a
						join poheader b on b.poheaderid = a.poheaderid
						join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
						join product e on e.productid = a.productid
						join addressbook f on f.addressbookid = b.addressbookid
						join sloc g on g.slocid = a.slocid
						where b.recordstatus = 5 
						".getFieldTable($productcollectid,'e','productcollectid')."
            ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty ";
					
					$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
					
					$totalqty = 0;
					$totalqtygr = 0;
					$totalselisih = 0;
					
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0, $line, 'GUDANG : ')
							->setCellValueByColumnAndRow(1, $line, $row['description']);
					$line++;
					
					$i=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0, $line, 'No ')
							->setCellValueByColumnAndRow(1, $line, 'NO. PO ')
							->setCellValueByColumnAndRow(2, $line, 'TGL. PO ')
							->setCellValueByColumnAndRow(3, $line, 'Nama Barang ')
							->setCellValueByColumnAndRow(4, $line, 'Qty PO ')
							->setCellValueByColumnAndRow(5, $line, 'Qty GR ')
							->setCellValueByColumnAndRow(6, $line, 'Selisih ')
              ->setCellValueByColumnAndRow(7, $line, 'Satuan ')
              ->setCellValueByColumnAndRow(8, $line, 'Harga ')
              ->setCellValueByColumnAndRow(9, $line, 'Notes ');
					$line++;
					foreach($dataReader1 as $row1)
					{
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0, $line, $i)
									->setCellValueByColumnAndRow(1, $line, $row1['pono'])
									->setCellValueByColumnAndRow(2, $line, $row1['docdate'])
									->setCellValueByColumnAndRow(3, $line, $row1['productname'])
									->setCellValueByColumnAndRow(4, $line, $row1['poqty'])
									->setCellValueByColumnAndRow(5, $line, $row1['grqty'])
                  ->setCellValueByColumnAndRow(6, $line, $row1['selisih'])
                  ->setCellValueByColumnAndRow(7, $line, $row1['uomcode'])
                  ->setCellValueByColumnAndRow(8, $line, $row1['netprice']);
							$line++;
							$i++;
							
							$totalqty += $row1['poqty'];
							$totalqtygr += $row1['grqty'];
							$totalselisih += $row1['selisih'];
					}
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(3, $line, 'Total Gudang '.$row['description'])
							->setCellValueByColumnAndRow(4, $line, $totalqty)
							->setCellValueByColumnAndRow(5, $line, $totalqtygr)
							->setCellValueByColumnAndRow(6, $line, $totalselisih);
					
					$subtotalqty = $subtotalqty + $totalqty;
					$subtotalqtygr = $subtotalqtygr + $totalqtygr;
					$subtotalselisih = $subtotalselisih + $totalselisih;
					$line = $line+2;
					
			}
			
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(3, $line, 'Grand Total ')
							->setCellValueByColumnAndRow(4, $line, $subtotalqty)
							->setCellValueByColumnAndRow(5, $line, $subtotalqtygr)
							->setCellValueByColumnAndRow(6, $line, $subtotalselisih);
			
			$this->getFooterXLS($this->phpExcel);

	}
	//27
  public function RincianPOPerBarangPerDokumenXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
			//ini_set('memory_limit', '512M'); 
            $this->menuname='rincianpoperbarangperdokumen';
			parent::actionDownxls();
			
			$subtotalqty = 0;
			$subtotalqtygr = 0;
			$subtotalselisih = 0;
			$sql               = "select distinct d.description,d.slocid
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join product c on c.productid = b.productid
                    join sloc d on d.slocid = b.slocid
                    join addressbook e on e.addressbookid = a.addressbookid
                    where a.recordstatus = getwfmaxstatbywfname('apppo')
                    ".getFieldTable($productcollectid,'c','productcollectid')."
                    ".getCompanyGroup($companyid,'a')."  and c.productname like '%" . $product . "%' 
                    and e.fullname like '%" . $supplier . "%'
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
			
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
			
			$line=3;
			
			foreach($dataReader as $row)
			{
          $sql1           = "select distinct pono, docdate, productname, uomcode, (poqty) as poqty, (grqty) as grqty, (poqty-grqty) as selisih,netprice,headernote,fullname
                        from (select e.productname, d.uomcode, a.poqty, b.pono, b.docdate,
                        ifnull((select sum(c.qty) 
                        from grdetail c 
                        join grheader h on h.grheaderid=c.grheaderid 
                        where h.recordstatus = 3 and c.podetailid=a.podetailid),0) as grqty,a.netprice,b.headernote,f.fullname
                        from podetail a
                        join poheader b on b.poheaderid = a.poheaderid
                        join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
                        join product e on e.productid = a.productid
                        join addressbook f on f.addressbookid = b.addressbookid
                        join sloc g on g.slocid = a.slocid
                        where b.recordstatus = 5 
                        ".getFieldTable($productcollectid,'e','productcollectid')."
                        ".getCompanyGroup($companyid,'b')." and e.productname like '%" . $product . "%' 
                        and f.fullname like '%" . $supplier . "%' 
                        and a.slocid = " . $row['slocid'] . "
                        and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                        and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z ";
					
					$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
					
					$totalqty = 0;
					$totalqtygr = 0;
					$totalselisih = 0;
					
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0, $line, 'GUDANG : ')
							->setCellValueByColumnAndRow(1, $line, $row['description']);
					$line++;
					
					$i=1;
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(0, $line, 'No')
							->setCellValueByColumnAndRow(1, $line, 'NO. PO')
							->setCellValueByColumnAndRow(2, $line, 'Nama Supplier')
							->setCellValueByColumnAndRow(3, $line, 'TGL. PO ')
							->setCellValueByColumnAndRow(4, $line, 'Nama Barang')
							->setCellValueByColumnAndRow(5, $line, 'Qty PO')
							->setCellValueByColumnAndRow(6, $line, 'Qty GR')
							->setCellValueByColumnAndRow(7, $line, 'Selisih')
              ->setCellValueByColumnAndRow(8, $line, 'Satuan')
              ->setCellValueByColumnAndRow(9, $line, 'Harga')
              ->setCellValueByColumnAndRow(10, $line, 'Keterangan')
              ->setCellValueByColumnAndRow(11, $line, 'Notes');
					$line++;
					foreach($dataReader1 as $row1)
					{
							$this->phpExcel->setActiveSheetIndex(0)
									->setCellValueByColumnAndRow(0, $line, $i)
									->setCellValueByColumnAndRow(1, $line, $row1['pono'])
									->setCellValueByColumnAndRow(2, $line, $row1['fullname'])
									->setCellValueByColumnAndRow(3, $line, $row1['docdate'])
									->setCellValueByColumnAndRow(4, $line, $row1['productname'])
									->setCellValueByColumnAndRow(5, $line, $row1['poqty'])
									->setCellValueByColumnAndRow(6, $line, $row1['grqty'])
                  ->setCellValueByColumnAndRow(7, $line, $row1['selisih'])
                  ->setCellValueByColumnAndRow(8, $line, $row1['uomcode'])
                  ->setCellValueByColumnAndRow(9, $line, $row1['netprice'])
                  ->setCellValueByColumnAndRow(10, $line, $row1['headernote']);
							$line++;
							$i++;
							
							$totalqty += $row1['poqty'];
							$totalqtygr += $row1['grqty'];
							$totalselisih += $row1['selisih'];
					}
					$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(4, $line, 'Total Gudang '.$row['description'])
							->setCellValueByColumnAndRow(5, $line, $totalqty)
							->setCellValueByColumnAndRow(6, $line, $totalqtygr)
							->setCellValueByColumnAndRow(7, $line, $totalselisih);
					
					$subtotalqty = $subtotalqty + $totalqty;
					$subtotalqtygr = $subtotalqtygr + $totalqtygr;
					$subtotalselisih = $subtotalselisih + $totalselisih;
					$line = $line+2;
					
			}
			
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(4, $line, 'Grand Total ')
							->setCellValueByColumnAndRow(5, $line, $subtotalqty)
							->setCellValueByColumnAndRow(6, $line, $subtotalqtygr)
							->setCellValueByColumnAndRow(7, $line, $subtotalselisih);
			
			$this->getFooterXLS($this->phpExcel);

	}
	//28
	public function RekapFPPForecastXLS($companyid, $supplier, $productcollectid, $product, $startdate, $enddate, $per)
	{
    $this->menuname='rekapfppforecast';
    parent::actionDownxls();

    $grandTotal = array(
    'font'  => array(
        'bold' => true,
        'size'  => 12,
    ));

    $totalCollection = array (
      'font'  => array(
        'bold' => true,
        'size'  => 11,
    ));

    $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      )
    );

     $verticalcenter = array(
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $month = date('Y-m',strtotime($enddate));
    $month1 = $month.'-01';
    $sql = "select t.productcollectid, a.collectionname, t.forecastfppid,t.companyid
      from forecastfpp t 
      join productcollection a on a.productcollectid=t.productcollectid
      where t.perioddate='{$month1}'
      ".getFieldTable($productcollectid,'t','productcollectid')."
      and t.companyid=".$companyid;
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();

    $totalqty1=0;
    $totalprice1=0;
    $totalqty2=0;
    $totalprice2=0;
    $totalqty3=0;
    $totalprice3=0;
    $totalqty4=0;
    $totalprice4=0;
    $totalqty5=0;
    $totalprice5=0;

    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1, 2, date('Y-m', strtotime($startdate)))
      ->setCellValueByColumnAndRow(5, 1, GetCompanyCode($companyid));
    $line=4;

    foreach($dataReader as $row)
    {
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $line, 'Kelompok Product')
        ->setCellValueByColumnAndRow(1, $line, 'Material/Service')
        ->setCellValueByColumnAndRow(2, $line, 'Satuan')
        ->setCellValueByColumnAndRow(3, $line, 'FPP Bulan Ini')
        ->setCellValueByColumnAndRow(5, $line, 'FPP Bulan Lalu')
        ->setCellValueByColumnAndRow(7, $line, 'Realisasi Pembelian')
        ->setCellValueByColumnAndRow(9, $line, 'Saldo Awal')
        ->setCellValueByColumnAndRow(11, $line, 'Saldo Akhir');

      // Merge Row
      $plus=$line+1;
      $this->phpExcel->getActiveSheet()->mergeCells("A{$line}:A{$plus}");
      $this->phpExcel->getActiveSheet()->mergeCells("B{$line}:B{$plus}");
      $this->phpExcel->getActiveSheet()->mergeCells("C{$line}:C{$plus}");

      // Merge Column
      $this->phpExcel->getActiveSheet()->mergeCells("D{$line}:E{$line}");
      $this->phpExcel->getActiveSheet()->mergeCells("F{$line}:G{$line}");
      $this->phpExcel->getActiveSheet()->mergeCells("H{$line}:I{$line}");
      $this->phpExcel->getActiveSheet()->mergeCells("J{$line}:K{$line}");
      $this->phpExcel->getActiveSheet()->mergeCells("L{$line}:M{$line}");

      // Center Merge
      $this->phpExcel->getActiveSheet()->getStyle("D{$line}:E{$line}")->applyFromArray($style);
      $this->phpExcel->getActiveSheet()->getStyle("F{$line}:G{$line}")->applyFromArray($style);
      $this->phpExcel->getActiveSheet()->getStyle("H{$line}:I{$line}")->applyFromArray($style);
      $this->phpExcel->getActiveSheet()->getStyle("J{$line}:K{$line}")->applyFromArray($style);
      $this->phpExcel->getActiveSheet()->getStyle("L{$line}:M{$line}")->applyFromArray($style);
      $this->phpExcel->getActiveSheet()->getStyle("A{$line}:A{$plus}")->applyFromArray($verticalcenter);
      $this->phpExcel->getActiveSheet()->getStyle("B{$line}:B{$plus}")->applyFromArray($verticalcenter);
      $this->phpExcel->getActiveSheet()->getStyle("C{$line}:C{$plus}")->applyFromArray($verticalcenter);

      $line++;

      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(3, $line, 'Qty')
        ->setCellValueByColumnAndRow(4, $line, 'Nilai')
        ->setCellValueByColumnAndRow(5, $line, 'Qty')
        ->setCellValueByColumnAndRow(6, $line, 'Nilai')
        ->setCellValueByColumnAndRow(7, $line, 'Qty')
        ->setCellValueByColumnAndRow(8, $line, 'Nilai')
        ->setCellValueByColumnAndRow(9, $line, 'Qty')
        ->setCellValueByColumnAndRow(10, $line, 'Nilai')
        ->setCellValueByColumnAndRow(11, $line, 'Qty')
        ->setCellValueByColumnAndRow(12, $line, 'Nilai');
      $line++;

      $y=$line;
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(0, $line, $row['collectionname']);
      $line++;

      $sql1="select productid,productname, uomcode, sum(qty1) as qty1, sum(price1) as price1, sum(qty2) as qty2, sum(price2) as price2, sum(qty3) as qty3, sum(price3) as price3 , flag 
        from (select distinct b.productid, b.productname, c.uomcode,a.prqtyreal as qty1,a.price*a.prqtyreal as price1,
        0 as qty2, 0 as price2, 0 as qty3, 0 as price3,'' as flag
        from forecastfppdet a
        join product b on b.productid = a.productid
        join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        where a.forecastfppid = ".$row['forecastfppid']."
        union
        select distinct a1.productid, b1.productname, c1.uomcode, 0 as qty1, 0 as price1,a1.prqtyreal as qty2, a1.price*a1.prqtyreal as price2,0 as qty3, 0 as price3,'*' as flag
        from forecastfppdet a1
        join forecastfpp a2 on a2.forecastfppid = a1.forecastfppid
        join product b1 on b1.productid = a1.productid
        join unitofmeasure c1 on c1.unitofmeasureid = a1.unitofmeasureid
        where a2.productcollectid = {$row['productcollectid']} and
        a2.companyid = {$row['companyid']} and a2.perioddate = date_add('{$month1}', interval -1 month)
        union
        select a3.productid, g3.productname,h3.uomcode,0 as qty1, 0 as price1, 0 as qty2, 0 as price2, sum(a3.qty) as qty3,sum(a3.qty * c3.netprice) as price3,'**' as flag
        from grdetail a3
        left join invoiceap b3 on b3.grheaderid=a3.grheaderid
        left join podetail c3 on c3.podetailid=a3.podetailid
        left join product g3 on g3.productid=a3.productid
        left join unitofmeasure h3 on h3.unitofmeasureid=a3.unitofmeasureid
        where b3.recordstatus = 3 and b3.companyid={$row['companyid']} and g3.productcollectid={$row['productcollectid']}
        and b3.receiptdate between date_add('{$month1}', interval -1 month) 
        and date_add('{$month1}', interval -1 day)
        group by productname) z
        group by productname";
      $i=1;
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $subqty1=0;
      $subprice1=0;
      $subqty2=0;
      $subprice2=0;
      $subqty3=0;
      $subprice3=0;
      $subqty4=0;
      $subprice4=0;
      $subqty5=0;
      $subprice5=0;
      foreach($dataReader1 as $row1)
      {

        $sAwal = Yii::app()->db->createCommand("select a.productname, sum(a.qty) as qty4, sum(a.qty*a.buyprice) as price4, a.averageprice
          from productdetailhist a
          where a.productid={$row1['productid']} and a.slocid in(
            select x.slocid
            from sloc x
            join plant xa on xa.plantid = x.plantid
            where xa.companyid={$companyid}
          )
          and a.buydate < date_add(date_add(last_day('".date(Yii::app()->params['datetodb'],strtotime($enddate))."'), interval 1 day), interval -2 month)")->queryRow();

        $sAkhir = Yii::app()->db->createCommand("select a.productname, sum(a.qty) as qty5, sum(a.qty*a.buyprice) as price5, a.averageprice
          from productdetailhist a
          where a.productid={$row1['productid']} and a.slocid in(
            select x.slocid
            from sloc x
            join plant xa on xa.plantid = x.plantid
            where xa.companyid={$companyid}
          )
          and a.buydate < date_add('{$month1}', interval -1 day)")->queryRow();  

        $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, $i)
          ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
          ->setCellValueByColumnAndRow(2, $line, $row1['uomcode'])
          ->setCellValueByColumnAndRow(3, $line, $row1['qty1'])
          ->setCellValueByColumnAndRow(4, $line, $row1['price1']/$per)
          ->setCellValueByColumnAndRow(5, $line, $row1['qty2'])
          ->setCellValueByColumnAndRow(6, $line, $row1['price2']/$per)
          ->setCellValueByColumnAndRow(7, $line, $row1['qty3'])
          ->setCellValueByColumnAndRow(8, $line, $row1['price3']/$per)
          ->setCellValueByColumnAndRow(9, $line, $sAwal['qty4'])
          ->setCellValueByColumnAndRow(10, $line, $sAwal['price4']/$per)
          ->setCellValueByColumnAndRow(11, $line, $sAkhir['qty5'])
          ->setCellValueByColumnAndRow(12, $line, $sAkhir['price5']/$per);
        $line++;
        $i++;
        $subqty1 += ($row1['qty1']);
        $subprice1 += ($row1['price1']);
        $subqty2 += ($row1['qty2']);
        $subprice2 += ($row1['price2']);
        $subqty3 += ($row1['qty3']);
        $subprice3 += ($row1['price3']);
        $subqty4 += ($sAwal['qty4']);
        $subprice4 += ($sAwal['price4']);
        $subqty5 += ($sAkhir['qty5']);
        $subprice5 += ($sAkhir['price5']);
      }
      $this->phpExcel->getActiveSheet()->getStyle("A{$y}")->applyFromArray($totalCollection);
      $this->phpExcel->getActiveSheet()->getStyle("E{$y}")->applyFromArray($totalCollection);
      $this->phpExcel->getActiveSheet()->getStyle("G{$y}")->applyFromArray($totalCollection);
      $this->phpExcel->getActiveSheet()->getStyle("I{$y}")->applyFromArray($totalCollection);
      $this->phpExcel->getActiveSheet()->getStyle("K{$y}")->applyFromArray($totalCollection);
      $this->phpExcel->getActiveSheet()->getStyle("M{$y}")->applyFromArray($totalCollection);
        
      $this->phpExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(4, $y, $subprice1/$per)
        ->setCellValueByColumnAndRow(6, $y, $subprice2/$per)
        ->setCellValueByColumnAndRow(8, $y, $subprice3/$per)
        ->setCellValueByColumnAndRow(10, $y, $subprice4/$per)
        ->setCellValueByColumnAndRow(12, $y, $subprice5/$per);
      $line++;
      $totalqty1+=$subqty1;
      $totalprice1+=$subprice1;
      $totalqty2+=$subqty2;
      $totalprice2+=$subprice2;
      $totalqty3+=$subqty3;
      $totalprice3+=$subprice3;
      $totalqty4+=$subqty4;
      $totalprice4+=$subprice4;
      $totalqty5+=$subqty5;
      $totalprice5+=$subprice5;
    }

    $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL ')
      ->setCellValueByColumnAndRow(4, $line, $totalprice1/$per)
      ->setCellValueByColumnAndRow(6, $line, $totalprice2/$per)
      ->setCellValueByColumnAndRow(8, $line, $totalprice3/$per)
      ->setCellValueByColumnAndRow(10, $line, $totalprice4/$per)
      ->setCellValueByColumnAndRow(12, $line, $totalprice5/$per);
    $line++;

    $this->getFooterXLS($this->phpExcel);
  }

}