<script src="<?php echo Yii::app()->baseUrl;?>/js/ttf.js"></script>
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
		'url': '<?php echo Yii::app()->createUrl('order/ttf/getinvoice')?>',
		'data': {
		'ttntdetailid':$("input[name='ttntdetailid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='invoiceid']").val(data.invoiceid);
                $("input[name='invoiceno']").val(data.invoiceno);
                $("input[name='fullname']").val(data.fullname);
				
				$("input[name='amount']").val(data.amount);
				$("input[name='payamount']").val(data.payamount);
				$("input[name='gino']").val(data.gino);
				$("input[name='sono']").val(data.sono);
				$("input[name='ttntdetailid']").val(data.ttntdetailid);
				
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
function getmultittnt()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('order/ttf/getmultittnt')?>',
		'data':{
			'ttntdetailid':$("input[name='multittntid']").val(),
			'ttfid':$("input[name='ttfid']").val(),
			},
		'type':'post','dataType':'json',
		'success':function(data) {
				$.fn.yiiGridView.update("TtfdetailList");
		},
		'cache':false});
}
</script>

<h3><?php echo $this->getCatalog('ttf') ?></h3>

<?php if ($this->checkAccess('ttf','isupload')) { ?>
<?php }?>

<?php if ($this->checkAccess('ttf','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttf','ispost')) { ?>
<button name="CreateButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttf','isreject')) { ?>
<button name="CreateButton" type="button" class="btn btn-warning" onclick="rejectdata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>

<?php if ($this->checkAccess('ttf','ispurge')) { ?>
<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>

<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>

<?php if ($this->checkAccess('ttf','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('ttf','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('ttf','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('ttf','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('ttfid'),
				'name'=>'ttfid',
				'value'=>'$data["ttfid"]'
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
				'header'=>$this->getCatalog('ttntno'),
				'name'=>'docno',
				'value'=>'$data["ttntdocno"]'
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
				    		'dataProvider'=>$dataProviderttfdetail,
							'id'=>'DetailTtfdetailList',
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
					<label for="dlg_search_docno"><?php echo $this->getCatalog('docdate')?></label>
					<input type="date" class="form-control" name="dlg_search_docno">
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
				<h4 class="modal-title"><?php echo $this->getCatalog('ttf') ?></h4>
			</div>
			<div class="modal-body">
						<input type="hidden" class="form-control" name="actiontype">
						<input type="hidden" class="form-control" name="ttfid">
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
                  <?php $this->widget('DataPopUp',
							array('id'=>'Widget','IDField'=>'ttntid1','ColField'=>'docno1',
								'IDDialog'=>'ttnt_dialog1','titledialog'=>$this->getCatalog('ttnt'),'classtype'=>'col-md-4',
								'classtypebox'=>'col-md-8','RelationID'=>'employeeid','RelationID2'=>'companyid',
								'PopUpName'=>'order.components.views.TtntPopUp1','PopGrid'=>'ttnt1grid'))
                                ; 
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
							<li><a data-toggle="tab" href="#ttfdetail">Detail</a></li>
						</ul>
				<div class="tab-content">
					<div id="ttfdetail" class="tab-pane">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Detail</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div><!-- /.box-header -->
							<div class="box-body">
								<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdatattfdetail()"><?php echo $this->getCatalog('new')?></button>
								<button name="CreateButton" type="button" class="btn btn-danger" onclick="purgedatattfdetail($.fn.yiiGridView.getSelection('TtfdetailList'))"><?php echo $this->getCatalog('purge')?></button>
								<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'multittntid','ColField'=>'multiinvoiceno',
							'IDDialog'=>'multi_ttnt_dialog','titledialog'=>$this->getCatalog('multittnt'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.MultiTtntPopUp','PopGrid'=>'multittnygrid','RelationID'=>'ttntid1',
							'onaftersign'=>'getmultittnt();')); 
					?>
								
							    <?php
									$this->widget('zii.widgets.grid.CGridView', array(
								    'dataProvider'=>$dataProviderttfdetail,
										'id'=>'TtfdetailList',
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
																updatedatattfdetail($(this).parent().parent().children(':nth-child(3)').text());
															}",
													),
													'purge' => array
													(
															'label'=>$this->getCatalog('purge'),
															'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
															'visible'=>'true',							
															'url'=>'"#"',
															'click'=>"function() { 
																purgedatattfdetail($(this).parent().parent().children(':nth-child(3)').text());
															}",
													),
												),
											),
											array(
												'header'=>$this->getCatalog('ttfdetailid'),
												'name'=>'ttfdetailid',
												'value'=>'$data["ttfdetailid"]'
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

	<div id="TtfdetailDialog" class="modal fade" role="dialog">
		<div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $this->getCatalog('ttf') ?></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="ttfid">
					<input type="hidden" class="form-control" name="ttfdetailid">
					<input type="hidden" class="form-control" name="invoiceid">
                    
					<?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'ttntdetailid','ColField'=>'invoiceno',
							'IDDialog'=>'ttnt_dialog','titledialog'=>$this->getCatalog('ttntdetail'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'order.components.views.TtntPopUp','PopGrid'=>'ttntdetailgrid','RelationID'=>'ttntid1',
                            'RelationID2'=>'employeeid',
							'onaftersign'=>'getinvoicedata();')); 
					?>
					<div class="row">
						<div class="col-md-4">
							<label for="fullname"><?php echo $this->getCatalog('fullname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="fullname" disabled>
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
							<label for="amount"><?php echo $this->getCatalog('amount')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="amount" disabled>
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
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="savedatattfdetail()"><?php echo $this->getCatalog('save') ?></button>
		        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
				</div>
		    </div>
		</div>
	</div>

</div>