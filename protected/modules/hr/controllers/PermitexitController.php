<?php

class PermitexitController extends AdminController
{
	protected $menuname = 'permitexit';
	public $module = 'Hr';
	protected $pageTitle = 'Jenis Ijin Keluar';
	public $wfname = 'apppermitexit';
	protected $sqldata = "select a0.permitexitid,a0.permitexitname,a0.snroid,a0.recordstatus,a1.description as description,getwfstatusbywfname('apppermitexit',a0.recordstatus) as statusname  
    from permitexit a0 
    left join snro a1 on a1.snroid = a0.snroid
  ";
  protected $sqlcount = "select count(1) 
    from permitexit a0 
    left join snro a1 on a1.snroid = a0.snroid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['permitexitname'])))
		{				
			$where .= " where a0.permitexitname like '%". $_REQUEST['permitexitname']."%'"; 
		}
		if (isset($_REQUEST['permitexitid']))
			{
				if (($_REQUEST['permitexitid'] !== '0') && ($_REQUEST['permitexitid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.permitexitid in (".$_REQUEST['permitexitid'].")";
					}
					else
					{
						$where .= " and a0.permitexitid in (".$_REQUEST['permitexitid'].")";
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
			'keyField'=>'permitexitid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'permitexitid','permitexitname','snroid','recordstatus'
				),
				'defaultOrder' => array( 
					'permitexitid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("inspermintexit")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.permitexitid = '.$id)->queryRow();
			//if ($this->CheckDoc($model['recordstatus']) == '')
			//{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'permitexitid'=>$model['permitexitid'],
                        'permitexitname'=>$model['permitexitname'],
                        'snroid'=>$model['snroid'],
                        'recordstatus'=>$model['recordstatus'],
                        'description'=>$model['description'],

					));
					Yii::app()->end();
				}
            /*
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
            */
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('permitexitname','string','emptypermitexitname'),
      array('snroid','string','emptysnroid'),
    ));
		if ($error == false)
		{
			$id = $_POST['permitexitid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update permitexit 
			      set permitexitname = :permitexitname,snroid = :snroid,recordstatus = :recordstatus 
			      where permitexitid = :permitexitid';
				}
				else
				{
					$sql = 'insert into permitexit (permitexitname,snroid,recordstatus) 
			      values (:permitexitname,:snroid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':permitexitid',$_POST['permitexitid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':permitexitname',(($_POST['permitexitname']!=='')?$_POST['permitexitname']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvepermitexit(:vid,:vcreatedby)';
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
				$sql = 'call Deletepermitexit(:vid,:vcreatedby)';
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
				$sql = "delete from permitexit where permitexitid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('permitexit');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('permitexitid'),$this->getCatalog('permitexitname'),$this->getCatalog('snro'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['permitexitid'],$row1['permitexitname'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('permitexitid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('permitexitname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['permitexitid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['permitexitname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}