<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Recent Modules</h3>
  </div>
  <div class="panel-body">
    <?php
	foreach($this->getComments() as $post)
	{
		echo "<li>";
		echo "<p><a href='".Yii::app()->createUrl($post['modulename'])."'>".$post['description']."</a></p>";
		echo "</li>";
	}
?>
</ul>
  </div>
</div>
