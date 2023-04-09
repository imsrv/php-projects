<?require "config.php";?>
<link rel="stylesheet" type="text/css" href="e-post.css">
<?
//if calling pages into an index file place this section at the start of your index
if ($_POST['userid'] && $_POST['password'])
{
  // if the user has just tried to log in
  $query = "SELECT * FROM e_users WHERE username='$_POST[userid]' AND passwd='$_POST[password]'";
  $result = mysql_query($query, $db_conn);
  $row = mysql_fetch_assoc($result);
  if (mysql_num_rows($result) >0)
  {
    // if they are in the database register the user id
	//below are the session variables add/remove or modify these as you wish
    $valid_user = $_POST['userid'];
    $_SESSION['valid_user'] = $valid_user;
    $_SESSION['pass'] = $_POST['password'];
	$_SESSION['groupname'] = $row['groupname'];
	 }
}
//end of section
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>

<title>
e-post
</title>
</head>
<body>
<table align="center" cellpadding="0" border="0" cellspacing="0" width="900">
<tr>
<td>

<table width="900" cellpadding="0" border="0" cellspacing="0">
<tr>
<td>

</td>
<td>
</td>
<td align="right">

</td>
</tr>
</table>

<table class="background" align="left" cellpadding="1" border="0" cellspacing="1">
<tr>
<td border="1" valign="top" height="150" width="110">
<?
//include this php block wherever you want your login script to appear
if ($log=="") include "authmain.php";
if ($log=="logout") include "logout.php";
if ($log=="forgot") include "forgot.php";
if ($log=="change") include "changepass.php";
?>
</td>
</tr>
<tr>
<td border="1" width="110">
<!-- navigation include this where you want navigation to appear -->
<? include "e-post_nav.php"; ?>
</td>
</tr>
<tr>
<td align="center">
<br /><br />
<?
//include this php block where you want the new mail notification to show on your page
$mailcheck = "SELECT readstate FROM e_post WHERE username='$_SESSION[valid_user]' AND groupname='$_SESSION[groupname]' AND readstate='0'";
$checkq = mysql_query($mailcheck, $db_conn) or die("Query mailcheck failed".mysql_error());
if (mysql_num_rows($checkq)>0)
{
	$msgcheck = '<a href="index.php?page=e-post" /><img src="images/mai_anm.gif" border="0"><a/>';
}
else
{
	$msgcheck = '';
}
$howmany = mysql_num_rows($checkq);
if ($howmany=='1')
{
	$howmany2 = 'message';
}
else
{
    $howmany2 = 'messages';
}
if ($msgcheck=='')
{
	echo '';
}
else
{
echo '<table ><tr>';
echo '<td>'.$msgcheck.'</td></tr>';
echo '<tr><td><a href="index.php?page=e-post" />You have <b>'.$howmany.'</b><br />New '.$howmany2.'</a></td></tr></table>';
}
?>
</td>
</tr>
</table>
<table align="center" cellpadding="0" border="0" cellspacing="0">
<tr>
<td valign="top" height="100">
<h3>e-post online site messaging system (<i>V 1.9</i>)!</h3>
</td>
</tr>
<tr>
<td valign="top">
<? include "content.php"; ?>
</td>
</tr>
<tr>
<td height="300">
</td>
</tr>
</table>

</td>
</tr>
<tr>
<td align="center">
<a href="http://www.irealms.co.uk" />e-post by Ryan Marshall of www.irealms.co.uk</a>
</td>
</tr>
</table>