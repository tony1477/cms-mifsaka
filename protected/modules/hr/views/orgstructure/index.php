<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='orgstructure_0_orgstructureid']").val(data.orgstructureid);
			$("input[name='orgstructure_0_companyid']").val('');
            $("input[name='orgstructure_0_structurename']").val('');
            $("input[name='orgstructure_0_parentid']").val('');
            $("input[name='orgstructure_0_recordstatus']").val(data.recordstatus);
            $("input[name='orgstructure_0_companyname']").val('');
            $("input[name='orgstructure_0_structurename']").val('');
			
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
function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='orgstructure_0_orgstructureid']").val(data.orgstructureid);
				$("input[name='orgstructure_0_companyid']").val(data.companyid);
                $("input[name='orgstructure_0_structurename']").val(data.structurename);
                $("input[name='orgstructure_0_department']").val(data.department);
                $("input[name='orgstructure_0_divisi']").val(data.divisi);
                $("input[name='orgstructure_0_parentid']").val(data.parentid);
                //$("input[name='orgstructure_0_recordstatus']").val(data.recordstatus);
                $("input[name='orgstructure_0_companyname']").val(data.companyname);
                $("input[name='orgstructure_0_parentstructure']").val(data.parentstructure);
                if (data.recordstatus == 1){
				    $("input[name='orgstructure_0_recordstatus']").prop('checked',true);
                }
                else{
				    $("input[name='orgstructure_0_recordstatus']").prop('checked',false);
                }
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
function savedata()
{
    var recordstatus = 0;
	if ($("input[name='orgstructure_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/save')?>',
		'data':{
			'orgstructureid':$("input[name='orgstructure_0_orgstructureid']").val(),
			'companyid':$("input[name='orgstructure_0_companyid']").val(),
          'structurename':$("input[name='orgstructure_0_structurename']").val(),
          'department':$("input[name='orgstructure_0_department']").val(),
          'divisi':$("input[name='orgstructure_0_divisi']").val(),
          'parentid':$("input[name='orgstructure_0_parentid']").val(),
          'recordstatus':recordstatus,
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
function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/delete')?>',
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
function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/orgstructure/purge')?>','data':{'id':$id},
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
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'orgstructure_0_orgstructureid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&structurename='+$("input[name='dlg_search_structurename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}
function downpdf($id=0)
{
	var array = 'orgstructureid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&structurename='+$("input[name='dlg_search_structurename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/orgstructure/downpdf')?>?'+array);
}
function downxls($id=0)
{
	var array = 'orgstructureid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&structurename='+$("input[name='dlg_search_structurename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/orgstructure/downxls')?>?'+array);
}
function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'orgstructureid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('orgstructure') ?></h3>
<?php if ($this->checkAccess('orgstructure','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('orgstructure','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('orgstructure','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('orgstructure','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('orgstructure','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
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
				'template'=>'{edit} {delete} {purge} {pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('orgstructure','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('orgstructure','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('orgstructure','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('orgstructure','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('orgstructure','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('orgstructureid'),
					'name'=>'orgstructureid',
					'value'=>'$data["orgstructureid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('structurename'),
					'name'=>'structurename',
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
					'header'=>$this->getCatalog('parentstructure'),
					'name'=>'parentid',
					'value'=>'$data["parentstructure"]'
				),
							 array(
					'class'=>'CCheckBoxColumn',
                    'header'=>$this->getCatalog('recordstatus'),
					'name'=>'recordsatus',
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
					<div class="form-group">
						<label for="dlg_search_structurename"><?php echo $this->getCatalog('structurename')?></label>
						<input type="text" class="form-control" name="dlg_search_structurename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('orgstructure') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="orgstructure_0_orgstructureid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'orgstructure_0_companyid','ColField'=>'orgstructure_0_companyname',
							'IDDialog'=>'orgstructure_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'orgstructure_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_0_structurename"><?php echo $this->getCatalog('structurename')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="orgstructure_0_structurename">
						</div>
					</div>
          
          <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_0_department"><?php echo $this->getCatalog('department')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="orgstructure_0_department">
						</div>
					</div>
          
          <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_0_divisi"><?php echo $this->getCatalog('divisi')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="orgstructure_0_divisi">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'orgstructure_0_parentid','ColField'=>'orgstructure_0_parentstructure',
							'IDDialog'=>'orgstructure_0_parentid_dialog','titledialog'=>$this->getCatalog('parentstructure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.OrgstructcompanyPopUp','PopGrid'=>'orgstructure_0_parentidgrid')); 
					?>
          <div class="row">
						<div class="col-md-4">
							<label for="orgstructure_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="orgstructure_0_recordstatus">
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


