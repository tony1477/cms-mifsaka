<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='reqpay_0_reqpayid']").val(data.reqpayid);
			$("input[name='reqpay_0_companyid']").val('');
      $("input[name='reqpay_0_docdate']").val(data.docdate);
      $("textarea[name='reqpay_0_headernote']").val('');
      $("input[name='reqpay_0_companyname']").val('');
			$.fn.yiiGridView.update('reqpayinvList',{data:{'reqpayid':data.reqpayid}});

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
function newdatareqpayinv()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/createreqpayinv')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='reqpayinv_1_invoiceapid']").val('');
      $("input[name='reqpayinv_1_taxid']").val('');
      $("input[name='reqpayinv_1_taxno']").val('');
      $("input[name='reqpayinv_1_taxdate']").val(data.taxdate);
      $("input[name='reqpayinv_1_currencyid']").val(data.currencyid);
      $("input[name='reqpayinv_1_currencyrate']").val('');
      $("input[name='reqpayinv_1_bankaccountno']").val('');
      $("input[name='reqpayinv_1_bankname']").val('');
      $("input[name='reqpayinv_1_bankowner']").val('');
      $("textarea[name='reqpayinv_1_itemnote']").val('');
      $("input[name='reqpayinv_1_invoiceno']").val('');
      $("input[name='reqpayinv_1_amount']").val('');
      $("input[name='reqpayinv_1_taxcode']").val('');
      $("input[name='reqpayinv_1_currencyname']").val('');
			$('#InputDialogreqpayinv').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='reqpay_0_reqpayid']").val(data.reqpayid);
				$("input[name='reqpay_0_companyid']").val(data.companyid);
      $("input[name='reqpay_0_docdate']").val(data.docdate);
      $("textarea[name='reqpay_0_headernote']").val(data.headernote);
      $("input[name='reqpay_0_companyname']").val(data.companyname);
				$.fn.yiiGridView.update('reqpayinvList',{data:{'reqpayid':data.reqpayid}});

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
function updatedatareqpayinv($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/updatereqpayinv')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='reqpayinv_1_invoiceapid']").val(data.invoiceapid);
      $("input[name='reqpayinv_1_taxid']").val(data.taxid);
      $("input[name='reqpayinv_1_taxno']").val(data.taxno);
      $("input[name='reqpayinv_1_taxdate']").val(data.taxdate);
      $("input[name='reqpayinv_1_currencyid']").val(data.currencyid);
      $("input[name='reqpayinv_1_currencyrate']").val(data.currencyrate);
      $("input[name='reqpayinv_1_bankaccountno']").val(data.bankaccountno);
      $("input[name='reqpayinv_1_bankname']").val(data.bankname);
      $("input[name='reqpayinv_1_bankowner']").val(data.bankowner);
      $("textarea[name='reqpayinv_1_itemnote']").val(data.itemnote);
      $("input[name='reqpayinv_1_invoiceno']").val(data.invoiceno);
      $("input[name='reqpayinv_1_amount']").val(data.amount);
      $("input[name='reqpayinv_1_taxcode']").val(data.taxcode);
      $("input[name='reqpayinv_1_currencyname']").val(data.currencyname);
			$('#InputDialogreqpayinv').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/save')?>',
		'data':{
			'reqpayid':$("input[name='reqpay_0_reqpayid']").val(),
			'companyid':$("input[name='reqpay_0_companyid']").val(),
      'docdate':$("input[name='reqpay_0_docdate']").val(),
      'headernote':$("textarea[name='reqpay_0_headernote']").val(),
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

function savedatareqpayinv()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/savereqpayinv')?>',
		'data':{
			'reqpayid':$("input[name='reqpay_0_reqpayid']").val(),
			'invoiceapid':$("input[name='reqpayinv_1_invoiceapid']").val(),
      'taxid':$("input[name='reqpayinv_1_taxid']").val(),
      'taxno':$("input[name='reqpayinv_1_taxno']").val(),
      'taxdate':$("input[name='reqpayinv_1_taxdate']").val(),
      'currencyid':$("input[name='reqpayinv_1_currencyid']").val(),
      'currencyrate':$("input[name='reqpayinv_1_currencyrate']").val(),
      'bankaccountno':$("input[name='reqpayinv_1_bankaccountno']").val(),
      'bankname':$("input[name='reqpayinv_1_bankname']").val(),
      'bankowner':$("input[name='reqpayinv_1_bankowner']").val(),
      'itemnote':$("textarea[name='reqpayinv_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogreqpayinv').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("reqpayinvList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/purge')?>','data':{'id':$id},
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
function purgedatareqpayinv()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/reqpay/purgereqpayinv')?>','data':{'id':$.fn.yiiGridView.getSelection("reqpayinvList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("reqpayinvList");
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
	var array = 'reqpayid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'reqpayid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/reqpay/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'reqpayid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&reqpayno='+$("input[name='dlg_search_reqpayno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/reqpay/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'reqpayid='+$id
$.fn.yiiGridView.update("DetailreqpayinvList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('reqpay') ?></h3>
<?php if ($this->checkAccess('reqpay','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('reqpay','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('reqpay','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('reqpay','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('reqpay','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('reqpay','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('reqpay','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('reqpay','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('reqpayid'),
					'name'=>'reqpayid',
					'value'=>'$data["reqpayid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('reqpayno'),
					'name'=>'reqpayno',
					'value'=>'$data["reqpayno"]'
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
						<label for="dlg_search_reqpayno"><?php echo $this->getCatalog('reqpayno')?></label>
						<input type="text" class="form-control" name="dlg_search_reqpayno">
					</div>
          <div class="form-group">
						<label for="dlg_search_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						<input type="text" class="form-control" name="dlg_search_invoiceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxno"><?php echo $this->getCatalog('taxno')?></label>
						<input type="text" class="form-control" name="dlg_search_taxno">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						<input type="text" class="form-control" name="dlg_search_bankaccountno">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankname"><?php echo $this->getCatalog('bankname')?></label>
						<input type="text" class="form-control" name="dlg_search_bankname">
					</div>
          <div class="form-group">
						<label for="dlg_search_bankowner"><?php echo $this->getCatalog('bankowner')?></label>
						<input type="text" class="form-control" name="dlg_search_bankowner">
					</div>
          <div class="form-group">
						<label for="dlg_search_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						<input type="text" class="form-control" name="dlg_search_itemnote">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('reqpay') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="reqpay_0_reqpayid">
        <div class="row">
						<div class="col-md-4">
							<label for="reqpay_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="reqpay_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpay_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="reqpay_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#reqpayinv"><?php echo $this->getCatalog("reqpayinv")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="reqpayinv" class="tab-pane">
	<?php if ($this->checkAccess('reqpay','iswrite')) { ?>
<button name="CreateButtonreqpayinv" type="button" class="btn btn-primary" onclick="newdatareqpayinv()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('reqpay','ispurge')) { ?>
<button name="PurgeButtonreqpayinv" type="button" class="btn btn-danger" onclick="purgedatareqpayinv()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderreqpayinv,
		'id'=>'reqpayinvList',
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
							'visible'=>$this->booltostr($this->checkAccess('reqpay','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatareqpayinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('reqpay','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatareqpayinv($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('reqpayinvid'),
					'name'=>'reqpayinvid',
					'value'=>'$data["reqpayinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('amou'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
					'header'=>$this->getCatalog('tax'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('taxdate'),
					'name'=>'taxdate',
					'value'=>'Yii::app()->format->formatDate($data["taxdate"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'$data["currencyrate"]'
				),
							array(
					'header'=>$this->getCatalog('bankaccountno'),
					'name'=>'bankaccountno',
					'value'=>'$data["bankaccountno"]'
				),
							array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('bankowner'),
					'name'=>'bankowner',
					'value'=>'$data["bankowner"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('reqpayinv')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderreqpayinv,
		'id'=>'DetailreqpayinvList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('reqpayinvid'),
					'name'=>'reqpayinvid',
					'value'=>'$data["reqpayinvid"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceap'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('amou'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
				),
							array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
				),
							array(
					'header'=>$this->getCatalog('tax'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('taxdate'),
					'name'=>'taxdate',
					'value'=>'Yii::app()->format->formatDate($data["taxdate"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'$data["currencyrate"]'
				),
							array(
					'header'=>$this->getCatalog('bankaccountno'),
					'name'=>'bankaccountno',
					'value'=>'$data["bankaccountno"]'
				),
							array(
					'header'=>$this->getCatalog('bankname'),
					'name'=>'bankname',
					'value'=>'$data["bankname"]'
				),
							array(
					'header'=>$this->getCatalog('bankowner'),
					'name'=>'bankowner',
					'value'=>'$data["bankowner"]'
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
			
<div id="InputDialogreqpayinv" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('reqpayinv') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="reqpayinv_1_invoiceapid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'reqpayinv_1_taxid','ColField'=>'reqpayinv_1_taxcode',
							'IDDialog'=>'reqpayinv_1_taxid_dialog','titledialog'=>$this->getCatalog('tax'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'reqpayinv_1_taxidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="reqpayinv_1_taxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_taxdate"><?php echo $this->getCatalog('taxdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="reqpayinv_1_taxdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'reqpayinv_1_currencyid','ColField'=>'reqpayinv_1_currencyname',
							'IDDialog'=>'reqpayinv_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'reqpayinv_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="reqpayinv_1_currencyrate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_bankaccountno"><?php echo $this->getCatalog('bankaccountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="reqpayinv_1_bankaccountno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_bankname"><?php echo $this->getCatalog('bankname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="reqpayinv_1_bankname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_bankowner"><?php echo $this->getCatalog('bankowner')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="reqpayinv_1_bankowner">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="reqpayinv_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="reqpayinv_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatareqpayinv()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			