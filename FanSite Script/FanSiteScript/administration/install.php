
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /><title>Установка FansiteScript</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

</head><body>

<center>



<div style="text-align:left; width:300px; margin-top:50px; background-color:#000000; padding:10px;">
<div style="color:#FFFFFF; text-transform:uppercase; ">Установка FansiteScript</div><br />
<?php
include ("../include/connect.txt");
$result = mysql_query("SHOW TABLES");
$count = mysql_num_rows($result);


If ($count ==0 )
{
$create = "CREATE TABLE ds_articles (
  id smallint(6) NOT NULL auto_increment,
  film tinytext NOT NULL,
  article text NOT NULL,
  type tinytext NOT NULL,
  reference tinytext NOT NULL,
  views smallint(6) NOT NULL default '0',
  meta_title text NOT NULL,
  meta_description text NOT NULL,
  meta_keywords text NOT NULL,
  title tinytext NOT NULL,
  seo_url tinytext NOT NULL,
  PRIMARY KEY  (id)
)";
mysql_query($create);

$create = "CREATE TABLE ds_awards (
  id smallint(6) NOT NULL auto_increment,
  type tinytext NOT NULL,
  description tinytext NOT NULL,
  film tinytext NOT NULL,
  PRIMARY KEY  (id)
)";
mysql_query($create);

$create = "CREATE TABLE `ds_images` (
  id smallint(6) NOT NULL auto_increment,
  description tinytext NOT NULL,
  bin_data longblob NOT NULL,
  filename tinytext NOT NULL,
  filesize tinytext NOT NULL,
  filetype tinytext NOT NULL,
  PRIMARY KEY  (id)
) ";
mysql_query($create);


$create = "CREATE TABLE `ds_links` (
  `id` smallint(6) NOT NULL auto_increment,
  `link` tinytext NOT NULL,
  `film` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
)";
mysql_query($create);

$create = "CREATE TABLE `ds_movies` (
  `id` smallint(6) NOT NULL auto_increment,
  `title` tinytext NOT NULL,
  `release_date` tinytext NOT NULL,
  `summary` text NOT NULL,
  `forum` tinytext NOT NULL,
  `image` tinytext NOT NULL,
  `running_time` tinytext NOT NULL,
  `aspect_ratio` tinytext NOT NULL,
  `mpaa_rating` tinytext NOT NULL,
  `budget` float(6,2) NOT NULL default '0.00',
  `domestic_gross` float(6,2) NOT NULL default '0.00',
  `international_gross` float(6,2) NOT NULL default '0.00',
  `worldwide_gross` float(6,2) NOT NULL default '0.00',
  `views` smallint(6) NOT NULL default '0',
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `seo_url` tinytext NOT NULL,
  `rss_newsfeed` tinytext NOT NULL,	
  PRIMARY KEY  (`id`)
)";
mysql_query($create);

$create = "CREATE TABLE `ds_options` (
  `id` smallint(6) NOT NULL,
  `thumbnail` tinyint(4) NOT NULL,
  `currency` tinytext NOT NULL,
  `amazon` tinytext NOT NULL,
  `rating` tinytext NOT NULL,
  `movie_page` tinyint(4) NOT NULL,
  `article_page` tinyint(4) NOT NULL,
  `movie_summary` smallint(6) NOT NULL,
  `article_summary` smallint(6) NOT NULL,
  `rss_default` tinytext NOT NULL,
  `rss_count` tinyint(4) NOT NULL,
  `rss_advert_text` tinytext NOT NULL,
  `rss_advert_link` tinytext NOT NULL,
  `site_url` tinytext NOT NULL,
  `site_name` tinytext NOT NULL,
  `e_mail` tinytext NOT NULL,
  `search_number` tinyint(4) NOT NULL,
  `e_mail_subject` tinytext NOT NULL,
  `admin_note` mediumtext NOT NULL,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  PRIMARY KEY  (`id`)

)";
mysql_query($create);

$insert = "INSERT INTO `ds_options` VALUES (0, 100, '$', 'your-amazon-id', 'MPAA Rating', 10, 10, 100, 100, '', 10, '', '', 'http://yoursite.com', 'Your Site', 'you@yoursite.com', 10, 'Site Feedback', 'Your Admin Notes', 'admin', 'adpexzg3FUZAk', '', '', '')";
mysql_query($insert);
}
?>

<div style="background-color:#FFCC00; text-transform:uppercase; font-weight:bold; font-size:16px; padding:5px;">БД Установлена.</div><br />
<font color="#FF0000">Пожалуйста, удалите файл "install.php" в целях собственной безопасности</font>
<br /><br /><font color="#FFFFFF">
Сейчас Вы можете зайти в контрольную панель администратора<br /><br />
<strong>Логин:</strong> admin<br />
<strong>Пароль:</strong> admin<br /><br />

<a href="index.php" style="color:#FFFFFF; text-transform:uppercase; font-weight:bold;">Кликните, чтобы войти</a></font>

</div>

</center>
</body>
</html>
	