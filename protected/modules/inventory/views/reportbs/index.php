<script type="text/javascript">

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'bsheaderid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&bsheaderno='+$("input[name='dlg_search_bsheaderno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'bsheaderid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&bsheaderno='+$("input[name='dlg_search_bsheaderno']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/reportbs/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'bsheaderid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&bsheaderno='+$("input[name='dlg_search_bsheaderno']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/reportbs/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'bsheaderid='+$id
$.fn.yiiGridView.update("DetailbsdetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('reportbs') ?></h3>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('bsheader','isdownload')) { ?>
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
				'template'=>'{select} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('detail'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'url'=>'"#"',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('bsheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('bsheaderid'),
					'name'=>'bsheaderid',
					'value'=>'$data["bsheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('bsdate'),
					'name'=>'bsdate',
					'value'=>'Yii::app()->format->formatDate($data["bsdate"])'
				),
							array(
					'header'=>$this->getCatalog('bsheaderno'),
					'name'=>'bsheaderno',
					'value'=>'$data["bsheaderno"]'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_bsheaderno"><?php echo $this->getCatalog('bsheaderno')?></label>
						<input type="text" class="form-control" name="dlg_search_bsheaderno">
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
						<label for="dlg_search_ownershipname"><?php echo $this->getCatalog('ownershipname')?></label>
						<input type="text" class="form-control" name="dlg_search_ownershipname">
					</div>
          <div class="form-group">
						<label for="dlg_search_materialstatusname"><?php echo $this->getCatalog('materialstatusname')?></label>
						<input type="text" class="form-control" name="dlg_search_materialstatusname">
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
						<label for="dlg_search_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						<input type="text" class="form-control" name="dlg_search_itemnote">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('bsheader') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="bsheader_0_bsheaderid">
        <div class="row">
						<div class="col-md-4">
							<label for="bsheader_0_bsdate"><?php echo $this->getCatalog('bsdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="bsheader_0_bsdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsheader_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="bsheader_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#bsdetail"><?php echo $this->getCatalog("bsdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="bsdetail" class="tab-pane">
	<?php if ($this->checkAccess('bsheader','iswrite')) { ?>
<button name="CreateButtonbsdetail" type="button" class="btn btn-primary" onclick="newdatabsdetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('bsheader','ispurge')) { ?>
<button name="PurgeButtonbsdetail" type="button" class="btn btn-danger" onclick="purgedatabsdetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbsdetail,
		'id'=>'bsdetailList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('bsheader','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatabsdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('bsheader','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatabsdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('bsdetailid'),
					'name'=>'bsdetailid',
					'value'=>'$data["bsdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('ownership'),
					'name'=>'ownershipid',
					'value'=>'$data["ownershipname"]'
				),
							array(
					'header'=>$this->getCatalog('expiredate'),
					'name'=>'expiredate',
					'value'=>'Yii::app()->format->formatDate($data["expiredate"])'
				),
							array(
					'header'=>$this->getCatalog('materialstatus'),
					'name'=>'materialstatusid',
					'value'=>'$data["materialstatusname"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('buyprice'),
					'name'=>'buyprice',
					'value'=>'Yii::app()->format->formatNumber($data["buyprice"])'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
				),
							
		)
));
?>
  </div>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
				<div class="modal-body">
			<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('bsdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbsdetail,
		'id'=>'DetailbsdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('bsdetailid'),
					'name'=>'bsdetailid',
					'value'=>'$data["bsdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('ownership'),
					'name'=>'ownershipid',
					'value'=>'$data["ownershipname"]'
				),
							array(
					'header'=>$this->getCatalog('expiredate'),
					'name'=>'expiredate',
					'value'=>'Yii::app()->format->formatDate($data["expiredate"])'
				),
							array(
					'header'=>$this->getCatalog('materialstatus'),
					'name'=>'materialstatusid',
					'value'=>'$data["materialstatusname"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('buyprice'),
					'name'=>'buyprice',
					'value'=>'Yii::app()->format->formatNumber($data["buyprice"])'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogbsdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('bsdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="bsdetail_1_bsheaderid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_productid','ColField'=>'bsdetail_1_productname',
							'IDDialog'=>'bsdetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'bsdetail_1_productidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_unitofmeasureid','ColField'=>'bsdetail_1_uomcode',
							'IDDialog'=>'bsdetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'bsdetail_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="bsdetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_ownershipid','ColField'=>'bsdetail_1_ownershipname',
							'IDDialog'=>'bsdetail_1_ownershipid_dialog','titledialog'=>$this->getCatalog('ownership'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.OwnershipPopUp','PopGrid'=>'bsdetail_1_ownershipidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_expiredate"><?php echo $this->getCatalog('expiredate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="bsdetail_1_expiredate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_materialstatusid','ColField'=>'bsdetail_1_materialstatusname',
							'IDDialog'=>'bsdetail_1_materialstatusid_dialog','titledialog'=>$this->getCatalog('materialstatus'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialstatusPopUp','PopGrid'=>'bsdetail_1_materialstatusidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_storagebinid','ColField'=>'bsdetail_1_description',
							'IDDialog'=>'bsdetail_1_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'bsdetail_1_storagebinidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_location"><?php echo $this->getCatalog('location')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="bsdetail_1_location">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="bsdetail_1_itemnote">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bsdetail_1_currencyid','ColField'=>'bsdetail_1_currencyname',
							'IDDialog'=>'bsdetail_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'bsdetail_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_buyprice"><?php echo $this->getCatalog('buyprice')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="bsdetail_1_buyprice">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bsdetail_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="bsdetail_1_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatabsdetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			