<?
/***************************************************************************
 *                         AutoHits  PRO                                   *
 *                      -------------------                                *
 *   Version         : 1.0                                                 *
 *   Released        : 02.20.2003                                          *
 *   copyright       : (C) 2003 SupaTools.com                              *
 *   email           : info@supatools.com                                  *
 *   website         : www.supatools.com                                   *
 *   custom work     :http://www.gofreelancers.com                         *
 *   support         :http://support.supatools.com                         *
 *                                                                         *
 ***************************************************************************/
//require('error_inc.php');
require('config_inc.php');
require('header_inc.php');

if($page=='') $page = '1';

if($pri=='Save values'){
	if($page == '1'){ //use area
		$f=fopen("../error_inc.php",'w');
		fputs($f,"<?\n");
		fputs($f,"\$subject[1]=\"$subject1\";\n");
		fputs($f,"\$subject[2]=\"$subject2\";\n");
		fputs($f,"\$subject[3]=\"$subject3\";\n");
		fputs($f,"\$subject[6]=\"$subject6\";\n");
		fputs($f,"\$subject[4]=\"$subject4\";\n");
		fputs($f,"\$subject[5]=\"$subject5\";\n");
		fputs($f,"\$body[1]=\"$body1\";\n");
		fputs($f,"\$body[2]=\"$body2\";\n");
		fputs($f,"\$body[3]=\"$body3\";\n");
		fputs($f,"//Macroses [id],[email],[pass]\n");
		fputs($f,"\$body[4]=\"".str_replace("\r","",$body4)."\";\n");
		fputs($f,"\$msg[1]=\"$msg1\";\n");
		fputs($f,"\$msg[2]=\"$msg2\";\n");
		fputs($f,"\$msg[3]=\"".str_replace("\r","",$msg3)."\";\n");
		fputs($f,"\$err[1]=\"$err1\";\n");
		fputs($f,"\$err[2]=\"$err2\";\n");
		fputs($f,"\$err[3]=\"$err3\";\n");
		fputs($f,"\$err[4]=\"$err4\";\n");
		fputs($f,"\$err[5]=\"$err5\";\n");
		fputs($f,"\$err[6]=\"$err6\";\n");
		fputs($f,"\$err[7]=\"$err7\";\n");
		fputs($f,"\$err[8]=\"$err8\";\n");
		fputs($f,"\$err[9]=\"$err9\";\n");
		fputs($f,"\$err[10]=\"$err10\";\n");
		fputs($f,"?>");
		fclose($f);
	}else{ // admin area
		$f=fopen("error_inc.php",'w');
		fputs($f,"<?\n");
		fputs($f,"\$title_adm=\"$title_adm\";\n");
		fputs($f,"\$author_email=\"$author_email\";\n");
		fputs($f,"\$subject[1]=\"$subject1\";\n");
		fputs($f,"\$subject[2]=\"$subject2\";\n");
		fputs($f,"\$subject[3]=\"$subject3\";\n");
		fputs($f,"\$body[1]=\"$body1\";\n");
		fputs($f,"\$body[2][1]=\"".str_replace("\r","",$body21)."\";\n");
		fputs($f,"\$body[2][7]=\"$body27\";\n");
		fputs($f,"\$body[3]=\"".str_replace("\r","",$body3)."\";\n\n");
		
		fputs($f,"\$body[2][2]=\"\n");
		fputs($f,"\n");
		fputs($f,"Site Name [site]	\n");
		fputs($f,"Site URL [url]	\n");
		fputs($f,"Total hits [hits]	\n");
		fputs($f,"From last Mail	[last_mail]\n");
		fputs($f,"Credits [credits1]	\n");
		fputs($f,"State   [state]\";\n");
		fputs($f,"\$body[2][3]=\"\n");
		fputs($f,"\n");
		fputs($f,"Hits Received on this week\n");
		fputs($f,"\n");
		fputs($f,"Date	   Received\n");
		fputs($f,"\";\n");
		fputs($f,"\$body[2][4]=\"[date_r]   [receive]\n");
		fputs($f,"\";\n");
		fputs($f,"\$body[2][5]=\"\n");
		fputs($f,"Date	   Earned\n");
		fputs($f,"\";\n");
		fputs($f,"\$body[2][6]=\"[date_e]   [earn]\n");
		fputs($f,"\";\n\n");
		fputs($f,"\$msg[1]=\" No new sites\";\n");
		fputs($f,"\$msg[2]=\" No users\";\n");
		fputs($f,"\$msg[3]=\" Mail was sent\";\n");
		fputs($f,"\$msg[4]=\" No users Admin\";\n");
		fputs($f,"\$err[1]=\" Login or password incorrect\";\n");
		fputs($f,"\$err[2]=\" Cannot connect\";\n");
		fputs($f,"\$err[3]=\" Fill all fields\";\n");
		fputs($f,"\$err[4]=\" Cannot add\";\n");
		fputs($f,"\$err[5]=\" Cannot delete\";\n");
		fputs($f,"\$err[6]=\" Cannot edit\";\n");
		fputs($f,"\$err[7]=\" Cannot publish\";\n");
		fputs($f,"\$err[8]=\" Target even one category\";\n");
		fputs($f,"\$err[9]=\" User alredy exist please enter new name\";\n");
		fputs($f,"\$err[10]=\" Enter current value of field\";\n");
		fputs($f,"\$err[11]=\" Cannot send to\";\n");
		fputs($f,"\$err[12]=\" Cannot find\";\n");
		fputs($f,"?>");
		fclose($f);
	}
	print "<p class=red>Data has been saved.</p>";
}

