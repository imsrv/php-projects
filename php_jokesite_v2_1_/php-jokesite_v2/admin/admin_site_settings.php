<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

//postvars($HTTP_POST_VARS);

$this_file_name = HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF']);
$page_title = "Site settings";
//postvars($HTTP_POST_VARS, "<b>\$HTTP_POST_VARS[ ]</b>");

if (!empty($HTTP_POST_VARS['mini_jokes_length']) && $HTTP_POST_VARS['mini_jokes_length']!="0" && !verify($HTTP_POST_VARS['mini_jokes_length'],"int") && !empty($HTTP_POST_VARS['comment_max_length']) && $HTTP_POST_VARS['comment_max_length']!="0" && !verify($HTTP_POST_VARS['comment_max_length'],"int") && !empty($HTTP_POST_VARS['long_jokes_length']) && $HTTP_POST_VARS['long_jokes_length']!="0" && !verify($HTTP_POST_VARS['long_jokes_length'],"int") && !empty($HTTP_POST_VARS['short_jokes_length']) && $HTTP_POST_VARS['short_jokes_length']!="0" && !verify($HTTP_POST_VARS['short_jokes_length'],"int") && !empty($HTTP_POST_VARS['medium_jokes_length']) && $HTTP_POST_VARS['medium_jokes_length']!="0" && !verify($HTTP_POST_VARS['medium_jokes_length'],"int") && !empty($HTTP_POST_VARS['little_photo_width']) && $HTTP_POST_VARS['little_photo_width']!="0" && !verify($HTTP_POST_VARS['little_photo_width'],"int") && !empty($HTTP_POST_VARS['little_photo_height']) && $HTTP_POST_VARS['little_photo_height']!="0" && !verify($HTTP_POST_VARS['little_photo_height'],"int") && !empty($HTTP_POST_VARS['little_photo_size']) && $HTTP_POST_VARS['little_photo_size']!="0" && !verify($HTTP_POST_VARS['little_photo_size'],"int") && !empty($HTTP_POST_VARS['big_photo_width']) && $HTTP_POST_VARS['big_photo_width']!="0" && !verify($HTTP_POST_VARS['big_photo_width'],"int") && !empty($HTTP_POST_VARS['big_photo_height']) && $HTTP_POST_VARS['big_photo_height']!="0" && !verify($HTTP_POST_VARS['big_photo_height'],"int") && !empty($HTTP_POST_VARS['big_photo_size']) && $HTTP_POST_VARS['big_photo_size']!="0" && !verify($HTTP_POST_VARS['big_photo_size'],"int") && $HTTP_POST_VARS['submit'] && !empty($HTTP_POST_VARS['site_mail'])  && (eregi("(@)(.*)",$HTTP_POST_VARS['site_mail'],$regs)) && (verify($HTTP_POST_VARS['newsletter_mail'],"string_int_email")==0) && !empty($HTTP_POST_VARS['newsletter_mail'])  && (eregi("(@)(.*)",$HTTP_POST_VARS['newsletter_mail'],$regs)) && (verify($HTTP_POST_VARS['newsletter_mail'],"string_int_email")==0) && !empty($HTTP_POST_VARS['site_name']) && !empty($HTTP_POST_VARS['site_title']) && !verify($HTTP_POST_VARS['display_nr_top_emailed_joke'],"int") && !verify($HTTP_POST_VARS['display_nr_top_random_joke'],"int") && !verify($HTTP_POST_VARS['display_nr_top_joke'],"int") && !verify($HTTP_POST_VARS['display_nr_joke_category'],"int") && !verify($HTTP_POST_VARS['cookie_limit'],"int"))
{
	$HTTP_POST_VARS['cookie_limit'] *= 3600;
	$HTTP_POST_VARS['cookie_limit'] = $HTTP_POST_VARS['cookie_limit'] =="0" ? "3600" : $HTTP_POST_VARS['cookie_limit'] ;

	$towrite = "<?\n";
	$towrite .= " \$debug_mode = \"".$HTTP_POST_VARS['debug_mode']."\";\n";
	$towrite .= " \$multilanguage_support = \"".$HTTP_POST_VARS['multilanguage_support']."\";\n";
	$towrite .= " \$enable_anonymous_posting = \"".$HTTP_POST_VARS['enable_anonymous_posting']."\";\n";
	$towrite .= " \$use_dirty_words = \"".$HTTP_POST_VARS['use_dirty_words']."\";\n";
	$towrite .= " \$use_censor = \"".$HTTP_POST_VARS['use_censor']."\";\n";
	$towrite .= " \$dirty_words = \"".$HTTP_POST_VARS['dirty_words']."\";\n";
	$towrite .= " \$dirty_words_replacement = \"".$HTTP_POST_VARS['dirty_words_replacement']."\";\n";
	$towrite .= " \$show_newsletter_form = \"".$HTTP_POST_VARS['show_newsletter_form']."\";\n";
	$towrite .= " \$show_quick_search_form = \"".$HTTP_POST_VARS['show_quick_search_form']."\";\n";
	$towrite .= " \$show_statistic_form = \"".$HTTP_POST_VARS['show_statistic_form']."\";\n";
	$towrite .= " \$show_newsletter_form = \"".$HTTP_POST_VARS['show_newsletter_form']."\";\n";
	$towrite .= " \$show_the_joke_and_picture_of_the_day = \"".$HTTP_POST_VARS['show_the_joke_and_picture_of_the_day']."\";\n";
	$towrite .= " \$use_extra_header = \"".$HTTP_POST_VARS['use_extra_header']."\";\n";
	$towrite .= " \$use_extra_footer = \"".$HTTP_POST_VARS['use_extra_footer']."\";\n";
	$towrite .= " \$need_joke_validation = \"".$HTTP_POST_VARS['need_joke_validation']."\";\n";
	$towrite .= " \$need_picture_validation = \"".$HTTP_POST_VARS['need_picture_validation']."\";\n";
	$towrite .= " \$newperiod_for_jokes = \"".$HTTP_POST_VARS['newperiod_for_jokes']."\";\n";
	$towrite .= " \$newperiod_for_pictures = \"".$HTTP_POST_VARS['newperiod_for_pictures']."\";\n";
	$towrite .= " \$showCountedJokes = \"".$HTTP_POST_VARS['showCountedJokes']."\";\n";
	$towrite .= " \$showCountedPictures = \"".$HTTP_POST_VARS['showCountedPictures']."\";\n";
	$towrite .= " \$joke_listing_show_characters = \"".$HTTP_POST_VARS['joke_listing_show_characters']."\";\n";
	$towrite .= " \$mini_jokes_length = \"".$HTTP_POST_VARS['mini_jokes_length']."\";\n";
	$towrite .= " \$comment_max_length = \"".$HTTP_POST_VARS['comment_max_length']."\";\n";
	$towrite .= " \$short_jokes_length = \"".$HTTP_POST_VARS['short_jokes_length']."\";\n";
	$towrite .= " \$long_jokes_length = \"".$HTTP_POST_VARS['long_jokes_length']."\";\n";
	$towrite .= " \$cookie_limit = \"".$HTTP_POST_VARS['cookie_limit']."\";\n";
	$towrite .= " \$display_nr_top_joke = \"".$HTTP_POST_VARS['display_nr_top_joke']."\";\n";
	$towrite .= " \$display_nr_joke_category = \"".$HTTP_POST_VARS['display_nr_joke_category']."\";\n";
	$towrite .= " \$display_nr_top_emailed_joke = \"".$HTTP_POST_VARS['display_nr_top_emailed_joke']."\";\n";
	$towrite .= " \$display_nr_top_random_joke = \"".$HTTP_POST_VARS['display_nr_top_random_joke']."\";\n";
	$towrite .= " \$medium_jokes_length = \"".$HTTP_POST_VARS['medium_jokes_length']."\";\n";
	$towrite .= " \$show_images_at_home = \"".$HTTP_POST_VARS['show_images_at_home']."\";\n";
	$towrite .= " \$little_photo_width = \"".$HTTP_POST_VARS['little_photo_width']."\";\n";
	$towrite .= " \$little_photo_height = \"".$HTTP_POST_VARS['little_photo_height']."\";\n";
	$towrite .= " \$little_photo_size = \"".$HTTP_POST_VARS['little_photo_size']."\";\n";
	$towrite .= " \$big_photo_width = \"".$HTTP_POST_VARS['big_photo_width']."\";\n";
	$towrite .= " \$big_photo_height = \"".$HTTP_POST_VARS['big_photo_height']."\";\n";
	$towrite .= " \$big_photo_size = \"".$HTTP_POST_VARS['big_photo_size']."\";\n";
	$towrite .= " \$site_mail = \"".$HTTP_POST_VARS['site_mail']."\";\n";
	$towrite .= " \$newsletter_mail = \"".$HTTP_POST_VARS['newsletter_mail']."\";\n";
	$towrite .= " \$site_name = \"".$HTTP_POST_VARS['site_name']."\";\n";
	$towrite .= " \$site_title = \"".$HTTP_POST_VARS['site_title']."\";\n";
	$towrite .= " \$imagemagic = \"".$HTTP_POST_VARS['imagemagic']."\";\n";
	$towrite .= " \$imagemagic_path = \"".$HTTP_POST_VARS['imagemagic_path']."\";\n";
	$towrite .= " \$site_signature = \"".$HTTP_POST_VARS['site_signature']."\";\n";
	$towrite .= "?>";
	$fp = fopen("../site_settings.php","w+");
	fwrite($fp, $towrite);
	fclose($fp);
	refresh($this_file_name);
	exit;
}


