if("undefined"==typeof jQuery)throw new Error("Balance Sheet's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'balancesheet/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='repneracaid']").val(data.repneracaid);
			
			$("input[name='companyid']").val(data.companyid);
      $("input[name='accountid']").val('');
      $("input[name='isdebet']").prop('checked',true);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='accountname']").val('');
			
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
	jQuery.ajax({'url':'balancesheet/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='repneracaid']").val(data.repneracaid);
				
				$("input[name='companyid']").val(data.companyid);
      $("input[name='accountid']").val(data.accountid);
      if (data.isdebet == 1)
			{
				$("input[name='isdebet']").prop('checked',true);
			}
			else
			{
				$("input[name='isdebet']").prop('checked',false)
			}
      $("input[name='companyname']").val(data.companyname);
      $("input[name='accountname']").val(data.accountname);
				
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
var isdebet = 0;
	if ($("input[name='isdebet']").prop('checked'))
	{
		isdebet = 1;
	}
	else
	{
		isdebet = 0;
	}
	jQuery.ajax({'url':'balancesheet/save',
		'data':{
			
			'repneracaid':$("input[name='repneracaid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'accountid':$("input[name='accountid']").val(),
      'isdebet':isdebet,
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
	jQuery.ajax({'url':'balancesheet/delete',
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
	jQuery.ajax({'url':'balancesheet/purge','data':{'id':$id},
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
		'repneracaid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'accountname':$("input[name='dlg_search_accountname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'repneracaid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&reporttype='+$("select[name='dlg_search_reporttype']").val()
+ '&accounttype='+$("select[name='dlg_search_accounttype']").val()
+ '&reportdate='+$("input[name='dlg_search_date']").val()
;
	window.open('balancesheet/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'repneracaid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val();
	window.open('balancesheet/downxls?'+array);
}