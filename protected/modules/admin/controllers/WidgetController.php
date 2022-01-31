<?php

class WidgetController extends AdminController
{
	protected $menuname = 'widget';
	public $module = 'Admin';
	protected $pageTitle = 'Widget';
	public $wfname = '';
	protected $sqldata = "select a0.widgetid,a0.widgetname,a0.widgettitle,a0.widgetversion,a0.widgetby,a0.description,a0.widgeturl,a0.moduleid,a0.installdate,a0.recordstatus,a1.modulename as modulename 
    from widget a0 
    left join modules a1 on a1.moduleid = a0.moduleid
  ";
  protected $sqlcount = "select count(1) 
    from widget a0 
    left join modules a1 on a1.moduleid = a0.moduleid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['widgetname'])) && (isset($_REQUEST['widgettitle'])) && (isset($_REQUEST['widgetversion'])) && (isset($_REQUEST['widgetby'])) && (isset($_REQUEST['widgeturl'])) && (isset($_REQUEST['modulename'])))
		{				
			$where .= " where a0.widgetname like '%". $_REQUEST['widgetname']."%' 
and a0.widgettitle like '%". $_REQUEST['widgettitle']."%' 
and a0.widgetversion like '%". $_REQUEST['widgetversion']."%' 
and a0.widgetby like '%". $_REQUEST['widgetby']."%' 
and a0.widgeturl like '%". $_REQUEST['widgeturl']."%' 
and a1.modulename like '%". $_REQUEST['modulename']."%'"; 
		}
		if (isset($_REQUEST['widgetid']))
			{
				if (($_REQUEST['widgetid'] !== '0') && ($_REQUEST['widgetid'] !== ''))
				{
					$where .= " and a0.widgetid in (".$_REQUEST['widgetid'].")";
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
			'keyField'=>'widgetid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'widgetid','widgetname','widgettitle','widgetversion','widgetby','description','widgeturl','moduleid','installdate','recordstatus'
				),
				'defaultOrder' => array( 
					'widgetid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.widgetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'widgetid'=>$model['widgetid'],
          'widgetname'=>$model['widgetname'],
          'widgettitle'=>$model['widgettitle'],
          'widgetversion'=>$model['widgetversion'],
          'widgetby'=>$model['widgetby'],
          'description'=>$model['description'],
          'widgeturl'=>$model['widgeturl'],
          'moduleid'=>$model['moduleid'],
          'installdate'=>$model['installdate'],
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
      array('widgetname','string','emptywidgetname'),
      array('widgettitle','string','emptywidgettitle'),
      array('widgetversion','string','emptywidgetversion'),
      array('widgetby','string','emptywidgetby'),
      array('description','string','emptydescription'),
      array('widgeturl','string','emptywidgeturl'),
      array('moduleid','string','emptymoduleid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['widgetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update widget 
			      set widgetname = :widgetname,widgettitle = :widgettitle,widgetversion = :widgetversion,widgetby = :widgetby,description = :description,widgeturl = :widgeturl,moduleid = :moduleid,recordstatus = :recordstatus 
			      where widgetid = :widgetid';
				}
				else
				{
					$sql = 'insert into widget (widgetname,widgettitle,widgetversion,widgetby,description,widgeturl,moduleid,recordstatus) 
			      values (:widgetname,:widgettitle,:widgetversion,:widgetby,:description,:widgeturl,:moduleid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':widgetid',$_POST['widgetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':widgetname',(($_POST['widgetname']!=='')?$_POST['widgetname']:null),PDO::PARAM_STR);
        $command->bindvalue(':widgettitle',(($_POST['widgettitle']!=='')?$_POST['widgettitle']:null),PDO::PARAM_STR);
        $command->bindvalue(':widgetversion',(($_POST['widgetversion']!=='')?$_POST['widgetversion']:null),PDO::PARAM_STR);
        $command->bindvalue(':widgetby',(($_POST['widgetby']!=='')?$_POST['widgetby']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':widgeturl',(($_POST['widgeturl']!=='')?$_POST['widgeturl']:null),PDO::PARAM_STR);
        $command->bindvalue(':moduleid',(($_POST['moduleid']!=='')?$_POST['moduleid']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from widget where a0.widgetid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update widget set recordstatus = 0 where a0.widgetid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update widget set recordstatus = 1 where a0.widgetid = ".$id[$i];
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
				$sql = "delete from widget where widgetid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('widget');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('widgetid'),$this->getCatalog('widgetna'),$this->getCatalog('widgettit'),$this->getCatalog('widgetversi'),$this->getCatalog('widget'),$this->getCatalog('description'),$this->getCatalog('widgetu'),$this->getCatalog('module'),$this->getCatalog('installdate'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['widgetid'],$row1['widgetname'],$row1['widgettitle'],$row1['widgetversion'],$row1['widgetby'],$row1['description'],$row1['widgeturl'],$row1['modulename'],$row1['installdate'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('widgetid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('widgetname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('widgettitle'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('widgetversion'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('widgetby'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('widgeturl'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('modulename'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('installdate'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['widgetid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['widgetname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['widgettitle'])
->setCellValueByColumnAndRow(3, $i+1, $row1['widgetversion'])
->setCellValueByColumnAndRow(4, $i+1, $row1['widgetby'])
->setCellValueByColumnAndRow(5, $i+1, $row1['description'])
->setCellValueByColumnAndRow(6, $i+1, $row1['widgeturl'])
->setCellValueByColumnAndRow(7, $i+1, $row1['modulename'])
->setCellValueByColumnAndRow(8, $i+1, $row1['installdate'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}