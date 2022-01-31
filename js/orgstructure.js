if("undefined"==typeof jQuery)throw new Error("Organization Structure's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'orgstructure/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='orgstructureid']").val(data.orgstructureid);
				$("input[name='companyid']").val('');
				$("input[name='structurename']").val('');
				$("input[name='parentid']").val('');
				$("input[name='recordstatus']").prop('checked',true);
				$("input[name='companyname']").val('');
				$("input[name='parentname']").val('');
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
	jQuery.ajax({'url':'orgstructure/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='orgstructureid']").val(data.orgstructureid);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='structurename']").val(data.structurename);
				$("input[name='parentid']").val(data.parentid);
				if (data.recordstatus == 1)
				{
					$("input[name='recordstatus']").prop('checked',true);
				}
				else
				{
					$("input[name='recordstatus']").prop('checked',false)
				}
				$("input[name='companyname']").val(data.companyname);
				$("input[name='parentname']").val(data.parentname);
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
var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'orgstructure/save',
		'data':{
			'orgstructureid':$("input[name='orgstructureid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'structurename':$("input[name='structurename']").val(),
      'parentid':$("input[name='parentid']").val(),
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

function deletedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'orgstructure/delete',
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
	jQuery.ajax({'url':'orgstructure/purge','data':{'id':$id},
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
		'orgstructureid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'structurename':$("input[name='dlg_search_structurename']").val(),
		'parentname':$("input[name='dlg_search_parentname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'orgstructureid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&parentname='+$("input[name='dlg_search_parentname']").val();
	window.open('orgstructure/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'orgstructureid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&parentname='+$("input[name='dlg_search_parentname']").val();
	window.open('orgstructure/downxls?'+array);
}