<?php

class MaterialtypeController extends AdminController
{
	protected $menuname = 'materialtype';
	public $module = 'Common';
	protected $pageTitle = 'Jenis Material';
	public $wfname = '';
	protected $sqldata = "select a0.materialtypeid,a0.materialtypecode,a0.description,a0.recordstatus, a0.isview, a0.nourut
    from materialtype a0 
  ";
  protected $sqlcount = "select count(1) 
    from materialtype a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['materialtypecode'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.materialtypecode like '%". $_REQUEST['materialtypecode']."%' 
and a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['materialtypeid']))
			{
				if (($_REQUEST['materialtypeid'] !== '0') && ($_REQUEST['materialtypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.materialtypeid in (".$_REQUEST['materialtypeid'].")";
					}
					else
					{
						$where .= " and a0.materialtypeid in (".$_REQUEST['materialtypeid'].")";
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
			'keyField'=>'materialtypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'materialtypeid','materialtypecode','description','nourut','isview','recordstatus'
				),
				'defaultOrder' => array( 
					'materialtypeid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.materialtypeid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'materialtypeid'=>$model['materialtypeid'],
          'materialtypecode'=>$model['materialtypecode'],
          'description'=>$model['description'],
          'nourut'=>$model['nourut'],
          'isview'=>$model['isview'],
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
			array('materialtypecode','string','emptymaterialtypecode'),
      array('description','string','emptydescription'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['materialtypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update materialtype 
			      set materialtypecode = :materialtypecode,description = :description, nourut = :nourut, isview = :isview, recordstatus = :recordstatus 
			      where materialtypeid = :materialtypeid';
				}
				else
				{
					$sql = 'insert into materialtype (materialtypecode,description,nourut,isview,recordstatus) 
			      values (:materialtypecode,:description,:nourut,:isview,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':materialtypeid',$_POST['materialtypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':materialtypecode',(($_POST['materialtypecode']!=='')?$_POST['materialtypecode']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':nourut',(($_POST['nourut']!=='')?$_POST['nourut']:null),PDO::PARAM_STR);
        $command->bindvalue(':isview',(($_POST['isview']!=='')?$_POST['isview']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from materialtype where materialtypeid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update materialtype set recordstatus = 0 where materialtypeid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update materialtype set recordstatus = 1 where materialtypeid = ".$id[$i];
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
				$sql = "delete from materialtype where materialtypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('materialtype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('materialtypeid'),$this->getCatalog('materialtypecode'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['materialtypeid'],$row1['materialtypecode'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('materialtypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('materialtypecode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['materialtypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['materialtypecode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}