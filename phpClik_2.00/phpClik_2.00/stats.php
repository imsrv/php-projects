<?


$dbconf = "db.inc.php";                 // Zugangsdaten für die mySQL db
$header = "header.inc";                 // HTML Code
$footer = "footer.inc";                 // HTML Code



function patch($time) {

	$laenge = strlen($time);
	strval($laenge);
	if($laenge == "1") {
		$keytime = "0$time";

	} else {
		$keytime = $time;
	}

	return "$keytime";

}


function get_stats($hits, $whole) {

$stats = $hits*100/$whole;
	return $stats = round($stats);

}

function show_stats($stats, $hits) {
        $gstats = 100 - $stats;
        $output = "<img src='lb.gif' height='10' width='1'><img src='blue.gif' height='10' width='$stats'><img src='grau.gif' height='10' width='$gstats'><img src='lb.gif' height='10' width='1'> <b>$hits</b> ($stats %)</font>";
        return "$output";

}









include("$dbconf");
include("$header");

$link = mysql_connect ("$dbhost", "$dbuser", "$dbpasswd");



//viewby year

if($viewby == "") {

	$sql = "SELECT COUNT(id) AS whole FROM clik WHERE time LIKE '%$year-%'";

	$year = date("Y");

	$query = mysql_db_query ("$db","$sql");

	while ($row = mysql_fetch_array ($query)) {
		$whole = $row[whole];


	}




	$sql = "SELECT MONTH(time) AS time, COUNT(ID) AS hits FROM clik WHERE time LIKE '$year%' GROUP BY time";

	$query = mysql_db_query ("$db","$sql");

	echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {

		$hits = $row[hits];
       		$stats = get_stats($hits, $whole);

		$time = $row[time];
		$keytime = patch($time);

        	echo "<tr><td nowrap align='right'>\n";
                echo "<a href='$PHP_SELF?viewby=day&year=$year&month=$keytime'>$keytime/$year</a>&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


	}

	echo "</table>";
}




// viewby day

if($viewby == "day") {

        $sql = "SELECT COUNT(id) AS whole FROM clik WHERE time LIKE '%$year-$month%'";

        $query = mysql_db_query ("$db","$sql");

        while ($row = mysql_fetch_array ($query)) {

                $whole = $row[whole];

        }




        $sql = "SELECT DAYOFMONTH(time) AS time, COUNT(ID) AS hits FROM clik WHERE time LIKE '$year-$month%' GROUP BY time";

        $query = mysql_db_query ("$db","$sql");

        echo "<font size='2'><a href='stats.php'>back</a><br><br>\n";
        echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {

	        $hits = $row[hits];
                $stats = get_stats($hits, $whole);

                $time = $row[time];
	        $keytime = patch($time);

                echo "<tr><td nowrap align='right'>\n";
                echo "$keytime/$month/$year&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


 	}

echo "</table>";
}


// last 10 visitors




//viewby files

if($viewby == "url") {

	$sql = "SELECT COUNT(id) AS whole FROM clik LIMIT 0,50";

	$year = date("Y");

	$query = mysql_db_query ("$db","$sql");

	while ($row = mysql_fetch_array ($query)) {
		$whole = $row[whole];


	}




	$sql = "SELECT url, COUNT(ID) AS hits FROM clik GROUP BY url ORDER BY hits DESC LIMIT 0,50";

	$query = mysql_db_query ("$db","$sql");

	echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {
                $url = $row[url];
		$hits = $row[hits];
       		$stats = get_stats($hits, $whole);

        	echo "<tr><td nowrap><a href='$url'>$url</a>&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


	}

	echo "</table>";
}



//viewby referer

if($viewby == "referer") {

	$sql = "SELECT COUNT(id) AS whole FROM clik";

	$year = date("Y");

	$query = mysql_db_query ("$db","$sql");

	while ($row = mysql_fetch_array ($query)) {
		$whole = $row[whole];


	}




	$sql = "SELECT ref, COUNT(ID) AS hits FROM clik GROUP BY ref ORDER BY hits DESC";

	$query = mysql_db_query ("$db","$sql");

	echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {

		$hits = $row[hits];
       		$stats = get_stats($hits, $whole);

                $ref = $row[ref];
                if($ref == "") {
                        $ref = "No referer";

                } else {
                        $ref = "<a href='$ref'>$ref</a>";
                }

        	echo "<tr><td nowrap>$ref&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


	}

	echo "</table>";
}




// viewby agent

if($viewby == "agent") {


	$sql = "SELECT COUNT(id) AS whole FROM clik";

	$query = mysql_db_query ("$db","$sql");

	while ($row = mysql_fetch_array ($query)) {
		$whole = $row[whole];


	}




	$sql = "SELECT agent, COUNT(ID) AS hits FROM clik GROUP BY agent ORDER BY hits DESC";

	$query = mysql_db_query ("$db","$sql");

	echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {

                $agent = $row[agent];
		$hits = $row[hits];
       		$stats = get_stats($hits, $whole);

        	echo "<tr><td nowrap>$agent&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


	}

	echo "</table>";
}



if($viewby == "os") {


	$sql = "SELECT COUNT(id) AS whole FROM clik";

	$query = mysql_db_query ("$db","$sql");

	while ($row = mysql_fetch_array ($query)) {
		$whole = $row[whole];


	}





	$sql = "SELECT os, COUNT(ID) AS hits FROM clik GROUP BY os ORDER BY hits DESC";

	$query = mysql_db_query ("$db","$sql");

	echo "<table cellpadding='0' cellspacing='0'>";

	while ($row = mysql_fetch_array ($query)) {

                $os = $row[os];
		$hits = $row[hits];

       		$stats = get_stats($hits, $whole);

        	echo "<tr><td nowrap>$os&nbsp;</td><td>\n";
                echo show_stats($stats, $hits);
                echo "</td></tr>\n";


	}

	echo "</table>";


}




include("$footer");

?>


