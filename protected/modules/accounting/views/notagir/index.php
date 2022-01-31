<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagir_0_notagirid']").val(data.notagirid);
			$("input[name='notagir_0_companyid']").val('');
      $("input[name='notagir_0_docdate']").val(data.docdate);
      $("input[name='notagir_0_gireturid']").val('');
      $("textarea[name='notagir_0_headernote']").val('');
      $("input[name='notagir_0_companyname']").val('');
      $("input[name='notagir_0_gireturno']").val('');
			$.fn.yiiGridView.update('notagirproList',{data:{'notagirid':data.notagirid}});
$.fn.yiiGridView.update('notagiraccList',{data:{'notagirid':data.notagirid}});

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
function newdatanotagirpro()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/createnotagirpro')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagirpro_1_price']").val(data.price);
      $("input[name='notagirpro_1_currencyid']").val(data.currencyid);
      $("input[name='notagirpro_1_currencyrate']").val(data.currencyrate);
      $("input[name='notagirpro_1_productname']").val('');
      $("input[name='notagirpro_1_uomcode']").val('');
      $("input[name='notagirpro_1_sloccode']").val('');
      $("input[name='notagirpro_1_currencyname']").val('');
			$('#InputDialognotagirpro').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatanotagiracc()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/createnotagiracc')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			
			$('#InputDialognotagiracc').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='notagir_0_notagirid']").val(data.notagirid);
				$("input[name='notagir_0_companyid']").val(data.companyid);
      $("input[name='notagir_0_docdate']").val(data.docdate);
      $("input[name='notagir_0_gireturid']").val(data.gireturid);
      $("textarea[name='notagir_0_headernote']").val(data.headernote);
      $("input[name='notagir_0_companyname']").val(data.companyname);
      $("input[name='notagir_0_gireturno']").val(data.gireturno);
				$.fn.yiiGridView.update('notagirproList',{data:{'notagirid':data.notagirid}});
