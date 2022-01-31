<?php
class AdminController extends Controller
{
	public function actionIndex()
	{
		//parent::actionIndex();
		if ($this->checkAccess($this->menuname,'isread') == false)
		{
			$this->redirect(Yii::app()->createUrl('site/index'));
		}
		else
		{
			$this->getTheme(true);
		}
	}
	
	public function findstatusbyuser($workflow)
  {
		$status = Yii::app()->db->createCommand("select wfbefstat
			from workflow a
			inner join wfgroup b on b.workflowid = a.workflowid
			inner join groupaccess c on c.groupaccessid = b.groupaccessid
			inner join usergroup d on d.groupaccessid = c.groupaccessid
			inner join useraccess e on e.useraccessid = d.useraccessid
			where upper(a.wfname) = upper('". $workflow ."') and upper(e.username)=upper('".Yii::app()->user->name."')")->queryScalar();
		if ($status !== null)
		{
			 return $status;
		}
		else
		{
			return 0;
		}
  }
	
	public function CheckDoc($datastatus)
	{
		$stat = $this->findstatusbyuser($this->wfname);
		Yii::app()->user->setFlash('error', $stat);
		$s = '';
		if ($stat !== $datastatus)
		{
			return 'docreachmaxstatus';
		}
		else
		{
			$sql = "select getwfmaxstatbywfname('".$this->wfname."')";
			$isallow = Yii::app()->db->createCommand($sql)->queryScalar();
			if ($isallow !== $datastatus)
			{
				return '';
			}
			else
			{
				return 'docreachmaxstatus';
			}
		}
	}
	
	public function actionCreate()
	{
		parent::actionCreate();
		if (!$this->checkAccess($this->menuname,'iswrite'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionUpdate()
	{
		parent::actionUpdate();
		if (!$this->checkAccess($this->menuname,'iswrite'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionSave()
	{
		parent::actionSave();
		if (!$this->checkAccess($this->menuname,'iswrite'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionDelete()
	{
		parent::actionDelete();
		if (!$this->checkAccess($this->menuname,'isreject'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionReject()
	{
		parent::actionDelete();
		if (!$this->checkAccess($this->menuname,'isreject'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionPurge()
	{
		parent::actionPurge();
		if (!$this->checkAccess($this->menuname,'ispurge'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function actionPost()
	{
		if (!$this->checkAccess($this->menuname,'ispost'))
		{
			Yii::app()->user->setFlash('error', "You are not authorized");
		}
	}
	
	public function getCompanyCode($companyid){
        $company = Yii::app()->db->createCommand(
			"select companycode
			from company a  
			where companyid = ".$companyid)->queryScalar();
		return $company;
    }
}