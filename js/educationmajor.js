if("undefined"==typeof jQuery)throw new Error("Education Major's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'educationmajor/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='educationmajorid']").val(data.educationmajorid);
			
			$("input[name='educationid']").val('');
      $("input[name='educationmajorname']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='educationname']").val('');
			
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
	jQuery.ajax({'url':'educationmajor/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='educationmajorid']").val(data.educationmajorid);
				
				$("input[name='educationid']").val(data.educationid);
      $("input[name='educationmajorname']").val(data.educationmajorname);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='educationname']").val(data.educationname);
				
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
	jQuery.ajax({'url':'educationmajor/save',
		'data':{
			
			'educationmajorid':$("input[name='educationmajorid']").val(),
			'educationid':$("input[name='educationid']").val(),
      'educationmajorname':$("input[name='educationmajorname']").val(),
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
	jQuery.ajax({'url':'educationmajor/delete',
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
	jQuery.ajax({'url':'educationmajor/purge','data':{'id':$id},
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
		'educationmajorid':$id,
		'educationname':$("input[name='dlg_search_educationname']").val(),
		'educationmajorname':$("input[name='dlg_search_educationmajorname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'educationmajorid='+$id
+ '&educationname='+$("input[name='dlg_search_educationname']").val()
+ '&educationmajorname='+$("input[name='dlg_search_educationmajorname']").val();
	window.open('educationmajor/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'educationmajorid='+$id
+ '&educationname='+$("input[name='dlg_search_educationname']").val()
+ '&educationmajorname='+$("input[name='dlg_search_educationmajorname']").val();
	window.open('educationmajor/downxls?'+array);
} 