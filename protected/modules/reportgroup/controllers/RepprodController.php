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
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']))
    {
      if ($_GET['lro'] == 1) {
        $this->RincianProduksiPerDokumen($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 2) {
        $this->RekapProduksiPerBarang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 3) {
        $this->RincianPemakaianPerDokumen($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 4) {
        $this->RekapPemakaianPerBarang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 5) {
        $this->PerbandinganPlanningOutput($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 6) {
        $this->RwBelumAdaGudangAsal($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 7) {
        $this->RwBelumAdaGudangTujuan($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 8) {
        $this->PendinganProduksi($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 9) {
        $this->RincianPendinganProduksiPerBarang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 10) {
        $this->RekapPendinganProduksiPerBarang($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 11) {
        $this->RekapProduksiPerBarangPerHari($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 12) {
        $this->RekapHasilProduksiPerDokumentBelumStatusMax($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 13) {
        $this->RekapProduksiPerBarangPerBulan($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else if ($_GET['lro'] == 14) {
        $this->RincianHasilOperator($_GET['company'], $_GET['sloc'], $_GET['product'], $_GET['startdate'], $_GET['enddate']);
      } else {
				echo $this->getCatalog('reportdoesnotexist');
			}               
		}
	}
	//1
	public function RincianProduksiPerDokumen($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.productoutputno,a.productoutputdate,a.productoutputid,e.productplanno as spp
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				where a.recordstatus = 3 and a.productoutputno is not null and d.sloccode like '%".$sloc."%' and
				e.companyid = ".$companyid." and c.productname like '%".$product."%' and
				a.productoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productoutputdate";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Produksi Per Dokumen';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['productoutputno']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productoutputdate'])));
				$this->pdf->text(135,$this->pdf->gety()+10,'No SPP');$this->pdf->text(150,$this->pdf->gety()+10,': '.$row['spp']);
				$sql1 = "select distinct b.productname,a.qtyoutput,c.uomcode,a.description ,d.description as sloc
						from productoutputfg a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join sloc d on d.slocid = a.slocid
						where b.productname like '%".$product."%' and a.productoutputid = ".$row['productoutputid'];
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+20);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,20,20,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Gudang','Keterangan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','C','L','L');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qtyoutput']),$row1['uomcode'],$row1['sloc'],
						$row1['description']
					));
					$totalqty += $row1['qtyoutput'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						''
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function RekapProduksiPerBarang($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct g.materialgroupid,g.description
				from productoutput a
				join productoutputfg b on b.productoutputid = a.productoutputid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				join productplan e on e.productplanid = a.productplanid
				join productplant f on f.productid = b.productid
				join materialgroup g on g.materialgroupid = f.materialgroupid
				where a.productoutputno is not null and e.companyid = ".$companyid." and a.recordstatus = 3
				and d.sloccode like '%".$sloc."%' and c.productname like '%".$product."%' 
				and a.productoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Produksi Per Barang';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Divisi');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
				$sql1 = "select distinct productname,uomcode,materialgroupid,sum(qtyoutput) as qtyoutput from 
					(select distinct b.productname,a.qtyoutput,e.uomcode,c.materialgroupid,a.productoutputfgid
					from productoutputfg a
					inner join product b on b.productid = a.productid
					inner join productoutput d on d.productoutputid = a.productoutputid
					inner join unitofmeasure e on e.unitofmeasureid = a.uomid
					inner join productplant c on c.productid = a.productid and c.slocid = a.slocid and c.unitofissue = a.uomid
					join sloc f on f.slocid = a.slocid
					join productplan g on g.productplanid = d.productplanid 
					where b.productname like '%".$product."%' and d.recordstatus = 3 and f.sloccode like '%".$sloc."%'
					and g.companyid = ".$companyid." and d.productoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and c.materialgroupid = ".$row['materialgroupid'].") z 
					group by productname,uomcode,materialgroupid";
			
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+15);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(10,120,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','C','R');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						$row1['uomcode'],
						Yii::app()->format->formatNumber($row1['qtyoutput'])
					));
					$totalqty += $row1['qtyoutput'];
				}
				$this->pdf->row(array(
						'','Total '.$row['description'],'',
						Yii::app()->format->formatNumber($totalqty)
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function RincianPemakaianPerDokumen($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.productoutputid,a.productoutputno as dokumen,a.productoutputdate as tanggal,e.sloccode
				from productoutput a
				join productplan b on b.productplanid = a.productplanid
				join productoutputdetail c on c.productoutputid = a.productoutputid
				join product d on d.productid = c.productid
				join sloc e on e.slocid = c.toslocid 
				where a.productoutputno is not null and b.companyid = ".$companyid." and e.sloccode like '%".$sloc."%' 
				and d.productname like '%".$product."%' 
				and a.productoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productoutputdate";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rincian Pemakaian Per Dokumen';
			$this->pdf->text(10,$this->pdf->gety()+10,'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['dokumen']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['tanggal'])));
				$this->pdf->text(10,$this->pdf->gety()+20,'Gudang');$this->pdf->text(30,$this->pdf->gety()+20,': '.$row['sloccode']);
				$sql1 = "select distinct b.productname,a.qty,c.uomcode,e.description as rak,a.description,
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
						where a.productoutputid = ".$row['productoutputid'];
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,40,20,20,20,25,25,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Rak','Asal','Tujuan','Keterangan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','C','L','L','L','L');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],
						$row1['rak'],$row1['sumber'],$row1['tujuan'],$row1['description']
					));
					$totalqty += $row1['qty'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						'','','',''
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function RekapPemakaianPerBarang($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
			$sql = "select distinct a.toslocid,a.fromslocid,
				e.sloccode fromsloccode,
			e.description as fromslocdesc,
			f.sloccode as tosloccode,	
			f.description as toslocdesc
					from productoutputdetail a
					join product b on b.productid = a.productid
					join productoutput c on c.productoutputid = a.productoutputid
					join sloc e on e.slocid = a.fromslocid
					join sloc f on f.slocid = a.toslocid
					where c.recordstatus = 3 and (e.sloccode like '%".$sloc."%' or f.sloccode like '%".$sloc."%') 
					and b.productname like '%".$product."%' and c.productoutputdate between 
					'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
					'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Rekap Pemakaian Per Barang';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Asal');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['fromsloccode'].' - '.$row['fromslocdesc']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tujuan');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['tosloccode'].' - '.$row['toslocdesc']);
				$sql1 = "select distinct a.productid,b.productname,d.uomcode,sum(a.qty) as qty
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						where c.recordstatus = 3 and a.fromslocid = ".$row['fromslocid']." and a.toslocid = " . $row['toslocid'] . " and b.productname like '%".$product."%' and c.productoutputdate between 
						'". date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
						'".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						group by productid,productname";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqty=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+20);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(10,120,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','C','R');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						$row1['uomcode'],
						Yii::app()->format->formatNumber($row1['qty'])
					));
					$totalqty += $row1['qty'];
				}
				$this->pdf->row(array(
						'','Total','',
						Yii::app()->format->formatNumber($totalqty)
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function PerbandinganPlanningOutput($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownpdf();
		$sql = "select distinct a.productplanno,a.productplandate,a.productplanid,d.sloccode,d.description as slocdesc
				from productplan a
				join productplanfg b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.slocid
				where a.recordstatus = 3 and a.productplanno is not null and a.companyid = ".$companyid." and d.sloccode like '%".$sloc."%' and c.productname like '%".$product."%' and
				a.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Perbandingan Planning Output';
			$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['productplanno']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
				$this->pdf->text(100,$this->pdf->gety()+10,'Sloc');$this->pdf->text(130,$this->pdf->gety()+10,': '.$row['sloccode'].'-'.$row['slocdesc']);
				$this->pdf->text(10,$this->pdf->gety()+22,'FG');
				$sql1 = "select b.productname,a.qty as qtyplan, (
					select ifnull(sum(ifnull(c.qtyoutput,0)),0)
					from productoutputfg c
					join productoutput g on g.productoutputid = c.productoutputid 
					where c.productplanfgid = a.productplanfgid and g.recordstatus = 3
					) as qtyout,d.uomcode,f.sloccode,f.description as slocdesc
					from productplanfg a 
					inner join product b on b.productid = a.productid 
					inner join unitofmeasure d on d.unitofmeasureid = a.uomid
					inner join sloc f on f.slocid = a.slocid
					where a.productplanid = ".$row['productplanid'];
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$totalqtyplan = 0;$i=0;$totalqtyout=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C');
				$this->pdf->setwidths(array(10,120,20,20,20));
				$this->pdf->colheader = array('No','Nama Barang','Qty Plan','Qty Out','Satuan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','C');
				$this->pdf->setFont('Arial','',8);
				
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qtyplan']),
						Yii::app()->format->formatNumber($row1['qtyout']),
						$row1['uomcode']
					));
					$totalqtyplan += $row1['qtyplan'];
					$totalqtyout += $row1['qtyout'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqtyplan),
						Yii::app()->format->formatNumber($totalqtyout),
						''
					));
				$this->pdf->text(10,$this->pdf->gety()+5,'Detail');					
				$sql2 = "select distinct b.productname, a.qty as qtyplan,ifnull(f.qty,0) as qtyout, c.uomcode, a.description,
				(select sloccode from sloc d where d.slocid = a.fromslocid) as fromsloccode,
				(select description from sloc d where d.slocid = a.fromslocid) as fromslocdesc,
				(select sloccode from sloc d where d.slocid = a.toslocid) as tosloccode,	
				(select description from sloc d where d.slocid = a.toslocid) as toslocdesc			
				from productplandetail a
				left join productoutputdetail f on f.productplandetailid = a.productplandetailid
				left join product b on b.productid = a.productid
				left join unitofmeasure c on c.unitofmeasureid = a.uomid
				left join billofmaterial d on d.bomid = a.bomid
				left join sloc e on e.slocid = a.fromslocid 
				left join productoutput g on g.productoutputid=f.productoutputid
				where g.recordstatus = 3 and b.isstock = 1 and a.productplanid = ".$row['productplanid'];
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				$totalqtyplan1 = 0;$ii=0;$totalqtyout1=0;
				$this->pdf->sety($this->pdf->gety()+10);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C');
				$this->pdf->setwidths(array(10,120,20,20,20));
				$this->pdf->colheader = array('No','Nama Barang','Qty Plan','Qty Out','Satuan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','C');
				$this->pdf->setFont('Arial','',8);
	
				foreach($dataReader2 as $row2)
				{
					$ii+=1;
					$this->pdf->row(array(
						$ii,$row2['productname'],
						Yii::app()->format->formatNumber($row2['qtyplan']),
						Yii::app()->format->formatNumber($row2['qtyout']),$row2['uomcode']
					));
					$totalqtyplan1 += $row2['qtyplan'];
					$totalqtyout1 += $row2['qtyout'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqtyplan1),
						Yii::app()->format->formatNumber($totalqtyout1),
						''
					));
				$this->pdf->AddPage();
			}
			$this->pdf->Output();
	}
	
	public function RwBelumAdaGudangAsal($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.productplanno,a.productplandate,a.productplanid
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.fromslocid
				where a.recordstatus > 0 and d.sloccode like '%".$sloc."%' 
				and a.companyid = ".$companyid." and c.productname like '%".$product."%'
				and a.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'				
				and b.fromslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid)";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Raw Material Gudang Asal Belum Ada di Data Gudang';
			$this->pdf->text(10,$this->pdf->gety()+10,'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['productplanno']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
				$sql1 = "select distinct b.productname,a.qty,c.uomcode,d.description,d.productplandate,
						(select sloccode from sloc xx where xx.slocid = a.fromslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.fromslocid
						where b.productname like '%".$product."%' and e.sloccode like '%".$sloc."%' 
						and d.companyid = ".$companyid." and d.recordstatus > 0
						and d.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and a.productplanid = ".$row['productplanid']."
						and a.fromslocid not in (select x.slocid from productplant x where x.productid = a.productid)";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,20,20,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Gudang Asal','Keterangan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','C','L','L');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],$row1['sloc'],
						$row1['description']
					));
					$totalqty += $row1['qty'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						''
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function RwBelumAdaGudangTujuan($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.productplanno,a.productplandate,a.productplanid,a.recordstatus
				from productplan a
				join productplandetail b on b.productplanid = a.productplanid
				join product c on c.productid = b.productid
				join sloc d on d.slocid = b.toslocid
				where d.sloccode like '%".$sloc."%' and a.recordstatus > 0 
				and a.companyid = ".$companyid." and c.productname like '%".$product."%'
				and a.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
				and b.toslocid not in (select xx.slocid from productplant xx where xx.productid = b.productid)";
			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Raw Material Gudang Tujuan Belum Ada di Data Gudang';
			$this->pdf->text(10,$this->pdf->gety()+10,'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['productplanno']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
				$sql1 = "select distinct b.productname,a.qty,c.uomcode,d.description,
						(select sloccode from sloc xx where xx.slocid = a.toslocid) as sloc
						from productplandetail a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join productplan d on d.productplanid = a.productplanid
						join sloc e on e.slocid = a.toslocid
						where b.productname like '%".$product."%' and e.sloccode like '%".$sloc."%'
						and d.companyid = ".$companyid." and d.recordstatus > 0 and a.productplanid = ".$row['productplanid']."
						and d.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						and a.toslocid not in (select x.slocid from productplant x where x.productid = a.productid)";
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,80,20,20,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Qty','Satuan','Gudang Tujuan','Keterangan');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','C','L','L');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						Yii::app()->format->formatNumber($row1['qty']),$row1['uomcode'],$row1['sloc'],
						$row1['description']
					));
					$totalqty += $row1['qty'];
				}
				$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatNumber($totalqty),'',
						''
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	
	public function PendinganProduksi($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.productplanno,a.productplandate,a.productplanid
			   from productplan a
			   join productplanfg b on b.productplanid = a.productplanid
			   join product c on c.productid = b.productid
			   join sloc d on d.slocid = b.slocid
			   where a.recordstatus = 3 and a.productplanno is not null and d.sloccode like '%".$sloc."%' 
			   and a.companyid = ".$companyid." and c.productname like '%".$product."%' and b.qty > b.qtyres
			   and a.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
			   and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productplanno";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Pendingan Produksi';
			$this->pdf->text(10,$this->pdf->gety()+10,'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)));
			$this->pdf->AddPage('P');
			$alltotalqty = 0; $alltotalqtyoutput = 0;
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Dokumen');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['productplanno']);
				$this->pdf->text(10,$this->pdf->gety()+15,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));
				
				$sql1 = "select distinct b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,c.uomcode,d.description as sloc						
						from productplanfg a						
						join product b on b.productid = a.productid						
						join unitofmeasure c on c.unitofmeasureid = a.uomid						
						join sloc d on d.slocid = a.slocid
						join productplan e on e.productplanid = a.productplanid						
						where b.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and a.qty > a.qtyres
						and e.companyid = ".$companyid." and e.recordstatus = 3
						and e.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' and a.productplanid = ".$row['productplanid']; 
				
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				$total = 0;$i=0;$totalqty=0;$totalqtyoutput=0;
				$this->pdf->sety($this->pdf->gety()+25);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,70,20,20,20,30,20));
				$this->pdf->colheader = array('No','Nama Barang','Qty','QtyOutput','Satuan','Gudang','Selisih');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','R','R','C','L','L');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
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
						'','Total',
						Yii::app()->format->formatNumber($totalqty),
						Yii::app()->format->formatNumber($totalqtyoutput),
						''
					));
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->row(array(
						'','Total Keseluruhan',
						Yii::app()->format->formatNumber($alltotalqty),
						Yii::app()->format->formatNumber($alltotalqtyoutput),
						'',
						Yii::app()->format->formatNumber($alltotalqty-$alltotalqtyoutput),
					));
			$this->pdf->Output();
	}
	
	public function RincianPendinganProduksiPerBarang($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$subtotalqty=0;
		$subtotalqtyoutput=0;
		$subtotalselisih=0;
		$sql = "select distinct d.description,d.slocid
						 from productplan a
						 join productplanfg b on b.productplanid = a.productplanid
						 join product c on c.productid = b.productid
						 join sloc d on d.slocid = b.slocid
						 where a.recordstatus = 3 and d.sloccode like '%".$sloc."%' 
						 and a.companyid = ".$companyid." and c.productname like '%".$product."%' and b.qty > b.qtyres
						 and b.startdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						 and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Pendingan Produksi Per Barang';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'GUDANG');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
			$this->pdf->SetFont('Arial','',9);
			$sql1 = "select distinct b.productname,b.productid
				from productplanfg a	
				join product b on b.productid = a.productid	
				join unitofmeasure c on c.unitofmeasureid = a.uomid	
				join sloc d on d.slocid = a.slocid
				join productplan e on e.productplanid = a.productplanid	
				where b.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and a.qty > a.qtyres
				and e.companyid = ".$companyid." and e.recordstatus = 3
				and e.productplanno is not null
				and a.startdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
				and a.slocid = ".$row['slocid']." ";  
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totalqty=0;
			$totalqtyoutput=0;
			$totalselisih=0;

			$this->pdf->setFont('Arial','',8);
			foreach($dataReader1 as $row1)
			{
				$this->pdf->checkPageBreak(30);
				$this->pdf->SetFont('Arial','B',9);
				$this->pdf->text(10,$this->pdf->gety()+15,'Nama Barang ');$this->pdf->text(33,$this->pdf->gety()+15,': '.$row1['productname']);
				$sql2 = "select distinct e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
					c.uomcode,d.description as sloc,e.productplanno,e.productplandate,a.startdate
					from productplanfg a	
					join product b on b.productid = a.productid	
					join unitofmeasure c on c.unitofmeasureid = a.uomid	
					join sloc d on d.slocid = a.slocid
					join productplan e on e.productplanid = a.productplanid	
					where b.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and a.qty > a.qtyres
					and e.companyid = 1 and e.recordstatus = 3
					and e.productplanno is not null
					and a.startdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."'
					and b.productid = ".$row1['productid']. " and d.slocid = ".$row['slocid']."";        
				$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
				$this->pdf->sety($this->pdf->gety()+18);
				$this->pdf->setFont('Arial','',8);
				$this->pdf->colalign = array('C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(10,40,25,15,35,35,35));
				$this->pdf->colheader = array('No','No SPP','Tgl Mulai','Satuan','Qty SPP','Qty OP','Selisih');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('C','L','C','C','R','R','R');
				$i=0;
				$jumlahqty = 0;
				$jumlahqtyoutput =0;
				$jumlahselisih = 0;
				foreach($dataReader2 as $row2)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row2['productplanno'],
						Yii::app()->format->formatDate($row2['startdate']),
						$row2['uomcode'],
						Yii::app()->format->formatNumber($row2['qty']),
						Yii::app()->format->formatNumber($row2['qtyoutput']),
						Yii::app()->format->formatNumber($row2['selisih'])));
						$jumlahqty += $row2['qty'];
						$jumlahqtyoutput += $row2['qtyoutput'];
						$jumlahselisih += $row2['selisih'];
				}
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array(
					'','Jumlah '
					,'','',
					Yii::app()->format->formatNumber($jumlahqty),
					Yii::app()->format->formatNumber($jumlahqtyoutput),
					Yii::app()->format->formatNumber($jumlahselisih)
				));
				$totalqty += $jumlahqty;
				$totalqtyoutput += $jumlahqtyoutput;
				$totalselisih += $jumlahselisih;
			}
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
					'','Total '.$row['description']
					,'','',
					Yii::app()->format->formatNumber($totalqty),
					Yii::app()->format->formatNumber($totalqtyoutput),
					Yii::app()->format->formatNumber($totalselisih)
			));
			$subtotalqty+= $totalqty;
			$subtotalqtyoutput+=$totalqtyoutput;
			$subtotalselisih+=$totalselisih;
			$this->pdf->checkPageBreak(20);
		}
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->setFont('Arial','B',11);
			$this->pdf->row(array(
					'','Grand Total '
					,'','',
					Yii::app()->format->formatNumber($subtotalqty),
					Yii::app()->format->formatNumber($subtotalqtyoutput),
					Yii::app()->format->formatNumber($subtotalselisih)
			));
		$this->pdf->Output();
	}
	
	public function RekapPendinganProduksiPerBarang($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
		$subtotalqty=0;
		$subtotalqtyoutput=0;
		$subtotalselisih=0;
		$sql = "select distinct d.description,d.slocid
			from productplan a
			join productplanfg b on b.productplanid = a.productplanid
			join product c on c.productid = b.productid
			join sloc d on d.slocid = b.slocid
			where a.recordstatus = 3 and d.sloccode like '%".$sloc."%' 
			and a.companyid = ".$companyid." and c.productname like '%".$product."%' and b.qty > b.qtyres
			and a.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
			and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productplanno";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Pendingan Produksi Per Barang';
		$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','B',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'GUDANG');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
							
			
			$sql1 = "select *,sum(qty) as sumqty,sum(qtyoutput) as sumqtyoutput,sum(selisih) as sumselisih
				from
				 (select distinct e.productplanid,b.productname,a.qty,a.qtyres as qtyoutput,(a.qty-a.qtyres) as selisih,
				c.uomcode,d.description as sloc,e.productplanno,e.productplandate	
				from productplanfg a	
				join product b on b.productid = a.productid	
				join unitofmeasure c on c.unitofmeasureid = a.uomid	
				join sloc d on d.slocid = a.slocid
				join productplan e on e.productplanid = a.productplanid	
				where b.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and a.qty > a.qtyres
				and e.companyid = ".$companyid." and e.recordstatus = 3
				and e.productplanno is not null
				and e.productplandate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
				and '". date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
				and a.slocid = ".$row['slocid']." order by productname) z group by productname";
			
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$totalqty=0;$i=0;$totalqtyoutput=0;$totalselisih=0;
			$this->pdf->sety($this->pdf->gety()+18);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,70,25,25,25,25,35));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty SPP','Qty OP','Selisih');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('C','L','C','C','R','R','R');
			$this->pdf->setFont('Arial','',8);
															
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->row(array(
					$i,$row1['productname'],
					$row1['uomcode'],
					Yii::app()->format->formatNumber($row1['sumqty']),
					Yii::app()->format->formatNumber($row1['sumqtyoutput']),
					Yii::app()->format->formatNumber($row1['sumselisih'])
				));
				$totalqty += $row1['sumqty'];
				$totalqtyoutput += $row1['sumqtyoutput'];
				$totalselisih += $row1['sumselisih'];														 
			}
			$this->pdf->setFont('Arial','B',9);
			$this->pdf->row(array(
				'','Total '.$row['description'],
				'',
				Yii::app()->format->formatNumber($totalqty),
				Yii::app()->format->formatNumber($totalqtyoutput),
				Yii::app()->format->formatNumber($totalselisih)
			));
			$subtotalqty += $totalqty;
			$subtotalqtyoutput += $totalqtyoutput;
			$subtotalselisih += $totalselisih;
		}
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->setFont('Arial','B',11);
		$this->pdf->row(array(
			'','Grand Total ',
			'',
			Yii::app()->format->formatNumber($subtotalqty),
			Yii::app()->format->formatNumber($subtotalqtyoutput),
			Yii::app()->format->formatNumber($subtotalselisih)
			));
		$this->pdf->Output();
	}
	//11
	public function RekapProduksiPerBarangPerHari($companyid, $sloc, $product, $startdate, $enddate)
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
				where a.productoutputno is not null and e.companyid = " . $companyid . " and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and a.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
				and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "'";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Produksi Per Barang Per Hari';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L', 'Legal');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 7);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
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
								where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
								and g.companyid = " . $companyid . " and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
								and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . " ) z 
								group by productname,uomcode,materialgroupid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
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
	public function RekapHasilProduksiPerDokumentBelumStatusMax($companyid, $sloc, $product, $startdate, $enddate)
  {
    parent::actionDownPDF();
    $sql        = "select distinct b.productoutputid,b.productoutputid,b.recordstatus,
					b.productoutputno,b.productoutputdate,c.productplanno,b.description 
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
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
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
    $totalnominal1             = 0;
    $i                         = 0;
    $totaldisc1                = 0;
    $totaljumlah1              = 0;
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
        Wfstatus::model()->findstatusname("apppayreq", $row['recordstatus'])
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
	public function RekapProduksiPerBarangPerBulan($companyid, $sloc, $product, $startdate, $enddate)
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
				where a.productoutputno is not null and e.companyid = " . $companyid . " and a.recordstatus = 3
				and d.sloccode like '%" . $sloc . "%' and c.productname like '%" . $product . "%' 
				and year(a.productoutputdate) = year('" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "')";
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title    = 'Rekap Produksi Per Barang Per Bulan';
    $this->pdf->subtitle = 'Dari Tgl :' . date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)) . ' s/d ' . date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('L','F4');
    foreach ($dataReader as $row) {
      $this->pdf->SetFont('Arial', '', 10);
      $this->pdf->text(10, $this->pdf->gety() + 10, 'Divisi');
      $this->pdf->text(30, $this->pdf->gety() + 10, ': ' . $row['description']);
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
					where b.productname like '%" . $product . "%' and d.recordstatus = 3 and f.sloccode like '%" . $sloc . "%'
					and g.companyid = " . $companyid . " and d.productoutputdate between '" . date(Yii::app()->params['datetodb'], strtotime($startdate)) . "' 
					and '" . date(Yii::app()->params['datetodb'], strtotime($enddate)) . "' and c.materialgroupid = " . $row['materialgroupid'] . ") z 
					group by productname,uomcode";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
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
          Yii::app()->format->formatNumber($row1['januari']),
          Yii::app()->format->formatNumber($row1['februari']),
          Yii::app()->format->formatNumber($row1['maret']),
          Yii::app()->format->formatNumber($row1['april']),
          Yii::app()->format->formatNumber($row1['mei']),
          Yii::app()->format->formatNumber($row1['juni']),
          Yii::app()->format->formatNumber($row1['juli']),
          Yii::app()->format->formatNumber($row1['agustus']),
          Yii::app()->format->formatNumber($row1['september']),
          Yii::app()->format->formatNumber($row1['oktober']),
          Yii::app()->format->formatNumber($row1['nopember']),
          Yii::app()->format->formatNumber($row1['desember']),
          Yii::app()->format->formatNumber($row1['jumlah']),
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
        Yii::app()->format->formatNumber($totaljanuari),
        Yii::app()->format->formatNumber($totalfebruari),
        Yii::app()->format->formatNumber($totalmaret),
        Yii::app()->format->formatNumber($totalapril),
        Yii::app()->format->formatNumber($totalmei),
        Yii::app()->format->formatNumber($totaljuni),
        Yii::app()->format->formatNumber($totaljuli),
        Yii::app()->format->formatNumber($totalagustus),
        Yii::app()->format->formatNumber($totalseptember),
        Yii::app()->format->formatNumber($totaloktober),
        Yii::app()->format->formatNumber($totalnopember),
        Yii::app()->format->formatNumber($totaldesember),
        Yii::app()->format->formatNumber($totaljumlah),
      ));
      $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  //14
   public function RincianHasilOperator($companyid,$sloc,$product,$startdate,$enddate)
  {
     parent::actionDownPDF();

     $sql = " select b.employeeid,d.sloccode,b.fullname
              from operatoroutputdet a
              join employee b on b.employeeid=a.employeeid
              join operatoroutput c on c.operatoroutputid=a.operatoroutputid
              join sloc d on d.slocid=c.slocid
              where c.companyid= ".$companyid." and c.recordstatus = 2
              and d.sloccode like '%".$sloc."%' 
              and c.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
              and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by b.employeeid " ;

              $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

     foreach($dataReader as $row)
     {
       $this->pdf->companyid = $companyid;
     }
     $this->pdf->title='Rincian Hasil Operator';
     $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
     $this->pdf->AddPage('P');

     foreach($dataReader as $row)
     {
       $this->pdf->SetFont('Arial','B',9);
       $this->pdf->text(10,$this->pdf->gety()+5,'KARYAWAN');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fullname']);
       $this->pdf->sety($this->pdf->gety()+8);            
       $this->pdf->setFont('Arial','B',8);
       $this->pdf->colalign = array('C','C','C','C','C','C','C');
       $this->pdf->setwidths(array(10,60,25,25,25,25,25));
       $this->pdf->coldetailalign = array('L','L','R','R','R','R','R');
       $this->pdf->colheader = array('No','Tgl Hasil Operator','Qty','Nilai Point','Jumlah Point','Jumlah Target','Pencapaian (%)');
       $this->pdf->RowHeader();
       $sql1 = " select distinct b.standardopoutputid,b.groupname,e.sloccode
                from operatoroutputdet a
                join standardopoutput b on b.standardopoutputid=a.standardopoutputid
                join employee c on c.employeeid=a.employeeid
                join operatoroutput d on d.operatoroutputid=a.operatoroutputid
                join sloc e on e.slocid=b.slocid
                where d.companyid = ".$companyid." and d.recordstatus = 2
                and a.employeeid='".$row['employeeid']."'
                and e.sloccode like '%".$sloc."%' 
                and d.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";

       $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
       $totalqty1=0;
       foreach($dataReader1 as $row1)
       {
         $this->pdf->SetFont('Arial','B',8);
         $this->pdf->text(10,$this->pdf->gety()+5,'NAMA KELOMPOK');$this->pdf->text(40,$this->pdf->gety()+5,': '.$row1['groupname']);
         $this->pdf->sety($this->pdf->gety()+8); 
         $sql2 = " select distinct c.employeeid,c.fullname,b.groupname,d.opoutputdate,a.qty,b.standardvalue,a.qty*b.standardvalue as nilai
                    from operatoroutputdet a
                    join standardopoutput b on b.standardopoutputid=a.standardopoutputid
                    join employee c on c.employeeid=a.employeeid
                    join operatoroutput d on d.operatoroutputid=a.operatoroutputid
                    where d.recordstatus =2 
                    and a.employeeid='".$row['employeeid']."'
                    and b.standardopoutputid='".$row1['standardopoutputid']."'
                    and d.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                    and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'";
         $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
         $totalqty=0;$i=0;
         $this->pdf->SetFont('Arial','',8);
         foreach($dataReader2 as $row2)
         {
           $i+=1;
           $this->pdf->colalign = array('C','C','C','C','C');
           $this->pdf->setwidths(array(10,60,25,25,25));
           $this->pdf->coldetailalign = array('L','L','R','R','R');
           $this->pdf->row(array(
           $i,$row2['opoutputdate'],
           Yii::app()->format->formatNumber($row2['qty']),
           Yii::app()->format->formatNumber($row2['standardvalue']),
           Yii::app()->format->formatNumber($row2['nilai'])
           ));
           $totalqty+= $row2['nilai'];
         }
         $this->pdf->colalign = array('C','C','C');
         $this->pdf->setwidths(array(10,110,25));
         $this->pdf->coldetailalign = array('R','R','R');
         $this->pdf->SetFont('Arial','B',8);
         $this->pdf->row(array(
            '','TOTAL POINT '.$row1['groupname'].' '.$row['fullname'],
            Yii::app()->format->formatNumber($totalqty)
          ));
         $this->pdf->checkPageBreak(20);

         $totalqty1+= $totalqty;
       }
       $sql3 =  "select ifnull(count(1),0) as count
                from (select distinct a.opoutputdate
                from operatoroutput a
                join operatoroutputdet b on b.operatoroutputid=a.operatoroutputid
                join standardopoutput c on c.standardopoutputid=b.standardopoutputid
                join sloc d on d.slocid=a.slocid
                join employee e on e.employeeid=b.employeeid
                where a.companyid = ".$companyid." and a.recordstatus = 2 
                and e.employeeid='".$row['employeeid']."'
                and d.sloccode like '%".$sloc."%' 
                and a.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by opoutputdate) z";
       $cmd=Yii::app()->db->createCommand($sql3)->queryScalar();
       $this->pdf->colalign = array('C','C','C','C','C');
       $this->pdf->setwidths(array(10,110,25,25,25));
       $this->pdf->coldetailalign = array('R','R','R','R','R');
       $this->pdf->SetFont('Arial','BI',9);
       $this->pdf->row(array(
          '','GRAND TOTAL POINT '.$row['fullname'],
          Yii::app()->format->formatNumber($totalqty1),
          Yii::app()->format->formatNumber($cmd * 100),
          Yii::app()->format->formatNumber(($totalqty1/($cmd * 100))*100)
       ));
       $this->pdf->checkPageBreak(20);
    }
    $this->pdf->Output();
  }
  /*public function RekapHasilOperator($companyid,$sloc,$product,$startdate,$enddate)
	{
		parent::actionDownPDF();
      
    $sql = " select b.employeeid,d.sloccode,b.fullname
              from operatoroutputdet a
              join employee b on b.employeeid=a.employeeid
              join operatoroutput c on c.operatoroutputid=a.operatoroutputid
              join sloc d on d.slocid=c.slocid
              where c.companyid= ".$companyid." and c.recordstatus = 2
              and d.sloccode like '%".$sloc."%' 
              and c.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
              and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' group by b.employeeid " ;       

    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();

    foreach($dataReader as $row)
    {
      $this->pdf->companyid = $companyid;
    }
    $this->pdf->title='Rekap Hasil Operator';
    $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
    $this->pdf->AddPage('P');

    foreach($dataReader as $row)
    {
      $this->pdf->SetFont('Arial','B',9);
      $this->pdf->text(10,$this->pdf->gety()+3,'KARYAWAN');$this->pdf->text(30,$this->pdf->gety()+3,' : '.$row['fullname']); $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(25,90,20,20,20));
      $this->pdf->colheader = array('Tanggal','Gudang','Qty','Nilai Point','Jumlah Point');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('C','L','R','R','R');
      $this->pdf->setFont('Arial','',8);
      $sql1 =  "select a.opoutputdate,d.sloccode,e.fullname,sum(b.qty) as qty,c.standardvalue,d.description,sum(b.qty*c.standardvalue) as nilai
                from operatoroutput a
                join operatoroutputdet b on b.operatoroutputid=a.operatoroutputid
                join standardopoutput c on c.standardopoutputid=b.standardopoutputid
                join sloc d on d.slocid=a.slocid
                join employee e on e.employeeid=b.employeeid
                where a.companyid = ".$companyid." and a.recordstatus = 2 
                and e.employeeid='".$row['employeeid']."'
                and d.sloccode like '%".$sloc."%' 
                and a.opoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
                and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
                group by opoutputdate";

      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

      $totalqty=0;$totalnilai=0;
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array(
        $row1['opoutputdate'],
        $row1['sloccode'].' - '.$row1['description'],              
        Yii::app()->format->formatNumber($row1['qty']),
        Yii::app()->format->formatNumber($row1['standardvalue']),
        Yii::app()->format->formatNumber($row1['nilai'])
        ));

        $totalqty += $row1['qty'];
        $totalnilai += $row1['nilai'];
      }
      $this->pdf->setFont('Arial','BI',8);
      $this->pdf->row(array(
        '','TOTAL '.$row['fullname'],
        Yii::app()->format->formatNumber($totalqty),'',
        Yii::app()->format->formatNumber($totalnilai),
      ));
      $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->checkPageBreak(20);
    }
		$this->pdf->Output();
	}*/
  
	public function actionDownXLS()
	{
	  parent::actionDownXLS();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate']))
		{
			if ($_GET['lro'] == 1)
			{
				$this->RincianProduksiPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 2)
			{
				$this->RekapProduksiPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 3)
			{
				$this->RincianPemakaianPerDokumenXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 4)
			{
				$this->RekapPemakaianPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 5)
			{
				$this->PerbandinganPlanningOutputXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RwBelumAdaGudangAsalXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RwBelumAdaGudangTujuanXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->PendinganProduksiXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
                        else
			if ($_GET['lro'] == 10)
			{
				$this->RekapPendinganProduksiPerBarangXLS($_GET['company'],$_GET['sloc'],$_GET['product'],$_GET['startdate'],$_GET['enddate']);
			}
			else
			{
				echo $this->getCatalog('reportdoesnotexist');
			}
		}
	}
        
       public function RincianProduksiPerDokumenXLS($companyid,$sloc,$product,$startdate,$enddate)
	{
		$this->menuname='rincianproduksiperdokumen';
		parent::actionDownxls();
		$totalppn=0;$totalnetto=0;$totalallqty=0;$totalalljumlah=0;
		$sql = "select distinct a.productoutputno,a.productoutputdate,a.productoutputid,e.productplanno as spp,e.productplandate
					from productoutput a
					join productoutputfg b on b.productoutputid = a.productoutputid
					join product c on c.productid = b.productid
					join sloc d on d.slocid = b.slocid
					join productplan e on e.productplanid = a.productplanid
					where a.recordstatus = 3 and a.productoutputno is not null and d.sloccode like '%".$sloc."%' and
					e.companyid = ".$companyid." and c.productname like '%".$product."%' and
					a.productoutputdate between '". date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
					and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."' order by productoutputdate";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
			->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
			->setCellValueByColumnAndRow(5,1,$this->GetCompanyCode($companyid));
		$line=4;
		
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Dokumen')
				->setCellValueByColumnAndRow(1,$line,': '.$row['productoutputno'])
				->setCellValueByColumnAndRow(5,$line,'No. SPP')
				->setCellValueByColumnAndRow(6,$line,': '.$row['spp']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Tanggal')
				->setCellValueByColumnAndRow(1,$line,': '.$row['productoutputdate'])
				->setCellValueByColumnAndRow(5,$line,'Tanggal')
				->setCellValueByColumnAndRow(6,$line,': '.$row['productplandate']);
			$line++;
			
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Qty')
				->setCellValueByColumnAndRow(3,$line,'Satuan')
				->setCellValueByColumnAndRow(4,$line,'Gudang')
				->setCellValueByColumnAndRow(5,$line,'Keterangan');
			$line++;
			
			$i=0;$totalqty=0;
			$sql1 = "select distinct b.productname,a.qtyoutput,c.uomcode,a.description ,d.description as sloc
						from productoutputfg a
						join product b on b.productid = a.productid
						join unitofmeasure c on c.unitofmeasureid = a.uomid
						join sloc d on d.slocid = a.slocid
						where b.productname like '%".$product."%' and a.productoutputid = ".$row['productoutputid'];
			$command1=$this->connection->createCommand($sql1);
			$dataReader1=$command1->queryAll();
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['productname'])
					->setCellValueByColumnAndRow(2,$line,$row1['qtyoutput'])
					->setCellValueByColumnAndRow(3,$line,$row1['uomcode'])
					->setCellValueByColumnAndRow(4,$line,$row1['sloc'])
					->setCellValueByColumnAndRow(5,$line,$row1['description']);
				$line++;
				
				$totalqty += $row1['qtyoutput'];
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'')
				->setCellValueByColumnAndRow(1,$line,'Total')
				->setCellValueByColumnAndRow(2,$line,$totalqty)
				->setCellValueByColumnAndRow(3,$line,'')
				->setCellValueByColumnAndRow(4,$line,'')
				->setCellValueByColumnAndRow(5,$line,'');
			$line+=2;			
		}
					
		$this->getFooterXLS($this->phpExcel);
	}

}

