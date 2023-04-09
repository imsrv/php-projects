<?
include "header.php";

if (!$submit) {
	?>
	<center>
	Please do not forget to create MySQL Database at first...<BR>
	<form action="install.php" method="post">
	MySQL Host name: (usually localhost)<BR>
	<input type=text name=dbhost><BR>
	MySQL Database name:<BR>
	<input type=text name=dbname><BR>
	MySQL Username:<BR>
	<input type=text name=dbuser><BR>
	MySQL Password:<BR>
	<input type=text name=dbpass><BR>
	<input type=checkbox name=drop value=1><font size=1>Drop table if exists ?</font><BR>
	<input type=submit name=submit value="Install">
	</form>
	</center>
	<?
}

if ($submit == "Install") {

	$db=mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());

	if ($drop) mysql_db_query ($dbname,"DROP TABLE IF EXISTS top_cats",$db) or die (mysql_error());
	mysql_db_query ($dbname,"
	CREATE TABLE top_cats (
	  cid int(11) NOT NULL auto_increment,
	  catname varchar(255) default 'Main' Not Null,
	  PRIMARY KEY (cid),
	  UNIQUE catname (catname))",$db) or die (mysql_error());	

	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (1,'Animals')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (2,'Arts')"   ,$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (3,'Books')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (4,'Business')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (5,'Cars')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (6,'Celebrities')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (7,'Chat')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (8,'Clipart')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (9,'Collectibles')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (10,'Communities')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (11,'Computers')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (12,'Contests')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (13,'Cool sites')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (14,'Crafts')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (15,'Desktop Themes')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (16,'Dogs')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (17,'Education')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (18,'Entertainment')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (19,'Essays')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (20,'Finance')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (21,'Fonts')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (22,'Free Cash')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (23,'Free Mail')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (24,'Freestuff')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (25,'Freeware')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (26,'Genealogy')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (27,'Graphics')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (28,'GSM')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (29,'Greetingcards')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (30,'Health')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (31,'Hobbies')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (32,'Horoscopes')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (33,'Hotels')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (34,'Internet')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (35,'Jobs')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (36,'Jokes')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (37,'Lyrics')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (38,'Magazines')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (39,'Maps')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (40,'Marketing')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (41,'Midi')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (42,'Movies')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (43,'MP3')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (44,'Music')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (45,'News')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (46,'Newsletters')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (47,'Personal homepages')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (48,'Pets')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (49,'Pokemon')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (50,'Portals')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (51,'Radiostations')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (52,'Real estate')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (53,'Recipes')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (54,'Reference')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (55,'Religion')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (56,'Romantic')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (57,'Screensavers')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (58,'Search engines')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (59,'Shopping')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (60,'Software')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (61,'Sports')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (62,'Star Trek')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (63,'Star Wars')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (64,'Sweepstakes')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (65,'Telecom')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (66,'Top Websites')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (67,'Travel')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (68,'Videogames')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (69,'Wallpapers')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (70,'Web Promotion')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (71,'Webcams')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (72,'Webdesign')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (73,'Webdevelopment')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (74,'Webhosting')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (75,'Webmasters')",$db) or die (mysql_error());
	mysql_db_query ($dbname,"INSERT INTO top_cats (cid,catname) VALUES (76,'Women')",$db) or die (mysql_error());	

	if ($drop) mysql_db_query ($dbname,"DROP TABLE IF EXISTS top_hits",$db) or die (mysql_error());
	$query = mysql_db_query ($dbname,"
	CREATE TABLE top_hits (
	  sid int(11),
	  ip varchar(20),
	  cdate timestamp(8)
	)
	",$db) or die (mysql_error());	

	if ($drop) mysql_db_query ($dbname,"DROP TABLE IF EXISTS top_user",$db) or die (mysql_error());
	$query = mysql_db_query ($dbname,"
	CREATE TABLE top_user (
	  sid int(11) NOT NULL auto_increment,
	  banner varchar(255),
	  bannerw int(11),
	  bannerh int(11),
	  title varchar(255),
	  description varchar(255),
	  rank int(11) DEFAULT '0' NOT NULL,
	  votes int(11) DEFAULT '0' NOT NULL,
	  status enum('Y','N') DEFAULT 'N' NOT NULL,
	  name varchar(255),
	  email varchar(255),
	  password varchar(255),
	  url varchar(255),
	  linkback varchar(255),
	  hitin int(11) DEFAULT '0' NOT NULL,
	  hitout int(11) DEFAULT '0' NOT NULL,
	  category int(11),
	  stars enum('0','1','2','3','4','5') DEFAULT '0' NOT NULL,
	  country varchar(100),
	  PRIMARY KEY (sid)
	)
	",$db) or die (mysql_error());	

	if ($drop) mysql_db_query ($dbname,"DROP TABLE IF EXISTS top_review",$db) or die (mysql_error());
	$query = mysql_db_query ($dbname,"
	CREATE TABLE top_review (
	  rid int(11) NOT NULL auto_increment,
	  name varchar(20),
	  email varchar(40),
	  review text,
	  sid int DEFAULT 0 NOT NULL,
	  rating tinyint DEFAULT 0 NOT NULL,
	  postdate timestamp(8),
	  postip varchar(16),
	  PRIMARY KEY (rid)
	)
	",$db) or die (mysql_error());	

	echo "<center>";
	echo "MySQL Tables installation done...";
	echo "Please edit your config.php";
	echo "<center>";
}

include "footer.php";
?>
