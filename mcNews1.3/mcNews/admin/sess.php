<?
// mcNews 1.3 - Marc Cagninacci - marc@phpforums.net - http://www.phpforums.net

include 'header.php';
include '../conf.inc.php';
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT lang FROM mcnews_design";
$req = mysql_query($query, $connect) or die('Vous devez d\'abord executer <b>admin/install.php</b><br>Please run first <b>admin/install.php</b>');
$log=mysql_fetch_array($req);
$langfile=$log['lang'];
include ("$langfile");
?>

<form method="post" action="login.php">
<table border="0" width="400" align="center">
<tr>
<td width="200"><font face="verdana" size="2" color="black"><b><? echo $lLogin; ?></b></font></td>
<td width="200"><input type="text" name="log"></td>
</tr>
<tr>
<td width="200"><font face="verdana" size="2" color="black"><b><? echo $lPass; ?><b></font></td>
<td width="200"><input type="password" name="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="<? echo $lSubmit; ?>">
</td></tr> 
</table>
</form>

<?
include './footer.php';
?>
