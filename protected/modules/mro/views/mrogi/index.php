<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='mrogiheader_0_mrogiheaderid']").val(data.mrogiheaderid);
			$("input[name='mrogiheader_0_mrogidate']").val(data.mrogidate);
      $("input[name='mrogiheader_0_giheaderid']").val('');
      $("input[name='fullname']").val('');
      $("input[name='taxcode']").val('PPN 10%');
      $("textarea[name='mrogiheader_0_shipto']").val('');
      $("textarea[name='mrogiheader_0_headernote']").val('');
      $("input[name='mrogiheader_0_gino']").val('');
			$.fn.yiiGridView.update('mrogidetailList',{data:{'mrogiheaderid':data.mrogiheaderid}});

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
function newdatamrogidetail()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/createmrogidetail')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='mrogidetail_1_mrogidetailid']").val('');
      $("input[name='mrogidetail_1_productid']").val('');
      $("input[name='mrogidetail_1_qty']").val(data.qty);
      $("input[name='mrogidetail_1_unitofmeasureid']").val('');
      $("input[name='mrogidetail_1_netprice']").val(data.netprice);
      $("textarea[name='mrogidetail_1_itemnote']").val('');
      $("input[name='mrogidetail_1_productname']").val('');
      $("input[name='mrogidetail_1_uomcode']").val('');
			$('#InputDialogmrogidetail').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}
    
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
						'productid':$("input[name='mrogidetail_1_productid']").val(),
						'companyid':$("input[name='companyid']").val(),
						'currencyid':$("input[name='currencyid']").val(),
						'addressbookid':$("input[name='addressbookid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='mrogidetail_1_unitofmeasureid']").val(data.uomid);
				$("input[name='mrogidetail_1_uomcode']").val(data.uomcode);
				$("input[name='slocid']").val(data.slocid);
				$("input[name='sloccode']").val(data.sloccode);
				$("input[name='price']").val(data.currencyvalue);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}

function getalldata(){
    jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('mro/mrogi/getdatamrogi')?>',
		'data': {'giheaderid':$("input[name='mrogiheader_0_giheaderid']").val()},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='fullname']").val(data.fullname);
				$("input[name='addressbookid']").val(data.addressbookid);
				$("input[name='taxcode']").val(data.taxcode);
				$("input[name='taxid']").val(data.taxid);
				$("textarea[name='mrogiheader_0_shipto']").val(data.shipto);
				$("textarea[name='mrogiheader_0_headernote']").val(data.headernote);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
	return false;
}

