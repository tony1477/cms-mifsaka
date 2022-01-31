<?php

class GmerpController extends AdminController
{
	protected $menuname = 'gmerp';
	public $module = 'Admin';
	protected $pageTitle = 'Otorisasi Grup dan Menu';
	public $wfname = '';
	protected $sqldata = "select a0.groupmenuid,a0.groupaccessid,a0.menuaccessid,a0.isread,a0.iswrite,a0.ispost,a0.isreject,a0.ispurge,a0.isupload,a0.isdownload,a1.groupname as groupname,a2.menuname as menuname 
    from groupmenu a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join menuaccess a2 on a2.menuaccessid = a0.menuaccessid
  ";
  protected $sqlcount = "select count(1) 
    from groupmenu a0 
    left join groupaccess a1 on a1.groupaccessid = a0.groupaccessid
    left join menuaccess a2 on a2.menuaccessid = a0.menuaccessid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['groupname'])) && (isset($_REQUEST['menuname'])))
		{				
			$where .= " where a1.groupname like '%". $_REQUEST['groupname']."%' 
and a2.menuname like '%". $_REQUEST['menuname']."%'"; 
		}
		if (isset($_REQUEST['groupmenuid']))
			{
				if (($_REQUEST['groupmenuid'] !== '0') && ($_REQUEST['groupmenuid'] !== ''))
				{
					$where .= " and a0.groupmenuid in (".$_REQUEST['groupmenuid'].")";
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
			'keyField'=>'groupmenuid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'groupmenuid','groupaccessid','menuaccessid','isread','iswrite','ispost','isreject','ispurge','isupload','isdownload'
				),
				'defaultOrder' => array( 
					'groupmenuid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where groupmenuid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'groupmenuid'=>$model['groupmenuid'],
          'groupaccessid'=>$model['groupaccessid'],
          'menuaccessid'=>$model['menuaccessid'],
          'isread'=>$model['isread'],
          'iswrite'=>$model['iswrite'],
          'ispost'=>$model['ispost'],
          'isreject'=>$model['isreject'],
          'ispurge'=>$model['ispurge'],
          'isupload'=>$model['isupload'],
          'isdownload'=>$model['isdownload'],
          'groupname'=>$model['groupname'],
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
      array('menuaccessid','string','emptymenuaccessid'),
    ));
		if ($error == false)
		{
			$id = $_POST['groupmenuid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update groupmenu 
			      set groupaccessid = :groupaccessid,menuaccessid = :menuaccessid,isread = :isread,iswrite = :iswrite,ispost = :ispost,isreject = :isreject,ispurge = :ispurge,isupload = :isupload,isdownload = :isdownload 
			      where groupmenuid = :groupmenuid';
				}
				else
				{
					$sql = 'insert into groupmenu (groupaccessid,menuaccessid,isread,iswrite,ispost,isreject,ispurge,isupload,isdownload) 
			      values (:groupaccessid,:menuaccessid,:isread,:iswrite,:ispost,:isreject,:ispurge,:isupload,:isdownload)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':groupmenuid',$_POST['groupmenuid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':groupaccessid',(($_POST['groupaccessid']!=='')?$_POST['groupaccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':menuaccessid',(($_POST['menuaccessid']!=='')?$_POST['menuaccessid']:null),PDO::PARAM_STR);
        $command->bindvalue(':isread',(($_POST['isread']!=='')?$_POST['isread']:null),PDO::PARAM_STR);
        $command->bindvalue(':iswrite',(($_POST['iswrite']!=='')?$_POST['iswrite']:null),PDO::PARAM_STR);
        $command->bindvalue(':ispost',(($_POST['ispost']!=='')?$_POST['ispost']:null),PDO::PARAM_STR);
        $command->bindvalue(':isreject',(($_POST['isreject']!=='')?$_POST['isreject']:null),PDO::PARAM_STR);
        $command->bindvalue(':ispurge',(($_POST['ispurge']!=='')?$_POST['ispurge']:null),PDO::PARAM_STR);
        $command->bindvalue(':isupload',(($_POST['isupload']!=='')?$_POST['isupload']:null),PDO::PARAM_STR);
        $command->bindvalue(':isdownload',(($_POST['isdownload']!=='')?$_POST['isdownload']:null),PDO::PARAM_STR);
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
				$sql = "delete from groupmenu where groupmenuid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('gmerp');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('groupmenuid'),$this->getCatalog('groupaccess'),$this->getCatalog('menuaccess'),$this->getCatalog('isread'),$this->getCatalog('iswrite'),$this->getCatalog('ispost'),$this->getCatalog('isreject'),$this->getCatalog('ispurge'),$this->getCatalog('isupload'),$this->getCatalog('isdownload'));
		$this->pdf->setwidths(array(10,40,40,15,15,15,15,15,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['groupmenuid'],$row1['groupname'],$row1['menuname'],$row1['isread'],$row1['iswrite'],$row1['ispost'],$row1['isreject'],$row1['ispurge'],$row1['isupload'],$row1['isdownload']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('groupmenuid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('groupname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('menuname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('isread'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('iswrite'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('ispost'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('isreject'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('ispurge'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('isupload'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('isdownload'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['groupmenuid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['groupname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['menuname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['isread'])
->setCellValueByColumnAndRow(4, $i+1, $row1['iswrite'])
->setCellValueByColumnAndRow(5, $i+1, $row1['ispost'])
->setCellValueByColumnAndRow(6, $i+1, $row1['isreject'])
->setCellValueByColumnAndRow(7, $i+1, $row1['ispurge'])
->setCellValueByColumnAndRow(8, $i+1, $row1['isupload'])
->setCellValueByColumnAndRow(9, $i+1, $row1['isdownload']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}