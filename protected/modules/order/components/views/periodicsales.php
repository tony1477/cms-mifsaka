<?php 
$sqlcomp = "select companyid,companyname from company where recordstatus = 1";
$allcomps = Yii::app()->db->createCommand($sqlcomp)->queryAll();
foreach ($allcomps as $allcomp) {
$sql = "select DATE_FORMAT(NOW() ,'%Y-01-01') as firstdateyear,DATE_FORMAT(NOW() ,'%Y-12-31') as lastdateyear, 
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 1 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as januari,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 2 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as februari,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 3 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as maret,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 4 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as april,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 5 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as mei,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 6 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as juni,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 7 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as juli,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 8 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as agustus,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 9 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as september,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 10 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as oktober,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 11 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as november,
(
select ifnull(sum(getamountdiscbyso(a.soheaderid)),0)
from soheader a
where month(a.sodate) = 12 and year(a.sodate) = year(now()) and a.pocustno is not null and a.recordstatus = 6 and a.companyid = ".$allcomp['companyid']." 
) as desember
"; 

			$dataReader=Yii::app()->db->createCommand($sql)->queryRow();
			
?>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/chartjs/Chart.min.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Periodic Sales Report <?php echo $allcomp['companyname']?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-md-8">
				<p class="text-center">
					<strong>Sales: <?php echo Yii::app()->format->formatDate($dataReader['firstdateyear'])?> - 
						<?php echo Yii::app()->format->formatDate($dataReader['lastdateyear'])?></strong>
				</p>
				<div class="chart">
					<!-- Sales Chart Canvas -->
					<canvas id="salesChart<?php echo $allcomp['companyid']?>" style="height: 300px;"></canvas>
				</div><!-- /.chart-responsive -->
			</div><!-- /.col -->
			<div class="col-md-4">
				<p class="text-center">
					<strong>Monthly Sales</strong>
				</p>
				<div class="progress-group">
					<div class="col-md-4"><?php echo $this->getCatalog('month')?></div>
					<div class="col-md-8"><?php echo $this->getCatalog('sales')?></div>
				</div>
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Januari')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['januari'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Februari')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['februari'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Maret')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['maret'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('April')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['april'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Mei')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['mei'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Juni')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['juni'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Juli')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['juli'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Agustus')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['agustus'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('September')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['september'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Oktober')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['oktober'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('November')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['november'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-4"><span class="progress-text"><?php echo $this->getCatalog('Desember')?></span></div>
					<div class="col-md-8"><span class="label label-primary"><b><?php echo Yii::app()->format->formatCurrency($dataReader['desember'])?></b></span></div>
				</div><!-- /.progress-group -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- ./box-body -->
	<div class="box-footer">
	</div><!-- /.box-footer -->
</div><!-- /.box -->
<script>
var salesChartCanvas = $("#salesChart<?php echo $allcomp['companyid']?>").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: ["<?php echo $this->getCatalog('Januari')?>", 
			"<?php echo $this->getCatalog('Februari')?>", "<?php echo $this->getCatalog('Maret')?>", 
			"<?php echo $this->getCatalog('April')?>", "<?php echo $this->getCatalog('Mei')?>", 
			"<?php echo $this->getCatalog('Juni')?>", "<?php echo $this->getCatalog('Juli')?>", 
			"<?php echo $this->getCatalog('Agustus')?>","<?php echo $this->getCatalog('September')?>",
			"<?php echo $this->getCatalog('Oktober')?>","<?php echo $this->getCatalog('November')?>",
			"<?php echo $this->getCatalog('Desember')?>"],
    datasets: [
      {
        label: "Customer",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [<?php echo $dataReader['januari']?>, <?php echo $dataReader['februari']?>, 
					<?php echo $dataReader['maret']?>, <?php echo $dataReader['april']?>, 
					<?php echo $dataReader['mei']?>, <?php echo $dataReader['juni']?>, 
					<?php echo $dataReader['juli']?>,<?php echo $dataReader['agustus']?>,
					<?php echo $dataReader['september']?>,<?php echo $dataReader['oktober']?>,
					<?php echo $dataReader['november']?>,<?php echo $dataReader['desember']?>]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: true,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 2,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
</script>
<?php } ?>
