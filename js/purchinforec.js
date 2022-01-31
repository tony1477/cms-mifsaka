if("undefined"==typeof jQuery)throw new Error("Purchasing Info Record's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'purchinforec/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='purchinforec_0_purchinforecid']").val(data.purchinforecid);
			$("input[name='purchinforec_0_addressbookid']").val('');
      $("input[name='purchinforec_0_productid']").val('');
      $("input[name='purchinforec_0_deliverytime']").val('');
      $("input[name='purchinforec_0_purchasinggroupid']").val('');
      $("input[name='purchinforec_0_underdelvtol']").val('');
      $("input[name='purchinforec_0_overdelvtol']").val('');
      $("input[name='purchinforec_0_price']").val(data.price);
      $("input[name='purchinforec_0_currencyid']").val(data.currencyid);
      $("input[name='purchinforec_0_biddate']").val(data.biddate);
      $("input[name='purchinforec_0_recordstatus']").prop('checked',true);
      $("input[name='purchinforec_0_fullname']").val('');
      $("input[name='purchinforec_0_productname']").val('');
      $("input[name='purchinforec_0_purchasinggroupcode']").val('');
      $("input[name='purchinforec_0_currencyname']").val(data.currencyname);
			
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
	jQuery.ajax({'url':'purchinforec/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='purchinforec_0_purchinforecid']").val(data.purchinforecid);
				$("input[name='purchinforec_0_addressbookid']").val(data.addressbookid);
      $("input[name='purchinforec_0_productid']").val(data.productid);
      $("input[name='purchinforec_0_deliverytime']").val(data.deliverytime);
      $("input[name='purchinforec_0_purchasinggroupid']").val(data.purchasinggroupid);
      $("input[name='purchinforec_0_underdelvtol']").val(data.underdelvtol);
      $("input[name='purchinforec_0_overdelvtol']").val(data.overdelvtol);
      $("input[name='purchinforec_0_price']").val(data.price);
      $("input[name='purchinforec_0_currencyid']").val(data.currencyid);
      $("input[name='purchinforec_0_biddate']").val(data.biddate);
      if (data.recordstatus == 1)
			{
				$("input[name='purchinforec_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='purchinforec_0_recordstatus']").prop('checked',false)
			}
      $("input[name='purchinforec_0_fullname']").val(data.fullname);
      $("input[name='purchinforec_0_productname']").val(data.productname);
      $("input[name='purchinforec_0_purchasinggroupcode']").val(data.purchasinggroupcode);
      $("input[name='purchinforec_0_currencyname']").val(data.currencyname);
				
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
	if ($("input[name='purchinforec_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'purchinforec/save',
		'data':{
			'purchinforecid':$("input[name='purchinforec_0_purchinforecid']").val(),
			'addressbookid':$("input[name='purchinforec_0_addressbookid']").val(),
      'productid':$("input[name='purchinforec_0_productid']").val(),
      'deliverytime':$("input[name='purchinforec_0_deliverytime']").val(),
      'purchasinggroupid':$("input[name='purchinforec_0_purchasinggroupid']").val(),
      'underdelvtol':$("input[name='purchinforec_0_underdelvtol']").val(),
      'overdelvtol':$("input[name='purchinforec_0_overdelvtol']").val(),
      'price':$("input[name='purchinforec_0_price']").val(),
      'currencyid':$("input[name='purchinforec_0_currencyid']").val(),
      'biddate':$("input[name='purchinforec_0_biddate']").val(),
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
	jQuery.ajax({'url':'purchinforec/delete',
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
	jQuery.ajax({'url':'purchinforec/purge','data':{'id':$id},
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
	var array = 'purchinforecid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&startdate='+$("input[name='dlg_search_startdate']").val()
+ '&enddate='+$("input[name='dlg_search_enddate']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'purchinforecid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&startdate='+$("input[name='dlg_search_startdate']").val()
+ '&enddate='+$("input[name='dlg_search_enddate']").val();
	window.open('purchinforec/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'purchinforecid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val()
+ '&startdate='+$("input[name='dlg_search_startdate']").val()
+ '&enddate='+$("input[name='dlg_search_enddate']").val();
	window.open('purchinforec/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'purchinforecid='+$id
} 