if("undefined"==typeof jQuery)throw new Error("Tax Wage Progressif's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'taxwageprogressif/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='taxwageprogressifid']").val(data.taxwageprogressifid);
			
			$("input[name='description']").val('');
      $("input[name='minvalue']").val(data.minvalue);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='valuepercent']").val(data.valuepercent);
      $("input[name='recordstatus']").prop('checked',true);
			
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
	jQuery.ajax({'url':'taxwageprogressif/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='taxwageprogressifid']").val(data.taxwageprogressifid);
				
				$("input[name='description']").val(data.description);
      $("input[name='minvalue']").val(data.minvalue);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='valuepercent']").val(data.valuepercent);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
				
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
	jQuery.ajax({'url':'taxwageprogressif/save',
		'data':{
			
			'taxwageprogressifid':$("input[name='taxwageprogressifid']").val(),
			'description':$("input[name='description']").val(),
      'minvalue':$("input[name='minvalue']").val(),
      'maxvalue':$("input[name='maxvalue']").val(),
      'valuepercent':$("input[name='valuepercent']").val(),
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
	jQuery.ajax({'url':'taxwageprogressif/delete',
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
	jQuery.ajax({'url':'taxwageprogressif/purge','data':{'id':$id},
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
		'taxwageprogressifid':$id,
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'taxwageprogressifid='+$id
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('taxwageprogressif/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'taxwageprogressifid='+$id
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('taxwageprogressif/downxls?'+array);
}