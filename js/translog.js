if("undefined"==typeof jQuery)throw new Error("Transaction Log's JavaScript requires jQuery");
unction purgedata($id)
{
	$.msg.confirmation('Confirm','',function(){
	jQuery.ajax({'url':'translog/purge','data':{'id':$id},
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
		'translogid':$id,
		'username':$("input[name='dlg_search_username']").val(),
		'useraction':$("input[name='dlg_search_useraction']").val(),
		'menuname':$("input[name='dlg_search_menuname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'translogid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&useraction='+$("input[name='dlg_search_useraction']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val();
	window.open('translog/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'translogid='+$id
+ '&username='+$("input[name='dlg_search_username']").val()
+ '&useraction='+$("input[name='dlg_search_useraction']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val();
	window.open('translog/downxls?'+array);
}