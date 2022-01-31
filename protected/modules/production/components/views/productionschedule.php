<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/adminlte/plugins/fullcalendar/fullcalendar.min.css');
$dependency = new CDbCacheDependency('SELECT MAX(a.productplanfgid) FROM productplanfg a
join product b on b.productid = a.productid 
join productplan c on c.productplanid = a.productplanid
join unitofmeasure e on e.unitofmeasureid = a.uomid
left join soheader d on d.soheaderid = c.soheaderid
left join addressbook f on f.addressbookid = d.addressbookid
where year(a.startdate) = year(now())');
$sql = "select a.startdate,a.enddate,b.productname,a.qty,e.uomcode,d.pocustno,f.fullname
from productplanfg a
join product b on b.productid = a.productid 
join productplan c on c.productplanid = a.productplanid
join unitofmeasure e on e.unitofmeasureid = a.uomid
left join soheader d on d.soheaderid = c.soheaderid
left join addressbook f on f.addressbookid = d.addressbookid
where year(a.startdate) = year(now())";
$dataReader=Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
?>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/fullcalendar/fullcalendar.min.js"></script>
<div class="box box-primary">
<div class="box-header with-border">
		<h3 class="box-title">Production Schedule</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<!-- THE CALENDAR -->
		<div id="productionschedule"></div>
	</div><!-- /.box-body -->
</div><!-- /. box -->
<script>
var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
$('#productionschedule').fullCalendar({
	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
	},
	buttonText: {
		today: 'today',
		month: 'month',
		week: 'week',
		day: 'day'
	},
	//Random default events
	events: [
	<?php 
		foreach ($dataReader as $data)
		{
			echo "
			{
				title: '".$data['fullname']." ".$data['pocustno']." ".$data['productname']." ".Yii::app()->format->formatNumber($data['qty']).$data['uomcode']."',
				start: new Date('".$data['startdate']."'),
				end: new Date('".$data['enddate']."'),
				backgroundcolor : '#f56954',
				borderColor : '#f56954',
				allDay: true,
			},";
		}
	?>
	],
	editable: false,
	droppable: false, // this allows things to be dropped onto the calendar !!!
});
</script>
