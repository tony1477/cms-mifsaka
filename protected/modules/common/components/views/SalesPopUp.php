<?php
	$sqldata="select *
					from (select a.employeeid,a.fullname,a.oldnik,
					(select group_concat(d.companyname)
					from employeeorgstruc b
					left join orgstructure c on c.orgstructureid=b.orgstructureid
					left join company d on d.companyid=c.companyid
					where b.employeeid=a.employeeid) as companyname
					from employee a) z
		where coalesce(fullname,'') like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
		and coalesce(oldnik,'') like '%".(isset($_REQUEST['oldnik'])?$_REQUEST['oldnik']:'')."%'
		and coalesce(companyname,'') like '%".(isset($_REQUEST['companyname'])?$_REQUEST['companyname']:'')."%'
	";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'employeeid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'employeeid', 'fullname','oldnik','companyname'
        ),
				'defaultOrder' => array( 
					'employeeid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'fullname':$("input[name='<?php echo $this->ColField; ?>_search_fullname']").val(),
		'oldnik':$("input[name='<?php echo $this->ColField; ?>_search_oldnik']").val(),
		'companyname':$("input[name='<?php echo $this->ColField; ?>_search_companyname']").val()
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
		<?php echo $this->IDField?>searchdata()
	}});
});
function <?php echo $this->IDField?>ClearClick()
{
	$("input[name='<?php echo $this->ColField ?>']").val('');
	$("input[name='<?php echo $this->IDField ?>']").val('');
}
</script>
<div class="row">
	<div class="<?php echo $this->classtype ?>">
		<label class=" control-label" for="<?php echo $this->ColField; ?>"><?php echo $this->titledialog ?></label>
	</div>
	<div class="<?php echo $this->classtypebox ?>">
		<input name="<?php echo $this->IDField ?>" type="hidden" value="">
		<div class="input-group">
                    <input type="text" name="<?php echo $this->ColField ?>" class="form-control">
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_fullname"><?php echo $this->getCatalog('fullname') ?></label>
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_oldnik"><?php echo $this->getCatalog('oldnik') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_oldnik" class="form-control">
				</div>
			</div>
			</div>
						<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_companyname"><?php echo $this->getCatalog('companyname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_companyname" class="form-control">
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
						'header'=>$this->getCatalog('employeeid'),
						'name'=>'employeeid', 
						'value'=>'$data["employeeid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('fullname'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
					array(
						'header'=>$this->getCatalog('oldnik'),
						'name'=>'oldnik', 
						'value'=>'$data["oldnik"]',
					),
					array(
						'header'=>$this->getCatalog('companyname'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>