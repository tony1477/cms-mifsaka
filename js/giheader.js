if("undefined"==typeof jQuery)throw new Error("Goods Issue's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'giheader/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='giheader_0_giheaderid']").val(data.giheaderid);
			$("input[name='giheader_0_gidate']").val(data.gidate);
      $("input[name='giheader_0_soheaderid']").val('');
      $("textarea[name='giheader_0_headernote']").val('');
      $("input[name='giheader_0_sono']").val('');
			$.fn.yiiGridView.update('gidetailList',{data:{'giheaderid':data.giheaderid}});

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
function newdatagidetail()
{
	jQuery.ajax({'url':'giheader/creategidetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gidetail_1_productid']").val('');
      $("input[name='gidetail_1_qty']").val(data.qty);
      $("input[name='gidetail_1_unitofmeasureid']").val('');
      $("input[name='gidetail_1_slocid']").val('');
      $("input[name='gidetail_1_storagebinid']").val('');
      $("textarea[name='gidetail_1_itemnote']").val('');
      $("input[name='gidetail_1_productname']").val('');
      $("input[name='gidetail_1_uomcode']").val('');
      $("input[name='gidetail_1_sloccode']").val('');
      $("input[name='gidetail_1_description']").val('');
			$('#InputDialoggidetail').modal();
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
	jQuery.ajax({'url':'giheader/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='giheader_0_giheaderid']").val(data.giheaderid);
				$("input[name='giheader_0_gidate']").val(data.gidate);
      $("input[name='giheader_0_soheaderid']").val(data.soheaderid);
      $("textarea[name='giheader_0_headernote']").val(data.headernote);
      $("input[name='giheader_0_sono']").val(data.sono);
				$.fn.yiiGridView.update('gidetailList',{data:{'giheaderid':data.giheaderid}});

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
function updatedatagidetail($id)
{
	jQuery.ajax({'url':'giheader/updategidetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='gidetail_1_productid']").val(data.productid);
      $("input[name='gidetail_1_qty']").val(data.qty);
      $("input[name='gidetail_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='gidetail_1_slocid']").val(data.slocid);
      $("input[name='gidetail_1_storagebinid']").val(data.storagebinid);
      $("textarea[name='gidetail_1_itemnote']").val(data.itemnote);
      $("input[name='gidetail_1_productname']").val(data.productname);
      $("input[name='gidetail_1_uomcode']").val(data.uomcode);
      $("input[name='gidetail_1_sloccode']").val(data.sloccode);
      $("input[name='gidetail_1_description']").val(data.description);
			$('#InputDialoggidetail').modal();
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

	jQuery.ajax({'url':'giheader/save',
		'data':{
			'giheaderid':$("input[name='giheader_0_giheaderid']").val(),
			'gidate':$("input[name='giheader_0_gidate']").val(),
      'soheaderid':$("input[name='giheader_0_soheaderid']").val(),
      'headernote':$("textarea[name='giheader_0_headernote']").val(),
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

function savedatagidetail()
{

	jQuery.ajax({'url':'giheader/savegidetail',
		'data':{
			'giheaderid':$("input[name='giheader_0_giheaderid']").val(),
			'productid':$("input[name='gidetail_1_productid']").val(),
      'qty':$("input[name='gidetail_1_qty']").val(),
      'unitofmeasureid':$("input[name='gidetail_1_unitofmeasureid']").val(),
      'slocid':$("input[name='gidetail_1_slocid']").val(),
      'storagebinid':$("input[name='gidetail_1_storagebinid']").val(),
      'itemnote':$("textarea[name='gidetail_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialoggidetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("gidetailList");
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
	jQuery.ajax({'url':'giheader/approve',
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
	jQuery.ajax({'url':'giheader/delete',
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
	jQuery.ajax({'url':'giheader/purge','data':{'id':$id},
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
function purgedatagidetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'giheader/purgegidetail','data':{'id':$.fn.yiiGridView.getSelection("gidetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("gidetailList");
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
	var array = 'giheaderid='+$id
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&gidate='+$("input[name='dlg_search_gidate']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'giheaderid='+$id
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&gidate='+$("input[name='dlg_search_gidate']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('giheader/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'giheaderid='+$id
+ '&gino='+$("input[name='dlg_search_gino']").val()
+ '&gidate='+$("input[name='dlg_search_gidate']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('giheader/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'giheaderid='+$id
$.fn.yiiGridView.update("DetailgidetailList",{data:array});
} 