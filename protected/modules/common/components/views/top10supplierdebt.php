<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Top 10 Supplier Debt</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<ul class="products-list product-list-in-box">
		<?php 
		$products = Yii::app()->db->createCommand('select fullname,currentdebt  
			from addressbook 
			where isvendor = 1 and currentdebt > 0 
			order by currentdebt desc 
			limit 10')->queryAll();
		foreach ($products as $product)
		{
			echo '<li class="item">';
			echo '<div class="product-info">';
			echo $product['fullname'];
			echo '<span class="label label-success pull-right">'.Yii::app()->format->formatCurrency($product['currentlimit']).'</span>';
			echo '</div>';
			echo '</li>';
		}
		?>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /.box -->