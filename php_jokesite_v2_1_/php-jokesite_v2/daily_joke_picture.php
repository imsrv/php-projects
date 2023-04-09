<?

if(!isset($HTTP_POST_VARS['rebuild_channel']))
{
	include ("config_file.php");
}
include(DIR_LNG.'daily_joke_picture.php');
include (DIR_SERVER_ROOT."daily_joke_picture_config_file.php");
$joke_file_name = INCOMING."daily_active_joke_picture".$slng.".php";

$database_jokes_table_name = $bx_db_table_jokes;
$database_pictures_table_name = $bx_db_table_images;

$header_font = 'face="verdana, helvetica, arial" size="1" color="'.$header_font_color.'" style="font-weight: bold"';
$joke_font = "style=\"font-size:10px\"";

$link_under_picture = "<a href=\"".$link_address."\" style=\"font-size:8pt;color:".$content_under_font_color.";text-decoration:none\">".$link_text."</a>";

$last_access = @getdate(filemtime($joke_file_name));
$today = getdate();

if(isset($HTTP_POST_VARS['rebuild_channel']))
{
	$today['mday'] = 0;
}

if($last_access['mday'] != $today['mday'] || $last_access['month'] != $today['month'] || $last_access['year'] != $today['year'])			//ezt != kell legyen mert igy nezi a nap elteleset
{
	
	$select_joke_SQL = "select * from $database_jokes_table_name where validate='1' ".(MULTILANGUAGE_SUPPORT == "on" ? "and slng='".$slng."'" : "");
	$select_joke_query = mysql_query($select_joke_SQL);
	$count_joke = mysql_num_rows($select_joke_query);
	
	if ($count_joke > 1)
	{
		$random_joke = rand(1, $count_joke);
	}
	$i=0;
	while ($select_joke_result = mysql_fetch_array($select_joke_query))
	{

		if ($count_joke > 1 )
		{
			$i++;
			if ($i == $random_joke)
			{
				$active_joke_text = $select_joke_result['joke_text'];
				$active_joke_id = $select_joke_result['joke_id'];
				$active_joke_cat_id = $select_joke_result['category_id'];
			}
		}
		else
		{
			$active_joke_text = $select_joke_result['joke_text'];
			$active_joke_id = $select_joke_result['joke_id'];
			$active_joke_cat_id = $select_joke_result['category_id'];
		}
	}

	if ($count_joke != 0)
	{
		$active = "<?\n\$active_joke=\"".addslashes("<a href=\"".HTTP_SERVER."jokes.php?joke_id=".$active_joke_id."&cat_id=".$active_joke_cat_id."\" $joke_font style=\"color:".$content_joke_font_color.";text-decoration:none\">".eregi_replace("\r\n","<br>",short_string($active_joke_text, $nr_of_joke_characters, "...")."</font></a>"))."\";\n\n";
	}
	else
	{
		$active .= "<?\n\$active_joke= \"<font size=2><center>".TEXT_NO_JOKE."</center></font>\";\n";
	}

	$select_picture_SQL = "select * from $database_pictures_table_name where validate='1'";
	$select_picture_query = mysql_query($select_picture_SQL);
	$count_picture = mysql_num_rows($select_picture_query);
	if ($count_picture > 0)
	{
		$random_picture = rand(1, $count_picture);
	}
	
	while ($select_picture_result = mysql_fetch_array($select_picture_query))
	{
		if ($count_picture > 0)
		{
			$j++;
			if ($j == $random_picture)
			{
				$active_picture = $select_picture_result['little_img_name'];
				$active_picture_id = $select_picture_result['img_id'];
			}
		}
		else
		{
			$active_picture = $select_picture_result['little_img_name'];
			$active_picture_id = $select_picture_result['img_id'];
		}
	}
	if ($count_picture != 0)
	{
		$active .= "\$active_picture=\"".addslashes("<a href=\"".HTTP_SERVER."creat_postcard.php?img_id=".$active_picture_id."\"><img src=\"".HTTP_INCOMING.$active_picture."\" border=\"0\" hspace=\"3\" vspace=\"3\"></a>")."\";\n";
		$active .= "?>";
	}
	else
	{
		$active .= "\$active_picture= \"".TEXT_NO_PICTURE."\";\n?>";
	}

	$file_open=fopen($joke_file_name,"w");		
	$file_write=fwrite($file_open, $active);
	fclose($file_open);
}

