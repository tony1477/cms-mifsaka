<?php

class SpletterController extends AdminController
{
	protected $menuname = 'spletter';
	public $module = 'Hr';
	protected $pageTitle = 'Surat Peringatan';
	public $wfname = 'appspletter';
	protected $sqldata = "select a0.spletterid,a0.employeeid,a0.splettertypeid,a0.spletterdate,a0.description,a0.recordstatus,a1.fullname as fullname,a2.splettername as splettername,getwfstatusbywfname('appspletter',a0.recordstatus) as statusname, a0.spletterno
    from spletter a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join splettertype a2 on a2.splettertypeid = a0.splettertypeid
  ";
  protected $sqlcount = "select count(1) 
    from spletter a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join splettertype a2 on a2.splettertypeid = a0.splettertypeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (select b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join groupaccess c on c.groupaccessid = b.groupaccessid
				inner join usergroup d on d.groupaccessid = c.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where upper(a.wfname) = upper('listspletter') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		if ((isset($_REQUEST['description'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['splettername'])))
		{				
			$where .= " where a0.description like '%". $_REQUEST['description']."%' 
and a1.fullname like '%". $_REQUEST['fullname']."%' 
and a2.splettername like '%". $_REQUEST['splettername']."%'"; 
		}
		if (isset($_REQUEST['spletterid']))
			{
				if (($_REQUEST['spletterid'] !== '0') && ($_REQUEST['spletterid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.spletterid in (".$_REQUEST['spletterid'].")";
					}
					else
					{
						$where .= " and a0.spletterid in (".$_REQUEST['spletterid'].")";
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
			'keyField'=>'spletterid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'spletterid','spletterno','employeeid','splettertypeid','spletterdate','description','recordstatus'
				),
				'defaultOrder' => array( 
					'spletterid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"date" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insspletter")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.spletterid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'spletterid'=>$model['spletterid'],
          'employeeid'=>$model['employeeid'],
          'splettertypeid'=>$model['splettertypeid'],
          'spletterdate'=>$model['spletterdate'],
          'description'=>$model['description'],
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'splettername'=>$model['splettername'],

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
			array('employeeid','string','emptyemployeeid'),
      array('splettertypeid','string','emptysplettertypeid'),
      array('spletterdate','string','emptydate'),
      array('description','string','emptydescription'),
    ));
		if ($error == false)
		{
			$id = $_POST['spletterid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update spletter 
			      set employeeid = :employeeid,splettertypeid = :splettertypeid,spletterdate = :spletterdate,description = :description,recordstatus = :recordstatus 
			      where spletterid = :spletterid';
				}
				else
				{
					$sql = 'insert into spletter (employeeid,splettertypeid,spletterdate,description,recordstatus) 
			      values (:employeeid,:splettertypeid,:spletterdate,:description,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':spletterid',$_POST['spletterid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':employeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':splettertypeid',(($_POST['splettertypeid']!=='')?$_POST['splettertypeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':spletterdate',(($_POST['spletterdate']!=='')?$_POST['spletterdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':description',(($_POST['description']!=='')?$_POST['description']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus','1',PDO::PARAM_STR);
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
				$sql = 'call Approvespletter(:vid,:vcreatedby)';
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
				$sql = 'call Deletespletter(:vid,:vcreatedby)';
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
				$sql = "delete from spletter where spletterid = ".$id[$i];
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
        if(isset($_GET['spletter_0_spletterid']) && $_GET['spletter_0_spletterid']!=''){
            $where = " AND spletterid='".$_GET['spletter_0_spletterid']."'";
        }else{
            $where = '';
        }
		$dataReader=Yii::app()->db->createCommand($this->sqldata.$where)->queryAll();
        foreach($dataReader as $row){
            $this->pdf->isfooter = false;
            //masukkan judul
            //$this->pdf->title=$this->getCatalog('empreward');
            $this->pdf->footer = 0;
            $this->pdf->AddPage('L','A4');
            $this->pdf->sety(5);
            $this->pdf->SetFont('Times','B',24);
            $this->pdf->Cell(0,12,'PUNISHMENT AGREEMENT',0,1,'C');
            $this->pdf->Ln(1);
            $this->pdf->SetFont('Times','',18);
            $this->pdf->Cell(0,5,'=========================================',0,1,'C');

            $this->pdf->SetFont('Times','B',18);
            $this->pdf->Cell(0,12,'KANGAROO SPRINGBED MEMBERIKAN',0,1,'C');
            $this->pdf->Ln(1);
            $this->pdf->SetFont('Times','B',16);
            $this->pdf->Cell(0,1,strtoupper($row['splettername']),0,1,'C');
            $this->pdf->Ln(15);

            $this->pdf->SetFont('Times','B',20);
            $this->pdf->Cell(0,1,'KEPADA YTH ',0,1,'C');
            $this->pdf->Ln(15);

            $this->pdf->SetFont('Times','BU',26);
            $this->pdf->Cell(0,1,$row['fullname'],0,1,'C');
            $this->pdf->Ln(25);

            $this->pdf->SetFont('Times','',20);
            $this->pdf->Cell(0,1,'ATAS KESALAHAN MELAKUKAN TINDAKAN ',0,1,'C');
            $this->pdf->Ln(10);

            $this->pdf->SetFont('Times','B',20);
            $this->pdf->Cell(0,1,'____________________________________________________________________________________',0,1,'C');
            $this->pdf->Ln(2);

            $this->pdf->SetFont('Times','B',20);
            $this->pdf->Cell(0,22,$row['description'],0,1,'C');
            $this->pdf->Ln(0);

            $this->pdf->SetFont('Times','B',20);
            $this->pdf->Cell(0,-5,'____________________________________________________________________________________',0,1,'C');
            $this->pdf->Ln(1);

            $this->pdf->SetFont('times','',18);
            $this->pdf->text(240,150,date(Yii::app()->params['dateviewfromdb'], strtotime($row['date'])));

            $this->pdf->SetFont('times','',18);
            $this->pdf->text(250,160,'TTD');

            $this->pdf->SetFont('times','',18);
            $this->pdf->text(15,190,'KARYAWAN');
            
            $this->pdf->SetFont('times','',18);
            $this->pdf->text(235,190,'MANAJEMEN');
        }
        
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('spletterid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('splettername'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('date'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('description'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['spletterid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['splettername'])
->setCellValueByColumnAndRow(3, $i+1, $row1['date'])
->setCellValueByColumnAndRow(4, $i+1, $row1['description'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}