<?php
# go.php

require "config.class.php";
$c = new config();
$c->open();

if ($id && $go == "Download") {
	$get = @mysql_query("SELECT * FROM $c->mysql_tb_dl WHERE id = '$id'");
	if (mysql_num_rows($get)) {
		$row = mysql_fetch_array($get);
		@mysql_query("UPDATE $c->mysql_tb_dl SET views=views+1 WHERE id = '$id'");
?>
<html>
<head>
<title>GIGA Dls / <? echo $row[title];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset rows="60,*" frameborder="NO" border="0" framespacing="0"> 
  <frame name="topFrame" scrolling="NO" noresize src="frame.php" >
  <frame name="mainFrame" src="<? echo $row[url];?>">
</frameset>
<noframes><body bgcolor="#FFFFFF" text="#000000">
</body></noframes>
</html>
<?
	} else
		$id = false;

} elseif ($id && $go == "Report") {
	$get = @mysql_query("SELECT * FROM $c->mysql_tb_dl WHERE id = '$id'");
	if (mysql_num_rows($get)) {
		echo "<html><head><title>[tunw_to_j_com.tk / report dead link]</title></head><body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" bgcolor=#ffffff><link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\">";
		$row = mysql_fetch_array($get);
		if (!$ok) {
			echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=\"50%\">
			<form name=\"deadlink\" action=\"go.php?id=$id&go=Report\" method=\"POST\">
			<tr><td align=\"center\" valign=\"middle\"><font face=\"Verdana, Arial\" size=\"2\">
			<a href=\"$row[url]\" target=\"_blank\">$row[url]</a><br><br>
			<input type=\"Submit\" value=\"Report - $row[title]\" style=\"font-family:Verdana,Arial; font-size:10;\">
			<input type=\"Hidden\" name=\"ok\" value=\"$row[id]\">
			</td></tr></form></table>";
		} else {
			@mysql_query("UPDATE $c->mysql_tb_dl SET reports=reports+1 WHERE id = '$id'");
			echo "<font face=\"Verdana,Arial\" size=\"2\"><b>Thanks! The Dead Link has been reported!</b><br><br>
			<a href=\"javascript:window.close()\">Close Window</a><br></font>\n";
		}
		echo "\n</body>\n</html>";
	} else
		$id = false;
}

if (!$id)
	header("Location: ut.php");

$c->close();
?>