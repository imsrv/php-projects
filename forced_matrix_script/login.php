<?php
/* nulled by [GTT] :) */    

include("functions.php");
session_start();
include ('header.php');

if((!@$password||!$id)&&!session_is_registered("usid"))
{?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF"><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#FFFFFF">
          <td width="416"> <div align="center"><img src="images/money.jpg" width="225" height="150"><br>
              <font size="4" face="Arial Narrow"><strong>JOIN THE BEST<br>
              AFFILIATE PROGRAM IN THE NET</strong></font><br>
              <font size="3">~ <font face="Arial Narrow"><strong>YOUR TEXT HERE
              ~</strong></font></font></div></td>
          <td width="344"> <div align="center"><strong></strong></div>
            <div align="center"><b>Please, sign in above<br>
              or <a href="register.php">register
              here</a></b></div></td>
        </tr>
      </table>
      <div align="center"><font color="#5f667d" size="5" face="Verdana, Arial, Helvetica, sans-serif">
        <?php
}
else{
if (!session_is_registered("usid")){
db_connect();
$result=mysql_query("select password from users where id='$id'");
$result=mysql_fetch_array(@$result);
if($password!=$result['password'] ||!$result)
{echo "Access denied";}
else{
session_register("usid");
$usid=$id;}}
if (session_is_registered("usid")){
?>
        </font> </div>
      <div align="center">
<table width="788" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td bgcolor="#FFFFFF"><p align="center"><font color="#5f667d" size="5" face="Verdana, Arial, Helvetica, sans-serif">
                <br>
                Welcome back!</font></p>
              <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">You
                have the following options available to you:</font></p>
              <div align="center">
                <table width="341" height="102" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="341" bgcolor="#edf0f5"><font color="#57667d" size="2" face="Verdana, Arial, Helvetica, sans-serif">1.
                      <a href="editinfo.php">View/ Edit your Contact Information</a></font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#edf0f5"><font color="#57667d" size="2" face="Verdana, Arial, Helvetica, sans-serif">2.
                      <a href="affstats.php">View your Affiliate Statistics including
                      Balances</a></font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#edf0f5"><font color="#57667d" size="2" face="Verdana, Arial, Helvetica, sans-serif">3.
                      <a href="getlink.php">View available Advertising code</a></font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#edf0f5"><font color="#57667d" size="2" face="Verdana, Arial, Helvetica, sans-serif">4.
                      <a href="emaildownline.php">Email entire downline</a></font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#edf0f5"><font color="#57667d" size="2" face="Verdana, Arial, Helvetica, sans-serif">5.
                      <a href="emailfriend.php">Tell a friend</a></font></td>
                  </tr>
                </table>
              </div></td>
          </tr>
        </table>
      </div>
<? }
}

include ('footer.php');
?></td>
  </tr>
</table>