<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| HEADLINES.PHP - A script to get     |
| the latest news headlines from the  |
| database and display.               |
| Called Via SSI/Include              |
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# Include configuration script

include './config.php';

# Connect to MySQL database

mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']);
mysql_select_db($CONF['dbname']);

# Get our variables into a better format

$_SUBMIT = array_merge( $HTTP_GET_VARS, $HTTP_POST_VARS );
extract( $_SUBMIT, EXTR_OVERWRITE );

//--------------------

//--------------------------------
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
if($items == "")
{
	$limiter = "$condition";
}else
{
$limiter = "ORDER BY date_added DESC
			     LIMIT $items";
}

$news = mysql_query("SELECT id, category, headline, blurb, date_added FROM `$CONF[table_prefix]news`
		   WHERE category = '$category' AND 
		   live = 'yes' $limiter");

//--------------------

$templates = mysql_query("SELECT name, code FROM `$CONF[table_prefix]templates`
		        WHERE name = 'html_header' OR
			     name = 'headline_bit' OR 
			     name = 'headline_header' OR
			     name = 'headline_footer' OR
			     name = 'headline_separator' OR
			     name = 'html_footer'");

while($row_info = mysql_fetch_array($templates))
{
	$row_info['code'] = eregi_replace("\"", "\\\"", $row_info['code']);
	
	$TEMPLATE[$row_info['name']] = $row_info['code'];
	
}

//--------------------
// Print out the header/html

eval( "echo(\"".$TEMPLATE['html_header']."\");");

//--------------------

eval ( "echo(\"".$TEMPLATE['headline_header']."\");");

$i = 0 ; # Counter variable

while($news_info = mysql_fetch_array($news))
{
	$news_info['date'] = date("m.d.Y", $news_info['date_added']);
		
	eval( "echo(\"".$TEMPLATE['headline_bit']."\");");
	
	if($i != (mysql_num_rows($news) - 1))
	{
		eval( "echo(\"".$TEMPLATE['headline_separator']."\");");
	}
	
	$i++;
	
}

eval( "echo(\"".$TEMPLATE['headline_footer']."\");");

eval( "echo(\"".$TEMPLATE['html_footer']."\");");

?>