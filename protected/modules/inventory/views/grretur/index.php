<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grretur_0_grreturid']").val(data.grreturid);
			$("input[name='grretur_0_grreturdate']").val(data.grreturdate);
      $("input[name='grretur_0_poheaderid']").val('');
      $("textarea[name='grretur_0_headernote']").val('');
      $("input[name='grretur_0_pono']").val('');
			$.fn.yiiGridView.update('grreturdetailList',{data:{'grreturid':data.grreturid}});

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
function newdatagrreturdetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/creategrreturdetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grreturdetail_1_productid']").val('');
      $("input[name='grreturdetail_1_qty']").val(data.qty);
      $("input[name='grreturdetail_1_uomid']").val('');
      $("input[name='grreturdetail_1_slocid']").val('');
      $("input[name='grreturdetail_1_storagebinid']").val('');
      $("textarea[name='grreturdetail_1_itemnote']").val('');
      $("input[name='grreturdetail_1_productname']").val('');
      $("input[name='grreturdetail_1_uomcode']").val('');
      $("input[name='grreturdetail_1_sloccode']").val('');
      $("input[name='grreturdetail_1_description']").val('');
			$('#InputDialoggrreturdetail').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {

'productid':$("input[name='grreturdetail_1_productid']").val(),

        },
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='unitofmeasureid']").val(data.uomid);
				$("input[name='uomcode']").val(data.uomcode);
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
function getalldata(){
    jQuery.ajax({
		'url': 'grretur/getdatagrretur',
		'data': {'grreturid':$("input[name='grretur_0_grreturid']").val()},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='fullname']").val(data.fullname);
				$("input[name='pono']").val(data.pono);
				$("input[name='grreturdate']").val(data.grreturdate);
				$("input[name='headernote']").val(data.taxid);
				
                $.fn.yiiGridView.update('grdetailList',{data:{'grheaderid':data.grheaderid}});
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

    function check_grreturdetail(){
    jQuery.ajax({'url':'inventory/grretur/checkgrretur',
		'data':{
			'grreturid':$("input[name='grretur_0_grreturid']").val(),
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
    
function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
$("input[name='grretur_0_grreturid']").val(data.grreturid);
$("input[name='grretur_0_grreturdate']").val(data.grreturdate);
$("input[name='grretur_0_poheaderid']").val(data.poheaderid);
$("textarea[name='grretur_0_headernote']").val(data.headernote);
$("input[name='grretur_0_pono']").val(data.pono);
$.fn.yiiGridView.update('grreturdetailList',{data:{'grreturid':data.grreturid}});

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
function updatedatagrreturdetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/updategrreturdetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grreturdetail_1_productid']").val(data.productid);
      $("input[name='grreturdetail_1_qty']").val(data.qty);
      $("input[name='grreturdetail_1_uomid']").val(data.uomid);
      $("input[name='grreturdetail_1_slocid']").val(data.slocid);
      $("input[name='grreturdetail_1_storagebinid']").val(data.storagebinid);
      $("textarea[name='grreturdetail_1_itemnote']").val(data.itemnote);
      $("input[name='grreturdetail_1_productname']").val(data.productname);
      $("input[name='grreturdetail_1_uomcode']").val(data.uomcode);
      $("input[name='grreturdetail_1_sloccode']").val(data.sloccode);
      $("input[name='grreturdetail_1_description']").val(data.description);
			$('#InputDialoggrreturdetail').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/save')?>',
		'data':{
			'grreturid':$("input[name='grretur_0_grreturid']").val(),
			'grreturdate':$("input[name='grretur_0_grreturdate']").val(),
      'poheaderid':$("input[name='grretur_0_poheaderid']").val(),
      'headernote':$("textarea[name='grretur_0_headernote']").val(),
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

function savedatagrreturdetail()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/savegrreturdetail')?>',
		'data':{
'grreturid':$("input[name='grretur_0_grreturid']").val(),
'productid':$("input[name='grreturdetail_1_productid']").val(),
'qty':$("input[name='grreturdetail_1_qty']").val(),
'uomid':$("input[name='grreturdetail_1_uomid']").val(),
'slocid':$("input[name='grreturdetail_1_slocid']").val(),
'storagebinid':$("input[name='grreturdetail_1_storagebinid']").val(),
      'itemnote':$("textarea[name='grreturdetail_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoggrreturdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("grreturdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/approve')?>',
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
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/purge')?>','data':{'id':$id},
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
function purgedatagrreturdetail()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grretur/purgegrreturdetail')?>','data':{'id':$.fn.yiiGridView.getSelection("grreturdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("grreturdetailList");
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
	var array = 'grreturid='+$id
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'grreturid='+$id
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/grretur/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'grreturid='+$id
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/grretur/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'grreturid='+$id
$.fn.yiiGridView.update("DetailgrreturdetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('grretur') ?></h3>
<?php if ($this->checkAccess('grretur','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('grretur','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('grretur','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('grretur','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('grretur','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('grretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('grretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('grretur','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('grreturid'),
					'name'=>'grreturid',
					'value'=>'$data["grreturid"]'
				),
							array(
					'header'=>$this->getCatalog('grreturno'),
					'name'=>'grreturno',
					'value'=>'$data["grreturno"]'
				),
							array(
					'header'=>$this->getCatalog('grreturdate'),
					'name'=>'grreturdate',
					'value'=>'Yii::app()->format->formatDate($data["grreturdate"])'
				),
							array(
					'header'=>$this->getCatalog('pono'),
					'name'=>'poheaderid',
					'value'=>'$data["pono"]'
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
						<label for="dlg_search_grreturno"><?php echo $this->getCatalog('grreturno')?></label>
						<input type="text" class="form-control" name="dlg_search_grreturno">
					</div>
          <div class="form-group">
						<label for="dlg_search_pono"><?php echo $this->getCatalog('pono')?></label>
						<input type="text" class="form-control" name="dlg_search_pono">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('grretur') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="grretur_0_grreturid">
          <div class="row">
						<div class="col-md-4">
							<label for="grretur_0_grreturdate"><?php echo $this->getCatalog('grreturdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="grretur_0_grreturdate">
					
          </div>
					</div>
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'grretur_0_poheaderid','ColField'=>'grretur_0_pono',
							'IDDialog'=>'grretur_0_poheaderid_dialog','titledialog'=>$this->getCatalog('pono'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.PurchasingPopUp','PopGrid'=>'grretur_0_poheaderidgrid',
                             'onaftersign'=>'getalldata()')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="grretur_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="grretur_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#grreturdetail"><?php echo $this->getCatalog("grreturdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="grreturdetail" class="tab-pane">
	<?php if ($this->checkAccess('grretur','iswrite')) { ?>
<!--<button name="CreateButtongrreturdetail" type="button" class="btn btn-primary" onclick="newdatagrreturdetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('grretur','ispurge')) { ?>
<button name="PurgeButtongrreturdetail" type="button" class="btn btn-danger" onclick="purgedatagrreturdetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidergrreturdetail,
		'id'=>'grreturdetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('grretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatagrreturdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('grretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatagrreturdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('grreturdetailid'),
					'name'=>'grreturdetailid',
					'value'=>'$data["grreturdetailid"]'
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
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('grreturdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidergrreturdetail,
		'id'=>'DetailgrreturdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('grreturdetailid'),
					'name'=>'grreturdetailid',
					'value'=>'$data["grreturdetailid"]'
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
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
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
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialoggrreturdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('grreturdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="grreturdetail_1_productid">
                <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'grreturdetail_1_productid','ColField'=>'grreturdetail_1_productname',
							'IDDialog'=>'grreturdetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'grreturdetail_1_productidgrid',
                             'onaftersign'=>'getproductdata();')); 
					?>
        <div class="row">
						<div class="col-md-4">
							<label for="grreturdetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="grreturdetail_1_qty">
						</div>
					</div>
                
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'grreturdetail_1_uomid','ColField'=>'grreturdetail_1_uomcode',
							'IDDialog'=>'grreturdetail_1_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'grreturdetail_1_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'grreturdetail_1_slocid','ColField'=>'grreturdetail_1_sloccode',
							'IDDialog'=>'grreturdetail_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'grreturdetail_1_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'grreturdetail_1_storagebinid','ColField'=>'grreturdetail_1_description',
							'IDDialog'=>'grreturdetail_1_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'grreturdetail_1_storagebinidgrid',
                             'RelationID'=>'grreturdetail_1_slocid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="grreturdetail_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="grreturdetail_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatagrreturdetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			