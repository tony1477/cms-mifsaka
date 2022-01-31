<?php

class salesscaleController extends AdminController
{
	protected $menuname = 'salesscale';
	public $module = 'Order';
	protected $pageTitle = 'Skala Komisi Penjualan';
	public $wfname = 'appss';
	protected $sqldata = "select a0.salesscaleid,a0.companyid,a0.perioddate,a0.docdate,a0.recordstatus,a0.statusname,a1.companyname as companyname,a0.statusname,a0.paramspv,a0.minscale,a0.docno,a0.spvscale
    from salesscale a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
    protected $sqldatasalesscaledet = "select a0.salesscaledetid,a0.salesscaleid,a0.materialgroupid,a0.gt120,a0.gt100,a0.gt90,a0.gt80,a0.gt70,a1.description as description 
    from salesscaledet a0 
    left join materialgroup a1 on a1.materialgroupid = a0.materialgroupid
  ";
    protected $sqldatasalesscalecat = "select a0.salesscalecatid, a0.salesscaleid,a0.custcategoryid,a0.paramvalue, a1.custcategoryname
    from salesscalecat a0
    left join custcategory a1 on a1.custcategoryid = a0.custcategoryid
    ";
    protected $sqlcount = "select count(1) 
    from salesscale a0 
    left join company a1 on a1.companyid = a0.companyid
  ";
    protected $sqlcountsalesscaledet = "select count(1) 
    from salesscaledet a0 
    left join materialgroup a1 on a1.materialgroupid = a0.materialgroupid
  ";
    protected $sqlcountsalesscalecat = "select count(1)
    from salesscalecat a0
    left join custcategory a1 on a1.custcategoryid = a0.custcategoryid
    ";

