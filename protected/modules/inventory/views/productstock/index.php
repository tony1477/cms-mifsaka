<script type="text/javascript">
function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	$.fn.yiiGridView.update("GridList",{data:{
                'productstockid':$id,
		'productname':$("input[name='dlg_search_productname']").val(),
		'sloccode':$("input[name='dlg_search_sloccode']").val(),
                'uomcode':$("input[name='dlg_search_uomcode']").val(),
		'storagebindesc':$("input[name='dlg_search_storagebindesc']").val()	
		
	}});
	return false;
}

function downpdf($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagebindesc='+$("input[name='dlg_search_storagebindesc']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();

	window.open('<?php echo Yii::app()->createUrl('inventory/productstock/downpdf')?>?'+array);
       
}

function downxls($id=0) {
	var array = 'productstockid='+$id
+ '&productname='+$("input[name='dlg_search_productname']").val()
+ '&sloccode='+$("input[name='dlg_search_sloccode']").val()
+ '&storagebindesc='+$("input[name='dlg_search_storagebindesc']").val()
+ '&uomcode='+$("input[name='dlg_search_uomcode']").val();

	window.open('<?php echo Yii::app()->createUrl('inventory/productstock/downxls')?>?'+array);
         
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'productstockid='+$id
$.fn.yiiGridView.update("DetailproductstockdetList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('productstock') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>

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
				'template'=>'{select} {edit} {approve} {delete} {purge}',
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
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'approve' => array
					(
							'label'=>$this->getCatalog('approve'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/approved.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								approvedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
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
							'visible'=>$this->booltostr($this->checkAccess('productstock','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('productstock','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('productstockid'),
					'name'=>'productstockid',
					'value'=>'$data["productstockid"]'
				),
							
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productname',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'sloccode',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('uomcode'),
					'name'=>'uomcode',
					'value'=>'$data["uomcode"]'
				),
                                                        array(
					'header'=>$this->getCatalog('storagebindesc'),
					'name'=>'storagebindesc',
					'value'=>'$data["storagebindesc"]'
				),
				
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),			
							array(
					'header'=>$this->getCatalog('qtyinprogress'),
					'name'=>'qtyinprogress',
					'value'=>'Yii::app()->format->formatNumber($data["qtyinprogress"])'
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_description"><?php echo $this->getCatalog('uomcode')?></label>
						<input type="text" class="form-control" name="dlg_search_uomcode">
					</div>
          <div class="form-group">
						<label for="dlg_search_uomcode"><?php echo $this->getCatalog('storagebindesc')?></label>
						<input type="text" class="form-control" name="dlg_search_storagebindesc">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('productstock') ?></h4>
      </div>
      <div class="modal-body">
				
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#productstockdet"><?php echo $this->getCatalog("productstockdet")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="productstockdet" class="tab-pane">
	<?php if ($this->checkAccess('productstock','iswrite')) { ?>
<button name="CreateButtonproductstockdet" type="button" class="btn btn-primary" onclick="newdataproductstockdet()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('productstock','ispurge')) { ?>
<button name="PurgeButtonproductstockdet" type="button" class="btn btn-danger" onclick="purgedataproductstockdet()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductstockdet,
		'id'=>'productstockdetList',
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
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedataproductstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedataproductstockdet($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('productstockdetid'),
					'name'=>'productstockdetid',
					'value'=>'$data["productstockdetid"]'
				),
                                                        array(
					'header'=>$this->getCatalog('referenceno'),
					'name'=>'referenceno',
					'value'=>'$data["referenceno"]'
				),
				
							array(
					'header'=>$this->getCatalog('transdate'),
					'name'=>'transdate',
					'value'=>'Yii::app()->format->formatDate($data["transdate"])'
				),
							array(
					'header'=>$this->getCatalog('qty'),
					'name'=>'qtydet',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('productstockdet')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderproductstockdet,
		'id'=>'DetailproductstockdetList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
                                                array(
					'header'=>$this->getCatalog('productstockdetid'),
					'name'=>'productstockdetid',
					'value'=>'$data["productstockdetid"]'
				),
					         array(
					'header'=>$this->getCatalog('referenceno'),
					'name'=>'referenceno',
					'value'=>'$data["referenceno"]'
				),	
                    		array(
					'header'=>$this->getCatalog('transdate'),
					'name'=>'transdate',
					'value'=>'$data["transdate"]'
				),
							array(
					'header'=>$this->getCatalog('qtydet'),
					'name'=>'qty',
					'value'=>'Yii::app()->format->formatNumber($data["qty"])'
				),
					
						
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogproductstockdet" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('productstockdet') ?></h4>
      </div>
			<div class="modal-body">
			
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedataproductstockdet()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			