<?php

class TransoutController extends AdminController
{
	protected $menuname = 'transout';
	public $module = 'Hr';
	protected $pageTitle = 'Transaksi Ijin Keluar';
	public $wfname = 'apptransout';
	protected $sqldata = "select a0.transoutid,a0.docdate,a0.employeeid,a0.permitexitid,a0.startdate,a0.enddate,a0.description,a0.recordstatus,a1.fullname as fullname,a2.permitexitname as permitexitname,getwfstatusbywfname('apptransout',a0.recordstatus) as statusname  
    from transout a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join permitexit a2 on a2.permitexitid = a0.permitexitid
  ";
  protected $sqlcount = "select count(1) 
    from transout a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join permitexit a2 on a2.permitexitid = a0.permitexitid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['description'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['transoutid']))
			{
				if (($_REQUEST['transoutid'] !== '0') && ($_REQUEST['transoutid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.transoutid in (".$_REQUEST['transoutid'].")";
					}
					else
					{
						$where .= " and a0.transoutid in (".$_REQUEST['transoutid'].")";
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
			'keyField'=>'transoutid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'transoutid','docdate','employeeid','permitexitid','startdate','enddate','description','recordstatus'
				),
				'defaultOrder' => array( 
					'transoutid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"docdate" =>date("Y-m-d"),
      "startdate" =>date("Y-m-d H:i:s"),
      "enddate" =>date("Y-m-d H:i:s"),
      "recordstatus" =>$this->findstatusbyuser("instransout")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.transoutid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'transoutid'=>$model['transoutid'],
          'docdate'=>$model['docdate'],
          'employeeid'=>$model['employeeid'],
          'permitexitid'=>$model['permitexitid'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'permitexitname'=>$model['permitexitname'],

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
      array('permitexitid','string','emptypermitexitid'),
      array('startdate','string','emptystartdate'),
      array('enddate','string','emptyenddate'),
    ));
		if ($error == false)
		{
			$id = $_POST['transoutid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update transout 
			      set docdate = :docdate,employeeid = :employeeid,permitexitid = :permitexitid,startdate = :startdate,enddate = :enddate,description = :description,recordstatus = :recordstatus 
			      where transoutid = :transoutid';
				}
				else
				{
					$sql = 'insert into transout (docdate,employeeid,permitexitid,startdate,enddate,description,recordstatus) 
			      values (:docdate,:employeeid,:permitexitid,:startdate,:enddate,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':transoutid',$_POST['transoutid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':permitexitid',(($_POST['permitexitid']!=='')?$_POST['permitexitid']:null),PDO::PARAM_STR);
        $command->bindvalue(':startdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':enddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvetransout(:vid,:vcreatedby)';
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
				$sql = 'call Deletetransout(:vid,:vcreatedby)';
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
				$sql = "delete from transout where transoutid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('transout');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('transoutid'),$this->getCatalog('docdate'),$this->getCatalog('employee'),$this->getCatalog('permitexit'),$this->getCatalog('startdate'),$this->getCatalog('enddate'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['transoutid'],$row1['docdate'],$row1['fullname'],$row1['permitexitname'],$row1['startdate'],$row1['enddate'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('transoutid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('permitexitname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('startdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('enddate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['transoutid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['permitexitname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['startdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['enddate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['description'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}