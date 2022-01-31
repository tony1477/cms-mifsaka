<?php 
class Recentproduct extends Portlet
{ 
	protected function renderContent()
	{
		$products = Yii::app()->db->createCommand('select productpic,productname,
				(select currencyvalue from productsales b where b.productid = a.productid limit 1) as productprice,
				(select c.uomcode from productsales b inner join unitofmeasure c on c.unitofmeasureid = b.uomid where b.productid = a.productid limit 1) as uom
			from product a 
			order by productid desc limit 5')->queryAll();
		$this->render('recentproduct',array('products'=>$products));
	}
}