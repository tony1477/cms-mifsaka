<?php

class RepdailyController extends AdminController
{
	protected $menuname = 'repdaily';		
	public $module = 'accounting';
	protected $pageTitle = 'Report Harian Kas/Bank';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select * from (
		select 'Penerimaan' as ket,a.companyid, a.docdate, a.cbinno, c.docno, a.iscutar, a.headernote, a.recordstatus,
(
select ifnull(sum(ifnull(z.debit,0)),0)
from cbinjournal z
where z.cbinid = a.cbinid
) as amount
from cbin a 
join ttnt c on c.ttntid = a.ttntid 
where a.companyid = ".$_GET['company']." and a.docdate between '".date(Yii::app()->params['datetodb'], strtotime($_GET['startdate']))."' and '".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."'
union
select 'Pembayaran', b.companyid, b.docdate, b.cashbankoutno, d.reqpayno, '', '', b.recordstatus,
(
select ifnull(sum(ifnull(zz.payamount,0)),0)
from cbapinv zz
where zz.cashbankoutid = b.cashbankoutid
) as amount
from cashbankout b
join reqpay d on d.reqpayid = b.reqpayid
where b.companyid = ".$_GET['company']." and b.docdate between '".date(Yii::app()->params['datetodb'], strtotime($_GET['startdate']))."' and '".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."'
union
select 'Umum', c.companyid, c.docdate, c.cashbankno, c.receiptno, c.isin, c.headernote, c.recordstatus,
(
select ifnull(sum(ifnull(zzz.debit,0)),0)
from cashbankacc zzz
where zzz.cashbankid = c.cashbankid
) as amount
from cashbank c
where c.companyid = ".$_GET['company']." and c.docdate between '".date(Yii::app()->params['datetodb'], strtotime($_GET['startdate']))."' and '".date(Yii::app()->params['datetodb'], strtotime($_GET['enddate']))."' ) zzzz
order by docdate";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->companyid = $_GET['company'];
		}
		$this->pdf->title='Laporan Harian Kas / Bank';
		$this->pdf->subtitle='Dari Tgl :'.date(Yii::app()->params['dateviewfromdb'], strtotime($_GET['startdate'])).' s/d '.date(Yii::app()->params['dateviewfromdb'], strtotime($_GET['enddate']));
		$this->pdf->AddPage('P');
		
		$this->pdf->sety($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->setwidths(array(10,30,30,40,40,40));
		$this->pdf->colheader = array('No','Jenis','Doc Date','No Doc','No Receipt','Amount');
		$this->pdf->RowHeader();
		$i = 0;
		$this->pdf->coldetailalign = array('L','L','R','R','R','R');
		$this->pdf->setFont('Arial','',8);
			
		foreach($dataReader as $row)
		{
			$i++;
			$this->pdf->row(array(
				$i,$row['ket'],Yii::app()->format->formatDate($row['docdate']),$row['cbinno'],$row['docno'],
				Yii::app()->format->formatNumber($row['amount']),
			));
		}
		$this->pdf->CheckPageBreak(40);
		$this->pdf->Output();
	}
}

