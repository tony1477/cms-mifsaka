<?php

class PaymentscaleController extends AdminController
{
	protected $menuname = 'paymentscale';
	public $module = 'Accounting';
	protected $pageTitle = 'Skala Tagihan';
	public $wfname = 'appps';
	protected $sqldata = "select a0.paymentscaleid,a0.companyid,a0.docdate,a0.perioddate,a0.recordstatus,a0.statusname,a0.paramspv,a1.companyname as companyname, a0.minscale, a0.docno,a0.spvscale
    from paymentscale a0 
    left join company a1 on a1.companyid = a0.companyid
    ";
    protected $sqldatapaymentscaledet = "select a0.paymentscaledetid,a0.paymentscaleid,a0.min,a0.max,a0.gt30,a0.gt15,a0.gt7,a0.gt0,a0.x0,a0.lt0,a0.lt14, case when a0.min is null then
            concat('< ',a0.max) 
            when a0.max is null then 
            concat('>= ',a0.min)
            else
            concat('>= ',a0.min,' & < ',a0.max) 
            end as `range`
    from paymentscaledet a0 
    ";
    protected $sqldatapaymentscalecat = "select a0.paymentscalecatid, a0.custcategoryid, a0.paramvalue, a1.custcategoryname,a0.paymentscaleid
    from paymentscalecat a0
    left join custcategory a1 on a1.custcategoryid = a0.custcategoryid
    ";
    protected $sqlcount = "select count(1) 
    from paymentscale a0 
    left join company a1 on a1.companyid = a0.companyid
    ";
    protected $sqlcountpaymentscaledet = "select count(1) 
    from paymentscaledet a0 
    ";
    protected $sqlcountpaymentscalecat = "select ifnull(count(1),0)
    from paymentscalecat a0
    ";
	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appps')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus in (".getUserRecordStatus('listps').")
								and a0.recordstatus < {$maxstat}
                and a0.companyid in (".getUserObjectValues('company').")";
        
