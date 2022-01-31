if ("undefined" == typeof jQuery) throw new Error("Product's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({
		url: "product/create",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='product_0_productid']").val(data.productid);
				$("input[name='product_0_productname']").val("");
				$("input[name='product_0_productpic']").val(data.productpic);
				$("input[name='product_0_barcode']").val("");
				$("input[name='product_0_k3lnumber']").val("");
				$("input[name='product_0_isstock']").prop("checked", false);
				$("input[name='product_0_isfohulbom']").prop("checked", false);
				$("input[name='product_0_iscontinue']").prop("checked", false);
				$("input[name='product_0_materialtypeid']").val("");
				$("input[name='product_0_description']").val("");
				$("input[name='product_0_productidentityid']").val("");
				$("input[name='product_0_identityname']").val("");
				$("input[name='product_0_productbrandid']").val("");
				$("input[name='product_0_brandname']").val("");
				$("input[name='product_0_productcollectid']").val("");
				$("input[name='product_0_collectionname']").val("");
				$("input[name='product_0_productseriesid']").val("");
				$("input[name='product_0_leadtime']").val("");
				$("input[name='product_0_seriesdesc']").val("");
				$("input[name='product_0_panjang']").val("");
				$("input[name='product_0_lebar']").val("");
				$("input[name='product_0_tinggi']").val("");
				$("input[name='product_0_density']").val("");
				$("input[name='product_0_recordstatus']").prop("checked", true);

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
		url: "product/update",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='product_0_productid']").val(data.productid);
				$("input[name='product_0_productname']").val(data.productname);
				$("input[name='product_0_productpic']").val(data.productpic);
				$("input[name='product_0_barcode']").val(data.barcode);
				$("input[name='product_0_k3lnumber']").val(data.k3lnumber);
				$("input[name='product_0_description']").val(data.description);
				$("input[name='product_0_materialtypeid']").val(data.materialtypeid);
				$("input[name='product_0_productidentityid']").val(data.productidentityid);
				$("input[name='product_0_identityname']").val(data.identityname);
				$("input[name='product_0_productcollectid']").val(data.productcollectid);
				$("input[name='product_0_collectionname']").val(data.collectionname);
				$("input[name='product_0_productbranid']").val(data.productbranid);
				$("input[name='product_0_brandname']").val(data.brandname);
				$("input[name='product_0_productseriesid']").val(data.productseriesid);
				$("input[name='product_0_seriesdesc']").val(data.seriesdesc);
				$("input[name='product_0_leadtime']").val(data.leadtime);
				$("input[name='product_0_panjang']").val(data.panjang);
				$("input[name='product_0_lebar']").val(data.lebar);
				$("input[name='product_0_tinggi']").val(data.tinggi);
				$("input[name='product_0_density']").val(data.density);
				$("input[name='product_0_iscontinue']").val(data.iscontinue);
				if (data.isstock == 1) {
					$("input[name='product_0_isstock']").prop("checked", true);
				} else {
					$("input[name='product_0_isstock']").prop("checked", false);
				}
				if (data.iscontinue == 1) {
					$("input[name='product_0_iscontinue']").prop("checked", true);
				} else {
					$("input[name='product_0_iscontinue']").prop("checked", false);
				}
				if (data.isfohulbom == 1) {
					$("input[name='product_0_isfohulbom']").prop("checked", true);
				} else {
					$("input[name='product_0_isfohulbom']").prop("checked", false);
				}
				if (data.recordstatus == 1) {
					$("input[name='product_0_recordstatus']").prop("checked", true);
				} else {
					$("input[name='product_0_recordstatus']").prop("checked", false);
				}

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
	var isstock = 0;
	if ($("input[name='product_0_isstock']").prop("checked")) {
		isstock = 1;
	} else {
		isstock = 0;
	}
	var iscontinue = 0;
	if ($("input[name='product_0_iscontinue']").prop("checked")) {
		iscontinue = 1;
	} else {
		iscontinue = 0;
	}
	var isfohulbom = 0;
	if ($("input[name='product_0_isfohulbom']").prop("checked")) {
		isfohulbom = 1;
	} else {
		isfohulbom = 0;
	}
	var recordstatus = 0;
	if ($("input[name='product_0_recordstatus']").prop("checked")) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({
		url: "product/save",
		data: {
			productid: $("input[name='product_0_productid']").val(),
			productname: $("input[name='product_0_productname']").val(),
			productpic: $("input[name='product_0_productpic']").val(),
			barcode: $("input[name='product_0_barcode']").val(),
			materialtypeid: $("input[name='product_0_materialtypeid']").val(),
			productidentityid: $("input[name='product_0_productidentityid']").val(),
			productbrandid: $("input[name='product_0_productbrandid']").val(),
			productcollectid: $("input[name='product_0_productcollectid']").val(),
			productseriesid: $("input[name='product_0_productseriesid']").val(),
			leadtime: $("input[name='product_0_leadtime']").val(),
			panjang: $("input[name='product_0_panjang']").val(),
			lebar: $("input[name='product_0_lebar']").val(),
			tinggi: $("input[name='product_0_tinggi']").val(),
			density: $("input[name='product_0_density']").val(),
			k3lnumber: $("input[name='product_0_k3lnumber']").val(),
			isstock: isstock,
			isfohulbom: isfohulbom,
			iscontinue: iscontinue,
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
			url: "product/delete",
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
			url: "product/purge",
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
			productname: $("input[name='dlg_search_productname']").val(),
			productpic: $("input[name='dlg_search_productpic']").val(),
			barcode: $("input[name='dlg_search_barcode']").val(),
			panjang: $("input[name='dlg_search_panjang']").val(),
			lebar: $("input[name='dlg_search_lebar']").val(),
			tinggi: $("input[name='dlg_search_tinggi']").val(),
		},
	});
	return false;
}

function downpdf($id = 0) {
	var array =
		"productid=" +
		$id +
		"&productname=" +
		$("input[name='dlg_search_productname']").val() +
		"&productpic=" +
		$("input[name='dlg_search_productpic']").val() +
		"&barcode=" +
		$("input[name='dlg_search_barcode']").val() +
		"&panjang=" +
		$("input[name='dlg_search_panjang']").val() +
		"&lebar=" +
		$("input[name='dlg_search_lebar']").val() +
		"&tinggi=" +
		$("input[name='dlg_search_tinggi']").val();
	window.open("product/downpdf?" + array);
}

function downxls($id = 0) {
	var array =
		"productid=" +
		$id +
		"&productname=" +
		$("input[name='dlg_search_productname']").val() +
		"&productpic=" +
		$("input[name='dlg_search_productpic']").val() +
		"&barcode=" +
		$("input[name='dlg_search_barcode']").val() +
		"&panjang=" +
		$("input[name='dlg_search_panjang']").val() +
		"&lebar=" +
		$("input[name='dlg_search_lebar']").val() +
		"&tinggi=" +
		$("input[name='dlg_search_tinggi']").val();
	window.open("product/downxls?" + array);
}

function GetDetail($id) {
	$("#ShowDetailDialog").modal("show");
	var array = "productid=" + $id;
}
