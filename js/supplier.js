if("undefined"==typeof jQuery)throw new Error("Supplier's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'supplier/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
			$("input[name='addressbook_0_fullname']").val('');
      $("input[name='addressbook_0_isvendor']").prop('checked',true);
      $("input[name='addressbook_0_taxno']").val('');
      $("input[name='addressbook_0_bankname']").val('');
      $("input[name='addressbook_0_bankaccountno']").val('');
      $("input[name='addressbook_0_accountowner']").val('');
      $("input[name='addressbook_0_logo']").val('');
      $("input[name='addressbook_0_recordstatus']").prop('checked',true);
			$.fn.yiiGridView.update('addressList',{data:{'addressbookid':data.addressbookid}});
$.fn.yiiGridView.update('addresscontactList',{data:{'addressbookid':data.addressbookid}});
$.fn.yiiGridView.update('addressaccountList',{data:{'addressbookid':data.addressbookid}});

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
function newdataaddress()
{
	jQuery.ajax({'url':'supplier/createaddress','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='address_1_addressid']").val('');
      $("input[name='address_1_addresstypeid']").val('');
      $("input[name='address_1_addressname']").val('');
      $("input[name='address_1_rt']").val('');
      $("input[name='address_1_rw']").val('');
      $("input[name='address_1_cityid']").val('');
      $("input[name='address_1_phoneno']").val('');
      $("input[name='address_1_faxno']").val('');
      $("input[name='address_1_lat']").val('');
      $("input[name='address_1_lng']").val('');
      $("input[name='address_1_addresstypename']").val('');
      $("input[name='address_1_cityname']").val('');
			$('#InputDialogaddress').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataaddresscontact()
{
	jQuery.ajax({'url':'supplier/createaddresscontact','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addresscontact_2_addresscontactid']").val('');
      $("input[name='addresscontact_2_contacttypeid']").val('');
      $("input[name='addresscontact_2_addresscontactname']").val('');
      $("input[name='addresscontact_2_phoneno']").val('');
      $("input[name='addresscontact_2_mobilephone']").val('');
      $("input[name='addresscontact_2_emailaddress']").val('');
      $("input[name='addresscontact_2_contacttypename']").val('');
			$('#InputDialogaddresscontact').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataaddressaccount()
{
	jQuery.ajax({'url':'supplier/createaddressaccount','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressaccount_3_addressaccountid']").val('');
      $("input[name='addressaccount_3_companyid']").val(data.companyid);
      $("input[name='addressaccount_3_acchutangid']").val('');
      $("input[name='addressaccount_3_recordstatus']").prop('checked',true);
      $("input[name='addressaccount_3_companyname']").val(data.companyname);
      $("input[name='addressaccount_3_acchutangname']").val('');
			$('#InputDialogaddressaccount').modal();
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
	jQuery.ajax({'url':'supplier/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
				$("input[name='addressbook_0_fullname']").val(data.fullname);
      if (data.isvendor == 1)
			{
				$("input[name='addressbook_0_isvendor']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_isvendor']").prop('checked',false)
			}
      $("input[name='addressbook_0_taxno']").val(data.taxno);
      $("input[name='addressbook_0_bankname']").val(data.bankname);
      $("input[name='addressbook_0_bankaccountno']").val(data.bankaccountno);
      $("input[name='addressbook_0_accountowner']").val(data.accountowner);
      $("input[name='addressbook_0_logo']").val(data.logo);
      if (data.recordstatus == 1)
			{
				$("input[name='addressbook_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='addressbook_0_recordstatus']").prop('checked',false)
			}
				$.fn.yiiGridView.update('addressList',{data:{'addressbookid':data.addressbookid}});
$.fn.yiiGridView.update('addresscontactList',{data:{'addressbookid':data.addressbookid}});
$.fn.yiiGridView.update('addressaccountList',{data:{'addressbookid':data.addressbookid}});

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
function updatedataaddress($id)
{
	jQuery.ajax({'url':'supplier/updateaddress','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='address_1_addressid']").val(data.addressid);
      $("input[name='address_1_addresstypeid']").val(data.addresstypeid);
      $("input[name='address_1_addressname']").val(data.addressname);
      $("input[name='address_1_rt']").val(data.rt);
      $("input[name='address_1_rw']").val(data.rw);
      $("input[name='address_1_cityid']").val(data.cityid);
      $("input[name='address_1_phoneno']").val(data.phoneno);
      $("input[name='address_1_faxno']").val(data.faxno);
      $("input[name='address_1_lat']").val(data.lat);
      $("input[name='address_1_lng']").val(data.lng);
      $("input[name='address_1_addresstypename']").val(data.addresstypename);
      $("input[name='address_1_cityname']").val(data.cityname);
			$('#InputDialogaddress').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataaddresscontact($id)
{
	jQuery.ajax({'url':'supplier/updateaddresscontact','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addresscontact_2_addresscontactid']").val(data.addresscontactid);
      $("input[name='addresscontact_2_contacttypeid']").val(data.contacttypeid);
      $("input[name='addresscontact_2_addresscontactname']").val(data.addresscontactname);
      $("input[name='addresscontact_2_phoneno']").val(data.phoneno);
      $("input[name='addresscontact_2_mobilephone']").val(data.mobilephone);
      $("input[name='addresscontact_2_emailaddress']").val(data.emailaddress);
      $("input[name='addresscontact_2_contacttypename']").val(data.contacttypename);
			$('#InputDialogaddresscontact').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataaddressaccount($id)
{
	jQuery.ajax({'url':'supplier/updateaddressaccount','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressaccount_3_addressaccountid']").val(data.addressaccountid);
      $("input[name='addressaccount_3_companyid']").val(data.companyid);
      $("input[name='addressaccount_3_acchutangid']").val(data.acchutangid);
      if (data.recordstatus == 1)
			{
				$("input[name='addressaccount_3_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='addressaccount_3_recordstatus']").prop('checked',false)
			}
      $("input[name='addressaccount_3_companyname']").val(data.companyname);
      $("input[name='addressaccount_3_acchutangname']").val(data.acchutangname);
			$('#InputDialogaddressaccount').modal();
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
var isvendor = 0;
	if ($("input[name='addressbook_0_isvendor']").prop('checked'))
	{
		isvendor = 1;
	}
	else
	{
		isvendor = 0;
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
	jQuery.ajax({'url':'supplier/save',
		'data':{
			'addressbookid':$("input[name='addressbook_0_addressbookid']").val(),
			'fullname':$("input[name='addressbook_0_fullname']").val(),
      'isvendor':isvendor,
      'taxno':$("input[name='addressbook_0_taxno']").val(),
      'bankname':$("input[name='addressbook_0_bankname']").val(),
      'bankaccountno':$("input[name='addressbook_0_bankaccountno']").val(),
      'accountowner':$("input[name='addressbook_0_accountowner']").val(),
      'logo':$("input[name='addressbook_0_logo']").val(),
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

function savedataaddress()
{

	jQuery.ajax({'url':'supplier/saveaddress',
		'data':{
			'addressbookid':$("input[name='addressbook_0_addressbookid']").val(),
			'addressid':$("input[name='address_1_addressid']").val(),
      'addresstypeid':$("input[name='address_1_addresstypeid']").val(),
      'addressname':$("input[name='address_1_addressname']").val(),
      'rt':$("input[name='address_1_rt']").val(),
      'rw':$("input[name='address_1_rw']").val(),
      'cityid':$("input[name='address_1_cityid']").val(),
      'phoneno':$("input[name='address_1_phoneno']").val(),
      'faxno':$("input[name='address_1_faxno']").val(),
      'lat':$("input[name='address_1_lat']").val(),
      'lng':$("input[name='address_1_lng']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogaddress').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedataaddresscontact()
{

	jQuery.ajax({'url':'supplier/saveaddresscontact',
		'data':{
			'addressbookid':$("input[name='addressbook_0_addressbookid']").val(),
			'addresscontactid':$("input[name='addresscontact_2_addresscontactid']").val(),
      'contacttypeid':$("input[name='addresscontact_2_contacttypeid']").val(),
      'addresscontactname':$("input[name='addresscontact_2_addresscontactname']").val(),
      'phoneno':$("input[name='addresscontact_2_phoneno']").val(),
      'mobilephone':$("input[name='addresscontact_2_mobilephone']").val(),
      'emailaddress':$("input[name='addresscontact_2_emailaddress']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogaddresscontact').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("addresscontactList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function savedataaddressaccount()
{
var recordstatus = 0;
	if ($("input[name='addressaccount_3_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'supplier/saveaddressaccount',
		'data':{
			'addressbookid':$("input[name='addressbook_0_addressbookid']").val(),
			'addressaccountid':$("input[name='addressaccount_3_addressaccountid']").val(),
      'companyid':$("input[name='addressaccount_3_companyid']").val(),
      'acchutangid':$("input[name='addressaccount_3_acchutangid']").val(),
      'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogaddressaccount').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressaccountList");
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
	jQuery.ajax({'url':'supplier/delete',
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
	jQuery.ajax({'url':'supplier/purge','data':{'id':$id},
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
function purgedataaddress()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'supplier/purgeaddress','data':{'id':$.fn.yiiGridView.getSelection("addressList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressList");
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
function purgedataaddresscontact()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'supplier/purgeaddresscontact','data':{'id':$.fn.yiiGridView.getSelection("addresscontactList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("addresscontactList");
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
function purgedataaddressaccount()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'supplier/purgeaddressaccount','data':{'id':$.fn.yiiGridView.getSelection("addressaccountList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressaccountList");
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
	window.open('supplier/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'addressbookid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&bankname='+$("input[name='dlg_search_bankname']").val()
+ '&bankaccountno='+$("input[name='dlg_search_bankaccountno']").val()
+ '&accountowner='+$("input[name='dlg_search_accountowner']").val();
	window.open('supplier/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'addressbookid='+$id
$.fn.yiiGridView.update("DetailaddressList",{data:array});
$.fn.yiiGridView.update("DetailaddresscontactList",{data:array});
$.fn.yiiGridView.update("DetailaddressaccountList",{data:array});
} 