if("undefined"==typeof jQuery)throw new Error("Onleave Type's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'onleavetype/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='onleavetypeid']").val(data.onleavetypeid);
			
			$("input[name='onleavename']").val('');
      $("input[name='cutimax']").val('');
      $("input[name='cutistart']").val('');
      $("input[name='snroid']").val('');
      $("input[name='absstatusid']").val('');
      $("input[name='recordstatus']").prop('checked',true);
      $("input[name='snrodesc']").val('');
      $("input[name='shortstat']").val('');
			
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
	jQuery.ajax({'url':'onleavetype/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='onleavetypeid']").val(data.onleavetypeid);
				
				$("input[name='onleavename']").val(data.onleavename);
      $("input[name='cutimax']").val(data.cutimax);
      $("input[name='cutistart']").val(data.cutistart);
      $("input[name='snroid']").val(data.snroid);
      $("input[name='absstatusid']").val(data.absstatusid);
      if (data.recordstatus == 1)
			{
				$("input[name='recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='recordstatus']").prop('checked',false)
			}
      $("input[name='snrodesc']").val(data.snrodesc);
      $("input[name='shortstat']").val(data.shortstat);
				
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
	jQuery.ajax({'url':'onleavetype/save',
		'data':{
			
			'onleavetypeid':$("input[name='onleavetypeid']").val(),
			'onleavename':$("input[name='onleavename']").val(),
      'cutimax':$("input[name='cutimax']").val(),
      'cutistart':$("input[name='cutistart']").val(),
      'snroid':$("input[name='snroid']").val(),
      'absstatusid':$("input[name='absstatusid']").val(),
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
	jQuery.ajax({'url':'onleavetype/delete',
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
	jQuery.ajax({'url':'onleavetype/purge','data':{'id':$id},
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
		'onleavetypeid':$id,
		'onleavename':$("input[name='dlg_search_onleavename']").val(),
		'snrodesc':$("input[name='dlg_search_snrodesc']").val(),
		'shortstat':$("input[name='dlg_search_shortstat']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'onleavetypeid='+$id
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('onleavetype/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'onleavetypeid='+$id
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val()
+ '&snrodesc='+$("input[name='dlg_search_snrodesc']").val()
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val();
	window.open('onleavetype/downxls?'+array);
}