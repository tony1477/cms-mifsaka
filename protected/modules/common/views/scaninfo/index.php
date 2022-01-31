<!--<script src="<?php echo Yii::app()->baseUrl;?>/js/productoutput.js"></script>-->
<script type="text/javascript">
if("undefined"==typeof jQuery)throw new Error("Goods Issue's JavaScript requires jQuery");
function searchdata()
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
		'nobarcode':$("input[name='nobarcode']").val()
	}});
	$( "#nobarcode" ).val('');
	$( "#nobarcode" ).focus();
	return false;
}
</script>
<h3><?php echo $this->getCatalog('scaninfo') ?></h3>
<div class="col-md-8">
    <div class="row">
    <div class="col-md-4">
    <label for="nobarcode" class="control-label">No Barcode:</label>
    </div>
    <div class="col-md-8">
    <input type="text" class="form-control" id="nobarcode" name="nobarcode" autofocus="true" required="required" onchange="searchdata()">
    </div>
</div>
  <?php  if ($this->checkAccess('scaninfo','ispost')) { ?>
  <button type="button" class="btn btn-default">Submit</button>
  <?php } ?>
    <br />
<div class="progress progress-striped active" style="display: none;">
    <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
    </div>
    </div>
    <div class="col-md-4"></div>
    <div class="clearfix"></div>
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
				'header'=>$this->getCatalog('tempscanid'),
				'name'=>'tempscanid',
				'value'=>'$data["tempscanid"]'
			),
			array(
				'header'=>$this->getCatalog('barcode'),
				'name'=>'barcode',
				'value'=>'$data["barcode"]'
			),
			array(
				'header'=>$this->getCatalog('productname'),
				'name'=>'productname',
				'value'=>'$data["productname"]'
			),
            array(
				'header'=>$this->getCatalog('uomcode'),
				'name'=>'uomcode',
				'value'=>'$data["uomcode"]'
			),
            array(
				'header'=>$this->getCatalog('qty'),
				'name'=>'qtyori',
				'value'=>'Yii::app()->format->formatNumber($data["qtyori"])'
			),
            array(
				'header'=>$this->getCatalog('sloccode'),
				'name'=>'sloccode',
				'value'=>'$data["sloccode"]'
			),
            array(
				'header'=>$this->getCatalog('storagebin'),
				'name'=>'description',
				'value'=>'$data["description"]'
			),
            array(
				'header'=>$this->getCatalog('productplanno'),
				'name'=>'productplanno',
				'value'=>'$data["productplanno"]'
			),
            array(
				'header'=>$this->getCatalog('productoutputno'),
				'name'=>'productoutputno',
				'value'=>'$data["productoutputno"]'
			),
            array(
				'header'=>$this->getCatalog('dano'),
				'name'=>'dano',
				'value'=>'$data["dano"]'
			),
            array(
				'header'=>$this->getCatalog('transstockno'),
				'name'=>'transstockno',
				'value'=>'$data["transstockno"]'
			),
            array(
				'header'=>$this->getCatalog('sono'),
				'name'=>'sono',
				'value'=>'$data["sono"]'
			),
            array(
				'header'=>$this->getCatalog('gino'),
				'name'=>'gino',
				'value'=>'$data["gino"]'
			),
            array(
				'header'=>$this->getCatalog('uomcode'),
				'name'=>'uomcode',
				'value'=>'$data["uomcode"]'
			),
						array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isscanhp',
				'header'=>$this->getCatalog('isscanhp'),
				'selectableRows'=>'0',
				'checked'=>'$data["isscanhp"]',
				
			),
						array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isapprovehp',
				'header'=>$this->getCatalog('isapprovehp'),
				'selectableRows'=>'0',
				'checked'=>'$data["isapprovehp"]',
					
			),
						array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isscangi',
				'header'=>$this->getCatalog('isscangi'),
				'selectableRows'=>'0',
				'checked'=>'$data["isscangi"]',
				
			),
						array(
				'class'=>'CCheckBoxColumn',
				'name'=>'isapprovegi',
				'header'=>$this->getCatalog('isapprovegi'),
				'selectableRows'=>'0',
				'checked'=>'$data["isapprovegi"]',
				
			),
      
		)
));
?>