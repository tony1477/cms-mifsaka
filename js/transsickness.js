if("undefined"==typeof jQuery)throw new Error("Transaction Sickness's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'transsickness/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transsicknessid']").val(data.transsicknessid);
			
			$("input[name='docdate']").val(data.docdate);
      $("input[name='employeeid']").val('');
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='description']").val('');
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val('');
      $("input[name='suratdokter']").val('');
			
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
	jQuery.ajax({'url':'transsickness/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transsicknessid']").val(data.transsicknessid);
				
				$("input[name='docdate']").val(data.docdate);
      $("input[name='employeeid']").val(data.employeeid);
      $("input[name='startdate']").val(data.startdate);
      $("input[name='enddate']").val(data.enddate);
      $("input[name='description']").val(data.description);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val(data.fullname);
      $("input[name='suratdokter']").val(data.suratdokter);
				
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

	jQuery.ajax({'url':'transsickness/save',
		'data':{
			
			'transsicknessid':$("input[name='transsicknessid']").val(),
			'docdate':$("input[name='docdate']").val(),
      'employeeid':$("input[name='employeeid']").val(),
      'startdate':$("input[name='startdate']").val(),
      'enddate':$("input[name='enddate']").val(),
      'description':$("input[name='description']").val(),
      'recordstatus':$("input[name='recordstatus']").val(),
      'suratdokter':$("input[name='suratdokter']").val(),
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
	jQuery.ajax({'url':'transsickness/approve',
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
	jQuery.ajax({'url':'transsickness/delete',
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
	jQuery.ajax({'url':'transsickness/purge','data':{'id':$id},
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
	var array = '='+
+ '&transsickno='+$("input[name='dlg_search_transsickno']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:{
		'transsicknessid':$id
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'transsicknessid='+$id
+ '&transsickno='+$("input[name='dlg_search_transsickno']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('transsickness/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'transsicknessid='+$id
+ '&transsickno='+$("input[name='dlg_search_transsickno']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('transsickness/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'transsicknessid='+$id
}