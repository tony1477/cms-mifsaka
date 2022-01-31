<?php 
$useronline = Yii::app()->db->createCommand('select ifnull(count(1),0)
from useraccess a where isonline = 1')->queryScalar();
?>

<div class="info-box">
	<span class="info-box-icon bg-green"><i class="ion ion-earth"></i></span>
	<div class="info-box-content">
		<span class="info-box-text"><?php echo $this->getCatalog('useronline')?></span>
		<span class="info-box-number"><?php echo $usercount?></span>
	</div><!-- /.info-box-content -->
</div><!-- /.info-box -->