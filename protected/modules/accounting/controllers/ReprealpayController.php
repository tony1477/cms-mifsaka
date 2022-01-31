<?php

class ReprealpayController extends AdminController
{
	protected $menuname = 'reprealpay';		
	public $module = 'accounting';
	protected $pageTitle = 'Report Realisasi Pembayaran';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select *,(zz.totalamount-zz.totalpayamount) as selisih
from (
select a.reqpayid,c.companyname,a.docdate,a.reqpayno,a.headernote,
(
select ifnull(sum(ifnull(b.amount,0)),0)
from reqpayinv b 
join invoiceap d on d.invoiceapid = b.invoiceapid 
join addressbook e on e.addressbookid = d.addressbookid 
where b.reqpayid = a.reqpayid and e.fullname like '%".$_GET['addressbook']."%' 
) as totalamount,
(
select ifnull(sum(ifnull(b.payamount,0)),0)
from reqpayinv b 
join invoiceap d on d.invoiceapid = b.invoiceapid 
join addressbook e on e.addressbookid = d.addressbookid 
where b.reqpayid = a.reqpayid and e.fullname like '%".$_GET['addressbook']."%' 
) as totalpayamount
from reqpay a
join company c on c.companyid = a.companyid
where docdate between '".date(Yii::app()->params['datetodb'], strtotime($_GET['startdate']))."' and '".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."' 
and c.companyid = ".$_GET['company']." 
) zz order by docdate";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $_GET['company'];
		}
		$this->pdf->title='Laporan Realisasi Pembayaran Hutang';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($_GET['startdate'])).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($_GET['enddate']));
		$this->pdf->AddPage('P');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',10);
			$this->pdf->text(10,$this->pdf->gety()+10,'Tanggal');$this->pdf->text(30,$this->pdf->gety()+10,': '.Yii::app()->format->formatDate($row['docdate']));
			$this->pdf->text(10,$this->pdf->gety()+15,'No Req Pay');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['reqpayno']);
			$this->pdf->text(10,$this->pdf->gety()+20,'Amount');$this->pdf->text(30,$this->pdf->gety()+20,': '.Yii::app()->format->formatNumber($row['totalamount']));
			$this->pdf->text(10,$this->pdf->gety()+25,'Pay Amount');$this->pdf->text(30,$this->pdf->gety()+25,': '.Yii::app()->format->formatNumber($row['totalpayamount']));
			$this->pdf->text(10,$this->pdf->gety()+30,'Selisih');$this->pdf->text(30,$this->pdf->gety()+30,': '.Yii::app()->format->formatNumber($row['selisih']));
			$sql1 = "select a.reqpayid, c.invoiceno, a.amount, a.payamount, (a.amount-a.payamount) as selisih
				from reqpayinv a
				join invoiceap c on c.invoiceapid = a.invoiceapid 
				where reqpayid = ".$row['reqpayid'];
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			$this->pdf->sety($this->pdf->gety()+35);
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colalign = array('C','C','C','C','C','C');
			$this->pdf->setwidths(array(10,30,40,40,40,30));
			$this->pdf->colheader = array('No','Invoice','Amount','Pay Amount','Selisih');
			$this->pdf->RowHeader();
			$i = 0;
			$this->pdf->coldetailalign = array('L','L','R','R','R','R');
			$this->pdf->setFont('Arial','',8);
			
			foreach($dataReader1 as $row1)
			{
				$i++;
				$this->pdf->row(array(
					$i,$row1['invoiceno'],
					Yii::app()->format->formatNumber($row1['amount']),
					Yii::app()->format->formatNumber($row1['payamount']),
					Yii::app()->format->formatNumber($row1['selisih']),
				));
			}
			$this->pdf->CheckPageBreak(40);
		}
		
		$this->pdf->Output();
	}
}

