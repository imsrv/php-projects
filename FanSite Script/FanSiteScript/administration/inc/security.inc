<?php
session_start();
include("../include/connect.txt");

if (isset($_POST['Submit']))
{
$error ="0";
	$username = $_POST['username'];
	$password = $_POST['password'];
	$salt = substr($password, 0, 2);
		$encrypted_pswd = crypt($password, $salt);
	$result = mysql_query("Select * From ds_options where username='$username'",$db);
	
	if(mysql_num_rows($result)>0)
	{
		$myrow = mysql_fetch_array($result, MYSQL_BOTH);
		if($encrypted_pswd == $myrow["password"])
		{
			
			$_SESSION['loginok'] = "ok";
			$_SESSION['username'] = "username";
			$_SESSION['password'] = "password";
			header("Location: $PHP_SELF");

		}
		else
		{
			$error="1";
		}
		
   	 }
	else
	{
		$error ="1";
	}

}

if ($_SESSION['loginok'] !="ok" )
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><title><?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?> - Login</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

</head><body>

<center>


<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
<div style="text-align:left; width:300px; margin-top:50px; background-color:#000000; padding:10px;">
<div style="color:#FFFFFF; text-transform:uppercase; ">Добро пожаловать в панель администратора<br /><span style="color:#FED200; font-weight:bold; font-size:17px;"><?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?></span><br /></div><br />
<?PHP
if ( $error =="1" )
{
?>
<div style="text-align:center;"><FONT COLOR="#FF0000"><B><FONT SIZE="2">Неверный логин. </FONT></div>
<?php
}
?>
<div style="background-color:#FFCC00; text-transform:uppercase; font-weight:bold; font-size:16px; padding:5px;">Логин:</div><br />
<div><input type="text" name="username" style="width:300px;" /></div><br /><br />

<div style="background-color:#FFCC00; text-transform:uppercase; font-weight:bold; font-size:16px; padding:5px;">Пароль:</div><br />
<div><input type="password" name="password" style="width:300px;" /></div><br /><br />
<div style="text-align:center;"><INPUT TYPE="Submit" NAME="Войти" VALUE="login"></div>

</div>
</FORM>
</center>
</body>
</html>
<?PHP
		exit();
	}

?>