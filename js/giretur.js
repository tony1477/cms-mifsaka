if("undefined"==typeof jQuery)throw new Error("Goods Issue Return's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'giretur/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gireturid']").val(data.gireturid);
			$("input[name='actiontype']").val(0);
			$("input[name='companyid']").val(data.companyid);
      $("input[name='giheaderid']").val('');
      $("input[name='gireturdate']").val(data.gireturdate);
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='gino']").val('');
			$.fn.yiiGridView.update('gireturdetailList',{data:{'gireturid':data.gireturid}});

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
function newdatagireturdetail()
{
	jQuery.ajax({'url':'giretur/creategireturdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gireturdetailid']").val('');
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
			$('#InputDialoggireturdetail').modal();
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
	jQuery.ajax({'url':'giretur/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='gireturid']").val(data.gireturid);
				$("input[name='actiontype']").val(1);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='giheaderid']").val(data.giheaderid);
      $("input[name='gireturdate']").val(data.gireturdate);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='gino']").val(data.gino);
				$.fn.yiiGridView.update('gireturdetailList',{data:{'gireturid':data.gireturid}});

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
function updatedatagireturdetail($id)
{
	jQuery.ajax({'url':'giretur/updategireturdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gireturdetailid']").val(data.gireturdetailid);
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
			$('#InputDialoggireturdetail').modal();
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

	jQuery.ajax({'url':'giretur/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'gireturid':$("input[name='gireturid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'giheaderid':$("input[name='giheaderid']").val(),
      'gireturdate':$("input[name='gireturdate']").val(),
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

function savedatagireturdetail()
{

	jQuery.ajax({'url':'giretur/savegireturdetail',
		'data':{
			'gireturid':$("input[name='gireturid']").val(),
			'gireturdetailid':$("input[name='gireturdetailid']").val(),
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
				$('#InputDialoggireturdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("gireturdetailList");
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
	jQuery.ajax({'url':'giretur/delete',
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
	jQuery.ajax({'url':'giretur/approve',
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
		'gireturid':$id,
		'gireturno':$("input[name='dlg_search_gireturno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'gino':$("input[name='dlg_search_gino']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'gireturid='+$id
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val();
	window.open('giretur/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'gireturid='+$id
+ '&gireturno='+$("input[name='dlg_search_gireturno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&gino='+$("input[name='dlg_search_gino']").val();
	window.open('giretur/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'gireturid='+$id
$.fn.yiiGridView.update("DetailgireturdetailList",{data:array});
} 

function generategirgi() {
	jQuery.ajax({
			'url': 'giretur/generategirgi',
			'data': {
				'id':$("input[name='giheaderid']").val(),
				'hid':$("input[name='gireturid']").val(),
			},
			'type': 'post',
			'dataType': 'json',
			'success': function(data) {
			if (data.status == "success")
			{
				$.fn.yiiGridView.update('gireturdetailList',{data:{'gireturid':data.gireturid}});
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