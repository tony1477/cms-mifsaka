<?php

class RealplanController extends AdminController
{
	protected $menuname = 'realplan';
	public $module = 'Hr';
	protected $pageTitle = 'Realisasi Rencana Kegiatan';
	public $wfname = 'apprealplan';
	protected $sqldata = "select distinct a0.realplanid,a0.empplanid,a0.employeeid,a0.description,a0.objvalue,a0.recordstatus,a0.statusname,a1.empplanname as empplanname,a2.fullname as fullname, 
                          a0.realdate, a0.dateline, a0.hambatan, a0.solusi, case when foto = '' then 'default.jpg' else foto end as foto, b.description as empplandetail, b.empplandetailid
    from realplan a0 
    inner join empplan a on a.empplanid = a0.empplanid
    left join empplandetail b on b.empplandetailid = a0.empplandetailid
    left join empplan a1 on a1.empplanid = a0.empplanid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
  protected $sqlcount = "select count(distinct a0.realplanid) 
    from realplan a0 
    inner join empplan a on a.empplanid = a0.empplanid
    inner join empplandetail b on b.empplanid = a.empplanid
    left join empplan a1 on a1.empplanid = a0.empplanid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " WHERE a0.recordstatus <> 0";
		if ((isset($_REQUEST['fullname'])))
		{				
			$where .= " AND a2.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
		if (isset($_REQUEST['realplanid']))
			{
				if (($_REQUEST['realplanid'] !== '0') && ($_REQUEST['realplanid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " AND a0.realplanid in (".$_REQUEST['realplanid'].")";
					}
					else
					{
						$where .= " and a0.realplanid in (".$_REQUEST['realplanid'].")";
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
			'keyField'=>'realplanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'realplanid','empplanid','empplandetail','employeeid','realdate','dateline','hambatan','solusi','foto','description','objvalue','recordstatus'
				),
				'defaultOrder' => array( 
					'realplanid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			"realdate" =>date("Y-m-d"),
            "dateline" =>date("Y-m-d"),
			"objvalue" =>0,
            "recordstatus" =>$this->findstatusbyuser("insrealplan")
		));
	}
    
    public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/employee/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/employee/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/employee/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
    
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.realplanid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
					echo CJSON::encode(array(
						'status'=>'success',
						'realplanid'=>$model['realplanid'],
          'empplanid'=>$model['empplanid'],
          'empplandetailid'=>$model['empplandetailid'],
          'empplandetail'=>$model['empplandetail'],
          'employeeid'=>$model['employeeid'],
          'description'=>$model['description'],
          'objvalue'=>$model['objvalue'],
          'empplanname'=>$model['empplanname'],
          'fullname'=>$model['fullname'],
          'hambatan'=>$model['hambatan'],
          'solusi'=>$model['solusi'],
          'foto'=>$model['foto'],
          'dateline'=>$model['dateline'],
          'realdate'=>$model['realdate']
					));
					
				
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
			array('empplanid','string','emptyempplanid'),
            array('employeeid','string','emptyemployeeid'),
    ));
		if ($error == false)
		{
			$id = $_POST['realplanid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update realplan 
			      set empplanid = :empplanid,employeeid = :employeeid, realdate= :realdate, dateline = :dateline, hambatan = :hambatan, solusi = :solusi, foto = :foto, description = :description,objvalue = :objvalue, empplandetailid = :empplandetailid 
			      where realplanid = :realplanid';
				}
				else
				{
					$sql = 'insert into realplan (empplanid,employeeid,realdate,dateline,hambatan,solusi,foto,description,objvalue,empplandetailid)
			      values (:empplanid,:employeeid,:realdate,:dateline,:hambatan,:solusi,:foto,:description,:objvalue,:empplandetailid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':realplanid',$_POST['realplanid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':empplanid',(($_POST['empplanid']!=='')?$_POST['empplanid']:null),PDO::PARAM_STR);
				$command->bindvalue(':empplandetailid',(($_POST['empplandetailid']!=='')?$_POST['empplandetailid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':realdate',(($_POST['realdate']!=='')?$_POST['realdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':dateline',(($_POST['dateline']!=='')?$_POST['dateline']:null),PDO::PARAM_STR);
        $command->bindvalue(':hambatan',(($_POST['hambatan']!=='')?$_POST['hambatan']:null),PDO::PARAM_STR);
        $command->bindvalue(':solusi',(($_POST['solusi']!=='')?$_POST['solusi']:null),PDO::PARAM_STR);
        $command->bindvalue(':foto',(($_POST['foto']!=='')?$_POST['foto']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':objvalue',(($_POST['objvalue']!=='')?$_POST['objvalue']:null),PDO::PARAM_STR);
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
				$sql = 'call Approverealplan(:vid,:vcreatedby)';
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
				$sql = 'call Deleterealplan(:vid,:vcreatedby)';
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
				$sql = "delete from realplan where realplanid = ".$id[$i];
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
	public function actionDownPDF1()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('realplan');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('L','L','L','L','L','L','L');
		$this->pdf->colheader = array($this->getCatalog('realplanid'),$this->getCatalog('empplanname'),$this->getCatalog('employee'),$this->getCatalog('description'),$this->getCatalog('objvalue'),$this->getCatalog('recordstatus'),$this->getCatalog('statusname'));
		$this->pdf->setwidths(array(10,40,35,40,30,15,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['realplanid'],$row1['empplanname'],$row1['fullname'],$row1['description'],$row1['objvalue'],$row1['recordstatus'],$row1['statusname']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
    
    public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('realplan');
		$this->pdf->AddPage('L');
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L');
        $this->pdf->SetFont('Arial','',11);
		$this->pdf->colheader = array($this->getCatalog('realplanid'),$this->getCatalog('empplanname'),$this->getCatalog('employee'),$this->getCatalog('objvalue'),$this->getCatalog('realdate'),$this->getCatalog('dateline'),$this->getCatalog('description'),$this->getCatalog('hambatan'),$this->getCatalog('solusi'),$this->getCatalog('statusname'));
		$this->pdf->setwidths(array(10,30,30,25,23,23,35,35,35,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
		
        
        $this->pdf->SetFont('Arial','',10);
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
            if($row1['foto']=='' or $row1['foto']==='null'){
                $images = 'default.jpg';
            }else{
                $images = $row1['foto'];
            }
		  $this->pdf->row(array($row1['realplanid'],$row1['empplanname'],$row1['fullname'],$row1['objvalue'],$row1['realdate'],$row1['dateline'],$row1['description'],$row1['hambatan'],$row1['solusi'],$row1['statusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('realplanid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('empplanname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('objvalue'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['realplanid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['empplanname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['objvalue']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}