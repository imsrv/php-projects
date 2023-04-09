<?php
# put the FULL path to the settings.php file here. For security reasons, the settings.php 
# file should not be accessable to a browser.
#
# replace only the text between the quotes with the path and file information.
# the rest of the line must remain as it is.
/*** SET VARIABLE HERE *****/ 
include("/homepages/htdocs/dbconfig/settings.php");


# if you don't have the possibility to put this file where a browser can't get to it,
# then leave it in the admin directory and password protect the admin directory. 
# you still must set the full path to the file, for example:
# include("/homepages/htdocs/calogic/admin/settings.php");

mysql_connect("$dbhost","$dbuser","$dbpass") OR DIE("Couldn`t connect to MySQL server in the DBLOADER!");
@mysql_select_db("$dbname") OR DIE("Couldn`t connect database in the DBLOADER!");

?>