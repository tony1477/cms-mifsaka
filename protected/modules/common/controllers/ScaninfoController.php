<?php

class scaninfoController extends AdminController
{
	protected $menuname = 'scaninfo';
	public $module = 'Production';
	protected $pageTitle = 'Scan Hasil Produksi';
	public $wfname = '';
	
	/*protected $sqldata = "SELECT a.tempscanid, a.barcode, a.companyid, a.productplanid, a.productplanfgid, b.productid, b.productname, a.isapprovehp 
    FROM tempscan a INNER JOIN product b ON 
                        a.productid=b.productid ";
	protected $sqlcount = "SELECT COUNT(1) FROM tempscan a INNER JOIN product b ON 
                        a.productid=b.productid ";*/
	protected $sqldata = "select a.*,b.productname,c.uomcode,a.qtyori,d.sloccode,e.description,f.productplanno,g.productoutputno,h.dano,i.transstockno,j.sono,k.gino
												FROM tempscan a
												INNER JOIN product b ON a.productid=b.productid
												INNER JOIN unitofmeasure c ON c.unitofmeasureid=a.unitofmeasureid
												LEFT JOIN sloc d ON d.slocid=a.slocid
												LEFT JOIN storagebin e ON e.storagebinid=a.storagebinid
												LEFT JOIN productplan f on f.productplanid=a.productplanid
												LEFT JOIN productoutput g on g.productoutputid=a.productoutputid
												LEFT JOIN deliveryadvice h on h.deliveryadviceid=a.deliveryadviceid
												LEFT JOIN transstock i on i.transstockid=a.transstockid
												LEFT JOIN soheader j on j.soheaderid=a.soheaderid
												LEFT JOIN giheader k on k.giheaderid=a.giheaderid ";
	protected $sqlcount = "SELECT IFNULL(COUNT(1),0)
												FROM tempscan a
												INNER JOIN product b ON a.productid=b.productid
												INNER JOIN unitofmeasure c ON c.unitofmeasureid=a.unitofmeasureid
												LEFT JOIN sloc d ON d.slocid=a.slocid
												LEFT JOIN storagebin e ON e.storagebinid=a.storagebinid
												LEFT JOIN productplan f on f.productplanid=a.productplanid
												LEFT JOIN productoutput g on g.productoutputid=a.productoutputid
												LEFT JOIN deliveryadvice h on h.deliveryadviceid=a.deliveryadviceid
												LEFT JOIN transstock i on i.transstockid=a.transstockid
												LEFT JOIN soheader j on j.soheaderid=a.soheaderid
												LEFT JOIN giheader k on k.giheaderid=a.giheaderid ";
	protected function getSQL()
	{
    $this->count=Yii::app()->db->createCommand($this->sqlcount)->queryScalar();
		$where = " where a.companyid = 999999999";
		if (isset($_REQUEST['nobarcode']))
		{
			if (($_REQUEST['nobarcode'] !== '0') && ($_REQUEST['nobarcode'] !== ''))
			{
					$where = " where a.barcode like upper('%". $_REQUEST['nobarcode']."%') ";
			}
		}
		//barcode like '%". $_REQUEST['nobarcode']."%'
		$this->sqldata = $this->sqldata.$where;
		$this->count=Yii::app()->db->createCommand($this->sqlcount.$where)->queryScalar();
	}
	public function actionIndex()
	{
		parent::actionIndex();
		$this->getSQL();
    $dataProvider=new CSqlDataProvider($this->sqldata,array(
			'totalItemCount'=>$this->count,
                'keyField'=>'tempscanid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'tempscanid','barcode','productname','uomcode','qtyori','sloccode','description','productplanno','productoutputno','dano','transstockno','sono','gino','isscanhp','isapprovehp','isscangi','isapprovegi'
				),
                
			),
		));
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	
}