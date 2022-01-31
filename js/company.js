if("undefined"==typeof jQuery)throw new Error("Company's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'company/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='company_0_companyid']").val(data.companyid);
			$("input[name='company_0_companyname']").val('');
      $("input[name='company_0_companycode']").val('');
      $("input[name='company_0_address']").val('');
      $("input[name='company_0_cityid']").val('');
      $("input[name='company_0_zipcode']").val('');
      $("input[name='company_0_taxno']").val('');
      $("input[name='company_0_currencyid']").val(data.currencyid);
      $("input[name='company_0_faxno']").val('');
      $("input[name='company_0_phoneno']").val('');
      $("input[name='company_0_webaddress']").val('');
      $("input[name='company_0_email']").val('');
      $("input[name='company_0_leftlogofile']").val('');
      $("input[name='company_0_rightlogofile']").val('');
      $("input[name='company_0_isholding']").prop('checked',true);
      $("input[name='company_0_billto']").val('');
      $("input[name='company_0_bankacc1']").val('');
      $("input[name='company_0_bankacc2']").val('');
      $("input[name='company_0_bankacc3']").val('');
      $("input[name='company_0_cityname']").val('');
      $("input[name='company_0_currencyname']").val(data.currencyname);
			
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
	jQuery.ajax({'url':'company/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='company_0_companyid']").val(data.companyid);
				$("input[name='company_0_companyname']").val(data.companyname);
      $("input[name='company_0_companycode']").val(data.companycode);
      $("input[name='company_0_address']").val(data.address);
      $("input[name='company_0_cityid']").val(data.cityid);
      $("input[name='company_0_zipcode']").val(data.zipcode);
      $("input[name='company_0_taxno']").val(data.taxno);
      $("input[name='company_0_currencyid']").val(data.currencyid);
      $("input[name='company_0_faxno']").val(data.faxno);
      $("input[name='company_0_phoneno']").val(data.phoneno);
      $("input[name='company_0_webaddress']").val(data.webaddress);
      $("input[name='company_0_email']").val(data.email);
      $("input[name='company_0_leftlogofile']").val(data.leftlogofile);
      $("input[name='company_0_rightlogofile']").val(data.rightlogofile);
      if (data.isholding == 1)
			{
				$("input[name='company_0_isholding']").prop('checked',true);
			}
			else
			{
				$("input[name='company_0_isholding']").prop('checked',false)
			}
      $("input[name='company_0_billto']").val(data.billto);
      $("input[name='company_0_bankacc1']").val(data.bankacc1);
      $("input[name='company_0_bankacc2']").val(data.bankacc2);
      $("input[name='company_0_bankacc3']").val(data.bankacc3);
      $("input[name='company_0_cityname']").val(data.cityname);
      $("input[name='company_0_currencyname']").val(data.currencyname);
				
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
var isholding = 0;
	if ($("input[name='company_0_isholding']").prop('checked'))
	{
		isholding = 1;
	}
	else
	{
		isholding = 0;
	}
	jQuery.ajax({'url':'company/save',
		'data':{
			'companyid':$("input[name='company_0_companyid']").val(),
			'companyname':$("input[name='company_0_companyname']").val(),
      'companycode':$("input[name='company_0_companycode']").val(),
      'address':$("input[name='company_0_address']").val(),
      'cityid':$("input[name='company_0_cityid']").val(),
      'zipcode':$("input[name='company_0_zipcode']").val(),
      'taxno':$("input[name='company_0_taxno']").val(),
      'currencyid':$("input[name='company_0_currencyid']").val(),
      'faxno':$("input[name='company_0_faxno']").val(),
      'phoneno':$("input[name='company_0_phoneno']").val(),
      'webaddress':$("input[name='company_0_webaddress']").val(),
      'email':$("input[name='company_0_email']").val(),
      'leftlogofile':$("input[name='company_0_leftlogofile']").val(),
      'rightlogofile':$("input[name='company_0_rightlogofile']").val(),
      'isholding':isholding,
      'billto':$("input[name='company_0_billto']").val(),
      'bankacc1':$("input[name='company_0_bankacc1']").val(),
      'bankacc2':$("input[name='company_0_bankacc2']").val(),
      'bankacc3':$("input[name='company_0_bankacc3']").val(),
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'company/approve',
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
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'company/delete',
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
	jQuery.ajax({'url':'company/purge','data':{'id':$id},
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
	var array = 'companyid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&companycode='+$("input[name='dlg_search_companycode']").val()
+ '&address='+$("input[name='dlg_search_address']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&webaddress='+$("input[name='dlg_search_webaddress']").val()
+ '&email='+$("input[name='dlg_search_email']").val()
+ '&leftlogofile='+$("input[name='dlg_search_leftlogofile']").val()
+ '&rightlogofile='+$("input[name='dlg_search_rightlogofile']").val()
+ '&billto='+$("input[name='dlg_search_billto']").val()
+ '&bankacc1='+$("input[name='dlg_search_bankacc1']").val()
+ '&bankacc2='+$("input[name='dlg_search_bankacc2']").val()
+ '&bankacc3='+$("input[name='dlg_search_bankacc3']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'companyid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&companycode='+$("input[name='dlg_search_companycode']").val()
+ '&address='+$("input[name='dlg_search_address']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&webaddress='+$("input[name='dlg_search_webaddress']").val()
+ '&email='+$("input[name='dlg_search_email']").val()
+ '&leftlogofile='+$("input[name='dlg_search_leftlogofile']").val()
+ '&rightlogofile='+$("input[name='dlg_search_rightlogofile']").val()
+ '&billto='+$("input[name='dlg_search_billto']").val()
+ '&bankacc1='+$("input[name='dlg_search_bankacc1']").val()
+ '&bankacc2='+$("input[name='dlg_search_bankacc2']").val()
+ '&bankacc3='+$("input[name='dlg_search_bankacc3']").val();
	window.open('company/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'companyid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&companycode='+$("input[name='dlg_search_companycode']").val()
+ '&address='+$("input[name='dlg_search_address']").val()
+ '&cityname='+$("input[name='dlg_search_cityname']").val()
+ '&zipcode='+$("input[name='dlg_search_zipcode']").val()
+ '&taxno='+$("input[name='dlg_search_taxno']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&faxno='+$("input[name='dlg_search_faxno']").val()
+ '&phoneno='+$("input[name='dlg_search_phoneno']").val()
+ '&webaddress='+$("input[name='dlg_search_webaddress']").val()
+ '&email='+$("input[name='dlg_search_email']").val()
+ '&leftlogofile='+$("input[name='dlg_search_leftlogofile']").val()
+ '&rightlogofile='+$("input[name='dlg_search_rightlogofile']").val()
+ '&billto='+$("input[name='dlg_search_billto']").val()
+ '&bankacc1='+$("input[name='dlg_search_bankacc1']").val()
+ '&bankacc2='+$("input[name='dlg_search_bankacc2']").val()
+ '&bankacc3='+$("input[name='dlg_search_bankacc3']").val();
	window.open('company/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'companyid='+$id
} 
