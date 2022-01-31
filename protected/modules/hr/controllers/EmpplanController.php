<?php

class EmpplanController extends AdminController
{
	protected $menuname = 'empplan';
	public $module = 'Hr';
	protected $pageTitle = 'Rencana Kegiatan Karyawan';
	public $wfname = 'appempplan';
	protected $sqldata = "select distinct a0.empplanid,a0.empplanno,a0.empplanname,a0.empplandate,a0.recordstatus,a0.statusname,getwfstatusbywfname('appempplan',a0.recordstatus) as statusname, a0.useraccess
    from empplan a0 
    join empplandetail a1 on a1.empplanid = a0.empplanid
  ";
protected $sqldataempplandetail = "select a0.empplandetailid,a0.empplanid,a0.employeeid,a0.description,a0.objvalue,a0.enddate, a0.startdate,a1.fullname as employeename 
    from empplandetail a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";
  protected $sqlcount = "select count(1) 
    from empplan a0 
    join empplandetail a1 on a0.empplanid = a1.empplanid
  ";
protected $sqlcountempplandetail = "select count(1) 
    from empplandetail a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		/*
        $where = "WHERE a0.recordstatus <> 0 AND a1.employeeid IN (
                SELECT e.employeeid FROM groupmenuauth gm
                LEFT JOIN menuauth m ON m.menuauthid = gm.menuauthid
                LEFT JOIN groupaccess g ON g.groupaccessid = gm.groupaccessid
                LEFT JOIN usergroup u ON u.groupaccessid = g.groupaccessid
                LEFT JOIN useraccess us ON us.useraccessid = u.useraccessid 
                LEFT JOIN employee e ON e.employeeid = gm.menuvalueid
                WHERE us.username='".Yii::app()->user->name."' AND m.menuobject='employee' )";
        */
        $where = "WHERE recordstatus <> 0";
		if ((isset($_REQUEST['empplanno'])) && (isset($_REQUEST['empplanname'])))
		{				
			$where .= " AND a0.empplanno like '%". $_REQUEST['empplanno']."%' 
and a0.empplanname like '%". $_REQUEST['empplanname']."%'"; 
		}
		if (isset($_REQUEST['empplanid']))
			{
				if (($_REQUEST['empplanid'] !== '0') && ($_REQUEST['empplanid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " AND a0.empplanid in (".$_REQUEST['empplanid'].")";
					}
					else
					{
						$where .= " and a0.empplanid in (".$_REQUEST['empplanid'].")";
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
			'keyField'=>'empplanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'empplanid','empplanno','empplanname','empplandate','recordstatus','useraccess'
				),
				'defaultOrder' => array( 
					'empplanid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['empplanid']))
		{
			$this->sqlcountempplandetail .= ' where a0.empplanid = '.$_REQUEST['empplanid'];
			$this->sqldataempplandetail .= ' where a0.empplanid = '.$_REQUEST['empplanid'];
		}
		$countempplandetail = Yii::app()->db->createCommand($this->sqlcountempplandetail)->queryScalar();
$dataProviderempplandetail=new CSqlDataProvider($this->sqldataempplandetail,array(
					'totalItemCount'=>$countempplandetail,
					'keyField'=>'empplandetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'empplandetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderempplandetail'=>$dataProviderempplandetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into empplan (recordstatus) values (".$this->findstatusbyuser('insempplan').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'empplanid'=>$id,
			"empplandate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insempplan")
		));
	}
  public function actionCreateempplandetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"objvalue" =>0,
      "enddate" =>date("Y-m-d"),
      "startdate" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.empplanid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'empplanid'=>$model['empplanid'],
          'empplanname'=>$model['empplanname'],
          'empplandate'=>$model['empplandate'],

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

  public function actionUpdateempplandetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataempplandetail.' where empplandetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'empplandetailid'=>$model['empplandetailid'],
          'empplanid'=>$model['empplanid'],
          'employeeid'=>$model['employeeid'],
          'description'=>$model['description'],
          'objvalue'=>$model['objvalue'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'employeename'=>$model['employeename'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('empplanname','string','emptyempplanname'),
    ));
		if ($error == false)
		{
			$id = $_POST['empplanid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateEmpplan (:empplanid,:empplandate,:empplanname,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':empplanid',$_POST['empplanid'],PDO::PARAM_STR);
				$command->bindvalue(':empplanname',(($_POST['empplanname']!=='')?$_POST['empplanname']:null),PDO::PARAM_STR);
                $command->bindvalue(':empplandate',(($_POST['empplandate']!=='')?$_POST['empplandate']:null),PDO::PARAM_STR);
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
public function actionSaveempplandetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('empplanid','string','emptyempplanid'),
      array('employeeid','string','emptyemployeeid'),
    ));
		if ($error == false)
		{
			$id = $_POST['empplandetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update empplandetail 
			      set empplanid = :empplanid,employeeid = :employeeid,description = :description,objvalue = :objvalue,startdate = :startdate, enddate = :enddate
			      where empplandetailid = :empplandetailid';
				}
				else
				{
					$sql = 'insert into empplandetail (empplanid,employeeid,description,objvalue,startdate,enddate) 
			      values (:empplanid,:employeeid,:description,:objvalue,:startdate,:enddate)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':empplandetailid',$_POST['empplandetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':empplanid',(($_POST['empplanid']!=='')?$_POST['empplanid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':objvalue',(($_POST['objvalue']!=='')?$_POST['objvalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':startdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':enddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
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
        date_default_timezone_set('Asia/Jakarta');
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Approveempplan(:vid,:vcreatedby,:vdate)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
					$command->bindvalue(':vdate',date('Y-m-d'),PDO::PARAM_STR);
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
				$sql = 'call Deleteempplan(:vid,:vcreatedby)';
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
				$sql = "delete from empplan where empplanid = ".$id[$i];
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
	}public function actionPurgeempplandetail()
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
				$sql = "delete from empplandetail where empplandetailid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
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
		$array = ($_REQUEST['empplan_0_empplanid']);
        $ids = explode(',',$array);
        parent::actionDownPDF();
        $where = "WHERE a0.empplanid IN(";
        if(count($ids)==1){
            $where .= "'".$ids['0']."'";
        }else{
            for($i=0; $i<count($ids); $i++){
                if($i+1>=count($ids)){
                    $seperator='';
                }else{
                    $seperator=',';
                }
                $where .= "'$ids[$i]'".$seperator;
            }
        }
        $where .= ")";
        
		$dataReader=Yii::app()->db->createCommand($this->sqldata.$where)->queryAll();

		//masukkan judul
    
		$this->pdf->title=$this->getCatalog('empplan');
		$this->pdf->AddPage('P');
        
        foreach($dataReader as $row){
            $this->pdf->SetFont('Arial','',12);
            $this->pdf->colalign = array('L','L','L','L');
            $this->pdf->setwidths(array(45,40,25,70));            
            $this->pdf->coldetailalign = array('L','L','L','L');
            $this->pdf->row(array('No Kegiatan Rencana ',': '.$row['empplanno'],'','Tanggal Rencana: '.$row['empplandate']));
												
            $this->pdf->setwidths(array(45,135));            
            $this->pdf->coldetailalign = array('L','L');
            $this->pdf->row(array('Nama Rencana  ',': '. $row['empplanname']));

            $this->pdf->sety($this->pdf->gety()+5);
            $this->pdf->SetFont('Arial','',11);
            
            $this->pdf->colalign = array('C','C','C','C','C','C');
            $this->pdf->colheader = array($this->getCatalog('empplandetailid'),$this->getCatalog('fullname'),$this->getCatalog('description'),$this->getCatalog('objvalue'),$this->getCatalog('startdate'),$this->getCatalog('enddate'));
            $this->pdf->setwidths(array(10,40,65,30,22,22));
            $this->pdf->Rowheader();
            $this->pdf->coldetailalign = array('C','L','L','R','C','C');
            
            $this->pdf->SetFont('Arial','',10);
            $detail = Yii::app()->db->createCommand($this->sqldataempplandetail.$where)->queryAll();
            foreach($detail as $row1){
                $this->pdf->row(array($row1['empplandetailid'],$row1['employeename'],$row1['description'],
								Yii::app()->format->formatNumber($row1['objvalue']),$row1['startdate'],$row1['enddate']));
            }
        }
		$this->pdf->Output();
        
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('empplanid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('empplanno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('empplanname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('empplandate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['empplanid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['empplanno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['empplanname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['empplandate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus'])
->setCellValueByColumnAndRow(5, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}