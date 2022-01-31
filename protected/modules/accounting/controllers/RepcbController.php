<?php

class RepcbController extends AdminController
{
	protected $menuname = 'repcb';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Cash Bank';
	public $wfname = 'appcb';
	protected $sqldata = "select a0.cbid,a0.docdate,a0.companyid,a0.cashbankno,a0.receiptno,a0.isin,a0.headernote,a0.recordstatus,a1.companyname as companyname,a0.statusname  
    from cb a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqldatacbacc = "select a0.cbaccid,a0.cbid,a0.debitaccid,a0.creditaccid,a0.amount,a0.currencyid,a0.currencyrate,a0.chequeid,a0.tglcair,a0.tgltolak,a0.description,a1.accountname as accountname,a2.accountname as accountname,a3.currencyname as currencyname,a4.chequeno as chequeno 
    from cbacc a0 
    left join account a1 on a1.accountid = a0.debitaccid
    left join account a2 on a2.accountid = a0.creditaccid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join cheque a4 on a4.chequeid = a0.chequeid
  ";
protected $sqldatacheque = "select a0.chequeid,a0.companyid,a0.tglbayar,a0.chequeno,a0.bankid,a0.amount,a0.currencyid,a0.currencyrate,a0.tglcheque,a0.tgltempo,a0.tglcair,a0.tgltolak,a0.addressbookid,a0.iscustomer,a0.recordstatus,a1.companyname as companyname,a2.bankname as bankname,a3.currencyname as currencyname,a4.fullname as fullname 
    from cheque a0 
    left join company a1 on a1.companyid = a0.companyid
    left join bank a2 on a2.bankid = a0.bankid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join addressbook a4 on a4.addressbookid = a0.addressbookid
  ";
protected $sqldatabank = "select a0.bankid,a0.bankname,a0.recordstatus 
    from bank a0 
  ";
  protected $sqlcount = "select count(1) 
    from cb a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqlcountcbacc = "select count(1) 
    from cbacc a0 
    left join account a1 on a1.accountid = a0.debitaccid
    left join account a2 on a2.accountid = a0.creditaccid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join cheque a4 on a4.chequeid = a0.chequeid
  ";
protected $sqlcountcheque = "select count(1) 
    from cheque a0 
    left join company a1 on a1.companyid = a0.companyid
    left join bank a2 on a2.bankid = a0.bankid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join addressbook a4 on a4.addressbookid = a0.addressbookid
  ";
protected $sqlcountbank = "select count(1) 
    from bank a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['cashbankno'])) && (isset($_REQUEST['receiptno'])) && (isset($_REQUEST['headernote'])) && (isset($_REQUEST['companyname'])))
		{				
			$where .=  " 
and a0.cashbankno like '%". $_REQUEST['cashbankno']."%' 
and a0.receiptno like '%". $_REQUEST['receiptno']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
		if (isset($_REQUEST['cbid']))
			{
				if (($_REQUEST['cbid'] !== '0') && ($_REQUEST['cbid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.cbid in (".$_REQUEST['cbid'].")";
					}
					else
					{
						$where .= " and a0.cbid in (".$_REQUEST['cbid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'cbid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cbid','docdate','companyid','cashbankno','receiptno','isin','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'cbid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['cbid']))
		{
			$this->sqlcountcbacc .= ' where a0.cbid = '.$_REQUEST['cbid'];
			$this->sqldatacbacc .= ' where a0.cbid = '.$_REQUEST['cbid'];
		}
		$countcbacc = Yii::app()->db->createCommand($this->sqlcountcbacc)->queryScalar();
$dataProvidercbacc=new CSqlDataProvider($this->sqldatacbacc,array(
					'totalItemCount'=>$countcbacc,
					'keyField'=>'cbaccid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'cbaccid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['cbid']))
		{
			$this->sqlcountcheque .= '';
			$this->sqldatacheque .= '';
		}
		$countcheque = Yii::app()->db->createCommand($this->sqlcountcheque)->queryScalar();
$dataProvidercheque=new CSqlDataProvider($this->sqldatacheque,array(
					'totalItemCount'=>$countcheque,
					'keyField'=>'chequeid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'chequeid' => CSort::SORT_DESC
						),
					),
					));
		/*if (isset($_REQUEST['cbid']))
		{
			$this->sqlcountbank .= ' where a0.cbid = '.$_REQUEST['cbid'];
			$this->sqldatabank .= ' where a0.cbid = '.$_REQUEST['cbid'];
		}*/
		$countbank = Yii::app()->db->createCommand($this->sqlcountbank)->queryScalar();
$dataProviderbank=new CSqlDataProvider($this->sqldatabank,array(
					'totalItemCount'=>$countbank,
					'keyField'=>'bankid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'bankid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercbacc'=>$dataProvidercbacc,'dataProvidercheque'=>$dataProvidercheque,'dataProviderbank'=>$dataProviderbank));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select *,a.cashbankno,a.docdate,a.receiptno
			from cb a
			join company b on b.companyid = a.companyid ";
		if ($_GET['cbid'] !== '') 
		{
				$sql = $sql . "where a.cbid in (".$_GET['cbid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title=$this->getcatalog('cashbank');
		$this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
		foreach($dataReader as $row)
		{
				$this->pdf->SetFontSize(8);
				$this->pdf->text(10,$this->pdf->gety()+2,'No. Transaksi ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cashbankno']);
				$this->pdf->text(120,$this->pdf->gety()+2,'No Kwitansi ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['receiptno']);
				$this->pdf->text(10,$this->pdf->gety()+6,'Tanggal ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
				//$this->pdf->text(120,$this->pdf->gety()+6,'SO ');$this->pdf->text(130,$this->pdf->gety()+6,': '.$row['sono']. ' / '.$row['customer']);
				$sql1 = "select b.accountname as accdebitname,c.accountname as acccreditname,a.description,a.amount,
					d.currencyname,e.chequeno,
					case when a.tglcair = '1970-01-01' then null else a.tglcair end as tglcair,
					case when a.tgltolak = '1970-01-01' then null else a.tgltolak end as tgltolak
					from cbacc a
					join account b on b.accountid = a.debitaccid
					join account c on c.accountid = a.creditaccid
					left join currency d on d.currencyid = a.currencyid
					left join cheque e on e.chequeid=a.chequeid
					where a.cbid = ".$row['cbid'];
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+10);

				$this->pdf->setFont('Arial','',7);
				$this->pdf->colalign = array('C','L','L','L','C','C','C','C','C');
				$this->pdf->setwidths(array(7,45,25,38,25,15,20,15,15));
				$this->pdf->colheader = array('No','Akun Debit','Akun Credit','Uraian','Nilai','Mata Uang','No. Cek/Giro','Tgl. Cair','Tgl. Tolak');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','L','L','R','C','R','C','L');
				$i=0;$amount=0;
				foreach($dataReader1 as $row1)
				{
					$i=$i+1;
					$this->pdf->row(array($i,$row1['accdebitname'],
						$row1['acccreditname'],
						$row1['description'],
						Yii::app()->format->formatCurrency($row1['amount']),
						$row1['currencyname'],
						$row1['chequeno'],
						(($row1['tglcair'] !== null)?date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tglcair'])):''),
						(($row1['tgltolak'] !== null)?date(Yii::app()->params['dateviewfromdb'], strtotime($row1['tgltolak'])):''),
					));
					$amount += $row1['amount'];
				}
				$this->pdf->setFont('Arial','',8);
				$this->pdf->row(array('','','','JUMLAH',
					Yii::app()->format->formatCurrency($amount),$row1['currencyname'],'','','',
				));
				$bilangan = explode(".",$amount);
								
				$this->pdf->sety($this->pdf->gety()+0);
				$this->pdf->setFont('Arial','I',8);
				$this->pdf->colalign = array('C','C');
				$this->pdf->setwidths(array(7,200));
				$this->pdf->coldetailalign = array('L','L');
				$this->pdf->row(array('','Terbilang : '.$this->eja($bilangan[0]).' '.$row1['currencyname'],));
				$this->pdf->setFont('Arial','BI',8);
				$this->pdf->row(array('','NOTE : '.$row['headernote'],));
        $this->pdf->checkNewPage(15);
                   
				//$this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
				$this->pdf->setFont('Arial','',8);
				$this->pdf->sety($this->pdf->gety()+5);
				/*$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(120,$this->pdf->gety(),'Mengetahui Peminta');$this->pdf->text(170,$this->pdf->gety(),'Peminta Barang');
				$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(120,$this->pdf->gety()+15,'........................');$this->pdf->text(170,$this->pdf->gety()+15,'........................');*/
				$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Disetujui oleh,');
				$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
				$this->pdf->text(15,$this->pdf->gety()+25,'  Admin Kasir');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
				//$this->pdf->checkNewPage(100);
				//$this->pdf->checkPageBreak(40);
		}
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cbid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cashbankno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('receiptno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('isin'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cbid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cashbankno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['receiptno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['isin'])
->setCellValueByColumnAndRow(6, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}