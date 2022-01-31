<?php

//namespace Accounting;

class AttbmController extends AdminController
{
	 
    protected $menuname = 'attbm';		
	public $module = 'reportbm';
	protected $pageTitle = 'Lampiran Neraca & Laba (Rugi)';
	        
	public function actionIndex()
	{
		parent::actionIndex();
        
        $id='balancesheet';
        $att = new AttController($id,$this->module);
        
        $dataProvider = $att->getIndex();
        
        $dataProviderattdetail = $att->getIndexDetail();
                 
        $this->render('application.modules.accounting.views.att.index',array('dataProvider'=>$dataProvider,'dataProviderattdetail'=>$dataProviderattdetail));
        
        
    }
	
}