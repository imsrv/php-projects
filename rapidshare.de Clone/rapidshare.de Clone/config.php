<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
////////////////////////////////////////////////////////

$compname = "Mini File Host";
////Your Company Name

$slogan = "FileUploading - The world's biggest 1-Click Webhoster";
//// Your Company Slogan

$scripturl = "http://www.fileuploading.info/";
//// the URL to this script with a trailing slash

$adminpass = "19760618";
//// set this password to something other than default
//// it will be used to access the admin panel

$topten = true;
//// Make It true if you want to enable Top ten files

$maxfilesize = 250;
//// the maximum file size allowed to be uploaded (in megabytes)

$downloadtimelimit = 60;
//// time users must wait before downloading another file (in minutes)

$uploadtimelimit = 30;
//// time users must wait before uploading another file (in minutes)

$nolimitsize = 0.5;
//// if a file is under this many megabytes, there is no time limit

$deleteafter = 30;
//// delete files if not downloaded after this many days

$downloadtimer = 40;
//// length of the timer on the download page (in seconds)

$enable_filelist = true;
//// allows users to see a list of uploaded files. set to false to disable

$shourturl = true;
//// Short url Eg yourdomain.com/13232 needs mod_rewrite enabled. For More Info See Our Froum

//$allowedtypes = array("txt","gif","jpg","jpeg");
//// remove the //'s from the above line to enable file extention blocking
//// only file extentions that are noted in the above array will be allowed

$emailoption = false;
//// set this to true to allow users to email themselves the download links

$passwordoption = false;
//// set this to true to allow users to password protect their uploads

$descriptionoption = false;
//// set this to true to disable the description field

//$categories = array("Documents","Applications","Audio","Misc");
//// remove the //'s from the above line to enable categories
//// Users will be able to choose from this list of categories

?>