<?php

class EkspedisiController extends AdminController
{
	protected $menuname = 'ekspedisi';
	public $module = 'Accounting';
	protected $pageTitle = 'Ekspedisi';
	public $wfname = 'appeksp';
	protected $sqldata = "select a0.ekspedisiid,a0.companyid,a0.ekspedisino,a0.docdate,a0.addressbookid,a0.amount,a0.currencyid,a0.currencyrate,a0.recordstatus,a1.companyname as companyname,a2.fullname as fullname,a3.currencyname as currencyname,a0.statusname  
    from ekspedisi a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
protected $sqldataekspedisipo = "select a0.ekspedisipoid,a0.ekspedisiid,a0.poheaderid,a1.pono as pono 
    from ekspedisipo a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqldataeksmat = "select a0.eksmatid,a0.ekspedisiid,a0.ekspedisipoid,a0.productid,a0.qty,a0.uomid,a0.expense,a0.currencyid,a0.currencyrate,a1.productname as productname,a2.uomcode as uomcode,a3.currencyname as currencyname 
    from eksmat a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from ekspedisi a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";
protected $sqlcountekspedisipo = "select count(1) 
    from ekspedisipo a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqlcounteksmat = "select count(1) 
    from eksmat a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join currency a3 on a3.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listeksp').") 
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['ekspedisino'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .=  " 
and a0.ekspedisino like '%". $_REQUEST['ekspedisino']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.fullname like '%". $_REQUEST['fullname']."%' 
and a3.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['ekspedisiid']))
			{
				if (($_REQUEST['ekspedisiid'] !== '0') && ($_REQUEST['ekspedisiid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.ekspedisiid in (".$_REQUEST['ekspedisiid'].")";
					}
					else
					{
						$where .= " and a0.ekspedisiid in (".$_REQUEST['ekspedisiid'].")";
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
			'keyField'=>'ekspedisiid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'ekspedisiid','companyid','ekspedisino','docdate','addressbookid','amount','currencyid','currencyrate','recordstatus'
				),
				'defaultOrder' => array( 
					'ekspedisiid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['ekspedisiid']))
		{
			$this->sqlcountekspedisipo .= ' where a0.ekspedisiid = '.$_REQUEST['ekspedisiid'];
			$this->sqldataekspedisipo .= ' where a0.ekspedisiid = '.$_REQUEST['ekspedisiid'];
		}
		$countekspedisipo = Yii::app()->db->createCommand($this->sqlcountekspedisipo)->queryScalar();
$dataProviderekspedisipo=new CSqlDataProvider($this->sqldataekspedisipo,array(
					'totalItemCount'=>$countekspedisipo,
					'keyField'=>'ekspedisipoid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'ekspedisipoid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['ekspedisiid']))
		{
			$this->sqlcounteksmat .= ' where a0.ekspedisiid = '.$_REQUEST['ekspedisiid'];
			$this->sqldataeksmat .= ' where a0.ekspedisiid = '.$_REQUEST['ekspedisiid'];
			$count = Yii::app()->db->createCommand($this->sqlcounteksmat)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldataeksmat .= " limit 0";
		}
		$counteksmat = Yii::app()->db->createCommand($this->sqlcounteksmat)->queryScalar();
$dataProvidereksmat=new CSqlDataProvider($this->sqldataeksmat,array(
					'totalItemCount'=>$counteksmat,
					'keyField'=>'eksmatid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'eksmatid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderekspedisipo'=>$dataProviderekspedisipo,'dataProvidereksmat'=>$dataProvidereksmat));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into ekspedisi (recordstatus) values (".$this->findstatusbyuser('inseksp').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'ekspedisiid'=>$id,
			"docdate" =>date("Y-m-d"),
      "amount" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0,
      "recordstatus" =>$this->findstatusbyuser("inseksp")
		));
	}
  public function actionCreateekspedisipo()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
  public function actionCreateeksmat()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "expense" =>0,
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.ekspedisiid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'addressbookid'=>$model['addressbookid'],
          'amount'=>$model['amount'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'companyname'=>$model['companyname'],
          'fullname'=>$model['fullname'],
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

  public function actionUpdateekspedisipo()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataekspedisipo.' where ekspedisipoid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'poheaderid'=>$model['poheaderid'],
          'pono'=>$model['pono'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateeksmat()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataeksmat.' where eksmatid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'expense'=>$model['expense'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
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
      array('addressbookid','string','emptyaddressbookid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['ekspedisiid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateEkspedisi (:companyid
,:docdate
,:addressbookid
,:amount
,:currencyid
,:currencyrate,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':ekspedisiid',$_POST['ekspedisiid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':amount',(($_POST['amount']!=='')?$_POST['amount']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
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
public function actionSaveekspedisipo()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('poheaderid','string','emptypoheaderid'),
    ));
		if ($error == false)
		{
			$id = $_POST['ekspedisipoid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update ekspedisipo 
			      set poheaderid = :poheaderid 
			      where ekspedisipoid = :ekspedisipoid';
				}
				else
				{
					$sql = 'insert into ekspedisipo (poheaderid) 
			      values (:poheaderid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':ekspedisipoid',$_POST['ekspedisipoid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':poheaderid',(($_POST['poheaderid']!=='')?$_POST['poheaderid']:null),PDO::PARAM_STR);
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
				
public function actionSaveeksmat()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['eksmatid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update eksmat 
			      set productid = :productid,qty = :qty,uomid = :uomid,expense = :expense,currencyid = :currencyid,currencyrate = :currencyrate 
			      where eksmatid = :eksmatid';
				}
				else
				{
					$sql = 'insert into eksmat (productid,qty,uomid,expense,currencyid,currencyrate) 
			      values (:productid,:qty,:uomid,:expense,:currencyid,:currencyrate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':eksmatid',$_POST['eksmatid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':expense',(($_POST['expense']!=='')?$_POST['expense']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyrate',(($_POST['currencyrate']!=='')?$_POST['currencyrate']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveekspedisi(:vid,:vcreatedby)';
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
				$sql = 'call Deleteekspedisi(:vid,:vcreatedby)';
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
				$sql = "delete from ekspedisi where ekspedisiid = ".$id[$i];
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
	}public function actionPurgeekspedisipo()
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
				$sql = "delete from ekspedisipo where ekspedisipoid = ".$id[$i];
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
	}public function actionPurgeeksmat()
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
				$sql = "delete from eksmat where eksmatid = ".$id[$i];
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
		$sql = "select a.*, c.pono, a.docdate as eksdate, d.fullname as kurir,
                        (select zz.fullname
                        from poheader z
                        left join addressbook zz on zz.addressbookid = z.addressbookid
                        where z.poheaderid = b.poheaderid) as supplier
                        from ekspedisi a
                        left join ekspedisipo b on b.ekspedisiid = a.ekspedisiid
                        left join poheader c on c.poheaderid = b.poheaderid
                        left join addressbook d on d.addressbookid = a.addressbookid ";
		if ($_GET['ekspedisiid'] !== '') {
				$sql = $sql . "where a.ekspedisiid in (".$_GET['ekspedisiid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('ekspedisi');
                $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
                // definisi font
                
                foreach($dataReader as $row)
                {
                    $this->pdf->SetFontSize(8);
                    $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['ekspedisino']);
                    $this->pdf->text(120,$this->pdf->gety()+2,'Ekspedisi ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['kurir']);
                    $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['eksdate'])));
                    $this->pdf->text(120,$this->pdf->gety()+6,'PO ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['pono']. ' / '.$row['supplier']);
                    $sql1 = "select *,b.productname,c.currencyname,d.uomcode
                            from eksmat a
                            left join product b on b.productid = a.productid
                            left join currency c on c.currencyid = a.currencyid
                            left join unitofmeasure d on d.unitofmeasureid = a.uomid
                            where ekspedisiid = ".$row['ekspedisiid'];
                    $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
                    
                    $this->pdf->sety($this->pdf->gety()+10);
      
                    $this->pdf->colalign = array('C','C','C','C','C','C');
                    $this->pdf->setwidths(array(10,100,20,20,30,20));
                    $this->pdf->colheader = array('No','Product','Qty','Satuan','Biaya','Mata Uang');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('L','L','R','C','R','C');
                    $i=0;$totalexpense=0;$currency = '';
                    foreach($dataReader1 as $row1)
                    {
                        $i=$i+1;
                        $this->pdf->row(array($i,$row1['productname'],
                        Yii::app()->format->formatNumber($row1['qty']),
                        $row1['uomcode'],
                        Yii::app()->format->formatCurrency($row1['expense']),
                        $row1['currencyname']));
						$totalexpense += $row1['expense'];
						$currency = $row1['currencyname'];
                    }	
					$this->pdf->row(array(
						'','','','Total',
						Yii::app()->format->formatCurrency($totalexpense),
						$currency,
					));
                    
                    $this->pdf->sety($this->pdf->gety());
                    $this->pdf->colalign = array('C','C');
                    $this->pdf->setwidths(array(30,170));
                    $this->pdf->iscustomborder = false;
                    $this->pdf->setbordercell(array('none','none'));
                    $this->pdf->coldetailalign = array('L','L');
                    /*$this->pdf->row(array(
                    'Note:',
                    $row['headernote']
                    ));*/
                    
                    $this->pdf->checkNewPage(40);      
                        //      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'    Admin AP');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('ekspedisiid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('ekspedisino'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('amount'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('currencyrate'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['ekspedisiid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['ekspedisino'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['amount'])
->setCellValueByColumnAndRow(6, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(7, $i+1, $row1['currencyrate'])
->setCellValueByColumnAndRow(8, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}