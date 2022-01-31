<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceap_0_invoiceapid']").val(data.invoiceapid);
			$("input[name='invoiceap_0_companyid']").val('');
      $("input[name='invoiceap_0_invoiceno']").val('');
      $("input[name='invoiceap_0_invoicedate']").val(data.invoicedate);
      $("input[name='invoiceap_0_poheaderid']").val('');
      $("input[name='invoiceap_0_addressbookid']").val('');
      $("input[name='invoiceap_0_taxno']").val('');
      $("input[name='invoiceap_0_taxdate']").val(data.taxdate);
      $("input[name='invoiceap_0_amount']").val(data.amount);
      $("input[name='invoiceap_0_currencyid']").val(data.currencyid);
      $("input[name='invoiceap_0_currencyrate']").val(data.currencyrate);
      $("input[name='invoiceap_0_taxid']").val('');
      $("input[name='invoiceap_0_paymentmethodid']").val('');
      $("input[name='invoiceap_0_journalno']").val('');
      $("input[name='invoiceap_0_receiptdate']").val(data.receiptdate);
      $("input[name='invoiceap_0_grheaderid']").val('');
      $("input[name='invoiceap_0_companyname']").val('');
      $("input[name='invoiceap_0_pono']").val('');
      $("input[name='invoiceap_0_fullname']").val('');
      $("input[name='invoiceap_0_taxcode']").val('');
      $("input[name='invoiceap_0_currencyname']").val(data.currencyname);
      $("input[name='invoiceap_0_taxcode']").val('');
      $("input[name='invoiceap_0_paycode']").val('');
      $("input[name='invoiceap_0_grno']").val('');
			$.fn.yiiGridView.update('invoiceapmatList',{data:{'invoiceapid':data.invoiceapid}});
$.fn.yiiGridView.update('invoiceapjurnalList',{data:{'invoiceapid':data.invoiceapid}});

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
function newdatainvoiceapmat()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/createinvoiceapmat')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapmat_1_productname']").val('');
      $("input[name='invoiceapmat_1_uomcode']").val('');
			$('#InputDialoginvoiceapmat').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatainvoiceapjurnal()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/createinvoiceapjurnal')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapjurnal_2_accountid']").val('');
      $("input[name='invoiceapjurnal_2_debet']").val(data.debet);
      $("input[name='invoiceapjurnal_2_credit']").val(data.credit);
      $("input[name='invoiceapjurnal_2_description']").val('');
      $("input[name='invoiceapjurnal_2_currencyid']").val(data.currencyid);
      $("input[name='invoiceapjurnal_2_currencyrate']").val(data.currencyrate);
      $("input[name='invoiceapjurnal_2_accountname']").val('');
      $("input[name='invoiceapjurnal_2_currencyname']").val('');
			$('#InputDialoginvoiceapjurnal').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='invoiceap_0_invoiceapid']").val(data.invoiceapid);
				$("input[name='invoiceap_0_companyid']").val(data.companyid);
      $("input[name='invoiceap_0_invoiceno']").val(data.invoiceno);
      $("input[name='invoiceap_0_invoicedate']").val(data.invoicedate);
      $("input[name='invoiceap_0_poheaderid']").val(data.poheaderid);
      $("input[name='invoiceap_0_addressbookid']").val(data.addressbookid);
      $("input[name='invoiceap_0_taxno']").val(data.taxno);
      $("input[name='invoiceap_0_taxdate']").val(data.taxdate);
      $("input[name='invoiceap_0_amount']").val(data.amount);
      $("input[name='invoiceap_0_currencyid']").val(data.currencyid);
      $("input[name='invoiceap_0_currencyrate']").val(data.currencyrate);
      $("input[name='invoiceap_0_taxid']").val(data.taxid);
      $("input[name='invoiceap_0_paymentmethodid']").val(data.paymentmethodid);
      $("input[name='invoiceap_0_journalno']").val(data.journalno);
      $("input[name='invoiceap_0_receiptdate']").val(data.receiptdate);
      $("input[name='invoiceap_0_grheaderid']").val(data.grheaderid);
      $("input[name='invoiceap_0_companyname']").val(data.companyname);
      $("input[name='invoiceap_0_pono']").val(data.pono);
      $("input[name='invoiceap_0_fullname']").val(data.fullname);
      $("input[name='invoiceap_0_taxcode']").val(data.taxcode);
      $("input[name='invoiceap_0_currencyname']").val(data.currencyname);
      $("input[name='invoiceap_0_taxcode']").val(data.taxcode);
      $("input[name='invoiceap_0_paycode']").val(data.paycode);
      $("input[name='invoiceap_0_grno']").val(data.grno);
				$.fn.yiiGridView.update('invoiceapmatList',{data:{'invoiceapid':data.invoiceapid}});
