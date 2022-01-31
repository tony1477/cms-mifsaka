if("undefined"==typeof jQuery)throw new Error("Payment Request's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='payrequestid']").val(data.payrequestid);
			$("input[name='actiontype']").val(0);
			$("input[name='payreqdate']").val(data.payreqdate);
      $("input[name='companyid']").val(data.companyid);
      $("textarea[name='description']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
			$.fn.yiiGridView.update('payrequestdetList',{data:{'payrequestid':data.payrequestid}});

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
function newdatapayrequestdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/createpayrequestdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='payrequestdetid']").val('');
      $("input[name='invoiceapid']").val('');
      $("input[name='amount']").val(data.amount);
      $("input[name='paydate']").val(data.paydate);
      $("input[name='payamount']").val(data.payamount);
      $("input[name='invoiceno']").val('');
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='currencyrate']").val(data.currencyrate);
			$('#InputDialogpayrequestdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='payrequestid']").val(data.payrequestid);
				$("input[name='actiontype']").val(1);
				$("input[name='payreqdate']").val(data.payreqdate);
      $("input[name='companyid']").val(data.companyid);
      $("textarea[name='description']").val(data.description);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
				$.fn.yiiGridView.update('payrequestdetList',{data:{'payrequestid':data.payrequestid}});

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
function updatedatapayrequestdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/updatepayrequestdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='payrequestdetid']").val(data.payrequestdetid);
      $("input[name='invoiceapid']").val(data.invoiceapid);
      $("input[name='amount']").val(data.amount);
      $("input[name='paydate']").val(data.paydate);
      $("input[name='payamount']").val(data.payamount);
      $("input[name='invoiceno']").val(data.invoiceno);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogpayrequestdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/save')?>',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'payrequestid':$("input[name='payrequestid']").val(),
			'payreqdate':$("input[name='payreqdate']").val(),
      'companyid':$("input[name='companyid']").val(),
      'description':$("textarea[name='description']").val(),
      'recordstatus':$("input[name='recordstatus']").val(),
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

function savedatapayrequestdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/savepayrequestdet')?>',
		'data':{
			'payrequestid':$("input[name='payrequestid']").val(),
			'payrequestdetid':$("input[name='payrequestdetid']").val(),
      'invoiceapid':$("input[name='invoiceapid']").val(),
      'amount':$("input[name='amount']").val(),
      'paydate':$("input[name='paydate']").val(),
      'payamount':$("input[name='payamount']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogpayrequestdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("payrequestdetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/purge')?>','data':{'id':$id},
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
function purgedatapayrequestdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/purgepayrequestdet')?>','data':{'id':$.fn.yiiGridView.getSelection("payrequestdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("payrequestdetList");
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
	$.fn.yiiGridView.update("GridList",{data:{
		'payrequestid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'payrequestid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/payrequest/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'payrequestid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/payrequest/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'payrequestid='+$id
$.fn.yiiGridView.update("DetailpayrequestdetList",{data:array});
} 

function getinvap()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('accounting/payrequest/getinvap')?>',
		'data':{'id':$("input[name='poheaderid']").val(),
		'hid':$("input[name='invoiceapid']").val(),},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='amount']").val(data.amount);
				$("input[name='payamount']").val(data.amount);
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});
}