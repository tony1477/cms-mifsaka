if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'deliveryadviceproductoutput/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
			$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val('');
      $("input[name='deliveryadvice_0_productoutputid']").val('');
      $("textarea[name='deliveryadvice_0_headernote']").val('');
      $("input[name='deliveryadvice_0_sloccode']").val('');
      $("input[name='deliveryadvice_0_productoutputno']").val('');
			$.fn.yiiGridView.update('deliveryadvicedetailList',{data:{'deliveryadviceid':data.deliveryadviceid}});

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
function newdatadeliveryadvicedetail()
{
	jQuery.ajax({'url':'deliveryadviceproductoutput/createdeliveryadvicedetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='deliveryadvicedetail_1_productid']").val('');
      $("input[name='deliveryadvicedetail_1_qty']").val(data.qty);
      $("input[name='deliveryadvicedetail_1_unitofmeasureid']").val('');
      $("input[name='deliveryadvicedetail_1_requestedbyid']").val('');
      $("input[name='deliveryadvicedetail_1_reqdate']").val(data.reqdate);
      $("textarea[name='deliveryadvicedetail_1_itemtext']").val('');
      $("input[name='deliveryadvicedetail_1_slocid']").val('');
      $("input[name='deliveryadvicedetail_1_productname']").val('');
      $("input[name='deliveryadvicedetail_1_uomcode']").val('');
      $("input[name='deliveryadvicedetail_1_requestedbycode']").val('');
      $("input[name='deliveryadvicedetail_1_sloccode']").val('');
			$('#InputDialogdeliveryadvicedetail').modal();
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
	jQuery.ajax({'url':'deliveryadviceproductoutput/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
				$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val(data.slocid);
      $("input[name='deliveryadvice_0_productoutputid']").val(data.productoutputid);
      $("textarea[name='deliveryadvice_0_headernote']").val(data.headernote);
      $("input[name='deliveryadvice_0_sloccode']").val(data.sloccode);
      $("input[name='deliveryadvice_0_productoutputno']").val(data.productoutputno);
				//$.fn.yiiGridView.update('deliveryadvicedetailList');
        				$.fn.yiiGridView.update('deliveryadvicedetailList',{data:{'deliveryadviceid':data.deliveryadviceid}});


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
function updatedatadeliveryadvicedetail($id)
{
	jQuery.ajax({'url':'deliveryadviceproductoutput/updatedeliveryadvicedetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='deliveryadvicedetail_1_productid']").val(data.productid);
      $("input[name='deliveryadvicedetail_1_qty']").val(data.qty);
      $("input[name='deliveryadvicedetail_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='deliveryadvicedetail_1_requestedbyid']").val(data.requestedbyid);
      $("input[name='deliveryadvicedetail_1_reqdate']").val(data.reqdate);
      $("textarea[name='deliveryadvicedetail_1_itemtext']").val(data.itemtext);
      $("input[name='deliveryadvicedetail_1_slocid']").val(data.slocid);
      $("input[name='deliveryadvicedetail_1_productname']").val(data.productname);
      $("input[name='deliveryadvicedetail_1_uomcode']").val(data.uomcode);
      $("input[name='deliveryadvicedetail_1_requestedbycode']").val(data.requestedbycode);
      $("input[name='deliveryadvicedetail_1_sloccode']").val(data.sloccode);
			$('#InputDialogdeliveryadvicedetail').modal();
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

	jQuery.ajax({'url':'deliveryadviceproductoutput/save',
		'data':{
			'deliveryadviceid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
			'dadate':$("input[name='deliveryadvice_0_dadate']").val(),
      'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
      'productoutputid':$("input[name='deliveryadvice_0_productoutputid']").val(),
      'headernote':$("textarea[name='deliveryadvice_0_headernote']").val(),
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

function savedatadeliveryadvicedetail()
{

	jQuery.ajax({'url':'deliveryadviceproductoutput/savedeliveryadvicedetail',
		'data':{
			'deliveryadviceid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
			'deliveryadvicedetailid':$("input[name='deliveryadvicedetail_1_deliveryadvicedetailid']").val(),
			'productid':$("input[name='deliveryadvicedetail_1_productid']").val(),
      'qty':$("input[name='deliveryadvicedetail_1_qty']").val(),
      'unitofmeasureid':$("input[name='deliveryadvicedetail_1_unitofmeasureid']").val(),
      'requestedbyid':$("input[name='deliveryadvicedetail_1_requestedbyid']").val(),
      'reqdate':$("input[name='deliveryadvicedetail_1_reqdate']").val(),
      'itemtext':$("textarea[name='deliveryadvicedetail_1_itemtext']").val(),
      'slocid':$("input[name='deliveryadvicedetail_1_slocid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogdeliveryadvicedetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("deliveryadvicedetailList");
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
	jQuery.ajax({'url':'deliveryadviceproductoutput/approve',
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
	jQuery.ajax({'url':'deliveryadviceproductoutput/delete',
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
	jQuery.ajax({'url':'deliveryadviceproductoutput/purge','data':{'id':$id},
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
function purgedatadeliveryadvicedetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'deliveryadviceproductoutput/purgedeliveryadvicedetail','data':{'id':$.fn.yiiGridView.getSelection("deliveryadvicedetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("deliveryadvicedetailList");
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
		'deliveryadviceid':$id,
		'dano':$("input[name='dlg_search_dano']").val(),
		'username':$("input[name='dlg_search_username']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'productoutputno':$("input[name='dlg_search_productoutputno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val();
	window.open('deliveryadviceproductoutput/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productoutputno='+$("input[name='dlg_search_productoutputno']").val();
	window.open('deliveryadviceproductoutput/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'deliveryadviceid='+$id
$.fn.yiiGridView.update("DetaildeliveryadvicedetailList",{data:array});
} 

function generateop()
{

	jQuery.ajax({'url':'deliveryadviceproductoutput/generateop',
		'data':{
			'id':$("input[name='deliveryadvice_0_productoutputid']").val(),
			'hid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
      'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$.fn.yiiGridView.update("deliveryadvicedetailList");
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}