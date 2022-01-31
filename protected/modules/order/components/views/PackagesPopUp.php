<?php
    $recordstatus = Yii::app()->db->createCommand("select getwfmaxstatbywfname('apppkg')")->queryScalar();

    $sqldata="select a.packageid,docno,packagename,startdate,enddate,headernote 
from packages a
where packagetype=1 and curdate() >= startdate and curdate() <= enddate and a.recordstatus={$recordstatus}
and a.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
and a.packagename like '%".(isset($_REQUEST['packagename'])?$_REQUEST['packagename']:'')."%'
union
select b.packageid,docno,packagename,startdate,enddate,headernote 
from packages b
join tempcompany b1 on b1.tableid = b.packageid
where b1.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')." and b.packagetype=2 and curdate() >= startdate and curdate() <= enddate and b.recordstatus={$recordstatus}
and b.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
and b.packagename like '%".(isset($_REQUEST['packagename'])?$_REQUEST['packagename']:'')."%'
union
select c.packageid,docno,packagename,startdate,enddate,headernote 
from packages c
join tempcustomer c1 on c1.tableid = c.packageid
where c1.customerid = ".(isset($_REQUEST['addressbookid'])?$_REQUEST['addressbookid']:'null')." and c.packagetype=3 and curdate() >= startdate and curdate() <= enddate and c.recordstatus={$recordstatus}
and c.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
and c.packagename like '%".(isset($_REQUEST['packagename'])?$_REQUEST['packagename']:'')."%'
union
select d.packageid,docno,packagename,startdate,enddate,headernote 
from packages d
join tempcompany d1 on d1.tableid = d.packageid
join tempcustomer d2 on d2.tableid = d.packageid
where d.packagetype=4 and d2.customerid = ".(isset($_REQUEST['addressbookid'])?$_REQUEST['addressbookid']:'null')." and d1.companyid = ".(isset($_REQUEST['companyid'])?$_REQUEST['companyid']:'null')."
and curdate() >= startdate and curdate() <= enddate and d.recordstatus={$recordstatus}
and d.docno like '%".(isset($_REQUEST['docno'])?$_REQUEST['docno']:'')."%'
and d.packagename like '%".(isset($_REQUEST['packagename'])?$_REQUEST['packagename']:'')."%' ";
    
$count = count(Yii::app()->db->createCommand($sqldata)->queryAll());
	$product=new CSqlDataProvider($sqldata,array(
			'totalItemCount'=>$count,
			'keyField'=>'packageid',
			'pagination'=>array(
				'pageSize'=>('DefaultPageSize'),
				'pageVar'=>'page',
			),
			'sort'=>array(
        'attributes'=>array(
             'packageid', 'docno', 'packagename','startdate','enddate','headernote'
        ),
				'defaultOrder' => array( 
					'docno' => CSort::SORT_DESC,
					
				),
			),
		));
		?>
<script>
function <?php echo $this->IDField?>searchdata()
{
	$.fn.yiiGridView.update("<?php echo $this->PopGrid?>",{data:{
		'companyid':$("input[name='<?php echo $this->RelationID?>']").val(),
		'addressbookid':$("input[name='<?php echo $this->RelationID2?>']").val(),
		'docno':$("input[name='<?php echo $this->ColField; ?>_search_docno']").val(),
		'packagename':$("input[name='<?php echo $this->ColField; ?>_search_packagename']").val(),
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
			$("input[name='<?php echo $this->ColField ?>']").val($(this).find("td:nth-child(3)").text());
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
				<label class="control-label" for="<?php echo $this->ColField; ?>_search_packagename"><?php echo $this->getCatalog('packagename') ?></label>
			</div>
			<div class="col-md-8">
				<div class="input-group">
					<input type="text" name="<?php echo $this->ColField; ?>_search_packagename" class="form-control">
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
			<?php	
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>$this->PopGrid,
				'selectableRows'=>1,
				'dataProvider'=>$product,
				'selectionChanged'=>'function(id){'.$this->PopGrid.'onSelectionChange()}',
				'columns'=>array(
					array(
						'header'=>$this->getCatalog('ttntdetailid'),
						'name'=>'packageid', 
						'value'=>'$data["packageid"]',
						'htmlOptions'=>array('width'=>'1%')
					),
                    array(
						'header'=>$this->getCatalog('docno'),
						'name'=>'docno', 
						'value'=>'$data["docno"]',
					),
                    array(
						'header'=>$this->getCatalog('packages'),
						'name'=>'packagename', 
						'value'=>'$data["packagename"]',
					),
					array(
						'header'=>$this->getCatalog('startdate'),
						'name'=>'startdate', 
						'value'=>'$data["startdate"]',
					),
					array(
						'header'=>$this->getCatalog('enddate'),
						'name'=>'enddate', 
						'value'=>'$data["enddate"]',
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