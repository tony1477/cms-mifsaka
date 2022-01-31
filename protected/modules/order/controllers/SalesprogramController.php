<?php

class SalesprogramController extends AdminController
{
	protected $menuname = 'salesprogram';
	public $module = 'Order';
	protected $pageTitle = 'Program Sales';
	public $wfname = 'AppSalesProgram';
	protected $sqldata = "select a0.salesprogramid,a0.salesprogramno,a0.salesprogramdate,a0.companyid,a0.addressbookid,a0.iscontract,a0.programname,a0.month,a0.totalvalue,a0.totalvalue/a0.month as monthvalue,a0.description,a0.startdate,a0.enddate,a0.docupload,a0.recordstatus,a1.companyname as companyname,a2.fullname as fullname,getwfstatusbywfname('AppSalesProgram',a0.recordstatus) as statusname  
    from salesprogram a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
  ";
  protected $sqlcount = "select count(1) 
    from salesprogram a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['salesprogramno'])) && (isset($_REQUEST['programname'])) && (isset($_REQUEST['docupload'])))
		{				
			$where .= " and a0.salesprogramno like '%". $_REQUEST['salesprogramno']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.fullname like '%". $_REQUEST['customer']."%' 
and a0.programname like '%". $_REQUEST['programname']."%' 
and a0.description like '%". $_REQUEST['description']."%' 
and a0.docupload like '%". $_REQUEST['docupload']."%'"; 
		}
		if (isset($_REQUEST['salesprogramid']))
			{
				if (($_REQUEST['salesprogramid'] !== '0') && ($_REQUEST['salesprogramid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.salesprogramid in (".$_REQUEST['salesprogramid'].")";
					}
					else
					{
						$where .= " and a0.salesprogramid in (".$_REQUEST['salesprogramid'].")";
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
			'keyField'=>'salesprogramid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'salesprogramid','salesprogramno','salesprogramdate','companyid','addressbookid','iscontract','programname','month','totalvalue','description','startdate','enddate','docupload','recordstatus'
				),
				'defaultOrder' => array( 
					'salesprogramid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
    public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/salesprogram/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/salesprogram/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/salesprogram/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
    public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"salesprogramdate" =>date("Y-m-d"),
      "startdate" =>date("Y-m-d"),
      "enddate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("InsSalesProgram")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.salesprogramid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'salesprogramid'=>$model['salesprogramid'],
          'salesprogramdate'=>$model['salesprogramdate'],
          'companyid'=>$model['companyid'],
          'addressbookid'=>$model['addressbookid'],
          'iscontract'=>$model['iscontract'],
          'programname'=>$model['programname'],
          'month'=>$model['month'],
          'totalvalue'=>$model['totalvalue'],
          'monthvalue'=>$model['monthvalue'],
          'description'=>$model['description'],
          'startdate'=>$model['startdate'],
          'enddate'=>$model['enddate'],
          'docupload'=>$model['docupload'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'fullname'=>$model['fullname'],

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
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('salesprogramdate','string','emptysalesprogramdate'),
			array('companyid','string','emptycompanyid'),
			array('programname','string','emptyprogramname'),
			array('description','string','emptydescription'),
			array('startdate','string','emptystartdate'),
			array('enddate','string','emptyenddate'),
			array('docupload','string','emptydocupload'),
			array('recordstatus','string','emptyrecordstatus'),
		));
		if ($error == false)
		{
			$id = $_POST['salesprogramid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id == '') {
                    $sql     = 'call InsertSalesProgram(:salesprogramdate,:companyid,:addressbookid,:iscontract,:programname,:month,:totalvalue,:description,:startdate,:enddate,:docupload,:recordstatus,:vcreatedby)';
                    $command = $connection->createCommand($sql);
                } else {
                    $sql     = 'call UpdateSalesProgram(:vid,:salesprogramdate,:companyid,:addressbookid,:iscontract,:programname,:month,:totalvalue,:description,:startdate,:enddate,:docupload,:recordstatus,:vcreatedby)';
                    $command = $connection->createCommand($sql);
                    $command->bindvalue(':vid', $_POST['salesprogramid'], PDO::PARAM_STR);
                }
                $command->bindvalue(':salesprogramdate',(($_POST['salesprogramdate']!=='')?date(Yii::app()->params['datetodb'],strtotime($_POST['salesprogramdate'])):null),PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
				$command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
				$command->bindvalue(':iscontract',(($_POST['iscontract']!=='')?$_POST['iscontract']:null),PDO::PARAM_STR);
				$command->bindvalue(':programname',(($_POST['programname']!=='')?$_POST['programname']:null),PDO::PARAM_STR);
				$command->bindvalue(':month',(($_POST['month']!=='')?$_POST['month']:null),PDO::PARAM_STR);
				$command->bindvalue(':totalvalue',(($_POST['totalvalue']!=='')?$_POST['totalvalue']:null),PDO::PARAM_STR);
				$command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
                $command->bindvalue(':startdate',(($_POST['startdate']!=='')?date(Yii::app()->params['datetodb'],strtotime($_POST['startdate'])):null),PDO::PARAM_STR);
                $command->bindvalue(':enddate',(($_POST['enddate']!=='')?date(Yii::app()->params['datetodb'],strtotime($_POST['enddate'])):null),PDO::PARAM_STR);
				$command->bindvalue(':docupload',(($_POST['docupload']!=='')?$_POST['docupload']:null),PDO::PARAM_STR);
				$command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
/*	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('salesprogramdate','string','emptysalesprogramdate'),
      array('companyid','string','emptycompanyid'),
      array('programname','string','emptyprogramname'),
      array('description','string','emptydescription'),
      array('startdate','string','emptystartdate'),
      array('enddate','string','emptyenddate'),
      array('docupload','string','emptydocupload'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesprogramid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update salesprogram 
			      set salesprogramdate = :salesprogramdate,companyid = :companyid,addressbookid = :addressbookid,programname = :programname,month = :month,totalvalue = :totalvalue,description = :description,startdate = :startdate,enddate = :enddate,docupload = :docupload,recordstatus = :recordstatus 
			      where salesprogramid = :salesprogramid';
				}
				else
				{
					$sql = 'insert into salesprogram (salesprogramdate,companyid,addressbookid,programname,month,totalvalue,description,startdate,enddate,docupload,recordstatus) 
			      values (:salesprogramdate,:companyid,:addressbookid,:programname,:month,:totalvalue,:description,:startdate,:enddate,:docupload,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':salesprogramid',$_POST['salesprogramid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':salesprogramdate',(($_POST['salesprogramdate']!=='')?$_POST['salesprogramdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':programname',(($_POST['programname']!=='')?$_POST['programname']:null),PDO::PARAM_STR);
        $command->bindvalue(':month',(($_POST['month']!=='')?$_POST['month']:null),PDO::PARAM_STR);
        $command->bindvalue(':totalvalue',(($_POST['totalvalue']!=='')?$_POST['totalvalue']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':startdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':enddate',(($_POST['enddate']!=='')?$_POST['enddate']:null),PDO::PARAM_STR);
        $command->bindvalue(':docupload',(($_POST['docupload']!=='')?$_POST['docupload']:null),PDO::PARAM_STR);
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
	}*/
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
				$sql = 'call Approvesalesprogram(:vid,:vlastupdateby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vlastupdateby',Yii::app()->user->name,PDO::PARAM_STR);
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
				$sql = 'call Deletesalesprogram(:vid,:vlastupdateby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vlastupdateby',Yii::app()->user->name,PDO::PARAM_STR);
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
				$sql = "delete from salesprogram where salesprogramid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('salesprogram');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('salesprogramid'),$this->getCatalog('salesprogramno'),$this->getCatalog('salesprogramdate'),$this->getCatalog('company'),$this->getCatalog('addressbook'),$this->getCatalog('iscontract'),$this->getCatalog('programname'),$this->getCatalog('description'),$this->getCatalog('startdate'),$this->getCatalog('enddate'),$this->getCatalog('docupload'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['salesprogramid'],$row1['salesprogramno'],$row1['salesprogramdate'],$row1['companyname'],$row1['fullname'],$row1['iscontract'],$row1['programname'],$row1['description'],$row1['startdate'],$row1['enddate'],$row1['docupload'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('salesprogramid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('salesprogramno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('salesprogramdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('iscontract'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('programname'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('startdate'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('enddate'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('docupload'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['salesprogramid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['salesprogramno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['salesprogramdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['iscontract'])
->setCellValueByColumnAndRow(6, $i+1, $row1['programname'])
->setCellValueByColumnAndRow(7, $i+1, $row1['description'])
->setCellValueByColumnAndRow(8, $i+1, $row1['startdate'])
->setCellValueByColumnAndRow(9, $i+1, $row1['enddate'])
->setCellValueByColumnAndRow(10, $i+1, $row1['docupload'])
->setCellValueByColumnAndRow(11, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}