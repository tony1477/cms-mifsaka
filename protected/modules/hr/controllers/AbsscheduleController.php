<?php

class AbsscheduleController extends AdminController
{
	protected $menuname = 'absschedule';
	public $module = 'Hr';
	protected $pageTitle = 'Jadwal';
	public $wfname = '';
	protected $sqldata = "select a0.absscheduleid,a0.absschedulename,a0.absin,a0.absout,a0.absstatusid,a0.recordstatus,a0.createddate,a0.updatedate,a1.longstat as longstat 
    from absschedule a0 
    left join absstatus a1 on a1.absstatusid = a0.absstatusid
  ";
  protected $sqlcount = "select count(1) 
    from absschedule a0 
    left join absstatus a1 on a1.absstatusid = a0.absstatusid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['absschedulename'])))
		{				
			$where .= " where a0.absschedulename like '%". $_REQUEST['absschedulename']."%'"; 
		}
		if (isset($_REQUEST['absscheduleid']))
			{
				if (($_REQUEST['absscheduleid'] !== '0') && ($_REQUEST['absscheduleid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.absscheduleid in (".$_REQUEST['absscheduleid'].")";
					}
					else
					{
						$where .= " and a0.absscheduleid in (".$_REQUEST['absscheduleid'].")";
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
			'keyField'=>'absscheduleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'absscheduleid','absschedulename','absin','absout','absstatusid','recordstatus','createddate','updatedate'
				),
				'defaultOrder' => array( 
					'absscheduleid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.absscheduleid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'absscheduleid'=>$model['absscheduleid'],
          'absschedulename'=>$model['absschedulename'],
          'absin'=>$model['absin'],
          'absout'=>$model['absout'],
          'absstatusid'=>$model['absstatusid'],
          'recordstatus'=>$model['recordstatus'],
          'longstat'=>$model['longstat'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('absschedulename','string','emptyabsschedulename'),
    ));
		if ($error == false)
		{
			$id = $_POST['absscheduleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateabsschedule(:vid,:vabsschedulename,:vabsin,:vabsout,:vabsstatusid,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertabsschedule(:vabsschedulename,:vabsin,:vabsout,:vabsstatusid,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['absscheduleid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vabsschedulename',(($_POST['absschedulename']!=='')?$_POST['absschedulename']:null),PDO::PARAM_STR);
                $command->bindvalue(':vabsin',(($_POST['absin']!=='')?$_POST['absin']:null),PDO::PARAM_STR);
                $command->bindvalue(':vabsout',(($_POST['absout']!=='')?$_POST['absout']:null),PDO::PARAM_STR);
                $command->bindvalue(':vabsstatusid',(($_POST['absstatusid']!=='')?$_POST['absstatusid']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from absschedule where absscheduleid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update absschedule set recordstatus = 0 where absscheduleid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update absschedule set recordstatus = 1 where absscheduleid = ".$id[$i];
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
				$sql = "delete from absschedule where absscheduleid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('absschedule');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('absscheduleid'),$this->getCatalog('absschedulename'),$this->getCatalog('absin'),$this->getCatalog('absout'),$this->getCatalog('absstatus'),$this->getCatalog('recordstatus'),$this->getCatalog('createddate'),$this->getCatalog('updatedate'));
		$this->pdf->setwidths(array(10,40,40,40,40,15,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['absscheduleid'],$row1['absschedulename'],$row1['absin'],$row1['absout'],$row1['longstat'],$row1['recordstatus'],$row1['createddate'],$row1['updatedate']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('absscheduleid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('absschedulename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('absin'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('absout'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('longstat'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['absscheduleid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['absschedulename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['absin'])
->setCellValueByColumnAndRow(3, $i+1, $row1['absout'])
->setCellValueByColumnAndRow(4, $i+1, $row1['longstat'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}