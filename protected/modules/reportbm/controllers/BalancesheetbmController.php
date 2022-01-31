<?php

//namespace Accounting;

class BalancesheetbmController extends AdminController
{
	 
    protected $menuname = 'balancesheetbm';		
	public $module = 'reportbm';
	protected $pageTitle = 'Laporan Neraca';
	        
	public function actionIndex()
	{
		parent::actionIndex();
        //parent::__construct($id=,$module='accounting');
		 //$this->redirect(array('//accounting/balancesheet/index'));
        //$acc = new \Balanceseet\Index();
        //$dataProvider=1;
        //Balancesheet::getIndex();
        //$module='accounting';
        $id='balancesheet';
        $balance = new BalancesheetController($id,$this->module);
        //$b = $n->actionIndex();
        $dataProvider = $balance->getIndex();
        //$ne->index();
        //print_r($dataProvider);
         
        $this->render('application.modules.accounting.views.balancesheet.index',array('dataProvider'=>$dataProvider));
        
        
    }
	
}