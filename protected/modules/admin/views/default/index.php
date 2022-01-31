<?php 
$position=0;$group=0;$i=0;
foreach($datas as $data)
{
	if ($i == 0)
	{
		echo "<div class='row'>";
		$group = $data['dashgroup'];
	}
	echo "<div class='".$data['webformat']."'>";
        echo 'apapapa';
	$this->widget($data['widgeturl']);	
	echo "</div>";	
	$i++;
	if ($i == $data['dashcount'])
	{
		echo "</div>";
		$i=0;
	}	
}
echo 'Disnis';
?>