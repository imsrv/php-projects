<?php
require_once("../include/vars.php");
require_once("../include/functions.php");
session_start();
$err=array();
if(count($_POST)>0)
{
        require_once("../include/db.php");
        $uname=$_REQUEST['uname'];
        $pwd=md5($_REQUEST['pwd']);
                
        $qry="SELECT uid FROM ".$db->tb("admin")." WHERE uname='$uname' AND pwd='$pwd'";
        $db->query($qry);
        if($db->getrownum()>0)
        {
                $row=$db->getrow();
                session_register("auid");
                $_SESSION["auid"]=$row[0];
                        
                $qry="SELECT MIN(timein), COUNT(*) FROM ".$db->tb("adminlog")." WHERE uid=".$row[0];
                $db->query($qry);
                $row1=$db->getrow();
                if($row1[1]>=15)
                {
                        $qry="DELETE FROM ".$db->tb("adminlog")." WHERE uid=".$row[0]." and timein=".$row1[0];
                        $db->query($qry);
                }        
                
                $qry="INSERT INTO ".$db->tb("adminlog")."(uid,timein,ip) VALUES(".$row[0].",".time().",'".$_SERVER['REMOTE_ADDR']."')";
                $db->query($qry);
                
                header("Location: lastlogins.php"); exit;        
        }
        else
        {
                $err[]="Wrong Username/Password.";
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
      <table width="258" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <form action="" method="post" onSubmit="return isLoginFormOk(this)">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" nowrap class="nav"><strong>Login Panel</strong></td>
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
            <td width="175" nowrap> 
              <input name="uname" type="text" class="txtbox" id="uname" maxlength="15"></td>
          </tr>
          <tr> 
            <td nowrap class="ltxt"><strong>Password:</strong></td>
            <td nowrap><input name="pwd" type="password" class="txtbox" id="pwd" maxlength="15"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center" nowrap> 
              <input name="Submit" type="submit" class="button" value="Login"> 
            </td>
          </tr>
          <tr> 
            <td nowrap>&nbsp;</td>
            <td nowrap> <A href="forgotpwd.php" class="ltxt">Forget password</A> 
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
