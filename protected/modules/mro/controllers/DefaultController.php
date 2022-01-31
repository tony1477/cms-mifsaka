<?php

class DefaultController extends AdminController
{
	protected $menuname = 'mrogi';
	public $module = 'mro';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->redirect(Yii::app()->createUrl('admin'));
	}
}