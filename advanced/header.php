<?php
session_start();
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
if(!eregi('login.php',$_SERVER['PHP_SELF']) ){
	if($_SESSION['adminin'] != 'yes'){
		header("Location: login.php");
		exit();
	}
}
?>
<html>
<head>
<title>Marsal Banner Manager :: Powered By Free-PHP-Scripts.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="codethatcalendarstd.js"></script>
	<script language="javascript" src="scroller_ex.js"></script>
	<script language="javascript">
		var c1 = new CodeThatCalendar(caldef1);

	</script>
</head>
<body>
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
<table width="100%" cellspacing="0" cellpadding="0">
  <tr> 
    <td><table width="100%" border="3" cellpadding="3" cellspacing="0" bordercolor="#9933CC">
        <tr> 
          <td bgcolor="#9933CC"><div align="center"><strong><font color="#FFFFFF" size="5" face="Georgia, Times New Roman, Times, serif">Marsal 
              Advanced Banner Manager</font></strong></div></td>
        </tr>
        <tr> 
          <td><table width="100%" cellspacing="0" cellpadding="5">
              <tr> 
                <td height="25" bgcolor="#993300"><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"><a href="index.php" ><font color="#FFFFFF">General 
                    Options</font></a> |<a href="add.php" ><font color="#FFFFFF">Add Banner</font></a> 
                    | <a href="remove.php" ><font color="#FFFFFF">Remove Banner</font></a> | <a href="edit.php" ><font color="#FFFFFF">Edit 
                    Banner</font></a> | <a href="view.php"  ><font color="#FFFFFF">Banner Stats</font></a> 
                    | <a href="http://www.free-php-scripts.net" target="_blank"  ><font color="#FFFFFF">Support</font></a> 
                    |<a href="logoff.php" ><font color="#FFFFFF">Log 
                  Off</font></a></font> | </font></strong></div></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?php
include_once("header.php");
//Check if we are displaying a message to the user:
if($message != NULL){?>
<table width="100%"  border="0" cellpadding="3" cellspacing="0" bgcolor="#FFCCCC">
  <tr>
    <td><div align="center"><strong><font color="#FF0000"><?=$message;?></font></strong></div></td>
  </tr>
</table>
<?php } ?>