if("undefined"==typeof jQuery)throw new Error("Profit Loss's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'profitloss/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='repprofitlossid']").val(data.repprofitlossid);
			
			$("input[name='companyid']").val(data.companyid);
      $("input[name='accountid']").val('');
      $("input[name='isdebet']").prop('checked',true);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='accountcode']").val('');
			
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
	jQuery.ajax({'url':'profitloss/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='repprofitlossid']").val(data.repprofitlossid);
				
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
      $("input[name='accountcode']").val(data.accountcode);
				
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
	jQuery.ajax({'url':'profitloss/save',
		'data':{
			
			'repprofitlossid':$("input[name='repprofitlossid']").val(),
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



function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'profitloss/purge','data':{'id':$id},
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
		'repprofitlossid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'accountcode':$("input[name='dlg_search_accountcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountname='+$("input[name='dlg_search_accountname']").val()
+ '&reporttype='+$("select[name='dlg_search_reporttype']").val()
+ '&accounttype='+$("select[name='dlg_search_accounttype']").val()
+ '&reportdate='+$("input[name='dlg_search_date']").val()
;
	window.open('profitloss/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'repprofitlossid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountcode='+$("input[name='dlg_search_accountcode']").val();
	window.open('profitloss/downxls?'+array);
}