<?php 
/*
	Moiat Chat v4.05
	nullified by GTT
				*/

// include the language file
include "language.php";

$userdata = file("users.txt");
$unum = count($userdata);
?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
<tr><td align="left">
<font face="Arial" size="2" color="#ffffff"><? echo $insidethechatare; ?>:</font>
</td></tr>
</table>

<table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" width="500"> 
<tr><td>
<table bgorder="0" cellspacing="1" cellpadding="1" width="500">
<?

if ($unum==0) { echo "<tr bgcolor=\#000000\"><td bgcolor=\"#ffffff\" align=center>
<font face=\"Arial\" size=\"2\" color=\"#000000\">". $thereisnobodynow ."</font>
</td></tr></table></td></tr></table>"; exit; }

while (($unum % 4)!=0) $unum++;

for ($i=0; $i<$unum; $i++) {

if (($i % 4)==0) echo "<tr bgcolor=\"#000000\">";

$ud = explode("|", $userdata[$i]);

if ($ud[1]=="m") { 
?>
<td width="25%" bgcolor="#ffffff"><font face="Arial" size="2" color="#000000"><img src="./img/boy.gif"><? echo $ud[0]; ?></font></td>
<? }
elseif ($ud[1]=="f") {
?>
<td width="25%" bgcolor="#ffffff"><font face="Arial" size="2" color="#000000"><img src="./img/girl.gif"><? echo $ud[0]; ?></font></td>
<? } else { 
?>
<td width="25%" bgcolor="#ffffff"></td>
<?
}
if (($i % 4)==3) echo "</tr>";
}

?>
</table>
</td></tr>
</table>