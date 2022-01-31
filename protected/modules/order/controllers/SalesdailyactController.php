<?php

class SalesdailyactController extends AdminController
{
	protected $menuname = 'salesdailyact';
	public $module = 'Order';
	protected $pageTitle = 'Kegiatan Sales';
	public $wfname = 'appsalesdailyact';
	protected $sqldata = "select a0.salesdailyactid,a0.salesdailyno,a0.companyid,a0.employeeid,a0.dailydatetime,a0.dailypic,a0.description,a0.dailylat,a0.dailylng,a0.recordstatus,a1.companyname as companyname,a2.fullname as salesname,getwfstatusbywfname('appsalesdailyact',a0.recordstatus) as statusname  
    from salesdailyact a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";
  protected $sqlcount = "select count(1) 
    from salesdailyact a0 
    left join company a1 on a1.companyid = a0.companyid
    left join employee a2 on a2.employeeid = a0.employeeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['salesdailyno'])) && (isset($_REQUEST['dailypic'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['salesname'])))
		{				
			$where .=  " 
and a0.salesdailyno like '%". $_REQUEST['salesdailyno']."%' 
and a0.dailypic like '%". $_REQUEST['dailypic']."%' 
and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.salesname like '%". $_REQUEST['salesname']."%'"; 
		}
		if (isset($_REQUEST['salesdailyactid']))
			{
				if (($_REQUEST['salesdailyactid'] !== '0') && ($_REQUEST['salesdailyactid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.salesdailyactid in (".$_REQUEST['salesdailyactid'].")";
					}
					else
					{
						$where .= " and a0.salesdailyactid in (".$_REQUEST['salesdailyactid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
	public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		}
		$this->storeFolder = dirname('__FILES__').'/uploads/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'salesdailyactid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'salesdailyactid','salesdailyno','companyid','employeeid','dailydatetime','dailypic','description','dailylat','dailylng','statusname'
				),
				'defaultOrder' => array( 
					'salesdailyactid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("inssalesdailyact")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.salesdailyactid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'salesdailyactid'=>$model['salesdailyactid'],
          'companyid'=>$model['companyid'],
          'employeeid'=>$model['employeeid'],
          'dailydatetime'=>$model['dailydatetime'],
          'dailypic'=>$model['dailypic'],
          'description'=>$model['description'],
          'dailylat'=>$model['dailylat'],
          'dailylng'=>$model['dailylng'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'salesname'=>$model['salesname'],

					));
					Yii::app()->end();
				}
			}
			else
			{
				$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('employeeid','string','emptyemployeeid'),
      array('dailypic','string','emptydailypic'),
      array('description','string','emptydescription'),
      array('dailylat','string','emptydailylat'),
      array('dailylng','string','emptydailylng'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesdailyactid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update salesdailyact 
			      set companyid = :companyid,employeeid = :employeeid,dailypic = :dailypic,description = :description,dailylat = :dailylat,dailylng = :dailylng,recordstatus = :recordstatus 
			      where salesdailyactid = :salesdailyactid';
				}
				else
				{
					$sql = 'insert into salesdailyact (companyid,employeeid,dailypic,description,dailylat,dailylng,recordstatus) 
			      values (:companyid,:employeeid,:dailypic,:description,:dailylat,:dailylng,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':salesdailyactid',$_POST['salesdailyactid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':dailypic',(($_POST['dailypic']!=='')?$_POST['dailypic']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':dailylat',(($_POST['dailylat']!=='')?$_POST['dailylat']:null),PDO::PARAM_STR);
        $command->bindvalue(':dailylng',(($_POST['dailylng']!=='')?$_POST['dailylng']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvesalesdailyact(:vid,:vcreatedby)';
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
				$sql = 'call Deletesalesdailyact(:vid,:vcreatedby)';
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
				$sql = "delete from salesdailyact where salesdailyactid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('salesdailyact');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('salesdailyactid'),$this->getCatalog('salesdailyno'),$this->getCatalog('company'),$this->getCatalog('employee'),$this->getCatalog('dailydatetime'),$this->getCatalog('dailypic'),$this->getCatalog('description'),$this->getCatalog('dailylat'),$this->getCatalog('dailylng'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['salesdailyactid'],$row1['salesdailyno'],$row1['companyname'],$row1['fullname'],$row1['dailydatetime'],$row1['dailypic'],$row1['description'],$row1['dailylat'],$row1['dailylng'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('salesdailyactid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('salesdailyno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('dailydatetime'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('dailypic'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('dailylat'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('dailylng'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['salesdailyactid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['salesdailyno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(4, $i+1, $row1['dailydatetime'])
->setCellValueByColumnAndRow(5, $i+1, $row1['dailypic'])
->setCellValueByColumnAndRow(6, $i+1, $row1['description'])
->setCellValueByColumnAndRow(7, $i+1, $row1['dailylat'])
->setCellValueByColumnAndRow(8, $i+1, $row1['dailylng'])
->setCellValueByColumnAndRow(9, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
