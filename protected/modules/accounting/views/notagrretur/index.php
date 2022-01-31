<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagrretur_0_notagrreturid']").val(data.notagrreturid);
			$("input[name='notagrretur_0_companyid']").val('');
      $("input[name='notagrretur_0_docdate']").val(data.docdate);
      $("input[name='notagrretur_0_grreturid']").val('');
      $("textarea[name='notagrretur_0_headernote']").val('');
      $("input[name='notagrretur_0_companyname']").val('');
      $("input[name='notagrretur_0_grreturno']").val('');
			$.fn.yiiGridView.update('notagrrproList',{data:{'notagrreturid':data.notagrreturid}});
$.fn.yiiGridView.update('notagrraccList',{data:{'notagrreturid':data.notagrreturid}});

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
function newdatanotagrrpro()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/createnotagrrpro')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagrrpro_1_price']").val(data.price);
      $("input[name='notagrrpro_1_currencyid']").val(data.currencyid);
      $("input[name='notagrrpro_1_currencyrate']").val(data.currencyrate);
      $("input[name='notagrrpro_1_productname']").val('');
      $("input[name='notagrrpro_1_uomcode']").val('');
      $("input[name='notagrrpro_1_sloccode']").val('');
      $("input[name='notagrrpro_1_currencyname']").val('');
			$('#InputDialognotagrrpro').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatanotagrracc()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/createnotagrracc')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			
			$('#InputDialognotagrracc').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='notagrretur_0_notagrreturid']").val(data.notagrreturid);
				$("input[name='notagrretur_0_companyid']").val(data.companyid);
      $("input[name='notagrretur_0_docdate']").val(data.docdate);
      $("input[name='notagrretur_0_grreturid']").val(data.grreturid);
      $("textarea[name='notagrretur_0_headernote']").val(data.headernote);
      $("input[name='notagrretur_0_companyname']").val(data.companyname);
      $("input[name='notagrretur_0_grreturno']").val(data.grreturno);
				$.fn.yiiGridView.update('notagrrproList',{data:{'notagrreturid':data.notagrreturid}});
