<script src="<?php echo Yii::app()->baseUrl;?>/js/ttnt.js"></script>
<script type="text/javascript">
function getdatacustomer()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/customer/getdata')?>',
		'data':{'id':$("input[name='addressbookid']").val()},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='shiptoid']").val(data.shiptoid);
				$("input[name='shiptoname']").val(data.shiptoname);
				$("input[name='billtoid']").val(data.billtoid);
				$("input[name='billtoname']").val(data.billtoname);
			}
		},
		'cache':false});
	return false;
}

function getprice()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('common/productsales/getprice')?>',
		'data':{
			'productid':$("input[name='productid']").val(),
			'unitofmeasureid':$("input[name='unitofmeasureid']").val(),
			'addressbookid':$("input[name='addressbookid']").val(),
			'currencyid':$("input[name='currencyid']").val(),
			},
		'type':'post','dataType':'json',
		'success':function(data) {
				$("input[name='price']").val(data.currencyvalue)
		},
		'cache':false});
}
function getinvoicedata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('order/ttnt/getinvoice')?>',
		'data': {
		'invoiceid':$("input[name='invoiceid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='fullname']").val(data.fullname);
				$("input[name='invoiceno']").val(data.invoiceno);
				$("input[name='amount']").val(data.amount);
				$("input[name='payamount']").val(data.payamount);
				$("input[name='gino']").val(data.gino);
				$("input[name='sono']").val(data.sono);
				$("input[name='invoiceid']").val(data.invoiceid);
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
function getproductdata() {
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('common/productplant/getproductplant')?>',
		'data': {
		'productid':$("input[name='productid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='unitofmeasureid']").val(data.uomid);
				$("input[name='uomcode']").val(data.uomcode);
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
function getmultiinvoice()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/ttnt/getmultiinvoice')?>',
		'data':{
			'invoiceid':$("input[name='multiinvoiceid']").val(),
			'ttntid':$("input[name='ttntid']").val(),
			},
		'type':'post','dataType':'json',
		'success':function(data) {
				$.fn.yiiGridView.update("TtntdetailList");
		},
		'cache':false});
}
</script>

<h3><?php echo $this->getCatalog('ttnt') ?></h3>

<?php if ($this->checkAccess('ttnt','isupload')) { ?>
<?php }?>

