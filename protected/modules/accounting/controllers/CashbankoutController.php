<?php

class CashbankoutController extends AdminController
{
	protected $menuname = 'cashbankout';
	public $module = 'Accounting';
	protected $pageTitle = 'Pengeluaran Kas/Bank';
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
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appcbout')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listcbout').") 
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
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
		}
		$countcbapinv = Yii::app()->db->createCommand($this->sqlcountcbapinv)->queryScalar();
$dataProvidercbapinv=new CSqlDataProvider($this->sqldatacbapinv,array(
					'totalItemCount'=>$countcbapinv,
					'keyField'=>'cbapinvid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'cbapinvid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidercbapinv'=>$dataProvidercbapinv));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into cashbankout (recordstatus) values (".$this->findstatusbyuser('inscbout').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'cashbankoutid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inscbout")
		));
	}
  public function actionCreatecbapinv()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"tglcair" =>date("Y-m-d"),
      "payamount" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.cashbankoutid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'cashbankoutno'=>$model['cashbankoutno'],
          'reqpayid'=>$model['reqpayid'],
          'companyname'=>$model['companyname'],
          'reqpayno'=>$model['reqpayno'],

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

  public function actionUpdatecbapinv()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatacbapinv.' where cbapinvid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'accountid'=>$model['accountid'],
          'cashbankno'=>$model['cashbankno'],
          'tglcair'=>$model['tglcair'],
          'payamount'=>$model['payamount'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'bankaccountno'=>$model['bankaccountno'],
          'bankname'=>$model['bankname'],
          'bankowner'=>$model['bankowner'],
          'itemnote'=>$model['itemnote'],
          'invoiceno'=>$model['invoiceno'],
          'ekspedisino'=>$model['ekspedisino'],
          'accountname'=>$model['accountname'],
          'currencyname'=>$model['currencyname'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('docdate','string','emptydocdate'),
      array('cashbankoutno','string','emptycashbankoutno'),
      array('reqpayid','string','emptyreqpayid'),
    ));
		if ($error == false)
		{
			$id = $_POST['cashbankoutid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateCashbankout (:companyid
,:docdate
,:cashbankoutno
,:reqpayid,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':cashbankoutid',$_POST['cashbankoutid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':cashbankoutno',(($_POST['cashbankoutno']!=='')?$_POST['cashbankoutno']:null),PDO::PARAM_STR);
        $command->bindvalue(':reqpayid',(($_POST['reqpayid']!=='')?$_POST['reqpayid']:null),PDO::PARAM_STR);
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
public function actionSavecbapinv()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('accountid','string','emptyaccountid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['cbapinvid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update cbapinv 
			      set accountid = :accountid,cashbankno = :cashbankno,tglcair = :tglcair,payamount = :payamount,currencyid = :currencyid,currencyrate = :currencyrate,bankaccountno = :bankaccountno,bankname = :bankname,bankowner = :bankowner,itemnote = :itemnote 
			      where cbapinvid = :cbapinvid';
				}
				else
				{
					$sql = 'insert into cbapinv (accountid,cashbankno,tglcair,payamount,currencyid,currencyrate,bankaccountno,bankname,bankowner,itemnote) 
			      values (:accountid,:cashbankno,:tglcair,:payamount,:currencyid,:currencyrate,:bankaccountno,:bankname,:bankowner,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':cbapinvid',$_POST['cbapinvid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':cashbankno',(($_POST['cashbankno']!=='')?$_POST['cashbankno']:null),PDO::PARAM_STR);
        $command->bindvalue(':tglcair',(($_POST['tglcair']!=='')?$_POST['tglcair']:null),PDO::PARAM_STR);
        $command->bindvalue(':payamount',(($_POST['payamount']!=='')?$_POST['payamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankaccountno',(($_POST['bankaccountno']!=='')?$_POST['bankaccountno']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankname',(($_POST['bankname']!=='')?$_POST['bankname']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankowner',(($_POST['bankowner']!=='')?$_POST['bankowner']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemnote',(($_POST['itemnote']!=='')?$_POST['itemnote']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvecashbankout(:vid,:vcreatedby)';
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
				$sql = 'call Deletecashbankout(:vid,:vcreatedby)';
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
				$sql = "delete from cashbankout where cashbankoutid = ".$id[$i];
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
	}public function actionPurgecbapinv()
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
				$sql = "delete from cbapinv where cbapinvid = ".$id[$i];
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