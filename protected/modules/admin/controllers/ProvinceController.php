<?php

class ProvinceController extends AdminController
{
	protected $menuname = 'province';
	public $module = 'Admin';
	protected $pageTitle = 'Provinsi';
	public $wfname = '';
	protected $sqldata = "select a0.provinceid,a0.countryid,a0.provincecode,a0.provincename,a0.recordstatus,a1.countryname as countryname 
    from province a0 
    left join country a1 on a1.countryid = a0.countryid
  ";
  protected $sqlcount = "select count(1) 
    from province a0 
    left join country a1 on a1.countryid = a0.countryid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['provincecode'])) && (isset($_REQUEST['provincename'])) && (isset($_REQUEST['countryname'])))
		{				
			$where .= " where a0.provincecode like '%". $_REQUEST['provincecode']."%' 
and a0.provincename like '%". $_REQUEST['provincename']."%' 
and a1.countryname like '%". $_REQUEST['countryname']."%'"; 
		}
		if (isset($_REQUEST['provinceid']))
			{
				if (($_REQUEST['provinceid'] !== '0') && ($_REQUEST['provinceid'] !== ''))
				{
					$where .= " and a0.provinceid in (".$_REQUEST['provinceid'].")";
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
			'keyField'=>'provinceid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'provinceid','countryid','provincecode','provincename','recordstatus'
				),
				'defaultOrder' => array( 
					'provinceid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where provinceid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'provinceid'=>$model['provinceid'],
          'countryid'=>$model['countryid'],
          'provincecode'=>$model['provincecode'],
          'provincename'=>$model['provincename'],
          'recordstatus'=>$model['recordstatus'],
          'countryname'=>$model['countryname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('countryid','string','emptycountryid'),
      array('provincecode','string','emptyprovincecode'),
      array('provincename','string','emptyprovincename'),
    ));
		if ($error == false)
		{
			$id = $_POST['provinceid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update province 
			      set countryid = :countryid,provincecode = :provincecode,provincename = :provincename,recordstatus = :recordstatus 
			      where provinceid = :provinceid';
				}
				else
				{
					$sql = 'insert into province (countryid,provincecode,provincename,recordstatus) 
			      values (:countryid,:provincecode,:provincename,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':provinceid',$_POST['provinceid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':countryid',(($_POST['countryid']!=='')?$_POST['countryid']:null),PDO::PARAM_STR);
        $command->bindvalue(':provincecode',(($_POST['provincecode']!=='')?$_POST['provincecode']:null),PDO::PARAM_STR);
        $command->bindvalue(':provincename',(($_POST['provincename']!=='')?$_POST['provincename']:null),PDO::PARAM_STR);
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
					$sql = "select recordstatus from province where provinceid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update province set recordstatus = 0 where provinceid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update province set recordstatus = 1 where provinceid = ".$id[$i];
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from province where provinceid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('province');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('provinceid'),$this->getCatalog('country'),$this->getCatalog('provincecode'),$this->getCatalog('provincename'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,50,40,70,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['provinceid'],$row1['countryname'],$row1['provincecode'],$row1['provincename'],
			(($row1['recordstatus'] == 1)?'Active':'NotActive')));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('provinceid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('countryname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('provincecode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('provincename'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['provinceid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['countryname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['provincecode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['provincename'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}