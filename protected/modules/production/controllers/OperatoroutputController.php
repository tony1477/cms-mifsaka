<?php

class OperatoroutputController extends AdminController
{
	protected $menuname = 'operatoroutput';
	public $module = 'Production';
	protected $pageTitle = 'Realisasi Hasil Operator';
	public $wfname = 'AppOpOutput';
	protected $sqldata = "select a0.operatoroutputid,a0.opoutputdate,a0.companyid,a0.slocid,a0.recordstatus,a1.companyname as companyname,a2.sloccode as sloccode,getwfstatusbywfname('AppOpOutput',a0.recordstatus) as statusname  
    from operatoroutput a0 
    left join company a1 on a1.companyid = a0.companyid
    left join sloc a2 on a2.slocid = a0.slocid
  ";
protected $sqldataoperatoroutputdet = "select a0.operatoroutputdetid,a0.operatoroutputid,a0.employeeid,a0.standardopoutputid,a0.qty,a1.fullname as fullname,a2.groupname
    from operatoroutputdet a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join standardopoutput a2 on a2.standardopoutputid = a0.standardopoutputid
  ";
  protected $sqlcount = "select count(1) 
    from operatoroutput a0 
    left join company a1 on a1.companyid = a0.companyid
    left join sloc a2 on a2.slocid = a0.slocid
  ";
protected $sqlcountoperatoroutputdet = "select count(1) 
    from operatoroutputdet a0 
    left join employee a1 on a1.employeeid = a0.employeeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .= " and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['operatoroutputid']))
			{
				if (($_REQUEST['operatoroutputid'] !== '0') && ($_REQUEST['operatoroutputid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.operatoroutputid in (".$_REQUEST['operatoroutputid'].")";
					}
					else
					{
						$where .= " and a0.operatoroutputid in (".$_REQUEST['operatoroutputid'].")";
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
			'keyField'=>'operatoroutputid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'operatoroutputid','opoutputdate','companyname','sloccode','statusname'
				),
				'defaultOrder' => array( 
					'operatoroutputid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['operatoroutputid']))
		{
			$this->sqlcountoperatoroutputdet .= ' where a0.operatoroutputid = '.$_REQUEST['operatoroutputid'];
			$this->sqldataoperatoroutputdet .= ' where a0.operatoroutputid = '.$_REQUEST['operatoroutputid'];
		}
		$countoperatoroutputdet = Yii::app()->db->createCommand($this->sqlcountoperatoroutputdet)->queryScalar();
$dataProvideroperatoroutputdet=new CSqlDataProvider($this->sqldataoperatoroutputdet,array(
					'totalItemCount'=>$countoperatoroutputdet,
					'keyField'=>'operatoroutputdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'operatoroutputdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvideroperatoroutputdet'=>$dataProvideroperatoroutputdet));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into operatoroutput (recordstatus) values (".$this->findstatusbyuser('InsOpOutput').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'operatoroutputid'=>$id,
			"opoutputdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("InsOpOutput")
		));
	}
  public function actionCreateoperatoroutputdet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.operatoroutputid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'operatoroutputid'=>$model['operatoroutputid'],
                       
          'opoutputdate'=>$model['opoutputdate'],
          'companyid'=>$model['companyid'],
          'slocid'=>$model['slocid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'sloccode'=>$model['sloccode'],

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

  public function actionUpdateoperatoroutputdet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataoperatoroutputdet.' where operatoroutputdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'operatoroutputdetid'=>$model['operatoroutputdetid'],
          'operatoroutputid'=>$model['operatoroutputid'],
          'employeeid'=>$model['employeeid'],
          'standardopoutputid'=>$model['standardopoutputid'],
         'groupname'=>$model['groupname'],
          'qty'=>$model['qty'],
          'fullname'=>$model['fullname'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('opoutputdate','string','emptyopoutputdate'),
      array('companyid','string','emptycompanyid'),
      array('slocid','string','emptyslocid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['operatoroutputid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateOpOutput (:operatoroutputid
,:opoutputdate
,:companyid
,:slocid
,:recordstatus,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':operatoroutputid',$_POST['operatoroutputid'],PDO::PARAM_STR);
				$command->bindvalue(':opoutputdate',(($_POST['opoutputdate']!=='')?$_POST['opoutputdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
public function actionSaveoperatoroutputdet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('employeeid','string','emptyemployeeid'),
      array('standardopoutputid','string','emptystandardopoutputid'),
      array('qty','string','emptyqty'),
    ));
		if ($error == false)
		{
			$id = $_POST['operatoroutputdetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update operatoroutputdet 
			      set operatoroutputid = :operatoroutputid,employeeid = :employeeid,standardopoutputid = :standardopoutputid,qty = :qty 
			      where operatoroutputdetid = :operatoroutputdetid';
				}
				else
				{
					$sql = 'insert into operatoroutputdet (operatoroutputid,employeeid,standardopoutputid,qty) 
			      values (:operatoroutputid,:employeeid,:standardopoutputid,:qty)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':operatoroutputdetid',$_POST['operatoroutputdetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':operatoroutputid',(($_POST['operatoroutputid']!=='')?$_POST['operatoroutputid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':standardopoutputid',(($_POST['standardopoutputid']!=='')?$_POST['standardopoutputid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveopoutput(:vid,:vcreatedby)';
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
				$sql = 'call Deleteoperatoroutput(:vid,:vcreatedby)';
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
				$sql = "delete from operatoroutput where operatoroutputid = ".$id[$i];
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
	}public function actionPurgeoperatoroutputdet()
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
				$sql = "delete from operatoroutputdet where operatoroutputdetid = ".$id[$i];
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
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('operatoroutput');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('operatoroutputid'),$this->getCatalog('opoutputdate'),$this->getCatalog('company'),$this->getCatalog('sloc'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['operatoroutputid'],$row1['opoutputdate'],$row1['companyid'],$row1['slocid'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('operatoroutputid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('opoutputdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyid'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('slocid'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['operatoroutputid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['opoutputdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyid'])
->setCellValueByColumnAndRow(3, $i+1, $row1['slocid'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}