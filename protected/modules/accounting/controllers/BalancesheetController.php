<?php

class BalancesheetController extends AdminController
{
	protected $menuname = 'balancesheet';
	public $module = 'Accounting';
	protected $pageTitle = 'Laporan Neraca';
	public $wfname = '';
	protected $sqldata = "select a0.repneracaid,a0.companyid,a0.accountid,a0.isdebet,a0.accformula,a0.aftacc,a0.nourut,a0.recordstatus,a1.companyname as companyname,a2.accountname as accountname 
    from repneraca a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.accountid
  ";
  protected $sqlcount = "select count(1) 
    from repneraca a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.accountid
  ";
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['accformula'])) && (isset($_REQUEST['companyname'])) && (isset($_REQUEST['accountname'])))
		{				
			$where .= " where a0.accformula like '%". $_REQUEST['accformula']."%' 
and a1.companyid like '%". $_REQUEST['companyname']."%' 
and a2.accountname like '%". $_REQUEST['accountname']."%'"; 
		}
		if (isset($_REQUEST['repneracaid']))
		{
			if (($_REQUEST['repneracaid'] !== '0') && ($_REQUEST['repneracaid'] !== ''))
			{
				if ($where == "")
				{
					$where .= " where a0.repneracaid in (".$_REQUEST['repneracaid'].")";
				}
				else
				{
					$where .= " and a0.repneracaid in (".$_REQUEST['repneracaid'].")";
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
			'keyField'=>'repneracaid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'repneracaid','companyid','accountid','isdebet','accformula','aftacc','nourut','recordstatus'
				),
				'defaultOrder' => array( 
					'repneracaid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
  public function getIndex(){
  $this->getSQL();
  $dataProvider=new CSqlDataProvider($this->sqldata,array(
    'totalItemCount'=>$this->count,
    'keyField'=>'repneracaid',
    'pagination'=>array(
      'pageSize'=>$this->getParameter('DefaultPageSize'),
      'pageVar'=>'page',
    ),
    'sort'=>array(
      'attributes'=>array(
                  'repneracaid','companyid','accountid','isdebet','accformula','aftacc','nourut','recordstatus'
      ),
      'defaultOrder' => array( 
        'repneracaid' => CSort::SORT_DESC
      ),
    ),
  ));
      return $dataProvider;
  }
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.repneracaid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'repneracaid'=>$model['repneracaid'],
          'companyid'=>$model['companyid'],
          'accountid'=>$model['accountid'],
          'isdebet'=>$model['isdebet'],
          'accformula'=>$model['accformula'],
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
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyid','string','emptycompanyid'),
      array('accountid','string','emptyaccountid'),
      array('isdebet','string','emptyisdebet'),
      array('accformula','string','emptyaccformula'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['repneracaid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update repneraca 
			      set companyid = :companyid,accountid = :accountid,isdebet = :isdebet,accformula = :accformula,aftacc = :aftacc,nourut = :nourut,recordstatus = :recordstatus 
			      where repneracaid = :repneracaid';
				}
				else
				{
					$sql = 'insert into repneraca (companyid,accountid,isdebet,accformula,aftacc,nourut,recordstatus) 
			      values (:companyid,:accountid,:isdebet,:accformula,:aftacc,:nourut,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':repneracaid',$_POST['repneracaid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':isdebet',(($_POST['isdebet']!=='')?$_POST['isdebet']:null),PDO::PARAM_STR);
        $command->bindvalue(':accformula',(($_POST['accformula']!=='')?$_POST['accformula']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from repneraca where repneracaid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update repneraca set recordstatus = 0 where repneracaid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update repneraca set recordstatus = 1 where repneracaid = ".$id[$i];
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
				$sql = "delete from repneraca where repneracaid = ".$id[$i];
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
	public function actionGenerate()
  {
    parent::actionCreate();
		$sql = "call InsertBSLajur(" . $_REQUEST['companyname'] . ", '" . date(Yii::app()->params['datetodb'], strtotime($_REQUEST['date'])) . "')";
    Yii::app()->db->createCommand($sql)->execute();
		$this->GetMessage('success', 'alreadysaved');
  }
	public function actionDownPDF()
	{
		parent::actionDownPDF();
		$connection=Yii::app()->db;
	  //$this->GenerateTable();
		//$sql = "call InsertNeracaLajur('".$_REQUEST['companyname']."','".date(Yii::app()->params['datetodb'], strtotime($_REQUEST['date']))."')";
		//$connection->createCommand($sql)->execute();
		
		$sql        = "select a.*
			from repneracalajur a 
			where a.companyid = " . $_GET['companyname'] . " 
			and a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
			order by jumlah ";
    $datareader = Yii::app()->db->createCommand($sql)->queryAll();
    $this->pdf->AddPage('L');
    $this->pdf->companyid = $_GET['companyname'];
    $this->pdf->Cell(0, 0, $this->getcatalog('balancesheet'), 0, 0, 'C');
    $this->pdf->Cell(-277, 10, 'Per : ' . date("t F Y", strtotime($_GET['date'])), 0, 0, 'C');
    $i = 0;
    $this->pdf->setFont('Arial', 'B', 7);
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
      'C'
    );
    $this->pdf->colheader = array(
      '',
      'Bulan Ini',
      '',
      'Bulan Lalu',
      '',
      '',
      'Bulan Ini',
      '',
      'Bulan Lalu',
      ''
    );
    $this->pdf->setwidths(array(
      72,
      29,
      11,
      29,
      11,
      52,
      29,
      11,
      29,
      11
    ));
    $this->pdf->Rowheader();
    $this->pdf->colheader = array(
      'Keterangan',
      'Total',
      '%',
      'Total',
      '%',
      'Keterangan',
      'Total',
      '%',
      'Total',
      '%'
    );
    $this->pdf->setwidths(array(
      72,
      29,
      11,
      29,
      11,
      52,
      29,
      11,
      29,
      11
    ));
    $this->pdf->Rowheader();
    $this->pdf->coldetailalign = array(
      'L',
      'R',
      'R',
      'R',
      'R',
      'L',
      'R',
      'R',
      'R',
      'R'
    );
    $this->pdf->setFont('Arial', '', 7);
    foreach ($datareader as $data) {
      if ((strpos($data['accactivaname'], 'TOTAL') !== false) && (strpos($data['accpasivaname'], 'TOTAL') !== false)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          )
        );
      } else if (($data['accactivaid'] == null) && (strpos($data['accpasivaname'], 'TOTAL') !== false)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          )
        );
      } else if (($data['accactivaid'] == null) && ($data['accpasivaid'] == null)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          )
        );
      } else if (($data['accactivaid'] !== null) && ($data['accpasivaid'] == null)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          )
        );
      } else if (($data['accactivaid'] === null) && ($data['accpasivaid'] !== null)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          )
        );
      } else if ((strpos($data['accactivaname'], 'TOTAL') !== false) && (strpos($data['accpasivaname'], 'TOTAL') === false)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          )
        );
      } else if ((strpos($data['accactivaname'], 'TOTAL') === false) && (strpos($data['accpasivaname'], 'TOTAL') !== false)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          ),
          array(
            'Arial',
            'B',
            7
          )
        );
      } else if (($data['accactivaid'] !== null) && ($data['accpasivaid'] !== null)) {
        $this->pdf->rowstyles = array(
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          ),
          array(
            'Arial',
            '',
            7
          )
        );
      }
      $this->pdf->row(array(
        $data['accactivaname'],
        Yii::app()->format->formatNumber($data['accblninitotal']/$_GET['per']),
        Yii::app()->format->formatNumber($data['accblninipersen']),
        Yii::app()->format->formatNumber($data['accblnlalutotal']/$_GET['per']),
        Yii::app()->format->formatNumber($data['accblnlalupersen']),
        $data['accpasivaname'],
        Yii::app()->format->formatNumber($data['pasblninitotal']/$_GET['per']),
        Yii::app()->format->formatNumber($data['pasblninipersen']),
        Yii::app()->format->formatNumber($data['pasblnlalutotal']/$_GET['per']),
        Yii::app()->format->formatNumber($data['pasblnlalupersen'])
      ));
    }
    $this->pdf->Output();
	}
	public function actionDownXLS()
	{
		$this->menuname = 'laporanneraca';
    parent::actionDownxls();
		/*$sql = "call InsertProfitLossLajur('".$_REQUEST['companyname']."','".date(Yii::app()->params['datetodb'], strtotime($_REQUEST['date']))."')"; 
		$command = Yii::app()->db->createCommand($sql);		
		$command->execute();*/
			
    $sql        = "select a.*
									from repneracalajur a 
									where a.companyid = " . $_GET['companyname'] . " 
									and a.tahun = year('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
									and a.bulan = month('" . date(Yii::app()->params['datetodb'], strtotime($_GET['date'])) . "')
									order by jumlah ";
		
		$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
		$i=6;
		$this->phpExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(0, 2,date(Yii::app()->params['dateviewfromdb'], strtotime($_REQUEST['date'])));
		
		foreach($dataReader as $row1)
		{			
			//$this->phpExcel->getActiveSheet()->getStyle($i+1)->applyFromArray($styleArray);
			$this->phpExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $i + 1, $row1['accactivaname'])->setCellValueByColumnAndRow(1, $i + 1, $row1['accblninitotal']/$_GET['per'])->setCellValueByColumnAndRow(2, $i + 1, $row1['accblninipersen'])->setCellValueByColumnAndRow(3, $i + 1, $row1['accblnlalutotal']/$_GET['per'])->setCellValueByColumnAndRow(4, $i + 1, $row1['accblnlalupersen'])->setCellValueByColumnAndRow(5, $i + 1, $row1['accpasivaname'])->setCellValueByColumnAndRow(6, $i + 1, $row1['pasblninitotal']/$_GET['per'])->setCellValueByColumnAndRow(7, $i + 1, $row1['pasblninipersen'])->setCellValueByColumnAndRow(8, $i + 1, $row1['pasblnlalutotal']/$_GET['per'])->setCellValueByColumnAndRow(9, $i + 1, $row1['pasblnlalupersen']);
      $i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}