PHOTO FLASH GALLERY INSTALATION GUIDE
*********************************************


REQUIREMENTS
*********************************************
The server-side requirements are: PHP 4.1+ .
You will need GDLIB picture library installed on server. This is used to resize pictures with better quality and lower KB size.
The client-side requirements are: a web browser with the Flash 8 plug-in from Macromedia.
If you dont have it please download the most recent version of the Flash plug-in from http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash


INSTALLATION
*********************************************
Run install.php and follow the instructions.
Brief description of installer.
Step 1. 
	You have to set 777 rights to the files and folders listed below:
	Folders:
		tmp
		images
	Files:
		userconfig.xml 
		database.xml 
		thumberrors.xml 
		head.php 
		admin.php 

Step 2. 
	Enter the title of the gallery (will appear on the page title) and the absolute url where you copied the files.

Step 3. 
	Now you can start adding images to gallery. 
	You can do this in 2 ways: 
	1. Using the upload module from administration area located at http://www.yourdomain.com/admin/
	Default username is "administrator" 
	Default password is "12345" 
 
	2. Uploading image files to "images" folder using a ftp client application.
	Then generate the xml file structure using this link http://www.yourdomain.com/admin/generate.php 
	
	Warning 
	To avoid errors while uploading files from Flash create or find the .htaccess file in your root directory then type in:
	SecFilterEngine Off
	SecFilterScanPOST Off

	For security reasons please change your password from administration area. 
	
	PLEASE REMEMBER TO REMOVE THE INSTALLATION FILE: INSTALL.PHP 


ADMINISTRATION AREA LOGIN:
*********************************************
Your default login info for administration area is:
Username: administrator
Password: 12345


GETTING HELP
*********************************************
If you are having difficulty installing the module, or need a feature which is not available, please visit the support page available at http://www.photoflashgallery.com/support.php


LEGAL STUFF & LICENSE
*********************************************
The license for "PHOTO FLASH GALLERY" is very simple: ONE DOMAIN = ONE LICENSE.
This means that if you want to use "PHOTO FLASH GALLERY" on multiple websites, you must purchase additional licenses. 
It is illegal to resell or redistribute "PHOTO FLASH GALLERY" module in any manner.
Changing the "PHOTO FLASH GALLERY" code does not give you resale or redistribution rights, although you are welcome to change the code as needed, to suit your own particular needs.
The copyright is the exclusive ownership of PhotoFlashGallery.com, and is not transferable.
Please support this software by being honest! Further development can only take place with your cooperation.

*********************************************
Thanks for buying from PhotoFlashGallery.com
*********************************************