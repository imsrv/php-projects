<?php
/* nulled by [GTT] :) */    
include("functions.php");
session_start();
include ('header.php');

if((!@$email)&&!session_is_registered("bayid"))
{
?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF"><table border=0 align="center" cellpadding=2 cellspacing=0>
        <form method="post" action="login_bay.php">
          <tr>
            <td align=right class=right><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Your
              email adress:</font></td>
            <td> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input name="email" type="text" size=7>
              </font></td>
            <td></td>
          </tr>
          <tr>
            <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <input name="submit" type=submit class=but value="Send me link">
              </font></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<?
}
else
{
  $sql = "SELECT * FROM temp_link WHERE date<'".mktime (date('H'),date('i'),0,date("m")  ,date("d")-1,date("Y"))."'";
  $result = mysql_query($sql);
  if (!$result)
  {
     echo $sql;
  }
  else
  {
     if (mysql_num_rows($result) > 0)
     {
        while ($row = mysql_fetch_row($result))
        {
           $path = explode('/',$row['link']);
           unlink('../programs/'.$path[count($path)-2].'/'.$path[count($path)-1]);
           rmdir('../programs/'.$path[count($path)-2]);
        }
     }
  }
  $sql = "SELECT t.*,u.* FROM temp_link t,users_bay u WHERE t.id_user=u.id AND u.email='".$email."'";
  $result = mysql_query($sql);
  if (!$result)
  {
     echo $sql;
  }
  else
  {
  if (mysql_num_rows($result) > 0)
  {
     while ($row = mysql_fetch_array($result))
     {
        if (mail($row['email'], 'Link for program', 'Please click on this link for get programs\nhttp://'.$row['link']))
        {
           echo '<center><font color="red">Link was send to you email</font></center>';
        }
        else
        {
           echo '<center><font color="red">Link was not send to you email</font></center>';
        }
     }
  }
  else
  {
     echo '<center><font color="red">We have no link for you</font></center>';
  }
  }
}
include ('footer.php');
?>
