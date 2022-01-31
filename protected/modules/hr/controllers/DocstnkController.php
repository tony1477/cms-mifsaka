<?php

class DocstnkController extends AdminController
{
	protected $menuname = 'docstnk';
	public $module = 'hr';
	protected $pageTitle = 'Dokument STNK';
	public $wfname = '';
	protected $sqldata = "select a0.docid,a0.namedoc,a0.nodoc,a0.exdate,a0.cost,a0.docupload,a0.companyid,a1.companyname
    from docstnk a0
    left join company a1 on a1.companyid=a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from docstnk a0 
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['namedoc'])) && (isset($_REQUEST['nodoc'])) && (isset($_REQUEST['cost'])) && (isset($_REQUEST['docupload'])))
		{				
$where .= " where a0.namedoc like '%". $_REQUEST['namedoc']."%' and 
a0.nodoc like '%". $_REQUEST['nodoc']."%' and 
a0.cost like '%". $_REQUEST['cost']."%' and 
a0.docupload like '%". $_REQUEST['docupload']."%'"; 
		}
		if (isset($_REQUEST['docid']))
			{
				if (($_REQUEST['docid'] !== '0') && ($_REQUEST['docid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.docid in (".$_REQUEST['docid'].")";
					}
					else
					{
						$where .= " and a0.docid in (".$_REQUEST['docid'].")";
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
			'keyField'=>'docid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'docid','namedoc','nodoc','exdate','cost','docupload','companyid'
				),
				'defaultOrder' => array( 
					'docid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

     public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/dokumenstnk/'))
		{
            mkdir(Yii::getPathOfAlias('webroot').'/images/dokumenstnk/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/dokumenstnk/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"exdate" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.docid = '.$id)->queryRow();
			
				if ($model !== null)
				{
					echo CJSON::encode(array(
          'status'=>'success',
          'docid'=>$model['docid'],
          'namedoc'=>$model['namedoc'],
          'nodoc'=>$model['nodoc'],
          'exdate'=>$model['exdate'],
          'cost'=>$model['cost'],
          'docupload'=>$model['docupload'],
          'companyname'=>$model['companyname'],

					));
					Yii::app()->end();
				}
        }
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('namedoc','string','emptynamedoc'),
      array('nodoc','string','emptynodoc'),
      array('exdate','string','emptyexdate'),
      array('cost','string','emptycost'),
      array('docupload','string','emptydocupload'),
      array('companyid','string','emptycompanyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['docid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update docstnk 
			      set namedoc = :namedoc,nodoc = :nodoc,exdate = :exdate,cost = :cost,docupload = :docupload,companyid = :companyid 
			      where docid = :docid';
				}
				else
				{
					$sql = 'insert into docstnk (namedoc,nodoc,exdate,cost,docupload,companyid) 
			      values (:namedoc,:nodoc,:exdate,:cost,:docupload,:companyid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':docid',$_POST['docid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':namedoc',(($_POST['namedoc']!=='')?$_POST['namedoc']:null),PDO::PARAM_STR);
        $command->bindvalue(':nodoc',(($_POST['nodoc']!=='')?$_POST['nodoc']:null),PDO::PARAM_STR);
        $command->bindvalue(':exdate',(($_POST['exdate']!=='')?$_POST['exdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':cost',(($_POST['cost']!=='')?$_POST['cost']:null),PDO::PARAM_STR);
        $command->bindvalue(':docupload',(($_POST['docupload']!=='')?$_POST['docupload']:null),PDO::PARAM_STR);
        $command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
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
				$sql = "delete from docstnk where docid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('Docstnk');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('docid'),$this->getCatalog('namedoc'),$this->getCatalog('nodoc'),$this->getCatalog('exdate'),$this->getCatalog('cost'),$this->getCatalog('docupload'),$this->getCatalog('companyname'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['docid'],$row1['namedoc'],$row1['nodoc'],$row1['exdate'],$row1['cost'],$row1['docupload'],$row1['companyname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('docid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('namedoc'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('nodoc'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('exdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('cost'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('docupload'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('companyname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['docid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['namedoc'])
->setCellValueByColumnAndRow(2, $i+1, $row1['nodoc'])
->setCellValueByColumnAndRow(3, $i+1, $row1['exdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['cost'])
->setCellValueByColumnAndRow(5, $i+1, $row1['docupload'])
->setCellValueByColumnAndRow(6, $i+1, $row1['companyname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}