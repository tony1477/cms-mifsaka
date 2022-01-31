<?php

class PurgescanController extends AdminController
{
	protected $menuname = 'purgescan';
	public $module = 'Inventory';
	protected $pageTitle = 'Purge Scan Barcode';
	public $wfname = 'appgi';
    // $soheaderid = '';
    
	public function actionIndex()
	{
		parent::actionIndex();
        
		$this->render('index');
	}
    
    public function actionPurgescanbarcode(){
    
        $nobarcode = $_POST['nobarcode'];

        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
            $sql = 'call purgescanbarcode(:barcode,:vcreatedby)';
            $command = $connection->createCommand($sql);
            $command->bindvalue(':barcode',$nobarcode,PDO::PARAM_STR);
            $command->bindvalue(':vcreatedby',Yii::app()->user->name,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->getMessage('success','alreadysaved');
        }
        catch (CDbException $e)
        {
            $transaction->rollBack();
            $this->getMessage('error',$e->getMessage());
        }
    }

}