<script src="<?php echo Yii::app()->baseUrl;?>/js/productoutput.js"></script>
<script type="text/javascript">
function generatepp() {
	jQuery.ajax({
			'url': '<?php echo Yii::app()->createUrl('production/productoutput/generatepp')?>',
			'data': {
				'id':$("input[name='productoutput_0_productplanid']").val(),
				'hid':$("input[name='productoutput_0_productoutputid']").val(),
			},
			'type': 'post',
			'dataType': 'json',
			'success': function(data) {
			if (data.status == "success")
			{
				$.fn.yiiGridView.update('productoutputfgList',{data:{'productoutputid':data.productplanid}});
				$.fn.yiiGridView.update('productoutputdetailList',{data:{'productoutputid':data.productplanid}});
				toastr.info(data.div);
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
<h3><?php echo $this->getCatalog('productoutput') ?></h3>
<?php if ($this->checkAccess('productoutput','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productoutput','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('productoutput','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('productoutput','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('productoutput','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
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
				'template'=>'{select} {edit} {purge} {pdf}',
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
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('productoutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('productoutput','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('productoutputid'),
					'name'=>'productoutputid',
					'value'=>'$data["productoutputid"]'
				),
array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('productoutputno'),
					'name'=>'productoutputno',
					'value'=>'$data["productoutputno"]'
				),
							array(
					'header'=>$this->getCatalog('productoutputdate'),
					'name'=>'productoutputdate',
					'value'=>'Yii::app()->format->formatDate($data["productoutputdate"])'
				),
							array(
					'header'=>$this->getCatalog('productplanno'),
					'name'=>'productplanid',
					'value'=>'$data["productplanno"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
					<div class="form-group">
						<label for="dlg_search_productoutputno"><?php echo $this->getCatalog('productoutputno')?></label>
						<input type="text" class="form-control" name="dlg_search_productoutputno">
					</div>
          <div class="form-group">
						<label for="dlg_search_productplanno"><?php echo $this->getCatalog('productplanno')?></label>
						<input type="text" class="form-control" name="dlg_search_productplanno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('productoutput') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="productoutput_0_productoutputid">
        <div class="row">
						<div class="col-md-4">
							<label for="productoutput_0_productoutputdate"><?php echo $this->getCatalog('productoutputdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productoutput_0_productoutputdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutput_0_productplanid','ColField'=>'productoutput_0_productplanno',
							'IDDialog'=>'productoutput_0_productplanid_dialog','titledialog'=>$this->getCatalog('productplanno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'production.components.views.ProdplanPopUp','PopGrid'=>'productoutput_0_productplanidgrid',
							'onaftersign'=>'generatepp();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutput_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productoutput_0_description"></textarea>
						</div>
					</div>
							<input type="hidden" class="form-control" name="productoutput_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#productoutputfg"><?php echo $this->getCatalog("productoutputfg")?></a></li>
<li><a data-toggle="tab" href="#productoutputdetail"><?php echo $this->getCatalog("productoutputdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="productoutputfg" class="tab-pane">
	<?php if ($this->checkAccess('productoutput','iswrite')) { ?>
<button name="CreateButtonproductoutputfg" type="button" class="btn btn-primary" onclick="newdataproductoutputfg()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productoutput','ispurge')) { ?>
<button name="PurgeButtonproductoutputfg" type="button" class="btn btn-danger" onclick="purgedataproductoutputfg()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductoutputfg,
		'id'=>'productoutputfgList',
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
							'visible'=>$this->booltostr($this->checkAccess('productoutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataproductoutputfg($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataproductoutputfg($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('productoutputfgid'),
					'name'=>'productoutputfgid',
					'value'=>'$data["productoutputfgid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qtyoutput'),
					'name'=>'qtyoutput',
					'value'=>'Yii::app()->format->formatNumber($data["qtyoutput"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["storagedesc"]'
				),
							array(
					'header'=>$this->getCatalog('outputdate'),
					'name'=>'outputdate',
					'value'=>'Yii::app()->format->formatDate($data["outputdate"])'
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
<div id="productoutputdetail" class="tab-pane">
	<?php if ($this->checkAccess('productoutput','iswrite')) { ?>
<button name="CreateButtonproductoutputdetail" type="button" class="btn btn-primary" onclick="newdataproductoutputdetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productoutput','ispurge')) { ?>
<button name="PurgeButtonproductoutputdetail" type="button" class="btn btn-danger" onclick="purgedataproductoutputdetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductoutputdetail,
		'id'=>'productoutputdetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('productoutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataproductoutputdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('productoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataproductoutputdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('productoutputdetailid'),
					'name'=>'productoutputdetailid',
					'value'=>'$data["productoutputdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('tosloc'),
					'name'=>'toslocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["storagedesc"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('productoutputfg')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductoutputfg,
		'id'=>'DetailproductoutputfgList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('productoutputfgid'),
					'name'=>'productoutputfgid',
					'value'=>'$data["productoutputfgid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qtyoutput'),
					'name'=>'qtyoutput',
					'value'=>'Yii::app()->format->formatNumber($data["qtyoutput"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["storagedesc"]'
				),
							array(
					'header'=>$this->getCatalog('outputdate'),
					'name'=>'outputdate',
					'value'=>'Yii::app()->format->formatDate($data["outputdate"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('productoutputdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductoutputdetail,
		'id'=>'DetailproductoutputdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('productoutputdetailid'),
					'name'=>'productoutputdetailid',
					'value'=>'$data["productoutputdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('tosloc'),
					'name'=>'toslocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["storagedesc"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogproductoutputfg" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('productoutputfg') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="productoutputfg_1_productoutputfgid">
			<input type="hidden" class="form-control" name="productoutputfg_1_productplanfgid">
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputfg_1_productid','ColField'=>'productoutputfg_1_productname',
							'IDDialog'=>'productoutputfg_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productoutputfg_1_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutputfg_1_qtyoutput"><?php echo $this->getCatalog('qtyoutput')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productoutputfg_1_qtyoutput">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputfg_1_uomid','ColField'=>'productoutputfg_1_uomcode',
							'IDDialog'=>'productoutputfg_1_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'productoutputfg_1_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'productoutputfg_1_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputfg_1_slocid','ColField'=>'productoutputfg_1_sloccode',
							'IDDialog'=>'productoutputfg_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productoutputfg_1_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputfg_1_storagebinid','ColField'=>'productoutputfg_1_storagedesc',
							'IDDialog'=>'productoutputfg_1_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'productoutputfg_1_slocid',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'productoutputfg_1_storagebinidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutputfg_1_outputdate"><?php echo $this->getCatalog('outputdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="productoutputfg_1_outputdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutputfg_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productoutputfg_1_description"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductoutputfg()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogproductoutputdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('productoutputdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="productoutputdetail_2_productoutputdetailid">
			<input type="hidden" class="form-control" name="productoutputdetail_2_productoutputfgid">
			<input type="hidden" class="form-control" name="productoutputdetail_2_productplandetailid">
			<input type="hidden" class="form-control" name="productoutputdetail_2_productplanfgid">
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputdetail_2_productid','ColField'=>'productoutputdetail_2_productname',
							'IDDialog'=>'productoutputdetail_2_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'productoutputdetail_2_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutputdetail_2_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="productoutputdetail_2_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputdetail_2_uomid','ColField'=>'productoutputdetail_2_uomcode',
							'IDDialog'=>'productoutputdetail_2_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'productoutputdetail_2_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'productoutputdetail_2_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputdetail_2_toslocid','ColField'=>'productoutputdetail_2_sloccode',
							'IDDialog'=>'productoutputdetail_2_toslocid_dialog','titledialog'=>$this->getCatalog('tosloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'productoutputdetail_2_toslocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'productoutputdetail_2_storagebinid','ColField'=>'productoutputdetail_2_storagedesc',
							'IDDialog'=>'productoutputdetail_2_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'productoutputdetail_2_toslocid',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'productoutputdetail_2_storagebinidgrid')); 
					?>
							
							
        <div class="row">
						<div class="col-md-4">
							<label for="productoutputdetail_2_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="productoutputdetail_2_description"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductoutputdetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			