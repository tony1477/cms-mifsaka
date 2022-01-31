<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/adminlte/plugins/fullcalendar/fullcalendar.min.css');
$dependency = new CDbCacheDependency('SELECT MAX(a.schedulebbid) FROM schedulebb a
join product b on b.productid = a.productid 
where tahun = year(now() and bulan = month(now())');
$sql = "SELECT b.productname,c.uomcode,a.* FROM schedulebb a
join product b on b.productid = a.productid 
join unitofmeasure c on c.unitofmeasureid = a.uomid 
where tahun = year(now())";
$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
?>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/fullcalendar/fullcalendar.min.js"></script>
<div class="box box-primary">
<div class="box-header with-border">
		<h3 class="box-title">Raw Material Schedule</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<!-- THE CALENDAR -->
		<div id="rawmaterialschedule"></div>
	</div><!-- /.box-body -->
</div><!-- /. box -->
<script>
var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
$('#rawmaterialschedule').fullCalendar({
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
			if ($data['d1'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d1']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/1'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/1'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d2'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d2']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/2'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/2'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d3'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d3']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/3'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/3'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d4'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d4']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/4'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/4'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d5'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d5']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/5'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/5'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d6'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d6']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/6'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/6'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d7'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d7']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/7'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/7'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d8'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d8']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/8'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/8'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d9'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d9']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/9'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/9'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d10'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d10']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/10'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/10'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d11'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d11']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/11'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/11'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d12'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d12']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/12'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/12'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d13'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d13']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/13'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/13'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d14'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d14']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/14'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/14'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d15'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d15']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/15'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/15'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d16'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d16']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/16'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/16'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d17'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d17']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/17'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/17'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d18'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d18']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/18'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/18'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d19'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d19']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/19'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/19'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d20'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d20']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/20'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/20'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d21'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d21']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/21'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/21'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d22'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d22']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/22'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/22'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d23'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d23']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/23'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/23'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d24'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d24']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/24'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/24'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d25'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d25']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/25'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/25'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d26'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d26']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/26'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/26'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d27'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d27']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/27'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/27'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d28'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d28']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/28'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/28'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d29'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d29']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/29'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/29'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d30'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d30']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/30'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/30'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
			if ($data['d31'] > 0)
			{
				echo "
				{
					title: '".$data['productname']." ".Yii::app()->format->formatNumber($data['d31']).$data['uomcode']."',
					start: new Date('".$data['tahun']."/".$data['bulan']."/31'),
					end: new Date('".$data['tahun']."/".$data['bulan']."/31'),
					backgroundcolor : '#f56954',
					borderColor : '#f56954',
					allDay: true,
				},";
			}
		}
	?>
	],
	editable: false,
	droppable: false, // this allows things to be dropped onto the calendar !!!
});
</script>
