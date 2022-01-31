<?php

class SexController extends AdminController
{
	protected $menuname = 'sex';
	public $module = 'hr';
	protected $pageTitle = 'Jenis Kelamin';
	public $wfname = 'appsex';
	protected $sqldata = "select a0.sexid,a0.sexname,a0.recordstatus 
    from sex a0 
  ";
  protected $sqlcount = "select count(1) 
    from sex a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['sexname'])))
		{				
			$where .= " where a0.sexname like '%". $_REQUEST['sexname']."%'"; 
		}
		if (isset($_REQUEST['sexid']))
			{
				if (($_REQUEST['sexid'] !== '0') && ($_REQUEST['sexid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.sexid in (".$_REQUEST['sexid'].")";
					}
					else
					{
						$where .= " and a0.sexid in (".$_REQUEST['sexid'].")";
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
			'keyField'=>'sexid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'sexid','sexname','recordstatus'
				),
				'defaultOrder' => array( 
					'sexid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("inssex")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.sexid = '.$id)->queryRow();
			if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'sexid'=>$model['sexid'],
          'sexname'=>$model['sexname'],
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
			array('sexname','string','emptysexname'),
    ));
		if ($error == false)
		{
			$id = $_POST['sexid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update sex 
			      set sexname = :sexname,recordstatus = :recordstatus 
			      where sexid = :sexid';
				}
				else
				{
					$sql = 'insert into sex (sexname,recordstatus) 
			      values (:sexname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':sexid',$_POST['sexid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':sexname',(($_POST['sexname']!=='')?$_POST['sexname']:null),PDO::PARAM_STR);
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
				
	
public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Approvesex(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
		}
	}
	
public function actionDelete()
	{
		parent::actionDelete();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Deletesex(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->execute();
				}
				$transaction->commit();
				$this->GetMessage('success','alreadysaved',1);
			}
			catch (Exception $e)
			{
				$transaction->rollback();
				$this->GetMessage('error',$e->getMessage(),1);
			}
		}
		else
		{
		$this->GetMessage('error','chooseone',1);
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
				$sql = "delete from sex where sexid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('sex');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('sexid'),$this->getCatalog('sexname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['sexid'],$row1['sexname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('sexid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('sexname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['sexid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['sexname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}