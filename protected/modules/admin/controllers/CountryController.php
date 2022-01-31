<?php

class CountryController extends AdminController
{
	protected $menuname = 'country';
	public $module = 'Admin';
	protected $pageTitle = 'Negara';
	public $wfname = '';
	protected $sqldata = "select a0.countryid,a0.countrycode,a0.countryname,a0.recordstatus 
    from country a0 
  ";
  protected $sqlcount = "select count(1) 
    from country a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['countrycode'])) && (isset($_REQUEST['countryname'])))
		{				
			$where .= " where a0.countrycode like '%". $_REQUEST['countrycode']."%' 
and a0.countryname like '%". $_REQUEST['countryname']."%'"; 
		}
		if (isset($_REQUEST['countryid']))
			{
				if (($_REQUEST['countryid'] !== '0') && ($_REQUEST['countryid'] !== ''))
				{
					$where .= " and a0.countryid in (".$_REQUEST['countryid'].")";
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
			'keyField'=>'countryid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'countryid','countrycode','countryname','recordstatus'
				),
				'defaultOrder' => array( 
					'countryid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.countryid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'countryid'=>$model['countryid'],
          'countrycode'=>$model['countrycode'],
          'countryname'=>$model['countryname'],
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
			array('countrycode','string','emptycountrycode'),
      array('countryname','string','emptycountryname'),
    ));
		if ($error == false)
		{
			$id = $_POST['countryid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update country 
			      set countrycode = :countrycode,countryname = :countryname,recordstatus = :recordstatus 
			      where countryid = :countryid';
				}
				else
				{
					$sql = 'insert into country (countrycode,countryname,recordstatus) 
			      values (:countrycode,:countryname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':countryid',$_POST['countryid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':countrycode',(($_POST['countrycode']!=='')?$_POST['countrycode']:null),PDO::PARAM_STR);
        $command->bindvalue(':countryname',(($_POST['countryname']!=='')?$_POST['countryname']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from country where countryid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update country set recordstatus = 0 where countryid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update country set recordstatus = 1 where countryid = ".$id[$i];
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
				$sql = "delete from country where countryid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('country');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('countryid'),$this->getCatalog('countrycode'),$this->getCatalog('countryname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,120,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['countryid'],$row1['countrycode'],$row1['countryname'],(($row1['recordstatus'] == 1)?'Active':'NotActive')));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('countryid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('countrycode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('countryname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['countryid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['countrycode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['countryname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}