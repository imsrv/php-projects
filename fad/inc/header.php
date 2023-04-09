<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
//Get Error Messages Page
session_start();

//include configuration file
include_once("configure.php");

//Include submits file
include_once("submits.php");


//Check User sessions (set it to NO at first)
$is_logged = false;
$check_user = @mysql_query("SELECT * from `user_sessions` WHERE `session_id`='$_SESSION[session_id]'");
//Return the number of session for that user (should be over 1)
if(@mysql_num_rows($check_user) > 0){
	//If everything is good.. mark loged
	$is_logged = true;
}
if($is_logged == false && !eregi('index.php',$_SERVER['PHP_SELF'])){
	header("Location: index.php");
	exit();
}
?>
<html>
<head>
<title>FAD Site Manager ::: Powered By PHP Scripts.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="codethatcalendarstd.js"></script>
	<script language="javascript" src="scroller_ex.js"></script>
	<script language="javascript">
		var c1 = new CodeThatCalendar(caldef1);

</script>
<style type="text/css">
a {
	text-decoration:none;
	color:#0000FF;
}
a:hover {
	text-decoration:underline;
}
</style>	
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!--
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
-->
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999933">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" background="<? echo $IMAGEFOLDER;?>/xp3.gif">
        <tr> 
          <td width="350"><div align="left"><a href="<? echo $SITE_DIR . $FAD_DIR;?>index.php"><img src="<? echo $IMAGEFOLDER;?>/tophead.gif" alt="Main Page" width="350" height="50" border="0"></a></div></td>
          <td><img src="<? echo $IMAGEFOLDER;?>/tops.gif" width="100%" height="50"></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
  <tr>
      <td>&nbsp; </td>
  </tr>
</table>
<? if($message != NULL){ ?>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFCCCC">
  <tr> 
    <td height="25"><div align="center"><strong><font color="red" face="Verdana, Arial, Helvetica, sans-serif"><? echo $message;?></font></strong> 
      </div></td>
  </tr>
</table>
<? } ?>