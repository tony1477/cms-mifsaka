<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesprogram_0_salesprogramid']").val(data.salesprogramid);
			$("input[name='salesprogram_0_salesprogramdate']").val(data.salesprogramdate);
      $("input[name='salesprogram_0_companyid']").val('');
      $("input[name='salesprogram_0_addressbookid']").val('');
      $("input[name='salesprogram_0_iscontract']").prop('checked',true);
      $("input[name='salesprogram_0_programname']").val('');
      $("input[name='salesprogram_0_month']").val('');
      $("input[name='salesprogram_0_totalvalue']").val('');
      $("textarea[name='salesprogram_0_description']").val('');
      $("input[name='salesprogram_0_startdate']").val(data.startdate);
      $("input[name='salesprogram_0_enddate']").val(data.enddate);
      $("input[name='salesprogram_0_docupload']").val('');
      $("input[name='salesprogram_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesprogram_0_companyname']").val('');
      $("input[name='salesprogram_0_fullname']").val('');
			
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salesprogram_0_salesprogramid']").val(data.salesprogramid);
				$("input[name='salesprogram_0_salesprogramdate']").val(data.salesprogramdate);
      $("input[name='salesprogram_0_companyid']").val(data.companyid);
      $("input[name='salesprogram_0_addressbookid']").val(data.addressbookid);
      if (data.iscontract == 1)
			{
				$("input[name='salesprogram_0_iscontract']").prop('checked',true);
			}
			else
			{
				$("input[name='salesprogram_0_iscontract']").prop('checked',false)
			}
      $("input[name='salesprogram_0_programname']").val(data.programname);
      $("input[name='salesprogram_0_month']").val(data.month);
      $("input[name='salesprogram_0_totalvalue']").val(data.totalvalue);
      $("textarea[name='salesprogram_0_description']").val(data.description);
      $("input[name='salesprogram_0_startdate']").val(data.startdate);
      $("input[name='salesprogram_0_enddate']").val(data.enddate);
      $("input[name='salesprogram_0_docupload']").val(data.docupload);
      $("input[name='salesprogram_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesprogram_0_companyname']").val(data.companyname);
      $("input[name='salesprogram_0_fullname']").val(data.fullname);
				
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
	var iscontract = 0;
	if ($("input[name='salesprogram_0_iscontract']").prop('checked'))
	{
		iscontract = 1;
	}
	else
	{
		iscontract = 0;
	}
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/save')?>',
		'data':{
			'salesprogramid':$("input[name='salesprogram_0_salesprogramid']").val(),
			'salesprogramdate':$("input[name='salesprogram_0_salesprogramdate']").val(),
      'companyid':$("input[name='salesprogram_0_companyid']").val(),
      'addressbookid':$("input[name='salesprogram_0_addressbookid']").val(),
      'iscontract':iscontract,
      'programname':$("input[name='salesprogram_0_programname']").val(),
      'month':$("input[name='salesprogram_0_month']").val(),
      'totalvalue':$("input[name='salesprogram_0_totalvalue']").val(),
      'description':$("textarea[name='salesprogram_0_description']").val(),
      'startdate':$("input[name='salesprogram_0_startdate']").val(),
      'enddate':$("input[name='salesprogram_0_enddate']").val(),
      'docupload':$("input[name='salesprogram_0_docupload']").val(),
      'recordstatus':$("input[name='salesprogram_0_recordstatus']").val(),
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesprogram/purge')?>','data':{'id':$id},
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
	var array = 'salesprogram_0_salesprogramid='+$id
+ '&salesprogramno='+$("input[name='dlg_search_salesprogramno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&customer='+$("input[name='dlg_search_customer']").val()
+ '&iscontract='+$("input[name='dlg_search_iscontract']").val()
+ '&programname='+$("input[name='dlg_search_programname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'salesprogram_0_salesprogramid='+$id
+ '&salesprogramno='+$("input[name='dlg_search_salesprogramno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&customer='+$("input[name='dlg_search_customer']").val()
+ '&iscontract='+$("input[name='dlg_search_iscontract']").val()
+ '&programname='+$("input[name='dlg_search_programname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesprogram/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'salesprogram_0_salesprogramid='+$id
+ '&salesprogramno='+$("input[name='dlg_search_salesprogramno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&customer='+$("input[name='dlg_search_customer']").val()
+ '&iscontract='+$("input[name='dlg_search_iscontract']").val()
+ '&programname='+$("input[name='dlg_search_programname']").val()
+ '&description='+$("input[name='dlg_search_description']").val()
+ '&docupload='+$("input[name='dlg_search_docupload']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesprogram/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesprogramid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('salesprogram') ?></h3>
<?php if ($this->checkAccess('salesprogram','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesprogram','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesprogram','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesprogram','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salesprogram','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('salesprogram','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('salesprogram','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salesprogram','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salesprogram','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('salesprogram','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('salesprogramid'),
					'name'=>'salesprogramid',
					'value'=>'$data["salesprogramid"]'
				),
							array(
					'header'=>$this->getCatalog('salesprogramno'),
					'name'=>'salesprogramno',
					'value'=>'$data["salesprogramno"]'
				),
							array(
					'header'=>$this->getCatalog('salesprogramdate'),
					'name'=>'salesprogramdate',
					'value'=>'Yii::app()->format->formatDate($data["salesprogramdate"])'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'iscontract',
					'header'=>$this->getCatalog('iscontract'),
					'selectableRows'=>'0',
					'checked'=>'$data["iscontract"]',
				),
							array(
					'header'=>$this->getCatalog('programname'),
					'name'=>'programname',
					'value'=>'$data["programname"]'
				),
							array(
					'header'=>$this->getCatalog('bulan'),
					'name'=>'month',
					'value'=>'$data["month"]'
				),
							array(
					'header'=>$this->getCatalog('totalvalue'),
					'name'=>'totalvalue',
					'value'=>'Yii::app()->format->formatNumber($data["totalvalue"])'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
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
							array(
					'header'=>$this->getCatalog('docupload'),
					'name'=>'docupload',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/salesprogram/".$data["docupload"],$data["docupload"],
					array("width"=>"100"))'
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
						<label for="dlg_search_salesprogramno"><?php echo $this->getCatalog('salesprogramno')?></label>
						<input type="text" class="form-control" name="dlg_search_salesprogramno">
					</div>
          <div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
					</div>
          <div class="form-group">
						<label for="dlg_search_customer"><?php echo $this->getCatalog('customer')?></label>
						<input type="text" class="form-control" name="dlg_search_customer">
					</div>
          <div class="form-group">
						<label for="dlg_search_iscontract"><?php echo $this->getCatalog('iscontract')?></label>
						<input type="text" class="form-control" name="dlg_search_iscontract">
					</div>
          <div class="form-group">
						<label for="dlg_search_programname"><?php echo $this->getCatalog('programname')?></label>
						<input type="text" class="form-control" name="dlg_search_programname">
					</div>
          <div class="form-group">
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
					</div>
          <div class="form-group">
						<label for="dlg_search_docupload"><?php echo $this->getCatalog('docupload')?></label>
						<input type="text" class="form-control" name="dlg_search_docupload">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('salesprogram') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="salesprogram_0_salesprogramid">
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_salesprogramdate"><?php echo $this->getCatalog('salesprogramdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesprogram_0_salesprogramdate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesprogram_0_companyid','ColField'=>'salesprogram_0_companyname',
							'IDDialog'=>'salesprogram_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'salesprogram_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesprogram_0_addressbookid','ColField'=>'salesprogram_0_fullname',
							'IDDialog'=>'salesprogram_0_addressbookid_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.AddressbookPopUp','PopGrid'=>'salesprogram_0_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_iscontract"><?php echo $this->getCatalog('iscontract')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="salesprogram_0_iscontract">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_programname"><?php echo $this->getCatalog('programname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="salesprogram_0_programname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_month"><?php echo $this->getCatalog('bulan')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesprogram_0_month">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_totalvalue"><?php echo $this->getCatalog('totalvalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salesprogram_0_totalvalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="salesprogram_0_description"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_startdate"><?php echo $this->getCatalog('startdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesprogram_0_startdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_enddate"><?php echo $this->getCatalog('enddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesprogram_0_enddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesprogram_0_docupload"><?php echo $this->getCatalog('docupload')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="salesprogram_0_docupload">
						</div>
					</div>
							<input type="hidden" class="form-control" name="salesprogram_0_recordstatus">
          <script>
				function successUp(param,param2,param3)
				{
					$('input[name="salesprogram_0_docupload"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('order/salesprogram/upload'),
						'mimeTypes' => array('.jpg','.png','.pdf'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


