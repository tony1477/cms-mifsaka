<script src="<?php echo Yii::app()->baseUrl;?>/js/slocaccounting.js"></script>
<h3><?php echo $this->getCatalog('slocaccounting') ?></h3>
<?php if ($this->checkAccess('slocaccounting','iswrite')) { ?>
<button name="CreateButton" type="button" class="btn btn-primary" onclick="newdata()"><?php echo $this->getCatalog('new')?></button>
<?php } ?>

<?php if ($this->checkAccess('slocaccounting','isreject')) { ?>
<button name="DeleteButton" type="button" class="btn btn-warning" onclick="deletedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('delete')?></button>
<?php } ?>
<?php if ($this->checkAccess('slocaccounting','ispurge')) { ?>
<button name="PurgeButton" type="button" class="btn btn-danger" onclick="purgedata($.fn.yiiGridView.getSelection('GridList'))"><?php echo $this->getCatalog('purge')?></button>
<?php } ?>
<button name="SearchButton" type="button" class="btn btn-success" data-toggle="modal" data-target="#SearchDialog"><?php echo $this->getCatalog('search')?></button>
<?php if ($this->checkAccess('slocaccounting','isdownload')) { ?>
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
							'visible'=>$this->booltostr($this->checkAccess('slocaccounting','iswrite')),							
							'url'=>'"#"',
							'click'=>"function() { 
								updatedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'delete' => array
					(
							'label'=>$this->getCatalog('delete'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/active.png',
							'visible'=>$this->booltostr($this->checkAccess('slocaccounting','isreject')),							
							'url'=>'"#"',
							'click'=>"function() { 
								deletedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'purge' => array
					(
							'label'=>$this->getCatalog('purge'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/trash.png',
							'visible'=>$this->booltostr($this->checkAccess('slocaccounting','ispurge')),							
							'url'=>'"#"',
							'click'=>"function() { 
								purgedata($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'pdf' => array
					(
							'label'=>$this->getCatalog('downpdf'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/pdf.png',
							'visible'=>$this->booltostr($this->checkAccess('slocaccounting','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downpdf($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
					'xls' => array
					(
							'label'=>$this->getCatalog('downxls'),
							'imageUrl'=>Yii::app()->baseUrl.'/images/xls.png',
							'visible'=>$this->booltostr($this->checkAccess('slocaccounting','isdownload')),
							'url'=>'"#"',
							'click'=>"function() { 
								downxls($(this).parent().parent().children(':nth-child(3)').text());
							}",
					),
				),
			),
array(
					'header'=>$this->getCatalog('slocaccid'),
					'name'=>'slocaccid',
					'value'=>'$data["slocaccid"]'
				),
							array(
					'header'=>$this->getCatalog('sloccode'),
					'name'=>'slocid',
					'value'=>'$data["sloccode"]'
				),
							array(
					'header'=>$this->getCatalog('materialgroupcode'),
					'name'=>'materialgroupid',
					'value'=>'$data["materialgroupcode"]'
				),
							array(
					'header'=>$this->getCatalog('accaktivatetap'),
					'name'=>'accaktivatetap',
					'value'=>'$data["accaktivatetapname"]'
				),
							array(
					'header'=>$this->getCatalog('accakumatname'),
					'name'=>'accakumat',
					'value'=>'$data["accakumatname"]'
				),
							array(
					'header'=>$this->getCatalog('accbiayaatname'),
					'name'=>'accbiayaat',
					'value'=>'$data["accbiayaatname"]'
				),
							array(
					'header'=>$this->getCatalog('accpersediaanname'),
					'name'=>'accpersediaan',
					'value'=>'$data["accpersediaanname"]'
				),
							array(
					'header'=>$this->getCatalog('accreturpembelianname'),
					'name'=>'accreturpembelian',
					'value'=>'$data["accreturpembelianname"]'
				),
							array(
					'header'=>$this->getCatalog('accdiscpembelianname'),
					'name'=>'accdiscpembelian',
					'value'=>'$data["accdiscpembelianname"]'
				),
							array(
					'header'=>$this->getCatalog('accpenjualanname'),
					'name'=>'accpenjualan',
					'value'=>'$data["accpenjualanname"]'
				),
							array(
					'header'=>$this->getCatalog('accbiayaname'),
					'name'=>'accbiaya',
					'value'=>'$data["accbiayaname"]'
				),
							array(
					'header'=>$this->getCatalog('accreturpenjualanname'),
					'name'=>'accreturpenjualan',
					'value'=>'$data["accreturpenjualanname"]'
				),
							array(
					'header'=>$this->getCatalog('accspsiname'),
					'name'=>'accspsi',
					'value'=>'$data["accspsiname"]'
				),
							array(
					'header'=>$this->getCatalog('accexpedisiname'),
					'name'=>'accexpedisi',
					'value'=>'$data["accexpedisiname"]'
				),
							array(
					'header'=>$this->getCatalog('acchppname'),
					'name'=>'hpp',
					'value'=>'$data["acchppname"]'
				),
							array(
					'header'=>$this->getCatalog('accupahlemburname'),
					'name'=>'accupahlembur',
					'value'=>'$data["accupahlemburname"]'
				),
							array(
					'header'=>$this->getCatalog('accfohname'),
					'name'=>'foh',
					'value'=>'$data["accfohname"]'
				),
                            array(
					'header'=>$this->getCatalog('acckoreksiname'),
					'name'=>'acckoreksi',
					'value'=>'$data["acckoreksiname"]'
				),          
                            array(
					'header'=>$this->getCatalog('acccadanganname'),
					'name'=>'acccadangan',
					'value'=>'$data["acccadanganname"]'
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
						<label for="dlg_search_sloccode"><?php echo $this->getCatalog('sloccode')?></label>
						<input type="text" class="form-control" name="dlg_search_sloccode">
					</div>
          <div class="form-group">
						<label for="dlg_search_materialgroupcode"><?php echo $this->getCatalog('materialgroupcode')?></label>
						<input type="text" class="form-control" name="dlg_search_materialgroupcode">
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
        <h4 class="modal-title"><?php echo $this->getCatalog('slocaccounting') ?></h4>
      </div>
      <div class="modal-body">
				<input type="hidden" class="form-control" name="slocaccounting_0_slocaccid">
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_slocid','ColField'=>'slocaccounting_0_sloccode',
							'IDDialog'=>'slocaccounting_0_slocid_dialog','titledialog'=>$this->getCatalog('sloccode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.SlocPopUp','PopGrid'=>'slocaccounting_0_slocidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_materialgroupid','ColField'=>'slocaccounting_0_materialgroupcode',
							'IDDialog'=>'slocaccounting_0_materialgroupid_dialog','titledialog'=>$this->getCatalog('materialgroupcode'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8',
							'PopUpName'=>'common.components.views.MaterialgrouptrxPopUp','PopGrid'=>'slocaccounting_0_materialgroupidgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accaktivatetap','ColField'=>'slocaccounting_0_accaktivatetapname',
							'IDDialog'=>'slocaccounting_0_accaktivatetap_dialog','titledialog'=>$this->getCatalog('accaktivatetap'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accaktivatetapgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accakumat','ColField'=>'slocaccounting_0_accakumatname',
							'IDDialog'=>'slocaccounting_0_accakumat_dialog','titledialog'=>$this->getCatalog('accakumatname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accakumatgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accbiayaat','ColField'=>'slocaccounting_0_accbiayaatname',
							'IDDialog'=>'slocaccounting_0_accbiayaat_dialog','titledialog'=>$this->getCatalog('accbiayaatname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accbiayaatgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accpersediaan','ColField'=>'slocaccounting_0_accpersediaanname',
							'IDDialog'=>'slocaccounting_0_accpersediaan_dialog','titledialog'=>$this->getCatalog('accpersediaanname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accpersediaangrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accreturpembelian','ColField'=>'slocaccounting_0_accreturpembelianname',
							'IDDialog'=>'slocaccounting_0_accreturpembelian_dialog','titledialog'=>$this->getCatalog('accreturpembelianname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accreturpembeliangrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accdiscpembelian','ColField'=>'slocaccounting_0_accdiscpembelianname',
							'IDDialog'=>'slocaccounting_0_accdiscpembelian_dialog','titledialog'=>$this->getCatalog('accdiscpembelianname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accdiscpembeliangrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accpenjualan','ColField'=>'slocaccounting_0_accpenjualanname',
							'IDDialog'=>'slocaccounting_0_accpenjualan_dialog','titledialog'=>$this->getCatalog('accpenjualanname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accpenjualangrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accbiaya','ColField'=>'slocaccounting_0_accbiayaname',
							'IDDialog'=>'slocaccounting_0_accbiaya_dialog','titledialog'=>$this->getCatalog('accbiayaname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accbiayagrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accreturpenjualan','ColField'=>'slocaccounting_0_accreturpenjualanname',
							'IDDialog'=>'slocaccounting_0_accreturpenjualan_dialog','titledialog'=>$this->getCatalog('accreturpenjualanname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accreturpenjualangrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accspsi','ColField'=>'slocaccounting_0_accspsiname',
							'IDDialog'=>'slocaccounting_0_accspsi_dialog','titledialog'=>$this->getCatalog('accspsiname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accspsigrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accexpedisi','ColField'=>'slocaccounting_0_accexpedisiname',
							'IDDialog'=>'slocaccounting_0_accexpedisi_dialog','titledialog'=>$this->getCatalog('accexpedisiname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accexpedisigrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_hpp','ColField'=>'slocaccounting_0_acchppname',
							'IDDialog'=>'slocaccounting_0_hpp_dialog','titledialog'=>$this->getCatalog('acchppname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_hppgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_accupahlembur','ColField'=>'slocaccounting_0_accupahlemburname',
							'IDDialog'=>'slocaccounting_0_accupahlembur_dialog','titledialog'=>$this->getCatalog('accupahlemburname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_accupahlemburgrid')); 
					?>
							
        <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_foh','ColField'=>'slocaccounting_0_accfohname',
							'IDDialog'=>'slocaccounting_0_foh_dialog','titledialog'=>$this->getCatalog('accfohname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_fohgrid')); 
					?>
          
         <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_acckoreksi','ColField'=>'slocaccounting_0_acckoreksiname',
							'IDDialog'=>'slocaccounting_0_koreksi_dialog','titledialog'=>$this->getCatalog('acckoreksiname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_koreksigrid')); 
					?>
          
         <?php $this->widget('DataPopUp',
						array('id'=>'Widget','IDField'=>'slocaccounting_0_acccadangan','ColField'=>'slocaccounting_0_acccadanganname',
							'IDDialog'=>'slocaccounting_0_acccadangan_dialog','titledialog'=>$this->getCatalog('acccadanganname'),'classtype'=>'col-md-4',
							'classtypebox'=>'col-md-8','RelationID'=>'slocaccounting_0_slocid',
							'PopUpName'=>'accounting.components.views.AccountslocPopUp','PopGrid'=>'slocaccounting_0_acccadangangrid')); 
					?>
							
				
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-success" onclick="savedata()"><?php echo $this->getCatalog('save')?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->getCatalog('close')?></button>
      </div>
    </div>
  </div>
</div>


