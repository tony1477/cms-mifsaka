<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl."/bootstrap/js/jquery.bootstrap.wizard.min.js"); ?>
<script>
$(function() {
    $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = ($current/$total) * 100;
		$('#wizprogress').css({width:$percent+'%'});
		$('#wizprogress').attr({'aria-valuenow':$percent});
		$('#wizprogress').html(Math.round($percent)+'%');
		
		// If it's the last tab then hide the last button and show the finish instead
		if($current >= $total) {
			$('#rootwizard').find('.pager .next').hide();
			$('#rootwizard').find('.pager .finish').show();
			$('#rootwizard').find('.pager .finish').removeClass('disabled');
		} else {
			$('#rootwizard').find('.pager .next').show();
			$('#rootwizard').find('.pager .finish').hide();
		}
	},
	/*onTabClick: function(tab, navigation, index) {
		alert('<?php echo getCatalog("notallowtabclick")?>');
		return false;
	},*/
	onNext: function(tab, navigation, index) {
			if(index==2) {
				// Make sure we entered the name
				if(!$('input[name="tablename"]').val()) {
					toastr.error('<?php echo getCatalog("emptytablename")?>');
					$('input[name="tablename"]').focus();
					return false;
				}
				else
				if(!$('input[name="controller"]').val()) {
					toastr.error('<?php echo getCatalog("emptycontroller")?>');
					$('input[name="controller"]').focus();
					return false;
				}
				else
				if(!$('input[name="module"]').val()) {
					toastr.error('<?php echo getCatalog("emptymodule")?>');
					$('input[name="module"]').focus();
					return false;
				}
			}			
		}}
	);
	$('#rootwizard .finish').click(function() {
		location.reload();
	});
});
</script>
<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Point Of Sales</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<form class="form-horizontal" role="form" id="posform">
			<div id="rootwizard">
				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
							<ul>
								<li><a href="#tab1" data-toggle="tab">Perkenalan</a></li>
								<li><a href="#tab2" data-toggle="tab">Konfigurasi</a></li>
								<li><a href="#tab3" data-toggle="tab">View</a></li>
								<li><a href="#tab4" data-toggle="tab">Instalasi</a></li>
								<li><a href="#tab5" data-toggle="tab">Selesai</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="progress">
						<div id="wizprogress" class="progress-bar progress-bar-striped active" role="progressbar"
								 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
							0%
						</div>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane" id="tab1">
						<div class="container">
							<h1>Menu Generator</h1>
							<p>Modul ini akan melakukan pembuatan code secara otomatis sesuai data yang dimasukkan</p> 
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>