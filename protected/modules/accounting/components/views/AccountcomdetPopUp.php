<?php
	$sqldata="select distinct a.accountid,a.accountcode,a.accountname 
		from account a 
		inner join company b on b.companyid = a.companyid
		where a.recordstatus = 1 
			and a.accounttypeid = 2 
			and b.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')." 
			and a.accountcode like '%".(isset($_REQUEST['accountcode'])?$_REQUEST['accountcode']:'')."%' 
			and a.accountname like '%".(isset($_REQUEST['accountname'])?$_REQUEST['accountname']:'')."%'";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'accountid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'accountid', 'accountcode', 'accountname'
        ),
				'defaultOrder' => array( 
					'accountid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'accountcode':$("input[name='<?php echo $this->IDField?>_search_accountcode']").val(),
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'accountname':$("input[name='<?php echo $this->IDField?>_search_accountname']").val()
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
				<label class="control-label" for="<?php echo $this->IDField?>_search_accountcode"><?php echo $this->getCatalog('accountcode') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->IDField?>_search_accountcode" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->IDField?>_search_accountname"><?php echo $this->getCatalog('accountname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->IDField?>_search_accountname" class="form-control">
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
						'header'=>$this->getCatalog('accountid'),
						'name'=>'accountid', 
						'value'=>'$data["accountid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('accountcode'),
						'name'=>'accountcode', 
						'value'=>'$data["accountcode"]',
					),
					array(
						'header'=>$this->getCatalog('accountname'),
						'name'=>'accountname', 
						'value'=>'$data["accountname"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>
