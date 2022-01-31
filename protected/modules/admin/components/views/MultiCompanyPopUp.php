<?php
	$sqldata="select companyname, companycode, companyid
				from company a
				where a.companyname like '%".(isset($_REQUEST['companyname'])?$_REQUEST['companyname']:'')."%'
				and companycode like '%".(isset($_REQUEST['companycode'])?$_REQUEST['companycode']:'')."%' 
				and a.recordstatus=1";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$company=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'companyid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'companyid', 'companyname', 'companycode'
        ),
				'defaultOrder' => array( 
					'companyid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyname':$("input[name='<?php echo $this->ColField;?>_search_companyname']").val(),
		'companycode':$("input[name='<?php echo $this->ColField; ?>_search_companycode']").val()
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
<div class="input-group">
      <input type="text" class="form-control" placeholder="Search for..." readonly>
      <span class="input-group-btn">
		  <button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><?= getCatalog('choose') .' '. getCatalog('company')?></button>
      </span>
</div>
<!--<button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><span class="glyphicon glyphicon-list-alt"></span></button>-->
	
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_companyname"><?php echo $this->getCatalog('company') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_companyname" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ok()"><span class="glyphicon glyphicon-inbox"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_companycode"><?php echo $this->getCatalog('companycode') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_companycode" class="form-control">
				</div>
			</div>
			</div>
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>2,
				'dataProvider'=>$company,
				//'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'class'=>'CCheckBoxColumn',
						'id'=>'companyid', 
						'selectableRows'=>null           
					),
					array(
						'header'=>$this->getCatalog('companyid'),
						'name'=>'companyid', 
						'value'=>'$data["companyid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('companyname'),
						'name'=>'companyname', 
						'value'=>'$data["companyname"]',
					),
					array(
						'header'=>$this->getCatalog('companycode'),
						'name'=>'companycode', 
						'value'=>'$data["companycode"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>