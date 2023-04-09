<?php
// +-------------------------------------------------------------------------+
// | Avrora - Content Managment System                                       |
// |-------------------------------------------------------------------------|
// | Copyright (c) Vadim Kravciuk aka Stek -> vadim@phpdevs.com              |
// | http://www.phpdevs.com                                                  |
// +-------------------------------------------------------------------------+
error_reporting(7);

include_once('../config.php');
include_once('../class/class.session.php');
include_once('../class/class.mysql.php');
include_once('../lang/admin.php');
include_once('../function.php');

$p=array_merge($HTTP_COOKIE_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS);

$s=new class_session(SESSION_PATCH);

$db=new class_db(DB_HOST,DB_LOGIN,DB_PASS);
$db->m_select_db(DB_DEVICE);
$db->debug=TRUE;

?>
<html>
<head>
<title>Avrora CMS - managment</title>
<link rel=stylesheet type=text/css href=/admin.css>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#000080" alink="#FF0000">
<?php
$login_error=0;
if (!$s->read('uid') || !$s->read('gid')) {
	if (@$p['cmd_login'] && @$p['_login'] && @$p['_pass']) {
		$rs=$db->m_query("SELECT * FROM ai_users WHERE _login='".trim($p['_login'])."' AND _pass='".md5(trim($p['_pass']))."'");
		if ($db->m_count($rs) == 1) {
			$row=$db->m_fetch($rs);
			$s->write('uid',$row['uid']);
			$s->write('gid',$row['gid']);
			$db->m_query("UPDATE ai_users SET _date_last=".time().", _ip_last='".getenv('REMOTE_ADDR')."' WHERE uid=".$row['uid']);
		}else {
			include_once('inc_login_form.php');
			$login_error=1;
		}
	}else {
		include_once('inc_login_form.php');
		$login_error=1;
	}
}

if($login_error != 1) {
	?><script type='text/javascript'>function Go(){return}</script><?
	if ($s->read('gid')==1) {
		print "<script type='text/javascript' src='../js/admin_menu.js.php?ac=".crypt(time())."'></script>";
	}
	?>
	<script type='text/javascript' src='../js/menu_com.js?ac=<?php print crypt(time());?>'></script><noscript>Your browser does not support script</noscript>
	<img src="/p.gif" width="1" height="10" border="0"><br>
	<?php
	switch (@$p['action']) {
		case 'pages': include('inc_pages.php');break;
		case 'members': include('inc_members.php');break;
		case 'templates': include('inc_templates.php');break;
		case 'pages': include('inc_pages.php');break;
		case 'modules': 
			if (is_file('../modules/'.$p['mod_name'].'/admin.php')) {
				@include('../modules/'.$p['mod_name'].'/lang.php');
				include('../modules/'.$p['mod_name'].'/admin.php');
			}else {
				print 'object not found <br>';
			}
			break;
		default: print '<font class="ok">'.$lang['25'].'</font> <br>';
	}
}

$db->m_close();
?>
</body>
</html>