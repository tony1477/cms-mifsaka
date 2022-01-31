<?php
	$sqldata="select b.gino, b.giheaderid, b.headernote
from giheader b  
where b.giheaderid in 
(
select a.giheaderid 
from giretur a 
)
and b.gino like '%".(isset($_REQUEST['gino'])?$_REQUEST['gino']:'')."%' AND recordstatus='3' 
 " 
;
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'giheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'giheaderid', 'gino',
        ),
				'defaultOrder' => array( 
					'a.giheaderid' => CSort::SORT_DESC
				),
			),
		));
?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/js/mrogi.js"></script>
<h3><?php echo $this->getCatalog('mrogi') ?></h3>
<?php if ($this->checkAccess('mrogi','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('mrogi','isdownload')) { ?>
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
				'template'=>'{select} {edit} {purge} {pdf}',
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
							'visible'=>$this->booltostr($this->checkAccess('mrogi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('mrogiheaderid'),
					'name'=>'mrogiheaderid',
					'value'=>'$data["mrogiheaderid"]'
				),
							array(
					'header'=>$this->getCatalog('mrogino'),
					'name'=>'mrogino',
					'value'=>'$data["mrogino"]'
				),
							array(
					'header'=>$this->getCatalog('mrogidate'),
					'name'=>'mrogidate',
					'value'=>'Yii::app()->format->formatDate($data["mrogidate"])'
				),
							array(
					'header'=>$this->getCatalog('gino'),
					'name'=>'giheaderid',
					'value'=>'$data["gino"]'
				),
							array(
					'header'=>$this->getCatalog('shipto'),
					'name'=>'shipto',
					'value'=>'$data["shipto"]'
				),
							array(
					'header'=>$this->getCatalog('headernote'),
					'name'=>'headernote',
					'value'=>'$data["headernote"]'
				),
							array(
					'header'=>$this->getCatalog('statusname'),
					'name'=>'statusname',
					'value'=>'$data["statusname"]'
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
						<label for="dlg_search_mrogino"><?php echo $this->getCatalog('mrogino')?></label>
						<input type="text" class="form-control" name="dlg_search_mrogino">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('mrogi') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="mrogiheader_0_mrogiheaderid">
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_mrogidate"><?php echo $this->getCatalog('mrogidate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="mrogiheader_0_mrogidate">
						</div>
					</div>
        <!-- -->
							
        <div class="row">
	<div class="form-group>">
		<label class=" control-label" for="<?php echo $this->ColField; ?>"><?php echo $this->titledialog ?></label>
	</div>
	<div class="<?php echo $this->classtypebox ?>">
		<input name="<?php echo $this->IDField ?>" type="hidden" value="">
		<div class="input-group">
			<input type="text" name="<?php echo $this->ColField ?>" readonly class="form-control">
			<span class="input-group-btn">
				<button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><span class="glyphicon glyphicon-modal-window"></span></button>
				<button name="<?php echo $this->IDField?>ClearButton" type="button" class="btn btn-danger" onclick="<?php echo $this->IDField?>ClearButtonClick()"><span class="glyphicon glyphicon-remove"></span></button>
			</span>
		</div>
	</div>
</div>
	
<div id="mrogiheader_0_giheaderid_dialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">	
	 <div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" href="#mrogiheader_0_giheaderid_dialog">&times;</button>
        <h4 class="modal-title"><?php echo $this->titledialog ?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_gino"><?php echo $this->getCatalog('gino') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_gino" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			
			
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('giheaderid'),
						'name'=>'giheaderid', 
						'value'=>'$data["giheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('gino'),
						'name'=>'gino', 
						'value'=>'$data["gino"]',
					),
                    array(
						'header'=>$this->getCatalog('headernote'),
						'name'=>'headernote', 
						'value'=>'$data["headernote"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
    </div></div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_shipto"><?php echo $this->getCatalog('shipto')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogiheader_0_shipto"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogiheader_0_headernote"><?php echo $this->getCatalog('headernote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogiheader_0_headernote"></textarea>
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#mrogidetail"><?php echo $this->getCatalog("mrogidetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="mrogidetail" class="tab-pane">
	<?php if ($this->checkAccess('mrogi','iswrite')) { ?>
<button name="CreateButtonmrogidetail" type="button" class="btn btn-primary" onclick="newdatamrogidetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('mrogi','ispurge')) { ?>
<button name="PurgeButtonmrogidetail" type="button" class="btn btn-danger" onclick="purgedatamrogidetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidermrogidetail,
		'id'=>'mrogidetailList',
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
							'visible'=>$this->booltostr($this->checkAccess('mrogi','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedatamrogidetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('mrogi','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatamrogidetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('mrogidetailid'),
					'name'=>'mrogidetailid',
					'value'=>'$data["mrogidetailid"]'
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
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
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
		<h3 class="box-title"><?php echo $this->getCatalog('mrogidetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvidermrogidetail,
		'id'=>'DetailmrogidetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('mrogidetailid'),
					'name'=>'mrogidetailid',
					'value'=>'$data["mrogidetailid"]'
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
					'header'=>$this->getCatalog('unitofmeasure'),
					'name'=>'unitofmeasureid',
					'value'=>'$data["uomcode"]'
				),
							array(
					'header'=>$this->getCatalog('netprice'),
					'name'=>'netprice',
					'value'=>'Yii::app()->format->formatNumber($data["netprice"])'
				),
							array(
					'header'=>$this->getCatalog('itemnote'),
					'name'=>'itemnote',
					'value'=>'$data["itemnote"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogmrogidetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('mrogidetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="mrogidetail_1_mrogidetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrogidetail_1_productid','ColField'=>'mrogidetail_1_productname',
							'IDDialog'=>'mrogidetail_1_productid_dialog','titledialog'=>$this->getCatalog('product'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.ProductPopUp','PopGrid'=>'mrogidetail_1_productidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_qty"><?php echo $this->getCatalog('qty')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrogidetail_1_qty">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'mrogidetail_1_unitofmeasureid','ColField'=>'mrogidetail_1_uomcode',
							'IDDialog'=>'mrogidetail_1_unitofmeasureid_dialog','titledialog'=>$this->getCatalog('unitofmeasure'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.UomPopUp','PopGrid'=>'mrogidetail_1_unitofmeasureidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_netprice"><?php echo $this->getCatalog('netprice')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="mrogidetail_1_netprice">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="mrogidetail_1_itemnote"><?php echo $this->getCatalog('itemnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="mrogidetail_1_itemnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatamrogidetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			