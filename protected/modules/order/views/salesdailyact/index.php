<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesdailyact_0_salesdailyactid']").val(data.salesdailyactid);
			$("input[name='salesdailyact_0_companyid']").val('');
      $("input[name='salesdailyact_0_employeeid']").val('');
      $("input[name='salesdailyact_0_dailydatetime']").val('');
      $("input[name='salesdailyact_0_dailypic']").val('');
      $("input[name='salesdailyact_0_description']").val('');
      $("input[name='salesdailyact_0_dailylat']").val('');
      $("input[name='salesdailyact_0_dailylng']").val('');
      $("input[name='salesdailyact_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesdailyact_0_companyname']").val('');
      $("input[name='salesdailyact_0_salesname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salesdailyact_0_salesdailyactid']").val(data.salesdailyactid);
				$("input[name='salesdailyact_0_companyid']").val(data.companyid);
      $("input[name='salesdailyact_0_employeeid']").val(data.employeeid);
      $("input[name='salesdailyact_0_dailydatetime']").val(data.dailydatetime);
      $("input[name='salesdailyact_0_dailypic']").val(data.dailypic);
      $("input[name='salesdailyact_0_description']").val(data.description);
      $("input[name='salesdailyact_0_dailylat']").val(data.dailylat);
      $("input[name='salesdailyact_0_dailylng']").val(data.dailylng);
      $("input[name='salesdailyact_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesdailyact_0_companyname']").val(data.companyname);
      $("input[name='salesdailyact_0_salesname']").val(data.salesname);
				
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/save')?>',
		'data':{
			'salesdailyactid':$("input[name='salesdailyact_0_salesdailyactid']").val(),
			'companyid':$("input[name='salesdailyact_0_companyid']").val(),
      'employeeid':$("input[name='salesdailyact_0_employeeid']").val(),
      'dailydatetime':$("input[name='salesdailyact_0_dailydatetime']").val(),
      'dailypic':$("input[name='salesdailyact_0_dailypic']").val(),
      'description':$("input[name='salesdailyact_0_description']").val(),
      'dailylat':$("input[name='salesdailyact_0_dailylat']").val(),
      'dailylng':$("input[name='salesdailyact_0_dailylng']").val(),
      'recordstatus':$("input[name='salesdailyact_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesdailyact/purge')?>','data':{'id':$id},
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
	var array = 'salesdailyact_0_salesdailyactid='+$id
+ '&salesdailyno='+$("input[name='dlg_search_salesdailyno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&dailypic='+$("input[name='dlg_search_dailypic']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'salesdailyact_0_salesdailyactid='+$id
+ '&salesdailyno='+$("input[name='dlg_search_salesdailyno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&dailypic='+$("input[name='dlg_search_dailypic']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesdailyact/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'salesdailyact_0_salesdailyactid='+$id
+ '&salesdailyno='+$("input[name='dlg_search_salesdailyno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val()
+ '&dailypic='+$("input[name='dlg_search_dailypic']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesdailyact/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesdailyactid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('salesdailyact') ?></h3>
<?php if ($this->checkAccess('salesdailyact','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesdailyact','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesdailyact','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesdailyact','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salesdailyact','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('salesdailyact','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('salesdailyact','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salesdailyact','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salesdailyact','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('salesdailyact','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('salesdailyactid'),
					'name'=>'salesdailyactid',
					'value'=>'$data["salesdailyactid"]'
				),
							array(
					'header'=>$this->getCatalog('salesdailyno'),
					'name'=>'salesdailyno',
					'value'=>'$data["salesdailyno"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('salesname'),
					'name'=>'employeeid',
					'value'=>'$data["salesname"]'
				),
							array(
					'header'=>$this->getCatalog('dailydatetime'),
					'name'=>'dailydatetime',
					'value'=>'Yii::app()->format->formatDateTime($data["dailydatetime"])'
				),
							array(
					'header'=>$this->getCatalog('dailypic'),
					'name'=>'dailypic',
					'value'=>'$data["dailypic"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('dailylat'),
					'name'=>'dailylat',
					'value'=>'$data["dailylat"]'
				),
							array(
					'header'=>$this->getCatalog('dailylng'),
					'name'=>'dailylng',
					'value'=>'$data["dailylng"]'
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
						<label for="dlg_search_salesdailyno"><?php echo $this->getCatalog('salesdailyno')?></label>
						<input type="text" class="form-control" name="dlg_search_salesdailyno">
					</div>
          <div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
          <div class="form-group">
						<label for="dlg_search_dailypic"><?php echo $this->getCatalog('dailypic')?></label>
						<input type="text" class="form-control" name="dlg_search_dailypic">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('salesdailyact') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="salesdailyact_0_salesdailyactid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesdailyact_0_companyid','ColField'=>'salesdailyact_0_companyname',
							'IDDialog'=>'salesdailyact_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'salesdailyact_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesdailyact_0_employeeid','ColField'=>'salesdailyact_0_salesname',
							'IDDialog'=>'salesdailyact_0_employeeid_dialog','titledialog'=>$this->getCatalog('salesname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.SalesPopUp','PopGrid'=>'salesdailyact_0_employeeidgrid')); 
					?>
					<div class="row">
					<div class="col-md-4">
						<label for="salesdailyact_0_dailypic"><?php echo $this->getCatalog('dailypic')?></label>
					</div>
					<div class="col-md-8">
							<input type="text" name="salesdailyact_0_dailypic" readonly class="form-control">
					</div>
				</div>

				<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
				<script>
function successUp(param,param2,param3)
{
	$('input[name="salesdailyact_0_dailypic"]').val(param2);
}
</script>
				<?php
				$events = array(
						'success' => 'successUp(param,param2,param3)',
				);
$this->widget('ext.dropzone.EDropzone', array(
    'name'=>'upload',
    'url' => Yii::app()->createUrl('order/salesdailyact/upload'),
    'mimeTypes' => array('.jpg','.png','.jpeg'),		
		'events' => $events,
		'options' => CMap::mergeArray($this->options, $this->dict ),
    'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
));
?>
</div>
</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesdailyact_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="salesdailyact_0_description">
						</div>
					</div>
        
        <div class="row">
						<div class="col-md-4">
							<label for="salesdailyact_0_dailylat"><?php echo $this->getCatalog('dailylat')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesdailyact_0_dailylat">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesdailyact_0_dailylng"><?php echo $this->getCatalog('dailylng')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesdailyact_0_dailylng">
						</div>
					</div>
							<input type="hidden" class="form-control" name="salesdailyact_0_recordstatus">
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


