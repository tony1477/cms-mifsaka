<?php

class MrogiController extends AdminController
{
	protected $menuname = 'mrogi';
	public $module = 'mro';
	protected $pageTitle = 'mrogi';
	public $wfname = 'appmrogi';
	protected $sqldata = "select a0.mrogiheaderid,a0.mrogino,a0.mrogidate,a0.giheaderid,a0.shipto,a0.headernote,a0.recordstatus,a0.statusname,a1.gino as gino,getwfstatusbywfname('appmrogi',a0.recordstatus) as statusname  
    from mrogiheader a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
  ";
protected $sqldatamrogidetail = "select a0.mrogidetailid,a0.mrogiheaderid,a0.productid,a0.qty,a0.unitofmeasureid,a0.netprice,a0.gidetailid,a0.itemnote,a1.productname as productname,a2.description as uomcode 
    from mrogidetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
  ";
  protected $sqlcount = "select count(1) 
    from mrogiheader a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
  ";
protected $sqlcountmrogidetail = "select count(1) 
    from mrogidetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['mrogino'])))
		{				
			$where .= " where a0.mrogino like '%". $_REQUEST['mrogino']."%'"; 
		}
		if (isset($_REQUEST['mrogiheaderid']))
			{
				if (($_REQUEST['mrogiheaderid'] !== '0') && ($_REQUEST['mrogiheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.mrogiheaderid in (".$_REQUEST['mrogiheaderid'].")";
					}
					else
					{
						$where .= " and a0.mrogiheaderid in (".$_REQUEST['mrogiheaderid'].")";
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
			'keyField'=>'mrogiheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'mrogiheaderid','mrogino','mrogidate','giheaderid','shipto','headernote','recordstatus','statusname'
				),
				'defaultOrder' => array( 
					'mrogiheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['mrogiheaderid']))
		{
			$this->sqlcountmrogidetail .= ' where a0.mrogiheaderid = '.$_REQUEST['mrogiheaderid'];
			$this->sqldatamrogidetail .= ' where a0.mrogiheaderid = '.$_REQUEST['mrogiheaderid'];
		}
		$countmrogidetail = Yii::app()->db->createCommand($this->sqlcountmrogidetail)->queryScalar();
$dataProvidermrogidetail=new CSqlDataProvider($this->sqldatamrogidetail,array(
					'totalItemCount'=>$countmrogidetail,
					'keyField'=>'mrogidetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'mrogidetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidermrogidetail'=>$dataProvidermrogidetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into mrogiheader (recordstatus) values (".$this->findstatusbyuser('insmrogi').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'mrogiheaderid'=>$id,
			"mrogidate" =>date("Y-m-d"),
            "recordstatus" =>$this->findstatusbyuser("insmrogi")
		));
	}
    
    public function createmrogidetail(){
        parent::actionCreate();
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        
        try{
            $sql = "CALL createmrogidetail(:vid,:giheaderid,:shipto,:headernote,:date,:vcreatedby)";
            $command = $connection->createCommand($sql);
            $command->bindvalue(':vid',$_POST['mrogiheaderid'],PDO::PARAM_STR);
            $command->bindvalue(':giheaderid',(($_POST['giheaderid']!=='')?$_POST['giheaderid']:null),PDO::PARAM_STR);
            $command->bindvalue(':shipto',(($_POST['shipto']!=='')?$_POST['shipto']:null),PDO::PARAM_STR);
            $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
            $command->bindvalue(':date',(($_POST['mrogidate']!=='')?$_POST['mrogidate']:null),PDO::PARAM_STR);
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
  public function actionCreatemrogidetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
            "netprice" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.mrogiheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'mrogiheaderid'=>$model['mrogiheaderid'],
                        'mrogidate'=>$model['mrogidate'],
                        'giheaderid'=>$model['giheaderid'],
                        'shipto'=>$model['shipto'],
                        'headernote'=>$model['headernote'],
                        'gino'=>$model['gino'],

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

  public function actionUpdatemrogidetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatamrogidetail.' where mrogidetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'mrogidetailid'=>$model['mrogidetailid'],
          'mrogiheaderid'=>$model['mrogiheaderid'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'netprice'=>$model['netprice'],
          'itemnote'=>$model['itemnote'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],

				));
				Yii::app()->end();
			}
		}
	}
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['mrogiheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatemro (:mrogiheaderid
,:mrogidate
,:giheaderid
,:shipto
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':mrogiheaderid',$_POST['mrogiheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':mrogidate',(($_POST['mrogidate']!=='')?$_POST['mrogidate']:null),PDO::PARAM_STR);
        $command->bindvalue(':giheaderid',(($_POST['giheaderid']!=='')?$_POST['giheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':shipto',(($_POST['shipto']!=='')?$_POST['shipto']:null),PDO::PARAM_STR);
        $command->bindvalue(':headernote',(($_POST['headernote']!=='')?$_POST['headernote']:null),PDO::PARAM_STR);
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
public function actionSavemrogidetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('mrogiheaderid','string','emptymrogiheaderid'),
    ));
		if ($error == false)
		{
			$id = $_POST['mrogidetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update mrogidetail 
			      set mrogiheaderid = :mrogiheaderid,productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,netprice = :netprice,itemnote = :itemnote 
			      where mrogidetailid = :mrogidetailid';
				}
				else
				{
					$sql = 'insert into mrogidetail (mrogiheaderid,productid,qty,unitofmeasureid,netprice,itemnote) 
			      values (:mrogiheaderid,:productid,:qty,:unitofmeasureid,:netprice,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':mrogidetailid',$_POST['mrogidetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':mrogiheaderid',(($_POST['mrogiheaderid']!=='')?$_POST['mrogiheaderid']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':netprice',(($_POST['netprice']!=='')?$_POST['netprice']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemnote',(($_POST['itemnote']!=='')?$_POST['itemnote']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvemrogi(:vid,:vcreatedby)';
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
				$sql = 'call Deletemrogi(:vid,:vcreatedby)';
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
				$sql = "delete from mrogiheader where mrogiheaderid = ".$id[$i];
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
	}public function actionPurgemrogidetail()
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
				$sql = "delete from mrogidetail where mrogidetailid = ".$id[$i];
				Yii::app()->db->createCommand($sql)->execute();
				}
				$transaction->commit();
				$this->getMessage('success','alreadysaved');
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
		$this->pdf->title=$this->getCatalog('mrogi');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('mrogiheaderid'),$this->getCatalog('mrogino'),$this->getCatalog('mrogida'),$this->getCatalog('giheader'),$this->getCatalog('shipto'),$this->getCatalog('headernote'),$this->getCatalog('recordstatus'),$this->getCatalog('statusname'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,15,40));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['mrogiheaderid'],$row1['mrogino'],$row1['mrogidate'],$row1['gino'],$row1['shipto'],$row1['headernote'],$row1['recordstatus'],$row1['statusname']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('mrogiheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('mrogino'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('mrogidate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('shipto'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['mrogiheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['mrogino'])
->setCellValueByColumnAndRow(2, $i+1, $row1['mrogidate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(4, $i+1, $row1['shipto'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(7, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}