<?php if ($this->checkAccess('ttnt','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttnt','ispost')) { ?>
<button name="CreateButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttnt','isreject')) { ?>
<button name="CreateButton" type="button" class="btn btn-warning" onclick="rejectdata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttnt','ispurge')) { ?>
<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>

<?php if ($this->checkAccess('ttnt','isdownload')) { ?>
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
				'template'=>'{select} {edit} {purge} {pdf}',
				'buttons'=>array
				(
					'select' => array
					(
							'label'=>$this->getCatalog('select'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/detail.png',
							'click'=>"function() { 
								GetDetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('ttnt','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('ttnt','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('ttnt','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('ttntid'),
				'name'=>'ttntid',
				'value'=>'$data["ttntid"]'
			),
			array(
				'header'=>$this->getCatalog('company'),
				'name'=>'companyname',
				'value'=>'$data["companyname"]'
			),
			array(
				'header'=>$this->getCatalog('docdate'),
				'name'=>'docdate',
				'value'=>'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data["docdate"]))'

			),
			array(
				'header'=>$this->getCatalog('docno'),
				'name'=>'docno',
				'value'=>'$data["docno"]'
			),
			array(
				'header'=>$this->getCatalog('sales'),
				'name'=>'fullname',
				'value'=>'$data["fullname"]'
			),
			array(
				'header'=>$this->getCatalog('description'),
				'name'=>'description',
				'value'=>'$data["description"]'
			),
			array(
				'header'=>$this->getCatalog('recordstatus'),
				'name'=>'recordstatus',
				'value'=>'$data["statusname"]'
			),
		)
));
?>

<div id="ShowDetailDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Detail</h3>
						<div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<?php
							$this->widget('zii.widgets.grid.CGridView', array(
				    		'dataProvider'=>$dataProviderttntdetail,
							'id'=>'DetailTtntdetailList',
							'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('invoiceno'),
									'name'=>'invoiceid',
									'value'=>'$data["invoiceno"]'
								),
								array(
									'header'=>$this->getCatalog('customer'),
									'name'=>'fullname',
									'value'=>'$data["fullname"]'
								),
								array(
									'header'=>$this->getCatalog('sales'),
									'name'=>'sales',
									'value'=>'$data["sales"]'
								),
								array(
									'header'=>$this->getCatalog('umur'),
									'name'=>'umur',
									'value'=>'$data["umur"]'
								),
								array(
									'header'=>$this->getCatalog('amount'),
									'name'=>'amount',
									'value'=>'Yii::app()->format->formatNumber($data["amount"])'
								),
								array(
									'header'=>$this->getCatalog('payamount'),
									'name'=>'payamount',
									'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
								),
								array(
									'header'=>$this->getCatalog('gino'),
									'name'=>'gino',
									'value'=>'$data["gino"]'
								),
								array(
									'header'=>$this->getCatalog('sono'),
									'name'=>'sono',
									'value'=>'$data["sono"]'
								),
							)
							));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="dlg_search_docdate"><?php echo $this->getCatalog('docdate')?></label>
					<input type="date" class="form-control" name="dlg_search_docdate">
				</div>
				<div class="form-group">
					<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
					<input type="text" class="form-control" name="dlg_search_companyname">
				</div>
				<div class="form-group">
					<label for="dlg_search_fullname"><?php echo $this->getCatalog('salesname')?></label>
					<input type="text" class="form-control" name="dlg_search_fullname">
				</div>
				<div class="form-group">
					<label for="dlg_search_description"><?php echo $this->getCatalog('description')?></label>
					<input type="text" class="form-control" name="dlg_search_description">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>

<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
	    <div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $this->getCatalog('ttnt') ?></h4>
			</div>
			<div class="modal-body">
						<input type="hidden" class="form-control" name="actiontype">
						<input type="hidden" class="form-control" name="ttntid">
						<input type="hidden" class="form-control" name="recordstatus">
						<div class="row">
							<div class="col-md-4">
								<label for="docdate"><?php echo $this->getCatalog('docdate')?></label>
							</div>
							<div class="col-md-8">
								<input type="date" class="form-control" name="docdate">
							</div>
						</div>
						<?php $this->widget('DataPopUp',
							array('id'=>'Widget','IDField'=>'companyid','ColField'=>'companyname',
								'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),
								'classtype'=>'col-md-4',
								'classtypebox'=>'col-md-8',
								'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'companygrid')); 
						?>
						<?php $this->widget('DataPopUp',
							array('id'=>'Widget','IDField'=>'employeeid','ColField'=>'fullname',
								'IDDialog'=>'sales_dialog','titledialog'=>$this->getCatalog('sales'),'classtype'=>'col-md-4',
								'classtypebox'=>'col-md-8',
								'PopUpName'=>'common.components.views.SalesPopUp','PopGrid'=>'salesgrid')); 
						?>						
						<div class="row">
							<div class="col-md-4">
								<label for="description"><?php echo $this->getCatalog('description')?></label>
							</div>
							<div class="col-md-8">
								<textarea type="text" class="form-control" name="description" rows="5"></textarea>
							</div>
						</div>
						<ul class="nav nav-tabs">
							<li><a data-toggle="tab" href="#ttntdetail">Detail</a></li>
						</ul>
				<div class="tab-content">
					<div id="ttntdetail" class="tab-pane">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Detail</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div><!-- /.box-header -->
							<div class="box-body">
								<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdatattntdetail()"><?php echo $this->getCatalog('new')?></button>
								<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedatattntdetail($.fn.yiiGridView.getSelection('TtntdetailList'))"><?php echo $this->getCatalog('purge')?></button>
								<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'multiinvoiceid','ColField'=>'multiinvoiceno',
							'IDDialog'=>'multi_invoice_dialog','titledialog'=>$this->getCatalog('multiinvoice'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.MultiinvoicearcomPopUp','PopGrid'=>'multiinvoicegrid',
							'onaftersign'=>'getmultiinvoice();')); 
					?>
								
							    <?php
									$this->widget('zii.widgets.grid.CGridView', array(
								    'dataProvider'=>$dataProviderttntdetail,
										'id'=>'TtntdetailList',
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
												'template'=>'{edit} {purge}',
												'htmlOptions' => array('style'=>'width:80px'),
												'buttons'=>array
												(
													'edit' => array
													(
															'label'=>$this->getCatalog('edit'),
															'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
															'visible'=>'true',							
															'url'=>'"#"',
															'click'=>"function() { 
																updatedatattntdetail($(this).parent().parent().children(':nth-child(3)').text());
															}",
													),
													'purge' => array
													(
															'label'=>$this->getCatalog('purge'),
															'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
															'visible'=>'true',							
															'url'=>'"#"',
															'click'=>"function() { 
																purgedatattntdetail($(this).parent().parent().children(':nth-child(3)').text());
															}",
													),
												),
											),
											array(
												'header'=>$this->getCatalog('ttntdetailid'),
												'name'=>'ttntdetailid',
												'value'=>'$data["ttntdetailid"]'
											),
											array(
												'header'=>$this->getCatalog('fullname'),
												'name'=>'fullname',
												'value'=>'$data["fullname"]'
											),
											array(
												'header'=>$this->getCatalog('invoiceno'),
												'name'=>'invoiceno',
												'value'=>'$data["invoiceno"]'
											),
											array(
									'header'=>$this->getCatalog('sales'),
									'name'=>'sales',
									'value'=>'$data["sales"]'
								),
								array(
									'header'=>$this->getCatalog('umur'),
									'name'=>'umur',
									'value'=>'$data["umur"]'
								),
											array(
												'header'=>$this->getCatalog('amount'),
												'name'=>'amount',
												'value'=>'Yii::app()->format->formatNumber($data["amount"])'
											),
											array(
												'header'=>$this->getCatalog('payamount'),
												'name'=>'payamount',
												'value'=>'Yii::app()->format->formatNumber($data["payamount"])'
											),

											array(
												'header'=>$this->getCatalog('gino'),
												'name'=>'gino',
												'value'=>'$data["gino"]'
											),
											array(
												'header'=>$this->getCatalog('sono'),
												'name'=>'sono',
												'value'=>'$data["sono"]'
											),
										)
									));
								?>
							</div> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save') ?></button>
					<button type="button" class="btn btn-default" onclick="closedata()"><?php echo $this->getCatalog('close') ?></button>
				</div>
			</div>
		</div>
	</div>

	<div id="TtntdetailDialog" class="modal fade" role="dialog">
		<div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $this->getCatalog('ttntdetail') ?></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="ttntdetailid">

					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'invoiceid','ColField'=>'invoiceno',
							'IDDialog'=>'invoice_dialog','titledialog'=>$this->getCatalog('invoice'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'companyid',
							'PopUpName'=>'accounting.components.views.InvoicearcomPopUp','PopGrid'=>'invoicegrid',
							'onaftersign'=>'getinvoicedata();')); 
					?>

					<div class="row">
						<div class="col-md-4">
							<label for="customer"><?php echo $this->getCatalog('customer')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="customer" disabled="disable">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label for="amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="amount" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label for="payamount"><?php echo $this->getCatalog('payamount')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="payamount" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label for="gino"><?php echo $this->getCatalog('gino')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="gino" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label for="sono"><?php echo $this->getCatalog('sono')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="sono" disabled>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="savedatattntdetail()"><?php echo $this->getCatalog('save') ?></button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
				</div>
		    </div>
		</div>
	</div>

</div>