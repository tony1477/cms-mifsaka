if("undefined"==typeof jQuery)throw new Error("Address Book's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'addressbook/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
			$("input[name='addressbook_0_fullname']").val('');
      $("input[name='addressbook_0_iscustomer']").prop('checked',true);
      $("input[name='addressbook_0_isemployee']").prop('checked',true);
      $("input[name='addressbook_0_isvendor']").prop('checked',true);
      $("input[name='addressbook_0_ishospital']").prop('checked',true);
      $("input[name='addressbook_0_currentlimit']").val(data.currentlimit);
      $("input[name='addressbook_0_currentdebt']").val(data.currentdebt);
      $("input[name='addressbook_0_taxno']").val('');
      $("input[name='addressbook_0_creditlimit']").val(data.creditlimit);
      $("input[name='addressbook_0_isstrictlimit']").prop('checked',true);
      $("input[name='addressbook_0_bankname']").val('');
      $("input[name='addressbook_0_bankaccountno']").val('');
      $("input[name='addressbook_0_accountowner']").val('');
      $("input[name='addressbook_0_salesareaid']").val('');
      $("input[name='addressbook_0_pricecategoryid']").val('');
      $("input[name='addressbook_0_overdue']").val('');
      $("input[name='addressbook_0_invoicedate']").val(data.invoicedate);
      $("input[name='addressbook_0_recordstatus']").prop('checked',true);
      $("input[name='addressbook_0_areaname']").val('');
      $("input[name='addressbook_0_categoryname']").val('');
			
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
	jQuery.ajax({'url':'addressbook/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
				$("input[name='addressbook_0_fullname']").val(data.fullname);
      if (data.iscustomer == 1)
			{
				$("input[name='addressbook_0_iscustomer']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_iscustomer']").prop('checked',false)
			}
      if (data.isemployee == 1)
			{
				$("input[name='addressbook_0_isemployee']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_isemployee']").prop('checked',false)
			}
      if (data.isvendor == 1)
			{
				$("input[name='addressbook_0_isvendor']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_isvendor']").prop('checked',false)
			}
      if (data.ishospital == 1)
			{
				$("input[name='addressbook_0_ishospital']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_ishospital']").prop('checked',false)
			}
      $("input[name='addressbook_0_currentlimit']").val(data.currentlimit);
      $("input[name='addressbook_0_currentdebt']").val(data.currentdebt);
      $("input[name='addressbook_0_taxno']").val(data.taxno);
      $("input[name='addressbook_0_creditlimit']").val(data.creditlimit);
      if (data.isstrictlimit == 1)
			{
				$("input[name='addressbook_0_isstrictlimit']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_isstrictlimit']").prop('checked',false)
			}
      $("input[name='addressbook_0_bankname']").val(data.bankname);
      $("input[name='addressbook_0_bankaccountno']").val(data.bankaccountno);
      $("input[name='addressbook_0_accountowner']").val(data.accountowner);
      $("input[name='addressbook_0_salesareaid']").val(data.salesareaid);
      $("input[name='addressbook_0_pricecategoryid']").val(data.pricecategoryid);
      $("input[name='addressbook_0_overdue']").val(data.overdue);
      $("input[name='addressbook_0_invoicedate']").val(data.invoicedate);
      if (data.recordstatus == 1)
			{
				$("input[name='addressbook_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_recordstatus']").prop('checked',false)
			}
      $("input[name='addressbook_0_areaname']").val(data.areaname);
      $("input[name='addressbook_0_categoryname']").val(data.categoryname);
				
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
var iscustomer = 0;
	if ($("input[name='addressbook_0_iscustomer']").prop('checked'))
	{
		iscustomer = 1;
	}
	else
	{
		iscustomer = 0;
	}
var isemployee = 0;
	if ($("input[name='addressbook_0_isemployee']").prop('checked'))
	{
		isemployee = 1;
	}
	else
	{
		isemployee = 0;
	}
var isvendor = 0;
	if ($("input[name='addressbook_0_isvendor']").prop('checked'))
	{
		isvendor = 1;
	}
	else
	{
		isvendor = 0;
	}
var ishospital = 0;
	if ($("input[name='addressbook_0_ishospital']").prop('checked'))
	{
		ishospital = 1;
	}
	else
	{
		ishospital = 0;
	}
var isstrictlimit = 0;
	if ($("input[name='addressbook_0_isstrictlimit']").prop('checked'))
	{
		isstrictlimit = 1;
	}
	else
	{
		isstrictlimit = 0;
	}
var recordstatus = 0;
	if ($("input[name='addressbook_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'addressbook/save',
		'data':{
			'addressbookid':$("input[name='addressbook_0_addressbookid']").val(),
			'fullname':$("input[name='addressbook_0_fullname']").val(),
      'iscustomer':iscustomer,
      'isemployee':isemployee,
      'isvendor':isvendor,
      'ishospital':ishospital,
      'currentlimit':$("input[name='addressbook_0_currentlimit']").val(),
      'currentdebt':$("input[name='addressbook_0_currentdebt']").val(),
      'taxno':$("input[name='addressbook_0_taxno']").val(),
      'creditlimit':$("input[name='addressbook_0_creditlimit']").val(),
      'isstrictlimit':isstrictlimit,
      'bankname':$("input[name='addressbook_0_bankname']").val(),
      'bankaccountno':$("input[name='addressbook_0_bankaccountno']").val(),
      'accountowner':$("input[name='addressbook_0_accountowner']").val(),
      'salesareaid':$("input[name='addressbook_0_salesareaid']").val(),
      'pricecategoryid':$("input[name='addressbook_0_pricecategoryid']").val(),
      'overdue':$("input[name='addressbook_0_overdue']").val(),
      'invoicedate':$("input[name='addressbook_0_invoicedate']").val(),
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
	jQuery.ajax({'url':'addressbook/delete',
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
	jQuery.ajax({'url':'addressbook/purge','data':{'id':$id},
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
		'addressbookid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'taxno':$("input[name='dlg_search_taxno']").val(),
		'bankname':$("input[name='dlg_search_bankname']").val(),
		'bankaccountno':$("input[name='dlg_search_bankaccountno']").val(),
		'accountowner':$("input[name='dlg_search_accountowner']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'addressbookid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&bankaccountno='+$("input[name='dlg_search_bankaccountno']").val()
+ '&accountowner='+$("input[name='dlg_search_accountowner']").val();
	window.open('addressbook/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'addressbookid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&bankaccountno='+$("input[name='dlg_search_bankaccountno']").val()
+ '&accountowner='+$("input[name='dlg_search_accountowner']").val();
	window.open('addressbook/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'addressbookid='+$id
} 