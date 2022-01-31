<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='giretur_0_gireturid']").val(data.gireturid);
			$("input[name='giretur_0_gireturdate']").val(data.gireturdate);
     $("input[name='giretur_0_giheaderid']").val('');
      $("textarea[name='giretur_0_headernote']").val('');
      $("input[name='giretur_0_gino']").val('');
			$.fn.yiiGridView.update('gireturdetailList',{data:{'gireturid':data.gireturid}});

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
function newdatagireturdetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/creategireturdetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gireturdetail_1_productid']").val('');
      $("input[name='gireturdetail_1_qty']").val(data.qty);
      $("input[name='gireturdetail_1_uomid']").val('');
      $("input[name='gireturdetail_1_slocid']").val('');
      $("input[name='gireturdetail_1_storagebinid']").val('');
      $("textarea[name='gireturdetail_1_itemnote']").val('');
      $("input[name='gireturdetail_1_productname']").val('');
      $("input[name='gireturdetail_1_uomcode']").val('');
      $("input[name='gireturdetail_1_sloccode']").val('');
      $("input[name='gireturdetail_1_description']").val('');
			$('#InputDialoggireturdetail').modal();
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

'productid':$("input[name='gireturdetail_1_productid']").val(),

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
		'url': 'giretur/getdatagiretur',
		'data': {'gireturid':$("input[name='giretur_0_gireturid']").val()},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='fullname']").val(data.fullname);
				$("input[name='gino']").val(data.gino);
				$("input[name='gireturdate']").val(data.gireturdate);
				$("input[name='headernote']").val(data.taxid);
				
                $.fn.yiiGridView.update('gidetailList',{data:{'giheaderid':data.giheaderid}});
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

 function check_gireturdetail(){
    jQuery.ajax({'url':'inventory/giretur/checkgiretur',
		'data':{
			'gireturid':$("input[name='giretur_0_gireturid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
    $("input[name='giretur_0_gireturid']").val(data.gireturid);
    $("input[name='giretur_0_gireturdate']").val(data.gireturdate);
    $("input[name='giretur_0_giheaderid']").val(data.giheaderid);
    $("textarea[name='giretur_0_headernote']").val(data.headernote);
    $("input[name='giretur_0_gino']").val(data.gino);
    $.fn.yiiGridView.update('gireturdetailList',{data:{'gireturid':data.gireturid}});

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
function updatedatagireturdetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/updategireturdetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gireturdetail_1_productid']").val(data.productid);
      $("input[name='gireturdetail_1_qty']").val(data.qty);
      $("input[name='gireturdetail_1_uomid']").val(data.uomid);
      $("input[name='gireturdetail_1_slocid']").val(data.slocid);
      $("input[name='gireturdetail_1_storagebinid']").val(data.storagebinid);
      $("textarea[name='gireturdetail_1_itemnote']").val(data.itemnote);
      $("input[name='gireturdetail_1_productname']").val(data.productname);
      $("input[name='gireturdetail_1_uomcode']").val(data.uomcode);
      $("input[name='gireturdetail_1_sloccode']").val(data.sloccode);
      $("input[name='gireturdetail_1_description']").val(data.description);
			$('#InputDialoggireturdetail').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/save')?>',
		'data':{
			'gireturid':$("input[name='giretur_0_gireturid']").val(),
			'gireturdate':$("input[name='giretur_0_gireturdate']").val(),
            'giheaderid':$("input[name='giretur_0_giheaderid']").val(),
      'headernote':$("textarea[name='giretur_0_headernote']").val(),
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

function savedatagireturdetail()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/savegireturdetail')?>',
		'data':{
'gireturid':$("input[name='giretur_0_gireturid']").val(),
'productid':$("input[name='gireturdetail_1_productid']").val(),
'qty':$("input[name='gireturdetail_1_qty']").val(),
'uomid':$("input[name='gireturdetail_1_uomid']").val(),
'slocid':$("input[name='gireturdetail_1_slocid']").val(),
'storagebinid':$("input[name='gireturdetail_1_storagebinid']").val(),     'itemnote':$("textarea[name='gireturdetail_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoggireturdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("gireturdetailList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/purge')?>','data':{'id':$id},
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
function purgedatagireturdetail()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/giretur/purgegireturdetail')?>','data':{'id':$.fn.yiiGridView.getSelection("gireturdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("gireturdetailList");
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
	var array = 'gireturid='+$id
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'gireturid='+$id
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/giretur/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'gireturid='+$id
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/giretur/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'gireturid='+$id
$.fn.yiiGridView.update("DetailgireturdetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('giretur') ?></h3>
<?php if ($this->checkAccess('giretur','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('giretur','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('giretur','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('giretur','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('giretur','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('giretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('giretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('giretur','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('gireturid'),
					'name'=>'gireturid',
					'value'=>'$data["gireturid"]'
				),
											array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('gireturno'),
					'name'=>'gireturno',
					'value'=>'$data["gireturno"]'
				),
							array(
					'header'=>$this->getCatalog('gino'),
					'name'=>'giheaderid',
					'value'=>'$data["gino"]'
				),
							array(
					'header'=>$this->getCatalog('gireturdate'),
					'name'=>'gireturdate',
					'value'=>'Yii::app()->format->formatDate($data["gireturdate"])'
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
						<label for="dlg_search_gireturno"><?php echo $this->getCatalog('gireturno')?></label>
						<input type="text" class="form-control" name="dlg_search_gireturno">
					</div>
          <div class="form-group">
						<label for="dlg_search_gino"><?php echo $this->getCatalog('gino')?></label>
						<input type="text" class="form-control" name="dlg_search_gino">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('giretur') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="giretur_0_gireturid">
        <div class="row">
            <div class="col-md-4">
							<label for="giretur_0_gireturdate"><?php echo $this->getCatalog('gireturdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="giretur_0_gireturdate">
                             </div>
					</div>
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'giretur_0_giheaderid','ColField'=>'giretur_0_gino',
							'IDDialog'=>'giretur_0_giheaderid_dialog','titledialog'=>$this->getCatalog('gino'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GiheaderreturPopUp','PopGrid'=>'giretur_0_giheaderidgrid',
                             'onaftersign'=>'getalldata()')); 
					?>
           <div class="row">
						<div class="col-md-4">
							<label for="giretur_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="giretur_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#gireturdetail"><?php echo $this->getCatalog("gireturdetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="gireturdetail" class="tab-pane">
	<?php if ($this->checkAccess('giretur','iswrite')) { ?>
<!--<button name="CreateButtongireturdetail" type="button" class="btn btn-primary" onclick="newdatagireturdetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('giretur','ispurge')) { ?>
<button name="PurgeButtongireturdetail" type="button" class="btn btn-danger" onclick="purgedatagireturdetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidergireturdetail,
		'id'=>'gireturdetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('giretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatagireturdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('giretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatagireturdetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('gireturdetailid'),
					'name'=>'gireturdetailid',
					'value'=>'$data["gireturdetailid"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('gireturdetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidergireturdetail,
		'id'=>'DetailgireturdetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('gireturdetailid'),
					'name'=>'gireturdetailid',
					'value'=>'$data["gireturdetailid"]'
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
			
<div id="InputDialoggireturdetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('gireturdetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="gireturdetail_1_productid">
        
             <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'gireturdetail_1_productid','ColField'=>'gireturdetail_1_productname',
							'IDDialog'=>'gireturdetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'gireturdetail_1_productidgrid',
                             'onaftersign'=>'getproductdata();')); 
					?>
                <div class="row">
						<div class="col-md-4">
							<label for="gireturdetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="gireturdetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'gireturdetail_1_uomid','ColField'=>'gireturdetail_1_uomcode',
							'IDDialog'=>'gireturdetail_1_uomid_dialog','titledialog'=>$this->getCatalog('uom'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'gireturdetail_1_uomidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'gireturdetail_1_slocid','ColField'=>'gireturdetail_1_sloccode',
							'IDDialog'=>'gireturdetail_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'gireturdetail_1_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'gireturdetail_1_storagebinid','ColField'=>'gireturdetail_1_description',
							'IDDialog'=>'gireturdetail_1_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'gireturdetail_1_storagebinidgrid',
                             'RelationID'=>'gireturdetail_1_slocid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="gireturdetail_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="gireturdetail_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatagireturdetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			