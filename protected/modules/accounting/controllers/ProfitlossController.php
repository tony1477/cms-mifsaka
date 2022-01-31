<?php

class ProfitlossController extends AdminController
{
	protected $menuname = 'profitloss';
	public $module = 'Accounting';
	protected $pageTitle = 'Laporan P/L';
	public $wfname = '';
	protected $sqldata = "select a0.repprofitlossid,a0.companyid,a0.accountid,a0.isdebet,a0.accformula,a0.performula,a0.aftacc,a0.nourut,a0.recordstatus,a1.companyname as companyname,a2.accountname as accountname 
    from repprofitloss a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.accountid
  ";
  protected $sqlcount = "select count(1) 
    from repprofitloss a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.accountid
  ";
	protected function getSQL()	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['accformula'])) && (isset($_REQUEST['performula'])) && (isset($_REQUEST['companyid'])) && (isset($_REQUEST['accountname'])))
		{				
			$where .= " where a0.accformula like '%". $_REQUEST['accformula']."%' 
and a0.performula like '%". $_REQUEST['performula']."%' 
and a1.companyid like '%". $_REQUEST['companyid']."%' 
and a2.accountname like '%". $_REQUEST['accountname']."%'"; 
		}
		if (isset($_REQUEST['repprofitlossid']))
		{
			if (($_REQUEST['repprofitlossid'] !== '0') && ($_REQUEST['repprofitlossid'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.repprofitlossid in (".$_REQUEST['repprofitlossid'].")";
				}
				else
				{
					$where .= " and a0.repprofitlossid in (".$_REQUEST['repprofitlossid'].")";
				}
			}
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionIndex()	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'repprofitlossid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'repprofitlossid','companyid','accountid','isdebet','accformula','performula','aftacc','nourut','recordstatus'
				),
				'defaultOrder' => array( 
					'repprofitlossid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
  public function getIndex() {
    $this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
      'totalItemCount'=>$this->count,
      'keyField'=>'repprofitlossid',
      'pagination'=>array(
        'pageSize'=>$this->getParameter('DefaultPageSize'),
        'pageVar'=>'page',
      ),
      'sort'=>array(
        'attributes'=>array(
                    'repprofitlossid','companyid','accountid','isdebet','accformula','performula','aftacc','nourut','recordstatus'
        ),
        'defaultOrder' => array( 
          'repprofitlossid' => CSort::SORT_DESC
        ),
      ),
    ));
        return $dataProvider;
    }
	public function actionCreate() {
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			
		));
	}
	public function actionUpdate() {
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.repprofitlossid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'repprofitlossid'=>$model['repprofitlossid'],
          'companyid'=>$model['companyid'],
          'accountid'=>$model['accountid'],
          'isdebet'=>$model['isdebet'],
          'accformula'=>$model['accformula'],
          'performula'=>$model['performula'],
          'aftacc'=>$model['aftacc'],
          'nourut'=>$model['nourut'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'accountname'=>$model['accountname'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave() {
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('accountid','string','emptyaccountid'),
      array('isdebet','string','emptyisdebet'),
      array('accformula','string','emptyaccformula'),
      array('performula','string','emptyperformula'),
      array('nourut','string','emptynourut'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['repprofitlossid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update repprofitloss 
			      set companyid = :companyid,accountid = :accountid,isdebet = :isdebet,accformula = :accformula,performula = :performula,aftacc = :aftacc,nourut = :nourut,recordstatus = :recordstatus 
			      where repprofitlossid = :repprofitlossid';
				}
				else
				{
					$sql = 'insert into repprofitloss (companyid,accountid,isdebet,accformula,performula,aftacc,nourut,recordstatus) 
			      values (:companyid,:accountid,:isdebet,:accformula,:performula,:aftacc,:nourut,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':repprofitlossid',$_POST['repprofitlossid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':isdebet',(($_POST['isdebet']!=='')?$_POST['isdebet']:null),PDO::PARAM_STR);
        $command->bindvalue(':accformula',(($_POST['accformula']!=='')?$_POST['accformula']:null),PDO::PARAM_STR);
        $command->bindvalue(':performula',(($_POST['performula']!=='')?$_POST['performula']:null),PDO::PARAM_STR);
        $command->bindvalue(':aftacc',(($_POST['aftacc']!=='')?$_POST['aftacc']:null),PDO::PARAM_STR);
        $command->bindvalue(':nourut',(($_POST['nourut']!=='')?$_POST['nourut']:null),PDO::PARAM_STR);
        $command->bindvalue(':recordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
	public function actionDelete() {
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
					$sql = "select recordstatus from repprofitloss where repprofitlossid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update repprofitloss set recordstatus = 0 where repprofitlossid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update repprofitloss set recordstatus = 1 where repprofitlossid = ".$id[$i];
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
	public function actionPurge() {
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
				$sql = "delete from repprofitloss where repprofitlossid = ".$id[$i];
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
	public function actionGenerate() {
    parent::actionCreate();
		$sql = "call InsertPLLajur(" . $_REQUEST['companyname'] . ", '" . date(Yii::app()->params['datetodb'], strtotime($_REQUEST['date'])) . "')";
    Yii::app()->db->createCommand($sql)->execute();
		$this->GetMessage('success', 'alreadysaved');
  }
	public function actionGenerate1() {
    parent::actionCreate();
		$sql = "call InsertPLLajurTahun(" . $_REQUEST['companyname'] . ", '" . date(Yii::app()->params['datetodb'], strtotime($_REQUEST['date'])) . "')";
    Yii::app()->db->createCommand($sql)->execute();
		$this->GetMessage('success', 'alreadysaved');
  }
	public function actionDownPDF() {
		parent::actionDownPDF();
		//masukkan perintah download
		$connection=Yii::app()->db;
		//$sql = "call InsertProfitLossLajur('".$_GET['companyid']."','".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')";
		//Yii::app()->db->createCommand($sql)->execute();
		
		//masukkan judul
		$this->pdf->companyid = $_GET['companyid'];
    $this->pdf->AddPage('L');
    $this->pdf->Cell(0, 0, $this->getcatalog('profitloss'), 0, 0, 'C');
    $this->pdf->Cell(-277, 10, 'Per : ' . date("t F Y", strtotime($_GET['date'])), 0, 0, 'C');
    $i = 0;
    $this->pdf->setFont('Arial', 'B', 6);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign  = array(
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->colheader = array(
      '',
      'Bulan Ini',
      'Bulan Lalu',
      'Akumulatif  s/d  Bulan Ini'
    );
    $this->pdf->setwidths(array(
      50,
      92,
      40,
      92
    ));
    $this->pdf->Rowheader();
    $this->pdf->colalign  = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C'
    );
    $this->pdf->colheader = array(
      'Keterangan',
      'Budget',
      '%',
      'Actual',
      '%',
      'Penc %',
      'Actual',
      '%',
      'Budget',
      '%',
      'Actual',
      '%',
      'Penc %'
    );
    $this->pdf->setwidths(array(
      50,
      28,
      12,
      28,
      12,
      12,
      28,
      12,
      28,
      12,
      28,
      12,
      12
    ));
    $this->pdf->Rowheader();
    $this->pdf->coldetailalign = array(
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R'
    );
    $sql                       = "select a.*
			from repprofitlosslajur a 
			where a.companyid = '" . $_GET['companyid'] . "' 
			and a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			order by jumlah";
    $datas                     = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($datas as $data) {
      if (($data['accountid'] !== null) && (strpos($data['accountname'], 'Total') === false)) {
        $this->pdf->setFont('Arial', '', 6);
        $this->pdf->row(array(
          $data['accountname'],
          Yii::app()->format->formatNumber($data['budgetblninitotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['budgetblninipersen']),
          Yii::app()->format->formatNumber($data['actualblninitotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualblninipersen']),
          Yii::app()->format->formatNumber($data['pencpersen']),
          Yii::app()->format->formatNumber($data['actualblnlalutotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualblnlalupersen']),
          Yii::app()->format->formatNumber($data['budgetakumtotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['budgetakumpersen']),
          Yii::app()->format->formatNumber($data['actualakumtotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualakumpersen']),
          Yii::app()->format->formatNumber($data['pencakumpersen'])
        ));
      } else if ($data['accountid'] == null) {
        $this->pdf->setFont('Arial', 'B', 6);
        $this->pdf->row(array(
          $data['accountname'],
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          '',
          ''
        ));
      } else {
        $this->pdf->setFont('Arial', 'B', 6);
        $this->pdf->row(array(
          $data['accountname'],
          Yii::app()->format->formatNumber($data['budgetblninitotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['budgetblninipersen']),
          Yii::app()->format->formatNumber($data['actualblninitotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualblninipersen']),
          Yii::app()->format->formatNumber($data['pencpersen']),
          Yii::app()->format->formatNumber($data['actualblnlalutotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualblnlalupersen']),
          Yii::app()->format->formatNumber($data['budgetakumtotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['budgetakumpersen']),
          Yii::app()->format->formatNumber($data['actualakumtotal']/$_GET['per']),
          Yii::app()->format->formatNumber($data['actualakumpersen']),
          Yii::app()->format->formatNumber($data['pencakumpersen'])
        ));
      }
      $this->pdf->sety($this->pdf->gety() - 2);
    }
    $this->pdf->Output();
	}
	public function actionDownXLS() {
		$this->menuname='laporanlabarugi';
		parent::actionDownXLS();
		/*$sql = "call InsertProfitLossLajur('".$_GET['companyid']."','".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')"; 
		$command = Yii::app()->db->createCommand($sql);	
		$command->execute();*/

		$sql                       = "select a.*
			from repprofitlosslajur a 
			where a.companyid = '" . $_GET['companyid'] . "' 
			and a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			order by jumlah";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		$i=6;

		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, 2,date(Yii::app()->params['dateviewfromdb'], strtotime($_GET['date'])));
			
		foreach($dataReader as $row1)
		{
      $this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i + 1, $row1['accountname'])->setCellValueByColumnAndRow(1, $i + 1, $row1['budgetblninitotal']/$_GET['per'])->setCellValueByColumnAndRow(2, $i + 1, $row1['budgetblninipersen'])->setCellValueByColumnAndRow(3, $i + 1, $row1['actualblninitotal']/$_GET['per'])->setCellValueByColumnAndRow(4, $i + 1, $row1['actualblninipersen'])->setCellValueByColumnAndRow(5, $i + 1, $row1['pencpersen'])->setCellValueByColumnAndRow(6, $i + 1, $row1['actualblnlalutotal']/$_GET['per'])->setCellValueByColumnAndRow(7, $i + 1, $row1['actualblnlalupersen'])->setCellValueByColumnAndRow(8, $i + 1, $row1['budgetakumtotal']/$_GET['per'])->setCellValueByColumnAndRow(9, $i + 1, $row1['budgetakumpersen'])->setCellValueByColumnAndRow(10, $i + 1, $row1['actualakumtotal']/$_GET['per'])->setCellValueByColumnAndRow(11, $i + 1, $row1['actualakumpersen'])->setCellValueByColumnAndRow(12, $i + 1, $row1['pencakumpersen']);
      $i += 1;
    }		
		$this->getFooterXLS($this->phpExcel);
	}
	public function actionDownPDF1() {
    parent::actionDownPDF();
    $connection = Yii::app()->db;
    //$sql        = "call InsertPLLajur('" . $_GET['company'] . "','" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')";
    //$this->connection->createCommand($sql)->execute();
    $this->pdf->companyid = $_GET['companyid'];
    $this->pdf->AddPage('L',array(200,775));
    $this->pdf->Cell(0, 0, GetCatalog('profitloss'), 0, 0, 'C');
    $this->pdf->Cell(-277, 10, 'Per : ' . date("t F Y", strtotime($_GET['date'])), 0, 0, 'C');
    $i = 0;
    $this->pdf->setFont('Arial', 'B', 6);
    $this->pdf->sety($this->pdf->gety() + 10);
    $this->pdf->colalign  = array(
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
      'C',
    );
    $this->pdf->colheader = array(
      'Keterangan',
      'Januari',
      '%',
      'Februari',
      '%',
      'Maret',
      '%',
      'Triwulan I',
      '%',
      'April',
      '%',
      'Mei',
      '%',
      'Juni',
      '%',
      'Triwulan II',
      '%',
      'Semester I',
      '%',
      'Juli',
      '%',
      'Agustus',
      '%',
      'September',
      '%',
      'Triwulan III',
      '%',
      'Oktober',
      '%',
      'Nopember',
      '%',
      'Desember',
      '%',
      'Triwulan IV',
      '%',
      'Semester II',
      '%',
      'Total',
      '%'
    );
    $this->pdf->setwidths(array(
      50,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
      25,
      12,
    ));
    $this->pdf->Rowheader();
    $this->pdf->coldetailalign = array(
      'L',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
      'R',
    );
    $sql = "select accountid,accountname,jan,janper,feb,febper,mar,marper,tri1,tri1per,
				apr,aprper,mei,meiper,jun,junper,tri2,tri2per,sem1,sem1per,
				jul,julper,ags,agsper,sep,sepper,tri3,tri3per,
				okt,oktper,nop,nopper,des,desper,tri4,tri4per,sem2,sem2per,total,totalper
			from repprofitlosslajurtahun
			where companyid = '" . $_GET['companyid'] . "' 
			and tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			order by jumlah";
    $datas = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($datas as $data) {
      if (($data['accountid'] !== null) && (strpos($data['accountname'], 'Total') === false)) {
        $this->pdf->setFont('Arial', '', 6);
        $this->pdf->row(array(
          $data['accountname'],
					Yii::app()->format->formatCurrency($data['jan']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['janper']),
					Yii::app()->format->formatCurrency($data['feb']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['febper']),
					Yii::app()->format->formatCurrency($data['mar']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['marper']),
					Yii::app()->format->formatCurrency($data['tri1']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri1per']),
					Yii::app()->format->formatCurrency($data['apr']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['aprper']),
					Yii::app()->format->formatCurrency($data['mei']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['meiper']),
					Yii::app()->format->formatCurrency($data['jun']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['junper']),
					Yii::app()->format->formatCurrency($data['tri2']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri2per']),
					Yii::app()->format->formatCurrency($data['sem1']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sem1per']),
					Yii::app()->format->formatCurrency($data['jul']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['julper']),
					Yii::app()->format->formatCurrency($data['ags']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['agsper']),
					Yii::app()->format->formatCurrency($data['sep']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sepper']),
					Yii::app()->format->formatCurrency($data['tri3']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri3per']),
					Yii::app()->format->formatCurrency($data['okt']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['oktper']),
					Yii::app()->format->formatCurrency($data['nop']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['nopper']),
					Yii::app()->format->formatCurrency($data['des']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['desper']),
					Yii::app()->format->formatCurrency($data['tri4']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri4per']),
					Yii::app()->format->formatCurrency($data['sem2']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sem2per']),
					Yii::app()->format->formatCurrency($data['total']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['totalper']),
          //Yii::app()->format->formatCurrency($data['pencakumpersen'])
        ));
      } else if ($data['accountid'] == null) {
        $this->pdf->setFont('Arial', 'B', 6);
        $this->pdf->row(array(
          $data['accountname'],
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
        ));
      } else {
        $this->pdf->setFont('Arial', 'B', 6);
        $this->pdf->row(array(
          $data['accountname'],
					Yii::app()->format->formatCurrency($data['jan']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['janper']),
					Yii::app()->format->formatCurrency($data['feb']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['febper']),
					Yii::app()->format->formatCurrency($data['mar']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['marper']),
					Yii::app()->format->formatCurrency($data['tri1']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri1per']),
					Yii::app()->format->formatCurrency($data['apr']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['aprper']),
					Yii::app()->format->formatCurrency($data['mei']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['meiper']),
					Yii::app()->format->formatCurrency($data['jun']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['junper']),
					Yii::app()->format->formatCurrency($data['tri2']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri2per']),
					Yii::app()->format->formatCurrency($data['sem1']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sem1per']),
					Yii::app()->format->formatCurrency($data['jul']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['julper']),
					Yii::app()->format->formatCurrency($data['ags']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['agsper']),
					Yii::app()->format->formatCurrency($data['sep']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sepper']),
					Yii::app()->format->formatCurrency($data['tri3']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri3per']),
					Yii::app()->format->formatCurrency($data['okt']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['oktper']),
					Yii::app()->format->formatCurrency($data['nop']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['nopper']),
					Yii::app()->format->formatCurrency($data['des']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['desper']),
					Yii::app()->format->formatCurrency($data['tri4']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['tri4per']),
					Yii::app()->format->formatCurrency($data['sem2']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['sem2per']),
					Yii::app()->format->formatCurrency($data['total']/$_GET['per']),
					Yii::app()->format->formatCurrency($data['totalper']),
        ));
      }
      $this->pdf->sety($this->pdf->gety() - 2);
    }
    $this->pdf->Output();
  }
  public function actionDownXls1() {
    $this->menuname = 'laporanlabarugitahun';
    parent::actionDownXls();
		$sql2 = "select a.companycode
							from company a
							where a.companyid = " . $_GET['companyid'] . "
		";
    $company = Yii::app()->db->createCommand($sql2)->queryScalar();
		
    $sql = "select accountid,accountname,jan,janper,feb,febper,mar,marper,tri1,tri1per,
				apr,aprper,mei,meiper,jun,junper,tri2,tri2per,sem1,sem1per,
				jul,julper,ags,agsper,sep,sepper,tri3,tri3per,
				okt,oktper,nop,nopper,des,desper,tri4,tri4per,sem2,sem2per,total,totalper
			from repprofitlosslajurtahun
			where companyid = " . $_GET['companyid'] . "
			and tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			order by jumlah";
    $dataReader = Yii::app()->db->createCommand($sql)->queryAll();
    $i          = 5;
    $this->phpExcel->setActiveSheetIndex(0)
		->setCellValueByColumnAndRow(0, 2, date('Y',strtotime($_GET['date'])))
    ->setCellValueByColumnAndRow(0, 3, $company);
    foreach ($dataReader as $row1) 
		{
      $this->phpExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(0, $i + 1, $row1['accountname'])
			->setCellValueByColumnAndRow(1, $i + 1, $row1['jan'])
			->setCellValueByColumnAndRow(2, $i + 1, $row1['janper'])
			->setCellValueByColumnAndRow(3, $i + 1, $row1['feb'])
			->setCellValueByColumnAndRow(4, $i + 1, $row1['febper'])
			->setCellValueByColumnAndRow(5, $i + 1, $row1['mar'])
			->setCellValueByColumnAndRow(6, $i + 1, $row1['marper'])
			->setCellValueByColumnAndRow(7, $i + 1, $row1['tri1'])
			->setCellValueByColumnAndRow(8, $i + 1, $row1['tri1per'])
			->setCellValueByColumnAndRow(9, $i + 1, $row1['apr'])
			->setCellValueByColumnAndRow(10, $i + 1, $row1['aprper'])
			->setCellValueByColumnAndRow(11, $i + 1, $row1['mei'])
			->setCellValueByColumnAndRow(12, $i + 1, $row1['meiper'])
			->setCellValueByColumnAndRow(13, $i + 1, $row1['jun'])
			->setCellValueByColumnAndRow(14, $i + 1, $row1['junper'])
			->setCellValueByColumnAndRow(15, $i + 1, $row1['tri2'])
			->setCellValueByColumnAndRow(16, $i + 1, $row1['tri2per'])
			->setCellValueByColumnAndRow(17, $i + 1, $row1['sem1'])
			->setCellValueByColumnAndRow(18, $i + 1, $row1['sem1per'])
			->setCellValueByColumnAndRow(19, $i + 1, $row1['jul'])
			->setCellValueByColumnAndRow(20, $i + 1, $row1['julper'])
			->setCellValueByColumnAndRow(21, $i + 1, $row1['ags'])
			->setCellValueByColumnAndRow(22, $i + 1, $row1['agsper'])
			->setCellValueByColumnAndRow(23, $i + 1, $row1['sep'])
			->setCellValueByColumnAndRow(24, $i + 1, $row1['sepper'])
			->setCellValueByColumnAndRow(25, $i + 1, $row1['tri3'])
			->setCellValueByColumnAndRow(26, $i + 1, $row1['tri3per'])
			->setCellValueByColumnAndRow(27, $i + 1, $row1['okt'])
			->setCellValueByColumnAndRow(28, $i + 1, $row1['oktper'])
			->setCellValueByColumnAndRow(29, $i + 1, $row1['nop'])
			->setCellValueByColumnAndRow(30, $i + 1, $row1['nopper'])
			->setCellValueByColumnAndRow(31, $i + 1, $row1['des'])
			->setCellValueByColumnAndRow(32, $i + 1, $row1['desper'])
			->setCellValueByColumnAndRow(33, $i + 1, $row1['tri4'])
			->setCellValueByColumnAndRow(34, $i + 1, $row1['tri4per'])
			->setCellValueByColumnAndRow(35, $i + 1, $row1['sem2'])
			->setCellValueByColumnAndRow(36, $i + 1, $row1['sem2per'])
			->setCellValueByColumnAndRow(37, $i + 1, $row1['total'])
			->setCellValueByColumnAndRow(38, $i + 1, $row1['totalper']);
      $i += 1;
    }
    $this->getFooterXLS($this->phpExcel);
  }
	public function actionDownLabaRugiUjiCobaPDF() {
        parent::actionDownload();
		$i=0;$bulanini=0;$bulanlalu=0;
        $companyid = $_GET['company'];
        $per = $_GET['per'];
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')
					and year(c.journaldate) = year('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')
					group by accountid asc),0) as bulanini,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."',interval 1 month)))
					and year(c.journaldate) = year(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."',interval 1 month)))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode > '3%'
					) z where z.bulanini <> 0 or z.bulanlalu <> 0
					order by accountcode asc";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		
		foreach($dataReader as $row)
		{
				$this->pdf->companyid = $companyid;
		}
		$this->pdf->title='Laba (Rugi) - Uji Coba';
		$this->pdf->subtitle = 'Per Tanggal : '.date(Yii::app()->params['datetodb'], strtotime($_GET['date']));
		$this->pdf->AddPage('P');

		$this->pdf->sety($this->pdf->gety());
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C');
		$this->pdf->setwidths(array(10,80,30,35,35));
		$this->pdf->colheader = array('No','Nama Akun','Kode Akun','Bulan Ini','Bulan Lalu');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('R','L','L','R','R');
		
		foreach($dataReader as $row)
		{
			$this->pdf->SetFont('Arial','',8);
			$i+=1;
			$this->pdf->row(array(
				$i,$row['accountname'],
				$row['accountcode'],
				Yii::app()->format->formatCurrency($row['bulanini']/$per),
				Yii::app()->format->formatCurrency($row['bulanlalu']/$per),
			));
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
			$this->pdf->checkPageBreak(10);
		}
		$this->pdf->SetFont('Arial','BI',8);
		$this->pdf->row(array(
			'','LABA (RUGI) BERSIH',
			'',
			Yii::app()->format->formatCurrency($bulanini),
			Yii::app()->format->formatCurrency($bulanlalu),
		));
				
		$this->pdf->Output();
  }
  public function actionDownLabaRugiUjiCobaXLS() {
        $this->menuname='labarugiujicoba';
		parent::actionDownxls();
        $companyid = $_GET['company'];
        $per = $_GET['per'];
		$sql = "select * from(select a.accountid,a.companyid,a.accountcode,a.accountname,a.parentaccountid,a.currencyid,a.accounttypeid,a.recordstatus,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')
					and year(c.journaldate) = year('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."')
					group by accountid asc),0) as bulanini,
					ifnull((select -1*(sum(b.debit*b.ratevalue)-sum(b.credit*b.ratevalue))
					from genledger b
					join genjournal c on c.genjournalid=b.genjournalid
					where b.accountid = a.accountid and month(c.journaldate) = month(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."',interval 1 month)))
					and year(c.journaldate) = year(last_day(date_sub('".date(Yii::app()->params['datetodb'], strtotime($_GET['date']))."',interval 1 month)))
					group by accountid asc),0) as bulanlalu
					from account a
					where a.companyid = '".$companyid."' and a.accountcode > '3%'
					) z where z.bulanini <> 0 or z.bulanlalu <> 0
					order by accountcode asc";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		
		$this->phpExcel->setActiveSheetIndex(0)			
			->setCellValueByColumnAndRow(1,2,date(Yii::app()->params['datetodb'], strtotime($_GET['date'])))
			->setCellValueByColumnAndRow(4,1,getcompanycode($companyid));
		$line=4;
		$i=0;$bulanini=0;$bulanlalu=0;			
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,'No')
					->setCellValueByColumnAndRow(1,$line,'Nama Akun')
					->setCellValueByColumnAndRow(2,$line,'Kode Akun')					
					->setCellValueByColumnAndRow(3,$line,'Bulan Ini')
					->setCellValueByColumnAndRow(4,$line,'Bulan Lalu');
		$line++;
		
		foreach($dataReader as $row)
		{
			$i+=1;
			$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,$line,$i)
					->setCellValueByColumnAndRow(1,$line,$row['accountname'])
					->setCellValueByColumnAndRow(2,$line,$row['accountcode'])
					->setCellValueByColumnAndRow(3,$line,$row['bulanini']/$per)
					->setCellValueByColumnAndRow(4,$line,$row['bulanlalu']/$per);
			$line++;
			
			$bulanini += $row['bulanini']/$per;
			$bulanlalu += $row['bulanlalu']/$per;
		}
		$this->phpExcel->setActiveSheetIndex(0)	
					->setCellValueByColumnAndRow(1,$line,'LABA (RUGI) BERSIH')			
					->setCellValueByColumnAndRow(3,$line,$bulanini)										
					->setCellValueByColumnAndRow(4,$line,$bulanlalu);
		$line++;
		
		$this->getFooterXLS($this->phpExcel);
  }
}