if("undefined"==typeof jQuery)throw new Error("Wage Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'wagetype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='wagetypeid']").val(data.wagetypeid);
			
			$("input[name='wagename']").val('');
      $("input[name='ispph']").prop('checked',true);
      $("input[name='ispayroll']").prop('checked',true);
      $("input[name='isprint']").prop('checked',true);
      $("input[name='percentage']").val(data.percentage);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='isrutin']").prop('checked',true);
      $("input[name='paidbycompany']").prop('checked',true);
      $("input[name='pphbycompany']").prop('checked',true);
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='currencyname']").val(data.currencyname);
			
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
	jQuery.ajax({'url':'wagetype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='wagetypeid']").val(data.wagetypeid);
				
				$("input[name='wagename']").val(data.wagename);
      if (data.ispph == 1)
			{
				$("input[name='ispph']").prop('checked',true);
			}
			else
			{
				$("input[name='ispph']").prop('checked',false)
			}
      if (data.ispayroll == 1)
			{
				$("input[name='ispayroll']").prop('checked',true);
			}
			else
			{
				$("input[name='ispayroll']").prop('checked',false)
			}
      if (data.isprint == 1)
			{
				$("input[name='isprint']").prop('checked',true);
			}
			else
			{
				$("input[name='isprint']").prop('checked',false)
			}
      $("input[name='percentage']").val(data.percentage);
      $("input[name='maxvalue']").val(data.maxvalue);
      $("input[name='currencyid']").val(data.currencyid);
      if (data.isrutin == 1)
			{
				$("input[name='isrutin']").prop('checked',true);
			}
			else
			{
				$("input[name='isrutin']").prop('checked',false)
			}
      if (data.paidbycompany == 1)
			{
				$("input[name='paidbycompany']").prop('checked',true);
			}
			else
			{
				$("input[name='paidbycompany']").prop('checked',false)
			}
      if (data.pphbycompany == 1)
			{
				$("input[name='pphbycompany']").prop('checked',true);
			}
			else
			{
				$("input[name='pphbycompany']").prop('checked',false)
			}
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='currencyname']").val(data.currencyname);
				
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
var ispph = 0;
	if ($("input[name='ispph']").prop('checked'))
	{
		ispph = 1;
	}
	else
	{
		ispph = 0;
	}
var ispayroll = 0;
	if ($("input[name='ispayroll']").prop('checked'))
	{
		ispayroll = 1;
	}
	else
	{
		ispayroll = 0;
	}
var isprint = 0;
	if ($("input[name='isprint']").prop('checked'))
	{
		isprint = 1;
	}
	else
	{
		isprint = 0;
	}
var isrutin = 0;
	if ($("input[name='isrutin']").prop('checked'))
	{
		isrutin = 1;
	}
	else
	{
		isrutin = 0;
	}
var paidbycompany = 0;
	if ($("input[name='paidbycompany']").prop('checked'))
	{
		paidbycompany = 1;
	}
	else
	{
		paidbycompany = 0;
	}
var pphbycompany = 0;
	if ($("input[name='pphbycompany']").prop('checked'))
	{
		pphbycompany = 1;
	}
	else
	{
		pphbycompany = 0;
	}
var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'wagetype/save',
		'data':{
			
			'wagetypeid':$("input[name='wagetypeid']").val(),
			'wagename':$("input[name='wagename']").val(),
      'ispph':ispph,
      'ispayroll':ispayroll,
      'isprint':isprint,
      'percentage':$("input[name='percentage']").val(),
      'maxvalue':$("input[name='maxvalue']").val(),
      'currencyid':$("input[name='currencyid']").val(),
      'isrutin':isrutin,
      'paidbycompany':paidbycompany,
      'pphbycompany':pphbycompany,
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
	jQuery.ajax({'url':'wagetype/delete',
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
	jQuery.ajax({'url':'wagetype/purge','data':{'id':$id},
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
		'wagetypeid':$id,
		'wagename':$("input[name='dlg_search_wagename']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'wagetypeid='+$id
+ '&wagename='+$("input[name='dlg_search_wagename']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('wagetype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'wagetypeid='+$id
+ '&wagename='+$("input[name='dlg_search_wagename']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('wagetype/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'wagetypeid='+$id
}