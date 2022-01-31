<?php

class AddressaccountController extends AdminController
{
	protected $menuname = 'addressaccount';
	public $module = 'Common';
	protected $pageTitle = 'Address Accounting';
	public $wfname = '';
	protected $sqldata = "select a0.addressaccountid,a0.companyid,a0.addressbookid,a0.accpiutangid,a0.acchutangid,a0.recordstatus,a1.companyname as companyname,a2.fullname as fullname,a3.accountname as accpiutang,a4.accountname as acchutang 
    from addressaccount a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
    left join account a3 on a3.accountid = a0.accpiutangid
    left join account a4 on a4.accountid = a0.acchutangid
  ";
  protected $sqlcount = "select count(1) 
    from addressaccount a0 
    left join company a1 on a1.companyid = a0.companyid
    left join addressbook a2 on a2.addressbookid = a0.addressbookid
    left join account a3 on a3.accountid = a0.accpiutangid
    left join account a4 on a4.accountid = a0.acchutangid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['companyname'])) && (isset($_REQUEST['fullname'])) && (isset($_REQUEST['accpiutang'])) && (isset($_REQUEST['acchutang'])))
		{				
			$where .= " where a1.companyname like '%". $_REQUEST['companyname']."%' 
and a2.fullname like '%". $_REQUEST['fullname']."%' 
and a3.accountname like '%". $_REQUEST['accpiutang']."%' 
and a4.accountname like '%". $_REQUEST['acchutang']."%'"; 
		}
		if (isset($_REQUEST['addressaccountid']))
			{
				if (($_REQUEST['addressaccountid'] !== '0') && ($_REQUEST['addressaccountid'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a0.addressaccountid in (".$_REQUEST['addressaccountid'].")";
					}
					else
					{
						$where .= " and a0.addressaccountid in (".$_REQUEST['addressaccountid'].")";
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
			'keyField'=>'addressaccountid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'addressaccountid','companyid','addressbookid','accpiutangid','acchutangid','recordstatus'
				),
				'defaultOrder' => array( 
					'addressaccountid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
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
			$model = Yii::app()->db->createCommand($this->sqldata.' where a0.addressaccountid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'addressaccountid'=>$model['addressaccountid'],
          'companyid'=>$model['companyid'],
          'addressbookid'=>$model['addressbookid'],
          'accpiutangid'=>$model['accpiutangid'],
          'acchutangid'=>$model['acchutangid'],
          'recordstatus'=>$model['recordstatus'],
          'companyname'=>$model['companyname'],
          'fullname'=>$model['fullname'],
          'accpiutang'=>$model['accpiutang'],
          'acchutang'=>$model['acchutang'],

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
      array('addressbookid','string','emptyaddressbookid'),
      array('accpiutangid','string','emptyaccpiutangid'),
      array('acchutangid','string','emptyacchutangid'),
      array('recordstatus','string','emptyrecordstatus'),
    ));
		if ($error == false)
		{
			$id = $_POST['addressaccountid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update addressaccount 
			      set companyid = :companyid,addressbookid = :addressbookid,accpiutangid = :accpiutangid,acchutangid = :acchutangid,recordstatus = :recordstatus 
			      where addressaccountid = :addressaccountid';
				}
				else
				{
					$sql = 'insert into addressaccount (companyid,addressbookid,accpiutangid,acchutangid,recordstatus) 
			      values (:companyid,:addressbookid,:accpiutangid,:acchutangid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':addressaccountid',$_POST['addressaccountid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':companyid',(($_POST['companyid']!=='')?$_POST['companyid']:null),PDO::PARAM_STR);
        $command->bindvalue(':addressbookid',(($_POST['addressbookid']!=='')?$_POST['addressbookid']:null),PDO::PARAM_STR);
        $command->bindvalue(':accpiutangid',(($_POST['accpiutangid']!=='')?$_POST['accpiutangid']:null),PDO::PARAM_STR);
        $command->bindvalue(':acchutangid',(($_POST['acchutangid']!=='')?$_POST['acchutangid']:null),PDO::PARAM_STR);
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
					$sql = "select recordstatus from addressaccount where addressaccountid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update addressaccount set recordstatus = 0 where addressaccountid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update addressaccount set recordstatus = 1 where addressaccountid = ".$id[$i];
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
				$sql = "delete from addressaccount where addressaccountid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('addressaccount');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('addressaccountid'),$this->getCatalog('company'),$this->getCatalog('addressbook'),$this->getCatalog('accpiutang'),$this->getCatalog('acchutang'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['addressaccountid'],$row1['companyname'],$row1['fullname'],$row1['accpiutang'],$row1['acchutang'],$row1['recordstatus']='1'?'Aktif':'Tidak Aktif'));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('addressaccountid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('companyname'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('fullname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('accpiutang'))
->setCellValueByColumnAndRow(4,4,$this->getCatalog('acchutang'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['addressaccountid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['companyname'])
->setCellValueByColumnAndRow(2, $i+1, $row1['fullname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['accpiutang'])
->setCellValueByColumnAndRow(4, $i+1, $row1['acchutang'])
->setCellValueByColumnAndRow(5, $i+1, $row1['recordstatus']='1'?'Aktif':'Tidak Aktif');
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}
