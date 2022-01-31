<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='jobs_0_jobsid']").val(data.jobsid);
			$("input[name='jobs_0_orgstructureid']").val('');
            $("textarea[name='jobs_0_jobdesc']").val('');
            $("textarea[name='jobs_0_qualification']").val('');
            $("input[name='jobs_0_positionid']").val('');
            $("input[name='jobs_0_recordstatus']").val(data.recordstatus);
            $("input[name='jobs_0_structurename']").val('');
            $("input[name='jobs_0_positionname']").val('');
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='jobs_0_jobsid']").val(data.jobsid);
				$("input[name='jobs_0_orgstructureid']").val(data.orgstructureid);
                $("textarea[name='jobs_0_jobdesc']").val(data.jobdesc);
                $("textarea[name='jobs_0_qualification']").val(data.qualification);
                $("input[name='jobs_0_positionid']").val(data.positionid);
                if (data.recordstatus == 1){
				    $("input[name='jobs_0_recordstatus']").prop('checked',true);
                }
                else{
				    $("input[name='jobs_0_recordstatus']").prop('checked',false);
                }
                $("input[name='jobs_0_structurename']").val(data.structurename);
                $("input[name='jobs_0_positionname']").val(data.positionname);
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
	if ($("input[name='jobs_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/save')?>',
		'data':{
			'jobsid':$("input[name='jobs_0_jobsid']").val(),
			'orgstructureid':$("input[name='jobs_0_orgstructureid']").val(),
            'jobdesc':$("textarea[name='jobs_0_jobdesc']").val(),
            'qualification':$("textarea[name='jobs_0_qualification']").val(),
            'positionid':$("input[name='jobs_0_positionid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/jobs/purge')?>','data':{'id':$id},
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
	var array = 'jobs_0_jobsid='+$id
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&jobdesc='+$("input[name='dlg_search_jobdesc']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'jobsid='+$id
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&jobdesc='+$("input[name='dlg_search_jobdesc']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/jobs/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'jobsid='+$id
+ '&structurename='+$("input[name='dlg_search_structurename']").val()
+ '&jobdesc='+$("input[name='dlg_search_jobdesc']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/jobs/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'jobsid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('jobs') ?></h3>
<?php if ($this->checkAccess('jobs','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('jobs','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('jobs','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('jobs','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('jobs','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('jobs','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('jobs','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('jobs','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('jobs','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('jobs','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('jobsid'),
					'name'=>'jobsid',
					'value'=>'$data["jobsid"]'
				),
							array(
					'header'=>$this->getCatalog('structurename'),
					'name'=>'orgstructureid',
					'value'=>'$data["structurename"]'
				),
							array(
					'header'=>$this->getCatalog('jobdesc'),
					'name'=>'jobdesc',
					'value'=>'$data["jobdesc"]'
				),
							array(
					'header'=>$this->getCatalog('qualification'),
					'name'=>'qualification',
					'value'=>'$data["qualification"]'
				),
							array(
					'header'=>$this->getCatalog('positionname'),
					'name'=>'positionid',
					'value'=>'$data["positionname"]'
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
						<label for="dlg_search_structurename"><?php echo $this->getCatalog('structurename')?></label>
						<input type="text" class="form-control" name="dlg_search_structurename">
					</div>
          <div class="form-group">
						<label for="dlg_search_jobdesc"><?php echo $this->getCatalog('jobdesc')?></label>
						<input type="text" class="form-control" name="dlg_search_jobdesc">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('jobs') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="jobs_0_jobsid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'jobs_0_orgstructureid','ColField'=>'jobs_0_structurename',
							'IDDialog'=>'jobs_0_orgstructureid_dialog','titledialog'=>$this->getCatalog('structurename'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.OrgstructcompanyPopUp','PopGrid'=>'jobs_0_orgstructureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="jobs_0_jobdesc"><?php echo $this->getCatalog('jobdesc')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="jobs_0_jobdesc"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="jobs_0_qualification"><?php echo $this->getCatalog('qualification')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="jobs_0_qualification"></textarea>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'jobs_0_positionid','ColField'=>'jobs_0_positionname',
							'IDDialog'=>'jobs_0_positionid_dialog','titledialog'=>$this->getCatalog('positionname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.PositionPopUp','PopGrid'=>'jobs_0_positionidgrid')); 
					?>
							<div class="row">
						<div class="col-md-4">
							<label for="jobs_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="jobs_0_recordstatus">
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


