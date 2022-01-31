<script src="<?php echo Yii::app()->baseUrl;?>/js/repsalestarget.js"></script>
<h3><?php echo $this->getCatalog('repsalestarget') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('salestarget','isdownload')) { ?>
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
				'template'=>'{select}{pdf}',
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
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('salestarget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('salestargetid'),
				'name'=>'salestargetid',
				'value'=>'$data["salestargetid"]'
			),
			array(
				'header'=>$this->getCatalog('company'),
				'name'=>'companyid',
				'value'=>'$data["companyname"]'
			),
			array(
				'header'=>$this->getCatalog('docno'),
				'name'=>'docno',
				'value'=>'$data["docno"]'
			),
			array(
				'header'=>$this->getCatalog('sales'),
				'name'=>'employeeid',
				'value'=>'$data["fullname"]'
			),
			array(
				'header'=>$this->getCatalog('docdate'),
				'name'=>'docdate',
				'value'=>'Yii::app()->format->formatDate($data["docdate"])'
			),
			array(
				'header'=>$this->getCatalog('perioddate'),
				'name'=>'perioddate',
				'value'=>'Yii::app()->format->formatDate($data["perioddate"])'
			),
            array(
				'header'=>$this->getCatalog('useraccess'),
				'name'=>'useraccessid',
				'value'=>'$data["username"]'
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
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProvidersalestargetdet,
							'id'=>'DetailsalestargetdetList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('materialgroup'),
									'name'=>'materialgroupid',
									'value'=>'$data["description"]'
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
									'header'=>$this->getCatalog('sloc'),
									'name'=>'slocid',
									'value'=>'$data["sloccode"]'
								),
								array(
									'header'=>$this->getCatalog('unitofmeasure'),
									'name'=>'unitofmeasureid',
									'value'=>'$data["uomcode"]'
								),
								
								array(
									'header'=>$this->getCatalog('price'),
									'name'=>'price',
									'value'=>'Yii::app()->format->formatCurrency($data["price"])'
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
					<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
					<input type="text" class="form-control" name="companyname">
				</div>
				<div class="form-group">
					<label for="dlg_search_salesname"><?php echo $this->getCatalog('sales')?></label>
					<input type="text" class="form-control" name="fullname">
				</div>
				<div class="form-group">
					<label for="dlg_search_pocustno"><?php echo $this->getCatalog('docno')?></label>
					<input type="text" class="form-control" name="docno">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>