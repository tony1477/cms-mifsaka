<?php

class MroinvoiceController extends AdminController
{
	protected $menuname = 'mroinv';
	public $module = 'mro';
	protected $pageTitle = 'mroinvoice';
	public $wfname = 'appmroinv';
	protected $sqldata = "select a0.mroinvoiceid,a0.invoicedate,a0.invoiceno,a0.mrogiheaderid,a0.amount,a0.currencyid,a0.currencyrate,a0.taxid,a0.payamount,a0.headernote,a0.recordstatus,a0.statusname,a1.mrogino as mrogino,a2.currencyname as currencyname,a3.taxcode as taxvalue,getwfstatusbywfname('appmroinv',a0.recordstatus) as statusname  
    from mroinvoice a0 
    left join mrogiheader a1 on a1.mrogiheaderid = a0.mrogiheaderid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join tax a3 on a3.taxid = a0.taxid
    WHERE a0.recordstatus <> 0
  ";
  protected $sqlcount = "select count(1) 
    from mroinvoice a0 
    left join mrogiheader a1 on a1.mrogiheaderid = a0.mrogiheaderid
    left join currency a2 on a2.currencyid = a0.currencyid
    left join tax a3 on a3.taxid = a0.taxid
  ";

    protected $sqldatamroinvdetail = "SELECT a0.mroinvoiceid, a0.amount,a0.currencyid,a0.currencyrate,a0.taxid,a0.payamount,a0.headernote,a0.recordstatus,a0.statusname,a1.mrogino as mrogino,a2.currencyname as currencyname,a3.taxcode as taxvalue,getwfstatusbywfname('appmroinv',a0.recordstatus) as statusname 
    FROM mroinvoice a0
    LEFT JOIN mrogiheader a1 on a1.mrogiheaderid = a0.mrogiheaderid 
    LEFT JOIN currency a2 on a2.currencyid = a0.currencyid
    LEFT JOIN tax a3 on a3.taxid = a0.taxid ";
    
