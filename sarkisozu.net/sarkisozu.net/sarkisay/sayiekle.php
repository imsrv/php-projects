<?php
$info = mysql_query("SELECT * FROM sarki");
$num = $row_sozler['sayac'];
mysql_query("UPDATE sarki SET sayac=(sayac+1) WHERE id='$id'");
?>

