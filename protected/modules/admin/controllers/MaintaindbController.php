<?php

class MaintaindbController extends AdminController
{
	protected $menuname = 'maintaindb';
	public $module = 'admin';
	protected $pageTitle = 'Maintain DB';
		
	public function actionIndex()
	{
		parent::actionIndex();
		$this->render('index');
	}
	
	public function actionRestore()
	{
		
	}
	
	public function actionBackup()
	{
		$file = "backupdb-".date('Ymd').".sql";
		$db = Yii::app()->db->createCommand("SELECT DATABASE()")->queryScalar();
		if ($db !== '')
		{
			file_put_contents($file, 'CREATE DATABASE '.$db. ";\n", FILE_APPEND | LOCK_EX);
			$tables = Yii::app()->db->createCommand("SELECT TABLE_NAME
				FROM information_schema.TABLES 
				WHERE TABLE_SCHEMA = '".$db."'")->queryAll();	
			foreach ($tables as $table)
			{
				$createtable = Yii::app()->db->createCommand("SHOW CREATE TABLE ".$db.".".$table['TABLE_NAME']."")->queryRow();
				file_put_contents($file, $createtable['Create Table'].";\n", FILE_APPEND | LOCK_EX);
				
				$datas = Yii::app()->db->createCommand("select * from ".$table['TABLE_NAME'])->queryAll();
				foreach ($datas as $data)
				{
					$sql = "INSERT INTO ".$table['TABLE_NAME']." VALUES ";
					
				}
			}
		}
	}
}