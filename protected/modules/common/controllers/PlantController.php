<?php

class PlantController extends AdminController
{
	protected $menuname = 'plant';
	public $module = 'Common';
	protected $pageTitle = 'Kantor Cabang';
	public $wfname = '';
	protected $sqldata = "select a0.plantid,a0.companyid,a0.plantcode,a0.description,a0.recordstatus,a1.companyname as companyname 
    from plant a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from plant a0 
    left join company a1 on a1.companyid = a0.companyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['plantcode'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['companyname'])))
		{				
			$where .= " where a0.plantcode like '%". $_REQUEST['plantcode']."%' 
and a0.description like '%". $_REQUEST['description']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
		if (isset($_REQUEST['plantid']))
			{
				if (($_REQUEST['plantid'] !== '0') && ($_REQUEST['plantid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.plantid in (".$_REQUEST['plantid'].")";
					}
					else
					{
						$where .= " and a0.plantid in (".$_REQUEST['plantid'].")";
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
			'keyField'=>'plantid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'plantid','companyid','plantcode','description','recordstatus'
				),
				'defaultOrder' => array( 
					'plantid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.plantid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'plantid'=>$model['plantid'],
          'companyid'=>$model['companyid'],
          'plantcode'=>$model['plantcode'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('plantcode','string','emptyplantcode'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['plantid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update plant 
			      set companyid = :companyid,plantcode = :plantcode,description = :description,recordstatus = :recordstatus 
			      where plantid = :plantid';
				}
				else
				{
					$sql = 'insert into plant (companyid,plantcode,description,recordstatus) 
			      values (:companyid,:plantcode,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':plantid',$_POST['plantid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':plantcode',(($_POST['plantcode']!=='')?$_POST['plantcode']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from plant where plantid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update plant set recordstatus = 0 where plantid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update plant set recordstatus = 1 where plantid = ".$id[$i];
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
				$sql = "delete from plant where plantid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('plant');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('plantid'),$this->getCatalog('company'),$this->getCatalog('plantcode'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['plantid'],$row1['companyname'],$row1['plantcode'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('plantid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('plantcode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['plantid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['plantcode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
