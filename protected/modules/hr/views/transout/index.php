<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transout_0_transoutid']").val(data.transoutid);
			$("input[name='transout_0_docdate']").val(data.docdate);
      $("input[name='transout_0_employeeid']").val('');
      $("input[name='transout_0_permitexitid']").val('');
      $("input[name='transout_0_startdate']").val(data.startdate);
      $("input[name='transout_0_enddate']").val(data.enddate);
      $("input[name='transout_0_description']").val('');
      $("input[name='transout_0_recordstatus']").val(data.recordstatus);
      $("input[name='transout_0_fullname']").val('');
      $("input[name='transout_0_permitexitname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transout_0_transoutid']").val(data.transoutid);
				$("input[name='transout_0_docdate']").val(data.docdate);
      $("input[name='transout_0_employeeid']").val(data.employeeid);
      $("input[name='transout_0_permitexitid']").val(data.permitexitid);
      $("input[name='transout_0_startdate']").val(data.startdate);
      $("input[name='transout_0_enddate']").val(data.enddate);
      $("input[name='transout_0_description']").val(data.description);
      $("input[name='transout_0_recordstatus']").val(data.recordstatus);
      $("input[name='transout_0_fullname']").val(data.fullname);
      $("input[name='transout_0_permitexitname']").val(data.permitexitname);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/save')?>',
		'data':{
			'transoutid':$("input[name='transout_0_transoutid']").val(),
			'docdate':$("input[name='transout_0_docdate']").val(),
      'employeeid':$("input[name='transout_0_employeeid']").val(),
      'permitexitid':$("input[name='transout_0_permitexitid']").val(),
      'startdate':$("input[name='transout_0_startdate']").val(),
      'enddate':$("input[name='transout_0_enddate']").val(),
      'description':$("input[name='transout_0_description']").val(),
      'recordstatus':$("input[name='transout_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/transout/purge')?>','data':{'id':$id},
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
	var array = 'transout_0_transoutid='+$id
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'transout_0_transoutid='+$id
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/transout/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'transout_0_transoutid='+$id
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/transout/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'transoutid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('transout') ?></h3>
<?php if ($this->checkAccess('transout','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('transout','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('transout','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('transout','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('transout','isdownload')) { ?>
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
				'template'=>'{edit} {delete} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('transout','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('transout','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('transout','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('transout','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('transoutid'),
					'name'=>'transoutid',
					'value'=>'$data["transoutid"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('permitexitname'),
					'name'=>'permitexitid',
					'value'=>'$data["permitexitname"]'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDateTime($data["startdate"])'
				),
							array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'Yii::app()->format->formatDateTime($data["enddate"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'recordstatus',
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
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('transout') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="transout_0_transoutid">
        <div class="row">
						<div class="col-md-4">
							<label for="transout_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="transout_0_docdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transout_0_employeeid','ColField'=>'transout_0_fullname',
							'IDDialog'=>'transout_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'transout_0_employeeidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transout_0_permitexitid','ColField'=>'transout_0_permitexitname',
							'IDDialog'=>'transout_0_permitexitid_dialog','titledialog'=>$this->getCatalog('permitexitname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.PermitoutPopUp','PopGrid'=>'transout_0_permitexitidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transout_0_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="datetime-local" class="form-control" name="transout_0_startdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transout_0_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="datetime-local" class="form-control" name="transout_0_enddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transout_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="transout_0_description">
						</div>
					</div>
							<input type="hidden" class="form-control" name="transout_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


