<script type="text/javascript">
if("undefined"==typeof jQuery)throw new Error("Purge's Scan JavaScript requires jQuery");

function savedata()
{

	jQuery.ajax({'url':'purgescan/purgescanbarcode',
		'data':{
			'nobarcode':$("input[name='nobarcode']").val()
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				//$('#InputDialog').modal('hide');
				toastr.info(data.div);
				//$.fn.yiiGridView.update("GridList");
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
			}
			else
			{
                $( "#nobarcode" ).val('');
                $( "#nobarcode" ).focus();
				toastr.error(data.div);
			}
		},
		'cache':false});
}
</script>
<h3><?php echo $this->getCatalog('purgescan') ?></h3>
<form class="form-inline" method="post">
  <div class="form-group">
    <label for="nobarcode">No Barcode:</label>
    <input type="hidden" id="action" name="action" value="add" />
    <input type="text" class="form-control" id="nobarcode" name="nobarcode" autofocus="true" required="required" onchange="savedata()">
  </div>
  <button type="button" class="btn btn-default" onclick="savedata()">Submit</button>
</form><br />
<div class="progress progress-striped active" style="display: none;">
    <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
</div>

<?php
/*	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>1,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
        'selectionChanged'=>'function(id){giheader_0_soheaderidgridonSelectionChange()}',
		'columns'=>array(
							array(
					'header'=>$this->getCatalog('productname'),
					'name'=>'productname',
					'value'=>'$data["productname"]'
				),
							array(
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('qtyso'),
					'name'=>'qty',
					'value'=>'$data["qty"]'
				),
							array(
					'header'=>$this->getCatalog('giqty'),
					'name'=>'giqty',
					'value'=>'$data["giqty"]'
				),
                            array(
					'header'=>$this->getCatalog('qtyscangi'),
					'name'=>'qtyscan',
					'value'=>'$data["qtyscan"]'
				),
		)
));
*/
?>
<!--
<div id="giheader_0_soheaderid_dialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">	
	 <div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" href="#giheader_0_soheaderid_dialog">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('sono');?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_companyname"><?php echo $this->getCatalog('companyname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_companyname" class="form-control">
					<span class="input-group-btn">
						<button name="giheader_0_soheaderidSearchButton" type="button" class="btn btn-primary" onclick="giheader_0_soheaderidsearchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_fullname"><?php echo $this->getCatalog('customer') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_fullname" class="form-control">
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="giheader_0_sono_search_sono"><?php echo $this->getCatalog('docno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="giheader_0_sono_search_sono" class="form-control">
				</div>
			</div>
			</div>
			<?php
        /*
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'giheader_0_soheaderidgrid',
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){giheader_0_soheaderidgridonSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('soheaderid'),
						'name'=>'soheaderid', 
						'value'=>'$data["soheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'sono', 
						'value'=>'$data["sono"]',
					),
                    array(
						'header'=>$this->getCatalog('company'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
					array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
				),
			));
            */ ?>
			</div>
		</div>
	</div>
</div>
-->
