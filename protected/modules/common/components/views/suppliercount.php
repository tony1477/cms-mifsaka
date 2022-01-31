<?php 
$usercount = Yii::app()->db->createCommand('select ifnull(count(1),0)
from addressbook a where isvendor = 1')->queryScalar();
?>

<div class="info-box">
	<span class="info-box-icon bg-red"><i class="ion ion-ios-paper"></i></span>
	<div class="info-box-content">
		<span class="info-box-text"><?php echo $this->getCatalog('supplier')?></span>
		<span class="info-box-number"><?php echo $usercount?></span>
	</div><!-- /.info-box-content -->
</div><!-- /.info-box -->