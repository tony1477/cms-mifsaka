if("undefined"==typeof jQuery)throw new Error("Material Group's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'materialgroup/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='materialgroup_0_materialgroupid']").val(data.materialgroupid);
			$("input[name='materialgroup_0_materialgroupcode']").val('');
      $("input[name='materialgroup_0_description']").val('');
      $("input[name='materialgroup_0_parentmatgroupid']").val('');
      $("input[name='materialgroup_0_isfg']").val('');
      $("input[name='materialgroup_0_recordstatus']").prop('checked',true);
      $("input[name='materialgroup_0_parentmatgroup']").val('');
			
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
	jQuery.ajax({'url':'materialgroup/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='materialgroup_0_materialgroupid']").val(data.materialgroupid);
				$("input[name='materialgroup_0_materialgroupcode']").val(data.materialgroupcode);
      $("input[name='materialgroup_0_description']").val(data.description);
      $("input[name='materialgroup_0_parentmatgroupid']").val(data.parentmatgroupid);
      if (data.isfg == 1)
			{
				$("input[name='materialgroup_0_isfg']").prop('checked',true);
			}
			else
			{
				$("input[name='materialgroup_0_isfg']").prop('checked',false)
			}
      if (data.recordstatus == 1)
			{
				$("input[name='materialgroup_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='materialgroup_0_recordstatus']").prop('checked',false)
			}
      $("input[name='materialgroup_0_parentmatgroup']").val(data.parentmatgroup);
				
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
var isfg = 0;
	if ($("input[name='materialgroup_0_isfg']").prop('checked'))
	{
		isfg = 1;
	}
	else
	{
		isfg = 0;
	}
var recordstatus = 0;
	if ($("input[name='materialgroup_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'materialgroup/save',
		'data':{
			'materialgroupid':$("input[name='materialgroup_0_materialgroupid']").val(),
			'materialgroupcode':$("input[name='materialgroup_0_materialgroupcode']").val(),
      'description':$("input[name='materialgroup_0_description']").val(),
      'parentmatgroupid':$("input[name='materialgroup_0_parentmatgroupid']").val(),
      'isfg':isfg,
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'materialgroup/delete',
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
	jQuery.ajax({'url':'materialgroup/purge','data':{'id':$id},
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
		'materialgroupid':$id,
		'materialgroupcode':$("input[name='dlg_search_materialgroupcode']").val(),
		'description':$("input[name='dlg_search_description']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'materialgroupid='+$id
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('materialgroup/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'materialgroupid='+$id
+ '&materialgroupcode='+$("input[name='dlg_search_materialgroupcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
	window.open('materialgroup/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'materialgroupid='+$id
} 