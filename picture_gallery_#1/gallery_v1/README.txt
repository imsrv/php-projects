GALLERY INSTALATION GUIDE
**************************


REQUIREMENTS
The server-side requirements are: PHP 4.3+ .
You will need GDLIB picture library installed on server. This is used to resize pictures with better quality and lower KB size.
The client-side requirements are: a web browser with the Flash 7 plug-in from Macromedia.
If you dont have it please download the most recent version of the Flash plug-in from http://www.macromedia.com/software/flashplayer/


INSTALATION
1). Create a new folder on your website root called "galleryv1".
IF you want to use your own name of folder, or in diferent location please change in config.php file from admin folder this variable:
$site = "gallery_v1";
with the path to new folder you chose.

2). Copy all the files (except gallery.fla) to the new created folder.

3). Place this code into the page where you want to see the flash module:

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="675" height="412" id="gallery" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="galleryv1/gallery.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="galleryv1/gallery.swf" quality="high" bgcolor="#ffffff" width="675" height="412" name="gallery" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

4). Set read/write rights (777) on the folder called "images"
(You can do this from domain control panel / files manager or via ftp using this command in the folder galleryv1: chmod 777 images)

5). Set read/write rights (777) on all the images from the folder called "images"
(You can do this from domain control panel / files manager or via ftp using this command in the folder galleryv1: chmod 777 name of file)

6). Set read/write rights (777) on the folder called "files" from admin folder
(You can do this from domain control panel / files manager or via ftp using this command in the folder galleryv1/admin: chmod 777 files)

7). Set read/write rights (777) on all the files from the folder called "files" from admin folder
(You can do this from domain control panel / files manager or via ftp using this command in the folder galleryv1/admin: chmod 777 name of file)


ADMINISTRATION AREA LOGIN:
Your login info for administration area is:
Username: admin
Password: 1


GETTING HELP
If you are having difficulty installing the module, or need a feature which is not available, please visit the support page available at http://www.buyflashmodules.com/support.php


LEGAL STUFF & LICENSE
The license for "Galley v1" module is very simple: ONE DOMAIN = ONE LICENSE.
This means that if you want to use "Galley v1" module on multiple websites, you must purchase additional licenses. 
It is illegal to resell or redistribute "Galley v1" module in any manner.
Changing the "Galley v1" module code does not give you resale or redistribution rights, although you are welcome to change the code as needed, to suit your own particular needs.
The copyright is the exclusive ownership of BuyFlashModules.com, and is not transferable.
Please support this software by being honest! Further development can only take place with your cooperation.


Thanks for buying from BuyFlashModules.com "Galley v1" module!