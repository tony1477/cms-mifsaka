if("undefined"==typeof jQuery)throw new Error("Payment Request's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'account/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='account_0_accountid']").val(data.accountid);
			$("input[name='account_0_companyid']").val(data.companyid);
      $("input[name='account_0_accountcode']").val('');
      $("input[name='account_0_accountname']").val('');
      $("input[name='account_0_parentaccountid']").val('');
      $("input[name='account_0_currencyid']").val(data.currencyid);
      $("input[name='account_0_accounttypeid']").val('');
      $("input[name='account_0_recordstatus']").prop('checked',true);
      $("input[name='account_0_companyname']").val(data.companyname);
      $("input[name='account_0_parentaccountname']").val('');
      $("input[name='account_0_currencyname']").val(data.currencyname);
      $("input[name='account_0_accounttypename']").val('');
			
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
	jQuery.ajax({'url':'account/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='account_0_accountid']").val(data.accountid);
				$("input[name='account_0_companyid']").val(data.companyid);
      $("input[name='account_0_accountcode']").val(data.accountcode);
      $("input[name='account_0_accountname']").val(data.accountname);
      $("input[name='account_0_parentaccountid']").val(data.parentaccountid);
      $("input[name='account_0_currencyid']").val(data.currencyid);
      $("input[name='account_0_accounttypeid']").val(data.accounttypeid);
      if (data.recordstatus == 1)
			{
				$("input[name='account_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='account_0_recordstatus']").prop('checked',false)
			}
      $("input[name='account_0_companyname']").val(data.companyname);
      $("input[name='account_0_parentaccountname']").val(data.parentaccountname);
      $("input[name='account_0_currencyname']").val(data.currencyname);
      $("input[name='account_0_accounttypename']").val(data.accounttypename);
				
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
	if ($("input[name='account_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'account/save',
		'data':{
			'accountid':$("input[name='account_0_accountid']").val(),
			'companyid':$("input[name='account_0_companyid']").val(),
      'accountcode':$("input[name='account_0_accountcode']").val(),
      'accountname':$("input[name='account_0_accountname']").val(),
      'parentaccountid':$("input[name='account_0_parentaccountid']").val(),
      'currencyid':$("input[name='account_0_currencyid']").val(),
      'accounttypeid':$("input[name='account_0_accounttypeid']").val(),
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'account/delete',
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
	jQuery.ajax({'url':'account/purge','data':{'id':$id},
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
		'accountid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'accountname':$("input[name='dlg_search_accountname']").val(),
		'accountcode':$("input[name='dlg_search_accountcode']").val(),
		'parentaccountname':$("input[name='dlg_search_parentaccountname']").val(),
		'currencyname':$("input[name='dlg_search_currencyname']").val(),
		'accounttypename':$("input[name='dlg_search_accounttypename']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'accountid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountcode='+$("input[name='dlg_search_accountcode']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&parentaccountname='+$("input[name='dlg_search_parentaccountname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&accounttypename='+$("input[name='dlg_search_accounttypename']").val();
	window.open('account/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'accountid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountcode='+$("input[name='dlg_search_accountcode']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&parentaccountname='+$("input[name='dlg_search_parentaccountname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&accounttypename='+$("input[name='dlg_search_accounttypename']").val();
	window.open('account/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'accountid='+$id
} 