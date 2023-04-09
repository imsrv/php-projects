<?php
session_start();
if(!isset($_SESSION["auid"]) || $_SESSION["auid"]<=0)
{
	header("Location: index.php"); exit;
}
else $auid=$_SESSION["auid"];

require_once("../include/vars.php");
require_once("../include/db.php");
require_once("../include/functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?> (Admin Panel)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../script.js"></script>
</head>

<body>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td><?php
	require_once("header.php");
	?></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="50%" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <form action="" method="post" onSubmit="return isLoginFormOk(this)">
          <tr bgcolor="#305b01"> 
            <td width="100%" align="center" nowrap bgcolor="#FFFFFF" class="nav"><strong>Login 
              History</strong></td>
          </tr>
          <tr> 
            <td nowrap class="ltxt"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                <tr class="ltxt"> 
                  <td><strong>Login Time</strong></td>
                  <td><strong>Logout Time</strong></td>
                  <td><strong>IP Address</strong></td>
                </tr>
			<?
				
				$qry="SELECT timein, timeout, ip FROM ".$db->tb("adminlog")." WHERE uid='$auid' ORDER BY timein DESC";
				$db->query($qry);
				while($row=$db->getrow())
				{
			 ?>
                <tr class="ltxt"> 
                  <td><? print date("d M, Y H:i",$row[0])?></td>
				  <td> 
                    <? if($row[1]!="") print date("d M, Y H:i",$row[1]); else print "&nbsp;&nbsp;";?>
                  </td>
				  <td> 
                    <?=$row[2]?>
                  </td>
                </tr>
			<?
			}
			?>	
              </table></td>
          </tr>
        </form>
      </table>
      <br>
    </td>
  </tr>
  <tr>
    <td>
	<?php
	require_once("footer.php");
	?>
	</td>
  </tr>
</table>  
</body>
</html>