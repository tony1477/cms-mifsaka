<?php
	$sqldata="select b.prheaderid,a.prmaterialid,b.prno, b.prdate, c.productname, a.qty, a.poqty, a.grqty, a.giqty
from prmaterial a
left join prheader b on b.prheaderid = a.prheaderid
left join product c on c.productid = a.productid 
left join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid 
left join requestedby e on e.requestedbyid = a.requestedbyid 
left join deliveryadvicedetail f on f.deliveryadvicedetailid = a.deliveryadvicedetailid
left join deliveryadvice g on g.deliveryadviceid = f.deliveryadviceid
left join sloc h on h.slocid = g.slocid 
left join plant i on i.plantid = h.plantid 
where b.recordstatus = getwfmaxstatbywfname('apppr') 
and b.prno is not null 
and b.recordstatus in (".getUserRecordStatus('listpr').")
				and
				i.companyid in (".getUserObjectValues('company').")
				
and a.prmaterialid not in 
(
select zz.prmaterialid
from podetail zz 
where zz.productid = a.productid and zz.prmaterialid = a.prmaterialid
and zz.poqty <= a.qty
)
and i.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')."
and b.prno like '%".(isset($_REQUEST['prno'])?$_REQUEST['prno']:'')."%'
and c.productname like '%".(isset($_REQUEST['productname'])?$_REQUEST['productname']:'')."%'
";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'prmaterialid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'prmaterialid', 'frno', 'frdate','useraccessid','productplanid','slocid'
        ),
				'defaultOrder' => array( 
					'prmaterialid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'prno':$("input[name='<?php echo $this->ColField; ?>_search_prno']").val(),
		'productname':$("input[name='<?php echo $this->ColField; ?>_search_productname']").val(),
	}});
	return false;
}
function <?php echo $this->IDField?>ShowButtonClick()
{
	$('#<?php echo $this->IDDialog?>').modal();
	<?php echo $this->IDField?>searchdata();
}
function <?php echo $this->IDField?>ClearButtonClick()
{
	$("input[name='<?php echo $this->ColField ?>']").val('');
	$("input[name='<?php echo $this->IDField ?>']").val('');
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
				<button name="<?php echo $this->IDField?>ClearButton" type="button" class="btn btn-danger" onclick="<?php echo $this->IDField?>ClearButtonClick()"><span class="glyphicon glyphicon-remove"></span></button>
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_prno"><?php echo $this->getCatalog('prno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_prno" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_productname"><?php echo $this->getCatalog('productname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_productname" class="form-control">
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
						'header'=>$this->getCatalog('prmaterialid'),
						'name'=>'prmaterialid', 
						'value'=>'$data["prmaterialid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('prno'),
						'name'=>'prno', 
						'value'=>'$data["prno"]',
					),
					array(
						'header'=>$this->getCatalog('product'),
						'name'=>'productid', 
						'value'=>'$data["productname"]',
					),
					array(
						'header'=>$this->getCatalog('qty'),
						'name'=>'qty', 
						'value'=>'$data["qty"]',
					),	
					array(
						'header'=>$this->getCatalog('poqty'),
						'name'=>'poqty', 
						'value'=>'$data["poqty"]',
					),
					array(
						'header'=>$this->getCatalog('grqty'),
						'name'=>'grqty', 
						'value'=>'$data["grqty"]',
					),
					array(
						'header'=>$this->getCatalog('giqty'),
						'name'=>'giqty', 
						'value'=>'$data["giqty"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>
