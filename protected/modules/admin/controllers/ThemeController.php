<?php

class ThemeController extends AdminController
{
	protected $menuname = 'theme';	
	public $module = 'admin';
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->pageTitle="Theme";
		$sql = "select a.themeid,a.themename,a.description,a.recordstatus
			from theme a ";
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM theme')->queryScalar();
		$dataProvider=new CSqlDataProvider($sql,array(
			'totalItemCount'=>$count,
			'keyField'=>'themeid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'moduleid', 'themename', 'description',
        ),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	
	public function actionUninstall()
	{
		$sql = "select themename 
			from theme a 
			where a.themeid = ".$_POST['theme'];
		$dependency = new CDbCacheDependency('SELECT MAX(themeid) FROM theme');
		$datas = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryRow();
		$a = $datas['themename'];
		$sql = file_get_contents(dirname('__FILES__').'/themes/'.$a.'/uninstall.sql');
		try
		{
			Yii::app()->db->createCommand($sql)->execute();
			$this->rrmdir(dirname('__FILES__').'/themes/'.$a);
			Yii::app()->user->setFlash('info', "Your theme already uninstalled");
		}
		catch (CException $e)
		{
			Yii::app()->user->setFlash('error', $e->getMessage());
		}
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	public function actionInstall()
	{		
		if (!empty($_FILES)) {
			$storeFolder = dirname('__FILES__').'/uploads/';
			$tempFile = $_FILES['upload']['tmp_name'];                     									 
			$targetFile =  $storeFolder. $_FILES['upload']['name']; 		 
			move_uploaded_file($tempFile,$targetFile);
			$zip = new ZipArchive;
			if ($zip->open($storeFolder.$_FILES['upload']['name']) === TRUE) {
				$zip->extractTo(dirname('__FILES__').'/themes/');
				$zip->close();
				unlink($storeFolder.$_FILES['upload']['name']);
				$s = basename($_FILES['upload']['name'], ".zip");
				$sql = file_get_contents(dirname('__FILES__').'/themes/'.$s.'/install.sql');
				Yii::app()->db->createCommand($sql)->execute();
				Yii::app()->user->setFlash('info', "Your theme already installed");
			} else {
				Yii::app()->user->setFlash('error', "Your theme has an error, please try or consult to Prisma Data Abadi");
			}
		}
	}
/**	
	public function actionActivate()
	{
		try
		{
			if (strtolower($_POST['status']) == 'active')
			{			
				$sql = "update theme set recordstatus = 0 where themeid = ".$_POST['themeid'];
				Yii::app()->db->createCommand($sql)->execute();
			}
			else
			{
				$sql = "select isadmin 
					from theme a 
					where a.themeid = ".$_POST['themeid'];
				$dependency = new CDbCacheDependency('SELECT MAX(themeid) FROM theme');
				$s = Yii::app()->db->createCommand($sql)->queryRow();
				$sql = "update theme set recordstatus = 0 where isadmin = ".$s['isadmin'];
				Yii::app()->db->createCommand($sql)->execute();
				$sql = "update theme set recordstatus = 1 where isadmin = ".$s['isadmin']." and themeid = ".$_POST['themeid'];
				Yii::app()->db->createCommand($sql)->execute();
			}
			Yii::app()->user->setFlash('info','Your data already saved');
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		catch (CExcpetion $e)
		{
			Yii::app()->user->setFlash('error', $e->getMessage());
		}
	} */
}