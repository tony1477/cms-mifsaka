<script type="text/javascript">






function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'genledger_0_genledgerid='+$id
+ '&genledger_0_journalno='+$("input[name='dlg_search_journalno']").val()
+ '&genledger_0_currencyname='+$("input[name='dlg_search_currencyname']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'genledger_0_genledgerid='+$id
+ '&genledger_0_journalno='+$("input[name='dlg_search_journalno']").val()
+ '&genledger_0_currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/genledger/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'genledger_0_genledgerid='+$id
+ '&genledger_0_journalno='+$("input[name='dlg_search_journalno']").val()
+ '&genledger_0_currencyname='+$("input[name='dlg_search_currencyname']").val();
	window.open('<?php echo Yii::app()->createUrl('Accounting/genledger/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'genledgerid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('genledger') ?></h3>




<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('genledger','isdownload')) { ?>
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
				'template'=>'{pdf} {xls}',
				'htmlOptions' => array('style'=>'width:80px'),
				'buttons'=>array
				(
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('genledger','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('genledger','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('genledgerid'),
					'name'=>'genledgerid',
					'value'=>'$data["genledgerid"]'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'companyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('accountcode'),
					'name'=>'accountid',
					'value'=>'$data["accountcode"]'
				),
							array(
					'header'=>$this->getCatalog('journalno'),
					'name'=>'genjournalid',
					'value'=>'$data["journalno"]'
				),
							array(
					'header'=>$this->getCatalog('debit'),
					'name'=>'debit',
					'value'=>'$data["symbol"]." ".Yii::app()->format->formatNumber($data["debit"])'
				),
							array(
					'header'=>$this->getCatalog('credit'),
					'name'=>'credit',
					'value'=>'$data["symbol"]." ".Yii::app()->format->formatNumber($data["credit"])'
				),
							array(
					'header'=>$this->getCatalog('postdate'),
					'name'=>'postdate',
					'value'=>'Yii::app()->format->formatDateSQL($data["postdate"])'
				),
							array(
					'header'=>$this->getCatalog('ratevalue'),
					'name'=>'ratevalue',
					'value'=>'Yii::app()->format->formatNumber($data["ratevalue"])'
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
        <h4 class="modal-title"><?php echo $this->getCatalog('genledger') ?></h4>
      </div>
      <div class="modal-body">
				
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


