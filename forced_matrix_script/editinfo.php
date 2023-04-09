<font size="2" color=FFFF00 face="Verdana, Arial, Helvetica, sans-serif"><?php
/* nulled by [GTT] :) */    

@session_start();
include("functions.php");
include ('header.php');
if(session_is_registered("usid"))
{
db_connect();
if(@$update&&$password&&$email&&$frstname&&$lstname&&$city&&$address&&$zip&&$country){
mysql_query("update users set frstname='$frstname',password='$password',lstname='$lstname', state='$state', zip='$zip', website='$website', phone='$phone', socsec='$socsec', compname='$compname', country='$country',city='$city',zip='$zip',address='$address',email='$email'  where id='$usid'");}
$result=mysql_query("select * from users where id='$usid'");
$result=mysql_fetch_array($result);?>
<CENTER>
  <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="">
    <tr>
      <td ><form method="post" action="editinfo.php">
          <div align="center">
            <input type=hidden name=update value=1>
            Here are your payment details: </div>
          <div align="center">(** - are required fields) </div>
                  <small>NOTE: Social security number is necessary to be filled only after you have generated minimum $600 in your affiliate account</small><br><br>
          <table width="700" border="0" align="center">
            <tr>
              <td width="101">**Password:</td>
              <td width="187"><b><?echo $result['password'];?></b></td>
              <td width="396"> <input type="text" name="password" size="25" maxlength="250" value="<?echo $result['password'];?>">
              </td>
            </tr>
            <tr>
            <tr>
              <td width="101">**First Name:</td>
              <td width="187"><b><?echo $result['frstname'];?></b></td>
              <td width="396"> <input type="text" name="frstname" size="25" maxlength="250" value="<?echo $result['frstname'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">**Last Name:</td>
              <td width="187"><b><?echo $result['lstname'];?></b></td>
              <td width="396"> <input type="text" name="lstname" size="25" maxlength="250" value="<?echo $result['lstname'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">Company Name:</td>
              <td width="187"><b>
                <?if (!$result['compname']) echo "N/A"; else echo $result['compname'];?>
                </b></td>
              <td width="396"> <input type="text" name="compname" maxlength="250" value="<?echo $result['compname'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">**Address:</td>
              <td width="187"><b><?echo $result['address'];?></b></td>
              <td width="396"> <input type="text" name="address" size="30" maxlength="250" value="<?echo $result['address'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">**City:</td>
              <td width="187"><b><?echo $result['city'];?></b></td>
              <td width="396"> <input type="text" name="city" maxlength="250" value="<?echo $result['city'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">State/**Zip:</td>
              <td width="187"><b>
                <?if (!$result['state']) echo "N/A"; else echo $result['state'];?>
                &nbsp;&nbsp;/ &nbsp;&nbsp;<?echo $result['zip'];?></b></td>
              <td width="396"> <input type="text" name="state" size="15" maxlength="50" value="<?echo $result['state'];?>">
                /
                <input type="text" name="zip" size="5" maxlength="10" value="<?echo $result['zip'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">**Country:</td>
              <td width="187"><b><?echo $result['country'];?></b></td>
              <td width="396"> <input type="text" name="country" size="25" maxlength="100" value="<?echo $result['country'];?>">
              </td>
            </tr>
            <TR>
              <TD WIDTH="101">Social Security :</TD>
              <TD WIDTH="187"><B>
                <?if (!$result['socsec']) echo "N/A"; else echo $result['socsec'];?>
                </B></TD>
              <TD WIDTH="396"> <INPUT TYPE="text" NAME="socsec" SIZE="11" MAXLENGTH="11" value="<?echo $result['socsec'];?>">
              </TD>
            </TR>
            <tr>
              <td width="101">Phone:</td>
              <td width="187"><b>
                <?if (!$result['phone']) echo "N/A"; else echo $result['phone'];?>
                </b></td>
              <td width="396"> <input type="text" name="phone" size="12" maxlength="15" value="<?echo $result['phone'];?>">
              </td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="101">**Email:</td>
              <td width="187"><b><?echo $result['email'];?></b></td>
              <td width="396"> <input type="text" name="email" size="30" maxlength="100" value="<?echo $result['email'];?>">
              </td>
            </tr>
            <tr>
              <td width="101">Website:</td>
              <td width="187"><b>
                <?if (!$result['website']) echo "N/A"; else echo "http://$result[website]";?>
                </b></td>
              <td width="396"> http://
                <input type="text" name="website" maxlength="250" size="35" value="<?echo $result['website'];?>">
              </td>
            </tr>
            <tr align="center">
              <td colspan="3"><br>
                <br> <br> <input name="submit" type="submit" value="Update Details" >
                <input name="reset" type="reset" value="Clear Form"> </td>
            </tr>
          </table>
        </form>
        <form method="post" action="login.php">
          <div align="center">
            <input type="submit" name="Submit" value="Click here to return to Main Menu">
          </div>
        </form>

      </td>
    </tr>
  </table>
  <?}
else echo "You are not logged in!";

include ('footer.php');
?>
  <p>&nbsp;</p>
</CENTER>
