<?php

class AccountController extends AdminController
{
	protected $menuname = 'account';
	public $module = 'Accounting';
	protected $pageTitle = 'Akun';
	public $wfname = '';
	protected $sqldata = "select a0.accountid,a0.companyid,a0.accountcode,a0.accountname,a0.parentaccountid,a0.currencyid,a0.accounttypeid,a0.recordstatus,a1.companyname as companyname,a1.companycode as companycode,a2.accountcode as parentaccountcode,a3.currencyname as currencyname,a4.accounttypename as accounttypename
    from account a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.parentaccountid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join accounttype a4 on a4.accounttypeid = a0.accounttypeid
  ";
  protected $sqlcount = "select count(1) 
    from account a0 
    left join company a1 on a1.companyid = a0.companyid
    left join account a2 on a2.accountid = a0.parentaccountid
    left join currency a3 on a3.currencyid = a0.currencyid
    left join accounttype a4 on a4.accounttypeid = a0.accounttypeid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "where a0.companyid in (".getUserObjectValues('company').")";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['accountcode'])) && (isset($_REQUEST['accountname'])) && (isset($_REQUEST['parentaccountname'])) && (isset($_REQUEST['currencyname'])) && (isset($_REQUEST['accounttypename'])))
		{				
			if ($_REQUEST['companyname'] != "")
            {
                $where .= " and a1.companyname like '%". $_REQUEST['companyname']."%'
                "; 
            }
            if ($_REQUEST['accountcode'] != "")
            {
                $where .= " and a0.accountcode like '%". $_REQUEST['accountcode']."%'
                "; 
            }
            if ($_REQUEST['accountname'] != "")
            {
                $where .= " and a0.accountname like '%". $_REQUEST['accountname']."%'
                "; 
            }
            if ($_REQUEST['parentaccountname'] != "")
            {
                $where .= " and a2.accountname like '%". $_REQUEST['parentaccountname']."%'
                "; 
            }
            if ($_REQUEST['currencyname'] != "")
            {
                $where .= " and a3.currencyname like '%". $_REQUEST['currencyname']."%'
                "; 
            }
            if ($_REQUEST['accounttypename'] != "")
            {
                $where .= " and a4.accounttypename like '%". $_REQUEST['accounttypename']."%'
                "; 
            }
            $where .= " order by a0.accountcode asc";
		}
		if (isset($_REQUEST['accountid']))
        {
            if (($_REQUEST['accountid'] !== '0') && ($_REQUEST['accountid'] !== ''))
            {
                if ($where == "")
                {
                    $where .= " where a0.accountid in (".$_REQUEST['accountid'].")";
                }
                else
                {
                    $where .= " and a0.accountid in (".$_REQUEST['accountid'].")";
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
			for ($i = 3;$i <= $highestRow; $i++)
			{	
                $accid = $sheet->getCell('A'.$i)->getValue();
				$company = $sheet->getCell('B'.$i)->getValue();
				$companyid = Yii::app()->db->createCommand("select companyid from company where lower(companycode) = lower('".$company."')")->queryScalar();
				if ($companyid == null)
				{
					$this->getMessage('error','emptycompanyid');
				}
				$accountcode = $sheet->getCell('C'.$i)->getValue();
				$accountname = $sheet->getCell('D'.$i)->getValue();
				$parentaccount = $sheet->getCell('E'.$i)->getValue();
				$parentid = Yii::app()->db->createCommand("select accountid 
					from account 
					where companyid = ".$companyid." and lower(accountcode) = lower('".$parentaccount."')")->queryScalar();
				$currency = $sheet->getCell('F'.$i)->getValue();
				$currencyid = Yii::app()->db->createCommand("select currencyid from currency where lower(currencyname) = lower('".$currency."')")->queryScalar();
				if ($currencyid == null)
				{
					$this->getMessage('error','emptycurrencyid');
				}
				$accounttype = $sheet->getCell('G'.$i)->getValue();
				$accounttypeid = Yii::app()->db->createCommand("select accounttypeid from accounttype where lower(accounttypename) = lower('".$accounttype."')")->queryScalar();
				if ($accounttypeid == null)
				{
					$this->getMessage('error','emptyaccounttypeid');
				}
				$recordstatus = $sheet->getCell('H'.$i)->getValue();
                
				if ($accid != "")
                {
                    $sql = 'update account
                            set companyid = :companyid,accountcode = :accountcode,accountname = :accountname,parentaccountid = :parentaccountid,currencyid = :currencyid,accounttypeid = :accounttypeid,recordstatus = :recordstatus
                            where accountid = '.$accid;
                }
                else
                {
					$sql = 'insert into account (companyid,accountcode,accountname,parentaccountid,currencyid,accounttypeid,recordstatus) 
                            values (:companyid,:accountcode,:accountname,:parentaccountid,:currencyid,:accounttypeid,:recordstatus)';
				}                
                $command = $connection->createCommand($sql);
                $command->bindvalue(':companyid',$companyid,PDO::PARAM_STR);
                $command->bindvalue(':accountcode',$accountcode,PDO::PARAM_STR);
                $command->bindvalue(':accountname',$accountname,PDO::PARAM_STR);
                $command->bindvalue(':parentaccountid',(($parentid!==null)?$parentid:null),PDO::PARAM_STR);
                $command->bindvalue(':currencyid',$currencyid,PDO::PARAM_STR);
                $command->bindvalue(':accounttypeid',$accounttypeid,PDO::PARAM_STR);
                $command->bindvalue(':recordstatus',$recordstatus,PDO::PARAM_STR);
                $command->execute();
			}
			$this->getMessage('success',"alreadysaved");
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
			'keyField'=>'accountid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'accountid','companyid','accountcode','accountname','parentaccountid','currencyid','accounttypeid','recordstatus'
				),
				'defaultOrder' => array( 
					'accountid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"companyid" => $company["companyid"],										"companyname" => $company["companyname"],
      "currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.accountid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'accountid'=>$model['accountid'],
          'companyid'=>$model['companyid'],
          'accountcode'=>$model['accountcode'],
          'accountname'=>$model['accountname'],
          'parentaccountid'=>$model['parentaccountid'],
          'currencyid'=>$model['currencyid'],
          'accounttypeid'=>$model['accounttypeid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'companycode'=>$model['companycode'],
          'parentaccountid'=>$model['parentaccountid'],
          'parentaccountcode'=>$model['parentaccountcode'], 
          'currencyname'=>$model['currencyname'],
          'accounttypename'=>$model['accounttypename'],

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
      array('accountcode','string','emptyaccountcode'),
      array('accountname','string','emptyaccountname'),
      array('currencyid','string','emptycurrencyid'),
      array('accounttypeid','string','emptyaccounttypeid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['accountid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update account 
			      set companyid = :companyid,accountcode = :accountcode,accountname = :accountname,parentaccountid = :parentaccountid,currencyid = :currencyid,accounttypeid = :accounttypeid,recordstatus = :recordstatus 
			      where accountid = :accountid';
				}
				else
				{
					$sql = 'insert into account (companyid,accountcode,accountname,parentaccountid,currencyid,accounttypeid,recordstatus) 
			      values (:companyid,:accountcode,:accountname,:parentaccountid,:currencyid,:accounttypeid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':accountid',$_POST['accountid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountcode',(($_POST['accountcode']!=='')?$_POST['accountcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':accountname',(($_POST['accountname']!=='')?$_POST['accountname']:null),PDO::PARAM_STR);
        $command->bindvalue(':parentaccountid',(($_POST['parentaccountid']!=='')?$_POST['parentaccountid']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accounttypeid',(($_POST['accounttypeid']!=='')?$_POST['accounttypeid']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from account where accountid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update account set recordstatus = 0 where accountid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update account set recordstatus = 1 where accountid = ".$id[$i];
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
				$sql = "delete from account where accountid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('account');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('accountid'),$this->getCatalog('company'),$this->getCatalog('accountcode'),$this->getCatalog('accountname'),$this->getCatalog('parentaccount'),$this->getCatalog('currency'),$this->getCatalog('accounttype'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['accountid'],$row1['companyname'],$row1['accountcode'],$row1['accountname'],$row1['parentaccountcode'],$row1['currencyname'],$row1['accounttypename'],$row1['recordstatus']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}
	public function actionDownXLS()
	{
		parent::actionDownXLS();
		$this->getSQL();
		$dataReader=Yii::app()->db->createCommand($this->sqldata)->queryAll();
		$i=2;
		/*$this->phpExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,4,$this->getCatalog('accountid'))
            ->setCellValueByColumnAndRow(1,4,$this->getCatalog('companycode'))
            ->setCellValueByColumnAndRow(2,4,$this->getCatalog('accountcode'))
            ->setCellValueByColumnAndRow(3,4,$this->getCatalog('accountname'))
            ->setCellValueByColumnAndRow(4,4,$this->getCatalog('accountcode'))
            ->setCellValueByColumnAndRow(5,4,$this->getCatalog('currencyname'))
            ->setCellValueByColumnAndRow(6,4,$this->getCatalog('accounttypename'))
            ->setCellValueByColumnAndRow(7,4,$this->getCatalog('recordstatus'));*/
		foreach($dataReader as $row1)
		{
            $this->phpExcel->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow(0, $i+1, $row1['accountid'])
                ->setCellValueByColumnAndRow(1, $i+1, $row1['companycode'])
                ->setCellValueByColumnAndRow(2, $i+1, $row1['accountcode'])
                ->setCellValueByColumnAndRow(3, $i+1, $row1['accountname'])
                ->setCellValueByColumnAndRow(4, $i+1, $row1['parentaccountcode'])
                ->setCellValueByColumnAndRow(5, $i+1, $row1['currencyname'])
                ->setCellValueByColumnAndRow(6, $i+1, $row1['accounttypename'])
                ->setCellValueByColumnAndRow(7, $i+1, $row1['recordstatus']);
            $i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}