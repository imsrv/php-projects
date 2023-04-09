<?

session_start();

require_once("../config.php");

$connection = mysql_connect($dbServer, $dbUser, $dbPass) or die(mysql_error());
$db = mysql_select_db($dbName, $connection);

if(isset($_POST[s2]))
{
	$MyUsername1 = strip_tags($_POST[username1]);
	$MyPassword1 = strip_tags($_POST[password1]);
	
	if(empty($MyUsername1) || empty($MyPassword1))
	{
		$MyError = "<center><font color=red size=2 face=verdana><b>All fields are required!</b></font></center>";
	}
	else
	{
		//check the login info if exists
		$q1 = "select * from admin25 where username = '$MyUsername1' and password = '$MyPassword1' ";
		$r1 = mysql_query($q1);

		if(mysql_error())
		{
			$MyError = "<center><font color=red size=2 face=verdana><b>Login info is not correct!</b></font></center>";
			exit();
		}
		else
		{
			if(mysql_num_rows($r1) == '1')
			{
				$a1 = mysql_fetch_array($r1);

				$_SESSION[AdminID] = $a1[AdminID];
				$_SESSION[username] = $a1[username];

				header("location:index.php");
				exit();
			}
		}
	}
}

?>

<html>
<head>
<title>Admin Panel</title>

<style>
	body {font-family:verdana; font-size:12; font-weight:bold; color:black; background-color:white}
	td  {font-family:verdana; font-size:12; font-weight:bold; color:black}
</style>

</head>

<body onload="document.f1.username1.focus();">
<!-- main table start here -->
<table width=761 height=500 align=center  border=0 bordercolor=black cellspacing=0 cellpadding=0>
<tr>
	<td align=center>

			<!-- second table start here -->
			<table width="757" border="0" cellspacing="0" cellpadding="0" height="100%" bgcolor=white>	 
			<tr>
				<td align=center>
					<form method=post action="login.php" name=f1>
					<table align=center width=354 border=0 bordercolor=black cellspacing=0 cellpadding=5>
					<caption align=center><?=$MyError?></center>
					<tr bgcolor=#666666>
						
                  <td colspan=2 align=center><b><font color="#FFFFFF" size="+1">Admin</font></b></td>
					</tr>
					<tr bgcolor=#CCCCCC>
						<td>Username: <font size="1">&nbsp;</font></td>
						<td><input type=text name=username1 maxlength=20></td>
					</tr>

					<tr bgcolor=#CCCCCC>
						<td>Password: <font size="1">&nbsp;</font></td>
						<td><input type=password name=password1 maxlength=20></td>
					</tr>
					</table>
			
					<br>

						<center>
							<input type=submit name=s2 value="Login" style="background-color:#6598CD; font-size:11; color:black; font-family:verdana, arial; font-weight:bold; border-width:1; border-color:black">
						</center>

					</form>
		
			</table>
			<!-- second table end here -->
	</td>
</tr>
</table>

<!-- main table end here -->
