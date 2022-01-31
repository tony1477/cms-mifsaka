<?php

class RepcbinController extends AdminController
{
	protected $menuname = 'repcbin';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Penerimaan Kas/Bank';
	public $wfname = 'appcbin';
	protected $sqldata = "select a0.cbinid,a0.docdate,a0.companyid,a0.cbinno,a0.ttntid,a0.iscutar,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.docno as docno,a0.statusname  
    from cbin a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
  ";
protected $sqldatacbinjournal = "select a0.cbinjournalid,a0.cbinid,a0.accountid,a0.debit,a0.currencyid,a0.currencyrate,a0.chequeid,a0.tglcair,a0.description,a1.accountname as accountname,a2.currencyname as currencyname,a3.chequeno as chequeno 
    from cbinjournal a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join cheque a3 on a3.chequeid = a0.chequeid
  ";
  protected $sqlcount = "select count(1) 
    from cbin a0 
    left join company a1 on a1.companyid = a0.companyid
    left join ttnt a2 on a2.ttntid = a0.ttntid
  ";
protected $sqlcountcbinjournal = "select count(1) 
    from cbinjournal a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join cheque a3 on a3.chequeid = a0.chequeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['cbinno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['docno'])))
		{				
			$where .=  " 
and a0.cbinno like '%". $_REQUEST['cbinno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.docno like '%". $_REQUEST['docno']."%'"; 
		}
		if (isset($_REQUEST['cbinid']))
			{
				if (($_REQUEST['cbinid'] !== '0') && ($_REQUEST['cbinid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.cbinid in (".$_REQUEST['cbinid'].")";
					}
					else
					{
						$where .= " and a0.cbinid in (".$_REQUEST['cbinid'].")";
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
			'keyField'=>'cbinid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cbinid','docdate','companyid','cbinno','ttntid','iscutar','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'cbinid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['cbinid']))
		{
			$this->sqlcountcbinjournal .= ' where a0.cbinid = '.$_REQUEST['cbinid'];
			$this->sqldatacbinjournal .= ' where a0.cbinid = '.$_REQUEST['cbinid'];
			$count = Yii::app()->db->createCommand($this->sqlcountcbinjournal)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatacbinjournal .= " limit 0";
		}
		$countcbinjournal = $count;
$dataProvidercbinjournal=new CSqlDataProvider($this->sqldatacbinjournal,array(
					'totalItemCount'=>$countcbinjournal,
					'keyField'=>'cbinjournalid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'cbinjournalid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercbinjournal'=>$dataProvidercbinjournal));
	}

	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
	  parent::actionDownload();
                $sql = "select distinct a.cbinid,a.cbinno,a.docdate as cbindate,c.docno as ttntno,c.docdate as ttntdate,b.companyid,concat('Pelunasan Piutang ',c.docno) as uraian
                        from cbin a
                        left join company b on b.companyid = a.companyid
                        left join ttnt c on c.ttntid = a.ttntid
                        left join cbinjournal d on d.cbinid = a.cbinid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.cbinid in (".$_GET['id'].")";
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=Catalogsys::model()->getcatalog('cbin');
                $this->pdf->AddPage('P',array(220,70));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(7);
                    $this->pdf->text(10,$this->pdf->gety(),'No ');$this->pdf->text(30,$this->pdf->gety(),': '.$row['cbinno']);
                    $this->pdf->text(60,$this->pdf->gety(),'Tgl ');$this->pdf->text(70,$this->pdf->gety(),': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cbindate'])));
                    $this->pdf->text(100,$this->pdf->gety(),'TTNT ');$this->pdf->text(130,$this->pdf->gety(),': '.$row['ttntno']);
                    $this->pdf->text(160,$this->pdf->gety(),'Tgl ');$this->pdf->text(180,$this->pdf->gety(),': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));
                    $sql1 = "select b.accountname,a.description,d.chequeno,a.tglcair,a.debit,c.currencyname,a.currencyrate
                            from cbinjournal a
                            left join account b on b.accountid=a.accountid
                            left join currency c on c.currencyid=a.currencyid
														left join cheque d on d.chequeid = a.chequeid
                            where a.cbinid = ".$row['cbinid'];
                    $command1=$this->connection->createCommand($sql1);
                    $dataReader1=$command1->queryAll();
                    
					$total = 0;$totalqty=0;				
                    $this->pdf->sety($this->pdf->gety()+3);    
                    $this->pdf->colalign = array('C','L','L','L','C','C','C');
                    $this->pdf->setwidths(array(10,40,65,20,20,25,25));
                    $this->pdf->colheader = array('No','Akun','Keterangan','No. Cek/Giro','Tgl. Cair','Debit','Kredit');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('C','L','L','L','C','R','R');
                    $i=0;
                    foreach($dataReader1 as $row1)
					
					
					{
                        $i=$i+1;
                        $this->pdf->row(array($i,$row1['accountname'],
						$row1['description'],$row1['chequeno'],$row1['tglcair'],
                        Yii::app()->format->formatCurrency($row1['debit']),
						'0.00')
                        );
						
					$total = $row1['debit'] + $total;
					}
					$i=$i+1;
					$this->pdf->row(array($i,'KAS PENAMPUNG PIUTANG',$row['uraian'],'','','0.00',
					Yii::app()->format->formatCurrency($total)));
					
					$this->pdf->setbordercell(array('TB','TB','TB','TB','TB','TB','TB'));
					$this->pdf->row(array('','','Jumlah','','',
					Yii::app()->format->formatCurrency($total),
					Yii::app()->format->formatCurrency($total)));
					                
                    //      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+18,'........................');$this->pdf->text(55,$this->pdf->gety()+18,'.........................');$this->pdf->text(96,$this->pdf->gety()+18,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+20,'  Admin Kasir');$this->pdf->text(55,$this->pdf->gety()+20,'     Controller');$this->pdf->text(96,$this->pdf->gety()+20,'Chief Accounting');
                //$this->pdf->checkNewPage(40);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cbinid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cbinno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('iscutar'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cbinid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cbinno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['iscutar'])
->setCellValueByColumnAndRow(6, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}