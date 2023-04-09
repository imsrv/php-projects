
README FILE 1.05

System At A Glance ...

The YouLoader system is an easy to use yet full featured YouTube video clip management system YouLoader was built with webmasters in mind however its so well thoght out that any one can use it even your client safely and easily...

The YouLoader admin lists each video by sort number, this means you can resort your vids at any time and have the vids you want where you want, plus your not limited you can even disable vids from public viewing, yet still have them available to you from our easy to use system admin, You can instantly see the status of each clip thus selecting the videos you want loaded is easy and organized. 

One neat feature we built in, is the ability to lock the URL fields from being changed and you can even prevent clip deletion just buy setting a few vars in the config file.


INSTALING
This set up process is quick and easy!

Step 1. open the you_config.php file in a text editor such as note pad.

Step 2. if you have a registration license key enter it where it says license.
If you are using it without a key then please note it will run fine however you will only see 3 clips 
that is the max amount the Free Version can load, also no clip view counts will be stored or regestered by the system, to use these cool features you must buy the system ...

Step 3. set the following vars

//Path to install directory on server 
//ie. if installed in http://www.mysite.com/youload/
//then you put "/youload/", blank if in root
$path_to_dir = "/youload/";

//Allow clips to be deleted from admin.$allow_del = "no";

//Allow editing clip link in admin yes/no ...
$url_edit = "no";

//Disable YouTube relative videos feature yes/no
//This setting will disable a new YouTube feature where 
//multiple related videos are shown in the embeded player
//Default sys setting is yes meaning relative videos feature is disabled.
$rel_videos = "yes";

//DB text file you can rename this file if you like but it must match ...
$url_file = "you_links.txt";

//Set to trigger the word popular to be shown at set amount ...
$pop_view = "1000"; 

//Set the number of videos to display on each page of the admin section.
$records_per_page = "10";

//Set our default screen on start or use your own splash screen.
//Graphic to replace our screen this can even be your logo!
//This is the screen shown when a visitor first visits your page ...
$img_default = "youloader.gif";

Step 4. Upload the complete youloader dir to your main web dir on some servers this
dir may need to be set to 777 UNIX CHMOD 777 permissions.

IMPORTANT: you will need to set the DB file you_links.php to 666 UNIX CHMOD 666 permissions if you do not the system may not work.

Step 5. Visit the YouTube website http://www.youtube.com get a few video embed codes and start adding the vids to the system.


Enjoy your YouLoader ...

Official YouLoader Site
http://www.youloader.com
 