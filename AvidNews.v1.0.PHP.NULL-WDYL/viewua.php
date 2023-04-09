<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| VIEWALL.PHP ::                      |
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

# Viewall
if($em == "")
{
	echo("Sorry, you cannot access this file directly");
}
else
{
	echo("<script language=javascript>
		function deleteNews(id)
		{
			if(confirm(\"Are you sure you wish to delete this news item?\"))
			{
				location.href = \"admin.php?action=delete&id=\"+id;
			}
		}
		</script>");
echo("<table width=100% cellpadding=0 cellspacing=0>");
echo("<tr>");
echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #ffffff\">
		<tr bgcolor=#ffffff height=20><td colspan=2><font color=#666699><font size=3><font face=Arial>&nbsp;&nbsp;<b>The Latest Unapproved Articles</b></font></font></font></tr></td>");
	
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]news` 
	WHERE live = 'no' ORDER BY date_added DESC LIMIT 5");
	
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=3><center>&nbsp;&nbsp;There are currently no articles that need approved.</center></td></tr>");
	}
	
	while($row_info = mysql_fetch_array($news))
	{
		$row_info[date] = date("m.d.Y", $row_info['date_added']);
		echo("<tr><td width=5% valign=top><img src=\"$CONF[domain]images/arrowicon.gif\" border=\"0\" align=\"absmiddle\"></td><td width=65%><b><a href=\"viewarticle.php?id=$row_info[id]\" target=blank class=welcomenews>$row_info[headline]</a></b><br><i>$row_info[date]</i><br><font color=gray>$row_info[blurb]</font></td><td width=35%><center><a href=\"admin.php?action=editenews&id=$row_info[id]\"><img src=\"$CONF[domain]images/icon-overview.gif\" border=0 alt=Edit/Approve Article align=absmiddle> Read/Approve</a>    <a href='javascript:deleteNews($row_info[id])'><img src=\"$CONF[domain]images/icon-recycle.gif\" border=0 alt=Delete Article align=absmiddle> Delete</a></center></td></tr><tr><td colspan=3><hr></td></tr><p></td></tr>");
	}
echo("</tr></td></table>");
}
# End Viewall
?>