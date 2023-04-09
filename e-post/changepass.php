<form method=post action="index.php?log=change">
Old password:<br />
<input type=text name=old_passwd style="font-size:10px;border:solid 1px;"><br />
New password:<br />
<input type=text name=new_passwd style="font-size:10px;border:solid 1px;"><br />
Repeat new password:<br />
<input type=text name=new_passwd2 style="font-size:10px;border:solid 1px;"><br />
<input type=image src="images/cp.gif" name=change value="Change password" style="font-size:10px;">
</form>
<?
$checkpass = "SELECT passwd FROM e_users WHERE username='$_SESSION[valid_user]'";
$checkpassquery = mysql_query($checkpass, $db_conn) or die("query [$checkpass] failed: ".mysql_error());
$rowcheckpass = mysql_fetch_assoc($checkpassquery);
$_SESSION['pass'] = $rowcheckpass['passwd'];
if (strlen($new_passwd)>16 || strlen($new_passwd)<4) 
   echo "Passwords must be between<br />4 and 16 chars."; 
elseif ($_SESSION['pass'] != $old_passwd) 
   echo "Your old password is incorrect<br />please try again."; 
elseif ($new_passwd!=$new_passwd2) 
   echo "The passwords do not match.<br />passwords not changed."; 
else
{
$pquery = "update e_users set passwd = '$new_passwd' where username = '$valid_user'";
@mysql_query($pquery, $db_conn);
  echo "<div class=\"log\">password changed</div>";
$_SESSION['pass'] = '$new_passwd';
}
?>
