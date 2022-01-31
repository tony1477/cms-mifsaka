<?php

class CbinController extends AdminController
{
	protected $menuname = 'cbin';
	public $module = 'Accounting';
	protected $pageTitle = 'Penerimaan Kas/Bank';
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
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appcbin')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listcbin').") 
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
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
		}
		$countcbinjournal = Yii::app()->db->createCommand($this->sqlcountcbinjournal)->queryScalar();
$dataProvidercbinjournal=new CSqlDataProvider($this->sqldatacbinjournal,array(
					'totalItemCount'=>$countcbinjournal,
					'keyField'=>'cbinjournalid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'cbinjournalid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercbinjournal'=>$dataProvidercbinjournal));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into cbin (recordstatus) values (".$this->findstatusbyuser('inscbin').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'cbinid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inscbin")
		));
	}
  public function actionCreatecbinjournal()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"debit" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0,
      "tglcair" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.cbinid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'docdate'=>$model['docdate'],
          'companyid'=>$model['companyid'],
          'ttntid'=>$model['ttntid'],
          'headernote'=>$model['headernote'],
          'companyname'=>$model['companyname'],
          'docno'=>$model['docno'],

					));
					Yii::app()->end();
				}
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
		}
	}

  public function actionUpdatecbinjournal()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatacbinjournal.' where cbinjournalid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'accountid'=>$model['accountid'],
          'debit'=>$model['debit'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'chequeid'=>$model['chequeid'],
          'tglcair'=>$model['tglcair'],
          'description'=>$model['description'],
          'accountname'=>$model['accountname'],
          'currencyname'=>$model['currencyname'],
          'chequeno'=>$model['chequeno'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('docdate','string','emptydocdate'),
      array('companyid','string','emptycompanyid'),
      array('ttntid','string','emptyttntid'),
    ));
		if ($error == false)
		{
			$id = $_POST['cbinid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call cbinjournal (:docdate
,:companyid
,:ttntid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':cbinid',$_POST['cbinid'],PDO::PARAM_STR);
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':ttntid',(($_POST['ttntid']!=='')?$_POST['ttntid']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
				$command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
public function actionSavecbinjournal()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('accountid','string','emptyaccountid'),
      array('debit','string','emptydebit'),
      array('currencyid','string','emptycurrencyid'),
      array('currencyrate','string','emptycurrencyrate'),
    ));
		if ($error == false)
		{
			$id = $_POST['cbinjournalid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update cbinjournal 
			      set accountid = :accountid,debit = :debit,currencyid = :currencyid,currencyrate = :currencyrate,chequeid = :chequeid,tglcair = :tglcair,description = :description 
			      where cbinjournalid = :cbinjournalid';
				}
				else
				{
					$sql = 'insert into cbinjournal (accountid,debit,currencyid,currencyrate,chequeid,tglcair,description) 
			      values (:accountid,:debit,:currencyid,:currencyrate,:chequeid,:tglcair,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':cbinjournalid',$_POST['cbinjournalid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':debit',(($_POST['debit']!=='')?$_POST['debit']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':chequeid',(($_POST['chequeid']!=='')?$_POST['chequeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':tglcair',(($_POST['tglcair']!=='')?$_POST['tglcair']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->InsertTranslog($command,$id);
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
	
public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Approvecbin(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	
public function actionDelete()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Deletecbin(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from cbin where cbinid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
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
	}public function actionPurgecbinjournal()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
				$sql = "delete from cbinjournal where cbinjournalid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
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
		$sql = "select distinct a.cbinid,a.cbinno,a.docdate as cbindate,c.docno as ttntno,c.docdate as ttntdate,b.companyid,concat('Pelunasan Piutang ',c.docno) as uraian
                        from cbin a
                        left join company b on b.companyid = a.companyid
                        left join ttnt c on c.ttntid = a.ttntid
                        left join cbinjournal d on d.cbinid = a.cbinid ";
		if ($_GET['cbinid'] !== '') {
				$sql = $sql . "where a.cbinid in (".$_GET['cbinid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('cbin');
                $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(8);
                    $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['cbinno']);
                    $this->pdf->text(160,$this->pdf->gety()+2,'TTNT ');$this->pdf->text(170,$this->pdf->gety()+2,': '.$row['ttntno']);
                    $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['cbindate'])));
                    $this->pdf->text(160,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(170,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['ttntdate'])));
                    $sql1 = "select b.accountname,a.description,d.chequeno,a.tglcair,a.debit,c.currencyname,a.currencyrate
                            from cbinjournal a
                            left join account b on b.accountid=a.accountid
                            left join currency c on c.currencyid=a.currencyid
														left join cheque d on d.chequeid = a.chequeid
                            where a.cbinid = ".$row['cbinid'];
                    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                    
					$total = 0;$totalqty=0;				
                    $this->pdf->sety($this->pdf->gety()+10);    
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
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'  Admin Kasir');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
                $this->pdf->checkNewPage(40);
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