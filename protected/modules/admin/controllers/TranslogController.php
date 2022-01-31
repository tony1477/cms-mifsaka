<?php

class TranslogController extends AdminController
{
	protected $menuname = 'translog';
	public $module = 'Admin';
	protected $pageTitle = 'Catatan Transaksi';
	public $wfname = '';
	protected $sqldata = "select a0.translogid,a0.username,a0.createddate,a0.useraction,a0.newdata,a0.menuname,a0.tableid 
    from translog a0 
  ";
  protected $sqlcount = "select count(1) 
    from translog a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['username'])) && (isset($_REQUEST['useraction'])) && (isset($_REQUEST['menuname'])))
		{				
			$where .= " where a0.username like '%". $_REQUEST['username']."%' 
and a0.useraction like '%". $_REQUEST['useraction']."%' 
and a0.menuname like '%". $_REQUEST['menuname']."%'"; 
		}
		if (isset($_REQUEST['translogid']))
			{
				if (($_REQUEST['translogid'] !== '0') && ($_REQUEST['translogid'] !== ''))
				{
					$where .= " and a0.translogid in (".$_REQUEST['translogid'].")";
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
			'keyField'=>'translogid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'translogid','username','createddate','useraction','newdata','menuname','tableid'
				),
				'defaultOrder' => array( 
					'translogid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where translogid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'translogid'=>$model['translogid'],
          'username'=>$model['username'],
          'createddate'=>$model['createddate'],
          'useraction'=>$model['useraction'],
          'newdata'=>$model['newdata'],
          'menuname'=>$model['menuname'],
          'tableid'=>$model['tableid'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('username','string','emptyusername'),
      array('useraction','string','emptyuseraction'),
      array('menuname','string','emptymenuname'),
    ));
		if ($error == false)
		{
			$id = $_POST['translogid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update translog 
			      set username = :username,createddate = :createddate,useraction = :useraction,newdata = :newdata,menuname = :menuname,tableid = :tableid 
			      where translogid = :translogid';
				}
				else
				{
					$sql = 'insert into translog (username,createddate,useraction,newdata,menuname,tableid) 
			      values (:username,:createddate,:useraction,:newdata,:menuname,:tableid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':translogid',$_POST['translogid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':username',(($_POST['username']!=='')?$_POST['username']:null),PDO::PARAM_STR);
        $command->bindvalue(':createddate',(($_POST['createddate']!=='')?$_POST['createddate']:null),PDO::PARAM_STR);
        $command->bindvalue(':useraction',(($_POST['useraction']!=='')?$_POST['useraction']:null),PDO::PARAM_STR);
        $command->bindvalue(':newdata',(($_POST['newdata']!=='')?$_POST['newdata']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuname',(($_POST['menuname']!=='')?$_POST['menuname']:null),PDO::PARAM_STR);
        $command->bindvalue(':tableid',(($_POST['tableid']!=='')?$_POST['tableid']:null),PDO::PARAM_STR);
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from translog where translogid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('translog');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('translogid'),$this->getCatalog('username'),$this->getCatalog('createddate'),$this->getCatalog('useraction'),$this->getCatalog('newdata'),$this->getCatalog('menuname'),$this->getCatalog('table'));
		$this->pdf->setwidths(array(10,20,40,20,50,20,20));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['translogid'],$row1['username'],
				Yii::app()->format->formatDateTime($row1['createddate']),$row1['useraction'],$row1['newdata'],$row1['menuname'],$row1['tableid']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('translogid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('username'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('createddate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('useraction'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('newdata'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('menuname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('tableid'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['translogid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['username'])
->setCellValueByColumnAndRow(2, $i+1, $row1['createddate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['useraction'])
->setCellValueByColumnAndRow(4, $i+1, $row1['newdata'])
->setCellValueByColumnAndRow(5, $i+1, $row1['menuname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['tableid']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}