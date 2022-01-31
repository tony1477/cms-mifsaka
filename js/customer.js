if ("undefined" == typeof jQuery) throw new Error("Customer's JavaScript requires jQuery");
function newdata() {
	jQuery.ajax({
		url: "customer/create",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
				$("input[name='addressbook_0_fullname']").val("");
				$("input[name='addressbook_0_taxno']").val("");
				$("input[name='addressbook_0_ktpno']").val("");
				$("input[name='addressbook_0_husbandbirthdate']").val("");
				$("input[name='addressbook_0_wifebirthdate']").val("");
				$("input[name='addressbook_0_weddingdate']").val("");
				$("input[name='addressbook_0_creditlimit']").val("");
				$("input[name='addressbook_0_isstrictlimit']").prop("checked", true);
				$("input[name='addressbook_0_bankname']").val("");
				$("input[name='addressbook_0_bankaccountno']").val("");
				$("input[name='addressbook_0_accountowner']").val("");
				$("input[name='addressbook_0_salesareaid']").val("");
				$("input[name='addressbook_0_pricecategoryid']").val("");
				$("input[name='addressbook_0_overdue']").val("");
				$("input[name='addressbook_0_recordstatus']").prop("checked", true);
				$("input[name='addressbook_0_areaname']").val("");
				$("input[name='addressbook_0_categoryname']").val("");
				$("input[name='addressbook_0_taxid']").val("");
				$("input[name='addressbook_0_taxcode']").val("");
				$("input[name='addressbook_0_paymentmethodid']").val("");
				$("input[name='addressbook_0_paycode']").val("");
				$("input[name='addressbook_0_provinceid']").val("");
				$("input[name='addressbook_0_orovincename']").val("");
				$("input[name='addressbook_0_marketareaid']").val("");
				$("input[name='addressbook_0_marketname']").val("");
				$("select[name='addressbook_0_customertypeid']").val("");
				$.fn.yiiGridView.update("addressList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("addresscontactList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("addressaccountList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("customerdiscList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("customerpotensiList", { data: { addressbookid: data.addressbookid } });

				$("#InputDialog").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdataaddress() {
	jQuery.ajax({
		url: "customer/createaddress",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='address_1_addressid']").val("");
				$("input[name='address_1_addresstypeid']").val("");
				$("input[name='address_1_addressname']").val("");
				$("input[name='address_1_rt']").val("");
				$("input[name='address_1_rw']").val("");
				$("input[name='address_1_cityid']").val("");
				$("input[name='address_1_phoneno']").val("");
				$("input[name='address_1_faxno']").val("");
				$("input[name='address_1_lat']").val("");
				$("input[name='address_1_lng']").val("");
				$("input[name='address_1_foto']").val("");
				$("input[name='address_1_addresstypename']").val("");
				$("input[name='address_1_cityname']").val("");
				$("#InputDialogaddress").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdataaddresscontact() {
	jQuery.ajax({
		url: "customer/createaddresscontact",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addresscontact_2_addresscontactid']").val("");
				$("input[name='addresscontact_2_contacttypeid']").val("");
				$("input[name='addresscontact_2_addresscontactname']").val("");
				$("input[name='addresscontact_2_phoneno']").val("");
				$("input[name='addresscontact_2_mobilephone']").val("");
				$("input[name='addresscontact_2_wanumber']").val("");
				$("input[name='addresscontact_2_telegramid']").val("");
				$("input[name='addresscontact_2_emailaddress']").val("");
				$("input[name='addresscontact_2_ktp']").val("");
				$("input[name='addresscontact_2_contacttypename']").val("");
				$("#InputDialogaddresscontact").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdatacustomerdisc() {
	jQuery.ajax({
		url: "customer/createcustomerdisc",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='customerdisc_4_custdiscid']").val("");
				$("input[name='customerdisc_4_materialtypeid']").val("");
				$("input[name='customerdisc_4_discvalue']").val("");
				$("input[name='customerdisc_4_description']").val("");
				$("input[name='customerdisc_4_sopaymethodid']").val("");
				$("input[name='customerdisc_4_realpaymethodid']").val("");
				$("input[name='customerdisc_4_sopaycode']").val("");
				$("input[name='customerdisc_4_realpaycode']").val("");
				$("#InputDialogcustomerdisc").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdataaddressaccount() {
	jQuery.ajax({
		url: "customer/createaddressaccount",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addressaccount_3_addressaccountid']").val("");
				$("input[name='addressaccount_3_companyid']").val(data.companyid);
				$("input[name='addressaccount_3_accpiutangid']").val("");
				$("input[name='addressaccount_3_recordstatus']").prop("checked", true);
				$("input[name='addressaccount_3_companyname']").val(data.companyname);
				$("input[name='addressaccount_3_accpiutangname']").val("");
				$("#InputDialogaddressaccount").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function newdatacustomerpotensi() {
	jQuery.ajax({
		url: "customer/createcustomerpotensi",
		data: {},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='customerpotensi_5_addresspotensiid']").val("");
				$("select[name='customerpotensi_5_grouplineid']").val("");
				$("input[name='customerpotensi_5_amount']").val("");
				$("input[name='customerpotensi_5_recordstatus']").prop("checked", true);
				$("#InputDialogcustomerpotensi").modal();
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
		url: "customer/update",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addressbook_0_addressbookid']").val(data.addressbookid);
				$("input[name='addressbook_0_fullname']").val(data.fullname);
				$("input[name='addressbook_0_taxno']").val(data.taxno);
				$("input[name='addressbook_0_ktpno']").val(data.ktpno);
				$("input[name='addressbook_0_husbandbirthdate']").val(data.husbandbirthdate);
				$("input[name='addressbook_0_wifebirthdate']").val(data.wifebirthdate);
				$("input[name='addressbook_0_weddingdate']").val(data.weddingdate);
				$("input[name='addressbook_0_creditlimit']").val(data.creditlimit);
				if (data.isstrictlimit == 1) {
					$("input[name='addressbook_0_isstrictlimit']").prop("checked", true);
				} else {
					$("input[name='addressbook_0_isstrictlimit']").prop("checked", false);
				}
				$("input[name='addressbook_0_bankname']").val(data.bankname);
				$("input[name='addressbook_0_bankaccountno']").val(data.bankaccountno);
				$("input[name='addressbook_0_accountowner']").val(data.accountowner);
				$("input[name='addressbook_0_salesareaid']").val(data.salesareaid);
				$("input[name='addressbook_0_groupcustomerid']").val(data.groupcustomerid);
				$("input[name='addressbook_0_groupname']").val(data.groupname);
				$("input[name='addressbook_0_pricecategoryid']").val(data.pricecategoryid);
				$("input[name='addressbook_0_overdue']").val(data.overdue);
				$("input[name='addressbook_0_custcategoryid']").val(data.custcategoryid);
				$("input[name='addressbook_0_custcategoryname']").val(data.custcategoryname);
				$("input[name='addressbook_0_custgradeid']").val(data.custgradeid);
				$("input[name='addressbook_0_custgradename']").val(data.custgradename);
				if (data.recordstatus == 1) {
					$("input[name='addressbook_0_recordstatus']").prop("checked", true);
				} else {
					$("input[name='addressbook_0_recordstatus']").prop("checked", false);
				}
				$("input[name='addressbook_0_areaname']").val(data.areaname);
				$("input[name='addressbook_0_categoryname']").val(data.categoryname);
				$("input[name='addressbook_0_taxid']").val(data.taxid);
				$("input[name='addressbook_0_taxcode']").val(data.taxcode);
				$("input[name='addressbook_0_paymentmethodid']").val(data.paymentmethodid);
				$("input[name='addressbook_0_paycode']").val(data.paycode);
				$("input[name='addressbook_0_provinceid']").val(data.provinceid);
				$("input[name='addressbook_0_provincename']").val(data.provincename);
				$("input[name='addressbook_0_marketareaid']").val(data.marketareaid);
				$("input[name='addressbook_0_marketname']").val(data.marketname);
				$("select[name='addressbook_0_customertypeid']").val(data.customertypeid);
				$.fn.yiiGridView.update("addressList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("addresscontactList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("addressaccountList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("customerdiscList", { data: { addressbookid: data.addressbookid } });
				$.fn.yiiGridView.update("customerpotensiList", { data: { addressbookid: data.addressbookid } });

				$("#InputDialog").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function updatedataaddress($id) {
	jQuery.ajax({
		url: "customer/updateaddress",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='address_1_addressid']").val(data.addressid);
				$("input[name='address_1_addresstypeid']").val(data.addresstypeid);
				$("input[name='address_1_addressname']").val(data.addressname);
				$("input[name='address_1_rt']").val(data.rt);
				$("input[name='address_1_rw']").val(data.rw);
				$("input[name='address_1_cityid']").val(data.cityid);
				$("input[name='address_1_phoneno']").val(data.phoneno);
				$("input[name='address_1_faxno']").val(data.faxno);
				$("input[name='address_1_lat']").val(data.lat);
				$("input[name='address_1_lng']").val(data.lng);
				$("input[name='address_1_foto']").val(data.foto);
				$("input[name='address_1_addresstypename']").val(data.addresstypename);
				$("input[name='address_1_cityname']").val(data.cityname);
				$("#InputDialogaddress").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function updatedataaddresscontact($id) {
	jQuery.ajax({
		url: "customer/updateaddresscontact",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addresscontact_2_addresscontactid']").val(data.addresscontactid);
				$("input[name='addresscontact_2_contacttypeid']").val(data.contacttypeid);
				$("input[name='addresscontact_2_addresscontactname']").val(data.addresscontactname);
				$("input[name='addresscontact_2_phoneno']").val(data.phoneno);
				$("input[name='addresscontact_2_mobilephone']").val(data.mobilephone);
				$("input[name='addresscontact_2_wanumber']").val(data.wanumber);
				$("input[name='addresscontact_2_telegramid']").val(data.telegramid);
				$("input[name='addresscontact_2_emailaddress']").val(data.emailaddress);
				$("input[name='addresscontact_2_ktp']").val(data.ktp);
				$("input[name='addresscontact_2_contacttypename']").val(data.contacttypename);
				$("#InputDialogaddresscontact").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function updatedatacustomerdisc($id) {
	jQuery.ajax({
		url: "customer/updatecustomerdisc",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='customerdisc_4_custdiscid']").val(data.custdiscid);
				$("input[name='customerdisc_4_materialtypeid']").val(data.materialtypeid);
				$("input[name='customerdisc_4_description']").val(data.description);
				$("input[name='customerdisc_4_discvalue']").val(data.discvalue);
				$("input[name='customerdisc_4_sopaymethodid']").val(data.sopaymethodid);
				$("input[name='customerdisc_4_realpaymethodid']").val(data.realpaymethodid);
				$("input[name='customerdisc_4_sopaycode']").val(data.sopaycode);
				$("input[name='customerdisc_4_realpaycode']").val(data.realpaycode);
				$("#InputDialogcustomerdisc").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}
function updatedataaddressaccount($id) {
	jQuery.ajax({
		url: "customer/updateaddressaccount",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='addressaccount_3_addressaccountid']").val(data.addressaccountid);
				$("input[name='addressaccount_3_companyid']").val(data.companyid);
				$("input[name='addressaccount_3_accpiutangid']").val(data.accpiutangid);
				if (data.recordstatus == 1) {
					$("input[name='addressaccount_3_recordstatus']").prop("checked", true);
				} else {
					$("input[name='addressaccount_3_recordstatus']").prop("checked", false);
				}
				$("input[name='addressaccount_3_companyname']").val(data.companyname);
				$("input[name='addressaccount_3_accpiutangname']").val(data.accpiutangname);
				$("#InputDialogaddressaccount").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}

function updatedatacustomerpotensi($id) {
	jQuery.ajax({
		url: "customer/updatecustomerpotensi",
		data: { id: $id },
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("input[name='customerpotensi_5_addresspotensiid']").val(data.addresspotensiid);
				if (data.recordstatus == 1) {
					$("input[name='customerpotensi_5_recordstatus']").prop("checked", true);
				} else {
					$("input[name='customerpotensi_5_recordstatus']").prop("checked", false);
				}
				$("select[name='customerpotensi_5_grouplineid']").val(data.grouplineid);
				$("input[name='customerpotensi_5_amount']").val(data.amount);
				$("#InputDialogcustomerpotensi").modal();
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
	return false;
}

function savedata() {
	var isstrictlimit = 0;
	if ($("input[name='addressbook_0_isstrictlimit']").prop("checked")) {
		isstrictlimit = 1;
	} else {
		isstrictlimit = 0;
	}
	var recordstatus = 0;
	if ($("input[name='addressbook_0_recordstatus']").prop("checked")) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({
		url: "customer/save",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			fullname: $("input[name='addressbook_0_fullname']").val(),
			taxno: $("input[name='addressbook_0_taxno']").val(),
			ktpno: $("input[name='addressbook_0_ktpno']").val(),
			husbandbirthdate: $("input[name='addressbook_0_husbandbirthdate']").val(),
			wifebirthdate: $("input[name='addressbook_0_wifebirthdate']").val(),
			weddingdate: $("input[name='addressbook_0_weddingdate']").val(),
			creditlimit: $("input[name='addressbook_0_creditlimit']").val(),
			isstrictlimit: isstrictlimit,
			bankname: $("input[name='addressbook_0_bankname']").val(),
			bankaccountno: $("input[name='addressbook_0_bankaccountno']").val(),
			accountowner: $("input[name='addressbook_0_accountowner']").val(),
			salesareaid: $("input[name='addressbook_0_salesareaid']").val(),
			groupcustomerid: $("input[name='addressbook_0_groupcustomerid']").val(),
			pricecategoryid: $("input[name='addressbook_0_pricecategoryid']").val(),
			overdue: $("input[name='addressbook_0_overdue']").val(),
			taxid: $("input[name='addressbook_0_taxid']").val(),
			paymentmethodid: $("input[name='addressbook_0_paymentmethodid']").val(),
			custcategoryid: $("input[name='addressbook_0_custcategoryid']").val(),
			custgradeid: $("input[name='addressbook_0_custgradeid']").val(),
			provinceid: $("input[name='addressbook_0_provinceid']").val(),
			marketareaid: $("input[name='addressbook_0_marketareaid']").val(),
			customertypeid: $("select[name='addressbook_0_customertypeid']").val(),
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

function savedataaddress() {
	jQuery.ajax({
		url: "customer/saveaddress",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			addressid: $("input[name='address_1_addressid']").val(),
			addresstypeid: $("input[name='address_1_addresstypeid']").val(),
			addressname: $("input[name='address_1_addressname']").val(),
			rt: $("input[name='address_1_rt']").val(),
			rw: $("input[name='address_1_rw']").val(),
			cityid: $("input[name='address_1_cityid']").val(),
			phoneno: $("input[name='address_1_phoneno']").val(),
			faxno: $("input[name='address_1_faxno']").val(),
			lat: $("input[name='address_1_lat']").val(),
			lng: $("input[name='address_1_lng']").val(),
			foto: $("input[name='address_1_foto']").val(),
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogaddress").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}

function savedataaddresscontact() {
	jQuery.ajax({
		url: "customer/saveaddresscontact",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			addresscontactid: $("input[name='addresscontact_2_addresscontactid']").val(),
			contacttypeid: $("input[name='addresscontact_2_contacttypeid']").val(),
			addresscontactname: $("input[name='addresscontact_2_addresscontactname']").val(),
			phoneno: $("input[name='addresscontact_2_phoneno']").val(),
			mobilephone: $("input[name='addresscontact_2_mobilephone']").val(),
			wanumber: $("input[name='addresscontact_2_wanumber']").val(),
			telegramid: $("input[name='addresscontact_2_telegramid']").val(),
			emailaddress: $("input[name='addresscontact_2_emailaddress']").val(),
			ktp: $("input[name='addresscontact_2_ktp']").val(),
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogaddresscontact").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("addresscontactList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}

function savedatacustomerdisc() {
	jQuery.ajax({
		url: "customer/savecustomerdisc",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			custdiscid: $("input[name='customerdisc_4_custdiscid']").val(),
			materialtypeid: $("input[name='customerdisc_4_materialtypeid']").val(),
			discvalue: $("input[name='customerdisc_4_discvalue']").val(),
			sopaymethodid: $("input[name='customerdisc_4_sopaymethodid']").val(),
			realpaymethodid: $("input[name='customerdisc_4_realpaymethodid']").val(),
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogcustomerdisc").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("customerdiscList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}
function savedataaddressaccount() {
	var recordstatus = 0;
	if ($("input[name='addressaccount_3_recordstatus']").prop("checked")) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({
		url: "customer/saveaddressaccount",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			addressaccountid: $("input[name='addressaccount_3_addressaccountid']").val(),
			companyid: $("input[name='addressaccount_3_companyid']").val(),
			accpiutangid: $("input[name='addressaccount_3_accpiutangid']").val(),
			recordstatus: recordstatus,
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogaddressaccount").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressaccountList");
			} else {
				toastr.error(data.div);
			}
		},
		cache: false,
	});
}

function savedatacustomerpotensi() {
	let recordstatus = 0;
	if ($("input[name='customerpotensi_5_recordstatus']").prop("checked")) {
		recordstatus = 1;
	} else {
		recordstatus = 0;
	}
	jQuery.ajax({
		url: "customer/savecustomerpotensi",
		data: {
			addressbookid: $("input[name='addressbook_0_addressbookid']").val(),
			addresspotensiid: $("input[name='customerpotensi_5_addresspotensiid']").val(),
			grouplineid: $("select[name='customerpotensi_5_grouplineid']").val(),
			amount: $("input[name='customerpotensi_5_amount']").val(),
			recordstatus: recordstatus,
		},
		type: "post",
		dataType: "json",
		success: function (data) {
			if (data.status == "success") {
				$("#InputDialogcustomerpotensi").modal("hide");
				toastr.info(data.div);
				$.fn.yiiGridView.update("customerpotensiList");
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
			url: "customer/delete",
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
			url: "customer/purge",
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
function purgedataaddress() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "customer/purgeaddress",
			data: { id: $.fn.yiiGridView.getSelection("addressList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("addressList");
				} else {
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}
function purgedataaddresscontact() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "customer/purgeaddresscontact",
			data: { id: $.fn.yiiGridView.getSelection("addresscontactList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("addresscontactList");
				} else {
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}
function purgedatacustomerdisc() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "customer/purgecustomerdisc",
			data: { id: $.fn.yiiGridView.getSelection("customerdiscList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("customerdiscList");
				} else {
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}
function purgedataaddressaccount() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "customer/purgeaddressaccount",
			data: { id: $.fn.yiiGridView.getSelection("addressaccountList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("addressaccountList");
				} else {
					toastr.error(data.div);
				}
			},
			cache: false,
		});
	});
	return false;
}
function purgedatacustomerpotensi() {
	$.msg.confirmation("Confirm", "Apakah anda yakin ?", function () {
		jQuery.ajax({
			url: "customer/purgecustomerpotensi",
			data: { id: $.fn.yiiGridView.getSelection("customerpotensiList") },
			type: "post",
			dataType: "json",
			success: function (data) {
				if (data.status == "success") {
					toastr.info(data.div);
					$.fn.yiiGridView.update("customerpotensiList");
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
			addressbookid: $id,
			fullname: $("input[name='dlg_search_fullname']").val(),
			areaname: $("input[name='dlg_search_areaname']").val(),
			categoryname: $("input[name='dlg_search_categoryname']").val(),
			groupname: $("input[name='dlg_search_groupname']").val(),
			overdue: $("input[name='dlg_search_overdue']").val(),
		},
	});
	return false;
}

function downpdf($id = 0) {
	var array =
		"addressbookid=" +
		$id +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&areaname=" +
		$("input[name='dlg_search_areaname']").val() +
		"&categoryname=" +
		$("input[name='dlg_search_categoryname']").val() +
		"&groupname=" +
		$("input[name='dlg_search_groupname']").val() +
		"&overdue=" +
		$("input[name='dlg_search_overdue']").val();
	window.open("customer/downpdf?" + array);
}

function downxls($id = 0) {
	var array =
		"addressbookid=" +
		$id +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&areaname=" +
		$("input[name='dlg_search_areaname']").val() +
		"&categoryname=" +
		$("input[name='dlg_search_categoryname']").val() +
		"&groupname=" +
		$("input[name='dlg_search_groupname']").val() +
		"&overdue=" +
		$("input[name='dlg_search_overdue']").val();
	window.open("customer/downxls?" + array);
}

function downpdf1($id = 0) {
	var array =
		"addressbookid=" +
		$id +
		"&company=" +
		$("input[name='dlg_search_company']").val() +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&areaname=" +
		$("input[name='dlg_search_areaname']").val() +
		"&categoryname=" +
		$("input[name='dlg_search_categoryname']").val() +
		"&groupname=" +
		$("input[name='dlg_search_groupname']").val() +
		"&overdue=" +
		$("input[name='dlg_search_overdue']").val();
	window.open("customer/downpdf1?" + array);
}

function downxls1($id = 0) {
	var array =
		"addressbookid=" +
		$id +
		"&company=" +
		$("input[name='dlg_search_company']").val() +
		"&fullname=" +
		$("input[name='dlg_search_fullname']").val() +
		"&areaname=" +
		$("input[name='dlg_search_areaname']").val() +
		"&categoryname=" +
		$("input[name='dlg_search_categoryname']").val() +
		"&groupname=" +
		$("input[name='dlg_search_groupname']").val() +
		"&overdue=" +
		$("input[name='dlg_search_overdue']").val();
	window.open("customer/downxls1?" + array);
}

function GetDetail($id) {
	$("#ShowDetailDialog").modal("show");
	var array = "addressbookid=" + $id;
	$.fn.yiiGridView.update("DetailaddressList", { data: array });
	$.fn.yiiGridView.update("DetailaddresscontactList", { data: array });
	$.fn.yiiGridView.update("DetailaddressaccountList", { data: array });
	$.fn.yiiGridView.update("DetailcustomerdiscList", { data: array });
	$.fn.yiiGridView.update("DetailcustomerpotensiList", { data: array });
}
