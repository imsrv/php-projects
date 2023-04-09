<?
include ('./db.php');
include ('./chart.php');
include ('./dir/config.php');

$username = $HTTP_POST_VARS["a"];
if (!($username)) {
	$username = 'LoggerX';
}

$db2 = new DB;
$db2 -> open($dbhost,$dbuser,$dbpasswd,$db);
$db2 -> onLogin($username);
$data1 = $db2 -> onQueryJavaScript($db2 -> currentID);
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED' width=95%>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED' width=100%>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> JavaScript version </td> <tr><td bgcolor=white>";

$header1 = array("JavaScript version","% of Visitors","Visitors");
$hchart1 = new HChart;
$hchart1 -> setData($data1);
$hchart1 -> barwidth = 270;
$hchart1 -> tableheader = "subheader";
$hchart1 -> imageURL = $image_path;
$hchart1 -> drawChart($header1,0,0);

echo "</td></tr></table></td></tr></table><br><br>";

$db1 = new DB;
$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
$db1 -> onLogin($username);
$data = $db1 -> onQueryJava($db1 -> currentID);

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED' width=95%>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED' width=100%>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> Java enabled </td> <tr><td bgcolor=white>";

$header = array("Java version","% of Visitors","Visitors");
$hchart = new HChart;
$hchart -> setData($data);
$hchart -> barwidth = 270;
$hchart -> tableheader = "subheader";
$hchart -> imageURL = $image_path;
$hchart -> drawChart($header,0,0);

echo "</td></tr></table></td></tr></table><br><br>";

?>
