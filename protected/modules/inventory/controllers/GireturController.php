<?php

class GireturController extends AdminController
{
	protected $menuname = 'giretur';
	public $module = 'Inventory';
	protected $pageTitle = 'Retur Penjualan';
	public $wfname = 'appgiretur';
	protected $sqldata = "select b.companyid,c.companyname,a0.gireturid,a0.gireturno,a0.giheaderid,a0.gireturdate,a0.headernote,a0.recordstatus,a1.gino as gino,a0.statusname  
    from giretur a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
	left join soheader b on b.soheaderid = a1.soheaderid
				left join company c on c.companyid = b.companyid
  ";
protected $sqldatagireturdetail = "select a0.gireturdetailid,a0.gireturid,a0.productid,a0.qty,a0.uomid,a0.gidetailid,a0.slocid,a0.storagebinid,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from gireturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from giretur a0 
    left join giheader a1 on a1.giheaderid = a0.giheaderid
	left join soheader b on b.soheaderid = a1.soheaderid
				left join company c on c.companyid = b.companyid
  ";
protected $sqlcountgireturdetail = "select count(1) 
    from gireturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgiretur')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listgiretur').")
				and a0.recordstatus < {$maxstat}
				and c.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['gireturno'])) && (isset($_REQUEST['gino'])))
		{				
			$where .=  " 
and a0.gireturno like '%". $_REQUEST['gireturno']."%' 
and a1.gino like '%". $_REQUEST['gino']."%'"; 
		}
		if (isset($_REQUEST['gireturid']))
			{
				if (($_REQUEST['gireturid'] !== '0') && ($_REQUEST['gireturid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.gireturid in (".$_REQUEST['gireturid'].")";
					}
					else
					{
						$where .= " and a0.gireturid in (".$_REQUEST['gireturid'].")";
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
			'keyField'=>'gireturid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'gireturid','gireturno','giheaderid','gireturdate','headernote','recordstatus','companyid'
				),
				'defaultOrder' => array( 
					'gireturid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['gireturid']))
		{
			$this->sqlcountgireturdetail .= ' where a0.gireturid = '.$_REQUEST['gireturid'];
			$this->sqldatagireturdetail .= ' where a0.gireturid = '.$_REQUEST['gireturid'];
		}
		$countgireturdetail = Yii::app()->db->createCommand($this->sqlcountgireturdetail)->queryScalar();
$dataProvidergireturdetail=new CSqlDataProvider($this->sqldatagireturdetail,array(
					'totalItemCount'=>$countgireturdetail,
					'keyField'=>'gireturdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'gireturdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergireturdetail'=>$dataProvidergireturdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into giretur (recordstatus) values (".$this->findstatusbyuser('insgiretur').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'gireturid'=>$id,
			"gireturdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insgiretur")
		));
	}
     public function actionUpdategireturdetail1(){
       parent::actionSave();
		$error = $this->ValidateData(array(
			array('gireturid','string','emptygireturid'),
    ));
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        
        try{
             $sql     = 'call GenerateGIRGI (:vid, :vhid)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $_POST['giheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vhid', $_POST['gireturid'], PDO::PARAM_INT);
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
  public function actionCreategireturdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.gireturid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
        'gireturdate'=>$model['gireturdate'],
        'giheaderid'=>$model['giheaderid'],
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

 public function actionGetdatagiretur(){
        $gireturid = $_POST['gireturid'];
            $sql = "select b.productid, a.productname, b.poqty-b.qtyres as qty, c.uomcode, d.sloccode, e. description, b.itemtext
            from podetail  b
            left join product a on a.productid=b.productid
            left join unitofmeasure c on c.unitofmeasureid=b.unitofmeasureid
            left join sloc d on d.slocid=b.slocid
            left join storagebin e on e.slocid=d.slocid;
             WHERE a.gireturid ='".$gireturid."'";
        $model = Yii::app()->db->createCommand($sql)->queryRow();
        echo CJSON::encode(array(
                'status'=>'success',
               'productid'=>$model['productid'],
            'qty'=>$model['qty'],      
          'itemtext'=>$model['itemtext'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],
                ));
  }    
  public function actionUpdategireturdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatagireturdetail.' where gireturdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'itemnote'=>$model['itemnote'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],

				));
				Yii::app()->end();
			}
		}
	}
    
    public function actionCheckgrretur(){
        
		$error = $this->ValidateData(array(
			array('gireturid','string','emptygireturid'),
    ));
        $connection = Yii::app()->db;
        //$transaction=$connection->beginTransaction();
        
        $sql = "SELECT IFNULL(COUNT(1),0) FROM gireturdetail WHERE gireturid= '".$_POST['gireturid']."'";
        $id = $connection->createCommand($sql)->queryScalar();
        if($id>0){
            $this->getMessage('success','datagenerated');
        }
    }
	
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
        array('gireturid','string','emptygireturid'),    
			    ));
		if ($error == false)
		{
			$id = $_POST['gireturid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
   $sql = 'call UpdateGiRetur (:gireturid,:gireturdate,:giheaderid
,:headernote,:vcreatedby)';
$command = $connection->createCommand($sql);
$command->bindvalue(':gireturid',$_POST['gireturid'],PDO::PARAM_STR);
$command->bindvalue(':gireturdate',(($_POST['gireturdate']!=='')?$_POST['gireturdate']:null),PDO::PARAM_STR);
$command->bindvalue(':giheaderid',(($_POST['giheaderid']!=='')?$_POST['giheaderid']:null),PDO::PARAM_STR);
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
public function actionSavegireturdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['gireturdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update gireturdetail 
			      set productid = :productid,qty = :qty,uomid = :uomid,slocid = :slocid,storagebinid = :storagebinid,itemnote = :itemnote 
			      where gireturdetailid = :gireturdetailid';
				}
				else
				{
					$sql = 'insert into gireturdetail (productid,qty,uomid,slocid,storagebinid,itemnote) 
			      values (:productid,:qty,:uomid,:slocid,:storagebinid,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':gireturdetailid',$_POST['gireturdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvegiretur(:vid,:vcreatedby)';
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
				$sql = 'call Deletegiretur(:vid,:vcreatedby)';
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
				$sql = "delete from giretur where gireturid = ".$id[$i];
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
	}public function actionPurgegireturdetail()
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
				$sql = "delete from gireturdetail where gireturdetailid = ".$id[$i];
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
		$sql = "select c.companyid, a.gireturno,a.gireturdate,b.gino ,c.shipto,a.gireturid,a.headernote,
						a.recordstatus
						from giretur a
						left join giheader b on b.giheaderid = a.giheaderid 
						left join soheader c on c.soheaderid = b.soheaderid ";
		if ($_REQUEST['gireturid'] !== '') 
		{
				$sql = $sql . "where a.gireturid in (".$_REQUEST['gireturid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('giretur');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AliasNBPages();
	  // definisi font
		
    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',9);      
      $this->pdf->text(15,$this->pdf->gety(),'No ');$this->pdf->text(50,$this->pdf->gety(),': '.$row['gireturno']);
      $this->pdf->text(15,$this->pdf->gety()+5,'Date ');$this->pdf->text(50,$this->pdf->gety()+5,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gireturdate'])));
      $this->pdf->text(15,$this->pdf->gety()+10,'SJ No ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['gino']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,d.description,
								f.description as rak
								from gireturdetail a
								inner join product b on b.productid = a.productid
								inner join unitofmeasure c on c.unitofmeasureid = a.uomid
								inner join sloc d on d.slocid = a.slocid
								left join storagebin f on f.storagebinid = a.storagebinid
								left join gidetail g on g.gidetailid = a.gidetailid
								left join sodetail h on h.sodetailid = g.sodetailid
								where gireturid = ".$row['gireturid']." group by b.productname order by h.sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->setwidths(array(10,95,20,15,50,30));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','R','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['description'].' - '.$row1['rak']));
      }
				$this->pdf->sety($this->pdf->gety());
				$this->pdf->colalign = array('C','C');
				$this->pdf->setwidths(array(50,140));
				$this->pdf->coldetailalign = array('L','L');
				$this->pdf->row(array('Note',$row['headernote']));
		
			$this->pdf->checkNewPage(35);
			//$this->pdf->Image('images/ttdgir.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'');$this->pdf->text(20,$this->pdf->gety(),' Dibuat Oleh,');$this->pdf->text(70,$this->pdf->gety(),'  Dibawa Oleh,');$this->pdf->text(120,$this->pdf->gety(),'Diserahkan,');$this->pdf->text(170,$this->pdf->gety(),'Diterima Oleh,');
			$this->pdf->text(10,$this->pdf->gety()+22,'');$this->pdf->text(20,$this->pdf->gety()+20,'.........................');$this->pdf->text(70,$this->pdf->gety()+20,'............................');$this->pdf->text(120,$this->pdf->gety()+20,'........................');$this->pdf->text(170,$this->pdf->gety()+20,'.............................');
			$this->pdf->text(10,$this->pdf->gety()+25,'');$this->pdf->text(20,$this->pdf->gety()+23,'  Adm Gudang');$this->pdf->text(70,$this->pdf->gety()+23,' Ekspedisi/ Supir');$this->pdf->text(120,$this->pdf->gety()+23,'    Customer');$this->pdf->text(170,$this->pdf->gety()+23,' Kepala Gudang');

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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('gireturid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('gireturno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('gireturdate'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['gireturid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['gireturno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(3, $i+1, $row1['gireturdate'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}