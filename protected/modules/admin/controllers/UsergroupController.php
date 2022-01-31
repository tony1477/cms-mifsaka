<?php

class UsergroupController extends AdminController
{
	protected $menuname = 'usergroup';
	public $module = 'Admin';
	protected $pageTitle = 'Otorisasi User dan Grup';
	public $wfname = '';
	protected $sqldata = "select a0.usergroupid,a0.useraccessid,a0.groupaccessid,a1.username as username,a2.groupname as groupname 
    from usergroup a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join groupaccess a2 on a2.groupaccessid = a0.groupaccessid
  ";
  protected $sqlcount = "select count(1) 
    from usergroup a0 
    left join useraccess a1 on a1.useraccessid = a0.useraccessid
    left join groupaccess a2 on a2.groupaccessid = a0.groupaccessid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['username'])) && (isset($_REQUEST['groupname'])))
		{				
			$where .= " where a1.username like '%". $_REQUEST['username']."%' 
and a2.groupname like '%". $_REQUEST['groupname']."%'"; 
		}
		if (isset($_REQUEST['usergroupid']))
			{
				if (($_REQUEST['usergroupid'] !== '0') && ($_REQUEST['usergroupid'] !== ''))
				{
					$where .= " and a0.usergroupid in (".$_REQUEST['usergroupid'].")";
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
			'keyField'=>'usergroupid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'usergroupid','useraccessid','groupaccessid'
				),
				'defaultOrder' => array( 
					'usergroupid' => CSort::SORT_DESC
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
			$id = $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where usergroupid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'usergroupid'=>$model['usergroupid'],
          'useraccessid'=>$model['useraccessid'],
          'groupaccessid'=>$model['groupaccessid'],
          'username'=>$model['username'],
          'groupname'=>$model['groupname'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('useraccessid','string','emptyuseraccessid'),
      array('groupaccessid','string','emptygroupaccessid'),
    ));
		if ($error == false)
		{
			$id = $_POST['usergroupid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update usergroup 
			      set useraccessid = :useraccessid,groupaccessid = :groupaccessid 
			      where usergroupid = :usergroupid';
				}
				else
				{
					$sql = 'insert into usergroup (useraccessid,groupaccessid) 
			      values (:useraccessid,:groupaccessid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':usergroupid',$_POST['usergroupid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':useraccessid',(($_POST['useraccessid']!=='')?$_POST['useraccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':groupaccessid',(($_POST['groupaccessid']!=='')?$_POST['groupaccessid']:null),PDO::PARAM_STR);
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
				$sql = "delete from usergroup where usergroupid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('usergroup');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C');
		$this->pdf->colheader = array($this->getCatalog('usergroupid'),$this->getCatalog('useraccess'),$this->getCatalog('groupaccess'));
		$this->pdf->setwidths(array(10,70,70));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['usergroupid'],$row1['username'],$row1['groupname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('usergroupid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('username'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('groupname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['usergroupid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['username'])
->setCellValueByColumnAndRow(2, $i+1, $row1['groupname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}