<?php

class PaymentTargetController extends AdminController
{
	protected $menuname = 'paymenttarget';
	public $module = 'Accounting';
	protected $pageTitle = 'Target Tagihan';
	public $wfname = 'apppt';
	protected $sqldata = "select a0.paymenttargetid,a0.companyid,a0.employeeid,a0.docdate,a0.perioddate,a0.recordstatus,a0.statusname,a1.companyname as companyname,a2.fullname as fullname,a0.docno
    from paymenttarget a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
protected $sqldatapaymenttargetdet = "select a0.paymenttargetdetid,a0.paymenttargetid,a0.addressbookid,a0.gt30,a0.gt15,a0.gt7,a0.gt0,a0.x0,a0.lt0,a0.lt14,a1.fullname as customername, a0.custcategoryid, a2.custcategoryname
    from paymenttargetdet a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join custcategory a2 on a2.custcategoryid = a0.custcategoryid
  ";
  protected $sqlcount = "select count(1) 
    from paymenttarget a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
protected $sqlcountpaymenttargetdet = "select count(1) 
    from paymenttargetdet a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
    left join custcategory a2 on a2.custcategoryid = a0.custcategoryid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('apppt')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
			$where = " where a0.recordstatus in (".getUserRecordStatus('listpt').")
								and a0.recordstatus < {$maxstat}
                and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['fullname'])))
		{				
			$where .= " and a2.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
        if ((isset($_REQUEST['companyname'])))
		{				
			$where .= " and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
		if (isset($_REQUEST['paymenttargetid']))
			{
				if (($_REQUEST['paymenttargetid'] !== '0') && ($_REQUEST['paymenttargetid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.paymenttargetid in (".$_REQUEST['paymenttargetid'].")";
					}
					else
					{
						$where .= " and a0.paymenttargetid in (".$_REQUEST['paymenttargetid'].")";
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
			'keyField'=>'paymenttargetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'paymenttargetid','companyid','employeeid','docdate','perioddate','recordstatus','statusname','custcategoryid','docno'
				),
				'defaultOrder' => array( 
					'paymenttargetid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['paymenttargetid']))
		{
			$this->sqlcountpaymenttargetdet .= ' where a0.paymenttargetid = '.$_REQUEST['paymenttargetid'];
			$this->sqldatapaymenttargetdet .= ' where a0.paymenttargetid = '.$_REQUEST['paymenttargetid'];
		}
		$countpaymenttargetdet = Yii::app()->db->createCommand($this->sqlcountpaymenttargetdet)->queryScalar();
$dataProviderpaymenttargetdet=new CSqlDataProvider($this->sqldatapaymenttargetdet,array(
					'totalItemCount'=>$countpaymenttargetdet,
					'keyField'=>'paymenttargetdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'paymenttargetdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderpaymenttargetdet'=>$dataProviderpaymenttargetdet));
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into paymenttarget (recordstatus) values (".$this->findstatusbyuser('inspt').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'paymenttargetid'=>$id,
			"docdate" =>date("Y-m-d"),
            "recordstatus" =>$this->findstatusbyuser("inspt")
		));
	}
  public function actionCreatepaymenttargetdet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"gt30" =>0,
            "gt15" =>0,
            "gt7" =>0,
            "gt0" =>0,
            "x0" =>0,
            "lt0" =>0,
            "lt14" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.paymenttargetid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'paymenttargetid'=>$model['paymenttargetid'],
                        'companyid'=>$model['companyid'],
                        'employeeid'=>$model['employeeid'],
                        'docdate'=>$model['docdate'],
                        'perioddate'=>$model['perioddate'],
                        'companyname'=>$model['companyname'],
                        'fullname'=>$model['fullname'],

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
	public function actionUpdatepaymenttargetdet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapaymenttargetdet.' where paymenttargetdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'paymenttargetdetid'=>$model['paymenttargetdetid'],
                    'paymenttargetid'=>$model['paymenttargetid'],
                    'custcategoryid'=>$model['custcategoryid'],
                    'custcategoryname'=>$model['custcategoryname'],
                    'addressbookid'=>$model['addressbookid'],
                    'gt30'=>$model['gt30'],
                    'gt15'=>$model['gt15'],
                    'gt7'=>$model['gt7'],
                    'gt0'=>$model['gt0'],
                    'x0'=>$model['x0'],
                    'lt0'=>$model['lt0'],
                    'lt14'=>$model['lt14'],
                    'customername'=>$model['customername'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['paymenttargetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatepaymenttarget (:paymenttargetid
,:companyid
,:employeeid
,:docdate
,:perioddate,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':paymenttargetid',$_POST['paymenttargetid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':perioddate',(($_POST['perioddate']!=='')?$_POST['perioddate']:null),PDO::PARAM_STR);
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
	public function actionSavepaymenttargetdet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('paymenttargetid','string','emptypaymenttargetid'),
			array('custcategoryid','string','emptycustcategoryid'),
			array('addressbookid','string','emptyaddressbookid'),
    ));
		if ($error == false)
		{
			$id = $_POST['paymenttargetdetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatepaymenttargetdetail(:vid,:vpaymenttargetid,:vcustcategoryid,:vaddressbookid,:vgt30,:vgt15,:vgt7,:vgt0,:vx0,:vlt0,:vlt14,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertpaymenttargetdetail(:vpaymenttargetid,:vcustcategoryid,:vaddressbookid,:vgt30,:vgt15,:vgt7,:vgt0,:vx0,:vlt0,:vlt14,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['paymenttargetdetid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':vpaymenttargetid',(($_POST['paymenttargetid']!=='')?$_POST['paymenttargetid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaddressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt30',(($_POST['gt30']!=='')?$_POST['gt30']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt15',(($_POST['gt15']!=='')?$_POST['gt15']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt7',(($_POST['gt7']!=='')?$_POST['gt7']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt0',(($_POST['gt0']!=='')?$_POST['gt0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vx0',(($_POST['x0']!=='')?$_POST['x0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlt0',(($_POST['lt0']!=='')?$_POST['lt0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlt14',(($_POST['lt14']!=='')?$_POST['lt14']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvepaymenttarget(:vid,:vcreatedby)';
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
				$sql = 'call Deletepaymenttarget(:vid,:vcreatedby)';
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
				$sql = "delete from paymenttarget where paymenttargetid = ".$id[$i];
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
	public function actionPurgepaymenttargetdet()
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
				$sql = "delete from paymenttargetdet where paymenttargetdetid = ".$id[$i];
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
	public function actionDownPDF1()
	{
		parent::actionDownPDF();
		//$this->getSQL();
		//$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
        
		$sql = "select a.docdate,a.perioddate, d.fullname, a.employeeid, a.companyid, a.paymenttargetid
						from paymenttarget a
						join employee d on d.employeeid = a.employeeid ";
        
        if ($_GET['paymenttarget_0_paymenttargetid'] !== '') 
		{
				$sql = $sql . "where a.paymenttargetid in (".$_GET['paymenttarget_0_paymenttargetid'].")";
		}
						
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        
        foreach($result as $row)
        {
            $totalgt30 = 0;
            $totalgt15 = 0;
            $totalgt7 = 0;
            $totalgt0 = 0;
            $totalx0 = 0;
            $totallt0 = 0;
            $totallt14 = 0;
            $totaljumlah = 0;
		
            $datetime = new DateTime($row['perioddate']);
            //masukkan judul
            $this->pdf->title=$this->getCatalog('paymenttarget');
            $this->pdf->AddPage('L','A4');

            $this->pdf->setFont('Arial','B',11);
            $this->pdf->text(10,15,'Tanggal ');
            $this->pdf->text(10,20,'Nama Sales ');
            $this->pdf->text(10,25,'Periode ');
            //$this->pdf->text(10,25,'Total Target ');
            $this->pdf->text(45,15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
            $this->pdf->text(45,20,': '.$row['fullname']);
            $this->pdf->text(45,25,': '.$datetime->format('F').' '.$datetime->format('Y'));
            //$this->pdf->text(45,25,': 999999999999');

            $month = date('m',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));

            $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -3 month');
            $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -1 month');

            $lastmonth1 = date('Y-m-d', $prev_month_ts1);
            $lastmonth2 = date('Y-m-t', $prev_month_ts2);

            $sql1 = "select b.addressbookid, c.fullname as custname, gt30,gt15,gt7,gt0,x0,lt0,lt14,gt30+gt15+gt7+gt0+x0+lt0+lt14 as jumlah,b.paymenttargetid
                             from paymenttargetdet b
                             join addressbook c on c.addressbookid = b.addressbookid ";
            $sql1 = $sql1 . " where b.paymenttargetid = ".$row['paymenttargetid']." group by b.addressbookid ";
            $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();

            $this->pdf->setFont('Arial','',10);
            $this->pdf->setY($this->pdf->getY()+13);
            $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
            $this->pdf->colheader = array($this->getCatalog('NO'),$this->getCatalog('customer'),$this->getCatalog('gt30'),$this->getCatalog('gt15'),$this->getCatalog('gt7'),$this->getCatalog('gt0'),$this->getCatalog('x0'),$this->getCatalog('lt0'),$this->getCatalog('lt14'),$this->getCatalog('Jumlah'));
            $this->pdf->setwidths(array(10,40,29,30,29,29,29,29,29,29));
            $this->pdf->Rowheader();        

            $i=1;
            
            foreach($dataReader1 as $row1)
            {
                //masukkan baris untuk cetak
                $totalqty = 0;
                $totalharga = 0;

                
                //$this->pdf->text(20,$this->pdf->getY()+10,'Group Material :');
                $this->pdf->coldetailalign = array('C','L','R','R','R','R','R','R','R','R');
                $this->pdf->setwidths(array(10,40,29,30,29,29,29,29,29,29));
                $this->pdf->setFont('Arial','',8);
                
               
                $this->pdf->row(array($i,
                    $row1['custname'],
                    Yii::app()->format->formatCurrency($row1['gt30']),
                    Yii::app()->format->formatCurrency($row1['gt15']),
                    Yii::app()->format->formatCurrency($row1['gt7']),
                    Yii::app()->format->formatCurrency($row1['gt0']),
                    Yii::app()->format->formatCurrency($row1['x0']),
                    Yii::app()->format->formatCurrency($row1['lt0']),
                    Yii::app()->format->formatCurrency($row1['lt14']),
                    Yii::app()->format->formatCurrency($row1['jumlah']),
                ));
                
                $i++;
                $totalgt30 += $row1['gt30'];
                $totalgt15 += $row1['gt15'];
                $totalgt7 += $row1['gt7'];
                $totalgt0 += $row1['gt0'];
                $totalx0 += $row1['x0'];
                $totallt0 += $row1['lt0'];
                $totallt14 += $row1['lt14'];
                $totaljumlah += $row1['jumlah'];
            }
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setFont('Arial','B',8);
            
            $this->pdf->setwidths(array(50,29,30,29,29,29,29,29,29));
            $this->pdf->coldetailalign = array('L','R','R','R','R','R','R','R','R');
            
            $this->pdf->row(array('TOTAL TARGET SALES '.$row['fullname'],
                            Yii::app()->format->formatCurrency($totalgt30),
                            Yii::app()->format->formatCurrency($totalgt15),
                            Yii::app()->format->formatCurrency($totalgt7),
                            Yii::app()->format->formatCurrency($totalgt0),
                            Yii::app()->format->formatCurrency($totalx0),
                            Yii::app()->format->formatCurrency($totallt0),
                            Yii::app()->format->formatCurrency($totallt14),
                            Yii::app()->format->formatCurrency($totaljumlah),
            ));
            
        }
		// me-render ke browser
		$this->pdf->Output();
	}
  public function actionDownPDF()
	{
		parent::actionDownPDF();
		//$this->getSQL();
		//$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
        
		$sql = "select a.docdate,a.perioddate, d.fullname, a.employeeid, a.companyid, a.paymenttargetid
						from paymenttarget a
						join employee d on d.employeeid = a.employeeid ";
        
        if ($_GET['paymenttarget_0_paymenttargetid'] !== '') 
		{
				$sql = $sql . "where a.paymenttargetid in (".$_GET['paymenttarget_0_paymenttargetid'].")";
		}
						
		$result = Yii::app()->db->createCommand($sql)->queryAll();
        
        foreach($result as $row)
        {
            $totalgt30 = 0;
            $totalgt15 = 0;
            $totalgt7 = 0;
            $totalgt0 = 0;
            $totalx0 = 0;
            $totallt0 = 0;
            $totallt14 = 0;
            $totaljumlah = 0;
		
            $sqlcustcategory = "select b.custcategoryid, b.custcategoryname
                                from paymenttargetdet a 
                                join custcategory b on b.custcategoryid = a.custcategoryid
                                where a.paymenttargetid = ".$row['paymenttargetid']."
                                group by b.custcategoryid";
            $custcategory = Yii::app()->db->createCommand($sqlcustcategory)->queryAll();
            
            $datetime = new DateTime($row['perioddate']);
            //masukkan judul
            $this->pdf->title=$this->getCatalog('paymenttarget');
            $this->pdf->AddPage('L','A4');
            
            $this->pdf->setY($this->pdf->getY());
            $this->pdf->setFont('Arial','B',11);
            $this->pdf->text(10,$this->pdf->getY(),'Tanggal ');
            $this->pdf->text(10,$this->pdf->getY()+5,'Nama Sales ');
            $this->pdf->text(10,$this->pdf->getY()+10,'Periode ');
            //$this->pdf->text(10,25,'Total Target ');
            $this->pdf->text(45,$this->pdf->getY(),': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
            $this->pdf->text(45,$this->pdf->getY()+5,': '.$row['fullname']);
            $this->pdf->text(45,$this->pdf->getY()+10,': '.$datetime->format('F').' '.$datetime->format('Y'));
            //$this->pdf->text(45,25,': 999999999999');

            $month = date('m',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));

            $prev_month_ts1 = strtotime(''.$year.'-'.$month.'-01 -3 month');
            $prev_month_ts2 = strtotime(''.$year.'-'.$month.'-01 -1 month');

            $lastmonth1 = date('Y-m-d', $prev_month_ts1);
            $lastmonth2 = date('Y-m-t', $prev_month_ts2);
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setY($this->pdf->getY()+5);
            foreach($custcategory as $rslt)
            {
                $totalgt30cust = 0;
                $totalgt15cust = 0;
                $totalgt7cust = 0;
                $totalgt0cust = 0;
                $totalx0cust = 0;
                $totallt0cust = 0;
                $totallt14cust = 0;
                $totaljumlahcust = 0;
                
                $this->pdf->setFont('Arial','B',10);
                $this->pdf->text(10,$this->pdf->getY()+10,getCatalog('custcategory').' : '.$rslt['custcategoryname']);
                
                $sql1 = "select b.addressbookid, c.fullname as custname, gt30,gt15,gt7,gt0,x0,lt0,lt14,gt30+gt15+gt7+gt0+x0+lt0+lt14 as jumlah,b.paymenttargetid
                                 from paymenttargetdet b
                                 join addressbook c on c.addressbookid = b.addressbookid ";
                $sql1 = $sql1 . " where b.paymenttargetid = ".$row['paymenttargetid']." and b.custcategoryid = ".$rslt['custcategoryid']." group by b.addressbookid ";
                $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();

                $this->pdf->setFont('Arial','',10);
                $this->pdf->setY($this->pdf->getY()+13);
                $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
                $this->pdf->colheader = array($this->getCatalog('NO'),$this->getCatalog('customer'),$this->getCatalog('gt30'),$this->getCatalog('gt15'),$this->getCatalog('gt7'),$this->getCatalog('gt0'),$this->getCatalog('x0'),$this->getCatalog('lt0'),$this->getCatalog('lt14'),$this->getCatalog('Jumlah'));
                $this->pdf->setwidths(array(10,40,29,30,29,29,29,29,29,29));
                $this->pdf->Rowheader();        

                $i=1;

                foreach($dataReader1 as $row1)
                {
                    //masukkan baris untuk cetak
                    $totalqty = 0;
                    $totalharga = 0;


                    //$this->pdf->text(20,$this->pdf->getY()+10,'Group Material :');
                    $this->pdf->coldetailalign = array('C','L','R','R','R','R','R','R','R','R');
                    $this->pdf->setwidths(array(10,40,29,30,29,29,29,29,29,29));
                    $this->pdf->setFont('Arial','',8);


                    $this->pdf->row(array($i,
                        $row1['custname'],
                        Yii::app()->format->formatCurrency($row1['gt30']),
                        Yii::app()->format->formatCurrency($row1['gt15']),
                        Yii::app()->format->formatCurrency($row1['gt7']),
                        Yii::app()->format->formatCurrency($row1['gt0']),
                        Yii::app()->format->formatCurrency($row1['x0']),
                        Yii::app()->format->formatCurrency($row1['lt0']),
                        Yii::app()->format->formatCurrency($row1['lt14']),
                        Yii::app()->format->formatCurrency($row1['jumlah']),
                    ));

                    $i++;
                    $totalgt30 += $row1['gt30'];
                    $totalgt15 += $row1['gt15'];
                    $totalgt7 += $row1['gt7'];
                    $totalgt0 += $row1['gt0'];
                    $totalx0 += $row1['x0'];
                    $totallt0 += $row1['lt0'];
                    $totallt14 += $row1['lt14'];
                    $totaljumlah += $row1['jumlah'];
                    
                    $totalgt30cust += $row1['gt30'];
                    $totalgt15cust += $row1['gt15'];
                    $totalgt7cust += $row1['gt7'];
                    $totalgt0cust += $row1['gt0'];
                    $totalx0cust += $row1['x0'];
                    $totallt0cust += $row1['lt0'];
                    $totallt14cust += $row1['lt14'];
                    $totaljumlahcust += $row1['jumlah'];
                }
                $this->pdf->setFont('Arial','B',8);
            
                $this->pdf->setwidths(array(50,29,30,29,29,29,29,29,29));
                $this->pdf->coldetailalign = array('L','R','R','R','R','R','R','R','R');
                $this->pdf->row(array('TOTAL '.$rslt['custcategoryname'],
                            Yii::app()->format->formatCurrency($totalgt30cust),
                            Yii::app()->format->formatCurrency($totalgt15cust),
                            Yii::app()->format->formatCurrency($totalgt7cust),
                            Yii::app()->format->formatCurrency($totalgt0cust),
                            Yii::app()->format->formatCurrency($totalx0cust),
                            Yii::app()->format->formatCurrency($totallt0cust),
                            Yii::app()->format->formatCurrency($totallt14cust),
                            Yii::app()->format->formatCurrency($totaljumlahcust)
                ));
            }
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setFont('Arial','B',8);
            
            $this->pdf->setwidths(array(50,29,30,29,29,29,29,29,29));
            $this->pdf->coldetailalign = array('L','R','R','R','R','R','R','R','R');
            
            $this->pdf->row(array('TOTAL TARGET SALES '.$row['fullname'],
                            Yii::app()->format->formatCurrency($totalgt30),
                            Yii::app()->format->formatCurrency($totalgt15),
                            Yii::app()->format->formatCurrency($totalgt7),
                            Yii::app()->format->formatCurrency($totalgt0),
                            Yii::app()->format->formatCurrency($totalx0),
                            Yii::app()->format->formatCurrency($totallt0),
                            Yii::app()->format->formatCurrency($totallt14),
                            Yii::app()->format->formatCurrency($totaljumlah),
            ));
            
        }
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('paymenttargetid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('perioddate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['paymenttargetid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['perioddate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
