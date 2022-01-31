<?php

class AccounttypeController extends AdminController
{
	protected $menuname = 'accounttype';
	public $module = 'Accounting';
	protected $pageTitle = 'Jenis Akun';
	public $wfname = '';
	protected $sqldata = "select a0.accounttypeid,a0.accounttypename,a0.parentaccounttypeid,a0.recordstatus,a1.accountcode as accountcode 
    from accounttype a0 
    left join account a1 on a1.accountid = a0.parentaccounttypeid
  ";
  protected $sqlcount = "select count(1) 
    from accounttype a0 
    left join account a1 on a1.accountid = a0.parentaccounttypeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['accounttypename'])))
		{				
			$where .= " where a0.accounttypename like '%". $_REQUEST['accounttypename']."%'"; 
		}
		if (isset($_REQUEST['accounttypeid']))
			{
				if (($_REQUEST['accounttypeid'] !== '0') && ($_REQUEST['accounttypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.accounttypeid in (".$_REQUEST['accounttypeid'].")";
					}
					else
					{
						$where .= " and a0.accounttypeid in (".$_REQUEST['accounttypeid'].")";
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
			'keyField'=>'accounttypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'accounttypeid','accounttypename','parentaccounttypeid','recordstatus'
				),
				'defaultOrder' => array( 
					'accounttypeid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.accounttypeid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'accounttypeid'=>$model['accounttypeid'],
          'accounttypename'=>$model['accounttypename'],
          'parentaccounttypeid'=>$model['parentaccounttypeid'],
          'recordstatus'=>$model['recordstatus'],
          'accountcode'=>$model['accountcode'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('accounttypename','string','emptyaccounttypename'),
    ));
		if ($error == false)
		{
			$id = $_POST['accounttypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update accounttype 
			      set accounttypename = :accounttypename,parentaccounttypeid = :parentaccounttypeid,recordstatus = :recordstatus 
			      where accounttypeid = :accounttypeid';
				}
				else
				{
					$sql = 'insert into accounttype (accounttypename,parentaccounttypeid,recordstatus) 
			      values (:accounttypename,:parentaccounttypeid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':accounttypeid',$_POST['accounttypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':accounttypename',(($_POST['accounttypename']!=='')?$_POST['accounttypename']:null),PDO::PARAM_STR);
        $command->bindvalue(':parentaccounttypeid',(($_POST['parentaccounttypeid']!=='')?$_POST['parentaccounttypeid']:null),PDO::PARAM_STR);
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
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from accounttype where accounttypeid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update accounttype set recordstatus = 0 where accounttypeid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update accounttype set recordstatus = 1 where accounttypeid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
				$sql = "delete from accounttype where accounttypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('accounttype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('accounttypeid'),$this->getCatalog('accounttypename'),$this->getCatalog('parentaccounttype'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['accounttypeid'],$row1['accounttypename'],$row1['accountcode'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('accounttypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('accounttypename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('accountcode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['accounttypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['accounttypename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['accountcode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}