<?php

class TaxController extends AdminController
{
	protected $menuname = 'tax';
	public $module = 'Accounting';
	protected $pageTitle = 'Jenis Pajak';
	public $wfname = '';
	protected $sqldata = "select a0.taxid,a0.taxcode,a0.taxvalue,a0.description,a0.recordstatus 
    from tax a0 
  ";
  protected $sqlcount = "select count(1) 
    from tax a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['taxcode'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.taxcode like '%". $_REQUEST['taxcode']."%' 
and a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['taxid']))
			{
				if (($_REQUEST['taxid'] !== '0') && ($_REQUEST['taxid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.taxid in (".$_REQUEST['taxid'].")";
					}
					else
					{
						$where .= " and a0.taxid in (".$_REQUEST['taxid'].")";
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
			'keyField'=>'taxid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'taxid','taxcode','taxvalue','description','recordstatus'
				),
				'defaultOrder' => array( 
					'taxid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.taxid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'taxid'=>$model['taxid'],
          'taxcode'=>$model['taxcode'],
          'taxvalue'=>$model['taxvalue'],
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
			array('taxcode','string','emptytaxcode'),
      array('taxvalue','string','emptytaxvalue'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['taxid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update tax 
			      set taxcode = :taxcode,taxvalue = :taxvalue,description = :description,recordstatus = :recordstatus 
			      where taxid = :taxid';
				}
				else
				{
					$sql = 'insert into tax (taxcode,taxvalue,description,recordstatus) 
			      values (:taxcode,:taxvalue,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':taxid',$_POST['taxid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':taxcode',(($_POST['taxcode']!=='')?$_POST['taxcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxvalue',(($_POST['taxvalue']!=='')?$_POST['taxvalue']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from tax where taxid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update tax set recordstatus = 0 where taxid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update tax set recordstatus = 1 where taxid = ".$id[$i];
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
				$sql = "delete from tax where taxid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('tax');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('taxid'),$this->getCatalog('taxcode'),$this->getCatalog('taxvalue'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['taxid'],$row1['taxcode'],$row1['taxvalue'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('taxid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('taxcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('taxvalue'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['taxid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['taxcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['taxvalue'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}