		if ((isset($_REQUEST['companyname'])))
		{				
			$where .= " and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
        if ((isset($_REQUEST['perioddate'])))
		{				
			$where .= " and a0.perioddate like '%". $_REQUEST['perioddate']."%'"; 
		}
		if (isset($_REQUEST['paymentscaleid']))
			{
				if (($_REQUEST['paymentscaleid'] !== '0') && ($_REQUEST['paymentscaleid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.paymentscaleid in (".$_REQUEST['paymentscaleid'].")";
					}
					else
					{
						$where .= " and a0.paymentscaleid in (".$_REQUEST['paymentscaleid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	
    public function actionCopypaymentscale()
    {
        if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call CopyPaymentScale(:vid,:vcreatedby)';
				$command=$connection->createCommand($sql);
                $command->bindvalue(':vid',$id,PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
                $command->execute();
				$transaction->commit();
				$this->GetMessage('success','insertsuccess',1);
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
    public function actionCheckdetail()
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try
            {
                $sql = 'call CheckDetailPaymentScale(:vid,:vcreatedby)';
                $command = $connection->createCommand($sql);
                $command->bindvalue(':vid',$id,PDO::PARAM_STR);
                $command->bindvalue(':vcreatedby',Yii::app()->user->id,PDO::PARAM_STR);
                $command->execute();
                $transaction->commit();
                $this->getMessage('success','insertsuccess',1);
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                $this->getMessage('error',$e->getMessage(),1);
            }
        }
        else
        {
            $this->GetMessage('error','chooseone',1);
        }        
    }
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'paymentscaleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'paymentscaleid','companyid','docdate','perioddate','recordstatus','paramspv','minscale','docno','spvscale'
				),
				'defaultOrder' => array( 
					'paymentscaleid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['paymentscaleid']))
		{
			$this->sqlcountpaymentscaledet .= ' where a0.paymentscaleid = '.$_REQUEST['paymentscaleid'];
			$this->sqldatapaymentscaledet .= ' where a0.paymentscaleid = '.$_REQUEST['paymentscaleid'];
      $this->sqlcountpaymentscalecat .= ' where a0.paymentscaleid = '.$_REQUEST['paymentscaleid'];
			$this->sqldatapaymentscalecat .= ' where a0.paymentscaleid = '.$_REQUEST['paymentscaleid'];
		}
		$countpaymentscaledet = Yii::app()->db->createCommand($this->sqlcountpaymentscaledet)->queryScalar();
$dataProviderpaymentscaledet=new CSqlDataProvider($this->sqldatapaymentscaledet,array(
					'totalItemCount'=>$countpaymentscaledet,
					'keyField'=>'paymentscaledetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'paymentscaledetid' => CSort::SORT_DESC
						),
					),
					));
        $countpaymentscalecat = Yii::app()->db->createCommand($this->sqlcountpaymentscalecat)->queryScalar();
        $dataProviderpaymentscalecat = 
        new CSqlDataProvider($this->sqldatapaymentscalecat,array(
					'totalItemCount'=>$countpaymentscalecat,
					'keyField'=>'paymentscalecatid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'paymentscalecatid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderpaymentscaledet'=>$dataProviderpaymentscaledet,'dataProviderpaymentscalecat'=>$dataProviderpaymentscalecat));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into paymentscale (recordstatus) values (".$this->findstatusbyuser('insps').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();echo CJSON::encode(array(
			'status'=>'success',
			'paymentscaleid'=>$id,
			"docdate" =>date("Y-m-d"),
      "perioddate" =>date("Y-m-d"),
      "recordstatus" =>$this->findstatusbyuser("insps"),
      "paramspv" =>0
		));
	}
  public function actionCreatepaymentscaledet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"gt30" =>0,
      "gt15" =>0,
      "gt7" =>0,
      "gt0" =>0,
      "x0" =>0,
      "lt0" =>0,
      "lt14" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.paymentscaleid = '.$id)->queryRow();
			//if ($this->CheckDoc($model['recordstatus']) == '')
			//{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'paymentscaleid'=>$model['paymentscaleid'],
          'companyid'=>$model['companyid'],
          'docdate'=>$model['docdate'],
          'perioddate'=>$model['perioddate'],
          'paramspv'=>$model['paramspv'],
          'companyname'=>$model['companyname'],
          'minscale'=>$model['minscale'],
          'spvscale'=>$model['spvscale'],

					));
					Yii::app()->end();
				}
			//}
			//else
			//{
				//$this->getMessage('error',$this->getCatalog("docreachmaxstatus"));
			//}
		}
	}

    public function actionUpdatepaymentscaledet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapaymentscaledet.' where paymentscaledetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'paymentscaledetid'=>$model['paymentscaledetid'],
          'paymentscaleid'=>$model['paymentscaleid'],
          'min'=>$model['min'],
          'max'=>$model['max'],
          'gt30'=>$model['gt30'],
          'gt15'=>$model['gt15'],
          'gt7'=>$model['gt7'],
          'gt0'=>$model['gt0'],
          'x0'=>$model['x0'],
          'lt0'=>$model['lt0'],
          'lt14'=>$model['lt14'],

				));
				Yii::app()->end();
			}
		}
	}
    public function actionUpdatepaymentscalecat()
    {
        parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatapaymentscalecat.' where paymentscalecatid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'paymentscalecatid'=>$model['paymentscalecatid'],
                    'paymentscaleid'=>$model['paymentscaleid'],
                    'custcategoryid'=>$model['custcategoryid'],
                    'custcategoryname'=>$model['custcategoryname'],
                    'paramvalue'=>$model['paramvalue'],
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
			$id = $_POST['paymentscaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatepaymentscale (:paymentscaleid,:companyid,:docdate,:perioddate,:paramspv,:vminscale,:vspvscale,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':paymentscaleid',$_POST['paymentscaleid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':perioddate',(($_POST['perioddate']!=='')?$_POST['perioddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':paramspv',(($_POST['paramspv']!=='')?$_POST['paramspv']:null),PDO::PARAM_STR);
                $command->bindvalue(':vminscale',(($_POST['minscale']!=='')?$_POST['minscale']:null),PDO::PARAM_STR);
                $command->bindvalue(':vspvscale',(($_POST['spvscale']!=='')?$_POST['spvscale']:null),PDO::PARAM_STR);
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
public function actionSavepaymentscaledet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('paymentscaleid','string','emptypaymentscaleid'),
    ));
		if ($error == false)
		{
			$id = $_POST['paymentscaledetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatepaymentscaledetail(:vid,:vpaymentscaleid,:vmin,:vmax,:vgt30,:vgt15,:vgt7,:vgt0,:vx0,:vlt0,:vlt14,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertpaymentscaledetail(:vpaymentscaleid,:vmin,:vmax,:vgt30,:vgt15,:vgt7,:vgt0,:vx0,:vlt0,:vlt14,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['paymentscaledetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vpaymentscaleid',(($_POST['paymentscaleid']!=='')?$_POST['paymentscaleid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmin',(($_POST['min']!=='')?$_POST['min']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmax',(($_POST['max']!=='')?$_POST['max']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt30',(($_POST['gt30']!=='')?$_POST['gt30']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt15',(($_POST['gt15']!=='')?$_POST['gt15']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt7',(($_POST['gt7']!=='')?$_POST['gt7']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt0',(($_POST['gt0']!=='')?$_POST['gt0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vx0',(($_POST['x0']!=='')?$_POST['x0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlt0',(($_POST['lt0']!=='')?$_POST['lt0']:null),PDO::PARAM_STR);
                $command->bindvalue(':vlt14',(($_POST['lt14']!=='')?$_POST['lt14']:null),PDO::PARAM_STR);
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
				
	public function actionSavepaymentscalecat()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('paymentscaleid','string','emptypaymentscaleid'),
            array('custcategoryid','string','emptycustcategoryid'),
            array('paramvalue','string','emptyparamvalue'),
    ));
		if ($error == false)
		{
			$id = $_POST['paymentscaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatepaymentscalecat(:vid,:vpaymentscaleid,:vcustcategoryid,:vparamvalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertpaymentscalecat(:vpaymentscaleid,:vcustcategoryid,:vparamvalue,:vcreatedby';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['paymentscalecatid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vpaymentscaleid',(($_POST['paymentscaleid']!=='')?$_POST['paymentscaleid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vparamvalue',(($_POST['paramvalue']!=='')?$_POST['paramvalue']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvepaymentscale(:vid,:vcreatedby)';
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
				$sql = 'call Deletepaymentscale(:vid,:vcreatedby)';
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
				$sql = "delete from paymentscale where paymentscaleid = ".$id[$i];
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
	}public function actionPurgepaymentscaledet()
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
				$sql = "delete from paymentscaledet where paymentscaledetid = ".$id[$i];
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
	public function actionDownPDF1()
	{
		parent::actionDownPDF();
        $this->pdf->title='Ketentuan Skala Komisi Tagihan';
        
        $sql = "select a.companyid, b.companycode, a.perioddate, a.paymentscaleid
                from paymentscale a
                join company b on b.companyid = a.companyid";
        if($_GET['paymentscale_0_paymentscaleid'] !== '')
            {
                $where = " and a.paymentscaleid in(".$_GET['paymentscale_0_paymentscaleid'].")";
            }
            else
            {
                $where = ' where paymentscaleid = 0 ';
                $this->pdf->setFont('Arial','B',11);
                $this->pdf->text(10,10,'Harap Pilih Dokumen');
            }
        $res = Yii::app()->db->createCommand($sql.$where)->queryAll();
        foreach($res as $row)
        {
            $this->pdf->setFont('Arial','',10);
            $month = date('M',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));
            $this->pdf->Addpage('L','A4');
            $this->pdf->text(10,12,$row['companycode'].' PERIODE '.$month.' '.$year);
            $this->pdf->setFont('Arial','',10);
            $this->pdf->colalign = array('C','C','C','C');
            $this->pdf->setbordercell(array('LRT','LRTB','LRTB','LRTB'));
            $this->pdf->colheader = array('%','X < TOP','X = TOP','X > TOP');
            
            $this->pdf->setwidths(array(30,60,25,120));
            $this->pdf->Rowheader();        
            
            $this->pdf->setFont('Arial','',10);
            $this->pdf->setwidths(array(30,30,30,25,30,30,30,30));
            $this->pdf->coldetailalign = array('C','C','C','C','C','C','C','C');
            $this->pdf->setbordercell(array('LB','LBR','BR','BR','BR','BR','BR','BR'));
            $this->pdf->row(array('  ',
                    ' X < -14 hr',
                    ' -14 <= X < 0 hr',
                    ' X = 0 hr',
                    ' 0 < X <= 7 hr',
                    ' 7 < X <= 15 hr',
                    ' 15 < X <= 30 hr',
                    ' X >= 30 hr'
                ));
            
            $sql2 = "select if(min is null and max is not null, ' < 70 %',IF(max is null and min is not null,' > 100 %',concat(min,' < X <= ',max))) as string,gt30,gt15,gt7,gt0,x0,lt0,lt14
                         from paymentscaledet a
                         where a.paymentscaleid = {$row['paymentscaleid']} ";
            $dataReader = Yii::app()->db->createCommand($sql2)->queryAll();
            foreach($dataReader as $row3)
            {
                $this->pdf->setbordercell(array('LR','L','L','L','L','L','L','LR'));
                $this->pdf->row(array($row3['string'],
                    Yii::app()->format->formatNumber($row3['lt14']).' %',
                    Yii::app()->format->formatNumber($row3['lt0']).' %',
                    Yii::app()->format->formatNumber($row3['x0']).' %',
                    Yii::app()->format->formatNumber($row3['gt0']).' %',
                    Yii::app()->format->formatNumber($row3['gt7']).' %',
                    Yii::app()->format->formatNumber($row3['gt15']).' %',
                    Yii::app()->format->formatNumber($row3['gt30']).' %',
                ));
            }
            
            $this->pdf->setbordercell(array('LBRT','TB','LBT','LBT','LBT','LBT','LBT','LBRT'));
            $this->pdf->row(array('X = Umur T.O.P','','','','','','',''));
            //$this->pdf->row(array(''));
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+15,'Dibuat Oleh');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+15,'Mengetahui');
            $this->pdf->text($this->pdf->getX()+213,$this->pdf->getY()+15,'Disetujui');
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+30,'(..................)');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+30,'(..................)');
            $this->pdf->text($this->pdf->getX()+210,$this->pdf->getY()+30,'(..................)');
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+40,'NB : ');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+45,'1. SKALA BERSIFAT FLEKSIBLE');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+50,'2. DAPAT BERUBAH DAN BERBEDA PER CABANG PER BULAN');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+55,'3. DI INPUT SETIAP BULAN');
        }
		$this->pdf->Output();
	}
  public function actionDownPDF()
	{
		parent::actionDownPDF();
        $this->pdf->title='Ketentuan Skala Komisi Tagihan';
        
        $sql = "select a.companyid, b.companycode, a.perioddate, a.paymentscaleid
                from paymentscale a
                join company b on b.companyid = a.companyid";
        if($_GET['paymentscale_0_paymentscaleid'] !== '')
            {
                $where = " and a.paymentscaleid in(".$_GET['paymentscale_0_paymentscaleid'].")";
            }
            else
            {
                $where = ' where paymentscaleid = 0 ';
                $this->pdf->setFont('Arial','B',11);
                $this->pdf->text(10,10,'Harap Pilih Dokumen');
            }
        $res = Yii::app()->db->createCommand($sql.$where)->queryAll();
        foreach($res as $row)
        {
            $this->pdf->setFont('Arial','',10);
            $month = date('M',strtotime($row['perioddate']));
            $year = date('Y',strtotime($row['perioddate']));
            $this->pdf->Addpage('L','A4');
            $this->pdf->text(10,12,$row['companycode'].' PERIODE '.$month.' '.$year);
            $this->pdf->setFont('Arial','',10);
            $this->pdf->colalign = array('C','C','C','C');
            $this->pdf->setbordercell(array('LRT','LRTB','LRTB','LRTB'));
            $this->pdf->colheader = array('%','X < TOP','X = TOP','X > TOP');
            
            $this->pdf->setwidths(array(30,60,25,120));
            $this->pdf->Rowheader();        
            
            $this->pdf->setFont('Arial','',10);
            $this->pdf->setwidths(array(30,30,30,25,30,30,30,30));
            $this->pdf->coldetailalign = array('C','C','C','C','C','C','C','C');
            $this->pdf->setbordercell(array('LB','LBR','BR','BR','BR','BR','BR','BR'));
            $this->pdf->row(array('  ',
                    ' X < -14 hr',
                    ' -14 <= X < 0 hr',
                    ' X = 0 hr',
                    ' 0 < X <= 7 hr',
                    ' 7 < X <= 15 hr',
                    ' 15 < X <= 30 hr',
                    ' X >= 30 hr'
                ));
            
            $sql2 = "select if(min is null and max is not null, ' < 70 %',IF(max is null and min is not null,' > 100 %',concat(min,' < X <= ',max))) as string,gt30,gt15,gt7,gt0,x0,lt0,lt14
                         from paymentscaledet a
                         where a.paymentscaleid = {$row['paymentscaleid']} ";
            $dataReader = Yii::app()->db->createCommand($sql2)->queryAll();
            foreach($dataReader as $row3)
            {
                $this->pdf->setbordercell(array('LR','L','L','L','L','L','L','LR'));
                $this->pdf->row(array($row3['string'],
                    Yii::app()->format->formatNumber($row3['lt14']).' %',
                    Yii::app()->format->formatNumber($row3['lt0']).' %',
                    Yii::app()->format->formatNumber($row3['x0']).' %',
                    Yii::app()->format->formatNumber($row3['gt0']).' %',
                    Yii::app()->format->formatNumber($row3['gt7']).' %',
                    Yii::app()->format->formatNumber($row3['gt15']).' %',
                    Yii::app()->format->formatNumber($row3['gt30']).' %',
                ));
            }
            $this->pdf->setbordercell(array('LBRT','TB','LBT','LBT','LBT','LBT','LBT','LBRT'));
            $this->pdf->row(array('X = Umur T.O.P','','','','','','',''));
            //$this->pdf->row(array(''));
            
            $this->pdf->setbordercell(array('TLB','TLBR'));
            $this->pdf->setY($this->pdf->getY()+10);
            $this->pdf->checkNewPage(20);
            $sqlscalecust = "select a.paramvalue, b.custcategoryname
                            from paymentscalecat a
                            join custcategory b on b.custcategoryid = a.custcategoryid
                            where a.paymentscaleid = ".$row['paymentscaleid']."";
            $scalecust = Yii::app()->db->createCommand($sqlscalecust)->queryAll();
            $this->pdf->setFont('Arial','',9);
            $this->pdf->colalign = array('C','C');
            $this->pdf->colheader = array($this->getCatalog('custcategory'),$this->getCatalog('paramvalue'));
            $this->pdf->setwidths(array(90,35));
            $this->pdf->Rowheader(); 
            
            foreach($scalecust as $row2)
            {          
                $this->pdf->setFont('Arial','',8);
                $this->pdf->setwidths(array(90,35));
                $this->pdf->coldetailalign = array('L','R');
                $this->pdf->row(array($row2['custcategoryname'],
                        Yii::app()->format->formatNumber($row2['paramvalue']).' %'));
            }
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+15,'Dibuat Oleh');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+15,'Mengetahui');
            $this->pdf->text($this->pdf->getX()+213,$this->pdf->getY()+15,'Disetujui');
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+30,'(..................)');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+30,'(..................)');
            $this->pdf->text($this->pdf->getX()+210,$this->pdf->getY()+30,'(..................)');
            
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+40,'NB : ');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+45,'1. SKALA BERSIFAT FLEKSIBLE');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+50,'2. DAPAT BERUBAH DAN BERBEDA PER CABANG PER BULAN');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+55,'3. DI INPUT SETIAP BULAN');
        }
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=4;
		$this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('paymentscaleid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('docdate'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('perioddate'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('statusname'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('paramspv'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['paymentscaleid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['docdate'])
->setCellValueByColumnAndRow(3, $i+1, $row1['perioddate'])
->setCellValueByColumnAndRow(5, $i+1, $row1['statusname'])
->setCellValueByColumnAndRow(6, $i+1, $row1['paramspv']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
