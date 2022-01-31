if("undefined"==typeof jQuery)throw new Error("Onleave Transaction's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'onleavetrans/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='onleavetransid']").val(data.onleavetransid);
			$("input[name='docdate']").val(data.docdate);
      $("input[name='employeeid']").val('');
      $("input[name='onleavetypeid']").val('');
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='description']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val('');
      $("input[name='onleavename']").val('');
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
	jQuery.ajax({'url':'onleavetrans/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='onleavetransid']").val(data.onleavetransid);
				$("input[name='docdate']").val(data.docdate);
				$("input[name='employeeid']").val(data.employeeid);
				$("input[name='onleavetypeid']").val(data.onleavetypeid);
				$("input[name='startdate']").val(data.startdate);
				$("input[name='enddate']").val(data.enddate);
				$("input[name='description']").val(data.description);
				$("input[name='recordstatus']").val(data.recordstatus);
				$("input[name='fullname']").val(data.fullname);
				$("input[name='onleavename']").val(data.onleavename);
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
	jQuery.ajax({'url':'onleavetrans/save',
		'data':{
			'onleavetransid':$("input[name='onleavetransid']").val(),
			'docdate':$("input[name='docdate']").val(),
      'employeeid':$("input[name='employeeid']").val(),
      'onleavetypeid':$("input[name='onleavetypeid']").val(),
      'startdate':$("input[name='startdate']").val(),
      'enddate':$("input[name='enddate']").val(),
      'description':$("input[name='description']").val(),
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
	jQuery.ajax({'url':'onleavetrans/approve',
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
	jQuery.ajax({'url':'onleavetrans/delete',
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
	jQuery.ajax({'url':'onleavetrans/purge','data':{'id':$id},
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
		'onleavetransid':$id,
		'onleavetransno':$("input[name='dlg_search_onleavetransno']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'onleavename':$("input[name='dlg_search_onleavename']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'onleavetransid='+$id
+ '&onleavetransno='+$("input[name='dlg_search_onleavetransno']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('onleavetrans/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'onleavetransid='+$id
+ '&onleavetransno='+$("input[name='dlg_search_onleavetransno']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('onleavetrans/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'onleavetransid='+$id
} 