<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='onleavetype_0_onleavetypeid']").val(data.onleavetypeid);
			$("input[name='onleavetype_0_onleavename']").val('');
            $("input[name='onleavetype_0_cutimax']").val('');
            $("input[name='onleavetype_0_cutistart']").val('');
            $("input[name='onleavetype_0_snroid']").val('');
            $("input[name='onleavetype_0_absstatusid']").val('');
            $("input[name='onleavetype_0_recordstatus']").val(data.recordstatus);
            $("input[name='onleavetype_0_snro']").val('');
            $("input[name='onleavetype_0_absstatus']").val('');
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='onleavetype_0_onleavetypeid']").val(data.onleavetypeid);
				$("input[name='onleavetype_0_onleavename']").val(data.onleavename);
                $("input[name='onleavetype_0_cutimax']").val(data.cutimax);
                $("input[name='onleavetype_0_cutistart']").val(data.cutistart);
                $("input[name='onleavetype_0_snroid']").val(data.snroid);
                $("input[name='onleavetype_0_absstatusid']").val(data.absstatusid);
                if (data.recordstatus == 1){
				    $("input[name='onleavetype_0_recordstatus']").prop('checked',true);
                }
                else{
				    $("input[name='onleavetype_0_recordstatus']").prop('checked',false);
                }
                $("input[name='onleavetype_0_snro']").val(data.snro);
                $("input[name='onleavetype_0_absstatus']").val(data.absstatus);
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
	if ($("input[name='onleavetype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/save')?>',
		'data':{
			'onleavetypeid':$("input[name='onleavetype_0_onleavetypeid']").val(),
			'onleavename':$("input[name='onleavetype_0_onleavename']").val(),
            'cutimax':$("input[name='onleavetype_0_cutimax']").val(),
            'cutistart':$("input[name='onleavetype_0_cutistart']").val(),
            'snroid':$("input[name='onleavetype_0_snroid']").val(),
            'absstatusid':$("input[name='onleavetype_0_absstatusid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/onleavetype/purge')?>','data':{'id':$id},
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
	var array = 'onleavetype_0_onleavetypeid='+$id
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'onleavetypeid='+$id
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/onleavetype/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'onleavetypeid='+$id
+ '&onleavename='+$("input[name='dlg_search_onleavename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/onleavetype/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'onleavetypeid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('onleavetype') ?></h3>
<?php if ($this->checkAccess('onleavetype','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('onleavetype','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('onleavetype','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('onleavetype','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('onleavetype','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('onleavetype','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('onleavetype','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('onleavetype','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('onleavetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('onleavetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('onleavetypeid'),
					'name'=>'onleavetypeid',
					'value'=>'$data["onleavetypeid"]'
				),
							array(
					'header'=>$this->getCatalog('onleavename'),
					'name'=>'onleavename',
					'value'=>'$data["onleavename"]'
				),
							array(
					'header'=>$this->getCatalog('cutimax'),
					'name'=>'cutimax',
					'value'=>'$data["cutimax"]'
				),
							array(
					'header'=>$this->getCatalog('cutistart'),
					'name'=>'cutistart',
					'value'=>'$data["cutistart"]'
				),
							array(
					'header'=>$this->getCatalog('snro'),
					'name'=>'snroid',
					'value'=>'$data["snro"]'
				),
							array(
					'header'=>$this->getCatalog('absstatus'),
					'name'=>'absstatusid',
					'value'=>'$data["absstatus"]'
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
						<label for="dlg_search_onleavename"><?php echo $this->getCatalog('onleavename')?></label>
						<input type="text" class="form-control" name="dlg_search_onleavename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('onleavetype') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="onleavetype_0_onleavetypeid">
        <div class="row">
						<div class="col-md-4">
							<label for="onleavetype_0_onleavename"><?php echo $this->getCatalog('onleavename')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="onleavetype_0_onleavename">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="onleavetype_0_cutimax"><?php echo $this->getCatalog('cutimax')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="onleavetype_0_cutimax">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="onleavetype_0_cutistart"><?php echo $this->getCatalog('cutistart')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="onleavetype_0_cutistart">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'onleavetype_0_snroid','ColField'=>'onleavetype_0_snro',
							'IDDialog'=>'onleavetype_0_snroid_dialog','titledialog'=>$this->getCatalog('snro'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.SnroPopUp','PopGrid'=>'onleavetype_0_snroidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'onleavetype_0_absstatusid','ColField'=>'onleavetype_0_absstatus',
							'IDDialog'=>'onleavetype_0_absstatusid_dialog','titledialog'=>$this->getCatalog('absstatus'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.AbsstatusPopUp','PopGrid'=>'onleavetype_0_absstatusidgrid')); 
					?>
							<div class="row">
						<div class="col-md-4">
							<label for="onleavetype_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="onleavetype_0_recordstatus">
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


