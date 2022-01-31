<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='absstatus_0_absstatusid']").val(data.absstatusid);
			$("input[name='absstatus_0_shortstat']").val('');
            $("input[name='absstatus_0_longstat']").val('');
            $("input[name='absstatus_0_isin']").prop('checked',true);
            $("input[name='absstatus_0_priority']").prop('checked',true);
            $("input[name='absstatus_0_recordstatus']").val(data.recordstatus);
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='absstatus_0_absstatusid']").val(data.absstatusid);
				$("input[name='absstatus_0_shortstat']").val(data.shortstat);
                $("input[name='absstatus_0_longstat']").val(data.longstat);
                if (data.isin == 1)
                {
				    $("input[name='absstatus_0_isin']").prop('checked',true);
                }
                else
                {
				    $("input[name='absstatus_0_isin']").prop('checked',false)
                }
                if (data.priority == 1)
                {
				    $("input[name='absstatus_0_priority']").prop('checked',true);
                }
                else
                {
				    $("input[name='absstatus_0_priority']").prop('checked',false)
                }
                if (data.recordstatus == 1){
				    $("input[name='absstatus_0_recordstatus']").prop('checked',true);
                }
                else{
				    $("input[name='absstatus_0_recordstatus']").prop('checked',false);
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
    var isin = 0;
	if ($("input[name='absstatus_0_isin']").prop('checked'))
	{
		isin = 1;
	}
	else
	{
		isin = 0;
	}
    var priority = 0;
	if ($("input[name='absstatus_0_priority']").prop('checked'))
	{
		priority = 1;
	}
	else
	{
		priority = 0;
	}
    
    var recordstatus = 0;
	if ($("input[name='absstatus_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/save')?>',
		'data':{
			'absstatusid':$("input[name='absstatus_0_absstatusid']").val(),
			'shortstat':$("input[name='absstatus_0_shortstat']").val(),
            'longstat':$("input[name='absstatus_0_longstat']").val(),
            'isin':isin,
            'priority':priority,
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/absstatus/purge')?>','data':{'id':$id},
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
	var array = 'absstatus_0_absstatusid='+$id
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'absstatusid='+$id
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/absstatus/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'absstatusid='+$id
+ '&shortstat='+$("input[name='dlg_search_shortstat']").val()
+ '&longstat='+$("input[name='dlg_search_longstat']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/absstatus/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'absstatusid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('absstatus') ?></h3>
<?php if ($this->checkAccess('absstatus','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('absstatus','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('absstatus','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('absstatus','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('absstatus','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('absstatus','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('absstatus','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('absstatus','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('absstatus','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('absstatus','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('absstatusid'),
					'name'=>'absstatusid',
					'value'=>'$data["absstatusid"]'
				),
							array(
					'header'=>$this->getCatalog('shortstat'),
					'name'=>'shortstat',
					'value'=>'$data["shortstat"]'
				),
							array(
					'header'=>$this->getCatalog('longstat'),
					'name'=>'longstat',
					'value'=>'$data["longstat"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isin',
					'header'=>$this->getCatalog('isin'),
					'selectableRows'=>'0',
					'checked'=>'$data["isin"]',
				),
                            array(
					'class'=>'CCheckBoxColumn',
					'name'=>'priority',
					'header'=>$this->getCatalog('priority'),
					'selectableRows'=>'0',
					'checked'=>'$data["priority"]',
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
						<label for="dlg_search_shortstat"><?php echo $this->getCatalog('shortstat')?></label>
						<input type="text" class="form-control" name="dlg_search_shortstat">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('absstatus') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="absstatus_0_absstatusid">
        <div class="row">
						<div class="col-md-4">
							<label for="absstatus_0_shortstat"><?php echo $this->getCatalog('shortstat')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="absstatus_0_shortstat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absstatus_0_longstat"><?php echo $this->getCatalog('longstat')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="absstatus_0_longstat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absstatus_0_isin"><?php echo $this->getCatalog('isin')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="absstatus_0_isin">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="absstatus_0_priority"><?php echo $this->getCatalog('priority')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="absstatus_0_priority">
						</div>
					</div>
							<div class="row">
						<div class="col-md-4">
							<label for="absstatus_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="absstatus_0_recordstatus">
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


