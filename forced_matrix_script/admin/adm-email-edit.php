<?@session_start();
if(session_is_registered("admin"))
{
include("functions.php");
include ('header.php');
db_connect();
if(@$action) mysql_query("update letters set fromemail='".@$fromemail."',fromperson='".@$fromperson."',subject='$subject',message='$message' where action='$action'");
?>
<?$query=mysql_query("select * from letters where action='welcome'"); $result=mysql_fetch_array($query); ?>
<?admin_menu();?>

<center>
<h3>Customise Affiliate Emails</h3>
 <form method="post" action="adm-email-edit.php">
 <input type="hidden" name="action" value="welcome">
        <table width="518" border="0">
         <tr>
                <td colspan="2">
                 <h4><b>Welcome to the affiliate program email</b></h4>
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">From:</td>
                <td width="410">
                 <input type="text" name="fromperson" maxlength="250" value="<?echo $result['fromperson']?>">
                 Enter name here, not email address, </td>
         </tr>
         <tr>
                <td width="98" valign="top">From Email:</td>
                <td width="410">
                 <input type="text" name="fromemail" maxlength="250" value="<?echo $result['fromemail'];?>">
                 Enter email address here</td>
         </tr>
         <tr>
                <td width="98" valign="top">Subject:</td>
                <td width="410">
                 <input type="text" name="subject" size="40" maxlength="250" value="<?echo $result['subject'];?>">
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">
                 <p>Message:</p>
                 <p><b>Keys:<br>
                        [fullname] = <BR>
                        </b><I>Affiliate's full name</I></p>
                 <p><b>[fname] = <br>
                        </b><i>First name</i></p>
                 <p><B>[lname] = <BR>
                        </B><I>Last name</I></p>
                 <p><b>[maxid] = <br>
                        </b><i>Affiliate ID</i></p>
                 <p><b>[password] = <br>
                        </b><i>Affiliate Password</i></p>
                </td>
                <td width="410" valign="top">
                 <textarea name="message" cols="40" rows="20"><?echo $result['message'];?></textarea>
                </td>
         </tr>
         <tr>
                <td colspan="2" valign="top">
                 <div align="center"><br>
                        <input type="submit" name="newaffiliateemail" value="Update welcome email">
                        <INPUT TYPE="reset" VALUE="Reset" NAME="reset">
                 </div>
                </td>
         </tr>
        </table>
 </form>
 <hr width="400" size="1">
 <form method="post" action="adm-email-edit.php">
  <input type="hidden" name="action" value="lostpass">
  <?$query=mysql_query("select * from letters where action='lostpass'"); $result=mysql_fetch_array($query); ?>
        <table width="518" border="0">
         <tr>
                <td colspan="2">
                 <h4><b>Lost password sending email</b></h4>
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">From:</td>
                <td width="410">
                 <input type="text" name="fromperson" maxlength="250" value="<?echo $result['fromperson'];?>">
                 Enter name here, not email address</td>
         </tr>
         <tr>
                <td width="98" valign="top">From Email:</td>
                <td width="410">
                 <input type="text" name="fromemail" maxlength="250" value="<?echo $result['fromemail'];?>">
                 Enter email address here</td>
         </tr>
         <tr>
                <td width="98" valign="top">Subject:</td>
                <td width="410">
                 <input type="text" name="subject" size="40" maxlength="250" value="<?echo $result['subject'];?>">
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">
                 <p>Message:</p>
                 <p><b>Key:<br>
                        [fullname] = <BR>
                        </b><I>Affiliate's full name</I></p>
                 <p><b>[fname] = <BR>
                        </b><I>First name</I></p>
                 <P><B>[lname] = <BR>
                        </B><I>Last name</I></P>
                 <p><b>[affid] = <br>
                        </b><i>Affiliate ID</i></p>
                 <p><b>[password] = <br>
                        </b><i>Affiliate Password</i></p>
                </td>
                <td width="410" valign="top">
                 <textarea name="message" cols="40" rows="20"><?echo $result['message'];?></textarea>
                </td>
         </tr>
         <tr>
                <td colspan="2" valign="top">
                 <div align="center"><br>

                        <input type="submit" name="lostpwdemail" value="Update lost password email">
						<INPUT TYPE="reset" VALUE="Reset" NAME="reset">
                    
                 </div>
                </td>
         </tr>
        </table>
 </form>
 <hr width="400" size="1">
 <form method="post" action="adm-email-edit.php">
 <input type="hidden" name="action" value="signbelow">
 <?$query=mysql_query("select * from letters where action='signbelow'"); $result=mysql_fetch_array($query); ?>
        <table width="518" border="0">
         <tr>
                <td colspan="2">
                 <h4><b>Email sent to affiliate when an affiliate signs up below them</b></h4>
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">From:</td>
                <td width="410">
                 <input type="text" name="fromperson" maxlength="250" value="<?echo $result['fromperson'];?>">
                 Enter name here, not email address</td>
         </tr>
         <tr>
                <td width="98" valign="top">From Email:</td>
                <td width="410">
                 <input type="text" name="fromemail" maxlength="250" value="<?echo $result['fromemail'];?>">
                 Enter email address here</td>
         </tr>
         <tr>
                <td width="98" valign="top">Subject:</td>
                <td width="410">
                 <input type="text" name="subject" size="40" maxlength="250" value="<?echo $result['subject'];?>">
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">
                 <p>Message:</p>
                 <p><b>Key:<br>
                        [fullname] = <BR>
                        </b><I>Affiliate's full name</I><b> </b></p>
                 <p><b>[fname] = <BR>
                        </b><I>First name</I></p>
                 <P><B>[lname] = <BR>
                        </B><I>Last name</I></P>
                </td>
                <td width="410">
                 <textarea name="message" cols="40" rows="20"><?echo $result['message'];?></textarea>
                </td>
         </tr>
         <tr>
                <td colspan="2" valign="top">
                 <div align="center"><br>

                        <input type="submit" name="newreferralemail" value="Update email">
						<INPUT TYPE="reset" VALUE="Reset" NAME="reset">
           
                 </div>
                </td>
         </tr>
        </table>
 </form>
 <hr width="400" size="1">
 <form method="post" action="adm-email-edit.php" >
 <input type="hidden" name="action" value="sale">
 <?$query=mysql_query("select * from letters where action='sale'"); $result=mysql_fetch_array($query); ?>
        <table width="518" border="0">
         <tr>
                <td colspan="2">
                 <h4><b>Email sent to affiliate when they (or one of their downline) generates
                        a sale</b></h4>
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">From:</td>
                <td width="410">
                 <input type="text" name="fromperson" maxlength="250" value="<?echo $result['fromperson'];?>">
                 Enter name here, not email address</td>
         </tr>
         <tr>
                <td width="98" valign="top">From Email:</td>
                <td width="410">
                 <input type="text" name="fromemail" maxlength="250" value="<?echo $result['fromemail'];?>">
                 Enter email address here</td>
         </tr>
         <tr>
                <td width="98" valign="top">Subject:</td>
                <td width="410">
                 <input type="text" name="subject" size="40" maxlength="250" value="<?echo $result['subject'];?>">
                </td>
         </tr>
         <tr>
                <td width="98" valign="top">
                 <p>Message:</p>
                 <p><b>Key:<br>
                        [fullname] = <BR>
                        </b><I>Affiliate's full name</I></p>
                 <p><b>[fname] = <BR>
                        </b><I>First name</I></p>
                 <P><B>[lname] = <BR>
                        </B><I>Last name</I></P>
                 <p><b>[coolingoff] </b><i>= Cooling Off Period (days)</i></p>
                </td>
                <td width="410">
                 <textarea name="message" cols="40" rows="20"><?echo $result['message'];?></textarea>
                </td>
         </tr>
         <tr>
                <td colspan="2" valign="top">
                 <div align="center"><br>
                        <input type="submit" name="newsaleemail" value="Update email">
						<INPUT TYPE="reset" VALUE="Reset" NAME="reset">
                 
                 </div>
                </td>
         </tr>
        </table>
 </form>
 <hr width="400" size="1">
 <FORM METHOD="post" ACTION="adm-email-edit.php">
 <input type="hidden" name="action" value="friends">
 <?$query=mysql_query("select * from letters where action='friends'"); $result=mysql_fetch_array($query); ?>
        <TABLE WIDTH="518" BORDER="0">
         <TR>
                <TD COLSPAN="2">
                 <H4><B>Email affiliate's use to send to their friends</B></H4>
                </TD>
         </TR>
         <TR>
                <TD WIDTH="98" VALIGN="top">Subject:</TD>
                <TD WIDTH="410">
                 <INPUT TYPE="text" NAME="subject" SIZE="40" MAXLENGTH="250" VALUE="<?echo $result['subject'];?>">
                </TD>
         </TR>
         <TR>
                <TD WIDTH="98" VALIGN="top">
                 <P>Message:</P>
                 <P><B>Key:<BR>
                        [affiliatename] = <BR>
                        </B><I>Affiliate's full name</I></P>
                 <P><B>[affiliateemail] = <BR>
                        </B><I>Affiliate's email </I></P>
                 <P><B>[affiliateurl] = <BR>
                        </B><I>Affiliate's URL</I></P>
                 <P><B>[friendname] </B><I>= Affiliate's friend's name</I></P>
                 <P><B>[friendemail] </B><I>= Affiliate's friend's email</I></P>
                </TD>
                <TD WIDTH="410">
                 <TEXTAREA NAME="message" COLS="40" ROWS="20"><?echo $result['message'];?></TEXTAREA>
                </TD>
         </TR>
         <TR>
                <TD COLSPAN="2" VALIGN="top">
                 <DIV ALIGN="center"><BR>
                        <INPUT TYPE="submit" NAME="tellafriend"  id="4" VALUE="Update email">
						<INPUT TYPE="reset" VALUE="Reset" NAME="reset">
           
                 </DIV>
                </TD>
         </TR>
        </TABLE>
 </FORM>
 <br>

  <form method="post" action="adminlogin.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
 </center>
 <?}
 else echo "You are not logged in";
 ?>