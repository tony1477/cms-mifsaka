<?php

class FakturpajakController extends AdminController
{
	protected $menuname = 'fakturpajak';
	public $module = 'Accounting';
	protected $pageTitle = 'Faktur Pajak';
	public $wfname = '';
	protected $sqldata = "select a0.fakturpajakid,a0.fakturpajakno,a0.invoiceid,a1.invoiceno as invoiceno  
    from fakturpajak a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
  ";
  protected $sqlcount = "select count(1) 
    from fakturpajak a0 
    left join invoice a1 on a1.invoiceid = a0.invoiceid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['fakturpajakno'])) && (isset($_REQUEST['invoiceno'])))
		{				
			$where .= " where a0.fakturpajakno like '%". $_REQUEST['fakturpajakno']."%' 
and a1.invoiceno like '%". $_REQUEST['invoiceno']."%'"; 
		}
		if (isset($_REQUEST['fakturpajakid']))
			{
				if (($_REQUEST['fakturpajakid'] !== '0') && ($_REQUEST['fakturpajakid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.fakturpajakid in (".$_REQUEST['fakturpajakid'].")";
					}
					else
					{
						$where .= " and a0.fakturpajakid in (".$_REQUEST['fakturpajakid'].")";
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
			'keyField'=>'fakturpajakid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'fakturpajakid','fakturpajakno','invoiceid'
				),
				'defaultOrder' => array( 
					'fakturpajakid' => CSort::SORT_DESC
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
	
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('fakturpajakno','string','emptyfakturpajakno'),
      array('invoiceid','string','emptyinvoiceid'),
    ));
		if ($error == false)
		{
			$id = $_POST['fakturpajakid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update fakturpajak 
			      set fakturpajakno = :fakturpajakno,invoiceid = :invoiceid 
			      where fakturpajakid = :fakturpajakid';
				}
				else
				{
					$sql = 'insert into fakturpajak (fakturpajakno,invoiceid) 
			      values (:fakturpajakno,:invoiceid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':fakturpajakid',$_POST['fakturpajakid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':fakturpajakno',(($_POST['fakturpajakno']!=='')?$_POST['fakturpajakno']:null),PDO::PARAM_STR);
        $command->bindvalue(':invoiceid',(($_POST['invoiceid']!=='')?$_POST['invoiceid']:null),PDO::PARAM_STR);
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
				$sql = "delete from fakturpajak where fakturpajakid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('fakturpajak');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('fakturpajakid'),$this->getCatalog('fakturpajakno'),$this->getCatalog('invoice'));
		$this->pdf->setwidths(array(10,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['fakturpajakid'],$row1['fakturpajakno'],$row1['invoiceno']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('fakturpajakid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fakturpajakno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('invoiceno'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['fakturpajakid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fakturpajakno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['invoiceno']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}