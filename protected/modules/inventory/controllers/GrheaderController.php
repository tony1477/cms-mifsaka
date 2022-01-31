<?php

class GrheaderController extends AdminController
{
	protected $menuname = 'grheader';
	public $module = 'Inventory';
	protected $pageTitle = 'Surat Tanda Terima Barang';
	public $wfname = 'appgr';
	protected $sqldata = "select a0.grheaderid,a0.grdate,a0.grno,a0.poheaderid,a0.headernote,a0.recordstatus,a0.statusname  
    from grheader a0 
	join poheader j on j.poheaderid = a0.poheaderid
  ";
protected $sqldatagrdetail = "select a0.grdetailid,a0.grheaderid,a0.productid,a0.qty,a0.unitofmeasureid,a0.slocid,a0.podetailid,a0.invqty,a0.storagebinid,a0.itemtext,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from grdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from grheader a0 
	join poheader j on j.poheaderid = a0.poheaderid
  ";
protected $sqlcountgrdetail = "select count(1) 
    from grdetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgr')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listgr').")
				and a0.recordstatus < {$maxstat}
				and j.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['grno'])) && (isset($_REQUEST['pono'])) && (isset($_REQUEST['headernote'])))
		{				
			$where .=  " 
and a0.grno like '%". $_REQUEST['grno']."%' 
and j.pono like '%". $_REQUEST['pono']."%' 
and a0.headernote like '%". $_REQUEST['headernote']."%'"; 
		}
		if (isset($_REQUEST['grheaderid']))
			{
				if (($_REQUEST['grheaderid'] !== '0') && ($_REQUEST['grheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.grheaderid in (".$_REQUEST['grheaderid'].")";
					}
					else
					{
						$where .= " and a0.grheaderid in (".$_REQUEST['grheaderid'].")";
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
			'keyField'=>'grheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'grheaderid','grdate','grno','poheaderid','headernote','statusname'
				),
				'defaultOrder' => array( 
					'grheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['grheaderid']))
		{
			$this->sqlcountgrdetail .= ' where a0.grheaderid = '.$_REQUEST['grheaderid'];
			$this->sqldatagrdetail .= ' where a0.grheaderid = '.$_REQUEST['grheaderid'];
			$count = Yii::app()->db->createCommand($this->sqlcountgrdetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatagrdetail .= " limit 0";
		}
		$countgrdetail = $count;
$dataProvidergrdetail=new CSqlDataProvider($this->sqldatagrdetail,array(
					'totalItemCount'=>$countgrdetail,
					'keyField'=>'grdetailid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'grdetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergrdetail'=>$dataProvidergrdetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into grheader (recordstatus) values (".$this->findstatusbyuser('insgr').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'grheaderid'=>$id,
			"grdate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insgr")
		));
	}
    public function actionUpdategrdetail1(){
       parent::actionSave();
		$error = $this->ValidateData(array(
			array('grheaderid','string','emptygrheaderid'),
    ));
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        
        try{
             $sql     = 'call GenerateGRPO(:vid, :vhid)';
        $command = $connection->createCommand($sql);
        $command->bindvalue(':vid', $_POST['poheaderid'], PDO::PARAM_INT);
        $command->bindvalue(':vhid', $_POST['grheaderid'], PDO::PARAM_INT);
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
    
  public function actionCreategrdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "invqty" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.grheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'grdate'=>$model['grdate'],
          'headernote'=>$model['headernote'],

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
    
    public function actionGetdatagrheader(){
        $giheaderid = $_POST['grheaderid'];
            $sql = "select b.productid, a.productname, b.poqty-b.qtyres as qty, c.uomcode, d.sloccode, e. description, b.itemtext
            from podetail  b
            left join product a on a.productid=b.productid
            left join unitofmeasure c on c.unitofmeasureid=b.unitofmeasureid
            left join sloc d on d.slocid=b.slocid
            left join storagebin e on e.slocid=d.slocid;
             WHERE a.grheaderid ='".$giheaderid."'";
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

  public function actionUpdategrdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatagrdetail.' where grdetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
          'slocid'=>$model['slocid'],
          'storagebinid'=>$model['storagebinid'],
          'itemtext'=>$model['itemtext'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'description'=>$model['description'],

				));
				Yii::app()->end();
			}
		}
	}
    
     public function actionCheckgrheadaer(){
        
		$error = $this->ValidateData(array(
			array('grheaderid','string','emptygrheaderid'),
    ));
        $connection = Yii::app()->db;
        //$transaction=$connection->beginTransaction();
        
        $sql = "SELECT IFNULL(COUNT(1),0) FROM grdetail WHERE grheaderid= '".$_POST['grheaderid']."'";
        $id = $connection->createCommand($sql)->queryScalar();
        if($id>0){
            $this->getMessage('success','datagenerated');
        }
    }
	
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			
    ));
		if ($error == false)
		{
			$id = $_POST['grheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
                $sql = 'call UpdateGrHeader (:grheaderid,:grdate
,:poheaderid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':grheaderid',$_POST['grheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':grdate',(($_POST['grdate']!=='')?$_POST['grdate']:null),PDO::PARAM_STR);
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
public function actionSavegrdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('grheaderid','string','emptygrheaderid'),
     
    ));
		if ($error == false)
		{
			$id = $_POST['grdetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update grdetail 
			      set grheaderid = :grheaderid,productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,slocid = :slocid,storagebinid = :storagebinid,itemtext = :itemtext 
			      where grdetailid = :grdetailid';
				}
				else
				{
					$sql = 'insert into grdetail (grheaderid,productid,qty,unitofmeasureid,slocid,storagebinid,itemtext) 
			      values (:grheaderid,:productid,:qty,:unitofmeasureid,:slocid,:storagebinid,:itemtext)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':grdetailid',$_POST['grdetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':grheaderid',(($_POST['grheaderid']!=='')?$_POST['grheaderid']:null),PDO::PARAM_STR);
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':storagebinid',(($_POST['storagebinid']!=='')?$_POST['storagebinid']:null),PDO::PARAM_STR);
        $command->bindvalue(':itemtext',(($_POST['itemtext']!=='')?$_POST['itemtext']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvegr(:vid,:vcreatedby)';
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
				$sql = 'call Deletegr(:vid,:vcreatedby)';
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
				$sql = "delete from grheader where grheaderid = ".$id[$i];
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
	}public function actionPurgegrdetail()
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
				$sql = "delete from grdetail where grdetailid = ".$id[$i];
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
		$sql = "select b.companyid,a.grno,a.grdate,a.grheaderid,b.pono,c.fullname,a.recordstatus,a.headernote
						from grheader a
						left join poheader b on b.poheaderid = a.poheaderid
						left join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_GET['grheaderid'] !== '') 
		{
				$sql = $sql . "where a.grheaderid in (".$_GET['grheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('grheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->setFont('Arial'); 
		$this->pdf->AliasNbPages();
	  // definisi font	  

    foreach($dataReader as $row)
    {
      $this->pdf->setFontSize(8);      
      $this->pdf->text(10,$this->pdf->gety()+2,'No ');$this->pdf->text(30,$this->pdf->gety()+2,': '.$row['grno']);
      $this->pdf->text(10,$this->pdf->gety()+6,'Date ');$this->pdf->text(30,$this->pdf->gety()+6,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['grdate'])));
      $this->pdf->text(130,$this->pdf->gety()+2,'PO No ');$this->pdf->text(165,$this->pdf->gety()+2,': '.$row['pono']);
      $this->pdf->text(130,$this->pdf->gety()+6,'Vendor ');$this->pdf->text(165,$this->pdf->gety()+6,': '.$row['fullname']);
      $sql1 = "select b.productname, a.qty, c.uomcode,concat(d.sloccode,'-',d.description) as description,
							e.description as rak
							from grdetail a
							left join product b on b.productid = a.productid
							left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
							left join sloc d on d.slocid = a.slocid
							left join storagebin e on e.storagebinid = a.storagebinid
							where grheaderid = ".$row['grheaderid'];
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,20,60));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->format->formatNumber($row1['qty']),
            $row1['uomcode'],
            $row1['description']. ' - '. $row1['rak']));
      }
			$this->pdf->sety($this->pdf->gety());
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(20,170));
			$this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Note:',$row['headernote']));
      $this->pdf->checkNewPage(40);
      //$this->pdf->Image('images/ttdttb.jpg',5,$this->pdf->gety()+5,200);
			$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(10,$this->pdf->gety(),'Penerima');$this->pdf->text(50,$this->pdf->gety(),'Mengetahui');$this->pdf->text(90,$this->pdf->gety(),'Supplier / Perwakilan');
			$this->pdf->text(10,$this->pdf->gety()+15,'........................');$this->pdf->text(50,$this->pdf->gety()+15,'........................');$this->pdf->text(90,$this->pdf->gety()+15,'........................');
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('grheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('grdate'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('grno'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('poheaderid'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['grheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['grdate'])
->setCellValueByColumnAndRow(2, $i+1, $row1['grno'])
->setCellValueByColumnAndRow(3, $i+1, $row1['poheaderid'])
->setCellValueByColumnAndRow(4, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}