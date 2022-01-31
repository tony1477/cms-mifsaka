<style type="text/css">
.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +1000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:35%;
}
</style>
<script type="text/javascript">
function searchdata($id=0)
{
    $('#SearchDialog').modal('hide');
    $('.ajax-loader').css('visibility', 'visible');
	$.fn.yiiGridView.update("ProductStockList",{data:{
		'storagebin':$("input[name='dlg_search_storagebin']").val(),
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val()
	},
         complete: function(jqXHR, status) {
            if (status=='success'){
                //console.log(jqXHR, status)
                $('.ajax-loader').css("visibility", "hidden");
            }                                           
    }});
	return false;
}

function downpdf($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('<?php echo Yii::app()->createUrl('Stock/productstock/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('<?php echo Yii::app()->createUrl('Stock/productstock/downxls')?>?'+array);
}
</script>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><a href="<?php echo Yii::app()->createUrl('stock/productstock/')?>">Material Stock Overview</a></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
    <button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
	<div class="box-body">
		<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'ProductStockList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
array(
					'header'=>$this->getCatalog('productstockid'),
					'name'=>'productstockid',
					'value'=>'$data["productstockid"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('storagedesc'),
					'name'=>'storagebinid',
					'value'=>'$data["storagedesc"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('qtyinprogress'),
					'name'=>'qtyinprogress',
					'value'=>'Yii::app()->format->formatNumber($data["qtyinprogress"])'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							
		)
));
?>	
    </div><!-- /.box-body -->
</div><!-- /.box -->
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
                    <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
                    <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
                    <div class="form-group">
						<label for="dlg_search_storagebin"><?php echo $this->getCatalog('storagebindesc')?></label>
						<input type="text" class="form-control" name="dlg_search_storagebin">
					</div>
					<div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
				</div>
		</div>
	</div>
</div>
