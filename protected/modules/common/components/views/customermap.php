<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Customer</h3>
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

$icon = new EGMapMarkerImage(Yii::app()->baseUrl.'/images/smallcity.png');
$icon->setSize(32, 37);
$icon->setAnchor(16, 16.5);
$icon->setOrigin(0, 0);
 $companys = Yii::app()->db->createCommand("select a.addressbookid,fullname,b.lat,b.lng,creditlimit,currentlimit,b.addressname from addressbook a 
	inner join address b on b.addressbookid = a.addressbookid 
	where iscustomer=1 and a.fullname <> '' and a.fullname is not null order by a.fullname")->queryAll();
foreach($companys as $company)
{
	$marker = new EGMapMarkerWithLabel($company['lat'],$company['lng'], 
		array('title' => $company['fullname'],
		'icon'=>$icon));
	$info_window = new EGMapInfoWindow('Customer : '.$company['fullname'].
		'<br/>Alamat: '.$company['addressname'].
		'<br/>Credit Limit: '.Yii::app()->format->formatCurrency($company['creditlimit']).
		'<br/>Current Limit: '.Yii::app()->format->formatCurrency($company['currentlimit']));
	$marker->addHtmlInfoWindow($info_window);
	$gMap->addMarker($marker);
}
$label_options = array(
  'backgroundColor'=>'yellow',
  'opacity'=>'0.75',
  'width'=>'100px',
  'color'=>'blue'
);
$gMap->renderMap();
?>
	</div><!-- /.box-body -->
</div><!-- /.box -->