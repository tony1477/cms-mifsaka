<script src="<?php echo Yii::app()->baseUrl;?>/js/deliveryadviceproductoutput.js"></script>
<script>
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
						'productid':$("input[name='deliveryadvicedetail_1_productid']").val(),
						'slocid':$("input[name='deliveryadvice_0_slocid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='deliveryadvicedetail_1_unitofmeasureid']").val(data.uomid);
				$("input[name='deliveryadvicedetail_1_uomcode']").val(data.uomcode);
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
</script>
<h3><?php echo $this->getCatalog('deliveryadviceproductoutput') ?></h3>
<?php if ($this->checkAccess('deliveryadviceproductoutput','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('deliveryadviceproductoutput','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('deliveryadviceproductoutput','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('deliveryadviceproductoutput','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('deliveryadviceproductoutput','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
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
							'visible'=>$this->booltostr($this->checkAccess('deliveryadviceproductoutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('deliveryadviceproductoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('deliveryadviceproductoutput','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('deliveryadviceid'),
					'name'=>'deliveryadviceid',
					'value'=>'$data["deliveryadviceid"]'
				),
							array(
					'header'=>$this->getCatalog('dadate'),
					'name'=>'dadate',
					'value'=>'Yii::app()->format->formatDate($data["dadate"])'
				),
							array(
					'header'=>$this->getCatalog('dano'),
					'name'=>'dano',
					'value'=>'$data["dano"]'
				),
							array(
					'header'=>$this->getCatalog('username'),
					'name'=>'useraccessid',
					'value'=>'$data["username"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('productoutputno'),
					'name'=>'productoutputid',
					'value'=>'$data["productoutputno"]'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
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
						<label for="dlg_search_dano"><?php echo $this->getCatalog('dano')?></label>
						<input type="text" class="form-control" name="dlg_search_dano">
					</div>
          <div class="form-group">
						<label for="dlg_search_username"><?php echo $this->getCatalog('username')?></label>
						<input type="text" class="form-control" name="dlg_search_username">
					</div>
          <div class="form-group">
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_productoutputno"><?php echo $this->getCatalog('productoutputno')?></label>
						<input type="text" class="form-control" name="dlg_search_productoutputno">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('deliveryadviceproductoutput') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="deliveryadvice_0_deliveryadviceid">
				<div class="row">
						<div class="col-md-4">
							<label for="deliveryadvice_0_dadate"><?php echo $this->getCatalog('dadate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" rows="5" name="deliveryadvice_0_dadate"></input>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvice_0_slocid','ColField'=>'deliveryadvice_0_sloccode',
							'IDDialog'=>'deliveryadvice_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocUserPopUp','PopGrid'=>'deliveryadvice_0_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvice_0_productoutputid','ColField'=>'deliveryadvice_0_productoutputno',
							'IDDialog'=>'deliveryadvice_0_productoutputid_dialog','titledialog'=>$this->getCatalog('productoutputno'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'production.components.views.ProdoutputPopUp','PopGrid'=>'deliveryadvice_0_productoutputidgrid',
							'onaftersign'=>'generateop();')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="deliveryadvice_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="deliveryadvice_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#deliveryadvicedetail"><?php echo $this->getCatalog("deliveryadvicedetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="deliveryadvicedetail" class="tab-pane">
	<?php if ($this->checkAccess('deliveryadviceproductoutput','iswrite')) { ?>
<button name="CreateButtondeliveryadvicedetail" type="button" class="btn btn-primary" onclick="newdatadeliveryadvicedetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('deliveryadviceproductoutput','isreject')) { ?>
<button name="PurgeButtondeliveryadvicedetail" type="button" class="btn btn-danger" onclick="purgedatadeliveryadvicedetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderdeliveryadvicedetail,
		'id'=>'deliveryadvicedetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('deliveryadviceproductoutput','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatadeliveryadvicedetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('deliveryadviceproductoutput','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatadeliveryadvicedetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('deliveryadvicedetailid'),
					'name'=>'deliveryadvicedetailid',
					'value'=>'$data["deliveryadvicedetailid"]'
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
					'header'=>$this->getCatalog('requestedby'),
					'name'=>'requestedbyid',
					'value'=>'$data["requestedbycode"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							array(
					'header'=>$this->getCatalog('prqty'),
					'name'=>'prqty',
					'value'=>'Yii::app()->format->formatNumber($data["prqty"])'
				),
							array(
					'header'=>$this->getCatalog('giqty'),
					'name'=>'giqty',
					'value'=>'Yii::app()->format->formatNumber($data["giqty"])'
				),
							array(
					'header'=>$this->getCatalog('grqty'),
					'name'=>'grqty',
					'value'=>'Yii::app()->format->formatNumber($data["grqty"])'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('deliveryadvicedetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderdeliveryadvicedetail,
		'id'=>'DetaildeliveryadvicedetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('deliveryadvicedetailid'),
					'name'=>'deliveryadvicedetailid',
					'value'=>'$data["deliveryadvicedetailid"]'
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
					'header'=>$this->getCatalog('requestedby'),
					'name'=>'requestedbyid',
					'value'=>'$data["requestedbycode"]'
				),
							array(
					'header'=>$this->getCatalog('reqdate'),
					'name'=>'reqdate',
					'value'=>'Yii::app()->format->formatDate($data["reqdate"])'
				),
							array(
					'header'=>$this->getCatalog('itemtext'),
					'name'=>'itemtext',
					'value'=>'$data["itemtext"]'
				),
							array(
					'header'=>$this->getCatalog('prqty'),
					'name'=>'prqty',
					'value'=>'Yii::app()->format->formatNumber($data["prqty"])'
				),
							array(
					'header'=>$this->getCatalog('giqty'),
					'name'=>'giqty',
					'value'=>'Yii::app()->format->formatNumber($data["giqty"])'
				),
							array(
					'header'=>$this->getCatalog('grqty'),
					'name'=>'grqty',
					'value'=>'Yii::app()->format->formatNumber($data["grqty"])'
				),
							array(
					'header'=>$this->getCatalog('poqty'),
					'name'=>'poqty',
					'value'=>'Yii::app()->format->formatNumber($data["poqty"])'
				),
							array(
					'header'=>$this->getCatalog('sloc'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
				),
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogdeliveryadvicedetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('deliveryadvicedetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="deliveryadvicedetail_1_deliveryadvicedetailid">
      <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvicedetail_1_productid','ColField'=>'deliveryadvicedetail_1_productname',
							'IDDialog'=>'deliveryadvicedetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'deliveryadvice_0_slocid',							'PopUpName'=>'common.components.views.ProductplantslocPopUp','PopGrid'=>'deliveryadvicedetail_1_productidgrid',
							'onaftersign'=>'getproductdata();')); 
					?>
      <input type="hidden" class="form-control" name="">
        <div class="row">
						<div class="col-md-4">
							<label for="deliveryadvicedetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="deliveryadvicedetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvicedetail_1_unitofmeasureid','ColField'=>'deliveryadvicedetail_1_uomcode',
							'IDDialog'=>'deliveryadvicedetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'deliveryadvicedetail_1_productid',							'PopUpName'=>'common.components.views.UomPlantPopUp','PopGrid'=>'deliveryadvicedetail_1_unitofmeasureidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvicedetail_1_requestedbyid','ColField'=>'deliveryadvicedetail_1_requestedbycode',
							'IDDialog'=>'deliveryadvicedetail_1_requestedbyid_dialog','titledialog'=>$this->getCatalog('requestedby'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'inventory.components.views.RequestedbyPopUp','PopGrid'=>'deliveryadvicedetail_1_requestedbyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="deliveryadvicedetail_1_reqdate"><?php echo $this->getCatalog('reqdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="deliveryadvicedetail_1_reqdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="deliveryadvicedetail_1_itemtext"><?php echo $this->getCatalog('itemtext')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="deliveryadvicedetail_1_itemtext"></textarea>
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'deliveryadvicedetail_1_slocid','ColField'=>'deliveryadvicedetail_1_sloccode',
							'IDDialog'=>'deliveryadvicedetail_1_slocid_dialog','titledialog'=>$this->getCatalog('sloc'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocUserPopUp','PopGrid'=>'deliveryadvicedetail_1_slocidgrid')); 
					?>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatadeliveryadvicedetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			