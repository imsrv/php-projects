<?
/*
	Moiat Chat v4.05
	nullified by GTT
				*/
$username = "admin";
$password = "admin";

if ( (!isset($PHP_AUTH_USER)) || !(($PHP_AUTH_USER == $username) && ( $PHP_AUTH_PW == $password)) ) {
header("WWW-Authenticate: Basic Realm=\"ROOMS\"");
header("HTTP/1.0 401 Unauthorized");
echo "Unauthorized access..."; exit;
}

?>

<form method="post" action="define_rooms.php"> 
<input type="text" name="newroom" size="20" maxlength="30">
<input type="submit" name="sendit" value="Create">
</form>

<?

$crlist = file("myrooms.txt");
$croomc = count($crlist)-1;

echo "Currently aviable rooms:<br>\n";
for ($i=0; $i<=$croomc; $i++) {

$rmdata = explode("|", $crlist[$i]);

echo "<b>$rmdata[0]</b> - $rmdata[1]<br>";
}

if ($croomc==0) echo "No rooms aviable!<br>";

if (!empty($HTTP_POST_VARS["newroom"])) { $newroom = $HTTP_POST_VARS["newroom"]; }

if ($newroom!='') {

$fr = fopen("myrooms.txt", "a");
fwrite($fr, "\n". ($croomc+2) ."|". $newroom);
fclose($fr);

$fp = fopen("chat". ($croomc+2) .".dat", "w+");
fclose($fp);

echo "<br>New room $newroom created<br><br>";
}


?>