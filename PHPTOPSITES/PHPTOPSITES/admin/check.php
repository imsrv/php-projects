<?
include "../config.php";
include "header.php";

$ms_tb[0] = "top_cats||0";
$ms_tb[1] = "top_hits||0";
$ms_tb[2] = "top_user||0";
$ms_tb[3] = "top_review||0";

$tables = mysql_list_tables($dbname);
$i = 0;

while ($i<mysql_num_rows($tables)) {
      $tb_name[$i] = mysql_tablename($tables,$i);
      $c = 0;
      while ($ms_tb[$c]) {
        $cv = explode ("||", $ms_tb[$c]);
	if ($cv[1] == 0 && $tb_name[$i] == $cv[0]) $ms_tb[$c] = $cv[0]."||1";
	$c++;
      }
      $i++;
}

echo "<table align=center border=1 cellpadding=3 cellspacing=0>";
echo "<tr>";
echo "<td>Variable</td><td>Result</td>";
echo "</tr>";

$c = 0;
while ($ms_tb[$c]) {
	echo "<tr>";
        $cv = explode ("||", $ms_tb[$c]);
	echo "<td>MySQL Table : ".$cv[0]."</td>";
	echo "<td>";
	if ($cv[1] != 1) echo "<font color=red>Failed</font>";
	else echo "<font color=green>Passed</font>";
	echo "</tr>";
	$c++;
}

echo "<tr><td>File : count.txt</td><td>";
if (file_exists("count.txt")) echo "<font color=green>Passed</font>";
else echo "<font color=red>Failed</font>";
echo "</td></tr>";

echo "<tr><td>File : reset.txt</td><td>";
if (file_exists("reset.txt")) echo "<font color=green>Passed</font>";
else echo "<font color=red>Failed</font>";
echo "</td></tr>";

echo "<tr><td>File permissions: count.txt</td><td>";
if (is_writable("count.txt")) echo "<font color=green>Passed</font>";
else echo "<font color=red>Failed</font>";
echo "</td></tr>";

echo "<tr><td>File permissions: reset.txt</td><td>";
if (is_writable("reset.txt")) echo "<font color=green>Passed</font>";
else echo "<font color=red>Failed</font>";
echo "</td></tr>";

echo "</table>";
include "footer.php";
?>