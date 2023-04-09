<?php
session_start();
session_register("valid");
$_SESSION["valid"]=true;
require_once("include/vars.php");
require_once("include/db.php");
require_once("include/functions.php");

$key=isset($_REQUEST["id"])?$_REQUEST["id"]:0;
$err=array();
$file="";
$qry="SELECT file_name, size, no_of_dwnld, expire_time, max_dwnld,dir FROM ".$db->tb("fileinfo")." WHERE idkey='$key' AND link_status=1";
$db->query($qry);
if($db->getrownum()>0)
{
	$row=$db->getrow();
	$file="<strong>".$row[0]."</strong>&nbsp;size(".sprintf("%.2f",$row[1]/1024)." KB)";
	if($row[3]<time()) $err[]="File download time expired.";
	if($row[2]>=$row[4]) $err[]="File download for ".$row[2]." times. It can't be downloaded anymore";
}
else  $err[]="Sorry! Link doesn't exists.";
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
          <td> 
            <?php
		  	if(count($err)>0)
			{
		  ?>
            <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td class="ltxt"><font color="#FF0000"> 
                  <?php 
				  		foreach($err as $errmsg)
						print "<li>$errmsg</li>";
						?>
                  </font></td>
              </tr>
            </table>
            <?php
			}
			else
			{
			?>
            <div id="table1SD"></div>
            <div id="table1" style="visibility: visible; display: inline"> 
              <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr> 
                  <td align="center" class="ltxt"><h4><strong>File Transfer: Start 
                      Download</strong></h4>
                    <hr></td>
                </tr>
                <tr> 
                  <td align="center" class="ltxt"><font color="#000000">
                    <?=$file?>
                    </font></td>
                </tr>
                <tr> 
                  <td class="ltxt">You must click one of the following:</td>
                </tr>
                <tr> 
                  <td class="ltxt">1. <a href="complete.php?id=<?=$key?>" class="ltxt" onClick="javascript: Toggle()">Click 
                    here to download the file.</a> 
                  </td>
                </tr>
                <tr> 
                  <td class="ltxt">2. <a href="remove.php?key=<?=$key?>" class="ltxt">Click 
                    here to remove the file from our servers.</a></td>
                </tr>
                <tr> 
                  <td><a href="index.php" class="ltxt">&laquo; Back</a></td>
                </tr>
              </table>
            </div>
            <div id="table2SD"></div>
            <div id="table2" style="visibility: hidden; display: none"> 
              <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr> 
                  <td align="center" class="ltxt"> <h4><strong>Thank you for using 
                      <?=SITE_NAME?>
                      </strong></h4>
                    <hr> </td>
                </tr>
                <tr> 
                  <td class="ltxt"><strong>Your download is in progress.</strong></td>
                </tr>
                <tr> 
                  <td class="ltxt">Feel free to click away from this page. <br>
                    Navigating to other pages will not <br>
                    affect your download. </td>
                </tr>
                <tr> 
                  <td class="ltxt"><strong><a href="index.php" class="ltxt">Home</a></strong></td>
                </tr>
              </table>
            </div>
            <?php
			}
			?>
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