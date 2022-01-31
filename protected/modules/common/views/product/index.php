<script src="<?php echo Yii::app()->baseUrl;?>/js/product.js"></script>
<h3><?php echo $this->getCatalog('product') ?></h3>
<?php if ($this->checkAccess('product','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('product','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('product','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('product','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('product','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('product','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('product','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('product','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('product','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
        array(
					'header'=>$this->getCatalog('productid'),
					'name'=>'productid',
					'value'=>'$data["productid"]'
				),
        array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productname',
					'value'=>'$data["productname"]'
				),
        array(
					'header'=>$this->getCatalog('productpic'),
					'name'=>'productpic',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->baseUrl."/images/product/".$data["productpic"],$data["productpic"],
					array("width"=>"100"))'
				),
        array(
					'header'=>$this->getCatalog('barcode'),
					'name'=>'barcode',
					'value'=>'$data["barcode"]'
				),
        array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isstock',
					'header'=>$this->getCatalog('isstock'),
					'selectableRows'=>'0',
					'checked'=>'$data["isstock"]',                
				),
        array(
					'class'=>'CCheckBoxColumn',
					'name'=>'isfohulbom',
					'header'=>$this->getCatalog('isfohulbom'),
					'selectableRows'=>'0',
					'checked'=>'$data["isfohulbom"]',                
				),
        array(
					'class'=>'CCheckBoxColumn',
					'name'=>'iscontinue',
					'header'=>$this->getCatalog('iscontinue'),
					'selectableRows'=>'0',
					'checked'=>'$data["iscontinue"]',                
				),
        array(
					'header'=>$this->getCatalog('k3lnumber'),
					'name'=>'k3lnumber',
					'value'=>'$data["k3lnumber"]'
				),
        array(
					'header'=>$this->getCatalog('materialtype'),
					'name'=>'materialtypeid',
					'value'=>'$data["description"]'
				),
        array(
					'header'=>$this->getCatalog('productidentity'),
					'name'=>'productidentity',
					'value'=>'$data["identityname"]'
				),
        array(
					'header'=>$this->getCatalog('productbrand'),
					'name'=>'productbrandid',
					'value'=>'$data["brandname"]'
				),
        array(
					'header'=>$this->getCatalog('productcollect'),
					'name'=>'productcollectid',
					'value'=>'$data["collectionname"]'
				),
        array(
					'header'=>$this->getCatalog('productseries'),
					'name'=>'productseriesid',
					'value'=>'$data["seriesdesc"]'
				),
        array(
					'header'=>$this->getCatalog('leadtime'),
					'name'=>'leadtime',
					'value'=>'$data["leadtime"]'
				),
        array(
					'header'=>$this->getCatalog('length'),
					'name'=>'panjang',
					'value'=>'$data["panjang"]'
				),
        array(
					'header'=>$this->getCatalog('width'),
					'name'=>'lebar',
					'value'=>'$data["lebar"]'
				),
        array(
					'header'=>$this->getCatalog('height'),
					'name'=>'tinggi',
					'value'=>'$data["tinggi"]'
				),
        array(
					'header'=>$this->getCatalog('density'),
					'name'=>'density',
					'value'=>'$data["density"]'
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
						<label for="dlg_search_productname"><?php echo $this->getCatalog('productname')?></label>
						<input type="text" class="form-control" name="dlg_search_productname">
					</div>
          <div class="form-group">
						<label for="dlg_search_productpic"><?php echo $this->getCatalog('productpic')?></label>
						<input type="text" class="form-control" name="dlg_search_productpic">
					</div>
          <div class="form-group">
						<label for="dlg_search_barcode"><?php echo $this->getCatalog('barcode')?></label>
						<input type="text" class="form-control" name="dlg_search_barcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_panjang"><?php echo $this->getCatalog('length')?></label>
						<input type="text" class="form-control" name="dlg_search_panjang">
					</div>
          <div class="form-group">
						<label for="dlg_search_lebar"><?php echo $this->getCatalog('width')?></label>
						<input type="text" class="form-control" name="dlg_search_lebar">
					</div>
          <div class="form-group">
						<label for="dlg_search_tinggi"><?php echo $this->getCatalog('height')?></label>
						<input type="text" class="form-control" name="dlg_search_tinggi">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('product') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="product_0_productid">
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_productname"><?php echo $this->getCatalog('productname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="product_0_productname">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_productpic"><?php echo $this->getCatalog('productpic')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="product_0_productpic">
						</div>
					</div>
							
        <script>
				function successUp(param,param2,param3)
				{
					$('input[name="product_0_productpic"]').val(param2);
				}
				</script>
				
				<?php
					$events = array(
						'success' => 'successUp(param,param2,param3)',
					);
					$this->widget('ext.dropzone.EDropzone', array(
						'name'=>'upload',
						'url' => Yii::app()->createUrl('common/product/upload'),
						'mimeTypes' => array('.jpg','.png','.jpeg'),		
						'events' => $events,
						'options' => CMap::mergeArray($this->options, $this->dict ),
						'htmlOptions' => array('style'=>'height:95%; overflow: hidden;'),
					));
				?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_barcode"><?php echo $this->getCatalog('barcode')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="product_0_barcode">
						</div>
					</div>

        <div class="row">
						<div class="col-md-4">
							<label for="product_0_k3lnumber"><?php echo $this->getCatalog('k3lnumber')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="product_0_k3lnumber">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_isstock"><?php echo $this->getCatalog('isstock')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="product_0_isstock">
						</div>
					</div>

        <div class="row">
						<div class="col-md-4">
							<label for="product_0_isfohulbom"><?php echo $this->getCatalog('isfohulbom')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="product_0_isfohulbom">
						</div>
					</div>

        <div class="row">
						<div class="col-md-4">
							<label for="product_0_iscontinue"><?php echo $this->getCatalog('iscontinue')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="product_0_iscontinue">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp', array('id'=>'Widget','IDField'=>'product_0_materialtypeid','ColField'=>'product_0_description',
							'IDDialog'=>'product_0_materialtypeid_dialog','titledialog'=>$this->getCatalog('materialtype'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialtypePopUp','PopGrid'=>'product_0_materialtypeidgrid')); 
					?>

        <?php $this->widget('DataPopUp', array('id'=>'Widget','IDField'=>'product_0_productidentityid','ColField'=>'product_0_identityname',
							'IDDialog'=>'product_0_productidentityid_dialog','titledialog'=>$this->getCatalog('productidentity'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductIdentityPopUp','PopGrid'=>'product_0_productidentityidgrid')); 
					?>

        <?php $this->widget('DataPopUp', array('id'=>'Widget','IDField'=>'product_0_productbrandid','ColField'=>'product_0_brandname',
							'IDDialog'=>'product_0_productbrandid_dialog','titledialog'=>$this->getCatalog('productbrand'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductBrandPopUp','PopGrid'=>'product_0_productbrandidgrid')); 
					?>
        
        <?php $this->widget('DataPopUp', array('id'=>'Widget','IDField'=>'product_0_productcollectid','ColField'=>'product_0_collectionname',
							'IDDialog'=>'product_0_productcollectid_dialog','titledialog'=>$this->getCatalog('productcollect'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductCollectionPopUp','PopGrid'=>'product_0_productcollectidgrid')); 
					?>

        <?php $this->widget('DataPopUp', array('id'=>'Widget','IDField'=>'product_0_productseriesid','ColField'=>'product_0_seriesdesc',
							'IDDialog'=>'product_0_productseriesid_dialog','titledialog'=>$this->getCatalog('productseries'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductSeriesPopUp','PopGrid'=>'product_0_productseriesidgrid')); 
					?>	
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_leadtime"><?php echo $this->getCatalog('leadtime')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" name="product_0_leadtime" class="form-control">
						</div>
					</div>
        
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_panjang"><?php echo $this->getCatalog('length')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" name="product_0_panjang" class="form-control">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_lebar"><?php echo $this->getCatalog('width')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" name="product_0_lebar" class="form-control">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_tinggi"><?php echo $this->getCatalog('height')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" name="product_0_tinggi" class="form-control">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="product_0_density"><?php echo $this->getCatalog('density')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" name="product_0_density" class="form-control">
						</div>
					</div>

        <div class="row">
						<div class="col-md-4">
							<label for="product_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="product_0_recordstatus">
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


