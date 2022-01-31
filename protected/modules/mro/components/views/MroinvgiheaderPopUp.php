<?php
	$sqldata="select b.mrogino, b.mrogidate, b.shipto, b.mrogiheaderid
from mrogiheader b  
where b.mrogiheaderid
and b.mrogino like '%".(isset($_REQUEST['mrogino'])?$_REQUEST['mrogino']:'')."%' AND b.recordstatus='2' AND b.mrogiheaderid NOT IN (SELECT mrogiheaderid FROM mroinvoice WHERE recordstatus=2) ORDER BY mrogino DESC 

 " 
;
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'mrogiheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'mrogiheaderid', 'mrogino','mrogidate','shipto'
        ),
				'defaultOrder' => array( 
					'a.mrogiheaderid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		
		'gino':$("input[name='<?php echo $this->ColField; ?>_search_mrogino']").val()
		
	}});
	return false;
}
    
function update_mroinvdetail(){
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mroinvoice/updatemrodetail')?>',
		'data':{
            'mroinvoiceid':$("input[name='mroinvoice_0_mroinvoiceid']").val(),
            'mrogiheaderid':$("input[name='mroinvoice_0_mrogiheaderid']").val(),
            'taxid':$("input[name='mroinvoice_0_taxid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
                toastr.info("<?php echo $this->getCatalog('alreadysaved');?>");
                $("input[name='mroinvoice_0_mroinvoiceid']").val(data.mroinvoiceid);
				$.fn.yiiGridView.update("mroinvdetailList",{data:{'mroinvoiceid':$("input[name='mroinvoice_0_mroinvoiceid']").val()}});
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
    update_mroinvdetail();
    return false;
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_mrogino"><?php echo $this->getCatalog('mrogino') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_gino" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
			<div class="row">
			
			
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('mrogiheaderid'),
						'name'=>'mrogiheaderid', 
						'value'=>'$data["mrogiheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('mrogino'),
						'name'=>'mrogino', 
						'value'=>'$data["mrogino"]',
					),
                    array(
						'header'=>$this->getCatalog('mrogidate'),
						'name'=>'mrogidate', 
						'value'=>'$data["mrogidate"]',
					),
                    array(
						'header'=>$this->getCatalog('shipto'),
						'name'=>'shipto', 
						'value'=>'$data["shipto"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>