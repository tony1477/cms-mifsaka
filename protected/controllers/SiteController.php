<?php
class SiteController extends Controller
{
	private $_identity;
	public $module = '';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->pageTitle = $this->getParameter('tagline');
		$this->render('index');
	}
	
	public function actionAbout()
	{
		parent::actionIndex();
		$this->pageTitle = $this->getParameter('tagline');
		$this->render('about');
	}

	public function actionError()
	{
		$error = Yii::app()->errorHandler->error;
		if( $error )
		{
			$this -> render('error', array( 'error' => $error ) );
		}
	}
	
	public function actionLogin()
	{
		if (isset($_POST['pptt']) && (isset($_POST['sstt'])))
		{
			$this->_identity = new UserIdentity($_POST['pptt'], $_POST['sstt']);
			$this->_identity->authenticate();
			if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
			{
				$rememberMe = isset($_POST['rrmm'])?$_POST['rrmm']:false;
				$duration=$rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				$this->getMessage('success','welcome');
			}
			else
			{
				$this->getMessage('error','tryagain');
			}
		}
		else
		{
			$this->getMessage('error','invalidmethod');
		}
	}
	
	public function actionLogout()
	{
		Yii::app()->db->createCommand("update useraccess set isonline = 0 where lower(username) = lower('".Yii::app()->user->id."')")->execute();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionSaveuser()
	{
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			if ($_POST['useraccessid'] > 0)
			{
				$sql = "update useraccess 
					set realname = '".$_POST['realname']."', 
					email = '".$_POST['email']."',
					phoneno = '".$_POST['phoneno']."',
					birthdate = '".$_POST['birthdate']."',
					useraddress = '".$_POST['useraddress']."' 
					where useraccessid = ".$_POST['useraccessid'];
				$connection->createCommand($sql)->execute();
				if ($_POST['password'] !== '')
				{
					$sql = "update useraccess 
						set password = md5('".$_POST['realname']."') 
						where useraccessid = ".$_POST['useraccessid'];
					$connection->createCommand($sql)->execute();
				}
			}
			else 
			{
				$sql = "insert into useraccess (username,password,realname,email,phoneno,languageid,recordstatus,joindate,birthdate,useraddress) 
					values ('".$_POST['username']."',md5('".$_POST['password']."'),'".$_POST['realname']."','".$_POST['email']."',
					'".$_POST['phoneno']."',1,0,now(),'".$_POST['birthdate']."','".$_POST['useraddress']."')";
				$connection->createCommand($sql)->execute();
			}
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (CdbException $e)
		{
			$transaction->rollBack();
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionGetProfile()
	{
		$username = filter_input(INPUT_POST,'pptt');
		$password = filter_input(INPUT_POST,'sstt');
		$user = null;
		//var_dump($_POST);
		if (Yii::app()->user->id == null) {
			if (($username == null) || ($username == '')) {
				$this->getMessage('error','invaliduser');
			} else 
				if (($password == null) || ($password == '')) {
					$this->getMessage('error','invalidpassword');
			} else {
				$user = Yii::app()->db->createCommand("select useraccessid,username,realname,email,phoneno 
					from useraccess 
					where lower(username) = '".$username."' 
					and `password` = md5('".$password."')")->queryRow();
			}
		} else {
			$user = Yii::app()->db->createCommand("select useraccessid,username,realname,email,phoneno 
				from useraccess 
				where lower(username) = '".Yii::app()->user->id."'")->queryRow();
		}
		if ($user !== null) {
			if ($user['useraccessid'] == null) {
				$this->getMessage('error','invaliduserpassword');
			} else {
				Yii::app()->db->createCommand("update useraccess set isonline = 1 where lower(username) = lower('".$user['useraccessid']."')")->execute();
				echo CJSON::encode(array(
					'status'=>'success',
					'useraccessid'=>$user['useraccessid'],
					'username'=>$user['username'],
					'realname'=>$user['realname'],
					'email'=>$user['email'],
					'phoneno'=>$user['phoneno']
				));
				Yii::app()->end();
			}
		}
	}
	
	public function actionGetUserSuperMenu() {
		$username = filter_input(INPUT_POST,'pptt');
		$password = filter_input(INPUT_POST,'sstt');
		if (($username == null) || ($username == '')) {
				$this->getMessage('error','invaliduser');
			} else 
				if (($password == null) || ($password == '')) {
					$this->getMessage('error','invalidpassword');
			} else {
			$sql = "select count(1)
				from useraccess a
				inner join usergroup b on b.useraccessid = a.useraccessid
				inner join groupmenu c on c.groupaccessid = b.groupaccessid
				inner join menuaccess d on d.menuaccessid = c.menuaccessid
				inner join modules e on e.moduleid = d.moduleid
				where d.recordstatus = 1 and c.isread = 1 
				and d.parentid is null 
				and lower(username) = lower('".$username."') 
				order by d.sortorder asc";
			$row = Yii::app()->db->createCommand($sql)->queryAll();
			if ($row > 0) {
				foreach($cmd as $data)
				{	
					$row[] = array(
						'catalogsysid'=>$data['catalogsysid'],
						'languageid'=>$data['languageid'],
						'languagename'=>$data['languagename'],
						'catalogname'=>$data['catalogname'],
						'catalogval'=>$data['catalogval'],
					);
				}
				$result=array_merge($result,array('rows'=>$row));
				return CJSON::encode($result);
			} else {
				$this->getMessage('error','false');
			}
		}
	}
}
