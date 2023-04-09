<?
$path_to_dir = "/youload/";
$license = "MST2007.php";

//You can set the vars below to your exact liking!

//Allow clips to be deleted from admin this is a must if you
//Have others loading data to the system as well and don't want
//clips to be deleteable by others set this to no ...
$allow_del = "no";

//Allow editing clip link in admin yes/no ...
//Should we allow YouTube clip URL to be edited? set to no if 
//you have more then one person using the admin to prevent this ...
$url_edit = "no";

//Disable YouTube relative videos feature yes/no
//This setting will disable a new YouTube feature where 
//multiple related videos are shown in the embeded player
//Default sys setting is yes meaning relative videos feature is disabled.
$rel_videos = "yes";

//This is our db file it contains all the data the script stores.
//You can rename this file if you like but it must match ...
$url_file = "you_links.txt";

//Set this to show a clip as popular when it hits 
//your desired count, Example 1000 default setting 
//will trigger the word Popular to be shown ...
$pop_view = "1000"; 

//Graphic to replace our screen this can even be your logo!
//See the ReadMe file for more details.
$img_default = "youloader.gif";

//Set the number of videos to display on each page of the admin section.
$records_per_page = "10";

//Admin alternating table row colors
$row_color1 = "#DFDFDF";
$row_color2 = "#BCBCBC";

?>