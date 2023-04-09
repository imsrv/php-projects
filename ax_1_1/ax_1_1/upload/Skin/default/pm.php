<?
//+----------------------------------
//	AnnoucementX Private Messages
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/26
//	Updated: 2005/10/12
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class pms {

	function go_switch($step) {
	
	global $title, $username, $password, $functions, $errors, $what, $used_skin;
	
		switch ($step) {
		
		case "read":
		
			$this->do_pm_read($username,$password);
			
		break;
		
		case "view":
		
			$this->do_pm_show($username,$password,$what);
			
		break;
		
		case "create":

			$this->do_pm_create($username,$password);

		break; 
		
		case "reply":

			$this->do_pm_reply($username,$password);

		break;
		
		case "send":
	
			$this->do_pm_send($username,$password);
	
		break;
		
		case "find":
		
			$this->do_find();
		
		break;
		
		case "dofind":
	
			$this->do_pm_dofind();
	
		break;
		
		case "mark_as_read":
	
			$this->mark_as_read($username,$password);
	
		break;
		
		case "delete":
	
			$this->do_pm_delete($username,$password);
	
		break;
		
		case "delete_all":
		
			$this->do_pm_deleteall($username,$password);
			
		break;
		
		case "delete_all_ok":
		
			$this->do_pm_deleteallok($username,$password);
			
		break;
		
		default:
		
			$this->do_pm_read($username,$password);
			
		break;
		
		}
	
	}

	function do_pm_read($username,$password) {
	
	global $title, $username, $password, $functions, $errors, $used_skin, $title;
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$query="SELECT * FROM pms WHERE `To`='$username' ORDER BY `Read` ASC LIMIT 0, 200";
		$run=mysql_query($query) or die ('AnnoucementX Error: ' . mysql_error());
		
		$num=mysql_num_rows($run);

		$get_num_qr="SELECT * FROM config WHERE Name='PM_number'";
		$get_num_run=mysql_query($get_num_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
		$get_num=mysql_result($get_num_run,0,'Value');
	
echo <<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - $username - Inbox ::
			</td>
		</tr>
		<tr>
END;

		$functions->do_menu($username,$password);
	
echo <<<END
			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=pm&step=read'.SID title='Reading Personal Messages of $username'>Reading Personal Messages of $username</a></div>
			<br /><br />
			<div align=right><b>You have $num of $get_num allowed messages</b></div>
			<br /><br />
			:: <a href='index.php?do=pm&step=create'.SID title='Compose new message'>Compose New Message</a> :: <a href='index.php?do=pm&step=delete_all'.SID title='Delete All Messages'>Delete All Messages</a> ::
			<br /><br />
END;
						
			if ($num>=$get_num) {
			
			echo "<font color=red><b>You have reached the max number of stored PMs, please, remove some of them or you will not be able to receive any more PMs untill you free your Inbox</b></font>";
			
			}

		switch ($num) {
		
		case "0":
		
			echo "<b>There are no messages</b>";
			
		break;
		
		default:
		
echo <<<END
			<table align=center width=100% border=0 cellpadding=3 class=PM>
			<form name='pm' action='index.php?do=pm&step=delete' method='post'>
			<tr>
				<td align=center class=FORM width=10%>
				(Un)Read:
				</td>
				<td align=center class=MAIN width=35%>
				From: 
				</td>
				<td align=center class=MAIN width=40%>
				Subject:
				</td>
				<td align=center class=FORM width=15%>
				Delete:
				</td>
			</tr>
END;
		
			$i=0;
		
			while ($i<$num) {
			
			$id=mysql_result($run,$i,'id');
			$from=mysql_result($run,$i,'From');
			$subject=mysql_result($run,$i,'Title');
			$read=mysql_result($run,$i,'Read');
			
				$msg_img='./style_images'.$used_skin.'unread.jpg';
				
				if ($read == 'Yes') {
				
				$msg_img='./style_images'.$used_skin.'read.jpg';
				
				}
			
				
				echo "<tr><td align=center class=FORM width=10%><img src='".$msg_img."' width=22 height=20 border=0></td>
				<td align=center class=MAIN width=35%>From: <a href='index.php?do=pm&step=view&what=$id'>$from</a></td><td align=center class=MAIN width=40%>$subject</td>
				<td align=center class=FORM width=15%><input type=checkbox name='messages[]' value='$id'>
				</td></tr>";
							
			$i++;
			
			}
			
			echo "<tr><td class=main align=right colspan=4>
			<input type=submit name=submit value='Delete Checked' class=submit onClick=\"this.value='Deleting...';this.disabled=true\">
			</td></tr>";
			
		break;
		
		}
		
echo <<<END
			</form>
			</table>
			</td>
		</tr>
	</table>
END;
	
		mysql_close($link);
		
	}
	
	function mark_as_read($username,$password) {
	
	global $functions, $error, $username, $password, $title;
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
	
		$sel_query="SELECT * FROM `pms` WHERE `To`='$username'";
		$sel=mysql_query($sel_query) or die ('AnnouncementX Error: ' . mysql_error());
	
		$num=mysql_num_rows($sel);
		
	
		$mark_query="UPDATE pms SET `Read`='Yes' WHERE `To`='$username'";
		$mark=mysql_query($mark_query) or die ('AnnoucementX Error: ' . mysql_error());
		
			$url='index.php?do=pm&step=read&'.strip_tags(sid);
			$functions->do_redirect($url);
			
		mysql_close($link);
		
	}
	
	function do_pm_delete($username,$password) {
	
	global $username, $password, $functions, $errors, $title;
	
	$messages=$_POST['messages'];
	
	$count=count($messages);
	
		if (isset($messages)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			foreach ($messages as $q) {
			
			$del_query="DELETE FROM pms WHERE id='$q'";
			mysql_query($del_query) or die ('AnnouncementX Error: ' . mysql_error());
			
			}
			
				echo "<center>You have deleted <em>$count</em> messages</center>";
			
				$url='index.php?do=pm&step=read'.strip_tags(sid);
				$functions->do_redirect($url);
				
		} else {
		
			echo "It is not set what to delete";
		
		}
	
	mysql_close($link);
	
	}
	
	function do_pm_show($username,$password,$what) {

	global $username, $password, $title, $functions, $errors;

		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$select_qr="SELECT * FROM pms WHERE `To`='$username'and `id`='$what'";
		$select=mysql_query($select_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$id=mysql_result($select,0,'id');
		$from=mysql_result($select,0,'From');
		$message=mysql_result($select,0,'Message');
		$subject=mysql_result($select,0,'Title');
				
		$num=mysql_num_rows($select);
		
		$read_qr=mysql_query("SELECT `Read` FROM pms WHERE `id`='$id'") or die ('AnnouncementX Error: ' . mysql_error());
		$read=mysql_fetch_row($read_qr);
		
		$b_qr=mysql_query("SELECT Value FROM config WHERE `Name`='BadWords'") or die ("AnnouncementX Error: " . mysql_error());
		$b_res=mysql_fetch_row($b_qr);
		
		if ($b_res[0] == 'On') {
		
			$get_badword_qr="SELECT * FROM badwords";
			$get_badword=mysql_query($get_badword_qr,$link) or die ('AnnouncementX Error: ' . mysql_error());
							
			$badwords_num=mysql_num_rows($get_badword);
							
			for ($b=0;$b<$badwords_num;$b++) {
							
				$badword=mysql_result($get_badword,$b,'Word');
				$message=str_replace($badword,"+-censored-+",$message);
						
			}
		
		}
		
		include ('./sources/bbcode.php');
				
		if ($read[0] == 'No') {
		
			$update_status=mysql_query("UPDATE `pms` SET `Read`='Yes' WHERE id='$id'") or die ('AnnouncementX Error: ' . mysql_error());
		
		} else {
		
		}
		
		if ($num>1) {
		
		$errors->error_reading_pm();
		exit;
		
		}
		
		echo "
		<script language='JavaScript'>
			<!--
				
					function ValidateDelete() {
					
						if (confirm('Are you sure you want to delete this message?')) {
						
							document.del_msg.submit.disabled = true;
							return true;
						
						} else {
						
							alert ('Deletion has been aborted by user!');
						
						}
					
					}
				
			-->
		</script>";

echo <<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - $username - Inbox - Read Message ::
			</td>
		</tr>
		<tr>
END;
	
		$functions->do_menu($username,$password);
		
echo <<<END
			<td align=left class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=pm&step=read'.SID title='Reading Personal Messages of $username'>Reading Personal Messages of $username</a></div>
			<br /><br />
			
			<b>From:</b> $from<br />
			<b>Title:</b> $subject<br />
			<b>Message:</b> <br />
			$message<br />
			
			
			<div align='right'>
			
				
				<form name='pm' action='index.php?do=pm&step=reply' method='post' onsubmit='ValidateForm()'>
				<input type=hidden name='new_to' value='$from'>
				<input type=hidden name='new_from' value='$username'>
				<input type=hidden name='old_message' value='$message'>
				<input type=hidden name='old_title' value='$subject'>
				<input type=submit name=submit value='Reply' class=submit>
				</form>
			
			</div>
			
			</td>
		</tr>
	</table>
END;

	}
	
	function do_pm_reply($username,$password) {

	global $username, $password, $title, $functions, $errors;

		$new_to=$_POST['new_to'];
		$new_from=$_POST['new_from'];
		$subject=$_POST['old_title'];
		$message=$_POST['old_message'];
		
		$message=str_replace('<br />','',$message);
		$message=str_replace('<i>Original message:</i>','',$message);
		$subject=str_replace('Re:','',$subject);
	
echo <<<EOF
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - $username - Inbox - Reply ::
			</td>
		</tr>
		<tr>
EOF;

	$functions->do_menu($username,$password);
	
echo <<<END
			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=pm&step=read'.SID title='Reading Personal Messages of $username'>Reading Personal Messages of $username</a></div>
			<br /><br />
			
END;
			$functions->BBCode();		
echo <<<END

			<table width=100% align=center border=0 cellpadding=3>
			<form name='replies' action='index.php?do=pm&step=send' method='post' onsubmit='ValidateForm()'>
			<input type=hidden name='from' value=$new_from>
				<tr>
					<td align=center class='FORM'>
					<label for='to'>To:</label>
					<input maxlength='255' type=text name='to' value='$new_to' size='30'>				
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<label for='subject'>Subject</label>
					<input type=text name='subject' value='Re: $subject' size='30'>
					</td>
				</tr>
				<tr>
					<td align=center class=FORM>
					Message:<br />
					<textarea name='message' rows='10' cols='58' class=textarea><i>Original Message:</i> $message</textarea> 
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<input type=submit name=submit value='Reply' class=submit><input type=reset name=reset value='Reset Form' class=submit>
					</td>
				</tr>
			</form>
			</table>
			</td>
		</tr>
	</table>

END;

	}
	
	function do_pm_create($username,$password) {
	
	global $username, $password, $title, $functions, $errors;

	$functions->find_username_java();
	
echo <<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - $username - Inbox - Create a PM ::
			</td>
		</tr>
		<tr>
END;

	$functions->do_menu($username,$password);
	
echo <<<END

			<td align=center class='MAIN'>
			<div id='navstrip' align='left'><a href='index.php?do=&'.SID title='Home'>$title</a> > <a href='index.php?do=pm&step=read'.SID title='Reading Personal Messages of $username'>Reading Personal Messages of $username</a></div>
			<br /><br />
END;
			$functions->BBCode();
echo <<<END
		
			<table width=100% align=center border=0 cellpadding=3>
			<form name='replies' action='index.php?do=pm&step=send' method='post' onsubmit='ValidateForm()'>
			<input type=hidden name='from' value=$username>
				<tr>
					<td align=center class='FORM'>
					<label for='to'>To:</label>
					<input maxlength='255' type=text name='to' value='' size='30'><br />
					<a href='#' title='Find Username' onClick="window.open('./index.php?do=pm&step=find','Find A Username','width=400,height=250,resizable=yes,scrollbars=yes,statusbar=no,menubar=no')">Find Username</a>
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<label for='subject'>Subject</label>
					<input type=text name='subject' value='' size='30'>
					</td>
				</tr>
				<tr>
					<td align=center class=FORM>
					Message:<br />
					<textarea name='message' rows='10' cols='58' class=textarea></textarea> 
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<input type=submit name=submit value='Compose Message' class=submit><input type=reset name=reset value='Reset Form' class=submit>
					</td>
				</tr>
			</form>
			</table>
			</td>
		</tr>
	</table>

END;
	
	}
	
	function do_pm_send($username,$password) {

	global $username, $password, $title, $functions, $errors;
	
	$to=$_POST['to'];
	$from=$_POST['from'];
	$title=$_POST['subject'];
	$message=$_POST['message'];
	
	$message=nl2br($message);
	
	/*echo "Debugger:<br /><b>To:</b> $to<br /><b>From:</b> $from<br /><b>Title:</b> $title<br /><b>Message:</b> $message";*/
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$check_qr="SELECT * FROM pms WHERE `To`='$to'";
		$check_run=mysql_query($check_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$check=mysql_num_rows($check_run);
		
		$get_num_qr="SELECT * FROM config WHERE Name='PM_number'";
		$get_num_run=mysql_query($get_num_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$get_num=mysql_result($get_num_run,0,'Value');
		
		if ($check>=$get_num) {
		
		$errors->error_too_many_messages();
		exit;
		
		}
		
		if (isset($to,$from,$title,$message)) {
		
		$send_qr="INSERT INTO pms VALUES ('','$to','$from','$title','$message','No')";
		$send=mysql_query($send_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$url='index.php?do=pm&step=read&'.strip_tags(sid);
		$functions->do_redirect($url);
		
		} else {
		
		$errors->error_sending_message();
		
		}
		
		mysql_close($link);
			
	}
	
	function do_pm_deleteall($username,$password) {
	
	global $title, $username, $password, $functions, $errors;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$all_qr=mysql_query("SELECT * FROM `pms` WHERE `To`='$username'") or die ('AnnouncementX Error: ' . mysql_error());
	$all=mysql_num_rows($all_qr);
	
echo<<<END

	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER' colspan=2>
			:: $title - $username - Inbox - Create a PM ::
			</td>
		</tr>
		<tr>
END;

	$functions->do_menu($username,$password);
	
echo <<<END

			<td align=center class='MAIN'>
			<table width=100% align=center border=0 cellpadding=3>
			<form name='pm' action='index.php?do=pm&step=delete_all_ok&'.strip_tags(sid) method='post' onsubmit='ValidateForm()'>
			<b>Are you sure you want to delete $all message(s)?</b><br /><br />
			<input type=submit name='submit' value='Yes' class=submit>
			</form>
			<form name='back' action='index.php?do=pm&step=read&'.strip_tags(sid)>
			<input type=submit name=submit value='No' class=submit>
			</form>
			</td>
		</tr>
	</table>

END;

	mysql_close($link);
	
	}
	
	function do_pm_deleteallok($username,$password) {
	
	global $title, $username, $password, $functions, $errors;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$del_qr=mysql_query("DELETE FROM `pms` WHERE `To`='$username'") or die ('AnnouncementX Error: ' . mysql_error());
	
	$url='index.php?do=pm&step=read'.strip_tags(sid);
	$functions->do_redirect($url);
	
	mysql_close($link);
	
	}
	
	function do_find() {
	
	global $title;
	
echo <<<EOF
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER'>
			:: $title - Find a Username ::
			</td>
		</tr>
		<tr>
			<td align=center class='MAIN'>
			To find a username, please, a part of the name below:<br />
			<form name='pm' action='index.php?do=pm&step=dofind' method='post' onsubmit='ValidateForm()'>
			<label for='find'>A part of username: </label><input type=text name='who' value='Username' onfocus="this.value=''" size='20'>
			<br /><input type=submit name='submit' value='Search' class=submit>
			</form>
			</td>
		</tr>
	</table>
EOF;
	
	}
	
	function do_pm_dofind() {

	global $title, $who, $errors, $functions;

	$who=$_POST['who'];

		$link=mysql_connect(HOST,USER,PASS) or die ('AnnoucementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);

		$query="SELECT Name FROM members WHERE `Name` LIKE '%$who' OR `Name` LIKE '$who%'";
		$run=mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());

		$num=mysql_num_rows($run);
	
echo <<<END
	<table class=maintable align=center cellpadding='3'>
		<tr>
			<td align='center' class='HEADER'>
			:: $title - Find a Username - Results ::
			</td>
		</tr>
		<tr>
			<td align=center class='MAIN'>
			<strong>The following username(s) was(were) found by your request:</strong>
			</td>
		</tr>
END;
			if ($num==0) {
				
				$errors->error_no_username_found();
				exit;
			
			}
			
			$i=0;
			
			while ($i<$num) {
			
				$name=mysql_result($run,$i,'Name');
				$this->do_pm_dofind_and_show($name);
				
				$i++;
			
			}

echo <<<END
		<tr>
			<td align=center class=MAIN>
			<a href=javascript:self.close() title='Close Window'>Close Window</a>
			</td>
		</tr>
	</table>
END;

	mysql_close($link);

	}
	
	function do_pm_dofind_and_show($name) {
	
echo <<<END
	<tr>
		<td align=center class=FORM>
		$name	
		</td>
	</tr>
END;

	}
	
}
?>