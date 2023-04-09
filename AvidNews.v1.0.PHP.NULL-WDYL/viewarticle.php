<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| VIEWARTICLE.PHP - A script to view  |
| the article selected by the user    |
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

$templates = mysql_query("SELECT name, code FROM `$CONF[table_prefix]templates`
                WHERE name = 'article_header' OR
                 name = 'show_article' OR 
                 name = 'article_footer'");

while($row_info = mysql_fetch_array($templates))
{
    $row_info['code'] = eregi_replace("\"", "\\\"", $row_info['code']);
    
    $TEMPLATE[$row_info['name']] = $row_info['code'];
    
}
//--------------------

$news = mysql_query("SELECT n.*, a.* FROM `$CONF[table_prefix]news` n LEFT JOIN `$CONF[table_prefix]admins` a ON a.username=n.added_by WHERE n.id = '$id'");
$article_info = mysql_fetch_array($news);
if($article_info[image] == "")
{
	$article_info[image] = "";
}else{
	$article_info[image] = "<img src=\"$CONF[domain]images/$article_info[image]\" border=\"1\" align=\"left\" alt=\"$article_info[headline]\">";
}
$page = empty($page) ? 0 : $page - 1;
$pages_array = explode('%newpage%', $article_info['text']);
$pages_array[$page] .= '<br /><br />';

if(($page + 1) > 1)
{
    $pages_array[$page] .= '« <a href="viewarticle.php?id='.$id.'&page='.$page.'">Back</a> ';
}

if(($page + 1) > 1 && count($pages_array) > ($page + 1))
{
    $pages_array[$page] .= ' - ';
}

if(count($pages_array) > ($page + 1))
{
    $pages_array[$page] .= '<a href="viewarticle.php?id='.$id.'&page='.($page + 2).'">Next</a> »';
}

$article_info['text'] = nl2br($pages_array[$page]);
$printpage = "<img src=\"$CONF[domain]images/icon-print.gif\"> <a href=\"$CONF[domain]printthispage.php\" target=\"_blank\" class=\"footernav\">Print This Article</a>";
$emailpage = "<img src=\"$CONF[domain]images/icon-envelop.gif\"> <a href=\"$CONF[domain]emailarticle.php\" target=\"_blank\" class=\"footernav\">Email This Article</a>";
$author = "<a href=\"$CONF[domain]profile.php?writer=$article_info[name]\" target=\"_blank\" class=\"footernav\">$article_info[name]</a>";

eval( "echo(\"".$TEMPLATE['article_header']."\");");

eval( "echo(\"".$TEMPLATE['show_article']."\");");

eval( "echo(\"".$TEMPLATE['article_footer']."\");");

?>
