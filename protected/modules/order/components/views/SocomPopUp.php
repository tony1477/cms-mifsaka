<?php
	$sqldata="select a.soheaderid, a.sono, c.fullname, b.companyname, a.pocustno
		from soheader a 
		left join company b on b.companyid = a.companyid 
		left join addressbook c on c.addressbookid = a.addressbookid 
		where b.companyname like '%".(isset($_REQUEST['companyname'])?$_REQUEST['companyname']:'')."%' 
		and c.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
		and a.sono like '%".(isset($_REQUEST['sono'])?$_REQUEST['sono']:'')."%'
		and a.pocustno like '%".(isset($_REQUEST['pocustno'])?$_REQUEST['pocustno']:'')."%'
		and a.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')." 
		and a.companyid in (".getUserObjectValues('company').")";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'soheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'soheaderid', 'sono','fullname','pocustno'
        ),
				'defaultOrder' => array( 
					'a.soheaderid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyname':$("input[name='<?php echo $this->ColField; ?>_search_companyname']").val(),
		'fullname':$("input[name='<?php echo $this->ColField; ?>_search_fullname']").val(),
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'sono':$("input[name='<?php echo $this->ColField; ?>_search_sono']").val(),
		'pocustno':$("input[name='<?php echo $this->ColField; ?>_search_pocustno']").val()
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_companyname"><?php echo $this->getCatalog('companyname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_companyname" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_fullname"><?php echo $this->getCatalog('customer') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_fullname" class="form-control">
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_sono"><?php echo $this->getCatalog('docno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_sono" class="form-control">
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_pocustno"><?php echo $this->getCatalog('pocustno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_pocustno" class="form-control">
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
						'header'=>$this->getCatalog('soheaderid'),
						'name'=>'soheaderid', 
						'value'=>'$data["soheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('company'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
					array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'sono', 
						'value'=>'$data["sono"]',
					),
					array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
					array(
						'header'=>$this->getCatalog('pocustno'),
						'name'=>'pocustno', 
						'value'=>'$data["pocustno"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>