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

//Connect to database and header
include_once("connect.php");
include_once("header.php");

?>
<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
  <tr bgcolor="#99CC99"> 
    <td colspan="2"><div align="center"><font size="4"><strong>How 
    To View The Banner:</strong></font></div></td>
  </tr>
  <tr> 
    <td width="50%" height="32" rowspan="2" valign="middle"><div align="center"><strong>Simply include this line of php code anywhere on your page: </strong></div></td>
    <td width="50%"><div align="center"><strong><font color="#FF0000">&lt;?php</font>        <font color="#339999">include</font>(<font color="#FF0000">&quot;DIRTOMANAGER/viewbanner.php&quot;</font>);<font color="#FF0000">?&gt;</font></strong></div></td>
  </tr>
  <tr>
    <td height="47"><div align="center"><strong>Where 
        'DIRTOMANAGER' is the directory of where the viewbanner.php is located!</strong></div></td>
  </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
$get_banners = @mysql_query("SELECT * FROM banners");

if(@mysql_num_rows($get_banners) > 0){

?>

<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
  <tr bgcolor="#9933CC"> 
    <td bgcolor="#99CC99"><div align="center"><font size="4"><strong> 
        Banner Pre-View:</strong></font></div></td>
  </tr>
  <tr> 
    <td height="47" valign="middle" bgcolor="#FFFFFF"><div align="left"></div>
      <div align="center"><?php include("viewbanner.php");?></div>
    </td>
  </tr>
</table>
<?php } else { ?>
<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF" bgcolor="#CCCCCC">
  <tr bgcolor="#9933CC"> 
    <td width="102%" bgcolor="#99CC99"><div align="center"><font size="4"><strong>Unable 
        To Preview Include File, No Banners Selected!</strong></font></div></td>
  </tr>
</table>
<?php } ?>
<p>&nbsp;</p>
<?php include_once("footer.php"); ?>
