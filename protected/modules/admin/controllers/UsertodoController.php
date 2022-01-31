<?php

class UsertodoController extends AdminController
{
	public function actionPurge()
	{
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$sql = "delete from usertodo where usertodoid = ".$_POST['id'];
			Yii::app()->db->createCommand($sql)->execute();
			$transaction->commit();
			$this->getMessage('success','alreadysaved');
		}
		catch (Exception $e)
		{
			$transaction->rollback();
			$this->getMessage('error',$e->getMessage());
		}
	}
}