<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Latest Order</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<ul class="products-list product-list-in-box">
		<?php 
		$products = Yii::app()->db->createCommand('select a.sono, c.oldnik, b.fullname,a.sodate,c.fullname as sales,
		getamountdiscbyso(a.soheaderid) as total,d.companyname,c.photo
from soheader a
inner join addressbook b on b.addressbookid = a.addressbookid
inner join employee c on c.employeeid = a.employeeid 
inner join company d on d.companyid = a.companyid 
where a.sono is not null and a.recordstatus = 6
order by a.soheaderid desc 
			limit 5')->queryAll();
		
		foreach ($products as $product)
		{
			echo '<li class="item">';
			echo '<div class="product-img">';
			echo '<img src="'.Yii::app()->baseUrl.'/images/employee/'.$product['photo'].'" alt="'.$product['sales'].'">';
			echo '</div>';
			echo '<div class="product-info">';
			echo $product['companyname'].'<span class="label label-primary pull-right">'.
				$product['sono'].'</span><br/>'.$product['sales'].'<span class="label label-danger pull-right">'.
				Yii::app()->format->formatDate($product['sodate']).'</span><br/>';			
			echo '<span class="label label-success pull-right">'.$product['fullname'].'</span><br/><span class="label label-warning pull-right">'.
				Yii::app()->format->formatCurrency($product['total']).'</span>';
			echo '</div>';
			echo '</li>';
		}
		?>
		</ul>
	</div><!-- /.box-body -->
</div><!-- /.box -->
