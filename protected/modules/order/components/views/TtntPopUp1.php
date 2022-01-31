<?php
	$sqldata="select distinct t.*,b.companyname,c.fullname as sales
				from ttnt t
        left join ttntdetail a on a.ttntid = t.ttntid
				left join company b on b.companyid = t.companyid
				left join employee c on c.employeeid = t.employeeid           
				where t.recordstatus = 3
					and t.recordstatus in (".getUserRecordStatus('listttnt').")  
				and	t.companyid in (".getUserObjectValues('company').")
				and t.employeeid = '".(isset($_REQUEST['employeeid'])?$_REQUEST['employeeid']:'')."'
				and t.companyid = '".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'')."'
				and t.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
				and t.iscutar is null and t.iscbin is null and a.isttf =0
				order by ttntid desc
				";
$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'ttntid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'ttntid', 'companyname', 'docdate','docno','sales'
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
		'employeeid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'companyid':$("input[name='<?php echo $this->RelationID2?>']").val(),        
		'docno':$("input[name='<?php echo $this->ColField; ?>_search_docno']").val()
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
			$("input[name='<?php echo $this->ColField ?>']").val($(this).find("td:nth-child(4)").text());
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_docno"><?php echo $this->getCatalog('ttntno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_docno" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
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
						'header'=>$this->getCatalog('ttntid'),
						'name'=>'ttntid', 
						'value'=>'$data["ttntid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
                   array(
						'header'=>$this->getCatalog('companyname'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
					array(
						'header'=>$this->getCatalog('docdate'),
						'name'=>'docdate', 
						'value'=>'$data["docdate"]',
					),
					array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'docno', 
						'value'=>'$data["docno"]',
					),
					array(
						'header'=>$this->getCatalog('sales'),
						'name'=>'sales', 
						'value'=>'$data["sales"]',
					
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>