<?php

class OnleavetypeController extends AdminController
{
	protected $menuname = 'onleavetype';
	public $module = 'Hr';
	protected $pageTitle = 'Jenis Cuti';
	public $wfname = '';
	protected $sqldata = "select a0.onleavetypeid,a0.onleavename,a0.cutimax,a0.cutistart,a0.snroid,a0.absstatusid,a0.recordstatus,a1.description as snro,a2.longstat as absstatus,getwfstatusbywfname('',a0.recordstatus) as statusname  
    from onleavetype a0 
    left join snro a1 on a1.snroid = a0.snroid
    left join absstatus a2 on a2.absstatusid = a0.absstatusid
  ";
  protected $sqlcount = "select count(1) 
    from onleavetype a0 
    left join snro a1 on a1.snroid = a0.snroid
    left join absstatus a2 on a2.absstatusid = a0.absstatusid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['onleavename'])))
		{				
			$where .= " where a0.onleavename like '%". $_REQUEST['onleavename']."%'"; 
		}
		if (isset($_REQUEST['onleavetypeid']))
			{
				if (($_REQUEST['onleavetypeid'] !== '0') && ($_REQUEST['onleavetypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.onleavetypeid in (".$_REQUEST['onleavetypeid'].")";
					}
					else
					{
						$where .= " and a0.onleavetypeid in (".$_REQUEST['onleavetypeid'].")";
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
			'keyField'=>'onleavetypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'onleavetypeid','onleavename','cutimax','cutistart','snroid','absstatusid','recordstatus'
				),
				'defaultOrder' => array( 
					'onleavetypeid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.onleavetypeid = '.$id)->queryRow();
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'onleavetypeid'=>$model['onleavetypeid'],
                        'onleavename'=>$model['onleavename'],
                        'cutimax'=>$model['cutimax'],
                        'cutistart'=>$model['cutistart'],
                        'snroid'=>$model['snroid'],
                        'absstatusid'=>$model['absstatusid'],
                        'recordstatus'=>$model['recordstatus'],
                        'snro'=>$model['snro'],
                        'absstatus'=>$model['absstatus'],
					));
					Yii::app()->end();
				}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('onleavename','string','emptyonleavename'),
      array('cutimax','string','emptycutimax'),
      array('cutistart','string','emptycutistart'),
      array('snroid','string','emptysnroid'),
      array('absstatusid','string','emptyabsstatusid'),
    ));
		if ($error == false)
		{
			$id = $_POST['onleavetypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update onleavetype 
			      set onleavename = :onleavename,cutimax = :cutimax,cutistart = :cutistart,snroid = :snroid,absstatusid = :absstatusid,recordstatus = :recordstatus 
			      where onleavetypeid = :onleavetypeid';
				}
				else
				{
					$sql = 'insert into onleavetype (onleavename,cutimax,cutistart,snroid,absstatusid,recordstatus) 
			      values (:onleavename,:cutimax,:cutistart,:snroid,:absstatusid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':onleavetypeid',$_POST['onleavetypeid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':onleavename',(($_POST['onleavename']!=='')?$_POST['onleavename']:null),PDO::PARAM_STR);
        $command->bindvalue(':cutimax',(($_POST['cutimax']!=='')?$_POST['cutimax']:null),PDO::PARAM_STR);
        $command->bindvalue(':cutistart',(($_POST['cutistart']!=='')?$_POST['cutistart']:null),PDO::PARAM_STR);
        $command->bindvalue(':snroid',(($_POST['snroid']!=='')?$_POST['snroid']:null),PDO::PARAM_STR);
        $command->bindvalue(':absstatusid',(($_POST['absstatusid']!=='')?$_POST['absstatusid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approveonleavetype(:vid,:vcreatedby)';
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
				$sql = 'call Deleteonleavetype(:vid,:vcreatedby)';
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
				$sql = "delete from onleavetype where onleavetypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('onleavetype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('onleavetypeid'),$this->getCatalog('onleavename'),$this->getCatalog('cutimax'),$this->getCatalog('cutistart'),$this->getCatalog('snro'),$this->getCatalog('absstatus'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['onleavetypeid'],$row1['onleavename'],$row1['cutimax'],$row1['cutistart'],$row1['snro'],$row1['absstatus'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('onleavetypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('onleavename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('cutimax'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('cutistart'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('longstat'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['onleavetypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['onleavename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['cutimax'])
->setCellValueByColumnAndRow(3, $i+1, $row1['cutistart'])
->setCellValueByColumnAndRow(4, $i+1, $row1['description'])
->setCellValueByColumnAndRow(5, $i+1, $row1['longstat'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}