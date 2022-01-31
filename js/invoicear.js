if("undefined"==typeof jQuery)throw new Error("Invoice AR's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'invoicear/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoicearid']").val(data.invoicearid);
			$("input[name='actiontype']").val(0);
			$("input[name='invoiceardate']").val(data.invoiceardate);
      $("input[name='invoicearno']").val('');
      $("input[name='companyid']").val(data.companyid);
      $("input[name='soheaderid']").val('');
      $("input[name='taxid']").val('');
      $("input[name='addressbookid']").val('');
      $("input[name='billto']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='sono']").val('');
      $("input[name='taxcode']").val('');
      $("input[name='customer']").val('');
      $("textarea[name='addressname']").val('');
			$.fn.yiiGridView.update('invoiceardetList',{data:{'invoicearid':data.invoicearid}});

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
function newdatainvoiceardet()
{
	jQuery.ajax({'url':'invoicear/createinvoiceardet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceardetid']").val('');
      $("input[name='productid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val('');
      $("input[name='price']").val(data.price);
      $("textarea[name='itemnote']").val('');
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
			$('#InputDialoginvoiceardet').modal();
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
	jQuery.ajax({'url':'invoicear/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='invoicearid']").val(data.invoicearid);
				$("input[name='actiontype']").val(1);
				$("input[name='invoiceardate']").val(data.invoiceardate);
      $("input[name='invoicearno']").val(data.invoicearno);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='soheaderid']").val(data.soheaderid);
      $("input[name='taxid']").val(data.taxid);
      $("input[name='addressbookid']").val(data.addressbookid);
      $("input[name='billto']").val(data.billto);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='sono']").val(data.sono);
      $("input[name='taxcode']").val(data.taxcode);
      $("input[name='customer']").val(data.customer);
      $("textarea[name='addressname']").val(data.addressname);
				$.fn.yiiGridView.update('invoiceardetList',{data:{'invoicearid':data.invoicearid}});

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
function updatedatainvoiceardet($id)
{
	jQuery.ajax({'url':'invoicear/updateinvoiceardet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='invoiceardetid']").val(data.invoiceardetid);
      $("input[name='productid']").val(data.productid);
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val(data.uomid);
      $("input[name='price']").val(data.price);
      $("textarea[name='itemnote']").val(data.itemnote);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
			$('#InputDialoginvoiceardet').modal();
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

	jQuery.ajax({'url':'invoicear/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'invoicearid':$("input[name='invoicearid']").val(),
			'invoiceardate':$("input[name='invoiceardate']").val(),
      'invoicearno':$("input[name='invoicearno']").val(),
      'companyid':$("input[name='companyid']").val(),
      'soheaderid':$("input[name='soheaderid']").val(),
      'taxid':$("input[name='taxid']").val(),
      'addressbookid':$("input[name='addressbookid']").val(),
      'billto':$("input[name='billto']").val(),
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

function savedatainvoiceardet()
{

	jQuery.ajax({'url':'invoicear/saveinvoiceardet',
		'data':{
			'invoicearid':$("input[name='invoicearid']").val(),
			'invoiceardetid':$("input[name='invoiceardetid']").val(),
      'productid':$("input[name='productid']").val(),
      'qty':$("input[name='qty']").val(),
      'uomid':$("input[name='uomid']").val(),
      'price':$("input[name='price']").val(),
      'itemnote':$("textarea[name='itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoginvoiceardet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceardetList");
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
	jQuery.ajax({'url':'invoicear/approve',
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
	jQuery.ajax({'url':'invoicear/delete',
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
	jQuery.ajax({'url':'invoicear/purge','data':{'id':$id},
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
function purgedatainvoiceardet()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'invoicear/purgeinvoiceardet','data':{'id':$.fn.yiiGridView.getSelection("invoiceardetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("invoiceardetList");
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
		'invoicearid':$id,
		'invoicearno':$("input[name='dlg_search_invoicearno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'sono':$("input[name='dlg_search_sono']").val(),
		'customer':$("input[name='dlg_search_customer']").val(),
		'addressname':$("input[name='dlg_search_addressname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'invoicearid='+$id
+ '&invoicearno='+$("input[name='dlg_search_invoicearno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&customer='+$("input[name='dlg_search_customer']").val()
+ '&addressname='+$("input[name='dlg_search_addressname']").val();
	window.open('invoicear/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'invoicearid='+$id
+ '&invoicearno='+$("input[name='dlg_search_invoicearno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&customer='+$("input[name='dlg_search_customer']").val()
+ '&addressname='+$("input[name='dlg_search_addressname']").val();
	window.open('invoicear/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'invoicearid='+$id
$.fn.yiiGridView.update("DetailinvoiceardetList",{data:array});
} 

function generateinvso()
{
	jQuery.ajax({'url':'invoicear/generateinvso',
		'data':{'id':$("input[name='soheaderid']").val(),
		'hid':$("input[name='invoicearid']").val(),},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressbookid']").val(data.addressbookid);
				$("input[name='customer']").val(data.customer);
				$("input[name='taxcode']").val(data.taxcode);
				$("input[name='taxid']").val(data.taxid);
				$("input[name='billto']").val(data.billto);
				$("textarea[name='addressname']").val(data.addressname);
				$.fn.yiiGridView.update("invoiceardetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});
}