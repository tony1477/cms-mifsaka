<?php

class CurrencyController extends AdminController
{
	protected $menuname = 'currency';
	public $module = 'Admin';
	protected $pageTitle = 'Mata Uang';
	public $wfname = '';
	protected $sqldata = "select a0.currencyid,a0.countryid,a0.currencyname,a0.symbol,a0.i18n,a0.recordstatus,a1.countryname as countryname 
    from currency a0 
    left join country a1 on a1.countryid = a0.countryid
  ";
  protected $sqlcount = "select count(1) 
    from currency a0 
    left join country a1 on a1.countryid = a0.countryid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['currencyname'])) && (isset($_REQUEST['symbol'])) && (isset($_REQUEST['i18n'])) && (isset($_REQUEST['countryname'])))
		{				
			$where .= " where a0.currencyname like '%". $_REQUEST['currencyname']."%' 
and a0.symbol like '%". $_REQUEST['symbol']."%' 
and a0.i18n like '%". $_REQUEST['i18n']."%' 
and a1.countryname like '%". $_REQUEST['countryname']."%'"; 
		}
		if (isset($_REQUEST['currencyid']))
			{
				if (($_REQUEST['currencyid'] !== '0') && ($_REQUEST['currencyid'] !== ''))
				{
					$where .= " and a0.currencyid in (".$_REQUEST['currencyid'].")";
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
			'keyField'=>'currencyid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'currencyid','countryid','currencyname','symbol','i18n','recordstatus'
				),
				'defaultOrder' => array( 
					'currencyid' => CSort::SORT_DESC
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
			
			"currencyid" => $this->GetParameter("basecurrencyid"),
			"currencyname" => $this->GetParameter("basecurrency")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where currencyid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'currencyid'=>$model['currencyid'],
          'countryid'=>$model['countryid'],
          'currencyname'=>$model['currencyname'],
          'symbol'=>$model['symbol'],
          'i18n'=>$model['i18n'],
          'recordstatus'=>$model['recordstatus'],
          'countryname'=>$model['countryname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			  array('countryid','string','emptycountryid'),
		      array('currencyname','string','emptycurrencyname'),
		      array('symbol','string','emptysymbol'),
		      array('i18n','string','emptyi18n'),
    ));
		if ($error == false)
		{
			$id = $_POST['currencyid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update currency 
			      set countryid = :countryid,currencyname = :currencyname,symbol = :symbol,i18n = :i18n,recordstatus = :recordstatus 
			      where currencyid = :currencyid';
				}
				else
				{
					$sql = 'insert into currency (countryid,currencyname,symbol,i18n,recordstatus) 
			      values (:countryid,:currencyname,:symbol,:i18n,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':currencyid',$_POST['currencyid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':countryid',(($_POST['countryid']!=='')?$_POST['countryid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyname',(($_POST['currencyname']!=='')?$_POST['currencyname']:null),PDO::PARAM_STR);
        $command->bindvalue(':symbol',(($_POST['symbol']!=='')?$_POST['symbol']:null),PDO::PARAM_STR);
        $command->bindvalue(':i18n',(($_POST['i18n']!=='')?$_POST['i18n']:null),PDO::PARAM_STR);
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
					$sql = "select recordstatus from currency where currencyid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update currency set recordstatus = 0 where currencyid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update currency set recordstatus = 1 where currencyid = ".$id[$i];
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from currency where currencyid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('currency');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('currencyid'),$this->getCatalog('country'),$this->getCatalog('currencyname'),$this->getCatalog('symbol'),$this->getCatalog('i18n'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['currencyid'],$row1['countryname'],$row1['currencyname'],$row1['symbol'],
			$row1['i18n'],(($row1['recordstatus'] == 1)?'Active':'NotActive')));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('currencyid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('countryname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('symbol'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('i18n'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['currencyid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['countryname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['symbol'])
->setCellValueByColumnAndRow(4, $i+1, $row1['i18n'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}