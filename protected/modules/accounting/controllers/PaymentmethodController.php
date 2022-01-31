<?php

class PaymentmethodController extends AdminController
{
	protected $menuname = 'paymentmethod';
	public $module = 'Accounting';
	protected $pageTitle = 'Metode Pembayaran';
	public $wfname = '';
	protected $sqldata = "select a0.paymentmethodid,a0.paycode,a0.paydays,a0.paymentname,a0.recordstatus 
    from paymentmethod a0 
  ";
  protected $sqlcount = "select count(1) 
    from paymentmethod a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['paycode'])) && (isset($_REQUEST['paymentname'])))
		{				
			$where .= " where a0.paycode like '%". $_REQUEST['paycode']."%' 
and a0.paymentname like '%". $_REQUEST['paymentname']."%'"; 
		}
		if (isset($_REQUEST['paymentmethodid']))
			{
				if (($_REQUEST['paymentmethodid'] !== '0') && ($_REQUEST['paymentmethodid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.paymentmethodid in (".$_REQUEST['paymentmethodid'].")";
					}
					else
					{
						$where .= " and a0.paymentmethodid in (".$_REQUEST['paymentmethodid'].")";
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
			'keyField'=>'paymentmethodid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'paymentmethodid','paycode','paydays','paymentname','recordstatus'
				),
				'defaultOrder' => array( 
					'paymentmethodid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.paymentmethodid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'paymentmethodid'=>$model['paymentmethodid'],
          'paycode'=>$model['paycode'],
          'paydays'=>$model['paydays'],
          'paymentname'=>$model['paymentname'],
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
			array('paycode','string','emptypaycode'),
      array('paydays','string','emptypaydays'),
      array('paymentname','string','emptypaymentname'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['paymentmethodid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update paymentmethod 
			      set paycode = :paycode,paydays = :paydays,paymentname = :paymentname,recordstatus = :recordstatus 
			      where paymentmethodid = :paymentmethodid';
				}
				else
				{
					$sql = 'insert into paymentmethod (paycode,paydays,paymentname,recordstatus) 
			      values (:paycode,:paydays,:paymentname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':paymentmethodid',$_POST['paymentmethodid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':paycode',(($_POST['paycode']!=='')?$_POST['paycode']:null),PDO::PARAM_STR);
        $command->bindvalue(':paydays',(($_POST['paydays']!=='')?$_POST['paydays']:null),PDO::PARAM_STR);
        $command->bindvalue(':paymentname',(($_POST['paymentname']!=='')?$_POST['paymentname']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from paymentmethod where paymentmethodid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update paymentmethod set recordstatus = 0 where paymentmethodid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update paymentmethod set recordstatus = 1 where paymentmethodid = ".$id[$i];
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
				$sql = "delete from paymentmethod where paymentmethodid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('paymentmethod');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('paymentmethodid'),$this->getCatalog('paycode'),$this->getCatalog('paydays'),$this->getCatalog('paymentname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['paymentmethodid'],$row1['paycode'],$row1['paydays'],$row1['paymentname'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('paymentmethodid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('paycode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('paydays'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('paymentname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['paymentmethodid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['paycode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['paydays'])
->setCellValueByColumnAndRow(3, $i+1, $row1['paymentname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}