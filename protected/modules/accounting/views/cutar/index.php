<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cutar_0_cutarid']").val(data.cutarid);
			$("input[name='cutar_0_docdate']").val(data.docdate);
      $("input[name='cutar_0_companyid']").val('');
      $("input[name='cutar_0_ttntid']").val('');
      $("input[name='cutar_0_companyname']").val('');
      $("input[name='cutar_0_docno']").val('');
      $("input[name='cutar_0_cbinno']").val('');
			$.fn.yiiGridView.update('cutarinvList',{data:{'cutarid':data.cutarid}});

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
function newdatacutarinv()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/createcutarinv')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cutarinv_1_cashamount']").val(data.cashamount);
      $("input[name='cutarinv_1_bankamount']").val(data.bankamount);
      $("input[name='cutarinv_1_discamount']").val(data.discamount);
      $("input[name='cutarinv_1_returnamount']").val(data.returnamount);
      $("input[name='cutarinv_1_obamount']").val(data.obamount);
      $("input[name='cutarinv_1_currencyid']").val(data.currencyid);
      $("input[name='cutarinv_1_currencyrate']").val(data.currencyrate);
      $("input[name='cutarinv_1_description']").val('');
      $("input[name='cutarinv_1_invoiceno']").val('');
      $("input[name='cutarinv_1_invoicedate']").val('');
      $("input[name='cutarinv_1_currencyname']").val(data.currencyname);
			$('#InputDialogcutarinv').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cutar_0_cutarid']").val(data.cutarid);
				$("input[name='cutar_0_docdate']").val(data.docdate);
      $("input[name='cutar_0_companyid']").val(data.companyid);
      $("input[name='cutar_0_ttntid']").val(data.ttntid);
      $("input[name='cutar_0_companyname']").val(data.companyname);
      $("input[name='cutar_0_docno']").val(data.docno);
      $("input[name='cutar_0_cbinno']").val(data.cbinno);
				$.fn.yiiGridView.update('cutarinvList',{data:{'cutarid':data.cutarid}});

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
function updatedatacutarinv($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/updatecutarinv')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cutarinv_1_cashamount']").val(data.cashamount);
      $("input[name='cutarinv_1_bankamount']").val(data.bankamount);
      $("input[name='cutarinv_1_discamount']").val(data.discamount);
      $("input[name='cutarinv_1_returnamount']").val(data.returnamount);
      $("input[name='cutarinv_1_obamount']").val(data.obamount);
      $("input[name='cutarinv_1_currencyid']").val(data.currencyid);
      $("input[name='cutarinv_1_currencyrate']").val(data.currencyrate);
      $("input[name='cutarinv_1_description']").val(data.description);
      $("input[name='cutarinv_1_invoiceno']").val(data.invoiceno);
      $("input[name='cutarinv_1_invoicedate']").val(data.invoicedate);
      $("input[name='cutarinv_1_currencyname']").val(data.currencyname);
			$('#InputDialogcutarinv').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/save')?>',
		'data':{
			'cutarid':$("input[name='cutar_0_cutarid']").val(),
			'docdate':$("input[name='cutar_0_docdate']").val(),
      'companyid':$("input[name='cutar_0_companyid']").val(),
      'ttntid':$("input[name='cutar_0_ttntid']").val(),
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

function savedatacutarinv()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/savecutarinv')?>',
		'data':{
			'cutarid':$("input[name='cutar_0_cutarid']").val(),
			'cashamount':$("input[name='cutarinv_1_cashamount']").val(),
      'bankamount':$("input[name='cutarinv_1_bankamount']").val(),
      'discamount':$("input[name='cutarinv_1_discamount']").val(),
      'returnamount':$("input[name='cutarinv_1_returnamount']").val(),
      'obamount':$("input[name='cutarinv_1_obamount']").val(),
      'currencyid':$("input[name='cutarinv_1_currencyid']").val(),
      'currencyrate':$("input[name='cutarinv_1_currencyrate']").val(),
      'description':$("input[name='cutarinv_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcutarinv').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cutarinvList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/purge')?>','data':{'id':$id},
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
function purgedatacutarinv()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/cutar/purgecutarinv')?>','data':{'id':$.fn.yiiGridView.getSelection("cutarinvList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cutarinvList");
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
	var array = 'cutarid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cutarno='+$("input[name='dlg_search_cutarno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'cutarid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cutarno='+$("input[name='dlg_search_cutarno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cutar/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'cutarid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cutarno='+$("input[name='dlg_search_cutarno']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val()
+ '&cbinno='+$("input[name='dlg_search_cbinno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/cutar/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cutarid='+$id
$.fn.yiiGridView.update("DetailcutarinvList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('cutar') ?></h3>
<?php if ($this->checkAccess('cutar','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cutar','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('cutar','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('cutar','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('cutar','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('cutar','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cutar','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('cutar','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('cutarid'),
					'name'=>'cutarid',
					'value'=>'$data["cutarid"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('cutarno'),
					'name'=>'cutarno',
					'value'=>'$data["cutarno"]'
				),
							array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'ttntid',
					'value'=>'$data["docno"]'
				),
							array(
					'header'=>$this->getCatalog('cbinno'),
					'name'=>'cbinid',
					'value'=>'$data["cbinno"]'
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
						<label for="dlg_search_cutarno"><?php echo $this->getCatalog('cutarno')?></label>
						<input type="text" class="form-control" name="dlg_search_cutarno">
					</div>
          <div class="form-group">
						<label for="dlg_search_docno"><?php echo $this->getCatalog('docno')?></label>
						<input type="text" class="form-control" name="dlg_search_docno">
					</div>
          <div class="form-group">
						<label for="dlg_search_cbinno"><?php echo $this->getCatalog('cbinno')?></label>
						<input type="text" class="form-control" name="dlg_search_cbinno">
					</div>
          <div class="form-group">
						<label for="dlg_search_headernote"><?php echo $this->getCatalog('headernote')?></label>
						<input type="text" class="form-control" name="dlg_search_headernote">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('cutar') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="cutar_0_cutarid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cutar_0_companyid','ColField'=>'cutar_0_companyname',
							'IDDialog'=>'cutar_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'cutar_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cutar_0_ttntid','ColField'=>'cutar_0_docno',
							'IDDialog'=>'cutar_0_ttntid_dialog','titledialog'=>$this->getCatalog('docno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.TtntPopUp','PopGrid'=>'cutar_0_ttntidgrid')); 
					?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#cutarinv"><?php echo $this->getCatalog("cutarinv")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="cutarinv" class="tab-pane">
	<?php if ($this->checkAccess('cutar','iswrite')) { ?>
<button name="CreateButtoncutarinv" type="button" class="btn btn-primary" onclick="newdatacutarinv()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('cutar','ispurge')) { ?>
<button name="PurgeButtoncutarinv" type="button" class="btn btn-danger" onclick="purgedatacutarinv()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercutarinv,
		'id'=>'cutarinvList',
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
							'visible'=>$this->booltostr($this->checkAccess('cutar','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatacutarinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('cutar','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatacutarinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('cutarinvid'),
					'name'=>'cutarinvid',
					'value'=>'$data["cutarinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoice'),
					'name'=>'invoiceid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('saldoinvoice'),
					'name'=>'saldoinvoice',
					'value'=>'Yii::app()->format->formatNumber($data["saldoinvoice"])'
				),
							array(
					'header'=>$this->getCatalog('invoiceda'),
					'name'=>'invoicedate',
					'value'=>'Yii::app()->format->formatDate($data["invoicedate"])'
				),
							array(
					'header'=>$this->getCatalog('cashamount'),
					'name'=>'cashamount',
					'value'=>'Yii::app()->format->formatNumber($data["cashamount"])'
				),
							array(
					'header'=>$this->getCatalog('bankamount'),
					'name'=>'bankamount',
					'value'=>'Yii::app()->format->formatNumber($data["bankamount"])'
				),
							array(
					'header'=>$this->getCatalog('discamount'),
					'name'=>'discamount',
					'value'=>'Yii::app()->format->formatNumber($data["discamount"])'
				),
							array(
					'header'=>$this->getCatalog('returnamount'),
					'name'=>'returnamount',
					'value'=>'Yii::app()->format->formatNumber($data["returnamount"])'
				),
							array(
					'header'=>$this->getCatalog('obamount'),
					'name'=>'obamount',
					'value'=>'Yii::app()->format->formatNumber($data["obamount"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('cutarinv')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidercutarinv,
		'id'=>'DetailcutarinvList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('cutarinvid'),
					'name'=>'cutarinvid',
					'value'=>'$data["cutarinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoice'),
					'name'=>'invoiceid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('saldoinvoice'),
					'name'=>'saldoinvoice',
					'value'=>'Yii::app()->format->formatNumber($data["saldoinvoice"])'
				),
							array(
					'header'=>$this->getCatalog('invoiceda'),
					'name'=>'invoicedate',
					'value'=>'Yii::app()->format->formatDate($data["invoicedate"])'
				),
							array(
					'header'=>$this->getCatalog('cashamount'),
					'name'=>'cashamount',
					'value'=>'Yii::app()->format->formatNumber($data["cashamount"])'
				),
							array(
					'header'=>$this->getCatalog('bankamount'),
					'name'=>'bankamount',
					'value'=>'Yii::app()->format->formatNumber($data["bankamount"])'
				),
							array(
					'header'=>$this->getCatalog('discamount'),
					'name'=>'discamount',
					'value'=>'Yii::app()->format->formatNumber($data["discamount"])'
				),
							array(
					'header'=>$this->getCatalog('returnamount'),
					'name'=>'returnamount',
					'value'=>'Yii::app()->format->formatNumber($data["returnamount"])'
				),
							array(
					'header'=>$this->getCatalog('obamount'),
					'name'=>'obamount',
					'value'=>'Yii::app()->format->formatNumber($data["obamount"])'
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
			
<div id="InputDialogcutarinv" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('cutarinv') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="cutarinv_1_cashamount">
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_bankamount"><?php echo $this->getCatalog('bankamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cutarinv_1_bankamount">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_discamount"><?php echo $this->getCatalog('discamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cutarinv_1_discamount">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_returnamount"><?php echo $this->getCatalog('returnamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cutarinv_1_returnamount">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_obamount"><?php echo $this->getCatalog('obamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cutarinv_1_obamount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'cutarinv_1_currencyid','ColField'=>'cutarinv_1_currencyname',
							'IDDialog'=>'cutarinv_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'cutarinv_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="cutarinv_1_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="cutarinv_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="cutarinv_1_description">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatacutarinv()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			