<?php
	$sqldata=" select a.poheaderid, b.fullname,a.pono,a.docdate,a.headernote
		from poheader  a
        left join addressbook b on a.addressbookid=b.addressbookid
        where a.recordstatus = 5 
		and a.pono like '%".(isset($_REQUEST['pono'])?$_REQUEST['pono']:'')."%'
		and a.docdate like '%".(isset($_REQUEST['docdate'])?$_REQUEST['docdate']:'')."%' and 
        b.fullname like '%".(isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'')."%'
		";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'poheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'poheaderid', 'docdate', 'pono', 'headernote' , 'fullname'
        ),
				'defaultOrder' => array( 
					'purchasingorgid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'fullname':$("input[name='<?php echo $this->ColField; ?>_search_fullname']").val(),
		'pono':$("input[name='<?php echo $this->ColField; ?>_search_pono']").val(),
	}});
	return false;
}
    
function update_grdetail1(){
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('inventory/grheader/updategrdetail1')?>',
		'data':{
            'grheaderid':$("input[name='grheader_0_grheaderid']").val(),
			'docdate':$("input[name='grheader_0_docdate']").val(),
            'poheaderid':$("input[name='grheader_0_poheaderid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("grdetailList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
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
    update_grdetail1();
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
                <div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_pono"><?php echo $this->getCatalog('pono') ?></label>
			</div>
                <div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_pono" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
						<div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_headernote"><?php echo $this->getCatalog('headernote') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_headernote" class="form-control">
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
						'header'=>$this->getCatalog('poheaderid'),
						'name'=>'poheaderid', 
						'value'=>'$data["poheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
                    array(
						'header'=>$this->getCatalog('fullname'),
						'name'=>'fullname', 
						'value'=>'$data["fullname"]',
					),
                    array(
						'header'=>$this->getCatalog('pono'),
						'name'=>'pono', 
						'value'=>'$data["pono"]',
					),
					array(
						'header'=>$this->getCatalog('docdate'),
						'name'=>'docdate', 
						'value'=>'$data["docdate"]',
					),
					array(
						'header'=>$this->getCatalog('headernote'),
						'name'=>'headernote', 
						'value'=>'$data["headernote"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>