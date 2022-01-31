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
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['supplier']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1) {
        $this->RincianPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 3) {
        $this->RekapPOPerSupplier($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 4) {
        $this->RekapPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 5) {
        $this->RincianPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 6) {
        $this->RekapPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 7) {
        $this->RekapPembelianPerSupplier($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 8) {
        $this->RekapPembelianPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 9) {
        $this->RincianReturPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapReturPembelianPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 11) {
        $this->RekapReturPembelianPerSupplier($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapReturPembelianPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 13) {
        $this->RincianSelisihPembelianReturPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 14) {
        $this->RekapSelisihPembelianReturPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 15) {
        $this->RekapSelisihPembelianReturPerSupplier($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 16) {
        $this->RekapSelisihPembelianReturPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 17) {
        $this->PendinganPOPerDokumen($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 18) {
        $this->RincianPendinganPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 19) {
        $this->RekapPendinganPOPerBarang($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else {
        echo $this->getCatalog('reportdoesnotexist');
      }
    }
	}
	//1
  public function RincianPOPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.recordstatus=5 and a.companyid = " . $companyid . " and a.pono is not null
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
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
    foreach ($dataReader as $row) 
		{
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'No Bukti');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['pono']);
      $this->pdf->text(10, $this->pdf->gety() + 15, 'Supplier');
      $this->pdf->text(30, $this->pdf->gety() + 15, ': ' . $row['fullname']);
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
							and a.companyid = " . $companyid . " and a.poheaderid = " . $row['poheaderid'] . "
							and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
      $total=0;$i=0;$totalqty=0;
      $this->pdf->sety($this->pdf->gety() + 20);
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
    $this->pdf->Output();
  }
  //2
	public function RekapPOPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
                    where a.recordstatus=5 and a.pono is not null and f.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' and a.companyid = " . $companyid . " and 
                    a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
    $this->pdf->Output();
  }
  //3
	public function RekapPOPerSupplier($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
										where b.poheaderid=a.poheaderid and e.productname like '%" . $product . "%' ) as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    where a.recordstatus=5 and a.pono is not null and d.fullname like '%" . $supplier . "%' and a.companyid = " . $companyid . " and 
                    a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
    $this->pdf->Output();
  }
  //4
	public function RekapPOPerBarang($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql        = "select distinct g.materialgroupid, g.description
                    from poheader a
                    join podetail b on b.poheaderid = a.poheaderid
                    join addressbook c on c.addressbookid = a.addressbookid
                    join paymentmethod d on d.paymentmethodid = a.paymentmethodid
                    join product e on e.productid = b.productid
                    join productplant f on f.productid = b.productid
                    join materialgroup g on g.materialgroupid = f.materialgroupid
                    where a.companyid = " . $companyid . " and a.pono is not null
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
                and a.companyid = " . $companyid . " and i.materialgroupid = " . $row['materialgroupid'] . "
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
    $this->pdf->Output();
  }
  //5
	public function RincianPembelianPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
						where a.recordstatus=3 and c.companyid = " . $companyid . " and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by receiptdate,grno";
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
      $this->pdf->text(180, $this->pdf->gety() + 0, ': ' . $row['pono']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(180, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['podate'])));
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
							where d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
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
    $this->pdf->Output();
  }
  //6
	public function RekapPembelianPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
    $this->pdf->Output();
  }
  //7
	public function RekapPembelianPerSupplier($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
						where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'
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
    $this->pdf->Output();
  }
  //8
	public function RekapPembelianPerBarang($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
				where f.companyid = " . $companyid . " and b.productid in
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
							where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Pembelian Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Material Group');
      $this->pdf->text(40, $this->pdf->gety() + 10, ': ' . $row['description']);
      $sql1         = "select g.productname,a.qty,h.uomcode,c.netprice,sum(a.qty * c.netprice) as nominal,
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
							where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
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
          Yii::app()->format->formatCurrency($row1['netprice'] / $per),
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
    $this->pdf->Output();
  }
  //9
	public function RincianReturPembelianPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
							where a.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' and f.companyid = " . $companyid . " and 
							a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
    $this->pdf->Output();
  }
  //10
	public function RekapReturPembelianPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql  = "select distinct *,(nominal+ppn) as netto
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Retur Pembelian Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
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
    $this->pdf->Output();
  }
  //11
	public function RekapReturPembelianPerSupplier($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql = "select supplier,taxid,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
            from (select distinct *,(nominal+ppn) as netto
						from (select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
    $this->pdf->Output();
  }
  //12
	public function RekapReturPembelianPerBarang($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
                    where j.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = 1
                    group by productname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
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
      $sql1        = "select *,(nominal+ppn) as netto
                      from
                      (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
                      from
                      (select b.productname,a.qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
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
                      where j.recordstatus = 3 and  b.productname like '%" . $product . "%' and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                      and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = " . $companyid . " and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz";
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
    $this->pdf->Output();
  }
  //13
	public function RincianSelisihPembelianReturPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
						where a.recordstatus=3 and c.companyid = " . $companyid . " and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
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
      $this->pdf->text(180, $this->pdf->gety() + 0, ': ' . $row['pono']);
      $this->pdf->text(150, $this->pdf->gety() + 5, 'Tanggal');
      $this->pdf->text(180, $this->pdf->gety() + 5, ': ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['podate'])));
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
							where d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
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
							where a.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' and f.companyid = " . $companyid . " and 
							a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
							 join unitofmeasure d on d.unitofmeasureid=a.uomid
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
    $this->pdf->Output();
  }
  //14
	public function RekapSelisihPembelianReturPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
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
    $this->pdf->title    = 'Rekap (Pembelian-Retur) Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
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
    $this->pdf->Output();
  }
  //15
	public function RekapSelisihPembelianReturPerSupplier($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql          = "select *
                    from (select fullname,nominal-nominalretur as nom, ppn-ppnretur as pajak, netto-nettoretur as total
                    from (select *,nominal+ppn as netto,nominalretur+ppnretur as nettoretur
                    from (select a.fullname,
                    ifnull((select sum(b.qty * e.netprice)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominal,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid 
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppn,
                    ifnull((select sum(b.qty * e.netprice)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominalretur,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppnretur
                    from addressbook a
                    where a.isvendor=1
                    and a.fullname like '%".$supplier."%') z) zz) zzz
                    where nom <> 0 or pajak <> 0 or total <> 0
                    order by fullname
                    ";
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
    $this->pdf->Output();
  }
  //16
	public function RekapSelisihPembelianReturPerBarang($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    parent::actionDownPDF();
    $sql   = "select distinct *
              from (select distinct a.materialgroupid,a.description
              from materialgroup a
              join productplant b on b.materialgroupid = a.materialgroupid
              join product c on c.productid = b.productid
              join sloc d on d.slocid = b.slocid
              join plant e on e.plantid = d.plantid
              join company f on f.companyid = e.companyid
              where f.companyid = " . $companyid . " and b.productid in
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
							where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = 1) z
              ";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap (Pembelian-Retur) Per Barang';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');
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
              from (select g.productname,a.qty,h.uomcode,sum(a.qty * c.netprice) as nominal,sum((a.qty * c.netprice)*(i.taxvalue/100)) as ppn 
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
							where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname
            union
              select distinct productname,-qty,uomcode,-nominal,-ppn
              from
              (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
              from
              (select b.productname,a.qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
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
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = " . $companyid . " and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz
              ) x group by productname
              ";
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
    $this->pdf->Output();
  }
	//17
	public function PendinganPOPerDokumen($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		parent::actionDownPDF();
		
		$sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.companyid = " . $companyid . " and a.pono is not null
						and a.recordstatus=5
						and b.poqty > b.qtyres
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) 
		{
      $this->pdf->companyid = $companyid;
    }
		$this->pdf->title    = 'Pendingan PO Per Dokumen';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->text(10, $this->pdf->gety() + 10, 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
    $this->pdf->AddPage('P');
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
			
			$sql1 = "select b.productname,a.poqty,a.qtyres,c.uomcode,a.netprice,(a.poqty-a.qtyres)*a.netprice as jumlah,a.itemtext,(e.taxvalue/100)*((a.poqty-a.qtyres)*a.netprice) as ppn
							from podetail a
							join product b on b.productid=a.productid
							join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
							join poheader d on d.poheaderid=a.poheaderid
							join tax e on e.taxid=d.taxid
							where b.productname like '%" . $product . "%' 
							and a.poqty > a.qtyres and a.poheaderid = " . $row['poheaderid'] . " ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$totalnominal=0;$i=0;$totalqty=0;$totalppn=0;$totalnetto=0;$totalgrqty=0;
			
      $this->pdf->sety($this->pdf->gety() + 13);
      $this->pdf->setFont('Arial', 'B', 8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,50,15,15,15,28,28,35));
      $this->pdf->colheader = array('No','Nama Barang','Qty','Qty GR','Satuan','Harga','Jumlah','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','R','C','R','R','R');
      $this->pdf->setFont('Arial', '', 8);
			
      foreach ($dataReader1 as $row1)
			{
				$i += 1;
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['poqty']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['qtyres']),
          $row1['uomcode'],
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $row1['netprice'] / $per),
          Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], ($row1['jumlah'])/$per),
          $row1['itemtext']
        ));
        $totalqty += $row1['poqty'];
				$totalgrqty += $row1['qtyres'];
        $totalnominal += ($row1['jumlah']) / $per;
				$totalppn += $row1['ppn'] / $per;        
        $totalnetto += ($row1['jumlah'] + $row1['ppn']) / $per;
				
				
			}
			
			$this->pdf->row(array(
        '',
        'Total',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalqty),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalgrqty),
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
        'PPN',
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"], $totalppn)
      ));
      $this->pdf->row(array(
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
		
		$this->pdf->Output();
	}
	//18
	public function RincianPendinganPOPerBarang($companyid, $supplier, $product, $startdate, $enddate, $per)
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
				and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty
				";
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
				and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%' and d.slocid = " . $row['slocid'] . "
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
				from (select distinct pono, docdate, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
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
						and b.companyid = " . $companyid . " and e.productname like '%" . $product . "%' 
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
	public function RekapPendinganPOPerBarang($companyid, $supplier, $product, $startdate, $enddate)
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
				and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
				and e.fullname like '%" . $supplier . "%'
				and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
				where poqty>grqty
					";
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
						and b.companyid = " . $companyid . " and e.productname like '%" . $product . "%' 
						and f.fullname like '%" . $supplier . "%' 
						and a.slocid = " . $row['slocid'] . "
						and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty
						group by productname) zz
						";
      $command=$this->connection->createCommand($sql1);$dataReader1=$command->queryAll();
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
  
  public function actionDownXLS()
	{
	  parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['supplier']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['per'])) {
      if ($_GET['lro'] == 1) {
        $this->RincianPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 3) {
        $this->RekapPOPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 4) {
        $this->RekapPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 5) {
        $this->RincianPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 6) {
        $this->RekapPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 7) {
        $this->RekapPembelianPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 8) {
        $this->RekapPembelianPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 9) {
        $this->RincianReturPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapReturPembelianPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 11) {
        $this->RekapReturPembelianPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapReturPembelianPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 13) {
        $this->RincianSelisihPembelianReturPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 14) {
        $this->RekapSelisihPembelianReturPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 15) {
        $this->RekapSelisihPembelianReturPerSupplierXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 16) {
        $this->RekapSelisihPembelianReturPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 17) {
        $this->PendinganPOPerDokumenXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 18) {
        $this->RincianPendinganPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else if ($_GET['lro'] == 19) {
        $this->RekapPendinganPOPerBarangXLS($_GET['company'], $_GET['supplier'], $_GET['product'], $_GET['startdate'], $_GET['enddate'], $_GET['per']);
      } else {
        echo $this->getCatalog('reportdoesnotexist');
      }
    }
	}
  //1
	public function RincianPOPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpoperdokumen';
    parent::actionDownXLS();
    $totalppn       = 0;
    $totalnetto     = 0;
    $totalallqty    = 0;
    $totalalljumlah = 0;
    $sql            = "select *,(nominal+ppn) as netto
					from
					(select *,(select nominal*c.taxvalue/100 from tax c where c.taxid=zz.taxid) as ppn
					from 
					(select a.poheaderid,a.taxid,a.pono,a.docdate,d.fullname,e.paydays,(select sum(b.poqty*b.netprice) 
					from podetail b where b.poheaderid=a.poheaderid) as nominal
					from poheader a
					inner join addressbook d on d.addressbookid=a.addressbookid
					inner join paymentmethod e on e.paymentmethodid=a.paymentmethodid
					where a.recordstatus=5 and a.pono is not null and a.companyid = " . $companyid . " and 
					a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
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
      $sql1        = "select c.productname, a.poqty,d.uomcode,a.netprice,a.poqty * a.netprice as jumlah,a.itemtext
							from podetail a
							inner join product c on c.productid = a.productid
							inner join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
							where a.poheaderid = " . $row['poheaderid'];
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
						->setCellValueByColumnAndRow(5, $line, $row1['jumlah'] / $per)
						->setCellValueByColumnAndRow(6, $line, $row1['itemtext']);
        $line++;
        $totalqty += $row1['poqty'];
        $totaljumlah += $row1['jumlah'] / $per;
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
			->setCellValueByColumnAndRow(6, $line, $row['ppn'] / $per);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, $line, '')
			->setCellValueByColumnAndRow(1, $line, '')
			->setCellValueByColumnAndRow(2, $line, '')
			->setCellValueByColumnAndRow(3, $line, '')
			->setCellValueByColumnAndRow(4, $line, '')
			->setCellValueByColumnAndRow(5, $line, 'Netto')
			->setCellValueByColumnAndRow(6, $line, $row['netto'] / $per);
      $line += 2;
      $totalppn += $row['ppn'] / $per;
      $totalnetto += $row['netto'] / $per;
			$totalallqty += $row1['poqty'];
			$totalalljumlah += $row1['jumlah'] / $per;
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
  //2
	public function RekapPOPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappoperdokumen';
    parent::actionDownXLS();
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
                    where a.recordstatus=5 and a.pono is not null and f.productname like '%" . $product . "%' and d.fullname like '%" . $supplier . "%' and a.companyid = " . $companyid . " and 
                    a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
  //3
	public function RekapPOPerSupplierXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappopersupplier';
    parent::actionDownXLS();
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
										where b.poheaderid=a.poheaderid and e.productname like '%" . $product . "%' ) as nominal
                    from poheader a
                    inner join addressbook d on d.addressbookid=a.addressbookid
                    where a.recordstatus=5 and a.pono is not null and d.fullname like '%" . $supplier . "%' and a.companyid = " . $companyid . " and 
                    a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') zz)zzz)xx
                    group by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    $totalppn     = 0;
    $totalnominal = 0;
    $total        = 0;
    $i            = 0;
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
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
  //4
	public function RekapPOPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappoperbarang';
    parent::actionDownXLS();
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
                    where a.companyid = " . $companyid . " and a.pono is not null
                    and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
                    and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
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
                and a.companyid = " . $companyid . " and i.materialgroupid = " . $row['materialgroupid'] . "
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
  //5
	public function RincianPembelianPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rincianpembelianperdokumen';
    parent::actionDownXLS();
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
						where a.recordstatus=3 and c.companyid = " . $companyid . " and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by receiptdate,grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
							where d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
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
  //6
	public function RekapPembelianPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianperdokumen';
    parent::actionDownXLS();
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
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, $this->GetCompanyCode($companyid));
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
  //7
	public function RekapPembelianPerSupplierXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianpersupplier';
    parent::actionDownXLS();
    $totalnominal = 0;
    $totalppn     = 0;
    $totaljumlah  = 0;
    $sql          = "select fullname,sum(nom) as nominal,sum(pajak) as PPN from 
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
						where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%'
						and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						group by fullname order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
    $line = 4;
    $i    = 0;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, 'No')->setCellValueByColumnAndRow(1, $line, 'Nama Supplier')->setCellValueByColumnAndRow(2, $line, 'Nominal')->setCellValueByColumnAndRow(3, $line, 'PPN')->setCellValueByColumnAndRow(4, $line, 'Total');
    $line++;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $line, $i += 1)->setCellValueByColumnAndRow(1, $line, $row['fullname'])->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($row['nominal'] / $per))->setCellValueByColumnAndRow(3, $line, Yii::app()->format->formatCurrency($row['PPN'] / $per))->setCellValueByColumnAndRow(4, $line, Yii::app()->format->formatCurrency(($row['nominal'] + $row['PPN']) / $per));
      $line++;
      $totalnominal += $row['nominal'] / $per;
      $totalppn += $row['PPN'] / $per;
      $totaljumlah += ($row['nominal'] + $row['PPN']) / $per;
    }
    $line += 1;
    $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $line, 'GRAND TOTAL')->setCellValueByColumnAndRow(2, $line, Yii::app()->format->formatCurrency($totalnominal))->setCellValueByColumnAndRow(3, $line, Yii::app()->format->formatCurrency($totalppn))->setCellValueByColumnAndRow(4, $line, Yii::app()->format->formatCurrency($totaljumlah));
    $this->getFooterXLS($this->phpExcel);
  }
  //8
	public function RekapPembelianPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
  {
    $this->menuname = 'rekappembelianperbarang';
    parent::actionDownXLS();
    $totalqty1     = 0;
    $totalnominal1 = 0;
    $totalppn1     = 0;
    $sql           = "select distinct a.materialgroupid,a.materialgroupcode,a.description
				from materialgroup a
				join productplant b on b.materialgroupid = a.materialgroupid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join plant e on e.plantid = d.plantid
				join company f on f.companyid = e.companyid
				where f.companyid = " . $companyid . " and b.productid in
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
							where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
				)";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
			
      $sql1 = "select g.productname,a.qty,h.uomcode,c.netprice,sum(a.qty * c.netprice) as nominal,
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
							where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
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
	//9
	public function RincianReturPembelianPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianreturpembelianperdokumen';
    parent::actionDownXLS();
		$sql = "select distinct *
					from 
					(select a.grreturid,a.grreturno,g.fullname as supplier,a.grreturdate,h.paycode							
					from grretur a
					join grreturdetail c on c.grreturid=a.grreturid
					join product d on d.productid=c.productid
					join podetail e on e.podetailid=c.podetailid
					join poheader f on f.poheaderid=e.poheaderid
					join addressbook g on g.addressbookid=f.addressbookid
					join paymentmethod h on h.paymentmethodid=f.paymentmethodid
					where a.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' and f.companyid = " . $companyid . " and 
					a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
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
	//10
	public function RekapReturPembelianPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianperdokumen';
    parent::actionDownXLS();
		$sql  = "select distinct *,(nominal+ppn) as netto
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z) zz order by grreturno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
	//11
	public function RekapReturPembelianPerSupplierXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianpersupplier';
    parent::actionDownXLS();
		$sql = "select supplier,taxid,sum(nominal) as nominal,sum(ppn) as ppn,sum(netto) as netto
            from (select distinct *,(nominal+ppn) as netto
						from (select *,(select nominal*g.taxvalue/100 from tax g where g.taxid=z.taxid) as ppn
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
						a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z ) zz 
            order by grreturno) zzz group by supplier";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
	//12
	public function RekapReturPembelianPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapreturpembelianperbarang';
		parent::actionDownXLS();		
			$sql  = "select a.materialgroupid,a.description from materialgroup a where a.materialgroupid in
							(select b.materialgroupid from productplant b where b.productid in
							(select c.productid from grreturdetail c 
							left join podetail d on d.podetailid=c.podetailid
							left join poheader e on e.poheaderid=d.poheaderid
							left join grretur f on f.grreturid=c.grreturid
							join product g on g.productid = d.productid
							join addressbook h on h.addressbookid = e.addressbookid
							where g.productname like '%" . $product . "%' and h.fullname like '%" . $supplier . "%' and e.companyid = " . $companyid . " and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'))";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($dataReader as $row)
			
      $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
				
				$sql1 = "select *,(nominal+ppn) as netto
                        from
                        (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
                        from
                        (select b.productname,a.qty,(a.qty*c.netprice) as nominal,d.taxid,h.description
                        from grreturdetail a
                        join product b on b.productid=a.productid
                        join podetail c on c.podetailid=a.podetailid
                        join poheader d on d.poheaderid=c.poheaderid
                        join unitofmeasure e on e.unitofmeasureid=a.uomid
                        join grretur f on f.grreturid=a.grreturid
                        join productplant g on g.productid=a.productid
                        join materialgroup h on h.materialgroupid=g.materialgroupid
                        where f.recordstatus = 3 and  b.productname like '%" . $product . "%' " . "and f.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
                    and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = 1 and h.materialgroupid = " . $row['materialgroupid'] . " 
                        group by productname) z) zz";
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
	//13
	public function RincianSelisihPembelianReturPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianselisihpembelianreturperdokumen';
		parent::actionDownXLS();	
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
						where a.recordstatus=3 and c.companyid = " . $companyid . " and e.fullname like '%" . $supplier . "%' and g.productname like '%" . $product . "%'
						and a.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
						order by receiptdate,grno";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row)
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
							where d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.grheaderid = " . $row['grheaderid'];
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
    
    $sql = "select distinct *
					from 
					(select a.grreturid,a.grreturno,g.fullname as supplier,a.grreturdate,h.paycode							
					from grretur a
					join grreturdetail c on c.grreturid=a.grreturid
					join product d on d.productid=c.productid
					join podetail e on e.podetailid=c.podetailid
					join poheader f on f.poheaderid=e.poheaderid
					join addressbook g on g.addressbookid=f.addressbookid
					join paymentmethod h on h.paymentmethodid=f.paymentmethodid
					where a.recordstatus = 3 and d.productname like '%" . $product . "%' and g.fullname like '%" . $supplier . "%' and f.companyid = " . $companyid . " and 
					a.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
	//14
	public function RekapSelisihPembelianReturPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturperdokumen';
		parent::actionDownXLS();
		$totalnominal = 0;
    $totalppn     = 0;
    $totalnetto   = 0;
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
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))->setCellValueByColumnAndRow(8, 1, $this->GetCompanyCode($companyid));
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
		$sql1 = "select distinct *,(nominal+ppn) as netto
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
						where a.recordstatus = 3 and b.companyid = " . $companyid . " and c.fullname like '%" . $supplier . "%' and e.productname like '%" . $product . "%'  and 
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
	//15
	public function RekapSelisihPembelianReturPerSupplierXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturpersupplier';
		parent::actionDownXLS();
		$sql  = "select *
                    from (select fullname,nominal-nominalretur as nom, ppn-ppnretur as pajak, netto-nettoretur as total
                    from (select *,nominal+ppn as netto,nominalretur+ppnretur as nettoretur
                    from (select a.fullname,
                    ifnull((select sum(b.qty * e.netprice)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominal,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grdetail b
                    join grheader c on c.grheaderid=b.grheaderid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join invoiceap g on g.grheaderid=c.grheaderid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid 
                    and c.grdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppn,
                    ifnull((select sum(b.qty * e.netprice)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as nominalretur,
                    ifnull((select sum(b.qty * e.netprice * f.taxvalue / 100)
                    from grreturdetail b
                    join grretur c on c.grreturid=b.grreturid
                    join poheader d on d.poheaderid=c.poheaderid
                    join podetail e on e.podetailid=b.podetailid
                    join tax f on f.taxid=d.taxid
                    join notagrretur g on g.grreturid=c.grreturid
                    where g.recordstatus=3 and d.companyid = " . $companyid . " and d.addressbookid=a.addressbookid
                    and c.grreturdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'),0) as ppnretur
                    from addressbook a
                    where a.isvendor=1
                    and a.fullname like '%".$supplier."%') z) zz) zzz
                    where nom <> 0 or pajak <> 0 or total <> 0
                    order by fullname";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(4, 1, $this->GetCompanyCode($companyid));
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
	//16
	public function RekapSelisihPembelianReturPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rekapselisihpembelianreturperbarang';
		parent::actionDownXLS();
		$sql  = "select distinct *
              from (select distinct a.materialgroupid,a.description
              from materialgroup a
              join productplant b on b.materialgroupid = a.materialgroupid
              join product c on c.productid = b.productid
              join sloc d on d.slocid = b.slocid
              join plant e on e.plantid = d.plantid
              join company f on f.companyid = e.companyid
              where f.companyid = " . $companyid . " and b.productid in
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
							where b.recordstatus=3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
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
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = 1) z
              ";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
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
              from (select g.productname,a.qty,h.uomcode,sum(a.qty * c.netprice) as nominal,sum((a.qty * c.netprice)*(i.taxvalue/100)) as ppn 
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
							where b.recordstatus = 3 and d.companyid = " . $companyid . " and g.productname like '%" . $product . "%' and f.fullname like '%" . $supplier . "%' 
						  and j.materialgroupid = " . $row['materialgroupid'] . "
						  and b.receiptdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						  and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'
							group by productname
            union
              select distinct productname,-qty,uomcode,-nominal,-ppn
              from
              (select *,(select nominal*i.taxvalue/100 from tax i where i.taxid=z.taxid) as ppn
              from
              (select b.productname,a.qty,i.uomcode,(a.qty*c.netprice) as nominal,d.taxid,h.description
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
              and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and d.companyid = " . $companyid . " and h.materialgroupid = " . $row['materialgroupid'] . " ) z) zz
              ) x group by productname
              ";
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
	//17
	public function PendinganPOPerDokumenXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'pendinganpoperdokumen';
		parent::actionDownXLS();
		$sql = "select distinct a.poheaderid, a.pono, c.fullname, d.paydays, a.docdate
						from poheader a
						join podetail b on b.poheaderid = a.poheaderid
						join addressbook c on c.addressbookid = a.addressbookid
						join paymentmethod d on d.paymentmethodid = a.paymentmethodid
						join product e on e.productid = b.productid
						where a.companyid = " . $companyid . " and a.pono is not null
						and a.recordstatus=5
						and b.poqty > b.qtyres
						and e.productname like '%" . $product . "%' and c.fullname like '%" . $supplier . "%' 
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' order by pono";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$totalallqty=0;$totalnetto1=0;
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(7, 1, $this->GetCompanyCode($companyid));
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
			
			$sql1 = "select b.productname,a.poqty,a.qtyres,c.uomcode,a.netprice,(a.poqty-a.qtyres)*a.netprice as jumlah,a.itemtext,(e.taxvalue/100)*((a.poqty-a.qtyres)*a.netprice) as ppn
							from podetail a
							join product b on b.productid=a.productid
							join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
							join poheader d on d.poheaderid=a.poheaderid
							join tax e on e.taxid=d.taxid
							where b.productname like '%" . $product . "%' 
							and a.poqty > a.qtyres and a.poheaderid = " . $row['poheaderid'] . " ";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$i=0;$totalqty=0;$totalgrqty=0;$totalnominal=0;$totalnetto=0;$totalppn=0;
			foreach ($dataReader1 as $row1)
			{
				$i += 1;
        $this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0, $line, $i)
						->setCellValueByColumnAndRow(1, $line, $row1['productname'])
						->setCellValueByColumnAndRow(2, $line, $row1['poqty'])
						->setCellValueByColumnAndRow(3, $line, $row1['qtyres'])
						->setCellValueByColumnAndRow(4, $line, $row1['uomcode'])
						->setCellValueByColumnAndRow(5, $line, $row1['netprice'] / $per)
						->setCellValueByColumnAndRow(6, $line, $row1['jumlah'] / $per)
						->setCellValueByColumnAndRow(7, $line, $row1['itemtext']);
        $line++;
				$totalqty += $row1['poqty'];
				$totalgrqty += $row1['qtyres'];
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
	public function RincianPendinganPOPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate, $per)
	{
		$this->menuname = 'rincianpendinganpoperbarang';
		parent::actionDownXLS();
		$subtotalqty=0;$subtotalqtyoutput=0;$subtotalselisih=0;
		$sql = "select distinct description,slocid
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
					and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
					and e.fullname like '%" . $supplier . "%'
					and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
					where poqty>grqty
					";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(6, 1, $this->GetCompanyCode($companyid));
		$line=4;
    foreach ($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'GUDANG ')
					->setCellValueByColumnAndRow(1,$line,': '.$row['description']);
      $line++;
			
			$sql1 = "select distinct productname,productid from (
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
							and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
							and e.fullname like '%" . $supplier . "%' and d.slocid = " . $row['slocid'] . "
							and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							where poqty>grqty
							";
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
				
				$sql2 = "select *
								from (select distinct pono, docdate, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
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
								and b.companyid = " . $companyid . " and e.productname like '%" . $product . "%' 
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
	public function RekapPendinganPOPerBarangXLS($companyid, $supplier, $product, $startdate, $enddate)
	{
		$this->menuname = 'rekappendinganpoperbarang';
		parent::actionDownXLS();
		$subtotalqty=0;$subtotalqtyoutput=0;$subtotalselisih=0;
		$sql = "select distinct description,slocid
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
						and a.companyid = " . $companyid . "  and c.productname like '%" . $product . "%' 
						and e.fullname like '%" . $supplier . "%'
						and a.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
						and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
						where poqty>grqty
						";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(1, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
					->setCellValueByColumnAndRow(3, 2, date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
					->setCellValueByColumnAndRow(5, 1, $this->GetCompanyCode($companyid));
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
			
			$sql1 = "select *
							from (select distinct productname, uomcode, sum(poqty) as poqty, sum(grqty) as grqty, sum(poqty-grqty) as selisih
							from (select e.productname, d.uomcode, a.poqty, 
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
							and b.companyid = " . $companyid . " and e.productname like '%" . $product . "%' 
							and f.fullname like '%" . $supplier . "%' 
							and a.slocid = " . $row['slocid'] . "
							and b.docdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
							and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "') z
							where poqty>grqty
							group by productname) zz
							";
      $command=$this->connection->createCommand($sql1);$dataReader1=$command->queryAll();
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
	
}