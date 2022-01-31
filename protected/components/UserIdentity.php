<?php
class UserIdentity extends CUserIdentity
{
	const ERROR_USER_PASSWORD_INVALID=3;
	public function authenticate()
	{
		$connection=Yii::app()->db;
		$sql = 'select username,ifnull(count(1),0) as jumlah from useraccess 
			where lower(username) = :username and password = md5(:password) and recordstatus = 1';
		$command=$connection->createCommand($sql);
		$command->bindvalue(':username',$this->username,PDO::PARAM_STR);
		$command->bindvalue(':password',$this->password,PDO::PARAM_STR);
		$user = $command->queryRow();
		if ($user['jumlah'] > 0)
		{
			$this->username = $user['username'];
			$this->errorCode= self::ERROR_NONE;
		}
		else 
		{
			$this->errorCode = self::ERROR_USER_PASSWORD_INVALID;
		}
		return $this->errorCode==self::ERROR_NONE;
	}
}