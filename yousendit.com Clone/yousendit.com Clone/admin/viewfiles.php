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

$err=array();

$act=isset($_REQUEST["act"])?$_REQUEST["act"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
if($act=="del" && !empty($id))
{
	$qry="SELECT dir,file_name FROM ".$db->tb("fileinfo")." WHERE id=$id";
	$db->query($qry);
	if($db->getrownum()==0) $err[]="Sorry! Wrong link.";
	else
	{
		$row=$db->getrow();
		@unlink("../uploads/".$row[0]."/".$row[1]);
		@rmdir("../uploads/".$row[0]);
		$qry="DELETE FROM ".$db->tb("fileinfo")." WHERE id=$id";
		$db->query($qry);		
		$err[]="File successfully deleted.";
	}
}

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
      <table width="90%" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <form action="" method="post" onSubmit="return isLoginFormOk(this)">
          <tr bgcolor="#305b01"> 
            <td width="100%" align="center" nowrap bgcolor="#FFFFFF" class="nav"><strong>Uploaded 
              File Info</strong></td>
          </tr>
		  <?
		  if(count($err)>0)
		  {
		  ?>
          <tr> 
            <td align="center" nowrap class="ltxt"><font color="#FF0000"> 
              <?php 
				  		foreach($err as $errmsg)
						print "<li>$errmsg</li>";
						?>
              </font></td>
          </tr>
          <?
		  }
		  ?>
          <tr> 
            <td nowrap class="ltxt"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                <tr class="ltxt"> 
                  <td><strong>Key</strong></td>
                  <td align="center"><strong>Details</strong></td>
                  <td align="center"><strong>Size</strong></td>
                  <td align="center"><strong>Mime Type</strong></td>
                  <td align="center"> <strong>Download Info</strong></td>
                  <td align="center"><strong>Expiary Info</strong></td>
                  <td align="center"><strong>Status</strong></td>
                  <td align="right"><strong>Action</strong></td>
                </tr>
                <?
				
				$qry="SELECT * FROM ".$db->tb("fileinfo")." ORDER BY upload_time DESC";
				$db->query($qry);
				while($row=$db->getarr())
				{
					$status="Ok";
					if($row["no_of_dwnld"]>=$row["max_dwnld"]) $status="Count Exceeded";
					if($row["expire_time"]<time()) $status="Expired";
					if($row["link_status"]==0) $status="Suspended";
			 ?>
                <tr class="ltxt"> 
                  <td> 
                    <?=$row["idkey"]?>
                  </td>
                  <td align="center"> 
                    File: <?=$row["file_name"]?><br>Recipient: <?=$row["recipient"]?><br>Sender: <?=$row["sender"]?>
                  </td>
                  <td align="center"><? print sprintf("%.2f",$row["size"]/1024)." KB";?></td>
                  <td align="center"> 
                    <?=$row["mime_type"]?>
                  </td>
                  <td align="center"> 
                    <?=$row["no_of_dwnld"]?>
                    <br>
                    ----<br> 
                    <?=$row["max_dwnld"]?>
                  </td>
                  <td align="center"><? print date("d M, Y H:i",$row["upload_time"])?><br>
                    ----<br> <? print date("d M, Y H:i",$row["expire_time"])?></td>
                  <td align="center"><?=$status?></td>
                  <td align="right"><a href="viewfiles.php?act=del&id=<?=$row["id"]?>" onClick='return confirm("Do you really want to delete the link \"<?=$row["idkey"]?>\"")'><strong>Delete</strong></a></td>
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