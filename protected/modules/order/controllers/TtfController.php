<?php class TtfController extends AdminController
{
	protected $menuname = 'ttf';
	public $module = 'order';
	protected $pageTitle = 'Tanda Terima Faktur';
	public $wfname = 'appttf';
    
     
    
	protected $sqldata = "select t.*,t.docdate,t.docno as ttfdocno,c.companyname,t.employeeid,b.fullname as fullname,t.description, t.statusname, d.docno as ttntdocno,c.bankacc1,c.bankacc2,c.bankacc3
				from ttf t
				left join employee b on b.employeeid = t.employeeid
				left join company c on c.companyid = t.companyid 
                left join ttnt d on d.ttntid = t.ttntid
              
  ";
  protected $sqlcount = 'select count(1)		
                from ttf t
                left join employee b on b.employeeid = t.employeeid
                left join company c on c.companyid = t.companyid
                left join ttnt d on d.ttntid = t.ttntid' ;
    
protected $sqldatattfdetail = 'select t.*,b.invoicedate,c.gino,d.sono,e.fullname,b.invoiceno,b.amount,b.payamount,
					adddate(b.invoicedate,f.paydays) as jatuhtempo,
					datediff(current_date(),b.invoicedate) as umur, g.fullname as sales,h.ttntdetailid
				from ttfdetail t 
				 left join invoice b on b.invoiceid = t.invoiceid 
				 left join giheader c on c.giheaderid = b.giheaderid 
				 left join soheader d on d.soheaderid = c.soheaderid 
				 left join addressbook e on e.addressbookid = d.addressbookid 
				 left join paymentmethod f on f.paymentmethodid = d.paymentmethodid
				 left join employee g on g.employeeid = d.employeeid
                 left join ttntdetail h on h.ttntdetailid=t.ttntdetailid
                
				 ';
  protected $sqlcountttfdetail = 'select count(1) 
      from ttfdetail t 
      left join invoice b on b.invoiceid = t.invoiceid 
      left join giheader c on c.giheaderid = b.giheaderid 
      left join soheader d on d.soheaderid = c.soheaderid 
      left join addressbook e on e.addressbookid = d.addressbookid 
      left join paymentmethod f on f.paymentmethodid = d.paymentmethodid
     ';

  protected function getSQL()
  {
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appttf')")->queryScalar();
      //$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
      $where = " where t.recordstatus in (".getUserRecordStatus('listttf').")
								and t.recordstatus < {$maxstat}
								and t.companyid in (".getUserObjectValues('company').")";
      if ((isset($_REQUEST['docdate'])) && (isset($_REQUEST['companyname'])))
      {				
          $where .= " and t.docdate like '%". $_REQUEST['docdate']."%' 
                      and c.companyname like '%". $_REQUEST['companyname']."%'
                      and t.description like '%". $_REQUEST['description']."%'
                      "; 
      }
      if (isset($_REQUEST['ttfid']))
          {
              if (($_REQUEST['ttfid'] !== '0') && ($_REQUEST['ttfid'] !== ''))
              {
                  $where .= " and t.ttfid in (".$_REQUEST['ttfid'].")";
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
          'keyField'=>'ttfid',
          'pagination'=>array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
          ),
          'sort'=>array(
              'attributes'=>array(
           'ttfid', 'docdate','ttfdocno','fullname','description', 'companyname','recordstatus','docno'
      ),
              'defaultOrder' => array( 
                  'ttfid' => CSort::SORT_DESC
              ),
          ),
      ));
  if (isset($_REQUEST['ttfid']))
      {
          $this->sqlcountttfdetail .= ' where ttfid = '.$_REQUEST['ttfid'];
          $this->sqldatattfdetail .= ' where ttfid = '.$_REQUEST['ttfid'];
          $count = Yii::app()->db->createCommand($this->sqlcountttfdetail)->queryScalar();
          $pagination = array(
              'pageSize'=>$this->getParameter('DefaultPageSize'),
              'pageVar'=>'page',
          );
      }
      else
      {
          $count = 0;
          $pagination = false;
          $this->sqldatattfdetail .= " limit 0";
      }
      $sqlcountttfdetail = $count;
      $dataProviderttfdetail=new CSqlDataProvider($this->sqldatattfdetail,array(
          'totalItemCount'=>$sqlcountttfdetail,
          'keyField'=>'ttfdetailid',
          'pagination'=>$pagination,
          'sort'=>array(
      'attributes'=>array(
           'ttfdetailid', 'invoiceno','sono','fullname','gino','amount','payamount','sales','ttntdetailid'
      ),
              'defaultOrder' => array( 
                  'ttfid' => CSort::SORT_ASC
              ),
          ),
      ));
      $this->render('index',array('dataProvider'=>$dataProvider,'dataProviderttfdetail'=>$dataProviderttfdetail));
  }	
  public function actionGetMultiTtnt()
  {
      Yii::app()->db->createCommand(
          "
          insert into ttfdetail (ttfid,invoiceid,amount,payamount,itemnote,ttntdetailid)
          select ".$_REQUEST['ttfid'].",invoiceid,amount,payamount,itemnote,ttntdetailid
          from ttntdetail 
          where ttntdetailid  in (".$_REQUEST['ttntdetailid'].")
          "
      )->execute();
      echo CJSON::encode(array(
                  'status'=>'success'));
      Yii::app()->end();
  }
  public function actionCreate()
  {
      parent::actionCreate();
      $sql = "insert into ttf (recordstatus) values (".$this->findstatusbyuser('insttf').")";
      Yii::app()->db->createCommand($sql)->execute();
      $sql = "select last_insert_id()";
      $ttfid = Yii::app()->db->createCommand($sql)->queryScalar();
      echo CJSON::encode(array(
          'status'=>'success',
          'ttfid'=>$ttfid,
          'docdate'=>date('Y-m-d'),
          'recordstatus'=>$this->findstatusbyuser('insttf')
      ));
  }	
  public function actionCreatettfdetail()
  {
      parent::actionCreate();
      echo CJSON::encode(array(
          'status'=>'success',
      ));
  }
  public function actionGetInvoice()
  {
      $docno = '';
      $invoiceno = '';
      $amount = '';
      $payamount = '';
      $gino = '';
      $sono = '';
      $fullname = '';
      $companyname = '';
      $invoiceid = '';
      $docno1;
      if(isset($_POST['ttntdetailid']))
      {
          $prodinvoi= "select t.*,a.gino,b.sono,f.fullname,d.companyname,e.currencyname,g.currencyrate,h.docno, g.invoiceno
              from ttntdetail t
              left join ttnt h on h.ttntid = t.ttntid
              left join invoice g on g.invoiceid=t.invoiceid
              left join giheader a on a.giheaderid = g.giheaderid
              left join soheader b on b.soheaderid = a.soheaderid
              left join employee f on f.employeeid = b.employeeid 
              left join company d on d.companyid = b.companyid 
              left join addressbook c on c.addressbookid = b.addressbookid 
              left join currency e on e.currencyid = g.currencyid

              where h.recordstatus in (select b.wfbefstat
              from workflow a
              inner join wfgroup b on b.workflowid = a.workflowid
              inner join groupaccess c on c.groupaccessid = b.groupaccessid
              inner join usergroup d on d.groupaccessid = c.groupaccessid
              inner join useraccess e on e.useraccessid = d.useraccessid
              where upper(a.wfname) = upper('listinvar') and upper(e.username)=upper('".Yii::app()->user->name."') and
              b.companyid in (select gm.menuvalueid from groupmenuauth gm
              inner join menuauth ma on ma.menuauthid = gm.menuauthid
              where upper(ma.menuobject) = upper('company') and gm.groupaccessid = c.groupaccessid)) and g.invoiceno is not null 
              and t.payamount < t.amount and t.ttntdetailid = ".$_POST['ttntdetailid'];

          $docno1 = Yii::app()->db->createCommand($prodinvoi)->queryRow();
      }
          $invoiceno = $docno1['invoiceno'];
          $amount = $docno1['amount'];
          $invoiceid = $docno1['invoiceid'];
          $ttntdetailid = $docno1['ttntdetailid'];
          $payamount = $docno1['payamount'];
          $gino = $docno1['gino'];
          $sono = $docno1['sono'];
          $fullname = $docno1['fullname'];
          $companyname = $docno1['companyname'];
      echo CJSON::encode(array(
                  'status'=>'success',
                  'docno'=>$docno,
                  'invoiceno'=>$invoiceno,
                  'amount'=>$amount,
                  'ttntdetailid'=>$ttntdetailid,
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
          $model = Yii::app()->db->createCommand($this->sqldata.' where t.ttfid = '.$id)->queryRow();
          if ($model !== null)
          {
              echo CJSON::encode(array(
                  'status'=>'success',
                  'ttfid'=>$model['ttfid'],
                  'companyid'=>$model['companyid'],
                  'companyname'=>$model['companyname'],
                  'docdate'=>$model['docdate'],
                  'ttfdocno'=>$model['docno'],
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
          $model = Yii::app()->db->createCommand($this->sqldata.' where t.ttfid = '.$id)->queryRow();
          if ($model !== null)
          {
              echo CJSON::encode(array(
                  'status'=>'success',
                  'ttfid'=>$model['ttfid'],
                  'ttntid'=>$model['ttntid'],
                  'employeeid'=>$model['employeeid'],
                  'fullname'=>$model['fullname'],
                  'companyid'=>$model['companyid'],
                  'companyname'=>$model['companyname'],
                  'docdate'=>$model['docdate'],
                  'ttfdocno'=>$model['docno'],
                  'ttntdocno'=>$model['ttntdocno'],
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
  public function actionUpdatettfdetail()
  {
      parent::actionUpdate();
      if (isset($_POST['id']))
      {
          $id= $_POST['id'];
          $model = Yii::app()->db->createCommand($this->sqldatattfdetail.' where t.ttfdetailid = '.$id)->queryRow();
          if ($model !== null)
          {
              echo CJSON::encode(array(
                  'status'=>'success',
                  'ttfdetailid'=>$model['ttfdetailid'],
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

      array('description','string','emptydescription'),

  ));
      if ($error == false)
      {
          $id = $_POST['ttfid'];
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
              $sql = 'call Updatettf(:vttfid,:vttntid,:vcompanyid,:vdocdate,:vemployeeid,:vdescription,:vlastupdateby)';
              $command=$connection->createCommand($sql);
              $command->bindvalue(':vttfid',$_POST['ttfid'],PDO::PARAM_STR);
              $command->bindvalue(':vttntid',$_POST['ttntid'],PDO::PARAM_STR);				
              $command->bindvalue(':vcompanyid',$_POST['companyid'],PDO::PARAM_STR);
              $command->bindvalue(':vdocdate',$_POST['docdate'],PDO::PARAM_STR);
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
  public function actionSavettfdetail()
  {
      parent::actionSave();
      $error = $this->ValidateData(array(
          array('ttfid','string','emptyttf'),
          array('invoiceid','string','emptyinvoiceid'),
          array('amount','string','emptyamount'),
          array('payamount','string','emptypayamount'),
      ));
      if ($error == false)
      {
          //$id = $_POST['ttfdetailid'];
          if (isset($_POST['ttfdetailid']) && $_POST['ttfdetailid'] !== '')
          {
              $id = $_POST['ttfdetailid'];
               $sql = "update ttfdetail set 
                  ttfid = ".$_POST['ttfid'].",
                  invoiceid = ".$_POST['invoiceid'].",
                  amount = ".$_POST['amount'].",
                  payamount = ".$_POST['payamount'].",
                  ttntdetailid = ".$_POST['ttntdetailid']."
                  where ttfdetailid = ".$id;

          }
          else
          {
               $sql = "insert into ttfdetail (ttfid,invoiceid,amount,payamount,ttntdetailid) 
                  values (".$_POST['ttfid'].",".$_POST['invoiceid'].",".$_POST['amount'].",
                      ".$_POST['payamount'].",".$_POST['ttntdetailid'].")";
              $id = Yii::app()->db->createCommand("select last_insert_id()")->queryScalar();

          }
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
              $command = $connection->createCommand($sql);
              $command->execute();
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
              $sql = 'call Approvettf(:vid,:vcreatedby)';
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
          $id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
              $sql = 'call DeleteTTF(:vid,:vcreatedby)';
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
  /*public function actionPurge()
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
              $sql = "delete from ttf where ttfid = ".$id[$i];
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
  }*/
  public function actionPurgettfdetail()
  {
      parent::actionPurge();
      $connection=Yii::app()->db;
      $transaction=$connection->beginTransaction();
      try
      {
          $id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
          for ($i = 0; $i < count($id); $i++)
          {
              $sql = "delete from ttfdetail where ttfdetailid = ".$id[$i];
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
  public function actionUpload()
  {
      parent::actionUpload();
       function Terbilang($satuan){
$huruf = array ("", "satu", "dua", "tiga", "empat", "lima", "enam", 
"tujuh", "delapan", "sembilan", "sepuluh","sebelas");
if ($satuan < 12)
return " ".$huruf[$satuan];
elseif ($satuan < 20)
return Terbilang($satuan - 10)." belas";
elseif ($satuan < 100)
return Terbilang($satuan / 10)." puluh".
Terbilang($satuan % 10);
elseif ($satuan < 200)
return "seratus".Terbilang($satuan - 100);
elseif ($satuan < 1000)
return Terbilang($satuan / 100)." ratus".
Terbilang($satuan % 100);
elseif ($satuan < 2000)
return "seribu".Terbilang($satuan - 1000); 
elseif ($satuan < 1000000)
return Terbilang($satuan / 1000)." ribu".
Terbilang($satuan % 1000); 
elseif ($satuan < 1000000000)
return Terbilang($satuan / 1000000)." juta".
Terbilang($satuan % 1000000); 
elseif ($satuan >= 1000000000)
echo "Angka terlalu Besar";
}

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
		$a = $_REQUEST['ttfid'];
		$b = explode(',',$a);
		if (count($b) > 1)
		{
			$this->pdf->AddPage('P',array(198,70));
			$this->pdf->sety($this->pdf->gety()+20);
			$this->pdf->SetFont('Arial','B',20);
			$this->pdf->text(50,$this->pdf->gety(),'PILIH DATA HANYA 1 SAJA');
		}
		else
		{
			$sqldata = $this->sqldata." where t.ttfid = (".$_REQUEST['ttfid'].") ";
			$dataReader=Yii::app()->db->createCommand($sqldata)->queryAll();
			$count = Yii::app()->db->createCommand("select count(1) from ttfdetail where ttfid = ".$_REQUEST['ttfid'])->queryScalar();

			if($count>7)
			{
				$this->pdf->AddPage('P',array(198,280));          
			}
			else
			{
					$this->pdf->AddPage('P',array(198,140));
			}
			//var_dump($this->sqldata);
			$this->pdf->isheader=false;


			foreach($dataReader as $row)
			{
				$i=0;$total2=0;
				$this->pdf->SetFont('Arial','B',18);
				$this->pdf->text(70,$this->pdf->gety(),'Tanda Terima Faktur');
				$this->pdf->SetFont('Arial','B',9);
				$this->pdf->text(10,$this->pdf->gety()+5,''.$row['companyname']);
				$this->pdf->text(140,$this->pdf->gety()+5,'No. ');$this->pdf->text(153,$this->pdf->gety()+5,': '.$row['ttfdocno']);
				$this->pdf->text(140,$this->pdf->gety()+10,'Sales ');$this->pdf->text(153,$this->pdf->gety()+10,': '.$row['fullname']);
				$this->pdf->text(10,$this->pdf->gety()+10,'No. Ref. ');$this->pdf->text(25,$this->pdf->gety()+10,': '.$row['ttntdocno']);
				$this->pdf->text(80,$this->pdf->gety()+10,'Tanggal');$this->pdf->text(95,$this->pdf->gety()+10  ,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));


				$sql1 = "select distinct e.addressbookid,e.fullname
								from ttfdetail a
								join invoice b on b.invoiceid = a.invoiceid
								join giheader c on c.giheaderid = b.giheaderid
								join soheader d on d.soheaderid = c.soheaderid
								join paymentmethod f on f.paymentmethodid = d.paymentmethodid
								join addressbook e on e.addressbookid = d.addressbookid
								where a.ttfid = ".$row['ttfid']." order by b.invoicedate ";
				$dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

				$this->pdf->sety($this->pdf->gety()+13);
				$this->pdf->setFont('Arial','B',7);
				$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
				$this->pdf->setwidths(array(8,22,43,20,20,25,20,25));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->colheader = array('No.','No. Inv','Nama Toko','Tgl Inv.', 'Tgl. JTT','Nilai Inv.','Diskon','Stlh. Diskon');
				$this->pdf->RowHeader();
				$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R');
				$this->pdf->setFont('Arial','',8);

				foreach($dataReader1 as $row1)
				{
					$total = 0;
					$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
					$this->pdf->setwidths(array(8,22,43,20,20,25,20,25));
					$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
					$this->pdf->coldetailalign = array('L','L','C','L','C','R','R','R');
					$this->pdf->setFont('Arial','',8);

					$sql2 = "select b.invoiceno,d.sono,e.fullname,b.invoicedate,adddate(b.invoicedate,f.paydays) as jatuhtempo, a.amount,
					b.amount-ifnull((select sum((ifnull(f.cashamount,0)+ifnull(f.bankamount,0)+ifnull(f.discamount,0)+ifnull(f.returnamount,0)+ifnull(f.obamount,0))*ifnull(f.currencyrate,0))
									from cutarinv f
									join cutar g on g.cutarid=f.cutarid
									where g.recordstatus=getwfmaxstatbywfname('appcutar') and f.invoiceid=a.invoiceid and g.docdate <= h.docdate),0) as saldoinvoice
									from ttfdetail a
									join invoice b on b.invoiceid = a.invoiceid
									join giheader c on c.giheaderid = b.giheaderid
									join soheader d on d.soheaderid = c.soheaderid
									join paymentmethod f on f.paymentmethodid = d.paymentmethodid
									join addressbook e on e.addressbookid = d.addressbookid
									join ttf h on h.ttfid=a.ttfid
									where a.ttfid = ".$row['ttfid']." and e.addressbookid = ".$row1['addressbookid']." order by b.invoicedate ";
					$dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();



					foreach($dataReader2 as $row2)
					{
						$i+=1;
						$this->pdf->row(array($i,$row2['invoiceno'],
								$row2['fullname'],
								date(Yii::app()->params['dateviewfromdb'], strtotime($row2['invoicedate'])),
								date(Yii::app()->params['dateviewfromdb'], strtotime($row2['jatuhtempo'])),
								Yii::app()->format->formatNumber($row2['saldoinvoice']),
								'','',
								));
						$total += $row2['saldoinvoice'];
					}
					$this->pdf->setwidths(array(113,30,20,25,20,20));
					$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
					$this->pdf->coldetailalign = array('R','R','R','R','R','R');
					$this->pdf->setFont('Arial','B',8);
					//$this->pdf->row(array('TOTAL '.$row1['fullname'].'  >>> ',
							//Yii::app()->format->formatNumber($total)));
					$total2 += $total;
				}
				$bilangan = explode(".",$total2);
				$this->pdf->setwidths(array(113,25,20,25,20,20));
				$this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
				$this->pdf->coldetailalign = array('C','R','R','R','R','R');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->row(array('GRAND TOTAL  >>> ',
					Yii::app()->format->formatNumber($total2),
					'','',
				));

				$this->pdf->checkNewPage(15);

				$this->pdf->setFont('Arial','',8);
				$this->pdf->sety($this->pdf->gety()+5);
				$this->pdf->setFont('Arial','I',8);

				$this->pdf->text(15,$this->pdf->gety(),'Terbilang: '. $this->eja($bilangan[0]));
				$this->pdf->setFont('Arial','B',10);
				$this->pdf->text(15,$this->pdf->gety()+5,'Pembayaran Dilakukan Pada');
				$this->pdf->text(15,$this->pdf->gety()+10,'Metode Pembayaran');
				$this->pdf->setFont('Arial','',8);
				$this->pdf->text(80,$this->pdf->gety()+5,'Tanggal :');
				$this->pdf->text(80,$this->pdf->gety()+10,'Cash / Tunai');
				$this->pdf->rect(99,$this->pdf->gety()+7,4,4);

				$this->pdf->text(120,$this->pdf->gety()+10,'Transfer');
				$this->pdf->rect(134,$this->pdf->gety()+7,4,4);
				$this->pdf->text(150,$this->pdf->gety()+10,'Giro / Cek');
				$this->pdf->rect(165,$this->pdf->gety()+7,4,4);
				$this->pdf->setFont('Arial','B',9);
				$this->pdf->text(15, $this->pdf->gety()+15, 'Apabila Tansfer / Cek / Giro Ditujukan Ke:');
				$this->pdf->setFont('Arial','',9);
				if ($row['bankacc1'] !== null ){
				$this->pdf->text(25, $this->pdf->gety()+20, '~ Rekening '.$row['bankacc1']);}
/*				if ($row['bankacc2'] !== null ){
				$this->pdf->text(25, $this->pdf->gety() + 24, '~ Rekening '.$row['bankacc2']);}
				if ($row['bankacc3'] !== null ){
				$this->pdf->text(25, $this->pdf->gety() + 28, '~ Rekening '.$row['bankacc3']);}
*/
				$this->pdf->setFont('Arial','',8);
				$this->pdf->checkNewPage(40);
				$this->pdf->text(25,$this->pdf->gety()+27,'       Disiapkan oleh,');
				$this->pdf->text(88,$this->pdf->gety()+27,'     Diserahkan oleh,');
				$this->pdf->text(145,$this->pdf->gety()+27,'     Diterima oleh,');

				$this->pdf->text(25,$this->pdf->gety()+42,'     ..............................');
				$this->pdf->text(88,$this->pdf->gety()+42,' ..............................');
				$this->pdf->text(145,$this->pdf->gety()+42,'..............................');

				$this->pdf->text(35,$this->pdf->gety()+45,'Collector');
				$this->pdf->text(90,$this->pdf->gety()+45,$row['fullname']);
				$this->pdf->text(150,$this->pdf->gety()+45,'Customer');
			}
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
                  ->setCellValueByColumnAndRow(0,4,$this->getCatalog('ttfid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('ttfid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyid'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('employeeid'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('statusname'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('iscbin'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('iscutar'));
      foreach($dataReader as $row1)
      {
            $this->phpExcel->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(0, $i+1, $row1['ttfid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['ttfid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyid'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['description'])
->setCellValueByColumnAndRow(5, $i+1, $row1['employeeid'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(7, $i+1, $row1['statusname'])
->setCellValueByColumnAndRow(8, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(9, $i+1, $row1['iscbin'])
->setCellValueByColumnAndRow(10, $i+1, $row1['iscutar']);
      $i+=1;
      }
      $this->getFooterXLS($this->phpExcel);
  }
}