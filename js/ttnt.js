if("undefined"==typeof jQuery)throw new Error("TTNT's JavaScript requires jQuery");
function newdata()
{
	var x;
	jQuery.ajax({'url':'ttnt/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='ttntid']").val(data.ttntid);
			$("input[name='actiontype']").val(1);
			$("input[name='docdate']").val(data.docdate);
			$("input[name='companyid']").val('');
			$("input[name='companyname']").val('');
			$("input[name='fullname']").val('');
			$("input[name='employeeid']").val('');
			$("input[name='docno']").val('');
			$("textarea[name='description']").val('');
			$("input[name='recordstatus']").val(data.recordstatus);
			$.fn.yiiGridView.update('TtntdetailList',{data:{'ttntid':data.ttntid}});
			$('#InputDialog').modal();
		},
		'cache':false});
	return false;
}
function newdatattntdetail()
{
	var x;
	jQuery.ajax({'url':'ttnt/createttntdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='ttntdetailid']").val('');
			$("input[name='invoiceid']").val('');
			$("input[name='invoiceno']").val('');
			$("input[name='amount']").val('');
			$("input[name='payamount']").val('');
			$("input[name='gino']").val('');
			$("input[name='sono']").val('');
			$("input[name='customer']").val('');
			$('#TtntdetailDialog').modal();
		},
		'cache':false});
	return false;
}
function updatedata($id)
{
	var x;
	jQuery.ajax({'url':'ttnt/update',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ttntid']").val(data.ttntid);
				$("input[name='actiontype']").val(1);
				$("input[name='docdate']").val(data.docdate);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='companyname']").val(data.companyname);
				$("input[name='fullname']").val(data.fullname);
				$("input[name='employeeid']").val(data.employeeid);
				$("input[name='docno']").val(data.docno);
				$("textarea[name='description']").val(data.description);
				$("input[name='recordstatus']").val(data.recordstatus);
				$.fn.yiiGridView.update('TtntdetailList',{data:{'ttntid':data.ttntid}});
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
function updatedatattntdetail($id)
{
	var x;
	jQuery.ajax({'url':'ttnt/updatettntdetail',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ttntdetailid']").val(data.ttntdetailid);
				$("input[name='invoiceid']").val(data.invoiceid);
				$("input[name='invoiceno']").val(data.invoiceno);
				$("input[name='amount']").val(data.amount);
				$("input[name='payamount']").val(data.payamount);
				$("input[name='gino']").val(data.gino);
				$("input[name='sono']").val(data.sono);
				$("input[name='customer']").val(data.fullname);
				$('#TtntdetailDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function savedata()
{
	jQuery.ajax({'url':'ttnt/save',
		'data':{	
			'ttntid':$("input[name='ttntid']").val(),
			'docdate':$("input[name='docdate']").val(),
			'companyid':$("input[name='companyid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'description':$("textarea[name='description']").val(),
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
	return false;
}
function savedatattntdetail()
{
	jQuery.ajax({'url':'ttnt/savettntdetail',
		'data':{	
			'actiontype':$("input[name='actiontype']").val(),
			'ttntdetailid':$("input[name='ttntdetailid']").val(),
			'ttntid':$("input[name='ttntid']").val(),
			'invoiceid':$("input[name='invoiceid']").val(),
			'amount':$("input[name='amount']").val(),
			'payamount':$("input[name='payamount']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#TtntdetailDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("TtntdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function rejectdata($id)
{
	var r = confirm("Apakah anda yakin ?");
	if (r == true) {
	jQuery.ajax({'url':'ttnt/reject',
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
		'cache':false});
	}
	return false;
}
function approvedata($id)
{
	var r = confirm("Apakah anda yakin ?");
	if (r == true) {
	jQuery.ajax({'url':'ttnt/approve',
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
		'cache':false});
	}
	return false;
}
function purgedata($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'ttnt/purge',
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
		'cache':false});
	});
	return false;
}
function closedata()
{
	jQuery.ajax({'url':'ttnt/close',
		'data':{'id':$("input[name='ttntid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
				$('#InputDialog').modal('hide');
				$.fn.yiiGridView.update("GridList");
		},
		'cache':false});
	return false;
}
function purgedatattntdetail($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'ttnt/purgettntdetail',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("TtntdetailList");
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
		'docdate':$("input[name='dlg_search_docdate']").val(),
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'description':$("input[name='dlg_search_description']").val(),
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'ttntid='+$id
	+ '&docdate='+$("input[name='dlg_search_docdate']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('ttnt/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'ttntid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val()
	+ '&companyname='+$("input[name='dlg_search_companyname']").val()
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('ttnt/downxls?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ttntid='+$id;
	$.fn.yiiGridView.update("DetailTtntdetailList",{data:array});
} 