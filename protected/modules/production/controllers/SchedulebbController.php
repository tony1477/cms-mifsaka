<?php

class SchedulebbController extends AdminController
{
	protected $menuname = 'schedulebb';
	public $module = 'Production';
	protected $pageTitle = 'Raw Material Schedule';
	public $wfname = '';
	protected $sqldata = "select a0.schedulebbid,a0.companyid,a0.bulan,a0.tahun,a0.productid,a0.uomid,a0.slocid,a0.d1,a0.d2,a0.d3,a0.d4,a0.d5,a0.d6,a0.d7,a0.d8,a0.d9,a0.d10,a0.d11,a0.d12,a0.d13,a0.d14,a0.d15,a0.d16,a0.d17,a0.d18,a0.d19,a0.d20,a0.d21,a0.d22,a0.d23,a0.d24,a0.d25,a0.d26,a0.d27,a0.d28,a0.d29,a0.d30,a0.d31,a1.companyname as companyname,a2.productname as productname,a3.uomcode as uomcode,a4.sloccode as sloccode ,d1+d2+d3+d4+d5+d6+d7+d8+d9+d10+d11+d12+d13+d14+d15+d16+d17+d18+d19+d20+d21+d22+d23+d24+d25+d26+d27+d28+d29+d30+d31 as totalpesan
    from schedulebb a0 
    left join company a1 on a1.companyid = a0.companyid
    left join product a2 on a2.productid = a0.productid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.uomid
    left join sloc a4 on a4.slocid = a0.slocid
  ";
  protected $sqlcount = "select count(1) 
    from schedulebb a0 
    left join company a1 on a1.companyid = a0.companyid
    left join product a2 on a2.productid = a0.productid
    left join unitofmeasure a3 on a3.unitofmeasureid = a0.uomid
    left join sloc a4 on a4.slocid = a0.slocid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a1.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['productname'])) && (isset($_REQUEST['uomcode'])) && (isset($_REQUEST['sloccode'])))
		{				
			$where .= " and a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.productname like '%". $_REQUEST['productname']."%' 
and a3.uomcode like '%". $_REQUEST['uomcode']."%' 
and a4.sloccode like '%". $_REQUEST['sloccode']."%'"; 
		}
		if (isset($_REQUEST['schedulebbid']))
			{
				if (($_REQUEST['schedulebbid'] !== '0') && ($_REQUEST['schedulebbid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.schedulebbid in (".$_REQUEST['schedulebbid'].")";
					}
					else
					{
						$where .= " and a0.schedulebbid in (".$_REQUEST['schedulebbid'].")";
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
			$companyid = Yii::app()->db->createCommand("select companyid from company where lower(companyname) = lower('".$sheet->getCell('A1')->getValue()."')")->queryScalar();
			if ($companyid == null)
			{
				throw new Exception('emptycompany');
			}
			$highestRow = $sheet->getHighestRow();
			for ($i = 7;$i <= $highestRow; $i++)
			{	
				$bulan = $sheet->getCell('B'.$i)->getValue();
				$tahun = $sheet->getCell('C'.$i)->getValue();
				$productname = $sheet->getCell('D'.$i)->getValue();
				if ((strpos($productname,'TOTAL') === false) && (strpos($productname,'LEGEND') === false) &&
					(strpos($productname,'Hari OFF Production') === false) && (strpos($productname,'Tidak ada tanggal di bulan tersebut') === false))
				{
					$productid = Yii::app()->db->createCommand("select productid from product where lower(productname) = lower('".$sheet->getCell('D'.$i)->getValue()."')")->queryScalar();
					if ($productid != null)
					{
						$sloc = $sheet->getCell('E'.$i)->getValue();
						$slocid = Yii::app()->db->createCommand("select a.slocid 
							from sloc a
							where lower(sloccode) = lower('".$sloc."')")->queryScalar();
						$uom = $sheet->getCell('F'.$i)->getValue();
						$uomid = Yii::app()->db->createCommand("select a.unitofmeasureid 
							from unitofmeasure a
							where lower(uomcode) = lower('".$uom."')")->queryScalar();
						$d1 = $sheet->getCell('H'.$i)->getValue();
						$d2 = $sheet->getCell('I'.$i)->getValue();
						$d3 = $sheet->getCell('J'.$i)->getValue();
						$d4 = $sheet->getCell('K'.$i)->getValue();
						$d5 = $sheet->getCell('L'.$i)->getValue();
						$d6 = $sheet->getCell('M'.$i)->getValue();
						$d7 = $sheet->getCell('N'.$i)->getValue();
						$d8 = $sheet->getCell('O'.$i)->getValue();
						$d9 = $sheet->getCell('P'.$i)->getValue();
						$d10 = $sheet->getCell('Q'.$i)->getValue();
						$d11 = $sheet->getCell('R'.$i)->getValue();
						$d12 = $sheet->getCell('S'.$i)->getValue();
						$d13 = $sheet->getCell('T'.$i)->getValue();
						$d14 = $sheet->getCell('U'.$i)->getValue();
						$d15 = $sheet->getCell('V'.$i)->getValue();
						$d16 = $sheet->getCell('W'.$i)->getValue();
						$d17 = $sheet->getCell('X'.$i)->getValue();
						$d18 = $sheet->getCell('Y'.$i)->getValue();
						$d19 = $sheet->getCell('Z'.$i)->getValue();
						$d20 = $sheet->getCell('AA'.$i)->getValue();
						$d21 = $sheet->getCell('AB'.$i)->getValue();
						$d22 = $sheet->getCell('AC'.$i)->getValue();
						$d23 = $sheet->getCell('AD'.$i)->getValue();
						$d24 = $sheet->getCell('AE'.$i)->getValue();
						$d25 = $sheet->getCell('AF'.$i)->getValue();
						$d26 = $sheet->getCell('AG'.$i)->getValue();
						$d27 = $sheet->getCell('AH'.$i)->getValue();
						$d28 = $sheet->getCell('AI'.$i)->getValue();
						$d29 = $sheet->getCell('AJ'.$i)->getValue();
						$d30 = $sheet->getCell('AK'.$i)->getValue();
						$d31 = $sheet->getCell('AL'.$i)->getValue();
						$id = Yii::app()->db->createCommand("select schedulebbid from schedulebb where bulan = ".$bulan." and productid = ".$productid." and tahun = ".$tahun." and companyid = ".$companyid)->queryScalar();
						$connection = Yii::app()->db;
						if ($id == null)
						{
							$sql = 'insert into schedulebb (companyid,bulan,tahun,productid,uomid,slocid,d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31) 
								values (:companyid,:bulan,:tahun,:productid,:uomid,:slocid,:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8,:d9,:d10,:d11,:d12,:d13,:d14,:d15,:d16,:d17,:d18,:d19,:d20,:d21,:d22,:d23,:d24,:d25,:d26,:d27,:d28,:d29,:d30,:d31)';
							$command = $connection->createCommand($sql);
							$command->bindvalue(':bulan',$bulan,PDO::PARAM_STR);
							$command->bindvalue(':tahun',$tahun,PDO::PARAM_STR);
							$command->bindvalue(':productid',$productid,PDO::PARAM_STR);
							$command->bindvalue(':companyid',$companyid,PDO::PARAM_STR);
						}
						else
						{
							$sql = "update schedulebb set uomid = :uomid,slocid = :slocid, d1 = :d1, d2 = :d2, d3 = :d3, d4 = :d4, d5 = :d5, d6 = :d6, d7 = :d7,
								d8 = :d8, d9 = :d9, d10 = :d10, d11 = :d11, d12 = :d12, d13 = :d13, d14 = :d14, d15 = :d15, d16 = :d16,
								d17 = :d17, d18 = :d18, d19 = :d19, d20 = :d20, d21 = :d21, d22 = :d22, d23 = :d23, d24 = :d24, d25 = :d25,
								d26 = :d26, d27 = :d27, d28 = :d28, d29 = :d29, d30 = :d30, d31 = :d31
								where schedulebbid = ".$id;	
							$command = $connection->createCommand($sql);
						}
						$command->bindvalue(':uomid',$uomid,PDO::PARAM_STR);
						$command->bindvalue(':slocid',$slocid,PDO::PARAM_STR);
						$command->bindvalue(':d1',(($d1 != null)?$d1:0),PDO::PARAM_STR);
						$command->bindvalue(':d2',(($d2 != null)?$d2:0),PDO::PARAM_STR);
						$command->bindvalue(':d3',(($d3 != null)?$d3:0),PDO::PARAM_STR);
						$command->bindvalue(':d4',(($d4 != null)?$d4:0),PDO::PARAM_STR);
						$command->bindvalue(':d5',(($d5 != null)?$d5:0),PDO::PARAM_STR);
						$command->bindvalue(':d6',(($d6 != null)?$d6:0),PDO::PARAM_STR);
						$command->bindvalue(':d7',(($d7 != null)?$d7:0),PDO::PARAM_STR);
						$command->bindvalue(':d8',(($d8 != null)?$d8:0),PDO::PARAM_STR);
						$command->bindvalue(':d9',(($d9 != null)?$d9:0),PDO::PARAM_STR);
						$command->bindvalue(':d10',(($d10 != null)?$d10:0),PDO::PARAM_STR);
						$command->bindvalue(':d11',(($d11 != null)?$d11:0),PDO::PARAM_STR);
						$command->bindvalue(':d12',(($d12 != null)?$d12:0),PDO::PARAM_STR);
						$command->bindvalue(':d13',(($d13 != null)?$d13:0),PDO::PARAM_STR);
						$command->bindvalue(':d14',(($d14 != null)?$d14:0),PDO::PARAM_STR);
						$command->bindvalue(':d15',(($d15 != null)?$d15:0),PDO::PARAM_STR);
						$command->bindvalue(':d16',(($d16 != null)?$d16:0),PDO::PARAM_STR);
						$command->bindvalue(':d17',(($d17 != null)?$d17:0),PDO::PARAM_STR);
						$command->bindvalue(':d18',(($d18 != null)?$d18:0),PDO::PARAM_STR);
						$command->bindvalue(':d19',(($d19 != null)?$d19:0),PDO::PARAM_STR);
						$command->bindvalue(':d20',(($d20 != null)?$d20:0),PDO::PARAM_STR);
						$command->bindvalue(':d21',(($d21 != null)?$d21:0),PDO::PARAM_STR);
						$command->bindvalue(':d22',(($d22 != null)?$d22:0),PDO::PARAM_STR);
						$command->bindvalue(':d23',(($d23 != null)?$d23:0),PDO::PARAM_STR);
						$command->bindvalue(':d24',(($d24 != null)?$d24:0),PDO::PARAM_STR);
						$command->bindvalue(':d25',(($d25 != null)?$d25:0),PDO::PARAM_STR);
						$command->bindvalue(':d26',(($d26 != null)?$d26:0),PDO::PARAM_STR);
						$command->bindvalue(':d27',(($d27 != null)?$d27:0),PDO::PARAM_STR);
						$command->bindvalue(':d28',(($d28 != null)?$d28:0),PDO::PARAM_STR);
						$command->bindvalue(':d29',(($d29 != null)?$d29:0),PDO::PARAM_STR);
						$command->bindvalue(':d30',(($d30 != null)?$d30:0),PDO::PARAM_STR);
						$command->bindvalue(':d31',(($d31 != null)?$d31:0),PDO::PARAM_STR);
						$command->execute();
					}		
					else
					{
						var_dump($sheet->getCell('D'.$i)->getValue());
					}	
				}
			}
		}	
		catch (Exception $e)
		{
			$this->getMessage('error',$e->getMessage());
		}		
	}
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'schedulebbid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'schedulebbid','companyid','bulan','tahun','productid','uomid','slocid','d1','d2','d3','d4','d5','d6','d7','d8','d9','d10','d11','d12','d13','d14','d15','d16','d17','d18','d19','d20','d21','d22','d23','d24','d25','d26','d27','d28','d29','d30','d31','totalpesan','forecast','buffer','acuan'
				),
				'defaultOrder' => array( 
					'schedulebbid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"d1" =>0,
      "d2" =>0,
      "d3" =>0,
      "d4" =>0,
      "d5" =>0,
      "d6" =>0,
      "d7" =>0,
      "d8" =>0,
      "d9" =>0,
      "d10" =>0,
      "d11" =>0,
      "d12" =>0,
      "d13" =>0,
      "d14" =>0,
      "d15" =>0,
      "d16" =>0,
      "d17" =>0,
      "d18" =>0,
      "d19" =>0,
      "d20" =>0,
      "d21" =>0,
      "d22" =>0,
      "d23" =>0,
      "d24" =>0,
      "d25" =>0,
      "d26" =>0,
      "d27" =>0,
      "d28" =>0,
      "d29" =>0,
      "d30" =>0,
      "d31" =>0,
      "totalpesan" =>0,
      "forecast" =>0,
      "buffer" =>0,
      "acuan" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.schedulebbid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'schedulebbid'=>$model['schedulebbid'],
          'companyid'=>$model['companyid'],
          'bulan'=>$model['bulan'],
          'tahun'=>$model['tahun'],
          'productid'=>$model['productid'],
          'uomid'=>$model['uomid'],
          'slocid'=>$model['slocid'],
          'd1'=>$model['d1'],
          'd2'=>$model['d2'],
          'd3'=>$model['d3'],
          'd4'=>$model['d4'],
          'd5'=>$model['d5'],
          'd6'=>$model['d6'],
          'd7'=>$model['d7'],
          'd8'=>$model['d8'],
          'd9'=>$model['d9'],
          'd10'=>$model['d10'],
          'd11'=>$model['d11'],
          'd12'=>$model['d12'],
          'd13'=>$model['d13'],
          'd14'=>$model['d14'],
          'd15'=>$model['d15'],
          'd16'=>$model['d16'],
          'd17'=>$model['d17'],
          'd18'=>$model['d18'],
          'd19'=>$model['d19'],
          'd20'=>$model['d20'],
          'd21'=>$model['d21'],
          'd22'=>$model['d22'],
          'd23'=>$model['d23'],
          'd24'=>$model['d24'],
          'd25'=>$model['d25'],
          'd26'=>$model['d26'],
          'd27'=>$model['d27'],
          'd28'=>$model['d28'],
          'd29'=>$model['d29'],
          'd30'=>$model['d30'],
          'd31'=>$model['d31'],
          'companyname'=>$model['companyname'],
          'productname'=>$model['productname'],
          'uomcode'=>$model['uomcode'],
          'sloccode'=>$model['sloccode'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('bulan','string','emptybulan'),
      array('tahun','string','emptytahun'),
      array('productid','string','emptyproductid'),
      array('uomid','string','emptyuomid'),
      array('slocid','string','emptyslocid'),
      array('d1','string','emptyd1'),
      array('d2','string','emptyd2'),
      array('d3','string','emptyd3'),
      array('d4','string','emptyd4'),
      array('d5','string','emptyd5'),
      array('d6','string','emptyd6'),
      array('d7','string','emptyd7'),
      array('d8','string','emptyd8'),
      array('d9','string','emptyd9'),
      array('d10','string','emptyd10'),
      array('d11','string','emptyd11'),
      array('d12','string','emptyd12'),
      array('d13','string','emptyd13'),
      array('d14','string','emptyd14'),
      array('d15','string','emptyd15'),
      array('d16','string','emptyd16'),
      array('d17','string','emptyd17'),
      array('d18','string','emptyd18'),
      array('d19','string','emptyd19'),
      array('d20','string','emptyd20'),
      array('d21','string','emptyd21'),
      array('d22','string','emptyd22'),
      array('d23','string','emptyd23'),
      array('d24','string','emptyd24'),
      array('d25','string','emptyd25'),
      array('d26','string','emptyd26'),
      array('d27','string','emptyd27'),
      array('d28','string','emptyd28'),
      array('d29','string','emptyd29'),
      array('d30','string','emptyd30'),
      array('d31','string','emptyd31'),
    ));
		if ($error == false)
		{
			$id = $_POST['schedulebbid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update schedulebb 
			      set companyid = :companyid,bulan = :bulan,tahun = :tahun,productid = :productid,uomid = :uomid,slocid = :slocid,d1 = :d1,d2 = :d2,d3 = :d3,d4 = :d4,d5 = :d5,d6 = :d6,d7 = :d7,d8 = :d8,d9 = :d9,d10 = :d10,d11 = :d11,d12 = :d12,d13 = :d13,d14 = :d14,d15 = :d15,d16 = :d16,d17 = :d17,d18 = :d18,d19 = :d19,d20 = :d20,d21 = :d21,d22 = :d22,d23 = :d23,d24 = :d24,d25 = :d25,d26 = :d26,d27 = :d27,d28 = :d28,d29 = :d29,d30 = :d30,d31 = :d31
			      where schedulebbid = :schedulebbid';
				}
				else
				{
					$sql = 'insert into schedulebb (companyid,bulan,tahun,productid,uomid,slocid,d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31) 
			      values (:companyid,:bulan,:tahun,:productid,:uomid,:slocid,:d1,:d2,:d3,:d4,:d5,:d6,:d7,:d8,:d9,:d10,:d11,:d12,:d13,:d14,:d15,:d16,:d17,:d18,:d19,:d20,:d21,:d22,:d23,:d24,:d25,:d26,:d27,:d28,:d29,:d30,:d31)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':schedulebbid',$_POST['schedulebbid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':bulan',(($_POST['bulan']!=='')?$_POST['bulan']:null),PDO::PARAM_STR);
        $command->bindvalue(':tahun',(($_POST['tahun']!=='')?$_POST['tahun']:null),PDO::PARAM_STR);
        $command->bindvalue(':productid',(($_POST['productid']!=='')?$_POST['productid']:null),PDO::PARAM_STR);
        $command->bindvalue(':uomid',(($_POST['uomid']!=='')?$_POST['uomid']:null),PDO::PARAM_STR);
        $command->bindvalue(':slocid',(($_POST['slocid']!=='')?$_POST['slocid']:null),PDO::PARAM_STR);
        $command->bindvalue(':d1',(($_POST['d1']!=='')?$_POST['d1']:null),PDO::PARAM_STR);
        $command->bindvalue(':d2',(($_POST['d2']!=='')?$_POST['d2']:null),PDO::PARAM_STR);
        $command->bindvalue(':d3',(($_POST['d3']!=='')?$_POST['d3']:null),PDO::PARAM_STR);
        $command->bindvalue(':d4',(($_POST['d4']!=='')?$_POST['d4']:null),PDO::PARAM_STR);
        $command->bindvalue(':d5',(($_POST['d5']!=='')?$_POST['d5']:null),PDO::PARAM_STR);
        $command->bindvalue(':d6',(($_POST['d6']!=='')?$_POST['d6']:null),PDO::PARAM_STR);
        $command->bindvalue(':d7',(($_POST['d7']!=='')?$_POST['d7']:null),PDO::PARAM_STR);
        $command->bindvalue(':d8',(($_POST['d8']!=='')?$_POST['d8']:null),PDO::PARAM_STR);
        $command->bindvalue(':d9',(($_POST['d9']!=='')?$_POST['d9']:null),PDO::PARAM_STR);
        $command->bindvalue(':d10',(($_POST['d10']!=='')?$_POST['d10']:null),PDO::PARAM_STR);
        $command->bindvalue(':d11',(($_POST['d11']!=='')?$_POST['d11']:null),PDO::PARAM_STR);
        $command->bindvalue(':d12',(($_POST['d12']!=='')?$_POST['d12']:null),PDO::PARAM_STR);
        $command->bindvalue(':d13',(($_POST['d13']!=='')?$_POST['d13']:null),PDO::PARAM_STR);
        $command->bindvalue(':d14',(($_POST['d14']!=='')?$_POST['d14']:null),PDO::PARAM_STR);
        $command->bindvalue(':d15',(($_POST['d15']!=='')?$_POST['d15']:null),PDO::PARAM_STR);
        $command->bindvalue(':d16',(($_POST['d16']!=='')?$_POST['d16']:null),PDO::PARAM_STR);
        $command->bindvalue(':d17',(($_POST['d17']!=='')?$_POST['d17']:null),PDO::PARAM_STR);
        $command->bindvalue(':d18',(($_POST['d18']!=='')?$_POST['d18']:null),PDO::PARAM_STR);
        $command->bindvalue(':d19',(($_POST['d19']!=='')?$_POST['d19']:null),PDO::PARAM_STR);
        $command->bindvalue(':d20',(($_POST['d20']!=='')?$_POST['d20']:null),PDO::PARAM_STR);
        $command->bindvalue(':d21',(($_POST['d21']!=='')?$_POST['d21']:null),PDO::PARAM_STR);
        $command->bindvalue(':d22',(($_POST['d22']!=='')?$_POST['d22']:null),PDO::PARAM_STR);
        $command->bindvalue(':d23',(($_POST['d23']!=='')?$_POST['d23']:null),PDO::PARAM_STR);
        $command->bindvalue(':d24',(($_POST['d24']!=='')?$_POST['d24']:null),PDO::PARAM_STR);
        $command->bindvalue(':d25',(($_POST['d25']!=='')?$_POST['d25']:null),PDO::PARAM_STR);
        $command->bindvalue(':d26',(($_POST['d26']!=='')?$_POST['d26']:null),PDO::PARAM_STR);
        $command->bindvalue(':d27',(($_POST['d27']!=='')?$_POST['d27']:null),PDO::PARAM_STR);
        $command->bindvalue(':d28',(($_POST['d28']!=='')?$_POST['d28']:null),PDO::PARAM_STR);
        $command->bindvalue(':d29',(($_POST['d29']!=='')?$_POST['d29']:null),PDO::PARAM_STR);
        $command->bindvalue(':d30',(($_POST['d30']!=='')?$_POST['d30']:null),PDO::PARAM_STR);
        $command->bindvalue(':d31',(($_POST['d31']!=='')?$_POST['d31']:null),PDO::PARAM_STR);
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
				$sql = "delete from schedulebb where schedulebbid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('schedulebb');
		$this->pdf->AddPage('L',array(140,440));
        $this->pdf->setFont('Arial', '', 7);
		$this->pdf->colalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		$this->pdf->colheader = array($this->getCatalog('schedulebbid'),$this->getCatalog('company'),$this->getCatalog('bulan'),$this->getCatalog('product'),$this->getCatalog('sloc'),$this->getCatalog('d1'),$this->getCatalog('d2'),$this->getCatalog('d3'),$this->getCatalog('d4'),$this->getCatalog('d5'),$this->getCatalog('d6'),$this->getCatalog('d7'),$this->getCatalog('d8'),$this->getCatalog('d9'),$this->getCatalog('d10'),$this->getCatalog('d11'),$this->getCatalog('d12'),$this->getCatalog('d13'),$this->getCatalog('d14'),$this->getCatalog('d15'),$this->getCatalog('d16'),$this->getCatalog('d17'),$this->getCatalog('d18'),$this->getCatalog('d19'),$this->getCatalog('d20'),$this->getCatalog('d21'),$this->getCatalog('d22'),$this->getCatalog('d23'),$this->getCatalog('d24'),$this->getCatalog('d25'),$this->getCatalog('d26'),$this->getCatalog('d27'),$this->getCatalog('d28'),$this->getCatalog('d29'),$this->getCatalog('d30'),$this->getCatalog('d31'),$this->getCatalog('totalpesan'));
		$this->pdf->setwidths(array(8,30,10,25,25,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,17));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['schedulebbid'],$row1['companyname'],$row1['bulan'],$row1['productname'],$row1['sloccode'],		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d1']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d2']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d3']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d4']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d5']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d6']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d7']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d8']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d9']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d10']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d11']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d12']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d13']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d14']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d15']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d16']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d17']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d18']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d19']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d20']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d21']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d22']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d23']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d24']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d25']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d26']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d27']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d28']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d29']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d30']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['d31']),
        Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['totalpesan'])));;
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('schedulebbid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('bulan'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('tahun'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('productname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('uomcode'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('sloccode'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('d1'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('d2'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('d3'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('d4'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('d5'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('d6'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('d7'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('d8'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('d9'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('d10'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('d11'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('d12'))
->setCellValueByColumnAndRow(19,4,$this->getCatalog('d13'))
->setCellValueByColumnAndRow(20,4,$this->getCatalog('d14'))
->setCellValueByColumnAndRow(21,4,$this->getCatalog('d15'))
->setCellValueByColumnAndRow(22,4,$this->getCatalog('d16'))
->setCellValueByColumnAndRow(23,4,$this->getCatalog('d17'))
->setCellValueByColumnAndRow(24,4,$this->getCatalog('d18'))
->setCellValueByColumnAndRow(25,4,$this->getCatalog('d19'))
->setCellValueByColumnAndRow(26,4,$this->getCatalog('d20'))
->setCellValueByColumnAndRow(27,4,$this->getCatalog('d21'))
->setCellValueByColumnAndRow(28,4,$this->getCatalog('d22'))
->setCellValueByColumnAndRow(29,4,$this->getCatalog('d23'))
->setCellValueByColumnAndRow(30,4,$this->getCatalog('d24'))
->setCellValueByColumnAndRow(31,4,$this->getCatalog('d25'))
->setCellValueByColumnAndRow(32,4,$this->getCatalog('d26'))
->setCellValueByColumnAndRow(33,4,$this->getCatalog('d27'))
->setCellValueByColumnAndRow(34,4,$this->getCatalog('d28'))
->setCellValueByColumnAndRow(35,4,$this->getCatalog('d29'))
->setCellValueByColumnAndRow(36,4,$this->getCatalog('d30'))
->setCellValueByColumnAndRow(37,4,$this->getCatalog('d31'))
->setCellValueByColumnAndRow(38,4,$this->getCatalog('totalpesan'))
->setCellValueByColumnAndRow(39,4,$this->getCatalog('forecast'))
->setCellValueByColumnAndRow(40,4,$this->getCatalog('buffer'))
->setCellValueByColumnAndRow(41,4,$this->getCatalog('acuan'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['schedulebbid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['bulan'])
->setCellValueByColumnAndRow(3, $i+1, $row1['tahun'])
->setCellValueByColumnAndRow(4, $i+1, $row1['productname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['uomcode'])
->setCellValueByColumnAndRow(6, $i+1, $row1['sloccode'])
->setCellValueByColumnAndRow(7, $i+1, $row1['d1'])
->setCellValueByColumnAndRow(8, $i+1, $row1['d2'])
->setCellValueByColumnAndRow(9, $i+1, $row1['d3'])
->setCellValueByColumnAndRow(10, $i+1, $row1['d4'])
->setCellValueByColumnAndRow(11, $i+1, $row1['d5'])
->setCellValueByColumnAndRow(12, $i+1, $row1['d6'])
->setCellValueByColumnAndRow(13, $i+1, $row1['d7'])
->setCellValueByColumnAndRow(14, $i+1, $row1['d8'])
->setCellValueByColumnAndRow(15, $i+1, $row1['d9'])
->setCellValueByColumnAndRow(16, $i+1, $row1['d10'])
->setCellValueByColumnAndRow(17, $i+1, $row1['d11'])
->setCellValueByColumnAndRow(18, $i+1, $row1['d12'])
->setCellValueByColumnAndRow(19, $i+1, $row1['d13'])
->setCellValueByColumnAndRow(20, $i+1, $row1['d14'])
->setCellValueByColumnAndRow(21, $i+1, $row1['d15'])
->setCellValueByColumnAndRow(22, $i+1, $row1['d16'])
->setCellValueByColumnAndRow(23, $i+1, $row1['d17'])
->setCellValueByColumnAndRow(24, $i+1, $row1['d18'])
->setCellValueByColumnAndRow(25, $i+1, $row1['d19'])
->setCellValueByColumnAndRow(26, $i+1, $row1['d20'])
->setCellValueByColumnAndRow(27, $i+1, $row1['d21'])
->setCellValueByColumnAndRow(28, $i+1, $row1['d22'])
->setCellValueByColumnAndRow(29, $i+1, $row1['d23'])
->setCellValueByColumnAndRow(30, $i+1, $row1['d24'])
->setCellValueByColumnAndRow(31, $i+1, $row1['d25'])
->setCellValueByColumnAndRow(32, $i+1, $row1['d26'])
->setCellValueByColumnAndRow(33, $i+1, $row1['d27'])
->setCellValueByColumnAndRow(34, $i+1, $row1['d28'])
->setCellValueByColumnAndRow(35, $i+1, $row1['d29'])
->setCellValueByColumnAndRow(36, $i+1, $row1['d30'])
->setCellValueByColumnAndRow(37, $i+1, $row1['d31'])
->setCellValueByColumnAndRow(38, $i+1, $row1['totalpesan'])
->setCellValueByColumnAndRow(39, $i+1, $row1['forecast'])
->setCellValueByColumnAndRow(40, $i+1, $row1['buffer'])
->setCellValueByColumnAndRow(41, $i+1, $row1['acuan']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}