    protected $sqlcountmroinvdetail = "SELECT COUNT(1)
    FROM mroinvoice a0
    LEFT JOIN mrogiheader a1 on a1.mrogiheaderid = a0.mrogiheaderid 
    LEFT JOIN currency a2 on a2.currencyid = a0.currencyid
    LEFT JOIN tax a3 on a3.taxid = a0.taxid ";
    
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['invoiceno'])) && (isset($_REQUEST['statusname'])))
		{				
			$where .= " AND  a0.invoiceno like '%". $_REQUEST['invoiceno']."%' ";
		}
		if (isset($_REQUEST['mroinvoiceid']))
			{
				if (($_REQUEST['mroinvoiceid'] !== '0') && ($_REQUEST['mroinvoiceid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " AND a0.mroinvoiceid in (".$_REQUEST['mroinvoiceid'].")";
					}
					else
					{
						$where .= " and a0.mroinvoiceid in (".$_REQUEST['mroinvoiceid'].")";
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
			'keyField'=>'mroinvoiceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'mroinvoiceid','invoicedate','invoiceno','mrogiheaderid','amount','currencyid','currencyrate','taxid','payamount','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'mroinvoiceid' => CSort::SORT_DESC
				),
			),
		));
        if (isset($_REQUEST['mroinvoiceid'])){
			$this->sqlcountmroinvdetail .= ' where a0.mroinvoiceid = '.$_REQUEST['mroinvoiceid'];
			$this->sqldatamroinvdetail .= ' where a0.mroinvoiceid = '.$_REQUEST['mroinvoiceid'];
		}else{
            $this->sqlcountmroinvdetail .= ' where a0.mroinvoiceid = null';
			$this->sqldatamroinvdetail .= ' where a0.mroinvoiceid = null';
        }
            
		$countmroinvdetail = Yii::app()->db->createCommand($this->sqlcountmroinvdetail)->queryScalar();
        $dataProvidermroinvdetail=new CSqlDataProvider($this->sqldatamroinvdetail,array(
					'totalItemCount'=>$countmroinvdetail,
					'keyField'=>'mroinvoiceid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'mroinvoiceid' => CSort::SORT_DESC
						),
					),
					));
        
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidermroinvdetail'=>$dataProvidermroinvdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
        $sql = "insert into mroinvoice (recordstatus) values (".$this->findstatusbyuser('insmroinv').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
			"invoicedate" =>date("Y-m-d"),
            "currencyid" => $this->GetParameter("basecurrencyid"),
            "currencyname" => $this->GetParameter("basecurrency"),
            "mroinvoiceid" =>$id,
		));
	}
    
    public function actionUpdatemrodetail(){
        parent::actionSave();
		$error = $this->ValidateData(array(
			array('mrogiheaderid','string','emptymrogiheaderid'),
            array('taxid','string','emptytaxid'),
        ));
        if ($error == false)
		{
            $connection = Yii::app()->db;
            $transaction=$connection->beginTransaction();
        
            try{
                $currencyid = $this->GetParameter("basecurrencyid");
                $sql = "CALL Updatemroinvdetail(:vid,:vmrogiheaderid,:vtaxid,:vcurrencyid,:vcreatedby)";
                $command = $connection->createCommand($sql);
                $command->bindvalue(':vid',$_POST['mroinvoiceid'],PDO::PARAM_STR);
                $command->bindvalue(':vmrogiheaderid',$_POST['mrogiheaderid'],PDO::PARAM_STR);
                $command->bindvalue(':vtaxid',$_POST['taxid'],PDO::PARAM_STR);
                $command->bindvalue(':vcurrencyid',$this->GetParameter("basecurrencyid"),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
                $command->execute();
                echo CJSON::encode(array(
						'status'=>'success',
						'mroinvoiceid'=>$_POST['mroinvoiceid'],
                ));
                $transaction->commit();
               // $this->getMessage('success','alreadysaved');
                
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
        }
    }
    
    
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' AND a0.mroinvoiceid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'mroinvoiceid'=>$model['mroinvoiceid'],
                        'invoicedate'=>$model['invoicedate'],
                        'mrogiheaderid'=>$model['mrogiheaderid'],
                        'amount'=>$model['amount'],
                        'currencyid'=>$model['currencyid'],
                        'taxid'=>$model['taxid'],
                        'payamount'=>$model['payamount'],
                        'headernote'=>$model['headernote'],
                        'recordstatus'=>$model['recordstatus'],
                        'mrogino'=>$model['mrogino'],
                        'currencyname'=>$model['currencyname'],
                        'taxvalue'=>$model['taxvalue'],

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
			array('mroinvoiceid','string','emptymroinvoiceid'),
        ));
		if ($error == false)
		{
			$id = $_POST['mroinvoiceid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
                $sql = "UPDATE mroinvoice SET invoicedate = :invdate WHERE mroinvoiceid = :mroinvoiceid";
                $command = $connection->createCommand($sql);
                $command->bindvalue(':invdate',$_POST['invoicedate'],PDO::PARAM_STR);
                $command->bindvalue(':mroinvoiceid',$id,PDO::PARAM_STR);
                $command->execute();
                $transaction->commit();
                //$this->InsertTranslog($command,$id);
                $this->getMessage('success','alreadysaved');
            }
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
    public function actionCreatemrogidetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
            "netprice" =>0
		));
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
				$sql = 'call Approvemroinv(:vid,:vcreatedby)';
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
				$sql = 'call Deletemroinv(:vid,:vcreatedby)';
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
				$sql = "delete from mroinvoice where mroinvoiceid = ".$id[$i];
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
    
    public function actionDownPDF(){
        parent::actionDownPDF();
        
        $this->pdf->title='PT. AKA';
        $this->pdf->AddPage('P',array(220,140));
        
        $this->pdf->SetFont('Arial','U');
        $this->pdf->text(100,7,'INVOICE');
        
        $sql = "select a.invoiceno, ifnull(d.sono,'-') as sono, c.gino, b.mrogino, b.shipto, c.giheaderid, b.mrogiheaderid, a.amount, b.headernote, d.soheaderid, upper(e.fullname) as customer, upper(i.addressname) as addressname,  a.invoicedate, date_add(a.invoicedate, INTERVAL h.paydays day) as duedate, b.addressbookid, upper(j.fullname) as salesname, i.cityid
                from mroinvoice a 
                left join mrogiheader b on b.mrogiheaderid = a.mrogiheaderid
                left join giheader c on c.giheaderid = b.giheaderid
                left join soheader d on d.soheaderid = c.soheaderid
                left join addressbook e on e.addressbookid = d.addressbookid
                left join address i on i.addressbookid = e.addressbookid
                left join company f on f.companyid = d.companyid
                left join city g on g.cityid = f.cityid 
                left join paymentmethod h on h.paymentmethodid = d.paymentmethodid 
                left join employee j on j.employeeid = d.employeeid ";
		if ($_GET['mroinvoiceid'] !== '') {
            $sql = $sql . "WHERE a.mroinvoiceid in (".$_GET['mroinvoiceid'].")";
		}
        $sql = $sql . " order by mroinvoiceid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
        
		foreach($dataReader as $row){
            $city = "SELECT upper(cityname) as cityname FROM city WHERE cityid='".$row['cityid']."'";
            $cityname = Yii::app()->db->createCommand($city)->queryScalar();
            
            $this->pdf->SetFont('Arial','B',12);
            $this->pdf->text(97,12,$row['invoiceno']);

            $this->pdf->SetFont('Arial','',10);
            
            $this->pdf->text(142,17,$cityname.', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
            $this->pdf->text(142,22,'KEPADA YTH,');
            $this->pdf->SetFont('Arial','B',10);
            $this->pdf->text(142,27,$row['customer']);
            $this->pdf->SetFont('Arial','',10);
            $this->pdf->text(142,32,$row['addressname']);
            //$this->pdf->text(145,37,$row['cityname']);

            $this->pdf->text(10,22,'NO.SO');$this->pdf->text(40,22,': '.$row['sono']);
            $this->pdf->text(10,27,'SALES');$this->pdf->text(40,27,': '.$row['salesname']);
            $this->pdf->text(10,32,'ALAMAT KIRIM');$this->pdf->text(40,32,': '.$row['shipto']);
            //$this->pdf->text(10,37,'KET');$this->pdf->text(30,37,': '. $row['headernote']);
            //$this->pdf->text(30,42,' Dikirim '. $row['shipto']);
            $this->pdf->setY(33);$this->pdf->setX(9);
            $this->pdf->colalign = array('L','L','L','L');
            $this->pdf->setwidths(array(30,2,100,85));
            $this->pdf->coldetailalign = array('L','L','L','L');
            $this->pdf->row(array('KET',': ',$row['headernote'],$cityname));
        }
        
       $sql1 = "select * from (select a.mrogidetailid,d.productname,sum(a.qty) as qty,c.uomcode,a.netprice,b.symbol,a.itemnote,
                (a.netprice * sum(a.qty) * ifnull(e.taxvalue,0)/100) as taxvalue
                from mrogidetail a
                join mroinvoice x on x.mrogiheaderid = a.mrogiheaderid
                inner join product d on d.productid = a.productid
                inner join currency b on b.currencyid = x.currencyid
                inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
                left join tax e on e.taxid = x.taxid
                where a.mrogiheaderid = '".$row['mrogiheaderid']."' group by d.productname,a.mrogidetailid order by a.mrogidetailid
                ) zz order by zz.mrogidetailid";
        $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

        $this->pdf->setY(46);
        $this->pdf->colalign = array('L','L','C','C','C','C');
        $this->pdf->setwidths(array(10,95,18,18,33,33));
        $this->pdf->colheader = array('NO','NAMA BARANG','QTY','SATUAN','HARGA','JUMLAH');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('L','L','C','C','R','R');
        $i=1;$total=0;
        foreach($dataReader1 as $row1){
            if($row1['taxvalue']==0 || $row1['taxvalue']==''){
                $row1['taxvalue'] = 10;
            }
            $b=$row1['symbol'];
            $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            Yii::app()->format->formatCurrency($row1['netprice'],$row1['symbol']),
            Yii::app()->format->formatCurrency(($row1['netprice'] * $row1['qty']) + $row1['taxvalue'],$row1['symbol'])));
            $total += ($row1['netprice'] * $row1['qty']) + $row1['taxvalue'];   
            $i++;
            $this->pdf->checkNewPage(20);
        }
        $this->pdf->setY($this->pdf->getY()+3);
        $this->pdf->setaligns(array('L','C','R'));
        $this->pdf->setFont('Arial','',11);
        $this->pdf->setwidths(array(150,20,40));
        $this->pdf->row(array('TERBILANG','TOTAL',Yii::app()->format->formatCurrency($total,$row1['symbol'])));
        
        $this->pdf->setFont('Arial','',10);
        $this->pdf->setY($this->pdf->getY()+3);
        $this->pdf->setaligns(array('L','L','L','L','L'));
        $this->pdf->setwidths(array(80,30,30,30,35));
        $this->pdf->coldetailalign = array('L','L','C','R','R');
        $this->pdf->row(array('# '.strtoupper($this->to_word($total + ($total*$row1['taxvalue']/100))).' RUPIAH#','Dicatat Oleh,','Hormat Kami','',''));
        $this->pdf->row(array('','','','PPN 10%',Yii::app()->format->formatCurrency($total*$row1['taxvalue']/100,$row1['symbol'])));
        $this->pdf->setFont('Arial','B',10);
        $this->pdf->row(array('','','','NETTO ',Yii::app()->format->formatCurrency($total + ($total*$row1['taxvalue']/100),$row1['symbol'])));
        $this->pdf->setFont('Arial','',9);
        $this->pdf->SetY(-10);
        $this->pdf->text(5,$this->pdf->getY(),'Catatan: Pembayaran dengan cek/ Giro dianggap lunas apabila telah disahkan');
        $this->pdf->Output();
    }
    
	public function actionDownPDF1(){
		parent::actionDownPDF();
		$sql = "select a.invoiceno, ifnull(d.sono,'-') as sono, c.gino, b.mrogino, b.shipto, c.giheaderid, b.mrogiheaderid, a.amount, b.headernote, d.soheaderid, e.fullname as customer, i.addressname, g.cityname, a.invoicedate, date_add(a.invoicedate, INTERVAL h.paydays day) as duedate
                from mroinvoice a 
                left join mrogiheader b on b.mrogiheaderid = a.mrogiheaderid
                left join giheader c on c.giheaderid = b.giheaderid
                left join soheader d on d.soheaderid = c.soheaderid
                left join addressbook e on e.addressbookid = d.addressbookid
                left join address i on i.addressbookid = e.addressbookid
                left join company f on f.companyid = d.companyid
                left join city g on g.cityid = f.cityid
                left join paymentmethod h on h.paymentmethodid = d.paymentmethodid ";
		if ($_GET['mroinvoiceid'] !== '') {
            $sql = $sql . "where a.mroinvoiceid in (".$_GET['mroinvoiceid'].")";
		}
		
        $sql = $sql . " order by mroinvoiceid";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach($dataReader as $row){}
	 	
        $this->pdf->title='Faktur Penitipan Barang';
        $this->pdf->AddPage('P',array(220,140));
        $this->pdf->AddFont('tahoma','','tahoma.php');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('tahoma');
		$sodisc = '';
		

        foreach($dataReader as $row){
            $this->pdf->setFontSize(9);
            $this->pdf->colalign = array('C','C','C','C','C','C');
            $this->pdf->setwidths(array(20,70,20,10,10,70));
            $this->pdf->row(array(
            '',
            '','','',
            '',
            $row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
            ));
            $this->pdf->row(array(
             'No',
            ' : '.$row['invoiceno'],'','',
            '',
            'Kepada Yth, ',
            ));
            $this->pdf->row(array(
            'No. SO ',
            ' : '.$row['sono'],'','',
            '',
            $row['customer'],
            ));
            $this->pdf->row(array(
            'T.O.P. ',
            ' : '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['duedate'])),'','',
            '',
            $row['addressname'],
            ));

            /*$this->pdf->text(10,$this->pdf->gety()+0,'No ');$this->pdf->text(25,$this->pdf->gety()+0,': '.$row['invoiceno']);
            $this->pdf->text(140,$this->pdf->gety()+0,$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
            $this->pdf->text(10,$this->pdf->gety()+5,'Sales ');$this->pdf->text(25,$this->pdf->gety()+5,': '.$row['sales']);
            $this->pdf->text(140,$this->pdf->gety()+5,'Kepada Yth, ');
            $this->pdf->text(10,$this->pdf->gety()+10,'No. SO ');$this->pdf->text(25,$this->pdf->gety()+10,': '.$row['sono']);
            $this->pdf->text(140,$this->pdf->gety()+10,$row['customer']);
            $this->pdf->text(10,$this->pdf->gety()+15,'T.O.P. ');$this->pdf->text(25,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['duedate'])));
            $this->pdf->text(140,$this->pdf->gety()+15,''.$row['addressname']);*/

          $sql1 = "select * from (select a.mrogidetailid,d.productname,sum(a.qty) as qty,c.uomcode,a.netprice,b.symbol,a.itemnote,
                    (a.netprice * sum(a.qty) * ifnull(e.taxvalue,0)/100) as taxvalue
                    from mrogidetail a
                    join mroinvoice x on x.mrogiheaderid = a.mrogiheaderid
                    inner join product d on d.productid = a.productid
                    inner join currency b on b.currencyid = x.currencyid
                    inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
                    left join tax e on e.taxid = x.taxid
                    where a.mrogiheaderid = '".$row['mrogiheaderid']."' group by d.productname,a.mrogidetailid order by a.mrogidetailid
                    ) zz order by zz.mrogidetailid";
          $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

          $this->pdf->SetY($this->pdf->gety()+3);
          $this->pdf->setFontSize(9);
          $this->pdf->colalign = array('L','L','C','C','C','C','L','L');
          $this->pdf->setwidths(array(10,95,20,20,25,30));
          $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Price','Total');
          $this->pdf->RowHeader();
          $this->pdf->coldetailalign = array('L','L','R','C','R','R','R','R');
          $i=0;$total = 0;$b='';
          foreach($dataReader1 as $row1){
            $i=$i+1;
            $b=$row1['symbol'];
            $this->pdf->row(array($i,$row1['productname'],
                Yii::app()->format->formatNumber($row1['qty']),
                $row1['uomcode'],
                Yii::app()->format->formatCurrency($row1['netprice'],$row1['symbol']),
                Yii::app()->format->formatCurrency(($row1['netprice'] * $row1['qty']) + $row1['taxvalue'],$row1['symbol'])));
            $total += ($row1['netprice'] * $row1['qty']) + $row1['taxvalue'];
          }
          $this->pdf->setaligns(array('L','R','L','R','C','R','R','R'));
          $this->pdf->row(array('','',
			'',
			'',
			'Nominal',
			Yii::app()->format->formatCurrency($total,$b)));
			$this->pdf->row(array('','',
			'',
			'',
			'Netto',
          Yii::app()->format->formatCurrency($row['amount'],$b)));
          $bilangan = explode(".",$row['amount']);
          $this->pdf->iscustomborder=true;
		  $this->pdf->setbordercell(array('','','','','','','',''));
					
          $this->pdf->colalign = array('C');
          $this->pdf->setwidths(array(150));
          $this->pdf->coldetailalign = array('L');
          $this->pdf->row(array('Terbilang : '.$this->eja($bilangan[0]),));
          $this->pdf->row(array('NOTE : '.$row['headernote'],));

          $this->pdf->checkNewPage(20);
          $this->pdf->text(25,$this->pdf->gety()+5,'Approved By');$this->pdf->text(170,$this->pdf->gety()+5,'Proposed By');
          $this->pdf->text(25,$this->pdf->gety()+25,'_____________ ');$this->pdf->text(170,$this->pdf->gety()+25,'_____________');
          $this->pdf->text(10,$this->pdf->gety()+30,'Catatan: Pembayaran dengan Cek/Giro dianggap lunas apabila telah dicairkan');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('mroinvoiceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('invoicedate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('invoiceno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('mrogino'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('amount'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('payamount'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['mroinvoiceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['invoicedate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['invoiceno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['mrogino'])
->setCellValueByColumnAndRow(4, $i+1, $row1['amount'])
->setCellValueByColumnAndRow(5, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(7, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(8, $i+1, $row1['payamount'])
->setCellValueByColumnAndRow(9, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(10, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(11, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}