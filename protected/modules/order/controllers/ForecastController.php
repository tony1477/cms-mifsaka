<?php

class ForecastController extends AdminController
{
	protected $menuname = 'forecast';
	public $module = 'Order';
	protected $pageTitle = 'Forecast';
	public $wfname = '';
	protected $sqldata = "select a0.forecastid,a0.bulan,a0.tahun,a0.productid,a0.qty,a0.uomid,a0.slocid,a1.productname as productname,a2.uomcode as uomcode,a3.sloccode as sloccode,a0.bomid,a4.bomversion
    from forecast a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid=a0.bomid
		left join plant a5 on a5.plantid = a3.plantid
		left join company a6 on a6.companyid = a5.companyid
  ";
  protected $sqlcount = "select count(1) 
    from forecast a0 
    left join product a1 on a1.productid = a0.productid
    left join unitofmeasure a2 on a2.unitofmeasureid = a0.uomid
    left join sloc a3 on a3.slocid = a0.slocid
    left join billofmaterial a4 on a4.bomid=a0.bomid
		left join plant a5 on a5.plantid = a3.plantid
		left join company a6 on a6.companyid = a5.companyid
  ";
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a4.recordstatus = 1 ";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['sloccode']))
				&& (isset($_REQUEST['bulan'])) && (isset($_REQUEST['tahun'])) && (isset($_REQUEST['companyname'])))
		{
			$where .= " and a1.productname like '%". $_REQUEST['productname']."%' 
									and a2.uomcode like '%". $_REQUEST['uomcode']."%' 
									and a3.sloccode like '%". $_REQUEST['sloccode']."%'
									and a0.tahun like '%". $_REQUEST['tahun']."%'
									and a6.companyname like '%". $_REQUEST['companyname']."%'
			";
			if ($_REQUEST['bulan'] != '')
			{
				$where .= " and a0.bulan = '". $_REQUEST['bulan']."'
				";
			}
		}
		if (isset($_REQUEST['forecastid']))
			{
				if (($_REQUEST['forecastid'] !== '0') && ($_REQUEST['forecastid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.forecastid in (".$_REQUEST['forecastid'].")";
					}
					else
					{
						$where .= " and a0.forecastid in (".$_REQUEST['forecastid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionUploaddata()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/uploads/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		}
		$this->storeFolder = dirname('__FILES__').'/uploads/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	public function actionRunning()
	{
		$s = $_POST['id'];
		Yii::import('ext.phpexcel.XPHPExcel');
		Yii::import('ext.phpexcel.vendor.PHPExcel'); 
		$phpExcel = XPHPExcel::createPHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$phpExcel = $objReader->load(dirname('__FILES__').'/uploads/'.$s);
		$connection = Yii::app()->db;
		try
		{
			$sheet = $phpExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$transaction = $connection->beginTransaction();
			for ($i = 6;$i <= $highestRow; $i++)
			{	
				$companyid = Yii::app()->db->createCommand("select companyid from company where lower(companycode) = lower('".$sheet->getCell('A'.$i)->getValue()."')")->queryScalar();
				if ($companyid == null)
				{
					throw new Exception('emptycompany');
				}
				$bulan = $sheet->getCell('B'.$i)->getValue();
				$tahun = $sheet->getCell('C'.$i)->getValue();
				$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$sheet->getCell('E'.$i)->getValue()."')")->queryScalar();
				if ($productid != null)
				{
					//throw new Exception('emptyproduct');
					$bomid  = Yii::app()->db->createCommand("select bomid from billofmaterial where recordstatus = 1 and productid = ".$productid)->queryScalar();				
					if ($bomid != null)
					{
						$qty = $sheet->getCell('H'.$i)->getValue();
						$uomid  = Yii::app()->db->createCommand("select uomid from billofmaterial where recordstatus = 1 and productid = ".$productid)->queryScalar();				
						$slocid = Yii::app()->db->createCommand("select a.slocid 
							from productplant a 
							join sloc b on b.slocid = a.slocid 
							join plant c on c.plantid = b.plantid 
							where a.issource = 1 
							and c.companyid = ".$companyid."
							and a.productid = ".$productid)->queryScalar();
						$id = Yii::app()->db->createCommand("select forecastid from forecast where bulan = ".$bulan." and productid = ".$productid." and tahun = ".$tahun." and slocid = ".$slocid)->queryScalar();
						$connection = Yii::app()->db;
						if ($id == null)
						{
							$sql = 'insert into forecast (bulan,tahun,productid,qty,uomid,slocid,bomid) 
								values (:bulan,:tahun,:productid,:qty,:uomid,:slocid,:bomid)';
							$command = $connection->createCommand($sql);
							$command->bindvalue(':bulan',$bulan,PDO::PARAM_STR);
							$command->bindvalue(':tahun',$tahun,PDO::PARAM_STR);
							$command->bindvalue(':productid',$productid,PDO::PARAM_STR);
							$command->bindvalue(':uomid',$uomid,PDO::PARAM_STR);
							$command->bindvalue(':bomid',$bomid,PDO::PARAM_STR);
							$command->bindvalue(':slocid',$slocid,PDO::PARAM_STR);
						}
						else
						{
							$sql = "update forecast set qty = :qty where forecastid = ".$id;	
							$command = $connection->createCommand($sql);
						}
						$command->bindvalue(':qty',$qty,PDO::PARAM_STR);
						$command->execute();
					}
				}		
				else
				{
					var_dump($sheet->getCell('E'.$i)->getValue());
				}	
				//$this->getMessage('success','alreadysaved');				
			}
			$transaction->commit();
		}	
		catch (Exception $e)
		{
			$transaction->rollBack();
			$this->getMessage('error',$e->getMessage());
		}		
	}
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'forecastid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'forecastid','bulan','tahun','productid','qty','uomid','slocid'
				),
				'defaultOrder' => array( 
					'forecastid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function RecursiveFG($companyid,$bulan,$tahun,$forecastid,$forecastdetailid,$productid,$uomid,$qty)
	{
		$dependency = new CDbCacheDependency('select max(bomid) from billofmaterial');
		$sql = "select ifnull(count(1),0)
			from billofmaterial a 
			join productplant b on b.productid = a.productid 
			join product c on c.productid = a.productid 
			join sloc d on d.slocid = b.slocid 
			join plant e on e.plantid = d.plantid
			join company f on f.companyid = e.companyid 
			where a.productid = ".$productid." and b.issource = 1 and a.recordstatus = 1 and f.companyid = ".$companyid." limit 1";
		$k = Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryScalar();
		if ($k > 0) 
		{
			$sql = "select a.bomid 
				from billofmaterial a 
				join productplant b on b.productid = a.productid and b.issource = 1
				join product c on c.productid = a.productid 
				join sloc d on d.slocid = b.slocid 
				join plant e on e.plantid = d.plantid
				join company f on f.companyid = e.companyid 
				where a.productid = ".$productid."  and a.recordstatus = 1 and f.companyid = ".$companyid." limit 1";
			$k = Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryScalar();
			
			$sql = "insert into forecastdetail (companyid,forecastid,bulan,tahun,productid,qty,uomid,slocid,iscreate,bomid,turunanid)
					select ".$companyid.",".$forecastid.",".$bulan.",".$tahun.",d.productid,d.qty * ".$qty.",d.uomid,(
select zb.slocid
from productplant zb 
join sloc zc on zc.slocid = zb.slocid 
join plant zd on zd.plantid = zc.plantid
join company ze on ze.companyid = zd.companyid
where zb.productid = d.productid and zb.issource = 1 and zd.companyid = ".$companyid." and zb.unitofissue = d.uomid
limit 1
),
						case when d.productbomid is null then 0 else 1 end,d.productbomid,".$forecastdetailid."
from billofmaterial a 				
join bomdetail d on d.bomid = a.bomid and d.productbomid is not null  
join product e on e.productid = d.productid 
where a.bomid = ".$k."
and a.productid = ".$productid." 
and e.isstock = 1
order by d.bomdetailid";
			Yii::app()->db->createCommand($sql)->execute();
			
			$sql = "insert into forecastbb (companyid,forecastid,bulan,tahun,productid,qty,uomid,slocid,iscreate,bomid,turunanid)
					select ".$companyid.",".$forecastid.",".$bulan.",".$tahun.",d.productid,d.qty * ".$qty.",d.uomid,(
select zb.slocid
from productplant zb 
join sloc zc on zc.slocid = zb.slocid 
join plant zd on zd.plantid = zc.plantid
join company ze on ze.companyid = zd.companyid
where zb.productid = d.productid and zb.issource = 1 and zd.companyid = ".$companyid." and zb.unitofissue = d.uomid
and e.isstock = 1
limit 1
),
						0,null,".$forecastdetailid."
from billofmaterial a 				
join bomdetail d on d.bomid = a.bomid and d.productbomid is null
join product e on e.productid = d.productid 
where a.bomid = ".$k."
and a.productid = ".$productid." 
and e.isstock = 1
order by d.bomdetailid";
			Yii::app()->db->createCommand($sql)->execute();
		}
		$sql = "select f.companyid,a.forecastid, a.forecastdetailid,b.productid,c.unitofmeasureid,a.qty,a.slocid,a.turunanid
				from forecastdetail a
				join product b on b.productid = a.productid
				join unitofmeasure c on c.unitofmeasureid = a.uomid
				join sloc d on d.slocid = a.slocid 
				join plant e on e.plantid = d.plantid
				join company f on f.companyid = e.companyid
				where f.companyname like '%".$_REQUEST['companyname']."%' 
					and a.bulan = ".$_REQUEST['bulan']." 
					and b.isstock = 1
					and a.tahun = ".$_REQUEST['tahun']." and a.iscreate = 1 
					and a.turunanid = ".$forecastdetailid;
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($dataReader as $data)
		{
			$sql = "update forecastdetail
				set iscreate = 0
				where forecastdetailid = ".$data['forecastdetailid'];
			Yii::app()->db->createCommand($sql)->execute();
			$this->RecursiveFG($data['companyid'],$_REQUEST['bulan'],$_REQUEST['tahun'],$data['forecastid'],$data['forecastdetailid'],
				$data['productid'],$data['unitofmeasureid'],$data['qty']);
		}
	}
	public function actionGeneratefg()
	{
		parent::actionCreate();
		$sql = "select companyid from company where companyname like '%".$_REQUEST['companyname']."%'";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
		$sql = "delete from forecastdetail where companyid = ".$id." and bulan = ".$_REQUEST['bulan']." and tahun = ".$_REQUEST['tahun'];
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "delete from forecastbb where companyid = ".$id." and bulan = ".$_REQUEST['bulan']." and tahun = ".$_REQUEST['tahun'];
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "call generatefcfg(".$id.",".$_REQUEST['bulan'].",".$_REQUEST['tahun'].")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select distinct f.companyid,a.forecastid, a.forecastdetailid,b.productid,c.unitofmeasureid,a.qty,a.slocid
			from forecastdetail a
			join product b on b.productid = a.productid
			join unitofmeasure c on c.unitofmeasureid = a.uomid
			join sloc d on d.slocid = a.slocid 
			join plant e on e.plantid = d.plantid
			join company f on f.companyid = e.companyid
			where f.companyname like '%".$_REQUEST['companyname']."%' and a.bulan = ".$_REQUEST['bulan']." 
				and a.tahun = ".$_REQUEST['tahun']." and a.iscreate = 1";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($dataReader as $data)
		{
			$sql = "update forecastdetail
				set iscreate = 0
				where forecastdetailid = ".$data['forecastdetailid'];
			Yii::app()->db->createCommand($sql)->execute();
			$this->RecursiveFG($data['companyid'],$_REQUEST['bulan'],$_REQUEST['tahun'],$data['forecastid'],
				$data['forecastdetailid'],
				$data['productid'],$data['unitofmeasureid'],$data['qty']);
		}
		$this->getMessage('success','alreadysaved');
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.forecastid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'forecastid'=>$model['forecastid'],
          'bulan'=>$model['bulan'],
          'tahun'=>$model['tahun'],
          'productid'=>$model['productid'],
          'qty'=>$model['qty'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],
          'bomid'=>$model['bomid'],
          'bomversion'=>$model['bomversion'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
    ));
		if ($error == false)
		{
			$id = $_POST['forecastid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update forecast 
			      set bulan = :bulan,tahun = :tahun,productid = :productid,qty = :qty,uomid = :uomid,slocid = :slocid,bomid=:bomid
			      where forecastid = :forecastid';
				}
				else
				{
					$sql = 'insert into forecast (bulan,tahun,productid,qty,uomid,slocid,bomid) 
			      values (:bulan,:tahun,:productid,:qty,:uomid,:slocid,:bomid)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':forecastid',$_POST['forecastid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':bulan',(($_POST['bulan']!=='')?$_POST['bulan']:null),PDO::PARAM_STR);
        $command->bindvalue(':tahun',(($_POST['tahun']!=='')?$_POST['tahun']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':qty',(($_POST['qty']!=='')?$_POST['qty']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':bomid',(($_POST['bomid']!=='')?$_POST['bomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
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
				$sql = "delete from forecast where forecastid = ".$id[$i];
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
		$sql = "select a.forecastid,a.bulan,a.tahun,e.productname,a.qty,f.uomcode,b.sloccode,
		(
		select sum(za.qty)
		from productstock za
		where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid
		
		) as stockqty
			from forecast a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			order by d.companyid,a.bulan,a.tahun,b.slocid,e.productid
			";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		//masukkan judul
		$this->pdf->title=$this->getCatalog('forecast');
		$this->pdf->AddPage('P');
		$this->pdf->setFontSize(8);
		$this->pdf->text(10,$this->pdf->gety()+0,'Daftar FG');
		$this->pdf->sety($this->pdf->gety()+5);
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('bulan'),$this->getCatalog('tahun'),$this->getCatalog('product'),$this->getCatalog('qty'),$this->getCatalog('stock'),$this->getCatalog('uom'),$this->getCatalog('sloc'));
		$this->pdf->setwidths(array(15,15,80,20,20,20,20));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('C','C','L','R','R','C','L');
		$total = 0;
		foreach($dataReader as $row1)
		{
			$this->pdf->setFontSize(8);
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['bulan'],$row1['tahun'],$row1['productname'],
			Yii::app()->format->formatNumber($row1['qty']),Yii::app()->format->formatNumber($row1['stockqty']),
			$row1['uomcode'],$row1['sloccode']));
			$total += $row1['qty'];
		}
		$this->pdf->row(array('','','Total',
			Yii::app()->format->formatNumber($total)));
		$this->pdf->sety($this->pdf->gety()+7);	
		
		$this->pdf->text(10,$this->pdf->gety()+0,'Product WIP (Work In Process)');
		$sql = "select e.productname,sum(a.qty) as qty,(
		select sum(za.qty)
		from productstock za
		where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid
		
		) as stockqty,f.uomcode,b.sloccode,g.bomversion
			from forecastdetail a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			left join billofmaterial g on g.bomid = a.bomid
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			group by e.productname,f.uomcode,b.sloccode
			";
		$this->pdf->sety($this->pdf->gety()+5);
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('product'),$this->getCatalog('qty'),$this->getCatalog('stock'),$this->getCatalog('uom'),
			$this->getCatalog('sloc'),$this->getCatalog('bomversion'));
		$this->pdf->setwidths(array(70,25,20,20,30,30));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','R','R','C','L','L');
		$total = 0;
		foreach($dataReader as $row1)
		{
			$this->pdf->setFontSize(8);
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productname'],
			Yii::app()->format->formatNumber($row1['qty']),Yii::app()->format->formatNumber($row1['stockqty']),$row1['uomcode'],$row1['sloccode'],$row1['bomversion']));
			$total += $row1['qty'];
		}
		$this->pdf->row(array('Total',
			Yii::app()->format->formatNumber($total)));
			
		$this->pdf->sety($this->pdf->gety()+7);
		$this->pdf->text(10,$this->pdf->gety()+0,'Kebutuhan Bahan Baku');
		$sql = "select e.productname,sum(a.qty) as qty,(
		select sum(za.qty)
		from productstock za
		where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid
		
		) as stockqty,f.uomcode,b.sloccode,g.bomversion
			from forecastbb a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			left join billofmaterial g on g.bomid = a.bomid
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			group by e.productname,f.uomcode,b.sloccode
			";
		$this->pdf->sety($this->pdf->gety()+5);
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		$this->pdf->colalign = array('C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('product'),$this->getCatalog('qty'),$this->getCatalog('stock'),$this->getCatalog('uom'),
			$this->getCatalog('sloc'),$this->getCatalog('bomversion'));
		$this->pdf->setwidths(array(70,25,20,20,30,30));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','R','R','C','L','L');
		$total = 0;
		foreach($dataReader as $row1)
		{
			$this->pdf->setFontSize(8);
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productname'],
			Yii::app()->format->formatNumber($row1['qty']),Yii::app()->format->formatNumber($row1['stockqty']),$row1['uomcode'],$row1['sloccode'],$row1['bomversion']));
			$total += $row1['qty'];
		}
		$this->pdf->row(array('Total',
			Yii::app()->format->formatNumber($total)));
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		$this->menuname = 'forecast';
		parent::actionDownXLS();
		$sql = "select a.forecastid,a.bulan,a.tahun,e.productname,a.qty,f.uomcode,b.sloccode,(select sum(za.qty) from productstock za	where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid) as stockqty
			from forecast a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			order by d.companyid,a.bulan,a.tahun,b.slocid,e.productid
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		
		$line = 2;
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Daftar FG');
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Bulan')
						->setCellValueByColumnAndRow(1,$line,'Tahun')
						->setCellValueByColumnAndRow(2,$line,'Material / Service')
						->setCellValueByColumnAndRow(3,$line,'Qty')
						->setCellValueByColumnAndRow(4,$line,'Stock')
						->setCellValueByColumnAndRow(5,$line,'Satuan')
						->setCellValueByColumnAndRow(6,$line,'Gudang');
		$line++;
        
		$total = 0;
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$line,$row1['bulan'])
				->setCellValueByColumnAndRow(1,$line,$row1['tahun'])
				->setCellValueByColumnAndRow(2,$line,$row1['productname'])
				->setCellValueByColumnAndRow(3,$line,$row1['qty'])
				->setCellValueByColumnAndRow(4,$line,$row1['stockqty'])
				->setCellValueByColumnAndRow(5,$line,$row1['uomcode'])
				->setCellValueByColumnAndRow(6,$line,$row1['sloccode']);
			$line++;
			$total += $row1['qty'];
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(2,$line,'Total')
			->setCellValueByColumnAndRow(3,$line,$total);
		$line++;
		$total=0;
		$sql = "select e.productname,sum(a.qty) as qty,(select sum(za.qty) from productstock za where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid) as stockqty,f.uomcode,b.sloccode,g.bomversion
			from forecastdetail a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			left join billofmaterial g on g.bomid = a.bomid
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			group by e.productname,f.uomcode,b.sloccode
		";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		$line++;
        
		$this->phpExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0,$line,'Product WIP (Work In Progress)');
		$line++;
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(2,$line,'Material / Service')
			->setCellValueByColumnAndRow(3,$line,'Qty')
			->setCellValueByColumnAndRow(4,$line,'Stock')
			->setCellValueByColumnAndRow(5,$line,'Satuan')
			->setCellValueByColumnAndRow(6,$line,'Gudang')
			->setCellValueByColumnAndRow(7,$line,'Versi BOM');
		$line++;
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		 $this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(2,$line,$row1['productname'])
				->setCellValueByColumnAndRow(3,$line,$row1['qty'])
				->setCellValueByColumnAndRow(4,$line,$row1['stockqty'])
				->setCellValueByColumnAndRow(5,$line,$row1['uomcode'])
				->setCellValueByColumnAndRow(6,$line,$row1['sloccode'])
				->setCellValueByColumnAndRow(7,$line,$row1['bomversion']);
			$line++;
			$total += $row1['qty'];
		}
		$this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(2,$line,'Total')
			->setCellValueByColumnAndRow(3,$line,$total);
		$line++;
        
		$total=0;
		$sql = "select e.productname,sum(a.qty) as qty,(
		select sum(za.qty)
		from productstock za
		where za.productid = a.productid and za.unitofmeasureid = a.uomid and za.slocid = b.slocid
		
		) as stockqty,f.uomcode,b.sloccode,g.bomversion
			from forecastbb a 
			join sloc b on b.slocid = a.slocid 
			join plant c on c.plantid = b.plantid 
			join company d on d.companyid = c.companyid 
			join product e on e.productid = a.productid 
			join unitofmeasure f on f.unitofmeasureid = a.uomid 
			left join billofmaterial g on g.bomid = a.bomid
			where bulan = ".$_GET['bulan']." and tahun = ".$_GET['tahun']." and d.companyname like '%".$_GET['companyname']."%' 
			group by e.productname,f.uomcode,b.sloccode
			";
		$dataReader = Yii::app()->db->createCommand($sql)->queryAll();
		$line++;
        
        $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0,$line,'Kebutuhan Bahan Baku');
        $line++;
        $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(2,$line,'Material / Service')
                ->setCellValueByColumnAndRow(3,$line,'Qty')
                ->setCellValueByColumnAndRow(4,$line,'Stock')
                ->setCellValueByColumnAndRow(5,$line,'Satuan')
                ->setCellValueByColumnAndRow(6,$line,'Gudang')
                ->setCellValueByColumnAndRow(7,$line,'Versi BOM');
        $line++;
        
        foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		   $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(2,$line,$row1['productname'])
                ->setCellValueByColumnAndRow(3,$line,$row1['qty'])
                ->setCellValueByColumnAndRow(4,$line,$row1['stockqty'])
                ->setCellValueByColumnAndRow(5,$line,$row1['uomcode'])
                ->setCellValueByColumnAndRow(6,$line,$row1['sloccode'])
                ->setCellValueByColumnAndRow(7,$line,$row1['bomversion']);
            $line++;
			$total += $row1['qty'];
		}
        $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(2,$line,'Total')
                ->setCellValueByColumnAndRow(3,$line,$total);
        
		$this->getFooterXLS($this->phpExcel);
	}
}