<?php

class PurchasinggroupController extends AdminController
{
	protected $menuname = 'purchasinggroup';
	public $module = 'Purchasing';
	protected $pageTitle = 'Grup Pembelian';
	public $wfname = '';
	protected $sqldata = "select a0.purchasinggroupid,a0.purchasingorgid,a0.purchasinggroupcode,a0.description,a0.recordstatus,a1.purchasingorgcode as purchasingorgcode 
    from purchasinggroup a0 
    left join purchasingorg a1 on a1.purchasingorgid = a0.purchasingorgid
  ";
  protected $sqlcount = "select count(1) 
    from purchasinggroup a0 
    left join purchasingorg a1 on a1.purchasingorgid = a0.purchasingorgid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['purchasinggroupcode'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['purchasingorgcode'])))
		{				
			$where .= " where a0.purchasinggroupcode like '%". $_REQUEST['purchasinggroupcode']."%' 
and a0.description like '%". $_REQUEST['description']."%' 
and a1.purchasingorgcode like '%". $_REQUEST['purchasingorgcode']."%'"; 
		}
		if (isset($_REQUEST['purchasinggroupid']))
			{
				if (($_REQUEST['purchasinggroupid'] !== '0') && ($_REQUEST['purchasinggroupid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.purchasinggroupid in (".$_REQUEST['purchasinggroupid'].")";
					}
					else
					{
						$where .= " and a0.purchasinggroupid in (".$_REQUEST['purchasinggroupid'].")";
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
			'keyField'=>'purchasinggroupid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'purchasinggroupid','purchasingorgid','purchasinggroupcode','description','recordstatus'
				),
				'defaultOrder' => array( 
					'purchasinggroupid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.purchasinggroupid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'purchasinggroupid'=>$model['purchasinggroupid'],
          'purchasingorgid'=>$model['purchasingorgid'],
          'purchasinggroupcode'=>$model['purchasinggroupcode'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'purchasingorgcode'=>$model['purchasingorgcode'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('purchasingorgid','string','emptypurchasingorgid'),
      array('purchasinggroupcode','string','emptypurchasinggroupcode'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['purchasinggroupid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update purchasinggroup 
			      set purchasingorgid = :purchasingorgid,purchasinggroupcode = :purchasinggroupcode,description = :description,recordstatus = :recordstatus 
			      where purchasinggroupid = :purchasinggroupid';
				}
				else
				{
					$sql = 'insert into purchasinggroup (purchasingorgid,purchasinggroupcode,description,recordstatus) 
			      values (:purchasingorgid,:purchasinggroupcode,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':purchasinggroupid',$_POST['purchasinggroupid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':purchasingorgid',(($_POST['purchasingorgid']!=='')?$_POST['purchasingorgid']:null),PDO::PARAM_STR);
        $command->bindvalue(':purchasinggroupcode',(($_POST['purchasinggroupcode']!=='')?$_POST['purchasinggroupcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from purchasinggroup where purchasinggroupid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update purchasinggroup set recordstatus = 0 where purchasinggroupid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update purchasinggroup set recordstatus = 1 where purchasinggroupid = ".$id[$i];
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
				$sql = "delete from purchasinggroup where purchasinggroupid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('purchasinggroup');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('purchasinggroupid'),$this->getCatalog('purchasingorg'),$this->getCatalog('purchasinggroupcode'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['purchasinggroupid'],$row1['purchasingorgcode'],$row1['purchasinggroupcode'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('purchasinggroupid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('purchasingorgcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('purchasinggroupcode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['purchasinggroupid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['purchasingorgcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['purchasinggroupcode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}