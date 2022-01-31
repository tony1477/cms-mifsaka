if("undefined"==typeof jQuery)throw new Error("Purchase Requisition's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'prheader/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='prheaderid']").val(data.prheaderid);
			$("input[name='prdate']").val(data.prdate);
			$("input[name='deliveryadviceid']").val('');
			$("input[name='dano']").val('');
      $("textarea[name='headernote']").val('');
			$.fn.yiiGridView.update('prmaterialList',{data:{'prheaderid':data.prheaderid}});

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
function newdataprmaterial()
{
	jQuery.ajax({'url':'prheader/createprmaterial','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='prmaterial_1_productid']").val('');
      $("input[name='prmaterial_1_qty']").val(data.qty);
      $("input[name='prmaterial_1_unitofmeasureid']").val('');
      $("input[name='prmaterial_1_requestedbyid']").val('');
      $("input[name='prmaterial_1_reqdate']").val(data.reqdate);
      $("textarea[name='prmaterial_1_itemtext']").val('');
      $("input[name='prmaterial_1_productname']").val('');
      $("input[name='prmaterial_1_uomcode']").val('');
      $("input[name='prmaterial_1_requestedbycode']").val('');
			$('#InputDialogprmaterial').modal();
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
	jQuery.ajax({'url':'prheader/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='prheaderid']").val(data.prheaderid);
				$("input[name='prdate']").val(data.prdate);
      $("textarea[name='headernote']").val(data.headernote);
			$("input[name='deliveryadviceid']").val(data.deliveryadviceid);
			$("input[name='dano']").val(data.dano);
				$.fn.yiiGridView.update('prmaterialList',{data:{'prheaderid':data.prheaderid}});

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
function updatedataprmaterial($id)
{
	jQuery.ajax({'url':'prheader/updateprmaterial','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='prmaterial_1_productid']").val(data.productid);
      $("input[name='prmaterial_1_qty']").val(data.qty);
      $("input[name='prmaterial_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='prmaterial_1_requestedbyid']").val(data.requestedbyid);
      $("input[name='prmaterial_1_reqdate']").val(data.reqdate);
      $("textarea[name='prmaterial_1_itemtext']").val(data.itemtext);
      $("input[name='prmaterial_1_productname']").val(data.productname);
      $("input[name='prmaterial_1_uomcode']").val(data.uomcode);
      $("input[name='prmaterial_1_requestedbycode']").val(data.requestedbycode);
			$('#InputDialogprmaterial').modal();
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

	jQuery.ajax({'url':'prheader/save',
		'data':{
			'prheaderid':$("input[name='prheaderid']").val(),
			'prdate':$("input[name='prdate']").val(),
			'deliveryadviceid':$("input[name='deliveryadviceid']").val(),
      'headernote':$("textarea[name='headernote']").val(),
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

function savedataprmaterial()
{

	jQuery.ajax({'url':'prheader/saveprmaterial',
		'data':{
			'prheaderid':$("input[name='prheaderid']").val(),
			'productid':$("input[name='prmaterial_1_productid']").val(),
      'qty':$("input[name='prmaterial_1_qty']").val(),
      'unitofmeasureid':$("input[name='prmaterial_1_unitofmeasureid']").val(),
      'requestedbyid':$("input[name='prmaterial_1_requestedbyid']").val(),
      'reqdate':$("input[name='prmaterial_1_reqdate']").val(),
      'itemtext':$("textarea[name='prmaterial_1_itemtext']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogprmaterial').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("prmaterialList");
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
	jQuery.ajax({'url':'prheader/approve',
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
	jQuery.ajax({'url':'prheader/delete',
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
	jQuery.ajax({'url':'prheader/purge','data':{'id':$id},
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
function purgedataprmaterial()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'prheader/purgeprmaterial','data':{'id':$.fn.yiiGridView.getSelection("prmaterialList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("prmaterialList");
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
		'prheaderid':$id,
		'prno':$("input[name='dlg_search_prno']").val(),
		'deliveryadviceid':$("input[name='dlg_search_deliveryadviceid']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'prheaderid='+$id
+ '&prno='+$("input[name='dlg_search_prno']").val()
+ '&deliveryadviceid='+$("input[name='dlg_search_deliveryadviceid']").val();
	window.open('prheader/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'prheaderid='+$id
+ '&prno='+$("input[name='dlg_search_prno']").val()
+ '&deliveryadviceid='+$("input[name='dlg_search_deliveryadviceid']").val();
	window.open('prheader/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'prheaderid='+$id
$.fn.yiiGridView.update("DetailprmaterialList",{data:array});
}

function generatefr()
{
	jQuery.ajax({'url':'prheader/generatefr',
		'data':{
			'id':$("input[name='deliveryadviceid']").val(),
			'hid':$("input[name='prheaderid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("prmaterialList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}