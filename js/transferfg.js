if("undefined"==typeof jQuery)throw new Error("Transfer FG's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'transferfg/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstockid']").val(data.transstockid);
			$("input[name='actiontype']").val(0);
			$("input[name='companyid']").val(data.companyid);
      $("input[name='slocfromid']").val('');
      $("input[name='sloctoid']").val('');
      $("input[name='transdate']").val(data.transdate);
      $("textarea[name='headernote']").val('');
      $("input[name='soheaderid']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='slocfromcode']").val('');
      $("input[name='sloctocode']").val('');
      $("input[name='sono']").val('');
			$.fn.yiiGridView.update('transstockdetList',{data:{'transstockid':data.transstockid}});

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
function newdatatransstockdet()
{
	jQuery.ajax({'url':'transferfg/createtransstockdet','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstockdetid']").val('');
      $("input[name='productid']").val('');
      $("input[name='storagebinid']").val('');
      $("input[name='unitofmeasureid']").val('');
      $("input[name='uomcode']").val('');
      $("input[name='qty']").val(data.qty);
      $("input[name='storagebintoid']").val('');
      $("textarea[name='itemtext']").val('');
      $("input[name='productname']").val('');
      $("input[name='storagefrom']").val('');
      $("input[name='storagetodesc']").val('');
			$('#InputDialogtransstockdet').modal();
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
	jQuery.ajax({'url':'transferfg/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transstockid']").val(data.transstockid);
				$("input[name='actiontype']").val(1);
				$("input[name='companyid']").val(data.companyid);
      $("input[name='slocfromid']").val(data.slocfromid);
      $("input[name='sloctoid']").val(data.sloctoid);
      $("input[name='transdate']").val(data.transdate);
      $("textarea[name='headernote']").val(data.headernote);
      $("input[name='soheaderid']").val(data.soheaderid);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='slocfromcode']").val(data.slocfromcode);
      $("input[name='sloctocode']").val(data.sloctocode);
      $("input[name='sono']").val(data.sono);
				$.fn.yiiGridView.update('transstockdetList',{data:{'transstockid':data.transstockid}});

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
function updatedatatransstockdet($id)
{
	jQuery.ajax({'url':'transferfg/updatetransstockdet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstockdetid']").val(data.transstockdetid);
      $("input[name='productid']").val(data.productid);
      $("input[name='storagebinid']").val(data.storagebinid);
      $("input[name='unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='uomcode']").val(data.uomcode);
      $("input[name='qty']").val(data.qty);
      $("input[name='storagebintoid']").val(data.storagebintoid);
      $("textarea[name='itemtext']").val(data.itemtext);
      $("input[name='productname']").val(data.productname);
      $("input[name='storagefrom']").val(data.storagefrom);
      $("input[name='storagetodesc']").val(data.storagetodesc);
			$('#InputDialogtransstockdet').modal();
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

	jQuery.ajax({'url':'transferfg/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'transstockid':$("input[name='transstockid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'slocfromid':$("input[name='slocfromid']").val(),
      'sloctoid':$("input[name='sloctoid']").val(),
      'transdate':$("input[name='transdate']").val(),
      'headernote':$("textarea[name='headernote']").val(),
      'soheaderid':$("input[name='soheaderid']").val(),
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

function savedatatransstockdet()
{

	jQuery.ajax({'url':'transferfg/savetransstockdet',
		'data':{
			'transstockid':$("input[name='transstockid']").val(),
			'transstockdetid':$("input[name='transstockdetid']").val(),
      'productid':$("input[name='productid']").val(),
      'storagebinid':$("input[name='storagebinid']").val(),
      'unitofmeasureid':$("input[name='unitofmeasureid']").val(),
      'qty':$("input[name='qty']").val(),
      'storagebintoid':$("input[name='storagebintoid']").val(),
      'itemtext':$("textarea[name='itemtext']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogtransstockdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("transstockdetList");
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
	jQuery.ajax({'url':'transferfg/approve',
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
	jQuery.ajax({'url':'transferfg/delete',
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
	jQuery.ajax({'url':'transferfg/purge','data':{'id':$id},
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
function purgedatatransstockdet($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'transferfg/purgetransstockdet','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("transstockdetList");
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
function generatetsso()
{
	jQuery.ajax({'url':'transferfg/generatetsso',
			'data':{
				'id':$("input[name='soheaderid']").val(),
				'hid':$("input[name='transstockid']").val(),
				},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='sloctoid']").val(data.sloctoid),
				$("input[name='slocfromid']").val(data.slocfromid),
				$("input[name='sloctocode']").val(data.sloctocode),
				$("input[name='slocfromcode']").val(data.slocfromcode),
				$.fn.yiiGridView.update("transstockdetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'transstockid':$id,
		'transstockno':$("input[name='dlg_search_transstockno']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'slocfromcode':$("input[name='dlg_search_slocfromcode']").val(),
		'sloctocode':$("input[name='dlg_search_sloctocode']").val(),
		'sono':$("input[name='dlg_search_sono']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'transstockid='+$id
+ '&transstockno='+$("input[name='dlg_search_transstockno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&slocfromcode='+$("input[name='dlg_search_slocfromcode']").val()
+ '&sloctocode='+$("input[name='dlg_search_sloctocode']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('transferfg/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'transstockid='+$id
+ '&transstockno='+$("input[name='dlg_search_transstockno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&slocfromcode='+$("input[name='dlg_search_slocfromcode']").val()
+ '&sloctocode='+$("input[name='dlg_search_sloctocode']").val()
+ '&sono='+$("input[name='dlg_search_sono']").val();
	window.open('transferfg/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'transstockid='+$id
$.fn.yiiGridView.update("DetailtransstockdetList",{data:array});
} 