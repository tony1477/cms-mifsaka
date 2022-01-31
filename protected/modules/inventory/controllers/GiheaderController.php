<?php

class GiheaderController extends AdminController
{
	protected $menuname = 'giheader';
	public $module = 'Inventory';
	protected $pageTitle = 'Surat Jalan Penitipan Barang';
	public $wfname = 'appgi';
	protected $sqldata = "select a0.giheaderid,a0.gino,a0.gidate,a0.soheaderid,a0.shipto,a0.headernote,a0.recordstatus,a1.sono as sono,a0.statusname  
    from giheader a0 
    left join soheader a1 on a1.soheaderid = a0.soheaderid
  ";
protected $sqldatagidetail = "select a0.gidetailid,a0.giheaderid,a0.productdetailid,a0.productid,a0.qty,a0.unitofmeasureid,a0.slocid,a0.sodetailid,a0.storagebinid,a0.qtyres,a0.itemnote,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a4.description as description 
    from gidetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";
  protected $sqlcount = "select count(1) 
    from giheader a0 
    left join soheader a1 on a1.soheaderid = a0.soheaderid
  ";
protected $sqlcountgidetail = "select count(1) 
    from gidetail a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.unitofmeasureid
    left join sloc a3 on a3.slocid = a0.slocid
    left join storagebin a4 on a4.storagebinid = a0.storagebinid
  ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appgi')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.recordstatus in (".getUserRecordStatus('listgi').") 
				and a0.recordstatus < {$maxstat}
				and a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['gino'])) && (isset($_REQUEST['gidate'])) && (isset($_REQUEST['sono'])))
		{				
			$where .=  " 
and a0.gino like '%". $_REQUEST['gino']."%' 
and a0.gidate like '%". $_REQUEST['gidate']."%' 
and a1.sono like '%". $_REQUEST['sono']."%'"; 
		}
		if (isset($_REQUEST['giheaderid']))
			{
				if (($_REQUEST['giheaderid'] !== '0') && ($_REQUEST['giheaderid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.giheaderid in (".$_REQUEST['giheaderid'].")";
					}
					else
					{
						$where .= " and a0.giheaderid in (".$_REQUEST['giheaderid'].")";
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
			'keyField'=>'giheaderid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'giheaderid','gino','gidate','soheaderid','shipto','headernote','recordstatus'
				),
				'defaultOrder' => array( 
					'giheaderid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['giheaderid']))
		{
			$this->sqlcountgidetail .= ' where a0.giheaderid = '.$_REQUEST['giheaderid'];
			$this->sqldatagidetail .= ' where a0.giheaderid = '.$_REQUEST['giheaderid'];
			$count = Yii::app()->db->createCommand($this->sqlcountgidetail)->queryScalar();
			$pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
		}
		else
		{
			$count = 0;
			$pagination = false;
			$this->sqldatagidetail .= " limit 0";
		}
		$countgidetail = $count;
$dataProvidergidetail=new CSqlDataProvider($this->sqldatagidetail,array(
					'totalItemCount'=>$countgidetail,
					'keyField'=>'gidetailid',
					'pagination'=>$pagination,
					'sort'=>array(
						'defaultOrder' => array( 
							'gidetailid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidergidetail'=>$dataProvidergidetail));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into giheader (recordstatus) values (".$this->findstatusbyuser('insgi').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'giheaderid'=>$id,
			"gidate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insgi")
		));
	}
  public function actionCreategidetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"qty" =>0,
      "qtyres" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.giheaderid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'gidate'=>$model['gidate'],
          'soheaderid'=>$model['soheaderid'],
          'headernote'=>$model['headernote'],
          'sono'=>$model['sono'],

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

  public function actionUpdategidetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatagidetail.' where gidetailid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'unitofmeasureid'=>$model['unitofmeasureid'],
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
	
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			    ));
		if ($error == false)
		{
			$id = $_POST['giheaderid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call UpdateGI (:gidate
,:soheaderid
,:headernote,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':giheaderid',$_POST['giheaderid'],PDO::PARAM_STR);
				$command->bindvalue(':gidate',(($_POST['gidate']!=='')?$_POST['gidate']:null),PDO::PARAM_STR);
        $command->bindvalue(':soheaderid',(($_POST['soheaderid']!=='')?$_POST['soheaderid']:null),PDO::PARAM_STR);
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
public function actionSavegidetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('unitofmeasureid','string','emptyunitofmeasureid'),
      array('slocid','string','emptyslocid'),
      array('storagebinid','string','emptystoragebinid'),
    ));
		if ($error == false)
		{
			$id = $_POST['gidetailid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update gidetail 
			      set productid = :productid,qty = :qty,unitofmeasureid = :unitofmeasureid,slocid = :slocid,storagebinid = :storagebinid,itemnote = :itemnote 
			      where gidetailid = :gidetailid';
				}
				else
				{
					$sql = 'insert into gidetail (productid,qty,unitofmeasureid,slocid,storagebinid,itemnote) 
			      values (:productid,:qty,:unitofmeasureid,:slocid,:storagebinid,:itemnote)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':gidetailid',$_POST['gidetailid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':unitofmeasureid',(($_POST['unitofmeasureid']!=='')?$_POST['unitofmeasureid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvegi(:vid,:vcreatedby)';
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
				$sql = 'call Deletegi(:vid,:vcreatedby)';
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
				$sql = "delete from giheader where giheaderid = ".$id[$i];
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
	}public function actionPurgegidetail()
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
				$sql = "delete from gidetail where gidetailid = ".$id[$i];
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
		$sql = "select b.companyid, a.gino,a.gidate,b.sono ,b.shipto,a.giheaderid,a.headernote,
						a.recordstatus,c.fullname as customer,d.fullname as sales,f.cityname,b.isdisplay,
						(
						select distinct g.mobilephone
						from addresscontact g 
						where g.addressbookid = c.addressbookid
						limit 1 
						) as hp,
							(
						select distinct h.phoneno
						from address h
						where h.addressbookid = c.addressbookid
						limit 1 
						) as phone 
						from giheader a
						left join soheader b on b.soheaderid = a.soheaderid 
						left join addressbook c on c.addressbookid = b.addressbookid
						left join employee d on d.employeeid = b.employeeid
						left join company e on e.companyid = b.companyid
						left join city f on f.cityid = e.cityid ";
		if ($_GET['giheaderid'] !== '') 
		{
				$sql = $sql . "where a.giheaderid in (".$_GET['giheaderid'].")";
		}
    $dataReader=Yii::app()->db->createCommand($sql)->queryAll();
    foreach($dataReader as $row)
    {
    $this->pdf->companyid = $row['companyid'];
    }
	  $this->pdf->title=$this->getcatalog('giheader');
	  $this->pdf->AddPage('P',array(220,140));
		$this->pdf->AddFont('tahoma','','tahoma.php');
		$this->pdf->AliasNbPages();
		$this->pdf->setFont('tahoma');
	  // definisi font
	  

    foreach($dataReader as $row)
    {
	  if($row['isdisplay']==1) $this->pdf->Image('images/DISPLAY.jpg', 0, 8, 210, 135);
      $this->pdf->setFontSize(9);      
      $this->pdf->text(10,$this->pdf->gety()+0,'No ');$this->pdf->text(25,$this->pdf->gety()+0,': '.$row['gino']);
			$this->pdf->text(10,$this->pdf->gety()+5,'Sales ');$this->pdf->text(25,$this->pdf->gety()+5,': '.$row['sales']);
      $this->pdf->text(140,$this->pdf->gety()+0,$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])));
			$this->pdf->text(10,$this->pdf->gety()+10,'No. SO ');$this->pdf->text(25,$this->pdf->gety()+10,': '.$row['sono']);
			$this->pdf->text(10,$this->pdf->gety()+15,'Dengan hormat,');
			$this->pdf->text(10,$this->pdf->gety()+20,'Bersama ini kami kirimkan barang-barang sebagai berikut:');
			$this->pdf->text(140,$this->pdf->gety()+5,'Kepada Yth, ');
      $this->pdf->text(140,$this->pdf->gety()+10,$row['customer']);
		
      $sql1 = "select b.productname, sum(ifnull(a.qty,0)) as vqty, c.uomcode,d.description,f.description as rak,itemnote
								from gidetail a
								inner join product b on b.productid = a.productid
								inner join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
								inner join sloc d on d.slocid = a.slocid
								left join storagebin f on f.storagebinid = a.storagebinid
								where giheaderid = ".$row['giheaderid']." group by b.productname,a.sodetailid order by sodetailid";
      $dataReader1=Yii::app()->db->createCommand($sql1)->queryAll();

			$this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('L','L','L','L','L','L','L');
      $this->pdf->setwidths(array(8,77,20,20,50,30));
			$this->pdf->colheader = array('No','Nama Barang','Qty','Unit','Gudang - Rak','Keterangan');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
				Yii::app()->format->formatNumber($row1['vqty']),
				$row1['uomcode'],
				$row1['description'].' - '.$row1['rak'],
				$row1['itemnote']));
      }
			$this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(20,170));
      $this->pdf->coldetailalign = array('L','L');
			$this->pdf->row(array('Ship To',$row['shipto'].' / '.$row['phone'].' / '.$row['hp']));

			$this->pdf->row(array('Note',$row['headernote']));
	  
			$this->pdf->colalign = array('C');
      $this->pdf->setwidths(array(150));
      $this->pdf->coldetailalign = array('L');
			$this->pdf->row(array(
			'Barang-barang tersebut diatas kami (saya) periksa dan terima dengan baik serta cukup.'
			));
			$this->pdf->checkNewPage(20);
			//$this->pdf->Image('images/ttdsj.jpg',5,$this->pdf->gety()+25,200);
						$this->pdf->sety($this->pdf->gety()+10);
			$this->pdf->text(15,$this->pdf->gety(),'  Dibuat oleh,');$this->pdf->text(55,$this->pdf->gety(),' Disetujui oleh,');$this->pdf->text(96,$this->pdf->gety(),'  Diketahui oleh,');$this->pdf->text(137,$this->pdf->gety(),'Dibawa oleh,');$this->pdf->text(178,$this->pdf->gety(),' Diterima oleh,');
			$this->pdf->text(15,$this->pdf->gety()+22,'........................');$this->pdf->text(55,$this->pdf->gety()+22,'.........................');$this->pdf->text(96,$this->pdf->gety()+22,'........................');$this->pdf->text(137,$this->pdf->gety()+22,'........................');$this->pdf->text(178,$this->pdf->gety()+22,'........................');
			$this->pdf->text(15,$this->pdf->gety()+25,'Admin Gudang');$this->pdf->text(55,$this->pdf->gety()+25,' Kepala Gudang');$this->pdf->text(96,$this->pdf->gety()+25,'     Distribusi');$this->pdf->text(137,$this->pdf->gety()+25,'        Supir');$this->pdf->text(178,$this->pdf->gety()+25,'Customer/Toko');

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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('giheaderid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('gino'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('gidate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('sono'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('shipto'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('headernote'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['giheaderid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['gino'])
->setCellValueByColumnAndRow(2, $i+1, $row1['gidate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['sono'])
->setCellValueByColumnAndRow(4, $i+1, $row1['shipto'])
->setCellValueByColumnAndRow(5, $i+1, $row1['headernote'])
->setCellValueByColumnAndRow(6, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}