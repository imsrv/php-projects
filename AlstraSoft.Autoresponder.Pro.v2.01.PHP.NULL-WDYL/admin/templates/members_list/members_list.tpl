<html>
<head>
<title>Administrative Area :: Members List</title>
<link rel="stylesheet" type="text/css" href="../slim.css">
</head>
<body>

<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td valign="middle" align="center" height="40">
		<h3>Members List</h3>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa">

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#eeeeee" colSpan="2">
		<a href="main.php">Menu</a> |
		<a href="logout.php">Logout</a> 
	</td>
</tr>

<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#eeeeee">
	</td>
	<td align="center" valign="top" bgColor="white">
		Number of members:
		<b>{MEMBERS_NUMBER}</b>
		<form name="form_members_hide" action="members_list.php?show=0" method="post">
			<input type="submit" value=" Show only members (-) ">
		</form>
		<form name="form_members_show" action="members_list.php?show=1" method="post">
			<input type="submit" value=" Show their campaings too (+) ">
		</form>
	</td>
</tr>
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#eeeeee"><b>Search member
	</td>
	<td align="center" valign="top" bgColor="white">
	<form action=members_list.php method=post>
	<table width="100%" cellPadding="5" cellSpacing="0" border="0">
		<tr>
			<td width="30%" align="left"><font color="red">*</font> Username or E-mail: </td>
			<td width="70%" align="left"><input type=text name=user></td>
		</tr>
			<tr>
			<td width="30%" align="left"> </td>
			<td width="70%" align="left"><input type=submit value='Search User'></td>
		</tr>
	
</table>
	</form>	
	</td>
</tr>

<form name="form_members_list" action="do_on_members_list.php" method="post" onSubmit="return Confirm();">
<tr>
	<td align="left" valign="top" width="25%" bgColor="#eeeeee">
		<b>Members List:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="0" cellSpacing="1" border="0">
		<tr height="20">
			<td width="6%" align="center" bgColor="#eeeeee"><input type="checkbox" name="check_all" class="noborder" onclick="CheckAll();"></td>
			<td width="23%" align="center" bgColor="#eeeeee"><b>Username</b></td>
			<td width="22%" align="center" bgColor="#eeeeee"><b>Name</b></td>
			<td width="26%" align="center" bgColor="#eeeeee"><b>E-mail</b></td>
			<td width="17%" align="center" bgColor="#eeeeee"><b>Type</b></td>
			<td width="5%" align="center" bgColor="#eeeeee"><b>$</b></td>
		</tr>
		{MEMBERS_LIST}
		{MEMBERS_MENU}
		</table>
	</td>
</tr>
</form>

<form name="form_add_member" action="do_add_member.php" method="post" onSubmit="return Validate();">
<tr>
	<td align="left" valign="top" bgColor="#eeeeee">
		<b>Add New Member:
	</td>
	<td align="left" valign="top" bgColor="white">
		<table width="100%" cellPadding="5" cellSpacing="0" border="0">
		<tr>
			<td width="30%" align="left"><font color="red">*</font> Name: </td>
			<td width="70%" align="left"><input type="text" name="name" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td align="left"><font color="red">*</font> E-Mail Address </td>
			<td align="left"><input type="text" name="email" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td align="left"><font color="red">*</font> Username: <br><font size="1">(letters and numbers only!)</font></td>
			<td align="left"><input type="text" name="username" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td align="left">Password: </td>
			<td align="left"><input type="password" name="password" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td align="left">Retype Password: </td>
			<td align="left"><input type="password" name="password_again" size="30" maxlength="40"></td>
		</tr>
		<tr>
			<td align="left"><font color="red">*</font> Account Type: </td>
			<td align="left">
				<select name="account_type">
				{ACCOUNTTYPE_LIST}
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colSpan="2"><input type="submit" value="Add Member"></td>
		</tr>
		<tr>
			<td height="20" colSpan="2" align="right" valign="bottom"><font color="red">*</font> denotes a required field</td>
		</tr>
		</table>
	</td>
</tr>
</form>

<tr>
	<td align="left" valign="top" bgColor="#eeeeee" colSpan="2">&nbsp;
		
	</td>
</tr>

</table>

<script language="javascript">
function Confirm()
{
	if (confirm("Are you sure you want to delete selected members?\r\nThis will delete all the information related to them."))
		return true;
	else
		return false;
}

function Validate()
{
	if (document.form_add_member.password.value != document.form_add_member.password_again.value)
	{
		alert ("Passwords do not match!");
		return false;
	}

	return true;
}

function CheckAll()
{
        for (var i=0; i<document.form_members_list.elements.length; i++)
        {
                var elem = document.form_members_list.elements[i];

                if ((elem.name.substring(0, 13) == 'member_check[') && (elem.type == 'checkbox'))
	                elem.checked = document.form_members_list.check_all.checked;
        }
}
</script>

</body>
</html>
