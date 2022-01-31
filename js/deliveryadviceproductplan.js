if("undefined"==typeof jQuery)throw new Error("Delivery Advice Product Plan's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'deliveryadviceproductplan/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
			$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val('');
      $("input[name='deliveryadvice_0_productplanid']").val('');
      $("textarea[name='deliveryadvice_0_headernote']").val('');
      $("input[name='deliveryadvice_0_username']").val('');
      $("input[name='deliveryadvice_0_sloccode']").val('');
      $("input[name='deliveryadvice_0_productplanno']").val('');
			$.fn.yiiGridView.update('deliveryadvicedetailList',{data:{'deliveryadviceid':data.deliveryadviceid}});
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
	jQuery.ajax({'url':'deliveryadviceproductplan/createdeliveryadvicedetail','data':{},
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
	jQuery.ajax({'url':'deliveryadviceproductplan/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='deliveryadvice_0_deliveryadviceid']").val(data.deliveryadviceid);
				$("input[name='deliveryadvice_0_dadate']").val(data.dadate);
      $("input[name='deliveryadvice_0_slocid']").val(data.slocid);
      $("input[name='deliveryadvice_0_productplanid']").val(data.productplanid);
      $("textarea[name='deliveryadvice_0_headernote']").val(data.headernote);
      $("input[name='deliveryadvice_0_username']").val(data.username);
      $("input[name='deliveryadvice_0_sloccode']").val(data.sloccode);
      $("input[name='deliveryadvice_0_productplanno']").val(data.productplanno);
				$.fn.yiiGridView.update('deliveryadvicedetailList',{data:{'deliveryadviceid':data.deliveryadviceid}});
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
	jQuery.ajax({'url':'deliveryadviceproductplan/updatedeliveryadvicedetail','data':{'id':$id},
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

function generatepp()
{

	jQuery.ajax({'url':'deliveryadviceproductplan/generatepp',
		'data':{
			'id':$("input[name='deliveryadvice_0_productplanid']").val(),
			'hid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
      'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
		},
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
}

function savedata()
{

	jQuery.ajax({'url':'deliveryadviceproductplan/save',
		'data':{
			'deliveryadviceid':$("input[name='deliveryadvice_0_deliveryadviceid']").val(),
			'dadate':$("input[name='deliveryadvice_0_dadate']").val(),
      'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
      'productplanid':$("input[name='deliveryadvice_0_productplanid']").val(),
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

	jQuery.ajax({'url':'deliveryadviceproductplan/savedeliveryadvicedetail',
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
	jQuery.ajax({'url':'deliveryadviceproductplan/approve',
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
	jQuery.ajax({'url':'deliveryadviceproductplan/delete',
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
	jQuery.ajax({'url':'deliveryadviceproductplan/purge','data':{'id':$id},
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
	jQuery.ajax({'url':'deliveryadviceproductplan/purgedeliveryadvicedetail','data':{'id':$.fn.yiiGridView.getSelection("deliveryadvicedetailList")},
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
		'productplanno':$("input[name='dlg_search_productplanno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('deliveryadviceproductplan/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'deliveryadviceid='+$id
+ '&dano='+$("input[name='dlg_search_dano']").val()
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('deliveryadviceproductplan/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'deliveryadviceid='+$id
$.fn.yiiGridView.update("DetaildeliveryadvicedetailList",{data:array});
$.fn.yiiGridView.update("DetailproductplanList",{data:array});
} 