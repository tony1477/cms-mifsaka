<?php
class Controller extends CController
{
	//layout
	public $layout='//layouts/column1';
	
	//seo
	protected $pageTitle='';
	protected $metatag = array();
	protected $description='';
	
	//internal
	protected $pdf;
	protected $menuname = '';
	protected $module = '';
	protected $sqldata='';
	protected $sqlcount='';
	protected $count = 0;
	protected $storeFolder = '';
	protected $wfname = '';
    protected $uploaded_file;
	protected $phpExcel;
	public $dict = array(
			'dictDefaultMessage'=>'Drop files here or click to Upload',
			'dictFallbackMessage'=>'Your Browser doesn\'t support',
			'dictInvalidFileType'=>'File Type not allowed (only zip)',
			'dictFileTooBig'=>'Your File Too Big, Max 2MB',
			'dictResponseError'=>'Oops! something wrong',
			'dictCancelUpload'=>'Cancelled',
			'dictCancelUploadConfirmation'=>'Are you sure to cancel this upload ?',
			'dictRemoveFile'=>'Delete',
			'dictMaxFilesExceeded'=>'Maximum file exceeded',
	);
	public $options = array(
			'addRemoveLinks'=>true,
	);
	
	public function parseToXML($htmlStr) 
	{ 
		$xmlStr=str_replace('<','&lt;',$htmlStr); 
		$xmlStr=str_replace('>','&gt;',$xmlStr); 
		$xmlStr=str_replace('"','&quot;',$xmlStr); 
		$xmlStr=str_replace("'",'&#39;',$xmlStr); 
		$xmlStr=str_replace("&",'&amp;',$xmlStr); 
		return $xmlStr; 
	} 
	public function GetMenuAuth($menuobject)
  {
    $baccess = 'false';
    $sql     = "select ifnull(count(1),0)
			from groupmenuauth gm
			inner join menuauth ma on ma.menuauthid = gm.menuauthid
			inner join usergroup ug on ug.groupaccessid = gm.groupaccessid
			inner join useraccess ua on ua.useraccessid = ug.useraccessid
			where upper(ma.menuobject) = upper('" . $menuobject . "') 
			and lower(ua.username) = lower('" . Yii::app()->user->id . "')";
    $data    = Yii::app()->db->createCommand($sql)->queryScalar();
    if ($data == 0) {
      $baccess = 'true';
    } else {
      $baccess = 'false';
    }
    return $baccess;
  }
	
