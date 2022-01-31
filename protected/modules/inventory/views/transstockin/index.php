<style type="text/css">
.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +1000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:10%;
}
</style>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<script type="text/javascript">
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstock_0_transstockid']").val(data.transstockid);
			$("input[name='transstock_0_slocfromid']").val('');
      $("input[name='transstock_0_sloctoid']").val('');
      $("input[name='transstock_0_docdate']").val(data.docdate);
      $("textarea[name='transstock_0_headernote']").val('');
      $("input[name='transstock_0_deliveryadviceid']").val('');
      $("input[name='transstock_0_sloccode']").val('');
      $("input[name='transstock_0_sloccode']").val('');
      $("input[name='transstock_0_dano']").val('');
			$.fn.yiiGridView.update('transstockdetList',{data:{'transstockid':data.transstockid}});

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
function newdatatransstockdet()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/createtransstockdet')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstockdet_1_productid']").val('');
      $("input[name='transstockdet_1_storagebinid']").val('');
      $("input[name='transstockdet_1_unitofmeasureid']").val('');
      $("input[name='transstockdet_1_qty']").val(data.qty);
      $("input[name='transstockdet_1_storagebintoid']").val('');
      $("textarea[name='transstockdet_1_itemtext']").val('');
      $("input[name='transstockdet_1_productname']").val('');
      $("input[name='transstockdet_1_description']").val('');
      $("input[name='transstockdet_1_uomcode']").val('');
      $("input[name='transstockdet_1_description']").val('');
			$('#InputDialogtransstockdet').modal();
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='transstock_0_transstockid']").val(data.transstockid);
				$("input[name='transstock_0_slocfromid']").val(data.slocfromid);
      $("input[name='transstock_0_sloctoid']").val(data.sloctoid);
      $("input[name='transstock_0_docdate']").val(data.docdate);
      $("textarea[name='transstock_0_headernote']").val(data.headernote);
      $("input[name='transstock_0_deliveryadviceid']").val(data.deliveryadviceid);
      $("input[name='transstock_0_sloccode']").val(data.sloccode);
      $("input[name='transstock_0_sloccode']").val(data.sloccode);
      $("input[name='transstock_0_dano']").val(data.dano);
				$.fn.yiiGridView.update('transstockdetList',{data:{'transstockid':data.transstockid}});

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
function updatedatatransstockdet($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/updatetransstockdet')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='transstockdet_1_productid']").val(data.productid);
      $("input[name='transstockdet_1_storagebinid']").val(data.storagebinid);
      $("input[name='transstockdet_1_unitofmeasureid']").val(data.unitofmeasureid);
      $("input[name='transstockdet_1_qty']").val(data.qty);
      $("input[name='transstockdet_1_storagebintoid']").val(data.storagebintoid);
      $("textarea[name='transstockdet_1_itemtext']").val(data.itemtext);
      $("input[name='transstockdet_1_productname']").val(data.productname);
      $("input[name='transstockdet_1_description']").val(data.description);
      $("input[name='transstockdet_1_uomcode']").val(data.uomcode);
      $("input[name='transstockdet_1_description']").val(data.description);
			$('#InputDialogtransstockdet').modal();
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

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/save')?>',
		'data':{
			'transstockid':$("input[name='transstock_0_transstockid']").val(),
			'slocfromid':$("input[name='transstock_0_slocfromid']").val(),
      'sloctoid':$("input[name='transstock_0_sloctoid']").val(),
      'docdate':$("input[name='transstock_0_docdate']").val(),
      'headernote':$("textarea[name='transstock_0_headernote']").val(),
      'deliveryadviceid':$("input[name='transstock_0_deliveryadviceid']").val(),
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

function savedatatransstockdet()
{

	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/savetransstockdet')?>',
		'data':{
			'transstockid':$("input[name='transstock_0_transstockid']").val(),
			'productid':$("input[name='transstockdet_1_productid']").val(),
      'storagebinid':$("input[name='transstockdet_1_storagebinid']").val(),
      'unitofmeasureid':$("input[name='transstockdet_1_unitofmeasureid']").val(),
      'qty':$("input[name='transstockdet_1_qty']").val(),
      'storagebintoid':$("input[name='transstockdet_1_storagebintoid']").val(),
      'itemtext':$("textarea[name='transstockdet_1_itemtext']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialogtransstockdet').modal('hide');
				toastr.info(data.div);
				$.fn.yiiGridView.update("transstockdetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function tampil_loading() {
  $(".ajax-loader").css("visibility", "visible");
}

function tutup_loading() {
  $(".ajax-loader").css("visibility", "hidden");
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
    $(".ajax-loader").css("visibility", "visible");
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/approve')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
        		tutup_loading();
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
        		tutup_loading();
				toastr.error(data.div);
			}
		},
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/delete')?>',
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
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/purge')?>','data':{'id':$id},
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
function purgedatatransstockdet()
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/transstockin/purgetransstockdet')?>','data':{'id':$.fn.yiiGridView.getSelection("transstockdetList")},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("transstockdetList");
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
	var array = 'transstockid='+$id
+ '&transstockno='+$("input[name='dlg_search_transstockno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&dano='+$("input[name='dlg_search_dano']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'transstockid='+$id
+ '&transstockno='+$("input[name='dlg_search_transstockno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&dano='+$("input[name='dlg_search_dano']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/transstockin/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'transstockid='+$id
+ '&transstockno='+$("input[name='dlg_search_transstockno']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&dano='+$("input[name='dlg_search_dano']").val();
	window.open('<?php echo Yii::app()->createUrl('Inventory/transstockin/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'transstockid='+$id
$.fn.yiiGridView.update("DetailtransstockdetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('transstockin') ?></h3>
<?php if ($this->checkAccess('transstockin','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('transstockin','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('transstockin','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('transstockin','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('transstockin','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('transstockin','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('transstockin','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('transstockid'),
					'name'=>'transstockid',
					'value'=>'$data["transstockid"]'
				),
							array(
					'header'=>$this->getCatalog('transstockno'),
					'name'=>'transstockno',
					'value'=>'$data["transstockno"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocfromid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'sloctoid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
				),
							array(
					'header'=>$this->getCatalog('dano'),
					'name'=>'deliveryadviceid',
					'value'=>'$data["dano"]'
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
						<label for="dlg_search_transstockno"><?php echo $this->getCatalog('transstockno')?></label>
						<input type="text" class="form-control" name="dlg_search_transstockno">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_dano"><?php echo $this->getCatalog('dano')?></label>
						<input type="text" class="form-control" name="dlg_search_dano">
					</div>
          <div class="form-group">
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
						<input type="text" class="form-control" name="dlg_search_description">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('transstockin') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="transstock_0_transstockid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transstock_0_sloctoid','ColField'=>'transstock_0_sloccode',
							'IDDialog'=>'transstock_0_sloctoid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'transstock_0_sloctoidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transstock_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="transstock_0_docdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transstock_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="transstock_0_headernote"></textarea>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transstock_0_deliveryadviceid','ColField'=>'transstock_0_dano',
							'IDDialog'=>'transstock_0_deliveryadviceid_dialog','titledialog'=>$this->getCatalog('dano'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.GiheaderPopUp','PopGrid'=>'transstock_0_deliveryadviceidgrid')); 
					?>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#transstockdet"><?php echo $this->getCatalog("transstockdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="transstockdet" class="tab-pane">
<?php if ($this->checkAccess('transstockin','ispurge')) { ?>
<button name="PurgeButtontransstockdet" type="button" class="btn btn-danger" onclick="purgedatatransstockdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidertransstockdet,
		'id'=>'transstockdetList',
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
							'visible'=>$this->booltostr($this->checkAccess('transstockin','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatatransstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('transstockin','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatatransstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('transstockdetid'),
					'name'=>'transstockdetid',
					'value'=>'$data["transstockdetid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('storagebinto'),
					'name'=>'storagebintoid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('deliveryadvicedetailid'),
					'name'=>'deliveryadvicedetailid',
					'value'=>'$data["deliveryadvicedetailid"]'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('transstockdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidertransstockdet,
		'id'=>'DetailtransstockdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('transstockdetid'),
					'name'=>'transstockdetid',
					'value'=>'$data["transstockdetid"]'
				),
							array(
					'header'=>$this->getCatalog('product'),
					'name'=>'productid',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('storagebin'),
					'name'=>'storagebinid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
							array(
					'header'=>$this->getCatalog('storagebinto'),
					'name'=>'storagebintoid',
					'value'=>'$data["description"]'
				),
							array(
					'header'=>$this->getCatalog('deliveryadvicedetailid'),
					'name'=>'deliveryadvicedetailid',
					'value'=>'$data["deliveryadvicedetailid"]'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogtransstockdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('transstockdet') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="transstockdet_1_productid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transstockdet_1_storagebinid','ColField'=>'transstockdet_1_description',
							'IDDialog'=>'transstockdet_1_storagebinid_dialog','titledialog'=>$this->getCatalog('storagebin'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'transstockdet_1_storagebinidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transstockdet_1_unitofmeasureid','ColField'=>'transstockdet_1_uomcode',
							'IDDialog'=>'transstockdet_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'transstockdet_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transstockdet_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="transstockdet_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'transstockdet_1_storagebintoid','ColField'=>'transstockdet_1_description',
							'IDDialog'=>'transstockdet_1_storagebintoid_dialog','titledialog'=>$this->getCatalog('storagebinto'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.StoragebinPopUp','PopGrid'=>'transstockdet_1_storagebintoidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="transstockdet_1_itemtext"><?php echo $this->getCatalog('itemtext')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="transstockdet_1_itemtext"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatatransstockdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			