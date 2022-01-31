<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/gmerp/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='groupmenuid']").val(data.groupmenuid);
			$("input[name='groupaccessid']").val('');
      $("input[name='menuaccessid']").val('');
      $("input[name='isread']").prop('checked',true);
      $("input[name='iswrite']").prop('checked',true);
      $("input[name='ispost']").prop('checked',true);
      $("input[name='isreject']").prop('checked',true);
      $("input[name='ispurge']").prop('checked',true);
      $("input[name='isupload']").prop('checked',true);
      $("input[name='isdownload']").prop('checked',true);
      $("input[name='groupname']").val('');
      $("input[name='menuname']").val('');
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/gmerp/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='groupmenuid']").val(data.groupmenuid);
				$("input[name='groupaccessid']").val(data.groupaccessid);
      $("input[name='menuaccessid']").val(data.menuaccessid);
      if (data.isread == 1)
			{
				$("input[name='isread']").prop('checked',true);
			}
			else
			{
				$("input[name='isread']").prop('checked',false)
			}
      if (data.iswrite == 1)
			{
				$("input[name='iswrite']").prop('checked',true);
			}
			else
			{
				$("input[name='iswrite']").prop('checked',false)
			}
      if (data.ispost == 1)
			{
				$("input[name='ispost']").prop('checked',true);
			}
			else
			{
				$("input[name='ispost']").prop('checked',false)
			}
      if (data.isreject == 1)
			{
				$("input[name='isreject']").prop('checked',true);
			}
			else
			{
				$("input[name='isreject']").prop('checked',false)
			}
      if (data.ispurge == 1)
			{
				$("input[name='ispurge']").prop('checked',true);
			}
			else
			{
				$("input[name='ispurge']").prop('checked',false)
			}
      if (data.isupload == 1)
			{
				$("input[name='isupload']").prop('checked',true);
			}
			else
			{
				$("input[name='isupload']").prop('checked',false)
			}
      if (data.isdownload == 1)
			{
				$("input[name='isdownload']").prop('checked',true);
			}
			else
			{
				$("input[name='isdownload']").prop('checked',false)
			}
      $("input[name='groupname']").val(data.groupname);
      $("input[name='menuname']").val(data.menuname);
				
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
var isread = 0;
	if ($("input[name='isread']").prop('checked'))
	{
		isread = 1;
	}
	else
	{
		isread = 0;
	}
var iswrite = 0;
	if ($("input[name='iswrite']").prop('checked'))
	{
		iswrite = 1;
	}
	else
	{
		iswrite = 0;
	}
var ispost = 0;
	if ($("input[name='ispost']").prop('checked'))
	{
		ispost = 1;
	}
	else
	{
		ispost = 0;
	}
var isreject = 0;
	if ($("input[name='isreject']").prop('checked'))
	{
		isreject = 1;
	}
	else
	{
		isreject = 0;
	}
var ispurge = 0;
	if ($("input[name='ispurge']").prop('checked'))
	{
		ispurge = 1;
	}
	else
	{
		ispurge = 0;
	}
var isupload = 0;
	if ($("input[name='isupload']").prop('checked'))
	{
		isupload = 1;
	}
	else
	{
		isupload = 0;
	}
var isdownload = 0;
	if ($("input[name='isdownload']").prop('checked'))
	{
		isdownload = 1;
	}
	else
	{
		isdownload = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/gmerp/save')?>',
		'data':{
			'groupmenuid':$("input[name='groupmenuid']").val(),
			'groupaccessid':$("input[name='groupaccessid']").val(),
      'menuaccessid':$("input[name='menuaccessid']").val(),
      'isread':isread,
      'iswrite':iswrite,
      'ispost':ispost,
      'isreject':isreject,
      'ispurge':ispurge,
      'isupload':isupload,
      'isdownload':isdownload,
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

function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/gmerp/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/gmerp/purge')?>','data':{'id':$id},
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
	$.fn.yiiGridView.update("GridList",{data:{
		'groupmenuid':$id,
		'groupname':$("input[name='dlg_search_groupname']").val(),
		'menuname':$("input[name='dlg_search_menuname']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'groupmenuid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val();
	window.open('<?php echo Yii::app()->createUrl('Admin/gmerp/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'groupmenuid='+$id
+ '&groupname='+$("input[name='dlg_search_groupname']").val()
+ '&menuname='+$("input[name='dlg_search_menuname']").val();
	window.open('<?php echo Yii::app()->createUrl('Admin/gmerp/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'groupmenuid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('gmerp') ?></h3>
<?php if ($this->checkAccess('gmerp','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>


<?php if ($this->checkAccess('gmerp','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('gmerp','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('gmerp','iswrite')),
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
							'visible'=>$this->booltostr($this->checkAccess('gmerp','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('gmerp','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('gmerp','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('groupmenuid'),
					'name'=>'groupmenuid',
					'value'=>'$data["groupmenuid"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupaccessid',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('menuname'),
					'name'=>'menuaccessid',
					'value'=>'$data["menuname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isread',
					'header'=>$this->getCatalog('isread'),
					'selectableRows'=>'0',
					'checked'=>'$data["isread"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'iswrite',
					'header'=>$this->getCatalog('iswrite'),
					'selectableRows'=>'0',
					'checked'=>'$data["iswrite"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'ispost',
					'header'=>$this->getCatalog('ispost'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispost"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isreject',
					'header'=>$this->getCatalog('isreject'),
					'selectableRows'=>'0',
					'checked'=>'$data["isreject"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'ispurge',
					'header'=>$this->getCatalog('ispurge'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispurge"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isupload',
					'header'=>$this->getCatalog('isupload'),
					'selectableRows'=>'0',
					'checked'=>'$data["isupload"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isdownload',
					'header'=>$this->getCatalog('isdownload'),
					'selectableRows'=>'0',
					'checked'=>'$data["isdownload"]',
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
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
					</div>
          <div class="form-group">
						<label for="dlg_search_menuname"><?php echo $this->getCatalog('menuname')?></label>
						<input type="text" class="form-control" name="dlg_search_menuname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('gmerp') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="groupmenuid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'groupaccessid','ColField'=>'groupname',
							'IDDialog'=>'groupaccessid_dialog','titledialog'=>$this->getCatalog('groupname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.GroupaccessPopUp','PopGrid'=>'groupaccessidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'menuaccessid','ColField'=>'menuname',
							'IDDialog'=>'menuaccessid_dialog','titledialog'=>$this->getCatalog('menuname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.MenuaccessPopUp','PopGrid'=>'menuaccessidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isread"><?php echo $this->getCatalog('isread')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isread">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="iswrite"><?php echo $this->getCatalog('iswrite')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="iswrite">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ispost"><?php echo $this->getCatalog('ispost')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="ispost">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isreject"><?php echo $this->getCatalog('isreject')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isreject">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="ispurge"><?php echo $this->getCatalog('ispurge')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="ispurge">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isupload"><?php echo $this->getCatalog('isupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isupload">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="isdownload"><?php echo $this->getCatalog('isdownload')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="isdownload">
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


