<?php

class InvoicearController extends AdminController
{
	protected $menuname = 'invoicear';
	public $module = 'Accounting';
	protected $pageTitle = 'Account Receivable';
	public $wfname = 'appinvar';
	protected $sqldata = "select a0.invoiceid,a0.invoicedate,a0.invoiceno,a0.giheaderid,a0.amount,a0.currencyid,a0.currencyrate,a0.payamount,a0.headernote,a0.recordstatus,a1.gino as gino,a2.currencyname as currencyname,getwfstatusbywfname('appinvar',a0.recordstatus) as statusname  
    from invoice a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
    left join currency a2 on a2.currencyid = a0.currencyid 
		left join soheader a3 on a3.soheaderid = a1.giheaderid 
  ";
  protected $sqlcount = "select count(1) 
    from invoice a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
    left join currency a2 on a2.currencyid = a0.currencyid 
		left join soheader a3 on a3.soheaderid = a1.giheaderid 
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appinvar')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listinvar').")
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['invoiceno'])) && (isset($_REQUEST['gino'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .=  " 
and a0.invoiceno like '%". $_REQUEST['invoiceno']."%' 
and a1.gino like '%". $_REQUEST['gino']."%' 
and a2.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['invoiceid']))
			{
				if (($_REQUEST['invoiceid'] !== '0') && ($_REQUEST['invoiceid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.invoiceid in (".$_REQUEST['invoiceid'].")";
					}
					else
					{
						$where .= " and a0.invoiceid in (".$_REQUEST['invoiceid'].")";
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
			'keyField'=>'invoiceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'invoiceid','invoicedate','invoiceno','giheaderid','amount','currencyid','currencyrate','payamount','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'invoiceid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"invoicedate" =>date("Y-m-d"),
      "amount" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>1,
      "payamount" =>0,
      "recordstatus" =>$this->findstatusbyuser("insinvar")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.invoiceid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'invoiceid'=>$model['invoiceid'],
          'invoicedate'=>$model['invoicedate'],
          'invoiceno'=>$model['invoiceno'],
          'giheaderid'=>$model['giheaderid'],
          'amount'=>$model['amount'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'payamount'=>$model['payamount'],
          'headernote'=>$model['headernote'],
          'recordstatus'=>$model['recordstatus'],
          'gino'=>$model['gino'],
          'currencyname'=>$model['currencyname'],

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

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('invoiceno','string','emptyinvoiceno'),
      array('giheaderid','string','emptygiheaderid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['invoiceid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update invoice 
			      set invoicedate = :invoicedate,invoiceno = :invoiceno,giheaderid = :giheaderid,amount = :amount,currencyid = :currencyid,currencyrate = :currencyrate,payamount = :payamount,headernote = :headernote,recordstatus = :recordstatus 
			      where invoiceid = :invoiceid';
				}
				else
				{
					$sql = 'insert into invoice (invoicedate,invoiceno,giheaderid,amount,currencyid,currencyrate,payamount,headernote,recordstatus) 
			      values (:invoicedate,:invoiceno,:giheaderid,:amount,:currencyid,:currencyrate,:payamount,:headernote,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':invoiceid',$_POST['invoiceid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':invoicedate',(($_POST['invoicedate']!=='')?$_POST['invoicedate']:null),PDO::PARAM_STR);
        $command->bindvalue(':invoiceno',(($_POST['invoiceno']!=='')?$_POST['invoiceno']:null),PDO::PARAM_STR);
        $command->bindvalue(':giheaderid',(($_POST['giheaderid']!=='')?$_POST['giheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':amount',(($_POST['amount']!=='')?$_POST['amount']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
        $command->bindvalue(':payamount',(($_POST['payamount']!=='')?$_POST['payamount']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveinvoicear(:vid,:vcreatedby)';
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
				$sql = 'call rejectinvoicear(:vid,:vcreatedby)';
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
				$sql = "delete from invoice where invoiceid = ".$id[$i];
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
	}
	public function actionDownPDF() {
    parent::actionDownload();
    $sql = "select a.approveby,f.companyid,a.amount,g.symbol,currencyrate,a.giheaderid,invoiceid,invoiceno,f.sono,d.fullname as customer,a.invoicedate,a.headernote, taxvalue,a.recordstatus,
	   f.shipto as addressname,j.cityname,f.isdisplay,ifnull(count(packageid),0) as pkgid,
		 a.recordstatus,
			if(a.companyid = 18,if(a.invoicedate < '2021-09-01',date_add(a.invoicedate, INTERVAL e.paydays day),if(e.paydays < 30,date_add(a.invoicedate, INTERVAL e.paydays day),if(f.materialtypeid in (1,19,20,30,4,24,25,16,27,28,17,6),date_add(a.invoicedate, INTERVAL 45 day),if(f.materialtypeid in (14,15,22,3),date_add(a.invoicedate, INTERVAL 30 day),date_add(a.invoicedate, INTERVAL 45 day))))),date_add(a.invoicedate, INTERVAL e.paydays day)) as duedate,
		--  date_add(a.invoicedate, INTERVAL e.paydays day) as duedate,
		 b.gino,f.sono,f.soheaderid,h.fullname as sales,i.bankacc1,i.bankacc2,i.bankacc3,
		 (select headernote from packages s where s.packageid = f.packageid) as packagenote,(select packagename from packages s where s.packageid = f.packageid) as packagename,ifnull(qtypackage,0) as qtypackage
		from invoice a 
		left join giheader b on b.giheaderid = a.giheaderid
		left join soheader f on f.soheaderid = b.soheaderid
		left join tax c on c.taxid = f.taxid 
		left join currency g on g.currencyid = a.currencyid
		left join addressbook d on d.addressbookid = f.addressbookid
		left join paymentmethod e on e.paymentmethodid = f.paymentmethodid
		left join employee h on h.employeeid = f.employeeid
		left join company i on i.companyid = f.companyid
		left join city j on j.cityid = i.cityid ";
    if ($_GET['id'] !== '') {
      $sql = $sql . " where a.invoiceid in (" . $_GET['id'] . ")";
    }
    $sql        = $sql . " order by invoiceid";
    $command    = $this->connection->createCommand($sql);
    $dataReader = $command->queryAll();
    foreach ($dataReader as $row) {
      $this->pdf->companyid = $row['companyid'];
    }
    $this->pdf->title = 'Faktur Penitipan Barang';
    $this->pdf->AddPage('P', array(
      220,
      140
    ));
    $this->pdf->AddFont('tahoma', '', 'tahoma.php');
    $this->pdf->AliasNbPages();
    $this->pdf->setFont('tahoma');
    $sodisc      = '';
    $sql1        = 'select ifnull(discvalue,0) as discvalue from sodisc z where z.soheaderid = ' . $row['soheaderid'];
    $command1    = $this->connection->createCommand($sql1);
    $dataReader1 = $command1->queryAll();
    foreach ($dataReader1 as $row1) {
      if ($sodisc == '') {
        $sodisc = Yii::app()->format->formatCurrency($row1['discvalue']);
      } else {
        $sodisc = $sodisc . '+' . Yii::app()->format->formatCurrency($row1['discvalue']);
      }
    }
    if ($sodisc == '') {
      $sodisc = '0';
    }
    foreach ($dataReader as $row) {
			if($row['isdisplay']==1) $this->pdf->Image('images/DISPLAY.jpg', 0, 8, 210, 135);
      $this->pdf->setFontSize(9);
      $this->pdf->colalign = array(
        'C',
        'C',
        'C',
        'C',
        'C',
        'C'
      );
      $this->pdf->setwidths(array(
        20,
        70,
        20,
        10,
        10,
        70
      ));
      $this->pdf->row(array(
        'No',
        ' : ' . $row['invoiceno'],
        '',
        '',
        '',
        $row['cityname'] . ', ' . date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate']))
      ));
      $this->pdf->row(array(
        'Sales',
        ' : ' . $row['sales'],
        '',
        '',
        '',
        'Kepada Yth, '
      ));
      $this->pdf->row(array(
        'No. SO ',
        ' : ' . $row['sono'],
        '',
        '',
        '',
        $row['customer']
      ));
      $this->pdf->row(array(
        'T.O.P. ',
        ($row['isdisplay']==1) ? ' : LANGSUNG BAYAR SAAT TERJUAL' : ' : ' .date(Yii::app()->params['dateviewfromdb'], strtotime($row['duedate'])),
        '',
        '',
        '',
        $row['addressname']
      ));
      $sql1        = "select * from (select a.sodetailid,d.productname,sum(a.qty) as qty,c.uomcode,f.price,b.symbol,a.itemnote,
	    (price * sum(a.qty) * ifnull(e.taxvalue,0)/100) as taxvalue
        from gidetail a
				inner join sodetail f on f.sodetailid = a.sodetailid
				inner join soheader g on g.soheaderid = f.soheaderid
		inner join product d on d.productid = a.productid
		inner join currency b on b.currencyid = f.currencyid
		inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
		left join tax e on e.taxid = g.taxid
        where a.giheaderid = '" . $row['giheaderid'] . "' group by d.productname,a.sodetailid order by a.sodetailid
		) zz order by zz.sodetailid";
      $command1    = $this->connection->createCommand($sql1);
      $dataReader1 = $command1->queryAll();
      $this->pdf->SetY($this->pdf->gety() + 3);
      $this->pdf->setFontSize(9);
      $this->pdf->colalign = array(
        'L',
        'L',
        'C',
        'C',
        'C',
        'C',
        'L',
        'L'
      );
      $this->pdf->setwidths(array(
        7,
        110,
        18,
        10,
        27,
        32
      ));
      $this->pdf->colheader = array(
        'No',
        'Nama Barang',
        'Qty',
        'Unit',
          ($row['pkgid']==1) ? '' : 'Price',
          ($row['pkgid']==1) ? '' : 'Total',
      );
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array(
        'L',
        'L',
        'R',
        'C',
        'R',
        'R',
        'R',
        'R'
      );
      $i                         = 0;
      $total                     = 0;
      $b                         = '';
      foreach ($dataReader1 as $row1) {
        $i = $i + 1;
        $b = $row1['symbol'];
        $this->pdf->row(array(
          $i,
          $row1['productname'],
          Yii::app()->format->formatCurrency($row1['qty']),
          $row1['uomcode'],
          ($row['pkgid']==1) ? '' : Yii::app()->format->formatCurrency($row1['price'], $row1['symbol']),
          ($row['pkgid']==1) ? '' : Yii::app()->format->formatCurrency(($row1['price'] * $row1['qty']), $row1['symbol'])
        ));
        $total += ($row1['price'] * $row1['qty']);
      }
      $this->pdf->setaligns(array(
        'L',
        'R',
        'L',
        'R',
        'C',
        'R',
        'R',
        'R'
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        ($row['pkgid']==1) ? '' : 'Nominal',
        ($row['pkgid']==1) ? '' : Yii::app()->format->formatCurrency($total, $b)
      ));
      $this->pdf->row(array(
        '',
        ($row['pkgid']==1) ? '' : 'Disc ' . $sodisc . ' (%) ',
        '',
        '',
        ($row['pkgid']==1) ? '' : 'Diskon',
        ($row['pkgid']==1) ? '' : Yii::app()->format->formatCurrency($total - $row['amount'], $b)
      ));
      $this->pdf->row(array(
        '',
        '',
        '',
        '',
        'Netto',
        Yii::app()->format->formatCurrency($row['amount'], $b)
      ));
      $bilangan                  = explode(".", $row['amount']);
      $this->pdf->iscustomborder = true;
      $this->pdf->setbordercell(array(
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        ''
      ));
      $this->pdf->colalign = array(
        'C'
      );
      $this->pdf->setwidths(array(
        150
      ));
      $this->pdf->coldetailalign = array(
        'L'
      );
      $this->pdf->row(array(
        'Terbilang : ' . eja($bilangan[0])
      ));
      $this->pdf->row(array(
        (($row['pkgid']==1) ? "NOTE : ".$row['packagename']." (QTY : ".Yii::app()->format->formatCurrency($row['qtypackage']).") \n".$row['packagenote']." \n". $row['headernote'] : "NOTE : ".$row['headernote']
      )));
/*	  $this->pdf->row(array(
        ($row['pkgid']==1) ? "NOTE : ".$row['packagename']." (QTY : ".Yii::app()->format->formatCurrency($row['qtypackage']).") \n". $row['headernote'] : 'NOTE : ' . $row['headernote']
      ));*/
	  
	  if($row['companyid']==1) {
          $x = 15;
          $i = 0;
          $y = 10;
        if($row['approveby']>0) {
            $arr = explode(',',$row['approveby']);
            
            $sqlsign1 = 'select username, realname, ifnull(signature,"") as signature from useraccess where useraccessid = '.$arr[0];
            $qsign1 = Yii::app()->db->createCommand($sqlsign1)->queryRow();

            if(!empty($arr[1])) {
              $sqlsign2 = 'select username, realname, ifnull(signature,"") as signature from useraccess where useraccessid = '.$arr[1];
              $qsign2 = Yii::app()->db->createCommand($sqlsign2)->queryRow();

             
            if ($qsign2['signature'] <> '') {
              //foreach($data as $rowx){
                  $this->pdf->Image('images/useraccess/'.$qsign2['signature'], 10, $this->pdf->gety()+5, 50,20,'PNG');
                  //$this->pdf->Image('images/'.$rowx['signature'], 15, $this->pdf->gety(), 15);
                  $this->pdf->text(25,$this->pdf->getY()+10+15,$qsign2['realname']);
                  //$i=$i+20;
                  $x=$x+50;
            }
          }
          if ($qsign1['signature'] <> '') {
            //foreach($data as $rowx){
                $this->pdf->Image('images/useraccess/'.$qsign1['signature'], 155, $this->pdf->gety()+5, 50,20,'PNG');
                //$this->pdf->Image('images/'.$rowx['signature'], 15, $this->pdf->gety(), 15);
                $this->pdf->text(170,$this->pdf->getY()+10+15,$qsign1['realname']);
                //$i=$i+20;
                $x=$x+50;
          }
        }
      }
	  
      $this->pdf->checkNewPage(20);
      $this->pdf->text(25, $this->pdf->gety() + 5, 'Approved By');
      $this->pdf->text(170, $this->pdf->gety() + 5, 'Proposed By');
      $this->pdf->text(25, $this->pdf->gety() + 25, '_____________ ');
      $this->pdf->text(170, $this->pdf->gety() + 25, '_____________');
      $this->pdf->text(10, $this->pdf->gety() + 30, 'Catatan:');
      $this->pdf->text(25, $this->pdf->gety() + 30, '- Pembayaran dengan Cek/Giro dianggap lunas apabila telah dicairkan');
      $this->pdf->text(25, $this->pdf->gety() + 35, '- Pembayaran KE REKENING SALES atau DILUAR DARI REKENING yang TELAH DITENTUKAN, maka dianggap');
      $this->pdf->text(25, $this->pdf->gety() + 40, '  TIDAK SAH / TIDAK DIAKUI sebagai PEMBAYARAN.');
      if ($row['bankacc1'] !== null ){
      $this->pdf->text(25, $this->pdf->gety() + 45, '- Transfer Bank ke:');
      $this->pdf->text(55, $this->pdf->gety() + 45, '~ Rekening '.$row['bankacc1']);}
      /*if ($row['bankacc2'] !== null ){
      $this->pdf->text(55, $this->pdf->gety() + 50, '~ Rekening '.$row['bankacc2']);}
      if ($row['bankacc3'] !== null ){
      $this->pdf->text(55, $this->pdf->gety() + 55, '~ Rekening '.$row['bankacc3']);}*/
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('invoiceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('invoicedate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('invoiceno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('amount'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('payamount'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['invoiceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['invoicedate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['invoiceno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(4, $i+1, $row1['amount'])
->setCellValueByColumnAndRow(5, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(7, $i+1, $row1['payamount'])
->setCellValueByColumnAndRow(8, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}