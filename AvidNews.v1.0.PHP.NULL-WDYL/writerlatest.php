<?
include './config.php';
$database = "avid_galtnews";

$connection = mysql_connect("localhost", "databasename","databasepassword") or die ("Server not responding");
mysql_select_db($database);

// Retrieve all news headlines, limited
// either by number of date

switch($CONF['limit_type'])
{
	case "number";

		$condition = "ORDER BY date_added DESC
			     LIMIT $CONF[limit]";
	break;
	
	case "date";
	
		$date_parts = split("/", $CONF['limit']);
		
		$cut_off = mktime( 0, 0, 0, $date_parts['0'], $date_parts['1'], $date_parts['2']);
		
		$condition = "WHERE date_added > '$cut_off'
			     ORDER BY date_added DESC";
	break;
}

//--------------------

$query = "SELECT id, headline, blurb, date_added FROM `$CONF[table_prefix]news`
		   WHERE added_by = 'writer' AND
		   live = 'yes' $condition";
		$result = mysql_query($query) or die ("Error receiving Data");

$num_rows = mysql_num_rows($result);
for($i=0;$i<$num_rows;$i++){
		$row = mysql_fetch_array($result);
		
		$blurb = "blurb$i";
		$blurb = $row['blurb'];

		$id = "id$i";
		$id = $row['id'];
		
		$headline = "headline$i";
		$headline = $row['headline']
		
		$date = "date$i";
		date("m.d.Y", $row['date_added']);
		
		print("document.write('<FONT SIZE=\"2\"><FONT FACE=\"Arial\"><FONT COLOR=\"#7F7F7F\"><a href=\"$CONF[domain]/viewarticle.php?id=$id\">$headline</a></font></font></font>');");		   		
		print("document.write('<br>');");
		print("document.write('<FONT SIZE=\"1\">');");
		print("document.write('<FONT FACE=\"Verdana,Arial,Times New I2\">');");
		print("document.write('<FONT COLOR=\"#7F7F7F\">');");
		print("document.write('$news');");
		print("document.write('<p></td></tr></table>');");

		}
		mysql_close($connection);
		
?>				   