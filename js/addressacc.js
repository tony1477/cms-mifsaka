if("undefined"==typeof jQuery)throw new Error("Address Accounting's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'addressacc/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='addressaccid']").val(data.addressaccid);
			
			$("input[name='companyid']").val(data.companyid);
      $("input[name='addressbookid']").val('');
      $("input[name='acchutangid']").val('');
      $("input[name='accpiutangid']").val('');
      $("input[name='companyname']").val(data.companyname);
      $("input[name='fullname']").val('');
      $("input[name='acchutangname']").val('');
      $("input[name='accpiutangname']").val('');
			
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
	jQuery.ajax({'url':'addressacc/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='addressaccid']").val(data.addressaccid);
				
				$("input[name='companyid']").val(data.companyid);
      $("input[name='addressbookid']").val(data.addressbookid);
      $("input[name='acchutangid']").val(data.acchutangid);
      $("input[name='accpiutangid']").val(data.accpiutangid);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='fullname']").val(data.fullname);
      $("input[name='acchutangname']").val(data.acchutangname);
      $("input[name='accpiutangname']").val(data.accpiutangname);
				
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

	jQuery.ajax({'url':'addressacc/save',
		'data':{
			
			'addressaccid':$("input[name='addressaccid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'addressbookid':$("input[name='addressbookid']").val(),
      'acchutangid':$("input[name='acchutangid']").val(),
      'accpiutangid':$("input[name='accpiutangid']").val(),
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
	jQuery.ajax({'url':'addressacc/delete',
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
	jQuery.ajax({'url':'addressacc/purge','data':{'id':$id},
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
		'addressaccid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'acchutangname':$("input[name='dlg_search_acchutangname']").val(),
		'accpiutangname':$("input[name='dlg_search_accpiutangname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'addressaccid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&acchutangname='+$("input[name='dlg_search_acchutangname']").val()
+ '&accpiutangname='+$("input[name='dlg_search_accpiutangname']").val();
	window.open('addressacc/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'addressaccid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&acchutangname='+$("input[name='dlg_search_acchutangname']").val()
+ '&accpiutangname='+$("input[name='dlg_search_accpiutangname']").val();
	window.open('addressacc/downxls?'+array);
}