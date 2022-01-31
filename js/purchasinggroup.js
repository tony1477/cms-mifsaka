if("undefined"==typeof jQuery)throw new Error("Purchasing Group's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'purchasinggroup/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='purchasinggroup_0_purchasinggroupid']").val(data.purchasinggroupid);
			$("input[name='purchasinggroup_0_purchasingorgid']").val('');
      $("input[name='purchasinggroup_0_purchasinggroupcode']").val('');
      $("input[name='purchasinggroup_0_description']").val('');
      $("input[name='purchasinggroup_0_recordstatus']").prop('checked',true);
      $("input[name='purchasinggroup_0_purchasingorgcode']").val('');
			
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
	jQuery.ajax({'url':'purchasinggroup/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='purchasinggroup_0_purchasinggroupid']").val(data.purchasinggroupid);
				$("input[name='purchasinggroup_0_purchasingorgid']").val(data.purchasingorgid);
      $("input[name='purchasinggroup_0_purchasinggroupcode']").val(data.purchasinggroupcode);
      $("input[name='purchasinggroup_0_description']").val(data.description);
      if (data.recordstatus == 1)
			{
				$("input[name='purchasinggroup_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='purchasinggroup_0_recordstatus']").prop('checked',false)
			}
      $("input[name='purchasinggroup_0_purchasingorgcode']").val(data.purchasingorgcode);
				
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
	if ($("input[name='purchasinggroup_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'purchasinggroup/save',
		'data':{
			'purchasinggroupid':$("input[name='purchasinggroup_0_purchasinggroupid']").val(),
			'purchasingorgid':$("input[name='purchasinggroup_0_purchasingorgid']").val(),
      'purchasinggroupcode':$("input[name='purchasinggroup_0_purchasinggroupcode']").val(),
      'description':$("input[name='purchasinggroup_0_description']").val(),
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
	jQuery.ajax({'url':'purchasinggroup/delete',
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
	jQuery.ajax({'url':'purchasinggroup/purge','data':{'id':$id},
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
	var array = 'purchasinggroupid='+$id
+ '&purchasingorgcode='+$("input[name='dlg_search_purchasingorgcode']").val()
+ '&purchasinggroupcode='+$("input[name='dlg_search_purchasinggroupcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'purchasinggroupid='+$id
+ '&purchasingorgcode='+$("input[name='dlg_search_purchasingorgcode']").val()
+ '&purchasinggroupcode='+$("input[name='dlg_search_purchasinggroupcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('purchasinggroup/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'purchasinggroupid='+$id
+ '&purchasingorgcode='+$("input[name='dlg_search_purchasingorgcode']").val()
+ '&purchasinggroupcode='+$("input[name='dlg_search_purchasinggroupcode']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('purchasinggroup/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'purchasinggroupid='+$id
} 