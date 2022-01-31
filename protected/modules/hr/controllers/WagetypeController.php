<?php

class WagetypeController extends AdminController
{
	protected $menuname = 'wagetype';
	public $module = 'hr';
	protected $pageTitle = 'Jenis Penggajian';
	public $wfname = 'appwagetype';
	protected $sqldata = "select a0.wagetypeid,a0.wagename,a0.ispph,a0.ispayroll,a0.isprint,a0.percentage,a0.maxvalue,a0.currencyid,a0.isrutin,a0.paidbycompany,a0.pphbycompany,a0.recordstatus,a1.currencyname as currencyname,getwfstatusbywfname('appwagetype',a0.recordstatus) as statusname  
    from wagetype a0 
    left join currency a1 on a1.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from wagetype a0 
    left join currency a1 on a1.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['wagename'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .= " where a0.wagename like '%". $_REQUEST['wagename']."%' 
and a1.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['wagetypeid']))
			{
				if (($_REQUEST['wagetypeid'] !== '0') && ($_REQUEST['wagetypeid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.wagetypeid in (".$_REQUEST['wagetypeid'].")";
					}
					else
					{
						$where .= " and a0.wagetypeid in (".$_REQUEST['wagetypeid'].")";
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
			'keyField'=>'wagetypeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'wagetypeid','wagename','ispph','ispayroll','isprint','percentage','maxvalue','currencyid','isrutin','paidbycompany','pphbycompany','recordstatus'
				),
				'defaultOrder' => array( 
					'wagetypeid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
      "percentage" =>0,
      "maxvalue" =>0,
      "currencyid" => $this->GetParameter("basecurrencyid"),		"currencyname" => $this->GetParameter("basecurrency"),
      "recordstatus" =>$this->findstatusbyuser("inswagetype")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.wagetypeid = '.$id)->queryRow();
			
				if ($model !== null)
				{
					echo CJSON::encode(array(
          'status'=>'success',
          'wagetypeid'=>$model['wagetypeid'],
          'wagename'=>$model['wagename'],
          'ispph'=>$model['ispph'],
          'ispayroll'=>$model['ispayroll'],
          'isprint'=>$model['isprint'],
          'percentage'=>$model['percentage'],
          'maxvalue'=>$model['maxvalue'],
          'currencyid'=>$model['currencyid'],
          'isrutin'=>$model['isrutin'],
          'paidbycompany'=>$model['paidbycompany'],
          'pphbycompany'=>$model['pphbycompany'],
          'recordstatus'=>$model['recordstatus'],
          'currencyname'=>$model['currencyname'],

					));
					Yii::app()->end();
				}
			
			}
		
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('wagename','string','emptywagename'),
      array('currencyid','string','emptycurrencyid'),
    ));
		if ($error == false)
		{
			$id = $_POST['wagetypeid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update wagetype 
			      set wagename = :wagename,ispph = :ispph,ispayroll = :ispayroll,isprint = :isprint,percentage = :percentage,`maxvalue` = :maxvalue,currencyid = :currencyid,isrutin = :isrutin,paidbycompany = :paidbycompany,pphbycompany = :pphbycompany,recordstatus = :recordstatus 
			      where wagetypeid = :wagetypeid';
				}
				else
				{
					$sql = 'insert into wagetype(wagename,ispph,ispayroll,isprint,percentage,`maxvalue`,currencyid,isrutin,paidbycompany,pphbycompany,recordstatus) values(:wagename,:ispph,:ispayroll,:isprint,:percentage,:maxvalue,:currencyid,:isrutin,:paidbycompany,:pphbycompany,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':wagetypeid',$_POST['wagetypeid'],PDO::PARAM_STR);
				}
                $command->bindvalue(':wagename',(($_POST['wagename']!=='')?$_POST['wagename']:null),PDO::PARAM_STR);
                $command->bindvalue(':ispph',(($_POST['ispph']!=='')?$_POST['ispph']:null),PDO::PARAM_STR);
                $command->bindvalue(':ispayroll',(($_POST['ispayroll']!=='')?$_POST['ispayroll']:null),PDO::PARAM_STR);
                $command->bindvalue(':isprint',(($_POST['isprint']!=='')?$_POST['isprint']:null),PDO::PARAM_STR);
                $command->bindvalue(':percentage',(($_POST['percentage']!=='')?$_POST['percentage']:'0'),PDO::PARAM_STR);
                $command->bindvalue(':maxvalue',(($_POST['maxvalue']!=='')?$_POST['maxvalue']:'0'),PDO::PARAM_STR);
                $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':isrutin',(($_POST['isrutin']!=='')?$_POST['isrutin']:'0'),PDO::PARAM_STR);
                $command->bindvalue(':paidbycompany',(($_POST['paidbycompany']!=='')?$_POST['paidbycompany']:'0'),PDO::PARAM_STR);
                $command->bindvalue(':pphbycompany',(($_POST['pphbycompany']!=='')?$_POST['pphbycompany']:'0'),PDO::PARAM_STR);
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
				$sql = 'call Approvewagetype(:vid,:vcreatedby)';
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
				$sql = 'call Deletewagetype(:vid,:vcreatedby)';
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
				$sql = "delete from wagetype where wagetypeid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('wagetype');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('wagetypeid'),$this->getCatalog('wagename'),$this->getCatalog('ispph'),$this->getCatalog('ispayroll'),$this->getCatalog('isprint'),$this->getCatalog('percentage'),$this->getCatalog('maxvalue'),$this->getCatalog('currency'),$this->getCatalog('isrutin'),$this->getCatalog('paidbycompa'),$this->getCatalog('pphbycompany'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,15,15,15,40,40,40,15,15,15,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['wagetypeid'],$row1['wagename'],$row1['ispph'],$row1['ispayroll'],$row1['isprint'],$row1['percentage'],$row1['maxvalue'],$row1['currencyname'],$row1['isrutin'],$row1['paidbycompany'],$row1['pphbycompany'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('wagetypeid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('wagename'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('ispph'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('ispayroll'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('isprint'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('percentage'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('maxvalue'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('isrutin'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('paidbycompany'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('pphbycompany'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['wagetypeid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['wagename'])
->setCellValueByColumnAndRow(2, $i+1, $row1['ispph'])
->setCellValueByColumnAndRow(3, $i+1, $row1['ispayroll'])
->setCellValueByColumnAndRow(4, $i+1, $row1['isprint'])
->setCellValueByColumnAndRow(5, $i+1, $row1['percentage'])
->setCellValueByColumnAndRow(6, $i+1, $row1['maxvalue'])
->setCellValueByColumnAndRow(7, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(8, $i+1, $row1['isrutin'])
->setCellValueByColumnAndRow(9, $i+1, $row1['paidbycompany'])
->setCellValueByColumnAndRow(10, $i+1, $row1['pphbycompany'])
->setCellValueByColumnAndRow(11, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}