if("undefined"==typeof jQuery)throw new Error("Transaction Out's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'transout/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transoutid']").val(data.transoutid);
			
			$("input[name='docdate']").val(data.docdate);
      $("input[name='employeeid']").val('');
      $("input[name='permitexitid']").val('');
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='description']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val('');
      $("input[name='permitexitname']").val('');
			
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
	jQuery.ajax({'url':'transout/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transoutid']").val(data.transoutid);
				
				$("input[name='docdate']").val(data.docdate);
      $("input[name='employeeid']").val(data.employeeid);
      $("input[name='permitexitid']").val(data.permitexitid);
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='description']").val(data.description);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val(data.fullname);
      $("input[name='permitexitname']").val(data.permitexitname);
				
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

	jQuery.ajax({'url':'transout/save',
		'data':{
			
			'transoutid':$("input[name='transoutid']").val(),
			'docdate':$("input[name='docdate']").val(),
      'employeeid':$("input[name='employeeid']").val(),
      'permitexitid':$("input[name='permitexitid']").val(),
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
	$.msg.confirmation('Confirm','',function(){	
	jQuery.ajax({'url':'transout/approve',
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
	$.msg.confirmation('Confirm','',function(){	
	jQuery.ajax({'url':'transout/delete',
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
	$.msg.confirmation('Confirm','',function(){
	jQuery.ajax({'url':'transout/purge','data':{'id':$id},
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
		'transoutid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'permitexitname':$("input[name='dlg_search_permitexitname']").val(),
		'description':$("input[name='dlg_search_description']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'transoutid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&permitexitname='+$("input[name='dlg_search_permitexitname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('transout/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'transoutid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&permitexitname='+$("input[name='dlg_search_permitexitname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('transout/downxls?'+array);
}