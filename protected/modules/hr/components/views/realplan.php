<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Realisasi Kegiatan Karyawan</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">	
	<div class="col-md-12">
    <?php
		$this->widget('application.extensions.LiveGridView.RefreshGridView', array(
				'id'=>'realplanid',
				'updatingTime'=>1200000, // 60 sec
				'dataProvider'=>$dataProvider,
		'id'=>'realplanlist',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'header'=>$this->getCatalog('empplanname'),
				'name'=>'empplanname',
				'value'=>'$data["empplanname"]'
			),
			array(
				'header'=>$this->getCatalog('objvalue'),
				'name'=>'objvalue',
				'value'=>'$data["objvalue"]'
			),
			array(
				'header'=>$this->getCatalog('description'),
				'name'=>'description',
				'value'=>'$data["description"]'
			),
		)
		));
?>
</div>
  </div>
</div>
