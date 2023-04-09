<?php
error_reporting(7);
include_once('./config.php');
include_once('./class/class.mysql.php');

$db=new class_db(DB_HOST,DB_LOGIN,DB_PASS);
$db->debug=FALSE;
if ($db->connect_id == false) {
	die('MySQL DB error.');
}
$db->m_select_db(DB_DEVICE);

if (getenv('PATH_INFO')) {
	$virt=getenv('PATH_INFO');
	$virt=str_replace('index.html','',$virt); $virt=str_replace('index.htm','',$virt);
	$virt=str_replace('index.php','',$virt); $virt=str_replace('index.asp','',$virt);

	$a=explode('/',$virt); $url='/';
	while(list($k,$v)=each($a)) {
		if (trim($v)) { $url.=$v.'/'; }
	}
}else {
	$url='/';
}

$SQL="SELECT ai_pages.*, ai_templates._name AS _template
  FROM ai_pages, ai_templates
  WHERE ai_pages._path='".$url."' AND ai_pages._enabled='Y'
  AND ai_pages.tid=ai_templates.tid";
$rs=$db->m_query($SQL);
if ($db->m_count($rs)>0) {
	$row=$db->m_fetch($rs);
	$art['pid']=&$row['pid'];
	$art['title']=&$row['_title'];
	$art['desc']=&$row['_desc'];
	$art['text']=&$row['_text'];
	$art['date']=&$row['_date'];
	$art['parent']=&$row['_parent'];

	if ($row['_is_link']=='Y') {
		header('Location: '.$row['_link']);
		print 'Pages moved <a href="'.$row['_link'].'">here</a>.';
	}else {
		Header("Last-Modified: ".gmdate("D, M d Y H:i:s",time()-3600)." GMT");
		include('templates/'.$row['_template']);
	}

}else {
	include('./error/404.php');
}
$db->m_close();

/********************** System Function  ***************************/
function &modules($name) {
	if (is_file('modules/'.$name.'/index.php')) {
		ob_start();
		include('modules/'.$name.'/index.php');
		$value = ob_get_contents();
		ob_end_clean();
		return $value;
	}else {
		return 'Modules '.$name.' not found <br>';
	}
}
?>