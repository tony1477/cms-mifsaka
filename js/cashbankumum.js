if("undefined"==typeof jQuery)throw new Error("General Cash Bank's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'cashbankumum/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankuid']").val(data.cashbankuid);
			$("input[name='actiontype']").val(0);
			$("input[name='cashbankudate']").val(data.cashbankudate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='referenceno']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
			$.fn.yiiGridView.update('cashbankudetList',{data:{'cashbankuid':data.cashbankuid}});

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
function newdatacashbankudet()
{
	jQuery.ajax({'url':'cashbankumum/createcashbankudet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankudetid']").val('');
      $("input[name='accountid']").val('');
      $("input[name='debet']").val(data.debet);
      $("input[name='credit']").val(data.credit);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='accountcode']").val('');
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogcashbankudet').modal();
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
	jQuery.ajax({'url':'cashbankumum/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cashbankuid']").val(data.cashbankuid);
				$("input[name='actiontype']").val(1);
				$("input[name='cashbankudate']").val(data.cashbankudate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='referenceno']").val(data.referenceno);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
				$.fn.yiiGridView.update('cashbankudetList',{data:{'cashbankuid':data.cashbankuid}});

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
function updatedatacashbankudet($id)
{
	jQuery.ajax({'url':'cashbankumum/updatecashbankudet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cashbankudetid']").val(data.cashbankudetid);
      $("input[name='accountid']").val(data.accountid);
      $("input[name='debet']").val(data.debet);
      $("input[name='credit']").val(data.credit);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='accountcode']").val(data.accountcode);
      $("input[name='currencyname']").val(data.currencyname);
			$('#InputDialogcashbankudet').modal();
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

	jQuery.ajax({'url':'cashbankumum/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'cashbankuid':$("input[name='cashbankuid']").val(),
			'cashbankudate':$("input[name='cashbankudate']").val(),
      'companyid':$("input[name='companyid']").val(),
      'referenceno':$("input[name='referenceno']").val(),
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

function savedatacashbankudet()
{

	jQuery.ajax({'url':'cashbankumum/savecashbankudet',
		'data':{
			'cashbankuid':$("input[name='cashbankuid']").val(),
			'cashbankudetid':$("input[name='cashbankudetid']").val(),
      'accountid':$("input[name='accountid']").val(),
      'debet':$("input[name='debet']").val(),
      'credit':$("input[name='credit']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcashbankudet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankudetList");
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
	jQuery.ajax({'url':'cashbankumum/approve',
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
	jQuery.ajax({'url':'cashbankumum/delete',
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

function purgedatacashbankudet($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'cashbankumum/purgedatacashbankudet',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cashbankudetList");
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
		'cashbankuid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'referenceno':$("input[name='dlg_search_referenceno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'cashbankuid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('cashbankumum/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cashbankuid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('cashbankumum/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cashbankuid='+$id
$.fn.yiiGridView.update("DetailcashbankudetList",{data:array});
} 