<?php

class ReportglController extends AdminController
{
	protected $menuname = 'reportgl';
	public $module = 'Accounting';
	protected $pageTitle = 'Daftar Journal Umum';
	public $wfname = 'appjournal';
	protected $sqldata = "select a0.genjournalid,a0.companyid,a0.journalno,a0.referenceno,a0.journaldate,a0.postdate,a0.journalnote,a0.recordstatus,a1.companyname as companyname,a0.statusname 
    from genjournal a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqldatajournaldetail = "select a0.journaldetailid,a0.genjournalid,a0.accountid,a0.debit,a0.credit,a0.currencyid,a0.ratevalue,a0.detailnote,a1.accountcode as accountcode,a2.currencyname as currencyname 
    from journaldetail a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from genjournal a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqlcountjournaldetail = "select count(1) 
    from journaldetail a0 
    left join account a1 on a1.accountid = a0.accountid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['journalno'])) && (isset($_REQUEST['referenceno'])))
		{				
			$where .= " where a0.journalno like '%". $_REQUEST['journalno']."%' 
and a0.referenceno like '%". $_REQUEST['referenceno']."%'"; 
		}
		if (isset($_REQUEST['genjournalid']))
			{
				if (($_REQUEST['genjournalid'] !== '0') && ($_REQUEST['genjournalid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.genjournalid in (".$_REQUEST['genjournalid'].")";
					}
					else
					{
						$where .= " and a0.genjournalid in (".$_REQUEST['genjournalid'].")";
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
			'keyField'=>'genjournalid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'genjournalid','companyid','journalno','referenceno','journaldate','postdate','journalnote','recordstatus'
				),
				'defaultOrder' => array( 
					'genjournalid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['genjournalid']))
		{
			$this->sqlcountjournaldetail .= ' where a0.genjournalid = '.$_REQUEST['genjournalid'];
			$this->sqldatajournaldetail .= ' where a0.genjournalid = '.$_REQUEST['genjournalid'];
		}
		$countjournaldetail = Yii::app()->db->createCommand($this->sqlcountjournaldetail)->queryScalar();
$dataProviderjournaldetail=new CSqlDataProvider($this->sqldatajournaldetail,array(
					'totalItemCount'=>$countjournaldetail,
					'keyField'=>'journaldetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'journaldetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderjournaldetail'=>$dataProviderjournaldetail));
	}

	
	
	
	
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from genjournal where genjournalid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update genjournal set recordstatus = 0 where genjournalid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update genjournal set recordstatus = 1 where genjournalid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			else
			{
				$this->getMessage('success','chooseone');
			}
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$sql = "select a.genjournalid,
						ifnull(b.companyname,'-')as company,
						ifnull(a.journalno,'-')as journalno,
						ifnull(a.referenceno,'-')as referenceno,
						a.journaldate,a.postdate,
						ifnull(a.journalnote,'-')as journalnote,a.recordstatus
						from genjournal a
						left join company b on b.companyid = a.companyid ";
		if ($_GET['genjournalid'] !== '') 
		{
				$sql = $sql . "where a.genjournalid in (".$_GET['genjournalid'].")";
		}	    
		$debit = 0;
		$credit=0;	
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('genjournal');
	  $this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',10);		
		$this->pdf->AliasNBPages();
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFontSize(10);
      $this->pdf->text(15,$this->pdf->gety()+5,'No Journal ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['journalno']);
			$this->pdf->text(15,$this->pdf->gety()+10,'Ref No ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['referenceno']);			
			$this->pdf->text(15,$this->pdf->gety()+15,'Tgl Jurnal ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['journaldate']);
			
			$sql1 = "select b.accountcode,b.accountname, a.debit,a.credit,c.symbol,a.detailnote,a.ratevalue
							from journaldetail a
							left join account b on b.accountid = a.accountid
							left join currency c on c.currencyid = a.currencyid
							where a.genjournalid = '".$row['genjournalid']."'
							order by journaldetailid ";							
							
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+20);
      
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,70,25,25,10,55));
			$this->pdf->colheader = array('No','Account','Debit','Credit','Rate','Detail Note');
      $this->pdf->RowHeader();
			$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('C','L','R','R','R','L');
      $i=0;
      foreach($dataReader1 as $row1)
			{
				$i=$i+1;
				$debit=$debit + ($row1['debit'] * $row1['ratevalue']);
				$credit=$credit + ($row1['credit'] * $row1['ratevalue']);
        $this->pdf->row(array($i,$row1['accountcode'].' '.$row1['accountname'],
            Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['ratevalue']),
            $row1['detailnote']));
			}
			$this->pdf->row(array('','Total',
            Yii::app()->numberFormatter->formatCurrency($debit,$row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($credit,$row1['symbol']),'',''));
            
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->border=false;
			$this->pdf->setwidths(array(20,175));
			$this->pdf->row(array('Note',$row['journalnote']));

      $this->pdf->text(20,$this->pdf->gety()+20,'Approved By');$this->pdf->text(170,$this->pdf->gety()+20,'Proposed By');
      $this->pdf->text(20,$this->pdf->gety()+40,'_____________ ');$this->pdf->text(170,$this->pdf->gety()+40,'_____________');

      $this->pdf->CheckNewPage(10);
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('genjournalid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('journalno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('referenceno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('journaldate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('postdate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('journalnote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['genjournalid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['journalno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['referenceno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['journaldate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['postdate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['journalnote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}