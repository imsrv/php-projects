<?php
<?
include "config.php";
$db = mysql_connect($db_host,$db_user,$db_pass); 
mysql_select_db ($db_name) or die ("Cannot connect to database"); 
$query4 = "SELECT id, emailadd, fullname, country, date FROM users WHERE username='$_GET[p]' LIMIT 0,1"; 
$result4 = mysql_query($query4); 
while($r=mysql_fetch_array($result4)) 
{ 
/* This bit sets our data from each row as variables, to make it easier to display */ 
$id=$r["id"]; 
$emailadd=$r["emailadd"]; 
$fullname=$r["fullname"]; 
$country=$r["country"]; 
$date=$r["date"]; 
// display it all
echo "<b>General</b><br>";
echo "&nbsp;&nbsp;&nbsp;Email Address: <b>$emailadd</b><br>&nbsp;&nbsp;&nbsp;Country: <b>$country</b><br>&nbsp;&nbsp;&nbsp;Date " . $_GET['p'] . " signed up: <b>$date</b><br>"; 
}
?>
</div></div><br>
<div class="side-headline"><b>Posts By: <?=$_GET['p'];?></b></div>
include "switcharray.php";
$query = "SELECT id, tid, categories, tname, poster, fpost, sig, avatar, time, date FROM forum WHERE poster = '$_GET[p]' ORDER BY date DESC"; 
$sig=$r["sig"]; 