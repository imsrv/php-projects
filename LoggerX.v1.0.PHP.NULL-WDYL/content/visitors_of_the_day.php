<?
include ('./db.php');
include ('./chart.php');
include ('./dir/config.php');

$username = $HTTP_POST_VARS["a"];
if (!($username)) {
	$username = 'LoggerX';
}

$db1 = new DB;
$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
$db1 -> onLogin($username);
$data = $db1 -> onQueryWeekly($db1 -> currentID);
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table border=0 cellpadding=3 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=7 class=\"Header\">";
echo "Number Visitors by day of the week</td></tr>";

$vchart = new VChart;
$vchart -> imageURL = $image_path;
$vchart -> tablestyle = "subheader";
$vchart -> setData($data);
$vchart -> drawChart();

echo "</table></td></tr></table><br><br>";

?>
