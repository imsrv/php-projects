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
$data = $db1 -> onQueryLanguage($db1 -> currentID);
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED' width=95%>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED' width=100%>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> Language </td> <tr><td bgcolor=white>";

$header = array("Language","% of Visitors","Visitors");
$hchart = new HChart;
$hchart -> setData($data);
$hchart -> barwidth = 270;
$hchart -> tableheader = "subheader";
$hchart -> imageURL = $image_path;
$hchart -> drawChart($header,0,0);

echo "</td></tr></table></td></tr></table><br><br>";

?>
