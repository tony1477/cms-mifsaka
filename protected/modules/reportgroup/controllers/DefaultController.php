<?php

class DefaultController extends AdminController
{
	protected $menuname = 'reportorder';
	public $module = 'reportgroup';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->redirect(Yii::app()->createUrl('admin'));
	}
}