<?php

class StoragebinController extends AdminController
{
	protected $menuname = 'storagebin';
	public $module = 'Common';
	protected $pageTitle = 'Rak';
	public $wfname = '';
	protected $sqldata = "select a0.storagebinid,a0.slocid,a0.description,a0.ismultiproduct,a0.qtymax,a0.recordstatus,a1.sloccode as sloccode 
    from storagebin a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";
  protected $sqlcount = "select count(1) 
    from storagebin a0 
    left join sloc a1 on a1.slocid = a0.slocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['description'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%' 
and a1.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['storagebinid']))
			{
				if (($_REQUEST['storagebinid'] !== '0') && ($_REQUEST['storagebinid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.storagebinid in (".$_REQUEST['storagebinid'].")";
					}
					else
					{
						$where .= " and a0.storagebinid in (".$_REQUEST['storagebinid'].")";
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
			'keyField'=>'storagebinid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'storagebinid','slocid','description','ismultiproduct','qtymax','recordstatus'
				),
				'defaultOrder' => array( 
					'storagebinid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"qtymax" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.storagebinid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'storagebinid'=>$model['storagebinid'],
          'slocid'=>$model['slocid'],
          'description'=>$model['description'],
          'ismultiproduct'=>$model['ismultiproduct'],
          'qtymax'=>$model['qtymax'],
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
      array('description','string','emptydescription'),
    ));
		if ($error == false)
		{
			$id = $_POST['storagebinid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update storagebin 
			      set slocid = :slocid,description = :description,ismultiproduct = :ismultiproduct,qtymax = :qtymax,recordstatus = :recordstatus 
			      where storagebinid = :storagebinid';
				}
				else
				{
					$sql = 'insert into storagebin (slocid,description,ismultiproduct,qtymax,recordstatus) 
			      values (:slocid,:description,:ismultiproduct,:qtymax,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':storagebinid',$_POST['storagebinid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':ismultiproduct',(($_POST['ismultiproduct']!=='')?$_POST['ismultiproduct']:null),PDO::PARAM_STR);
        $command->bindvalue(':qtymax',(($_POST['qtymax']!=='')?$_POST['qtymax']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from storagebin where storagebinid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update storagebin set recordstatus = 0 where storagebinid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update storagebin set recordstatus = 1 where storagebinid = ".$id[$i];
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
				$sql = "delete from storagebin where storagebinid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('storagebin');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('storagebinid'),$this->getCatalog('sloc'),$this->getCatalog('description'),$this->getCatalog('ismultiproduct'),$this->getCatalog('qtymax'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['storagebinid'],$row1['sloccode'],$row1['description'],$row1['ismultiproduct'],$row1['qtymax'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('storagebinid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('ismultiproduct'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('qtymax'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['storagebinid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['ismultiproduct'])
->setCellValueByColumnAndRow(4, $i+1, $row1['qtymax'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}