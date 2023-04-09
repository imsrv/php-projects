<?php include ("inc/security.inc") ?>
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



<div style="text-align:left; width:300px; margin-top:50px; background-color:#000000; padding:10px;">
<div style="color:#FFFFFF; text-transform:uppercase; ">Добро пожаловать в панель администратора<br /><span style="color:#FED200; font-weight:bold; font-size:17px;"><?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?></span><br /></div><br />
<?php
session_unset();
session_destroy();
?>

<div style="background-color:#FFCC00; text-transform:uppercase; font-weight:bold; font-size:16px; padding:5px;">Ваша сессия успешно закрыта. Вы вышли.</div><br /><br />
<a href="index.php" style="color:#FFFFFF; text-transform:uppercase; font-weight:bold;">Кликните здесь, чтобы снова войти</a></font>
</div>

</center>
</body>
</html>
	