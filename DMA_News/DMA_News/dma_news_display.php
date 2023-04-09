<?php

// +------------------------------------+
// |  Config							|
// +------------------------------------+

$db_host = "";
$db_user = "";
$db_password = "";
$db_db_name = "";

// +------------------------------------+
// |  Do not edit anything below here	|
// +------------------------------------+

$link = mysql_connect ("$db_host", "$db_user", "$db_password");

mysql_select_db ("$db_db_name", $link);

if (!$link)
	{
		echo "<font color=\"000000\">DB Connect FAIL</font>";
		exit;
	}

$db_result = mysql_query ("SELECT * FROM DMA_News_Config", $link);
$news_array = mysql_fetch_array ($db_result);
$news_header = $news_array[news_article_header];
$news_footer = $news_array[news_article_footer];
$alt_color_1 = $news_array[alt_color_1];
$alt_color_2 = $news_array[alt_color_2];

$row_mod = 2;
	
echo $news_header;

$the_news = mysql_query ("SELECT * FROM DMA_News order by id DESC", $link);

while ($result = mysql_fetch_array ($the_news))
	{
		if ($row_mod%2 == 0)
			{
				$rowcolor = $alt_color_1;
				$row_mod = $row_mod + 1;
			}
		elseif ($row_mod%2 == 1)
			{
				$rowcolor = $alt_color_2;
				$row_mod = $row_mod + 1;
			}
			
		$temporary_template = $news_array[news_article_template];
		
		$news_item = eregi_replace ("XXX_TIME_XXX", $result['time'], $temporary_template);
		$news_item = eregi_replace ("XXX_NEWS_XXX", $result['news'], $news_item);
		$news_item = eregi_replace ("XXX_AUTHOR_XXX", $result['author'], $news_item);
		$news_item = eregi_replace ("XXX_ALTCOLOR_XXX", $rowcolor, $news_item);
		
		echo $news_item;
	}

echo $news_footer;

?>