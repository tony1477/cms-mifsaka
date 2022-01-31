<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
		if (data.status == "success")
		{
			$("input[name='employee_0_employeeid']").val(data.employeeid);
			$("input[name='addressbookid']").val(data.addressbookid);
			$("input[name='addressid']").val(data.addressid);
			$("input[name='employee_0_companyid']").val('');
		    $("input[name='employee_0_fullname']").val('');
		    $("input[name='employee_0_oldnik']").val('');
		    //$("input[name='employee_0_orgstructureid']").val('');
		    $("input[name='employee_0_positionid']").val('');
		    $("input[name='employee_0_employeetypeid']").val('');
		    $("input[name='employee_0_sexid']").val('');
		    $("input[name='employee_0_birthcityid']").val('');
		    $("input[name='employee_0_birthdate']").val(data.birthdate);
		    $("input[name='employee_0_religionid']").val('');
		    $("input[name='employee_0_maritalstatusid']").val('');
		    $("input[name='employee_0_referenceby']").val('');
		    $("input[name='employee_0_joindate']").val(data.joindate);
		    $("input[name='employee_0_employeestatusid']").val('');
		    $("input[name='employee_0_barcode']").val('');
		    $("input[name='employee_0_photo']").val('');
		    $("input[name='employee_0_resigndate']").val('');
		    $("input[name='employee_0_levelorgid']").val('');
		    $("input[name='employee_0_email']").val('');
		    $("input[name='employee_0_phoneno']").val('');
		    $("input[name='employee_0_alternateemail']").val('');
		    $("input[name='employee_0_hpno']").val('');
		    $("input[name='employee_0_taxno']").val('');
		    $("input[name='employee_0_dplkno']").val('');
		    $("input[name='employee_0_bpjskesno']").val('');
		    $("input[name='employee_0_hpno2']").val('');
		    $("input[name='employee_0_accountno']").val('');
		    $("input[name='employee_0_companyname']").val('');
		    $("input[name='employee_0_structurename']").val('');
		    $("input[name='employee_0_positionname']").val('');
		    $("input[name='employee_0_employeetypename']").val('');
		    $("input[name='employee_0_sexname']").val('');
		    $("input[name='employee_0_cityname']").val('');
		    $("input[name='employee_0_religionname']").val('');
		    $("input[name='employee_0_maritalstatusname']").val('');
		    $("input[name='employee_0_employeestatusname']").val('');
		    $("input[name='employee_0_levelorgname']").val('');
			$.fn.yiiGridView.update('addressList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeeidentityList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeefamilyList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeeeducationList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeeinformalList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeewoList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeecontractList',{data:{'employeeid':data.employeeid}});
			$.fn.yiiGridView.update('employeeorgstructureList',{data:{'employeeid':data.employeeid}});

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
function newdataaddress()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createaddress')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
              $("input[name='address_1_addressid']").val('');
			  $("input[name='address_1_addresstypeid']").val('');
              $("input[name='address_1_addressname']").val('');
              $("input[name='address_1_rt']").val('');
              $("input[name='address_1_rw']").val('');
              $("input[name='address_1_cityid']").val('');
              $("input[name='address_1_lat']").val('');
              $("input[name='address_1_lng']").val('');
              $("input[name='address_1_addresstypename']").val('');
              $("input[name='address_1_cityname']").val('');
			$('#InputDialogaddress').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeeidentity()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeeidentity')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeidentity_2_employeeidentityid']").val('');
      $("input[name='employeeidentity_2_identitytypeid']").val('');
      $("input[name='employeeidentity_2_identityname']").val('');
      $("input[name='employeeidentity_2_recordstatus']").val(data.recordstatus);
      $("input[name='employeeidentity_2_identitytypename']").val('');
      $("input[name='employeeidentity_2_expiredate']").val('');
      $("input[name='employeeidentity_2_foto']").val('');
			$('#InputDialogemployeeidentity').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeefamily()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeefamily')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeefamily_3_employeefamilyid']").val('');
      $("input[name='employeefamily_3_familyname']").val('');
      $("input[name='employeefamily_3_sexid']").val('');
      $("input[name='employeefamily_3_cityid']").val('');
      $("input[name='employeefamily_3_birthdate']").val(data.birthdate);
      $("input[name='employeefamily_3_educationid']").val('');
      $("input[name='employeefamily_3_occupationid']").val('');
      $("input[name='employeefamily_3_recordstatus']").val(data.recordstatus);
      $("input[name='employeefamily_3_familyrelationname']").val('');
      $("input[name='employeefamily_3_sexname']").val('');
      $("input[name='employeefamily_3_cityname']").val('');
      $("input[name='employeefamily_3_educationname']").val('');
      $("input[name='employeefamily_3_occupationname']").val('');
      $("input[name='employeefamily_3_bpjskesno']").val('');
      $("input[name='employeefamily_3_recordstatus']").val('');
			$('#InputDialogemployeefamily').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeeeducation()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeeeducation')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeeducation_4_employeeeducationid']").val('');
      $("input[name='employeeeducation_4_educationid']").val('');
      $("input[name='employeeeducation_4_schoolname']").val('');
      $("input[name='employeeeducation_4_cityid']").val('');
      $("input[name='employeeeducation_4_yeargraduate']").val(data.yeargraduate);
      $("input[name='employeeeducation_4_isdiploma']").prop('checked',true);
      $("input[name='employeeeducation_4_schooldegree']").val('');
      $("input[name='employeeeducation_4_recordstatus']").val(data.recordstatus);
      $("input[name='employeeeducation_4_educationname']").val('');
      $("input[name='employeeeducation_4_cityname']").val('');
      $("input[name='employeeeducation_4_attach']").val('');
			$('#InputDialogemployeeeducation').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeeinformal()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeeinformal')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeinformal_5_employeeinformalid']").val('');
      $("input[name='employeeinformal_5_informalname']").val('');
      $("input[name='employeeinformal_5_organizer']").val('');
      $("input[name='employeeinformal_5_period']").val('');
      $("input[name='employeeinformal_5_isdiploma']").prop('checked',true);
      $("input[name='employeeinformal_5_sponsoredby']").val('');
      $("input[name='employeeinformal_5_attach']").val('');
      $("input[name='employeeinformal_5_recordstatus']").val(data.recordstatus);
			$('#InputDialogemployeeinformal').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeewo()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeewo')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='employeewo_6_employeewoid']").val('');
                $("input[name='employeewo_6_employer']").val('');
                $("textarea[name='employeewo_6_addressname']").val('');
                $("input[name='employeewo_6_telp']").val('');
                $("input[name='employeewo_6_firstposition']").val('');
                $("input[name='employeewo_6_lastposition']").val('');
                $("input[name='employeewo_6_startdate']").val('');
                $("input[name='employeewo_6_enddate']").val('');
                $("input[name='employeewo_6_spvname']").val('');
                $("input[name='employeewo_6_spvposition']").val('');
                $("input[name='employeewo_6_spvphone']").val('');
                $("input[name='employeewo_6_payamount']").val('');
                $("textarea[name='employeewo_6_reasonleave']").val('');
                $("input[name='employeewo_6_attach']").val('');
                $("input[name='employeewo_6_recordstatus']").val('');
                $('#InputDialogemployeewo').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeecontract()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeecontract')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
              $("input[name='employeecontract_7_contractid']").val('');
			  $("input[name='employeecontract_7_employeeid']").val('');
              $("input[name='employeecontract_7_contracttype']").val('');
              $("input[name='employeecontract_7_startdate']").val(data.startdate);
              $("input[name='employeecontract_7_enddate']").val(data.enddate);
              $("input[name='employeecontract_7_description']").val('');
              $("input[name='employeecontract_7_attach']").val('');
              $("input[name='employeecontract_7_recordstatus']").val('');
			$('#InputDialogemployeecontract').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdataemployeeorgstructure()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/createemployeeorgstructure')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
              $("input[name='orgstructure_8_employeeorgstrucid']").val('');
			  $("input[name='orgstructure_8_employeeid']").val('');
              $("input[name='orgstructure_8_orgstructureid']").val('');
              $("input[name='orgstructure_8_structurename']").val('');
              $("input[name='orgstructure_8_startdate']").val('');
              $("input[name='orgstructure_8_enddate']").val('');
              $("input[name='orgstructure_8_attach']").val('');
              $("input[name='orgstructure_8_recordstatus']").val('');
			$('#InputDialogemployeeorgstructure').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employee_0_employeeid']").val(data.employeeid);
				$("input[name='companyid']").val(data.companyid);
				//$("input[name='employee_0_companyid']").val(data.companyid);
				$("input[name='addressbookid']").val(data.addressbookid);
				$("input[name='addressid']").val(data.addressid);
      $("input[name='employee_0_fullname']").val(data.fullname);
      $("input[name='employee_0_oldnik']").val(data.oldnik);
      //$("input[name='employee_0_orgstructureid']").val(data.orgstructureid);
      $("input[name='employee_0_positionid']").val(data.positionid);
      $("input[name='employee_0_employeetypeid']").val(data.employeetypeid);
      $("input[name='employee_0_sexid']").val(data.sexid);
      $("input[name='employee_0_birthcityid']").val(data.birthcityid);
      $("input[name='employee_0_birthdate']").val(data.birthdate);
      $("input[name='employee_0_religionid']").val(data.religionid);
      $("input[name='employee_0_maritalstatusid']").val(data.maritalstatusid);
      $("input[name='employee_0_referenceby']").val(data.referenceby);
      $("input[name='employee_0_joindate']").val(data.joindate);
      $("input[name='employee_0_employeestatusid']").val(data.employeestatusid);
      $("input[name='employee_0_barcode']").val(data.barcode);
      $("input[name='employee_0_photo']").val(data.photo);
      $("input[name='employee_0_resigndate']").val(data.resigndate);
      $("input[name='employee_0_levelorgid']").val(data.levelorgid);
      $("input[name='employee_0_email']").val(data.email);
      $("input[name='employee_0_phoneno']").val(data.phoneno);
      $("input[name='employee_0_alternateemail']").val(data.alternateemail);
      $("input[name='employee_0_hpno']").val(data.hpno);
      $("input[name='employee_0_taxno']").val(data.taxno);
      $("input[name='employee_0_dplkno']").val(data.dplkno);
      $("input[name='employee_0_hpno2']").val(data.hpno2);
      $("input[name='employee_0_accountno']").val(data.accountno);
      $("input[name='employee_0_istrial']").val(data.istrial);
      $("input[name='employee_0_companyname']").val(data.companyname);
      $("input[name='employee_0_structurename']").val(data.structurename);
      $("input[name='employee_0_positionname']").val(data.positionname);
      $("input[name='employee_0_employeetypename']").val(data.employeetypename);
      $("input[name='employee_0_sexname']").val(data.sexname);
      $("input[name='employee_0_birthcityname']").val(data.birthcityname);
      $("input[name='employee_0_religionname']").val(data.religionname);
      $("input[name='employee_0_maritalstatusname']").val(data.maritalstatusname);
      $("input[name='employee_0_employeestatusname']").val(data.employeestatusname);
      $("input[name='employee_0_levelorgname']").val(data.levelorgname);
      $("input[name='employee_0_addresstypeid']").val(data.addresstypeid);
      $("input[name='employee_0_addresstypename']").val(data.addresstypename);
      $("input[name='employee_0_addressname']").val(data.addressname);
      $("input[name='employee_0_rt']").val(data.rt);
      $("input[name='employee_0_rw']").val(data.rw);
      $("input[name='employee_0_cityid']").val(data.cityid);
      $("input[name='employee_0_lat']").val(data.lat);
      $("input[name='employee_0_lng']").val(data.lng);
      $("input[name='employee_0_bpjskesno']").val(data.bpjskesno);
				$.fn.yiiGridView.update('addressList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeeidentityList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeefamilyList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeeeducationList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeeinformalList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeewoList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeecontractList',{data:{'employeeid':data.employeeid}});
