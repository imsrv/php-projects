<?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/11/27
//	Updated: 2005/10/12
//	Description: Handles errors and 
//	stuff like that
//+----------------------------------


class ERRFUNC {

function error_no_username_or_password() {

global $functions, $username, $password, $title;

echo "
	<script language='JavaScript'>
	<!--
	
		function Blah() {
		
			if (document.login.remember.checked = false) {
			
				document.login.remember.checked;
				return true;
			
			} else {
			
				document.login.remember.checked = false;
				return false;
			
			}
			
		}
	
	-->
	</script>
	";

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - LogIn Error ::
		</td>
	</tr>
	<tr>
END;

	$functions->do_menu($username,$password);
	
echo <<<END
		<td align=center class='MAIN'>
		<b>Wrong username/password, please re-login:<br />
		<br />
			<a href='./index.php?do=login&step=1&' title='Log In'>Login</a><br /><br />
			<a href='./index.php?do=register&step=1' title='Register'>Register</a><br /><br />
		</td>
	</tr>
</table>
END;
}
function error_invalid_username_password() {

global $functions, $username, $password, $title;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER' colspan=2>
		:: $title - LogIn Error ::
		</td>
	</tr>
	<tr>
END;
	$functions->do_menu($username,$password);
echo <<<END
		<td align=center class='MAIN'>
		<b>You have entered the password that does not match the username.<br />Please, check it.</b>
		<br /><br />
			<table align=center width=100% border=0 cellpadding=3>
			<form name='login' action='index.php?do=login&step=2' method='post' onsubmit='ValidateForm()'>
			<tr>
				<td align=left>
				<input type=text name='user' value='' size='30' class='field'>
				</td>
				<td align=left class='FORM'>
				Username
				</td>
				<td align=center>
				<input type='checkbox' name='remember' value='true' checked><label for='checkbox'>Remember Me</label>
				</td>
			</tr>
			<tr>
				<td align=left>
				<input type=password name='pass' value='' size='30' class='field'>
				</td>
				<td colspan=2 align=left class='FORM'>
				Password
				</td>
			</tr>
			<tr>
				<td align=center class=FORM colspan=3>
				<input type=submit name=submit value='Log In'>
				</td>
			</tr>
			</form>
			</table>
		</td>
	</tr>
</table>
END;
}
function error_username_exists() {

global $username, $password, $title, $functions;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Registration Error ::
		</td>
	</tr>
	<tr>
END;
	$functions->do_menu($username,$password);
echo <<<END
		<td align=center class='MAIN'>
		<b>Sorry, username you have chosen already exists.<br />Please, choose another one</b><br /><br />
		<table align=left width=100% border=0 cellpadding=3>
			<form name='register' action='index.php?do=register&step=2' method='post' onsubmit='ValidateForm()'>
				<tr>
					<td align=center class='FORM'>
					<b>Username:</b><br />
					Please, choose your username here (max 255 characters)
					</td>
					<td align=center class=FORM>
					<input type=text name='name' value='' size='30' maxlength="255">
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<b>Password:</b><br />
					Please, choose your password (max 255 characters)
					</td>
					<td align=center class='FORM'>
					<input type=password name='pass' value='' size='30' maxlength="255">
					</td>
				</tr>
				<tr>
					<td align=center class='FORM'>
					<b>E-mail:</b><br />
					Please, enter your <i>valid</i> e-mail
					</td>
					<td align=center class='FORM'>
					<input type=text name='email' value='' size='30' maxlength="255">
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
function error_guests_cant_email() {

global $functions, $username, $password, $title;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, but guests cannot send e-mails.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}
function error_cant_email() {

global $username, $password, $title, $functions;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, but this function was disabled by an admin.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}
function error_fill_in_all_fields() {

global $username, $password, $functions, $title;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Please, fill in all the fields to continue</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}
function error_reading_pm() {

global $username, $password, $title, $functions;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, cannot read the private message.<br />Please, try again from the previous menu.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}
function error_sending_message() {

global $username, $password, $title, $functions;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, cannot send this private message.<br />Please, try again from the previous menu.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}
function error_no_username_found() {

global $username, $password, $title, $functions;

echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, cannot send the message to this username, it is not in our database.<br />Please, try again from the previous menu.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>
END;
}

function error_too_any_messages() {
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align=center class='HEADER' colspan=2>
		:: $title - Error ::
		</td>
	</tr>
	<tr>
		<td align=center class=MAIN>
		<b>Sorry, cannot send the message to this username, his/her inbox is full.<br />Please, try again later.</b><br /><br />
		<input type=button  name=back value='Return To Previous Page' class=submit onclick='javascript:history.back()'><br />
		</td>
	</tr>
</table>

END;
}

}
?>