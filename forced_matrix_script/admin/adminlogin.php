<?php
include("functions.php");
session_start();
include("header.php");


if((!@$password||!@$login)&&!session_is_registered("admin"))
{?> 
<div align="center"><b>Login here:</b> </div>
<tr> 
  <td bgcolor="#FFFFFF"> <div align="center">
      <table align="center"><tr><td><form name="login" method="get" action="adminlogin.php"></td>
        <td></td></tr>
        <tr>
          <td>login:</td>
          <td> <input name="login" type="text"></td>
          <br>
        </tr>
        <tr>
          <td>password:</td>
          <td> <input name="password" type="Password"></td>
          <br>
          <br>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td><input name="enter" type="Submit" value="Verify"></td>
          <td></td>
        </tr>
      </table></form>
      <?php

}

else{

if (!session_is_registered("admin")){

db_connect();

@$result=mysql_query("select password from admininfo where name='$login'");

$result=mysql_fetch_array(@$result);

if($password!=$result['password'] ||!$result)

{echo "Access denied";}

else{

@session_start();

session_register("admin");

$admin="admin";}}

if (session_is_registered("admin")){

?>
    </div>
    <p align="center">&nbsp;</p>
    <div align="center">
      <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td bgcolor="#FFFFFF"> <div align="center"> 
              <ol>
                <p align="center"><font size="4" color="#FF0000">Welcome back!</font></p>
                <p align="center">You have the following options available to 
                  you: <br>
                </p>
                <li><a href="adminedit.php">Modify Admin Login Details</a></li>
                <li><a href="admafflist.php">List Current Affiliates</a></li>
                <li><a href="admpref.php">Preferences</a></li>
                <li><a href="admbanners.php">Banner and Text Link Setup</a></li>
                <li><a href="upload.php">Manage Software Programs</a></li>
                <li><a href="admsubscr.php">Manage Subscribtions</a></li>
                <li><a href="admitemset.php">Affiliate Payment / Single Item Setup</a></li>
                <li><a href="admrefunds.php">Cancel Payments / Refunds</a></li>
                <li><a href="adm-email-edit.php">Customise emails to affiliates</a></li>
                <li><a href="admallaffmail.php">Email all affiliates</a></li>
                <li><a href="admstartpages.php">Customise affiliate start pages</a></li>
                <li><a href="adm-shift.php">Shift Downline</a></li>
                <li><a href="addbanner.php">Banners</a></li>
              </ol>
            </div></td>
        </tr>
      </table>
      <?}

}

?>
    </div>