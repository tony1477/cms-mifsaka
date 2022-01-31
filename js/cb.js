if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'cb/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cb_0_cbid']").val(data.cbid);
			$("input[name='cb_0_docdate']").val(data.docdate);
      $("input[name='cb_0_companyid']").val('');
      $("input[name='cb_0_receiptno']").val('');
      $("input[name='cb_0_isin']").prop('checked',true);
      $("textarea[name='cb_0_headernote']").val('');
      $("input[name='cb_0_companyname']").val('');
			$.fn.yiiGridView.update('cbaccList',{data:{'cbid':data.cbid}});
$.fn.yiiGridView.update('chequeList',{data:{'cbid':data.cbid}});
$.fn.yiiGridView.update('bankList',{data:{'cbid':data.cbid}});

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
function newdatacbacc()
{
	jQuery.ajax({'url':'cb/createcbacc','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbacc_1_debitaccid']").val('');
      $("input[name='cbacc_1_creditaccid']").val('');
      $("input[name='cbacc_1_amount']").val(data.amount);
      $("input[name='cbacc_1_currencyid']").val(data.currencyid);
      $("input[name='cbacc_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbacc_1_chequeid']").val('');
      $("input[name='cbacc_1_tglcair']").val(data.tglcair);
      $("input[name='cbacc_1_tgltolak']").val(data.tgltolak);
      $("input[name='cbacc_1_description']").val('');
      $("input[name='cbacc_1_accountname']").val('');
      $("input[name='cbacc_1_accountname']").val('');
      $("input[name='cbacc_1_currencyname']").val('');
      $("input[name='cbacc_1_chequeno']").val('');
			$('#InputDialogcbacc').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatacheque()
{
	jQuery.ajax({'url':'cb/createcheque','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cheque_2_companyid']").val('');
      $("input[name='cheque_2_tglbayar']").val(data.tglbayar);
      $("input[name='cheque_2_chequeno']").val('');
      $("input[name='cheque_2_bankid']").val('');
      $("input[name='cheque_2_amount']").val(data.amount);
      $("input[name='cheque_2_currencyid']").val(data.currencyid);
      $("input[name='cheque_2_currencyrate']").val(data.currencyrate);
      $("input[name='cheque_2_tglcheque']").val(data.tglcheque);
      $("input[name='cheque_2_tgltempo']").val(data.tgltempo);
      $("input[name='cheque_2_tglcair']").val(data.tglcair);
      $("input[name='cheque_2_tgltolak']").val(data.tgltolak);
      $("input[name='cheque_2_addressbookid']").val('');
      $("input[name='cheque_2_iscustomer']").prop('checked',true);
      $("input[name='cheque_2_companyname']").val('');
      $("input[name='cheque_2_bankname']").val('');
      $("input[name='cheque_2_currencyname']").val(data.currencyname);
      $("input[name='cheque_2_fullname']").val('');
			$('#InputDialogcheque').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdatabank()
{
	jQuery.ajax({'url':'cb/createbank','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bank_3_bankname']").val('');
			$('#InputDialogbank').modal();
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
	jQuery.ajax({'url':'cb/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='cb_0_cbid']").val(data.cbid);
				$("input[name='cb_0_docdate']").val(data.docdate);
      $("input[name='cb_0_companyid']").val(data.companyid);
      $("input[name='cb_0_receiptno']").val(data.receiptno);
      if (data.isin == 1)
			{
				$("input[name='cb_0_isin']").prop('checked',true);
			}
			else
			{
				$("input[name='cb_0_isin']").prop('checked',false)
			}
      $("textarea[name='cb_0_headernote']").val(data.headernote);
      $("input[name='cb_0_companyname']").val(data.companyname);
				$.fn.yiiGridView.update('cbaccList',{data:{'cbid':data.cbid}});
$.fn.yiiGridView.update('chequeList',{data:{'cbid':data.cbid}});
$.fn.yiiGridView.update('bankList',{data:{'cbid':data.cbid}});

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
function updatedatacbacc($id)
{
	jQuery.ajax({'url':'cb/updatecbacc','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cbacc_1_debitaccid']").val(data.debitaccid);
      $("input[name='cbacc_1_creditaccid']").val(data.creditaccid);
      $("input[name='cbacc_1_amount']").val(data.amount);
      $("input[name='cbacc_1_currencyid']").val(data.currencyid);
      $("input[name='cbacc_1_currencyrate']").val(data.currencyrate);
      $("input[name='cbacc_1_chequeid']").val(data.chequeid);
      $("input[name='cbacc_1_tglcair']").val(data.tglcair);
      $("input[name='cbacc_1_tgltolak']").val(data.tgltolak);
      $("input[name='cbacc_1_description']").val(data.description);
      $("input[name='cbacc_1_accountname']").val(data.accountname);
      $("input[name='cbacc_1_accountname']").val(data.accountname);
      $("input[name='cbacc_1_currencyname']").val(data.currencyname);
      $("input[name='cbacc_1_chequeno']").val(data.chequeno);
			$('#InputDialogcbacc').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatacheque($id)
{
	jQuery.ajax({'url':'cb/updatecheque','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='cheque_2_companyid']").val(data.companyid);
      $("input[name='cheque_2_tglbayar']").val(data.tglbayar);
      $("input[name='cheque_2_chequeno']").val(data.chequeno);
      $("input[name='cheque_2_bankid']").val(data.bankid);
      $("input[name='cheque_2_amount']").val(data.amount);
      $("input[name='cheque_2_currencyid']").val(data.currencyid);
      $("input[name='cheque_2_currencyrate']").val(data.currencyrate);
      $("input[name='cheque_2_tglcheque']").val(data.tglcheque);
      $("input[name='cheque_2_tgltempo']").val(data.tgltempo);
      $("input[name='cheque_2_tglcair']").val(data.tglcair);
      $("input[name='cheque_2_tgltolak']").val(data.tgltolak);
      $("input[name='cheque_2_addressbookid']").val(data.addressbookid);
      if (data.iscustomer == 1)
			{
				$("input[name='cheque_2_iscustomer']").prop('checked',true);
			}
			else
			{
				$("input[name='cheque_2_iscustomer']").prop('checked',false)
			}
      $("input[name='cheque_2_companyname']").val(data.companyname);
      $("input[name='cheque_2_bankname']").val(data.bankname);
      $("input[name='cheque_2_currencyname']").val(data.currencyname);
      $("input[name='cheque_2_fullname']").val(data.fullname);
			$('#InputDialogcheque').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedatabank($id)
{
	jQuery.ajax({'url':'cb/updatebank','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bank_3_bankname']").val(data.bankname);
			$('#InputDialogbank').modal();
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
var isin = 0;
	if ($("input[name='cb_0_isin']").prop('checked'))
	{
		isin = 1;
	}
	else
	{
		isin = 0;
	}
	jQuery.ajax({'url':'cb/save',
		'data':{
			'cbid':$("input[name='cb_0_cbid']").val(),
			'docdate':$("input[name='cb_0_docdate']").val(),
      'companyid':$("input[name='cb_0_companyid']").val(),
      'receiptno':$("input[name='cb_0_receiptno']").val(),
      'isin':isin,
      'headernote':$("textarea[name='cb_0_headernote']").val(),
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

function savedatacbacc()
{

	jQuery.ajax({'url':'cb/savecbacc',
		'data':{
			'cbid':$("input[name='cb_0_cbid']").val(),
			'debitaccid':$("input[name='cbacc_1_debitaccid']").val(),
      'creditaccid':$("input[name='cbacc_1_creditaccid']").val(),
      'amount':$("input[name='cbacc_1_amount']").val(),
      'currencyid':$("input[name='cbacc_1_currencyid']").val(),
      'currencyrate':$("input[name='cbacc_1_currencyrate']").val(),
      'chequeid':$("input[name='cbacc_1_chequeid']").val(),
      'tglcair':$("input[name='cbacc_1_tglcair']").val(),
      'tgltolak':$("input[name='cbacc_1_tgltolak']").val(),
      'description':$("input[name='cbacc_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcbacc').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbaccList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatacheque()
{
var iscustomer = 0;
	if ($("input[name='cheque_2_iscustomer']").prop('checked'))
	{
		iscustomer = 1;
	}
	else
	{
		iscustomer = 0;
	}
	jQuery.ajax({'url':'cb/savecheque',
		'data':{
			'cbid':$("input[name='cb_0_cbid']").val(),
			'companyid':$("input[name='cheque_2_companyid']").val(),
      'tglbayar':$("input[name='cheque_2_tglbayar']").val(),
      'chequeno':$("input[name='cheque_2_chequeno']").val(),
      'bankid':$("input[name='cheque_2_bankid']").val(),
      'amount':$("input[name='cheque_2_amount']").val(),
      'currencyid':$("input[name='cheque_2_currencyid']").val(),
      'currencyrate':$("input[name='cheque_2_currencyrate']").val(),
      'tglcheque':$("input[name='cheque_2_tglcheque']").val(),
      'tgltempo':$("input[name='cheque_2_tgltempo']").val(),
      'tglcair':$("input[name='cheque_2_tglcair']").val(),
      'tgltolak':$("input[name='cheque_2_tgltolak']").val(),
      'addressbookid':$("input[name='cheque_2_addressbookid']").val(),
      'iscustomer':iscustomer,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogcheque').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("chequeList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedatabank()
{

	jQuery.ajax({'url':'cb/savebank',
		'data':{
			'cbid':$("input[name='cb_0_cbid']").val(),
			'bankname':$("input[name='bank_3_bankname']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogbank').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("bankList");
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'cb/approve',
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'cb/delete',
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'cb/purge','data':{'id':$id},
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
function purgedatacbacc()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'cb/purgecbacc','data':{'id':$.fn.yiiGridView.getSelection("cbaccList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("cbaccList");
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
function purgedatacheque()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'cb/purgecheque','data':{'id':$.fn.yiiGridView.getSelection("chequeList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("chequeList");
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
function purgedatabank()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'cb/purgebank','data':{'id':$.fn.yiiGridView.getSelection("bankList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("bankList");
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
	var array = 'cbid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankno='+$("input[name='dlg_search_cashbankno']").val()
+ '&receiptno='+$("input[name='dlg_search_receiptno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'cbid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankno='+$("input[name='dlg_search_cashbankno']").val()
+ '&receiptno='+$("input[name='dlg_search_receiptno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('cb/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'cbid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&cashbankno='+$("input[name='dlg_search_cashbankno']").val()
+ '&receiptno='+$("input[name='dlg_search_receiptno']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('cb/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'cbid='+$id
$.fn.yiiGridView.update("DetailcbaccList",{data:array});
$.fn.yiiGridView.update("DetailchequeList",{data:array});
$.fn.yiiGridView.update("DetailbankList",{data:array});
} 