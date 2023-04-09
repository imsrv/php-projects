<?php
require_once("include/vars.php");
require_once("include/db.php");
require_once("include/functions.php");

$act=isset($_REQUEST["act"])?$_REQUEST["act"]:"";

$key=isset($_REQUEST["key"])?trim($_REQUEST["key"]):"";
$err=array();
if(count($_POST)>0 && $act=="remove")
{
	if(empty($key)) $err[]="Link key is missing. Please provide the key.";
	else
	{
		$qry="SELECT link_status FROM ".$db->tb("fileinfo")." WHERE idkey='$key'";
		$db->query($qry);
		if($db->getrownum()==0) $err[]="Sorry! Wrong Link.";
		else
		{
			$row=$db->getrow();
			if($row[0]==0) $err[]="Link already suspended.";
			else
			{
				$qry="UPDATE ".$db->tb("fileinfo")." SET link_status=0 WHERE idkey='$key'";
				$db->query($qry);		
				$err[]="Link successfully suspended.";
			}	
		}
	}	
}
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
          <td> <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td align="center" class="ltxt"> <h4><strong>Remove a Link</strong></h4>
                  <hr> </td>
              </tr>
              <?php
		  	if(count($err)>0)
			{
		  ?>
              <tr> 
                <td class="ltxt"><font color="#FF0000"> 
                  <?php 
				  		foreach($err as $errmsg)
						print "<li>$errmsg</li>";
						?>
                  </font></td>
              </tr>
              <?php
			}
			?>
              <tr> 
                <td class="ltxt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <form action="" method="post">
                      <tr> 
                        <td colspan="2" class="ltxt">To remove access to a file 
                          enter the full link (or just the unique 32-character 
                          identifier) below and click Submit. Access to the file 
                          will be terminated immediately.</td>
                      </tr>
                      <tr> 
                        <td width="20%" class="ltxt"><strong>Link Key:</strong></td>
                        <td><input name="key" type="text" class="txtbox" id="key" value="<?=$key?>"></td>
                      </tr>
                      <tr align="center"> 
                        <td colspan="2"><input name="act" type="hidden" id="act" value="remove"> 
                          <input name="Submit" type="submit" class="button" value="Submit"></td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <tr> 
                <td class="ltxt"><strong><a href="index.php" class="ltxt">Home</a></strong></td>
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