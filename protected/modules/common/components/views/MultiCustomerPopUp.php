<?php
	$sqldata="select a.addressbookid, fullname, a.groupcustomerid, a.custgradeid, a.salesareaid, groupname, areaname, custogradedesc as gradedesc
				from addressbook a
				left join salesarea b on b.salesareaid = a.salesareaid
				left join groupcustomer c on c.groupcustomerid = a.groupcustomerid
				left join custgrade d on d.custgradeid = a.custgradeid
				where a.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
				and groupname like '%".(isset($_REQUEST['groupname'])?$_REQUEST['groupname']:'')."%' 
				and areaname like '%".(isset($_REQUEST['areaname'])?$_REQUEST['areaname']:'')."%' 
				and a.iscustomer = 1 and a.recordstatus=1
				";

	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$customer=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'addressbookid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'addressbookid', 'fullname', 'groupname','areaname','gradedesc'
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
		'fullname':$("input[name='<?php echo $this->ColField;?>_search_fullname']").val(),
		'areaname':$("input[name='<?php echo $this->ColField; ?>_search_areaname']").val(),
		'groupname':$("input[name='<?php echo $this->ColField; ?>_search_groupname']").val()
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
		  <button name="<?php echo $this->IDField?>ShowButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>ShowButtonClick()"><?= getCatalog('choose') .' '. getCatalog('customer')?></button>
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_fullname"><?php echo $this->getCatalog('fullname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_fullname" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-success" onclick="<?php echo $this->IDField?>ok()"> Tambah <span class="glyphicon glyphicon-inbox"></span></button>
						<button name="<?php echo $this->IDField?>CancelButton" type="button" class="btn btn-danger" onclick="<?php echo $this->IDField?>cancel()"> Hapus <span class="glyphicon glyphicon-erase"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_areaname"><?php echo $this->getCatalog('areaname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_areaname" class="form-control">
				</div>
			</div>
			</div>
		  <div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_groupname"><?php echo $this->getCatalog('groupname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_groupname" class="form-control">
				</div>
			</div>
			</div>
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>2,
				'dataProvider'=>$customer,
				//'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'class'=>'CCheckBoxColumn',
						'id'=>'addressbookid', 
						'selectableRows'=>null           
					),
					array(
						'header'=>$this->getCatalog('addressbookid'),
						'name'=>'addressbookid', 
						'value'=>'$data["addressbookid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
					array(
						'header'=>$this->getCatalog('salesarea'),
						'name'=>'areaname', 
						'value'=>'$data["areaname"]',
					),
					array(
						'header'=>$this->getCatalog('groupcustomer'),
						'name'=>'groupname', 
						'value'=>'$data["groupname"]',
					),
					array(
						'header'=>$this->getCatalog('custgrade'),
						'name'=>'gradedesc', 
						'value'=>'$data["gradedesc"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>