<?php 
class Materialstockoverview extends Portlet
{ 
	protected function renderContent()
	{
		$dependency = new CDbCacheDependency('select max(a0.productstockid) from productstock a0');
		$sql = 'select a0.productstockid,a0.productid,a0.slocid,a0.storagebinid,a0.qty,a0.unitofmeasureid,a0.qtyinprogress,a1.productname as productname,a2.sloccode as sloccode,a3.description as storagedesc,a4.uomcode as uomcode 
    from productstock a0 
    join product a1 on a1.productid = a0.productid
    join sloc a2 on a2.slocid = a0.slocid
    join storagebin a3 on a3.storagebinid = a0.storagebinid
    join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid';
		$sqlcount = "select count(1) 
    from productstock a0 
    join product a1 on a1.productid = a0.productid
    join sloc a2 on a2.slocid = a0.slocid
    join storagebin a3 on a3.storagebinid = a0.storagebinid
    join unitofmeasure a4 on a4.unitofmeasureid = a0.unitofmeasureid
  ";
        $where = "";
        if (isset($_REQUEST['productname']))
			{
				if (($_REQUEST['productname'] !== '0') && ($_REQUEST['productname'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a1.productname like '%".$_REQUEST['productname']."%'";
					}
					else
					{
						$where .= " and a1.productname like '%".$_REQUEST['productname']."%'";
					}
				}
			}
        
        if (isset($_REQUEST['sloccode']))
			{
				if (($_REQUEST['sloccode'] !== '0') && ($_REQUEST['sloccode'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a2.sloccode like '%".$_REQUEST['sloccode']."%'";
					}
					else
					{
						$where .= " and a2.sloccode like '%".$_REQUEST['sloccode']."%'";
					}
				}
			}
        
        if (isset($_REQUEST['storagebin']))
			{
				if (($_REQUEST['storagebin'] !== '0') && ($_REQUEST['storagebin'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a3.description like '%".$_REQUEST['storagebin']."%'";
					}
					else
					{
						$where .= " and a3.description like '%".$_REQUEST['storagebin']."%'";
					}
				}
			}
        
        if (isset($_REQUEST['uomcode']))
			{
				if (($_REQUEST['uomcode'] !== '0') && ($_REQUEST['uomcode'] !== ''))
				{
					if ($where == "")
					{
						$where .= " where a4.uomcode like '%".$_REQUEST['uomcode']."%'";
					}
					else
					{
						$where .= " and a4.uomcode like '%".$_REQUEST['uomcode']."%'";
					}
				}
			}
        
		$count=Yii::app()->db->cache(1000,$dependency)->createCommand($sqlcount.$where)->queryScalar();
        $newsql = Yii::app()->db->cache(1000,$dependency)->createCommand($sql.$where);
		$dataProvider=new CSqlDataProvider($newsql,array(
			'totalItemCount'=>$count,
			'keyField'=>'productstockid',
			'pagination'=>array(
				'pageSize'=>$this->getParameter('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
				'attributes'=>array(
					 'productstockid','productid','slocid','storagebinid','qty','unitofmeasureid','qtyinprogress'
				),
				'defaultOrder' => array( 
					'productstockid' => CSort::SORT_DESC
				),
			),
		));
		$this->render('materialstockoverview',array('dataProvider'=>$dataProvider));
	}
    
    public function actionSearch(){
        
    }
}