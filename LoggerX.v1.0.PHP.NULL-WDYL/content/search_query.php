<?
include ('./db.php');
include ('./chart.php');
include ('./dir/config.php');

$pagesize = 50;

$username = $HTTP_POST_VARS["a"];
$page = $HTTP_GET_VARS["page"];
if (!($page)) {
	$page = 1;
}

if (!($username)) {
	$username = 'LoggerX';
}

$db1 = new DB;
$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
$db1 -> onLogin();$db1 -> onLogin($username);$data = $db1 -> onQueryQuery($db1 -> currentID);

if (!($data)) {
	$data['no keywords'] = 1;
}

/*$pages = ceil(count($data)/$pagesize);
if ($pages > 1) {
	echo "<br><b>Pages:&nbsp;";
	if ($page != 1) {
		echo "<a href='search_query.php?a=$username&page=1'> << </a>&nbsp;";
	}
	for($i = 1;$i <= $pages;$i++) {
		if ($i != $page) {
			echo "<a href='search_query.php?a=$username&page=$i'> $i </a>&nbsp;";
		}
	}
	if ($page != $pages) {
		echo "<a href='search_query.php?a=$username&page=$pages'> >> </a>&nbsp;";
	}
	echo "</b>";
}*/
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";

echo "<br><br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> Search query </td> <tr><td bgcolor=white>";

$header = array("Keyword","% of Visitors","Visitors");
$schart = new SimpleChart;
$schart -> setData($data);
$schart -> tableheader = "subheader";
$schart -> imageURL = $image_path;
$schart -> drawChart($header,$page,$pagesize);

echo "</td></tr></table></td></tr></table><br><br>";
/*
if ($pages > 1) {
	echo "<br><b>Pages:&nbsp;";
	if ($page != 1) {
		echo "<a href='search_query.php?a=$username&page=1'> << </a>&nbsp;";
	}
	for($i = 1;$i <= $pages;$i++) {
		if ($i != $page) {
			echo "<a href='search_query.php?a=$username&page=$i'> $i </a>&nbsp;";
		}
	}
	if ($page != $pages) {
		echo "<a href='search_query.php?a=$username&page=$pages'> >> </a>&nbsp;";
	}
	echo "</b>";
}*/

?>
