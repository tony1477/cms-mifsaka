if("undefined"==typeof jQuery)throw new Error("Employee Status's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeewstatus/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeewstatusid']").val(data.employeewstatusid);
			
			$("input[name='employeeid']").val('');
      $("input[name='employeestatusid']").val('');
      $("input[name='fullname']").val('');
      $("input[name='employeestatusname']").val('');
			
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
	jQuery.ajax({'url':'employeewstatus/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeewstatusid']").val(data.employeewstatusid);
				
				$("input[name='employeeid']").val(data.employeeid);
      $("input[name='employeestatusid']").val(data.employeestatusid);
      $("input[name='fullname']").val(data.fullname);
      $("input[name='employeestatusname']").val(data.employeestatusname);
				
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

	jQuery.ajax({'url':'employeewstatus/save',
		'data':{
			
			'employeewstatusid':$("input[name='employeewstatusid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
      'employeestatusid':$("input[name='employeestatusid']").val(),
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



function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'employeewstatus/purge','data':{'id':$id},
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
		'employeewstatusid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'employeestatusname':$("input[name='dlg_search_employeestatusname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeewstatusid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val();
	window.open('employeewstatus/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeewstatusid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val();
	window.open('employeewstatus/downxls?'+array);
}