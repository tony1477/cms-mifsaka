if("undefined"==typeof jQuery)throw new Error("Product Sales's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'bsheader/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bsheader_0_bsheaderid']").val(data.bsheaderid);
			$("input[name='bsheader_0_slocid']").val('');
      $("input[name='bsheader_0_bsdate']").val(data.bsdate);
      $("textarea[name='bsheader_0_headernote']").val('');
      $("input[name='bsheader_0_sloccode']").val('');
			$.fn.yiiGridView.update('bsdetailList',{data:{'bsheaderid':data.bsheaderid}});

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
function newdatabsdetail()
{
	jQuery.ajax({'url':'bsheader/createbsdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bsdetail_1_bsdetailid']").val('');
			$("input[name='bsdetail_1_productid']").val('');
      $("input[name='bsdetail_1_unitofmeasureid']").val('');
      $("input[name='bsdetail_1_qty']").val(data.qty);
      $("input[name='bsdetail_1_ownershipid']").val('');
      $("input[name='bsdetail_1_expiredate']").val(data.expiredate);
      $("input[name='bsdetail_1_materialstatusid']").val('');
      $("input[name='bsdetail_1_storagebinid']").val('');
      $("input[name='bsdetail_1_location']").val('');
      $("input[name='bsdetail_1_itemnote']").val('');
      $("input[name='bsdetail_1_currencyid']").val(data.currencyid);
      $("input[name='bsdetail_1_buyprice']").val(data.buyprice);
      $("input[name='bsdetail_1_currencyrate']").val(data.currencyrate);
      $("input[name='bsdetail_1_productname']").val('');
      $("input[name='bsdetail_1_uomcode']").val('');
      $("input[name='bsdetail_1_ownershipname']").val('');
      $("input[name='bsdetail_1_materialstatusname']").val('');
      $("input[name='bsdetail_1_description']").val('');
      $("input[name='bsdetail_1_currencyname']").val(data.currencyname);
			$('#InputDialogbsdetail').modal();
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
	jQuery.ajax({'url':'bsheader/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='bsheader_0_bsheaderid']").val(data.bsheaderid);
				$("input[name='bsheader_0_slocid']").val(data.slocid);
      $("input[name='bsheader_0_bsdate']").val(data.bsdate);
      $("textarea[name='bsheader_0_headernote']").val(data.headernote);
      $("input[name='bsheader_0_sloccode']").val(data.sloccode);
				$.fn.yiiGridView.update('bsdetailList',{data:{'bsheaderid':data.bsheaderid}});

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
function updatedatabsdetail($id)
{
	jQuery.ajax({'url':'bsheader/updatebsdetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='bsdetail_1_productid']").val(data.productid);
      $("input[name='bsdetail_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='bsdetail_1_qty']").val(data.qty);
      $("input[name='bsdetail_1_ownershipid']").val(data.ownershipid);
      $("input[name='bsdetail_1_expiredate']").val(data.expiredate);
      $("input[name='bsdetail_1_materialstatusid']").val(data.materialstatusid);
      $("input[name='bsdetail_1_storagebinid']").val(data.storagebinid);
      $("input[name='bsdetail_1_location']").val(data.location);
      $("input[name='bsdetail_1_itemnote']").val(data.itemnote);
      $("input[name='bsdetail_1_currencyid']").val(data.currencyid);
      $("input[name='bsdetail_1_buyprice']").val(data.buyprice);
      $("input[name='bsdetail_1_currencyrate']").val(data.currencyrate);
      $("input[name='bsdetail_1_productname']").val(data.productname);
      $("input[name='bsdetail_1_uomcode']").val(data.uomcode);
      $("input[name='bsdetail_1_ownershipname']").val(data.ownershipname);
      $("input[name='bsdetail_1_materialstatusname']").val(data.materialstatusname);
      $("input[name='bsdetail_1_description']").val(data.description);
      $("input[name='bsdetail_1_currencyname']").val(data.currencyname);
			$('#InputDialogbsdetail').modal();
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

	jQuery.ajax({'url':'bsheader/save',
		'data':{
			'bsheaderid':$("input[name='bsheader_0_bsheaderid']").val(),
			'slocid':$("input[name='bsheader_0_slocid']").val(),
      'bsdate':$("input[name='bsheader_0_bsdate']").val(),
      'headernote':$("textarea[name='bsheader_0_headernote']").val(),
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

function savedatabsdetail()
{

	jQuery.ajax({'url':'bsheader/savebsdetail',
		'data':{
			'bsdetailid':$("input[name='bsdetail_1_bsdetailid']").val(),
			'bsheaderid':$("input[name='bsheader_0_bsheaderid']").val(),
			'productid':$("input[name='bsdetail_1_productid']").val(),
      'unitofmeasureid':$("input[name='bsdetail_1_unitofmeasureid']").val(),
      'qty':$("input[name='bsdetail_1_qty']").val(),
      'ownershipid':$("input[name='bsdetail_1_ownershipid']").val(),
      'expiredate':$("input[name='bsdetail_1_expiredate']").val(),
      'materialstatusid':$("input[name='bsdetail_1_materialstatusid']").val(),
      'storagebinid':$("input[name='bsdetail_1_storagebinid']").val(),
      'location':$("input[name='bsdetail_1_location']").val(),
      'itemnote':$("input[name='bsdetail_1_itemnote']").val(),
      'currencyid':$("input[name='bsdetail_1_currencyid']").val(),
      'buyprice':$("input[name='bsdetail_1_buyprice']").val(),
      'currencyrate':$("input[name='bsdetail_1_currencyrate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogbsdetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("bsdetailList");
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
	jQuery.ajax({'url':'bsheader/approve',
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
	jQuery.ajax({'url':'bsheader/delete',
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
	jQuery.ajax({'url':'bsheader/purge','data':{'id':$id},
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
function purgedatabsdetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'bsheader/purgebsdetail','data':{'id':$.fn.yiiGridView.getSelection("bsdetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("bsdetailList");
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
		'bsheaderid':$id,
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'bsheaderno':$("input[name='dlg_search_bsheaderno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'bsheaderid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&bsheaderno='+$("input[name='dlg_search_bsheaderno']").val();
	window.open('bsheader/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'bsheaderid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&bsheaderno='+$("input[name='dlg_search_bsheaderno']").val();
	window.open('bsheader/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'bsheaderid='+$id
$.fn.yiiGridView.update("DetailbsdetailList",{data:array});
} 
