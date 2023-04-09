//------------------------------------------------------//
// author: Vytautas Stanaitis basas@elst.vtu.lt         //
// date:   2004.01.04                                   //
// web:    http://basas.ablomas.com/simplegallery/      //
// info:   Simple Gallery from Basas v 1.1              //
//------------------------------------------------------//
================================================================================
Requirements:
  PHP / web server
  Image Magick and Package: gs Description: The Ghostscript Postscript interpreter
  GD Library version 1.x or later
================================================================================
Tested on:
 Apache/1.3.27 (Unix) Debian GNU/Linux PHP/4.2.3
 Apache/1.3.26 (Unix) Debian GNU/Linux PHP/4.1.2
 Apache/1.3.28 (Windows) PHP/4.3.3 with GD 2.0.15
 Apache/1.3.29 (Unix) Debian GNU/Linux PHP/4.3.3
================================================================================
Changes
v1.1
 *  fixed $footer and $header now you can make yuor own footer and header.
 * fixed some html bugs
 * www.w3c.org  HTML 4.01valid
================================================================================
Install:
 1. Create a directory for gallery, somewhere the web server can read the files and serve them as web pages.
 2. Change the permissions on the directory to be world writeable. On a unix machine you would use the chmod command with this syntax.
 chmod 777 <directory> This is done so that the script can generate the thumbnails.
 3. Edit configuration. 
 4. Upload script file
 5. Upload pictures in the same directory as sript file and change all pictures permisions to world writeable (666)- for converting.
 6. Go to url http://server/gallery_dir/index.php?setup first time it converting images so be patient
 7. Done.
================================================================================
