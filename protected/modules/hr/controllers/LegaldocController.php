<?php

class LegaldocController extends AdminController
{
	protected $menuname = 'legaldoc';
	public $module = 'Hr';
	protected $pageTitle = 'Dokumen Legal';
	public $wfname = '';
	protected $sqldata = "select a0.legaldocid,a0.doctypeid,a0.docname,a0.docno,a0.docdate,a0.doccompanyid,a0.storagedocid,a0.description, doctypename, storagedocname, companyname,expireddate
    from legaldoc a0 
    left join doctype a1 on a1.doctypeid = a0.doctypeid
    left join storagedoc a2 on a2.storagedocid = a0.storagedocid
    left join company a3 on a3.companyid = a0.doccompanyid
  ";
  protected $sqlcount = "select count(1)
    from legaldoc a0
    left join doctype a1 on a1.doctypeid = a0.doctypeid
    left join storagedoc a2 on a2.storagedocid = a0.storagedocid
    left join company a3 on a3.companyid = a0.doccompanyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['docname'])) && (isset($_REQUEST['docno'])))
		{				
			$where .= " where a0.docname like '%". $_REQUEST['docname']."%' 
and a0.docno like '%". $_REQUEST['docno']."%'"; 
		}
		if (isset($_REQUEST['legaldocid']))
			{
				if (($_REQUEST['legaldocid'] !== '0') && ($_REQUEST['legaldocid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.legaldocid in (".$_REQUEST['legaldocid'].")";
					}
					else
					{
						$where .= " and a0.legaldocid in (".$_REQUEST['legaldocid'].")";
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
			'keyField'=>'legaldocid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'legaldocid','doctypeid','docname','docno','docdate','expireddate','doccompanyid','storagedocid','description'
				),
				'defaultOrder' => array( 
					'legaldocid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"docdate" =>date("Y-m-d")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.legaldocid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'legaldocid'=>$model['legaldocid'],
          'doctypeid'=>$model['doctypeid'],
          'doctypename'=>$model['doctypename'],
          'docname'=>$model['docname'],
          'docno'=>$model['docno'],
          'docdate'=>$model['docdate'],
          'expireddate'=>$model['expireddate'],
          'doccompanyid'=>$model['doccompanyid'],
          'companyname'=>$model['companyname'],
          'storagedocid'=>$model['storagedocid'],
          'storagedocname'=>$model['storagedocname'],
          'description'=>$model['description'],

					));
					Yii::app()->end();
				}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('doctypeid','string','emptydoctypeid'),
      array('docname','string','emptydocname'),
      array('docno','string','emptydocno'),
    ));
		if ($error == false)
		{
			$id = $_POST['legaldocid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatelegaldoc(:vid,:vdoctypeid,:vdocname,:vdocno,:vdocdate,:vexpireddate,:vdoccompanyid,:vstoragedocid,:vdescription,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertLegaldoc(:vdoctypeid,:vdocname,:vdocno,:vdocdate,:vexpireddate,:vdoccompanyid,:vstoragedocid,:vdescription,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['legaldocid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vdoctypeid',(($_POST['doctypeid']!=='')?$_POST['doctypeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocname',(($_POST['docname']!=='')?$_POST['docname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocno',(($_POST['docno']!=='')?$_POST['docno']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vexpireddate',(($_POST['expireddate']!=='')?$_POST['expireddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdoccompanyid',(($_POST['doccompanyid']!=='')?$_POST['doccompanyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vstoragedocid',(($_POST['storagedocid']!=='')?$_POST['storagedocid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdescription',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
			}
			catch (CDbException $e)
			{
				$transaction->rollBack();
				$this->getMessage('error',$e->getMessage());
			}
		}
	}
				
	
	/*
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
				$sql = "delete from legaldoc where legaldocid = ".$id[$i];
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
    */
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('legaldoc');
		$this->pdf->AddPage('L',array(200,350));
		$this->pdf->setFont('Arial','',9);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('legaldocid'),$this->getCatalog('doctype'),$this->getCatalog('docname'),$this->getCatalog('docno'),$this->getCatalog('docdate'),$this->getCatalog('expireddate'),$this->getCatalog('doccompany'),$this->getCatalog('storagedoc'),$this->getCatalog('description'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['legaldocid'],$row1['doctypename'],$row1['docname'],$row1['docno'],date(Yii::app()->params['dateviewfromdb'],strtotime($row1['docdate'])),date(Yii::app()->params['dateviewfromdb'],strtotime($row1['expireddate'])),$row1['companyname'],$row1['storagedocname'],$row1['description']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('legaldocid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('doctypeid'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('docname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('docno'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('doccompanyid'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('storagedocid'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('description'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['legaldocid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['doctypeid'])
->setCellValueByColumnAndRow(2, $i+1, $row1['docname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['docno'])
->setCellValueByColumnAndRow(4, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['doccompanyid'])
->setCellValueByColumnAndRow(6, $i+1, $row1['storagedocid'])
->setCellValueByColumnAndRow(7, $i+1, $row1['description']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}