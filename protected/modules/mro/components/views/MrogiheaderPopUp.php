<?php
	$sqldata="select b.gino, b.giheaderid, b.headernote, c.companyname, d.fullname, d.addressbookid, c.companyid
from giheader b  
join soheader z on z.soheaderid = b.soheaderid
join company c on c.companyid = z.companyid
join addressbook d on d.addressbookid = z.addressbookid  
where b.gino like '%".(isset($_REQUEST['gino'])?$_REQUEST['gino']:'')."%' AND b.recordstatus='3' 
 " 
;
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'giheaderid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'giheaderid', 'gino', 'companyid','addressbookid','headernote'
        ),
				'defaultOrder' => array( 
					'a.giheaderid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		
		'gino':$("input[name='<?php echo $this->ColField; ?>_search_gino']").val()
		
	}});
	return false;
}
    
function update_mrogidetail(){
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('mro/mrogi/updatemrodetail')?>',
		'data':{
            'mrogiheaderid':$("input[name='mrogiheader_0_mrogiheaderid']").val(),
			'mrogidate':$("input[name='mrogiheader_0_mrogidate']").val(),
            'giheaderid':$("input[name='mrogiheader_0_giheaderid']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("mrogidetailList");
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
    update_mrogidetail();
    //alert('alert');
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_gino"><?php echo $this->getCatalog('gino') ?></label>
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
						'header'=>$this->getCatalog('giheaderid'),
						'name'=>'giheaderid', 
						'value'=>'$data["giheaderid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('gino'),
						'name'=>'gino', 
						'value'=>'$data["gino"]',
					),
                    array(
						'header'=>$this->getCatalog('companyname'),
						'name'=>'companyid', 
						'value'=>'$data["companyname"]',
					),
                    array(
						'header'=>$this->getCatalog('customer'),
						'name'=>'addressbookid', 
						'value'=>'$data["fullname"]',
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
