<?php

class KepletterController extends AdminController
{
	protected $menuname = 'kepletter';
	public $module = 'hr';
	protected $pageTitle = 'Surat Keputusan';
	public $wfname = '';
	protected $sqldata = "select a0.kepletterid,a0.nosuid,a0.kopletter,a0.dateletter,a0.docupload, a1.companyname
    from kepletter a0 
	left join company a1 on a1.companyid=a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from kepletter a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['kopletter']))  &&
            (isset($_REQUEST['nosuid'])) &&
            (isset($_REQUEST['docupload']))
           )
		{				
			$where .= " where a0.kopletter like '%". $_REQUEST['kopletter']."%' and
            a0.nosuid like '%". $_REQUEST['nosuid']."%' and
             a0.docupload like '%". $_REQUEST['docupload']."%'"; 
		}
		if (isset($_REQUEST['kepletterid']))
			{
				if (($_REQUEST['kepletterid'] !== '0') && ($_REQUEST['kepletterid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.kepletterid in (".$_REQUEST['kepletterid'].")";
					}
					else
					{
						$where .= " and a0.kepletterid in (".$_REQUEST['kepletterid'].")";
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
			'keyField'=>'kepletterid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'kepletterid','nosuid','kopletter','dateletter','docupload','companyid'
				),
				'defaultOrder' => array( 
					'kepletterid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

    public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/suratkeputusan/'))
		{
            mkdir(Yii::getPathOfAlias('webroot').'/images/suratkeputusan/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/suratkeputusan/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
    
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"dateletter" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.kepletterid = '.$id)->queryRow();
			
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'kepletterid'=>$model['kepletterid'],
          'nosuid'=>$model['nosuid'],
          'kopletter'=>$model['kopletter'],
        'companyname'=>$model['companyname'],
          'dateletter'=>$model['dateletter'],
          'docupload'=>$model['docupload'],
        

					));
					Yii::app()->end();
				}
		
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
      array('dateletter','string','emptydateletter'),
     array('companyid','string','emptycompanyid'),
      array('docupload','string','emptydocupload'),
    ));
		if ($error == false)
		{
			$id = $_POST['kepletterid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update kepletter 
			      set nosuid = :nosuid,kopletter = :kopletter,companyid = :companyid,dateletter = :dateletter,docupload = :docupload 
			      where kepletterid = :kepletterid';
				}
				else
				{
					$sql = 'insert into kepletter (nosuid,kopletter,companyid,dateletter,docupload) 
			      values (:nosuid,:kopletter,:companyid,:dateletter,:docupload)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':kepletterid',$_POST['kepletterid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':nosuid',(($_POST['nosuid']!=='')?$_POST['nosuid']:null),PDO::PARAM_STR);
        $command->bindvalue(':kopletter',(($_POST['kopletter']!=='')?$_POST['kopletter']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':dateletter',(($_POST['dateletter']!=='')?$_POST['dateletter']:null),PDO::PARAM_STR);
        $command->bindvalue(':docupload',(($_POST['docupload']!=='')?$_POST['docupload']:null),PDO::PARAM_STR);
       
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
				$sql = "delete from kepletter where kepletterid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('kepletter');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('id'),$this->getCatalog('nosu'),$this->getCatalog('kopletter'),$this->getCatalog('dateletter'),$this->getCatalog('companyname'));
		$this->pdf->setwidths(array(10,35,30,30,70));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('C','C','C','C','C');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['kepletterid'],$row1['nosuid'],$row1['kopletter'],$row1['dateletter'],$row1['companyname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('kepletterid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('nosuid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('kopletter'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('dateletter'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docupload'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('companyname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['kepletterid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['nosuid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['kopletter'])
->setCellValueByColumnAndRow(3, $i+1, $row1['dateletter'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docupload'])
->setCellValueByColumnAndRow(4, $i+1, $row1['companyname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}