if ("undefined" == typeof jQuery) throw new Error("Sales Order's JavaScript requires jQuery");
function tampil_loading() {
  $(".ajax-loader").css("visibility", "visible");
}

function tutup_loading() {
  $(".ajax-loader").css("visibility", "hidden");
}
/*
function EnablePrice() {
    $("input[name='price']").prop('readonly',true);
}*/
function DisableButtonHeader() {
  $("input[name='paymentmethodname']").prop("readonly", true);
  $("button[name='paymentmethodidShowButton']").prop("disabled", true);
  $("button[name='paymentmethodidClearButton']").prop("disabled", true);
}

function EnableButtonHeader() {
  $("input[name='paymentmethodname']").prop("readonly", false);
  $("button[name='paymentmethodidShowButton']").prop("disabled", false);
  $("button[name='paymentmethodidClearButton']").prop("disabled", false);
}

function DisablebuttonDetail() {
  $("input[name='productname']").prop("readonly", true);
  $("input[name='qty']").prop("readonly", true);
  $("input[name='uomcode']").prop("readonly", true);
  $("input[name='sloccode']").prop("readonly", true);
  $("input[name='currencyname']").prop("readonly", true);
  $("#productidShowButton").prop("disabled", true);
  $("#productidClearButton").prop("disabled", true);
  $("button[name='unitofmeasureidShowButton']").prop("disabled", true);
  $("button[name='unitofmeasureidClearButton']").prop("disabled", true);
  $("button[name='slocidShowButton']").prop("disabled", true);
  $("button[name='slocidClearButton']").prop("disabled", true);
  $("button[name='currencyidShowButton']").prop("disabled", true);
  $("button[name='currencyidClearButton']").prop("disabled", true);

  //$("input[name='unitofmeasureid']").prop('readonly',true);
}

function EnableButtonDetail() {
  $("input[name='productname']").prop("readonly", false);
  $("input[name='qty']").prop("readonly", false);
  $("input[name='uomcode']").prop("readonly", false);
  $("input[name='sloccode']").prop("readonly", false);
  $("input[name='currencyname']").prop("readonly", false);
  $("#productidShowButton").prop("disabled", false);
  $("#productidClearButton").prop("disabled", false);
  //$("button[name='unitofmeasureidShowButton']").prop('disabled',false);
  //$("button[name='unitofmeasureidClearButton']").prop('disabled',false);
  //$("button[name='slocidShowButton']").prop('disabled',false);
  //$("button[name='slocidClearButton']").prop('disabled',false);
  //$("button[name='currencyidShowButton']").prop('disabled',false);
  //$("button[name='currencyidClearButton']").prop('disabled',false);
}

function DisablebuttonDisc() {
  $("input[name='discvalue']").prop("readonly", true);
}

function HideButtonDetail() {
  $("#CreateButtonAddSoDetail").hide();
  //$("#CreateButtonAddSoDisc").hide();
  $("#CreateButtonDelSoDetail").hide();
  //$("#CreateButtonDelSoDisc").hide();
}

function HideButtonDisc() {
  //$("#CreateButtonAddSoDetail").hide();
  $("#CreateButtonAddSoDisc").hide();
  //$("#CreateButtonDelSoDetail").hide();
  $("#CreateButtonDelSoDisc").hide();
}

function ShowButtonDetail() {
  $("#CreateButtonAddSoDetail").show();
  //$("#CreateButtonAddSoDisc").show();
  $("#CreateButtonDelSoDetail").show();
  //$("#CreateButtonDelSoDisc").show();
}

function ShowButtonDisc() {
  //$("#CreateButtonAddSoDetail").show();
  $("#CreateButtonAddSoDisc").show();
  //$("#CreateButtonDelSoDetail").show();
  $("#CreateButtonDelSoDisc").show();
}

