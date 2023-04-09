<?
include("config.php");
$ip = $_SERVER["REMOTE_ADDR"];
$saniyesure = $kacdakka * 60;
$simdikizaman = time();
$yenizaman = $simdikizaman - $saniyesure;
$sbilgi = mysql_query("SELECT * FROM $stabloadi WHERE ip='$ip'");
$ssayi = mysql_num_rows($sbilgi);
if ($ssayi > 0) {
	mysql_query("DELETE FROM $stabloadi WHERE $yenizaman>time", $lyrics);
} else {
	mysql_query("INSERT INTO $stabloadi (ip, time) VALUES ('$ip', '$simdikizaman')", $lyrics);
	mysql_query("DELETE FROM $stabloadi WHERE $yenizaman>time", $lyrics);
}
?>