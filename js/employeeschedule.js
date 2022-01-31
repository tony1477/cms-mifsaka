if("undefined"==typeof jQuery)throw new Error("Employee Schedule's JavaScript requires jQuery");
function newdata()
{
	jQuery.ajax({'url':'employeeschedule/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeescheduleid']").val(data.employeescheduleid);
			
			$("input[name='employeeid']").val('');
      $("input[name='month']").val(data.month);
      $("input[name='year']").val(data.year);
      $("input[name='d1']").val(data.d1);
      $("input[name='d2']").val(data.d2);
      $("input[name='d3']").val(data.d3);
      $("input[name='d4']").val(data.d4);
      $("input[name='d5']").val(data.d5);
      $("input[name='d6']").val(data.d6);
      $("input[name='d7']").val(data.d7);
      $("input[name='d8']").val(data.d8);
      $("input[name='d9']").val(data.d9);
      $("input[name='d10']").val(data.d10);
      $("input[name='d11']").val(data.d11);
      $("input[name='d12']").val(data.d12);
      $("input[name='d13']").val(data.d13);
      $("input[name='d14']").val(data.d14);
      $("input[name='d15']").val(data.d15);
      $("input[name='d16']").val(data.d16);
      $("input[name='d17']").val(data.d17);
      $("input[name='d18']").val(data.d18);
      $("input[name='d19']").val(data.d19);
      $("input[name='d20']").val(data.d20);
      $("input[name='d21']").val(data.d21);
      $("input[name='d22']").val(data.d22);
      $("input[name='d23']").val(data.d23);
      $("input[name='d24']").val(data.d24);
      $("input[name='d25']").val(data.d25);
      $("input[name='d26']").val(data.d26);
      $("input[name='d27']").val(data.d27);
      $("input[name='d28']").val(data.d28);
      $("input[name='d29']").val(data.d29);
      $("input[name='d30']").val(data.d30);
      $("input[name='d31']").val(data.d31);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val('');
      $("input[name='d1name']").val(data.d1name);
      $("input[name='d2name']").val(data.d2name);
      $("input[name='d3name']").val(data.d3name);
      $("input[name='d4name']").val(data.d4name);
      $("input[name='d5name']").val(data.d5name);
      $("input[name='d6name']").val(data.d6name);
      $("input[name='d7name']").val(data.d7name);
      $("input[name='d8name']").val(data.d8name);
      $("input[name='d9name']").val(data.d9name);
      $("input[name='d10name']").val(data.d10name);
      $("input[name='d11name']").val(data.d11name);
      $("input[name='d12name']").val(data.d12name);
      $("input[name='d13name']").val(data.d13name);
      $("input[name='d14name']").val(data.d14name);
      $("input[name='d15name']").val(data.d15name);
      $("input[name='d16name']").val(data.d16name);
      $("input[name='d17name']").val(data.d17name);
      $("input[name='d18name']").val(data.d18name);
      $("input[name='d19name']").val(data.d19name);
      $("input[name='d20name']").val(data.d20name);
      $("input[name='d21name']").val(data.d21name);
      $("input[name='d22name']").val(data.d22name);
      $("input[name='d23name']").val(data.d23name);
      $("input[name='d24name']").val(data.d24name);
      $("input[name='d25name']").val(data.d25name);
      $("input[name='d26name']").val(data.d26name);
      $("input[name='d27name']").val(data.d27name);
      $("input[name='d28name']").val(data.d28name);
      $("input[name='d29name']").val(data.d29name);
      $("input[name='d30name']").val(data.d30name);
      $("input[name='d31name']").val(data.d31name);
			
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
	jQuery.ajax({'url':'employeeschedule/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeescheduleid']").val(data.employeescheduleid);
				
				$("input[name='employeeid']").val(data.employeeid);
      $("input[name='month']").val(data.month);
      $("input[name='year']").val(data.year);
      $("input[name='d1']").val(data.d1);
      $("input[name='d2']").val(data.d2);
      $("input[name='d3']").val(data.d3);
      $("input[name='d4']").val(data.d4);
      $("input[name='d5']").val(data.d5);
      $("input[name='d6']").val(data.d6);
      $("input[name='d7']").val(data.d7);
      $("input[name='d8']").val(data.d8);
      $("input[name='d9']").val(data.d9);
      $("input[name='d10']").val(data.d10);
      $("input[name='d11']").val(data.d11);
      $("input[name='d12']").val(data.d12);
      $("input[name='d13']").val(data.d13);
      $("input[name='d14']").val(data.d14);
      $("input[name='d15']").val(data.d15);
      $("input[name='d16']").val(data.d16);
      $("input[name='d17']").val(data.d17);
      $("input[name='d18']").val(data.d18);
      $("input[name='d19']").val(data.d19);
      $("input[name='d20']").val(data.d20);
      $("input[name='d21']").val(data.d21);
      $("input[name='d22']").val(data.d22);
      $("input[name='d23']").val(data.d23);
      $("input[name='d24']").val(data.d24);
      $("input[name='d25']").val(data.d25);
      $("input[name='d26']").val(data.d26);
      $("input[name='d27']").val(data.d27);
      $("input[name='d28']").val(data.d28);
      $("input[name='d29']").val(data.d29);
      $("input[name='d30']").val(data.d30);
      $("input[name='d31']").val(data.d31);
      $("input[name='recordstatus']").val(data.recordstatus);
      $("input[name='fullname']").val(data.fullname);
      $("input[name='d1name']").val(data.d1name);
      $("input[name='d2name']").val(data.d2name);
      $("input[name='d3name']").val(data.d3name);
      $("input[name='d4name']").val(data.d4name);
      $("input[name='d5name']").val(data.d5name);
      $("input[name='d6name']").val(data.d6name);
      $("input[name='d7name']").val(data.d7name);
      $("input[name='d8name']").val(data.d8name);
      $("input[name='d9name']").val(data.d9name);
      $("input[name='d10name']").val(data.d10name);
      $("input[name='d11name']").val(data.d11name);
      $("input[name='d12name']").val(data.d12name);
      $("input[name='d13name']").val(data.d13name);
      $("input[name='d14name']").val(data.d14name);
      $("input[name='d15name']").val(data.d15name);
      $("input[name='d16name']").val(data.d16name);
      $("input[name='d17name']").val(data.d17name);
      $("input[name='d18name']").val(data.d18name);
      $("input[name='d19name']").val(data.d19name);
      $("input[name='d20name']").val(data.d20name);
      $("input[name='d21name']").val(data.d21name);
      $("input[name='d22name']").val(data.d22name);
      $("input[name='d23name']").val(data.d23name);
      $("input[name='d24name']").val(data.d24name);
      $("input[name='d25name']").val(data.d25name);
      $("input[name='d26name']").val(data.d26name);
      $("input[name='d27name']").val(data.d27name);
      $("input[name='d28name']").val(data.d28name);
      $("input[name='d29name']").val(data.d29name);
      $("input[name='d30name']").val(data.d30name);
      $("input[name='d31name']").val(data.d31name);
				
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

	jQuery.ajax({'url':'employeeschedule/save',
		'data':{
			
			'employeescheduleid':$("input[name='employeescheduleid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
      'month':$("input[name='month']").val(),
      'year':$("input[name='year']").val(),
      'd1':$("input[name='d1']").val(),
      'd2':$("input[name='d2']").val(),
      'd3':$("input[name='d3']").val(),
      'd4':$("input[name='d4']").val(),
      'd5':$("input[name='d5']").val(),
      'd6':$("input[name='d6']").val(),
      'd7':$("input[name='d7']").val(),
      'd8':$("input[name='d8']").val(),
      'd9':$("input[name='d9']").val(),
      'd10':$("input[name='d10']").val(),
      'd11':$("input[name='d11']").val(),
      'd12':$("input[name='d12']").val(),
      'd13':$("input[name='d13']").val(),
      'd14':$("input[name='d14']").val(),
      'd15':$("input[name='d15']").val(),
      'd16':$("input[name='d16']").val(),
      'd17':$("input[name='d17']").val(),
      'd18':$("input[name='d18']").val(),
      'd19':$("input[name='d19']").val(),
      'd20':$("input[name='d20']").val(),
      'd21':$("input[name='d21']").val(),
      'd22':$("input[name='d22']").val(),
      'd23':$("input[name='d23']").val(),
      'd24':$("input[name='d24']").val(),
      'd25':$("input[name='d25']").val(),
      'd26':$("input[name='d26']").val(),
      'd27':$("input[name='d27']").val(),
      'd28':$("input[name='d28']").val(),
      'd29':$("input[name='d29']").val(),
      'd30':$("input[name='d30']").val(),
      'd31':$("input[name='d31']").val(),
      'recordstatus':$("input[name='recordstatus']").val(),
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'employeeschedule/approve',
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
	$.msg.confirmation('Confirm','Are you sure ?',function(){	
	jQuery.ajax({'url':'employeeschedule/delete',
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
	jQuery.ajax({'url':'employeeschedule/purge','data':{'id':$id},
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
		'employeescheduleid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val(),
		'month':$("input[name='dlg_search_month']").val(),
		'year':$("input[name='dlg_search_year']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'employeescheduleid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&month='+$("input[name='dlg_search_month']").val()
+ '&year='+$("input[name='dlg_search_year']").val();
	window.open('employeeschedule/downpdf?'+array);
}

function downxls($id=0) {
	var array = 'employeescheduleid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&month='+$("input[name='dlg_search_month']").val()
+ '&year='+$("input[name='dlg_search_year']").val();
	window.open('employeeschedule/downxls?'+array);
}

function running(id,param2)
{
	jQuery.ajax({'url':'employeeschedule/install',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			location.reload();
		},
		'cache':false});
}