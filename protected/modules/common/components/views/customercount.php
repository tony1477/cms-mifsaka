<?php 
$usercount = Yii::app()->db->createCommand('select ifnull(count(1),0)
from addressbook a where iscustomer = 1')->queryScalar();
?>

<div class="info-box">
	<span class="info-box-icon bg-green"><i class="ion ion-ios-paper"></i></span>
	<div class="info-box-content">
		<span class="info-box-text"><?php echo $this->getCatalog('customer')?></span>
		<span class="info-box-number"><?php echo $usercount?></span>
	</div><!-- /.info-box-content -->
</div><!-- /.info-box -->