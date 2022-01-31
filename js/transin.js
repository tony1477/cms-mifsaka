if("undefined"==typeof jQuery)throw new Error("Transaction Permit In's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'transin/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transinid']").val(data.transinid);
				$("input[name='docdate']").val(data.docdate);
				$("input[name='employeeid']").val('');
				$("input[name='permitinid']").val('');
				$("textarea[name='description']").val('');
				$("input[name='recordstatus']").val(data.recordstatus);
				$("input[name='fullname']").val('');
				$("input[name='permitinname']").val('');
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

function updatedata($id)
{
	jQuery.ajax({'url':'transin/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transinid']").val(data.transinid);
				$("input[name='docdate']").val(data.docdate);
				$("input[name='employeeid']").val(data.employeeid);
				$("input[name='permitinid']").val(data.permitinid);
				$("textarea[name='description']").val(data.description);
				$("input[name='recordstatus']").val(data.recordstatus);
				$("input[name='fullname']").val(data.fullname);
				$("input[name='permitinname']").val(data.permitinname);
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

function savedata()
{
	jQuery.ajax({'url':'transin/save',
		'data':{
			'transinid':$("input[name='transinid']").val(),
			'docdate':$("input[name='docdate']").val(),
      'employeeid':$("input[name='employeeid']").val(),
      'permitinid':$("input[name='permitinid']").val(),
      'description':$("textarea[name='description']").val(),
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

function approvedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'transin/approve',
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
	jQuery.ajax({'url':'transin/delete',
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
	jQuery.ajax({'url':'transin/purge','data':{'id':$id},
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
		'transinid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'permitinname':$("input[name='dlg_search_permitinname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'transinid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&permitinname='+$("input[name='dlg_search_permitinname']").val();
	window.open('transin/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'transinid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&permitinname='+$("input[name='dlg_search_permitinname']").val();
	window.open('transin/downxls?'+array);
}