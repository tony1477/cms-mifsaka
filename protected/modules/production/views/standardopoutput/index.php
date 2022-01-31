<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/standardopoutput/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='standardopoutput_0_standardopoutputid']").val(data.standardopoutputid);
			$("input[name='standardopoutput_0_slocid']").val('');
      $("input[name='standardopoutput_0_groupname']").val('');
      $("input[name='standardopoutput_0_standardvalue']").val(data.standardvalue);
      $("input[name='standardopoutput_0_recordstatus']").prop('checked',true);
      $("input[name='standardopoutput_0_sloccode']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/standardopoutput/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='standardopoutput_0_standardopoutputid']").val(data.standardopoutputid);
				$("input[name='standardopoutput_0_slocid']").val(data.slocid);
      $("input[name='standardopoutput_0_groupname']").val(data.groupname);
      $("input[name='standardopoutput_0_standardvalue']").val(data.standardvalue);
      if (data.recordstatus == 1)
			{
				$("input[name='standardopoutput_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='standardopoutput_0_recordstatus']").prop('checked',false)
			}
      $("input[name='standardopoutput_0_sloccode']").val(data.sloccode);
				
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
	if ($("input[name='standardopoutput_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/standardopoutput/save')?>',
		'data':{
			'standardopoutputid':$("input[name='standardopoutput_0_standardopoutputid']").val(),
			'slocid':$("input[name='standardopoutput_0_slocid']").val(),
      'groupname':$("input[name='standardopoutput_0_groupname']").val(),
      'standardvalue':$("input[name='standardopoutput_0_standardvalue']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('production/standardopoutput/purge')?>','data':{'id':$id},
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
	var array = 'standardopoutput_0_standardopoutputid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'standardopoutput_0_standardopoutputid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/standardopoutput/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'standardopoutput_0_standardopoutputid='+$id
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&groupname='+$("input[name='dlg_search_groupname']").val();
	window.open('<?php echo Yii::app()->createUrl('Production/standardopoutput/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'standardopoutputid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('standardopoutput') ?></h3>
<?php if ($this->checkAccess('standardopoutput','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>


<?php if ($this->checkAccess('standardopoutput','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('standardopoutput','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('standardopoutput','iswrite')),							
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
							'visible'=>$this->booltostr($this->checkAccess('standardopoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('standardopoutput','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('standardopoutput','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('standardopoutputid'),
					'name'=>'standardopoutputid',
					'value'=>'$data["standardopoutputid"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('groupname'),
					'name'=>'groupname',
					'value'=>'$data["groupname"]'
				),
							array(
					'header'=>$this->getCatalog('standardvalue'),
					'name'=>'standardvalue',
					'value'=>'Yii::app()->format->formatNumber($data["standardvalue"])'
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_groupname"><?php echo $this->getCatalog('groupname')?></label>
						<input type="text" class="form-control" name="dlg_search_groupname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('standardopoutput') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="standardopoutput_0_standardopoutputid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'standardopoutput_0_slocid','ColField'=>'standardopoutput_0_sloccode',
							'IDDialog'=>'standardopoutput_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocUserPopUp','PopGrid'=>'standardopoutput_0_slocidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="standardopoutput_0_groupname"><?php echo $this->getCatalog('groupname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="standardopoutput_0_groupname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="standardopoutput_0_standardvalue"><?php echo $this->getCatalog('standardvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="standardopoutput_0_standardvalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="standardopoutput_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="standardopoutput_0_recordstatus">
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