	protected function getSQL()
	{
		$maxstat = Yii::app()->db->createCommand("select getwfmaxstatbywfname('appss')")->queryScalar();
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus in (".getUserRecordStatus('listss').")
								and a0.recordstatus < {$maxstat}
                and a0.companyid in (".getUserObjectValues('company').") ";
        
        if ((isset($_REQUEST['companyname'])))
		{				
			$where .= " and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
        if ((isset($_REQUEST['perioddate'])))
		{				
			$where .= " and a0.perioddate like '%". $_REQUEST['perioddate']."%'"; 
		}
		if (isset($_REQUEST['salesscaleid']))
			{
				if (($_REQUEST['salesscaleid'] !== '0') && ($_REQUEST['salesscaleid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.salesscaleid in (".$_REQUEST['salesscaleid'].")";
					}
					else
					{
						$where .= " and a0.salesscaleid in (".$_REQUEST['salesscaleid'].")";
					}
				}
			}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
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
                $sql = 'call CheckDetailSalesScale(:vid,:vcreatedby)';
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
    public function actionCopysalesscale()
    {
        if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call CopySalesScale(:vid,:vcreatedby)';
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
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
			'keyField'=>'salesscaleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'salesscaleid','companyid','perioddate','docdate','recordstatus','paramspv','minscale','docno','spvscale'
				),
				'defaultOrder' => array( 
					'salesscaleid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['salesscaleid']))
		{
			$this->sqlcountsalesscaledet .= ' where a0.salesscaleid = '.$_REQUEST['salesscaleid'];
			$this->sqldatasalesscaledet .= ' where a0.salesscaleid = '.$_REQUEST['salesscaleid'];
            
            $this->sqlcountsalesscalecat .= ' where a0.salesscaleid = '.$_REQUEST['salesscaleid'];
			$this->sqldatasalesscalecat .= ' where a0.salesscaleid = '.$_REQUEST['salesscaleid'];
		}
		$countsalesscaledet = Yii::app()->db->createCommand($this->sqlcountsalesscaledet)->queryScalar();
$dataProvidersalesscaledet=new CSqlDataProvider($this->sqldatasalesscaledet,array(
					'totalItemCount'=>$countsalesscaledet,
					'keyField'=>'salesscaledetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'salesscaledetid' => CSort::SORT_DESC
						),
					),
					));
        $countsalesscalecat = Yii::app()->db->createCommand($this->sqlcountsalesscalecat)->queryScalar();
        
        $dataProvidersalesscalecat = new CSqlDataProvider($this->sqldatasalesscalecat,array(
					'totalItemCount'=>$countsalesscalecat,
					'keyField'=>'salesscalecatid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'salesscalecatid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProvidersalesscaledet'=>$dataProvidersalesscaledet,'dataProvidersalesscalecat'=>$dataProvidersalesscalecat));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into salesscale (companyid,docdate,perioddate,recordstatus) values (companyid,docdate,perioddate,".$this->findstatusbyuser('insss').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
			'salesscaleid'=>$id,
			"perioddate" =>date("Y-m-d"),
            "docdate" =>date("Y-m-d"),
            "recordstatus" =>$this->findstatusbyuser("insss")
		));
	}
  public function actionCreatesalesscaledet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"gt120" =>0,
            "gt100" =>0,
            "gt90" =>0,
            "gt80" =>0,
            "gt70" =>0
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.salesscaleid = '.$id)->queryRow();
			//if ($this->CheckDoc($model['recordstatus']) == '')
			//{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'salesscaleid'=>$model['salesscaleid'],
                        'companyid'=>$model['companyid'],
                        'perioddate'=>$model['perioddate'],
                        'docdate'=>$model['docdate'],
                        'recordstatus'=>$model['recordstatus'],
                        'paramspv'=>$model['paramspv'],
                        'minscale'=>$model['minscale'],
                        'spvscale'=>$model['spvscale'],
                        'companyname'=>$model['companyname'],
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

  public function actionUpdatesalesscaledet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasalesscaledet.' where salesscaledetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'salesscaledetid'=>$model['salesscaledetid'],
                    'salesscaleid'=>$model['salesscaleid'],
                    'materialgroupid'=>$model['materialgroupid'],
                    'gt120'=>$model['gt120'],
                    'gt100'=>$model['gt100'],
                    'gt90'=>$model['gt90'],
                    'gt80'=>$model['gt80'],
                    'gt70'=>$model['gt70'],
                    'description'=>$model['description'],
				));
				Yii::app()->end();
			}
		}
	}
	
    public function actionUpdatesalesscalecat()
    {
        parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatasalesscalecat.' where salesscalecatid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'salesscalecatid'=>$model['salesscalecatid'],
                    'salesscaleid'=>$model['salesscaleid'],
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
			array('salesscaleid','string','emptysalesscaleid'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesscaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatesalesscale (:salesscaleid,:companyid,:perioddate,:docdate,:paramspv,:minscale,:spvscale,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':salesscaleid',$_POST['salesscaleid'],PDO::PARAM_STR);
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
                $command->bindvalue(':perioddate',(($_POST['perioddate']!=='')?$_POST['perioddate']:null),PDO::PARAM_STR);
                $command->bindvalue(':docdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':paramspv',(($_POST['paramspv']!=='')?$_POST['paramspv']:null),PDO::PARAM_STR);
                $command->bindvalue(':minscale',(($_POST['minscale']!=='')?$_POST['minscale']:null),PDO::PARAM_STR);
                $command->bindvalue(':spvscale',(($_POST['spvscale']!=='')?$_POST['spvscale']:null),PDO::PARAM_STR);
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
public function actionSavesalesscaledet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('salesscaleid','string','emptysalesscaleid'),
      array('materialgroupid','string','emptymaterialgroupid'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesscaledetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatesalesscaledetail(:vid,:vsalesscaleid,:vmatgroupid,:vgt120,:vgt100,:vgt90,:vgt80,:vgt70,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertsalesscaledetail(:vsalesscaleid,:vmatgroupid,vgt120,:vgt100,:vgt90,:vgt80,:vgt70,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['salesscaledetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vsalesscaleid',(($_POST['salesscaleid']!=='')?$_POST['salesscaleid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmatgroupid',(($_POST['materialgroupid']!=='')?$_POST['materialgroupid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt120',(($_POST['gt120']!=='')?$_POST['gt120']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt100',(($_POST['gt100']!=='')?$_POST['gt100']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt90',(($_POST['gt90']!=='')?$_POST['gt90']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt80',(($_POST['gt80']!=='')?$_POST['gt80']:null),PDO::PARAM_STR);
                $command->bindvalue(':vgt70',(($_POST['gt70']!=='')?$_POST['gt70']:null),PDO::PARAM_STR);
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
	
public function actionSavesalesscalecat()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('salesscaleid','string','emptysalesscaleid'),
            array('custcategoryid','string','emptycustcategoryid'),
            array('paramvalue','string','emptyparamvalue'),
    ));
		if ($error == false)
		{
			$id = $_POST['salesscaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatesalesscalecat(:vid,:vsalesscaleid,:vcustcategoryid,:vparamvalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertsalesscalecat(:vsalesscaleid,:vcustcategoryid,:vparamvalue,:vcreatedby';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['salesscalecatid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vsalesscaleid',(($_POST['salesscaleid']!=='')?$_POST['salesscaleid']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvesalesscale(:vid,:vcreatedby)';
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
				$sql = 'call Deletesalesscale(:vid,:vcreatedby)';
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
				$sql = "delete from salesscale where salesscaleid = ".$id[$i];
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
	}public function actionPurgesalesscaledet()
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
				$sql = "delete from salesscaledet where salesscaledetid = ".$id[$i];
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
        $this->pdf->title='Ketentuan Skala Komisi Penjualan';
        
        $sql = "select a.companyid, b.companycode, a.perioddate, a.salesscaleid
                from salesscale a
                join company b on b.companyid = a.companyid";
        if($_GET['salesscale_0_salesscaleid'] !== '')
            {
                $where = " and a.salesscaleid in(".$_GET['salesscale_0_salesscaleid'].")";
            }
            else
            {
                $where = ' where salesscaleid = 0 ';
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
            $sql1 = "select materialgroupid, description from materialgroup a where isfg = 1";
            $res1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $this->pdf->setFont('Arial','',9);
            $this->pdf->colalign = array('C','C','C','C','C','C');
            $this->pdf->colheader = array($this->getCatalog('description'),$this->getCatalog('gt120'),$this->getCatalog('gt100'),$this->getCatalog('gt90'),$this->getCatalog('gt80'),$this->getCatalog('gt70'));
            $this->pdf->setwidths(array(90,35,35,35,35,35));
            $this->pdf->Rowheader();        
            
            foreach($res1 as $row1)
            {
                $sql2 = "select b.description, ifnull(gt120,0) as gt120, ifnull(gt100,0) as gt100, ifnull(gt90,0) as gt90, ifnull(gt80,0) as gt80, ifnull(gt70,0) as gt70
                         from materialgroup  b
                         left join salesscaledet a on a.materialgroupid = b.materialgroupid and a.salesscaleid={$row['salesscaleid']}
                         where b.materialgroupid = {$row1['materialgroupid']}";
                         
                $row3 = Yii::app()->db->createCommand($sql2)->queryRow();
                
                $this->pdf->setFont('Arial','',8);
                $this->pdf->setwidths(array(90,35,35,35,35,35));
                $this->pdf->coldetailalign = array('L','C','C','C','C','C');
                $this->pdf->row(array($row1['description'],
                        Yii::app()->format->formatNumber($row3['gt120']),
                        Yii::app()->format->formatNumber($row3['gt100']),
                        Yii::app()->format->formatNumber($row3['gt90']),
                        Yii::app()->format->formatNumber($row3['gt80']),
                        Yii::app()->format->formatNumber($row3['gt70']),
                    ));
            }
            
            $this->pdf->setY($this->pdf->getY()+15);
            $this->pdf->checkNewPage(20);
            $sqlscalecust = "select a.paramvalue, b.custcategoryname
                            from salesscalecat a
                            join custcategory b on b.custcategoryid = a.custcategoryid
                            where a.salesscaleid = ".$row['salesscaleid']."";
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
            $this->pdf->setY($this->pdf->getY()+5);
            $this->pdf->setFont('Arial','',10);
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+5,'Dibuat Oleh');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+5,'Mengetahui');
            $this->pdf->text($this->pdf->getX()+235,$this->pdf->getY()+5,'Disetujui');
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+20,'(..................)');
            $this->pdf->text($this->pdf->getX()+125,$this->pdf->getY()+20,'(..................)');
            $this->pdf->text($this->pdf->getX()+235,$this->pdf->getY()+20,'(..................)');
            
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+30,'NB : ');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+35,'1. SKALA BERSIFAT FLEKSIBLE');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+40,'2. DAPAT BERUBAH DAN BERBEDA PER CABANG PER BULAN');
            $this->pdf->text($this->pdf->getX(),$this->pdf->getY()+45,'3. DI INPUT SETIAP BULAN');
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
                ->setCellValueByColumnAndRow(0,4,$this->getCatalog('salesscaleid'))
                ->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
                ->setCellValueByColumnAndRow(2,4,$this->getCatalog('perioddate'))
                ->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
                ->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'))
                ->setCellValueByColumnAndRow(5,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $i+1, $row1['salesscaleid'])
                ->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
                ->setCellValueByColumnAndRow(2, $i+1, $row1['perioddate'])
                ->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
                ->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus'])
                ->setCellValueByColumnAndRow(5, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
