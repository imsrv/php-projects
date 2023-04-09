<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

define('JS_ERROR', 'Errors have occured during the process of your form!\nPlease make the following corrections:\n\n');
define('ADMIN_LOGIN_ERROR','* New Login required.\n');
define('ADMIN_PASSWORD_ERROR','* New Password required.\n');
define('ADMIN_REPASSWORD_ERROR','* Retype Password required.\n');
define('ADMIN_PASSWORDMATCH_ERROR','* New Password and Retyped Password does not match.\n');
define('TEXT_ADMIN_PASSWORD_SUCCESS','Successful password protection!!!');
define('TEXT_ADMIN_PASSWORD_PROTECTION_SUCCESS','You are now password protecting your admin directory.');
$jstype = "include";
//$jsfile = "admin_passwd.js";

$updatepwd = true;
if ($HTTP_POST_VARS['todo'] == "chpasswd"){
       //<<begin fields validations
       if (empty($HTTP_POST_VARS['adm_login'])) {
                  bx_error("New Login is required.");
                  $updatepwd = false;
                  include("admin_footer.php");
                  exit;
       }
       if (empty($HTTP_POST_VARS['adm_passwd'])) {
                  bx_error("New Password is required.");
                  $updatepwd = false;
                  include("admin_footer.php");
                  exit;
       }
       if (empty($HTTP_POST_VARS['adm_repasswd'])) {
                  bx_error("Retype Password is required.");
                  $updatepwd = false;
                  include("admin_footer.php");
                  exit;
       }
       if ($HTTP_POST_VARS['adm_passwd'] != $HTTP_POST_VARS['adm_repasswd']) {
                  bx_error("New Password and Retyped Password does't match.");
                  $updatepwd = false;
                  include("admin_footer.php");
                  exit;
       }
	   $fp=fopen(DIR_SERVER_ADMIN."auth_pass.php","w");
       $to_write = "<?\n";
       $to_write .= "\$admin_user_f = \"".md5($HTTP_POST_VARS['adm_login']."Php-Jokesite admin authorization")."\";\n";
       $to_write .= "\$admin_pass_f = \"".md5($HTTP_POST_VARS['adm_passwd']."Php-Jokesite admin authorization")."\";\n";
       $to_write .= "?".">";
       fwrite($fp, $to_write);
       fclose($fp);

       if ($updatepwd) {
           ?>
             <font class="head_text1">Change Admin Password</font>
             <br><br>
             <table border="0" cellpadding="2" cellspacing="0" width="85%" align="center">
             <tr>
             <td class="bigtext" colspan="2" align="center">
                    &nbsp;&nbsp;&nbsp;Successful password protection!!!
              </td>
              </tr>
              <tr>
              <td class="smalltext" colspan="2" align="center">
                      <font color="#FF0000"><br>***** You are now password protecting your admin directory.</font>
              </td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              </table>
           <?
      }//end if $updatepwd
	 session_unregister("adm_user");
	session_unregister("adm_pass");
	
}//end if ($HTTP_POST_VARS['todo'] == "chpasswd")
else {
?>
<font class="head_text1">Change Admin Password</font>
<br><br>
<form method="post" action="admin_password.php" name="chpasswd" onSubmit="return check_form();">
<input type="hidden" name="todo" value="chpasswd">
<table border="0" cellpadding="2" cellspacing="0" width="85%" align="center">
<tr>
	<td class="smalltext" colspan="2">
		&nbsp;&nbsp;&nbsp;You can now password protect your admin directory.<br>
        &nbsp;&nbsp;&nbsp;By pushing the update button, the password protection will be deleted, and recreated with information given below. This way you wil get a password promt when accessing the admin dir. 
	</td>
</tr>
<tr>
	<td class="smalltext" colspan="2">
		<font color="#FF0000"><br>***** Note: This type of protection is often available on Unix/Linux systems, but on Windows system, other methods of protection of the admin directory may be needed instead.</font>
	</td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
        <td align="right" class="smalltext2"><b>New Login:</b></font></td><td valign="top"><input type="text" name="adm_login"></td>
</tr>
<tr>
        <td align="right" class="smalltext2"><b>New Password:</b></font></td><td valign="top"><input type="text" name="adm_passwd"></td>
</tr>
<tr>
        <td align="right" class="smalltext2"><b>Retype Password:</b></font></td><td valign="top"><input type="text" name="adm_repasswd"></td>
</tr>
<tr>
        <td colspan="2" align="center" class="smalltext2"><br><input type="submit" name="update" value="Update" class="button1"></td>
</tr>
</table>
</form>
<?
}
include("admin_footer.php");
?>