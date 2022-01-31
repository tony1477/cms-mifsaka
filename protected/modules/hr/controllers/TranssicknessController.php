<?php

class TranssicknessController extends AdminController
{
	protected $menuname = 'transsickness';
	public $module = 'Hr';
	protected $pageTitle = 'Transaksi Sakit';
	public $wfname = 'appsickness';
	protected $sqldata = "select a0.transsicknessid,a0.docdate,a0.employeeid,a0.startdate,a0.enddate,a0.description,a0.recordstatus,a1.fullname as fullname,getwfstatusbywfname('appsickness',a0.recordstatus) as statusname  
    from transsickness a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";
  protected $sqlcount = "select count(1) 
    from transsickness a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['description'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['transsicknessid']))
			{
				if (($_REQUEST['transsicknessid'] !== '0') && ($_REQUEST['transsicknessid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.transsicknessid in (".$_REQUEST['transsicknessid'].")";
					}
					else
					{
						$where .= " and a0.transsicknessid in (".$_REQUEST['transsicknessid'].")";
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
			'keyField'=>'transsicknessid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'transsicknessid','docdate','employeeid','startdate','enddate','description','recordstatus'
				),
				'defaultOrder' => array( 
					'transsicknessid' => CSort::SORT_DESC
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
      "recordstatus" =>$this->findstatusbyuser("inssickness")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.transsicknessid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'transsicknessid'=>$model['transsicknessid'],
          'docdate'=>$model['docdate'],
          'employeeid'=>$model['employeeid'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],

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
			array('docdate','string','emptydocdate'),
      array('employeeid','string','emptyemployeeid'),
      array('startdate','string','emptystartdate'),
      array('enddate','string','emptyenddate'),
    ));
		if ($error == false)
		{
			$id = $_POST['transsicknessid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update transsickness 
			      set docdate = :docdate,employeeid = :employeeid,startdate = :startdate,enddate = :enddate,description = :description,recordstatus = :recordstatus 
			      where transsicknessid = :transsicknessid';
				}
				else
				{
					$sql = 'insert into transsickness (docdate,employeeid,startdate,enddate,description,recordstatus) 
			      values (:docdate,:employeeid,:startdate,:enddate,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':transsicknessid',$_POST['transsicknessid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvetranssickness(:vid,:vcreatedby)';
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
				$sql = 'call Deletetranssickness(:vid,:vcreatedby)';
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
				$sql = "delete from transsickness where transsicknessid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('transsickness');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('transsicknessid'),$this->getCatalog('docdate'),$this->getCatalog('employee'),$this->getCatalog('startdate'),$this->getCatalog('enddate'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['transsicknessid'],$row1['docdate'],$row1['fullname'],$row1['startdate'],$row1['enddate'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('transsicknessid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('startdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('enddate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['transsicknessid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['startdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['enddate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['description'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}