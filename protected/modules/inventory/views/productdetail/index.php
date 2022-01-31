<script type="text/javascript">

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'productdetailid='+$id
+ '&materialcode='+$("input[name='dlg_search_materialcode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&location='+$("input[name='dlg_search_location']").val()
+ '&ownershipname='+$("input[name='dlg_search_ownershipname']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val()
+ '&serialno='+$("input[name='dlg_search_serialno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'productdetailid='+$id
+ '&materialcode='+$("input[name='dlg_search_materialcode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&location='+$("input[name='dlg_search_location']").val()
+ '&ownershipname='+$("input[name='dlg_search_ownershipname']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val()
+ '&serialno='+$("input[name='dlg_search_serialno']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/productdetail/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'productdetailid='+$id
+ '&materialcode='+$("input[name='dlg_search_materialcode']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&location='+$("input[name='dlg_search_location']").val()
+ '&ownershipname='+$("input[name='dlg_search_ownershipname']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val()
+ '&serialno='+$("input[name='dlg_search_serialno']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/productdetail/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productdetailid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('productdetail') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>

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
array(
					'header'=>$this->getCatalog('productdetailid'),
					'name'=>'productdetailid',
					'value'=>'$data["productdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('materialcode'),
					'name'=>'materialcode',
					'value'=>'$data["materialcode"]'
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
					'header'=>$this->getCatalog('expiredate'),
					'name'=>'expiredate',
					'value'=>'Yii::app()->format->formatDate($data["expiredate"])'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('buydate'),
					'name'=>'buydate',
					'value'=>'Yii::app()->format->formatDate($data["buydate"])'
				),
							array(
					'header'=>$this->getCatalog('buyprice'),
					'name'=>'buyprice',
					'value'=>'Yii::app()->format->formatNumber($data["buyprice"])'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'storagebinid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('location'),
					'name'=>'location',
					'value'=>'$data["location"]'
				),
							array(
					'header'=>$this->getCatalog('locationdate'),
					'name'=>'locationdate',
					'value'=>'Yii::app()->format->formatDateTime($data["locationdate"])'
				),
							array(
					'header'=>$this->getCatalog('materialstatusname'),
					'name'=>'materialstatusid',
					'value'=>'$data["materialstatusname"]'
				),
							array(
					'header'=>$this->getCatalog('ownershipname'),
					'name'=>'ownershipid',
					'value'=>'$data["ownershipname"]'
				),
							array(
					'header'=>$this->getCatalog('referenceno'),
					'name'=>'referenceno',
					'value'=>'$data["referenceno"]'
				),
							array(
					'header'=>$this->getCatalog('vrqty'),
					'name'=>'vrqty',
					'value'=>'Yii::app()->format->formatNumber($data["vrqty"])'
				),
							array(
					'header'=>$this->getCatalog('serialno'),
					'name'=>'serialno',
					'value'=>'$data["serialno"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
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
						<label for="dlg_search_materialcode"><?php echo $this->getCatalog('materialcode')?></label>
						<input type="text" class="form-control" name="dlg_search_materialcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
					</div>
          <div class="form-group">
						<label for="dlg_search_location"><?php echo $this->getCatalog('location')?></label>
						<input type="text" class="form-control" name="dlg_search_location">
					</div>
          <div class="form-group">
						<label for="dlg_search_ownershipname"><?php echo $this->getCatalog('ownershipname')?></label>
						<input type="text" class="form-control" name="dlg_search_ownershipname">
					</div>
          <div class="form-group">
						<label for="dlg_search_referenceno"><?php echo $this->getCatalog('referenceno')?></label>
						<input type="text" class="form-control" name="dlg_search_referenceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_serialno"><?php echo $this->getCatalog('serialno')?></label>
						<input type="text" class="form-control" name="dlg_search_serialno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('productdetail') ?></h4>
      </div>
      <div class="modal-body">
				
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


