<?php
session_start();
if(!isset($_SESSION["auid"]) || $_SESSION["auid"]<=0)
{
        header("Location: index.php"); exit;
}
else $auid=$_SESSION["auid"];

require_once("../include/db.php");
require_once("../include/vars.php");
require_once("../include/functions.php");
$err=array();

if(count($_POST)>0)
{
        $uname=$_REQUEST['uname'];
        $pwd=md5($_REQUEST['pwd']);
        $email=$_REQUEST['email'];
        $qry="UPDATE ".$db->tb("admin")." SET uname='$uname', pwd='$pwd', email='$email' WHERE uid=$auid";
        $db->query($qry);
        if($db->getaffectedrows()==0) $err[0]="Nothing altered! Try again.";
        else  $err[0]="Profile updated successfully.";
}
else
{
        $qry="SELECT uname, pwd, email FROM ".$db->tb("admin")." WHERE uid=$auid";
        $db->query($qry);
        $row=$db->getrow();
        $uname=$row[0];
        $pwd=$row[1];
        $email=$row[2];
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
      <table width="258" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <form action="" method="post" onSubmit="return isProfileFormOk(this)">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" nowrap class="nav"><strong>Update Profile 
              </strong></td>
          </tr>
          <?
                  if(count($err)>0)
                  {
                  ?>
          <tr> 
            <td colspan="2" align="center" nowrap class="ltxt"><font color="#FF0000"> 
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
            <td width="73" nowrap class="ltxt"><strong>User Name:</strong></td>
            <td width="175" nowrap> <input name="uname" type="text" class="txtbox" id="uname" value="<?=$uname?>" maxlength="15"></td>
          </tr>
          <tr> 
            <td nowrap class="ltxt"><strong>Password:</strong></td>
            <td nowrap><input name="pwd" type="password" class="txtbox" id="pwd" value="<?=$pwd?>" maxlength="15"></td>
          </tr>
          <tr> 
            <td nowrap class="ltxt"><strong>Email Address:</strong></td>
            <td nowrap><input name="email" type="text" class="txtbox" id="email" value="<?=$email?>" maxlength="50"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center" nowrap> <input name="Submit" type="submit" class="button" value="Update"> 
            </td>
          </tr>
        </form>
      </table>
      <br>&nbsp;
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
