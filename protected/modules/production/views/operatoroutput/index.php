<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='operatoroutput_0_operatoroutputid']").val(data.operatoroutputid);
			$("input[name='operatoroutput_0_opoutputdate']").val(data.opoutputdate);
      $("input[name='operatoroutput_0_companyid']").val('');
      $("input[name='operatoroutput_0_slocid']").val('');
      $("input[name='operatoroutput_0_recordstatus']").val(data.recordstatus);
      $("input[name='operatoroutput_0_companyname']").val('');
      $("input[name='operatoroutput_0_sloccode']").val('');
			$.fn.yiiGridView.update('operatoroutputdetList',{data:{'operatoroutputid':data.operatoroutputid}});

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
function newdataoperatoroutputdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/createoperatoroutputdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='operatoroutputdet_1_operatoroutputdetid']").val('');
      $("input[name='operatoroutputdet_1_employeeid']").val('');
      $("input[name='operatoroutputdet_1_standardopoutputid']").val('');
      $("input[name='operatoroutputdet_1_qty']").val(data.qty);
      $("input[name='operatoroutputdet_1_fullname']").val('');
			$('#InputDialogoperatoroutputdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='operatoroutput_0_operatoroutputid']").val(data.operatoroutputid);
				$("input[name='operatoroutput_0_opoutputdate']").val(data.opoutputdate);
      $("input[name='operatoroutput_0_companyid']").val(data.companyid);
      $("input[name='operatoroutput_0_slocid']").val(data.slocid);
      $("input[name='operatoroutput_0_recordstatus']").val(data.recordstatus);
      $("input[name='operatoroutput_0_companyname']").val(data.companyname);
      $("input[name='operatoroutput_0_sloccode']").val(data.sloccode);
				$.fn.yiiGridView.update('operatoroutputdetList',{data:{'operatoroutputid':data.operatoroutputid}});

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
function updatedataoperatoroutputdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/updateoperatoroutputdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='operatoroutputdet_1_operatoroutputdetid']").val(data.operatoroutputdetid);
      $("input[name='operatoroutputdet_1_employeeid']").val(data.employeeid);
      $("input[name='operatoroutputdet_1_standardopoutputid']").val(data.standardopoutputid);
      $("input[name='operatoroutputdet_1_qty']").val(data.qty);
      $("input[name='operatoroutputdet_1_fullname']").val(data.fullname);
			$('#InputDialogoperatoroutputdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/save')?>',
		'data':{
			'operatoroutputid':$("input[name='operatoroutput_0_operatoroutputid']").val(),
			'opoutputdate':$("input[name='operatoroutput_0_opoutputdate']").val(),
      'companyid':$("input[name='operatoroutput_0_companyid']").val(),
      'slocid':$("input[name='operatoroutput_0_slocid']").val(),
      'recordstatus':$("input[name='operatoroutput_0_recordstatus']").val(),
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

function savedataoperatoroutputdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/saveoperatoroutputdet')?>',
		'data':{
			'operatoroutputid':$("input[name='operatoroutput_0_operatoroutputid']").val(),
			'operatoroutputdetid':$("input[name='operatoroutputdet_1_operatoroutputdetid']").val(),
      'employeeid':$("input[name='operatoroutputdet_1_employeeid']").val(),
      'standardopoutputid':$("input[name='operatoroutputdet_1_standardopoutputid']").val(),
      'qty':$("input[name='operatoroutputdet_1_qty']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogoperatoroutputdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("operatoroutputdetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/purge')?>','data':{'id':$id},
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
function purgedataoperatoroutputdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/operatoroutput/purgeoperatoroutputdet')?>','data':{'id':$.fn.yiiGridView.getSelection("operatoroutputdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("operatoroutputdetList");
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
	var array = 'operatoroutput_0_operatoroutputid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'operatoroutput_0_operatoroutputid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/operatoroutput/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'operatoroutput_0_operatoroutputid='+$id
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/operatoroutput/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'operatoroutputid='+$id
$.fn.yiiGridView.update("DetailoperatoroutputdetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('operatoroutput') ?></h3>
<?php if ($this->checkAccess('operatoroutput','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('operatoroutput','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('operatoroutput','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('operatoroutput','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('operatoroutput','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('operatoroutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('operatoroutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('operatoroutput','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('operatoroutputid'),
					'name'=>'operatoroutputid',
					'value'=>'$data["operatoroutputid"]'
				),
							array(
					'header'=>$this->getCatalog('opoutputdate'),
					'name'=>'opoutputdate',
					'value'=>'Yii::app()->format->formatDate($data["opoutputdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyname',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'sloccode',
					'value'=>'$data["sloccode"]'
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
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_slocid"><?php echo $this->getCatalog('slocid')?></label>
						<input type="text" class="form-control" name="dlg_search_slocid">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('operatoroutput') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="operatoroutput_0_operatoroutputid">
        <div class="row">
						<div class="col-md-4">
							<label for="operatoroutput_0_opoutputdate"><?php echo $this->getCatalog('opoutputdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="operatoroutput_0_opoutputdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'operatoroutput_0_companyid','ColField'=>'operatoroutput_0_companyname',
							'IDDialog'=>'operatoroutput_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'operatoroutput_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'operatoroutput_0_slocid','ColField'=>'operatoroutput_0_sloccode',
							'IDDialog'=>'operatoroutput_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'operatoroutput_0_companyid',
							'PopUpName'=>'common.components.views.SloccomPopUp','PopGrid'=>'operatoroutput_0_slocidgrid')); 
					?>
							<input type="hidden" class="form-control" name="operatoroutput_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#operatoroutputdet"><?php echo $this->getCatalog("operatoroutputdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="operatoroutputdet" class="tab-pane">
	<?php if ($this->checkAccess('operatoroutput','iswrite')) { ?>
<button name="CreateButtonoperatoroutputdet" type="button" class="btn btn-primary" onclick="newdataoperatoroutputdet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('operatoroutput','ispurge')) { ?>
<button name="PurgeButtonoperatoroutputdet" type="button" class="btn btn-danger" onclick="purgedataoperatoroutputdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideroperatoroutputdet,
		'id'=>'operatoroutputdetList',
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
							'visible'=>$this->booltostr($this->checkAccess('operatoroutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataoperatoroutputdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('operatoroutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataoperatoroutputdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('operatoroutputdetid'),
					'name'=>'operatoroutputdetid',
					'value'=>'$data["operatoroutputdetid"]'
				),
							array(
					'header'=>$this->getCatalog('operator'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupname',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('operatoroutputdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvideroperatoroutputdet,
		'id'=>'DetailoperatoroutputdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('operatoroutputdetid'),
					'name'=>'operatoroutputdetid',
					'value'=>'$data["operatoroutputdetid"]'
				),
							array(
					'header'=>$this->getCatalog('operator'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupname',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogoperatoroutputdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('operatoroutputdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="operatoroutputdet_1_operatoroutputdetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'operatoroutputdet_1_employeeid','ColField'=>'operatoroutputdet_1_fullname',
							'IDDialog'=>'operatoroutputdet_1_employeeid_dialog','titledialog'=>$this->getCatalog('operator'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'operatoroutputdet_1_employeeidgrid')); 
					?>
							
       <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'operatoroutputdet_1_standardopoutputid','ColField'=>'operatoroutputdet_1_groupname',
							'IDDialog'=>'operatoroutputdet_1_standardopoutputid_dialog','titledialog'=>$this->getCatalog('standardopoutput'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',							'PopUpName'=>'production.components.views.OpoutputPopUp','PopGrid'=>'operatoroutputdet_1_standardopoutputidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="operatoroutputdet_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="operatoroutputdet_1_qty">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataoperatoroutputdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			