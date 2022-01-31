if("undefined"==typeof jQuery)throw new Error("Production Output's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'productoutput/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productoutput_0_productoutputid']").val(data.productoutputid);
			$("input[name='productoutput_0_productoutputdate']").val(data.productoutputdate);
      $("input[name='productoutput_0_productplanid']").val('');
      $("textarea[name='productoutput_0_description']").val('');
      $("input[name='productoutput_0_recordstatus']").val(data.recordstatus);
      $("input[name='productoutput_0_productplanno']").val('');
			$.fn.yiiGridView.update('productoutputfgList',{data:{'productoutputid':data.productoutputid}});
$.fn.yiiGridView.update('productoutputdetailList',{data:{'productoutputid':data.productoutputid}});

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
function newdataproductoutputfg()
{
	jQuery.ajax({'url':'productoutput/createproductoutputfg','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productoutputfg_1_productoutputfgid']").val('');
      $("input[name='productoutputfg_1_productplanfgid']").val('');
      $("input[name='productoutputfg_1_productid']").val('');
      $("input[name='productoutputfg_1_qtyoutput']").val(data.qtyoutput);
      $("input[name='productoutputfg_1_uomid']").val('');
      $("input[name='productoutputfg_1_slocid']").val('');
      $("input[name='productoutputfg_1_storagebinid']").val('');
      $("input[name='productoutputfg_1_outputdate']").val(data.outputdate);
      $("textarea[name='productoutputfg_1_description']").val('');
      $("input[name='productoutputfg_1_productname']").val('');
      $("input[name='productoutputfg_1_uomcode']").val('');
      $("input[name='productoutputfg_1_sloccode']").val('');
      $("input[name='productoutputfg_1_storagedesc']").val('');
			$('#InputDialogproductoutputfg').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataproductoutputdetail()
{
	jQuery.ajax({'url':'productoutput/createproductoutputdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productoutputdetail_2_productoutputdetailid']").val('');
      $("input[name='productoutputdetail_2_productoutputfgid']").val('');
      $("input[name='productoutputdetail_2_productid']").val('');
      $("input[name='productoutputdetail_2_qty']").val(data.qty);
      $("input[name='productoutputdetail_2_uomid']").val('');
      $("input[name='productoutputdetail_2_toslocid']").val('');
      $("input[name='productoutputdetail_2_storagebinid']").val('');
      $("input[name='productoutputdetail_2_productplandetailid']").val('');
      $("input[name='productoutputdetail_2_productplanfgid']").val('');
      $("textarea[name='productoutputdetail_2_description']").val('');
      $("input[name='productoutputdetail_2_productname']").val('');
      $("input[name='productoutputdetail_2_uomcode']").val('');
      $("input[name='productoutputdetail_2_sloccode']").val('');
      $("input[name='productoutputdetail_2_storagedesc']").val('');
			$('#InputDialogproductoutputdetail').modal();
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
	jQuery.ajax({'url':'productoutput/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='productoutput_0_productoutputid']").val(data.productoutputid);
				$("input[name='productoutput_0_productoutputdate']").val(data.productoutputdate);
      $("input[name='productoutput_0_productplanid']").val(data.productplanid);
      $("textarea[name='productoutput_0_description']").val(data.description);
      $("input[name='productoutput_0_recordstatus']").val(data.recordstatus);
      $("input[name='productoutput_0_productplanno']").val(data.productplanno);
				$.fn.yiiGridView.update('productoutputfgList',{data:{'productoutputid':data.productoutputid}});
$.fn.yiiGridView.update('productoutputdetailList',{data:{'productoutputid':data.productoutputid}});

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
function updatedataproductoutputfg($id)
{
	jQuery.ajax({'url':'productoutput/updateproductoutputfg','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productoutputfg_1_productoutputfgid']").val(data.productoutputfgid);
      $("input[name='productoutputfg_1_productplanfgid']").val(data.productplanfgid);
      $("input[name='productoutputfg_1_productid']").val(data.productid);
      $("input[name='productoutputfg_1_qtyoutput']").val(data.qtyoutput);
      $("input[name='productoutputfg_1_uomid']").val(data.uomid);
      $("input[name='productoutputfg_1_slocid']").val(data.slocid);
      $("input[name='productoutputfg_1_storagebinid']").val(data.storagebinid);
      $("input[name='productoutputfg_1_outputdate']").val(data.outputdate);
      $("textarea[name='productoutputfg_1_description']").val(data.description);
      $("input[name='productoutputfg_1_productname']").val(data.productname);
      $("input[name='productoutputfg_1_uomcode']").val(data.uomcode);
      $("input[name='productoutputfg_1_sloccode']").val(data.sloccode);
      $("input[name='productoutputfg_1_storagedesc']").val(data.storagedesc);
			$('#InputDialogproductoutputfg').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataproductoutputdetail($id)
{
	jQuery.ajax({'url':'productoutput/updateproductoutputdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productoutputdetail_2_productoutputdetailid']").val(data.productoutputdetailid);
      $("input[name='productoutputdetail_2_productoutputfgid']").val(data.productoutputfgid);
      $("input[name='productoutputdetail_2_productid']").val(data.productid);
      $("input[name='productoutputdetail_2_qty']").val(data.qty);
      $("input[name='productoutputdetail_2_uomid']").val(data.uomid);
      $("input[name='productoutputdetail_2_toslocid']").val(data.toslocid);
      $("input[name='productoutputdetail_2_storagebinid']").val(data.storagebinid);
      $("input[name='productoutputdetail_2_productplandetailid']").val(data.productplandetailid);
      $("input[name='productoutputdetail_2_productplanfgid']").val(data.productplanfgid);
      $("textarea[name='productoutputdetail_2_description']").val(data.description);
      $("input[name='productoutputdetail_2_productname']").val(data.productname);
      $("input[name='productoutputdetail_2_uomcode']").val(data.uomcode);
      $("input[name='productoutputdetail_2_sloccode']").val(data.sloccode);
      $("input[name='productoutputdetail_2_storagedesc']").val(data.storagedesc);
			$('#InputDialogproductoutputdetail').modal();
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

	jQuery.ajax({'url':'productoutput/save',
		'data':{
			'productoutputid':$("input[name='productoutput_0_productoutputid']").val(),
			'productoutputdate':$("input[name='productoutput_0_productoutputdate']").val(),
      'productplanid':$("input[name='productoutput_0_productplanid']").val(),
      'description':$("textarea[name='productoutput_0_description']").val(),
      'recordstatus':$("input[name='productoutput_0_recordstatus']").val(),
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

function savedataproductoutputfg()
{

	jQuery.ajax({'url':'productoutput/saveproductoutputfg',
		'data':{
			'productoutputid':$("input[name='productoutput_0_productoutputid']").val(),
			'productoutputfgid':$("input[name='productoutputfg_1_productoutputfgid']").val(),
      'productplanfgid':$("input[name='productoutputfg_1_productplanfgid']").val(),
      'productid':$("input[name='productoutputfg_1_productid']").val(),
      'qtyoutput':$("input[name='productoutputfg_1_qtyoutput']").val(),
      'uomid':$("input[name='productoutputfg_1_uomid']").val(),
      'slocid':$("input[name='productoutputfg_1_slocid']").val(),
      'storagebinid':$("input[name='productoutputfg_1_storagebinid']").val(),
      'outputdate':$("input[name='productoutputfg_1_outputdate']").val(),
      'description':$("textarea[name='productoutputfg_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogproductoutputfg').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("productoutputfgList");
				$.fn.yiiGridView.update("productoutputdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedataproductoutputdetail()
{

	jQuery.ajax({'url':'productoutput/saveproductoutputdetail',
		'data':{
			'productoutputid':$("input[name='productoutput_0_productoutputid']").val(),
			'productoutputdetailid':$("input[name='productoutputdetail_2_productoutputdetailid']").val(),
      'productoutputfgid':$("input[name='productoutputdetail_2_productoutputfgid']").val(),
      'productid':$("input[name='productoutputdetail_2_productid']").val(),
      'qty':$("input[name='productoutputdetail_2_qty']").val(),
      'uomid':$("input[name='productoutputdetail_2_uomid']").val(),
      'toslocid':$("input[name='productoutputdetail_2_toslocid']").val(),
      'storagebinid':$("input[name='productoutputdetail_2_storagebinid']").val(),
      'productplandetailid':$("input[name='productoutputdetail_2_productplandetailid']").val(),
      'productplanfgid':$("input[name='productoutputdetail_2_productplanfgid']").val(),
      'description':$("textarea[name='productoutputdetail_2_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogproductoutputdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("productoutputdetailList");
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
	jQuery.ajax({'url':'productoutput/approve',
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
	jQuery.ajax({'url':'productoutput/delete',
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
	jQuery.ajax({'url':'productoutput/purge','data':{'id':$id},
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
function purgedataproductoutputfg()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'productoutput/purgeproductoutputfg','data':{'id':$.fn.yiiGridView.getSelection("productoutputfgList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("productoutputfgList");
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
function purgedataproductoutputdetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'productoutput/purgeproductoutputdetail','data':{'id':$.fn.yiiGridView.getSelection("productoutputdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("productoutputdetailList");
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
		'productoutputid':$id,
		'productoutputno':$("input[name='dlg_search_productoutputno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'productplanno':$("input[name='dlg_search_productplanno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productoutputid='+$id
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('productoutput/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productoutputid='+$id
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('productoutput/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productoutputid='+$id
$.fn.yiiGridView.update("DetailproductoutputfgList",{data:array});
$.fn.yiiGridView.update("DetailproductoutputdetailList",{data:array});
} 