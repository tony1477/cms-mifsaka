if ("undefined" == typeof jQuery) throw new Error("Product Plant's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({
		url: "productplant/create",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='productplant_0_productplantid']").val(data.productplantid);
				$("input[name='productplant_0_productid']").val("");
				$("input[name='productplant_0_slocid']").val("");
				$("input[name='productplant_0_unitofissue']").val("");
				$("input[name='productplant_0_isautolot']").prop("checked", true);
				$("input[name='productplant_0_sled']").val("");
				$("input[name='productplant_0_snroid']").val("");
				$("input[name='productplant_0_snro']").val("");
				$("input[name='productplant_0_materialgroupid']").val("");
				$("input[name='productplant_0_mgprocessid']").val("");
				$("input[name='productplant_0_issource']").prop("checked", true);
				$("input[name='productplant_0_recordstatus']").prop("checked", true);
				$("input[name='productplant_0_productname']").val("");
				$("input[name='productplant_0_sloccode']").val("");
				$("input[name='productplant_0_uomcode']").val("");
				$("input[name='productplant_0_materialgroupcode']").val("");
				$("input[name='productplant_0_mgprocess']").val("");

				$("#InputDialog").modal();
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
		url: "productplant/update",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='productplant_0_productplantid']").val(data.productplantid);
				$("input[name='productplant_0_productid']").val(data.productid);
				$("input[name='productplant_0_slocid']").val(data.slocid);
				$("input[name='productplant_0_unitofissue']").val(data.unitofissue);
				if (data.isautolot == 1) {
					$("input[name='productplant_0_isautolot']").prop("checked", true);
				} else {
					$("input[name='productplant_0_isautolot']").prop("checked", false);
				}
				$("input[name='productplant_0_sled']").val(data.sled);
				$("input[name='productplant_0_snroid']").val(data.snroid);
				$("input[name='productplant_0_snro']").val(data.snro);
				$("input[name='productplant_0_materialgroupid']").val(data.materialgroupid);
				$("input[name='productplant_0_mgprocess']").val(data.mgprocessid);
				if (data.issource == 1) {
					$("input[name='productplant_0_issource']").prop("checked", true);
				} else {
					$("input[name='productplant_0_issource']").prop("checked", false);
				}
				if (data.recordstatus == 1) {
					$("input[name='productplant_0_recordstatus']").prop("checked", true);
				} else {
					$("input[name='productplant_0_recordstatus']").prop("checked", false);
				}
				$("input[name='productplant_0_productname']").val(data.productname);
				$("input[name='productplant_0_sloccode']").val(data.sloccode);
				$("input[name='productplant_0_uomcode']").val(data.uomcode);
				$("input[name='productplant_0_materialgroupcode']").val(data.materialgroupcode);
				$("input[name='productplant_0_mgprocess']").val(data.mgprocess);

				$("#InputDialog").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}

function savedata() {
	var isautolot = 0;
	if ($("input[name='productplant_0_isautolot']").prop("checked")) {
		isautolot = 1;
	} else {
		isautolot = 0;
	}
	var issource = 0;
	if ($("input[name='productplant_0_issource']").prop("checked")) {
		issource = 1;
	} else {
		issource = 0;
	}
	var recordstatus = 0;
	if ($("input[name='productplant_0_recordstatus']").prop("checked")) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({
		url: "productplant/save",
		data: {
			productplantid: $("input[name='productplant_0_productplantid']").val(),
			productid: $("input[name='productplant_0_productid']").val(),
			slocid: $("input[name='productplant_0_slocid']").val(),
			unitofissue: $("input[name='productplant_0_unitofissue']").val(),
			isautolot: isautolot,
			sled: $("input[name='productplant_0_sled']").val(),
			snroid: $("input[name='productplant_0_snroid']").val(),
			materialgroupid: $("input[name='productplant_0_materialgroupid']").val(),
			mgprocessid: $("input[name='productplant_0_mgprocessid']").val(),
			issource: issource,
			recordstatus: recordstatus,
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

function deletedata($id) {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "productplant/delete",
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

function purgedata($id) {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "productplant/purge",
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

function searchdata($id = 0) {
	$("#SearchDialog").modal("hide");
	$.fn.yiiGridView.update("GridList", {
		data: {
			productplantid: $id,
			productname: $("input[name='dlg_search_productname']").val(),
			sloccode: $("input[name='dlg_search_sloccode']").val(),
			uomcode: $("input[name='dlg_search_uomcode']").val(),
			materialgroupcode: $("input[name='dlg_search_materialgroupcode']").val(),
		},
	});
	return false;
}

function downpdf($id = 0) {
	var array =
		"productplantid=" +
		$id +
		"&productname=" +
		$("input[name='dlg_search_productname']").val() +
		"&sloccode=" +
		$("input[name='dlg_search_sloccode']").val() +
		"&uomcode=" +
		$("input[name='dlg_search_uomcode']").val() +
		"&materialgroupcode=" +
		$("input[name='dlg_search_materialgroupcode']").val();
	window.open("productplant/downpdf?" + array);
}

function downxls($id = 0) {
	var array =
		"productplantid=" +
		$id +
		"&productname=" +
		$("input[name='dlg_search_productname']").val() +
		"&sloccode=" +
		$("input[name='dlg_search_sloccode']").val() +
		"&uomcode=" +
		$("input[name='dlg_search_uomcode']").val() +
		"&materialgroupcode=" +
		$("input[name='dlg_search_materialgroupcode']").val();
	window.open("productplant/downxls?" + array);
}

function GetDetail($id) {
	$("#ShowDetailDialog").modal("show");
	var array = "productplantid=" + $id;
}
