<?php

class TransdocController extends AdminController
{
	protected $menuname = 'transdoc';
	public $module = 'HR';
	protected $pageTitle = 'Serah Terima Dokumen';
	public $wfname = 'apptransdoc';
	protected $sqldata = "select a0.transdocid,a0.transdocno,a0.transdate,a0.fromemployeeid,a0.toemployeeid,a0.docupload,a0.recordstatus,a0.statusname,a1.fullname as fromfullname,a2.fullname as tofullname,a0.recordstatus
    from transdoc a0 
    left join employee a1 on a1.employeeid = a0.fromemployeeid
    left join employee a2 on a2.employeeid = a0.toemployeeid
  ";
protected $sqldatatransdocdet = "select a0.transdocdetid,a0.transdocid,a0.legaldocid,a0.storagedocid,a1.docname as docname,a2.storagedocname as storagedocname 
    from transdocdet a0 
    left join legaldoc a1 on a1.legaldocid = a0.legaldocid
    left join storagedoc a2 on a2.storagedocid = a0.storagedocid
  ";
  protected $sqlcount = "select count(1) 
    from transdoc a0 
    left join employee a1 on a1.employeeid = a0.fromemployeeid
    left join employee a2 on a2.employeeid = a0.toemployeeid
  ";
protected $sqlcounttransdocdet = "select count(1) 
    from transdocdet a0 
    left join legaldoc a1 on a1.legaldocid = a0.legaldocid
    left join storagedoc a2 on a2.storagedocid = a0.storagedocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['transdocno'])) && (isset($_REQUEST['docupload'])))
		{				
			$where .= " where a0.transdocno like '%". $_REQUEST['transdocno']."%' 
and a0.docupload like '%". $_REQUEST['docupload']."%'"; 
		}
		if (isset($_REQUEST['transdocid']))
			{
				if (($_REQUEST['transdocid'] !== '0') && ($_REQUEST['transdocid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.transdocid in (".$_REQUEST['transdocid'].")";
					}
					else
					{
						$where .= " and a0.transdocid in (".$_REQUEST['transdocid'].")";
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
			'keyField'=>'transdocid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'transdocid','transdocno','transdate','fromemployeeid','toemployeeid','docupload','recordstatus','statusname'
				),
				'defaultOrder' => array( 
					'transdocid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['transdocid']))
		{
			$this->sqlcounttransdocdet .= ' where a0.transdocid = '.$_REQUEST['transdocid'];
			$this->sqldatatransdocdet .= ' where a0.transdocid = '.$_REQUEST['transdocid'];
		}
		$counttransdocdet = Yii::app()->db->createCommand($this->sqlcounttransdocdet)->queryScalar();
$dataProvidertransdocdet=new CSqlDataProvider($this->sqldatatransdocdet,array(
					'totalItemCount'=>$counttransdocdet,
					'keyField'=>'transdocdetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'transdocdetid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidertransdocdet'=>$dataProvidertransdocdet));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into transdoc (recordstatus) values (".$this->findstatusbyuser('instransdoc').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'transdocid'=>$id,
			"transdate" =>date("Y-m-d")
		));
	}
  public function actionCreatetransdocdet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.transdocid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'transdocid'=>$model['transdocid'],
          'transdate'=>$model['transdate'],
          'fromemployeeid'=>$model['fromemployeeid'],
          'toemployeeid'=>$model['toemployeeid'],
          'docupload'=>$model['docupload'],
          'fromfullname'=>$model['fromfullname'],
          'tofullname'=>$model['tofullname'],

					));
					Yii::app()->end();
				}
		}
	}

  public function actionUpdatetransdocdet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatatransdocdet.' where transdocdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'transdocdetid'=>$model['transdocdetid'],
          'transdocid'=>$model['transdocid'],
          'legaldocid'=>$model['legaldocid'],
          'storagedocid'=>$model['storagedocid'],
          'docname'=>$model['docname'],
          'storagedocname'=>$model['storagedocname'],

				));
				Yii::app()->end();
			}
		}
	}
	
    public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/transdoc/'))
		{
            mkdir(Yii::getPathOfAlias('webroot').'/images/transdoc/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/transdoc/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
    
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('fromemployeeid','string','emptyfromemployee'),
			array('toemployeeid','string','emptytoemployee'),
			array('transdate','string','emptytransdate'),
    ));
		if ($error == false)
		{
			$id = $_POST['transdocid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatetransdoc (:vid,:vtransdate,:vfromemployeeid,:vtoemployeeid,:vdocupload,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['transdocid'],PDO::PARAM_STR);
				$command->bindvalue(':vtransdate',(($_POST['transdate']!=='')?$_POST['transdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vfromemployeeid',(($_POST['fromemployeeid']!=='')?$_POST['fromemployeeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vtoemployeeid',(($_POST['toemployeeid']!=='')?$_POST['toemployeeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocupload',(($_POST['docupload']!=='')?$_POST['docupload']:null),PDO::PARAM_STR);
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
public function actionSavetransdocdet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('transdocid','string','emptytransdocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['transdocdetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatetransdocdetail(:vid,:vtransdocid,:vlegaldocid,:vstoragedocid,:vcreatedby)';
				}
				else
				{
					$sql = 'call Inserttransdocdetail(:vtransdocid,:vlegaldocid,:vstoragedocid,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['transdocdetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vtransdocid',(($_POST['transdocid']!=='')?$_POST['transdocid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlegaldocid',(($_POST['legaldocid']!=='')?$_POST['legaldocid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vstoragedocid',(($_POST['storagedocid']!=='')?$_POST['storagedocid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvetransdoc(:vid,:vcreatedby)';
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
				$sql = 'call Deletetransdoc(:vid,:vcreatedby)';
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
    /*
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
				$sql = "delete from transdoc where transdocid = ".$id[$i];
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
    */
    public function actionPurgetransdocdet()
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
				    $sql = "delete from transdocdet where transdocdetid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('transdoc');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('transdocid'),$this->getCatalog('transdocno'),$this->getCatalog('transdate'),$this->getCatalog('fromemployee'),$this->getCatalog('toemployee'),$this->getCatalog('docupload'),$this->getCatalog('recordstatus'),$this->getCatalog('statusname'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['transdocid'],$row1['transdocno'],$row1['transdate'],$row1['fullname'],$row1['fullname'],$row1['docupload'],$row1['recordstatus'],$row1['statusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('transdocid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('transdocno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('transdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('docupload'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['transdocid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['transdocno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['transdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['docupload'])
->setCellValueByColumnAndRow(7, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}