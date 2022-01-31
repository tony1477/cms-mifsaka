<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='abstrans_0_abstransid']").val(data.abstransid);
			$("input[name='abstrans_0_employeeid']").val('');
      $("input[name='abstrans_0_datetimeclock']").val(data.datetimeclock);
      $("input[name='abstrans_0_time']").val('');
      $("input[name='abstrans_0_reason']").val('');
      $("input[name='abstrans_0_status']").val('');
      $("input[name='abstrans_0_fullname']").val('');
      $("input[name='abstrans_0_longstat']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='abstrans_0_abstransid']").val(data.abstransid);
				$("input[name='abstrans_0_employeeid']").val(data.employeeid);
      $("input[name='abstrans_0_datetimeclock']").val(data.datetimeclock);
      $("input[name='abstrans_0_time']").val(data.time);
      $("input[name='abstrans_0_reason']").val(data.reason);
      $("input[name='abstrans_0_status']").val(data.status);
      $("input[name='abstrans_0_fullname']").val(data.fullname);
      $("input[name='abstrans_0_longstat']").val(data.longstat);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/save')?>',
		'data':{
			'abstransid':$("input[name='abstrans_0_abstransid']").val(),
			'employeeid':$("input[name='abstrans_0_employeeid']").val(),
      'datetimeclock':$("input[name='abstrans_0_datetimeclock']").val(),
      'time':$("input[name='abstrans_0_time']").val(),
      'reason':$("input[name='abstrans_0_reason']").val(),
      'status':$("input[name='abstrans_0_status']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/abstrans/purge')?>','data':{'id':$id},
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
	var array = 'abstrans_0_abstransid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&reason='+$("input[name='dlg_search_reason']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'abstransid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&reason='+$("input[name='dlg_search_reason']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/abstrans/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'abstrans_0_abstransid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&reason='+$("input[name='dlg_search_reason']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/abstrans/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'abstransid='+$id
} 
    
function running(id,param2)
{
	jQuery.ajax({'url':'abstrans/running',
		'data':{
			'id':param2,
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				location.reload();
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
</script>
<h3><?php echo $this->getCatalog('abstrans') ?></h3>
<?php if ($this->checkAccess('abstrans','isupload')) { ?>
<?php
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('hr/abstrans/uploaddata'),
    'mimeTypes' => array('.xlsx','.xls'),
		'options' => CMap::mergeArray($this->options, $this->dict ),
		'events'=> array(
			'success' => 'js:running(this,param2)'
		),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
<?php } ?>
<?php if ($this->checkAccess('abstrans','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('abstrans','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('abstrans','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('abstrans','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('abstrans','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('abstrans','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('abstrans','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('abstrans','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('abstrans','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('abstrans','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('abstransid'),
					'name'=>'abstransid',
					'value'=>'$data["abstransid"]'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('datetimeclock'),
					'name'=>'datetimeclock',
					'value'=>'Yii::app()->format->formatDateTime($data["datetimeclock"])'
				),
							array(
					'header'=>$this->getCatalog('time'),
					'name'=>'time',
					'value'=>'Yii::app()->format->formatTime($data["time"])'
				),
							array(
					'header'=>$this->getCatalog('reason'),
					'name'=>'reason',
					'value'=>'$data["reason"]'
				),
							array(
					'header'=>$this->getCatalog('stat'),
					'name'=>'status',
					'value'=>'$data["longstat"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_reason"><?php echo $this->getCatalog('reason')?></label>
						<input type="text" class="form-control" name="dlg_search_reason">
					</div>
          <div class="form-group">
						<label for="dlg_search_longstat"><?php echo $this->getCatalog('longstat')?></label>
						<input type="text" class="form-control" name="dlg_search_longstat">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('abstrans') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="abstrans_0_abstransid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'abstrans_0_employeeid','ColField'=>'abstrans_0_fullname',
							'IDDialog'=>'abstrans_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'abstrans_0_employeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="abstrans_0_datetimeclock"><?php echo $this->getCatalog('datetimeclock')?></label>
						</div>
						<div class="col-md-8">
							<input type="datetime-local" class="form-control" name="abstrans_0_datetimeclock">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="abstrans_0_reason"><?php echo $this->getCatalog('reason')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="abstrans_0_reason">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'abstrans_0_absstatus','ColField'=>'abstrans_0_status',
							'IDDialog'=>'abstrans_0_absstatus_dialog','titledialog'=>$this->getCatalog('longstat'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.AbsstatusPopUp','PopGrid'=>'abstrans_0_absstatusgrid')); 
					?>
							
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


