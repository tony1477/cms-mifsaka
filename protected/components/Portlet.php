<?php
Yii::import('zii.widgets.CPortlet');
 
class Portlet extends CPortlet
{
	public function eja($n) 
	{
		$dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
		$angka = array(1000000000,1000000,1000,100,10,1);
		$satuan = array('milyar','juta','ribu','ratus','puluh','');
		
		$i=0;
		$str="";
		while($n!=0){
			$count = (int)($n/$angka[$i]);
			if($count>=10) $str .= $this->eja($count). " ".$satuan[$i]." ";
			else if($count > 0 && $count < 10)
				$str .= $dasar[$count] . " ".$satuan[$i]." ";
			$n -= $angka[$i] * $count;
			$i++;
		}
		$str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
		$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);
		return $str;
	}
	
	public function truncateword($string, $limit, $break=".", $pad="...")
	{
		$string = str_replace('<strong>','',$string);
		$string = str_replace('</strong>','',$string);
		$string = str_replace('<h2>','',$string);
		$string = str_replace('</h2>','',$string);
		$string = str_replace('<td>','',$string);
		$string = str_replace('</td>','',$string);
		$string = str_replace('</tr>','',$string);
		$string = str_replace('<tr>','',$string);		
		$string = str_replace('<tbody>','',$string);
		$string = str_replace('</tbody>','',$string);
		$string = str_replace('</thead>','',$string);
		$string = str_replace('<thead>','',$string);
		$string = str_replace('&nbsp;','',$string);
		$string = str_replace("\n",'',$string);
		$string = str_replace("\"",'',$string);
		// return with no change if string is shorter than $limit
		if(strlen($string) <= $limit) return $string;

		// is $break present between $limit and the end of the string?
		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
			if($breakpoint < strlen($string) - 1) {
				$string = substr($string, 0, $breakpoint) . $pad;
			}
		}
		return $string;
	}
	
	public function GetCatalog($menuname)
  {
		if (Yii::app()->user->id !== null)
		{
			$sql = "select catalogval as katalog ".
			" from catalogsys a ".
			" inner join useraccess b on b.languageid = a.languageid ".
			" where lower(catalogname) = lower('".$menuname."') and lower(b.username) = lower('". Yii::app()->user->id ."')";
		}
		else
		{
			$sql = "select catalogval as katalog ".
			" from catalogsys a ".
			" inner join useraccess b on b.languageid = a.languageid ".
			" where lower(catalogname) = lower('".$menuname."')";
		}
		$menu = Yii::app()->db->createCommand($sql)->queryRow();
    if ($menu['katalog'] !== null)
    {
      return  $menu['katalog'];
    }
    else 
    {
      return $menuname;
    }
  }
	
	public function GetParameter($paramname)
	{
		$sql = "select paramvalue ".
			" from parameter a ".
			" where lower(paramname) = lower('".$paramname."')";
		$menu = Yii::app()->db->createCommand($sql)->queryRow();
		return $menu['paramvalue'];
	}
	
	public function WidgetRegistration($widgetname,$widgettitle,$widgetby,$widgetversion,$description,$widgeturl,$modulename)
	{
		$sql = "select ifnull(count(1),0) as jumlah ".
			" from widget a ".
			" where lower(widgetname) = lower('".$widgetname."')";
		$menu = Yii::app()->db->createCommand($sql)->queryRow();
		if ($menu['jumlah'] == 0)
		{
			$sql = "select ifnull(moduleid,0) as moduleid ".
			" from modules a ".
			" where lower(modulename) = lower('".$modulename."')";
			$moduleid = Yii::app()->db->createCommand($sql)->queryRow();
			if ($moduleid > 0)
			{
				$sql = "insert into widget (widgetname,widgettitle,widgetby,widgetversion,description,widgeturl,moduleid ".
					" values ('".$widgetname."','".$widgettitle."','".$widgetby."','".$widgetversion."','".$description."','".$widgeturl."',".$moduleid.")";
				Yii::app()->db->execute();
			}
		}
	}
	
	public function getMenuModule($menuname='null')
	{
		$sql = "select a.modulename 
			from modules a
			join menuaccess b on b.moduleid = a.moduleid 
			where b.menuname = '".$menuname."'";
		return Yii::app()->db->createCommand($sql)->queryScalar().'/'.$menuname."/";
	}
}