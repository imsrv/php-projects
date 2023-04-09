<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
include_once("../functions.php");
include_once("../".$installed_config_file);
session_start();
if (session_is_registered('admin_md5_pass')) pama_authenticate($_SESSION['admin_username'],$_SESSION['admin_md5_pass'],'admin',0);
else
{
 js_msg("Error, please re-login.  CODE: LEa0");
 include("logoff.php");
 exit;
}
if (isset($id))
{
 $date_now = time();
 $their_password = random_password(8);
 $md5_password = md5($their_password);
 $update_query = "UPDATE pama_members
                    SET activated='1',
                        their_password='$md5_password',
                        activated_date='$date_now'
                    where id='$id'";
 $result = mysql_query($update_query);
 js_msg("New member activated and email sent.");
 $logged_in="<b><small><small><font color=\"#008000\">:: You are logged in ::</font>
            <br></small><a href=\"logoff.php\">Log off</a><br><br>
            <a href=\"get_details.php\">Main Menu</a></small></b>";
 $page_title="Admin area - activate new members";
 include_once("header.html");
 $get_query = "SELECT * from pama_members
                   where id='$id'";
 $result=mysql_query($get_query);
 $email = mysql_result($result,0, 'email');
 $get_query = "SELECT * from pama_admin";
 $result=mysql_query($get_query);
 $contact_email = mysql_result($result,0, 'contact_email');
 $their_username = $email;

 include("email_activated_login_details.php");
}
$result=mysql_query("SELECT * FROM pama_members where activated='0'");
if (mysql_num_rows($result))  // check has got some
{
 $i = 0;
 echo "<br><center><b>Click the ACTIVATE link next to the name of the member you wish to activate<br>and the account details email will be sent to the new member (and cc: to admin contact).</b></center><blockquote>";
 while ($i < mysql_num_rows($result))
  {
   $id=mysql_result($result,$i, 'id');
   $name = mysql_result($result,$i, 'name');
   $companyname = mysql_result($result,$i, 'companyname');
   $email = mysql_result($result,$i, 'email');
   echo "<a href=\"javascript:activate('$id')\"><small>ACTIVATE:</small></a> <b>$name</b>, of $companyname, email:<b> $email</b>, Join date: ".strftime("%b %d, %Y",$id)."<hr size=1>";
   $i++;
  }
 echo "</blockquote>";
}
else echo "<br><br><hr><center><h3>Currently there are NO new members awaiting activation.</h3><hr><br><br><br>";
db_close();
?>
<form name="AF" method="post">
  <input type="hidden" name="id" value>
</form>
<script LANGUAGE="JavaScript"><!--

function activate(id)
{
 document.AF.id.value=id;
 document.AF.action="activate.php";
 document.AF.submit();
}
// --></script>
<?
include_once("footer.html");
?>
