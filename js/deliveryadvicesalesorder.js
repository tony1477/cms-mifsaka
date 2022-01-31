if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'deliveryadvicesalesorder/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
			$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val('');
      $("input[name='deliveryadvice_0_soheaderid']").val('');
      $("textarea[name='deliveryadvice_0_headernote']").val('');
      $("input[name='deliveryadvice_0_username']").val('');
      $("input[name='deliveryadvice_0_sloccode']").val('');
      $("input[name='deliveryadvice_0_sono']").val('');
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/createdeliveryadvicedetail','data':{},
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
				$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val(data.slocid);
      $("input[name='deliveryadvice_0_soheaderid']").val(data.soheaderid);
      $("textarea[name='deliveryadvice_0_headernote']").val(data.headernote);
      $("input[name='deliveryadvice_0_username']").val(data.username);
      $("input[name='deliveryadvice_0_sloccode']").val(data.sloccode);
      $("input[name='deliveryadvice_0_sono']").val(data.sono);
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/updatedeliveryadvicedetail','data':{'id':$id},
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

	jQuery.ajax({'url':'deliveryadvicesalesorder/save',
		'data':{
			'deliveryadviceid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
			'dadate':$("input[name='deliveryadvice_0_dadate']").val(),
      'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
      'soheaderid':$("input[name='deliveryadvice_0_soheaderid']").val(),
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

function generateso()
{

	jQuery.ajax({'url':'deliveryadvicesalesorder/generateso',
		'data':{
			'id':$("input[name='deliveryadvice_0_soheaderid']").val(),
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

function savedatadeliveryadvicedetail()
{

	jQuery.ajax({'url':'deliveryadvicesalesorder/savedeliveryadvicedetail',
		'data':{
			'deliveryadviceid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/approve',
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/delete',
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/purge','data':{'id':$id},
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
	jQuery.ajax({'url':'deliveryadvicesalesorder/purgedeliveryadvicedetail','data':{'id':$.fn.yiiGridView.getSelection("deliveryadvicedetailList")},
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
		'sono':$("input[name='dlg_search_sono']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('deliveryadvicesalesorder/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('deliveryadvicesalesorder/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'deliveryadviceid='+$id
$.fn.yiiGridView.update("DetaildeliveryadvicedetailList",{data:array});
} 