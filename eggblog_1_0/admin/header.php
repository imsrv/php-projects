<?
$eggblog_release = "v1.0";

session_start();
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");

if (!isset($_SESSION[eggblog])) {
  if (isset($_COOKIE[eggblog_u])) {
    if (isset($_COOKIE[eggblog_p])) {
      $uid = mysql_result(mysql_query("SELECT username FROM eggblog_members WHERE md5(username)='$_COOKIE[eggblog_u]' AND md5(password)='$_COOKIE[eggblog_p]'"),0);
      $pid = mysql_result(mysql_query("SELECT password FROM eggblog_members WHERE md5(username)='$_COOKIE[eggblog_u]' AND md5(password)='$_COOKIE[eggblog_p]'"),0);
      if (strlen($uid) > 0) {
        $_SESSION[eggblog] = $uid;
      }
    }
  }
}
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="EN" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Administration | <?=$eggblog_title?> | <?=$eggblog_subtitle?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />

	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="../_etc/_<?=$eggblog_css?>.css" type="text/css" media="screen" />
	<style type="text/css" media="screen">@import "../_etc/_layout.css";</style>
	<script type="text/javascript" src="../_etc/global.js"></script>
</head>

<body>

<div id="container">
	<div id="header">
		<h1><a href="index.php">Administration</a></h1>
		<h2><a href="../home/index.php"><?=$eggblog_title?> | <?=$eggblog_subtitle?></a></h2>
	</div>

	<div id="main">
