<?php

class UserdashController extends AdminController
{
	protected $menuname = 'userdash';
	public $module = 'Admin';
	protected $pageTitle = 'User Dashboard';
	public $wfname = '';
	protected $sqldata = "select a0.userdashid,a0.groupaccessid,a0.widgetid,a0.menuaccessid,a0.position,a0.webformat,a0.dashgroup,a1.groupname as groupname,a2.widgetname as widgetname,a3.menuname as menuname 
    from userdash a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join widget a2 on a2.widgetid = a0.widgetid
    left join menuaccess a3 on a3.menuaccessid = a0.menuaccessid
  ";
  protected $sqlcount = "select count(1) 
    from userdash a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join widget a2 on a2.widgetid = a0.widgetid
    left join menuaccess a3 on a3.menuaccessid = a0.menuaccessid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['webformat'])) && (isset($_REQUEST['groupname'])) && (isset($_REQUEST['widgetname'])) && (isset($_REQUEST['menuname'])))
		{				
			$where .= " where a0.webformat like '%". $_REQUEST['webformat']."%' 
and a1.groupname like '%". $_REQUEST['groupname']."%' 
and a2.widgetname like '%". $_REQUEST['widgetname']."%' 
and a3.menuname like '%". $_REQUEST['menuname']."%'"; 
		}
		if (isset($_REQUEST['userdashid']))
			{
				if (($_REQUEST['userdashid'] !== '0') && ($_REQUEST['userdashid'] !== ''))
				{
					$where .= " and a0.userdashid in (".$_REQUEST['userdashid'].")";
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
			'keyField'=>'userdashid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'userdashid','groupaccessid','widgetid','menuaccessid','position','webformat','dashgroup'
				),
				'defaultOrder' => array( 
					'userdashid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.userdashid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'userdashid'=>$model['userdashid'],
          'groupaccessid'=>$model['groupaccessid'],
          'widgetid'=>$model['widgetid'],
          'menuaccessid'=>$model['menuaccessid'],
          'position'=>$model['position'],
          'webformat'=>$model['webformat'],
          'dashgroup'=>$model['dashgroup'],
          'groupname'=>$model['groupname'],
          'widgetname'=>$model['widgetname'],
          'menuname'=>$model['menuname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
      array('groupaccessid','string','emptygroupaccessid'),
      array('widgetid','string','emptywidgetid'),
      array('menuaccessid','string','emptymenuaccessid'),
      array('position','string','emptyposition'),
      array('webformat','string','emptywebformat'),
      array('dashgroup','string','emptydashgroup'),
    ));
		if ($error == false)
		{
			$id = $_POST['userdashid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update userdash 
			      set groupaccessid = :groupaccessid,widgetid = :widgetid,menuaccessid = :menuaccessid,position = :position,webformat = :webformat,dashgroup = :dashgroup 
			      where userdashid = :userdashid';
				}
				else
				{
					$sql = 'insert into userdash (groupaccessid,widgetid,menuaccessid,position,webformat,dashgroup) 
			      values (:groupaccessid,:widgetid,:menuaccessid,:position,:webformat,:dashgroup)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':userdashid',$_POST['userdashid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':groupaccessid',(($_POST['groupaccessid']!=='')?$_POST['groupaccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':widgetid',(($_POST['widgetid']!=='')?$_POST['widgetid']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuaccessid',(($_POST['menuaccessid']!=='')?$_POST['menuaccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':position',(($_POST['position']!=='')?$_POST['position']:null),PDO::PARAM_STR);
        $command->bindvalue(':webformat',(($_POST['webformat']!=='')?$_POST['webformat']:null),PDO::PARAM_STR);
        $command->bindvalue(':dashgroup',(($_POST['dashgroup']!=='')?$_POST['dashgroup']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				//$this->InsertTranslog($command,$id);
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
				$sql = "delete from userdash where userdashid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('userdash');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('userdashid'),$this->getCatalog('groupaccess'),$this->getCatalog('widget'),$this->getCatalog('menuaccess'),$this->getCatalog('position'),$this->getCatalog('webformat'),$this->getCatalog('dashgroup'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['userdashid'],$row1['groupname'],$row1['widgetname'],$row1['menuname'],$row1['position'],$row1['webformat'],$row1['dashgroup']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('userdashid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('widgetname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('menuname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('position'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('webformat'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('dashgroup'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['userdashid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['widgetname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['menuname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['position'])
->setCellValueByColumnAndRow(5, $i+1, $row1['webformat'])
->setCellValueByColumnAndRow(6, $i+1, $row1['dashgroup']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}