$.fn.yiiGridView.update('notagrraccList',{data:{'notagrreturid':data.notagrreturid}});

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
function updatedatanotagrrpro($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/updatenotagrrpro')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagrrpro_1_price']").val(data.price);
      $("input[name='notagrrpro_1_currencyid']").val(data.currencyid);
      $("input[name='notagrrpro_1_currencyrate']").val(data.currencyrate);
      $("input[name='notagrrpro_1_productname']").val(data.productname);
      $("input[name='notagrrpro_1_uomcode']").val(data.uomcode);
      $("input[name='notagrrpro_1_sloccode']").val(data.sloccode);
      $("input[name='notagrrpro_1_currencyname']").val(data.currencyname);
			$('#InputDialognotagrrpro').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatanotagrracc($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/updatenotagrracc')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			
			$('#InputDialognotagrracc').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/save')?>',
		'data':{
			'notagrreturid':$("input[name='notagrretur_0_notagrreturid']").val(),
			'companyid':$("input[name='notagrretur_0_companyid']").val(),
      'docdate':$("input[name='notagrretur_0_docdate']").val(),
      'grreturid':$("input[name='notagrretur_0_grreturid']").val(),
      'headernote':$("textarea[name='notagrretur_0_headernote']").val(),
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

function savedatanotagrrpro()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/savenotagrrpro')?>',
		'data':{
			'notagrreturid':$("input[name='notagrretur_0_notagrreturid']").val(),
			'price':$("input[name='notagrrpro_1_price']").val(),
      'currencyid':$("input[name='notagrrpro_1_currencyid']").val(),
      'currencyrate':$("input[name='notagrrpro_1_currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialognotagrrpro').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagrrproList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatanotagrracc()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/savenotagrracc')?>',
		'data':{
			'notagrreturid':$("input[name='notagrretur_0_notagrreturid']").val(),
			
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialognotagrracc').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagrraccList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/purge')?>','data':{'id':$id},
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
function purgedatanotagrrpro()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/purgenotagrrpro')?>','data':{'id':$.fn.yiiGridView.getSelection("notagrrproList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagrrproList");
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
function purgedatanotagrracc()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagrretur/purgenotagrracc')?>','data':{'id':$.fn.yiiGridView.getSelection("notagrraccList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagrraccList");
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
	var array = 'notagrreturid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagrreturno='+$("input[name='dlg_search_notagrreturno']").val()
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'notagrreturid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagrreturno='+$("input[name='dlg_search_notagrreturno']").val()
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/notagrretur/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'notagrreturid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagrreturno='+$("input[name='dlg_search_notagrreturno']").val()
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/notagrretur/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'notagrreturid='+$id
$.fn.yiiGridView.update("DetailnotagrrproList",{data:array});
$.fn.yiiGridView.update("DetailnotagrraccList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('notagrretur') ?></h3>
<?php if ($this->checkAccess('notagrretur','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('notagrretur','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('notagrreturid'),
					'name'=>'notagrreturid',
					'value'=>'$data["notagrreturid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('notagrreturno'),
					'name'=>'notagrreturno',
					'value'=>'$data["notagrreturno"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('grreturno'),
					'name'=>'grreturid',
					'value'=>'$data["grreturno"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_notagrreturno"><?php echo $this->getCatalog('notagrreturno')?></label>
						<input type="text" class="form-control" name="dlg_search_notagrreturno">
					</div>
          <div class="form-group">
						<label for="dlg_search_grreturno"><?php echo $this->getCatalog('grreturno')?></label>
						<input type="text" class="form-control" name="dlg_search_grreturno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrretur') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="notagrretur_0_notagrreturid">
        <div class="row">
						<div class="col-md-4">
							<label for="notagrretur_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="notagrretur_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagrretur_0_grreturid','ColField'=>'notagrretur_0_grreturno',
							'IDDialog'=>'notagrretur_0_grreturid_dialog','titledialog'=>$this->getCatalog('grreturno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GrreturPopUp','PopGrid'=>'notagrretur_0_grreturidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagrretur_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="notagrretur_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#notagrrpro"><?php echo $this->getCatalog("notagrrpro")?></a></li>
<li><a data-toggle="tab" href="#notagrracc"><?php echo $this->getCatalog("notagrracc")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="notagrrpro" class="tab-pane">
	<?php if ($this->checkAccess('notagrretur','iswrite')) { ?>
<button name="CreateButtonnotagrrpro" type="button" class="btn btn-primary" onclick="newdatanotagrrpro()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispurge')) { ?>
<button name="PurgeButtonnotagrrpro" type="button" class="btn btn-danger" onclick="purgedatanotagrrpro()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrrpro,
		'id'=>'notagrrproList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagrrpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagrrpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagrrproid'),
					'name'=>'notagrrproid',
					'value'=>'$data["notagrrproid"]'
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
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
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
<div id="notagrracc" class="tab-pane">
	<?php if ($this->checkAccess('notagrretur','iswrite')) { ?>
<button name="CreateButtonnotagrracc" type="button" class="btn btn-primary" onclick="newdatanotagrracc()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagrretur','ispurge')) { ?>
<button name="PurgeButtonnotagrracc" type="button" class="btn btn-danger" onclick="purgedatanotagrracc()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrracc,
		'id'=>'notagrraccList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagrracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagrretur','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagrracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagrraccid'),
					'name'=>'notagrraccid',
					'value'=>'$data["notagrraccid"]'
				),
							array(
					'header'=>$this->getCatalog('accountid'),
					'name'=>'accountid',
					'value'=>'$data["accountid"]'
				),
							array(
					'header'=>$this->getCatalog('debet'),
					'name'=>'debet',
					'value'=>'Yii::app()->format->formatNumber($data["debet"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currencyid'),
					'name'=>'currencyid',
					'value'=>'$data["currencyid"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('notagrrpro')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrrpro,
		'id'=>'DetailnotagrrproList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagrrproid'),
					'name'=>'notagrrproid',
					'value'=>'$data["notagrrproid"]'
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
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatNumber($data["price"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
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
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('notagrracc')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagrracc,
		'id'=>'DetailnotagrraccList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagrraccid'),
					'name'=>'notagrraccid',
					'value'=>'$data["notagrraccid"]'
				),
							array(
					'header'=>$this->getCatalog('accountid'),
					'name'=>'accountid',
					'value'=>'$data["accountid"]'
				),
							array(
					'header'=>$this->getCatalog('debet'),
					'name'=>'debet',
					'value'=>'Yii::app()->format->formatNumber($data["debet"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currencyid'),
					'name'=>'currencyid',
					'value'=>'$data["currencyid"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
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
			
<div id="InputDialognotagrrpro" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrrpro') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="notagrrpro_1_price">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagrrpro_1_currencyid','ColField'=>'notagrrpro_1_currencyname',
							'IDDialog'=>'notagrrpro_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'notagrrpro_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagrrpro_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="notagrrpro_1_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagrrpro()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialognotagrracc" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagrracc') ?></h4>
      </div>
			<div class="modal-body">
			
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagrracc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			