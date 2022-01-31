<?php

class DoctypeController extends AdminController
{
	protected $menuname = 'doctype';
	public $module = 'Hr';
	protected $pageTitle = 'Jenis Dokumen';
	public $wfname = '';
	protected $sqldata = "select a0.doctypeid,a0.doctypename,a0.recordstatus, if(a0.recordstatus=1,'Aktif','Tidak Aktif') as statusname
    from doctype a0 
  ";
  protected $sqlcount = "select count(1) 
    from doctype a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['doctypename'])))
		{				
			$where .= " where a0.doctypename like '%". $_REQUEST['doctypename']."%'"; 
		}
		if (isset($_REQUEST['doctypeid']))
			{
				if (($_REQUEST['doctypeid'] !== '0') && ($_REQUEST['doctypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.doctypeid in (".$_REQUEST['doctypeid'].")";
					}
					else
					{
						$where .= " and a0.doctypeid in (".$_REQUEST['doctypeid'].")";
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
			'keyField'=>'doctypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'doctypeid','doctypename','recordstatus'
				),
				'defaultOrder' => array( 
					'doctypeid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.doctypeid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'doctypeid'=>$model['doctypeid'],
          'doctypename'=>$model['doctypename'],
          'recordstatus'=>$model['recordstatus'],

					));
					Yii::app()->end();
				}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('doctypename','string','emptydoctypename'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['doctypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatedoctype(:vid,:vdoctypename,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call insertdoctype(:vdoctypename,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['doctypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vdoctypename',(($_POST['doctypename']!=='')?$_POST['doctypename']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
				
/*	
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
				$sql = 'call Approvedoctype(:vid,:vcreatedby)';
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
				$sql = 'call Deletedoctype(:vid,:vcreatedby)';
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
				$sql = "delete from doctype where doctypeid = ".$id[$i];
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
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('doctype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('doctypeid'),$this->getCatalog('doctypename'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['doctypeid'],$row1['doctypename'],$row1['statusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('doctypeid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('doctypename'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['doctypeid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['doctypename'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}