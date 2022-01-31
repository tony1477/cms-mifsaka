<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Top 10 Customer Debt</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<ul class="products-list product-list-in-box">
		<?php 
		$products = Yii::app()->db->createCommand('select fullname,currentlimit,creditlimit 
			from addressbook 
			where iscustomer = 1 and currentlimit > 0 
			order by currentlimit desc 
			limit 10')->queryAll();
		foreach ($products as $product)
		{
			echo '<li class="item">';
			echo '<div class="product-info">';
			echo $product['fullname'];
			if ($product['currentlimit'] > $product['creditlimit'])
			{
				echo '<span class="label label-danger pull-right">'.Yii::app()->format->formatCurrency($product['creditlimit']).'</span>';
			}
			else
			if ($product['currentlimit'] < $product['creditlimit'])
			{
				echo '<span class="label label-success pull-right">'.Yii::app()->format->formatCurrency($product['currentlimit']).'</span>';
			}
			else
			if ($product['currentlimit'] = $product['creditlimit'])
			{
				echo '<span class="label label-warning pull-right">'.Yii::app()->format->formatCurrency($product['currentlimit']).'</span>';				
			}
			echo '</div>';
			echo '</li>';
		}
		?>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /.box -->