if($page=='1') require_once("../error_inc.php");
else require_once("error_inc.php");

?>
<table border="0">
<form action="" method=post>
<tr>
	<td align="center">
		<table border="0" width="100%"><tr>
			<td align="center"><a href="setup.php?page=1"><b>Edit Public area messages...</b></a></td>
			<td align="center"><a href="setup.php?page=2"><b>Edit Admin area messages...</b></a></td>
		</tr></table>
	</td>
</tr>
<?if($page == '1'){ // edit public messages?>
<tr>
	<td>
		<br><b>Editing public messages:</b>
		<table>
		<tr><td colspan="2" bgcolor=#AAAAAA style="text-align:center"><b>Email Subjects</b></td></tr>
		<tr><td>New User has registed - Admin email</td><td><input type=text size=100 style="width:500px" name='subject1' value='<?=$subject[1]?>'></td></tr>
		<tr><td>Users Password</td><td><input type=text size=100 style="width:500px" name='subject2' value='<?=$subject[2]?>'></td></tr>
		<tr><td>User Changed Password</td><td><input type=text size=100 style="width:500px" name='subject3' value='<?=$subject[3]?>'></td></tr>
		<tr><td>User Changed Email Address</td><td><input type=text size=100 style="width:500px" name='subject6' value='<?=$subject[6]?>'></td></tr>
		<tr><td>New Registration Email</td><td><input type=text size=100 style="width:500px" name='subject4' value='<?=$subject[4]?>'></td></tr>
		<tr><td>Confirm Account Email</td><td><input type=text size=100 style="width:500px" name='subject5' value='<?=$subject[5]?>'></td></tr>
		<tr><td colspan="2" bgcolor=#AAAAAA style="text-align:center"><b>Email Body</b></td></tr>
		<tr><td>New User has registed - Admin email</td><td><input type=text size=100 style="width:500px" name='body1' value='<?=$body[1]?>'></td></tr>
		<tr><td>Users Password</td><td><input type=text size=100 style="width:500px" name='body2' value='<?=$body[2]?>'></td></tr>
		<tr><td>User Changed Password</td><td><input type=text size=100 style="width:500px" name='body3' value='<?=$body[3]?>'></td></tr>
		<tr><td>New Registration Email</td><td><textarea cols="95" rows="8" name="body4"><?=$body[4]?></textarea></td></tr>
		<tr><td colspan="2" bgcolor=#AAAAAA style="text-align:center"><b>Onsite Messages</b></td></tr>
		<tr><td>Forgot Login Details</td><td><input type=text size=100 style="width:500px" name='msg1' value='<?=$msg[1]?>'></td></tr>
		<tr><td>Wrong Login Details</td><td><input type=text size=100 style="width:500px" name='msg2' value='<?=$msg[2]?>'></td></tr>
		<tr><td>New Sign Up</td><td><textarea cols="95" rows="8" name="msg3"><?=$msg[3]?></textarea></td></tr>
		<tr><td colspan="2" bgcolor=#AAAAAA style="text-align:center"><b>Error Messages</b></td></tr>
		<tr><td>Incorrect Login</td><td><input type=text size=100 style="width:500px" name='err1' value='<?=$err[1]?>'></td></tr>
		<tr><td>DataBase Error</td><td><input type=text size=100 style="width:500px" name='err2' value='<?=$err[2]?>'></td></tr>
		<tr><td>Required Form Feild Not Entered</td><td><input type=text size=100 style="width:500px" name='err3' value='<?=$err[3]?>'></td></tr>
		<tr><td>Error Adding Site</td><td><input type=text size=100 style="width:500px" name='err4' value='<?=$err[4]?>'></td></tr>
		<tr><td>Invalid Password Setup</td><td><input type=text size=100 style="width:500px" name='err5' value='<?=$err[5]?>'></td></tr>
		<tr><td>Credits Lower Than Transaction</td><td><input type=text size=100 style="width:500px" name='err6' value='<?=$err[6]?>'></td></tr>
		<tr><td>New Signup - Email Is Already Used</td><td><input type=text size=100 style="width:500px" name='err7' value='<?=$err[7]?>'></td></tr>
		<tr><td>Category Fields Not Entered</td><td><input type=text size=100 style="width:500px" name='err8' value='<?=$err[8]?>'></td></tr>
		<tr><td>Editing Site Error</td><td><input type=text size=100 style="width:500px" name='err9' value='<?=$err[9]?>'></td></tr>
		<tr><td>No Sites To View</td><td><input type=text size=100 style="width:500px" name='err10' value='<?=$err[10]?>'></td></tr>
		
		<tr><td colspan=2 align=center><input type=submit name=pri value='Save values'></td></tr>
		</table>
	</td>
</tr>
<?}elseif($page == '2'){ // edit admin messages?>
<tr>
	<td>
		<br><b>Editing Admin messages:</b>
		<table>
		<tr><td colspan="2" bgcolor=#AAAAAA style="text-align:center"><b>Administrators Details</b></td></tr>
		<tr><td>Meta Tag For Admin Panel</td><td><input type=text size=100 style="width:500px" name='title_adm' value='<?=$title_adm?>'></td></tr>
		<tr><td>Email used for administrator</td><td><input type=text size=100 style="width:500px" name='author_email' value='<?=$author_email?>'></td></tr>
		<tr><td>User email - Email sent when site published</td><td><input type=text size=100 style="width:500px" name='subject1' value='<?=$subject[1]?>'></td></tr>
		<tr><td>User email - Emailed Statistics</td><td><input type=text size=100 style="width:500px" name='subject2' value='<?=$subject[2]?>'></td></tr>
		<tr><td>User email - Site was declined by admin</td><td><input type=text size=100 style="width:500px" name='subject3' value='<?=$subject[3]?>'></td></tr>
		<tr><td>User email (body)- Email sent when site published</td><td><input type=text size=100 style="width:500px" name='body1' value='<?=$body[1]?>'></td></tr>
		<tr><td>User email (body) - Overall Stats</td><td><textarea cols="95" rows="8" name="body21"><?=$body[2][1]?></textarea></td></tr>
		<tr><td>User email (body) - Last Line Of all emails sent</td><td><input type=text size=100 style="width:500px" name='body27' value='<?=$body[2][7]?>'></td></tr>
		<tr><td>User email (body)- Site was declined by admin</td><td><textarea cols="95" rows="8" name="body3"><?=$body[3]?></textarea></td></tr>
		<tr><td colspan=2 align=center><input type=submit name=pri value='Save values'></td></tr>
		</table>
	</td>
</tr>

<?}?>
<input type="Hidden" name="page" value="<?=$page?>">
</form>
</table>
<?
include('footer_inc.php');
?>

