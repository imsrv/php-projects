<?
include_once "logincheck.php"; 
include_once "../config.php";
$id=$_REQUEST["id"];
$rst=mysql_fetch_array(mysql_query("select * from sbwmd_member_feedback where id=$id"));
?>
<div align="center">
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td height="1" colspan="4" bgcolor="#666666"></td>
    </tr>
    <tr> 
      <td width="126" align="left"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Title:</font></strong></td>
      <td colspan="3"><? echo $rst["title"];?></td>
    </tr>
    <tr> 
      <td align="left"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></strong></td>
      <td colspan="3"><? echo $rst["fname"]." ".$rst["lname"];?></td>
    </tr>
    <tr bgcolor="#EEEEEE"> 
      <td align="left"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Comments:</font></strong></td>
      <td colspan="3"><? echo str_replace("\n","<br>",$rst["comment"]);?></td>
    </tr>
    <tr>
      <td align="left"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Member 
        Name :</font></strong></td>
      <td><? $rs_t0=mysql_fetch_array(mysql_query("select username from sbwmd_members where id=".$rst["uid"])); echo $rs_t0[0];?></td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="left"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></strong></td>
      <td width="137"><? echo $rst["email"];?></td>
      <td width="38" align="right"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL:</font></strong></td>
      <td width="99"><? echo $rst["url"];?></td>
    </tr>
    <tr> 
      <td height="1" colspan="4" bgcolor="#666666"></td>
    </tr>
  </table>
</div>