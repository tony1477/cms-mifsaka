if("undefined"==typeof jQuery)throw new Error("Invoice AP's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'invoiceap/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapid']").val(data.invoiceapid);
			$("input[name='actiontype']").val(0);
			$("input[name='companyid']").val(data.companyid);
      $("input[name='invoicedate']").val(data.invoicedate);
      $("input[name='receiptdate']").val(data.receiptdate);
      $("input[name='poheaderid']").val('');
      $("input[name='addressbookid']").val('');
      $("input[name='taxno']").val('');
      $("input[name='invoiceno']").val('');
      $("input[name='taxdate']").val(data.taxdate);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='taxid']").val('');
      $("input[name='paymentmethodid']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='pono']").val('');
      $("input[name='supplier']").val('');
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='taxcode']").val('');
      $("input[name='paycode']").val('');
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
	jQuery.ajax({'url':'invoiceap/createinvoiceapmat','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapmatid']").val('');
      $("input[name='productid']").val('');
      $("input[name='uomid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
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
	jQuery.ajax({'url':'invoiceap/createinvoiceapjurnal','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapjurnalid']").val('');
      $("input[name='accountid']").val('');
      $("input[name='debet']").val(data.debet);
      $("input[name='credit']").val(data.credit);
      $("input[name='currencydetid']").val('');
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='description']").val('');
      $("input[name='accountcode']").val('');
      $("input[name='currencyname']").val('');
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
	jQuery.ajax({'url':'invoiceap/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='invoiceapid']").val(data.invoiceapid);
				$("input[name='actiontype']").val(1);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='invoicedate']").val(data.invoicedate);
      $("input[name='receiptdate']").val(data.receiptdate);
      $("input[name='poheaderid']").val(data.poheaderid);
      $("input[name='addressbookid']").val(data.addressbookid);
      $("input[name='invoiceno']").val(data.invoiceno);
      $("input[name='taxno']").val(data.taxno);
      $("input[name='taxdate']").val(data.taxdate);
      $("input[name='amount']").val(data.amount);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyrate']").val(data.currencyrate);
      $("input[name='taxid']").val(data.taxid);
      $("input[name='paymentmethodid']").val(data.paymentmethodid);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='pono']").val(data.pono);
      $("input[name='supplier']").val(data.supplier);
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='taxcode']").val(data.taxcode);
      $("input[name='paycode']").val(data.paycode);
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
	jQuery.ajax({'url':'invoiceap/updateinvoiceapmat','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapmatid']").val(data.invoiceapmatid);
      $("input[name='productid']").val(data.productid);
      $("input[name='uomid']").val(data.uomid);
      $("input[name='qty']").val(data.qty);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
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
	jQuery.ajax({'url':'invoiceap/updateinvoiceapjurnal','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceapjurnalid']").val(data.invoiceapjurnalid);
      $("input[name='accountid']").val(data.accountid);
      $("input[name='debet']").val(data.debet);
      $("input[name='credit']").val(data.credit);
      $("input[name='currencydetid']").val(data.currencydetid);
      $("input[name='currencydetrate']").val(data.currencydetrate);
      $("input[name='description']").val(data.description);
      $("input[name='accountcode']").val(data.accountcode);
      $("input[name='currencyname']").val(data.currencyname);
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

	jQuery.ajax({'url':'invoiceap/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'invoiceapid':$("input[name='invoiceapid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'invoicedate':$("input[name='invoicedate']").val(),
      'receiptdate':$("input[name='receiptdate']").val(),
      'poheaderid':$("input[name='poheaderid']").val(),
      'addressbookid':$("input[name='addressbookid']").val(),
      'invoiceno':$("input[name='invoiceno']").val(),
      'taxno':$("input[name='taxno']").val(),
      'taxdate':$("input[name='taxdate']").val(),
      'amount':$("input[name='amount']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'currencyrate':$("input[name='currencyrate']").val(),
      'taxid':$("input[name='taxid']").val(),
      'paymentmethodid':$("input[name='paymentmethodid']").val(),
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

function savedatainvoiceapmat()
{

	jQuery.ajax({'url':'invoiceap/saveinvoiceapmat',
		'data':{
			'invoiceapid':$("input[name='invoiceapid']").val(),
			'invoiceapmatid':$("input[name='invoiceapmatid']").val(),
      'productid':$("input[name='productid']").val(),
      'uomid':$("input[name='uomid']").val(),
      'qty':$("input[name='qty']").val(),
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

	jQuery.ajax({'url':'invoiceap/saveinvoiceapjurnal',
		'data':{
			'invoiceapid':$("input[name='invoiceapid']").val(),
			'invoiceapjurnalid':$("input[name='invoiceapjurnalid']").val(),
      'accountid':$("input[name='accountid']").val(),
      'debet':$("input[name='debet']").val(),
      'credit':$("input[name='credit']").val(),
      'currencydetid':$("input[name='currencydetid']").val(),
      'currencydetrate':$("input[name='currencydetrate']").val(),
      'description':$("input[name='description']").val(),
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'invoiceap/approve',
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
	jQuery.ajax({'url':'invoiceap/delete',
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

function generateinvpo()
{
	jQuery.ajax({'url':'invoiceap/generateinvpo',
		'data':{'id':$("input[name='poheaderid']").val(),
		'hid':$("input[name='invoiceapid']").val(),},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressbookid']").val(data.addressbookid);
				$("input[name='supplier']").val(data.supplier);
				$("input[name='paycode']").val(data.paycode);
				$("input[name='paymentmethodid']").val(data.paymentmethodid);
				$("input[name='taxcode']").val(data.taxcode);
				$("input[name='taxid']").val(data.taxid);
				$("input[name='amount']").val(data.amount);
				$.fn.yiiGridView.update("invoiceapjurnalList");
				$.fn.yiiGridView.update("invoiceapmatList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'invoiceap/purge','data':{'id':$id},
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'invoiceap/purgeinvoiceapmat','data':{'id':$.fn.yiiGridView.getSelection("invoiceapmatList")},
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'invoiceap/purgeinvoiceapjurnal','data':{'id':$.fn.yiiGridView.getSelection("invoiceapjurnalList")},
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
	$.fn.yiiGridView.update("GridList",{data:{
		'invoiceapid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'invoiceno':$("input[name='dlg_search_invoiceno']").val(),
		'pono':$("input[name='dlg_search_pono']").val(),
		'supplier':$("input[name='dlg_search_supplier']").val(),
		'taxno':$("input[name='dlg_search_taxno']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
		'taxcode':$("input[name='dlg_search_taxcode']").val(),
		'paycode':$("input[name='dlg_search_paycode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&supplier='+$("input[name='dlg_search_supplier']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val();
	window.open('invoiceap/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'invoiceapid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&invoiceno='+$("input[name='dlg_search_invoiceno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&supplier='+$("input[name='dlg_search_supplier']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&taxcode='+$("input[name='dlg_search_taxcode']").val()
+ '&paycode='+$("input[name='dlg_search_paycode']").val();
	window.open('invoiceap/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'invoiceapid='+$id
$.fn.yiiGridView.update("DetailinvoiceapmatList",{data:array});
$.fn.yiiGridView.update("DetailinvoiceapjurnalList",{data:array});
} 