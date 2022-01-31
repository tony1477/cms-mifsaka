<?php

class RepaccpersController extends AdminController
{
	protected $menuname = 'repaccpers';		
	public $module = 'accounting';
	protected $pageTitle = 'Laporan Persediaan';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
		
	public function actionDownPDF()
	{
	  parent::actionDownPDF();
	if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['materialgroup']) && isset($_GET['storagebin']) 
			&& isset($_GET['startdate']) && isset($_GET['enddate']) && ($_GET['company'] !== '')&& isset($_GET['per']))
		{
		
			if ($_GET['lro'] == 1)
			{
				$this->RekapPersediaanBarangDetail($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 3)
			{
				$this->RekapPenerimaanPersediaanBarangDetail($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 4)
			{
				$this->RekapPengeluaranPersediaanBarangDetail($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																else
			if ($_GET['lro'] == 5)
			{
				$this->HPP($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 6)
			{
				$this->HppBillOfMaterial($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RincianNilaiPemakaianStok($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RekapNilaiPemakaianStok($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RincianNilaiStockOpname($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RekapNilaiStockOpname($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->RincianHargaPokokPenjualan($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 12)
			{
				$this->RekapHargaPokokPenjualan($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			if ($_GET['lro'] == 2)
			{
				$this->RekapPersediaanBarangDetailDataHarga($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}	
		}
	}
	
	public function RekapPersediaanBarangDetail($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$qtyawal2=0;$nilaiawal2=0;$qtymasuk2=0;$nilaimasuk2=0;$qtytersedia2=0;$nilaitersedia2=0;$qtykeluar2=0;$nilaikeluar2=0;$qtyakhir2=0;$nilaiakhir2=0;
		$sql="select distinct slocid,sloccode,materialgroupid,description from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,slocid,sloccode,materialgroupid,description
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,slocid,sloccode,materialgroupid,description
							from
							(select
							(
							select distinct aa.productid 
							from productstockdet a
							join product aa on aa.productid = a.productid
							join sloc ab on ab.slocid = a.slocid
							join storagebin ac on ac.storagebinid=a.storagebinid
							where a.productid = t.productid and
							a.unitofmeasureid = t.unitofissue and
							ac.description like '%".$storagebin."%'
							) as barang,
							(
							select distinct bb.uomcode 
							from productstockdet b
							join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
							join sloc ba on ba.slocid = b.slocid
							join storagebin bc on bc.storagebinid=b.storagebinid
							where b.productid = t.productid and
							b.unitofmeasureid = t.unitofissue and
							bc.description like '%".$storagebin."%'
							) as satuan,
							(
							select ifnull(sum(aw.qty),0) 
							from productstockdet aw
							join sloc aaw on aaw.slocid = aw.slocid
							join storagebin abw on abw.storagebinid=aw.storagebinid
							where aw.productid = t.productid and
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid and
							abw.description like '%".$storagebin."%'
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							join storagebin ccc on ccc.storagebinid=c.storagebinid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							ccc.description like '%".$storagebin."%' and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							join storagebin ddd on ddd.storagebinid=d.storagebinid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							ddd.description like '%".$storagebin."%' and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							join storagebin eee on eee.storagebinid=e.storagebinid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							eee.description like '%".$storagebin."%' and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							join storagebin fff on fff.storagebinid=f.storagebinid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							fff.description like '%".$storagebin."%' and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							join storagebin ggg on ggg.storagebinid=g.storagebinid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							ggg.description like '%".$storagebin."%' and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							join storagebin hhh on hhh.storagebinid=h.storagebinid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							hhh.description like '%".$storagebin."%' and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							join storagebin iii on iii.storagebinid=i.storagebinid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							iii.description like '%".$storagebin."%' and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							join storagebin jjj on jjj.storagebinid=j.storagebinid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							jjj.description like '%".$storagebin."%' and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							join storagebin kkk on kkk.storagebinid=k.storagebinid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							kkk.description like '%".$storagebin."%' and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							join storagebin lll on lll.storagebinid=l.storagebinid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid and
							lll.description like '%".$storagebin."%' and
							l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							join storagebin mmm on mmm.storagebinid=m.storagebinid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							mmm.description like '%".$storagebin."%' and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,v.slocid,v.sloccode,u.materialgroupid,u.description
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
							where getcompanyfromsloc(v.slocid) = ".$companyid." and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%') z) zz )zzz where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0
					order by materialgroupid,slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Persediaan Barang (Detail)';
		$this->pdf->subtitle='Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','Legal');
		
		foreach ($dataReader as $row)
		{
			$this->pdf->setFont('Arial','',10);
			$this->pdf->text(15,$this->pdf->gety()+5,'GUDANG');$this->pdf->text(35,$this->pdf->gety()+5,': '.$row['sloccode']);
			$this->pdf->text(200,$this->pdf->gety()+5,'MATERIAL GROUP');$this->pdf->text(235,$this->pdf->gety()+5,': '.$row['description']);
			
			if ($storagebin == null)
			{$this->pdf->text(100,$this->pdf->gety()+5,'');$this->pdf->text(115,$this->pdf->gety()+5,'');}
			else
			{$this->pdf->text(100,$this->pdf->gety()+5,'RAK');$this->pdf->text(115,$this->pdf->gety()+5,': '.$storagebin);}
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+7);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,61,38,61,38,38,5));
			$this->pdf->colheader = array('','','','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
			$this->pdf->RowHeader();
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','C','R','R','R','R','R','R','R','R','R','R','R','R','C');
			
			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
			$sql1="select *,case when akhir < 0 then 'X' else '' end as minus from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,harga
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,harga
							from
							(select 
							(
							select distinct aa.productname 
							from productstockdet a
							join product aa on aa.productid = a.productid
							join sloc ab on ab.slocid = a.slocid
							join storagebin ac on ac.storagebinid=a.storagebinid
							where a.productid = t.productid and
							a.unitofmeasureid = t.unitofissue and
							ac.description like '%".$storagebin."%'
							) as barang,
							(
							select distinct bb.uomcode 
							from productstockdet b
							join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
							join sloc ba on ba.slocid = b.slocid
							join storagebin bc on bc.storagebinid=b.storagebinid
							where b.productid = t.productid and
							b.unitofmeasureid = t.unitofissue and
							bc.description like '%".$storagebin."%'
							) as satuan,
							(
							select ifnull(sum(aw.qty),0) 
							from productstockdet aw
							join sloc aaw on aaw.slocid = aw.slocid
							join storagebin aww on aww.storagebinid=aw.storagebinid
							where aw.productid = t.productid and
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid and
							aww.description like '%".$storagebin."%'
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							join storagebin ccc on ccc.storagebinid=c.storagebinid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							ccc.description like '%".$storagebin."%' and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							join storagebin ddd on ddd.storagebinid=d.storagebinid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							ddd.description like '%".$storagebin."%' and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							join storagebin eee on eee.storagebinid=e.storagebinid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							eee.description like '%".$storagebin."%' and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							join storagebin fff on fff.storagebinid=f.storagebinid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							fff.description like '%".$storagebin."%' and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							join storagebin ggg on ggg.storagebinid=g.storagebinid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							ggg.description like '%".$storagebin."%' and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							join storagebin hhh on hhh.storagebinid=h.storagebinid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							hhh.description like '%".$storagebin."%' and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							join storagebin iii on iii.storagebinid=i.storagebinid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							iii.description like '%".$storagebin."%' and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							join storagebin jjj on jjj.storagebinid=j.storagebinid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							jjj.description like '%".$storagebin."%' and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							join storagebin kkk on kkk.storagebinid=k.storagebinid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							kkk.description like '%".$storagebin."%' and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							join storagebin lll on lll.storagebinid=l.storagebinid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid and
							lll.description like '%".$storagebin."%' and
							l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							join storagebin mmm on mmm.storagebinid=m.storagebinid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,
							ifnull((select q.harga 
							from dataharga q
							where q.productid=t.productid
							),0) as harga
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
									where getcompanyfromsloc(v.slocid) = ".$companyid."
              and u.materialgroupid = '".$row['materialgroupid']."' 
							and v.slocid = '".$row['slocid']."' and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%' order by barang) z) zz )zzz 
							where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0 order by barang asc";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach ($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',6.5);
				$this->pdf->row(array(
					$i,$row1['barang'],$row1['satuan'],
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['awal']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['masuk']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['masuk'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] + $row1['masuk'])),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],(($row1['awal'] + $row1['masuk']) * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['keluar']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['keluar'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['akhir']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['akhir'] * $row1['harga']/$per)),
					$row1['minus'],
				));
				$qtyawal += $row1['awal'];
				$nilaiawal += ($row1['awal'] * $row1['harga']/$per);
				$qtymasuk += $row1['masuk'];
				$nilaimasuk += ($row1['masuk'] * $row1['harga']/$per);
				$qtytersedia += ($row1['awal'] + $row1['masuk']);
				$nilaitersedia += (($row1['awal'] + $row1['masuk']) * $row1['harga']/$per);
				$qtykeluar += $row1['keluar'];
				$nilaikeluar += ($row1['keluar'] * $row1['harga']/$per);
				$qtyakhir += $row1['akhir'];
				$nilaiakhir += ($row1['akhir'] * $row1['harga']/$per);
			}
			$this->pdf->setFont('Arial','B',6.5);
			$this->pdf->setwidths(array(98,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->coldetailalign = array('R','R','R','R','R','R','R','R','R','R','R','R','R','C');
			$this->pdf->row(array(
				'TOTAL '.$row['sloccode'].' - '.$row['description'].'      >>>>>',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir),'',
			));
			$qtyawal2 += $qtyawal;
			$nilaiawal2 += $nilaiawal;
			$qtymasuk2 += $qtymasuk;
			$nilaimasuk2 += $nilaimasuk;
			$qtytersedia2 += $qtytersedia;
			$nilaitersedia2 += $nilaitersedia;
			$qtykeluar2 += $qtykeluar;
			$nilaikeluar2 += $nilaikeluar;
			$qtyakhir2 += $qtyakhir;
			$nilaiakhir2 += $nilaiakhir;
			
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkNewPage(175);
		}
		$this->pdf->setFont('Arial','BI',6.5);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,68,43,68,43,43,5));
		$this->pdf->colheader = array('','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
		$this->pdf->RowHeader();
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,18,25,25,18,25,18,25,25,18,25,18,25,5));
		$this->pdf->colheader = array('Keterangan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R','R','R','R','R','C');
		$this->pdf->row(array(
			'GRAND TOTAL      >>>>>',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir2),'',
		));
		
		$this->pdf->Output();
	}
	public function RekapPersediaanBarangDetailDataHarga($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	//Masih menggunakan Data Harga
	{
		parent::actionDownPDF();
		$qtyawal2=0;$nilaiawal2=0;$qtymasuk2=0;$nilaimasuk2=0;$qtytersedia2=0;$nilaitersedia2=0;$qtykeluar2=0;$nilaikeluar2=0;$qtyakhir2=0;$nilaiakhir2=0;
		$sql="select distinct slocid,sloccode,materialgroupid,description from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,slocid,sloccode,materialgroupid,description
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,slocid,sloccode,materialgroupid,description
							from
							(select
							(
							select distinct aa.productid 
							from productstockdet a
							join product aa on aa.productid = a.productid
							join sloc ab on ab.slocid = a.slocid
							join storagebin ac on ac.storagebinid=a.storagebinid
							where a.productid = t.productid and
							a.unitofmeasureid = t.unitofissue and
							ac.description like '%".$storagebin."%'
							) as barang,
							(
							select distinct bb.uomcode 
							from productstockdet b
							join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
							join sloc ba on ba.slocid = b.slocid
							join storagebin bc on bc.storagebinid=b.storagebinid
							where b.productid = t.productid and
							b.unitofmeasureid = t.unitofissue and
							bc.description like '%".$storagebin."%'
							) as satuan,
							(
							select ifnull(sum(aw.qty),0) 
							from productstockdet aw
							join sloc aaw on aaw.slocid = aw.slocid
							join storagebin abw on abw.storagebinid=aw.storagebinid
							where aw.productid = t.productid and
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid and
							abw.description like '%".$storagebin."%'
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							join storagebin ccc on ccc.storagebinid=c.storagebinid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							ccc.description like '%".$storagebin."%' and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							join storagebin ddd on ddd.storagebinid=d.storagebinid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							ddd.description like '%".$storagebin."%' and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							join storagebin eee on eee.storagebinid=e.storagebinid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							eee.description like '%".$storagebin."%' and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							join storagebin fff on fff.storagebinid=f.storagebinid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							fff.description like '%".$storagebin."%' and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							join storagebin ggg on ggg.storagebinid=g.storagebinid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							ggg.description like '%".$storagebin."%' and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							join storagebin hhh on hhh.storagebinid=h.storagebinid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							hhh.description like '%".$storagebin."%' and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							join storagebin iii on iii.storagebinid=i.storagebinid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							iii.description like '%".$storagebin."%' and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							join storagebin jjj on jjj.storagebinid=j.storagebinid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							jjj.description like '%".$storagebin."%' and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							join storagebin kkk on kkk.storagebinid=k.storagebinid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							kkk.description like '%".$storagebin."%' and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							join storagebin lll on lll.storagebinid=l.storagebinid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid and
							lll.description like '%".$storagebin."%' and
							l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							join storagebin mmm on mmm.storagebinid=m.storagebinid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							mmm.description like '%".$storagebin."%' and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,v.slocid,v.sloccode,u.materialgroupid,u.description
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
							where getcompanyfromsloc(v.slocid) = ".$companyid." and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%') z) zz )zzz where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0
					order by materialgroupid,slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Persediaan Barang (Detail) - Data Harga';
		$this->pdf->subtitle='Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','Legal');
		
		foreach ($dataReader as $row)
		{
			$this->pdf->setFont('Arial','',10);
			$this->pdf->text(15,$this->pdf->gety()+5,'GUDANG');$this->pdf->text(35,$this->pdf->gety()+5,': '.$row['sloccode']);
			$this->pdf->text(200,$this->pdf->gety()+5,'MATERIAL GROUP');$this->pdf->text(235,$this->pdf->gety()+5,': '.$row['description']);
			
			if ($storagebin == null)
			{$this->pdf->text(100,$this->pdf->gety()+5,'');$this->pdf->text(115,$this->pdf->gety()+5,'');}
			else
			{$this->pdf->text(100,$this->pdf->gety()+5,'RAK');$this->pdf->text(115,$this->pdf->gety()+5,': '.$storagebin);}
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+7);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,61,38,61,38,38,5));
			$this->pdf->colheader = array('','','','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
			$this->pdf->RowHeader();
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','C','R','R','R','R','R','R','R','R','R','R','R','R','C');
			
			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
			$sql1="select *,case when akhir < 0 then 'X' else '' end as minus from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,harga
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,harga
							from
							(select 
							(
							select distinct aa.productname 
							from productstockdet a
							join product aa on aa.productid = a.productid
							join sloc ab on ab.slocid = a.slocid
							join storagebin ac on ac.storagebinid=a.storagebinid
							where a.productid = t.productid and
							a.unitofmeasureid = t.unitofissue and
							ac.description like '%".$storagebin."%'
							) as barang,
							(
							select distinct bb.uomcode 
							from productstockdet b
							join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
							join sloc ba on ba.slocid = b.slocid
							join storagebin bc on bc.storagebinid=b.storagebinid
							where b.productid = t.productid and
							b.unitofmeasureid = t.unitofissue and
							bc.description like '%".$storagebin."%'
							) as satuan,
							(
							select ifnull(sum(aw.qty),0) 
							from productstockdet aw
							join sloc aaw on aaw.slocid = aw.slocid
							join storagebin aww on aww.storagebinid=aw.storagebinid
							where aw.productid = t.productid and
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid and
							aww.description like '%".$storagebin."%'
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							join storagebin ccc on ccc.storagebinid=c.storagebinid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							ccc.description like '%".$storagebin."%' and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							join storagebin ddd on ddd.storagebinid=d.storagebinid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							ddd.description like '%".$storagebin."%' and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							join storagebin eee on eee.storagebinid=e.storagebinid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							eee.description like '%".$storagebin."%' and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							join storagebin fff on fff.storagebinid=f.storagebinid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							fff.description like '%".$storagebin."%' and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							join storagebin ggg on ggg.storagebinid=g.storagebinid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							ggg.description like '%".$storagebin."%' and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							join storagebin hhh on hhh.storagebinid=h.storagebinid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							hhh.description like '%".$storagebin."%' and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							join storagebin iii on iii.storagebinid=i.storagebinid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							iii.description like '%".$storagebin."%' and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							join storagebin jjj on jjj.storagebinid=j.storagebinid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							jjj.description like '%".$storagebin."%' and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							join storagebin kkk on kkk.storagebinid=k.storagebinid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							kkk.description like '%".$storagebin."%' and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							join storagebin lll on lll.storagebinid=l.storagebinid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid and
							lll.description like '%".$storagebin."%' and
							l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							join storagebin mmm on mmm.storagebinid=m.storagebinid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,
							ifnull((select q.harga 
							from dataharga q
							where q.productid=t.productid
							),0) as harga
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
									where getcompanyfromsloc(v.slocid) = ".$companyid."
              and u.materialgroupid = '".$row['materialgroupid']."' 
							and v.slocid = '".$row['slocid']."' and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%' order by barang) z) zz )zzz 
							where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0 order by barang asc";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach ($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',6.5);
				$this->pdf->row(array(
					$i,$row1['barang'],$row1['satuan'],
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['awal']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['masuk']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['masuk'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] + $row1['masuk'])),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],(($row1['awal'] + $row1['masuk']) * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['keluar']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['keluar'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['akhir']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['akhir'] * $row1['harga']/$per)),
					$row1['minus'],
				));
				$qtyawal += $row1['awal'];
				$nilaiawal += ($row1['awal'] * $row1['harga']/$per);
				$qtymasuk += $row1['masuk'];
				$nilaimasuk += ($row1['masuk'] * $row1['harga']/$per);
				$qtytersedia += ($row1['awal'] + $row1['masuk']);
				$nilaitersedia += (($row1['awal'] + $row1['masuk']) * $row1['harga']/$per);
				$qtykeluar += $row1['keluar'];
				$nilaikeluar += ($row1['keluar'] * $row1['harga']/$per);
				$qtyakhir += $row1['akhir'];
				$nilaiakhir += ($row1['akhir'] * $row1['harga']/$per);
			}
			$this->pdf->setFont('Arial','B',6.5);
			$this->pdf->setwidths(array(98,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->coldetailalign = array('R','R','R','R','R','R','R','R','R','R','R','R','R','C');
			$this->pdf->row(array(
				'TOTAL '.$row['sloccode'].' - '.$row['description'].'      >>>>>',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir),'',
			));
			$qtyawal2 += $qtyawal;
			$nilaiawal2 += $nilaiawal;
			$qtymasuk2 += $qtymasuk;
			$nilaimasuk2 += $nilaimasuk;
			$qtytersedia2 += $qtytersedia;
			$nilaitersedia2 += $nilaitersedia;
			$qtykeluar2 += $qtykeluar;
			$nilaikeluar2 += $nilaikeluar;
			$qtyakhir2 += $qtyakhir;
			$nilaiakhir2 += $nilaiakhir;
			
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkNewPage(175);
		}
		$this->pdf->setFont('Arial','BI',6.5);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,68,43,68,43,43,5));
		$this->pdf->colheader = array('','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
		$this->pdf->RowHeader();
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,18,25,25,18,25,18,25,25,18,25,18,25,5));
		$this->pdf->colheader = array('Keterangan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R','R','R','R','R','C');
		$this->pdf->row(array(
			'GRAND TOTAL      >>>>>',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir2),'',
		));
		
		$this->pdf->Output();
	}
	/* tanpa filter rak
	public function RekapPersediaanBarangDetail($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	//Masih menggunakan Data Harga
	{
		parent::actionDownPDF();
		$qtyawal2=0;$nilaiawal2=0;$qtymasuk2=0;$nilaimasuk2=0;$qtytersedia2=0;$nilaitersedia2=0;$qtykeluar2=0;$nilaikeluar2=0;$qtyakhir2=0;$nilaiakhir2=0;
		$sql="select distinct slocid,sloccode,materialgroupid,description from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,slocid,sloccode,materialgroupid,description
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,slocid,sloccode,materialgroupid,description
							from
							(select
							(
							select distinct aa.productid 
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
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid
							and l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,v.slocid,v.sloccode,u.materialgroupid,u.description
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
							where getcompanyfromsloc(v.slocid) = ".$companyid." and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%') z) zz )zzz where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0
					order by materialgroupid,slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Persediaan Barang (Detail)';
		$this->pdf->subtitle='Dari Tgl : '.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('L','Legal');
		
		foreach ($dataReader as $row)
		{
			$this->pdf->setFont('Arial','',10);
			$this->pdf->text(15,$this->pdf->gety()+5,'GUDANG');$this->pdf->text(35,$this->pdf->gety()+5,': '.$row['sloccode']);
			$this->pdf->text(200,$this->pdf->gety()+5,'MATERIAL GROUP');$this->pdf->text(235,$this->pdf->gety()+5,': '.$row['description']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+7);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,61,38,61,38,38,5));
			$this->pdf->colheader = array('','','','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
			$this->pdf->RowHeader();
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(6,80,12,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','C','R','R','R','R','R','R','R','R','R','R','R','R','C');
			
			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
			$sql1="select *,case when akhir < 0 then 'X' else '' end as minus from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,harga
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,harga
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
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid
							and l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,
							ifnull((select q.harga 
							from dataharga q
							where q.productid=t.productid
							),0) as harga
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
									where getcompanyfromsloc(v.slocid) = ".$companyid."
              and u.materialgroupid = '".$row['materialgroupid']."' 
							and v.slocid = '".$row['slocid']."' and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%' order by barang) z) zz )zzz 
							where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0 order by barang asc";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach ($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',6.5);
				$this->pdf->row(array(
					$i,$row1['barang'],$row1['satuan'],
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['awal']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['masuk']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['masuk'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['awal'] + $row1['masuk'])),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['harga']/$per),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],(($row1['awal'] + $row1['masuk']) * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['keluar']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['keluar'] * $row1['harga']/$per)),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['akhir']),
					Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],($row1['akhir'] * $row1['harga']/$per)),
					$row1['minus'],
				));
				$qtyawal += $row1['awal'];
				$nilaiawal += ($row1['awal'] * $row1['harga']/$per);
				$qtymasuk += $row1['masuk'];
				$nilaimasuk += ($row1['masuk'] * $row1['harga']/$per);
				$qtytersedia += ($row1['awal'] + $row1['masuk']);
				$nilaitersedia += (($row1['awal'] + $row1['masuk']) * $row1['harga']/$per);
				$qtykeluar += $row1['keluar'];
				$nilaikeluar += ($row1['keluar'] * $row1['harga']/$per);
				$qtyakhir += $row1['akhir'];
				$nilaiakhir += ($row1['akhir'] * $row1['harga']/$per);
			}
			$this->pdf->setFont('Arial','B',6.5);
			$this->pdf->setwidths(array(98,15,23,23,15,23,15,23,23,15,23,15,23,5));
			$this->pdf->coldetailalign = array('R','R','R','R','R','R','R','R','R','R','R','R','R','C');
			$this->pdf->row(array(
				'TOTAL '.$row['sloccode'].' - '.$row['description'].'      >>>>>',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia),'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir),'',
			));
			$qtyawal2 += $qtyawal;
			$nilaiawal2 += $nilaiawal;
			$qtymasuk2 += $qtymasuk;
			$nilaimasuk2 += $nilaimasuk;
			$qtytersedia2 += $qtytersedia;
			$nilaitersedia2 += $nilaitersedia;
			$qtykeluar2 += $qtykeluar;
			$nilaikeluar2 += $nilaikeluar;
			$qtyakhir2 += $qtyakhir;
			$nilaiakhir2 += $nilaiakhir;
			
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkNewPage(175);
		}
		$this->pdf->setFont('Arial','BI',6.5);
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,68,43,68,43,43,5));
		$this->pdf->colheader = array('','Awal','Penerimaan','Tersedia','Pengeluaran','Akhir','');
		$this->pdf->RowHeader();
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->setwidths(array(69,18,25,25,18,25,18,25,25,18,25,18,25,5));
		$this->pdf->colheader = array('Keterangan','Qty','Harga','Nilai','Qty','Nilai','Qty','Harga','Nilai','Qty','Nilai','Qty','Nilai','');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R','R','R','R','R','C');
		$this->pdf->row(array(
			'GRAND TOTAL      >>>>>',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyawal2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiawal2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtymasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaimasuk2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtytersedia2),'',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaitersedia2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtykeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaikeluar2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$qtyakhir2),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$nilaiakhir2),'',
		));
		
		$this->pdf->Output();
	}
	*/
	public function Hpp($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$sql = "select distinct a.materialgroupid,a.description
				from materialgroup a
				join productplant b on b.materialgroupid = a.materialgroupid
				join sloc c on c.slocid = b.slocid
				join plant d on d.plantid = c.plantid
				join product e on e.productid = b.productid
				where d.companyid = '".$companyid."'";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			
			foreach($dataReader as $row)
			{
				$this->pdf->companyid = $companyid;
			}
			$this->pdf->title='Harga Pokok Produksi';
			$this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
			$this->pdf->AddPage('P');
			
			foreach($dataReader as $row)
			{
				$this->pdf->SetFont('Arial','',10);
				$this->pdf->text(10,$this->pdf->gety()+10,'Divisi');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['description']);
				$sql1 = "select distinct b.productname,f.description as uom,ifnull(a.buyprice,0) as hpp
					from productdetail a
					join product b on b.productid = a.productid
					join sloc c on c.slocid = a.slocid
					join productplant d on d.productid = a.productid and d.slocid = a.slocid and d.unitofissue = a.unitofmeasureid
					join materialgroup e on e.materialgroupid = d.materialgroupid
					join unitofmeasure f on f.unitofmeasureid = a.unitofmeasureid
					where e.materialgroupid = '".$row['materialgroupid']."'";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$totalqty=0;$i=0;
				$this->pdf->sety($this->pdf->gety()+15);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->colalign = array('C','C','C','C');
				$this->pdf->setwidths(array(10,120,30,30));
				$this->pdf->colheader = array('No','Nama Barang','Satuan','HPP');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','C','R');
				$this->pdf->setFont('Arial','',8);
				foreach($dataReader1 as $row1)
				{
					$i+=1;
					$this->pdf->row(array(
						$i,$row1['productname'],
						$row1['uom'],
						Yii::app()->format->formatCurrency($row1['hpp']/$per)
					));
				}
				$this->pdf->checkPageBreak(20);
			}
			$this->pdf->Output();
	}
	public function HppBillOfMaterial($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
  {
            parent::actionDownPDF();
            $sql = "select distinct d.slocid,d.sloccode
					from bomdetail a
					join billofmaterial b on b.bomid=a.bomid
					join productplant aa on aa.productid=a.productid
					join productplant bb on bb.productid=b.productid
					join product aaa on aaa.productid=a.productid
					join product bbb on bbb.productid=b.productid
					left join productdetail c on c.productid=a.productid and c.slocid=aa.slocid and c.unitofmeasureid=aa.unitofissue
					left join sloc d on d.slocid=aa.slocid
					left join plant e on e.plantid=d.plantid
					left join company f on f.companyid=e.companyid
					left join unitofmeasure g on g.unitofmeasureid=b.uomid
					where f.companyid='".$companyid."' and bb.issource=1 and bbb.productname like '%".$product."%' and d.sloccode like '%".$sloc."%' and bb.slocid=aa.slocid order by slocid";
            $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
            
            
            foreach($dataReader as $row)
            {
                $this->pdf->companyid = $companyid;
            }
            $this->pdf->title='HPP Berdasarkan BOM';
            $this->pdf->subtitle = 'Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
            $this->pdf->AddPage('P');

            $this->pdf->sety($this->pdf->gety());
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C');
			$this->pdf->setwidths(array(110,20,20,20,20));
			$this->pdf->colheader = array('Nama Barang','Satuan','Qty','Price','Jumlah');
			$this->pdf->RowHeader();
            
            foreach($dataReader as $row)
            {
                $this->pdf->SetFont('Arial','B',10);                
				$this->pdf->text(10,$this->pdf->gety()+5,'GUDANG');$this->pdf->text(28,$this->pdf->gety()+5,': '.$row['sloccode']);
                $sql1 = "select distinct bbb.productid,bbb.productname,g.uomcode as uomname
						from bomdetail a
						join billofmaterial b on b.bomid=a.bomid
						join productplant aa on aa.productid=a.productid
						join productplant bb on bb.productid=b.productid
						join product aaa on aaa.productid=a.productid
						join product bbb on bbb.productid=b.productid
						left join productdetail c on c.productid=a.productid and c.slocid=aa.slocid and c.unitofmeasureid=aa.unitofissue
						left join sloc d on d.slocid=aa.slocid
						left join plant e on e.plantid=d.plantid
						left join company f on f.companyid=e.companyid
						left join unitofmeasure g on g.unitofmeasureid=b.uomid
						where f.companyid=".$companyid." and bb.issource=1 and bbb.productname like '%".$product."%' and bb.slocid='".$row['slocid']."' and bb.slocid=aa.slocid order by productname";
                $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                
                $this->pdf->sety($this->pdf->gety()+5);
                foreach($dataReader1 as $row1)
				
			{
                $sql2 = "select bbb.productname,bbb.productid,g.description as uomname,d.sloccode,sum(a.qty*ifnull(c.buyprice,1)) as total
						from bomdetail a
						join billofmaterial b on b.bomid=a.bomid
						join productplant aa on aa.productid=a.productid
						join productplant bb on bb.productid=b.productid
						join product aaa on aaa.productid=a.productid
						join product bbb on bbb.productid=b.productid
						left join productdetail c on c.productid=a.productid and c.slocid=aa.slocid and c.unitofmeasureid=aa.unitofissue
						left join sloc d on d.slocid=aa.slocid
						left join plant e on e.plantid=d.plantid
						left join company f on f.companyid=e.companyid
						left join unitofmeasure g on g.unitofmeasureid=b.uomid
						where f.companyid=".$companyid." and bb.issource=1 and bb.slocid='".$row['slocid']."' and b.productid='".$row1['productid']."' and bb.slocid=aa.slocid";
                $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
                
                $this->pdf->sety($this->pdf->gety());
                foreach($dataReader2 as $row2)
				
			{
                $this->pdf->SetFont('Arial','BI',9);                
				$this->pdf->text(10,$this->pdf->gety()+5,$row2['productname']);$this->pdf->text(150,$this->pdf->gety()+5,$row2['uomname']);
				$this->pdf->text(180,$this->pdf->gety()+5,Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['total']/$per));
                $sql3 = "select distinct aaa.productname,c.slocid,aaa.isstock,g.description as uomname,ifnull(a.qty*aaa.isstock,0) as qty,ifnull(c.buyprice,a.qty) as price,ifnull(a.qty*c.buyprice,ifnull(c.buyprice,a.qty)) as jumlah
							from bomdetail a
							join billofmaterial b on b.bomid=a.bomid
							join productplant aa on aa.productid=a.productid
							join productplant bb on bb.productid=b.productid
							join product aaa on aaa.productid=a.productid
							join product bbb on bbb.productid=b.productid
							left join productdetail c on c.productid=a.productid and c.slocid=aa.slocid and c.unitofmeasureid=aa.unitofissue
							left join sloc d on d.slocid=aa.slocid
							left join plant e on e.plantid=d.plantid
							left join company f on f.companyid=e.companyid
							left join unitofmeasure g on g.unitofmeasureid=a.uomid
							where f.companyid=".$companyid." and bb.issource=1 and bb.slocid='".$row['slocid']."' and b.productid='".$row1['productid']."' and bb.slocid=aa.slocid order by isstock desc,productname";
                $this->pdf->sety($this->pdf->gety()+7);
                $this->pdf->coldetailalign = array('L','C','R','R','R');
                $this->pdf->setFont('Arial','',8);
                $dataReader3=Yii::app()->db->createCommand($sql3)->queryAll();
                
                
                foreach($dataReader3 as $row3)
                {
                   $this->pdf->row(array(
                                $row3['productname'],$row3['uomname'],
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['qty']),
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['price']/$per),
                                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['jumlah']/$per),
                        ));
                }
				$this->pdf->sety($this->pdf->gety()+5);
                    $this->pdf->checkPageBreak(10);
            }}}
                $this->pdf->Output();
  
	}
	public function RincianNilaiPemakaianStok($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	//Masih menggunakan dataharga
  {
		parent::actionDownPDF();
		$sql = "select e.slocid as fromslocid,e.sloccode as fromsloccode, e.description as fromslocdesc,
						f.slocid as toslocid, f.sloccode as tosloccode, f.description as toslocdesc
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						join sloc e on e.slocid=a.fromslocid
						join sloc f on f.slocid=a.toslocid
						join productplan g on g.productplanid=c.productplanid
						where c.recordstatus = 3 and g.companyid = ".$companyid." and e.sloccode like '%".$sloc."%' and f.sloccode like '%".$sloc."%'
						and c.productoutputdate between 
						'".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
						'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						group by e.slocid,f.slocid
						order by e.sloccode,f.sloccode";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Nilai Pemakaian Stok';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'Asal');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['fromsloccode'].' - '.$row['fromslocdesc']);
			$this->pdf->text(10,$this->pdf->gety()+10,'Tujuan');$this->pdf->text(30,$this->pdf->gety()+10,': '.$row['tosloccode'].' - '.$row['toslocdesc']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+12);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,90,15,20,30,30));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','R','R','R');
			
			$i=0;$total=0;
			$sql1 = "select e.sloccode as fromsloccode, f.sloccode as tosloccode, b.productname, a.qty, d.uomcode,
						(select ifnull(z.harga,0) from dataharga z where z.productid=a.productid and z.uom=a.uomid) as harga
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						join sloc e on e.slocid=a.fromslocid
						join sloc f on f.slocid=a.toslocid
						join productplan g on g.productplanid=c.productplanid
						where c.recordstatus = 3 and g.companyid = ".$companyid." and e.slocid = '".$row['fromslocid']."' and f.slocid = '".$row['toslocid']."'
						and c.productoutputdate between 
						'".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
						'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row1['productname'],
					$row1['uomcode'],
					Yii::app()->format->formatNumber($row1['qty']),
					Yii::app()->format->formatCurrency($row1['harga']/$per),
					Yii::app()->format->formatCurrency($row1['qty'] * $row1['harga']/$per),
				));
				$total += ($row1['qty'] * $row1['harga']/$per);
			}
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(10,155,30));
			$this->pdf->coldetailalign = array('R','R','R');
			$this->pdf->row(array(
				'','TOTAL PEMAKAIAN '.$row['fromsloccode'].' - '.$row['tosloccode'],
				Yii::app()->format->formatCurrency($total),
			));
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->checkPageBreak(10);
		}
		
				
		$this->pdf->Output();
	}
	
	public function RekapNilaiPemakaianStok($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
  //Masih menggunakan dataharga
	{
		parent::actionDownPDF();
		$i=0;$total=0;
		$sql = "select e.slocid as fromslocid,e.sloccode as fromsloccode, e.description as fromslocdesc,
						f.slocid as toslocid, f.sloccode as tosloccode, f.description as toslocdesc,
						sum(ifnull(a.qty,0)*(select ifnull(z.harga,0) from dataharga z where z.productid=a.productid and z.uom=a.uomid)) as jumlah
						from productoutputdetail a
						join product b on b.productid = a.productid
						join productoutput c on c.productoutputid = a.productoutputid
						join unitofmeasure d on d.unitofmeasureid = a.uomid
						join sloc e on e.slocid=a.fromslocid
						join sloc f on f.slocid=a.toslocid
						join productplan g on g.productplanid=c.productplanid
						where c.recordstatus = 3 and g.companyid = ".$companyid." and e.sloccode like '%".$sloc."%' and f.sloccode like '%".$sloc."%'
						and c.productoutputdate between 
						'".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and 
						'".date(Yii::app()->params['datetodb'], strtotime($enddate))."' 
						group by e.slocid,f.slocid
						order by e.sloccode,f.sloccode";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Nilai Pemakaian Stok';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->sety($this->pdf->gety()+0);
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->setwidths(array(10,70,70,35));
		$this->pdf->colheader = array('No','Gudang Asal','Gudang Tujuan','Jumlah');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','R');

		foreach($dataReader as $row)
		{
			$i+=1;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->row(array(
				$i,
				$row['fromsloccode'].' - '.$row['fromslocdesc'],
				$row['tosloccode'].' - '.$row['toslocdesc'],
				Yii::app()->format->formatCurrency($row['jumlah']/$per),
			));
			$total += $row['jumlah']/$per;			
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->row(array(
			'',
			'',
			'Total Pemakaian',
			Yii::app()->format->formatCurrency($total),
		));
		
		$this->pdf->checkPageBreak(10);		
		$this->pdf->Output();
	}
	
	public function RincianNilaiStockOpname($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$total2=0;
		$sql = "select distinct f.slocid,f.sloccode,f.description
						from bsdetail a
						join product b on b.productid=a.productid
						join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
						join storagebin d on d.storagebinid=a.storagebinid
						join bsheader e on e.bsheaderid=a.bsheaderid
						join sloc f on f.slocid=e.slocid
						where e.recordstatus=5 and getcompanyfromsloc(f.slocid) = ".$companyid." and f.sloccode like '%".$sloc."%' 
						and b.productname like '%".$product."%' 
						and e.bsdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by sloccode";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Nilai Stock Opname';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'Gudang');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['sloccode'].' - '.$row['description']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+12);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,90,15,20,30,30));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','L','R','R','R');
			
			$i=0;$total=0;
			$sql1 = "select b.productname,c.uomcode,sum(a.qty) as qty,sum(a.qty*a.buyprice)/sum(a.qty) as harga,sum(a.qty*a.buyprice) as jumlah
						from bsdetail a
						join product b on b.productid=a.productid
						join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
						join storagebin d on d.storagebinid=a.storagebinid
						join bsheader e on e.bsheaderid=a.bsheaderid
						join sloc f on f.slocid=e.slocid
						where e.recordstatus=5 and f.slocid = '".$row['slocid']."' and f.sloccode like '%".$sloc."%' 
						and b.productname like '%".$product."%' 
						and e.bsdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						group by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row1['productname'],
					$row1['uomcode'],
					Yii::app()->format->formatNumber($row1['qty']),
					Yii::app()->format->formatCurrency($row1['harga']/$per),
					Yii::app()->format->formatCurrency($row1['jumlah']/$per),
				));
				$total += ($row1['jumlah']/$per);
			}
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(10,155,30));
			$this->pdf->coldetailalign = array('R','R','R');
			$this->pdf->row(array(
				'','TOTAL KOREKSI '.$row['sloccode'],
				Yii::app()->format->formatCurrency($total),
			));
			$total2 += $total;
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(10,155,30));
		$this->pdf->coldetailalign = array('R','R','R');
		$this->pdf->row(array(
			'','GRAND TOTAL KOREKSI ',
			Yii::app()->format->formatCurrency($total2),
		));
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->checkPageBreak(10);
				
		$this->pdf->Output();
	}
	
	public function RekapNilaiStockOpname($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		parent::actionDownPDF();
		$i=0;$total=0;
		$sql = "select distinct f.slocid,f.sloccode,f.description,sum(a.qty*a.buyprice) as jumlah
						from bsdetail a
						join product b on b.productid=a.productid
						join unitofmeasure c on c.unitofmeasureid=a.unitofmeasureid
						join storagebin d on d.storagebinid=a.storagebinid
						join bsheader e on e.bsheaderid=a.bsheaderid
						join sloc f on f.slocid=e.slocid
						where e.recordstatus=5 and getcompanyfromsloc(f.slocid) = ".$companyid." and f.sloccode like '%".$sloc."%' 
						and b.productname like '%".$product."%' 
						and e.bsdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						group by slocid order by sloccode";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Nilai Stock Opname';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(10,130,35));
			$this->pdf->colheader = array('No','Nama Gudang','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','R');

		foreach($dataReader as $row)
		{
			$i+=1;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->row(array(
				$i,$row['sloccode'].' - '.$row['description'],
				Yii::app()->format->formatCurrency($row['jumlah']/$per),
			));
			$total += ($row['jumlah']/$per);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(10,135,30));
		$this->pdf->coldetailalign = array('R','R','R');
		$this->pdf->row(array(
			'','TOTAL KOREKSI ',
			Yii::app()->format->formatCurrency($total),
		));
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->checkPageBreak(10);
				
		$this->pdf->Output();
	}
	
	public function RincianHargaPokokPenjualan($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
  //Masih menggunakan dataharga
	{
		parent::actionDownPDF();
		$total2=0;
		$sql = "select distinct d.slocid,d.sloccode,d.description
						from gidetail a
						left join giheader b on b.giheaderid=a.giheaderid
						left join product c on c.productid=a.productid
						left join sloc d on d.slocid=a.slocid
						left join soheader e on e.soheaderid=b.soheaderid
						where b.recordstatus = 3 and c.isstock = 1 and e.companyid = ".$companyid." and d.sloccode like '%".$sloc."%' 
						and c.productname like '%".$product."%'and b.gidate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						order by slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rincian Harga Pokok Penjualan';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');

		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+5,'Gudang');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['sloccode'].' - '.$row['description']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+12);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,90,15,20,30,30));
			$this->pdf->colheader = array('No','Nama Barang','Satuan','Qty','Harga','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','C','R','R','R');
			
			$i=0;$total=0;
			$sql1 = "select c.productname,f.uomcode,sum(ifnull(a.qty,0)) as qty,
						ifnull((select z.harga from dataharga z where z.productid=a.productid and z.uom=a.unitofmeasureid),0) as harga,
						sum(ifnull(a.qty,0)*
						ifnull((select z.harga from dataharga z where z.productid=a.productid and z.uom=a.unitofmeasureid),0)) as jumlah
						from gidetail a
						left join giheader b on b.giheaderid=a.giheaderid
						left join product c on c.productid=a.productid
						left join sloc d on d.slocid=a.slocid
						left join soheader e on e.soheaderid=b.soheaderid
						left join unitofmeasure f on f.unitofmeasureid=a.unitofmeasureid
						where b.recordstatus=3 and c.isstock=1 and d.slocid = '".$row['slocid']."' and d.sloccode like '%".$sloc."%' 
						and c.productname like '%".$product."%' 
						and b.gidate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'					
						group by productname";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array(
					$i,$row1['productname'],
					$row1['uomcode'],
					Yii::app()->format->formatNumber($row1['qty']),
					Yii::app()->format->formatCurrency($row1['harga']/$per),
					Yii::app()->format->formatCurrency($row1['jumlah']/$per),
				));
				$total += ($row1['jumlah']/$per);
			}
			$this->pdf->setFont('Arial','BI',9);
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(10,155,30));
			$this->pdf->coldetailalign = array('R','R','R');
			$this->pdf->row(array(
				'','TOTAL HPP '.$row['sloccode'],
				Yii::app()->format->formatCurrency($total),
			));
			$total2 += $total;
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(10,155,30));
		$this->pdf->coldetailalign = array('R','R','R');
		$this->pdf->row(array(
			'','GRAND TOTAL HPP ',
			Yii::app()->format->formatCurrency($total2),
		));
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->checkPageBreak(10);
				
		$this->pdf->Output();
	}
	
	public function RekapHargaPokokPenjualan($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
  //Masih menggunakan dataharga
	{
		parent::actionDownPDF();
		$i=0;$total=0;
		$sql = "select distinct d.slocid,d.sloccode,d.description,sum(ifnull(a.qty,0)*
						ifnull((select z.harga from dataharga z where z.productid=a.productid and z.uom=a.unitofmeasureid),0)) as jumlah
						from gidetail a
						left join giheader b on b.giheaderid=a.giheaderid
						left join product c on c.productid=a.productid
						left join sloc d on d.slocid=a.slocid
						left join soheader e on e.soheaderid=b.soheaderid
						where b.recordstatus = 3 and c.isstock = 1 and e.companyid = ".$companyid." and d.sloccode like '%".$sloc."%' 
						and c.productname like '%".$product."%'and b.gidate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						group by slocid order by slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Rekap Harga Pokok Penjualan';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($enddate));
		$this->pdf->AddPage('P');
		
		$this->pdf->setFont('Arial','B',8);
			$this->pdf->sety($this->pdf->gety()+0);
			$this->pdf->colalign = array('C','C','C');
			$this->pdf->setwidths(array(10,130,35));
			$this->pdf->colheader = array('No','Nama Gudang','Jumlah');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('R','L','R');

		foreach($dataReader as $row)
		{
			$i+=1;
			$this->pdf->setFont('Arial','',8);
			$this->pdf->row(array(
				$i,$row['sloccode'].' - '.$row['description'],
				Yii::app()->format->formatCurrency($row['jumlah']/$per),
			));
			$total += ($row['jumlah']/$per);
		}
		$this->pdf->setFont('Arial','BI',9);
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(10,135,30));
		$this->pdf->coldetailalign = array('R','R','R');
		$this->pdf->row(array(
			'','TOTAL KOREKSI ',
			Yii::app()->format->formatCurrency($total),
		));
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->checkPageBreak(10);
				
		$this->pdf->Output();
	}
	   
       
		
		
		
	public function actionDownXLS()
	{
		parent::actionDownPDF();
		if (isset($_GET['lro']) && isset($_GET['company']) && isset($_GET['sloc']) && isset($_GET['materialgroup']) && isset($_GET['storagebin']) && isset($_GET['product']) && isset($_GET['startdate']) && isset($_GET['enddate'],$_GET['per']) && isset($_GET['enddate'],$_GET['per']) && isset($_GET['per']))
		{
			if ($_GET['lro'] == 1)
			{
				$this->RekapPersediaanBarangDetailXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																
			else
			if ($_GET['lro'] == 2)
			{
				$this->RekapPenerimaanPersediaanBarangDetailXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																
			else
			if ($_GET['lro'] == 3)
			{
				$this->RekapPengeluaranPersediaanBarangDetailXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}																																
			else
			if ($_GET['lro'] == 4)
			{
				$this->HPPXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}			
			else
			if ($_GET['lro'] == 5)
			{
				$this->HppBillOfMaterialXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 6)
			{
				$this->RincianNilaiPemakaianStokXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 7)
			{
				$this->RekapNilaiPemakaianStokXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 8)
			{
				$this->RincianNilaiStockOpnameXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 9)
			{
				$this->RekapNilaiStockOpnameXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 10)
			{
				$this->RincianHargaPokokPenjualanXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
			else
			if ($_GET['lro'] == 11)
			{
				$this->RekapHargaPokokPenjualanXLS($_GET['company'],$_GET['sloc'],$_GET['materialgroup'],$_GET['storagebin'],$_GET['product'],$_GET['startdate'],$_GET['enddate'],$_GET['per']);
			}
		}
	}
	
	public function RekapPersediaanBarangDetailXLS($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		$this->menuname='rekappersediaanbarangdetail';
		parent::actionDownXLS();
		$qtyawal2=0;$nilaiawal2=0;$qtymasuk2=0;$nilaimasuk2=0;$qtytersedia2=0;$nilaitersedia2=0;$qtykeluar2=0;$nilaikeluar2=0;$qtyakhir2=0;$nilaiakhir2=0;
		$sql="select distinct slocid,sloccode,materialgroupid,description from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,slocid,sloccode,materialgroupid,description
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,slocid,sloccode,materialgroupid,description
							from
							(select
							(
							select distinct aa.productid 
							from productstockdet a
							join product aa on aa.productid = a.productid
							join sloc ab on ab.slocid = a.slocid
							join storagebin ac on ac.storagebinid=a.storagebinid
							where a.productid = t.productid and
							a.unitofmeasureid = t.unitofissue and
							ac.description like '%".$storagebin."%'
							) as barang,
							(
							select distinct bb.uomcode 
							from productstockdet b
							join unitofmeasure bb on bb.unitofmeasureid = b.unitofmeasureid
							join sloc ba on ba.slocid = b.slocid
							join storagebin bc on bc.storagebinid=b.storagebinid
							where b.productid = t.productid and
							b.unitofmeasureid = t.unitofissue and
							bc.description like '%".$storagebin."%'
							) as satuan,
							(
							select ifnull(sum(aw.qty),0) 
							from productstockdet aw
							join sloc aaw on aaw.slocid = aw.slocid
							join storagebin abw on abw.storagebinid=aw.storagebinid
							where aw.productid = t.productid and
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid and
							abw.description like '%".$storagebin."%'
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							join storagebin ccc on ccc.storagebinid=c.storagebinid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							ccc.description like '%".$storagebin."%' and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							join storagebin ddd on ddd.storagebinid=d.storagebinid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							ddd.description like '%".$storagebin."%' and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							join storagebin eee on eee.storagebinid=e.storagebinid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							eee.description like '%".$storagebin."%' and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							join storagebin fff on fff.storagebinid=f.storagebinid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							fff.description like '%".$storagebin."%' and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							join storagebin ggg on ggg.storagebinid=g.storagebinid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							ggg.description like '%".$storagebin."%' and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							join storagebin hhh on hhh.storagebinid=h.storagebinid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							hhh.description like '%".$storagebin."%' and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							join storagebin iii on iii.storagebinid=i.storagebinid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							iii.description like '%".$storagebin."%' and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							join storagebin jjj on jjj.storagebinid=j.storagebinid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							jjj.description like '%".$storagebin."%' and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							join storagebin kkk on kkk.storagebinid=k.storagebinid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							kkk.description like '%".$storagebin."%' and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							join storagebin lll on lll.storagebinid=l.storagebinid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid and
							lll.description like '%".$storagebin."%' and
							l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							join storagebin mmm on mmm.storagebinid=m.storagebinid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							mmm.description like '%".$storagebin."%' and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,v.slocid,v.sloccode,u.materialgroupid,u.description
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
							where getcompanyfromsloc(v.slocid) = ".$companyid." and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%') z) zz )zzz where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0
					order by materialgroupid,slocid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
						->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
						->setCellValueByColumnAndRow(3,1,$this->GetCompanyCode($companyid));
						$line=5;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Gudang')
				->setCellValueByColumnAndRow(1,$line,': '.$row['sloccode'])
				->setCellValueByColumnAndRow(6,$line,'Material Group')
				->setCellValueByColumnAndRow(7,$line,': '.$row['description']);							
			if ($storagebin == null)			
				{$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'')
				->setCellValueByColumnAndRow(4,$line,'');}
			else
				{$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(3,$line,'Rak')
				->setCellValueByColumnAndRow(4,$line,': '.$storagebin);}
			$line++;
				
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Satuan')					
				->setCellValueByColumnAndRow(3,$line,'Qty')
				->setCellValueByColumnAndRow(4,$line,'Harga')
				->setCellValueByColumnAndRow(5,$line,'Nilai')
				->setCellValueByColumnAndRow(6,$line,'Qty')
				->setCellValueByColumnAndRow(7,$line,'Nilai')
				->setCellValueByColumnAndRow(8,$line,'Qty')
				->setCellValueByColumnAndRow(9,$line,'Harga')
				->setCellValueByColumnAndRow(10,$line,'Nilai')
				->setCellValueByColumnAndRow(11,$line,'Qty')
				->setCellValueByColumnAndRow(12,$line,'Nilai')
				->setCellValueByColumnAndRow(13,$line,'Qty')
				->setCellValueByColumnAndRow(14,$line,'Nilai')
				->setCellValueByColumnAndRow(15,$line,'');
			$line++;
			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
			$sql1="select *,case when akhir < 0 then 'X' else '' end as minus
						from (select barang,satuan,rak,awal,hargaawal,masuk,ifnull(hmasuk/masuk,0) as hargamasuk,keluar,ifnull(hkeluar/keluar,0) as hargakeluar,(awal+masuk+keluar) as akhir
						from (select barang,satuan,rak,awal,
						case when awal = 0 then 0 else hargaawal end as hargaawal,
						(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,
						(hbeli+hreturjual+htrfin+hproduksi+hkonversiin) as hmasuk,(hjual+hreturbeli+htrfout+hpemakaian+hkoreksi+hkonversiout) as hkeluar
						from (select 
						(
						select distinct aa.productname 
						from productstockdet a
						join product aa on aa.productid = a.productid
						where a.productid = o.productid and
						a.slocid = o.slocid and
						a.unitofmeasureid = o.unitofmeasureid and
						a.storagebinid = o.storagebinid
						) as barang,
						v.uomcode as satuan,
						t.description as rak,
						(
						select ifnull(sum(b.qty),0) 
						from productstockdet b
						where b.productid = o.productid and
						b.slocid = o.slocid and
						b.unitofmeasureid = o.unitofmeasureid and
						b.storagebinid = o.storagebinid and
						b.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."'
						) as awal,
						(
						select ifnull(sum(c.qty),0) 
						from productstockdet c
						where c.productid = o.productid and
						c.slocid = o.slocid and
						c.unitofmeasureid = o.unitofmeasureid and
						c.storagebinid = o.storagebinid and
						c.referenceno like 'GR-%' and
						c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as beli,
						(
						select ifnull(sum(c.qty*c.buyprice),0) 
						from productdetailhist c
						where c.productid = o.productid and
						c.slocid = o.slocid and
						c.unitofmeasureid = o.unitofmeasureid and
						c.storagebinid = o.storagebinid and
						c.referenceno like 'GR-%' and
						c.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hbeli,
						(
						select ifnull(sum(d.qty),0) 
						from productstockdet d
						where d.productid = o.productid and
						d.slocid = o.slocid and
						d.unitofmeasureid = o.unitofmeasureid and
						d.storagebinid = o.storagebinid and
						d.referenceno like 'GIR-%' and
						d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as returjual,
						(
						select ifnull(sum(d.qty*d.buyprice),0) 
						from productdetailhist d
						where d.productid = o.productid and
						d.slocid = o.slocid and
						d.unitofmeasureid = o.unitofmeasureid and
						d.storagebinid = o.storagebinid and
						d.referenceno like 'GIR-%' and
						d.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hreturjual,
						(
						select ifnull(sum(e.qty),0) 
						from productstockdet e
						where e.productid = o.productid and
						e.slocid = o.slocid and
						e.unitofmeasureid = o.unitofmeasureid and
						e.storagebinid = o.storagebinid and
						e.referenceno like 'TFS-%' and
						e.qty > 0 and
						e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as trfin,
						(
						select ifnull(sum(e.qty*e.buyprice),0) 
						from productdetailhist e
						where e.productid = o.productid and
						e.slocid = o.slocid and
						e.unitofmeasureid = o.unitofmeasureid and
						e.storagebinid = o.storagebinid and
						e.referenceno like 'TFS-%' and
						e.qty > 0 and
						e.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as htrfin,
						(
						select ifnull(sum(f.qty),0) 
						from productstockdet f
						where f.productid = o.productid and
						f.slocid = o.slocid and
						f.unitofmeasureid = o.unitofmeasureid and
						f.storagebinid = o.storagebinid and
						f.referenceno like 'OP-%' and
						f.qty > 0 and
						f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as produksi,
						(
						select ifnull(sum(f.qty*f.buyprice),0) 
						from productdetailhist f
						where f.productid = o.productid and
						f.slocid = o.slocid and
						f.unitofmeasureid = o.unitofmeasureid and
						f.storagebinid = o.storagebinid and
						f.referenceno like 'OP-%' and
						f.qty > 0 and
						f.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hproduksi,
						(
						select ifnull(sum(g.qty),0) 
						from productstockdet g
						where g.productid = o.productid and
						g.slocid = o.slocid and
						g.unitofmeasureid = o.unitofmeasureid and
						g.storagebinid = o.storagebinid and
						g.referenceno like 'SJ-%' and
						g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as jual,
						(
						select ifnull(sum(g.qty*g.buyprice),0) 
						from productdetailhist g
						where g.productid = o.productid and
						g.slocid = o.slocid and
						g.unitofmeasureid = o.unitofmeasureid and
						g.storagebinid = o.storagebinid and
						g.referenceno like 'SJ-%' and
						g.buyprice between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hjual,
						(
						select ifnull(sum(h.qty),0) 
						from productstockdet h
						where h.productid = o.productid and
						h.slocid = o.slocid and
						h.unitofmeasureid = o.unitofmeasureid and
						h.storagebinid = o.storagebinid and
						h.referenceno like 'GRR-%' and
						h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as returbeli,
						(
						select ifnull(sum(h.qty*h.buyprice),0) 
						from productdetailhist h
						where h.productid = o.productid and
						h.slocid = o.slocid and
						h.unitofmeasureid = o.unitofmeasureid and
						h.storagebinid = o.storagebinid and
						h.referenceno like 'GRR-%' and
						h.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hreturbeli,
						(
						select ifnull(sum(i.qty),0) 
						from productstockdet i
						where i.productid = o.productid and
						i.slocid = o.slocid and
						i.unitofmeasureid = o.unitofmeasureid and
						i.storagebinid = o.storagebinid and
						i.referenceno like 'TFS-%' and
						i.qty < 0 and
						i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as trfout,
						(
						select ifnull(sum(i.qty*i.buyprice),0) 
						from productdetailhist i
						where i.productid = o.productid and
						i.slocid = o.slocid and
						i.unitofmeasureid = o.unitofmeasureid and
						i.storagebinid = o.storagebinid and
						i.referenceno like 'TFS-%' and
						i.qty < 0 and
						i.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as htrfout,
						(
						select ifnull(sum(j.qty),0) 
						from productstockdet j
						where j.productid = o.productid and
						j.slocid = o.slocid and
						j.unitofmeasureid = o.unitofmeasureid and
						j.storagebinid = o.storagebinid and
						j.referenceno like 'OP-%' and
						j.qty < 0 and
						j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as pemakaian,
						(
						select ifnull(sum(j.qty*j.buyprice),0) 
						from productdetailhist j
						where j.productid = o.productid and
						j.slocid = o.slocid and
						j.unitofmeasureid = o.unitofmeasureid and
						j.storagebinid = o.storagebinid and
						j.referenceno like 'OP-%' and
						j.qty < 0 and
						j.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hpemakaian,
						(
						select ifnull(sum(k.qty),0) 
						from productstockdet k
						where k.productid = o.productid and
						k.slocid = o.slocid and
						k.unitofmeasureid = o.unitofmeasureid and
						k.storagebinid = o.storagebinid and
						k.referenceno like 'TSO-%' and
						k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as koreksi,
						(
						select ifnull(sum(k.qty*k.buyprice),0) 
						from productdetailhist k
						where k.productid = o.productid and
						k.slocid = o.slocid and
						k.unitofmeasureid = o.unitofmeasureid and
						k.storagebinid = o.storagebinid and
						k.referenceno like 'TSO-%' and
						k.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hkoreksi,
						(select ifnull(sum(l.qty),0) 
						from productstockdet l
						where l.productid = o.productid and
						l.slocid = o.slocid and
						l.unitofmeasureid = o.unitofmeasureid and
						l.storagebinid = o.storagebinid and
						l.referenceno like '%konversi%' and
						l.qty > 0 and
						l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as konversiin,
						(select ifnull(sum(l.qty*l.buyprice),0) 
						from productdetailhist l
						where l.productid = o.productid and
						l.slocid = o.slocid and
						l.unitofmeasureid = o.unitofmeasureid and
						l.storagebinid = o.storagebinid and
						l.referenceno like '%konversi%' and
						l.qty > 0 and
						l.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hkonversiin,
						(
						select ifnull(sum(m.qty),0) 
						from productstockdet m
						where m.productid = o.productid and
						m.slocid = o.slocid and
						m.unitofmeasureid = o.unitofmeasureid and
						m.storagebinid = o.storagebinid and
						m.referenceno like '%konversi%' and
						m.qty < 0 and
						m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as konversiout,
						(
						select ifnull(sum(m.qty*m.buyprice),0) 
						from productdetailhist m
						where m.productid = o.productid and
						m.slocid = o.slocid and
						m.unitofmeasureid = o.unitofmeasureid and
						m.storagebinid = o.storagebinid and
						m.referenceno like '%konversi%' and
						m.qty < 0 and
						m.buydate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
						and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
						) as hkonversiout,
						getbeginningvaluebydate(o.productid,o.slocid,o.unitofmeasureid,o.storagebinid,'".date(Yii::app()->params['datetodb'], strtotime($startdate))."') as hargaawal
						from productstock o
						join productplant p on p.productid = o.productid and p.slocid=o.slocid and p.unitofissue = o.unitofmeasureid
						join materialgroup q on q.materialgroupid = p.materialgroupid
						join sloc r on r.slocid = o.slocid
						join plant s on s.plantid=r.plantid
						join storagebin t on t.storagebinid=o.storagebinid
						join product u on u.productid=o.productid
						join unitofmeasure v on v.unitofmeasureid=o.unitofmeasureid
						where s.companyid = ".$companyid."
						and r.sloccode like '%".$sloc."%'
						and q.materialgroupcode like '%".$materialgroup."%'
						and t.description like '%".$storagebin."%'
						and q.materialgroupid = '".$row['materialgroupid']."' 
						and r.slocid = '".$row['slocid']."' ) z) zz) zzz 
						where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0 order by barang asc";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
				
			foreach($dataReader1 as $row1)
			{
              
              
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['barang'])
					->setCellValueByColumnAndRow(2,$line,$row1['satuan'])
					->setCellValueByColumnAndRow(3,$line,$row1['awal'])
					->setCellValueByColumnAndRow(4,$line,$row1['hargaawal']/$per)
					->setCellValueByColumnAndRow(5,$line,$row1['awal']*$row1['hargaawal']/$per)
					->setCellValueByColumnAndRow(6,$line,$row1['masuk'])
					->setCellValueByColumnAndRow(7,$line,$row1['masuk']*$row1['hargamasuk']/$per)
					->setCellValueByColumnAndRow(8,$line,$row1['awal']+$row1['masuk'])
					->setCellValueByColumnAndRow(9,$line,(($row1['awal'] * $row1['hargaawal']/$per) + ($row1['masuk'] * $row1['hargamasuk']/$per)) / ($row1['awal'] + $row1['masuk']))
					->setCellValueByColumnAndRow(10,$line,(($row1['awal'] * $row1['hargaawal']/$per)+($row1['masuk'] * $row1['hargamasuk']/$per)))
					->setCellValueByColumnAndRow(11,$line,$row1['keluar'])
					->setCellValueByColumnAndRow(12,$line,$row1['keluar']*$row1['hargakeluar']/$per)
					->setCellValueByColumnAndRow(13,$line,$row1['akhir'])
					->setCellValueByColumnAndRow(14,$line,$row1['akhir']*$row1['hargaawal']/$per)
					->setCellValueByColumnAndRow(15,$line,$row1['minus']);
				$qtyawal += $row1['awal'];
				$nilaiawal += ($row1['awal'] * $row1['hargaawal']/$per);
				$qtymasuk += $row1['masuk'];
				$nilaimasuk += ($row1['masuk'] * $row1['hargamasuk']/$per);
				$qtytersedia += ($row1['awal'] + $row1['masuk']);
				$nilaitersedia += (($row1['awal'] * $row1['hargaawal']/$per) + ($row1['masuk'] * $row1['hargamasuk']/$per)) / ($row1['awal'] + $row1['masuk']);
				$qtykeluar += $row1['keluar'];
				$nilaikeluar += ($row1['keluar'] * $row1['hargakeluar']/$per);
				$qtyakhir += $row1['akhir'];
				$nilaiakhir += ($row1['akhir'] * $row1['hargaawal']/$per);					
				$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'TOTAL '.$row['sloccode'].' - '.$row['description'])
				->setCellValueByColumnAndRow(3,$line,$qtyawal)
				->setCellValueByColumnAndRow(5,$line,$nilaiawal)
				->setCellValueByColumnAndRow(6,$line,$qtymasuk)
				->setCellValueByColumnAndRow(7,$line,$nilaimasuk)
				->setCellValueByColumnAndRow(8,$line,$qtytersedia)
				->setCellValueByColumnAndRow(10,$line,$nilaitersedia)
				->setCellValueByColumnAndRow(11,$line,$qtykeluar)
				->setCellValueByColumnAndRow(12,$line,$nilaikeluar)
				->setCellValueByColumnAndRow(13,$line,$qtyakhir)
				->setCellValueByColumnAndRow(14,$line,$nilaiakhir);
			$qtyawal2 += $qtyawal;
			$nilaiawal2 += $nilaiawal;
			$qtymasuk2 += $qtymasuk;
			$nilaimasuk2 += $nilaimasuk;
			$qtytersedia2 += $qtytersedia;
			$nilaitersedia2 += $nilaitersedia;
			$qtykeluar2 += $qtykeluar;
			$nilaikeluar2 += $nilaikeluar;
			$qtyakhir2 += $qtyakhir;
			$nilaiakhir2 += $nilaiakhir;
			$line +=2;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
			->setCellValueByColumnAndRow(3,$line,$qtyawal2)
			->setCellValueByColumnAndRow(5,$line,$nilaiawal2)
			->setCellValueByColumnAndRow(6,$line,$qtymasuk2)
			->setCellValueByColumnAndRow(7,$line,$nilaimasuk2)
			->setCellValueByColumnAndRow(8,$line,$qtytersedia2)
			->setCellValueByColumnAndRow(10,$line,$nilaitersedia2)
			->setCellValueByColumnAndRow(11,$line,$qtykeluar2)
			->setCellValueByColumnAndRow(12,$line,$nilaikeluar2)
			->setCellValueByColumnAndRow(13,$line,$qtyakhir2)
			->setCellValueByColumnAndRow(14,$line,$nilaiakhir2);
		
		$this->getFooterXLS($this->phpExcel);	
	}
	
	/* tanpa filter rak
	public function RekapPersediaanBarangDetailXLS($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		$this->menuname='rekappersediaanbarangdetail';
		parent::actionDownxls();
		$qtyawal2=0;$nilaiawal2=0;$qtymasuk2=0;$nilaimasuk2=0;$qtytersedia2=0;$nilaitersedia2=0;$qtykeluar2=0;$nilaikeluar2=0;$qtyakhir2=0;$nilaiakhir2=0;
		$sql = "select distinct slocid,sloccode,materialgroupid,description from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,slocid,sloccode,materialgroupid,description
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,slocid,sloccode,materialgroupid,description
							from
							(select
							(
							select distinct aa.productid 
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
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid
							and l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,v.slocid,v.sloccode,u.materialgroupid,u.description
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
							where getcompanyfromsloc(v.slocid) = ".$companyid." and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%') z) zz )zzz where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0
					order by materialgroupid,slocid";

		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		
		foreach($dataReader as $row)
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
						->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
						->setCellValueByColumnAndRow(3,1,$this->GetCompanyCode($companyid));
						$line=5;				
		foreach($dataReader as $row)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'Gudang')
				->setCellValueByColumnAndRow(1,$line,': '.$row['sloccode'])
				->setCellValueByColumnAndRow(3,$line,'Material Group')
				->setCellValueByColumnAndRow(4,$line,': '.$row['description']);							
			$line++;
				
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'No')
				->setCellValueByColumnAndRow(1,$line,'Nama Barang')
				->setCellValueByColumnAndRow(2,$line,'Satuan')					
				->setCellValueByColumnAndRow(3,$line,'Qty')
				->setCellValueByColumnAndRow(4,$line,'Harga')
				->setCellValueByColumnAndRow(5,$line,'Nilai')
				->setCellValueByColumnAndRow(6,$line,'Qty')
				->setCellValueByColumnAndRow(7,$line,'Nilai')
				->setCellValueByColumnAndRow(8,$line,'Qty')
				->setCellValueByColumnAndRow(9,$line,'Harga')
				->setCellValueByColumnAndRow(10,$line,'Nilai')
				->setCellValueByColumnAndRow(11,$line,'Qty')
				->setCellValueByColumnAndRow(12,$line,'Nilai')
				->setCellValueByColumnAndRow(13,$line,'Qty')
				->setCellValueByColumnAndRow(14,$line,'Nilai')
				->setCellValueByColumnAndRow(15,$line,'');
			$line++;
			$i=0;$qtyawal=0;$nilaiawal=0;$qtymasuk=0;$nilaimasuk=0;$qtytersedia=0;$nilaitersedia=0;$qtykeluar=0;$nilaikeluar=0;$qtyakhir=0;$nilaiakhir=0;
			$sql1 = "select *,case when akhir < 0 then 'X' else '' end as minus from
							(select barang,satuan,awal,masuk,keluar,(awal+masuk+keluar) as akhir,harga
							from
							(select barang,satuan,awal,(beli+returjual+trfin+produksi+konversiin) as masuk,(jual+returbeli+trfout+pemakaian+koreksi+konversiout) as keluar,harga
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
							aw.transdate < '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' and
							aw.slocid = t.slocid
							) as awal,
							(
							select ifnull(sum(c.qty),0) 
							from productstockdet c
							join sloc cc on cc.slocid = c.slocid
							where c.productid = t.productid and
							c.referenceno like 'GR-%' and
							c.slocid = t.slocid and
							c.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as beli,
							(
							select ifnull(sum(d.qty),0) 
							from productstockdet d
							join sloc dd on dd.slocid = d.slocid
							where d.productid = t.productid and
							d.referenceno like 'GIR-%' and
							d.slocid = t.slocid and
							d.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returjual,
							(
							select ifnull(sum(e.qty),0) 
							from productstockdet e
							join sloc ee on ee.slocid = e.slocid
							where e.productid = t.productid and
							e.referenceno like 'TFS-%' and
							e.qty > 0 and
							e.slocid = t.slocid and
							e.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfin,
							(
							select ifnull(sum(f.qty),0) 
							from productstockdet f
							join sloc ff on ff.slocid = f.slocid
							where f.productid = t.productid and
							f.referenceno like 'OP-%' and
							f.qty > 0 and
							f.slocid = t.slocid and
							f.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as produksi,
							(
							select ifnull(sum(g.qty),0) 
							from productstockdet g
							join sloc gg on gg.slocid = g.slocid
							where g.productid = t.productid and
							g.referenceno like 'SJ-%' and
							g.slocid = t.slocid and
							g.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as jual,
							(
							select ifnull(sum(h.qty),0) 
							from productstockdet h
							join sloc hh on hh.slocid = h.slocid
							where h.productid = t.productid and
							h.referenceno like 'GRR-%' and
							h.slocid = t.slocid and
							h.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as returbeli,
							(
							select ifnull(sum(i.qty),0) 
							from productstockdet i
							join sloc ii on ii.slocid = i.slocid
							where i.productid = t.productid and
							i.referenceno like 'TFS-%' and
							i.qty < 0 and
							i.slocid = t.slocid and
							i.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as trfout,
							(
							select ifnull(sum(j.qty),0) 
							from productstockdet j
							join sloc jj on jj.slocid = j.slocid
							where j.productid = t.productid and
							j.referenceno like 'OP-%' and
							j.qty < 0 and
							j.slocid = t.slocid and
							j.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as pemakaian,
							(
							select ifnull(sum(k.qty),0) 
							from productstockdet k
							join sloc kk on kk.slocid = k.slocid
							where k.productid = t.productid and
							k.referenceno like 'TSO-%' and
							k.slocid = t.slocid and
							k.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as koreksi,
							(select ifnull(sum(l.qty),0) 
							from productstockdet l
							join sloc ll on ll.slocid = l.slocid
							where l.productid = t.productid and
							l.referenceno like '%konversi%' and
							l.qty > 0 and
							l.slocid = t.slocid
							and l.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiin,
							(
							select ifnull(sum(m.qty),0) 
							from productstockdet m
							join sloc mm on mm.slocid = m.slocid
							where m.productid = t.productid and
							m.referenceno like '%konversi%' and
							m.qty < 0 and
							m.slocid = t.slocid and
							m.transdate between '".date(Yii::app()->params['datetodb'], strtotime($startdate))."' 
							and '".date(Yii::app()->params['datetodb'], strtotime($enddate))."'
							) as konversiout,
							ifnull((select q.harga 
							from dataharga q
							where q.productid=t.productid
							),0) as harga
							from productplant t
							join materialgroup u on u.materialgroupid = t.materialgroupid
							join sloc v on v.slocid = t.slocid
									where getcompanyfromsloc(v.slocid) = ".$companyid."
              and u.materialgroupid = '".$row['materialgroupid']."' 
							and v.slocid = '".$row['slocid']."' and v.sloccode like '%".$sloc."%'
							and u.materialgroupcode like '%".$materialgroup."%' order by barang) z) zz )zzz 
							where awal<>0 or masuk<>0 or keluar<>0 or akhir<>0 order by barang asc";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			

			$i=0;
				
			foreach($dataReader1 as $row1)
			{
				$i+=1;
				$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row1['barang'])
					->setCellValueByColumnAndRow(2,$line,$row1['satuan'])
					->setCellValueByColumnAndRow(3,$line,$row1['awal'])
					->setCellValueByColumnAndRow(4,$line,$row1['harga']/$per)
					->setCellValueByColumnAndRow(5,$line,$row1['awal']*$row1['harga']/$per)
					->setCellValueByColumnAndRow(6,$line,$row1['masuk'])
					->setCellValueByColumnAndRow(7,$line,$row1['masuk']*$row1['harga']/$per)
					->setCellValueByColumnAndRow(8,$line,$row1['awal']+$row1['masuk'])
					->setCellValueByColumnAndRow(9,$line,$row1['harga']/$per)
					->setCellValueByColumnAndRow(10,$line,($row1['awal']+$row1['masuk'])*$row1['harga']/$per)
					->setCellValueByColumnAndRow(11,$line,$row1['keluar'])
					->setCellValueByColumnAndRow(12,$line,$row1['keluar']*$row1['harga']/$per)
					->setCellValueByColumnAndRow(13,$line,$row1['akhir'])
					->setCellValueByColumnAndRow(14,$line,$row1['akhir']*$row1['harga']/$per)
					->setCellValueByColumnAndRow(15,$line,$row1['minus']);
				$qtyawal += $row1['awal'];
				$nilaiawal += ($row1['awal'] * $row1['harga']/$per);
				$qtymasuk += $row1['masuk'];
				$nilaimasuk += ($row1['masuk'] * $row1['harga']/$per);
				$qtytersedia += ($row1['awal'] + $row1['masuk']);
				$nilaitersedia += (($row1['awal'] + $row1['masuk']) * $row1['harga']/$per);
				$qtykeluar += $row1['keluar'];
				$nilaikeluar += ($row1['keluar'] * $row1['harga']/$per);
				$qtyakhir += $row1['akhir'];
				$nilaiakhir += ($row1['akhir'] * $row1['harga']/$per);					
				$line+=1;
			}
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,'TOTAL '.$row['sloccode'].' - '.$row['description'])
				->setCellValueByColumnAndRow(3,$line,$qtyawal)
				->setCellValueByColumnAndRow(5,$line,$nilaiawal)
				->setCellValueByColumnAndRow(6,$line,$qtymasuk)
				->setCellValueByColumnAndRow(7,$line,$nilaimasuk)
				->setCellValueByColumnAndRow(8,$line,$qtytersedia)
				->setCellValueByColumnAndRow(10,$line,$nilaitersedia)
				->setCellValueByColumnAndRow(11,$line,$qtykeluar)
				->setCellValueByColumnAndRow(12,$line,$nilaikeluar)
				->setCellValueByColumnAndRow(13,$line,$qtyakhir)
				->setCellValueByColumnAndRow(14,$line,$nilaiakhir);
			$qtyawal2 += $qtyawal;
			$nilaiawal2 += $nilaiawal;
			$qtymasuk2 += $qtymasuk;
			$nilaimasuk2 += $nilaimasuk;
			$qtytersedia2 += $qtytersedia;
			$nilaitersedia2 += $nilaitersedia;
			$qtykeluar2 += $qtykeluar;
			$nilaikeluar2 += $nilaikeluar;
			$qtyakhir2 += $qtyakhir;
			$nilaiakhir2 += $nilaiakhir;
			$line +=2;
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,$line,'GRAND TOTAL')
			->setCellValueByColumnAndRow(3,$line,$qtyawal2)
			->setCellValueByColumnAndRow(5,$line,$nilaiawal2)
			->setCellValueByColumnAndRow(6,$line,$qtymasuk2)
			->setCellValueByColumnAndRow(7,$line,$nilaimasuk2)
			->setCellValueByColumnAndRow(8,$line,$qtytersedia2)
			->setCellValueByColumnAndRow(10,$line,$nilaitersedia2)
			->setCellValueByColumnAndRow(11,$line,$qtykeluar2)
			->setCellValueByColumnAndRow(12,$line,$nilaikeluar2)
			->setCellValueByColumnAndRow(13,$line,$qtyakhir2)
			->setCellValueByColumnAndRow(14,$line,$nilaiakhir2);
		
		$this->getFooterXLS($this->phpExcel);	
	}
	*/
	public function HppXLS($companyid,$sloc,$materialgroup,$storagebin,$product,$startdate,$enddate,$per)
	{
		$this->menuname='hpp';
		parent::actionDownxls();
		$sql = "select distinct a.materialgroupid,a.description
						from materialgroup a
						join productplant b on b.materialgroupid = a.materialgroupid
						join sloc c on c.slocid = b.slocid
						join plant d on d.plantid = c.plantid
						join product e on e.productid = b.productid
						where d.companyid = '".$companyid."'";

			$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
			
			
			foreach($dataReader as $row)
			$this->phpExcel->setActiveSheetIndex(0)
							->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)))
							->setCellValueByColumnAndRow(3,2,date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)))
							->setCellValueByColumnAndRow(3,1,$this->GetCompanyCode($companyid));
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
									->setCellValueByColumnAndRow(2,$line,'Satuan')					
									->setCellValueByColumnAndRow(3,$line,'HPP');
							$line++;
							$sql1 = "select distinct b.productname,f.description as uom,ifnull(a.buyprice,0) as hpp
											from productdetail a
											join product b on b.productid = a.productid
											join sloc c on c.slocid = a.slocid
											join productplant d on d.productid = a.productid and d.slocid = a.slocid and d.unitofissue = a.unitofmeasureid
											join materialgroup e on e.materialgroupid = d.materialgroupid
											join unitofmeasure f on f.unitofmeasureid = a.unitofmeasureid
											where e.materialgroupid = '".$row['materialgroupid']."'";
							$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
							
				
               $i=0;
								
							foreach($dataReader1 as $row1)
							{
								$i+=1;
									$this->phpExcel->setActiveSheetIndex(0)
											->setCellValueByColumnAndRow(0,$line,$i)
											->setCellValueByColumnAndRow(1,$line,$row1['productname'])
											->setCellValueByColumnAndRow(2,$line,$row1['uom'])
											->setCellValueByColumnAndRow(3,$line,$row1['hpp']/$per);
									$line++;
									
							}
							$line += 1;
			}
		
		
		$this->getFooterXLS($this->phpExcel);
	}
		
		
}

