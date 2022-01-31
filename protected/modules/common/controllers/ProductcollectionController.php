<?php

class ProductcollectionController extends AdminController
{
	protected $menuname = 'productcollection';
	public $module = 'Common';
	protected $pageTitle = 'Collection Product';
	public $wfname = '';
	protected $sqldata = "select a0.productcollectid,a0.collectionname,a0.recordstatus 
    from productcollection a0 
    ";
  protected $sqlcount = "select count(1) 
    from productcollection a0 
    ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['collectionname'])))
		{				
			$where .= " where a0.collectionname like '%". $_REQUEST['collectionname']."%'"; 
		}
		if (isset($_REQUEST['productcollectid']))
			{
				if (($_REQUEST['productcollectid'] !== '0') && ($_REQUEST['productcollectid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.productcollectid in (".$_REQUEST['productcollectid'].")";
					}
					else
					{
						$where .= " and a0.productcollectid in (".$_REQUEST['productcollectid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionGetProductCollect()
  {
    parent::actionIndex();
    $result = array();
    $row = array();
    $q = Yii::app()->db->createCommand("select productcollectid,collectionname from productcollection where recordstatus=1")->queryAll();
    $result['total'] = count($q);

    foreach($q as $data) {
      $row[] = array(
        'productcollectid' => $data['productcollectid'],
        'collectionname' => $data['collectionname']);
    }
    $result = array_merge($result,array('rows'=>$row));
    echo CJSON::encode($result);
    //Yii::app()->end();
  }
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'productcollectid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productcollectid','collectionname','recordstatus'
				),
				'defaultOrder' => array( 
					'productcollectid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productcollectid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productcollectid'=>$model['productcollectid'],
          'collectionname'=>$model['collectionname'],
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
			    ));
		if ($error == false)
		{
			$id = $_POST['productcollectid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateproductcollect(:vid,:vcollectionname,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertproductcollect(:vcollectionname,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['productcollectid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vcollectionname',$_POST['collectionname'],PDO::PARAM_STR);
		    $command->bindvalue(':vrecordstatus',$_POST['recordstatus'],PDO::PARAM_STR);
		    $command->bindvalue(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
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
					$sql = "select recordstatus from productcollection where productcollectid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update productcollection set recordstatus = 0 where productcollectid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update productcollection set recordstatus = 1 where productcollectid = ".$id[$i];
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
				$sql = "delete from productcollection where productcollectid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('productcollection');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('productcollectid'),$this->getCatalog('collectionname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productcollectid'],$row1['collectionname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('productcollectid'))
          ->setCellValueByColumnAndRow(1,4,$this->getCatalog('collectionname'))
          ->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
              foreach($dataReader as $row1)
              {
                  $this->phpExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow(0, $i+1, $row1['productcollectid'])
          ->setCellValueByColumnAndRow(1, $i+1, $row1['collectionname'])
          ->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		      $i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}