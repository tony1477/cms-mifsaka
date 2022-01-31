if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'productconversion/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productconversion_0_productconversionid']").val(data.productconversionid);
			$("input[name='productconversion_0_productid']").val('');
      $("input[name='productconversion_0_qty']").val(data.qty);
      $("input[name='productconversion_0_uomid']").val('');
      $("input[name='productconversion_0_recordstatus']").prop('checked',true);
      $("input[name='productconversion_0_productname']").val('');
      $("input[name='productconversion_0_uomcode']").val('');
			$.fn.yiiGridView.update('productconversiondetailList',{data:{'productconversionid':data.productconversionid}});

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
function newdataproductconversiondetail()
{
	jQuery.ajax({'url':'productconversion/createproductconversiondetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productconversiondetail_1_productconversiondetailid']").val('');
      $("input[name='productconversiondetail_1_productid']").val('');
      $("input[name='productconversiondetail_1_qty']").val(data.qty);
      $("input[name='productconversiondetail_1_uomid']").val('');
      $("input[name='productconversiondetail_1_productname']").val('');
      $("input[name='productconversiondetail_1_uomcode']").val('');
			$('#InputDialogproductconversiondetail').modal();
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
	jQuery.ajax({'url':'productconversion/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='productconversion_0_productconversionid']").val(data.productconversionid);
				$("input[name='productconversion_0_productid']").val(data.productid);
      $("input[name='productconversion_0_qty']").val(data.qty);
      $("input[name='productconversion_0_uomid']").val(data.uomid);
      if (data.recordstatus == 1)
			{
				$("input[name='productconversion_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='productconversion_0_recordstatus']").prop('checked',false)
			}
      $("input[name='productconversion_0_productname']").val(data.productname);
      $("input[name='productconversion_0_uomcode']").val(data.uomcode);
				$.fn.yiiGridView.update('productconversiondetailList',{data:{'productconversionid':data.productconversionid}});

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
function updatedataproductconversiondetail($id)
{
	jQuery.ajax({'url':'productconversion/updateproductconversiondetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productconversiondetail_1_productconversiondetailid']").val(data.productconversiondetailid);
      $("input[name='productconversiondetail_1_productid']").val(data.productid);
      $("input[name='productconversiondetail_1_qty']").val(data.qty);
      $("input[name='productconversiondetail_1_uomid']").val(data.uomid);
      $("input[name='productconversiondetail_1_productname']").val(data.productname);
      $("input[name='productconversiondetail_1_uomcode']").val(data.uomcode);
			$('#InputDialogproductconversiondetail').modal();
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
var recordstatus = 0;
	if ($("input[name='productconversion_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'productconversion/save',
		'data':{
			'productconversionid':$("input[name='productconversion_0_productconversionid']").val(),
			'productid':$("input[name='productconversion_0_productid']").val(),
      'qty':$("input[name='productconversion_0_qty']").val(),
      'uomid':$("input[name='productconversion_0_uomid']").val(),
      'recordstatus':recordstatus,
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

function savedataproductconversiondetail()
{

	jQuery.ajax({'url':'productconversion/saveproductconversiondetail',
		'data':{
			'productconversionid':$("input[name='productconversion_0_productconversionid']").val(),
			'productconversiondetailid':$("input[name='productconversiondetail_1_productconversiondetailid']").val(),
      'productid':$("input[name='productconversiondetail_1_productid']").val(),
      'qty':$("input[name='productconversiondetail_1_qty']").val(),
      'uomid':$("input[name='productconversiondetail_1_uomid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogproductconversiondetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("productconversiondetailList");
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'productconversion/delete',
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
	jQuery.ajax({'url':'productconversion/purge','data':{'id':$id},
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
function purgedataproductconversiondetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'productconversion/purgeproductconversiondetail','data':{'id':$.fn.yiiGridView.getSelection("productconversiondetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("productconversiondetailList");
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
		'productconversionid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productconversionid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productconversion/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productconversionid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('productconversion/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productconversionid='+$id
$.fn.yiiGridView.update("DetailproductconversiondetailList",{data:array});
} 