$(document).ready(function () {
  var visible = true;
  $("button[name='unitofmeasureidShowButton']").prop("disabled", true);
  $("button[name='unitofmeasureidClearButton']").prop("disabled", true);
  $("button[name='slocidShowButton']").prop("disabled", true);
  $("button[name='slocidClearButton']").prop("disabled", true);
  $("button[name='currencyidShowButton']").prop("disabled", true);
  $("button[name='currencyidClearButton']").prop("disabled", true);

  $("input[name='isdisplay']").change(function () {
    let isdisplay = $(this).prop("checked");
    if (isdisplay) {
      let value = 120;
      setTop(value);
      //console.log('checked');
    } else {
      setTop(0);
      //console.log('not checked');
    }
  });

  $("select#sotype").change(function () {
    let value = $(this).children("option:selected").val();
    if (value == 2) {
      // company

      $("#packagegrid").show();
      $("#qtypkggrid").show();
      $("#isdisplay").prop("checked", false);
      $("#isdisplaygrid").hide();
      $("#materialtypesgrid").hide();
      $("input[name='packageid']").attr("required", true);
      $("input[name='materialtypeid']").attr("required", false);
      $("input[name='materialtypeid']").val("");
      $("input[name='description']").val("");
      HideButtonDetail();
      HideButtonDisc();
      visible = false;
      //hapus detailso dan sodic()
    } else if (value == 1) {
      // hide
      var r = confirm("Apakah Anda yakin ingin mengganti Detail SO ?");
      if (r == true) {
        //$("select#sotype").val('');
        $("#packagegrid").hide();
        $("#qtypkggrid").hide();
        $("input[name='packageid']").val("");
        $("input[name='packagename']").val("");
        $("input[name='qtypkg']").val("");
        $("#isdisplaygrid").show();
        $("#materialtypesgrid").show();
        $("input[name='packageid']").attr("required", false);
        $("input[name='qtypkg']").attr("required", false);
        $("input[name='materialtypeid']").attr("required", true);
        visible = true;
        ShowButtonDisc();
        ShowButtonDetail();
        // hapus sodetail dan sodisc
      } else {
        console.log("else here");
        $("select#sotype").val(2);
      }
    }
  });
  /*
    $("input[name='qtypkg']").blur(function(){
    // do your stuff
        let sotype = $('#sotype').val();
        let qtypkg = $("input[name='qtypkg']").val();
        if(sotype==2 && qtypkg != '') {
            alert('Apakah anda ingin berubah detail ?');   
        }
    });
    */
});

function setTop(value) {
  if (value == 0) {
    //console.log('0');
    //$("#paymentmethodid").combogrid({required:true,readonly:false});
    var myFunc = function (event) {
      paymentmethodidShowButtonClick();
      // execute a bunch of action to preform
    };
    //EnableButtonHeader();
    DisableButtonHeader();
    $("input[name='paymentmethodid']").val("");
    $("input[name='paymentname']").val("");
  } else {
    jQuery.ajax({
      url: "soheader/getTop",
      data: { payday: value },
      type: "post",
      dataType: "json",
      success: function (data) {
        console.log(data);

        DisableButtonHeader();
        $("input[name='paymentmethodid']").val(data.paymentmethodid);
        $("input[name='paymentname']").val(data.paycode);
      },
      cache: false,
    });
  }
}

/*$('#approvesoheader').click(function(){
    tampil_loading();
});*/

function tampil_loading() {
  $(".ajax-loader").css("visibility", "visible");
}

function tutup_loading() {
  $(".ajax-loader").css("visibility", "hidden");
}

