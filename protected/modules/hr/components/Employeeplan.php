<?php 
class Employeeplan extends Portlet
{ 
    /*
	protected $sqldata = 'select a.usertodoid,a.username,a.tododate,a.menuname,a.docno,a.description 
					from usertodo a ';
	protected $sqlcount = 'select count(1) 
		from usertodo a ';
	*/
    
    protected $sqldata = "select distinct a0.empplanid, a1.startdate, a1.enddate, a0.useraccess, a1.description, a1.objvalue, if(a1.enddate<CURDATE(),'merah','normal') as warna
    from empplan a0
    join empplandetail a1 on a0.empplanid = a1.empplanid
  ";
    
    protected $sqlcount = "select count(1) 
    from empplan a0 
    join empplandetail a1 on a0.empplanid = a1.empplanid
  ";
	/* AND a1.employeeid IN (
                SELECT e.employeeid FROM groupmenuauth gm
                LEFT JOIN menuauth m ON m.menuauthid = gm.menuauthid
                LEFT JOIN groupaccess g ON g.groupaccessid = gm.groupaccessid
                LEFT JOIN usergroup u ON u.groupaccessid = g.groupaccessid
                LEFT JOIN useraccess us ON us.useraccessid = u.useraccessid 
                LEFT JOIN employee e ON e.employeeid = gm.menuvalueid
                WHERE us.username='".Yii::app()->user->name."' AND m.menuobject='employee')
	*/
	protected function renderContent()
	{
		$where = "WHERE a0.recordstatus <> 0";
		$this->sqldata = $this->sqldata.$where;
		//$count = Yii::app()->db->createCommand($this->sqlcount." where a0.useraccess = '".Yii::app()->user->id."'")->queryScalar();
		$count = Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'empplanid',
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'description','objvalue','startdate','enddate'
        ),
				'defaultOrder'=>'empplanid',
			),
		));
		$this->render('employeeplan',array('dataProvider'=>$dataProvider));
	}
}