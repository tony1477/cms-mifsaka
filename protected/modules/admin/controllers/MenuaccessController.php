<?php

class MenuaccessController extends AdminController
{
	protected $menuname = 'menuaccess';
	public $module = 'Admin';
	protected $pageTitle = 'Akses Menu';
	public $wfname = '';
	protected $sqldata = "select a0.menuaccessid,a0.menuname,a0.description,a0.menuurl,a0.menuicon,a0.parentid,a0.moduleid,a0.sortorder,a0.recordstatus,a1.modulename as modulename 
    from menuaccess a0 
    left join modules a1 on a1.moduleid = a0.moduleid
  ";
  protected $sqlcount = "select count(1) 
    from menuaccess a0 
    left join modules a1 on a1.moduleid = a0.moduleid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['menuname'])) && (isset($_REQUEST['description'])) && (isset($_REQUEST['menuurl'])) && (isset($_REQUEST['menuicon'])) && (isset($_REQUEST['modulename'])))
		{				
			$where .= " where a0.menuname like '%". $_REQUEST['menuname']."%' 
and a0.description like '%". $_REQUEST['description']."%' 
and a0.menuurl like '%". $_REQUEST['menuurl']."%' 
and a0.menuicon like '%". $_REQUEST['menuicon']."%' 
and a1.modulename like '%". $_REQUEST['modulename']."%'"; 
		}
		if (isset($_REQUEST['menuaccessid']))
			{
				if (($_REQUEST['menuaccessid'] !== '0') && ($_REQUEST['menuaccessid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.menuaccessid in (".$_REQUEST['menuaccessid'].")";
					}
					else
					{
						$where .= " and a0.menuaccessid in (".$_REQUEST['menuaccessid'].")";
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
			'keyField'=>'menuaccessid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'menuaccessid','menuname','description','menuurl','menuicon','parentid','moduleid','sortorder','recordstatus'
				),
				'defaultOrder' => array( 
					'menuaccessid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.menuaccessid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'menuaccessid'=>$model['menuaccessid'],
          'menuname'=>$model['menuname'],
          'description'=>$model['description'],
          'menuurl'=>$model['menuurl'],
          'menuicon'=>$model['menuicon'],
          'parentid'=>$model['parentid'],
          'moduleid'=>$model['moduleid'],
          'sortorder'=>$model['sortorder'],
          'recordstatus'=>$model['recordstatus'],
          'modulename'=>$model['modulename'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('menuname','string','emptymenuname'),
      array('description','string','emptydescription'),
      array('menuurl','string','emptymenuurl'),
      array('menuicon','string','emptymenuicon'),
      array('moduleid','string','emptymoduleid'),
    ));
		if ($error == false)
		{
			$id = $_POST['menuaccessid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update menuaccess 
			      set menuname = :menuname,description = :description,menuurl = :menuurl,menuicon = :menuicon,parentid = :parentid,moduleid = :moduleid,sortorder = :sortorder,recordstatus = :recordstatus 
			      where menuaccessid = :menuaccessid';
				}
				else
				{
					$sql = 'insert into menuaccess (menuname,description,menuurl,menuicon,parentid,moduleid,sortorder,recordstatus) 
			      values (:menuname,:description,:menuurl,:menuicon,:parentid,:moduleid,:sortorder,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':menuaccessid',$_POST['menuaccessid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':menuname',(($_POST['menuname']!=='')?$_POST['menuname']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuurl',(($_POST['menuurl']!=='')?$_POST['menuurl']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuicon',(($_POST['menuicon']!=='')?$_POST['menuicon']:null),PDO::PARAM_STR);
        $command->bindvalue(':parentid',(($_POST['parentid']!=='')?$_POST['parentid']:null),PDO::PARAM_STR);
        $command->bindvalue(':moduleid',(($_POST['moduleid']!=='')?$_POST['moduleid']:null),PDO::PARAM_STR);
        $command->bindvalue(':sortorder',(($_POST['sortorder']!=='')?$_POST['sortorder']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from menuaccess where menuaccessid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update menuaccess set recordstatus = 0 where menuaccessid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update menuaccess set recordstatus = 1 where menuaccessid = ".$id[$i];
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
				$sql = "delete from menuaccess where menuaccessid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('menuaccess');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('menuaccessid'),$this->getCatalog('menuname'),$this->getCatalog('description'),$this->getCatalog('menuurl'),$this->getCatalog('menuicon'),$this->getCatalog('parent'),$this->getCatalog('module'),$this->getCatalog('sortorder'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['menuaccessid'],$row1['menuname'],$row1['description'],$row1['menuurl'],$row1['menuicon'],$row1['parentid'],$row1['modulename'],$row1['sortorder'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('menuaccessid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('menuname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('menuurl'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('menuicon'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('parentid'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('modulename'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('sortorder'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['menuaccessid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['menuname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
->setCellValueByColumnAndRow(3, $i+1, $row1['menuurl'])
->setCellValueByColumnAndRow(4, $i+1, $row1['menuicon'])
->setCellValueByColumnAndRow(5, $i+1, $row1['parentid'])
->setCellValueByColumnAndRow(6, $i+1, $row1['modulename'])
->setCellValueByColumnAndRow(7, $i+1, $row1['sortorder'])
->setCellValueByColumnAndRow(8, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}