function newdata() {
  var x;
  visible = true;
  $("#infobtn").hide();
  jQuery.ajax({
    url: "soheader/create",
    data: {},
    type: "post",
    dataType: "json",
    success: function (data) {
      $("input[name='soheaderid']").val(data.soheaderid);
      $("input[name='actiontype']").val(0);
      $("input[name='sodate']").val(data.sodate);
      $("input[name='companyid']").val(data.companyid);
      $("input[name='companyname']").val(data.companyname);
      $("input[name='addressbookid']").val("");
      $("input[name='fullname']").val("");
      $("input[name='pocustno']").val("");
      $("input[name='employeeid']").val("");
      $("input[name='salesname']").val("");
      $("select[name='sotype']").val(1);
      $("input[name='isdisplay']").prop("checked", false);
      $("input[name='packageid']").val("");
      $("input[name='packagename']").val("");
      $("input[name='materialtypeid']").val("");
      $("input[name='qtypkg']").val("");
      $("input[name='description']").val("");
      $("input[name='paymentmethodid']").val("0");
      $("input[name='paymentname']").val("");
      $("input[name='taxid']").val("");
      $("input[name='taxcode']").val("");
      $("textarea[name='shipto']").val("");
      $("textarea[name='billto']").val("");
      $("textarea[name='headernote']").val("");
      $("input[name='recordstatus']").val(data.recordstatus);
      $("#materialtypesgrid").show();
      $.fn.yiiGridView.update("SodetailList", { data: { soheaderid: data.soheaderid } });
      $.fn.yiiGridView.update("SodiscList", { data: { soheaderid: data.soheaderid } });
      $("#InputDialog").modal();
    },
    cache: false,
  });
  return false;
}
function newdatasodetail() {
  var x;
  let sotype = $("select#sotype").val();
  let materialtypeid = $("input[name='materialtypeid']").val();

  jQuery.ajax({
    url: "soheader/GetAttr",
    data: { materialtypeid: materialtypeid },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.iseditpriceso == 0) {
        $("input[name='price']").prop("readonly", true);
      } else {
        console.log("1");
        $("input[name='price']").prop("readonly", false);
      }
      if (data.iseditdiscso == 0) {
        $("input[name='discvalue']").prop("readonly", true);
      } else {
        console.log("1");
        $("input[name='discvalue']").prop("readonly", false);
      }
      if (data.isedittop == 0) {
        DisableButtonHeader();
      } else {
        EnableButtonHeader();
      }
    },
    cache: false,
  });

  //setMaterialtype();
  if (sotype == 2) {
    $("input[name='productname']").prop("readonly", true);
    $("input[name='qty']").prop("readonly", true);
    //$("input[name='unitofmeasureid']").prop('readonly',true);
    $("input[name='uomcode']").prop("readonly", true);
  }
  jQuery.ajax({
    url: "soheader/createsodetail",
    data: {},
    type: "post",
    dataType: "json",
    success: function (data) {
      $("input[name='sodetailid']").val("");
      $("input[name='productid']").val("");
      $("input[name='productname']").val("");
      $("input[name='qty']").val("1");
      $("input[name='unitofmeasureid']").val("");
      $("input[name='uomcode']").val("");
      $("input[name='slocid']").val("");
      $("input[name='sloccode']").val("");
      $("input[name='price']").val("0");
      $("input[name='currencyid']").val(data.currencyid);
      $("input[name='currencyname']").val(data.currencyname);
      $("input[name='currencyrate']").val("1");
      $("textarea[name='itemnote']").val("");
      $("input[name='deliverydate']").val(data.deliverydate);
      $("input[name='isbonus']").val('');
      $("#SodetailDialog").modal();
    },
    cache: false,
  });
  return false;
}
function newdatasodisc() {
  var x;
  jQuery.ajax({
    url: "soheader/createsodisc",
    data: {},
    type: "post",
    dataType: "json",
    success: function (data) {
      $("input[name='sodiscid']").val("");
      $("input[name='discpersen']").val("0");
      $("#SodiscDialog").modal();
    },
    cache: false,
  });
  return false;
}
function updatedata($id) {
  let sotype = $("#sotype").val();
  jQuery.ajax({
    url: "soheader/update",
    data: { id: $id },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        if (data.sotype == 2) {
          $("#packagegrid").show();
          $("#qtypkggrid").show();
          $("#isdisplay").prop("checked", false);
          $("#isdisplaygrid").hide();
          $("#materialtypesgrid").hide();
          EnableButtonHeader();
          $("#CreateButtonAddSoDetail").hide();
          $("#CreateButtonAddSoDisc").hide();
          $("#CreateButtonDelSoDetail").hide();
          $("#CreateButtonDelSoDisc").hide();
        } else {
          DisableButtonHeader();
          $("#CreateButtonAddSoDetail").show();
          $("#CreateButtonAddSoDisc").show();
          $("#CreateButtonDelSoDetail").show();
          $("#CreateButtonDelSoDisc").show();
          $("#materialtypesgrid").show();
          $("#isdisplaygrid").show();
        }
        $("input[name='actiontype']").val(1);
        $("input[name='soheaderid']").val(data.soheaderid);
        $("input[name='sodate']").val(data.sodate);
        $("input[name='companyid']").val(data.companyid);
        $("input[name='poheaderid']").val(data.poheaderid);
        $("input[name='pono']").val(data.pono);
        $("input[name='companyname']").val(data.companyname);
        $("input[name='addressbookid']").val(data.addressbookid);
        $("input[name='fullname']").val(data.fullname);
        $("input[name='pocustno']").val(data.pocustno);
        $("input[name='employeeid']").val(data.employeeid);
        $("select[name='sotype']").val(data.sotype);
        $("input[name='packageid']").val(data.packageid);
        $("input[name='packagename']").val(data.packagename);
        $("input[name='qtypkg']").val(data.qtypkg);
        $("input[name='materialtypeid']").val(data.materialtypeid);
        $("input[name='description']").val(data.description);
        $("input[name='salesname']").val(data.salesname);
        $("input[name='paymentmethodid']").val(data.paymentmethodid);
        $("input[name='paymentname']").val(data.paymentname);
        $("input[name='taxid']").val(data.taxid);
        $("input[name='taxcode']").val(data.taxcode);
        $("textarea[name='shipto']").val(data.shipto);
        $("textarea[name='billto']").val(data.billto);
        $("textarea[name='headernote']").val(data.headernote);
        $("input[name='recordstatus']").val(data.recordstatus);
        if (data.isdisplay == 1) {
          $("input[name='isdisplay']").prop("checked", true);
        } else {
          $("input[name='isdisplay']").prop("checked", false);
        }
        if (data.addressbookid == "") {
          $("#infobtn").hide();
        } else {
          $("#infobtn").show();
        }
        $.fn.yiiGridView.update("SodetailList", { data: { soheaderid: data.soheaderid } });
        $.fn.yiiGridView.update("SodiscList", { data: { soheaderid: data.soheaderid } });
        $("#InputDialog").modal();
      } else {
        toastr.error(data.div);
      }
    },
    cache: false,
  });
  return false;
}
function updatedatasodetail($id) {
  var x;
  let package = $("select#sotype").val();
  let materialtypeid = $("input[name='materialtypeid']").val();
  if (package == 2) {
    console.log(package);
    //$("#productidShowButton").off('click.onclick');
    //$("#productidShowButton").prop("disabled",true);
    //$("#productidClearButton").prop("disabled",true);
    DisablebuttonDetail();
    $("input[name='productname']").prop("readonly", true);
    $("input[name='qty']").prop("readonly", true);
    //$('#elementId').off('click.myevent');
  } else {
    EnableButtonDetail();
    $("input[name='productname']").prop("readonly", false);
    $("input[name='qty']").prop("readonly", false);
  }
  //$("input[name='price']").prop('readonly',true);
  jQuery.ajax({
    url: "soheader/GetAttr",
    data: { materialtypeid: materialtypeid },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.iseditpriceso == 0) {
        $("input[name='price']").prop("readonly", true);
      } else {
        console.log("1");
        $("input[name='price']").prop("readonly", false);
      }
      if (data.iseditdiscso == 0) {
        $("input[name='discvalue']").prop("readonly", true);
      } else {
        console.log("1");
        $("input[name='discvalue']").prop("readonly", false);
      }
      if (data.isedittop == 0) {
        DisableButtonHeader();
      } else {
        EnableButtonHeader();
      }
    },
    cache: false,
  });

  jQuery.ajax({
    url: "soheader/updatesodetail",
    data: { id: $id },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        /*
                var company = $("input[name='companyid']").val();
                if(company == 17)
                {
                    $("input[name='price']").attr('readonly','true');
                }
                */

        if (data.iseditpriceso == 0) {
          $("input[name='price']").prop("readonly", true);
        } else {
          console.log("1");
          $("input[name='price']").prop("readonly", false);
        }
        if (data.iseditdiscso == 0) {
          $("input[name='discvalue']").prop("readonly", true);
        } else {
          console.log("1");
          $("input[name='discvalue']").prop("readonly", false);
        }
        if (data.isedittop == 0) {
          DisableButtonHeader();
        } else {
          EnableButtonHeader();
        }

        if (data.isbonus == 1)
        {
          $("input[name='isbonus']").prop('checked',true);
        }
        else
        {
          $("input[name='isbonus']").prop('checked',false)
        }

        $("input[name='sodetailid']").val(data.sodetailid);
        $("input[name='productid']").val(data.productid);
        $("input[name='productname']").val(data.productname);
        $("input[name='qty']").val(data.qty);
        $("input[name='unitofmeasureid']").val(data.unitofmeasureid);
        $("input[name='uomcode']").val(data.uomcode);
        $("input[name='slocid']").val(data.slocid);
        $("input[name='sloccode']").val(data.sloccode);
        $("input[name='price']").val(data.price);
        $("input[name='currencyid']").val(data.currencyid);
        $("input[name='currencyname']").val(data.currencyname);
        $("input[name='currencyrate']").val(data.currencyrate);
        $("input[name='deliverydate']").val(data.deliverydate);
        $("textarea[name='itemnote']").val(data.itemnote);
        $("#SodetailDialog").modal();
      }
    },
    cache: false,
  });
  return false;
}
function updatedatasodisc($id) {
  var x;
  let package = $("select#sotype").val();
  if (package == 2) {
    console.log(package);
    //$("#productidShowButton").off('click.onclick');
    //$("#productidShowButton").prop("disabled",true);
    //$("#productidClearButton").prop("disabled",true);
    DisablebuttonDisc();
    //$('#elementId').off('click.myevent');
  }

  jQuery.ajax({
    url: "soheader/updatesodisc",
    data: { id: $id },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        $("input[name='sodiscid']").val(data.sodiscid);
        $("input[name='discvalue']").val(data.discvalue);
        $("#SodiscDialog").modal();
      }
    },
    cache: false,
  });
  return false;
}
function savedata() {
  var isdisplay = 0;
  var paymentmethod = $("input[name='paymentmethodid']").val();
  let sotype = $("select#sotype").val();
  let pkgid = $("input[name='packageid']").val();
  let materialtypeid = $("input[name='materialtypeid']").val();
  let next = 0;
  if (sotype == 1) {
    if (materialtypeid == "") {
      alert("Jenis Material Belum Diisi");
    } else {
      next = 1;
    }
  } else if (sotype == 2) {
    if (pkgid == "") {
      alert("Paket Belum Diisi");
    } else {
      next = 1;
    }
  }
  //else if((sotype==1 && pkgid!='') || (sotype==2 && materialtypeid!='')) {
  //  next = 1;
  //}

  if (next == 1) {
    if (paymentmethod == "") {
      alert("Metode Pembayaran belum diisi");
    } else {
      if ($("input[name='isdisplay']").prop("checked")) {
        isdisplay = 1;
      } else {
        isdisplay = 0;
      }

      jQuery.ajax({
        url: "soheader/save",
        data: {
          actiontype: $("input[name='actiontype']").val(),
          soheaderid: $("input[name='soheaderid']").val(),
          sodate: $("input[name='sodate']").val(),
          companyid: $("input[name='companyid']").val(),
          poheaderid: $("input[name='poheaderid']").val(),
          addressbookid: $("input[name='addressbookid']").val(),
          pocustno: $("input[name='pocustno']").val(),
          isdisplay: isdisplay,
          sotype: $("select[name='sotype']").val(),
          materialtypeid: $("input[name='materialtypeid']").val(),
          packageid: $("input[name='packageid']").val(),
          qtypackage: $("input[name='qtypkg']").val(),
          employeeid: $("input[name='employeeid']").val(),
          paymentmethodid: $("input[name='paymentmethodid']").val(),
          taxid: $("input[name='taxid']").val(),
          shiptoid: $("textarea[name='shipto']").val(),
          billtoid: $("textarea[name='billto']").val(),
          headernote: $("textarea[name='headernote']").val(),
          recordstatus: $("input[name='recordstatus']").val(),
          recordstatus: $("input[name='recordstatus']").val(),
        },
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.status == "success") {
            $("#InputDialog").modal("hide");
            toastr.info(data.div);
            tutup_loading();
            $.fn.yiiGridView.update("GridList");
          } else {
            toastr.error(data.div);
          }
        },
        cache: false,
      });
      return false;
    }
  }
}
function savedatasodetail() {
  let isbonus;
  if ($("input[name='isbonus']").prop('checked'))
	{
		isbonus = 1;
	}
	else
	{
		isbonus = 0;
	}
  jQuery.ajax({
    url: "soheader/savesodetail",
    data: {
      sodetailid: $("input[name='sodetailid']").val(),
      soheaderid: $("input[name='soheaderid']").val(),
      productid: $("input[name='productid']").val(),
      qty: $("input[name='qty']").val(),
      unitofmeasureid: $("input[name='unitofmeasureid']").val(),
      slocid: $("input[name='slocid']").val(),
      price: $("input[name='price']").val(),
      currencyid: $("input[name='currencyid']").val(),
      currencyrate: $("input[name='currencyrate']").val(),
      delvdate: $("input[name='delvdate']").val(),
      itemnote: $("textarea[name='itemnote']").val(),
      isbonus: isbonus,
    },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        $("#SodetailDialog").modal("hide");
        toastr.info(data.div);
        $.fn.yiiGridView.update("SodetailList");
      } else {
        toastr.error(data.div);
      }
    },
    cache: false,
  });
  return false;
}
function savedatasodisc() {
  jQuery.ajax({
    url: "soheader/savesodisc",
    data: {
      sodiscid: $("input[name='sodiscid']").val(),
      soheaderid: $("input[name='soheaderid']").val(),
      discvalue: $("input[name='discvalue']").val(),
    },
    type: "post",
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        $("#SodiscDialog").modal("hide");
        toastr.info(data.div);
        $.fn.yiiGridView.update("SodiscList");
      } else {
        toastr.error(data.div);
      }
    },
    cache: false,
  });
  return false;
}
function rejectdata($id) {
  var r = confirm("Are you sure ?");
  if (r == true) {
    jQuery.ajax({
      url: "soheader/reject",
      data: { id: $id },
      type: "post",
      dataType: "json",
      success: function (data) {
        if (data.status == "success") {
          toastr.info(data.div);
          $.fn.yiiGridView.update("GridList");
        } else {
          toastr.error(data.div);
        }
      },
      cache: false,
    });
  }
  return false;
}
function approvedata($id) {
  var r = confirm("Are you sure ?");
  if (r == true) {
    $(".ajax-loader").css("visibility", "visible");
    jQuery.ajax({
      url: "soheader/approve",
      data: { id: $id },
      type: "post",
      dataType: "json",
      statusCode: {
        200: function (data) {
          //console.log(data);
          //show('Message','Simpan Data Berhasil');
          $.fn.yiiGridView.update("GridList");
        },
      },
      success: function (data) {
        if (data.status == "success") {
          tutup_loading();
          toastr.info(data.div);
          $.fn.yiiGridView.update("GridList");
        } else {
          tutup_loading();
          toastr.error(data.div);
        }
      },
      cache: false,
    });
  }
  return false;
}
function purgedata($id) {
  $.msg.confirmation("Confirm", "Are you sure ?", function () {
    jQuery.ajax({
      url: "soheader/purge",
      data: { id: $id },
      type: "post",
      dataType: "json",
      success: function (data) {
        if (data.status == "success") {
          toastr.info(data.div);
          $.fn.yiiGridView.update("GridList");
        } else {
          toastr.error(data.div);
        }
      },
      cache: false,
    });
  });
  return false;
}
function closedata() {
  jQuery.ajax({
    url: "soheader/close",
    data: { id: $("input[name='soheaderid']").val() },
    type: "post",
    dataType: "json",
    success: function (data) {
      $("#InputDialog").modal("hide");
      $.fn.yiiGridView.update("GridList");
    },
    cache: false,
  });
  return false;
}
function purgedatasodetail($id) {
  let sotype = $("#sotype").val();
  if (sotype == 2) {
    alert("Jenis Paket Tidak bisa dihapus");
  } else {
    $.msg.confirmation("Confirm", "Are you sure ?", function () {
      jQuery.ajax({
        url: "soheader/purgesodetail",
        data: { id: $id },
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.status == "success") {
            toastr.info(data.div);
            $.fn.yiiGridView.update("SodetailList");
          } else {
            toastr.error(data.div);
          }
        },
        cache: false,
      });
    });
    return false;
  }
}
function purgedatasodisc($id) {
  let sotype = $("#sotype").val();
  if (sotype == 2) {
    alert("Jenis Paket Tidak bisa dihapus");
  } else {
    $.msg.confirmation("Confirm", "Are you sure ?", function () {
      jQuery.ajax({
        url: "soheader/purgesodisc",
        data: { id: $id },
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.status == "success") {
            toastr.info(data.div);
            $.fn.yiiGridView.update("SodiscList");
          } else {
            toastr.error(data.div);
          }
        },
        cache: false,
      });
    });
    return false;
  }
}
function searchdata($id = 0) {
  $("#SearchDialog").modal("hide");
  $.fn.yiiGridView.update("GridList", {
    data: {
      soheaderid: $id,
      fullname: $("input[name='dlg_search_fullname']").val(),
      companyname: $("input[name='dlg_search_companyname']").val(),
      salesname: $("input[name='dlg_search_salesname']").val(),
      pocustno: $("input[name='dlg_search_pocustno']").val(),
    },
  });
  return false;
}
function downpdf($id = 0) {
  var array = "soheaderid=" + $id + "&fullname=" + $("input[name='dlg_search_fullname']").val() + "&companyname=" + $("input[name='dlg_search_companyname']").val() + "&salesname=" + $("input[name='dlg_search_salesname']").val();
  window.open("soheader/downpdf?" + array);
}
function downpdfcustomer($id = 0) {
  var array = "soheaderid=" + $id + "&fullname=" + $("input[name='dlg_search_fullname']").val() + "&companyname=" + $("input[name='dlg_search_companyname']").val() + "&salesname=" + $("input[name='dlg_search_salesname']").val();
  window.open("soheader/downpdfcustomer?" + array);
}
function downxls($id = 0) {
  var array = "soheaderid=" + $id + "&fullname=" + $("input[name='dlg_search_fullname']").val() + "&companyname=" + $("input[name='dlg_search_companyname']").val() + "&salesname=" + $("input[name='dlg_search_salesname']").val();
  window.open("soheader/downxls?" + array);
}
function GetDetail($id) {
  $("#ShowDetailDialog").modal("show");
  var array = "soheaderid=" + $id;
  $.fn.yiiGridView.update("DetailSodetailList", { data: array });
  $.fn.yiiGridView.update("DetailSodiscList", { data: array });
}
