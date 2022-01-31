<?php
	$sqldata="SELECT a.productoutputno, a.productoutputid, a.description, a.productplanno, b.productplanid, productoutputdate
              FROM productoutput a
              JOIN productplan b ON a.productplanid = b.productplanid
              WHERE a.recordstatus = 3
              AND a.productoutputno LIKE '%".(isset($_REQUEST['productoutputno'])?$_REQUEST['productoutputno']:'')."%'
              AND a.companyid in (".getUserObjectValues('company').")
              ORDER BY productoutputid DESC";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'productoutputid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'productoutputid', 'productoutputno','productoutputdate','productplanid'
        ),
				'defaultOrder' => array( 
					'productoutputid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'productoutputno':$("input[name='<?php echo $this->IDField?>_search_productoutputno']").val()
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
    
function generateTSOP(){
     
    jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('inventory/transstockfg/generatedetail')?>',
		'data': {
						'productoutputid':$("input[name='transstock_0_productoutputid']").val(),
						'transstockid':$("input[name='transstock_0_transstockid']").val(),
		},
		'type': 'post',
		'dataType': 'json',
		'success': function(data) {
		if (data.status == "success")
			{
				$("input[name='transstock_0_headernote']").val(data.headernote);
				$("input[name='transstock_0_slocfromid']").val(data.slocfromid);
				$("input[name='transstock_0_slocfromcode']").val(data.slocfromcode);
                $.fn.yiiGridView.update("transstockdetList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache': false
	});
    //$.fn.yiiGridView.update("grdetailList",{data:{'grheaderid':$("input[name='grheader_0_poheaderid']").val()}});
    $.fn.yiiGridView.update("grdetailList");
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
    //jQuery here
	$('#<?php echo $this->IDDialog?>').modal('hide');
    generateTSOP();
}
$(document).ready(function(){
	$("input[name='<?php echo $this->ColField; ?>']").keyup(function(e){
	if(e.keyCode == 13)
	{
		<?php echo $this->IDField?>ShowButtonClick();
	}});
	$(":input[name*='<?php echo $this->ColField; ?>_']").keyup(function(e){
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
				<label class="control-label" for="<?php echo $this->IDField?>_search_productoutputno"><?php echo $this->getCatalog('productoutputno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->IDField?>_search_productoutputno" class="form-control">
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
						'header'=>$this->getCatalog('productoutputid'),
						'name'=>'productoutputid', 
						'value'=>'$data["productoutputid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('productoutputno'),
						'name'=>'productoutputno', 
						'value'=>'$data["productoutputno"]',
					),
                    array(
						'header'=>$this->getCatalog('productoutputdate'),
						'name'=>'productoutputdate', 
						'value'=>'$data["productoutputdate"]',
					),
                    array(
						'header'=>$this->getCatalog('productplanno'),
						'name'=>'productplanid', 
						'value'=>'$data["productplanno"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>