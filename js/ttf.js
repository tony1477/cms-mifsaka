if("undefined"==typeof jQuery)throw new Error("TTF's JavaScript requires jQuery");
function newdata()
{
	var x;
	jQuery.ajax({'url':'ttf/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='ttfid']").val(data.ttfid);
			$("input[name='actiontype']").val(1);
			$("input[name='docdate']").val(data.docdate);
			$("input[name='companyid']").val('');
			$("input[name='companyname']").val('');
			$("input[name='fullname']").val('');
            $("input[name='employeeid']").val('');
			$("input[name='ttntid']").val('');
			$("input[name='docno']").val('');
			$("textarea[name='description']").val('');
			$("input[name='recordstatus']").val(data.recordstatus);
			$.fn.yiiGridView.update('TtfdetailList',{data:{'ttfid':data.ttfid}});
			$('#InputDialog').modal();
		},
		'cache':false});
	return false;
}
function newdatattfdetail()
{
	var x;
	jQuery.ajax({'url':'ttf/createttfdetail','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='ttfdetailid']").val('');
			$("input[name='invoiceid']").val('');
			$("input[name='invoiceno']").val('');
			$("input[name='amount']").val('');
			$("input[name='payamount']").val('');
			$("input[name='ttntdetailid']").val('');
			$("input[name='sono']").val('');
			$("input[name='customer']").val('');
			$('#TtfdetailDialog').modal();
		},
		'cache':false});
	return false;
}
function updatedata($id)
{
	var x;
	jQuery.ajax({'url':'ttf/update',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ttfid']").val(data.ttfid);
				$("input[name='actiontype']").val(1);
				$("input[name='docdate']").val(data.docdate);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='companyname']").val(data.companyname);
				$("input[name='fullname']").val(data.fullname);
				$("input[name='employeeid']").val(data.employeeid);
				$("input[name='ttntid1']").val(data.ttntid);
				$("input[name='docno']").val(data.docno);
				$("input[name='docno1']").val(data.ttntdocno);
				$("textarea[name='description']").val(data.description);
				$("input[name='recordstatus']").val(data.recordstatus);
				$.fn.yiiGridView.update('TtfdetailList',{data:{'ttfid':data.ttfid}});
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
function updatedatattfdetail($id)
{
	var x;
	jQuery.ajax({'url':'ttf/updatettfdetail',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='ttfdetailid']").val(data.ttfdetailid);
				$("input[name='invoiceid']").val(data.invoiceid);
				$("input[name='invoiceno']").val(data.invoiceno);
				$("input[name='amount']").val(data.amount);
				$("input[name='payamount']").val(data.payamount);
				$("input[name='ttntdetailid']").val(data.ttntdetailid);
				$("input[name='sono']").val(data.sono);
				$("input[name='customer']").val(data.fullname);
				$('#TtfdetailDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function savedata()
{
	jQuery.ajax({'url':'ttf/save',
		'data':{	
			'ttfid':$("input[name='ttfid']").val(),
			'docdate':$("input[name='docdate']").val(),
			'companyid':$("input[name='companyid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'ttntid':$("input[name='ttntid1']").val(),
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
function savedatattfdetail()
{
	jQuery.ajax({'url':'ttf/savettfdetail',
		'data':{	
			'actiontype':$("input[name='actiontype']").val(),
			'ttfdetailid':$("input[name='ttfdetailid']").val(),
			'ttfid':$("input[name='ttfid']").val(),
			'invoiceid':$("input[name='invoiceid']").val(),
			'fullname':$("input[name='fullname']").val(),
			'payamount':$("input[name='payamount']").val(),
            'amount':$("input[name='amount']").val(),
            'sono':$("input[name='sono']").val(),
            'ttntdetailid':$("input[name='ttntdetailid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#TtfdetailDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("TtfdetailList");
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
	jQuery.ajax({'url':'ttf/reject',
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
	jQuery.ajax({'url':'ttf/approve',
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
	jQuery.ajax({'url':'ttf/purge',
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
	jQuery.ajax({'url':'ttf/close',
		'data':{'id':$("input[name='ttfid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
				$('#InputDialog').modal('hide');
				$.fn.yiiGridView.update("GridList");
		},
		'cache':false});
	return false;
}
function purgedatattfdetail($id)
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'ttf/purgettfdetail',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("TtfdetailList");
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
	window.open('ttf/downpdf?ttfid='+$id);
}
function downxls($id=0) {
	window.open('ttf/downxls?ttfid='+$id);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'ttfid='+$id;
	$.fn.yiiGridView.update("DetailTtfdetailList",{data:array});
} 