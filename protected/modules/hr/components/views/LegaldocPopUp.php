<?php
	$sqldata="select legaldocid,docname, docno, docdate, doccompanyid, a.storagedocid, description,companyname, storagedocname
		from legaldoc a
        left join storagedoc b on b.storagedocid = a.storagedocid
        left join company c on c.companyid = a.doccompanyid
		where c.recordstatus = 1 and docname like '%".(isset($_REQUEST['docname'])?$_REQUEST['docname']:'')."%'
        and companyname like '%".(isset($_REQUEST['companyanme'])?$_REQUEST['companyanme']:'')."%' 
        and docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%' ";
	$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$legaldoc=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'legaldocid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'legaldocid', 'docname','docno','docdate','doccompanyid'
        ),
				'defaultOrder' => array( 
					'legaldocid' => CSort::SORT_DESC
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'docname':$("input[name='<?php echo $this->ColField; ?>_search_docname']").val(),
		'docno':$("input[name='<?php echo $this->ColField; ?>_search_docno']").val(),
		'companyname':$("input[name='<?php echo $this->ColField; ?>_search_companyname']").val()
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_docname"><?php echo $this->getCatalog('docname') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_docname" class="form-control">
					<span class="input-group-btn">
						<button name="<?php echo $this->IDField?>SearchButton" type="button" class="btn btn-primary" onclick="<?php echo $this->IDField?>searchdata()"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
			</div>
            <div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_docno"><?php echo $this->getCatalog('docno') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_docno" class="form-control">
				</div>
			</div>
			</div>
            <div class="row">
			<div class="col-md-4">
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_companyname"><?php echo $this->getCatalog('company') ?></label>
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
				'dataProvider'=>$legaldoc,
				'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('legaldocid'),
						'name'=>'legaldocid', 
						'value'=>'$data["legaldocid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
					array(
						'header'=>$this->getCatalog('docname'),
						'name'=>'docname', 
						'value'=>'$data["docname"]',
					),
                    array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'docno', 
						'value'=>'$data["docno"]',
					),
                    array(
						'header'=>$this->getCatalog('docdate'),
						'name'=>'docdate', 
						'value'=>'date(Yii::app()->params["dateviewfromdb"],strtotime($data["docdate"]))',
					),
                    array(
						'header'=>$this->getCatalog('company'),
						'name'=>'doccompanyid', 
						'value'=>'$data["companyname"]',
					),
                    array(
						'header'=>$this->getCatalog('storagedoc'),
						'name'=>'storagedocid', 
						'value'=>'$data["storagedocname"]',
					),
				),
			));?>
			</div>
		</div>
	</div>
</div>