<?php

class StandardopoutputController extends AdminController
{
	protected $menuname = 'standardopoutput';
	public $module = 'Production';
	protected $pageTitle = 'Standar Hasil Operator';
	public $wfname = 'AppStdOpOutput';
	protected $sqldata = "select a0.standardopoutputid,a0.slocid,a0.groupname,a0.standardvalue,a0.recordstatus,a1.sloccode as sloccode 
    from standardopoutput a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
  protected $sqlcount = "select count(1) 
    from standardopoutput a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['groupname'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .= " where a0.groupname like '%". $_REQUEST['groupname']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['standardopoutputid']))
			{
				if (($_REQUEST['standardopoutputid'] !== '0') && ($_REQUEST['standardopoutputid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.standardopoutputid in (".$_REQUEST['standardopoutputid'].")";
					}
					else
					{
						$where .= " and a0.standardopoutputid in (".$_REQUEST['standardopoutputid'].")";
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
			'keyField'=>'standardopoutputid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'standardopoutputid','slocid','groupname','standardvalue','recordstatus'
				),
				'defaultOrder' => array( 
					'standardopoutputid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"standardvalue" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.standardopoutputid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'standardopoutputid'=>$model['standardopoutputid'],
          'slocid'=>$model['slocid'],
          'groupname'=>$model['groupname'],
          'standardvalue'=>$model['standardvalue'],
          'recordstatus'=>$model['recordstatus'],
          'sloccode'=>$model['sloccode'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('slocid','string','emptyslocid'),
      array('groupname','string','emptygroupname'),
      array('standardvalue','string','emptystandardvalue'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['standardopoutputid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update standardopoutput 
			      set slocid = :slocid,groupname = :groupname,standardvalue = :standardvalue,recordstatus = :recordstatus 
			      where standardopoutputid = :standardopoutputid';
				}
				else
				{
					$sql = 'insert into standardopoutput (slocid,groupname,standardvalue,recordstatus) 
			      values (:slocid,:groupname,:standardvalue,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':standardopoutputid',$_POST['standardopoutputid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':groupname',(($_POST['groupname']!=='')?$_POST['groupname']:null),PDO::PARAM_STR);
        $command->bindvalue(':standardvalue',(($_POST['standardvalue']!=='')?$_POST['standardvalue']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from standardopoutput where standardopoutputid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update standardopoutput set recordstatus = 0 where standardopoutputid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update standardopoutput set recordstatus = 1 where standardopoutputid = ".$id[$i];
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
				$sql = "delete from standardopoutput where standardopoutputid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('standardopoutput');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('standardopoutputid'),$this->getCatalog('sloc'),$this->getCatalog('groupname'),$this->getCatalog('standardvalue'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['standardopoutputid'],$row1['slocid'],$row1['groupname'],$row1['standardvalue'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('standardopoutputid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('slocid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('standardvalue'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['standardopoutputid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['slocid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['standardvalue'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}