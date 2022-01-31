<?php

class WorkflowController extends AdminController
{
	protected $menuname = 'workflow';
	public $module = 'Admin';
	protected $pageTitle = 'Alur Dokumen';
	public $wfname = '';
	protected $sqldata = "select a0.workflowid,a0.wfname,a0.wfdesc,a0.wfminstat,a0.wfmaxstat,a0.recordstatus 
    from workflow a0 
  ";
  protected $sqlcount = "select count(1) 
    from workflow a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['wfname'])) && (isset($_REQUEST['wfdesc'])))
		{				
			$where .= " where a0.wfname like '%". $_REQUEST['wfname']."%' 
and a0.wfdesc like '%". $_REQUEST['wfdesc']."%'"; 
		}
		if (isset($_REQUEST['workflowid']))
			{
				if (($_REQUEST['workflowid'] !== '0') && ($_REQUEST['workflowid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.workflowid in (".$_REQUEST['workflowid'].")";
					}
					else
					{
						$where .= " and a0.workflowid in (".$_REQUEST['workflowid'].")";
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
			'keyField'=>'workflowid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'workflowid','wfname','wfdesc','wfminstat','wfmaxstat','recordstatus'
				),
				'defaultOrder' => array( 
					'workflowid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.workflowid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'workflowid'=>$model['workflowid'],
          'wfname'=>$model['wfname'],
          'wfdesc'=>$model['wfdesc'],
          'wfminstat'=>$model['wfminstat'],
          'wfmaxstat'=>$model['wfmaxstat'],
          'recordstatus'=>$model['recordstatus'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('wfname','string','emptywfname'),
      array('wfdesc','string','emptywfdesc'),
      array('wfminstat','string','emptywfminstat'),
      array('wfmaxstat','string','emptywfmaxstat'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['workflowid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update workflow 
			      set wfname = :wfname,wfdesc = :wfdesc,wfminstat = :wfminstat,wfmaxstat = :wfmaxstat,recordstatus = :recordstatus 
			      where workflowid = :workflowid';
				}
				else
				{
					$sql = 'insert into workflow (wfname,wfdesc,wfminstat,wfmaxstat,recordstatus) 
			      values (:wfname,:wfdesc,:wfminstat,:wfmaxstat,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':workflowid',$_POST['workflowid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':wfname',(($_POST['wfname']!=='')?$_POST['wfname']:null),PDO::PARAM_STR);
        $command->bindvalue(':wfdesc',(($_POST['wfdesc']!=='')?$_POST['wfdesc']:null),PDO::PARAM_STR);
        $command->bindvalue(':wfminstat',(($_POST['wfminstat']!=='')?$_POST['wfminstat']:null),PDO::PARAM_STR);
        $command->bindvalue(':wfmaxstat',(($_POST['wfmaxstat']!=='')?$_POST['wfmaxstat']:null),PDO::PARAM_STR);
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
				
	
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from workflow where workflowid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update workflow set recordstatus = 0 where workflowid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update workflow set recordstatus = 1 where workflowid = ".$id[$i];
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
				$sql = "delete from workflow where workflowid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('workflow');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('workflowid'),$this->getCatalog('wfname'),$this->getCatalog('wfdesc'),$this->getCatalog('wfminstat'),$this->getCatalog('wfmaxstat'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['workflowid'],$row1['wfname'],$row1['wfdesc'],$row1['wfminstat'],$row1['wfmaxstat'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('workflowid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('wfname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('wfdesc'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('wfminstat'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('wfmaxstat'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['workflowid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['wfname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['wfdesc'])
->setCellValueByColumnAndRow(3, $i+1, $row1['wfminstat'])
->setCellValueByColumnAndRow(4, $i+1, $row1['wfmaxstat'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}