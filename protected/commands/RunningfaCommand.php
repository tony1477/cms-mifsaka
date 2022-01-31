<?php
class RunningfaCommand extends CConsoleCommand
{
	public function run($args)
	{
		$connection=Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try
		{
			$sql = 'select companyid from company';
			$dataReader=$connection->createCommand($sql)->queryAll();
			foreach ($dataReader as $data)
			{
				$sql = 'call RunningFA('.$data['companyid'].')';
				$command=$connection->createCommand($sql);
				$command->execute();
			}			
			$transaction->commit();
		}
		catch(Exception $e) // an exception is raised if a query fails
		{
			 $transaction->rollBack();
		}
	}
}
