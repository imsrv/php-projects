<?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/11/23
//	Updated: 2005/10/12
//	Description: Handles the Profile's
//	stuff
//+----------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class Profile {

	function go_switch($step) {
	
	global $functions, $errors, $username, $password, $who;

		switch ($step) {
		
		case "view":
		
			$this->do_profile_view($username,$who,$password);
			
		break;
		
		case "edit_finish":
		
			$this->do_profile_edit_doedit();
			
		break;
		
		case "email":
		
			$this->show_email($username,$user,$who);

		break;
		
		case "do_email":
		
			$this->do_email($username,$password);

		break;
		
		default:
		
			if(!headers_sent) {
			header("Location:index.php?do=profile&step=view&who=");
			} else {
			$url='index.php?do=profile&step=view&who=';
			$functions->do_redirect($url);
			}
			
		break;
		
		}

	}
	
	function show_email($username, $user) {
		
		global $errors, $title, $username, $password, $functions, $user, $who;
		
		$who=$user;
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$check_qr="SELECT * FROM config WHERE Name='Emails'";
			$check=mysql_query($check_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			$email_qr=mysql_query("SELECT `Email` FROM members WHERE `Name`='$who'") or die ('AnnouncementX Error: ' . mysql_error());
			$email=mysql_fetch_row($email_qr);
			
			$get=mysql_result($check,0,'Value');
			
				if ($get == 'Off') {
				
					$errors->error_cant_email();
					exit;
					
				} else {

				}
				
				if ($username != '') {
				
				} else {
				
					$errors->error_guests_cant_email();
					exit;
				
				}
				
echo<<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - View Profile - $who ::
			</td>
		</tr>
		<tr>
END;
		if ($username!='' && $password!='') {
	
		$functions->do_menu($username,$password);
		
		} else {
		
		$functions->do_menu('','');
		
		}
echo<<<END
			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=profile&step=view&user=$who'.SID title='Viewing Profile of $who'>Viewing Profile of $who</a></div>
			Please, fill in the fields below or your e-mail will not be sent:
			<br /><br />
			<form name='profile' action='index.php?do=profile&step=do_email' method='post' onsubmit='ValidateForm()'>
			<input type=hidden name='to' value='$email[0]'>
			<input type=hidden name='recepient' value='$user'>
			<input type=hidden name='from' value='$username'>
			<label for='subject'>Subject: </label><input type=text name=subject value='' size='30' class=field><br /><br />
			Message: <br />
			<textarea name='message' class=field rows=14 cols=28></textarea><br /><br />
			<input type=submit name=submit value='Send E-mail to $user' class=submit>   <input type=reset name=reset>
			</form>
			</td>
		</tr>
	</table>
END;
	
	}
		
	function do_email($username,$password) {
		
		global $functions, $errors, $username, $password, $title;
		
		$to=$_POST['to'];
		$from=$_POST['from'];
		$recepient=$_POST['recepient'];
		$subject=$_POST['subject'];
		$message=$_POST['message'];
		
		/*$message=nl2br($message);*/
		/*$message=wordwrap($message,70,'\n');*/
	
		if (isset($to,$from,$subject,$message)) {
	
			/*$new_message="Dear $recepient, \n\A e-mail had been sent to you from $title by $from\n\Subject: $subject\n\$message";*/
			$new_message="Dear $recepient, \nAn e-mail has been sent to you from $title by $from\nSubject: $subject\n\n".$message;
			/*$new_message=wordwrap($new_message,70,'<br />\n');*/
	
			if (mail($to,$subject,$new_message,"From: $title\n")) {
	
				$url='javascript:history.go(-2)';
				$functions->do_redirect($url);
	
			}
	
		} else {
	
			$errors->error_fill_in_all_fields();
			exit;
	
		}
	
	}

	function do_profile_view($username,$who,$password) {
	
		global $who,$username,$password;
	
		switch ($who) {
		
		case "":
		
			$this->do_profile_list_profiles();
			
		break;
		
		case "$username":
		
			$this->do_profile_edit($who,$username,$password);
			
		break;
		
		default:
		
			$this->do_profile_view_profile($who);
			
		break;
		
		}
		
	}

	function do_profile_list_profiles() {
	
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql='SELECT * FROM `members` ORDER BY Name ASC LIMIT 0, 1000';
			$profiles=mysql_query($sql) or die ("AnnouncementX Error: " . mysql_error());
			
			$num_of_profs=mysql_num_rows($profiles);
			
				if ($num_of_profs===0) {
					
					echo "There are no users, strange...";
				
				}
										
			echo "<table width=80% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=2>
			<tr><td width=5% align=center class=MAIN><b>#</b></td><td width=35% align=center class=MAIN><b>Username:</b></td><td width=30% align=center class=MAIN><b>E-Mail:</b></td>
			<td align=center width=15% class=MAIN><b>Location:</b></td><td align=center class=MAIN width=15%><b>Occupation:</b></td></tr>";
				
				$a=1;
				$i=0;
				
				while ($i<$num_of_profs) {
				
					$name=mysql_result($profiles,$i,'Name');
					$email=mysql_result($profiles,$i,'Email');
					$location=mysql_result($profiles,$i,'Location');
					$occupation=mysql_result($profiles,$i,'Occupation');
					
					if ($i/2===int) {
					
						echo "<tr><td width=5% align=center class=MAIN_2>$a</td><td width=35% align=center class=MAIN_2><a href='index.php?do=profile&step=view&who=$name'>$name</a></td><td width=30% align=center class=MAIN_2>
						<a href='./index.php?do=profile&step=email&who=$name'>Send an e-mail to $name</a></td>
						<td align=center width=15% class=MAIN_2>$location</td><td align=center class=MAIN_2 width=15%>$occupation</td></tr>";

					
					} else {
					
						echo "<tr><td width=5% align=center class=MAIN>$a</td><td width=35% align=center class=MAIN><a href='index.php?do=profile&step=view&who=$name'>$name</a></td><td width=30% align=center class=MAIN>
						<a href='./index.php?do=profile&step=email&who=$name'>Send an e-mail to $name</a></td>
						<td align=center width=15% class=MAIN>$location</td><td align=center class=MAIN width=15%>$occupation</td></tr>";
					
					}
					
					$a++;
					$i++;
	
				}
				
			echo "<tr><td align=center colspan=5 class=MAIN><a href='javascript:history.back()' title='Back'>< Back</a></td></tr></table>";
			
	}
	
	function do_profile_edit($who,$username,$password) {
	
		global $errors, $functions, $title, $username, $password, $who;
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$select_qr="SELECT * FROM members WHERE Name='$who'";
			$select=mysql_query($select_qr) or die ("AnnouncementX Error: " . mysql_error());
			
			$id=mysql_result($select,0,'id');
			$email=mysql_result($select,0,'Email');
			$occupation=mysql_result($select,0,'Occupation');
			$location=mysql_result($select,0,'Location');
			
			$owner=$who;
			
			$notebookqr=mysql_query("SELECT `Message` FROM `notebook` WHERE `mid`='$id'") or die ("AnnouncementX Error: " . mysql_error());
			$notebook=mysql_result($notebookqr,0,'Message');

			
			$num=mysql_num_rows($select);
			
		if ($num>1) {
		
		echo "Error, while trying to view the profile $who";
		
		} else {
	
echo<<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - View Profile - $who ::
			</td>
		</tr>
		<tr>
END;
		$functions->do_menu($username,$password);
echo<<<END
			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=profile&step=view&user=$who'.SID title='Viewing Profile of $who'>Viewing Profile of $who</a></div><br /><br />
			You are view the following profile: <b>$who</b><br />
			And you can edit it because you are the owner of this profile.<br />
			<table width=90% align=center border=0 cellpadding=3>
				<form name='profile' action='index.php?do=profile&step=edit_finish' method=post onsubmit='ValidateForm()'>
				<input type=hidden name='owner' value='$owner'>
					<tr>
						<td align=center class=FORM>Username: 
						</td>
						<td align=center class=FORM>$who
						</td>
					</tr>
					<tr>
						<td align=center class=FORM>Current password: 
						</td>
						<td align=center class=FORM>
						$password
						</td>
					</tr>
					<tr>
						<td align=center class=FORM>
						New password:<br />
						(leave empty if you do not want to change it)
						</td>
						<td align=center>
						<input type=password name='password' value='' onfocus="this.value=''" size='30'>
						</td>
					</tr>
					<tr>
						<td align=center class=FORM>
						Your Location:
						</td>
						<td align=center>
						<input type=text name='location' value="$location" onfocus="this.value=''" size='30'>
						</td>
					</tr>
					<tr>
						<td align=center class=FORM>Occupation:
						</td>
						<td align=center>
						<input type=text name='occupation' value='$occupation' onfocus="this.value=''" size='30'>
						</td>
					</tr>
					<tr>
						<td align=center class=FORM>E-Mail:
						</td>
						<td align=center>
						<input type=text name='email' value='$email' onfocus="this.value=''" size='30'>
						</td>
					</tr>
					<tr>
						<td align=center colspan=2 class=FORM>
						<input type=submit name=submit value='Edit Profile ($who)' class=submit>  
						<input type=reset name=reset>
					</tr>
				</form>
				</table><br /><br />
				<hr align=center width=95% color='#efefef'><br /><br />
				<form name='notebook' action='./index.php?do=profile&step=edit_finish&extra=1' method='post'>
				<input type=hidden name=id value='$id'>
				<input type=hidden name='owner' value='$owner'>
				<b>Personal notebook:</b><br /><br />
				<textarea name='notebox' rows='7' cols='58' class=textarea>$notebook</textarea><br /><br />
END;
			
				$browser=$_SERVER['HTTP_USER_AGENT'];
				
				if  (strstr($browser,'MSIE')) {
				
					echo "<input type=submit name=submit value='Update Notebook' class=submit>";
				
				} else {
				
					echo "<input type=submit name=submit value='Update Notebook' class=submit onClick=\"this.value='Updating...';this.disabled = true;document.notebook.submit()\">";
				
				}

echo <<<END
				</form>
			</td>
		</tr>
	</table>
END;
	
		mysql_close($link);
	
		}
		
	}

	function do_profile_edit_doedit() {
	
	global $username, $password, $functions, $errors, $extra;
	
		if (!isset($extra)) {
		
			$who=$_POST['owner'];
			$password_changed=$_POST['password'];
			$location=$_POST['location'];
			$occupation=$_POST['occupation'];
			$email=$_POST['email'];
			
			if (!isset($who)) {
			
				echo "$who is not defined!";
			
			}
			
			if (isset($email)) {
			
				$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
				mysql_select_db(DATA,$link);
				
				if ($password_changed!='' && $password_changed!=$password) {
				
					$update_qr="UPDATE members SET Password='$password_changed', Location='$location', Occupation='$occupation', Email='$email' WHERE Name='$who'";
					$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());
				
					$to='$email';
					
					$message='$who,\n\ Your password at $title had been changed to $password_changed.\n\ If you have any questions, please, contact the administrator.\n\$title';
	
					mail($to,'Password changed',$message,"From: $title\n");
	
	
					$_SESSION['username'] = '';
					$_SESSION['password'] = '';
	
					$url='index.php?do=login&step=1';
					$functions->do_redirect($url);
	
				} else {
				
					$update_qr="UPDATE members SET Password='$password', Location='$location', Occupation='$occupation', Email='$email' WHERE Name='$who'";
					$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
					$url='index.php?do=profile&step=view&who='.$who;
					$functions->do_redirect($url);
	
				}
	
			} else {
	
				echo "<center>Please, fill in the following fields: <b>password, e-mail</b><br /><input type=button name=back value='Return to previous page' class=submit onclick='javascript:history.back()'></center>";
	
			}
			
			mysql_close($link);
			
		} else {
		
			$mid=$_POST['id'];
			$who=$_POST['owner'];
			$message=$_POST['notebox'];
			
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			if ($message == '') {
			
				$message='Notebook is currently empty';
			
			}
			
			$sql=mysql_query("UPDATE `notebook` SET `Message`='$message' WHERE `mid`='$mid'") or die ("AnnouncementX Error: " . mysql_error());
			
			$url='./index.php?do=profile&step=view&who='.$who;
			$functions->do_redirect($url);
			
			mysql_close($link);
		
		}

	}
	
	function do_profile_view_profile($who) {
	
	global $username, $password, $who, $functions, $errors, $title;
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$select_qr="SELECT * FROM members WHERE Name='$who'";
		$select=mysql_query($select_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$num=mysql_num_rows($select);
		
		$email=mysql_result($select,0,'Email');
		$occupation=mysql_result($select,0,'Occupation');
		$location=mysql_result($select,0,'Location');
	
echo<<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - View Profile - $who ::
			</td>
		</tr>
		<tr>
END;

		$functions->do_menu($username,$password);
		
echo <<<END
			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=profile&step=view&user=$who'.SID title='Viewing Profile of $who'>Viewing Profile of $who</a></div><br /><br />
			You are view the following profile: <b>$who</b><br />
			<table width=90% align=center border=0 cellpadding=3>
				<tr>
					<td align=center class=FORM>Username: 
					</td>
					<td align=center class=FORM>$who
					</td>
				</tr>
				<tr>
					<td align=center class=FORM>
					Location:
					</td>
					<td align=center class=FORM>
					$location
					</td>
				</tr>
				<tr>
					<td align=center class=FORM>Occupation:
					</td>
					<td align=center class=FORM>
					$occupation
					</td>
				</tr>
				<tr>
					<td align=center class=FORM>E-Mail:
					</td>
					<td align=center class=FORM>
					$email (<a href='index.php?do=profile&step=email&user=$who&'.strip_tags(sid) title='Send a e-mail to $who'>Send an e-mail to $who</a>)
					</td>
				</tr>
				<tr>
					<td align=center colspan=2 class=MAIN>
					<input type=button name='back' value='Return to previous page' class=submit onclick='javascript:history.back()'>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
END;

	mysql_close($link);
		
	}
	
}
?>