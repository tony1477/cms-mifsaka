<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">User TO DO</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">	
	<div class="col-md-12">
    <?php
		$this->widget('application.extensions.LiveGridView.RefreshGridView', array(
				'id'=>'usertodogrid',
				'updatingTime'=>1200000, // 60 sec
				'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'header'=>$this->getCatalog('tododate'),
				'name'=>'tododate',
				'value'=>'Yii::app()->format->formatDateTime($data["tododate"])'
			),
			array(
				'header'=>$this->getCatalog('docno'),
				'name'=>'docno',
				'value'=>'$data["docno"]'
			),
			array(
				'header'=>$this->getCatalog('menuname'),
				'type'=>'raw',
				'name'=>'menuname',
				'value'=>'CHtml::link($this->grid->owner->getCatalog($data["menuname"]),
					Yii::app()->createUrl($this->grid->owner->getMenuModule($data["menuname"])))'
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
