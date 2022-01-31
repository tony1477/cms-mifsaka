<?php 
class Userprofile extends Portlet
{ 
	protected $sqldata = 'select a.useraccessid,a.username, a.password, a.realname, a.email, a.phoneno
					from useraccess a ';
	
	protected function renderContent()
	{
		$this->sqldata = $this->sqldata." where username = '".Yii::app()->user->id."'";
		$db = Yii::app()->db->createCommand($this->sqldata)->queryRow();
		$this->render('userprofile',array('useraccessid'=>$db['useraccessid'],'username'=>$db['username'],
			'password'=>$db['password'],'realname'=>$db['realname'],'email'=>$db['email'],
			'phoneno'=>$db['phoneno']));
	}
}