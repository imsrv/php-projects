<?php
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

//get userdata
include "rid.php";

// start
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;
?>
<html>
<head>
<title>Chatbox</title>
<meta http-equiv="Content-Type" content="text/html; charset=<? echo $charset; ?>">
<meta http-equiv="Content-Language" content="<? echo $language; ?>">
<script language="JavaScript">
<!--
function fsubmit() {
document.form1.submit();
document.form1.chat.value='';
return false;
}
function justfocus() {
form1.chat.focus();
}
// -->
</script>
</head>
<?
echo "
<body bgcolor=\"#6699CC\" text=\"#FFFFFF\" link=\"#808080\" vlink=\"#C0C0C0\" alink=\"#808080\" onLoad=\"javascript:justfocus();\">

<table border=\"0\" width=\"100%\">
<tr><td width=\"113\">&nbsp;</td>
<td width=\"350\" valign=\"middle\"><form name=\"form1\" method=\"post\" target=\"right\" action=\"right.php\" OnSubmit=\"javascript:return fsubmit();\"> 
<font face=\"arial\" size=\"2\">
<input type=\"text\" name=\"chat\" size=\"35\" maxlength=\"255\">
<input type=\"hidden\" name=\"rid\" value=\"$rid\">
<input type=\"submit\" name=\"sendit\" value=\"$say\">
</form></font>
</td>
<td valign=\"middle\"><form name=\"changeroom\" method=\"post\" action=\"index.php\" target=\"_top\">";

$crlist = file("myrooms.txt");
$croomc = count($crlist)-1;
for ($i=0; $i<=$croomc; $i++) {

$rmdata = explode("|", $crlist[$i]);
$roomx[($i+1)] = $rmdata[1];
}

$cr = $roomx[$room];

$roomnum = count($roomx);

echo "<font face=Arial size=2> $broom: 
<SELECT name=\"room\" OnChange=\"javascript:this.form.submit();\">";

for ($i=1; $i<=$roomnum; $i++) {

if ($roomx[$i]==$cr) { echo "<OPTION value=$i selected>$roomx[$i]\n"; }
else { echo "<OPTION value=\"$i\">$roomx[$i]\n"; }

}
echo "</SELECT>
<input type=\"hidden\" name=\"rid\" value=\"$rid\">
<input type=\"hidden\" name=\"ch\" value=\"1\">
</FORM>";


echo "</td>

<td align=\"right\"></td>

</tr></table>";

//end
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "<!-- Debug: ".$totaltime." -->";
?>

</body>
</html>