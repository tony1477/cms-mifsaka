if("undefined"==typeof jQuery)throw new Error("Letter of Intent's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'letterofintent/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='letterofintentid']").val(data.letterofintentid);
			$("input[name='actiontype']").val(0);
			$("input[name='loidate']").val(data.loidate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='addressbookid']").val('');
      $("input[name='loidoc']").val('');
      $("input[name='companyname']").val(data.companyname);
      $("input[name='fullname']").val('');
			$.fn.yiiGridView.update('loidetailList',{data:{'letterofintentid':data.letterofintentid}});

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
function newdataloidetail()
{
	jQuery.ajax({'url':'letterofintent/createloidetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='loidetailid']").val('');
      $("input[name='productid']").val('');
      $("input[name='productname']").val('');
			$('#InputDialogloidetail').modal();
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
	jQuery.ajax({'url':'letterofintent/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='letterofintentid']").val(data.letterofintentid);
				$("input[name='actiontype']").val(1);
				$("input[name='loidate']").val(data.loidate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='addressbookid']").val(data.addressbookid);
      $("input[name='loidoc']").val(data.loidoc);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='fullname']").val(data.fullname);
				$.fn.yiiGridView.update('loidetailList',{data:{'letterofintentid':data.letterofintentid}});

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
function updatedataloidetail($id)
{
	jQuery.ajax({'url':'letterofintent/updateloidetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='loidetailid']").val(data.loidetailid);
      $("input[name='productid']").val(data.productid);
      $("input[name='productname']").val(data.productname);
			$('#InputDialogloidetail').modal();
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

	jQuery.ajax({'url':'letterofintent/save',
		'data':{
			'actiontype':$("input[name='actiontype']").val(),
			'letterofintentid':$("input[name='letterofintentid']").val(),
			'loidate':$("input[name='loidate']").val(),
      'companyid':$("input[name='companyid']").val(),
      'addressbookid':$("input[name='addressbookid']").val(),
      'loidoc':$("input[name='loidoc']").val(),
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

function savedataloidetail()
{

	jQuery.ajax({'url':'letterofintent/saveloidetail',
		'data':{
			'letterofintentid':$("input[name='letterofintentid']").val(),
			'loidetailid':$("input[name='loidetailid']").val(),
      'productid':$("input[name='productid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogloidetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("loidetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}



function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'letterofintent/purge','data':{'id':$id},
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
function purgedataloidetail()
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'letterofintent/purgeloidetail','data':{'id':$.fn.yiiGridView.getSelection("loidetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("loidetailList");
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
		'letterofintentid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'loidoc':$("input[name='dlg_search_loidoc']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'letterofintentid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&loidoc='+$("input[name='dlg_search_loidoc']").val();
	window.open('letterofintent/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'letterofintentid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&loidoc='+$("input[name='dlg_search_loidoc']").val();
	window.open('letterofintent/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'letterofintentid='+$id
$.fn.yiiGridView.update("DetailloidetailList",{data:array});
}