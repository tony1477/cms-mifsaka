<?php

class CustgradeController extends AdminController
{
	protected $menuname = 'custgrade';
	public $module = 'Common';
	protected $pageTitle = 'Customer Grade';
	public $wfname = '';
	protected $sqldata = "select t.*
    from custgrade t
  ";
  protected $sqlcount = "select count(1) 
    from custgrade t
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where 1";
		if (isset($_REQUEST['custgradename']) && $_REQUEST['custgradename']!='')
        {
            $where .= " and custgradename like '%".$_REQUEST['custgradename']."%' ";
        }
        if(isset($_REQUEST['custogradedesc']) && $_REQUEST['custogradedesc']!='')
        {
            $where .= " and custogradedesc like '%".$_REQUEST['custogradedesc']."%' ";
        }
        if(isset($_REQUEST['description']) && $_REQUEST['description']!='')
        {
            $where .= " and description like '%".$_REQUEST['description']."%' ";
        }
            
		if (isset($_REQUEST['custgradeid']))
			{
				if (($_REQUEST['custgradeid'] !== '0') && ($_REQUEST['custgradeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where t.custgradeid in (".$_REQUEST['custgradeid'].")";
					}
					else
					{
						$where .= " and t.custgradeid in (".$_REQUEST['custgradeid'].")";
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
			'keyField'=>'custgradeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'custgradeid','custgradename','custogradedesc','description','recordstatus'
				),
				'defaultOrder' => array( 
					'custgradeid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.custgradeid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'custgradeid'=>$model['custgradeid'],
                    'custgradename'=>$model['custgradename'],
                    'custogradedesc'=>$model['custogradedesc'],
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
			array('custgradename','string','emptycustgradename'),
            array('custogradedesc','string','emptycustogradedesc'),
            array('description','string','emptydescription'),
    ));
		if ($error == false)
		{
			$id = $_POST['custgradeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call UpdateCustgrade(:vid,:vcustgradename,:vcustogradedesc,:vdescription,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertCustgrade(:vcustgradename,:vcustogradedesc,:vdescription,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['custgradeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vcustgradename',(($_POST['custgradename']!=='')?$_POST['custgradename']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustogradedesc',(($_POST['custogradedesc']!=='')?$_POST['custogradedesc']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdescription',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
	/*
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
					$sql = "select recordstatus from custgrade where custgradeid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update custgrade set recordstatus = 0 where custgradeid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update custgrade set recordstatus = 1 where custgradeid = ".$id[$i];
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
				$sql = "delete from custgrade where custgradeid = ".$id[$i];
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
    */
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('custgrade');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('custgradeid'),$this->getCatalog('custgradename'),$this->getCatalog('custogradedesc'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['custgradeid'],$row1['custgradename'],$row1['custogradedesc'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('custgradeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('custgradecode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('custgradecode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('materialtypecode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('isfg'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['custgradeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['custgradecode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['custgradecode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['materialtypecode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['isfg'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}