if ($HTTP_GET_VARS['restore'])
{
	include (DIR_SERVER_ADMIN."admin_settings_backup.php");	
	$towrite = "<?\n";
	$towrite .= " \$debug_mode = \"".$debug_mode."\";\n";
	$towrite .= " \$multilanguage_support = \"".$multilanguage_support."\";\n";
	$towrite .= " \$enable_anonymous_posting = \"".$enable_anonymous_posting."\";\n";
	$towrite .= " \$use_dirty_words = \"".$use_dirty_words."\";\n";
	$towrite .= " \$use_censor = \"".$use_censor."\";\n";
	$towrite .= " \$dirty_words = \"".$dirty_words."\";\n";
	$towrite .= " \$dirty_words_replacement = \"".$dirty_words_replacement."\";\n";
	$towrite .= " \$show_newsletter_form = \"".$show_newsletter_form."\";\n";
	$towrite .= " \$show_quick_search_form = \"".$show_quick_search_form."\";\n";
	$towrite .= " \$show_statistic_form = \"".$show_statistic_form."\";\n";
	$towrite .= " \$show_the_joke_and_picture_of_the_day = \"".$show_the_joke_and_picture_of_the_day."\";\n";
	$towrite .= " \$use_extra_header = \"".$use_extra_header."\";\n";
	$towrite .= " \$use_extra_footer = \"".$use_extra_footer."\";\n";
	$towrite .= " \$need_joke_validation = \"".$need_joke_validation."\";\n";
	$towrite .= " \$need_picture_validation = \"".$need_picture_validation."\";\n";
	$towrite .= " \$newperiod_for_jokes = \"".$newperiod_for_jokes."\";\n";
	$towrite .= " \$newperiod_for_pictures = \"".$newperiod_for_pictures."\";\n";
	$towrite .= " \$showCountedJokes = \"".$showCountedJokes."\";\n";
	$towrite .= " \$joke_listing_show_characters = \"".$joke_listing_show_characters."\";\n";
	$towrite .= " \$showCountedPictures = \"".$showCountedPictures."\";\n";
	$towrite .= " \$mini_jokes_length = \"".$mini_jokes_length."\";\n";
	$towrite .= " \$comment_max_length = \"".$comment_max_length."\";\n";
	$towrite .= " \$short_jokes_length = \"".$short_jokes_length."\";\n";
	$towrite .= " \$long_jokes_length = \"".$long_jokes_length."\";\n";
	$towrite .= " \$cookie_limit = \"".$cookie_limit."\";\n";
	$towrite .= " \$display_nr_top_joke = \"".$display_nr_top_joke."\";\n";
	$towrite .= " \$display_nr_joke_category = \"".$display_nr_joke_category."\";\n";
	$towrite .= " \$display_nr_top_emailed_joke = \"".$display_nr_top_emailed_joke."\";\n";
	$towrite .= " \$display_nr_top_random_joke = \"".$display_nr_top_random_joke."\";\n";
	$towrite .= " \$medium_jokes_length = \"".$medium_jokes_length."\";\n";
	$towrite .= " \$show_images_at_home = \"".$show_images_at_home."\";\n";
	$towrite .= " \$little_photo_width = \"".$little_photo_width."\";\n";
	$towrite .= " \$little_photo_height = \"".$little_photo_height."\";\n";
	$towrite .= " \$little_photo_size = \"".$little_photo_size."\";\n";
	$towrite .= " \$big_photo_width = \"".$big_photo_width."\";\n";
	$towrite .= " \$big_photo_height = \"".$big_photo_height."\";\n";
	$towrite .= " \$big_photo_size = \"".$big_photo_size."\";\n";
	$towrite .= " \$site_mail = \"".$site_mail."\";\n";
	$towrite .= " \$newsletter_mail = \"".$newsletter_mail."\";\n";
	$towrite .= " \$site_name = \"".$site_name."\";\n";
	$towrite .= " \$site_title = \"".$site_title."\";\n";
	$towrite .= " \$imagemagic_path = \"".$imagemagic_path."\";\n";
	$towrite .= " \$site_signature = \"".$site_signature."\";\n";
	$towrite .= "?>";
	$fp = fopen("../site_settings.php","w+");
	fwrite($fp, $towrite);
	fclose($fp);
}

