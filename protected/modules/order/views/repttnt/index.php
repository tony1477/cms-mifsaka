<script src="<?php echo Yii::app()->baseUrl;?>/js/repttnt.js"></script>
<h3><?php echo $this->getCatalog('ttnt') ?></h3>
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
						'classtypebox'=>'col-md-8',
						'PopUpName'=>'accounting.components.views.InvoicearPopUp','PopGrid'=>'invoicegrid',
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