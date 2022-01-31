<?php

class ReqpayController extends AdminController
{
	protected $menuname = 'reqpay';
	public $module = 'Accounting';
	protected $pageTitle = 'Permohonan Pembayaran';
	public $wfname = 'apppayreq';
	protected $sqldata = "select a0.reqpayid,a0.companyid,a0.docdate,a0.reqpayno,a0.headernote,a0.recordstatus,a1.companyname as companyname,getwfstatusbywfname('apppayreq',a0.recordstatus) as statusname  
    from reqpay a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqldatareqpayinv = "select a0.reqpayinvid,a0.reqpayid,a0.invoiceapid,a0.ekspedisiid,a0.amount,a0.payamount,a0.taxid,a0.taxno,a0.taxdate,a0.currencyid,a0.currencyrate,a0.bankaccountno,a0.bankname,a0.bankowner,a0.itemnote,a1.invoiceno as invoiceno,a2.amount as amount,a3.taxcode as taxcode,a4.currencyname as currencyname 
    from reqpayinv a0 
    left join invoiceap a1 on a1.invoiceapid = a0.invoiceapid
    left join invoiceap a2 on a2.invoiceapid = a0.amount
    left join tax a3 on a3.taxid = a0.taxid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from reqpay a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
protected $sqlcountreqpayinv = "select count(1) 
    from reqpayinv a0 
    left join invoiceap a1 on a1.invoiceapid = a0.invoiceapid
    left join invoiceap a2 on a2.invoiceapid = a0.amount
    left join tax a3 on a3.taxid = a0.taxid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listpayreq').")  
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['reqpayno'])) && (isset($_REQUEST['companyname'])))
		{				
			$where .=  " 
and a0.reqpayno like '%". $_REQUEST['reqpayno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
		if (isset($_REQUEST['reqpayid']))
			{
				if (($_REQUEST['reqpayid'] !== '0') && ($_REQUEST['reqpayid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.reqpayid in (".$_REQUEST['reqpayid'].")";
					}
					else
					{
						$where .= " and a0.reqpayid in (".$_REQUEST['reqpayid'].")";
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
			'keyField'=>'reqpayid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'reqpayid','companyid','docdate','reqpayno','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'reqpayid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['reqpayid']))
		{
			$this->sqlcountreqpayinv .= ' where a0.reqpayid = '.$_REQUEST['reqpayid'];
			$this->sqldatareqpayinv .= ' where a0.reqpayid = '.$_REQUEST['reqpayid'];
		}
		$countreqpayinv = Yii::app()->db->createCommand($this->sqlcountreqpayinv)->queryScalar();
$dataProviderreqpayinv=new CSqlDataProvider($this->sqldatareqpayinv,array(
					'totalItemCount'=>$countreqpayinv,
					'keyField'=>'reqpayinvid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'reqpayinvid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderreqpayinv'=>$dataProviderreqpayinv));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into reqpay (recordstatus) values (".$this->findstatusbyuser('inspayreq').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'reqpayid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inspayreq")
		));
	}
  public function actionCreatereqpayinv()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"amount" =>0,
      "payamount" =>0,
      "taxdate" =>date("Y-m-d"),
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.reqpayid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'headernote'=>$model['headernote'],
          'companyname'=>$model['companyname'],

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

  public function actionUpdatereqpayinv()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatareqpayinv.' where reqpayinvid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'invoiceapid'=>$model['invoiceapid'],
          'taxid'=>$model['taxid'],
          'taxno'=>$model['taxno'],
          'taxdate'=>$model['taxdate'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'bankaccountno'=>$model['bankaccountno'],
          'bankname'=>$model['bankname'],
          'bankowner'=>$model['bankowner'],
          'itemnote'=>$model['itemnote'],
          'invoiceno'=>$model['invoiceno'],
          'amount'=>$model['amount'],
          'taxcode'=>$model['taxcode'],
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
    ));
		if ($error == false)
		{
			$id = $_POST['reqpayid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateReqpay (:companyid
,:docdate
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':reqpayid',$_POST['reqpayid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
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
public function actionSavereqpayinv()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('invoiceapid','string','emptyinvoiceapid'),
      array('taxno','string','emptytaxno'),
    ));
		if ($error == false)
		{
			$id = $_POST['reqpayinvid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update reqpayinv 
			      set invoiceapid = :invoiceapid,taxid = :taxid,taxno = :taxno,taxdate = :taxdate,currencyid = :currencyid,currencyrate = :currencyrate,bankaccountno = :bankaccountno,bankname = :bankname,bankowner = :bankowner,itemnote = :itemnote 
			      where reqpayinvid = :reqpayinvid';
				}
				else
				{
					$sql = 'insert into reqpayinv (invoiceapid,taxid,taxno,taxdate,currencyid,currencyrate,bankaccountno,bankname,bankowner,itemnote) 
			      values (:invoiceapid,:taxid,:taxno,:taxdate,:currencyid,:currencyrate,:bankaccountno,:bankname,:bankowner,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':reqpayinvid',$_POST['reqpayinvid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':invoiceapid',(($_POST['invoiceapid']!=='')?$_POST['invoiceapid']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxid',(($_POST['taxid']!=='')?$_POST['taxid']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxdate',(($_POST['taxdate']!=='')?$_POST['taxdate']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvereqpay(:vid,:vcreatedby)';
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
				$sql = 'call Deletereqpay(:vid,:vcreatedby)';
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
				$sql = "delete from reqpay where reqpayid = ".$id[$i];
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
	}public function actionPurgereqpayinv()
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
				$sql = "delete from reqpayinv where reqpayinvid = ".$id[$i];
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
		$sql = "select distinct a.reqpayid,a.docdate,d.fullname as supplier,b.bankname,d.bankaccountno,a.companyid,d.accountowner,a.reqpayno,
	  (select sum(za.amount)
				from invoiceap za
				join reqpayinv zb on zb.invoiceapid = za.invoiceapid
				where zb.reqpayid = a.reqpayid) as nilai,a.headernote
				from reqpay a 
				join reqpayinv b on b.reqpayid = a.reqpayid
				join invoiceap c on c.invoiceapid = b.invoiceapid
				join addressbook d on d.addressbookid = c.addressbookid ";
		if ($_GET['reqpayid'] !== '') {
				$sql = $sql . "where a.reqpayid in (".$_GET['reqpayid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('reqpay');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font  

    foreach($dataReader as $row)
    {
	$this->pdf->SetFontSize(8);
	$this->pdf->text(10,$this->pdf->gety()+2,'No. Dokumen ');$this->pdf->text(40,$this->pdf->gety()+2,': '.$row['reqpayno']);
	$this->pdf->text(10,$this->pdf->gety()+6,'Dibayarkan kepada ');$this->pdf->text(40,$this->pdf->gety()+6,': '.$row['supplier']);
     $this->pdf->text(10,$this->pdf->gety()+10,'Sejumlah Rp. ');$this->pdf->text(40,$this->pdf->gety()+10,': '.Yii::app()->format->formatCurrency($row['nilai']));
	 $this->pdf->text(120,$this->pdf->gety()+6,'Bank ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['bankname']);
	 $this->pdf->text(120,$this->pdf->gety()+10,'A/N ');$this->pdf->text(140,$this->pdf->gety()+10,': '.$row['accountowner']);
	 $this->pdf->SetFontSize(9);
	$this->pdf->text(120,$this->pdf->gety()+14,'No Rekening');$this->pdf->text(140,$this->pdf->gety()+14,': '.$row['bankaccountno']);
    $this->pdf->SetFontSize(8);
		$this->pdf->text(120,$this->pdf->gety()+2,'Tgl Dokumen ');$this->pdf->text(140,$this->pdf->gety()+2,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
	$this->pdf->text(10,$this->pdf->gety()+18,'Terbilang ');$this->pdf->text(40,$this->pdf->gety()+18,': ');
	$this->pdf->sety($this->pdf->gety()+15);
	$this->pdf->setaligns(array('C','L'));
	$this->pdf->setwidths(array(31,160));
	$this->pdf->row(array('',strtoupper($this->eja($row['nilai']))));
	 
	  $sql1 = "select b.invoiceno,d.fullname as supplier,b.invoicedate,adddate(b.invoicedate,e.paydays) as duedate,b.amount,a.taxno,a.itemnote
        from reqpayinv a
        left join invoiceap b on b.invoiceapid = a.invoiceapid
        left join poheader c on c.poheaderid = b.poheaderid 
				left join addressbook d on d.addressbookid = c.addressbookid
				left join paymentmethod e on e.paymentmethodid = c.paymentmethodid
        where reqpayid = ".$row['reqpayid'];
		
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

	  $this->pdf->sety($this->pdf->gety()+2);
      
       $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,25,25,25,25,25,60));
	  $this->pdf->colheader = array('No','No Invoice','Tgl Invoice','Nilai','Jth Tempo','No Faktur pajak','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('C','C','C','R','C','C','L');
      $i=0;
	  $total=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['invoiceno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
		Yii::app()->format->formatCurrency($row1['amount']),		
		date(Yii::app()->params['dateviewfromdb'], strtotime($row1['duedate'])),		
		$row1['taxno'],
		$row1['itemnote']));
		
			$total += $row1['amount'];
      }
		$this->pdf->SetFontSize(10);
		$this->pdf->setaligns(array('C','C','C','C','C','L','R'));
		$this->pdf->setwidths(array(10,25,25,25,25,25,35));
        $this->pdf->row(array('',
			'',
			'','','','TOTAL :',Yii::app()->format->formatCurrency($total)
			));
		$this->pdf->SetFontSize(8);
		$this->pdf->text(10,$this->pdf->gety()+5,'Keterangan ');$this->pdf->text(25,$this->pdf->gety()+5,': ');
		$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['headernote']);
$this->pdf->checkNewPage(60);      
//      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->SetFontSize(8);
			$this->pdf->text(10,$this->pdf->gety(),'Diajukan oleh');$this->pdf->text(45,$this->pdf->gety(),'Diperiksa oleh');$this->pdf->text(85,$this->pdf->gety(),'Diketahui oleh');$this->pdf->text(125,$this->pdf->gety(),'Disetujui oleh');$this->pdf->text(165,$this->pdf->gety(),'Dibayar oleh');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(45,$this->pdf->gety()+15,'........................');$this->pdf->text(85,$this->pdf->gety()+15,'........................');$this->pdf->text(125,$this->pdf->gety()+15,'........................');$this->pdf->text(165,$this->pdf->gety()+15,'........................');
			$this->pdf->text(10,$this->pdf->gety()+20,'Adm H/D');$this->pdf->text(42,$this->pdf->gety()+20,'Divisi Acc & Finance');$this->pdf->text(85,$this->pdf->gety()+20,'Branch Manager');$this->pdf->text(125,$this->pdf->gety()+20,'Dir. Keuangan');$this->pdf->text(165,$this->pdf->gety()+20,'Bag. Bank pusat');
			$this->pdf->text(10,$this->pdf->gety()+25,'Tgl :');$this->pdf->text(42,$this->pdf->gety()+25,'Tgl :');$this->pdf->text(85,$this->pdf->gety()+25,'Tgl :');$this->pdf->text(125,$this->pdf->gety()+25,'Tgl :');$this->pdf->text(165,$this->pdf->gety()+25,'Tgl :');
			 $this->pdf->setFontSize(7);
			 $this->pdf->text(10,$this->pdf->gety()+33,'NB :Faktur pajak wajib diisi jika pembayaran melalui Legal (Tanpa melampirkan faktur pajak lagi)');
			 $this->pdf->text(10,$this->pdf->gety()+38,'     :Dibuat rangkap 3, putih untuk Bag.Bank/Kasir, setelah dibayar diserahkan ke Adm H/D,Rangkap 2 utk Bag.Pajak,rangkap 3 Arsip H/D');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('reqpayid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('reqpayno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['reqpayid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['reqpayno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}