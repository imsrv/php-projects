<?php
###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
# 452 Multi-MAIL v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001 452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://www.fsf.org/
###############################################################################
require("config.inc.php");
require("functions.php");
require("default_lang.inc.php");
echo"<font size=\"1\">";
			  if($submit){
			  			  if(check_email_addy($Email)){
															if($default_list){
																$result = mysql_query("SELECT id, welcome FROM lists WHERE list_name='$default_list'") or die("Problem, big problem. " . mysql_error());
																$temp = mysql_fetch_array($result);
																$welcome = $temp[welcome];
																$did = $temp[id];
																$url = "http://" . $base . $mail_loc . "?a=w&e=" . $Email . "&l=$did"; 
																$m = ereg_replace( "\\\\", " ", $welcome);
																$Body =$m . "\r\n" . $msg_to_confirm . "\r\n" . $url;
													
															} else {
																$url = "http://" . $base . $mail_loc . "?a=w&e=" . $Email . "&l=1"; 
																$welcome = mysql_query("SELECT welcome FROM lists WHERE id='$id'");
																$welcome = mysql_fetch_array($welcome);
																$welcome = $welcome["welcome"];
																$Body = stripslashes($welcome . "\r\n" . $msg_to_confirm . "\r\n" . $url);
															}
															if(check_user($Email) == "1"){
			   														echo"$msg_checkfurther";
																		mail("$Email","$msg_subjConf","$Body","From:$nice_mail\nReply-To: $mail_admin");
															}else {
						echo"$msg_oops $call_admin</a>";	
				}

			   } else { 
			   $emessage = "$msg_realemail";
			   ?>
			   <form method="post" action="<?php echo"$PHP_SELF"; ?>">
					<?php echo"$msg_signup "; ?><br>
			   <input type="text" name="Email" value="" size="10">
			   <input type="submit" name="submit" Value="Join!">
			   </form>
			   <?php
		  }
}else{

?>

<form method="post" action="<?php echo"$PHP_SELF" ?>">
<?php echo"$msg_signup"; ?><br>
<input type="text" name="Email" value="" size="10">
<input type="submit" name="submit" Value="Join!">
</form>
<?php 
}
echo"</font>";
?>