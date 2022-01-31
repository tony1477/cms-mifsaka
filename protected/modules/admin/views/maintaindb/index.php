<script>
function Backup()
{
	window.open('<?php echo Yii::app()->createUrl('admin/maintaindb/backup')?>');
}
</script>

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Backup</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<button type="submit" class="btn btn-success" onclick="Backup()"><?php echo $this->getCatalog('backup') ?></button>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Restore</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body no-padding">
		<?php
		$this->widget('ext.dropzone.EDropzone', array(
				'name'=>'upload',
				'url' => Yii::app()->createUrl('admin/maintaindb/restore'),
				'mimeTypes' => array('.zip'),
				'options' => CMap::mergeArray($this->options, $this->dict ),
				'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
		));
		?>
	</div><!-- /.box-body -->
</div><!-- /.box -->