$.fn.yiiGridView.update('notagiraccList',{data:{'notagirid':data.notagirid}});

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
function updatedatanotagirpro($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/updatenotagirpro')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='notagirpro_1_price']").val(data.price);
      $("input[name='notagirpro_1_currencyid']").val(data.currencyid);
      $("input[name='notagirpro_1_currencyrate']").val(data.currencyrate);
      $("input[name='notagirpro_1_productname']").val(data.productname);
      $("input[name='notagirpro_1_uomcode']").val(data.uomcode);
      $("input[name='notagirpro_1_sloccode']").val(data.sloccode);
      $("input[name='notagirpro_1_currencyname']").val(data.currencyname);
			$('#InputDialognotagirpro').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatanotagiracc($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/updatenotagiracc')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			
			$('#InputDialognotagiracc').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/save')?>',
		'data':{
			'notagirid':$("input[name='notagir_0_notagirid']").val(),
			'companyid':$("input[name='notagir_0_companyid']").val(),
      'docdate':$("input[name='notagir_0_docdate']").val(),
      'gireturid':$("input[name='notagir_0_gireturid']").val(),
      'headernote':$("textarea[name='notagir_0_headernote']").val(),
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

function savedatanotagirpro()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/savenotagirpro')?>',
		'data':{
			'notagirid':$("input[name='notagir_0_notagirid']").val(),
			'price':$("input[name='notagirpro_1_price']").val(),
      'currencyid':$("input[name='notagirpro_1_currencyid']").val(),
      'currencyrate':$("input[name='notagirpro_1_currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialognotagirpro').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagirproList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatanotagiracc()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/savenotagiracc')?>',
		'data':{
			'notagirid':$("input[name='notagir_0_notagirid']").val(),
			
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialognotagiracc').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagiraccList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/purge')?>','data':{'id':$id},
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
function purgedatanotagirpro()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/purgenotagirpro')?>','data':{'id':$.fn.yiiGridView.getSelection("notagirproList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagirproList");
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
function purgedatanotagiracc()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/notagir/purgenotagiracc')?>','data':{'id':$.fn.yiiGridView.getSelection("notagiraccList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("notagiraccList");
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
	var array = 'notagirid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagirno='+$("input[name='dlg_search_notagirno']").val()
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'notagirid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagirno='+$("input[name='dlg_search_notagirno']").val()
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/notagir/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'notagirid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&notagirno='+$("input[name='dlg_search_notagirno']").val()
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/notagir/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'notagirid='+$id
$.fn.yiiGridView.update("DetailnotagirproList",{data:array});
$.fn.yiiGridView.update("DetailnotagiraccList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('notagir') ?></h3>
<?php if ($this->checkAccess('notagir','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagir','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagir','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagir','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('notagir','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('notagir','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagir','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('notagir','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('notagirid'),
					'name'=>'notagirid',
					'value'=>'$data["notagirid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('notagirno'),
					'name'=>'notagirno',
					'value'=>'$data["notagirno"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('gireturno'),
					'name'=>'gireturid',
					'value'=>'$data["gireturno"]'
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
						<label for="dlg_search_notagirno"><?php echo $this->getCatalog('notagirno')?></label>
						<input type="text" class="form-control" name="dlg_search_notagirno">
					</div>
          <div class="form-group">
						<label for="dlg_search_gireturno"><?php echo $this->getCatalog('gireturno')?></label>
						<input type="text" class="form-control" name="dlg_search_gireturno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('notagir') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="notagir_0_notagirid">
        <div class="row">
						<div class="col-md-4">
							<label for="notagir_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="notagir_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagir_0_gireturid','ColField'=>'notagir_0_gireturno',
							'IDDialog'=>'notagir_0_gireturid_dialog','titledialog'=>$this->getCatalog('gireturno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GireturPopUp','PopGrid'=>'notagir_0_gireturidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagir_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="notagir_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#notagirpro"><?php echo $this->getCatalog("notagirpro")?></a></li>
<li><a data-toggle="tab" href="#notagiracc"><?php echo $this->getCatalog("notagiracc")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="notagirpro" class="tab-pane">
	<?php if ($this->checkAccess('notagir','iswrite')) { ?>
<button name="CreateButtonnotagirpro" type="button" class="btn btn-primary" onclick="newdatanotagirpro()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagir','ispurge')) { ?>
<button name="PurgeButtonnotagirpro" type="button" class="btn btn-danger" onclick="purgedatanotagirpro()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagirpro,
		'id'=>'notagirproList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagir','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagirpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagir','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagirpro($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagirproid'),
					'name'=>'notagirproid',
					'value'=>'$data["notagirproid"]'
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
<div id="notagiracc" class="tab-pane">
	<?php if ($this->checkAccess('notagir','iswrite')) { ?>
<button name="CreateButtonnotagiracc" type="button" class="btn btn-primary" onclick="newdatanotagiracc()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('notagir','ispurge')) { ?>
<button name="PurgeButtonnotagiracc" type="button" class="btn btn-danger" onclick="purgedatanotagiracc()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagiracc,
		'id'=>'notagiraccList',
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
							'visible'=>$this->booltostr($this->checkAccess('notagir','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatanotagiracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('notagir','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatanotagiracc($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('notagiraccid'),
					'name'=>'notagiraccid',
					'value'=>'$data["notagiraccid"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('notagirpro')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagirpro,
		'id'=>'DetailnotagirproList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagirproid'),
					'name'=>'notagirproid',
					'value'=>'$data["notagirproid"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('notagiracc')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidernotagiracc,
		'id'=>'DetailnotagiraccList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('notagiraccid'),
					'name'=>'notagiraccid',
					'value'=>'$data["notagiraccid"]'
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
			
<div id="InputDialognotagirpro" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagirpro') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="notagirpro_1_price">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'notagirpro_1_currencyid','ColField'=>'notagirpro_1_currencyname',
							'IDDialog'=>'notagirpro_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'notagirpro_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="notagirpro_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="notagirpro_1_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagirpro()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialognotagiracc" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('notagiracc') ?></h4>
      </div>
			<div class="modal-body">
			
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatanotagiracc()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			