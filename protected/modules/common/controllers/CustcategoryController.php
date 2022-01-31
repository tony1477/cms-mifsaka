<?php

class CustcategoryController extends AdminController
{
	protected $menuname = 'custcategory';
	public $module = 'Common';
	protected $pageTitle = 'Kategori Customer';
	public $wfname = '';
	protected $sqldata = "select t.*
    from custcategory t
  ";
  protected $sqlcount = "select count(1) 
    from custcategory t
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if (isset($_REQUEST['custcategoryname']) && $_REQUEST['custcategoryname']!='')
        {
            $where .= " where custcategoryname like '%".$_REQUEST['custcategoryname']."%' ";
        }
            
		if (isset($_REQUEST['custcategoryid']))
			{
				if (($_REQUEST['custcategoryid'] !== '0') && ($_REQUEST['custcategoryid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where t.custcategoryid in (".$_REQUEST['custcategoryid'].")";
					}
					else
					{
						$where .= " and t.custcategoryid in (".$_REQUEST['custcategoryid'].")";
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
			'keyField'=>'custcategoryid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'custcategoryid','custcategoryname','recordstatus'
				),
				'defaultOrder' => array( 
					'custcategoryid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.custcategoryid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'custcategoryid'=>$model['custcategoryid'],
                    'custcategoryname'=>$model['custcategoryname'],
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
			array('custcategoryname','string','emptycustcategoryname'),
    ));
		if ($error == false)
		{
			$id = $_POST['custcategoryid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatecustcategory(:vid,:vcustcategoryname,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertcustcategory(:vcustcategoryname,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['custcategoryid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vcustcategoryname',(($_POST['custcategoryname']!=='')?$_POST['custcategoryname']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from custcategory where custcategoryid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update custcategory set recordstatus = 0 where custcategoryid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update custcategory set recordstatus = 1 where custcategoryid = ".$id[$i];
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
				$sql = "delete from custcategory where custcategoryid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('custcategory');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('custcategoryid'),$this->getCatalog('custcategoryname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['custcategoryid'],$row1['custcategoryname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('custcategoryid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('custcategorycode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('custcategorycode'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('materialtypecode'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('isfg'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['custcategoryid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['custcategorycode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['custcategorycode'])
->setCellValueByColumnAndRow(4, $i+1, $row1['materialtypecode'])
->setCellValueByColumnAndRow(5, $i+1, $row1['isfg'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}