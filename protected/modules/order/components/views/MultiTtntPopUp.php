<?php
	$sqldata="select t.*,a.gino,b.sono,c.fullname,d.companyname,e.currencyname,g.currencyrate,f.fullname as sales,g.invoiceno
	,h.docno 
				from ttntdetail t
                left join ttnt h on h.ttntid = t.ttntid
                left join invoice g on g.invoiceid=t.invoiceid
				left join giheader a on a.giheaderid = g.giheaderid
				left join soheader b on b.soheaderid = a.soheaderid
				left join employee f on f.employeeid = b.employeeid 
				left join company d on d.companyid = b.companyid 
				left join addressbook c on c.addressbookid = b.addressbookid 
				left join currency e on e.currencyid = g.currencyid
				where h.recordstatus = 3
				and h.recordstatus in (".getUserRecordStatus('listttnt').") and
				b.companyid in (".getUserObjectValues('company').") and g.invoiceno is not null 
				and g.payamount < g.amount
				and b.sono like '%".(isset($_REQUEST['sono'])?$_REQUEST['sono']:'')."%'and h.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
				and c.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
				and g.invoiceno like '%".(isset($_REQUEST['invoiceno'])?$_REQUEST['invoiceno']:'')."%'
				AND t.ttntid = '".(isset($_REQUEST['ttntid'])?$_REQUEST['ttntid']:'')."'
				and t.ttntdetailid not in (select ttntdetailid from ttfdetail z where z.ttntdetailid = t.ttntdetailid) and h.iscutar is null and h.iscbin is null and t.isttf =0
				order by ttntdetailid	
				";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'ttntdetailid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'ttntdetailid', 'invoiceno', 'fullname','sono','amount','payamount','sales'
        ),
				'defaultOrder' => array( 
					'docno' => CSort::SORT_DESC,
					
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'ttntid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'sono':$("input[name='<?php echo $this->ColField; ?>_search_sono']").val(),
		'fullname':$("input[name='<?php echo $this->ColField; ?>_search_fullname']").val(),
		
		'invoiceno':$("input[name='<?php echo $this->ColField; ?>_search_invoiceno']").val()
	}});
	return false;
}
function <?php echo $this->IDField?>ok()
{
	$id = $.fn.yiiGridView.getSelection('<?php echo $this->PopGrid?>');
	$("input[name='<?php echo $this->IDField ?>']").val($id);
	$('#<?php echo $this->IDDialog?>').modal('hide');
	<?php echo $this->onaftersign ?>
	return false;
}
function <?php echo $this->IDField?>ShowButtonClick()
{
	$('#<?php echo $this->IDDialog?>').modal();
	<?php echo $this->IDField?>searchdata();
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
<input name="<?php echo $this->IDField ?>" type="hidden" value="">
<button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><span class="glyphicon glyphicon-list-alt"></span></button>
	
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
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ok()"><span class="glyphicon glyphicon-inbox"></span></button>
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
				'selectableRows'=>2,
				'dataProvider'=>$product,
				//'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'class'=>'CCheckBoxColumn',
						'id'=>'invoiceid', 
						'selectableRows'=>null           
					),
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
					),					array(
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