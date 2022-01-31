<?php

class ProductoutputController extends AdminController
{
	protected $menuname = 'productoutput';
	public $module = 'Production';
	protected $pageTitle = 'Hasil Produksi';
	public $wfname = 'appop';
	protected $sqldata = "select a1.companyid,a2.companyname, a0.productoutputid,a0.productoutputno,a0.productoutputdate,a0.productplanid,a0.description,a0.recordstatus,a1.productplanno as productplanno,a0.statusname  
    from productoutput a0 
    left join productplan a1 on a1.productplanid = a0.productplanid 
		left join company a2 on a2.companyid = a1.companyid 
  ";
protected $sqldataproductoutputfg = "select a0.productoutputfgid,a0.productoutputid,a0.productplanfgid,a0.productid,a0.qtyoutput,a0.uomid,a0.slocid,a0.storagebinid,a0.outputdate,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as storagedesc 
    from productoutputfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
protected $sqldataproductoutputdetail = "select a0.productoutputdetailid,a0.productoutputid,a0.productoutputfgid,a0.productid,a0.qty,a0.uomid,a0.toslocid,a0.storagebinid,a0.productplandetailid,a0.productplanfgid,a0.description,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as storagedesc 
    from productoutputdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.toslocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from productoutput a0 
    left join productplan a1 on a1.productplanid = a0.productplanid 
		left join company a2 on a2.companyid = a1.companyid 
  ";
protected $sqlcountproductoutputfg = "select count(1) 
    from productoutputfg a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
protected $sqlcountproductoutputdetail = "select count(1) 
    from productoutputdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.toslocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appop')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listop').")
				and a0.recordstatus < {$maxstat}
				and a1.companyid in (".getUserObjectWfValues('company','appprodplan').")";
		if ((isset($_REQUEST['productoutputno'])) && (isset($_REQUEST['productplanno'])))
		{				
			$where .=  " 
and a0.productoutputno like '%". $_REQUEST['productoutputno']."%' 
and a2.companyname like '%". $_REQUEST['companyname']."%' 
and a1.productplanno like '%". $_REQUEST['productplanno']."%'"; 
		}
		if (isset($_REQUEST['productoutputid']))
			{
				if (($_REQUEST['productoutputid'] !== '0') && ($_REQUEST['productoutputid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productoutputid in (".$_REQUEST['productoutputid'].")";
					}
					else
					{
						$where .= " and a0.productoutputid in (".$_REQUEST['productoutputid'].")";
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
			'keyField'=>'productoutputid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productoutputid','productoutputno','productoutputdate','productplanid','description','recordstatus','companyid'
				),
				'defaultOrder' => array( 
					'productoutputid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['productoutputid']))
		{
			$this->sqlcountproductoutputfg .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$this->sqldataproductoutputfg .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$count = Yii::app()->db->createCommand($this->sqlcountproductoutputfg)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldataproductoutputfg .= " limit 0";
		}
		$countproductoutputfg = $count;
		$dataProviderproductoutputfg=new CSqlDataProvider($this->sqldataproductoutputfg,array(
					'totalItemCount'=>$countproductoutputfg,
					'keyField'=>'productoutputfgid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'productoutputfgid' => CSort::SORT_DESC
						),
					),
					));
		if (isset($_REQUEST['productoutputid']))
		{
			$this->sqlcountproductoutputdetail .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$this->sqldataproductoutputdetail .= ' where a0.productoutputid = '.$_REQUEST['productoutputid'];
			$count = Yii::app()->db->createCommand($this->sqlcountproductoutputdetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldataproductoutputdetail .= " limit 0";
		}
		$countproductoutputdetail = $count;
		$dataProviderproductoutputdetail=new CSqlDataProvider($this->sqldataproductoutputdetail,array(
			'totalItemCount'=>$countproductoutputdetail,
			'keyField'=>'productoutputdetailid',
			'pagination'=>$pagination,
			'sort'=>array(
				'defaultOrder' => array( 
					'productoutputdetailid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderproductoutputfg'=>$dataProviderproductoutputfg,'dataProviderproductoutputdetail'=>$dataProviderproductoutputdetail));
	}
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into productoutput (recordstatus) values (".$this->findstatusbyuser('insop').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'productoutputid'=>$id,
			"productoutputdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insop")
		));
	}
  public function actionCreateproductoutputfg()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qtyoutput" =>0,
      "outputdate" =>date("Y-m-d")
		));
	}
  public function actionCreateproductoutputdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productoutputid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'productoutputid'=>$model['productoutputid'],
          'productoutputdate'=>$model['productoutputdate'],
          'productplanid'=>$model['productplanid'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'productplanno'=>$model['productplanno'],

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
	public function actionUpdateproductoutputfg()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductoutputfg.' where productoutputfgid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productoutputfgid'=>$model['productoutputfgid'],
          'productoutputid'=>$model['productoutputid'],
          'productplanfgid'=>$model['productplanfgid'],
          'productid'=>$model['productid'],
          'qtyoutput'=>$model['qtyoutput'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'outputdate'=>$model['outputdate'],
          'description'=>$model['description'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'storagedesc'=>$model['storagedesc'],

				));
				Yii::app()->end();
			}
		}
	}
  public function actionUpdateproductoutputdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataproductoutputdetail.' where productoutputdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productoutputdetailid'=>$model['productoutputdetailid'],
          'productoutputid'=>$model['productoutputid'],
          'productoutputfgid'=>$model['productoutputfgid'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'toslocid'=>$model['toslocid'],
          'storagebinid'=>$model['storagebinid'],
          'productplandetailid'=>$model['productplandetailid'],
          'productplanfgid'=>$model['productplanfgid'],
          'description'=>$model['description'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'storagedesc'=>$model['storagedesc'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionGeneratepp()
	{
		if(isset($_POST['id']))
		{
			if($_POST['id'] !== '')
			{
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					$sql = 'call GenerateOPPP(:vid, :vhid)';
					$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
					$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
					$command->execute();
					$transaction->commit();
					$this->getMessage('success','datagenerated');
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$transaction->rollBack();
					$this->getMessage('failure',$e->getMessage());
				}
			}
		}
		Yii::app()->end();
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productoutputdate','string','emptyproductoutputdate'),
      array('productplanid','string','emptyproductplanid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productoutputid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateProductOutput (:productoutputid
,:productoutputdate
,:productplanid
,:description
,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':productoutputid',$_POST['productoutputid'],PDO::PARAM_STR);
				$command->bindvalue(':productoutputdate',(($_POST['productoutputdate']!=='')?$_POST['productoutputdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':productplanid',(($_POST['productplanid']!=='')?$_POST['productplanid']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
	public function actionSaveproductoutputfg()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productoutputid','string','emptyproductoutputid'),
      array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productoutputfgid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateproductoutputfg(:vid,:vproductoutputid,:vproductid,:vqty,:vuomid,:vslocid,:vstoragebinid,:voutputdate,:vdescription,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertproductoutputfg(:vproductoutputid,:vproductid,:vqty,:vuomid,:vslocid,:vstoragebinid,:voutputdate,:vdescription,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['productoutputfgid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vproductoutputid',(($_POST['productoutputid']!=='')?$_POST['productoutputid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vqty',(($_POST['qtyoutput']!=='')?$_POST['qtyoutput']:null),PDO::PARAM_STR);
        $command->bindvalue(':vuomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vslocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vstoragebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':voutputdate',(($_POST['outputdate']!=='')?$_POST['outputdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':vdescription',$_POST['description'],PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
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
	public function actionSaveproductoutputdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('toslocid','string','emptytoslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['productoutputdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update productoutputdetail 
			      set productoutputid = :productoutputid,productoutputfgid = :productoutputfgid,productid = :productid,qty = :qty,uomid = :uomid,toslocid = :toslocid,storagebinid = :storagebinid,productplandetailid = :productplandetailid,productplanfgid = :productplanfgid,description = :description 
			      where productoutputdetailid = :productoutputdetailid';
				}
				else
				{
					$sql = 'insert into productoutputdetail (productoutputid,productoutputfgid,productid,qty,uomid,toslocid,storagebinid,productplandetailid,productplanfgid,description) 
			      values (:productoutputid,:productoutputfgid,:productid,:qty,:uomid,:toslocid,:storagebinid,:productplandetailid,:productplanfgid,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':productoutputdetailid',$_POST['productoutputdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productoutputid',(($_POST['productoutputid']!=='')?$_POST['productoutputid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productoutputfgid',(($_POST['productoutputfgid']!=='')?$_POST['productoutputfgid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':toslocid',(($_POST['toslocid']!=='')?$_POST['toslocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productplandetailid',(($_POST['productplandetailid']!=='')?$_POST['productplandetailid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productplanfgid',(($_POST['productplanfgid']!=='')?$_POST['productplanfgid']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
			foreach($id as $ids)
			{
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					$sql = 'call ApproveOP(:vid,:vcreatedby)';
					$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
					$transaction->commit();
					$this->GetMessage('success','alreadysaved',1);
				}
				catch (Exception $e)
				{
					$transaction->rollback();
					$this->GetMessage('error',$e->getMessage(),1);
				}
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
				$sql = 'call Deleteproductoutput(:vid,:vcreatedby)';
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
				$sql = "delete from productoutput where productoutputid = ".$id[$i];
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
	public function actionPurgeproductoutputfg()
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
				$sql = "delete from productoutputfg where productoutputfgid = ".$id[$i];
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
	public function actionPurgeproductoutputdetail()
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
				$sql = "delete from productoutputdetail where productoutputdetailid = ".$id[$i];
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
		$sql = "select a.*,b.productplanno,b.productplandate
      from productoutput a 
	join productplan b on b.productplanid = a.productplanid ";
		if ($_REQUEST['productoutputid'] !== '') {
				$sql = $sql . "where a.productoutputid in (".$_REQUEST['productoutputid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
	  $this->pdf->title=$this->getcatalog('productoutput');
	  $this->pdf->AddPage('P');
		$this->pdf->AliasNBPages();
	  // definisi font  

    foreach($dataReader as $row)
    {
			$this->pdf->SetFont('Arial','',10);
      $this->pdf->text(15,$this->pdf->gety()+5,'No Output ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['productoutputno']);
	$this->pdf->text(120,$this->pdf->gety()+5,'No Plan ');$this->pdf->text(140,$this->pdf->gety()+5,': '.$row['productplanno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Tgl Output ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productoutputdate'])));
      $this->pdf->text(120,$this->pdf->gety()+10,'Tgl Plan ');$this->pdf->text(140,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['productplandate'])));

      $sql1 = "select b.productname, a.qtyoutput as qty, c.uomcode, a.description,
			concat(d.sloccode,'-',d.description) as sloccode, 
			e.description as rak
        from productoutputfg a
        inner join product b on b.productid = a.productid
        inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				inner join sloc d on d.slocid = a.slocid
				inner join storagebin e on e.storagebinid = a.storagebinid
        where productoutputid = ".$row['productoutputid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,30,20,35,15));
			$this->pdf->colheader = array('No','Items','Qty','Unit','Gudang','Rak');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
						$row1['sloccode'],
						$row1['rak']));
      }
      $this->pdf->checkPagebreak(40);
      $this->pdf->setFont('Arial','',10);
      $this->pdf->text(10,$this->pdf->gety()+25,'Approved By');$this->pdf->text(150,$this->pdf->gety()+25,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+45,'____________ ');$this->pdf->text(150,$this->pdf->gety()+45,'____________');
			/*$this->pdf->AddPage($this->pdf->CurOrientation);*/
			}
	  $this->pdf->Output();
	}
	public function actionDownxls()
  {
    $this->menuname = 'productoutput';
    parent::actionDownxls();
    $sql = "select a.*,b.productplanno,b.productplandate
            from productoutput a 
	        join productplan b on b.productplanid = a.productplanid ";
    if ($_GET['productoutputid'] !== '') {
      $sql = $sql . "where a.productoutputid in (" . $_GET['productoutputid'] . ")";
    }
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $line       = 5;
    foreach ($dataReader as $row) {
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, 3, 'No Output')
          ->setCellValueByColumnAndRow(2, 3, ': ' . $row['productoutputno'])
          ->setCellValueByColumnAndRow(1, 4, 'Tgl Output')
          ->setCellValueByColumnAndRow(2, 4, ': ' . $row['productplandate'])
          ->setCellValueByColumnAndRow(4, 3, 'No Plan')
          ->setCellValueByColumnAndRow(5, 3, ': ' . $row['productplanno']) 
          ->setCellValueByColumnAndRow(4, 4, 'Tgl Plan')
          ->setCellValueByColumnAndRow(5, 4, ': ' . $row['productplandate']);
      $line++;
      $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(0, $line, 'No')
          ->setCellValueByColumnAndRow(1, $line, 'Items')
          ->setCellValueByColumnAndRow(3, $line, 'Qty')
          ->setCellValueByColumnAndRow(4, $line, 'Unit')
          ->setCellValueByColumnAndRow(5, $line, 'Gudang')
          ->setCellValueByColumnAndRow(6, $line, 'Rak');
      $line++;
      $sql1        = "select b.productname, a.qtyoutput as qty, c.uomcode, a.description,
			concat(d.sloccode,'-',d.description) as sloccode, 
			e.description as rak
            from productoutputfg a
                inner join product b on b.productid = a.productid
                inner join unitofmeasure c on c.unitofmeasureid = a.uomid
				inner join sloc d on d.slocid = a.slocid
				inner join storagebin e on e.storagebinid = a.storagebinid
        where productoutputid = " . $row['productoutputid'];
      $dataReader1 = Yii::app()->db->createCommand($sql1)->queryAll();
      $i           = 0;
      foreach ($dataReader1 as $row1) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0, $line, $i += 1)
            ->setCellValueByColumnAndRow(1, $line, $row1['productname'])
            ->setCellValueByColumnAndRow(3, $line, $row1['qty'])
            ->setCellValueByColumnAndRow(4, $line, $row1['uomcode'])
            ->setCellValueByColumnAndRow(5, $line, $row1['sloccode'])
            ->setCellValueByColumnAndRow(6, $line, $row1['rak']);
       
$sql2        = "SELECT DISTINCT t.*,a.productname,b.uomcode,
					(select sloccode from sloc zz where zz.slocid = t.fromslocid) as fromsloccode,
			(select description from sloc zz where zz.slocid = t.fromslocid) as fromslocdesc,
			(select sloccode from sloc zz where zz.slocid = t.toslocid) as tosloccode,
			(select description from sloc zz where zz.slocid = t.toslocid) as toslocdesc,
			d.description as rak,
			getstock(t.productid,t.uomid,t.fromslocid) as fromslocstock,
			getstock(t.productid,t.uomid,t.toslocid) as toslocstock,
			getminstockmrp(t.productid,t.uomid,t.fromslocid) as minfromstock,
			getminstockmrp(t.productid,t.uomid,t.toslocid) as mintostock
FROM productoutputdetail t
LEFT JOIN productoutputfg c ON c.productoutputfgid = t.productoutputfgid
LEFT JOIN product a ON a.productid = t.productid
LEFT JOIN unitofmeasure b ON b.unitofmeasureid = t.uomid
LEFT JOIN storagebin d ON d.storagebinid = t.storagebinid 

 where t.productoutputid = " . $row['productoutputid'] ;
      $dataReader2 = Yii::app()->db->createCommand($sql2)->queryAll();
      $c           = 0;
      $line++; 
            $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, $line, 'Material/Service - FG');
      $line++;  
          $this->phpExcel->setActiveSheetIndex(0)
          ->setCellValueByColumnAndRow(1, $line, 'No')
          ->setCellValueByColumnAndRow(2, $line, 'Items')
          ->setCellValueByColumnAndRow(3, $line, 'Qty')
          ->setCellValueByColumnAndRow(4, $line, 'Unit')
          ->setCellValueByColumnAndRow(5, $line, 'Gudang Asal')
          ->setCellValueByColumnAndRow(6, $line, 'Stock Gd Asal')
          ->setCellValueByColumnAndRow(7, $line, 'Stock Gd Tujuan')
          ->setCellValueByColumnAndRow(8, $line, 'Rak');
      $line++;
      foreach ($dataReader2 as $row2) {
        $this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $line, $c += 1)
            ->setCellValueByColumnAndRow(2, $line, $row2['productname'])
            ->setCellValueByColumnAndRow(3, $line, $row2['qty'])
            ->setCellValueByColumnAndRow(4, $line, $row2['uomcode'])
            ->setCellValueByColumnAndRow(5, $line, $row2['fromsloccode'])
            ->setCellValueByColumnAndRow(6, $line, $row2['fromslocstock'])
            ->setCellValueByColumnAndRow(7, $line, $row2['toslocstock'])
            ->setCellValueByColumnAndRow(8, $line, $row2['rak']);
        $line++;
      }
      }
     
      $line += 2;
      $this->phpExcel->setActiveSheetIndex(0)
      ->setCellValueByColumnAndRow(1, $line, 'Approved By')
      ->setCellValueByColumnAndRow(4, $line, 'Proposed By');
      
    $line += 4;
    $this->phpExcel->setActiveSheetIndex(0)    
      ->setCellValueByColumnAndRow(1,$line, '____________ ')
      ->setCellValueByColumnAndRow(4, $line, '____________ ');
    }
    $this->getFooterXLS($this->phpExcel);
  }
}