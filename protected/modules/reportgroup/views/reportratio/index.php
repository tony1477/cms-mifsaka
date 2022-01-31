<script type="text/javascript">
function downpdfratio() {
	$companyid = $("input[name='companyid']").val();
	$enddate = $("input[name='enddate']").val();
	var array = 'lro=1'
+ '&company='+$("input[name='companyid']").val()
+ '&enddate='+$("input[name='enddate']").val()
+'&per=10';
	window.open('<?php echo Yii::app()->createUrl('reportgroup/reportratio/downpdf')?>?'+array);
};
</script>
<?php if ($this->checkAccess($this->menuname,'isdownload')) { ?>
  
<?php } ?>

<h3><?php echo $this->getCatalog('groupratio') ?></h3>
			<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
							'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companyidgrid')); 
		
               ?>               
<div class="row">
<div class="col-md-4">
				<label for="startdate"><?php echo $this->getCatalog('date')?></label>
				</div>
				<div class="col-md-8">
		<input type="date" class="form-control" name="enddate" />
                <br>
              
                
                <div class="btn-group">
                <button type="button" class="btn btn-primary " onclick="downpdfratio()">
                <?php echo $this->getCatalog('download')?> </button>
                    
  </div>
                
               
                