$.fn.yiiGridView.update('invoiceapjurnalList',{data:{'invoiceapid':data.invoiceapid}});

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
function updatedatainvoiceapmat($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/updateinvoiceapmat')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapmat_1_productname']").val(data.productname);
      $("input[name='invoiceapmat_1_uomcode']").val(data.uomcode);
			$('#InputDialoginvoiceapmat').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatainvoiceapjurnal($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/updateinvoiceapjurnal')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapjurnal_2_accountid']").val(data.accountid);
      $("input[name='invoiceapjurnal_2_debet']").val(data.debet);
      $("input[name='invoiceapjurnal_2_credit']").val(data.credit);
      $("input[name='invoiceapjurnal_2_description']").val(data.description);
      $("input[name='invoiceapjurnal_2_currencyid']").val(data.currencyid);
      $("input[name='invoiceapjurnal_2_currencyrate']").val(data.currencyrate);
      $("input[name='invoiceapjurnal_2_accountname']").val(data.accountname);
      $("input[name='invoiceapjurnal_2_currencyname']").val(data.currencyname);
			$('#InputDialoginvoiceapjurnal').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/save')?>',
		'data':{
			'invoiceapid':$("input[name='invoiceap_0_invoiceapid']").val(),
			'companyid':$("input[name='invoiceap_0_companyid']").val(),
      'invoiceno':$("input[name='invoiceap_0_invoiceno']").val(),
      'invoicedate':$("input[name='invoiceap_0_invoicedate']").val(),
      'poheaderid':$("input[name='invoiceap_0_poheaderid']").val(),
      'addressbookid':$("input[name='invoiceap_0_addressbookid']").val(),
      'taxno':$("input[name='invoiceap_0_taxno']").val(),
      'taxdate':$("input[name='invoiceap_0_taxdate']").val(),
      'amount':$("input[name='invoiceap_0_amount']").val(),
      'currencyid':$("input[name='invoiceap_0_currencyid']").val(),
      'currencyrate':$("input[name='invoiceap_0_currencyrate']").val(),
      'taxid':$("input[name='invoiceap_0_taxid']").val(),
      'paymentmethodid':$("input[name='invoiceap_0_paymentmethodid']").val(),
      'journalno':$("input[name='invoiceap_0_journalno']").val(),
      'receiptdate':$("input[name='invoiceap_0_receiptdate']").val(),
      'grheaderid':$("input[name='invoiceap_0_grheaderid']").val(),
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

function savedatainvoiceapmat()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/saveinvoiceapmat')?>',
		'data':{
			'invoiceapid':$("input[name='invoiceap_0_invoiceapid']").val(),
			
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoginvoiceapmat').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceapmatList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatainvoiceapjurnal()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/saveinvoiceapjurnal')?>',
		'data':{
			'invoiceapid':$("input[name='invoiceap_0_invoiceapid']").val(),
			'accountid':$("input[name='invoiceapjurnal_2_accountid']").val(),
      'debet':$("input[name='invoiceapjurnal_2_debet']").val(),
      'credit':$("input[name='invoiceapjurnal_2_credit']").val(),
      'description':$("input[name='invoiceapjurnal_2_description']").val(),
      'currencyid':$("input[name='invoiceapjurnal_2_currencyid']").val(),
      'currencyrate':$("input[name='invoiceapjurnal_2_currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoginvoiceapjurnal').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceapjurnalList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/purge')?>','data':{'id':$id},
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
function purgedatainvoiceapmat()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/purgeinvoiceapmat')?>','data':{'id':$.fn.yiiGridView.getSelection("invoiceapmatList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceapmatList");
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
function purgedatainvoiceapjurnal()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/invoiceap/purgeinvoiceapjurnal')?>','data':{'id':$.fn.yiiGridView.getSelection("invoiceapjurnalList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceapjurnalList");
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
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&currencyrate='+$("input[name='dlg_search_currencyrate']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&currencyrate='+$("input[name='dlg_search_currencyrate']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/invoiceap/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&currencyrate='+$("input[name='dlg_search_currencyrate']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/invoiceap/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'invoiceapid='+$id
$.fn.yiiGridView.update("DetailinvoiceapmatList",{data:array});
$.fn.yiiGridView.update("DetailinvoiceapjurnalList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('invoiceap') ?></h3>
<?php if ($this->checkAccess('invoiceap','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoiceap','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoiceap','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoiceap','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('invoiceap','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('invoiceapid'),
					'name'=>'invoiceapid',
					'value'=>'$data["invoiceapid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('invoiceno'),
					'name'=>'invoiceno',
					'value'=>'$data["invoiceno"]'
				),
							array(
					'header'=>$this->getCatalog('invoicedate'),
					'name'=>'invoicedate',
					'value'=>'Yii::app()->format->formatDate($data["invoicedate"])'
				),
							array(
					'header'=>$this->getCatalog('pono'),
					'name'=>'poheaderid',
					'value'=>'$data["pono"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('tax'),
					'name'=>'taxno',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('taxdate'),
					'name'=>'taxdate',
					'value'=>'Yii::app()->format->formatDate($data["taxdate"])'
				),
							array(
					'header'=>$this->getCatalog('amount'),
					'name'=>'amount',
					'value'=>'Yii::app()->format->formatNumber($data["amount"])'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('currencyrate'),
					'name'=>'currencyrate',
					'value'=>'Yii::app()->format->formatNumber($data["currencyrate"])'
				),
							array(
					'header'=>$this->getCatalog('taxcode'),
					'name'=>'taxid',
					'value'=>'$data["taxcode"]'
				),
							array(
					'header'=>$this->getCatalog('paycode'),
					'name'=>'paymentmethodid',
					'value'=>'$data["paycode"]'
				),
							array(
					'header'=>$this->getCatalog('journalno'),
					'name'=>'journalno',
					'value'=>'$data["journalno"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
				),
							array(
					'header'=>$this->getCatalog('receiptdate'),
					'name'=>'receiptdate',
					'value'=>'Yii::app()->format->formatDate($data["receiptdate"])'
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
						<label for="dlg_search_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						<input type="text" class="form-control" name="dlg_search_invoiceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_pono"><?php echo $this->getCatalog('pono')?></label>
						<input type="text" class="form-control" name="dlg_search_pono">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxcode"><?php echo $this->getCatalog('taxcode')?></label>
						<input type="text" class="form-control" name="dlg_search_taxcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyrate">
					</div>
          <div class="form-group">
						<label for="dlg_search_taxcode"><?php echo $this->getCatalog('taxcode')?></label>
						<input type="text" class="form-control" name="dlg_search_taxcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_paycode"><?php echo $this->getCatalog('paycode')?></label>
						<input type="text" class="form-control" name="dlg_search_paycode">
					</div>
          <div class="form-group">
						<label for="dlg_search_grno"><?php echo $this->getCatalog('grno')?></label>
						<input type="text" class="form-control" name="dlg_search_grno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('invoiceap') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="invoiceap_0_invoiceapid">
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_invoiceno"><?php echo $this->getCatalog('invoiceno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="invoiceap_0_invoiceno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_invoicedate"><?php echo $this->getCatalog('invoicedate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="invoiceap_0_invoicedate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_poheaderid','ColField'=>'invoiceap_0_pono',
							'IDDialog'=>'invoiceap_0_poheaderid_dialog','titledialog'=>$this->getCatalog('pono'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.PogrPopUp','PopGrid'=>'invoiceap_0_poheaderidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_addressbookid','ColField'=>'invoiceap_0_fullname',
							'IDDialog'=>'invoiceap_0_addressbookid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'invoiceap_0_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="invoiceap_0_taxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_taxdate"><?php echo $this->getCatalog('taxdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="invoiceap_0_taxdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoiceap_0_amount">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_currencyid','ColField'=>'invoiceap_0_currencyname',
							'IDDialog'=>'invoiceap_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'invoiceap_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoiceap_0_currencyrate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_taxid','ColField'=>'invoiceap_0_taxcode',
							'IDDialog'=>'invoiceap_0_taxid_dialog','titledialog'=>$this->getCatalog('taxcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'invoiceap_0_taxidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_paymentmethodid','ColField'=>'invoiceap_0_paycode',
							'IDDialog'=>'invoiceap_0_paymentmethodid_dialog','titledialog'=>$this->getCatalog('paycode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.PaymentmethodPopUp','PopGrid'=>'invoiceap_0_paymentmethodidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_journalno"><?php echo $this->getCatalog('journalno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="invoiceap_0_journalno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceap_0_receiptdate"><?php echo $this->getCatalog('receiptdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="invoiceap_0_receiptdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceap_0_grheaderid','ColField'=>'invoiceap_0_grno',
							'IDDialog'=>'invoiceap_0_grheaderid_dialog','titledialog'=>$this->getCatalog('grno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GiheaderPopUp','PopGrid'=>'invoiceap_0_grheaderidgrid')); 
					?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#invoiceapmat"><?php echo $this->getCatalog("invoiceapmat")?></a></li>
<li><a data-toggle="tab" href="#invoiceapjurnal"><?php echo $this->getCatalog("invoiceapjurnal")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="invoiceapmat" class="tab-pane">
	<?php if ($this->checkAccess('invoiceap','iswrite')) { ?>
<button name="CreateButtoninvoiceapmat" type="button" class="btn btn-primary" onclick="newdatainvoiceapmat()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoiceap','ispurge')) { ?>
<button name="PurgeButtoninvoiceapmat" type="button" class="btn btn-danger" onclick="purgedatainvoiceapmat()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderinvoiceapmat,
		'id'=>'invoiceapmatList',
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
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatainvoiceapmat($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatainvoiceapmat($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('invoiceapmatid'),
					'name'=>'invoiceapmatid',
					'value'=>'$data["invoiceapmatid"]'
				),
							array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('grdetailid'),
					'name'=>'grdetailid',
					'value'=>'$data["grdetailid"]'
				),
							
		)
));
?>
  </div>
<div id="invoiceapjurnal" class="tab-pane">
	<?php if ($this->checkAccess('invoiceap','iswrite')) { ?>
<button name="CreateButtoninvoiceapjurnal" type="button" class="btn btn-primary" onclick="newdatainvoiceapjurnal()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('invoiceap','ispurge')) { ?>
<button name="PurgeButtoninvoiceapjurnal" type="button" class="btn btn-danger" onclick="purgedatainvoiceapjurnal()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderinvoiceapjurnal,
		'id'=>'invoiceapjurnalList',
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
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatainvoiceapjurnal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('invoiceap','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatainvoiceapjurnal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('invoiceapjurnalid'),
					'name'=>'invoiceapjurnalid',
					'value'=>'$data["invoiceapjurnalid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('invoiceapmat')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderinvoiceapmat,
		'id'=>'DetailinvoiceapmatList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('invoiceapmatid'),
					'name'=>'invoiceapmatid',
					'value'=>'$data["invoiceapmatid"]'
				),
							array(
					'header'=>$this->getCatalog('podetailid'),
					'name'=>'podetailid',
					'value'=>'$data["podetailid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('uom'),
					'name'=>'uomid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('grdetailid'),
					'name'=>'grdetailid',
					'value'=>'$data["grdetailid"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('invoiceapjurnal')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderinvoiceapjurnal,
		'id'=>'DetailinvoiceapjurnalList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('invoiceapjurnalid'),
					'name'=>'invoiceapjurnalid',
					'value'=>'$data["invoiceapjurnalid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountname"]'
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
			
<div id="InputDialoginvoiceapmat" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('invoiceapmat') ?></h4>
      </div>
			<div class="modal-body">
			
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatainvoiceapmat()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialoginvoiceapjurnal" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('invoiceapjurnal') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="invoiceapjurnal_2_accountid">
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceapjurnal_2_debet"><?php echo $this->getCatalog('debet')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoiceapjurnal_2_debet">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceapjurnal_2_credit"><?php echo $this->getCatalog('credit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoiceapjurnal_2_credit">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceapjurnal_2_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="invoiceapjurnal_2_description">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceapjurnal_2_currencyid','ColField'=>'invoiceapjurnal_2_currencyname',
							'IDDialog'=>'invoiceapjurnal_2_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'invoiceapjurnal_2_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="invoiceapjurnal_2_currencyrate"><?php echo $this->getCatalog('currencyrate')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="invoiceapjurnal_2_currencyrate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatainvoiceapjurnal()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			