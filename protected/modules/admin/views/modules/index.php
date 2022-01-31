<script>
function running(id,param2)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/modules/running')?>',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
</script>
<h3>Modules</h3>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('admin/modules/install'),
    'mimeTypes' => array('.zip'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'ModulesList',
    'ajaxUpdate'=>false,
    'template'=>'{sorter}{pager}{summary}{items}{pager}',
    'itemView'=>'_view',
    'pager'=>array(
        'maxButtonCount'=>'7',
    ),
));
?>