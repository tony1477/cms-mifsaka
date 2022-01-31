<?php
	$sqldata="select t.*,a.gino,b.sono,c.fullname,d.companyname,e.currencyname,t.currencyrate,f.fullname as sales,
	datediff(current_date(),t.invoicedate) as umur 
				from invoice t
				left join giheader a on a.giheaderid = t.giheaderid
				left join soheader b on b.soheaderid = a.soheaderid
				left join employee f on f.employeeid = b.employeeid 
				left join company d on d.companyid = b.companyid 
				left join addressbook c on c.addressbookid = b.addressbookid 
				left join currency e on e.currencyid = t.currencyid
				where t.recordstatus in (".getUserRecordStatus('listinvar').") and
				b.companyid in (".getUserObjectValues('company').") and t.invoiceno is not null 
				and t.payamount < t.amount
				and b.sono like '%".(isset($_REQUEST['sono'])?$_REQUEST['sono']:'')."%'
				and c.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
				and t.invoiceno like '%".(isset($_REQUEST['invoiceno'])?$_REQUEST['invoiceno']:'')."%'
			    and b.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')." 
				";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'invoiceid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'invoiceid', 'invoiceno', 'fullname','sono','amount','payamount','sales','umur'
        ),
				'defaultOrder' => array( 
					'fullname' => CSort::SORT_DESC,
					'umur' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'sono':$("input[name='<?php echo $this->ColField; ?>_search_sono']").val(),
		'fullname':$("input[name='<?php echo $this->ColField; ?>_search_fullname']").val(),
		'invoiceno':$("input[name='<?php echo $this->ColField; ?>_search_invoiceno']").val()
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
			$("input[name='<?php echo $this->IDField ?>']").val($(this).find('td:first-child').text());<?php echo $this->onaftersign ?>
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
		<?php echo $this->IDField?>searchdata()
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_fullname"><?php echo $this->getCatalog('customer') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_fullname" class="form-control">
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
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_sono"><?php echo $this->getCatalog('sono') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_sono" class="form-control">
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
						'header'=>$this->getCatalog('invoiceid'),
						'name'=>'invoiceid', 
						'value'=>'$data["invoiceid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
					array(
						'header'=>$this->getCatalog('invoiceno'),
						'name'=>'invoiceno', 
						'value'=>'$data["invoiceno"]',
					),
					array(
						'header'=>$this->getCatalog('sono'),
						'name'=>'sono', 
						'value'=>'$data["sono"]',
					),
					array(
						'header'=>$this->getCatalog('sales'),
						'name'=>'sales', 
						'value'=>'$data["sales"]',
					),
					array(
						'header'=>$this->getCatalog('umur'),
						'name'=>'umur', 
						'value'=>'$data["umur"]',
					),
					array(
						'header'=>$this->getCatalog('amount'),
						'name'=>'amount', 
						'value'=>'Yii::app()->format->formatCurrency($data["amount"])',
					),
					array(
						'header'=>$this->getCatalog('payamount'),
						'name'=>'payamount', 
						'value'=>'Yii::app()->format->formatCurrency($data["payamount"])',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>