<?

include ('./db.php');
include ('./chart.php');
include ('./dir/config.php');

$username = $HTTP_POST_VARS["a"];

if (!($username)) {
	$username = $login;
}

if (!($username)) {
	$username = 'LoggerX';
}

$month = $HTTP_POST_VARS["month"];
$year = $HTTP_POST_VARS["year"];
$yearnext = $HTTP_POST_VARS["yearnext"];
$yearprev = $HTTP_POST_VARS["yearprev"];
$thisyear = date("Y");

if (!($month)) {
	$month = '13';
}

if (!($year)) {
	$year = $thisyear;
}

if ($yearprev) {
	$year--;
}

if ($yearnext) {
	$year++;
}

if ($month == 13) {
	$year = $thisyear;
}

$getdate = getdate (mktime (0,0,0,$month + 1,0,2001)); 

$db1 = new DB;
$db1 -> open($dbhost,$dbuser,$dbpasswd,$db);
$db1 -> onLogin($username);
$data = $db1 -> onQueryVisitor($db1 -> currentID,$month,$year);

if ($month == '13') {
	$data = array_reverse($data);
}

function totalHits($data) {
	reset($data);
	$result = 0;
	while (list($key,$value) = each($data)) {
		$result += $value;
	}
	return $result;
}

function Compare($first,$second) {
        list($m1,$d1,$y1) = split(':',$first);
        list($m2,$d2,$y2) = split(':',$second);
        $first = "$y1:$m1:$d1";
        $second = "$y2:$m2:$d2";
        if ($first > $second) {
                return true;
        } else {
                return false;
        }
}


function Last30Days($data) {
	$var = date("m");
	if ($var == '01') {
		$var = 12;
		$last = substr($today,-1,1);
		$date = substr_replace($today,$var,0,2);
		$date = substr_replace($date,--$last,-1,1);
	} else {
		if ($var < '11') {
			$var = '0'.--$var;
		}
		$date = --$var;
	}
	$date = date("$date:d:Y");
	$result = 0;
	reset($data);
	$i=0;
	while (list($key,$value) = each($data)) {
		if (Compare($key,$date)) {
			$result += $value;
		}
	}
	return $result;
}
echo "<table cellSpacing= 0 cellPadding= 0 width=100%  bgColor='#000000' border= 0 ><tbody><tr><td colSpan='2'><table cell Spacing=1 cellPadding=0 width=100% border=0><tbody><tr><td bgColor='#4776AF'><p align='center'><b><font face='Verdana' color='#FFFFFF'>Statistics for $username</font></b></p></td> </tr></tbody></table></table>";
echo '<br><table border=0>';
echo '<tr valign="top"><td align=center>';
if ($username == 'LoggerX') {
	$scriptname = 'visitorsex.php';
} else {
	$scriptname = 'visitors.php';
}
echo "<form name=\"monthform\" method=post action=\"".$scriptname."\">";
echo "<input type=hidden name='a' value='$username'>";
echo '<select name="month" onchange="document.monthform.submit()">';
if ($month == '13') {
	echo '<option value="13"> Last 30 </option>';
	$getdate['month'] = 'last 30 days';
} else {
	echo "<option value=\"$month\"> ".$getdate['month']." </option>";
}
if ($month != '13') {
	echo '<option value="13"> Last 30 </option>';
}
echo '<option value="01"> January </option>';
echo '<option value="02"> February </option>';
echo '<option value="03"> March </option>';
echo '<option value="04"> April </option>';
echo '<option value="05"> May </option>';
echo '<option value="06"> June </option>';
echo '<option value="07"> July </option>';
echo '<option value="08"> August </option>';
echo '<option value="09"> September </option>';
echo '<option value="10"> October </option>';
echo '<option value="11"> November </option>';
echo '<option value="12"> December </option>';
echo "</select>";
echo "<br><br>";
echo "<input type=submit name=\"yearprev\" value=\"<<\">";
echo " <b> &nbsp; $year &nbsp; </b> ";
echo "<input type=submit name=\"yearnext\" value=\">>\">";
echo "<input type=hidden name=\"year\" value=\"$year\">";
echo "</form>";
echo "</td>";

if (!count($data)) {
	$data = array('no stats available' => '0');
}

echo "<td width=20%></td><td align=center>";
echo "<table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED'>";
echo "<tr>";
echo "<td bgcolor=\"#4776AF\"> Total hits: </td>";
echo "<td bgcolor=\"#CCCCCC\">".$db1 -> onHitsQuery($db1 -> currentID)."</td>";
echo "</tr>";
echo "<tr>";
echo "<td bgcolor=\"#4776AF\"> Total visitors: </td>";
list($totalVisitors,$countVisitors) = $db1 -> onTotalVisitorsQuery($db1 -> currentID);
if (!($countVisitors)) {
	$countVisitors = 1;
}
echo "<td bgcolor=\"#CCCCCC\">".$totalVisitors."</td>";
echo "</tr>";
echo "<tr>";
echo "<td bgcolor=\"#4776AF\"> Average visitors per day: </td>";
echo "<td bgcolor=\"#CCCCCC\">".round($totalVisitors/$countVisitors)."</td>";
echo "</tr>";
echo "<tr>";
echo "<td bgcolor=\"#4776AF\"> Total for ".$getdate['month']." : </td>";
echo "<td bgcolor=\"#CCCCCC\">".Last30Days($data)."</td>";
echo "</tr>";
echo "</table>";
echo "</td></tr>";
echo "</table></table>";

echo "<br><table border=0 cellpadding=1 cellspacing=1 bgcolor='#EDEDED' width=95%>";
echo "<tr bgcolor=\"#000000\" align=center><td>";
echo "<table cellpadding=3 cellspacing=1 bgcolor='#EDEDED' width=100%>";
echo "<tr bgcolor=\"#000000\" align=center>";
echo "<td colspan=3 class=\"Header\"> Visitors by ".$getdate['month'].", $year </td> <tr><td bgcolor=white>";

$header = array("Date","% of Visitors","# of Visitors");
$hchart = new HChart;
$hchart -> setData($data);
$hchart -> tableheader = "subheader";
$hchart -> imageURL = $image_path;
$hchart -> drawChart($header,0,0,0);

echo "</td></tr></table></td></tr></table><br><br>";

?>
