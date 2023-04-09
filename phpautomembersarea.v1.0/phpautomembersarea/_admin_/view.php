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
$logged_in="<b><small><small><font color=\"#008000\">:: You are logged in ::</font>
            <br></small><a href=\"logoff.php\">Log off</a><br><br>
            <a href=\"get_details.php\">Main Menu</a></small></b>";
$page_title="Admin area - view members";
include_once("header.html");
if (isset($the_action))
{
 if ($the_action=="delete")
 {
  $date_now = time();
  $update_query = "DELETE from pama_members
                    where id='$id'";
  $result = mysql_query($update_query);
  js_msg("Member DELETED.");
 }
 else
 {
  $date_now = time();
  $get_query = "SELECT * from pama_members
                    where id='$id'";
  $result=mysql_query($get_query);
  $row = mysql_fetch_array($result);
  db_close();
  include("modify.html");
  include_once("footer.html");
  exit;
 }
}
if (isset($save))
{
 $update_query = "
  UPDATE pama_members
    SET companyname='$companyname',
        name='$name',
        address='$address',
        email='$email',
        tel='$tel',
        postcode='$postcode'
  WHERE id=$id";
 $result = mysql_query($update_query);
}
$result=mysql_query("SELECT * FROM pama_members");
if (mysql_num_rows($result))  // check has got some
{
 $i = 0;
 echo "<br><center><b>Click the relevant link next to the name of the member.</b></center><blockquote>";
 while ($i < mysql_num_rows($result))
  {
   $id=mysql_result($result,$i, 'id');
   $name = mysql_result($result,$i, 'name');
   $companyname = mysql_result($result,$i, 'companyname');
   $email = mysql_result($result,$i, 'email');
   echo "<a href=\"javascript:action('$id','view','')\">View/Modify</a> |
         <a href=\"javascript:action('$id','delete','$name')\">Delete:</a>
         <b>$name</b>, of $companyname, email:<b> $email</b>, Join date: "
         .strftime("%b %d, %Y",$id)."<hr size=1>";
   $i++;
  }
 echo "</blockquote>";
}
else echo "<br><br><hr><center><h3>Currently you have NO members.</h3><hr><br><br><br>";
db_close();
?>
<form name="AF" method="post" action="view.php">
  <input type="hidden" name="id" value>
  <input type="hidden" name="the_action" value>
</form>
<script LANGUAGE="JavaScript"><!--

function action(id,the_action,name)
{
 document.AF.id.value=id;
 document.AF.the_action.value=the_action;
 if (the_action=="delete")
 {
  if (confirm("Are you sure you want to delete:\n\n" +name)) document.AF.submit();
 }
 else document.AF.submit();
}
// --></script>
<?
include_once("footer.html");
?>
