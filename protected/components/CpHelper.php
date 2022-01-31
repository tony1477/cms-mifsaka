<?php
/*function GetCatalog($menuname) {
	$dependency = new CDbCacheDependency("select count(catalogsysid) from catalogsys");
    if (Yii::app()->user->id !== null) {
      $menu = Yii::app()->db->cache(1000, $dependency)->createCommand("select catalogval as katalog " . " from catalogsys a " . " inner join useraccess b on b.languageid = a.languageid " . " where catalogname = '" . $menuname . "' and b.username = '" . Yii::app()->user->id . "'")->queryScalar();
    } else {
      $menu = Yii::app()->db->cache(1000, $dependency)->createCommand("select catalogval as katalog " . " from catalogsys a " . " inner join useraccess b on b.languageid = a.languageid " . " where catalogname = '" . $menuname . "'")->queryScalar();
	}
	if (($menu != null) || ($menu != '')) {
		return $menu;
	} else {
		return $menuname;
	}
}*/
function GetCatalog($menuname) {
  $menuname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[45000]: <<Unknown error>>: 1644', '', $menuname);
  $menuname = str_replace('The SQL statement executed was: call ', '', $menuname);
  $menuname = str_replace('(:vid,:vcreatedby)', '', $menuname);
  $menuname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[42000]: Syntax error or access violation: 1305', '', $menuname);
  $menuname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[42000]: Syntax error or access violation: 1064', '', $menuname);

	$dependency = new CDbCacheDependency("select count(catalogsysid) from catalogsys");
    if (Yii::app()->user->id !== null) {
      $menu = Yii::app()->db->createCommand("select catalogval as katalog " . " from catalogsys a " . " inner join useraccess b on b.languageid = a.languageid " . " where catalogname = '" . $menuname . "' and b.username = '" . Yii::app()->user->id . "'")->queryScalar();
    } else {
      $menu = Yii::app()->db->createCommand("select catalogval as katalog " . " from catalogsys a " . " where languageid = 1 and catalogname = '" . $menuname . "'")->queryScalar();
	}
	if (($menu != null) || ($menu != '')) {
		return $menu;
	} else {
		return $menuname;
	}
}
function GetMessage($isError = false, $catalogname = '', $typeerror = 0) {
  $catalogname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[45000]: <<Unknown error>>: 1644', '', $catalogname);
  $catalogname = str_replace('The SQL statement executed was: call ', '', $catalogname);
  $catalogname = str_replace('(:vid,:vcreatedby)', '', $catalogname);
  $catalogname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[42000]: Syntax error or access violation: 1305', '', $catalogname);
  $catalogname = str_replace('CDbCommand failed to execute the SQL statement: SQLSTATE[42000]: Syntax error or access violation: 1064', '', $catalogname);
  switch (true) {
    case (stripos($catalogname, 'Incorrect decimal') !== false) :
      $catalogname = 'incorrectdecimal';
      break;
    case (stripos($catalogname, 'uq_') !== false) :
      $catalogname = 'invaliddoubleentry';
      break;
    case (stripos($catalogname, 'Duplicate entry') !== false) :
      $catalogname = 'invalidduplicateentry';
      break;
    case (stripos($catalogname, 'column') !== false) :
      $catalogname = 'error ' . $catalogname;
      break;
    case (stripos($catalogname, 'Data too long for column') !== false) :
      $catalogname = 'datatoolong';
      break;
  }
  switch ($typeerror){
    case 0 :
      echo CJSON::encode(array(
        'isError' => $isError,
        'msg' => getcatalog($catalogname)
      ));
      break;
    case 1 :
      echo CJSON::encode(array(
        'success' => $isError,
        'message' => getcatalog($catalogname)
      ));
      break;
  }
}
function CheckDoc($wfname) {
  $sql = "select getwfmaxstatbywfname('".$wfname."')";
  $isallow = Yii::app()->db->createCommand($sql)->queryScalar();
  return $isallow;
}
function GetKey($username) {
	$sql = "select authkey from useraccess where lower(username) = '" . $username . "'";
	return Yii::app()->db->createCommand($sql)->queryScalar();
}
function GetMenuAuth($menuobject) {
  $baccess = 'false';
  $sql     = "select ifnull(count(1),0)
    from groupmenuauth gm
    inner join menuauth ma on ma.menuauthid = gm.menuauthid
    inner join usergroup ug on ug.groupaccessid = gm.groupaccessid
    inner join useraccess ua on ua.useraccessid = ug.useraccessid
    where upper(ma.menuobject) = upper('" . $menuobject . "') 
    and lower(ua.username) = lower('" . Yii::app()->user->id . "')";
  $data    = Yii::app()->db->createCommand($sql)->queryScalar();
  switch($data) {
    case 0 : $baccess = 'true';
        break;
    default : $baccess = 'false';
  }
  return $baccess;
}
function GetItems() {
  $dependency = new CDbCacheDependency("SELECT count(a.menuaccessid) 
    from menuaccess a 
    join groupmenu b on b.menuaccessid = a.menuaccessid 
    join usergroup c on c.groupaccessid = b.groupaccessid 
    join useraccess d on d.useraccessid = c.useraccessid
    where a.parentid is null and a.recordstatus = 1 and b.isread = 1  
      and lower(d.username) = lower('" . Yii::app()->user->name . "')");
  switch(Yii::app()->user->name) {
    case null :
      $results = Yii::app()->db->cache(1000, $dependency)->createCommand("
        select distinct a.menuicon,a.menuname, a.menuaccessid, a.description, a.menuurl,a.parentid,a.sortorder,a.description
        from menuaccess a, groupmenu b, usergroup c, useraccess d 
        where b.menuaccessid = a.menuaccessid and c.groupaccessid = b.groupaccessid and a.recordstatus = 1 and b.isread = 1 and 
          d.useraccessid = c.useraccessid and lower(d.username) = lower('guest') and parentid is null")->queryAll();
      break;
    default :
      $results = Yii::app()->db->cache(1000, $dependency)->createCommand("select distinct a.menuicon,a.menuname, a.menuaccessid, a.description, a.menuurl,a.parentid,a.sortorder,a.description
      from menuaccess a 
      join groupmenu b on b.menuaccessid = a.menuaccessid 
      join usergroup c on c.groupaccessid = b.groupaccessid 
      join useraccess d on d.useraccessid = c.useraccessid
      where a.parentid is null and a.recordstatus = 1 and b.isread = 1  
        and lower(d.username) = lower('" . Yii::app()->user->name . "')
      order by a.sortorder ASC, a.description ASC ")->queryAll();
  }
  $items = array();
  foreach ($results AS $result) {
    $items[] = array(
      'name' => $result['menuname'],
      'label' => getCatalog($result['menuname']),
      'url' => Yii::app()->createUrl($result['menuurl']),
      'icon' => $result['menuicon'],
      'parentid' => $result['menuaccessid']
    );
  }
  return $items;
}
function getSubMenu($menuname)
{
	$dependency = new CDbCacheDependency("SELECT count(a.menuaccessid) 
		from menuaccess a 
			join groupmenu b on b.menuaccessid = a.menuaccessid 
			join usergroup c on c.groupaccessid = b.groupaccessid 
			join useraccess d on d.useraccessid = c.useraccessid
			where a.parentid = " . $menuname . " and d.username = '" . Yii::app()->user->id . "' and b.isread = 1 and a.recordstatus = 1 and d.recordstatus = 1");
	$results    = Yii::app()->db->cache(1000, $dependency)->createCommand("select distinct t.menuaccessid,t.menuname,t.description,t.menuurl,t.menuicon 
		from menuaccess t 
		inner join groupmenu a on a.menuaccessid = t.menuaccessid
		inner join usergroup b on b.groupaccessid = a.groupaccessid
		inner join useraccess c on c.useraccessid = b.useraccessid
		where t.parentid = " . $menuname . " and c.username = '" . Yii::app()->user->id . "' and a.isread = 1 and t.recordstatus = 1 and c.recordstatus = 1
		order by t.sortorder asc, t.description asc")->queryAll();
	$items      = array();
	foreach ($results AS $result) {
		$items[] = array(
			'name' => $result['menuname'],
			'label' => getCatalog($result['menuname']),
			'url' => Yii::app()->createUrl($result['menuurl']),
			'icon' => $result['menuicon'],
			'parentid' => $result['menuaccessid']
		);
	}
	return $items;
}
function eja($number) {
  $number       = str_replace(',', '', $number);
  $before_comma = trim(to_word($number));
  $after_comma  = trim(comma($number));
  $results      = $before_comma . ' koma ' . $after_comma;
  $results = str_replace('nol nol nol nol nol','',$results);
  $results = str_replace('nol nol nol nol nol','',$results);
  $results = str_replace('nol nol nol','',$results);
  $results = str_replace('nol nol nol','',$results);
  $results = str_replace('nol nol','',$results);
  $results = str_replace('koma nol','',$results);
  return ucwords($results);
}
function to_word($number) {
  $words      = '';
  $arr_number = array(
    '',
    'satu',
    'dua',
    'tiga',
    'empat',
    'lima',
    'enam',
    'tujuh',
    'delapan',
    'sembilan',
    'sepuluh',
    'sebelas'
  );
  switch (true) {
    case ($number == 0) :
      $words = ' ';
      break;
    case (($number > 0) && ($number < 12)) :
      $words = ' ' . $arr_number[$number];
      break;
    case ($number < 20) :
      $words = to_word($number - 10) . ' belas';
      break;
    case ($number < 100) :
      $words = to_word($number / 10) . ' puluh ' . to_word($number % 10);
      break;
    case ($number < 200) :
      $words = 'seratus ' . to_word($number - 100);
      break;
    case ($number < 1000) :
      $words = to_word($number / 100) . ' ratus ' . to_word($number % 100);
      break;
    case ($number < 2000) :
      $words = 'seribu ' . to_word($number - 1000);
      break;
    case ($number < 1000000) :
      $words = to_word($number / 1000) . ' ribu ' . to_word($number % 1000);
      break;
    case ($number < 1000000000) :
      $words = to_word($number / 1000000) . ' juta ' . to_word($number % 1000000);
      break;
    case ($number < 1000000000000) :
      $words = to_word($number / 1000000000) . ' milyar ' . to_word($number % 1000000000);
      break;
    case ($number < 1000000000000000) :
      $words = to_word($number / 1000000000000) . ' trilyun ' . to_word($number % 1000000000000);
      break;
    default :
      $words = 'undefined';
  }
  return $words;
}
function comma($number) {
  $after_comma = stristr($number, '.');
  $arr_number  = array(
    'nol',
    'satu',
    'dua',
    'tiga',
    'empat',
    'lima',
    'enam',
    'tujuh',
    'delapan',
    'sembilan'
  );
  $results = '';
  $length  = strlen($after_comma);
  $i       = 1;
  while ($i < $length) {
    $get = substr($after_comma, $i, 1);
    $results .= ' ' . $arr_number[$get];
    $i++;
  }
  return $results;
}
function ValidateData($datavalidate) {
  $messages = '';
  for ($row = 0; $row < count($datavalidate); $row++) {
    if ($datavalidate[$row][2] == 'emptystring') {
      if ($datavalidate[$row][0] == '') {
        $message = getCatalog($datavalidate[$row][1]);
        if ($message != null) {
          $messages = $message->catalogval;
        } else {
          $messages = $datavalidate[$row][1];
        }
      }
    }
    if ($messages !== '') {
      $this->GetMessage('failure', $messages);
    }
  }
}
function CheckAccess($menuname, $menuaction) {
  $baccess    = false;
  $sql        = "select " . $menuaction . " as akses " . " from useraccess a " . " inner join usergroup b on b.useraccessid = a.useraccessid " . " inner join groupmenu c on c.groupaccessid = b.groupaccessid " . " inner join menuaccess d on d.menuaccessid = c.menuaccessid " . " where lower(username) = lower('" . Yii::app()->user->id . "') and lower(menuname) = lower('" . $menuname . "') limit 1";
  $result		  = Yii::app()->db->createCommand($sql)->queryScalar();
  switch($result) {
    case 1:
      $baccess = true;
      break;
    default :
      $baccess = false;
      break;
  }
  return $baccess;
}
function findstatusbyuser($workflow) {
	$status = Yii::app()->db->createCommand("select b.wfbefstat
		from workflow a
		inner join wfgroup b on b.workflowid = a.workflowid
		inner join groupaccess c on c.groupaccessid = b.groupaccessid
		inner join usergroup d on d.groupaccessid = c.groupaccessid
		inner join useraccess e on e.useraccessid = d.useraccessid
		where upper(a.wfname) = upper('". $workflow ."') and upper(e.username)=upper('".Yii::app()->user->name."')")->queryRow();
	if ($status !== null) {
		return $status['wfbefstat'];
	}
	else {
		return 0;
	}
}
function GetUserID() {
	return Yii::app()->db->createCommand("select useraccessid 
				from useraccess 
				where lower (username) = '" . Yii::app()->user->id . "'")->queryScalar();
}
function getwfbefstat($workflow) {
	$status = Yii::app()->db->createCommand("select wfbefstat
		from workflow a
		inner join wfgroup b on b.workflowid = a.workflowid
		inner join groupaccess c on c.groupaccessid = b.groupaccessid
		inner join usergroup d on d.groupaccessid = c.groupaccessid
		inner join useraccess e on e.useraccessid = d.useraccessid
		where upper(a.wfname) = upper('".$workflow."') and upper(e.username)=upper('".Yii::app()->user->name."')")->queryScalar();
	if ($status !== null) {
		return $status;
	} else {
		return 0;
	}
}
function getip() {
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if(filter_var($client, FILTER_VALIDATE_IP))
	{
			$ip = $client;
	}
	elseif(filter_var($forward, FILTER_VALIDATE_IP))
	{
			$ip = $forward;
	}
	else
	{
			$ip = $remote;
	}
	return $ip;
}
function GetCompanyCode($id) {
	return Yii::app()->db->createCommand("
		select companycode
		from company 
		where companyid = " . $id)->queryScalar();
}
function GetCompanyid($companyname,$companyid=0) {
    if($companyid==""){
        $where = ' )';
    }
    else
    {
        $where = " or companyid in ({$companyid}) )";
    }
	$q = Yii::app()->db->createCommand("
		select companyid
		from company 
		where ((coalesce(companyname,'') like '%" .  urldecode($companyname)."%')
        or (coalesce(companycode,'') like '%". urldecode($companyname)."%')
        ". $where." 
        and recordstatus=1" )->queryAll();
    
    $arr = array();
    foreach($q as $row){
        $arr[] = $row['companyid'];
    }
    return $arr;
}
function getUserFavs() {
	$sql = "select distinct b.menuaccessid,b.menuname,b.description,b.menuurl,b.menuicon
		from userfav a
		join menuaccess b on b.menuaccessid = a.menuaccessid 
		join useraccess c on c.useraccessid = a.useraccessid 
		where c.username = '". Yii::app()->user->id. "'		
	";
	$results = Yii::app()->db->createCommand($sql)->queryAll();
	$items      = array();
	foreach ($results AS $result) {
		$items[] = array(
			'name' => $result['menuname'],
			'label' => getCatalog($result['menuname']),
			'url' => Yii::app()->createUrl($result['menuurl']),
			'icon' => $result['menuicon'],
			'parentid' => $result['menuaccessid']
		);
	}
	return $items;
}
function getUserObjectValues($menuobject='company') {
	$sql = "select distinct a.menuvalueid 
				from groupmenuauth a
				inner join menuauth b on b.menuauthid = a.menuauthid
				inner join usergroup c on c.groupaccessid = a.groupaccessid 
				inner join useraccess d on d.useraccessid = c.useraccessid 
				inner join wfgroup e on e.groupaccessid = a.groupaccessid
				inner join workflow f on f.workflowid = e.workflowid
				where b.menuobject = '".$menuobject."'
				and d.username = '" . Yii::app()->user->name . "' ";
	$cid = '';
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach ($datas as $data) {
		if ($cid == '') {
			$cid = $data['menuvalueid'];
		} else 
		if ($cid !== '') {
			$cid .= ','.$data['menuvalueid'];
		}
	}
	return $cid;
}
function getUserObjectWfValues($menuobject='company',$workflow='appso') {
	$sql = "select distinct a.menuvalueid 
				from groupmenuauth a
				inner join menuauth b on b.menuauthid = a.menuauthid
				inner join usergroup c on c.groupaccessid = a.groupaccessid 
				inner join useraccess d on d.useraccessid = c.useraccessid 
				inner join wfgroup e on e.groupaccessid = a.groupaccessid
				inner join workflow f on f.workflowid = e.workflowid
				where b.menuobject = '".$menuobject."'
				and d.username = '" . Yii::app()->user->name . "'
			and c.groupaccessid in (select l.groupaccessid
			from wfgroup j
			join workflow k on k.workflowid=j.workflowid
			join usergroup l on l.groupaccessid=j.groupaccessid
			where k.wfname = '".$workflow."'
			and l.useraccessid=d.useraccessid)";
	$cid = '';
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach ($datas as $data) {
		if ($cid == '') {
			$cid = $data['menuvalueid'];
		} else 
		if ($cid !== '') {
			$cid .= ','.$data['menuvalueid'];
		}
	}
	return $cid;
}
function getUserObjectValuesarray($menuobject='company') {
	$sql = "select distinct a.menuvalueid 
				from groupmenuauth a
				inner join menuauth b on b.menuauthid = a.menuauthid
				inner join usergroup c on c.groupaccessid = a.groupaccessid 
				inner join useraccess d on d.useraccessid = c.useraccessid 
				inner join wfgroup e on e.groupaccessid = a.groupaccessid
				inner join workflow f on f.workflowid = e.workflowid
                inner join company g on g.companyid = a.menuvalueid
				where b.menuobject = '".$menuobject."'
				and d.username = '" . Yii::app()->user->name . "' 
                and g.recordstatus=1
                order by g.companyid asc";
	$array = array();
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach($datas as $row)
    {
        $array[] = $row['menuvalueid'];
    }
	return $array;
}
function getUserRecordStatus($wfname) {
	$sql = "select distinct b.wfbefstat
				from workflow a
				inner join wfgroup b on b.workflowid = a.workflowid
				inner join usergroup d on d.groupaccessid = b.groupaccessid
				inner join useraccess e on e.useraccessid = d.useraccessid
				where a.wfname = '".$wfname."' and e.username = '" . Yii::app()->user->name . "'";
	$cid = '';
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	foreach ($datas as $data) {
		if ($cid == '') {
			$cid = $data['wfbefstat'];
		} else 
		if ($cid !== '') {
			$cid .= ','.$data['wfbefstat'];
		}
	}
	return $cid;
}
function findstatusname($workflowname,$recordstatus) {
	$status = Yii::app()->db->createCommand("select wfstatusname
		from wfstatus a
		inner join workflow b on b.workflowid = a.workflowid
		where b.wfname = '".$workflowname."' and a.wfstat = ".$recordstatus)->queryScalar();
	if ($status != '') {
		return $status;
	}
	else {
		return 0;
	}
}
function getcurrencyid() {
	$a = 0;
	$connection=Yii::app()->db;
	$sql = 'select currencyid from company limit 1';
	$command=$connection->createCommand($sql);
	$a = $command->queryscalar();
	return $a;
}
function getcity() {
	$a = 0;
	$connection=Yii::app()->db;
	$sql = 'select cityname from company a left join city b on b.cityid = a.cityid limit 1';
	$command=$connection->createCommand($sql);
	$a = $command->queryscalar();
	return $a;
}
function getcurrencyname() {
	$a = 0;
	$connection=Yii::app()->db;
	$sql = 'select currencyname from company a left join currency b on b.currencyid = a.currencyid limit 1';
	$command=$connection->createCommand($sql);
	$a = $command->queryscalar();
	return $a;
}
function getcurrencysymbol() {
	$a = 0;
	$connection=Yii::app()->db;
	$sql = 'select symbol from company a left join currency b on b.currencyid = a.currencyid limit 1';
	$command=$connection->createCommand($sql);
	$a = $command->queryscalar();
	return $a;
}
function CheckEmptyUser() {
	if (Yii::app()->user == null) {
		echo '<script type="text/javascript">window.location.href="'.Yii::app()->createUrl('/site/login').'"; </script>';
	} else 
	if (Yii::app()->user->id == '') {
		echo '<script type="text/javascript">window.location.href="'.Yii::app()->createUrl('/site/login').'"; </script>';
	}
	Yii::app()->end();
}
function SendSpExec($spexec) {
	$sql = "insert into spexec (spexec,spstartdate,spenddate,useraccess,recordstatus)";
	Yii::app()->db->createCommand($sql)->execute();
	$sql = "select last_insert_id()";
	return Yii::app()->db->createCommand($sql)->queryscalar();
}
function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {

	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current <= $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}
function GetSearchText($paramtype=[],$param,$default='',$datatype='string') {
	$s = $default;
	for ($i = 0;$i<count($paramtype);$i++) {
		if (strtoupper($paramtype[$i]) == 'POST') {
			$s = isset ($_POST[$param]) ? filter_input(INPUT_POST,$param) : $s;
		}
		if (strtoupper($paramtype[$i]) == 'GET') {
			$s = isset ($_GET[$param]) ? filter_input(INPUT_GET,$param) : $s;
		}
		if (strtoupper($paramtype[$i]) == 'Q') {
			$s = isset ($_GET['q']) ? filter_input(INPUT_GET,'q') : $s;
		}
	}
	if ($datatype=='string') {
		$s = '%'.str_replace(' ','%',trim($s)).'%';
	}
	return $s;
}
function GetRemoteData($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Yii::app()->params['ReportTimeout']);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function PrintPDF($reportname,$dataprint){
	$dataprint['j_username']=Yii::app()->params['ReportServerUser'];
	$dataprint['j_password']=Yii::app()->params['ReportServerPass'];
	$dataprint['titlereport']=GetCatalog($reportname);
	$dataprint['titlecompany']=Yii::app()->params['title'];
	$dataprint['titleuser']='Dicetak oleh '.Yii::app()->user->id;
	$url = Yii::app()->params['baseUrlReport']."/".$reportname.".pdf?".http_build_query($dataprint);
	$data = GetRemoteData($url);
	if (strpos($data,'PDF') != 0) {        
		header('Cache-Control: public');
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="'.$reportname.'.pdf"');
		header('Content-Length: '.strlen($data));
	}
	echo $data;
}
function PrintXLS($reportname,$dataprint){
	$dataprint['j_username']=Yii::app()->params['ReportServerUser'];
	$dataprint['j_password']=Yii::app()->params['ReportServerPass'];
	$dataprint['titlereport']=GetCatalog($reportname);
	$dataprint['titlecompany']=Yii::app()->params['title'];
	$dataprint['titleuser']='Dicetak oleh '.Yii::app()->user->id;
	$url = Yii::app()->params['baseUrlReport']."/".$reportname.".xlsx?".http_build_query($dataprint);
	$data = GetRemoteData($url);
	header('Cache-Control: public');
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: inline; filename="'.$reportname.'.xlsx"');
	header('Content-Length: '.strlen($data));
	echo $data;
}
function PrintDoc($reportname,$dataprint){
	$dataprint['j_username']=Yii::app()->params['ReportServerUser'];
	$dataprint['j_password']=Yii::app()->params['ReportServerPass'];
	$dataprint['titlereport']=GetCatalog($reportname);
	$dataprint['titlecompany']=Yii::app()->params['title'];
	$dataprint['titleuser']='Dicetak oleh '.Yii::app()->user->id;
	$url = Yii::app()->params['baseUrlReport']."/".$reportname.".docx?".http_build_query($dataprint);
	$data = GetRemoteData($url);
	header('Cache-Control: public');
	header('Content-type: application/vnd.ms-word');
	header('Content-Disposition: inline; filename="'.$reportname.'.docx"');
	header('Content-Length: '.strlen($data));
	echo $data;
}
function joinTable($tablename,$tablealias,$tablejoins) {
    $tablejoin = '';
    if(is_array($tablejoins)) {
        $i=1;
        foreach($tablejoins as $value) {
            $tablejoin .= $value;
            if($i<count($tablejoins))
                $tablejoin .= ' and ';
            $i++;
        }
    }
    else
    {
        $tablejoin = $tablejoins;
    }
    return "left join {$tablename} {$tablealias} on {$tablejoin}";
}
function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");
  echo json_encode($parameters);
  return true;
}
function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);
    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successfull: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = Yii::app()->params['TelegramUrl'].Yii::app()->params['TelegramKey'].'/'.$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

function apiRequestJson($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  $handle = curl_init(Yii::app()->params['TelegramUrl'].Yii::app()->params['TelegramKey'].'/');
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
  curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

  return exec_curl_request($handle);
}
function WriteTelegramLog($message) {
  $myfile = fopen(Yii::getPathOfAlias('webroot') . '/protected/data/telegram.log',"a");
  fwrite($myfile,$message);
  fclose($myfile);
}
function getSalesEmployee() {
  //$query = false;
  $query = Yii::app()->db->createCommand("select ifnull(issales,0) 
  from employee a
  join useraccess b on b.employeeid = a.employeeid
  where b.username = '".Yii::app()->user->name."'")->queryScalar();
  return $query;
}
function getEmployeeid($employee=null) {
  if($employee !== null) {
    $emp = Yii::app()->db->createCommand("select employeeid from employee where fullname like '%{$employee}%'")->queryScalar();
    return $emp;
  }
  $emp = Yii::app()->db->createCommand("select ifnull(employeeid,0) 
    from useraccess 
    where username = '".Yii::app()->user->name."'")->queryScalar();
    //$emp =2462;
  return $emp;
}
function getStructure($femployeeid,$lemployeeid,$companyid) {
  
  $org = Yii::app()->db->createCommand("select o.orgstructureid
  from employeeorgstruc e 
  join orgstructure o on e.orgstructureid = o.orgstructureid 
  where o.companyid = {$companyid} and e.employeeid = {$femployeeid} and e.recordstatus = 1")->queryAll();
  $emp = '';
  foreach($org as $row1) {

    $sql = "call getEmployeeStructure(:vfemployeeid,:vlemployeeid,:vturunan,:vorgstructure,:vparentid)";
    $cmd = Yii::app()->db->createCommand($sql);
    $cmd->bindvalue(':vfemployeeid',$femployeeid,PDO::PARAM_STR);
    $cmd->bindvalue(':vlemployeeid',$lemployeeid,PDO::PARAM_STR);
    $cmd->bindvalue(':vturunan',1,PDO::PARAM_STR);
    $cmd->bindvalue(':vorgstructure',$row1['orgstructureid'],PDO::PARAM_STR);
    $cmd->bindvalue(':vparentid',1,PDO::PARAM_STR);
    $cmd->execute();
    
    $q = Yii::app()->db->createCommand("select distinct l_employeeid from tmp_employee where f_employeeid = {$femployeeid}")->queryAll();
    if(count($q) > 0) {
      foreach($q as $row) {
        $emp == '' ? $emp = $row['l_employeeid'] : $emp = $emp.','.$row['l_employeeid'];
      }
    }
  }
  $deltable = Yii::app()->db->createCommand("drop table if exists `tmp_employee`")->execute();
  return $emp;
}
function sendwajapri($devicekey,$message,$phonenumber) {
	$ch = curl_init();
	
	curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://chat.sinargemilang.com/api/messages/send-text',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => array(
				'to' => $phonenumber,
				'message' => urldecode($message),
				'reply_for' => 0
			),
			CURLOPT_HTTPHEADER => array(
				'device-key: '.$devicekey,
			),
		)
	);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	echo $response."\n\n";
	if ($err) {
		echo "cURL Error #:" . $err;
	}
	
	curl_close($ch);
}
function sendwagroup($devicekey,$message,$groupid) {
	$ch = curl_init();
	
	curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://chat.sinargemilang.com/api/messages/send-text',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => array(
				'to' => $groupid,
				'message' => urldecode($message),
				'reply_for' => 0
			),
			CURLOPT_HTTPHEADER => array(
				'device-key: '.$devicekey,
			),
		)
	);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	echo $response."\n\n";
	if ($err) {
		echo "cURL Error #:" . $err;
	}
	
	curl_close($ch);
}
function sendwaimage($devicekey,$message,$phonenumber,$urlimage) {
	$ch = curl_init();
	
	curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://chat.sinargemilang.com/api/messages/send-media',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => array(
				'to' => $phonenumber,
				'message' => urldecode($message),
				'media_url' => $urlmedia,
				'type' => "image",
				'reply_for' => 0
			),
			CURLOPT_HTTPHEADER => array(
				'device-key: '.$devicekey,
			),
		)
	);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	echo $response."\n\n";
	if ($err) {
		echo "cURL Error #:" . $err;
	}
	
	curl_close($ch);
}
function sendwavideo($devicekey,$message,$phonenumber,$urlvideo) {
	$ch = curl_init();
	
	curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://chat.sinargemilang.com/api/messages/send-media',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => array(
				'to' => $phonenumber,
				'message' => urldecode($message),
				'media_url' => $urlvideo,
				'type' => "video",
				'reply_for' => 0
			),
			CURLOPT_HTTPHEADER => array(
				'device-key: '.$devicekey,
			),
		)
	);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	echo $response."\n\n";
	if ($err) {
		echo "cURL Error #:" . $err;
	}
	
	curl_close($ch);
}
function sendwadocument($devicekey,$titledocument,$phonenumber,$urldocument) {
	$ch = curl_init();
	
	curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://chat.sinargemilang.com/api/messages/send-media',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => array(
				'to' => $phonenumber,
				'message' => urldecode($titledocument),
				'media_url' => $urldocument,
				'type' => "document",
				'reply_for' => 0
			),
			CURLOPT_HTTPHEADER => array(
				'device-key: '.$devicekey,
			),
		)
	);

	$response = curl_exec($ch);
	$err = curl_error($ch);
	echo $response."\n\n";
	if ($err) {
		echo "cURL Error #:" . $err;
	}
	
	curl_close($ch);
}
function getAmountCustomer($addressbookid,$startdate,$enddate) { 
  $sqlpencapaian = "select sum(kumharga) from (
    select addressbookid,
    ifnull((select sum(getamountdiscso(d.soheaderid,c.sodetailid,c.qty))
    from invoice a
    join giheader b on a.giheaderid = b.giheaderid
    join gidetail c on c.giheaderid = b.giheaderid
    join soheader d on d.soheaderid = b.soheaderid
    join product e on e.productid = c.productid
    join productplant f on f.productid = e.productid and f.slocid = c.slocid and f.unitofissue = c.unitofmeasureid
    join materialgroup h on h.materialgroupid = f.materialgroupid
    join addressbook g on g.addressbookid = d.addressbookid
    where a.recordstatus = 3 and a.invoicedate between '{$startdate}' and '{$enddate}' 
    -- and d.employeeid = and g.custcategoryid =  
    and g.addressbookid = {$addressbookid} and d.isdisplay=0),0) as kumharga
    from addressbook z
    where z.addressbookid = {$addressbookid}
    union
    select addressbookid,sum(kumharga) as kumharga from (
    select f.addressbookid,-1*sum(a.qty*a.price) as kumharga
    from notagirpro a
    join notagir b on b.notagirid = a.notagirid
    join gireturdetail c on c.gireturdetailid = a.gireturdetailid
    join giretur d on d.gireturid = c.gireturid
    join giheader e on e.giheaderid = d.giheaderid
    join soheader f on f.soheaderid = e.soheaderid
    join product g on g.productid = a.productid
    join addressbook h on h.addressbookid = f.addressbookid
    join productplant i on i.productid = a.productid and i.slocid = a.slocid and i.unitofissue = a.uomid
    join materialgroup j on j.materialgroupid = i.materialgroupid
    where b.recordstatus = 3 and f.isdisplay=0 
    and d.gireturdate between '{$startdate}' and '".date(Yii::app()->params['datetodb'],strtotime($enddate))."'
    and f.addressbookid = {$addressbookid}) x
    ) z ";
  $h = Yii::app()->db->createCommand($sqlpencapaian)->queryScalar();
  return $h;
}
function getCompanyGroup($companyid,$tablealias) {
  $query = '';
  // if not group
  if($companyid<>0) {
    $query = ' and '.$tablealias.'.companyid = '.$companyid;
  }
  else {
    $query = ' and '.$tablealias.'.companyid in((SELECT zz.companyid FROM company zz WHERE zz.isgroup = 1))';
  }
  return $query;
}

function getFieldTable($id,$tablealias,$column) {
    $query = '';
    if($id!='') {
      $query = ' and '.$tablealias.'.'.$column.' in ('.$id.')';
    }
    return $query;
}