<?php

class BudgetController extends AdminController
{
	protected $menuname = 'budget';
	public $module = 'Accounting';
	protected $pageTitle = 'Budget';
	public $wfname = '';
	protected $sqldata = "select a0.budgetid,a0.companyid,a0.accountid,a0.budgetdate,a0.budgetamount,a1.accountcode as accountcode,a2.companyname as companyname
    from budget a0 
    left join account a1 on a1.accountid = a0.accountid
    left join company a2 on a2.companyid = a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from budget a0 
    left join account a1 on a1.accountid = a0.accountid
    left join company a2 on a2.companyid = a0.companyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['accountcode'])))
		{				
			$where .= " where a2.companyname like '%". $_REQUEST['companyname']."%' and a1.accountcode like '%". $_REQUEST['accountcode']."%'"; 
		}
		if (isset($_REQUEST['budgetid']))
			{
				if (($_REQUEST['budgetid'] !== '0') && ($_REQUEST['budgetid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.budgetid in (".$_REQUEST['budgetid'].")";
					}
					else
					{
						$where .= " and a0.budgetid in (".$_REQUEST['budgetid'].")";
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
			'keyField'=>'budgetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'budgetid','companyid','accountid','budgetdate','budgetamount'
				),
				'defaultOrder' => array( 
					'budgetid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"budgetdate" =>date("Y-m-d"),
      "budgetamount" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.budgetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'budgetid'=>$model['budgetid'],
          'companyid'=>$model['companyid'],
          'accountid'=>$model['accountid'],
          'budgetdate'=>$model['budgetdate'],
          'budgetamount'=>$model['budgetamount'],
          'accountcode'=>$model['accountcode'],
          'companyname'=>$model['companyname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('accountid','string','emptyaccountid'),
			array('companyid','string','emptycompanyid'),
      array('budgetdate','string','emptybudgetdate'),
      array('budgetamount','string','emptybudgetamount'),
    ));
		if ($error == false)
		{
			$id = $_POST['budgetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update budget 
			      set companyid = :companyid,accountid = :accountid,budgetdate = :budgetdate,budgetamount = :budgetamount 
			      where budgetid = :budgetid';
				}
				else
				{
					$sql = 'insert into budget (companyid,accountid,budgetdate,budgetamount) 
			      values (:companyid,:accountid,:budgetdate,:budgetamount)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':budgetid',$_POST['budgetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
				$command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':budgetdate',(($_POST['budgetdate']!=='')?$_POST['budgetdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':budgetamount',(($_POST['budgetamount']!=='')?$_POST['budgetamount']:null),PDO::PARAM_STR);
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
				$sql = "delete from budget where budgetid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('budget');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('budgetid'),$this->getCatalog('account'),$this->getCatalog('budgetdate'),$this->getCatalog('budgetamount'));
		$this->pdf->setwidths(array(10,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['budgetid'],$row1['accountcode'],$row1['budgetdate'],$row1['budgetamount']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('budgetid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('accountcode'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('budgetdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('budgetamount'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['budgetid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['accountcode'])
->setCellValueByColumnAndRow(2, $i+1, $row1['budgetdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['budgetamount']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}