<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Company</h3>
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

$icon = new EGMapMarkerImage(Yii::app()->baseUrl.'/images/cabin.png');
$icon->setSize(32, 37);
$icon->setAnchor(16, 16.5);
$icon->setOrigin(0, 0);
$companys = Yii::app()->db->createCommand('select companyname,address,lat,lng
	from company a')->queryAll();
foreach($companys as $company)
{
	$marker = new EGMapMarkerWithLabel($company['lat'],$company['lng'], 
		array('title' => $company['companyname'],
		'icon'=>$icon));
	$info_window = new EGMapInfoWindow($this->getcatalog('company').': '.$company['companyname'].
		'<br/>'.$this->getcatalog('address').': '.$company['address']);
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