	public function getTheme($isadmin=false)
	{
		$theme = Yii::app()->theme;
		$userid = Yii::app()->user->id;
		if ($userid == '')
		{
			$userid = 'Guest';
		}
		$theme = Yii::app()->db->createCommand(
			"select themename
			from theme a 
			join useraccess b on b.themeid = a.themeid 
			where lower(b.username) = lower('".$userid."')")->queryScalar();
		Yii::app()->theme = $theme;
	}
	
	public function getCompany()
	{
		$dependency = new CDbCacheDependency('select max(companyid) from company');
		$company = Yii::app()->db->cache(1000,$dependency)->createCommand(
			"select companyid,companyname
			from company a  
			where companyid = ".$this->getParameter('companyid'))->queryRow();
		return $company;
	}
	
	public function getMenuModule($menuname='null')
	{
		$dependency = new CDbCacheDependency('select max(menuaccessid) from menuaccess');
		$sql = "select a.modulename 
			from modules a
			join menuaccess b on b.moduleid = a.moduleid 
			where b.menuname = '".$menuname."'";
		return Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryScalar().'/'.$menuname;
	}
	
	protected function getMyID()
	{
		$dependency = new CDbCacheDependency('select max(companyid) from company');
		$id = Yii::app()->db->cache(1000,$dependency)->createCommand("select useraccessid from useraccess where lower(username) = lower('".Yii::app()->user->id."')")->queryScalar();
		return $id;
	}
	
	protected function getFooterXLS($excel)
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$this->getCatalog($this->menuname).'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save('php://output');
		unset($excel);
	}
	
	protected function rrmdir($dir) { 
		CFileHelper::removeDirectory($dir);
	}
	
	protected function getInboxLimit()
	{
		$sql = "select b.username,c.username as fromusername,a.description,a.senddate,a.recordstatus  
			from userinbox a 
			inner join useraccess b on b.useraccessid = a.useraccessid 
			inner join useraccess c on c.useraccessid = a.fromuserid 
			where b.username = '".Yii::app()->user->id."' 
			limit 5 ";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}	
	
	protected function booltostr($id)
	{
		if ($id == false)
		{
			return 'false';
		}
		else 
			if ($id == true)
		{
			return 'true';
		}
	}
	
	protected function inttobool($id)
	{
		if ($id === 0)
		{
			return false;
		}
		else 
			if ($id === 1)
		{
			return true;
		}
	}
	
	protected function inttostr($id)
	{
		if ($id === 0)
		{
			return 'Not Active';
		}
		else 
			if ($id === 1)
		{
			return 'Active';
		}
	}
	
	protected function strtoint($id)
	{
		if (strtolower($id) === "active")
		{
			return 1;
		}
		else 
			if (strtolower($id) === "not active")
		{
			return 0;
		}
	}
	
	protected function booltoint($id)
	{
		if ($id === false)
		{
			return 0;
		}
		else if ($id === true)
		{
			return 1;
		}
	}
	
	protected function display_seo()
	{
		echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">'."\n";
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">'."\n";
    echo '<meta name="description" content="">'."\n";
		echo '<meta name="generator" content="Capella CMS 1.0.0">';
		echo '<title>'.$this->GetParameter('sitetitle').' - '.$this->pageTitle.'</title>'."\n";
		echo '<meta property="og:site_name" content="'.$this->GetParameter('sitename').'">'."\n";
		echo '<meta property="og:description" content="'.$this->truncateword($this->description,100).'">'."\n";
		$s = count($this->metatag);
		if ($s > 0)
		{
			foreach($this->metatag as $meta)
			{
				echo '<meta property="article:tag" content="'.$meta.'">'."\n";
			}
		}
	}
	
	protected function getUserGroups()
	{
		$dependency = new CDbCacheDependency('select max(groupaccessid) from groupaccess');
		$sql = "select c.groupname
			from useraccess a
			join usergroup b on b.useraccessid = a.useraccessid
			join groupaccess c on c.groupaccessid = b.groupaccessid
			where lower(username) = lower('".Yii::app()->user->id."')";
		$rows = Yii::app()->db->cache(1000,$dependency)->createCommand($sql)->queryAll();
		$grups = '';
		foreach ($rows as $row)
		{
			$grups .= $row['groupname'].',';
		}
		return $grups;
	}
	
	protected function getUserData()
	{
		$sql = "select email,phoneno,realname
			from useraccess a 
			inner join usergroup b on b.useraccessid = a.useraccessid 
			where lower(username) = lower('".Yii::app()->user->id."')";
		$row = Yii::app()->db->createCommand($sql)->queryRow();
		return $row;
	}
	
	protected function getUserSuperMenu()
	{
		$sql = "select distinct d.menuurl,d.menuaccessid,d.menuname,d.description,
				(select count(1) from menuaccess e where e.parentid = d.menuaccessid) as jumlah,
				e.modulename
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid
			inner join modules e on e.moduleid = d.moduleid
			where d.recordstatus = 1 and c.isread = 1 and d.parentid is null and lower(username) = lower('".Yii::app()->user->id."')
			order by d.sortorder asc";
		$row = Yii::app()->db->createCommand($sql)->queryAll();
		return $row;
	}
	
	protected function getUserMenu($id)
	{
		$sql = "select distinct d.menuurl,d.menuname,d.description,e.modulename
			from useraccess a
			inner join usergroup b on b.useraccessid = a.useraccessid
			inner join groupmenu c on c.groupaccessid = b.groupaccessid
			inner join menuaccess d on d.menuaccessid = c.menuaccessid 
			inner join modules e on e.moduleid = d.moduleid 
			where d.recordstatus = 1 and c.isread = 1 and d.parentid = ".$id." and lower(username) = lower('".Yii::app()->user->id."') 
			order by d.sortorder asc";
		$row = Yii::app()->db->createCommand($sql)->queryAll();
		return $row;
	}
	
	protected function truncateword($text, $length, $ending="...", $exact = false, $considerHtml=true)
	{
			if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
					// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
						unset($open_tags[$pos]);
						}
					// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
	
	function eja($number)
  {
    $number       = str_replace(',', '', number_format($number, 2));
    $before_comma = trim($this->to_word($number));
    $after_comma  = trim($this->comma($number));
    $results      = $before_comma . ' koma ' . $after_comma;
    $results = str_replace('koma nol nol nol nol','',$results);
    $results = str_replace('koma nol nol nol','',$results);
    $results = str_replace('koma nol nol','',$results);
    $results = str_replace('nol nol','',$results);
    return ucwords($results);
  }
  function to_word($number)
  {
    $words      = "";
    $arr_number = array(
      "",
      "satu",
      "dua",
      "tiga",
      "empat",
      "lima",
      "enam",
      "tujuh",
      "delapan",
      "sembilan",
      "sepuluh",
      "sebelas"
    );
    
    if ($number == 0) {
      $words = " ";
    } else if (($number > 0) && ($number < 12)) {
      $words = " " . $arr_number[$number];
    } else if ($number < 20) {
      $words = $this->to_word($number - 10) . " belas";
    } else if ($number < 100) {
      $words = $this->to_word($number / 10) . " puluh " . $this->to_word($number % 10);
    } else if ($number < 200) {
      $words = "seratus " . $this->to_word($number - 100);
    } else if ($number < 1000) {
      $words = $this->to_word($number / 100) . " ratus " . $this->to_word($number % 100);
    } else if ($number < 2000) {
      $words = "seribu " . $this->to_word($number - 1000);
    } else if ($number < 1000000) {
      $words = $this->to_word($number / 1000) . " ribu " . $this->to_word($number % 1000);
    } else if ($number < 1000000000) {
      $words = $this->to_word($number / 1000000) . " juta " . $this->to_word($number % 1000000);
    } else if ($number < 1000000000000) {
      $words = $this->to_word($number / 1000000000) . " milyar " . $this->to_word($number % 1000000000);
    } else if ($number < 1000000000000000) {
      $words = $this->to_word($number / 1000000000000) . " trilyun " . $this->to_word($number % 1000000000000);
    } else {
      $words = "undefined";
    }
    return $words;
  }
  function comma($number)
  {
    $after_comma = stristr($number, '.');
    $arr_number  = array(
      "nol",
      "satu",
      "dua",
      "tiga",
      "empat",
      "lima",
      "enam",
      "tujuh",
      "delapan",
      "sembilan"
    );
    $results = "";
    $length  = strlen($after_comma);
    $i       = 1;
    while ($i < $length) {
      $get = substr($after_comma, $i, 1);
      $results .= " " . $arr_number[$get];
      $i++;
    }
    return $results;
  }
	
        protected function EAN13($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->BarcodeEan13($x,$y,$barcode,$h,$w,13);
	}
        function BarcodeEan13($x, $y, $barcode, $h, $w, $len)
	{
		//Padding
		$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
		if($len==12)
			$barcode='0'.$barcode;
		//Add or control the check digit
		if(strlen($barcode)==12)
			$barcode.=$this->GetCheckDigit($barcode);
		elseif(!$this->TestCheckDigit($barcode))
			$this->Error('Incorrect check digit');
		//Convert digits to bars
		$codes=array(
			'A'=>array(
				'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
				'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
			'B'=>array(
				'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
				'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
			'C'=>array(
				'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
				'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
			);
		$parities=array(
			'0'=>array('A','A','A','A','A','A'),
			'1'=>array('A','A','B','A','B','B'),
			'2'=>array('A','A','B','B','A','B'),
			'3'=>array('A','A','B','B','B','A'),
			'4'=>array('A','B','A','A','B','B'),
			'5'=>array('A','B','B','A','A','B'),
			'6'=>array('A','B','B','B','A','A'),
			'7'=>array('A','B','A','B','A','B'),
			'8'=>array('A','B','A','B','B','A'),
			'9'=>array('A','B','B','A','B','A')
			);
		$code='101';
		$p=$parities[$barcode[0]];
		for($i=1;$i<=6;$i++)
			$code.=$codes[$p[$i-1]][$barcode[$i]];
		$code.='01010';
		for($i=7;$i<=12;$i++)
			$code.=$codes['C'][$barcode[$i]];
		$code.='101';
		//Draw bars
		for($i=0;$i<strlen($code);$i++)
		{
			if($code[$i]=='1')
				$this->Rect($x+$i*$w,$y,$w,$h,'F');
		}
		//Print text uder barcode
		$this->SetFont('Arial','',12);
		$this->Text($x+1,$y+$h+11/$this->k,substr($barcode,-$len));
	}
        function GetCheckDigit($barcode)
	{
		//Compute the check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		$r=$sum%10;
		if($r>0)
			$r=10-$r;
		return $r;
	}
        function TestCheckDigit($barcode)
	{
		//Test validity of check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		return ($sum+$barcode[12])%10==0;
	}
	
	public function ValidateData($datavalidate)
	{
		$error = false;
		foreach($datavalidate as $x)
		{
			if (!isset($_POST[$x[0]]))
			{
				$error = true;
				$this->getMessage('error',$x[2]);
			}
			else
			if ($_POST[$x[0]] == '')
			{
				$error = true;
				$this->getMessage('error',$x[2]);
			}
		}
		return $error;
	}

	protected function RepairData($data,$datatype='string')
	{
		if (!isset($data))
		{
			$data='';
		}
		if ($datatype == 'string')
		{
			return $data!==null?$data:'';
		}
		else
		if ($datatype == 'boolean')
		{
			return $data!==null?$data:false;
		}
		else
		if ($datatype == 'numeric')
		{
			return $data!==null?$data:0;
		}
	}
	
	public function GetCatalog($menuname)
  {
		try
		{
			if (Yii::app()->user->id !== null)
			{
				$sql = "select catalogval as katalog 
					from catalogsys a 
					inner join useraccess b on b.languageid = a.languageid 
					where lower(catalogname) = lower('".$menuname."') and lower(b.username) = lower('". Yii::app()->user->id ."')";
			}
			else
			{
				$sql = "select catalogval as katalog 
					from catalogsys a 
					inner join useraccess b on b.languageid = a.languageid 
					where lower(catalogname) = lower('".$menuname."') limit 1";
			}
			$menu = Yii::app()->db->createCommand($sql)->queryRow();
			$s = '';
			if ($menu['katalog'] !== null)
			{
				$s = $menu['katalog'];
			}
			else 
			{
				$s = $menuname;
			}
			$s = str_replace("CDbCommand failed to execute the SQL statement: SQLSTATE[45000]: <<Unknown error>>: 1644","",$s);
			$s = str_replace("The SQL statement executed was: call ","",$s);
			$s = str_replace("CDbCommand failed to execute the SQL statement: SQLSTATE[42000]: Syntax error or access violation: 1305","",$s);
			return  $s;
		}
		catch (CDbException $ex)
		{
			return $ex->getMessage();
		}
  }
	
	protected function GetParameter($paramname)
	{
		try
		{
			$sql = "select paramvalue ".
				" from parameter a ".
				" where lower(paramname) = lower('".$paramname."')";
			$menu = Yii::app()->db->createCommand($sql)->queryScalar();
			return $menu;
		}
		catch (CDbException $ex)
		{
			return $ex->getMessage();
		}
	}
	
	protected function ValidateData2($datavalidate)
	{
		$error = false;
		foreach($datavalidate as $x)
		{
			if (!isset($_POST[$x[0]]))
			{
				$error = true;
				$this->getMessage('error',$x[2]);
			}
			else
			if ($_POST[$x[0]] == '')
			{
				$error = true;
				$this->getMessage('error',$x[2]);
			}
		}
		return $error;
	}
	
	protected function GetMessage($status,$catalogname)
	{
		$p = substr_count($catalogname, 'Duplicate entry');
		if ($p > 0)
		{
			$catalogname = 'duplicateentry';
		}	
		else		
		{
			$p = substr_count($catalogname, 'null');
			if ($p > 0)
			{
				$catalogname = 'notallownull';
			}
			else
			{
				/*$p = substr_count($catalogname, 'Integrity');
				if ($p > 0)
				{
					$catalogname = 'relationerror';
				}
				else
				{
					$p = substr_count($catalogname, 'Workflow tidak sesuai, silahkan kontak Admin');
					if ($p > 0)
					{
						$catalogname = 'Workflow tidak sesuai, silahkan kontak Admin';
					}
				}*/
			}
		}
		echo CJSON::encode(array(
			'status'=>$status,
			'div'=> $this->getcatalog($catalogname)
			));
		Yii::app()->end();
	}
	
	protected function CheckAccess($menuname='',$menuaction,$username='')
	{
	  $baccess=false;
		if ($username == '')
		{
			$sql = "select group_concat(".$menuaction.")
			from useraccess a 
			inner join usergroup b on b.useraccessid = a.useraccessid 
			inner join groupmenu c on c.groupaccessid = b.groupaccessid 
			inner join menuaccess d on d.menuaccessid = c.menuaccessid 
			where lower(username) = '".Yii::app()->user->id."' and lower(menuname) = '".$menuname."' ";
		} else 
		{
			$sql = "select group_concat(".$menuaction.")
			from useraccess a 
			inner join usergroup b on b.useraccessid = a.useraccessid 
			inner join groupmenu c on c.groupaccessid = b.groupaccessid 
			inner join menuaccess d on d.menuaccessid = c.menuaccessid 
			where lower(username) = '".$username."' and lower(menuname) = '".$menuname."' ";
		}
		$isaction=Yii::app()->db->createCommand($sql)->queryScalar();
		$exp = explode(',',$isaction);
		//if ($isaction > 0)
        if(in_array('1',$exp))
		{
			$baccess = true;
		}
		else {
			$baccess = false;
		}
		return $baccess;
	}
	
	protected function GetKey($username)
	{
		$sql = "select authkey from useraccess where lower(username) = '".$username."'";
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
	public function actionIndex()
	{
		$this->getTheme(false);
	}
	
	public function actionCreate()
	{
	}
	
	public function actionUpdate()
	{
	}
	
	public function actionSave()
	{
	}
	
	public function actionDelete()
	{
	}
	
	public function actionPurge()
	{
	}
	
	public function actionDownPDF()
	{
		/*//require_once("pdf.php");
		$this->pdf = new pdf();
		$this->pdf->AliasNbPages();
		*/
		if ((Yii::app()->user->id == '') || (Yii::app()->user->id == null)) {
			$this->redirect(Yii::app()->createUrl('site'));
		} else {	
						if ($this->checkAccess($this->menuname,'isdownload') == false) {
            //if (checkAccess($this->menuname, $this->isdownload) == false) {
				//getmessage(true, 'youarenotauthorized');
				Yii::app()->user->setFlash('error', "You are not authorized");
			} else {
                $uri = $_SERVER['REQUEST_URI'];
                $str = stripos($uri,"company");
                $str2 = stripos(substr($uri,$str),"&");
                
                $new2 = substr($uri,$str,$str2);
                $start = stripos($new2,"=");
                $cpy = substr($new2,$start+1);
                $new3 = substr($new2,0,$start);
                //echo $cpy;
                $authcomp = getUserObjectValuesarray('company');
                
                if($new3 == 'companyname')
                {
                    if($cpy!='')
                    {
                       // companyname/code
                      $companyid = GetCompanyid($cpy);
                    }
                    else
                    {
                      $companyid = getUserObjectValuesarray('company');
                      //$cpy=$companyid;
                    }
                    //echo $cpy;
                }
                else
                {
                    if($cpy!='')
                    {
                        $companyid = GetCompanyid($cpy,$cpy);
                    }
                    else if($cpy=='')
                    {
                        $companyid = getUserObjectValuesarray('company');
                        //$cpy=$companyid;
                    }
                    else
                    {
                        $companyid = getUserObjectValuesarray('company');
                        
                    }    
                }
                
                if($str==''){
                    $companyid = getUserObjectValuesarray('company');
                }
                
                if(array_intersect($authcomp,$companyid)) {
                    require_once("pdf.php");
                    //$this->connection = Yii::app()->db;
                    $this->pdf        = new PDF();
                    ob_start();
                }
                else 
								if (getUserObjectValues('reportgroup')==1) {
                    // get groupmenuatuh for group
                    require_once("pdf.php");
                    $this->pdf        = new PDF();
                    ob_start();
                }
                else
                {
                    //var_dump($authcomp);
                    //var_dump($companyid);
                    //getmessage(true, 'youarenotauthorized');
										Yii::app()->user->setFlash('error', "You are not authorized");
                    die();
                }

			}
		}
	}
	
	public function GetCompanyCode($id)
	{
		return Yii::app()->db->createCommand("
			select companycode
			from company 
			where companyid = ".$id)->queryScalar();
	} 
	
	public function actionDownXLS()
	{
		Yii::import('ext.phpexcel.XPHPExcel');      
		$this->phpExcel = XPHPExcel::createPHPExcel();
		$this->phpExcel->getProperties()->setCreator("Prisma Data Abadi")
			 ->setLastModifiedBy("Prisma Data Abadi")
			 ->setCompany("Prisma Data Abadi")
			 ->setTitle("Capella CMS")
			 ->setSubject("Capella CMS")
			 ->setDescription("Capella CMS")
			 ->setManager("Romy Andre")
			 ->setKeywords("capella cms php yii framework")
			 ->setCategory("Capella CMS");
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$filename = "";
		if (!file_exists(Yii::getPathOfAlias('webroot')."/protected/modules/".$this->menuname.".xlsx"))
		{
				$filename = Yii::getPathOfAlias('webroot')."/protected/modules/template.xlsx";
		}
		else
		{
			$filename = Yii::getPathOfAlias('webroot')."/protected/modules/".$this->menuname.".xlsx";
		}
		$this->phpExcel = $objReader->load($filename);
		$this->phpExcel->setActiveSheetIndex(0)->setCellValue('D2', $this->getCatalog($this->menuname));
	}
	
	public function actionPost()
	{
	}
	
	public function actionUpload()
	{
		if (!empty($_FILES)) {
			if ($this->storeFolder === '')
			{
				$this->storeFolder = dirname('__FILES__').'/uploads/';
			}
            $this->uploaded_file = $_FILES['upload']['name'];
			$original_name = pathinfo($this->uploaded_file, PATHINFO_FILENAME);
            $FileCounter=0;
            $extension =  pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            while (file_exists($this->storeFolder.$this->uploaded_file)) {
                 $FileCounter++;
                 $this->uploaded_file = $original_name. '_' . $FileCounter . '.' . $extension;
            }
            
			$tempFile = $_FILES['upload']['tmp_name'];                     			 									 
			$targetFile =  $this->storeFolder. $this->uploaded_file; 	 
			move_uploaded_file($tempFile,$targetFile);
		}
	}
	
	protected function InsertTranslog($command,$tableid='')
	{
		if ($this->getParameter('usinglog') == '1')
		{
			$useraction = 'Insert';
			if ($tableid !== '')
			{
				$useraction = 'Update';
			}
			else
			if ($tableid == '')
			{
				$sql = "select last_insert_id() as tableid";
				$id = Yii::app()->db->createCommand($sql)->queryRow();
				$tableid = $id['tableid'];
			}
			$newdata = $command->pdoStatement->queryString;
			foreach ($command->getParamLog() as $key => $value)
			{
				$newdata = str_replace($key,$value,$newdata);
			}
			$sql = "insert into translog(username,useraction,newdata,menuname,tableid)
				values ('".Yii::app()->user->id."','".$useraction."',\"".$newdata."\",'".$this->menuname."','".$tableid."')";
			Yii::app()->db->createCommand($sql)->execute();
		}
	}
}