include ($joke_file_name);
if ($HTTP_GET_VARS['type']== "js")
{
?>

document.writeln("<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" width=\"<?=$table_width?>\">");
document.writeln("<tr>");
document.writeln("	<td bgcolor=\"<?=$header_font_bgcolor?>\" align=\"center\"><font <?=addslashes($header_font);?>><?=TEXT_JOKE_OF_THE_DAY?></font></td>");
document.writeln("</tr>");
document.writeln("<tr>");
document.writeln("	<td bgcolor=\"<?=$header_font_bgcolor?>\">");
document.writeln("		<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" bgcolor=\"<?=$internal_table_bgcolor?>\" width=\"<?=$table_width?>\">");
document.writeln("		<tr>");
document.writeln("			<td style=\"font-size:2px\">");
document.writeln("				<?=addslashes($active_joke);?>");
document.writeln("			</td>");
document.writeln("		</tr>");
document.writeln("		</table>");
document.writeln("	</td>");
document.writeln("</tr>");
document.writeln("<tr>");
document.writeln("	<td bgcolor=\"<?=$header_font_bgcolor?>\" align=\"center\"><font <?=addslashes($header_font);?>><?=TEXT_FUNNY_PIC_OF_THE_DAY?></font></td>");
document.writeln("</tr>");
document.writeln("<tr>");
document.writeln("	<td bgcolor=\"<?=$header_font_bgcolor?>\">");
document.writeln("		<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" bgcolor=\"<?=$internal_table_bgcolor?>\" width=\"100%\">");
document.writeln("		<tr>");
document.writeln("			<td align=\"center\">");
document.writeln("				<?=addslashes($active_picture);?>");
document.writeln("			</td>");
document.writeln("		</tr>");
document.writeln("		</table>");
document.writeln("	</td>");
document.writeln("</tr>");
document.writeln("<tr bgcolor=\"<?=$header_font_bgcolor?>\">");
document.writeln("	<td>");
document.writeln("		<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"<?=$internal_table_bgcolor?>\" width=\"100%\">");
document.writeln("		<tr>");
document.writeln("			<td align=\"center\" style=\"font-size:2px\">");
document.writeln("				<?=addslashes($link_under_picture);?>");
document.writeln("			</td>");
document.writeln("		</tr>");
document.writeln("		</table>");
document.writeln("	</td>");
document.writeln("</tr>");
document.writeln("</table>");

<?
}
else{
?>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=$table_width?>">
<tr>
	<td bgcolor="<?=$header_font_bgcolor?>" align="center"><font <?=$header_font;?>><?=TEXT_JOKE_OF_THE_DAY?></font></td>
</tr>
<tr>
	<td bgcolor="<?=$header_font_bgcolor?>">
		<table align="center" border="0" cellspacing="0" cellpadding="2" bgcolor="<?=$internal_table_bgcolor?>" width="<?=$table_width?>">
		<tr>
			<td style="font-size:2px">
				<?=nl2br($active_joke);?>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td bgcolor="<?=$header_font_bgcolor?>" align="center"><font <?=$header_font;?>><?=TEXT_FUNNY_PIC_OF_THE_DAY?></font></td>
</tr>
<tr>
	<td bgcolor="<?=$header_font_bgcolor?>">
		<table align="center" border="0" cellspacing="0" cellpadding="2" bgcolor="<?=$internal_table_bgcolor?>" width="100%">
		<tr>
			<td align="center">
				<?=$active_picture;?>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr bgcolor="<?=$header_font_bgcolor?>">
	<td>
		<table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$internal_table_bgcolor?>" width="100%">
		<tr>
			<td align="center" style="font-size:2px">
				<?=$link_under_picture;?>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<?
}
?>