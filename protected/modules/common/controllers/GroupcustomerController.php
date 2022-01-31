<?php

class GroupcustomerController extends AdminController
{
	protected $menuname = 'groupcustomer';
	public $module = 'common';
	protected $pageTitle = 'Group Customer';
	public $wfname = 'appgroupcust';
	protected $sqldata = "select a0.groupcustomerid,a0.groupname,a0.recordstatus
    from groupcustomer a0 
  ";
  protected $sqlcount = "select count(1) 
    from groupcustomer a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['groupname'])))
		{				
			$where .= " where a0.groupname like '%". $_REQUEST['groupname']."%'"; 
		}
		if (isset($_REQUEST['groupcustomerid']))
			{
				if (($_REQUEST['groupcustomerid'] !== '0') && ($_REQUEST['groupcustomerid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.groupcustomerid in (".$_REQUEST['groupcustomerid'].")";
					}
					else
					{
						$where .= " and a0.groupcustomerid in (".$_REQUEST['groupcustomerid'].")";
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
			'keyField'=>'groupcustomerid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'groupcustomerid','groupname','recordstatus'
				),
				'defaultOrder' => array( 
					'groupcustomerid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.groupcustomerid = '.$id)->queryRow();
			if ($model !== null)
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
				'status'=>'success',
				'groupcustomerid'=>$model['groupcustomerid'],
          'groupname'=>$model['groupname'],
          'recordstatus'=>$model['recordstatus'],

					));
					Yii::app()->end();
				}
			
			
		}
	}}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('groupname','string','emptygroupname'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['groupcustomerid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update groupcustomer 
			      set groupname = :groupname,recordstatus = :recordstatus 
			      where groupcustomerid = :groupcustomerid';
				}
				else
				{
					$sql = 'insert into groupcustomer (groupname,recordstatus) 
			      values (:groupname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':groupcustomerid',$_POST['groupcustomerid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':groupname',(($_POST['groupname']!=='')?$_POST['groupname']:null),PDO::PARAM_STR);
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
				$sql = 'call Deletegroupcustomer(:vid,:vcreatedby)';
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
				$sql = "delete from groupcustomer where groupcustomerid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('groupcustomer');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('groupcustomerid'),$this->getCatalog('groupname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['groupcustomerid'],$row1['groupname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('groupcustomerid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['groupcustomerid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}