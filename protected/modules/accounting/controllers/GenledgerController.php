<?php

class GenledgerController extends AdminController
{
	protected $menuname = 'genledger';
	public $module = 'Accounting';
	protected $pageTitle = 'General Ledger';
	public $wfname = '';
	protected $sqldata = "select a3.symbol,a4.companyname,a1.companyid,a0.genledgerid,a0.accountid,a0.genjournalid,a0.debit,a0.credit,a0.postdate,a0.currencyid,a0.ratevalue,a1.accountcode as accountcode,a2.journalno as journalno,a3.currencyname as currencyname 
    from genledger a0 
    left join account a1 on a1.accountid = a0.accountid
    left join genjournal a2 on a2.genjournalid = a0.genjournalid
    left join currency a3 on a3.currencyid = a0.currencyid
		left join company a4 on a4.companyid = a1.companyid 
  ";
  protected $sqlcount = "select count(1) 
    from genledger a0 
    left join account a1 on a1.accountid = a0.accountid
    left join genjournal a2 on a2.genjournalid = a0.genjournalid
    left join currency a3 on a3.currencyid = a0.currencyid
		left join company a4 on a4.companyid = a1.companyid   
	";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['journalno'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .= " where a2.journalno like '%". $_REQUEST['journalno']."%' 
and a3.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['genledgerid']))
			{
				if (($_REQUEST['genledgerid'] !== '0') && ($_REQUEST['genledgerid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.genledgerid in (".$_REQUEST['genledgerid'].")";
					}
					else
					{
						$where .= " and a0.genledgerid in (".$_REQUEST['genledgerid'].")";
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
			'keyField'=>'genledgerid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'genledgerid','accountid','genjournalid','debit','credit','postdate','currencyid','ratevalue'
				),
				'defaultOrder' => array( 
					'genledgerid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	
	
	
	
	
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('genledger');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('genledgerid'),$this->getCatalog('account'),$this->getCatalog('genjournal'),$this->getCatalog('debit'),$this->getCatalog('credit'),$this->getCatalog('postdate'),$this->getCatalog('currency'),$this->getCatalog('ratevalue'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['genledgerid'],$row1['accountcode'],$row1['journalno'],$row1['debit'],$row1['credit'],$row1['postdate'],$row1['currencyname'],$row1['ratevalue']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('genledgerid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('accountcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('journalno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('debit'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('credit'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('postdate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('ratevalue'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['genledgerid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['accountcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['journalno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['debit'])
->setCellValueByColumnAndRow(4, $i+1, $row1['credit'])
->setCellValueByColumnAndRow(5, $i+1, $row1['postdate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(7, $i+1, $row1['ratevalue']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}