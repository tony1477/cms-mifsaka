<?php

class TtntController extends AdminController
{
	protected $menuname = 'ttnt';		
	public $module = 'order';
	protected $pageTitle = 'Tanda Terima Nota Tagihan';
	public $wfname = 'appttnt';
	protected $sqldata = "
			select t.*,t.docdate,t.docno,c.companyname,t.employeeid,b.fullname as fullname,t.description, t.statusname
				from ttnt t
				left join employee b on b.employeeid = t.employeeid
				left join company c on c.companyid = t.companyid ";
        
	protected $sqlcount = 'select count(1)		
                from ttnt t
                left join employee b on b.employeeid = t.employeeid
                left join company c on c.companyid = t.companyid ';
		
	protected $sqldatattntdetail = 'select t.*,b.invoicedate,c.gino,d.sono,e.fullname,b.invoiceno,b.amount,b.payamount,
					adddate(b.invoicedate,f.paydays) as jatuhtempo,
					datediff(current_date(),b.invoicedate) as umur, g.fullname as sales
				from ttntdetail t 
				 left join invoice b on b.invoiceid = t.invoiceid 
				 left join giheader c on c.giheaderid = b.giheaderid 
				 left join soheader d on d.soheaderid = c.soheaderid 
				 left join addressbook e on e.addressbookid = d.addressbookid 
				 left join paymentmethod f on f.paymentmethodid = d.paymentmethodid
				 left join employee g on g.employeeid = d.employeeid 
				 ';
	protected $sqlcountttntdetail = 'select count(1) 
		from ttntdetail t 
		left join invoice b on b.invoiceid = t.invoiceid 
		left join giheader c on c.giheaderid = b.giheaderid 
		left join soheader d on d.soheaderid = c.soheaderid 
		left join addressbook e on e.addressbookid = d.addressbookid 
		left join paymentmethod f on f.paymentmethodid = d.paymentmethodid';

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appttnt')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where t.recordstatus in (".getUserRecordStatus('listttnt').") and
						t.companyid in (".getUserObjectValues('company').") and
						t.recordstatus < {$maxstat}
				";
		if ((isset($_REQUEST['docdate'])) && (isset($_REQUEST['companyname'])))
		{				
			$where .= " and t.docdate like '%". $_REQUEST['docdate']."%' 
						and c.companyname like '%". $_REQUEST['companyname']."%'
						and b.fullname like '%". $_REQUEST['fullname']."%'
						and t.description like '%". $_REQUEST['description']."%'
						"; 
		}
		if (isset($_REQUEST['ttntid']))
			{
				if (($_REQUEST['ttntid'] !== '0') && ($_REQUEST['ttntid'] !== ''))
				{
					$where .= " and t.ttntid in (".$_REQUEST['ttntid'].")";
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
			'keyField'=>'ttntid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'ttntid', 'docdate','docno','fullname','description', 'companyname','recordstatus'
        ),
				'defaultOrder' => array( 
					'ttntid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['ttntid']))
		{
			$this->sqlcountttntdetail .= ' where ttntid = '.$_REQUEST['ttntid'];
			$this->sqldatattntdetail .= ' where ttntid = '.$_REQUEST['ttntid'];
			$count = Yii::app()->db->createCommand($this->sqlcountttntdetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatattntdetail .= " limit 0";
		}
		$sqlcountttntdetail = $count;
		$dataProviderttntdetail=new CSqlDataProvider($this->sqldatattntdetail,array(
			'totalItemCount'=>$sqlcountttntdetail,
			'keyField'=>'ttntdetailid',
			'pagination'=>$pagination,
			'sort'=>array(
        'attributes'=>array(
             'ttntdetailid', 'invoiceno','sono','fullname','gino','amount','payamount','sales','umur'
        ),
				'defaultOrder' => array( 
					'ttntid' => CSort::SORT_ASC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderttntdetail'=>$dataProviderttntdetail));
	}
	
	public function actionGetMultiInvoice()
	{
		Yii::app()->db->createCommand(
			"
			insert into ttntdetail (ttntid,invoiceid,amount,payamount,itemnote)
			select ".$_REQUEST['ttntid'].",invoiceid,amount,payamount,headernote
			from invoice 
			where invoiceid in (".$_REQUEST['invoiceid'].")
			"
		)->execute();
		echo CJSON::encode(array(
					'status'=>'success'));
		Yii::app()->end();
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into ttnt (recordstatus) values (".$this->findstatusbyuser('insttnt').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$ttntid = Yii::app()->db->createCommand($sql)->queryScalar();
		echo CJSON::encode(array(
			'status'=>'success',
			'ttntid'=>$ttntid,
			'docdate'=>date('Y-m-d'),
			'recordstatus'=>$this->findstatusbyuser('insttnt')
		));
	}
	
	public function actionCreatettntdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}

	public function actionGetInvoice()
	{
		$invoiceno = '';
		$amount = '';
		$payamount = '';
		$gino = '';
		$sono = '';
		$fullname = '';
		$companyname = '';
		$invoiceid = '';
		$invoi;
		if(isset($_POST['invoiceid']))
		{
			$prodinvoi= "select t.*,a.gino,b.sono,c.fullname,d.companyname,e.currencyname,t.currencyrate		
				from invoice t
				left join giheader a on a.giheaderid = t.giheaderid
				left join soheader b on b.soheaderid = a.soheaderid
				left join company d on d.companyid = b.companyid 
				left join addressbook c on c.addressbookid = b.addressbookid 
				left join currency e on e.currencyid = t.currencyid
				where t.recordstatus in (select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join groupaccess c on c.groupaccessid = b.groupaccessid
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where upper(a.wfname) = upper('listinvar') and upper(e.username)=upper('".Yii::app()->user->name."') and
				b.companyid in (select gm.menuvalueid from groupmenuauth gm
				inner join menuauth ma on ma.menuauthid = gm.menuauthid
				where upper(ma.menuobject) = upper('company') and gm.groupaccessid = c.groupaccessid)) and t.invoiceno is not null 
				and t.payamount < t.amount and invoiceid = ".$_POST['invoiceid'];

			$invoi = Yii::app()->db->createCommand($prodinvoi)->queryRow();
		}
			$invoiceno = $invoi['invoiceno'];
			$amount = $invoi['amount'];
			$invoiceid = $invoi['invoiceid'];
			$payamount = $invoi['payamount'];
			$gino = $invoi['gino'];
			$sono = $invoi['sono'];
			$fullname = $invoi['fullname'];
			$companyname = $invoi['companyname'];
		echo CJSON::encode(array(
					'status'=>'success',
					'invoiceno'=>$invoiceno,
					'amount'=>$amount,
					'payamount'=>$payamount,
					'sono'=>$sono,
					'invoiceid'=>$invoiceid,
					'fullname'=>$fullname,
					'companyname'=>$companyname,
					'gino'=>$gino));
		Yii::app()->end();
	}
	
	public function actionGetdata()
	{
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.ttntid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'ttntid'=>$model['ttntid'],
					'companyid'=>$model['companyid'],
					'companyname'=>$model['companyname'],
					'docdate'=>$model['docdate'],
					'docno'=>$model['docno'],
					'employeeid'=>$model['employeeid'],
					'fullname'=>$model['fullname'],
					'description'=>$model['description'],
					'recordstatus'=>$model['recordstatus'],
					));
				Yii::app()->end();
			}
		}
	}
	
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.ttntid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'ttntid'=>$model['ttntid'],
					'companyid'=>$model['companyid'],
					'companyname'=>$model['companyname'],
					'docdate'=>$model['docdate'],
					'docno'=>$model['docno'],
					'employeeid'=>$model['employeeid'],
					'fullname'=>$model['fullname'],
					'description'=>$model['description'],
					'recordstatus'=>$model['recordstatus'],
					));
				Yii::app()->end();
			}
		}
	}
	
	public function actionClose()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			echo CJSON::encode(array(
				'status'=>'success',
				));
			Yii::app()->end();
		}
	}
	
	public function actionUpdatettntdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id= $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatattntdetail.' where t.ttntdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'ttntdetailid'=>$model['ttntdetailid'],
					'invoiceid'=>$model['invoiceid'],
					'invoiceno'=>$model['invoiceno'],
					'amount'=>$model['amount'],
					'payamount'=>$model['payamount'],
					'gino'=>$model['gino'],
					'sono'=>$model['sono'],
					'fullname'=>$model['fullname'],
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
			array('companyid','string','emptycompany'),
			array('employeeid','string','emptysales'),
			array('description','string','emptydescription'),
		));
		if ($error == false)
		{
			$id = $_POST['ttntid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatettnt(:vttntid,:vcompanyid,:vdocdate,:vemployeeid,:vdescription,:vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vttntid',$_POST['ttntid'],PDO::PARAM_STR);
				$command->bindvalue(':vdocdate',$_POST['docdate'],PDO::PARAM_STR);
				$command->bindvalue(':vcompanyid',$_POST['companyid'],PDO::PARAM_STR);
				$command->bindvalue(':vemployeeid',$_POST['employeeid'],PDO::PARAM_STR);
				$command->bindvalue(':vdescription',$_POST['description'],PDO::PARAM_STR);
				$command->bindvalue(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
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

	public function actionSavettntdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('ttntid','string','emptyttnt'),
			array('invoiceid','string','emptyinvoiceid'),
			array('amount','string','emptyamount'),
			array('payamount','string','emptypayamount'),
		));
		if ($error == false)
		{
			$id = $_POST['ttntdetailid'];
			$connection  = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
              if ($id === '') {
                $sql     = 'call Insertttntdetail(:vttntid,:vinvoiceid,:vcreatedby)';
                $command = $connection->createCommand($sql);
              } else {
                $sql     = 'call Updatettntdetail(:vid,:vttntid,:vinvoiceid,:vcreatedby)';
                $command = $connection->createCommand($sql);
                $command->bindvalue(':vid', $_POST['ttntdetailid'], PDO::PARAM_STR);
                //$this->DeleteLock($this->menuname, $_POST['ttntdetailid']);
              }
              $command->bindvalue(':vttntid', $_POST['ttntid'], PDO::PARAM_STR);
              $command->bindvalue(':vinvoiceid', $_POST['invoiceid'], PDO::PARAM_STR);
              $command->bindvalue(':vcreatedby', Yii::app()->user->name, PDO::PARAM_STR);
              $command->execute();
              $transaction->commit();
	      $this->getMessage('success','alreadysaved');
            }
            catch (Exception $e) {
              $transaction->rollBack();
              $this->getMessage('error',$e->getMessage());
            }
		}
	}
	/*
	public function actionSavesodisc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('soheaderid','string','emptysoheader'),
			array('discvalue','string','emptydiscvalue'),
		));
		if ($error == false)
		{
			$id = $_POST['sodiscid'];
			if ($id !== '')
			{
				$sql = "update sodisc set 
					soheaderid = '".$_POST['soheaderid']."',
					discvalue = ".$_POST['discvalue']."	
					where sodiscid = ".$id;
			}
			else
			{
				$sql = "insert into sodisc (soheaderid,discvalue) 
					values (".$_POST['soheaderid'].",".$_POST['discvalue'].")";
			}
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$connection->createCommand($sql)->execute();
				$this->InsertTranslog($command,$id);
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}*/
	
	public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call ApproveTTNT(:vid,:vcreatedby)';
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
	
	public function actionReject()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call DeleteTTNT(:vid,:vcreatedby)';
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
/*	
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$id = $_POST['id'];
			$sql = "delete from sodisc where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = "delete from sodetail where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$sql = "delete from soheader where soheaderid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}*/
	
	public function actionPurgettntdetail()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			for ($i = 0; $i < count($ids);$i++)
			{
				$sql = "delete from ttntdetail where ttntdetailid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
			}
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
/*	
	public function actionPurgesodisc()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$id = $_POST['id'];
			$sql = "delete from sodisc where sodiscid = ".((is_array($id))?$id[0]:$id);
			Yii::app()->db->createCommand($sql)->execute();
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CDbException $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}*/
	
	public function actionUpload()
	{
		parent::actionUpload();
		if (($handle = fopen($storeFolder.$_FILES['upload']['name'], "r")) !== FALSE) 
		{
			$s = $this->getParameter('csvformat');
			$row=1;
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				while (($data = fgetcsv($handle, 2000, $s )) !== FALSE) 
				{
					if ($row>1)
					{
						$sql = "replace into soheader (soheaderid,fullname,recordstatus) 
							values (".$data[0].",'".$data[1]."',".$data[2].")";
						$connection->createCommand($sql)->execute();
					}
					$row++;
				}					
				$transaction->commit();
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->GetMessage('error',$e->getMessage());
			}
		}
	}
	
	public function actionDownPDF()
	{
	  parent::actionDownPDF();
		//masukkan perintah download
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		//		var_dump($this->sqldata);
	  $this->pdf->isheader=false;
	  $this->pdf->AddPage('L','Letter');
		

		foreach($dataReader as $row)
    {
			$i=0;$total2=0;
			$this->pdf->SetFont('Arial','B',12);
			$this->pdf->text(10,$this->pdf->gety()+0,'Tanda Terima Nota Tagihan');
			$this->pdf->SetFont('Arial','B',9);
      $this->pdf->text(10,$this->pdf->gety()+5,'TTNT No. ');$this->pdf->text(30,$this->pdf->gety()+5,': '.$row['docno']);
      $this->pdf->text(10,$this->pdf->gety()+10,'TTNT Date ');$this->pdf->text(30,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
      $this->pdf->text(10,$this->pdf->gety()+15,'Sales ');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['fullname']);

			$sql1 = "select distinct e.addressbookid,e.fullname
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					where a.ttntid = ".$row['ttntid']." order by fullname ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
			
			$this->pdf->sety($this->pdf->gety()+20);
			$this->pdf->setFont('Arial','B',7);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(8,40,17,22,17,25,20,20,20,20,20,20,20));
			$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->colheader = array('No.','Customer','Tgl. Inv.','No. Inv.', 'Tgl. JTT','Nilai Inv.',
				'Tunai','Bank','Diskon','Retur','Over Booking','Sisa','Ket.');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R','R','R','R','R','R');
			$this->pdf->setFont('Arial','',8);
			
			foreach($dataReader1 as $row1)
			{	
				$total = 0;
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(8,40,17,22,17,25,20,20,20,20,20,20,20));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R','R','R','R','R','R');
				$this->pdf->setFont('Arial','',8);
				
				$sql2 = "select b.invoiceno,d.sono,e.fullname,b.invoicedate,adddate(b.invoicedate,f.paydays) as jatuhtempo, a.amount,
					b.amount-ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
					from cutarinv f
					join cutar g on g.cutarid=f.cutarid
					where g.recordstatus=getwfmaxstatbywfname('appcutar') and f.invoiceid=a.invoiceid and g.docdate < h.docdate),0) as saldoinvoice
					from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
					join ttnt h on h.ttntid=a.ttntid
					where a.ttntid = ".$row['ttntid']." and e.addressbookid = ".$row1['addressbookid']." order by fullname ";
			$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();

				
				
				foreach($dataReader2 as $row2)
				{
					$i+=1;
					$this->pdf->row(array($i,$row2['fullname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
						$row2['invoiceno'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo'])),
						Yii::app()->format->formatNumber($row2['saldoinvoice']),
						'','','','','','','',
						));
					$total += $row2['saldoinvoice'];
				}
				$this->pdf->setwidths(array(104,25,20,20,20,20,20,20,20));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->coldetailalign = array('R','R','R','R','R','R','R','R','R');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array('TOTAL '.$row1['fullname'].'  >>> ',
					Yii::app()->format->formatNumber($total),
					'','','','','','',''));
				$total2 += $total;
			}
			
			$this->pdf->setwidths(array(104,25,20,20,20,20,20,20,20));
			$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->coldetailalign = array('C','R','R','R','R','R','R','R','R');
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->row(array('GRAND TOTAL  >>> ',
				Yii::app()->format->formatNumber($total2),
				'','','','','','',''));

			$this->pdf->checkNewPage(15);
								 
			$this->pdf->setFont('Arial','',8);
			$this->pdf->sety($this->pdf->gety()+5);
			$this->pdf->text(35,$this->pdf->gety(),'        PENYERAHAN INVOICE');
			$this->pdf->text(125,$this->pdf->gety(),'FISIK UANG TUNAI');
			$this->pdf->text(200,$this->pdf->gety(),'    PENGEMBALIAN INVOICE');
			
			$this->pdf->text(15,$this->pdf->gety()+4,'       Diserahkan oleh,');
			$this->pdf->text(70,$this->pdf->gety()+4,'     Diterima oleh,');
			$this->pdf->text(125,$this->pdf->gety()+4,'     Diterima oleh,');
			$this->pdf->text(180,$this->pdf->gety()+4,' Diserahkan oleh,');
			$this->pdf->text(235,$this->pdf->gety()+4,'    Diterima oleh,');
			
			$this->pdf->text(15,$this->pdf->gety()+25,'     ..............................');
			$this->pdf->text(70,$this->pdf->gety()+25,' ..............................');
			$this->pdf->text(125,$this->pdf->gety()+25,'..............................');
			$this->pdf->text(180,$this->pdf->gety()+25,'..............................');
			$this->pdf->text(235,$this->pdf->gety()+25,'..............................');
			
			$this->pdf->text(24,$this->pdf->gety()+28,'Admin AR');
			$this->pdf->text(78,$this->pdf->gety()+28,'Sales');
			$this->pdf->text(129,$this->pdf->gety()+28,'Admin Kasir');
			$this->pdf->text(188,$this->pdf->gety()+28,'Sales');
			$this->pdf->text(240,$this->pdf->gety()+28,'Admin AR');
		}
	  $this->pdf->Output();
	  
	}
	
	/*public function actionDownPDF()
	{
		parent::actionDownPDF();
		//masukkan perintah download
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
//		var_dump($this->sqldata);

		$this->pdf->isheader=false;
		$this->pdf->AddPage('L','Legal');
		foreach($dataReader as $row)
    	{
			$this->pdf->SetFont('Arial','B',12);
			$this->pdf->text(5,$this->pdf->gety()+5,'Tanda Terima Nota Tagihan');
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->text(5,$this->pdf->gety()+10,'TTNT No ');$this->pdf->text(30,$this->pdf->gety()+10,$row['docno']);
			$this->pdf->text(5,$this->pdf->gety()+15,'TTNT Date ');$this->pdf->text(30,$this->pdf->gety()+15,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
			$this->pdf->text(5,$this->pdf->gety()+20,'Sales ');$this->pdf->text(30,$this->pdf->gety()+20,$row['fullname']);

			$sql1 = "select b.invoiceno,d.sono,e.fullname,b.invoicedate,adddate(b.invoicedate,f.paydays) as jatuhtempo, b.amount,b.payamount,b.amount-b.payamount as saldoinvoice
			from ttntdetail a
					join invoice b on b.invoiceid = a.invoiceid
					join giheader c on c.giheaderid = b.giheaderid
					join soheader d on d.soheaderid = c.soheaderid
					join paymentmethod f on f.paymentmethodid = d.paymentmethodid
					join addressbook e on e.addressbookid = d.addressbookid
			where a.ttntid = ".$row['ttntid']." order by e.addressbookid ";
			$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$total = 0;$totalqty=0;
			$this->pdf->sety($this->pdf->gety()+25);
			$this->pdf->setFont('Arial','B',7);
				$this->pdf->setx(5);
			$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
			$this->pdf->setwidths(array(35,20,20,20,25,20,20,20,20,20,20,20,20,20,20,20));
			$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
			$this->pdf->colheader = array('Customer','Tanggal Invoice','No Invoice', 'Tgl Jatuh Tempo','Nilai Invoice',
					'TUNAI','BANK','NILAI GIRO','NM BANK','NO GIRO','TGL JTT','Disc Jual','Retur Jual','Sisa Invoice','Ket');
			$this->pdf->RowHeader();
			$this->pdf->coldetailalign = array('L','C','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
			$this->pdf->setFont('Arial','',7);
			foreach($dataReader1 as $row1)
			{
					$this->pdf->setx(5);
			$this->pdf->row(array($row1['fullname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['invoicedate'])),
						$row1['invoiceno'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['jatuhtempo'])),
						Yii::app()->format->formatNumber($row1['saldoinvoice']),
						'','','','','','','','','',''
						));
			$total = $row1['saldoinvoice'] + $total;
			}
			$this->pdf->setx(5);
			$this->pdf->row(array('','','Total','',
        	Yii::app()->format->formatNumber($total),
				'','','','','','','','','',''));	  
		}
		// me-render ke browser
		$this->pdf->Output();
		
	}*/
	
}