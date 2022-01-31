<?php

class EmployeescheduleController extends AdminController
{
	protected $menuname = 'employeeschedule';
	public $module = 'Hr';
	protected $pageTitle = 'Jadwal Karyawan';
	public $wfname = 'appempsched';
	protected $sqldata = "select a0.employeescheduleid,a0.employeeid,a0.month,a0.year,a0.d1,a0.d2,a0.d3,a0.d4,a0.d5,a0.d6,a0.d7,a0.d8,a0.d9,a0.d10,a0.d11,a0.d12,a0.d13,a0.d14,a0.d15,a0.d16,a0.d17,a0.d18,a0.d19,a0.d20,a0.d21,a0.d22,a0.d23,a0.d24,a0.d25,a0.d26,a0.d27,a0.d28,a0.d29,a0.d30,a0.d31,a0.recordstatus,a1.fullname as fullname,a2.absschedulename as d1name,a3.absschedulename as d2name,a4.absschedulename as d3name,a5.absschedulename as d4name,a6.absschedulename as d5name,a7.absschedulename as d6name,a8.absschedulename as d7name,a9.absschedulename as d8name,a10.absschedulename as d9name,a11.absschedulename as d10name,a12.absschedulename as d11name,a13.absschedulename as d12name,a14.absschedulename as d13name,a15.absschedulename as d14name,a16.absschedulename as d15name,a17.absschedulename as d16name,a18.absschedulename as d17name,a19.absschedulename as d18name,a20.absschedulename as d19name,a21.absschedulename as d20name,a22.absschedulename as d21name,a23.absschedulename as d22name,a24.absschedulename as d23name,a25.absschedulename as d24name,a26.absschedulename as d25name,a27.absschedulename as d26name,a28.absschedulename as d27name,a29.absschedulename as d28name,a30.absschedulename as d29name,a31.absschedulename as d30name,a32.absschedulename as d31name,getwfstatusbywfname('appempsched',a0.recordstatus) as statusname  
    from employeeschedule a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join absschedule a2 on a2.absscheduleid = a0.d1
    left join absschedule a3 on a3.absscheduleid = a0.d2
    left join absschedule a4 on a4.absscheduleid = a0.d3
    left join absschedule a5 on a5.absscheduleid = a0.d4
    left join absschedule a6 on a6.absscheduleid = a0.d5
    left join absschedule a7 on a7.absscheduleid = a0.d6
    left join absschedule a8 on a8.absscheduleid = a0.d7
    left join absschedule a9 on a9.absscheduleid = a0.d8
    left join absschedule a10 on a10.absscheduleid = a0.d9
    left join absschedule a11 on a11.absscheduleid = a0.d10
    left join absschedule a12 on a12.absscheduleid = a0.d11
    left join absschedule a13 on a13.absscheduleid = a0.d12
    left join absschedule a14 on a14.absscheduleid = a0.d13
    left join absschedule a15 on a15.absscheduleid = a0.d14
    left join absschedule a16 on a16.absscheduleid = a0.d15
    left join absschedule a17 on a17.absscheduleid = a0.d16
    left join absschedule a18 on a18.absscheduleid = a0.d17
    left join absschedule a19 on a19.absscheduleid = a0.d18
    left join absschedule a20 on a20.absscheduleid = a0.d19
    left join absschedule a21 on a21.absscheduleid = a0.d20
    left join absschedule a22 on a22.absscheduleid = a0.d21
    left join absschedule a23 on a23.absscheduleid = a0.d22
    left join absschedule a24 on a24.absscheduleid = a0.d23
    left join absschedule a25 on a25.absscheduleid = a0.d24
    left join absschedule a26 on a26.absscheduleid = a0.d25
    left join absschedule a27 on a27.absscheduleid = a0.d26
    left join absschedule a28 on a28.absscheduleid = a0.d27
    left join absschedule a29 on a29.absscheduleid = a0.d28
    left join absschedule a30 on a30.absscheduleid = a0.d29
    left join absschedule a31 on a31.absscheduleid = a0.d30
    left join absschedule a32 on a32.absscheduleid = a0.d31
  ";
  protected $sqlcount = "select count(1) 
    from employeeschedule a0 
    left join employee a1 on a1.employeeid = a0.employeeid
    left join absschedule a2 on a2.absscheduleid = a0.d1
    left join absschedule a3 on a3.absscheduleid = a0.d2
    left join absschedule a4 on a4.absscheduleid = a0.d3
    left join absschedule a5 on a5.absscheduleid = a0.d4
    left join absschedule a6 on a6.absscheduleid = a0.d5
    left join absschedule a7 on a7.absscheduleid = a0.d6
    left join absschedule a8 on a8.absscheduleid = a0.d7
    left join absschedule a9 on a9.absscheduleid = a0.d8
    left join absschedule a10 on a10.absscheduleid = a0.d9
    left join absschedule a11 on a11.absscheduleid = a0.d10
    left join absschedule a12 on a12.absscheduleid = a0.d11
    left join absschedule a13 on a13.absscheduleid = a0.d12
    left join absschedule a14 on a14.absscheduleid = a0.d13
    left join absschedule a15 on a15.absscheduleid = a0.d14
    left join absschedule a16 on a16.absscheduleid = a0.d15
    left join absschedule a17 on a17.absscheduleid = a0.d16
    left join absschedule a18 on a18.absscheduleid = a0.d17
    left join absschedule a19 on a19.absscheduleid = a0.d18
    left join absschedule a20 on a20.absscheduleid = a0.d19
    left join absschedule a21 on a21.absscheduleid = a0.d20
    left join absschedule a22 on a22.absscheduleid = a0.d21
    left join absschedule a23 on a23.absscheduleid = a0.d22
    left join absschedule a24 on a24.absscheduleid = a0.d23
    left join absschedule a25 on a25.absscheduleid = a0.d24
    left join absschedule a26 on a26.absscheduleid = a0.d25
    left join absschedule a27 on a27.absscheduleid = a0.d26
    left join absschedule a28 on a28.absscheduleid = a0.d27
    left join absschedule a29 on a29.absscheduleid = a0.d28
    left join absschedule a30 on a30.absscheduleid = a0.d29
    left join absschedule a31 on a31.absscheduleid = a0.d30
    left join absschedule a32 on a32.absscheduleid = a0.d31
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus > 0";
		if ((isset($_REQUEST['fullname'])))
		{				
			$where .= " and a1.fullname like '%". $_REQUEST['fullname']."%'"; 
		}
		if (isset($_REQUEST['employeescheduleid']))
			{
				if (($_REQUEST['employeescheduleid'] !== '0') && ($_REQUEST['employeescheduleid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.employeescheduleid in (".$_REQUEST['employeescheduleid'].")";
					}
					else
					{
						$where .= " and a0.employeescheduleid in (".$_REQUEST['employeescheduleid'].")";
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
			'keyField'=>'employeescheduleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'employeescheduleid','employeeid','month','year','d1','d2','d3','d4','d5','d6','d7','d8','d9','d10','d11','d12','d13','d14','d15','d16','d17','d18','d19','d20','d21','d22','d23','d24','d25','d26','d27','d28','d29','d30','d31','recordstatus'
				),
				'defaultOrder' => array( 
					'employeescheduleid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"recordstatus" =>$this->findstatusbyuser("insempsched")
		));
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
			
			
			for ($i = 5;$i <= $highestRow; $i++)
			{	
				$id = $sheet->getCell('A'.$i)->getValue();
				$employee = $sheet->getCell('B'.$i)->getValue();
                $employeeid = Yii::app()->db->createCommand("select employeeid from employee where fullname = '".$employee."' limit 1")->queryScalar(); 
				if ($employeeid == null)
				{
					$this->getMessage('error','emptyemployeeid');
				}
                $month = $sheet->getCell('C'.$i)->getValue();
				if ($month == null)
				{
					$this->getMessage('error','emptymonth');
				}
				$year = $sheet->getCell('D'.$i)->getValue();
				if ($year == null)
				{
					$this->getMessage('error','emptyyear');
				}
				$d1 = $sheet->getCell('E'.$i)->getValue();
                $d1name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d1."' limit 1")->queryScalar();
                $d2 = $sheet->getCell('F'.$i)->getValue();
                $d2name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d2."' limit 1")->queryScalar();
                $d3 = $sheet->getCell('G'.$i)->getValue();
                $d3name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d3."'  limit 1")->queryScalar();
                $d4 = $sheet->getCell('H'.$i)->getValue();
                $d4name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d4."' limit 1")->queryScalar();
                $d5 = $sheet->getCell('I'.$i)->getValue();
                $d5name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d5."' limit 1")->queryScalar();
                $d6 = $sheet->getCell('J'.$i)->getValue();
                $d6name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d6."' limit 1")->queryScalar();
                $d7 = $sheet->getCell('K'.$i)->getValue();
                $d7name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d7."' limit 1")->queryScalar();
                $d8 = $sheet->getCell('L'.$i)->getValue();
                $d8name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d8."' limit 1")->queryScalar();
                $d9 = $sheet->getCell('M'.$i)->getValue();
                $d9name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d9."' limit 1")->queryScalar();
                $d10 = $sheet->getCell('N'.$i)->getValue();
                $d10name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d10."' limit 1")->queryScalar();
                $d11 = $sheet->getCell('O'.$i)->getValue();
                $d11name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d11."' limit 1")->queryScalar();
                $d12 = $sheet->getCell('P'.$i)->getValue();
                $d12name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d12."' limit 1")->queryScalar();
				$d13 = $sheet->getCell('Q'.$i)->getValue();
                $d13name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d13."' limit 1")->queryScalar();
				$d14 = $sheet->getCell('R'.$i)->getValue();
                $d14name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d14."' limit 1")->queryScalar();
                $d15 = $sheet->getCell('S'.$i)->getValue();
                $d15name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d15."' limit 1")->queryScalar();
                $d16 = $sheet->getCell('T'.$i)->getValue();
                $d16name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d16."' limit 1")->queryScalar();
                $d17 = $sheet->getCell('U'.$i)->getValue();
                $d17name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d17."' limit 1")->queryScalar();
                $d18 = $sheet->getCell('V'.$i)->getValue();
                $d18name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d18."' limit 1")->queryScalar();
                $d19 = $sheet->getCell('W'.$i)->getValue();
                $d19name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d19."' limit 1")->queryScalar();
                $d20 = $sheet->getCell('X'.$i)->getValue();
                $d20name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d20."' limit 1")->queryScalar();
                $d21 = $sheet->getCell('Y'.$i)->getValue();
                $d21name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d21."' limit 1")->queryScalar();
                $d22 = $sheet->getCell('Z'.$i)->getValue();
                $d22name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d22."' limit 1")->queryScalar();
                $d23 = $sheet->getCell('AA'.$i)->getValue();
                $d23name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d23."' limit 1")->queryScalar();
                $d24 = $sheet->getCell('AB'.$i)->getValue();
                $d24name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d24."' limit 1")->queryScalar();
                $d25 = $sheet->getCell('AC'.$i)->getValue();
                $d25name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d25."' limit 1")->queryScalar();
                $d26 = $sheet->getCell('AD'.$i)->getValue();
                $d26name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d26."' limit 1")->queryScalar();
                $d27 = $sheet->getCell('AE'.$i)->getValue();
                $d27name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d27."' limit 1")->queryScalar();
                $d28 = $sheet->getCell('AF'.$i)->getValue();
                $d28name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d28."' limit 1")->queryScalar();
                $d29 = $sheet->getCell('AG'.$i)->getValue();
                $d29name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d29."' limit 1")->queryScalar();
                $d30 = $sheet->getCell('AH'.$i)->getValue();
                $d30name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d30."' limit 1")->queryScalar();
                $d31 = $sheet->getCell('AI'.$i)->getValue();
                $d31name = Yii::app()->db->createCommand("select absscheduleid from absschedule where absschedulename = '".$d31."' limit 1")->queryScalar();
                /*
                if($d29==null || $d30 == null || $d31 == null) {
                    $d29 = null;
                    $d30 = null;
                    $d29 = null;
                }
                */
				if($id!='') {
                    $sql = "call Updateemployeeschedule(:vid,:vemployeeid,:vmonth,:vyear,:vd1,:vd2,:vd3,:vd4,:vd5,:vd6,:vd7,:vd8,:vd9,:vd10,:vd11,:vd12,:vd13,:vd14,:vd15,:vd16,:vd17,:vd18,:vd19,:vd20,:vd21,:vd22,:vd23,:vd24,:vd25,:vd26,:vd27,:vd28,:vd29,:vd30,:vd31,:vcreatedby)";
                    $command = $connection->createCommand($sql);
                    $command->bindvalue(':vid',$id,PDO::PARAM_STR);
                }
                else {
                    $sql = 'call InsertEmployeeSchedule(:vemployeeid,:vmonth,:vyear,:vd1,:vd2,:vd3,:vd4,:vd5,:vd6,:vd7,:vd8,:vd9,:vd10,:vd11,:vd12,:vd13,:vd14,:vd15,:vd16,:vd17,:vd18,:vd19,:vd20,:vd21,:vd22,:vd23,:vd24,:vd25,:vd26,:vd27,:vd28,:vd29,:vd30,:vd31,:vcreatedby)';
                    $command = $connection->createCommand($sql);
                }
				
				
				$command->bindvalue(':vemployeeid',$employeeid,PDO::PARAM_STR);
                $command->bindvalue(':vmonth',$month,PDO::PARAM_STR);
                $command->bindvalue(':vyear',$year,PDO::PARAM_STR);
                $command->bindvalue(':vd1',$d1name,PDO::PARAM_STR);
                $command->bindvalue(':vd2',$d2name,PDO::PARAM_STR);
                $command->bindvalue(':vd3',$d3name,PDO::PARAM_STR);
                $command->bindvalue(':vd4',$d4name,PDO::PARAM_STR);
                $command->bindvalue(':vd5',$d5name,PDO::PARAM_STR);
                $command->bindvalue(':vd6',$d6name,PDO::PARAM_STR);
                $command->bindvalue(':vd7',$d7name,PDO::PARAM_STR);
                $command->bindvalue(':vd8',$d8name,PDO::PARAM_STR);
                $command->bindvalue(':vd9',$d9name,PDO::PARAM_STR);
                $command->bindvalue(':vd10',$d10name,PDO::PARAM_STR);
                $command->bindvalue(':vd11',$d11name,PDO::PARAM_STR);
                $command->bindvalue(':vd12',$d12name,PDO::PARAM_STR);
                $command->bindvalue(':vd13',$d13name,PDO::PARAM_STR);
                $command->bindvalue(':vd14',$d14name,PDO::PARAM_STR);
                $command->bindvalue(':vd15',$d15name,PDO::PARAM_STR);
                $command->bindvalue(':vd16',$d16name,PDO::PARAM_STR);
                $command->bindvalue(':vd17',$d17name,PDO::PARAM_STR);
                $command->bindvalue(':vd18',$d18name,PDO::PARAM_STR);
                $command->bindvalue(':vd19',$d19name,PDO::PARAM_STR);
                $command->bindvalue(':vd20',$d20name,PDO::PARAM_STR);
                $command->bindvalue(':vd21',$d21name,PDO::PARAM_STR);
                $command->bindvalue(':vd22',$d22name,PDO::PARAM_STR);
                $command->bindvalue(':vd23',$d23name,PDO::PARAM_STR);
                $command->bindvalue(':vd24',$d24name,PDO::PARAM_STR);
                $command->bindvalue(':vd25',$d25name,PDO::PARAM_STR);
                $command->bindvalue(':vd26',$d26name,PDO::PARAM_STR);
                $command->bindvalue(':vd27',$d27name,PDO::PARAM_STR);
                $command->bindvalue(':vd28',$d28name,PDO::PARAM_STR);
                $command->bindvalue(':vd29',$d29name,PDO::PARAM_STR);
                $command->bindvalue(':vd30',$d30name,PDO::PARAM_STR);
                $command->bindvalue(':vd31',$d31name,PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
				$command->execute();
			}
			$this->getMessage('success',"alreadysaved");
		}	
		catch (Exception $e)
		{
			$this->getMessage('error',$e->getMessage());
		}		
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.employeescheduleid = '.$id)->queryRow();
			if ($this->CheckDoc($model['recordstatus']) == '')
			{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'employeescheduleid'=>$model['employeescheduleid'],
          'employeeid'=>$model['employeeid'],
          'month'=>$model['month'],
          'year'=>$model['year'],
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
          'recordstatus'=>$model['recordstatus'],
          'fullname'=>$model['fullname'],
          'd1name'=>$model['d1name'],
          'd2name'=>$model['d2name'],
          'd3name'=>$model['d3name'],
          'd4name'=>$model['d4name'],
          'd5name'=>$model['d5name'],
          'd6name'=>$model['d6name'],
          'd7name'=>$model['d7name'],
          'd8name'=>$model['d8name'],
          'd9name'=>$model['d9name'],
          'd10name'=>$model['d10name'],
          'd11name'=>$model['d11name'],
          'd12name'=>$model['d12name'],
          'd13name'=>$model['d13name'],
          'd14name'=>$model['d14name'],
          'd15name'=>$model['d15name'],
          'd16name'=>$model['d16name'],
          'd17name'=>$model['d17name'],
          'd18name'=>$model['d18name'],
          'd19name'=>$model['d19name'],
          'd20name'=>$model['d20name'],
          'd21name'=>$model['d21name'],
          'd22name'=>$model['d22name'],
          'd23name'=>$model['d23name'],
          'd24name'=>$model['d24name'],
          'd25name'=>$model['d25name'],
          'd26name'=>$model['d26name'],
          'd27name'=>$model['d27name'],
          'd28name'=>$model['d28name'],
          'd29name'=>$model['d29name'],
          'd30name'=>$model['d30name'],
          'd31name'=>$model['d31name'],

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
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['employeescheduleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updateemployeeschedule(:vid,:vemployeeid,:vmonth,:vyear,:vd1,:vd2,:vd3,:vd4,:vd5,:vd6,:vd7,:vd8,:vd9,:vd10,:vd11,:vd12,:vd13,:vd14,:vd15,:vd16,:vd17,:vd18,:vd19,:vd20,:vd21,:vd22,:vd23,:vd24,:vd25,:vd26,:vd27,:vd28,:vd29,:vd30,:vd31,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertemployeeschedule(:vemployeeid,:vmonth,:vyear,:vd1,:vd2,:vd3,:vd4,:vd5,:vd6,:vd7,:vd8,:vd9,:vd10,:vd11,:vd12,:vd13,:vd14,:vd15,:vd16,:vd17,:vd18,:vd19,:vd20,:vd21,:vd22,:vd23,:vd24,:vd25,:vd26,:vd27,:vd28,:vd29,:vd30,:vd31,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['employeescheduleid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vemployeeid',(($_POST['employeeid']!=='')?$_POST['employeeid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmonth',(($_POST['month']!=='')?$_POST['month']:null),PDO::PARAM_STR);
                $command->bindvalue(':vyear',(($_POST['year']!=='')?$_POST['year']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd1',(($_POST['d1']!=='')?$_POST['d1']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd2',(($_POST['d2']!=='')?$_POST['d2']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd3',(($_POST['d3']!=='')?$_POST['d3']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd4',(($_POST['d4']!=='')?$_POST['d4']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd5',(($_POST['d5']!=='')?$_POST['d5']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd6',(($_POST['d6']!=='')?$_POST['d6']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd7',(($_POST['d7']!=='')?$_POST['d7']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd8',(($_POST['d8']!=='')?$_POST['d8']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd9',(($_POST['d9']!=='')?$_POST['d9']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd10',(($_POST['d10']!=='')?$_POST['d10']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd11',(($_POST['d11']!=='')?$_POST['d11']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd12',(($_POST['d12']!=='')?$_POST['d12']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd13',(($_POST['d13']!=='')?$_POST['d13']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd14',(($_POST['d14']!=='')?$_POST['d14']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd15',(($_POST['d15']!=='')?$_POST['d15']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd16',(($_POST['d16']!=='')?$_POST['d16']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd17',(($_POST['d17']!=='')?$_POST['d17']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd18',(($_POST['d18']!=='')?$_POST['d18']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd19',(($_POST['d19']!=='')?$_POST['d19']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd20',(($_POST['d20']!=='')?$_POST['d20']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd21',(($_POST['d21']!=='')?$_POST['d21']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd22',(($_POST['d22']!=='')?$_POST['d22']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd23',(($_POST['d23']!=='')?$_POST['d23']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd24',(($_POST['d24']!=='')?$_POST['d24']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd25',(($_POST['d25']!=='')?$_POST['d25']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd26',(($_POST['d26']!=='')?$_POST['d26']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd27',(($_POST['d27']!=='')?$_POST['d27']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd28',(($_POST['d28']!=='')?$_POST['d28']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd29',(($_POST['d29']!=='')?$_POST['d29']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd30',(($_POST['d30']!=='')?$_POST['d30']:null),PDO::PARAM_STR);
                $command->bindvalue(':vd31',(($_POST['d31']!=='')?$_POST['d31']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
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
				$sql = 'call ApproveEmployeeSchedule(:vid,:vcreatedby)';
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
				$sql = 'call Deleteemployeeschedule(:vid,:vcreatedby)';
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
	
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();

		//masukkan judul
		$this->pdf->title=$this->getCatalog('employeeschedule');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('employeescheduleid'),$this->getCatalog('employee'),$this->getCatalog('month'),$this->getCatalog('year'),$this->getCatalog('d1'),$this->getCatalog('d2'),$this->getCatalog('d3'),$this->getCatalog('d4'),$this->getCatalog('d5'),$this->getCatalog('d6'),$this->getCatalog('d7'),$this->getCatalog('d8'),$this->getCatalog('d9'),$this->getCatalog('d10'),$this->getCatalog('d11'),$this->getCatalog('d12'),$this->getCatalog('d13'),$this->getCatalog('d14'),$this->getCatalog('d15'),$this->getCatalog('d16'),$this->getCatalog('d17'),$this->getCatalog('d18'),$this->getCatalog('d19'),$this->getCatalog('d20'),$this->getCatalog('d21'),$this->getCatalog('d22'),$this->getCatalog('d23'),$this->getCatalog('d24'),$this->getCatalog('d25'),$this->getCatalog('d26'),$this->getCatalog('d27'),$this->getCatalog('d28'),$this->getCatalog('d29'),$this->getCatalog('d30'),$this->getCatalog('d31'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['employeescheduleid'],$row1['fullname'],$row1['month'],$row1['year'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['absschedulename'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('employeescheduleid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('month'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('year'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('d1'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('d2'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('d3'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('d4'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('d5'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('d6'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('d7'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('d8'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('d9'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('d10'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('d11'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('d12'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('d13'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('d14'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('d15'))
->setCellValueByColumnAndRow(19,4,$this->getCatalog('d16'))
->setCellValueByColumnAndRow(20,4,$this->getCatalog('d17'))
->setCellValueByColumnAndRow(21,4,$this->getCatalog('d18'))
->setCellValueByColumnAndRow(22,4,$this->getCatalog('d19'))
->setCellValueByColumnAndRow(23,4,$this->getCatalog('d20'))
->setCellValueByColumnAndRow(24,4,$this->getCatalog('d21'))
->setCellValueByColumnAndRow(25,4,$this->getCatalog('d22'))
->setCellValueByColumnAndRow(26,4,$this->getCatalog('d23'))
->setCellValueByColumnAndRow(27,4,$this->getCatalog('d24'))
->setCellValueByColumnAndRow(28,4,$this->getCatalog('d25'))
->setCellValueByColumnAndRow(29,4,$this->getCatalog('d26'))
->setCellValueByColumnAndRow(30,4,$this->getCatalog('d27'))
->setCellValueByColumnAndRow(31,4,$this->getCatalog('d28'))
->setCellValueByColumnAndRow(32,4,$this->getCatalog('d29'))
->setCellValueByColumnAndRow(33,4,$this->getCatalog('d30'))
->setCellValueByColumnAndRow(34,4,$this->getCatalog('d31'))
->setCellValueByColumnAndRow(35,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['employeescheduleid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['month'])
->setCellValueByColumnAndRow(3, $i+1, $row1['year'])
->setCellValueByColumnAndRow(4, $i+1, $row1['d1name'])
->setCellValueByColumnAndRow(5, $i+1, $row1['d2name'])
->setCellValueByColumnAndRow(6, $i+1, $row1['d3name'])
->setCellValueByColumnAndRow(7, $i+1, $row1['d4name'])
->setCellValueByColumnAndRow(8, $i+1, $row1['d5name'])
->setCellValueByColumnAndRow(9, $i+1, $row1['d6name'])
->setCellValueByColumnAndRow(10, $i+1, $row1['d7name'])
->setCellValueByColumnAndRow(11, $i+1, $row1['d8name'])
->setCellValueByColumnAndRow(12, $i+1, $row1['d9name'])
->setCellValueByColumnAndRow(13, $i+1, $row1['d10name'])
->setCellValueByColumnAndRow(14, $i+1, $row1['d11name'])
->setCellValueByColumnAndRow(15, $i+1, $row1['d12name'])
->setCellValueByColumnAndRow(16, $i+1, $row1['d13name'])
->setCellValueByColumnAndRow(17, $i+1, $row1['d14name'])
->setCellValueByColumnAndRow(18, $i+1, $row1['d15name'])
->setCellValueByColumnAndRow(19, $i+1, $row1['d16name'])
->setCellValueByColumnAndRow(20, $i+1, $row1['d17name'])
->setCellValueByColumnAndRow(21, $i+1, $row1['d18name'])
->setCellValueByColumnAndRow(22, $i+1, $row1['d19name'])
->setCellValueByColumnAndRow(23, $i+1, $row1['d20name'])
->setCellValueByColumnAndRow(24, $i+1, $row1['d21name'])
->setCellValueByColumnAndRow(25, $i+1, $row1['d22name'])
->setCellValueByColumnAndRow(26, $i+1, $row1['d23name'])
->setCellValueByColumnAndRow(27, $i+1, $row1['d24name'])
->setCellValueByColumnAndRow(28, $i+1, $row1['d25name'])
->setCellValueByColumnAndRow(29, $i+1, $row1['d26name'])
->setCellValueByColumnAndRow(30, $i+1, $row1['d27name'])
->setCellValueByColumnAndRow(31, $i+1, $row1['d28name'])
->setCellValueByColumnAndRow(32, $i+1, $row1['d29name'])
->setCellValueByColumnAndRow(33, $i+1, $row1['d30name'])
->setCellValueByColumnAndRow(34, $i+1, $row1['d31name'])
->setCellValueByColumnAndRow(35, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}