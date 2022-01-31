if("undefined"==typeof jQuery)throw new Error("Cash Bank AP's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'cashbankap/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankapid']").val(data.cashbankapid);
			$("input[name='actiontype']").val(0);
			$("input[name='companyid']").val(data.companyid);
			$("input[name='cashbankapdate']").val(data.cashbankapdate);
      $("input[name='payrequestid']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='payreqno']").val('');
			$.fn.yiiGridView.update('cashbankapinvList',{data:{'cashbankapid':data.cashbankapid}});
$.fn.yiiGridView.update('cashbankappayList',{data:{'cashbankapid':data.cashbankapid}});

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
function newdatacashbankapinv()
{
	jQuery.ajax({'url':'cashbankap/createcashbankapinv','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankapinvid']").val('');
      $("input[name='invoiceapid']").val('');
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='invoiceno']").val('');
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogcashbankapinv').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatacashbankappay()
{
	jQuery.ajax({'url':'cashbankap/createcashbankappay','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankappayid']").val('');
      $("input[name='accountid']").val('');
      $("input[name='amountdet']").val(data.amountdet);
      $("input[name='currencydetid']").val(data.currencyid);
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='accountcode']").val('');
      $("input[name='currencydetname']").val(data.currencyname);
			$('#InputDialogcashbankappay').modal();
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
	jQuery.ajax({'url':'cashbankap/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cashbankapid']").val(data.cashbankapid);
				$("input[name='actiontype']").val(1);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='payrequestid']").val(data.payrequestid);
      $("input[name='cashbankapdate']").val(data.cashbankapdate);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='payreqno']").val(data.payreqno);
				$.fn.yiiGridView.update('cashbankapinvList',{data:{'cashbankapid':data.cashbankapid}});
$.fn.yiiGridView.update('cashbankappayList',{data:{'cashbankapid':data.cashbankapid}});

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
function updatedatacashbankapinv($id)
{
	jQuery.ajax({'url':'cashbankap/updatecashbankapinv','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankapinvid']").val(data.cashbankapinvid);
      $("input[name='invoiceapid']").val(data.invoiceapid);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='invoiceno']").val(data.invoiceno);
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogcashbankapinv').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatacashbankappay($id)
{
	jQuery.ajax({'url':'cashbankap/updatecashbankappay','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankappayid']").val(data.cashbankappayid);
      $("input[name='accountid']").val(data.accountid);
      $("input[name='amountdet']").val(data.amountdet);
      $("input[name='currencydetid']").val(data.currencydetid);
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='accountcode']").val(data.accountcode);
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogcashbankappay').modal();
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

	jQuery.ajax({'url':'cashbankap/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'cashbankapid':$("input[name='cashbankapid']").val(),
			'companyid':$("input[name='companyid']").val(),
			'cashbankapdate':$("input[name='cashbankapdate']").val(),
      'payrequestid':$("input[name='payrequestid']").val(),
      'headernote':$("textarea[name='headernote']").val(),
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

function savedatacashbankapinv()
{

	jQuery.ajax({'url':'cashbankap/savecashbankapinv',
		'data':{
			'cashbankapid':$("input[name='cashbankapid']").val(),
			'cashbankapinvid':$("input[name='cashbankapinvid']").val(),
      'invoiceapid':$("input[name='invoiceapid']").val(),
      'amount':$("input[name='amount']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcashbankapinv').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankapinvList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatacashbankappay()
{

	jQuery.ajax({'url':'cashbankap/savecashbankappay',
		'data':{
			'cashbankapid':$("input[name='cashbankapid']").val(),
			'cashbankappayid':$("input[name='cashbankappayid']").val(),
      'accountid':$("input[name='accountid']").val(),
      'amountdet':$("input[name='amountdet']").val(),
      'currencydetid':$("input[name='currencydetid']").val(),
      'currencydetrate':$("input[name='currencydetrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcashbankappay').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankappayList");
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'cashbankap/approve',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'cashbankap/delete',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'cashbankap/purge','data':{'id':$id},
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
function purgedatacashbankapinv()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'cashbankap/purgecashbankapinv','data':{'id':$.fn.yiiGridView.getSelection("cashbankapinvList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankapinvList");
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
function purgedatacashbankappay()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'cashbankap/purgecashbankappay','data':{'id':$.fn.yiiGridView.getSelection("cashbankappayList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankappayList");
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
		'cashbankapid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'payreqno':$("input[name='dlg_search_payreqno']").val(),
		'cashbankapno':$("input[name='dlg_search_cashbankapno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cashbankapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&payreqno='+$("input[name='dlg_search_payreqno']").val()
+ '&cashbankapno='+$("input[name='dlg_search_cashbankapno']").val();
	window.open('cashbankap/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cashbankapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&payreqno='+$("input[name='dlg_search_payreqno']").val()
+ '&cashbankapno='+$("input[name='dlg_search_cashbankapno']").val();
	window.open('cashbankap/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cashbankapid='+$id
$.fn.yiiGridView.update("DetailcashbankapinvList",{data:array});
$.fn.yiiGridView.update("DetailcashbankappayList",{data:array});
} 

function generatecbpay()
{
	jQuery.ajax({'url':'cashbankap/generatecbpay',
		'data':{'id':$("input[name='payrequestid']").val(),
		'hid':$("input[name='cashbankapid']").val(),},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankapinvList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});
}