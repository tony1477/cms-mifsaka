if("undefined"==typeof jQuery)throw new Error("Family Relation's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'familyrelation/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='familyrelationid']").val(data.familyrelationid);
			
			$("input[name='familyrelationname']").val('');
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
	jQuery.ajax({'url':'familyrelation/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='familyrelationid']").val(data.familyrelationid);
				
				$("input[name='familyrelationname']").val(data.familyrelationname);
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
	jQuery.ajax({'url':'familyrelation/save',
		'data':{
			
			'familyrelationid':$("input[name='familyrelationid']").val(),
			'familyrelationname':$("input[name='familyrelationname']").val(),
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
	jQuery.ajax({'url':'familyrelation/delete',
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
	jQuery.ajax({'url':'familyrelation/purge','data':{'id':$id},
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
		'familyrelationid':$id,
		'familyrelationname':$("input[name='dlg_search_familyrelationname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'familyrelationid='+$id
+ '&familyrelationname='+$("input[name='dlg_search_familyrelationname']").val();
	window.open('familyrelation/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'familyrelationid='+$id
+ '&familyrelationname='+$("input[name='dlg_search_familyrelationname']").val();
	window.open('familyrelation/downxls?'+array);
}