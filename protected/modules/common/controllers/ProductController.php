<?php

class ProductController extends AdminController
{
	protected $menuname = 'product';
	public $module = 'Common';
	protected $pageTitle = 'Material / Service';
	public $wfname = '';
	protected $sqldata = "select a0.productid,a0.productname,a0.productpic,a0.barcode,a0.isstock,a0.panjang,a0.lebar,a0.tinggi,a0.recordstatus,a0.materialtypeid, a1.description,a0.productidentityid,a0.productbrandid,a0.productcollectid,a0.productseriesid,a2.identityname,a3.brandname,a4.collectionname,a5.description as seriesdesc,a0.isfohulbom, a0.iscontinue, a0.k3lnumber,a0.density,a0.leadtime
    from product a0 
    left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
    left join productidentity a2 on a2.productidentityid = a0.productidentityid
    left join productbrand a3 on a3.productbrandid = a0.productbrandid
    left join productcollection a4 on a4.productcollectid = a0.productcollectid
    left join productseries a5 on a5.productseriesid = a0.productseriesid

  ";
  protected $sqlcount = "select count(1) 
    from product a0 
    left join materialtype a1 on a1.materialtypeid = a0.materialtypeid
    left join productidentity a2 on a2.productidentityid = a0.productidentityid
    left join productbrand a3 on a3.productbrandid = a0.productbrandid
    left join productcollection a4 on a4.productcollectid = a0.productcollectid
    left join productseries a5 on a5.productseriesid = a0.productseriesid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['productname'])) && (isset($_REQUEST['productpic'])) && (isset($_REQUEST['barcode'])))
		{				
			$where .= " where a0.productname like '%". $_REQUEST['productname']."%' 
and a0.productpic like '%". $_REQUEST['productpic']."%' 
and a0.panjang like '%". $_REQUEST['panjang']."%' 
and a0.lebar like '%". $_REQUEST['lebar']."%' 
and a0.tinggi like '%". $_REQUEST['tinggi']."%'"; 
		}
		if (isset($_REQUEST['barcode']))
		{
			if (($_REQUEST['barcode'] !== '0') && ($_REQUEST['barcode'] !== ''))
			{
					$where .= " and a0.barcode in (".$_REQUEST['barcode'].")";
			}
		}
		if (isset($_REQUEST['productid']))
		{
			if (($_REQUEST['productid'] !== '0') && ($_REQUEST['productid'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.productid in (".$_REQUEST['productid'].")";
				}
				else
				{
					$where .= " and a0.productid in (".$_REQUEST['productid'].")";
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
			'keyField'=>'productid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productid','productname','productpic','barcode','isstock','materialtypeid','panjang','lebar','tinggi','recordstatus','k3lnumber','isfohulbom','iscontinue','productidentity','productbrandid','productcollectid','productseriesid','density','leadtime'
				),
				'defaultOrder' => array( 
					'productid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionUpload()
	{
		if (!file_exists(Yii::getPathOfAlias('webroot').'/images/product/'))
		{
			mkdir(Yii::getPathOfAlias('webroot').'/images/product/');
		}
		$this->storeFolder = dirname('__FILES__').'/images/product/';
		parent::actionUpload();
		echo $_FILES['upload']['name'];
	}
	
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"productpic"=>"default.jpg"
		));
	}
	
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.productid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'productid'=>$model['productid'],
          'productname'=>$model['productname'],
          'productpic'=>$model['productpic'],
          'materialtypeid'=>$model['materialtypeid'],
          'description'=>$model['description'],
          'barcode'=>$model['barcode'],
          'isstock'=>$model['isstock'],
          'panjang'=>$model['panjang'],
          'lebar'=>$model['lebar'],
          'tinggi'=>$model['tinggi'],
          'productidentityid' => $model['productidentityid'],
          'productbrandid' => $model['productbrandid'],
          'productcollectid' => $model['productcollectid'],
          'productseriesid' => $model['productseriesid'],
          'identityname' => $model['identityname'],
          'brandname' => $model['brandname'],
          'collectionname' => $model['collectionname'],
          'seriesdesc' => $model['seriesdesc'],
          'recordstatus'=>$model['recordstatus'],
          'isfohubom' => $model['isfohulbom'],
          'iscontinue' => $model['iscontinue'],
          'k3lnumber' => $model['k3lnumber'],
          'density' => $model['density'],
          'leadtime' => $model['leadtime']
				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('productname','string','emptyproductname'),
      //array('productpic','string','emptyproductpic'),
      array('barcode','string','emptybarcode'),
      array('panjang','string','emptypanjang'),
      array('lebar','string','emptylebar'),
      array('tinggi','string','emptytinggi'),
      //array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['productid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateproduct(:vid,:vproductname,:visstock,:visfohulbom,:viscontinue,:vproductpic,:vbarcode,:vk3lnumber,:vmaterialtypeid,:vproductidentityid,:vproductbrandid,:vproductcollectid,:vproductseriesid,:vleadtime,:vpanjang,:vlebar,:vtinggi,:vdensity,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertproduct(:vproductname,:visstock,:visfohulbom,:viscontinue,:vproductpic,:vbarcode,:vk3lnumber,:vmaterialtypeid,:vproductidentityid,:vproductbrandid,:vproductcollectid,:vproductseriesid,:vleadtime,:vpanjang,:vlebar,:vtinggi,:vdensity,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['productid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vproductname',(($_POST['productname']!=='')?$_POST['productname']:null),PDO::PARAM_STR);
        $command->bindvalue(':visstock',(($_POST['isstock']!=='')?$_POST['isstock']:null),PDO::PARAM_STR);
        $command->bindvalue(':visfohulbom',(($_POST['isfohulbom']!=='')?$_POST['isfohulbom']:null),PDO::PARAM_STR);
        $command->bindvalue(':viscontinue',(($_POST['iscontinue']!=='')?$_POST['iscontinue']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductpic',(($_POST['productpic']!=='')?$_POST['productpic']:null),PDO::PARAM_STR);
        $command->bindvalue(':vbarcode',(($_POST['barcode']!=='')?$_POST['barcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':vk3lnumber',(($_POST['k3lnumber']!=='')?$_POST['k3lnumber']:null),PDO::PARAM_STR);
        $command->bindvalue(':vmaterialtypeid',(($_POST['materialtypeid']!=='')?$_POST['materialtypeid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductidentityid',(($_POST['productidentityid']!=='')?$_POST['productidentityid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductbrandid',(($_POST['productbrandid']!=='')?$_POST['productbrandid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductcollectid',(($_POST['productcollectid']!=='')?$_POST['productcollectid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vproductseriesid',(($_POST['productseriesid']!=='')?$_POST['productseriesid']:null),PDO::PARAM_STR);
        $command->bindvalue(':vleadtime',(($_POST['leadtime']!=='')?$_POST['leadtime']:null),PDO::PARAM_STR);
        $command->bindvalue(':vpanjang',(($_POST['panjang']!=='')?$_POST['panjang']:null),PDO::PARAM_STR);
        $command->bindvalue(':vlebar',(($_POST['lebar']!=='')?$_POST['lebar']:null),PDO::PARAM_STR);
        $command->bindvalue(':vtinggi',(($_POST['tinggi']!=='')?$_POST['tinggi']:null),PDO::PARAM_STR);
        $command->bindvalue(':vdensity',(($_POST['density']!=='')?$_POST['density']:null),PDO::PARAM_STR);
        $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
        $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
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
		
	public function actionDelete()
	{
		parent::actionDelete();
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if (isset($_POST['id']))
			{
				$id = $_POST['id']; if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($_POST['id']);$i++)
				{
					$sql = "select recordstatus from product where productid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update product set recordstatus = 0 where productid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update product set recordstatus = 1 where productid = ".$id[$i];
					}
					$connection->createCommand($sql)->execute();
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
				$sql = "delete from product where productid = ".$id[$i];
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
	
	public function actionDownPDF()	{
	  parent::actionDownPDF();
		//masukkan perintah download
	  $sql = "select productid,productname,productpic,leadtime,
						case when isstock = 1 then 'Yes' else 'No' end as isstock,
						case when isfohulbom = 1 then 'Yes' else 'No' end as isfohulbom,
						case when iscontinue = 1 then 'Yes' else 'No' end as iscontinue,
						barcode,panjang,lebar,tinggi,density,b.materialtypecode,
            c.identityname,d.brandname,e.collectionname,f.description as productseries,
						case when a.recordstatus = 1 then 'Yes' else 'No' end as recordstatus, k3lnumber
						from product a
						left join materialtype b on b.materialtypeid=a.materialtypeid 
						left join productidentity c on c.productidentityid=a.productidentityid
						left join productbrand d on d.productbrandid=a.productbrandid
						left join productcollection e on e.productcollectid=a.productcollectid
						left join productseries f on f.productseriesid=a.productseriesid
                        ";
		$productid = filter_input(INPUT_GET,'productid');
		$productname = filter_input(INPUT_GET,'productname');
		$barcode = filter_input(INPUT_GET,'barcode');
		$productidentity = filter_input(INPUT_GET,'productidentity');
		$productbrand = filter_input(INPUT_GET,'productbrand');
		$productcollection = filter_input(INPUT_GET,'productcollection');
		$productseries = filter_input(INPUT_GET,'productseries');
		$leadtime = filter_input(INPUT_GET,'leadtime');
		$length = filter_input(INPUT_GET,'length');
		$width = filter_input(INPUT_GET,'width');
		$height = filter_input(INPUT_GET,'height');
		$isstock = filter_input(INPUT_GET,'isstock');
		$isfohulbom = filter_input(INPUT_GET,'isfohulbom');
		$iscontinue = filter_input(INPUT_GET,'iscontinue');
		$materialtype = filter_input(INPUT_GET,'materialtype');
		$density = filter_input(INPUT_GET,'density');
		$recordstatus = filter_input(INPUT_GET,'recordstatus');
		$sql .= " where coalesce(a.productid,'') like '%".$productid."%' 
			and coalesce(a.productname,'') like '%".$productname."%'
			and coalesce(a.barcode,'') like '%".$barcode."%'
			and coalesce(c.identityname,'') like '%".$productidentity."%'
			and coalesce(d.brandname,'') like '%".$productbrand."%'
			and coalesce(e.collectionname,'') like '%".$productcollection."%'
			and coalesce(f.description,'') like '%".$productseries."%'
			and coalesce(a.leadtime,'') like '%".$leadtime."%'
			and coalesce(a.panjang,'') like '%".$length."%'
			and coalesce(a.lebar,'') like '%".$width."%'
			and coalesce(a.tinggi,'') like '%".$height."%'
			and coalesce(a.isstock,'') like '%".$isstock."%'
			and coalesce(a.isfohulbom,'') like '%".$isfohulbom."%'
			and coalesce(a.iscontinue,'') like '%".$iscontinue."%'
			and coalesce(b.description,'') like '%".$materialtype."%'
			and coalesce(a.density,'') like '%".$density."%'
			and coalesce(a.recordstatus,'') like '%".$recordstatus."%'
			";
		if ($_GET['productid'] !== '') 
		{
				$sql = $sql . " and a.productid in (".$_GET['productid'].")";
		}
		$sql = $sql . " order by productname asc ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		//masukkan judul
		$this->pdf->title=GetCatalog('product');
		$this->pdf->AddPage('P',array(400,250));
		//masukkan posisi judul
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		//masukkan colom judul
		$this->pdf->colheader = array(GetCatalog('productid'),
			GetCatalog('productname'),
			GetCatalog('productpic'),
			GetCatalog('isstock'),
			GetCatalog('isfohulbom'),
			GetCatalog('iscontinue'),
			GetCatalog('barcode'),
      GetCatalog('materialtype'),
			GetCatalog('identityname'),
			GetCatalog('brandname'),
			GetCatalog('collectionname'),
			GetCatalog('productseries'),
			GetCatalog('leadtime'),
			GetCatalog('panjang'),
			GetCatalog('lebar'),
			GetCatalog('tinggi'),
			GetCatalog('recordstatus'),
			GetCatalog('k3lnumber'),
			GetCatalog('density'));
		$this->pdf->setwidths(array(22,90,25,20,20,20,45,25,20,20,20,20,20,20,20,20,20,20,20));
		$this->pdf->Rowheader();
		$this->pdf->setFont('Arial','',8);
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['productid'],$row1['productname'],$row1['productpic'],$row1['isstock'],$row1['isfohulbom'],$row1['iscontinue'],$row1['barcode'],$row1['materialtypecode'],$row1['identityname'],$row1['brandname'],$row1['collectionname'],$row1['productseries'],$row1['leadtime'],$row1['panjang'],$row1['lebar'],$row1['tinggi'],$row1['recordstatus'],$row1['k3lnumber'],$row1['density']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	
	public function actionDownxls()	{
		$this->menuname='product';
		parent::actionDownxls();
		$sql = "select productid,productname,productpic,leadtime,
						case when isstock = 1 then 'Yes' else 'No' end as isstock,
						case when isfohulbom = 1 then 'Yes' else 'No' end as isfohulbom,
						case when iscontinue = 1 then 'Yes' else 'No' end as iscontinue,
						barcode,panjang,lebar,tinggi,density,b.materialtypecode,
                        c.identityname,d.brandname,e.collectionname,f.description as productseries,
						case when a.recordstatus = 1 then 'Yes' else 'No' end as recordstatus, k3lnumber
						from product a
						left join materialtype b on b.materialtypeid=a.materialtypeid 
						left join productidentity c on c.productidentityid=a.productidentityid
						left join productbrand d on d.productbrandid=a.productbrandid
						left join productcollection e on e.productcollectid=a.productcollectid
						left join productseries f on f.productseriesid=a.productseriesid
                        ";
		$productid = filter_input(INPUT_GET,'productid');
		$productname = filter_input(INPUT_GET,'productname');
		$barcode = filter_input(INPUT_GET,'barcode');
		$productidentity = filter_input(INPUT_GET,'productidentity');
		$productbrand = filter_input(INPUT_GET,'productbrand');
		$productcollection = filter_input(INPUT_GET,'productcollection');
		$productseries = filter_input(INPUT_GET,'productseries');
		$leadtime = filter_input(INPUT_GET,'leadtime');
		$length = filter_input(INPUT_GET,'length');
		$width = filter_input(INPUT_GET,'width');
		$height = filter_input(INPUT_GET,'height');
		$isstock = filter_input(INPUT_GET,'isstock');
		$isfohulbom = filter_input(INPUT_GET,'isfohulbom');
		$iscontinue = filter_input(INPUT_GET,'iscontinue');
		$materialtype = filter_input(INPUT_GET,'materialtype');
		$density = filter_input(INPUT_GET,'density');
		$recordstatus = filter_input(INPUT_GET,'recordstatus');
		$sql .= " where coalesce(a.productid,'') like '%".$productid."%' 
			and coalesce(a.productname,'') like '%".$productname."%'
			and coalesce(a.barcode,'') like '%".$barcode."%'
			and coalesce(c.identityname,'') like '%".$productidentity."%'
			and coalesce(d.brandname,'') like '%".$productbrand."%'
			and coalesce(e.collectionname,'') like '%".$productcollection."%'
			and coalesce(f.description,'') like '%".$productseries."%'
			and coalesce(a.leadtime,'') like '%".$leadtime."%'
			and coalesce(a.panjang,'') like '%".$length."%'
			and coalesce(a.lebar,'') like '%".$width."%'
			and coalesce(a.tinggi,'') like '%".$height."%'
			and coalesce(a.isstock,'') like '%".$isstock."%'
			and coalesce(a.isfohulbom,'') like '%".$isfohulbom."%'
			and coalesce(a.iscontinue,'') like '%".$iscontinue."%'
			and coalesce(b.description,'') like '%".$materialtype."%'
			and coalesce(a.density,'') like '%".$density."%'
			and coalesce(a.recordstatus,'') like '%".$recordstatus."%'
			";
		if ($_GET['productid'] !== '') 
		{
				$sql = $sql . " and a.productid in (".$_GET['productid'].")";
		}
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();	
		$i=3;
		
		foreach($dataReader as $row1)
		{
			$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0,$i,$row1['productid'])
				->setCellValueByColumnAndRow(1,$i,$row1['productname'])							
				->setCellValueByColumnAndRow(2,$i,$row1['productpic'])
				->setCellValueByColumnAndRow(3,$i,$row1['isstock'])
				->setCellValueByColumnAndRow(4,$i,$row1['barcode'])
				->setCellValueByColumnAndRow(5,$i,$row1['materialtypecode'])
				->setCellValueByColumnAndRow(6,$i,$row1['identityname'])
				->setCellValueByColumnAndRow(7,$i,$row1['brandname'])
				->setCellValueByColumnAndRow(8,$i,$row1['collectionname'])
				->setCellValueByColumnAndRow(9,$i,$row1['productseries'])
				->setCellValueByColumnAndRow(10,$i,$row1['leadtime'])
				->setCellValueByColumnAndRow(11,$i,$row1['panjang'])
				->setCellValueByColumnAndRow(12,$i,$row1['lebar'])
				->setCellValueByColumnAndRow(13,$i,$row1['tinggi'])
				->setCellValueByColumnAndRow(14,$i,$row1['recordstatus'])
				->setCellValueByColumnAndRow(15,$i,$row1['k3lnumber'])
				->setCellValueByColumnAndRow(16,$i,$row1['density'])
				->setCellValueByColumnAndRow(17,$i,$row1['isfohulbom'])
				->setCellValueByColumnAndRow(18,$i,$row1['iscontinue']);
			$i++;
		}
		
		
		$this->getFooterXLS($this->phpExcel);
	}
}