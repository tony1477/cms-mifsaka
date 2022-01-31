<?php

class ModulesController extends AdminController
{
	protected $menuname = 'modules';
	public $module = 'admin';
	protected $sqldata = "select a0.moduleid,a0.modulename,a0.moduledesc,a0.recordstatus 
    from modules a0 
  ";
  protected $sqlcount = "select count(1) 
    from modules a0 
  ";
	protected function getSQL()
	{
		$this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = "";
		if ((isset($_REQUEST['modulename'])) && (isset($_REQUEST['moduledesc'])))
		{				
			$where .= " where a0.modulename like '%". $_REQUEST['modulename']."%' 
and a0.moduledesc like '%". $_REQUEST['moduledesc']."%'"; 
		}
		if (isset($_REQUEST['modulesid']))
		{
			if ($_REQUEST['modulesid'] !== '0')
			{
				$where .= " and a0.moduleid = ".$_REQUEST['modulesid'];
			}
		}
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
/**	
*	public function getModuleRelation($moduleid)
*	{
*		$sql = "select a.relationid, b.modulename, b.moduledesc 
*			from modulerelation a 
*			inner join modules b on b.moduleid = a.relationid 
			where a.moduleid = ".$moduleid;
		$dependency = new CDbCacheDependency('SELECT MAX(moduleid) FROM modules');
		$datas = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
		$s = "";
		foreach ($datas as $data)
		{
			if ($s == "")
			{
				$s = $data['modulename'];
			}
			else
			{
				$s = $s.','.$data['modulename'];
			}
		}
		return $s;
	}
*/	
	public function actionUninstall()
	{
		//TODO:
		//cek dependency
		//uninstall module
		$sql = "select ifnull(count(1),0) as jumlah
			from modulerelation a 
			where a.relationid = ".$_POST['module'];
		$dependency = new CDbCacheDependency('SELECT MAX(moduleid) FROM modules');
		$datas = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryRow();
		if ($datas['jumlah'] > 0)
		{
			$this->getMessage('error','Your module has dependency to other');
		}
		else
		{
			$sql = "select modulename 
				from modules a 
				where a.moduleid = ".$_POST['module'];
			$dependency = new CDbCacheDependency('SELECT MAX(moduleid) FROM modules');
			$datas = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryRow();
			$a = $datas['modulename'];
			if (Yii::app()->hasModule($a))
			{
				$s = Yii::app()->getModule($a)->uninstall();
				if ($s == "ok")
				{
					$this->rrmdir(dirname('__FILES__').'/protected/modules/'.$datas['modulename']);
					$this->getMessage('success','alreadysaved');
					$this->redirect(Yii::app()->user->returnUrl);
				}
				else
				{
					$this->getMessage('error',$s);
				}
			}
			else
			{
				$this->getMessage('error','alreadyuninstalled');
			}
		}
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
				$zip->extractTo(dirname('__FILES__').'/protected/modules/');
				$zip->close();
				unlink($storeFolder.$_FILES['upload']['name']);
				$s = basename($_FILES['upload']['name'], ".zip");
				echo $s;
			}
		}
	}
	
	public function actionRunning()
	{
		try
		{
			$s = $_POST['id'];
			$a = Yii::app()->getModule($s)->install();
			if ($a == "ok")
			{
				$this->getMessage('success','alreadysaved');
			}
			else 
			{
				$this->getMessage('error',$a);
			}
		}
		catch (Exception $e)
		{
			$this->getMessage('error',$e->getMessage());
		}
	}
	
	public function actionIndex()
	{
		parent::actionIndex();
		$this->pageTitle="Modules";
		$sql = "select moduleid,modulename,moduledesc,recordstatus 
			from modules a ";
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM modules')->queryScalar();
		$dataProvider=new CSqlDataProvider($sql,array(
			'totalItemCount'=>$count,
			'keyField'=>'moduleid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'moduleid', 'modulename', 'moduledesc',
        ),
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (isset($_POST['id']))
		{
			$id = $_POST['id'];if (is_array($id)) { $id = $id[0]; }
			$model = Yii::app()->db->createCommand($this->sqldata.' where moduleid = '.$id)->queryRow();
			if ($model !== null)
			{
				echo CJSON::encode(array(
					'status'=>'success',
					'moduleid'=>$model['moduleid'],
          'modulename'=>$model['modulename'],
          'moduledesc'=>$model['moduledesc'],
          'recordstatus'=>$model['recordstatus'],

				));
				Yii::app()->end();
			}
		}
	}
}