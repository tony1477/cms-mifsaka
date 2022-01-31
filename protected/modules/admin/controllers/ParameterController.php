<?php

class ParameterController extends AdminController
{
	protected $menuname = 'parameter';
	public $module = 'Admin';
	protected $pageTitle = 'Parameter';
	public $wfname = '';
	protected $sqldata = "select a0.parameterid,a0.paramname,a0.paramvalue,a0.description 
    from parameter a0 
  ";
  protected $sqlcount = "select count(1) 
    from parameter a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['paramname'])) && (isset($_REQUEST['paramvalue'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.paramname like '%". $_REQUEST['paramname']."%' 
and a0.paramvalue like '%". $_REQUEST['paramvalue']."%' 
and a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['parameterid']))
			{
				if (($_REQUEST['parameterid'] !== '0') && ($_REQUEST['parameterid'] !== ''))
				{
					$where .= " and a0.parameterid in (".$_REQUEST['parameterid'].")";
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
			'keyField'=>'parameterid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'parameterid','paramname','paramvalue','description'
				),
				'defaultOrder' => array( 
					'parameterid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where parameterid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'parameterid'=>$model['parameterid'],
          'paramname'=>$model['paramname'],
          'paramvalue'=>$model['paramvalue'],
          'description'=>$model['description'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('paramname','string','emptyparamname'),
      array('paramvalue','string','emptyparamvalue'),
      array('description','string','emptydescription'),
    ));
		if ($error == false)
		{
			$id = $_POST['parameterid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update parameter 
			      set paramname = :paramname,paramvalue = :paramvalue,description = :description 
			      where parameterid = :parameterid';
				}
				else
				{
					$sql = 'insert into parameter (paramname,paramvalue,description) 
			      values (:paramname,:paramvalue,:description)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':parameterid',$_POST['parameterid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':paramname',(($_POST['paramname']!=='')?$_POST['paramname']:null),PDO::PARAM_STR);
        $command->bindvalue(':paramvalue',(($_POST['paramvalue']!=='')?$_POST['paramvalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
				$sql = "delete from parameter where parameterid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('parameter');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('parameterid'),$this->getCatalog('paramname'),$this->getCatalog('paramvalue'),$this->getCatalog('description'));
		$this->pdf->setwidths(array(10,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['parameterid'],$row1['paramname'],$row1['paramvalue'],$row1['description']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('parameterid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('paramname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('paramvalue'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['parameterid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['paramname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['paramvalue'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}