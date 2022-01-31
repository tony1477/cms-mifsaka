<?php

class NotagirController extends AdminController
{
	protected $menuname = 'notagir';
	public $module = 'Accounting';
	protected $pageTitle = 'Nota Retur Penjualan';
	public $wfname = 'appnotagir';
	protected $sqldata = "select a0.notagirid,a0.companyid,a0.notagirno,a0.docdate,a0.gireturid,a0.headernote,a0.recordstatus,a1.companyname as companyname,a2.gireturno as gireturno,a0.statusname  
    from notagir a0 
    left join company a1 on a1.companyid = a0.companyid
    left join giretur a2 on a2.gireturid = a0.gireturid
  ";
protected $sqldatanotagirpro = "select a0.notagirproid,a0.notagirid,a0.gireturdetailid,a0.productid,a0.qty,a0.uomid,a0.price,a0.slocid,a0.currencyid,a0.currencyrate,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.currencyname as currencyname 
    from notagirpro a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
protected $sqldatanotagiracc = "select a0.notagiraccid,a0.notagirid,a0.accountid,a0.debet,a0.credit,a0.currencyid,a0.currencyrate,a0.itemnote 
    from notagiracc a0 
  ";
  protected $sqlcount = "select count(1) 
    from notagir a0 
    left join company a1 on a1.companyid = a0.companyid
    left join giretur a2 on a2.gireturid = a0.gireturid
  ";
protected $sqlcountnotagirpro = "select count(1) 
    from notagirpro a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join currency a4 on a4.currencyid = a0.currencyid
  ";
protected $sqlcountnotagiracc = "select count(1) 
    from notagiracc a0 
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appnotagir')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listnotagir').") 
				and a0.recordstatus < {$maxstat}
				and a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['notagirno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['gireturno'])))
		{				
			$where .=  " 
and a0.notagirno like '%". $_REQUEST['notagirno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.gireturno like '%". $_REQUEST['gireturno']."%'"; 
		}
		if (isset($_REQUEST['notagirid']))
			{
				if (($_REQUEST['notagirid'] !== '0') && ($_REQUEST['notagirid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.notagirid in (".$_REQUEST['notagirid'].")";
					}
					else
					{
						$where .= " and a0.notagirid in (".$_REQUEST['notagirid'].")";
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
			'keyField'=>'notagirid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'notagirid','companyid','notagirno','docdate','gireturid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'notagirid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['notagirid']))
		{
			$this->sqlcountnotagirpro .= ' where a0.notagirid = '.$_REQUEST['notagirid'];
			$this->sqldatanotagirpro .= ' where a0.notagirid = '.$_REQUEST['notagirid'];
		}
		$countnotagirpro = Yii::app()->db->createCommand($this->sqlcountnotagirpro)->queryScalar();
$dataProvidernotagirpro=new CSqlDataProvider($this->sqldatanotagirpro,array(
					'totalItemCount'=>$countnotagirpro,
					'keyField'=>'notagirproid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'notagirproid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['notagirid']))
		{
			$this->sqlcountnotagiracc .= ' where a0.notagirid = '.$_REQUEST['notagirid'];
			$this->sqldatanotagiracc .= ' where a0.notagirid = '.$_REQUEST['notagirid'];
		}
		$countnotagiracc = Yii::app()->db->createCommand($this->sqlcountnotagiracc)->queryScalar();
$dataProvidernotagiracc=new CSqlDataProvider($this->sqldatanotagiracc,array(
					'totalItemCount'=>$countnotagiracc,
					'keyField'=>'notagiraccid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'notagiraccid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidernotagirpro'=>$dataProvidernotagirpro,'dataProvidernotagiracc'=>$dataProvidernotagiracc));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into notagir (recordstatus) values (".$this->findstatusbyuser('insnotagir').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'notagirid'=>$id,
			"docdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insnotagir")
		));
	}
  public function actionCreatenotagirpro()
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
  public function actionCreatenotagiracc()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.notagirid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'gireturid'=>$model['gireturid'],
          'headernote'=>$model['headernote'],
          'companyname'=>$model['companyname'],
          'gireturno'=>$model['gireturno'],

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

  public function actionUpdatenotagirpro()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatanotagirpro.' where notagirproid = '.$id)->queryRow();
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
  public function actionUpdatenotagiracc()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatanotagiracc.' where notagiraccid = '.$id)->queryRow();
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
			$id = $_POST['notagirid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateNotagir (:companyid
,:docdate
,:gireturid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':notagirid',$_POST['notagirid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':gireturid',(($_POST['gireturid']!=='')?$_POST['gireturid']:null),PDO::PARAM_STR);
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
public function actionSavenotagirpro()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['notagirproid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update notagirpro 
			      set price = :price,currencyid = :currencyid,currencyrate = :currencyrate 
			      where notagirproid = :notagirproid';
				}
				else
				{
					$sql = 'insert into notagirpro (price,currencyid,currencyrate) 
			      values (:price,:currencyid,:currencyrate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':notagirproid',$_POST['notagirproid'],PDO::PARAM_STR);
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
				
public function actionSavenotagiracc()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['notagiraccid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update notagiracc 
			      set  
			      where notagiraccid = :notagiraccid';
				}
				else
				{
					$sql = 'insert into notagiracc () 
			      values ()';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':notagiraccid',$_POST['notagiraccid'],PDO::PARAM_STR);
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
				$sql = 'call Approvenotagir(:vid,:vcreatedby)';
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
				$sql = 'call Deletenotagir(:vid,:vcreatedby)';
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
				$sql = "delete from notagir where notagirid = ".$id[$i];
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
	}public function actionPurgenotagirpro()
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
				$sql = "delete from notagirpro where notagirproid = ".$id[$i];
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
	}public function actionPurgenotagiracc()
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
				$sql = "delete from notagiracc where notagiraccid = ".$id[$i];
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
		$sql = "select *,a.notagirid,a.notagirno,a.companyid,a.docdate,b.gireturno,d.sono,e.fullname as customer,f.invoiceno
						from notagir a
						left join giretur b on b.gireturid = a.gireturid
						left join giheader c on c.giheaderid = b.giheaderid
						left join soheader d on d.soheaderid = c.soheaderid
						left join addressbook e on e.addressbookid = d.addressbookid
						left join invoice f on f.giheaderid=c.giheaderid";
		if ($_GET['notagirid'] !== '') {
				$sql = $sql . " where a.notagirid in (".$_GET['notagirid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $row['companyid'];
		}
		$this->pdf->title=$this->getcatalog('notagir');
		$this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('Arial');
		// definisi font  

		foreach($dataReader as $row)
		{
			$this->pdf->SetFontSize(8);
			$this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['notagirno']);
			$this->pdf->text(120,$this->pdf->gety()+2,'No. Reff. ');$this->pdf->text(140,$this->pdf->gety()+2,': '.$row['invoiceno']);
			$this->pdf->text(10,$this->pdf->gety()+6,'Tgl ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));
			$this->pdf->text(120,$this->pdf->gety()+6,'Customer ');$this->pdf->text(140,$this->pdf->gety()+6,': '.$row['customer']);

			$sql1 = "select b.productname, a.qty, c.uomcode, a.price, a.qty*a.price as jumlah
			from notagirpro a
			left join product b on b.productid = a.productid
			left join unitofmeasure c on c.unitofmeasureid = a.uomid 
			left join sloc e on e.slocid = a.slocid
			where notagirid = ".$row['notagirid'];
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
				Yii::app()->format->formatCurrency($row1['qty']),
				$row1['uomcode'],
				Yii::app()->format->formatCurrency($row1['price']),
				Yii::app()->format->formatCurrency($row1['jumlah'])));
				$totaljumlah += $row1['jumlah'];
			}
		
			$this->pdf->row(array(
				'','','','','Total',
				Yii::app()->format->formatCurrency($totaljumlah),
			));
										 
			$sql2 = "select distinct b.accountname,a.debet,a.credit,c.currencyname,a.itemnote
							from notagiracc a
							left join account b on b.accountid = a.accountid
							left join currency c on c.currencyid = a.currencyid
							where a.notagirid = ".$row['notagirid'];
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
				$totaldebet += $row2['debet'];
				$totalcredit += $row2['credit'];
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
			
			$this->pdf->checkNewPage(30);      
													//      $this->pdf->Image('images/ttdda.jpg',10,$this->pdf->gety()+5,180);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Diperiksa oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'...........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'    Admin AR');$this->pdf->text(55,$this->pdf->gety()+25,'     Controller');$this->pdf->text(96,$this->pdf->gety()+25,'Chief Accounting');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('notagirid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('notagirno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('gireturno'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['notagirid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['notagirno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['gireturno'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}