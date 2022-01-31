<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='employeetype_0_employeetypeid']").val(data.employeetypeid);
			$("input[name='employeetype_0_employeetypename']").val('');
      $("input[name='employeetype_0_snroid']").val('');
      $("input[name='employeetype_0_sicksnroid']").val('');
      $("input[name='employeetype_0_sickstatusid']").val('');
      $("input[name='employeetype_0_recordstatus']").val(data.recordstatus);
      $("input[name='employeetype_0_description']").val('');
      $("input[name='employeetype_0_sicksnro']").val('');
      $("input[name='employeetype_0_sickstatus']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='employeetype_0_employeetypeid']").val(data.employeetypeid);
				$("input[name='employeetype_0_employeetypename']").val(data.employeetypename);
                $("input[name='employeetype_0_snroid']").val(data.snroid);
                $("input[name='employeetype_0_sicksnroid']").val(data.sicksnroid);
                $("input[name='employeetype_0_sickstatusid']").val(data.sickstatusid);
                //$("input[name='employeetype_0_recordstatus']").val(data.recordstatus);
                if (data.recordstatus == 1){
				    $("input[name='employeetype_0_recordstatus']").prop('checked',true);
                }
                else{
				    $("input[name='employeetype_0_recordstatus']").prop('checked',false);
                }
                $("input[name='employeetype_0_description']").val(data.description);
                $("input[name='employeetype_0_sicksnro']").val(data.sicksnro);
                $("input[name='employeetype_0_sickstatus']").val(data.sickstatus);
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
    if ($("input[name='employeetype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/save')?>',
		'data':{
			'employeetypeid':$("input[name='employeetype_0_employeetypeid']").val(),
			'employeetypename':$("input[name='employeetype_0_employeetypename']").val(),
      'snroid':$("input[name='employeetype_0_snroid']").val(),
      'sicksnroid':$("input[name='employeetype_0_sicksnroid']").val(),
      'sickstatusid':$("input[name='employeetype_0_sickstatusid']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/employeetype/purge')?>','data':{'id':$id},
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
	var array = 'employeetype_0_employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/employeetype/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'employeetypeid='+$id
+ '&employeetypename='+$("input[name='dlg_search_employeetypename']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/employeetype/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'employeetypeid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('employeetype') ?></h3>
<?php if ($this->checkAccess('employeetype','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('employeetype','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('employeetype','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('employeetype','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('employeetype','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('employeetype','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('employeetype','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('employeetype','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('employeetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('employeetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('employeetypeid'),
					'name'=>'employeetypeid',
					'value'=>'$data["employeetypeid"]'
				),
							array(
					'header'=>$this->getCatalog('employeetypename'),
					'name'=>'employeetypename',
					'value'=>'$data["employeetypename"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'snroid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('sicksnro'),
					'name'=>'sicksnroid',
					'value'=>'$data["sicksnro"]'
				),
							array(
					'header'=>$this->getCatalog('sickstatus'),
					'name'=>'sickstatusid',
					'value'=>'$data["sickstatus"]'
				),
							  array(
					'class'=>'CCheckBoxColumn',
                    'header'=>$this->getCatalog('recordstatus'),
					'name'=>'recordstatus',
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]'),
							
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
						<label for="dlg_search_employeetypename"><?php echo $this->getCatalog('employeetypename')?></label>
						<input type="text" class="form-control" name="dlg_search_employeetypename">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('employeetype') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="employeetype_0_employeetypeid">
        <div class="row">
						<div class="col-md-4">
							<label for="employeetype_0_employeetypename"><?php echo $this->getCatalog('employeetypename')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="employeetype_0_employeetypename">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeetype_0_snroid','ColField'=>'employeetype_0_description',
							'IDDialog'=>'employeetype_0_snroid_dialog','titledialog'=>$this->getCatalog('description'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.SnroPopUp','PopGrid'=>'employeetype_0_snroidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeetype_0_sicksnroid','ColField'=>'employeetype_0_sicksnro',
							'IDDialog'=>'employeetype_0_sicksnroid_dialog','titledialog'=>$this->getCatalog('sicksnro'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.SnroPopUp','PopGrid'=>'employeetype_0_sicksnroidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'employeetype_0_sickstatusid','ColField'=>'employeetype_0_sickstatus',
							'IDDialog'=>'employeetype_0_sickstatusid_dialog','titledialog'=>$this->getCatalog('sickstatus'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.AbsstatusPopUp','PopGrid'=>'employeetype_0_sickstatusidgrid')); 
					?>
				    <div class="row">
						<div class="col-md-4">
							<label for="employeetype_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="employeetype_0_recordstatus">
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


