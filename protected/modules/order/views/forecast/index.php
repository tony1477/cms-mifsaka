<script src="<?php echo Yii::app()->baseUrl;?>/js/forecast.js"></script>
<script>
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
						'productid':$("input[name='forecast_0_productid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='forecast_0_uomid']").val(data.uomid);
				$("input[name='forecast_0_uomcode']").val(data.uomcode);
				$("input[name='forecast_0_slocid']").val(data.slocid);
				$("input[name='forecast_0_sloccode']").val(data.sloccode);

			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}
</script>
<h3><?php echo $this->getCatalog('forecast') ?></h3>
<?php if ($this->checkAccess('forecast','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('order/forecast/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('forecast','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="generatefg()"><?php echo $this->getCatalog('generate')?></button>
<?php } ?>
<?php if ($this->checkAccess('forecast','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('forecast','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('forecast','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<?php } ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
				'htmlOptions' => array('style'=>'width:10px'),
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {delete} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('forecast','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('forecast','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('forecast','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('forecastid'),
					'name'=>'forecastid',
					'value'=>'$data["forecastid"]'
				),
							array(
					'header'=>$this->getCatalog('bulan'),
					'name'=>'bulan',
					'value'=>'$data["bulan"]'
				),
							array(
					'header'=>$this->getCatalog('tahun'),
					'name'=>'tahun',
					'value'=>'$data["tahun"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							
		)
));
?>
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_bulan"><?php echo $this->getCatalog('bulan')?></label>
						<input type="text" class="form-control" name="dlg_search_bulan">
					</div>
					<div class="form-group">
						<label for="dlg_search_tahun"><?php echo $this->getCatalog('tahun')?></label>
						<input type="text" class="form-control" name="dlg_search_tahun">
					</div>
					<div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
					<div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
				</div>
		</div>
	</div>
</div>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('forecast') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="forecast_0_forecastid">
        <div class="row">
						<div class="col-md-4">
							<label for="forecast_0_bulan"><?php echo $this->getCatalog('bulan')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="forecast_0_bulan">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="forecast_0_tahun"><?php echo $this->getCatalog('tahun')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="forecast_0_tahun">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'forecast_0_productid','ColField'=>'forecast_0_productname',
							'IDDialog'=>'forecast_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'forecast_0_productidgrid',
							'onaftersign'=>'getproductdata();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="forecast_0_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="forecast_0_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'forecast_0_uomid','ColField'=>'forecast_0_uomcode',
							'IDDialog'=>'forecast_0_uomid_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'forecast_0_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'forecast_0_uomidgrid')); 
					?>
							
							        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'forecast_0_slocid','ColField'=>'forecast_0_sloccode',
							'IDDialog'=>'forecast_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID2'=>'forecast_0_productid',
							'PopUpName'=>'common.components.views.SlocProductPopUp','PopGrid'=>'forecast_0_slocidgrid')); 
					?>
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'forecast_0_bomid','ColField'=>'forecast_0_bomversion',
							'IDDialog'=>'forecast_0_bomid_dialog','titledialog'=>$this->getCatalog('bom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'forecast_0_productid',
							'PopUpName'=>'production.components.views.ProductbomPopUp','PopGrid'=>'forecast_0_bomidgrid')); 
					?>
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


