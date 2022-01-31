<script type="text/javascript">

function clearsales(){
    $("input[name='salestarget_0_employeeid']").val('');
    $("input[name='salestarget_0_employeename']").val('');
}
function clearproduct(){
    $("input[name='salestargetdet_1_productid']").val('');
    $("input[name='salestargetdet_1_productname']").val('');
}

function cleartype(){
  $("input[name='salestargetdet_1_materialgroupid']").val('');
  $("input[name='salestargetdet_1_description").val('');
}
function generatedetail(){
  /*
     jQuery.ajax({'url':'<?php //echo Yii::app()->createUrl('order/salestarget/generatedetail')?>',
        'data':{
            'companyid':$("input[name='salestarget_0_companyid']").val(),
            'employeeid':$("input[name='salestarget_0_employeeid']").val(),
            'perioddate':$("input[name='salestarget_0_perioddate']").val(),
            'salestargetid':$("input[name='salestarget_0_salestargetid']").val(), },
            'type':'post','dataType':'json',
            'success':function(data) {
			if (data.status == "success")
			{
                /*
                $("input[name='salestargetdet_1_slocid']").val(data.slocid);
                $("input[name='salestargetdet_1_unitofmeasureid']").val(data.unitofmeasureid);
                $("input[name='salestargetdet_1_sloccode']").val(data.sloccode);
                $("input[name='salestargetdet_1_uomcode']").val(data.uomcode);
                */
                /*
                toastr.info(data.div);
                $.fn.yiiGridView.update("salestargetdetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
    */
	return false; 
}
function generateproduct(){
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/generateproduct')?>',
        'data':{
            'companyid':$("input[name='salestarget_0_companyid']").val(),
            'productid':$("input[name='salestargetdet_1_productid']").val(), },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='salestargetdet_1_materialgroupid']").val(data.materialgroupid);
                $("input[name='salestargetdet_1_materialgroupcode']").val(data.materialgroupcode);
                $("input[name='salestargetdet_1_slocid']").val(data.slocid);
                $("input[name='salestargetdet_1_unitofmeasureid']").val(data.unitofmeasureid);
                $("input[name='salestargetdet_1_sloccode']").val(data.sloccode);
                $("input[name='salestargetdet_1_uomcode']").val(data.uomcode);
                $("input[name='materialgroupid']").val(data.materialgroupid);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='salestarget_0_salestargetid']").val(data.salestargetid);
                $("input[name='salestarget_0_perioddate']").val(data.perioddate);
                $("input[name='salestarget_0_docdate']").val(data.docdate);
                $("input[name='salestarget_0_employeeid']").val('');
                $("input[name='salestarget_0_recordstatus']").val(data.recordstatus);
                $("input[name='salestarget_0_companyid']").val('');
                $("input[name='salestarget_0_employeename']").val('');
                $("input[name='salestarget_0_companyname']").val('');
                $.fn.yiiGridView.update('salestargetdetList',{data:{'salestargetid':data.salestargetid}});

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
function newdatasalestargetdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/createsalestargetdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='salestargetdet_1_salestargetdetid']").val('');
                $("input[name='salestargetdet_1_materialgroupid']").val('');
                $("input[name='salestargetdet_1_materialgroupcode']").val('');
                //$("input[name='salestargetdet_1_productid']").val('');
                //$("input[name='salestargetdet_1_qty']").val(data.qty);
                $("input[name='salestargetdet_1_price']").val('');
                //$("input[name='salestargetdet_1_productname']").val('');
                //$("input[name='salestargetdet_1_slocid']").val('');
                //$("input[name='salestargetdet_1_unitofmeasureid']").val('');
                //$("input[name='salestargetdet_1_sloccode']").val('');
                //$("input[name='salestargetdet_1_uomcode']").val('');
                $('#InputDialogsalestargetdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='salestarget_0_salestargetid']").val(data.salestargetid);
                $("input[name='salestarget_0_perioddate']").val(data.perioddate);
                $("input[name='salestarget_0_docdate']").val(data.docdate);
                $("input[name='salestarget_0_employeeid']").val(data.employeeid);
                $("input[name='salestarget_0_recordstatus']").val(data.recordstatus);
                $("input[name='salestarget_0_companyid']").val(data.companyid);
                $("input[name='salestarget_0_employeename']").val(data.employeename);
                $("input[name='salestarget_0_companyname']").val(data.companyname);
                $.fn.yiiGridView.update('salestargetdetList',{data:{'salestargetid':data.salestargetid}});

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
function updatedatasalestargetdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/updatesalestargetdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                $("input[name='salestargetdet_1_salestargetdetid']").val(data.salestargetdetid);
                $("input[name='salestargetdet_1_materialgroupid']").val(data.materialgroupid);
                $("input[name='salestargetdet_1_custcategoryid']").val(data.custcategoryid);
                $("input[name='salestargetdet_1_custcategoryname']").val(data.custcategoryname);
                $("input[name='salestargetdet_1_groupkastaid']").val(data.groupkastaid);
                $("input[name='salestargetdet_1_groupname']").val(data.groupname);
                $("input[name='salestargetdet_1_materialgroupid']").val(data.materialgroupid);
                //$("input[name='materialgroupid']").val(data.materialgroupid);
                $("input[name='salestargetdet_1_description']").val(data.materialgroupcode);
                //$("input[name='salestargetdet_1_productid']").val(data.productid);
                //$("input[name='salestargetdet_1_qty']").val(data.qty);
                $("input[name='salestargetdet_1_price']").val(data.price);
                //$("input[name='salestargetdet_1_productname']").val(data.productname);
                //$("input[name='salestargetdet_1_slocid']").val(data.slocid);
                //$("input[name='salestargetdet_1_unitofmeasureid']").val(data.unitofmeasureid);
                //$("input[name='salestargetdet_1_sloccode']").val(data.sloccode);
                //$("input[name='salestargetdet_1_uomcode']").val(data.uomcode);
                $('#InputDialogsalestargetdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/save')?>',
		'data':{
            'salestargetid':$("input[name='salestarget_0_salestargetid']").val(),
            'perioddate':$("input[name='salestarget_0_perioddate']").val(),
            'docdate':$("input[name='salestarget_0_docdate']").val(),
            'employeeid':$("input[name='salestarget_0_employeeid']").val(),
            'recordstatus':$("input[name='salestarget_0_recordstatus']").val(),
            'companyid':$("input[name='salestarget_0_companyid']").val(),
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

function savedatasalestargetdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/savesalestargetdet')?>',
		'data':{
            'salestargetid':$("input[name='salestarget_0_salestargetid']").val(),
            'salestargetdetid':$("input[name='salestargetdet_1_salestargetdetid']").val(),
            'perioddate':$("input[name='salestarget_0_perioddate']").val(),
            'materialgroupid':$("input[name='salestargetdet_1_materialgroupid']").val(),
            'custcategoryid':$("input[name='salestargetdet_1_custcategoryid']").val(),
            'groupkastaid':$("input[name='salestargetdet_1_groupkastaid']").val(),
            //'productid':$("input[name='salestargetdet_1_productid']").val(),
            //'qty':$("input[name='salestargetdet_1_qty']").val(),
            'price':$("input[name='salestargetdet_1_price']").val(),
            //'slocid':$("input[name='salestargetdet_1_slocid']").val(),
            //'unitofmeasureid':$("input[name='salestargetdet_1_unitofmeasureid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogsalestargetdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("salestargetdetList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/purge')?>','data':{'id':$id},
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
function purgedatasalestargetdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/salestarget/purgesalestargetdet')?>','data':{'id':$.fn.yiiGridView.getSelection("salestargetdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("salestargetdetList");
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
	var array = 'fullname='+$("input[name='dlg_search_fullname']").val()
+ '&companyname='+$("input[name='dlg_search_companyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'salestargetid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/salestarget/downpdf')?>?'+array);
}

function downpdf1($id=0) {
	var array = 'salestargetid='+$id;
	window.open('<?php echo Yii::app()->createUrl('order/salestarget/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'salestarget_0_salestargetid='+$id
+ '&statusname='+$("input[name='dlg_search_statusname']").val();
	window.open('<?php echo Yii::app()->createUrl('order/salestarget/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'salestargetid='+$id
$.fn.yiiGridView.update("DetailsalestargetdetList",{data:array});
    var array = 'salestargetid='+$id
$.fn.yiiGridView.update("DetailsalestargetdetList1",{data:array});
    
} 
</script>
<h3><?php echo $this->getCatalog('salestarget') ?></h3>
<?php if ($this->checkAccess('salestarget','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php }?>
<?php if ($this->checkAccess('salestarget','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php }?>
<?php if ($this->checkAccess('salestarget','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php }?>
<?php  if ($this->checkAccess('salestarget','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php }  ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salestarget','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('salestarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salestarget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('salestargetid'),
					'name'=>'salestargetid',
					'value'=>'$data["salestargetid"]'
				),          
                            array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
                            array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'docno',
					'value'=>'$data["docno"]'
				),
                            array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
            
                            array(
					'header'=>$this->getCatalog('perioddatetarget'),
					'name'=>'perioddate',
					'value'=>'Yii::app()->format->formatDate($data["perioddate"])'
				),
                            array(
					'header'=>$this->getCatalog('sales'),
					'name'=>'employeeid',
					'value'=>'$data["employeename"]'
				),
                            array(
					'header'=>$this->getCatalog('useraccess'),
					'name'=>'useraccessid',
					'value'=>'$data["username"]'
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
						<label for="dlg_search_fullname"><?php echo $this->getCatalog('salesname')?></label>
						<input type="text" class="form-control" name="dlg_search_fullname">
					</div>
                    <div class="form-group">
						<label for="dlg_search_companyname"><?php echo $this->getCatalog('company')?></label>
						<input type="text" class="form-control" name="dlg_search_companyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('salestarget') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="salestarget_0_salestargetid">
        <div class="row">
						<div class="col-md-4">
							<label for="salestarget_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salestarget_0_docdate">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="salestarget_0_perioddate"><?php echo $this->getCatalog('perioddatetarget')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="salestarget_0_perioddate">
						</div>
					</div>
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestarget_0_companyid','ColField'=>'salestarget_0_companyname',
							'IDDialog'=>'salestarget_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'salestarget_0_companyidgrid','onaftersign'=>'clearsales()')); 
					?>
          
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestarget_0_employeeid','ColField'=>'salestarget_0_employeename',
							'IDDialog'=>'salestarget_0_employeeid_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'hr.components.views.EmployeecomsalesPopUp','PopGrid'=>'salestarget_0_employeeidgrid','RelationID'=>'salestarget_0_companyid')); 
					?>
							<input type="hidden" class="form-control" name="salestarget_0_recordstatus">
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#salestargetdet"><?php echo $this->getCatalog("salestargetdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="salestargetdet" class="tab-pane">
	<?php if ($this->checkAccess('salestarget','iswrite')) { ?>
<button name="CreateButtonsalestargetdet" type="button" class="btn btn-primary" onclick="newdatasalestargetdet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('salestarget','iswrite')) { ?>
<button name="PurgeButtonsalestargetdet" type="button" class="btn btn-danger" onclick="purgedatasalestargetdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalestargetdet,
		'id'=>'salestargetdetList',
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
							'visible'=>$this->booltostr($this->checkAccess('salestarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatasalestargetdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('salestarget','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatasalestargetdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('salestargetdetid'),
					'name'=>'salestargetdetid',
					'value'=>'$data["salestargetdetid"]',
          'visible'=>true
				),
							array(
					'header'=>$this->getCatalog('custcategory'),
					'name'=>'custcategoryid',
					'value'=>'$data["custcategoryname"]'
				),
                            array(
					'header'=>$this->getCatalog('materialgroup'),
					'name'=>'materialgroupid',
					'value'=>'$data["description"]'
				),
        /*
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
        */
                            array(
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatCurrency($data["price"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('salestargetdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
<div class="box-body">
				<?php 
    
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidersalestargetdet,
		'id'=>'DetailsalestargetdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
                             array(
					'header'=>$this->getCatalog('custcategory'),
					'name'=>'custcategoryid',
					'value'=>'$data["custcategoryname"]'
				),
                            array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
                            array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
				             array(
					'header'=>$this->getCatalog('price'),
					'name'=>'price',
					'value'=>'Yii::app()->format->formatCurrency($data["price"])'
				),
		)
));  ?>
		</div>		
		</div>
        <div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $this->getCatalog('salestargetdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
<div class="box-body">
    <?php 
     /*       
    $dataProviderFG1=new CSqlDataProvider($sql,array(
					'totalItemCount'=>'5',
					'keyField'=>'materialgroupid',
					'pagination'=>array(
						'pageSize'=>$this->getParameter('DefaultPageSize'),
						'pageVar'=>'page',
					),
					'sort'=>array(
						'defaultOrder' => array( 
							'materialgroupid' => CSort::SORT_DESC
						),
					),
					));
    
				
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderFG1,
		'id'=>'DetailsalestargetdetList1',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
                            array(
					'header'=>$this->getCatalog('materialgroupid'),
					'name'=>'materialgroupid',
					'value'=>'$data["materialgroupid"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["totalfg"])'
				),
							
		) 
)); */ ?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
-->
<!--
<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="box box-primary">
                   <div class="box-header with-border">
                       <!-- begin grupmaterial -->
                       <?php /*
                       foreach($dataFG as $row) { ?>
                        <div class="box box-primary collapsed-box">
                           <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $row['description']?></h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        <div class="box-body" style="display: none;">
                            <!--
                                data
                            -->
                            <?php 
                           /*
                                $sql = 'select productid 
                                from productplant a
                                join salestargetdet b on b.materialgroupid = a.materialgroupid
                                where a.materialgroupid = '.$row['materialgroupid'].' and 
                                salestargetid = '.$row['salestargetid'];
                            */
                            ?>
<!--
                        </div>		
                      </div>
                       <?php //} ?>
                        <!-- end grupmaterial -->
                    <!-- </div>
                </div>
            </div>
        </div>
    </div>
</div>
        -->
<div id="InputDialogsalestargetdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('salestargetdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="salestargetdet_1_salestargetdetid">
            
         <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestargetdet_1_custcategoryid','ColField'=>'salestargetdet_1_custcategoryname',
							'IDDialog'=>'salestargetdet_1_custcategoryid_dialog','titledialog'=>$this->getCatalog('custcategory'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.CustcategoryPopUp','PopGrid'=>'salestargetdet_1_custcategoryidgrid')); 
					?>        
        
        <?php /* $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestargetdet_1_materialgroupid','ColField'=>'salestargetdet_1_materialgroupcode',
							'IDDialog'=>'salestargetdet_1_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupSalesPopUp','PopGrid'=>'salestargetdet_1_materialgroupididgrid','onaftersign'=>'clearproduct()')); 
              */
        ?>

        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestargetdet_1_groupkastaid','ColField'=>'salestargetdet_1_groupname',
							'IDDialog'=>'salestargetdet_1_groupkastaid_dialog','titledialog'=>$this->getCatalog('groupkasta'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.GroupKastaPopUp','PopGrid'=>'salestargetdet_1_groupkastaidgrid','onaftersign'=>'cleartype()')); 
        ?>
		    <!--<input type="hidden" class="form-control" name="materialgroupid" value="" />-->
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'salestargetdet_1_materialgroupid','ColField'=>'salestargetdet_1_description',
							'IDDialog'=>'salestargetdet_1_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroup'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgroupKastaPopUp','PopGrid'=>'salestargetdet_1_materialgroupidgrid','RelationID'=>'salestargetdet_1_groupkastaid','onaftersign'=>'clearprice()')); 
					?>
				<!--		
        <div class="row">
						<div class="col-md-4">
							<label for="salestargetdet_1_slocid"><?php //echo $this->getCatalog('sloccode')?></label>
						</div>
						<div class="col-md-8">
							<input type="hidden" class="form-control" name="salestargetdet_1_slocid">
							<input type="text" class="form-control" name="salestargetdet_1_sloccode" readonly="readonly">
						</div>
					</div>
        -->
        <!--
        <div class="row">
						<div class="col-md-4">
							<label for="salestargetdet_1_unitofmeasureid"><?php //echo $this->getCatalog('uomcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="hidden" class="form-control" name="salestargetdet_1_unitofmeasureid">
							<input type="text" class="form-control" name="salestargetdet_1_uomcode" readonly="readonly">
						</div>
					</div>
        <div class="row">
						<div class="col-md-4">
							<label for="salestargetdet_1_qty"><?php //echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salestargetdet_1_qty">
						</div>
					</div>
        -->
         <div class="row">
						<div class="col-md-4">
							<label for="salestargetdet_1_price"><?php echo $this->getCatalog('Target')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="salestargetdet_1_price">
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatasalestargetdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			