<?php

class AttController extends AdminController
{
	protected $menuname = 'att';
	public $module = 'Accounting';
	protected $pageTitle = 'Lampiran Neraca & Laba (Rugi)';
	public $wfname = '';
	protected $sqldata = "select t.*, a.companyname, b.accountid, b.accountname
        from att t
        left join company a on a.companyid = t.companyid
        left join account b on b.accountid = t.accheaderid ";
    protected $sqlcount = "select count(1) 
        from att t
        left join company a on a.companyid = t.companyid
        left join account b on b.accountid = t.accheaderid ";
    
    protected $sqldataattdetail = "select t.*, a.accountcode
        from attdet t
        left join account a on a.accountid = t.accountid ";

    protected $sqlcountattdetail = "select count(1)
        from attdet t
        join account a on a.accountid = t.accountid ";
    
	protected function getSQL()
	{
        $isneraca        = isset($_POST['isneraca']) ? $_POST['isneraca'] : '%%';
        if(isset($_REQUEST['isneraca']) && ($_REQUEST['isneraca']!=0))
        {
            $whereneraca = " ";
        }
        else{
            $whereneraca ='';
        }
        
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where isneraca like '{$isneraca}'";
		if(isset($_REQUEST['attid']) && ($_REQUEST['attid']!='0'))
        {
            $where .= " and t.attid like '{$_REQUEST['attid']}'";
        }
        if(isset($_REQUEST['companyid']) && ($_REQUEST['companyid']!=''))
        {
            $where .= " and t.companyid like '%{$_REQUEST['companyid']}%'";
        }
        if(isset($_REQUEST['accountname']) && ($_REQUEST['accountname']!=''))
        {
            $where .= " and t.accountname like '%{$_REQUEST['accountname']}'%";
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
			'keyField'=>'attid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'attid','companyid','accountid','isneraca','nourut','recordstatus'
				),
				'defaultOrder' => array( 
					'attid' => CSort::SORT_DESC
				),
			),
		));
        
        if (isset($_REQUEST['attdetid']))
		{
			$this->sqlcountattdetail .= ' where attdetid = '.$_REQUEST['attdetid'];
			$this->sqldataattdetail .= ' where attdetid = '.$_REQUEST['attdetid'];
		}
        
        if(isset($_REQUEST['attid']))
        {
            $this->sqlcountattdetail .= ' where attid = '.$_REQUEST['attid'];
            $this->sqldataattdetail .= ' where attid = '.$_REQUEST['attid'];
        }
        
        $countattdetail = Yii::app()->db->createCommand($this->sqlcountattdetail)->queryScalar();
        
        $pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
        
        $dataProviderattdetail = new CSqlDataProvider($this->sqldataattdetail,array(
			'totalItemCount'=>$countattdetail,
			'keyField'=>'attdetid',
			'pagination'=>$pagination,
			'sort'=>array(
                'attributes'=>array(
                    'attdetid', 'accountcode','accountname','accformula', 'isbold', 'nourut', 'isview', 'total',
            ),
            'defaultOrder' => array( 
                'attdetid' => CSort::SORT_ASC
				),
			),
		));
		
        $this->render('index',array('dataProvider'=>$dataProvider,'dataProviderattdetail'=>$dataProviderattdetail));
	}
    public function getIndex(){
    $this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'attid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
                    'attid','companyid','accountid','isneraca','nourut','recordstatus'
				),
				'defaultOrder' => array( 
					'attid' => CSort::SORT_DESC
				),
			),
		));
        return $dataProvider;
    }
    
    public function getIndexDetail(){
        if (isset($_REQUEST['attdetid']))
		{
			$this->sqlcountattdetail .= ' where attdetid = '.$_REQUEST['attdetid'];
			$this->sqldataattdetail .= ' where attdetid = '.$_REQUEST['attdetid'];
		}
        
        if(isset($_REQUEST['attid']))
        {
            $this->sqlcountattdetail .= ' where attid = '.$_REQUEST['attid'];
            $this->sqldataattdetail .= ' where attid = '.$_REQUEST['attid'];
        }
        
        $countattdetail = Yii::app()->db->createCommand($this->sqlcountattdetail)->queryScalar();
        
        $pagination = array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			);
        
        $dataProviderattdetail = new CSqlDataProvider($this->sqldataattdetail,array(
			'totalItemCount'=>$countattdetail,
			'keyField'=>'attdetid',
			'pagination'=>$pagination,
			'sort'=>array(
                'attributes'=>array(
                    'attdetid', 'accountcode','accountname','accformula', 'isbold', 'nourut', 'isview', 'total',
            ),
            'defaultOrder' => array( 
                'attdetid' => CSort::SORT_ASC
				),
			),
		));
        
        return $dataProviderattdetail;
    }
	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into att (recordstatus) values (0)";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
            'attid'=>$id,
		));
	}
    
    public function actionCreateattdetail()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
		));
	}
    
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where t.attid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'attid'=>$model['attid'],
                    'companyid'=>$model['companyid'],
                    'accheaderid'=>$model['accheaderid'],
                    'accountname'=>$model['accountname'],
                    'isprofitloss'=>$model['isprofitloss'],
                    'isneraca'=>$model['isneraca'],
                    'nourut'=>$model['nourut'],
                    'recordstatus'=>$model['recordstatus'],
                    'companyname'=>$model['companyname'],
                    'accountname'=>$model['accountname'],
				));
				Yii::app()->end();
			}
		}
	}
    public function actionUpdateattdetail()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldataattdetail.' where attdetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'attdetid'=>$model['attdetid'],
					'accountid'=>$model['accountid'],
                    'accountname'=>$model['accountname'],
                    'accformula'=>$model['accformula'],
                    'isbold'=>$model['isbold'],
                    'nourut'=>$model['nourut'],
                    'isview'=>$model['isview'],
                    'istotal'=>$model['istotal'],
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
            array('accheaderid','string','emptyaccountid'),
            array('nourut','string','emptynourut'),
            array('recordstatus','string','emptyrecordstatus'),
        ));
		if ($error == false)
		{
			$id = $_POST['attid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call UpdateAtt(:vid,:vcompanyid,:vaccheaderid,:visneraca,:vnourut,:vrecordstatus,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertAtt(:vcompanyid,:vaccheaderid,:visneraca,:vnourut,:vrecordstatus,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['attid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vcompanyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccheaderid',(($_POST['accheaderid']!=='')?$_POST['accheaderid']:null),PDO::PARAM_STR);
                $command->bindvalue(':visneraca',(($_POST['isneraca']!=='')?$_POST['isneraca']:null),PDO::PARAM_STR);
                $command->bindvalue(':vnourut',(($_POST['nourut']!=='')?$_POST['nourut']:null),PDO::PARAM_STR);
                $command->bindvalue(':vrecordstatus',(($_POST['recordstatus']!=='')?$_POST['recordstatus']:null),PDO::PARAM_STR);
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
    public function actionSaveattdetail()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
            array('nourut','string','emptynourut'),
        ));
		if ($error == false)
		{
			$id = $_POST['attdetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call UpdateAttDet(:vid,:vattid,:vaccountid,:vaccountname,:vaccformula,:vnourut,:visbold,:visview,:vistotal,:vcreatedby)';
				}
				else
				{
					$sql = 'call InsertAttDet(:vattid,:vaccountid,:vaccountname,:vaccformula,:vnourut,:visbold,:visview,:vistotal,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['attdetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vattid',(($_POST['attid']!=='')?$_POST['attid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccountid',(($_POST['accountid']!=='')?$_POST['accountid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccountname',(($_POST['accountname']!=='')?$_POST['accountname']:null),PDO::PARAM_STR);
                $command->bindvalue(':vaccformula',(($_POST['accformula']!=='')?$_POST['accformula']:null),PDO::PARAM_STR);
                $command->bindvalue(':vnourut',(($_POST['nourut']!=='')?$_POST['nourut']:null),PDO::PARAM_STR);
                $command->bindvalue(':visbold',(($_POST['isbold']!=='')?$_POST['isbold']:null),PDO::PARAM_STR);
                $command->bindvalue(':visview',(($_POST['isview']!=='')?$_POST['isview']:null),PDO::PARAM_STR);
                $command->bindvalue(':vistotal',(($_POST['istotal']!=='')?$_POST['istotal']:null),PDO::PARAM_STR);
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
	public function actionDownPdfNeraca()
    {
        parent::actionDownPDF();
        $this->pdf->companyid = $_GET['company'];
        $this->pdf->AddPage('P');  
        $companyid = $_GET['company'];
        $date = $_GET['date'];
        $saldoawal = 0;
        $saldoakhir = 0;
        $per = $_GET['per'];
        $connection = Yii::app()->db;
        $companyname = $connection->createCommand('select companycode from company a where a.companyid='.$companyid)->queryScalar();

        $sql1 = "select a.*, b.accountname as accheadername, b.accountcode
                from att a 
                join account b on a.accheaderid = b.accountid
                where a.recordstatus = 1 and isneraca = 1 and a.companyid = ".$companyid." order by a.nourut asc";
        $res1 = $connection->createCommand($sql1)->queryAll();
        foreach($res1 as $row1){
            $this->pdf->setFont('Arial','',11);
            $this->pdf->Cell(0, 0, $companyname, 0, 0, 'C');
            $this->pdf->Cell(-187, 10, $row1['accheadername'], 0, 0, 'C');
            $this->pdf->text(85,$this->pdf->gety()+10,'Per : '.date("t F Y", strtotime($_GET['date'])));

            $i = 0;
            $this->pdf->setFont('Arial', '', 10);
            $this->pdf->sety($this->pdf->gety()+15);
            $this->pdf->colalign  = array(
              'C',
              'L',
              'C',
              'C',
              'C'
            );
            $this->pdf->setwidths(array(
              15,
              60,
              30,
              60,
              30
            ));
            $this->pdf->setbordercell(array(
            'LTR',
            'LTR',
            'LTR',
            'LTRB',
            'LTR'
          ));
            $this->pdf->colheader = array(
              'NO',
              'KETERANGAN',
              'SALDO',
              'MUTASI',
              'SALDO'
            );
            $this->pdf->Rowheader();

            $this->pdf->colalign  = array(
              'L',
              'L',
              'C',
              'C',
              'C',
              'C'
            );
            $this->pdf->colheader = array(
              '',
              '',
              'AWAL',
              'DEBIT',
              'CREDIT',
              'AKHIR'
            );
            $this->pdf->setwidths(array(
              15,
              60,
              30,
              30,
              30,
              30
            ));
            $this->pdf->setbordercell(array(
            'LRB',
            'LRB',
            'LRB',
            'LRB',
            'LRB',
            'LRB'
          ));
            $this->pdf->Rowheader();

            $this->pdf->coldetailalign = array(
              'C',
              'L',
              'R',
              'R',
              'R',
              'R'
            );
            //$this->pdf->row(array('1','TEST','AWAL','DEBIT','CREDIT','AKHIR'));
            $sql2 = "select a.* from attdet a where a.isview = 1 and a.attid = ".$row1['attid']." order by a.nourut asc";
            $res2 = $connection->createCommand($sql2)->queryAll();
            $i=1;
            $subawal = 0;
            $subakhir = 0;
            $subdebit = 0;
            $subcredit= 0;
            $this->pdf->Line(10,35,10,$this->pdf->gety()); // before NO, first border
            $this->pdf->Line(205,35,205,$this->pdf->gety()); // after akhir, end border
            foreach($res2 as $row2){
                $this->pdf->setFont('Arial','',8);
                if($row2['isbold']==1){
                    $this->pdf->SetFont('Arial','B',9);
                }

                if($row2['istotal']!=1){
                $sqlsaldoawal = "call hitungsaldo(:vaccountcode,:vdate,:vcompanyid,@vsaldoawal,@vsaldoakhir)";
                $command1 = $connection->createCommand($sqlsaldoawal);
                $command1->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                $command1->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                $command1->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                $command1->execute();

                $sqlsaldo = "select @vsaldoawal as awal, @vsaldoakhir as akhir"; 
                $stmt1 = Yii::app()->db->createCommand($sqlsaldo); 
                $stmt1->execute(); 
                $saldo = $stmt1->queryRow();

                $sqldebitcredit = "call hitungdebcred(:vaccountcode,:vdate,:vcompanyid,@vdebit,@vcredit)";
                $command2 = $connection->createCommand($sqldebitcredit);
                $command2->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                $command2->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                $command2->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                $command2->execute();

                $sqldebcred = "select @vdebit as debit, @vcredit as credit"; 
                $stmt2 = Yii::app()->db->createCommand($sqldebcred); 
                $stmt2->execute(); 
                $debcred = $stmt2->queryRow();

                $this->pdf->setbordercell(array(
                'L',
                'LR',
                'R',
                'R',
                'R',
                'R'));


                if($row2['accformula']=='' || $row2['accformula']=='-'){
                   $this->pdf->row(array($i,$row2['accountname'],'','','',''));
                }else{
                    $this->pdf->Line(10,30,10,$this->pdf->gety()); // before NO, first border
                    $this->pdf->Line(205,30,205,$this->pdf->gety()); // after akhir, end border
                    $this->pdf->Line(115,30,115,$this->pdf->gety()+2); // after saldo awal
                    $this->pdf->Line(145,35,145,$this->pdf->gety()+2); // after debit
                    $this->pdf->Line(175,30,175,$this->pdf->gety()+2); // after credit
                   $this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($saldo['awal']/$per),
                                          Yii::app()->format->formatCurrency($debcred['debit']/$per),
                                          Yii::app()->format->formatCurrency($debcred['credit']/$per),
                                          Yii::app()->format->formatCurrency($saldo['akhir']/$per)));   
                }
                /*
                $this->pdf->text(12,$this->pdf->gety(),$i);
                $this->pdf->text(21,$this->pdf->gety(),$row2['accountname']);
                */
                /*$this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($saldo['awal']/$per),
                                          Yii::app()->format->formatCurrency($debcred['debit']/$per),
                                          Yii::app()->format->formatCurrency($debcred['credit']/$per),
                                          Yii::app()->format->formatCurrency($saldo['akhir']/$per)));
                */
                $subawal = $subawal + $saldo['awal'];
                $subakhir = $subakhir + $saldo['akhir'];
                $subdebit = $subdebit + $debcred['debit'];
                $subcredit = $subcredit + $debcred['credit'];
                }else{
                    $this->pdf->Line(10,30,10,$this->pdf->gety()); // before NO, first border
                    $this->pdf->Line(205,30,205,$this->pdf->gety()); // after akhir, end border
                    $this->pdf->Line(115,30,115,$this->pdf->gety()+2); // after saldo awal
                    $this->pdf->Line(145,35,145,$this->pdf->gety()+2); // after debit
                    $this->pdf->Line(175,30,175,$this->pdf->gety()+2); // after credit
                    $this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($subawal/$per),
                                          Yii::app()->format->formatCurrency($subdebit/$per),
                                          Yii::app()->format->formatCurrency($subcredit/$per),
                                          Yii::app()->format->formatCurrency($subakhir/$per)));   

                    $subawal = 0;
                    $subakhir = 0;
                    $subdebit = 0;
                    $subcredit = 0;
                }
            $i++;
            }
            //$this->pdf->Rect($this->pdf->getX(),$this->pdf->getY(),5,20,'D');
            $this->pdf->setY($this->pdf->getY()-5);
            $this->pdf->setbordercell(array(
                'LRB',
                'LRB',
                'LRB',
                'LRB',
                'LRB',
                'LRB'));
            $this->pdf->row(array('','','','','',''));
            $this->pdf->checkPageBreak(250);
        }

        $this->pdf->Output();
    }
    public function actionDownPdfPL()
	{
        parent::actionDownload();
        $this->pdf->companyid = $_GET['company'];
        $this->pdf->AddPage('P');  
        $companyid = $_GET['company'];
        $date = $_GET['date'];
        $saldoawal = 0;
        $saldoakhir = 0;
        $per = $_GET['per'];
        $connection = Yii::app()->db;
        $companyname = $connection->createCommand('select companycode from company a where a.companyid='.$companyid)->queryScalar();

        $sql1 = "select a.*, b.accountname as accheadername, b.accountcode
                from att a 
                join account b on a.accheaderid = b.accountid
                where a.recordstatus = 1 and isneraca = 0 and a.companyid = ".$companyid." order by a.nourut asc";
        $res1 = $connection->createCommand($sql1)->queryAll();
        foreach($res1 as $row1){
            $this->pdf->setFont('Arial','',11);
            $this->pdf->Cell(0, 0, $companyname, 0, 0, 'C');
            $this->pdf->Cell(-187, 10, $row1['accheadername'], 0, 0, 'C');
            $this->pdf->text(85,$this->pdf->gety()+10,'Per : '.date("t F Y", strtotime($_GET['date'])));

            $i = 0;
            $this->pdf->setFont('Arial', '', 10);
            $this->pdf->sety($this->pdf->gety()+15);
            $this->pdf->colalign  = array(
              'C',
              'L',
              'C',
              'C',
              'C'
            );
            $this->pdf->setwidths(array(
              15,
              90,
              30,
              30,
              30
            ));
            $this->pdf->setbordercell(array(
            'LTR',
            'LTR',
            'LTR',
            'LTR',
            'LTR'
          ));
            $this->pdf->colheader = array(
              'NO',
              'KETERANGAN',
              'BULAN',
              'BULAN',
              'KUMULATIF'
            );
            $this->pdf->Rowheader();

            $this->pdf->colalign  = array(
              'L',
              'L',
              'C',
              'C',
              'C',
              'C'
            );
            $this->pdf->colheader = array(
              '',
              '',
              'INI',
              'LALU',
              'S/D BULAN INI'
            );
            $this->pdf->setwidths(array(
              15,
              90,
              30,
              30,
              30
            ));
            $this->pdf->setbordercell(array(
            'LRB',
            'LRB',
            'LRB',
            'LRB',
            'LRB'
          ));
            $this->pdf->Rowheader();

            $this->pdf->coldetailalign = array(
              'C',
              'L',
              'R',
              'R',
              'R'
            );
            //$this->pdf->row(array('1','TEST','AWAL','DEBIT','CREDIT','AKHIR'));
            $sql2 = "select a.* from attdet a where a.isview = 1 and a.attid = ".$row1['attid']." order by a.nourut asc";
            $res2 = $connection->createCommand($sql2)->queryAll();
            $i=1;
            $subawal = 0;
            $subakhir = 0;
            $subakum = 0;
            $this->pdf->Line(10,35,10,$this->pdf->gety()); // before NO, first border
            $this->pdf->Line(205,35,205,$this->pdf->gety()); // after akhir, end border
            foreach($res2 as $row2){
                $this->pdf->setFont('Arial','',8);
                if($row2['isbold']==1){
                    $this->pdf->SetFont('Arial','B',9);
                }

                if($row2['istotal']!=1){
                $sqlsaldoawal = "call hitungplmonth(:vaccountcode,:vdate,:vcompanyid,@vplmonth,@vpllastmonth)";
                $command1 = $connection->createCommand($sqlsaldoawal);
                $command1->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                $command1->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                $command1->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                $command1->execute();

                $sqlpl = "select @vplmonth as month, @vpllastmonth as lastmonth"; 
                $stmt1 = Yii::app()->db->createCommand($sqlpl); 
                $stmt1->execute(); 
                $pl = $stmt1->queryRow();

                $sqldebitcredit = "call hitungplakum(:vaccountcode,:vdate,:vcompanyid,@vplakum)";
                $command2 = $connection->createCommand($sqldebitcredit);
                $command2->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                $command2->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                $command2->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                $command2->execute();

                $sqlakum = "select @vplakum as plakum"; 
                $stmt2 = Yii::app()->db->createCommand($sqlakum); 
                $stmt2->execute(); 
                $akum = $stmt2->queryRow();

                $this->pdf->setbordercell(array(
                'L',
                'LR',
                'R',
                'R',
                'R'));


                if($row2['accformula']=='' || $row2['accformula']=='-'){
                   $this->pdf->row(array($i,$row2['accountname'],'','',''));
                }else{
                    $this->pdf->Line(10,30,10,$this->pdf->gety()); // before NO, first border
                    $this->pdf->Line(205,30,205,$this->pdf->gety()); // after akhir, end border
                    $this->pdf->Line(115,30,115,$this->pdf->gety()+2); // after saldo awal
                    $this->pdf->Line(145,35,145,$this->pdf->gety()+2); // after debit
                    $this->pdf->Line(175,30,175,$this->pdf->gety()+2); // after credit
                   $this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($pl['month']/$per),
                                          Yii::app()->format->formatCurrency($pl['lastmonth']/$per),
                                          Yii::app()->format->formatCurrency($akum['plakum']/$per)));   
                }
                /*
                $this->pdf->text(12,$this->pdf->gety(),$i);
                $this->pdf->text(21,$this->pdf->gety(),$row2['accountname']);
                */
                /*$this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($saldo['awal']/$per),
                                          Yii::app()->format->formatCurrency($debcred['debit']/$per),
                                          Yii::app()->format->formatCurrency($debcred['credit']/$per),
                                          Yii::app()->format->formatCurrency($saldo['akhir']/$per)));
                */
                $subawal = $subawal + $pl['month'];
                $subakhir = $subakhir + $pl['lastmonth'];
                $subakum = $subakum + $akum['plakum'];

                }else{
                    $this->pdf->row(array($i,
                                          $row2['accountname'],
                                          Yii::app()->format->formatCurrency($subawal/$per),
                                          Yii::app()->format->formatCurrency($subakhir/$per),
                                          Yii::app()->format->formatCurrency($subakum/$per)));   

                    $subawal = 0;
                    $subakhir = 0;
                    $subakum = 0;
                }
            $i++;
            }
            //$this->pdf->Rect($this->pdf->getX(),$this->pdf->getY(),5,20,'D');
            $this->pdf->setY($this->pdf->getY()-5);
            $this->pdf->setbordercell(array(
                'LRB',
                'LRB',
                'LRB',
                'LRB',
                'LRB'));
            $this->pdf->row(array('','','','',''));
            $this->pdf->checkPageBreak(250);
        }
        $this->pdf->Output();
    }
	public function actionDownXlsNeraca()
	{
        //$this->menuname = 'lampiranneraca';
        parent::actionDownXls();
        $companyid = $_GET['company'];
        $date = $_GET['date'];
        $per = $_GET['per'];
        $connection = Yii::app()->db;
        $sqldata1 = "select t.*, a.companyname, b.accountname ";
        $sqlcount1 = "select count(1) as total ";
        $from = "from att t 
            join company a on t.companyid = a.companyid
            join account b on b.accountid = t.accheaderid
            where isneraca = 1 and t.recordstatus = 1 and t.companyid = ".$companyid." order by t.nourut desc";
        $total = $connection->createCommand($sqlcount1.$from)->queryScalar();
        $res1 = $connection->createCommand($sqldata1.$from)->queryAll();

        $i=0;$j=2;
        $style = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        foreach($res1 as $row1)
        {
            $myWorkSheet = new PHPExcel_Worksheet($this->phpExcel, $row1['accountname']);
            $this->phpExcel->addSheet($myWorkSheet, $i);
            $excel = $this->phpExcel->getSheetByName($row1['accountname']);
            $excel->mergeCells('A2:F2');
            $excel->mergeCells('A3:F3');
            $excel->mergeCells('A4:F4');
            $excel->mergeCells('D6:E6');
            $excel->mergeCells('A6:A7');
            $excel->mergeCells('B6:B7');
            $excel->getColumnDimension('A')->setWidth(5);
            $excel->getColumnDimension('B')->setWidth(40);
            $excel->getColumnDimension('C')->setWidth(15);
            $excel->getColumnDimension('D')->setWidth(15);
            $excel->getColumnDimension('E')->setWidth(15);
            $excel->getColumnDimension('F')->setWidth(15);
            $excel->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
            $excel->
                setCellValueByColumnAndRow($i, $j, $row1['companyname'])->
                setCellValueByColumnAndRow($i, $j+1, 'MUTASI '.$row1['accountname'])->
                setCellValueByColumnAndRow($i, $j+2, 'Per : '.date("t F Y", strtotime($_GET['date'])));

            $excel
                ->setCellValueByColumnAndRow($i, $j+4, 'NO')
                ->setCellValueByColumnAndRow($i+1, $j+4, 'Keterangan')
                ->setCellValueByColumnAndRow($i+2, $j+4, 'Saldo')
                ->setCellValueByColumnAndRow($i+3, $j+4, 'Mutasi')
                ->setCellValueByColumnAndRow($i+5, $j+4, 'Saldo');

            $excel
                ->setCellValueByColumnAndRow($i+2, $j+5, 'Awal')
                ->setCellValueByColumnAndRow($i+3, $j+5, 'Debit')
                ->setCellValueByColumnAndRow($i+4, $j+5, 'Credit')
                ->setCellValueByColumnAndRow($i+5, $j+5, 'Akhir');

            // get all data
            $sql2 = "select a.* 
                    from attdet a 
                    where a.isview = 1 and a.attid = ".$row1['attid']." 
                    order by a.nourut asc";
            $res2 = $connection->createCommand($sql2)->queryAll();

            $subawal = 0;
            $subakhir = 0;
            $subdebit = 0;
            $subcredit= 0;
            $k = 8;
            $l=1;
            
            foreach($res2 as $row2)
            {
                if($row2['istotal']!=1)
                {
                    $sqlsaldoawal = "call hitungsaldo(:vaccountcode,:vdate,:vcompanyid,@vsaldoawal,@vsaldoakhir)";
                    $command1 = $connection->createCommand($sqlsaldoawal);
                    $command1->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                    $command1->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                    $command1->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                    $command1->execute();

                    $sqlsaldo = "select @vsaldoawal as awal, @vsaldoakhir as akhir"; 
                    $stmt1 = Yii::app()->db->createCommand($sqlsaldo); 
                    $stmt1->execute(); 
                    $saldo = $stmt1->queryRow();

                    $sqldebitcredit = "call hitungdebcred(:vaccountcode,:vdate,:vcompanyid,@vdebit,@vcredit)";
                    $command2 = $connection->createCommand($sqldebitcredit);
                    $command2->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                    $command2->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                    $command2->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                    $command2->execute();

                    $sqldebcred = "select @vdebit as debit, @vcredit as credit"; 
                    $stmt2 = Yii::app()->db->createCommand($sqldebcred); 
                    $stmt2->execute(); 
                    $debcred = $stmt2->queryRow();

                    $excel
                        ->setCellValueByColumnAndRow($i+0, $k, $l)
                        ->setCellValueByColumnAndRow($i+1, $k, $row2['accountname']);

                    if($row2['accformula']=='' || $row2['accformula']=='-')
                    {

                    }else{
                        $excel
                            ->setCellValueByColumnAndRow($i+2, $k, $saldo['awal']/$per)
                            ->setCellValueByColumnAndRow($i+3, $k, $debcred['debit']/$per)
                            ->setCellValueByColumnAndRow($i+4, $k, $debcred['credit']/$per)
                            ->setCellValueByColumnAndRow($i+5, $k, $saldo['akhir']/$per);
                    }
                    $subawal = $subawal + $saldo['awal'];
                    $subakhir = $subakhir + $saldo['akhir'];
                    $subdebit = $subdebit + $debcred['debit'];
                    $subcredit = $subcredit + $debcred['credit'];
                }
                else
                {
                    $excel
                        ->setCellValueByColumnAndRow($i+0, $k, $l)
                        ->setCellValueByColumnAndRow($i+1, $k, $row2['accountname'])
                        ->setCellValueByColumnAndRow($i+2, $k, $subawal/$per)
                        ->setCellValueByColumnAndRow($i+3, $k, $subdebit/$per)
                        ->setCellValueByColumnAndRow($i+4, $k, $subcredit/$per)
                        ->setCellValueByColumnAndRow($i+5, $k, $subakhir/$per);

                    $subawal = 0;
                    $subakhir = 0;
                    $subdebit = 0;
                    $subcredit = 0;
                }
                $k++;
                $l++;
            }
        }
    $this->getFooterXLS($this->phpExcel);  
    }
    
    public function actionDownXlsPL()
	{
        parent::actionDownXls();
        //$this->menuname = 'lampiranlabarugi';
        $companyid = $_GET['company'];
        $date = $_GET['date'];
        $per = $_GET['per'];
        $connection = Yii::app()->db;
        $sqldata1 = "select t.*, a.companyname, b.accountname ";
        $sqlcount1 = "select count(1) as total ";
        $from = "from att t 
                join company a on t.companyid = a.companyid
                join account b on b.accountid = t.accheaderid
                where isneraca = 0 and t.recordstatus = 1 and t.companyid = ".$companyid." order by t.nourut desc";
        $total = $connection->createCommand($sqlcount1.$from)->queryScalar();
        $res1 = $connection->createCommand($sqldata1.$from)->queryAll();

        $i=0;$j=2;
        $style = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $x = 1;
        foreach($res1 as $row1)
        {
            $myWorkSheet = new PHPExcel_Worksheet($this->phpExcel, 'Lampiran '.$x);
            $this->phpExcel->addSheet($myWorkSheet, $i);
            $excel = $this->phpExcel->getSheetByName('Lampiran '.$x);
            $excel->mergeCells('A2:F2');
            $excel->mergeCells('A3:F3');
            $excel->mergeCells('A4:F4');
            $excel->mergeCells('A6:A7');
            $excel->mergeCells('B6:B7');
            $excel->getColumnDimension('A')->setWidth(5);
            $excel->getColumnDimension('B')->setWidth(40);
            $excel->getColumnDimension('C')->setWidth(15);
            $excel->getColumnDimension('D')->setWidth(15);
            $excel->getColumnDimension('E')->setWidth(15);
            $excel->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $excel->
                setCellValueByColumnAndRow($i, $j, $row1['companyname'])->
                setCellValueByColumnAndRow($i, $j+1, 'MUTASI '.$row1['accountname'])->
                setCellValueByColumnAndRow($i, $j+2, 'Per : '.date("t F Y", strtotime($_GET['date'])));

            $excel
                ->setCellValueByColumnAndRow($i, $j+4, 'NO')
                ->setCellValueByColumnAndRow($i+1, $j+4, 'KETERANGAN')
                ->setCellValueByColumnAndRow($i+2, $j+4, 'BULAN')
                ->setCellValueByColumnAndRow($i+3, $j+4, 'BULAN')
                ->setCellValueByColumnAndRow($i+4, $j+4, 'KUMULATIF');

            $excel
                ->setCellValueByColumnAndRow($i+2, $j+5, 'INI')
                ->setCellValueByColumnAndRow($i+3, $j+5, 'LALU')
                ->setCellValueByColumnAndRow($i+4, $j+5, 'S/D BULAN INI');

            // get all data
            $sql2 = "select a.* from attdet a where a.isview = 1 and a.attid = ".$row1['attid']." order by a.nourut asc";
            $res2 = $connection->createCommand($sql2)->queryAll();

            $subawal = 0;
            $subakhir = 0;
            $subakum = 0;
            $k = 8;
            $l=1;
            foreach($res2 as $row2)
            {
                if($row2['istotal']!=1)
                {
                    $sqlsaldoawal = "call hitungplmonth(:vaccountcode,:vdate,:vcompanyid,@vplmonth,@vpllastmonth)";
                    $command1 = $connection->createCommand($sqlsaldoawal);
                    $command1->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                    $command1->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                    $command1->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                    $command1->execute();

                    $sqlpl = "select @vplmonth as month, @vpllastmonth as lastmonth"; 
                    $stmt1 = Yii::app()->db->createCommand($sqlpl); 
                    $stmt1->execute(); 
                    $pl = $stmt1->queryRow();

                    $sqldebitcredit = "call hitungplakum(:vaccountcode,:vdate,:vcompanyid,@vplakum)";
                    $command2 = $connection->createCommand($sqldebitcredit);
                    $command2->bindvalue(':vaccountcode', $row2['accformula'], PDO::PARAM_STR);
                    $command2->bindvalue(':vdate',date(Yii::app()->params['datetodb'],strtotime($date)), PDO::PARAM_STR);
                    $command2->bindvalue(':vcompanyid', $companyid, PDO::PARAM_STR);
                    $command2->execute();

                    $sqlakum = "select @vplakum as plakum"; 
                    $stmt2 = Yii::app()->db->createCommand($sqlakum); 
                    $stmt2->execute(); 
                    $akum = $stmt2->queryRow();

                    $excel
                        ->setCellValueByColumnAndRow($i+0, $k, $l)
                        ->setCellValueByColumnAndRow($i+1, $k, $row2['accountname']);

                    if($row2['accformula']=='' || $row2['accformula']=='-'){

                    }else{
                        $excel
                            ->setCellValueByColumnAndRow($i+2, $k, $pl['month']/$per)
                            ->setCellValueByColumnAndRow($i+3, $k, $pl['lastmonth']/$per)
                            ->setCellValueByColumnAndRow($i+4, $k, $akum['plakum']/$per);
                    }
                    
                    $subawal = $subawal + $pl['month'];
                    $subakhir = $subakhir + $pl['lastmonth'];
                    $subakum = $subakum + $akum['plakum'];
                }
                else
                {
                    $excel
                        ->setCellValueByColumnAndRow($i+2, $k, $pl['month']/$per)
                        ->setCellValueByColumnAndRow($i+3, $k, $pl['lastmonth']/$per)
                        ->setCellValueByColumnAndRow($i+4, $k, $akum['plakum']/$per);

                    $subawal = 0;
                    $subakhir = 0;
                    $subakum = 0;
                }
                $k++;
                $l++;
            }
            $x++;

        }
        $this->getFooterXLS($this->phpExcel);  
        }
}