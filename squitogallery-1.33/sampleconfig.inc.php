<?php
$mainfilename = "";//this option has been depricated but I'm too lazy to remove it
$webimageroot = "/gallery";//this is the path as seen from your webserver
$photoroot = "/home/username/gallery/"; //this is the full path to the gallery files
$usedatabase = 1; //this option has been depricated but I'm too lazy to remove it
$db_host = "localhost"; //hostname for the mysql database
$db_user = ""; //username to access the database
$db_pass = ""; //password to access the database
$database = "gallery"; //database that you created to use with the gallery. see your system admin for 
                       // questions on this
$useimagemagick = "1";
$imagemagickpath = "/usr/local/bin/"; //path where imagemagick is located. c:\\imagemagick\\ on a windows
$thumbsize = "100"; //dimensions of the thumbnail files
$images = "images/"; //directory where your full images will reside
$thumbnails = "thumbnails/"; //directory where your thumbnail images will reside
$homeURL = "localhost"; //your websites address without the http://
$site_name = "Squito Gallery v1.33"; //title of the gallery
$os = "1"; //Operating system being used. 1 for windows based 2 for linux/unix

?>