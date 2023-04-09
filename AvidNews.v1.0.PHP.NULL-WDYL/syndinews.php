<?
include './config.php';

$connection = mysql_connect( $CONF["dbhost"], $CONF["dbuser"], $CONF["dbpass"]) or die ("Server not responding");
mysql_select_db( $CONF["dbname"] );

// Retrieve all news headlines, limited
// either by number of date  example: $CONF[limit]

switch($CONF['limit_type'])
{
	case "number";
		(isset($_GET['items'])) ? $limit = $_GET['items'] : $limit = $CONF['limit'];
		$condition = "ORDER BY date_added DESC
			       LIMIT $limit";
	break;
	
	case "date";
	
		$date_parts = split("/", $CONF['limit']);
		
		$cut_off = mktime( 0, 0, 0, $date_parts['0'], $date_parts['1'], $date_parts['2']);
		
		$condition = "WHERE date_added > '$cut_off'
			     ORDER BY date_added DESC";
	break;
}

//-------------------- <IMG SRC=\"images/newsbullet.gif\" WIDTH=\"9\" HEIGHT=\"9\" VSPACE=\"0\" HSPACE=\"0\" BORDER=\"0\">

$query = "SELECT id, headline, blurb, date_added FROM `$CONF[table_prefix]news`
		   WHERE category = '$_GET[category]' AND
		   live = 'yes' $condition";
		$result = mysql_query($query) or die ("Error receiving Data");

$num_rows = mysql_num_rows($result);

//-------------------
// Retrieve headline templates

$templates = mysql_query("SELECT name, code FROM `$CONF[table_prefix]templates`
		        WHERE name = 'html_header' OR
			     name = 'headline_bit' OR 
			     name = 'headline_header' OR
			     name = 'headline_footer' OR
			     name = 'headline_separator' OR
			     name = 'html_footer'");

while($row_info = mysql_fetch_array($templates))
{
	$row_info['code'] = str_replace("\"", "\\\"", $row_info['code']);
	$row_info['code'] = str_replace("'", "\\'", $row_info['code']);
	$row_info['code'] = str_replace("\r\n", "", $row_info['code']);
	$row_info['code'] = str_replace("\n", "", $row_info['code']);
	
		
	$TEMPLATE[$row_info['name']] = $row_info['code'];
	
}

//---

eval( "echo(\"document.write('".$TEMPLATE['html_header']."');\n\");");

//--------------------

eval( "echo(\"document.write('".$TEMPLATE['headline_header']."');\n\");");		
		
//---

for($i=0;$i<$num_rows;$i++)
{
		$news_info = mysql_fetch_array($result);
		
		$news_info['date'] = date("m.d.Y", $news_info['date_added']);
		
		nl2br($news_info['blurb']);
		$news_info[headline] = addslashes($news_info['headline']);
		$news_info[blurb] = addslashes($news_info['blurb']);
				
		eval( "echo(\"document.write('".$TEMPLATE['headline_bit']."');\n\");");
		
		if($i != ($num_rows - 1))
		{
			eval( "echo(\"document.write('".$TEMPLATE['headline_separator']."');\n\");");
			}
			
//		print("document.write('<TABLE WIDTH=\"100%\" CELLPADDING=\"2\" CELLSPACING=\"0\" BORDER=\"0\"><TR><TD WIDTH=\"2%\" VALIGN=top></TD>');");
//     	print("document.write('<TD WIDTH=\"98%\" VALIGN=TOP><P>');");
//      	print("document.write('<FONT SIZE=\"1\">');");
//		print("document.write('<FONT FACE=\"Verdana,Arial,Times New I2\">');");
//		print("document.write('<FONT COLOR=\"#7F7F7F\">');");
//		print("document.write('<font color=\"#97A91A\"><b>$date</b></font>');");
//		print("document.write('<br>');");
//		print("document.write('<font color=\"#142C4D\"><b>$headline</b>');");		   		
//		print("document.write('<br>');");
//		print("document.write('<FONT SIZE=\"1\">');");
//		print("document.write('<FONT FACE=\"Verdana,Arial,Times New I2\">');");
//		print("document.write('<FONT COLOR=\"#000000\">');");
//		print("document.write('$news');");
//		print("document.write('</TD></TR><TR><TD WIDTH=\"2%\" VALIGN=TOP></TD><TD WIDTH=\"98%\" VALIGN=TOP><P><a href=\"http://news.avidnewmedia.com/viewarticle.php?id=$id\" class=\"idootut\"><IMG SRC=\"images/morenews.gif\" WIDTH=\"180\" HEIGHT=\"15\" VSPACE=\"0\" HSPACE=\"0\" BORDER=\"0\"></a></TD></TR></TABLE>');");
//		print("document.write('<br>');");
eval( "echo(\"document.write('".$TEMPLATE['headline_footer']."');\");");
}
		mysql_close($connection);
		
?>				   