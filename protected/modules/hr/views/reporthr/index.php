<script type="text/javascript">
function downpdfreporthr() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
    $employeeid = $("input[name='employeeid']").val();
	
    if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
    if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
    if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listreporthr']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&employeeid='+$("input[name='employeeid']").val()
+ '&religionid='+$("input[name='religionid']").val()
+ '&employeetypeid='+$("input[name='employeetypeid']").val()
+ '&empplanid='+$("input[name='empplanid']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('hr/reporthr/downpdf')?>?'+array);
	}
};


function downxlsreporthr() {
	$companyid = $("input[name='companyid']").val();
	$startdate = $("input[name='startdate']").val();
	$enddate = $("input[name='enddate']").val();
    $employeeid = $("input[name='employeeid']").val();
	if ($companyid == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptycompany')?>');
	}
	else
		if ($startdate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptystartdate')?>');
	}
	else
		if ($enddate == "")
	{
		toastr.error('<?php echo $this->getCatalog('emptyenddate')?>');
	}
	else
	{
	var array = 'lro='+$("select[name='listreporthr']").val()
+ '&company='+$("input[name='companyid']").val()
+ '&employeeid='+$("input[name='employeeid']").val()
+ '&religionid='+$("input[name='religionid']").val()
+ '&employeetypeid='+$("input[name='employeetypeid']").val()
+ '&empplanid='+$("input[name='empplanid']").val()
+ '&startdate='+$("input[name='startdate']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('hr/reporthr/downxls')?>?'+array);
	}
};




 
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('reporthr') ?></h3>
<div class="row">
	<div class="col-md-4">
		<label for="listreporthr"><?php echo $this->getCatalog('reporttype')?></label>
	</div>
	<div class="col-md-8">
		<select class="form-control" name="listreporthr" >
		<option value="1">(1).Laporan Evaluasi Karyawan</option>
		<option value="2">(2).Rekap Laporan Evaluasi Karyawan Per Dokumen</option>
		<option value="3">(3).Laporan Kontrak Yang Sudah di Perpanjang</option>
		<option value="4">(4).Laporan Kontrak Yang Akan Berakhir</option>
		<option value="5">(5).Laporan Kejadian Karyawan</option>
		<option value="6">(6).Rekap Data Karyawan</option>
        <option value="7">(7).Rekap Jenis Karyawan</option>
        <option value="8">(8).Rekap THR Karyawan</option>
        <option value="9">(9).Rekap Ulang Tahun Karyawan</option>
        <option value="10">(10).Rincian Struktur Karyawan</option>
		</select>
	</div>
</div>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
					?>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'employeename',
							'IDDialog'=>'employeeid_dialog','titledialog'=>$this->getCatalog('employee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'employeeid',
							'PopUpName'=>'hr.components.views.EmployeelevelPopUp','PopGrid'=>'employeeidgrid')); 
					?>
            <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'religionid','ColField'=>'employee_0_religionname',
							'IDDialog'=>'employee_0_religionid_dialog','titledialog'=>$this->getCatalog('religionname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.ReligionPopUp','PopGrid'=>'employee_0_religionidgrid')); 
					?>

             <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeetypeid','ColField'=>'employee_0_employeetypename',
							'IDDialog'=>'employee_0_employeetypeid_dialog','titledialog'=>$this->getCatalog('employeetypename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeetypePopUp','PopGrid'=>'employee_0_employeetypeidgrid')); 
					?>
             <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'empplanid','ColField'=>'empplanname',
							'IDDialog'=>'empplanid_dialog','titledialog'=>$this->getCatalog('empplanname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'empplanid',
							'PopUpName'=>'hr.components.views.EmployeePlanUserPopUp','PopGrid'=>'empplanidgrid')); 
					?>       
<div class="row">
<div class="col-md-4">
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-8">
		<input type="date" class="form-control" name="startdate" />s/d<input type="date" class="form-control" name="enddate" />
                <br>
              
                
                <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="downpdfreporthr()"><?php echo $this->getCatalog('downpdf')?></a></li>
                        <li><a onclick="downxlsreporthr()"><?php echo $this->getCatalog('downxls')?></a></li>
                    </ul>
  </div>
                
               
                