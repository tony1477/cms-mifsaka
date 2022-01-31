<?php

class UseraccessController extends AdminController
{
	protected $menuname = 'useraccess';
	public $module = 'Admin';
	protected $pageTitle = 'Akses User';
	public $wfname = '';
	protected $sqldata = "select a0.useraccessid,a0.username,a0.realname,a0.password,a0.authkey,a0.email,a0.phoneno,a0.languageid,a0.isonline,a0.recordstatus,a1.languagename as languagename 
    from useraccess a0 
    left join language a1 on a1.languageid = a0.languageid
  ";
  protected $sqlcount = "select count(1) 
    from useraccess a0 
    left join language a1 on a1.languageid = a0.languageid
  ";

	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['username'])) && (isset($_REQUEST['realname'])) && (isset($_REQUEST['email'])) && (isset($_REQUEST['phoneno'])) && (isset($_REQUEST['languagename'])))
		{				
			$where .= " where a0.username like '%". $_REQUEST['username']."%' 
and a0.realname like '%". $_REQUEST['realname']."%' 
and a0.email like '%". $_REQUEST['email']."%' 
and a0.phoneno like '%". $_REQUEST['phoneno']."%' 
and a1.languagename like '%". $_REQUEST['languagename']."%'"; 
		}
		if (isset($_REQUEST['useraccessid']))
			{
				if (($_REQUEST['useraccessid'] !== '0') && ($_REQUEST['useraccessid'] !== ''))
				{
					$where .= " and a0.useraccessid in (".$_REQUEST['useraccessid'].")";
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
			'keyField'=>'useraccessid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'useraccessid','username','realname','password','authkey','email','phoneno','languageid','isonline','recordstatus'
				),
				'defaultOrder' => array( 
					'useraccessid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	public function actionCreate()
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
			$id = $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where useraccessid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'useraccessid'=>$model['useraccessid'],
          'username'=>$model['username'],
          'realname'=>$model['realname'],
          'password'=>$model['password'],
          'email'=>$model['email'],
          'phoneno'=>$model['phoneno'],
          'languageid'=>$model['languageid'],
          'recordstatus'=>$model['recordstatus'],
          'languagename'=>$model['languagename'],

				));
				Yii::app()->end();
			}
		}
	}

	public function actionSave()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('username','string','emptyusername'),
      array('realname','string','emptyrealname'),
      array('password','string','emptypassword'),
      array('email','string','emptyemail'),
      array('phoneno','string','emptyphoneno'),
      array('languageid','string','emptylanguageid'),
    ));
		if ($error == false)
		{
			$id = $_POST['useraccessid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
				if ($id !== '')
				{
					$sql = 'update useraccess 
			      set username = :username,realname = :realname,password = :password,email = :email,phoneno = :phoneno,languageid = :languageid,recordstatus = :recordstatus 
			      where useraccessid = :useraccessid';
				}
				else
				{
					$sql = 'insert into useraccess (username,realname,password,email,phoneno,languageid,recordstatus) 
			      values (:username,:realname,:password,:email,:phoneno,:languageid,:recordstatus)';
				}
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':useraccessid',$_POST['useraccessid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':username',(($_POST['username']!=='')?$_POST['username']:null),PDO::PARAM_STR);
        $command->bindvalue(':realname',(($_POST['realname']!=='')?$_POST['realname']:null),PDO::PARAM_STR);
				$sql = "select `password` from useraccess where username = '".$_POST['username']."'";
				$password = Yii::app()->db->createCommand($sql)->queryScalar();
				if ($password != $_POST['password'])
				{
					$command->bindvalue(':password',(($_POST['password']!=='')?md5($_POST['password']):null),PDO::PARAM_STR);
				}
				else
				{
					$command->bindvalue(':password',$password,PDO::PARAM_STR);
				}
        $command->bindvalue(':email',(($_POST['email']!=='')?$_POST['email']:null),PDO::PARAM_STR);
        $command->bindvalue(':phoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
        $command->bindvalue(':languageid',(($_POST['languageid']!=='')?$_POST['languageid']:null),PDO::PARAM_STR);
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
	
	public function actionSaveProfile()
	{
		parent::actionSave();
		$error = $this->ValidateData(array(
			array('username','string','emptyusername'),
      array('realname','string','emptyrealname'),
      array('password','string','emptypassword'),
      array('email','string','emptyemail'),
      array('phoneno','string','emptyphoneno'),
    ));
		if ($error == false)
		{
			$id = $_POST['useraccessid'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
					$sql = 'update useraccess 
			      set username = :username,realname = :realname,password = :password,email = :email,phoneno = :phoneno
			      where useraccessid = :useraccessid';
				$command = $connection->createCommand($sql);
				if ($id !== '')
				{
					$command->bindvalue(':useraccessid',$_POST['useraccessid'],PDO::PARAM_STR);
				}
				$command->bindvalue(':username',(($_POST['username']!=='')?$_POST['username']:null),PDO::PARAM_STR);
        $command->bindvalue(':realname',(($_POST['realname']!=='')?$_POST['realname']:null),PDO::PARAM_STR);
				$sql = "select `password` from useraccess where useraccessid = ".$_POST['useraccessid'];
				$password = Yii::app()->db->createCommand($sql)->queryScalar();
				if ($password != $_POST['password'])
				{
					$command->bindvalue(':password',(($_POST['password']!=='')?md5($_POST['password']):null),PDO::PARAM_STR);
				}
        $command->bindvalue(':email',(($_POST['email']!=='')?$_POST['email']:null),PDO::PARAM_STR);
        $command->bindvalue(':phoneno',(($_POST['phoneno']!=='')?$_POST['phoneno']:null),PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				//$this->InsertTranslog($command,$id);
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
					$sql = "select recordstatus from useraccess where useraccessid = ".$id[$i];
					$status = Yii::app()->db->createCommand($sql)->queryRow();
					if ($status['recordstatus'] == 1)
					{			
						$sql = "update useraccess set recordstatus = 0 where useraccessid = ".$id[$i];
					}
					else
					if ($status['recordstatus'] == 0)
					{
						$sql = "update useraccess set recordstatus = 1 where useraccessid = ".$id[$i];
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
				$id = $_POST['id'];if (!is_array($id)) { $ids[] = $id; $id = $ids; }
				for ($i = 0; $i < count($id);$i++)
				{
				$sql = "delete from useraccess where useraccessid = ".$id[$i];
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
		$this->pdf->title=$this->getCatalog('useraccess');
		$this->pdf->AddPage('P');
		$this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
		$this->pdf->colheader = array($this->getCatalog('useraccessid'),$this->getCatalog('username'),$this->getCatalog('realname'),$this->getCatalog('password'),$this->getCatalog('authkey'),$this->getCatalog('email'),$this->getCatalog('phoneno'),$this->getCatalog('language'),$this->getCatalog('isonline'),$this->getCatalog('recordstatus'));
		$this->pdf->setwidths(array(10,40,40,40,40,40,40,40,15,40,15));
		$this->pdf->Rowheader();
		$this->pdf->coldetailalign = array('L','L','L','L','L','L','L','L','L','L','L');
		
		foreach($dataReader as $row1)
		{
			//masukkan baris untuk cetak
		  $this->pdf->row(array($row1['useraccessid'],$row1['username'],$row1['realname'],$row1['password'],$row1['authkey'],$row1['email'],$row1['phoneno'],$row1['languagename'],$row1['isonline'],$row1['recordstatus']));
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
					->setCellValueByColumnAndRow(0,4,$this->getCatalog('useraccessid'))
->setCellValueByColumnAndRow(1,4,$this->getCatalog('username'))
->setCellValueByColumnAndRow(2,4,$this->getCatalog('realname'))
->setCellValueByColumnAndRow(3,4,$this->getCatalog('password'))
->setCellValueByColumnAndRow(5,4,$this->getCatalog('email'))
->setCellValueByColumnAndRow(6,4,$this->getCatalog('phoneno'))
->setCellValueByColumnAndRow(7,4,$this->getCatalog('languagename'))
->setCellValueByColumnAndRow(8,4,$this->getCatalog('isonline'))
->setCellValueByColumnAndRow(10,4,$this->getCatalog('recordstatus'));
		foreach($dataReader as $row1)
		{
			  $this->phpExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(0, $i+1, $row1['useraccessid'])
->setCellValueByColumnAndRow(1, $i+1, $row1['username'])
->setCellValueByColumnAndRow(2, $i+1, $row1['realname'])
->setCellValueByColumnAndRow(3, $i+1, $row1['password'])
->setCellValueByColumnAndRow(5, $i+1, $row1['email'])
->setCellValueByColumnAndRow(6, $i+1, $row1['phoneno'])
->setCellValueByColumnAndRow(7, $i+1, $row1['languagename'])
->setCellValueByColumnAndRow(8, $i+1, $row1['isonline'])
->setCellValueByColumnAndRow(10, $i+1, $row1['recordstatus']);
		$i+=1;
		}
		$this->getFooterXLS($this->phpExcel);
	}
}