if ($HTTP_GET_VARS['save'])
{

	$filename = "../site_settings.php";
	$fd = fopen ($filename, "r");
	$contents = fread ($fd, filesize ($filename));
	fclose ($fd);
	
	$fp = fopen("admin_settings_backup.php","w+");
	fwrite($fp, $contents);
	fclose($fp);
}

?>

<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="3" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="40%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Name</b></font></td>
			<td align="center" width="60%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Value</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>">
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Debug mode</b>
			</td>
			<td>
				<input type="checkbox" name="debug_mode" value="yes" <?=$debug_mode=="yes" ? "checked" : ""?>>
				switch off after your site is released
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Multilanguage support</b>
			</td>
			<td>
				<input type="checkbox" name="multilanguage_support" value="on" <?=$multilanguage_support=="on" ? "checked" : ""?>>
				check to enable this support
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Enable anonymous email for joke and picture posting</b>
			</td>
			<td>
				<input type="checkbox" name="enable_anonymous_posting" value="yes" <?=$enable_anonymous_posting=="yes" ? "checked" : ""?>>
				check to enable this support
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Use Censor category</b>
			</td>
			<td>
				<input type="checkbox" name="use_censor" value="yes" <?=$use_censor=="yes" ? "checked" : ""?>>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Use Dirty words filter</b>
			</td>
			<td>
				<input type="checkbox" name="use_dirty_words" value="yes" <?=$use_dirty_words=="yes" ? "checked" : ""?>>
				check to enable this support
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Dirty words list</b>
			</td>
			<td>
				<textarea name="dirty_words" cols=40 rows=5><?=$dirty_words?></textarea>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Dirty words will be replaced by </b>
			</td>
			<td>
				<input type="text" name="dirty_words_replacement" value="<?=$dirty_words_replacement?>" class="" size="10"> character
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show newsletter subscribe form on the left part of pages</b>
			</td>
			<td>
				<input type="checkbox" name="show_newsletter_form" value="yes" <?=$show_newsletter_form=="yes" ? "checked" : ""?>>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show quick search form on the left part of pages</b>
			</td>
			<td>
				<input type="checkbox" name="show_quick_search_form" value="yes" <?=$show_quick_search_form=="yes" ? "checked" : ""?>>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show statistic form on the left part of pages</b>
			</td>
			<td>
				<input type="checkbox" name="show_statistic_form" value="yes" <?=$show_statistic_form=="yes" ? "checked" : ""?>>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show content channel (the joke and picture of the day)</b>
			</td>
			<td>
				<input type="checkbox" name="show_the_joke_and_picture_of_the_day" value="yes" <?=$show_the_joke_and_picture_of_the_day=="yes" ? "checked" : ""?>>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Use extra header (to edit extra header go to edit language and edit eg:english.php)</b>
			</td>
			<td>
				<input type="checkbox" name="use_extra_header" value="yes" <?=$use_extra_header=="yes" ? "checked" : ""?>> check to use this header
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Use extra footer (to edit extra footer go to edit language and edit eg:english.php)</b>
			</td>
			<td>
				<input type="checkbox" name="use_extra_footer" value="yes" <?=$use_extra_footer=="yes" ? "checked" : ""?>> check to use this footer
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Jokes need validation from admin? </b>
			</td>
			<td>
				<input type="checkbox" name="need_joke_validation" value="1" <?=$need_joke_validation=="1" ? "checked" : ""?>> check if yes
			</td> 
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Pictures need validation from admin? </b>
			</td>
			<td>
				<input type="checkbox" name="need_picture_validation" value="1" <?=$need_picture_validation=="1" ? "checked" : ""?>> check if yes
			</td> 
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show 'new' for jokes not older than </b>
			</td>
			<td>
				<input type="text" name="newperiod_for_jokes" value="<?=$newperiod_for_jokes?>" class="" size="10"> days
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show 'new' for pictures not older than </b>
			</td>
			<td>
				<input type="text" name="newperiod_for_pictures" value="<?=$newperiod_for_pictures?>" class="" size="10"> days
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show number of jokes beside category</b>
			</td>
			<td>
				<input type="checkbox" name="showCountedJokes" value="on" <?=$showCountedJokes=="on" ? "checked" : ""?>>
				
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Show number of pictures beside category</b>
			</td>
			<td>
				<input type="checkbox" name="showCountedPictures" value="on" <?=$showCountedPictures=="on" ? "checked" : ""?>>
				
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>On joke listings show only</b>
			</td>
			<td>
				<input type="text" name="joke_listing_show_characters" value="<?=$joke_listing_show_characters?>" class="" size="10"> characters
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Short jokes length</b>
			</td>
			<td>
				<input type="text" name="short_jokes_length" value="<?=$short_jokes_length?>" class="" size="10"> character
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Mini jokes length</b>
			</td>
			<td>
				<input type="text" name="mini_jokes_length" value="<?=$mini_jokes_length?>" class="" size="10"> character
			</td>
		</tr>	
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Medium jokes length</b>
			</td>
			<td>
				<input type="text" name="medium_jokes_length" value="<?=$medium_jokes_length?>" class="" size="10"> character
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Long jokes length (this is the max. character what will be accepted)</b>
			</td>
			<td>
				<input type="text" name="long_jokes_length" value="<?=$long_jokes_length?>" class="" size="10"> character
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Comment length (this is the max. character what will be accepted)</b>
			</td>
			<td>
				<input type="text" name="comment_max_length" value="<?=$comment_max_length?>" class="" size="10"> character
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Rating expire</b>
			</td>
			<td>
				<input type="text" name="cookie_limit" value="<?=$cookie_limit/3600?>" class="" size="10"> hours
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Number of displayed jokes in Jokes Categories</b>
			</td>
			<td>
				<input type="text" name="display_nr_joke_category" value="<?=$display_nr_joke_category?>" class="" size="3"> 
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Number of displayed jokes in Top Jokes</b>
			</td>
			<td>
				<input type="text" name="display_nr_top_joke" value="<?=$display_nr_top_joke?>" class="" size="3"> 
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Number of displayed jokes in Top Random Jokes</b>
			</td>
			<td>
				<input type="text" name="display_nr_top_random_joke" value="<?=$display_nr_top_random_joke?>" class="" size="3"> 
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Number of displayed jokes in Top Emailed Jokes</b>
			</td>
			<td>
				<input type="text" name="display_nr_top_emailed_joke" value="<?=$display_nr_top_emailed_joke?>" class="" size="3"> 
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<a name="dislay_images"></a>
				<b>If checked then selected images from "Edit Images" will be displayed, otherway images will be displayed ramdomly</b>
			</td>
			<td>
				<input type="checkbox" name="show_images_at_home" value="on" <?=$show_images_at_home=="on" ? "checked" : ""?>>
				check=selected image display, not checked=random display
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Little photo width</b>
			</td>
			<td>
				<input type="text" name="little_photo_width" value="<?=$little_photo_width?>" class="" size="10"> pixel
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Little photo height</b>
			</td>
			<td>
				<input type="text" name="little_photo_height" value="<?=$little_photo_height?>" class="" size="10"> pixel
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Little photo size</b>
			</td>
			<td>
				<input type="text" name="little_photo_size" value="<?=$little_photo_size?>" class="" size="10"> Kbyte
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Big photo width</b>
			</td>
			<td>
				<input type="text" name="big_photo_width" value="<?=$big_photo_width?>" class="" size="10"> pixel
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Big photo height</b>
			</td>
			<td>
				<input type="text" name="big_photo_height" value="<?=$big_photo_height?>" class="" size="10"> pixel
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Big photo size</b>
			</td>
			<td>
				<input type="text" name="big_photo_size" value="<?=$big_photo_size?>" class="" size="10"> Kbyte
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Site email address</b>
			</td>
			<td>
				<input type="text" name="site_mail" value="<?=$site_mail?>" class="" size="25">
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Newsletter email address</b>
			</td>
			<td>
				<input type="text" name="newsletter_mail" value="<?=$newsletter_mail?>" class="" size="25">
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Site name</b>
			</td>
			<td>
				<input type="text" name="site_name" value="<?=$site_name?>" class="" size="25">
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Site title</b>
			</td>
			<td>
				<input type="text" name="site_title" value="<?=$site_title?>" class="" size="25">
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Use ImageMagic for images manipulation</b>
			</td>
			<td>
				<input type="checkbox" name="imagemagic" value="yes" <?=$imagemagic=="yes" ? "checked" : ""?>> check to use ImageMagick 
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<a name="imagemagick"></a>
				<b><?if($HTTP_GET_VARS['imagemagick']){?><font size="3" color="#ff0000"><?}?>Path to ImageMagick executable</b>
			</td>
			<td>
				<input type="text" name="imagemagic_path" value="<?=$imagemagic_path?>" class="" size="25"> <br>(generally /usr/local/bin/ under Linux)
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td align="right">
				<b>Mail Signature</b>
			</td>
			<td>
				<textarea name="site_signature" cols=40 rows=5><?=$site_signature?></textarea>
			</td>
		</tr>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>">
			<td colspan="2" align="center" height="40">
				<input type="submit" name="submit" value="Save values" class="button" size="10">
			</td>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr>
	<td align="right">
		<a href="<?=$this_file_name?>?save=1" onClick="return confirm('Before you save these values must save!\nDo you want to save as default value now?')">Save as default</a><br>
		<a href="<?=$this_file_name?>?restore=1" onClick="return confirm('Do you want to restore the default values? All data will be replaced with original values!')">Restore default values</a>
	</td>
</tr>
<tr>
	<td>
		&nbsp;
	</td>
</tr>
</table>
<br><br><br>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>