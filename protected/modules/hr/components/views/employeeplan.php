<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Rencana Kegiatan Karyawan</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">	
	<div class="col-md-12">
    <?php
		$this->widget('application.extensions.LiveGridView.RefreshGridView', array(
                'rowCssClassExpression'=>'($data["warna"] == "merah")?"bg-red":"bg-white"',
				'updatingTime'=>1200000, // 60 sec
				'dataProvider'=>$dataProvider,
		'id'=>'empplanlist',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'header'=>$this->getCatalog('description'),
				'name'=>'description',
				'value'=>'$data["description"]'
			),
			array(
				'header'=>$this->getCatalog('objvalue'),
				'name'=>'objvalue',
				'value'=>'$data["objvalue"]'
			),
			array(
				'header'=>$this->getCatalog('startdate'),
				'name'=>'startdate',
				'value'=>'$data["startdate"]'
			),
			array(
				'header'=>$this->getCatalog('enddate'),
				'name'=>'enddate',
				'value'=>'$data["enddate"]'
			),
		)
		));
?>
</div>
  </div>
</div>
