<?php

class AbstransController extends AdminController
{
	protected $menuname = 'abstrans';
	public $module = 'Hr';
	protected $pageTitle = 'Transaksi Absensi';
	public $wfname = 'appabstrans';
	protected $sqldata = "select a0.abstransid,a0.employeeid,a0.datetimeclock,a0.time,a0.reason,a0.status,a0.recordstatus,a1.fullname as fullname,a2.longstat as longstat,getwfstatusbywfname('appabstrans',a0.recordstatus) as statusname  
    from abstrans a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join absstatus a2 on a2.longstat = a0.status
  ";
  protected $sqlcount = "select count(1) 
    from abstrans a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join absstatus a2 on a2.longstat = a0.status
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['reason'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['longstat'])))
		{				
			$where .= " where a0.reason like '%". $_REQUEST['reason']."%' 
and a1.fullname like '%". $_REQUEST['fullname']."%' 
and a2.longstat like '%". $_REQUEST['longstat']."%'"; 
		}
		if (isset($_REQUEST['abstransid']))
			{
				if (($_REQUEST['abstransid'] !== '0') && ($_REQUEST['abstransid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.abstransid in (".$_REQUEST['abstransid'].")";
					}
					else
					{
						$where .= " and a0.abstransid in (".$_REQUEST['abstransid'].")";
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
			'keyField'=>'abstransid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'abstransid','employeeid','datetimeclock','time','reason','status','recordstatus'
				),
				'defaultOrder' => array( 
					'abstransid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
    
    public function actionUploaddata()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		}
		$this->storeFolder = dirname('__FILES__').'/uploads/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	
	public function actionRunning()
	{
		$s = $_POST['id'];
		Yii::import('ext.phpexcel.XPHPExcel');
		Yii::import('ext.phpexcel.vendor.PHPExcel'); 
		$phpExcel = XPHPExcel::createPHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$phpExcel = $objReader->load(dirname('__FILES__').'/uploads/'.$s);
		$connection = Yii::app()->db;
        try{
			$sheet = $phpExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
            //$transaction = $connection->beginTransaction();
            for($i=2; $i<=$highestRow; $i++){
                $nik = $sheet->getCell('B'.$i)->getValue();
                $dept = $sheet->getCell('C'.$i)->getValue();
                $c = 0;
                if($dept!='SECURITY'){
                    $employeeid = Yii::app()->db->createCommand("select employeeid from employee where cast(oldnik as int) = ".intval($nik)."")->queryScalar();
                    if($employeeid !='' || $employeeid!=null){
                        $day = $sheet->getCell('E'.$i)->getValue();
                        $format = 'd/m/Y H:i:s';
                        $date = DateTime::createFromFormat($format, $day);
                        $pola = $sheet->getCell('F'.$i);
                        
                        if($day !=='' || $day !== null){
                            
                            $sql = "call insertabstransupload(:vemployeeid,:vdatetime,:vcreatedby,:vcount)";
                            $command = $connection->createCommand($sql);
                            $command->bindvalue(':vemployeeid',$employeeid,PDO::PARAM_STR);
                            $command->bindvalue(':vdatetime',$date->format('Y-m-d H:i:s'),PDO::PARAM_STR);
                            $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
                            $command->bindvalue(':vcount',$c,PDO::PARAM_STR);
                            $command->execute();
                            
                            /*
                            $sql = "insert into abstrans(employeeid,datetimeclock,recordstatus)
	                               values (".$employeeid.",'".$date->format('Y-m-d H:i:s')."',2)";
                            $cmd = Yii::app()->db->createCommand($sql)->execute();
                            /*
                            $sid = "select last_insert_id()";
                            $id = Yii::app()->db->createCommand($sid)->queryScalar();
                    
                            $proc = "call approveabstrans(".($id+$c).",'".Yii::app()->user->id."')";
                            $exec = Yii::app()->db->createCommand($proc)->execute();
                            */
                            
			                //$this->getMessage('success',"alreadysaved");
                    }
                }
            }
			
        }
            /*
            $user = Yii::app()->user->id;
            $sql2 = "call insertabstransupload('".$user."')";
            $cmd1 = Yii::app()->db->createCommand($sql2)->execute();
            */
            $this->getMessage('success',"alreadysaved");
            }
                catch (Exception $e){
			     $this->getMessage('error',$e->getMessage());
		  }
	}
    
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"datetimeclock" =>date("Y-m-d H:i:s"),
      "recordstatus" =>$this->findstatusbyuser("insabstrans")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.abstransid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'abstransid'=>$model['abstransid'],
          'employeeid'=>$model['employeeid'],
          'datetimeclock'=>$model['datetimeclock'],
          'time'=>$model['time'],
          'reason'=>$model['reason'],
          'status'=>$model['status'],
          'fullname'=>$model['fullname'],
          'longstat'=>$model['longstat'],

					));
					Yii::app()->end();
				}
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
      array('datetimeclock','string','emptydatetimeclock'),
    ));
		if ($error == false)
		{
			$id = $_POST['abstransid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update abstrans 
			      set employeeid = :employeeid,datetimeclock = :datetimeclock,reason = :reason,status = :status 
			      where abstransid = :abstransid';
				}
				else
				{
					$sql = 'insert into abstrans (employeeid,datetimeclock,reason,status,recordstatus) 
			      values (:employeeid,:datetimeclock,:reason,:status,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':abstransid',$_POST['abstransid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':datetimeclock',(($_POST['datetimeclock']!=='')?$_POST['datetimeclock']:null),PDO::PARAM_STR);
        
        $command->bindvalue(':reason',(($_POST['reason']!=='')?$_POST['reason']:null),PDO::PARAM_STR);
        $command->bindvalue(':status',(($_POST['status']!=='')?$_POST['status']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus','1',PDO::PARAM_STR);
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
				$sql = 'call Approveabstrans(:vid,:vcreatedby)';
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
				$sql = 'call Deleteabstrans(:vid,:vcreatedby)';
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
				$sql = "delete from abstrans where abstransid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('abstrans');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('abstransid'),$this->getCatalog('employee'),$this->getCatalog('datetimeclock'),$this->getCatalog('time'),$this->getCatalog('reason'),$this->getCatalog('status'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		$day = '11/01/2017 07:43:23';
        $format = 'd/m/Y H:i:s';
        $date = DateTime::createFromFormat($format, $day);
        
        //$newtime = strtotime($day);
        
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['abstransid'],$row1['fullname'],$row1['datetimeclock'],$date->format('H:i:s').' '.$date->format('Y-m-d'),$row1['reason'],$row1['longstat'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('abstransid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('datetimeclock'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('time'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('reason'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('longstat'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['abstransid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['datetimeclock'])
->setCellValueByColumnAndRow(3, $i+1, $row1['time'])
->setCellValueByColumnAndRow(4, $i+1, $row1['reason'])
->setCellValueByColumnAndRow(5, $i+1, $row1['longstat'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}