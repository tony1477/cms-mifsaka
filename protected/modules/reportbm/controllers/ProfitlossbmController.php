<?php

//namespace Accounting;

class ProfitlossbmController extends AdminController
{
	 
    protected $menuname = 'profitloss';		
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
        $id='profitloss';
        $profitloss = new ProfitlossController($id,$this->module);
        //$b = $n->actionIndex();
        $dataProvider = $profitloss->getIndex();
        //$ne->index();
        //print_r($dataProvider);
         
        $this->render('application.modules.accounting.views.profitloss.index',array('dataProvider'=>$dataProvider));
        
        
    }
	
}