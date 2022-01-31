<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absschedule/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='absschedule_0_absscheduleid']").val(data.absscheduleid);
			$("input[name='absschedule_0_absschedulename']").val('');
      $("input[name='absschedule_0_absin']").val('');
      $("input[name='absschedule_0_absout']").val('');
      $("input[name='absschedule_0_absstatusid']").val('');
      $("input[name='absschedule_0_recordstatus']").prop('checked',true);
      $("input[name='absschedule_0_longstat']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absschedule/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='absschedule_0_absscheduleid']").val(data.absscheduleid);
				$("input[name='absschedule_0_absschedulename']").val(data.absschedulename);
      $("input[name='absschedule_0_absin']").val(data.absin);
      $("input[name='absschedule_0_absout']").val(data.absout);
      $("input[name='absschedule_0_absstatusid']").val(data.absstatusid);
      if (data.recordstatus == 1)
			{
				$("input[name='absschedule_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='absschedule_0_recordstatus']").prop('checked',false)
			}
      $("input[name='absschedule_0_longstat']").val(data.longstat);
				
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
	if ($("input[name='absschedule_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absschedule/save')?>',
		'data':{
			'absscheduleid':$("input[name='absschedule_0_absscheduleid']").val(),
			'absschedulename':$("input[name='absschedule_0_absschedulename']").val(),
      'absin':$("input[name='absschedule_0_absin']").val(),
      'absout':$("input[name='absschedule_0_absout']").val(),
      'absstatusid':$("input[name='absschedule_0_absstatusid']").val(),
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



function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absschedule/purge')?>','data':{'id':$id},
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
	var array = 'absschedule_0_absscheduleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'absschedule_0_absscheduleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/absschedule/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'absschedule_0_absscheduleid='+$id
+ '&absschedulename='+$("input[name='dlg_search_absschedulename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/absschedule/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'absscheduleid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('absschedule') ?></h3>
<?php if ($this->checkAccess('absschedule','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>


<?php if ($this->checkAccess('absschedule','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('absschedule','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('absschedule','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('absschedule','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('absschedule','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('absschedule','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('absscheduleid'),
					'name'=>'absscheduleid',
					'value'=>'$data["absscheduleid"]'
				),
							array(
					'header'=>$this->getCatalog('absschedulename'),
					'name'=>'absschedulename',
					'value'=>'$data["absschedulename"]'
				),
							array(
					'header'=>$this->getCatalog('absin'),
					'name'=>'absin',
					'value'=>'$data["absin"]'
				),
							array(
					'header'=>$this->getCatalog('absout'),
					'name'=>'absout',
					'value'=>'$data["absout"]'
				),
							array(
					'header'=>$this->getCatalog('longstat'),
					'name'=>'absstatusid',
					'value'=>'$data["longstat"]'
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
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_absschedulename"><?php echo $this->getCatalog('absschedulename')?></label>
						<input type="text" class="form-control" name="dlg_search_absschedulename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('absschedule') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="absschedule_0_absscheduleid">
        <div class="row">
						<div class="col-md-4">
							<label for="absschedule_0_absschedulename"><?php echo $this->getCatalog('absschedulename')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="absschedule_0_absschedulename">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absschedule_0_absin"><?php echo $this->getCatalog('absin')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="absschedule_0_absin">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absschedule_0_absout"><?php echo $this->getCatalog('absout')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="absschedule_0_absout">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'absschedule_0_absstatusid','ColField'=>'absschedule_0_longstat',
							'IDDialog'=>'absschedule_0_absstatusid_dialog','titledialog'=>$this->getCatalog('longstat'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.AbsstatusPopUp','PopGrid'=>'absschedule_0_absstatusidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absschedule_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="absschedule_0_recordstatus">
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


