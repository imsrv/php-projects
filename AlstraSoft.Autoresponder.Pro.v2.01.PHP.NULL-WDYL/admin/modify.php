<?
/* Nullified by WDYL-WTN */
require("include/everything.php");
		
	
	$db = new DB_Sql;
	mysql_connect( $Host, $User, $Password ) or die ( 'Unable to connect to server.' );
    mysql_select_db( $Database )   or die ( 'Unable to select database.' );
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
	if ($password!=""){
		$ap = ",users_password='".md5($password)."' ";
	}
		if ($password==""){$password = "Password was not changed";}
		mysql_query("update users set  users_name='$name',users_username='$username',users_email='$email',users_accounttype_id='$type'$ap   where users_id='$user'");
		$subject = "Your account was updated";
		$text= "Dear $username\n\n
		Your account was updated\n 
		New Account Info:\n
		Name: $name\n
		E-mail: $email\n
		Username: $username
		Password: $password
		\n\n
		____________________________________
		Administrator
		";
		$headers = "From: donotreply@_donotreply.com\r\n".
                 "Reply-To: donotreply@_donotreply.com\r\n".
                 "X-Mailer: Gen4ik";
		mail($email,$subject,$text,$headers);
		header ("Location: members_list.php");
	}
	
	$template = new Template("templates/members_list");
	$template->set_file("tpl_members_list", "m_zero.tpl");
	
	$r = mysql_query("select * from users where users_id='$user'");
	$q = mysql_fetch_array($r);

	$p = mysql_query("SELECT * FROM accounttypes ORDER BY accounttypes_id");
	$asc = " ";
	while ($s = mysql_fetch_array($p)){
		
		if ($s[accounttypes_id] == $q[users_accounttype_id]){
			$asc .= "<option value=$s[accounttypes_id] selected>$s[accounttypes_description]";
		}else{			$asc.= "<option value=$s[accounttypes_id]>$s[accounttypes_description]";}
	}
	$asc = "<select name=type>".$asc."</select>";
	$dt=  '<tr>
	<td align="left" valign="top" bgColor="#eeeeee">
		<b>Add New Member:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="5" cellSpacing="0" border="0">
		<tr>
			<td width="30%" align="left"><font color="red">*</font> Name: </td>
			<td width="70%" align="left">
			<input type=hidden name=user value='.$user.'>
			<input type="text" name="name" size="30" maxlength="40" value='.$q[users_name].'></td>
		</tr>
		<tr>
			<td align="left"><font color="red">*</font> E-Mail Address </td>
			<td align="left"><input type="text" name="email" size="30" maxlength="40" value='.$q[users_email].'></td>
		</tr>
		<tr>
			<td align="left"><font color="red">*</font> Username: <br><font size="1">(letters and numbers only!)</font></td>
			<td align="left"><input type="text" name="username" size="30" maxlength="40" value='.$q[users_username].'></td>
		</tr>
		<tr>
			<td align="left">Password: <br> <font size=1>(Live empty if you do not have chenge it)</td>
			<td align="left"><input type="text" name="password" size="30" maxlength="40"></td>
		</tr>
		
		<tr>
			<td align="left"><font color="red">*</font> Account Type: </td>
			<td align="left">
				'.
				$asc
				.'
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colSpan="2"><input type="submit" value="Modify Member"></td>
		</tr>
		<tr>
			<td height="20" colSpan="2" align="right" valign="bottom"><font color="red">*</font> denotes a required field</td>
		</tr>
		</table>
	</td>
</tr>';
	$template->set_var("ACCOUNTTYPE_LIST", $dt);

	$template->parse("output", "tpl_members_list");
	$template->p("output");
?>