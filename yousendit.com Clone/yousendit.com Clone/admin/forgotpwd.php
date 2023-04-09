<?php
ob_start();
session_start();
require_once("../include/vars.php");
require_once("../include/functions.php");
$err=array();
if(count($_POST)>0)
{
        require_once("../include/db.php");
        $email=trim($_REQUEST['email']);
                
        $qry="SELECT uname, pwd FROM ".$db->tb("admin")." WHERE email='$email'";
        $db->query($qry);
        if($db->getrownum()>0)
        {       $password = substr(md5(time()),0,10);
                $md5      = md5($password);
                $db->query("UPDATE ".$db->tb("admin")." SET `pwd`='".$md5."'");
                $row=$db->getrow();
                $headers = "From: Delivary@".SITE_NAME.".com <Delivary@".SITE_NAME.".com>\nMIME-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\nX-Mailer: PHP\n";
                $subject="Password Sent";
                $msg="Hello from ".SITE.",<br>
                Your Username is: ".$row[0]."
                <br>And Password is: ".$password."<br>
                This email was automatically generated, please do not reply to it. For 
                any inquiries, feel free to email <a href=\"mailto: support@".SITE_NAME.".com\">support@".SITE_NAME.".com</a><br>
                The ".SITE_NAME." Team";                
                if(empty($message)) $msg.="Additional Messgae:<br>$message";
                @mail($email, $subject, "<font face=Tahoma size=2>".$msg."</font>", $headers);
                
                header("Location: index.php"); exit;
        }
        else
        {
                $err[]="Sorry! Your email doesn't exist at our database.";
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
      <table width="50%" align="center" cellpadding="2" cellspacing="0" class="table" style="border: 1px solid #9cab93">
        <form action="" method="post" onSubmit="return isSendPwdFormOk(this)">
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center" nowrap class="nav"><strong>Retrieve 
              your password now!</strong></td>
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
            <td width="36%" nowrap class="ltxt"><strong>Email Address:</strong></td>
            <td width="64%" nowrap> 
              <input name="email" type="text" class="txtbox" id="email" maxlength="50"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center" nowrap> <input name="Submit" type="submit" class="button" value="Send Now"> 
            </td>
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
