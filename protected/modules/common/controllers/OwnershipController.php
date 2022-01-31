<?php

class OwnershipController extends AdminController
{
	protected $menuname = 'ownership';
	public $module = 'Common';
	protected $pageTitle = 'Kepemilikan Barang';
	public $wfname = '';
	protected $sqldata = "select a0.ownershipid,a0.ownershipname,a0.recordstatus 
    from ownership a0 
  ";
  protected $sqlcount = "select count(1) 
    from ownership a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['ownershipname'])))
		{				
			$where .= " where a0.ownershipname like '%". $_REQUEST['ownershipname']."%'"; 
		}
		if (isset($_REQUEST['ownershipid']))
			{
				if (($_REQUEST['ownershipid'] !== '0') && ($_REQUEST['ownershipid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.ownershipid in (".$_REQUEST['ownershipid'].")";
					}
					else
					{
						$where .= " and a0.ownershipid in (".$_REQUEST['ownershipid'].")";
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
			'keyField'=>'ownershipid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'ownershipid','ownershipname','recordstatus'
				),
				'defaultOrder' => array( 
					'ownershipid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.ownershipid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'ownershipid'=>$model['ownershipid'],
          'ownershipname'=>$model['ownershipname'],
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
			array('ownershipname','string','emptyownershipname'),
    ));
		if ($error == false)
		{
			$id = $_POST['ownershipid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update ownership 
			      set ownershipname = :ownershipname,recordstatus = :recordstatus 
			      where ownershipid = :ownershipid';
				}
				else
				{
					$sql = 'insert into ownership (ownershipname,recordstatus) 
			      values (:ownershipname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':ownershipid',$_POST['ownershipid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':ownershipname',(($_POST['ownershipname']!=='')?$_POST['ownershipname']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from ownership where ownershipid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update ownership set recordstatus = 0 where ownershipid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update ownership set recordstatus = 1 where ownershipid = ".$id[$i];
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
				$sql = "delete from ownership where ownershipid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('ownership');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('ownershipid'),$this->getCatalog('ownershipname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['ownershipid'],$row1['ownershipname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('ownershipid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('ownershipname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['ownershipid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['ownershipname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}