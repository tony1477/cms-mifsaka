<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/adminlte/plugins/fullcalendar/fullcalendar.min.css');
$sql = "select a.delvdate,d.fullname,c.productname,a.qty,b.pocustno,e.uomcode
from sodetail a
join soheader b on b.soheaderid = a.soheaderid
join product c on c.productid = a.productid
join addressbook d on d.addressbookid= b.addressbookid
join unitofmeasure e on e.unitofmeasureid = a.unitofmeasureid	
where year(a.delvdate) = year(now()) and b.recordstatus in (".getUserRecordStatus('listso').") 
and b.companyid in (".getUserObjectValues('company').")";
$dataReader=Yii::app()->db->createCommand($sql)->queryAll();
?>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/fullcalendar/fullcalendar.min.js"></script>
<div class="box box-primary">
<div class="box-header with-border">
		<h3 class="box-title">Delivery Schedule</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<!-- THE CALENDAR -->
		<div id="deliveryschedule"></div>
	</div><!-- /.box-body -->
</div><!-- /. box -->
<script>
var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
$('#deliveryschedule').fullCalendar({
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
				title: '".$data['fullname']." ".$data['pocustno']." ".$data['productname']." ".
					Yii::app()->format->formatNumber($data['qty']).$data['uomcode']."',
				start: new Date('".$data['delvdate']."'),
				allDay: true,
				backgroundcolor : 'green',
				borderColor : '#f56954',
				
			},";
		}
	?>
	],
	editable: false,
	droppable: false, // this allows things to be dropped onto the calendar !!!
});
</script>
