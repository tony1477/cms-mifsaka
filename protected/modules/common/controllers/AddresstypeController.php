<?php

class AddresstypeController extends AdminController
{
	protected $menuname = 'addresstype';
	public $module = 'Common';
	protected $pageTitle = 'Jenis Alamat';
	public $wfname = '';
	protected $sqldata = "select a0.addresstypeid,a0.addresstypename,a0.recordstatus 
    from addresstype a0 
  ";
  protected $sqlcount = "select count(1) 
    from addresstype a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['addresstypename'])))
		{				
			$where .= " where a0.addresstypename like '%". $_REQUEST['addresstypename']."%'"; 
		}
		if (isset($_REQUEST['addresstypeid']))
			{
				if (($_REQUEST['addresstypeid'] !== '0') && ($_REQUEST['addresstypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.addresstypeid in (".$_REQUEST['addresstypeid'].")";
					}
					else
					{
						$where .= " and a0.addresstypeid in (".$_REQUEST['addresstypeid'].")";
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
			'keyField'=>'addresstypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'addresstypeid','addresstypename','recordstatus'
				),
				'defaultOrder' => array( 
					'addresstypeid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.addresstypeid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addresstypeid'=>$model['addresstypeid'],
          'addresstypename'=>$model['addresstypename'],
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
			array('addresstypename','string','emptyaddresstypename'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addresstypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update addresstype 
			      set addresstypename = :addresstypename,recordstatus = :recordstatus 
			      where addresstypeid = :addresstypeid';
				}
				else
				{
					$sql = 'insert into addresstype (addresstypename,recordstatus) 
			      values (:addresstypename,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addresstypeid',$_POST['addresstypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':addresstypename',(($_POST['addresstypename']!=='')?$_POST['addresstypename']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from addresstype where addresstypeid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update addresstype set recordstatus = 0 where addresstypeid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update addresstype set recordstatus = 1 where addresstypeid = ".$id[$i];
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
				$sql = "delete from addresstype where addresstypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('addresstype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('addresstypeid'),$this->getCatalog('addresstypename'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['addresstypeid'],$row1['addresstypename'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('addresstypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('addresstypename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['addresstypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['addresstypename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}