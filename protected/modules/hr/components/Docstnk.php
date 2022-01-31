<?php 
class Docstnk extends Portlet
{ 
    /*
	protected $sqldata = 'select a.usertodoid,a.username,a.tododate,a.menuname,a.docno,a.description 
					from usertodo a ';
	protected $sqlcount = 'select count(1) 
		from usertodo a ';
	*/
    
    protected $sqldata = "select a0.docid,a0.namedoc,a0.nodoc,a0.exdate,a0.cost,a0.docupload,a0.companyid,a1.companyname
    from docstnk a0
    left join company a1 on a1.companyid=a0.companyid
  ";
  protected $sqlcount = "select count(1) 
    from docstnk a0 
  ";
  
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
        $where = "WHERE MONTH(a0.exdate) = MONTH(CURDATE()) GROUP BY a0.companyid ";
		$this->sqldata = $this->sqldata.$where;
		//$count = Yii::app()->db->createCommand($this->sqlcount." where a0.useraccess = '".Yii::app()->user->id."'")->queryScalar();
		$count = Yii::app()->db->createCommand($this->sqlcount.$where)->query();
		$dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$count->rowCount,
			'keyField'=>'companyid',
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'companyname','nodoc','namedoc','exdate'
        ),
				'defaultOrder'=>'exdate asc',
			),
		));
		$this->render('docstnk',array('dataProvider'=>$dataProvider));
	}
}
