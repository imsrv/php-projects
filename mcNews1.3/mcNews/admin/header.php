<?
// mcNews 1.3  Marc Cagninacci marc@phpforums.net
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Admin mcNews</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
<?

if($voir!='') {
  $skinfile=strstr($skinfile, 'skin');
include ("$skinfile");
?>
a:actif {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:link {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:visited {  font-family: <? echo $FontLien; ?>; color: <?echo $LienColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
a:hover {  font-family: <? echo $FontLien; ?>; color: <?echo $LienSurvolColor; ?>; font-weight: <? echo $LienWeight; ?>; text-decoration: none}
<?
}
else
{
?>
a:actif {  font-family: Verdana, Arial; color:gray; text-decoration: none}
a:link {  font-family: Verdana, Arial; color: gray; text-decoration: none}
a:visited {  font-family: verdana, Arial; color: gray; text-decoration: none}
a:hover {  font-family: Verdana, Arial; color: #333333; text-decoration: none}
<?
}
?>
-->
</style>
</head>

<body bgcolor="#c0c0c0" text="black">

<?
include ("../conf.inc.php");
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT lang FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
$langfile=$row['lang'];
include ("$langfile");
echo '<p align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#000000"><b>'.$lAccueil.'</b></font></p><hr>';

?>
