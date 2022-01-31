<?php 
class EndofContract extends Portlet
{ 
    /*
	protected $sqldata = 'select a.usertodoid,a.username,a.tododate,a.menuname,a.docno,a.description 
					from usertodo a ';
	protected $sqlcount = 'select count(1) 
		from usertodo a ';
	*/
    
    protected $sqldata = "SELECT distinct a.*, b.fullname, b.joindate 
                        FROM employeecontract a JOIN employee b on a.employeeid = b.employeeid ";
    
    protected $sqlcount = "select count(1) 
    FROM employeecontract a JOIN employee b on a.employeeid = b.employeeid ";
  
	protected function renderContent()
	{
        /*
		$where = "WHERE a0.recordstatus <> 0 AND a1.employeeid IN (
                SELECT e.employeeid FROM groupmenuauth gm
                LEFT JOIN menuauth m ON m.menuauthid = gm.menuauthid
                LEFT JOIN groupaccess g ON g.groupaccessid = gm.groupaccessid
                LEFT JOIN usergroup u ON u.groupaccessid = g.groupaccessid
                LEFT JOIN useraccess us ON us.useraccessid = u.useraccessid 
                LEFT JOIN employee e ON e.employeeid = gm.menuvalueid
                WHERE us.username='".Yii::app()->user->name."' AND m.menuobject='employee')";
        */
        $where = "WHERE MONTH(a.enddate) = MONTH(CURDATE())";
		$this->sqldata = $this->sqldata.$where;
		//$count = Yii::app()->db->createCommand($this->sqlcount." where a0.useraccess = '".Yii::app()->user->id."'")->queryScalar();
		$count = Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'contractid',
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'fullname','joindate','startdate','enddate','description'
        ),
				'defaultOrder'=>'enddate asc',
			),
		));
		$this->render('contract',array('dataProvider'=>$dataProvider));
	}
}