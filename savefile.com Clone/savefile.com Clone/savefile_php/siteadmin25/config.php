<?
require_once("../config.php");
require_once("accesscontrol.php");
require_once("header.php");

$connection = mysql_connect($dbServer, $dbUser, $dbPass) or die(mysql_error());
$db = mysql_select_db($dbName, $connection);

if(isset($_POST[s1]))
{

		if(!empty($_POST[NewPass1]))
		{
			$q1 = "update admin25 set 
							username = '$_POST[NewAdmin]',
							password = '$_POST[NewPass1]'
							
							where AdminID = '$_SESSION[AdminID]' ";
		}
		else
		{
			$q1 = "update admin25 set 
							username = '$_POST[NewAdmin]'

							where AdminID = '$_SESSION[AdminID]' ";
		}

		mysql_query($q1) or die(mysql_error());


		echo "<br><center>Your information was updated.</center>";

		if($_SESSION[username] != $_POST[NewAdmin])
		{
			$_SESSION[username] = $_POST[NewAdmin];
		}

}

//get the admin25 information
$q1 = "select * from admin25 where AdminID = '$_SESSION[AdminID]' ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

?>

<script>
	function CheckInfo() {

		if(document.f1.NewAdmin.value == "")
		{
			alert('Enter your Admin username!');
			document.f1.NewAdmin.focus();
			return false;
		}

		if(document.f1.NewPass1.value != "")
		{
			if(document.f1.NewPass1.value != document.f1.NewPass2.value)
			{
				alert('Retype and confirm your new password again!');
				document.f1.NewPass1.value = "";
				document.f1.NewPass2.value = "";
				document.f1.NewPass1.focus();
				return false;
			}

		}

	}
</script>

<form method=post onsubmit="return CheckInfo();" name=f1>
<table align=center width=450>
<caption align=center><font size=2><b>Edit Your Information</b></font><br><?=$up_error?></caption>

<tr style="background-color:#FF9933; font-family:verdana; font-size:11; font-weight:bold; color:white">
	<td colspan=2>Change your Admin username:</td>
</tr>

<tr>
	<td>New Admin ID:</td>
	<td><input type=text name=NewAdmin value="<?=$a1[username]?>"></td>
</tr>

<tr style="background-color:#FF9933; font-family:verdana; font-size:11; font-weight:bold; color:white">
	<td colspan=2>Change your password:</td>
</tr>

<tr>
	<td>New password:</td>
	<td><input type=password name=NewPass1></td>
</tr>

<tr>
	<td>Confirm password:</td>
	<td><input type=password name=NewPass2></td>
</tr>

<tr>
	<td colspan=2 align=center><br><br>
		<input type=submit name=s1 value="Update" class="sub1">
	</td>
</tr>
</table>
</form>

<?
require_once("footer.php");
?>