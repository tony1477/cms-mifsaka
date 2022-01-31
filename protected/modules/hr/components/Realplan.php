<?php 
class Realplan extends Portlet
{ 
    /*
	protected $sqldata = 'select a.usertodoid,a.username,a.tododate,a.menuname,a.docno,a.description 
					from usertodo a ';
	protected $sqlcount = 'select count(1) 
		from usertodo a ';
	*/
    
    protected $sqldata = "select distinct a.description, a.objvalue, b.empplanname, a.empplanid
    from realplan a 
    join empplan b on a.empplanid = b.empplanid
  ";
    
    protected $sqlcount = "select count(1) 
    from realplan a 
    join empplan b on a.empplanid = b.empplanid
  ";
	protected function renderContent()
	{
		//$this->sqldata = $this->sqldata." where b.useraccess = '".Yii::app()->user->id."'";
        $where = "WHERE a.recordstatus <> 0 AND a.employeeid IN (
                SELECT e.employeeid FROM groupmenuauth gm
                LEFT JOIN menuauth m ON m.menuauthid = gm.menuauthid
                LEFT JOIN groupaccess g ON g.groupaccessid = gm.groupaccessid
                LEFT JOIN usergroup u ON u.groupaccessid = g.groupaccessid
                LEFT JOIN useraccess us ON us.useraccessid = u.useraccessid 
                LEFT JOIN employee e ON e.employeeid = gm.menuvalueid
                WHERE us.username='".Yii::app()->user->name."' AND m.menuobject='employee')";
        $this->sqldata = $this->sqldata.$where;
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
             'empplanname','objvalue','description'
        ),
				'defaultOrder'=>'a.empplanid desc',
			),
		));
		$this->render('realplan',array('dataProvider'=>$dataProvider));
	}
}