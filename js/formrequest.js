if("undefined"==typeof jQuery)throw new Error("Form Request's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'formrequest/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='formrequestid']").val(data.formrequestid);
			$("input[name='actiontype']").val(0);
			$("input[name='frdate']").val(data.frdate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='slocid']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='productplanno']").val('');
      $("input[name='sloccode']").val('');
			$.fn.yiiGridView.update('formrequestdetList',{data:{'formrequestid':data.formrequestid}});

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
function newdataformrequestdet()
{
	jQuery.ajax({'url':'formrequest/createformrequestdet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='formrequestdetid']").val('');
      $("input[name='productid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='unitofmeasureid']").val('');
      $("textarea[name='itemtext']").val('');
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
      $("input[name='slocdetid']").val('');
      $("input[name='sloccodetdet']").val('');
			$('#InputDialogformrequestdet').modal();
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
	jQuery.ajax({'url':'formrequest/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='formrequestid']").val(data.formrequestid);
				$("input[name='actiontype']").val(1);
				$("input[name='frdate']").val(data.frdate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='slocid']").val(data.slocid);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='productplanno']").val(data.productplanno);
      $("input[name='sloccode']").val(data.sloccode);
				$.fn.yiiGridView.update('formrequestdetList',{data:{'formrequestid':data.formrequestid}});

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
function updatedataformrequestdet($id)
{
	jQuery.ajax({'url':'formrequest/updateformrequestdet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='formrequestdetid']").val(data.formrequestdetid);
      $("input[name='productid']").val(data.productid);
      $("input[name='qty']").val(data.qty);
      $("input[name='unitofmeasureid']").val(data.unitofmeasureid);
      $("textarea[name='itemtext']").val(data.itemtext);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
      $("input[name='slocdetid']").val(data.slocid);
      $("input[name='sloccodedet']").val(data.sloccode);
			$('#InputDialogformrequestdet').modal();
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

	jQuery.ajax({'url':'formrequest/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'formrequestid':$("input[name='formrequestid']").val(),
			'frdate':$("input[name='frdate']").val(),
      'companyid':$("input[name='companyid']").val(),
      'slocid':$("input[name='slocid']").val(),
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

function savedataformrequestdet()
{

	jQuery.ajax({'url':'formrequest/saveformrequestdet',
		'data':{
			'formrequestid':$("input[name='formrequestid']").val(),
			'formrequestdetid':$("input[name='formrequestdetid']").val(),
      'productid':$("input[name='productid']").val(),
      'qty':$("input[name='qty']").val(),
      'unitofmeasureid':$("input[name='unitofmeasureid']").val(),
      'itemtext':$("textarea[name='itemtext']").val(),
      'slocid':$("input[name='slocdetid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogformrequestdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("formrequestdetList");
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
	jQuery.ajax({'url':'formrequest/approve',
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
	jQuery.ajax({'url':'formrequest/delete',
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
	jQuery.ajax({'url':'formrequest/purge','data':{'id':$id},
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
function purgedataformrequestdet()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'formrequest/purgeformrequestdet','data':{'id':$.fn.yiiGridView.getSelection("formrequestdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("formrequestdetList");
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
		'formrequestid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'frno':$("input[name='dlg_search_frno']").val(),
		'productplanno':$("input[name='dlg_search_productplanno']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'formrequestid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&frno='+$("input[name='dlg_search_frno']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('formrequest/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'formrequestid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&frno='+$("input[name='dlg_search_frno']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('formrequest/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'formrequestid='+$id
$.fn.yiiGridView.update("DetailformrequestdetList",{data:array});
} 

function getproductplant() {
	jQuery.ajax({
		'url': 'productplant/getproductplant',
		'data': {
						'productid':$("input[name='productid']").val(),
						'slocid':$("input[name='slocid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='unitofmeasureid']").val(data.uomid);
				$("input[name='uomcode']").val(data.uomcode);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
}