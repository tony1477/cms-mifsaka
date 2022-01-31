if("undefined"==typeof jQuery)throw new Error("Goods Receipt's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'grheader/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grheader_0_grheaderid']").val(data.grheaderid);
			$("input[name='grheader_0_grdate']").val(data.grdate);
      $("textarea[name='grheader_0_headernote']").val('');
			$.fn.yiiGridView.update('grdetailList',{data:{'grheaderid':data.grheaderid}});

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
function newdatagrdetail()
{
	jQuery.ajax({'url':'grheader/creategrdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grdetail_1_productid']").val('');
      $("input[name='grdetail_1_qty']").val(data.qty);
      $("input[name='grdetail_1_unitofmeasureid']").val('');
      $("input[name='grdetail_1_slocid']").val('');
      $("input[name='grdetail_1_storagebinid']").val('');
      $("textarea[name='grdetail_1_itemtext']").val('');
      $("input[name='grdetail_1_productname']").val('');
      $("input[name='grdetail_1_uomcode']").val('');
      $("input[name='grdetail_1_sloccode']").val('');
      $("input[name='grdetail_1_description']").val('');
			$('#InputDialoggrdetail').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function getalldata(){
    jQuery.ajax({
		'url': 'grheader/getdatagrheader',
		'data': {'grheaderid':$("input[name='grheader_0_grheaderid']").val()},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='fullname']").val(data.fullname);
				$("input[name='pono']").val(data.pono);
				$("input[name='grdate']").val(data.grdate);
				$("input[name='headernote']").val(data.taxid);
				
                $.fn.yiiGridView.update('grdetailList',{data:{'grheaderid':data.grheaderid}});
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

function check_grdetail(){
    jQuery.ajax({'url':'inventory/grheader/checkgrheadaer',
		'data':{
			'grheaderid':$("input[name='grheader_0_grheaderid']").val(),
            },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function updatedata($id)
{
	jQuery.ajax({'url':'grheader/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='grheader_0_grheaderid']").val(data.grheaderid);
				$("input[name='grheader_0_grdate']").val(data.grdate);
      $("textarea[name='grheader_0_headernote']").val(data.headernote);
				$.fn.yiiGridView.update('grdetailList',{data:{'grheaderid':data.grheaderid}});

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
function updatedatagrdetail($id)
{
	jQuery.ajax({'url':'grheader/updategrdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='grdetail_1_productid']").val(data.productid);
      $("input[name='grdetail_1_qty']").val(data.qty);
      $("input[name='grdetail_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='grdetail_1_slocid']").val(data.slocid);
      $("input[name='grdetail_1_storagebinid']").val(data.storagebinid);
      $("textarea[name='grdetail_1_itemtext']").val(data.itemtext);
      $("input[name='grdetail_1_productname']").val(data.productname);
      $("input[name='grdetail_1_uomcode']").val(data.uomcode);
      $("input[name='grdetail_1_sloccode']").val(data.sloccode);
      $("input[name='grdetail_1_description']").val(data.description);
			$('#InputDialoggrdetail').modal();
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

	jQuery.ajax({'url':'grheader/save',
		'data':{
			'grheaderid':$("input[name='grheader_0_grheaderid']").val(),
			'grdate':$("input[name='grheader_0_grdate']").val(),
			'poheaderid':$("input[name='grheader_0_poheaderid']").val(),
      'headernote':$("textarea[name='grheader_0_headernote']").val(),
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

function savedatagrdetail()
{

	jQuery.ajax({'url':'grheader/savegrdetail',
		'data':{
			'grheaderid':$("input[name='grheader_0_grheaderid']").val(),
			'productid':$("input[name='grdetail_1_productid']").val(),
      'qty':$("input[name='grdetail_1_qty']").val(),
      'unitofmeasureid':$("input[name='grdetail_1_unitofmeasureid']").val(),
      'slocid':$("input[name='grdetail_1_slocid']").val(),
      'storagebinid':$("input[name='grdetail_1_storagebinid']").val(),
      'itemtext':$("textarea[name='grdetail_1_itemtext']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoggrdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("grdetailList");
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
	jQuery.ajax({'url':'grheader/approve',
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
	jQuery.ajax({'url':'grheader/delete',
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
	jQuery.ajax({'url':'grheader/purge','data':{'id':$id},
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
function purgedatagrdetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'grheader/purgegrdetail','data':{'id':$.fn.yiiGridView.getSelection("grdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("grdetailList");
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
		'grheaderid':$id,
		'grno':$("input[name='dlg_search_grno']").val(),
		'pono':$("input[name='dlg_search_pono']").val(),
		'headernote':$("input[name='dlg_search_headernote']").val()
	}});
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'grheaderid='+$id
+ '&grno='+$("input[name='dlg_search_grno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('grheader/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'grheaderid='+$id
+ '&grno='+$("input[name='dlg_search_grno']").val()
+ '&pono='+$("input[name='dlg_search_pono']").val()
+ '&headernote='+$("input[name='dlg_search_headernote']").val();
	window.open('grheader/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'grheaderid='+$id
$.fn.yiiGridView.update("DetailgrdetailList",{data:array});
} 

function generatefr()
{
	jQuery.ajax({'url':'grheader/generatefr',
		'data':{
			'id':$("input[name='deliveryadviceid']").val(),
			'hid':$("input[name='prheaderid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("prmaterialList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}