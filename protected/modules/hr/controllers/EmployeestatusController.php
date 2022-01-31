<?php

class EmployeestatusController extends AdminController
{
	protected $menuname = 'employeestatus';
	public $module = 'Hr';
	protected $pageTitle = 'Status Karyawan';
	public $wfname = '';
	protected $sqldata = "select a0.employeestatusid,a0.employeestatusname,a0.taxvalue,a0.recordstatus,getwfstatusbywfname('',a0.recordstatus) as statusname  
    from employeestatus a0 
  ";
  protected $sqlcount = "select count(1) 
    from employeestatus a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['employeestatusname'])) && (isset($_REQUEST['taxvalue'])))
		{				
			$where .= " where a0.employeestatusname like '%". $_REQUEST['employeestatusname']."%' 
and a0.taxvalue like '%". $_REQUEST['taxvalue']."%'"; 
		}
		if (isset($_REQUEST['employeestatusid']))
			{
				if (($_REQUEST['employeestatusid'] !== '0') && ($_REQUEST['employeestatusid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.employeestatusid in (".$_REQUEST['employeestatusid'].")";
					}
					else
					{
						$where .= " and a0.employeestatusid in (".$_REQUEST['employeestatusid'].")";
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
			'keyField'=>'employeestatusid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'employeestatusid','employeestatusname','taxvalue','recordstatus'
				),
				'defaultOrder' => array( 
					'employeestatusid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"taxvalue" =>0,
      "recordstatus" =>$this->findstatusbyuser("")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.employeestatusid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'employeestatusid'=>$model['employeestatusid'],
          'employeestatusname'=>$model['employeestatusname'],
          'taxvalue'=>$model['taxvalue'],
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
			array('employeestatusname','string','emptyemployeestatusname'),
      array('taxvalue','string','emptytaxvalue'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeestatusid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update employeestatus 
			      set employeestatusname = :employeestatusname,taxvalue = :taxvalue,recordstatus = :recordstatus 
			      where employeestatusid = :employeestatusid';
				}
				else
				{
					$sql = 'insert into employeestatus (employeestatusname,taxvalue,recordstatus) 
			      values (:employeestatusname,:taxvalue,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':employeestatusid',$_POST['employeestatusid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':employeestatusname',(($_POST['employeestatusname']!=='')?$_POST['employeestatusname']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxvalue',(($_POST['taxvalue']!=='')?$_POST['taxvalue']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveemployeestatus(:vid,:vcreatedby)';
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
				$sql = 'call Deleteemployeestatus(:vid,:vcreatedby)';
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
				$sql = "delete from employeestatus where employeestatusid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('employeestatus');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('employeestatusid'),$this->getCatalog('employeestatusname'),$this->getCatalog('taxvalue'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['employeestatusid'],$row1['employeestatusname'],$row1['taxvalue'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('employeestatusid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('employeestatusname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('taxvalue'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['employeestatusid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['employeestatusname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['taxvalue'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}