<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Recently Added Products</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<ul class="products-list product-list-in-box">
		<?php 
		foreach ($products as $product)
		{
			echo '<li class="item">';
			echo '<div class="product-img">';
			echo '<img src="'.Yii::app()->baseUrl.'/images/product/'.$product['productpic'].'" alt="'.$product['productname'].'">';
			echo '</div>';
			echo '<div class="product-info">';
			echo $product['productname'].'<span class="label label-warning pull-right">'.
				$product['uom'].'</span>'.'<span class="label label-primary pull-right">'.
				Yii::app()->format->formatCurrency($product['productprice']).'</span>';
			echo '</div>';
			echo '</li>';
		}
		?>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /.box -->