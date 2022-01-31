<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='wagetype_0_wagetypeid']").val(data.wagetypeid);
			$("input[name='wagetype_0_wagename']").val('');
      $("input[name='wagetype_0_ispph']").prop('checked',true);
      $("input[name='wagetype_0_ispayroll']").prop('checked',true);
      $("input[name='wagetype_0_isprint']").prop('checked',true);
      $("input[name='wagetype_0_percentage']").val(data.percentage);
      $("input[name='wagetype_0_maxvalue']").val(data.maxvalue);
      $("input[name='wagetype_0_currencyid']").val(data.currencyid);
      $("input[name='wagetype_0_isrutin']").prop('checked',true);
      $("input[name='wagetype_0_paidbycompany']").prop('checked',true);
      $("input[name='wagetype_0_pphbycompany']").prop('checked',true);
      $("input[name='wagetype_0_recordstatus']").val(data.recordstatus);
      $("input[name='wagetype_0_currencyname']").val(data.currencyname);
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='wagetype_0_wagetypeid']").val(data.wagetypeid);
				$("input[name='wagetype_0_wagename']").val(data.wagename);
      if (data.ispph == 1)
			{
				$("input[name='wagetype_0_ispph']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_ispph']").prop('checked',false)
			}
      if (data.ispayroll == 1)
			{
				$("input[name='wagetype_0_ispayroll']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_ispayroll']").prop('checked',false)
			}
      if (data.isprint == 1)
			{
				$("input[name='wagetype_0_isprint']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_isprint']").prop('checked',false)
			}
      $("input[name='wagetype_0_percentage']").val(data.percentage);
      $("input[name='wagetype_0_maxvalue']").val(data.maxvalue);
      $("input[name='wagetype_0_currencyid']").val(data.currencyid);
      if (data.isrutin == 1)
			{
				$("input[name='wagetype_0_isrutin']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_isrutin']").prop('checked',false)
			}
      if (data.paidbycompany == 1)
			{
				$("input[name='wagetype_0_paidbycompany']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_paidbycompany']").prop('checked',false)
			}
      if (data.pphbycompany == 1)
			{
				$("input[name='wagetype_0_pphbycompany']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_pphbycompany']").prop('checked',false)
			}
      if (data.recordstatus == 1)
			{
				$("input[name='wagetype_0_recordstatus']").prop('checked',true);
			}
			else
			{
				$("input[name='wagetype_0_recordstatus']").prop('checked',false)
			}
      $("input[name='wagetype_0_currencyname']").val(data.currencyname);
				
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
var ispph = 0;
	if ($("input[name='wagetype_0_ispph']").prop('checked'))
	{
		ispph = 1;
	}
	else
	{
		ispph = 0;
	}
var ispayroll = 0;
	if ($("input[name='wagetype_0_ispayroll']").prop('checked'))
	{
		ispayroll = 1;
	}
	else
	{
		ispayroll = 0;
	}
var isprint = 0;
	if ($("input[name='wagetype_0_isprint']").prop('checked'))
	{
		isprint = 1;
	}
	else
	{
		isprint = 0;
	}
var isrutin = 0;
	if ($("input[name='wagetype_0_isrutin']").prop('checked'))
	{
		isrutin = 1;
	}
	else
	{
		isrutin = 0;
	}
var paidbycompany = 0;
	if ($("input[name='wagetype_0_paidbycompany']").prop('checked'))
	{
		paidbycompany = 1;
	}
	else
	{
		paidbycompany = 0;
	}
