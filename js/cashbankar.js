if("undefined"==typeof jQuery)throw new Error("Cash Bank AR's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'cashbankar/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankarid']").val(data.cashbankarid);
			$("input[name='actiontype']").val(0);
			$("input[name='cashbankardate']").val(data.cashbankardate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='invoicearid']").val('');
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='invoicearno']").val('');
      $("input[name='currencyname']").val(data.currencyname);
			$.fn.yiiGridView.update('cashbankardetList',{data:{'cashbankarid':data.cashbankarid}});

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
function newdatacashbankardet()
{
	jQuery.ajax({'url':'cashbankar/createcashbankardet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankardetid']").val('');
      $("input[name='accountid']").val('');
      $("input[name='amountdet']").val(data.amountdet);
      $("input[name='currencydetid']").val(data.currencydetid);
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='accountcode']").val('');
      $("input[name='currencydetname']").val(data.currencydetname);
			$('#InputDialogcashbankardet').modal();
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
	jQuery.ajax({'url':'cashbankar/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cashbankarid']").val(data.cashbankarid);
				$("input[name='actiontype']").val(1);
				$("input[name='cashbankardate']").val(data.cashbankardate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='invoicearid']").val(data.invoicearid);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='invoicearno']").val(data.invoicearno);
      $("input[name='currencyname']").val(data.currencyname);
				$.fn.yiiGridView.update('cashbankardetList',{data:{'cashbankarid':data.cashbankarid}});

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
function updatedatacashbankardet($id)
{
	jQuery.ajax({'url':'cashbankar/updatecashbankardet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankardetid']").val(data.cashbankardetid);
      $("input[name='accountid']").val(data.accountid);
      $("input[name='amountdet']").val(data.amountdet);
      $("input[name='currencydetid']").val(data.currencydetid);
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='accountcode']").val(data.accountcode);
      $("input[name='currencydetname']").val(data.currencydetname);
			$('#InputDialogcashbankardet').modal();
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

	jQuery.ajax({'url':'cashbankar/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'cashbankarid':$("input[name='cashbankarid']").val(),
			'cashbankardate':$("input[name='cashbankardate']").val(),
      'companyid':$("input[name='companyid']").val(),
      'invoicearid':$("input[name='invoicearid']").val(),
      'amount':$("input[name='amount']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
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

function savedatacashbankardet()
{

	jQuery.ajax({'url':'cashbankar/savecashbankardet',
		'data':{
			'cashbankarid':$("input[name='cashbankarid']").val(),
			'cashbankardetid':$("input[name='cashbankardetid']").val(),
      'accountid':$("input[name='accountid']").val(),
      'amountdet':$("input[name='amountdet']").val(),
      'currencydetid':$("input[name='currencydetid']").val(),
      'currencydetrate':$("input[name='currencydetrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcashbankardet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankardetList");
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
	jQuery.ajax({'url':'cashbankar/approve',
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
	jQuery.ajax({'url':'cashbankar/delete',
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


function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'cashbankarid':$id,
		'cashbankarno':$("input[name='dlg_search_cashbankarno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'invoicearno':$("input[name='dlg_search_invoicearno']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cashbankarid='+$id
+ '&cashbankarno='+$("input[name='dlg_search_cashbankarno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoicearno='+$("input[name='dlg_search_invoicearno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('cashbankar/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cashbankarid='+$id
+ '&cashbankarno='+$("input[name='dlg_search_cashbankarno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoicearno='+$("input[name='dlg_search_invoicearno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('cashbankar/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cashbankarid='+$id
$.fn.yiiGridView.update("DetailcashbankardetList",{data:array});
} 

function generateinvcbar()
{
	jQuery.ajax({'url':'cashbankar/generateinvcbar',
		'data':{'id':$("input[name='invoicearid']").val(),
		'hid':$("input[name='cashbankarid']").val(),},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='amount']").val(data.amount);
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});
}