$.fn.yiiGridView.update('employeeorgstructureList',{data:{'employeeid':data.employeeid}});

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
function updatedataaddress($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateaddress')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='address_1_addressid']").val(data.addressid);
			$("input[name='address_1_addresstypeid']").val(data.addresstypeid);
			$("input[name='address_1_addressbookid']").val(data.addressbookid);
      $("input[name='address_1_addressname']").val(data.addressname);
      $("input[name='address_1_rt']").val(data.rt);
      $("input[name='address_1_rw']").val(data.rw);
      $("input[name='address_1_cityid']").val(data.cityid);
      $("input[name='address_1_lat']").val(data.lat);
      $("input[name='address_1_lng']").val(data.lng);
      $("input[name='address_1_addresstypename']").val(data.addresstypename);
      $("input[name='address_1_cityname']").val(data.cityname);
			$('#InputDialogaddress').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeeidentity($id)
{
    
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeeidentity')?>',
                 'data':{
                     'id':$id,
                     'employeeid':$("input[name='employee_0_employeeid']").val(),
                 },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeidentity_2_employeeidentityid']").val(data.employeeidentityid);
      $("input[name='employeeidentity_2_identitytypeid']").val(data.identitytypeid);
      $("input[name='employeeidentity_2_identityname']").val(data.identityname);
      //$("input[name='employeeidentity_2_recordstatus']").val(data.recordstatus);
      $("input[name='employeeidentity_2_identitytypename']").val(data.identitytypename);
      $("input[name='employeeidentity_2_expiredate']").val(data.expiredate);
      $("input[name='employeeidentity_2_foto']").val(data.foto);
            if (data.recordstatus == 1)
			{
				$("input[name='employeeidentity_2_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='employeeidentity_2_recordstatus']").prop('checked',false)
			}
			$('#InputDialogemployeeidentity').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeefamily($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeefamily')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeefamily_3_employeefamilyid']").val(data.employeefamilyid);
			$("input[name='employeefamily_3_familyrelationid']").val(data.familyrelationid);
      $("input[name='employeefamily_3_familyname']").val(data.familyname);
      $("input[name='employeefamily_3_sexid']").val(data.sexid);
      $("input[name='employeefamily_3_cityid']").val(data.cityid);
      $("input[name='employeefamily_3_birthdate']").val(data.birthdate);
      $("input[name='employeefamily_3_educationid']").val(data.educationid);
      $("input[name='employeefamily_3_occupationid']").val(data.occupationid);
      $("input[name='employeefamily_3_recordstatus']").val(data.recordstatus);
      $("input[name='employeefamily_3_familyrelationname']").val(data.familyrelationname);
      $("input[name='employeefamily_3_sexname']").val(data.sexname);
      $("input[name='employeefamily_3_cityname']").val(data.cityname);
      $("input[name='employeefamily_3_educationname']").val(data.educationname);
      $("input[name='employeefamily_3_occupationname']").val(data.occupationname);
      $("input[name='employeefamily_3_bpjskesno']").val(data.bpjskesno);
      $("input[name='employeefamily_3_recordstatus']").val(data.recordstatus);
            if (data.recordstatus == 1)
			{
				$("input[name='employeefamily_3_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='employeefamily_3_recordstatus']").prop('checked',false)
			}
			$('#InputDialogemployeefamily').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeeeducation($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeeeducation')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeeducation_4_employeeeducationid']").val(data.employeeeducationid);
      $("input[name='employeeeducation_4_educationid']").val(data.educationid);
      $("input[name='employeeeducation_4_schoolname']").val(data.schoolname);
      $("input[name='employeeeducation_4_cityid']").val(data.cityid);
      $("input[name='employeeeducation_4_yeargraduate']").val(data.yeargraduate);
      if (data.isdiploma == 1)
			{
				$("input[name='employeeeducation_4_isdiploma']").prop('checked',true);
			}
			else
			{
				$("input[name='employeeeducation_4_isdiploma']").prop('checked',false)
			}
        if (data.recordstatus == 1)
			{
				$("input[name='employeeeducation_4_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='employeeeducation_4_recordstatus']").prop('checked',false)
			}
      $("input[name='employeeeducation_4_schooldegree']").val(data.schooldegree);
      //$("input[name='employeeeducation_4_recordstatus']").val(data.recordstatus);
      $("input[name='employeeeducation_4_educationname']").val(data.educationname);
      $("input[name='employeeeducation_4_cityname']").val(data.cityname);
      $("input[name='employeeeducation_4_attach']").val(data.attach);
			$('#InputDialogemployeeeducation').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeeinformal($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeeinformal')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeeinformal_5_employeeinformalid']").val(data.employeeinformalid);
      $("input[name='employeeinformal_5_informalname']").val(data.informalname);
      $("input[name='employeeinformal_5_organizer']").val(data.organizer);
      $("input[name='employeeinformal_5_period']").val(data.period);
      $("input[name='employeeinformal_5_attach']").val(data.attach);
      $("input[name='employeeinformal_5_sponsoredby']").val(data.sponsoredby);
      if (data.isdiploma == 1)
			{
				$("input[name='employeeinformal_5_isdiploma']").prop('checked',true);
			}
			else
			{
				$("input[name='employeeinformal_5_isdiploma']").prop('checked',false)
			}
	$('#InputDialogemployeeinformal').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeewo($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeewo')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                console.log(data);
                $("input[name='employeewo_6_employeewoid']").val(data.employeewoid);
                $("input[name='employeewo_6_employer']").val(data.employer);
                $("textarea[name='employeewo_6_addressname']").val(data.addressname);
                $("input[name='employeewo_6_telp']").val(data.telp);
                $("input[name='employeewo_6_firstposition']").val(data.firstposition);
                $("input[name='employeewo_6_lastposition']").val(data.lastposition);
                $("input[name='employeewo_6_startdate']").val(data.startdate);
                $("input[name='employeewo_6_enddate']").val(data.enddate);
                $("input[name='employeewo_6_spvname']").val(data.spvname);
                $("input[name='employeewo_6_spvposition']").val(data.spvposition);
                $("input[name='employeewo_6_spvphone']").val(data.spvphone);
                $("input[name='employeewo_6_payamount']").val(data.payamount);
                $("textarea[name='employeewo_6_reasonleave']").val(data.reasonleave);
                $("input[name='employeewo_6_attach']").val(data.attach);
                if (data.recordstatus == 1)
                {
                    $("input[name='employeewo_6_recordstatus']").prop('checked',true);
                }
                else
                {
                    $("input[name='employeewo_6_recordstatus']").prop('checked',false)
                }
			$('#InputDialogemployeewo').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeecontract($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeecontract')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			 $("input[name='employeecontract_7_contractid']").val(data.contractid);
			 //$("input[name='employeecontract_7_employeeid']").val(data.employeeid);
			 $("input[name='employeecontract_7_fullname']").val(data.fullname);
             $("input[name='employeecontract_7_contracttype']").val(data.contracttype);
             $("input[name='employeecontract_7_startdate']").val(data.startdate);
             $("input[name='employeecontract_7_enddate']").val(data.enddate);
             $("input[name='employeecontract_7_description']").val(data.description);
             $("input[name='employeecontract_7_attach']").val(data.attach);
             //$("input[name='employeecontract_7_recordstatus']").val(data.recordstatus);
            if (data.recordstatus == 1)
			{
				$("input[name='employeecontract_7_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='employeecontract_7_recordstatus']").prop('checked',false)
			}
			 $('#InputDialogemployeecontract').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function updatedataemployeeorgstructure($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/updateemployeeorgstructure')?>','data':{
                    'id':$id,
                    'employeeid':$("input[name='employee_0_employeeid']").val(),
                },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			  $("input[name='orgstructure_8_employeeorgstrucid']").val(data.employeeorgstrucid);
			  $("input[name='orgstructure_8_employeeid']").val(data.employeeid);
			  $("input[name='orgstructure_8_fullname']").val(data.employeeid);
              $("input[name='orgstructure_8_orgstructureid']").val(data.orgstructureid);
              $("input[name='orgstructure_8_structurename']").val(data.structurename);
              $("input[name='orgstructure_8_startdate']").val(data.startdate);
              $("input[name='orgstructure_8_enddate']").val(data.enddate);
              $("input[name='orgstructure_8_attach']").val(data.attach);
              //$("input[name='orgstructure_8_recordstatus']").val('');
             //$("input[name='employeecontract_7_recordstatus']").val(data.recordstatus);
            if (data.recordstatus == 1)
			{
				$("input[name='orgstructure_8_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='orgstructure_8_recordstatus']").prop('checked',false)
			}
			 $('#InputDialogemployeeorgstructure').modal();
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
var istrial = 0;
	if ($("input[name='employee_0_istrial']").prop('checked'))
	{
		istrial = 1;
	}
	else
	{
		istrial = 0;
	}
    
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/save')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			//'companyid':$("input[name='employee_0_companyid']").val(),
			'companyid':$("input[name='companyid']").val(),
      'fullname':$("input[name='employee_0_fullname']").val(),
      'oldnik':$("input[name='employee_0_oldnik']").val(),
      //'orgstructureid':$("input[name='employee_0_orgstructureid']").val(),
      'positionid':$("input[name='employee_0_positionid']").val(),
      'employeetypeid':$("input[name='employee_0_employeetypeid']").val(),
      'sexid':$("input[name='employee_0_sexid']").val(),
      'birthcityid':$("input[name='employee_0_birthcityid']").val(),
      'birthdate':$("input[name='employee_0_birthdate']").val(),
      'religionid':$("input[name='employee_0_religionid']").val(),
      'maritalstatusid':$("input[name='employee_0_maritalstatusid']").val(),
      'referenceby':$("input[name='employee_0_referenceby']").val(),
      'joindate':$("input[name='employee_0_joindate']").val(),
      'employeestatusid':$("input[name='employee_0_employeestatusid']").val(),
      'barcode':$("input[name='employee_0_barcode']").val(),
      'photo':$("input[name='employee_0_photo']").val(),
      'resigndate':$("input[name='employee_0_resigndate']").val(),
      'levelorgid':$("input[name='employee_0_levelorgid']").val(),
      'email':$("input[name='employee_0_email']").val(),
      'phoneno':$("input[name='employee_0_phoneno']").val(),
      'alternateemail':$("input[name='employee_0_alternateemail']").val(),
      'istrial':istrial,
      'hpno':$("input[name='employee_0_hpno']").val(),
      'taxno':$("input[name='employee_0_taxno']").val(),
      'dplkno':$("input[name='employee_0_dplkno']").val(),
      'bpjskesno':$("input[name='employee_0_bpjskesno']").val(),
      'hpno2':$("input[name='employee_0_hpno2']").val(),
      'addresstypeid':$("input[name='employee_0_addresstypeid']").val(),
      'addressbookid':$("input[name='addressbookid']").val(),
      'addressid':$("input[name='addressid']").val(),
      'addressname':$("textarea[name='employee_0_addressname']").val(),
      'rt':$("input[name='employee_0_rt']").val(),
      'rw':$("input[name='employee_0_rw']").val(),
      'city':$("input[name='employee_0_cityid']").val(),
      'lat':$("input[name='employee_0_lat']").val(),
      'lng':$("input[name='employee_0_lng']").val(),
      'accountno':$("input[name='employee_0_accountno']").val(),
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
function savedataaddress()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveaddress')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'addressid':$("input[name='address_1_addressid']").val(),
			'addresstypeid':$("input[name='address_1_addresstypeid']").val(),
			'addressbookid':$("input[name='addressbookid']").val(),
      'addressname':$("input[name='address_1_addressname']").val(),
      'rt':$("input[name='address_1_rt']").val(),
      'rw':$("input[name='address_1_rw']").val(),
      'cityid':$("input[name='address_1_cityid']").val(),
      'lat':$("input[name='address_1_lat']").val(),
      'lng':$("input[name='address_1_lng']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogaddress').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeeidentity()
{
    var recordstatus = 0;
	if ($("input[name='employeeidentity_2_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
    
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeeidentity')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'employeeidentityid':$("input[name='employeeidentity_2_employeeidentityid']").val(),
      'identitytypeid':$("input[name='employeeidentity_2_identitytypeid']").val(),
      'identityname':$("input[name='employeeidentity_2_identityname']").val(),
      'expiredate':$("input[name='employeeidentity_2_expiredate']").val(),
      'foto':$("input[name='employeeidentity_2_foto']").val(),
      'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeeidentity').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeidentityList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeefamily()
{
    
    var recordstatus = 0;
	if ($("input[name='employeefamily_3_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
    
    
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeefamily')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'familyrelationid':$("input[name='employeefamily_3_familyrelationid']").val(),
			'employeefamilyid':$("input[name='employeefamily_3_employeefamilyid']").val(),
            'familyname':$("input[name='employeefamily_3_familyname']").val(),
            'sexid':$("input[name='employeefamily_3_sexid']").val(),
            'cityid':$("input[name='employeefamily_3_cityid']").val(),
            'birthdate':$("input[name='employeefamily_3_birthdate']").val(),
            'educationid':$("input[name='employeefamily_3_educationid']").val(),
            'occupationid':$("input[name='employeefamily_3_occupationid']").val(),
            'bpjskesno':$("input[name='employeefamily_3_bpjskesno']").val(),
            'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeefamily').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeefamilyList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeeeducation()
{
var isdiploma = 0;
	if ($("input[name='employeeeducation_4_isdiploma']").prop('checked'))
	{
		isdiploma = 1;
	}
	else
	{
		isdiploma = 0;
	}
    
var recordstatus = 0;
    if ($("input[name='employeeeducation_4_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeeeducation')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'employeeeducationid':$("input[name='employeeeducation_4_employeeeducationid']").val(),
            'educationid':$("input[name='employeeeducation_4_educationid']").val(),
            'schoolname':$("input[name='employeeeducation_4_schoolname']").val(),
            'cityid':$("input[name='employeeeducation_4_cityid']").val(),
            'yeargraduate':$("input[name='employeeeducation_4_yeargraduate']").val(),
            'isdiploma':isdiploma,
            'schooldegree':$("input[name='employeeeducation_4_schooldegree']").val(),
            'attach':$("input[name='employeeeducation_4_attach']").val(),
            'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeeeducation').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeeducationList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeeinformal()
{
var isdiploma = 0;
var recordstatus = 0;
	if ($("input[name='employeeinformal_5_isdiploma']").prop('checked'))
	{
		isdiploma = 1;
	}
	else
	{
		isdiploma = 0;
	}
    if ($("input[name='employeeinformal_5_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeeinformal')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'employeeinformalid':$("input[name='employeeinformal_5_employeeinformalid']").val(),
            'informalname':$("input[name='employeeinformal_5_informalname']").val(),
            'organizer':$("input[name='employeeinformal_5_organizer']").val(),
            'period':$("input[name='employeeinformal_5_period']").val(),
            'isdiploma':isdiploma,
            'sponsoredby':$("input[name='employeeinformal_5_sponsoredby']").val(),
            'attach':$("input[name='employeeinformal_5_attach']").val(),
            'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeeinformal').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeinformalList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeewo()
{
    var recordstatus = 0;
    if ($("input[name='employeewo_6_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeewo')?>',
		'data':{
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'employeewoid':$("input[name='employeewo_6_employeewoid']").val(),
            'employer':$("input[name='employeewo_6_employer']").val(),
            'addressname':$("textarea[name='employeewo_6_addressname']").val(),
            'telp':$("input[name='employeewo_6_telp']").val(),
            'firstposition':$("input[name='employeewo_6_firstposition']").val(),
            'lastposition':$("input[name='employeewo_6_lastposition']").val(),
            'startdate':$("input[name='employeewo_6_startdate']").val(),
            'enddate':$("input[name='employeewo_6_enddate']").val(),
            'spvname':$("input[name='employeewo_6_spvname']").val(),
            'spvposition':$("input[name='employeewo_6_spvposition']").val(),
            'spvphone':$("input[name='employeewo_6_spvphone']").val(),
            'payamount':$("input[name='employeewo_6_payamount']").val(),
            'reasonleave':$("textarea[name='employeewo_6_reasonleave']").val(),
            'attach':$("input[name='employeewo_6_attach']").val(),
            'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeewo').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeewoList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeecontract()
{
    var recordstatus = 0;
	if ($("input[name='employeecontract_7_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeecontract')?>',
		'data':{
			'contractid':$("input[name='employeecontract_7_contractid']").val(),
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'contracttype':$("input[name='employeecontract_7_contracttype']").val(),
			'startdate':$("input[name='employeecontract_7_startdate']").val(),
			'enddate':$("input[name='employeecontract_7_enddate']").val(),
			'description':$("input[name='employeecontract_7_description']").val(),
			'attach':$("input[name='employeecontract_7_attach']").val(),
			'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeecontract').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeecontractList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function savedataemployeeorgstructure()
{
    var recordstatus = 0;
	if ($("input[name='orgstructure_8_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/saveemployeeorgstructure')?>',
		'data':{
			'employeeorgstrucid':$("input[name='orgstructure_8_employeeorgstrucid']").val(),
			'employeeid':$("input[name='employee_0_employeeid']").val(),
			'orgstructureid':$("input[name='orgstructure_8_orgstructureid']").val(),
			'startdate':$("input[name='orgstructure_8_startdate']").val(),
			'enddate':$("input[name='orgstructure_8_enddate']").val(),
			'attach':$("input[name='orgstructure_8_attach']").val(),
			'recordstatus':recordstatus,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogemployeeorgstructure').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeorgstructureList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function purgedataaddress()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeaddress','data':{'id':$.fn.yiiGridView.getSelection("addressList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("addressList");
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
function purgedataemployeeidentity()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeeidentity','data':{'id':$.fn.yiiGridView.getSelection("employeeidentityList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeidentityList");
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
function purgedataemployeefamily()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeefamily','data':{'id':$.fn.yiiGridView.getSelection("employeefamilyList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeefamilyList");
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
function purgedataemployeeeducation()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeeeducation','data':{'id':$.fn.yiiGridView.getSelection("employeeeducationList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeeducationList");
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
function purgedataemployeeinformal()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeeinformal','data':{'id':$.fn.yiiGridView.getSelection("employeeinformalList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeinformalList");
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
function purgedataemployeewo()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeewo','data':{'id':$.fn.yiiGridView.getSelection("employeewoList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeewoList");
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
function purgedataemployeecontract()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeecontract','data':{'id':$.fn.yiiGridView.getSelection("employeecontractList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeecontractList");
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
function purgedataemployeeorgstructure()
{
	$.msg.confirmation('Confirm','Apakah anda yakin ?',function(){
	jQuery.ajax({'url':'employee/purgeemployeeorgstructure','data':{'id':$.fn.yiiGridView.getSelection("employeeorgstructureList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("employeeorgstructureList");
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
function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/approve')?>',
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
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employee/delete')?>',
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
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'employee_0_employeeid='+$id
+ '&id='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&contract='+$("input[name='dlg_search_contract']").val()
+ '&isresign='+$("input[name='dlg_search_isresign']").val()
;
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}
function downpdf($id=0) {
	var array = 'employee_0_employeeid='+$id
+ '&id='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&contract='+$("input[name='dlg_search_contract']").val()
+ '&isresign='+$("input[name='dlg_search_isresign']").val()
;
	window.open('<?php echo Yii::app()->createUrl('Hr/employee/downpdf')?>?'+array);
}
function downxls($id=0) {
	var array = 'employee_0_employeeid='+$id
+ '&id='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&contract='+$("input[name='dlg_search_contract']").val()
+ '&isresign='+$("input[name='dlg_search_isresign']").val()
;
	window.open('<?php echo Yii::app()->createUrl('Hr/employee/downxls')?>?'+array);
}
function downpdf1($id=0) {
	var array = 'employee_0_employeeid='+$id
+ '&id='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&contract='+$("input[name='dlg_search_contract']").val()
+ '&isresign='+$("input[name='dlg_search_isresign']").val()
;
	window.open('<?php echo Yii::app()->createUrl('Hr/employee/downpdf1')?>?'+array);
}
function downxls1($id=0) {
	var array = 'employee_0_employeeid='+$id
+ '&id='+$("input[name='dlg_search_employeeid']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&oldnik='+$("input[name='dlg_search_oldnik']").val()
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val()
+ '&sexname='+$("input[name='dlg_search_sexname']").val()
+ '&birthdate='+$("input[name='dlg_search_birthdate']").val()
+ '&religionname='+$("input[name='dlg_search_religionname']").val()
+ '&employeestatusname='+$("input[name='dlg_search_employeestatusname']").val()
+ '&contract='+$("input[name='dlg_search_contract']").val()
+ '&isresign='+$("input[name='dlg_search_isresign']").val()
;
	window.open('<?php echo Yii::app()->createUrl('Hr/employee/downxls1')?>?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeeid='+$id;
$.fn.yiiGridView.update("DetailaddressList",{data:array});
$.fn.yiiGridView.update("DetailemployeeidentityList",{data:array});
$.fn.yiiGridView.update("DetailemployeefamilyList",{data:array});
$.fn.yiiGridView.update("DetailemployeeeducationList",{data:array});
$.fn.yiiGridView.update("DetailemployeeinformalList",{data:array});
$.fn.yiiGridView.update("DetailemployeewoList",{data:array});
$.fn.yiiGridView.update("DetailemployeecontractList",{data:array});
$.fn.yiiGridView.update("DetailemployeeorgstructureList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('employee') ?></h3>
<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
-->
<!--
<?php if ($this->checkAccess('employee','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
-->
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('employee','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo "PDF Rincian Karyawan"?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo "XLS Rincian Karyawan"?></a></li>
      <li><a onclick="downpdf1($.fn.yiiGridView.getSelection('GridList'))"><?php echo "PDF Rekap Karyawan"?></a></li>
      <li><a onclick="downxls1($.fn.yiiGridView.getSelection('GridList'))"><?php echo "XLS Rekap Karyawan"?></a></li>
    </ul>
  </div>
<?php } ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
				'htmlOptions' => array('style'=>'width:10px'),
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{select} {edit} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('detail'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'url'=>'"#"',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('employeeid'),
					'name'=>'employeeid',
					'value'=>'$data["employeeid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'fullname',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('oldnik'),
					'name'=>'oldnik',
					'value'=>'$data["oldnik"]'
				),
							array(
					'header'=>$this->getCatalog('positionname'),
					'name'=>'positionid',
					'value'=>'$data["positionname"]'
				),
							array(
					'header'=>$this->getCatalog('employeetypename'),
					'name'=>'employeetypeid',
					'value'=>'$data["employeetypename"]'
				),
							array(
					'header'=>$this->getCatalog('sexname'),
					'name'=>'sexid',
					'value'=>'$data["sexname"]'
				),
							array(
					'header'=>$this->getCatalog('cityname'),
					'name'=>'birthcityid',
					'value'=>'$data["birthcityname"]'
				),
							array(
					'header'=>$this->getCatalog('birthdate'),
					'name'=>'birthdate',
					'value'=>'Yii::app()->format->formatDate($data["birthdate"])'
				),
							array(
					'header'=>$this->getCatalog('religionname'),
					'name'=>'religionid',
					'value'=>'$data["religionname"]'
				),
							array(
					'header'=>$this->getCatalog('maritalstatusname'),
					'name'=>'maritalstatusid',
					'value'=>'$data["maritalstatusname"]'
				),
							array(
					'header'=>$this->getCatalog('referenceby'),
					'name'=>'referenceby',
					'value'=>'$data["referenceby"]'
				),
							array(
					'header'=>$this->getCatalog('joindate'),
					'name'=>'joindate',
					'value'=>'Yii::app()->format->formatDate($data["joindate"])'
				),
                           array(
					'class'=>'CCheckBoxColumn',
                    'header'=>$this->getCatalog('istrial'),
					'name'=>'istrial',
					'selectableRows'=>'0',
					'checked'=>'$data["istrial"]'),
            
							array(
					'header'=>$this->getCatalog('employeestatusname'),
					'name'=>'employeestatusid',
					'value'=>'$data["employeestatusname"]'
				),
							array(
					'header'=>$this->getCatalog('barcode'),
					'name'=>'barcode',
					'value'=>'$data["barcode"]'
				),
							array(
					'header'=>$this->getCatalog('photo'),
					'name'=>'photo',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/employee/".$data["photo"],$data["photo"],
					array("width"=>"100"))'
				),
							array(
					'header'=>$this->getCatalog('resigndate'),
					'name'=>'resigndate',
					'value'=>'Yii::app()->format->formatDate($data["resigndate"])'
				),
							array(
					'header'=>$this->getCatalog('levelorgname'),
					'name'=>'levelorgid',
					'value'=>'$data["levelorgname"]'
				),
							array(
					'header'=>$this->getCatalog('email'),
					'name'=>'email',
					'value'=>'$data["email"]'
				),
							array(
					'header'=>$this->getCatalog('phoneno'),
					'name'=>'phoneno',
					'value'=>'$data["phoneno"]'
				),
							array(
					'header'=>$this->getCatalog('alternateemail'),
					'name'=>'alternateemail',
					'value'=>'$data["alternateemail"]'
				),
							array(
					'header'=>$this->getCatalog('hpno'),
					'name'=>'hpno',
					'value'=>'$data["hpno"]'
				),
							array(
					'header'=>$this->getCatalog('taxno'),
					'name'=>'taxno',
					'value'=>'$data["taxno"]'
				),
							array(
					'header'=>$this->getCatalog('dplkno'),
					'name'=>'dplkno',
					'value'=>'$data["dplkno"]'
				),
            
                            array(
					'header'=>$this->getCatalog('bpjskesno'),
					'name'=>'bpjskesno',
					'value'=>'$data["bpjskesno"]'
				),
							array(
					'header'=>$this->getCatalog('hpno2'),
					'name'=>'hpno2',
					'value'=>'$data["hpno2"]'
				),
							array(
					'header'=>$this->getCatalog('accountno'),
					'name'=>'accountno',
					'value'=>'$data["accountno"]'
				),
							
		)
));
?>
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_employeeid"><?php echo $this->getCatalog('employeeid')?></label>
						<input type="text" class="form-control" name="dlg_search_employeeid">
					</div>
					<div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
					<div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_oldnik"><?php echo $this->getCatalog('oldnik')?></label>
						<input type="text" class="form-control" name="dlg_search_oldnik">
					</div>
          <div class="form-group">
						<label for="dlg_search_employeetypename"><?php echo $this->getCatalog('employeetypename')?></label>
						<input type="text" class="form-control" name="dlg_search_employeetypename">
					</div>
          <div class="form-group">
						<label for="dlg_search_sexname"><?php echo $this->getCatalog('sexname')?></label>
						<input type="text" class="form-control" name="dlg_search_sexname">
					</div>
          <div class="form-group">
						<label for="dlg_search_birthdate"><?php echo $this->getCatalog('birthdate')?></label>
						<input type="text" class="form-control" name="dlg_search_birthdate">
					</div>
          <div class="form-group">
						<label for="dlg_search_religionname"><?php echo $this->getCatalog('religionname')?></label>
						<input type="text" class="form-control" name="dlg_search_religionname">
					</div>
          <div class="form-group">
						<label for="dlg_search_employeestatusname"><?php echo $this->getCatalog('employeestatusname')?></label>
						<input type="text" class="form-control" name="dlg_search_employeestatusname">
					</div>
          <div class="form-group">
						<label for="dlg_search_contract"><?php echo $this->getCatalog('employeecontractend')?></label>
						<input type="text" class="form-control" name="dlg_search_contract">
					</div>
          <div class="form-group">
						<label for="dlg_search_isresign"><?php echo $this->getCatalog('isresign')?></label>
						<input type="text" class="form-control" name="dlg_search_isresign" placeholder="Type Yes for Resign / Type No for Not Resign">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
				</div>
		</div>
	</div>
</div>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employee') ?></h4>
      </div>
      <div class="modal-body">
          <ul class="nav nav-tabs">
				<li><h4><?php echo 'Data Pribadi';?></h4></li>
          </ul>
				<input type="hidden" class="form-control" name="employee_0_employeeid">
                <input type="hidden" class="form-control" name="addressbookid">
                <input type="hidden" class="form-control" name="addressid">
                <input type="hidden" class="form-control" name="companyid">
          <!--
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_companyid','ColField'=>'employee_0_companyname',
							'IDDialog'=>'employee_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'employee_0_companyidgrid')); 
					?>
        -->
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_fullname"><?php echo $this->getCatalog('fullname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_fullname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_oldnik"><?php echo $this->getCatalog('oldnik')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_oldnik">
						</div>
					</div>
														
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_sexid','ColField'=>'employee_0_sexname',
							'IDDialog'=>'employee_0_sexid_dialog','titledialog'=>$this->getCatalog('sexname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.SexPopUp','PopGrid'=>'employee_0_sexidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_birthcityid','ColField'=>'employee_0_birthcityname',
							'IDDialog'=>'employee_0_birthcityid_dialog','titledialog'=>'Kota Kelahiran','classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'employee_0_birthcityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_birthdate"><?php echo $this->getCatalog('birthdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employee_0_birthdate">
						</div>
					</div>
          
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_religionid','ColField'=>'employee_0_religionname',
							'IDDialog'=>'employee_0_religionid_dialog','titledialog'=>$this->getCatalog('religionname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.ReligionPopUp','PopGrid'=>'employee_0_religionidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_maritalstatusid','ColField'=>'employee_0_maritalstatusname',
							'IDDialog'=>'employee_0_maritalstatusid_dialog','titledialog'=>$this->getCatalog('maritalstatusname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.MaritalstatusPopUp','PopGrid'=>'employee_0_maritalstatusidgrid')); 
					?>
          
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_levelorgid','ColField'=>'employee_0_levelorgname',
							'IDDialog'=>'employee_0_levelorgid_dialog','titledialog'=>$this->getCatalog('levelorgname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.LevelorgPopUp','PopGrid'=>'employee_0_levelorgidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_positionid','ColField'=>'employee_0_positionname',
							'IDDialog'=>'employee_0_positionid_dialog','titledialog'=>$this->getCatalog('positionname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.PositionPopUp','PopGrid'=>'employee_0_positionidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_employeetypeid','ColField'=>'employee_0_employeetypename',
							'IDDialog'=>'employee_0_employeetypeid_dialog','titledialog'=>$this->getCatalog('employeetypename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeetypePopUp','PopGrid'=>'employee_0_employeetypeidgrid')); 
					?>
							
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_employeestatusid','ColField'=>'employee_0_employeestatusname',
							'IDDialog'=>'employee_0_employeestatusid_dialog','titledialog'=>$this->getCatalog('employeestatusname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeestatusPopUp','PopGrid'=>'employee_0_employeestatusidgrid')); 
					?>
          
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_email"><?php echo $this->getCatalog('email')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_email">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_phoneno"><?php echo $this->getCatalog('phoneno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_phoneno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_alternateemail"><?php echo $this->getCatalog('alternateemail')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_alternateemail">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_hpno"><?php echo $this->getCatalog('hpno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_hpno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_hpno2"><?php echo $this->getCatalog('hpno2')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_hpno2">
						</div>
					</div>
          
          <div class="row">
						<div class="col-md-4">
							<label for="employee_0_referenceby"><?php echo $this->getCatalog('referenceby')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_referenceby">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_joindate"><?php echo $this->getCatalog('joindate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employee_0_joindate">
						</div>
					</div>
          
          <div class="row">
						<div class="col-md-4">
							<label for="employee_0_istrial"><?php echo $this->getCatalog('istrial')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employee_0_istrial">
						</div>
					</div>
          <!--
          <ul class="nav nav-tabs">
				<li><h4><?php echo 'Data alamat';?></h4></li>
          </ul>
          <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_addresstypeid','ColField'=>'employee_0_addresstypename',
							'IDDialog'=>'employee_0_addresstypeid_dialog','titledialog'=>$this->getCatalog('addresstype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddresstypePopUp','PopGrid'=>'employee_0_addresstypeidgrid')); 
					?>
          
         <div class="row">
						<div class="col-md-4">
							<label for="employee_0_addressname"><?php echo $this->getCatalog('addressname')?></label>
						</div>
						<div class="col-md-8">
                            <textarea class="form-control" name="employee_0_addressname"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_rt"><?php echo $this->getCatalog('rt')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_rt">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_rw"><?php echo $this->getCatalog('rw')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_rw">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employee_0_cityid','ColField'=>'employee_0_cityname',
							'IDDialog'=>'employee_0_cityid_dialog','titledialog'=>$this->getCatalog('city'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'employee_0_cityidgrid')); 
					?>
        -->
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_barcode"><?php echo $this->getCatalog('barcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_barcode">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_photo"><?php echo $this->getCatalog('photo')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_photo" readonly>
						</div>
					</div>
							
         <script>
				function successUp(param,param2,param3)
				{
					$('input[name="employee_0_photo"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('hr/employee/upload'),
						'maxFilesize' => '2', // MB
						'mimeTypes' => array('.jpg','.png','.jpeg'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
          
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_resigndate"><?php echo $this->getCatalog('resigndate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employee_0_resigndate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_accountno"><?php echo $this->getCatalog('accountno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_accountno">
						</div>
					</div>
          
           <div class="row">
						<div class="col-md-4">
							<label for="employee_0_taxno"><?php echo $this->getCatalog('taxno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_taxno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_dplkno"><?php echo $this->getCatalog('dplkno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_dplkno">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_bpjskesno"><?php echo $this->getCatalog('bpjskesno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employee_0_bpjskesno">
						</div>
					</div>
        <!--
         <div class="row">
						<div class="col-md-4">
							<label for="employee_0_lat"><?php echo $this->getCatalog('lat')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="employee_0_lat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employee_0_lng"><?php echo $this->getCatalog('lng')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="employee_0_lng">
						</div>
					</div>
        -->
				<ul class="nav nav-tabs">
                <li><a data-toggle="tab" href="#address"><?php echo $this->getCatalog("address")?></a></li>
                <li><a data-toggle="tab" href="#employeeidentity"><?php echo $this->getCatalog("employeeidentity")?></a></li>
                <li><a data-toggle="tab" href="#employeefamily"><?php echo $this->getCatalog("employeefamily")?></a></li>
                <li><a data-toggle="tab" href="#employeeeducation"><?php echo $this->getCatalog("employeeeducation")?></a></li>
                <li><a data-toggle="tab" href="#employeeinformal"><?php echo $this->getCatalog("employeeinformal")?></a></li>
                <li><a data-toggle="tab" href="#employeewo"><?php echo $this->getCatalog("employeewo")?></a></li>
                <li><a data-toggle="tab" href="#employeecontract"><?php echo $this->getCatalog("employeecontract")?></a></li>
                <li><a data-toggle="tab" href="#employeeorgstructure"><?php echo $this->getCatalog("employeeorgstructure")?></a></li>
				</ul>
				<div class="tab-content">	
<div id="address" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonaddress" type="button" class="btn btn-primary" onclick="newdataaddress()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonaddress" type="button" class="btn btn-danger" onclick="purgedataaddress()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddress,
		'id'=>'addressList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataaddress($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                
            
			                 array(
					'header'=>$this->getCatalog('addressid'),
					'name'=>'addressid',
					'value'=>'$data["addressid"]'
				),
			                 array(
					'header'=>$this->getCatalog('addresstype'),
					'name'=>'addresstypeid',
					'value'=>'$data["addresstypename"]'
				),
							array(
					'header'=>$this->getCatalog('addressname'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('rt'),
					'name'=>'rt',
					'value'=>'$data["rt"]'
				),
							array(
					'header'=>$this->getCatalog('rw'),
					'name'=>'rw',
					'value'=>'$data["rw"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('lat'),
					'name'=>'lat',
					'value'=>'$data["lat"]'
				),
							array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
							
		)
));
?>
  </div>
<div id="employeeidentity" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeeidentity" type="button" class="btn btn-primary" onclick="newdataemployeeidentity()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeeidentity" type="button" class="btn btn-danger" onclick="purgedataemployeeidentity()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeidentity,
		'id'=>'employeeidentityList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeeidentity($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeeidentity($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

                array(
					'header'=>$this->getCatalog('employeeidentityid'),
					'name'=>'employeeidentity',
					'value'=>'$data["employeeidentityid"]'
				),
            	array(
					'header'=>$this->getCatalog('identitytype'),
					'name'=>'identitytypeid',
					'value'=>'$data["identitytypename"]'
				),
							array(
					'header'=>$this->getCatalog('identityname'),
					'name'=>'identityname',
					'value'=>'$data["identityname"]'
				),
							array(
					'header'=>$this->getCatalog('expiredate'),
					'name'=>'expiredate',
					'value'=>'Yii::app()->format->formatDate($data["expiredate"])'
				),
							array(
					'header'=>$this->getCatalog('foto'),
					'name'=>'foto',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/employee/identity/".$data["foto"],$data["foto"],
						array("width"=>"100"))'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));
?>
  </div>
<div id="employeefamily" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeefamily" type="button" class="btn btn-primary" onclick="newdataemployeefamily()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeefamily" type="button" class="btn btn-danger" onclick="purgedataemployeefamily()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeefamily,
		'id'=>'employeefamilyList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeefamily($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeefamily($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                            array(
					'header'=>$this->getCatalog('employeefamilyid'),
					'name'=>'employeefamilyid',
					'value'=>'$data["employeefamilyid"]'
				),
			                 array(
					'header'=>$this->getCatalog('familyrelation'),
					'name'=>'familyrelationid',
					'value'=>'$data["familyrelationname"]'
				),
							array(
					'header'=>$this->getCatalog('familyname'),
					'name'=>'familyname',
					'value'=>'$data["familyname"]'
				),
							array(
					'header'=>$this->getCatalog('sex'),
					'name'=>'sexid',
					'value'=>'$data["sexname"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('birthdate'),
					'name'=>'birthdate',
					'value'=>'Yii::app()->format->formatDate($data["birthdate"])'
				),
							array(
					'header'=>$this->getCatalog('education'),
					'name'=>'educationid',
					'value'=>'$data["educationname"]'
				),
							array(
					'header'=>$this->getCatalog('occupation'),
					'name'=>'occupationid',
					'value'=>'$data["occupationname"]'
				),
                            array(
					'header'=>$this->getCatalog('bpjskesno'),
					'name'=>'bpjskesno',
					'value'=>'$data["bpjskesno"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));
?>
  </div>
<div id="employeeeducation" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeeeducation" type="button" class="btn btn-primary" onclick="newdataemployeeeducation()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeeeducation" type="button" class="btn btn-danger" onclick="purgedataemployeeeducation()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeeducation,
		'id'=>'employeeeducationList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeeeducation($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeeeducation($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                            array(
					'header'=>$this->getCatalog('employeeeducationid'),
					'name'=>'employeeeducationid',
					'value'=>'$data["employeeeducationid"]'
				),
			                 array(
					'header'=>$this->getCatalog('education'),
					'name'=>'educationid',
					'value'=>'$data["educationname"]'
				),
							array(
					'header'=>$this->getCatalog('schoolname'),
					'name'=>'schoolname',
					'value'=>'$data["schoolname"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('yeargraduate'),
					'name'=>'yeargraduate',
					'value'=>'Yii::app()->format->formatDate($data["yeargraduate"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdiploma',
					'header'=>$this->getCatalog('isdiploma'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdiploma"]',
				),
							array(
					'header'=>$this->getCatalog('schooldegree'),
					'name'=>'schooldegree',
					'value'=>'$data["schooldegree"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/education/".$data["attach"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));
?>
  </div>
<div id="employeeinformal" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeeinformal" type="button" class="btn btn-primary" onclick="newdataemployeeinformal()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeeinformal" type="button" class="btn btn-danger" onclick="purgedataemployeeinformal()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeinformal,
		'id'=>'employeeinformalList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeeinformal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeeinformal($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                            array(
					'header'=>$this->getCatalog('employeeinformalid'),
					'name'=>'employeeinformalid',
					'value'=>'$data["employeeinformalid"]'
				),
			                 array(
					'header'=>$this->getCatalog('informalname'),
					'name'=>'informalname',
					'value'=>'$data["informalname"]'
				),
							array(
					'header'=>$this->getCatalog('organizer'),
					'name'=>'organizer',
					'value'=>'$data["organizer"]'
				),
							array(
					'header'=>$this->getCatalog('period'),
					'name'=>'period',
					'value'=>'$data["period"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdiploma',
					'header'=>$this->getCatalog('isdiploma'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdiploma"]',
				),
							array(
					'header'=>$this->getCatalog('sponsoredby'),
					'name'=>'sponsoredby',
					'value'=>'$data["sponsoredby"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/informal/".$data["attach"])'
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));
?>
  </div>
<div id="employeewo" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeewo" type="button" class="btn btn-primary" onclick="newdataemployeewo()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeewo" type="button" class="btn btn-danger" onclick="purgedataemployeewo()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeewo,
		'id'=>'employeewoList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeewo($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeewo($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

                             array(
					'header'=>$this->getCatalog('employeewoid'),
					'name'=>'employeewoid',
					'value'=>'$data["employeewoid"]'
				),                 
                            array(
					'header'=>$this->getCatalog('employer'),
					'name'=>'employer',
					'value'=>'$data["employer"]'
				),
							array(
					'header'=>$this->getCatalog('address'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('telp'),
					'name'=>'telp',
					'value'=>'$data["telp"]'
				),
                            array(
					'header'=>$this->getCatalog('firstposition'),
					'name'=>'firstposition',
					'value'=>'$data["firstposition"]'
				),
                            array(
					'header'=>$this->getCatalog('lastposition'),
					'name'=>'lastposition',
					'value'=>'$data["lastposition"]'
				),
                            array(
					'header'=>$this->getCatalog('startperiod'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
                            array(
					'header'=>$this->getCatalog('endperiod'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
                            array(
					'header'=>$this->getCatalog('spvemployer'),
					'name'=>'spvname',
					'value'=>'$data["spvname"]'
				),
                            array(
					'header'=>$this->getCatalog('spvposition'),
					'name'=>'spvposition',
					'value'=>'$data["spvposition"]'
				),
                            array(
					'header'=>$this->getCatalog('spvphone'),
					'name'=>'spvphone',
					'value'=>'$data["spvphone"]'
				),
                            array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'$data["payamount"]'
				),
                            array(
					'header'=>$this->getCatalog('reasonleave'),
					'name'=>'reasonleave',
					'value'=>'$data["reasonleave"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/wo/".$data["attach"])'
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));
?>
  </div>
    <div id="employeecontract" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeecontract" type="button" class="btn btn-primary" onclick="newdataemployeecontract()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeecontract" type="button" class="btn btn-danger" onclick="purgedataemployeecontract()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeecontract,
		'id'=>'employeecontractList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeecontract($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeecontract($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                
            
			                 array(
					'header'=>$this->getCatalog('contractid'),
					'name'=>'contractid',
					'value'=>'$data["contractid"]'
				),
							array(
					'header'=>$this->getCatalog('contracttype'),
					'name'=>'contracttype',
					'value'=>'$data["contracttype"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/contract/".$data["attach"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),			
		)
));
?>
  </div>
<div id="employeeorgstructure" class="tab-pane">
	<?php if ($this->checkAccess('employee','iswrite')) { ?>
<button name="CreateButtonemployeeorgstructure" type="button" class="btn btn-primary" onclick="newdataemployeeorgstructure()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<!--
<?php if ($this->checkAccess('employee','ispurge')) { ?>
<button name="PurgeButtonemployeeorgstructure" type="button" class="btn btn-danger" onclick="purgedataemployeeorgstructure()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
-->
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeorgstruc,
		'id'=>'employeeorgstructureList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('employee','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataemployeeorgstructure($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'true',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataemployeeorgstructure($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
                
            
			                 array(
					'header'=>$this->getCatalog('employeeorgstrucid'),
					'name'=>'employeeorgstrucid',
					'value'=>'$data["employeeorgstrucid"]'
				),
							array(
					'header'=>$this->getCatalog('structurename'),
					'name'=>'orgstructureid',
					'value'=>'$data["structurename"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyname',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/orgstruc/".$data["attach"])'
				),
						array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),			
		)
));
?>
  </div>
</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
				<div class="modal-body">
			<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('address')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideraddress,
		'id'=>'DetailaddressList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('addresstype'),
					'name'=>'addresstypeid',
					'value'=>'$data["addresstypename"]'
				),
							array(
					'header'=>$this->getCatalog('addressname'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('rt'),
					'name'=>'rt',
					'value'=>'$data["rt"]'
				),
							array(
					'header'=>$this->getCatalog('rw'),
					'name'=>'rw',
					'value'=>'$data["rw"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('lat'),
					'name'=>'lat',
					'value'=>'$data["lat"]'
				),
							array(
					'header'=>$this->getCatalog('lng'),
					'name'=>'lng',
					'value'=>'$data["lng"]'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeeidentity')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeidentity,
		'id'=>'DetailemployeeidentityList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
            	array(
					'header'=>$this->getCatalog('identitytype'),
					'name'=>'identitytypeid',
					'value'=>'$data["identitytypename"]'
				),
							array(
					'header'=>$this->getCatalog('identityname'),
					'name'=>'identityname',
					'value'=>'$data["identityname"]'
				),
							array(
					'header'=>$this->getCatalog('expiredate'),
					'name'=>'expiredate',
					'value'=>'Yii::app()->format->formatDate($data["expiredate"])'
				),
							array(
					'header'=>$this->getCatalog('foto'),
					'name'=>'foto',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/employee/identity/".$data["foto"],$data["foto"],
						array("width"=>"100"))'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeefamily')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeefamily,
		'id'=>'DetailemployeefamilyList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('familyrelation'),
					'name'=>'familyrelationid',
					'value'=>'$data["familyrelationname"]'
				),
							array(
					'header'=>$this->getCatalog('familyname'),
					'name'=>'familyname',
					'value'=>'$data["familyname"]'
				),
							array(
					'header'=>$this->getCatalog('sex'),
					'name'=>'sexid',
					'value'=>'$data["sexname"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('birthdate'),
					'name'=>'birthdate',
					'value'=>'Yii::app()->format->formatDate($data["birthdate"])'
				),
							array(
					'header'=>$this->getCatalog('education'),
					'name'=>'educationid',
					'value'=>'$data["educationname"]'
				),
							array(
					'header'=>$this->getCatalog('occupation'),
					'name'=>'occupationid',
					'value'=>'$data["occupationname"]'
				),
                            array(
					'header'=>$this->getCatalog('bpjskesno'),
					'name'=>'bpjskesno',
					'value'=>'$data["bpjskesno"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeeeducation')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeeducation,
		'id'=>'DetailemployeeeducationList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('education'),
					'name'=>'educationid',
					'value'=>'$data["educationname"]'
				),
							array(
					'header'=>$this->getCatalog('schoolname'),
					'name'=>'schoolname',
					'value'=>'$data["schoolname"]'
				),
							array(
					'header'=>$this->getCatalog('city'),
					'name'=>'cityid',
					'value'=>'$data["cityname"]'
				),
							array(
					'header'=>$this->getCatalog('yeargraduate'),
					'name'=>'yeargraduate',
					'value'=>'Yii::app()->format->formatDate($data["yeargraduate"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdiploma',
					'header'=>$this->getCatalog('isdiploma'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdiploma"]',
				),
							array(
					'header'=>$this->getCatalog('schooldegree'),
					'name'=>'schooldegree',
					'value'=>'$data["schooldegree"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/education/".$data["attach"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeeinformal')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeinformal,
		'id'=>'DetailemployeeinformalList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('informalname'),
					'name'=>'informalname',
					'value'=>'$data["informalname"]'
				),
							array(
					'header'=>$this->getCatalog('organizer'),
					'name'=>'organizer',
					'value'=>'$data["organizer"]'
				),
							array(
					'header'=>$this->getCatalog('period'),
					'name'=>'period',
					'value'=>'$data["period"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdiploma',
					'header'=>$this->getCatalog('isdiploma'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdiploma"]',
				),
							array(
					'header'=>$this->getCatalog('sponsoredby'),
					'name'=>'sponsoredby',
					'value'=>'$data["sponsoredby"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/informal/".$data["attach"])'
				),
							
		)
));?>
		</div>		
		</div>		
				<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeewo')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeewo,
		'id'=>'DetailemployeewoList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('employer'),
					'name'=>'employer',
					'value'=>'$data["employer"]'
				),
							array(
					'header'=>$this->getCatalog('address'),
					'name'=>'addressname',
					'value'=>'$data["addressname"]'
				),
							array(
					'header'=>$this->getCatalog('telp'),
					'name'=>'telp',
					'value'=>'$data["telp"]'
				),
							array(
					'header'=>$this->getCatalog('firstposition'),
					'name'=>'firstposition',
					'value'=>'$data["firstposition"]'
				),
                            array(
					'header'=>$this->getCatalog('lastposition'),
					'name'=>'lastposition',
					'value'=>'$data["lastposition"]'
				),
                            array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
                            array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
                            array(
					'header'=>$this->getCatalog('spvempname'),
					'name'=>'spvname',
					'value'=>'$data["spvname"]'
				),
                            array(
					'header'=>$this->getCatalog('spvposition'),
					'name'=>'spvposition',
					'value'=>'$data["spvposition"]'
				),
                            array(
					'header'=>$this->getCatalog('spvphone'),
					'name'=>'spvphone',
					'value'=>'$data["spvphone"]'
				),
                            array(
					'header'=>$this->getCatalog('payamount'),
					'name'=>'payamount',
					'value'=>'$data["payamount"]'
				),
                            array(
					'header'=>$this->getCatalog('reasonleave'),
					'name'=>'reasonleave',
					'value'=>'$data["reasonleave"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/wo/".$data["attach"])'
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
							
		)
));?>
		</div>		
		</div>		
                    
        <div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeecontract')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeecontract,
		'id'=>'DetailemployeecontractList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('contractid'),
					'name'=>'contractid',
					'value'=>'$data["contractid"]'
				),
							array(
					'header'=>$this->getCatalog('contracttype'),
					'name'=>'contracttype',
					'value'=>'$data["contracttype"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/contract/".$data["attach"])'
				),
								array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
                ),
							
		)
));?>
		</div>		
		</div>
                    
                    <div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('employeeorgstructure')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideremployeeorgstruc,
		'id'=>'DetailemployeeorgstructureList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
							array(
					'header'=>$this->getCatalog('employeeorgstrucid'),
					'name'=>'employeeorgstrucid',
					'value'=>'$data["employeeorgstrucid"]'
				),
							array(
					'header'=>$this->getCatalog('structurename'),
					'name'=>'orgstructureid',
					'value'=>'$data["structurename"]'
				),
							array(
					'header'=>$this->getCatalog('department'),
					'name'=>'department',
					'value'=>'$data["department"]'
				),
							array(
					'header'=>$this->getCatalog('divisi'),
					'name'=>'divisi',
					'value'=>'$data["divisi"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyname',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'$data["startdate"]'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'$data["enddate"]'
				),
							array(
					'header'=>$this->getCatalog('attach'),
					'name'=>'attach',
					'type'=>'raw',
					'value'=>'CHtml::link($data["attach"],Yii::app()->baseUrl."/images/employee/orgstruc/".$data["attach"])'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
        		),
							
		)
));?>
		</div>		
		</div>
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogaddress" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('address') ?></h4>
      </div>
			<div class="modal-body">
			<!--<input type="hidden" class="form-control" name="address_1_addresstypeid">-->
			<input type="hidden" class="form-control" name="address_1_addressid">
                <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'address_1_addresstypeid','ColField'=>'address_1_addresstypename',
							'IDDialog'=>'employee_0_addresstypeid_dialog','titledialog'=>$this->getCatalog('addresstype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddresstypePopUp','PopGrid'=>'employee_0_addresstypeidgrid')); 
					?>
                
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_addressname"><?php echo $this->getCatalog('addressname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_addressname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_rt"><?php echo $this->getCatalog('rt')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_rt">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_rw"><?php echo $this->getCatalog('rw')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="address_1_rw">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'address_1_cityid','ColField'=>'address_1_cityname',
							'IDDialog'=>'address_1_cityid_dialog','titledialog'=>$this->getCatalog('city'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'address_1_cityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_lat"><?php echo $this->getCatalog('lat')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="address_1_lat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="address_1_lng"><?php echo $this->getCatalog('lng')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="address_1_lng">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataaddress()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogemployeeidentity" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeeidentity') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="employeeidentity_2_employeeidentityid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeidentity_2_identitytypeid','ColField'=>'employeeidentity_2_identitytypename',
							'IDDialog'=>'employeeidentity_2_identitytypeid_dialog','titledialog'=>$this->getCatalog('identitytype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.IdentitytypePopUp','PopGrid'=>'employeeidentity_2_identitytypeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeidentity_2_identityname"><?php echo $this->getCatalog('identityname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeidentity_2_identityname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeidentity_2_expiredate"><?php echo $this->getCatalog('expiredate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeeidentity_2_expiredate">
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp2(param,param2,param3)
							{
								$('input[name="employeeidentity_2_foto"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp2(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadidentity'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.jpg','.png'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="employeeidentity_2_foto"><?php echo $this->getCatalog('foto')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="employeeidentity_2_foto">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeidentity_2_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeeidentity_2_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeeidentity()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogemployeefamily" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeefamily') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="employeefamily_3_employeefamilyid">
        
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeefamily_3_familyrelationid','ColField'=>'employeefamily_3_familyrelationname',
							'IDDialog'=>'employeefamily_3_familyrelationid_dialog','titledialog'=>$this->getCatalog('familyrelation'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.FamilyrelationPopUp','PopGrid'=>'employeefamily_3_familyrelationidgrid')); 
					?>        
                <div class="row">
						<div class="col-md-4">
							<label for="employeefamily_3_familyname"><?php echo $this->getCatalog('familyname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeefamily_3_familyname">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeefamily_3_sexid','ColField'=>'employeefamily_3_sexname',
							'IDDialog'=>'employeefamily_3_sexid_dialog','titledialog'=>$this->getCatalog('sex'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.SexPopUp','PopGrid'=>'employeefamily_3_sexidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeefamily_3_cityid','ColField'=>'employeefamily_3_cityname',
							'IDDialog'=>'employeefamily_3_cityid_dialog','titledialog'=>$this->getCatalog('city'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'employeefamily_3_cityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeefamily_3_birthdate"><?php echo $this->getCatalog('birthdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeefamily_3_birthdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeefamily_3_educationid','ColField'=>'employeefamily_3_educationname',
							'IDDialog'=>'employeefamily_3_educationid_dialog','titledialog'=>$this->getCatalog('education'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EducationPopUp','PopGrid'=>'employeefamily_3_educationidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeefamily_3_occupationid','ColField'=>'employeefamily_3_occupationname',
							'IDDialog'=>'employeefamily_3_occupationid_dialog','titledialog'=>$this->getCatalog('occupation'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.OccupationPopUp','PopGrid'=>'employeefamily_3_occupationidgrid')); 
					?>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeefamily_3_bpjskesno"><?php echo $this->getCatalog('bpjskesno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeefamily_3_bpjskesno">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeefamily_3_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeefamily_3_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeefamily()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogemployeeeducation" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeeeducation') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="employeeeducation_4_employeeeducationid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeeducation_4_educationid','ColField'=>'employeeeducation_4_educationname',
							'IDDialog'=>'employeeeducation_4_educationid_dialog','titledialog'=>$this->getCatalog('education'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EducationPopUp','PopGrid'=>'employeeeducation_4_educationidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_schoolname"><?php echo $this->getCatalog('schoolname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeeducation_4_schoolname">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeeducation_4_cityid','ColField'=>'employeeeducation_4_cityname',
							'IDDialog'=>'employeeeducation_4_cityid_dialog','titledialog'=>$this->getCatalog('city'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CityPopUp','PopGrid'=>'employeeeducation_4_cityidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_yeargraduate"><?php echo $this->getCatalog('yeargraduate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeeeducation_4_yeargraduate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_isdiploma"><?php echo $this->getCatalog('isdiploma')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeeeducation_4_isdiploma">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_schooldegree"><?php echo $this->getCatalog('schooldegree')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeeducation_4_schooldegree">
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp4(param,param2,param3)
							{
								$('input[name="employeeeducation_4_attach"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp4(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadeducation'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.pdf'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_attach"><?php echo $this->getCatalog('attach')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="employeeeducation_4_attach">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeeducation_4_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeeeducation_4_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeeeducation()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogemployeeinformal" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeeinformal') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="employeeinformal_5_employeeinformalid">
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_informalname"><?php echo $this->getCatalog('informalname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeinformal_5_informalname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_organizer"><?php echo $this->getCatalog('organizer')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeinformal_5_organizer">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_period"><?php echo $this->getCatalog('period')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeinformal_5_period">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_isdiploma"><?php echo $this->getCatalog('isdiploma')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeeinformal_5_isdiploma">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_sponsoredby"><?php echo $this->getCatalog('sponsoredby')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeeinformal_5_sponsoredby">
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp5(param,param2,param3)
							{
								$('input[name="employeeinformal_5_attach"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp5(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadinformal'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.pdf'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_attach"><?php echo $this->getCatalog('attach')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="employeeinformal_5_attach">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeeinformal_5_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeeinformal_5_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeeinformal()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			<div id="InputDialogemployeewo" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeewo') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="employeewo_6_employeewoid">
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_employer"><?php echo $this->getCatalog('employer')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_employer">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_addressname"><?php echo $this->getCatalog('address')?></label>
						</div>
						<div class="col-md-8">
                            <textarea  class="form-control" name="employeewo_6_addressname"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_telp"><?php echo $this->getCatalog('telp')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_telp">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_firstposition"><?php echo $this->getCatalog('firstposition')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_firstposition">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_lastposition"><?php echo $this->getCatalog('lastposition')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_lastposition">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeewo_6_startdate">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeewo_6_enddate">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_spvname"><?php echo $this->getCatalog('spvempname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_spvname">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_spvposition"><?php echo $this->getCatalog('spvposition')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_spvposition">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_spvphone"><?php echo $this->getCatalog('spvphone')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeewo_6_spvphone">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_payamount"><?php echo $this->getCatalog('payamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="employeewo_6_payamount">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_reasonleave"><?php echo $this->getCatalog('reasonleave')?></label>
						</div>
						<div class="col-md-8">
                            <textarea class="form-control" name="employeewo_6_reasonleave"></textarea>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp6(param,param2,param3)
							{
								$('input[name="employeewo_6_attach"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp6(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadwo'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.pdf'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_attach"><?php echo $this->getCatalog('attach')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="employeewo_6_attach">
						</div>
					</div>
                
        <div class="row">
						<div class="col-md-4">
							<label for="employeewo_6_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeewo_6_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeewo()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>

            <div id="InputDialogemployeecontract" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeecontract') ?></h4>
      </div>
			<div class="modal-body">
			<!--<input type="hidden" class="form-control" name="address_1_addresstypeid">-->
			<input type="hidden" class="form-control" name="employeecontract_7_contractid">
               <!--
                <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeecontract_7_employeeid','ColField'=>'employeecontract_7_fullname',
							'IDDialog'=>'employeecontract_7_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'employeecontract_7_employeegrid')); 
					?>
                -->
        <div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_contracttype"><?php echo $this->getCatalog('contracttype')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeecontract_7_contracttype">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeecontract_7_startdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="employeecontract_7_enddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeecontract_7_description">
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp7(param,param2,param3)
							{
								$('input[name="employeecontract_7_attach"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp7(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadcontract'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.pdf'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_attach"><?php echo $this->getCatalog('attach')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="employeecontract_7_attach">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="employeecontract_7_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeecontract_7_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeecontract()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>

<div id="InputDialogemployeeorgstructure" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('employeeorgstructure') ?></h4>
      </div>
			<div class="modal-body">
			<!--<input type="hidden" class="form-control" name="address_1_addresstypeid">-->
			<input type="hidden" class="form-control" name="orgstructure_8_employeeorgstrucid">
                <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'orgstructure_8_orgstructureid','ColField'=>'orgstructure_8_structurename',
							'IDDialog'=>'orgstructure_8_orgstructureid_dialog','titledialog'=>$this->getCatalog('structurename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.OrgstructurePopUp','PopGrid'=>'orgstructure_8_orgstructureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_8_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="orgstructure_8_startdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_8_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="orgstructure_8_enddate">
						</div>
					</div>

		<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<script>
							function successUp8(param,param2,param3)
							{
								$('input[name="orgstructure_8_attach"]').val(param2);
							}
							</script>
							<?php
								$events = array(
									'success' => 'successUp8(param,param2,param3)',
								);
								$this->widget('ext.dropzone.EDropzone', array(
								    'name'=>'upload',
								    'url' => Yii::app()->createUrl('hr/employee/uploadorgstruc'),
										'maxFilesize' => '2', // MB
								    'mimeTypes' => array('.pdf'),		
									'events' => $events,
									'options' => CMap::mergeArray($this->options, $this->dict ),
	    							'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
								));
							?>
						</div>
					</div>

		<div class="row">
						<div class="col-md-4">
							<label for="orgstructure_8_attach"><?php echo $this->getCatalog('attach')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" readonly name="orgstructure_8_attach">
						</div>
					</div>

        <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_8_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="orgstructure_8_recordstatus">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataemployeeorgstructure()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			