<?php 
$sqlcomp = "select companyid,companyname from company where recordstatus = 1";
$allcomps = Yii::app()->db->createCommand($sqlcomp)->queryAll();
foreach ($allcomps as $allcomp) {
$sql = "
select *,(januari - januari1) as seljan, (februari - februari1) as selfeb, (maret - maret1) as selmar,
(april - april1) as selap, (mei - mei1) as selmei, (juni - juni1) as seljun, (juli - juli1) as seljul,
(agustus - agustus1) as selag, (september - september1) as selsep, (oktober - oktober1) as selok,
(november - november1) as selnov, (desember - desember1) as seldes
from (
select DATE_FORMAT(NOW() ,'%Y-01-01') as firstdateyear,DATE_FORMAT(NOW() ,'%Y-12-31') as lastdateyear, 
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 1 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as januari,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 2 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as februari,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 3 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as maret,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 4 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as april,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 5 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as mei,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 6 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as juni,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 7 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as juli,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 8 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as agustus,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 9 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as september,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 10 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as oktober,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 11 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as november,
(
select ifnull(sum(b.qty),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 12 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as desember,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 1 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as januari1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 2 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as februari1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 3 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as maret1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 4 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as april1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 5 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as mei1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 6 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as juni1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 7 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as juli1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 8 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as agustus1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 9 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as september1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 10 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as oktober1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 11 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as november1,
(
select ifnull(sum(b.qtyres),0)
from productplan a
join productplanfg b on b.productplanid = a.productplanid
where month(a.productplandate) = 12 and year(a.productplandate) = year(now()) and a.recordstatus = 3 and a.companyid = ".$allcomp['companyid']." 
) as desember1
) z
"; 

			$dataReader=Yii::app()->db->createCommand($sql)->queryRow();
			
?>
<script src="<?php echo Yii::app()->theme->baseUrl?>/adminlte/plugins/chartjs/Chart.min.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Comparation Planning vs Output <?php echo $allcomp['companyname']?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="row">
			<div class="col-md-6">
				<p class="text-center">
					<strong>Periode: <?php echo Yii::app()->format->formatDate($dataReader['firstdateyear'])?> - 
						<?php echo Yii::app()->format->formatDate($dataReader['lastdateyear'])?></strong>
				</p>
				<div class="chart">
					<!-- Sales Chart Canvas -->
					<canvas id="ppopChart<?php echo $allcomp['companyid']?>" style="height: 300px;"></canvas>
				</div><!-- /.chart-responsive -->
			</div><!-- /.col -->
			<div class="col-md-6">
				<p class="text-center">
					<strong>Monthly</strong>
				</p>
				<div class="progress-group">
					<div class="col-md-3"><?php echo $this->getCatalog('month')?></div>
					<div class="col-md-3"><?php echo $this->getCatalog('SPK')?></div>
					<div class="col-md-3"><?php echo $this->getCatalog('productoutput')?></div>
					<div class="col-md-3"><?php echo $this->getCatalog('selisih')?></div>
				</div>
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Januari')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['januari'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['januari1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['seljan'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Februari')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['februari'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['februari1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selfeb'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Maret')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['maret'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['maret1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selmar'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('April')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['april'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['april1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selap'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Mei')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['mei'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['mei1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selmei'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Juni')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['juni'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['juni1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['seljun'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Juli')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['juli'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['juli1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['seljul'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Agustus')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['agustus'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['agustus1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selag'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('September')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['september'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['september1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selsep'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Oktober')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['oktober'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['oktober1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selok'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('November')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['november'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['november1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['selnov'])?></b></span></div>
				</div><!-- /.progress-group -->
				<div class="progress-group">
					<div class="col-md-3"><span class="progress-text"><?php echo $this->getCatalog('Desember')?></span></div>
					<div class="col-md-3"><span class="label label-primary"><b><?php echo Yii::app()->format->formatNumber($dataReader['desember'])?></b></span></div>
					<div class="col-md-3"><span class="label label-danger"><b><?php echo Yii::app()->format->formatNumber($dataReader['desember1'])?></b></span></div>
					<div class="col-md-3"><span class="label label-warning"><b><?php echo Yii::app()->format->formatNumber($dataReader['seldes'])?></b></span></div>
				</div><!-- /.progress-group -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- ./box-body -->
	<div class="box-footer">
	</div><!-- /.box-footer -->
</div><!-- /.box -->
<script>
var salesChartCanvas = $("#ppopChart<?php echo $allcomp['companyid']?>").get(0).getContext("2d");
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
        label: "SPK",
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
      },
			{
        label: "Hasil Produksi",
        fillColor: "#dd4b39",
        strokeColor: "#dd4b39",
        pointColor: "#dd4b39",
        pointStrokeColor: "#dd4b39",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#dd4b39",
        data: [<?php echo $dataReader['januari1']?>, <?php echo $dataReader['februari1']?>, 
					<?php echo $dataReader['maret1']?>, <?php echo $dataReader['april1']?>, 
					<?php echo $dataReader['mei1']?>, <?php echo $dataReader['juni1']?>, 
					<?php echo $dataReader['juli1']?>,<?php echo $dataReader['agustus1']?>,
					<?php echo $dataReader['september1']?>,<?php echo $dataReader['oktober1']?>,
					<?php echo $dataReader['november1']?>,<?php echo $dataReader['desember1']?>]
      },
      {
        label: "Selisih",
        fillColor: "#dd4b39",
        strokeColor: "#dd4b39",
        pointColor: "#dd4b39",
        pointStrokeColor: "#dd4b39",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "#dd4b39",
        data: [<?php echo $dataReader['seljan']?>, 
        	<?php echo $dataReader['selfeb']?>, 
					<?php echo $dataReader['maret1']?>, 
					<?php echo $dataReader['april1']?>, 
					<?php echo $dataReader['mei1']?>, <?php echo $dataReader['juni1']?>, 
					<?php echo $dataReader['juli1']?>,<?php echo $dataReader['agustus1']?>,
					<?php echo $dataReader['september1']?>,<?php echo $dataReader['oktober1']?>,
					<?php echo $dataReader['november1']?>,<?php echo $dataReader['desember1']?>]
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
