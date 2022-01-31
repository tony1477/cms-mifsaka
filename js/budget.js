if("undefined"==typeof jQuery)throw new Error("Budget's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'budget/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='budget_0_budgetid']").val(data.budgetid);
			$("input[name='budget_0_companyid']").val('');
			$("input[name='budget_0_accountid']").val('');
      $("input[name='budget_0_budgetdate']").val(data.budgetdate);
      $("input[name='budget_0_budgetamount']").val(data.budgetamount);
      $("input[name='budget_0_accountcode']").val('');
      $("input[name='budget_0_companyname']").val('');
			
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
	jQuery.ajax({'url':'budget/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='budget_0_budgetid']").val(data.budgetid);
				$("input[name='budget_0_companyid']").val(data.companyid);
				$("input[name='budget_0_accountid']").val(data.accountid);
      $("input[name='budget_0_budgetdate']").val(data.budgetdate);
      $("input[name='budget_0_budgetamount']").val(data.budgetamount);
      $("input[name='budget_0_accountcode']").val(data.accountcode);
				$("input[name='budget_0_companyname']").val(data.companyname);
				
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

	jQuery.ajax({'url':'budget/save',
		'data':{
			'budgetid':$("input[name='budget_0_budgetid']").val(),
			'companyid':$("input[name='budget_0_companyid']").val(),
			'accountid':$("input[name='budget_0_accountid']").val(),
      'budgetdate':$("input[name='budget_0_budgetdate']").val(),
      'budgetamount':$("input[name='budget_0_budgetamount']").val(),
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
	jQuery.ajax({'url':'budget/delete',
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
	jQuery.ajax({'url':'budget/purge','data':{'id':$id},
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
		'budgetid':$id,
		'companyname':$("input[name='dlg_search_companyname']").val(),
		'accountcode':$("input[name='dlg_search_accountcode']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'budgetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountcode='+$("input[name='dlg_search_accountcode']").val();
	window.open('budget/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'budgetid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&accountcode='+$("input[name='dlg_search_accountcode']").val();
	window.open('budget/downxls?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'budgetid='+$id
} 
