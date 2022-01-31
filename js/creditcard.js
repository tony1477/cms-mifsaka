if("undefined"==typeof jQuery)throw new Error("Credit Card's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'creditcard/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='creditcardid']").val(data.creditcardid);
				$("input[name='creditcardname']").val('');
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
	jQuery.ajax({'url':'creditcard/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='creditcardid']").val(data.creditcardid);
				$("input[name='creditcardname']").val(data.creditcardname);
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
	jQuery.ajax({'url':'creditcard/save',
		'data':{
			'creditcardid':$("input[name='creditcardid']").val(),
			'creditcardname':$("input[name='creditcardname']").val(),
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
	jQuery.ajax({'url':'creditcard/purge','data':{'id':$id},
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
		'creditcardid':$id,
		'creditcardname':$("input[name='dlg_search_creditcardname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'creditcardid='+$id
+ '&creditcardname='+$("input[name='dlg_search_creditcardname']").val();
	window.open('creditcard/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'creditcardid='+$id
+ '&creditcardname='+$("input[name='dlg_search_creditcardname']").val();
	window.open('creditcard/downxls?'+array);
}