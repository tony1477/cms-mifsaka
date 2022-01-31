<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Who's getting Older</h3>
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
		'id'=>'birthdaylist',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'header'=>$this->getCatalog('fullname'),
				'name'=>'fullname',
				'value'=>'$data["fullname"]'
			),
			array(
				'header'=>$this->getCatalog('birthdate'),
				'name'=>'birthdate',
				'value'=>'Yii::app()->format->formatDate($data["birthdate"])'
			),
			array(
				'header'=>$this->getCatalog('structurename'),
				'name'=>'structurename',
				'value'=>'$data["structurename"]'
			),
            array(
				'header'=>$this->getCatalog('companycode'),
				'name'=>'companycode',
				'value'=>'$data["companycode"]'
			),
		)
		));
?>
</div>
  </div>
</div>
