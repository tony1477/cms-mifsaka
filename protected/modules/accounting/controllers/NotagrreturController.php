<?php

class NotagrreturController extends AdminController
{
	protected $menuname = 'notagrretur';
	public $module = 'Accounting';
	protected $pageTitle = 'Nota Retur Pembelian';
	public $wfname = 'appnotagrretur';
	protected $sqldata = "select a0.notagrreturid,a0.companyid,a0.notagrreturno,a0.docdate,a0.grreturid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.grreturno as grreturno,a0.statusname  
    from notagrretur a0 
    left join company a1 on a1.companyid = a0.companyid
    left join grretur a2 on a2.grreturid = a0.grreturid
  ";
protected $sqldatanotagrrpro = "select a0.notagrrproid,a0.notagrreturid,a0.grreturdetailid,a0.productid,a0.qty,a0.uomid,a0.price,a0.slocid,a0.currencyid,a0.currencyrate,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.currencyname as currencyname 
    from notagrrpro a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
protected $sqldatanotagrracc = "select a0.notagrraccid,a0.notagrreturid,a0.accountid,a0.debet,a0.credit,a0.currencyid,a0.currencyrate,a0.itemnote 
    from notagrracc a0 
  ";
  protected $sqlcount = "select count(1) 
    from notagrretur a0 
    left join company a1 on a1.companyid = a0.companyid
    left join grretur a2 on a2.grreturid = a0.grreturid
  ";
protected $sqlcountnotagrrpro = "select count(1) 
    from notagrrpro a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
protected $sqlcountnotagrracc = "select count(1) 
    from notagrracc a0 
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appnotagrretur')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listnotagrretur').") 
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['notagrreturno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['grreturno'])))
		{				
			$where .=  " 
and a0.notagrreturno like '%". $_REQUEST['notagrreturno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.grreturno like '%". $_REQUEST['grreturno']."%'"; 
		}
		if (isset($_REQUEST['notagrreturid']))
			{
				if (($_REQUEST['notagrreturid'] !== '0') && ($_REQUEST['notagrreturid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.notagrreturid in (".$_REQUEST['notagrreturid'].")";
					}
					else
					{
						$where .= " and a0.notagrreturid in (".$_REQUEST['notagrreturid'].")";
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
			'keyField'=>'notagrreturid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'notagrreturid','companyid','notagrreturno','docdate','grreturid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'notagrreturid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['notagrreturid']))
		{
			$this->sqlcountnotagrrpro .= ' where a0.notagrreturid = '.$_REQUEST['notagrreturid'];
			$this->sqldatanotagrrpro .= ' where a0.notagrreturid = '.$_REQUEST['notagrreturid'];
		}
		$countnotagrrpro = Yii::app()->db->createCommand($this->sqlcountnotagrrpro)->queryScalar();
$dataProvidernotagrrpro=new CSqlDataProvider($this->sqldatanotagrrpro,array(
					'totalItemCount'=>$countnotagrrpro,
					'keyField'=>'notagrrproid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'notagrrproid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['notagrreturid']))
		{
			$this->sqlcountnotagrracc .= ' where a0.notagrreturid = '.$_REQUEST['notagrreturid'];
			$this->sqldatanotagrracc .= ' where a0.notagrreturid = '.$_REQUEST['notagrreturid'];
		}
		$countnotagrracc = Yii::app()->db->createCommand($this->sqlcountnotagrracc)->queryScalar();
$dataProvidernotagrracc=new CSqlDataProvider($this->sqldatanotagrracc,array(
					'totalItemCount'=>$countnotagrracc,
					'keyField'=>'notagrraccid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'notagrraccid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidernotagrrpro'=>$dataProvidernotagrrpro,'dataProvidernotagrracc'=>$dataProvidernotagrracc));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into notagrretur (recordstatus) values (".$this->findstatusbyuser('insnotagrretur').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'notagrreturid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insnotagrretur")
		));
	}
  public function actionCreatenotagrrpro()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "price" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "currencyrate" =>0
		));
	}
  public function actionCreatenotagrracc()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"debet" =>0,
      "credit" =>0,
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.notagrreturid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'grreturid'=>$model['grreturid'],
          'headernote'=>$model['headernote'],
          'companyname'=>$model['companyname'],
          'grreturno'=>$model['grreturno'],

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

  public function actionUpdatenotagrrpro()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatanotagrrpro.' where notagrrproid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'price'=>$model['price'],
          'currencyid'=>$model['currencyid'],
          'currencyrate'=>$model['currencyrate'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'currencyname'=>$model['currencyname'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdatenotagrracc()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatanotagrracc.' where notagrraccid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					
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
    ));
		if ($error == false)
		{
			$id = $_POST['notagrreturid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateNotagrretur (:companyid
,:docdate
,:grreturid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':notagrreturid',$_POST['notagrreturid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':grreturid',(($_POST['grreturid']!=='')?$_POST['grreturid']:null),PDO::PARAM_STR);
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
public function actionSavenotagrrpro()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('price','string','emptyprice'),
    ));
		if ($error == false)
		{
			$id = $_POST['notagrrproid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update notagrrpro 
			      set price = :price,currencyid = :currencyid,currencyrate = :currencyrate 
			      where notagrrproid = :notagrrproid';
				}
				else
				{
					$sql = 'insert into notagrrpro (price,currencyid,currencyrate) 
			      values (:price,:currencyid,:currencyrate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':notagrrproid',$_POST['notagrrproid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':price',(($_POST['price']!=='')?$_POST['price']:null),PDO::PARAM_STR);
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
				
public function actionSavenotagrracc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['notagrraccid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update notagrracc 
			      set  
			      where notagrraccid = :notagrraccid';
				}
				else
				{
					$sql = 'insert into notagrracc () 
			      values ()';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':notagrraccid',$_POST['notagrraccid'],PDO::PARAM_STR);
				}
				
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
				$sql = 'call Approvenotagrretur(:vid,:vcreatedby)';
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
				$sql = 'call Deletenotagrretur(:vid,:vcreatedby)';
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
				$sql = "delete from notagrretur where notagrreturid = ".$id[$i];
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
	}public function actionPurgenotagrrpro()
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
				$sql = "delete from notagrrpro where notagrrproid = ".$id[$i];
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
	}public function actionPurgenotagrracc()
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
				$sql = "delete from notagrracc where notagrraccid = ".$id[$i];
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
		$sql = "select notagrreturid,a.companyid,a.notagrreturno,a.docdate,a.headernote,c.grreturno,d.pono,e.fullname
                        from notagrretur a 
						left join grretur c on c.grreturid = a.grreturid
                        left join poheader d on d.poheaderid = c.poheaderid
                        left join addressbook e on e.addressbookid = d.addressbookid			
                        ";
		if ($_GET['notagrreturid'] !== '') {
				$sql = $sql . "where a.notagrreturid in (".$_GET['notagrreturid'].")";
		}
                $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
                foreach($dataReader as $row)
                {
                    $this->pdf->companyid = $row['companyid'];
                }
                $this->pdf->title=$this->getcatalog('notagrretur');
                $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
	  // definisi font  

    foreach($dataReader as $row)
    {
        $this->pdf->SetFontSize(8);
        $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['notagrreturno']);
        $this->pdf->text(120,$this->pdf->gety()+2,'No. Reff. ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['grreturno'].' / ' .$row['pono']);
        $this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
        $this->pdf->text(120,$this->pdf->gety()+6,'Supplier ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['fullname']);

        $sql1 = "select b.productname, a.qty, c.uomcode, concat(e.sloccode,' - ',e.description) as sloccode,a.price,a.qty*a.price as jumlah
        from notagrrpro a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.uomid 
        left join sloc e on e.slocid = a.slocid
        where notagrreturid = ".$row['notagrreturid'];
        $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();
		$totaljumlah=0;$i=0;
        $this->pdf->sety($this->pdf->gety()+10);
      
        $this->pdf->colalign = array('C','C','C','C','C','C');
        $this->pdf->setwidths(array(10,90,20,15,30,30));
        $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Harga', 'Jumlah');
        $this->pdf->RowHeader();
        $this->pdf->coldetailalign = array('L','L','R','C','R','R');
        $i=0;
        foreach($dataReader1 as $row1)
        {
            $i=$i+1;
            $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            Yii::app()->format->formatCurrency($row1['price']),
			Yii::app()->format->formatCurrency($row1['jumlah'])));
			$totaljumlah += $row1['jumlah'];
        }
		
		$this->pdf->row(array(
						'','','','','Total',
						Yii::app()->format->formatCurrency($totaljumlah),
					));
        
        $sql2 = "select b.accountname,a.debet,a.credit,c.currencyname,a.itemnote
                from notagrracc a
                left join account b on b.accountid = a.accountid
                left join currency c on c.currencyid = a.currencyid
                where notagrreturid = ".$row['notagrreturid'];
                    $dataReader2=Yii::app()->db->createCommand($sql2)->queryAll();
                    $totaldebet=0;$totalcredit=0;$i=0;
                    $this->pdf->sety($this->pdf->gety()+12);
      
                    $this->pdf->colalign = array('C','C','C','C','C','C');
                    $this->pdf->setwidths(array(10,60,25,25,25,50));
                    $this->pdf->colheader = array('No','Akun','Debet','Credit','Mata Uang','Keterangan');
                    $this->pdf->RowHeader();
                    $this->pdf->coldetailalign = array('L','L','R','R','C','L');
                    $i=0;
                    foreach($dataReader2 as $row2)
                    {
                        $i=$i+1;
                        $this->pdf->row(array($i,$row2['accountname'],
                        Yii::app()->format->formatNumber($row2['debet']),
                        Yii::app()->format->formatNumber($row2['credit']),
                        $row2['currencyname'],
                        $row2['itemnote']));
						$totaldebet += $row1['debet'];
						$totalcredit += $row1['credit'];
                    }
					
					$this->pdf->row(array(
						'','Total',
						Yii::app()->format->formatCurrency($totaldebet),
						Yii::app()->format->formatCurrency($totalcredit),
						'','',
					));
			
            $this->pdf->sety($this->pdf->gety());
            $this->pdf->colalign = array('C','C');
            $this->pdf->setwidths(array(30,170));
            $this->pdf->iscustomborder = false;
            $this->pdf->setbordercell(array('none','none'));
            $this->pdf->coldetailalign = array('L','L');
            $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('notagrreturid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('notagrreturno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('grreturno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['notagrreturid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['notagrreturno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['grreturno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}