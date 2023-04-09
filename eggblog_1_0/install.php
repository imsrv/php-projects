<?php
if (file_exists("_etc/config.inc.php")) {
  require_once("_etc/config.inc.php");
  if ($GET['confirm'] == '1') {
    $mysql = mysql_connect($eggblog_mysql_host,$eggblog_mysql_user,$eggblog_mysql_password);
    mysql_select_db($eggblog_mysql_db,$mysql);
    $sql_articles = "CREATE TABLE `eggblog_articles` (`id` int(5) NOT NULL auto_increment,`date` int(12) NOT NULL default '0',`category` varchar(50) NOT NULL default '',`title` varchar(100) NOT NULL default '',`intro` longtext NOT NULL,`details` longtext NOT NULL,`comments` enum('0','1') NOT NULL default '1',PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=70";
    $sql_comments = "CREATE TABLE `eggblog_comments` (`id` int(5) NOT NULL auto_increment,`date` int(12) NOT NULL default '0',`article_id` int(5) NOT NULL default '0',`author` varchar(250) NOT NULL default '',`comments` longtext NOT NULL,PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=224";
    $sql_forum_posts = "CREATE TABLE `eggblog_forum_posts` (`id` int(12) NOT NULL auto_increment,`topicid` int(5) NOT NULL default '0',`date` int(12) NOT NULL default '0',`author` varchar(250) NOT NULL default '',`text` mediumtext NOT NULL,PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=19";
    $sql_forum_topics = "CREATE TABLE `eggblog_forum_topics` (`id` int(5) NOT NULL auto_increment,`name` varchar(150) NOT NULL default '',`author` varchar(150) NOT NULL default '',`lastpost` int(12) NOT NULL default '',`lastpostid` int(12) NOT NULL default '',PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=5";
    $sql_members = "CREATE TABLE `eggblog_members` (`id` int(5) NOT NULL auto_increment,`username` varchar(20) NOT NULL default '',`password` varchar(20) NOT NULL default '',`email` varchar(150) NOT NULL default '',PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=21";
    $sql_photos = "CREATE TABLE `eggblog_photos` (`id` int(5) NOT NULL auto_increment,`album_id` int(5) NOT NULL default '0',`title` varchar(250) NOT NULL default '',`description` longtext NOT NULL,PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=131";
    $sql_photos_albums = "CREATE TABLE `eggblog_photos_albums` (`id` int(5) NOT NULL auto_increment,`title` varchar(250) NOT NULL default '',`description` longtext NOT NULL,PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=23";
    if (mysql_query($sql_articles)) {
      echo "<p><b>eggblog_articles</b> table set up successfully.</p>\n";
      if (mysql_query($sql_comments)) {
        echo "<p><b>eggblog_comments</b> table set up successfully.</p>\n";
        if (mysql_query($sql_forum_posts)) {
          echo "<p><b>eggblog_forum_posts</b> table set up successfully.</p>\n";
          if (mysql_query($sql_forum_topics)) {
            echo "<p><b>eggblog_forum_topics</b> table set up successfully.</p>\n";
            if (mysql_query($sql_members)) {
              echo "<p><b>eggblog_members</b> table set up successfully.</p>\n";
              if (mysql_query($sql_photos)) {
                echo "<p><b>eggblog_photos</b> table set up successfully.</p>\n";
                if (mysql_query($sql_photos_albums)) {
                  echo "<p><b>eggblog_photos_albums</b> table set up successfully.</p>\n";
                  echo "<p><b>eggblog $eggblog_release has been set up successfully.</b></p>\n<p>you must delete this <b>install.php</b> file before proceeding to use eggblog.</p>\n";
                  echo "<p>You will need to change ownership of the folders in the /photos/ folder to <code>chmod 777</code>.</p>\n";
                }
                  else {
                  echo "<p><b>There has been an error creating the table</b> eggblog_photos_albums:<br />\n".mysql_error()."</p>\n";
                }
              }
                else {
                echo "<p><b>There has been an error creating the table</b> eggblog_photos:<br />\n".mysql_error()."</p>\n";
              }
            }
              else {
              echo "<p><b>There has been an error creating the table</b> eggblog_members:<br />\n".mysql_error()."</p>\n";
            }
          }
           else {
            echo "<p><b>There has been an error creating the table</b> eggblog_forum_topics:<br />\n".mysql_error()."</p>\n";
          }
        }
        else {
          echo "<p><b>There has been an error creating the table</b> eggblog_forum_posts:<br />\n".mysql_error()."</p>\n";
        }
      }
      else {
        echo "<p><b>There has been an error creating the table</b> eggblog_comments:<br />\n".mysql_error()."</p>\n";
      }
    }
    else {
      echo "<p><b>There has been an error creating the table</b> eggblog_articles:<br />\n".mysql_error()."</p>\n";
    }
  }
  else {
    echo "<h1>eggblog $eggblog_release Installation</h1>\n";
    if (strlen($eggblog_title) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_title</b>.</p>\n"; }
    elseif (strlen($eggblog_subtitle) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_subtitle</b>.</p>\n"; }
    elseif (strlen($eggblog_domain) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_domain</b>.</p>\n"; }
    elseif (strlen($eggblog_url) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_url</b>.</p>\n"; }
    elseif (strlen($eggblog_absolutepath) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_absolutepath</b>.</p>\n"; }
    elseif (strlen($eggblog_email) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_email</b>.</p>\n"; }
    elseif (strlen($eggblog_css) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_css</b>.</p>\n"; }
    elseif (strlen($eggblog_absolutepath) <= 0) { echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> does not contain an entry for <b>&dollar;eggblog_absolutepath</b>.</p>\n"; }
    else {
      $mysql = mysql_connect($eggblog_mysql_host,$eggblog_mysql_user,$eggblog_mysql_password);
      if ($mysql == 0) {
        echo "<p><span class=error\">ERROR:</span><br />Could not connect to the mysql server at <b>$eggblog_mysql_host</b>.</p>\n";
      }
      else {
        mysql_select_db($eggblog_mysql_db,$mysql);
        echo "<p><b>eggblog is ready to install.</b></p>\n<p><a href=\"install.php?confirm=1\">Complete the installation ...</a></p>\n";
        mysql_close($mysql);
      }
    }
  }
}
else {
  echo "<p><span class=error\">ERROR:</span><br />The <b>config.inc.php</b> file could not be found.</p>\n";
}
?>