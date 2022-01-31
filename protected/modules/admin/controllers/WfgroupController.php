<?php

class WfgroupController extends AdminController
{
	protected $menuname = 'wfgroup';
	public $module = 'Admin';
	protected $pageTitle = 'Otorisasi Dokumen';
	public $wfname = '';
	protected $sqldata = "select a0.wfgroupid,a0.workflowid,a0.groupaccessid,a0.wfbefstat,a0.wfrecstat,a1.wfdesc,a2.groupname
    from wfgroup a0
    left join workflow a1 on a1.workflowid = a0.workflowid
    left join groupaccess a2 on a2.groupaccessid = a0.groupaccessid
  ";
  protected $sqlcount = "select count(1) 
    from wfgroup a0
    left join workflow a1 on a1.workflowid = a0.workflowid
    left join groupaccess a2 on a2.groupaccessid = a0.groupaccessid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['wfdesc'])) && (isset($_REQUEST['groupname'])))
		{				
			$where .= " where a2.groupname like '%". $_REQUEST['groupname']."%' 
and a1.wfdesc like '%". $_REQUEST['wfdesc']."%'"; 
		}
		if (isset($_REQUEST['wfgroupid']))
			{
				if (($_REQUEST['wfgroupid'] !== '0') && ($_REQUEST['wfgroupid'] !== ''))
				{
					$where .= " and a0.wfgroupid in (".$_REQUEST['wfgroupid'].")";
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
			'keyField'=>'wfgroupid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'wfgroupid','groupname','wfdesc','wfbefstat','wfrecstat'
				),
				'defaultOrder' => array( 
					'wfgroupid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where wfgroupid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
				'status'=>'success',
				'wfgroupid'=>$model['wfgroupid'],
		        'groupaccessid'=>$model['groupaccessid'],
		        'groupname'=>$model['groupname'],
		        'workflowid'=>$model['workflowid'],
		        'wfdesc'=>$model['wfdesc'],
		        'wfbefstat'=>$model['wfbefstat'],
		        'wfrecstat'=>$model['wfrecstat'],

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
      		array('groupaccessid','string','emptygroupaccessid'),
    ));
		if ($error == false)
		{
			$id = $_POST['wfgroupid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update wfgroup 
			      set workflowid = :workflowid, groupaccessid = :groupaccessid, wfbefstat = :wfbefstat, 
			      wfrecstat = :wfrecstat
			      where wfgroupid = :wfgroupid';
				}
				else
				{
					$sql = 'insert wfgroup (workflowid, groupaccessid, wfbefstat, wfrecstat) 
			      	values (:workflowid, :groupaccessid, :wfbefstat, :wfrecstat)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
				$command->bindvalue(':wfgroupid',$_POST['wfgroupid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':workflowid',(($_POST['workflowid']!=='')?$_POST['workflowid']:null),PDO::PARAM_STR);
        		$command->bindvalue(':groupaccessid',(($_POST['groupaccessid']!=='')?$_POST['groupaccessid']:null),PDO::PARAM_STR);
        		$command->bindvalue(':wfbefstat',(($_POST['wfbefstat']!=='')?$_POST['wfbefstat']:null),PDO::PARAM_STR);
        		$command->bindvalue(':wfrecstat',(($_POST['wfrecstat']!=='')?$_POST['wfrecstat']:null),PDO::PARAM_STR);
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
				$sql = "delete from wfgroup where wfgroupid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('wfgroup');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('wfgroupid'),$this->getCatalog('wfdesc'),$this->getCatalog('groupname'),$this->getCatalog('wfbefstat'),$this->getCatalog('wfrecstat'));
		$this->pdf->setwidths(array(12,40,40,15,15,15,15,15,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['wfgroupid'],$row1['wfdesc'],$row1['groupname'],$row1['wfbefstat'],$row1['wfrecstat']
				));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	/*
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('wfgroupid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['groupaccessid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}*/
}