if("undefined"==typeof jQuery)throw new Error("General Journal's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'genjournal/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='genjournal_0_genjournalid']").val(data.genjournalid);
			$("input[name='genjournal_0_companyid']").val(data.companyid);
      $("input[name='genjournal_0_referenceno']").val('');
      $("input[name='genjournal_0_journaldate']").val(data.journaldate);
      $("input[name='genjournal_0_postdate']").val(data.postdate);
      $("textarea[name='genjournal_0_journalnote']").val('');
      $("input[name='genjournal_0_recordstatus']").val(data.recordstatus);
      $("input[name='genjournal_0_companyname']").val('');
			$.fn.yiiGridView.update('journaldetailList',{data:{'genjournalid':data.genjournalid}});

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
function newdatajournaldetail()
{
	jQuery.ajax({'url':'genjournal/createjournaldetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='journaldetail_1_journaldetailid']").val('');
      $("input[name='journaldetail_1_accountid']").val('');
      $("input[name='journaldetail_1_debit']").val(data.debit);
      $("input[name='journaldetail_1_credit']").val(data.credit);
      $("input[name='journaldetail_1_currencyid']").val(data.currencyid);
      $("input[name='journaldetail_1_ratevalue']").val(data.ratevalue);
      $("textarea[name='journaldetail_1_detailnote']").val('');
      $("input[name='journaldetail_1_accountcode']").val('');
      $("input[name='journaldetail_1_currencyname']").val(data.currencyname);
			$('#InputDialogjournaldetail').modal();
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
	jQuery.ajax({'url':'genjournal/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='genjournal_0_genjournalid']").val(data.genjournalid);
				$("input[name='genjournal_0_companyid']").val(data.companyid);
      $("input[name='genjournal_0_referenceno']").val(data.referenceno);
      $("input[name='genjournal_0_journaldate']").val(data.journaldate);
      $("input[name='genjournal_0_postdate']").val(data.postdate);
      $("textarea[name='genjournal_0_journalnote']").val(data.journalnote);
      $("input[name='genjournal_0_recordstatus']").val(data.recordstatus);
      $("input[name='genjournal_0_companyname']").val(data.companyname);
				$.fn.yiiGridView.update('journaldetailList',{data:{'genjournalid':data.genjournalid}});

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
function updatedatajournaldetail($id)
{
	jQuery.ajax({'url':'genjournal/updatejournaldetail','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='journaldetail_1_journaldetailid']").val(data.journaldetailid);
      $("input[name='journaldetail_1_accountid']").val(data.accountid);
      $("input[name='journaldetail_1_debit']").val(data.debit);
      $("input[name='journaldetail_1_credit']").val(data.credit);
      $("input[name='journaldetail_1_currencyid']").val(data.currencyid);
      $("input[name='journaldetail_1_ratevalue']").val(data.ratevalue);
      $("textarea[name='journaldetail_1_detailnote']").val(data.detailnote);
      $("input[name='journaldetail_1_accountcode']").val(data.accountcode);
      $("input[name='journaldetail_1_currencyname']").val(data.currencyname);
			$('#InputDialogjournaldetail').modal();
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

	jQuery.ajax({'url':'genjournal/save',
		'data':{
			'genjournalid':$("input[name='genjournal_0_genjournalid']").val(),
			'companyid':$("input[name='genjournal_0_companyid']").val(),
      'referenceno':$("input[name='genjournal_0_referenceno']").val(),
      'journaldate':$("input[name='genjournal_0_journaldate']").val(),
      'postdate':$("input[name='genjournal_0_postdate']").val(),
      'journalnote':$("textarea[name='genjournal_0_journalnote']").val(),
      'recordstatus':$("input[name='genjournal_0_recordstatus']").val(),
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

function savedatajournaldetail()
{

	jQuery.ajax({'url':'genjournal/savejournaldetail',
		'data':{
			'genjournalid':$("input[name='genjournal_0_genjournalid']").val(),
			'journaldetailid':$("input[name='journaldetail_1_journaldetailid']").val(),
      'accountid':$("input[name='journaldetail_1_accountid']").val(),
      'debit':$("input[name='journaldetail_1_debit']").val(),
      'credit':$("input[name='journaldetail_1_credit']").val(),
      'currencyid':$("input[name='journaldetail_1_currencyid']").val(),
      'ratevalue':$("input[name='journaldetail_1_ratevalue']").val(),
      'detailnote':$("textarea[name='journaldetail_1_detailnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogjournaldetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("journaldetailList");
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
	jQuery.ajax({'url':'genjournal/approve',
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
	jQuery.ajax({'url':'genjournal/delete',
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
	jQuery.ajax({'url':'genjournal/purge','data':{'id':$id},
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
function purgedatajournaldetail()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'genjournal/purgejournaldetail','data':{'id':$.fn.yiiGridView.getSelection("journaldetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("journaldetailList");
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
		'genjournalid':$id,
		'journalno':$("input[name='dlg_search_journalno']").val(),
		'referenceno':$("input[name='dlg_search_referenceno']").val(),
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'genjournalid='+$id
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('genjournal/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'genjournalid='+$id
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('genjournal/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'genjournalid='+$id
$.fn.yiiGridView.update("DetailjournaldetailList",{data:array});
} 