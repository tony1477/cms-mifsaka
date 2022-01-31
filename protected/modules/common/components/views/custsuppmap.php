<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Customer & Supplier</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<?php
Yii::import('ext.egmap.*');
 
$gMap = new EGMap();
$gMap->zoom = 5;
$gMap->setWidth('100%');
$gMap->setHeight(400);
$mapTypeControlOptions = array(
  'position'=> EGMapControlPosition::LEFT_BOTTOM,
  'style'=>EGMap::MAPTYPECONTROL_STYLE_DROPDOWN_MENU
);
$gMap->mapTypeControlOptions= $mapTypeControlOptions;
$gMap->setCenter(-1.733094,120.1330883);

$companys = Yii::app()->db->createCommand('select isvendor,iscustomer,fullname,b.lat,b.lng,creditlimit,currentlimit,currentdebt, b.addressname from addressbook a 
	inner join address b on b.addressbookid = a.addressbookid')->queryAll();
foreach($companys as $company)
{
	if ($company['isvendor'] == 1)
	{
		$icon = new EGMapMarkerImage(Yii::app()->baseUrl.'/images/smallcity.png');
	}
	else
	{
		$icon = new EGMapMarkerImage(Yii::app()->baseUrl.'/images/bigcity.png');
	}
	$icon->setSize(32, 37);
	$icon->setAnchor(16, 16.5);
	$icon->setOrigin(0, 0);
	$marker = new EGMapMarkerWithLabel($company['lat'],$company['lng'], 
		array('title' => $company['fullname'],
		'icon'=>$icon));
		if ($company['isvendor'] == 1)
	{
	$info_window = new EGMapInfoWindow($this->getcatalog('fullname').': '.$company['fullname'].
		'<br/>'.$this->getcatalog('address').': '.$company['addressname'].
		'<br/>'.$this->getcatalog('currentdebt').': '.Yii::app()->format->formatCurrency($company['currentdebt']));
	$marker->addHtmlInfoWindow($info_window);
	}
	else
	{
		$info_window = new EGMapInfoWindow($this->getcatalog('fullname').': '.$company['fullname'].
		'<br/>'.$this->getcatalog('address').': '.$company['addressname'].
		'<br/>'.$this->getcatalog('creditlimit').': '.Yii::app()->format->formatCurrency($company['creditlimit']).
		'<br/>'.$this->getcatalog('currentlimit').': '.Yii::app()->format->formatCurrency($company['currentlimit']));
	$marker->addHtmlInfoWindow($info_window);
	}
	$gMap->addMarker($marker);
}
$gMap->renderMap();
?>
	</div><!-- /.box-body -->
</div><!-- /.box -->