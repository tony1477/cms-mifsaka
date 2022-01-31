<?php

class SalesplanController extends AdminController
{
	protected $menuname = 'salesplan';
	public $module = 'Order';
	protected $pageTitle = 'Rencana Kunjungan Sales';
	public $wfname = 'appsalesplan';
	protected $sqldata = "select a0.salesplanid,a0.salesplanno,a0.companyid,a0.employeeid,a0.plandate,a0.recordstatus,a1.companyname as companyname,a2.fullname as salesname,getwfstatusbywfname('appsalesplan',a0.recordstatus) as statusname  
    from salesplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
protected $sqldatasalesplandet = "select a0.salesplandetid,a0.salesplanid,a0.addressbookid,a0.plandesc,a0.plandatetime,a1.fullname as customername 
    from salesplandet a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
  ";
  protected $sqlcount = "select count(1) 
    from salesplan a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
protected $sqlcountsalesplandet = "select count(1) 
    from salesplandet a0 
    left join addressbook a1 on a1.addressbookid = a0.addressbookid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['salesplanno'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['salesname'])))
		{				
			$where .=  " 
and a0.salesplanno like '%". $_REQUEST['salesplanno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.fullname like '%". $_REQUEST['salesname']."%'"; 
		}
		if (isset($_REQUEST['salesplanid']))
			{
				if (($_REQUEST['salesplanid'] !== '0') && ($_REQUEST['salesplanid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.salesplanid in (".$_REQUEST['salesplanid'].")";
					}
					else
					{
						$where .= " and a0.salesplanid in (".$_REQUEST['salesplanid'].")";
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
			'keyField'=>'salesplanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'salesplanid','salesplanno','companyid','employeeid','plandate','recordstatus'
				),
				'defaultOrder' => array( 
					'salesplanid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['salesplanid']))
		{
			$this->sqlcountsalesplandet .= ' where a0.salesplanid = '.$_REQUEST['salesplanid'];
			$this->sqldatasalesplandet .= ' where a0.salesplanid = '.$_REQUEST['salesplanid'];
		}
		$countsalesplandet = Yii::app()->db->createCommand($this->sqlcountsalesplandet)->queryScalar();
$dataProvidersalesplandet=new CSqlDataProvider($this->sqldatasalesplandet,array(
					'totalItemCount'=>$countsalesplandet,
					'keyField'=>'salesplandetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'salesplandetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersalesplandet'=>$dataProvidersalesplandet));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into salesplan (recordstatus) values (".$this->findstatusbyuser('inssalesplan').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'salesplanid'=>$id,
			"plandate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("inssalesplan")
		));
	}
  public function actionCreatesalesplandet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"plandatetime" =>date("Y-m-d H:i:s")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.salesplanid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'salesplanid'=>$model['salesplanid'],
          'companyid'=>$model['companyid'],
          'employeeid'=>$model['employeeid'],
          'plandate'=>$model['plandate'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'salesname'=>$model['salesname'],

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

  public function actionUpdatesalesplandet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasalesplandet.' where salesplandetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'salesplandetid'=>$model['salesplandetid'],
          'salesplanid'=>$model['salesplanid'],
          'addressbookid'=>$model['addressbookid'],
          'plandesc'=>$model['plandesc'],
          'plandatetime'=>$model['plandatetime'],
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
			array('companyid','string','emptycompanyid'),
      array('employeeid','string','emptyemployeeid'),
      array('plandate','string','emptyplandate'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesplanid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call  Updatesalesplan (:salesplanid
,:companyid
,:employeeid
,:plandate
,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':salesplanid',$_POST['salesplanid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':plandate',(($_POST['plandate']!=='')?$_POST['plandate']:null),PDO::PARAM_STR);
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
public function actionSavesalesplandet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('salesplanid','string','emptysalesplanid'),
      array('addressbookid','string','emptyaddressbookid'),
      array('plandesc','string','emptyplandesc'),
      array('plandatetime','string','emptyplandatetime'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesplandetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update salesplandet 
			      set salesplanid = :salesplanid,addressbookid = :addressbookid,plandesc = :plandesc,plandatetime = :plandatetime 
			      where salesplandetid = :salesplandetid';
				}
				else
				{
					$sql = 'insert into salesplandet (salesplanid,addressbookid,plandesc,plandatetime) 
			      values (:salesplanid,:addressbookid,:plandesc,:plandatetime)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':salesplandetid',$_POST['salesplandetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':salesplanid',(($_POST['salesplanid']!=='')?$_POST['salesplanid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':plandesc',(($_POST['plandesc']!=='')?$_POST['plandesc']:null),PDO::PARAM_STR);
        $command->bindvalue(':plandatetime',(($_POST['plandatetime']!=='')?$_POST['plandatetime']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvesalesplan(:vid,:vcreatedby)';
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
				$sql = 'call Deletesalesplan(:vid,:vcreatedby)';
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
				$sql = "delete from salesplan where salesplanid = ".$id[$i];
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
	}public function actionPurgesalesplandet()
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
				$sql = "delete from salesplandet where salesplandetid = ".$id[$i];
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
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('salesplan');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('salesplanid'),$this->getCatalog('salesplanno'),$this->getCatalog('company'),$this->getCatalog('employee'),$this->getCatalog('plandate'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['salesplanid'],$row1['salesplanno'],$row1['companyname'],$row1['fullname'],$row1['plandate'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('salesplanid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('salesplanno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('plandate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['salesplanid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['salesplanno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['plandate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}