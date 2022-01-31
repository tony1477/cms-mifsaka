<script src="<?php echo Yii::app()->baseUrl;?>/js/reportso.js"></script>
<h3><?php echo $this->getCatalog('reportso') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('soheader','isdownload')) { ?>
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
		'rowCssClassExpression'=>'
			($data["warna"] == "1")?"bg-red":(($data["warna"] == "2")?"bg-orange":(($data["warna"] == "3")?"bg-yellow":"bg-white"))
		',
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
							'visible'=>$this->booltostr($this->checkAccess('soheader','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('soheaderid'),
				'name'=>'soheaderid',
				'value'=>'$data["soheaderid"]'
			),
			array(
				'header'=>$this->getCatalog('sodate'),
				'name'=>'sodate',
				'value'=>'Yii::app()->format->formatDate($data["sodate"])'
			),
			array(
				'header'=>$this->getCatalog('company'),
				'name'=>'companyid',
				'value'=>'$data["companyname"]'
			),
			array(
				'header'=>$this->getCatalog('docno'),
				'name'=>'sono',
				'value'=>'$data["sono"]'
			),
			array(
				'header'=>$this->getCatalog('customer'),
				'name'=>'addressbookid',
				'value'=>'$data["fullname"]'
			),
			array(
				'header'=>$this->getCatalog('pocustno'),
				'name'=>'pocustno',
				'value'=>'$data["pocustno"]'
			),
			array(
				'header'=>$this->getCatalog('sales'),
				'name'=>'employeeid',
				'value'=>'$data["salesname"]'
			),
			array(
				'header'=>$this->getCatalog('currentlimit'),
				'name'=>'currentlimit',
				'value'=>'Yii::app()->format->formatCurrency($data["currentlimit"])'
			),
			array(
				'header'=>$this->getCatalog('creditlimit'),
				'name'=>'creditlimit',
				'value'=>'Yii::app()->format->formatCurrency($data["creditlimit"])'
			),
			array(
				'header'=>$this->getCatalog('top'),
				'name'=>'top',
				'value'=>'$data["top"]'
			),
			array(
				'header'=>$this->getCatalog('paycode'),
				'name'=>'paycode',
				'value'=>'$data["paycode"]'
			),
			array(
				'header'=>$this->getCatalog('pendinganso'),
				'name'=>'pendinganso',
				'value'=>'Yii::app()->format->formatCurrency($data["pendinganso"])'
			),
			array(
				'header'=>$this->getCatalog('totalaftdisc'),
				'name'=>'totalaftdisc',
				'value'=>'Yii::app()->format->formatCurrency($data["totalaftdisc"])'
			),
			array(
				'header'=>$this->getCatalog('recordstatus'),
				'name'=>'recordstatus',
				'value'=>'$data["statusname"]'
			),
			array(
				'header'=>$this->getCatalog('createddate'),
				'name'=>'createddate',
				'value'=>'$data["createddate"]'
			),
			array(
				'header'=>$this->getCatalog('updatedate'),
				'name'=>'updatedate',
				'value'=>'$data["updatedate"]'
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
					    'dataProvider'=>$dataProvidersodetail,
							'id'=>'DetailSodetailList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
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
									'header'=>$this->getCatalog('giqty'),
									'name'=>'giqty',
									'type'=>'raw',
									'value'=>'CHtml::image(Yii::app()->baseUrl.(($data["qty"] > $data["giqty"])?"/images/basket-remove.png":"/images/basket-accept.png"),"",
									array("width"=>"30")) .Yii::app()->format->formatNumber($data["giqty"])'
								),
								array(
									'header'=>$this->getCatalog('qtystock'),
									'name'=>'qtystock',
									'type'=>'raw',
									'value'=>'CHtml::image(Yii::app()->baseUrl.(($data["qtystock"] <= 0)?"/images/empty.png":"/images/full.png"),"",
									array("width"=>"30")) . Yii::app()->format->formatNumber($data["qtystock"])'
								),
								array(
									'header'=>$this->getCatalog('unitofmeasure'),
									'name'=>'unitofmeasureid',
									'value'=>'$data["uomcode"]'
								),
								array(
									'header'=>$this->getCatalog('sloc'),
									'name'=>'slocid',
									'value'=>'$data["sloccode"]'
								),
								array(
									'header'=>$this->getCatalog('price'),
									'name'=>'price',
									'value'=>'Yii::app()->format->formatCurrency($data["price"])'
								),
								array(
									'header'=>$this->getCatalog('currencyrate'),
									'name'=>'currencyrate',
									'value'=>'Yii::app()->format->formatCurrency($data["currencyrate"])'
								),
								array(
									'header'=>$this->getCatalog('total'),
									'name'=>'total',
									'type'=>'raw',
									'value'=>'Yii::app()->format->formatCurrency($data["total"])'
								),
								array(
									'header'=>$this->getCatalog('itemnote'),
									'name'=>'itemnote',
									'value'=>'$data["itemnote"]'
								),
							)
					));
					?>
				</div>
			</div>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Discount</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php
						$this->widget('zii.widgets.grid.CGridView', array(
					    'dataProvider'=>$dataProvidersodisc,
							'id'=>'DetailSodiscList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('discvalue'),
									'name'=>'discvalue',
									'value'=>'Yii::app()->format->formatNumber($data["discvalue"])'
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
					<label for="dlg_search_fullname"><?php echo $this->getCatalog('customer')?></label>
					<input type="text" class="form-control" name="dlg_search_fullname">
				</div>
				<div class="form-group">
					<label for="dlg_search_companyname"><?php echo $this->getCatalog('companyname')?></label>
					<input type="text" class="form-control" name="dlg_search_companyname">
				</div>
				<div class="form-group">
					<label for="dlg_search_salesname"><?php echo $this->getCatalog('sales')?></label>
					<input type="text" class="form-control" name="dlg_search_salesname">
				</div>
				<div class="form-group">
					<label for="dlg_search_pocustno"><?php echo $this->getCatalog('pocustno')?></label>
					<input type="text" class="form-control" name="dlg_search_pocustno">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search') ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
			</div>
		</div>
	</div>
</div>