<?php

class JobsController extends AdminController
{
	protected $menuname = 'jobs';
	public $module = 'Hr';
	protected $pageTitle = 'Rincian Pekerjaan';
	public $wfname = '';
	protected $sqldata = "select a0.jobsid,a0.orgstructureid,a0.jobdesc,a0.qualification,a0.positionid,a0.recordstatus,a1.structurename as structurename,a2.positionname as positionname,getwfstatusbywfname('',a0.recordstatus) as statusname  
    from jobs a0 
    left join orgstructure a1 on a1.orgstructureid = a0.orgstructureid
    left join position a2 on a2.positionid = a0.positionid
  ";
  protected $sqlcount = "select count(1) 
    from jobs a0 
    left join orgstructure a1 on a1.orgstructureid = a0.orgstructureid
    left join position a2 on a2.positionid = a0.positionid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['jobdesc'])) && (isset($_REQUEST['structurename'])))
		{				
			$where .= " where a0.jobdesc like '%". $_REQUEST['jobdesc']."%' 
and a1.structurename like '%". $_REQUEST['structurename']."%'"; 
		}
		if (isset($_REQUEST['jobsid']))
			{
				if (($_REQUEST['jobsid'] !== '0') && ($_REQUEST['jobsid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.jobsid in (".$_REQUEST['jobsid'].")";
					}
					else
					{
						$where .= " and a0.jobsid in (".$_REQUEST['jobsid'].")";
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
			'keyField'=>'jobsid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'jobsid','orgstructureid','jobdesc','qualification','positionid','recordstatus'
				),
				'defaultOrder' => array( 
					'jobsid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.jobsid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'jobsid'=>$model['jobsid'],
                        'orgstructureid'=>$model['orgstructureid'],
                        'jobdesc'=>$model['jobdesc'],
                        'qualification'=>$model['qualification'],
                        'positionid'=>$model['positionid'],
                        'recordstatus'=>$model['recordstatus'],
                        'structurename'=>$model['structurename'],
                        'positionname'=>$model['positionname'],
					));
					Yii::app()->end();
				}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('orgstructureid','string','emptyorgstructureid'),
    ));
		if ($error == false)
		{
			$id = $_POST['jobsid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update jobs 
			      set orgstructureid = :orgstructureid,jobdesc = :jobdesc,qualification = :qualification,positionid = :positionid,recordstatus = :recordstatus 
			      where jobsid = :jobsid';
				}
				else
				{
					$sql = 'insert into jobs (orgstructureid,jobdesc,qualification,positionid,recordstatus) 
			      values (:orgstructureid,:jobdesc,:qualification,:positionid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':jobsid',$_POST['jobsid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':orgstructureid',(($_POST['orgstructureid']!=='')?$_POST['orgstructureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':jobdesc',(($_POST['jobdesc']!=='')?$_POST['jobdesc']:null),PDO::PARAM_STR);
        $command->bindvalue(':qualification',(($_POST['qualification']!=='')?$_POST['qualification']:null),PDO::PARAM_STR);
        $command->bindvalue(':positionid',(($_POST['positionid']!=='')?$_POST['positionid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvejobs(:vid,:vcreatedby)';
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
				$sql = 'call Deletejobs(:vid,:vcreatedby)';
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
				$sql = "delete from jobs where jobsid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('jobs');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('jobsid'),$this->getCatalog('orgstructure'),$this->getCatalog('jobdesc'),$this->getCatalog('qualification'),$this->getCatalog('position'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['jobsid'],$row1['structurename'],$row1['jobdesc'],$row1['qualification'],$row1['positionname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('jobsid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('structurename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('jobdesc'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('qualification'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('positionname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['jobsid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['structurename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['jobdesc'])
->setCellValueByColumnAndRow(3, $i+1, $row1['qualification'])
->setCellValueByColumnAndRow(4, $i+1, $row1['positionname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}