<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/snro/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='snroid']").val(data.snroid);
				$("input[name='description']").val('');
			    $("input[name='formatdoc']").val('');
			    $("input[name='formatno']").val('');
			    $("input[name='repeatby']").val('');
			    $("input[name='recordstatus']").prop('checked',true);
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/snro/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='snroid']").val(data.snroid);
				$("input[name='description']").val(data.description);
			    $("input[name='formatdoc']").val(data.formatdoc);
			    $("input[name='formatno']").val(data.formatno);
			    $("input[name='repeatby']").val(data.repeatby);
		    	if (data.recordstatus == 1)
				{
					$("input[name='recordstatus']").prop('checked',true);
				}
				else
				{
					$("input[name='recordstatus']").prop('checked',false)
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
var recordstatus = 0;
	if ($("input[name='recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/snro/save')?>',
		'data':{
			'snroid':$("input[name='snroid']").val(),
			'description':$("input[name='description']").val(),
		    'formatdoc':$("input[name='formatdoc']").val(),
		    'formatno':$("input[name='formatno']").val(),
		    'repeatby':$("input[name='repeatby']").val(),
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

function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/snro/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('admin/snro/purge')?>','data':{'id':$id},
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
		'snroid':$id,
		'description':$("input[name='dlg_search_description']").val(),
		'formatdoc':$("input[name='dlg_search_formatdoc']").val(),
		'formatno':$("input[name='dlg_search_formatno']").val(),
		'repeatby':$("input[name='dlg_search_repeatby']").val()
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'snroid='+$id
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&formatdoc='+$("input[name='dlg_search_formatdoc']").val()
	+ '&formatno='+$("input[name='dlg_search_formatno']").val()
	+ '&repeatby='+$("input[name='dlg_search_repeatby']").val();
	window.open('<?php echo Yii::app()->createUrl('Admin/snro/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'snroid='+$id
	+ '&description='+$("input[name='dlg_search_description']").val()
	+ '&formatdoc='+$("input[name='dlg_search_formatdoc']").val()
	+ '&formatno='+$("input[name='dlg_search_formatno']").val()
	+ '&repeatby='+$("input[name='dlg_search_repeatby']").val();
	window.open('<?php echo Yii::app()->createUrl('Admin/snro/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'snroid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('snro') ?></h3>
<?php if ($this->checkAccess('snro','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('snro','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('snro','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('snro','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('snro','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('snro','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('snro','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('snro','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('snro','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('snroid'),
					'name'=>'snroid',
					'value'=>'$data["snroid"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('formatdoc'),
					'name'=>'formatdoc',
					'value'=>'$data["formatdoc"]'
				),
							array(
					'header'=>$this->getCatalog('formatno'),
					'name'=>'formatno',
					'value'=>'$data["formatno"]'
				),
							array(
					'header'=>$this->getCatalog('repeatby'),
					'name'=>'repeatby',
					'value'=>'$data["repeatby"]'
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
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
					</div>
          <div class="form-group">
						<label for="dlg_search_formatdoc"><?php echo $this->getCatalog('formatdoc')?></label>
						<input type="text" class="form-control" name="dlg_search_formatdoc">
					</div>
          <div class="form-group">
						<label for="dlg_search_formatno"><?php echo $this->getCatalog('formatno')?></label>
						<input type="text" class="form-control" name="dlg_search_formatno">
					</div>
          <div class="form-group">
						<label for="dlg_search_repeatby"><?php echo $this->getCatalog('repeatby')?></label>
						<input type="text" class="form-control" name="dlg_search_repeatby">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('snro') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="actiontype">
<input type="hidden" class="form-control" name="snroid">					
        <div class="row">
						<div class="col-md-4">
							<label for="description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="description">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="formatdoc"><?php echo $this->getCatalog('formatdoc')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="formatdoc">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="formatno"><?php echo $this->getCatalog('formatno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="formatno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="repeatby"><?php echo $this->getCatalog('repeatby')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="repeatby">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="recordstatus">
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


