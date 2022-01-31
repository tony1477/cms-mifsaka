<style type="text/css">
.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +1000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:10%;
  left:10%;
}
</style>
<div class="ajax-loader">
  <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" class="img-responsive" />
</div>
<script type="text/javascript">
function tampil_loading(){
    $('.ajax-loader').css('visibility', 'visible');
}

function tutup_loading(){
    $('.ajax-loader').css("visibility", "hidden");
}
function newdata()
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/create')?>','data':{},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
			$("input[name='legaldoc_0_legaldocid']").val(data.legaldocid);
			$("input[name='legaldoc_0_doctypeid']").val('');
			$("input[name='legaldoc_0_doctypename']").val('');
            $("input[name='legaldoc_0_docname']").val('');
            $("input[name='legaldoc_0_docno']").val('');
            $("input[name='legaldoc_0_docdate']").val(data.docdate);
            $("input[name='legaldoc_0_expireddate']").val(data.expireddate);
            $("input[name='legaldoc_0_doccompanyid']").val('');
            $("input[name='legaldoc_0_companyname']").val('');
            $("input[name='legaldoc_0_storagedocid']").val('');
            $("input[name='legaldoc_0_storagedocname']").val('');
            $("textarea[name='legaldoc_0_description']").val('');
			
			$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function updatedata($id)
{
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/update')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$("input[name='legaldoc_0_legaldocid']").val(data.legaldocid);
				$("input[name='legaldoc_0_doctypeid']").val(data.doctypeid);
				$("input[name='legaldoc_0_doctypename']").val(data.doctypename);
                $("input[name='legaldoc_0_docname']").val(data.docname);
                $("input[name='legaldoc_0_docno']").val(data.docno);
                $("input[name='legaldoc_0_docdate']").val(data.docdate);
                $("input[name='legaldoc_0_expireddate']").val(data.expireddate);
                $("input[name='legaldoc_0_doccompanyid']").val(data.doccompanyid);
                $("input[name='legaldoc_0_companyname']").val(data.companyname);
                $("input[name='legaldoc_0_storagedocid']").val(data.storagedocid);
                $("input[name='legaldoc_0_storagedocname']").val(data.storagedocname);
                $("textarea[name='legaldoc_0_description']").val(data.description);
				
				$('#InputDialog').modal();
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	return false;
}

function savedata()
{

	$('.ajax-loader').css('visibility', 'visible');
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/save')?>',
		'data':{
			'legaldocid':$("input[name='legaldoc_0_legaldocid']").val(),
			'doctypeid':$("input[name='legaldoc_0_doctypeid']").val(),
            'docname':$("input[name='legaldoc_0_docname']").val(),
            'docno':$("input[name='legaldoc_0_docno']").val(),
            'docdate':$("input[name='legaldoc_0_docdate']").val(),
            'expireddate':$("input[name='legaldoc_0_expireddate']").val(),
            'doccompanyid':$("input[name='legaldoc_0_doccompanyid']").val(),
            'storagedocid':$("input[name='legaldoc_0_storagedocid']").val(),
            'description':$("textarea[name='legaldoc_0_description']").val(),
		},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				$('#InputDialog').modal('hide');
				tutup_loading();
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				tutup_loading();
				toastr.error(data.div);
			}
		},
		'cache':false});
}

function approvedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/approve')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});	});
	return false;
}
function deletedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){	
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/delete')?>',
		'data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
	'cache':false});});
	return false;
}

function purgedata($id)
{
	$.msg.confirmation('Confirm','<?php echo $this->getCatalog('areyousure')?>',function(){
	jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('hr/legaldoc/purge')?>','data':{'id':$id},
		'type':'post','dataType':'json',
		'success':function(data) {
			if (data.status == "success")
			{
				toastr.info(data.div);
				$.fn.yiiGridView.update("GridList");
			}
			else
			{
				toastr.error(data.div);
			}
		},
		'cache':false});
	});
	return false;
}

