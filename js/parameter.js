if("undefined"==typeof jQuery)throw new Error("Parameter's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'parameter/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='parameterid']").val(data.parameterid);
			
			$("input[name='paramname']").val('');
      $("input[name='paramvalue']").val('');
      $("input[name='description']").val('');
			
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
	jQuery.ajax({'url':'parameter/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='parameterid']").val(data.parameterid);
				
				$("input[name='paramname']").val(data.paramname);
      $("input[name='paramvalue']").val(data.paramvalue);
      $("input[name='description']").val(data.description);
				
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

	jQuery.ajax({'url':'parameter/save',
		'data':{
			
			'parameterid':$("input[name='parameterid']").val(),
			'paramname':$("input[name='paramname']").val(),
      'paramvalue':$("input[name='paramvalue']").val(),
      'description':$("input[name='description']").val(),
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
	jQuery.ajax({'url':'parameter/delete',
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
	jQuery.ajax({'url':'parameter/purge','data':{'id':$id},
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
		'parameterid':$id,
		'paramname':$("input[name='dlg_search_paramname']").val(),
		'paramvalue':$("input[name='dlg_search_paramvalue']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'parameterid='+$id
+ '&paramname='+$("input[name='dlg_search_paramname']").val()
+ '&paramvalue='+$("input[name='dlg_search_paramvalue']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('parameter/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'parameterid='+$id
+ '&paramname='+$("input[name='dlg_search_paramname']").val()
+ '&paramvalue='+$("input[name='dlg_search_paramvalue']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('parameter/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'parameterid='+$id
} 