<?php

class EmployeetypeController extends AdminController
{
	protected $menuname = 'employeetype';
	public $module = 'Hr';
	protected $pageTitle = 'Jenis Karyawan';
	public $wfname = 'appemployeetype';
	protected $sqldata = "select a0.employeetypeid,a0.employeetypename,a0.snroid,a0.sicksnroid,a0.sickstatusid,a0.recordstatus,a1.description as description,a2.description as sicksnro,a3.longstat as sickstatus
    from employeetype a0 
    left join snro a1 on a1.snroid = a0.snroid
    left join snro a2 on a2.snroid = a0.sicksnroid
    left join absstatus a3 on a3.absstatusid = a0.sickstatusid
  ";
  protected $sqlcount = "select count(1) 
    from employeetype a0 
    left join snro a1 on a1.snroid = a0.snroid
    left join snro a2 on a2.snroid = a0.sicksnroid
    left join absstatus a3 on a3.absstatusid = a0.sickstatusid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['employeetypename'])))
		{				
			$where .= " where a0.employeetypename like '%". $_REQUEST['employeetypename']."%'"; 
		}
		if (isset($_REQUEST['employeetypeid']))
			{
				if (($_REQUEST['employeetypeid'] !== '0') && ($_REQUEST['employeetypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.employeetypeid in (".$_REQUEST['employeetypeid'].")";
					}
					else
					{
						$where .= " and a0.employeetypeid in (".$_REQUEST['employeetypeid'].")";
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
			'keyField'=>'employeetypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'employeetypeid','employeetypename','snroid','sicksnroid','sickstatusid','recordstatus'
				),
				'defaultOrder' => array( 
					'employeetypeid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("insemployeetype")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.employeetypeid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'employeetypeid'=>$model['employeetypeid'],
                        'employeetypename'=>$model['employeetypename'],
                        'snroid'=>$model['snroid'],
                        'sicksnroid'=>$model['sicksnroid'],
                        'sickstatusid'=>$model['sickstatusid'],
                        'recordstatus'=>$model['recordstatus'],
                        'description'=>$model['description'],
                        'sicksnro'=>$model['sicksnro'],
                        'sickstatus'=>$model['sickstatus'],
					));
					Yii::app()->end();
				}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeetypename','string','emptyemployeetypename'),
      array('snroid','string','emptysnroid'),
      array('sicksnroid','string','emptysicksnroid'),
      array('sickstatusid','string','emptysickstatusid'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeetypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update employeetype 
			      set employeetypename = :employeetypename,snroid = :snroid,sicksnroid = :sicksnroid,sickstatusid = :sickstatusid,recordstatus = :recordstatus 
			      where employeetypeid = :employeetypeid';
				}
				else
				{
					$sql = 'insert into employeetype (employeetypename,snroid,sicksnroid,sickstatusid,recordstatus) 
			      values (:employeetypename,:snroid,:sicksnroid,:sickstatusid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':employeetypeid',$_POST['employeetypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':employeetypename',(($_POST['employeetypename']!=='')?$_POST['employeetypename']:null),PDO::PARAM_STR);
        $command->bindvalue(':snroid',(($_POST['snroid']!=='')?$_POST['snroid']:null),PDO::PARAM_STR);
        $command->bindvalue(':sicksnroid',(($_POST['sicksnroid']!=='')?$_POST['sicksnroid']:null),PDO::PARAM_STR);
        $command->bindvalue(':sickstatusid',(($_POST['sickstatusid']!=='')?$_POST['sickstatusid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveemployeetype(:vid,:vcreatedby)';
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
				$sql = 'call Deleteemployeetype(:vid,:vcreatedby)';
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
				$sql = "delete from employeetype where employeetypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('employeetype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('employeetypeid'),$this->getCatalog('employeetypename'),$this->getCatalog('snro'),$this->getCatalog('sicksnro'),$this->getCatalog('sickstatus'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['employeetypeid'],$row1['employeetypename'],$row1['description'],$row1['description'],$row1['sickstatus'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('employeetypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('employeetypename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('longstat'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['employeetypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['employeetypename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['longstat'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}