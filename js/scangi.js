if("undefined"==typeof jQuery)throw new Error("Goods Issue's Scan JavaScript requires jQuery");

$(function(){
   $("#DeleteButton").click(function () {
      $(this).text(function(i, text){
          return text === "Hapus" ? "Tambah" : "Hapus";
      });
   });
});

function savedata()
{
    var action;
    var type;
    action = $("input[name='action']").val();
    if(action==='delete'){
        type = 'delete';
    }else{
        type = 'add';
    }
    
	jQuery.ajax({'url':'scangi/scanbarcode',
		'data':{
			'giheader_0_nobarcode':$("input[name='giheader_0_nobarcode']").val(),
            'giheader_0_soheaderid':$("input[name='giheader_0_soheaderid']").val(),
            'type':type
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
			}
			else
			{
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function updatedata($id)
{
    
    jQuery.ajax({'url':'scangi/update','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='scangi_1_sodetailid']").val(data.sodetailid);
				$("input[name='scangi_1_qtyscan']").val(data.qtyscan);
				$('#InputDialogScanGI').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
    
}

function savedatascangi(){
    jQuery.ajax({'url':'scangi/saveqtyscan',
		'data':{
			'sodetailid':$("input[name='scangi_1_sodetailid']").val(),
            'qty':$("input[name='scangi_1_qtyscan']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogScanGI').modal('hide');
				$.fn.yiiGridView.update("GridList1",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
                toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function giheader_0_soheaderidsearchdata()
{
	$.fn.yiiGridView.update("giheader_0_soheaderidgrid",{data:{
		'companyname':$("input[name='giheader_0_sono_search_companyname']").val(),
		'fullname':$("input[name='giheader_0_sono_search_fullname']").val(),
		'sono':$("input[name='giheader_0_sono_search_sono']").val(),
        'soheaderid':$("input[name='giheader_0_soheaderid']").val()
        
	}});
	return false;
}

function getdata_so(){
    jQuery.ajax({'url':'scangi/getdataso',
		'data':{
            'soheaderid' : $("input[name='giheader_0_soheaderid']").val(),
        },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("#custname span").text(data.custname);
				$("#salesname span").text(data.salesname);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function refresh(){
    
    $.fn.yiiGridView.update("GridList",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
    //tutup_loading();
}

function giheader_update_so()
{
    /*
    $.fn.yiiGridView.update("GridList",{data:{
		'soheaderid':$("input[name='giheader_0_soheaderid']").val()
	}});
    */
    /*
    jQuery.ajax({'url':'scangi/getdatagi',
		'data':{
			'giheader_0_nobarcode':$("input[name='giheader_0_nobarcode']").val(),
            'giheader_0_soheaderid':$("input[name='giheader_0_soheaderid']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				/*
                $('#InputDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
                
                console.log(data);
                alert(data.output);
                alert('success');
			}
			else
			{
                /*
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
                $.fn.yiiGridView.update("GridList",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
				toastr.error(data.div);
                
                console.log(data);
                alert('failed');
			}
		},
		'cache':false});
        */
        $.fn.yiiGridView.update("GridList",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
        $.fn.yiiGridView.update("GridList1",{data:{'soheaderid':$("input[name='giheader_0_soheaderid']").val()}});
}

function giheader_0_soheaderidShowButtonClick()
{
	$('#giheader_0_soheaderid_dialog').modal();
	giheader_0_soheaderidsearchdata();
}
function giheader_0_soheaderidClearButtonClick()
{
	$("input[name='giheader_0_sono']").val('');
	$("input[name='giheader_0_soheaderid']").val('');
}
function giheader_0_soheaderidgridonSelectionChange()
{
	$("#giheader_0_soheaderidgrid > table > tbody > tr").each(function(i)
	{
		if($(this).hasClass("selected"))
		{
			$("input[name='giheader_0_sono']").val($(this).find("td:nth-child(2)").text());
			$("input[name='giheader_0_soheaderid']").val($(this).find('td:first-child').text());	   
        }
	});
	$('#giheader_0_soheaderid_dialog').modal('hide');
    giheader_update_so();
		getdata_so();
    return false;
}
$(document).ready(function(){
	$("input[name='giheader_0_sono']").keyup(function(e){
	if(e.keyCode == 13)
	{
		giheader_0_soheaderidShowButtonClick();
        
	}});
	$(":input[name*='giheader_0_sono_search_']").keyup(function(e){
	if(e.keyCode == 13)
	{
		giheader_0_soheaderidsearchdata();
	}});
});

    function approvedata()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'scangi/ApproveGi',
		'data':{
            'giheader_0_soheaderid' : $("input[name='giheader_0_soheaderid']").val(),
            'giheader_0_note' : $("textarea[name='giheader_0_note']").val()
        },
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

   function deletedata()
{
	/*
    $.msg.confirmation('Confirm','Apakah anda yakin ?',function(){	
	jQuery.ajax({'url':'scangi/ApproveGi',
		'data':{
            'giheader_0_soheaderid' : $("input[name='giheader_0_soheaderid']").val()
            //'id':$id
        },
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
    */
    /*
    
     var action = $('#action').val('');
     action = $('#action').val();
     if(action='add'){
         $("span#text").text("Tambah");
         $("#DeleteButton").removeClass("btn btn-danger").addClass("btn btn-info");
         //$('.btn btn-danger').addClass('btn btn-success').removeClass('btn btn-danger');
         $("input[name='action']").val('delete');
         $("div.form-group").hide(500);
         $("div.form-group").show(100);
         $("input[name='giheader_0_soheaderid']").val();
     }else{
         $("span#text").text("purge");
         $("#DeleteButton").removeClass("btn btn-info").addClass("btn btn-danger");
         //$('.btn btn-danger').addClass('btn btn-success').removeClass('btn btn-danger');
         $("input[name='action']").val('add');
         $("div.form-group").hide(500);
         $("div.form-group").show(100);
         $("input[name='giheader_0_soheaderid']").val();
     }
     */
    var text = $("#DeleteButton").text();
    if(text=='Hapus'){
         //$("span#text").text("purge");
         //$("#DeleteButton").removeClass("btn btn-info").addClass("btn btn-danger");
         $('#DeleteButton').addClass('btn btn-info').removeClass('btn-danger');
         $("input[name='action']").val('delete');
         $("div.form-group").hide(500);
         $("div.form-group").show(100);
         $("input[name='giheader_0_soheaderid']").val();
    }else{
        $('#DeleteButton').addClass('btn btn-danger').removeClass('btn-info');
        $("input[name='action']").val('add');
         $("div.form-group").hide(500);
         $("div.form-group").show(100);
         $("input[name='giheader_0_soheaderid']").val();
    }
    
}
