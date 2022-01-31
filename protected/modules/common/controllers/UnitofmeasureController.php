<?php

class UnitofmeasureController extends AdminController
{
	protected $menuname = 'unitofmeasure';
	public $module = 'Common';
	protected $pageTitle = 'Satuan';
	public $wfname = '';
	protected $sqldata = "select a0.unitofmeasureid,a0.uomcode,a0.description,a0.recordstatus 
    from unitofmeasure a0 
  ";
  protected $sqlcount = "select count(1) 
    from unitofmeasure a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['uomcode'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.uomcode like '%". $_REQUEST['uomcode']."%' 
and a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['unitofmeasureid']))
			{
				if (($_REQUEST['unitofmeasureid'] !== '0') && ($_REQUEST['unitofmeasureid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.unitofmeasureid in (".$_REQUEST['unitofmeasureid'].")";
					}
					else
					{
						$where .= " and a0.unitofmeasureid in (".$_REQUEST['unitofmeasureid'].")";
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
			'keyField'=>'unitofmeasureid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'unitofmeasureid','uomcode','description','recordstatus'
				),
				'defaultOrder' => array( 
					'unitofmeasureid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.unitofmeasureid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'unitofmeasureid'=>$model['unitofmeasureid'],
          'uomcode'=>$model['uomcode'],
          'description'=>$model['description'],
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
			array('uomcode','string','emptyuomcode'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['unitofmeasureid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update unitofmeasure 
			      set uomcode = :uomcode,description = :description,recordstatus = :recordstatus 
			      where unitofmeasureid = :unitofmeasureid';
				}
				else
				{
					$sql = 'insert into unitofmeasure (uomcode,description,recordstatus) 
			      values (:uomcode,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':unitofmeasureid',$_POST['unitofmeasureid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':uomcode',(($_POST['uomcode']!=='')?$_POST['uomcode']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from unitofmeasure where unitofmeasureid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update unitofmeasure set recordstatus = 0 where unitofmeasureid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update unitofmeasure set recordstatus = 1 where unitofmeasureid = ".$id[$i];
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
				$sql = "delete from unitofmeasure where unitofmeasureid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('unitofmeasure');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('unitofmeasureid'),$this->getCatalog('uomcode'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['unitofmeasureid'],$row1['uomcode'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('unitofmeasureid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['unitofmeasureid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}