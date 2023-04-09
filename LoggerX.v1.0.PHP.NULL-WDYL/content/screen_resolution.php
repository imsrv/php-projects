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
$data = $db1 -> onQueryResolution($db1 -> currentID);
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table border=1 bordercolor=\"#000000\" cellpadding=3 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=2 class=\"Header\"> Screen resolution </td> <tr><td bgcolor=white>";

$pie = new PieChart;
$pie -> setData($data);
$pie -> percents();
$pie -> bgcolor = "FFFFFF";
$pie -> setColors(array("88aaee","88ddff","55dd55","ffff66","ffaa00","ffaaaa","ee6666"));
$pie -> cutData(5);
$pie -> drawChart(1);

echo "</td></tr></table></td></tr></table><br>";
echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> Screen resolution </td> <tr><td bgcolor=white>";

$header = array("Screen size","% of Visitors","Visitors");
$hchart = new HChart;
$hchart -> setData($data);
$hchart -> tableheader = "subheader";
$hchart -> imageURL = $image_path;
$hchart -> drawChart($header,0,0);

echo "</td></tr></table></td></tr></table><br><br>";

?>