function searchdata($id=0)
{
	$('#SearchDialog').modal('hide');
	var array = 'legaldoc_0_legaldocid='+$id
+ '&docname='+$("input[name='dlg_search_docname']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	$.fn.yiiGridView.update("GridList",{data:array});
	return false;
}

function downpdf($id=0) {
	var array = 'legaldoc_0_legaldocid='+$id
+ '&docname='+$("input[name='dlg_search_docname']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/legaldoc/downpdf')?>?'+array);
}

function downxls($id=0) {
	var array = 'legaldoc_0_legaldocid='+$id
+ '&docname='+$("input[name='dlg_search_docname']").val()
+ '&docno='+$("input[name='dlg_search_docno']").val();
	window.open('<?php echo Yii::app()->createUrl('Hr/legaldoc/downxls')?>?'+array);
}

function GetDetail($id)
{
	$('#ShowDetailDialog').modal('show');
	var array = 'legaldocid='+$id
} 
</script>
<h3><?php echo $this->getCatalog('legaldoc') ?></h3>
<?php if ($this->checkAccess('legaldoc','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>
<?php /*if ($this->checkAccess('legaldoc','ispost')) { ?>
<button name="ApproveButton" type="button" class="btn btn-success" onclick="approvedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('approve')?></button>
<?php } ?>
<?php if ($this->checkAccess('legaldoc','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('reject')?></button>
<?php } ?>
<?php if ($this->checkAccess('legaldoc','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } */ ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('legaldoc','isdownload')) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <?php echo $this->getCatalog('download')?> <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
      <li><a onclick="downpdf($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downpdf')?></a></li>
      <li><a onclick="downxls($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('downxls')?></a></li>
    </ul>
  </div>
<?php } ?>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
		'id'=>'GridList',
		'selectableRows'=>2,
    'ajaxUpdate'=>true,
		'filter'=>null,
		'enableSorting'=>true,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
				'id'=>'ids',
				'htmlOptions' => array('style'=>'width:10px'),
			),
			array
			(
				'class'=>'CButtonColumn',
				'template'=>'{edit} {delete} {purge} {pdf} {xls}',
				'htmlOptions' => array('style'=>'width:160px'),
				'buttons'=>array
				(
					'edit' => array
					(
							'label'=>$this->getCatalog('edit'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
							'visible'=>$this->booltostr($this->checkAccess('legaldoc','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('legaldoc','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('legaldoc','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('legaldoc','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							//'visible'=>$this->booltostr($this->checkAccess('legaldoc','isdownload')),
							'visible'=>'false',
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('legaldocid'),
					'name'=>'legaldocid',
					'value'=>'$data["legaldocid"]'
				),
							array(
					'header'=>$this->getCatalog('doctype'),
					'name'=>'doctypeid',
					'value'=>'$data["doctypename"]'
				),
							array(
					'header'=>$this->getCatalog('docname'),
					'name'=>'docname',
					'value'=>'$data["docname"]'
				),
							array(
					'header'=>$this->getCatalog('docno'),
					'name'=>'docno',
					'value'=>'$data["docno"]'
				),
							array(
					'header'=>$this->getCatalog('docdate'),
					'name'=>'docdate',
					'value'=>'Yii::app()->format->formatDate($data["docdate"])'
				),
                            array(
					'header'=>$this->getCatalog('expireddate'),
					'name'=>'expireddate',
					'value'=>'Yii::app()->format->formatDate($data["expireddate"])'
				),
							array(
					'header'=>$this->getCatalog('company'),
					'name'=>'doccompanyid',
					'value'=>'$data["companyname"]'
				),
							array(
					'header'=>$this->getCatalog('storagedoc'),
					'name'=>'storagedocid',
					'value'=>'$data["storagedocname"]'
				),
							array(
					'header'=>$this->getCatalog('description'),
					'name'=>'description',
					'value'=>'$data["description"]'
				),
							
		)
));
?>
<div id="SearchDialog" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('search') ?></h4>
      </div>
				<div class="modal-body">
					<div class="form-group">
						<label for="dlg_search_docname"><?php echo $this->getCatalog('docname')?></label>
						<input type="text" class="form-control" name="dlg_search_docname">
					</div>
                <div class="form-group">
						<label for="dlg_search_docno"><?php echo $this->getCatalog('docno')?></label>
						<input type="text" class="form-control" name="dlg_search_docno">
					</div>
                    
                <div class="form-group">
						<label for="dlg_search_storagedocname"><?php echo $this->getCatalog('storagedocname')?></label>
						<input type="text" class="form-control" name="dlg_search_storagedocname">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" onclick="searchdata()"><?php echo $this->getCatalog('search')?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
				</div>
		</div>
	</div>
</div>
<div id="InputDialog" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->getCatalog('legaldoc') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="legaldoc_0_legaldocid">
          
          <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'legaldoc_0_doctypeid','ColField'=>'legaldoc_0_doctypename',
					'IDDialog'=>'doctype_dialog','titledialog'=>$this->getCatalog('doctype'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'hr.components.views.DoctypePopUp','PopGrid'=>'doctypegrid')); 
			?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="legaldoc_0_docname"><?php echo $this->getCatalog('docname')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="legaldoc_0_docname">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="legaldoc_0_docdate"><?php echo $this->getCatalog('docdate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="legaldoc_0_docdate">
						</div>
					</div>
          
        <div class="row">
						<div class="col-md-4">
							<label for="legaldoc_0_expireddate"><?php echo $this->getCatalog('expireddate')?></label>
						</div>
						<div class="col-md-8">
							<input type="date" class="form-control" name="legaldoc_0_expireddate">
						</div>
					</div>
							
        <div class="row">
						<div class="col-md-4">
							<label for="legaldoc_0_docno"><?php echo $this->getCatalog('docno')?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="legaldoc_0_docno">
						</div>
					</div>
							
        <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'legaldoc_0_doccompanyid','ColField'=>'legaldoc_0_companyname',
					'IDDialog'=>'company_dialog','titledialog'=>$this->getCatalog('company'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'admin.components.views.CompanyPopUp','PopGrid'=>'companygrid')); 
			?>
							
        <?php $this->widget('DataPopUp',
				array('id'=>'Widget','IDField'=>'legaldoc_0_storagedocid','ColField'=>'legaldoc_0_storagedocname',
					'IDDialog'=>'storagedoc_dialog','titledialog'=>$this->getCatalog('storagedoc'),'classtype'=>'col-md-4',
					'classtypebox'=>'col-md-8',
					'PopUpName'=>'hr.components.views.StoragedocPopUp','PopGrid'=>'storagedocgrid')); 
			?>
							
        <div class="row">
						<div class="col-md-4">
							<label for="legaldoc_0_description"><?php echo $this->getCatalog('description')?></label>
						</div>
						<div class="col-md-8">
							<textarea type="text" class="form-control" rows="5" name="legaldoc_0_description"></textarea>
						</div>
					</div>
							
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


