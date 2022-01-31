<?php

class OrgstructureController extends AdminController
{
	protected $menuname = 'orgstructure';
	public $module = 'Hr';
	protected $pageTitle = 'Struktur Organisasi';
	public $wfname = 'apporgstructure';
	protected $sqldata = "select a0.orgstructureid,a0.companyid,a0.structurename,a0.parentid,(select substring_index(substring_index(structurename, ',', 1), ',', - 1) from orgstructure where orgstructureid=a0.parentid) as parentstructure,a0.recordstatus,a1.companyname as companyname,substring_index(substring_index(a0.structurename, ',', 1), ',', - 1) as structurename, substring_index(substring_index(a0.structurename, ',', 2), ',', - 1) as department, substring_index(substring_index(a0.structurename, ',', 3), ',', - 1) as divisi, a0.recordstatus 
    from orgstructure a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from orgstructure a0 
    left join company a1 on a1.companyid = a0.companyid
    left join orgstructure a2 on a2.orgstructureid = a0.parentid
  ";
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if (isset($_REQUEST['companyname']) && isset($_REQUEST['structurename']))
		{				
			$where .= " where a1.companyname like '%".$_REQUEST['companyname']."%' 
									and a0.structurename like '%".$_REQUEST['structurename']."%' "; 
		}
		if (isset($_REQUEST['orgstructureid']))
			{
				if (($_REQUEST['orgstructureid'] !== '0') && ($_REQUEST['orgstructureid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.orgstructureid in (".$_REQUEST['orgstructureid'].")";
					}
					else
					{
						$where .= " and a0.orgstructureid in (".$_REQUEST['orgstructureid'].")";
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
			'keyField'=>'orgstructureid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'orgstructureid','companyid','structurename','department','divisi','parentid','recordstatus'
				),
				'defaultOrder' => array( 
					'orgstructureid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("insorgstructure")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.orgstructureid = '.$id)->queryRow();
            if ($model !== null)
            {
                echo CJSON::encode(array(
                    'status'=>'success',
                    'orgstructureid'=>$model['orgstructureid'],
                    'companyid'=>$model['companyid'],
                    'structurename'=>$model['structurename'],
                    'department'=>$model['department'],
                    'divisi'=>$model['divisi'],
                    'parentstructure'=>$model['parentstructure'],
                    'parentid'=>$model['parentid'],
                    'recordstatus'=>$model['recordstatus'],
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
			array('companyid','string','emptycompanyid'),
            array('structurename','string','emptystructurename'),
            array('department','string','emptydepartment'),
            array('divisi','string','emptydivisi'),
    ));
		if ($error == false)
		{
			$id = $_POST['orgstructureid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
                $name1 = rtrim($_POST['structurename']);
                $name2 = rtrim($_POST['department']);
                $name3 = rtrim($_POST['divisi']);
                $name = $name1.','.$name2.','.$name3;
				if ($id !== '')
				{
					$sql = 'call UpdateOrgStructure(:vid,:vstructurename,:vparentid,:vcompanyid,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertOrgStructure(:vstructurename,:vparentid,:vcompanyid,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['orgstructureid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':vstructurename',$name,PDO::PARAM_STR);
                $command->bindvalue(':vparentid',(($_POST['parentid']!=='')?$_POST['parentid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcompanyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
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
	public function actionApprove()
	{
		parent::actionPost();
		if (isset($_POST['id']))
		{
			$id=$_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Approveorgstructure(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
				$sql = 'call Deleteorgstructure(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
				foreach($id as $ids)
				{
					$command->bindvalue(':vid',$ids,PDO::PARAM_STR);
					$command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
				$sql = "delete from orgstructure where orgstructureid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('orgstructure');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('orgstructureid'),$this->getCatalog('company'),$this->getCatalog('structurename'),$this->getCatalog('parent'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['orgstructureid'],$row1['companyname'],$row1['structurename'],$row1['structurename'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('orgstructureid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('structurename'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('structurename'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['orgstructureid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['structurename'])
->setCellValueByColumnAndRow(3, $i+1, $row1['structurename'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}