<?php

class TController extends AdminController
{
	protected $menuname = TMenuName;
	public $module = TModule;
	protected $pageTitle = TPageTitle;
	TApproveWorkflow
	TSqlData  TSqlCount
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		TAddOnWhere
		if (TRequest)
		{				
			$where .= TWhere; 
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	TActionIndex
	TActionDownPDF
	TActionDownXLS
}