if("undefined"==typeof jQuery)throw new Error("Product Plan's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'productplan/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productplan_0_productplanid']").val(data.productplanid);
			$("input[name='productplan_0_companyid']").val('');
      $("input[name='productplan_0_soheaderid']").val('');
      $("input[name='productplan_0_productplandate']").val(data.productplandate);
      $("textarea[name='productplan_0_description']").val('');
      $("input[name='productplan_0_recordstatus']").val(data.recordstatus);
      $("input[name='productplan_0_companyname']").val('');
      $("input[name='productplan_0_sono']").val('');
			$.fn.yiiGridView.update('productplanfgList',{data:{'productplanid':data.productplanid}});
$.fn.yiiGridView.update('productplandetailList',{data:{'productplanid':data.productplanid}});

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
function newdataproductplanfg()
{
	jQuery.ajax({'url':'productplan/createproductplanfg','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productplanfg_1_productid']").val('');
      $("input[name='productplanfg_1_qty']").val(data.qty);
      $("input[name='productplanfg_1_uomid']").val('');
      $("input[name='productplanfg_1_slocid']").val('');
      $("input[name='productplanfg_1_bomid']").val('');
      $("input[name='productplanfg_1_startdate']").val(data.startdate);
      $("input[name='productplanfg_1_enddate']").val(data.enddate);
      $("input[name='productplanfg_1_qtyres']").val(data.qtyres);
      $("textarea[name='productplanfg_1_description']").val('');
      $("input[name='productplanfg_1_productname']").val('');
      $("input[name='productplanfg_1_uomcode']").val('');
      $("input[name='productplanfg_1_sloccode']").val('');
      $("input[name='productplanfg_1_bomversion']").val('');
			$('#InputDialogproductplanfg').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataproductplandetail()
{
	jQuery.ajax({'url':'productplan/createproductplandetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productplandetail_2_productid']").val('');
      $("input[name='productplandetail_2_qty']").val(data.qty);
      $("input[name='productplandetail_2_uomid']").val('');
      $("input[name='productplandetail_2_fromslocid']").val('');
      $("input[name='productplandetail_2_toslocid']").val('');
      $("input[name='productplandetail_2_reqdate']").val(data.reqdate);
      $("input[name='productplandetail_2_qtyres']").val(data.qtyres);
      $("textarea[name='productplandetail_2_description']").val('');
      $("input[name='productplandetail_2_productname']").val('');
      $("input[name='productplandetail_2_uomcode']").val('');
      $("input[name='productplandetail_2_sloccode']").val('');
      $("input[name='productplandetail_2_toslocid']").val('');
			$('#InputDialogproductplandetail').modal();
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
	jQuery.ajax({'url':'productplan/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='productplan_0_productplanid']").val(data.productplanid);
				$("input[name='productplan_0_companyid']").val(data.companyid);
      $("input[name='productplan_0_soheaderid']").val(data.soheaderid);
      $("input[name='productplan_0_productplandate']").val(data.productplandate);
      $("textarea[name='productplan_0_description']").val(data.description);
      $("input[name='productplan_0_recordstatus']").val(data.recordstatus);
      $("input[name='productplan_0_companyname']").val(data.companyname);
      $("input[name='productplan_0_sono']").val(data.sono);
				$.fn.yiiGridView.update('productplanfgList',{data:{'productplanid':data.productplanid}});
$.fn.yiiGridView.update('productplandetailList',{data:{'productplanid':data.productplanid}});

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
function updatedataproductplanfg($id)
{
	jQuery.ajax({'url':'productplan/updateproductplanfg','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productplanfg_1_productid']").val(data.productid);
      $("input[name='productplanfg_1_qty']").val(data.qty);
      $("input[name='productplanfg_1_uomid']").val(data.uomid);
      $("input[name='productplanfg_1_slocid']").val(data.slocid);
      $("input[name='productplanfg_1_bomid']").val(data.bomid);
      $("input[name='productplanfg_1_startdate']").val(data.startdate);
      $("input[name='productplanfg_1_enddate']").val(data.enddate);
      $("input[name='productplanfg_1_qtyres']").val(data.qtyres);
      $("textarea[name='productplanfg_1_description']").val(data.description);
      $("input[name='productplanfg_1_productname']").val(data.productname);
      $("input[name='productplanfg_1_uomcode']").val(data.uomcode);
      $("input[name='productplanfg_1_sloccode']").val(data.sloccode);
      $("input[name='productplanfg_1_bomversion']").val(data.bomversion);
			$('#InputDialogproductplanfg').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataproductplandetail($id)
{
	jQuery.ajax({'url':'productplan/updateproductplandetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='productplandetail_2_productid']").val(data.productid);
      $("input[name='productplandetail_2_qty']").val(data.qty);
      $("input[name='productplandetail_2_uomid']").val(data.uomid);
      $("input[name='productplandetail_2_fromslocid']").val(data.fromslocid);
      $("input[name='productplandetail_2_toslocid']").val(data.toslocid);
      $("input[name='productplandetail_2_reqdate']").val(data.reqdate);
      $("input[name='productplandetail_2_qtyres']").val(data.qtyres);
      $("textarea[name='productplandetail_2_description']").val(data.description);
      $("input[name='productplandetail_2_productname']").val(data.productname);
      $("input[name='productplandetail_2_uomcode']").val(data.uomcode);
      $("input[name='productplandetail_2_sloccode']").val(data.sloccode);
      $("input[name='productplandetail_2_toslocid']").val(data.toslocid);
			$('#InputDialogproductplandetail').modal();
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

	jQuery.ajax({'url':'productplan/save',
		'data':{
			'productplanid':$("input[name='productplan_0_productplanid']").val(),
			'companyid':$("input[name='productplan_0_companyid']").val(),
      'soheaderid':$("input[name='productplan_0_soheaderid']").val(),
      'productplandate':$("input[name='productplan_0_productplandate']").val(),
      'description':$("textarea[name='productplan_0_description']").val(),
      'recordstatus':$("input[name='productplan_0_recordstatus']").val(),
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

function savedataproductplanfg()
{

	jQuery.ajax({'url':'productplan/saveproductplanfg',
		'data':{
			'productplanid':$("input[name='productplan_0_productplanid']").val(),
			'productid':$("input[name='productplanfg_1_productid']").val(),
      'qty':$("input[name='productplanfg_1_qty']").val(),
      'uomid':$("input[name='productplanfg_1_uomid']").val(),
      'slocid':$("input[name='productplanfg_1_slocid']").val(),
      'bomid':$("input[name='productplanfg_1_bomid']").val(),
      'startdate':$("input[name='productplanfg_1_startdate']").val(),
      'enddate':$("input[name='productplanfg_1_enddate']").val(),
      'qtyres':$("input[name='productplanfg_1_qtyres']").val(),
      'description':$("textarea[name='productplanfg_1_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogproductplanfg').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("productplanfgList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedataproductplandetail()
{

	jQuery.ajax({'url':'productplan/saveproductplandetail',
		'data':{
			'productplanid':$("input[name='productplan_0_productplanid']").val(),
			'productid':$("input[name='productplandetail_2_productid']").val(),
      'qty':$("input[name='productplandetail_2_qty']").val(),
      'uomid':$("input[name='productplandetail_2_uomid']").val(),
      'fromslocid':$("input[name='productplandetail_2_fromslocid']").val(),
      'toslocid':$("input[name='productplandetail_2_toslocid']").val(),
      'reqdate':$("input[name='productplandetail_2_reqdate']").val(),
      'qtyres':$("input[name='productplandetail_2_qtyres']").val(),
      'description':$("textarea[name='productplandetail_2_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogproductplandetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("productplandetailList");
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
	jQuery.ajax({'url':'productplan/approve',
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
	jQuery.ajax({'url':'productplan/delete',
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
	jQuery.ajax({'url':'productplan/purge','data':{'id':$id},
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
function purgedataproductplanfg()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'productplan/purgeproductplanfg','data':{'id':$.fn.yiiGridView.getSelection("productplanfgList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("productplanfgList");
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
function purgedataproductplandetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'productplan/purgeproductplandetail','data':{'id':$.fn.yiiGridView.getSelection("productplandetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("productplandetailList");
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
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('productplan/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'productplanid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val()
+ '&productplanno='+$("input[name='dlg_search_productplanno']").val();
	window.open('productplan/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productplanid='+$id
$.fn.yiiGridView.update("DetailproductplanfgList",{data:array});
$.fn.yiiGridView.update("DetailproductplandetailList",{data:array});
} 