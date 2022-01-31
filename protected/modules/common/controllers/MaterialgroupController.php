<?php

class MaterialgroupController extends AdminController
{
	protected $menuname = 'materialgroup';
	public $module = 'Common';
	protected $pageTitle = 'Grup Material';
	public $wfname = '';
	protected $sqldata = "select a0.materialgroupid,a0.materialgroupcode,a0.description,a0.parentmatgroupid,a0.isfg,a0.recordstatus,a1.materialgroupcode as parentmatgroup 
    from materialgroup a0 
    left join materialgroup a1 on a1.materialgroupid = a0.parentmatgroupid
  ";
  protected $sqlcount = "select count(1) 
    from materialgroup a0 
    left join materialgroup a1 on a1.materialgroupid = a0.parentmatgroupid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['materialgroupcode'])) && (isset($_REQUEST['description'])))
		{				
			$where .= " where a0.materialgroupcode like '%". $_REQUEST['materialgroupcode']."%' 
and a0.description like '%". $_REQUEST['description']."%' "; 
		}
		if (isset($_REQUEST['materialgroupid']))
			{
				if (($_REQUEST['materialgroupid'] !== '0') && ($_REQUEST['materialgroupid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.materialgroupid in (".$_REQUEST['materialgroupid'].")";
					}
					else
					{
						$where .= " and a0.materialgroupid in (".$_REQUEST['materialgroupid'].")";
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
			'keyField'=>'materialgroupid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'materialgroupid','materialgroupcode','description','parentmatgroupid','isfg','recordstatus'
				),
				'defaultOrder' => array( 
					'materialgroupid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.materialgroupid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'materialgroupid'=>$model['materialgroupid'],
          'materialgroupcode'=>$model['materialgroupcode'],
          'description'=>$model['description'],
          'parentmatgroupid'=>$model['parentmatgroupid'],
          'isfg'=>$model['isfg'],
          'recordstatus'=>$model['recordstatus'],
          'parentmatgroup'=>$model['parentmatgroup'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('materialgroupcode','string','emptymaterialgroupcode'),
      array('description','string','emptydescription'),
    ));
		if ($error == false)
		{
			$id = $_POST['materialgroupid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update materialgroup 
			      set materialgroupcode = :materialgroupcode,description = :description,parentmatgroupid = :parentmatgroupid,isfg = :isfg,recordstatus = :recordstatus 
			      where materialgroupid = :materialgroupid';
				}
				else
				{
					$sql = 'insert into materialgroup (materialgroupcode,description,parentmatgroupid,isfg,recordstatus) 
			      values (:materialgroupcode,:description,:parentmatgroupid,:isfg,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':materialgroupid',$_POST['materialgroupid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':materialgroupcode',(($_POST['materialgroupcode']!=='')?$_POST['materialgroupcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':parentmatgroupid',(($_POST['parentmatgroupid']!=='')?$_POST['parentmatgroupid']:null),PDO::PARAM_STR);
        $command->bindvalue(':isfg',(($_POST['isfg']!=='')?$_POST['isfg']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from materialgroup where materialgroupid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update materialgroup set recordstatus = 0 where materialgroupid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update materialgroup set recordstatus = 1 where materialgroupid = ".$id[$i];
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
				$sql = "delete from materialgroup where materialgroupid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('materialgroup');
		$this->pdf->AddPage('P',array(350,250));
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('materialgroupid'),$this->getCatalog('materialgroupcode'),$this->getCatalog('description'),$this->getCatalog('parentmatgroup'),$this->getCatalog('isfg'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(15,55,95,95,15,20));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		$this->pdf->setFont('Arial','',10);
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['materialgroupid'],$row1['materialgroupcode'],$row1['description'],$row1['materialgroupcode'],$row1['isfg'],$row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXls() {
		$this->menuname='materialgroup';
		parent::actionDownxls();
		$sql = "select a.materialgroupid,a.materialgroupcode,a.description,
						ifnull((select z.description from materialgroup z where z.materialgroupid = a.parentmatgroupid),'-')as parentmatgroup,
						case when a.isfg = 1 then 'Yes' else 'No' end as isfg,
						case when a.recordstatus = 1 then 'Yes' else 'No' end as recordstatus
						from materialgroup a ";
		$materialgroupid = filter_input(INPUT_GET,'materialgroupid');
		$materialgroupcode = filter_input(INPUT_GET,'materialgroupcode');
		$description = filter_input(INPUT_GET,'description');
		$sql .= " where coalesce(a.materialgroupid,'') like '%".$materialgroupid."%' 
			and coalesce(a.materialgroupcode,'') like '%".$materialgroupcode."%'
			and coalesce(a.description,'') like '%".$description."%'
			";
		if ($_GET['materialgroupid'] !== '') {
				$sql = $sql . " and a.materialgroupid in (".$_GET['materialgroupid'].")";
		}
			$sql = $sql . " order by materialgroupcode asc ";
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		$i=2;		
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0,2,GetCatalog('materialgroupid'))
			->setCellValueByColumnAndRow(1,2,GetCatalog('materialgroupcode'))			
			->setCellValueByColumnAndRow(2,2,GetCatalog('description'))
			->setCellValueByColumnAndRow(3,2,GetCatalog('parentmatgroup'))
			->setCellValueByColumnAndRow(4,2,GetCatalog('isfg'))
			->setCellValueByColumnAndRow(5,2,GetCatalog('recordstatus'));
		foreach($dataReader as $row1) {
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, $i+1, $row1['materialgroupid'])
				->setCellValueByColumnAndRow(1, $i+1, $row1['materialgroupcode'])				
				->setCellValueByColumnAndRow(2, $i+1, $row1['description'])
				->setCellValueByColumnAndRow(3, $i+1, $row1['parentmatgroup'])
				->setCellValueByColumnAndRow(4, $i+1, $row1['isfg'])
				->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
			$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);	
	}
}