<?
/* nulled by [GTT] :) */    

include("functions.php");
db_connect();
@session_start();

if(session_is_registered("usid"))
{
include ('header.php');
$result=db_result_to_array("select subject, message from letters where action='friends'");
$subject=$result[0][0];
$message=$result[0][1];
$result=db_result_to_array("select frstname, lstname, email from users where id='$usid'");
$frstname=$result[0][0];
$lstname=$result[0][1];
$email=$result[0][2];
$subject=str_replace("[affiliatename]", "$frstname $lstname", $subject);
$message=str_replace("[affiliatename]", "$frstname $lstname", $message);
$result=db_result_to_array("select defurl, affdir from admininfo");
$affurl="http://".$result[0][0]."".$result[0][1]."/referral/register.php?affid=".$usid;
$message=str_replace("[affiliateurl]", "$affurl", $message);
$message=str_replace("[affiliateemail]", $email, $message);
$message=str_replace("[lname]", $lstname, $message);
if (@$go&&@$friendname&&@$friendemail&&@$message)//&&@$affmessage
{
$messagesend=str_replace("[friendname]", "$friendname", $message);
$affmessagesend=str_replace("[friendname]", "$friendname", $affmessage);
$messagesend=$messagesend."\n\nPS:\n".$affmessagesend;
$messagesend=str_replace("[friendemail]", "$friendemail", $messagesend);
//echo "Friend e-mail: $friendemail<br>Subject:  $subject<br>Message: $messagesend<br>FROM: $frstname $lstname <$email>";
mail($friendemail, $subject, $messagesend, "FROM: $frstname $lstname <$email>");
echo "<br><br><align=center><center><font color=FFFFFF><font size=4><b>Your message has been sent!</b></font size><br><br>Just enter a new name and e-mail address to send another.</b></center></font color><br>";
}
else if ($go&&($friendname||$friendemail||$message))
 echo "You did not fill in all the fields!";
?>
<CENTER>
  <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#FFFFFF"><h3 align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Tell
          a friend</font></h3>
        <FORM METHOD="post" ACTION="emailfriend.php">
          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type=hidden name=go value=1>
            </font>
            <TABLE WIDTH="395">
              <TR>
                <TD WIDTH="101"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Friend's
                  name</font></TD>
                <TD WIDTH="282"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <INPUT TYPE=text NAME="friendname">
                  </font></TD>
              </TR>
              <TR>
                <TD WIDTH="101"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Friend's
                  email</font></TD>
                <TD WIDTH="282"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <INPUT TYPE=text NAME="friendemail">
                  </font></TD>
              </TR>
              <TR>
                <TD WIDTH="101"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></TD>
                <TD WIDTH="282"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?echo $subject;?></font></TD>
              </TR>
              <TR>
                <TD WIDTH="101" VALIGN="TOP"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Message:</font></TD>
                <TD WIDTH="282"><P> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <TEXTAREA name="textarea" COLS="50" ROWS="20" disabled><?echo $message;?></TEXTAREA>
                    <BR>
                    PS:
                    <textarea name="affmessage" cols="48" rows="5">My message to you, [friendname]</textarea>
                    </font></P></TD>
              </TR>
              <TR>
                <TD COLSPAN="2"><CENTER><br>
                    <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <INPUT TYPE="submit" NAME="sendemail" VALUE="Send this email to a friend">
                    </font></CENTER></TD>
              </TR>
            </TABLE>
          </div>
        </FORM>
        <div align="center"></div>
        <form method="post" action="login.php">
          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type="submit" name="Submit" value="Click here to return to Main Menu">
            </font></div>
        </form></td>
    </tr>
  </table>
</CENTER>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<?
include ('footer.php');
}
else
{
  include ('header.php');
  echo "Access denied";
  include ('footer.php');
}

?>
</font>