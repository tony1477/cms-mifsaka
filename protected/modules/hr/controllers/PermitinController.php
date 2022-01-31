<?php

class PermitinController extends AdminController
{
	protected $menuname = 'permitin';
	public $module = 'Hr';
	protected $pageTitle = 'Jenis Ijin Masuk';
	public $wfname = 'apppermitin';
	protected $sqldata = "select a0.permitinid,a0.permitinname,a0.snroid,a0.recordstatus,a1.description as description,getwfstatusbywfname('apppermitin',a0.recordstatus) as statusname  
    from permitin a0 
    left join snro a1 on a1.snroid = a0.snroid
  ";
  protected $sqlcount = "select count(1) 
    from permitin a0 
    left join snro a1 on a1.snroid = a0.snroid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['permitinname'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.permitinname like '%". $_REQUEST['permitinname']."%' 
and a1.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['permitinid']))
			{
				if (($_REQUEST['permitinid'] !== '0') && ($_REQUEST['permitinid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.permitinid in (".$_REQUEST['permitinid'].")";
					}
					else
					{
						$where .= " and a0.permitinid in (".$_REQUEST['permitinid'].")";
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
			'keyField'=>'permitinid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'permitinid','permitinname','snroid','recordstatus'
				),
				'defaultOrder' => array( 
					'permitinid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("inspermintin")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.permitinid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'permitinid'=>$model['permitinid'],
                        'permitinname'=>$model['permitinname'],
                        'snroid'=>$model['snroid'],
                        'recordstatus'=>$model['recordstatus'],
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
			array('permitinname','string','emptypermitinname'),
      array('snroid','string','emptysnroid'),
    ));
		if ($error == false)
		{
			$id = $_POST['permitinid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update permitin 
			      set permitinname = :permitinname,snroid = :snroid,recordstatus = :recordstatus 
			      where permitinid = :permitinid';
				}
				else
				{
					$sql = 'insert into permitin (permitinname,snroid,recordstatus) 
			      values (:permitinname,:snroid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':permitinid',$_POST['permitinid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':permitinname',(($_POST['permitinname']!=='')?$_POST['permitinname']:null),PDO::PARAM_STR);
                $command->bindvalue(':snroid',(($_POST['snroid']!=='')?$_POST['snroid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvepermitin(:vid,:vcreatedby)';
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
				$sql = 'call Deletepermitin(:vid,:vcreatedby)';
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
				$sql = "delete from permitin where permitinid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('permitin');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('permitinid'),$this->getCatalog('permitinname'),$this->getCatalog('snro'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['permitinid'],$row1['permitinname'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('permitinid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('permitinname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['permitinid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['permitinname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}