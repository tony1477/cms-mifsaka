<?php

class RepcboutController extends AdminController
{
	protected $menuname = 'repcbout';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Pengeluaran Kas/Bank';
	public $wfname = 'appcbout';
	protected $sqldata = "select a0.cashbankoutid,a0.companyid,a0.docdate,a0.cashbankoutno,a0.reqpayid,a0.recordstatus,a1.companyname as companyname,a2.reqpayno as reqpayno,a0.statusname  
    from cashbankout a0 
    left join company a1 on a1.companyid = a0.companyid
    left join reqpay a2 on a2.reqpayid = a0.reqpayid
  ";
protected $sqldatacbapinv = "select a0.cbapinvid,a0.cashbankoutid,a0.invoiceapid,a0.ekspedisiid,a0.accountid,a0.cashbankno,a0.tglcair,a0.payamount,a0.currencyid,a0.currencyrate,a0.bankaccountno,a0.bankname,a0.bankowner,a0.itemnote,a1.invoiceno as invoiceno,a2.ekspedisino as ekspedisino,a3.accountname as accountname,a4.currencyname as currencyname 
    from cbapinv a0 
    left join invoiceap a1 on a1.invoiceapid = a0.invoiceapid
    left join ekspedisi a2 on a2.ekspedisiid = a0.ekspedisiid
    left join account a3 on a3.accountid = a0.accountid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from cashbankout a0 
    left join company a1 on a1.companyid = a0.companyid
    left join reqpay a2 on a2.reqpayid = a0.reqpayid
  ";
protected $sqlcountcbapinv = "select count(1) 
    from cbapinv a0 
    left join invoiceap a1 on a1.invoiceapid = a0.invoiceapid
    left join ekspedisi a2 on a2.ekspedisiid = a0.ekspedisiid
    left join account a3 on a3.accountid = a0.accountid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['cashbankoutno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['reqpayno'])))
		{				
			$where .=  " 
and a0.cashbankoutno like '%". $_REQUEST['cashbankoutno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.reqpayno like '%". $_REQUEST['reqpayno']."%'"; 
		}
		if (isset($_REQUEST['cashbankoutid']))
			{
				if (($_REQUEST['cashbankoutid'] !== '0') && ($_REQUEST['cashbankoutid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.cashbankoutid in (".$_REQUEST['cashbankoutid'].")";
					}
					else
					{
						$where .= " and a0.cashbankoutid in (".$_REQUEST['cashbankoutid'].")";
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
			'keyField'=>'cashbankoutid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cashbankoutid','companyid','docdate','cashbankoutno','reqpayid','recordstatus'
				),
				'defaultOrder' => array( 
					'cashbankoutid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['cashbankoutid']))
		{
			$this->sqlcountcbapinv .= ' where a0.cashbankoutid = '.$_REQUEST['cashbankoutid'];
			$this->sqldatacbapinv .= ' where a0.cashbankoutid = '.$_REQUEST['cashbankoutid'];
			$count = Yii::app()->db->createCommand($this->sqlcountcbapinv)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatacbapinv .= " limit 0";
		}
		$countcbapinv = $count;
$dataProvidercbapinv=new CSqlDataProvider($this->sqldatacbapinv,array(
					'totalItemCount'=>$countcbapinv,
					'keyField'=>'cbapinvid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'cbapinvid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercbapinv'=>$dataProvidercbapinv));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select *,a.companyid,a.cashbankoutno,a.docdate,c.reqpayno
                        from cashbankout a
                        left join company b on b.companyid = a.companyid
                        left join reqpay c on c.reqpayid = a.reqpayid
                        ";
		if ($_GET['cashbankoutid'] !== '') {
				$sql = $sql . "where a.cashbankoutid in (".$_GET['cashbankoutid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('cashbankout');
                $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font  

                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(8);
                    $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cashbankoutno']);
                    $this->pdf->text(120,$this->pdf->gety()+2,'Reqpay ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['reqpayno']);
                    $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
                    $sql1 = "select a.*,b.accountname,c.currencyname,e.pono
                            from cbapinv a
                            left join account b on b.accountid = a.accountid
                            left join currency c on c.currencyid = a.currencyid
														left join invoiceap d on d.invoiceapid = a.invoiceapid
														left join poheader e on e.poheaderid = d.poheaderid
                            where cashbankoutid = ".$row['cashbankoutid'];
                    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                    
                    $this->pdf->sety($this->pdf->gety()+10);
      
                    $this->pdf->colalign = array('C','C','C','C','C','C','C');
                    $this->pdf->setwidths(array(10,40,25,25,40,25,30));
                    $this->pdf->colheader = array('No','Akun','Tgl Cair','Dibayar','No Cash/Bank','Pemilik Akun','Keterangan');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('L','L','C','R','C','C','C');
                    $i=0;$total=0;
                    foreach($dataReader1 as $row1)
                    {
                        $i=$i+1;
                        $this->pdf->row(array($i,$row1['accountname'],
                        Yii::app()->format->formatDate($row1['tglcair']),
                        Yii::app()->format->formatCurrency($row1['payamount']),
                        $row1['cashbankno'],
                        $row1['bankowner'],
												$row1['pono'])
                        );
												$total += $row1['payamount'];
                    }
										$this->pdf->row(array(
                    '','TOTAL','',
                    Yii::app()->format->formatCurrency($total)
                    ));
                    
                    $this->pdf->sety($this->pdf->gety());
                    $this->pdf->colalign = array('C','C');
                    $this->pdf->setwidths(array(30,170));
                    $this->pdf->coldetailalign = array('L','L');
                    $this->pdf->row(array(
                    'Note:',
                    $row['headernote']
                    ));
                         
                        //      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
										$this->pdf->sety($this->pdf->gety()+10);
										$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
										$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
										$this->pdf->text(15,$this->pdf->gety()+25,'  Admin Kasir');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
                    $this->pdf->checkNewPage(20); 
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cashbankoutid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cashbankoutno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('reqpayno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cashbankoutid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cashbankoutno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['reqpayno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}