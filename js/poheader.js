if ("undefined" == typeof jQuery) throw new Error("Purchase Order's JavaScript requires jQuery");
function tampil_loading() {
	$(".ajax-loader").css("visibility", "visible");
}

function tutup_loading() {
	$(".ajax-loader").css("visibility", "hidden");
}
function newdata() {
	jQuery.ajax({
		url: "poheader/create",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='poheader_0_poheaderid']").val(data.poheaderid);
				$("input[name='poheader_0_companyid']").val(data.companyid);
				$("input[name='poheader_0_docdate']").val(data.docdate);
				$("input[name='poheader_0_purchasinggroupid']").val("");
				$("input[name='poheader_0_addressbookid']").val("");
				$("input[name='poheader_0_paymentmethodid']").val("");
				$("input[name='poheader_0_taxid']").val("");
				$("textarea[name='poheader_0_shipto']").val("");
				$("textarea[name='poheader_0_billto']").val("");
				$("input[name='poheader_0_headernote']").val("");
				$("input[name='poheader_0_recordstatus']").val(data.recordstatus);
				$("input[name='poheader_0_companyname']").val(data.companyname);
				$("input[name='poheader_0_purchasinggroupcode']").val("");
				$("input[name='poheader_0_fullname']").val("");
				$("input[name='poheader_0_paycode']").val("");
				$("input[name='poheader_0_taxcode']").val("");
				$.fn.yiiGridView.update("podetailList", { data: { poheaderid: data.poheaderid } });

				$("#InputDialog").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdatapodetail() {
	jQuery.ajax({
		url: "poheader/createpodetail",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='podetail_1_podetailid']").val("");
				$("input[name='podetail_1_prmaterialid']").val("");
				$("input[name='podetail_1_productid']").val("");
				$("input[name='podetail_1_poqty']").val(data.poqty);
				$("input[name='podetail_1_unitofmeasureid']").val("");
				$("input[name='podetail_1_delvdate']").val(data.delvdate);
				$("input[name='podetail_1_netprice']").val(data.netprice);
				$("input[name='podetail_1_currencyid']").val(data.currencyid);
				$("input[name='podetail_1_ratevalue']").val(data.ratevalue);
				$("input[name='podetail_1_diskon']").val(data.diskon);
				$("input[name='podetail_1_underdelvtol']").val(data.underdelvtol);
				$("input[name='podetail_1_overdelvtol']").val(data.overdelvtol);
				$("textarea[name='podetail_1_itemtext']").val("");
				$("input[name='podetail_1_productname']").val("");
				$("input[name='podetail_1_uomcode']").val("");
				$("input[name='podetail_1_currencyname']").val(data.currencyname);
				$("#InputDialogpodetail").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}

function updatedata($id) {
	jQuery.ajax({
		url: "poheader/update",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='poheader_0_poheaderid']").val(data.poheaderid);
				$("input[name='poheader_0_companyid']").val(data.companyid);
				$("input[name='poheader_0_docdate']").val(data.docdate);
				$("input[name='poheader_0_purchasinggroupid']").val(data.purchasinggroupid);
				$("input[name='poheader_0_addressbookid']").val(data.addressbookid);
				$("input[name='poheader_0_paymentmethodid']").val(data.paymentmethodid);
				$("input[name='poheader_0_taxid']").val(data.taxid);
				$("textarea[name='poheader_0_shipto']").val(data.shipto);
				$("textarea[name='poheader_0_billto']").val(data.billto);
				$("input[name='poheader_0_headernote']").val(data.headernote);
				$("input[name='poheader_0_recordstatus']").val(data.recordstatus);
				$("input[name='poheader_0_companyname']").val(data.companyname);
				$("input[name='poheader_0_purchasinggroupcode']").val(data.purchasinggroupcode);
				$("input[name='poheader_0_fullname']").val(data.fullname);
				$("input[name='poheader_0_paycode']").val(data.paycode);
				$("input[name='poheader_0_taxcode']").val(data.taxcode);
				$.fn.yiiGridView.update("podetailList", { data: { poheaderid: data.poheaderid } });

				$("#InputDialog").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function updatedatapodetail($id) {
	jQuery.ajax({
		url: "poheader/updatepodetail",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='podetail_1_podetailid']").val(data.podetailid);
				$("input[name='podetail_1_prmaterialid']").val(data.prmaterialid);
				$("input[name='podetail_1_productid']").val(data.productid);
				$("input[name='podetail_1_poqty']").val(data.poqty);
				$("input[name='podetail_1_unitofmeasureid']").val(data.unitofmeasureid);
				$("input[name='podetail_1_delvdate']").val(data.delvdate);
				$("input[name='podetail_1_netprice']").val(data.netprice);
				$("input[name='podetail_1_currencyid']").val(data.currencyid);
				$("input[name='podetail_1_ratevalue']").val(data.ratevalue);
				$("input[name='podetail_1_diskon']").val(data.diskon);
				$("input[name='podetail_1_underdelvtol']").val(data.underdelvtol);
				$("input[name='podetail_1_overdelvtol']").val(data.overdelvtol);
				$("textarea[name='podetail_1_itemtext']").val(data.itemtext);
				$("input[name='podetail_1_productname']").val(data.productname);
				$("input[name='podetail_1_uomcode']").val(data.uomcode);
				$("input[name='podetail_1_currencyname']").val(data.currencyname);
				$("#InputDialogpodetail").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}

function savedata() {
	jQuery.ajax({
		url: "poheader/save",
		data: {
			poheaderid: $("input[name='poheader_0_poheaderid']").val(),
			companyid: $("input[name='poheader_0_companyid']").val(),
			docdate: $("input[name='poheader_0_docdate']").val(),
			purchasinggroupid: $("input[name='poheader_0_purchasinggroupid']").val(),
			addressbookid: $("input[name='poheader_0_addressbookid']").val(),
			paymentmethodid: $("input[name='poheader_0_paymentmethodid']").val(),
			taxid: $("input[name='poheader_0_taxid']").val(),
			shipto: $("textarea[name='poheader_0_shipto']").val(),
			billto: $("textarea[name='poheader_0_billto']").val(),
			headernote: $("input[name='poheader_0_headernote']").val(),
			recordstatus: $("input[name='poheader_0_recordstatus']").val(),
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialog").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}

function savedatapodetail() {
	jQuery.ajax({
		url: "poheader/savepodetail",
		data: {
			poheaderid: $("input[name='poheader_0_poheaderid']").val(),
			podetailid: $("input[name='podetail_1_podetailid']").val(),
			prmaterialid: $("input[name='podetail_1_prmaterialid']").val(),
			productid: $("input[name='podetail_1_productid']").val(),
			poqty: $("input[name='podetail_1_poqty']").val(),
			unitofmeasureid: $("input[name='podetail_1_unitofmeasureid']").val(),
			delvdate: $("input[name='podetail_1_delvdate']").val(),
			netprice: $("input[name='podetail_1_netprice']").val(),
			currencyid: $("input[name='podetail_1_currencyid']").val(),
			ratevalue: $("input[name='podetail_1_ratevalue']").val(),
			diskon: $("input[name='podetail_1_diskon']").val(),
			underdelvtol: $("input[name='podetail_1_underdelvtol']").val(),
			overdelvtol: $("input[name='podetail_1_overdelvtol']").val(),
			itemtext: $("textarea[name='podetail_1_itemtext']").val(),
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogpodetail").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("podetailList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}

function approvedata($id) {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		tampil_loading();
		jQuery.ajax({
			url: "poheader/approve",
			data: { id: $id },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					tutup_loading();
					$.fn.yiiGridView.update("GridList");
				} else {
					tutup_loading();
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}
function deletedata($id) {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		tampil_loading();
		jQuery.ajax({
			url: "poheader/delete",
			data: { id: $id },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					tutup_loading();
					$.fn.yiiGridView.update("GridList");
				} else {
					tutup_loading();
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}

function purgedata($id) {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "poheader/purge",
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
function purgedatapodetail() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "poheader/purgepodetail",
			data: { id: $.fn.yiiGridView.getSelection("podetailList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("podetailList");
				} else {
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}

function searchdata($id = 0) {
	$("#SearchDialog").modal("hide");
	var array =
		"poheaderid=" +
		$id +
		"&companyname=" +
		$("input[name='dlg_search_companyname']").val() +
		"&pono=" +
		$("input[name='dlg_search_pono']").val() +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&paycode=" +
		$("input[name='dlg_search_paycode']").val() +
		"&taxcode=" +
		$("input[name='dlg_search_taxcode']").val() +
		"&headernote=" +
		$("input[name='dlg_search_headernote']").val();
	$.fn.yiiGridView.update("GridList", { data: array });
	return false;
}

function downpdf($id = 0) {
	var array =
		"poheaderid=" +
		$id +
		"&companyname=" +
		$("input[name='dlg_search_companyname']").val() +
		"&pono=" +
		$("input[name='dlg_search_pono']").val() +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&paycode=" +
		$("input[name='dlg_search_paycode']").val() +
		"&taxcode=" +
		$("input[name='dlg_search_taxcode']").val() +
		"&headernote=" +
		$("input[name='dlg_search_headernote']").val();
	window.open("poheader/downpdf?" + array);
}

function downxls($id = 0) {
	var array =
		"poheaderid=" +
		$id +
		"&companyname=" +
		$("input[name='dlg_search_companyname']").val() +
		"&pono=" +
		$("input[name='dlg_search_pono']").val() +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&paycode=" +
		$("input[name='dlg_search_paycode']").val() +
		"&taxcode=" +
		$("input[name='dlg_search_taxcode']").val() +
		"&headernote=" +
		$("input[name='dlg_search_headernote']").val();
	window.open("poheader/downxls?" + array);
}

function GetDetail($id) {
	$("#ShowDetailDialog").modal("show");
	var array = "poheaderid=" + $id;
	$.fn.yiiGridView.update("DetailpodetailList", { data: array });
}
