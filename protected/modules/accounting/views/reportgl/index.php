<script type="text/javascript">

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'genjournalid='+$id
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'genjournalid='+$id
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/reportgl/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'genjournalid='+$id
+ '&journalno='+$("input[name='dlg_search_journalno']").val()
+ '&referenceno='+$("input[name='dlg_search_referenceno']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/reportgl/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'genjournalid='+$id
$.fn.yiiGridView.update("DetailjournaldetailList",{data:array});
} 
</script>
<h3><?php echo $this->getCatalog('reportgl') ?></h3>




<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('reportgl','isdownload')) { ?>
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
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
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
							'visible'=>$this->booltostr($this->checkAccess('reportgl','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('genjournalid'),
					'name'=>'genjournalid',
					'value'=>'$data["genjournalid"]'
				),
							array(
					'header'=>$this->getCatalog('companyname'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('journalno'),
					'name'=>'journalno',
					'value'=>'$data["journalno"]'
				),
							array(
					'header'=>$this->getCatalog('referenceno'),
					'name'=>'referenceno',
					'value'=>'$data["referenceno"]'
				),
							array(
					'header'=>$this->getCatalog('journaldate'),
					'name'=>'journaldate',
					'value'=>'Yii::app()->format->formatDate($data["journaldate"])'
				),
							array(
					'header'=>$this->getCatalog('postdate'),
					'name'=>'postdate',
					'value'=>'Yii::app()->format->formatDate($data["postdate"])'
				),
							array(
					'header'=>$this->getCatalog('journalnote'),
					'name'=>'journalnote',
					'value'=>'$data["journalnote"]'
				),
							array(
					'class'=>'CCheckBoxColumn',
					'name'=>'recordstatus',
					'header'=>$this->getCatalog('recordstatus'),
					'selectableRows'=>'0',
					'checked'=>'$data["recordstatus"]',
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
						<label for="dlg_search_journalno"><?php echo $this->getCatalog('journalno')?></label>
						<input type="text" class="form-control" name="dlg_search_journalno">
					</div>
          <div class="form-group">
						<label for="dlg_search_referenceno"><?php echo $this->getCatalog('referenceno')?></label>
						<input type="text" class="form-control" name="dlg_search_referenceno">
					</div>
          <div class="form-group">
						<label for="dlg_search_genjournalid"><?php echo $this->getCatalog('genjournalid')?></label>
						<input type="text" class="form-control" name="dlg_search_genjournalid">
					</div>
          <div class="form-group">
						<label for="dlg_search_currencyname"><?php echo $this->getCatalog('currencyname')?></label>
						<input type="text" class="form-control" name="dlg_search_currencyname">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('reportgl') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="genjournal_0_genjournalid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'genjournal_0_companyid','ColField'=>'genjournal_0_companyname',
							'IDDialog'=>'genjournal_0_companyid_dialog','titledialog'=>$this->getCatalog('companyname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CompanyUserPopUp','PopGrid'=>'genjournal_0_companyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_journalno"><?php echo $this->getCatalog('journalno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="genjournal_0_journalno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_referenceno"><?php echo $this->getCatalog('referenceno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="genjournal_0_referenceno">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_journaldate"><?php echo $this->getCatalog('journaldate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="genjournal_0_journaldate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_postdate"><?php echo $this->getCatalog('postdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="genjournal_0_postdate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_journalnote"><?php echo $this->getCatalog('journalnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="genjournal_0_journalnote"></textarea>
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="genjournal_0_recordstatus"><?php echo $this->getCatalog('recordstatus')?></label>
						</div>
						<div class="col-md-8">
							<input type="checkbox" name="genjournal_0_recordstatus">
						</div>
					</div>
							
				<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#journaldetail"><?php echo $this->getCatalog("journaldetail")?></a></li>

				</ul>
				<div class="tab-content">
				
<div id="journaldetail" class="tab-pane">
	<?php if ($this->checkAccess('reportgl','iswrite')) { ?>
<button name="CreateButtonjournaldetail" type="button" class="btn btn-primary" onclick="newdatajournaldetail()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php if ($this->checkAccess('reportgl','ispurge')) { ?>
<button name="PurgeButtonjournaldetail" type="button" class="btn btn-danger" onclick="purgedatajournaldetail()"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
    <?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderjournaldetail,
		'id'=>'journaldetailList',
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
								updatedatajournaldetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>'false',							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedatajournaldetail($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),

			array(
					'header'=>$this->getCatalog('journaldetailid'),
					'name'=>'journaldetailid',
					'value'=>'$data["journaldetailid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('debit'),
					'name'=>'debit',
					'value'=>'Yii::app()->format->formatNumber($data["debit"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
				),
							array(
					'header'=>$this->getCatalog('detailnote'),
					'name'=>'detailnote',
					'value'=>'$data["detailnote"]'
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
		<h3 class="box-title"><?php echo $this->getCatalog('journaldetail')?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->		
<div class="box-body">
				<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProviderjournaldetail,
		'id'=>'DetailjournaldetailList',
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
					'header'=>$this->getCatalog('journaldetailid'),
					'name'=>'journaldetailid',
					'value'=>'$data["journaldetailid"]'
				),
							array(
					'header'=>$this->getCatalog('account'),
					'name'=>'accountid',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('debit'),
					'name'=>'debit',
					'value'=>'Yii::app()->format->formatNumber($data["debit"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('currency'),
					'name'=>'currencyid',
					'value'=>'$data["currencyname"]'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
				),
							array(
					'header'=>$this->getCatalog('detailnote'),
					'name'=>'detailnote',
					'value'=>'$data["detailnote"]'
				),
							
		)
));?>
		</div>		
		</div>		
				
			</div>
			</div>
			</div>
			</div>
			
<div id="InputDialogjournaldetail" class="modal fade" role="dialog">
	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('journaldetail') ?></h4>
      </div>
			<div class="modal-body">
			<input type="hidden" class="form-control" name="journaldetail_1_journaldetailid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'journaldetail_1_accountid','ColField'=>'journaldetail_1_accountcode',
							'IDDialog'=>'journaldetail_1_accountid_dialog','titledialog'=>$this->getCatalog('account'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'genjournal_0_companyid',
							'PopUpName'=>'accounting.components.views.AccountcomdetPopUp','PopGrid'=>'journaldetail_1_accountidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="journaldetail_1_debit"><?php echo $this->getCatalog('debit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="journaldetail_1_debit">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="journaldetail_1_credit"><?php echo $this->getCatalog('credit')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="journaldetail_1_credit">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'journaldetail_1_currencyid','ColField'=>'journaldetail_1_currencyname',
							'IDDialog'=>'journaldetail_1_currencyid_dialog','titledialog'=>$this->getCatalog('currency'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'admin.components.views.CurrencyPopUp','PopGrid'=>'journaldetail_1_currencyidgrid')); 
					?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="journaldetail_1_ratevalue"><?php echo $this->getCatalog('ratevalue')?></label>
						</div>
						<div class="col-md-8">
							<input type="number" class="form-control" name="journaldetail_1_ratevalue">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="journaldetail_1_detailnote"><?php echo $this->getCatalog('detailnote')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="journaldetail_1_detailnote"></textarea>
						</div>
					</div>
							
			</div>
			      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedatajournaldetail()"><?php echo $this->getCatalog('save') ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close') ?></button>
      </div>
			</div>
			</div>
			</div>
			