<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PHP Installer.</title>
<style type="text/css">
	BODY{
		background : #FDF5E6;
		font : 14px Verdana, Geneva, Arial, Helvetica, sans-serif;
		color : Black;
	}
	INPUT{
		background-color : #D2B48C;
		font-size : 12px;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-weight : bold;
		color : Black;
	}
	.submit{
		background-color : #99ccff;
		font-size : 12px;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-weight : bold;
		color : Black;
		border : 0px solid #708090;
		cursor : hand;
	}
	.tblRTitle{
		background-color : #6A5ACD;
		color : Yellow;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-weight : bold;
		font-size : 12px;
	}
	.tblRStat{
		background-color : #99ccff;
		color : #000000;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-weight : bold;
		font-size : 11px;
	}
	.tblRNormal{
		background-color : #99ccff;
		color : #000000;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-weight : bold;
		font-size : 12px;
	}
	P {
		color : Black;
		font-size : 11px;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		text-decoration : none;
	}
	A {
		color : Black;
		font-size : 13px;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		text-decoration : none;
	}
	A:HOVER {
		color : Black;
		font-size : 13px;
		font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
		text-decoration : underline;
	}
	.ok {
		font-family : Verdana;
		font-size : 12px;
		font-weight : bold;
		background-color : #556B2F;
		color : White;
	}
	.warning {
		font-family : Verdana;
		font-size : 12px;
		font-weight : bold;
		background-color : #B22222;
		color : #FFEFD5;
	}
</style>
</head>
<body bgcolor="#ffffff">

<?php
require('./inst_conf.php');
include($INST['config']);

switch($_SERVER['QUERY_STRING']) {
	case 'file':
		f_step_file();
		break;
	case 'db':
		f_step_db();
		break;
	case 'sql':
		f_step_sql();
		break;
	case 'end':
		f_step_end();
		break;
	default:
		f_main_screen();
}

function f_step_sql() {
	global $INST;
	print '<b>STEP 3.</b><br><br>';
	print 'Creating DB structure ... <br>';
	@mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or $error = true;
	@mysql_select_db(DB_DEVICE) or $error = true;
	$f= implode('',file($INST['sql']));
	$SQL=explode(';',$f); unset($f);
	while(list($k,$v) = each($SQL)) {
		if (trim($v)) {mysql_query($v) or die(mysql_error());}
		print '* ';
		flush();
	}
	mysql_close();
	print '<br>done <br><br>';
	?><a href="install.php?file">Next Step</a><?php
}

function f_step_end() {
	global $INST;
	?>
	<center>Configuration "<?php print $INST['msg']['label']?>" complited.</center>
	<br>
	<font color="#FF0000">Please remove directory "install"</font>.
	<br><br>
	<?php print $INST['msg']['end']?>
	<br>
	<?php
}

function f_step_file() {
	global $INST;
	$error=false;
	print '<b>STEP 4.</b><br><br>';
	while(list($k,$v) = each($INST['file'])) {
		print 'checking '.$v .' ... ';
		if ( true != is_writable('./'.$v)) {
			print '<font color="#990000">failed</font>. ';
			print ' -> '.$v .' must by writable. <br>';
			$error=true;
		}else {
			print '<font color="#008000">passed</font>.<br>';
		}
	}
	print '<br>';
	if (false == $error) {
		?><a href="install.php?end">Next Step</a><?php
	}else {
		?><a href="install.php?file">Retry current Step</a><?php
	}
}

function f_check_mysql_connection() {
	$error=false;
	@mysql_connect(DB_HOST,DB_LOGIN,DB_PASS) or $error = true;
	@mysql_select_db(DB_DEVICE) or $error = true;
	return $error;
}

function f_step_db() {
	global $INST;
	print '<b>STEP 2.</b><br><br>';
	if (false == f_check_mysql_connection()) {
		?>
		Checking MySQL configuration ... <font color="#008000">passed</font>. <br><br>
		<a href="install.php?sql">Next Step</a><br>
		<?php
	}else {
		?>
		Checking MySQL configuration ... <font color="#990000">failed</font>. <br><br>
		Please open and configure global config file -> <font color="#804040"><?php print $INST['config']?></font> . <br><br>
		<font color="#004080">DB_HOST</font>		- MySQL DB host.<br>
		<font color="#004080">DB_LOGIN</font>	- MySQL user login. <br>
		<font color="#004080">DB_PASS</font>		- MySQL user password.<br>
		<font color="#004080">DB_DEVICE</font>	- MySQL database name. <br><br>
		<a href="install.php?db">Retry current Step</a><br>
		<?php
	}
}

function f_main_screen() {
	global $INST;
	?>
	<center>Welcome to "<?php print $INST['msg']['label']?>" installation area.</center>
	<br>
	<i><?php print $INST['msg']['welcome']?></i>
	<br><br>
	<b>STEP 1.</b><br><br>
	Please open and configure global config file -> <font color="#804040"><?php print $INST['config']?></font> . <br><br>
	<font color="#004080">DB_HOST</font>		- MySQL DB host.<br>
	<font color="#004080">DB_LOGIN</font>	- MySQL user login. <br>
	<font color="#004080">DB_PASS</font>		- MySQL user password.<br>
	<font color="#004080">DB_DEVICE</font>	- MySQL database name. <br><br>
	<a href="install.php?db">Next Step</a><br>
	<?php
}
?>

<br>
<hr width="60%" size="1">
<p align="center">
<font color="#804040">PHP Installer.</font> Copyright 2001-2003 <a href="http://www.phpdevs.com/" target="_blank">PHP Devs</a>. 
</p>
</body>
</html>