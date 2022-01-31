<?php

class OnleavetransController extends AdminController
{
	protected $menuname = 'onleavetrans';
	public $module = 'Hr';
	protected $pageTitle = 'Transaksi Cuti';
	public $wfname = 'apponleave';
	protected $sqldata = "select a0.onleavetransid,a0.docdate,a0.employeeid,a0.onleavetypeid,a0.startdate,a0.enddate,a0.description,a0.recordstatus,a1.fullname as fullname,a2.onleavename as onleavename,getwfstatusbywfname('apponleave',a0.recordstatus) as statusname  
    from onleavetrans a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join onleavetype a2 on a2.onleavetypeid = a0.onleavetypeid
  ";
  protected $sqlcount = "select count(1) 
    from onleavetrans a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join onleavetype a2 on a2.onleavetypeid = a0.onleavetypeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['description'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%'"; 
		}
		if (isset($_REQUEST['onleavetransid']))
			{
				if (($_REQUEST['onleavetransid'] !== '0') && ($_REQUEST['onleavetransid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.onleavetransid in (".$_REQUEST['onleavetransid'].")";
					}
					else
					{
						$where .= " and a0.onleavetransid in (".$_REQUEST['onleavetransid'].")";
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
			'keyField'=>'onleavetransid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'onleavetransid','docdate','employeeid','onleavetypeid','startdate','enddate','description','recordstatus'
				),
				'defaultOrder' => array( 
					'onleavetransid' => CSort::SORT_DESC
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
      "startdate" =>date("Y-m-d"),
      "enddate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insonleave")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.onleavetransid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'onleavetransid'=>$model['onleavetransid'],
          'docdate'=>$model['docdate'],
          'employeeid'=>$model['employeeid'],
          'onleavetypeid'=>$model['onleavetypeid'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'onleavename'=>$model['onleavename'],

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
      array('onleavetypeid','string','emptyonleavetypeid'),
      array('startdate','string','emptystartdate'),
      array('enddate','string','emptyenddate'),
    ));
		if ($error == false)
		{
			$id = $_POST['onleavetransid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update onleavetrans 
			      set docdate = :docdate,employeeid = :employeeid,onleavetypeid = :onleavetypeid,startdate = :startdate,enddate = :enddate,description = :description,recordstatus = :recordstatus 
			      where onleavetransid = :onleavetransid';
				}
				else
				{
					$sql = 'insert into onleavetrans (docdate,employeeid,onleavetypeid,startdate,enddate,description,recordstatus) 
			      values (:docdate,:employeeid,:onleavetypeid,:startdate,:enddate,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':onleavetransid',$_POST['onleavetransid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':onleavetypeid',(($_POST['onleavetypeid']!=='')?$_POST['onleavetypeid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveonleavetrans(:vid,:vcreatedby)';
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
				$sql = 'call Deleteonleavetrans(:vid,:vcreatedby)';
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
				$sql = "delete from onleavetrans where onleavetransid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('onleavetrans');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('onleavetransid'),$this->getCatalog('docdate'),$this->getCatalog('employee'),$this->getCatalog('onleavetype'),$this->getCatalog('startdate'),$this->getCatalog('enddate'),$this->getCatalog('description'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['onleavetransid'],$row1['docdate'],$row1['fullname'],$row1['onleavename'],$row1['startdate'],$row1['enddate'],$row1['description'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('onleavetransid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('onleavename'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('startdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('enddate'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['onleavetransid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['onleavename'])
->setCellValueByColumnAndRow(4, $i+1, $row1['startdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['enddate'])
->setCellValueByColumnAndRow(6, $i+1, $row1['description'])
->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}