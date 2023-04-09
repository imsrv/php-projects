<?php

if ($run_test != 1)
	{
		echo "<font color=\"FF0000\" face=\"verdana\" size=\"1\">Please, do not run this script directly, 
		run the <a href=\"./dma_news_admin.php\">admin script</a>.</font>";
		exit;
	}

//
// Table structure for table `DMA_News`
//

$query_1 = "CREATE TABLE DMA_News (
  id tinyint(4) NOT NULL auto_increment,
  time varchar(20) NOT NULL default '',
  author varchar(30) NOT NULL default '',
  news text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY id (id),
  KEY id_2 (id)
) TYPE=MyISAM;";

//
// Table structure for table `DMA_News_Authors`
//

$query_2 = "CREATE TABLE DMA_News_Authors (
  id tinyint(4) NOT NULL auto_increment,
  Author varchar(20) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

//
// Table structure for table `DMA_News_Config`
//

$query_3 = "CREATE TABLE DMA_News_Config (
  id varchar(7) NOT NULL default '',
  news_article_template text NOT NULL,
  news_article_header text NOT NULL,
  news_article_footer text NOT NULL,
  admin_template text NOT NULL,
  alt_color_1 varchar(12) NOT NULL default '',
  alt_color_2 varchar(12) NOT NULL default ''
) TYPE=MyISAM;";

//
// Dumping data for table `DMA_News`
//
$query_4a = "INSERT INTO DMA_News VALUES (1, '05th June 2002', 'Test Author', 'You may only install and use these scripts if you agree to assume full \r\nliability for their use. They are intended for the use of knowledgeable web \r\nprofessionals. DMANews is, and always will be, in development, and as such it is unlikely that it will ever be deemed anything other than beta software.<br>\r\nWe hope that you find it useful, but remind you that you use it entirely \r\nat your own risk.');";
$query_4b = "INSERT INTO DMA_News VALUES (2, '05th June 2002', 'Test Author', 'DMANews is copyright © 2002 by Simon Troup of DigitalMediaArt.Com. \r\nAll rights are reserved. You may use the scripts solely for the purpose for which they were designed, as part of a news management solution.');";
$query_4c = "INSERT INTO DMA_News VALUES (3, '05th June 2002', 'Test Author', 'DMANews is designed to ease the process of adding regular news to your website. Once setup, little or no HTML knowledge is required to post news. The script used templates to provide great flexibility in the way that your news is presented on your site.');";
$query_4d = "INSERT INTO DMA_News VALUES (4, '05th June 2002', 'Test Author', 'Welcome to DMA News, a simple news management solution. This is the first Beta release v0.500. Please refer to the readme HTML file for tips and advice about how to set up templates, and if you have any problems, feel free to visit out website by clicking on the DMANews logo at the top of this control panel.');";

//
// Dumping data for table `DMA_News_Authors`
//

$query_5 = "INSERT INTO DMA_News_Authors VALUES (1, 'Test Author');";

//
// Dumping data for table `DMA_News_Config`
//

$query_6 = "INSERT INTO DMA_News_Config VALUES ('config1', '<tr>\r\n	<td align=\"right\" bgcolor=\"XXX_ALTCOLOR_XXX\">\r\n		XXX_TIME_XXX\r\n	</td>\r\n</tr>\r\n<tr>\r\n	<td align=\"left\" bgcolor=\"XXX_ALTCOLOR_XXX\">\r\n		XXX_NEWS_XXX\r\n<br><br>\r\n	<i>XXX_AUTHOR_XXX</i>\r\n	</td>\r\n</tr>', '<center>\r\n<table bgcolor=\"#FFFFFF\" width=\"80%\" cellpadding=\"8\" cellspacing=\"0\" border=\"1\">', '</table>\r\n</center>', '<html>\r\n\r\n<head>\r\n	<title>DMA News | PHP & MySQL News Script</title>\r\n	<meta http-equiv=\"Content-Type\" content=\"text/html;\">\r\n	<link rel=\"stylesheet\" href=\"./dma_news_admin.css\" type=\"text/css\">\r\n</head>\r\n\r\n<body>\r\n\r\n<table bgcolor=\"#ffffff\" border=\"0\" cellpadding=\"20\" cellspacing=\"0\" width=\"100%\">\r\n	<tr>\r\n		<td width=\"100%\">\r\n			XXX_CONTENT_XXX\r\n		</td>\r\n	</tr>\r\n</table>\r\n\r\n</body>\r\n</html>', '#CCCCCC', '#BBBBBB');";

// +------------------------------------+
// |  Database Operations				|
// +------------------------------------+

$link = mysql_connect ("$db_host", "$db_user", "$db_password");
echo "<font color=\"000000\" face=\"verdana\" size=\"2\"><b>Database Operations</b></font>";
echo "<br><br>";

//
// Select DB
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to select the database `$db_db_name` ... </font>";
mysql_select_db ("$db_db_name", $link) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font><br><br><font color=\"#FF0000\" face=\"verdana\" size=\"1\"><b><u>Plese create the MySQL database yourself and then run the script again</u></b></font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Selected</font>";
echo "<br><br>";

//
// Table structure for table `DMA_News`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to create table structure for table `DMA_News` ... </font>";
mysql_query ($query_1) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Created</font>";
echo "<br><br>";

//
// Table structure for table `DMA_News_Authors`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to create table structure for table `DMA_News_Authors` ... </font>";
mysql_query ($query_2) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Created</font>";
echo "<br><br>";

//
// Table structure for table `DMA_News_Config`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to create table structure for table `DMA_News_Config` ... </font>";
mysql_query ($query_3) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Created</font>";
echo "<br><br>";

//
// Dumping data for table `DMA_News`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload dummy news article to table `DMA_News` ... </font>";
mysql_query ($query_4a) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br>";

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload dummy news article to table `DMA_News` ... </font>";
mysql_query ($query_4b) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br>";

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload dummy news article to table `DMA_News` ... </font>";
mysql_query ($query_4c) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br>";

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload dummy news article to table `DMA_News` ... </font>";
mysql_query ($query_4d) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br><br>";

//
// Dumping data for table `DMA_News_Authors`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload data for table `DMA_News_Authors` ... </font>";
mysql_query ($query_5) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br><br>";

//
// Dumping data for table `DMA_News_Config`
//

echo "<font color=\"000000\" face=\"verdana\" size=\"1\">Attempting to upload data for table `DMA_News_Config` ... </font>";
mysql_query ($query_6) or die ("<font color=\"FF0000\" face=\"verdana\" size=\"1\">FAILED</font>");
echo "<font color=\"006600\" face=\"verdana\" size=\"1\">Uploaded</font>";
echo "<br><br>";

//
// If we've got this far, then things must have gone ok !
//

?>
<br><br>
<font color="006600" face="verdana" size="2">Congratulations!</font>
<br><br>
<font color="000000" face="verdana" size="1">The database has now been configured correctly. Please delete the install file for security reasons.</font>
<br><br>
<font color="006600" face="verdana" size="2">Click <a href="./dma_news_admin.php">here</a> to continue.</font>