<script src="<?php echo Yii::app()->baseUrl;?>/js/billofmaterial.js"></script>
<script>
function running(id,param2)
{
	jQuery.ajax({'url':'bom/running',
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
<h3><?php echo $this->getCatalog('bom') ?></h3>
<?php if ($this->checkAccess('bom','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('production/bom/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('bom','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('bom','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('bom','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('bom','isdownload')) { ?>
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
				'template'=>'{select} {edit} {copy} {purge} {pdf}',
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
							'visible'=>$this->booltostr($this->checkAccess('bom','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'copy' => array
					(
							'label'=>$this->getCatalog('copy'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/copy.png',
							'visible'=>$this->booltostr($this->checkAccess('bom','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								copybom($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('bom','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('bom','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('bomid'),
					'name'=>'bomid',
					'value'=>'$data["bomid"]'
				),
							array(
					'header'=>$this->getCatalog('bomversion'),
					'name'=>'bomversion',
					'value'=>'$data["bomversion"]'
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
					'header'=>$this->getCatalog('bomdate'),
					'name'=>'bomdate',
					'value'=>'Yii::app()->format->formatDate($data["bomdate"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
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
						<label for="dlg_search_bomversion"><?php echo $this->getCatalog('bomversion')?></label>
						<input type="text" class="form-control" name="dlg_search_bomversion">
					</div>
          <div class="form-group">
						<label for="dlg_search_productheader"><?php echo $this->getCatalog('productheader')?></label>
						<input type="text" class="form-control" name="dlg_search_productheader">
					</div>
          <div class="form-group">
						<label for="dlg_search_productdetail"><?php echo $this->getCatalog('productdetail')?></label>
						<input type="text" class="form-control" name="dlg_search_productdetail">
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
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('bom') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="billofmaterial_0_bomid">
        <div class="row">
						<div class="col-md-4">
							<label for="billofmaterial_0_bomversion"><?php echo $this->getCatalog('bomversion')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="billofmaterial_0_bomversion">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'billofmaterial_0_productid','ColField'=>'billofmaterial_0_productname',
							'IDDialog'=>'billofmaterial_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'billofmaterial_0_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="billofmaterial_0_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="billofmaterial_0_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'billofmaterial_0_uomid','ColField'=>'billofmaterial_0_uomcode',
							'IDDialog'=>'billofmaterial_0_uomid_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'billofmaterial_0_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'billofmaterial_0_uomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="billofmaterial_0_bomdate"><?php echo $this->getCatalog('bomdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="billofmaterial_0_bomdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="billofmaterial_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="billofmaterial_0_description"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="billofmaterial_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="billofmaterial_0_recordstatus">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#bomdetail"><?php echo $this->getCatalog("bomdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="bomdetail" class="tab-pane">
	<?php if ($this->checkAccess('bom','iswrite')) { ?>
<button name="CreateButtonbomdetail" type="button" class="btn btn-primary" onclick="newdatabomdetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('bom','ispurge')) { ?>
<button name="PurgeButtonbomdetail" type="button" class="btn btn-danger" onclick="purgedatabomdetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbomdetail,
		'id'=>'bomdetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('bom','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatabomdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('bom','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatabomdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('bomdetailid'),
					'name'=>'bomdetailid',
					'value'=>'$data["bomdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('productbom'),
					'name'=>'productbomid',
					'value'=>'$data["bomversion"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('bomdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderbomdetail,
		'id'=>'DetailbomdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('bomdetailid'),
					'name'=>'bomdetailid',
					'value'=>'$data["bomdetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('productbom'),
					'name'=>'productbomid',
					'value'=>'$data["bomversion"]'
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
			
<div id="InputDialogbomdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('bomdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="bomdetail_1_bomdetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bomdetail_1_productid','ColField'=>'bomdetail_1_productname',
							'IDDialog'=>'bomdetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'bomdetail_1_productidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bomdetail_1_productbomid','ColField'=>'bomdetail_1_bomversion',
							'IDDialog'=>'bomdetail_1_productbomid_dialog','titledialog'=>$this->getCatalog('productbom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'bomdetail_1_productid',
							'PopUpName'=>'production.components.views.ProductbomPopUp','PopGrid'=>'bomdetail_1_productbomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bomdetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="bomdetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'bomdetail_1_uomid','ColField'=>'bomdetail_1_uomcode',
							'IDDialog'=>'bomdetail_1_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'bomdetail_1_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'bomdetail_1_uomidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="bomdetail_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="bomdetail_1_description"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatabomdetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			