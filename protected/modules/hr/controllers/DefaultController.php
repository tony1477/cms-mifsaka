<?php

class DefaultController extends AdminController
{
	protected $menuname = 'position';
	public $module = 'hr';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->redirect(Yii::app()->createUrl('admin'));
	}
}