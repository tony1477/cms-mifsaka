<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesplan_0_salesplanid']").val(data.salesplanid);
			$("input[name='salesplan_0_companyid']").val('');
      $("input[name='salesplan_0_employeeid']").val('');
      $("input[name='salesplan_0_plandate']").val(data.plandate);
      $("input[name='salesplan_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesplan_0_companyname']").val('');
      $("input[name='salesplan_0_salesname']").val('');
			$.fn.yiiGridView.update('salesplandetList',{data:{'salesplanid':data.salesplanid}});

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
function newdatasalesplandet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/createsalesplandet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesplandet_1_salesplandetid']").val('');
      $("input[name='salesplandet_1_addressbookid']").val('');
      $("textarea[name='salesplandet_1_plandesc']").val('');
      $("input[name='salesplandet_1_plandatetime']").val(data.plandatetime);
      $("input[name='salesplandet_1_customername']").val('');
			$('#InputDialogsalesplandet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salesplan_0_salesplanid']").val(data.salesplanid);
				$("input[name='salesplan_0_companyid']").val(data.companyid);
      $("input[name='salesplan_0_employeeid']").val(data.employeeid);
      $("input[name='salesplan_0_plandate']").val(data.plandate);
      $("input[name='salesplan_0_recordstatus']").val(data.recordstatus);
      $("input[name='salesplan_0_companyname']").val(data.companyname);
      $("input[name='salesplan_0_salesname']").val(data.salesname);
				$.fn.yiiGridView.update('salesplandetList',{data:{'salesplanid':data.salesplanid}});

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
function updatedatasalesplandet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/updatesalesplandet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='salesplandet_1_salesplandetid']").val(data.salesplandetid);
      $("input[name='salesplandet_1_addressbookid']").val(data.addressbookid);
      $("textarea[name='salesplandet_1_plandesc']").val(data.plandesc);
      $("input[name='salesplandet_1_plandatetime']").val(data.plandatetime);
      $("input[name='salesplandet_1_customername']").val(data.customername);
			$('#InputDialogsalesplandet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/save')?>',
		'data':{
			'salesplanid':$("input[name='salesplan_0_salesplanid']").val(),
			'companyid':$("input[name='salesplan_0_companyid']").val(),
      'employeeid':$("input[name='salesplan_0_employeeid']").val(),
      'plandate':$("input[name='salesplan_0_plandate']").val(),
      'recordstatus':$("input[name='salesplan_0_recordstatus']").val(),
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

function savedatasalesplandet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/savesalesplandet')?>',
		'data':{
			'salesplanid':$("input[name='salesplan_0_salesplanid']").val(),
			'salesplandetid':$("input[name='salesplandet_1_salesplandetid']").val(),
      'addressbookid':$("input[name='salesplandet_1_addressbookid']").val(),
      'plandesc':$("textarea[name='salesplandet_1_plandesc']").val(),
      'plandatetime':$("input[name='salesplandet_1_plandatetime']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogsalesplandet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("salesplandetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/purge')?>','data':{'id':$id},
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
function purgedatasalesplandet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salesplan/purgesalesplandet')?>','data':{'id':$.fn.yiiGridView.getSelection("salesplandetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("salesplandetList");
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
	var array = 'salesplan_0_salesplanid='+$id
+ '&salesplanno='+$("input[name='dlg_search_salesplanno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'salesplan_0_salesplanid='+$id
+ '&salesplanno='+$("input[name='dlg_search_salesplanno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesplan/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'salesplan_0_salesplanid='+$id
+ '&salesplanno='+$("input[name='dlg_search_salesplanno']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val()
+ '&salesname='+$("input[name='dlg_search_salesname']").val();
	window.open('<?php echo Yii::app()->createUrl('Order/salesplan/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salesplanid='+$id
$.fn.yiiGridView.update("DetailsalesplandetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('salesplan') ?></h3>
<?php if ($this->checkAccess('salesplan','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesplan','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesplan','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesplan','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salesplan','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('salesplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salesplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salesplan','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('salesplanid'),
					'name'=>'salesplanid',
					'value'=>'$data["salesplanid"]'
				),
							array(
					'header'=>$this->getCatalog('salesplanno'),
					'name'=>'salesplanno',
					'value'=>'$data["salesplanno"]'
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
					'header'=>$this->getCatalog('plandate'),
					'name'=>'plandate',
					'value'=>'Yii::app()->format->formatDate($data["plandate"])'
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
						<label for="dlg_search_salesplanno"><?php echo $this->getCatalog('salesplanno')?></label>
						<input type="text" class="form-control" name="dlg_search_salesplanno">
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('fullname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('salesplan') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="salesplan_0_salesplanid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesplan_0_companyid','ColField'=>'salesplan_0_companyname',
							'IDDialog'=>'salesplan_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'salesplan_0_companyidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesplan_0_employeeid','ColField'=>'salesplan_0_salesname',
							'IDDialog'=>'salesplan_0_employeeid_dialog','titledialog'=>$this->getCatalog('salesname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'salesplan_0_employeeidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesplan_0_plandate"><?php echo $this->getCatalog('plandate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salesplan_0_plandate">
						</div>
					</div>
							<input type="hidden" class="form-control" name="salesplan_0_recordstatus">
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#salesplandet"><?php echo $this->getCatalog("salesplandet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="salesplandet" class="tab-pane">
	<?php if ($this->checkAccess('salesplan','iswrite')) { ?>
<button name="CreateButtonsalesplandet" type="button" class="btn btn-primary" onclick="newdatasalesplandet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salesplan','ispurge')) { ?>
<button name="PurgeButtonsalesplandet" type="button" class="btn btn-danger" onclick="purgedatasalesplandet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalesplandet,
		'id'=>'salesplandetList',
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
							'visible'=>$this->booltostr($this->checkAccess('salesplan','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatasalesplandet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salesplan','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatasalesplandet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('salesplandetid'),
					'name'=>'salesplandetid',
					'value'=>'$data["salesplandetid"]'
				),
							array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["customername"]'
				),
							array(
					'header'=>$this->getCatalog('plandesc'),
					'name'=>'plandesc',
					'value'=>'$data["plandesc"]'
				),
							array(
					'header'=>$this->getCatalog('plandatetime'),
					'name'=>'plandatetime',
					'value'=>'Yii::app()->format->formatDateTime($data["plandatetime"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('salesplandet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalesplandet,
		'id'=>'DetailsalesplandetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('salesplandetid'),
					'name'=>'salesplandetid',
					'value'=>'$data["salesplandetid"]'
				),
							array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["customername"]'
				),
							array(
					'header'=>$this->getCatalog('plandesc'),
					'name'=>'plandesc',
					'value'=>'$data["plandesc"]'
				),
							array(
					'header'=>$this->getCatalog('plandatetime'),
					'name'=>'plandatetime',
					'value'=>'Yii::app()->format->formatDateTime($data["plandatetime"])'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogsalesplandet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('salesplandet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="salesplandet_1_salesplandetid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salesplandet_1_addressbookid','ColField'=>'salesplandet_1_customername',
							'IDDialog'=>'salesplandet_1_addressbookid_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'salesplandet_1_addressbookidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesplandet_1_plandesc"><?php echo $this->getCatalog('plandesc')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="salesplandet_1_plandesc"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="salesplandet_1_plandatetime"><?php echo $this->getCatalog('plandatetime')?></label>
						</div>
						<div class="col-md-8">
							<input type="datetime-local" class="form-control" name="salesplandet_1_plandatetime">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasalesplandet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			