function check_mrogidetail(){
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/checkmrogiheadaer')?>',
		'data':{
			'mrogiheaderid':$("input[name='mrogiheader_0_mrogiheaderid']").val(),
            },
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}
function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='mrogiheader_0_mrogiheaderid']").val(data.mrogiheaderid);
				$("input[name='mrogiheader_0_mrogidate']").val(data.mrogidate);
                $("input[name='mrogiheader_0_giheaderid']").val(data.giheaderid);
                $("input[name='addressbookid']").val(data.addressbookid);
                $("input[name='taxid']").val(data.taxid);
                $("textarea[name='mrogiheader_0_shipto']").val(data.shipto);
                $("textarea[name='mrogiheader_0_headernote']").val(data.headernote);
                $("input[name='mrogiheader_0_gino']").val(data.gino);
				$.fn.yiiGridView.update('mrogidetailList',{data:{'mrogiheaderid':data.mrogiheaderid}});

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
function updatedatamrogidetail($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/updatemrogidetail')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='mrogidetail_1_mrogidetailid']").val(data.mrogidetailid);
      $("input[name='mrogidetail_1_productid']").val(data.productid);
      $("input[name='mrogidetail_1_qty']").val(data.qty);
      $("input[name='mrogidetail_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='mrogidetail_1_netprice']").val(data.netprice);
      $("textarea[name='mrogidetail_1_itemnote']").val(data.itemnote);
      $("input[name='mrogidetail_1_productname']").val(data.productname);
      $("input[name='mrogidetail_1_uomcode']").val(data.uomcode);
			$('#InputDialogmrogidetail').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/save')?>',
		'data':{
			'mrogiheaderid':$("input[name='mrogiheader_0_mrogiheaderid']").val(),
			'mrogidate':$("input[name='mrogiheader_0_mrogidate']").val(),
            'giheaderid':$("input[name='mrogiheader_0_giheaderid']").val(),
            'addressbookid':$("input[name='addressbookid']").val(),
            'taxid':$("input[name='taxid']").val(),
            'shipto':$("textarea[name='mrogiheader_0_shipto']").val(),
            'headernote':$("textarea[name='mrogiheader_0_headernote']").val(),
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

function savedatamrogidetail()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/savemrogidetail')?>',
		'data':{
			'mrogiheaderid':$("input[name='mrogiheader_0_mrogiheaderid']").val(),
			'mrogidetailid':$("input[name='mrogidetail_1_mrogidetailid']").val(),
      'productid':$("input[name='mrogidetail_1_productid']").val(),
      'qty':$("input[name='mrogidetail_1_qty']").val(),
      'unitofmeasureid':$("input[name='mrogidetail_1_unitofmeasureid']").val(),
      'netprice':$("input[name='mrogidetail_1_netprice']").val(),
      'itemnote':$("textarea[name='mrogidetail_1_itemnote']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogmrogidetail').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("mrogidetailList");
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/approve')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/purge')?>','data':{'id':$id},
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
function purgedatamrogidetail()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/purgemrogidetail')?>','data':{'id':$.fn.yiiGridView.getSelection("mrogidetailList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("mrogidetailList");
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
	var array = 'mrogiheader_0_mrogiheaderid='+$id
+ '&mrogino='+$("input[name='dlg_search_mrogino']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'mrogiheaderid='+$id
+ '&mrogino='+$("input[name='dlg_search_mrogino']").val();
	window.open('<?php echo Yii::app()->createUrl('mro/mrogi/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'mrogiheader_0_mrogiheaderid='+$id
+ '&mrogino='+$("input[name='dlg_search_mrogino']").val();
	window.open('<?php echo Yii::app()->createUrl('mro/mrogi/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'mrogiheaderid='+$id
$.fn.yiiGridView.update("DetailmrogidetailList",{data:array});
}
function getdatacustomer()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/customer/getdata')?>',
		'data':{'id':$("input[name='addressbookid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("textarea[name='mrogiheader_0_shipto']").val(data.shiptoname);
			}
		},
		'cache':false});
	return false;
}
</script>
<h3><?php echo $this->getCatalog('mrogi') ?></h3>
<?php if ($this->checkAccess('mrogi','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('mrogi','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('mrogi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('mrogiheaderid'),
					'name'=>'mrogiheaderid',
					'value'=>'$data["mrogiheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('mrogino'),
					'name'=>'mrogino',
					'value'=>'$data["mrogino"]'
				),
							array(
					'header'=>$this->getCatalog('mrogidate'),
					'name'=>'mrogidate',
					'value'=>'Yii::app()->format->formatDate($data["mrogidate"])'
				),
							array(
					'header'=>$this->getCatalog('gino'),
					'name'=>'giheaderid',
					'value'=>'$data["gino"]'
				),
                            array(
					'header'=>$this->getCatalog('customer'),
					'name'=>'addressbookid',
					'value'=>'$data["fullname"]'
				),
							array(
					'header'=>$this->getCatalog('shipto'),
					'name'=>'shipto',
					'value'=>'$data["shipto"]'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
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
						<label for="dlg_search_mrogino"><?php echo $this->getCatalog('mrogino')?></label>
						<input type="text" class="form-control" name="dlg_search_mrogino">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('mrogi') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="mrogiheader_0_mrogiheaderid">
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_mrogidate"><?php echo $this->getCatalog('mrogidate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="mrogiheader_0_mrogidate">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrogiheader_0_giheaderid','ColField'=>'mrogiheader_0_gino',
							'IDDialog'=>'mrogiheader_0_giheaderid_dialog','titledialog'=>$this->getCatalog('gino'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'mro.components.views.MrogiheaderPopUp','PopGrid'=>'mrogiheader_0_giheaderidgrid',
                            'onaftersign'=>'getalldata()')); 
					?>
        <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'addressbookid','ColField'=>'fullname',
					'IDDialog'=>'customer_dialog','titledialog'=>$this->getCatalog('customer'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.CustomerPopUp','PopGrid'=>'customergrid',
					'onaftersign'=>'getdatacustomer()')); 
                    ?>
          <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'taxid','ColField'=>'taxcode',
					'IDDialog'=>'tax_dialog','titledialog'=>$this->getCatalog('tax'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'common.components.views.TaxPopUp','PopGrid'=>'taxgrid')); 
			?>
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_shipto"><?php echo $this->getCatalog('shipto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogiheader_0_shipto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogiheader_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#mrogidetail" onclick="check_mrogidetail()"><?php echo $this->getCatalog("mrogidetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="mrogidetail" class="tab-pane">
	<?php if ($this->checkAccess('mrogi','iswrite')) { ?>
<button name="CreateButtonmrogidetail" type="button" class="btn btn-primary" onclick="newdatamrogidetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispurge')) { ?>
<button name="PurgeButtonmrogidetail" type="button" class="btn btn-danger" onclick="purgedatamrogidetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidermrogidetail,
		'id'=>'mrogidetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('mrogi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatamrogidetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatamrogidetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('mrogidetailid'),
					'name'=>'mrogidetailid',
					'value'=>'$data["mrogidetailid"]'
				),
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
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('mrogidetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidermrogidetail,
		'id'=>'DetailmrogidetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('mrogidetailid'),
					'name'=>'mrogidetailid',
					'value'=>'$data["mrogidetailid"]'
				),
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
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogmrogidetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('mrogidetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="mrogidetail_1_mrogidetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrogidetail_1_productid','ColField'=>'mrogidetail_1_productname',
							'IDDialog'=>'mrogidetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'mrogidetail_1_productidgrid',
                             'onaftersign'=>'getproductdata();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrogidetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrogidetail_1_unitofmeasureid','ColField'=>'mrogidetail_1_uomcode',
							'IDDialog'=>'mrogidetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'mrogidetail_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_netprice"><?php echo $this->getCatalog('netprice')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrogidetail_1_netprice">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogidetail_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatamrogidetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			
