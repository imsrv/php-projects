<?
//+----------------------------------
//	AnnoucementX Registration Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

if (isset($index)) {

} else {

	header("Location:index.php");

}

class Register {

	function go_switch($step) {
	
	global $functions;
	
		switch ($step) {
		
			case "1":
			
				/* The same bug fix that I've used for the login script */
				
				$name=$_POST['name'];
				
				if (isset($name)) {
				
					$this->do_register_again();
					
				} else {
				
					$this->do_register_start();
					
				}
			
				/* Here it finishes fixing :) */
				
			break;
			
			case "2":
			
				$this->do_register_again();
				
			break;
			
			case "validate":
			
				$this->do_validate_start();
				
			break;
			
			case "first_validate":
				
				$this->do_validate_first();

			break;
			
			default:
			
				if (!headers_sent) {
				
					header("Location:index.php?do=register&step=1");
				
				} else {
				
					$url="Location:index.php?do=register&step=1";
					$functions->do_redirect($url);
				
				}
			
			break;
		
		}
	
	}

	function do_register_start() {
	
	global $title, $functions;
	
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Register ::
		</td>
	</tr>
	<tr>
END;
	
	if ($username!='') {
	
		$functions->do_menu($username,$password);
	
	} else {
	
		$functions->do_menu('','');
	
	}

echo<<<END
		<td align=center class='MAIN'>
		<div align='left' id='navstrip'>
		<a href='index.php?do=' title='Home'>$title</a> > <a href='javascript:window.location()' title='Register'>Register</a>
		</div>
		<h5>To register, fill in the fields below</h5>
		<table align=left width=80% border=0 cellpadding=3>
			<form name='register' action='index.php?do=register&step=2' method='post' onsubmit='ValidateForm()'>
				<tr>
					<td align=center class='FORM'>
					<b>Username:</b><br />
					Please, choose your username here (max 255 characters)
					</td>
					<td align=center class=FORM>
					<input type=text name='name' value='' size='20' maxlength="255">
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<b>Password:</b><br />
					Please, choose your password (max 255 characters)
					</td>
					<td align=center class='FORM'>
					<input type=password name='pass' value='' size='20' maxlength="255">
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<b>E-mail:</b><br />
					Please, enter your <i>valid</i> e-mail
					</td>
					<td align=center class='FORM'>
					<input type=text name='email' value='' size='20' maxlength="255">
					</td>
				</tr>
				<tr>
					<td colspan=2 align=center class='MAIN'>
					<input type=submit name=submit value='Register'>
					<input type=reset name=reset>
					</td>
				</tr>
			</form>
		</table>
		</td>
	</tr>
</table>
END;
	}
	
	function do_register_again() {
	
	global $errors, $functions, $title;
	
		$name=$_POST['name'];
		$pass=$_POST['pass'];
		$email=$_POST['email'];
		
		if (isset($name,$pass,$email)) {
		
			if ($name == '') {
			
				$errors->error_fill_in_all_fields();
				exit;
			
			}
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$query="SELECT * FROM members WHERE Name='$name'";
			$run=mysql_query($query) or die ('AnnouncementX Error(query/check name): ' . mysql_error());
			
				$num=mysql_num_rows($run);
			
			if ($num > 0) {
			
				$errors->error_username_exists();
				exit;
			
			} else {
			
				$insert_query="INSERT INTO members VALUES ('','$name','$pass','$email','','','Member')";
				$check="SELECT `Value` FROM config WHERE `Name`='Validation'";
				
				$get_check=mysql_query($check) or die ('AnnouncementX Error: ' . mysql_error());
				$valid=mysql_fetch_row($get_check);
				
				if ($valid[0] == 'On') {
				
					$insert_query="INSERT INTO members VALUES ('','$name','$pass','$email','','','Validating')";
					
					$address="SELECT * FROM config WHERE Name='Path'";
					$do_address=mysql_query($address) or die ('AnnouncementX Error: ' . mysql_error());
					$path=mysql_result($do_address,0,"Value");
					
					$insert=mysql_query($insert_query) or die ('AnnouncementX Error: ' . mysql_error());
					
					$to=$email;
					$message="Please, validate your registration at ".$title."\nClick the link below to continue\n".$path."/index.php?do=register&step=validate&username=".$name."&password=".$pass."";
					define ('TITLE',$title);
					mail ($to,TITLE.'-Validate Registration',$message,"From: $title\n");
					
					$getuserid=mysql_query("SELECT `id` FROM `members` WHERE `Name`='$name'") or die ("AnnouncementX Error: " . mysql_error());
					$userid=mysql_result($getuserid,0,'id');
				
					$notebookqr=mysql_query("INSERT INTO `notebook` VALUES ('','$userid','It is the place for your personal notes!')") or die ("AnnouncementX Error: " . mysql_error());
					
					$url='index.php?do=register&step=first_validate';
					$functions->do_redirect($url);
				
				} else {
				
				$insert=mysql_query($insert_query) or die ('AnnouncementX Error: ' . mysql_error());
				
				$getuserid=mysql_query("SELECT `id` FROM `members` WHERE `Name`='$name'") or die ("AnnouncementX Error: " . mysql_error());
				$userid=mysql_result($getuserid,0,'id');
				
				$notebookqr=mysql_query("INSERT INTO `notebook` VALUES ('','$userid','It is the place for your personal notes!')") or die ("AnnouncementX Error: " . mysql_error());
			
					$url='index.php?do=login&step=1';
					$functions->do_redirect($url);
				
				}
							
			}
			
		} else {
		
			$errors->error_fill_in_all_fields();

		}
		
	mysql_close($link);
	
	}
	
	function do_validate_first() {

	global $title;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER'>
		:: $title - Register ::
		</td>
	</tr>
	<tr>
		<td align=center class='MAIN'>
		Before you can use your account, please, validate it.<br />
		Check your mailbox, the validation e-mail should be received by you in 10 minutes (usually immediatly).<br /><br />
		<a href='index.php?do=&'.strip_tags(sid) title='Continue'>Click here to continue</a><br /><br />
		</td>
	</tr>
</table>
END;

	}
	
	function do_validate_start() {
	
		global $functions, $username, $password;
			
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$query="UPDATE `members` SET `Group`='Member' WHERE `Name`='$username' AND `Password`='$password'";
		$run=mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());

		$url='index.php?do=&'.strip_tags(sid);
		$functions->do_redirect($url);
		
		mysql_close($link);
	
	}
}
?>