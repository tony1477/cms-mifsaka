if("undefined"==typeof jQuery)throw new Error("Goods Receipt Return's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'grretur/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grreturid']").val(data.grreturid);
			$("input[name='actiontype']").val(0);
			$("input[name='companyid']").val(data.companyid);
      $("input[name='grreturdate']").val(data.grreturdate);
      $("input[name='grheaderid']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='grno']").val('');
			$.fn.yiiGridView.update('grreturdetailList',{data:{'grreturid':data.grreturid}});

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
function newdatagrreturdetail()
{
	jQuery.ajax({'url':'grretur/creategrreturdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grreturdetailid']").val('');
      $("input[name='productid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val('');
      $("input[name='slocid']").val('');
      $("input[name='storagebinid']").val('');
      $("textarea[name='itemnote']").val('');
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
      $("input[name='sloccode']").val('');
      $("input[name='storagedesc']").val('');
			$('#InputDialoggrreturdetail').modal();
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
	jQuery.ajax({'url':'grretur/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='grreturid']").val(data.grreturid);
				$("input[name='actiontype']").val(1);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='grreturdate']").val(data.grreturdate);
      $("input[name='grheaderid']").val(data.grheaderid);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='grno']").val(data.grno);
				$.fn.yiiGridView.update('grreturdetailList',{data:{'grreturid':data.grreturid}});

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
function updatedatagrreturdetail($id)
{
	jQuery.ajax({'url':'grretur/updategrreturdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grreturdetailid']").val(data.grreturdetailid);
      $("input[name='productid']").val(data.productid);
      $("input[name='qty']").val(data.qty);
      $("input[name='uomid']").val(data.uomid);
      $("input[name='slocid']").val(data.slocid);
      $("input[name='storagebinid']").val(data.storagebinid);
      $("textarea[name='itemnote']").val(data.itemnote);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
      $("input[name='sloccode']").val(data.sloccode);
      $("input[name='storagedesc']").val(data.storagedesc);
			$('#InputDialoggrreturdetail').modal();
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

	jQuery.ajax({'url':'grretur/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'grreturid':$("input[name='grreturid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'grreturdate':$("input[name='grreturdate']").val(),
      'grheaderid':$("input[name='grheaderid']").val(),
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

function savedatagrreturdetail()
{

	jQuery.ajax({'url':'grretur/savegrreturdetail',
		'data':{
			'grreturid':$("input[name='grreturid']").val(),
			'grreturdetailid':$("input[name='grreturdetailid']").val(),
      'productid':$("input[name='productid']").val(),
      'qty':$("input[name='qty']").val(),
      'uomid':$("input[name='uomid']").val(),
      'slocid':$("input[name='slocid']").val(),
      'storagebinid':$("input[name='storagebinid']").val(),
      'itemnote':$("textarea[name='itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoggrreturdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("grreturdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}


function deletedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'grretur/delete',
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

function approvedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'grretur/approve',
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
		'grreturid':$id,
		'grreturno':$("input[name='dlg_search_grreturno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'grno':$("input[name='dlg_search_grno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'grreturid='+$id
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('grretur/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'grreturid='+$id
+ '&grreturno='+$("input[name='dlg_search_grreturno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&grno='+$("input[name='dlg_search_grno']").val();
	window.open('grretur/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'grreturid='+$id
$.fn.yiiGridView.update("DetailgrreturdetailList",{data:array});
} 

function generategrrgr() {
	jQuery.ajax({
			'url': 'grretur/generategrrgr',
			'data': {
				'id':$("input[name='grheaderid']").val(),
				'hid':$("input[name='grreturid']").val(),
			},
			'type': 'post',
			'dataType': 'json',
			'success': function(data) {
			if (data.status == "success")
			{
				$.fn.yiiGridView.update('grreturdetailList',{data:{'grreturid':data.grreturid}});
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}