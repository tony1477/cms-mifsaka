<?php

class SlocController extends AdminController
{
	protected $menuname = 'sloc';
	public $module = 'Common';
	protected $pageTitle = 'Gudang';
	public $wfname = '';
	protected $sqldata = "select a0.slocid,a0.plantid,a0.sloccode,a0.description,a0.recordstatus,a1.plantcode as plantcode 
    from sloc a0 
    left join plant a1 on a1.plantid = a0.plantid
  ";
  protected $sqlcount = "select count(1) 
    from sloc a0 
    left join plant a1 on a1.plantid = a0.plantid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['sloccode'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['plantcode'])))
		{				
			$where .= " where a0.sloccode like '%". $_REQUEST['sloccode']."%' 
and a0.description like '%". $_REQUEST['description']."%' 
and a1.plantcode like '%". $_REQUEST['plantcode']."%'"; 
		}
		if (isset($_REQUEST['slocid']))
			{
				if (($_REQUEST['slocid'] !== '0') && ($_REQUEST['slocid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.slocid in (".$_REQUEST['slocid'].")";
					}
					else
					{
						$where .= " and a0.slocid in (".$_REQUEST['slocid'].")";
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
			'keyField'=>'slocid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'slocid','plantid','sloccode','description','recordstatus'
				),
				'defaultOrder' => array( 
					'slocid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.slocid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'slocid'=>$model['slocid'],
          'plantid'=>$model['plantid'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'plantcode'=>$model['plantcode'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('plantid','string','emptyplantid'),
      array('sloccode','string','emptysloccode'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['slocid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update sloc 
			      set plantid = :plantid,sloccode = :sloccode,description = :description,recordstatus = :recordstatus 
			      where slocid = :slocid';
				}
				else
				{
					$sql = 'insert into sloc (plantid,sloccode,description,recordstatus) 
			      values (:plantid,:sloccode,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':slocid',$_POST['slocid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':plantid',(($_POST['plantid']!=='')?$_POST['plantid']:null),PDO::PARAM_STR);
        $command->bindvalue(':sloccode',(($_POST['sloccode']!=='')?$_POST['sloccode']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from sloc where slocid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update sloc set recordstatus = 0 where slocid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update sloc set recordstatus = 1 where slocid = ".$id[$i];
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
				$sql = "delete from sloc where slocid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('sloc');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('slocid'),$this->getCatalog('plant'),$this->getCatalog('sloccode'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['slocid'],$row1['plantcode'],$row1['sloccode'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('slocid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('plantcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['slocid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['plantcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}