<? include "config.php" ?><?
$conn = mysql_connect("$dbhost", "$dbuname", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname",$conn)  or die(mysql_error());

$sql=" CREATE TABLE `users` (`id` int NOT NULL auto_increment,`time` DATETIME NOT NULL,`url` VARCHAR( 255 ) NOT NULL,`ms` VARCHAR( 10 ) NOT NULL, PRIMARY KEY (`id`))";
$result=mysql_query($sql, $conn);
echo $result;
mysql_close($conn);
?>
Now Delete This File This <a href="index.php">Click Here</a> to go to the home page