var pphbycompany = 0;
	if ($("input[name='wagetype_0_pphbycompany']").prop('checked'))
	{
		pphbycompany = 1;
	}
	else
	{
		pphbycompany = 0;
	}
    var recordstatus = 0;
	if ($("input[name='wagetype_0_recordstatus']").prop('checked'))
	{
		recordstatus = 1;
	}
	else
	{
		recordstatus = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/save')?>',
		'data':{
			'wagetypeid':$("input[name='wagetype_0_wagetypeid']").val(),
			'wagename':$("input[name='wagetype_0_wagename']").val(),
      'ispph':ispph,
      'ispayroll':ispayroll,
      'isprint':isprint,
      'percentage':$("input[name='wagetype_0_percentage']").val(),
      'maxvalue':$("input[name='wagetype_0_maxvalue']").val(),
      'currencyid':$("input[name='wagetype_0_currencyid']").val(),
      'isrutin':isrutin,
      'paidbycompany':paidbycompany,
      'pphbycompany':pphbycompany,
      'recordstatus':recordstatus,
        //'recordstatus':$("input[name='wagetype_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/wagetype/purge')?>','data':{'id':$id},
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
	var array = 'wagetype_0_wagetypeid='+$id
+ '&wagename='+$("input[name='dlg_search_wagename']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'wagetypeid='+$id
+ '&wagename='+$("input[name='dlg_search_wagename']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('hr/wagetype/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'wagetypeid='+$id
+ '&wagename='+$("input[name='dlg_search_wagename']").val()
+ '&currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('hr/wagetype/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'wagetypeid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('wagetype') ?></h3>
<?php if ($this->checkAccess('wagetype','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('wagetype','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('wagetype','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('wagetype','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('wagetype','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('wagetype','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() {updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('wagetype','isreject')),							
							'url'=>'"#"',
							'click'=>"function() {deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('wagetype','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() {purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('wagetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() {downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('wagetype','isdownload')),
							'url'=>'"#"',
							'click'=>"function() {downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('wagetypeid'),
					'name'=>'wagetypeid',
					'value'=>'$data["wagetypeid"]'
				),
							array(
					'header'=>$this->getCatalog('wagename'),
					'name'=>'wagename',
					'value'=>'$data["wagename"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'ispph',
					'header'=>$this->getCatalog('ispph'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispph"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'ispayroll',
					'header'=>$this->getCatalog('ispayroll'),
					'selectableRows'=>'0',
					'checked'=>'$data["ispayroll"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isprint',
					'header'=>$this->getCatalog('isprint'),
					'selectableRows'=>'0',
					'checked'=>'$data["isprint"]',
				),array(
					'header'=>$this->getCatalog('percentage'),
					'name'=>'percentage',
					'value'=>'Yii::app()->format->formatNumber($data["percentage"])'
				),
							array(
					'header'=>$this->getCatalog('maxvalue'),
					'name'=>'maxvalue',
					'value'=>'Yii::app()->format->formatNumber($data["maxvalue"])'
				),
							array(
					'header'=>$this->getCatalog('currencyname'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isrutin',
					'header'=>$this->getCatalog('isrutin'),
					'selectableRows'=>'0',
					'checked'=>'$data["isrutin"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'paidbycompany',
					'header'=>$this->getCatalog('paidbycompany'),
					'selectableRows'=>'0',
					'checked'=>'$data["paidbycompany"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'pphbycompany',
					'header'=>$this->getCatalog('pphbycompany'),
					'selectableRows'=>'0',
					'checked'=>'$data["pphbycompany"]',
				),array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',),
            /*array(
					'header'=>$this->getCatalog('recordstatus'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
				),*/
							
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
						<label for="dlg_search_wagename"><?php echo $this->getCatalog('wagename')?></label>
						<input type="text" class="form-control" name="dlg_search_wagename">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('wagetype') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="wagetype_0_wagetypeid">
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_wagename"><?php echo $this->getCatalog('wagename')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="wagetype_0_wagename">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_ispph"><?php echo $this->getCatalog('ispph')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_ispph">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_ispayroll"><?php echo $this->getCatalog('ispayroll')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_ispayroll">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_isprint"><?php echo $this->getCatalog('isprint')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_isprint">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_percentage"><?php echo $this->getCatalog('percentage')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="wagetype_0_percentage">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_maxvalue"><?php echo $this->getCatalog('maxvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="wagetype_0_maxvalue">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'wagetype_0_currencyid','ColField'=>'wagetype_0_currencyname',
							'IDDialog'=>'wagetype_0_currencyid_dialog','titledialog'=>$this->getCatalog('currencyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'wagetype_0_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_isrutin"><?php echo $this->getCatalog('isrutin')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_isrutin">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_paidbycompany"><?php echo $this->getCatalog('paidbycompany')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_paidbycompany">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_pphbycompany"><?php echo $this->getCatalog('pphbycompany')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_pphbycompany">
						</div>
					</div>
							<div class="row">
						<div class="col-md-4">
							<label for="wagetype_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="wagetype_0_recordstatus">
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


