<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='spletter_0_spletterid']").val(data.spletterid);
			$("input[name='spletter_0_employeeid']").val('');
      $("input[name='spletter_0_splettertypeid']").val('');
      $("input[name='spletter_0_spletterdate']").val(data.date);
      $("input[name='spletter_0_description']").val('');
      $("input[name='spletter_0_recordstatus']").val(data.recordstatus);
      $("input[name='spletter_0_fullname']").val('');
      $("input[name='spletter_0_splettername']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='spletter_0_spletterid']").val(data.spletterid);
				$("input[name='spletter_0_employeeid']").val(data.employeeid);
      $("input[name='spletter_0_splettertypeid']").val(data.splettertypeid);
      $("input[name='spletter_0_spletterdate']").val(data.date);
      $("input[name='spletter_0_description']").val(data.description);
      $("input[name='spletter_0_recordstatus']").val(data.recordstatus);
      $("input[name='spletter_0_fullname']").val(data.fullname);
      $("input[name='spletter_0_splettername']").val(data.splettername);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/save')?>',
		'data':{
			'spletterid':$("input[name='spletter_0_spletterid']").val(),
			'employeeid':$("input[name='spletter_0_employeeid']").val(),
      'splettertypeid':$("input[name='spletter_0_splettertypeid']").val(),
      'date':$("input[name='spletter_0_spletterdate']").val(),
      'description':$("input[name='spletter_0_description']").val(),
      'recordstatus':$("input[name='spletter_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/spletter/purge')?>','data':{'id':$id},
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
	var array = 'spletter_0_spletterid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&splettername='+$("input[name='dlg_search_splettername']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'spletter_0_spletterid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&splettername='+$("input[name='dlg_search_splettername']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/spletter/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'spletter_0_spletterid='+$id
+ '&fullname='+$("input[name='dlg_search_fullname']").val()
+ '&splettername='+$("input[name='dlg_search_splettername']").val()
+ '&description='+$("input[name='dlg_search_description']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/spletter/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'spletterid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('spletter') ?></h3>
<?php if ($this->checkAccess('spletter','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('spletter','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('spletter','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('spletter','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('spletter','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('spletter','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('spletter','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('spletter','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('spletter','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('spletterid'),
					'name'=>'spletterid',
					'value'=>'$data["spletterid"]'
				),
							array(
					'header'=>$this->getCatalog('spletterno'),
					'name'=>'spletterno',
					'value'=>'$data["spletterno"]'
				),
                            array(
					'header'=>$this->getCatalog('fullname'),
					'name'=>'employeeid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('splettername'),
					'name'=>'splettertypeid',
					'value'=>'$data["splettername"]'
				),
							array(
					'header'=>$this->getCatalog('date'),
					'name'=>'date',
					'value'=>'Yii::app()->format->formatDate($data["date"])'
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_splettername"><?php echo $this->getCatalog('splettername')?></label>
						<input type="text" class="form-control" name="dlg_search_splettername">
					</div>
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
        <h4 class="modal-title"><?php echo $this->getCatalog('spletter') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="spletter_0_spletterid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'spletter_0_employeeid','ColField'=>'spletter_0_fullname',
							'IDDialog'=>'spletter_0_employeeid_dialog','titledialog'=>$this->getCatalog('fullname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeePopUp','PopGrid'=>'spletter_0_employeeidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'spletter_0_splettertypeid','ColField'=>'spletter_0_splettername',
							'IDDialog'=>'spletter_0_splettertypeid_dialog','titledialog'=>$this->getCatalog('splettername'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.SpletterPopUp','PopGrid'=>'spletter_0_splettertypeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="spletter_0_spletterdate"><?php echo $this->getCatalog('date')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="spletter_0_spletterdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="spletter_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="spletter_0_description">
						</div>
					</div>
							<input type="hidden" class="form-control" name="spletter_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


