<script type="text/javascript">
function running(id,param2)
{
	jQuery.ajax({'url':'mrp/running',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/mrp/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='mrp_0_mrpid']").val(data.mrpid);
			$("input[name='mrp_0_productid']").val('');
      $("input[name='mrp_0_uomid']").val('');
      $("input[name='mrp_0_slocid']").val('');
      $("input[name='mrp_0_minstock']").val(data.minstock);
      $("input[name='mrp_0_reordervalue']").val(data.reordervalue);
      $("input[name='mrp_0_maxvalue']").val(data.maxvalue);
      $("input[name='mrp_0_leadtime']").val('');
      $("input[name='mrp_0_recordstatus']").prop('checked',true);
      $("input[name='mrp_0_productname']").val('');
      $("input[name='mrp_0_uomcode']").val('');
      $("input[name='mrp_0_sloccode']").val('');
			
			$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/mrp/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='mrp_0_mrpid']").val(data.mrpid);
				$("input[name='mrp_0_productid']").val(data.productid);
      $("input[name='mrp_0_uomid']").val(data.uomid);
      $("input[name='mrp_0_slocid']").val(data.slocid);
      $("input[name='mrp_0_minstock']").val(data.minstock);
      $("input[name='mrp_0_reordervalue']").val(data.reordervalue);
      $("input[name='mrp_0_maxvalue']").val(data.maxvalue);
      $("input[name='mrp_0_leadtime']").val(data.leadtime);
      if (data.recordstatus == 1)
			{
				$("input[name='mrp_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='mrp_0_recordstatus']").prop('checked',false)
			}
      $("input[name='mrp_0_productname']").val(data.productname);
      $("input[name='mrp_0_uomcode']").val(data.uomcode);
      $("input[name='mrp_0_sloccode']").val(data.sloccode);
				
				$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function savedata()
{
var recordstatus = 0;
	if ($("input[name='mrp_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/mrp/save')?>',
		'data':{
			'mrpid':$("input[name='mrp_0_mrpid']").val(),
			'productid':$("input[name='mrp_0_productid']").val(),
      'uomid':$("input[name='mrp_0_uomid']").val(),
      'slocid':$("input[name='mrp_0_slocid']").val(),
      'minstock':$("input[name='mrp_0_minstock']").val(),
      'reordervalue':$("input[name='mrp_0_reordervalue']").val(),
      'maxvalue':$("input[name='mrp_0_maxvalue']").val(),
      'leadtime':$("input[name='mrp_0_leadtime']").val(),
      'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}


function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/mrp/delete')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/mrp/purge')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	});
	return false;
}

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'mrpid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'mrpid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/mrp/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'mrpid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/mrp/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'mrpid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('mrp') ?></h3>
<?php if ($this->checkAccess('mrp','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('inventory/mrp/uploaddata'),
    'mimeTypes' => array('.xlsx'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('mrp','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('mrp','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrp','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('mrp','isdownload')) { ?>
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
				'template'=>'{edit} {delete} {purge} {pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('mrp','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('mrp','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('mrp','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('mrp','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('mrp','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('mrpid'),
					'name'=>'mrpid',
					'value'=>'$data["mrpid"]'
				),
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
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
							array(
					'header'=>$this->getCatalog('minstock'),
					'name'=>'minstock',
					'value'=>'Yii::app()->format->formatNumber($data["minstock"])'
				),
							array(
					'header'=>$this->getCatalog('reordervalue'),
					'name'=>'reordervalue',
					'value'=>'Yii::app()->format->formatNumber($data["reordervalue"])'
				),
							array(
					'header'=>$this->getCatalog('maxvalue'),
					'name'=>'maxvalue',
					'value'=>'Yii::app()->format->formatNumber($data["maxvalue"])'
				),
							array(
					'header'=>$this->getCatalog('leadtime'),
					'name'=>'leadtime',
					'value'=>'$data["leadtime"]'
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
        <h4 class="modal-title"><?php echo $this->getCatalog('mrp') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="mrp_0_mrpid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrp_0_productid','ColField'=>'mrp_0_productname',
							'IDDialog'=>'mrp_0_productid_dialog','titledialog'=>$this->getCatalog('productname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'mrp_0_productidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrp_0_uomid','ColField'=>'mrp_0_uomcode',
							'IDDialog'=>'mrp_0_uomid_dialog','titledialog'=>$this->getCatalog('uomcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'mrp_0_productid',
							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'mrp_0_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrp_0_slocid','ColField'=>'mrp_0_sloccode',
							'IDDialog'=>'mrp_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'mrp_0_slocidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrp_0_minstock"><?php echo $this->getCatalog('minstock')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrp_0_minstock">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrp_0_reordervalue"><?php echo $this->getCatalog('reordervalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrp_0_reordervalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrp_0_maxvalue"><?php echo $this->getCatalog('maxvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrp_0_maxvalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrp_0_leadtime"><?php echo $this->getCatalog('leadtime')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrp_0_leadtime">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrp_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="mrp_0_recordstatus">
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


