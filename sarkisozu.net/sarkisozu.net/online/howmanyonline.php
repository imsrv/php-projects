<?

include("config.php");
$sbilgi = mysql_query("SELECT * FROM counter_online", $lyrics);
$ssayi = mysql_num_rows($sbilgi)+1;

if ($num == 1) {
	echo "$ssayi";
} else {
	echo "$ssayi";
}

?>