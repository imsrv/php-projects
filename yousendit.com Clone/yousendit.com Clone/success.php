<?php
require_once("include/vars.php");
require_once("include/db.php");
require_once("include/functions.php");

$id=isset($_REQUEST["id"])?$_REQUEST["id"]:0;

$qry="SELECT conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_TIME'";
$db->query($qry);
$row=$db->getrow();
$maxtime=$row[0];


$qry="SELECT conf_optional FROM ".$db->tb("configuration")." WHERE conf_name='MAX_COUNT'";
$db->query($qry);
$row=$db->getrow();
$maxcount=$row[0];

$qry="SELECT idkey FROM ".$db->tb("fileinfo")." WHERE id='$id'";
$db->query($qry);
if($db->getrownum()>0)
{
	$row=$db->getrow();
	$link="<a href=\"download.php?id=".$row[0]."\" class=\"ltxt\">".HostURL()."download.php?id=".$row[0]."</a>";
}
else  $link="<span class=\"ltxt\"><font color=red>Sorry! Link doesn't exists</font><span>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="script.js"></script>
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
          <td><table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td class="ltxt"><strong>Your file has been successfully sent!</strong></td>
              </tr>
              <tr> 
                <td class="ltxt">We've stored your file on our server and sent 
                  your recipient an email with instructions for retrieving it. 
                  The file will be available for 
                  <?=$maxtime?>
                  or 
                  <?=$maxcount?>
                  downloads.</td>
              </tr>
              <tr> 
                <td class="ltxt"><strong>Here is a link for your reference: </strong></td>
              </tr>
              <tr> 
                <td>
                  <?=$link?>
                </td>
              </tr>
              <tr> 
                <td><a href="index.php" class="ltxt">&laquo; Back</a></td>
              </tr>
            </table>
            <br> 
          </td>
        </tr>
      </table>
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
