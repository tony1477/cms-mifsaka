<?php

class ScaleController extends AdminController
{
	protected $menuname = 'scale';
	public $module = 'Order';
	protected $pageTitle = 'Skala Komisi Sales';
	public $wfname = 'appss';
	protected $sqldata = "select a0.scaleid,a0.docdate,a0.startdate,a0.recordstatus,a0.statusname,a0.statusname,a0.spvscale,a0.docno
    from scale a0 
    -- left join company a1 on a1.companyid = a0.companyid
  ";
    protected $sqldatascaledet = "select a0.scaledetid,a0.scaleid,a0.materialgroupid,a1.description as description, a0.value
    from scaledet a0 
    left join materialgroup a1 on a1.materialgroupid = a0.materialgroupid
  ";
    protected $sqldatascalecat = "select a0.scalecatid, a0.scaleid,a0.custcategoryid,a0.`value`, a1.custcategoryname
    from scalecat a0
    left join custcategory a1 on a1.custcategoryid = a0.custcategoryid
    ";
    protected $sqlcount = "select count(1) 
    from scale a0 
    -- left join company a1 on a1.companyid = a0.companyid
  ";
    protected $sqlcountscaledet = "select count(1) 
    from scaledet a0 
    left join materialgroup a1 on a1.materialgroupid = a0.materialgroupid
  ";
    protected $sqlcountscalecat = "select count(1)
    from scalecat a0
    left join custcategory a1 on a1.custcategoryid = a0.custcategoryid
    ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a0.recordstatus in (".getUserRecordStatus('listss').")
                -- and a0.companyid in (".getUserObjectValues('company').") ";
        
        if ((isset($_REQUEST['companyname'])))
		{				
			$where .= " -- and a1.companyname like '%". $_REQUEST['companyname']."%'"; 
		}
        if ((isset($_REQUEST['docdate'])))
		{				
			$where .= " and a0.docdate like '%". $_REQUEST['docdate']."%'"; 
		}
		if (isset($_REQUEST['scaleid']))
			{
				if (($_REQUEST['scaleid'] !== '0') && ($_REQUEST['scaleid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.scaleid in (".$_REQUEST['scaleid'].")";
					}
					else
					{
						$where .= " and a0.scaleid in (".$_REQUEST['scaleid'].")";
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
                $sql = 'call CheckDetailScale(:vid,:vcreatedby)';
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
    public function actionCopyscale()
    {
        if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Copyscale(:vid,:vcreatedby)';
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
			'keyField'=>'scaleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'scaleid','companyid','startdate','docdate','recordstatus','spvscale','docno'
				),
				'defaultOrder' => array( 
					'scaleid' => CSort::SORT_DESC
				),
			),
		));
		if (isset($_REQUEST['scaleid']))
		{
			$this->sqlcountscaledet .= ' where a0.scaleid = '.$_REQUEST['scaleid'];
			$this->sqldatascaledet .= ' where a0.scaleid = '.$_REQUEST['scaleid'];
            
            $this->sqlcountscalecat .= ' where a0.scaleid = '.$_REQUEST['scaleid'];
			$this->sqldatascalecat .= ' where a0.scaleid = '.$_REQUEST['scaleid'];
		}
		$countscaledet = Yii::app()->db->createCommand($this->sqlcountscaledet)->queryScalar();
$dataProviderscaledet=new CSqlDataProvider($this->sqldatascaledet,array(
					'totalItemCount'=>$countscaledet,
					'keyField'=>'scaledetid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'scaledetid' => CSort::SORT_DESC
						),
					),
					));
        $countscalecat = Yii::app()->db->createCommand($this->sqlcountscalecat)->queryScalar();
        
        $dataProviderscalecat = new CSqlDataProvider($this->sqldatascalecat,array(
					'totalItemCount'=>$countscalecat,
					'keyField'=>'scalecatid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'scalecatid' => CSort::SORT_DESC
						),
					),
					));
		$this->render('index',array('dataProvider'=>$dataProvider,'dataProviderscaledet'=>$dataProviderscaledet,'dataProviderscalecat'=>$dataProviderscalecat));
	}

	public function actionCreate()
	{
		parent::actionCreate();
		$sql = "insert into scale (docdate,startdate,recordstatus) values (docdate,startdate,".$this->findstatusbyuser('insss').")";
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "select last_insert_id()";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
        echo CJSON::encode(array(
			'status'=>'success',
			'scaleid'=>$id,
			"startdate" =>date("Y-m-d"),
            "docdate" =>date("Y-m-d"),
            "recordstatus" =>$this->findstatusbyuser("insss")
		));
	}
  public function actionCreatescaledet()
	{
		parent::actionCreate();
		echo CJSON::encode(array(
			'status'=>'success',
			"value" =>0,
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.scaleid = '.$id)->queryRow();
			//if ($this->CheckDoc($model['recordstatus']) == '')
			//{
				if ($model !== null)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'scaleid'=>$model['scaleid'],
                        'startdate'=>$model['startdate'],
                        'docdate'=>$model['docdate'],
                        'recordstatus'=>$model['recordstatus'],
                        'spvscale'=>$model['spvscale'],
                        //'docno'=>$model['docno'],
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

  public function actionUpdatescaledet()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatascaledet.' where scaledetid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'scaledetid'=>$model['scaledetid'],
                    'scaleid'=>$model['scaleid'],
                    'materialgroupid'=>$model['materialgroupid'],
                    'value'=>$model['value'],
                    'description'=>$model['description'],
				));
				Yii::app()->end();
			}
		}
	}
	
    public function actionUpdatescalecat()
    {
        parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldatascalecat.' where scalecatid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'scalecatid'=>$model['scalecatid'],
                    'scaleid'=>$model['scaleid'],
                    'custcategoryid'=>$model['custcategoryid'],
                    'custcategoryname'=>$model['custcategoryname'],
                    'value'=>$model['value'],
				));
				Yii::app()->end();
			}
		}
    }
