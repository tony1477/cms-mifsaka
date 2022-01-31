if("undefined"==typeof jQuery)throw new Error("Employee's JavaScript requires jQuery");
function newdata()
{
	var x;
	jQuery.ajax({'url':'employee/create','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='employeeid']").val(data.employeeid);
			$("input[name='addressbookid']").val('');
			$("input[name='actiontype']").val(0);
			$("input[name='fullname']").val('');
			$("input[name='companyid']").val(data.companyid);
			$("input[name='companyname']").val(data.companyname);
			$("input[name='oldnik']").val('');
			$("input[name='orgstructureid']").val('');
			$("input[name='structurename']").val('');
			$("input[name='positionid']").val('');
			$("input[name='positionname']").val('');
			$("input[name='employeetypeid']").val('');
			$("input[name='employeetypename']").val('');
			$("input[name='sexid']").val('');
			$("input[name='sexname']").val('');
			$("input[name='birthcityid']").val('');
			$("input[name='cityname']").val('');
			$("input[name='birthdate']").val('');
			$("input[name='religionid']").val('');
			$("input[name='religionname']").val('');
			$("input[name='maritalstatusid']").val('');
			$("input[name='maritalstatusname']").val('');
			$("input[name='referenceby']").val('');
			$("input[name='joindate']").val('');
			$("input[name='employeestatusid']").val('');
			$("input[name='employeestatusname']").val('');
			$("input[name='istrial']").val('');
			$("input[name='photo']").val('');
			$("input[name='resigndate']").val('');
			$("input[name='levelorgid']").val('');
			$("input[name='levelorgname']").val('');
			$.fn.yiiGridView.update('FamilyList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('IdentityList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('ForeignLanguageList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('EducationList',{data:{'employeeid':data.employeeid}});
			$('#InputDialog').modal();
		},
		'cache':false});
	return false;
}
function newdatafamily()
{
	var x;
	jQuery.ajax({'url':'employee/createfamily','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='employeefamilyid']").val('');
			$("input[name='familyrelationid']").val('');
			$("input[name='familyname']").val('');
			$("input[name='familysexid']").val('');
			$("input[name='familysexname']").val('');
			$("input[name='familycityid']").val('');
			$("input[name='familycityname']").val('');
			$("input[name='familyeducationid']").val('');
			$("input[name='familyeducationname']").val('');
			$('#FamilyDialog').modal();
		},
		'cache':false});
	return false;
}
function newdataidentity()
{
	var x;
	jQuery.ajax({'url':'employee/createidentity','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='employeeidentityid']").val('');
				$("input[name='identitytypeid']").val('');
				$("input[name='identitytypename']").val('');
				$("input[name='identityname']").val('');
			$('#IdentityDialog').modal();
		},
		'cache':false});
	return false;
}
function newdataforeignlanguage()
{
	var x;
	jQuery.ajax({'url':'employee/createforeignlanguage','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='employeeforeignlanguageid']").val('');
				$("input[name='languageid']").val('');
				$("input[name='languagename']").val('');
				$("input[name='languagevalueid']").val('');
				$("input[name='languagevaluename']").val('');
			$('#ForeignLanguageDialog').modal();
		},
		'cache':false});
	return false;
}
function newdataeducation()
{
	var x;
	jQuery.ajax({'url':'employee/createeducation','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			$("input[name='employeeeducationid']").val('');
				$("input[name='educationid']").val('');
				$("input[name='educationname']").val('');
				$("input[name='schoolname']").val('');
				$("input[name='educationcityid']").val('');
				$("input[name='educationcityname']").val('');
				$("input[name='yeargraduate']").val('');
				$("input[name='educationmajorid']").val('');
				$("input[name='educationmajorname']").val('');
			$('#EducationDialog').modal();
		},
		'cache':false});
	return false;
}
function updatedata($id)
{
	var x;
	jQuery.ajax({'url':'employee/update',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='actiontype']").val(1);
				$("input[name='addressbookid']").val(data.addressbookid);
				$("input[name='companyid']").val(data.companyid);
				$("input[name='companyname']").val(data.companyname);
				$("input[name='employeeid']").val(data.employeeid);
				$("input[name='fullname']").val(data.fullname);
				$("input[name='oldnik']").val(data.oldnik);
				$("input[name='orgstructureid']").val(data.orgstructureid);
				$("input[name='structurename']").val(data.structurename);
			$("input[name='positionid']").val(data.positionid);
			$("input[name='positionname']").val(data.positionname);
			$("input[name='employeetypeid']").val(data.employeetypeid);
			$("input[name='employeetypename']").val(data.employeetypename);
			$("input[name='sexid']").val(data.sexid);
			$("input[name='sexname']").val(data.sexname);
			$("input[name='birthcityid']").val(data.birthcityid);
			$("input[name='cityname']").val(data.cityname);
			$("input[name='birthdate']").val(data.birthdate);
			$("input[name='religionid']").val(data.religionid);
			$("input[name='religionname']").val(data.religionname);
			$("input[name='maritalstatusid']").val(data.maritalstatusid);
			$("input[name='maritalstatusname']").val(data.maritalstatusname);
			$("input[name='referenceby']").val(data.referenceby);
			$("input[name='joindate']").val(data.joindate);
			$("input[name='employeestatusid']").val(data.employeestatusid);
			$("input[name='employeestatusname']").val(data.employeestatusname);
			$("input[name='photo']").val(data.photo);
			$("input[name='resigndate']").val(data.resigndate);
			$("input[name='levelorgid']").val(data.levelorgid);
			$("input[name='levelorgname']").val(data.levelorgname);
				if (data.istrial == 1)
				{
					$("input[name='istrial']").prop('checked',true);
				}
				else
				{
					$("input[name='istrial']").prop('checked',false)
				}
				if (data.recordstatus == 1)
				{
					$("input[name='recordstatus']").prop('checked',true);
				}
				else
				{
					$("input[name='recordstatus']").prop('checked',false)
				}
				$.fn.yiiGridView.update('FamilyList',{data:{'employeeid':data.employeeid}});
				$.fn.yiiGridView.update('IdentityList',{data:{'employeeid':data.employeeid}});
				$.fn.yiiGridView.update('ForeignLanguageList',{data:{'employeeid':data.employeeid}});
				$.fn.yiiGridView.update('EducationList',{data:{'employeeid':data.employeeid}});
				$('#InputDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function updatedataidentity($id)
{
	var x;
	jQuery.ajax({'url':'employee/updateidentity',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
							$("input[name='employeeidentityid']").val(data.employeeidentityid);
				$("input[name='identitytypeid']").val(data.identitytypeid);
				$("input[name='identitytypename']").val(data.identitytypename);
				$("input[name='identityname']").val(data.identityname);
				$('#IdentityDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function updatedatafamily($id)
{
	var x;
	jQuery.ajax({'url':'employee/updatefamily',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeefamilyid']").val(data.employeefamilyid);
				$("input[name='familyrelationid']").val(data.familyrelationid);
				$("input[name='familyrelationname']").val(data.familyrelationname);
				$("input[name='familyname']").val(data.familyname);
				$("input[name='familysexid']").val(data.familysexid);
				$("input[name='familysexname']").val(data.familysexname);
				$("input[name='familycityid']").val(data.familycityid);
				$("input[name='familycityname']").val(data.familycityname);
				$("input[name='familyeducationid']").val(data.familyeducationid);
				$("input[name='familyeducationname']").val(data.familyeducationname);
				$("input[name='familyoccupationid']").val(data.familyoccupationid);
				$("input[name='familyoccupationname']").val(data.familyoccupationname);
				$('#FamilyDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function updatedataforeignlanguage($id)
{
	var x;
	jQuery.ajax({'url':'employee/updateforeignlanguage',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeeforeignlanguageid']").val(data.employeeforeignlanguageid);
				$("input[name='languageid']").val(data.languageid);
				$("input[name='languagename']").val(data.languagename);
				$("input[name='languagevalueid']").val(data.languagevalueid);
				$("input[name='languagevaluename']").val(data.languagevaluename);
				$('#ForeignLanguageDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function updatedataeducation()
{
	var x;
	jQuery.ajax({'url':'employee/updateeducation',
		'data':{'id':$.fn.yiiGridView.getSelection("EducationList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeeeducationid']").val(data.employeeeducationid);
				$("input[name='educationid']").val(data.educationid);
				$("input[name='educationname']").val(data.educationname);
				$("input[name='schoolname']").val(data.schoolname);
				$("input[name='educationcityid']").val(data.cityid);
				$("input[name='yeargraduate']").val(data.yeargraduate);
				$("input[name='educationcityname']").val(data.cityname);
				$("input[name='educationmajorid']").val(data.educationmajorid);
				$("input[name='educationmajorname']").val(data.educationmajorname);
				if (data.isdiploma == 1)
				{
					$("input[name='isdiploma']").prop('checked',true);
				}
				else
				{
					$("input[name='isdiploma']").prop('checked',false)
				}
				$('#EducationDialog').modal();
			}
		},
		'cache':false});
	return false;
}
function savedata()
{
	var istrial = 0;
	if ($("input[name='istrial']").prop('checked'))
	{
		istrial = 1;
	}
	var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	jQuery.ajax({'url':'employee/save',
		'data':{	
			'actiontype':$("input[name='actiontype']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'addressbookid':$("input[name='addressbookid']").val(),
			'fullname':$("input[name='fullname']").val(),
			'companyid': $("input[name='companyid']").val(),
			'companyname': $("input[name='companyname']").val(),
			'oldnik': $("input[name='oldnik']").val(),
			'orgstructureid': $("input[name='orgstructureid']").val(),
			'positionid': $("input[name='positionid']").val(),
			'employeetypeid': $("input[name='employeetypeid']").val(),
			'sexid': $("input[name='sexid']").val(),
			'birthcityid': $("input[name='birthcityid']").val(),
			'birthdate': $("input[name='birthdate']").val(),
			'religionid': $("input[name='religionid']").val(),
			'maritalstatusid': $("input[name='maritalstatusid']").val(),
			'referenceby': $("input[name='referenceby']").val(),
			'joindate': $("input[name='joindate']").val(),
			'employeestatusid': $("input[name='employeestatusid']").val(),
			'istrial': istrial,
			'photo': $("input[name='photo']").val(),
			'resigndate': $("input[name='resigndate']").val(),
			'levelorgid': $("input[name='levelorgid']").val(),
			'recordstatus': recordstatus
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
	return false;
}
function savedatafamily()
{
	jQuery.ajax({'url':'employee/savefamily',
		'data':{
			'employeeid': $("input[name='employeeid']").val(),
			'employeefamilyid': $("input[name='employeefamilyid']").val(),
			'familyrelationid': $("input[name='familyrelationid']").val(),
			'familyname':$("input[name='familyname']").val(),
			'familysexid': $("input[name='familysexid']").val(),
			'familycityid': $("input[name='familycityid']").val(),
			'familyeducationid': $("input[name='familyeducationid']").val(),
			'familyoccupationid': $("input[name='familyoccupationid']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#FamilyDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("FamilyList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function savedataidentity()
{
	jQuery.ajax({'url':'employee/saveidentity',
		'data':{
			'employeeidentityid':$("input[name='employeeidentityid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'identitytypeid':$("input[name='identitytypeid']").val(),
			'identityname':$("input[name='identityname']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#IdentityDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("IdentityList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function savedataforeignlanguage()
{
	jQuery.ajax({'url':'employee/saveforeignlanguage',
		'data':{
			'employeeforeignlanguageid':$("input[name='employeeforeignlanguageid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'languageid':$("input[name='languageid']").val(),
			'languagevalueid':$("input[name='languagevalueid']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#ForeignLanguageDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("ForeignLanguageList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function savedataeducation()
{
	var isdiploma = 0;
	if ($("input[name='isdiploma']").prop('checked'))
	{
		isdiploma = 1;
	}
	jQuery.ajax({'url':'employee/saveeducation',
		'data':{
			'employeeeducationid':$("input[name='employeeeducationid']").val(),
			'employeeid':$("input[name='employeeid']").val(),
			'educationid':$("input[name='educationid']").val(),
			'schoolname':$("input[name='schoolname']").val(),
			'cityid':$("input[name='educationcityid']").val(), 
			'yeargraduate':$("input[name='yeargraduate']").val(),
			'educationmajorid':$("input[name='educationmajorid']").val(),
			'isdiploma':isdiploma
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#EducationDialog').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("EducationList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function purgedata($id)
{
	$.msg.confirmation('Confirm','Are you sure ?',function(){
	jQuery.ajax({'url':'employee/purge',
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
		'cache':false});
	});
	return false;
}
function closedata()
{
	jQuery.ajax({'url':'employee/close',
		'data':{'id':$("input[name='addressbookid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
				$('#InputDialog').modal('hide');
				$.fn.yiiGridView.update("GridList");
		},
		'cache':false});
	return false;
}
function purgedatafamily($id)
{
	var r = confirm("Are you sure ?");
	if (r == true) {
	jQuery.ajax({'url':'employee/purgefamily',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("FamilyList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	}
	return false;
}
function purgedataidentity()
{
	var r = confirm("Are you sure ?");
	if (r == true) {
			jQuery.ajax({'url':'employee/purgeidentity',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("IdentityList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	}	
	return false;
}
function purgedataforeignlanguage()
{
	var r = confirm("Are you sure ?");
	if (r == true) {
			jQuery.ajax({'url':'employee/purgeforeignlanguage',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("ForeignLanguageList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	}	
	return false;
}
function purgedataeducation()
{
	var r = confirm("Are you sure ?");
	if (r == true) {
			jQuery.ajax({'url':'employee/purgeeducation',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("EducationList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	}	
	return false;
}
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'employeeid':$id,
		'fullname':$("input[name='dlg_search_fullname']").val()
	}});
	return false;
}
function downpdf($id=0) {
	var array = 'employeeid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('employee/downpdf?'+array);
}
function downxls($id=0) {
	var array = 'employeeid='+$id
	+ '&fullname='+$("input[name='dlg_search_fullname']").val();
	window.open('employee/downxls?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeeid='+$id;
	$.fn.yiiGridView.update('DetailFamilyList',{data:array});
	$.fn.yiiGridView.update('DetailIdentityList',{data:array});
	$.fn.yiiGridView.update('DetailForeignLanguageList',{data:array});
}