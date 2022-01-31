<?php

class CompanyController extends AdminController
{
	protected $menuname = 'company';
	public $module = 'Admin';
	protected $pageTitle = 'Perusahaan';
	public $wfname = '';
	protected $sqldata = "select a0.companyid,a0.companyname,a0.companycode,a0.address,a0.cityid,a0.zipcode,a0.taxno,a0.currencyid,a0.faxno,a0.phoneno,a0.webaddress,a0.email,a0.leftlogofile,a0.rightlogofile,a0.isholding,a0.billto,a0.bankacc1,a0.bankacc2,a0.bankacc3,a0.recordstatus,a1.cityname as cityname,a2.currencyname as currencyname,getwfstatusbywfname('',a0.recordstatus) as statusname  
    from company a0 
    left join city a1 on a1.cityid = a0.cityid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";
  protected $sqlcount = "select count(1) 
    from company a0 
    left join city a1 on a1.cityid = a0.cityid
    left join currency a2 on a2.currencyid = a0.currencyid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['companycode'])) && (isset($_REQUEST['address'])) && (isset($_REQUEST['zipcode'])) && (isset($_REQUEST['taxno'])) && (isset($_REQUEST['faxno'])) && (isset($_REQUEST['phoneno'])) && (isset($_REQUEST['webaddress'])) && (isset($_REQUEST['email'])) && (isset($_REQUEST['leftlogofile'])) && (isset($_REQUEST['rightlogofile'])) && (isset($_REQUEST['billto'])) && (isset($_REQUEST['bankacc1'])) && (isset($_REQUEST['bankacc2'])) && (isset($_REQUEST['bankacc3'])) && (isset($_REQUEST['cityname'])) && (isset($_REQUEST['currencyname'])))
		{				
			$where .=  " 
and a0.companyname like '%". $_REQUEST['companyname']."%' 
and a0.companycode like '%". $_REQUEST['companycode']."%' 
and a0.address like '%". $_REQUEST['address']."%' 
and a0.zipcode like '%". $_REQUEST['zipcode']."%' 
and a0.taxno like '%". $_REQUEST['taxno']."%' 
and a0.faxno like '%". $_REQUEST['faxno']."%' 
and a0.phoneno like '%". $_REQUEST['phoneno']."%' 
and a0.webaddress like '%". $_REQUEST['webaddress']."%' 
and a0.email like '%". $_REQUEST['email']."%' 
and a0.leftlogofile like '%". $_REQUEST['leftlogofile']."%' 
and a0.rightlogofile like '%". $_REQUEST['rightlogofile']."%' 
and a0.billto like '%". $_REQUEST['billto']."%' 
and a0.bankacc1 like '%". $_REQUEST['bankacc1']."%' 
and a0.bankacc2 like '%". $_REQUEST['bankacc2']."%' 
and a0.bankacc3 like '%". $_REQUEST['bankacc3']."%' 
and a1.cityname like '%". $_REQUEST['cityname']."%' 
and a2.currencyname like '%". $_REQUEST['currencyname']."%'"; 
		}
		if (isset($_REQUEST['companyid']))
			{
				if (($_REQUEST['companyid'] !== '0') && ($_REQUEST['companyid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.companyid in (".$_REQUEST['companyid'].")";
					}
					else
					{
						$where .= " and a0.companyid in (".$_REQUEST['companyid'].")";
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
			'keyField'=>'companyid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'companyid','companyname','companycode','address','cityid','zipcode','taxno','currencyid','faxno','phoneno','webaddress','email','leftlogofile','rightlogofile','isholding','billto','bankacc1','bankacc2','bankacc3','statusname'
				),
				'defaultOrder' => array( 
					'companyid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	public function actionCreate()
	{
		parent::actionCreate();echo CJSON::encode(array(
			'status'=>'success',
			
			"currencyid" => $this->GetParameter("basecurrencyid"),										"currencyname" => $this->GetParameter("basecurrency"),
      "recordstatus" =>$this->findstatusbyuser("")
		));
	}
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.companyid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'companyid'=>$model['companyid'],
					'companyname'=>$model['companyname'],
				'companycode'=>$model['companycode'],
				'address'=>$model['address'],
				'cityid'=>$model['cityid'],
				'zipcode'=>$model['zipcode'],
				'taxno'=>$model['taxno'],
				'currencyid'=>$model['currencyid'],
				'faxno'=>$model['faxno'],
				'phoneno'=>$model['phoneno'],
				'webaddress'=>$model['webaddress'],
				'email'=>$model['email'],
				'leftlogofile'=>$model['leftlogofile'],
				'rightlogofile'=>$model['rightlogofile'],
				'isholding'=>$model['isholding'],
				'billto'=>$model['billto'],
				'bankacc1'=>$model['bankacc1'],
				'bankacc2'=>$model['bankacc2'],
				'bankacc3'=>$model['bankacc3'],
				'cityname'=>$model['cityname'],
				'currencyname'=>$model['currencyname'],

				));
				Yii::app()->end();
			}
		}
	}
	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('companyname','string','emptycompanyname'),
      array('companycode','string','emptycompanycode'),
      array('address','string','emptyaddress'),
      array('cityid','string','emptycityid'),
      array('zipcode','string','emptyzipcode'),
      array('currencyid','string','emptycurrencyid'),
      array('billto','string','emptybillto'),
    ));
		if ($error == false)
		{
			$id = $_POST['companyid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update company 
			      set companyname = :companyname,companycode = :companycode,address = :address,cityid = :cityid,zipcode = :zipcode,taxno = :taxno,currencyid = :currencyid,faxno = :faxno,phoneno = :phoneno,webaddress = :webaddress,email = :email,leftlogofile = :leftlogofile,rightlogofile = :rightlogofile,isholding = :isholding,billto = :billto,bankacc1 = :bankacc1,bankacc2 = :bankacc2,bankacc3 = :bankacc3 
			      where companyid = :companyid';
				}
				else
				{
					$sql = 'insert into company (companyname,companycode,address,cityid,zipcode,taxno,currencyid,faxno,phoneno,webaddress,email,leftlogofile,rightlogofile,isholding,billto,bankacc1,bankacc2,bankacc3) 
			      values (:companyname,:companycode,:address,:cityid,:zipcode,:taxno,:currencyid,:faxno,:phoneno,:webaddress,:email,:leftlogofile,:rightlogofile,:isholding,:billto,:bankacc1,:bankacc2,:bankacc3)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':companyid',$_POST['companyid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyname',(($_POST['companyname']!=='')?$_POST['companyname']:null),PDO::PARAM_STR);
        $command->bindvalue(':companycode',(($_POST['companycode']!=='')?$_POST['companycode']:null),PDO::PARAM_STR);
        $command->bindvalue(':address',(($_POST['address']!=='')?$_POST['address']:null),PDO::PARAM_STR);
        $command->bindvalue(':cityid',(($_POST['cityid']!=='')?$_POST['cityid']:null),PDO::PARAM_STR);
        $command->bindvalue(':zipcode',(($_POST['zipcode']!=='')?$_POST['zipcode']:null),PDO::PARAM_STR);
        $command->bindvalue(':taxno',(($_POST['taxno']!=='')?$_POST['taxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':currencyid',(($_POST['currencyid']!=='')?$_POST['currencyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':faxno',(($_POST['faxno']!=='')?$_POST['faxno']:null),PDO::PARAM_STR);
        $command->bindvalue(':phoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
        $command->bindvalue(':webaddress',(($_POST['webaddress']!=='')?$_POST['webaddress']:null),PDO::PARAM_STR);
        $command->bindvalue(':email',(($_POST['email']!=='')?$_POST['email']:null),PDO::PARAM_STR);
        $command->bindvalue(':leftlogofile',(($_POST['leftlogofile']!=='')?$_POST['leftlogofile']:null),PDO::PARAM_STR);
        $command->bindvalue(':rightlogofile',(($_POST['rightlogofile']!=='')?$_POST['rightlogofile']:null),PDO::PARAM_STR);
        $command->bindvalue(':isholding',(($_POST['isholding']!=='')?$_POST['isholding']:null),PDO::PARAM_STR);
        $command->bindvalue(':billto',(($_POST['billto']!=='')?$_POST['billto']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankacc1',(($_POST['bankacc1']!=='')?$_POST['bankacc1']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankacc2',(($_POST['bankacc2']!=='')?$_POST['bankacc2']:null),PDO::PARAM_STR);
        $command->bindvalue(':bankacc3',(($_POST['bankacc3']!=='')?$_POST['bankacc3']:null),PDO::PARAM_STR);
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
				$sql = 'call Approvecompany(:vid,:vcreatedby)';
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
				$sql = 'call Deletecompany(:vid,:vcreatedby)';
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
				$sql = "delete from company where companyid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('company');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('companyid'),$this->getCatalog('companyname'),$this->getCatalog('companycode'),$this->getCatalog('address'),$this->getCatalog('city'),$this->getCatalog('zipcode'),$this->getCatalog('taxno'),$this->getCatalog('currency'),$this->getCatalog('faxno'),$this->getCatalog('phoneno'),$this->getCatalog('webaddress'),$this->getCatalog('email'),$this->getCatalog('leftlogofile'),$this->getCatalog('rightlogofile'),$this->getCatalog('isholding'),$this->getCatalog('billto'),$this->getCatalog('bankacc1'),$this->getCatalog('bankacc2'),$this->getCatalog('bankacc3'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,40,40,40,40,40,40,15,40,30,30,30,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['companyid'],$row1['companyname'],$row1['companycode'],$row1['address'],$row1['cityname'],$row1['zipcode'],$row1['taxno'],$row1['currencyname'],$row1['faxno'],$row1['phoneno'],$row1['webaddress'],$row1['email'],$row1['leftlogofile'],$row1['rightlogofile'],$row1['isholding'],$row1['billto'],$row1['bankacc1'],$row1['bankacc2'],$row1['bankacc3'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('companyid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('companycode'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('address'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('cityname'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('zipcode'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('taxno'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('currencyname'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('faxno'))
->setCellValueByColumnAndRow(9,4,$this->getCatalog('phoneno'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('webaddress'))
->setCellValueByColumnAndRow(11,4,$this->getCatalog('email'))
->setCellValueByColumnAndRow(12,4,$this->getCatalog('leftlogofile'))
->setCellValueByColumnAndRow(13,4,$this->getCatalog('rightlogofile'))
->setCellValueByColumnAndRow(14,4,$this->getCatalog('isholding'))
->setCellValueByColumnAndRow(15,4,$this->getCatalog('billto'))
->setCellValueByColumnAndRow(16,4,$this->getCatalog('bankacc1'))
->setCellValueByColumnAndRow(17,4,$this->getCatalog('bankacc2'))
->setCellValueByColumnAndRow(18,4,$this->getCatalog('bankacc3'))
->setCellValueByColumnAndRow(19,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['companyid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['companycode'])
->setCellValueByColumnAndRow(3, $i+1, $row1['address'])
->setCellValueByColumnAndRow(4, $i+1, $row1['cityname'])
->setCellValueByColumnAndRow(5, $i+1, $row1['zipcode'])
->setCellValueByColumnAndRow(6, $i+1, $row1['taxno'])
->setCellValueByColumnAndRow(7, $i+1, $row1['currencyname'])
->setCellValueByColumnAndRow(8, $i+1, $row1['faxno'])
->setCellValueByColumnAndRow(9, $i+1, $row1['phoneno'])
->setCellValueByColumnAndRow(10, $i+1, $row1['webaddress'])
->setCellValueByColumnAndRow(11, $i+1, $row1['email'])
->setCellValueByColumnAndRow(12, $i+1, $row1['leftlogofile'])
->setCellValueByColumnAndRow(13, $i+1, $row1['rightlogofile'])
->setCellValueByColumnAndRow(14, $i+1, $row1['isholding'])
->setCellValueByColumnAndRow(15, $i+1, $row1['billto'])
->setCellValueByColumnAndRow(16, $i+1, $row1['bankacc1'])
->setCellValueByColumnAndRow(17, $i+1, $row1['bankacc2'])
->setCellValueByColumnAndRow(18, $i+1, $row1['bankacc3'])
->setCellValueByColumnAndRow(19, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}