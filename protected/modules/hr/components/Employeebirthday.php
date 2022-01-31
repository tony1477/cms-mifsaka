<?php 
class Employeebirthday extends Portlet
{ 
    /*
	protected $sqldata = 'select a.usertodoid,a.username,a.tododate,a.menuname,a.docno,a.description 
					from usertodo a ';
	protected $sqlcount = 'select count(1) 
		from usertodo a ';
	*/
    
    protected $sqldata = "SELECT a0.employeeid, a0.birthdate, a0.fullname, a1.companycode, substring_index(substring_index(a2.structurename, ',', 1), ',', - 1) as structurename
                        FROM employee a0
                        LEFT JOIN employeeorgstruc b ON b.employeeid = a0.employeeid
                        LEFT JOIN orgstructure a2 ON a2.orgstructureid = b.orgstructureid
                        LEFT JOIN company a1 ON a1.companyid = a2.companyid ";
    
    protected $sqlcount = "select ifnull(count(distinct 1),0) 
                        FROM employee a0
                        LEFT JOIN employeeorgstruc b ON b.employeeid = a0.employeeid
                        LEFT JOIN orgstructure a2 ON a2.orgstructureid = b.orgstructureid
                        LEFT JOIN company a1 ON a1.companyid = a2.companyid ";
  
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
        $where = "WHERE MONTH(a0.birthdate) = MONTH(CURDATE()) GROUP BY a0.employeeid ";
		$this->sqldata = $this->sqldata.$where;
		//$count = Yii::app()->db->createCommand($this->sqlcount." where a0.useraccess = '".Yii::app()->user->id."'")->queryScalar();
		$count = Yii::app()->db->createCommand($this->sqlcount.$where)->query();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$count->rowCount,
			'keyField'=>'employeeid',
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'fullname','birthdate','structurename','companycode'
        ),
				'defaultOrder'=>'day(birthdate) asc',
			),
		));
		$this->render('birthday',array('dataProvider'=>$dataProvider));
	}
}
