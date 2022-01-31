<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Dokumen STNK </h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">	
	<div class="col-md-12">
    <?php
		$this->widget('application.extensions.LiveGridView.RefreshGridView', array(
				//'rowCssClassExpression'=>'($data["warna"] == "merah")?"bg-red":"bg-white"',
				'updatingTime'=>1200000, // 60 sec
				'dataProvider'=>$dataProvider,
		'id'=>'docstnklist',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'header'=>$this->getCatalog('companyname'),
				'name'=>'companyname',
				'value'=>'$data["companyname"]'
			),
			array(
				'header'=>$this->getCatalog('nodoc'),
				'name'=>'nodoc',
				'value'=>'$data["nodoc"]'
			),
			array(
				'header'=>$this->getCatalog('namedoc'),
				'name'=>'namedoc',
				'value'=>'$data["namedoc"]'
			),
            array(
				'header'=>$this->getCatalog('exdate'),
				'name'=>'exdate',
				'value'=>'Yii::app()->format->formatDate($data["exdate"])'
			),
		)
		));
?>
</div>
  </div>
</div>
