<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='empplan_0_empplanid']").val(data.empplanid);
			$("input[name='empplan_0_empplanname']").val('');
      $("input[name='empplan_0_empplandate']").val(data.empplandate);
			$.fn.yiiGridView.update('empplandetailList',{data:{'empplanid':data.empplanid}});

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
function newdataempplandetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/createempplandetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='empplandetail_1_empplandetailid']").val('');
      $("input[name='empplandetail_1_employeeid']").val('');
      $("textarea[name='empplandetail_1_description']").val('');
      $("input[name='empplandetail_1_objvalue']").val(data.objvalue);
      $("input[name='empplandetail_1_startdate']").val(data.startdate);
      $("input[name='empplandetail_1_enddate']").val(data.enddate);
      $("input[name='empplandetail_1_employeename']").val('');
			$('#InputDialogempplandetail').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='empplan_0_empplanid']").val(data.empplanid);
				$("input[name='empplan_0_empplanname']").val(data.empplanname);
      $("input[name='empplan_0_empplandate']").val(data.empplandate);
				$.fn.yiiGridView.update('empplandetailList',{data:{'empplanid':data.empplanid}});

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
function updatedataempplandetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/updateempplandetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='empplandetail_1_empplandetailid']").val(data.empplandetailid);
      $("input[name='empplandetail_1_employeeid']").val(data.employeeid);
      $("textarea[name='empplandetail_1_description']").val(data.description);
      $("input[name='empplandetail_1_objvalue']").val(data.objvalue);
      $("input[name='empplandetail_1_startdate']").val(data.startdate);
      $("input[name='empplandetail_1_enddate']").val(data.enddate);
      $("input[name='empplandetail_1_employeename']").val(data.employeename);
			$('#InputDialogempplandetail').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/save')?>',
		'data':{
			'empplanid':$("input[name='empplan_0_empplanid']").val(),
			'empplanname':$("input[name='empplan_0_empplanname']").val(),
            'empplandate':$("input[name='empplan_0_empplandate']").val(),
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

function savedataempplandetail()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/saveempplandetail')?>',
		'data':{
			'empplanid':$("input[name='empplan_0_empplanid']").val(),
			'empplandetailid':$("input[name='empplandetail_1_empplandetailid']").val(),
      'employeeid':$("input[name='empplandetail_1_employeeid']").val(),
      'description':$("textarea[name='empplandetail_1_description']").val(),
      'objvalue':$("input[name='empplandetail_1_objvalue']").val(),
      'startdate':$("input[name='empplandetail_1_startdate']").val(),
      'enddate':$("input[name='empplandetail_1_enddate']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogempplandetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("empplandetailList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/purge')?>','data':{'id':$id},
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
function purgedataempplandetail()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/empplan/purgeempplandetail')?>','data':{'id':$.fn.yiiGridView.getSelection("empplandetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("empplandetailList");
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
	var array = 'empplan_0_empplanid='+$id
+ '&empplanno='+$("input[name='dlg_search_empplanno']").val()
+ '&empplanname='+$("input[name='dlg_search_empplanname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'empplan_0_empplanid='+$id
+ '&empplanno='+$("input[name='dlg_search_empplanno']").val()
+ '&empplanname='+$("input[name='dlg_search_empplanname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/empplan/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'empplan_0_empplanid='+$id
+ '&empplanno='+$("input[name='dlg_search_empplanno']").val()
+ '&empplanname='+$("input[name='dlg_search_empplanname']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/empplan/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'empplanid='+$id
$.fn.yiiGridView.update("DetailempplandetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('empplan') ?></h3>
<?php if ($this->checkAccess('empplan','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('empplan','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('empplan','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('empplan','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('empplan','isdownload')) { ?>
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
				'template'=>'{select} {edit} {purge} {pdf}',
				'htmlOptions' => array('style'=>'width:100px'),
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('detail'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'url'=>'"#"',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('empplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('empplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('empplan','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('empplanid'),
					'name'=>'empplanid',
					'value'=>'$data["empplanid"]'
				),
							array(
					'header'=>$this->getCatalog('empplanno'),
					'name'=>'empplanno',
					'value'=>'$data["empplanno"]'
				),
							array(
					'header'=>$this->getCatalog('empplanname'),
					'name'=>'empplanname',
					'value'=>'$data["empplanname"]'
				),
							array(
					'header'=>$this->getCatalog('empplandate'),
					'name'=>'empplandate',
					'value'=>'Yii::app()->format->formatDate($data["empplandate"])'
				),
							array(
					'header'=>$this->getCatalog('useraccess'),
					'name'=>'useraccess',
					'value'=>'$data["useraccess"]'
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
						<label for="dlg_search_empplanno"><?php echo $this->getCatalog('empplanno')?></label>
						<input type="text" class="form-control" name="dlg_search_empplanno">
					</div>
          <div class="form-group">
						<label for="dlg_search_empplanname"><?php echo $this->getCatalog('empplanname')?></label>
						<input type="text" class="form-control" name="dlg_search_empplanname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('empplan') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="empplan_0_empplanid">
        <div class="row">
						<div class="col-md-4">
							<label for="empplan_0_empplanname"><?php echo $this->getCatalog('empplanname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="empplan_0_empplanname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="empplan_0_empplandate"><?php echo $this->getCatalog('empplandate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="empplan_0_empplandate">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#empplandetail"><?php echo $this->getCatalog("empplandetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="empplandetail" class="tab-pane">
	<?php if ($this->checkAccess('empplan','iswrite')) { ?>
<button name="CreateButtonempplandetail" type="button" class="btn btn-primary" onclick="newdataempplandetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('empplan','isreject')) { ?>
<button name="PurgeButtonempplandetail" type="button" class="btn btn-danger" onclick="purgedataempplandetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderempplandetail,
		'id'=>'empplandetailList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {purge}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('empplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataempplandetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('empplan','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataempplandetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('empplandetailid'),
					'name'=>'empplandetailid',
					'value'=>'$data["empplandetailid"]'
				),
							array(
					'header'=>$this->getCatalog('employee'),
					'name'=>'employeeid',
					'value'=>'$data["employeename"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('objvalue'),
					'name'=>'objvalue',
					'value'=>'Yii::app()->format->formatNumber($data["objvalue"])'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDate($data["startdate"])'
				),
                        array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'Yii::app()->format->formatDate($data["enddate"])'
				),
							
		)
));
?>
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

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
				<div class="modal-body">
			<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('empplandetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderempplandetail,
		'id'=>'DetailempplandetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('empplandetailid'),
					'name'=>'empplandetailid',
					'value'=>'$data["empplandetailid"]'
				),
							array(
					'header'=>$this->getCatalog('employee'),
					'name'=>'employeeid',
					'value'=>'$data["employeename"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('objvalue'),
					'name'=>'objvalue',
					'value'=>'Yii::app()->format->formatNumber($data["objvalue"])'
				),
							array(
					'header'=>$this->getCatalog('startdate'),
					'name'=>'startdate',
					'value'=>'Yii::app()->format->formatDate($data["startdate"])'
				),  
                            array(
					'header'=>$this->getCatalog('enddate'),
					'name'=>'enddate',
					'value'=>'Yii::app()->format->formatDate($data["enddate"])'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogempplandetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('empplandetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="empplandetail_1_empplandetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'empplandetail_1_employeeid','ColField'=>'empplandetail_1_employeename',
							'IDDialog'=>'empplandetail_1_employeeid_dialog','titledialog'=>$this->getCatalog('employee'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'employeeid',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'empplandetail_1_employeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="empplandetail_1_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="empplandetail_1_description"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="empplandetail_1_objvalue"><?php echo $this->getCatalog('objvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="empplandetail_1_objvalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="empplandetail_1_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="empplandetail_1_startdate">
						</div>
					</div>
        <div class="row">
						<div class="col-md-4">
							<label for="empplandetail_1_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="empplandetail_1_enddate">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataempplandetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			