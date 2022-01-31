<?php

class ReportorderController extends AdminController
{
	protected $menuname = 'reportorder';
	public $module = 'reportgroup';
	protected $pageTitle = 'Laporan Penjualan';
	public $wfname = '';
	protected $sqldata = "select 
    from  ";
  protected $sqlcount = "select count(1) 
    from  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ()
		{				
			$where .= "; 
		}
		if (isset($_REQUEST['']))
			{
				if (($_REQUEST[''] !== '0') && ($_REQUEST[''] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0. in (".$_REQUEST[''].")";
					}
					else
					{
						$where .= " and a0. in (".$_REQUEST[''].")";
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
			'keyField'=>'',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					
				),
				'defaultOrder' => array( 
					'' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0. = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					
				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST[''];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update reportorder 
			      set  
			      where  = :';
				}
				else
				{
					$sql = 'insert into reportorder () 
			      values ()';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':',$_POST[''],PDO::PARAM_STR);
				}
				
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
				
	
	
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('reportorder');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array();
		$this->pdf->colheader = array();
		$this->pdf->setwidths(array());
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array();
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array());
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
					;
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					;
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}