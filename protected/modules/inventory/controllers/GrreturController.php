<?php

class GrreturController extends AdminController
{
	protected $menuname = 'grretur';
	public $module = 'Inventory';
	protected $pageTitle = 'Retur Pembelian';
	public $wfname = 'appgrretur';
	protected $sqldata = "select a0.grreturid,a0.grreturno,a0.grreturdate,a0.poheaderid,a0.headernote,a0.recordstatus,a1.pono as pono,a0.statusname  
    from grretur a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqldatagrreturdetail = "select a0.grreturdetailid,a0.grreturid,a0.podetailid,a0.productid,a0.qty,a0.uomid,a0.slocid,a0.storagebinid,a0.grdetailid,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from grreturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from grretur a0 
    left join poheader a1 on a1.poheaderid = a0.poheaderid
  ";
protected $sqlcountgrreturdetail = "select count(1) 
    from grreturdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgrretur')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listgrretur').") 
				and a0.recordstatus < {$maxstat}
				and a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['grreturno'])) && (isset($_REQUEST['pono'])))
		{				
			$where .=  " 
and a0.grreturno like '%". $_REQUEST['grreturno']."%' 
and a1.pono like '%". $_REQUEST['pono']."%'"; 
		}
		if (isset($_REQUEST['grreturid']))
			{
				if (($_REQUEST['grreturid'] !== '0') && ($_REQUEST['grreturid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.grreturid in (".$_REQUEST['grreturid'].")";
					}
					else
					{
						$where .= " and a0.grreturid in (".$_REQUEST['grreturid'].")";
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
			'keyField'=>'grreturid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'grreturid','grreturno','grreturdate','poheaderid','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'grreturid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['grreturid']))
		{
			$this->sqlcountgrreturdetail .= ' where a0.grreturid = '.$_REQUEST['grreturid'];
			$this->sqldatagrreturdetail .= ' where a0.grreturid = '.$_REQUEST['grreturid'];
		}
		$countgrreturdetail = Yii::app()->db->createCommand($this->sqlcountgrreturdetail)->queryScalar();
$dataProvidergrreturdetail=new CSqlDataProvider($this->sqldatagrreturdetail,array(
					'totalItemCount'=>$countgrreturdetail,
					'keyField'=>'grreturdetailid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'grreturdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergrreturdetail'=>$dataProvidergrreturdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into grretur (recordstatus) values (".$this->findstatusbyuser('insgrretur').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'grreturid'=>$id,
			"grreturdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insgrretur")
		));
	}
    
      public function actionUpdategrreturdetail1(){
       parent::actionSave();
		$error = $this->ValidateData(array(
			array('grreturid','string','emptygrreturid'),
    ));
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        
        try{
             $sql     = 'call GenerateGRRPO(:vid, :vhid)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $_POST['poheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vhid', $_POST['grreturid'], PDO::PARAM_INT);
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
  public function actionCreategrreturdetail()
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.grreturid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'grreturdate'=>$model['grreturdate'],
          'poheaderid'=>$model['poheaderid'],
          'headernote'=>$model['headernote'],
          'pono'=>$model['pono'],

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

     public function actionGetdatagrretur(){
        $grreturid = $_POST['grreturid'];
            $sql = "select b.productid, a.productname, b.poqty-b.qtyres as qty, c.uomcode, d.sloccode, e. description, b.itemtext
            from podetail  b
            left join product a on a.productid=b.productid
            left join unitofmeasure c on c.unitofmeasureid=b.unitofmeasureid
            left join sloc d on d.slocid=b.slocid
            left join storagebin e on e.slocid=d.slocid;
             WHERE a.grreturid ='".$grreturid."'";
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
  public function actionUpdategrreturdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatagrreturdetail.' where grreturdetailid = '.$id)->queryRow();
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
			array('grreturid','string','emptygrreturid'),
    ));
        $connection = Yii::app()->db;
        //$transaction=$connection->beginTransaction();
        
        $sql = "SELECT IFNULL(COUNT(1),0) FROM grreturdetail WHERE grreturid= '".$_POST['grreturid']."'";
        $id = $connection->createCommand($sql)->queryScalar();
        if($id>0){
            $this->getMessage('success','datagenerated');
        }
    }
	
    
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('grreturid','string','emptygrreturid'),
    ));
		if ($error == false)
		{
			$id = $_POST['grreturid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
       $sql = 'call UpdateGRRetur (:grreturid,:grreturdate
,:poheaderid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':grreturid',$_POST['grreturid'],PDO::PARAM_STR);
				$command->bindvalue(':grreturdate',(($_POST['grreturdate']!=='')?$_POST['grreturdate']:null),PDO::PARAM_STR);
        $command->bindvalue(':poheaderid',(($_POST['poheaderid']!=='')?$_POST['poheaderid']:null),PDO::PARAM_STR);
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
public function actionSavegrreturdetail()
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
			$id = $_POST['grreturdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update grreturdetail 
			      set productid = :productid,qty = :qty,uomid = :uomid,slocid = :slocid,storagebinid = :storagebinid,itemnote = :itemnote 
			      where grreturdetailid = :grreturdetailid';
				}
				else
				{
					$sql = 'insert into grreturdetail (productid,qty,uomid,slocid,storagebinid,itemnote) 
			      values (:productid,:qty,:uomid,:slocid,:storagebinid,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':grreturdetailid',$_POST['grreturdetailid'],PDO::PARAM_STR);
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
				$sql = 'call Approvegrretur(:vid,:vcreatedby)';
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
				$sql = 'call Deletegrretur(:vid,:vcreatedby)';
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
				$sql = "delete from grretur where grreturid = ".$id[$i];
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
	}public function actionPurgegrreturdetail()
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
				$sql = "delete from grreturdetail where grreturdetailid = ".$id[$i];
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
		$sql = "select a.grreturid,b.companyid,a.grreturno,a.grreturdate,a.poheaderid,b.pono,c.fullname,a.recordstatus,a.headernote
      from grretur a
      left join poheader b on b.poheaderid = a.poheaderid
      left join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_REQUEST['grreturid'] !== '') {
				$sql = $sql . "where a.grreturid in (".$_REQUEST['grreturid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
     foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('grretur');
	  $this->pdf->AddPage('P');
	  // definisi font	  

    foreach($dataReader as $row)
    {
	        $this->pdf->Rect(10,60,190,25);
      $this->pdf->setFont('Arial','B',9);      
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['grreturno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grreturdate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'PO No ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['pono']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Vendor ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['fullname']);

      $sql1 = "select b.productname, a.qty, c.uomcode,d.description
        from grreturdetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.uomid
        left join sloc d on d.slocid = a.slocid
        where grreturid = ".$row['grreturid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,90,20,20,50));
	  $this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['description']));
      }
		$this->pdf->sety($this->pdf->gety()+10);
	  $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,140));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
	  $this->pdf->colheader = array('Item','Description');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L');
	  $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
      
      $this->pdf->Image('images/ttdgrretur.jpg',5,$this->pdf->gety()+25,200);
				$this->pdf->isheader=false;
				$this->pdf->AddPage('L',array(100,200));
      
      $this->pdf->AddPage('P');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('grreturid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('grreturno'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('grreturdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('pono'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['grreturid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['grreturno'])
->setCellValueByColumnAndRow(2, $i+1, $row1['grreturdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['pono'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}