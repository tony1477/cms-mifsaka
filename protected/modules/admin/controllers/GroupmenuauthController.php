<?php

class GroupmenuauthController extends AdminController
{
	protected $menuname = 'groupmenuauth';
	public $module = 'Admin';
	protected $pageTitle = 'Grup Menu Obyek';
	public $wfname = '';
	protected $sqldata = "select a0.groupmenuauthid,a0.groupaccessid,a0.menuauthid,a0.menuvalueid,a1.groupname as groupname,a2.menuobject as menuobject 
    from groupmenuauth a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join menuauth a2 on a2.menuauthid = a0.menuauthid
  ";
  protected $sqlcount = "select count(1) 
    from groupmenuauth a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join menuauth a2 on a2.menuauthid = a0.menuauthid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['menuvalueid'])) && (isset($_REQUEST['groupname'])) && (isset($_REQUEST['menuobject'])))
		{				
			$where .= " where a0.menuvalueid like '%". $_REQUEST['menuvalueid']."%' 
and a1.groupname like '%". $_REQUEST['groupname']."%' 
and a2.menuobject like '%". $_REQUEST['menuobject']."%'"; 
		}
		if (isset($_REQUEST['groupmenuauthid']))
			{
				if (($_REQUEST['groupmenuauthid'] !== '0') && ($_REQUEST['groupmenuauthid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.groupmenuauthid in (".$_REQUEST['groupmenuauthid'].")";
					}
					else
					{
						$where .= " and a0.groupmenuauthid in (".$_REQUEST['groupmenuauthid'].")";
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
			'keyField'=>'groupmenuauthid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'groupmenuauthid','groupaccessid','menuauthid','menuvalueid'
				),
				'defaultOrder' => array( 
					'groupmenuauthid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.groupmenuauthid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'groupmenuauthid'=>$model['groupmenuauthid'],
          'groupaccessid'=>$model['groupaccessid'],
          'menuauthid'=>$model['menuauthid'],
          'menuvalueid'=>$model['menuvalueid'],
          'groupname'=>$model['groupname'],
          'menuobject'=>$model['menuobject'],

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
      array('menuauthid','string','emptymenuauthid'),
      array('menuvalueid','string','emptymenuvalueid'),
    ));
		if ($error == false)
		{
			$id = $_POST['groupmenuauthid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update groupmenuauth 
			      set groupaccessid = :groupaccessid,menuauthid = :menuauthid,menuvalueid = :menuvalueid 
			      where groupmenuauthid = :groupmenuauthid';
				}
				else
				{
					$sql = 'insert into groupmenuauth (groupaccessid,menuauthid,menuvalueid) 
			      values (:groupaccessid,:menuauthid,:menuvalueid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':groupmenuauthid',$_POST['groupmenuauthid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':groupaccessid',(($_POST['groupaccessid']!=='')?$_POST['groupaccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuauthid',(($_POST['menuauthid']!=='')?$_POST['menuauthid']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuvalueid',(($_POST['menuvalueid']!=='')?$_POST['menuvalueid']:null),PDO::PARAM_STR);
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
				$sql = "delete from groupmenuauth where groupmenuauthid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('groupmenuauth');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('groupmenuauthid'),$this->getCatalog('groupaccess'),$this->getCatalog('menuauth'),$this->getCatalog('menuvalue'));
		$this->pdf->setwidths(array(10,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['groupmenuauthid'],$row1['groupname'],$row1['menuobject'],$row1['menuvalueid']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('groupmenuauthid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('menuobject'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('menuvalueid'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['groupmenuauthid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['menuobject'])
->setCellValueByColumnAndRow(3, $i+1, $row1['menuvalueid']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}