<h3><?php echo $this->getCatalog('themes') ?></h3>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('admin/theme/install'),
    'mimeTypes' => array('.zip'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'ThemeList',
    'ajaxUpdate'=>false,
    'template'=>'{sorter}{pager}{summary}{items}{pager}',
    'itemView'=>'_view',
    'pager'=>array(
        'maxButtonCount'=>'7',
    ),
));
?>