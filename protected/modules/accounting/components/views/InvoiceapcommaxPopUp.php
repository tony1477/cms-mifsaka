<?php
	$sqldata="select t.*,a.pono,b.fullname as supplier,c.currencyname,d.paycode,e.taxcode,f.companyname
         from invoiceap t
         left join poheader a on a.poheaderid=t.poheaderid
         left join addressbook b on b.addressbookid=t.addressbookid
         left join currency c on c.currencyid=t.currencyid
         left join paymentmethod d on d.paymentmethodid=t.paymentmethodid
         left join tax e on e.taxid=t.taxid																
         left join company f on f.companyid = t.companyid
         where t.recordstatus = getwfmaxstatbywfname('appinvap')
					and invoiceapid like '%".(isset($_REQUEST['invoiceapid'])?$_REQUEST['invoiceapid']:'')."%'
					and invoiceno like '%".(isset($_REQUEST['invoiceno'])?$_REQUEST['invoiceno']:'')."%'
					and t.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')." 
	";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'invoiceapid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'invoiceapid', 'invoiceno'
        ),
				'defaultOrder' => array( 
					'invoiceapid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'invoiceno':$("input[name='<?php echo $this->ColField; ?>_search_invoiceno']").val(),
		'invoiceapid':$("input[name='<?php echo $this->ColField; ?>_search_invoiceapid']").val()
	}});
	return false;
}
function <?php echo $this->IDField?>ShowButtonClick()
{
	$('#<?php echo $this->IDDialog?>').modal();
	<?php echo $this->IDField?>searchdata();
}
function <?php echo $this->PopGrid?>onSelectionChange()
{
	$("#<?php echo $this->PopGrid?> > table > tbody > tr").each(function(i)
	{
		if($(this).hasClass("selected"))
		{
			$("input[name='<?php echo $this->ColField ?>']").val($(this).find("td:nth-child(2)").text());
			$("input[name='<?php echo $this->IDField ?>']").val($(this).find('td:first-child').text());
		}
	});
	$('#<?php echo $this->IDDialog?>').modal('hide');
}
$(document).ready(function(){
	$("input[name='<?php echo $this->ColField; ?>']").keyup(function(e){
	if(e.keyCode == 13)
	{
		<?php echo $this->IDField?>ShowButtonClick();
	}});
	$(":input[name*='<?php echo $this->ColField; ?>_search_']").keyup(function(e){
	if(e.keyCode == 13)
	{
		<?php echo $this->IDField?>searchdata();
	}});
});
</script>
<div class="row">
	<div class="<?php echo $this->classtype ?>">
		<label class=" control-label" for="<?php echo $this->ColField; ?>"><?php echo $this->titledialog ?></label>
	</div>
	<div class="<?php echo $this->classtypebox ?>">
		<input name="<?php echo $this->IDField ?>" type="hidden" value="">
		<div class="input-group">
			<input type="text" name="<?php echo $this->ColField ?>" readonly class="form-control">
			<span class="input-group-btn">
				<button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><span class="glyphicon glyphicon-modal-window"></span></button>
                <button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-danger" onclick="<?php echo $this->IDField?>ClearClick()"><span class="glyphicon glyphicon-remove"></span></button>
			</span>
		</div>
	</div>
</div>
	
<div id="<?php echo $this->IDDialog?>" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">	
	 <div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" href="#<?php echo $this->IDDialog?>">&times;</button>
        <h4 class="modal-title"><?php echo $this->titledialog ?></h4>
      </div>
      <div class="modal-body">
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_invoiceapid"><?php echo $this->getCatalog('invoiceapid') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_invoiceapid" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_invoiceno"><?php echo $this->getCatalog('invoiceno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_invoiceno" class="form-control">
				</div>
			</div>
			</div>
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('invoiceapid'),
						'name'=>'invoiceapid', 
						'value'=>'$data["invoiceapid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('invoiceno'),
						'name'=>'invoiceno', 
						'value'=>'$data["invoiceno"]',
					),
					array(
						'header'=>$this->getCatalog('supplier'),
						'name'=>'supplier', 
						'value'=>'$data["supplier"]',
					),
					array(
						'header'=>$this->getCatalog('pono'),
						'name'=>'pono', 
						'value'=>'$data["pono"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>