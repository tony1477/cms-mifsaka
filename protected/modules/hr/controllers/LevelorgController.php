<?php

class LevelorgController extends AdminController
{
	protected $menuname = 'levelorg';
	public $module = 'Hr';
	protected $pageTitle = 'Level';
	public $wfname = '';
	protected $sqldata = "select a0.levelorgid,a0.levelorgname,a0.recordstatus,getwfstatusbywfname('',a0.recordstatus) as statusname  
    from levelorg a0 
  ";
  protected $sqlcount = "select count(1) 
    from levelorg a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['levelorgname'])))
		{				
			$where .= " where a0.levelorgname like '%". $_REQUEST['levelorgname']."%'"; 
		}
		if (isset($_REQUEST['levelorgid']))
			{
				if (($_REQUEST['levelorgid'] !== '0') && ($_REQUEST['levelorgid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.levelorgid in (".$_REQUEST['levelorgid'].")";
					}
					else
					{
						$where .= " and a0.levelorgid in (".$_REQUEST['levelorgid'].")";
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
			'keyField'=>'levelorgid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'levelorgid','levelorgname','recordstatus'
				),
				'defaultOrder' => array( 
					'levelorgid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.levelorgid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'levelorgid'=>$model['levelorgid'],
                        'levelorgname'=>$model['levelorgname'],
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
			array('levelorgname','string','emptylevelorgname'),
    ));
		if ($error == false)
		{
			$id = $_POST['levelorgid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update levelorg 
			      set levelorgname = :levelorgname,recordstatus = :recordstatus 
			      where levelorgid = :levelorgid';
				}
				else
				{
					$sql = 'insert into levelorg (levelorgname,recordstatus) 
			      values (:levelorgname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':levelorgid',$_POST['levelorgid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':levelorgname',(($_POST['levelorgname']!=='')?$_POST['levelorgname']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvelevelorg(:vid,:vcreatedby)';
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
				$sql = 'call Deletelevelorg(:vid,:vcreatedby)';
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
				$sql = "delete from levelorg where levelorgid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('levelorg');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('levelorgid'),$this->getCatalog('levelorgname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['levelorgid'],$row1['levelorgname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('levelorgid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('levelorgname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['levelorgid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['levelorgname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}