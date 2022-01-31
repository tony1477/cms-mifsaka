<?php

class CatalogsysController extends AdminController
{
	protected $menuname = 'catalogsys';
	public $module = 'Admin';
	protected $pageTitle = 'Kamus';
	public $wfname = '';
	protected $sqldata = "select a0.catalogsysid,a0.languageid,a0.catalogname,a0.catalogval,a1.languagename as languagename 
    from catalogsys a0 
    left join language a1 on a1.languageid = a0.languageid
  ";
  protected $sqlcount = "select count(1) 
    from catalogsys a0 
    left join language a1 on a1.languageid = a0.languageid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['catalogname'])) && (isset($_REQUEST['catalogval'])) && (isset($_REQUEST['languagename'])))
		{				
			$where .= " where a0.catalogname like '%". $_REQUEST['catalogname']."%' 
and a0.catalogval like '%". $_REQUEST['catalogval']."%' 
and a1.languagename like '%". $_REQUEST['languagename']."%'"; 
		}
		if (isset($_REQUEST['catalogsysid']))
			{
				if (($_REQUEST['catalogsysid'] !== '0') && ($_REQUEST['catalogsysid'] !== ''))
				{
					$where .= " and a0.catalogsysid in (".$_REQUEST['catalogsysid'].")";
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
			'keyField'=>'catalogsysid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'catalogsysid','languageid','catalogname','description','catalogval'
				),
				'defaultOrder' => array( 
					'catalogsysid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where catalogsysid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'catalogsysid'=>$model['catalogsysid'],
          'languageid'=>$model['languageid'],
          'catalogname'=>$model['catalogname'],
          'catalogval'=>$model['catalogval'],
          'languagename'=>$model['languagename'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('languageid','string','emptylanguageid'),
      array('catalogname','string','emptycatalogname'),
      array('catalogval','string','emptycatalogval'),
    ));
		if ($error == false)
		{
			$id = $_POST['catalogsysid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update catalogsys 
			      set languageid = :languageid,catalogname = :catalogname,catalogval = :catalogval 
			      where catalogsysid = :catalogsysid';
				}
				else
				{
					$sql = 'insert into catalogsys (languageid,catalogname,catalogval) 
			      values (:languageid,:catalogname,:catalogval)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':catalogsysid',$_POST['catalogsysid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':languageid',(($_POST['languageid']!=='')?$_POST['languageid']:null),PDO::PARAM_STR);
        $command->bindvalue(':catalogname',(($_POST['catalogname']!=='')?$_POST['catalogname']:null),PDO::PARAM_STR);
        $command->bindvalue(':catalogval',(($_POST['catalogval']!=='')?$_POST['catalogval']:null),PDO::PARAM_STR);
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
				$sql = "delete from catalogsys where catalogsysid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('catalogsys');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('catalogsysid'),$this->getCatalog('language'),$this->getCatalog('catalogname'),$this->getCatalog('description'),$this->getCatalog('catalogval'));
		$this->pdf->setwidths(array(10,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['catalogsysid'],$row1['languagename'],$row1['catalogname'],$row1['description'],$row1['catalogval']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('catalogsysid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('languagename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('catalogname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('catalogval'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['catalogsysid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['languagename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['catalogname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['description'])
->setCellValueByColumnAndRow(4, $i+1, $row1['catalogval']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}