public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('scaleid','string','emptyscaleid'),
    ));
		if ($error == false)
		{
			$id = $_POST['scaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				$sql = 'call Updatescale (:vscaleid,:vstartdate,:vdocdate,:vspvscale,:vcreatedby)';
				$command = $connection->createCommand($sql);
				$command->bindvalue(':vscaleid',$_POST['scaleid'],PDO::PARAM_STR);
                $command->bindvalue(':vstartdate',(($_POST['startdate']!=='')?$_POST['startdate']:null),PDO::PARAM_STR);
                $command->bindvalue(':vdocdate',(($_POST['docdate']!=='')?$_POST['docdate']:null),PDO::PARAM_STR);
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
public function actionSavescaledet()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('scaleid','string','emptyscaleid'),
      array('materialgroupid','string','emptymaterialgroupid'),
    ));
		if ($error == false)
		{
			$id = $_POST['scaledetid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatescaledet(:vid,:vscaleid,:vmatgroupid,:vvalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertscaledet(:vscaleid,:vmatgroupid,vvalue,:vcreatedby)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['scaledetid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vscaleid',(($_POST['scaleid']!=='')?$_POST['scaleid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vmatgroupid',(($_POST['materialgroupid']!=='')?$_POST['materialgroupid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vvalue',(($_POST['value']!=='')?$_POST['value']:null),PDO::PARAM_STR);
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
	
public function actionSavescalecat()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('scaleid','string','emptyscaleid'),
            array('custcategoryid','string','emptycustcategoryid'),
            array('value','string','emptyvalue'),
    ));
		if ($error == false)
		{
			$id = $_POST['scaleid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'call Updatescalecat(:vid,:vscaleid,:vcustcategoryid,:vvalue,:vcreatedby)';
				}
				else
				{
					$sql = 'call Insertscalecat(:vscaleid,:vcustcategoryid,:vvalue,:vcreatedby';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':vid',$_POST['scalecatid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':vscaleid',(($_POST['scaleid']!=='')?$_POST['scaleid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vcustcategoryid',(($_POST['custcategoryid']!=='')?$_POST['custcategoryid']:null),PDO::PARAM_STR);
                $command->bindvalue(':vvalue',(($_POST['value']!=='')?$_POST['value']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvescale(:vid,:vcreatedby)';
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
				$sql = 'call Deletescale(:vid,:vcreatedby)';
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
				$sql = "delete from scale where scaleid = ".$id[$i];
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
	}public function actionPurgescaledet()
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
				$sql = "delete from scaledet where scaledetid = ".$id[$i];
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
        
        $sql = "select a.companyid, b.companycode, a.startdate, a.scaleid
                from scale a
                join company b on b.companyid = a.companyid";
        if($_GET['scale_0_scaleid'] !== '')
            {
                $where = " and a.scaleid in(".$_GET['scale_0_scaleid'].")";
            }
            else
            {
                $where = ' where scaleid = 0 ';
                $this->pdf->setFont('Arial','B',11);
                $this->pdf->text(10,10,'Harap Pilih Dokumen');
            }
        $res = Yii::app()->db->createCommand($sql.$where)->queryAll();
        foreach($res as $row)
        {
            $this->pdf->setFont('Arial','',10);
            $month = date('M',strtotime($row['startdate']));
            $year = date('Y',strtotime($row['startdate']));
            $this->pdf->Addpage('L','A4');
            $this->pdf->text(10,12,$row['companycode'].' PERIODE '.$month.' '.$year);
            $sql1 = "select materialgroupid, description from materialgroup a where isfg = 1";
            $res1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $this->pdf->setFont('Arial','',9);
            $this->pdf->colalign = array('C','C','C','C','C','C');
            $this->pdf->colheader = array($this->getCatalog('description'),$this->getCatalog('value'));
            $this->pdf->setwidths(array(90,35,35,35,35,35));
            $this->pdf->Rowheader();        
            
            foreach($res1 as $row1)
            {
                $sql2 = "select b.description, ifnull(value,0) as value
                         from materialgroup  b
                         left join scaledet a on a.materialgroupid = b.materialgroupid and a.scaleid={$row['scaleid']}
                         where b.materialgroupid = {$row1['materialgroupid']}";
                         
                $row3 = Yii::app()->db->createCommand($sql2)->queryRow();
                
                $this->pdf->setFont('Arial','',8);
                $this->pdf->setwidths(array(90,35,35,35,35,35));
                $this->pdf->coldetailalign = array('L','C','C','C','C','C');
                $this->pdf->row(array($row1['description'],
                        Yii::app()->format->formatNumber($row3['value']),
                    ));
            }
            
            $this->pdf->setY($this->pdf->getY()+15);
            $this->pdf->checkNewPage(20);
            $sqlscalecust = "select a.paramvalue, b.custcategoryname
                            from scalecat a
                            join custcategory b on b.custcategoryid = a.custcategoryid
                            where a.scaleid = ".$row['scaleid']."";
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
                ->setCellValueByColumnAndRow(0,4,$this->getCatalog('scaleid'))
                ->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
                ->setCellValueByColumnAndRow(2,4,$this->getCatalog('startdate'))
                ->setCellValueByColumnAndRow(3,4,$this->getCatalog('docdate'))
                ->setCellValueByColumnAndRow(4,4,$this->getCatalog('recordstatus'))
                ->setCellValueByColumnAndRow(5,4,$this->getCatalog('statusname'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $i+1, $row1['scaleid'])
                ->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
                ->setCellValueByColumnAndRow(2, $i+1, $row1['startdate'])
                ->setCellValueByColumnAndRow(3, $i+1, $row1['docdate'])
                ->setCellValueByColumnAndRow(4, $i+1, $row1['recordstatus'])
                ->setCellValueByColumnAndRow(5, $i+1, $row1['statusname']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
