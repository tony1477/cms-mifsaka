if("undefined"==typeof jQuery)throw new Error("Stock Opname's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'stockopname/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='stockopnameid']").val(data.stockopnameid);
			$("input[name='actiontype']").val(0);
			$("input[name='transdate']").val(data.transdate);
      $("input[name='slocid']").val('');
      $("textarea[name='headernote']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='sloccode']").val('');
			$.fn.yiiGridView.update('stockopnamedetList',{data:{'stockopnameid':data.stockopnameid}});

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
function newdatastockopnamedet()
{
	jQuery.ajax({'url':'stockopname/createstockopnamedet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='stockopnamedetid']").val('');
      $("input[name='productid']").val('');
      $("input[name='unitofmeasureid']").val('');
      $("input[name='storagebinid']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='buyprice']").val(data.buyprice);
      $("input[name='buydate']").val(data.buydate);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='expiredate']").val(data.expiredate);
      $("input[name='materialstatusid']").val('');
      $("input[name='ownershipid']").val('');
      $("input[name='serialno']").val('');
      $("input[name='location']").val('');
      $("textarea[name='itemnote']").val('');
      $("input[name='productname']").val('');
      $("input[name='uomcode']").val('');
      $("input[name='storagebindesc']").val('');
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='materialstatusname']").val('');
      $("input[name='ownershipname']").val('');
			$('#InputDialogstockopnamedet').modal();
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
	jQuery.ajax({'url':'stockopname/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='stockopnameid']").val(data.stockopnameid);
				$("input[name='actiontype']").val(1);
				$("input[name='transdate']").val(data.transdate);
      $("input[name='slocid']").val(data.slocid);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='sloccode']").val(data.sloccode);
				$.fn.yiiGridView.update('stockopnamedetList',{data:{'stockopnameid':data.stockopnameid}});

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
function updatedatastockopnamedet($id)
{
	jQuery.ajax({'url':'stockopname/updatestockopnamedet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='stockopnamedetid']").val(data.stockopnamedetid);
      $("input[name='productid']").val(data.productid);
      $("input[name='unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='storagebinid']").val(data.storagebinid);
      $("input[name='qty']").val(data.qty);
      $("input[name='buyprice']").val(data.buyprice);
      $("input[name='buydate']").val(data.buydate);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='expiredate']").val(data.expiredate);
      $("input[name='materialstatusid']").val(data.materialstatusid);
      $("input[name='ownershipid']").val(data.ownershipid);
      $("input[name='serialno']").val(data.serialno);
      $("input[name='location']").val(data.location);
      $("textarea[name='itemnote']").val(data.itemnote);
      $("input[name='productname']").val(data.productname);
      $("input[name='uomcode']").val(data.uomcode);
      $("input[name='storagebindesc']").val(data.storagebindesc);
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='materialstatusname']").val(data.materialstatusname);
      $("input[name='ownershipname']").val(data.ownershipname);
			$('#InputDialogstockopnamedet').modal();
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

	jQuery.ajax({'url':'stockopname/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'stockopnameid':$("input[name='stockopnameid']").val(),
			'transdate':$("input[name='transdate']").val(),
      'slocid':$("input[name='slocid']").val(),
      'headernote':$("textarea[name='headernote']").val(),
      'recordstatus':$("input[name='recordstatus']").val(),
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

function savedatastockopnamedet()
{

	jQuery.ajax({'url':'stockopname/savestockopnamedet',
		'data':{
			'stockopnameid':$("input[name='stockopnameid']").val(),
			'stockopnamedetid':$("input[name='stockopnamedetid']").val(),
      'productid':$("input[name='productid']").val(),
      'unitofmeasureid':$("input[name='unitofmeasureid']").val(),
      'storagebinid':$("input[name='storagebinid']").val(),
      'qty':$("input[name='qty']").val(),
      'buyprice':$("input[name='buyprice']").val(),
      'buydate':$("input[name='buydate']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'expiredate':$("input[name='expiredate']").val(),
      'materialstatusid':$("input[name='materialstatusid']").val(),
      'ownershipid':$("input[name='ownershipid']").val(),
      'serialno':$("input[name='serialno']").val(),
      'location':$("input[name='location']").val(),
      'itemnote':$("textarea[name='itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogstockopnamedet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("stockopnamedetList");
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'stockopname/approve',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'stockopname/delete',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'stockopname/purge','data':{'id':$id},
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
function purgedatastockopnamedet()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'stockopname/purgestockopnamedet','data':{'id':$.fn.yiiGridView.getSelection("stockopnamedetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("stockopnamedetList");
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
		'stockopnameid':$id,
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
		'stockopnameno':$("input[name='dlg_search_stockopnameno']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'stockopnameid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&stockopnameno='+$("input[name='dlg_search_stockopnameno']").val();
	window.open('stockopname/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'stockopnameid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&stockopnameno='+$("input[name='dlg_search_stockopnameno']").val();
	window.open('stockopname/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'stockopnameid='+$id
$.fn.yiiGridView.update("DetailstockopnamedetList",{data:array});
} 
function getproductplant() {
	jQuery.ajax({
		'url': 'productplant/getproductplant',
		'data': {
			'productid':$("input[name='productid']").val(),
			'slocid':$("input[name='slocid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='unitofmeasureid']").val(data.uomid);
				$("input[name='uomcode']").val(data.uomcode);
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