<?php

class CityController extends AdminController
{
	protected $menuname = 'city';
	public $module = 'Admin';
	protected $pageTitle = 'Kota';
	public $wfname = '';
	protected $sqldata = "select a0.cityid,a0.provinceid,a0.citycode,a0.cityname,a0.recordstatus,a1.provincename as provincename 
    from city a0 
    left join province a1 on a1.provinceid = a0.provinceid
  ";
  protected $sqlcount = "select count(1) 
    from city a0 
    left join province a1 on a1.provinceid = a0.provinceid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['citycode'])) && (isset($_REQUEST['cityname'])) && (isset($_REQUEST['provincename'])))
		{				
			$where .= " where a0.citycode like '%". $_REQUEST['citycode']."%' 
and a0.cityname like '%". $_REQUEST['cityname']."%' 
and a1.provincename like '%". $_REQUEST['provincename']."%'"; 
		}
		if (isset($_REQUEST['cityid']))
			{
				if (($_REQUEST['cityid'] !== '0') && ($_REQUEST['cityid'] !== ''))
				{
					$where .= " and a0.cityid in (".$_REQUEST['cityid'].")";
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
			'keyField'=>'cityid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'cityid','provinceid','citycode','cityname','recordstatus'
				),
				'defaultOrder' => array( 
					'cityid' => CSort::SORT_DESC
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where cityid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'cityid'=>$model['cityid'],
          'provinceid'=>$model['provinceid'],
          'citycode'=>$model['citycode'],
          'cityname'=>$model['cityname'],
          'recordstatus'=>$model['recordstatus'],
          'provincename'=>$model['provincename'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('provinceid','string','emptyprovinceid'),
      array('citycode','string','emptycitycode'),
      array('cityname','string','emptycityname'),
    ));
		if ($error == false)
		{
			$id = $_POST['cityid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update city 
			      set provinceid = :provinceid,citycode = :citycode,cityname = :cityname,recordstatus = :recordstatus 
			      where cityid = :cityid';
				}
				else
				{
					$sql = 'insert into city (provinceid,citycode,cityname,recordstatus) 
			      values (:provinceid,:citycode,:cityname,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':cityid',$_POST['cityid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':provinceid',(($_POST['provinceid']!=='')?$_POST['provinceid']:null),PDO::PARAM_STR);
        $command->bindvalue(':citycode',(($_POST['citycode']!=='')?$_POST['citycode']:null),PDO::PARAM_STR);
        $command->bindvalue(':cityname',(($_POST['cityname']!=='')?$_POST['cityname']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
					$sql = "select recordstatus from city where cityid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update city set recordstatus = 0 where cityid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update city set recordstatus = 1 where cityid = ".$id[$i];
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from city where cityid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('city');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('cityid'),$this->getCatalog('province'),$this->getCatalog('citycode'),$this->getCatalog('cityname'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,60,40,60,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['cityid'],$row1['provincename'],$row1['citycode'],$row1['cityname'],
			(($row1['recordstatus'] == 1)?'Active':'NotActive')));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('cityid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('provincename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('citycode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cityname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['cityid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['provincename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['citycode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cityname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}