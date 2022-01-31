if("undefined"==typeof jQuery)throw new Error("Bill of Material's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'bom/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='billofmaterial_0_bomid']").val(data.bomid);
			$("input[name='billofmaterial_0_bomversion']").val('');
      $("input[name='billofmaterial_0_productid']").val('');
      $("input[name='billofmaterial_0_qty']").val(data.qty);
      $("input[name='billofmaterial_0_uomid']").val('');
      $("input[name='billofmaterial_0_bomdate']").val(data.bomdate);
      $("textarea[name='billofmaterial_0_description']").val('');
      $("input[name='billofmaterial_0_recordstatus']").prop('checked',true);
      $("input[name='billofmaterial_0_productname']").val('');
      $("input[name='billofmaterial_0_uomcode']").val('');
			$.fn.yiiGridView.update('bomdetailList',{data:{'bomid':data.bomid}});

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
function newdatabomdetail()
{
	jQuery.ajax({'url':'bom/createbomdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bomdetail_1_bomdetailid']").val('');
      $("input[name='bomdetail_1_productid']").val('');
      $("input[name='bomdetail_1_productbomid']").val('');
      $("input[name='bomdetail_1_qty']").val(data.qty);
      $("input[name='bomdetail_1_uomid']").val('');
      $("textarea[name='bomdetail_1_description']").val('');
      $("input[name='bomdetail_1_productname']").val('');
      $("input[name='bomdetail_1_bomversion']").val('');
      $("input[name='bomdetail_1_uomcode']").val('');
			$('#InputDialogbomdetail').modal();
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
	jQuery.ajax({'url':'bom/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='billofmaterial_0_bomid']").val(data.bomid);
				$("input[name='billofmaterial_0_bomversion']").val(data.bomversion);
      $("input[name='billofmaterial_0_productid']").val(data.productid);
      $("input[name='billofmaterial_0_qty']").val(data.qty);
      $("input[name='billofmaterial_0_uomid']").val(data.uomid);
      $("input[name='billofmaterial_0_bomdate']").val(data.bomdate);
      $("textarea[name='billofmaterial_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='billofmaterial_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='billofmaterial_0_recordstatus']").prop('checked',false)
			}
      $("input[name='billofmaterial_0_productname']").val(data.productname);
      $("input[name='billofmaterial_0_uomcode']").val(data.uomcode);
				$.fn.yiiGridView.update('bomdetailList',{data:{'bomid':data.bomid}});

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
function updatedatabomdetail($id)
{
	jQuery.ajax({'url':'bom/updatebomdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bomdetail_1_bomdetailid']").val(data.bomdetailid);
      $("input[name='bomdetail_1_productid']").val(data.productid);
      $("input[name='bomdetail_1_productbomid']").val(data.productbomid);
      $("input[name='bomdetail_1_qty']").val(data.qty);
      $("input[name='bomdetail_1_uomid']").val(data.uomid);
      $("textarea[name='bomdetail_1_description']").val(data.description);
      $("input[name='bomdetail_1_productname']").val(data.productname);
      $("input[name='bomdetail_1_bomversion']").val(data.bomversion);
      $("input[name='bomdetail_1_uomcode']").val(data.uomcode);
			$('#InputDialogbomdetail').modal();
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
	if ($("input[name='billofmaterial_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'bom/save',
		'data':{
			'bomid':$("input[name='billofmaterial_0_bomid']").val(),
			'bomversion':$("input[name='billofmaterial_0_bomversion']").val(),
      'productid':$("input[name='billofmaterial_0_productid']").val(),
      'qty':$("input[name='billofmaterial_0_qty']").val(),
      'uomid':$("input[name='billofmaterial_0_uomid']").val(),
      'bomdate':$("input[name='billofmaterial_0_bomdate']").val(),
      'description':$("textarea[name='billofmaterial_0_description']").val(),
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

function savedatabomdetail()
{

	jQuery.ajax({'url':'bom/savebomdetail',
		'data':{
			'bomid':$("input[name='billofmaterial_0_bomid']").val(),
			'bomdetailid':$("input[name='bomdetail_1_bomdetailid']").val(),
      'productid':$("input[name='bomdetail_1_productid']").val(),
      'productbomid':$("input[name='bomdetail_1_productbomid']").val(),
      'qty':$("input[name='bomdetail_1_qty']").val(),
      'uomid':$("input[name='bomdetail_1_uomid']").val(),
      'description':$("textarea[name='bomdetail_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogbomdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("bomdetailList");
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
	jQuery.ajax({'url':'bom/delete',
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
	jQuery.ajax({'url':'bom/purge','data':{'id':$id},
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
function purgedatabomdetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'bom/purgebomdetail','data':{'id':$.fn.yiiGridView.getSelection("bomdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("bomdetailList");
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
function copybom($id=0)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'bom/copybom','data':{'id':$id},
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
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'bomid':$id,
		'bomversion':$("input[name='dlg_search_bomversion']").val(),
		'productheader':$("input[name='dlg_search_productheader']").val(),
		'productdetail':$("input[name='dlg_search_productdetail']").val(),
		'uomcode':$("input[name='dlg_search_uomcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'bomid='+$id
+ '&bomversion='+$("input[name='dlg_search_bomversion']").val()
+ '&productheader='+$("input[name='dlg_search_productheader']").val()
+ '&productdetail='+$("input[name='dlg_search_productdetail']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('bom/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'bomid='+$id
+ '&bomversion='+$("input[name='dlg_search_bomversion']").val()
+ '&productheader='+$("input[name='dlg_search_productheader']").val()
+ '&productdetail='+$("input[name='dlg_search_productdetail']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();
	window.open('bom/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'bomid='+$id
$.fn.yiiGridView.update("DetailbomdetailList",{data:array});
} 