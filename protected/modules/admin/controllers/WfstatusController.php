<?php

class WfstatusController extends AdminController
{
	protected $menuname = 'wfstatus';
	public $module = 'Admin';
	protected $pageTitle = 'Status Dokumen';
	public $wfname = '';
	protected $sqldata = "select a0.wfstatusid,a0.workflowid,a0.wfstat,a0.wfstatusname, a1.wfdesc as wfdesc
    from wfstatus a0 
    left join workflow a1 on a1.workflowid = a0.workflowid 
  ";
  protected $sqlcount = "select count(1) 
    from wfstatus a0 
    left join workflow a1 on a1.workflowid = a0.workflowid 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['wfstat'])) && (isset($_REQUEST['wfstatusname'])) && (isset($_REQUEST['wfdesc'])))
		{				
			$where .= " where a0.wfstat like '%". $_REQUEST['wfstat']."%' 
						and a1.wfdesc like '%". $_REQUEST['wfdesc']."%' 
						and a0.wfstatusname like '%". $_REQUEST['wfstatusname']."%'"; 
		}
		if (isset($_REQUEST['wfstatusid']))
			{
				if (($_REQUEST['wfstatusid'] !== '0') && ($_REQUEST['wfstatusid'] !== ''))
				{
					$where .= " and a0.wfstatusid in (".$_REQUEST['wfstatusid'].")";
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
			'keyField'=>'wfstatusid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'wfstatusid','workflowid','wfstatusname','wfstat'
				),
				'defaultOrder' => array( 
					'wfstatusid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where wfstatusid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'wfstatusid'=>$model['wfstatusid'],
		            'workflowid'=>$model['workflowid'],
		            'wfdesc'=>$model['wfdesc'],
		            'wfstatusname'=>$model['wfstatusname'],
		            'wfstat'=>$model['wfstat'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
	      array('workflowid','string','emptyworkflowid'),
	      array('wfstatusname','string','emptywfstatusname'),
	      array('wfstat','string','emptywfstat'),
    ));
		if ($error == false)
		{
			$id = $_POST['wfstatusid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update wfstatus 
			      set workflowid = :workflowid, wfstat = :wfstat, wfstatusname = :wfstatusname
			      where wfstatusid = :wfstatusid';
				}
				else
				{
					$sql = 'insert into wfstatus (workflowid,wfstat,wfstatusname) 
			      values (:workflowid,:wfstat,:wfstatusname)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':wfstatusid',$_POST['wfstatusid'],PDO::PARAM_STR);
				}
				
        $command->bindvalue(':workflowid',(($_POST['workflowid']!=='')?$_POST['workflowid']:null),PDO::PARAM_STR);
        $command->bindvalue(':wfstat',(($_POST['wfstat']!=='')?$_POST['wfstat']:null),PDO::PARAM_STR);
        $command->bindvalue(':wfstatusname',(($_POST['wfstatusname']!=='')?$_POST['wfstatusname']:null),PDO::PARAM_STR);
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
				
/*	
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
					$sql = "select recordstatus from wfstatus where wfstatusid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update wfstatus set recordstatus = 0 where wfstatusid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update wfstatus set recordstatus = 1 where wfstatusid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
	public function actionPurge()
	{
		parent::actionPurge();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from wfstatus where wfstatusid = ".$id[$i];
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('wfstatus');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('wfstatusid'),$this->getCatalog('workflow'),$this->getCatalog('wfstat'),$this->getCatalog('wfstatusname'));
		$this->pdf->setwidths(array(15,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['wfstatusid'],$row1['wfdesc'],$row1['wfstat'],
			$row1['wfstatusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('wfstatusid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('wfdesc'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('wfstat'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('wfstatusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['wfstatusid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['wfdesc'])
->setCellValueByColumnAndRow(3, $i+1, $row1['wfstat'])
->setCellValueByColumnAndRow(4, $i+1, $row1['wfstatusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}