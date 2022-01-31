<?php

class RepcutarController extends AdminController
{
	protected $menuname = 'repcutar';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Pelunasan Piutang';
	public $wfname = 'appcutar';
	protected $sqldata = "select a0.cutarid,a0.docdate,a0.companyid,a0.cutarno,a0.ttntid,a0.cbinid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.docno as docno,a3.cbinno as cbinno,a0.statusname  
    from cutar a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
    left join cbin a3 on a3.cbinid = a0.cbinid
  ";
protected $sqldatacutarinv = "select a0.cutarinvid,a0.cutarid,a0.invoiceid,a0.saldoinvoice,a0.invoicedate,a0.cashamount,a0.bankamount,a0.discamount,a0.returnamount,a0.obamount,a0.currencyid,a0.currencyrate,a0.description,a1.invoiceno as invoiceno,a2.invoicedate as invoicedate,a3.currencyname as currencyname 
    from cutarinv a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
    left join invoice a2 on a2.invoiceid = a0.invoicedate
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from cutar a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
    left join cbin a3 on a3.cbinid = a0.cbinid
  ";
protected $sqlcountcutarinv = "select count(1) 
    from cutarinv a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
    left join invoice a2 on a2.invoiceid = a0.invoicedate
    left join currency a3 on a3.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['cutarno'])) && (isset($_REQUEST['headernote'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['docno'])) && (isset($_REQUEST['cbinno'])))
		{				
			$where .=  " 
and a0.cutarno like '%". $_REQUEST['cutarno']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.docno like '%". $_REQUEST['docno']."%' 
and a3.cbinno like '%". $_REQUEST['cbinno']."%'"; 
		}
		if (isset($_REQUEST['cutarid']))
			{
				if (($_REQUEST['cutarid'] !== '0') && ($_REQUEST['cutarid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.cutarid in (".$_REQUEST['cutarid'].")";
					}
					else
					{
						$where .= " and a0.cutarid in (".$_REQUEST['cutarid'].")";
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
			'keyField'=>'cutarid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cutarid','docdate','companyid','cutarno','ttntid','cbinid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'cutarid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['cutarid']))
		{
			$this->sqlcountcutarinv .= ' where a0.cutarid = '.$_REQUEST['cutarid'];
			$this->sqldatacutarinv .= ' where a0.cutarid = '.$_REQUEST['cutarid'];
			$count = Yii::app()->db->createCommand($this->sqlcountcutarinv)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatacutarinv .= " limit 0";
		}
		$countcutarinv = $count;
$dataProvidercutarinv=new CSqlDataProvider($this->sqldatacutarinv,array(
					'totalItemCount'=>$countcutarinv,
					'keyField'=>'cutarinvid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'cutarinvid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercutarinv'=>$dataProvidercutarinv));
	}

	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select distinct a.cutarid,a.cutarno,a.docdate as cutardate,c.docno as ttntno,c.docdate as ttntdate,b.companyid
                        from cutar a
                        left join company b on b.companyid = a.companyid
                        left join ttnt c on c.ttntid = a.ttntid
                        left join cutarinv d on d.cutarid = a.cutarid ";
		if ($_GET['cutarid'] !== '') {
				$sql = $sql . "where a.cutarid in (".$_GET['cutarid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('cutar');
                $this->pdf->AddPage('L','A4');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(8);
                    $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cutarno']);
                    $this->pdf->text(160,$this->pdf->gety()+2,'TTNT ');$this->pdf->text(170,$this->pdf->gety()+2,': '.$row['ttntno']);
                    $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cutardate'])));
                    $this->pdf->text(160,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(170,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));
                    $sql1 = "select a.cutarid,b.invoiceno,f.fullname,b.invoicedate,a.saldoinvoice,a.cashamount,a.bankamount,a.discamount,a.returnamount,a.obamount,
							(a.cashamount+a.bankamount+a.discamount+a.returnamount+a.obamount) as jumlah,c.currencyname,a.currencyrate,a.description,
							(a.saldoinvoice-(a.cashamount+a.bankamount+a.discamount+a.returnamount+a.obamount)) as sisa
                            from cutarinv a
                            left join invoice b on b.invoiceid = a.invoiceid
                            left join currency c on c.currencyid = a.currencyid
							left join giheader d on d.giheaderid=b.giheaderid
                            left join soheader e on e.soheaderid=d.soheaderid
                            left join addressbook f on f.addressbookid=e.addressbookid
                            where a.cutarid = ".$row['cutarid'];
                    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                    
					$total = 0;$totalqty=0;
					$total1 = 0;$totalqty1=0;
					$total2 = 0;$totalqty2=0;
					$total3 = 0;$totalqty3=0;
					$total4 = 0;$totalqty4=0;
					$total5 = 0;$totalqty5=0;
					$total6 = 0;$totalqty6=0;
					$total7 = 0;$totalqty7=0;
                    $this->pdf->sety($this->pdf->gety()+10);    
                    $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
                    $this->pdf->setwidths(array(10,20,30,20,25,25,25,25,25,25,25,25));
                    $this->pdf->colheader = array('No','No Invoice','Customer','Tgl Invoice','Saldo Invoice','Tunai','Bank','Diskon','Retur','OB','Jumlah','Sisa');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('C','L','L','C','R','R','R','R','R','R','R','R');
                    $i=0;
                    foreach($dataReader1 as $row1)
					
					
					{
                        $i=$i+1;
												$this->pdf->setFont('Arial','',7);
                        $this->pdf->row(array($i,$row1['invoiceno'],
						$row1['fullname'],
                        date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
                        Yii::app()->format->formatNumber($row1['saldoinvoice']),						
						Yii::app()->format->formatNumber($row1['cashamount']),
						Yii::app()->format->formatNumber($row1['bankamount']),
						Yii::app()->format->formatNumber($row1['discamount']),
						Yii::app()->format->formatNumber($row1['returnamount']),
						Yii::app()->format->formatNumber($row1['obamount']),                        
						Yii::app()->format->formatNumber($row1['jumlah']),
						Yii::app()->format->formatNumber($row1['sisa']))
                        );
						
					$total = $row1['saldoinvoice'] + $total;
					$total1 = $row1['cashamount'] + $total1;
					$total2 = $row1['bankamount'] + $total2;
					$total3 = $row1['discamount'] + $total3;
					$total4 = $row1['returnamount'] + $total4;
					$total5 = $row1['obamount'] + $total5;
					$total6 = $row1['jumlah'] + $total6;
					$total7 = $row1['sisa'] + $total7;
					}
					
					$this->pdf->setbordercell(array('TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB','TB'));
					$this->pdf->row(array('','','Total','',
					Yii::app()->format->formatNumber($total),					
					Yii::app()->format->formatNumber($total1),
					Yii::app()->format->formatNumber($total2),
					Yii::app()->format->formatNumber($total3),
					Yii::app()->format->formatNumber($total4),
					Yii::app()->format->formatNumber($total5),
					Yii::app()->format->formatNumber($total6),
					Yii::app()->format->formatNumber($total7)));
					                
                    //      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
                $this->pdf->checkNewPage(40);
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'   Admin AR');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cutarid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cutarno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('cbinno'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cutarid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cutarno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['cbinno'])
->setCellValueByColumnAndRow(6, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}