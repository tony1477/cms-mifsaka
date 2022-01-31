<?php

class SnroController extends AdminController
{
	protected $menuname = 'snro';
	public $module = 'Admin';
	protected $pageTitle = 'Sistem Penomoran';
	public $wfname = '';
	protected $sqldata = "select a0.snroid,a0.description,a0.formatdoc,a0.formatno,a0.repeatby,a0.recordstatus 
    from snro a0 
  ";
  protected $sqlcount = "select count(1) 
    from snro a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['description'])) && (isset($_REQUEST['formatdoc'])) && (isset($_REQUEST['formatno'])) && (isset($_REQUEST['repeatby'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%' 
and a0.formatdoc like '%". $_REQUEST['formatdoc']."%' 
and a0.formatno like '%". $_REQUEST['formatno']."%' 
and a1.repeatby like '%". $_REQUEST['repeatby']."%'"; 
		}
		if (isset($_REQUEST['snroid']))
			{
				if (($_REQUEST['snroid'] !== '0') && ($_REQUEST['snroid'] !== ''))
				{
					$where .= " and a0.snroid in (".$_REQUEST['snroid'].")";
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
			'keyField'=>'snroid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'snroid','description','formatdoc','formatno','repeatby','recordstatus'
				),
				'defaultOrder' => array( 
					'snroid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where snroid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'snroid'=>$model['snroid'],
          'description'=>$model['description'],
          'formatdoc'=>$model['formatdoc'],
          'formatno'=>$model['formatno'],
          'recordstatus'=>$model['recordstatus'],
          'repeatby'=>$model['repeatby'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
	      array('formatdoc','string','emptyformatdoc'),
	      array('repeatby','string','emptyrepeatby'),
	      array('formatno','string','emptyformatno'),
    ));
		if ($error == false)
		{
			$id = $_POST['snroid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update snro 
			      set description = :description, formatdoc = :formatdoc, formatno = :formatno,
			      recordstatus = :recordstatus, repeatby = :repeatby
			      where snroid = :snroid';
				}
				else
				{
					$sql = 'insert into snro (description,formatdoc,formatno,repeatby,recordstatus) 
			      values (:description,:formatdoc,:formatno,:repeatby,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':snroid',$_POST['snroid'],PDO::PARAM_STR);
				}
				
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':formatdoc',(($_POST['formatdoc']!=='')?$_POST['formatdoc']:null),PDO::PARAM_STR);
        $command->bindvalue(':formatno',(($_POST['formatno']!=='')?$_POST['formatno']:null),PDO::PARAM_STR);
        $command->bindvalue(':repeatby',(($_POST['repeatby']!=='')?$_POST['repeatby']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from snro where snroid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update snro set recordstatus = 0 where snroid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update snro set recordstatus = 1 where snroid = ".$id[$i];
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
				$sql = "delete from snro where snroid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('snro');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('snroid'),$this->getCatalog('description'),$this->getCatalog('formatdoc'),$this->getCatalog('formatno'),$this->getCatalog('repeatby'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['snroid'],$row1['description'],$row1['formatdoc'],
			$row1['formatno'],$row1['repeatby'],(($row1['recordstatus'] == 1)?'Active':'NotActive')));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('snroid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('formatdoc'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('formatno'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('repeatby'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['snroid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['formatdoc'])
->setCellValueByColumnAndRow(4, $i+1, $row1['formatno'])
->setCellValueByColumnAndRow(1, $i+1, $row1['repeatby'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}