<script src="<?php echo Yii::app()->baseUrl;?>/js/reppaymenttarget.js"></script>
<h3><?php echo $this->getCatalog('reppaymenttarget') ?></h3>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('paymenttarget','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('paymenttarget','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
			array(
				'header'=>$this->getCatalog('paymenttargetid'),
				'name'=>'paymenttargetid',
				'value'=>'$data["paymenttargetid"]'
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
					    'dataProvider'=>$dataProviderpaymenttargetdet,
							'id'=>'DetailpaymenttargetdetList',
					    'ajaxUpdate'=>true,
							'filter'=>null,
							'enableSorting'=>true,
							'columns'=>array(
								array(
									'header'=>$this->getCatalog('custcategory'),
									'name'=>'custcategoryid',
									'value'=>'$data["custcategoryname"]'
								),
                                array(
									'header'=>$this->getCatalog('customer'),
									'name'=>'addressbookid',
									'value'=>'$data["fullname"]'
								),
								array(
									'header'=>$this->getCatalog('gt30'),
									'name'=>'gt30',
									'value'=>'Yii::app()->format->formatNumber($data["gt30"])'
								),
                                array(
									'header'=>$this->getCatalog('gt15'),
									'name'=>'gt15',
									'value'=>'Yii::app()->format->formatNumber($data["gt15"])'
								),
								array(
									'header'=>$this->getCatalog('gt7'),
									'name'=>'gt7',
									'value'=>'Yii::app()->format->formatNumber($data["gt7"])'
								),
								
								array(
									'header'=>$this->getCatalog('gt0'),
									'name'=>'gt0',
									'value'=>'Yii::app()->format->formatNumber($data["gt0"])'
								),
                                array(
									'header'=>$this->getCatalog('x0'),
									'name'=>'x0',
									'value'=>'Yii::app()->format->formatNumber($data["x0"])'
								),
                                array(
									'header'=>$this->getCatalog('lt0'),
									'name'=>'lt0',
									'value'=>'Yii::app()->format->formatNumber($data["lt0"])'
								),
                                array(
									'header'=>$this->getCatalog('lt14'),
									'name'=>'lt14',
									'value'=>'Yii::app()->format->formatNumber($data["lt14"])'
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
					<label for="dlg_search_customer"><?php echo $this->getCatalog('sales')?></label>
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